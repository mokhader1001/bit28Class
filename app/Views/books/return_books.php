<?php $session = session(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Borrowed Books</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap + Icons + jQuery + SweetAlert -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body { background-color: #eaf6ff; font-family: 'Segoe UI', Arial, sans-serif; padding: 20px; }
    .page-title { font-size: 28px; font-weight: bold; margin-bottom: 20px; }
    .book-card { border-radius: 10px; overflow: hidden; transition: 0.3s ease; cursor: pointer; }
    .book-card:hover { transform: scale(1.02); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    .book-img { width: 100%; height: 200px; object-fit: cover; }
    .book-details { padding: 15px; }
    .book-title { font-weight: bold; font-size: 16px; }
    .book-author { color: #666; font-size: 14px; }
    .search-box { padding: 10px 15px; border-radius: 8px; border: 1px solid #ccc; width: 100%; margin-bottom: 20px; }
  </style>
</head>
<body>

<div class="container">
  <a href="<?= base_url('dhash') ?>" class="text-decoration-none mb-3 d-inline-block">
    <i class="bi bi-arrow-left me-1"></i> Back
  </a>

  <h2 class="page-title"><i class="bi bi-journal-bookmark-fill me-2"></i>My Borrowed Books</h2>

  <input type="text" class="search-box" placeholder="Search by title, author, or ISBN..." id="searchInput">

  <div class="row" id="bookContainer">
    <!-- Cards will be injected here -->
  </div>
</div>

<!-- Return Modal -->
<div class="modal fade" id="returnModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title"><i class="bi bi-arrow-counterclockwise me-2 text-primary"></i>Book Return Options</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="returnModalBody">
        <!-- Filled by JS -->
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
  const BASE_URL = "<?= base_url() ?>";
  let selectedBook = null;

  function loadBooks() {
    $.getJSON(BASE_URL + "fetch_borrow_book", function (response) {
      const container = $("#bookContainer");
      container.empty();

      if (response.status && response.data.length > 0) {
        response.data.forEach(book => {
          const dueDate = new Date(book.return_date);
          const today = new Date();
          const daysLeft = Math.ceil((dueDate - today) / (1000 * 60 * 60 * 24));
          let dueColor = "text-primary";

          if (daysLeft < 0) dueColor = "text-danger";
          else if (daysLeft <= 3) dueColor = "text-warning";

          container.append(`
            <div class="col-md-4 mb-4">
              <div class="card book-card" data-book='${JSON.stringify(book)}'>
                <img src="${BASE_URL}public/uploads/books/${book.photo}" class="book-img" alt="Book Cover">
                <div class="book-details">
                  <div class="book-title">${book.title}</div>
                  <div class="book-author">by ${book.Name}</div>
                  <div>Borrowed: ${book.borrow_date}</div>
                  <div class="${dueColor}"><i class="bi bi-calendar-event me-1"></i>Due: ${book.return_date}</div>
                </div>
              </div>
            </div>
          `);
        });
      } else {
        container.html(`<div class="col-12"><div class="alert alert-warning text-center">No borrowed books found.</div></div>`);
      }
    });
  }

  loadBooks();

  $(document).on("click", ".book-card", function () {
    selectedBook = $(this).data("book");
    const today = new Date();
    const dueDate = new Date(selectedBook.return_date);
    const daysDiff = Math.ceil((dueDate - today) / (1000 * 60 * 60 * 24));
    let alertMsg = "";

    if (daysDiff < 0) {
      const overdueDays = Math.abs(daysDiff);
      alertMsg = `
        <div class="alert alert-danger mt-3 d-flex align-items-center">
          <i class="bi bi-exclamation-octagon-fill me-2 fs-5"></i>
          <div>
            <strong>Overdue:</strong> This book is <strong>${overdueDays} day(s)</strong> late.
            You may be charged. Please see the library admin.
          </div>
        </div>
      `;
    } else {
      alertMsg = `
        <div class="alert alert-warning mt-3 d-flex align-items-center">
          <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
          <div>
            <strong>Reminder:</strong> This book is due in <strong>${daysDiff} day(s)</strong>.
            Return it on time.
          </div>
        </div>
      `;
    }

    $("#returnModalBody").html(`
      <div class="d-flex mb-3">
        <img src="${BASE_URL}public/uploads/books/${selectedBook.photo}" style="width: 80px; height: 100px; object-fit: cover; margin-right: 15px;">
        <div>
          <h5>${selectedBook.title}</h5>
          <p>
            <strong>Book ID:</strong> ${selectedBook.book_id}<br>
            <strong>Borrow ID:</strong> ${selectedBook.boorow_id}<br>
            <strong>R ID:</strong> ${selectedBook.r_id}<br>
            <strong>Author:</strong> ${selectedBook.Name}<br>
            <strong>Borrowed on:</strong> ${selectedBook.borrow_date}<br>
            <strong>Due date:</strong> ${selectedBook.return_date}
          </p>
        </div>
      </div>
      ${alertMsg}
      <hr>
      <p class="fw-semibold">Select an action:</p>
      <div class="d-grid gap-2">
        <button class="btn btn-success return-btn" data-status="returned"><i class="bi bi-check-circle me-2"></i>Return Book</button>
        <button class="btn btn-warning text-dark return-btn" data-status="damaged"><i class="bi bi-exclamation-circle me-2"></i>Mark as Damaged</button>
        <button class="btn btn-danger return-btn" data-status="lost"><i class="bi bi-x-circle me-2"></i>Mark as Lost</button>
      </div>
      <div class="mt-3 text-end">
        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg me-1"></i>Cancel</button>
      </div>
    `);

    new bootstrap.Modal(document.getElementById("returnModal")).show();
  });

  $(document).on("click", ".return-btn", function () {
    const status = $(this).data("status");
    const today = new Date().toISOString().split("T")[0];

    const postData = {
      r_id: selectedBook.r_id,
      book_id: selectedBook.book_id,
      boorow_id: selectedBook.boorow_id,
      returned_date: today,
      status: status
    };

    $.post(BASE_URL + "returnbooks", postData, function (response) {
      if (response.status) {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: `Book marked as "${status.toUpperCase()}".`,
          timer: 2000,
          showConfirmButton: false
        });
        $('#returnModal').modal('hide');
        loadBooks();
      } else {
        Swal.fire('Error', response.message || 'Something went wrong!', 'error');
      }
    }).fail(function () {
      Swal.fire('Error', 'Could not send data to the server.', 'error');
    });
  });

  $("#searchInput").on("input", function () {
    const val = $(this).val().toLowerCase();
    $(".book-card").each(function () {
      const text = $(this).text().toLowerCase();
      $(this).closest(".col-md-4").toggle(text.includes(val));
    });
  });
});
</script>



</body>
</html>
