<?php

/*  Класс для взаимодействия с API AdProduct
    Позже перенесем в отдельный файл
*/
class adproduct_shop_api {
    protected $api_key;
    protected $token_api;
    protected $server_uri;


    // Отправляем запрос к API сервера
    public static function query($post_data){

        $adproduct_options = get_option( 'adproduct_options' );

        $api_key = $adproduct_options['adproduct_api_key'];
        $server_uri = $adproduct_options['adproduct_server'];

        /*
         * api_key
         * action
         * data = array($data)
         *
         * */
        $post_data['api_key'] = $api_key;

        $json_encode = json_encode($post_data, JSON_UNESCAPED_UNICODE);

        // Устанавливаем соединение
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($json_encode)));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_encode);

        curl_setopt($ch, CURLOPT_URL, 'http://'.$server_uri.'/api');
        $result = curl_exec($ch);

        return $result;
    }
}


/*  Класс для работы с письмом
*/
class adproduct_shop_letter {

    // Создаем письмо из поста
    function create($post_id){
        $mail_body = null;
        $this_post = get_post( $post_id );

        $html = $this_post->post_content;
      //  $html = str_replace('/n', '', $html);
     //   $html = apply_filters( 'the_content', $html);//addslashes($this_post->post_content);// //$this_post->post_content; //
       // $html = htmlentities($html);
        $title = addslashes($this_post->post_title);

        $return = array(
            'name' => $title,
            'body' => $html
        );

        return $return;
    }

}

/*  Класс для работы с функциями рассылок
*/
class adproduct_shop_mailing {
    protected $api_key;
    protected $token_api;
    protected $server_uri;

    /*	Создаем Email собщение
    ==================================================*/
    function creacte_email($post_id) {

        $letter = new adproduct_shop_letter();
        $letter = $letter->create($post_id);
      //  $letter = $letter;
       // remove_filter( 'the_content', 'wpautop' );
       // $letter['body'] = apply_filters( 'adproduct_vitrina_shortcode', $letter['body']);
       // $letter['body'] = apply_filters( 'the_content', $letter['body']); // wpautop( $letter['body'], 1); ////
        $letter['body'] = htmlentities($letter['body']);
        $letter['body'] = str_replace("\r\n","",$letter['body']);

        $api = new adproduct_shop_api();
        // Создаём POST-запрос
        $post_data = array (
            'action' => 'letter-save',
            'data' => $letter,
            'api_key' => ''
        );
        $result = $api->query($post_data);
       // var_dump($post_data);
        $result = json_decode($result);
        $result = (array)$result;

        if (!empty($result['result']) and $result['result'] !== false) { // Запрос выполнен успешно
            $message_id = $result['response'];
            if($message_id) {
                update_post_meta($post_id, 'adproduct_letter_id', $message_id);
            }

            // Новое сообщение успешно создано
            $return = $result;
        } else {    // Запрос выполнен с ошибкой

            $return = $result;
        }

        return $return;

    }


    /*	Создаем Email подписчика
    ==================================================*/
    function add_email_user($form_data) {

    	//  Если заполнено поле Name, что деляют только роботы, то отправляем ошибку
        if(!empty($form_data['name'])) {
            $return = array(
                'result'        =>  false,
                'error_code'    =>  'shop_mailing-create_email_user-10',
                'message'       =>  'Возникла непредвиденная ошибка. Сообщите администратору!'
            );
        }
        elseif(empty($form_data['email'])){
	        $return = array(
		        'result'        =>  false,
		        'error_code'    =>  'shop_mailing-create_email_user-10',
		        'message'       =>  'Проверьте корректность Email адреса'
	        );
        } else {
	        $url = '';
        	if(!empty($form_data['url'])) {
		        $url = $form_data['url'];
	        }

            $email_arr = array(
                   'email'     =>  $form_data['email'],
                   'url'       =>  $url,
                   'list_id'   =>  $form_data['list_id'],
                   'meta'      =>  $form_data['meta']
            );


            $api = new adproduct_shop_api();
            // Создаём POST-запрос
            $post_data = array (
                'action' => 'email-add',
                'data' => $email_arr,
                'api_key' => ''
            );
            $result = $api->query($post_data);
            // var_dump($post_data);
            $result = json_decode($result);
            $result = (array)$result;

            if (!empty($result['result']) and $result['result'] !== false) { // Запрос выполнен успешно
                //$message_id = $result['response'];

                // Новый подписчик успешно добавлен
                $return = $result;
            } else {    // Запрос выполнен с ошибкой

                $return = $result;
            }

        }

        return $return;

    }


    /* Получаем списки контактов
    ================================================================*/
    function get_lists() {
        $api = new adproduct_shop_api();

        // Создаём POST-запрос
        $post_data = array (
            'action' => 'get_lists',
        );

        $result = $api->query($post_data);

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

            }
            // Получили списки. Формируем результат
            else {
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


}


class adproduct_shop_email {


