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
	<script src="vendor/js/angular-sanitize.min.js"></script>
</head>
<body>

	<div id="wrap" class="col-sm-12 col-md-8 col-md-offset-2" ng-app='getinside' ng-controller="pageController as ctrl">
		
		<!-- homepage -->
		<div id="entry" ng-include="'pages/home.php'" ng-controller='entryController as eCtrl' ng-model='eCtrl' ng-if="page.is(1)"></div>

		<!-- vendita -->
		<div id="sale" ng-include="'pages/sale.php'" ng-controller='saleController as sCtrl' ng-model='sCtrl' ng-if="page.is(2)"></div>

		<!-- verifica -->
		<div id="verify" ng-include="'pages/verify.php'" ng-controller='verifyController as vCtrl' ng-model='vCtrl' ng-if="page.is(3)"></div>

		<!-- help -->
		<div id="help" ng-include="'pages/help.php'" ng-if="page.is(4)"></div>

		
		<!-- jumbotron -->
		<div class="jumbotron {{jumbo.classes}}" ng-if="jumbo.show" ng-bind-html="jumbo.content"></div>

	</div>

	<!-- after everything loaded -->
	<script src="main.js"></script>
</body>
</html>
