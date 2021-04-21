<?php 
    
    $coupons= '';

    include('includes/header.php');

    include('includes/function.php');
	include('language/language.php'); 

 	require_once("thumbnail_images.class.php");
	
	if(isset($_POST['submit']) and isset($_GET['add']))
	{
	    
        if (isset($_POST['count'])) {
            		include 'class.coupon.php';
            		$no_of_coupons = $_POST['count'];
            		$length = '10';
            // 		$prefix = $_POST['prefix'];
            // 		$suffix = $_POST['suffix'];
            // 		$numbers = $_POST['numbers'];
            // 		$letters = $_POST['letters'];
            // 		$symbols = $_POST['symbols'];
            		$random_register = $_POST['random_register'] == 'false' ? false : true;
            		$mask = $_POST['mask'] == '' ? false : $_POST['mask'];
            		$coupons = coupon::generate_coupons($no_of_coupons, $length, $prefix, $suffix, $numbers, $letters, $symbols, $random_register, $mask);
            		foreach ($coupons as $key => $value) {
            // 			echo $value."\n ";
            		}
            // 		die();
    	}
        
        $vouchers = '';
        
    	foreach ($coupons as $key => $value) {
    // 			echo $value."\n ";
                if($vouchers == '') {
                    $vouchers = $vouchers.$value;
                } else {
                    $vouchers = $vouchers.',<br>'.$value;
                }
    			
    			$data = array('days'  =>  $_POST['days'],
    			'vouchercode'  =>  $value
    			);
    
    			$qry = Insert('giftvoucher',$data);
            			
		}
	
	        $_SESSION['vouchers']=$vouchers;
	        
			$_SESSION['msg']="10";
// 			header("location:manage_giftvouchers.php");	 
// 			exit;
		
	}
	
	
?>
  
  <!--Rajan-->
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  
 <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
                                <h4 class="card-title">Add Gift Vouchers </h4>
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
                    <label class="col-md-3 control-label">Voucher Days :-</label>
                    <div class="col-md-6">
                      <input type="text" name="days" id="days" value="" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Quantity :-</label>
                    <div class="col-md-6">
                      <input type="number" name="count" id="count" value="" class="form-control" required>
                    </div>
                  </div>
                   
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary btn-round">Save</button>
                    </div>
                  </div>
                  
                  <div class="row mrg-top">
                    <div class="col-md-12">
                       
                      <div class="col-md-12 col-sm-12 small">
                        <?php if(isset($_SESSION['vouchers'])){?> 
                       	 <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        	<?php echo 'Gift Vouchers:'.'<br><br>'.$_SESSION['vouchers'] ; ?></a> </div>
                        <?php unset($_SESSION['vouchers']);}?>	
                      </div>
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