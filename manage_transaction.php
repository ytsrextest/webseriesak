<?php include('includes/header.php'); 

    include('includes/function.php');
	include('language/language.php');  


	if(isset($_POST['transaction_search']))
	 {
		 
		
		$transaction_qry="SELECT * FROM tbl_payment trn
        inner join tbl_users usr on usr.id=trn.userid WHERE usr.name like '%".addslashes($_POST['search_value'])."%' or usr.email like '%".addslashes($_POST['search_value'])."%' ORDER BY trn.trnid DESC";  
							 
		$transaction_result=mysqli_query($mysqli,$transaction_qry);
		
		 
	 } else if(isset($_GET['userid']))
	{
	    
	    $tableName="tbl_payment";		
							$targetpage = "manage_transaction.php"; 	
							$limit = 15; 
							
							$query = "SELECT COUNT(*) as num FROM tbl_payment trn
                                        inner join tbl_users usr on usr.id=trn.userid
                                        WHERE trn.userid='".$_GET['userid']."' order by trn.log_entdate desc";
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

                    		$transaction_qry="select trn.trnid, trn.userid, usr.name, usr.email, trn.amount, trn.type, trn.mode, trn.paytmnumber, trn.instaorderid, trn.instatxnid, trn.instapaymentid, trn.instatoken, trn.status, DATE_FORMAT(trn.log_entdate, '%Y-%m-%d %h:%i:%s %p') as log_entdate FROM tbl_payment trn
                            inner join tbl_users usr on usr.id=trn.userid
                            WHERE trn.userid='".$_GET['userid']."' order by trn.log_entdate desc LIMIT $start, $limit";  
                    							 
                    		$transaction_result=mysqli_query($mysqli,$transaction_qry);
							
	}
	 else
	 {
        
							$tableName="tbl_payment";		
							$targetpage = "manage_transaction.php"; 	
							$limit = 15; 
							
							$query = "SELECT COUNT(*) as num FROM tbl_payment trn inner join tbl_users usr on usr.id=trn.userid";
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
							
							
						 $transaction_qry="select trn.trnid, trn.userid, usr.name, usr.email, trn.amount, trn.type, trn.mode, trn.paytmnumber, trn.instaorderid, trn.instatxnid, trn.instapaymentid, trn.instatoken, trn.status, DATE_FORMAT(trn.log_entdate, '%Y-%m-%d %h:%i:%s %p') as log_entdate FROM tbl_payment trn
                                            inner join tbl_users usr on usr.id=trn.userid
                                            WHERE 1=1 order by trn.log_entdate desc LIMIT $start, $limit";  
							 
							$transaction_result=mysqli_query($mysqli,$transaction_qry);
							
	 }
	
	//Active and Deactive status
	if(isset($_GET['status_deactive_id']))
	{
		$data = array('status'  =>  '0');
		
		$edit_status=Update('tbl_users', $data, "WHERE id = '".$_GET['status_deactive_id']."'");
		
		 $_SESSION['msg']="14";
		 header( "Location:manage_transaction.php");
		 exit;
	}
	if(isset($_GET['status_active_id']))
	{
		$data = array('status'  =>  '1');
		
		$edit_status=Update('tbl_users', $data, "WHERE id = '".$_GET['status_active_id']."'");
		
		$_SESSION['msg']="13";
		 header( "Location:manage_transaction.php");
		 exit;
	}
	
	
?>


 <div class="row">
      <div class="col-md-16">
        <div class="card card-user">
          <div class="">
            <div class="card-header">
              <h4 class="card-title">Payment Transactions<?php if(isset($_GET['userid'])){echo ' - Userid: '.$_GET['userid'];}?></h4>
            </div>
            <hr/><center>
            <div class="col-md-7 col-xs-12">              
                  <div class="search_list">
                    <div class="search_block">
                      <form  method="post" action="">
                        <input class="form-control " placeholder="Search..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                        <button type="submit" name="transaction_search" class="btn btn-primary btn-round"><i class="fa fa-search"></i></button>
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
                    <th class="text-center">TrnID</th>
                    <th class="text-center">UserID</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Amount</th>
                    <!--<th class="text-center">Type</th>-->
                    <th class="text-center">Mode</th>
                    <th class="text-center">Remark</th>
                    <th class="text-center">DateTime</th>
                    <!--<th class="cat_action_list text-center">Action</th>-->
                </tr>
              </thead>
              <tbody>
              	<?php
						$i=0;
						while($rows=mysqli_fetch_array($transaction_result))
						{
						    
						    $ttype;
                            if($rows['type'] ==0) {
                                $ttype= "Debit";
                            } else {
                                $ttype= "Credit";
                            }
                            
                            //Payment
                            $mode;
                            if($rows['mode'] =='P') {
                                $mode= "Payment";
                            } else {
                                $mode= $rows['mode'];
                            }
						 
				?>
                <tr>
                   <td class="text-center"><?php echo $rows['trnid'];?></td>
                   <td class="text-center"><?php echo $rows['userid'];?></td>
                   <td class="text-center"><?php echo $rows['name'];?></td>
                   <td class="text-center"><?php if (strcasecmp(DEMO, 'yes') == 0) { echo 'demo@gmail.com'; } else { echo $rows['email']; } ?></td>
                   <td class="text-center"><?php echo $rows['amount'];?></td>
                   <!--<td class="text-center"><?php echo $ttype;?></td>-->
                   <td class="text-center"><?php echo $mode;?></td>
                   <td class="text-center"><?php echo str_replace(' ', ' ', $rows['status']);?></td>
                   <td class="text-center"><?php echo $rows['log_entdate'];?></td>
                   <!--<td class="text-center">-->
                   <!-- <a href="view_user.php?userid=<?php echo $rows['userid'];?>"><i class="fa fa-user-circle-o" data-toggle="tooltip" data-placement="top" title="View User Details"></i></a>-->
                   <!-- </td>-->
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