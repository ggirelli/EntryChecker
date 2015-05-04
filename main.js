angular.module('getinside', ['ngAnimate'])

	.controller('pageController',
		function($scope) {

			$scope.page = {
				value: 1,

				set: function (i) {
					$scope.page.value = i;
				},

				is: function (i) {
					return i == $scope.page.value;
				}
			};

		}
	)

	.controller('entryController', 
		function($scope, $http, $timeout) {
			
			var delay = 3000;

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
			$scope.enter = function() {

				var ticket = null;
				var residency = 0;
				if ( $scope.rTicket.is() ) {
					ticket = $scope.rTicket.value;
					residency = 1;
				}
				if ( $scope.ticket.is() ) ticket = $scope.ticket.value;

				if ( null == ticket ) return;

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
						if ( 1 == residency ) { data['ticket'] = 'R' + data['ticket']; }
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
											$scope.jumbo.content = 'Il biglietto #' + data['ticket'] + ' puo\' entrare';
											$timeout(function() { $scope.resetTicket(); }, delay);
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
						$timeout(function() { $scope.jumbo.reset(); }, delay);
					});

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

	.controller('saleController',
		function($scope, $http) {

		}
	)

	.controller('verifyController',
		function($scope, $http) {
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
						$scope.getList();
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
	);