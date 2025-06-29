<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>BIT28-A Memory Keepsake | SIMAD University</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Dancing+Script:wght@700&display=swap" rel="stylesheet"/>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        :root {
            --primary-gold: #FFD700;
            --primary-blue: #1e3a8a;
            --secondary-purple: #7c3aed;
            --success-green: #10b981;
            --gradient-bg: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --card-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            font-family: 'Poppins', sans-serif;
            background: var(--gradient-bg);
            min-height: 100vh;
            position: relative;
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            z-index: -2;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Falling Objects */
        .falling-object {
            position: fixed;
            top: -100px;
            font-size: 28px;
            animation: fall linear forwards;
            pointer-events: none;
            z-index: 1;
        }

        .balloon {
            font-size: 32px;
            animation: balloonFloat linear forwards;
        }

        .confetti {
            width: 10px;
            height: 10px;
            background: var(--primary-gold);
            animation: confettiFall linear forwards;
        }

        @keyframes fall {
            0% {
                transform: translateY(-100px) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(110vh) rotate(720deg);
                opacity: 0;
            }
        }

        @keyframes balloonFloat {
            0% {
                transform: translateY(-100px) translateX(0px);
                opacity: 1;
            }
            50% {
                transform: translateY(50vh) translateX(20px);
                opacity: 0.8;
            }
            100% {
                transform: translateY(110vh) translateX(-10px);
                opacity: 0;
            }
        }

        @keyframes confettiFall {
            0% {
                transform: translateY(-100px) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(110vh) rotate(1080deg);
                opacity: 0;
            }
        }

        /* Main Container */
        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 10;
        }

        /* Congratulations Header */
        .congratulations-header {
            text-align: center;
            margin-bottom: 30px;
            animation: slideInDown 1s ease-out;
        }

        .congratulations-text {
            font-family: 'Dancing Script', cursive;
            font-size: 3.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, var(--primary-gold), #ff6b6b, var(--primary-gold));
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: textShimmer 3s ease-in-out infinite;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        @keyframes textShimmer {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form Card */
        .form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            animation: slideInUp 1s ease-out 0.3s both;
            max-width: 500px;
            width: 100%;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-purple));
            color: white;
            padding: 25px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shine 3s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 4px solid var(--primary-gold);
            margin-bottom: 15px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .university-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .batch-title {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 300;
        }

        /* Form Styling */
        .card-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-blue);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 15px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
            background: white;
        }

        .character-count {
            position: absolute;
            right: 10px;
            bottom: 10px;
            font-size: 12px;
            color: #6b7280;
            background: rgba(255, 255, 255, 0.9);
            padding: 2px 6px;
            border-radius: 4px;
        }

        .submit-btn {
            background: linear-gradient(135deg, var(--success-green), #059669);
            border: none;
            border-radius: 12px;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        /* Decorative Elements */
        .decoration {
            position: absolute;
            font-size: 24px;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .decoration:nth-child(odd) {
            animation-delay: -3s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        /* Graduation Celebration Styles */
        .graduation-celebration {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
            box-sizing: border-box;
            overflow-y: auto;
        }

        .celebration-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 600px;
            min-height: 100vh;
            padding: 20px 0;
        }

        .student-circle {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 8px solid var(--primary-gold);
            margin-bottom: 30px;
            animation: bounceIn 1s ease-out;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            object-fit: cover;
            flex-shrink: 0;
        }

        .graduation-message {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            animation: slideInUp 1s ease-out 0.5s both;
            margin: 0 auto;
            box-sizing: border-box;
        }

        .graduation-message h2 {
            color: var(--primary-blue);
            font-family: 'Dancing Script', cursive;
            font-size: 2.5rem;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .graduation-message p {
            font-size: 1.2rem;
            line-height: 1.6;
            color: #333;
            margin-bottom: 20px;
        }

        .signature {
            font-style: normal;
            color: #1e3a8a;
            font-weight: 800;
            margin-top: 20px;
            font-size: 1.1rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
            border-top: 2px solid #1e3a8a;
            padding-top: 15px;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .signature .from-icon {
            color: #059669;
            font-size: 1.2rem;
            animation: pulse 2s infinite;
        }

        .footer-info {
            font-size: 0.9rem;
            color: #6b7280;
            margin-top: 15px;
            font-weight: 500;
        }

        .footer-info div {
            margin-bottom: 5px;
        }

        .footer-info .service-line {
            font-size: 0.8rem;
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Enhanced falling objects for celebration */
        .celebration-balloon {
            position: fixed;
            font-size: 40px;
            animation: celebrationFloat linear forwards;
            pointer-events: none;
            z-index: 10000;
        }

        .celebration-confetti {
            position: fixed;
            width: 15px;
            height: 15px;
            animation: celebrationConfetti linear forwards;
            pointer-events: none;
            z-index: 10000;
        }

        @keyframes celebrationFloat {
            0% {
                transform: translateY(100vh) translateX(0px);
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) translateX(50px);
                opacity: 0;
            }
        }

        @keyframes celebrationConfetti {
            0% {
                transform: translateY(-100px) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(1440deg);
                opacity: 0;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .congratulations-text {
                font-size: 2.5rem;
            }
            
            .card-body {
                padding: 20px;
            }
            
            .university-title {
                font-size: 1.3rem;
            }

            .graduation-celebration {
                padding: 10px;
            }

            .celebration-content {
                padding: 10px 0;
                min-height: 100vh;
                justify-content: flex-start;
                padding-top: 20px;
            }

            .student-circle {
                width: 150px;
                height: 150px;
                margin-bottom: 20px;
                border-width: 6px;
            }

            .graduation-message {
                padding: 20px;
                margin: 0;
                width: 100%;
            }

            .graduation-message h2 {
                font-size: 1.8rem;
                margin-bottom: 15px;
            }

            .graduation-message p {
                font-size: 1rem;
                line-height: 1.5;
                margin-bottom: 15px;
            }

            .signature {
                font-size: 1rem;
                margin-top: 15px;
                padding-top: 12px;
                flex-direction: column;
                gap: 5px;
            }

            .signature .from-icon {
                font-size: 1.1rem;
            }

            .footer-info {
                font-size: 0.8rem;
                margin-top: 10px;
            }

            .footer-info .service-line {
                font-size: 0.7rem;
            }

            /* Adjust student name sizes for mobile */
            .student-name-title {
                font-size: 2rem !important;
            }

            .student-name-message {
                font-size: 1.2rem !important;
            }
        }

        @media (max-width: 480px) {
            .congratulations-text {
                font-size: 2rem;
            }
            
            .main-container {
                padding: 10px;
            }

            .graduation-celebration {
                padding: 5px;
            }

            .celebration-content {
                padding: 5px 0;
                padding-top: 15px;
            }

            .student-circle {
                width: 120px;
                height: 120px;
                margin-bottom: 15px;
                border-width: 4px;
            }

            .graduation-message {
                padding: 15px;
                border-radius: 15px;
            }

            .graduation-message h2 {
                font-size: 1.5rem;
                margin-bottom: 10px;
            }

            .graduation-message p {
                font-size: 0.9rem;
                line-height: 1.4;
                margin-bottom: 10px;
            }

            .signature {
                font-size: 0.9rem;
                margin-top: 10px;
                padding-top: 10px;
            }

            .signature .from-icon {
                font-size: 1rem;
            }

            .footer-info {
                font-size: 0.7rem;
                margin-top: 8px;
            }

            .footer-info .service-line {
                font-size: 0.6rem;
            }

            /* Further adjust student name sizes for small mobile */
            .student-name-title {
                font-size: 1.5rem !important;
            }

            .student-name-message {
                font-size: 1rem !important;
            }

            .btn {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 360px) {
            .student-circle {
                width: 100px;
                height: 100px;
                margin-bottom: 10px;
            }

            .graduation-message {
                padding: 12px;
            }

            .graduation-message h2 {
                font-size: 1.3rem;
            }

            .graduation-message p {
                font-size: 0.8rem;
            }

            .student-name-title {
                font-size: 1.3rem !important;
            }

            .student-name-message {
                font-size: 0.9rem !important;
            }
        }

        /* Landscape orientation for mobile */
        @media (max-height: 600px) and (orientation: landscape) {
            .celebration-content {
                flex-direction: row;
                align-items: center;
                justify-content: center;
                min-height: auto;
                padding: 10px 0;
            }

            .student-circle {
                width: 120px;
                height: 120px;
                margin-bottom: 0;
                margin-right: 20px;
                flex-shrink: 0;
            }

            .graduation-message {
                flex: 1;
                max-width: none;
                margin: 0;
            }

            .graduation-message h2 {
                font-size: 1.5rem;
                margin-bottom: 10px;
            }

            .graduation-message p {
                font-size: 0.9rem;
                margin-bottom: 10px;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <div class="animated-bg"></div>
    
    <!-- Decorative Elements -->
    <div class="decoration" style="top: 10%; left: 10%;">🎓</div>
    <div class="decoration" style="top: 20%; right: 15%;">🎉</div>
    <div class="decoration" style="bottom: 30%; left: 5%;">🏆</div>
    <div class="decoration" style="bottom: 10%; right: 10%;">⭐</div>

    <!-- Graduation Celebration Overlay -->
    <div class="graduation-celebration" id="graduationCelebration">
        <div class="celebration-content">
            <img src="/placeholder.svg?height=200&width=200" alt="Student Photo" class="student-circle" id="studentPhoto">
            <div class="graduation-message">
                <h2 id="congratsTitle">🎉 Congratulations! 🎉</h2>
                <p id="congratsMessage">Congratulations on your graduation! It's been amazing watching you grow and achieve so much. We will really miss you! 😢 Wishing you all the best in your next chapter.</p>
                <div class="signature">
                    <i class="fas fa-paper-plane from-icon"></i>
                    <span><strong>From: Shafici Mohamud Isse, <br>System Admin</strong></span>
                </div>
                <div class="footer-info">
                    <div>Hosted at <strong>MohamedYusuf.engineer</strong></div>
                    <div class="service-line">Web Development and Software Engineering Services</div>
                    <div class="service-line">Copyright © BIT28-A All Rights Reserved</div>
                </div>
                <button class="btn btn-primary mt-3" onclick="closeCelebration()">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>

    <div class="main-container">
        <div class="container">
            <!-- Congratulations Header -->
            <div class="congratulations-header">
                <h1 class="congratulations-text">Congratulations!</h1>
                <p class="text-white fs-5 fw-light">🎉 Celebrate Your Achievement 🎉</p>
            </div>

            <!-- Main Form Card -->
            <div class="form-card mx-auto">
                <div class="card-header">
            <img src="<?= base_url(); ?>/public/uploads/SU.JPEG" alt="SIMAD University Logo" class="logo" />
                    <h2 class="university-title">SIMAD University</h2>
                    <p class="batch-title">BIT28-A Memory Keepsake</p>
                </div>

                <div class="card-body">
                    <form id="bit28Form" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user text-primary"></i>
                                Your Name
                            </label>
                            <input type="text" name="name" class="form-control" placeholder="eg..Sacid Farah Mire" required />
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-camera text-primary"></i>
                                Your Photo
                            </label>
                            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*" required />
                            <small class="text-muted">Upload your graduation photo</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-heart text-primary"></i>
                                Your Message
                            </label>
                            <textarea name="message" id="message" class="form-control" maxlength="20" 
                                placeholder="Share your graduation message..." required rows="3"></textarea>
                            <span class="character-count" id="charCount">0/20</span>
                        </div>

                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane me-2"></i>
                            <span class="btn-text">Create Memory</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Enhanced falling objects with balloons and confetti
        const graduationSymbols = ["🎓", "🎉", "🏆", "⭐", "🎊"];
        const balloonColors = ["🎈", "🟡", "🔴", "🔵", "🟢", "🟣", "🟠"];
        const confettiColors = ['#FFD700', '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7'];

        // Create falling graduation symbols
        setInterval(() => {
            const span = document.createElement("span");
            span.className = "falling-object";
            span.style.left = Math.random() * window.innerWidth + "px";
            span.style.animationDuration = (4 + Math.random() * 6) + "s";
            span.textContent = graduationSymbols[Math.floor(Math.random() * graduationSymbols.length)];
            document.body.appendChild(span);
            setTimeout(() => span.remove(), 8000);
        }, 800);

        // Create floating balloons
        setInterval(() => {
            const balloon = document.createElement("span");
            balloon.className = "falling-object balloon";
            balloon.style.left = Math.random() * window.innerWidth + "px";
            balloon.style.animationDuration = (6 + Math.random() * 4) + "s";
            balloon.textContent = balloonColors[Math.floor(Math.random() * balloonColors.length)];
            document.body.appendChild(balloon);
            setTimeout(() => balloon.remove(), 10000);
        }, 1200);

        // Create confetti
        setInterval(() => {
            const confetti = document.createElement("div");
            confetti.className = "falling-object confetti";
            confetti.style.left = Math.random() * window.innerWidth + "px";
            confetti.style.backgroundColor = confettiColors[Math.floor(Math.random() * confettiColors.length)];
            confetti.style.animationDuration = (3 + Math.random() * 3) + "s";
            document.body.appendChild(confetti);
            setTimeout(() => confetti.remove(), 6000);
        }, 400);

        // Character counter
        $("#message").on("input", function() {
            const length = $(this).val().length;
            $("#charCount").text(length + "/20");
            
            if (length > 15) {
                $("#charCount").css("color", "#ef4444");
            } else {
                $("#charCount").css("color", "#6b7280");
            }
        });

        // Function to create celebration effects
        function createCelebrationEffects() {
            // Create celebration balloons
            for (let i = 0; i < 20; i++) {
                setTimeout(() => {
                    const balloon = document.createElement("span");
                    balloon.className = "celebration-balloon";
                    balloon.style.left = Math.random() * window.innerWidth + "px";
                    balloon.style.bottom = "-50px";
                    balloon.style.animationDuration = (3 + Math.random() * 2) + "s";
                    balloon.textContent = balloonColors[Math.floor(Math.random() * balloonColors.length)];
                    document.body.appendChild(balloon);
                    setTimeout(() => balloon.remove(), 5000);
                }, i * 200);
            }

            // Create celebration confetti
            for (let i = 0; i < 50; i++) {
                setTimeout(() => {
                    const confetti = document.createElement("div");
                    confetti.className = "celebration-confetti";
                    confetti.style.left = Math.random() * window.innerWidth + "px";
                    confetti.style.backgroundColor = confettiColors[Math.floor(Math.random() * confettiColors.length)];
                    confetti.style.animationDuration = (2 + Math.random() * 3) + "s";
                    document.body.appendChild(confetti);
                    setTimeout(() => confetti.remove(), 5000);
                }, i * 100);
            }
        }

        // Function to show graduation celebration
        function showGraduationCelebration(imageFile, studentName) {
            if (imageFile) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('studentPhoto').src = e.target.result;
                };
                reader.readAsDataURL(imageFile);
            }

            // Update congratulations message with student name (responsive sizing)
            if (studentName) {
                document.getElementById('congratsTitle').innerHTML = `🎉 Congratulations <span class="student-name-title" style="font-size: 3rem; font-weight: 900; color: #10b981; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">${studentName}</span>! 🎉`;
                document.getElementById('congratsMessage').innerHTML = `Congratulations <span class="student-name-message" style="font-size: 1.5rem; font-weight: 800; color: #7c3aed; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">${studentName}</span> on your graduation! It's been amazing watching you grow and achieve so much. We will really miss you! 😢 Wishing you all the best in your next chapter.`;
            }

            document.getElementById('graduationCelebration').style.display = 'flex';
            createCelebrationEffects();
        }

        // Function to close celebration
        function closeCelebration() {
            document.getElementById('graduationCelebration').style.display = 'none';
        }

        // Enhanced form submission with proper database handling
        $("#bit28Form").on("submit", function(e) {
            e.preventDefault();
            
            const message = $("#message").val();
            if (message.length > 20) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Message Too Long',
                    text: 'Please keep your message under 20 characters.',
                    confirmButtonColor: '#1e3a8a'
                });
                return;
            }

            // Show loading state
            const submitBtn = $(".submit-btn");
            const btnText = $(".btn-text");
            const originalText = btnText.text();
            
            submitBtn.prop("disabled", true);
            btnText.html('<span class="loading"></span> Saving...');

            // Get form data
            const imageFile = document.getElementById('imageInput').files[0];
            const studentName = $('input[name="name"]').val();
            let formData = new FormData(this);

            // Submit to database first
            $.ajax({
                url: "<?= base_url('Bit28_a_save') ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Check if response indicates success
                    if(response.status === 'success') {
                        // Data saved successfully - show celebration
                        showGraduationCelebration(imageFile, studentName);
                        
                        // Reset form
                        $("#bit28Form")[0].reset();
                        $("#charCount").text("0/20");
                    } else {
                        // Database save failed - show error
                        Swal.fire({
                            icon: 'error',
                            title: 'Save Failed!',
                            text: response.message || 'Failed to save your graduation memory. Please try again.',
                            confirmButtonColor: '#ef4444'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Network or server error - show error
                    console.error('AJAX Error:', xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Connection Error',
                        text: 'Unable to connect to the server. Please check your internet connection and try again.',
                        confirmButtonColor: '#ef4444'
                    });
                },
                complete: function() {
                    // Always reset button state
                    submitBtn.prop("disabled", false);
                    btnText.text(originalText);
                }
            });
        });

        // Add entrance animations on load
        $(document).ready(function() {
            setTimeout(() => {
                $(".form-card").addClass("animate__animated animate__fadeInUp");
            }, 500);
        });
    </script>
</body>
</html>
