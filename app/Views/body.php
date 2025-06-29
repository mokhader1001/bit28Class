<?= $this->extend("index"); ?>
<?= $this->section('content'); ?>
<br><br>
<div class="dashboard-container">
    <!-- Animated Background -->
    <div class="area">
        <ul class="circles">
            <li></li><li></li><li></li><li></li><li></li>
            <li></li><li></li><li></li><li></li><li></li>
        </ul>
    </div>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="header-content">
            <h2 class="dashboard-title">
                <span class="gradient-text">Library Dashboard</span>
                <div class="underline"></div>
            </h2>
            <button class="btn-refresh">
                <i class="fas fa-sync-alt"></i>
                <span>Refresh</span>
            </button>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="stats-container">
        <!-- Total Books Card -->
        <div class="stat-card books-card">
            <div class="card-glass">
                <div class="icon-container">
                    <div class="icon-wrapper books-icon">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value counter" data-target="0">0</h3>
                    <p class="stat-label">Total Books</p>
                    <div class="progress-container">
                        <div class="progress-bar books-progress" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Library Users Card -->
        <div class="stat-card users-card">
            <div class="card-glass">
                <div class="icon-container">
                    <div class="icon-wrapper users-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value counter" data-target="0">0</h3>
                    <p class="stat-label">Library Users</p>
                    <div class="progress-container">
                        <div class="progress-bar users-progress" style="width: 65%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Authors Card -->
        <div class="stat-card authors-card">
            <div class="card-glass">
                <div class="icon-container">
                    <div class="icon-wrapper authors-icon">
                        <i class="fas fa-user-edit"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value counter" data-target="0">0</h3>
                    <p class="stat-label">Total Authors</p>
                    <div class="progress-container">
                        <div class="progress-bar authors-progress" style="width: 70%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="stat-card orders-card">
            <div class="card-glass">
                <div class="icon-container">
                    <div class="icon-wrapper orders-icon">
                        <i class="far fa-check-circle"></i>
                    </div>
                </div>
                <div class="stat-content">
                    <h3 class="stat-value counter" data-target="576">0</h3>
                    <p class="stat-label">Orders</p>
                    <div class="progress-container">
                        <div class="progress-bar orders-progress" style="width: 50%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Last 5 Registered Users -->
   
</div>

