<?
$taxonomyName = 'product_cat';  
$terms = get_terms($taxonomyName );  
$images = get_option('taxonomy_image_plugin'); 
$catalog_categoryes = array();
  
foreach ($terms as $term) { 
	$termID = $term->term_taxonomy_id;
	$term_id = $term->term_id;
	$term_children = get_terms( $taxonomyName, array('parent' => $term_id,'hide_empty' => true  ) );
		
		$term_link = get_term_link((int)$term_id, $taxonomyName ); 
		$term_image = wp_get_attachment_image( $images[$termID],'' );
		$term_litle_name = get_option('product_cat_'.$term_id.'_litle_name_category');
		$term_number = get_option('product_cat_'.$term_id.'_number_of_catalog');
		
		if($term_litle_name) { $catalog_category_name = $term_litle_name;} else { $catalog_category_name = $term->name;}
		
			if($term_children) {
			
				$catalog_categoryes[] = array(
					'name' => $catalog_category_name,
					'link' => $term_link,
					'image' => $term_image,
					'number' => $term_number
				);
		
			}	 
}  


if($catalog_categoryes) {
	function sort_menu($a, $b)
	{
	return strnatcmp($a["number"], $b["number"]);
	}

	usort($catalog_categoryes, "sort_menu");
	
	$catalog .= '<ul class="under-menu">';
	$count =0;
	foreach ($catalog_categoryes as $catalog_category) {
		$count++; if($count == 2) { $class = 'second';} if($count == 1) { $class = 'first';} if($count == 3) { $class = 'last';}
		
		$catalog .= '<li><a href="'.$catalog_category['link'].'">'.$catalog_category['name'].'</a></li>';
		if($count == 4) {$count =1;} 
	}
	$catalog .= '</ul>';
	
	if($catalog) { echo $catalog; } 
} ?>