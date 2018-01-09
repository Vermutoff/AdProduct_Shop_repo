<?php
class ControlPanel {

// Устанавливаем значения по умолчанию 

	var $default_settings = array(

	);
	var $options;
	
	function ControlPanel() {
    	add_action('admin_menu', array(&$this, 'add_menu'));
		if (!is_array(get_option('themadmin')))
		add_option('themadmin', $this->default_settings);
		$this->options = get_option('themadmin');
	}
	
	function add_menu() {
		add_theme_page('WP Theme Options', 'Опции темы', 8, "themadmin", array(&$this, 'optionsmenu'));
	}
	
	// Сохраняем значения формы с настройками 
	function optionsmenu() {
		if ($_POST['ss_action'] == 'save') {
				
		// Тексты для главной
			$this->options["gdeslon_shops"] = $_POST['cp_gdeslon_shops'];
							
			update_option('themadmin', $this->options);
			echo '<div class="updated fade" id="message" style="background-color: rgb(255, 251, 204); width: 400px; margin-left: 17px; margin-top: 17px;"><p>Ваши изменения <strong>сохранены</strong>.</p></div>';
		}
	// Создаем форму для настроек
		echo '<form action="" method="post" class="themeform">';
		echo '<input type="hidden" id="ss_action" name="ss_action" value="save">';
		
		print '<div class="cptab"><br />
		<b>Настройки темы</b>
				
		<h3>Тексты в шаблоны</h3>
		
		<label>Ссылка на XML всех рекламодателей в Где слон</label>
		<p><input type="text" name="cp_gdeslon_shops" id="cp_gdeslon_shops" value="'.stripslashes($this->options["gdeslon_shops"]).'" style="width: 500px;" /></p>
		
		<button id="update_shops_logo">Обновить логотипы</button>
		
		</div><br />';
		echo '<input type="submit" value="Сохранить" name="cp_save" class="dochanges" />';
		echo '</form>';
	}
}
$cpanel = new ControlPanel();
$mytheme = get_option('themadmin');
?>