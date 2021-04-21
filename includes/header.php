<?php include("includes/connection.php");
      include("includes/session_check.php");
      
      //Get file name
      $currentFile = $_SERVER["SCRIPT_NAME"];
      $parts = Explode('/', $currentFile);
      $currentFile = $parts[count($parts) - 1];       
       
      
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="">
<meta name="description" content="">

<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
<title><?php echo APP_NAME;?></title>
<link href="assets/css/tab.less" rel="stylesheet" />

<!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
<!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/video-page.css" rel="stylesheet" />
  <link href="assets/css/paper-dashboard.css?v=2.0.0" rel="stylesheet" />
 <script src="assets/ckeditor/ckeditor.js"></script>
 
 

</head>
<body>
<div class="wrapper">
  <div class="sidebar" data-color="white" data-active-color="danger">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="newhome.php" class="simple-text logo-mini">
       
        </a>
        <a href="#" class="simple-text logo-normal">
           <?php echo APP_NAME;?>
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li <?php if($currentFile=="home.php"){?>class="nav-item active"<?php }?>>
            <a class="nav-link" href="home.php">
             <i class="nc-icon nc-laptop"></i>
              <b>Dashboard</b>
            </a>
          </li>
          <li <?php if($currentFile=="premium.php"){?>class="nav-item active"<?php }?>
              <?php if($currentFile=="add_plan.php"){?>class="nav-item active"<?php }?>
              <?php if($currentFile=="edit_plan.php"){?>class="nav-item active"<?php }?>
              <?php if($currentFile=="delete_plan.php"){?>class="nav-item active"<?php }?>
              <?php if($currentFile=="edit_plan_detail.php"){?>class="nav-item active"<?php }?>
              >
            <a class="nav-link" href="premium.php">
              <i class="nc-icon nc-app"></i>
              <b>Premium Plans</b>
            </a>
          </li>
          <li <?php if($currentFile=="manage_category.php"){?>class="nav-item active"<?php }?>
              <?php if($currentFile=="add_category.php"){?>class="nav-item active"<?php }?>>
            <a class="nav-link" href="manage_category.php">
              <i class="nc-icon nc-paper"></i>
              <b>Categories</b>
            </a>
          </li>
          <li <?php if($currentFile=="manage_videos.php"){?>class="nav-item active"<?php }?>
          <?php if($currentFile=="add_video.php"){?>class="nav-item active"<?php }?>
          <?php if($currentFile=="edit_video.php"){?>class="nav-item active"<?php }?>>
            <a class="nav-link" href="manage_videos.php">
             <i class="nc-icon nc-button-play"></i>
              <b>Videos</b>
            </a>
          </li>
          
          <li <?php if($currentFile=="manage_transaction.php"){?>class="nav-item active"<?php }?>
              >
            <a class="nav-link" href="manage_transaction.php">
             <i class="nc-icon nc-paper"></i>
              <b>Payments</b>
            </a>
          </li>
          
          <li <?php if($currentFile=="manage_giftvouchers.php"){?>class="nav-item active"<?php }?>
              <?php if($currentFile=="add_giftvoucher.php"){?>class="nav-item active"<?php }?>>
            <a class="nav-link" href="manage_giftvouchers.php">
             <i class="nc-icon nc-credit-card"></i>
              <b>Gift Vouchers</b>
            </a>
          </li>
          
          <li <?php if($currentFile=="manage_users.php"){?>class="nav-item active"<?php }?>
              <?php if($currentFile=="add_user.php"){?>class="nav-item active"<?php }?>>
            <a class="nav-link" href="manage_users.php">
              <i class="nc-icon nc-single-02"></i>
              <b>Users</b>
            </a>
          </li>
          <li <?php if($currentFile=="send_notification.php"){?>class="nav-item active"<?php }?>>
            <a class="nav-link" href="send_notification.php">
              <i class="nc-icon nc-bell-55"></i>
              <b>Notification</b>
            </a>
          </li>
          <!--<li <?php if($currentFile=="settings.php"){?>class="nav-item active"<?php }?>>-->
          <!--  <a class="nav-link" href="settings.php">-->
          <!--   <i class="nc-icon nc-settings-gear-65"></i>-->
          <!--    <b>Settings</b>-->
          <!--  </a>-->
          <!--</li>-->
          <li <?php if($currentFile=="profile.php"){?>class="nav-item active"<?php }?>>
            <a class="nav-link" href="profile.php">
              <i class="nc-icon nc-satisfied"></i>
              <b>Profile</b>
            </a>
          </li>
          <li class="active-pro">
            <a class="nav-link" href="logout.php">
             <i class="nc-icon nc-simple-remove"></i>
              <b>Logout</b>
            </a>
          </li>
        </ul>
      </div>
    </div>
    
    
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="home.php">Admin Panel</a>
          </div>
          
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-layout-11"></i>
                  
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="profile.php">Profile</a>
                  <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">