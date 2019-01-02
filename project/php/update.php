<?php
   $con = mysqli_connect("localhost", "root", "","gps");
   mysqli_set_charset($con, "UTF8");

   $check = $_GET["check"];
  
  

    $result = mysqli_query($con, "UPDATE sos SET checked = '1', checked_time = now() WHERE sos_id = '$check'");


?>

<script>

 location.href="sos_view.php";
</script>

