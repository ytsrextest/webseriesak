<?php include("includes/header.php");

	require("includes/function.php");
	require("language/language.php");
	
	$plan_qry="SELECT * FROM plans";
	$plan_result=mysqli_query($mysqli,$plan_qry); 
	
	if(isset($_POST['submit']) && isset($_POST['plan_id']))
	{
	    if((strcasecmp(DEMO, 'no') == 0)) {
            // header( "Location:delete_plan.php?planid=".$_POST['plan_id']);
            // exit;
 
            Delete('plans','planid='.$_POST['plan_id'].'');
            
            $_SESSION['msg']="12";
            header( "Location:delete_plan.php");
            exit;
	    }
    
	}

?>

<!--Top Menu-->
<div class="row">
    <a href="add_plan.php"><div class="btn btn-primary btn-round" style="margin: 50px"> Add Plan </div></a>
    
    <a href="edit_plan.php"><div class="btn btn-primary btn-round" style="margin: 50px"> Edit Plan </div></a>
    
    <a href="delete_plan.php"><div class="btn btn-primary btn-round" style="margin: 50px"> Delete Plan </div></a>
    
    <a href="view_plan.php"><div class="btn btn-primary btn-round" style="margin: 50px; display:none"> View Plan </div></a>
</div>

<!--Below Grid-->
<div class="row">
 <div class="col-md-8">
            <div class="card card-user">
              <div class="card-header">
                                <h4 class="card-title">Delete Plan</h4>
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
                    <label class="col-md-3 control-label">Select Plan :-</label>
                    <div class="col-md-6">
                      <select name="plan_id" id="plan_id" class="select2" required>
                        <option value="">--Select Plan--</option>
          							<?php
          									while($plan_row=mysqli_fetch_array($plan_result))
          									{
          							?>          						 
          							<option value="<?php echo $plan_row['planid'];?>"><?php echo $plan_row['name'].' (PlanID='.$plan_row['planid'].')';?></option>	          							 
          							<?php
          								}
          							?>
                      </select>
                    </div>
                  </div>
                  
                  <br>
                  <br>
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                        <?php if (strcasecmp(DEMO, 'yes') == 0) {
                              echo '<button type="submit" name="submit" class="btn btn-primary btn-round" disabled>Delete</button>';
                              echo '<p>---This option is disabled in demo---</p>';
                          } else {
                              echo '<button type="submit" name="submit" class="btn btn-primary btn-round">Delete</button>';
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