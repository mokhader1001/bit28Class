<?= $this->extend('index') ?>
<?= $this->section('content') ?>
<br><br><br><br>



<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Class Management</h4>
    <button class="btn btn-primary" id="addBtn" data-bs-toggle="modal" data-bs-target="#classModal">+ Add Class</button>
  </div>

  <table class="table table-bordered" id="classTable">
    <thead>
      <tr>
        <th>#</th>
        <th>Class Name</th>
        <th>Assigned Teacher</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<!-- Modal -->
<div class="modal fade" id="classModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="classForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Class</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="class_id" id="class_id">

          <div class="mb-3">
            <label>Class Name</label>
            <input type="text" class="form-control" name="class_name" id="class_name" required>
          </div>

     
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 Bundle (with Popper.js included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script>
$(document).ready(function () {
  let table = $('#classTable').DataTable({
    ajax: {
      url: "<?= base_url('fetch_clases') ?>",
      type: "GET",
      dataSrc: "data"
    },
    columns: [
      { data: 'class_id' },
      { data: 'class_name' },
      { data: 'teacher_name' },
      {
        data: null,
        orderable: false,
        searchable: false,
        render: function (data) {
          return `
            <button class="btn btn-warning btn-sm editBtn" 
              data-id="${data.class_id}"
              data-name="${data.class_name}"
              data-teacher="${data.teacher_id}" 
              title="Edit">
              <i class="fa fa-pencil-alt"></i>
            </button>
            <button class="btn btn-danger btn-sm deleteBtn" 
              data-id="${data.class_id}" 
              title="Delete">
              <i class="fa fa-trash"></i>
            </button>
          `;
        }
      }
    ]
  });
$('#addBtn').click(function () {
    $('#classForm')[0].reset();
    $('#class_id').val('');
    $('.modal-title').text('Add Class');
});

$('#classForm').submit(function (e) {
  e.preventDefault();
  $.ajax({
    url: "<?= base_url('save_class') ?>",
    method: "POST",
    data: $(this).serialize(),
    success: function (res) {
      if (res.status === 'success') {
        $('#classModal').modal('hide');
        $('.modal-backdrop').remove();
        table.ajax.reload();
        Swal.fire('Success', res.message || 'Class saved successfully!', 'success');
      } else {
        Swal.fire('Error', res.message || 'Failed to save class.', 'error');
      }
    },
    error: function () {
      Swal.fire('Error', 'Failed to save class.', 'error');
    }
  });
});


  $('#classTable').on('click', '.editBtn', function () {
    $('#class_id').val($(this).data('id'));
    $('#class_name').val($(this).data('name'));
    $('#teacher_id').val($(this).data('teacher'));
    $('.modal-title').text('Edit Class');
    $('#classModal').modal('show');
  });

$('#classTable').on('click', '.deleteBtn', function () {
    const classId = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "This will delete the class permanently!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?= base_url('delete_class') ?>",
                type: "POST",
                data: { class_id: classId },
                success: function (res) {
                    if (res.status === 'success') {
                        Swal.fire('Deleted!', 'Class has been deleted.', 'success');
                        $('#classTable').DataTable().ajax.reload();
                    } else {
                        Swal.fire('Error!', 'Delete failed.', 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Server error.', 'error');
                }
            });
        }
    });
});
});



</script>

<?= $this->endSection() ?>
