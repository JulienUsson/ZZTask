var app = angular.module('ZZTask', ['ngRoute']);

app.config(function($routeProvider, $locationProvider) {
	$routeProvider
		.when('/', {
			templateUrl : 'pages/task.html',
			controller  : 'taskController'
        })
        .when('/login', {
			templateUrl : 'pages/login.html',
			controller  : 'loginController'
        });
		$locationProvider.html5Mode(true);
});

app.run(function($rootScope, $http) {
    $rootScope.loggedIn=false;
		$http.post("./services/authentification/", {action: "isconnected"}).success(function(data){
			$rootScope.loggedIn=data;
		});
});

app.controller('menuController', function($rootScope, $scope, $location, $http) {
	$scope.logout = function() {
		$http.post("./services/authentification/", {action: "logout"}).success(function(data){
			if(data=="true") {
				$rootScope.loggedIn=false;
				$location.url('/login');
			}
		});
	}
});

app.controller('taskController', function($rootScope, $scope, $location, $http) {
	if(!$rootScope.loggedIn)
		$location.url('/login');

	$scope.tasks={}
	$scope.tasks.todo={};
	$scope.tasks.inProgress={};
	$scope.tasks.done={};
});

app.controller('loginController', function($rootScope, $scope, $location, $http) {
	if($rootScope.loggedIn)
		$location.url('/');

	$scope.form={};

	$scope.login = function() {
		var params= {action: "login", login: $scope.form.login, password: $scope.form.password};
		$http.post("./services/authentification/", params).success(function(data){
			if(data=="true") {
				$rootScope.loggedIn=true;
				$location.url('/');
			}
		});
	};
});
