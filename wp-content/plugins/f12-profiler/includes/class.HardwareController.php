<?php

namespace f12_profiler\includes {
	defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

	/**
	 * Class HardwareController
	 * @package f12_profiler\includes
	 */
	class HardwareController {
		/**
		 * @var $_instance HardwareController
		 */
		private static $_instance = null;

		/**
		 * @return HardwareController
		 */
		public static function getInstance() {
			if ( self::$_instance == null ) {
				self::$_instance = new HardwareController();
			}

			return self::$_instance;
		}

		/**
		 * constructor.
		 */
		private function __construct() {
		}

		/**
		 * Get the CPU Usage
		 */
		public function getCPUData() {
			# check if the system is running on windows or linux
			if ( Helper::isWindows() ) {
				# Test if the shell_exec is callable to ensure
				# we can trigger the necessary shell
				if ( Helper::isFunctionEnabled( 'shell_exec' ) ) {
					# We do call the windows shell to get the percentage
					# of the cpu usage as a string: LoadPercentage XX
					$res = shell_exec( 'wmic cpu get LoadPercentage' );
					$res = explode( " ", trim( $res ) );

					if ( is_array( $res ) && isset( $res[2] ) ) {
						return array( $res[2] );
					}
				}
			} else {
				# Use the php function to get the avg load of the system
				if ( Helper::isFunctionEnabled( 'sys_getloadavg' ) ) {
					return sys_getloadavg();
				}
			}

			return null;
		}


		/**
		 * Returns the RAM usage of PHP as MB
		 * @return array
		 */
		public function getRAMUsageByPHP() {
			$mem = memory_get_peak_usage( true ) / 1024 / 1024;

			return array( number_format( $mem, 2 ) );
		}

		/**
		 * Returns the RAM usage of the system as % value
		 * @return array
		 */
		public function getRAMUsagePercentage() {
			# Test if the shell_exec is callable to ensure
			# we can trigger the necessary shell
			if ( Helper::isFunctionEnabled( 'shell_exec' ) ) {

				# check if the system is running on windows or linux
				if ( Helper::isWindows() ) {
					$total = doubleval( $this->getRAMTotal() );
					$usage = doubleval( $this->getRAMUsage()[0] );

					$memory_usage = 100 / $total * $usage;

					return array( number_format( $memory_usage, 2 ) );
				} else {
					# read the shell to get the available amount of memory.
					$free     = shell_exec( 'free' );
					$free     = (string) trim( $free );
					$free_arr = explode( "\n", $free );

					if ( is_array( $free_arr ) && isset( $free_arr[1] ) ) {
						$mem = explode( " ", $free_arr[1] );
						$mem = array_filter( $mem );
						$mem = array_merge( $mem );

						if ( is_array( $mem ) && isset( $mem[1] ) && isset( $mem[2] ) ) {
							$memory_usage = $mem[2] / $mem[1] * 100;


							return array( number_format( $memory_usage, 2 ) );
						}
					}
				}
			}

			return null;
		}

		/**
		 * Get the total amount of memory as GB
		 * @return string
		 */
		public function getRAMTotal() {
			# Test if the shell_exec is callable to ensure
			# we can trigger the necessary shell
			if ( Helper::isFunctionEnabled( 'shell_exec' ) ) {

				# check if the system is running on windows or linux
				if ( Helper::isWindows() ) {

					# read the shell to get all necessary memory. this will return a string
					# containing all memory sticks with the given size.
					$res = shell_exec( 'wmic memorychip get capacity' );
					$res = explode( " ", $res );
					$res = array_sum( $res );

					# return the formatted number in GB
					return number_format( ( $res / 1024 / 1024 / 1024 ), 2 );

				} else {
					# Run the shell on the linux system to get the amount of memory
					$res = shell_exec( 'awk \'/MemTotal/ { print $2 }\' /proc/meminfo' );
					$res = floatval( $res );

					# return the formatted number in GB
					return number_format( ( $res / 1024 / 1024 ), 2 );
				}
			}

			# return null if the shell can't be loaded.
			return null;
		}

		/**
		 * Get the used amount of memory in GB
		 * @return array
		 */
		public function getRAMUsage() {
			# Test if the shell_exec is callable to ensure
			# we can trigger the necessary shell
			if ( Helper::isFunctionEnabled( 'shell_exec' ) ) {

				# check if the system is running on windows or linux
				if ( Helper::isWindows() ) {

					# read the shell to get the available amount of memory. this will return a
					# string with the given format: FreePhysicalMemory=XXX while xxx is the amount
					# of memory available
					$res = shell_exec( 'wmic OS get FreePhysicalMemory /Value' );
					$res = explode( '=', $res );

					if ( is_array( $res ) && isset( $res[1] ) ) {
						# format the memory from byte to gb to be able to calculate the free memory.
						$res   = doubleval( number_format( ( doubleval( $res[1] ) / 1024 / 1024 ), 2 ) );
						$total = doubleval( $this->getRAMTotal() );

						return array( $total - $res );
					}
				} else {
					# read the shell to get the available amount of memory.
					$free     = shell_exec( 'free' );
					$free     = (string) trim( $free );
					$free_arr = explode( "\n", $free );

					if ( is_array( $free_arr ) && isset( $free_arr[1] ) ) {
						$mem = explode( " ", $free_arr[1] );
						$mem = array_filter( $mem );
						$mem = array_merge( $mem );

						if ( is_array( $mem ) && isset( $mem[2] ) ) {
							$used = $mem[2] / 1024 / 1024;


							return array( number_format( $used, 4 ) );
						}
					}
				}
			}

			return null;
		}

		/**
		 * Check if the Hard
		 * @return bool
		 */
		private function isLoaded() {
			if ( Helper::isFunctionEnabled( 'shell_exec' ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Return all Hardware Data as Array
		 * @return array
		 */
		public function getData() {
			return [
				'isLoaded'       => $this->isLoaded(),
				'CPU'            => $this->getCPUData(),
				'RAM_PERCENTAGE' => $this->getRAMUsagePercentage(),
				'RAM_PHP'        => $this->getRAMUsageByPHP(),
				'RAM_TOTAL'      => $this->getRAMTotal(),
				'RAM_USAGE'      => $this->getRAMUsage(),
			];
		}
	}
}