<?php include('includes/header.php'); 

    include('includes/function.php');
	include('language/language.php');  


	if(isset($_POST['user_search']))
	 {
		 
		
		$user_qry="SELECT * FROM tbl_users WHERE tbl_users.name like '%".addslashes($_POST['search_value'])."%' or tbl_users.email like '%".addslashes($_POST['search_value'])."%' ORDER BY tbl_users.id DESC";  
							 
		$users_result=mysqli_query($mysqli,$user_qry);
		
		 
	 }
	 else
	 {
	 
							$tableName="tbl_users";		
							$targetpage = "manage_users.php"; 	
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
							
							
						 $users_qry="SELECT * FROM tbl_users
						 ORDER BY tbl_users.id DESC LIMIT $start, $limit";  
							 
							$users_result=mysqli_query($mysqli,$users_qry);
							
	 }
	if(isset($_GET['user_id']))
	{
		 if((strcasecmp(DEMO, 'no') == 0)) {
    		Delete('tbl_users','id='.$_GET['user_id'].'');
    		
    		$_SESSION['msg']="12";
    		header( "Location:manage_users.php");
    		exit;
		 }
	}
	
	//Active and Deactive status
	if(isset($_GET['status_deactive_id']))
	{
	    if((strcasecmp(DEMO, 'no') == 0)) {
    		$data = array('status'  =>  '0');
    		
    		$edit_status=Update('tbl_users', $data, "WHERE id = '".$_GET['status_deactive_id']."'");
    		
    		 $_SESSION['msg']="14";
    		 header( "Location:manage_users.php");
    		 exit;
	    }
	}
	if(isset($_GET['status_active_id']))
	{
        if((strcasecmp(DEMO, 'no') == 0)) {
    		$data = array('status'  =>  '1');
    		
    		$edit_status=Update('tbl_users', $data, "WHERE id = '".$_GET['status_active_id']."'");
    		
    		$_SESSION['msg']="13";
    		 header( "Location:manage_users.php");
    		 exit;
        }
	}
	
	
?>


 <div class="row">
      <div class="col-md-16">
        <div class="card card-user">
          <div class="">
            <div class="card-header">
              <h4 class="card-title">Manage Users</h4>
            </div>
            <hr/><center>
            <div class="col-md-7 col-xs-12">              
                  <div class="search_list">
                    <div class="search_block">
                      <form  method="post" action="">
                        <input class="form-control " placeholder="Search..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                        <button type="submit" name="user_search" class="btn btn-primary btn-round"><i class="fa fa-search"></i></button><a href="add_user.php?add"><div class="btn btn-primary btn-round"> Add User </div></a>
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
                  <th class="text-center">UserID</th>
                  <th class="text-center">Name</th>						 
				  <th class="text-center">Email</th>
				  <th class="text-center">Google Id</th>
				  <th class="text-center">PromoCode</th>
				  <th class="text-center">Status</th>	 
                  <th class="text-center cat_action_list">Action</th>
                </tr>
              </thead>
              <tbody>
              	<?php
						$i=0;
						while($users_row=mysqli_fetch_array($users_result))
						{
						 
				?>
                <tr>
                   <td class="text-center"><?php echo $users_row['id'];?></td>
                   <td><?php echo $users_row['name'];?></td>
                   <td class="text-center"><?php if (strcasecmp(DEMO, 'yes') == 0) { echo 'demo@gmail.com'; } else { echo $users_row['email']; } ?></td>
                   <td class="text-center"><?php if (strcasecmp(DEMO, 'yes') == 0) { echo '99********'; } else { echo $users_row['phone']; } ?></td>
		           <td class="text-center"><?php if($users_row['promocode'] != ""){echo $users_row['promocode'];} else { echo "-"; }?></td>
		           <td class="text-center">
		          		<?php if($users_row['status']!="0"){?>
		              <a href="manage_users.php?status_deactive_id=<?php echo $users_row['id'];?>" title="Change Status"><span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Enable</span></span></a>

		              <?php }else{?>
		              <a href="manage_users.php?status_active_id=<?php echo $users_row['id'];?>" title="Change Status"><span class="badge badge-danger badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>Disable </span></span></a>
		              <?php }?>
              		</td>
                   <td class="text-center"><a href="add_user.php?user_id=<?php echo $users_row['id'];?>"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="Edit User"></i></a>
                   <a href="manage_transaction.php?userid=<?php echo $users_row['id'];?>"><i class="fa fa-money" data-toggle="tooltip" data-placement="top" title="View User Transactions"></i></a>
                    <a href="manage_users.php?user_id=<?php echo $users_row['id'];?>" onclick="return confirm('Are you sure you want to delete this user?');"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete User"></i></a></td>
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