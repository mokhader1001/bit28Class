<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIT28-A Memory Keepsake | Class of 2025</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800;900&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <!-- html2canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --accent-color: #f093fb;
            --card-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
            --hover-shadow: 0 15px 35px rgba(102, 126, 234, 0.25);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #ffffff;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Subtle background pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(118, 75, 162, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(240, 147, 251, 0.03) 0%, transparent 50%);
            pointer-events: none;
            z-index: 1;
        }

        .container-fluid {
            position: relative;
            z-index: 2;
            padding: 15px;
        }

        /* Minimized Beautiful Header Section */
        .header-section {
            text-align: center;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            color: white;
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 6px 25px rgba(102, 126, 234, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
        }

        .university-logo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,0.8);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            margin-bottom: 10px;
            transition: transform 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .university-logo:hover {
            transform: scale(1.05) rotate(5deg);
        }

        /* EXTRA LARGE TEXT - Visible from 10 steps away */
        .main-title {
            font-family: 'Dancing Script', cursive;
            font-size: 5rem;
            font-weight: 900;
            margin-bottom: 5px;
            text-shadow: 3px 3px 10px rgba(0,0,0,0.4);
            position: relative;
            z-index: 2;
            background: linear-gradient(45deg, #fff, #f0f0f0, #fff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 2px;
        }

        .sub-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 8px;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.3);
            position: relative;
            z-index: 2;
            opacity: 0.95;
            letter-spacing: 1px;
        }

        .university-subtitle {
            font-size: 1.3rem;
            margin-bottom: 12px;
            font-weight: 500;
            position: relative;
            z-index: 2;
            opacity: 0.9;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.2);
        }

        .pdf-btn {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 15px rgba(238, 90, 36, 0.4);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 2;
        }

        .pdf-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(238, 90, 36, 0.5);
            color: white;
        }

        .pdf-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .pdf-btn:hover::before {
            left: 100%;
        }

        /* Student Cards Grid - Exactly 6 per row, larger cards */
        .students-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 18px;
            max-height: calc(100vh - 160px);
            overflow-y: auto;
            padding: 20px;
            background: rgba(102, 126, 234, 0.02);
            border-radius: 20px;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        /* Custom Scrollbar */
        .students-grid::-webkit-scrollbar {
            width: 8px;
        }

        .students-grid::-webkit-scrollbar-track {
            background: rgba(102, 126, 234, 0.1);
            border-radius: 10px;
        }

        .students-grid::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }

        .students-grid::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }

        .student-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 18px;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: 2px solid rgba(102, 126, 234, 0.1);
            position: relative;
            overflow: hidden;
        }

        .student-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .student-card:hover::before {
            transform: scaleX(1);
        }

        .student-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--hover-shadow);
            border-color: var(--primary-color);
        }

        .student-photo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .student-photo:hover {
            border-color: var(--accent-color);
            transform: scale(1.1);
        }

        .student-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
            line-height: 1.2;
        }

        .student-message {
            font-size: 0.75rem;
            color: #666;
            font-style: italic;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* PDF Layout Styles - Fixed spacing and layout */
        .pdf-page {
            display: none;
            width: 210mm;
            min-height: 297mm;
            padding: 8mm;
            background: white;
            margin: 0 auto;
            box-sizing: border-box;
            page-break-after: always;
            position: relative;
        }

        .pdf-page.active {
            display: block;
        }

        /* Minimized PDF Header - Only on first page */
        .pdf-header {
            text-align: center;
            margin-bottom: 8mm;
            padding-bottom: 5mm;
            border-bottom: 1px solid var(--primary-color);
        }

        .pdf-logo {
            width: 15mm;
            height: 15mm;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid var(--primary-color);
            margin-bottom: 3mm;
        }

        .pdf-title {
            font-family: 'Dancing Script', cursive;
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 2mm;
            font-weight: 700;
        }

        .pdf-subtitle {
            font-size: 0.9rem;
            color: var(--secondary-color);
            margin-bottom: 2mm;
            font-weight: 600;
        }

        .pdf-university-subtitle {
            font-size: 0.7rem;
            color: #666;
            margin-bottom: 2mm;
        }

        /* PDF Students Grid - Fixed to fit 3 per row properly */
        .pdf-students-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8mm;
            margin-top: 5mm;
            margin-bottom: 10mm;
        }

        .pdf-student-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 8mm;
            text-align: center;
            border: none;
            box-shadow: none;
            max-width: 60mm;
            margin: 0 auto;
        }

        .pdf-student-photo {
            width: 20mm;
            height: 20mm;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid var(--primary-color);
            margin-bottom: 4mm;
        }

        .pdf-student-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 3mm;
            line-height: 1.2;
            word-wrap: break-word;
        }

        .pdf-student-message {
            font-size: 0.65rem;
            color: #666;
            font-style: italic;
            line-height: 1.2;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            word-wrap: break-word;
        }

        /* PDF Footer - Only on last page */
        .pdf-footer {
            position: absolute;
            bottom: 8mm;
            left: 8mm;
            right: 8mm;
            text-align: center;
            padding-top: 3mm;
            border-top: 1px solid #ddd;
            font-size: 0.6rem;
            color: #666;
        }

        .pdf-footer .developer-credit {
            font-weight: 500;
            color: var(--primary-color);
        }

        /* Falling Animation */
        .falling-object {
            position: fixed;
            top: -50px;
            font-size: 20px;
            animation: fall linear forwards;
            opacity: 0.7;
            pointer-events: none;
            z-index: 1000;
        }

        @keyframes fall {
            0% {
                transform: translateY(-50px) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(110vh) rotate(360deg);
                opacity: 0;
            }
        }

        /* Responsive Design */
        @media (max-width: 1400px) {
            .students-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        @media (max-width: 1200px) {
            .students-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 992px) {
            .students-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .main-title {
                font-size: 3.5rem;
            }
            .sub-title {
                font-size: 1.5rem;
            }
            .university-subtitle {
                font-size: 1rem;
            }
        }

        @media (max-width: 768px) {
            .main-title {
                font-size: 2.8rem;
            }
            .sub-title {
                font-size: 1.3rem;
            }
            .university-subtitle {
                font-size: 0.9rem;
            }
            .students-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
                max-height: calc(100vh - 140px);
            }
            .student-photo {
                width: 70px;
                height: 70px;
            }
        }

        @media (max-width: 576px) {
            .students-grid {
                grid-template-columns: repeat(2, 1fr);
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

        /* Hidden PDF container */
        #pdf-container {
            position: absolute;
            left: -9999px;
            top: -9999px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Minimized Beautiful Header Section -->
        <div class="header-section" id="header-section">
            <img 
                src="<?= base_url('public/uploads/SU.jpeg') ?>" 
                alt="SIMAD University Logo" 
                class="university-logo"
            />
            <h1 class="main-title">BIT28-A</h1>
            <h2 class="sub-title">Class of 2025</h2>
            <p class="university-subtitle">SIMAD University - Celebrating Excellence Together</p>
            <button class="btn pdf-btn" onclick="generatePDF()">
                <i class="fas fa-file-pdf me-2"></i>
                <span id="pdf-btn-text">Download PDF</span>
            </button>
        </div>

        <!-- Students Grid - 6 per row -->
        <div class="students-grid" id="students-grid">
            <?php if (!empty($students)) : ?>
                <?php foreach ($students as $index => $student) : ?>
                    <div class="student-card" data-aos="fade-up" data-aos-delay="<?= $index * 50 ?>">
                        <img 
                            src="<?= base_url('uploads/' . $student['image_filename']) ?>" 
                            alt="<?= htmlspecialchars($student['name']) ?>"
                            class="student-photo"
                            onclick="showStudentDetails('<?= htmlspecialchars($student['name']) ?>', '<?= base_url('uploads/' . $student['image_filename']) ?>', '<?= htmlspecialchars($student['message']) ?>')"
                        />
                        <div class="student-name"><?= htmlspecialchars($student['name']) ?></div>
                        <div class="student-message"><?= htmlspecialchars($student['message']) ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <!-- Demo Data for 45 Students -->
                <?php for ($i = 1; $i <= 50; $i++) : ?>
                    <div class="student-card">
                        <img 
                            src="/placeholder.svg?height=90&width=90" 
                            alt="Student <?= $i ?>"
                            class="student-photo"
                            onclick="showStudentDetails('Student <?= $i ?>', '/placeholder.svg?height=200&width=200', 'Congratulations on this amazing journey! Looking forward to our bright future ahead.')"
                        />
                        <div class="student-name">Student Name <?= $i ?></div>
                        <div class="student-message">Congratulations on this amazing journey! Looking forward to our bright future.</div>
                    </div>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Hidden PDF Container -->
    <div id="pdf-container"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Store student data globally
        let studentsData = [];

        // Falling Animation
        const symbols = ["🎓", "📚", "✨", "🌟", "💫", "🎉", "🎊", "💖", "🏆", "🎯"];
        
        function createFallingObject() {
            const span = document.createElement("span");
            span.className = "falling-object";
            span.style.left = Math.random() * window.innerWidth + "px";
            span.style.animationDuration = (4 + Math.random() * 4) + "s";
            span.textContent = symbols[Math.floor(Math.random() * symbols.length)];
            document.body.appendChild(span);
            
            setTimeout(() => span.remove(), 8000);
        }

        // Create falling objects periodically
        setInterval(createFallingObject, 800);

        // Show Student Details
        function showStudentDetails(name, imageSrc, message) {
            Swal.fire({
                title: name,
                text: message,
                imageUrl: imageSrc,
                imageWidth: 250,
                imageHeight: 250,
                imageAlt: name,
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'student-popup'
                },
                background: '#fff',
                backdrop: 'rgba(0,0,0,0.8)'
            });
        }

        // Collect student data from DOM
        function collectStudentData() {
            const cards = document.querySelectorAll('.student-card');
            studentsData = [];
            
            cards.forEach(card => {
                const img = card.querySelector('.student-photo');
                const name = card.querySelector('.student-name').textContent;
                const message = card.querySelector('.student-message').textContent;
                
                studentsData.push({
                    name: name,
                    image: img.src,
                    message: message
                });
            });
        }

        // Create PDF pages with proper layout - 9 students each (3 per row, 3 rows)
        function createPDFPages() {
            const container = document.getElementById('pdf-container');
            container.innerHTML = '';
            
            const studentsPerPage = 9; // 3 cards per row, 3 rows
            const totalPages = Math.ceil(studentsData.length / studentsPerPage);
            
            for (let pageNum = 0; pageNum < totalPages; pageNum++) {
                const startIndex = pageNum * studentsPerPage;
                const endIndex = Math.min(startIndex + studentsPerPage, studentsData.length);
                const pageStudents = studentsData.slice(startIndex, endIndex);
                
                const page = document.createElement('div');
                page.className = 'pdf-page';
                
                // Header only on first page
                const headerHTML = pageNum === 0 ? `
                    <div class="pdf-header">
                        <img src="<?= base_url('public/uploads/SU.jpeg') ?>" alt="SIMAD University Logo" class="pdf-logo" />
                        <h1 class="pdf-title">BIT28-A</h1>
                        <h2 class="pdf-subtitle">Class of 2025</h2>
                        <p class="pdf-university-subtitle">SIMAD University - Celebrating Excellence Together</p>
                    </div>
                ` : '';
                
                // Footer only on last page
                const footerHTML = pageNum === totalPages - 1 ? `
                    <div class="pdf-footer">
                        <p>Maintained and provided by <span class="developer-credit">MYA.Engineer</span></p>
                        <p style="font-size: 0.5rem; margin-top: 2px; color: #999;">Professional Web Development & Engineering Solutions</p>
                    </div>
                ` : '';
                
                page.innerHTML = `
                    ${headerHTML}
                    <div class="pdf-students-grid">
                        ${pageStudents.map(student => `
                            <div class="pdf-student-card">
                                <img src="${student.image}" alt="${student.name}" class="pdf-student-photo" />
                                <div class="pdf-student-name">${student.name}</div>
                                <div class="pdf-student-message">${student.message}</div>
                            </div>
                        `).join('')}
                    </div>
                    ${footerHTML}
                `;
                
                container.appendChild(page);
            }
        }

        // PDF Generation with fixed layout
        async function generatePDF() {
            const button = document.getElementById('pdf-btn-text');
            const originalText = button.innerHTML;
            
            // Show loading state
            button.innerHTML = '<span class="loading"></span> Generating...';
            
            try {
                // Collect student data
                collectStudentData();
                
                // Create PDF pages
                createPDFPages();
                
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });
                
                const pages = document.querySelectorAll('.pdf-page');
                
                for (let i = 0; i < pages.length; i++) {
                    const page = pages[i];
                    page.classList.add('active');
                    
                    // Wait for images to load
                    const images = page.querySelectorAll('img');
                    await Promise.all(Array.from(images).map(img => {
                        return new Promise((resolve) => {
                            if (img.complete) {
                                resolve();
                            } else {
                                img.onload = resolve;
                                img.onerror = resolve;
                            }
                        });
                    }));
                    
                    const canvas = await html2canvas(page, {
                        scale: 2,
                        useCORS: true,
                        allowTaint: true,
                        backgroundColor: '#ffffff',
                        width: 794, // A4 width in pixels at 96 DPI
                        height: 1123 // A4 height in pixels at 96 DPI
                    });
                    
                    const imgData = canvas.toDataURL('image/png');
                    
                    if (i > 0) {
                        pdf.addPage();
                    }
                    
                    // Add image to PDF (full page)
                    pdf.addImage(imgData, 'PNG', 0, 0, 210, 297);
                    
                    page.classList.remove('active');
                }
                
                // Save the PDF
                pdf.save('BIT28-A_Class_of_2025_Memory_Keepsake.pdf');
                
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'PDF Generated Successfully!',
                    html: `
                        <p>Your memory keepsake has been downloaded with:</p>
                        <ul style="text-align: left; display: inline-block;">
                            <li><strong>${Math.ceil(studentsData.length / 9)} pages</strong> total</li>
                            <li><strong>Fixed layout</strong> - all 3 students per row visible</li>
                            <li><strong>Header only on first page</strong></li>
                            <li><strong>Footer only on last page</strong></li>
                            <li><strong>Optimized spacing</strong> - no content cut off</li>
                        </ul>
                    `,
                    timer: 5000,
                    showConfirmButton: true,
                    confirmButtonText: 'Perfect!'
                });
                
            } catch (error) {
                console.error('Error generating PDF:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to generate PDF. Please try again.',
                });
            } finally {
                // Restore button text
                button.innerHTML = originalText;
                
                // Clean up PDF container
                document.getElementById('pdf-container').innerHTML = '';
            }
        }

        // Add smooth scrolling
        document.addEventListener('DOMContentLoaded', function() {
            // Add entrance animation to cards
            const cards = document.querySelectorAll('.student-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 50);
            });
        });

        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                generatePDF();
            }
        });
    </script>
</body>
</html>
