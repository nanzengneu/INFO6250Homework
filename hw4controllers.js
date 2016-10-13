var redisApp = ngular.module('redis', ['ui.bootstrap']);


function RedisController() {}

RedisController.prototype.submit = function() {
     this.scope_.messages = [];
     var info = {
        firstname: this.scope_.firstname,
        lastname: this.scope_.lastname,
        sex: this.scope_.sex,
        email:this.scope_.email,
        password: this.scope_.password,
        confirmpassword: this.scope_.confirmpassword,
        address: this.scope_.address,
        city: this.scope_.city,
        state: this.scope_.state,
        zipcode: this.scope_.zipcode,
        dateofbirth: this.scope_.dateofbirth
        };
    this.scope_.messages.push(this.scope_.messages);
   /* this.scope_.info = "";*/
    var value = this.scope_.messages; 

    this.http_.get("app.php?cmd=append&key=messages&value=" + value)
            .success(angular.bind(this, function(data) {
                this.scope_.redisResponse = "Updated.";
            }));

};

redisApp.controller('redisCtrl', function ($scope, $http, $location) {
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


