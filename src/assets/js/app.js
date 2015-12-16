var app = angular.module('ZZTask', ['ngRoute', 'ngCookies']);

app.config(function($routeProvider) {
	$routeProvider
		.when('/', {
			templateUrl : './assets/template/task.html',
			controller  : 'taskController'
        })
        .when('/login', {
			templateUrl : './assets/template/login.html',
			controller  : 'loginController'
        })        
        .otherwise({
			redirectTo: '/'
		});
});

app.run(function($rootScope, $http) {
    $rootScope.loggedIn=false;
	$http.post("./api/authentification/", {action: "isconnected"}).success(function(data){
		if(data=="true")
			$rootScope.loggedIn=true;
	});
	$rootScope.langue={};
	$http.post("./assets/json/langue_en.json").success(function(data){
		$rootScope.langue=data;
	});
});

app.controller('menuController', function($rootScope, $scope, $location, $http) {
	$scope.logout = function() {
		$http.post("./api/authentification/", {action: "logout"}).success(function(data){
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

app.controller('loginController', function($rootScope, $scope, $location, $http, $cookies) {
	$scope.form={};
	$scope.error={};
	
	if($rootScope.loggedIn)
		$location.url('/');
		
	$scope.rememberMe=($cookies.get('rememberMe')=='true');
	if($scope.rememberMe)
		$scope.form.login=$cookies.get('login');
	
	$scope.login = function() {
		$cookies.put('login', $scope.form.login);
		var params= {action: "login", login: $scope.form.login, password: $scope.form.password};
		$http.post("./api/authentification/", params).success(function(data){
			if(data=="true") {
				$rootScope.loggedIn=true;
				$location.url('/');
			}
			else {
				$scope.form.password="";
				$scope.error.login=true;
			}
		});
	};
	
	$scope.$watch('rememberMe', function() {
		$cookies.put('rememberMe', $scope.rememberMe);
	});
});
