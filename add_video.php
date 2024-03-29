<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");

 
	$cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
	$cat_result=mysqli_query($mysqli,$cat_qry); 
	
	if(isset($_POST['submit']))
	{
        if((strcasecmp(DEMO, 'no') == 0)) {
     		if ($_POST['video_type']=='youtube')
            {
    
                  $video_url=$_POST['video_url'];
    
                  $youtube_video_url = addslashes($_POST['video_url']);
                  parse_str( parse_url( $youtube_video_url, PHP_URL_QUERY ), $array_of_vars );
                  $video_id=  $array_of_vars['v'];
    
                  $video_thumbnail='';     
    
            }
    
            if ($_POST['video_type']=='vimeo')
            {
                  $video_url=$_POST['video_url'];
    
                  $video_id= (int) substr(parse_url($_POST['video_url'], PHP_URL_PATH), 1);
    
                  $get_video_thumb=unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
    
                  $video_thumbnail=$get_video_thumb[0]['thumbnail_large'];
            }
    
            if ($_POST['video_type']=='dailymotion')
            {
                  $video_url=$_POST['video_url'];
    
                  $video_id= strtok(basename($_POST['video_url']), '_');
    
                  $video_thumbnail='';
            }				
    				
            if ($_POST['video_type']=='server_url')
            {
                  $video_url=$_POST['video_url'];
    
                  $video_thumbnail=rand(0,99999)."_".$_FILES['video_thumbnail']['name'];
           
                  //Main Image
                  $tpath1='images/'.$video_thumbnail;        
                  $pic1=compress_image($_FILES["video_thumbnail"]["tmp_name"], $tpath1, 80);
             
                  //Thumb Image 
                  $thumbpath='images/thumbs/'.$video_thumbnail;   
                  $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','200');   
    
                  $video_id='';
    
            } 
    
            if ($_POST['video_type']=='local')
            {
    
                  $file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/uploads/';
                  
                  $video_url=$file_path.$_POST['video_file_name'];
    
                  $video_thumbnail=rand(0,99999)."_".$_FILES['video_thumbnail']['name'];
           
                  //Main Image
                  $tpath1='images/'.$video_thumbnail;        
                  $pic1=compress_image($_FILES["video_thumbnail"]["tmp_name"], $tpath1, 80);
             
                  //Thumb Image 
                  $thumbpath='images/thumbs/'.$video_thumbnail;   
                  $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','200');   
    
                  $video_id='';
            } 
            
            if ($_POST['video_type']=='embed')
            {
                  $video_url=$_POST['video_url'];
    
                  $video_thumbnail=rand(0,99999)."_".$_FILES['video_thumbnail']['name'];
           
                  //Main Image
                  $tpath1='images/'.$video_thumbnail;        
                  $pic1=compress_image($_FILES["video_thumbnail"]["tmp_name"], $tpath1, 80);
             
                  //Thumb Image 
                  $thumbpath='images/thumbs/'.$video_thumbnail;   
                  $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','200');   
    
                  $video_id='';
    
            } 
    
    
              
            $data = array( 
    			    'cat_id'  =>  $_POST['cat_id'],
    			    'video_type'  =>  $_POST['video_type'],
    			    'premium'  =>  $_POST['premium'],
    			    'video_title'  =>  $_POST['video_title'],
                    'video_url'  =>  $video_url,
                    'video_id'  =>  $video_id,
                    'video_thumbnail'  =>  $video_thumbnail,
                    'video_duration'  =>  $_POST['video_duration'],
                    'video_description'  =>  $_POST['video_description'],
                    );		
    
    		 		$qry = Insert('tbl_video',$data);	
    
     	    
    		$_SESSION['msg']="10";
     
    		header( "Location:add_video.php");
    		exit;	
        }

		 
	}
	
	  
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>
            $(function () {
                $('#btn').click(function () {
                    $('.myprogress').css('width', '0');
                    $('.msg').text('');
                    var video_local = $('#video_local').val();
                    if (video_local == '') {
                        alert('Please enter file name and select file');
                        return;
                    }
                    var formData = new FormData();
                    formData.append('video_local', $('#video_local')[0].files[0]);
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: 'uploadscript.php',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css('width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                         
                            $('#video_file_name').val(data);
                            $('.msg').text("File uploaded successfully!!");
                            $('#btn').removeAttr('disabled');
                        }
                    });
                });
            });
        </script>
