<?php include("includes/header.php");
	require("includes/connection.php");
	require("includes/function.php");
	require("language/language.php");

	
	   //Get all videos 
	 if(isset($_POST['data_search']))
   {

      $data_qry="SELECT * FROM tbl_video
                  WHERE tbl_video.video_title like '%".addslashes($_POST['search_value'])."%' 
                  ORDER BY tbl_video.id";
 
     $result=mysqli_query($mysqli,$data_qry); 

   }
   else
   {
      $tableName="tbl_video";   
      $targetpage = "manage_videos.php"; 
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
      
     $quotes_qry="SELECT tbl_category.category_name,tbl_video.* FROM tbl_video
                  LEFT JOIN tbl_category ON tbl_video.cat_id= tbl_category.cid 
                  ORDER BY tbl_video.id DESC LIMIT $start, $limit";
 
     $result=mysqli_query($mysqli,$quotes_qry); 
	 }

  if(isset($_GET['video_id']))
  { 
    if((strcasecmp(DEMO, 'no') == 0)) {
        $img_res=mysqli_query($mysqli,'SELECT * FROM tbl_video WHERE id='.$_GET['video_id'].'');
        $img_res_row=mysqli_fetch_assoc($img_res);
               
        if($img_res_row['video_thumbnail']!="")
         {
              unlink('images/thumbs/'.$img_res_row['video_thumbnail']);
              unlink('images/'.$img_res_row['video_thumbnail']);
    
              unlink($img_res_row['video_url']);
          }
     
        Delete('tbl_video','id='.$_GET['video_id'].'');
        
        $_SESSION['msg']="12";
        header( "Location:manage_videos.php");
        exit;
    }
    
  }

  //Active and Deactive status
if(isset($_GET['status_deactive_id']))
{
   $data = array('status'  =>  '0');
  
   $edit_status=Update('tbl_video', $data, "WHERE id = '".$_GET['status_deactive_id']."'");
  
   $_SESSION['msg']="14";
   header( "Location:manage_videos.php");
   exit;
}
if(isset($_GET['status_active_id']))
{
    $data = array('status'  =>  '1');
    
    $edit_status=Update('tbl_video', $data, "WHERE id = '".$_GET['status_active_id']."'");
    
    $_SESSION['msg']="13";   
    header( "Location:manage_videos.php");
    exit;
} 

//Active and Deactive featured
  if(isset($_GET['featured_deactive_id']))
  {
      if((strcasecmp(DEMO, 'no') == 0)) {
        $data = array('featured'  =>  '0');
        
        $edit_status=Update('tbl_video', $data, "WHERE id = '".$_GET['featured_deactive_id']."'");
        
         $_SESSION['msg']="14";
         header( "Location:manage_videos.php");
         exit;
      }
  }
  if(isset($_GET['featured_active_id']))
  {
      if((strcasecmp(DEMO, 'no') == 0)) {
        $data = array('featured'  =>  '1');
        
        $edit_status=Update('tbl_video', $data, "WHERE id = '".$_GET['featured_active_id']."'");
        
        $_SESSION['msg']="13";
         header( "Location:manage_videos.php");
         exit;
      }
  } 

?>
    <div class="row">
        <div class="col-md-16">
            <div class="card card-user">
              <div class="card-header">
              <h4 class="card-title">Manage Videos</h4>
            </div>
            <hr/><center>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                <div class="search_block">
                  <form  method="post" action="">
                  <input class="form-control" placeholder="Search..." aria-controls="DataTables_Table_0" type="search" name="search_value" required>
                        <button type="submit" name="data_search" class="btn btn-primary btn-round"><i class="fa fa-search"></i></button>
                        <a href="add_video.php"><div class="btn btn-primary btn-round"> Add Video </div></a>
                  </form>  
               </div>
              </div>
            </div></center>
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
                    <b class="title"><font color="#403D39"><?php echo $row['category_name'];?></font></b>
                    
                     <hr/>
                     
                     <span class="image"><?php if($row['video_thumbnail']!=""){?>
						<img src="images/<?php echo $row['video_thumbnail'];?>" /></span>                     
						 <?php }else{?>
						<img class="image" src="images/default_img.jpg" /></span>                     
                      <?php }?>  
                     
                     
                     <hr/>
                     <p><?php echo $row['video_title'];?></p>
                     <hr/>
                     
                      <?php if($row['featured']!="0"){?>
                        <a href="manage_videos.php?featured_deactive_id=<?php echo $row['id'];?>" data-toggle="tooltip" data-tooltip="Slide"><div class="btn btn-primary btn-round" style="color:green;"><i class="fa fa-check-circle"></i> </div></a> 
                      <?php }else{?>
                         <a href="manage_videos.php?featured_active_id=<?php echo $row['id'];?>" data-toggle="tooltip" data-tooltip="Set Slide"><div class="btn btn-primary btn-round"><i class="fa fa-circle"></i> </div></a>
                      <?php }?>
               
                     <!--<a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row['totel_viewer'];?> Views"><div class="btn btn-primary btn-round"><i class="fa fa-eye"></i> </div></a>                    -->
                       

                     <a href="edit_video.php?video_id=<?php echo $row['id'];?>" data-toggle="tooltip" data-tooltip="Edit"><div class="btn btn-primary btn-round"><i class="fa fa-edit"></i> </div></a><br/>
                     
                     <a href="?video_id=<?php echo $row['id'];?>" data-toggle="tooltip" data-tooltip="Delete" onclick="return confirm('Are you sure you want to delete this wallpaper?');"><div class="btn btn-primary btn-round"><i class="fa fa-trash"></i> </div></a>

                      <!--<?php if($row['status']!="0"){?>-->
                      <!-- <a href="manage_videos.php?status_deactive_id=<?php echo $row['id'];?>" data-toggle="tooltip" data-tooltip="DISABLE"><div class="btn btn-primary btn-round"><i class="fa fa-times-circle"></i> </div></a>-->

                      <!--<?php }else{?>-->
                      
                      <!-- <a href="manage_videos.php?status_active_id=<?php echo $row['id'];?>" data-toggle="tooltip" data-tooltip="ENABLE"><div class="btn btn-primary btn-round"><i class="fa fa-check-circle"></i> </div></a>-->
                  
                      <!--<?php }?>  -->
    
                          
    
                  </center>
                </div>
              </div>
         
          <?php
            
            if($i==1) {
                ?>  <?php
            }
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
