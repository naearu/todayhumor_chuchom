function _popup( url, w, h){
    if( !w ) w = 600;
    if( !h ) h = 350;
    var window_left = (screen.width-w)/2;
    var window_top = (screen.height-h)/2;
    window.open(url,w,'width='+w+',height='+h+',scrollbars=yes,status=no,top=' +window_top+',left='+window_left+'');
}

var app = angular.module('my_app',[]);  

function appCtrl($scope,$rootScope,$http ){
	
	$scope.url = '';
	$scope.comment_list = [];
	$scope.email_only = 'N';
	$scope.lottery_count = '1';
	$scope.list_search = '';

	$scope.start = function(){

		if( $scope.url.length == 0 ){
			alert("짧은 주소를 입력해주세요.");
			return;
		}

		$scope.comment_list = [];

		$http({
		    url: './loader.php', 
		    method: "POST",
		    data: {
		    	'url': $scope.url,
		    	'email_only': $scope.email_only
		    }
		 })
		.success(function(data, status, headers, config) {

			$("#search").hide();
			$("#search_list").show();

			for( i in data){
				data[i].use = 1;
				data[i].seq = i;
				data[i].active = parseInt(data[i].active);
				data[i].up = parseInt(data[i].up);
				data[i].down = parseInt(data[i].down);
			}
			$scope.comment_list  = data;
		});
	}

	$scope.change_state = function( i, use ){

		$scope.comment_list[ i ].use = use;

		console.log( i, use,$scope.comment_list[ i ] );
		// $scope.$apply();

	}

	$scope.lottery_list = [];

	$scope.lottery = function( ){

		var lottery_count = parseInt( $("#lottery_count").val() );

		if( !lottery_count ){
			alert("당첨인원을 설정해주세요.");
			return;
		}

		// 제외된 인원빼고 몇명이나 되는지 확인.
		var active_list = 0;
		for( i in $scope.comment_list ){
			var item = $scope.comment_list[i];
			if( item.use == 1 ) active_list += 1;
		}

		if( active_list <= lottery_count ){
			alert("당첨인원에 비해 참여자가 적습니다.");
			return;
		}
		
		// 당첨자 담을 변수
		var prize_keys = [];
		do{
			
			var en = mt_rand( 0, $scope.comment_list.length-1 );

			// 이미 뽑은사람은 빼고..
			if( in_array(en,prize_keys) ) continue;

			// 제외한 인원도 빼고
			if( $scope.comment_list[ en ].use == 0 ) continue;

			$scope.lottery_list[ $scope.lottery_list.length ] = $scope.comment_list[ en ];

			array_push( prize_keys, en );

			// 필요한만큼 뽑으면 끝~
			if( $scope.lottery_list.length >= lottery_count ) break;

		}while(true);

		
		$("#search_list").hide();
		$("#lottery_result").show();

	}

};




