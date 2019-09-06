<?php
defined('BBF') or die();

class Falbar_BBF extends Falbar_BBF_Core{

	public function __construct($params = array()){

		if($params){

			$this->main_file_name = $params['main_file_name'];
			$this->prefix_db 	  = $params['prefix_db'];

			$this->main_file_path = dirname(dirname(__FILE__)).BBF_DS.$this->main_file_name;
			$this->options 		  = get_option($this->prefix_db.'_options_params');
		}

		return false;
	}

	public function run(){

		register_activation_hook(
			$this->main_file_path,
			array(
				$this,
				'activate'
			)
		);

		register_deactivation_hook(
			$this->main_file_path,
			array(
				$this,
				'deactivate'
			)
		);

		add_action(
			'admin_init',
			array(
				$this,
				'register_params'
			)
		);

		add_action(
			'plugins_loaded',
			array(
				$this,
				'load_plugin_localization'
			)
		);

		add_action(
			'admin_menu',
			array(
				$this,
				'add_admin_menu'
			)
		);

		add_action(
			'admin_enqueue_scripts',
			array(
				$this,
				'add_admin_scripts'
			)
		);

		add_action(
			'admin_notices',
			array(
				$this,
				'add_admin_notices'
			)
		);

		$this->generate_default_params();

		$this->setup_params();

		return false;
	}

	public function activate(){

		return false;
	}

	public function deactivate(){

		return false;
	}

	public function register_params(){

		register_setting(
			$this->prefix_db.'_options',
			$this->prefix_db.'_options_params',
			array(
				$this,
				'validate_sanitize_options'
			)
		);

		return false;
	}

	public function validate_sanitize_options($options){

		$clean_options = array();

		if(!empty($options)){

			foreach($options as $key=> $value){

				foreach($value as $k => $v){

					if($k == 'comment_text_convert_links_pseudo'){

						$clean_options[$key][$k] = array(
							'enable' => (int) $v['enable'],
							'style'  => htmlspecialchars(trim($v['style']), ENT_QUOTES)
						);
					}else if($k == 'pseudo_comment_author_link'){

						$clean_options[$key][$k] = array(
							'enable' => (int) $v['enable'],
							'style'  => htmlspecialchars(trim($v['style']), ENT_QUOTES)
						);
					}else if($k == 'robots_txt'){

						$clean_options[$key][$k] = array(
							'enable' => (int) $v['enable'],
							'code'  => htmlspecialchars(trim($v['code']), ENT_QUOTES)
						);
					}else{

						$clean_options[$key][$k] = (int) $v;
					}
				}
			}
		}

		return $clean_options;
	}

	public function load_plugin_localization(){

		load_plugin_textdomain(
			BBF_PLUGIN_DOMAIN,
			false,
			dirname(dirname(plugin_basename(__FILE__ ))).'/languages/'
		);

		return false;
	}

	public function add_admin_menu(){

		add_menu_page(
			__('Bicycles', BBF_PLUGIN_DOMAIN),
			__('Bicycles', BBF_PLUGIN_DOMAIN),
			'manage_options',
			$this->main_file_name,
			array(
				$this,
				'admin_menu_display'
			),
			'dashicons-lightbulb',
			82,00012345677
		);

		return false;
	}

