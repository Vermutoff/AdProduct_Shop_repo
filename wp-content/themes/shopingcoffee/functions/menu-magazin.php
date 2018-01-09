<?
$taxonomyName = 'category';  
$terms = get_terms($taxonomyName );  
//$images = get_option('taxonomy_image_plugin'); 
$magazin_categoryes = array();
  
foreach ($terms as $term) { 
	$termID = $term->term_taxonomy_id;
	$term_id = $term->term_id;
		
		$term_link = get_term_link((int)$term_id, $taxonomyName ); 
		$term_image = wp_get_attachment_image( $images[$termID],'' );
		$term_litle_name = get_option('category_'.$term_id.'_litle_name_category');
		$term_number = get_option('category_'.$term_id.'_number_of_catalog');
		
		if($term_litle_name) { $catalog_category_name = $term_litle_name;} else { $catalog_category_name = $term->name;}
		
			
			
				$magazin_categoryes[] = array(
					'name' => $catalog_category_name,
					'link' => $term_link,
					'image' => $term_image,
					'number' => $term_number
				);
		
			 
}  

if($magazin_categoryes) {
	function sort_menu($a, $b)
	{
	return strnatcmp($a["number"], $b["number"]);
	}

	usort($catalog_categoryes, "sort_menu");
	
	$magazin .= '<ul class="under-menu">';
	$count =0;
	foreach ($magazin_categoryes as $magazin_category) {
		
		
		$magazin .= '<li><a href="'.$magazin_category['link'].'">'.$magazin_category['name'].'</a></li>';
		
	}
	$magazin .= '</ul>';
	
	if($magazin) { echo $magazin; } 
}  ?>