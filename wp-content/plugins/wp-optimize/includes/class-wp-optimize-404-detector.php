<?php
if (!defined('ABSPATH')) die('No direct access allowed');

if (!class_exists('WP_Optimize_404_Detector')) :

class WP_Optimize_404_Detector {

	/**
	 * Suspicious requests threshold
	 *
	 * @var int
	 */
	private $suspicious_request_count_threshold = 50;

	/**
	 * Remove trivial requests older than hours
	 *
	 * @var int
	 */
	private $suspicious_trivial_request_ttl_in_hours = 24;

	/**
	 * Remove suspicious requests older than hours
	 *
	 * @var int
	 */
	private $suspicious_request_ttl_in_hours = 672;
	
	/**
	 * How many suspicious requests count in total to show in the dashboard?
	 *
	 * @var int
	 */
	private $dashboard_alert_request_count_threshold = 100;
	
	/**
	 * Store the total count for each url, to be able to sort it later
	 *
	 * @var array
	 */
	private $total_count_per_url = array();

	/**
	 * Class constructor
	 */
	private function __construct() {
		add_action('wpo_prune_404_log', array($this, 'prune_404_log'));
	}
	
	/**
	 * Initialize the class as a singleton
	 *
	 * @return WP_Optimize_404_Detector
	 */
	public static function get_instance() {
		static $_instance = null;
		if (null === $_instance) {
			$_instance = new self();
		}
		return $_instance;
	}

	/**
	 * Handle 404 requests
	 *
	 * @return void
	 */
	public function handle_request() {
		$now = current_datetime()->getTimestamp();
		$request_timestamp = $now - ($now % 3600);

		$url_data = isset($_SERVER['REQUEST_URI']) ? $this->parse_url(sanitize_url(wp_unslash($_SERVER['REQUEST_URI']))) : false;

		if (false == $url_data || !isset($url_data['path']) || ('/' == $url_data['path'])) {
			return;
		}

		$url = home_url($url_data['path']);
		
		$this->save_request_hour_row($request_timestamp, $url);
	}

	/**
	 * Log an entry for 404 errors
	 *
	 * @param string $request_timestamp The moment the request is happening
	 * @param string $url			    Relative url to the URL being analyzed
	 * @return void
	 */
	private function save_request_hour_row($request_timestamp, $url) {
		global $wpdb;
		
		$log_table_name = $this->get_table_name();

		$referrer = isset($_SERVER['HTTP_REFERER']) ? sanitize_url(wp_unslash($_SERVER['HTTP_REFERER'])) : "";

		$safe_referrer = '';
		if ('' !== $referrer) {
			$referrer_parsed = $this->parse_url($referrer);
			$safe_referrer = (isset($referrer_parsed['scheme']) ? $referrer_parsed['scheme'] . '://' : '') .
							(isset($referrer_parsed['host']) ? $referrer_parsed['host'] : '') .
							(isset($referrer_parsed['port']) ? ':' . $referrer_parsed['port'] : '') .
							(isset($referrer_parsed['path']) ? $referrer_parsed['path'] : '') .
							(isset($referrer_parsed['query']) ? '?' . $referrer_parsed['query'] : '');
		}

		$wpdb->query($wpdb->prepare("INSERT INTO `$log_table_name` SET `url` = %s, request_timestamp = %d, referrer = %s, request_count = 1 ON DUPLICATE KEY UPDATE request_count = request_count + 1", $url, $request_timestamp, $safe_referrer));
	}

