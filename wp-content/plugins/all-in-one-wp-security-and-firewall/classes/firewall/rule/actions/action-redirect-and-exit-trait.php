<?php
namespace AIOWPS\Firewall;

/**
 * Combines the redirect and exit trait
 */
trait Action_Redirect_and_Exit_Trait {
	
	use Action_Redirect_Trait, Action_Exit_Trait {
		Action_Redirect_Trait::do_action as protected do_action_redirect;
		Action_Exit_Trait::do_action as protected do_action_exit;
	}

	/**
	 * Redirect and Exit when the rule condition is satisfied.
	 *
	 * @return void
	 */
	public function do_action() {
		$this->do_action_redirect();
		$this->do_action_exit();
	}
}
