
	</div>
</div><!-- #wrapper -->

<footer id="footer" role="contentinfo">

	<div class="container">
	
	<?php if ( ! dynamic_sidebar( 'primary-footer-widget' ) ) : ?>
	<?php endif; ?>
	
	</div>
	
	
	
	<!--p style="float: right; width: 48%; text-align: right; color: #888;"><a href="/sitemap.html">Карта сайта</a></p-->
	<p class="copyright">© 2012—<?php echo date("Y"); ?></p>
	<div id="scroller"><span>Наверх</span></div>
</footer><!-- #footer -->

<?php  wp_footer(); ?>


<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>


<!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter22319980 = new Ya.Metrika({ id:22319980, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/22319980" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->


<script type="text/javascript">jQuery(document).ready(function($){
$(window).scroll(function () {if ($(this).scrollTop() > 0) {$('#scroller').fadeIn();} else {$('#scroller').fadeOut();}});
$('#scroller').click(function () {$('body,html').animate({scrollTop: 0}, 400); return false;});
});</script>

<script type="text/javascript" src="<?php bloginfo('template_url');?>/js/tabs.js"></script>


<script type="text/javascript">
VK.Widgets.Group("vk_groups_640", {mode: 0, width: "auto", height: "340"}, 58301083);
</script>
<script type="text/javascript">
VK.Widgets.Group("vk_groups_240", {mode: 0, width: "auto", height: "320"}, 58301083);
</script>

<script type="text/javascript">
VK.Widgets.Poll("vk_poll", {width: 300}, "231383332_eb988b8eb395659366");
</script>

<script type="text/javascript">(function( window, undefined ){ e = document.createElement('script');e.src = '//daitovar.ru/js/wlbc.js';document.getElementById('wlbc_1427151015').appendChild(e); })(window);</script>
	<script type="text/javascript" src="<?php bloginfo('template_url');?>/js/jquery.scrollTo.js" charset="utf-8"></script>


<script type="text/javascript">
jQuery(document).ready(function($) {


	var link = $('[data-href]');
	$(link).addClass("link");
	$('body').on('click', '.link', function(){window.open($(this).data('href'));return false;});


	$('.nav_link').click(function() { $.scrollTo($(this).data('ancor'),{duration: 250, offset: { 'left':0, 'top':-0.10*$(window).height() }});});

		});
		</script>


<script type="text/javascript">
	VK.Widgets.Group("old_shopogolik", {mode: 1, width: "220", height: "400", color1: 'FFFFFF', color2: '2B587A', color3: '5B7FA6'}, -247083741);
	</script>
	
	<script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
<script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>

</body>

</html>