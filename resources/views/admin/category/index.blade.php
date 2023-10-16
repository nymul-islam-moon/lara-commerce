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
                        <h4 class="mb-sm-0">Blog Categoory List</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Blog</a></li>
                                <li class="breadcrumb-item active">Blog Categoory List</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-uppercase fw-medium text-muted mb-0">Total Product Categories</p>
                                </div>
                                {{-- <div class="flex-shrink-0">
                                    <h5 class="text-success fs-14 mb-0">
                                        <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +16.24 %
                                    </h5>
                                </div> --}}
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" id="total_category_count" data-target="0">0</span></h4>
                                    <a href="#" class="text-decoration-underline">View net earnings</a>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-success rounded fs-3">
                                        <i class="bx bx-dollar-circle text-success"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-uppercase fw-medium text-muted mb-0">Total Active Category</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">$<span class="counter-value" id="active_category_count" data-target="0">0</span>k</h4>
                                    <a href="#" class="text-decoration-underline">View net earnings</a>
                                </div>
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-soft-success rounded fs-3">
                                        <i class="bx bx-dollar-circle text-success"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">

                        <div class="card-header border-0">
                            <div class="d-flex align-items-center">
                                <h5 class="card-title mb-0 flex-grow-1">Blog Category List</h5>
                                <div class="flex-shrink-0">
                                   <div class="d-flex flex-wrap gap-2">

                                        {{-- <button class="btn btn-danger add-btn" data-bs-toggle="modal" data-bs-target="#addCategoryModal"><i class="ri-add-line align-bottom me-1"></i> Create Task</button> --}}
                                        <button class="btn btn-danger add-btn" href="{{ route('blog.category.create') }}" id="add_btn"><i class="ri-add-line align-bottom me-1"></i> Add Category</button>

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
                                    <table class="table align-middle table-nowrap mb-0 data_tbl category_table">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="width: 46px;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="select_all_ids">
                                                    </div>
                                                </th>
                                                <th scope="col">ID</th>
                                                <th scope="col">Action</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Image</th>
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

            <div class="modal fade zoomIn" id="addCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg" id="add-content">
                    <h1>hi</h1>
                </div>
            </div>

            <div class="modal fade zoomIn" id="editCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
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
         * Get all information
         * */
         function getAllData()
        {
            $.ajax({
                url: "{{ route('blog.category.getAllData') }}",
                type: 'GET',

                success: function(data) {
                    var total_category_count = document.getElementById('total_category_count');
                    total_category_count.dataset.target = data.allCategory;
                }
            });
        }


        /**
         * Yajra DataTable for show all data
         *
         * */
        var service__category__table = $('.category_table').DataTable({
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
                url: "{{ route('blog.category.index') }}",
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
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status'},
                {data: 'image', name: 'image'},
                {data: 'created_by', name: 'created_by'},
                {data: 'updated_by', name: 'updated_by'},

            ]
        });


        /**
         * Open Product Category Crete Form
         * @author Nymul Islam Moon < towkir1997@gmail.com >
         * */
         /**
         * Open Edit Modal
         * */

         $(document).on('click', '#add_btn', function(e) {
            e.preventDefault();

            var url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'get',
                success: function(data) {

                    $('#add-content').empty();
                    $('#add-content').html(data);
                    $('#addCategoryModal').modal('show');
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
                    $('#editCategoryModal').modal('show');
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
                    service__category__table.ajax.reload();
                },
                error: function(err) {
                    toastr.error(err.responseJSON)
                    service__category__table.ajax.reload();
                }
            });
        });


        /**
         * Filter js for reload the table on change
         * */

        $('.submitable').on('change', function(e) {
            service__category__table.ajax.reload();
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
                    service__category__table.ajax.reload();
                },
                error: function(err) {
                    toastr.error(err.responseJSON)
                    service__category__table.ajax.reload();
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
                    service__category__table.ajax.reload();
                },
                error: function(err) {
                    toastr.error(err.responseJSON)
                    service__category__table.ajax.reload();
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
                            service__category__table.ajax.reload();
                        },
                        error: function(err) {
                            toastr.error(err.responseJSON)
                            service__category__table.ajax.reload();
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
                        url: "{{ route('blog.category.destroyAll') }}",
                        type: 'DELETE',
                        data: {
                            ids:all_ids,
                            _token:'{{ csrf_token() }}',
                        },

                        success: function(data) {
                            toastr.error(data);
                            service__category__table.ajax.reload();
                            $("#select_all_ids").prop("checked", false);
                        },
                        error: function(err) {
                            toastr.error(err.responseJSON)
                            service__category__table.ajax.reload();
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
                        url: "{{ route('blog.category.restoreAll') }}",
                        type: 'DELETE',
                        data: {
                            ids:all_ids,
                            _token:'{{ csrf_token() }}',
                        },

                        success: function(data) {
                            toastr.success(data);
                            service__category__table.ajax.reload();
                            $("#select_all_ids").prop("checked", false);
                        },
                        error: function(err) {
                            toastr.error(err.responseJSON)
                            service__category__table.ajax.reload();
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
                        url: "{{ route('blog.category.permanentDestroyAll') }}",
                        type: 'DELETE',
                        data: {
                            ids:all_ids,
                            _token:'{{ csrf_token() }}',
                        },

                        success: function(data) {
                            toastr.error(data);
                            service__category__table.ajax.reload();
                            $("#select_all_ids").prop("checked", false);
                        },
                        error: function(err) {
                            toastr.error(err.responseJSON)
                            service__category__table.ajax.reload();
                        }
                    });
                }
            })
        });

    });
</script>
@endpush
