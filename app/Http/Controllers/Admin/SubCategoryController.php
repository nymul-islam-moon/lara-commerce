<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Interface\CodeGenerateInterface;
use App\Interface\ProductSubCategoryInterface;

class SubCategoryController extends Controller
{

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(CodeGenerateInterface $codeGenerateService, ProductSubCategoryInterface $productSubCategoryService)
    {
        $this->middleware('auth');
        $this->codeGenerateService = $codeGenerateService;
        $this->productSubCategoryService = $productSubCategoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $productCategories = ProductCategory::all();

        $query = DB::table('product_sub_categories');

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

        $subCategories = $query->get();

        if ($request->ajax()) {
            return DataTables::of($subCategories)
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
                        $html .='<li><a class="dropdown-item" href="'. route('product.subCategory.edit', $row->id) .'" id="edit_btn">Edit</a></li>';
                        $html .='<li><a class="dropdown-item" href="'. route('product.subCategory.destroy', $row->id) .'" id="delete_btn">Delete</a></li>';
                    } else {
                        $html .='<li><a class="dropdown-item" href="'. route('product.subCategory.restore', $row->id) .'" id="restore_btn">Restore</a></li>';
                        $html .='<li><a class="dropdown-item" href="'. route('product.subCategory.forcedelete', $row->id) .'" id="force_delete_btn">Hard Delete</a></li>';
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
                ->editColumn('product_category_id', function ($row) {

                    try {
                        $category = ProductCategory::where('id', $row->product_category_id)->first();
                        return $category->name;
                    } catch (\Throwable $th) {
                        return 'N/A';
                    }

                })
                ->editColumn('status', function ($row) {
                    $html = '';
                    if ($row->status == 1) {

                        $html .='<div class="form-check form-switch">';
                        $html .='<input class="form-check-input" href="'. route('product.subCategory.deactive', $row->id) .'" type="checkbox" role="switch" id="deactive_btn" checked="">&nbsp;';
                        $html .='<label class="form-check-label" for="SwitchCheck4"> Active</label>';
                        $html .='</div>';

                    } else {
                        $html .='<div class="form-check form-switch">';
                        $html .='<input class="form-check-input" type="checkbox" href="'. route('product.subCategory.active', $row->id) .'" role="switch" id="active_btn">&nbsp;';
                        $html .='<label class="form-check-label" for="SwitchCheck4"> De-active</label>';
                        $html .='</div>';
                    }
                    return $html;
                })
                ->rawColumns(['action', 'status', 'checkbox'])
                ->make(true);
        }



        return view('admin.sub_category.index', compact('productCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubCategoryRequest $request)
    {
        $formData = $request->validated();

        $formData['slug'] = Str::slug($formData['name'], '-');

        $formData['created_by_id'] = \auth::user()->id;

        $subCategories  = SubCategory::create($formData);

        return response()->json('Product Sub-Category Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subCategory)
    {
        $productCategories = ProductCategory::all();
        return view('admin.sub_category.edit', compact('subCategory', 'productCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubCategoryRequest $request, SubCategory $subCategory)
    {
        $formData = $request->validated();

        $formData['updated_by_id'] = auth()->user()->id;

        $formData['slug'] = Str::slug($formData['name'], '-');

        $subCategory->update($formData);

        return response()->json('Product Sub-Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        $subCategory->status = 0;
        $subCategory->save();
        $subCategory->delete();

        return response()->json('Product Sub-Category Deleted Successfully');
    }


    /**
     * Active the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function active(SubCategory $subCategory)
    {
        $subCategory->status = 1;
        $subCategory->save();
        return response()->json('Product Sub-Category Activated Successfully');
    }


    /**
     * De-active the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function deactive(SubCategory $subCategory)
    {
        $subCategory->status = 0;
        $subCategory->save();
        return response()->json('Product Sub-Category De-activated Successfully');
    }

    /**
     * Restore the soft deleted data.
     *
     * @param  \App\Models\SubCategory $SubCategory
     * @return \Illuminate\Http\Response
     */

    public function restore($subCategory)
    {

        SubCategory::where('id', $subCategory)->withTrashed()->restore();

        return response()->json('Product Sub-Category Restored Successfully');
    }



    /**
     * Force Delete the soft deleted data.
    *
    * @param  \App\Models\SubCategory $SubCategory
    * @return \Illuminate\Http\Response
    */

    public function forceDelete($SubCategory)
    {
        SubCategory::where('id', $SubCategory)->withTrashed()->forceDelete();

        return response()->json('Product Sub-Category Permanently Deleted Successfully');
    }


    /**
     * Force Delete the soft deleted data.
    *
    * @param  \App\Models\SubCategory $SubCategory
    * @return \Illuminate\Http\Response
    */

    public function destroyAll(Request $request)
    {

        $ids = $request->ids;

        $idArr = (array) $ids;

        foreach ($idArr as $key=> $id) {
            $SubCategory = SubCategory::where('id', $id)->first();
            $SubCategory->status = false;
            $SubCategory->save();
            $SubCategory->delete();
        }
        return response()->json('Product Sub-Category Deleted Successfully');
    }


    /**
     * Restore all the soft deleted data
    *
    * @param  \App\Models\SubCategory $SubCategory
    * @return \Illuminate\Http\Response
    */

    public function restoreAll(Request $request)
    {

        $ids = $request->ids;

        $idArr = (array) $ids;

        foreach ($idArr as $key=> $id) {
            $SubCategory = SubCategory::where('id', $id)->withTrashed()->restore();
        }

        return response()->json('Product Sub-Category Restored Successfully');

    }


    /**
     * Permanently Delete all the soft deleted data
    *
    * @param  \App\Models\SubCategory $SubCategory
    * @return \Illuminate\Http\Response
    */

    public function permanentDestroyAll(Request $request)
    {

        $ids = $request->ids;

        $idArr = (array) $ids;

        foreach ($idArr as $key=> $id) {
            $SubCategory = SubCategory::where('id', $id)->withTrashed()->forceDelete();
        }

        return response()->json('Product Sub-Category Permanently Deleted Successfully');

    }


    /**
     * Get all the data
    *
    * @param  \App\Models\SubCategory $SubCategory
    * @return \Illuminate\Http\Response
    */

    public function getAllData(Request $request)
    {
        $allCategory = SubCategory::count();
        // $activeCategories = SubCategory::where('satus', '=', 1)->count();
        $data = [
            'allCategory' => $allCategory,
            'allTrashCategory' => 3,
            'activeCategories' => 2,
        ];

        return $data;
    }

}
