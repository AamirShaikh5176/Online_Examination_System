<?php

$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Session.php');
Session::init();

include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
spl_autoload_register(function($class){
	include_once "classes/".$class.".php";
});

$db   = new Database();
$fm   = new Format();
$exam = new Exam();
$user = new User();
$pro  = new Process();

header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: pre-check=0, post-check=0, max-age=0"); 
header("Pragma: no-cache"); 
header("Expires: Mon, 6 Dec 1977 00:00:00 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
?>
<?php
  if (isset($_GET['action']) && $_GET['action'] == 'logout') {
  	     Session::destroy();
  	     header("Location:index.php");
  	     exit();
  }
?>
<!doctype html>
<html>
<head>
	<title>Online Exam System</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="js/main.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/theme.css">

<style>

/* Navbar Glass Effect */
.navbar {
    background: rgba(15, 32, 39, 0.95) !important;
    backdrop-filter: saturate(180%) blur(20px);
    -webkit-backdrop-filter: saturate(180%) blur(20px);
    box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
    animation: slideDown 0.6s ease-out forwards;
    padding: 12px 0;
    transition: all 0.3s ease;
}

/* Brand */
.navbar-brand {
    font-weight: 700;
    font-size: 22px;
    letter-spacing: 0.5px;
    background: linear-gradient(45deg, #00eaff, #0080ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    transition: transform 0.3s;
    display: flex;
    align-items: center;
}

.navbar-brand i {
    margin-right: 8px;
    font-size: 26px;
    background: linear-gradient(45deg, #00eaff, #0080ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.navbar-brand:hover {
    transform: scale(1.02);
}

/* Nav links */
.nav-link {
    font-weight: 500;
    font-size: 15px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-left: 15px;
    color: rgba(255, 255, 255, 0.8) !important;
    transition: all 0.3s ease;
    position: relative;
    padding: 8px 0 !important;
}

/* Hover underline animation */
.nav-link::after {
    content: '';
    width: 0%;
    height: 3px;
    background: linear-gradient(90deg, #00eaff, #0080ff);
    position: absolute;
    left: 0;
    bottom: -4px;
    border-radius: 2px;
    transition: width 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.nav-link:hover::after, .nav-item.active .nav-link::after {
    width: 100%;
}

/* Hover & Active color */
.nav-link:hover, .nav-item.active .nav-link {
    color: #00eaff !important;
    text-shadow: 0 0 10px rgba(0, 234, 255, 0.3);
}

/* Animation */
@keyframes slideDown {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fa fa-graduation-cap"></i> Online Exam System
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
			<?php
                $login = Session::get("login");
                if ($login == true) {
			?>
			<li class="nav-item active">
              <a class="nav-link" href="#">Welcome <strong><?php echo Session::get("name"); ?></strong></a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="profile.php">Profile</a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="exam.php">Exam</a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="?action=logout">Logout</a>
            </li>
             <?php } else{ ?>
			<li class="nav-item"><a class="nav-link" href="index.php">Login</a></li>
			<li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
            <li class="nav-item"><a class="nav-link" href="admin/">Admin</a></li>
			<?php } ?>
		</ul>
        </div>
      </div>
</nav>

<!-- Spacer (important for fixed navbar) -->
<div style="height:80px;"></div>