<?= $this->extend("index"); ?>

<?= $this->section('content'); ?>
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



<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAuthorModal"  style="margin-left:90%">
  <i class="fas fa-plus"></i> Add Author
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
      <th>Author Name</th>
      <th>Description</th>
      <th class="text-center">Actions</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

            </div>
        </div>
    </div>
</div>


<!-- add modal -->

<!-- Add Author Modal -->
<!-- Add Author Modal -->
<div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="addAuthorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="addAuthorModalLabel">
          <i class="fas fa-user-edit me-2"></i>Add New Author
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="authors_form" method="POST">
      <input type="hidden" name="author_id" id="author_id">

        <div class="modal-body">
          <!-- Name Input -->
          <div class="mb-3">
            <label class="form-label"><i class="fas fa-user-tag me-2"></i>Author Name</label>
            <input type="text" class="form-control" name="name" placeholder="Enter author name" required>
          </div>
          <!-- Description Input -->
          <div class="mb-3">
            <label class="form-label"><i class="fas fa-info-circle me-2"></i>Description</label>
            <textarea class="form-control" name="descriptions" rows="3" placeholder="Short bio or description" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Cancel
          </button>
          <button type="submit" id="btn_submit_modal"
            class="btn btn_submit_new btn-rounded btn-outline-primary">
            <b><i class="fas fa-save me-1"></i> Save</b>
        </button>

                    </div>

        </div>
      </form>
    </div>
  </div>
</div>






<!-- jQuery 3.6.0 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 Bundle (with Popper.js included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script>
    let align = 'dt-left';
    let manageTable;

    const base_url = "<?= base_url() ?>";

$(document).ready(function () {
    // Initialize DataTable
    manageTable = $('#manageTable').DataTable({
        ajax: base_url + 'authors/fetch_Authors', // ✅ no trailing slash needed
        order: [] // ✅ empty means default order is disabled
        // columnDefs: [{ className: 'dt-left', targets: [0, 1, 2, 3] }]
    });
});
;


 // Clear modal for insert
// Open modal for Edit
$(document).on('click', '#btn_edit', function () {
    const id = $(this).data('author_id');
    const name = $(this).data('name');
    const desc = $(this).data('description');

    $('#author_id').val(id);
    $('[name="name"]').val(name);
    $('[name="descriptions"]').val(desc);
    $('[name="action_type"]').val(''); // clear for update
    $('#btn_submit_modal')
        .html('<b><i class="fas fa-edit me-1"></i> Update</b>')
        .removeClass('btn-outline-danger')
        .addClass('btn-warning');

    $('#addAuthorModalLabel').html('<i class="fas fa-edit me-2"></i> Update Author');
    $('#addAuthorModal').modal('show');
});

$(document).on('click', '#btn_delete', function () {
    const id = $(this).data('author_id');
    const name = $(this).data('name');
    const desc = $(this).data('description');

    Swal.fire({
        title: 'Are you sure?',
        text: `Do you want to delete "${name}"? This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
    }).then((result) => {
        if (result.isConfirmed) {
            const formData = new FormData();
            formData.append('author_id', id);
            formData.append('action_type', 'delete');

            form(formData, 'authors/save', '#authors_form', '#addAuthorModal', '#inner_auth_add');

            Swal.fire({
                title: 'Deleted!',
                text: `"${name}" has been deleted.`,
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
});



// Open modal for Add
$(document).on('click', '.btn_add_author', function () {
    $('#authors_form')[0].reset();
    $('#author_id').val('');
    $('[name="action_type"]').val('');
    $('#btn_submit_modal')
        .html('<b><i class="fas fa-save me-1"></i> Save</b>')
        .removeClass('btn-warning btn-outline-danger')
        .addClass('btn-outline-primary');
    $('#addAuthorModalLabel').html('<i class="fas fa-user-edit me-2"></i> Add New Author');
    $('#addAuthorModal').modal('show');
});


     
$(document).on('submit', '#authors_form', function (event) {
    event.preventDefault(); // ✅ Prevent default browser form submission
    $('.btn_submit_new').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Submiting...');
    $('.btn_submit_new').attr('disabled', true);
    form(new FormData(this), 'authors/save', '#authors_form', '#addAuthorModal', '#inner_auth_add');
});


       


     
function form(data, controller_function, form, modal, inner) {
    event.preventDefault();
    $.ajax({
        url: base_url + controller_function,
        method: 'POST',
        data: data,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
            if (response.success == true) {
                // ✅ check if it's an update
                const isUpdate = data.get('author_id');

                Swal.fire({
                    icon: 'success',
                    title: isUpdate ? 'Updated Successfully' : 'Author Added',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                // ✅ Reload table
                if (typeof manageTable !== 'undefined') {
                    manageTable.ajax.reload(null, false);
                }

                $(modal).modal('hide');
                $('.modal-backdrop').remove();
                $(form)[0].reset();
            } else {
                $(inner).html(response.alert_inner || 'Error occurred.');
                setTimeout(() => { $(inner).html(''); }, 4000);
            }

            $('.btn_submit_new').html('Save');
            $('.btn_submit_new').attr('disabled', false);
        },
        error: function () {
            Swal.fire('Error', 'Something went wrong.', 'error');
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

 

</script>

<?= $this->endSection(); ?>