<?php
	$con = mysqli_connect("localhost", "root", "", "gps");
	mysqli_set_charset($con, "utf8");

	$bangle_id = $_GET["bangle_id"];

	$result = mysqli_query($con, "SELECT sos_id, bangle_id, response_time, checked, checked_time from sos where bangle_id = '$bangle_id'order by sos_id asc");
	$response = array();

	while($row = mysqli_fetch_array($result)){
  		array_push($response, array("sos_id"=>$row[0], "bangle_id"=>$row[1], "response_time"=>$row[2], "checked"=>$row[3], "checked_time"=>$row[4]));
	}

	echo json_encode(array("response"=>$response), JSON_UNESCAPED_UNICODE);

	mysqli_close($con);
?>