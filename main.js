angular.module('getinside', ['ngAnimate', 'ngSanitize'])

	.controller('pageController',
		function($scope) {

			$scope.delay = 3000;

			$scope.page = {
				value: 1,

				set: function (i) {
					$scope.page.value = i;
				},

				is: function (i) {
					return i == $scope.page.value;
				}
			};

			$scope.jumbo = {
				show: false,
				toggle: function() {
					$scope.jumbo.show = !$scope.jumbo.show;
				},
				classes: '',
				content: '',
				reset: function() {
					$scope.jumbo.show = false;
					$scope.jumbo.classes = '';
					$scope.jumbo.content = '';
				}
			};

		}
	)

	.controller('entryController', 
		function($scope, $http, $timeout) {

			/**
			 * Residency ticket
			 * @type {Object}
			 */
			$scope.rTicket = {

				value: null,

				is: function() {
					return( null != $scope.rTicket.value );
				},

				reset: function() {
					$scope.rTicket.value = null;
				}

			};

			/**
			 * Normal ticket
			 * @type {Object}
			 */
			$scope.ticket = {

				value: null,

				is: function() {
					return( null != $scope.ticket.value );
				},

				reset: function() {
					$scope.ticket.value = null;
				}

			};

			$scope.resetTicket = function () {
				$scope.rTicket.value = null;
				$scope.ticket.value = null;
			}

			/**
			 * Saves the ticket in the database
			 * @return {null}
			 */
			$scope.enter = function () {

				var ticket = null;
				var residency = 0;
				if ( $scope.rTicket.is() ) {
					ticket = "R" + $scope.rTicket.value;
					residency = 1;
				}
				if ( $scope.ticket.is() ) ticket = $scope.ticket.value;

				if ( null == ticket ) {
					$scope.jumbo.classes = 'red';
					$scope.jumbo.content = 'Leggi le istruzioni se non sai come fare.';
					$scope.jumbo.toggle();
					$timeout(function () { $scope.jumbo.reset(); }, $scope.delay);
					return;
				}

				$http({

					method: 'POST',
					data: {
						action: 'entry',
						ticket: ticket,
						residency: residency
					},
					url: 'be/'

				})
					.success(function(data) {
						$scope.jumbo.classes = 'red';
						switch(data['err']) {
							case -1: {
								$scope.jumbo.content = 'Cannot reach the database';
								break;
							}
							case 0: {
								if ( 0 == data['sold'] ) {
									$scope.jumbo.content = 'Biglietto #' + data['ticket'] + ' invenduto';
								} else {
									if ( 1 == data['entered'] ) {
										$scope.jumbo.content = 'Biglietto #' + data['ticket'] + ' gia\' entrato';
									} else {
										if ( 1 == data['entering'] ) {
											$scope.jumbo.classes = 'green';
											$scope.jumbo.content = 'Il biglietto #' + data['ticket'] + ' puo\' entrare.<br />';
											$scope.jumbo.content += 'Entrata numero: ' + data['number'];
											$timeout(function() { $scope.resetTicket(); }, $scope.delay);
										}
									}
								}
								break;
							}
							case 1: {
								$scope.jumbo.content = 'Biglietto #' + data['ticket'] + ' sconosciuto';
								break;
							}
							case 2: {
								$scope.jumbo.content = 'Segnala questo errore all\'admin';
								break;
							}
						};
						$scope.jumbo.toggle();
						$timeout(function() { $scope.jumbo.reset(); }, $scope.delay);
					});

			};

		}
	)

	.controller('saleController',
		function($scope, $http, $timeout) {

			$scope.saleTmp = {
				name: null,
				number: null,
				pwd: null,
				reset: function () {
					$scope.saleTmp.name = null;
					$scope.saleTmp.number = null;
					$scope.saleTmp.pwd = null;
				}
			};

			$scope.sale = function () {

				$http({

					method: 'POST',
					data: {
						action: 'sale',
						ticket: $scope.saleTmp.number,
						name: $scope.saleTmp.name,
						pwd: $scope.saleTmp.pwd
					},
					url: 'be/'

				})
					.success(function (data) {
						console.log(data);
						$scope.jumbo.classes = 'red';
						switch(data['err']) {
							case 1: {
								$scope.jumbo.content = 'Biglietto non trovato.';
								break;
							}
							case -1: case 2: case 4: {
								$scope.jumbo.content = 'Errore, contatta l\'admin';
								break;
							}
							case 3: {
								$scope.jumbo.content = 'Biglietto già venduto.';
								break;
							}
							case 0: {
								$scope.jumbo.classes = 'green';
								$scope.jumbo.content = 'Biglietto #' + $scope.saleTmp.number + ' venduto a ' + $scope.saleTmp.name + '.';
								$scope.saleTmp.reset();
								break;
							}
						}
						$scope.jumbo.toggle();
						$timeout(function () { $scope.jumbo.reset(); }, $scope.delay);
					});

			};

		}
	)

	.controller('verifyController',
		function($scope, $http, $timeout) {
			$scope.pwd = '';
			$scope.ticketList = [];

			$scope.ticketFilter = {
				number: '',
				name: '',
				resetNumber: function () {
					$scope.ticketFilter.number = '';
				},
				resetName: function () {
					$scope.ticketFilter.name = '';
				}
			}

			$scope.setNotEntered = function (id, pwd) {
				$http({

					method: 'POST',
					data: {
						action: 'setNotEntered',
						ticket: id,
						pwd: pwd
					},
					url: 'be/'

				})
					.success(function (data) {
						console.log(data);
						if ( 0 == data['err'] ) {
							$scope.jumbo.classes = 'green';
							$scope.jumbo.content = 'Biglietto #' + data['id'] + ' impostato come "NON ENTRATO".';
						} else {
							$scope.jumbo.classes = 'red';
							$scope.jumbo.content = 'Errore, chiama l\'admin.';
						}
						$scope.jumbo.toggle();
						$timeout(function () { $scope.jumbo.reset(); }, $scope.delay);
						$scope.getList();
					});

			};

			$scope.howManyInside = function () {

				$http({

					method: 'POST',
					data: {
						action: 'howManyInside'
					},
					url: 'be/'

				})
					.success(function (data) {
						console.log(data);
						alert(data['number']);
					});

			};
			
			/**
			 * Retrieve ticket information
			 * @return {null}
			 */
			$scope.getList = function () {

				$http({

					method: 'POST',
					data: {
						action: 'listTickets'
					},
					url: 'be/'

				})
					.success(function (data) {
						$scope.ticketList = data;
					});

			};

			$scope.getList();

		}
	)

	.controller('initDataBaseController',
		function($scope, $http) {

			$scope.initDataBase = function () {

				var ans = prompt('Inizializzare il database? (y/n)');
				if ( 'y' != ans ) return;

				$http({

					method: 'POST',
					data: {
						action: 'initDataBase'
					},
					url: 'be/'

				})
					.success(function (data) {
						console.log(data);
					});

			};

			$scope.initDataBase();

		}
	);