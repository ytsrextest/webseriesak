<?php

/*
 * Following code will create a new product row
 * All product details are read from HTTP POST Request
 */

// array for JSON response
$response = array();

// check for required fields
if (isset($_REQUEST['userid'])) {

    $userid= $_REQUEST['userid'];

    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    // connecting to db
	$db = new DB_CONNECT();
	$conn = $db->connect();
	    
    // get all rajan from products table
    $result = mysqli_query($conn,"SELECT * FROM plans ") or die(mysql_error());
    
    // check for empty result
    // rajan node
    $response["rajanr"] = array();
        
    if (mysqli_num_rows($result) > 0) {
        // looping through all results
        
        while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
            // temp user array
            //     $rajan = array();        
            //     $rajan["no"] = $row["no"];
            //     $rajan["date"] = $row["date"];
            //     $rajan["name"] = $row["name"];
            //     $rajan["url"] = $row["url"];
            //     $rajan["detail"] = $row["detail"];
            // 	$rajan["category"] = $row["category"];
            // 	$rajan["expire"] = $row["expire"];
            // 	$rajan["view"] = $row["view"];
    
    
            // push single rajan into final response array
            array_push($response["rajanr"], $row);
        }
	
    	// successfully inserted into database
    	$response["success"] = 1;
    	$response["message"] = "Get all match succsessfully done.";

    	// echoing JSON response
    	echo json_encode($response);
    } else {
        
        // successfully inserted into database
    	$response["success"] = 0;
    	$response["message"] = "No Plans available";

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