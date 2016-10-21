	var app = angular.module('myApp', []);
        app.controller('meController', function($scope) {
           $scope.res = [];
           $scope.submit = function() {
              
              var data = {
              firstname: $scope.firstname,
              lastname: $scope.lastname,
              sex: $scope.sex,
              email:$scope.email,
              password: $scope.password,
              confirmpassword: $scope.confirmpassword,
              address: $scope.address,
              city: $scope.city,
              state: $scope.state,
              zipcode: $scope.zipcode,
              dateofbirth: $scope.dateofbirth
              };
           $scope.res.push(data);
           }
        });
