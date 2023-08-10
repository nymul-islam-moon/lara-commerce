@extends('layouts.admin')


@push('script')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">

@endpush


@section('admin_content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Tasks List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tasks</a></li>
                                <li class="breadcrumb-item active">Tasks List</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">

                        {{-- <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Service Tables</h4>
                            <button type="button" class="btn btn-primary bg-gradient waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal">Add Service</button>
                            <div class="flex-shrink-0">
                                <div class="form-check form-switch form-switch-right form-switch-md">

                                </div>
                            </div>
                        </div> --}}


                        <div class="card-header border-0">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title mb-0 flex-grow-1">All Tasks</h5>
                                <div class="flex-shrink-0">
                                   <div class="d-flex flex-wrap gap-2">
                                        <button class="btn btn-danger add-btn" data-bs-toggle="modal" data-bs-target="#addSubCategoryModal"><i class="ri-add-line align-bottom me-1"></i> Create Task</button>
                                        <button class="btn btn-soft-danger" id="temp_delete_all"><i class="ri-delete-bin-2-line"></i></button>
                                        <button class="btn btn-soft-danger d-none" id="permanent_delete_all"><i class="ri-delete-bin-2-line"></i></button>
                                        <button class="btn btn-soft-danger d-none" id="restore_all_selected"><i class="ri-refresh-line"></i></button>
                                   </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body border border-dashed border-end-0 border-start-0">

                            <div class="row g-3">

                                <div class="col-xxl-2 col-sm-4">
                                    <div class="input-light">
                                        <select class="form-control submitable" name="f_soft_delete" id="f_soft_delete">
                                            <option selected value="1">All</option>
                                            <option value="2">Trash Categories</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xxl-2 col-sm-12">
                                    <div class="search-box">
                                        <input type="text" class="form-control search bg-light border-light" placeholder="Search for tasks or something...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>


                                <div class="col-xxl-2 col-sm-4">
                                    <input type="text" class="form-control bg-light border-light" id="demo-datepicker" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" placeholder="Select date range">
                                </div>


                                <div class="col-xxl-2 col-sm-4">
                                    <div class="input-light">
                                        <select class="form-control submitable" name="f_status" id="f_status">
                                            <option value="" Selected>All</option>
                                            <option value="1">Active</option>
                                            <option value="2">De-Active</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xxl-1 col-sm-4">
                                    <button type="button" class="btn btn-primary w-100"> <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                        Filters
                                    </button>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">
                            <div class="live-preview">
                                <div class="table-responsive table-card">
                                    <table class="table align-middle table-nowrap mb-0 data_tbl sub_category_table">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="width: 46px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="select_all_ids">
                                                    </div>
                                                </th>
                                                <th scope="col">ID</th>
                                                <th scope="col">Action</th>
                                                <th scope="col">Code</th>
                                                <th scope="col">Category Name</th>
                                                <th scope="col">SubCategory Name</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Sub-Category Slug</th>
                                                <th scope="col">Created By</th>
                                                <th scope="col">Updated By</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="modal fade zoomIn" id="addSubCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content border-0">
                        <div class="modal-header p-3 bg-soft-info">
                            <h5 class="modal-title" id="exampleModalLabel">Add Sub-Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" autocomplete="off" id="add_subCategory_form" action="{{ route('product.subCategory.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-lg-6">
                                        <label for="subCategory_name" class="form-label">Sub-category Name</label>
                                        <input type="text" id="subCategory_name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Subcategory name">
                                        <span class="error error_name text-danger"></span>
                                    </div>

                                    <div class="col-lg-6">
                                        <label for="category" class="form-label">Category Name</label>
                                        <select class="form-control" name="product_category_id" id="category">
                                            <option selected>Select Product Category</option>
                                            @foreach ($productCategories as $productCategory)
                                                <option value="{{ $productCategory->id }}" {{ old('product_category_id') == $productCategory->id ? 'selected' : '' }} >{{ $productCategory->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="error error_product_category_id text-danger"></span>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <label for="category_status" class="form-label">Status</label>
                                        <select class="form-control" name="status" id="category_status">
                                            <option selected>Status</option>
                                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }} >Active</option>
                                            <option value="2" {{ old('status') == 2 ? 'selected' : '' }} >De-Active</option>
                                        </select>
                                        <span class="error error_status text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="display: block;">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-light" id="close-modal" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success submit_button">Add Sub-Category</button>
                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update Task</button> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade zoomIn" id="editSubCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg" id="edit-content">

                </div>
            </div>

        </div>
    </div>
</div>

<form id="deleted_form" action="" method="post">
    @method('DELETE')
    @csrf
</form>

<form id="restore_form" action="" method="post">
    @method('POST')
    @csrf
</form>


@endsection

@push('js')

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {


        /**
         * Yajra DataTable for show all data
         *
         * */
        var sub__category__table = $('.sub_category_table').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false
                }
            ],
            "lengthMenu": [
                [5, 10, 25, 50, 100, 500, 1000, -1],
                [5, 10, 25, 50, 100, 500, 1000, "All"],
            ],
            ajax: {
                url: "{{ route('product.subCategory.index') }}",
                data: function(e) {
                    // e.center_id = $('#center_id').val();
                    e.f_status = $('#f_status').val();
                    e.f_soft_delete = $('#f_soft_delete').val();
                }
            },
            columns: [
                {data: 'checkbox', name: 'checkbox'},
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'action', name: 'action'},
                {data: 'code', name: 'code'},
                {data: 'product_category_id', name: 'product_category_id'},
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status'},
                {data: 'slug', name: 'slug'},
                {data: 'created_by', name: 'created_by', visible: false},
                {data: 'updated_by', name: 'updated_by'},
            ]
        });


        /**
         * Add Product Category
         * @author Nymul Islam Moon < towkir1997islam@gmail.com >
         * */
        $(document).on('submit', '#add_subCategory_form', function(e) {
            e.preventDefault();
            // $('.loading_button').show();
            var url = $(this).attr('action');
            $('.submit_button').prop('type', 'button');

            $.ajax({
                url: url,
                type: 'post',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#add_subCategory_form')[0].reset();

                    $('#addSubCategoryModal').modal('hide');

                    $('.submit_button').prop('type', 'submit');

                    $('.sub_category_table').DataTable().ajax.reload();

                    toastr.success(data)

                },
                error: function(err) {
                    let error = err.responseJSON;

                    $.each(error.errors, function (key, error){

                        $('.submit_button').prop('type', 'submit');
                        $('.error_' + key + '').html(error[0]);
                    });
                }
            });
        });


        /**
         * Delete Form Open
         * */

        $(document).on('click', '#delete_btn', function(e) {
            e.preventDefault();

            var url = $(this).attr('href');

            $('#deleted_form').attr('action', url);

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleted_form').submit();
                }
            })
        })


        /**
         * Delete Form Submit
         * */
        $(document).on('submit', '#deleted_form', function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            var request = $(this).serialize();
            $.ajax({
                url: url,
                type: 'delete',
                success: function(data) {
                    toastr.error(data)
                    sub__category__table.ajax.reload();
                },
                error: function(err) {
                    toastr.error(err.responseJSON)
                    sub__category__table.ajax.reload();
                }
            });
        });


        /**
         * Filter js for reload the table on change
         * */

        $('.submitable').on('change', function(e) {
            sub__category__table.ajax.reload();
        });


        /**
        * Filter Change detect for delete and restore button show
        * */

        $('#f_soft_delete').on('change', function(e) {
            $("#restore_all_selected").toggleClass("d-none");
            $("#temp_delete_all").toggleClass("d-none");
            $("#permanent_delete_all").toggleClass("d-none");
        });


        /**
         * Active Product Category
         * author : Nymul Islam Moon <towkir1997islam@gmail.com>
         * Active Status
         * */

        $(document).on('click', '#active_btn', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'post',
                success: function(data) {
                    toastr.success(data)
                    sub__category__table.ajax.reload();
                },
                error: function(err) {
                    toastr.error(err.responseJSON)
                    sub__category__table.ajax.reload();
                }
            });
        });

        /**
         * De-active Product Category
         * author : Nymul Islam Moon <towkir1997islam@gmail.com>
         * De-active Status
         * */

         $(document).on('click', '#deactive_btn', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.ajax({
                url: url,
                type: 'post',
                success: function(data) {
                    toastr.error(data)
                    sub__category__table.ajax.reload();
                },
                error: function(err) {
                    toastr.error(err.responseJSON)
                    sub__category__table.ajax.reload();
                }
            });
        });


        /**
         * Restore Deleted Category
         * */

        $(document).on('click', '#restore_btn', function(e) {
            e.preventDefault();

            var url = $(this).attr('href');

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to restore the data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'post',
                        success: function(data) {
                            toastr.error(data)
                            sub__category__table.ajax.reload();
                        },
                        error: function(err) {
                            toastr.error(err.responseJSON)
                            sub__category__table.ajax.reload();
                        }
                    });
                }
            })
        })


         /**
         * Force Deleted Category
         * */

        $(document).on('click', '#force_delete_btn', function(e) {
            e.preventDefault();

            var url = $(this).attr('href');

            $('#deleted_form').attr('action', url);

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleted_form').submit();
                }
            })
        })


        /**
         * Select All checkbox on clicking
         * */

        $(document).on('click', '#select_all_ids', function() {
            $('.checkbox_ids').prop('checked',$(this).prop('checked'));
        });


        /**
         * Soft Delete all selected items
         * */
        $(document).on('click', '#temp_delete_all', function(e) {
            e.preventDefault();
            var all_ids = [];
            $('input:checkbox[name=ids]:checked').each( function() {
                all_ids.push($(this).val());
            });

            if (all_ids.length === 0) {
                Swal.fire(
                    'Please, select any category!',
                    '',
                    'warning'
                );
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete all selected data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete All!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('product.subCategory.destroyAll') }}",
                        type: 'DELETE',
                        data: {
                            ids:all_ids,
                            _token:'{{ csrf_token() }}',
                        },

                        success: function(data) {
                            toastr.error(data);
                            sub__category__table.ajax.reload();
                            $("#select_all_ids").prop("checked", false);
                        },
                        error: function(err) {
                            toastr.error(err.responseJSON)
                            sub__category__table.ajax.reload();
                        }
                    });
                }
            })
        });


        /**
         * Restore all selected items
         * */
        $(document).on('click', '#restore_all_selected', function(e) {
            e.preventDefault();
            var all_ids = [];
            $('input:checkbox[name=ids]:checked').each( function() {
                all_ids.push($(this).val());
            });


            Swal.fire({
                title: 'Are you sure?',
                text: "You want to restore all selected data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Restore All!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('product.subCategory.restoreAll') }}",
                        type: 'DELETE',
                        data: {
                            ids:all_ids,
                            _token:'{{ csrf_token() }}',
                        },

                        success: function(data) {
                            toastr.success(data);
                            sub__category__table.ajax.reload();
                            $("#select_all_ids").prop("checked", false);
                        },
                        error: function(err) {
                            toastr.error(err.responseJSON)
                            sub__category__table.ajax.reload();
                        }
                    });
                }
            })
        });


        /**
         * Permanent Delete all selected items
         * */
        $(document).on('click', '#permanent_delete_all', function(e) {
            e.preventDefault();
            var all_ids = [];
            $('input:checkbox[name=ids]:checked').each( function() {
                all_ids.push($(this).val());
            });


            Swal.fire({
                title: 'Are you sure?',
                text: "You want to permanently delete all selected data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete All!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('product.subCategory.permanentDestroyAll') }}",
                        type: 'DELETE',
                        data: {
                            ids:all_ids,
                            _token:'{{ csrf_token() }}',
                        },

                        success: function(data) {
                            toastr.error(data);
                            sub__category__table.ajax.reload();
                            $("#select_all_ids").prop("checked", false);
                        },
                        error: function(err) {
                            toastr.error(err.responseJSON)
                            sub__category__table.ajax.reload();
                        }
                    });
                }
            })
        });


        /**
         * Open Edit Modal
         * */

        $(document).on('click', '#edit_btn', function(e) {
            e.preventDefault();

            var url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {

                    $('#edit-content').empty();
                    $('#edit-content').html(data);
                    $('#editSubCategoryModal').modal('show');
                },
                error: function(err) {
                    $('.data_preloader').hide();
                    if (err.status == 0) {
                        toastr.error('Net Connetion Error. Reload This Page.');
                    } else if (err.status == 500) {
                        toastr.error('Server Error, Please contact to the support team.');
                    }
                }
            });
        });


    });
</script>
@endpush
