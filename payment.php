<?php

/*
 * Following code will create a new product row
 * All product details are read from HTTP POST Request
 */

// array for JSON response
$response = array();

// check for required fields
if (isset($_REQUEST['user_id']) && isset($_REQUEST['planid']) && isset($_REQUEST['addamount']) && isset($_REQUEST['days']) && isset($_REQUEST['instaorderid']) && isset($_REQUEST['instatxnid']) && isset($_REQUEST['instapaymentid']) && isset($_REQUEST['instatoken']) && isset($_REQUEST['status'])) {

    $userid= $_REQUEST['user_id'];
    $planid= $_REQUEST['planid'];
    $days= $_REQUEST['days'];
    $addamount= $_REQUEST['addamount'];
    $instaorderid= $_REQUEST['instaorderid'];
    $instatxnid= $_REQUEST['instatxnid'];
    $instapaymentid= $_REQUEST['instapaymentid'];
    $instatoken= $_REQUEST['instatoken'];
    $status= $_REQUEST['status'];
    
    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    // connecting to db
	$db = new DB_CONNECT();
	$conn = $db->connect();

    date_default_timezone_set("Asia/Calcutta");
	$cur = date("Y-m-d H:i:s");
	
	//increment 1 days
    $Today=date('y:m:d');

    // add 1 days to date
    $NewDate=Date('Y-m-d H:i:s', strtotime("+".$days." days"));
    // echo $NewDate;
    
    // Refer and Earn
	// POST all iid from users table
	$results = $conn->query("SELECT * FROM tbl_payment WHERE userid='$userid' ") or die($conn->error);

	// check for empty result
	// it return number of rows in the table.
	if ($rows = $results->fetch_assoc() == 0) {
	    //Get user promo code of new user
    	$userpromocode = mysqli_query($conn,"SELECT * FROM tbl_users WHERE tbl_users.id = '$userid' ") or die($conn->error);
    
    	// check for empty result
    	if (mysqli_num_rows($userpromocode) == 1) {
            // looping through all results
            
            while ($rowp = mysqli_fetch_array($userpromocode, MYSQLI_BOTH)) {
                // temp user array
                //     $rajan = array();        
                $promocode = $rowp["promocode"];
                $name = $rowp["name"];
            }
    	}
    	
    	if(strlen($promocode)>1) {
    	    // Promocode - fatch old user data
    	    // POST all iid from users table
        	$promochk = mysqli_query($conn,"SELECT * FROM tbl_users WHERE tbl_users.id ='$promocode'") or die($conn->error);
        
        	// check for empty result
        	if (mysqli_num_rows($promochk) == 1) {
                // looping through all results
                
                while ($row = mysqli_fetch_array($promochk, MYSQLI_BOTH)) {
                    // temp user array
                    //     $rajan = array();        
                    $useridr = $row["id"];
                    $daysr = $row["plandays"];
                    $planendr = $row["planend"];

                    $dys= OLD_USER_DAYS;
                    
                    if($cur > $planendr) {
                        $daysr = $daysr + $dys;
                    
                        // add 1 days to date
                        $NewDater=Date('Y-m-d H:i:s', strtotime($cur."+".$dys." days"));
                        
                        // deduct balance
                    	$payment = mysqli_query($conn,"INSERT INTO `tbl_payment` (`trnid`, `userid`, `amount`, `type`, `mode`, `planid`, `planname`, `plandays`, `paytmnumber`, `instaorderid`, `instatxnid`, `instapaymentid`, `instatoken`, `status`, `log_entdate`) VALUES (NULL, '$useridr', '0', '1', 'Refer', '0', 'Refer', '$dys', NULL, NULL, NULL, NULL, NULL, 'Refer bonus of $name', '$cur') ") or die($conn->error);
                    
                    	// mysql inserting a new row
                    	$resultr = mysqli_query($conn,"UPDATE tbl_users SET planid = '0', planactive = 'Y', plandays = '$daysr', planstart = '$cur' , planend = '$NewDater' WHERE tbl_users.id = '$useridr' ");
                	
                    } else {
                        $daysr = $daysr + $dys;
                    
                        // add 1 days to date
                        $NewDater=Date('Y-m-d H:i:s', strtotime($planendr."+".$dys." days"));
                        
                        // deduct balance
                    	$payment = mysqli_query($conn,"INSERT INTO `tbl_payment` (`trnid`, `userid`, `amount`, `type`, `mode`, `planid`, `planname`, `plandays`, `paytmnumber`, `instaorderid`, `instatxnid`, `instapaymentid`, `instatoken`, `status`, `log_entdate`) VALUES (NULL, '$useridr', '0', '1', 'Refer', '0', 'Refer', '$dys', NULL, NULL, NULL, NULL, NULL, 'Refer bonus of $name', '$cur') ") or die($conn->error);
                    
                    	// mysql inserting a new row
                    	$resultr = mysqli_query($conn,"UPDATE tbl_users SET planactive = 'Y', plandays = '$daysr', planend = '$NewDater' WHERE tbl_users.id = '$useridr' ");
                    }

                }
        	    
        	}
    	}
	} else {
	    //referral money is given
	}
    
    // deduct balance
	$payment = mysqli_query($conn,"INSERT INTO `tbl_payment` (`trnid`, `userid`, `amount`, `type`, `mode`, `planid`, `planname`, `plandays`, `paytmnumber`, `instaorderid`, `instatxnid`, `instapaymentid`, `instatoken`, `status`, `log_entdate`) VALUES (NULL, '$userid', '$addamount', '1', 'P', '$planid', 'planname', '$days', NULL, NULL, NULL, NULL, NULL, '$status', '$cur') ") or die($conn->error);

    //Get user previous plan dates
	$userdetails = mysqli_query($conn,"SELECT * FROM tbl_users WHERE tbl_users.id = '$userid' ") or die($conn->error);

	// check for empty result
	if (mysqli_num_rows($userdetails) == 1) {
        // looping through all results
        
        while ($userrowp = mysqli_fetch_array($userdetails, MYSQLI_BOTH)) {
            // temp user array
            $userdaysr = $userrowp["plandays"];
            $userplanendr = $userrowp["planend"];
        }
	}
	
	if($cur > $userplanendr) {
        // plan expired so no needs to adds
	} else {
	    
	    $daysn = $days;
	    $days = $userdaysr + $days;
    
        // add 1 days to date
        $NewDate=Date('Y-m-d H:i:s', strtotime($userplanendr."+".$daysn." days"));
	}
	
	// mysql inserting a new row
	$result = mysqli_query($conn,"UPDATE tbl_users SET planid = '$planid', planactive = 'Y', plandays = '$days', planstart = '$cur' , planend = '$NewDate' WHERE tbl_users.id = '$userid' ");

	// check if row inserted or not
	if ($result) {
    	// successfully inserted into database
    	$response["planid"] = $planid;
    	$response["planactive"] = 'Y';
    	$response["plandays"] = $days;
    	$response["planstart"] = $cur;
    	$response["planend"] = $NewDate;
    	$response["success"] = 1;
    	$response["message"] = "Product successfully created.";

    	// echoing JSON response
    	echo json_encode($response);
	} else {
    	// failed to insert row
    	$response["success"] = 0;
    	$response["message"] = "Oops! An error occurred.";
    
    	// echoing JSON response
    	echo json_encode($response);
	}
	
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>