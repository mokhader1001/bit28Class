<?= $this->extend("index"); ?>

<?= $this->section('content'); ?>
<style>
    .page-breadcrumb {
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .breadcrumb {
        margin-bottom: 0;
    }
</style>

<div class="page-breadcrumb py-3">
    <div class="row">
        <div class="col-md-6 offset-md-1 align-self-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white px-3 py-2 shadow-sm rounded">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>/admin">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Evaluate Damaged Books</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card col-md-12">
        <div class="card-body">
            <table id="chargeTable" class="table table-striped table-bordered table-hover align-middle text-nowrap">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>User</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="evaluateDamageModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="evaluateDamageForm">
        <div class="modal-header">
          <h5 class="modal-title">Evaluate Damage</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">

          <!-- Hidden inputs -->
          <input type="hidden" name="book_id" id="eval_book_id">
          <input type="hidden" name="borrow_id" id="borrow_id">

          <!-- Book title -->
          <div class="mb-3">
            <label class="form-label">Book Title</label>
            <input type="text" id="eval_book_title" class="form-control" readonly>
          </div>

          <!-- Book price (read-only) -->
                <div class="mb-3">
                    <label class="form-label">Book Price ($)</label>
                    <input type="text" id="eval_book_price" class="form-control" readonly>
                </div>
                <!-- Username -->
        <div class="mb-3">
        <label class="form-label">User Name</label>
        <input type="text" id="eval_username" class="form-control" readonly>
        </div>

<!-- Card Tag -->
<div class="mb-3">
  <label class="form-label">Card Tag</label>
<input type="text" id="eval_card_tag" name="eval_card_tag" class="form-control" readonly>
</div>


    <!-- Damage type (Required) -->
<div class="mb-3">
  <label class="form-label">Damage Type <span class="text-danger">*</span></label>
  <select name="damage_type" class="form-select" required>
    <option value="" selected disabled>-- Select Damage Type --</option>
    <option value="minor">Minor</option>
    <option value="moderate">Moderate</option>
    <option value="major">Major</option>
  </select>
</div>

<!-- Upload photo (Required) -->
<div class="mb-3">
  <label class="form-label">Photo <span class="text-danger">*</span></label>
  <input type="file" name="photo" class="form-control" accept="image/*" required>
</div>


          <!-- Charge input -->
          <div class="mb-3">
            <label class="form-label">Charge Amount ($)</label>
            <input type="number" name="charge" id="charge_amount" class="form-control" required>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const base_url = "<?= base_url() ?>";
$(document).on('click', '.btn-eval-damage', function () {
    const bookId = $(this).data('book_id') || '';
    const borrowId = $(this).data('borrow_id') || '';
    const bookTitle = $(this).data('title') || '';
    const bookPrice = $(this).data('price') || '';
    const username = $(this).data('username') || '';
    const cardTag = $(this).data('card_tag') || '';

    // Fill modal fields
    $('#eval_book_id').val(bookId);
    $('#borrow_id').val(borrowId);
    $('#eval_book_title').val(bookTitle);
    $('#eval_book_price').val(bookPrice);
    $('#eval_username').val(username);
    $('#eval_card_tag').val(cardTag);

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('evaluateDamageModal'));
    modal.show();
});


$(document).ready(function () {
    $(document).on('input', '#charge_amount', function () {
        const bookPrice = parseFloat($('#eval_book_price').val());
        const charge = parseFloat($(this).val());

        if (!isNaN(bookPrice) && !isNaN(charge)) {
            if (charge > bookPrice) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Charge',
                    text: 'You cannot charge more than the book price!',
                });
                $(this).val('');
            } else if (charge < 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Charge',
                    text: 'Charge must be at least $1.',
                });
                $(this).val('');
            }
        }
    });
});




    $(document).ready(function () {
        $('#chargeTable').DataTable({
            ajax: base_url + "get_damaged_books_pending_charge",
            columns: [
                { data: 'index' },
                {
                    data: 'photo',
                    render: function (data) {
                        if (!data) return '<span class="text-muted">No Image</span>';
                        return `<img src="${base_url}/public/uploads/books/${data}" class="img-thumbnail" width="50">`;
                    }
                },
                { data: 'title' },
                { data: 'author' },
                {
                    data: 'username',
                    render: function (data, type, row) {
                        return `${data}<br><small class="text-muted">${row.card_tag}</small>`;
                    }
                },
                {
                    data: 'price',
                    render: function (data) {
                        return `$${parseFloat(data).toFixed(2)}`;
                    }
                },
                {
                    data: 'status',
                    render: function (status) {
                        if (status === 'damage') {
                            return `<span class="badge bg-danger">Damaged</span>`;
                        }
                        return `<span class="badge bg-secondary">${status}</span>`;
                    }
                },
                {
                    data: 'book_id',
                    render: function (bookId, type, row) {
                        return `
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light" data-bs-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item text-primary btn-eval-damage"
                                        data-book_id="${bookId}"
                                         data-borrow_id="${row.borrow_id}"  

                                        data-title="${row.title}"
                                        data-card_tag="${row.card_tag}"
                                        data-username="${row.username}"
                                        data-photo="${row.photo}"
                                        data-price="${row.price}">
                                        <i class="fas fa-check me-1"></i> Evaluate
                                    </a>
                                </div>
                            </div>`;
                    },
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

    // // ✅ Fix: Bind click event to Evaluate buttons
    // $(document).on('click', '.btn-eval-damage', function () {
    //     const bookId = $(this).data('book_id');
    //     $('#eval_book_id').val(bookId);
    //     const modal = new bootstrap.Modal(document.getElementById('evaluateDamageModal'));
    //     modal.show();
    // });

    // Handle form submission
    $(document).on('submit', '#evaluateDamageForm', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            url: base_url + "charges/evaluate",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    Swal.fire('Evaluated!', response.message, 'success');
                    $('#evaluateDamageModal').modal('hide');
                    $('#chargeTable').DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Server error occurred.', 'error');
            }
        });
    });
</script>

<?= $this->endSection(); ?>
