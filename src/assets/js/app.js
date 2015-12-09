var app = angular.module('ZZTask', ['ngRoute']);

app.config(function($routeProvider) {
	$routeProvider
		.when('/', {
			templateUrl : 'pages/task.html',
			controller  : 'taskController'
        })
        .when('/login', {
			templateUrl : 'pages/login.html',
			controller  : 'loginController'
        });
});

app.run(function($rootScope) {
    $rootScope.loggedIn=false;
});

app.controller('taskController', function($rootScope, $scope, $location) {
	if(!$rootScope.loggedIn)
		$location.url('/login');
});

app.controller('loginController', function($rootScope, $scope) {
	if($rootScope.loggedIn)
		$location.url('/');
});
