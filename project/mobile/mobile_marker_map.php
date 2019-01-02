<?php
	$con = mysqli_connect("localhost", "root", "", "gps");
	mysqli_set_charset($con, "utf8");

	$bangle_id = $_GET["bangle_id"];

	$result = mysqli_query($con, "SELECT * FROM ship WHERE ship_id IN (SELECT ship_id FROM bangle WHERE bangle_id = '$bangle_id')");
	$response = array();

	while($row = mysqli_fetch_array($result)){
  		array_push($response, array("ship_id"=>$row[0], "ship_name"=>$row[1],"latitude"=>$row[2], "longitude"=>$row[3], "outport"=>$row[4], "inport"=>$row[5], "max_floor"=>$row[6]));
	}

	echo json_encode(array("response"=>$response), JSON_UNESCAPED_UNICODE);

	mysqli_close($con);
?>