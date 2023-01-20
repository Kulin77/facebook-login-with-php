<?php
session_start();
include_once 'lib/Facebook/autoload.php';
?>
<html>
<head>
	<title>
		Social login - Facebook
	</title>
		
	</head>

<body>

<!--wwc_div_header-->
<div class="wwc_div_header" align="center"><h2>Facebook</h2></div>
<!--wwc_div_header-->

<!--wwc_body_div-->
<div class="wwc_body_div">

<!--wwc_body_div_inner-->
<div align="center" class="wwc_body_div_inner">

<!--content-->
<div id="content">
<a href="fblogin.php" data-action="connect" data-plugin="socialautoposter" data-popupwidth="600" data-popupheight="800" rel="nofollow" aria-label="Continue with <b>Facebook</b>">
	<img src="images/facebook.png" alt="Connect with Facebook"/>
</a>
</div><!--content-->
</div><!--wwc_body_div_inner-->

</div><!--wwc_body_div-->
	<script type="text/javascript" src="js/jquery-1.8.2.min.js" ></script>
	<script type="text/javascript" src="js/facebook.js" ></script> 
</body>
</html>