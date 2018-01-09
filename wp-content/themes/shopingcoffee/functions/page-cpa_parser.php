<?php // Template name: Парсим XML файлы

  $elements   = null;  // просто имя текущей ноды
  $offer = null; // собирает один элемент offer

  // Вызывается, когда встречается открывающий тег.
  // если это offer - создаем массив под него
  function startElements($parser, $name, $attrs)  
  {
      global $offer, $elements;
      if ($name == 'OFFER') {
        $offer = array();
      }
      $elements = $name;
  }

  // Вызывается, когда тег закрывается
  // если это тег offer - печатаем содержимое и вычищаем
  function endElements($parser, $name) 
  {
      global $offer, $elements;
      if(!empty($name)) {
          if ($name == 'OFFER') {
        echo '<h1>'.$offer['NAME'].'</h1>';
        echo $offer['PRICE'];
		echo '<img src="'.$offer['THUMBNAIL'].'" />';

		echo '<a href="'.$offer['URL'].'">Купить</a>';
        $offer = null;
          }
    $elements = null;
      }
  }

  // Вызывается для текста, заполняем массив
  function characterData($parser, $data) 
  {
      global $offer, $elements;
      if(!empty($data)) {
          if ($elements == 'NAME' || $elements == 'PRICE' || $elements == 'THUMBNAIL' || $elements == 'URL') {
            $offer[$elements] = trim($data);
          }
      }
  }

  // Собственно, подготавливаем парсер
  $parser = xml_parser_create();

  xml_set_element_handler($parser, "startElements", "endElements");
  xml_set_character_data_handler($parser, "characterData");

  // открываем файл
   if (!($handle = fopen('http://shopingeconom.ru/wp-content/themes/promocode/functions/gde_slon_vitrina/xml_files/159.xml', "r"))) {
       die("could not open XML input");
   }

   while($data = fread($handle, 4096)) // читаем по кусочкам
   {
    xml_parse($parser, $data);  // и стравливаем парсеру
   }

   xml_parser_free($parser); // почистим за собой.

?>