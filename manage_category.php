<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

  if(isset($_POST['data_search']))
   {

      $qry="SELECT * FROM tbl_category                   
                  WHERE tbl_category.category_name like '%".addslashes($_POST['search_value'])."%'
                  ORDER BY tbl_category.category_name";
 
     $result=mysqli_query($mysqli,$qry); 

   }
   else
   {
	
	//Get all Category 
	 
      $tableName="tbl_category";   
      $targetpage = "manage_category.php"; 
      $limit = 12; 
      
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
      
     $qry="SELECT * FROM tbl_category
                   ORDER BY tbl_category.cid DESC LIMIT $start, $limit";
 
     $result=mysqli_query($mysqli,$qry); 
	
    } 

	if(isset($_GET['cat_id']))
	{ 
        if((strcasecmp(DEMO, 'no') == 0)) {
    		$cat_res=mysqli_query($mysqli,'SELECT * FROM tbl_category WHERE cid=\''.$_GET['cat_id'].'\'');
    		$cat_res_row=mysqli_fetch_assoc($cat_res);
    
    
    		if($cat_res_row['category_image']!="")
    	    {
    	    	unlink('images/'.$cat_res_row['category_image']);
    			  unlink('images/thumbs/'.$cat_res_row['category_image']);
    
    		}
     
    		Delete('tbl_category','cid='.$_GET['cat_id'].'');
    
         
    		$_SESSION['msg']="12";
    		header( "Location:manage_category.php");
    		exit;
        }
		
	}	

  function get_total_item($cat_id)
  { 
    global $mysqli;   

    $qry_songs="SELECT COUNT(*) as num FROM tbl_video WHERE cat_id='".$cat_id."'";
     
    $total_songs = mysqli_fetch_array(mysqli_query($mysqli,$qry_songs));
    $total_songs = $total_songs['num'];
     
    return $total_songs;

  }

  //Active and Deactive status
if(isset($_GET['status_deactive_id']))
{
   $data = array('status'  =>  '0');
  
   $edit_status=Update('tbl_category', $data, "WHERE cid = '".$_GET['status_deactive_id']."'");
  
   $_SESSION['msg']="14";
   header( "Location:manage_category.php");
   exit;
}
if(isset($_GET['status_active_id']))
{
    $data = array('status'  =>  '1');
    
    $edit_status=Update('tbl_category', $data, "WHERE cid = '".$_GET['status_active_id']."'");
    
    $_SESSION['msg']="13";   
    header( "Location:manage_category.php");
    exit;
}  
	 
?>
                
    <div class="row">
        <div class="col-md-16">
            <div class="card card-user">
      <div class="">
              <div class="card-header">
                                <h4 class="card-title">Manage Categories</h4>
                            </div>
                            <hr/><center>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                <div class="search_block">
                  <form  method="post" action="">
                  <input class="form-control" placeholder="Search category..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                        <button type="submit" name="data_search" class="btn btn-primary btn-round"><i class="fa fa-search"></i></button><a href="add_category.php?add=yes"><div class="btn btn-primary btn-round"> Add Category </div></a>
                  </form>  
                </div>
              </div>
            </div></center>
          </div>
      <hr/>
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
            <div class="row">
              <?php 
              $i=0;
              while($row=mysqli_fetch_array($result))
              {         
          ?>
              <div class="col-lg-3 col-sm-6 col-xs-12">
                <div class="card card-user">           
                  <center>
                    <b class="title"><font color="#403D39"><?php echo $row['category_name'];?> <span>(<?php echo get_total_item($row['cid']);?>)</span></font></b>
                     <hr/><span class="image"><img src="images/<?php echo $row['category_image'];?>" height="125px" width="75%" /></span>
                     <hr/>
                     
    <a href="add_category.php?cat_id=<?php echo $row['cid'];?>" data-toggle="tooltip" data-tooltip="Edit"><div class="btn btn-primary btn-round" > <i class="fa fa-edit"></i> Edit</div></a>
    
    <a href="?cat_id=<?php echo $row['cid'];?>" data-toggle="tooltip" data-tooltip="Delete" onclick="return confirm('Are you sure you want to delete this category?');"><div class="btn btn-primary btn-round" > <i class="fa fa-trash"></i> Delete</div></a>
    
                          
                      <!--<?php if($row['status']!="0"){?><a href="manage_category.php?status_deactive_id=<?php echo $row['cid'];?>" data-toggle="tooltip" data-tooltip="DISABLE"><div class="btn btn-primary btn-round"><i class="fa fa-times-circle"></i> Disable</div></a>-->

                      <!--<?php }else{?>-->
                      
                      <!--<a href="manage_category.php?status_active_id=<?php echo $row['cid'];?>" data-toggle="tooltip" data-tooltip="ENABLE"><div class="btn btn-primary btn-round"><i class="fa fa-check-circle"></i> Enable</div></a>-->
                  
                      <!--<?php }?>-->

    
                  </center>
                </div>
              </div>
          <?php
            
            $i++;
              }
        ?>     
               
      </div>
          </div>
          <div class="col-md-12 col-xs-12">
            <div class="pagination_item_block">
              <nav>
                <?php if(!isset($_POST["data_search"])){ include("pagination.php");}?>
              </nav>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>       
