<?php // Template name: Переход по ссылке
?>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
 
<?php
$url = isset($_REQUEST['link']) ? $_REQUEST['link'] : '';
$shop_id = isset($_REQUEST['shop_id']) ? $_REQUEST['shop_id'] : '';
$vitrina_id = isset($_REQUEST['vitrina_id']) ? $_REQUEST['vitrina_id'] : '';
$pr_count = isset($_REQUEST['pr_count']) ? $_REQUEST['pr_count'] : '';
$sub_id = isset($_REQUEST['sub_id']) ? $_REQUEST['sub_id'] : '';
$site_id = str_replace('.', '', $_SERVER['SERVER_NAME']);



$POST = array (
		 'api_key' => '',
		 'action' => 'go_to_link',
		 'url' => $url,
		 'shop_id' => $shop_id,
		 'vitrina_id' => $vitrina_id,
		 'pr_count' => $pr_count,
		 'sub_id' => $sub_id,
		 'site_id' => $site_id
	);

		// Устанавливаем соединение
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_URL, 'http://adproduct.ru/api');
		$result = curl_exec($ch);
		
		$obj = json_decode($result, true);
		var_dump($obj['url']);
		
		//wp_redirect( $obj->url);
		exit;
		
?>