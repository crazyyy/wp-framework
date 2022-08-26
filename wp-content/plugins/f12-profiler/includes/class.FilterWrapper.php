<?php

namespace f12_profiler\includes {

	use function f12_profiler\f12_profiler;
	use f12_profiler\Profiler;

	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

	/**
	 * Class FilterWrapper
	 * Storing all information of the hook that will be injected
	 * by the new custom function.
	 */
	class FilterWrapper {
		/**
		 * Unique id defined by WordPress
		 */
		private $wp_id = '';
		/**
		 * @var string  This will be the hook we inject. Could either be an existing wordpress hook or alternative an
		 *              custom hook created by the plugin/theme.
		 */
		private $hook_name = '';
		/**
		 * @var string|array  The origin callback function which was implemented by the plugin|theme. it could either be
		 *                    a string or an array with the given object and method of the object.
		 */
		private $callback_function = '';
		/**
		 * @var int the priority of the hook.
		 */
		private $priority = 10;
		/**
		 * @var int the number of arguments accepted by the hook.
		 */
		private $accepted_args = 0;

		/**
		 * HookObject constructor.
		 *
		 * @param string $hook_name
		 * @param string $callback_function
		 * @param int $priority
		 * @param int $accepted_args
		 */
		public function __construct( $wp_id, $hook_name, $callback_function, $priority, $accepted_args ) {
			$this->wp_id             = $wp_id;
			$this->hook_name         = $hook_name;
			$this->priority          = $priority;
			$this->accepted_args     = $accepted_args;
			$this->callback_function = $callback_function;
			/**
			 * First we need to remove the existing hook, this will be replaced with an custom filter.
			 */
			//if($this->callback_function['f12_profiler\f12_profiler'])

			$this->change_origin_target();
			/*if ( ! remove_filter( $hook_name, $callback_function, $priority ) ) {
				echo "FAILED TO REMOVE FUNCTION";
			} else {

				add_filter( $hook_name, array( $this, 'wrapper' ), $priority, $accepted_args );
			}*/
		}

		/**
		 * This will change the origin target function, thats neccessary to ensure that our new hooked
		 * functions will also be removed, otherwise we will create an endless loop.
		 */
		private function change_origin_target() {
			global $wp_filter;

			if ( isset( $wp_filter[ $this->hook_name ]->callbacks[ $this->priority ][ $this->wp_id ] ) ) {
				// check if filter has already been wrapped, if not we add the new filter wrapper
				if(is_object($wp_filter[ $this->hook_name ]->callbacks[ $this->priority ][ $this->wp_id ]['function'])){
					$wp_filter[ $this->hook_name ]->callbacks[$this->priority][ $this->wp_id ] = array( 'function' => array( $this, 'wrapper' ), 'accepted_args' => $this->accepted_args );
				}else{
					if ( ! ( $wp_filter[ $this->hook_name ]->callbacks[ $this->priority ][ $this->wp_id ]['function'][0] instanceof FilterWrapper ) ) {
						$wp_filter[ $this->hook_name ]->callbacks[$this->priority][ $this->wp_id ] = array( 'function' => array( $this, 'wrapper' ), 'accepted_args' => $this->accepted_args );
					}
				}

			}
		}

		/**
		 * Magic _getter function provided by php
		 *
		 * @param string $property the property
		 *
		 * @return null|mixed returns null if the property doesn't exist
		 */
		public function __get( $property ) {
			if ( property_exists( $this, $property ) ) {
				return $this->$property;
			}

			return null;
		}

		/**
		 * The wrapper function. This function will be used to wrap the origin callback within our time measuring method.
		 * To ensure compatibility between filters and actions we always return a value.
		 *
		 * This function will call the origin filter|action and then track the time the function required to complete. After
		 * it will add the time to the class.
		 *
		 * @param mixed ...$args
		 *
		 * @return mixed|string
		 */
		public function wrapper( ...$args ) {
			# update the wordpress hooks, this will ensure that newly added hooks will be matched to the wrapper too.
			Profiler::updateWordpressHooks();

			$num_args   = count( $args );
			$value      = '';
			$time_start = microtime( true );

			// Avoid the array_slice if possible.
			// we used the origin code from wordpress to ensure the same functionality.
			if ( $this->accepted_args == 0 ) {
				$value = call_user_func_array( $this->callback_function, array() );
			} elseif ( $this->accepted_args >= $num_args ) {
				/**
				 * Need to transform the $args array to references to fix the compatibility to
				 * php7.0 and wordpress do_action_ref_array. Therefor we parse the $args array
				 * to an new array and create a reference to the values within the args array and
				 * then pass them to the origin function.
				 */
				$tmp = array();
				foreach ( $args as $key => $value ) {
					$tmp[ $key ] = &$args[ $key ];
				}
				$value = call_user_func_array( $this->callback_function, $tmp );
			} else {
				$value = call_user_func_array( $this->callback_function, array_slice( $args, 0, (int) $this->accepted_args ) );
			}

			$time_end = microtime( true );
			$time     = $time_end - $time_start;

			// Load debug backtrace to get the file / folder
			$debug_stack = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS | DEBUG_BACKTRACE_PROVIDE_OBJECT );
			/**
			 * loop through every stack to find the root of the filter|action.
			 */
			foreach ( $debug_stack as $stack ) {
				if ( isset( $stack['file'] ) ) {
					$stack['file'] = str_replace( "\\", "/", $stack['file'] );
					if ( ( strpos( $stack['file'], 'wp-content/themes' ) || strpos( $stack['file'], 'wp-content/plugins' ) ) ) {
						break;
					}
				}
			}
			if ( ! isset( $stack ) || ! isset( $stack['file'] ) ) {
				return $value;
			}
			/**
			 * Add the time to the found plugin|theme. If not found we use the unknown keyword to track the time.
			 */
			if ( strpos( $stack['file'], 'wp-content/themes/' ) ) {
				// Theme functions
				TimeTracker::add( 'themes', $time );
			} else if ( strpos( $stack['file'], 'wp-content/plugins/' ) ) {
				// Plugin functions
				TimeTracker::add( Helper::get_plugin_name( $stack['file'] ), $time );
			} else {
				// Wordpress Core functions
				TimeTracker::add( 'WordPress Core', $time );
			}

			return $value;
		}
	}
}