<!-- Add custom CSS -->
<style>
    /* Base Styles */
    :root {
        --primary-gradient: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        --info-gradient: linear-gradient(135deg, #0093E9 0%, #80D0C7 100%);
        --success-gradient: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
        --secondary-gradient: linear-gradient(135deg, #8E2DE2 0%, #4A00E0 100%);
        --text-color: #2d3748;
        --text-light: #718096;
        --card-bg: rgba(255, 255, 255, 0.9);
        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --card-hover-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        --border-radius: 16px;
        --active-color: #38a169;
        --inactive-color: #718096;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8fafc;
        color: var(--text-color);
        overflow-x: hidden;
    }

    /* Animated Background */
    .area {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        z-index: -1;
        background: linear-gradient(to bottom, #f8fafc, #edf2f7);
        overflow: hidden;
    }

    .circles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        margin: 0;
        padding: 0;
    }

    .circles li {
        position: absolute;
        display: block;
        list-style: none;
        width: 20px;
        height: 20px;
        background: rgba(108, 99, 255, 0.1);
        animation: animate 25s linear infinite;
        bottom: -150px;
        border-radius: 50%;
    }

    .circles li:nth-child(1) {
        left: 25%;
        width: 80px;
        height: 80px;
        animation-delay: 0s;
        animation-duration: 20s;
        background: rgba(108, 99, 255, 0.1);
    }

    .circles li:nth-child(2) {
        left: 10%;
        width: 20px;
        height: 20px;
        animation-delay: 2s;
        animation-duration: 12s;
        background: rgba(66, 153, 225, 0.1);
    }

    .circles li:nth-child(3) {
        left: 70%;
        width: 20px;
        height: 20px;
        animation-delay: 4s;
        animation-duration: 15s;
        background: rgba(72, 187, 120, 0.1);
    }

    .circles li:nth-child(4) {
        left: 40%;
        width: 60px;
        height: 60px;
        animation-delay: 0s;
        animation-duration: 18s;
        background: rgba(159, 122, 234, 0.1);
    }

    .circles li:nth-child(5) {
        left: 65%;
        width: 20px;
        height: 20px;
        animation-delay: 0s;
        animation-duration: 14s;
        background: rgba(108, 99, 255, 0.1);
    }

    .circles li:nth-child(6) {
        left: 75%;
        width: 110px;
        height: 110px;
        animation-delay: 3s;
        animation-duration: 25s;
        background: rgba(66, 153, 225, 0.1);
    }

    .circles li:nth-child(7) {
        left: 35%;
        width: 150px;
        height: 150px;
        animation-delay: 7s;
        animation-duration: 30s;
        background: rgba(72, 187, 120, 0.1);
    }

    .circles li:nth-child(8) {
        left: 50%;
        width: 25px;
        height: 25px;
        animation-delay: 15s;
        animation-duration: 45s;
        background: rgba(159, 122, 234, 0.1);
    }

    .circles li:nth-child(9) {
        left: 20%;
        width: 15px;
        height: 15px;
        animation-delay: 2s;
        animation-duration: 35s;
        background: rgba(108, 99, 255, 0.1);
    }

    .circles li:nth-child(10) {
        left: 85%;
        width: 150px;
        height: 150px;
        animation-delay: 0s;
        animation-duration: 40s;
        background: rgba(66, 153, 225, 0.1);
    }

    @keyframes animate {
        0% {
            transform: translateY(0) rotate(0deg);
            opacity: 0.8;
            border-radius: 50%;
        }
        100% {
            transform: translateY(-1000px) rotate(720deg);
            opacity: 0;
            border-radius: 50%;
        }
    }

    /* Dashboard Container */
    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
        position: relative;
        z-index: 1;
    }

    /* Dashboard Header */
    .dashboard-header {
        margin-bottom: 2.5rem;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dashboard-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        position: relative;
    }

    .gradient-text {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        display: inline-block;
    }

    .underline {
        height: 4px;
        width: 60px;
        background: var(--primary-gradient);
        border-radius: 2px;
        margin-top: 8px;
    }

    .btn-refresh {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(106, 17, 203, 0.4);
    }

    .btn-refresh:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(106, 17, 203, 0.6);
    }

    .btn-refresh i {
        font-size: 1rem;
    }

    /* Stats Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        position: relative;
        height: 180px;
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .stat-card:hover {
        transform: translateY(-10px);
    }

    .card-glass {
        position: relative;
        height: 100%;
        width: 100%;
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        padding: 1.5rem;
        display: flex;
        align-items: center;
        overflow: hidden;
        z-index: 1;
    }

    .stat-card:hover .card-glass {
        box-shadow: var(--card-hover-shadow);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: var(--border-radius);
        opacity: 0.8;
        z-index: 0;
    }

    .books-card::before {
        background: var(--primary-gradient);
    }

    .users-card::before {
        background: var(--info-gradient);
    }

    .authors-card::before {
        background: var(--success-gradient);
    }

    .orders-card::before {
        background: var(--secondary-gradient);
    }

    .icon-container {
        position: relative;
        margin-right: 1.5rem;
    }

    .icon-wrapper {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .books-icon {
        background: var(--primary-gradient);
    }

    .users-icon {
        background: var(--info-gradient);
    }

    .authors-icon {
        background: var(--success-gradient);
    }

    .orders-icon {
        background: var(--secondary-gradient);
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
        background-clip: text;
        -webkit-background-clip: text;
        color: var(--text-color);
    }

    .stat-label {
        font-size: 1rem;
        color: var(--text-light);
        margin: 0.25rem 0 1rem;
        font-weight: 500;
    }

    .progress-container {
        height: 8px;
        background-color: rgba(0, 0, 0, 0.05);
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        border-radius: 4px;
    }

    .books-progress {
        background: var(--primary-gradient);
    }

    .users-progress {
        background: var(--info-gradient);
    }

    .authors-progress {
        background: var(--success-gradient);
    }

    .orders-progress {
        background: var(--secondary-gradient);
    }

    /* Users Section */
    .users-section {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        padding: 2rem;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .section-header {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
        color: var(--text-color);
    }

    .section-underline {
        height: 3px;
        width: 50px;
        background: var(--primary-gradient);
        border-radius: 2px;
        margin-top: 8px;
    }

    /* Beautiful Table Styles */
    .table-container {
        overflow-x: auto;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }

    .users-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
    }

    .users-table thead {
        background: linear-gradient(to right, rgba(106, 17, 203, 0.05), rgba(37, 117, 252, 0.05));
    }

    .users-table th {
        padding: 1rem 1.5rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-color);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid rgba(0, 0, 0, 0.05);
        position: relative;
    }

    .users-table th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: var(--primary-gradient);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .users-table thead:hover th::after {
        transform: scaleX(1);
    }

    .users-table tbody tr {
        background-color: white;
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        opacity: 0;
        animation: fadeIn 0.5s forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .users-table tbody tr:hover {
        background-color: rgba(106, 17, 203, 0.02);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        z-index: 1;
        position: relative;
    }

    .users-table td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-top: 1px solid rgba(0, 0, 0, 0.02);
    }

    /* User Cell Styling */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .user-avatar {
        position: relative;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        border: 2px solid white;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .status-dot {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
    }

    .status-dot.active {
        background-color: var(--active-color);
    }

    .status-dot.inactive {
        background-color: var(--inactive-color);
    }

    .user-info {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        color: var(--text-color);
    }

    .user-joined {
        font-size: 0.8rem;
        color: var(--text-light);
        margin: 0;
    }

    .user-joined .highlight {
        color: #4c51bf;
        font-weight: 600;
    }

    /* Table Cell Styling */
    .table-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .cell-icon {
        color: #4c51bf;
        font-size: 0.9rem;
        opacity: 0.8;
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.35rem 1rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-badge.active {
        background-color: rgba(72, 187, 120, 0.1);
        color: var(--active-color);
    }

    .status-badge.inactive {
        background-color: rgba(160, 174, 192, 0.1);
        color: var(--inactive-color);
    }

    .no-data {
        text-align: center;
        padding: 3rem 0;
        color: var(--text-light);
    }

    .no-data i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Responsive Styles */
    @media (max-width: 992px) {
        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 1.5rem;
        }
        
        .dashboard-title {
            font-size: 2rem;
        }
        
        .users-table {
            min-width: 800px;
        }
    }

    @media (max-width: 576px) {
        .stats-container {
            grid-template-columns: 1fr;
        }
        
        .header-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .btn-refresh {
            align-self: flex-start;
        }
    }
</style>

<!-- Add JavaScript for animations -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter animation
    const counters = document.querySelectorAll('.counter');
    const speed = 200;
    
    counters.forEach(counter => {
        const animate = () => {
            const value = +counter.getAttribute('data-target');
            const data = +counter.innerText;
            
            const time = value / speed;
            
            if (data < value) {
                counter.innerText = Math.ceil(data + time);
                setTimeout(animate, 1);
            } else {
                counter.innerText = value;
            }
        }
        
        animate();
    });
    
    // Add hover effect to stat cards
    const statCards = document.querySelectorAll('.stat-card');
    
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.icon-wrapper');
            icon.style.transform = 'scale(1.1) rotate(10deg)';
        });
        
        card.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.icon-wrapper');
            icon.style.transform = 'scale(1) rotate(0)';
        });
    });
    
    // Add refresh button animation
    const refreshBtn = document.querySelector('.btn-refresh');
    
    refreshBtn.addEventListener('click', function() {
        const icon = this.querySelector('i');
        icon.style.transition = 'transform 0.5s ease';
        icon.style.transform = 'rotate(360deg)';
        
        setTimeout(() => {
            icon.style.transform = 'rotate(0)';
        }, 500);
    });
    
    // Add staggered animation to table rows
    const tableRows = document.querySelectorAll('.table-row');
    
    tableRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Add hover effect to table headers
    const tableHeaders = document.querySelectorAll('.users-table th');
    
    tableHeaders.forEach(header => {
        header.addEventListener('mouseenter', function() {
            this.style.color = '#4c51bf';
        });
        
        header.addEventListener('mouseleave', function() {
            this.style.color = '';
        });
    });
});
</script>

<?= $this->endSection(); ?>