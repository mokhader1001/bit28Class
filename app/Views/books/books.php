<?= $this->extend("index"); ?>

<?= $this->section('content'); ?>
<!-- Select2 CSS -->
<style>
    .page-breadcrumb {
        margin-top: 10px !important;
        margin-bottom: 10px;
    }
    .breadcrumb {
        margin-bottom: 0;
    }
</style>

<div class="page-breadcrumb py-3">
    <div class="row">
        <div class="col-md-6 offset-md-1 align-self-center">
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-white px-3 py-2 shadow-sm rounded">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/admin">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Authors</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookModal" style="margin-left:90%">
  <i class="fas fa-plus"></i> Add Book
</button>

<!-- Authors Table -->
<div class="container-fluid">
    <div class="card col-md-12">
        <div id="outer"></div>
        <div id="msg" class="alert alert-success" role="alert" style="display:none;"></div>
        <div class="card-body">
            <table id="manageTable" class="table table-striped table-bordered table-hover align-middle text-nowrap">
            <thead class="table-dark">
    <tr>
        <th style="width: 40px;">#</th>
        <th>Title</th>
        <th>Author</th>
        <th>ISBN</th>
        <th>RFID Tag</th>
        <th>Quantity</th>
        <th>Published Year</th>
        <th>Price</th>
        <th>Photo</th>
        <th>Added Date</th>
        <th class="text-center">Actions</th>
    </tr>
</thead>

                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Book Modal -->
<div class="modal fade" id="bookModal" tabindex="-1" aria-labelledby="bookModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow border border-primary">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="bookModalLabel">
                    <i class="fas fa-book me-2"></i> Add/Edit Book
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="bookForm" enctype="multipart/form-data">
                <input type="hidden" name="book_id" id="book_id">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter book title" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Author</label>
                        <select name="author_id" class="form-select select2" required>
                            <option value="">Select author</option>
                            <?php foreach ($authors as $auth): ?>
                                <option value="<?= $auth['author_id'] ?>"><?= $auth['Name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ISBN</label>
                        <input type="text" name="isbn" class="form-control" placeholder="Enter ISBN number">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">RFID Tag</label>
                        <input type="text" name="rfid_tag" class="form-control" placeholder="Scan or enter RFID tag">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" class="form-control" placeholder="Enter quantity">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Published Year</label>
                        <input type="text" name="published_year" class="form-control" placeholder="e.g., 2024">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="text" name="price" class="form-control" placeholder="e.g., 10">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Photo</label><br>
                        <img id="bookPhotoPreview" src="" width="80" class="rounded border mb-2 d-none" title="Double-click to change">
                        <input type="file" name="photo" class="form-control" id="bookPhotoInput" accept="image/*">
                    </div>

                    
                </div>

                <div class="modal-footer">
                    <button type="submit" id="btn_book_submit" class="btn btn-success btn_submit_new">
                        <i class="fas fa-save me-1"></i> Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const base_url = "<?= base_url() ?>";



    
$(document).ready(function () {
    // Initialize DataTable
    manageTable = $('#manageTable').DataTable({
        ajax: base_url + 'books/fetch_books', 
        order: [] 
    });
});

    // Submit form
    $(document).on('submit', '#bookForm', function (event) {
        event.preventDefault();
        $('.btn_submit_new').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Submitting...');
        $('.btn_submit_new').attr('disabled', true);

        form(new FormData(this), 'books/save', '#bookForm', '#bookModal', '#inner_bk_add');
    });

    function form(data, controller_function, form, modal, inner) {
    $.ajax({
        url: base_url + controller_function,
        method: 'POST',
        data: data,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
            if (response.success === true) {
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = base_url + 'books'; // or reload if needed
                });

                $(modal).modal('hide');
                $('.modal-backdrop').remove();
                $(form)[0].reset();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message || 'Something went wrong.'
                });
            }

            $('.btn_submit_new').html('Save');
            $('.btn_submit_new').attr('disabled', false);
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Something went wrong while processing your request.'
            });

            $('.btn_submit_new').html('Save');
            $('.btn_submit_new').attr('disabled', false);
        },
        complete: function () {
            $('.btn_submit_new').html('Save');
            $('.btn_submit_new').attr('disabled', false);
        }
    });

    return false;
}


    // Initialize Select2
    $(document).ready(function () {
        $('.select2').select2({ width: '100%' });
    });


    $(document).on('click', '.btn-edit-book', function () {
    const modal = $('#bookModal');

    // Fill modal fields
    modal.find('[name="book_id"]').val($(this).data('book_id'));
    modal.find('[name="title"]').val($(this).data('title'));
    modal.find('[name="isbn"]').val($(this).data('isbn'));
    modal.find('[name="rfid_tag"]').val($(this).data('rfid_tag'));
    modal.find('[name="quantity"]').val($(this).data('quantity'));
    modal.find('[name="published_year"]').val($(this).data('published_year'));
    modal.find('[name="price"]').val($(this).data('price'));


    // ✅ Set author select2 correctly
    modal.find('[name="author_id"]').val($(this).data('author_id')).trigger('change');

    const photo = $(this).data('photo');
    if (photo) {
        $('#bookPhotoPreview')
            .removeClass('d-none')
            .attr('src', base_url + 'public/uploads/books/' + photo);
    } else {
        $('#bookPhotoPreview').addClass('d-none');
    }

    // Change button text to Update
    $('#btn_book_submit')
        .html('<i class="fas fa-save me-1"></i> Update')
        .removeClass('btn-success')
        .addClass('btn-warning');

    $('#bookModal').modal('show');
});

$(document).on('click', '[data-bs-target="#bookModal"]', function () {
    $('#bookForm')[0].reset();
    $('#book_id').val('');
    $('#bookPhotoPreview').addClass('d-none');

    $('#btn_book_submit')
        .html('<i class="fas fa-save me-1"></i> Save')
        .removeClass('btn-warning')
        .addClass('btn-success');
});


$(document).ready(function () {
    $('.select2').select2({ width: '100%' });
});

$(document).on('click', '.btn-delete-book', function () {
    const bookId = $(this).data('book_id');
    const title = $(this).data('title');

    Swal.fire({
        title: `Are you sure you want to delete "${title}"?`,
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + 'books/save', // Use same controller function
                method: 'POST',
                data: {
                    book_id: bookId,
                    action_type: 'delete'
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Deleted!', response.message, 'success');
                        if (typeof manageTable !== 'undefined') {
                            manageTable.ajax.reload(null, false);
                        }
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                }
            });
        }
    });
});

    
</script>
<?= $this->endSection(); ?>