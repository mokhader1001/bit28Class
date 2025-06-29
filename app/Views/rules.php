<?= $this->extend('index') ?>
<?= $this->section('content') ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
  :root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    --dark-gradient: linear-gradient(135deg, #434343 0%, #000000 100%);
    
    --bg-primary: #f8fafc;
    --bg-secondary: #ffffff;
    --text-primary: #1a202c;
    --text-secondary: #718096;
    --border-color: #e2e8f0;
    --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background: var(--bg-primary);
    color: var(--text-primary);
    line-height: 1.6;
  }

  .policy-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
  }

  .page-header {
    background: var(--bg-secondary);
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
  }

  .page-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: var(--primary-gradient);
  }

  .page-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 0.5rem;
  }

  .page-header p {
    color: var(--text-secondary);
    font-size: 1.1rem;
    margin: 0;
  }

  .policy-form-container {
    background: var(--bg-secondary);
    border-radius: 20px;
    box-shadow: var(--shadow-xl);
    overflow: hidden;
  }

  .custom-nav-tabs {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border: none;
    padding: 1rem 2rem 0;
    margin: 0;
  }

  .custom-nav-tabs .nav-item {
    margin-right: 0.5rem;
  }

  .custom-nav-tabs .nav-link {
    border: none;
    border-radius: 15px 15px 0 0;
    padding: 1rem 2rem;
    font-weight: 600;
    font-size: 1rem;
    color: var(--text-secondary);
    background: transparent;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
  }

  .custom-nav-tabs .nav-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--primary-gradient);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
  }

  .custom-nav-tabs .nav-link:hover {
    color: #667eea;
    transform: translateY(-2px);
  }

  .custom-nav-tabs .nav-link.active {
    background: var(--bg-secondary);
    color: var(--text-primary);
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
  }

  .custom-nav-tabs .nav-link.active::before {
    opacity: 0.1;
  }

  .tab-content {
    padding: 0;
  }

  .tab-pane {
    padding: 2.5rem;
    min-height: 500px;
  }

  .policy-card {
    border: none;
    border-radius: 0;
    background: transparent;
    padding: 0;
  }

  .policy-section-header {
    display: flex;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--border-color);
  }

  .policy-section-header .icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-right: 1rem;
  }

  .policy-section-header .borrow-icon {
    background: var(--primary-gradient);
  }

  .policy-section-header .late-icon {
    background: var(--warning-gradient);
  }

  .policy-section-header .damage-icon {
    background: var(--danger-gradient);
  }

  .policy-section-header h5 {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
    color: var(--text-primary);
  }

  .form-group {
    margin-bottom: 2rem;
  }

  .form-label {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
  }

  .form-label i {
    margin-right: 0.5rem;
    color: var(--text-secondary);
  }

  .form-control {
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 0.875rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: var(--bg-primary);
  }

  .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: var(--bg-secondary);
  }

  .form-control::placeholder {
    color: var(--text-secondary);
    opacity: 0.7;
  }

  .input-group {
    position: relative;
  }

  .input-addon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
    font-weight: 500;
    z-index: 10;
  }

  .form-control.has-addon {
    padding-right: 3rem;
  }

  .form-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
  }

  .action-buttons {
    padding: 2rem 2.5rem;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
  }

  .btn {
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    border: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
  }

  .btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
  }

  .btn:hover::before {
    left: 100%;
  }

  .btn-secondary {
    background: #6c757d;
    color: white;
  }

  .btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
  }

  .btn-success {
    background: var(--success-gradient);
    color: white;
  }

  .btn-success:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
  }

  .info-card {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border: 1px solid #90caf9;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
  }

  .info-card .info-icon {
    color: #1976d2;
    font-size: 1.25rem;
    margin-right: 0.75rem;
  }

  .info-card h6 {
    color: #1565c0;
    font-weight: 600;
    margin-bottom: 0.5rem;
  }

  .info-card p {
    color: #1976d2;
    margin: 0;
    font-size: 0.9rem;
  }

  .percentage-indicator {
    display: inline-flex;
    align-items: center;
    background: rgba(102, 126, 234, 0.1);
    color: #667eea;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-left: 0.5rem;
  }

  .loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
  }

  .loading-spinner {
    width: 50px;
    height: 50px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: #667eea;
    animation: spin 1s ease-in-out infinite;
  }

  @keyframes spin {
    to { transform: rotate(360deg); }
  }

  @media (max-width: 768px) {
    .policy-container {
      padding: 1rem;
    }

    .page-header {
      padding: 1.5rem;
      text-align: center;
    }

    .page-header h1 {
      font-size: 2rem;
    }

    .custom-nav-tabs {
      padding: 0.5rem 1rem 0;
    }

    .custom-nav-tabs .nav-link {
      padding: 0.75rem 1rem;
      font-size: 0.9rem;
    }

    .tab-pane {
      padding: 1.5rem;
    }

    .form-row {
      grid-template-columns: 1fr;
    }

    .action-buttons {
      padding: 1.5rem;
      flex-direction: column;
    }

    .btn {
      width: 100%;
    }
  }

  @media (max-width: 576px) {
    .custom-nav-tabs .nav-link {
      padding: 0.5rem 0.75rem;
      font-size: 0.8rem;
    }

    .policy-section-header {
      flex-direction: column;
      text-align: center;
    }

    .policy-section-header .icon {
      margin-right: 0;
      margin-bottom: 1rem;
    }
  }
