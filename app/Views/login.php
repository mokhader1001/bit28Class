<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Library Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body, html {
      height: 100%;
      margin: 0;
      background: linear-gradient(135deg, #e0f2fe, #93c5fd);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', sans-serif;
    }

    .login-box {
      width: 100%;
      max-width: 520px;
      background: #fff;
      padding: 3rem 2.5rem;
      border-radius: 18px;
      box-shadow: 0 0 25px rgba(0,0,0,0.08);
    }

    .login-icon {
      font-size: 3.2rem;
      color: #0d6efd;
    }

    .header-text {
      font-size: 2rem;
      font-weight: 600;
      margin-top: 10px;
    }

    .form-control {
      padding-left: 2.5rem;
      height: 48px;
    }

    .input-icon {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #6c757d;
    }

    .position-relative {
      position: relative;
    }

    #response {
      display: none;
    }
  </style>
</head>
<body>

  <div class="login-box text-center">
    <div class="login-icon mb-3">
      <i class="fas fa-book-reader"></i>
    </div>
    <div class="header-text">Library Login</div>
    <p class="text-muted">Access your account to manage books & users</p>

    <div id="response" class="alert alert-danger"></div>

    <form id="loginForm" class="mt-4">
      <div class="mb-3 position-relative">
        <i class="fas fa-envelope input-icon"></i>
        <input type="email" name="email" class="form-control" placeholder="Email address" required>
      </div>
      <div class="mb-4 position-relative">
        <i class="fas fa-lock input-icon"></i>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">
        <i class="fas fa-sign-in-alt me-1"></i> Login
      </button>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $('#loginForm').submit(function (e) {
      e.preventDefault();
      $.ajax({
        url: "<?= base_url('auth/login') ?>",
        method: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function (res) {
          if (res.success) {
            window.location.href = "<?= base_url('body') ?>";
          } else {
            $('#response').removeClass('d-none').text(res.message).fadeIn();
          }
        },
        error: function () {
          $('#response').removeClass('d-none').text('Server error occurred.').fadeIn();
        }
      });
    });
  </script>

</body>
</html>
