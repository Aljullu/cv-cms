<?php
// Database connection
$con=mysqli_connect("SERVER", "USER", "PASSWORD", "DATABASE");
if (mysqli_connect_errno())
  echo __("Failed to connect to MySQL: ") . mysqli_connect_error();
mysqli_query($con,"SET NAMES utf8;");

function close_connection() {
	global $con;

	mysqli_close($con);
}

function get_google_analytics_code() {
	return compress("<script>CODE</script>");
}
?>
