<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($quizData[0]->name) ?> - Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            padding: 20px;
        }

        .main-container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        /* Rules Section */
        .rules-section {
            background: #fce4ec;
            margin: 30px;
            border-radius: 8px;
            padding: 20px;
        }

        .rules-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            font-weight: 600;
            color: #c2185b;
            margin-bottom: 20px;
        }

        .rule-item {
            background: white;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 8px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 14px;
            color: #333;
        }

        .rule-item:last-child {
            margin-bottom: 0;
        }

        .rule-item i {
            color: #666;
            margin-top: 2px;
            width: 16px;
        }

        .rule-text {
            flex: 1;
        }

        .rule-text strong {
            color: #333;
            font-weight: 600;
        }

        /* Student Form */
        .student-form {
            padding: 30px;
        }

        .form-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin: 24px 0;
        }

        .checkbox-group input[type="checkbox"] {
            margin-top: 2px;
        }

        .checkbox-group label {
            font-size: 14px;
            color: #333;
            line-height: 1.4;
        }

        .start-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .start-btn:hover {
            transform: translateY(-1px);
        }

        .start-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        /* Quiz Section - Hidden Initially */
        .quiz-section {
            display: none;
        }

        .quiz-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            margin: 2rem auto;
            max-width: 900px;
        }
        
        .quiz-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 2rem;
            text-align: center;
        }

        /* Instructor Information in Quiz Header */
        .instructor-info-header {
            background: rgba(255, 255, 255, 0.15);
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .instructor-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.3);
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .instructor-details {
            text-align: left;
        }

        .instructor-name {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 2px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .institution-name {
            font-size: 13px;
            opacity: 0.9;
            font-weight: 400;
        }
        
        .student-info {
            background: rgba(255, 255, 255, 0.2);
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            backdrop-filter: blur(10px);
        }
        
        .student-info-item {
            display: inline-block;
            margin: 0 1rem;
            font-size: 0.9rem;
        }
        
        .quiz-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .quiz-info {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 1rem;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            backdrop-filter: blur(10px);
        }
        
        .progress-container {
            margin: 1.5rem 0;
        }
        
        .progress {
            height: 8px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.3);
        }
        
        .progress-bar {
            background: linear-gradient(90deg, #00c851, #007e33);
            border-radius: 10px;
            transition: width 0.3s ease;
        }
        
        .question-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .question-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .question-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .question-number {
            background: rgba(255, 255, 255, 0.3);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }
        
        .question-marks {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .question-text {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        
        .form-check {
            margin-bottom: 1rem;
            padding: 1rem;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .form-check:hover {
            border-color: #4facfe;
            background: rgba(79, 172, 254, 0.05);
            transform: translateX(5px);
        }
        
        .form-check-input:checked + .form-check-label {
            color: #4facfe;
            font-weight: 600;
        }
        
        .form-check-input:checked {
            background-color: #4facfe;
            border-color: #4facfe;
        }
        
        .form-check-label {
            font-size: 1.1rem;
            cursor: pointer;
            margin-left: 0.5rem;
            transition: color 0.3s ease;
        }
        
        .submit-section {
            text-align: center;
            padding: 2rem;
            background: #f8f9fa;
            border-radius: 0 0 20px 20px;
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 1rem 3rem;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        
        .btn-submit:disabled {
            background: #6c757d;
            transform: none;
            box-shadow: none;
            cursor: not-allowed;
        }
        
        .validation-message {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            color: #721c24;
            padding: 1rem;
            border-radius: 10px;
            margin: 1rem 0;
            display: none;
        }
        
        .question-counter {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.9);
            padding: 1rem;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            z-index: 1000;
        }
        
        .timer-warning {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            color: #721c24;
            animation: pulse 1s infinite;
        }

        /* Unified Results Section */
        .results-section {
            display: none;
        }

        .results-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 2rem;
            text-align: center;
        }

        .results-header.early-submission {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        }

        .score-display {
            background: rgba(255, 255, 255, 0.2);
            padding: 1.5rem;
            border-radius: 15px;
            margin: 1rem 0;
            backdrop-filter: blur(10px);
        }

        .score-main {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .score-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .results-stats {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.2);
            padding: 1rem 1.5rem;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            text-align: center;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .results-content {
            padding: 2rem;
        }

        .result-question {
            background: white;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .result-question-header {
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .result-question-header.correct {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .result-question-header.incorrect {
            background: linear-gradient(135deg, #dc3545, #fd7e14);
            color: white;
        }

        .result-question-body {
            padding: 1.5rem;
        }

        .result-question-text {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
        }

        .answer-comparison {
            display: grid;
            gap: 1rem;
        }

        .answer-item {
            padding: 0.8rem 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .answer-item.your-answer {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
        }

        .answer-item.correct-answer {
            background: #e8f5e8;
            border-left: 4px solid #28a745;
        }

        .answer-item.wrong-answer {
            background: #ffebee;
            border-left: 4px solid #dc3545;
        }

        .answer-label {
            font-weight: 600;
            font-size: 0.9rem;
            min-width: 100px;
        }

        .answer-text {
            flex: 1;
        }

        .points-earned {
            background: rgba(255, 255, 255, 0.8);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .results-actions {
            text-align: center;
            padding: 2rem;
            background: #f8f9fa;
            border-radius: 0 0 20px 20px;
        }

        .btn-action {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            margin: 0 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        }

        .early-submission-notice {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid #ffc107;
            border-radius: 10px;
            padding: 1rem;
            margin: 1.5rem;
            text-align: center;
            color: #856404;
        }

        .early-submission-notice i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .countdown-timer {
            background: rgba(255, 255, 255, 0.9);
            padding: 1.5rem;
            border-radius: 15px;
            margin: 1rem 0;
            text-align: center;
        }

        .countdown-display {
            font-size: 2.5rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 0.5rem;
            font-family: 'Courier New', monospace;
        }

        .countdown-timer small {
            color: #666;
            font-size: 0.9rem;
        }

        .detailed-answers {
            display: none;
        }

        .quiz-time-info {
            background: rgba(255, 255, 255, 0.15);
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .time-info-item {
            text-align: center;
        }

        .time-info-label {
            font-size: 0.8rem;
            opacity: 0.8;
            margin-bottom: 0.2rem;
        }

        .time-info-value {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .state-indicator {
            position: fixed;
            top: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            z-index: 1001;
            display: none;
        }

        .state-indicator.show {
            display: block;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .main-container {
                margin: 0;
            }

            .instructor-info-header {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }

            .instructor-details {
                text-align: center;
            }

            .instructor-avatar {
                width: 45px;
                height: 45px;
            }
            
            .quiz-title {
                font-size: 2rem;
            }
            
            .quiz-info, .results-stats {
                flex-direction: column;
                gap: 1rem;
            }
            
            .question-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .question-counter {
                position: static;
                margin: 1rem;
            }
            
            .student-info-item {
                display: block;
                margin: 0.2rem 0;
            }

            .score-main {
                font-size: 2.5rem;
            }

            .results-content {
                padding: 1rem;
            }

            .quiz-time-info {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- State Indicator -->
    <div class="state-indicator" id="stateIndicator">
        <i class="fas fa-sync-alt fa-spin me-1"></i>
        Restoring state...
    </div>

    <!-- Rules and Student Info Section -->
    <div class="main-container" id="rulesSection">
        <div class="header">
            <h1><?= esc($quizData[0]->name) ?></h1>
            <p>Please read the rules carefully before starting</p>
        </div>

        <!-- Rules Section -->
        <div class="rules-section">
            <div class="rules-title">
                <i class="fas fa-exclamation-triangle"></i>
                IMPORTANT Exam RULES - READ CAREFULLY
            </div>
            
            <div class="rule-item">
                <i class="fas fa-clock"></i>
                <div class="rule-text">
                    <strong>Time Limit:</strong>
                    You have <?= esc($quizes->time_limit ?? 20) ?> minutes to complete this quiz. The timer will start once you begin.
                </div>
            </div>
            
            <div class="rule-item">
                <i class="fas fa-ban"></i>
                <div class="rule-text">
                    <strong>No Tab Switching:</strong> Switching tabs or windows will automatically cancel your Exam and assign ZERO marks.
                </div>
            </div>
            
            <div class="rule-item">
                <i class="fas fa-mouse"></i>
                <div class="rule-text">
                    <strong>No Right-Click:</strong> Right-clicking is disabled. Attempting to use it will cancel your quiz.
                </div>
            </div>
            
            <div class="rule-item">
                <i class="fas fa-keyboard"></i>
                <div class="rule-text">
                    <strong>No Developer Tools:</strong> Using F12, Ctrl+Shift+I, or any developer shortcuts will cancel your quiz.
                </div>
            </div>
            
            <div class="rule-item">
                <i class="fas fa-arrow-left"></i>
                <div class="rule-text">
                    <strong>No Back Button:</strong> The back button is disabled during the quiz.
                </div>
            </div>
            
            <div class="rule-item">
                <i class="fas fa-check-circle"></i>
                <div class="rule-text">
                    <strong>Answer All Questions:</strong> You must answer all questions before submitting the quiz.
                </div>
            </div>
            
            <div class="rule-item">
                <i class="fas fa-save"></i>
                <div class="rule-text">
                    <strong>Auto-Save:</strong> Your progress is automatically saved every 30 seconds.
                </div>
            </div>

            <div class="rule-item">
                <i class="fas fa-eye-slash"></i>
                <div class="rule-text">
                    <strong>Answer Review:</strong> Correct answers will only be shown when the full time limit is reached to prevent cheating.
                </div>
            </div>
        </div>

        <!-- Student Information Form -->
        <div class="student-form">
            <div class="form-title">
                <i class="fas fa-user-edit"></i>
                Enter Your Information
            </div>
            
            <form id="studentForm">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-id-card"></i>
                        Student ID
                    </label>
                    <input type="text" class="form-control" id="studentId" required 
                           placeholder="Enter your student ID">
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-user"></i>
                        Full Name
                    </label>
                    <input type="text" class="form-control" id="studentName" required 
                           placeholder="Enter your full name">
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-phone"></i>
                        Phone Number
                    </label>
                    <input type="tel" class="form-control" id="studentPhone" required 
                           placeholder="Enter your phone number">
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-graduation-cap"></i>
                        Select Your Class
                    </label>
                    <select class="form-select" id="studentClass" required>
                        <option value="">Choose your class...</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= esc($class->class_id) ?>">
                                <?= esc($class->class_name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="agreeRules" required>
                    <label for="agreeRules">
                        I have read and agree to follow all the Exam rules mentioned above
                    </label>
                </div>
                
                <button type="submit" class="start-btn">
                    <i class="fas fa-play me-2"></i>
                    Start Quiz
                </button>
            </form>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
            document.getElementById('studentForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const studentId = document.getElementById('studentId').value.trim();
                const studentName = document.getElementById('studentName').value.trim();
                const studentPhone = document.getElementById('studentPhone').value.trim();
                const studentClass = document.getElementById('studentClass').value;
                const agreeRules = document.getElementById('agreeRules').checked;

                if (!studentId || !studentName || !studentPhone || !studentClass || !agreeRules) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Incomplete',
                        text: 'Please fill in all fields and agree to the rules.',
                        toast: true,
                        position: 'top',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        width: '320px'
                    });
                    return;
                }

                fetch('<?= base_url('student_reg') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        student_id: studentId,
                        student_name: studentName,
                        phone: studentPhone,
                        class_id: studentClass
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Optionally handle response, then continue with quiz logic
                    if (typeof displayStudentInfo === 'function') {
                        // Get selected class name
                        const classSelect = document.getElementById('studentClass');
                        const className = classSelect.options[classSelect.selectedIndex].text;

                        const studentInfo = {
                            student_id: studentId,
                            student_name: studentName,
                            phone: studentPhone,
                            class_id: studentClass,
                            class_name: className,
                            agreed: agreeRules
                        };
                        localStorage.setItem('quiz_student_info_<?= $quizData[0]->quiz_id ?>', JSON.stringify(studentInfo));
                        displayStudentInfo(studentInfo);
                        if (typeof populateHiddenFields === 'function') {
                            populateHiddenFields(studentInfo);
                        }
                        document.getElementById('rulesSection').style.display = 'none';
                        document.getElementById('quizSection').style.display = 'block';
                        if (typeof startQuiz === 'function') {
                            startQuiz();
                        }
                    }
                })
                .catch(error => {
                    alert('Failed to register student. Please try again.');
                });
            });
            </script>
        </div>
    </div>

    <!-- Quiz Section -->
    <div class="quiz-section" id="quizSection">
        <div class="container-fluid">
            <!-- Question Counter -->
            <div class="question-counter">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-clipboard-list text-primary"></i>
                    <span id="answered-count">0</span>/<span id="total-questions"><?= count($quizData) ?></span>
                    <small class="text-muted">answered</small>
                </div>
            </div>

            <div class="quiz-container">
                <!-- Quiz Header -->
                <div class="quiz-header">
                    <!-- Instructor Information -->
                    <?php if (isset($creatorInfo) && $creatorInfo): ?>
                    <div class="instructor-info-header">
                        <?php if (!empty($creatorInfo->inst_image)): ?>
                            <img src="<?= base_url('public/uploads/institutions/' . esc($creatorInfo->inst_image)) ?>" 
                                 alt="Institution Logo" class="instructor-avatar">
                        <?php else: ?>
                            <div class="instructor-avatar" style="background: rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-university" style="font-size: 20px;"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="instructor-details">
                            <div class="instructor-name">
                                <i class="fas fa-chalkboard-teacher me-1"></i>
                                <strong>Instructor:</strong> <?= esc($creatorInfo->username) ?>
                            </div>
                            
                            <?php if (!empty($creatorInfo->Instution_Name)): ?>
                                <div class="institution-name">
                                    <i class="fas fa-university me-1"></i>
                                    <?= esc($creatorInfo->Instution_Name) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Student Information -->
                    <div class="student-info" id="student-info">
                        <div class="student-info-item">
                            <i class="fas fa-user me-1"></i>
                            <span id="student-name"></span>
                        </div>
                        <div class="student-info-item">
                            <i class="fas fa-id-card me-1"></i>
                            ID: <span id="student-id"></span>
                        </div>
                        <div class="student-info-item">
                            <i class="fas fa-phone me-1"></i>
                            <span id="student-phone"></span>
                        </div>
                        <div class="student-info-item">
                            <i class="fas fa-graduation-cap me-1"></i>
                            Class: <span id="student-class"></span>
                        </div>
                    </div>
                    
                    <h1 class="quiz-title">
                        <i class="fas fa-graduation-cap me-3"></i>
                        <?= esc($quizData[0]->name) ?>
                    </h1>
                    <p class="lead mb-0">Test your knowledge and challenge yourself!</p>
                    
                    <div class="quiz-info">
                        <div class="info-item">
                            <i class="fas fa-question-circle"></i>
                            <span><?= count($quizData) ?> Questions</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-star"></i>
                            <span><?= array_sum(array_column($quizData, 'marks')) ?> Total Marks</span>
                        </div>
                        <div class="info-item" id="timer-container">
                            <i class="fas fa-clock"></i>
                            <span id="timer">--:--</span>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="progress-container">
                        <div class="d-flex justify-content-between mb-2">
                            <small>Progress</small>
                            <small><span id="progress-percent">0</span>% Complete</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" id="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                <!-- Quiz Form -->
                <div class="p-4">
                    <form id="quizForm">
                        <input type="hidden" name="quiz_id" value="<?= esc($quizData[0]->quiz_id) ?>">
                        <input type="hidden" name="student_id" id="form_student_id" value="">
                        <input type="hidden" name="student_name" id="form_student_name" value="">
                        <input type="hidden" name="phone" id="form_phone" value="">
                        <input type="hidden" name="class_id" id="form_class_id" value="">
                        <input type="hidden" name="start_time" id="start_time" value="">
                        <input type="hidden" name="end_time" id="end_time" value="">
                        
                        <!-- Validation Message -->
                        <div class="validation-message" id="validation-message">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Please answer all questions before submitting the quiz.
                        </div>
                        
                        <?php foreach ($quizData as $index => $q): ?>
                            <div class="question-card" data-question="<?= $index + 1 ?>">
                                <div class="question-header">
                                    <div class="question-number">
                                        <i class="fas fa-hashtag me-2"></i>
                                        Question <?= $index + 1 ?>
                                    </div>
                                    <div class="question-marks">
                                        <i class="fas fa-medal me-1"></i>
                                        <?= esc($q->marks) ?> <?= $q->marks == 1 ? 'mark' : 'marks' ?>
                                    </div>
                                </div>
                                
                                <div class="card-body p-4">
                                    <div class="question-text">
                                        <?= esc($q->question_text) ?>
                                    </div>

                                    <div class="options-container" data-question-id="<?= $q->quiz_question_id ?>">
                                        <?php if ($q->q_type === 'true_false'): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" 
                                                       name="answers[<?= $q->quiz_question_id ?>]" 
                                                       value="True" 
                                                       id="q<?= $q->quiz_question_id ?>_true"
                                                       onchange="updateProgress(); saveQuizState();">
                                                <label class="form-check-label" for="q<?= $q->quiz_question_id ?>_true">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    True
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" 
                                                       name="answers[<?= $q->quiz_question_id ?>]" 
                                                       value="False" 
                                                       id="q<?= $q->quiz_question_id ?>_false"
                                                       onchange="updateProgress(); saveQuizState();">
                                                <label class="form-check-label" for="q<?= $q->quiz_question_id ?>_false">
                                                    <i class="fas fa-times-circle text-danger me-2"></i>
                                                    False
                                                </label>
                                            </div>
                                        <?php else: ?>
                                            <?php 
                                                $choices = explode('|||', $q->choices);
                                                foreach ($choices as $i => $choice):
                                            ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" 
                                                           name="answers[<?= $q->quiz_question_id ?>]" 
                                                           value="<?= esc($choice) ?>" 
                                                           id="q<?= $q->quiz_question_id ?>_<?= $i ?>"
                                                           onchange="updateProgress(); saveQuizState();">
                                                    <label class="form-check-label" for="q<?= $q->quiz_question_id ?>_<?= $i ?>">
                                                        <i class="fas fa-circle-dot text-primary me-2"></i>
                                                        <?= esc($choice) ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- Submit Section -->
                        <div class="submit-section">
                            <button type="submit" class="btn btn-submit" id="submitBtn" disabled>
                                <i class="fas fa-paper-plane me-2"></i>
                                Submit Quiz
                            </button>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Make sure to review all your answers before submitting
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Unified Results Section -->
    <div class="results-section" id="resultsSection">
        <div class="container-fluid">
            <div class="quiz-container">
                <!-- Results Header -->
                <div class="results-header" id="resultsHeader">
                    <h1 class="quiz-title" id="resultsTitle">
                        <i class="fas fa-check-circle me-3"></i>
                        Quiz Submitted!
                    </h1>
                    
                    <!-- Quiz Time Information -->
                    <div class="quiz-time-info">
                        <div class="time-info-item">
                            <div class="time-info-label">Quiz Duration</div>
                            <div class="time-info-value" id="quiz-duration-display"><?= esc($quizes->time_limit ?? 20) ?>:00</div>
                        </div>
                        <div class="time-info-item">
                            <div class="time-info-label">Time Taken</div>
                            <div class="time-info-value" id="time-taken-display">0:00</div>
                        </div>
                        <div class="time-info-item">
                            <div class="time-info-label">Submission Type</div>
                            <div class="time-info-value" id="submission-type">Early</div>
                        </div>
                    </div>
                    
                    <div class="score-display">
                        <div class="score-main" id="final-score">0/0</div>
                        <div class="score-subtitle" id="score-percentage">0%</div>
                    </div>

                    <div class="results-stats">
                        <div class="stat-card">
                            <div class="stat-number" id="correct-answers">0</div>
                            <div class="stat-label">Correct</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number" id="incorrect-answers">0</div>
                            <div class="stat-label">Incorrect</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number" id="total-time">0:00</div>
                            <div class="stat-label">Time Used</div>
                        </div>
                    </div>
                </div>

                <!-- Early Submission Notice (Hidden when time expires) -->
                <div class="early-submission-notice" id="earlySubmissionNotice">
                    <i class="fas fa-clock"></i>
                    <h4>Early Submission</h4>
                    <p><strong>Your quiz has been submitted successfully!</strong></p>
                    <p>Detailed answers will be available in:</p>
                    
                    <!-- Countdown Timer -->
                    <div class="countdown-timer" id="countdownTimer">
                        <div class="countdown-display">
                            <span id="countdown-minutes">00</span>:<span id="countdown-seconds">00</span>
                        </div>
                        <small>Time remaining until detailed results are available</small>
                    </div>
                    
                    <p>Thank you for completing the quiz!</p>
                </div>

                <!-- Detailed Results Content (Hidden initially for early submissions) -->
                <div class="detailed-answers" id="detailedAnswers">
                    <div class="results-content" id="results-content">
                        <!-- Results will be populated here -->
                    </div>
                </div>

                <!-- Results Actions -->
                <div class="results-actions">
                    <button class="btn-action btn-secondary" onclick="window.print()">
                        <i class="fas fa-print me-2"></i>
                        Print Results
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const totalQuestions = <?= count($quizData) ?>;
    let timerInterval;
    let countdownInterval;
    
    // Storage keys for persistence
    const quizKey = 'quiz_timer_start_<?= $quizData[0]->quiz_id ?>';
    const stateKey = 'quiz_state_<?= $quizData[0]->quiz_id ?>';
    const progressKey = 'quiz_progress_<?= $quizData[0]->quiz_id ?>';
    const resultsKey = 'quiz_results_<?= $quizData[0]->quiz_id ?>';
    const studentKey = 'quiz_student_info_<?= $quizData[0]->quiz_id ?>';
    
    // Keep time limit from database - DON'T CHANGE
    const timeLimit = <?= (int)($quizes->time_limit ?? 20) ?>;
    
    let quizStarted = false;
    let timeExpired = false;
    let quizStartTime = null;
    let quizSubmitted = false;

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        restoreApplicationState();
    });

    function restoreApplicationState() {
        showStateIndicator('Checking saved state...');
        
        const savedState = localStorage.getItem(stateKey);
        const savedResults = localStorage.getItem(resultsKey);
        const savedStudent = localStorage.getItem(studentKey);
        
        if (savedResults) {
            // User has completed quiz - show results
            const results = JSON.parse(savedResults);
            restoreResultsState(results);
        } else if (savedState) {
            // User was in quiz - restore quiz state
            const state = JSON.parse(savedState);
            restoreQuizState(state, savedStudent);
        } else if (savedStudent) {
            // User filled form but didn't start quiz
            restoreStudentForm(JSON.parse(savedStudent));
        }
        
        hideStateIndicator();
    }

    function restoreResultsState(results) {
        showStateIndicator('Restoring results...');
        
        // Hide other sections and show results
        document.getElementById('rulesSection').style.display = 'none';
        document.getElementById('quizSection').style.display = 'none';
        document.getElementById('resultsSection').style.display = 'block';
        
        // Restore results data
        showUnifiedResults(results.data, results.isTimeExpired, true);
        
        // If it was early submission, check if countdown should continue
        if (!results.isTimeExpired && results.submissionTime) {
            const submissionTime = new Date(results.submissionTime);
            const originalStartTime = localStorage.getItem(quizKey);
        
            if (originalStartTime) {
                const startTime = new Date(originalStartTime);
                const endTime = new Date(startTime.getTime() + timeLimit * 60000);
                const now = new Date();
            
                if (now < endTime) {
                    // Continue countdown
                    startResultsCountdown();
                } else {
                    // Time has expired, show detailed answers immediately
                    setTimeout(() => {
                        showDetailedAnswers();
                    }, 500); // Small delay to ensure UI is ready
                }
            } else {
                // No start time found, assume time expired
                setTimeout(() => {
                    showDetailedAnswers();
                }, 500);
            }
        } else if (results.isTimeExpired) {
            // Time expired submission, show detailed answers immediately
            setTimeout(() => {
                showDetailedAnswers();
            }, 500);
        }
    }

    function restoreQuizState(state, savedStudent) {
        showStateIndicator('Restoring quiz progress...');
        
        // Hide rules and show quiz
        document.getElementById('rulesSection').style.display = 'none';
        document.getElementById('quizSection').style.display = 'block';
        
        // Restore student info
        if (savedStudent) {
            const studentInfo = JSON.parse(savedStudent);
            displayStudentInfo(studentInfo);
            populateHiddenFields(studentInfo);
        }
        
        // Restore quiz state
        quizStarted = true;
        quizSubmitted = state.quizSubmitted || false;
        
        if (state.startTime) {
            quizStartTime = new Date(state.startTime);
            document.getElementById('start_time').value = state.startTime;
        }
        
        // Load saved answers
        loadSavedProgress();
        updateProgress();
        
        // Resume timer - CONTINUES COUNTING EVEN IF TAB WAS CLOSED
        if (!quizSubmitted) {
            startCountdownWithPersistence(timeLimit);
            enableSecurityMeasures();
        }
    }

    function restoreStudentForm(studentInfo) {
        showStateIndicator('Restoring form data...');
        
        // Fill form fields
        document.getElementById('studentId').value = studentInfo.student_id || '';
        document.getElementById('studentName').value = studentInfo.student_name || '';
        document.getElementById('studentPhone').value = studentInfo.phone || '';
        document.getElementById('studentClass').value = studentInfo.class_id || '';
        document.getElementById('agreeRules').checked = studentInfo.agreed || false;
    }

    function saveQuizState() {
        if (!quizStarted) return;
        
        const state = {
            section: 'quiz',
            startTime: quizStartTime ? quizStartTime.toISOString() : null,
            quizSubmitted: quizSubmitted,
            timestamp: new Date().toISOString()
        };
        
        localStorage.setItem(stateKey, JSON.stringify(state));
        
        // Also save progress
        autoSave();
    }

    function saveResultsState(data, isTimeExpired) {
        const results = {
            data: data,
            isTimeExpired: isTimeExpired,
            submissionTime: new Date().toISOString(),
            timestamp: new Date().toISOString()
        };
        
        localStorage.setItem(resultsKey, JSON.stringify(results));
        
        // Clear quiz state since it's completed
        localStorage.removeItem(stateKey);
        localStorage.removeItem(progressKey);
    }

    function showStateIndicator(message) {
        const indicator = document.getElementById('stateIndicator');
        indicator.innerHTML = `<i class="fas fa-sync-alt fa-spin me-1"></i>${message}`;
        indicator.classList.add('show');
    }

    function hideStateIndicator() {
        setTimeout(() => {
            document.getElementById('stateIndicator').classList.remove('show');
        }, 1000);
    }

    // Student form submission
    document.getElementById('studentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const studentId = document.getElementById('studentId').value.trim();
        const studentName = document.getElementById('studentName').value.trim();
        const studentPhone = document.getElementById('studentPhone').value.trim();
        const studentClass = document.getElementById('studentClass').value;
        const agreeRules = document.getElementById('agreeRules').checked;
        
        if (!studentId || !studentName || !studentPhone || !studentClass || !agreeRules) {
            alert('Please fill in all fields and agree to the rules.');
            return;
        }
        
        // Get selected class name
        const classSelect = document.getElementById('studentClass');
        const className = classSelect.options[classSelect.selectedIndex].text;
        
        // Store student information
        const studentInfo = {
            student_id: studentId,
            student_name: studentName,
            phone: studentPhone,
            class_id: studentClass,
            class_name: className,
            agreed: agreeRules
        };
        
        localStorage.setItem(studentKey, JSON.stringify(studentInfo));
        
        // Display student info and populate hidden fields
        displayStudentInfo(studentInfo);
        populateHiddenFields(studentInfo);
        
        // Hide rules section and show quiz
        document.getElementById('rulesSection').style.display = 'none';
        document.getElementById('quizSection').style.display = 'block';
        
        // Start the quiz
        startQuiz();
    });

    function displayStudentInfo(studentInfo) {
        document.getElementById('student-name').textContent = studentInfo.student_name;
        document.getElementById('student-id').textContent = studentInfo.student_id;
        document.getElementById('student-phone').textContent = studentInfo.phone;
        document.getElementById('student-class').textContent = studentInfo.class_name;
    }

    function populateHiddenFields(studentInfo) {
        document.getElementById('form_student_id').value = studentInfo.student_id;
        document.getElementById('form_student_name').value = studentInfo.student_name;
        document.getElementById('form_phone').value = studentInfo.phone;
        document.getElementById('form_class_id').value = studentInfo.class_id;
    }

    function startQuiz() {
        quizStarted = true;
        quizStartTime = new Date();
        document.getElementById('start_time').value = quizStartTime.toISOString();
        
        // Save initial state
        saveQuizState();
        
        // Start timer - KEEPS RUNNING EVEN IF TAB CLOSED
        startCountdownWithPersistence(timeLimit);
        updateProgress();
        enableSecurityMeasures();
    }

    function startCountdownWithPersistence(minutes) {
        const timerEl = document.getElementById('timer');
        const timerContainer = document.getElementById('timer-container');

        // Get or set start time - PERSISTENT ACROSS TAB CLOSURES
        let startTime = localStorage.getItem(quizKey);
        if (!startTime) {
            startTime = new Date().toISOString();
            localStorage.setItem(quizKey, startTime);
        }

        document.getElementById('start_time').value = startTime;

        const start = new Date(startTime);
        const end = new Date(start.getTime() + minutes * 60000);

        timerInterval = setInterval(() => {
            const now = new Date();
            const diff = Math.floor((end - now) / 1000);

            if (diff >= 0) {
                const mins = Math.floor(diff / 60);
                const secs = diff % 60;
                timerEl.textContent = `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
                
                // Warning when time is low
                const warningTime = Math.min(60, Math.floor(minutes * 60 * 0.1)); // 10% of total time or 1 minute
                if (diff <= warningTime) {
                    timerContainer.classList.add('timer-warning');
                    timerEl.style.color = '#dc3545';
                    timerEl.style.fontWeight = 'bold';
                }
            } else {
                clearInterval(timerInterval);
                timeExpired = true;
                
                // Only auto-submit if not already submitted
                if (!quizSubmitted) {
                    const timerEl = document.getElementById('timer');
                    timerEl.textContent = "Time is up! Submitting quiz...";
                    timerEl.style.color = '#dc3545';
                    timerEl.style.fontWeight = 'bold';
                    setTimeout(function() {
                        submitQuizData(true);
                    }, 3000);
                }
            }
        }, 1000);
    }

    function updateProgress() {
        const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
        const progressPercent = Math.round((answeredQuestions / totalQuestions) * 100);
        document.getElementById('progress-bar').style.width = progressPercent + '%';
        document.getElementById('progress-percent').textContent = progressPercent;
        document.getElementById('answered-count').textContent = answeredQuestions;

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = answeredQuestions !== totalQuestions;
        submitBtn.innerHTML = answeredQuestions === totalQuestions
            ? '<i class="fas fa-check me-2"></i>Submit Quiz'
            : '<i class="fas fa-paper-plane me-2"></i>Submit Quiz';
        document.getElementById('validation-message').style.display = 'none';
    }

    document.getElementById('quizForm').addEventListener('submit', function (e) {
        e.preventDefault();
        
        const answered = document.querySelectorAll('input[type="radio"]:checked').length;
        if (answered < totalQuestions) {
            document.getElementById('validation-message').style.display = 'block';
            document.getElementById('validation-message').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }

        submitQuizData(false); // false indicates manual submission (early)
    });

    function submitQuizData(isTimeExpired) {
        if (quizSubmitted) return; // Prevent double submission
        
        quizSubmitted = true;
        document.getElementById('end_time').value = new Date().toISOString();
        clearInterval(timerInterval);
        
        // Update state
        saveQuizState();
        
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
        submitBtn.disabled = true;

        // Prepare form data
        const formData = new FormData(document.getElementById('quizForm'));
        
        // Submit via AJAX
        fetch('<?= base_url('submit_quiz_answers') ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Save results state for persistence
            saveResultsState(data, isTimeExpired);
            
            // Show unified results
            showUnifiedResults(data, isTimeExpired, false);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting your quiz. Please try again.');
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Submit Quiz';
            submitBtn.disabled = false;
            quizSubmitted = false;
            saveQuizState();
        });
    }

    function showUnifiedResults(data, isTimeExpired, isRestored = false) {
        // Hide quiz section and show results
        document.getElementById('quizSection').style.display = 'none';
        document.getElementById('resultsSection').style.display = 'block';

        // Calculate statistics
        const correctCount = data.details.filter(q => q.correct).length;
        const incorrectCount = data.details.length - correctCount;
        const percentage = Math.round((data.score / data.out_of) * 100);
        const timeTaken = calculateTimeTaken();

        // Update header based on submission type
        const resultsHeader = document.getElementById('resultsHeader');
        const resultsTitle = document.getElementById('resultsTitle');
        const submissionType = document.getElementById('submission-type');
        const timeTakenDisplay = document.getElementById('time-taken-display');

        if (isTimeExpired) {
            resultsHeader.classList.remove('early-submission');
            resultsTitle.innerHTML = '<i class="fas fa-trophy me-3"></i>Quiz Completed!';
            submissionType.textContent = 'Time Expired';
        } else {
            resultsHeader.classList.add('early-submission');
            resultsTitle.innerHTML = '<i class="fas fa-check-circle me-3"></i>Quiz Submitted!';
            submissionType.textContent = 'Early Submission';
        }

        timeTakenDisplay.textContent = timeTaken;

        // Update score display
        document.getElementById('final-score').textContent = `${data.score}/${data.out_of}`;
        document.getElementById('score-percentage').textContent = `${percentage}%`;
        document.getElementById('correct-answers').textContent = correctCount;
        document.getElementById('incorrect-answers').textContent = incorrectCount;
        document.getElementById('total-time').textContent = timeTaken;

        // Generate detailed results
        generateDetailedResults(data);

        if (isTimeExpired) {
            // Show detailed answers immediately
            showDetailedAnswers();
        } else if (!isRestored) {
            // Start countdown for early submission (only if not restored)
            startResultsCountdown();
        }
        // If isRestored is true, the countdown check will be handled in restoreResultsState
    }

    function generateDetailedResults(data) {
        const resultsContent = document.getElementById('results-content');
        resultsContent.innerHTML = '';

        data.details.forEach((question, index) => {
            const questionDiv = document.createElement('div');
            questionDiv.className = 'result-question';
            
            const isCorrect = question.correct;
            const headerClass = isCorrect ? 'correct' : 'incorrect';
            const icon = isCorrect ? 'fa-check-circle' : 'fa-times-circle';
            
            questionDiv.innerHTML = `
                <div class="result-question-header ${headerClass}">
                    <div>
                        <i class="fas ${icon} me-2"></i>
                        Question ${index + 1}
                    </div>
                    <div class="points-earned">
                        ${question.earned}/${question.marks} points
                    </div>
                </div>
                <div class="result-question-body">
                    <div class="result-question-text">${question.question}</div>
                    <div class="answer-comparison">
                        <div class="answer-item your-answer">
                            <div class="answer-label">Your Answer:</div>
                            <div class="answer-text">${question.submitted || 'Not answered'}</div>
                        </div>
                        <div class="answer-item correct-answer">
                            <div class="answer-label">Correct Answer:</div>
                            <div class="answer-text">${question.correct_answer}</div>
                        </div>
                    </div>
                </div>
            `;
            
            resultsContent.appendChild(questionDiv);
        });
    }

    function startResultsCountdown() {
        const originalStartTime = localStorage.getItem(quizKey);
        if (!originalStartTime) return;
        
        const startTime = new Date(originalStartTime);
        const endTime = new Date(startTime.getTime() + timeLimit * 60000);
        
        countdownInterval = setInterval(() => {
            const now = new Date();
            const diff = Math.floor((endTime - now) / 1000);
            
            if (diff > 0) {
                const mins = Math.floor(diff / 60);
                const secs = diff % 60;
                
                document.getElementById('countdown-minutes').textContent = mins.toString().padStart(2, '0');
                document.getElementById('countdown-seconds').textContent = secs.toString().padStart(2, '0');
            } else {
                // Time expired - show detailed answers
                clearInterval(countdownInterval);
                showDetailedAnswers();
            }
        }, 1000);
    }

    function showDetailedAnswers() {
        // Hide early submission notice
        const earlyNotice = document.getElementById('earlySubmissionNotice');
        const detailedAnswers = document.getElementById('detailedAnswers');
        
        if (earlyNotice) {
            earlyNotice.style.display = 'none';
        }
        
        // Show detailed answers
        if (detailedAnswers) {
            detailedAnswers.style.display = 'block';
        }
        
        // Update header
        const resultsHeader = document.getElementById('resultsHeader');
        const resultsTitle = document.getElementById('resultsTitle');
        const submissionType = document.getElementById('submission-type');
        
        if (resultsHeader) {
            resultsHeader.classList.remove('early-submission');
        }
        
        if (resultsTitle) {
            resultsTitle.innerHTML = '<i class="fas fa-trophy me-3"></i>Quiz Completed!';
        }
        
        if (submissionType) {
            submissionType.textContent = 'Answers Available';
        }
        
        // Clear countdown interval if running
        if (countdownInterval) {
            clearInterval(countdownInterval);
        }
        
        // Clean up timer storage
        localStorage.removeItem(quizKey);
        
        console.log('Detailed answers are now visible'); // Debug log
    }

    function calculateTimeTaken() {
        if (!quizStartTime) return '0:00';
        
        const endTime = new Date();
        const diffMs = endTime - quizStartTime;
        const diffMins = Math.floor(diffMs / 60000);
        const diffSecs = Math.floor((diffMs % 60000) / 1000);
        
        return `${diffMins}:${diffSecs.toString().padStart(2, '0')}`;
    }

    document.querySelectorAll('.form-check').forEach(function (div) {
        div.addEventListener('click', function (e) {
            if (e.target.tagName !== 'INPUT') {
                const radio = div.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                    updateProgress();
                    saveQuizState();
                }
            }
        });
    });

    function autoSave() {
        if (quizStarted && !quizSubmitted) {
            const formData = new FormData(document.getElementById('quizForm'));
            const answers = {};
            for (let [key, value] of formData.entries()) {
                if (key.startsWith('answers[')) {
                    answers[key] = value;
                }
            }
            localStorage.setItem(progressKey, JSON.stringify(answers));
        }
    }

    function loadSavedProgress() {
        const saved = localStorage.getItem(progressKey);
        if (saved) {
            const answers = JSON.parse(saved);
            for (let [key, value] of Object.entries(answers)) {
                const input = document.querySelector(`input[name="${key}"][value="${value}"]`);
                if (input) input.checked = true;
            }
            updateProgress();
        }
    }

    function handleQuizViolation(reason) {
        clearInterval(timerInterval);
        clearInterval(countdownInterval);
        alert(`⚠️ RULE VIOLATION: ${reason}! Your quiz has been cancelled and marks assigned as ZERO.`);
        
        // Clear all stored data
        localStorage.removeItem(quizKey);
        localStorage.removeItem(stateKey);
        localStorage.removeItem(progressKey);
        localStorage.removeItem(resultsKey);
        localStorage.removeItem(studentKey);
        
        window.location.href = '<?= base_url('quiz_cancelled') ?>';
    }

    function enableSecurityMeasures() {
        // Tab switching detection - DISABLED DURING QUIZ
        document.addEventListener('visibilitychange', function() {
            if (document.hidden && quizStarted && !quizSubmitted) {
                // Don't cancel quiz for tab switching - just continue timer
                console.log('Tab switched but timer continues running...');
            }
        });

        // Prevent right-click and common shortcuts
        document.addEventListener('contextmenu', e => {
            if (quizStarted && !quizSubmitted) {
                e.preventDefault();
                handleQuizViolation('Right-click attempted');
            }
        });

        document.addEventListener('keydown', function(e) {
            if (quizStarted && !quizSubmitted && (
                e.key === 'F12' || 
                (e.ctrlKey && e.shiftKey && e.key === 'I') ||
                (e.ctrlKey && e.key === 'u') ||
                (e.altKey && e.key === 'Tab')
            )) {
                e.preventDefault();
                handleQuizViolation('Developer tools/shortcuts attempted');
            }
        });

        // Prevent back button
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            if (quizStarted && !quizSubmitted) {
                history.go(1);
            }
        };

        // Prevent page unload without warning (but allow refresh for persistence)
        window.addEventListener('beforeunload', function (e) {
            if (quizStarted && !quizSubmitted) {
                const answered = document.querySelectorAll('input[type="radio"]:checked').length;
                if (answered > 0 && answered < totalQuestions) {
                    e.preventDefault();
                    e.returnValue = 'You have unsaved changes. Your progress will be saved.';
                }
            }
        });
    }

    // Auto-save every 10 seconds for better persistence
    setInterval(autoSave, 10000);

    // Save state on every answer change
    document.addEventListener('change', function(e) {
        if (e.target.type === 'radio' && quizStarted) {
            saveQuizState();
        }
    });

    // Cleanup function for page unload
    window.addEventListener('beforeunload', function() {
        if (quizStarted && !quizSubmitted) {
            saveQuizState();
        }
    });
</script>
</body>
</html>
