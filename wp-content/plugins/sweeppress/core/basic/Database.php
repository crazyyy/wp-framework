<?php

namespace Dev4Press\Plugin\SweepPress\Basic;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Database {
	private $_system = array(
		'options',
		'blog_versions',
		'blogs',
		'site',
		'sitemeta',
		'users',
		'usermeta'
	);
	private $_wordpress = array(
		'blog'    => array(
			'posts',
			'comments',
			'links',
			'options',
			'postmeta',
			'terms',
			'term_taxonomy',
			'term_relationships',
			'termmeta',
			'commentmeta'
		),
		'global'  => array(
			'users',
			'usermeta'
		),
		'network' => array(
			'blogs',
			'blogmeta',
			'signups',
			'site',
			'sitemeta',
			'registration_log'
		)
	);
	private $_prefix;
	private $_base_prefix;
	private $_tables;
	private $_core;
	private $_optimize;
	private $_engines = array();
	private $_collation = array();
	private $_totals = array(
		'size'        => 0,
		'free'        => 0,
		'index'       => 0,
		'rows'        => 0,
		'total'       => 0,
		'to_optimize' => 0,
		'to_repair'   => 0,
		'tables'      => 0
	);
	private $_totals_wp = array(
		'size'        => 0,
		'free'        => 0,
		'index'       => 0,
		'rows'        => 0,
		'total'       => 0,
		'to_optimize' => 0,
		'to_repair'   => 0,
		'tables'      => 0
	);

	public function __construct() {
		$this->_prefix      = sweeppress_prepare()->prefix();
		$this->_base_prefix = sweeppress_prepare()->base_prefix();

		$this->_optimize = array(
			'threshold' => sweeppress_settings()->get( 'db_table_optimize_threshold', 'sweepers' ),
			'min_size'  => sweeppress_settings()->get( 'db_table_optimize_min_size', 'sweepers' ) * 1024 * 1024
		);

		$this->_tables = Prepare::instance()->get_tables_status();
		$this->_core   = array(
			'blog'    => $this->_prepare_wp_tables( 'blog' ),
			'global'  => $this->_prepare_wp_tables( 'global' ),
			'network' => $this->_prepare_wp_tables( 'network' )
		);

		foreach ( $this->_tables as $name => $table ) {
			$this->_process_table( $name, $table );
		}
	}

	public static function instance() : Database {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new Database();
		}

