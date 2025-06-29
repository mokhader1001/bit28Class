<?php $session = session(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Browse Books</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body { background-color: #eaf6ff; font-family: 'Segoe UI', Arial, sans-serif; padding: 20px; }
    .container { max-width: 1200px; margin: 0 auto; }
    .back-button { color: #333; text-decoration: none; display: inline-flex; align-items: center; margin-bottom: 20px; font-size: 16px; }
    .page-title { font-size: 24px; font-weight: 600; margin-bottom: 20px; }
    .search-container { position: relative; margin-bottom: 30px; }
    .search-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #6c757d; }
    .search-input { width: 100%; padding: 12px 12px 12px 40px; border: 1px solid #ced4da; border-radius: 8px; background-color: #fff; }
    .book-card { background-color: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; display: flex; box-shadow: 0 2px 4px rgba(0,0,0,0.05); cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; }
    .book-card:hover { transform: translateY(-3px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    .book-image { width: 100px; height: 150px; object-fit: cover; margin-right: 20px; border-radius: 4px; flex-shrink: 0; }
    .book-info { flex-grow: 1; }
    .book-title { font-size: 18px; font-weight: 600; margin-bottom: 5px; }
    .book-author { font-size: 14px; color: #666; margin-bottom: 10px; }
    .book-description { font-size: 14px; color: #666; margin-bottom: 10px; }
    .badge-available { background-color: #28a745; color: white; font-size: 12px; padding: 4px 12px; border-radius: 4px; display: inline-block; }
    .badge-unavailable { background-color: #dc3545; color: white; font-size: 12px; padding: 4px 12px; border-radius: 4px; display: inline-block; }
  </style>
</head>
<body>

<div class="container">
  <a href="<?= base_url('dhash') ?>" class="back-button"><i class="bi bi-arrow-left me-2"></i> Back</a>
  <h1 class="page-title">Browse Books</h1>

  <div class="search-container">
    <i class="bi bi-search search-icon"></i>
    <input type="text" class="search-input" placeholder="Search by title or author...">
  </div>

  <div class="row" id="book-list">
    <?php foreach ($books as $book): ?>
      <div class="col-md-6 book-item">
        <div class="book-card"
             data-book-id="<?= esc($book['book_id']) ?>"
             data-title="<?= esc($book['title']) ?>"
             data-author="<?= esc($book['Name']) ?>">
          <img src="<?= base_url('public/uploads/books/' . esc($book['photo'])) ?>" class="book-image" alt="Book Cover">
          <div class="book-info">
            <h2 class="book-title"><?= esc($book['title']) ?></h2>
            <p class="book-author">by <?= esc($book['Name']) ?></p>
            <p class="book-description"><?= esc($book['descriptions']) ?></p>
            <span class="<?= $book['status'] === 'available' ? 'badge-available' : 'badge-unavailable' ?>">
              <?= ucfirst($book['status']) ?>
            </span>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Borrow Modal -->
<div class="modal fade" id="borrowModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Borrow Book</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="borrowForm">
        <div class="modal-body">
          <input type="hidden" id="selectedBookId">
          <div class="mb-3">
            <h5 id="modalBookTitle"></h5>
            <p id="modalBookAuthor" class="text-muted"></p>
          </div>
          <div class="mb-3">
            <label for="borrowDate">Borrow Date</label>
            <input type="date" class="form-control" id="borrowDate" readonly>
          </div>
          <div class="mb-3">
            <label for="returnDate">Return Date</label>
            <input type="date" class="form-control" id="returnDate" required>
          </div>


          <!-- Info Box -->
<div class="alert alert-info d-flex align-items-center mt-3" role="alert">
  <i class="bi bi-calendar-event-fill me-3 fs-5"></i>
  <div>
    <strong id="max-days-label">Maximum Borrowing Period:</strong><br>
    <small>You can return this book between <strong id="todayFormatted"></strong> and <strong id="maxReturnFormatted"></strong>.</small>
  </div>
</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Confirm Borrow</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  const LIB_USER_ID = <?= json_encode($session->get('lib_user_id')) ?>;
  const BASE_URL = "<?= base_url() ?>";
  const maxBorrowDays = <?= json_encode($max_days) ?>;

  $(function () {
    // Utility function to format date to YYYY-MM-DD
    function formatDate(date) {
      return date.toISOString().split('T')[0];
    }

    $(document).on("click", ".book-card", function () {
      const bookId = $(this).data("book-id");
      const title = $(this).data("title");
      const author = $(this).data("author");

      const today = new Date();
      const todayFormatted = today.toISOString().split("T")[0];

      const maxReturnDate = new Date(today);
      maxReturnDate.setDate(maxReturnDate.getDate() + parseInt(maxBorrowDays));
      const maxReturnFormatted = maxReturnDate.toISOString().split("T")[0];

      // Set modal content
      $("#selectedBookId").val(bookId);
      $("#modalBookTitle").text(title);
      $("#modalBookAuthor").text("by " + author);
      $("#borrowDate").val(todayFormatted);
      $("#returnDate")
        .attr("min", todayFormatted)
        .attr("max", maxReturnFormatted)
        .val(maxReturnFormatted);

      // 👇 Format for display like MM/DD/YYYY
      function displayFormat(date) {
        return `${String(date.getMonth() + 1).padStart(2, "0")}/${String(date.getDate()).padStart(2, "0")}/${date.getFullYear()}`;
      }

      // Inject formatted dates into the info box
      $("#todayFormatted").text(displayFormat(today));
      $("#maxReturnFormatted").text(displayFormat(maxReturnDate));

      new bootstrap.Modal($('#borrowModal')).show();
    });


    $("#borrowForm").on("submit", function (e) {
      e.preventDefault();
      const bookId = $("#selectedBookId").val();
      const borrowDate = $("#borrowDate").val();
      const returnDate = $("#returnDate").val();

      $.ajax({
        url: BASE_URL + "borrow/save",
        type: "POST",
        dataType: "json",
        data: {
          lib_user_id: LIB_USER_ID,
          book_id: bookId,
          borrow_date: borrowDate,
          return_date: returnDate
        },
        success: function (res) {
          if (res.limitReached) {
            Swal.fire({
              icon: 'error',
              title: 'Borrowing Limit Reached',
              html: `
                <p>You have already reached your maximum borrowing limit of <strong>${res.limit}</strong> books.</p>
                <div class="d-flex justify-content-around align-items-center mt-3 mb-2">
                  <div><strong>${res.borrowed}</strong><br><small>BORROWED</small></div>
                  <div><strong>${res.limit}</strong><br><small>LIMIT</small></div>
                </div>
                <div class="progress my-2" style="height: 6px;">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: ${res.borrowed / res.limit * 100}%"></div>
                </div>
                <small>Please return books to borrow new ones.</small>
              `,
              showCancelButton: true,
              confirmButtonText: 'Return Books',
              cancelButtonText: 'Continue Browsing',
              reverseButtons: true,
              customClass: {
                popup: 'text-center',
                confirmButton: 'btn btn-success me-2',
                cancelButton: 'btn btn-outline-secondary'
              },
              buttonsStyling: false
            });
            return;
          }

          if (res.success) {
            Swal.fire({
              icon: 'success',
              title: 'Book Borrowed Successfully',
              html: `
                <p>You borrowed <strong>${$("#modalBookTitle").text()}</strong>.</p>
                <div class="alert alert-info">Below is your receipt:</div>
                <div class="mb-2 text-start">${res.receipt}</div>
                <div class="d-flex justify-content-center gap-2 mt-3">
                  <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Print Receipt</button>
                  <a href="${BASE_URL}borrow/download-pdf" class="btn btn-secondary"><i class="bi bi-file-earmark-pdf"></i> Download PDF</a>
                  <a href="mailto:?subject=Borrowed Book Receipt&body=${encodeURIComponent(res.receipt)}" class="btn btn-success"><i class="bi bi-envelope"></i> Email Receipt</a>
                </div>
              `,
              showCloseButton: true,
              showCancelButton: true,
              cancelButtonText: 'Close',
              confirmButtonText: 'Go to Dashboard',
              reverseButtons: true,
              customClass: {
                popup: 'text-center',
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary me-2'
              },
              buttonsStyling: false
            }).then(() => location.reload());
          } else {
            Swal.fire('Failed', res.message, 'error');
          }
        },
        error: function () {
          Swal.fire('Server Error', 'Please try again later.', 'error');
        }
      });
    });

    $(".search-input").on("input", function () {
      const keyword = $(this).val().toLowerCase();
      $(".book-item").each(function () {
        const text = $(this).text().toLowerCase();
        $(this).toggle(text.includes(keyword));
      });
    });
  });
</script>






</body>
</html>
