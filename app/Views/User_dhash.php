<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dhobaale Library Options</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #eef7ff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }
    .options-box {
      background: white;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      padding: 2.5rem 2rem;
      max-width: 420px;
      width: 100%;
      text-align: center;
    }
    .options-box h4 {
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    .options-box p {
      font-size: 0.95rem;
      color: #666;
      margin-bottom: 1.5rem;
    }
    .option-button {
      display: flex;
      align-items: center;
      gap: 15px;
      padding: 1rem;
      border-radius: 10px;
      margin-bottom: 1rem;
      text-decoration: none;
      font-size: 1rem;
      transition: background 0.3s ease;
    }
    .option-button:hover {
      opacity: 0.95;
    }
    .option-icon {
      font-size: 1.6rem;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .option-text {
      text-align: left;
      line-height: 1.3;
    }
    .option-text strong {
      display: block;
      font-size: 1.05rem;
    }
    .borrow {
      background-color: #e8fce8;
      color: #28a745;
    }
    .return {
      background-color: #e7f0ff;
      color: #007bff;
    }
    .dashboard {
      background-color: #f5e7ff;
      color: #6f42c1;
    }
  </style>
</head>
<body>

  <div class="options-box">
    <h4>Welcome to Dhobaale Library</h4>
    <p>Please select an option to continue</p>

    <a href="<?= base_url('borrow') ?>" class="option-button borrow">
      <div class="option-icon"><i class="fas fa-book"></i></div>
      <div class="option-text">
        <strong>Borrow Books</strong>
        <small>Browse and borrow books from our collection</small>
      </div>
    </a>

    <a href="<?= base_url('return') ?>" class="option-button return">
      <div class="option-icon"><i class="fas fa-undo"></i></div>
      <div class="option-text">
        <strong>Return Books</strong>
        <small>Return books you've previously borrowed</small>
      </div>
    </a>

    <a href="<?= base_url('Dash') ?>" class="option-button dashboard">
      <div class="option-icon"><i class="fas fa-home"></i></div>
      <div class="option-text">
        <strong>Main Dashboard</strong>
        <small>View your account and library information</small>
      </div>
    </a>
  </div>

</body>
</html>