	/**
	 * Remove trivial requests older than 24 hours, and suspicious requests after 4 weeks
	 *
	 * @return void
	 */
	public function prune_404_log() {
		global $wpdb;

		$log_table_name = $this->get_table_name();

		// Remove old trivial requests
		$hs_to_remove_older = $this->suspicious_trivial_request_ttl_in_hours * 3600;
		$remove_date = time() - $hs_to_remove_older;


		$wpdb->query($wpdb->prepare("DELETE FROM `$log_table_name` WHERE request_timestamp < %d AND request_count < %d", $remove_date, $this->suspicious_request_count_threshold));

		// Remove any type of old request
		$hs_to_remove_older = $this->suspicious_request_ttl_in_hours * 3600;
		$remove_date = time() - $hs_to_remove_older;

		$wpdb->query($wpdb->prepare("DELETE FROM `$log_table_name` WHERE request_timestamp < %d", $remove_date));
	}

	/**
	 * Get suspicious requests from DB grouped by url and referrer
	 *
	 * @return array
	 */
	public function get_suspicious_requests() {
		$all_suspicious_referrers = array();
		$by_referrer = $this->get_single_suspicious_requests_by_referer($all_suspicious_referrers);
		
		$by_url = $this->get_grouped_requests_by_url($all_suspicious_referrers);

		$result = array_merge($by_url, $by_referrer);

		usort($result, array($this, 'sort_suspicious_requests'));

		$per_url = array();

		foreach ($result as $item) {
			$per_url[$item->url][] = $item;
		}

		return $per_url;
	}

