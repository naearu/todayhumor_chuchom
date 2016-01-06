<!doctype html>
<html  xmlns:ng="//angularjs.org" ng-app="my_app" id="ng-app" >
	<head> 
		<meta charset="utf-8">
		<meta http-equiv="pragma" content="no-cache" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title> 간편 </title>

		<link href="./css/custom.css" rel="stylesheet">
		<link href="./css/bootstrap.min.css" rel="stylesheet">


		<!--[if lte IE 8]>
		  <script src="./js/json3.min.js"></script>
		<![endif]-->


	</head>
	<body ng-controller='appCtrl'>

		<div class="container" style="margin-top:100px;" >
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body" id="search">
					  		<div class="row" >
					  			<div class="col-md-12">
					    			<h1>추첨기</h1>
					    		</div>
					    		<div class="col-md-12 padded">
					    			<input type="text" class="form-control input-lg" ng-model="url" placeholder=" http://todayhumor.com/?bestofbest_170188 ">

									<div class="checkbox">
										<label><input type="checkbox" ng-model="email_only" ng-true-value='Y' ng-false-value='N' > 이메일 있는것만 골라보기</label>
									</div>

					    		</div>
					    		<div class="col-md-12 padded">
							    	<button class="btn btn-block btn-success btn-lg" ng-click="start()" >Go!</button>
							    </div>
<!-- 							    <div class="col-md-12">

									<div class="alert alert-success" role="alert">...</div>
									<div class="alert alert-info" role="alert">...</div>
									<div class="alert alert-warning" role="alert">...</div>
									<div class="alert alert-danger" role="alert">...</div>

								</div> -->
							</div>

						</div>


						<div class="panel-body" id="search_list" style="display:none;">


					  		<div class="alert alert-info" role="alert">아래 목록을 편집하신 후 아래 추첨 버튼을 눌러주세요.(총 {{comment_list.length}}개)</div>
						<div class="row">
				    		<div class="col-md-12 padded">
							  <div class="form-group">
							    <label for="inputEmail3" class="col-sm-2 control-label">검색</label>
							    <div class="col-sm-10">
							      <input type="text" class="form-control" ng-model="searchText">
							    </div>
							  </div>
						    </div>
						</div>

					  		<div class="row" >
					  			<div class="col-md-12" style="height:500px;overflow-y:scroll;">
					  			<table class="table">
					  				<tr>
										<th ng-click="list_sort='ip'">ip</th>
										<th ng-click="list_sort='date'">date</th>
										<th ng-click="list_sort='join'">join</th>
										<th ng-click="list_sort='active'">active</th>
										<th ng-click="list_sort='up'">up</th>
										<th ng-click="list_sort='down'">down</th>
										<th ng-click="list_sort='nick'">nick</th>
										<th ng-click="list_sort='memo'" ng-show="email_only=='N'">memo</th>
										<th ng-click="list_sort='mail'">mail</th>
										<th >Action</th>
					  				</tr>

					  				<tr ng-repeat=" item in comment_list | orderBy : list_sort | filter:searchText " class="item_{{item.use}}">
										<td>{{item.ip}}</td>
										<td>{{item.date}}</td>
										<td>{{item.join}}</td>
										<td>{{item.active}}</td>
										<td>{{item.up}}</td>
										<td>{{item.down}}</td>
										<td>{{item.nick}}</td>
										<td ng-show="email_only=='N'">{{item.memo}}</td>
										<td>{{item.mail}}</td>
										<td>
											<button class="btn btn-xs btn-danger" ng-show="item.use == 1"  ng-click='change_state(item.seq,0)'>제외</button>
											<button class="btn btn-xs btn-success" ng-show="item.use != 1" ng-click='change_state(item.seq,1)'>복구</button>
										</td>
					  				</tr>
					  			</table>



								</div>
							</div>
						<div class="row">

					    		<div class="col-md-6 padded">

								  <div class="form-group">
								    <label for="inputEmail3" class="col-sm-4 control-label">당첨인원</label>
								    <div class="col-sm-8">
								      <input type="text" class="form-control" id='lottery_count' placeholder="숫자만 입력하세요.">
								    </div>
								  </div>

							    </div>


					    		<div class="col-md-6 padded">
							    	<button class="btn btn-block btn-success btn-lg" ng-click="lottery()" >추첨!</button>
							    </div>


						</div>
					</div>


					<div class="panel-body" id="lottery_result" style="display:none;">

					  		<div class="row" >
					  			<div class="col-md-12" style="height:500px;overflow-y:scroll;">
					  			<table class="table">
					  				<tr>
										<th>ip</th>
										<th>date</th>
										<th>join</th>
										<th>active</th>
										<th>up</th>
										<th>down</th>
										<th>nick</th>
										<th ng-show="email_only=='N'">memo</th>
										<th>mail</th>
					  				</tr>

					  				<tr ng-repeat=" item in lottery_list" class="item_{{item.use}}">
										<td>{{item.ip}}</td>
										<td>{{item.date}}</td>
										<td>{{item.join}}</td>
										<td>{{item.active}}</td>
										<td>{{item.up}}</td>
										<td>{{item.down}}</td>
										<td>{{item.nick}}</td>
										<td ng-show="email_only=='N'">{{item.memo}}</td>
										<td>{{item.mail}}</td>
					  				</tr>
					  			</table>



								</div>
							</div>

					</div>


					
				</div>
			</div>
		</div>

		<script type="text/javascript" src="./js/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="./js/bootstrap.min.js"></script>
		<script type="text/javascript" src="./js/angular.min.js"></script>
		<script type="text/javascript" src="./js/application.js"></script>
		<script type="text/javascript" src="./js/php.default.js"></script>


	</body>
</html>




