<div class="modal-content border-0">
    <div class="modal-header p-3 bg-soft-info">
        <h5 class="modal-title" id="exampleModalLabel">Edit Chield Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
    </div>

    <form class="tablelist-form" id="edit_chield_category_form" action="{{ route('product.childCategory.update', $childCategory->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-lg-6">
                    <label for="childCategory_name" class="form-label">Chield Category Name</label>
                    <input type="text" id="childCategory_name" name="name" class="form-control" value="{{ $childCategory->name }}" placeholder="childCategory name">
                    <span class="error error_name text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="product_subcategory_id" class="form-label">Sub-Category Name</label>
                    <select class="form-control" name="product_subcategory_id" id="product_subcategory_id">
                        <option selected>Select Product Category</option>
                        @foreach ($subCategories as $subCategory)
                            <option value="{{ $subCategory->id }}" {{ $childCategory->product_subcategory_id == $subCategory->id ? 'selected' : '' }} >{{ $subCategory->name }}</option>
                        @endforeach
                    </select>
                    <span class="error error_product_subcategory_id text-danger"></span>
                </div>
                <!--end col-->
                <div class="col-lg-6">
                    <label for="childCategory_status" class="form-label">Status</label>
                    <select class="form-control" name="status" id="childCategory_status">
                        <option selected>Status</option>
                        <option value="1" {{ $childCategory->status == 1 ? 'selected' : '' }} >Active</option>
                        <option value="0" {{ $childCategory->status == 2 ? 'selected' : '' }} >De-Active</option>
                    </select>
                    <span class="error error_status text-danger"></span>
                </div>
            </div>
        </div>

        <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary update_button">Update Sub-Category</button>
            </div>
        </div>
    </form>
</div>


<script>

    $(document).on('submit', '#edit_chield_category_form', function(e) {
        e.preventDefault();

        $('.update_button').prop('type', 'button');

        var url = $(this).attr('action');

        $.ajax({
            url: url,
            type: 'post',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                toastr.success(data);
                $('#editChieldCategoryModal').modal('hide');
                $('.update_button').prop('type', 'submit');
                $('.child_category_table').DataTable().ajax.reload();
            },
            error: function(err) {

                $('.error').html('');

                $('.submit_button').prop('type', 'submit');

                if (err.status == 0) {
                    toastr.error('Net Connetion Error. Reload This Page.');
                    return;
                } else if (err.status == 500) {
                    toastr.error('Server error. Please contact to the support team.');
                    return;
                }
                $.each(err.responseJSON.errors, function(key, error) {
                    $('.error_e_' + key + '').html(error[0]);
                });
            }
        });


    });
</script>

