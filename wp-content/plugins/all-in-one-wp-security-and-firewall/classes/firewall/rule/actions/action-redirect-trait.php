<?php
namespace AIOWPS\Firewall;

/**
 * Trait to set the header to redirect
 */
trait Action_Redirect_Trait {
	
	/**
	 * Redirect to the location.
	 *
	 * @var string
	 */
	public $location = '127.0.0.1';
	
	/**
	 * Redirect the rule condition is satisfied.
	 *
	 * @return void
	 */
	public function do_action() {
		header("Location: $this->location");
	}
}
