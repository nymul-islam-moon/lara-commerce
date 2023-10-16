<?php

namespace App\Http\Controllers\Admin;

use Image;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreBlogCategoryRequest;
use App\Http\Requests\UpdateBlogCategoryRequest;
use App\Interface\ProductCategoryInterface;
use App\Interface\CodeGenerateInterface;
class BlogCategoryController extends Controller
{

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(ProductCategoryInterface $productCategoryService, CodeGenerateInterface $codeGenerateService)
    {
        $this->middleware('auth');

        $this->productCategoryService = $productCategoryService;
        $this->codeGenerateService = $codeGenerateService;
    }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
        $query = DB::table('blog_categories');

        if (!empty($request->f_soft_delete)) {
            if ($request->f_soft_delete == 1) {
                $query->where('deleted_at', '=', null);
            } else {
                $query->where('deleted_at', '!=', null);
            }
        }

        if (!empty($request->f_status)) {
            if ($request->f_status == 1){
                $query->where('status', 1);
            }else{
                $query->where('status', 0);
            }
        }

        $categories = $query->orderByDesc('id')->get();

        if ($request->ajax()) {
            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $html = '';

                    $html .='<div class="btn-group" role="group" aria-label="Button group with nested dropdown">';
                    $html .='<div class="btn-group" role="group">';
                    $html .='<button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">';
                    $html .='Action';
                    $html .='</button>';
                    $html .='<ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">';
                    if ($row->deleted_at == null) {
                        $html .='<li><a class="dropdown-item" href="'. route('blog.category.edit', $row->id) .'" id="edit_btn">Edit</a></li>';
                        $html .='<li><a class="dropdown-item" href="'. route('blog.category.destroy', $row->id) .'" id="delete_btn">Delete</a></li>';
                    } else {
                        $html .='<li><a class="dropdown-item" href="'. route('blog.category.restore', $row->id) .'" id="restore_btn">Restore</a></li>';
                        $html .='<li><a class="dropdown-item" href="'. route('blog.category.forcedelete', $row->id) .'" id="force_delete_btn">Hard Delete</a></li>';
                    }
                    $html .='</ul>';
                    $html .='</div>';
                    $html .='</div>';

                    return $html;
                })
                ->addColumn('checkbox', function ($row) {
                    $html = '';

                    $html .= '<input type="checkbox" class="checkbox_ids" name="ids" value="'. $row->id .'">';

                    return $html;

                })
                ->addColumn('created_by', function ($row) {

                    if (!empty($row->created_by_id))
                    {
                        $user = User::where('id', $row->created_by_id)->first();

                        return $user->first_name . ' ' . $user->last_name;
                    }else{
                        return 'N/A';
                    }
                })
                ->addColumn('updated_by', function ($row) {

                    if (!empty($row->updated_by_id))
                    {
                        $user = User::where('id', $row->updated_by_id)->first();
                        return $user->first_name . ' ' . $user->last_name;
                    }else{
                        return 'N/A';
                    }
                })
                ->editColumn( 'image', function ( $row ) {

                    $html = '';
                    $html .='<a href="javascript: void(0);" class="avatar-group-item" data-img="avatar-3.jpg" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top" aria-label="Username" data-bs-original-title="Username">';
                    $html .='<img src="'. asset('uploads/blog/category/' . $row->image) . '" alt="" class="rounded-circle avatar-xxs"></a>';
                    $html .='</a>';

                    return $html;

                } )
                ->editColumn('status', function ($row) {
                    $html = '';
                    if ($row->status == 1) {

                        $html .='<div class="form-check form-switch">';
                        $html .='<input class="form-check-input" href="'. route('blog.category.deactive', $row->id) .'" type="checkbox" role="switch" id="deactive_btn" checked="">&nbsp;';
                        $html .='<label class="form-check-label" for="SwitchCheck4"> Active</label>';
                        $html .='</div>';

                    } else {
                        $html .='<div class="form-check form-switch">';
                        $html .='<input class="form-check-input" type="checkbox" href="'. route('blog.category.active', $row->id) .'" role="switch" id="active_btn">&nbsp;';
                        $html .='<label class="form-check-label" for="SwitchCheck4"> De-active</label>';
                        $html .='</div>';
                    }
                    return $html;
                })
                ->rawColumns(['action', 'status', 'checkbox', 'image'])
                ->make(true);
        }


        // $total_category =

        return view('admin.category.index', compact('categories'));
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       return view('admin.category.create');
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \App\Http\Requests\StoreProductCategoryRequest $request
    * @return \Illuminate\Http\Response
    */
   public function store(StoreBlogCategoryRequest $request)
   {

        $formData = $request->validated();


        $formData['created_by_id'] = \auth::user()->id;


        if ($formData['status'] == 1) {
            $formData['status'] = true;
        }else {
            $formData['status'] = false;
        }

        if( $request->hasFile('image') ) {
            $image = Image::make($request->file('image'));

            $imageName = time().'-'.$request->file('image')->getClientOriginalName();

            // dd($imageName);

            $destinationPath = public_path('uploads/blog/category/');

            $image->save($destinationPath.$imageName);

            $formData['image'] = $imageName;
        }
        // dd($formData);

        $blogCategory = BlogCategory::create($formData);

        // try {
        //     $categories  = $this->productCategoryService->store($formData);
        // } catch (\Exception $e) {
        //     return response()->json('Error');
        // }

        return response()->json('Blog Category Created Successfully');

   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\ProductCategory $productCategory
    * @return \Illuminate\Http\Response
    */
   public function show(BlogCategory $productCategory)
   {
       //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\ProductCategory  $productCategory
    * @return \Illuminate\Http\Response
    */
   public function edit(BlogCategory $blogCategory)
   {
        return view('admin.category.edit', compact('blogCategory'));
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \App\Http\Requests\UpdateBlogCategoryRequest  $request
    * @param  \App\Models\BlogCategory $blogCategory
    * @return \Illuminate\Http\Response
    */
   public function update(UpdateBlogCategoryRequest $request, BlogCategory $blogCategory)
   {
        // try {
        //         $formData = $request->validated();
        //         $categories  = $this->productCategoryService->update($productCategory, $formData);
        //     } catch (\Exception $e) {
        //         return response()->json('Error');
        //     }

        $formData = $request->validated();


        $formData['updated_by_id'] = \auth::user()->id;


        if ($formData['status'] == 1) {
            $formData['status'] = true;
        }else {
            $formData['status'] = false;
        }

        if( $request->hasFile('image') ) {

            try {
                unlink(public_path( 'uploads/blog/category/' . $blogCategory['image'] ));
            } catch (\Throwable $th) {

            }

            $image = Image::make($request->file('image'));

            $imageName = time().'-'.$request->file('image')->getClientOriginalName();

            $destinationPath = public_path('uploads/blog/category/');

            $image->save($destinationPath.$imageName);

            $formData['image'] = $imageName;
        }


        return response()->json('Blog Category Updated Successfully');
    }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\BlogCategory $blogCategory
    * @return \Illuminate\Http\Response
    */
   public function destroy(BlogCategory $blogCategory)
   {
        $blogCategory->status = 0;
        $blogCategory->save();
        $blogCategory->delete();

        return response()->json('Product Category Deleted Successfully');
   }


   /**
     * Active the specified resource from storage.
     *
     * @param  \App\Models\BlogCategory $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function active(BlogCategory $blogCategory)
    {
        $blogCategory->status = 1;
        $blogCategory->save();
        return response()->json('Blog Category Activated Successfully');
    }


    /**
     * De-active the specified resource from storage.
     *
     * @param  \App\Models\BlogCategory $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function deactive(BlogCategory $blogCategory)
    {
        $blogCategory->status = 0;
        $blogCategory->save();
        return response()->json('Blog Category De-activated Successfully');
    }

    /**
     * Restore the soft deleted data.
     *
     * @param  \App\Models\BlogCategory $blogCategory
     * @return \Illuminate\Http\Response
     */

    public function restore($blogCategory)
    {
        BlogCategory::where('id', $blogCategory)->withTrashed()->restore();

        return response()->json('Blog Category Restored Successfully');
    }



    /**
     * Force Delete the soft deleted data.
    *
    * @param  \App\Models\BlogCategory $blogCategory
    * @return \Illuminate\Http\Response
    */

    public function forceDelete($blogCategory)
    {
        BlogCategory::where('id', $blogCategory)->withTrashed()->forceDelete();

        return response()->json('Blog Category Permanently Deleted Successfully');
    }


    /**
     * Force Delete the soft deleted data.
    *
    * @param  \App\Models\BlogCategory $blogCategory
    * @return \Illuminate\Http\Response
    */

    public function destroyAll(Request $request)
    {

        $ids = $request->ids;

        $idArr = (array) $ids;

        foreach ($idArr as $key=> $id) {
            $blogCategory = BlogCategory::where('id', $id)->first();
            $blogCategory->status = 0;
            $blogCategory->save();
            $blogCategory->delete();
        }
        return response()->json('Blog Category Deleted Successfully');
    }


    /**
     * Restore all the soft deleted data
    *
    * @param  \App\Models\BlogCategory $blogCategory
    * @return \Illuminate\Http\Response
    */

    public function restoreAll(Request $request)
    {

        $ids = $request->ids;

        $idArr = (array) $ids;

        foreach ($idArr as $key=> $id) {
            $blogCategory = BlogCategory::where('id', $id)->withTrashed()->restore();
        }

        return response()->json('Blog Category Restored Successfully');

    }


    /**
     * Permanently Delete all the soft deleted data
    *
    * @param  \App\Models\BlogCategory $blogCategory
    * @return \Illuminate\Http\Response
    */

    public function permanentDestroyAll(Request $request)
    {

        $ids = $request->ids;

        $idArr = (array) $ids;

        foreach ($idArr as $key=> $id) {
            $blogCategory = BlogCategory::where('id', $id)->withTrashed()->forceDelete();
        }

        return response()->json('Blog Category Permanently Deleted Successfully');

    }


    /**
     * Get all the data
    *
    * @param  \App\Models\BlogCategory $blogCategory
    * @return \Illuminate\Http\Response
    */

    public function getAllData(Request $request)
    {
        $allBlogCategory = BlogCategory::count();
        // $activeCategories = ProductCategory::where('satus', '=', 1)->count();
        $data = [
            'allCategory' => $allBlogCategory,
            'allTrashCategory' => 3,
            'activeCategories' => 2,
        ];

        return $data;
    }

}
