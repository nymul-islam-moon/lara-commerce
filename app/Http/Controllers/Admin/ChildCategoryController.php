<?php

namespace App\Http\Controllers\Admin;



use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ChildCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreChildCategoryRequest;
use App\Http\Requests\UpdateChildCategoryRequest;

class ChildCategoryController extends Controller
{


    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subCategories = SubCategory::where('status', 1)->latest()->get();

        $query = DB::table('child_categories');

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

        $childCategories = $query->get();

        if ($request->ajax()) {
            return DataTables::of($childCategories)
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
                        $html .='<li><a class="dropdown-item" href="'. route('product.childCategory.edit', $row->id) .'" id="edit_btn">Edit</a></li>';
                        $html .='<li><a class="dropdown-item" href="'. route('product.childCategory.destroy', $row->id) .'" id="delete_btn">Delete</a></li>';
                    } else {
                        $html .='<li><a class="dropdown-item" href="'. route('product.childCategory.restore', $row->id) .'" id="restore_btn">Restore</a></li>';
                        $html .='<li><a class="dropdown-item" href="'. route('product.childCategory.forcedelete', $row->id) .'" id="force_delete_btn">Hard Delete</a></li>';
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
                ->editColumn('product_subcategory_id', function ($row) {

                    try {
                        $subCategory = SubCategory::where('id', $row->product_subcategory_id)->first();
                        return childCategory->name;
                    } catch (\Throwable $th) {
                        return 'N/A';
                    }

                })
                ->editColumn('status', function ($row) {
                    $html = '';
                    if ($row->status == 1) {

                        $html .='<div class="form-check form-switch">';
                        $html .='<input class="form-check-input" href="'. route('product.childCategory.deactive', $row->id) .'" type="checkbox" role="switch" id="deactive_btn" checked="">&nbsp;';
                        $html .='<label class="form-check-label" for="SwitchCheck4"> Active</label>';
                        $html .='</div>';

                    } else {
                        $html .='<div class="form-check form-switch">';
                        $html .='<input class="form-check-input" type="checkbox" href="'. route('product.childCategory.active', $row->id) .'" role="switch" id="active_btn">&nbsp;';
                        $html .='<label class="form-check-label" for="SwitchCheck4"> De-active</label>';
                        $html .='</div>';
                    }
                    return $html;
                })
                ->rawColumns(['action', 'status', 'checkbox'])
                ->make(true);
        }



        return view('admin.child_category.index', compact('subCategories'));
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
     * @param  \App\Http\Requests\StoreChildCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChildCategoryRequest $request)
    {
        $formData = $request->validated();

        $formData['slug'] = Str::slug($formData['name'], '-');

        $formData['created_by_id'] = \auth::user()->id;

        $childCategory  = ChildCategory::create($formData);

        return response()->json('Product Child Category Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChildCategory  $childCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ChildCategory $childCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChildCategory  $childCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ChildCategory $childCategory)
    {
        $subCategories = SubCategory::all();
        return view('admin.child_category.edit', compact('childCategory', 'subCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChildCategoryRequest  $request
     * @param  \App\Models\ChildCategory  $childCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChildCategoryRequest $request, ChildCategory $childCategory)
    {
        $formData = $request->validated();

        $formData['updated_by_id'] = auth()->user()->id;

        $formData['slug'] = Str::slug($formData['name'], '-');

        $childCategory->update($formData);

        return response()->json('Product Child Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChildCategory  $childCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChildCategory $childCategory)
    {
        $childCategory->status = 0;
        $childCategory->save();
        $childCategory->delete();

        return response()->json('Product Child Category Deleted Successfully');
    }


    /**
     * Active the specified resource from storage.
     *
     * @param  \App\Models\ChildCategory  $childCategory
     * @return \Illuminate\Http\Response
     */
    public function active(ChildCategory $childCategory)
    {
        $childCategory->status = 1;
        $childCategory->save();
        return response()->json('Product Child Category Activated Successfully');
    }


    /**
     * De-active the specified resource from storage.
     *
     * @param  \App\Models\ChildCategory  $childCategory
     * @return \Illuminate\Http\Response
     */
    public function deactive(ChildCategory $childCategory)
    {
        $childCategory->status = 0;
        $childCategory->save();
        return response()->json('Product Child Category De-activated Successfully');
    }

    /**
     * Restore the soft deleted data.
     *
     * @param  \App\Models\ChildCategory  $childCategory
     * @return \Illuminate\Http\Response
     */

    public function restore($childCategory)
    {

        ChildCategory::where('id', $childCategory)->withTrashed()->restore();

        return response()->json('Product Child Category Restored Successfully');
    }



    /**
     * Force Delete the soft deleted data.
    *
    * @param  \App\Models\ChildCategory  $childCategory
    * @return \Illuminate\Http\Response
    */

    public function forceDelete($childCategory)
    {
        ChildCategory::where('id', $childCategory)->withTrashed()->forceDelete();

        return response()->json('Product Child Category Permanently Deleted Successfully');
    }


    /**
     * Force Delete the soft deleted data.
    *
    * @param  \App\Models\ChildCategory  $childCategory
    * @return \Illuminate\Http\Response
    */

    public function destroyAll(Request $request)
    {

        $ids = $request->ids;

        $idArr = (array) $ids;

        foreach ($idArr as $key=> $id) {
            $childCategory = ChildCategory::where('id', $id)->first();
            $childCategory->status = false;
            $childCategory->save();
            $childCategory->delete();
        }
        return response()->json('Product Child Category Deleted Successfully');
    }


    /**
     * Restore all the soft deleted data
    *
    * @param  \App\Models\ChildCategory  $childCategory
    * @return \Illuminate\Http\Response
    */

    public function restoreAll(Request $request)
    {

        $ids = $request->ids;

        $idArr = (array) $ids;

        foreach ($idArr as $key=> $id) {
            $childCategory = ChildCategory::where('id', $id)->withTrashed()->restore();
        }

        return response()->json('Product Child Category Restored Successfully');

    }


    /**
     * Permanently Delete all the soft deleted data
    *
    * @param  \App\Models\ChildCategory  $childCategory
    * @return \Illuminate\Http\Response
    */

    public function permanentDestroyAll(Request $request)
    {

        $ids = $request->ids;

        $idArr = (array) $ids;

        foreach ($idArr as $key=> $id) {
            $childCategory = ChildCategory::where('id', $id)->withTrashed()->forceDelete();
        }

        return response()->json('Product Child Category Permanently Deleted Successfully');

    }

}
