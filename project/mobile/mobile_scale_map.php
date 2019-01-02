<?php
	$con = mysqli_connect("localhost", "root", "", "gps");
	mysqli_set_charset($con, "utf8");

	$bangle_id = $_GET["bangle_id"];

	$result = mysqli_query($con, "SELECT be.ship_id, be.beacon_floor, be.center_width, be.center_height FROM beacon be WHERE be.beacon_major IN
		(SELECT ba.request_major from bangle ba where ba.bangle_id IN (SELECT us.bangle_id FROM user us WHERE us.user_parent = '$bangle_id' and ba.ship_id = be.ship_id))");
	$response = array();

	while($row = mysqli_fetch_array($result)){
  		array_push($response, array("ship_id"=>$row[0], "beacon_floor"=>$row[1], "center_width"=>$row[2], "center_height"=>$row[3]));
	}

	echo json_encode(array("response"=>$response), JSON_UNESCAPED_UNICODE);

	mysqli_close($con);
?>