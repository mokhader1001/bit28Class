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
                        <li class="breadcrumb-item active" aria-current="page">Library Staff</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staffModal" style="margin-left:90%">
    <i class="fas fa-plus"></i> Add Staff
</button>

<div class="container-fluid">
    <div class="card col-md-12">
        <div class="card-body">
            <table id="manageTable" class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Role</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staffModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border border-primary shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-user-edit me-1"></i> Add/Edit Staff</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="staffForm" enctype="multipart/form-data">
                <input type="hidden" name="staff_id" id="staff_id">
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Gender</label>
                        <select name="gender" class="form-select">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Role</label>
                        <input type="text" name="role" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Image</label><br>
                        <img id="staffPhotoPreview" src="" width="60" class="mb-2 d-none rounded border">
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn_submit_new"><i class="fas fa-save me-1"></i> Save</button>
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

    $(document).ready(function () {
        manageTable = $('#manageTable').DataTable({
            ajax: base_url + 'staff/fetch_staff',
            order: []
        });
    });

    $(document).on('click', '.btn-edit-staff', function () {
        $('#staff_id').val($(this).data('staff_id'));
        $('[name="username"]').val($(this).data('username'));
        $('[name="password"]').val($(this).data('password'));
        $('[name="gender"]').val($(this).data('gender'));
        $('[name="phone"]').val($(this).data('phone'));
        $('[name="email"]').val($(this).data('email'));
        $('[name="address"]').val($(this).data('address'));
        $('[name="role"]').val($(this).data('role'));

        const image = $(this).data('image');
        if (image) {
            $('#staffPhotoPreview')
                .attr('src', base_url + 'public/uploads/staff/' + image)
                .removeClass('d-none');
        } else {
            $('#staffPhotoPreview').addClass('d-none');
        }

        $('.btn_submit_new').html('<i class="fas fa-save me-1"></i> Update').removeClass('btn-success').addClass('btn-warning');
        $('#staffModal').modal('show');
    });

    $(document).on('click', '.btn-delete-staff', function () {
        const id = $(this).data('staff_id');
        const name = $(this).data('username');

        Swal.fire({
            title: `Delete ${name}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(base_url + 'staff/save_staff', { staff_id: id, action_type: 'delete' }, function (res) {
                    if (res.success) {
                        Swal.fire('Deleted!', res.message, 'success');
                        manageTable.ajax.reload(null, false);
                    } else {
                        Swal.fire('Error!', res.message, 'error');
                    }
                });
            }
        });
    });



    $(document).on('submit', '#staffForm', function (event) {
        event.preventDefault();
        $('.btn_submit_new').html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> Submitting...');
        $('.btn_submit_new').attr('disabled', true);

        form(new FormData(this), 'staff/save_staff', '#staffForm', '#staffModal', '#inner_bk_add');
    });


    $(document).on('click', '.btn-status-toggle', function () {
    const staffId = $(this).data('staff_id');
    const newStatus = $(this).data('status');

    Swal.fire({
        title: `Are you sure?`,
        text: `Change status to ${newStatus}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, change it',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + 'staff/save_staff',
                method: 'POST',
                data: {
                    staff_id: staffId,
                    action_type: 'toggle_status',
                    status: newStatus
                },
                dataType: 'json',
                success: function (response) {
                    Swal.fire(response.success ? 'Updated!' : 'Failed', response.message, response.success ? 'success' : 'error');
                    if (typeof manageTable !== 'undefined') {
                        manageTable.ajax.reload(null, false);
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Could not change status.', 'error');
                }
            });
        }
    });
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
                    window.location.reload(); // or reload if needed
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
</script>

<?= $this->endSection(); ?>
