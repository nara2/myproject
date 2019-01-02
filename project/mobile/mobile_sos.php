<?php
	$con = mysqli_connect("localhost", "root", "", "gps");
 	mysqli_set_charset($con, "UTF8");

	$bangle_id = $_POST["bangle_id"];
	$fire = $_POST["fire"];
  $fall = $_POST["fall"];
  $leak = $_POST["leak"];
  $etc = $_POST["etc"];
  $message = $_POST["message"];

	$statement = mysqli_prepare($con, "insert into sos(bangle_id, fire, fall, leak, etc, message, response_time, checked) values (?, ?, ?, ?, ?, ?, now(), 0)");
	mysqli_stmt_bind_param($statement, "siiiis", $bangle_id, $fire, $fall, $leak, $etc, $message);
	mysqli_stmt_execute($statement);

  $response = array();
  $response["success"] = true;

  echo json_encode($response);

	mysqli_close($con);
?>