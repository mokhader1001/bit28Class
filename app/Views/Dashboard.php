<?php
$session = session();
$username = $session->get('username');
$cardTag  = $session->get('card_tag');
$image    = $session->get('image');

// Fallback avatar if no image
$avatar = $image ? base_url("public/uploads/library_users/" . $image) : "https://ui-avatars.com/api/?name=" . urlencode($username) . "&background=4f46e5&color=fff";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dhobaale Library - User Dashboard</title>
    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #06b6d4;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --light-bg: #f8fafc;
            --dark-text: #1e293b;
            --border-color: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-text);
            line-height: 1.6;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid white;
        }

        .dashboard-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card {
            padding: 1.5rem;
            text-align: center;
            position: relative;
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0.8;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .welcome-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .book-item {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .book-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .book-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-borrowed {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-returned {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-overdue {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .status-damaged {
            background-color: #fef3c7;
            color: #d97706;
        }

        .status-lost {
            background-color: #fecaca;
            color: #b91c1c;
        }

        .payment-card {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border: 1px solid #fca5a5;
        }

        .payment-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--danger-color);
        }

        .btn-pay {
            background: linear-gradient(135deg, var(--success-color), #059669);
            border: none;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
            color: white;
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--dark-text);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .action-btn {
            background: white;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 1rem;
            text-decoration: none;
            color: var(--dark-text);
            transition: all 0.3s ease;
            text-align: center;
        }

        .action-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.15);
        }

        .progress-ring {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
        }

        .progress-ring circle {
            fill: none;
            stroke-width: 8;
            stroke-linecap: round;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        .progress-ring .bg {
            stroke: #e2e8f0;
        }

        .progress-ring .progress {
            stroke: var(--primary-color);
            stroke-dasharray: 251.2;
            stroke-dashoffset: 125.6;
            transition: stroke-dashoffset 0.5s ease;
        }

        .modal-content {
            border-radius: 15px;
            border: none;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 15px 15px 0 0;
        }

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background-color: #f8fafc;
            border: none;
            font-weight: 600;
            color: var(--dark-text);
        }

        .table td {
            border: none;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        /* Payment method styles */
        .payment-method-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .payment-method-option {
            flex: 1;
            min-width: 120px;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 15px 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .payment-method-option:hover {
            border-color: var(--primary-color);
            background-color: #f8fafc;
        }

        .payment-method-option.selected {
            border-color: var(--primary-color);
            background-color: #eff6ff;
        }

        .payment-method-option i {
            font-size: 24px;
            margin-bottom: 8px;
            display: block;
        }

        .payment-method-option span {
            display: block;
            font-size: 14px;
            font-weight: 500;
        }

        .payment-form-section {
            display: none;
        }

        .payment-form-section.active {
            display: block;
        }

        /* Fee type styles */
        .fee-type-tabs {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }

        .fee-type-tab {
            padding: 10px 20px;
            cursor: pointer;
            font-weight: 500;
            border-bottom: 3px solid transparent;
            transition: all 0.2s ease;
        }

        .fee-type-tab:hover {
            color: var(--primary-color);
        }

        .fee-type-tab.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .fee-type-content {
            display: none;
        }

        .fee-type-content.active {
            display: block;
        }

        .fee-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 10px;
            background-color: #f8fafc;
            border-left: 4px solid var(--primary-color);
        }

        .fee-item.overdue {
            border-left-color: var(--danger-color);
        }

        .fee-item.lost {
            border-left-color: var(--warning-color);
        }

        .fee-item.damaged {
            border-left-color: var(--info-color);
        }

        .fee-checkbox {
            margin-right: 10px;
        }

        .fee-details {
            flex-grow: 1;
        }

        .fee-amount {
            font-weight: 600;
            color: var(--danger-color);
        }

        .total-section {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        @media (max-width: 768px) {
            .quick-actions {
                grid-template-columns: 1fr;
            }
            
            .stat-card {
                padding: 1rem;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }

            .payment-method-option {
                min-width: 100px;
                padding: 10px 5px;
            }

            .fee-type-tabs {
                overflow-x: auto;
                white-space: nowrap;
            }

            .fee-type-tab {
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-book-open me-2"></i>
            Dhobaale Library
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-bell me-1"></i> Notifications</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <img src="<?= esc($avatar) ?>" alt="User" class="user-avatar me-2 rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                        <?= esc($username) ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item-text">
                            <div class="small text-muted">Card: <strong><?= esc($cardTag) ?></strong></div>
                        </li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container mt-4">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-2">Welcome back,     <?= esc($username) ?>
                    !</h2>
                    <p class="mb-0">Here's your library activity summary. You have 2 books currently borrowed and 1 overdue item.</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="progress-ring">
                        <svg width="80" height="80">
                            <circle class="bg" cx="40" cy="40" r="36"></circle>
                            <circle class="progress" cx="40" cy="40" r="36"></circle>
                        </svg>
                    </div>
                    <small>Library Score: 85%</small>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
          <a href="<?= base_url('borrow') ?>" class="action-btn">
                <i class="fas fa-plus-circle fa-2x text-success mb-2"></i>
                <div>Borrow New Book</div>
            </a>

           <a href="<?= base_url('return') ?>" class="action-btn">
                <i class="fas fa-undo fa-2x text-primary mb-2"></i>
                <div>Return Books</div>
                        </a>
            <a href="#" class="action-btn" onclick="showPaymentModal()">
                <i class="fas fa-credit-card fa-2x text-warning mb-2"></i>
                <div>Make Payment</div>
            </a>
<a href="<?= base_url('Rules_for_Users') ?>" class="action-btn">
    <i class="fas fa-book-reader fa-2x text-primary mb-2"></i>
    <div>Library Rules</div>
</a>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="dashboard-card stat-card">
                    <i class="fas fa-book-reader stat-icon text-primary"></i>
                    <div class="stat-number">3</div>
                    <div class="stat-label">Currently Borrowed</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="dashboard-card stat-card">
                    <i class="fas fa-check-circle stat-icon text-success"></i>
                    <div class="stat-number">27</div>
                    <div class="stat-label">Books Returned</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="dashboard-card stat-card">
                    <i class="fas fa-exclamation-triangle stat-icon text-warning"></i>
                    <div class="stat-number">1</div>
                    <div class="stat-label">Overdue</div>
                </div>
            </div>
          <div class="col-md-3 col-sm-6 mb-3">
            <div class="dashboard-card stat-card">
                <i class="fas fa-dollar-sign stat-icon text-danger"></i>
                <div class="stat-number">$<?= number_format($balanceSummary, 2) ?></div>
                <div class="stat-label">Outstanding Fees</div>
            </div>
        </div>

        </div>
<div class="row">
    <!-- Left Side: Recent Activity Table (col-lg-8) -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 text-primary">
                    <i class="fas fa-history me-2 text-info"></i>Recent Activity
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Book Title</th>
                                <th>Action</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Fee</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentReturns)): ?>
                                <?php foreach ($recentReturns as $row): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-semibold"><?= esc($row['title']) ?></div>
                                            <small class="text-muted"><?= esc($row['Name']) ?></small>
                                        </td>
                                        <td><span class="badge bg-primary">Returned</span></td>
                                        <td><?= date('M d, Y', strtotime($row['retuned_date'])) ?></td>
                                        <td>
                                            <?php if (!empty($row['price']) && $row['price'] > 0): ?>
                                                <span class="badge bg-warning text-dark">Charged</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle me-1"></i> Returned
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($row['price']) && $row['price'] > 0): ?>
                                                <span class="text-danger fw-bold">$
                                                    <?= number_format($row['price'], 2) ?></span><br>
                                                <small class="text-muted">
                                                    <?= esc($row['desriptions']) ?></small>
                                            <?php else: ?>
                                                <span class="text-success fw-bold">$0.00</span><br>
                                                <small class="text-muted">Returned</small>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted p-4">
                                        <i class="fas fa-info-circle me-1"></i> No recent activity found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <!-- Outstanding Payments -->
        <div class="dashboard-card payment-card mb-3">
            <div class="card-body text-center">
        <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
        <h6>Outstanding Fees</h6>
        <div class="payment-amount">
            $<?= number_format($balanceSummary ?? 0, 2) ?>
        </div>
        <p class="small text-muted mb-3">
            Includes overdue, lost, and damaged book fees
        </p>

        <?php if (!empty($balanceSummary) && $balanceSummary > 0): ?>
            <button class="btn btn-pay" onclick="showPaymentModal()">
                <i class="fas fa-credit-card me-1"></i>Pay Now
            </button>
        <?php endif; ?>
    </div>


        <!-- Account Status -->
        <div class="dashboard-card">
            <div class="card-header bg-transparent border-0">
                <h6 class="section-title mb-0">
                    <i class="fas fa-user-circle text-info"></i>
                    Account Status
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Member Since:</span>
                    <strong>Jan 2023</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Books Read:</span>
                    <strong>47</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Current Limit:</span>
                    <strong>5 books</strong>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span>Status:</span>
                    <span class="badge bg-success">Active</span>
                </div>
                <div class="progress mb-2" style="height: 8px;">
                    <div class="progress-bar bg-primary" style="width: 60%"></div>
                </div>
                <small class="text-muted">3 of 5 books borrowed</small>
            </div>
        </div>
    </div>
</div>
</div>

    </div>

    <!-- Payment Modal -->
   <!-- Payment Modal -->
<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel">
          <i class="fas fa-credit-card me-2"></i>Make Payment
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

        <!-- Tabs -->
        <ul class="nav nav-tabs" id="feeTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">All</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="overdue-tab" data-bs-toggle="tab" data-bs-target="#overdue" type="button" role="tab">Late Fees</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="lost-tab" data-bs-toggle="tab" data-bs-target="#lost" type="button" role="tab">Lost Books</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="damaged-tab" data-bs-toggle="tab" data-bs-target="#damaged" type="button" role="tab">Damaged Books</button>
          </li>
        </ul>

        <!-- Tab Contents -->
        <div class="tab-content pt-3">
          <?php 
          $categories = ['all' => 'All', 'overdue' => 'Late Fees', 'lost' => 'Lost Books', 'damaged' => 'Damaged Books'];
          foreach ($categories as $catKey => $catLabel): ?>
            <div class="tab-pane fade<?= $catKey === 'all' ? ' show active' : '' ?>" id="<?= $catKey ?>" role="tabpanel">
              <?php $index = 1; $total = 0;
              foreach ($unpaidCharges as $row): 
                $status = strtolower($row['status']);
                $isCategory = $catKey === 'all' || 
                              ($catKey === 'overdue' && $status === 'returned' && strtotime($row['retuned_date']) > strtotime($row['return_date'])) ||
                              ($catKey === 'lost' && $status === 'lost') ||
                              ($catKey === 'damaged' && $status === 'damaged');
                if ($isCategory):
                  $total += $row['balance_due']; ?>
                  
                  <!-- ✅ Added charge_id -->
                  <div class="fee-item <?= $status ?>" data-charge-id="<?= $row['charge_id'] ?>">
                    <div class="form-check fee-checkbox">
                      <input class="form-check-input charge-checkbox" type="checkbox" value="<?= $row['balance_due'] ?>" id="<?= $catKey ?>Fee<?= $index ?>" checked>
                      <label class="form-check-label" for="<?= $catKey ?>Fee<?= $index ?>"></label>
                    </div>
                    <div class="fee-details">
                      <strong><?= esc($row['title']) ?></strong> by <?= esc($row['Name']) ?>
                      <div class="small text-muted">
                        <?= ucfirst($status) ?> on <?= date('F d, Y', strtotime($row['charge_date'])) ?>
                      </div>
                    </div>
                    <div class="fee-amount">
                      $<?= number_format($row['balance_due'], 2) ?>
                    </div>
                  </div>
              <?php $index++; endif; endforeach; ?>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Subtotal Display -->
        <div class="mt-3 fw-bold" id="totalAmount">Subtotal: $0.00</div>

        <!-- Payment Methods Selection -->
        <div class="mt-4">
          <h6 class="fw-bold mb-3">Select Payment Method</h6>
          <div class="payment-method-selector d-flex flex-wrap gap-3">
            <?php $methods = ['salaam' => 'Salam Bank', 'premier' => 'Premier', 'waafi' => 'Wafi', 'paypal' => 'PayPal']; ?>
            <?php foreach ($methods as $key => $name): ?>
              <div class="payment-method-option" data-method="<?= $key ?>" onclick="selectPaymentMethod('<?= $key ?>')">
                <img src="<?= base_url('public/uploads/banks/' . $key . '.JPEG') ?>" alt="<?= $name ?>" style="width: 40px; height: 40px;" class="me-2">
                <span><?= $name ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Payment Forms -->
        <form id="paymentForm">

<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">          <div id="salaamForm" class="payment-form-section active">
            <div class="mb-3">
              <label class="form-label">Card Number</label>
              <input type="text" class="form-control" placeholder="1234 5678 9012 3456" id="salaamCardNumber">
              <div class="invalid-feedback">Please enter a valid 16-digit card number.</div>
            </div>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">Expiry</label>
                <input type="text" class="form-control" placeholder="MM/YY" id="salaamExpiry">
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">CVV</label>
                <input type="text" class="form-control" placeholder="123" id="salaamCvv">
                <div class="invalid-feedback">3-digit CVV required.</div>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Cardholder Name</label>
                <input type="text" class="form-control" placeholder="John Doe" id="salaamCardName">
                <div class="invalid-feedback">Full name required.</div>
              </div>
            </div>
          </div>

          <!-- Premier Bank Form -->
          <div id="premierForm" class="payment-form-section">
            <div class="mb-3">
              <label class="form-label">Card Number</label>
              <input type="text" class="form-control" placeholder="1234 5678 9012 3456" id="premierCardNumber">
              <div class="invalid-feedback">Please enter a valid 16-digit card number.</div>
            </div>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label">Expiry</label>
                <input type="text" class="form-control" placeholder="MM/YY" id="premierExpiry">
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">CVV</label>
                <input type="text" class="form-control" placeholder="123" id="premierCvv">
                <div class="invalid-feedback">3-digit CVV required.</div>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Cardholder Name</label>
                <input type="text" class="form-control" placeholder="Mohamed" id="premierCardName">
                <div class="invalid-feedback">Full name required.</div>
              </div>
            </div>
          </div>

          <!-- Wafi Form -->
          <div id="waafiForm" class="payment-form-section">
            <div class="mb-3">
              <label class="form-label">Account Number</label>
              <input type="text" class="form-control" placeholder="Enter account number" id="waafiAccount">
              <div class="invalid-feedback">Account number is required.</div>
            </div>
            <div class="mb-3">
              <label class="form-label">Account Holder Name</label>
              <input type="text" class="form-control" placeholder="Mohamed" id="waafiName">
              <div class="invalid-feedback">Full name required.</div>
            </div>
            <div class="mb-3">
              <label class="form-label">Phone Number</label>
              <input type="text" class="form-control" placeholder="+252XXXXXXX" id="waafiPhone">
              <div class="invalid-feedback">Valid phone number required.</div>
            </div>
          </div>

          <!-- PayPal Form -->
          <div id="paypalForm" class="payment-form-section">
            <div class="mb-3">
              <label class="form-label">PayPal Email</label>
              <input type="email" class="form-control" placeholder="you@example.com" id="paypalEmail">
              <div class="invalid-feedback">A valid email is required.</div>
            </div>
          </div>

        </form>

      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" id="payButton">
          <i class="fas fa-lock me-1"></i>Pay <span id="payButtonAmount">$0.00</span>
        </button>
      </div>

    </div>
  </div>
</div>


<!-- JavaScript Logic -->

  
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
<script>
document.addEventListener('DOMContentLoaded', function () {
  selectPaymentMethod('salaam');
  setupTabListeners();
  addCheckboxListeners();
  updateTotalAmount();
  document.getElementById('payButton').addEventListener('click', handlePayClick);
});
function showPaymentModal() {
  const modal = new bootstrap.Modal(document.getElementById('paymentModal'));
  modal.show();
}
// Handle Payment Click
function handlePayClick() {
  const activeTab = document.querySelector('.tab-pane.show.active');
  const checkboxes = activeTab.querySelectorAll('.fee-checkbox input[type="checkbox"]:checked');
  const selectedCharges = [];
  const seenTitles = new Set(); // Prevent duplicates

  let totalAmount = 0;

  checkboxes.forEach(checkbox => {
    const feeItem = checkbox.closest('.fee-item');
    if (!feeItem) return;

    const amountText = feeItem.querySelector('.fee-amount')?.textContent || '';
    const amount = parseFloat(amountText.replace('$', '').trim());
    const title = feeItem.querySelector('strong')?.textContent || '';
    const statusText = feeItem.classList.contains('damaged') ? 'damaged' :
                       feeItem.classList.contains('lost') ? 'lost' :
                       feeItem.classList.contains('returned') ? 'returned' : 'unknown';

    // Avoid duplicate charges by title and status
    const uniqueKey = `${title}-${statusText}`;
    if (!seenTitles.has(uniqueKey) && !isNaN(amount)) {
      seenTitles.add(uniqueKey);
      totalAmount += amount;
      selectedCharges.push({ amount, title, status: statusText });
    }
  });

  if (selectedCharges.length === 0) {
    alert("Please select at least one charge to pay.");
    return;
  }

  const paymentMethodEl = document.querySelector('.payment-method-option.selected');
  if (!paymentMethodEl) {
    alert("Please select a payment method.");
    return;
  }

  const paymentMethod = paymentMethodEl.getAttribute('data-method');
  let formData = {};

  if (paymentMethod === 'salaam' || paymentMethod === 'premier') {
    const prefix = paymentMethod;
    formData = {
      card_number: document.getElementById(`${prefix}CardNumber`).value.trim(),
      expiry: document.getElementById(`${prefix}Expiry`).value.trim(),
      cvv: document.getElementById(`${prefix}Cvv`).value.trim(),
      card_name: document.getElementById(`${prefix}CardName`).value.trim()
    };
  } else if (paymentMethod === 'waafi') {
    formData = {
      account_number: document.getElementById('waafiAccount').value.trim(),
      account_name: document.getElementById('waafiName').value.trim(),
      phone: document.getElementById('waafiPhone').value.trim()
    };
  } else if (paymentMethod === 'paypal') {
    formData = {
      paypal_email: document.getElementById('paypalEmail').value.trim()
    };
  }

  // Combine everything into one payload object
  const payload = {
    charges: selectedCharges,
    total: totalAmount.toFixed(2),
    payment_method: paymentMethod,
    form_data: formData
  };

  // Build query string from payload
  const queryString = new URLSearchParams({
    data: JSON.stringify(payload)
  }).toString();

  // Send GET request with query string
  fetch("<?= base_url('makepayment') ?>?" + queryString, {
    method: "GET"
  })
  .then(res => res.json())
  .then(response => {
    if (response.status === 'success') {
      alert("Payment successful");
      location.reload();
    } else {
      alert("Payment failed: " + response.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert("An error occurred while submitting payment.");
  });
}

// Payment Method Selection
function selectPaymentMethod(method) {
  document.querySelectorAll('.payment-method-option').forEach(el => el.classList.remove('selected'));
  document.querySelector(`.payment-method-option[data-method="${method}"]`)?.classList.add('selected');
  document.querySelectorAll('.payment-form-section').forEach(form => form.classList.remove('active'));
  document.getElementById(`${method}Form`)?.classList.add('active');
}

// Update Total Display
function updateTotalAmount() {
  let total = 0;
  const activeTab = document.querySelector('.tab-pane.show.active');
  if (!activeTab) return;
  const checkboxes = activeTab.querySelectorAll('.fee-checkbox input[type="checkbox"]:checked');
  checkboxes.forEach(checkbox => {
    const feeItem = checkbox.closest('.fee-item');
    const amountText = feeItem.querySelector('.fee-amount')?.textContent || '';
    const amount = parseFloat(amountText.replace('$', '').trim());
    if (!isNaN(amount)) total += amount;
  });
  document.getElementById('totalAmount').textContent = `Subtotal: $${total.toFixed(2)}`;
  document.getElementById('payButtonAmount').textContent = `$${total.toFixed(2)}`;
}

// Tab Switch Listener
function setupTabListeners() {
  document.querySelectorAll('[data-bs-toggle="tab"]').forEach(button => {
    button.addEventListener('shown.bs.tab', updateTotalAmount);
  });
}

// Checkbox Listeners (Cleaned)
function addCheckboxListeners() {
  document.querySelectorAll('.fee-checkbox input[type="checkbox"]').forEach(cb => {
    cb.removeEventListener('change', updateTotalAmount);
    cb.addEventListener('change', updateTotalAmount);
  });
}

// First: ensure no duplicate listeners using removeEventListener
const payButton = document.getElementById('payButton');
payButton.removeEventListener('click', handlePayClick); // Prevent double binding
payButton.addEventListener('click', handlePayClick);     // Add once only

function handlePayClick() {
  const btn = this;

  if (btn.disabled) return; // Prevent if already clicked
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';

  const activeTab = document.querySelector('.tab-pane.show.active');
  const checkboxes = activeTab.querySelectorAll('.fee-checkbox input[type="checkbox"]:checked');
  const selectedCharges = [];
  const seen = new Set();
  let totalAmount = 0;

  checkboxes.forEach(checkbox => {
    const feeItem = checkbox.closest('.fee-item');
    if (!feeItem) return;

    const amountText = feeItem.querySelector('.fee-amount')?.textContent || '';
    const amount = parseFloat(amountText.replace('$', '').trim());
    const title = feeItem.querySelector('strong')?.textContent || '';
    const chargeId = feeItem.getAttribute('data-charge-id');
    const statusText = feeItem.classList.contains('damaged') ? 'damaged' :
                       feeItem.classList.contains('lost') ? 'lost' :
                       feeItem.classList.contains('returned') ? 'returned' : 'unknown';

    const key = `${title}-${statusText}`;
    if (!seen.has(key) && !isNaN(amount) && chargeId) {
      seen.add(key);
      totalAmount += amount;
      selectedCharges.push({
        charge_id: chargeId,
        amount,
        title,
        status: statusText
      });
    }
  });

  if (selectedCharges.length === 0) {
    alert("Please select at least one charge.");
    resetPayButton(btn);
    return;
  }

  const paymentMethodEl = document.querySelector('.payment-method-option.selected');
  if (!paymentMethodEl) {
    alert("Please select a payment method.");
    resetPayButton(btn);
    return;
  }

  const paymentMethod = paymentMethodEl.getAttribute('data-method');
  let formData = {};

  if (paymentMethod === 'salaam') {
    formData = {
      card_number: document.getElementById('salaamCardNumber').value.trim(),
      expiry: document.getElementById('salaamExpiry').value.trim(),
      cvv: document.getElementById('salaamCvv').value.trim(),
      card_name: document.getElementById('salaamCardName').value.trim()
    };
  } else if (paymentMethod === 'premier') {
    formData = {
      card_number: document.getElementById('premierCardNumber').value.trim(),
      expiry: document.getElementById('premierExpiry').value.trim(),
      cvv: document.getElementById('premierCvv').value.trim(),
      card_name: document.getElementById('premierCardName').value.trim()
    };
  } else if (paymentMethod === 'waafi') {
    formData = {
      account_number: document.getElementById('waafiAccount').value.trim(),
      account_name: document.getElementById('waafiName').value.trim(),
      phone: document.getElementById('waafiPhone').value.trim()
    };
  } else if (paymentMethod === 'paypal') {
    formData = {
      paypal_email: document.getElementById('paypalEmail').value.trim()
    };
  }

  const payload = {
    charges: selectedCharges,
    total: totalAmount.toFixed(2),
    payment_method: paymentMethod,
    form_data: formData
  };

  fetch("<?= base_url('makepayment') ?>", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(payload)
  })
  .then(res => res.json())
  .then(response => {
    console.log(response);
    alert("Payment submitted successfully!");
    // optionally reset or redirect
  })
  .catch(error => {
    console.error(error);
    alert("An error occurred while submitting payment.");
    resetPayButton(btn); // Re-enable on error
  });
}

// Reset the button (used on error or validation fail)
function resetPayButton(btn) {
  btn.disabled = false;
  btn.innerHTML = '<i class="fas fa-lock me-1"></i> Pay <span id="payButtonAmount">$0.00</span>';
}


</script>

</body>
</html>