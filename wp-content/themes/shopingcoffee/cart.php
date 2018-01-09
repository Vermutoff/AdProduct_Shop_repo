<?php
// Template name: Список покупок
session_start();

if($_POST['articul']) {
		if(empty($_SESSION['cart'][$_POST['articul']])) {
			$_SESSION['cart'][$_POST['articul']] = $_POST['articul'];	
			$_SESSION['name'][$_POST['articul']] = $_POST['name'];	
			$_SESSION['price'][$_POST['articul']] = $_POST['price'];
			$_SESSION['img'][$_POST['articul']] = $_POST['img'];
			$_SESSION['parent'][$_POST['articul']] = $_POST['parent'];
			$_SESSION['link'][$_POST['articul']] = $_POST['link'];
			//$a = is_array($_SESSION['cart']) ? $_SESSION['cart'] : array();
		}
}
	
if(isset($_POST['delete_product'])) {

	
		unset($_SESSION['cart'][$_POST['delete_product']]);
		unset($_SESSION['name'][$_POST['delete_product']]);
		unset($_SESSION['price'][$_POST['delete_product']]);
		unset($_SESSION['img'][$_POST['img']]);
		unset($_SESSION['parent'][$_POST['parent']]);
		unset($_SESSION['link'][$_POST['link']]);
	
	
	
	if(empty($_SESSION['cart'])) { unset($_SESSION['cart']); }
	
}
	
?>


<h2>Ваш список покупок</h2>
<?php
   if ($_SESSION['cart']) {
	
		$cart = '';
		foreach ($_SESSION['cart'] as $articul => $qty) {
  	
			$cart .= '<div id="product_card-'.$_SESSION['cart'][$articul].'" class="list_card block">';
			$cart .= '<span class="thumb"><noindex><span class="link" rel="nofollow" target="_blank" data-href="/product.html?parent='.$_SESSION['parent'][$articul].'&product_id='.$_SESSION['cart'][$articul].'"><img id="'.$_SESSION['cart'][$articul].'" class="product_more" alt="Купить '.$_SESSION['name'][$articul].' за '.$_SESSION['price'][$articul].' рублей" src="';
			//$cart .= '<span class="thumb"><noindex><a rel="nofollow" target="_blank" href="/link.php?to='.$product_this['link'].'?sub_id=shopingeconom_product"><img id="'.$product_this['id'].'" class="product_more" alt="Купить '.$product_this['name'].' за '.$product_this['price'].' рублей" src="';
			if($_SESSION['img'][$articul]) { $cart .= $_SESSION['img'][$articul]; } else { $cart .= '/wp-content/themes/promocode/images/noimage_product.png';}
			$cart .= '"></span></noindex></span>';
			$cart .= '<span class="product_title">'.$_SESSION['name'][$articul].'</span>';
			$cart .= '<span class="product_price">'.$_SESSION['price'][$articul].' руб.</span>';
			$cart .= '<span class="product_button blue link" data-href="'.$_SESSION['link'][$articul].'?sub_id=SE_cart_button">Купить в магазине »</span><span data-delete_product="'.$_SESSION['cart'][$articul].'" class="delete_product grey">X</span>';
			$cart .= '</div>';
        }
		
		$cart .= '<a class="grey" id="todestroy" href="javascript://">Очистить список</a>';
	} else { $cart = ''; }
	
	if($cart) {
		echo $cart;
	} else {
		echo 'Ваш список покупок пуст';
	}
	
	
	
	//var_dump($_SESSION['link']);
?>

