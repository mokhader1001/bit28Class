<?= $this->extend('index'); ?>
<?= $this->section('content'); ?>
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

<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal" style="margin-left:90%">
  <i class="fas fa-plus"></i> Library User
</button>
<div class="container-fluid">
    <div class="card col-md-12">
        <div id="outer"></div>
        <div id="msg" class="alert alert-success" role="alert" style="display:none;"></div>
        <div class="card-body">
        <table id="userTable" class="table table-bordered table-hover">
            <thead class="table-dark">
              <tr>
                <th>#</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Card Tag</th>
                <th>Image</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>

            </div>
        </div>
    </div>


<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="userModalLabel"><i class="fas fa-user-edit me-1"></i> Add/Edit Library User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="libraryUserForm">
        <input type="hidden" name="user_id" id="user_id">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone_number" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-select">
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Occupation</label>
            <input type="text" name="occupation" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="dob" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Card Tag</label>
            <input type="text" name="card_tag" class="form-control" placeholder="Please scan the card using the RFID machine">
            </div>
          <!-- Image Preview Modal Block -->
      <div class="mb-3">
        <label class="form-label">Image</label><br>
        <img id="imagePreview" src="" width="80" class="rounded border" style="cursor: pointer;" title="Double-click to change image">
        <input type="file" name="image" class="form-control mt-2" id="imageInput" style="display: none;" accept="image/*">
      </div>

        </div>
        <div class="modal-footer">
          <button type="submit" id="btn_submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
    const baseUrl = "<?= base_url(); ?>";

    let align = 'dt-left';
    let manageTable;

    const base_url = "<?= base_url() ?>";

$(document).ready(function () {
    manageTable = $('#userTable').DataTable({
        ajax: base_url + 'authors/fetch_library_users', 
        order: [] 
    });
});

    $(document).on('submit', '#libraryUserForm', function(event) {
        event.preventDefault(); // ✅ Prevent default form submission

        const formData = new FormData(this);

        form(formData, 'libraryusers/save', '#libraryUserForm', '#userModal');
    });
    function form(data, controller_function, formSelector, modalSelector, innerSelector = null, callback = null) {
  $('#btn_submit').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Saving...');
  $('#btn_submit').attr('disabled', true);

  $.ajax({
    url: baseUrl + controller_function,
    method: 'POST',
    data: data,
    contentType: false,
    processData: false,
    dataType: 'json',
    success: function (response) {
      if (response.success === true) {
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: response.message,
          timer: 2000,
          showConfirmButton: false
        });

        $('#btn_submit').html('Save').attr('disabled', false);
        $(modalSelector).modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $(formSelector)[0].reset();

        if (typeof callback === "function") {
          callback(); // ✅ reload table AFTER successful operation
        }
        if (typeof manageTable !== "undefined") {
          manageTable.ajax.reload(null, false);
        }
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: response.message
        });

        $('#btn_submit').html('Save').attr('disabled', false);
      }
    }
  });
}

// Set image preview from URL
$('#imagePreview').on('dblclick', function () {
  $('#imageInput').show().click(); // Show and trigger click
});

// Reset form for Add User
$('[data-bs-target="#userModal"]').on('click', function () {
  $('#libraryUserForm')[0].reset();
  $('#user_id').val('');
  $('#btn_submit').text('Save');
  $('#imagePreview').hide();         // hide preview for add
  $('#imageInput').show();           // show file input
});

// Populate form for Edit
$(document).on('click', '#btn_edit', function () {
  $('#user_id').val($(this).data('user_id'));
  $('input[name="username"]').val($(this).data('username'));
  $('input[name="email"]').val($(this).data('email'));
  $('input[name="phone_number"]').val($(this).data('phone_number'));
  $('input[name="occupation"]').val($(this).data('occupation'));
  $('input[name="dob"]').val($(this).data('dob'));
  $('input[name="card_tag"]').val($(this).data('card_tag'));
  $('select[name="gender"]').val($(this).data('gender'));

  const image = $(this).data('image');
  if (image) {
    const imageUrl = baseUrl + 'public/uploads/library_users/' + image;
    $('#imagePreview').attr('src', imageUrl).show();
    $('#imageInput').hide(); // hide input unless user double-clicks
  } else {
    $('#imagePreview').hide();
    $('#imageInput').show();
  }

  $('#btn_submit').text('Update');
  $('#userModal').modal('show');
});
$(document).on('click', '#btn_delete', function () {
  const user_id = $(this).data('user_id');
  const username = $(this).data('username');

  Swal.fire({
    title: `Delete ${username}?`,
    text: "This action cannot be undone.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append('user_id', user_id);
      formData.append('action_type', 'delete');

      // ✅ Reload table ONLY after deletion success
      form(formData, 'libraryusers/save', '#libraryUserForm', '#userModal', null, () => {
        manageTable.ajax.reload(null, false);
      });
    }
  });
});



$(document).on('click', '.btn-status-toggle', function () {
  const user_id = $(this).data('user_id');
  const new_status = $(this).data('status');

  Swal.fire({
    title: `Are you sure you want to ${new_status === 'Active' ? 'activate' : 'deactivate'} this user?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Yes',
    cancelButtonText: 'Cancel'
  }).then(result => {
    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append('user_id', user_id);
      formData.append('status', new_status);
      formData.append('action_type', 'toggle_status');

      form(formData, 'libraryusers/save', '#libraryUserForm', '#userModal', null, () => {
        manageTable.ajax.reload(null, false); // ✅ Reload table after update
      });
    }
  });
});


</script>

<?= $this->endSection(); ?>