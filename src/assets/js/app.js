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
		.when('/account/change-password', {
			templateUrl : './assets/template/change-password.html',
			controller  : 'changePasswordController'
		})
		.when('/users', {
		 templateUrl : './assets/template/users.html',
		 controller  : 'adminUsersController'
		})
		.otherwise({
			redirectTo: '/'
		});
});

app.filter('markdown', function($sce) {
  return function(input) {
		input=micromarkdown.parse(input)
    return $sce.trustAsHtml(input);
  }
});

app.run(function($rootScope, $http, $cookies, $location) {
  $rootScope.loggedIn=true;
	$rootScope.admin=false;
	$http.post("./api/authentification/", {action: "isconnected"}).success(function(data){
		$rootScope.loggedIn=data.loggedIn;
		$rootScope.admin=data.admin;
		if(!$rootScope.loggedIn)
			$location.url('/login');
		else if($location.url()=='/login')
			$location.url('/');
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

app.controller('adminUsersController', function($rootScope, $scope, $location, $http, $uibModal) {
	if(!$rootScope.loggedIn || !$rootScope.admin)
		$location.url('/login');

		$scope.user={};
		$http.post("./api/admin/", {action: "get_users"}).success(function(data){
			$scope.users=data;
		});

		$scope.setAdmin = function(index) {
			if($scope.users[index].isAdmin == 'true'){
				var dialog=$rootScope.langue.dangerUnsetAdmin;
			}
			else {
				var dialog=$rootScope.langue.dangerSetAdmin;
			}
			dangerModal($uibModal, dialog, function() {
				$http.post("./api/admin/", {'action': 'set_admin', 'login': $scope.users[index].login, 'isAdmin': $scope.users[index].isAdmin})
					.success(function(data){
						if(data!="true") {
							errorModal($uibModal, function() {
								location.reload();
							});
						}
					})
					.error(function(data){
						errorModal($uibModal, function() {
							location.reload();
						});
					});
			}, function() {
				$scope.users[index].isAdmin=!$scope.users[index].isAdmin;
			});
		}

	$scope.addUser = function() {
			var modalInstance = $uibModal.open({
				templateUrl: 'assets/template/modal/addUser.html',
				controller: 'addUserModalController',
			});
			modalInstance.result.then(function(user) {
				$scope.users.push(user);
				$http.post("./api/admin/", {'action': 'add_user', 'login': user.login, 'isAdmin': user.isAdmin})
				.success(function(data){
					if(data!="true") {
						errorModal($uibModal, function() {
							location.reload();
						});
					}
				})
				.error(function(data){
					errorModal($uibModal, function() {
						location.reload();
					});
				});
			}, null);
		}

		$scope.delete = function(index) {
			dangerModal($uibModal, $rootScope.langue.dangerDeleteUser, function() {
				$http.post("./api/admin/", {'action': 'remove_user', 'login': $scope.users[index].login})
					.success(function(data){
						if(data!="true") {
							errorModal($uibModal, function() {
								location.reload();
							});
						}
						else
							$scope.users.splice(index,1);
					})
					.error(function(data){
						errorModal($uibModal, function() {
							location.reload();
						});
					});
			});
		}

		$scope.reset = function(index) {
			dangerModal($uibModal, $rootScope.langue.dangerReset, function() {
				$http.post("./api/admin/", {'action': 'reset_user', 'login': $scope.users[index].login})
				.success(function(data){
					if(data!="true") {
						errorModal($uibModal, function() {
							location.reload();
						});
					}
				})
				.error(function(data){
					errorModal($uibModal, function() {
						location.reload();
					});
				});
			});
		}
});

app.controller('addUserModalController', function($rootScope, $scope, $http, $uibModal, $uibModalInstance) {
	$scope.form = {};
	$scope.form.state=0;
});

app.controller('taskController', function($rootScope, $scope, $http, $uibModal) {
	$scope.tasks=[];
	$http.post("./api/tasks/").success(function(data){
		$scope.tasks=data;
	})
	.error(function(data){
		errorModal($uibModal, function() {});
	});

	$scope.add = function() {
		var modalInstance = $uibModal.open({
			templateUrl: 'assets/template/modal/addTask.html',
			controller: 'addTaskModalController'
		});
		modalInstance.result.then(function(task) {
			$scope.tasks.push(task);
			$http.post("./api/tasks/", {'action': 'add_task', 'task': task})
			.success(function(data){
				$scope.tasks=data;
			})
			.error(function(data){
				errorModal($uibModal, function() {
					location.reload();
				});
			});
		}, null);
	}

	$scope.edit = function(index, state) {
		var modalInstance = $uibModal.open({
			templateUrl: 'assets/template/modal/editTask.html',
			controller: 'editTaskModalController',
			resolve: {
				task: function () {
					return $scope.tasks[state][index];
				}
			}
		});
		modalInstance.result.then(function(task) {
			$http.post("./api/tasks/", {'action': 'edit_task', 'task': task, 'id': $scope.tasks[state][index].id})
			.success(function(data){
					$scope.tasks=data;
			})
			.error(function(data){
				errorModal($uibModal, function() {
					location.reload();
				});
			});
		}, null);
	}

	$scope.delete = function(index, state) {
		dangerModal($uibModal, $rootScope.langue.dangerDelete, function() {
			$http.post("./api/tasks/", {'action': 'delete_task', 'id': $scope.tasks[state][index].id})
			.success(function(data){
				$scope.tasks=data;
			})
			.error(function(data){
				errorModal($uibModal, function() {
					location.reload();
				});
			});
		})
	}

	$scope.changeState = function(index, state) {
		var task=$scope.tasks[state][index];
		task.state++;
		$http.post("./api/tasks/", {'action': 'edit_task', 'task': task, 'id': task.id})
		.success(function(data){
				$scope.tasks=data;
		})
		.error(function(data){
			errorModal($uibModal, function() {
				location.reload();
			});
		});
	}
});

app.controller('changePasswordController', function($rootScope, $scope, $http) {
	$scope.error={};
	$scope.form={};
	$scope.changePassword = function() {
		if($scope.form.newPassword!=$scope.form.confirmPassword){
			$scope.error.passwordConfirm=true;
			$scope.error.password=false;
			$scope.success=false;
			return;
		}
		$http.post("./api/authentification/", {'action': 'changePassword', 'oldPassword': $scope.form.oldPassword, 'newPassword': $scope.form.newPassword})
		.success(function(data){
			if(data=="true") {
				$scope.success=true;
				$scope.error.password=false;
				$scope.error.passwordConfirm=false;
			}
			else {
				$scope.success=false;
				$scope.error.password=true;
			}
			$scope.form.oldPassword="";
			$scope.form.newPassword="";
			$scope.form.confirmPassword="";
		})
		.error(function(data){
			errorModal($uibModal, function() {});
		});
	}
});

app.controller('loginController', function($rootScope, $scope, $location, $http, $cookies) {
	$scope.form={};
	$scope.error={};

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

app.controller('editTaskModalController', function($rootScope, $scope, $http, $uibModal, $uibModalInstance, task) {
	$scope.states=[
		{id: 0, label: $rootScope.langue.todo},
		{id: 1, label: $rootScope.langue.inProgress},
		{id: 2, label: $rootScope.langue.done}
	];

	$scope.form = {};
	$scope.form.title=task.title;
	$scope.form.description=task.description;
	$scope.form.user=task.user;
	$scope.form.state=task.state;
});

function dangerModal($uibModal, message, success, cancel) {
	var modalInstance = $uibModal.open({
		templateUrl: 'assets/template/modal/danger.html',
		controller: 'dangerModalController',
		resolve: {
			message: function () {
				return message;
			}
		}
	});

	modalInstance.result.then(success, cancel);
}

app.controller('dangerModalController', function($scope, $uibModalInstance, message) {
	$scope.message = message;
});

function errorModal($uibModal, callback) {
	var modalInstance = $uibModal.open({
		templateUrl: 'assets/template/modal/error.html'
	});

	modalInstance.result.then(callback, callback);
}