		return $instance;
	}

	public function get_engines() : array {
		return $this->_engines;
	}

	public function get_collations() : array {
		return $this->_collation;
	}

	public function get_tables() : array {
		return $this->_tables;
	}

	public function total( string $name = '' ) {
		return $this->_totals[ $name ] ?? $this->_totals;
	}

	public function total_wp( string $name = '' ) {
		return $this->_totals_wp[ $name ] ?? $this->_totals_wp;
	}

	public function table( $name ) : array {
		$name = strtolower( $name );

		return $this->_tables[ $name ] ?? $this->_empty_stats( $name );
	}

	public function calculate( string $value, array $tables ) : int {
		$size = 0;

		if ( empty( $tables ) ) {
			foreach ( $this->_tables as $obj ) {
				$size += $obj[ $value ];
			}
		} else {
			foreach ( $tables as $table ) {
				$name = Prepare::instance()->wpdb()->$table ?? '';

				if ( ! empty( $name ) ) {
					$obj  = $this->table( $name );
					$size += $obj[ $value ];
				}
			}
		}

		return $size;
	}

	private function _prepare_wp_tables( string $type ) : array {
		$list   = $this->_wordpress[ $type ] ?? array();
		$tables = array();

		foreach ( $list as $table ) {
			$prefix = $type == 'blog' ? $this->_prefix : $this->_base_prefix;

			$tables[ $table ] = $prefix . $table;
		}

		return $tables;
	}

	private function _process_table( string $name, array $table ) {
		if ( ! in_array( $table[ 'engine' ], $this->_engines ) ) {
			$this->_engines[ $table[ 'engine' ] ] = $table[ 'engine' ];
		}

		if ( ! in_array( $table[ 'collation' ], $this->_collation ) ) {
			$this->_collation[ $table[ 'collation' ] ] = $table[ 'collation' ];
		}

		foreach ( $this->_core as $type => $tables ) {
			foreach ( $tables as $real => $tbl_name ) {
				if ( $name == $tbl_name ) {
					$this->_tables[ $name ][ 'wp_table' ]       = $real;
					$this->_tables[ $name ][ 'is_wp_' . $type ] = true;
					break;
				}
			}
		}

		$this->_tables[ $name ][ 'is_wp' ]     = $this->_tables[ $name ][ 'is_wp_blog' ] || $this->_tables[ $name ][ 'is_wp_global' ] || $this->_tables[ $name ][ 'is_wp_network' ];
		$this->_tables[ $name ][ 'is_non_wp' ] = ! $this->_tables[ $name ][ 'is_wp' ];

		if ( ! empty( $this->_tables[ $name ][ 'wp_table' ] ) ) {
			if ( in_array( $this->_tables[ $name ][ 'wp_table' ], $this->_system ) ) {
				$this->_tables[ $name ][ 'is_core' ] = true;
			}
		}

		if ( $table[ 'fragment' ] >= $this->_optimize[ 'threshold' ] && $table[ 'total' ] > $this->_optimize[ 'min_size' ] ) {
			$this->_tables[ $name ][ 'for_optimization' ] = true;
			$this->_totals[ 'to_optimize' ] ++;
		}

		if ( $table[ 'is_corrupted' ] ) {
			$this->_totals[ 'to_repair' ] ++;
		}

		if ( $this->_tables[ $name ][ 'is_non_wp' ] ) {
			$this->_tables[ $name ][ 'detected_plugin' ] = $this->_detect_plugin( $name );
		}

		$this->_totals[ 'size' ]  += $table[ 'size' ];
		$this->_totals[ 'free' ]  += $table[ 'free' ];
		$this->_totals[ 'index' ] += $table[ 'index' ];
		$this->_totals[ 'rows' ]  += $table[ 'rows' ];
		$this->_totals[ 'total' ] += $table[ 'total' ];
		$this->_totals[ 'tables' ] ++;

		if ( $this->_tables[ $name ][ 'is_wp' ] ) {
			$this->_totals_wp[ 'size' ]  += $table[ 'size' ];
			$this->_totals_wp[ 'free' ]  += $table[ 'free' ];
			$this->_totals_wp[ 'index' ] += $table[ 'index' ];
			$this->_totals_wp[ 'rows' ]  += $table[ 'rows' ];
			$this->_totals_wp[ 'total' ] += $table[ 'total' ];
			$this->_totals_wp[ 'tables' ] ++;
		}
	}

	private function _detect_plugin( string $name ) : string {
		$list = array(
			'actionscheduler' => array(
				$this->_base_prefix . 'actionscheduler_'
			),
			'buddypress'      => array(
				$this->_base_prefix . 'bp_'
			),
			'gravityforms'    => array(
				$this->_base_prefix . 'gf_'
			),
			'gdbbx'           => array(
				$this->_prefix . 'gdbbx_'
			),
			'coreactivity'    => array(
				$this->_base_prefix . 'coreactivity_'
			),
			'coresocial'      => array(
				$this->_prefix . 'coresocial_'
			),
			'gdkob'           => array(
				$this->_prefix . 'gdkob_'
			),
			'gdmaq'           => array(
				$this->_prefix . 'gdmaq_'
			),
			'gdpet'           => array(
				$this->_prefix . 'gdpet_'
			),
			'gdpol'           => array(
				$this->_prefix . 'gdpol_'
			),
			'gdrts'           => array(
				$this->_prefix . 'gdrts_'
			),
			'rankmath'        => array(
				$this->_prefix . 'rank_math_'
			),
			'woocommerce'     => array(
				$this->_prefix . 'actionscheduler_',
				$this->_prefix . 'wc_',
				$this->_prefix . 'woocommerce_'
			),
			'yoast'           => array(
				$this->_prefix . 'yoast_'
			)
		);

		$detected = '';

		foreach ( $list as $plugin => $prefixes ) {
			foreach ( $prefixes as $prefix ) {
				if ( strpos( $name, $prefix ) === 0 ) {
					$detected = $plugin;
					break 2;
				}
			}
		}

		return $detected;
	}

	private function _empty_stats( string $name ) : array {
		return array(
			'table'            => $name,
			'engine'           => '',
			'total'            => 0,
			'size'             => 0,
			'free'             => 0,
			'index'            => 0,
			'rows'             => 0,
			'average_row_size' => 0,
			'auto_increment'   => 0,
			'fragment'         => 0,
			'created'          => '',
			'updated'          => '',
			'collation'        => '',
			'comment'          => '',
			'is_corrupted'     => '',
			'is_wp'            => false,
			'is_wp_blog'       => false,
			'is_wp_global'     => false,
			'is_wp_network'    => false,
			'is_core'          => false,
			'is_non_wp'        => false,
			'wp_table'         => '',
			'detected_plugin'  => '',
			'for_optimization' => false
		);
	}
}
