var redisApp = angular.module('redis', ['ui.bootstrap']);


function RedisController() {}

RedisController.prototype.submit = function() {
     this.scope_.message = [];
     var info = {
        firstname: $scope.firstname,
        lastname: $scope.lastname,
        sex: $scope.sex,
        email: $scope.email,
        password: $scope.password,
        confirmpassword: $scope.confirmpassword,
        address: $scope.address,
        city: $scope.city,
        state: $scope.state,
        zipcode: $scope.zipcode,
        dateofbirth: $scope.dateofbirth
        };
    this.scope_.message.push(this.scope_.info);
   /* this.scope_.info = "";*/
    var value = this.scope_.info; 

    this.http_.get("app.php?cmd=set&key=messages&value=" + value)
            .success(angular.bind(this, function(data) {
                this.scope_.redisResponse = "Updated.";
            }));

};

redisApp.controller('RedisCtrl', function ($scope, $http, $location) {
        $scope.controller = new RedisController();
        $scope.controller.scope_ = $scope;
        $scope.controller.location_ = $location;
        $scope.controller.http_ = $http;
        $scope.controller.http_.get("app.php?cmd=get&key=messages")
            .success(function(data) {
                console.log(data);
                $scope.messages = data.data.split(",");
            });

});


