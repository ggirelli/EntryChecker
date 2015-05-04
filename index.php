<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Festa di Primavera 2015 - Get Inside</title>

	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet"  type="text/css" href="vendor/css/bootstrap.css" />
	<link rel="stylesheet"  type="text/css" href="style.css" />

	<script src="vendor/js/jquery.min.js"></script>
	<script src="vendor/js/bootstrap.min.js"></script>
	<script src="vendor/js/angular.min.js"></script>
	<script src="vendor/js/angular-animate.min.js"></script>
</head>
<body>

	<div id="wrap" class="col-sm-8 col-sm-offset-2" ng-app='getinside' ng-controller="pageController as ctrl">
		
		<!-- homepage -->
		<div ng-include="'pages/home.php'" ng-controller='entryController as eCtrl' ng-model='eCtrl' ng-if="page.is(1)"></div>

		<!-- vendita -->
		<div ng-include="'pages/sale.php'" ng-controller='saleController as sCtrl' ng-model='sCtrl' ng-if="page.is(2)"></div>

		<div ng-include="'pages/verify.php'" ng-controller='verifyController as vCtrl' ng-model='vCtrl' ng-if="page.is(3)"></div>


	</div>

	<!-- after everything loaded -->
	<script src="main.js"></script>
</body>
</html>