    /*	Отправляем Email подписчика
   ==================================================*/
    function send($post_id) {

        $letter = new adproduct_shop_letter();
        $letter = $letter->create($post_id);
        //  $letter = $letter;
        // remove_filter( 'the_content', 'wpautop' );
        // $letter['body'] = apply_filters( 'adproduct_vitrina_shortcode', $letter['body']);
        // $letter['body'] = apply_filters( 'the_content', $letter['body']); // wpautop( $letter['body'], 1); ////
        $letter['body'] = htmlentities($letter['body']);
        //$letter['body'] = str_replace("\n","",$letter['body']);

        $api = new adproduct_shop_api();
        // Создаём POST-запрос
        $post_data = array (
            'action' => 'letter_save',
            'data' => $letter,
            'api_key' => ''
        );
        $result = $api->query($post_data);
        // var_dump($post_data);
        $result = json_decode($result);
        $result = (array)$result;

        if (!empty($result['result']) and $result['result'] !== false) { // Запрос выполнен успешно
            $message_id = $result['response'];
            if($message_id) {
                update_post_meta($post_id, 'adproduct_letter_id', $message_id);
            }

            // Новое сообщение успешно создано
            $return = $result;
        } else {    // Запрос выполнен с ошибкой

            $return = $result;
        }

        return $return;

    }
}


/*	Получаем параметры из Ajax формы
========================================*/
function adproduct_get_formdata($formdata){
    if(!empty($formdata))	{
        $form_data = array(); $params_arr = array();
        $form_data = explode('&', $formdata);

        foreach($form_data as $data) {
            $param = explode('=', $data);
            $key = urldecode($param[0]);

            if($key == 'tiser[]') {
                $params_arr['tisers'][] = urldecode($param[1]);
            } else {
                $strpos = strpos($key, '[');

                if($strpos === false) {
                    $params_arr[$key] = urldecode($param[1]);
                } else {
                    $key_subvalue = substr($key, $strpos+1, -1);
                    $newkey = str_replace("[".$key_subvalue."]", "", $key);
                    //var_dump($key_subvalue);
                    $params_arr[$newkey][$key_subvalue] = urldecode($param[1]);

                }
            }
        }
    }
    return $params_arr;
}


/*	Обрабатываем Ajax-формы AdProduct
======================================================*/
add_action('wp_ajax_adproduct_ajax_form', 'adproduct_ajax_form_callback');
add_action('wp_ajax_nopriv_adproduct_ajax_form', 'adproduct_ajax_form_callback');
function adproduct_ajax_form_callback(){
   // $current_user_id = get_current_user_id();
    $form_data = adproduct_get_formdata($_POST['form_data']);
    if (empty($form_data['action'])) {
        $return = array(
            'result'    => false,
            'message'   => 'Ошибка! Форма неверно заполнена',
            'error_coe' =>  'adproduct_ajax_form_callback-10'
        );
    } else {
        $action = explode('-', $form_data['action']);
        $class_name = 'adproduct_shop_'.$action[0];
        $method_name = $action[1];
        $class = new $class_name();
        $return = $class->$method_name($form_data);
		var_dump($return);
    }

    //echo json_encode($return, JSON_UNESCAPED_UNICODE);
    exit;
}


add_action('wp_ajax_adproduct_send_email_from_post', 'adproduct_send_email_from_post_callback');
add_action('wp_ajax_nopriv_adproduct_send_email_from_post', 'adproduct_send_email_from_post_callback');
function adproduct_send_email_from_post_callback() {
	$post_id = $_POST['post_id'];


	if($post_id) {
        $mailing = new adproduct_shop_mailing();
        $creacte_email = $mailing->creacte_email($post_id);

		$result = json_encode($creacte_email, JSON_UNESCAPED_UNICODE);

	} else {
        $result = 'false';
    }

    echo '<br/>';
    echo 'Ответ Ajax функции';
    //var_dump($result);
    echo '<br/>';
    $json = $result;
     $result = json_decode($result);
    $result = (array)$result;


	echo 'Статус рассылки = '.$result['result'].'<br/>';
	echo 'Сообщение = '.$result['message'].'<br/>';
    echo 'ID письма = '.$result['response'].'<br/>';
    echo '$json = '.$json.'<br/>';
	exit; // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
}


add_action('wp_ajax_adproduct_test_api', 'adproduct_test_api_callback');
add_action('wp_ajax_nopriv_adproduct_test_api', 'adproduct_test_api_callback');
function adproduct_test_api_callback() {
    // Создаём POST-запрос
    $post_data = array (
        'action' => 'api_test'
    );
    $api = new adproduct_shop_api();
    $result = $api->query($post_data);



	//echo 'ID письма = '.$result['message_id'].'<br/>';
	//echo 'Статус рассылки = '.$result['campaign']['status'].'<br/>';
	//echo 'ID запланированной рассылки = '.$result['campaign']['campaign_id'].'<br/>';
//	echo 'Ошибки = '.$result['error'].'<br/>';
    echo 'Результат = '.$result;
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
	
	
	//$content = str_replace( '<img ', '<img style="max-width: 600px; height: auto;" ', $content);
	//$content = str_replace( '<h2 ', '<h2 style="color: #84c438" ', $content);
	//$content = str_replace( '<h3 ', '<h3 style="color: #84c438" ', $content);

	return $content;
}






 ?>