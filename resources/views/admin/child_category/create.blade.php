<div class="modal-content border-0">
    <div class="modal-header p-3 bg-soft-info">
        <h5 class="modal-title" id="exampleModalLabel">Add Child Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
    </div>
    <form class="tablelist-form" autocomplete="off" id="add_child_category_form" action="{{ route('product.childCategory.store') }}" method="POST">
        @csrf
        @method('POST')
        <div class="modal-body">
            <div class="row g-3">
                <div class="col-lg-6">
                    <label for="childCategory_name" class="form-label">Child category Name</label>
                    <input type="text" id="childCategory_name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Child Category name">
                    <span class="error error_name text-danger"></span>
                </div>

                <div class="col-lg-6">
                    <label for="category" class="form-label">Sub-Category Name</label>
                    <select class="form-control" name="product_subcategory_id" id="category">
                        <option selected>Select Product Category</option>
                        @foreach ($subCategories as $subCategory)
                            <option value="{{ $subCategory->id }}" {{ old('product_subcategory_id') == $subCategory->id ? 'selected' : '' }} >{{ $subCategory->name }}</option>
                        @endforeach
                    </select>
                    <span class="error error_product_subcategory_id text-danger"></span>
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
                <button type="submit" class="btn btn-success submit_button">Add Child Category</button>
                <!-- <button type="button" class="btn btn-success" id="edit-btn">Update Task</button> -->
            </div>
        </div>
    </form>
</div>

<script>
    /**
     * Add Product Child Category
     * @author Nymul Islam Moon < towkir1997islam@gmail.com >
     * */
    $(document).on('submit', '#add_child_category_form', function(e) {
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
                $('#add_child_category_form')[0].reset();

                $('#addChildCategoryModal').modal('hide');

                $('.submit_button').prop('type', 'submit');

                $('.child_category_table').DataTable().ajax.reload();

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
</script>
