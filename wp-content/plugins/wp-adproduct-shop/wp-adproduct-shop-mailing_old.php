<?php 





add_action('wp_ajax_adproduct_send_email_from_post', 'adproduct_send_email_from_post_callback');
add_action('wp_ajax_nopriv_adproduct_send_email_from_post', 'adproduct_send_email_from_post_callback');
function adproduct_send_email_from_post_callback() {
	$post_id = $_POST['post_id'];
	$adproduct_options = get_option( 'adproduct_options' );
	$api_key = $adproduct_options['adproduct_unisender_api_key'];
	if($post_id) {
	
		$result = adproduct_unisender_creacte_email($post_id, $api_key);
		
	}
	
	
	echo 'ID письма = '.$result['message_id'].'<br/>';
	echo 'Статус рассылки = '.$result['campaign']['status'].'<br/>';
	echo 'ID запланированной рассылки = '.$result['campaign']['campaign_id'].'<br/>';
	echo 'Ошибки = '.$result['error'].'<br/>';
	exit; // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
}



/*	Создаем Email собщения
==================================================*/
function adproduct_unisender_creacte_email($post_id, $api_key) {
	
	$result_array = array();
	$mail_body = null;
	
		
		$mail_body = adproduct_get_mail_body($post_id);
		
		
		// Ваш ключ доступа к API (из Личного Кабинета)
		
		// Параметры создаваемого email-сообщения
		// Если скрипт в кодировке UTF-8, удалите вызовы iconv
		$email_from_name = "Женский шоппинг";
		$email_from_email = "info@shopingeconom.ru";
		$email_subject = $mail_body['title'];
		$email_to = "7638062"; // код списка, по которому делать рассылку
		$email_text = $mail_body['body'];
		$email_wrap = 'center';
		$email_categories = '';

		// Прикрепим простой текстовый файл:
	//	$email_attach_file_name = iconv('cp1251', 'utf-8', "текстовый файл.txt");
	//	$email_attach_file_content = iconv('cp1251', 'utf-8', "Содержимое файла");

		// Создаём POST-запрос
		$POST = array (
		 'api_key' => $api_key,
		 'sender_name' => $email_from_name,
		 'sender_email' => $email_from_email,
		 'subject' => $email_subject,
		 'list_id' => $email_to,
		 'wrap_type' => $email_wrap,
		 'categories' => $email_categories,
		 'body' => $email_text
		);

		// Устанавливаем соединение
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_URL, 
		 'https://api.unisender.com/ru/api/createEmailMessage?format=json');
		$result = curl_exec($ch);

		if ($result) {
		 // Раскодируем ответ API-сервера
			 $jsonObj = json_decode($result);

			 if(null===$jsonObj) {
				// Ошибка в полученном ответе
				$result_array['error'] = "Invalid JSON";

			 }
			 elseif(!empty($jsonObj->error)) {
				// Ошибка создания сообщения
				$result_array['error'] = "An error occured: " . $jsonObj->error . "(code: " . $jsonObj->code . ")";

			 } else {
				 $message_id = $jsonObj->result->message_id;
			 // Новое сообщение успешно создано
				update_post_meta($post_id, 'unisender_message_id', $message_id);
				$result_array['campaign'] = adproduct_unisender_send_email($message_id, $api_key);
				$result_array['message_id'] = $message_id;

			 }
		} else {
			// Ошибка соединения с API-сервером
			$result_array['error'] = "API access error";
		}
		
		
	return $result_array;
	
}

/*	Планируем рассылку из письма
==================================================*/
function adproduct_unisender_send_email($message_id, $api_key) {
	$result_campaign = array();
	// Ваш ключ доступа к API (из Личного Кабинета)
	$adproduct_options = get_option( 'adproduct_options' );
	$api_key = $adproduct_options['adproduct_unisender_api_key'];
	if($message_id) {
	// Параметры для отправки сообщения
	

		// Запланируем отправку на определённое время
		// (закомментируйте, чтобы отправить немедленно)
		 $email_starttime = "2016-10-12 14:40";

		// Параметры сбора статистики
		// Если 1, собираем, если 0 - нет
		$email_stats_links = "1";
		$email_stats_read = "1";

		// Создаём POST-запрос
		$POST = array (
		  'api_key' => $api_key,
		  'message_id' => $message_id,
		  'start_time' => $email_starttime,
		  'track_read' => $email_stats_read,
		  'track_links' => $email_stats_links,
		  'defer' => 1
		);

		// Устанавливаем соединение
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_URL,
					'http://api.unisender.com/ru/api/createCampaign?format=json');
		$result = curl_exec($ch);

		//echo $result;

		if ($result) {
		  // Раскодируем ответ API-сервера
		  $jsonObj = json_decode($result);

		  if(null===$jsonObj) {
			// Ошибка в полученном ответе
			$result_campaign['error'] = "Invalid JSON";
		  }
		  elseif(!empty($jsonObj->error)) {
			// Ошибка отправки сообщения
			$result_campaign['error'] = "An error occured: " . $jsonObj->error . "(code: " . $jsonObj->code . ")";

		  } else {
			// Рассылка успешно отправлена (или запланирована к отправке)
			$result_campaign['status'] = $jsonObj->result->status;
			$result_campaign['campaign_id'] = $jsonObj->result->campaign_id;
			update_post_meta($post_id, 'unisender_campaign_id', $result_campaign['campaign_id']);
		  }
		} else {
		  // Ошибка соединения с API-сервером
		  $result_campaign['error'] = "API access error";
		}
	}
	
	return $result_campaign;
}




