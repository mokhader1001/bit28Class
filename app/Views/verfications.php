<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Verification Code</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #f0f8ff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }
    .card-box {
      background: #fff;
      border-radius: 1rem;
      padding: 2rem 2.5rem;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 480px;
      width: 100%;
    }
    .code-input input {
      width: 48px;
      height: 56px;
      font-size: 1.5rem;
      text-align: center;
      margin: 0 5px;
      border-radius: 0.5rem;
      border: 1px solid #ccc;
    }
    .confirm-btn {
      background-color: #57bf3f;
      border: none;
      font-weight: 600;
    }
    .confirm-btn:hover {
      background-color: #4ca437;
    }
    .resend-text {
      margin-top: 15px;
      font-size: 0.9rem;
    }
    #resendBtn {
      padding: 6px 16px;
      font-weight: 500;
      border-radius: 6px;
    }
  </style>
</head>
<body>
<div class="card-box">
  <div class="mb-4">
    <div style="width: 80px; height: 80px; background: #e0ffe6; border-radius: 50%; margin: auto;">
      <i class="fas fa-check text-success" style="font-size: 2rem; padding-top: 25px;"></i>
    </div>
  </div>

  <h4>Verification Code</h4>
  <p class="text-muted mb-4" style="line-height: 1.7; font-size: 1rem;">
    We've sent a verification code to<br>
    <strong style="font-size: 1.05rem; color: #000;"><?= session()->get('email') ?? 'your email' ?></strong>.<br>
    Please enter the 6-digit code below.
  </p>

  <div class="code-input d-flex justify-content-center mb-4">
    <?php for ($i = 0; $i < 6; $i++): ?>
      <input type="text" maxlength="1" class="form-control mx-1 code-char" />
    <?php endfor; ?>
  </div>

  <button class="btn btn-success w-100 confirm-btn" id="confirmBtn">Confirm Code</button>

  <div class="resend-text mt-3">
    <span id="resendInfo">Resend in <span id="timer">30</span> seconds</span><br>
    <a href="#" id="resendBtn" class="btn btn-outline-primary btn-sm mt-2" style="display:none;">🔁 Resend Code</a>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  const base_url = "<?= base_url() ?>";
  let seconds = 30;
  let countdown;

  const timerEl = $('#timer');
  const resendBtn = $('#resendBtn');
  const resendInfo = $('#resendInfo');

  function startCountdown() {
    resendBtn.hide();
    resendInfo.show();
    seconds = 30;
    timerEl.text(seconds);

    countdown = setInterval(() => {
      seconds--;
      timerEl.text(seconds);
      if (seconds <= 0) {
        clearInterval(countdown);
        resendInfo.hide();
        resendBtn.show();
      }
    }, 1000);
  }

  // Start countdown initially
  startCountdown();

  // Handle resend code click
  resendBtn.on('click', function (e) {
    e.preventDefault();
    $.post(base_url + 'sendVerificationCode', function (res) {
      Swal.fire({
        icon: 'info',
        title: 'Code Sent!',
        text: 'A new verification code has been sent to your email.',
        timer: 2000,
        showConfirmButton: false
      });
      startCountdown();
    });
  });

  // Handle confirm
  $('#confirmBtn').on('click', function () {
    const code = $('.code-char').map(function () {
      return $(this).val();
    }).get().join('');

    if (code.length === 6) {
      $.ajax({
        url: base_url + 'verifyCode',
        type: 'POST',
        data: { code },
        dataType: 'json',
        success: function (res) {
          if (res.success) {
            window.location.href = base_url + 'dhash';
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Invalid Code',
              text: 'The code you entered is incorrect.',
              confirmButtonText: 'Try Again'
            }).then(() => {
              $('.code-char').val('').first().focus();
            });
          }
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: 'Server Error',
            text: 'Please try again later.'
          });
        }
      });
    } else {
      Swal.fire({
        icon: 'warning',
        title: 'Incomplete Code',
        text: 'Please enter the full 6-digit code.'
      });
    }
  });

  // Auto move to next input
  $('.code-char').on('input', function () {
    if (this.value.length === 1) {
      $(this).next('.code-char').focus();
    }
  });

  // Handle pasting 6-digit code
  $('.code-char').on('paste', function (e) {
    const pasted = e.originalEvent.clipboardData.getData('text').replace(/\s+/g, '');
    if (pasted.length === 6 && /^\d+$/.test(pasted)) {
      $('.code-char').each((i, el) => {
        $(el).val(pasted.charAt(i));
      });
      e.preventDefault();
    }
  });
</script>
</body>
</html>
