<?php

    require_once('db_connection.php');
    $return_arr = array();

    $param = $_GET["term"];

    $query = "SELECT *
                FROM items WHERE itemCode
                LIKE '%". $param ."%'
                LIMIT 5";
    $result = $mysqli->query($query) or die($mysqli->error.__LINE__);

    /* Retrieve and store in array the results of the query.*/
    while ($row = $result->fetch_assoc()) {

        $row_array['jItemCode'] 		    = $row['itemCode'];
        $row_array['jItemDesc'] 		    = $row['itemDesc'];
        $row_array['jItemWholesale']        = $row['itemWholesale'];
        $row_array['jItemRetail']           = $row['itemRetail'];
        $row_array['jItemPrice']      	    = $row['itemPrice'];
        $row_array['jQtyOnHand']            = $row['qtyOnHand'];

        array_push( $return_arr, $row_array );
    }


    $result->free_result();
    $mysqli->close();

    /* Toss back results as json encoded array. */
    echo json_encode($return_arr);



