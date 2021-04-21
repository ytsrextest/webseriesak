<?php

/*
 * Following code will create a new product row
 * All product details are read from HTTP POST Request
 */

// array for JSON response
$response = array();

// check for required fields
if (true) {
    // required field is missing
    $response["success"] = 1;
    $response["urlid"] = "pgc3J2hBBEU";

    // echoing JSON response
    echo json_encode($response);
}
?>