<form class="searchform" id="search_product" action="http://shopingeconom.ru/product_search.html/" method="get">
					<?
						if($_GET['name_product']) { $xml_request = $_GET['name_product']; }
						if($_GET['page_number']) { $page_number = $_GET['page_number']; } else { $page_number = 1;}
					
					?>
					<input type="text" placeholder="Поиск товаров" name="name_product" id="name_product" value="<? echo $xml_request; ?>">
					<!--input type="hidden" name="page_number" id="page_number" value="1"-->
					<input type="submit" id="submit_query" value="Найти">
				</form>