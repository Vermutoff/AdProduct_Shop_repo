<?php
// Template name: Получаем XML файлы

define('BASEPATH_GS', str_replace('\\', '/', dirname(__FILE__)) . '/');

$xml_requests = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'wpcf-xml_file'", ARRAY_A);
//var_dump($xml_requests);	
$count=0;
foreach($xml_requests as $arr_request => $meta_value) {
$count++;
	$xml_for_file = $meta_value['meta_value'];
	
	$xml_for_gs = str_replace(' ','%20',$xml_for_file);	

		$urll  = 'http://api.gdeslon.ru/api/search.xml?q=';
		$urll .= $xml_for_gs;
		$urll .= '&l=99&_gs_at=7f54c3db2888b7a476661eb5410c608e9dff86fe';
		$url = (string)$urll;
				$ch = curl_init();			
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				$st = curl_redir_exec($ch);
				$st = curl_exec($ch);
				$fd = @fopen(BASEPATH_GS.'/product_xmls/'.$xml_for_file.'.xml', 'w');
				fwrite($fd, $st);
				@fclose($fd);
				curl_close($ch);
	
	sleep(1.2);
//if($count==1) break;
}


/* Редирект по cURL
==========================================*/
function curl_redir_exec($ch)
  {
  static $curl_loops = 0;
  static $curl_max_loops = 20;
  if ($curl_loops >= $curl_max_loops)
    {
    $curl_loops = 0;
    return false;
    }
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $data = curl_exec($ch);
  list($header, $data) = explode("\n\n", $data, 2);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  
  if ($http_code == 301 || $http_code == 302)
    {
    $matches = array();
    preg_match('/Location:(.*?)\n/', $header, $matches);
    $url = @parse_url(trim(array_pop($matches)));
    if (!$url)
      {
      $curl_loops = 0;
      return $data;
      }
    $last_url = parse_url(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
    
    if (!$url['scheme'])
      $url['scheme'] = $last_url['scheme'];
    if (!$url['host'])
      $url['host'] = $last_url['host'];
    if (!$url['path'])
      $url['path'] = $last_url['path'];
    $new_url = $url['scheme'] . '://' . $url['host'] . $url['path'] . ($url['query']?'?'.$url['query']:'');
    echo $new_url.' --- '.$http_code.'<br>';
    curl_setopt($ch, CURLOPT_URL, $new_url);
    return curl_redir_exec($ch);
    }
  else
    {
    $curl_loops = 0;
    return $data;
    }
  }
?>