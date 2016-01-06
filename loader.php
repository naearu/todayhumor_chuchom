<?

include "inc/function.php";

header('Content-Type: application/json');

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);


$html = request($request->url );

$entry = array();


do{
		
	// 게시글 번호 확인..
	if( !preg_match("/url1 = \"\/board\/ajax_memo\.php\?(table_memo_no=.+);/",$html,$out) ) break;

	parse_str($out[1],$params);

	$params = array(
	'table_memo_no'=>$params['table_memo_no'],
	'parent_id'=>$params['parent_id'],
	'last_memo_num'=>0,
	'memo_count_limit'=>100,
	'table'=>$params['table']
	);


	while( true ){

		$html = request("http://www.todayhumor.co.kr/board/ajax_memo.php?".http_build_query($params));

		// 데이터 수집에 실패하면 종료
		if( ! preg_match("/<script>lastMemoNumber = ([0-9]+)<\/script>/", $html,$out) ) break;

		// 이전과 종료숫자가 같다면 종료
		if( $params['last_memo_num'] == $out[1] ) break;

		$params['last_memo_num'] = $out[1];


		// 글 조각내기
		$list = explode("<!--memoContainerDiv-->",$html);

		
		foreach( $list as $item ){

			$info = array();
			// IP 확인
			preg_match("/<span style='color:red;'>([0-9\.\*]+)<\/span>/", $item,$info['ip']);
			preg_match("/<span style=\"white-space:nowrap;color:black;\">\(([0-9:\- ]+)\)<\/span>/", $item,$info['date']);
			preg_match("/<span style='color:gray; font-size:11px; white-space:nowrap;'>\(가입:([0-9\-]+) 방문:([0-9,]+)\)<\/span>/", $item,$info['active']);
			preg_match("/<span style=\"white-space:nowrap;color:red;\">추천:([0-9,]+) \/ 반대:([0-9,]+)<\/span>/", $item,$info['recommand']);
			preg_match("/<span style=\"color:#FF8C00;\">(.+)<\/span>/", $item,$info['nick']);


			if( !preg_match("/<a href=\"\/board\/myreply\.php\?mn=[0-9]+\" target=\"_blank\"><font color=black><b>(.+)<\/b><\/font><\/a><\/span>/", $item,$info['nick']) )
				preg_match("/<font color=gray>(익명.+)<\/font>/", $item,$info['nick']);


			preg_match("/<div class=\"memoContentDiv\" [^>]+>(.+)<\/div><\!--memoContentDiv-->/sm", $item,$info['memo']);
			
			if( !isset($info['date'][1]) || !isset($info['nick'][1]) ) continue;

			// 메모 정리
			$info['memo'] = trim( strip_tags($info['memo'][1]) );

            preg_match("/[^0-9]((02|03[0-9]|01[16890]|070|080)[ \-\._]?[0-9]{3,4}[ \-\._]?[0-9]{4})[^0-9]?/i", $info['memo'],$info['number']);
            preg_match("/[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}/i", $info['memo'],$info['mail']);


            if( $request->email_only == 'Y' && !isset($info['mail'][0]{0}) ) continue;

			$entry[] = array(
				'ip'=>$info['ip'][1],
				'date'=>$info['date'][1],
				'join'=>$info['active'][1],
				'active'=>$info['active'][2],
				'up'=>$info['recommand'][1],
				'down'=>$info['recommand'][2],
				'nick'=>$info['nick'][1],
				'memo'=>$info['memo'],
				'mail'=>$info['mail'][0],
			);

		}

	}


}while(false);



echo json_encode($entry);