/* Получаем списки контактов
================================================================*/
function adproduct_unisender_get_contacts_list() {
	// Ваш ключ доступа к API (из Личного Кабинета)
$adproduct_options = get_option( 'adproduct_options' );
	$api_key = $adproduct_options['adproduct_unisender_api_key'];

// Создаём POST-запрос
$POST = array (
  'api_key' => $api_key,
);

// Устанавливаем соединение
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $POST);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_URL, 'http://api.unisender.com/ru/api/getLists?format=json');
$result = curl_exec($ch);

if ($result) {
  // Раскодируем ответ API-сервера
  $jsonObj = json_decode($result);

  if(null===$jsonObj) {
    // Ошибка в полученном ответе
    echo "Invalid JSON";

  }
  elseif(!empty($jsonObj->error)) {
    // Ошибка получения перечня список
    echo "An error occured: " . $jsonObj->error . "(code: " . $jsonObj->code . ")";

  } else {
    // Выводим коды и названия всех имеющихся списков
    echo "Here's a list of your mailing lists:<br>";
    foreach ($jsonObj->result as $one) {
      echo "List #" . $one->id . " (" . $one->title . ")". "<br>";
    }

  }
} else {
  // Ошибка соединения с API-сервером
  echo "API access error";
}
	
}




/*	Формируем витрины в письме
================================================*/
add_filter('adproduct_vitrina_shortcode', 'adproduct_vitrina_shortcode_filter', 1);
/**
 * Фильтр заменяет шоткод [сaption] под стандарты HTML5
 *
 * @Возвращает HTML текст описывающий тег figure
 **/
function adproduct_vitrina_shortcode_filter($content){
	
	$content = str_replace( '[adproduct_vitrina_shortcode ', '[adproduct_vitrina_email_shortcode ', $content);
	
	
	$content = str_replace( '<img ', '<img style="max-width: 600px; height: auto;" ', $content);
	//$content = str_replace( '<h2 ', '<h2 style="color: #84c438" ', $content);
	//$content = str_replace( '<h3 ', '<h3 style="color: #84c438" ', $content);

	return $content;
}




/*	Шорткод для вывода витрины в Email письме (не применяется Ajax)
==============================================================*/
function adproduct_email_vitrins_function( $atts ) {
	//global $post;
	//var_dump($atts);
	$atts['id'];
$vitrina_id = $atts['id'];
	if($vitrina_id) {
		$return = email_vitrina_category_string($vitrina_id);
			
	} 
	
	return $return;
}
add_shortcode('adproduct_vitrina_email_shortcode', 'adproduct_email_vitrins_function');


/*	Выводим витрину в Email письме табличной версткой
==============================================================*/
function email_vitrina_category_string($vitrina_id) {
	if($vitrina_id) {
		$products = get_post_meta($vitrina_id, 'product', 1);
		$vitrina_shop_id = get_post_meta($vitrina_id, 'vitrina_shop_id', 1);
		$links = get_post_meta($vitrina_id, 'link', 1);
		$catalog_string = null;
		$link_string = null;
		if(1 < count($products)) {
			$catalog_string = adproduct_vitrina_email_from_json_decode($products);
			
		
		} else {
				$postdata = array(
					'api_key' => '',
					'action' => 'get_tiser',
					'tiser_id' => $vitrina_id
					
				);
				
				
				// Устанавливаем соединение
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				curl_setopt($ch, CURLOPT_URL, 'http://'.$adproduct_server_url.'/api');
				$result = curl_exec($ch);
					
				$products = json_decode($result);
				//var_dump($products);
				$catalog_string = adproduct_vitrina_email_from_json_decode($products);

		}	
		
		
		
	}
	
	
	
	return $catalog_string;
}



