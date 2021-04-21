<?php

/*
 * Following code will create a new product row
 * All product details are read from HTTP POST Request
 */

// array for JSON response
$response = array();

// check for required fields
if (isset($_REQUEST['user_id']) && isset($_REQUEST['vouchercode'])) {

    $userid= $_REQUEST['user_id'];
    $vouchercode= $_REQUEST['vouchercode'];
    
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
    // $NewDate=Date('Y-m-d H:i:s', strtotime("+".$days." days"));
    // echo $NewDate;
    
    //Get user promo code of new user
	$validuserid = mysqli_query($conn,"SELECT * FROM tbl_users WHERE tbl_users.id = '$userid' ") or die($conn->error);

	// check for empty result
	if (mysqli_num_rows($validuserid) == 1) {
        // looping through all results
        
        while ($rowp = mysqli_fetch_array($validuserid, MYSQLI_BOTH)) {
            // temp user array
            //     $rajan = array();        
            // $promocode = $rowp["promocode"];
            $name = $rowp["name"];
            $userdays = $rowp["plandays"];
            $userplanstart = $rowp["planstart"];
            $userplanend = $rowp["planend"];
        }
        
	    // POST all iid from users table
    	$voucherdetails = mysqli_query($conn,"SELECT * FROM giftvoucher WHERE vouchercode ='$vouchercode' ") or die($conn->error);
    
    	// check for empty result
    	if (mysqli_num_rows($voucherdetails) == 1) {
            // looping through all results
            
            while ($row = mysqli_fetch_array($voucherdetails, MYSQLI_BOTH)) {
                // temp user array
                //     $rajan = array();        
                $dys = $row["days"];
                $statusr = $row["status"];

                if($statusr == "0") {
                    
                    $daysr = $userdays;
                    
                    if($cur > $userplanend) {
                        
                        $daysr = $daysr + $dys;
                        $userplanstart = $cur;
                    
                        // add 1 days to date
                        $NewDater=Date('Y-m-d H:i:s', strtotime($cur."+".$dys." days"));
                        
                        // deduct balance
                    	$payment = mysqli_query($conn,"INSERT INTO `tbl_payment` (`trnid`, `userid`, `amount`, `type`, `mode`, `planid`, `planname`, `plandays`, `paytmnumber`, `instaorderid`, `instatxnid`, `instapaymentid`, `instatoken`, `status`, `log_entdate`) VALUES (NULL, '$userid', '0', '1', 'GiftVoucher', '0', 'GiftVoucher', '$dys', NULL, NULL, NULL, NULL, NULL, 'GiftVoucher: $vouchercode', '$cur') ") or die($conn->error);
                    
                    	// mysql inserting a new row
                    	$resultr = mysqli_query($conn,"UPDATE tbl_users SET planid = '0', planactive = 'Y', plandays = '$daysr', planstart = '$cur' , planend = '$NewDater' WHERE tbl_users.id = '$userid' ");
                	
                    } else {
                        $daysr = $daysr + $dys;
                        
                    
                        // add 1 days to date
                        $NewDater=Date('Y-m-d H:i:s', strtotime($userplanend."+".$dys." days"));
                        
                        // deduct balance
                    	$payment = mysqli_query($conn,"INSERT INTO `tbl_payment` (`trnid`, `userid`, `amount`, `type`, `mode`, `planid`, `planname`, `plandays`, `paytmnumber`, `instaorderid`, `instatxnid`, `instapaymentid`, `instatoken`, `status`, `log_entdate`) VALUES (NULL, '$userid', '0', '1', 'GiftVoucher', '0', 'GiftVoucher', '$dys', NULL, NULL, NULL, NULL, NULL, 'GiftVoucher: $vouchercode', '$cur') ") or die($conn->error);
                    
                    	// mysql inserting a new row
                    	$resultr = mysqli_query($conn,"UPDATE tbl_users SET planactive = 'Y', plandays = '$daysr', planend = '$NewDater' WHERE tbl_users.id = '$userid' ");
                    }
                    
                    // Gift Voucher Status Update
                	$giftvoucherstatus = mysqli_query($conn,"UPDATE giftvoucher SET userid='$userid',status='1' WHERE vouchercode= '$vouchercode' ");
                    
                    // successfully inserted into database
                // 	$response["planid"] = $planid;
                	$response["planactive"] = 'Y';
                	$response["plandays"] = $daysr;
                	$response["planstart"] = $userplanstart;
                	$response["planend"] = $NewDater;
                	$response["success"] = 1;
                	$response["message"] = "Gift Voucher Redeemed Succsessfully.";
            
                	// echoing JSON response
                	echo json_encode($response);
                } else {
                    //voucher already redeemed
                    $response["success"] = 0;
                    $response["message"] = "Voucher already redeemed";
                    
                    // echoing JSON response
                	echo json_encode($response);
                }
                

            }
    	    
    	} else {
    	    //referral money is given
    	    $response["success"] = 0;
            $response["message"] = "Invalid Gift Voucher";
            
            // echoing JSON response
        	echo json_encode($response);
	    }
	} else {
	    //referral money is given
	    $response["success"] = 0;
        $response["message"] = "Invalid User";
        
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