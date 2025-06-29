<?php
/** @var CodeIgniter\View\View $this */
?>
<?= $this->extend('index') ?>
<?= $this->section('content') ?>

<div class="page-breadcrumb py-3">
    <div class="row">
        <div class="col-md-8 offset-md-2 align-self-center">
            <h3 class="text-center fw-bold text-primary">
                <i class="fas fa-user-circle me-2"></i>Profile of <?= session()->get('username') ?>
            </h3>
        </div>
    </div>
</div>

<div class="container my-4">
    <div class="card shadow border-0">
        <div class="card-body px-4">
            <div class="text-center mb-4">
                <img src="<?= base_url('public/uploads/staff/' . session()->get('image')) ?>" class="rounded-circle border shadow" width="120" height="120" alt="Profile Image">
                <div class="mt-2">
                    <input type="file" name="image" class="form-control form-control-sm d-inline-block w-auto" accept="image/*">
                </div>
            </div>

            <form id="profileForm" method="post" enctype="multipart/form-data">

                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="username" class="form-control form-control-md" value="<?= session()->get('username') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control form-control-md" value="<?= session()->get('email') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control form-control-md" value="<?= session()->get('phone') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select form-select-md">
                        <option value="male" <?= session()->get('gender') == 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= session()->get('gender') == 'female' ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <input type="text" name="role" class="form-control form-control-md" value="<?= session()->get('role') ?>" readonly>
              

            

                <div class="text-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Save Changes</button>
                    <button type="button" class="btn btn-outline-secondary ms-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fas fa-key me-1"></i> Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Password Change Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="changePasswordModalLabel">
                    <i class="fas fa-lock me-2"></i> Change Password
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="passwordForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
