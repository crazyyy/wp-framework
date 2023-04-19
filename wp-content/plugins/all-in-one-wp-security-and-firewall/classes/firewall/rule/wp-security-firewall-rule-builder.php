<?php
namespace AIOWPS\Firewall;

/**
 * Builds our rules
 */
class Rule_Builder {

	/**
	 * Gets our rule if it's active
	 *
	 * @return iterable
	 */
	public static function get_active_rule() {

		foreach (self::get_rule_classname() as $classname) {

			$rule = new $classname();

			if (!$rule->is_active()) {
				Event::raise('rule_not_active', $rule, $classname);
				continue;
			}

			Event::raise('rule_active', $rule, $classname);
			yield $rule;
		}
	}

	/**
	 * Generates the classname for each rule
	 *
	 * @return iterable
	 */
	private static function get_rule_classname() {
		$rec_iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(AIOWPS_FIREWALL_DIR.'/rule/rules/', \FilesystemIterator::SKIP_DOTS));

		foreach ($rec_iterator as $dir_iterator) {
			$matches = array();
			if (preg_match('/^rule-(?<rule_name>.*)\.php$/', $dir_iterator->getFilename(), $matches)) {
				yield "AIOWPS\Firewall\Rule_".ucwords(str_replace('-', '_', $matches['rule_name']), '_');
			}
		}
	}

}
