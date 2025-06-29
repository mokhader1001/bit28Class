<?= $this->extend("index"); ?>
<?= $this->section('content'); ?>

<style>
.avatar-sm {
  width: 40px;
  height: 40px;
  font-size: 14px;
}

.table-hover tbody tr:hover {
  background-color: rgba(0, 123, 255, 0.05);
}

.font-monospace {
  font-family: "Courier New", Courier, monospace;
}

.card {
  transition: all 0.3s ease;
  border: none;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card:hover {
  transform: translateY(-2px);
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.btn {
  transition: all 0.2s ease;
}

.btn:hover {
  transform: translateY(-1px);
}

.badge {
  font-size: 0.75em;
  font-weight: 500;
}

.table th {
  font-weight: 600;
  color: #495057;
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border: none;
}

.dropdown-menu {
  border: none;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.form-control:focus,
.form-select:focus {
  border-color: #0d6efd;
  box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.stats-card {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 15px;
}

.stats-card.success {
  background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}

.stats-card.warning {
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stats-card.info {
  background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.loading {
  position: relative;
  overflow: hidden;
}

.loading::after {
  content: "";
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
  animation: loading 1.5s infinite;
}

@keyframes loading {
  0% { left: -100%; }
  100% { left: 100%; }
}

.risk-low { background: linear-gradient(135deg, #11998e, #38ef7d); }
.risk-medium { background: linear-gradient(135deg, #f093fb, #f5576c); }
.risk-high { background: linear-gradient(135deg, #ff416c, #ff4b2b); }

.device-icon {
  width: 35px;
  height: 35px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 10px;
}

.notification {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 9999;
  min-width: 300px;
  animation: slideIn 0.3s ease;
}

@keyframes slideIn {
  from { transform: translateX(100%); opacity: 0; }
  to { transform: translateX(0); opacity: 1; }
}

@media (max-width: 768px) {
  .table-responsive { font-size: 0.875rem; }
  .avatar-sm { width: 32px; height: 32px; font-size: 12px; }
  .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
}

.nav-tabs .nav-link {
    color: #6c757d;
    border: none;
    border-bottom: 2px solid transparent;
}

.nav-tabs .nav-link.active {
    color: #0d6efd;
    border-bottom: 2px solid #0d6efd;
    background-color: transparent;
}

.nav-tabs .nav-link:hover {
    color: #0d6efd;
    border-bottom: 2px solid #0d6efd;
}

.table th {
    font-weight: 600;
}

.badge {
    font-size: 0.875em;
}
</style>

<div class="container-fluid px-4 py-4">
    <h3 class="mb-4 fw-bold text-primary">
        <i class="fas fa-shield-alt me-2"></i>User Login Logs
    </h3>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table id="loginLogsTable" class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th><i class="fas fa-user me-1"></i>Staff ID</th>
                            <th><i class="fas fa-globe me-1"></i>IP Address</th>
                            <th><i class="fas fa-browser me-1"></i>User Agent</th>
                            <th><i class="fas fa-desktop me-1"></i>Device</th>
                            <th><i class="fas fa-laptop me-1"></i>Platform</th>
                            <th><i class="fas fa-clock me-1"></i>Login Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($logs)) : ?>
                            <?php foreach ($logs as $log) : ?>
                                <tr>
                                    <td>
                                        <i class="fas fa-user-circle text-primary me-2"></i>
                                        <?= esc($log->staff_id) ?>
                                    </td>
                                    <td>
                                        <i class="fas fa-map-marker-alt text-success me-2"></i>
                                        <?= esc($log->ip_address) ?>
                                    </td>
                                    <td>
                                        <small>
                                            <i class="fas fa-info-circle text-muted me-1"></i>
                                            <?= esc($log->user_agent) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <?php
                                        $deviceIcon = 'fas fa-desktop';
                                        $deviceColor = 'text-info';
                                        if (stripos($log->device_type, 'mobile') !== false) {
                                            $deviceIcon = 'fas fa-mobile-alt';
                                            $deviceColor = 'text-success';
                                        } elseif (stripos($log->device_type, 'tablet') !== false) {
                                            $deviceIcon = 'fas fa-tablet-alt';
                                            $deviceColor = 'text-warning';
                                        }
                                        ?>
                                        <i class="<?= $deviceIcon ?> <?= $deviceColor ?> me-2"></i>
                                        <?= esc($log->device_type) ?>
                                    </td>
                                    <td>
                                        <?php
                                        $platformIcon = 'fab fa-windows';
                                        $platformColor = 'text-primary';
                                        if (stripos($log->platform, 'mac') !== false || stripos($log->platform, 'ios') !== false) {
                                            $platformIcon = 'fab fa-apple';
                                            $platformColor = 'text-secondary';
                                        } elseif (stripos($log->platform, 'linux') !== false) {
                                            $platformIcon = 'fab fa-linux';
                                            $platformColor = 'text-dark';
                                        } elseif (stripos($log->platform, 'android') !== false) {
                                            $platformIcon = 'fab fa-android';
                                            $platformColor = 'text-success';
                                        }
                                        ?>
                                        <i class="<?= $platformIcon ?> <?= $platformColor ?> me-2"></i>
                                        <?= esc($log->platform) ?>
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar-alt text-secondary me-2"></i>
                                        <?= date('d M Y, h:i A', strtotime($log->login_time)) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    No login logs found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Required Libraries -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#loginLogsTable').DataTable({
            pageLength: 10,
            order: [[5, 'desc']], // Fixed index for login time column
            responsive: true,
            language: {
                search: "Search logs:",
                lengthMenu: "Show _MENU_ entries per page"
            }
        });
    });
</script>

<?= $this->endSection(); ?>