	/**
	 * Find requests that by themselves have a request count over the threshold
	 *
	 * @param array $all_suspicious_referrers Optional. By reference, will be populated with hashed referrers
	 * @return array
	 */
	private function get_single_suspicious_requests_by_referer(&$all_suspicious_referrers = null) {
		global $wpdb;
		$log_table_name = $this->get_table_name();

		$threshold = $this->suspicious_request_count_threshold;

		$by_referrer = $wpdb->get_results(
			$wpdb->prepare("SELECT `url`,
									  SUM(IF(request_count < %d, 0, request_count)) AS total_count,
									  referrer,
									  MIN(request_timestamp) AS first_access,
									  MAX(request_timestamp) AS last_access,
									  COUNT(1) AS occurrences,
									  1 AS total_referrers,
									  'singles' AS row_type
									  FROM `$log_table_name` GROUP BY `url`, referrer HAVING total_count >= %d ORDER BY request_timestamp DESC", $threshold, $threshold)
		);
		
		foreach ($by_referrer as &$item) {
			$item->referrer = esc_html($item->referrer);
			$item->suspicious_referrers = 1;
			$item->non_suspicious_referrers = 0;
			
			$this->total_count_per_url[$item->url] = $item->total_count;

			if (is_array($all_suspicious_referrers)) {
				$all_suspicious_referrers[] = substr(md5($item->referrer), 0, 6);
			}
		}

		return $by_referrer;
	}

	/**
	 * Find urls that if we sum the requests for all referrers, the result is greater than the threshold
	 *
	 * @param array $known_suspicious_referrers Hashed referrers to filter out from non-suspicious count
	 * @return array
	 */
	private function get_grouped_requests_by_url($known_suspicious_referrers) {
		global $wpdb;
		$log_table_name = $this->get_table_name();

		$threshold = $this->suspicious_request_count_threshold;

		$known_suspicious_referrers = implode(',', array_unique($known_suspicious_referrers));

		$by_url = $wpdb->get_results(
			$wpdb->prepare("SELECT `url`,
										SUM(request_count) AS total_count,
										'' AS referrer,
										MIN(request_timestamp) AS first_access,
										MAX(request_timestamp) AS last_access,
										COUNT(1) AS occurrences,
										(COUNT(DISTINCT(IF(%d < request_count, '--nonsuspcious--', referrer)))) AS suspicious_referrers,
										(SUM(IF(%d < request_count AND LOCATE(MD5(SUBSTRING(referrer,1,6)), %s) = 0, 1, 0))) AS non_suspicious_referrers,
										COUNT(DISTINCT(referrer)) AS total_referrers,
										'grouped' AS row_type
										FROM `$log_table_name` GROUP BY `url` HAVING 1 < occurrences AND %d <= total_count ORDER BY request_timestamp DESC", $threshold, $threshold, $known_suspicious_referrers, $threshold)
		);
		
		foreach ($by_url as &$item) {
			$item->referrer = esc_html__('(any)', 'wp-optimize');

			if (0 < $item->non_suspicious_referrers) {
				// Some non-suspicious referrers exist in the group, all those are grouped under `--nonsuspicious--`, so remove it from the suscipious count
				$item->suspicious_referrers = $item->suspicious_referrers - 1;
			}

			$this->total_count_per_url[$item->url] = $item->total_count;
		}

		return $by_url;
	}

	/**
	 * Get suspicious requests from DB for a single request url, grouped by under/over threshold
	 *
	 * @param string $url The actual url we are fetching for
	 * @return array
	 */
	public function get_url_requests_by_referrer($url) {
		global $wpdb;

		$log_table_name = $this->get_table_name();

		$return = array('over' => array(), 'under' => array());

		$threshold = $this->suspicious_request_count_threshold;

		$requests = $wpdb->get_results(
			$wpdb->prepare("SELECT SUM(request_count) AS total_count,
								referrer,
								MIN(request_timestamp) AS first_access,
								MAX(request_timestamp) AS last_access
								FROM `$log_table_name`
								WHERE `url` = %s GROUP BY referrer, (%d < request_count)
								ORDER BY request_count DESC",
				$url,
				$threshold
			)
		);
		
		foreach ($requests as $request) {
			$group = $request->total_count >= $threshold ? 'over' : 'under';
			$return[$group][] = $request;
		}

		return $return;
	}

	/**
	 * Check if there are any suspicious requests logged, then return the total
	 *
	 * @return int
	 */
	public function get_suspicious_requests_count() {
		$requests = $this->get_single_suspicious_requests_by_referer();
		
		$total = 0;
		foreach ($requests as $req) {
			$total += $req->total_count;
		}

		return $total;
	}

	/**
	 * Returns the dashboard alert request count
	 *
	 * @return int
	 */
	public function get_dashboard_alert_request_count_threshold() {
		return $this->dashboard_alert_request_count_threshold;
	}

	/**
	 * Returns the suspicious request count threshold
	 *
	 * @return int
	 */
	public function get_suspicious_request_count_threshold() {
		return $this->suspicious_request_count_threshold;
	}
	
	/**
	 * Returns the table name
	 *
	 * @return string
	 */
	private function get_table_name() {
		return WP_Optimize_Table_404_Detector::get_instance()->get_table_name();
	}
	
	/**
	 * Sorts the array by `url total count` DESC, `url` ASC, and `request total_count` DESC
	 *
	 * @param object $result_a
	 * @param object $result_b
	 *
	 * @return int
	 */
	private function sort_suspicious_requests($result_a, $result_b) {
		$a_url_total = isset($this->total_count_per_url[$result_a->url]) ? $this->total_count_per_url[$result_a->url] : 0;
		$b_url_total = isset($this->total_count_per_url[$result_b->url]) ? $this->total_count_per_url[$result_b->url] : 0;

		$a = (PHP_INT_MAX - $a_url_total) . ' ' . $result_a->url . ' ' . (PHP_INT_MAX - $result_a->total_count);
		$b = (PHP_INT_MAX - $b_url_total) . ' ' . $result_b->url . ' ' . (PHP_INT_MAX - $result_b->total_count);

		return $a < $b ? -1 : 1;
	}

	/**
	 * Wrapper over `wp_parse_url` to handle a `false` response, in such case we return an empty array.
	 * This wrapper always requests `wp_parse_url` the default return an array with all components found.
	 *
	 * @param string $url The URL to be parsed
	 * @return array
	 */
	private function parse_url($url) {
		$parsed = wp_parse_url($url);

		if (false !== $parsed) {
			return $parsed;
		} else {
			return array();
		}
	}
}

endif;