	public function admin_menu_display(){

		?>
		<div class="wrap bicycles-page">
			<h1>
				<?php echo(__('Bicycles', BBF_PLUGIN_DOMAIN)); ?>
			</h1>
			<div class="intro">
				<?php echo(__('In most cases, configuration and optimization of the website on the WordPress consists of a set<br>of well-known "Bicycle" and add the code templates that are repeated from project to project.<br>The purpose of this plugin is to collect all the solutions in one place to start or operate the CMS.', BBF_PLUGIN_DOMAIN)); ?>
			</div>
			<div class="fast-setup">
				<span class="recommend">
					<span class="dashicons dashicons-thumbs-up"></span>
					<?php echo(__('Note recommended settings', BBF_PLUGIN_DOMAIN)); ?>
				</span>
				<span class="reset">
					<span class="dashicons dashicons-backup"></span>
					<?php echo(__('Reset all settings', BBF_PLUGIN_DOMAIN)); ?>
				</span>
			</div>
			<div class="fast-setup-message">
				<span class="recommend">
					<?php echo(__('Settings marked do not forget to save!', BBF_PLUGIN_DOMAIN)); ?>
				</span>
				<span class="reset">
					<?php echo(__('Settings reset remember to save!', BBF_PLUGIN_DOMAIN)); ?>
				</span>
			</div>
			<form action="options.php" method="post">
				<?php settings_fields($this->prefix_db.'_options'); ?>
				<div class="wrap-tabs">
					<div class="tabs">
						<div class="tab active">
							<?php echo(__('General', BBF_PLUGIN_DOMAIN)); ?>
						</div>
						<div class="tab">
							<?php echo(__('Code', BBF_PLUGIN_DOMAIN)); ?>
						</div>
						<div class="tab">
							<?php echo(__('Doubles pages', BBF_PLUGIN_DOMAIN)); ?>
						</div>
						<div class="tab">
							<?php echo(__('SEO', BBF_PLUGIN_DOMAIN)); ?>
						</div>
						<div class="tab">
							<?php echo(__('Widgets', BBF_PLUGIN_DOMAIN)); ?>
						</div>
						<div class="tab">
							<?php echo(__('Comments', BBF_PLUGIN_DOMAIN)); ?>
						</div>
						<div class="tab">
							<?php echo(__('Security', BBF_PLUGIN_DOMAIN)); ?>
						</div>
						<div class="tab">
							<?php echo(__('Additionally', BBF_PLUGIN_DOMAIN)); ?>
						</div>
						<div class="tab donate">
							<span class="dashicons dashicons-smiley"></span>
							<?php echo(__('To support the plugin', BBF_PLUGIN_DOMAIN)); ?>
						</div>
					</div>
					<div class="content">
						<div class="tab-content active">
							<h3>
								<?php echo(__('What can plug-Bicycles by falbar', BBF_PLUGIN_DOMAIN)); ?>
							</h3>
							<ol>
								<li>
									<?php echo(__('Remove redundant code and optimize it;', BBF_PLUGIN_DOMAIN)); ?>
								</li>
								<li>
									<?php echo(__('Removes duplicate pages and redirects sets;', BBF_PLUGIN_DOMAIN)); ?>
								</li>
								<li>
									<?php echo(__('Improve SEO on the website;', BBF_PLUGIN_DOMAIN)); ?>
								</li>
								<li>
									<?php echo(__('Disable unnecessary widgets;', BBF_PLUGIN_DOMAIN)); ?>
								</li>
								<li>
									<?php echo(__('Enhances security for your website.', BBF_PLUGIN_DOMAIN)); ?>
								</li>
							</ol>
							<h3>
								<?php echo(__('From the developer', BBF_PLUGIN_DOMAIN)); ?>
							</h3>
							<p>
								<?php echo(__('Dear friends, if you have any questions or suggestions and ideas on how to improve the plugin please contact us by email: <a href="mailto:support@falbar.ru">support@falbar.ru</a>. I will try to answer the questions, and practical advice to implement in future updates.', BBF_PLUGIN_DOMAIN)); ?>
							</p>
							<h3>
								<?php echo(__('More plugins', BBF_PLUGIN_DOMAIN)); ?>
							</h3>
							<p>
								<a href="https://wordpress.org/plugins/simple-seo-by-falbar/" target="_blank">
									<?php echo(__('Simple SEO by falbar', BBF_PLUGIN_DOMAIN)); ?>
								</a>
								<?php echo(__(' - a simple solution without any extra settings to fill in title, description and keywords for all pages of WordPress.', BBF_PLUGIN_DOMAIN)); ?>
							</p>
							<p>
								<a href="https://wordpress.org/plugins/simple-seo-woo-by-falbar/" target="_blank">
									<?php echo(__('Simple SEO Woo by falbar', BBF_PLUGIN_DOMAIN)); ?>
								</a>
								<?php echo(__(' - a simple solution without any extra settings to fill in title, description and keywords for all pages of WooCommerce.', BBF_PLUGIN_DOMAIN)); ?>
							</p>
							<h3>
								<?php echo(__('My site', BBF_PLUGIN_DOMAIN)); ?>
							</h3>
							<p>
								<a href="http://falbar.ru/" target="_blank">
									<?php echo(__('falbar.ru', BBF_PLUGIN_DOMAIN)); ?>
								</a>
							</p>
						</div>
						<div class="tab-content">
							<h3>
								<?php echo(__('Code', BBF_PLUGIN_DOMAIN)); ?>
							</h3>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('code', 'remove_recentcomments'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove styles .recentcomments', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('WordPress default widget "Recent comments" registers in the code styles that it is almost impossible to change because it applies !important.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> remove styles .recentcomments section <code>&lt;head&gt;</code>.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('code', 'disable_emoji'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable Emoji', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('WordPress version 4.2 added support for Emoji emoticons. For many sites this is not needed and just increases the page loading time.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> code removes Emojis section <code>&lt;head&gt;</code>.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('code', 'disable_embed'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable Embeds', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('WordPress version 4.4 added support for embeddable objects. This function automatically converts YouTube, Tweets, and URLS to objects for easy viewing. For many sites this is not needed and just increases the page loading time.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> removes code Embeds on the page.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('code', 'remove_dns_prefetch'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove dns-prefetch', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('Starting with version 4.6.1 in WordPress appeared new links in the section <code>&lt;head&gt;</code> dns-prefetch.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> removes links dns-prefetch the partition <code>&lt;head&gt;</code>.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('code', 'remove_shortlink_link'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove shortlink link', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('WordPress by default adds per page short url <code>/?p=</code>. If you are using permalinks, it does not need a code.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> removes a short link section <code>&lt;head&gt;</code>.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('code', 'remove_canonical_link'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove canonical link', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('WordPress by default adds per page canonical link. At a certain site configuration, this functionality is not required.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> removes the canonical link section <code>&lt;head&gt;</code>.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('code', 'remove_next_prev_link'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove the links to next, previous record', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('If you are using WordPress as a CMS (not a blog), then you can remove these references, but for the blog they can be useful.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> removes references to next, previous record of the section <code>&lt;head&gt;</code>.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('code', 'remove_wlw_link'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove WLW manifest link', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('This reference is used to Windows Live Writer. If you don\'t know how to use it and why is it, then it\'s just unnecessary code.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> remove WLW manifest link section <code>&lt;head&gt;</code>.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('code', 'remove_rsd_link'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove RSD link', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('This link is used by customers of the blog. If you edit the website from your browser, then for you, it\'s just unnecessary code.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> remove RSD link section <code>&lt;head&gt;</code>.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('code', 'disable_rest_api'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable JSON REST API', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('WordPress version 4.4 provides an API for working with data, it allows developers to interact with the sites remotely by sending and receiving data in JSON format. However, many sites are using it, and therefore, in most cases it\'s just unnecessary code. Also WordPress creates technical page <code>/wp-json/</code>, which successfully indexed by search engines and index get a garbage page.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> disables the REST API and removes all reference from the section <code>&lt;head&gt;</code> and also puts a redirect on the main.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('code', 'remove_jquery_migrate'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove jQuery Migrate', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('JQuery Migrate was introduced in WordPress 3.6. For most modern web interfaces and plug-ins it is not required.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> removes the connection jquery-migrate.min.js section <code>&lt;head&gt;</code>.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="danger">
										<?php echo(__('* If you have problems in the website or plugin, disable this option!', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('code', 'remove_html_comments'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove HTML comments', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('This function will remove all HTML comments in the source code, except special and hidden comments. This is to hide the version of installed plugins.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> removes HTML comments in the source code of the page.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('code', 'html_minify'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Enable HTML minification', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('Reduce page weight by removing line breaks, tabs, spaces, etc.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> miniserver page.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-content">
							<h3>
								<?php echo(__('Doubles pages', BBF_PLUGIN_DOMAIN)); ?>
							</h3>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('doubles', 'remove_attachment_pages'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove page attachments', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('Each uploaded image has its own page on the site, consisting only of one symbol. These pages are successfully indexed and create duplicates. On the site may be thousands of similar pages of attachments.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> remove page attachments and puts a redirect to the entry.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('doubles', 'remove_archives_date'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove archives date', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('A huge number of duplicates in the archives dates. Imagine also that your article will be displayed on the home and category, you still get at least 3 doubles: archives by year, month and date, for example /2016/ /2016/02/ /2016/02/15.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> remove the archives, dates, and puts up a redirect on the main page (deactivate widget).', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('doubles', 'remove_archives_tag'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove files tags', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('If you use tags only for similar records, or not ispolzute them all - would be correct to close them to avoid duplicates.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> removes page tags it and puts a redirect on the main page (disables the widget).', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('doubles', 'remove_post_pagination'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove pagination of records', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('In WordPress any record can be divided into parts (pages), each part will have its own address. This functionality is rarely used, but can create problems for you. For example, to address any entry in your blog you can add a number, <code>/privet-mir/1/</code> - opens the record itself that will take. Room you can substitute any.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> removes the page pagination of the records and puts a redirect to the entry.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('doubles', 'remove_archives_author'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove a users archive', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('If the site is filled with only you - that function is required. Will get rid of the duplicates on the users archive, such as <code>/author/admin/</code>.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> deletes a users archive and puts a redirect on the main.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('doubles', 'remove_replytocom'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove ?replytocom', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('WordPress adds a <code>?replytocom=</code> to the reply link in the comments if you have enabled comment threading work.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> removes <code>?replytocom=</code> and puts a redirect to the entry.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-content">
							<h3>
								<?php echo(__('SEO', BBF_PLUGIN_DOMAIN)); ?>
							</h3>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('seo', 'image_auto_alt'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Automatically put alt', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('Attribute <code>alt</code> is mandatory, so say most SEO professionals. In case you missed or did not fill it, it will automatically be set to the name of the article.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> marks the attribute <code>alt</code> in the images where it is not specified.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('seo', 'set_last_modified'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Automatically set the Last Modified header', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('WordPress is not able to give server response header Last-Modified (last modified date of the document) and to give the correct answer 304 Not Modified. And this title is very important for search engines. Its presence speeds up indexing, reduces the load and allows you to download the search engines at a time, more pages in the index.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> marks for all posts, pages, archives (categories, tags, etc.) the title of the Last Modified and returns the correct answer, if the page has not been modified.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('seo', 'robots_txt', 1); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Create robots.txt', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('After installation, WordPress does not contain a file <code>robots.txt</code> and it has to be created manually. This setting will create the correct <code>robots.txt</code> and will save you from wasting time.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> creates the ideal <code>robots.txt</code>.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="danger">
										<?php echo(__('* If you have already created the file, save it, as it can be lost!', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<?php if($this->check_option('seo', 'robots_txt', 1)): ?>
									<div class="spoiler">
										<div class="name">
											<?php echo(__('To edit the file robots.txt', BBF_PLUGIN_DOMAIN)); ?>
										</div>
										<div class="data">
											<?php $this->display_textarea_robots(); ?>
										</div>
									</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="tab-content">
							<h3>
								<?php echo(__('Widgets', BBF_PLUGIN_DOMAIN)); ?>
							</h3>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('widgets', 'remove_widget_page'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable the page widget', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('widgets', 'remove_widget_calendar'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable calendar widget', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('widgets', 'remove_widget_tags'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable widget archives tags', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('widgets', 'remove_widget_archives'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable widget archives', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('widgets', 'remove_widget_meta'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable it on the meta', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('widgets', 'remove_widget_search'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable the search widget', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('widgets', 'remove_widget_text'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable the text widget', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('widgets', 'remove_widget_categories'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable widget categories', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('widgets', 'remove_widget_recent_posts'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable it on the last record', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('widgets', 'remove_widget_comments'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable widget recent comments', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('widgets', 'remove_widget_rss'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable RSS widget', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('widgets', 'remove_widget_menu'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable the widget menu', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-content">
							<h3>
								<?php echo(__('Comments', BBF_PLUGIN_DOMAIN)); ?>
							</h3>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('comments', 'remove_url_from_comment_form'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove field "Website" in comment form', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('Tired of comment spam? Visitors leave "empty" comments for links back to your website?', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> removes a field "Website" from comment form.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="danger">
										<?php echo(__('* Works with standard commenting form if your theme form prescribed manually - probably not going to work!', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('comments', 'comment_text_convert_links_pseudo', 1); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Replace external links in comments using JavaScript', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('External links in comments, which can be dozens or more on the same page, can degrade the promotion of your website.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> replaces the external links of <code>a href="http://mysite.com/"</code> to <code>span data-link="http://mysite.com/" class="pseudo-link"</code>.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="spoiler">
										<div class="name">
											<?php echo(__('To specify your own CSS for the pseudo links', BBF_PLUGIN_DOMAIN)); ?>
										</div>
										<div class="data">
											<?php $this->display_textarea('comments', 'comment_text_convert_links_pseudo', 'style'); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('comments', 'pseudo_comment_author_link', 1); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('To replace the external links from the authors of the comments in the JavaScript code', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('Up to 90 percent of the comments on the blog can be left for external links. Even nofollow from current weight page will not help here.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> replaces the external link with <code>a href="http://mysite.com/"</code> to <code>span data-link="http://mysite.com/" class="pseudo-author-link"</code>.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="spoiler">
										<div class="name">
											<?php echo(__('To specify your own CSS for the pseudo links', BBF_PLUGIN_DOMAIN)); ?>
										</div>
										<div class="data">
											<?php $this->display_textarea('comments', 'pseudo_comment_author_link', 'style'); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-content">
							<h3>
								<?php echo(__('Security', BBF_PLUGIN_DOMAIN)); ?>
							</h3>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('security', 'remove_meta_generator'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove meta generator', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('Allows hackers to know the version of WordPress installed on the website.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> removes the meta generator section <code>&lt;head&gt;</code>.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('security', 'remove_readme_license'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove files readme.html and license.txt', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('When you install WordPress or upgrade a machine added files readme.html and license.txt. Attackers can find out extra information about your CMS.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> removes files readme.html and license.txt when you are prompted.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('security', 'hide_login_errors'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Hide mistakes when you log on to the website', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('WordPress by default shows whether you\'ve entered the wrong username or the wrong password, which gives the cyber criminals to understand whether there is a certain user on the website, and then start brute force.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> change the error text so that attackers are unable to pick up login.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('security', 'disable_xmlrpc'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable XML-RPC', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('One of the reasons why your WordPress site began to slow down, is the attack in which there is a large number of queries to the file xmlrpc.php who is responsible for pingback\'and remote access to WordPress. File xmlrpc.php can go DDoS or brute force attack.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> disables XML-RPC mechanism, remove server response a reference to the xmlrpc file and closes the opportunity to spam the website pingback\'AMI.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('security', 'remove_admin_page'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove the opportunity to learn administrator login', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('An attacker can learn the username of the administrator who is using a similar GET request on a <code>mysite.com/?author=1</code>.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> deletes a user\'s archive and puts a redirect on the main.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('security', 'remove_versions_styles'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Delete a version of the styles', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('WordPress, themes and plugins often includes styles specifying the file version of the plugin or of the engine, it looks like this: <code>?ver=4.7.5</code>. First, it allows hackers to know the version of the plugin engine, and secondly, disables caching for these files, which reduces the page load time.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> removes version styles.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('security', 'remove_versions_scripts'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove version from scripts', BBF_PLUGIN_DOMAIN)); ?>
										<sup class="recommend">
											<?php echo(__('Recommended', BBF_PLUGIN_DOMAIN)); ?>
										</sup>
									</div>
									<div class="description">
										<?php echo(__('As with styles, scripts connect by specifying the file version of a plugin or engine, it looks like this: <code>?ver=4.7.5</code>. First, it allows hackers to know the version of the plugin engine, and secondly, disables caching for these files, which reduces the page load time.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> remove version from scripts.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-content">
							<h3>
								<?php echo(__('Additionally', BBF_PLUGIN_DOMAIN)); ?>
							</h3>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('additionally', 'enable_hidden_settings_page'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Enable the hidden settings page', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('In WordPress there is a hidden settings page that you can link to <code>/wp-admin/options.php</code>.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> adds a settings page under "Settings".', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('additionally', 'disable_rss_feeds'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable RSS feeds', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('By default, WordPress generates different types of RSS feeds for your website. Sometimes RSS feeds can be useful if you are using a blog for example, but if you have a normal odnostranichnik RSS for you will be useless.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> removes references to the RSS feeds section <code>&lt;head&gt;</code>, closes it and puts a redirect from all RSS feeds on the main page.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('additionally', 'remove_links_admin_bar'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Remove unnecessary links from the admin bar of WordPress', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('The first item in the toolbar is a WordPress logo and external links to sites wordpress.org, documentation, and WordPress forums.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> removes all links wordpress.org from the toolbar.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('additionally', 'enable_uplode_filename_lowercase'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Enable the Ghost to lower case the name of the media file while downloading', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('The names of the downloadable midifiles can be of different register, which is not always convenient.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> when uploading images and files names to lower case.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('additionally', 'redirect_from_http_to_https'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Redirect from http to https', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('If your site uses an SSL certificate, select this check box to enable redirect from http to https.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> puts a redirect from http to https.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="danger">
										<?php echo(__('* Before activating, please make sure that your site is opened via https!', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('additionally', 'sanitize_title'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Transliteration of titles and files', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('Analogue plugins Cyr to Lat enhanced, Rus To Lat, Cyr2Lat, etc. Transliteration permalinks and file names.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> performs transliteration permanent links and downloadable files, remove characters, spaces, Latin and other languages from the names of uploaded files (pure characters, only lowercase letters and dashes).', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('additionally', 'revisions_disable'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable revisions completely', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('When you save and update any posts or pages create a copy of it (the revision), which in the future can be viewed or restored. But over time, a large number of such revisions (and there may be dozens for each page) score database, wasting space and slowing the work.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> disables the creation of audits.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
							<div class="field">
								<div class="left">
									<?php $this->display_checkbox('additionally', 'disable_post_autosave'); ?>
								</div>
								<div class="right">
									<div class="name">
										<?php echo(__('Disable auto-save', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="description">
										<?php echo(__('By default, WordPress automatically saves a draft every 60 seconds.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
									<div class="action">
										<?php echo(__('<strong>Plugin:</strong> disables auto-save.', BBF_PLUGIN_DOMAIN)); ?>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-content">
							<div class="iframe">
								<iframe src="https://money.yandex.ru/quickpay/shop-widget?writer=seller&targets=%D0%9F%D0%BE%D0%B4%D0%B4%D0%B5%D1%80%D0%B6%D0%BA%D0%B0%20%D0%BF%D0%BB%D0%B0%D0%B3%D0%B8%D0%BD%D0%B0%20Bicycles%20by%20falbar&targets-hint=&default-sum=100&button-text=11&payment-type-choice=on&mobile-payment-type-choice=on&comment=on&hint=&successURL=&quickpay=shop&account=410011998508652" width="450" height="261" frameborder="0" allowtransparency="true" scrolling="no"></iframe>
							</div>
						</div>
					</div>
				</div>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php

		return false;
	}

	public function add_admin_scripts(){

		if(!empty($_GET['page']) && $_GET['page'] == $this->main_file_name){

			wp_enqueue_style(
				BBF_PLUGIN_DOMAIN,
				plugin_dir_url(dirname(__FILE__)).'assets/css/bicycles-by-falbar-admin.css',
				array(),
				null,
				'all'
			);

			wp_enqueue_script(
				BBF_PLUGIN_DOMAIN,
				plugin_dir_url(dirname(__FILE__)).'assets/js/bicycles-by-falbar-admin.js',
				array(
					'jquery'
				),
				null,
				false
			);
		}

		return false;
	}

	public function add_admin_notices(){

		if(!empty($_GET['page']) && $_GET['page'] == $this->main_file_name){

			if(!empty($_GET['settings-updated']) && $_GET['settings-updated'] == true){

				?>
				<div class="updated notice is-dismissible">
					<p>
						<strong>
							<?php echo(__('Settings saved.', BBF_PLUGIN_DOMAIN)); ?>
						</strong>
					</p>
					<button class="notice-dismiss" type="button">
						<span class="screen-reader-text">
							<?php echo(__('Dismiss this notice.', BBF_PLUGIN_DOMAIN)); ?>
						</span>
					</button>
				</div>
				<?php
			}
		}

		return false;
	}

	public function generate_default_params(){

		$options = $this->options;

		if($options === false){

			$params = array(
				'code' 		   => array(
					'remove_recentcomments' => 0,
					'disable_emoji' 		=> 0,
					'disable_embed' 		=> 0,
					'remove_dns_prefetch' 	=> 0,
					'remove_shortlink_link' => 0,
					'remove_canonical_link' => 0,
					'remove_next_prev_link' => 0,
					'remove_wlw_link' 		=> 0,
					'remove_rsd_link' 		=> 0,
					'disable_rest_api' 		=> 0,
					'remove_jquery_migrate' => 0,
					'remove_html_comments'  => 0,
					'html_minify' 			=> 0
				),
				'doubles' 	   => array(
					'remove_attachment_pages' => 0,
					'remove_archives_date' 	  => 0,
					'remove_archives_tag' 	  => 0,
					'remove_post_pagination'  => 0,
					'remove_archives_author'  => 0,
					'remove_replytocom' 	  => 0
				),
				'seo' 	   	   => array(
					'image_auto_alt' 	=> 0,
					'set_last_modified' => 0,
					'robots_txt' 		=> array(
						'enable' => 0,
						'code'   => ''
					)
				),
				'widgets' 	   => array(
					'remove_widget_page' 	 	 => 0,
					'remove_widget_calendar' 	 => 0,
					'remove_widget_tags' 	 	 => 0,
					'remove_widget_archives' 	 => 0,
					'remove_widget_meta' 	 	 => 0,
					'remove_widget_search' 	 	 => 0,
					'remove_widget_text' 		 => 0,
					'remove_widget_categories' 	 => 0,
					'remove_widget_recent_posts' => 0,
					'remove_widget_comments' 	 => 0,
					'remove_widget_rss' 	 	 => 0,
					'remove_widget_menu' 	 	 => 0
				),
				'comments' 	   => array(
					'remove_url_from_comment_form' 		=> 0,
					'comment_text_convert_links_pseudo' => array(
						'enable' => 0,
						'style'  => ''
					),
					'pseudo_comment_author_link' 		=> array(
						'enable' => 0,
						'style'  => ''
					)
				),
				'security' 	   => array(
					'remove_meta_generator'   => 0,
					'remove_readme_license'   => 0,
					'hide_login_errors' 	  => 0,
					'disable_xmlrpc' 		  => 0,
					'remove_admin_page' 	  => 0,
					'remove_versions_styles'  => 0,
					'remove_versions_scripts' => 0
				),
				'additionally' => array(
					'enable_hidden_settings_page' 	   => 0,
					'disable_rss_feeds' 		  	   => 0,
					'remove_links_admin_bar' 	  	   => 0,
					'enable_uplode_filename_lowercase' => 0,
					'redirect_from_http_to_https' 	   => 0,
					'sanitize_title' 				   => 0,
					'revisions_disable' 			   => 0,
					'disable_post_autosave' 		   => 0
				)
			);

			/*** OLD VERSION  ***/
			$options_old = get_option($this->prefix_db.'_options_name');

			if($options_old !== false){

				if(!empty($options_old['remove_meta_generator']) && $options_old['remove_meta_generator'] == 1){

					$params['security']['remove_meta_generator'] = 1;
				}

				if(!empty($options_old['remove_rsd_link']) && $options_old['remove_rsd_link'] == 1){

					$params['code']['remove_rsd_link'] = 1;
				}

				if(!empty($options_old['remove_wlw_link']) && $options_old['remove_wlw_link'] == 1){

					$params['code']['remove_wlw_link'] = 1;
				}

				if(!empty($options_old['remove_next_prev_link']) && $options_old['remove_next_prev_link'] == 1){

					$params['code']['remove_next_prev_link'] = 1;
				}

				if(!empty($options_old['remove_canonical_link']) && $options_old['remove_canonical_link'] == 1){

					$params['code']['remove_canonical_link'] = 1;
				}

				if(!empty($options_old['remove_shortlink_link']) && $options_old['remove_shortlink_link'] == 1){

					$params['code']['remove_shortlink_link'] = 1;
				}

				if(!empty($options_old['remove_dns_prefetch']) && $options_old['remove_dns_prefetch'] == 1){

					$params['code']['remove_dns_prefetch'] = 1;
				}

				if(!empty($options_old['disable_wp_embed']) && $options_old['disable_wp_embed'] == 1){

					$params['code']['disable_embed'] = 1;
				}

				if(!empty($options_old['disable_emoji']) && $options_old['disable_emoji'] == 1){

					$params['code']['disable_emoji'] = 1;
				}

				if(!empty($options_old['remove_recentcomments_style']) && $options_old['remove_recentcomments_style'] == 1){

					$params['code']['remove_recentcomments'] = 1;
				}

				if(!empty($options_old['remove_attachment_pages']) && $options_old['remove_attachment_pages'] == 1){

					$params['doubles']['remove_attachment_pages'] = 1;
				}

				if(!empty($options_old['remove_archives_date']) && $options_old['remove_archives_date'] == 1){

					$params['doubles']['remove_archives_date'] = 1;
				}

				if(!empty($options_old['remove_archives_tag']) && $options_old['remove_archives_tag'] == 1){

					$params['doubles']['remove_archives_tag'] = 1;
				}

				if(!empty($options_old['remove_post_pagination']) && $options_old['remove_post_pagination'] == 1){

					$params['doubles']['remove_post_pagination'] = 1;
				}

				if(!empty($options_old['remove_archives_author']) && $options_old['remove_archives_author'] == 1){

					$params['doubles']['remove_archives_author'] = 1;
				}

				if(!empty($options_old['hide_login_errors']) && $options_old['hide_login_errors'] == 1){

					$params['security']['hide_login_errors'] = 1;
				}

				if(!empty($options_old['disable_xmlrpc']) && $options_old['disable_xmlrpc'] == 1){

					$params['security']['disable_xmlrpc'] = 1;
				}

				if(!empty($options_old['disable_x_pingback']) && $options_old['disable_x_pingback'] == 1){

					$params['security']['disable_xmlrpc'] = 1;
				}

				if(!empty($options_old['enable_filename_lowercase']) && $options_old['enable_filename_lowercase'] == 1){

					$params['additionally']['enable_uplode_filename_lowercase'] = 1;
				}

				if(!empty($options_old['disable_rss_feeds']) && $options_old['disable_rss_feeds'] == 1){

					$params['additionally']['disable_rss_feeds'] = 1;
				}

				if(!empty($options_old['disable_rest_api']) && $options_old['disable_rest_api'] == 1){

					$params['code']['disable_rest_api'] = 1;
				}

				if(!empty($options_old['remove_links_admin_bar']) && $options_old['remove_links_admin_bar'] == 1){

					$params['additionally']['remove_links_admin_bar'] = 1;
				}

				if(!empty($options_old['remove_url_from_comment_form']) && $options_old['remove_url_from_comment_form'] == 1){

					$params['comments']['remove_url_from_comment_form'] = 1;
				}

				delete_option($this->prefix_db.'_options_name');
			}
			/* END OLD VERSION  */

			add_option($this->prefix_db.'_options_params', $params);
		}

		return false;
	}

	public function setup_params(){

		if(!empty($this->options['code'])){

			if($this->check_option('code', 'remove_recentcomments')){

				Falbar_BBF_Option_Code::remove_recentcomments();
			}

			if($this->check_option('code', 'disable_emoji')){

				Falbar_BBF_Option_Code::disable_emoji();
			}

			if($this->check_option('code', 'disable_embed')){

				Falbar_BBF_Option_Code::disable_embed();
			}

			if($this->check_option('code', 'remove_dns_prefetch')){

				Falbar_BBF_Option_Code::remove_dns_prefetch();
			}

			if($this->check_option('code', 'remove_shortlink_link')){

				Falbar_BBF_Option_Code::remove_shortlink_link();
			}

			if($this->check_option('code', 'remove_canonical_link')){

				Falbar_BBF_Option_Code::remove_canonical_link();
			}

			if($this->check_option('code', 'remove_next_prev_link')){

				Falbar_BBF_Option_Code::remove_next_prev_link();
			}

			if($this->check_option('code', 'remove_wlw_link')){

				Falbar_BBF_Option_Code::remove_wlw_link();
			}

			if($this->check_option('code', 'remove_rsd_link')){

				Falbar_BBF_Option_Code::remove_rsd_link();
			}

			if($this->check_option('code', 'disable_rest_api')){

				Falbar_BBF_Option_Code::disable_rest_api();
			}

			if($this->check_option('code', 'remove_jquery_migrate')){

				Falbar_BBF_Option_Code::remove_jquery_migrate();
			}

			if($this->check_option('code', 'remove_html_comments')){

				Falbar_BBF_Option_Code::remove_html_comments();
			}

			if($this->check_option('code', 'html_minify')){

				Falbar_BBF_Option_Code::html_minify();
			}
		}

		if(!empty($this->options['doubles'])){

			if($this->check_option('doubles', 'remove_attachment_pages')){

				Falbar_BBF_Option_Doubles::remove_attachment_pages();
			}

			if($this->check_option('doubles', 'remove_archives_date')){

				Falbar_BBF_Option_Doubles::remove_archives_date();
			}

			if($this->check_option('doubles', 'remove_archives_tag')){

				Falbar_BBF_Option_Doubles::remove_archives_tag();
			}

			if($this->check_option('doubles', 'remove_post_pagination')){

				Falbar_BBF_Option_Doubles::remove_post_pagination();
			}

			if($this->check_option('doubles', 'remove_archives_author')){

				Falbar_BBF_Option_Doubles::remove_archives_author();
			}

			if($this->check_option('doubles', 'remove_replytocom')){

				Falbar_BBF_Option_Doubles::remove_replytocom();
			}
		}

		if(!empty($this->options['seo'])){

			if($this->check_option('seo', 'image_auto_alt')){

				Falbar_BBF_Option_SEO::image_auto_alt();
			}

			if($this->check_option('seo', 'set_last_modified')){

				Falbar_BBF_Option_SEO::set_last_modified();
			}

			if($this->check_option('seo', 'robots_txt', 1)){

				Falbar_BBF_Option_SEO::robots_txt(
					$this->options['seo']['robots_txt']['code']
				);
			}
		}

		if(!empty($this->options['widgets'])){

			if($this->check_option('widgets', 'remove_widget_page')){

				Falbar_BBF_Option_Widgets::remove_widget_page();
			}

			if($this->check_option('widgets', 'remove_widget_calendar')){

				Falbar_BBF_Option_Widgets::remove_widget_calendar();
			}

			if($this->check_option('widgets', 'remove_widget_tags')){

				Falbar_BBF_Option_Widgets::remove_widget_tags();
			}

			if($this->check_option('widgets', 'remove_widget_archives')){

				Falbar_BBF_Option_Widgets::remove_widget_archives();
			}

			if($this->check_option('widgets', 'remove_widget_meta')){

				Falbar_BBF_Option_Widgets::remove_widget_meta();
			}

			if($this->check_option('widgets', 'remove_widget_search')){

				Falbar_BBF_Option_Widgets::remove_widget_search();
			}

			if($this->check_option('widgets', 'remove_widget_text')){

				Falbar_BBF_Option_Widgets::remove_widget_text();
			}

			if($this->check_option('widgets', 'remove_widget_categories')){

				Falbar_BBF_Option_Widgets::remove_widget_categories();
			}

			if($this->check_option('widgets', 'remove_widget_recent_posts')){

				Falbar_BBF_Option_Widgets::remove_widget_recent_posts();
			}

			if($this->check_option('widgets', 'remove_widget_comments')){

				Falbar_BBF_Option_Widgets::remove_widget_comments();
			}

			if($this->check_option('widgets', 'remove_widget_rss')){

				Falbar_BBF_Option_Widgets::remove_widget_rss();
			}

			if($this->check_option('widgets', 'remove_widget_menu')){

				Falbar_BBF_Option_Widgets::remove_widget_menu();
			}
		}

		if(!empty($this->options['comments'])){

			if($this->check_option('comments', 'remove_url_from_comment_form')){

				Falbar_BBF_Option_Comments::remove_url_from_comment_form();
			}

			if($this->check_option('comments', 'comment_text_convert_links_pseudo', 1)){

				Falbar_BBF_Option_Comments::comment_text_convert_links_pseudo(
					$this->options['comments']['comment_text_convert_links_pseudo']['style']
				);
			}

			if($this->check_option('comments', 'pseudo_comment_author_link', 1)){

				Falbar_BBF_Option_Comments::pseudo_comment_author_link(
					$this->options['comments']['pseudo_comment_author_link']['style']
				);
			}
		}

		if(!empty($this->options['security'])){

			if($this->check_option('security', 'remove_meta_generator')){

				Falbar_BBF_Option_Security::remove_meta_generator();
			}

			if($this->check_option('security', 'remove_readme_license')){

				Falbar_BBF_Option_Security::remove_readme_license();
			}

			if($this->check_option('security', 'hide_login_errors')){

				Falbar_BBF_Option_Security::hide_login_errors();
			}

			if($this->check_option('security', 'disable_xmlrpc')){

				Falbar_BBF_Option_Security::disable_xmlrpc();
			}

			if($this->check_option('security', 'remove_admin_page')){

				Falbar_BBF_Option_Security::remove_admin_page();
			}

			if($this->check_option('security', 'remove_versions_styles')){

				Falbar_BBF_Option_Security::remove_versions_styles();
			}

			if($this->check_option('security', 'remove_versions_scripts')){

				Falbar_BBF_Option_Security::remove_versions_scripts();
			}
		}

		if(!empty($this->options['additionally'])){

			if($this->check_option('additionally', 'enable_hidden_settings_page')){

				Falbar_BBF_Option_Additionally::enable_hidden_settings_page();
			}

			if($this->check_option('additionally', 'disable_rss_feeds')){

				Falbar_BBF_Option_Additionally::disable_rss_feeds();
			}

			if($this->check_option('additionally', 'remove_links_admin_bar')){

				Falbar_BBF_Option_Additionally::remove_links_admin_bar();
			}

			if($this->check_option('additionally', 'enable_uplode_filename_lowercase')){

				Falbar_BBF_Option_Additionally::enable_uplode_filename_lowercase();
			}

			if($this->check_option('additionally', 'redirect_from_http_to_https')){

				Falbar_BBF_Option_Additionally::redirect_from_http_to_https();
			}

			if($this->check_option('additionally', 'sanitize_title')){

				Falbar_BBF_Option_Additionally::sanitize_title();
			}

			if($this->check_option('additionally', 'revisions_disable')){

				Falbar_BBF_Option_Additionally::revisions_disable();
			}

			if($this->check_option('additionally', 'disable_post_autosave')){

				Falbar_BBF_Option_Additionally::disable_post_autosave();
			}
		}

		return false;
	}
}