<?= $this->extend('index'); ?>
<?= $this->section('content'); ?>
<br><br><br>
<div class="container py-5">
    <h3 class="mb-4 text-primary">
        <i class="fas fa-user-graduate me-2"></i>
        BIT28-A Memory Keepsake - Student List
    </h3>
  <button class="btn btn-primary" id="viewMemoriesBtn" style="margin-left:90%">
        <i class="fas fa-images"></i> View Memories
    </button>

    <button class="btn btn-success" id="addMemoriesBtn" style="margin-left:2%  ">
        <i class="fas fa-plus-circle"></i> Add Memories
    </button>

    <div class="table-responsive">
        <table id="studentTable" class="table table-bordered table-striped w-100">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Message</th>
                    <th>Photo</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- JS dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<script>
    const base_url = "<?= base_url(); ?>";

    
    document.getElementById('viewMemoriesBtn').addEventListener('click', function() {
        // Replace 'baseurl' with the actual base URL of your site
        window.location.href = base_url+"/Bit28/accepted_students";
    });
          document.getElementById('addMemoriesBtn').addEventListener('click', function() {
        window.location.href = base_url+"/BIT28-A/GraduationReg";
    });

    $(document).ready(function () {
        $('#studentTable').DataTable({
            ajax: {
                url: base_url + 'Bit28/fetch_students',
                dataSrc: 'data'
            },
            columns: [
                { width: "5%" },       // #
                { width: "20%" },      // Name
                { width: "30%" },      // Message
                { width: "10%" },      // Photo
                { width: "10%" },      // Status
                { width: "15%" }       // Action
            ],
            order: [[0, 'asc']],
            language: {
                emptyTable: "No students registered yet."
            }
        });
    });

    // Handle Accept button
    $(document).on('click', '.btn-accept', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Accept this student?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, accept',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(id, 'accepted');
            }
        });
    });

    // Handle Decline button
    $(document).on('click', '.btn-decline', function () {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Decline this student?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, decline',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(id, 'declined');
            }
        });
    });

    // AJAX call to update status
    function updateStatus(id, status) {
        $.post(base_url + 'Bit28/update_status', { student_id: id, status: status }, function (response) {
            if (response.success) {
                Swal.fire('Success', response.message, 'success');
                $('#studentTable').DataTable().ajax.reload(null, false);
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        }, 'json');
    }

    // Photo zoom functionality
    $(document).on('click', '.zoom-photo', function () {
        const imgSrc = $(this).data('src');
        Swal.fire({
            imageUrl: imgSrc,
            imageAlt: 'Student Photo',
            showCloseButton: true,
            showConfirmButton: false,
            width: 'auto',
            padding: '1em',
            background: '#fff'
        });
    });

    $(document).on('click', '.btn-delete', function () {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Delete Student?',
        text: "This will permanently remove the record and photo.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(base_url + 'Bit28/delete_student', { student_id: id }, function (response) {
                if (response.success) {
                    Swal.fire('Deleted!', response.message, 'success');
                    $('#studentTable').DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }, 'json');
        }
    });
});

</script>

<?= $this->endSection(); ?>
