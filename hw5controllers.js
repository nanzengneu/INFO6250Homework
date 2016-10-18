var radisApp = angular.module("redis", []);
radisApp.controller('RedisCtrl', function($scope,$http) {
            $scope.message = [];
            $scope.submit = function(){
               $scope.result ={
                  firstname : "",
                  lastname : "",
                  sex = "",
                  email="",
        	  password = "",
		  confirmpassword ="",
		  address = "",
		  city = "",
		  state = "".
		  zipcode = "",
		  dateofbirth = "",      
	 };

               angular.forEach($scope.info, function(value, key){
                     $http.get("map.php?cmd=set&key="+key+"&value="+value)
                           .success(function (data, status, headers, config) {
                               $scope.redisResponse = "Updated.";
                           });
                     $http.get("map.php?cmd=get&key="+key)
                            .success(function (data, status, headers, config) {
                                $scope.result[key] = data.data;
                           })
                            .error(function (data, status, header, config) {
                                console.log(data);
                           });

               });
               $scope.message.push(userdata);
            }
});
