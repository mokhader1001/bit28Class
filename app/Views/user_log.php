<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Miftaah Library Card Access</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom right, #e0f7fa, #ffffff);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }

    .login-box {
      background: #fff;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 480px;
      position: relative;
    }

    .library-logo {
      width: 110px;
      height: 110px;
      object-fit: contain;
      margin: 0 auto 10px auto;
      display: block;
    }

    .header-text {
      text-align: center;
      margin-bottom: 1.8rem;
    }

    .admin-link {
      position: absolute;
      top: 15px;
      right: 20px;
      font-size: 0.92rem;
    }

    .admin-link a {
      color: #007bff;
      text-decoration: none;
    }

    .admin-link a:hover {
      text-decoration: underline;
    }

    .info-box {
      font-size: 0.87rem;
      color: #555;
      margin-top: 2rem;
    }
  </style>
</head>
<body>

<div class="login-box text-center">
  <div class="admin-link">
    <i class="fas fa-lock"></i> <a href="<?= base_url('Admin') ?>">Admin Panel</a>
  </div>

  <img src="<?= base_url('public/uploads/logo.png') ?>" alt="Miftaah Library Logo" class="library-logo">

  <div class="header-text">
    <h4><i class="fas fa-id-card text-primary me-1"></i> Library Card Access</h4>
    <p class="text-muted">Place your library card on the scanner to continue.</p>
    </div>

    <form id="cardLoginForm">
  <input 
    type="text" 
    id="cardInput" 
    name="card_number" 
    class="form-control text-center" 
    placeholder="Please scan your library card to proceed" 
    autofocus 
  />
</form>



  <div class="info-box">
    <p><strong>Dhobaale Library</strong> provides equitable access to resources for students. Use your card for borrowing, digital archives, and study rooms. Respect library rules and enjoy your academic journey.</p>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const base_url = "<?= base_url() ?>";

$('#cardInput').on('input', function () {
  const card_number = $(this).val().trim();

  if (card_number.length > 0) {
    
    $.ajax({
      url: base_url + 'checkCardId',
      type: 'POST',
      data: { card_number },
      dataType: 'json',
      success: function (res) {
        if (res.success) {
          // Send verification code to user's email
          $.post(base_url + 'sendVerificationCode', { email: res.email }, function(sendRes) {
            if (sendRes.success) {
              Swal.fire({
                icon: 'success',
                title: 'Code Sent',
                text: 'Verification code sent to ' + res.email,
                timer: 2000,
                showConfirmButton: false
              }).then(() => {
                window.location.href = base_url + 'user/verfications';
              });
            } else {
              Swal.fire('Error', sendRes.message || 'Failed to send verification code.', 'error');
            }
          }, 'json');
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Invalid Card',
            text: res.message || 'This card is not registered.',
            showConfirmButton: false,
            timer: 2000
          });
          $('#cardInput').val('').focus();
        }
      },
      error: function () {
        Swal.fire('Error', 'Server error. Please try again.', 'error');
      }
    });
  }
});
</script>



</body>
</html>
