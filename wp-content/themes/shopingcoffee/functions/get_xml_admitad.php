<?php

$url = 'http://export.admitad.com/ru/webmaster/websites/105799/coupons/export/?code=91145552c1&user=Vermutoff&format=xml&v=1';

$file    = "/files/api_response_example.xml";
define('BASEPATH', str_replace('\\', '/', dirname(__FILE__)) . '/'); # путь до каталога с исполняемым файлом
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url); # файл, который надо получить с удаленного сервера
curl_setopt($ch, CURLOPT_TIMEOUT, 300);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$st = curl_exec($ch);
$fd = @fopen(BASEPATH . '/xmls/cupons.xml', "w"); # название файла на этом сервере
fwrite($fd, $st);
@fclose($fd);
echo 'XML выгрузка получена и загружена на сайт';
curl_close($ch);

?>