function adproduct_vitrina_email_from_json_decode($products) {
	global $adproduct_server_url;
	$return = '';
	$count_products = count($products);

	if(1 < $count_products) {
						$pr_count=-1; $pr_real_count=0;
						$return .= '<table border="0" cellpadding="0" cellspacing="0" class="">
                          <tbody><tr>';
						foreach($products as $product) { $pr_count++;
							if($pr_count !== 0) {
								
								$src = $product[0];
								if(empty($vitrina_shop_id)) { $shop_id = $product[3]; } else { $shop_id = $vitrina_shop_id; }
								if(!empty($product[2]) and !empty($src)) { 
									$pr_real_count++;
									$product_link = 'http://'.$adproduct_server_url.'/goto?shop_id='.$shop_id.'&vitrina_id='.$vitrina_id.'&pr_count='.$pr_real_count.'&link='.$product[2];
									
						
								$return .= ' <td align="center" style="width: 50%;">
                                <table border="0" cellpadding="0" cellspacing="10">
                                  <tbody>
                                    <tr>
                                      <td> <a href="'.$product_link.'" target="_blank"><img style="width: 280px; height: auto; " src="'.$src.'"></a> </td>
                                    </tr>
									 <tr>
                                      <td> <a style="text-align: center !important;" href="'.$product_link.'" target="_blank">'.$product[1].'</a> </td>
                                    </tr>
									
                                  </tbody>
                                </table>
                              </td>';
							
									if($pr_real_count % 2 == 0) { $return .= '</tr><tr>'; }
								}
								
							}
						}		
						$return .= '</tr></tbody></table>';
	
	} else {
		$return = 'Масив тизеров пуст';
	}
	
	return $return;
}



