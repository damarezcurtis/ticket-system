<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Marketing Ticket System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
	<meta http-equiv="imagetoolbar" content="No"/>
	<meta name="ROBOTS" content="NOINDEX,NOFOLLOW">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://kit.fontawesome.com/21d17be0b2.js" crossorigin="anonymous"></script>
<script crossorigin src="App.js"></script>	
<style type="text/css">
.border {
    border-color: #FFFFFF !important;
    border-width: 4px !important;
    border-style: solid !important;
}
.radiobtn {
    width: 20px;
    height: 20px;
}
legend.scheduler-border {
    width:inherit; /* Or auto */
    padding:0 10px; /* To give a bit of padding on the left and right */
    border-bottom:1px solid;
}
</style>

</head>

<body style='background-color:#cccccc;'>

	<div class="container" style="background-color: #FFFFFF;padding:0 !important;">
		<div class="vck" style="background: linear-gradient(to right,  rgb(38,74,151), rgb(25,160,222) ); border-top-left-radius: 0px;border-top-right-radius: 0px;"><img src="images/VCK_Logo_2014_3D_ronde_hoeken.svg" alt="" style="width:150px; margin-top:40px; margin-left:40px;margin-bottom:40px;"/> </div>
		<nav class="navbar navbar-light bg-light">
  
 
 
 
<div class="nav-item"><div class=""><form class="d-flex">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
				</form></div></div>
<div class="nav-item"><a class="btn btn-primary position-relative" href="view.php">
  Inbox
  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
   <?php require('ticket/alert.php'); ?>+
    <span class="visually-hidden">unread messages</span>
  </span>
</a></div>
</nav>
	<?php require('ticket/getTicket.php'); ?>
		<div style="background-color: #9ea6a9;width:100% !important;float:left;margin-top: -15px;"><img src="images/Member_grijs_cmyk.svg" alt="" width="200" style=" margin-top:30px;margin-bottom:25px; "/> </div>
		</div>
	 
</body>
</html>