</style>

<div class="policy-container">
  <!-- Page Header -->
  <div class="page-header" style="margin-top: -5%;">
    <p>Configure borrowing rules, penalties, and damage policies for your library system</p>
  </div>

  <!-- Policy Form -->
  <div class="policy-form-container">
  <form id="libraryPolicyForm">
  <input type="hidden" class="form-control" id="id" name="id" value="<?= isset($policy->id) ? $policy->id : '' ?>">

  <!-- Custom Navigation Tabs -->
  <ul class="nav nav-tabs custom-nav-tabs" id="policyTabs" role="tablist">
    <li class="nav-item">
      <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#borrow" type="button">
        <i class="fas fa-book-open me-2"></i>Borrowing Policy
      </button>
    </li>
    <li class="nav-item">
      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#late" type="button">
        <i class="fas fa-clock me-2"></i>Late Returns
      </button>
    </li>
    <li class="nav-item">
      <button class="nav-link" data-bs-toggle="tab" data-bs-target="#damage" type="button">
        <i class="fas fa-exclamation-triangle me-2"></i>Damages & Loss
      </button>
    </li>
  </ul>

  <div class="tab-content p-4">
    <!-- Borrowing Tab -->
    <div class="tab-pane fade show active" id="borrow" role="tabpanel">
      <div class="policy-card">
        <div class="policy-section-header">
          <div class="icon borrow-icon">
            <i class="fas fa-book-open"></i>
          </div>
          <h5>Borrowing Policy Configuration</h5>
        </div>

        <div class="info-card">
          <div class="d-flex align-items-start">
            <i class="fas fa-info-circle info-icon"></i>
            <div>
              <h6>Borrowing Guidelines</h6>
              <p>Set the maximum number of books users can borrow simultaneously and add any special borrowing conditions.</p>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="maxBooks" class="form-label">
              <i class="fas fa-hashtag"></i>Maximum Books Per User
            </label>
            <div class="input-group">
              <input type="number" class="form-control has-addon" id="maxBooks" name="max_books" 
                     value="<?= isset($policy->max_books) ? $policy->max_books : '' ?>"
                     placeholder="e.g., 5" min="1" max="50">
              <span class="input-addon">books</span>
            </div>
          </div>
        </div>


        <div class="form-group">
    <label for="minBooksReserved" class="form-label">
      <i class="fas fa-boxes"></i>Minimum Books Reserved
    </label>
    <div class="input-group">
      <input type="number" class="form-control has-addon" id="minBooksReserved" name="min_books_reserved"
             value="<?= isset($policy->min_books_reserved) ? $policy->min_books_reserved : '' ?>"
             placeholder="e.g., 2" min="0" max="100">
      <span class="input-addon">books</span>
    </div>
  </div>

        <div class="form-group">
          <label for="borrowNote" class="form-label">
            <i class="fas fa-sticky-note"></i>Additional Borrowing Notes
          </label>
          <textarea class="form-control" id="borrowNote" name="borrow_note" rows="4"
                    placeholder="Enter any special borrowing conditions, restrictions, or guidelines..."><?= isset($policy->borrowing_note) ? $policy->borrowing_note : '' ?></textarea>
        </div>
      </div>
    </div>

    <!-- Late Returns Tab -->
    <div class="tab-pane fade" id="late" role="tabpanel">
      <div class="policy-card">
        <div class="policy-section-header">
          <div class="icon late-icon">
            <i class="fas fa-clock"></i>
          </div>
          <h5>Late Return Policy Configuration</h5>
        </div>

        <div class="info-card">
          <div class="d-flex align-items-start">
            <i class="fas fa-exclamation-circle info-icon"></i>
            <div>
              <h6>Late Return Penalties</h6>
              <p>Configure daily penalty fees and account suspension rules for overdue books.</p>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="penalty" class="form-label">
              <i class="fas fa-dollar-sign"></i>Daily Penalty Fee
            </label>
            <div class="input-group">
              <input type="number" class="form-control has-addon" id="penalty" name="penalty_per_day" 
                     step="0.01" min="0" max="100"
                     value="<?= isset($policy->penalty_per_day) ? $policy->penalty_per_day : '' ?>"
                     placeholder="e.g., 1.50">
              <span class="input-addon">$/day</span>
            </div>
          </div>

          <div class="form-group">
            <label for="max_books_per_day" class="form-label">
              <i class="fas fa-book-reader"></i>Borrowing Limit (in Days) per Book
            </label>
            <div class="input-group">
              <input type="number" class="form-control has-addon" id="max_books_per_day" name="max_books_per_day"
                     min="1" max="20"
                     value="<?= isset($policy->max_days_allowed) ? $policy->max_days_allowed : '' ?>"
                     placeholder="e.g., 3">
              <span class="input-addon">books/day</span>
            </div>
          </div>

          <div class="form-group">
            <label for="suspendAfter" class="form-label">
              <i class="fas fa-ban"></i>Suspend Account After
            </label>
            <div class="input-group">
              <input type="number" class="form-control has-addon" id="suspendAfter" name="suspend_after_days"
                     min="1" max="365"
                     value="<?= isset($policy->suspend_after_days) ? $policy->suspend_after_days : '' ?>"
                     placeholder="e.g., 30">
              <span class="input-addon">days</span>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="lateNote" class="form-label">
            <i class="fas fa-file-alt"></i>Late Return Policy Notes
          </label>
          <textarea class="form-control" id="lateNote" name="late_note" rows="4"
                    placeholder="Additional notes about grace periods, suspension procedures, or special conditions..."><?= isset($policy->late_note) ? $policy->late_note : '' ?></textarea>
        </div>
      </div>
    </div>

    <!-- Damages & Deletion Tab -->
    <div class="tab-pane fade" id="damage" role="tabpanel">
      <div class="policy-card">
        <div class="policy-section-header">
          <div class="icon damage-icon">
            <i class="fas fa-exclamation-triangle"></i>
          </div>
          <h5>Damage & Loss Policy Configuration</h5>
        </div>

        <div class="info-card">
          <div class="d-flex align-items-start">
            <i class="fas fa-shield-alt info-icon"></i>
            <div>
              <h6>Damage & Loss Fees</h6>
              <p>Set percentage-based fees for different types of book damage and loss. Fees are calculated based on the book's original price.</p>
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="minorDamage" class="form-label">
              <i class="fas fa-band-aid"></i>Minor Damage Fee
              <span class="percentage-indicator">% of book price</span>
            </label>
            <div class="input-group">
              <input type="number" class="form-control has-addon" id="minorDamage" name="minor_damage_fee"
                     min="0" max="100"
                     value="<?= isset($policy->minor_damage_fee) ? $policy->minor_damage_fee : '' ?>"
                     placeholder="e.g., 25">
              <span class="input-addon">%</span>
            </div>
          </div>

          <div class="form-group">
            <label for="majorDamage" class="form-label">
              <i class="fas fa-tools"></i>Major Damage Fee
              <span class="percentage-indicator">% of book price</span>
            </label>
            <div class="input-group">
              <input type="number" class="form-control has-addon" id="majorDamage" name="major_damage_fee"
                     min="0" max="100"
                     value="<?= isset($policy->major_damage_fee) ? $policy->major_damage_fee : '' ?>"
                     placeholder="e.g., 75">
              <span class="input-addon">%</span>
            </div>
          </div>

          <div class="form-group">
            <label for="lostBook" class="form-label">
              <i class="fas fa-search"></i>Lost Book Fee
              <span class="percentage-indicator">% of book price</span>
            </label>
            <div class="input-group">
              <input type="number" class="form-control has-addon" id="lostBook" name="lost_book_fee"
                     min="0" max="200"
                     value="<?= isset($policy->lost_book_fee) ? $policy->lost_book_fee : '' ?>"
                     placeholder="e.g., 100">
              <span class="input-addon">%</span>
            </div>
          </div>

          <div class="form-group">
            <label for="deleteAfter" class="form-label">
              <i class="fas fa-user-times"></i>Delete Account After
            </label>
            <div class="input-group">
              <input type="number" class="form-control has-addon" id="deleteAfter" name="delete_after_days"
                     min="1" max="365"
                     value="<?= isset($policy->delete_account_after_days) ? $policy->delete_account_after_days : '' ?>"
                     placeholder="e.g., 90">
              <span class="input-addon">days suspended</span>
            </div>
          </div>
        </div>

        <div class="form-group mt-4">
          <label for="damageNote" class="form-label">
            <i class="fas fa-clipboard-list"></i>Damage Policy Notes
          </label>
          <textarea class="form-control" id="damageNote" name="damage_note" rows="4"
                    placeholder="Explain damage assessment procedures, appeal processes, or special conditions..."><?= isset($policy->damage_note) ? $policy->damage_note : '' ?></textarea>
        </div>
      </div>
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="action-buttons">
    <button type="button" class="btn btn-secondary">
      <i class="fas fa-times me-2"></i>Cancel
    </button>
    <button type="button" class="btn btn-success" id="savePolicyBtn">
      <i class="fas fa-save me-2"></i>Save Policy Configuration
    </button>
  </div>
