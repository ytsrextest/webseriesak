<?php include("includes/header.php");

  require("includes/function.php");
  require("language/language.php");

  require_once("thumbnail_images.class.php");

   
  
  if(isset($_POST['submit']) and isset($_GET['add']))
  {
  
    if((strcasecmp(DEMO, 'no') == 0)) {
        $category_image=rand(0,99999)."_".$_FILES['category_image']['name'];
        
        //Main Image
        $tpath1='images/'.$category_image;        
        $pic1=compress_image($_FILES["category_image"]["tmp_name"], $tpath1, 80);
        
        //Thumb Image 
        $thumbpath='images/thumbs/'.$category_image;   
        $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'300','300');   
        
          
        $data = array( 
          'category_name'  =>  $_POST['category_name'],
         'category_image'  =>  $category_image
          );    
        
        $qry = Insert('tbl_category',$data);  
        
        
        $_SESSION['msg']="10";
        
        header( "Location:manage_category.php");
        exit; 
    }

     
    
  }
  
  if(isset($_GET['cat_id']))
  {
       
      $qry="SELECT * FROM tbl_category where cid='".$_GET['cat_id']."'";
      $result=mysqli_query($mysqli,$qry);
      $row=mysqli_fetch_assoc($result);

  }
  if(isset($_POST['submit']) and isset($_POST['cat_id']))
  {
     if((strcasecmp(DEMO, 'no') == 0)) {
         if($_FILES['category_image']['name']!="")
         {    
    
    
            $img_res=mysqli_query($mysqli,'SELECT * FROM tbl_category WHERE cid='.$_GET['cat_id'].'');
              $img_res_row=mysqli_fetch_assoc($img_res);
          
    
              if($img_res_row['category_image']!="")
                {
                  unlink('images/thumbs/'.$img_res_row['category_image']);
                  unlink('images/'.$img_res_row['category_image']);
               }
    
               $category_image=rand(0,99999)."_".$_FILES['category_image']['name'];
           
                 //Main Image
               $tpath1='images/'.$category_image;        
                 $pic1=compress_image($_FILES["category_image"]["tmp_name"], $tpath1, 80);
             
              //Thumb Image 
               $thumbpath='images/thumbs/'.$category_image;   
               $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'300','300');
    
                        $data = array(
                  'category_name'  =>  $_POST['category_name'],
                  'category_image'  =>  $category_image
                );
    
              $category_edit=Update('tbl_category', $data, "WHERE cid = '".$_POST['cat_id']."'");
    
         }
         else
         {
    
               $data = array(
                    'category_name'  =>  $_POST['category_name']
                );  
     
                   $category_edit=Update('tbl_category', $data, "WHERE cid = '".$_POST['cat_id']."'");
    
         }
     
        
        $_SESSION['msg']="11"; 
        header( "Location:add_category.php?cat_id=".$_POST['cat_id']);
        exit;
    }
 
  }


?>
<div class="row">
             <div class="col-md-8">
            <div class="card card-user">
              <div class="card-header">
                                <h4 class="card-title"><?php if(isset($_GET['cat_id'])){?>Edit<?php }else{?>Add<?php }?> Category</h4>
                            </div>

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
            <form action="" name="addeditcategory" method="post" class="form form-horizontal" enctype="multipart/form-data">
              <input  type="hidden" name="cat_id" value="<?php echo $_GET['cat_id'];?>" />

              <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-3 control-label">Category Name :-
                    
                    </label>
                    <div class="col-md-6">
                      <input type="text" name="category_name" id="category_name" value="<?php if(isset($_GET['cat_id'])){echo $row['category_name'];}?>" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Select Image :-
                    </label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input style="form-group" type="file" name="category_image" value="fileupload" id="fileupload" />
                            
                            <div class="fileupload_img"><img type="image" src="http://www.pngmart.com/files/3/Upload-Button-PNG-File.png" alt="category image" height="20px" width="90px" />
                            <label for="imageInput">Click Here To Upload</label>
                            </div>
                           
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">&nbsp; </label>
                    <div class="col-md-6">
                      <?php if(isset($_GET['cat_id']) and $row['category_image']!="") {?>
                            <div class="block_wallpaper"><img src="images/<?php echo $row['category_image'];?>" alt="category image" /></div>
                          <?php } ?>
                    </div>
                  </div><br>
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
        
<?php include("includes/footer.php");?>       