<script type="text/javascript">
$(document).ready(function(e) {
           $("#video_type").change(function(){
          
           var type=$("#video_type").val();
              
              if(type=="youtube" || type=="vimeo" || type=="dailymotion")
              { 
                //alert(type);
                $("#video_url_display").show();
                $("#video_local_display").hide();
                $("#thumbnail").hide();
              } 
              else if(type=="server_url")
              {
                 
                 $("#video_url_display").show();
                 $("#thumbnail").show();
                 $("#video_local_display").hide();
              }
              else if(type=="embed")
              {
                 
                 $("#video_url_display").show();
                 $("#thumbnail").show();
                 $("#video_local_display").hide();
              }
              else
              {   
                     
                $("#video_url_display").hide();               
                $("#video_local_display").show();
                $("#thumbnail").show();

              }    
              
         });
         
         $('#video_local').change(function() {
                    var filename = $('#video_local').val().replace(/C:\\fakepath\\/i, '');
                    $('#my_file').html(filename);
            });
        });
</script>
<div class="row">
      <div class="col-md-12">
        <div class="card">
         <div class="card-header">
                                <h4 class="card-title">Add Video</h4>
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
            <form action="" name="add_form" method="post" class="form form-horizontal" enctype="multipart/form-data">
 
              <div class="section">
                <div class="section-body">
                   <div class="form-group">
                    <label class="col-md-3 control-label">Category :-</label>
                    <div class="col-md-6">
                      <select name="cat_id" id="cat_id" class="select2" required>
                        <option value="">--Select Category--</option>
          							<?php
          									while($cat_row=mysqli_fetch_array($cat_result))
          									{
          							?>          						 
          							<option value="<?php echo $cat_row['cid'];?>"><?php echo $cat_row['category_name'];?></option>	          							 
          							<?php
          								}
          							?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Video Title :-</label>
                    <div class="col-md-6">
                      <input type="text" name="video_title" id="video_title" value="" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Video Premium Type :-</label>
                    <div class="col-md-6">                       
                      <select name="premium" id="premium" style="width:280px; height:25px;" class="select2" required>
                            <option value="">--Select Category--</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                      </select>
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-md-3 control-label">Video duration :-</label>
                    <div class="col-md-6">
                      <input type="text" name="video_duration" id="video_duration" value="" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Video Type :-</label>
                    <div class="col-md-6">                       
                      <select name="video_type" id="video_type" style="width:280px; height:25px;" class="select2" required>
                            <option value="">--Select Category--</option>
                            <option value="youtube">Youtube URL</option>
                            <option value="vimeo">Vimeo URL</option>
                            <option value="dailymotion">Dailymotion URL</option>
                            <option value="server_url">Video Mp4/Mkv URL</option>
                            <option value="local">Upload Video</option>
                            <option value="embed">Embed Video URL</option>
                      </select>
                    </div>
                  </div>
                  <div id="video_url_display" class="form-group">
                    <label class="col-md-3 control-label">Video URL :-</label>
                    <div class="col-md-6">
                      <input type="text" name="video_url" id="video_url" value="" class="form-control">
                    </div>
                  </div>
                  <div id="video_local_display" class="form-group" style="display:none;">
                    <label class="col-md-3 control-label">Video Upload :-</label>
                    <div class="col-md-6">
                    
                    <input type="hidden" name="video_file_name" id="video_file_name" value="" class="form-control">
                    <div id="my_file"></div>
                      <input type="file" name="video_local" id="video_local" value="" class="form-control"> <p><u> <font size="3" color="blue">Click here to Choose file</font></u>.</p> </input>

                      <div class="progress">
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="msg"></div>
                        <input type="button" id="btn" class="btn-success" value="Upload" />
                    </div>
                  </div><br>
                  <div id="thumbnail" class="form-group" style="display:none;">
                    <label class="col-md-3 control-label">Video Preview Image:-</label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="video_thumbnail" value="" id="fileupload">
                        <div class="fileupload_img">
                            <img src="http://www.pngmart.com/files/3/Upload-Button-PNG-File.png" alt="edit video image" height="20px" width="90px" />
                            <label for="imageInput"></label>
                            </div>
                       <div class="fileupload_img"><img type="image" src="assets/images/add-image.png" alt="category image" /></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Video Description :-</label>
                    <div class="col-md-6">                    
                      <textarea name="video_description" id="video_description" class="form-control"></textarea>

                      <!--<script>CKEDITOR.replace( 'video_description' );</script>-->
                    </div>
                  </div><br>
                        <?php if (strcasecmp(DEMO, 'yes') == 0) {
                              echo '<button type="submit" name="submit" class="btn btn-primary btn-round" disabled>Save</button>';
                              echo '<p>---This option is disabled in demo---</p>';
                          } else {
                              echo '<button type="submit" name="submit" class="btn btn-primary btn-round">Save</button>';
                          }
                        ?>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
        
<?php include("includes/footer.php");?>       
