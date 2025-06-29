<?= $this->extend('index') ?>
<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<br><br><br><br>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Assign Quizzes to Classes</h4>
    <button class="btn btn-primary" id="addBtn" data-bs-toggle="modal" data-bs-target="#quizClassModal">+ Assign</button>
  </div>

  <table class="table table-bordered" id="quizClassTable">
    <thead>
      <tr>
        <th>#</th>
        <th>Quiz Name</th>
        <th>Class Name</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

<!-- Modal -->
<div class="modal fade" id="quizClassModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="quizClassForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Assign Quiz to Class</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="quiz_class_id" id="quiz_class_id">

          <div class="mb-3">
            <label>Quiz</label>
            <select name="quiz_id" id="quiz_id" class="form-select select2" required>
              <option value="">-- Select Quiz --</option>
              <?php foreach ($quizzes as $quiz): ?>
                <option value="<?= $quiz['quiz_id'] ?>"><?= esc($quiz['name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label>Class</label>
            <select name="class_id" id="class_id" class="form-select select2" required>
              <option value="">-- Select Class --</option>
              <?php foreach ($classes as $class): ?>
                <option value="<?= $class['class_id'] ?>"><?= esc($class['class_name']) ?></option>
              <?php endforeach; ?>
            </select>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
  const table = $('#quizClassTable').DataTable({
    ajax: {
      url: "<?= base_url('fetch_quiz_class') ?>",
      type: "GET",
      dataSrc: "data"
    },
    columns: [
      { data: 'id' },
      { data: 'quiz_name' },
      { data: 'class_name' },
      {
        data: null,
        render: function (data) {
          return `
            <button class="btn btn-warning btn-sm editBtn"
              data-id="${data.quiz_class_id}"
              data-quiz="${data.quiz_id}"
              data-class="${data.class_id}">
              <i class="fa fa-edit"></i>
            </button>
           
          `;
        }
      }
    ]
  });


$('#addBtn').click(function (e) {
    e.preventDefault();
    $('#quizClassForm')[0].reset();
    $('#quiz_class_id').val('');
    $('#quiz_id, #class_id').val(null).trigger('change');
    $('.modal-title').text('Assign Quiz to Class');
});

$('#quizClassForm').submit(function (e) {
  e.preventDefault();
  $.ajax({
    url: "<?= base_url('save_quiz_class') ?>",
    method: "POST",
    data: $(this).serialize(),
    dataType: "json",
    success: function (res) {
      if (res.status === 'success') {
        $('#quizClassModal').modal('hide');
        $('.modal-backdrop').remove(); // Remove modal backdrop
        $('#quizClassForm')[0].reset();
        $('#quiz_id, #class_id').val(null).trigger('change');
        table.ajax.reload();
        Swal.fire('Success', res.message || 'Assignment saved!', 'success');
      } else {
        Swal.fire('Error', res.message || 'Save failed.', 'error');
      }
    },
    error: function () {
      Swal.fire('Error', 'An error occurred.', 'error');
    }
  });
});

$('#quizClassTable').on('click', '.editBtn', function () {
  const id = $(this).data('id');
  const quizId = $(this).data('quiz');
  const classId = $(this).data('class');

  $('#quiz_class_id').val(id);
  $('#quiz_id').val(quizId);     // Just set the value
  $('#class_id').val(classId);   // Same here

  $('.modal-title').text('Edit Quiz-Class Assignment');
  $('#quizClassModal').modal('show');
});


  $('#quizClassTable').on('click', '.deleteBtn', function () {
    const id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure?',
      text: 'This assignment will be deleted!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then(result => {
      if (result.isConfirmed) {
        $.post("<?= base_url('quiz-class/delete') ?>", { id }, function (res) {
          if (res.status === 'success') {
            table.ajax.reload();
            Swal.fire('Deleted!', 'Assignment removed.', 'success');
          } else {
            Swal.fire('Error', 'Failed to delete.', 'error');
          }
        });
      }
    });
  });
});
</script>

<?= $this->endSection() ?>
