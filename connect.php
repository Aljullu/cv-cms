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
	return compress("<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', '" . get_analytics() . "', 'auto');
	  ga('send', 'pageview');
	</script>
	");
}
?>
