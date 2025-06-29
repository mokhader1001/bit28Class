<?= $this->extend('index') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


<br><br><br><br>
<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Quiz Management</h4>
    <button class="btn btn-primary" id="addBtn" data-bs-toggle="modal" data-bs-target="#quizModal">+ Add Quiz</button>
  </div>

  <table class="table table-bordered" id="quizTable">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Total Marks</th>
        <th>Time Limit</th>
        <th>Description</th>
        <th>Status</th>
        <th>Created By</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<div class="modal fade" id="quizModal">
  <div class="modal-dialog">
    <form id="quizForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Quiz</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="quiz_id" id="quiz_id">
          <div class="mb-2">
            <label>Quiz Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Total Marks</label>
            <input type="number" name="total_marks" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Time Limit (minutes)</label>
            <input type="number" name="time_limit" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
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

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
  let table = $('#quizTable').DataTable({
    ajax: {
      url: "<?= base_url('Quiz/List') ?>",
      type: "GET",
      dataSrc: "data"
    },
    columns: [
      { data: 'quiz_id' },
      { data: 'name' },
      { data: 'total_marks' },
      { data: 'time_limit' },
      { data: 'description' },
      { data: 'status' },
      { data: 'username' },
      { data: 'actions' }
    ]
  });

  $('#addBtn').click(function () {
    $('#quizForm')[0].reset();
    $('#quiz_id').val('');
    $('.modal-title').text('Add Quiz');
  });

  $('#quizForm').submit(function (e) {
    e.preventDefault();
    $.ajax({
      url: "<?= base_url('save_quiz') ?>",
      method: "POST",
      data: $(this).serialize(),
      success: function (res) {
        if (res.status === 'success') {
          $('#quizModal').modal('hide');
          table.ajax.reload();
          Swal.fire('Success', res.message || 'Quiz saved successfully!', 'success');
        } else {
          Swal.fire('Error', res.message || 'Failed to save quiz.', 'error');
        }
      }
    });
  });

  $('#quizTable').on('click', '.editBtn', function () {
    $('#quiz_id').val($(this).data('id'));
    $('[name="name"]').val($(this).data('name'));
    $('[name="total_marks"]').val($(this).data('marks'));
    $('[name="time_limit"]').val($(this).data('time'));
    $('[name="description"]').val($(this).data('description'));
    $('[name="status"]').val($(this).data('status'));
    $('.modal-title').text('Edit Quiz');
    $('#quizModal').modal('show');
  });

  $('#quizTable').on('click', '.deleteBtn', function () {
    const id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure?',
      text: 'This quiz will be deleted!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("<?= base_url('save_quiz') ?>", {
          quiz_id: id,
          _method: "DELETE"
        }, function (res) {
          if (res.status === 'success') {
            table.ajax.reload();
            Swal.fire('Deleted!', 'Quiz deleted successfully.', 'success');
          } else {
            Swal.fire('Error!', 'Failed to delete.', 'error');
          }
        });
      }
    });
  });
});
</script>

<?= $this->endSection() ?>
