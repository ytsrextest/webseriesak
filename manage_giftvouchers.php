<?php include('includes/header.php'); 

    include('includes/function.php');
	include('language/language.php');  


	if(isset($_POST['voucher_search']))
	 {
		 
		
		$vouchers_qry="SELECT gft.id AS id, gft.userid, usr.name AS name, usr.email AS email, gft.days AS days, gft.vouchercode AS vouchercode, gft.status, gft.log_entdate FROM `giftvoucher` gft LEFT join `tbl_users` usr ON usr.id = gft.userid 
		    WHERE gft.vouchercode like '%".addslashes($_POST['search_value'])."%' or usr.email like '%".addslashes($_POST['search_value'])."%' ORDER BY gft.id DESC";  
							 
		$vouchers_result=mysqli_query($mysqli,$vouchers_qry);
		
		 
	 }
	 else
	 {
	 
							$tableName="giftvoucher";		
							$targetpage = "manage_giftvouchers.php"; 	
							$limit = 15; 
							
							$query = "SELECT COUNT(*) as num FROM $tableName";
							$total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
							$total_pages = $total_pages['num'];
							
							$stages = 3;
							$page=0;
							if(isset($_GET['page'])){
							$page = mysqli_real_escape_string($mysqli,$_GET['page']);
							}
							if($page){
								$start = ($page - 1) * $limit; 
							}else{
								$start = 0;	
							}	
							
							
						 $vouchers_qry="SELECT gft.id AS id, gft.userid, usr.name AS name, usr.email AS email, gft.days AS days, gft.vouchercode AS vouchercode, gft.status, gft.log_entdate FROM `giftvoucher` gft LEFT join `tbl_users` usr ON usr.id = gft.userid
						 ORDER BY gft.id DESC LIMIT $start, $limit";  
							 
							$vouchers_result=mysqli_query($mysqli,$vouchers_qry);
							
	 }
	if(isset($_GET['voucher_id']))
	{
		  
		 if((strcasecmp(DEMO, 'no') == 0)) {
    		Delete('giftvoucher','id='.$_GET['voucher_id'].'');
    		
    		$_SESSION['msg']="12";
    		header( "Location:manage_giftvouchers.php");
    		exit;
		 }
	}
	
	
?>


 <div class="row">
      <div class="col-md-16">
        <div class="card card-user">
          <div class="">
            <div class="card-header">
              <h4 class="card-title">Manage Gift Vouchers</h4>
            </div>
            <hr/><center>
            <div class="col-md-7 col-xs-12">              
                  <div class="search_list">
                    <div class="search_block">
                      <form  method="post" action="">
                        <input class="form-control " placeholder="Search..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                        <button type="submit" name="voucher_search" class="btn btn-primary btn-round"><i class="fa fa-search"></i></button><a href="add_giftvoucher.php?add"><div class="btn btn-primary btn-round"> Add Gift Voucher </div></a>
                      </form>  
                    </div>
                    
                    
                  </div>
                  
            </div></center>
          </div><hr/>
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
          <div class="col-md-12 mrg-top">
            <table class="table table-striped table-bordered table-hover">
              <thead class="text-primary">
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">Voucher Code</th>
                  <th class="text-center">Days</th>
				  <th class="text-center">Email</th>
				  <th class="text-center">Redeem Status</th>	 
                  <th class="text-center cat_action_list">Action</th>
                </tr>
              </thead>
              <tbody>
              	<?php
						$i=0;
						while($vouchers_row=mysqli_fetch_array($vouchers_result))
						{
						 
				?>
                <tr>
                   <td class="text-center"><?php echo $vouchers_row['id'];?></td>
                   <td class="text-center"><?php echo $vouchers_row['vouchercode'];?></td>
                   <td class="text-center"><?php echo $vouchers_row['days'];?></td>
                   <td class="text-center">
		          		<?php if($vouchers_row['email']!=""){?>
		                    <?php if (strcasecmp(DEMO, 'yes') == 0) { echo 'demo@gmail.com'; } else { echo $vouchers_row['email']; } ?>
		              <?php }else{?>
		              <?php echo '-';?>
		              <?php }?>
              		</td>  
		           <td class="text-center">
		          		<?php if($vouchers_row['status']=="0"){?>
		              <a href="#" title=""><span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Pending</span></span></a>

		              <?php }else{?>
		              <a href="#" title=""><span class="badge badge-danger badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Done </span></span></a>
		              <?php }?>
              		</td>
                   <td class="text-center">
                    <a href="manage_giftvouchers.php?voucher_id=<?php echo $vouchers_row['id'];?>" onclick="return confirm('Are you sure you want to delete this voucher code?');" class="btn btn-default btn-round"><i class="fa fa-trash"></i></a></td>
                </tr>
               <?php
						
						$i++;
						}
			   ?>
              </tbody>
            </table>
          </div>
          <div class="col-md-12 col-xs-12">
            <div class="pagination_item_block">
              <nav>
              	<?php if(!isset($_POST["search"])){ include("pagination.php");}?>                 
              </nav>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>     



<?php include('includes/footer.php');?>                  