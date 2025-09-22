<?php
/**
 * CF7 Form Entries Class
 *
 * @package Contact Form 7 Honeypot
 * @since 3.1.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'CF7Apps_Form_Entries' ) ) :
	/**
	 * CF7Apps_Form_Entries class
	 *
	 * @since 3.1.0
	 */
	class CF7Apps_Form_Entries {
		/**
		 * The ID of the form entries.
		 *
		 * @since 3.1.0
		 * @var int $id The ID of the form entries.
		 */
		public $id;

		/**
		 * The name of the form.
		 *
		 * @since 3.1.0
		 * @var int $form_id The ID of the form.
		 */
		public $form_id;

		/**
		 * The name of the form.
		 *
		 * @since 3.1.0
		 * @var string $form_name The name of the form.
		 */
		public $form_name;

		/**
		 * The email address of the user who submitted the form.
		 *
		 * @since 3.1.0
		 * @var string $email The email address of the user who submitted the form.
		 */
		public $email;

		/**
		 * The date and time when the form was submitted.
		 *
		 * @since 3.1.0
		 * @var string $date_time The date and time when the form was submitted.
		 */
		public $date_time;

		/**
		 * The data submitted in the form.
		 *
		 * @since 3.1.0
		 * @var array $data The data submitted in the form.
		 */
		public $data;

		/**
		 * Constructor for the CF7Apps_Form_Entries class.
		 *
		 * @since 3.1.0
		 */
		public function __construct() { }

		/**
		 * Save the form entry to the database.
		 *
		 * @since 3.1.0
		 * @return int
		 */
		public function save() {
			global $wpdb;

			$table_name = $wpdb->prefix . 'cf7apps_form_entries';

			$data = array(
				'form_id'    => $this->form_id,
				'form_name'  => $this->form_name,
				'email'      => $this->email,
				'date_time'  => $this->date_time,
				'data'       => maybe_serialize( $this->data ),
			);

			if ( ! empty( $this->id ) ) {
				$wpdb->update( $table_name, $data, array( 'id' => $this->id ) );
			} else {
				$wpdb->insert( $table_name, $data );

				$this->id = $wpdb->insert_id;
			}

			return $this->id;
		}

		/**
		 * Get all form entries from the database.
		 *
		 * @since 3.1.0
		 * @return self[]
		 */
		public static function get_all_entries( $limit = 10, $offset = 0, $form_id = 0, $search = '', $start_date = 0, $end_date = 0, $args = array() ) {
			global $wpdb;

			$table_name = $wpdb->prefix . 'cf7apps_form_entries';
			$orderby    = isset( $args['orderby'] ) ? $args['orderby'] : 'id';
			$order      = isset( $args['order'] ) ? $args['order'] : 'DESC';
			$limit      = absint( $limit );
			$offset     = absint( $offset );
			$search     = trim( $search );

			$sql = "SELECT * FROM %i";

			$sql .= ' WHERE 1=1 ';

			if ( ! empty( $form_id ) ) {
				$sql .= $wpdb->prepare( ' AND form_id = %d', $form_id );
			}

			if ( ! empty( $search ) ) {
				$search = '%' . $wpdb->esc_like( $search ) . '%';
				$sql    .= $wpdb->prepare( ' AND (form_name LIKE %s OR email LIKE %s)', $search, $search );
			}

			if ( ! empty( $start_date ) && ! empty( $end_date ) ) {
				$sql .= $wpdb->prepare( ' AND `date_time` BETWEEN %d AND %d', $start_date, $end_date );
			} elseif ( ! empty( $start_date ) ) {
				$sql .= $wpdb->prepare( ' AND `date_time` >= %d', $start_date );
			} elseif ( ! empty( $end_date ) ) {
				$sql .= $wpdb->prepare( ' AND `date_time` <= %d', $end_date );
			}

			$sql .= $wpdb->prepare( ' ORDER BY %i ' . $order, $orderby );

			if ( $limit > 0 ) {
				$sql .= $wpdb->prepare( ' LIMIT %d OFFSET %d', $limit, $offset );
			}

			$sql = $wpdb->prepare( $sql, $table_name );

			$results    = $wpdb->get_results(
				$sql,
				ARRAY_A
			);

			if ( ! empty( $results ) ) {

				$results = array_map( array( self::class, 'create_instance' ), $results );
			}

			return $results;
		}

		public static function get_total_entries( $form_id = 0, $search = '', $start_date = 0, $end_date = 0 ) {
			global $wpdb;

			$table_name = $wpdb->prefix . 'cf7apps_form_entries';

			$sql = "SELECT COUNT(*) FROM %i WHERE 1=1";
			if ( ! empty( $form_id ) ) {
				$sql .= $wpdb->prepare( ' AND form_id = %d', $form_id );
			}
			if ( ! empty( $search ) ) {
				$search = '%' . $wpdb->esc_like( $search ) . '%';
				$sql    .= $wpdb->prepare( ' AND (form_name LIKE %s OR email LIKE %s)', $search, $search );
			}

			if ( ! empty( $start_date ) && ! empty( $end_date ) ) {
				$sql .= $wpdb->prepare( ' AND date_time BETWEEN %d AND %d', $start_date, $end_date );
			} elseif ( ! empty( $start_date ) ) {
				$sql .= $wpdb->prepare( ' AND date_time >= %d', $start_date );
			} elseif ( ! empty( $end_date ) ) {
				$sql .= $wpdb->prepare( ' AND date_time <= %d', $end_date );
			}

			$sql = $wpdb->prepare( $sql, $table_name );

			$count      = $wpdb->get_var( $sql );

			return absint( $count );
		}

		/**
		 * Get a form entry by its ID.
		 *
		 * @since 3.1.0
		 * @param int $id The ID of the form entry to retrieve.
		 *
		 * @return self|false
		 */
		public static function get_entry_by_id( $id ) {
			global $wpdb;

			$table_name = $wpdb->prefix . 'cf7apps_form_entries';
			$result     = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM %i WHERE id = %d', $table_name, $id ), ARRAY_A );

			if ( ! empty( $result ) ) {
				return self::create_instance( $result );
			}

			return false;
		}

		/**
		 * Create an instance of the CF7Apps_Form_Entries class from an array of data.
		 *
		 * @since 3.1.0
		 * @param array $data The data to create the instance from.
		 *
		 * @return self
		 */
		public static function create_instance( $data ) {
			$instance = new self();
			$instance->id        = $data['id'];
			$instance->form_id   = $data['form_id'];
			$instance->form_name = $data['form_name'];
			$instance->email     = $data['email'];
			$instance->date_time = date( 'F j, Y h:i a', $data['date_time'] );
			$instance->data      = maybe_unserialize( $data['data'] );

			return $instance;
		}

		/**
		 * Delete the form entry from the database.
		 *
		 * @since 3.1.0
		 * @return true
		 */
		public function destroy() {
			global $wpdb;

			$table_name = $wpdb->prefix . 'cf7apps_form_entries';

			if ( ! empty( $this->id ) ) {
				$wpdb->delete( $table_name, array( 'id' => $this->id ) );
			}

			$this->id        = null;
			$this->form_id   = null;
			$this->form_name = null;
			$this->email     = null;
			$this->date_time = null;
			$this->data      = array();

			return true;
		}

		public static function delete_entry( $id ) {
			$entry = self::get_entry_by_id( $id );

			if ( $entry ) {
				return $entry->destroy();
			}

			return false;
		}

		public static function delete_entries( $ids ) {
			if ( ! is_array( $ids ) ) {
				$ids = array( $ids );
			}

			foreach ( $ids as $id ) {
				self::delete_entry( $id );
			}

			return true;
		}
	}
endif;
