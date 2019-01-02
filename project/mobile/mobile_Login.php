<?php
	$con = mysqli_connect("localhost", "root", "", "gps");
 	mysqli_set_charset($con, "UTF8");

	$bangle_id =$_POST["bangle_id"];
	$bangle_pw =$_POST["bangle_pw"];

	$statement = mysqli_prepare($con, "select * from bangle where bangle_id = ? and bangle_pw = ?");
	mysqli_stmt_bind_param($statement, "ss", $bangle_id, $bangle_pw);
	mysqli_stmt_execute($statement);

	mysqli_stmt_store_result($statement);
	mysqli_stmt_bind_result($statement, $bangle_id, $bangle_pw, $ship_id, $request_major, $request_rssi);

	$response = array();
	$response["success"] = false;

	while(mysqli_stmt_fetch($statement)){
		$response["success"] = true;
		$response["bangle_id"] = $bangle_id;
		$response["bangle_pw"] = $bangle_pw;
		$response["ship_id"] = $ship_id;
		$response["request_major"] = $request_major;
		$response["request_rssi"] = $request_rssi;
	}

	echo json_encode($response);

	mysqli_close($con);
?>