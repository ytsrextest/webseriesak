<!-- Recoded by roktim -->
<?php
    include("includes/connection.php");
		include("language/language.php");

	if(isset($_SESSION['admin_name']))
	{
		header("Location:home.php");
		exit;
	}
?>

<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="">
<meta name="description" content="">

<meta name="viewport"content="width=device-width, initial-scale=1.0">
<title><?php echo APP_NAME;?></title>

<!-- Login page css -->
    
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Style created by roktim -->
<style type="text/css">
	body {
		color: #fff;
		background: #f4f3ef;
	}
	.form-control {
        min-height: 41px;
		background: #fff;
		box-shadow: none !important;
		border-color: #e3e3e3;
	}
	.form-control:focus {
		border-color: #70c5c0;
	}
    .form-control, .btn {        
        border-radius: 2px;
    }
	.login-form {
		width: 350px;
		margin: 0 auto;
		padding: 100px 0 30px;		
	}
	.login-form form {
		color: #7a7a7a;
		border-radius: 2px;
    	margin-bottom: 15px;
        font-size: 13px;
        background: #ffffff;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;	
        position: relative;	
    }
	.login-form h2 {
		font-size: 22px;
        margin: 35px 0 25px;
    }
	.login-form .avatar {
		position: absolute;
		margin: 0 auto;
		left: 0;
		right: 0;
		top: -50px;
		width: 95px;
		height: 95px;
		border-radius: 50%;
		z-index: 9;
		background: #f4f3ef;
		padding: 15px;
		box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
	}
	.login-form .avatar img {
		width: 100%;
	}	
    .login-form input[type="checkbox"] {
        margin-top: 2px;
    }
    .login-form .btn {        
        font-size: 16px;
        font-weight: bold;
		background: #70c5c0;
		border: none;
		margin-bottom: 20px;
    }
	.login-form .btn:hover, .login-form .btn:focus {
		background: #50b8b3;
        outline: none !important;
	}    
	.login-form a {
		color: #fff;
		text-decoration: underline;
	}
	.login-form a:hover {
		text-decoration: none;
	}
	.login-form form a {
		color: #7a7a7a;
		text-decoration: none;
	}
	.login-form form a:hover {
		text-decoration: underline;
	}
</style>
  
</head>
<body>
          <div class="login-form">  
            <form action="login_db.php" method="post">
                <div class="avatar">
			<img src="https://library.kissclipart.com/20181002/rhq/kissclipart-person-with-lock-icon-png-clipart-computer-icons-u-5c2827e2f0967bb7.png" alt="login page">
		</div>
        <marquee><h2 class="text-center">-------- <?php echo APP_NAME;?> --------</h2> </marquee>
                
			  <div class="form-group">
                <?php if(isset($_SESSION['msg'])){?>
                <div class="alert alert-danger  alert-dismissible" role="alert"> <?php echo $client_lang[$_SESSION['msg']]; ?> </div>
                <?php unset($_SESSION['msg']);}?>
              </div>
              <div class="form-group">
            	<input type="text" class="form-control" name="username" id="username" value="<?php if (strcasecmp(DEMO, 'yes') == 0) { echo 'admin';} ?>" placeholder="Username" required="required">
             </div>
	       	 <div class="form-group">
              <input type="password" class="form-control" name="password" id="password" value="<?php if (strcasecmp(DEMO, 'yes') == 0) { echo '123456';} ?>" placeholder="Password" required="required">
             </div>
              
              
              <div class="text-center">
                <input type="submit" class="btn btn-success btn-submit" value="Login">
              </div>
              <div class="text-center">
                <h5 class="text-center">
                    <?php if (strcasecmp(DEMO, 'yes') == 0) {
                      echo '<p>Some functions are disabled in demo</p>';
                    } else {
                      echo '';
                    }
                    ?>
                </h5>
              </div>
            </form>
            
            
            
           
            
             </div>
             
             
</body>
</html>