function adproduct_get_mail_body($post_id) {
	$mail_body = null;
	$this_post = get_post( $post_id );
		if ( has_post_thumbnail($post_id) ){
			$image_id = get_post_thumbnail_id( $post_id );
			$image_src = wp_get_attachment_image_src($image_id, 'full'); 
			//$mail_body .= '<img style="width: 100%; height auto;" src="'.$image_src[0].'" />';
			$image = '<img src="'.$image_src[0].'" width="580" height="auto" style="max-width: 100%; height: auto;" />';
		}
	$excerpt = get_the_excerpt($this_post);
	$url = get_permalink($post_id);
		 
		$content = apply_filters( 'adproduct_vitrina_shortcode', $this_post->post_content);
		$content = apply_filters( 'the_content', $content);
		
		
		$title = $this_post->post_title;
	
		$mail_body .= '<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>'.$title.'</title>
    <style>
      /* -------------------------------------
          GLOBAL RESETS
      ------------------------------------- */
      img {
        border: none;
        -ms-interpolation-mode: bicubic;
        max-width: 100%;
		height: auto;
		}
      body {
        background-color: #f6f6f6;
        font-family: sans-serif;
        -webkit-font-smoothing: antialiased;
        font-size: 16px;
        line-height: 150%;
        margin: 0;
        padding: 0; 
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%; }
      table {
        border-collapse: separate;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        width: 100%; }
        table td {
          font-family: sans-serif;
          font-size: 16px;
          vertical-align: top; }
      /* -------------------------------------
          BODY & CONTAINER
      ------------------------------------- */
      .body {
        background-color: #f6f6f6;
        width: 100%; }
      /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
      .container {
        display: block;
        Margin: 0 auto !important;
        /* makes it centered */
        max-width: 580px;
        padding: 10px;
        width: 580px; }
      /* This should also be a block element, so that it will fill 100% of the .container */
      .content {
        box-sizing: border-box;
        display: block;
        Margin: 0 auto;
        max-width: 580px;
        padding: 10px; }
      /* -------------------------------------
          HEADER, FOOTER, MAIN
      ------------------------------------- */
      .main {
        background: #fff;
        border-radius: 3px;
        width: 100%; }
      .wrapper {
        box-sizing: border-box;
        padding: 20px; }
      .footer {
        clear: both;
        padding-top: 10px;
        text-align: center;
        width: 100%; }
        .footer td,
        .footer p,
        .footer span,
        .footer a {
          color: #999999;
          font-size: 12px;
          text-align: center; }
      /* -------------------------------------
          TYPOGRAPHY
      ------------------------------------- */
      h1,
      h2,
      h3,
      h4 {
        color: #000000;
        font-family: sans-serif;
        font-weight: 400;
        line-height: 1.4;
        margin: 0;
        Margin-bottom: 30px; }
      h1 {
        font-size: 35px;
        font-weight: 300;
        text-align: center;
       }
	   
	   h2 {
		  font-size: 24px;
	   }
	   
	   h3 {
		  font-size: 18px;
	   }
      p,
      ul,
      ol {
        font-family: sans-serif;
        font-size: 14px;
        font-weight: normal;
        margin: 5px 0;
        Margin-bottom: 15px; }
        p li,
        ul li,
        ol li {
          list-style-position: inside;
          margin-left: 5px; }
      a {
        color: #3498db;
        text-decoration: underline; }
      /* -------------------------------------
          BUTTONS
      ------------------------------------- */
      .btn {
        box-sizing: border-box;
        width: 100%; }
        .btn > tbody > tr > td {
          padding-bottom: 15px; }
        .btn table {
          width: auto;
		  }
        .btn table td {
          background-color: #ffffff;
          border-radius: 5px;
          text-align: center; }
        .btn a {
          background-color: #ffffff;
          border: solid 1px #3498db;
          border-radius: 5px;
          box-sizing: border-box;
          color: #3498db;
          cursor: pointer;
          display: inline-block;
          font-size: 14px;
          font-weight: bold;
          margin: 0;
          padding: 12px 25px;
          text-decoration: none;
        }
      .btn-primary table td {
        background-color: #3498db; }
      .btn-primary a {
        background-color: #3498db;
        border-color: #3498db;
        color: #ffffff; }
      /* -------------------------------------
          OTHER STYLES THAT MIGHT BE USEFUL
      ------------------------------------- */
      .last {
        margin-bottom: 0; }
      .first {
        margin-top: 0; }
      .align-center {
        text-align: center; }
      .align-right {
        text-align: right; }
      .align-left {
        text-align: left; }
      .clear {
        clear: both; }
      .mt0 {
        margin-top: 0; }
      .mb0 {
        margin-bottom: 0; }
      .preheader {
        color: transparent;
        display: none;
        height: 0;
        max-height: 0;
        max-width: 0;
        opacity: 0;
        overflow: hidden;
        mso-hide: all;
        visibility: hidden;
        width: 0; }
      .powered-by a {
        text-decoration: none; }
      hr {
        border: 0;
        border-bottom: 1px solid #f6f6f6;
        Margin: 20px 0; }
      /* -------------------------------------
          RESPONSIVE AND MOBILE FRIENDLY STYLES
      ------------------------------------- */
      @media only screen and (max-width: 620px) {
	
        table[class=body] h1 {
          font-size: 28px !important;
          margin-bottom: 10px !important; }
        table[class=body] p,
        table[class=body] ul,
        table[class=body] ol,
        table[class=body] td,
        table[class=body] span,
        table[class=body] a {
          font-size: 16px !important; }
        table[class=body] .wrapper,
        table[class=body] .article {
          padding: 10px !important; }
        table[class=body] .content {
          padding: 0 !important; }
        table[class=body] .container {
          padding: 0 !important;
          width: 100% !important; }
        table[class=body] .main {
          border-left-width: 0 !important;
          border-radius: 0 !important;
          border-right-width: 0 !important; }
        table[class=body] .btn table {
          width: 100% !important; }
        table[class=body] .btn a {
          width: 100% !important; }
        table[class=body] .img-responsive {
          height: auto !important;
          max-width: 100% !important;
          width: auto !important; }}
      /* -------------------------------------
          PRESERVE THESE STYLES IN THE HEAD
      ------------------------------------- */
      @media all {
        .ExternalClass {
          width: 100%; }
        .ExternalClass,
        .ExternalClass p,
        .ExternalClass span,
        .ExternalClass font,
        .ExternalClass td,
        .ExternalClass div {
          line-height: 100%; }
        .apple-link a {
          color: inherit !important;
          font-family: inherit !important;
          font-size: inherit !important;
          font-weight: inherit !important;
          line-height: inherit !important;
          text-decoration: none !important; } 
        .btn-primary table td:hover {
          background-color: #34495e !important; }
        .btn-primary a:hover {
          background-color: #34495e !important;
          border-color: #34495e !important; } }
    </style>
  </head>
  <body class="">
    <table border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">

            <!-- START CENTERED WHITE CONTAINER -->
            
            <table class="main">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper">
                  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td class="content-block">
						'.$image.'<br />
						 <h1 style="text-align: left;">'.$title.'</h1>						
						'.$content.'
                       
						
						
					
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

              <!-- END MAIN CONTENT AREA -->
              </table>

            <!-- START FOOTER -->
            <div class="footer">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="content-block">
                    
                    <br> <a href="{{UnsubscribeUrl}}">Отписаться от рассылки</a> | <a href="{{WebLetterUrl}}">Смотреть в браузере</a>.
                  </td>
                </tr>
               
              </table>
            </div>

            <!-- END FOOTER -->
            
<!-- END CENTERED WHITE CONTAINER --></div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </body>
</html>
';

$return = array(
	'body' => $mail_body,
	'title' => $title
);

return $return;
}



 ?>