<script type="text/javascript">
function dl_robots_js_function( v ) {
	var robots = "Allow: /wp-content/uploads/ Disallow: /wp-login.php Disallow: /wp-register.php Disallow: /xmlrpc.php Disallow: /template.html Disallow: /wp-content/ Disallow: /tag/ Disallow: /category/ Disallow: /archive/ Disallow: */trackback/ Disallow: */feed/ Disallow: */comments/ Disallow: /?feed= Disallow: /?s=";

	document.getElementById(v).value = robots.replace(/(Allow|Disallow): ?(\S+) /g, "$1: $2\n");
}
</script>

<div class="wrap">

	<?php settings_errors(); ?>	

	<h2>DL Robots.txt</h2>

	<p class="description" >
		
		Все поисковые роботы при заходе на сайт в первую очередь ищут файл robots.txt. Если вы – вебмастер, вы должны знать назначение и синтаксис robots.txt
	
	</p>
	
	<p class="description" >
	
		Просмотр вашего файла <b><a href="<?php bloginfo('url'); ?>/robots.txt" target="_blank" >Robots.txt</a></b>
		
	</p>

	<?php if(get_option('blog_public') == '0') echo '<h2 style="color: #E14D43">Поисковые системы не индексируют сайт</h2>'; ?>


	<?php if ( file_exists( ABSPATH . 'robots.txt' ) ) { ?>
		<div style="color: #E14D43; font-weight:bold;">
			<p>В директории вашего сайта находится реальный файл robots.txt! Это неправильная ситуация, т.к. robots.txt должен формироваться динамически с помощью WordPress.</p>
			<p>Для нормальной работы этого плагина, вам нужно:</p>

			<ol>
				<li>скопировать настройки из реального файла в текстовое поле данного плагина</li>
				<li>сохранить изменения в настройках плагина нажав соответствующую кнопку внизу этой страницы</li>
				<li>потом удалить реальный файл</li>
			</ol>
		</div>
	<?php } else { ?>
		<h4 style="color: #27C544">Файл robots.txt формируется динамически с помощью WordPress</h4>
	<?php } ?>


	<form method="post" action="options.php">

		<?php settings_fields( 'dl-robots-settings' ); ?>
		
		<div style="float: left; width: 35%;" >
			
			<p>
				<textarea 
					name="dl_robots_option" 
					id="dl_robots_text" 
					class="large-text code" 
					type="textarea" 
					rows="24" 
				><?php echo get_option('dl_robots_option'); ?></textarea>
			</p>
			<p>
				<b>Попросить поисковые системы не индексировать сайт</b>
				<input 
					name="blog_public" 
					type="checkbox" 
					id="blog_public" 
					value="0" 
					<? checked( '0', get_option( 'blog_public' ) ); ?>
				/>
			</p>
			
			<p>
			
				Вы можите задать <a href="#" onclick="dl_robots_js_function('dl_robots_text'); return false;" >задать оптимальные настройки</a> для файла robots.txt для поисковых машин Yandex и Google. <br /><b color="red">(все значения в поле будут перезаписаны)</b>
			
		</div>

		<div style="float: right; width: 64%;">

			<p style="text-align: justify;">
				<b>Что такое файл robots.txt</b> – это текстовый файл, находящийся в корневой директории сайта, в котором записываются специальные инструкции для поисковых роботов. Эти инструкции могут запрещать к индексации некоторые разделы или страницы на сайте, указывать на правильное «зеркалирование» домена, рекомендовать поисковому роботу соблюдать определенный временной интервал между скачиванием документов с сервера и т.д.
			</p>
			
			<hr />
			
			<p>
				<iframe 
					width="640" 
					height="360" 
					frameborder="1" 
					src="http://video.yandex.ru/iframe/yacinema/xk28r9luk9.2518/?player-type=custom&amp;show-info=false&amp;show-logo=false&amp;hd=1">
				</iframe>
			</p>
		
		</div>
		
		<div style="clear: both">
			
			<input 
				type="submit" 
				class="button-primary" 
				value="<?php _e('Save Changes') ?>" 
			/>
			
		</div>
		
	</form>

</div>