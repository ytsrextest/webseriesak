<?php include('includes/header.php');

    include('includes/function.php');
	include('language/language.php'); 

 	require_once("thumbnail_images.class.php");
	 
	 
	if(isset($_POST['submit']) and isset($_GET['add']))
	{		
            if((strcasecmp(DEMO, 'no') == 0)) {
    			$data = array(
    			'user_type'=>'Normal',	
    			'name'  =>  $_POST['name'],
    			'email'  =>  $_POST['email'],
    			'password'  =>  $_POST['password'],
    			'phone'  =>  $_POST['phone']
    			);
    
    			$qry = Insert('tbl_users',$data);
    
    		
    			$_SESSION['msg']="10";
    			header("location:manage_users.php");	 
    			exit;
            }
		
	}
	
	if(isset($_GET['user_id']))
	{
			 
			$user_qry="SELECT * FROM tbl_users where id='".$_GET['user_id']."'";
			$user_result=mysqli_query($mysqli,$user_qry);
			$user_row=mysqli_fetch_assoc($user_result);
		
	}
	
	if(isset($_POST['submit']) and isset($_POST['user_id']))
	{
        if((strcasecmp(DEMO, 'no') == 0)) {
    	  $var = $_POST['datepicker'];
    	  $date = str_replace('/', '-', $var);
          $vardate = date("Y-m-d", strtotime($date) ).' 00:00:00';
            
    		if($_POST['password']!="")
    		{
    			$data = array(
    			'name'  =>  $_POST['name'],
    			'email'  =>  $_POST['email'],
    			'password'  =>  $_POST['password'],
    			'phone'  =>  $_POST['phone'],
    			'planend'  =>  $vardate
    			);
    		}
    		else
    		{
    			$data = array(
    			'name'  =>  $_POST['name'],
    			'email'  =>  $_POST['email'],
    			'password'  =>  $_POST['password'],
    			'phone'  =>  $_POST['phone'],
    			'planend'  =>  $vardate
    			);
    		}
    		
            // echo $_POST['email'];
            // echo $_POST['password'];
            // echo $_POST['phone'];
            // echo $vardate;
 
		
		   $user_edit=Update('tbl_users', $data, "WHERE id = '".$_POST['user_id']."'");
		 
			if ($user_edit > 0){
				
				$_SESSION['msg']="11";
				header("Location:add_user.php?user_id=".$_POST['user_id']);
				exit;
			} 	
        }
		
	 
	}
	
	
?>
  
  <!--Rajan-->
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  
 <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
                                <h4 class="card-title">User Manager </h4>
                            </div>
          <div class="clearfix"></div>
          <div class="row mrg-top">
            <div class="col-md-12">
               
              <div class="col-md-12 col-sm-12">
                <?php if(isset($_SESSION['msg'])){?> 
               	 <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                	<?php echo $client_lang[$_SESSION['msg']] ; ?></a> </div>
                <?php unset($_SESSION['msg']);}?>	
              </div>
            </div>
          </div>
          <div class="card-body mrg_bottom"> 
            <form action="" name="addedituser" method="post" class="form form-horizontal" enctype="multipart/form-data" >
            	<input  type="hidden" name="user_id" value="<?php echo $_GET['user_id'];?>" />

              <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-3 control-label">Name :-</label>
                    <div class="col-md-6">
                      <input type="text" name="name" id="name" value="<?php if(isset($_GET['user_id'])){echo $user_row['name'];}?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Email :-</label>
                    <div class="col-md-6">
                      <input type="email" name="email" id="email" value="<?php if(isset($_GET['user_id'])){echo $user_row['email'];}?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group" style="display:none;">
                    <label class="col-md-3 control-label">Password :-</label>
                    <div class="col-md-6">
                      <input type="password" name="password" id="password" value="" class="form-control" <?php if(!isset($_GET['user_id'])){?>required<?php }?>>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Google Id :-</label>
                    <div class="col-md-6">
                      <input type="text" name="phone" id="phone" value="<?php if(isset($_GET['user_id'])){echo $user_row['phone'];}?>" class="form-control">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Premium Plan End Date :-</label>
                    <div class="col-md-6">
                      <input type="date" id="datepicker" name="datepicker" value="<?php
                      $var = $user_row['planend'];
                	  $date = str_replace('/', '-', $var);
                      $vardate = date("Y-m-d", strtotime($var));
                       echo $vardate;
                       ?>" class="form-control" placeholder="DD/MM/YYYY">
                    </div>
                  </div>
                   
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                        <?php if (strcasecmp(DEMO, 'yes') == 0) {
                              echo '<button type="submit" name="submit" class="btn btn-primary btn-round" disabled>Save</button>';
                              echo '<p>---This option is disabled in demo---</p>';
                          } else {
                              echo '<button type="submit" name="submit" class="btn btn-primary btn-round">Save</button>';
                          }
                          ?>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    
   

<?php include('includes/footer.php');?>                  