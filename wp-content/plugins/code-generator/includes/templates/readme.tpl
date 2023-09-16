=== {{plugin_name}} ===
<?php if ( ! empty ( $wpg_contributors ) ) { ?>
Contributors: {{contributors}}
<?php } ?>
<?php if ( ! empty ( $wpg_tags ) ) { ?>
Tags: {{tags}}
<?php } ?>
<?php if ( ! empty ( $wpg_donate_link ) ) { ?>
Donate link: {{donate_link}}
<?php } ?>
<?php if ( ! empty ( $wpg_version_requires_at_least ) ) { ?>
Requires at least: {{version_requires_at_least}}
<?php } ?>
<?php if ( ! empty ( $wpg_version_tested_up_to ) ) { ?>
Tested up to: {{version_tested_up_to}}
<?php } ?>
<?php if ( ! empty ( $wpg_required_php_version ) ) { ?>
Requires PHP: {{required_php_version}}
<?php } ?>
<?php if ( ! empty ( $wpg_version_stable_tag ) ) { ?>
Stable tag: {{version_stable_tag}}
<?php } ?>
<?php if ( ! empty ( $wpg_license ) ) { ?>
License: {{license}}
<?php } ?>
<?php if ( ! empty ( $wpg_license_uri ) ) { ?>
License URI: {{license_uri}}
<?php } ?>
<?php if ( ! empty ( $wpg_short_description ) ) { ?>

{{short_description}}
<?php } ?>
<?php if ( ! empty ( $wpg_long_description ) ) { ?>

== Description ==
{{long_description}}
<?php } ?>
<?php if ( ! empty ( $wpg_installation ) ) { ?>

== Installation ==
{{installation}}
<?php } ?>
<?php if ( ! empty ( $wpg_faq ) ) { ?>

== Frequently Asked Questions ==
{{faq}}
<?php } ?>

== Screenshots ==
<?php if ( ! empty ( $data['wpg_screenshot-1'] ) ) { ?>
1. {{screenshot-1}}
<?php } ?>
<?php if ( ! empty ( $data['wpg_screenshot-2'] ) ) { ?>
2. {{screenshot-2}}
<?php } ?>
<?php if ( ! empty ( $data['wpg_screenshot-3'] ) ) { ?>
3. {{screenshot-3}}
<?php } ?>
<?php if ( ! empty ( $wpg_change_log ) ) { ?>

== Changelog ==
{{change_log}}
<?php } ?>
<?php if ( ! empty ( $wpg_upgrade_notice ) ) { ?>

== Upgrade Notice ==
{{upgrade_notice}}
<?php }
