var $j = jQuery.noConflict();

$j(document).ready(function() {

$j('ul.tabs.tabs1 li').live('click', function(){
	var thisClass = this.className.slice(0,2);
	$j('div.t1').hide();
	$j('div.t2').hide();
	$j('div.t3').hide();
	$j('div.t4').hide();
	$j('div.' + thisClass).show();
	$j('ul.tabs.tabs1 li').removeClass('tab-current');
	$j(this).addClass('tab-current');
	});

});