</form>
  </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
  <div class="loading-spinner"></div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // Enhanced form validation and submission
  $('#savePolicyBtn').on('click', function () {
    // Show loading overlay
    $('#loadingOverlay').show();
    
    // Disable button to prevent double submission
    $(this).prop('disabled', true);
    
    $.ajax({
      url: "<?= base_url('library-policy/save') ?>",
      type: "POST",
      data: $('#libraryPolicyForm').serialize(),
      dataType: "json",
      success: function (res) {
        $('#loadingOverlay').hide();
        $('#savePolicyBtn').prop('disabled', false);
        
        Swal.fire({
          icon: 'success',
          title: 'Policy Saved Successfully!',
          text: res.message,
          confirmButtonColor: '#667eea',
          confirmButtonText: 'Great!',
          showClass: {
            popup: 'animate__animated animate__fadeInDown'
          },
          hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
          }
        });
      },
      error: function (xhr, status, error) {
        $('#loadingOverlay').hide();
        $('#savePolicyBtn').prop('disabled', false);
        
        Swal.fire({
          icon: 'error',
          title: 'Error Saving Policy',
          text: 'Something went wrong while saving the policy. Please try again.',
          confirmButtonColor: '#d33',
          confirmButtonText: 'Try Again',
          showClass: {
            popup: 'animate__animated animate__shakeX'
          }
        });
      }
    });
  });

  // Form validation
  function validateForm() {
    let isValid = true;
    const requiredFields = ['maxBooks', 'penalty', 'suspendAfter', 'minorDamage', 'majorDamage', 'lostBook', 'deleteAfter'];
    
    requiredFields.forEach(function(fieldId) {
      const field = document.getElementById(fieldId);
      if (field && (!field.value || field.value <= 0)) {
        field.classList.add('is-invalid');
        isValid = false;
      } else if (field) {
        field.classList.remove('is-invalid');
      }
    });
    
    return isValid;
  }

  // Real-time validation
  $('input[type="number"]').on('input', function() {
    if ($(this).val() && $(this).val() > 0) {
      $(this).removeClass('is-invalid');
    }
  });

  // Enhanced tab switching with animation
  $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    const target = $(e.target).attr('data-bs-target');
    $(target).addClass('animate__animated animate__fadeInUp');
    
    setTimeout(() => {
      $(target).removeClass('animate__animated animate__fadeInUp');
    }, 500);
  });

  // Auto-save draft functionality (optional)
  let autoSaveTimer;
  $('#libraryPolicyForm input, #libraryPolicyForm textarea').on('input', function() {
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(function() {
      // Auto-save logic can be implemented here
      console.log('Auto-saving draft...');
    }, 5000);
  });

  // Keyboard shortcuts
  $(document).on('keydown', function(e) {
    // Ctrl+S to save
    if (e.ctrlKey && e.which === 83) {
      e.preventDefault();
      $('#savePolicyBtn').click();
    }
  });
</script>

<?= $this->endSection() ?>