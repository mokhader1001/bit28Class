<?= $this->extend('index') ?>
<?= $this->section('content') ?>
<br><br><br><br><br>

<style>
  :root {
    --primary-color: #2563eb;
    --primary-hover: #1d4ed8;
    --success-color: #059669;
    --danger-color: #dc2626;
    --warning-color: #d97706;
    --info-color: #0891b2;
    --light-bg: #f8fafc;
    --border-color: #e2e8f0;
    --text-primary: #1e293b;
    --text-secondary: #64748b;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
  }

  .quiz-builder-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 2rem 0;
  }

  .main-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    margin: 0 auto;
    max-width: 900px;
  }

  .header-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, #3b82f6 100%);
    color: white;
    padding: 2rem;
    text-align: center;
    position: relative;
    overflow: hidden;
  }

  .header-content {
    position: relative;
    z-index: 1;
  }

  .header-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }

  .header-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    font-weight: 300;
  }

  .content-section {
    padding: 2rem;
  }

  .quiz-selector {
    background: var(--light-bg);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 2px solid var(--border-color);
    transition: all 0.3s ease;
  }

  .form-label {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .form-select, .form-control {
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
  }

  .form-select:focus, .form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    outline: none;
  }

  .question-card {
    background: white;
    border: 2px solid var(--border-color);
    border-radius: 16px;
    margin-bottom: 1.5rem;
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
  }

  .question-card.error {
    border-color: var(--danger-color);
    background: rgba(220, 38, 38, 0.05);
    animation: shake 0.5s ease-in-out;
  }

  @keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
  }

  .question-header {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    padding: 1rem 1.5rem;
    border-bottom: 2px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .question-number {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary-color);
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .question-content {
    padding: 1.5rem;
  }

  .choice-item {
    background: var(--light-bg);
    border: 2px solid var(--border-color);
    border-radius: 8px;
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
    overflow: hidden;
  }

  .choice-letter {
    background: var(--primary-color);
    color: white;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 100%;
  }

  .correct-indicator {
    background: var(--danger-color);
    color: white;
    padding: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    min-width: 50px;
    font-weight: bold;
  }

  .correct-indicator:hover {
    background: #b91c1c;
    transform: scale(1.05);
  }

  .correct-indicator.selected {
    background: var(--success-color);
    box-shadow: inset 0 0 0 2px white;
  }

  .correct-indicator input[type="radio"] {
    display: none;
  }

  .btn-modern {
    border: none;
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
  }

  .btn-success-modern {
    background: linear-gradient(135deg, var(--success-color) 0%, #10b981 100%);
    color: white;
    box-shadow: var(--shadow-md);
  }

  .btn-danger-modern {
    background: linear-gradient(135deg, var(--danger-color) 0%, #ef4444 100%);
    color: white;
    box-shadow: var(--shadow-md);
  }

  .btn-info-modern {
    background: linear-gradient(135deg, var(--info-color) 0%, #06b6d4 100%);
    color: white;
    box-shadow: var(--shadow-md);
  }

  .true-false-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-top: 1rem;
  }

  .tf-option {
    background: var(--light-bg);
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
  }

  .tf-option.selected {
    border-color: var(--success-color);
    background: rgba(5, 150, 105, 0.1);
  }

  .tf-option input[type="radio"] {
    display: none;
  }

  .tf-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
  }

  .empty-state {
    text-align: center;
    padding: 3rem 2rem;
    color: var(--text-secondary);
  }

  .empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
  }

  .question-counter {
    background: var(--primary-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
  }

  /* Error Alert Styles */
  .error-alert {
    background: #fee2e2;
    border: 2px solid #dc2626;
    color: #991b1b;
    padding: 1rem;
    border-radius: 8px;
    margin: 1rem 0;
    display: none;
  }

  .error-alert.show {
    display: block;
    animation: slideDown 0.3s ease-out;
  }

  .error-alert h4 {
    margin: 0 0 0.5rem 0;
    font-weight: 600;
  }

  .error-alert ul {
    margin: 0;
    padding-left: 1.5rem;
  }

  .error-alert li {
    margin-bottom: 0.25rem;
  }

  @keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .fade-in {
    animation: fadeIn 0.5s ease-in;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @keyframes fadeOut {
    from { opacity: 1; transform: translateY(0); }
    to { opacity: 0; transform: translateY(-20px); }
  }
</style>

<div class="quiz-builder-container">
  <div class="main-card">
    <div class="header-section">
      <div class="header-content">
        <h1 class="header-title">📚 Quiz Builder</h1>
        <p class="header-subtitle">Create engaging questions for your students</p>
      </div>
    </div>

    <div class="content-section">
      <!-- Error Alert -->
      <div id="errorAlert" class="error-alert">
        <h4>⚠️ Please fix the following issues:</h4>
        <ul id="errorList"></ul>
      </div>

      <form id="questionsForm" method="post" action="<?= base_url('teacher/save_questions') ?>">
        
        <!-- Quiz Selection -->
        <div class="quiz-selector">
          <label for="quizSelect" class="form-label">
            🎯 Select Quiz
          </label>
          <select class="form-select" id="quizSelect" name="quiz_id" required>
            <option value="">-- Choose a quiz to add questions --</option>
            <?php foreach ($quizzes as $quiz): ?>
              <option value="<?= $quiz['quiz_id'] ?>">
                <?= esc($quiz['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <!-- Questions Counter -->
        <div class="question-counter" id="questionCounter" style="display: none;">
          <span>📝</span>
          <span id="questionCount">0</span>
          <span>Questions Added</span>
        </div>

        <!-- Questions Container -->
        <div id="questionsContainer">
          <div class="empty-state" id="emptyState">
            <div class="empty-icon">📋</div>
            <h3>No questions yet</h3>
            <p>Start building your quiz by adding your first question below</p>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex gap-3 justify-content-center mt-4">
          <button type="button" class="btn-modern btn-info-modern" id="addQuestionBtn">
            <span>➕</span> Add Question
          </button>
          <button type="submit" class="btn-modern btn-success-modern" id="saveBtn" style="display: none;">
            <span>💾</span> Save All Questions
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
  let questionIndex = 0;
  let questionCount = 0;

  function updateQuestionCounter() {
    const counter = document.getElementById('questionCounter');
    const countSpan = document.getElementById('questionCount');
    const saveBtn = document.getElementById('saveBtn');
    const emptyState = document.getElementById('emptyState');

    countSpan.textContent = questionCount;

    if (questionCount > 0) {
      counter.style.display = 'flex';
      saveBtn.style.display = 'inline-flex';
      emptyState.style.display = 'none';
    } else {
      counter.style.display = 'none';
      saveBtn.style.display = 'none';
      emptyState.style.display = 'block';
    }
  }

  function createTrueFalseChoices(qIndex) {
    return `
      <div class="mb-3">
        <label class="form-label">✅ Select Correct Answer</label>
        <div class="true-false-options">
          <div class="tf-option" onclick="selectTrueFalse(${qIndex}, 'True', this)">
            <div class="tf-icon">✅</div>
            <strong>TRUE</strong>
            <input type="radio" name="questions[${qIndex}][correct_answer]" value="True">
          </div>
          <div class="tf-option" onclick="selectTrueFalse(${qIndex}, 'False', this)">
            <div class="tf-icon">❌</div>
            <strong>FALSE</strong>
            <input type="radio" name="questions[${qIndex}][correct_answer]" value="False">
          </div>
        </div>
      </div>
    `;
  }

  function createMultipleChoiceInputs(qIndex) {
    const letters = ['A', 'B', 'C', 'D'];
    let html = '<div class="mb-3"><label class="form-label">📝 Answer Choices <small class="text-muted">(Click ❌ to mark correct answer)</small></label>';

    letters.forEach((letter, index) => {
      html += `
        <div class="choice-item d-flex">
          <div class="choice-letter">${letter}</div>
          <input type="text" class="form-control" name="questions[${qIndex}][choices][]" 
                 placeholder="Enter choice ${letter}" style="border: none; border-radius: 0;">
          <div class="correct-indicator" onclick="selectCorrectChoice(${qIndex}, ${index}, this)" title="Click to mark as correct answer">
            <span>❌</span>
            <input type="radio" name="questions[${qIndex}][correct_answer]" value="${index}">
          </div>
        </div>
      `;
    });

    html += '</div>';
    return html;
  }

  function selectTrueFalse(qIndex, value, element) {
    $(element).siblings().removeClass('selected');
    $(element).addClass('selected');
    $(element).find('input[type="radio"]').prop('checked', true);
  }

  function selectCorrectChoice(qIndex, choiceIndex, element) {
    const $parent = $(element).closest('.mb-3');
    $parent.find('.correct-indicator').removeClass('selected').find('span').text('❌');
    $(element).addClass('selected').find('span').text('✅');
    $(element).find('input[type="radio"]').prop('checked', true);
  }

  function addQuestionBlock() {
    const container = document.getElementById('questionsContainer');
    const qIdx = questionIndex++;
    questionCount++;

    const block = document.createElement('div');
    block.classList.add('question-card', 'fade-in');
    block.setAttribute('data-index', qIdx);

    block.innerHTML = `
      <div class="question-header">
        <div class="question-number"><span>❓</span> Question #${questionCount}</div>
        <button type="button" class="btn-modern btn-danger-modern btn-sm remove-question-btn">
          <span>🗑️</span> Remove
        </button>
      </div>
      <div class="question-content">
        <div class="mb-3">
          <label class="form-label">🎯 Question Type</label>
          <select class="form-select question-type" name="questions[${qIdx}][q_type]">
            <option value="">-- Select question type --</option>
            <option value="true_false">✅ True / False</option>
            <option value="multiple">📝 Multiple Choice</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">❓ Question Text</label>
          <textarea class="form-control" name="questions[${qIdx}][question_text]" rows="3" placeholder="Enter your question here..."></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">🏅 Marks for this Question</label>
          <input type="number" min="1" class="form-control" name="questions[${qIdx}][marks]" placeholder="Enter marks">
        </div>
        <div class="choices-container slide-up"></div>
      </div>
    `;

    container.appendChild(block);

    const $questionTypeSelect = $(block).find('.question-type');
    const $choicesContainer = $(block).find('.choices-container');

    $questionTypeSelect.on('change', function () {
      $choicesContainer.html('').addClass('slide-up');
      setTimeout(() => {
        const type = this.value;
        if (type === 'true_false') {
          $choicesContainer.html(createTrueFalseChoices(qIdx));
        } else if (type === 'multiple') {
          $choicesContainer.html(createMultipleChoiceInputs(qIdx));
        }
      }, 100);
    });

    $(block).find('.remove-question-btn').on('click', function () {
      if (confirm('Are you sure you want to remove this question?')) {
        block.style.animation = 'fadeOut 0.3s ease-out';
        setTimeout(() => {
          block.remove();
          questionCount--;
          updateQuestionCounter();
          renumberQuestions();
        }, 300);
      }
    });

    updateQuestionCounter();
  }

  function renumberQuestions() {
    $('#questionsContainer .question-card').each(function (i) {
      $(this).find('.question-number').html(`<span>❓</span> Question #${i + 1}`);
    });
  }

  $(document).ready(function () {
    $('#addQuestionBtn').on('click', addQuestionBlock);

    $('#questionsForm').on('submit', function (e) {
      e.preventDefault();
      const $saveBtn = $('#saveBtn');
      const originalText = $saveBtn.html();

      $saveBtn.html('<span>⏳</span> Saving...').prop('disabled', true);

      const formData = new FormData(this);

      $.ajax({
        url: "<?= base_url('save_questions') ?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
          if (response.status === 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Saved!',
              text: response.message
            }).then(() => {
              location.reload();
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Validation Error',
              text: response.message
            });
          }
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong while saving.'
          });
        },
        complete: function () {
          $saveBtn.html(originalText).prop('disabled', false);
        }
      });
    });

    updateQuestionCounter();

    const style = document.createElement('style');
    style.textContent = `
      @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-20px); }
      }
    `;
    document.head.appendChild(style);
  });
</script>



<?= $this->endSection() ?>