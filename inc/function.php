<?
/**
* Function Collection
* @version 1.2 (2014-07-15)
* @author Go Kwang Jin < naearu2@gmail.com >
*/


/**
* Curl Request
*
* @param string $code
* @param string $name
*
* @return string
*/
function request($url,$post=null ){
 
    $uInfo = parse_url($url);
    $ch = curl_init();
    $options = array(
        CURLOPT_URL                 =>  $url,
        CURLOPT_HEADER              =>  0,
        CURLOPT_USERAGENT           =>  "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.122 Safari/534.30",
        CURLOPT_FOLLOWLOCATION      =>  true,
        CURLOPT_RETURNTRANSFER      =>  true,
        CURLOPT_TIMEOUT             =>  5,
        CURLOPT_CONNECTTIMEOUT      =>  5,
    );

    if( strtolower($uInfo['scheme'])  == "https" ){
        $options[CURLOPT_SSL_VERIFYPEER] = FALSE;
        $options[CURLOPT_SSLVERSION] = 3;
    }
    if( !is_null( $post )){
        $options[CUSTOMREQUEST] = 'POST';
        $options[CURLOPT_POST] = true;
        $options[CURLOPT_POSTFIELDS] = $post;
    }

    curl_setopt_array($ch, $options);

    
    $ex=curl_exec ($ch);   

    return $ex;
}


