<?php
	$con = mysqli_connect("localhost", "root", "", "gps");
	mysqli_set_charset($con, "utf8");

	$sos_id = $_GET["sos_id"];

	$result = mysqli_query($con, "SELECT fire, fall, leak, etc, message from sos where sos_id = '$sos_id'");
	$response = array();

	while($row = mysqli_fetch_array($result)){
  		array_push($response, array("fire"=>$row[0], "fall"=>$row[1], "leak"=>$row[2], "etc"=>$row[3], "message"=>$row[4]));
	}

	echo json_encode(array("response"=>$response), JSON_UNESCAPED_UNICODE);

	mysqli_close($con);
?>