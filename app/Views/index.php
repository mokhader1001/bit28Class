<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Kaiadmin - Bootstrap 5 Admin Dashboard</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="<?php echo base_url(); ?>public/assets/img/kaiadmin/favicon.ico" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="<?php echo base_url(); ?>public/assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Public Sans:300,400,500,600,700"]},
			custom: {"families":["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['<?= base_url(); ?>/public/assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/assets/css/plugins.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/assets/css/kaiadmin.min.css">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/assets/css/demo.css">
</head>
<body>
	<div class="wrapper">
		<!-- Sidebar -->
		<div class="sidebar" data-background-color="dark">
			<div class="sidebar-logo">
				<!-- Logo Header -->
				<div class="logo-header" data-background-color="dark">

					<a href="<?php echo base_url(); ?>body" class="logo">
<img src="<?php echo base_url('public/uploads/SU.jpeg'); ?>" alt="navbar brand" class="navbar-brand large-logo rounded-circle">

<style>
	.large-logo {
		height: 90px;
		width: 70px;
		object-fit: cover;
		border-radius: 50% !important;
	}
</style>

					</a>
					<div class="nav-toggle">
						<button class="btn btn-toggle toggle-sidebar">
							<i class="gg-menu-right"></i>
						</button>
						<button class="btn btn-toggle sidenav-toggler">
							<i class="gg-menu-left"></i>
						</button>
					</div>
					<button class="topbar-toggler more">
						<i class="gg-more-vertical-alt"></i>
					</button>

				</div>
				<!-- End Logo Header -->	
			</div>	
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
	<div class="sidebar-content">
		<ul class="nav nav-secondary">

			<!-- Dashboard -->
		<li class="nav-item active">
    <a href="<?= base_url('body') ?>" class="nav-link">
        <i class="fas fa-home"></i>
        <p>Dashboard</p>
    </a>
</li>


		
			<!-- Class Management -->
			<li class="nav-item">
				<a data-bs-toggle="collapse" href="#classManagementMenu" class="collapsed" aria-expanded="false">
					<i class="fas fa-chalkboard-teacher"></i> <!-- Class management icon -->
					<p>Class Management</p>
					<span class="caret"></span>
				</a>
				<div class="collapse" id="classManagementMenu">
					<ul class="nav nav-collapse">
						<li>
							<a href="<?= base_url('Quiz-Manager/Class') ?>">
								<span class="sub-item">Class</span>
							</a>
						</li>
					</ul>
				</div>
			</li>

			
		<li class="nav-item">
    <a data-bs-toggle="collapse" href="#base" class="collapsed" aria-expanded="false">
        <i class="fas fa-user-graduate"></i> <!-- Student icon -->
        <p>Students Manager</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="base">
        <ul class="nav nav-collapse">
            <li>
                <a href="<?= base_url(); ?>Bit28/Students_confirmations">
                    <span class="sub-item">Students Confirmations</span>
                </a>
            </li>
            
        </ul>
    </div>
</li>


	<!-- Sidebar Layouts -->
<li class="nav-item">
	<a data-bs-toggle="collapse" href="#sidebarLayouts" class="collapsed" aria-expanded="false">
		<i class="fas fa-users"></i> <!-- Changed to fa-users for Library Users -->
		<p>Library Users</p>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="sidebarLayouts">
		<ul class="nav nav-collapse">
			<li><a href="<?php echo base_url(); ?>lib"><span class="sub-item">Add Users</span></a></li>
		</ul>
	</div>
</li>


			<!-- Forms -->
			<li class="nav-item">
    <a data-bs-toggle="collapse" href="#libraryStaffMenu" class="collapsed" aria-expanded="false">
        <i class="fas fa-user-tie"></i> <!-- 👈 Changed icon to user-tie (professional staff icon) -->
        <p>Library Staff</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="libraryStaffMenu">
        <ul class="nav nav-collapse">
            <li>
                <a href="<?= base_url(); ?>staff/users">
                    <span class="sub-item">Manage Staff</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<!-- Library Roles & Policies -->
<li class="nav-item">
	<a data-bs-toggle="collapse" href="#libraryRoles" class="collapsed" aria-expanded="false">
		<i class="fas fa-user-shield"></i> <!-- Professional icon for roles/policies -->
		<p>Library Roles & Policies</p>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="libraryRoles">
		<ul class="nav nav-collapse">
			<li>
				<a href="<?= base_url(); ?>libaray/rules">
					<span class="sub-item">Manage Roles & Access</span>
				</a>
			</li>
		</ul>
	</div>
</li>



<li class="nav-item">
    <a data-bs-toggle="collapse" href="#finance" class="collapsed" aria-expanded="false">
        <i class="fas fa-coins"></i>
        <p>Finance & Penalties</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="finance">
        <ul class="nav nav-collapse">
            <li>
                <a href="<?= base_url(); ?>finance/charges">
                    <span class="sub-item">Penalty & Damage Charges</span>
                </a>


				<a href="<?= base_url(); ?>cancel_cahrge">
                    <span class="sub-item">Cancel Charge</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<!-- User Logs -->
<li class="nav-item">
    <a data-bs-toggle="collapse" href="#userLogsMenu" class="nav-link" role="button" aria-expanded="false">
        <i class="fas fa-user-clock"></i>
        <p>User Logs</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="userLogsMenu">
        <ul class="nav flex-column ms-3">
            <li class="nav-item">
                <a href="<?= base_url('Admin/loginLogs') ?>" class="nav-link">
                    <i class="fas fa-sign-in-alt"></i> Login History
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('user-logs/activity') ?>" class="nav-link">
                    <i class="fas fa-tasks"></i> Activity Logs
                </a>
            </li>
        </ul>
    </div>
</li>

<!-- Finance -->
<li class="nav-item">
    <a data-bs-toggle="collapse" href="#financeMenu" class="nav-link" role="button" aria-expanded="false">
        <i class="fas fa-coins"></i>
        <p>Finance</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="financeMenu">
        <ul class="nav flex-column ms-3">
            <li class="nav-item">
                <a href="<?= base_url('Finance/Payments') ?>" class="nav-link">
                    <i class="fas fa-arrow-down"></i> Income
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('finance/expenses') ?>" class="nav-link">
                    <i class="fas fa-arrow-up"></i> Expenses
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('finance/transactions') ?>" class="nav-link">
                    <i class="fas fa-exchange-alt"></i> Transactions
                </a>
            </li>
        </ul>
    </div>
</li>

<!-- Reports -->
<li class="nav-item">
    <a data-bs-toggle="collapse" href="#reportsMenu" class="nav-link" role="button" aria-expanded="false">
        <i class="fas fa-chart-line"></i>
        <p>Reports</p>
        <span class="caret"></span>
    </a>
    <div class="collapse" id="reportsMenu">
        <ul class="nav flex-column ms-3">
            <li class="nav-item">
                <a href="<?= base_url('reports/borrowed-books') ?>" class="nav-link">
                    <i class="fas fa-book-reader"></i> Borrowed Books
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('reports/finance-summary') ?>" class="nav-link">
                    <i class="fas fa-chart-pie"></i> Finance Summary
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('reports/daily') ?>" class="nav-link">
                    <i class="fas fa-calendar-day"></i> Daily Report
                </a>
            </li>
        </ul>
    </div>
</li>


	<!-- Logout -->
<li class="nav-item">
    <a href="<?= base_url('logout') ?>" class="nav-link text-danger">
        <i class="fas fa-sign-out-alt"></i>
        <p>Logout</p>
    </a>
</li>


		</ul>
	</div>
</div>

		</div>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="main-header">
				<div class="main-header-logo">
					<!-- Logo Header -->
					<div class="logo-header" data-background-color="dark">

						<a href="<?php echo base_url(); ?>public/index.html" class="logo">
							<img src="<?php echo base_url(); ?>public/assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20">
						</a>
						<div class="nav-toggle">
							<button class="btn btn-toggle toggle-sidebar">
								<i class="gg-menu-right"></i>
							</button>
							<button class="btn btn-toggle sidenav-toggler">
								<i class="gg-menu-left"></i>
							</button>
						</div>
						<button class="topbar-toggler more">
							<i class="gg-more-vertical-alt"></i>
						</button>

					</div>
					<!-- End Logo Header -->
				</div>
				<!-- Navbar Header -->
				<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">

					<div class="container-fluid">
						<nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
							<div class="input-group">
								<div class="input-group-prepend">
									<button type="submit" class="btn btn-search pe-1">
										<i class="fa fa-search search-icon"></i>
									</button>
								</div>
								<input type="text" placeholder="Search ..." class="form-control">
							</div>
						</nav>

						<ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
							<li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
								<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="<?php echo base_url(); ?>public/#" role="button" aria-expanded="false" aria-haspopup="true">
									<i class="fa fa-search"></i>
								</a>
								<ul class="dropdown-menu dropdown-search animated fadeIn">
									<form class="navbar-left navbar-form nav-search">
										<div class="input-group">
											<input type="text" placeholder="Search ..." class="form-control">
										</div>
									</form>
								</ul>
							</li>
							<li class="nav-item topbar-icon dropdown hidden-caret">
								<a class="nav-link dropdown-toggle" href="<?php echo base_url(); ?>public/#" id="messageDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-envelope"></i>
								</a>
								<ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
									<li>
										<div class="dropdown-title d-flex justify-content-between align-items-center">
											Messages 									
											<a href="<?php echo base_url(); ?>public/#" class="small">Mark all as read</a>
										</div>
									</li>
									<li>
										<div class="message-notif-scroll scrollbar-outer">
											<div class="notif-center">
												<a href="<?php echo base_url(); ?>public/#">
													<div class="notif-img"> 
														<img src="<?php echo base_url(); ?>public/assets/img/jm_denis.jpg" alt="Img Profile">
													</div>
													<div class="notif-content">
														<span class="subject">Jimmy Denis</span>
														<span class="block">
															How are you ?
														</span>
														<span class="time">5 minutes ago</span> 
													</div>
												</a>
												<a href="<?php echo base_url(); ?>public/#">
													<div class="notif-img"> 
														<img src="<?php echo base_url(); ?>public/assets/img/chadengle.jpg" alt="Img Profile">
													</div>
													<div class="notif-content">
														<span class="subject">Chad</span>
														<span class="block">
															Ok, Thanks !
														</span>
														<span class="time">12 minutes ago</span> 
													</div>
												</a>
												<a href="<?php echo base_url(); ?>public/#">
													<div class="notif-img"> 
														<img src="<?php echo base_url(); ?>public/assets/img/mlane.jpg" alt="Img Profile">
													</div>
													<div class="notif-content">
														<span class="subject">Jhon Doe</span>
														<span class="block">
															Ready for the meeting today...
														</span>
														<span class="time">12 minutes ago</span> 
													</div>
												</a>
												<a href="<?php echo base_url(); ?>public/#">
													<div class="notif-img"> 
														<img src="<?php echo base_url(); ?>public/assets/img/talha.jpg" alt="Img Profile">
													</div>
													<div class="notif-content">
														<span class="subject">Talha</span>
														<span class="block">
															Hi, Apa Kabar ?
														</span>
														<span class="time">17 minutes ago</span> 
													</div>
												</a>
											</div>
										</div>
									</li>
									<li>
										<a class="see-all" href="<?php echo base_url(); ?>public/javascript:void(0);">See all messages<i class="fa fa-angle-right"></i> </a>
									</li>
								</ul>
							</li>
							<li class="nav-item topbar-icon dropdown hidden-caret">
								<a class="nav-link dropdown-toggle" href="<?php echo base_url(); ?>public/#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="fa fa-bell"></i>
									<span class="notification">4</span>
								</a>
								<ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
									<li>
										<div class="dropdown-title">You have 4 new notification</div>
									</li>
									<li>
										<div class="notif-scroll scrollbar-outer">
											<div class="notif-center">
												<a href="<?php echo base_url(); ?>public/#">
													<div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i> </div>
													<div class="notif-content">
														<span class="block">
															New user registered
														</span>
														<span class="time">5 minutes ago</span> 
													</div>
												</a>
												<a href="<?php echo base_url(); ?>public/#">
													<div class="notif-icon notif-success"> <i class="fa fa-comment"></i> </div>
													<div class="notif-content">
														<span class="block">
															Rahmad commented on Admin
														</span>
														<span class="time">12 minutes ago</span> 
													</div>
												</a>
												<a href="<?php echo base_url(); ?>public/#">
													<div class="notif-img"> 
														<img src="<?php echo base_url(); ?>public/assets/img/profile2.jpg" alt="Img Profile">
													</div>
													<div class="notif-content">
														<span class="block">
															Reza send messages to you
														</span>
														<span class="time">12 minutes ago</span> 
													</div>
												</a>
												<a href="<?php echo base_url(); ?>public/#">
													<div class="notif-icon notif-danger"> <i class="fa fa-heart"></i> </div>
													<div class="notif-content">
														<span class="block">
															Farrah liked Admin
														</span>
														<span class="time">17 minutes ago</span> 
													</div>
												</a>
											</div>
										</div>
									</li>
									<li>
										<a class="see-all" href="<?php echo base_url(); ?>public/javascript:void(0);">See all notifications<i class="fa fa-angle-right"></i> </a>
									</li>
								</ul>
							</li>
							<li class="nav-item topbar-icon dropdown hidden-caret">
								<a class="nav-link" data-bs-toggle="dropdown" href="<?php echo base_url(); ?>public/#" aria-expanded="false">
									<i class="fas fa-layer-group"></i>
								</a>
								<div class="dropdown-menu quick-actions animated fadeIn">
									<div class="quick-actions-header">
										<span class="title mb-1">Quick Actions</span>
										<span class="subtitle op-7">Shortcuts</span>
									</div>
									<div class="quick-actions-scroll scrollbar-outer">
										<div class="quick-actions-items">
											<div class="row m-0">
												<a class="col-6 col-md-4 p-0" href="<?php echo base_url(); ?>public/#">
													<div class="quick-actions-item">
														<div class="avatar-item bg-danger rounded-circle">
															<i class="far fa-calendar-alt"></i>
														</div>
														<span class="text">Calendar</span>
													</div>
												</a>
												<a class="col-6 col-md-4 p-0" href="<?php echo base_url(); ?>public/#">
													<div class="quick-actions-item">
														<div class="avatar-item bg-warning rounded-circle">
															<i class="fas fa-map"></i>
														</div>
														<span class="text">Maps</span>
													</div>
												</a>
												<a class="col-6 col-md-4 p-0" href="<?php echo base_url(); ?>public/#">
													<div class="quick-actions-item">
														<div class="avatar-item bg-info rounded-circle">
															<i class="fas fa-file-excel"></i>
														</div>
														<span class="text">Reports</span>
													</div>
												</a>
												<a class="col-6 col-md-4 p-0" href="<?php echo base_url(); ?>public/#">
													<div class="quick-actions-item">
														<div class="avatar-item bg-success rounded-circle">
															<i class="fas fa-envelope"></i>
														</div>
														<span class="text">Emails</span>
													</div>
												</a>
												<a class="col-6 col-md-4 p-0" href="<?php echo base_url(); ?>public/#">
													<div class="quick-actions-item">
														<div class="avatar-item bg-primary rounded-circle">
															<i class="fas fa-file-invoice-dollar"></i>
														</div>
														<span class="text">Invoice</span>
													</div>
												</a>
												<a class="col-6 col-md-4 p-0" href="<?php echo base_url(); ?>public/#">
													<div class="quick-actions-item">
														<div class="avatar-item bg-secondary rounded-circle">
															<i class="fas fa-credit-card"></i>
														</div>
														<span class="text">Payments</span>
													</div>
												</a>
											</div>
										</div>
									</div>
								</div>
							</li>
							
							<li class="nav-item topbar-user dropdown hidden-caret">
	<a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
		<div class="avatar-sm">
		<img 
		src="<?= base_url('public/uploads/staff/' . (session()->get('image') ?? 'default.jpg')) ?>" 
		alt="profile image" 
				class="avatar-img rounded"
				>
		</div>
		<span class="profile-username">
			<span class="op-7">Hi,</span>
			<span class="fw-bold"><?= session()->get('username') ?></span>
		</span>
	</a>
	<ul class="dropdown-menu dropdown-user animated fadeIn">
		<div class="dropdown-user-scroll scrollbar-outer">
		<li>
	<div class="user-box">
		<div class="avatar-lg">
			<img 
				src="<?= base_url('public/uploads/staff/' . (session()->get('image') ?? 'default.jpg')) ?>" 
				alt="profile image" 
				class="avatar-img rounded"
			>
		</div>
		<div class="u-text">
			<h4><?= session()->get('username') ?></h4>
			<p class="text-muted"><?= session()->get('email') ?></p>
			<a href="<?php echo base_url(); ?>user/view_profile" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
		</div>
	</div>
</li>

			<li>
				<div class="dropdown-divider"></div>
				
 			</li>
		</div>
	</ul>
</li>

						</ul>
					</div>
				</nav>
				<!-- End Navbar -->
			</div>
			
			<div class="page-wrapper" style="display: block;">

<?= $this->renderSection('content'); ?>



</div>
			
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						<ul class="nav">
							<li class="nav-item">
								<a class="nav-link" href="<?php echo base_url(); ?>public/http://www.themekita.com">
									ThemeKita
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo base_url(); ?>public/#">
									Help
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo base_url(); ?>public/#">
									Licenses
								</a>
							</li>
						</ul>
					</nav>
					<div class="copyright ms-auto">
						2024, made with <i class="fa fa-heart heart text-danger"></i> by <a href="<?php echo base_url(); ?>public/http://www.themekita.com">ThemeKita</a>
					</div>				
				</div>
			</footer>
		</div>
		
		<!-- Custom template | don't include it in your project! -->
		<div class="custom-template">
			<div class="title">Settings</div>
			<div class="custom-content">
				<div class="switcher">
					<div class="switch-block">
						<h4>Logo Header</h4>
						<div class="btnSwitch">
							<button type="button" class=" selected changeLogoHeaderColor" data-color="dark"></button>
							<button type="button" class="changeLogoHeaderColor" data-color="blue"></button>
							<button type="button" class="changeLogoHeaderColor" data-color="purple"></button>
							<button type="button" class="changeLogoHeaderColor" data-color="light-blue"></button>
							<button type="button" class="changeLogoHeaderColor" data-color="green"></button>
							<button type="button" class="changeLogoHeaderColor" data-color="orange"></button>
							<button type="button" class="changeLogoHeaderColor" data-color="red"></button>
							<button type="button" class="changeLogoHeaderColor" data-color="white"></button>
							<br/>
							<button type="button" class="changeLogoHeaderColor" data-color="dark2"></button>
							<button type="button" class="changeLogoHeaderColor" data-color="blue2"></button>
							<button type="button" class="changeLogoHeaderColor" data-color="purple2"></button>
							<button type="button" class="changeLogoHeaderColor" data-color="light-blue2"></button>
							<button type="button" class="changeLogoHeaderColor" data-color="green2"></button>
							<button type="button" class="changeLogoHeaderColor" data-color="orange2"></button>
							<button type="button" class="changeLogoHeaderColor" data-color="red2"></button>
						</div>
					</div>
					<div class="switch-block">
						<h4>Navbar Header</h4>
						<div class="btnSwitch">
							<button type="button" class="changeTopBarColor" data-color="dark"></button>
							<button type="button" class="changeTopBarColor" data-color="blue"></button>
							<button type="button" class="changeTopBarColor" data-color="purple"></button>
							<button type="button" class="changeTopBarColor" data-color="light-blue"></button>
							<button type="button" class="changeTopBarColor" data-color="green"></button>
							<button type="button" class="changeTopBarColor" data-color="orange"></button>
							<button type="button" class="changeTopBarColor" data-color="red"></button>
							<button type="button" class="selected changeTopBarColor" data-color="white"></button>
							<br/>
							<button type="button" class="changeTopBarColor" data-color="dark2"></button>
							<button type="button" class="changeTopBarColor" data-color="blue2"></button>
							<button type="button" class="changeTopBarColor" data-color="purple2"></button>
							<button type="button" class="changeTopBarColor" data-color="light-blue2"></button>
							<button type="button" class="changeTopBarColor" data-color="green2"></button>
							<button type="button" class="changeTopBarColor" data-color="orange2"></button>
							<button type="button" class="changeTopBarColor" data-color="red2"></button>
						</div>
					</div>
					<div class="switch-block">
						<h4>Sidebar</h4>
						<div class="btnSwitch">
							<button type="button" class="changeSideBarColor" data-color="white"></button>
							<button type="button" class="selected changeSideBarColor" data-color="dark"></button>
							<button type="button" class="changeSideBarColor" data-color="dark2"></button>
						</div>
					</div>
				</div>
			</div>
			<div class="custom-toggle">
				<i class="icon-settings"></i>
			</div>
		</div>
		<!-- End Custom template -->

	</div>
	<!--   Core JS Files   -->
	<script src="<?php echo base_url(); ?>public/assets/js/core/jquery-3.7.1.min.js"></script>
	<script src="<?php echo base_url(); ?>public/assets/js/core/popper.min.js"></script>
	<script src="<?php echo base_url(); ?>public/assets/js/core/bootstrap.min.js"></script>

	<!-- jQuery Scrollbar -->
	<script src="<?php echo base_url(); ?>public/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

	<!-- Chart JS -->
	<script src="<?php echo base_url(); ?>public/assets/js/plugin/chart.js/chart.min.js"></script>

	<!-- jQuery Sparkline -->
	<script src="<?php echo base_url(); ?>public/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

	<!-- Chart Circle -->
	<script src="<?php echo base_url(); ?>public/assets/js/plugin/chart-circle/circles.min.js"></script>

	<!-- Datatables -->
	<script src="<?php echo base_url(); ?>public/assets/js/plugin/datatables/datatables.min.js"></script>

	<!-- Bootstrap Notify -->
	<script src="<?php echo base_url(); ?>public/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

	<!-- jQuery Vector Maps -->
	<script src="<?php echo base_url(); ?>public/assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
	<script src="<?php echo base_url(); ?>public/assets/js/plugin/jsvectormap/world.js"></script>

	<!-- Sweet Alert -->
	<script src="<?php echo base_url(); ?>public/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

	<!-- Kaiadmin JS -->
	<script src="<?php echo base_url(); ?>public/assets/js/kaiadmin.min.js"></script>

	<!-- Kaiadmin DEMO methods, don't include it in your project! -->
	<script src="<?php echo base_url(); ?>public/assets/js/setting-demo.js"></script>
	<script src="<?php echo base_url(); ?>public/assets/js/demo.js"></script>
	<script>
		$('#lineChart').sparkline([102,109,120,99,110,105,115], {
			type: 'line',
			height: '70',
			width: '100%',
			lineWidth: '2',
			lineColor: '#177dff',
			fillColor: 'rgba(23, 125, 255, 0.14)'
		});

		$('#lineChart2').sparkline([99,125,122,105,110,124,115], {
			type: 'line',
			height: '70',
			width: '100%',
			lineWidth: '2',
			lineColor: '#f3545d',
			fillColor: 'rgba(243, 84, 93, .14)'
		});

		$('#lineChart3').sparkline([105,103,123,100,95,105,115], {
			type: 'line',
			height: '70',
			width: '100%',
			lineWidth: '2',
			lineColor: '#ffa534',
			fillColor: 'rgba(255, 165, 52, .14)'
		});
	</script>
</body>
</html>