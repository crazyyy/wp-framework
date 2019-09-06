<?php
/**
 * Woody Dashboard Widget
 *
 * Adds a widget with a banner, a list of news and chat for communication.
 *
 * @author        Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 15.03.2019, Webcraftic
 * @version       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WINP_Dashboard_Widget extends WINP_Request {

	const WINP_WIDGET_URL = 'http://woody-ad-snippets.webcraftic.com/wp-json/wp/v2/posts';
	const WINP_WIDGET_CATEGORY = '99,100';    // Requested categories id
	const WINP_WIDGET_ITEMS = 5;           // Posts for one request
	const WINP_WIDGET_EXPIRATION = 1200;        // Expiration time for cached news
	const WINP_WIDGET_BANNER_ID = 661;        // Expiration time for cached news

	/**
	 * WINP_Dashboard_Widget constructor.
	 */
	public function __construct() {
		parent::__construct();

		require_once WINP_PLUGIN_DIR . '/includes/jsonmapper/class/post.php';

		$this->register_hooks();
	}

	/**
	 * Register hooks
	 */
	public function register_hooks() {
		add_action( 'wp_dashboard_setup', [ $this, 'add_dashboard_widgets' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_filter( 'wbcr/inp/dashboard/widget/print', [ $this, 'dashboard_widget_news' ] );
	}

	/**
	 * Enqueue scripts and styles
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'winp-dashboard-widget', WINP_PLUGIN_URL . '/admin/assets/css/dashboard-widget.css' );
	}

	/**
	 * Add a widget to the dashboard
	 */
	public function add_dashboard_widgets() {
		wp_add_dashboard_widget( 'winp-dashboard-widget', __( 'Woody News', 'insert-php' ), [
			$this,
			'dashboard_widget_news'
		] );
	}

	/**
	 * Create the function to output the contents of our Dashboard Widget.
	 */
	public function dashboard_widget_news() {
		?>
        <div class="wordpress-news hide-if-no-js">
			<?php $this->print_news(); ?>
        </div>
		<?php
	}

	/**
	 * Get woody banner and news
	 *
	 * @return array
	 */
	public function get_data() {
		$support_details = WINP_Plugin::app()->getPluginInfoAttr( 'support_details' );
		$cached_data     = WINP_Plugin::app()->getOption( 'winp_dashboard_widget_news', [] );

		if ( ! empty( $cached_data ) && time() - $cached_data['time'] <= self::WINP_WIDGET_EXPIRATION ) {
			return [
				'banner' => $cached_data['banner'],
				'news'   => $cached_data['news'],
			];
		} else {
			$news  = [];
			$json  = wp_remote_get( self::WINP_WIDGET_URL . '?categories=' . self::WINP_WIDGET_CATEGORY . '&exclude=' . self::WINP_WIDGET_BANNER_ID . '&per_page=' . self::WINP_WIDGET_ITEMS );
			$posts = $this->map_objects( $json, 'WINP\JsonMapper\Post' );

			if ( ! empty( $posts ) ) {
				foreach ( $posts as $post ) {
					$news[] = [
						'link'  => $support_details['affiliate_url'] . $post->link,
						'title' => isset( $post->title->rendered ) ? $post->title->rendered : $post->slug,
					];
				}
			}

			$banner = [];
			$json   = wp_remote_get( self::WINP_WIDGET_URL . '?include=661' );
			$posts  = $this->map_objects( $json, 'WINP\JsonMapper\Post' );

			try {
				$content = isset( $posts[0] ) ? $posts[0]->content->rendered : '';
			} catch( \Exception $e ) {
				$content = '';
			}

			preg_match_all( '/bannerUrl:([^\s"]+)-->/', $content, $match );
			$href = isset( $match[1][0] ) ? trim( $match[1][0] ) : 0;
			preg_match_all( '/bannerSrc:([^\s"]+)-->/', $content, $match );
			$src = isset( $match[1][0] ) ? trim( $match[1][0] ) : 0;

			if ( ! empty( $href ) && ! empty( $src ) ) {
				$banner['href'] = $href;
				$banner['src']  = $src;
			}

			WINP_Plugin::app()->updateOption( 'winp_dashboard_widget_news', [
				'banner' => $banner,
				'news'   => $news,
				'time'   => time(),
			] );

			return [
				'banner' => $banner,
				'news'   => $news,
			];
		}
	}

	/**
	 * Output woody banner and news
	 */
	public function print_news() {
		$data = $this->get_data();
		if ( ! empty( $data ) ) :
			if ( ! empty( $data['banner'] ) ) :
				?>
                <div class="rss-widget">
                    <ul class="winp-banner">
                        <li class="banner-item">
                            <a href="<?php echo esc_url( $data['banner']['href'] ); ?>">
                                <img src="<?php echo esc_url( $data['banner']['src'] ); ?>" alt="<?php _e( 'Woody Banner', 'insert-php' ); ?>" style="width: 100%">
                            </a>
                        </li>
                    </ul>
                </div>
			<?php
			endif;
			?>
            <div class="rss-widget">
                <ul class="winp-news">
					<?php
					if ( ! empty( $data['news'] ) ) :
						foreach ( $data['news'] as $news ) {
							?>
                            <li>
                                <a class="rsswidget" href="<?php echo esc_url( $news['link'] ); ?>">
									<?php esc_html_e( $news['title'] ); ?>
                                </a>
                            </li>
							<?php
						}
					else :
						?>
                        <li><?php _e( 'No news', 'insert-php' ); ?></li>
					<?php
					endif;
					?>
                </ul>
            </div>
		<?php
		else :
			?>
            <div class="rss-widget">
                <ul>
                    <li><?php _e( 'No news', 'insert-php' ); ?></li>
                </ul>
            </div>
		<?php
		endif;
	}

}