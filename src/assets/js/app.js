var app = angular.module('ZZTask', ['ngRoute', 'ngCookies', 'ngAnimate', 'ui.bootstrap']);

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

app.run(function($rootScope, $http, $cookies) {
  $rootScope.loggedIn=true;
	$rootScope.admin=false;
	$http.post("./api/authentification/", {action: "isconnected"}).success(function(data){
		$rootScope.loggedIn=data.loggedIn;
		$rootScope.admin=data.admin;
	});

	$rootScope.selectedLangue=($cookies.get('langue'))?$cookies.get('langue'):'en';
	$rootScope.langue={};
	$http.post("./assets/json/langue_"+ $rootScope.selectedLangue +".json").success(function(data){
		$rootScope.langue=data;
	});

	$rootScope.setLangue = function(langue) {
		$rootScope.selectedLangue=langue;
		$cookies.put('langue', $rootScope.selectedLangue);
		$http.post("./assets/json/langue_"+ langue +".json").success(function(data){
			$rootScope.langue=data;
		});
	};
});

app.controller('menuController', function($rootScope, $scope, $location, $http) {
	$scope.logout = function() {
		$http.post("./api/authentification/", {action: "logout"}).success(function(data){
				$rootScope.loggedIn=false;
				$rootScope.admin=false;
				$location.url('/login');
		});
	}
});

app.controller('taskController', function($rootScope, $scope, $location, $http, $uibModal) {
	if(!$rootScope.loggedIn)
		$location.url('/login');

	$scope.tasks=[];
	$http.post("./api/tasks/", {action: "get_tasks"}).success(function(data){
		$scope.tasks=data;
	});

	$scope.add = function() {
		var modalInstance = $uibModal.open({
			templateUrl: 'assets/template/modal/addTask.html',
			controller: 'addTaskModalController'
		});
		modalInstance.result.then(function(task) {
			$scope.tasks.push(task);
		}, null);
	}
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
			$rootScope.loggedIn=data.loggedIn;
			$rootScope.admin=data.admin;
			if($rootScope.loggedIn)
				$location.url('/');
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

app.controller('addTaskModalController', function($rootScope, $scope, $http, $uibModal, $uibModalInstance) {
	$scope.form = {};
	$scope.form.state=0;
});
