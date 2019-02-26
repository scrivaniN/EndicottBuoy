<?php
/**
 * Created by PhpStorm.
 * User: nickscrivani
 * Date: 2019-02-24
 * Time: 15:39
 */

$conn = mysqli_connect("ecbuoy.cl7cxw0gh9pq.us-east-2.rds.amazonaws.com", "nick" , "Scribbles1$" , "endicottbuoy");
if ($conn-> connect_error) {
    die("connection failed:" . $conn-> connect_error);
}

?>