-- --------------------------------------------------------
-- Сервер:                       
-- Версія сервера:               10.11.9-MariaDB-ubu2204-log - mariadb.org binary distribution
-- ОС сервера:                   debian-linux-gnu
-- HeidiSQL Версія:              12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db
CREATE DATABASE IF NOT EXISTS `db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `db`;

-- Dumping structure for таблиця db.hadpj_aiowps_audit_log
CREATE TABLE IF NOT EXISTS `hadpj_aiowps_audit_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `network_id` bigint(20) NOT NULL DEFAULT 0,
  `site_id` bigint(20) NOT NULL DEFAULT 0,
  `username` varchar(60) NOT NULL DEFAULT '',
  `ip` varchar(45) NOT NULL DEFAULT '',
  `level` varchar(25) NOT NULL DEFAULT '',
  `event_type` varchar(25) NOT NULL DEFAULT '',
  `details` text NOT NULL DEFAULT '',
  `stacktrace` text NOT NULL DEFAULT '',
  `created` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `ip` (`ip`),
  KEY `level` (`level`),
  KEY `event_type` (`event_type`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table db.hadpj_aiowps_audit_log: ~5 rows (приблизно)
DELETE FROM `hadpj_aiowps_audit_log`;
INSERT INTO `hadpj_aiowps_audit_log` (`id`, `network_id`, `site_id`, `username`, `ip`, `level`, `event_type`, `details`, `stacktrace`, `created`) VALUES
	(1, 1, 1, 'aparserok', '127.0.0.1', 'info', 'theme_updated', 'Theme: Twenty Twenty-One  updated (v1.8)', 'a:10:{i:0;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:308;s:8:"function";s:12:"record_event";s:5:"class";s:33:"AIOWPSecurity_Audit_Event_Handler";s:4:"type";s:2:"->";s:4:"args";a:3:{i:0;s:13:"theme_updated";i:1;s:40:"Theme: Twenty Twenty-One  updated (v1.8)";i:2;s:4:"info";}}i:1;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:332;s:8:"function";s:13:"apply_filters";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:2:{i:0;s:0:"";i:1;a:3:{i:0;s:13:"theme_updated";i:1;s:40:"Theme: Twenty Twenty-One  updated (v1.8)";i:2;s:4:"info";}}}i:2;a:6:{s:4:"file";s:48:"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php";s:4:"line";i:517;s:8:"function";s:9:"do_action";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:1:{i:0;s:0:"";}}i:3;a:4:{s:4:"file";s:117:"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php";s:4:"line";i:285;s:8:"function";s:9:"do_action";s:4:"args";a:4:{i:0;s:19:"aiowps_record_event";i:1;s:13:"theme_updated";i:2;s:40:"Theme: Twenty Twenty-One  updated (v1.8)";i:3;s:4:"info";}}i:4;a:6:{s:4:"file";s:117:"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php";s:4:"line";i:227;s:8:"function";s:19:"event_theme_changed";s:5:"class";s:26:"AIOWPSecurity_Audit_Events";s:4:"type";s:2:"::";s:4:"args";a:3:{i:0;s:7:"updated";i:1;s:15:"twentytwentyone";i:2;s:0:"";}}i:5;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:308;s:8:"function";s:13:"theme_updated";s:5:"class";s:26:"AIOWPSecurity_Audit_Events";s:4:"type";s:2:"::";s:4:"args";a:1:{i:0;s:14:"Theme_Upgrader";}}i:6;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:332;s:8:"function";s:13:"apply_filters";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:1:{i:0;s:0:"";}}i:7;a:6:{s:4:"file";s:48:"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php";s:4:"line";i:517;s:8:"function";s:9:"do_action";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:1:{i:0;s:0:"";}}i:8;a:4:{s:4:"file";s:68:"C:\\Works\\Web\\wp-framework\\wp-admin\\includes\\class-theme-upgrader.php";s:4:"line";i:472;s:8:"function";s:9:"do_action";s:4:"args";a:3:{i:0;s:25:"upgrader_process_complete";i:1;O:14:"Theme_Upgrader":7:{s:6:"result";a:7:{s:6:"source";s:81:"C:/Works/Web/wp-framework/wp-content/upgrade/twentytwentytwo.1.4/twentytwentytwo/";s:12:"source_files";a:11:{i:0;s:6:"assets";i:1;s:13:"functions.php";i:2;s:3:"inc";i:3;s:9:"index.php";i:4;s:5:"parts";i:5;s:10:"readme.txt";i:6;s:14:"screenshot.png";i:7;s:9:"style.css";i:8;s:6:"styles";i:9;s:9:"templates";i:10;s:10:"theme.json";}s:11:"destination";s:60:"C:\\Works\\Web\\wp-framework/wp-content/themes/twentytwentytwo/";s:16:"destination_name";s:15:"twentytwentytwo";s:17:"local_destination";s:43:"C:\\Works\\Web\\wp-framework/wp-content/themes";s:18:"remote_destination";s:60:"C:/Works/Web/wp-framework/wp-content/themes/twentytwentytwo/";s:17:"clear_destination";b:1;}s:4:"bulk";b:1;s:14:"new_theme_data";a:0:{}s:7:"strings";a:31:{s:18:"skin_upgrade_start";s:98:"The update process is starting. This process may take a while on some hosts, so please be patient.";s:24:"skin_update_failed_error";s:43:"An error occurred while updating %1$s: %2$s";s:18:"skin_update_failed";s:24:"The update of %s failed.";s:22:"skin_update_successful";s:24:"%s updated successfully.";s:16:"skin_upgrade_end";s:32:"All updates have been completed.";s:25:"skin_before_update_header";s:31:"Updating Theme %1$s (%2$d/%3$d)";s:11:"bad_request";s:22:"Invalid data provided.";s:14:"fs_unavailable";s:28:"Could not access filesystem.";s:8:"fs_error";s:17:"Filesystem error.";s:14:"fs_no_root_dir";s:42:"Unable to locate WordPress root directory.";s:17:"fs_no_content_dir";s:58:"Unable to locate WordPress content directory (wp-content).";s:17:"fs_no_plugins_dir";s:44:"Unable to locate WordPress plugin directory.";s:16:"fs_no_themes_dir";s:43:"Unable to locate WordPress theme directory.";s:12:"fs_no_folder";s:36:"Unable to locate needed folder (%s).";s:15:"download_failed";s:16:"Download failed.";s:18:"installing_package";s:36:"Installing the latest version&#8230;";s:8:"no_files";s:30:"The package contains no files.";s:13:"folder_exists";s:34:"Destination folder already exists.";s:12:"mkdir_failed";s:27:"Could not create directory.";s:20:"incompatible_archive";s:35:"The package could not be installed.";s:18:"files_not_writable";s:124:"The update cannot be installed because some files could not be copied. This is usually due to inconsistent file permissions.";s:17:"maintenance_start";s:32:"Enabling Maintenance mode&#8230;";s:15:"maintenance_end";s:33:"Disabling Maintenance mode&#8230;";s:10:"up_to_date";s:35:"The theme is at the latest version.";s:10:"no_package";s:29:"Update package not available.";s:19:"downloading_package";s:59:"Downloading update from <span class="code">%s</span>&#8230;";s:14:"unpack_package";s:27:"Unpacking the update&#8230;";s:10:"remove_old";s:44:"Removing the old version of the theme&#8230;";s:17:"remove_old_failed";s:31:"Could not remove the old theme.";s:14:"process_failed";s:20:"Theme update failed.";s:15:"process_success";s:27:"Theme updated successfully.";}s:4:"skin";O:24:"Bulk_Theme_Upgrader_Skin":8:{s:10:"theme_info";O:8:"WP_Theme":13:{s:6:"update";b:0;s:20:"\0WP_Theme\0theme_root";s:43:"C:\\Works\\Web\\wp-framework/wp-content/themes";s:17:"\0WP_Theme\0headers";a:14:{s:4:"Name";s:17:"Twenty Twenty-Two";s:8:"ThemeURI";s:45:"https://wordpress.org/themes/twentytwentytwo/";s:11:"Description";s:939:"Built on a solidly designed foundation, Twenty Twenty-Two embraces the idea that everyone deserves a truly unique website. The theme’s subtle styles are inspired by the diversity and versatility of birds: its typography is lightweight yet strong, its color palette is drawn from nature, and its layout elements sit gently on the page. The true richness of Twenty Twenty-Two lies in its opportunity for customization. The theme is built to take advantage of the Full Site Editing features introduced in WordPress 5.9, which means that colors, typography, and the layout of every single page on your site can be customized to suit your vision. It also includes dozens of block patterns, opening the door to a wide range of professionally designed layouts in just a few clicks. Whether you’re building a single-page website, a blog, a business website, or a portfolio, Twenty Twenty-Two will help you create a site that is uniquely yours.";s:6:"Author";s:18:"the WordPress team";s:9:"AuthorURI";s:22:"https://wordpress.org/";s:7:"Version";s:3:"1.2";s:8:"Template";s:0:"";s:6:"Status";s:0:"";s:4:"Tags";s:171:"one-column, custom-colors, custom-menu, custom-logo, editor-style, featured-images, full-site-editing, block-patterns, rtl-language-support, sticky-post, threaded-comments";s:10:"TextDomain";s:15:"twentytwentytwo";s:10:"DomainPath";s:0:"";s:10:"RequiresWP";s:3:"5.9";s:11:"RequiresPHP";s:3:"5.6";s:9:"UpdateURI";s:0:"";}s:27:"\0WP_Theme\0headers_sanitized";a:3:{s:4:"Name";s:17:"Twenty Twenty-Two";s:10:"TextDomain";s:15:"twentytwentytwo";s:10:"DomainPath";s:0:"";}s:21:"\0WP_Theme\0block_theme";b:1;s:25:"\0WP_Theme\0name_translated";N;s:16:"\0WP_Theme\0errors";N;s:20:"\0WP_Theme\0stylesheet";s:15:"twentytwentytwo";s:18:"\0WP_Theme\0template";s:15:"twentytwentytwo";s:16:"\0WP_Theme\0parent";N;s:24:"\0WP_Theme\0theme_root_uri";N;s:27:"\0WP_Theme\0textdomain_loaded";b:0;s:20:"\0WP_Theme\0cache_hash";s:32:"0feca0ad8dfdb6266c757e92676771ed";}s:7:"in_loop";b:0;s:5:"error";b:0;s:8:"upgrader";r:81;s:11:"done_header";b:0;s:11:"done_footer";b:0;s:6:"result";a:7:{s:6:"source";s:81:"C:/Works/Web/wp-framework/wp-content/upgrade/twentytwentytwo.1.4/twentytwentytwo/";s:12:"source_files";a:11:{i:0;s:6:"assets";i:1;s:13:"functions.php";i:2;s:3:"inc";i:3;s:9:"index.php";i:4;s:5:"parts";i:5;s:10:"readme.txt";i:6;s:14:"screenshot.png";i:7;s:9:"style.css";i:8;s:6:"styles";i:9;s:9:"templates";i:10;s:10:"theme.json";}s:11:"destination";s:60:"C:\\Works\\Web\\wp-framework/wp-content/themes/twentytwentytwo/";s:16:"destination_name";s:15:"twentytwentytwo";s:17:"local_destination";s:43:"C:\\Works\\Web\\wp-framework/wp-content/themes";s:18:"remote_destination";s:60:"C:/Works/Web/wp-framework/wp-content/themes/twentytwentytwo/";s:17:"clear_destination";b:1;}s:7:"options";a:4:{s:3:"url";s:85:"update.php?action=update-selected-themes&amp;themes=twentytwentyone%2Ctwentytwentytwo";s:5:"nonce";s:18:"bulk-update-themes";s:5:"title";s:0:"";s:7:"context";b:0;}}s:12:"update_count";i:2;s:14:"update_current";i:2;}i:2;a:4:{s:6:"action";s:6:"update";s:4:"type";s:5:"theme";s:4:"bulk";b:1;s:6:"themes";a:2:{i:0;s:15:"twentytwentyone";i:1;s:15:"twentytwentytwo";}}}}i:9;a:6:{s:4:"file";s:45:"C:\\Works\\Web\\wp-framework\\wp-admin\\update.php";s:4:"line";i:252;s:8:"function";s:12:"bulk_upgrade";s:5:"class";s:14:"Theme_Upgrader";s:4:"type";s:2:"->";s:4:"args";a:1:{i:0;s:0:"";}}}', 1681885020),
	(2, 1, 1, 'aparserok', '127.0.0.1', 'warning', 'plugin_deleted', 'Plugin: ACF 5 Pro JSON Storage  deleted (v1.0.0)', 'a:14:{i:0;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:308;s:8:"function";s:12:"record_event";s:5:"class";s:33:"AIOWPSecurity_Audit_Event_Handler";s:4:"type";s:2:"->";s:4:"args";a:3:{i:0;s:14:"plugin_deleted";i:1;s:48:"Plugin: ACF 5 Pro JSON Storage  deleted (v1.0.0)";i:2;s:7:"warning";}}i:1;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:332;s:8:"function";s:13:"apply_filters";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:2:{i:0;s:0:"";i:1;a:3:{i:0;s:14:"plugin_deleted";i:1;s:48:"Plugin: ACF 5 Pro JSON Storage  deleted (v1.0.0)";i:2;s:7:"warning";}}}i:2;a:6:{s:4:"file";s:48:"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php";s:4:"line";i:517;s:8:"function";s:9:"do_action";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:1:{i:0;s:0:"";}}i:3;a:4:{s:4:"file";s:117:"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php";s:4:"line";i:183;s:8:"function";s:9:"do_action";s:4:"args";a:4:{i:0;s:19:"aiowps_record_event";i:1;s:14:"plugin_deleted";i:2;s:48:"Plugin: ACF 5 Pro JSON Storage  deleted (v1.0.0)";i:3;s:7:"warning";}}i:4;a:6:{s:4:"file";s:117:"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php";s:4:"line";i:155;s:8:"function";s:20:"event_plugin_changed";s:5:"class";s:26:"AIOWPSecurity_Audit_Events";s:4:"type";s:2:"::";s:4:"args";a:4:{i:0;s:7:"deleted";i:1;s:45:"acf-5-pro-json-storage/acf-5-json-storage.php";i:2;s:0:"";i:3;s:7:"warning";}}i:5;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:308;s:8:"function";s:14:"plugin_deleted";s:5:"class";s:26:"AIOWPSecurity_Audit_Events";s:4:"type";s:2:"::";s:4:"args";a:2:{i:0;s:45:"acf-5-pro-json-storage/acf-5-json-storage.php";i:1;b:1;}}i:6;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:332;s:8:"function";s:13:"apply_filters";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:2:{i:0;s:0:"";i:1;a:2:{i:0;s:45:"acf-5-pro-json-storage/acf-5-json-storage.php";i:1;b:1;}}}i:7;a:6:{s:4:"file";s:48:"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php";s:4:"line";i:517;s:8:"function";s:9:"do_action";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:1:{i:0;s:0:"";}}i:8;a:4:{s:4:"file";s:54:"C:\\Works\\Web\\wp-framework\\wp-admin\\includes\\plugin.php";s:4:"line";i:988;s:8:"function";s:9:"do_action";s:4:"args";a:3:{i:0;s:14:"deleted_plugin";i:1;s:45:"acf-5-pro-json-storage/acf-5-json-storage.php";i:2;b:1;}}i:9;a:4:{s:4:"file";s:60:"C:\\Works\\Web\\wp-framework\\wp-admin\\includes\\ajax-actions.php";s:4:"line";i:4701;s:8:"function";s:14:"delete_plugins";s:4:"args";a:1:{i:0;s:0:"";}}i:10;a:4:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:308;s:8:"function";s:21:"wp_ajax_delete_plugin";s:4:"args";a:1:{i:0;s:0:"";}}i:11;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:332;s:8:"function";s:13:"apply_filters";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:2:{i:0;s:0:"";i:1;a:1:{i:0;s:0:"";}}}i:12;a:6:{s:4:"file";s:48:"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php";s:4:"line";i:517;s:8:"function";s:9:"do_action";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:1:{i:0;s:0:"";}}i:13;a:4:{s:4:"file";s:49:"C:\\Works\\Web\\wp-framework\\wp-admin\\admin-ajax.php";s:4:"line";i:188;s:8:"function";s:9:"do_action";s:4:"args";a:1:{i:0;s:21:"wp_ajax_delete-plugin";}}}', 1681885624),
	(3, 1, 1, 'aparserok', '127.0.0.1', 'info', 'plugin_activated', 'Plugin: Advanced Custom Fields PRO  activated (v5.12.3)', 'a:10:{i:0;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:308;s:8:"function";s:12:"record_event";s:5:"class";s:33:"AIOWPSecurity_Audit_Event_Handler";s:4:"type";s:2:"->";s:4:"args";a:3:{i:0;s:16:"plugin_activated";i:1;s:55:"Plugin: Advanced Custom Fields PRO  activated (v5.12.3)";i:2;s:4:"info";}}i:1;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:332;s:8:"function";s:13:"apply_filters";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:2:{i:0;s:0:"";i:1;a:3:{i:0;s:16:"plugin_activated";i:1;s:55:"Plugin: Advanced Custom Fields PRO  activated (v5.12.3)";i:2;s:4:"info";}}}i:2;a:6:{s:4:"file";s:48:"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php";s:4:"line";i:517;s:8:"function";s:9:"do_action";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:1:{i:0;s:0:"";}}i:3;a:4:{s:4:"file";s:117:"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php";s:4:"line";i:183;s:8:"function";s:9:"do_action";s:4:"args";a:4:{i:0;s:19:"aiowps_record_event";i:1;s:16:"plugin_activated";i:2;s:55:"Plugin: Advanced Custom Fields PRO  activated (v5.12.3)";i:3;s:4:"info";}}i:4;a:6:{s:4:"file";s:117:"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php";s:4:"line";i:98;s:8:"function";s:20:"event_plugin_changed";s:5:"class";s:26:"AIOWPSecurity_Audit_Events";s:4:"type";s:2:"::";s:4:"args";a:3:{i:0;s:9:"activated";i:1;s:34:"advanced-custom-fields-pro/acf.php";i:2;s:0:"";}}i:5;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:308;s:8:"function";s:16:"plugin_activated";s:5:"class";s:26:"AIOWPSecurity_Audit_Events";s:4:"type";s:2:"::";s:4:"args";a:2:{i:0;s:34:"advanced-custom-fields-pro/acf.php";i:1;b:0;}}i:6;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:332;s:8:"function";s:13:"apply_filters";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:2:{i:0;s:0:"";i:1;a:2:{i:0;s:34:"advanced-custom-fields-pro/acf.php";i:1;b:0;}}}i:7;a:6:{s:4:"file";s:48:"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php";s:4:"line";i:517;s:8:"function";s:9:"do_action";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:1:{i:0;s:0:"";}}i:8;a:4:{s:4:"file";s:54:"C:\\Works\\Web\\wp-framework\\wp-admin\\includes\\plugin.php";s:4:"line";i:718;s:8:"function";s:9:"do_action";s:4:"args";a:3:{i:0;s:16:"activated_plugin";i:1;s:34:"advanced-custom-fields-pro/acf.php";i:2;b:0;}}i:9;a:4:{s:4:"file";s:46:"C:\\Works\\Web\\wp-framework\\wp-admin\\plugins.php";s:4:"line";i:58;s:8:"function";s:15:"activate_plugin";s:4:"args";a:3:{i:0;s:34:"advanced-custom-fields-pro/acf.php";i:1;s:98:"https://wpeb.ddev.site/wp-admin/plugins.php?error=true&plugin=advanced-custom-fields-pro%2Facf.php";i:2;b:0;}}}', 1681885627),
	(4, 1, 1, 'aparserok', '127.0.0.1', 'warning', 'plugin_deleted', 'Plugin: Akismet Anti-Spam: Spam Protection  deleted (v5.1)', 'a:14:{i:0;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:308;s:8:"function";s:12:"record_event";s:5:"class";s:33:"AIOWPSecurity_Audit_Event_Handler";s:4:"type";s:2:"->";s:4:"args";a:3:{i:0;s:14:"plugin_deleted";i:1;s:58:"Plugin: Akismet Anti-Spam: Spam Protection  deleted (v5.1)";i:2;s:7:"warning";}}i:1;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:332;s:8:"function";s:13:"apply_filters";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:2:{i:0;s:0:"";i:1;a:3:{i:0;s:14:"plugin_deleted";i:1;s:58:"Plugin: Akismet Anti-Spam: Spam Protection  deleted (v5.1)";i:2;s:7:"warning";}}}i:2;a:6:{s:4:"file";s:48:"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php";s:4:"line";i:517;s:8:"function";s:9:"do_action";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:1:{i:0;s:0:"";}}i:3;a:4:{s:4:"file";s:117:"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php";s:4:"line";i:183;s:8:"function";s:9:"do_action";s:4:"args";a:4:{i:0;s:19:"aiowps_record_event";i:1;s:14:"plugin_deleted";i:2;s:58:"Plugin: Akismet Anti-Spam: Spam Protection  deleted (v5.1)";i:3;s:7:"warning";}}i:4;a:6:{s:4:"file";s:117:"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php";s:4:"line";i:155;s:8:"function";s:20:"event_plugin_changed";s:5:"class";s:26:"AIOWPSecurity_Audit_Events";s:4:"type";s:2:"::";s:4:"args";a:4:{i:0;s:7:"deleted";i:1;s:19:"akismet/akismet.php";i:2;s:0:"";i:3;s:7:"warning";}}i:5;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:308;s:8:"function";s:14:"plugin_deleted";s:5:"class";s:26:"AIOWPSecurity_Audit_Events";s:4:"type";s:2:"::";s:4:"args";a:2:{i:0;s:19:"akismet/akismet.php";i:1;b:1;}}i:6;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:332;s:8:"function";s:13:"apply_filters";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:2:{i:0;s:0:"";i:1;a:2:{i:0;s:19:"akismet/akismet.php";i:1;b:1;}}}i:7;a:6:{s:4:"file";s:48:"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php";s:4:"line";i:517;s:8:"function";s:9:"do_action";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:1:{i:0;s:0:"";}}i:8;a:4:{s:4:"file";s:54:"C:\\Works\\Web\\wp-framework\\wp-admin\\includes\\plugin.php";s:4:"line";i:988;s:8:"function";s:9:"do_action";s:4:"args";a:3:{i:0;s:14:"deleted_plugin";i:1;s:19:"akismet/akismet.php";i:2;b:1;}}i:9;a:4:{s:4:"file";s:60:"C:\\Works\\Web\\wp-framework\\wp-admin\\includes\\ajax-actions.php";s:4:"line";i:4701;s:8:"function";s:14:"delete_plugins";s:4:"args";a:1:{i:0;s:0:"";}}i:10;a:4:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:308;s:8:"function";s:21:"wp_ajax_delete_plugin";s:4:"args";a:1:{i:0;s:0:"";}}i:11;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:332;s:8:"function";s:13:"apply_filters";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:2:{i:0;s:0:"";i:1;a:1:{i:0;s:0:"";}}}i:12;a:6:{s:4:"file";s:48:"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php";s:4:"line";i:517;s:8:"function";s:9:"do_action";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:1:{i:0;s:0:"";}}i:13;a:4:{s:4:"file";s:49:"C:\\Works\\Web\\wp-framework\\wp-admin\\admin-ajax.php";s:4:"line";i:188;s:8:"function";s:9:"do_action";s:4:"args";a:1:{i:0;s:21:"wp_ajax_delete-plugin";}}}', 1681885636),
	(5, 1, 1, 'aparserok', '127.0.0.1', 'warning', 'plugin_deactivated', 'Plugin: All In One WP Security  deactivated (v5.1.7)', 'a:10:{i:0;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:308;s:8:"function";s:12:"record_event";s:5:"class";s:33:"AIOWPSecurity_Audit_Event_Handler";s:4:"type";s:2:"->";s:4:"args";a:3:{i:0;s:18:"plugin_deactivated";i:1;s:52:"Plugin: All In One WP Security  deactivated (v5.1.7)";i:2;s:7:"warning";}}i:1;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:332;s:8:"function";s:13:"apply_filters";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:2:{i:0;s:0:"";i:1;a:3:{i:0;s:18:"plugin_deactivated";i:1;s:52:"Plugin: All In One WP Security  deactivated (v5.1.7)";i:2;s:7:"warning";}}}i:2;a:6:{s:4:"file";s:48:"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php";s:4:"line";i:517;s:8:"function";s:9:"do_action";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:1:{i:0;s:0:"";}}i:3;a:4:{s:4:"file";s:117:"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php";s:4:"line";i:183;s:8:"function";s:9:"do_action";s:4:"args";a:4:{i:0;s:19:"aiowps_record_event";i:1;s:18:"plugin_deactivated";i:2;s:52:"Plugin: All In One WP Security  deactivated (v5.1.7)";i:3;s:7:"warning";}}i:4;a:6:{s:4:"file";s:117:"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php";s:4:"line";i:129;s:8:"function";s:20:"event_plugin_changed";s:5:"class";s:26:"AIOWPSecurity_Audit_Events";s:4:"type";s:2:"::";s:4:"args";a:4:{i:0;s:11:"deactivated";i:1;s:51:"all-in-one-wp-security-and-firewall/wp-security.php";i:2;s:0:"";i:3;s:7:"warning";}}i:5;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:308;s:8:"function";s:18:"plugin_deactivated";s:5:"class";s:26:"AIOWPSecurity_Audit_Events";s:4:"type";s:2:"::";s:4:"args";a:2:{i:0;s:51:"all-in-one-wp-security-and-firewall/wp-security.php";i:1;b:0;}}i:6;a:6:{s:4:"file";s:55:"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php";s:4:"line";i:332;s:8:"function";s:13:"apply_filters";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:2:{i:0;s:0:"";i:1;a:2:{i:0;s:51:"all-in-one-wp-security-and-firewall/wp-security.php";i:1;b:0;}}}i:7;a:6:{s:4:"file";s:48:"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php";s:4:"line";i:517;s:8:"function";s:9:"do_action";s:5:"class";s:7:"WP_Hook";s:4:"type";s:2:"->";s:4:"args";a:1:{i:0;s:0:"";}}i:8;a:4:{s:4:"file";s:54:"C:\\Works\\Web\\wp-framework\\wp-admin\\includes\\plugin.php";s:4:"line";i:828;s:8:"function";s:9:"do_action";s:4:"args";a:3:{i:0;s:18:"deactivated_plugin";i:1;s:51:"all-in-one-wp-security-and-firewall/wp-security.php";i:2;b:0;}}i:9;a:4:{s:4:"file";s:46:"C:\\Works\\Web\\wp-framework\\wp-admin\\plugins.php";s:4:"line";i:209;s:8:"function";s:18:"deactivate_plugins";s:4:"args";a:3:{i:0;s:51:"all-in-one-wp-security-and-firewall/wp-security.php";i:1;b:0;i:2;b:0;}}}', 1681885642);

-- Dumping structure for таблиця db.hadpj_aiowps_debug_log
CREATE TABLE IF NOT EXISTS `hadpj_aiowps_debug_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `level` varchar(25) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `type` varchar(25) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table db.hadpj_aiowps_debug_log: ~0 rows (приблизно)
DELETE FROM `hadpj_aiowps_debug_log`;

-- Dumping structure for таблиця db.hadpj_aiowps_events
CREATE TABLE IF NOT EXISTS `hadpj_aiowps_events` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `event_type` varchar(150) NOT NULL DEFAULT '',
  `username` varchar(150) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `event_date` datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
  `ip_or_host` varchar(100) DEFAULT NULL,
  `referer_info` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `event_data` longtext DEFAULT NULL,
  `country_code` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db.hadpj_aiowps_events: ~0 rows (приблизно)
DELETE FROM `hadpj_aiowps_events`;

-- Dumping structure for таблиця db.hadpj_aiowps_failed_logins
CREATE TABLE IF NOT EXISTS `hadpj_aiowps_failed_logins` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `user_login` varchar(150) NOT NULL,
  `failed_login_date` datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
  `login_attempt_ip` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `failed_login_date` (`failed_login_date`),
  KEY `login_attempt_ip` (`login_attempt_ip`),
  KEY `failed_login_date_and_login_attempt_ip` (`failed_login_date`,`login_attempt_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db.hadpj_aiowps_failed_logins: ~0 rows (приблизно)
DELETE FROM `hadpj_aiowps_failed_logins`;

-- Dumping structure for таблиця db.hadpj_aiowps_global_meta
CREATE TABLE IF NOT EXISTS `hadpj_aiowps_global_meta` (
  `meta_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date_time` datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
  `meta_key1` varchar(255) NOT NULL,
  `meta_key2` varchar(255) NOT NULL,
  `meta_key3` varchar(255) NOT NULL,
  `meta_key4` varchar(255) NOT NULL,
  `meta_key5` varchar(255) NOT NULL,
  `meta_value1` varchar(255) NOT NULL,
  `meta_value2` text NOT NULL,
  `meta_value3` text NOT NULL,
  `meta_value4` longtext NOT NULL,
  `meta_value5` longtext NOT NULL,
  PRIMARY KEY (`meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table db.hadpj_aiowps_global_meta: ~0 rows (приблизно)
DELETE FROM `hadpj_aiowps_global_meta`;

-- Dumping structure for таблиця db.hadpj_aiowps_login_activity
CREATE TABLE IF NOT EXISTS `hadpj_aiowps_login_activity` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `user_login` varchar(150) NOT NULL,
  `login_date` datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
  `logout_date` datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
  `login_ip` varchar(100) NOT NULL DEFAULT '',
  `login_country` varchar(150) NOT NULL DEFAULT '',
  `browser_type` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db.hadpj_aiowps_login_activity: ~3 rows (приблизно)
DELETE FROM `hadpj_aiowps_login_activity`;
INSERT INTO `hadpj_aiowps_login_activity` (`id`, `user_id`, `user_login`, `login_date`, `logout_date`, `login_ip`, `login_country`, `browser_type`) VALUES
	(1, 2, 'aparserok', '2022-08-03 08:51:58', '1000-10-10 10:00:00', '127.0.0.1', '', ''),
	(2, 2, 'aparserok', '2022-08-25 20:37:58', '1000-10-10 10:00:00', '195.34.204.242', '', ''),
	(3, 2, 'aparserok', '2023-04-19 08:55:24', '1000-10-10 10:00:00', '178.74.236.195', '', '');

-- Dumping structure for таблиця db.hadpj_aiowps_login_lockdown
CREATE TABLE IF NOT EXISTS `hadpj_aiowps_login_lockdown` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `user_login` varchar(150) NOT NULL,
  `lockdown_date` datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
  `release_date` datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
  `failed_login_ip` varchar(100) NOT NULL DEFAULT '',
  `unlock_key` varchar(128) NOT NULL,
  `lock_reason` varchar(128) NOT NULL DEFAULT '',
  `is_lockout_email_sent` tinyint(1) NOT NULL DEFAULT 1,
  `backtrace_log` text NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `failed_login_ip` (`failed_login_ip`),
  KEY `is_lockout_email_sent` (`is_lockout_email_sent`),
  KEY `unlock_key` (`unlock_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db.hadpj_aiowps_login_lockdown: ~0 rows (приблизно)
DELETE FROM `hadpj_aiowps_login_lockdown`;

-- Dumping structure for таблиця db.hadpj_aiowps_permanent_block
CREATE TABLE IF NOT EXISTS `hadpj_aiowps_permanent_block` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `blocked_ip` varchar(100) NOT NULL DEFAULT '',
  `block_reason` varchar(128) NOT NULL DEFAULT '',
  `country_origin` varchar(50) NOT NULL DEFAULT '',
  `blocked_date` datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
  `unblock` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `blocked_ip` (`blocked_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db.hadpj_aiowps_permanent_block: ~0 rows (приблизно)
DELETE FROM `hadpj_aiowps_permanent_block`;

-- Dumping structure for таблиця db.hadpj_commentmeta
CREATE TABLE IF NOT EXISTS `hadpj_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`meta_key`,`comment_id`,`meta_id`),
  UNIQUE KEY `meta_id` (`meta_id`),
  KEY `comment_id` (`comment_id`,`meta_key`,`meta_value`(32)),
  KEY `meta_value` (`meta_value`(32))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db.hadpj_commentmeta: ~0 rows (приблизно)
DELETE FROM `hadpj_commentmeta`;

-- Dumping structure for таблиця db.hadpj_comments
CREATE TABLE IF NOT EXISTS `hadpj_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT 0,
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT 0,
  `comment_approved` varchar(20) NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_type` varchar(20) NOT NULL DEFAULT 'comment',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT 0,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`comment_post_ID`,`comment_ID`),
  UNIQUE KEY `comment_ID` (`comment_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`,`comment_ID`),
  KEY `comment_date_gmt` (`comment_date_gmt`,`comment_ID`),
  KEY `comment_parent` (`comment_parent`,`comment_ID`),
  KEY `comment_author_email` (`comment_author_email`,`comment_post_ID`,`comment_ID`),
  KEY `comment_post_parent_approved` (`comment_post_ID`,`comment_parent`,`comment_approved`,`comment_type`,`user_id`,`comment_date_gmt`,`comment_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db.hadpj_comments: ~0 rows (приблизно)
DELETE FROM `hadpj_comments`;

-- Dumping structure for таблиця db.hadpj_db7_forms
CREATE TABLE IF NOT EXISTS `hadpj_db7_forms` (
  `form_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `form_post_id` bigint(20) NOT NULL,
  `form_value` longtext NOT NULL,
  `form_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db.hadpj_db7_forms: ~0 rows (приблизно)
DELETE FROM `hadpj_db7_forms`;

-- Dumping structure for таблиця db.hadpj_links
CREATE TABLE IF NOT EXISTS `hadpj_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_image` varchar(255) NOT NULL DEFAULT '',
  `link_target` varchar(25) NOT NULL DEFAULT '',
  `link_description` varchar(255) NOT NULL DEFAULT '',
  `link_visible` varchar(20) NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) unsigned NOT NULL DEFAULT 1,
  `link_rating` int(11) NOT NULL DEFAULT 0,
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) NOT NULL DEFAULT '',
  `link_notes` mediumtext NOT NULL,
  `link_rss` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db.hadpj_links: ~0 rows (приблизно)
DELETE FROM `hadpj_links`;

-- Dumping structure for таблиця db.hadpj_options
CREATE TABLE IF NOT EXISTS `hadpj_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) NOT NULL,
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_name`),
  UNIQUE KEY `option_id` (`option_id`),
  KEY `autoload` (`autoload`)
) ENGINE=InnoDB AUTO_INCREMENT=3003 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db.hadpj_options: ~407 rows (приблизно)
DELETE FROM `hadpj_options`;
INSERT INTO `hadpj_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
	(2995, '_site_transient_available_translations', 'a:131:{s:2:"af";a:8:{s:8:"language";s:2:"af";s:7:"version";s:8:"5.8-beta";s:7:"updated";s:19:"2021-05-13 15:59:22";s:12:"english_name";s:9:"Afrikaans";s:11:"native_name";s:9:"Afrikaans";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/5.8-beta/af.zip";s:3:"iso";a:2:{i:1;s:2:"af";i:2;s:3:"afr";}s:7:"strings";a:1:{s:8:"continue";s:10:"Gaan voort";}}s:2:"am";a:8:{s:8:"language";s:2:"am";s:7:"version";s:5:"6.0.9";s:7:"updated";s:19:"2022-09-29 20:43:49";s:12:"english_name";s:7:"Amharic";s:11:"native_name";s:12:"አማርኛ";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.0.9/am.zip";s:3:"iso";a:2:{i:1;s:2:"am";i:2;s:3:"amh";}s:7:"strings";a:1:{s:8:"continue";s:9:"ቀጥል";}}s:3:"arg";a:8:{s:8:"language";s:3:"arg";s:7:"version";s:8:"6.2-beta";s:7:"updated";s:19:"2022-09-22 16:46:56";s:12:"english_name";s:9:"Aragonese";s:11:"native_name";s:9:"Aragonés";s:7:"package";s:65:"https://downloads.wordpress.org/translation/core/6.2-beta/arg.zip";s:3:"iso";a:3:{i:1;s:2:"an";i:2;s:3:"arg";i:3;s:3:"arg";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continar";}}s:2:"ar";a:8:{s:8:"language";s:2:"ar";s:7:"version";s:5:"6.4.5";s:7:"updated";s:19:"2024-02-13 12:49:38";s:12:"english_name";s:6:"Arabic";s:11:"native_name";s:14:"العربية";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.4.5/ar.zip";s:3:"iso";a:2:{i:1;s:2:"ar";i:2;s:3:"ara";}s:7:"strings";a:1:{s:8:"continue";s:12:"متابعة";}}s:3:"ary";a:8:{s:8:"language";s:3:"ary";s:7:"version";s:6:"4.8.25";s:7:"updated";s:19:"2017-01-26 15:42:35";s:12:"english_name";s:15:"Moroccan Arabic";s:11:"native_name";s:31:"العربية المغربية";s:7:"package";s:63:"https://downloads.wordpress.org/translation/core/4.8.25/ary.zip";s:3:"iso";a:2:{i:1;s:2:"ar";i:3;s:3:"ary";}s:7:"strings";a:1:{s:8:"continue";s:16:"المتابعة";}}s:2:"as";a:8:{s:8:"language";s:2:"as";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-16 07:55:52";s:12:"english_name";s:8:"Assamese";s:11:"native_name";s:21:"অসমীয়া";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/as.zip";s:3:"iso";a:3:{i:1;s:2:"as";i:2;s:3:"asm";i:3;s:3:"asm";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continue";}}s:3:"azb";a:8:{s:8:"language";s:3:"azb";s:7:"version";s:5:"6.4.5";s:7:"updated";s:19:"2024-01-19 08:58:31";s:12:"english_name";s:17:"South Azerbaijani";s:11:"native_name";s:29:"گؤنئی آذربایجان";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/6.4.5/azb.zip";s:3:"iso";a:2:{i:1;s:2:"az";i:3;s:3:"azb";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continue";}}s:2:"az";a:8:{s:8:"language";s:2:"az";s:7:"version";s:5:"4.7.2";s:7:"updated";s:19:"2016-11-06 00:09:27";s:12:"english_name";s:11:"Azerbaijani";s:11:"native_name";s:16:"Azərbaycan dili";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.7.2/az.zip";s:3:"iso";a:2:{i:1;s:2:"az";i:2;s:3:"aze";}s:7:"strings";a:1:{s:8:"continue";s:5:"Davam";}}s:3:"bel";a:8:{s:8:"language";s:3:"bel";s:7:"version";s:6:"4.9.26";s:7:"updated";s:19:"2019-10-29 07:54:22";s:12:"english_name";s:10:"Belarusian";s:11:"native_name";s:29:"Беларуская мова";s:7:"package";s:63:"https://downloads.wordpress.org/translation/core/4.9.26/bel.zip";s:3:"iso";a:2:{i:1;s:2:"be";i:2;s:3:"bel";}s:7:"strings";a:1:{s:8:"continue";s:20:"Працягнуць";}}s:5:"bg_BG";a:8:{s:8:"language";s:5:"bg_BG";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-17 11:39:48";s:12:"english_name";s:9:"Bulgarian";s:11:"native_name";s:18:"Български";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/bg_BG.zip";s:3:"iso";a:2:{i:1;s:2:"bg";i:2;s:3:"bul";}s:7:"strings";a:1:{s:8:"continue";s:12:"Напред";}}s:5:"bn_BD";a:8:{s:8:"language";s:5:"bn_BD";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-21 11:26:40";s:12:"english_name";s:20:"Bengali (Bangladesh)";s:11:"native_name";s:15:"বাংলা";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/bn_BD.zip";s:3:"iso";a:1:{i:1;s:2:"bn";}s:7:"strings";a:1:{s:8:"continue";s:28:"চালিয়ে যান";}}s:2:"bo";a:8:{s:8:"language";s:2:"bo";s:7:"version";s:8:"5.8-beta";s:7:"updated";s:19:"2020-10-30 03:24:38";s:12:"english_name";s:7:"Tibetan";s:11:"native_name";s:21:"བོད་ཡིག";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/5.8-beta/bo.zip";s:3:"iso";a:2:{i:1;s:2:"bo";i:2;s:3:"tib";}s:7:"strings";a:1:{s:8:"continue";s:33:"མུ་མཐུད་དུ།";}}s:5:"bs_BA";a:8:{s:8:"language";s:5:"bs_BA";s:7:"version";s:5:"6.2.6";s:7:"updated";s:19:"2023-02-22 20:45:53";s:12:"english_name";s:7:"Bosnian";s:11:"native_name";s:8:"Bosanski";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.2.6/bs_BA.zip";s:3:"iso";a:2:{i:1;s:2:"bs";i:2;s:3:"bos";}s:7:"strings";a:1:{s:8:"continue";s:7:"Nastavi";}}s:2:"ca";a:8:{s:8:"language";s:2:"ca";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-01 20:31:35";s:12:"english_name";s:7:"Catalan";s:11:"native_name";s:7:"Català";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/ca.zip";s:3:"iso";a:2:{i:1;s:2:"ca";i:2;s:3:"cat";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continua";}}s:3:"ceb";a:8:{s:8:"language";s:3:"ceb";s:7:"version";s:5:"4.7.2";s:7:"updated";s:19:"2016-03-02 17:25:51";s:12:"english_name";s:7:"Cebuano";s:11:"native_name";s:7:"Cebuano";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/4.7.2/ceb.zip";s:3:"iso";a:2:{i:2;s:3:"ceb";i:3;s:3:"ceb";}s:7:"strings";a:1:{s:8:"continue";s:7:"Padayun";}}s:5:"cs_CZ";a:8:{s:8:"language";s:5:"cs_CZ";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-07-23 09:49:04";s:12:"english_name";s:5:"Czech";s:11:"native_name";s:9:"Čeština";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/cs_CZ.zip";s:3:"iso";a:2:{i:1;s:2:"cs";i:2;s:3:"ces";}s:7:"strings";a:1:{s:8:"continue";s:11:"Pokračovat";}}s:2:"cy";a:8:{s:8:"language";s:2:"cy";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-08-14 17:44:28";s:12:"english_name";s:5:"Welsh";s:11:"native_name";s:7:"Cymraeg";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/cy.zip";s:3:"iso";a:2:{i:1;s:2:"cy";i:2;s:3:"cym";}s:7:"strings";a:1:{s:8:"continue";s:6:"Parhau";}}s:5:"da_DK";a:8:{s:8:"language";s:5:"da_DK";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-27 09:32:19";s:12:"english_name";s:6:"Danish";s:11:"native_name";s:5:"Dansk";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/da_DK.zip";s:3:"iso";a:2:{i:1;s:2:"da";i:2;s:3:"dan";}s:7:"strings";a:1:{s:8:"continue";s:8:"Fortsæt";}}s:14:"de_CH_informal";a:8:{s:8:"language";s:14:"de_CH_informal";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-07-29 10:55:35";s:12:"english_name";s:30:"German (Switzerland, Informal)";s:11:"native_name";s:21:"Deutsch (Schweiz, Du)";s:7:"package";s:73:"https://downloads.wordpress.org/translation/core/6.6.2/de_CH_informal.zip";s:3:"iso";a:1:{i:1;s:2:"de";}s:7:"strings";a:1:{s:8:"continue";s:6:"Weiter";}}s:5:"de_CH";a:8:{s:8:"language";s:5:"de_CH";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-07-29 10:55:14";s:12:"english_name";s:20:"German (Switzerland)";s:11:"native_name";s:17:"Deutsch (Schweiz)";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/de_CH.zip";s:3:"iso";a:1:{i:1;s:2:"de";}s:7:"strings";a:1:{s:8:"continue";s:6:"Weiter";}}s:5:"de_DE";a:8:{s:8:"language";s:5:"de_DE";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-12 12:21:36";s:12:"english_name";s:6:"German";s:11:"native_name";s:7:"Deutsch";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/de_DE.zip";s:3:"iso";a:1:{i:1;s:2:"de";}s:7:"strings";a:1:{s:8:"continue";s:6:"Weiter";}}s:5:"de_AT";a:8:{s:8:"language";s:5:"de_AT";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-08-16 07:47:37";s:12:"english_name";s:16:"German (Austria)";s:11:"native_name";s:21:"Deutsch (Österreich)";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/de_AT.zip";s:3:"iso";a:1:{i:1;s:2:"de";}s:7:"strings";a:1:{s:8:"continue";s:6:"Weiter";}}s:12:"de_DE_formal";a:8:{s:8:"language";s:12:"de_DE_formal";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-12 12:21:12";s:12:"english_name";s:15:"German (Formal)";s:11:"native_name";s:13:"Deutsch (Sie)";s:7:"package";s:71:"https://downloads.wordpress.org/translation/core/6.6.2/de_DE_formal.zip";s:3:"iso";a:1:{i:1;s:2:"de";}s:7:"strings";a:1:{s:8:"continue";s:6:"Weiter";}}s:3:"dsb";a:8:{s:8:"language";s:3:"dsb";s:7:"version";s:5:"6.2.6";s:7:"updated";s:19:"2022-07-16 12:13:09";s:12:"english_name";s:13:"Lower Sorbian";s:11:"native_name";s:16:"Dolnoserbšćina";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/6.2.6/dsb.zip";s:3:"iso";a:2:{i:2;s:3:"dsb";i:3;s:3:"dsb";}s:7:"strings";a:1:{s:8:"continue";s:5:"Dalej";}}s:3:"dzo";a:8:{s:8:"language";s:3:"dzo";s:7:"version";s:5:"4.7.2";s:7:"updated";s:19:"2016-06-29 08:59:03";s:12:"english_name";s:8:"Dzongkha";s:11:"native_name";s:18:"རྫོང་ཁ";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/4.7.2/dzo.zip";s:3:"iso";a:2:{i:1;s:2:"dz";i:2;s:3:"dzo";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continue";}}s:2:"el";a:8:{s:8:"language";s:2:"el";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-27 05:54:01";s:12:"english_name";s:5:"Greek";s:11:"native_name";s:16:"Ελληνικά";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/el.zip";s:3:"iso";a:2:{i:1;s:2:"el";i:2;s:3:"ell";}s:7:"strings";a:1:{s:8:"continue";s:16:"Συνέχεια";}}s:5:"en_NZ";a:8:{s:8:"language";s:5:"en_NZ";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-17 01:52:04";s:12:"english_name";s:21:"English (New Zealand)";s:11:"native_name";s:21:"English (New Zealand)";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/en_NZ.zip";s:3:"iso";a:3:{i:1;s:2:"en";i:2;s:3:"eng";i:3;s:3:"eng";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continue";}}s:5:"en_GB";a:8:{s:8:"language";s:5:"en_GB";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-08-13 21:41:14";s:12:"english_name";s:12:"English (UK)";s:11:"native_name";s:12:"English (UK)";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/en_GB.zip";s:3:"iso";a:3:{i:1;s:2:"en";i:2;s:3:"eng";i:3;s:3:"eng";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continue";}}s:5:"en_AU";a:8:{s:8:"language";s:5:"en_AU";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-17 01:27:38";s:12:"english_name";s:19:"English (Australia)";s:11:"native_name";s:19:"English (Australia)";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/en_AU.zip";s:3:"iso";a:3:{i:1;s:2:"en";i:2;s:3:"eng";i:3;s:3:"eng";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continue";}}s:5:"en_ZA";a:8:{s:8:"language";s:5:"en_ZA";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-08-23 06:54:09";s:12:"english_name";s:22:"English (South Africa)";s:11:"native_name";s:22:"English (South Africa)";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/en_ZA.zip";s:3:"iso";a:3:{i:1;s:2:"en";i:2;s:3:"eng";i:3;s:3:"eng";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continue";}}s:5:"en_CA";a:8:{s:8:"language";s:5:"en_CA";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-02 16:47:50";s:12:"english_name";s:16:"English (Canada)";s:11:"native_name";s:16:"English (Canada)";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/en_CA.zip";s:3:"iso";a:3:{i:1;s:2:"en";i:2;s:3:"eng";i:3;s:3:"eng";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continue";}}s:2:"eo";a:8:{s:8:"language";s:2:"eo";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-17 16:02:45";s:12:"english_name";s:9:"Esperanto";s:11:"native_name";s:9:"Esperanto";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/eo.zip";s:3:"iso";a:2:{i:1;s:2:"eo";i:2;s:3:"epo";}s:7:"strings";a:1:{s:8:"continue";s:8:"Daŭrigi";}}s:5:"es_ES";a:8:{s:8:"language";s:5:"es_ES";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-11 22:54:09";s:12:"english_name";s:15:"Spanish (Spain)";s:11:"native_name";s:8:"Español";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/es_ES.zip";s:3:"iso";a:3:{i:1;s:2:"es";i:2;s:3:"spa";i:3;s:3:"spa";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"es_AR";a:8:{s:8:"language";s:5:"es_AR";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-08-28 23:24:21";s:12:"english_name";s:19:"Spanish (Argentina)";s:11:"native_name";s:21:"Español de Argentina";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/es_AR.zip";s:3:"iso";a:3:{i:1;s:2:"es";i:2;s:3:"spa";i:3;s:3:"spa";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"es_MX";a:8:{s:8:"language";s:5:"es_MX";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-08-14 13:29:14";s:12:"english_name";s:16:"Spanish (Mexico)";s:11:"native_name";s:19:"Español de México";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/es_MX.zip";s:3:"iso";a:3:{i:1;s:2:"es";i:2;s:3:"spa";i:3;s:3:"spa";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"es_CR";a:8:{s:8:"language";s:5:"es_CR";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-23 16:36:30";s:12:"english_name";s:20:"Spanish (Costa Rica)";s:11:"native_name";s:22:"Español de Costa Rica";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/es_CR.zip";s:3:"iso";a:3:{i:1;s:2:"es";i:2;s:3:"spa";i:3;s:3:"spa";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"es_CO";a:8:{s:8:"language";s:5:"es_CO";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-08-16 19:05:01";s:12:"english_name";s:18:"Spanish (Colombia)";s:11:"native_name";s:20:"Español de Colombia";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/es_CO.zip";s:3:"iso";a:3:{i:1;s:2:"es";i:2;s:3:"spa";i:3;s:3:"spa";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"es_CL";a:8:{s:8:"language";s:5:"es_CL";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-20 23:44:51";s:12:"english_name";s:15:"Spanish (Chile)";s:11:"native_name";s:17:"Español de Chile";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/es_CL.zip";s:3:"iso";a:3:{i:1;s:2:"es";i:2;s:3:"spa";i:3;s:3:"spa";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"es_VE";a:8:{s:8:"language";s:5:"es_VE";s:7:"version";s:5:"6.4.5";s:7:"updated";s:19:"2023-10-16 16:00:04";s:12:"english_name";s:19:"Spanish (Venezuela)";s:11:"native_name";s:21:"Español de Venezuela";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.4.5/es_VE.zip";s:3:"iso";a:3:{i:1;s:2:"es";i:2;s:3:"spa";i:3;s:3:"spa";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"es_EC";a:8:{s:8:"language";s:5:"es_EC";s:7:"version";s:5:"6.2.6";s:7:"updated";s:19:"2023-04-21 13:32:10";s:12:"english_name";s:17:"Spanish (Ecuador)";s:11:"native_name";s:19:"Español de Ecuador";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.2.6/es_EC.zip";s:3:"iso";a:3:{i:1;s:2:"es";i:2;s:3:"spa";i:3;s:3:"spa";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"es_DO";a:8:{s:8:"language";s:5:"es_DO";s:7:"version";s:6:"5.8.10";s:7:"updated";s:19:"2021-10-08 14:32:50";s:12:"english_name";s:28:"Spanish (Dominican Republic)";s:11:"native_name";s:33:"Español de República Dominicana";s:7:"package";s:65:"https://downloads.wordpress.org/translation/core/5.8.10/es_DO.zip";s:3:"iso";a:3:{i:1;s:2:"es";i:2;s:3:"spa";i:3;s:3:"spa";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"es_UY";a:8:{s:8:"language";s:5:"es_UY";s:7:"version";s:8:"5.8-beta";s:7:"updated";s:19:"2021-03-31 18:33:26";s:12:"english_name";s:17:"Spanish (Uruguay)";s:11:"native_name";s:19:"Español de Uruguay";s:7:"package";s:67:"https://downloads.wordpress.org/translation/core/5.8-beta/es_UY.zip";s:3:"iso";a:3:{i:1;s:2:"es";i:2;s:3:"spa";i:3;s:3:"spa";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"es_PR";a:8:{s:8:"language";s:5:"es_PR";s:7:"version";s:6:"5.4.16";s:7:"updated";s:19:"2020-04-29 15:36:59";s:12:"english_name";s:21:"Spanish (Puerto Rico)";s:11:"native_name";s:23:"Español de Puerto Rico";s:7:"package";s:65:"https://downloads.wordpress.org/translation/core/5.4.16/es_PR.zip";s:3:"iso";a:3:{i:1;s:2:"es";i:2;s:3:"spa";i:3;s:3:"spa";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"es_GT";a:8:{s:8:"language";s:5:"es_GT";s:7:"version";s:6:"5.2.21";s:7:"updated";s:19:"2019-03-02 06:35:01";s:12:"english_name";s:19:"Spanish (Guatemala)";s:11:"native_name";s:21:"Español de Guatemala";s:7:"package";s:65:"https://downloads.wordpress.org/translation/core/5.2.21/es_GT.zip";s:3:"iso";a:3:{i:1;s:2:"es";i:2;s:3:"spa";i:3;s:3:"spa";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"es_PE";a:8:{s:8:"language";s:5:"es_PE";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-16 21:04:12";s:12:"english_name";s:14:"Spanish (Peru)";s:11:"native_name";s:17:"Español de Perú";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/es_PE.zip";s:3:"iso";a:3:{i:1;s:2:"es";i:2;s:3:"spa";i:3;s:3:"spa";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:2:"et";a:8:{s:8:"language";s:2:"et";s:7:"version";s:5:"6.5.5";s:7:"updated";s:19:"2024-06-06 09:50:37";s:12:"english_name";s:8:"Estonian";s:11:"native_name";s:5:"Eesti";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.5.5/et.zip";s:3:"iso";a:2:{i:1;s:2:"et";i:2;s:3:"est";}s:7:"strings";a:1:{s:8:"continue";s:6:"Jätka";}}s:2:"eu";a:8:{s:8:"language";s:2:"eu";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-10 00:15:35";s:12:"english_name";s:6:"Basque";s:11:"native_name";s:7:"Euskara";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/eu.zip";s:3:"iso";a:2:{i:1;s:2:"eu";i:2;s:3:"eus";}s:7:"strings";a:1:{s:8:"continue";s:8:"Jarraitu";}}s:5:"fa_IR";a:8:{s:8:"language";s:5:"fa_IR";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-13 09:15:26";s:12:"english_name";s:7:"Persian";s:11:"native_name";s:10:"فارسی";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/fa_IR.zip";s:3:"iso";a:2:{i:1;s:2:"fa";i:2;s:3:"fas";}s:7:"strings";a:1:{s:8:"continue";s:10:"ادامه";}}s:5:"fa_AF";a:8:{s:8:"language";s:5:"fa_AF";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-06-20 17:15:28";s:12:"english_name";s:21:"Persian (Afghanistan)";s:11:"native_name";s:31:"(فارسی (افغانستان";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/fa_AF.zip";s:3:"iso";a:2:{i:1;s:2:"fa";i:2;s:3:"fas";}s:7:"strings";a:1:{s:8:"continue";s:10:"ادامه";}}s:2:"fi";a:8:{s:8:"language";s:2:"fi";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-23 07:22:41";s:12:"english_name";s:7:"Finnish";s:11:"native_name";s:5:"Suomi";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/fi.zip";s:3:"iso";a:2:{i:1;s:2:"fi";i:2;s:3:"fin";}s:7:"strings";a:1:{s:8:"continue";s:5:"Jatka";}}s:5:"fr_CA";a:8:{s:8:"language";s:5:"fr_CA";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-30 11:36:50";s:12:"english_name";s:15:"French (Canada)";s:11:"native_name";s:19:"Français du Canada";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/fr_CA.zip";s:3:"iso";a:2:{i:1;s:2:"fr";i:2;s:3:"fra";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuer";}}s:5:"fr_BE";a:8:{s:8:"language";s:5:"fr_BE";s:7:"version";s:5:"6.5.5";s:7:"updated";s:19:"2024-02-01 23:56:53";s:12:"english_name";s:16:"French (Belgium)";s:11:"native_name";s:21:"Français de Belgique";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.5.5/fr_BE.zip";s:3:"iso";a:2:{i:1;s:2:"fr";i:2;s:3:"fra";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuer";}}s:5:"fr_FR";a:8:{s:8:"language";s:5:"fr_FR";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-27 09:59:26";s:12:"english_name";s:15:"French (France)";s:11:"native_name";s:9:"Français";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/fr_FR.zip";s:3:"iso";a:1:{i:1;s:2:"fr";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuer";}}s:3:"fur";a:8:{s:8:"language";s:3:"fur";s:7:"version";s:6:"4.8.25";s:7:"updated";s:19:"2023-04-30 13:56:46";s:12:"english_name";s:8:"Friulian";s:11:"native_name";s:8:"Friulian";s:7:"package";s:63:"https://downloads.wordpress.org/translation/core/4.8.25/fur.zip";s:3:"iso";a:2:{i:2;s:3:"fur";i:3;s:3:"fur";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continue";}}s:2:"fy";a:8:{s:8:"language";s:2:"fy";s:7:"version";s:5:"6.2.6";s:7:"updated";s:19:"2022-12-25 12:53:23";s:12:"english_name";s:7:"Frisian";s:11:"native_name";s:5:"Frysk";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.2.6/fy.zip";s:3:"iso";a:2:{i:1;s:2:"fy";i:2;s:3:"fry";}s:7:"strings";a:1:{s:8:"continue";s:9:"Trochgean";}}s:2:"gd";a:8:{s:8:"language";s:2:"gd";s:7:"version";s:5:"4.7.2";s:7:"updated";s:19:"2016-08-23 17:41:37";s:12:"english_name";s:15:"Scottish Gaelic";s:11:"native_name";s:9:"Gàidhlig";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.7.2/gd.zip";s:3:"iso";a:3:{i:1;s:2:"gd";i:2;s:3:"gla";i:3;s:3:"gla";}s:7:"strings";a:1:{s:8:"continue";s:15:"Lean air adhart";}}s:5:"gl_ES";a:8:{s:8:"language";s:5:"gl_ES";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-16 15:56:34";s:12:"english_name";s:8:"Galician";s:11:"native_name";s:6:"Galego";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/gl_ES.zip";s:3:"iso";a:2:{i:1;s:2:"gl";i:2;s:3:"glg";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:2:"gu";a:8:{s:8:"language";s:2:"gu";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-17 13:34:33";s:12:"english_name";s:8:"Gujarati";s:11:"native_name";s:21:"ગુજરાતી";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/gu.zip";s:3:"iso";a:2:{i:1;s:2:"gu";i:2;s:3:"guj";}s:7:"strings";a:1:{s:8:"continue";s:25:"ચાલુ રાખો";}}s:3:"haz";a:8:{s:8:"language";s:3:"haz";s:7:"version";s:6:"4.4.33";s:7:"updated";s:19:"2015-12-05 00:59:09";s:12:"english_name";s:8:"Hazaragi";s:11:"native_name";s:15:"هزاره گی";s:7:"package";s:63:"https://downloads.wordpress.org/translation/core/4.4.33/haz.zip";s:3:"iso";a:1:{i:3;s:3:"haz";}s:7:"strings";a:1:{s:8:"continue";s:10:"ادامه";}}s:5:"he_IL";a:8:{s:8:"language";s:5:"he_IL";s:7:"version";s:5:"6.2.6";s:7:"updated";s:19:"2024-05-04 18:39:24";s:12:"english_name";s:6:"Hebrew";s:11:"native_name";s:16:"עִבְרִית";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.2.6/he_IL.zip";s:3:"iso";a:1:{i:1;s:2:"he";}s:7:"strings";a:1:{s:8:"continue";s:8:"המשך";}}s:5:"hi_IN";a:8:{s:8:"language";s:5:"hi_IN";s:7:"version";s:5:"6.4.5";s:7:"updated";s:19:"2024-02-25 08:05:38";s:12:"english_name";s:5:"Hindi";s:11:"native_name";s:18:"हिन्दी";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.4.5/hi_IN.zip";s:3:"iso";a:2:{i:1;s:2:"hi";i:2;s:3:"hin";}s:7:"strings";a:1:{s:8:"continue";s:25:"जारी रखें";}}s:2:"hr";a:8:{s:8:"language";s:2:"hr";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-08-24 18:18:49";s:12:"english_name";s:8:"Croatian";s:11:"native_name";s:8:"Hrvatski";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/hr.zip";s:3:"iso";a:2:{i:1;s:2:"hr";i:2;s:3:"hrv";}s:7:"strings";a:1:{s:8:"continue";s:7:"Nastavi";}}s:3:"hsb";a:8:{s:8:"language";s:3:"hsb";s:7:"version";s:5:"6.2.6";s:7:"updated";s:19:"2023-02-22 17:37:32";s:12:"english_name";s:13:"Upper Sorbian";s:11:"native_name";s:17:"Hornjoserbšćina";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/6.2.6/hsb.zip";s:3:"iso";a:2:{i:2;s:3:"hsb";i:3;s:3:"hsb";}s:7:"strings";a:1:{s:8:"continue";s:4:"Dale";}}s:5:"hu_HU";a:8:{s:8:"language";s:5:"hu_HU";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-17 15:50:39";s:12:"english_name";s:9:"Hungarian";s:11:"native_name";s:6:"Magyar";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/hu_HU.zip";s:3:"iso";a:2:{i:1;s:2:"hu";i:2;s:3:"hun";}s:7:"strings";a:1:{s:8:"continue";s:10:"Folytatás";}}s:2:"hy";a:8:{s:8:"language";s:2:"hy";s:7:"version";s:5:"4.7.2";s:7:"updated";s:19:"2016-12-03 16:21:10";s:12:"english_name";s:8:"Armenian";s:11:"native_name";s:14:"Հայերեն";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.7.2/hy.zip";s:3:"iso";a:2:{i:1;s:2:"hy";i:2;s:3:"hye";}s:7:"strings";a:1:{s:8:"continue";s:20:"Շարունակել";}}s:5:"id_ID";a:8:{s:8:"language";s:5:"id_ID";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-22 16:54:41";s:12:"english_name";s:10:"Indonesian";s:11:"native_name";s:16:"Bahasa Indonesia";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/id_ID.zip";s:3:"iso";a:2:{i:1;s:2:"id";i:2;s:3:"ind";}s:7:"strings";a:1:{s:8:"continue";s:9:"Lanjutkan";}}s:5:"is_IS";a:8:{s:8:"language";s:5:"is_IS";s:7:"version";s:6:"4.9.26";s:7:"updated";s:19:"2018-12-11 10:40:02";s:12:"english_name";s:9:"Icelandic";s:11:"native_name";s:9:"Íslenska";s:7:"package";s:65:"https://downloads.wordpress.org/translation/core/4.9.26/is_IS.zip";s:3:"iso";a:2:{i:1;s:2:"is";i:2;s:3:"isl";}s:7:"strings";a:1:{s:8:"continue";s:6:"Áfram";}}s:5:"it_IT";a:8:{s:8:"language";s:5:"it_IT";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-17 09:31:39";s:12:"english_name";s:7:"Italian";s:11:"native_name";s:8:"Italiano";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/it_IT.zip";s:3:"iso";a:2:{i:1;s:2:"it";i:2;s:3:"ita";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continua";}}s:2:"ja";a:8:{s:8:"language";s:2:"ja";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-08-15 07:15:06";s:12:"english_name";s:8:"Japanese";s:11:"native_name";s:9:"日本語";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/ja.zip";s:3:"iso";a:1:{i:1;s:2:"ja";}s:7:"strings";a:1:{s:8:"continue";s:6:"次へ";}}s:5:"jv_ID";a:8:{s:8:"language";s:5:"jv_ID";s:7:"version";s:6:"4.9.26";s:7:"updated";s:19:"2019-02-16 23:58:56";s:12:"english_name";s:8:"Javanese";s:11:"native_name";s:9:"Basa Jawa";s:7:"package";s:65:"https://downloads.wordpress.org/translation/core/4.9.26/jv_ID.zip";s:3:"iso";a:2:{i:1;s:2:"jv";i:2;s:3:"jav";}s:7:"strings";a:1:{s:8:"continue";s:9:"Nerusaké";}}s:5:"ka_GE";a:8:{s:8:"language";s:5:"ka_GE";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-07-12 07:15:01";s:12:"english_name";s:8:"Georgian";s:11:"native_name";s:21:"ქართული";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/ka_GE.zip";s:3:"iso";a:2:{i:1;s:2:"ka";i:2;s:3:"kat";}s:7:"strings";a:1:{s:8:"continue";s:30:"გაგრძელება";}}s:3:"kab";a:8:{s:8:"language";s:3:"kab";s:7:"version";s:5:"6.2.6";s:7:"updated";s:19:"2023-07-05 11:40:39";s:12:"english_name";s:6:"Kabyle";s:11:"native_name";s:9:"Taqbaylit";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/6.2.6/kab.zip";s:3:"iso";a:2:{i:2;s:3:"kab";i:3;s:3:"kab";}s:7:"strings";a:1:{s:8:"continue";s:6:"Kemmel";}}s:2:"kk";a:8:{s:8:"language";s:2:"kk";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-07-18 02:49:24";s:12:"english_name";s:6:"Kazakh";s:11:"native_name";s:19:"Қазақ тілі";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/kk.zip";s:3:"iso";a:2:{i:1;s:2:"kk";i:2;s:3:"kaz";}s:7:"strings";a:1:{s:8:"continue";s:20:"Жалғастыру";}}s:2:"km";a:8:{s:8:"language";s:2:"km";s:7:"version";s:6:"5.2.21";s:7:"updated";s:19:"2019-06-10 16:18:28";s:12:"english_name";s:5:"Khmer";s:11:"native_name";s:27:"ភាសាខ្មែរ";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/5.2.21/km.zip";s:3:"iso";a:2:{i:1;s:2:"km";i:2;s:3:"khm";}s:7:"strings";a:1:{s:8:"continue";s:12:"បន្ត";}}s:2:"kn";a:8:{s:8:"language";s:2:"kn";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-18 15:21:55";s:12:"english_name";s:7:"Kannada";s:11:"native_name";s:15:"ಕನ್ನಡ";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/kn.zip";s:3:"iso";a:2:{i:1;s:2:"kn";i:2;s:3:"kan";}s:7:"strings";a:1:{s:8:"continue";s:30:"ಮುಂದುವರಿಸು";}}s:5:"ko_KR";a:8:{s:8:"language";s:5:"ko_KR";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-14 13:16:53";s:12:"english_name";s:6:"Korean";s:11:"native_name";s:9:"한국어";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/ko_KR.zip";s:3:"iso";a:2:{i:1;s:2:"ko";i:2;s:3:"kor";}s:7:"strings";a:1:{s:8:"continue";s:6:"계속";}}s:3:"ckb";a:8:{s:8:"language";s:3:"ckb";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-08-24 01:25:58";s:12:"english_name";s:16:"Kurdish (Sorani)";s:11:"native_name";s:13:"كوردی‎";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/6.6.2/ckb.zip";s:3:"iso";a:2:{i:1;s:2:"ku";i:3;s:3:"ckb";}s:7:"strings";a:1:{s:8:"continue";s:30:"به‌رده‌وام به‌";}}s:3:"kir";a:8:{s:8:"language";s:3:"kir";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-20 18:29:58";s:12:"english_name";s:6:"Kyrgyz";s:11:"native_name";s:16:"Кыргызча";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/6.6.2/kir.zip";s:3:"iso";a:3:{i:1;s:2:"ky";i:2;s:3:"kir";i:3;s:3:"kir";}s:7:"strings";a:1:{s:8:"continue";s:14:"Улантуу";}}s:2:"lo";a:8:{s:8:"language";s:2:"lo";s:7:"version";s:5:"4.7.2";s:7:"updated";s:19:"2016-11-12 09:59:23";s:12:"english_name";s:3:"Lao";s:11:"native_name";s:21:"ພາສາລາວ";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.7.2/lo.zip";s:3:"iso";a:2:{i:1;s:2:"lo";i:2;s:3:"lao";}s:7:"strings";a:1:{s:8:"continue";s:18:"ຕໍ່​ໄປ";}}s:5:"lt_LT";a:8:{s:8:"language";s:5:"lt_LT";s:7:"version";s:5:"6.5.5";s:7:"updated";s:19:"2024-06-13 13:11:03";s:12:"english_name";s:10:"Lithuanian";s:11:"native_name";s:15:"Lietuvių kalba";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.5.5/lt_LT.zip";s:3:"iso";a:2:{i:1;s:2:"lt";i:2;s:3:"lit";}s:7:"strings";a:1:{s:8:"continue";s:6:"Tęsti";}}s:2:"lv";a:8:{s:8:"language";s:2:"lv";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-06-20 17:21:01";s:12:"english_name";s:7:"Latvian";s:11:"native_name";s:16:"Latviešu valoda";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/lv.zip";s:3:"iso";a:2:{i:1;s:2:"lv";i:2;s:3:"lav";}s:7:"strings";a:1:{s:8:"continue";s:9:"Turpināt";}}s:5:"mk_MK";a:8:{s:8:"language";s:5:"mk_MK";s:7:"version";s:5:"6.0.9";s:7:"updated";s:19:"2022-10-01 09:23:52";s:12:"english_name";s:10:"Macedonian";s:11:"native_name";s:31:"Македонски јазик";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.0.9/mk_MK.zip";s:3:"iso";a:2:{i:1;s:2:"mk";i:2;s:3:"mkd";}s:7:"strings";a:1:{s:8:"continue";s:16:"Продолжи";}}s:5:"ml_IN";a:8:{s:8:"language";s:5:"ml_IN";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-05 15:57:37";s:12:"english_name";s:9:"Malayalam";s:11:"native_name";s:18:"മലയാളം";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/ml_IN.zip";s:3:"iso";a:2:{i:1;s:2:"ml";i:2;s:3:"mal";}s:7:"strings";a:1:{s:8:"continue";s:18:"തുടരുക";}}s:2:"mn";a:8:{s:8:"language";s:2:"mn";s:7:"version";s:5:"6.5.5";s:7:"updated";s:19:"2024-06-20 17:22:06";s:12:"english_name";s:9:"Mongolian";s:11:"native_name";s:12:"Монгол";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.5.5/mn.zip";s:3:"iso";a:2:{i:1;s:2:"mn";i:2;s:3:"mon";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continue";}}s:2:"mr";a:8:{s:8:"language";s:2:"mr";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-07 08:41:30";s:12:"english_name";s:7:"Marathi";s:11:"native_name";s:15:"मराठी";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/mr.zip";s:3:"iso";a:2:{i:1;s:2:"mr";i:2;s:3:"mar";}s:7:"strings";a:1:{s:8:"continue";s:25:"सुरु ठेवा";}}s:5:"ms_MY";a:8:{s:8:"language";s:5:"ms_MY";s:7:"version";s:6:"5.5.15";s:7:"updated";s:19:"2022-03-11 13:52:22";s:12:"english_name";s:5:"Malay";s:11:"native_name";s:13:"Bahasa Melayu";s:7:"package";s:65:"https://downloads.wordpress.org/translation/core/5.5.15/ms_MY.zip";s:3:"iso";a:2:{i:1;s:2:"ms";i:2;s:3:"msa";}s:7:"strings";a:1:{s:8:"continue";s:8:"Teruskan";}}s:5:"my_MM";a:8:{s:8:"language";s:5:"my_MM";s:7:"version";s:6:"4.2.38";s:7:"updated";s:19:"2017-12-26 11:57:10";s:12:"english_name";s:17:"Myanmar (Burmese)";s:11:"native_name";s:15:"ဗမာစာ";s:7:"package";s:65:"https://downloads.wordpress.org/translation/core/4.2.38/my_MM.zip";s:3:"iso";a:2:{i:1;s:2:"my";i:2;s:3:"mya";}s:7:"strings";a:1:{s:8:"continue";s:54:"ဆက်လက်လုပ်ဆောင်ပါ။";}}s:5:"nb_NO";a:8:{s:8:"language";s:5:"nb_NO";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-07-21 18:30:52";s:12:"english_name";s:19:"Norwegian (Bokmål)";s:11:"native_name";s:13:"Norsk bokmål";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/nb_NO.zip";s:3:"iso";a:2:{i:1;s:2:"nb";i:2;s:3:"nob";}s:7:"strings";a:1:{s:8:"continue";s:8:"Fortsett";}}s:5:"ne_NP";a:8:{s:8:"language";s:5:"ne_NP";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-08-30 11:32:23";s:12:"english_name";s:6:"Nepali";s:11:"native_name";s:18:"नेपाली";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/ne_NP.zip";s:3:"iso";a:2:{i:1;s:2:"ne";i:2;s:3:"nep";}s:7:"strings";a:1:{s:8:"continue";s:43:"जारी राख्नुहोस्";}}s:5:"nl_BE";a:8:{s:8:"language";s:5:"nl_BE";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-25 13:42:31";s:12:"english_name";s:15:"Dutch (Belgium)";s:11:"native_name";s:20:"Nederlands (België)";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/nl_BE.zip";s:3:"iso";a:2:{i:1;s:2:"nl";i:2;s:3:"nld";}s:7:"strings";a:1:{s:8:"continue";s:8:"Doorgaan";}}s:12:"nl_NL_formal";a:8:{s:8:"language";s:12:"nl_NL_formal";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-18 17:56:44";s:12:"english_name";s:14:"Dutch (Formal)";s:11:"native_name";s:20:"Nederlands (Formeel)";s:7:"package";s:71:"https://downloads.wordpress.org/translation/core/6.6.2/nl_NL_formal.zip";s:3:"iso";a:2:{i:1;s:2:"nl";i:2;s:3:"nld";}s:7:"strings";a:1:{s:8:"continue";s:8:"Doorgaan";}}s:5:"nl_NL";a:8:{s:8:"language";s:5:"nl_NL";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-22 19:57:38";s:12:"english_name";s:5:"Dutch";s:11:"native_name";s:10:"Nederlands";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/nl_NL.zip";s:3:"iso";a:2:{i:1;s:2:"nl";i:2;s:3:"nld";}s:7:"strings";a:1:{s:8:"continue";s:8:"Doorgaan";}}s:5:"nn_NO";a:8:{s:8:"language";s:5:"nn_NO";s:7:"version";s:8:"5.8-beta";s:7:"updated";s:19:"2021-03-18 10:59:16";s:12:"english_name";s:19:"Norwegian (Nynorsk)";s:11:"native_name";s:13:"Norsk nynorsk";s:7:"package";s:67:"https://downloads.wordpress.org/translation/core/5.8-beta/nn_NO.zip";s:3:"iso";a:2:{i:1;s:2:"nn";i:2;s:3:"nno";}s:7:"strings";a:1:{s:8:"continue";s:9:"Hald fram";}}s:3:"oci";a:8:{s:8:"language";s:3:"oci";s:7:"version";s:6:"4.8.25";s:7:"updated";s:19:"2017-08-25 10:03:08";s:12:"english_name";s:7:"Occitan";s:11:"native_name";s:7:"Occitan";s:7:"package";s:63:"https://downloads.wordpress.org/translation/core/4.8.25/oci.zip";s:3:"iso";a:2:{i:1;s:2:"oc";i:2;s:3:"oci";}s:7:"strings";a:1:{s:8:"continue";s:9:"Contunhar";}}s:5:"pa_IN";a:8:{s:8:"language";s:5:"pa_IN";s:7:"version";s:5:"4.7.2";s:7:"updated";s:19:"2017-01-16 05:19:43";s:12:"english_name";s:15:"Panjabi (India)";s:11:"native_name";s:18:"ਪੰਜਾਬੀ";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.7.2/pa_IN.zip";s:3:"iso";a:2:{i:1;s:2:"pa";i:2;s:3:"pan";}s:7:"strings";a:1:{s:8:"continue";s:25:"ਜਾਰੀ ਰੱਖੋ";}}s:5:"pl_PL";a:8:{s:8:"language";s:5:"pl_PL";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-27 06:32:31";s:12:"english_name";s:6:"Polish";s:11:"native_name";s:6:"Polski";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/pl_PL.zip";s:3:"iso";a:2:{i:1;s:2:"pl";i:2;s:3:"pol";}s:7:"strings";a:1:{s:8:"continue";s:9:"Kontynuuj";}}s:2:"ps";a:8:{s:8:"language";s:2:"ps";s:7:"version";s:6:"4.3.34";s:7:"updated";s:19:"2015-12-02 21:41:29";s:12:"english_name";s:6:"Pashto";s:11:"native_name";s:8:"پښتو";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/4.3.34/ps.zip";s:3:"iso";a:2:{i:1;s:2:"ps";i:2;s:3:"pus";}s:7:"strings";a:1:{s:8:"continue";s:19:"دوام ورکړه";}}s:5:"pt_PT";a:8:{s:8:"language";s:5:"pt_PT";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-22 13:12:01";s:12:"english_name";s:21:"Portuguese (Portugal)";s:11:"native_name";s:10:"Português";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/pt_PT.zip";s:3:"iso";a:1:{i:1;s:2:"pt";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"pt_BR";a:8:{s:8:"language";s:5:"pt_BR";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-22 23:08:50";s:12:"english_name";s:19:"Portuguese (Brazil)";s:11:"native_name";s:20:"Português do Brasil";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/pt_BR.zip";s:3:"iso";a:2:{i:1;s:2:"pt";i:2;s:3:"por";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:5:"pt_AO";a:8:{s:8:"language";s:5:"pt_AO";s:7:"version";s:5:"6.4.5";s:7:"updated";s:19:"2023-08-21 12:15:00";s:12:"english_name";s:19:"Portuguese (Angola)";s:11:"native_name";s:20:"Português de Angola";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.4.5/pt_AO.zip";s:3:"iso";a:1:{i:1;s:2:"pt";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:10:"pt_PT_ao90";a:8:{s:8:"language";s:10:"pt_PT_ao90";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-08-14 07:51:49";s:12:"english_name";s:27:"Portuguese (Portugal, AO90)";s:11:"native_name";s:17:"Português (AO90)";s:7:"package";s:69:"https://downloads.wordpress.org/translation/core/6.6.2/pt_PT_ao90.zip";s:3:"iso";a:1:{i:1;s:2:"pt";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuar";}}s:3:"rhg";a:8:{s:8:"language";s:3:"rhg";s:7:"version";s:5:"4.7.2";s:7:"updated";s:19:"2016-03-16 13:03:18";s:12:"english_name";s:8:"Rohingya";s:11:"native_name";s:8:"Ruáinga";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/4.7.2/rhg.zip";s:3:"iso";a:1:{i:3;s:3:"rhg";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continue";}}s:5:"ro_RO";a:8:{s:8:"language";s:5:"ro_RO";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-23 17:22:01";s:12:"english_name";s:8:"Romanian";s:11:"native_name";s:8:"Română";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/ro_RO.zip";s:3:"iso";a:2:{i:1;s:2:"ro";i:2;s:3:"ron";}s:7:"strings";a:1:{s:8:"continue";s:9:"Continuă";}}s:5:"ru_RU";a:8:{s:8:"language";s:5:"ru_RU";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-01 23:45:25";s:12:"english_name";s:7:"Russian";s:11:"native_name";s:14:"Русский";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/ru_RU.zip";s:3:"iso";a:2:{i:1;s:2:"ru";i:2;s:3:"rus";}s:7:"strings";a:1:{s:8:"continue";s:20:"Продолжить";}}s:3:"sah";a:8:{s:8:"language";s:3:"sah";s:7:"version";s:5:"4.7.2";s:7:"updated";s:19:"2017-01-21 02:06:41";s:12:"english_name";s:5:"Sakha";s:11:"native_name";s:14:"Сахалыы";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/4.7.2/sah.zip";s:3:"iso";a:2:{i:2;s:3:"sah";i:3;s:3:"sah";}s:7:"strings";a:1:{s:8:"continue";s:12:"Салҕаа";}}s:3:"snd";a:8:{s:8:"language";s:3:"snd";s:7:"version";s:6:"5.4.16";s:7:"updated";s:19:"2020-07-07 01:53:37";s:12:"english_name";s:6:"Sindhi";s:11:"native_name";s:8:"سنڌي";s:7:"package";s:63:"https://downloads.wordpress.org/translation/core/5.4.16/snd.zip";s:3:"iso";a:3:{i:1;s:2:"sd";i:2;s:3:"snd";i:3;s:3:"snd";}s:7:"strings";a:1:{s:8:"continue";s:15:"اڳتي هلو";}}s:5:"si_LK";a:8:{s:8:"language";s:5:"si_LK";s:7:"version";s:5:"4.7.2";s:7:"updated";s:19:"2016-11-12 06:00:52";s:12:"english_name";s:7:"Sinhala";s:11:"native_name";s:15:"සිංහල";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.7.2/si_LK.zip";s:3:"iso";a:2:{i:1;s:2:"si";i:2;s:3:"sin";}s:7:"strings";a:1:{s:8:"continue";s:44:"දිගටම කරගෙන යන්න";}}s:5:"sk_SK";a:8:{s:8:"language";s:5:"sk_SK";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-02 07:50:42";s:12:"english_name";s:6:"Slovak";s:11:"native_name";s:11:"Slovenčina";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/sk_SK.zip";s:3:"iso";a:2:{i:1;s:2:"sk";i:2;s:3:"slk";}s:7:"strings";a:1:{s:8:"continue";s:12:"Pokračovať";}}s:3:"skr";a:8:{s:8:"language";s:3:"skr";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-21 09:44:08";s:12:"english_name";s:7:"Saraiki";s:11:"native_name";s:14:"سرائیکی";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/6.6.2/skr.zip";s:3:"iso";a:1:{i:3;s:3:"skr";}s:7:"strings";a:1:{s:8:"continue";s:17:"جاری رکھو";}}s:5:"sl_SI";a:8:{s:8:"language";s:5:"sl_SI";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-08-30 07:14:35";s:12:"english_name";s:9:"Slovenian";s:11:"native_name";s:13:"Slovenščina";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/sl_SI.zip";s:3:"iso";a:2:{i:1;s:2:"sl";i:2;s:3:"slv";}s:7:"strings";a:1:{s:8:"continue";s:8:"Nadaljuj";}}s:2:"sq";a:8:{s:8:"language";s:2:"sq";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-02 11:01:55";s:12:"english_name";s:8:"Albanian";s:11:"native_name";s:5:"Shqip";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/sq.zip";s:3:"iso";a:2:{i:1;s:2:"sq";i:2;s:3:"sqi";}s:7:"strings";a:1:{s:8:"continue";s:6:"Vazhdo";}}s:5:"sr_RS";a:8:{s:8:"language";s:5:"sr_RS";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-20 22:15:56";s:12:"english_name";s:7:"Serbian";s:11:"native_name";s:23:"Српски језик";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/sr_RS.zip";s:3:"iso";a:2:{i:1;s:2:"sr";i:2;s:3:"srp";}s:7:"strings";a:1:{s:8:"continue";s:14:"Настави";}}s:5:"sv_SE";a:8:{s:8:"language";s:5:"sv_SE";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-08-20 14:19:52";s:12:"english_name";s:7:"Swedish";s:11:"native_name";s:7:"Svenska";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/sv_SE.zip";s:3:"iso";a:2:{i:1;s:2:"sv";i:2;s:3:"swe";}s:7:"strings";a:1:{s:8:"continue";s:9:"Fortsätt";}}s:2:"sw";a:8:{s:8:"language";s:2:"sw";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-06-20 17:29:45";s:12:"english_name";s:7:"Swahili";s:11:"native_name";s:9:"Kiswahili";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/sw.zip";s:3:"iso";a:2:{i:1;s:2:"sw";i:2;s:3:"swa";}s:7:"strings";a:1:{s:8:"continue";s:7:"Endelea";}}s:3:"szl";a:8:{s:8:"language";s:3:"szl";s:7:"version";s:5:"4.7.2";s:7:"updated";s:19:"2016-09-24 19:58:14";s:12:"english_name";s:8:"Silesian";s:11:"native_name";s:17:"Ślōnskŏ gŏdka";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/4.7.2/szl.zip";s:3:"iso";a:1:{i:3;s:3:"szl";}s:7:"strings";a:1:{s:8:"continue";s:13:"Kōntynuować";}}s:5:"ta_IN";a:8:{s:8:"language";s:5:"ta_IN";s:7:"version";s:5:"4.7.2";s:7:"updated";s:19:"2017-01-27 03:22:47";s:12:"english_name";s:5:"Tamil";s:11:"native_name";s:15:"தமிழ்";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.7.2/ta_IN.zip";s:3:"iso";a:2:{i:1;s:2:"ta";i:2;s:3:"tam";}s:7:"strings";a:1:{s:8:"continue";s:24:"தொடரவும்";}}s:5:"ta_LK";a:8:{s:8:"language";s:5:"ta_LK";s:7:"version";s:6:"4.2.38";s:7:"updated";s:19:"2015-12-03 01:07:44";s:12:"english_name";s:17:"Tamil (Sri Lanka)";s:11:"native_name";s:15:"தமிழ்";s:7:"package";s:65:"https://downloads.wordpress.org/translation/core/4.2.38/ta_LK.zip";s:3:"iso";a:2:{i:1;s:2:"ta";i:2;s:3:"tam";}s:7:"strings";a:1:{s:8:"continue";s:18:"தொடர்க";}}s:2:"te";a:8:{s:8:"language";s:2:"te";s:7:"version";s:5:"4.7.2";s:7:"updated";s:19:"2017-01-26 15:47:39";s:12:"english_name";s:6:"Telugu";s:11:"native_name";s:18:"తెలుగు";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/4.7.2/te.zip";s:3:"iso";a:2:{i:1;s:2:"te";i:2;s:3:"tel";}s:7:"strings";a:1:{s:8:"continue";s:30:"కొనసాగించు";}}s:2:"th";a:8:{s:8:"language";s:2:"th";s:7:"version";s:6:"5.8.10";s:7:"updated";s:19:"2022-06-08 04:30:30";s:12:"english_name";s:4:"Thai";s:11:"native_name";s:9:"ไทย";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/5.8.10/th.zip";s:3:"iso";a:2:{i:1;s:2:"th";i:2;s:3:"tha";}s:7:"strings";a:1:{s:8:"continue";s:15:"ต่อไป";}}s:2:"tl";a:8:{s:8:"language";s:2:"tl";s:7:"version";s:6:"4.8.25";s:7:"updated";s:19:"2017-09-30 09:04:29";s:12:"english_name";s:7:"Tagalog";s:11:"native_name";s:7:"Tagalog";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/4.8.25/tl.zip";s:3:"iso";a:2:{i:1;s:2:"tl";i:2;s:3:"tgl";}s:7:"strings";a:1:{s:8:"continue";s:10:"Magpatuloy";}}s:5:"tr_TR";a:8:{s:8:"language";s:5:"tr_TR";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-08-14 17:49:29";s:12:"english_name";s:7:"Turkish";s:11:"native_name";s:8:"Türkçe";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/tr_TR.zip";s:3:"iso";a:2:{i:1;s:2:"tr";i:2;s:3:"tur";}s:7:"strings";a:1:{s:8:"continue";s:5:"Devam";}}s:5:"tt_RU";a:8:{s:8:"language";s:5:"tt_RU";s:7:"version";s:5:"4.7.2";s:7:"updated";s:19:"2016-11-20 20:20:50";s:12:"english_name";s:5:"Tatar";s:11:"native_name";s:19:"Татар теле";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/4.7.2/tt_RU.zip";s:3:"iso";a:2:{i:1;s:2:"tt";i:2;s:3:"tat";}s:7:"strings";a:1:{s:8:"continue";s:17:"дәвам итү";}}s:3:"tah";a:8:{s:8:"language";s:3:"tah";s:7:"version";s:5:"4.7.2";s:7:"updated";s:19:"2016-03-06 18:39:39";s:12:"english_name";s:8:"Tahitian";s:11:"native_name";s:10:"Reo Tahiti";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/4.7.2/tah.zip";s:3:"iso";a:3:{i:1;s:2:"ty";i:2;s:3:"tah";i:3;s:3:"tah";}s:7:"strings";a:1:{s:8:"continue";s:8:"Continue";}}s:5:"ug_CN";a:8:{s:8:"language";s:5:"ug_CN";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-10-15 02:48:48";s:12:"english_name";s:6:"Uighur";s:11:"native_name";s:16:"ئۇيغۇرچە";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/ug_CN.zip";s:3:"iso";a:2:{i:1;s:2:"ug";i:2;s:3:"uig";}s:7:"strings";a:1:{s:8:"continue";s:26:"داۋاملاشتۇرۇش";}}s:2:"uk";a:8:{s:8:"language";s:2:"uk";s:7:"version";s:5:"6.4.5";s:7:"updated";s:19:"2024-03-06 18:52:07";s:12:"english_name";s:9:"Ukrainian";s:11:"native_name";s:20:"Українська";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.4.5/uk.zip";s:3:"iso";a:2:{i:1;s:2:"uk";i:2;s:3:"ukr";}s:7:"strings";a:1:{s:8:"continue";s:20:"Продовжити";}}s:2:"ur";a:8:{s:8:"language";s:2:"ur";s:7:"version";s:6:"5.4.16";s:7:"updated";s:19:"2020-04-09 11:17:33";s:12:"english_name";s:4:"Urdu";s:11:"native_name";s:8:"اردو";s:7:"package";s:62:"https://downloads.wordpress.org/translation/core/5.4.16/ur.zip";s:3:"iso";a:2:{i:1;s:2:"ur";i:2;s:3:"urd";}s:7:"strings";a:1:{s:8:"continue";s:19:"جاری رکھیں";}}s:5:"uz_UZ";a:8:{s:8:"language";s:5:"uz_UZ";s:7:"version";s:8:"5.8-beta";s:7:"updated";s:19:"2021-02-28 12:02:22";s:12:"english_name";s:5:"Uzbek";s:11:"native_name";s:11:"O‘zbekcha";s:7:"package";s:67:"https://downloads.wordpress.org/translation/core/5.8-beta/uz_UZ.zip";s:3:"iso";a:2:{i:1;s:2:"uz";i:2;s:3:"uzb";}s:7:"strings";a:1:{s:8:"continue";s:11:"Davom etish";}}s:2:"vi";a:8:{s:8:"language";s:2:"vi";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-23 10:07:11";s:12:"english_name";s:10:"Vietnamese";s:11:"native_name";s:14:"Tiếng Việt";s:7:"package";s:61:"https://downloads.wordpress.org/translation/core/6.6.2/vi.zip";s:3:"iso";a:2:{i:1;s:2:"vi";i:2;s:3:"vie";}s:7:"strings";a:1:{s:8:"continue";s:12:"Tiếp tục";}}s:5:"zh_TW";a:8:{s:8:"language";s:5:"zh_TW";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-10 20:43:54";s:12:"english_name";s:16:"Chinese (Taiwan)";s:11:"native_name";s:12:"繁體中文";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/zh_TW.zip";s:3:"iso";a:2:{i:1;s:2:"zh";i:2;s:3:"zho";}s:7:"strings";a:1:{s:8:"continue";s:6:"繼續";}}s:5:"zh_CN";a:8:{s:8:"language";s:5:"zh_CN";s:7:"version";s:5:"6.6.2";s:7:"updated";s:19:"2024-09-10 18:56:55";s:12:"english_name";s:15:"Chinese (China)";s:11:"native_name";s:12:"简体中文";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.6.2/zh_CN.zip";s:3:"iso";a:2:{i:1;s:2:"zh";i:2;s:3:"zho";}s:7:"strings";a:1:{s:8:"continue";s:6:"继续";}}s:5:"zh_HK";a:8:{s:8:"language";s:5:"zh_HK";s:7:"version";s:5:"6.2.6";s:7:"updated";s:19:"2022-07-15 15:25:03";s:12:"english_name";s:19:"Chinese (Hong Kong)";s:11:"native_name";s:12:"香港中文";s:7:"package";s:64:"https://downloads.wordpress.org/translation/core/6.2.6/zh_HK.zip";s:3:"iso";a:2:{i:1;s:2:"zh";i:2;s:3:"zho";}s:7:"strings";a:1:{s:8:"continue";s:6:"繼續";}}}', 'off'),
	(2982, '_site_transient_browser_9fae7894890fe21cd77090af114aa2cd', 'a:10:{s:4:"name";s:6:"Chrome";s:7:"version";s:9:"130.0.0.0";s:8:"platform";s:7:"Windows";s:10:"update_url";s:29:"https://www.google.com/chrome";s:7:"img_src";s:43:"http://s.w.org/images/browsers/chrome.png?1";s:11:"img_src_ssl";s:44:"https://s.w.org/images/browsers/chrome.png?1";s:15:"current_version";s:2:"18";s:7:"upgrade";b:0;s:8:"insecure";b:0;s:6:"mobile";b:0;}', 'no'),
	(2980, '_site_transient_php_check_d6b31cb0311c56af124525e5040ef5f1', 'a:5:{s:19:"recommended_version";s:3:"7.4";s:15:"minimum_version";s:6:"7.2.24";s:12:"is_supported";b:1;s:9:"is_secure";b:1;s:13:"is_acceptable";b:1;}', 'no'),
	(2976, '_site_transient_theme_roots', 'a:4:{s:19:"axio-starter-master";s:7:"/themes";s:16:"twentytwentyfour";s:7:"/themes";s:15:"twentytwentyone";s:7:"/themes";s:7:"wp-wpeb";s:7:"/themes";}', 'no'),
	(2994, '_site_transient_timeout_available_translations', '1729729463', 'off'),
	(2981, '_site_transient_timeout_browser_9fae7894890fe21cd77090af114aa2cd', '1730322689', 'no'),
	(2979, '_site_transient_timeout_php_check_d6b31cb0311c56af124525e5040ef5f1', '1730322685', 'no'),
	(2975, '_site_transient_timeout_theme_roots', '1729719682', 'no'),
	(2992, '_site_transient_timeout_wp_plugin_dependencies_plugin_timeout_contact-form-7', '1729761851', 'off'),
	(2990, '_site_transient_timeout_wp_theme_files_patterns-a64be370c6a53d17a10b356f6e90c147', '1729720425', 'off'),
	(2985, '_site_transient_update_core', 'O:8:"stdClass":4:{s:7:"updates";a:1:{i:0;O:8:"stdClass":10:{s:8:"response";s:6:"latest";s:8:"download";s:59:"https://downloads.wordpress.org/release/wordpress-6.6.2.zip";s:6:"locale";s:5:"en_US";s:8:"packages";O:8:"stdClass":5:{s:4:"full";s:59:"https://downloads.wordpress.org/release/wordpress-6.6.2.zip";s:10:"no_content";s:70:"https://downloads.wordpress.org/release/wordpress-6.6.2-no-content.zip";s:11:"new_bundled";s:71:"https://downloads.wordpress.org/release/wordpress-6.6.2-new-bundled.zip";s:7:"partial";s:0:"";s:8:"rollback";s:0:"";}s:7:"current";s:5:"6.6.2";s:7:"version";s:5:"6.6.2";s:11:"php_version";s:6:"7.2.24";s:13:"mysql_version";s:5:"5.5.5";s:11:"new_bundled";s:3:"6.4";s:15:"partial_version";s:0:"";}}s:12:"last_checked";i:1729718619;s:15:"version_checked";s:5:"6.6.2";s:12:"translations";a:0:{}}', 'off'),
	(2988, '_site_transient_update_plugins', 'O:8:"stdClass":5:{s:12:"last_checked";i:1729718625;s:8:"response";a:0:{}s:12:"translations";a:0:{}s:9:"no_update";a:49:{s:41:"acf-code-generator/acf_code_generator.php";O:8:"stdClass":10:{s:2:"id";s:32:"w.org/plugins/acf-code-generator";s:4:"slug";s:18:"acf-code-generator";s:6:"plugin";s:41:"acf-code-generator/acf_code_generator.php";s:11:"new_version";s:5:"1.0.2";s:3:"url";s:49:"https://wordpress.org/plugins/acf-code-generator/";s:7:"package";s:61:"https://downloads.wordpress.org/plugin/acf-code-generator.zip";s:5:"icons";a:2:{s:2:"2x";s:71:"https://ps.w.org/acf-code-generator/assets/icon-256x256.png?rev=2513505";s:2:"1x";s:71:"https://ps.w.org/acf-code-generator/assets/icon-256x256.png?rev=2513505";}s:7:"banners";a:0:{}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.0";}s:29:"acf-extended/acf-extended.php";O:8:"stdClass":10:{s:2:"id";s:26:"w.org/plugins/acf-extended";s:4:"slug";s:12:"acf-extended";s:6:"plugin";s:29:"acf-extended/acf-extended.php";s:11:"new_version";s:7:"0.9.0.7";s:3:"url";s:43:"https://wordpress.org/plugins/acf-extended/";s:7:"package";s:63:"https://downloads.wordpress.org/plugin/acf-extended.0.9.0.7.zip";s:5:"icons";a:2:{s:2:"2x";s:65:"https://ps.w.org/acf-extended/assets/icon-256x256.png?rev=2071550";s:2:"1x";s:65:"https://ps.w.org/acf-extended/assets/icon-128x128.png?rev=2071550";}s:7:"banners";a:2:{s:2:"2x";s:68:"https://ps.w.org/acf-extended/assets/banner-1544x500.png?rev=2071550";s:2:"1x";s:67:"https://ps.w.org/acf-extended/assets/banner-772x250.png?rev=2071550";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.9";}s:51:"all-in-one-wp-migration/all-in-one-wp-migration.php";O:8:"stdClass":10:{s:2:"id";s:37:"w.org/plugins/all-in-one-wp-migration";s:4:"slug";s:23:"all-in-one-wp-migration";s:6:"plugin";s:51:"all-in-one-wp-migration/all-in-one-wp-migration.php";s:11:"new_version";s:4:"7.87";s:3:"url";s:54:"https://wordpress.org/plugins/all-in-one-wp-migration/";s:7:"package";s:71:"https://downloads.wordpress.org/plugin/all-in-one-wp-migration.7.87.zip";s:5:"icons";a:2:{s:2:"2x";s:76:"https://ps.w.org/all-in-one-wp-migration/assets/icon-256x256.png?rev=2458334";s:2:"1x";s:76:"https://ps.w.org/all-in-one-wp-migration/assets/icon-128x128.png?rev=2458334";}s:7:"banners";a:2:{s:2:"2x";s:79:"https://ps.w.org/all-in-one-wp-migration/assets/banner-1544x500.png?rev=3173932";s:2:"1x";s:78:"https://ps.w.org/all-in-one-wp-migration/assets/banner-772x250.png?rev=3173932";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"3.3";}s:51:"all-in-one-wp-security-and-firewall/wp-security.php";O:8:"stdClass":10:{s:2:"id";s:49:"w.org/plugins/all-in-one-wp-security-and-firewall";s:4:"slug";s:35:"all-in-one-wp-security-and-firewall";s:6:"plugin";s:51:"all-in-one-wp-security-and-firewall/wp-security.php";s:11:"new_version";s:5:"5.3.4";s:3:"url";s:66:"https://wordpress.org/plugins/all-in-one-wp-security-and-firewall/";s:7:"package";s:84:"https://downloads.wordpress.org/plugin/all-in-one-wp-security-and-firewall.5.3.4.zip";s:5:"icons";a:2:{s:2:"2x";s:88:"https://ps.w.org/all-in-one-wp-security-and-firewall/assets/icon-256x256.png?rev=2798307";s:2:"1x";s:88:"https://ps.w.org/all-in-one-wp-security-and-firewall/assets/icon-128x128.png?rev=2798307";}s:7:"banners";a:2:{s:2:"2x";s:91:"https://ps.w.org/all-in-one-wp-security-and-firewall/assets/banner-1544x500.png?rev=2798307";s:2:"1x";s:90:"https://ps.w.org/all-in-one-wp-security-and-firewall/assets/banner-772x250.png?rev=2798307";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"5.0";}s:43:"broken-link-checker/broken-link-checker.php";O:8:"stdClass":10:{s:2:"id";s:33:"w.org/plugins/broken-link-checker";s:4:"slug";s:19:"broken-link-checker";s:6:"plugin";s:43:"broken-link-checker/broken-link-checker.php";s:11:"new_version";s:5:"2.4.1";s:3:"url";s:50:"https://wordpress.org/plugins/broken-link-checker/";s:7:"package";s:68:"https://downloads.wordpress.org/plugin/broken-link-checker.2.4.1.zip";s:5:"icons";a:2:{s:2:"2x";s:72:"https://ps.w.org/broken-link-checker/assets/icon-256x256.png?rev=2900468";s:2:"1x";s:72:"https://ps.w.org/broken-link-checker/assets/icon-128x128.png?rev=2900468";}s:7:"banners";a:2:{s:2:"2x";s:75:"https://ps.w.org/broken-link-checker/assets/banner-1544x500.png?rev=2900471";s:2:"1x";s:74:"https://ps.w.org/broken-link-checker/assets/banner-772x250.png?rev=2900471";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"5.2";}s:39:"bulk-page-creator/bulk-page-creator.php";O:8:"stdClass":10:{s:2:"id";s:31:"w.org/plugins/bulk-page-creator";s:4:"slug";s:17:"bulk-page-creator";s:6:"plugin";s:39:"bulk-page-creator/bulk-page-creator.php";s:11:"new_version";s:5:"1.1.4";s:3:"url";s:48:"https://wordpress.org/plugins/bulk-page-creator/";s:7:"package";s:60:"https://downloads.wordpress.org/plugin/bulk-page-creator.zip";s:5:"icons";a:1:{s:7:"default";s:61:"https://s.w.org/plugins/geopattern-icon/bulk-page-creator.svg";}s:7:"banners";a:0:{}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"3.1";}s:53:"child-theme-configurator/child-theme-configurator.php";O:8:"stdClass":10:{s:2:"id";s:38:"w.org/plugins/child-theme-configurator";s:4:"slug";s:24:"child-theme-configurator";s:6:"plugin";s:53:"child-theme-configurator/child-theme-configurator.php";s:11:"new_version";s:5:"2.6.6";s:3:"url";s:55:"https://wordpress.org/plugins/child-theme-configurator/";s:7:"package";s:73:"https://downloads.wordpress.org/plugin/child-theme-configurator.2.6.6.zip";s:5:"icons";a:1:{s:2:"1x";s:77:"https://ps.w.org/child-theme-configurator/assets/icon-128x128.png?rev=1557885";}s:7:"banners";a:1:{s:2:"1x";s:79:"https://ps.w.org/child-theme-configurator/assets/banner-772x250.jpg?rev=1557885";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.0";}s:41:"child-theme-wizard/child-theme-wizard.php";O:8:"stdClass":10:{s:2:"id";s:32:"w.org/plugins/child-theme-wizard";s:4:"slug";s:18:"child-theme-wizard";s:6:"plugin";s:41:"child-theme-wizard/child-theme-wizard.php";s:11:"new_version";s:3:"1.4";s:3:"url";s:49:"https://wordpress.org/plugins/child-theme-wizard/";s:7:"package";s:65:"https://downloads.wordpress.org/plugin/child-theme-wizard.1.4.zip";s:5:"icons";a:2:{s:2:"2x";s:70:"https://ps.w.org/child-theme-wizard/assets/icon-256x256.png?rev=984426";s:2:"1x";s:70:"https://ps.w.org/child-theme-wizard/assets/icon-128x128.png?rev=984426";}s:7:"banners";a:2:{s:2:"2x";s:73:"https://ps.w.org/child-theme-wizard/assets/banner-1544x500.png?rev=984451";s:2:"1x";s:72:"https://ps.w.org/child-theme-wizard/assets/banner-772x250.png?rev=984451";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"3.4";}s:33:"classic-editor/classic-editor.php";O:8:"stdClass":10:{s:2:"id";s:28:"w.org/plugins/classic-editor";s:4:"slug";s:14:"classic-editor";s:6:"plugin";s:33:"classic-editor/classic-editor.php";s:11:"new_version";s:5:"1.6.5";s:3:"url";s:45:"https://wordpress.org/plugins/classic-editor/";s:7:"package";s:63:"https://downloads.wordpress.org/plugin/classic-editor.1.6.5.zip";s:5:"icons";a:2:{s:2:"2x";s:67:"https://ps.w.org/classic-editor/assets/icon-256x256.png?rev=1998671";s:2:"1x";s:67:"https://ps.w.org/classic-editor/assets/icon-128x128.png?rev=1998671";}s:7:"banners";a:2:{s:2:"2x";s:70:"https://ps.w.org/classic-editor/assets/banner-1544x500.png?rev=1998671";s:2:"1x";s:69:"https://ps.w.org/classic-editor/assets/banner-772x250.png?rev=1998676";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.9";}s:35:"classic-widgets/classic-widgets.php";O:8:"stdClass":10:{s:2:"id";s:29:"w.org/plugins/classic-widgets";s:4:"slug";s:15:"classic-widgets";s:6:"plugin";s:35:"classic-widgets/classic-widgets.php";s:11:"new_version";s:3:"0.3";s:3:"url";s:46:"https://wordpress.org/plugins/classic-widgets/";s:7:"package";s:62:"https://downloads.wordpress.org/plugin/classic-widgets.0.3.zip";s:5:"icons";a:1:{s:7:"default";s:59:"https://s.w.org/plugins/geopattern-icon/classic-widgets.svg";}s:7:"banners";a:0:{}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.9";}s:33:"complianz-gdpr/complianz-gpdr.php";O:8:"stdClass":10:{s:2:"id";s:28:"w.org/plugins/complianz-gdpr";s:4:"slug";s:14:"complianz-gdpr";s:6:"plugin";s:33:"complianz-gdpr/complianz-gpdr.php";s:11:"new_version";s:5:"7.1.0";s:3:"url";s:45:"https://wordpress.org/plugins/complianz-gdpr/";s:7:"package";s:63:"https://downloads.wordpress.org/plugin/complianz-gdpr.7.1.0.zip";s:5:"icons";a:2:{s:2:"2x";s:67:"https://ps.w.org/complianz-gdpr/assets/icon-256x256.png?rev=2881064";s:2:"1x";s:67:"https://ps.w.org/complianz-gdpr/assets/icon-128x128.png?rev=2881064";}s:7:"banners";a:2:{s:2:"2x";s:70:"https://ps.w.org/complianz-gdpr/assets/banner-1544x500.png?rev=2881064";s:2:"1x";s:69:"https://ps.w.org/complianz-gdpr/assets/banner-772x250.png?rev=2881064";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"5.9";}s:36:"contact-form-7/wp-contact-form-7.php";O:8:"stdClass":10:{s:2:"id";s:28:"w.org/plugins/contact-form-7";s:4:"slug";s:14:"contact-form-7";s:6:"plugin";s:36:"contact-form-7/wp-contact-form-7.php";s:11:"new_version";s:5:"5.9.8";s:3:"url";s:45:"https://wordpress.org/plugins/contact-form-7/";s:7:"package";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.9.8.zip";s:5:"icons";a:2:{s:2:"1x";s:59:"https://ps.w.org/contact-form-7/assets/icon.svg?rev=2339255";s:3:"svg";s:59:"https://ps.w.org/contact-form-7/assets/icon.svg?rev=2339255";}s:7:"banners";a:2:{s:2:"2x";s:69:"https://ps.w.org/contact-form-7/assets/banner-1544x500.png?rev=860901";s:2:"1x";s:68:"https://ps.w.org/contact-form-7/assets/banner-772x250.png?rev=880427";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"6.3";}s:42:"contact-form-cfdb7/contact-form-cfdb-7.php";O:8:"stdClass":10:{s:2:"id";s:32:"w.org/plugins/contact-form-cfdb7";s:4:"slug";s:18:"contact-form-cfdb7";s:6:"plugin";s:42:"contact-form-cfdb7/contact-form-cfdb-7.php";s:11:"new_version";s:5:"1.2.7";s:3:"url";s:49:"https://wordpress.org/plugins/contact-form-cfdb7/";s:7:"package";s:67:"https://downloads.wordpress.org/plugin/contact-form-cfdb7.1.2.7.zip";s:5:"icons";a:2:{s:2:"2x";s:71:"https://ps.w.org/contact-form-cfdb7/assets/icon-256x256.png?rev=1619878";s:2:"1x";s:71:"https://ps.w.org/contact-form-cfdb7/assets/icon-128x128.png?rev=1619878";}s:7:"banners";a:1:{s:2:"1x";s:73:"https://ps.w.org/contact-form-cfdb7/assets/banner-772x250.png?rev=1619902";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.8";}s:53:"customizer-export-import/customizer-export-import.php";O:8:"stdClass":10:{s:2:"id";s:38:"w.org/plugins/customizer-export-import";s:4:"slug";s:24:"customizer-export-import";s:6:"plugin";s:53:"customizer-export-import/customizer-export-import.php";s:11:"new_version";s:7:"0.9.7.3";s:3:"url";s:55:"https://wordpress.org/plugins/customizer-export-import/";s:7:"package";s:75:"https://downloads.wordpress.org/plugin/customizer-export-import.0.9.7.3.zip";s:5:"icons";a:2:{s:2:"2x";s:77:"https://ps.w.org/customizer-export-import/assets/icon-256x256.jpg?rev=1049984";s:2:"1x";s:77:"https://ps.w.org/customizer-export-import/assets/icon-128x128.jpg?rev=1049984";}s:7:"banners";a:1:{s:2:"1x";s:79:"https://ps.w.org/customizer-export-import/assets/banner-772x250.jpg?rev=1049984";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"3.6";}s:43:"custom-post-type-ui/custom-post-type-ui.php";O:8:"stdClass":10:{s:2:"id";s:33:"w.org/plugins/custom-post-type-ui";s:4:"slug";s:19:"custom-post-type-ui";s:6:"plugin";s:43:"custom-post-type-ui/custom-post-type-ui.php";s:11:"new_version";s:6:"1.17.1";s:3:"url";s:50:"https://wordpress.org/plugins/custom-post-type-ui/";s:7:"package";s:69:"https://downloads.wordpress.org/plugin/custom-post-type-ui.1.17.1.zip";s:5:"icons";a:2:{s:2:"2x";s:72:"https://ps.w.org/custom-post-type-ui/assets/icon-256x256.png?rev=2744389";s:2:"1x";s:72:"https://ps.w.org/custom-post-type-ui/assets/icon-128x128.png?rev=2744389";}s:7:"banners";a:2:{s:2:"2x";s:75:"https://ps.w.org/custom-post-type-ui/assets/banner-1544x500.png?rev=2744389";s:2:"1x";s:74:"https://ps.w.org/custom-post-type-ui/assets/banner-772x250.png?rev=2744389";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"6.5";}s:39:"https-redirection/https-redirection.php";O:8:"stdClass":10:{s:2:"id";s:31:"w.org/plugins/https-redirection";s:4:"slug";s:17:"https-redirection";s:6:"plugin";s:39:"https-redirection/https-redirection.php";s:11:"new_version";s:5:"1.9.2";s:3:"url";s:48:"https://wordpress.org/plugins/https-redirection/";s:7:"package";s:60:"https://downloads.wordpress.org/plugin/https-redirection.zip";s:5:"icons";a:1:{s:2:"1x";s:70:"https://ps.w.org/https-redirection/assets/icon-128x128.png?rev=1779143";}s:7:"banners";a:1:{s:2:"1x";s:72:"https://ps.w.org/https-redirection/assets/banner-772x250.png?rev=1779143";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"5.5";}s:45:"enable-svg-webp-ico-upload/itc-svg-upload.php";O:8:"stdClass":10:{s:2:"id";s:40:"w.org/plugins/enable-svg-webp-ico-upload";s:4:"slug";s:26:"enable-svg-webp-ico-upload";s:6:"plugin";s:45:"enable-svg-webp-ico-upload/itc-svg-upload.php";s:11:"new_version";s:5:"1.0.6";s:3:"url";s:57:"https://wordpress.org/plugins/enable-svg-webp-ico-upload/";s:7:"package";s:75:"https://downloads.wordpress.org/plugin/enable-svg-webp-ico-upload.1.0.6.zip";s:5:"icons";a:2:{s:2:"2x";s:79:"https://ps.w.org/enable-svg-webp-ico-upload/assets/icon-256x256.png?rev=2510822";s:2:"1x";s:79:"https://ps.w.org/enable-svg-webp-ico-upload/assets/icon-256x256.png?rev=2510822";}s:7:"banners";a:1:{s:2:"1x";s:81:"https://ps.w.org/enable-svg-webp-ico-upload/assets/banner-772x250.png?rev=2510822";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.7";}s:25:"auto-sizes/auto-sizes.php";O:8:"stdClass":10:{s:2:"id";s:24:"w.org/plugins/auto-sizes";s:4:"slug";s:10:"auto-sizes";s:6:"plugin";s:25:"auto-sizes/auto-sizes.php";s:11:"new_version";s:5:"1.3.0";s:3:"url";s:41:"https://wordpress.org/plugins/auto-sizes/";s:7:"package";s:59:"https://downloads.wordpress.org/plugin/auto-sizes.1.3.0.zip";s:5:"icons";a:2:{s:2:"1x";s:55:"https://ps.w.org/auto-sizes/assets/icon.svg?rev=3098222";s:3:"svg";s:55:"https://ps.w.org/auto-sizes/assets/icon.svg?rev=3098222";}s:7:"banners";a:2:{s:2:"2x";s:66:"https://ps.w.org/auto-sizes/assets/banner-1544x500.png?rev=3098222";s:2:"1x";s:65:"https://ps.w.org/auto-sizes/assets/banner-772x250.png?rev=3098222";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"6.5";}s:45:"ewww-image-optimizer/ewww-image-optimizer.php";O:8:"stdClass":10:{s:2:"id";s:34:"w.org/plugins/ewww-image-optimizer";s:4:"slug";s:20:"ewww-image-optimizer";s:6:"plugin";s:45:"ewww-image-optimizer/ewww-image-optimizer.php";s:11:"new_version";s:5:"7.9.0";s:3:"url";s:51:"https://wordpress.org/plugins/ewww-image-optimizer/";s:7:"package";s:69:"https://downloads.wordpress.org/plugin/ewww-image-optimizer.7.9.0.zip";s:5:"icons";a:2:{s:2:"2x";s:73:"https://ps.w.org/ewww-image-optimizer/assets/icon-256x256.png?rev=1582276";s:2:"1x";s:73:"https://ps.w.org/ewww-image-optimizer/assets/icon-128x128.png?rev=1582276";}s:7:"banners";a:2:{s:2:"2x";s:76:"https://ps.w.org/ewww-image-optimizer/assets/banner-1544x500.jpg?rev=1582276";s:2:"1x";s:75:"https://ps.w.org/ewww-image-optimizer/assets/banner-772x250.jpg?rev=1582276";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"6.3";}s:25:"fakerpress/fakerpress.php";O:8:"stdClass":10:{s:2:"id";s:24:"w.org/plugins/fakerpress";s:4:"slug";s:10:"fakerpress";s:6:"plugin";s:25:"fakerpress/fakerpress.php";s:11:"new_version";s:5:"0.6.6";s:3:"url";s:41:"https://wordpress.org/plugins/fakerpress/";s:7:"package";s:59:"https://downloads.wordpress.org/plugin/fakerpress.0.6.6.zip";s:5:"icons";a:2:{s:2:"1x";s:55:"https://ps.w.org/fakerpress/assets/icon.svg?rev=1846090";s:3:"svg";s:55:"https://ps.w.org/fakerpress/assets/icon.svg?rev=1846090";}s:7:"banners";a:2:{s:2:"2x";s:66:"https://ps.w.org/fakerpress/assets/banner-1544x500.png?rev=1152002";s:2:"1x";s:65:"https://ps.w.org/fakerpress/assets/banner-772x250.png?rev=1152002";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"5.5";}s:29:"health-check/health-check.php";O:8:"stdClass":10:{s:2:"id";s:26:"w.org/plugins/health-check";s:4:"slug";s:12:"health-check";s:6:"plugin";s:29:"health-check/health-check.php";s:11:"new_version";s:5:"1.7.1";s:3:"url";s:43:"https://wordpress.org/plugins/health-check/";s:7:"package";s:61:"https://downloads.wordpress.org/plugin/health-check.1.7.1.zip";s:5:"icons";a:2:{s:2:"1x";s:57:"https://ps.w.org/health-check/assets/icon.svg?rev=1828244";s:3:"svg";s:57:"https://ps.w.org/health-check/assets/icon.svg?rev=1828244";}s:7:"banners";a:2:{s:2:"2x";s:68:"https://ps.w.org/health-check/assets/banner-1544x500.png?rev=1823210";s:2:"1x";s:67:"https://ps.w.org/health-check/assets/banner-772x250.png?rev=1823210";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.4";}s:36:"contact-form-7-honeypot/honeypot.php";O:8:"stdClass":10:{s:2:"id";s:37:"w.org/plugins/contact-form-7-honeypot";s:4:"slug";s:23:"contact-form-7-honeypot";s:6:"plugin";s:36:"contact-form-7-honeypot/honeypot.php";s:11:"new_version";s:5:"2.1.5";s:3:"url";s:54:"https://wordpress.org/plugins/contact-form-7-honeypot/";s:7:"package";s:72:"https://downloads.wordpress.org/plugin/contact-form-7-honeypot.2.1.5.zip";s:5:"icons";a:2:{s:2:"2x";s:76:"https://ps.w.org/contact-form-7-honeypot/assets/icon-256x256.png?rev=2487322";s:2:"1x";s:76:"https://ps.w.org/contact-form-7-honeypot/assets/icon-128x128.png?rev=2487322";}s:7:"banners";a:2:{s:2:"2x";s:79:"https://ps.w.org/contact-form-7-honeypot/assets/banner-1544x500.png?rev=3139486";s:2:"1x";s:78:"https://ps.w.org/contact-form-7-honeypot/assets/banner-772x250.png?rev=3139486";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.8";}s:29:"http-headers/http-headers.php";O:8:"stdClass":10:{s:2:"id";s:26:"w.org/plugins/http-headers";s:4:"slug";s:12:"http-headers";s:6:"plugin";s:29:"http-headers/http-headers.php";s:11:"new_version";s:6:"1.19.1";s:3:"url";s:43:"https://wordpress.org/plugins/http-headers/";s:7:"package";s:62:"https://downloads.wordpress.org/plugin/http-headers.1.19.1.zip";s:5:"icons";a:1:{s:2:"1x";s:65:"https://ps.w.org/http-headers/assets/icon-128x128.png?rev=1413576";}s:7:"banners";a:1:{s:2:"1x";s:67:"https://ps.w.org/http-headers/assets/banner-772x250.jpg?rev=1413577";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"3.2";}s:30:"dominant-color-images/load.php";O:8:"stdClass":10:{s:2:"id";s:35:"w.org/plugins/dominant-color-images";s:4:"slug";s:21:"dominant-color-images";s:6:"plugin";s:30:"dominant-color-images/load.php";s:11:"new_version";s:5:"1.1.2";s:3:"url";s:52:"https://wordpress.org/plugins/dominant-color-images/";s:7:"package";s:70:"https://downloads.wordpress.org/plugin/dominant-color-images.1.1.2.zip";s:5:"icons";a:2:{s:2:"1x";s:66:"https://ps.w.org/dominant-color-images/assets/icon.svg?rev=3098225";s:3:"svg";s:66:"https://ps.w.org/dominant-color-images/assets/icon.svg?rev=3098225";}s:7:"banners";a:2:{s:2:"2x";s:77:"https://ps.w.org/dominant-color-images/assets/banner-1544x500.png?rev=3098225";s:2:"1x";s:76:"https://ps.w.org/dominant-color-images/assets/banner-772x250.png?rev=3098225";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"6.5";}s:53:"index-wp-mysql-for-speed/index-wp-mysql-for-speed.php";O:8:"stdClass":10:{s:2:"id";s:38:"w.org/plugins/index-wp-mysql-for-speed";s:4:"slug";s:24:"index-wp-mysql-for-speed";s:6:"plugin";s:53:"index-wp-mysql-for-speed/index-wp-mysql-for-speed.php";s:11:"new_version";s:5:"1.5.2";s:3:"url";s:55:"https://wordpress.org/plugins/index-wp-mysql-for-speed/";s:7:"package";s:73:"https://downloads.wordpress.org/plugin/index-wp-mysql-for-speed.1.5.2.zip";s:5:"icons";a:1:{s:2:"1x";s:77:"https://ps.w.org/index-wp-mysql-for-speed/assets/icon-128x128.png?rev=2652667";}s:7:"banners";a:1:{s:2:"1x";s:79:"https://ps.w.org/index-wp-mysql-for-speed/assets/banner-772x250.png?rev=2652667";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.2";}s:35:"litespeed-cache/litespeed-cache.php";O:8:"stdClass":10:{s:2:"id";s:29:"w.org/plugins/litespeed-cache";s:4:"slug";s:15:"litespeed-cache";s:6:"plugin";s:35:"litespeed-cache/litespeed-cache.php";s:11:"new_version";s:5:"6.5.2";s:3:"url";s:46:"https://wordpress.org/plugins/litespeed-cache/";s:7:"package";s:64:"https://downloads.wordpress.org/plugin/litespeed-cache.6.5.2.zip";s:5:"icons";a:2:{s:2:"2x";s:68:"https://ps.w.org/litespeed-cache/assets/icon-256x256.png?rev=2554181";s:2:"1x";s:68:"https://ps.w.org/litespeed-cache/assets/icon-128x128.png?rev=2554181";}s:7:"banners";a:2:{s:2:"2x";s:71:"https://ps.w.org/litespeed-cache/assets/banner-1544x500.png?rev=2554181";s:2:"1x";s:70:"https://ps.w.org/litespeed-cache/assets/banner-772x250.png?rev=2554181";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.9";}s:21:"webp-uploads/load.php";O:8:"stdClass":10:{s:2:"id";s:26:"w.org/plugins/webp-uploads";s:4:"slug";s:12:"webp-uploads";s:6:"plugin";s:21:"webp-uploads/load.php";s:11:"new_version";s:5:"2.2.0";s:3:"url";s:43:"https://wordpress.org/plugins/webp-uploads/";s:7:"package";s:61:"https://downloads.wordpress.org/plugin/webp-uploads.2.2.0.zip";s:5:"icons";a:2:{s:2:"1x";s:57:"https://ps.w.org/webp-uploads/assets/icon.svg?rev=3098226";s:3:"svg";s:57:"https://ps.w.org/webp-uploads/assets/icon.svg?rev=3098226";}s:7:"banners";a:2:{s:2:"2x";s:68:"https://ps.w.org/webp-uploads/assets/banner-1544x500.png?rev=3098226";s:2:"1x";s:67:"https://ps.w.org/webp-uploads/assets/banner-772x250.png?rev=3098226";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"6.5";}s:24:"performance-lab/load.php";O:8:"stdClass":10:{s:2:"id";s:29:"w.org/plugins/performance-lab";s:4:"slug";s:15:"performance-lab";s:6:"plugin";s:24:"performance-lab/load.php";s:11:"new_version";s:5:"3.5.1";s:3:"url";s:46:"https://wordpress.org/plugins/performance-lab/";s:7:"package";s:64:"https://downloads.wordpress.org/plugin/performance-lab.3.5.1.zip";s:5:"icons";a:2:{s:2:"1x";s:60:"https://ps.w.org/performance-lab/assets/icon.svg?rev=2787149";s:3:"svg";s:60:"https://ps.w.org/performance-lab/assets/icon.svg?rev=2787149";}s:7:"banners";a:2:{s:2:"2x";s:71:"https://ps.w.org/performance-lab/assets/banner-1544x500.png?rev=3098881";s:2:"1x";s:70:"https://ps.w.org/performance-lab/assets/banner-772x250.png?rev=3098881";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"6.5";}s:45:"performance-profiler/performance-profiler.php";O:8:"stdClass":10:{s:2:"id";s:34:"w.org/plugins/performance-profiler";s:4:"slug";s:20:"performance-profiler";s:6:"plugin";s:45:"performance-profiler/performance-profiler.php";s:11:"new_version";s:5:"0.1.0";s:3:"url";s:51:"https://wordpress.org/plugins/performance-profiler/";s:7:"package";s:69:"https://downloads.wordpress.org/plugin/performance-profiler.0.1.0.zip";s:5:"icons";a:1:{s:7:"default";s:64:"https://s.w.org/plugins/geopattern-icon/performance-profiler.svg";}s:7:"banners";a:0:{}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.0";}s:51:"performant-translations/performant-translations.php";O:8:"stdClass":10:{s:2:"id";s:37:"w.org/plugins/performant-translations";s:4:"slug";s:23:"performant-translations";s:6:"plugin";s:51:"performant-translations/performant-translations.php";s:11:"new_version";s:5:"1.2.0";s:3:"url";s:54:"https://wordpress.org/plugins/performant-translations/";s:7:"package";s:72:"https://downloads.wordpress.org/plugin/performant-translations.1.2.0.zip";s:5:"icons";a:2:{s:2:"1x";s:68:"https://ps.w.org/performant-translations/assets/icon.svg?rev=3098168";s:3:"svg";s:68:"https://ps.w.org/performant-translations/assets/icon.svg?rev=3098168";}s:7:"banners";a:2:{s:2:"2x";s:79:"https://ps.w.org/performant-translations/assets/banner-1544x500.png?rev=3098168";s:2:"1x";s:78:"https://ps.w.org/performant-translations/assets/banner-772x250.png?rev=3103384";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"6.5";}s:55:"plugins-garbage-collector/plugins-garbage-collector.php";O:8:"stdClass":10:{s:2:"id";s:39:"w.org/plugins/plugins-garbage-collector";s:4:"slug";s:25:"plugins-garbage-collector";s:6:"plugin";s:55:"plugins-garbage-collector/plugins-garbage-collector.php";s:11:"new_version";s:4:"0.14";s:3:"url";s:56:"https://wordpress.org/plugins/plugins-garbage-collector/";s:7:"package";s:73:"https://downloads.wordpress.org/plugin/plugins-garbage-collector.0.14.zip";s:5:"icons";a:2:{s:2:"2x";s:78:"https://ps.w.org/plugins-garbage-collector/assets/icon-256x256.png?rev=2327424";s:2:"1x";s:78:"https://ps.w.org/plugins-garbage-collector/assets/icon-128x128.png?rev=2327424";}s:7:"banners";a:1:{s:2:"1x";s:80:"https://ps.w.org/plugins-garbage-collector/assets/banner-772x250.png?rev=2327425";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.0";}s:31:"query-monitor/query-monitor.php";O:8:"stdClass":10:{s:2:"id";s:27:"w.org/plugins/query-monitor";s:4:"slug";s:13:"query-monitor";s:6:"plugin";s:31:"query-monitor/query-monitor.php";s:11:"new_version";s:6:"3.16.4";s:3:"url";s:44:"https://wordpress.org/plugins/query-monitor/";s:7:"package";s:63:"https://downloads.wordpress.org/plugin/query-monitor.3.16.4.zip";s:5:"icons";a:2:{s:2:"1x";s:58:"https://ps.w.org/query-monitor/assets/icon.svg?rev=2994095";s:3:"svg";s:58:"https://ps.w.org/query-monitor/assets/icon.svg?rev=2994095";}s:7:"banners";a:2:{s:2:"2x";s:69:"https://ps.w.org/query-monitor/assets/banner-1544x500.png?rev=2870124";s:2:"1x";s:68:"https://ps.w.org/query-monitor/assets/banner-772x250.png?rev=2457098";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"5.8";}s:30:"seo-by-rank-math/rank-math.php";O:8:"stdClass":10:{s:2:"id";s:30:"w.org/plugins/seo-by-rank-math";s:4:"slug";s:16:"seo-by-rank-math";s:6:"plugin";s:30:"seo-by-rank-math/rank-math.php";s:11:"new_version";s:7:"1.0.230";s:3:"url";s:47:"https://wordpress.org/plugins/seo-by-rank-math/";s:7:"package";s:67:"https://downloads.wordpress.org/plugin/seo-by-rank-math.1.0.230.zip";s:5:"icons";a:2:{s:2:"1x";s:61:"https://ps.w.org/seo-by-rank-math/assets/icon.svg?rev=3015810";s:3:"svg";s:61:"https://ps.w.org/seo-by-rank-math/assets/icon.svg?rev=3015810";}s:7:"banners";a:2:{s:2:"2x";s:72:"https://ps.w.org/seo-by-rank-math/assets/banner-1544x500.png?rev=2639678";s:2:"1x";s:71:"https://ps.w.org/seo-by-rank-math/assets/banner-772x250.png?rev=2639678";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"6.3";}s:45:"search-and-replace/inpsyde-search-replace.php";O:8:"stdClass":10:{s:2:"id";s:32:"w.org/plugins/search-and-replace";s:4:"slug";s:18:"search-and-replace";s:6:"plugin";s:45:"search-and-replace/inpsyde-search-replace.php";s:11:"new_version";s:5:"3.2.3";s:3:"url";s:49:"https://wordpress.org/plugins/search-and-replace/";s:7:"package";s:67:"https://downloads.wordpress.org/plugin/search-and-replace.3.2.3.zip";s:5:"icons";a:2:{s:2:"2x";s:71:"https://ps.w.org/search-and-replace/assets/icon-256x256.png?rev=1776844";s:2:"1x";s:71:"https://ps.w.org/search-and-replace/assets/icon-128x128.png?rev=1776844";}s:7:"banners";a:2:{s:2:"2x";s:74:"https://ps.w.org/search-and-replace/assets/banner-1544x500.png?rev=1776844";s:2:"1x";s:73:"https://ps.w.org/search-and-replace/assets/banner-772x250.png?rev=1776844";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.0";}s:33:"seo-image/seo-friendly-images.php";O:8:"stdClass":10:{s:2:"id";s:23:"w.org/plugins/seo-image";s:4:"slug";s:9:"seo-image";s:6:"plugin";s:33:"seo-image/seo-friendly-images.php";s:11:"new_version";s:5:"3.0.5";s:3:"url";s:40:"https://wordpress.org/plugins/seo-image/";s:7:"package";s:52:"https://downloads.wordpress.org/plugin/seo-image.zip";s:5:"icons";a:1:{s:2:"1x";s:62:"https://ps.w.org/seo-image/assets/icon-128x128.png?rev=1050796";}s:7:"banners";a:1:{s:2:"1x";s:63:"https://ps.w.org/seo-image/assets/banner-772x250.png?rev=525849";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"2.7";}s:43:"site-health-manager/site-health-manager.php";O:8:"stdClass":10:{s:2:"id";s:33:"w.org/plugins/site-health-manager";s:4:"slug";s:19:"site-health-manager";s:6:"plugin";s:43:"site-health-manager/site-health-manager.php";s:11:"new_version";s:5:"1.1.2";s:3:"url";s:50:"https://wordpress.org/plugins/site-health-manager/";s:7:"package";s:68:"https://downloads.wordpress.org/plugin/site-health-manager.1.1.2.zip";s:5:"icons";a:2:{s:2:"1x";s:64:"https://ps.w.org/site-health-manager/assets/icon.svg?rev=2090933";s:3:"svg";s:64:"https://ps.w.org/site-health-manager/assets/icon.svg?rev=2090933";}s:7:"banners";a:2:{s:2:"2x";s:75:"https://ps.w.org/site-health-manager/assets/banner-1544x500.png?rev=2093623";s:2:"1x";s:74:"https://ps.w.org/site-health-manager/assets/banner-772x250.png?rev=2093629";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"5.2";}s:35:"google-site-kit/google-site-kit.php";O:8:"stdClass":10:{s:2:"id";s:29:"w.org/plugins/google-site-kit";s:4:"slug";s:15:"google-site-kit";s:6:"plugin";s:35:"google-site-kit/google-site-kit.php";s:11:"new_version";s:7:"1.138.0";s:3:"url";s:46:"https://wordpress.org/plugins/google-site-kit/";s:7:"package";s:66:"https://downloads.wordpress.org/plugin/google-site-kit.1.138.0.zip";s:5:"icons";a:2:{s:2:"2x";s:68:"https://ps.w.org/google-site-kit/assets/icon-256x256.png?rev=3141863";s:2:"1x";s:68:"https://ps.w.org/google-site-kit/assets/icon-128x128.png?rev=3141863";}s:7:"banners";a:2:{s:2:"2x";s:71:"https://ps.w.org/google-site-kit/assets/banner-1544x500.png?rev=3141863";s:2:"1x";s:70:"https://ps.w.org/google-site-kit/assets/banner-772x250.png?rev=3141863";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"5.2";}s:27:"svg-support/svg-support.php";O:8:"stdClass":10:{s:2:"id";s:25:"w.org/plugins/svg-support";s:4:"slug";s:11:"svg-support";s:6:"plugin";s:27:"svg-support/svg-support.php";s:11:"new_version";s:5:"2.5.8";s:3:"url";s:42:"https://wordpress.org/plugins/svg-support/";s:7:"package";s:60:"https://downloads.wordpress.org/plugin/svg-support.2.5.8.zip";s:5:"icons";a:2:{s:2:"1x";s:56:"https://ps.w.org/svg-support/assets/icon.svg?rev=1417738";s:3:"svg";s:56:"https://ps.w.org/svg-support/assets/icon.svg?rev=1417738";}s:7:"banners";a:2:{s:2:"2x";s:67:"https://ps.w.org/svg-support/assets/banner-1544x500.jpg?rev=1215377";s:2:"1x";s:66:"https://ps.w.org/svg-support/assets/banner-772x250.jpg?rev=1215377";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.8";}s:25:"ukr-to-lat/ukr-to-lat.php";O:8:"stdClass":10:{s:2:"id";s:24:"w.org/plugins/ukr-to-lat";s:4:"slug";s:10:"ukr-to-lat";s:6:"plugin";s:25:"ukr-to-lat/ukr-to-lat.php";s:11:"new_version";s:5:"1.3.5";s:3:"url";s:41:"https://wordpress.org/plugins/ukr-to-lat/";s:7:"package";s:53:"https://downloads.wordpress.org/plugin/ukr-to-lat.zip";s:5:"icons";a:2:{s:2:"2x";s:63:"https://ps.w.org/ukr-to-lat/assets/icon-256x256.png?rev=1942473";s:2:"1x";s:63:"https://ps.w.org/ukr-to-lat/assets/icon-128x128.png?rev=1942473";}s:7:"banners";a:2:{s:2:"2x";s:66:"https://ps.w.org/ukr-to-lat/assets/banner-1544x500.png?rev=1942473";s:2:"1x";s:65:"https://ps.w.org/ukr-to-lat/assets/banner-772x250.png?rev=1942473";}s:11:"banners_rtl";a:2:{s:2:"2x";s:70:"https://ps.w.org/ukr-to-lat/assets/banner-1544x500-rtl.png?rev=1942473";s:2:"1x";s:69:"https://ps.w.org/ukr-to-lat/assets/banner-772x250-rtl.png?rev=1942473";}s:8:"requires";s:3:"4.6";}s:27:"updraftplus/updraftplus.php";O:8:"stdClass":10:{s:2:"id";s:25:"w.org/plugins/updraftplus";s:4:"slug";s:11:"updraftplus";s:6:"plugin";s:27:"updraftplus/updraftplus.php";s:11:"new_version";s:6:"1.24.6";s:3:"url";s:42:"https://wordpress.org/plugins/updraftplus/";s:7:"package";s:61:"https://downloads.wordpress.org/plugin/updraftplus.1.24.6.zip";s:5:"icons";a:2:{s:2:"2x";s:64:"https://ps.w.org/updraftplus/assets/icon-256x256.jpg?rev=1686200";s:2:"1x";s:64:"https://ps.w.org/updraftplus/assets/icon-128x128.jpg?rev=1686200";}s:7:"banners";a:2:{s:2:"2x";s:67:"https://ps.w.org/updraftplus/assets/banner-1544x500.png?rev=1686200";s:2:"1x";s:66:"https://ps.w.org/updraftplus/assets/banner-772x250.png?rev=1686200";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"3.2";}s:53:"widget-importer-exporter/widget-importer-exporter.php";O:8:"stdClass":10:{s:2:"id";s:38:"w.org/plugins/widget-importer-exporter";s:4:"slug";s:24:"widget-importer-exporter";s:6:"plugin";s:53:"widget-importer-exporter/widget-importer-exporter.php";s:11:"new_version";s:5:"1.6.1";s:3:"url";s:55:"https://wordpress.org/plugins/widget-importer-exporter/";s:7:"package";s:73:"https://downloads.wordpress.org/plugin/widget-importer-exporter.1.6.1.zip";s:5:"icons";a:2:{s:2:"2x";s:76:"https://ps.w.org/widget-importer-exporter/assets/icon-256x256.jpg?rev=990577";s:2:"1x";s:76:"https://ps.w.org/widget-importer-exporter/assets/icon-128x128.jpg?rev=990577";}s:7:"banners";a:2:{s:2:"2x";s:79:"https://ps.w.org/widget-importer-exporter/assets/banner-1544x500.jpg?rev=775677";s:2:"1x";s:78:"https://ps.w.org/widget-importer-exporter/assets/banner-772x250.jpg?rev=741218";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"3.5";}s:23:"wordfence/wordfence.php";O:8:"stdClass":10:{s:2:"id";s:23:"w.org/plugins/wordfence";s:4:"slug";s:9:"wordfence";s:6:"plugin";s:23:"wordfence/wordfence.php";s:11:"new_version";s:6:"7.11.7";s:3:"url";s:40:"https://wordpress.org/plugins/wordfence/";s:7:"package";s:59:"https://downloads.wordpress.org/plugin/wordfence.7.11.7.zip";s:5:"icons";a:2:{s:2:"1x";s:54:"https://ps.w.org/wordfence/assets/icon.svg?rev=2070865";s:3:"svg";s:54:"https://ps.w.org/wordfence/assets/icon.svg?rev=2070865";}s:7:"banners";a:2:{s:2:"2x";s:65:"https://ps.w.org/wordfence/assets/banner-1544x500.jpg?rev=2124102";s:2:"1x";s:64:"https://ps.w.org/wordfence/assets/banner-772x250.jpg?rev=2124102";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"3.9";}s:41:"wordpress-importer/wordpress-importer.php";O:8:"stdClass":10:{s:2:"id";s:32:"w.org/plugins/wordpress-importer";s:4:"slug";s:18:"wordpress-importer";s:6:"plugin";s:41:"wordpress-importer/wordpress-importer.php";s:11:"new_version";s:5:"0.8.3";s:3:"url";s:49:"https://wordpress.org/plugins/wordpress-importer/";s:7:"package";s:67:"https://downloads.wordpress.org/plugin/wordpress-importer.0.8.3.zip";s:5:"icons";a:2:{s:2:"1x";s:63:"https://ps.w.org/wordpress-importer/assets/icon.svg?rev=2791650";s:3:"svg";s:63:"https://ps.w.org/wordpress-importer/assets/icon.svg?rev=2791650";}s:7:"banners";a:1:{s:2:"1x";s:72:"https://ps.w.org/wordpress-importer/assets/banner-772x250.png?rev=547654";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"5.2";}s:36:"inspector-wp/wordpress-inspector.php";O:8:"stdClass":10:{s:2:"id";s:26:"w.org/plugins/inspector-wp";s:4:"slug";s:12:"inspector-wp";s:6:"plugin";s:36:"inspector-wp/wordpress-inspector.php";s:11:"new_version";s:5:"1.1.0";s:3:"url";s:43:"https://wordpress.org/plugins/inspector-wp/";s:7:"package";s:61:"https://downloads.wordpress.org/plugin/inspector-wp.1.1.0.zip";s:5:"icons";a:1:{s:2:"1x";s:65:"https://ps.w.org/inspector-wp/assets/icon-128x128.png?rev=1409183";}s:7:"banners";a:0:{}s:11:"banners_rtl";a:0:{}s:8:"requires";s:5:"3.0.1";}s:27:"wp-optimize/wp-optimize.php";O:8:"stdClass":10:{s:2:"id";s:25:"w.org/plugins/wp-optimize";s:4:"slug";s:11:"wp-optimize";s:6:"plugin";s:27:"wp-optimize/wp-optimize.php";s:11:"new_version";s:5:"3.7.0";s:3:"url";s:42:"https://wordpress.org/plugins/wp-optimize/";s:7:"package";s:60:"https://downloads.wordpress.org/plugin/wp-optimize.3.7.0.zip";s:5:"icons";a:2:{s:2:"2x";s:64:"https://ps.w.org/wp-optimize/assets/icon-256x256.png?rev=1552899";s:2:"1x";s:64:"https://ps.w.org/wp-optimize/assets/icon-128x128.png?rev=1552899";}s:7:"banners";a:2:{s:2:"2x";s:67:"https://ps.w.org/wp-optimize/assets/banner-1544x500.png?rev=2125385";s:2:"1x";s:66:"https://ps.w.org/wp-optimize/assets/banner-772x250.png?rev=2125385";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.5";}s:39:"wp-file-manager/file_folder_manager.php";O:8:"stdClass":10:{s:2:"id";s:29:"w.org/plugins/wp-file-manager";s:4:"slug";s:15:"wp-file-manager";s:6:"plugin";s:39:"wp-file-manager/file_folder_manager.php";s:11:"new_version";s:3:"8.0";s:3:"url";s:46:"https://wordpress.org/plugins/wp-file-manager/";s:7:"package";s:58:"https://downloads.wordpress.org/plugin/wp-file-manager.zip";s:5:"icons";a:1:{s:2:"1x";s:68:"https://ps.w.org/wp-file-manager/assets/icon-128x128.png?rev=2491299";}s:7:"banners";a:1:{s:2:"1x";s:70:"https://ps.w.org/wp-file-manager/assets/banner-772x250.jpg?rev=2491299";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.0";}s:33:"wp-performance/wp-performance.php";O:8:"stdClass":10:{s:2:"id";s:28:"w.org/plugins/wp-performance";s:4:"slug";s:14:"wp-performance";s:6:"plugin";s:33:"wp-performance/wp-performance.php";s:11:"new_version";s:7:"1.1.8.3";s:3:"url";s:45:"https://wordpress.org/plugins/wp-performance/";s:7:"package";s:57:"https://downloads.wordpress.org/plugin/wp-performance.zip";s:5:"icons";a:1:{s:2:"1x";s:67:"https://ps.w.org/wp-performance/assets/icon-128x128.png?rev=2002746";}s:7:"banners";a:1:{s:2:"1x";s:69:"https://ps.w.org/wp-performance/assets/banner-772x250.png?rev=2002746";}s:11:"banners_rtl";a:0:{}s:8:"requires";s:3:"4.7";}s:37:"wp-reroute-email/wp-reroute-email.php";O:8:"stdClass":10:{s:2:"id";s:30:"w.org/plugins/wp-reroute-email";s:4:"slug";s:16:"wp-reroute-email";s:6:"plugin";s:37:"wp-reroute-email/wp-reroute-email.php";s:11:"new_version";s:5:"1.5.0";s:3:"url";s:47:"https://wordpress.org/plugins/wp-reroute-email/";s:7:"package";s:65:"https://downloads.wordpress.org/plugin/wp-reroute-email.1.5.0.zip";s:5:"icons";a:1:{s:7:"default";s:67:"https://s.w.org/plugins/geopattern-icon/wp-reroute-email_d1e8de.svg";}s:7:"banners";a:1:{s:2:"1x";s:71:"https://ps.w.org/wp-reroute-email/assets/banner-772x250.png?rev=1468438";}s:11:"banners_rtl";a:0:{}s:8:"requires";b:0;}s:34:"advanced-custom-fields-pro/acf.php";O:8:"stdClass":12:{s:4:"slug";s:26:"advanced-custom-fields-pro";s:6:"plugin";s:34:"advanced-custom-fields-pro/acf.php";s:11:"new_version";s:5:"6.3.9";s:3:"url";s:36:"https://www.advancedcustomfields.com";s:6:"tested";s:5:"6.6.2";s:7:"package";s:0:"";s:5:"icons";a:1:{s:7:"default";s:64:"https://connect.advancedcustomfields.com/assets/icon-256x256.png";}s:7:"banners";a:2:{s:3:"low";s:66:"https://connect.advancedcustomfields.com/assets/banner-772x250.jpg";s:4:"high";s:67:"https://connect.advancedcustomfields.com/assets/banner-1544x500.jpg";}s:8:"requires";s:3:"6.0";s:12:"requires_php";s:3:"7.4";s:12:"release_date";s:8:"20241015";s:6:"reason";s:10:"up_to_date";}}s:7:"checked";a:55:{s:41:"acf-code-generator/acf_code_generator.php";s:5:"1.0.2";s:29:"acf-extended/acf-extended.php";s:7:"0.9.0.7";s:41:"acf-theme-code-pro/acf_theme_code_pro.php";s:5:"2.5.6";s:34:"advanced-custom-fields-pro/acf.php";s:5:"6.3.9";s:51:"all-in-one-wp-migration/all-in-one-wp-migration.php";s:4:"7.87";s:91:"all-in-one-wp-migration-unlimited-extension/all-in-one-wp-migration-unlimited-extension.php";s:4:"2.49";s:51:"all-in-one-wp-security-and-firewall/wp-security.php";s:5:"5.3.4";s:41:"another-show-hooks/another-show-hooks.php";s:5:"1.0.2";s:43:"broken-link-checker/broken-link-checker.php";s:5:"2.4.1";s:39:"bulk-page-creator/bulk-page-creator.php";s:5:"1.1.4";s:53:"child-theme-configurator/child-theme-configurator.php";s:5:"2.6.6";s:41:"child-theme-wizard/child-theme-wizard.php";s:3:"1.4";s:33:"classic-editor/classic-editor.php";s:5:"1.6.5";s:35:"classic-widgets/classic-widgets.php";s:3:"0.3";s:33:"code-generator/code-generator.php";s:3:"1.0";s:33:"complianz-gdpr/complianz-gpdr.php";s:5:"7.1.0";s:36:"contact-form-7/wp-contact-form-7.php";s:5:"5.9.8";s:42:"contact-form-cfdb7/contact-form-cfdb-7.php";s:5:"1.2.7";s:53:"customizer-export-import/customizer-export-import.php";s:7:"0.9.7.3";s:43:"custom-post-type-ui/custom-post-type-ui.php";s:6:"1.17.1";s:39:"https-redirection/https-redirection.php";s:5:"1.9.2";s:45:"enable-svg-webp-ico-upload/itc-svg-upload.php";s:5:"1.0.6";s:25:"auto-sizes/auto-sizes.php";s:5:"1.3.0";s:45:"ewww-image-optimizer/ewww-image-optimizer.php";s:5:"7.9.0";s:25:"fakerpress/fakerpress.php";s:5:"0.6.6";s:29:"health-check/health-check.php";s:5:"1.7.1";s:36:"contact-form-7-honeypot/honeypot.php";s:5:"2.1.5";s:29:"http-headers/http-headers.php";s:6:"1.19.1";s:30:"dominant-color-images/load.php";s:5:"1.1.2";s:53:"index-wp-mysql-for-speed/index-wp-mysql-for-speed.php";s:5:"1.5.2";s:35:"litespeed-cache/litespeed-cache.php";s:5:"6.5.2";s:21:"webp-uploads/load.php";s:5:"2.2.0";s:24:"performance-lab/load.php";s:5:"3.5.1";s:45:"performance-profiler/performance-profiler.php";s:5:"0.1.0";s:51:"performant-translations/performant-translations.php";s:5:"1.2.0";s:55:"plugins-garbage-collector/plugins-garbage-collector.php";s:4:"0.14";s:31:"query-monitor/query-monitor.php";s:6:"3.16.4";s:39:"query-monitor-log-viewer/log-viewer.php";s:8:"14.05.04";s:30:"seo-by-rank-math/rank-math.php";s:7:"1.0.230";s:17:"revisr/revisr.php";s:5:"2.0.2";s:45:"search-and-replace/inpsyde-search-replace.php";s:5:"3.2.3";s:33:"seo-image/seo-friendly-images.php";s:5:"3.0.5";s:43:"site-health-manager/site-health-manager.php";s:5:"1.1.2";s:35:"google-site-kit/google-site-kit.php";s:7:"1.138.0";s:27:"svg-support/svg-support.php";s:5:"2.5.8";s:25:"ukr-to-lat/ukr-to-lat.php";s:5:"1.3.5";s:27:"updraftplus/updraftplus.php";s:6:"1.24.6";s:53:"widget-importer-exporter/widget-importer-exporter.php";s:5:"1.6.1";s:23:"wordfence/wordfence.php";s:6:"7.11.7";s:41:"wordpress-importer/wordpress-importer.php";s:5:"0.8.3";s:36:"inspector-wp/wordpress-inspector.php";s:5:"1.1.0";s:27:"wp-optimize/wp-optimize.php";s:5:"3.7.0";s:39:"wp-file-manager/file_folder_manager.php";s:3:"8.0";s:33:"wp-performance/wp-performance.php";s:7:"1.1.8.3";s:37:"wp-reroute-email/wp-reroute-email.php";s:5:"1.5.0";}}', 'off'),
	(2989, '_site_transient_update_themes', 'O:8:"stdClass":5:{s:12:"last_checked";i:1729718620;s:7:"checked";a:4:{s:19:"axio-starter-master";s:5:"1.0.0";s:16:"twentytwentyfour";s:3:"1.2";s:15:"twentytwentyone";s:3:"2.3";s:7:"wp-wpeb";s:10:"2024-07-23";}s:8:"response";a:0:{}s:9:"no_update";a:2:{s:16:"twentytwentyfour";a:6:{s:5:"theme";s:16:"twentytwentyfour";s:11:"new_version";s:3:"1.2";s:3:"url";s:46:"https://wordpress.org/themes/twentytwentyfour/";s:7:"package";s:62:"https://downloads.wordpress.org/theme/twentytwentyfour.1.2.zip";s:8:"requires";s:3:"6.4";s:12:"requires_php";s:3:"7.0";}s:15:"twentytwentyone";a:6:{s:5:"theme";s:15:"twentytwentyone";s:11:"new_version";s:3:"2.3";s:3:"url";s:45:"https://wordpress.org/themes/twentytwentyone/";s:7:"package";s:61:"https://downloads.wordpress.org/theme/twentytwentyone.2.3.zip";s:8:"requires";s:3:"5.3";s:12:"requires_php";s:3:"5.6";}}s:12:"translations";a:0:{}}', 'off'),
	(2927, '_site_transient_wp_plugin_dependencies_plugin_data', 'a:1:{s:14:"contact-form-7";a:35:{s:4:"name";s:14:"Contact Form 7";s:4:"slug";s:14:"contact-form-7";s:7:"version";s:5:"5.9.8";s:6:"author";s:62:"<a href="https://ideasilo.wordpress.com/">Takayuki Miyoshi</a>";s:14:"author_profile";s:44:"https://profiles.wordpress.org/takayukister/";s:12:"contributors";a:1:{s:12:"takayukister";a:3:{s:7:"profile";s:44:"https://profiles.wordpress.org/takayukister/";s:6:"avatar";s:88:"https://secure.gravatar.com/avatar/bb7bc21850c77e9eb16b44102f4a539d?s=96&d=monsterid&r=g";s:12:"display_name";s:16:"Takayuki Miyoshi";}}s:8:"requires";s:3:"6.3";s:6:"tested";s:5:"6.6.2";s:12:"requires_php";s:3:"7.4";s:16:"requires_plugins";a:0:{}s:6:"rating";i:80;s:7:"ratings";a:5:{i:5;i:1424;i:4;i:145;i:3;i:73;i:2;i:67;i:1;i:400;}s:11:"num_ratings";i:2109;s:11:"support_url";s:52:"https://wordpress.org/support/plugin/contact-form-7/";s:15:"support_threads";i:205;s:24:"support_threads_resolved";i:68;s:15:"active_installs";i:10000000;s:12:"last_updated";s:21:"2024-07-25 8:29am GMT";s:5:"added";s:10:"2007-08-02";s:8:"homepage";s:25:"https://contactform7.com/";s:8:"sections";a:6:{s:11:"description";s:3042:"<p>Contact Form 7 can manage multiple contact forms, plus you can customize the form and the mail contents flexibly with simple markup. The form supports Ajax-powered submitting, CAPTCHA, Akismet spam filtering and so on.</p>\n<h4>Docs and support</h4>\n<p>You can find <a href="https://contactform7.com/docs/" rel="nofollow ugc">docs</a>, <a href="https://contactform7.com/faq/" rel="nofollow ugc">FAQ</a> and more detailed information about Contact Form 7 on <a href="https://contactform7.com/" rel="nofollow ugc">contactform7.com</a>. When you cannot find the answer to your question on the FAQ or in any of the documentation, check the <a href="https://wordpress.org/support/plugin/contact-form-7/" rel="ugc">support forum</a> on WordPress.org. If you cannot locate any topics that pertain to your particular issue, post a new topic for it.</p>\n<h4>Contact Form 7 needs your support</h4>\n<p>It is hard to continue development and support for this free plugin without contributions from users like you. If you enjoy using Contact Form 7 and find it useful, please consider <a href="https://contactform7.com/donate/" rel="nofollow ugc">making a donation</a>. Your donation will help encourage and support the plugin&#8217;s continued development and better user support.</p>\n<h4>Privacy notices</h4>\n<p>With the default configuration, this plugin, in itself, does not:</p>\n<ul>\n<li>track users by stealth;</li>\n<li>write any user personal data to the database;</li>\n<li>send any data to external servers;</li>\n<li>use cookies.</li>\n</ul>\n<p>If you activate certain features in this plugin, the contact form submitter&#8217;s personal data, including their IP address, may be sent to the service provider. Thus, confirming the provider&#8217;s privacy policy is recommended. These features include:</p>\n<ul>\n<li>reCAPTCHA (<a href="https://policies.google.com/?hl=en" rel="nofollow ugc">Google</a>)</li>\n<li>Akismet (<a href="https://automattic.com/privacy/" rel="nofollow ugc">Automattic</a>)</li>\n<li><a href="https://www.constantcontact.com/legal/privacy-center" rel="nofollow ugc">Constant Contact</a></li>\n<li><a href="https://www.brevo.com/legal/privacypolicy/" rel="nofollow ugc">Brevo</a></li>\n<li><a href="https://stripe.com/privacy" rel="nofollow ugc">Stripe</a></li>\n</ul>\n<h4>Recommended plugins</h4>\n<p>The following plugins are recommended for Contact Form 7 users:</p>\n<ul>\n<li><a href="https://wordpress.org/plugins/flamingo/" rel="ugc">Flamingo</a> by Takayuki Miyoshi &#8211; With Flamingo, you can save submitted messages via contact forms in the database.</li>\n<li><a href="https://wordpress.org/plugins/bogo/" rel="ugc">Bogo</a> by Takayuki Miyoshi &#8211; Bogo is a straight-forward multilingual plugin that does not cause headaches.</li>\n</ul>\n<h4>Translations</h4>\n<p>You can <a href="https://contactform7.com/translating-contact-form-7/" rel="nofollow ugc">translate Contact Form 7</a> on <a href="https://translate.wordpress.org/projects/wp-plugins/contact-form-7" rel="nofollow ugc">translate.wordpress.org</a>.</p>\n";s:12:"installation";s:458:"<ol>\n<li>Upload the entire <code>contact-form-7</code> folder to the <code>/wp-content/plugins/</code> directory.</li>\n<li>Activate the plugin through the <strong>Plugins</strong> screen (<strong>Plugins &gt; Installed Plugins</strong>).</li>\n</ol>\n<p>You will find <strong>Contact</strong> menu in your WordPress admin screen.</p>\n<p>For basic usage, have a look at the <a href="https://contactform7.com/" rel="nofollow ugc">plugin&#8217;s website</a>.</p>\n";s:3:"faq";s:449:"<p>Do you have questions or issues with Contact Form 7? Use these support channels appropriately.</p>\n<ol>\n<li><a href="https://contactform7.com/docs/" rel="nofollow ugc">Docs</a></li>\n<li><a href="https://contactform7.com/faq/" rel="nofollow ugc">FAQ</a></li>\n<li><a href="https://wordpress.org/support/plugin/contact-form-7/" rel="ugc">Support forum</a></li>\n</ol>\n<p><a href="https://contactform7.com/support/" rel="nofollow ugc">Support</a></p>\n";s:9:"changelog";s:2427:"<p>For more information, see <a href="https://contactform7.com/category/releases/" rel="nofollow ugc">Releases</a>.</p>\n<h4>5.9.8</h4>\n<ul>\n<li>Fixes a bug that prevents the contact form selector block from working on 6.3-6.5 versions of WordPress.</li>\n</ul>\n<h4>5.9.7</h4>\n<p><a href="https://contactform7.com/contact-form-7-597/" rel="nofollow ugc">https://contactform7.com/contact-form-7-597/</a></p>\n<h4>5.9.6</h4>\n<p><a href="https://contactform7.com/contact-form-7-596/" rel="nofollow ugc">https://contactform7.com/contact-form-7-596/</a></p>\n<h4>5.9.5</h4>\n<p><a href="https://contactform7.com/contact-form-7-595/" rel="nofollow ugc">https://contactform7.com/contact-form-7-595/</a></p>\n<h4>5.9.4</h4>\n<p><a href="https://contactform7.com/contact-form-7-594/" rel="nofollow ugc">https://contactform7.com/contact-form-7-594/</a></p>\n<h4>5.9.3</h4>\n<p><a href="https://contactform7.com/contact-form-7-593/" rel="nofollow ugc">https://contactform7.com/contact-form-7-593/</a></p>\n<h4>5.9.2</h4>\n<p><a href="https://contactform7.com/contact-form-7-592/" rel="nofollow ugc">https://contactform7.com/contact-form-7-592/</a></p>\n<h4>5.9</h4>\n<p><a href="https://contactform7.com/contact-form-7-59/" rel="nofollow ugc">https://contactform7.com/contact-form-7-59/</a></p>\n<h4>5.8.7</h4>\n<p><a href="https://contactform7.com/contact-form-7-587/" rel="nofollow ugc">https://contactform7.com/contact-form-7-587/</a></p>\n<h4>5.8.6</h4>\n<p><a href="https://contactform7.com/contact-form-7-586/" rel="nofollow ugc">https://contactform7.com/contact-form-7-586/</a></p>\n<h4>5.8.5</h4>\n<p><a href="https://contactform7.com/contact-form-7-585/" rel="nofollow ugc">https://contactform7.com/contact-form-7-585/</a></p>\n<h4>5.8.4</h4>\n<p><a href="https://contactform7.com/contact-form-7-584/" rel="nofollow ugc">https://contactform7.com/contact-form-7-584/</a></p>\n<h4>5.8.3</h4>\n<p><a href="https://contactform7.com/contact-form-7-583/" rel="nofollow ugc">https://contactform7.com/contact-form-7-583/</a></p>\n<h4>5.8.2</h4>\n<p><a href="https://contactform7.com/contact-form-7-582/" rel="nofollow ugc">https://contactform7.com/contact-form-7-582/</a></p>\n<h4>5.8.1</h4>\n<p><a href="https://contactform7.com/contact-form-7-581/" rel="nofollow ugc">https://contactform7.com/contact-form-7-581/</a></p>\n<h4>5.8</h4>\n<p><a href="https://contactform7.com/contact-form-7-58/" rel="nofollow ugc">https://contactform7.com/contact-form-7-58/</a></p>\n";s:11:"screenshots";s:225:"<ol><li><a href="https://ps.w.org/contact-form-7/assets/screenshot-1.png?rev=1176454"><img src="https://ps.w.org/contact-form-7/assets/screenshot-1.png?rev=1176454" alt="screenshot-1.png"></a><p>screenshot-1.png</p></li></ol>";s:7:"reviews";s:15774:"<div class="review">\n	<div class="review-head">\n		<div class="reviewer-info">\n			<div class="review-title-section">\n				<h4 class="review-title">A Great Plugin</h4>\n				<div class="star-rating">\n				<div class="wporg-ratings" aria-label="5 out of 5 stars" data-title-template="%s out of 5 stars" data-rating="5" style="color:#ffb900;"><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span></div>				</div>\n			</div>\n			<p class="reviewer">\n				By <a href="https://profiles.wordpress.org/pagetec/"><img alt=\'\' src=\'https://secure.gravatar.com/avatar/d2313de5e102668b0779bc6d7ca1ad1c?s=16&#038;d=monsterid&#038;r=g\' srcset=\'https://secure.gravatar.com/avatar/d2313de5e102668b0779bc6d7ca1ad1c?s=32&#038;d=monsterid&#038;r=g 2x\' class=\'avatar avatar-16 photo\' height=\'16\' width=\'16\' loading=\'lazy\' decoding=\'async\'/></a><a href="https://profiles.wordpress.org/pagetec/" class="reviewer-name">PageTec <small>(pagetec)</small></a> on <span class="review-date">October 22, 2024</span>			</p>\n		</div>\n	</div>\n	<div class="review-body"><!-- wp:paragraph -->\n<p>Contact Form 7 is a great plugin for WordPress. It\'s easy to use and flexible for creating all kinds of forms. It\'s reliable and regularly updated, making it a top choice for any WordPress site.</p>\n<!-- /wp:paragraph --></div>\n</div>\n<div class="review">\n	<div class="review-head">\n		<div class="reviewer-info">\n			<div class="review-title-section">\n				<h4 class="review-title">Amazing</h4>\n				<div class="star-rating">\n				<div class="wporg-ratings" aria-label="5 out of 5 stars" data-title-template="%s out of 5 stars" data-rating="5" style="color:#ffb900;"><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span></div>				</div>\n			</div>\n			<p class="reviewer">\n				By <a href="https://profiles.wordpress.org/labsii/"><img alt=\'\' src=\'https://secure.gravatar.com/avatar/a9e843891eed8e0294135e03d606b2af?s=16&#038;d=monsterid&#038;r=g\' srcset=\'https://secure.gravatar.com/avatar/a9e843891eed8e0294135e03d606b2af?s=32&#038;d=monsterid&#038;r=g 2x\' class=\'avatar avatar-16 photo\' height=\'16\' width=\'16\' loading=\'lazy\' decoding=\'async\'/></a><a href="https://profiles.wordpress.org/labsii/" class="reviewer-name">labsii</a> on <span class="review-date">October 21, 2024</span>			</p>\n		</div>\n	</div>\n	<div class="review-body"><!-- wp:paragraph -->\n<p>With a bit of setup you can avoid spammers.</p>\n<!-- /wp:paragraph --></div>\n</div>\n<div class="review">\n	<div class="review-head">\n		<div class="reviewer-info">\n			<div class="review-title-section">\n				<h4 class="review-title">good plugin but errors in console need to be fixed</h4>\n				<div class="star-rating">\n				<div class="wporg-ratings" aria-label="4 out of 5 stars" data-title-template="%s out of 5 stars" data-rating="4" style="color:#ffb900;"><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-empty"></span></div>				</div>\n			</div>\n			<p class="reviewer">\n				By <a href="https://profiles.wordpress.org/worldwisdom/"><img alt=\'\' src=\'https://secure.gravatar.com/avatar/a4df4086f4e509af8ab8221022d6dca9?s=16&#038;d=monsterid&#038;r=g\' srcset=\'https://secure.gravatar.com/avatar/a4df4086f4e509af8ab8221022d6dca9?s=32&#038;d=monsterid&#038;r=g 2x\' class=\'avatar avatar-16 photo\' height=\'16\' width=\'16\' loading=\'lazy\' decoding=\'async\'/></a><a href="https://profiles.wordpress.org/worldwisdom/" class="reviewer-name">Kate <small>(worldwisdom)</small></a> on <span class="review-date">October 11, 2024</span>			</p>\n		</div>\n	</div>\n	<div class="review-body"><!-- wp:paragraph -->\n<p>Good plugin. I have used for quite some time, but there are outstanding issues and seems like some javascript conflicts with other scripts in WP. There are some errors in console that appear occasionally, related to Contact Form. But it does not seem to cause enough trouble to stop using it. Hopefully the issues will be fixed as there are plenty of other users pointing to the issues.</p>\n<!-- /wp:paragraph --></div>\n</div>\n<div class="review">\n	<div class="review-head">\n		<div class="reviewer-info">\n			<div class="review-title-section">\n				<h4 class="review-title">Hard to use</h4>\n				<div class="star-rating">\n				<div class="wporg-ratings" aria-label="2 out of 5 stars" data-title-template="%s out of 5 stars" data-rating="2" style="color:#ffb900;"><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-empty"></span><span class="star dashicons dashicons-star-empty"></span><span class="star dashicons dashicons-star-empty"></span></div>				</div>\n			</div>\n			<p class="reviewer">\n				By <a href="https://profiles.wordpress.org/swd38/"><img alt=\'\' src=\'https://secure.gravatar.com/avatar/a5a1c9eeddd7ce46582aa12a8d7bc12d?s=16&#038;d=monsterid&#038;r=g\' srcset=\'https://secure.gravatar.com/avatar/a5a1c9eeddd7ce46582aa12a8d7bc12d?s=32&#038;d=monsterid&#038;r=g 2x\' class=\'avatar avatar-16 photo\' height=\'16\' width=\'16\' loading=\'lazy\' decoding=\'async\'/></a><a href="https://profiles.wordpress.org/swd38/" class="reviewer-name">sw38 <small>(swd38)</small></a> on <span class="review-date">October 3, 2024</span>			</p>\n		</div>\n	</div>\n	<div class="review-body"><!-- wp:paragraph -->\n<p>Hard to use. The UI should be improved.</p>\n<!-- /wp:paragraph --></div>\n</div>\n<div class="review">\n	<div class="review-head">\n		<div class="reviewer-info">\n			<div class="review-title-section">\n				<h4 class="review-title">Gets heavier with each update</h4>\n				<div class="star-rating">\n				<div class="wporg-ratings" aria-label="1 out of 5 stars" data-title-template="%s out of 5 stars" data-rating="1" style="color:#ffb900;"><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-empty"></span><span class="star dashicons dashicons-star-empty"></span><span class="star dashicons dashicons-star-empty"></span><span class="star dashicons dashicons-star-empty"></span></div>				</div>\n			</div>\n			<p class="reviewer">\n				By <a href="https://profiles.wordpress.org/andre1dev/"><img alt=\'\' src=\'https://secure.gravatar.com/avatar/59e602a3de5ad74321c8e44d784e7054?s=16&#038;d=monsterid&#038;r=g\' srcset=\'https://secure.gravatar.com/avatar/59e602a3de5ad74321c8e44d784e7054?s=32&#038;d=monsterid&#038;r=g 2x\' class=\'avatar avatar-16 photo\' height=\'16\' width=\'16\' loading=\'lazy\' decoding=\'async\'/></a><a href="https://profiles.wordpress.org/andre1dev/" class="reviewer-name">andre1dev</a> on <span class="review-date">September 16, 2024</span>			</p>\n		</div>\n	</div>\n	<div class="review-body"><!-- wp:paragraph -->\n<p>With each update, a new js file or ajax call appears to slow down the page. If only they were useful, but they are useless, and worst of all, any attempt to get support is ignored. Just search the forum for: .../feedback, .../schema (which is 0 bytes but takes 500ms every time), .../swv/index.js. And in the latest update, it now forces the loading of hooks.js and i18n.js</p>\n<!-- /wp:paragraph --></div>\n</div>\n<div class="review">\n	<div class="review-head">\n		<div class="reviewer-info">\n			<div class="review-title-section">\n				<h4 class="review-title">Excellent Plugin, need one more option</h4>\n				<div class="star-rating">\n				<div class="wporg-ratings" aria-label="5 out of 5 stars" data-title-template="%s out of 5 stars" data-rating="5" style="color:#ffb900;"><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span></div>				</div>\n			</div>\n			<p class="reviewer">\n				By <a href="https://profiles.wordpress.org/ejda/"><img alt=\'\' src=\'https://secure.gravatar.com/avatar/b47e4dbd0371fb65a57021dd5823ed5d?s=16&#038;d=monsterid&#038;r=g\' srcset=\'https://secure.gravatar.com/avatar/b47e4dbd0371fb65a57021dd5823ed5d?s=32&#038;d=monsterid&#038;r=g 2x\' class=\'avatar avatar-16 photo\' height=\'16\' width=\'16\' loading=\'lazy\' decoding=\'async\'/></a><a href="https://profiles.wordpress.org/ejda/" class="reviewer-name">Ejda <small>(ejda)</small></a> on <span class="review-date">September 13, 2024</span>			</p>\n		</div>\n	</div>\n	<div class="review-body"><!-- wp:paragraph -->\n<p>Hi, Is there option to put reCaptcha invisible in that contact form?<br />I have reCaptcha on all my pages, but can\'t find out how it can be invisible.<br />I apologize if my question is not correlated with Contact Form 7.</p>\n<!-- /wp:paragraph --></div>\n</div>\n<div class="review">\n	<div class="review-head">\n		<div class="reviewer-info">\n			<div class="review-title-section">\n				<h4 class="review-title">Useless Support</h4>\n				<div class="star-rating">\n				<div class="wporg-ratings" aria-label="1 out of 5 stars" data-title-template="%s out of 5 stars" data-rating="1" style="color:#ffb900;"><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-empty"></span><span class="star dashicons dashicons-star-empty"></span><span class="star dashicons dashicons-star-empty"></span><span class="star dashicons dashicons-star-empty"></span></div>				</div>\n			</div>\n			<p class="reviewer">\n				By <a href="https://profiles.wordpress.org/ahmerhassan110/"><img alt=\'\' src=\'https://secure.gravatar.com/avatar/4bbdd8993801b17de0d239dff922d0e1?s=16&#038;d=monsterid&#038;r=g\' srcset=\'https://secure.gravatar.com/avatar/4bbdd8993801b17de0d239dff922d0e1?s=32&#038;d=monsterid&#038;r=g 2x\' class=\'avatar avatar-16 photo\' height=\'16\' width=\'16\' loading=\'lazy\' decoding=\'async\'/></a><a href="https://profiles.wordpress.org/ahmerhassan110/" class="reviewer-name">wpcoder110 <small>(ahmerhassan110)</small></a> on <span class="review-date">September 1, 2024</span>			</p>\n		</div>\n	</div>\n	<div class="review-body"><!-- wp:paragraph -->\n<p>What a useless developer. Can not reply to support requests!!!<br />support/topic/add-a-code-to-validation-class-please</p>\n<!-- /wp:paragraph --></div>\n</div>\n<div class="review">\n	<div class="review-head">\n		<div class="reviewer-info">\n			<div class="review-title-section">\n				<h4 class="review-title">Amazing - and free?!?</h4>\n				<div class="star-rating">\n				<div class="wporg-ratings" aria-label="5 out of 5 stars" data-title-template="%s out of 5 stars" data-rating="5" style="color:#ffb900;"><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span></div>				</div>\n			</div>\n			<p class="reviewer">\n				By <a href="https://profiles.wordpress.org/heiseheise/"><img alt=\'\' src=\'https://secure.gravatar.com/avatar/08535cba542fdc1ecf5cf330fdbafcab?s=16&#038;d=monsterid&#038;r=g\' srcset=\'https://secure.gravatar.com/avatar/08535cba542fdc1ecf5cf330fdbafcab?s=32&#038;d=monsterid&#038;r=g 2x\' class=\'avatar avatar-16 photo\' height=\'16\' width=\'16\' loading=\'lazy\' decoding=\'async\'/></a><a href="https://profiles.wordpress.org/heiseheise/" class="reviewer-name"> <small>(heiseheise)</small></a> on <span class="review-date">August 28, 2024</span>			</p>\n		</div>\n	</div>\n	<div class="review-body"><!-- wp:paragraph -->\n<p>Coming from the 800 pound gorilla in the Wordpress contact form room (cough WPForms cough) that gatekeeps almost everything it can do beyond the simplest form in their paid form (and it\'s not even a one-time fee, they want money constantly!) - Contact Form 7 is a welcome breath of fresh air.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>I was able to set up exactly what I needed within 30 minutes with the detailed help docs the author provided. Once I get confirmation from the rest of the folks in my org (we run a non-profit community cohousing building) we\'ll definitely be donating $20-30 for the devs time. It\'s so nice to see a truly free product out there - everyone should donate to thank the author.</p>\n<!-- /wp:paragraph --></div>\n</div>\n<div class="review">\n	<div class="review-head">\n		<div class="reviewer-info">\n			<div class="review-title-section">\n				<h4 class="review-title">The best plugin for contact form</h4>\n				<div class="star-rating">\n				<div class="wporg-ratings" aria-label="5 out of 5 stars" data-title-template="%s out of 5 stars" data-rating="5" style="color:#ffb900;"><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span></div>				</div>\n			</div>\n			<p class="reviewer">\n				By <a href="https://profiles.wordpress.org/rider7991/"><img alt=\'\' src=\'https://secure.gravatar.com/avatar/d33ea25668b95c613a49ad27daac1736?s=16&#038;d=monsterid&#038;r=g\' srcset=\'https://secure.gravatar.com/avatar/d33ea25668b95c613a49ad27daac1736?s=32&#038;d=monsterid&#038;r=g 2x\' class=\'avatar avatar-16 photo\' height=\'16\' width=\'16\' loading=\'lazy\' decoding=\'async\'/></a><a href="https://profiles.wordpress.org/rider7991/" class="reviewer-name">mbdNnse <small>(rider7991)</small></a> on <span class="review-date">August 8, 2024</span>			</p>\n		</div>\n	</div>\n	<div class="review-body"><!-- wp:paragraph -->\n<p>I do not use many plugins but this is one of 2-3 essentials</p>\n<!-- /wp:paragraph --></div>\n</div>\n<div class="review">\n	<div class="review-head">\n		<div class="reviewer-info">\n			<div class="review-title-section">\n				<h4 class="review-title">Nach Einarbeitungsphase stabile Umsetzung</h4>\n				<div class="star-rating">\n				<div class="wporg-ratings" aria-label="5 out of 5 stars" data-title-template="%s out of 5 stars" data-rating="5" style="color:#ffb900;"><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span><span class="star dashicons dashicons-star-filled"></span></div>				</div>\n			</div>\n			<p class="reviewer">\n				By <a href="https://profiles.wordpress.org/mehralsheidi/"><img alt=\'\' src=\'https://secure.gravatar.com/avatar/8125c22b2ac887a252c115000005cde1?s=16&#038;d=monsterid&#038;r=g\' srcset=\'https://secure.gravatar.com/avatar/8125c22b2ac887a252c115000005cde1?s=32&#038;d=monsterid&#038;r=g 2x\' class=\'avatar avatar-16 photo\' height=\'16\' width=\'16\' loading=\'lazy\' decoding=\'async\'/></a><a href="https://profiles.wordpress.org/mehralsheidi/" class="reviewer-name">mehralsheidi</a> on <span class="review-date">August 3, 2024</span>			</p>\n		</div>\n	</div>\n	<div class="review-body"><!-- wp:paragraph -->\n<p>Es hat zwar eine Weile gedauert, bis ich alle Funktionen - vor allem die, die ich benötigte - zu finden und einzurichten, seitdem funktioniert alles aber wunderbar. Ich bin sehr dankbar für dieses PlugIn. Zudem habe ich Advanced ReCaptcha eingefügt.</p>\n<!-- /wp:paragraph --></div>\n</div>\n";}s:17:"short_description";s:54:"Just another contact form plugin. Simple but flexible.";s:13:"download_link";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.9.8.zip";s:14:"upgrade_notice";a:0:{}s:11:"screenshots";a:1:{i:1;a:2:{s:3:"src";s:67:"https://ps.w.org/contact-form-7/assets/screenshot-1.png?rev=1176454";s:7:"caption";s:16:"screenshot-1.png";}}s:4:"tags";a:2:{s:12:"contact-form";s:12:"contact form";s:23:"schema-woven-validation";s:23:"schema-woven validation";}s:8:"versions";a:189:{s:3:"1.1";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.1.1.zip";s:4:"1.10";s:62:"https://downloads.wordpress.org/plugin/contact-form-7.1.10.zip";s:8:"1.10.0.1";s:66:"https://downloads.wordpress.org/plugin/contact-form-7.1.10.0.1.zip";s:6:"1.10.1";s:64:"https://downloads.wordpress.org/plugin/contact-form-7.1.10.1.zip";s:3:"1.2";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.1.2.zip";s:3:"1.3";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.1.3.zip";s:5:"1.3.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.3.1.zip";s:5:"1.3.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.3.2.zip";s:3:"1.4";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.1.4.zip";s:5:"1.4.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.4.1.zip";s:5:"1.4.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.4.2.zip";s:5:"1.4.3";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.4.3.zip";s:5:"1.4.4";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.4.4.zip";s:3:"1.5";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.1.5.zip";s:3:"1.6";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.1.6.zip";s:5:"1.6.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.6.1.zip";s:3:"1.7";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.1.7.zip";s:5:"1.7.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.7.1.zip";s:5:"1.7.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.7.2.zip";s:5:"1.7.4";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.7.4.zip";s:5:"1.7.5";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.7.5.zip";s:5:"1.7.6";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.7.6.zip";s:7:"1.7.6.1";s:65:"https://downloads.wordpress.org/plugin/contact-form-7.1.7.6.1.zip";s:5:"1.7.7";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.7.7.zip";s:7:"1.7.7.1";s:65:"https://downloads.wordpress.org/plugin/contact-form-7.1.7.7.1.zip";s:5:"1.7.8";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.7.8.zip";s:3:"1.8";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.1.8.zip";s:7:"1.8.0.1";s:65:"https://downloads.wordpress.org/plugin/contact-form-7.1.8.0.1.zip";s:7:"1.8.0.2";s:65:"https://downloads.wordpress.org/plugin/contact-form-7.1.8.0.2.zip";s:7:"1.8.0.3";s:65:"https://downloads.wordpress.org/plugin/contact-form-7.1.8.0.3.zip";s:7:"1.8.0.4";s:65:"https://downloads.wordpress.org/plugin/contact-form-7.1.8.0.4.zip";s:5:"1.8.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.8.1.zip";s:7:"1.8.1.1";s:65:"https://downloads.wordpress.org/plugin/contact-form-7.1.8.1.1.zip";s:3:"1.9";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.1.9.zip";s:5:"1.9.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.9.1.zip";s:5:"1.9.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.9.2.zip";s:7:"1.9.2.1";s:65:"https://downloads.wordpress.org/plugin/contact-form-7.1.9.2.1.zip";s:7:"1.9.2.2";s:65:"https://downloads.wordpress.org/plugin/contact-form-7.1.9.2.2.zip";s:5:"1.9.3";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.9.3.zip";s:5:"1.9.4";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.9.4.zip";s:5:"1.9.5";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.1.9.5.zip";s:7:"1.9.5.1";s:65:"https://downloads.wordpress.org/plugin/contact-form-7.1.9.5.1.zip";s:3:"2.0";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.2.0.zip";s:8:"2.0-beta";s:66:"https://downloads.wordpress.org/plugin/contact-form-7.2.0-beta.zip";s:5:"2.0.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.0.1.zip";s:5:"2.0.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.0.2.zip";s:5:"2.0.3";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.0.3.zip";s:5:"2.0.4";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.0.4.zip";s:5:"2.0.5";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.0.5.zip";s:5:"2.0.6";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.0.6.zip";s:5:"2.0.7";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.0.7.zip";s:3:"2.1";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.2.1.zip";s:5:"2.1.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.1.1.zip";s:5:"2.1.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.1.2.zip";s:3:"2.2";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.2.2.zip";s:5:"2.2.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.2.1.zip";s:3:"2.3";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.2.3.zip";s:5:"2.3.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.3.1.zip";s:3:"2.4";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.2.4.zip";s:5:"2.4.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.4.1.zip";s:5:"2.4.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.4.2.zip";s:5:"2.4.3";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.4.3.zip";s:5:"2.4.4";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.4.4.zip";s:5:"2.4.5";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.4.5.zip";s:5:"2.4.6";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.2.4.6.zip";s:3:"3.0";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.3.0.zip";s:8:"3.0-beta";s:66:"https://downloads.wordpress.org/plugin/contact-form-7.3.0-beta.zip";s:5:"3.0.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.0.1.zip";s:5:"3.0.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.0.2.zip";s:7:"3.0.2.1";s:65:"https://downloads.wordpress.org/plugin/contact-form-7.3.0.2.1.zip";s:3:"3.1";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.3.1.zip";s:5:"3.1.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.1.1.zip";s:5:"3.1.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.1.2.zip";s:3:"3.2";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.3.2.zip";s:5:"3.2.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.2.1.zip";s:3:"3.3";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.3.3.zip";s:5:"3.3.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.3.1.zip";s:5:"3.3.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.3.2.zip";s:5:"3.3.3";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.3.3.zip";s:3:"3.4";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.3.4.zip";s:5:"3.4.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.4.1.zip";s:5:"3.4.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.4.2.zip";s:3:"3.5";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.3.5.zip";s:5:"3.5.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.5.1.zip";s:5:"3.5.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.5.2.zip";s:5:"3.5.3";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.5.3.zip";s:5:"3.5.4";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.5.4.zip";s:3:"3.6";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.3.6.zip";s:3:"3.7";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.3.7.zip";s:5:"3.7.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.7.1.zip";s:5:"3.7.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.7.2.zip";s:3:"3.8";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.3.8.zip";s:5:"3.8.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.8.1.zip";s:3:"3.9";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.3.9.zip";s:8:"3.9-beta";s:66:"https://downloads.wordpress.org/plugin/contact-form-7.3.9-beta.zip";s:5:"3.9.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.9.1.zip";s:5:"3.9.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.9.2.zip";s:5:"3.9.3";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.3.9.3.zip";s:3:"4.0";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.4.0.zip";s:5:"4.0.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.4.0.1.zip";s:5:"4.0.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.4.0.2.zip";s:5:"4.0.3";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.4.0.3.zip";s:3:"4.1";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.4.1.zip";s:8:"4.1-beta";s:66:"https://downloads.wordpress.org/plugin/contact-form-7.4.1-beta.zip";s:5:"4.1.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.4.1.1.zip";s:5:"4.1.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.4.1.2.zip";s:3:"4.2";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.4.2.zip";s:8:"4.2-beta";s:66:"https://downloads.wordpress.org/plugin/contact-form-7.4.2-beta.zip";s:5:"4.2.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.4.2.1.zip";s:5:"4.2.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.4.2.2.zip";s:3:"4.3";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.4.3.zip";s:5:"4.3.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.4.3.1.zip";s:3:"4.4";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.4.4.zip";s:5:"4.4.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.4.4.1.zip";s:5:"4.4.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.4.4.2.zip";s:3:"4.5";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.4.5.zip";s:5:"4.5.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.4.5.1.zip";s:3:"4.6";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.4.6.zip";s:5:"4.6.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.4.6.1.zip";s:3:"4.7";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.4.7.zip";s:3:"4.8";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.4.8.zip";s:5:"4.8.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.4.8.1.zip";s:3:"4.9";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.4.9.zip";s:5:"4.9.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.4.9.1.zip";s:5:"4.9.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.4.9.2.zip";s:3:"5.0";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.5.0.zip";s:5:"5.0.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.0.1.zip";s:5:"5.0.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.0.2.zip";s:5:"5.0.3";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.0.3.zip";s:5:"5.0.4";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.0.4.zip";s:5:"5.0.5";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.0.5.zip";s:3:"5.1";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.5.1.zip";s:5:"5.1.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.1.1.zip";s:5:"5.1.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.1.2.zip";s:5:"5.1.3";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.1.3.zip";s:5:"5.1.4";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.1.4.zip";s:5:"5.1.5";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.1.5.zip";s:5:"5.1.6";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.1.6.zip";s:5:"5.1.7";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.1.7.zip";s:5:"5.1.8";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.1.8.zip";s:5:"5.1.9";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.1.9.zip";s:3:"5.2";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.5.2.zip";s:5:"5.2.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.2.1.zip";s:5:"5.2.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.2.2.zip";s:3:"5.3";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.5.3.zip";s:5:"5.3.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.3.1.zip";s:5:"5.3.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.3.2.zip";s:3:"5.4";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.5.4.zip";s:5:"5.4.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.4.1.zip";s:5:"5.4.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.4.2.zip";s:3:"5.5";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.5.5.zip";s:5:"5.5.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.5.1.zip";s:5:"5.5.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.5.2.zip";s:5:"5.5.3";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.5.3.zip";s:5:"5.5.4";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.5.4.zip";s:5:"5.5.5";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.5.5.zip";s:5:"5.5.6";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.5.6.zip";s:7:"5.5.6.1";s:65:"https://downloads.wordpress.org/plugin/contact-form-7.5.5.6.1.zip";s:3:"5.6";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.5.6.zip";s:5:"5.6.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.6.1.zip";s:5:"5.6.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.6.2.zip";s:5:"5.6.3";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.6.3.zip";s:5:"5.6.4";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.6.4.zip";s:3:"5.7";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.5.7.zip";s:5:"5.7.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.7.1.zip";s:5:"5.7.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.7.2.zip";s:5:"5.7.3";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.7.3.zip";s:5:"5.7.4";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.7.4.zip";s:5:"5.7.5";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.7.5.zip";s:7:"5.7.5.1";s:65:"https://downloads.wordpress.org/plugin/contact-form-7.5.7.5.1.zip";s:5:"5.7.6";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.7.6.zip";s:5:"5.7.7";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.7.7.zip";s:3:"5.8";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.5.8.zip";s:5:"5.8.1";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.8.1.zip";s:5:"5.8.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.8.2.zip";s:5:"5.8.3";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.8.3.zip";s:5:"5.8.4";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.8.4.zip";s:5:"5.8.5";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.8.5.zip";s:5:"5.8.6";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.8.6.zip";s:5:"5.8.7";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.8.7.zip";s:3:"5.9";s:61:"https://downloads.wordpress.org/plugin/contact-form-7.5.9.zip";s:5:"5.9.2";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.9.2.zip";s:5:"5.9.3";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.9.3.zip";s:5:"5.9.4";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.9.4.zip";s:5:"5.9.5";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.9.5.zip";s:5:"5.9.6";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.9.6.zip";s:5:"5.9.7";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.9.7.zip";s:5:"5.9.8";s:63:"https://downloads.wordpress.org/plugin/contact-form-7.5.9.8.zip";s:5:"trunk";s:57:"https://downloads.wordpress.org/plugin/contact-form-7.zip";}s:14:"business_model";b:0;s:14:"repository_url";s:0:"";s:22:"commercial_support_url";s:0:"";s:11:"donate_link";s:32:"https://contactform7.com/donate/";s:7:"banners";a:2:{s:3:"low";s:68:"https://ps.w.org/contact-form-7/assets/banner-772x250.png?rev=880427";s:4:"high";s:69:"https://ps.w.org/contact-form-7/assets/banner-1544x500.png?rev=860901";}s:5:"icons";a:2:{s:2:"1x";s:59:"https://ps.w.org/contact-form-7/assets/icon.svg?rev=2339255";s:3:"svg";s:59:"https://ps.w.org/contact-form-7/assets/icon.svg?rev=2339255";}s:12:"preview_link";s:0:"";s:4:"Name";s:14:"Contact Form 7";}}', 'off'),
	(2993, '_site_transient_wp_plugin_dependencies_plugin_timeout_contact-form-7', '1', 'off'),
	(2991, '_site_transient_wp_theme_files_patterns-a64be370c6a53d17a10b356f6e90c147', 'a:2:{s:7:"version";s:10:"2024-07-23";s:8:"patterns";a:0:{}}', 'off'),
	(2974, '_transient_acf_plugin_updates', 'a:5:{s:7:"plugins";a:0:{}s:9:"no_update";a:1:{s:34:"advanced-custom-fields-pro/acf.php";a:12:{s:4:"slug";s:26:"advanced-custom-fields-pro";s:6:"plugin";s:34:"advanced-custom-fields-pro/acf.php";s:11:"new_version";s:5:"6.3.9";s:3:"url";s:36:"https://www.advancedcustomfields.com";s:6:"tested";s:5:"6.6.2";s:7:"package";s:0:"";s:5:"icons";a:1:{s:7:"default";s:64:"https://connect.advancedcustomfields.com/assets/icon-256x256.png";}s:7:"banners";a:2:{s:3:"low";s:66:"https://connect.advancedcustomfields.com/assets/banner-772x250.jpg";s:4:"high";s:67:"https://connect.advancedcustomfields.com/assets/banner-1544x500.jpg";}s:8:"requires";s:3:"6.0";s:12:"requires_php";s:3:"7.4";s:12:"release_date";s:8:"20241015";s:6:"reason";s:10:"up_to_date";}}s:10:"expiration";i:172800;s:6:"status";i:1;s:7:"checked";a:1:{s:34:"advanced-custom-fields-pro/acf.php";s:5:"6.3.9";}}', 'no'),
	(2912, '_transient_acf_pro_license_reactivated', '1', 'yes'),
	(2971, '_transient_acf_pro_validating_license', '1', 'no'),
	(2048, '_transient_health-check-site-status-result', '{"good":"22","recommended":"4","critical":"1"}', 'yes'),
	(2638, '_transient_itc_svg_upload_settings_notice_dismiss_alert', '9', 'yes'),
	(3002, '_transient_perflab_plugins_info-v2', 'a:9:{s:15:"embed-optimizer";a:8:{s:4:"name";s:15:"Embed Optimizer";s:4:"slug";s:15:"embed-optimizer";s:17:"short_description";s:72:"Optimizes the performance of embeds by lazy-loading iframes and scripts.";s:8:"requires";s:3:"6.5";s:12:"requires_php";s:3:"7.2";s:16:"requires_plugins";a:0:{}s:13:"download_link";s:64:"https://downloads.wordpress.org/plugin/embed-optimizer.0.3.0.zip";s:7:"version";s:5:"0.3.0";}s:10:"auto-sizes";a:8:{s:4:"name";s:26:"Enhanced Responsive Images";s:4:"slug";s:10:"auto-sizes";s:17:"short_description";s:48:"Improvements for responsive images in WordPress.";s:8:"requires";s:3:"6.5";s:12:"requires_php";s:3:"7.2";s:16:"requires_plugins";a:0:{}s:13:"download_link";s:59:"https://downloads.wordpress.org/plugin/auto-sizes.1.3.0.zip";s:7:"version";s:5:"1.3.0";}s:21:"dominant-color-images";a:8:{s:4:"name";s:18:"Image Placeholders";s:4:"slug";s:21:"dominant-color-images";s:17:"short_description";s:89:"Displays placeholders based on an image&#039;s dominant color while the image is loading.";s:8:"requires";s:3:"6.5";s:12:"requires_php";s:3:"7.2";s:16:"requires_plugins";a:0:{}s:13:"download_link";s:70:"https://downloads.wordpress.org/plugin/dominant-color-images.1.1.2.zip";s:7:"version";s:5:"1.1.2";}s:17:"image-prioritizer";a:8:{s:4:"name";s:17:"Image Prioritizer";s:4:"slug";s:17:"image-prioritizer";s:17:"short_description";s:142:"Optimizes LCP image loading with fetchpriority=high and applies image lazy-loading by leveraging client-side detection with real user metrics.";s:8:"requires";s:3:"6.5";s:12:"requires_php";s:3:"7.2";s:16:"requires_plugins";a:1:{i:0;s:22:"optimization-detective";}s:13:"download_link";s:66:"https://downloads.wordpress.org/plugin/image-prioritizer.0.2.0.zip";s:7:"version";s:5:"0.2.0";}s:12:"webp-uploads";a:8:{s:4:"name";s:20:"Modern Image Formats";s:4:"slug";s:12:"webp-uploads";s:17:"short_description";s:74:"Converts images to more modern formats such as WebP or AVIF during upload.";s:8:"requires";s:3:"6.5";s:12:"requires_php";s:3:"7.2";s:16:"requires_plugins";a:0:{}s:13:"download_link";s:61:"https://downloads.wordpress.org/plugin/webp-uploads.2.2.0.zip";s:7:"version";s:5:"2.2.0";}s:22:"optimization-detective";a:8:{s:4:"name";s:22:"Optimization Detective";s:4:"slug";s:22:"optimization-detective";s:17:"short_description";s:126:"Provides an API for leveraging real user metrics to detect optimizations to apply on the frontend to improve page performance.";s:8:"requires";s:3:"6.5";s:12:"requires_php";s:3:"7.2";s:16:"requires_plugins";a:0:{}s:13:"download_link";s:71:"https://downloads.wordpress.org/plugin/optimization-detective.0.7.0.zip";s:7:"version";s:5:"0.7.0";}s:23:"performant-translations";a:8:{s:4:"name";s:23:"Performant Translations";s:4:"slug";s:23:"performant-translations";s:17:"short_description";s:78:"Making internationalization/localization in WordPress faster than ever before.";s:8:"requires";s:3:"6.5";s:12:"requires_php";s:3:"7.0";s:16:"requires_plugins";a:0:{}s:13:"download_link";s:72:"https://downloads.wordpress.org/plugin/performant-translations.1.2.0.zip";s:7:"version";s:5:"1.2.0";}s:17:"speculation-rules";a:8:{s:4:"name";s:19:"Speculative Loading";s:4:"slug";s:17:"speculation-rules";s:17:"short_description";s:87:"Enables browsers to speculatively prerender or prefetch pages when hovering over links.";s:8:"requires";s:3:"6.4";s:12:"requires_php";s:3:"7.2";s:16:"requires_plugins";a:0:{}s:13:"download_link";s:66:"https://downloads.wordpress.org/plugin/speculation-rules.1.3.1.zip";s:7:"version";s:5:"1.3.1";}s:21:"web-worker-offloading";a:8:{s:4:"name";s:21:"Web Worker Offloading";s:4:"slug";s:21:"web-worker-offloading";s:17:"short_description";s:142:"Offloads select JavaScript execution to a Web Worker to reduce work on the main thread and improve the Interaction to Next Paint (INP) metric.";s:8:"requires";s:3:"6.5";s:12:"requires_php";s:3:"7.2";s:16:"requires_plugins";a:0:{}s:13:"download_link";s:70:"https://downloads.wordpress.org/plugin/web-worker-offloading.0.1.1.zip";s:7:"version";s:5:"0.1.1";}}', 'off'),
	(2412, '_transient_perflab_set_object_cache_dropin', '1', 'no'),
	(2973, '_transient_timeout_acf_plugin_updates', '1729891386', 'no'),
	(2970, '_transient_timeout_acf_pro_validating_license', '1729718779', 'no'),
	(3001, '_transient_timeout_perflab_plugins_info-v2', '1729722332', 'off'),
	(2386, '_transient_users_online', 'a:1:{i:0;a:4:{s:7:"user_id";i:2;s:13:"last_activity";i:1681894525;s:10:"ip_address";s:14:"178.74.236.195";s:7:"blog_id";b:0;}}', 'no'),
	(2448, '_transient_wfRegistrationToken', 'LefZsV7NyV5vSeI4kPpX4MK9RaIKyfMe9PX7AjxGIqc', 'no'),
	(2956, '_transient_wp_core_block_css_files', 'a:2:{s:7:"version";s:5:"6.5.5";s:5:"files";a:500:{i:0;s:23:"archives/editor-rtl.css";i:1;s:27:"archives/editor-rtl.min.css";i:2;s:19:"archives/editor.css";i:3;s:23:"archives/editor.min.css";i:4;s:22:"archives/style-rtl.css";i:5;s:26:"archives/style-rtl.min.css";i:6;s:18:"archives/style.css";i:7;s:22:"archives/style.min.css";i:8;s:20:"audio/editor-rtl.css";i:9;s:24:"audio/editor-rtl.min.css";i:10;s:16:"audio/editor.css";i:11;s:20:"audio/editor.min.css";i:12;s:19:"audio/style-rtl.css";i:13;s:23:"audio/style-rtl.min.css";i:14;s:15:"audio/style.css";i:15;s:19:"audio/style.min.css";i:16;s:19:"audio/theme-rtl.css";i:17;s:23:"audio/theme-rtl.min.css";i:18;s:15:"audio/theme.css";i:19;s:19:"audio/theme.min.css";i:20;s:21:"avatar/editor-rtl.css";i:21;s:25:"avatar/editor-rtl.min.css";i:22;s:17:"avatar/editor.css";i:23;s:21:"avatar/editor.min.css";i:24;s:20:"avatar/style-rtl.css";i:25;s:24:"avatar/style-rtl.min.css";i:26;s:16:"avatar/style.css";i:27;s:20:"avatar/style.min.css";i:28;s:20:"block/editor-rtl.css";i:29;s:24:"block/editor-rtl.min.css";i:30;s:16:"block/editor.css";i:31;s:20:"block/editor.min.css";i:32;s:21:"button/editor-rtl.css";i:33;s:25:"button/editor-rtl.min.css";i:34;s:17:"button/editor.css";i:35;s:21:"button/editor.min.css";i:36;s:20:"button/style-rtl.css";i:37;s:24:"button/style-rtl.min.css";i:38;s:16:"button/style.css";i:39;s:20:"button/style.min.css";i:40;s:22:"buttons/editor-rtl.css";i:41;s:26:"buttons/editor-rtl.min.css";i:42;s:18:"buttons/editor.css";i:43;s:22:"buttons/editor.min.css";i:44;s:21:"buttons/style-rtl.css";i:45;s:25:"buttons/style-rtl.min.css";i:46;s:17:"buttons/style.css";i:47;s:21:"buttons/style.min.css";i:48;s:22:"calendar/style-rtl.css";i:49;s:26:"calendar/style-rtl.min.css";i:50;s:18:"calendar/style.css";i:51;s:22:"calendar/style.min.css";i:52;s:25:"categories/editor-rtl.css";i:53;s:29:"categories/editor-rtl.min.css";i:54;s:21:"categories/editor.css";i:55;s:25:"categories/editor.min.css";i:56;s:24:"categories/style-rtl.css";i:57;s:28:"categories/style-rtl.min.css";i:58;s:20:"categories/style.css";i:59;s:24:"categories/style.min.css";i:60;s:19:"code/editor-rtl.css";i:61;s:23:"code/editor-rtl.min.css";i:62;s:15:"code/editor.css";i:63;s:19:"code/editor.min.css";i:64;s:18:"code/style-rtl.css";i:65;s:22:"code/style-rtl.min.css";i:66;s:14:"code/style.css";i:67;s:18:"code/style.min.css";i:68;s:18:"code/theme-rtl.css";i:69;s:22:"code/theme-rtl.min.css";i:70;s:14:"code/theme.css";i:71;s:18:"code/theme.min.css";i:72;s:22:"columns/editor-rtl.css";i:73;s:26:"columns/editor-rtl.min.css";i:74;s:18:"columns/editor.css";i:75;s:22:"columns/editor.min.css";i:76;s:21:"columns/style-rtl.css";i:77;s:25:"columns/style-rtl.min.css";i:78;s:17:"columns/style.css";i:79;s:21:"columns/style.min.css";i:80;s:29:"comment-content/style-rtl.css";i:81;s:33:"comment-content/style-rtl.min.css";i:82;s:25:"comment-content/style.css";i:83;s:29:"comment-content/style.min.css";i:84;s:30:"comment-template/style-rtl.css";i:85;s:34:"comment-template/style-rtl.min.css";i:86;s:26:"comment-template/style.css";i:87;s:30:"comment-template/style.min.css";i:88;s:42:"comments-pagination-numbers/editor-rtl.css";i:89;s:46:"comments-pagination-numbers/editor-rtl.min.css";i:90;s:38:"comments-pagination-numbers/editor.css";i:91;s:42:"comments-pagination-numbers/editor.min.css";i:92;s:34:"comments-pagination/editor-rtl.css";i:93;s:38:"comments-pagination/editor-rtl.min.css";i:94;s:30:"comments-pagination/editor.css";i:95;s:34:"comments-pagination/editor.min.css";i:96;s:33:"comments-pagination/style-rtl.css";i:97;s:37:"comments-pagination/style-rtl.min.css";i:98;s:29:"comments-pagination/style.css";i:99;s:33:"comments-pagination/style.min.css";i:100;s:29:"comments-title/editor-rtl.css";i:101;s:33:"comments-title/editor-rtl.min.css";i:102;s:25:"comments-title/editor.css";i:103;s:29:"comments-title/editor.min.css";i:104;s:23:"comments/editor-rtl.css";i:105;s:27:"comments/editor-rtl.min.css";i:106;s:19:"comments/editor.css";i:107;s:23:"comments/editor.min.css";i:108;s:22:"comments/style-rtl.css";i:109;s:26:"comments/style-rtl.min.css";i:110;s:18:"comments/style.css";i:111;s:22:"comments/style.min.css";i:112;s:20:"cover/editor-rtl.css";i:113;s:24:"cover/editor-rtl.min.css";i:114;s:16:"cover/editor.css";i:115;s:20:"cover/editor.min.css";i:116;s:19:"cover/style-rtl.css";i:117;s:23:"cover/style-rtl.min.css";i:118;s:15:"cover/style.css";i:119;s:19:"cover/style.min.css";i:120;s:22:"details/editor-rtl.css";i:121;s:26:"details/editor-rtl.min.css";i:122;s:18:"details/editor.css";i:123;s:22:"details/editor.min.css";i:124;s:21:"details/style-rtl.css";i:125;s:25:"details/style-rtl.min.css";i:126;s:17:"details/style.css";i:127;s:21:"details/style.min.css";i:128;s:20:"embed/editor-rtl.css";i:129;s:24:"embed/editor-rtl.min.css";i:130;s:16:"embed/editor.css";i:131;s:20:"embed/editor.min.css";i:132;s:19:"embed/style-rtl.css";i:133;s:23:"embed/style-rtl.min.css";i:134;s:15:"embed/style.css";i:135;s:19:"embed/style.min.css";i:136;s:19:"embed/theme-rtl.css";i:137;s:23:"embed/theme-rtl.min.css";i:138;s:15:"embed/theme.css";i:139;s:19:"embed/theme.min.css";i:140;s:19:"file/editor-rtl.css";i:141;s:23:"file/editor-rtl.min.css";i:142;s:15:"file/editor.css";i:143;s:19:"file/editor.min.css";i:144;s:18:"file/style-rtl.css";i:145;s:22:"file/style-rtl.min.css";i:146;s:14:"file/style.css";i:147;s:18:"file/style.min.css";i:148;s:23:"footnotes/style-rtl.css";i:149;s:27:"footnotes/style-rtl.min.css";i:150;s:19:"footnotes/style.css";i:151;s:23:"footnotes/style.min.css";i:152;s:23:"freeform/editor-rtl.css";i:153;s:27:"freeform/editor-rtl.min.css";i:154;s:19:"freeform/editor.css";i:155;s:23:"freeform/editor.min.css";i:156;s:22:"gallery/editor-rtl.css";i:157;s:26:"gallery/editor-rtl.min.css";i:158;s:18:"gallery/editor.css";i:159;s:22:"gallery/editor.min.css";i:160;s:21:"gallery/style-rtl.css";i:161;s:25:"gallery/style-rtl.min.css";i:162;s:17:"gallery/style.css";i:163;s:21:"gallery/style.min.css";i:164;s:21:"gallery/theme-rtl.css";i:165;s:25:"gallery/theme-rtl.min.css";i:166;s:17:"gallery/theme.css";i:167;s:21:"gallery/theme.min.css";i:168;s:20:"group/editor-rtl.css";i:169;s:24:"group/editor-rtl.min.css";i:170;s:16:"group/editor.css";i:171;s:20:"group/editor.min.css";i:172;s:19:"group/style-rtl.css";i:173;s:23:"group/style-rtl.min.css";i:174;s:15:"group/style.css";i:175;s:19:"group/style.min.css";i:176;s:19:"group/theme-rtl.css";i:177;s:23:"group/theme-rtl.min.css";i:178;s:15:"group/theme.css";i:179;s:19:"group/theme.min.css";i:180;s:21:"heading/style-rtl.css";i:181;s:25:"heading/style-rtl.min.css";i:182;s:17:"heading/style.css";i:183;s:21:"heading/style.min.css";i:184;s:19:"html/editor-rtl.css";i:185;s:23:"html/editor-rtl.min.css";i:186;s:15:"html/editor.css";i:187;s:19:"html/editor.min.css";i:188;s:20:"image/editor-rtl.css";i:189;s:24:"image/editor-rtl.min.css";i:190;s:16:"image/editor.css";i:191;s:20:"image/editor.min.css";i:192;s:19:"image/style-rtl.css";i:193;s:23:"image/style-rtl.min.css";i:194;s:15:"image/style.css";i:195;s:19:"image/style.min.css";i:196;s:19:"image/theme-rtl.css";i:197;s:23:"image/theme-rtl.min.css";i:198;s:15:"image/theme.css";i:199;s:19:"image/theme.min.css";i:200;s:29:"latest-comments/style-rtl.css";i:201;s:33:"latest-comments/style-rtl.min.css";i:202;s:25:"latest-comments/style.css";i:203;s:29:"latest-comments/style.min.css";i:204;s:27:"latest-posts/editor-rtl.css";i:205;s:31:"latest-posts/editor-rtl.min.css";i:206;s:23:"latest-posts/editor.css";i:207;s:27:"latest-posts/editor.min.css";i:208;s:26:"latest-posts/style-rtl.css";i:209;s:30:"latest-posts/style-rtl.min.css";i:210;s:22:"latest-posts/style.css";i:211;s:26:"latest-posts/style.min.css";i:212;s:18:"list/style-rtl.css";i:213;s:22:"list/style-rtl.min.css";i:214;s:14:"list/style.css";i:215;s:18:"list/style.min.css";i:216;s:25:"media-text/editor-rtl.css";i:217;s:29:"media-text/editor-rtl.min.css";i:218;s:21:"media-text/editor.css";i:219;s:25:"media-text/editor.min.css";i:220;s:24:"media-text/style-rtl.css";i:221;s:28:"media-text/style-rtl.min.css";i:222;s:20:"media-text/style.css";i:223;s:24:"media-text/style.min.css";i:224;s:19:"more/editor-rtl.css";i:225;s:23:"more/editor-rtl.min.css";i:226;s:15:"more/editor.css";i:227;s:19:"more/editor.min.css";i:228;s:30:"navigation-link/editor-rtl.css";i:229;s:34:"navigation-link/editor-rtl.min.css";i:230;s:26:"navigation-link/editor.css";i:231;s:30:"navigation-link/editor.min.css";i:232;s:29:"navigation-link/style-rtl.css";i:233;s:33:"navigation-link/style-rtl.min.css";i:234;s:25:"navigation-link/style.css";i:235;s:29:"navigation-link/style.min.css";i:236;s:33:"navigation-submenu/editor-rtl.css";i:237;s:37:"navigation-submenu/editor-rtl.min.css";i:238;s:29:"navigation-submenu/editor.css";i:239;s:33:"navigation-submenu/editor.min.css";i:240;s:25:"navigation/editor-rtl.css";i:241;s:29:"navigation/editor-rtl.min.css";i:242;s:21:"navigation/editor.css";i:243;s:25:"navigation/editor.min.css";i:244;s:24:"navigation/style-rtl.css";i:245;s:28:"navigation/style-rtl.min.css";i:246;s:20:"navigation/style.css";i:247;s:24:"navigation/style.min.css";i:248;s:23:"nextpage/editor-rtl.css";i:249;s:27:"nextpage/editor-rtl.min.css";i:250;s:19:"nextpage/editor.css";i:251;s:23:"nextpage/editor.min.css";i:252;s:24:"page-list/editor-rtl.css";i:253;s:28:"page-list/editor-rtl.min.css";i:254;s:20:"page-list/editor.css";i:255;s:24:"page-list/editor.min.css";i:256;s:23:"page-list/style-rtl.css";i:257;s:27:"page-list/style-rtl.min.css";i:258;s:19:"page-list/style.css";i:259;s:23:"page-list/style.min.css";i:260;s:24:"paragraph/editor-rtl.css";i:261;s:28:"paragraph/editor-rtl.min.css";i:262;s:20:"paragraph/editor.css";i:263;s:24:"paragraph/editor.min.css";i:264;s:23:"paragraph/style-rtl.css";i:265;s:27:"paragraph/style-rtl.min.css";i:266;s:19:"paragraph/style.css";i:267;s:23:"paragraph/style.min.css";i:268;s:25:"post-author/style-rtl.css";i:269;s:29:"post-author/style-rtl.min.css";i:270;s:21:"post-author/style.css";i:271;s:25:"post-author/style.min.css";i:272;s:33:"post-comments-form/editor-rtl.css";i:273;s:37:"post-comments-form/editor-rtl.min.css";i:274;s:29:"post-comments-form/editor.css";i:275;s:33:"post-comments-form/editor.min.css";i:276;s:32:"post-comments-form/style-rtl.css";i:277;s:36:"post-comments-form/style-rtl.min.css";i:278;s:28:"post-comments-form/style.css";i:279;s:32:"post-comments-form/style.min.css";i:280;s:27:"post-content/editor-rtl.css";i:281;s:31:"post-content/editor-rtl.min.css";i:282;s:23:"post-content/editor.css";i:283;s:27:"post-content/editor.min.css";i:284;s:23:"post-date/style-rtl.css";i:285;s:27:"post-date/style-rtl.min.css";i:286;s:19:"post-date/style.css";i:287;s:23:"post-date/style.min.css";i:288;s:27:"post-excerpt/editor-rtl.css";i:289;s:31:"post-excerpt/editor-rtl.min.css";i:290;s:23:"post-excerpt/editor.css";i:291;s:27:"post-excerpt/editor.min.css";i:292;s:26:"post-excerpt/style-rtl.css";i:293;s:30:"post-excerpt/style-rtl.min.css";i:294;s:22:"post-excerpt/style.css";i:295;s:26:"post-excerpt/style.min.css";i:296;s:34:"post-featured-image/editor-rtl.css";i:297;s:38:"post-featured-image/editor-rtl.min.css";i:298;s:30:"post-featured-image/editor.css";i:299;s:34:"post-featured-image/editor.min.css";i:300;s:33:"post-featured-image/style-rtl.css";i:301;s:37:"post-featured-image/style-rtl.min.css";i:302;s:29:"post-featured-image/style.css";i:303;s:33:"post-featured-image/style.min.css";i:304;s:34:"post-navigation-link/style-rtl.css";i:305;s:38:"post-navigation-link/style-rtl.min.css";i:306;s:30:"post-navigation-link/style.css";i:307;s:34:"post-navigation-link/style.min.css";i:308;s:28:"post-template/editor-rtl.css";i:309;s:32:"post-template/editor-rtl.min.css";i:310;s:24:"post-template/editor.css";i:311;s:28:"post-template/editor.min.css";i:312;s:27:"post-template/style-rtl.css";i:313;s:31:"post-template/style-rtl.min.css";i:314;s:23:"post-template/style.css";i:315;s:27:"post-template/style.min.css";i:316;s:24:"post-terms/style-rtl.css";i:317;s:28:"post-terms/style-rtl.min.css";i:318;s:20:"post-terms/style.css";i:319;s:24:"post-terms/style.min.css";i:320;s:24:"post-title/style-rtl.css";i:321;s:28:"post-title/style-rtl.min.css";i:322;s:20:"post-title/style.css";i:323;s:24:"post-title/style.min.css";i:324;s:26:"preformatted/style-rtl.css";i:325;s:30:"preformatted/style-rtl.min.css";i:326;s:22:"preformatted/style.css";i:327;s:26:"preformatted/style.min.css";i:328;s:24:"pullquote/editor-rtl.css";i:329;s:28:"pullquote/editor-rtl.min.css";i:330;s:20:"pullquote/editor.css";i:331;s:24:"pullquote/editor.min.css";i:332;s:23:"pullquote/style-rtl.css";i:333;s:27:"pullquote/style-rtl.min.css";i:334;s:19:"pullquote/style.css";i:335;s:23:"pullquote/style.min.css";i:336;s:23:"pullquote/theme-rtl.css";i:337;s:27:"pullquote/theme-rtl.min.css";i:338;s:19:"pullquote/theme.css";i:339;s:23:"pullquote/theme.min.css";i:340;s:39:"query-pagination-numbers/editor-rtl.css";i:341;s:43:"query-pagination-numbers/editor-rtl.min.css";i:342;s:35:"query-pagination-numbers/editor.css";i:343;s:39:"query-pagination-numbers/editor.min.css";i:344;s:31:"query-pagination/editor-rtl.css";i:345;s:35:"query-pagination/editor-rtl.min.css";i:346;s:27:"query-pagination/editor.css";i:347;s:31:"query-pagination/editor.min.css";i:348;s:30:"query-pagination/style-rtl.css";i:349;s:34:"query-pagination/style-rtl.min.css";i:350;s:26:"query-pagination/style.css";i:351;s:30:"query-pagination/style.min.css";i:352;s:25:"query-title/style-rtl.css";i:353;s:29:"query-title/style-rtl.min.css";i:354;s:21:"query-title/style.css";i:355;s:25:"query-title/style.min.css";i:356;s:20:"query/editor-rtl.css";i:357;s:24:"query/editor-rtl.min.css";i:358;s:16:"query/editor.css";i:359;s:20:"query/editor.min.css";i:360;s:19:"quote/style-rtl.css";i:361;s:23:"quote/style-rtl.min.css";i:362;s:15:"quote/style.css";i:363;s:19:"quote/style.min.css";i:364;s:19:"quote/theme-rtl.css";i:365;s:23:"quote/theme-rtl.min.css";i:366;s:15:"quote/theme.css";i:367;s:19:"quote/theme.min.css";i:368;s:23:"read-more/style-rtl.css";i:369;s:27:"read-more/style-rtl.min.css";i:370;s:19:"read-more/style.css";i:371;s:23:"read-more/style.min.css";i:372;s:18:"rss/editor-rtl.css";i:373;s:22:"rss/editor-rtl.min.css";i:374;s:14:"rss/editor.css";i:375;s:18:"rss/editor.min.css";i:376;s:17:"rss/style-rtl.css";i:377;s:21:"rss/style-rtl.min.css";i:378;s:13:"rss/style.css";i:379;s:17:"rss/style.min.css";i:380;s:21:"search/editor-rtl.css";i:381;s:25:"search/editor-rtl.min.css";i:382;s:17:"search/editor.css";i:383;s:21:"search/editor.min.css";i:384;s:20:"search/style-rtl.css";i:385;s:24:"search/style-rtl.min.css";i:386;s:16:"search/style.css";i:387;s:20:"search/style.min.css";i:388;s:20:"search/theme-rtl.css";i:389;s:24:"search/theme-rtl.min.css";i:390;s:16:"search/theme.css";i:391;s:20:"search/theme.min.css";i:392;s:24:"separator/editor-rtl.css";i:393;s:28:"separator/editor-rtl.min.css";i:394;s:20:"separator/editor.css";i:395;s:24:"separator/editor.min.css";i:396;s:23:"separator/style-rtl.css";i:397;s:27:"separator/style-rtl.min.css";i:398;s:19:"separator/style.css";i:399;s:23:"separator/style.min.css";i:400;s:23:"separator/theme-rtl.css";i:401;s:27:"separator/theme-rtl.min.css";i:402;s:19:"separator/theme.css";i:403;s:23:"separator/theme.min.css";i:404;s:24:"shortcode/editor-rtl.css";i:405;s:28:"shortcode/editor-rtl.min.css";i:406;s:20:"shortcode/editor.css";i:407;s:24:"shortcode/editor.min.css";i:408;s:24:"site-logo/editor-rtl.css";i:409;s:28:"site-logo/editor-rtl.min.css";i:410;s:20:"site-logo/editor.css";i:411;s:24:"site-logo/editor.min.css";i:412;s:23:"site-logo/style-rtl.css";i:413;s:27:"site-logo/style-rtl.min.css";i:414;s:19:"site-logo/style.css";i:415;s:23:"site-logo/style.min.css";i:416;s:27:"site-tagline/editor-rtl.css";i:417;s:31:"site-tagline/editor-rtl.min.css";i:418;s:23:"site-tagline/editor.css";i:419;s:27:"site-tagline/editor.min.css";i:420;s:25:"site-title/editor-rtl.css";i:421;s:29:"site-title/editor-rtl.min.css";i:422;s:21:"site-title/editor.css";i:423;s:25:"site-title/editor.min.css";i:424;s:24:"site-title/style-rtl.css";i:425;s:28:"site-title/style-rtl.min.css";i:426;s:20:"site-title/style.css";i:427;s:24:"site-title/style.min.css";i:428;s:26:"social-link/editor-rtl.css";i:429;s:30:"social-link/editor-rtl.min.css";i:430;s:22:"social-link/editor.css";i:431;s:26:"social-link/editor.min.css";i:432;s:27:"social-links/editor-rtl.css";i:433;s:31:"social-links/editor-rtl.min.css";i:434;s:23:"social-links/editor.css";i:435;s:27:"social-links/editor.min.css";i:436;s:26:"social-links/style-rtl.css";i:437;s:30:"social-links/style-rtl.min.css";i:438;s:22:"social-links/style.css";i:439;s:26:"social-links/style.min.css";i:440;s:21:"spacer/editor-rtl.css";i:441;s:25:"spacer/editor-rtl.min.css";i:442;s:17:"spacer/editor.css";i:443;s:21:"spacer/editor.min.css";i:444;s:20:"spacer/style-rtl.css";i:445;s:24:"spacer/style-rtl.min.css";i:446;s:16:"spacer/style.css";i:447;s:20:"spacer/style.min.css";i:448;s:20:"table/editor-rtl.css";i:449;s:24:"table/editor-rtl.min.css";i:450;s:16:"table/editor.css";i:451;s:20:"table/editor.min.css";i:452;s:19:"table/style-rtl.css";i:453;s:23:"table/style-rtl.min.css";i:454;s:15:"table/style.css";i:455;s:19:"table/style.min.css";i:456;s:19:"table/theme-rtl.css";i:457;s:23:"table/theme-rtl.min.css";i:458;s:15:"table/theme.css";i:459;s:19:"table/theme.min.css";i:460;s:23:"tag-cloud/style-rtl.css";i:461;s:27:"tag-cloud/style-rtl.min.css";i:462;s:19:"tag-cloud/style.css";i:463;s:23:"tag-cloud/style.min.css";i:464;s:28:"template-part/editor-rtl.css";i:465;s:32:"template-part/editor-rtl.min.css";i:466;s:24:"template-part/editor.css";i:467;s:28:"template-part/editor.min.css";i:468;s:27:"template-part/theme-rtl.css";i:469;s:31:"template-part/theme-rtl.min.css";i:470;s:23:"template-part/theme.css";i:471;s:27:"template-part/theme.min.css";i:472;s:30:"term-description/style-rtl.css";i:473;s:34:"term-description/style-rtl.min.css";i:474;s:26:"term-description/style.css";i:475;s:30:"term-description/style.min.css";i:476;s:27:"text-columns/editor-rtl.css";i:477;s:31:"text-columns/editor-rtl.min.css";i:478;s:23:"text-columns/editor.css";i:479;s:27:"text-columns/editor.min.css";i:480;s:26:"text-columns/style-rtl.css";i:481;s:30:"text-columns/style-rtl.min.css";i:482;s:22:"text-columns/style.css";i:483;s:26:"text-columns/style.min.css";i:484;s:19:"verse/style-rtl.css";i:485;s:23:"verse/style-rtl.min.css";i:486;s:15:"verse/style.css";i:487;s:19:"verse/style.min.css";i:488;s:20:"video/editor-rtl.css";i:489;s:24:"video/editor-rtl.min.css";i:490;s:16:"video/editor.css";i:491;s:20:"video/editor.min.css";i:492;s:19:"video/style-rtl.css";i:493;s:23:"video/style-rtl.min.css";i:494;s:15:"video/style.css";i:495;s:19:"video/style.min.css";i:496;s:19:"video/theme-rtl.css";i:497;s:23:"video/theme-rtl.min.css";i:498;s:15:"video/theme.css";i:499;s:19:"video/theme.min.css";}}', 'yes'),
	(1304, 'acf_pro_license', 'YToyOntzOjM6ImtleSI7czo3MjoiYjNKa1pYSmZhV1E5TnpZMU9UaDhkSGx3WlQxa1pYWmxiRzl3WlhKOFpHRjBaVDB5TURFMkxUQXpMVEExSURFek9qUXdPalF4IjtzOjM6InVybCI7czoyMjoiaHR0cHM6Ly93cGViLmRkZXYuc2l0ZSI7fQ==', 'no'),
	(2913, 'acf_pro_license_status', 'a:11:{s:6:"status";s:6:"active";s:7:"created";i:0;s:6:"expiry";i:0;s:4:"name";s:9:"Developer";s:8:"lifetime";b:1;s:8:"refunded";b:0;s:17:"view_licenses_url";s:62:"https://www.advancedcustomfields.com/my-account/view-licenses/";s:23:"manage_subscription_url";s:0:"";s:9:"error_msg";s:0:"";s:10:"next_check";i:1729728682;s:16:"legacy_multisite";b:1;}', 'yes'),
	(2911, 'acf_site_health', '{"version":"6.3.9","plugin_type":"PRO","update_source":"ACF Direct","activated":true,"activated_url":"https:\\/\\/wpeb.ddev.site","license_type":"Developer","license_status":"active","subscription_expires":"","wp_version":"6.6.2","mysql_version":"10.11.9-MariaDB-ubu2204-log","is_multisite":false,"active_theme":{"name":"WP Easy Bruce","version":"2024-07-23","theme_uri":"https:\\/\\/github.com\\/crazyyy\\/wp-framework","stylesheet":false},"active_plugins":{"advanced-custom-fields-pro\\/acf.php":{"name":"Advanced Custom Fields PRO","version":"6.3.9","plugin_uri":"https:\\/\\/www.advancedcustomfields.com"},"classic-editor\\/classic-editor.php":{"name":"Classic Editor","version":"1.6.5","plugin_uri":"https:\\/\\/wordpress.org\\/plugins\\/classic-editor\\/"},"classic-widgets\\/classic-widgets.php":{"name":"Classic Widgets","version":"0.3","plugin_uri":"https:\\/\\/wordpress.org\\/plugins\\/classic-widgets\\/"},"contact-form-7\\/wp-contact-form-7.php":{"name":"Contact Form 7","version":"5.9.8","plugin_uri":"https:\\/\\/contactform7.com\\/"},"contact-form-cfdb7\\/contact-form-cfdb-7.php":{"name":"Contact Form CFDB7","version":"1.2.7","plugin_uri":"https:\\/\\/ciphercoin.com\\/"},"https-redirection\\/https-redirection.php":{"name":"Easy HTTPS (SSL) Redirection","version":"1.9.2","plugin_uri":"https:\\/\\/www.tipsandtricks-hq.com\\/wordpress-easy-https-redirection-plugin"},"enable-svg-webp-ico-upload\\/itc-svg-upload.php":{"name":"Enable SVG, WebP, and ICO Upload","version":"1.0.6","plugin_uri":"https:\\/\\/ideastocode.com\\/plugins\\/enable-svg-WebP-ico-upload\\/"},"auto-sizes\\/auto-sizes.php":{"name":"Enhanced Responsive Images","version":"1.3.0","plugin_uri":"https:\\/\\/github.com\\/WordPress\\/performance\\/tree\\/trunk\\/plugins\\/auto-sizes"},"health-check\\/health-check.php":{"name":"Health Check & Troubleshooting","version":"1.7.1","plugin_uri":"https:\\/\\/wordpress.org\\/plugins\\/health-check\\/"},"contact-form-7-honeypot\\/honeypot.php":{"name":"Honeypot for Contact Form 7","version":"2.1.5","plugin_uri":"https:\\/\\/wpexperts.io\\/"},"dominant-color-images\\/load.php":{"name":"Image Placeholders","version":"1.1.2","plugin_uri":"https:\\/\\/github.com\\/WordPress\\/performance\\/tree\\/trunk\\/plugins\\/dominant-color-images"},"index-wp-mysql-for-speed\\/index-wp-mysql-for-speed.php":{"name":"Index WP MySQL For Speed","version":"1.5.2","plugin_uri":"https:\\/\\/plumislandmedia.org\\/index-wp-mysql-for-speed\\/"},"webp-uploads\\/load.php":{"name":"Modern Image Formats","version":"2.2.0","plugin_uri":"https:\\/\\/github.com\\/WordPress\\/performance\\/tree\\/trunk\\/plugins\\/webp-uploads"},"performance-lab\\/load.php":{"name":"Performance Lab","version":"3.5.1","plugin_uri":"https:\\/\\/github.com\\/WordPress\\/performance"},"performant-translations\\/performant-translations.php":{"name":"Performant Translations","version":"1.2.0","plugin_uri":"https:\\/\\/github.com\\/swissspidy\\/performant-translations"},"query-monitor\\/query-monitor.php":{"name":"Query Monitor","version":"3.16.4","plugin_uri":"https:\\/\\/querymonitor.com\\/"},"site-health-manager\\/site-health-manager.php":{"name":"Site Health Manager","version":"1.1.2","plugin_uri":"https:\\/\\/wordpress.org\\/plugins\\/site-health-manager\\/"},"svg-support\\/svg-support.php":{"name":"SVG Support","version":"2.5.8","plugin_uri":"http:\\/\\/wordpress.org\\/plugins\\/svg-support\\/"},"ukr-to-lat\\/ukr-to-lat.php":{"name":"Ukr-To-Lat","version":"1.3.5","plugin_uri":"https:\\/\\/wordpress.org\\/plugins\\/ukr-to-lat\\/"}},"ui_field_groups":"0","php_field_groups":"0","json_field_groups":"0","rest_field_groups":"0","number_of_fields_by_type":[],"number_of_third_party_fields_by_type":[],"post_types_enabled":true,"ui_post_types":"4","json_post_types":"0","ui_taxonomies":"3","json_taxonomies":"0","ui_options_pages_enabled":true,"ui_options_pages":"0","json_options_pages":"0","php_options_pages":"0","rest_api_format":"standard","registered_acf_blocks":"1","blocks_per_api_version":{"v2":1},"blocks_per_acf_block_version":{"v1":1},"blocks_using_post_meta":"0","preload_blocks":true,"admin_ui_enabled":true,"field_type-modal_enabled":true,"field_settings_tabs_enabled":false,"shortcode_enabled":true,"registered_acf_forms":"0","json_save_paths":1,"json_load_paths":1,"last_updated":1729718719}', 'off'),
	(1287, 'acf_version', '6.3.9', 'yes'),
	(36, 'active_plugins', 'a:19:{i:0;s:31:"query-monitor/query-monitor.php";i:1;s:34:"advanced-custom-fields-pro/acf.php";i:2;s:25:"auto-sizes/auto-sizes.php";i:3;s:33:"classic-editor/classic-editor.php";i:4;s:35:"classic-widgets/classic-widgets.php";i:5;s:36:"contact-form-7-honeypot/honeypot.php";i:6;s:36:"contact-form-7/wp-contact-form-7.php";i:7;s:42:"contact-form-cfdb7/contact-form-cfdb-7.php";i:8;s:30:"dominant-color-images/load.php";i:9;s:45:"enable-svg-webp-ico-upload/itc-svg-upload.php";i:10;s:29:"health-check/health-check.php";i:11;s:39:"https-redirection/https-redirection.php";i:12;s:53:"index-wp-mysql-for-speed/index-wp-mysql-for-speed.php";i:13;s:24:"performance-lab/load.php";i:14;s:51:"performant-translations/performant-translations.php";i:15;s:43:"site-health-manager/site-health-manager.php";i:16;s:27:"svg-support/svg-support.php";i:17;s:25:"ukr-to-lat/ukr-to-lat.php";i:18;s:21:"webp-uploads/load.php";}', 'yes'),
	(148, 'add_admin_marker_timestamp', '1352375601', 'no'),
	(5, 'admin_email', 'crazyyy@gmail.com', 'yes'),
	(1874, 'admin_email_lifespan', '1745269888', 'yes'),
	(605, 'aio_wp_security_configs', 'a:112:{s:36:"aiowps_remove_wp_generator_meta_info";s:1:"1";s:25:"aiowps_prevent_hotlinking";s:0:"";s:28:"aiowps_enable_login_lockdown";s:1:"1";s:28:"aiowps_allow_unlock_requests";s:1:"1";s:25:"aiowps_max_login_attempts";i:3;s:24:"aiowps_retry_time_period";i:5;s:26:"aiowps_lockout_time_length";i:60;s:28:"aiowps_set_generic_login_msg";s:1:"1";s:26:"aiowps_enable_email_notify";s:1:"1";s:20:"aiowps_email_address";s:19:"info@wpeb.ddev.site";s:27:"aiowps_enable_forced_logout";s:0:"";s:25:"aiowps_logout_time_period";s:2:"60";s:39:"aiowps_enable_invalid_username_lockdown";s:0:"";s:32:"aiowps_unlock_request_secret_key";s:20:"ohy7ttxzt7k9r5my7rlz";s:26:"aiowps_enable_whitelisting";s:0:"";s:27:"aiowps_allowed_ip_addresses";s:0:"";s:27:"aiowps_enable_login_captcha";s:1:"1";s:34:"aiowps_enable_custom_login_captcha";s:1:"1";s:25:"aiowps_captcha_secret_key";s:20:"evnb4iydqjtw24ixfuh9";s:42:"aiowps_enable_manual_registration_approval";s:0:"";s:39:"aiowps_enable_registration_page_captcha";s:1:"1";s:27:"aiowps_enable_random_prefix";s:0:"";s:31:"aiowps_enable_automated_backups";s:1:"1";s:26:"aiowps_db_backup_frequency";i:1;s:25:"aiowps_db_backup_interval";s:1:"2";s:26:"aiowps_backup_files_stored";i:5;s:32:"aiowps_send_backup_email_address";s:0:"";s:27:"aiowps_backup_email_address";s:19:"info@wpeb.ddev.site";s:27:"aiowps_disable_file_editing";s:1:"1";s:37:"aiowps_prevent_default_wp_file_access";s:0:"";s:22:"aiowps_system_log_file";s:9:"error_log";s:26:"aiowps_enable_blacklisting";s:0:"";s:26:"aiowps_banned_ip_addresses";s:0:"";s:28:"aiowps_enable_basic_firewall";s:0:"";s:31:"aiowps_enable_pingback_firewall";s:0:"";s:26:"aiowps_disable_index_views";s:0:"";s:30:"aiowps_disable_trace_and_track";s:0:"";s:28:"aiowps_forbid_proxy_comments";s:0:"";s:29:"aiowps_deny_bad_query_strings";s:0:"";s:34:"aiowps_advanced_char_string_filter";s:0:"";s:25:"aiowps_enable_5g_firewall";s:0:"";s:25:"aiowps_enable_404_logging";s:0:"";s:28:"aiowps_enable_404_IP_lockout";s:0:"";s:30:"aiowps_404_lockout_time_length";s:2:"60";s:28:"aiowps_404_lock_redirect_url";s:16:"http://127.0.0.1";s:31:"aiowps_enable_rename_login_page";s:0:"";s:28:"aiowps_enable_login_honeypot";s:1:"1";s:43:"aiowps_enable_brute_force_attack_prevention";s:0:"";s:30:"aiowps_brute_force_secret_word";s:0:"";s:24:"aiowps_cookie_brute_test";s:29:"aiowps_cookie_test_iba7hg8tzh";s:44:"aiowps_cookie_based_brute_force_redirect_url";s:16:"http://127.0.0.1";s:59:"aiowps_brute_force_attack_prevention_pw_protected_exception";s:0:"";s:51:"aiowps_brute_force_attack_prevention_ajax_exception";s:0:"";s:19:"aiowps_site_lockout";s:0:"";s:23:"aiowps_site_lockout_msg";s:0:"";s:30:"aiowps_enable_spambot_blocking";s:0:"";s:29:"aiowps_enable_comment_captcha";s:1:"1";s:32:"aiowps_enable_automated_fcd_scan";s:1:"1";s:25:"aiowps_fcd_scan_frequency";i:2;s:24:"aiowps_fcd_scan_interval";s:1:"2";s:28:"aiowps_fcd_exclude_filetypes";s:0:"";s:24:"aiowps_fcd_exclude_files";s:5:"cache";s:26:"aiowps_send_fcd_scan_email";s:1:"1";s:29:"aiowps_fcd_scan_email_address";s:19:"info@wpeb.ddev.site";s:27:"aiowps_fcds_change_detected";b:0;s:22:"aiowps_copy_protection";s:0:"";s:40:"aiowps_prevent_site_display_inside_frame";s:0:"";s:35:"aiowps_enable_lost_password_captcha";s:1:"1";s:23:"aiowps_last_backup_time";s:19:"2022-08-25 20:37:50";s:25:"aiowps_last_fcd_scan_time";s:19:"2022-08-25 20:37:51";s:19:"aiowps_enable_debug";s:0:"";s:34:"aiowps_block_debug_log_file_access";s:0:"";s:25:"aiowps_enable_6g_firewall";s:0:"";s:26:"aiowps_enable_custom_rules";s:0:"";s:19:"aiowps_custom_rules";s:0:"";s:31:"aiowps_enable_autoblock_spam_ip";s:1:"1";s:33:"aiowps_spam_ip_min_comments_block";i:3;s:32:"aiowps_prevent_users_enumeration";s:1:"1";s:43:"aiowps_instantly_lockout_specific_usernames";a:0:{}s:35:"aiowps_lockdown_enable_whitelisting";s:0:"";s:36:"aiowps_lockdown_allowed_ip_addresses";s:0:"";s:35:"aiowps_enable_registration_honeypot";s:1:"1";s:38:"aiowps_disable_xmlrpc_pingback_methods";s:0:"";s:28:"aiowps_block_fake_googlebots";s:1:"1";s:26:"aiowps_cookie_test_success";s:1:"1";s:31:"aiowps_enable_woo_login_captcha";s:1:"1";s:34:"aiowps_enable_woo_register_captcha";s:1:"1";s:38:"aiowps_enable_woo_lostpassword_captcha";s:1:"1";s:25:"aiowps_recaptcha_site_key";s:0:"";s:27:"aiowps_recaptcha_secret_key";s:0:"";s:24:"aiowps_default_recaptcha";s:0:"";s:19:"aiowps_fcd_filename";s:26:"aiowps_fcd_data_ml5x64pna5";s:27:"aiowps_max_file_upload_size";s:2:"10";s:32:"aiowps_place_custom_rules_at_top";s:0:"";s:33:"aiowps_enable_bp_register_captcha";s:0:"";s:35:"aiowps_enable_bbp_new_topic_captcha";s:0:"";s:42:"aiowps_disallow_unauthorized_rest_requests";s:0:"";s:25:"aiowps_ip_retrieve_method";s:1:"0";s:12:"installed-at";i:1661449064;s:17:"dismissdashnotice";i:1693125855;s:36:"aiowps_enable_php_backtrace_in_email";s:0:"";s:30:"aiowps_max_lockout_time_length";s:2:"60";s:22:"aiowps_default_captcha";s:0:"";s:33:"aiowps_disable_rss_and_atom_feeds";s:0:"";s:35:"aiowps_disable_application_password";s:0:"";s:33:"aiowps_enable_trash_spam_comments";s:0:"";s:37:"aiowps_trash_spam_comments_after_days";s:2:"14";s:25:"aiowps_turnstile_site_key";s:0:"";s:27:"aiowps_turnstile_secret_key";s:0:"";s:36:"aiowps_on_uninstall_delete_db_tables";s:1:"1";s:34:"aiowps_on_uninstall_delete_configs";s:1:"1";s:21:"aios_firewall_dismiss";b:0;}', 'yes'),
	(2416, 'aiowps_temp_configs', 'a:111:{s:36:"aiowps_remove_wp_generator_meta_info";s:1:"1";s:25:"aiowps_prevent_hotlinking";s:1:"1";s:28:"aiowps_enable_login_lockdown";s:1:"1";s:28:"aiowps_allow_unlock_requests";s:1:"1";s:25:"aiowps_max_login_attempts";i:3;s:24:"aiowps_retry_time_period";i:5;s:26:"aiowps_lockout_time_length";i:60;s:28:"aiowps_set_generic_login_msg";s:1:"1";s:26:"aiowps_enable_email_notify";s:1:"1";s:20:"aiowps_email_address";s:19:"info@wpeb.ddev.site";s:27:"aiowps_enable_forced_logout";s:0:"";s:25:"aiowps_logout_time_period";s:2:"60";s:39:"aiowps_enable_invalid_username_lockdown";s:0:"";s:32:"aiowps_unlock_request_secret_key";s:20:"ohy7ttxzt7k9r5my7rlz";s:26:"aiowps_enable_whitelisting";s:0:"";s:27:"aiowps_allowed_ip_addresses";s:0:"";s:27:"aiowps_enable_login_captcha";s:1:"1";s:34:"aiowps_enable_custom_login_captcha";s:1:"1";s:25:"aiowps_captcha_secret_key";s:20:"evnb4iydqjtw24ixfuh9";s:42:"aiowps_enable_manual_registration_approval";s:0:"";s:39:"aiowps_enable_registration_page_captcha";s:1:"1";s:27:"aiowps_enable_random_prefix";s:0:"";s:31:"aiowps_enable_automated_backups";s:1:"1";s:26:"aiowps_db_backup_frequency";i:1;s:25:"aiowps_db_backup_interval";s:1:"2";s:26:"aiowps_backup_files_stored";i:5;s:32:"aiowps_send_backup_email_address";s:0:"";s:27:"aiowps_backup_email_address";s:19:"info@wpeb.ddev.site";s:27:"aiowps_disable_file_editing";s:1:"1";s:37:"aiowps_prevent_default_wp_file_access";s:1:"1";s:22:"aiowps_system_log_file";s:9:"error_log";s:26:"aiowps_enable_blacklisting";s:0:"";s:26:"aiowps_banned_ip_addresses";s:0:"";s:28:"aiowps_enable_basic_firewall";s:1:"1";s:31:"aiowps_enable_pingback_firewall";s:1:"1";s:26:"aiowps_disable_index_views";s:1:"1";s:30:"aiowps_disable_trace_and_track";s:1:"1";s:28:"aiowps_forbid_proxy_comments";s:1:"1";s:29:"aiowps_deny_bad_query_strings";s:1:"1";s:34:"aiowps_advanced_char_string_filter";s:1:"1";s:25:"aiowps_enable_5g_firewall";s:1:"1";s:25:"aiowps_enable_404_logging";s:0:"";s:28:"aiowps_enable_404_IP_lockout";s:0:"";s:30:"aiowps_404_lockout_time_length";s:2:"60";s:28:"aiowps_404_lock_redirect_url";s:16:"http://127.0.0.1";s:31:"aiowps_enable_rename_login_page";s:0:"";s:28:"aiowps_enable_login_honeypot";s:1:"1";s:43:"aiowps_enable_brute_force_attack_prevention";s:0:"";s:30:"aiowps_brute_force_secret_word";s:0:"";s:24:"aiowps_cookie_brute_test";s:29:"aiowps_cookie_test_iba7hg8tzh";s:44:"aiowps_cookie_based_brute_force_redirect_url";s:16:"http://127.0.0.1";s:59:"aiowps_brute_force_attack_prevention_pw_protected_exception";s:0:"";s:51:"aiowps_brute_force_attack_prevention_ajax_exception";s:0:"";s:19:"aiowps_site_lockout";s:0:"";s:23:"aiowps_site_lockout_msg";s:0:"";s:30:"aiowps_enable_spambot_blocking";s:1:"1";s:29:"aiowps_enable_comment_captcha";s:1:"1";s:32:"aiowps_enable_automated_fcd_scan";s:1:"1";s:25:"aiowps_fcd_scan_frequency";i:2;s:24:"aiowps_fcd_scan_interval";s:1:"2";s:28:"aiowps_fcd_exclude_filetypes";s:0:"";s:24:"aiowps_fcd_exclude_files";s:5:"cache";s:26:"aiowps_send_fcd_scan_email";s:1:"1";s:29:"aiowps_fcd_scan_email_address";s:19:"info@wpeb.ddev.site";s:27:"aiowps_fcds_change_detected";b:0;s:22:"aiowps_copy_protection";s:0:"";s:40:"aiowps_prevent_site_display_inside_frame";s:0:"";s:35:"aiowps_enable_lost_password_captcha";s:1:"1";s:23:"aiowps_last_backup_time";s:19:"2022-08-25 20:37:50";s:25:"aiowps_last_fcd_scan_time";s:19:"2022-08-25 20:37:51";s:19:"aiowps_enable_debug";s:0:"";s:34:"aiowps_block_debug_log_file_access";s:1:"1";s:25:"aiowps_enable_6g_firewall";s:1:"1";s:26:"aiowps_enable_custom_rules";s:0:"";s:19:"aiowps_custom_rules";s:0:"";s:31:"aiowps_enable_autoblock_spam_ip";s:1:"1";s:33:"aiowps_spam_ip_min_comments_block";i:3;s:32:"aiowps_prevent_users_enumeration";s:1:"1";s:43:"aiowps_instantly_lockout_specific_usernames";a:0:{}s:35:"aiowps_lockdown_enable_whitelisting";s:0:"";s:36:"aiowps_lockdown_allowed_ip_addresses";s:0:"";s:35:"aiowps_enable_registration_honeypot";s:1:"1";s:38:"aiowps_disable_xmlrpc_pingback_methods";s:0:"";s:28:"aiowps_block_fake_googlebots";s:1:"1";s:26:"aiowps_cookie_test_success";s:1:"1";s:31:"aiowps_enable_woo_login_captcha";s:1:"1";s:34:"aiowps_enable_woo_register_captcha";s:1:"1";s:38:"aiowps_enable_woo_lostpassword_captcha";s:1:"1";s:25:"aiowps_recaptcha_site_key";s:0:"";s:27:"aiowps_recaptcha_secret_key";s:0:"";s:24:"aiowps_default_recaptcha";s:0:"";s:19:"aiowps_fcd_filename";s:26:"aiowps_fcd_data_ml5x64pna5";s:27:"aiowps_max_file_upload_size";s:2:"10";s:32:"aiowps_place_custom_rules_at_top";s:0:"";s:33:"aiowps_enable_bp_register_captcha";s:0:"";s:35:"aiowps_enable_bbp_new_topic_captcha";s:0:"";s:42:"aiowps_disallow_unauthorized_rest_requests";s:0:"";s:25:"aiowps_ip_retrieve_method";s:1:"0";s:12:"installed-at";i:1661449064;s:17:"dismissdashnotice";i:1693125855;s:36:"aiowps_enable_php_backtrace_in_email";s:0:"";s:30:"aiowps_max_lockout_time_length";s:2:"60";s:22:"aiowps_default_captcha";s:0:"";s:33:"aiowps_disable_rss_and_atom_feeds";s:0:"";s:35:"aiowps_disable_application_password";s:0:"";s:33:"aiowps_enable_trash_spam_comments";s:0:"";s:37:"aiowps_trash_spam_comments_after_days";s:2:"14";s:25:"aiowps_turnstile_site_key";s:0:"";s:27:"aiowps_turnstile_secret_key";s:0:"";s:36:"aiowps_on_uninstall_delete_db_tables";s:1:"1";s:34:"aiowps_on_uninstall_delete_configs";s:1:"1";}', 'yes'),
	(604, 'aiowpsec_db_version', '1.9.8', 'yes'),
	(2409, 'aiowpsec_firewall_version', '1.0.3', 'yes'),
	(650, 'auto_core_update_notified', 'a:4:{s:4:"type";s:7:"success";s:5:"email";s:12:"info@wpeb.ddev.site";s:7:"version";s:5:"3.8.1";s:9:"timestamp";i:1395700963;}', 'yes'),
	(1997, 'auto_plugin_theme_update_emails', 'a:0:{}', 'no'),
	(1998, 'auto_update_core_dev', 'enabled', 'yes'),
	(2000, 'auto_update_core_major', 'unset', 'yes'),
	(1999, 'auto_update_core_minor', 'enabled', 'yes'),
	(2022, 'auto_update_plugins', 'a:55:{i:1;s:51:"all-in-one-wp-security-and-firewall/wp-security.php";i:2;s:43:"broken-link-checker/broken-link-checker.php";i:3;s:33:"classic-editor/classic-editor.php";i:4;s:33:"complianz-gdpr/complianz-gpdr.php";i:5;s:36:"contact-form-7/wp-contact-form-7.php";i:6;s:42:"contact-form-cfdb7/contact-form-cfdb-7.php";i:7;s:25:"fakerpress/fakerpress.php";i:8;s:29:"health-check/health-check.php";i:9;s:35:"litespeed-cache/litespeed-cache.php";i:11;s:27:"updraftplus/updraftplus.php";i:12;s:41:"wordpress-importer/wordpress-importer.php";i:13;s:39:"wp-file-manager/file_folder_manager.php";i:14;s:27:"wp-optimize/wp-optimize.php";i:15;s:34:"advanced-custom-fields-pro/acf.php";i:16;s:29:"acf-extended/acf-extended.php";i:17;s:53:"child-theme-configurator/child-theme-configurator.php";i:18;s:35:"classic-widgets/classic-widgets.php";i:20;s:43:"custom-post-type-ui/custom-post-type-ui.php";i:22;s:45:"enable-svg-webp-ico-upload/itc-svg-upload.php";i:23;s:45:"ewww-image-optimizer/ewww-image-optimizer.php";i:24;s:36:"contact-form-7-honeypot/honeypot.php";i:25;s:53:"index-wp-mysql-for-speed/index-wp-mysql-for-speed.php";i:26;s:24:"performance-lab/load.php";i:29;s:55:"plugins-garbage-collector/plugins-garbage-collector.php";i:30;s:31:"query-monitor/query-monitor.php";i:31;s:30:"seo-by-rank-math/rank-math.php";i:32;s:17:"revisr/revisr.php";i:33;s:33:"seo-image/seo-friendly-images.php";i:34;s:35:"google-site-kit/google-site-kit.php";i:39;s:37:"wp-reroute-email/wp-reroute-email.php";i:42;s:39:"bulk-page-creator/bulk-page-creator.php";i:43;s:41:"child-theme-wizard/child-theme-wizard.php";i:45;s:53:"customizer-export-import/customizer-export-import.php";i:49;s:43:"site-health-manager/site-health-manager.php";i:51;s:25:"ukr-to-lat/ukr-to-lat.php";i:52;s:36:"inspector-wp/wordpress-inspector.php";i:54;s:53:"widget-importer-exporter/widget-importer-exporter.php";i:55;s:23:"wordfence/wordfence.php";i:57;s:39:"https-redirection/https-redirection.php";i:58;s:45:"search-and-replace/inpsyde-search-replace.php";i:59;s:41:"acf-code-generator/acf_code_generator.php";i:62;s:41:"acf-theme-code-pro/acf_theme_code_pro.php";i:64;s:51:"all-in-one-wp-migration/all-in-one-wp-migration.php";i:65;s:91:"all-in-one-wp-migration-unlimited-extension/all-in-one-wp-migration-unlimited-extension.php";i:66;s:41:"another-show-hooks/another-show-hooks.php";i:67;s:25:"auto-sizes/auto-sizes.php";i:74;s:33:"code-generator/code-generator.php";i:86;s:29:"http-headers/http-headers.php";i:87;s:30:"dominant-color-images/load.php";i:90;s:21:"webp-uploads/load.php";i:92;s:45:"performance-profiler/performance-profiler.php";i:93;s:51:"performant-translations/performant-translations.php";i:96;s:39:"query-monitor-log-viewer/log-viewer.php";i:103;s:27:"svg-support/svg-support.php";i:111;s:33:"wp-performance/wp-performance.php";}', 'no'),
	(68, 'avatar_default', 'wavatar', 'yes'),
	(61, 'avatar_rating', 'G', 'yes'),
	(34, 'blog_charset', 'UTF-8', 'yes'),
	(56, 'blog_public', '1', 'yes'),
	(3, 'blogdescription', '', 'yes'),
	(2, 'blogname', 'WBEP Framework', 'yes'),
	(2946, 'bodhi_svgs_plugin_version', '2.5.8', 'yes'),
	(2947, 'bodhi_svgs_settings', 'a:4:{s:22:"sanitize_svg_front_end";s:2:"on";s:8:"restrict";a:1:{i:0;s:13:"administrator";}s:24:"sanitize_on_upload_roles";a:2:{i:0;s:13:"administrator";i:1;s:6:"editor";}s:10:"css_target";s:0:"";}', 'yes'),
	(520, 'bwp_gxs_log', 'a:2:{s:3:"log";a:0:{}s:7:"sitemap";a:0:{}}', 'yes'),
	(2922, 'can_compress_scripts', '0', 'yes'),
	(38, 'category_base', '/', 'yes'),
	(2658, 'category_children', 'a:0:{}', 'yes'),
	(2801, 'cfdb7_view_ignore_notice', 'true', 'yes'),
	(1937, 'cfdb7_view_install_date', '2020-02-03 16:47:01', 'yes'),
	(1951, 'classic-editor-allow-users', 'disallow', 'yes'),
	(1950, 'classic-editor-replace', 'classic', 'yes'),
	(77, 'close_comments_days_old', '31', 'yes'),
	(76, 'close_comments_for_old_posts', '', 'yes'),
	(41, 'comment_max_links', '2', 'yes'),
	(29, 'comment_moderation', '', 'yes'),
	(83, 'comment_order', 'asc', 'yes'),
	(1996, 'comment_previously_approved', '1', 'yes'),
	(49, 'comment_registration', '', 'yes'),
	(10, 'comments_notify', '1', 'yes'),
	(81, 'comments_per_page', '50', 'yes'),
	(1940, 'cptui_new_install', 'false', 'yes'),
	(104, 'cron', 'a:17:{i:1729721013;a:1:{s:34:"wp_privacy_delete_old_export_files";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"hourly";s:4:"args";a:0:{}s:8:"interval";i:3600;}}}i:1729723687;a:3:{s:16:"wp_version_check";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:17:"wp_update_plugins";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}s:16:"wp_update_themes";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1729727581;a:1:{s:29:"simple_history/maybe_purge_db";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1729730539;a:1:{s:16:"itsec_purge_logs";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1729749948;a:1:{s:21:"wp_update_user_counts";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:10:"twicedaily";s:4:"args";a:0:{}s:8:"interval";i:43200;}}}i:1729750575;a:1:{s:23:"aiowps_clean_old_events";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1729752836;a:1:{s:32:"recovery_mode_clean_expired_keys";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1729766722;a:1:{s:25:"delete_expired_transients";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1729766897;a:1:{s:19:"wp_scheduled_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1729771913;a:1:{s:30:"wp_scheduled_auto_draft_delete";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:0:{}s:8:"interval";i:86400;}}}i:1729800000;a:1:{s:19:"hmbkp_schedule_hook";a:1:{s:32:"7238d8d892636ada924d8907a1becaca";a:3:{s:8:"schedule";s:5:"daily";s:4:"args";a:1:{s:2:"id";s:10:"1434587998";}s:8:"interval";i:86400;}}}i:1729805700;a:1:{s:30:"wp_delete_temp_updater_backups";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"weekly";s:4:"args";a:0:{}s:8:"interval";i:604800;}}}i:1729848499;a:1:{s:30:"wp_site_health_scheduled_check";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"weekly";s:4:"args";a:0:{}s:8:"interval";i:604800;}}}i:1730126183;a:1:{s:18:"wpseo_onpage_fetch";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"weekly";s:4:"args";a:0:{}s:8:"interval";i:604800;}}}i:1730267789;a:1:{s:27:"acf_update_site_health_data";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"weekly";s:4:"args";a:0:{}s:8:"interval";i:604800;}}}i:1730268988;a:1:{s:24:"aiowps_weekly_cron_event";a:1:{s:32:"40cd750bba9870f18aada2478b24840a";a:3:{s:8:"schedule";s:6:"weekly";s:4:"args";a:0:{}s:8:"interval";i:604800;}}}s:7:"version";i:2;}', 'yes'),
	(412, 'current_theme', 'WP Wheel', 'yes'),
	(2535, 'd4p_blog_sweeppress_cache', 'a:1:{s:8:"sweepers";a:29:{s:16:"posts-auto-draft";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:14:{s:4:"post";a:7:{s:4:"type";s:9:"post_type";s:10:"registered";b:1;s:10:"real_title";s:4:"post";s:5:"title";s:5:"Posts";s:5:"items";i:1;s:7:"records";i:1;s:4:"size";i:0;}s:4:"page";a:5:{s:5:"title";s:5:"Pages";s:10:"real_title";s:4:"page";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:10:"attachment";a:5:{s:5:"title";s:5:"Media";s:10:"real_title";s:10:"attachment";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:8:"revision";a:5:{s:5:"title";s:9:"Revisions";s:10:"real_title";s:8:"revision";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:13:"nav_menu_item";a:5:{s:5:"title";s:21:"Navigation Menu Items";s:10:"real_title";s:13:"nav_menu_item";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:10:"custom_css";a:5:{s:5:"title";s:10:"Custom CSS";s:10:"real_title";s:10:"custom_css";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:19:"customize_changeset";a:5:{s:5:"title";s:10:"Changesets";s:10:"real_title";s:19:"customize_changeset";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:12:"oembed_cache";a:5:{s:5:"title";s:16:"oEmbed Responses";s:10:"real_title";s:12:"oembed_cache";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:12:"user_request";a:5:{s:5:"title";s:13:"User Requests";s:10:"real_title";s:12:"user_request";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:8:"wp_block";a:5:{s:5:"title";s:15:"Reusable blocks";s:10:"real_title";s:8:"wp_block";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:11:"wp_template";a:5:{s:5:"title";s:9:"Templates";s:10:"real_title";s:11:"wp_template";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:16:"wp_template_part";a:5:{s:5:"title";s:14:"Template Parts";s:10:"real_title";s:16:"wp_template_part";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:16:"wp_global_styles";a:5:{s:5:"title";s:13:"Global Styles";s:10:"real_title";s:16:"wp_global_styles";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:13:"wp_navigation";a:5:{s:5:"title";s:16:"Navigation Menus";s:10:"real_title";s:13:"wp_navigation";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}}}s:10:"posts-spam";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:14:{s:4:"post";a:5:{s:5:"title";s:5:"Posts";s:10:"real_title";s:4:"post";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:4:"page";a:5:{s:5:"title";s:5:"Pages";s:10:"real_title";s:4:"page";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:10:"attachment";a:5:{s:5:"title";s:5:"Media";s:10:"real_title";s:10:"attachment";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:8:"revision";a:5:{s:5:"title";s:9:"Revisions";s:10:"real_title";s:8:"revision";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:13:"nav_menu_item";a:5:{s:5:"title";s:21:"Navigation Menu Items";s:10:"real_title";s:13:"nav_menu_item";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:10:"custom_css";a:5:{s:5:"title";s:10:"Custom CSS";s:10:"real_title";s:10:"custom_css";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:19:"customize_changeset";a:5:{s:5:"title";s:10:"Changesets";s:10:"real_title";s:19:"customize_changeset";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:12:"oembed_cache";a:5:{s:5:"title";s:16:"oEmbed Responses";s:10:"real_title";s:12:"oembed_cache";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:12:"user_request";a:5:{s:5:"title";s:13:"User Requests";s:10:"real_title";s:12:"user_request";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:8:"wp_block";a:5:{s:5:"title";s:15:"Reusable blocks";s:10:"real_title";s:8:"wp_block";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:11:"wp_template";a:5:{s:5:"title";s:9:"Templates";s:10:"real_title";s:11:"wp_template";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:16:"wp_template_part";a:5:{s:5:"title";s:14:"Template Parts";s:10:"real_title";s:16:"wp_template_part";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:16:"wp_global_styles";a:5:{s:5:"title";s:13:"Global Styles";s:10:"real_title";s:16:"wp_global_styles";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:13:"wp_navigation";a:5:{s:5:"title";s:16:"Navigation Menus";s:10:"real_title";s:13:"wp_navigation";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}}}s:11:"posts-trash";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:14:{s:4:"post";a:5:{s:5:"title";s:5:"Posts";s:10:"real_title";s:4:"post";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:4:"page";a:5:{s:5:"title";s:5:"Pages";s:10:"real_title";s:4:"page";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:10:"attachment";a:5:{s:5:"title";s:5:"Media";s:10:"real_title";s:10:"attachment";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:8:"revision";a:5:{s:5:"title";s:9:"Revisions";s:10:"real_title";s:8:"revision";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:13:"nav_menu_item";a:5:{s:5:"title";s:21:"Navigation Menu Items";s:10:"real_title";s:13:"nav_menu_item";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:10:"custom_css";a:5:{s:5:"title";s:10:"Custom CSS";s:10:"real_title";s:10:"custom_css";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:19:"customize_changeset";a:5:{s:5:"title";s:10:"Changesets";s:10:"real_title";s:19:"customize_changeset";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:12:"oembed_cache";a:5:{s:5:"title";s:16:"oEmbed Responses";s:10:"real_title";s:12:"oembed_cache";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:12:"user_request";a:5:{s:5:"title";s:13:"User Requests";s:10:"real_title";s:12:"user_request";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:8:"wp_block";a:5:{s:5:"title";s:15:"Reusable blocks";s:10:"real_title";s:8:"wp_block";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:11:"wp_template";a:5:{s:5:"title";s:9:"Templates";s:10:"real_title";s:11:"wp_template";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:16:"wp_template_part";a:5:{s:5:"title";s:14:"Template Parts";s:10:"real_title";s:16:"wp_template_part";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:16:"wp_global_styles";a:5:{s:5:"title";s:13:"Global Styles";s:10:"real_title";s:16:"wp_global_styles";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:13:"wp_navigation";a:5:{s:5:"title";s:16:"Navigation Menus";s:10:"real_title";s:13:"wp_navigation";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}}}s:15:"posts-revisions";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:14:{s:4:"post";a:5:{s:5:"title";s:5:"Posts";s:10:"real_title";s:4:"post";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:4:"page";a:5:{s:5:"title";s:5:"Pages";s:10:"real_title";s:4:"page";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:10:"attachment";a:5:{s:5:"title";s:5:"Media";s:10:"real_title";s:10:"attachment";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:8:"revision";a:5:{s:5:"title";s:9:"Revisions";s:10:"real_title";s:8:"revision";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:13:"nav_menu_item";a:5:{s:5:"title";s:21:"Navigation Menu Items";s:10:"real_title";s:13:"nav_menu_item";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:10:"custom_css";a:5:{s:5:"title";s:10:"Custom CSS";s:10:"real_title";s:10:"custom_css";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:19:"customize_changeset";a:5:{s:5:"title";s:10:"Changesets";s:10:"real_title";s:19:"customize_changeset";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:12:"oembed_cache";a:5:{s:5:"title";s:16:"oEmbed Responses";s:10:"real_title";s:12:"oembed_cache";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:12:"user_request";a:5:{s:5:"title";s:13:"User Requests";s:10:"real_title";s:12:"user_request";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:8:"wp_block";a:5:{s:5:"title";s:15:"Reusable blocks";s:10:"real_title";s:8:"wp_block";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:11:"wp_template";a:5:{s:5:"title";s:9:"Templates";s:10:"real_title";s:11:"wp_template";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:16:"wp_template_part";a:5:{s:5:"title";s:14:"Template Parts";s:10:"real_title";s:16:"wp_template_part";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:16:"wp_global_styles";a:5:{s:5:"title";s:13:"Global Styles";s:10:"real_title";s:16:"wp_global_styles";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:13:"wp_navigation";a:5:{s:5:"title";s:16:"Navigation Menus";s:10:"real_title";s:13:"wp_navigation";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}}}s:21:"posts-draft-revisions";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:14:{s:4:"post";a:5:{s:5:"title";s:5:"Posts";s:10:"real_title";s:4:"post";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:4:"page";a:5:{s:5:"title";s:5:"Pages";s:10:"real_title";s:4:"page";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:10:"attachment";a:5:{s:5:"title";s:5:"Media";s:10:"real_title";s:10:"attachment";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:8:"revision";a:5:{s:5:"title";s:9:"Revisions";s:10:"real_title";s:8:"revision";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:13:"nav_menu_item";a:5:{s:5:"title";s:21:"Navigation Menu Items";s:10:"real_title";s:13:"nav_menu_item";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:10:"custom_css";a:5:{s:5:"title";s:10:"Custom CSS";s:10:"real_title";s:10:"custom_css";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:19:"customize_changeset";a:5:{s:5:"title";s:10:"Changesets";s:10:"real_title";s:19:"customize_changeset";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:12:"oembed_cache";a:5:{s:5:"title";s:16:"oEmbed Responses";s:10:"real_title";s:12:"oembed_cache";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:12:"user_request";a:5:{s:5:"title";s:13:"User Requests";s:10:"real_title";s:12:"user_request";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:8:"wp_block";a:5:{s:5:"title";s:15:"Reusable blocks";s:10:"real_title";s:8:"wp_block";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:11:"wp_template";a:5:{s:5:"title";s:9:"Templates";s:10:"real_title";s:11:"wp_template";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:16:"wp_template_part";a:5:{s:5:"title";s:14:"Template Parts";s:10:"real_title";s:16:"wp_template_part";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:16:"wp_global_styles";a:5:{s:5:"title";s:13:"Global Styles";s:10:"real_title";s:16:"wp_global_styles";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:13:"wp_navigation";a:5:{s:5:"title";s:16:"Navigation Menus";s:10:"real_title";s:13:"wp_navigation";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}}}s:24:"posts-orphaned-revisions";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:24:"posts-orphaned-revisions";a:3:{s:5:"title";s:18:"Orphaned Revisions";s:7:"records";i:0;s:4:"size";i:0;}}}s:14:"postmeta-locks";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:14:"postmeta-locks";a:3:{s:5:"title";s:22:"Meta key: \'_edit_lock\'";s:7:"records";i:0;s:4:"size";i:0;}}}s:14:"postmeta-edits";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:14:"postmeta-edits";a:3:{s:5:"title";s:22:"Meta key: \'_edit_last\'";s:7:"records";i:0;s:4:"size";i:0;}}}s:12:"postmeta-old";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:2:{s:12:"_wp_old_slug";a:3:{s:5:"title";s:24:"Meta key: \'_wp_old_slug\'";s:7:"records";i:0;s:4:"size";i:0;}s:12:"_wp_old_date";a:3:{s:5:"title";s:24:"Meta key: \'_wp_old_date\'";s:7:"records";i:0;s:4:"size";i:0;}}}s:16:"postmeta-oembeds";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:16:"postmeta-oembeds";a:3:{s:5:"title";s:14:"OEmbed Records";s:7:"records";i:0;s:4:"size";i:0;}}}s:16:"postmeta-orphans";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:16:"postmeta-orphans";a:3:{s:5:"title";s:16:"Orphaned Records";s:7:"records";i:0;s:4:"size";i:0;}}}s:13:"comments-spam";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:4:{s:7:"comment";a:5:{s:5:"title";s:7:"Comment";s:10:"real_title";s:7:"comment";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:9:"trackback";a:5:{s:5:"title";s:9:"Trackback";s:10:"real_title";s:9:"trackback";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:8:"pingback";a:5:{s:5:"title";s:8:"Pingback";s:10:"real_title";s:8:"pingback";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:17:"gdrts-user-review";a:5:{s:5:"title";s:18:"Rating User Review";s:10:"real_title";s:17:"gdrts-user-review";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}}}s:14:"comments-trash";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:4:{s:7:"comment";a:5:{s:5:"title";s:7:"Comment";s:10:"real_title";s:7:"comment";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:9:"trackback";a:5:{s:5:"title";s:9:"Trackback";s:10:"real_title";s:9:"trackback";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:8:"pingback";a:5:{s:5:"title";s:8:"Pingback";s:10:"real_title";s:8:"pingback";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:17:"gdrts-user-review";a:5:{s:5:"title";s:18:"Rating User Review";s:10:"real_title";s:17:"gdrts-user-review";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}}}s:19:"comments-unapproved";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:4:{s:7:"comment";a:5:{s:5:"title";s:7:"Comment";s:10:"real_title";s:7:"comment";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:9:"trackback";a:5:{s:5:"title";s:9:"Trackback";s:10:"real_title";s:9:"trackback";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:8:"pingback";a:5:{s:5:"title";s:8:"Pingback";s:10:"real_title";s:8:"pingback";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}s:17:"gdrts-user-review";a:5:{s:5:"title";s:18:"Rating User Review";s:10:"real_title";s:17:"gdrts-user-review";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}}}s:16:"comments-orphans";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:16:"comments-orphans";a:4:{s:5:"title";s:17:"Orphaned Comments";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}}}s:19:"comments-user-agent";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:19:"comments-user-agent";a:3:{s:5:"title";s:23:"Records with User Agent";s:7:"records";i:0;s:4:"size";i:0;}}}s:19:"commentmeta-orphans";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:19:"commentmeta-orphans";a:3:{s:5:"title";s:16:"Orphaned Records";s:7:"records";i:0;s:4:"size";i:0;}}}s:17:"pingbacks-cleanup";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:17:"pingbacks-cleanup";a:5:{s:5:"title";s:8:"Pingback";s:10:"real_title";s:8:"pingback";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}}}s:18:"trackbacks-cleanup";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:18:"trackbacks-cleanup";a:5:{s:5:"title";s:9:"Trackback";s:10:"real_title";s:9:"trackback";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}}}s:12:"akismet-meta";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:12:"akismet-meta";a:4:{s:5:"title";s:15:"Akismet Records";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}}}s:13:"terms-orphans";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:13:"terms-orphans";a:4:{s:5:"title";s:14:"Orphaned Terms";s:5:"items";s:1:"0";s:7:"records";i:0;s:4:"size";i:0;}}}s:16:"termmeta-orphans";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:16:"termmeta-orphans";a:3:{s:5:"title";s:16:"Orphaned Records";s:7:"records";s:1:"0";s:4:"size";s:1:"0";}}}s:16:"usermeta-orphans";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:16:"usermeta-orphans";a:3:{s:5:"title";s:16:"Orphaned Records";s:7:"records";s:1:"0";s:4:"size";s:1:"0";}}}s:18:"expired-transients";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:18:"expired-transients";a:5:{s:10:"transients";a:2:{s:4:"site";a:7:{i:0;s:42:"php_check_653b16e6c5979ac325fae9f9db6a18fe";i:1;s:49:"community-events-1aecf33ab8525ff212ebdffbb438372e";i:2;s:22:"available_translations";i:3;s:40:"browser_d779790d920bc0f1ab1a364c74903611";i:4;s:40:"browser_759b1e79d21e38d89cd2791faa91f8c6";i:5;s:42:"php_check_3fde9d06ba9e4fd20d08658e6f30b792";i:6;s:40:"browser_199212111a57ddf8d1f2e5cbdad1a5e2";}s:5:"local";a:5:{i:0;s:41:"feed_mod_d117b5738fbd35bd8c0391cda1f2b5d9";i:1;s:40:"dash_v2_88ae138922fe95674369b1cb3d215a2b";i:2;s:37:"feed_9bbd59226dc36b9b26cd43f15694c5c3";i:3;s:37:"feed_d117b5738fbd35bd8c0391cda1f2b5d9";i:4;s:41:"feed_mod_9bbd59226dc36b9b26cd43f15694c5c3";}}s:5:"title";s:18:"Expired Transients";s:5:"items";i:0;s:7:"records";i:24;s:4:"size";i:918904;}}}s:9:"rss-feeds";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:9:"rss-feeds";a:5:{s:10:"transients";a:2:{s:4:"site";a:0:{}s:5:"local";a:5:{i:0;s:40:"dash_v2_88ae138922fe95674369b1cb3d215a2b";i:1;s:37:"feed_9bbd59226dc36b9b26cd43f15694c5c3";i:2;s:37:"feed_d117b5738fbd35bd8c0391cda1f2b5d9";i:3;s:41:"feed_mod_9bbd59226dc36b9b26cd43f15694c5c3";i:4;s:41:"feed_mod_d117b5738fbd35bd8c0391cda1f2b5d9";}}s:5:"title";s:9:"All Feeds";s:5:"items";i:0;s:7:"records";i:10;s:4:"size";i:867979;}}}s:14:"all-transients";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:14:"all-transients";a:5:{s:10:"transients";a:2:{s:4:"site";a:12:{i:0;s:22:"available_translations";i:1;s:40:"browser_199212111a57ddf8d1f2e5cbdad1a5e2";i:2;s:40:"browser_759b1e79d21e38d89cd2791faa91f8c6";i:3;s:40:"browser_d779790d920bc0f1ab1a364c74903611";i:4;s:49:"community-events-1aecf33ab8525ff212ebdffbb438372e";i:5;s:42:"php_check_3fde9d06ba9e4fd20d08658e6f30b792";i:6;s:42:"php_check_653b16e6c5979ac325fae9f9db6a18fe";i:7;s:40:"poptags_40cd750bba9870f18aada2478b24840a";i:8;s:11:"theme_roots";i:18;s:11:"update_core";i:19;s:14:"update_plugins";i:20;s:13:"update_themes";}s:5:"local";a:10:{i:0;s:18:"acf_plugin_updates";i:1;s:40:"dash_v2_88ae138922fe95674369b1cb3d215a2b";i:2;s:37:"feed_9bbd59226dc36b9b26cd43f15694c5c3";i:3;s:37:"feed_d117b5738fbd35bd8c0391cda1f2b5d9";i:4;s:41:"feed_mod_9bbd59226dc36b9b26cd43f15694c5c3";i:5;s:41:"feed_mod_d117b5738fbd35bd8c0391cda1f2b5d9";i:6;s:31:"health-check-site-status-result";i:7;s:31:"perflab_set_object_cache_dropin";i:13;s:12:"users_online";i:14;s:19:"wfRegistrationToken";}}s:5:"title";s:14:"All Transients";s:5:"items";i:0;s:7:"records";i:36;s:4:"size";i:977618;}}}s:9:"cron-jobs";a:2:{s:6:"expire";i:1692313608;s:4:"data";a:1:{s:9:"cron-jobs";a:4:{s:5:"title";s:13:"All CRON Jobs";s:5:"items";i:0;s:7:"records";i:1;s:4:"size";i:3469;}}}s:15:"optimize-tables";a:2:{s:6:"expire";i:1692313610;s:4:"data";a:1:{s:15:"optimize-tables";a:4:{s:5:"title";s:17:"Fragmented Tables";s:5:"items";i:0;s:7:"records";i:0;s:4:"size";i:0;}}}s:13:"repair-tables";a:2:{s:6:"expire";i:1692313610;s:4:"data";a:0:{}}}}', 'yes'),
	(2533, 'd4p_blog_sweeppress_core', 'a:2:{s:9:"activated";i:0;s:9:"installed";s:19:"2023-08-17 21:02:33";}', 'yes'),
	(2538, 'd4p_blog_sweeppress_info', 'a:21:{s:4:"code";s:10:"sweeppress";s:7:"version";s:3:"2.3";s:5:"build";i:90;s:7:"updated";s:10:"2023.08.11";s:6:"status";s:6:"stable";s:7:"edition";s:4:"lite";s:8:"released";s:10:"2022.03.03";s:10:"plugin_url";s:0:"";s:10:"github_url";s:0:"";s:10:"wp_org_url";s:0:"";s:17:"is_bbpress_plugin";b:0;s:11:"author_name";s:14:"Milan Petrovic";s:10:"author_url";s:26:"https://www.dev4press.com/";s:3:"php";s:3:"7.3";s:5:"mysql";s:3:"5.0";s:3:"cms";a:2:{s:9:"wordpress";s:3:"5.5";s:12:"classicpress";s:3:"1.2";}s:7:"plugins";a:2:{s:7:"bbpress";b:0;s:10:"buddypress";b:0;}s:7:"install";b:0;s:6:"update";b:0;s:8:"previous";i:0;s:12:"translations";a:0:{}}', 'yes'),
	(2536, 'd4p_blog_sweeppress_settings', 'a:3:{s:10:"expand_cli";b:1;s:11:"expand_rest";b:0;s:19:"hide_backup_notices";b:1;}', 'yes'),
	(2534, 'd4p_blog_sweeppress_statistics', 'a:2:{s:6:"months";a:0:{}s:5:"total";a:0:{}}', 'yes'),
	(2537, 'd4p_blog_sweeppress_sweepers', 'a:23:{s:19:"estimated_mode_full";b:0;s:15:"estimated_cache";b:1;s:26:"keep_days_posts-auto-draft";i:14;s:20:"keep_days_posts-spam";i:14;s:21:"keep_days_posts-trash";i:14;s:25:"keep_days_posts-revisions";i:14;s:31:"keep_days_posts-draft-revisions";i:14;s:23:"keep_days_comments-spam";i:14;s:24:"keep_days_comments-trash";i:14;s:29:"keep_days_comments-unapproved";i:60;s:27:"keep_days_comments-pingback";i:14;s:28:"keep_days_comments-trackback";i:14;s:21:"keep_days_comments-ua";i:14;s:26:"keep_days_comments-akismet";i:14;s:26:"keep_days_signups-inactive";i:90;s:29:"keep_days_actionscheduler-log";i:14;s:32:"keep_days_actionscheduler-failed";i:14;s:34:"keep_days_actionscheduler-complete";i:14;s:34:"keep_days_actionscheduler-canceled";i:14;s:27:"db_table_optimize_threshold";i:40;s:26:"db_table_optimize_min_size";i:6;s:24:"db_table_optimize_method";s:8:"optimize";s:19:"last_used_timestamp";a:0:{}}', 'yes'),
	(113, 'dashboard_widget_options', 'a:4:{s:25:"dashboard_recent_comments";a:1:{s:5:"items";i:5;}s:24:"dashboard_incoming_links";a:5:{s:4:"home";s:21:"http://wpeb.ddev.site";s:4:"link";s:97:"http://blogsearch.google.com/blogsearch?scoring=d&partner=wordpress&q=link:http://wpeb.ddev.site/";s:3:"url";s:130:"http://blogsearch.google.com/blogsearch_feeds?scoring=d&ie=utf-8&num=10&output=rss&partner=wordpress&q=link:http://wpeb.ddev.site/";s:5:"items";i:10;s:9:"show_date";b:0;}s:17:"dashboard_primary";a:7:{s:4:"link";s:26:"http://wordpress.org/news/";s:3:"url";s:31:"http://wordpress.org/news/feed/";s:5:"title";s:18:"Блог WordPress";s:5:"items";i:2;s:12:"show_summary";i:1;s:11:"show_author";i:0;s:9:"show_date";i:1;}s:19:"dashboard_secondary";a:7:{s:4:"link";s:28:"http://planet.wordpress.org/";s:3:"url";s:33:"http://planet.wordpress.org/feed/";s:5:"title";s:37:"Другие новости WordPress";s:5:"items";i:5;s:12:"show_summary";i:0;s:11:"show_author";i:0;s:9:"show_date";i:0;}}', 'yes'),
	(23, 'date_format', 'd.m.Y', 'yes'),
	(405, 'db_upgraded', '', 'yes'),
	(53, 'db_version', '57155', 'yes'),
	(202, 'ddsg_items_per_page', '50', 'yes'),
	(201, 'ddsg_language', 'Russian', 'yes'),
	(2550, 'debugpress_settings', 'a:32:{s:10:"access_key";s:14:"debugaccesskey";s:2:"pr";s:4:"kint";s:6:"active";b:0;s:5:"admin";b:1;s:8:"frontend";b:0;s:4:"ajax";b:1;s:16:"ajax_to_debuglog";b:0;s:9:"mousetrap";b:0;s:18:"mousetrap_sequence";s:12:"ctrl+shift+u";s:12:"button_admin";s:7:"toolbar";s:15:"button_frontend";s:7:"toolbar";s:15:"for_super_admin";b:1;s:9:"for_roles";a:5:{i:0;s:13:"administrator";i:1;s:6:"editor";i:2;s:6:"author";i:3;s:11:"contributor";i:4;s:10:"subscriber";}s:11:"for_visitor";b:0;s:12:"auto_wpdebug";b:0;s:16:"auto_savequeries";b:0;s:15:"errors_override";b:1;s:19:"deprecated_override";b:1;s:21:"doingitwrong_override";b:1;s:14:"panel_rewriter";b:1;s:13:"panel_request";b:1;s:14:"panel_debuglog";b:1;s:13:"panel_content";b:0;s:11:"panel_hooks";b:1;s:11:"panel_roles";b:0;s:13:"panel_enqueue";b:1;s:12:"panel_system";b:1;s:10:"panel_user";b:0;s:15:"panel_constants";b:1;s:10:"panel_http";b:1;s:9:"panel_php";b:1;s:13:"panel_bbpress";b:0;}', 'yes'),
	(17, 'default_category', '1', 'yes'),
	(18, 'default_comment_status', 'open', 'yes'),
	(82, 'default_comments_page', 'newest', 'yes'),
	(43, 'default_email_category', '1', 'yes'),
	(57, 'default_link_category', '0', 'yes'),
	(19, 'default_ping_status', 'closed', 'yes'),
	(20, 'default_pingback_flag', '1', 'yes'),
	(95, 'default_post_format', '0', 'yes'),
	(52, 'default_role', 'subscriber', 'yes'),
	(1995, 'disallowed_keys', '-online\n.twinstatesnetwork.\n1031-exchange-properties\n125.47.41.166\n148.233.159.58\n165.29.58.126\n189.19.60.94\n189.4.80.48\n190.10.68.228\n194.68.238.7\n195.244.128.237\n195.250.160.37\n196.207.15.201\n196.207.40.213\n196.217.249.190\n1website\n200.51.41.29\n200.65.127.161\n200.68.73.193\n201.210.1.148\n201.234.19.13\n202.115.130.23\n206.245.173.42\n207.41.73.13\n210.212.228.7\n210.22.158.132\n213.239.210.120\n216.195.53.11\n216.213.199.53\n217.141.105.203\n217.141.106.201\n217.141.109.205\n217.141.249.203\n217.141.250.204\n217.65.31.167\n218.63.252.219\n219.209.194.156\n220.178.98.59\n221.122.43.124\n222.127.228.5\n222.221.6.144\n222.240.212.3\n222.82.226.145\n24.222.34.242\n4best-health.\n4u\n58.68.34.59\n61.133.87.226\n64.22.107.90\n64.22.110.2\n64.22.110.34\n67.227.134.4\n69.89.31.233\n70.86.141.82\n72.34.55.196\n74.53.227.178\n74.86.121.13\n80.227.1.100\n80.227.1.101\n80.231.198.77\n83.136.195.229\n85.13.219.98\n86.96.226.13\n86.96.226.14\n86.96.226.15\n87.101.244.6\n87.101.244.9\n88.147.165.40\n88.198.107.250\n88.249.63.217\n92.112.81.15\naccident insurance\nace-decoy-anchors.\nacnetreatment\nadderall\nadipex\nadvicer\nagentmanhoodragged\nalina1026@gmail.com\nallauctions4u.\nallegra\nalprazolam\nambien\namitriptyline\nanal\nanthurium\napexautoloan\nativan\natkins\nauto insurance\navailable-credit.\nbaccarat\nbaccarrat\nbalder\nballhoneys\nbannbaba.\nbbeckford@tscamail.com\nbestweblinks\nbitches\nblackjack\nbllogspot\nblow-ebony-job\nboat-loans\nbondage\nbontril\nbooker\nbutthole\nbuy online\nbuy-levitra-online\nbuy-phentermine\nbuy-porn-movie-online\nbuy-viagra\nbuy-xanax\nbuycialis\nbyob\nc**k\ncaclbca.\ncar insurance\ncar-rental-e-site\ncar-rentals-e-site\ncarisoprodol\ncash-services.\ncasino\ncasino-games\ncasinos\ncasualty insurance\ncephalexin\nchatroom\ncheapcarleasehire\ncheapdisneyvacationspackagesandtickets\ncialis\ncialisonline\ncitalopram\nclitoris\nclomid\ncock\ncollege-knowledge\ncompany-si.\ncontentattack.com\ncoolcoolhu\ncoolhu\ncopulationformmeet\ncraps\ncredit-card-debt\ncredit-cards\ncredit-dreams\ncredit-report-4u\ncreditcard\ncricketblog\ncunt\ncurrency-site\ncwas\ncyclen\ncyclobenzaprine\ncymbalta\ndating-e-site\ndawsonanddadrealty.\nday-trading\ndebt-consolidation\ndebt-consolidation-consultant\ndepressioninformation.net\ndiabservis.\ndidrex\ndiet-pill\ndiet-pills\ndiggdigg.co.cc\ndiscreetordering\ndissimilarly\ndistanceeducation\ndoxycycline\nduty-free\ndutyfree\nephedra\nequityloans\nfacial\nfinalsearch\nfioricet\nflamingosandfriends.\nflower4us\nflowers-leading-site\nforex\nfree-cumshot-gallery\nfree-online-poker\nfree-poker\nfree-ringtones\nfreenet\nfreenet-shopping\nfuck\nfukk\nfucking\ngambling\ngambling-\ngeneric-viagra\nh1.ripway\nhair-loss\nhawaiiresortblog\nheadsetplus\nhealth insurance\nhealth-insurancedeals-4u\nhentai\nholdem\nholdempoker\nholdemsoftware\nholdemtexasturbowilson\nhome-loans-inc.\nhomeequityloans\nhomefinance\nhomemade_sedatives\nhomeowners insurance\nhotel-dealse-site\nhotele-site\nhotelse-site\nhydrocodone\nhydrocone\nhypersearcher\nidealpaydayloans\nifinancialzone\nillcom.\nincest\nincrediblesearch.\ninforeal07.\ninsurance-quotesdeals-4u\ninsurancedeals-4u\ninvestment-loans\nionamin\nirs-problems\njbakerstudios.\njrcreations\njrcreations.\nk74v78@yahoo.com\nkasino\nkenwoodexcelon\nland.ru\nlaserhairremovalhints\nlawyerhints\nlesbian\nlevitra\nlevitra.\nlexapro\nlife insurance\nlifeinsurancehints\nlipitor\nlisinopril\nlopressor\nlorazepam\nlunestra\nlung-cancer\nluxury-linen\nlyndawyllie.\nm2mvc.\nmacinstruct\nmadesukadana.\nmanicsearch\nmark336699@gmail.com\nmaryknollogc.org\nmayopr.com\nmeridia\nmightyslumlords.com\nmlmleads.name\nmohegan sun\nmortgage-4-u\nmortgage-certificates\nmortgagequotes\nmortgagerefinancingtoday.\nmusicfastfinder\nmycolorcontacts\nmydivx.\nnemasoft.\nnetfirms.\nnipple\nnude\nnysm.\nonline casino\nonline casino guide\nonline poker\nonline slots\nonline-casino\nonline-casinos\nonline-debt-consolidation\nonline-gambling\nonline-pharmacy\nonlinegambling-4u\norgasm\nottawavalleyag\nownsthis\noxycodone\noxycontin\np***y\npacific-poker\npalm-texas-holdem-game\nparmacy\nparty-poker\npaxil\npayday loan\npayday-loan\npayday-loans\npenis\npercocet\npersonal-loans\npest-control\npharmacy\nphentermine\nphentermine.\npills-best.\npills-home.\npimpdog@gmail.com\npizzareviewblog\nplatinum-celebs\npoker\npoker-chip\npoker-games\npoker-hands\npoker-online\nporn\npornstar\npornstars\nprescription\nprohosting.\npropecia\nprotonix\nprozac\npussy\nrakeback\nrealtorlist\nrealtorx2\nrefinance-san-diego\nrental-car-e-site\nringtone\nringtones\nromanedirisinghe\nroulette\nsearchingrobot.\nseethishome\nservegame.com\nservehttp.com\nservepics.com\nshaffelrecords.\nshemale\nsightstickysubmit\nskank\nslot-machine\nslotmachine\nslots\nsoma\nstudent-loans\nswingers-search.com\nt35.\ntaboo\ntenuate\nterm insurance quote\ntexas hold\'em\ntexas holdem\ntexas-hold-em-rules\ntexas-hold-em.\ntexas-holdem\nthorcarlson\ntigerspice\ntop-e-site\ntop-franchise\ntop-site\ntrablinka\ntramadol\ntrancetechno.\ntransexual\ntranssexual\ntredgf\ntrim-spa\nturbo-tax\nugly.as\nultram\nunited24.\nvaleofglamorganconservatives\nvalium\nvaltrex\nvaried-poker.\nvcats\nviagra\nviagra-online\nviagrabuy\nviagraonline\nvicodin\nvincedel422@gmail.com\nvioxx\nvmasterpiece\nvneighbor\nvoyeurism\nvpawnshop\nvselling\nvsymphony\nwebsamba.\nwhore\nwiu.edu\nworld-series-of-poker\nwowad\nwpdigger.com\nxanax\nxenical\nxrated\nxxx\nycba\nytmnsfw.com\nz411.\nzenegra\nzithromax\nzolus\nzyban', 'no'),
	(92, 'embed_size_h', '600', 'yes'),
	(91, 'embed_size_w', '', 'yes'),
	(1634, 'factory_plugin_versions', 'a:1:{s:12:"wbcr_clearfy";s:10:"free-1.5.3";}', 'yes'),
	(1457, 'fakerpress-plugin-options', 'a:1:{s:5:"500px";a:1:{s:3:"key";s:40:"UBHtxibZdthje2lI4Dai9urqiUrUTYMBqCbPCF4R";}}', 'yes'),
	(1042, 'finished_splitting_shared_terms', '1', 'yes'),
	(2001, 'finished_updating_comment_type', '1', 'yes'),
	(2013, 'fm_key', 'wJ5A2ogHFRNQyIOPY6Lsx9U1r', 'yes'),
	(1364, 'fresh_site', '0', 'yes'),
	(42, 'gmt_offset', '', 'yes'),
	(33, 'hack_file', '0', 'yes'),
	(97, 'hadpj_user_roles', 'a:5:{s:13:"administrator";a:2:{s:4:"name";s:13:"Administrator";s:12:"capabilities";a:66:{s:13:"switch_themes";b:1;s:11:"edit_themes";b:1;s:16:"activate_plugins";b:1;s:12:"edit_plugins";b:1;s:10:"edit_users";b:1;s:10:"edit_files";b:1;s:14:"manage_options";b:1;s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:6:"import";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:8:"level_10";b:1;s:7:"level_9";b:1;s:7:"level_8";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;s:12:"delete_users";b:1;s:12:"create_users";b:1;s:17:"unfiltered_upload";b:1;s:14:"edit_dashboard";b:1;s:14:"update_plugins";b:1;s:14:"delete_plugins";b:1;s:15:"install_plugins";b:1;s:13:"update_themes";b:1;s:14:"install_themes";b:1;s:11:"update_core";b:1;s:10:"list_users";b:1;s:12:"remove_users";b:1;s:13:"promote_users";b:1;s:18:"edit_theme_options";b:1;s:13:"delete_themes";b:1;s:6:"export";b:1;s:11:"run_adminer";b:1;s:23:"wf2fa_activate_2fa_self";b:1;s:25:"wf2fa_activate_2fa_others";b:1;s:21:"wf2fa_manage_settings";b:1;s:12:"cfdb7_access";b:1;}}s:6:"editor";a:2:{s:4:"name";s:6:"Editor";s:12:"capabilities";a:34:{s:17:"moderate_comments";b:1;s:17:"manage_categories";b:1;s:12:"manage_links";b:1;s:12:"upload_files";b:1;s:15:"unfiltered_html";b:1;s:10:"edit_posts";b:1;s:17:"edit_others_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:10:"edit_pages";b:1;s:4:"read";b:1;s:7:"level_7";b:1;s:7:"level_6";b:1;s:7:"level_5";b:1;s:7:"level_4";b:1;s:7:"level_3";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:17:"edit_others_pages";b:1;s:20:"edit_published_pages";b:1;s:13:"publish_pages";b:1;s:12:"delete_pages";b:1;s:19:"delete_others_pages";b:1;s:22:"delete_published_pages";b:1;s:12:"delete_posts";b:1;s:19:"delete_others_posts";b:1;s:22:"delete_published_posts";b:1;s:20:"delete_private_posts";b:1;s:18:"edit_private_posts";b:1;s:18:"read_private_posts";b:1;s:20:"delete_private_pages";b:1;s:18:"edit_private_pages";b:1;s:18:"read_private_pages";b:1;}}s:6:"author";a:2:{s:4:"name";s:6:"Author";s:12:"capabilities";a:10:{s:12:"upload_files";b:1;s:10:"edit_posts";b:1;s:20:"edit_published_posts";b:1;s:13:"publish_posts";b:1;s:4:"read";b:1;s:7:"level_2";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;s:22:"delete_published_posts";b:1;}}s:11:"contributor";a:2:{s:4:"name";s:11:"Contributor";s:12:"capabilities";a:5:{s:10:"edit_posts";b:1;s:4:"read";b:1;s:7:"level_1";b:1;s:7:"level_0";b:1;s:12:"delete_posts";b:1;}}s:10:"subscriber";a:2:{s:4:"name";s:10:"Subscriber";s:12:"capabilities";a:2:{s:4:"read";b:1;s:7:"level_0";b:1;}}}', 'yes'),
	(1463, 'hmbkp_notices', 'a:1:{s:13:"backup_errors";a:1:{i:0;s:210:"php: ZipArchive::close(): Renaming temporary file failed: Invalid argument, C:\\Users\\crazyyy\\wp-framework\\wordpress\\wp-content\\plugins\\backupwordpress\\classes\\backup\\class-backup-engine-file-zip-archive.php, 46";}}', 'yes'),
	(939, 'hmbkp_plugin_version', '3.6.4', 'yes'),
	(937, 'hmbkp_schedule_1434587998', 'a:7:{s:11:"max_backups";i:7;s:8:"excludes";a:0:{}s:4:"type";s:8:"database";s:12:"reoccurrence";s:5:"daily";s:19:"schedule_start_time";d:1434657600;s:14:"duration_total";d:4500117172;s:16:"backup_run_count";i:3;}', 'yes'),
	(37, 'home', 'http://wpeb.ddev.site', 'yes'),
	(2631, 'honeypot4cf7_config', 'a:12:{s:14:"store_honeypot";i:0;s:11:"placeholder";s:0:"";s:21:"accessibility_message";s:0:"";s:22:"w3c_valid_autocomplete";a:1:{i:0;s:5:"false";}s:15:"move_inline_css";a:1:{i:0;s:5:"false";}s:9:"nomessage";a:1:{i:0;s:5:"false";}s:17:"timecheck_enabled";a:1:{i:0;s:5:"false";}s:15:"timecheck_value";i:4;s:14:"honeypot_count";i:0;s:21:"honeypot_install_date";i:1694130764;s:30:"honeypot_cf7_req_msg_dismissed";i:0;s:20:"honeypot4cf7_version";s:5:"2.1.5";}', 'yes'),
	(50, 'html_type', 'text/html', 'yes'),
	(2005, 'https_detection_errors', 'a:1:{s:23:"ssl_verification_failed";a:1:{i:0;s:24:"SSL verification failed.";}}', 'yes'),
	(2670, 'httpsrdrctn_options', 'a:5:{s:5:"https";s:1:"1";s:12:"https_domain";s:1:"1";s:17:"https_pages_array";a:0:{}s:15:"force_resources";s:1:"1";s:21:"plugin_option_version";s:5:"1.9.2";}', 'yes'),
	(2627, 'ideastocode_module_settings', 'a:1:{s:14:"itc_svg_upload";a:5:{s:4:"name";s:14:"itc_svg_upload";s:5:"title";s:33:"Enable SVG, WebP &amp; ICO Upload";s:4:"slug";s:14:"itc-svg-upload";s:7:"version";s:5:"1.0.1";s:8:"settings";s:23:"itc_svg_upload_settings";}}', 'yes'),
	(75, 'image_default_align', '', 'yes'),
	(73, 'image_default_link_type', '', 'yes'),
	(74, 'image_default_size', '', 'yes'),
	(2639, 'ImfsPage', 'a:5:{s:12:"majorVersion";d:1.5;s:10:"wp_version";s:5:"6.6.2";s:13:"wp_db_version";i:57155;s:6:"backup";a:0:{}s:14:"plugin_version";s:5:"1.5.2";}', 'yes'),
	(2632, 'imfsQueryMonitor', '', 'yes'),
	(96, 'initial_db_version', '21707', 'yes'),
	(2628, 'itc_svg_upload_settings', 'a:3:{s:3:"svg";i:1;s:4:"webp";i:1;s:3:"ico";i:1;}', 'yes'),
	(72, 'large_size_h', '0', 'yes'),
	(71, 'large_size_w', '1600', 'yes'),
	(614, 'limit_login_allowed_lockouts', '4', 'yes'),
	(612, 'limit_login_allowed_retries', '4', 'yes'),
	(611, 'limit_login_client_type', 'REMOTE_ADDR', 'yes'),
	(619, 'limit_login_cookies', '1', 'yes'),
	(613, 'limit_login_lockout_duration', '1200', 'yes'),
	(617, 'limit_login_lockout_notify', 'log,email', 'yes'),
	(615, 'limit_login_long_duration', '86400', 'yes'),
	(618, 'limit_login_notify_email_after', '4', 'yes'),
	(616, 'limit_login_valid_duration', '43200', 'yes'),
	(404, 'link_manager_enabled', '0', 'yes'),
	(25, 'links_updated_date_format', 'd.m.Y H:i', 'yes'),
	(14, 'mailserver_login', 'login@example.com', 'yes'),
	(15, 'mailserver_pass', 'password', 'yes'),
	(16, 'mailserver_port', '110', 'yes'),
	(13, 'mailserver_url', 'mail.example.com', 'yes'),
	(1108, 'medium_large_size_h', '0', 'yes'),
	(1107, 'medium_large_size_w', '768', 'yes'),
	(67, 'medium_size_h', '0', 'yes'),
	(66, 'medium_size_w', '600', 'yes'),
	(35, 'moderation_keys', '', 'no'),
	(30, 'moderation_notify', '1', 'yes'),
	(2426, 'new_admin_email', 'crazyyy@gmail.com', 'yes'),
	(993, 'p3_notices', 'a:0:{}', 'yes'),
	(1004, 'p3_scan_', '{"url":"\\/wp-admin\\/admin-ajax.php","ip":"127.0.0.1","pid":10812,"date":"2015-06-18T00:47:06+00:00","theme_name":"D:\\\\Works\\\\Verstka\\\\wp-framework\\\\wordpress\\\\wp-content\\\\themes\\\\wp-framework\\\\functions.php","runtime":{"total":0.29789185523987,"wordpress":0.12375378608704,"theme":0.004298210144043,"plugins":0.089087724685669,"profile":0.073323011398315,"breakdown":{"p3-profiler":0.010924339294434,"all-in-one-wp-security-and-firewall":0.030353307723999,"cyr3lat":0.0012428760528564,"htm-on-pages":0.0047204494476318,"optimize-db":0.0011062622070312,"wordpress-seo":0.037757396697998,"wp-sxd":0.0029830932617188}},"memory":21757952,"stacksize":2366,"queries":23}\r\n', 'yes'),
	(80, 'page_comments', '', 'yes'),
	(93, 'page_for_posts', '0', 'yes'),
	(94, 'page_on_front', '0', 'yes'),
	(1717, 'pbsfi_options', '', 'yes'),
	(2997, 'perflab_generate_webp_and_jpeg', '1', 'auto'),
	(2996, 'perflab_modern_image_format', 'webp', 'auto'),
	(31, 'permalink_structure', '/%postname%/', 'yes'),
	(39, 'ping_sites', 'https://topicexchange.com/RPC2\nhttps://www.blogstreet.com/xrbin/xmlrpc.cgi\nhttps://bulkfeeds.net/rpc\nhttps://www.feedsubmitter.com\nhttps://blog.with2.net/ping.php\nhttps://www.pingerati.net\nhttps://blog.with2.net/ping.php\nhttps://topicexchange.com/RPC2\nhttps://bulkfeeds.net/rpc\nhttps://rpc.blogbuzzmachine.com/RPC2\nhttps://rpc.pingomatic.com/\nhttps://www.feedsubmitter.com/\nhttps://www.bitacoles.net/ping.php\nhttps://blogmatcher.com/u.php\nhttps://blogsearch.google.com/ping/RPC2\nhttps://xmlrpc.blogg.de/\nhttps://rpc.twingly.com/\nhttps://www.blogdigger.com/RPC2\nhttps://www.blogshares.com/rpc.php\nhttps://pingoat.com/goat/RPC2\nhttps://ping.blo.gs/\nhttps://www.weblogues.com/RPC/\nhttps://www.popdex.com/addsite.php\nhttps://www.blogoole.com/ping/\nhttps://www.blogoon.net/ping/\nhttps://coreblog.org/ping/', 'yes'),
	(22, 'posts_per_page', '10', 'yes'),
	(11, 'posts_per_rss', '10', 'yes'),
	(146, 'recently_activated', 'a:0:{}', 'yes'),
	(44, 'recently_edited', '', 'no'),
	(1752, 'recovery_keys', 'a:0:{}', 'yes'),
	(9, 'require_name_email', '1', 'yes'),
	(1909, 'rewrite_rules', 'a:93:{s:11:"^wp-json/?$";s:22:"index.php?rest_route=/";s:14:"^wp-json/(.*)?";s:33:"index.php?rest_route=/$matches[1]";s:21:"^index.php/wp-json/?$";s:22:"index.php?rest_route=/";s:24:"^index.php/wp-json/(.*)?";s:33:"index.php?rest_route=/$matches[1]";s:17:"^wp-sitemap\\.xml$";s:23:"index.php?sitemap=index";s:17:"^wp-sitemap\\.xsl$";s:36:"index.php?sitemap-stylesheet=sitemap";s:23:"^wp-sitemap-index\\.xsl$";s:34:"index.php?sitemap-stylesheet=index";s:48:"^wp-sitemap-([a-z]+?)-([a-z\\d_-]+?)-(\\d+?)\\.xml$";s:75:"index.php?sitemap=$matches[1]&sitemap-subtype=$matches[2]&paged=$matches[3]";s:34:"^wp-sitemap-([a-z]+?)-(\\d+?)\\.xml$";s:47:"index.php?sitemap=$matches[1]&paged=$matches[2]";s:47:"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?category_name=$matches[1]&feed=$matches[2]";s:42:"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$";s:52:"index.php?category_name=$matches[1]&feed=$matches[2]";s:23:"category/(.+?)/embed/?$";s:46:"index.php?category_name=$matches[1]&embed=true";s:35:"category/(.+?)/page/?([0-9]{1,})/?$";s:53:"index.php?category_name=$matches[1]&paged=$matches[2]";s:17:"category/(.+?)/?$";s:35:"index.php?category_name=$matches[1]";s:44:"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?tag=$matches[1]&feed=$matches[2]";s:39:"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?tag=$matches[1]&feed=$matches[2]";s:20:"tag/([^/]+)/embed/?$";s:36:"index.php?tag=$matches[1]&embed=true";s:32:"tag/([^/]+)/page/?([0-9]{1,})/?$";s:43:"index.php?tag=$matches[1]&paged=$matches[2]";s:14:"tag/([^/]+)/?$";s:25:"index.php?tag=$matches[1]";s:45:"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?post_format=$matches[1]&feed=$matches[2]";s:40:"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?post_format=$matches[1]&feed=$matches[2]";s:21:"type/([^/]+)/embed/?$";s:44:"index.php?post_format=$matches[1]&embed=true";s:33:"type/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?post_format=$matches[1]&paged=$matches[2]";s:15:"type/([^/]+)/?$";s:33:"index.php?post_format=$matches[1]";s:12:"robots\\.txt$";s:18:"index.php?robots=1";s:13:"favicon\\.ico$";s:19:"index.php?favicon=1";s:48:".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$";s:18:"index.php?feed=old";s:20:".*wp-app\\.php(/.*)?$";s:19:"index.php?error=403";s:18:".*wp-register.php$";s:23:"index.php?register=true";s:32:"feed/(feed|rdf|rss|rss2|atom)/?$";s:27:"index.php?&feed=$matches[1]";s:27:"(feed|rdf|rss|rss2|atom)/?$";s:27:"index.php?&feed=$matches[1]";s:8:"embed/?$";s:21:"index.php?&embed=true";s:20:"page/?([0-9]{1,})/?$";s:28:"index.php?&paged=$matches[1]";s:41:"comments/feed/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?&feed=$matches[1]&withcomments=1";s:36:"comments/(feed|rdf|rss|rss2|atom)/?$";s:42:"index.php?&feed=$matches[1]&withcomments=1";s:17:"comments/embed/?$";s:21:"index.php?&embed=true";s:44:"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:40:"index.php?s=$matches[1]&feed=$matches[2]";s:39:"search/(.+)/(feed|rdf|rss|rss2|atom)/?$";s:40:"index.php?s=$matches[1]&feed=$matches[2]";s:20:"search/(.+)/embed/?$";s:34:"index.php?s=$matches[1]&embed=true";s:32:"search/(.+)/page/?([0-9]{1,})/?$";s:41:"index.php?s=$matches[1]&paged=$matches[2]";s:14:"search/(.+)/?$";s:23:"index.php?s=$matches[1]";s:47:"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?author_name=$matches[1]&feed=$matches[2]";s:42:"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:50:"index.php?author_name=$matches[1]&feed=$matches[2]";s:23:"author/([^/]+)/embed/?$";s:44:"index.php?author_name=$matches[1]&embed=true";s:35:"author/([^/]+)/page/?([0-9]{1,})/?$";s:51:"index.php?author_name=$matches[1]&paged=$matches[2]";s:17:"author/([^/]+)/?$";s:33:"index.php?author_name=$matches[1]";s:69:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$";s:80:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]";s:64:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$";s:80:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]";s:45:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$";s:74:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true";s:57:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$";s:81:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]";s:39:"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$";s:63:"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]";s:56:"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$";s:64:"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]";s:51:"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$";s:64:"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]";s:32:"([0-9]{4})/([0-9]{1,2})/embed/?$";s:58:"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true";s:44:"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$";s:65:"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]";s:26:"([0-9]{4})/([0-9]{1,2})/?$";s:47:"index.php?year=$matches[1]&monthnum=$matches[2]";s:43:"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?year=$matches[1]&feed=$matches[2]";s:38:"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?year=$matches[1]&feed=$matches[2]";s:19:"([0-9]{4})/embed/?$";s:37:"index.php?year=$matches[1]&embed=true";s:31:"([0-9]{4})/page/?([0-9]{1,})/?$";s:44:"index.php?year=$matches[1]&paged=$matches[2]";s:13:"([0-9]{4})/?$";s:26:"index.php?year=$matches[1]";s:27:".?.+?/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:37:".?.+?/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:57:".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:33:".?.+?/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:16:"(.?.+?)/embed/?$";s:41:"index.php?pagename=$matches[1]&embed=true";s:20:"(.?.+?)/trackback/?$";s:35:"index.php?pagename=$matches[1]&tb=1";s:40:"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?pagename=$matches[1]&feed=$matches[2]";s:35:"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$";s:47:"index.php?pagename=$matches[1]&feed=$matches[2]";s:28:"(.?.+?)/page/?([0-9]{1,})/?$";s:48:"index.php?pagename=$matches[1]&paged=$matches[2]";s:35:"(.?.+?)/comment-page-([0-9]{1,})/?$";s:48:"index.php?pagename=$matches[1]&cpage=$matches[2]";s:24:"(.?.+?)(?:/([0-9]+))?/?$";s:47:"index.php?pagename=$matches[1]&page=$matches[2]";s:27:"[^/]+/attachment/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:37:"[^/]+/attachment/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:57:"[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:"[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:52:"[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:33:"[^/]+/attachment/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";s:16:"([^/]+)/embed/?$";s:37:"index.php?name=$matches[1]&embed=true";s:20:"([^/]+)/trackback/?$";s:31:"index.php?name=$matches[1]&tb=1";s:40:"([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?name=$matches[1]&feed=$matches[2]";s:35:"([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:43:"index.php?name=$matches[1]&feed=$matches[2]";s:28:"([^/]+)/page/?([0-9]{1,})/?$";s:44:"index.php?name=$matches[1]&paged=$matches[2]";s:35:"([^/]+)/comment-page-([0-9]{1,})/?$";s:44:"index.php?name=$matches[1]&cpage=$matches[2]";s:24:"([^/]+)(?:/([0-9]+))?/?$";s:43:"index.php?name=$matches[1]&page=$matches[2]";s:16:"[^/]+/([^/]+)/?$";s:32:"index.php?attachment=$matches[1]";s:26:"[^/]+/([^/]+)/trackback/?$";s:37:"index.php?attachment=$matches[1]&tb=1";s:46:"[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:41:"[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$";s:49:"index.php?attachment=$matches[1]&feed=$matches[2]";s:41:"[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$";s:50:"index.php?attachment=$matches[1]&cpage=$matches[2]";s:22:"[^/]+/([^/]+)/embed/?$";s:43:"index.php?attachment=$matches[1]&embed=true";}', 'yes'),
	(12, 'rss_use_excerpt', '1', 'yes'),
	(225, 'seo_friendly_images_alt', '%name %title', 'yes'),
	(231, 'seo_friendly_images_notice', '1', 'yes'),
	(227, 'seo_friendly_images_override', 'on', 'yes'),
	(228, 'seo_friendly_images_override_title', 'off', 'yes'),
	(226, 'seo_friendly_images_title', '%title', 'yes'),
	(60, 'show_avatars', '1', 'yes'),
	(1599, 'show_comments_cookies_opt_in', '1', 'yes'),
	(58, 'show_on_front', 'posts', 'yes'),
	(103, 'sidebars_widgets', 'a:4:{s:19:"wp_inactive_widgets";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}s:13:"widget-area-1";a:0:{}s:13:"widget-area-2";a:0:{}s:13:"array_version";i:3;}', 'yes'),
	(2410, 'simba_tfa_priv_key_format', '1', 'no'),
	(2636, 'simple_history_enable_rss_feed', '0', 'yes'),
	(2697, 'simplehistory_AvailableUpdatesLogger_plugin_updates_available', 'a:3:{s:34:"advanced-custom-fields-pro/acf.php";a:1:{s:15:"checked_version";s:7:"6.2.1.1";}s:53:"accelerated-mobile-pages/accelerated-moblie-pages.php";a:1:{s:15:"checked_version";s:6:"1.0.89";}s:35:"google-site-kit/google-site-kit.php";a:1:{s:15:"checked_version";s:7:"1.109.0";}}', 'yes'),
	(1106, 'site_icon', '0', 'yes'),
	(1, 'siteurl', 'http://wpeb.ddev.site', 'yes'),
	(248, 'sm_options', 'a:56:{s:18:"sm_b_prio_provider";s:41:"GoogleSitemapGeneratorPrioByCountProvider";s:13:"sm_b_filename";s:11:"sitemap.xml";s:10:"sm_b_debug";b:1;s:8:"sm_b_xml";b:1;s:9:"sm_b_gzip";b:1;s:9:"sm_b_ping";b:1;s:12:"sm_b_pingmsn";b:1;s:19:"sm_b_manual_enabled";b:0;s:17:"sm_b_auto_enabled";b:1;s:15:"sm_b_auto_delay";b:1;s:15:"sm_b_manual_key";s:32:"b96745ccc831ceb3a5d2bb594672a608";s:11:"sm_b_memory";s:0:"";s:9:"sm_b_time";i:-1;s:14:"sm_b_max_posts";i:-1;s:13:"sm_b_safemode";b:0;s:18:"sm_b_style_default";b:1;s:10:"sm_b_style";s:0:"";s:11:"sm_b_robots";b:1;s:12:"sm_b_exclude";a:0:{}s:17:"sm_b_exclude_cats";a:0:{}s:18:"sm_b_location_mode";s:4:"auto";s:20:"sm_b_filename_manual";s:0:"";s:19:"sm_b_fileurl_manual";s:0:"";s:10:"sm_in_home";b:1;s:11:"sm_in_posts";b:1;s:15:"sm_in_posts_sub";b:0;s:11:"sm_in_pages";b:1;s:10:"sm_in_cats";b:0;s:10:"sm_in_arch";b:0;s:10:"sm_in_auth";b:0;s:10:"sm_in_tags";b:0;s:9:"sm_in_tax";a:0:{}s:17:"sm_in_customtypes";a:0:{}s:13:"sm_in_lastmod";b:1;s:10:"sm_cf_home";s:5:"daily";s:11:"sm_cf_posts";s:7:"monthly";s:11:"sm_cf_pages";s:6:"weekly";s:10:"sm_cf_cats";s:6:"weekly";s:10:"sm_cf_auth";s:6:"weekly";s:15:"sm_cf_arch_curr";s:5:"daily";s:14:"sm_cf_arch_old";s:6:"yearly";s:10:"sm_cf_tags";s:6:"weekly";s:10:"sm_pr_home";d:1;s:11:"sm_pr_posts";d:0.6;s:15:"sm_pr_posts_min";d:0.2;s:11:"sm_pr_pages";d:0.6;s:10:"sm_pr_cats";d:0.3;s:10:"sm_pr_arch";d:0.3;s:10:"sm_pr_auth";d:0.3;s:10:"sm_pr_tags";d:0.3;s:12:"sm_i_donated";b:1;s:17:"sm_i_hide_donated";b:1;s:17:"sm_i_install_date";i:1352379707;s:14:"sm_i_hide_note";b:0;s:15:"sm_i_hide_works";b:0;s:16:"sm_i_hide_donors";b:0;}', 'yes'),
	(249, 'sm_status', 'O:28:"GoogleSitemapGeneratorStatus":24:{s:10:"_startTime";d:1395701243.7861459255218505859375;s:8:"_endTime";d:1395701244.278173923492431640625;s:11:"_hasChanged";b:1;s:12:"_memoryUsage";i:42729472;s:9:"_lastPost";i:0;s:9:"_lastTime";i:0;s:8:"_usedXml";b:1;s:11:"_xmlSuccess";b:1;s:8:"_xmlPath";s:50:"E:/myWorkUp/OpenServer/domains/wpeb.ddev.site/sitemap.xml";s:7:"_xmlUrl";s:26:"http://wpeb.ddev.site/sitemap.xml";s:8:"_usedZip";b:1;s:11:"_zipSuccess";b:1;s:8:"_zipPath";s:53:"E:/myWorkUp/OpenServer/domains/wpeb.ddev.site/sitemap.xml.gz";s:7:"_zipUrl";s:29:"http://wpeb.ddev.site/sitemap.xml.gz";s:11:"_usedGoogle";b:1;s:10:"_googleUrl";s:92:"http://www.google.com/webmasters/sitemaps/ping?sitemap=http%3A%2F%2Fwpeb.ddev.site%2Fsitemap.xml.gz";s:15:"_gooogleSuccess";b:1;s:16:"_googleStartTime";d:1395701243.806147098541259765625;s:14:"_googleEndTime";d:1395701244.0151588916778564453125;s:8:"_usedMsn";b:1;s:7:"_msnUrl";s:85:"http://www.bing.com/webmaster/ping.aspx?siteMap=http%3A%2F%2Fwpeb.ddev.site%2Fsitemap.xml.gz";s:11:"_msnSuccess";b:1;s:13:"_msnStartTime";d:1395701244.0191590785980224609375;s:11:"_msnEndTime";d:1395701244.2751729488372802734375;}', 'no'),
	(173, 'spamfree_count', '0', 'yes'),
	(6, 'start_of_week', '1', 'yes'),
	(84, 'sticky_posts', 'a:0:{}', 'yes'),
	(46, 'stylesheet', 'wp-wpeb', 'yes'),
	(59, 'tag_base', '/', 'yes'),
	(45, 'template', 'wp-wpeb', 'yes'),
	(411, 'theme_mods_twentyeleven', 'a:1:{s:16:"sidebars_widgets";a:2:{s:4:"time";i:1356130367;s:4:"data";a:6:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}s:9:"sidebar-2";a:0:{}s:9:"sidebar-3";a:0:{}s:9:"sidebar-4";a:0:{}s:9:"sidebar-5";a:0:{}}}}', 'no'),
	(790, 'theme_mods_twentyfifteen', 'a:2:{i:0;b:0;s:16:"sidebars_widgets";a:2:{s:4:"time";i:1428927025;s:4:"data";a:2:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}}}}', 'no'),
	(652, 'theme_mods_twentyfourteen', 'a:2:{i:0;b:0;s:16:"sidebars_widgets";a:2:{s:4:"time";i:1395701065;s:4:"data";a:4:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}s:9:"sidebar-2";a:0:{}s:9:"sidebar-3";N;}}}', 'no'),
	(511, 'theme_mods_twentythirteen', 'a:2:{i:0;b:0;s:16:"sidebars_widgets";a:2:{s:4:"time";i:1383778597;s:4:"data";a:3:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}s:9:"sidebar-2";a:0:{}}}}', 'no'),
	(413, 'theme_mods_twentytwelve', 'a:2:{i:0;b:0;s:16:"sidebars_widgets";a:2:{s:4:"time";i:1383775628;s:4:"data";a:4:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}s:9:"sidebar-2";a:0:{}s:9:"sidebar-3";a:0:{}}}}', 'no'),
	(2955, 'theme_mods_twentytwentyfour', 'a:4:{i:0;b:0;s:19:"wp_classic_sidebars";a:0:{}s:18:"nav_menu_locations";a:0:{}s:16:"sidebars_widgets";a:2:{s:4:"time";i:1719988365;s:4:"data";a:1:{s:19:"wp_inactive_widgets";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}}}}', 'no'),
	(2007, 'theme_mods_twentytwentyone', 'a:4:{i:0;b:0;s:18:"nav_menu_locations";a:0:{}s:18:"custom_css_post_id";i:-1;s:16:"sidebars_widgets";a:2:{s:4:"time";i:1694130992;s:4:"data";a:2:{s:19:"wp_inactive_widgets";a:0:{}s:9:"sidebar-1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}}}}', 'no'),
	(529, 'theme_mods_wp-blanck', 'a:2:{i:0;b:0;s:16:"sidebars_widgets";a:2:{s:4:"time";i:1395701006;s:4:"data";a:3:{s:19:"wp_inactive_widgets";a:0:{}s:13:"widget-area-1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}s:13:"widget-area-2";a:0:{}}}}', 'no'),
	(657, 'theme_mods_wp-easy-master', 'a:2:{i:0;b:0;s:16:"sidebars_widgets";a:2:{s:4:"time";i:1422713825;s:4:"data";a:2:{s:19:"wp_inactive_widgets";a:0:{}s:11:"widgetArea1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}}}}', 'no'),
	(835, 'theme_mods_wp-framework', 'a:4:{i:0;b:0;s:18:"custom_css_post_id";i:-1;s:16:"sidebars_widgets";a:2:{s:4:"time";i:1719988361;s:4:"data";a:4:{s:19:"wp_inactive_widgets";a:0:{}s:13:"widget-area-1";a:0:{}s:13:"widget-area-2";a:0:{}s:11:"widgetarea1";a:6:{i:0;s:8:"search-2";i:1;s:14:"recent-posts-2";i:2;s:17:"recent-comments-2";i:3;s:10:"archives-2";i:4;s:12:"categories-2";i:5;s:6:"meta-2";}}}s:18:"nav_menu_locations";a:0:{}}', 'no'),
	(2961, 'theme_mods_wp-wpeb', 'a:3:{i:0;b:0;s:18:"nav_menu_locations";a:0:{}s:18:"custom_css_post_id";i:-1;}', 'yes'),
	(414, 'theme_switched', '', 'yes'),
	(78, 'thread_comments', '1', 'yes'),
	(79, 'thread_comments_depth', '5', 'yes'),
	(65, 'thumbnail_crop', '1', 'yes'),
	(64, 'thumbnail_size_h', '300', 'yes'),
	(63, 'thumbnail_size_w', '300', 'yes'),
	(24, 'time_format', 'H:i', 'yes'),
	(89, 'timezone_string', 'Europe/Kiev', 'yes'),
	(88, 'uninstall_plugins', 'a:14:{s:45:"branded-login-screen/branded-login-screen.php";a:2:{i:0;s:20:"Branded_Login_Screen";i:1;s:9:"uninstall";}s:23:"antivirus/antivirus.php";a:2:{i:0;s:9:"AntiVirus";i:1;s:9:"uninstall";}s:29:"antispam-bee/antispam_bee.php";a:2:{i:0;s:12:"Antispam_Bee";i:1;s:9:"uninstall";}s:41:"better-wp-security/better-wp-security.php";a:2:{i:0;s:10:"ITSEC_Core";i:1;s:12:"on_uninstall";}s:33:"classic-editor/classic-editor.php";a:2:{i:0;s:14:"Classic_Editor";i:1;s:9:"uninstall";}s:49:"advanced-database-cleaner/advanced-db-cleaner.php";s:14:"aDBc_uninstall";s:49:"pb-seo-friendly-images/pb-seo-friendly-images.php";a:2:{i:0;s:19:"pbSEOFriendlyImages";i:1;s:9:"uninstall";}s:51:"all-in-one-wp-security-and-firewall/wp-security.php";a:2:{i:0;s:15:"AIO_WP_Security";i:1;s:17:"uninstall_handler";}s:27:"wp-optimize/wp-optimize.php";a:2:{i:0;s:13:"WPO_Uninstall";i:1;s:7:"actions";}s:53:"advanced-database-cleaner-pro/advanced-db-cleaner.php";a:2:{i:0;s:28:"ADBC_Advanced_DB_Cleaner_Pro";i:1;s:14:"aDBc_uninstall";}s:39:"https-redirection/https-redirection.php";s:26:"httpsrdrctn_delete_options";s:36:"contact-form-7-honeypot/honeypot.php";s:22:"honeypot4cf7_uninstall";s:33:"wp-performance/wp-performance.php";s:13:"wpp_uninstall";s:29:"webp-express/webp-express.php";a:2:{i:0;s:28:"\\WebPExpress\\PluginUninstall";i:1;s:9:"uninstall";}}', 'no'),
	(2028, 'updraft_last_lock_time_wpo_cache_preloader_creating_tasks', '2021-07-15 09:33:16', 'no'),
	(2935, 'updraft_lock_wpo_minify_preloader_creating_tasks', '0', 'no'),
	(2933, 'updraft_lock_wpo_page_cache_preloader_creating_tasks', '0', 'no'),
	(2029, 'updraft_semaphore_wpo_cache_preloader_creating_tasks', '0', 'no'),
	(2929, 'updraft_task_manager_dbversion', '1.1', 'yes'),
	(2928, 'updraft_task_manager_plugins', 'a:1:{i:0;s:27:"wp-optimize/wp-optimize.php";}', 'yes'),
	(2027, 'updraft_unlocked_wpo_cache_preloader_creating_tasks', '1', 'no'),
	(55, 'upload_path', '', 'yes'),
	(62, 'upload_url_path', '', 'yes'),
	(54, 'uploads_use_yearmonth_folders', '1', 'yes'),
	(7, 'use_balanceTags', '', 'yes'),
	(8, 'use_smilies', '1', 'yes'),
	(51, 'use_trackback', '0', 'yes'),
	(2194, 'user_count', '2', 'no'),
	(4, 'users_can_register', '0', 'yes'),
	(1665, 'wbcr_clearfy_change_login_errors', '1', 'yes'),
	(1675, 'wbcr_clearfy_disable_dashicons', '0', 'yes'),
	(1672, 'wbcr_clearfy_disable_embeds', '0', 'yes'),
	(1652, 'wbcr_clearfy_disable_emoji', '1', 'yes'),
	(1668, 'wbcr_clearfy_disable_feed', '0', 'yes'),
	(1693, 'wbcr_clearfy_disable_google_fonts', '0', 'yes'),
	(1694, 'wbcr_clearfy_disable_google_maps', '0', 'yes'),
	(1676, 'wbcr_clearfy_disable_gravatars', '0', 'yes'),
	(1681, 'wbcr_clearfy_disable_heartbeat', 'default', 'yes'),
	(1670, 'wbcr_clearfy_disable_json_rest_api', '0', 'yes'),
	(1669, 'wbcr_clearfy_disabled_feed_behaviour', 'redirect_301', 'yes'),
	(1687, 'wbcr_clearfy_ga_adjusted_bounce_rate', '0', 'yes'),
	(1690, 'wbcr_clearfy_ga_anonymize_ip', '0', 'yes'),
	(1684, 'wbcr_clearfy_ga_cache', '0', 'yes'),
	(1688, 'wbcr_clearfy_ga_enqueue_order', '0', 'yes'),
	(1686, 'wbcr_clearfy_ga_script_position', 'footer', 'yes'),
	(1691, 'wbcr_clearfy_ga_track_admin', '0', 'yes'),
	(1685, 'wbcr_clearfy_ga_tracking_id', '', 'yes'),
	(1679, 'wbcr_clearfy_gutenberg_autosave_control', '0', 'yes'),
	(1682, 'wbcr_clearfy_heartbeat_frequency', 'default', 'yes'),
	(1674, 'wbcr_clearfy_lazy_load_font_awesome', '0', 'yes'),
	(1692, 'wbcr_clearfy_lazy_load_google_fonts', '1', 'yes'),
	(1633, 'wbcr_clearfy_plugin_activated', '1567753579', 'yes'),
	(1664, 'wbcr_clearfy_protect_author_get', '1', 'yes'),
	(1656, 'wbcr_clearfy_remove_adjacent_posts_link', '1', 'yes'),
	(1695, 'wbcr_clearfy_remove_iframe_google_maps', '0', 'yes'),
	(1671, 'wbcr_clearfy_remove_jquery_migrate', '1', 'yes'),
	(1662, 'wbcr_clearfy_remove_js_version', '1', 'yes'),
	(1660, 'wbcr_clearfy_remove_meta_generator', '1', 'yes'),
	(1657, 'wbcr_clearfy_remove_recent_comments_style', '1', 'yes'),
	(1653, 'wbcr_clearfy_remove_rsd_link', '1', 'yes'),
	(1655, 'wbcr_clearfy_remove_shortlink_link', '1', 'yes'),
	(1661, 'wbcr_clearfy_remove_style_version', '1', 'yes'),
	(1680, 'wbcr_clearfy_remove_version_exclude', '', 'yes'),
	(1654, 'wbcr_clearfy_remove_wlw_link', '1', 'yes'),
	(1673, 'wbcr_clearfy_remove_xfn_link', '0', 'yes'),
	(1678, 'wbcr_clearfy_revision_limit', 'default', 'yes'),
	(1677, 'wbcr_clearfy_revisions_disable', '0', 'yes'),
	(2998, 'webp_uploads_use_picture_element', '1', 'auto'),
	(2444, 'wf_plugin_act_error', '', 'yes'),
	(531, 'wfb_contact_methods', 'a:2:{i:0;s:3:"aim";i:1;s:3:"yim";}', 'yes'),
	(532, 'wfb_update_notification', '1', 'yes'),
	(2439, 'wfls_last_role_change', '1688175523', 'no'),
	(1781, 'widget_akismet_widget', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
	(101, 'widget_archives', 'a:2:{i:2;a:3:{s:5:"title";s:0:"";s:5:"count";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}', 'yes'),
	(2065, 'widget_block', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
	(1009, 'widget_calendar', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
	(85, 'widget_categories', 'a:2:{i:2;a:4:{s:5:"title";s:0:"";s:5:"count";i:0;s:12:"hierarchical";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}', 'yes'),
	(1420, 'widget_custom_html', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
	(1346, 'widget_media_audio', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
	(1532, 'widget_media_gallery', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
	(1347, 'widget_media_image', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
	(1348, 'widget_media_video', 'a:1:{s:12:"_multiwidget";i:1;}', 'yes'),
	(102, 'widget_meta', 'a:2:{i:2;a:1:{s:5:"title";s:0:"";}s:12:"_multiwidget";i:1;}', 'yes'),
	(1011, 'widget_nav_menu', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
	(1012, 'widget_pages', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
	(100, 'widget_recent-comments', 'a:2:{i:2;a:2:{s:5:"title";s:0:"";s:6:"number";i:5;}s:12:"_multiwidget";i:1;}', 'yes'),
	(99, 'widget_recent-posts', 'a:2:{i:2;a:2:{s:5:"title";s:0:"";s:6:"number";i:5;}s:12:"_multiwidget";i:1;}', 'yes'),
	(87, 'widget_rss', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
	(98, 'widget_search', 'a:2:{i:2;a:1:{s:5:"title";s:0:"";}s:12:"_multiwidget";i:1;}', 'yes'),
	(1010, 'widget_tag_cloud', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
	(86, 'widget_text', 'a:2:{i:1;a:0:{}s:12:"_multiwidget";i:1;}', 'yes'),
	(2441, 'wordfence_case', '', 'yes'),
	(2442, 'wordfence_installed', '1', 'yes'),
	(2440, 'wordfence_version', '7.10.0', 'yes'),
	(2443, 'wordfenceActivated', '0', 'yes'),
	(2891, 'wp_attachment_pages_enabled', '1', 'yes'),
	(2068, 'wp_force_deactivated_plugins', 'a:0:{}', 'yes'),
	(1598, 'wp_page_for_privacy_policy', '0', 'yes'),
	(172, 'wp_spamfree_version', '2.1.1.2', 'yes'),
	(1815, 'wp-optimize-auto', 'a:7:{s:6:"drafts";s:4:"true";s:8:"optimize";s:5:"false";s:9:"revisions";s:4:"true";s:5:"spams";s:4:"true";s:9:"transient";s:5:"false";s:5:"trash";s:4:"true";s:10:"unapproved";s:5:"false";}', 'yes'),
	(1822, 'wp-optimize-back_up_original', '1', 'yes'),
	(1820, 'wp-optimize-compression_server', 'resmushit', 'yes'),
	(1819, 'wp-optimize-corrupted-tables-count', '0', 'yes'),
	(1824, 'wp-optimize-dismiss_notice', '1575017480', 'yes'),
	(1813, 'wp-optimize-enable-admin-menu', 'false', 'yes'),
	(1466, 'wp-optimize-enable-auto-backup', 'false', 'yes'),
	(1821, 'wp-optimize-image_quality', 'very_good', 'yes'),
	(2944, 'wp-optimize-install-or-update-notice-version', '1.1', 'yes'),
	(2023, 'wp-optimize-installed-for', '1626341590', 'yes'),
	(2934, 'wp-optimize-is_gzip_compression_enabled', 'gzip', 'yes'),
	(1809, 'wp-optimize-last-optimized', 'Never', 'yes'),
	(1811, 'wp-optimize-retention-enabled', 'false', 'yes'),
	(1812, 'wp-optimize-retention-period', '2', 'yes'),
	(1808, 'wp-optimize-schedule', 'false', 'yes'),
	(1810, 'wp-optimize-schedule-type', 'wpo_weekly', 'yes'),
	(1816, 'wp-optimize-settings', 'a:13:{s:10:"user-spams";s:4:"true";s:15:"user-unapproved";s:4:"true";s:15:"user-orphandata";s:4:"true";s:11:"user-drafts";s:4:"true";s:14:"user-transient";s:4:"true";s:13:"user-postmeta";s:4:"true";s:15:"user-trackbacks";s:4:"true";s:14:"user-revisions";s:4:"true";s:13:"user-optimize";s:4:"true";s:14:"user-pingbacks";s:4:"true";s:10:"user-trash";s:4:"true";s:16:"user-commentmeta";s:4:"true";s:13:"last_saved_in";s:6:"3.1.11";}', 'yes'),
	(1814, 'wp-optimize-total-cleaned', '644320', 'yes'),
	(1901, 'wpcf7', 'a:2:{s:7:"version";s:5:"5.9.8";s:13:"bulk_validate";a:4:{s:9:"timestamp";i:1719987513;s:7:"version";s:5:"5.9.6";s:11:"count_valid";i:1;s:13:"count_invalid";i:0;}}', 'yes'),
	(776, 'WPLANG', '', 'yes'),
	(1825, 'wpo_cache_config', 'a:24:{s:19:"enable_page_caching";b:0;s:23:"page_cache_length_value";i:24;s:22:"page_cache_length_unit";s:5:"hours";s:17:"page_cache_length";i:86400;s:32:"cache_exception_conditional_tags";a:0:{}s:20:"cache_exception_urls";a:0:{}s:23:"cache_exception_cookies";a:0:{}s:30:"cache_exception_browser_agents";a:0:{}s:22:"enable_sitemap_preload";b:0;s:23:"enable_schedule_preload";b:0;s:21:"preload_schedule_type";s:0:"";s:21:"enable_mobile_caching";b:0;s:19:"enable_user_caching";b:0;s:8:"site_url";s:23:"https://wpeb.ddev.site/";s:24:"enable_cache_per_country";b:0;s:19:"permalink_structure";s:12:"/%postname%/";s:7:"uploads";s:32:"/var/www/html/wp-content/uploads";s:10:"gmt_offset";d:3;s:15:"timezone_string";s:11:"Europe/Kiev";s:11:"date_format";s:5:"d.m.Y";s:11:"time_format";s:3:"H:i";s:15:"use_webp_images";b:0;s:17:"wpo_cache_cookies";a:0:{}s:25:"wpo_cache_query_variables";a:0:{}}', 'yes'),
	(2024, 'wpo_minify_config', 'a:52:{s:5:"debug";b:0;s:19:"enabled_css_preload";b:0;s:18:"enabled_js_preload";b:0;s:11:"hpreconnect";s:0:"";s:8:"hpreload";s:0:"";s:7:"loadcss";b:0;s:10:"remove_css";b:0;s:17:"critical_path_css";s:0:"";s:31:"critical_path_css_is_front_page";s:0:"";s:30:"preserve_settings_on_uninstall";b:1;s:22:"disable_when_logged_in";b:0;s:16:"default_protocol";s:7:"dynamic";s:17:"html_minification";b:1;s:16:"clean_header_one";b:0;s:13:"emoji_removal";b:1;s:18:"merge_google_fonts";b:1;s:19:"enable_display_swap";b:1;s:18:"remove_googlefonts";b:0;s:13:"gfonts_method";s:6:"inline";s:15:"fawesome_method";s:7:"inherit";s:10:"enable_css";b:1;s:23:"enable_css_minification";b:1;s:21:"enable_merging_of_css";b:1;s:23:"remove_print_mediatypes";b:0;s:10:"inline_css";b:0;s:9:"enable_js";b:1;s:22:"enable_js_minification";b:1;s:20:"enable_merging_of_js";b:1;s:15:"enable_defer_js";s:10:"individual";s:13:"defer_js_type";s:5:"defer";s:12:"defer_jquery";b:1;s:18:"enable_js_trycatch";b:0;s:19:"exclude_defer_login";b:1;s:7:"cdn_url";s:0:"";s:9:"cdn_force";b:0;s:9:"async_css";s:0:"";s:8:"async_js";s:0:"";s:24:"disable_css_inline_merge";b:1;s:6:"ualist";a:5:{i:0;s:9:"Googlebot";i:1;s:17:"Chrome-Lighthouse";i:2;s:8:"GTmetrix";i:3;s:14:"HeadlessChrome";i:4;s:7:"Pingdom";}s:32:"exclude_js_from_page_speed_tools";b:0;s:33:"exclude_css_from_page_speed_tools";b:0;s:9:"blacklist";a:0:{}s:11:"ignore_list";a:0:{}s:10:"exclude_js";s:0:"";s:11:"exclude_css";s:0:"";s:23:"edit_default_exclutions";b:0;s:18:"merge_allowed_urls";s:0:"";s:7:"enabled";b:0;s:17:"last-cache-update";i:1719987173;s:14:"plugin_version";s:5:"0.0.0";s:14:"cache_lifespan";i:30;s:25:"merge_inline_extra_css_js";b:1;}', 'yes'),
	(1904, 'wpo_update_version', '3.4.1', 'yes'),
	(2730, 'wpp_browser_cache', '', 'yes'),
	(2721, 'wpp_cache', '', 'yes'),
	(2723, 'wpp_cache_length', '3600', 'yes'),
	(2722, 'wpp_cache_time', '10', 'yes'),
	(2729, 'wpp_cache_url_exclude', '', 'yes'),
	(2786, 'wpp_cdn', '', 'yes'),
	(2788, 'wpp_cdn_exclude', '', 'yes'),
	(2787, 'wpp_cdn_hostname', '', 'yes'),
	(2797, 'wpp_cf_enabled', '', 'yes'),
	(2728, 'wpp_clear_assets', '', 'yes'),
	(2718, 'wpp_critical_css_list', 'a:5:{i:0;s:44:"wp-includes/css/dist/block-library/style.css";i:1;s:57:"wp-content/plugins/contact-form-7/includes/css/styles.css";i:2;s:48:"wp-includes/css/dist/block-library/style.min.css";i:3;s:43:"wp-includes/blocks/navigation/style.min.css";i:4;s:38:"wp-includes/blocks/image/style.min.css";}', 'yes'),
	(2745, 'wpp_css_combine', '', 'yes'),
	(2754, 'wpp_css_combine_fonts', '', 'yes'),
	(2751, 'wpp_css_defer', '', 'yes'),
	(2747, 'wpp_css_disable', '', 'yes'),
	(2750, 'wpp_css_disable_except', '', 'yes'),
	(2759, 'wpp_css_disable_loggedin', '', 'yes'),
	(2748, 'wpp_css_disable_position', '', 'yes'),
	(2749, 'wpp_css_disable_selected', '', 'yes'),
	(2757, 'wpp_css_file_exclude', '', 'yes'),
	(2755, 'wpp_css_font_display', '', 'yes'),
	(2746, 'wpp_css_inline', '', 'yes'),
	(2743, 'wpp_css_minify', '', 'yes'),
	(2744, 'wpp_css_minify_inline', '', 'yes'),
	(2753, 'wpp_css_preconnect', '', 'yes'),
	(2752, 'wpp_css_prefetch', '', 'yes'),
	(2756, 'wpp_css_url_exclude', '', 'yes'),
	(2796, 'wpp_current_settings', '1694813686', 'yes'),
	(2794, 'wpp_db_cleanup_autodrafts', '', 'yes'),
	(2793, 'wpp_db_cleanup_cron', '', 'yes'),
	(2795, 'wpp_db_cleanup_frequency', 'none', 'yes'),
	(2790, 'wpp_db_cleanup_revisions', '', 'yes'),
	(2791, 'wpp_db_cleanup_spam', '', 'yes'),
	(2789, 'wpp_db_cleanup_transients', '', 'yes'),
	(2792, 'wpp_db_cleanup_trash', '', 'yes'),
	(2726, 'wpp_delete_clear', '', 'yes'),
	(2784, 'wpp_disable_embeds', '', 'yes'),
	(2783, 'wpp_disable_emoji', '', 'yes'),
	(2777, 'wpp_disable_lazy_mobile', '', 'yes'),
	(2785, 'wpp_enable_log', '1', 'yes'),
	(2968, 'wpp_external_js_list', 'a:1:{i:0;s:65:"//cdn.jsdelivr.net/npm/modernizr@3.12.0/lib/cli.min.js?ver=3.12.0";}', 'yes'),
	(2731, 'wpp_gzip_compression', '', 'yes'),
	(2737, 'wpp_html_minify_aggressive', '', 'yes'),
	(2736, 'wpp_html_minify_normal', '', 'yes'),
	(2735, 'wpp_html_optimization', '', 'yes'),
	(2738, 'wpp_html_remove_comments', '', 'yes'),
	(2739, 'wpp_html_remove_link_type', '', 'yes'),
	(2741, 'wpp_html_remove_qoutes', '', 'yes'),
	(2740, 'wpp_html_remove_script_type', '', 'yes'),
	(2742, 'wpp_html_url_exclude', '', 'yes'),
	(2780, 'wpp_image_url_exclude', '', 'yes'),
	(2778, 'wpp_images_containers_ids', '', 'yes'),
	(2779, 'wpp_images_exclude', '', 'yes'),
	(2775, 'wpp_images_force', '', 'yes'),
	(2776, 'wpp_images_lazy', '', 'yes'),
	(2774, 'wpp_images_resp', '', 'yes'),
	(2762, 'wpp_js_combine', '', 'yes'),
	(2764, 'wpp_js_defer', '', 'yes'),
	(2768, 'wpp_js_disable', '', 'yes'),
	(2771, 'wpp_js_disable_except', '', 'yes'),
	(2773, 'wpp_js_disable_loggedin', '', 'yes'),
	(2769, 'wpp_js_disable_position', '', 'yes'),
	(2770, 'wpp_js_disable_selected', '', 'yes'),
	(2772, 'wpp_js_file_exclude', '', 'yes'),
	(2763, 'wpp_js_inline', '', 'yes'),
	(2760, 'wpp_js_minify', '', 'yes'),
	(2761, 'wpp_js_minify_inline', '', 'yes'),
	(2766, 'wpp_js_preconnect', '', 'yes'),
	(2765, 'wpp_js_prefetch', '', 'yes'),
	(2767, 'wpp_js_url_exclude', '', 'yes'),
	(2727, 'wpp_mobile_cache', '', 'yes'),
	(2966, 'wpp_plugin_css_list', 'a:1:{i:0;s:57:"wp-content/plugins/contact-form-7/includes/css/styles.css";}', 'yes'),
	(2967, 'wpp_plugin_js_list', 'a:2:{i:0;s:58:"wp-content/plugins/contact-form-7/includes/swv/js/index.js";i:1;s:54:"wp-content/plugins/contact-form-7/includes/js/index.js";}', 'yes'),
	(2969, 'wpp_prefetch_js_list', 'a:1:{i:0;s:16:"cdn.jsdelivr.net";}', 'yes'),
	(2798, 'wpp_prefetch_pages', '', 'yes'),
	(2725, 'wpp_save_clear', '', 'yes'),
	(2734, 'wpp_search_bots_exclude', '', 'yes'),
	(2732, 'wpp_sitemaps_list', '', 'yes'),
	(2964, 'wpp_theme_css_list', 'a:1:{i:0;s:48:"wp-includes/css/dist/block-library/style.min.css";}', 'yes'),
	(2965, 'wpp_theme_js_list', 'a:2:{i:0;s:35:"wp-includes/js/jquery/jquery.min.js";i:1;s:43:"wp-includes/js/jquery/jquery-migrate.min.js";}', 'yes'),
	(2724, 'wpp_update_clear', '', 'yes'),
	(2733, 'wpp_user_agents_exclude', '', 'yes'),
	(2799, 'wpp_varnish_auto_purge', '', 'yes'),
	(2800, 'wpp_varnish_custom_host', '', 'yes'),
	(2782, 'wpp_video_url_exclude', '', 'yes'),
	(2781, 'wpp_videos_lazy', '', 'yes'),
	(175, 'wpseo', 'a:20:{s:15:"ms_defaults_set";b:0;s:7:"version";s:6:"12.9.1";s:20:"disableadvanced_meta";b:0;s:19:"onpage_indexability";b:1;s:11:"baiduverify";s:0:"";s:12:"googleverify";s:0:"";s:8:"msverify";s:0:"";s:12:"yandexverify";s:0:"";s:9:"site_type";s:0:"";s:20:"has_multiple_authors";s:0:"";s:16:"environment_type";s:0:"";s:23:"content_analysis_active";b:1;s:23:"keyword_analysis_active";b:1;s:21:"enable_admin_bar_menu";b:1;s:26:"enable_cornerstone_content";b:1;s:18:"enable_xml_sitemap";b:1;s:24:"enable_text_link_counter";b:1;s:22:"show_onboarding_notice";b:0;s:18:"first_activated_on";i:1507015975;s:13:"myyoast-oauth";b:0;}', 'yes'),
	(1751, 'wpseo_onpage', 'a:2:{s:6:"status";i:-1;s:10:"last_fetch";i:1580740591;}', 'yes'),
	(178, 'wpseo_social', 'a:19:{s:13:"facebook_site";s:0:"";s:13:"instagram_url";s:0:"";s:12:"linkedin_url";s:0:"";s:11:"myspace_url";s:0:"";s:16:"og_default_image";s:0:"";s:19:"og_default_image_id";s:0:"";s:18:"og_frontpage_title";s:0:"";s:17:"og_frontpage_desc";s:0:"";s:18:"og_frontpage_image";s:0:"";s:21:"og_frontpage_image_id";s:0:"";s:9:"opengraph";b:1;s:13:"pinterest_url";s:0:"";s:15:"pinterestverify";s:0:"";s:7:"twitter";b:1;s:12:"twitter_site";s:0:"";s:17:"twitter_card_type";s:19:"summary_large_image";s:11:"youtube_url";s:0:"";s:13:"wikipedia_url";s:0:"";s:10:"fbadminapp";s:0:"";}', 'yes'),
	(193, 'wpseo_taxonomy_meta', 'a:1:{s:13:"link_category";a:1:{i:2;a:1:{s:13:"wpseo_noindex";s:7:"noindex";}}}', 'yes'),
	(176, 'wpseo_titles', 'a:74:{s:10:"title_test";i:0;s:17:"forcerewritetitle";b:0;s:9:"separator";s:7:"sc-dash";s:16:"title-home-wpseo";s:42:"%%sitename%% %%page%% %%sep%% %%sitedesc%%";s:18:"title-author-wpseo";s:30:"%%name%%,%%sitename%% %%page%%";s:19:"title-archive-wpseo";s:38:"%%date%% %%page%% %%sep%% %%sitename%%";s:18:"title-search-wpseo";s:64:"Вы искали %%searchphrase%% %%page%% %%sep%% %%sitename%%";s:15:"title-404-wpseo";s:57:"Страница не найдена %%sep%% %%sitename%%";s:19:"metadesc-home-wpseo";s:11:"%%excerpt%%";s:21:"metadesc-author-wpseo";s:24:"%%excerpt%% %%sitename%%";s:22:"metadesc-archive-wpseo";s:24:"%%excerpt%% %%sitename%%";s:9:"rssbefore";s:0:"";s:8:"rssafter";s:73:"Запись %%POSTLINK%% впервые появилась %%BLOGLINK%%.";s:20:"noindex-author-wpseo";b:1;s:28:"noindex-author-noposts-wpseo";b:1;s:21:"noindex-archive-wpseo";b:1;s:14:"disable-author";b:1;s:12:"disable-date";b:1;s:19:"disable-post_format";b:0;s:18:"disable-attachment";b:1;s:23:"is-media-purge-relevant";b:0;s:20:"breadcrumbs-404crumb";s:0:"";s:29:"breadcrumbs-display-blog-page";b:0;s:20:"breadcrumbs-boldlast";b:0;s:25:"breadcrumbs-archiveprefix";s:0:"";s:18:"breadcrumbs-enable";b:0;s:16:"breadcrumbs-home";s:0:"";s:18:"breadcrumbs-prefix";s:0:"";s:24:"breadcrumbs-searchprefix";s:0:"";s:15:"breadcrumbs-sep";s:2:"»";s:12:"website_name";s:0:"";s:11:"person_name";s:0:"";s:11:"person_logo";s:0:"";s:14:"person_logo_id";i:0;s:22:"alternate_website_name";s:0:"";s:12:"company_logo";s:0:"";s:15:"company_logo_id";i:0;s:12:"company_name";s:0:"";s:17:"company_or_person";s:7:"company";s:25:"company_or_person_user_id";b:0;s:17:"stripcategorybase";b:1;s:10:"title-post";s:39:"%%title%% %%page%% %%sep%% %%sitename%%";s:13:"metadesc-post";s:11:"%%excerpt%%";s:12:"noindex-post";b:0;s:13:"showdate-post";b:1;s:23:"display-metabox-pt-post";b:1;s:23:"post_types-post-maintax";i:0;s:10:"title-page";s:39:"%%title%% %%page%% %%sep%% %%sitename%%";s:13:"metadesc-page";s:11:"%%excerpt%%";s:12:"noindex-page";b:0;s:13:"showdate-page";b:1;s:23:"display-metabox-pt-page";b:1;s:23:"post_types-page-maintax";i:0;s:16:"title-attachment";s:39:"%%title%% %%page%% %%sep%% %%sitename%%";s:19:"metadesc-attachment";s:0:"";s:18:"noindex-attachment";b:0;s:19:"showdate-attachment";b:0;s:29:"display-metabox-pt-attachment";b:1;s:29:"post_types-attachment-maintax";i:0;s:18:"title-tax-category";s:44:"%%term_title%% %%page%% %%sep%% %%sitename%%";s:21:"metadesc-tax-category";s:24:"%%excerpt%% %%sitename%%";s:28:"display-metabox-tax-category";b:1;s:20:"noindex-tax-category";b:1;s:18:"title-tax-post_tag";s:44:"%%term_title%% %%page%% %%sep%% %%sitename%%";s:21:"metadesc-tax-post_tag";s:24:"%%excerpt%% %%sitename%%";s:28:"display-metabox-tax-post_tag";b:1;s:20:"noindex-tax-post_tag";b:1;s:21:"title-tax-post_format";s:44:"%%term_title%% %%page%% %%sep%% %%sitename%%";s:24:"metadesc-tax-post_format";s:24:"%%excerpt%% %%sitename%%";s:31:"display-metabox-tax-post_format";b:0;s:23:"noindex-tax-post_format";b:0;s:26:"taxonomy-category-ptparent";s:1:"0";s:26:"taxonomy-post_tag-ptparent";s:1:"0";s:29:"taxonomy-post_format-ptparent";s:1:"0";}', 'yes'),
	(2175, 'wpto', 'a:35:{s:15:"css_js_versions";i:0;s:17:"wp_version_number";i:1;s:13:"remove_oembed";i:1;s:21:"remove_jquery_migrate";i:0;s:20:"remove_emoji_release";i:1;s:26:"remove_recent_comments_css";i:1;s:15:"remove_rsd_link";i:1;s:15:"remove_rss_feed";i:0;s:18:"remove_wlwmanifest";i:1;s:14:"remove_wp_json";i:1;s:19:"remove_wp_shortlink";i:1;s:20:"remove_wp_post_links";i:0;s:15:"remove_pingback";i:0;s:19:"remove_dns_prefetch";i:0;s:24:"remove_yoast_information";i:0;s:21:"wc_add_payment_method";i:0;s:16:"wc_lost_password";i:0;s:15:"wc_price_slider";i:0;s:17:"wc_single_product";i:0;s:14:"wc_add_to_cart";i:0;s:17:"wc_cart_fragments";i:0;s:19:"wc_credit_card_form";i:0;s:11:"wc_checkout";i:0;s:24:"wc_add_to_cart_variation";i:0;s:7:"wc_cart";i:0;s:9:"wc_chosen";i:0;s:11:"woocommerce";i:0;s:11:"prettyPhoto";i:0;s:16:"prettyPhoto_init";i:0;s:14:"jquery_blockui";i:0;s:18:"jquery_placeholder";i:0;s:14:"jquery_payment";i:0;s:8:"fancybox";i:0;s:8:"jqueryui";i:0;s:11:"html_minify";i:0;}', 'yes');

-- Dumping structure for таблиця db.hadpj_postmeta
CREATE TABLE IF NOT EXISTS `hadpj_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`post_id`,`meta_key`,`meta_id`),
  UNIQUE KEY `meta_id` (`meta_id`),
  KEY `meta_key` (`meta_key`,`meta_value`(32),`post_id`,`meta_id`),
  KEY `meta_value` (`meta_value`(32),`meta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db.hadpj_postmeta: ~7 rows (приблизно)
DELETE FROM `hadpj_postmeta`;
INSERT INTO `hadpj_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
	(106, 48, '_additional_settings', ''),
	(102, 48, '_form', '<label> Your name\n    [text* your-name autocomplete:name] </label>\n\n<label> Your email\n    [email* your-email autocomplete:email] </label>\n\n<label> Subject\n    [text* your-subject] </label>\n\n<label> Your message (optional)\n    [textarea your-message] </label>\n\n[submit "Submit"]'),
	(108, 48, '_hash', 'e63906deeb18db99890dfec251d75460266dfbf6'),
	(107, 48, '_locale', 'en_US'),
	(103, 48, '_mail', 'a:9:{s:6:"active";b:1;s:7:"subject";s:30:"[_site_title] "[your-subject]"";s:6:"sender";s:40:"[_site_title] <wordpress@wpeb.ddev.site>";s:9:"recipient";s:19:"[_site_admin_email]";s:4:"body";s:161:"From: [your-name] [your-email]\nSubject: [your-subject]\n\nMessage Body:\n[your-message]\n\n-- \nThis e-mail was sent from a contact form on [_site_title] ([_site_url])";s:18:"additional_headers";s:22:"Reply-To: [your-email]";s:11:"attachments";s:0:"";s:8:"use_html";b:0;s:13:"exclude_blank";b:0;}'),
	(104, 48, '_mail_2', 'a:9:{s:6:"active";b:0;s:7:"subject";s:30:"[_site_title] "[your-subject]"";s:6:"sender";s:40:"[_site_title] <wordpress@wpeb.ddev.site>";s:9:"recipient";s:12:"[your-email]";s:4:"body";s:105:"Message Body:\n[your-message]\n\n-- \nThis e-mail was sent from a contact form on [_site_title] ([_site_url])";s:18:"additional_headers";s:29:"Reply-To: [_site_admin_email]";s:11:"attachments";s:0:"";s:8:"use_html";b:0;s:13:"exclude_blank";b:0;}'),
	(105, 48, '_messages', 'a:22:{s:12:"mail_sent_ok";s:45:"Thank you for your message. It has been sent.";s:12:"mail_sent_ng";s:71:"There was an error trying to send your message. Please try again later.";s:16:"validation_error";s:61:"One or more fields have an error. Please check and try again.";s:4:"spam";s:71:"There was an error trying to send your message. Please try again later.";s:12:"accept_terms";s:69:"You must accept the terms and conditions before sending your message.";s:16:"invalid_required";s:27:"Please fill out this field.";s:16:"invalid_too_long";s:32:"This field has a too long input.";s:17:"invalid_too_short";s:33:"This field has a too short input.";s:13:"upload_failed";s:46:"There was an unknown error uploading the file.";s:24:"upload_file_type_invalid";s:49:"You are not allowed to upload files of this type.";s:21:"upload_file_too_large";s:31:"The uploaded file is too large.";s:23:"upload_failed_php_error";s:38:"There was an error uploading the file.";s:12:"invalid_date";s:41:"Please enter a date in YYYY-MM-DD format.";s:14:"date_too_early";s:32:"This field has a too early date.";s:13:"date_too_late";s:31:"This field has a too late date.";s:14:"invalid_number";s:22:"Please enter a number.";s:16:"number_too_small";s:34:"This field has a too small number.";s:16:"number_too_large";s:34:"This field has a too large number.";s:23:"quiz_answer_not_correct";s:36:"The answer to the quiz is incorrect.";s:13:"invalid_email";s:30:"Please enter an email address.";s:11:"invalid_url";s:19:"Please enter a URL.";s:11:"invalid_tel";s:32:"Please enter a telephone number.";}');

-- Dumping structure for таблиця db.hadpj_posts
CREATE TABLE IF NOT EXISTS `hadpj_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned NOT NULL DEFAULT 0,
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext NOT NULL,
  `post_title` text NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_status` varchar(20) NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) NOT NULL DEFAULT 'open',
  `post_password` varchar(255) NOT NULL DEFAULT '',
  `post_name` varchar(200) NOT NULL DEFAULT '',
  `to_ping` text NOT NULL,
  `pinged` text NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext NOT NULL,
  `post_parent` bigint(20) unsigned NOT NULL DEFAULT 0,
  `guid` varchar(255) NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT 0,
  `post_type` varchar(20) NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`),
  KEY `post_parent` (`post_parent`,`post_type`,`post_status`),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`post_author`),
  KEY `post_author` (`post_author`,`post_type`,`post_status`,`post_date`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db.hadpj_posts: ~2 rows (приблизно)
DELETE FROM `hadpj_posts`;
INSERT INTO `hadpj_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
	(48, 2, '2023-09-08 02:56:08', '2023-09-07 23:56:08', '<label> Your name\r\n    [text* your-name autocomplete:name] </label>\r\n\r\n<label> Your email\r\n    [email* your-email autocomplete:email] </label>\r\n\r\n<label> Subject\r\n    [text* your-subject] </label>\r\n\r\n<label> Your message (optional)\r\n    [textarea your-message] </label>\r\n\r\n[submit "Submit"]\n1\n[_site_title] "[your-subject]"\n[_site_title] <wordpress@wpeb.ddev.site>\n[_site_admin_email]\nFrom: [your-name] [your-email]\r\nSubject: [your-subject]\r\n\r\nMessage Body:\r\n[your-message]\r\n\r\n-- \r\nThis e-mail was sent from a contact form on [_site_title] ([_site_url])\nReply-To: [your-email]\n\n\n\n\n[_site_title] "[your-subject]"\n[_site_title] <wordpress@wpeb.ddev.site>\n[your-email]\nMessage Body:\r\n[your-message]\r\n\r\n-- \r\nThis e-mail was sent from a contact form on [_site_title] ([_site_url])\nReply-To: [_site_admin_email]\n\n\n\nThank you for your message. It has been sent.\nThere was an error trying to send your message. Please try again later.\nOne or more fields have an error. Please check and try again.\nThere was an error trying to send your message. Please try again later.\nYou must accept the terms and conditions before sending your message.\nPlease fill out this field.\nThis field has a too long input.\nThis field has a too short input.\nThere was an unknown error uploading the file.\nYou are not allowed to upload files of this type.\nThe uploaded file is too large.\nThere was an error uploading the file.\nPlease enter a date in YYYY-MM-DD format.\nThis field has a too early date.\nThis field has a too late date.\nPlease enter a number.\nThis field has a too small number.\nThis field has a too large number.\nThe answer to the quiz is incorrect.\nPlease enter an email address.\nPlease enter a URL.\nPlease enter a telephone number.', 'Contact Form', '', 'publish', 'closed', 'closed', '', 'contact-form', '', '', '2023-09-08 02:56:08', '2023-09-07 23:56:08', '', 0, 'https://wpeb.ddev.site/?post_type=wpcf7_contact_form&p=48', 0, 'wpcf7_contact_form', '', 0),
	(49, 0, '2024-07-03 09:32:45', '2024-07-03 06:32:45', '<!-- wp:page-list /-->', 'Navigation', '', 'publish', 'closed', 'closed', '', 'navigation', '', '', '2024-07-03 09:32:45', '2024-07-03 06:32:45', '', 0, 'https://wpeb.ddev.site/navigation/', 0, 'wp_navigation', '', 0);

-- Dumping structure for таблиця db.hadpj_termmeta
CREATE TABLE IF NOT EXISTS `hadpj_termmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`term_id`,`meta_key`,`meta_id`),
  UNIQUE KEY `meta_id` (`meta_id`),
  KEY `meta_key` (`meta_key`,`meta_value`(32),`term_id`,`meta_id`),
  KEY `meta_value` (`meta_value`(32),`meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db.hadpj_termmeta: ~0 rows (приблизно)
DELETE FROM `hadpj_termmeta`;

-- Dumping structure for таблиця db.hadpj_terms
CREATE TABLE IF NOT EXISTS `hadpj_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db.hadpj_terms: ~2 rows (приблизно)
DELETE FROM `hadpj_terms`;
INSERT INTO `hadpj_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
	(1, 'X', 'uncategories', 0),
	(2, 'Ссылки', 'links', 0);

-- Dumping structure for таблиця db.hadpj_term_relationships
CREATE TABLE IF NOT EXISTS `hadpj_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `term_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db.hadpj_term_relationships: ~0 rows (приблизно)
DELETE FROM `hadpj_term_relationships`;

-- Dumping structure for таблиця db.hadpj_term_taxonomy
CREATE TABLE IF NOT EXISTS `hadpj_term_taxonomy` (
  `term_taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `taxonomy` varchar(32) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `parent` bigint(20) unsigned NOT NULL DEFAULT 0,
  `count` bigint(20) NOT NULL DEFAULT 0,
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db.hadpj_term_taxonomy: ~2 rows (приблизно)
DELETE FROM `hadpj_term_taxonomy`;
INSERT INTO `hadpj_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
	(1, 1, 'category', '', 0, 0),
	(2, 2, 'link_category', '', 0, 0);

-- Dumping structure for таблиця db.hadpj_tm_taskmeta
CREATE TABLE IF NOT EXISTS `hadpj_tm_taskmeta` (
  `meta_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `task_id` bigint(20) NOT NULL DEFAULT 0,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`meta_id`),
  KEY `meta_key` (`meta_key`(191)),
  KEY `task_id` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table db.hadpj_tm_taskmeta: ~0 rows (приблизно)
DELETE FROM `hadpj_tm_taskmeta`;

-- Dumping structure for таблиця db.hadpj_tm_tasks
CREATE TABLE IF NOT EXISTS `hadpj_tm_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `type` varchar(300) NOT NULL,
  `class_identifier` varchar(300) DEFAULT '0',
  `attempts` int(11) DEFAULT 0,
  `description` varchar(300) DEFAULT NULL,
  `time_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_locked_at` bigint(20) DEFAULT 0,
  `status` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table db.hadpj_tm_tasks: ~0 rows (приблизно)
DELETE FROM `hadpj_tm_tasks`;

-- Dumping structure for таблиця db.hadpj_usermeta
CREATE TABLE IF NOT EXISTS `hadpj_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`user_id`,`meta_key`,`umeta_id`),
  UNIQUE KEY `umeta_id` (`umeta_id`),
  KEY `meta_key` (`meta_key`,`meta_value`(32),`user_id`,`umeta_id`),
  KEY `meta_value` (`meta_value`(32),`umeta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db.hadpj_usermeta: ~72 rows (приблизно)
DELETE FROM `hadpj_usermeta`;
INSERT INTO `hadpj_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
	(34, 2, '_yoast_wpseo_profile_updated', '1428927027'),
	(110, 2, 'acf_user_settings', 'a:3:{s:20:"taxonomies-first-run";b:1;s:19:"post-type-first-run";b:1;s:23:"options-pages-first-run";b:1;}'),
	(28, 2, 'admin_color', 'coffee'),
	(106, 2, 'aim', ''),
	(101, 2, 'closedpostboxes_dashboard', 'a:0:{}'),
	(27, 2, 'comment_shortcuts', 'false'),
	(98, 2, 'community-events-location', 'a:1:{s:2:"ip";s:10:"172.22.0.0";}'),
	(25, 2, 'description', ''),
	(33, 2, 'dismissed_wp_pointers', 'wp330_toolbar,wp330_saving_widgets,wp340_choose_image_from_library,wp340_customize_current_theme_link,wp350_media,wp360_revisions,wp360_locks,wp496_privacy,wbcr_clearfy_settings_pointer_1_4_2,perflab-admin-pointer,perflab-module-migration-pointer'),
	(22, 2, 'first_name', ''),
	(31, 2, 'hadpj_capabilities', 'a:1:{s:13:"administrator";b:1;}'),
	(97, 2, 'hadpj_dashboard_quick_press_last_post_id', '45'),
	(32, 2, 'hadpj_user_level', '10'),
	(108, 2, 'jabber', ''),
	(96, 2, 'last_login_time', '2023-04-19 08:55:24'),
	(23, 2, 'last_name', ''),
	(105, 2, 'locale', ''),
	(111, 2, 'manageedit-acf-post-typecolumnshidden', 'a:1:{i:0;s:7:"acf-key";}'),
	(109, 2, 'manageedit-acf-taxonomycolumnshidden', 'a:1:{i:0;s:7:"acf-key";}'),
	(115, 2, 'manageedit-acf-ui-options-pagecolumnshidden', 'a:1:{i:0;s:7:"acf-key";}'),
	(103, 2, 'meta-box-order_dashboard', 'a:4:{s:6:"normal";s:41:"dashboard_site_health,dashboard_right_now";s:4:"side";s:32:"wordfence_activity_report_widget";s:7:"column3";s:40:"dashboard_activity,dashboard_quick_press";s:7:"column4";s:17:"dashboard_primary";}'),
	(102, 2, 'metaboxhidden_dashboard', 'a:0:{}'),
	(24, 2, 'nickname', 'aparserok'),
	(26, 2, 'rich_editing', 'true'),
	(95, 2, 'session_tokens', 'a:1:{s:64:"5fb9802d9971b29974bfbdbccbd29891b55d5bb36849c73f838b0d3ecf795215";a:4:{s:10:"expiration";i:1730927483;s:2:"ip";s:10:"172.22.0.5";s:2:"ua";s:125:"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36 Edg/130.0.0.0";s:5:"login";i:1729717883;}}'),
	(30, 2, 'show_admin_bar_front', 'true'),
	(99, 2, 'show_try_gutenberg_panel', '0'),
	(100, 2, 'show_welcome_panel', '0'),
	(104, 2, 'syntax_highlighting', 'true'),
	(29, 2, 'use_ssl', '0'),
	(114, 2, 'wfls-last-login', '1688175250'),
	(116, 2, 'wpcf7_hide_welcome_panel_on', 'a:2:{i:0;s:3:"5.8";i:1;s:3:"5.9";}'),
	(107, 2, 'yim', ''),
	(60, 3, '_yoast_wpseo_profile_updated', '1428927027'),
	(50, 3, 'admin_color', 'midnight'),
	(61, 3, 'aim', ''),
	(49, 3, 'comment_shortcuts', 'false'),
	(90, 3, 'community-events-location', 'a:1:{s:2:"ip";s:9:"127.0.0.0";}'),
	(47, 3, 'description', ''),
	(55, 3, 'dismissed_wp_pointers', 'wp330_toolbar,wp330_saving_widgets,wp340_choose_image_from_library,wp340_customize_current_theme_link,wp350_media,wp360_revisions,wp360_locks,wp390_widgets,wp410_dfw,wp496_privacy'),
	(66, 3, 'facebook', ''),
	(44, 3, 'first_name', 'Shiva'),
	(64, 3, 'googleplus', ''),
	(53, 3, 'hadpj_capabilities', 'a:1:{s:13:"administrator";b:1;}'),
	(56, 3, 'hadpj_dashboard_quick_press_last_post_id', '35'),
	(54, 3, 'hadpj_user_level', '10'),
	(63, 3, 'jabber', ''),
	(67, 3, 'last_login_time', '2018-09-24 10:59:59'),
	(45, 3, 'last_name', 'Parameshwara'),
	(113, 3, 'locale', ''),
	(83, 3, 'managenav-menuscolumnshidden', 'a:4:{i:0;s:11:"link-target";i:1;s:11:"css-classes";i:2;s:3:"xfn";i:3;s:11:"description";}'),
	(86, 3, 'meta-box-order_dashboard', 'a:4:{s:6:"normal";s:38:"dashboard_right_now,dashboard_activity";s:4:"side";s:21:"dashboard_quick_press";s:7:"column3";s:17:"dashboard_primary";s:7:"column4";s:0:"";}'),
	(84, 3, 'metaboxhidden_nav-menus', 'a:2:{i:0;s:8:"add-post";i:1;s:12:"add-post_tag";}'),
	(46, 3, 'nickname', 'shiva'),
	(48, 3, 'rich_editing', 'true'),
	(68, 3, 'session_tokens', 'a:1:{s:64:"91d95bee62c50a50d8b3a55f6e82e1d2ab39d3fe1c26dadd710959485d307df8";a:4:{s:10:"expiration";i:1538985599;s:2:"ip";s:9:"127.0.0.1";s:2:"ua";s:115:"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36";s:5:"login";i:1537775999;}}'),
	(52, 3, 'show_admin_bar_front', 'true'),
	(93, 3, 'show_try_gutenberg_panel', '0'),
	(94, 3, 'show_welcome_panel', '0'),
	(112, 3, 'syntax_highlighting', 'true'),
	(65, 3, 'twitter', ''),
	(51, 3, 'use_ssl', '0'),
	(85, 3, 'wpseo_dismissed_gsc_notice', '1'),
	(81, 3, 'wpseo_ignore_tour', '1'),
	(58, 3, 'wpseo_metadesc', ''),
	(59, 3, 'wpseo_metakey', ''),
	(82, 3, 'wpseo_seen_about_version', '3.0.7'),
	(57, 3, 'wpseo_title', ''),
	(88, 3, 'wpseo-dismiss-about', 'seen'),
	(89, 3, 'wpseo-dismiss-gsc', 'seen'),
	(92, 3, 'wpseo-remove-upsell-notice', '1'),
	(62, 3, 'yim', '');

-- Dumping structure for таблиця db.hadpj_users
CREATE TABLE IF NOT EXISTS `hadpj_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(255) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT 0,
  `display_name` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`),
  KEY `user_email` (`user_email`),
  KEY `display_name` (`display_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db.hadpj_users: ~2 rows (приблизно)
DELETE FROM `hadpj_users`;
INSERT INTO `hadpj_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
	(2, 'aparserok', '$P$B/elTum9/FTA.MrU6bDt580YXCJiCn0', 'aparserok', 'aparserok@gmail.com', '', '2013-11-06 22:37:02', '', 0, 'aparserok'),
	(3, 'shiva', '$P$BNdTz5JzMaI1Q5pVX/quZko.M1GHZ80', 'shiva', 'crazyyy@gmail.com', 'http://en.wikipedia.org/wiki/Shiva', '2013-12-20 17:06:50', '', 0, 'Shiva Parameshwara');

-- Dumping structure for таблиця db.hadpj_wfblockediplog
CREATE TABLE IF NOT EXISTS `hadpj_wfblockediplog` (
  `IP` binary(16) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `countryCode` varchar(2) NOT NULL,
  `blockCount` int(10) unsigned NOT NULL DEFAULT 0,
  `unixday` int(10) unsigned NOT NULL,
  `blockType` varchar(50) NOT NULL DEFAULT 'generic',
  PRIMARY KEY (`IP`,`unixday`,`blockType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wfblockediplog: ~0 rows (приблизно)
DELETE FROM `hadpj_wfblockediplog`;

-- Dumping structure for таблиця db.hadpj_wfblocks7
CREATE TABLE IF NOT EXISTS `hadpj_wfblocks7` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(10) unsigned NOT NULL DEFAULT 0,
  `IP` binary(16) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `blockedTime` bigint(20) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `lastAttempt` int(10) unsigned DEFAULT 0,
  `blockedHits` int(10) unsigned DEFAULT 0,
  `expiration` bigint(20) unsigned NOT NULL DEFAULT 0,
  `parameters` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `IP` (`IP`),
  KEY `expiration` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wfblocks7: ~0 rows (приблизно)
DELETE FROM `hadpj_wfblocks7`;

-- Dumping structure for таблиця db.hadpj_wfconfig
CREATE TABLE IF NOT EXISTS `hadpj_wfconfig` (
  `name` varchar(100) NOT NULL,
  `val` longblob DEFAULT NULL,
  `autoload` enum('no','yes') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wfconfig: ~0 rows (приблизно)
DELETE FROM `hadpj_wfconfig`;

-- Dumping structure for таблиця db.hadpj_wfcrawlers
CREATE TABLE IF NOT EXISTS `hadpj_wfcrawlers` (
  `IP` binary(16) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `patternSig` binary(16) NOT NULL,
  `status` char(8) NOT NULL,
  `lastUpdate` int(10) unsigned NOT NULL,
  `PTR` varchar(255) DEFAULT '',
  PRIMARY KEY (`IP`,`patternSig`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wfcrawlers: ~0 rows (приблизно)
DELETE FROM `hadpj_wfcrawlers`;

-- Dumping structure for таблиця db.hadpj_wffilechanges
CREATE TABLE IF NOT EXISTS `hadpj_wffilechanges` (
  `filenameHash` char(64) NOT NULL,
  `file` varchar(1000) NOT NULL,
  `md5` char(32) NOT NULL,
  PRIMARY KEY (`filenameHash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wffilechanges: ~0 rows (приблизно)
DELETE FROM `hadpj_wffilechanges`;

-- Dumping structure for таблиця db.hadpj_wffilemods
CREATE TABLE IF NOT EXISTS `hadpj_wffilemods` (
  `filenameMD5` binary(16) NOT NULL,
  `filename` varchar(1000) NOT NULL,
  `real_path` text NOT NULL,
  `knownFile` tinyint(3) unsigned NOT NULL,
  `oldMD5` binary(16) NOT NULL,
  `newMD5` binary(16) NOT NULL,
  `SHAC` binary(32) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `stoppedOnSignature` varchar(255) NOT NULL DEFAULT '',
  `stoppedOnPosition` int(10) unsigned NOT NULL DEFAULT 0,
  `isSafeFile` varchar(1) NOT NULL DEFAULT '?',
  PRIMARY KEY (`filenameMD5`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wffilemods: ~0 rows (приблизно)
DELETE FROM `hadpj_wffilemods`;

-- Dumping structure for таблиця db.hadpj_wfhits
CREATE TABLE IF NOT EXISTS `hadpj_wfhits` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attackLogTime` double(17,6) unsigned NOT NULL,
  `ctime` double(17,6) unsigned NOT NULL,
  `IP` binary(16) DEFAULT NULL,
  `jsRun` tinyint(4) DEFAULT 0,
  `statusCode` int(11) NOT NULL DEFAULT 200,
  `isGoogle` tinyint(4) NOT NULL,
  `userID` int(10) unsigned NOT NULL,
  `newVisit` tinyint(3) unsigned NOT NULL,
  `URL` text DEFAULT NULL,
  `referer` text DEFAULT NULL,
  `UA` text DEFAULT NULL,
  `action` varchar(64) NOT NULL DEFAULT '',
  `actionDescription` text DEFAULT NULL,
  `actionData` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `k1` (`ctime`),
  KEY `k2` (`IP`,`ctime`),
  KEY `attackLogTime` (`attackLogTime`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wfhits: ~0 rows (приблизно)
DELETE FROM `hadpj_wfhits`;
INSERT INTO `hadpj_wfhits` (`id`, `attackLogTime`, `ctime`, `IP`, `jsRun`, `statusCode`, `isGoogle`, `userID`, `newVisit`, `URL`, `referer`, `UA`, `action`, `actionDescription`, `actionData`) VALUES
	(1, 0.000000, 1688175236.719319, _binary 0x00000000000000000000c3bfc3bf7f00, 0, 302, 0, 2, 0, 'https://wpeb.ddev.site/wp-login.php', 'https://wpeb.ddev.site/wp-login.php?redirect_to=https%3A%2F%2Fwpeb.ddev.site%2Fwp-admin%2F&reauth=1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36 Edg/115.0.1901.151', 'loginOK', NULL, NULL);

-- Dumping structure for таблиця db.hadpj_wfhoover
CREATE TABLE IF NOT EXISTS `hadpj_wfhoover` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner` text DEFAULT NULL,
  `host` text DEFAULT NULL,
  `path` text DEFAULT NULL,
  `hostKey` varbinary(124) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `k2` (`hostKey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wfhoover: ~0 rows (приблизно)
DELETE FROM `hadpj_wfhoover`;

-- Dumping structure for таблиця db.hadpj_wfissues
CREATE TABLE IF NOT EXISTS `hadpj_wfissues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(10) unsigned NOT NULL,
  `lastUpdated` int(10) unsigned NOT NULL,
  `status` varchar(10) NOT NULL,
  `type` varchar(20) NOT NULL,
  `severity` tinyint(3) unsigned NOT NULL,
  `ignoreP` char(32) NOT NULL,
  `ignoreC` char(32) NOT NULL,
  `shortMsg` varchar(255) NOT NULL,
  `longMsg` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lastUpdated` (`lastUpdated`),
  KEY `status` (`status`),
  KEY `ignoreP` (`ignoreP`),
  KEY `ignoreC` (`ignoreC`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wfissues: ~0 rows (приблизно)
DELETE FROM `hadpj_wfissues`;
INSERT INTO `hadpj_wfissues` (`id`, `time`, `lastUpdated`, `status`, `type`, `severity`, `ignoreP`, `ignoreC`, `shortMsg`, `longMsg`, `data`) VALUES
	(1, 1681898097, 1681898097, 'new', 'knownfile', 50, '181447348de2f66f53c1a116c0aa1265', '6df5d32dab8471256bb53ca3f3b5c843', 'Modified plugin file: wp-content/plugins/seo-image/seo-friendly-images.class.php', 'This file belongs to plugin "SEO Friendly Images" version "3.0.5" and has been modified from the file that is distributed by WordPress.org for this version. Please use the link to see how the file has changed. If you have modified this file yourself, you can safely ignore this warning. If you see a lot of changed files in a plugin that have been made by the author, then try uninstalling and reinstalling the plugin to force an upgrade. Doing this is a workaround for plugin authors who don\'t manage their code correctly. <a href="https://www.wordfence.com/help/?query=scan-result-modified-plugin" target="_blank" rel="noopener noreferrer">Learn More<span class="screen-reader-text"> (opens in new tab)</span></a>', 'a:10:{s:4:"file";s:58:"wp-content/plugins/seo-image/seo-friendly-images.class.php";s:8:"realFile";s:84:"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\seo-image\\seo-friendly-images.class.php";s:5:"cType";s:6:"plugin";s:7:"canDiff";b:1;s:6:"canFix";b:1;s:9:"canDelete";b:0;s:5:"cName";s:19:"SEO Friendly Images";s:8:"cVersion";s:5:"3.0.5";s:4:"cKey";s:33:"seo-image/seo-friendly-images.php";s:10:"haveIssues";s:7:"plugins";}');

-- Dumping structure for таблиця db.hadpj_wfknownfilelist
CREATE TABLE IF NOT EXISTS `hadpj_wfknownfilelist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `path` text NOT NULL,
  `wordpress_path` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wfknownfilelist: ~0 rows (приблизно)
DELETE FROM `hadpj_wfknownfilelist`;

-- Dumping structure for таблиця db.hadpj_wflivetraffichuman
CREATE TABLE IF NOT EXISTS `hadpj_wflivetraffichuman` (
  `IP` binary(16) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `identifier` binary(32) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `expiration` int(10) unsigned NOT NULL,
  PRIMARY KEY (`IP`,`identifier`),
  KEY `expiration` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wflivetraffichuman: ~0 rows (приблизно)
DELETE FROM `hadpj_wflivetraffichuman`;

-- Dumping structure for таблиця db.hadpj_wflocs
CREATE TABLE IF NOT EXISTS `hadpj_wflocs` (
  `IP` binary(16) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `ctime` int(10) unsigned NOT NULL,
  `failed` tinyint(3) unsigned NOT NULL,
  `city` varchar(255) DEFAULT '',
  `region` varchar(255) DEFAULT '',
  `countryName` varchar(255) DEFAULT '',
  `countryCode` char(2) DEFAULT '',
  `lat` float(10,7) DEFAULT 0.0000000,
  `lon` float(10,7) DEFAULT 0.0000000,
  PRIMARY KEY (`IP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wflocs: ~0 rows (приблизно)
DELETE FROM `hadpj_wflocs`;
INSERT INTO `hadpj_wflocs` (`IP`, `ctime`, `failed`, `city`, `region`, `countryName`, `countryCode`, `lat`, `lon`) VALUES
	(_binary 0x00000000000000000000c3bfc3bf7f00, 1688175237, 1, '', '', '', '', 0.0000000, 0.0000000);

-- Dumping structure for таблиця db.hadpj_wflogins
CREATE TABLE IF NOT EXISTS `hadpj_wflogins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hitID` int(11) DEFAULT NULL,
  `ctime` double(17,6) unsigned NOT NULL,
  `fail` tinyint(3) unsigned NOT NULL,
  `action` varchar(40) NOT NULL,
  `username` varchar(255) NOT NULL,
  `userID` int(10) unsigned NOT NULL,
  `IP` binary(16) DEFAULT NULL,
  `UA` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `k1` (`IP`,`fail`),
  KEY `hitID` (`hitID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wflogins: ~0 rows (приблизно)
DELETE FROM `hadpj_wflogins`;
INSERT INTO `hadpj_wflogins` (`id`, `hitID`, `ctime`, `fail`, `action`, `username`, `userID`, `IP`, `UA`) VALUES
	(1, 1, 1688175236.976641, 0, 'loginOK', 'aparserok', 2, _binary 0x00000000000000000000c3bfc3bf7f00, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36 Edg/115.0.1901.151');

-- Dumping structure for таблиця db.hadpj_wfls_2fa_secrets
CREATE TABLE IF NOT EXISTS `hadpj_wfls_2fa_secrets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `secret` tinyblob NOT NULL,
  `recovery` blob NOT NULL,
  `ctime` int(10) unsigned NOT NULL,
  `vtime` int(10) unsigned NOT NULL,
  `mode` enum('authenticator') NOT NULL DEFAULT 'authenticator',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wfls_2fa_secrets: ~0 rows (приблизно)
DELETE FROM `hadpj_wfls_2fa_secrets`;

-- Dumping structure for таблиця db.hadpj_wfls_role_counts
CREATE TABLE IF NOT EXISTS `hadpj_wfls_role_counts` (
  `serialized_roles` varbinary(255) NOT NULL,
  `two_factor_inactive` tinyint(1) NOT NULL,
  `user_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`serialized_roles`,`two_factor_inactive`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;

-- Dumping data for table db.hadpj_wfls_role_counts: ~0 rows (приблизно)
DELETE FROM `hadpj_wfls_role_counts`;

-- Dumping structure for таблиця db.hadpj_wfls_settings
CREATE TABLE IF NOT EXISTS `hadpj_wfls_settings` (
  `name` varchar(191) NOT NULL DEFAULT '',
  `value` longblob DEFAULT NULL,
  `autoload` enum('no','yes') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wfls_settings: ~26 rows (приблизно)
DELETE FROM `hadpj_wfls_settings`;
INSERT INTO `hadpj_wfls_settings` (`name`, `value`, `autoload`) VALUES
	('2fa-user-grace-period', _binary 0x3130, 'yes'),
	('allow-xml-rpc', _binary 0x31, 'yes'),
	('captcha-stats', _binary 0x7b22636f756e7473223a5b302c302c302c302c302c302c302c302c302c302c305d2c22617667223a307d, 'yes'),
	('delete-deactivation', _binary '', 'yes'),
	('disable-temporary-tables', _binary 0x30, 'yes'),
	('enable-auth-captcha', _binary '', 'yes'),
	('enable-login-history-columns', _binary 0x31, 'yes'),
	('enable-shortcode', _binary '', 'yes'),
	('enable-woocommerce-account-integration', _binary '', 'yes'),
	('enable-woocommerce-integration', _binary '', 'yes'),
	('global-notices', _binary 0x5b5d, 'yes'),
	('ip-source', _binary '', 'yes'),
	('ip-trusted-proxies', _binary '', 'yes'),
	('last-secret-refresh', _binary 0x31363831383836343836, 'yes'),
	('recaptcha-threshold', _binary 0x302e35, 'yes'),
	('remember-device', _binary '', 'yes'),
	('remember-device-duration', _binary 0x32353932303030, 'yes'),
	('require-2fa-grace-period-enabled', _binary '', 'yes'),
	('require-2fa.administrator', _binary '', 'yes'),
	('schema-version', _binary 0x32, 'yes'),
	('shared-hash-secret', _binary 0x35393561303963666463643537363637316664323837343034363865663765656230346136386137663965336531343635633639373531636634343664343131, 'yes'),
	('shared-symmetric-secret', _binary 0x36393764633964626134306438643239333632643562393535363463336635643366383831353763343835356665636561306362626564373363613963386439, 'yes'),
	('stack-ui-columns', _binary 0x31, 'yes'),
	('user-count-query-state', _binary '', 'yes'),
	('whitelisted', _binary '', 'yes'),
	('xmlrpc-enabled', _binary 0x31, 'yes');

-- Dumping structure for таблиця db.hadpj_wfnotifications
CREATE TABLE IF NOT EXISTS `hadpj_wfnotifications` (
  `id` varchar(32) NOT NULL DEFAULT '',
  `new` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `category` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT 1000,
  `ctime` int(10) unsigned NOT NULL,
  `html` text NOT NULL,
  `links` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wfnotifications: ~0 rows (приблизно)
DELETE FROM `hadpj_wfnotifications`;
INSERT INTO `hadpj_wfnotifications` (`id`, `new`, `category`, `priority`, `ctime`, `html`, `links`) VALUES
	('site-AEAAAAA', 0, 'wfplugin_scan', 502, 1688175513, '<a href="https://wpeb.ddev.site/wp-admin/admin.php?page=WordfenceScan">Scan aborted due to duration limit</a>', '[]');

-- Dumping structure for таблиця db.hadpj_wfpendingissues
CREATE TABLE IF NOT EXISTS `hadpj_wfpendingissues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(10) unsigned NOT NULL,
  `lastUpdated` int(10) unsigned NOT NULL,
  `status` varchar(10) NOT NULL,
  `type` varchar(20) NOT NULL,
  `severity` tinyint(3) unsigned NOT NULL,
  `ignoreP` char(32) NOT NULL,
  `ignoreC` char(32) NOT NULL,
  `shortMsg` varchar(255) NOT NULL,
  `longMsg` text DEFAULT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lastUpdated` (`lastUpdated`),
  KEY `status` (`status`),
  KEY `ignoreP` (`ignoreP`),
  KEY `ignoreC` (`ignoreC`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wfpendingissues: ~0 rows (приблизно)
DELETE FROM `hadpj_wfpendingissues`;
INSERT INTO `hadpj_wfpendingissues` (`id`, `time`, `lastUpdated`, `status`, `type`, `severity`, `ignoreP`, `ignoreC`, `shortMsg`, `longMsg`, `data`) VALUES
	(1, 1681890771, 1681890771, 'new', 'knownfile', 50, '181447348de2f66f53c1a116c0aa1265', '6df5d32dab8471256bb53ca3f3b5c843', 'Modified plugin file: wp-content/plugins/seo-image/seo-friendly-images.class.php', 'This file belongs to plugin "SEO Friendly Images" version "3.0.5" and has been modified from the file that is distributed by WordPress.org for this version. Please use the link to see how the file has changed. If you have modified this file yourself, you can safely ignore this warning. If you see a lot of changed files in a plugin that have been made by the author, then try uninstalling and reinstalling the plugin to force an upgrade. Doing this is a workaround for plugin authors who don\'t manage their code correctly. <a href="https://www.wordfence.com/help/?query=scan-result-modified-plugin" target="_blank" rel="noopener noreferrer">Learn More<span class="screen-reader-text"> (opens in new tab)</span></a>', 'a:10:{s:4:"file";s:58:"wp-content/plugins/seo-image/seo-friendly-images.class.php";s:8:"realFile";s:84:"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\seo-image\\seo-friendly-images.class.php";s:5:"cType";s:6:"plugin";s:7:"canDiff";b:1;s:6:"canFix";b:1;s:9:"canDelete";b:0;s:5:"cName";s:19:"SEO Friendly Images";s:8:"cVersion";s:5:"3.0.5";s:4:"cKey";s:33:"seo-image/seo-friendly-images.php";s:10:"haveIssues";s:7:"plugins";}');

-- Dumping structure for таблиця db.hadpj_wfreversecache
CREATE TABLE IF NOT EXISTS `hadpj_wfreversecache` (
  `IP` binary(16) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `host` varchar(255) NOT NULL,
  `lastUpdate` int(10) unsigned NOT NULL,
  PRIMARY KEY (`IP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wfreversecache: ~0 rows (приблизно)
DELETE FROM `hadpj_wfreversecache`;
INSERT INTO `hadpj_wfreversecache` (`IP`, `host`, `lastUpdate`) VALUES
	(_binary 0x00000000000000000000c3bfc3bf7f00, 'minimog.local', 1688175237);

-- Dumping structure for таблиця db.hadpj_wfsnipcache
CREATE TABLE IF NOT EXISTS `hadpj_wfsnipcache` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `IP` varchar(45) NOT NULL DEFAULT '',
  `expiration` timestamp NOT NULL DEFAULT current_timestamp(),
  `body` varchar(255) NOT NULL DEFAULT '',
  `count` int(10) unsigned NOT NULL DEFAULT 0,
  `type` int(10) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `expiration` (`expiration`),
  KEY `IP` (`IP`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wfsnipcache: ~0 rows (приблизно)
DELETE FROM `hadpj_wfsnipcache`;

-- Dumping structure for таблиця db.hadpj_wfstatus
CREATE TABLE IF NOT EXISTS `hadpj_wfstatus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ctime` double(17,6) unsigned NOT NULL,
  `level` tinyint(3) unsigned NOT NULL,
  `type` char(5) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `k1` (`ctime`),
  KEY `k2` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=788 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wfstatus: ~786 rows (приблизно)
DELETE FROM `hadpj_wfstatus`;
INSERT INTO `hadpj_wfstatus` (`id`, `ctime`, `level`, `type`, `msg`) VALUES
	(1, 1681887355.390894, 1, 'info', 'Using low resource scanning'),
	(2, 1681887355.422363, 10, 'info', 'SUM_PREP:Preparing a new scan.'),
	(3, 1681887355.495515, 1, 'info', 'Contacting Wordfence to initiate scan'),
	(4, 1681887356.356661, 10, 'info', 'SUM_PAIDONLY:Check if your site is being Spamvertized is for paid members only'),
	(5, 1681887358.431831, 10, 'info', 'SUM_PAIDONLY:Checking if your IP is generating spam is for paid members only'),
	(6, 1681887360.889857, 10, 'info', 'SUM_PAIDONLY:Checking if your site is on a domain blocklist is for paid members only'),
	(7, 1681887363.039263, 10, 'info', 'SUM_START:Checking for the most secure way to get IPs'),
	(8, 1681887363.087514, 10, 'info', 'SUM_ENDSKIPPED:Checking for the most secure way to get IPs'),
	(9, 1681887363.148148, 10, 'info', 'SUM_START:Scanning to check available disk space'),
	(10, 1681887363.179760, 2, 'info', 'Total disk space: 467.49 GB -- Free disk space: 76.74 GB'),
	(11, 1681887363.195788, 2, 'info', 'The disk has 78581.7 MB available'),
	(12, 1681887363.211060, 10, 'info', 'SUM_ENDOK:Scanning to check available disk space'),
	(13, 1681887363.274038, 10, 'info', 'SUM_START:Checking Web Application Firewall status'),
	(14, 1681887363.304690, 10, 'info', 'SUM_ENDOK:Checking Web Application Firewall status'),
	(15, 1681887363.367634, 10, 'info', 'SUM_START:Checking for future GeoIP support'),
	(16, 1681887363.399111, 10, 'info', 'SUM_ENDOK:Checking for future GeoIP support'),
	(17, 1681887363.461214, 10, 'info', 'SUM_START:Checking for paths skipped due to scan settings'),
	(18, 1681887363.493864, 10, 'info', 'SUM_ENDOK:Checking for paths skipped due to scan settings'),
	(19, 1681887363.540647, 2, 'info', 'Including files that are outside the WordPress installation in the scan.'),
	(20, 1681887363.554750, 2, 'info', 'Getting plugin list from WordPress'),
	(21, 1681887363.708255, 2, 'info', 'Found 65 plugins'),
	(22, 1681887363.724064, 2, 'info', 'Getting theme list from WordPress'),
	(23, 1681887363.748028, 2, 'info', 'Found 5 themes'),
	(24, 1681887364.303381, 10, 'info', 'SUM_START:Fetching core, theme and plugin file signatures from Wordfence'),
	(25, 1681887369.571018, 10, 'info', 'SUM_ENDSUCCESS:Fetching core, theme and plugin file signatures from Wordfence'),
	(26, 1681887369.640778, 10, 'info', 'SUM_START:Fetching list of known malware files from Wordfence'),
	(27, 1681887371.405846, 10, 'info', 'SUM_ENDSUCCESS:Fetching list of known malware files from Wordfence'),
	(28, 1681887371.495092, 10, 'info', 'SUM_START:Fetching list of known core files from Wordfence'),
	(29, 1681887373.300077, 10, 'info', 'SUM_ENDSUCCESS:Fetching list of known core files from Wordfence'),
	(30, 1681887373.363017, 10, 'info', 'SUM_START:Comparing core WordPress files against originals in repository'),
	(31, 1681887373.409748, 10, 'info', 'SUM_START:Comparing open source themes against WordPress.org originals'),
	(32, 1681887373.456583, 10, 'info', 'SUM_START:Comparing plugins against WordPress.org originals'),
	(33, 1681887373.503475, 10, 'info', 'SUM_START:Scanning for known malware files'),
	(34, 1681887373.550224, 10, 'info', 'SUM_START:Scanning for unknown files in wp-admin and wp-includes'),
	(35, 1681887373.982315, 2, 'info', '500 files indexed'),
	(36, 1681887374.416120, 2, 'info', '1000 files indexed'),
	(37, 1681887374.877112, 2, 'info', '1500 files indexed'),
	(38, 1681887375.377281, 2, 'info', '2000 files indexed'),
	(39, 1681887376.043231, 2, 'info', '2500 files indexed'),
	(40, 1681887376.371742, 2, 'info', '3000 files indexed'),
	(41, 1681887376.588596, 2, 'info', '3500 files indexed'),
	(42, 1681887376.839616, 2, 'info', '4000 files indexed'),
	(43, 1681887377.078518, 2, 'info', '4500 files indexed'),
	(44, 1681887377.404356, 2, 'info', '5000 files indexed'),
	(45, 1681887377.666280, 2, 'info', '5500 files indexed'),
	(46, 1681887377.987815, 2, 'info', '6000 files indexed'),
	(47, 1681887378.266117, 2, 'info', '6500 files indexed'),
	(48, 1681887378.562908, 2, 'info', '7000 files indexed'),
	(49, 1681887378.856454, 2, 'info', '7500 files indexed'),
	(50, 1681887379.093861, 2, 'info', '8000 files indexed'),
	(51, 1681887379.519068, 2, 'info', '8500 files indexed'),
	(52, 1681887380.168129, 2, 'info', '9000 files indexed'),
	(53, 1681887380.669136, 2, 'info', '9500 files indexed'),
	(54, 1681887381.116555, 2, 'info', '10000 files indexed'),
	(55, 1681887381.729891, 2, 'info', '10500 files indexed'),
	(56, 1681887382.454608, 2, 'info', '11000 files indexed'),
	(57, 1681887383.103657, 2, 'info', '11500 files indexed'),
	(58, 1681887383.522106, 2, 'info', '12000 files indexed'),
	(59, 1681887384.339579, 2, 'info', '12500 files indexed'),
	(60, 1681887385.021767, 2, 'info', '13000 files indexed'),
	(61, 1681887385.725213, 2, 'info', '13500 files indexed'),
	(62, 1681887386.068712, 2, 'info', '14000 files indexed'),
	(63, 1681887386.506071, 2, 'info', '14500 files indexed'),
	(64, 1681887387.041972, 2, 'info', '15000 files indexed'),
	(65, 1681887387.577788, 2, 'info', '15500 files indexed'),
	(66, 1681887388.296788, 2, 'info', '16000 files indexed'),
	(67, 1681887388.832583, 2, 'info', '16500 files indexed'),
	(68, 1681887389.545405, 2, 'info', '17000 files indexed'),
	(69, 1681887390.320320, 2, 'info', '17500 files indexed'),
	(70, 1681887391.002438, 2, 'info', '18000 files indexed'),
	(71, 1681887391.528954, 2, 'info', '18500 files indexed'),
	(72, 1681887392.248477, 2, 'info', '19000 files indexed'),
	(73, 1681887392.862616, 2, 'info', '19500 files indexed'),
	(74, 1681887393.663856, 2, 'info', '20000 files indexed'),
	(75, 1681887394.520382, 2, 'info', '20500 files indexed'),
	(76, 1681887395.542749, 2, 'info', '21000 files indexed'),
	(77, 1681887396.278584, 2, 'info', '21500 files indexed'),
	(78, 1681887396.969296, 2, 'info', '22000 files indexed'),
	(79, 1681887397.777328, 2, 'info', '22500 files indexed'),
	(80, 1681887398.404276, 2, 'info', '23000 files indexed'),
	(81, 1681887398.919687, 2, 'info', '23500 files indexed'),
	(82, 1681887399.601907, 2, 'info', '24000 files indexed'),
	(83, 1681887400.420051, 2, 'info', '24500 files indexed'),
	(84, 1681887401.001163, 2, 'info', '25000 files indexed'),
	(85, 1681887401.559175, 2, 'info', '25500 files indexed'),
	(86, 1681887402.028619, 2, 'info', '25847 files indexed'),
	(87, 1681887404.300892, 2, 'info', '26347 files indexed'),
	(88, 1681887404.637705, 2, 'info', '26847 files indexed'),
	(89, 1681887405.018805, 2, 'info', '27347 files indexed'),
	(90, 1681887405.413435, 2, 'info', '27847 files indexed'),
	(91, 1681887405.685775, 2, 'info', '28347 files indexed'),
	(92, 1681887406.024959, 2, 'info', '28847 files indexed'),
	(93, 1681887406.330396, 2, 'info', '29347 files indexed'),
	(94, 1681887406.696190, 2, 'info', '29847 files indexed'),
	(95, 1681887407.000689, 2, 'info', '30347 files indexed'),
	(96, 1681887407.260102, 2, 'info', '30847 files indexed'),
	(97, 1681887407.530610, 2, 'info', '31347 files indexed'),
	(98, 1681887407.846306, 2, 'info', '31847 files indexed'),
	(99, 1681887408.161079, 2, 'info', '32347 files indexed'),
	(100, 1681887408.453635, 2, 'info', '32847 files indexed'),
	(101, 1681887408.856756, 2, 'info', '33347 files indexed'),
	(102, 1681887409.233616, 2, 'info', '33847 files indexed'),
	(103, 1681887409.628306, 2, 'info', '34347 files indexed'),
	(104, 1681887409.933786, 2, 'info', '34847 files indexed'),
	(105, 1681887410.505286, 2, 'info', '35347 files indexed'),
	(106, 1681887410.906843, 2, 'info', '35847 files indexed'),
	(107, 1681887411.257118, 2, 'info', '36347 files indexed'),
	(108, 1681887411.893497, 2, 'info', '36847 files indexed'),
	(109, 1681887412.575655, 2, 'info', '37347 files indexed'),
	(110, 1681887413.177906, 2, 'info', '37847 files indexed'),
	(111, 1681887413.780991, 2, 'info', '38347 files indexed'),
	(112, 1681887414.389159, 2, 'info', '38847 files indexed'),
	(113, 1681887414.905500, 2, 'info', '39347 files indexed'),
	(114, 1681887415.591938, 2, 'info', '39847 files indexed'),
	(115, 1681887416.284310, 2, 'info', '40347 files indexed'),
	(116, 1681887416.882152, 2, 'info', '40847 files indexed'),
	(117, 1681887417.452251, 2, 'info', '41347 files indexed'),
	(118, 1681887418.010221, 2, 'info', '41847 files indexed'),
	(119, 1681887418.391200, 2, 'info', '42347 files indexed'),
	(120, 1681887418.783528, 2, 'info', '42847 files indexed'),
	(121, 1681887419.309084, 2, 'info', '43347 files indexed'),
	(122, 1681887420.119744, 2, 'info', '43847 files indexed'),
	(123, 1681887420.867352, 2, 'info', '44347 files indexed'),
	(124, 1681887421.492575, 2, 'info', '44847 files indexed'),
	(125, 1681887422.090605, 2, 'info', '45347 files indexed'),
	(126, 1681887422.650194, 2, 'info', '45847 files indexed'),
	(127, 1681887423.226053, 2, 'info', '46347 files indexed'),
	(128, 1681887423.641922, 2, 'info', '46847 files indexed'),
	(129, 1681887424.262050, 2, 'info', '47347 files indexed'),
	(130, 1681887424.754658, 2, 'info', '47847 files indexed'),
	(131, 1681887425.224160, 2, 'info', '48347 files indexed'),
	(132, 1681887425.726744, 2, 'info', '48847 files indexed'),
	(133, 1681887426.197221, 2, 'info', '49347 files indexed'),
	(134, 1681887426.943295, 2, 'info', '49847 files indexed'),
	(135, 1681887427.382081, 2, 'info', '50347 files indexed'),
	(136, 1681887427.852545, 2, 'info', '50847 files indexed'),
	(137, 1681887428.361172, 2, 'info', '51347 files indexed'),
	(138, 1681887428.899630, 2, 'info', '51847 files indexed'),
	(139, 1681887429.415072, 2, 'info', '52347 files indexed'),
	(140, 1681887430.362659, 2, 'info', '52847 files indexed'),
	(141, 1681887431.060207, 2, 'info', '53347 files indexed'),
	(142, 1681887431.662396, 2, 'info', '53847 files indexed'),
	(143, 1681887432.319892, 2, 'info', '54347 files indexed'),
	(144, 1681887432.845697, 2, 'info', '54847 files indexed'),
	(145, 1681887433.491995, 2, 'info', '55347 files indexed'),
	(146, 1681887434.083198, 2, 'info', '55847 files indexed'),
	(147, 1681887434.465231, 2, 'info', '56347 files indexed'),
	(148, 1681887434.813110, 2, 'info', '56847 files indexed'),
	(149, 1681887435.112508, 2, 'info', '57347 files indexed'),
	(150, 1681887435.428875, 2, 'info', '57847 files indexed'),
	(151, 1681887435.889979, 2, 'info', '58347 files indexed'),
	(152, 1681887436.106851, 2, 'info', '58634 files indexed'),
	(153, 1681887445.245965, 2, 'info', 'Analyzed 100 files containing 2.03 MB of data so far'),
	(154, 1681887483.101276, 2, 'info', 'Analyzed 200 files containing 5.27 MB of data so far'),
	(155, 1681887493.333681, 2, 'info', 'Analyzed 300 files containing 7.65 MB of data so far'),
	(156, 1681887503.416403, 2, 'info', 'Analyzed 400 files containing 8.81 MB of data so far'),
	(157, 1681887511.984098, 2, 'info', 'Analyzed 500 files containing 9.89 MB of data so far'),
	(158, 1681887520.947483, 2, 'info', 'Analyzed 600 files containing 10.32 MB of data so far'),
	(159, 1681887557.135938, 2, 'info', 'Analyzed 700 files containing 11.13 MB of data so far'),
	(160, 1681887567.904961, 2, 'info', 'Analyzed 800 files containing 12.44 MB of data so far'),
	(161, 1681887577.760901, 2, 'info', 'Analyzed 900 files containing 12.68 MB of data so far'),
	(162, 1681887586.508498, 2, 'info', 'Analyzed 1000 files containing 13.15 MB of data so far'),
	(163, 1681887622.163475, 2, 'info', 'Analyzed 1100 files containing 15.2 MB of data so far'),
	(164, 1681887632.504414, 2, 'info', 'Analyzed 1200 files containing 18.69 MB of data so far'),
	(165, 1681887643.078557, 2, 'info', 'Analyzed 1300 files containing 19.63 MB of data so far'),
	(166, 1681887653.870436, 2, 'info', 'Analyzed 1400 files containing 21.35 MB of data so far'),
	(167, 1681887663.572629, 2, 'info', 'Analyzed 1500 files containing 25.57 MB of data so far'),
	(168, 1681887699.462737, 2, 'info', 'Analyzed 1600 files containing 26.26 MB of data so far'),
	(169, 1681887709.419401, 2, 'info', 'Analyzed 1700 files containing 27.95 MB of data so far'),
	(170, 1681887719.641703, 2, 'info', 'Analyzed 1800 files containing 29.62 MB of data so far'),
	(171, 1681887730.293529, 2, 'info', 'Analyzed 1900 files containing 40.29 MB of data so far'),
	(172, 1681887766.834505, 2, 'info', 'Analyzed 2000 files containing 42.38 MB of data so far'),
	(173, 1681887776.048816, 2, 'info', 'Analyzed 2100 files containing 43.13 MB of data so far'),
	(174, 1681887785.001070, 2, 'info', 'Analyzed 2200 files containing 47.06 MB of data so far'),
	(175, 1681887795.019652, 2, 'info', 'Analyzed 2300 files containing 47.51 MB of data so far'),
	(176, 1681887806.230428, 2, 'info', 'Analyzed 2400 files containing 48.1 MB of data so far'),
	(177, 1681887842.153912, 2, 'info', 'Analyzed 2500 files containing 48.44 MB of data so far'),
	(178, 1681887851.334684, 2, 'info', 'Analyzed 2600 files containing 51.16 MB of data so far'),
	(179, 1681887859.787655, 2, 'info', 'Analyzed 2700 files containing 53.45 MB of data so far'),
	(180, 1681887869.021613, 2, 'info', 'Analyzed 2800 files containing 56.32 MB of data so far'),
	(181, 1681887906.090532, 2, 'info', 'Analyzed 2900 files containing 58.69 MB of data so far'),
	(182, 1681887916.566931, 2, 'info', 'Analyzed 3000 files containing 59.41 MB of data so far'),
	(183, 1681887927.376797, 2, 'info', 'Analyzed 3100 files containing 60.11 MB of data so far'),
	(184, 1681887937.217827, 2, 'info', 'Analyzed 3200 files containing 60.94 MB of data so far'),
	(185, 1681887945.403798, 2, 'info', 'Analyzed 3300 files containing 61.78 MB of data so far'),
	(186, 1681887981.754757, 2, 'info', 'Analyzed 3400 files containing 63.32 MB of data so far'),
	(187, 1681887991.792343, 2, 'info', 'Analyzed 3500 files containing 65.29 MB of data so far'),
	(188, 1681888082.079636, 2, 'info', 'Analyzed 3600 files containing 65.41 MB of data so far'),
	(189, 1681888405.892352, 2, 'info', 'Analyzed 3700 files containing 67.48 MB of data so far'),
	(190, 1681889121.647326, 2, 'info', 'Analyzed 3800 files containing 69.75 MB of data so far'),
	(191, 1681889347.657125, 2, 'info', 'Analyzed 3900 files containing 70.11 MB of data so far'),
	(192, 1681889430.681638, 2, 'info', 'Analyzed 4000 files containing 79.09 MB of data so far'),
	(193, 1681889469.998137, 2, 'info', 'Analyzed 4100 files containing 80.05 MB of data so far'),
	(194, 1681889578.795424, 2, 'info', 'Analyzed 4200 files containing 80.09 MB of data so far'),
	(195, 1681889617.753548, 2, 'info', 'Analyzed 4300 files containing 80.89 MB of data so far'),
	(196, 1681889635.883452, 2, 'info', 'Analyzed 4400 files containing 81.23 MB of data so far'),
	(197, 1681889688.893616, 2, 'info', 'Analyzed 4500 files containing 81.87 MB of data so far'),
	(198, 1681889698.889807, 2, 'info', 'Analyzed 4600 files containing 82.44 MB of data so far'),
	(199, 1681889708.097003, 2, 'info', 'Analyzed 4700 files containing 83 MB of data so far'),
	(200, 1681889716.399101, 2, 'info', 'Analyzed 4800 files containing 84.88 MB of data so far'),
	(201, 1681889725.322879, 2, 'info', 'Analyzed 4900 files containing 85.4 MB of data so far'),
	(202, 1681889762.050886, 2, 'info', 'Analyzed 5000 files containing 85.8 MB of data so far'),
	(203, 1681889771.946591, 2, 'info', 'Analyzed 5100 files containing 86.42 MB of data so far'),
	(204, 1681889782.261842, 2, 'info', 'Analyzed 5200 files containing 103.07 MB of data so far'),
	(205, 1681889791.501677, 2, 'info', 'Analyzed 5300 files containing 104.08 MB of data so far'),
	(206, 1681889827.305779, 2, 'info', 'Analyzed 5400 files containing 105.01 MB of data so far'),
	(207, 1681889837.382812, 2, 'info', 'Analyzed 5500 files containing 109.08 MB of data so far'),
	(208, 1681889847.754912, 2, 'info', 'Analyzed 5600 files containing 112.32 MB of data so far'),
	(209, 1681889858.058832, 2, 'info', 'Analyzed 5700 files containing 113.06 MB of data so far'),
	(210, 1681889867.832995, 2, 'info', 'Analyzed 5800 files containing 113.66 MB of data so far'),
	(211, 1681889903.616372, 2, 'info', 'Analyzed 5900 files containing 115.79 MB of data so far'),
	(212, 1681889913.835504, 2, 'info', 'Analyzed 6000 files containing 117.81 MB of data so far'),
	(213, 1681889923.789492, 2, 'info', 'Analyzed 6100 files containing 120.57 MB of data so far'),
	(214, 1681889934.547666, 2, 'info', 'Analyzed 6200 files containing 122.46 MB of data so far'),
	(215, 1681889967.615230, 2, 'info', 'Analyzed 6300 files containing 123.57 MB of data so far'),
	(216, 1681889977.186350, 2, 'info', 'Analyzed 6400 files containing 123.73 MB of data so far'),
	(217, 1681889987.182133, 2, 'info', 'Analyzed 6500 files containing 123.81 MB of data so far'),
	(218, 1681890060.034234, 2, 'info', 'Analyzed 6600 files containing 123.87 MB of data so far'),
	(219, 1681890069.506798, 2, 'info', 'Analyzed 6700 files containing 123.95 MB of data so far'),
	(220, 1681890078.189528, 2, 'info', 'Analyzed 6800 files containing 124.09 MB of data so far'),
	(221, 1681890087.104744, 2, 'info', 'Analyzed 6900 files containing 124.21 MB of data so far'),
	(222, 1681890097.250043, 2, 'info', 'Analyzed 7000 files containing 124.33 MB of data so far'),
	(223, 1681890133.075811, 2, 'info', 'Analyzed 7100 files containing 124.46 MB of data so far'),
	(224, 1681890143.344205, 2, 'info', 'Analyzed 7200 files containing 125.14 MB of data so far'),
	(225, 1681890151.996689, 2, 'info', 'Analyzed 7300 files containing 126.18 MB of data so far'),
	(226, 1681890160.971039, 2, 'info', 'Analyzed 7400 files containing 130.71 MB of data so far'),
	(227, 1681890197.607532, 2, 'info', 'Analyzed 7500 files containing 131.04 MB of data so far'),
	(228, 1681890208.133686, 2, 'info', 'Analyzed 7600 files containing 131.78 MB of data so far'),
	(229, 1681890218.172850, 2, 'info', 'Analyzed 7700 files containing 132.09 MB of data so far'),
	(230, 1681890226.863699, 2, 'info', 'Analyzed 7800 files containing 132.41 MB of data so far'),
	(231, 1681890235.771627, 2, 'info', 'Analyzed 7900 files containing 132.66 MB of data so far'),
	(232, 1681890273.213057, 2, 'info', 'Analyzed 8000 files containing 132.92 MB of data so far'),
	(233, 1681890283.168871, 2, 'info', 'Analyzed 8100 files containing 133.27 MB of data so far'),
	(234, 1681890293.369355, 2, 'info', 'Analyzed 8200 files containing 133.57 MB of data so far'),
	(235, 1681890301.897037, 2, 'info', 'Analyzed 8300 files containing 133.97 MB of data so far'),
	(236, 1681890310.307392, 2, 'info', 'Analyzed 8400 files containing 134.46 MB of data so far'),
	(237, 1681890346.218095, 2, 'info', 'Analyzed 8500 files containing 134.81 MB of data so far'),
	(238, 1681890356.250693, 2, 'info', 'Analyzed 8600 files containing 135.82 MB of data so far'),
	(239, 1681890366.682850, 2, 'info', 'Analyzed 8700 files containing 136.33 MB of data so far'),
	(240, 1681890375.607312, 2, 'info', 'Analyzed 8800 files containing 137.42 MB of data so far'),
	(241, 1681890384.018950, 2, 'info', 'Analyzed 8900 files containing 139.03 MB of data so far'),
	(242, 1681890418.695958, 2, 'info', 'Analyzed 9000 files containing 139.79 MB of data so far'),
	(243, 1681890429.143569, 2, 'info', 'Analyzed 9100 files containing 140.6 MB of data so far'),
	(244, 1681890439.462037, 2, 'info', 'Analyzed 9200 files containing 140.93 MB of data so far'),
	(245, 1681890449.444319, 2, 'info', 'Analyzed 9300 files containing 143.02 MB of data so far'),
	(246, 1681890484.823159, 2, 'info', 'Analyzed 9400 files containing 144.25 MB of data so far'),
	(247, 1681890494.221767, 2, 'info', 'Analyzed 9500 files containing 144.56 MB of data so far'),
	(248, 1681890504.486823, 2, 'info', 'Analyzed 9600 files containing 145.77 MB of data so far'),
	(249, 1681890514.927459, 2, 'info', 'Analyzed 9700 files containing 149.04 MB of data so far'),
	(250, 1681890524.764345, 2, 'info', 'Analyzed 9800 files containing 150.08 MB of data so far'),
	(251, 1681890559.047807, 2, 'info', 'Analyzed 9900 files containing 150.69 MB of data so far'),
	(252, 1681890567.756544, 2, 'info', 'Analyzed 10000 files containing 151.08 MB of data so far'),
	(253, 1681890577.457628, 2, 'info', 'Analyzed 10100 files containing 151.85 MB of data so far'),
	(254, 1681890587.374088, 2, 'info', 'Analyzed 10200 files containing 152.02 MB of data so far'),
	(255, 1681890597.308110, 2, 'info', 'Analyzed 10300 files containing 152.93 MB of data so far'),
	(256, 1681890633.185340, 2, 'info', 'Analyzed 10400 files containing 153.56 MB of data so far'),
	(257, 1681890643.217329, 2, 'info', 'Analyzed 10500 files containing 154.88 MB of data so far'),
	(258, 1681890653.118269, 2, 'info', 'Analyzed 10600 files containing 156.9 MB of data so far'),
	(259, 1681890662.047221, 2, 'info', 'Analyzed 10700 files containing 157.34 MB of data so far'),
	(260, 1681890670.272747, 2, 'info', 'Analyzed 10800 files containing 158.74 MB of data so far'),
	(261, 1681890705.439834, 2, 'info', 'Analyzed 10900 files containing 159.49 MB of data so far'),
	(262, 1681890715.738903, 2, 'info', 'Analyzed 11000 files containing 159.96 MB of data so far'),
	(263, 1681890725.804801, 2, 'info', 'Analyzed 11100 files containing 160.79 MB of data so far'),
	(264, 1681890735.286723, 2, 'info', 'Analyzed 11200 files containing 161.3 MB of data so far'),
	(265, 1681890771.117171, 2, 'info', 'Analyzed 11300 files containing 161.8 MB of data so far'),
	(266, 1681890781.259516, 2, 'info', 'Analyzed 11400 files containing 162.69 MB of data so far'),
	(267, 1681890791.111074, 2, 'info', 'Analyzed 11500 files containing 163.19 MB of data so far'),
	(268, 1681890801.617614, 2, 'info', 'Analyzed 11600 files containing 164.15 MB of data so far'),
	(269, 1681890811.533844, 2, 'info', 'Analyzed 11700 files containing 165.42 MB of data so far'),
	(270, 1681890846.413591, 2, 'info', 'Analyzed 11800 files containing 166.8 MB of data so far'),
	(271, 1681890856.797244, 2, 'info', 'Analyzed 11900 files containing 169.22 MB of data so far'),
	(272, 1681890866.965940, 2, 'info', 'Analyzed 12000 files containing 182.28 MB of data so far'),
	(273, 1681890877.158139, 2, 'info', 'Analyzed 12100 files containing 183.56 MB of data so far'),
	(274, 1681890913.861122, 2, 'info', 'Analyzed 12200 files containing 184.14 MB of data so far'),
	(275, 1681890922.657545, 2, 'info', 'Analyzed 12300 files containing 184.39 MB of data so far'),
	(276, 1681890931.294458, 2, 'info', 'Analyzed 12400 files containing 184.91 MB of data so far'),
	(277, 1681890941.586550, 2, 'info', 'Analyzed 12500 files containing 186.52 MB of data so far'),
	(278, 1681890951.664226, 2, 'info', 'Analyzed 12600 files containing 186.65 MB of data so far'),
	(279, 1681890986.833385, 2, 'info', 'Analyzed 12700 files containing 186.9 MB of data so far'),
	(280, 1681890995.506179, 2, 'info', 'Analyzed 12800 files containing 188.01 MB of data so far'),
	(281, 1681891004.596375, 2, 'info', 'Analyzed 12900 files containing 188.6 MB of data so far'),
	(282, 1681891014.561495, 2, 'info', 'Analyzed 13000 files containing 189.94 MB of data so far'),
	(283, 1681891024.593691, 2, 'info', 'Analyzed 13100 files containing 190.02 MB of data so far'),
	(284, 1681891059.739857, 2, 'info', 'Analyzed 13200 files containing 190.4 MB of data so far'),
	(285, 1681891068.645968, 2, 'info', 'Analyzed 13300 files containing 205.95 MB of data so far'),
	(286, 1681891077.231815, 2, 'info', 'Analyzed 13400 files containing 206.25 MB of data so far'),
	(287, 1681891087.295145, 2, 'info', 'Analyzed 13500 files containing 207.44 MB of data so far'),
	(288, 1681891097.110469, 2, 'info', 'Analyzed 13600 files containing 209.23 MB of data so far'),
	(289, 1681891133.157304, 2, 'info', 'Analyzed 13700 files containing 216.61 MB of data so far'),
	(290, 1681891141.829571, 2, 'info', 'Analyzed 13800 files containing 218.31 MB of data so far'),
	(291, 1681891150.008519, 2, 'info', 'Analyzed 13900 files containing 219.19 MB of data so far'),
	(292, 1681891158.611080, 2, 'info', 'Analyzed 14000 files containing 220.1 MB of data so far'),
	(293, 1681891168.474009, 2, 'info', 'Analyzed 14100 files containing 220.65 MB of data so far'),
	(294, 1681891204.268947, 2, 'info', 'Analyzed 14200 files containing 221.11 MB of data so far'),
	(295, 1681891214.106761, 2, 'info', 'Analyzed 14300 files containing 222.04 MB of data so far'),
	(296, 1681891221.809287, 2, 'info', 'Analyzed 14400 files containing 223.42 MB of data so far'),
	(297, 1681891228.989598, 2, 'info', 'Analyzed 14500 files containing 229.52 MB of data so far'),
	(298, 1681891235.883349, 2, 'info', 'Analyzed 14600 files containing 230.13 MB of data so far'),
	(299, 1681891268.505897, 2, 'info', 'Analyzed 14700 files containing 230.29 MB of data so far'),
	(300, 1681891278.610660, 2, 'info', 'Analyzed 14800 files containing 231.08 MB of data so far'),
	(301, 1681891288.755037, 2, 'info', 'Analyzed 14900 files containing 231.49 MB of data so far'),
	(302, 1681891297.927094, 2, 'info', 'Analyzed 15000 files containing 231.78 MB of data so far'),
	(303, 1681891306.158250, 2, 'info', 'Analyzed 15100 files containing 232.33 MB of data so far'),
	(304, 1681891340.726260, 2, 'info', 'Analyzed 15200 files containing 232.76 MB of data so far'),
	(305, 1681891350.918014, 2, 'info', 'Analyzed 15300 files containing 233.05 MB of data so far'),
	(306, 1681891361.208249, 2, 'info', 'Analyzed 15400 files containing 234.13 MB of data so far'),
	(307, 1681891369.882012, 2, 'info', 'Analyzed 15500 files containing 237.09 MB of data so far'),
	(308, 1681891378.409049, 2, 'info', 'Analyzed 15600 files containing 237.63 MB of data so far'),
	(309, 1681891413.269891, 2, 'info', 'Analyzed 15700 files containing 238.23 MB of data so far'),
	(310, 1681891423.104238, 2, 'info', 'Analyzed 15800 files containing 241.44 MB of data so far'),
	(311, 1681891432.994531, 2, 'info', 'Analyzed 15900 files containing 243.66 MB of data so far'),
	(312, 1681891443.496878, 2, 'info', 'Analyzed 16000 files containing 247.58 MB of data so far'),
	(313, 1681891452.676280, 2, 'info', 'Analyzed 16100 files containing 249.28 MB of data so far'),
	(314, 1681891487.368134, 2, 'info', 'Analyzed 16200 files containing 249.52 MB of data so far'),
	(315, 1681891497.784116, 2, 'info', 'Analyzed 16300 files containing 251.48 MB of data so far'),
	(316, 1681891507.713384, 2, 'info', 'Analyzed 16400 files containing 251.99 MB of data so far'),
	(317, 1681891517.439140, 2, 'info', 'Analyzed 16500 files containing 252.89 MB of data so far'),
	(318, 1681891553.097505, 2, 'info', 'Analyzed 16600 files containing 255.23 MB of data so far'),
	(319, 1681891561.451646, 2, 'info', 'Analyzed 16700 files containing 255.71 MB of data so far'),
	(320, 1681891570.486592, 2, 'info', 'Analyzed 16800 files containing 256.26 MB of data so far'),
	(321, 1681891580.730369, 2, 'info', 'Analyzed 16900 files containing 256.65 MB of data so far'),
	(322, 1681891590.784324, 2, 'info', 'Analyzed 17000 files containing 257.02 MB of data so far'),
	(323, 1681891626.197342, 2, 'info', 'Analyzed 17100 files containing 257.34 MB of data so far'),
	(324, 1681891634.425254, 2, 'info', 'Analyzed 17200 files containing 258.25 MB of data so far'),
	(325, 1681891643.585551, 2, 'info', 'Analyzed 17300 files containing 259.51 MB of data so far'),
	(326, 1681891653.643073, 2, 'info', 'Analyzed 17400 files containing 260.02 MB of data so far'),
	(327, 1681891663.450343, 2, 'info', 'Analyzed 17500 files containing 260.19 MB of data so far'),
	(328, 1681891697.964612, 2, 'info', 'Analyzed 17600 files containing 261.18 MB of data so far'),
	(329, 1681891706.580438, 2, 'info', 'Analyzed 17700 files containing 261.58 MB of data so far'),
	(330, 1681891715.447322, 2, 'info', 'Analyzed 17800 files containing 261.71 MB of data so far'),
	(331, 1681891725.105357, 2, 'info', 'Analyzed 17900 files containing 262.57 MB of data so far'),
	(332, 1681891735.081193, 2, 'info', 'Analyzed 18000 files containing 264.82 MB of data so far'),
	(333, 1681891771.591362, 2, 'info', 'Analyzed 18100 files containing 268.23 MB of data so far'),
	(334, 1681891782.076076, 2, 'info', 'Analyzed 18200 files containing 274.44 MB of data so far'),
	(335, 1681891792.251059, 2, 'info', 'Analyzed 18300 files containing 280.74 MB of data so far'),
	(336, 1681891801.840957, 2, 'info', 'Analyzed 18400 files containing 285.76 MB of data so far'),
	(337, 1681891810.228192, 2, 'info', 'Analyzed 18500 files containing 286.15 MB of data so far'),
	(338, 1681891846.372266, 2, 'info', 'Analyzed 18600 files containing 286.49 MB of data so far'),
	(339, 1681891856.495069, 2, 'info', 'Analyzed 18700 files containing 286.85 MB of data so far'),
	(340, 1681891866.635818, 2, 'info', 'Analyzed 18800 files containing 289.82 MB of data so far'),
	(341, 1681891876.717029, 2, 'info', 'Analyzed 18900 files containing 290.03 MB of data so far'),
	(342, 1681891912.603654, 2, 'info', 'Analyzed 19000 files containing 378.96 MB of data so far'),
	(343, 1681891921.154502, 2, 'info', 'Analyzed 19100 files containing 379.17 MB of data so far'),
	(344, 1681891930.359648, 2, 'info', 'Analyzed 19200 files containing 379.22 MB of data so far'),
	(345, 1681891940.913705, 2, 'info', 'Analyzed 19300 files containing 380.21 MB of data so far'),
	(346, 1681891951.137951, 2, 'info', 'Analyzed 19400 files containing 380.71 MB of data so far'),
	(347, 1681891986.858586, 2, 'info', 'Analyzed 19500 files containing 381.68 MB of data so far'),
	(348, 1681891996.269138, 2, 'info', 'Analyzed 19600 files containing 382.32 MB of data so far'),
	(349, 1681892004.935020, 2, 'info', 'Analyzed 19700 files containing 382.93 MB of data so far'),
	(350, 1681892013.485803, 2, 'info', 'Analyzed 19800 files containing 384.96 MB of data so far'),
	(351, 1681892022.335502, 2, 'info', 'Analyzed 19900 files containing 385.27 MB of data so far'),
	(352, 1681892058.820749, 2, 'info', 'Analyzed 20000 files containing 385.54 MB of data so far'),
	(353, 1681892068.963823, 2, 'info', 'Analyzed 20100 files containing 387.56 MB of data so far'),
	(354, 1681892078.699567, 2, 'info', 'Analyzed 20200 files containing 387.57 MB of data so far'),
	(355, 1681892087.362634, 2, 'info', 'Analyzed 20300 files containing 387.59 MB of data so far'),
	(356, 1681892095.779705, 2, 'info', 'Analyzed 20400 files containing 387.6 MB of data so far'),
	(357, 1681892131.529310, 2, 'info', 'Analyzed 20500 files containing 387.63 MB of data so far'),
	(358, 1681892141.504917, 2, 'info', 'Analyzed 20600 files containing 387.65 MB of data so far'),
	(359, 1681892151.285910, 2, 'info', 'Analyzed 20700 files containing 387.66 MB of data so far'),
	(360, 1681892159.840996, 2, 'info', 'Analyzed 20800 files containing 387.7 MB of data so far'),
	(361, 1681892194.314143, 2, 'info', 'Analyzed 20900 files containing 387.78 MB of data so far'),
	(362, 1681892204.211011, 2, 'info', 'Analyzed 21000 files containing 387.82 MB of data so far'),
	(363, 1681892214.124140, 2, 'info', 'Analyzed 21100 files containing 387.87 MB of data so far'),
	(364, 1681892224.086271, 2, 'info', 'Analyzed 21200 files containing 387.94 MB of data so far'),
	(365, 1681892232.768924, 2, 'info', 'Analyzed 21300 files containing 388.01 MB of data so far'),
	(366, 1681892268.011646, 2, 'info', 'Analyzed 21400 files containing 388.07 MB of data so far'),
	(367, 1681892277.986100, 2, 'info', 'Analyzed 21500 files containing 388.12 MB of data so far'),
	(368, 1681892287.990469, 2, 'info', 'Analyzed 21600 files containing 388.33 MB of data so far'),
	(369, 1681892298.999607, 2, 'info', 'Analyzed 21700 files containing 388.42 MB of data so far'),
	(370, 1681892308.796507, 2, 'info', 'Analyzed 21800 files containing 388.57 MB of data so far'),
	(371, 1681892341.862380, 2, 'info', 'Analyzed 21900 files containing 389.7 MB of data so far'),
	(372, 1681892348.904771, 2, 'info', 'Analyzed 22000 files containing 391.43 MB of data so far'),
	(373, 1681892355.679707, 2, 'info', 'Analyzed 22100 files containing 391.6 MB of data so far'),
	(374, 1681892362.706096, 2, 'info', 'Analyzed 22200 files containing 391.82 MB of data so far'),
	(375, 1681892369.960514, 2, 'info', 'Analyzed 22300 files containing 393.72 MB of data so far'),
	(376, 1681892377.703312, 2, 'info', 'Analyzed 22400 files containing 394.4 MB of data so far'),
	(377, 1681892411.337519, 2, 'info', 'Analyzed 22500 files containing 394.9 MB of data so far'),
	(378, 1681892421.647440, 2, 'info', 'Analyzed 22600 files containing 399.42 MB of data so far'),
	(379, 1681892431.886197, 2, 'info', 'Analyzed 22700 files containing 401.53 MB of data so far'),
	(380, 1681892441.733581, 2, 'info', 'Analyzed 22800 files containing 403.64 MB of data so far'),
	(381, 1681892451.751259, 2, 'info', 'Analyzed 22900 files containing 404.55 MB of data so far'),
	(382, 1681892487.114374, 2, 'info', 'Analyzed 23000 files containing 404.76 MB of data so far'),
	(383, 1681892495.422261, 2, 'info', 'Analyzed 23100 files containing 405.07 MB of data so far'),
	(384, 1681892503.670574, 2, 'info', 'Analyzed 23200 files containing 405.5 MB of data so far'),
	(385, 1681892513.521333, 2, 'info', 'Analyzed 23300 files containing 405.69 MB of data so far'),
	(386, 1681892523.878921, 2, 'info', 'Analyzed 23400 files containing 405.92 MB of data so far'),
	(387, 1681892559.612337, 2, 'info', 'Analyzed 23500 files containing 406.59 MB of data so far'),
	(388, 1681892569.508887, 2, 'info', 'Analyzed 23600 files containing 406.79 MB of data so far'),
	(389, 1681892578.072061, 2, 'info', 'Analyzed 23700 files containing 406.99 MB of data so far'),
	(390, 1681892586.800142, 2, 'info', 'Analyzed 23800 files containing 407.26 MB of data so far'),
	(391, 1681892595.661521, 2, 'info', 'Analyzed 23900 files containing 407.66 MB of data so far'),
	(392, 1681892631.602142, 2, 'info', 'Analyzed 24000 files containing 408.11 MB of data so far'),
	(393, 1681892641.919827, 2, 'info', 'Analyzed 24100 files containing 409.36 MB of data so far'),
	(394, 1681892651.560993, 2, 'info', 'Analyzed 24200 files containing 410.66 MB of data so far'),
	(395, 1681892659.030605, 2, 'info', 'Analyzed 24300 files containing 410.81 MB of data so far'),
	(396, 1681892666.060416, 2, 'info', 'Analyzed 24400 files containing 411.22 MB of data so far'),
	(397, 1681892702.861795, 2, 'info', 'Analyzed 24500 files containing 411.39 MB of data so far'),
	(398, 1681892712.923185, 2, 'info', 'Analyzed 24600 files containing 411.53 MB of data so far'),
	(399, 1681892723.429406, 2, 'info', 'Analyzed 24700 files containing 411.66 MB of data so far'),
	(400, 1681892734.139572, 2, 'info', 'Analyzed 24800 files containing 411.8 MB of data so far'),
	(401, 1681892768.177981, 2, 'info', 'Analyzed 24900 files containing 411.94 MB of data so far'),
	(402, 1681892778.390380, 2, 'info', 'Analyzed 25000 files containing 412.12 MB of data so far'),
	(403, 1681892789.092678, 2, 'info', 'Analyzed 25100 files containing 412.53 MB of data so far'),
	(404, 1681892799.420062, 2, 'info', 'Analyzed 25200 files containing 412.93 MB of data so far'),
	(405, 1681892809.776315, 2, 'info', 'Analyzed 25300 files containing 413.44 MB of data so far'),
	(406, 1681892844.588535, 2, 'info', 'Analyzed 25400 files containing 413.73 MB of data so far'),
	(407, 1681892853.408353, 2, 'info', 'Analyzed 25500 files containing 413.98 MB of data so far'),
	(408, 1681892862.392650, 2, 'info', 'Analyzed 25600 files containing 414.32 MB of data so far'),
	(409, 1681892872.765659, 2, 'info', 'Analyzed 25700 files containing 414.63 MB of data so far'),
	(410, 1681892908.610820, 2, 'info', 'Analyzed 25800 files containing 414.68 MB of data so far'),
	(411, 1681892918.994813, 2, 'info', 'Analyzed 25900 files containing 414.69 MB of data so far'),
	(412, 1681892928.529387, 2, 'info', 'Analyzed 26000 files containing 414.7 MB of data so far'),
	(413, 1681892937.496953, 2, 'info', 'Analyzed 26100 files containing 414.71 MB of data so far'),
	(414, 1681892946.080785, 2, 'info', 'Analyzed 26200 files containing 414.73 MB of data so far'),
	(415, 1681892979.757278, 2, 'info', 'Analyzed 26300 files containing 414.76 MB of data so far'),
	(416, 1681892989.623551, 2, 'info', 'Analyzed 26400 files containing 414.78 MB of data so far'),
	(417, 1681892999.776876, 2, 'info', 'Analyzed 26500 files containing 414.8 MB of data so far'),
	(418, 1681893017.851216, 2, 'info', 'Analyzed 26600 files containing 414.81 MB of data so far'),
	(419, 1681893055.602863, 2, 'info', 'Analyzed 26700 files containing 414.82 MB of data so far'),
	(420, 1681893064.709110, 2, 'info', 'Analyzed 26800 files containing 414.82 MB of data so far'),
	(421, 1681893073.241077, 2, 'info', 'Analyzed 26900 files containing 414.83 MB of data so far'),
	(422, 1681893081.875922, 2, 'info', 'Analyzed 27000 files containing 414.83 MB of data so far'),
	(423, 1681893091.829404, 2, 'info', 'Analyzed 27100 files containing 414.84 MB of data so far'),
	(424, 1681893127.488016, 2, 'info', 'Analyzed 27200 files containing 414.85 MB of data so far'),
	(425, 1681893138.014553, 2, 'info', 'Analyzed 27300 files containing 414.86 MB of data so far'),
	(426, 1681893147.881854, 2, 'info', 'Analyzed 27400 files containing 414.89 MB of data so far'),
	(427, 1681893156.463998, 2, 'info', 'Analyzed 27500 files containing 414.9 MB of data so far'),
	(428, 1681893165.447440, 2, 'info', 'Analyzed 27600 files containing 414.92 MB of data so far'),
	(429, 1681893201.112866, 2, 'info', 'Analyzed 27700 files containing 414.93 MB of data so far'),
	(430, 1681893211.168078, 2, 'info', 'Analyzed 27800 files containing 415.02 MB of data so far'),
	(431, 1681893221.536475, 2, 'info', 'Analyzed 27900 files containing 415.09 MB of data so far'),
	(432, 1681893232.026360, 2, 'info', 'Analyzed 28000 files containing 415.18 MB of data so far'),
	(433, 1681893266.492090, 2, 'info', 'Analyzed 28100 files containing 415.25 MB of data so far'),
	(434, 1681893275.736589, 2, 'info', 'Analyzed 28200 files containing 415.36 MB of data so far'),
	(435, 1681893286.035446, 2, 'info', 'Analyzed 28300 files containing 415.44 MB of data so far'),
	(436, 1681893296.075217, 2, 'info', 'Analyzed 28400 files containing 415.51 MB of data so far'),
	(437, 1681893306.157985, 2, 'info', 'Analyzed 28500 files containing 415.63 MB of data so far'),
	(438, 1681893342.161813, 2, 'info', 'Analyzed 28600 files containing 415.65 MB of data so far'),
	(439, 1681893351.002063, 2, 'info', 'Analyzed 28700 files containing 415.67 MB of data so far'),
	(440, 1681893359.589648, 2, 'info', 'Analyzed 28800 files containing 415.67 MB of data so far'),
	(441, 1681893369.499272, 2, 'info', 'Analyzed 28900 files containing 415.68 MB of data so far'),
	(442, 1681893380.006714, 2, 'info', 'Analyzed 29000 files containing 416.37 MB of data so far'),
	(443, 1681893416.495983, 2, 'info', 'Analyzed 29100 files containing 416.72 MB of data so far'),
	(444, 1681893426.195701, 2, 'info', 'Analyzed 29200 files containing 417.12 MB of data so far'),
	(445, 1681893434.647302, 2, 'info', 'Analyzed 29300 files containing 418.01 MB of data so far'),
	(446, 1681893443.467319, 2, 'info', 'Analyzed 29400 files containing 418.66 MB of data so far'),
	(447, 1681893453.763628, 2, 'info', 'Analyzed 29500 files containing 419.67 MB of data so far'),
	(448, 1681893489.334172, 2, 'info', 'Analyzed 29600 files containing 420.17 MB of data so far'),
	(449, 1681893499.553237, 2, 'info', 'Analyzed 29700 files containing 420.37 MB of data so far'),
	(450, 1681893509.560529, 2, 'info', 'Analyzed 29800 files containing 420.9 MB of data so far'),
	(451, 1681893519.624293, 2, 'info', 'Analyzed 29900 files containing 421.15 MB of data so far'),
	(452, 1681893554.112543, 2, 'info', 'Analyzed 30000 files containing 421.71 MB of data so far'),
	(453, 1681893564.442951, 2, 'info', 'Analyzed 30100 files containing 421.97 MB of data so far'),
	(454, 1681893574.852554, 2, 'info', 'Analyzed 30200 files containing 422.52 MB of data so far'),
	(455, 1681893582.251032, 2, 'info', 'Analyzed 30300 files containing 422.59 MB of data so far'),
	(456, 1681893589.167099, 2, 'info', 'Analyzed 30400 files containing 422.67 MB of data so far'),
	(457, 1681893622.765094, 2, 'info', 'Analyzed 30500 files containing 422.74 MB of data so far'),
	(458, 1681893632.633917, 2, 'info', 'Analyzed 30600 files containing 422.82 MB of data so far'),
	(459, 1681893642.643977, 2, 'info', 'Analyzed 30700 files containing 422.91 MB of data so far'),
	(460, 1681893653.227149, 2, 'info', 'Analyzed 30800 files containing 422.99 MB of data so far'),
	(461, 1681893663.416357, 2, 'info', 'Analyzed 30900 files containing 423.07 MB of data so far'),
	(462, 1681893697.571474, 2, 'info', 'Analyzed 31000 files containing 423.14 MB of data so far'),
	(463, 1681893706.614611, 2, 'info', 'Analyzed 31100 files containing 423.23 MB of data so far'),
	(464, 1681893715.487934, 2, 'info', 'Analyzed 31200 files containing 423.31 MB of data so far'),
	(465, 1681893725.687169, 2, 'info', 'Analyzed 31300 files containing 423.39 MB of data so far'),
	(466, 1681893735.646673, 2, 'info', 'Analyzed 31400 files containing 423.48 MB of data so far'),
	(467, 1681893772.734468, 2, 'info', 'Analyzed 31500 files containing 423.56 MB of data so far'),
	(468, 1681893782.673179, 2, 'info', 'Analyzed 31600 files containing 423.62 MB of data so far'),
	(469, 1681893791.131084, 2, 'info', 'Analyzed 31700 files containing 424.04 MB of data so far'),
	(470, 1681893799.722207, 2, 'info', 'Analyzed 31800 files containing 424.15 MB of data so far'),
	(471, 1681893808.514810, 2, 'info', 'Analyzed 31900 files containing 424.18 MB of data so far'),
	(472, 1681893844.251339, 2, 'info', 'Analyzed 32000 files containing 424.2 MB of data so far'),
	(473, 1681893854.118546, 2, 'info', 'Analyzed 32100 files containing 424.24 MB of data so far'),
	(474, 1681893864.173280, 2, 'info', 'Analyzed 32200 files containing 424.47 MB of data so far'),
	(475, 1681893873.645937, 2, 'info', 'Analyzed 32300 files containing 425.2 MB of data so far'),
	(476, 1681893908.958786, 2, 'info', 'Analyzed 32400 files containing 425.92 MB of data so far'),
	(477, 1681893920.286297, 2, 'info', 'Analyzed 32500 files containing 426.4 MB of data so far'),
	(478, 1681893930.915215, 2, 'info', 'Analyzed 32600 files containing 427.16 MB of data so far'),
	(479, 1681893941.848426, 2, 'info', 'Analyzed 32700 files containing 427.86 MB of data so far'),
	(480, 1681893952.458738, 2, 'info', 'Analyzed 32800 files containing 429.39 MB of data so far'),
	(481, 1681893986.581362, 2, 'info', 'Analyzed 32900 files containing 429.6 MB of data so far'),
	(482, 1681893995.644111, 2, 'info', 'Analyzed 33000 files containing 429.75 MB of data so far'),
	(483, 1681894005.495388, 2, 'info', 'Analyzed 33100 files containing 429.8 MB of data so far'),
	(484, 1681894016.263554, 2, 'info', 'Analyzed 33200 files containing 430.22 MB of data so far'),
	(485, 1681894052.842936, 2, 'info', 'Analyzed 33300 files containing 430.39 MB of data so far'),
	(486, 1681894061.271577, 2, 'info', 'Analyzed 33400 files containing 430.74 MB of data so far'),
	(487, 1681894069.716018, 2, 'info', 'Analyzed 33500 files containing 431.01 MB of data so far'),
	(488, 1681894078.772306, 2, 'info', 'Analyzed 33600 files containing 431.35 MB of data so far'),
	(489, 1681894088.941487, 2, 'info', 'Analyzed 33700 files containing 431.53 MB of data so far'),
	(490, 1681894125.057814, 2, 'info', 'Analyzed 33800 files containing 431.72 MB of data so far'),
	(491, 1681894135.029930, 2, 'info', 'Analyzed 33900 files containing 432.98 MB of data so far'),
	(492, 1681894142.653681, 2, 'info', 'Analyzed 34000 files containing 433.35 MB of data so far'),
	(493, 1681894149.662964, 2, 'info', 'Analyzed 34100 files containing 433.83 MB of data so far'),
	(494, 1681894156.990805, 2, 'info', 'Analyzed 34200 files containing 434 MB of data so far'),
	(495, 1681894163.976289, 2, 'info', 'Analyzed 34300 files containing 434.36 MB of data so far'),
	(496, 1681894198.711207, 2, 'info', 'Analyzed 34400 files containing 436.33 MB of data so far'),
	(497, 1681894209.049145, 2, 'info', 'Analyzed 34500 files containing 437.15 MB of data so far'),
	(498, 1681894219.158072, 2, 'info', 'Analyzed 34600 files containing 437.6 MB of data so far'),
	(499, 1681894229.169739, 2, 'info', 'Analyzed 34700 files containing 438.18 MB of data so far'),
	(500, 1681894238.199322, 2, 'info', 'Analyzed 34800 files containing 438.96 MB of data so far'),
	(501, 1681894274.105118, 2, 'info', 'Analyzed 34900 files containing 439.49 MB of data so far'),
	(502, 1681894284.224290, 2, 'info', 'Analyzed 35000 files containing 440.88 MB of data so far'),
	(503, 1681894294.260801, 2, 'info', 'Analyzed 35100 files containing 441.14 MB of data so far'),
	(504, 1681894304.444966, 2, 'info', 'Analyzed 35200 files containing 441.47 MB of data so far'),
	(505, 1681894339.115836, 2, 'info', 'Analyzed 35300 files containing 441.77 MB of data so far'),
	(506, 1681894348.360155, 2, 'info', 'Analyzed 35400 files containing 442.01 MB of data so far'),
	(507, 1681894358.777300, 2, 'info', 'Analyzed 35500 files containing 443.53 MB of data so far'),
	(508, 1681894368.707219, 2, 'info', 'Analyzed 35600 files containing 443.77 MB of data so far'),
	(509, 1681894378.778210, 2, 'info', 'Analyzed 35700 files containing 443.86 MB of data so far'),
	(510, 1681894414.096668, 2, 'info', 'Analyzed 35800 files containing 443.97 MB of data so far'),
	(511, 1681894425.972099, 2, 'info', 'Analyzed 35900 files containing 444.54 MB of data so far'),
	(512, 1681894435.107236, 2, 'info', 'Analyzed 36000 files containing 445 MB of data so far'),
	(513, 1681894445.340064, 2, 'info', 'Analyzed 36100 files containing 446.01 MB of data so far'),
	(514, 1681894481.959979, 2, 'info', 'Analyzed 36200 files containing 446.16 MB of data so far'),
	(515, 1681894490.912349, 2, 'info', 'Analyzed 36300 files containing 447.12 MB of data so far'),
	(516, 1681894499.957700, 2, 'info', 'Analyzed 36400 files containing 447.85 MB of data so far'),
	(517, 1681894508.618810, 2, 'info', 'Analyzed 36500 files containing 448.06 MB of data so far'),
	(518, 1681894518.593774, 2, 'info', 'Analyzed 36600 files containing 448.24 MB of data so far'),
	(519, 1681894555.417763, 2, 'info', 'Analyzed 36700 files containing 448.37 MB of data so far'),
	(520, 1681894565.058251, 2, 'info', 'Analyzed 36800 files containing 448.49 MB of data so far'),
	(521, 1681894573.885973, 2, 'info', 'Analyzed 36900 files containing 448.62 MB of data so far'),
	(522, 1681894582.843739, 2, 'info', 'Analyzed 37000 files containing 448.74 MB of data so far'),
	(523, 1681894593.486667, 2, 'info', 'Analyzed 37100 files containing 448.97 MB of data so far'),
	(524, 1681894628.981872, 2, 'info', 'Analyzed 37200 files containing 449.12 MB of data so far'),
	(525, 1681894638.935326, 2, 'info', 'Analyzed 37300 files containing 449.28 MB of data so far'),
	(526, 1681894647.772715, 2, 'info', 'Analyzed 37400 files containing 449.36 MB of data so far'),
	(527, 1681894656.801472, 2, 'info', 'Analyzed 37500 files containing 449.43 MB of data so far'),
	(528, 1681894693.376663, 2, 'info', 'Analyzed 37600 files containing 449.44 MB of data so far'),
	(529, 1681894703.944243, 2, 'info', 'Analyzed 37700 files containing 449.45 MB of data so far'),
	(530, 1681894714.061059, 2, 'info', 'Analyzed 37800 files containing 449.46 MB of data so far'),
	(531, 1681894722.863175, 2, 'info', 'Analyzed 37900 files containing 451.11 MB of data so far'),
	(532, 1681894732.092615, 2, 'info', 'Analyzed 38000 files containing 451.32 MB of data so far'),
	(533, 1681894767.235645, 2, 'info', 'Analyzed 38100 files containing 451.49 MB of data so far'),
	(534, 1681894777.754659, 2, 'info', 'Analyzed 38200 files containing 451.64 MB of data so far'),
	(535, 1681894788.278028, 2, 'info', 'Analyzed 38300 files containing 451.83 MB of data so far'),
	(536, 1681894797.712480, 2, 'info', 'Analyzed 38400 files containing 451.94 MB of data so far'),
	(537, 1681894806.226727, 2, 'info', 'Analyzed 38500 files containing 451.99 MB of data so far'),
	(538, 1681894841.683273, 2, 'info', 'Analyzed 38600 files containing 452 MB of data so far'),
	(539, 1681894851.809997, 2, 'info', 'Analyzed 38700 files containing 452.02 MB of data so far'),
	(540, 1681894861.980474, 2, 'info', 'Analyzed 38800 files containing 452.03 MB of data so far'),
	(541, 1681894871.959308, 2, 'info', 'Analyzed 38900 files containing 452.04 MB of data so far'),
	(542, 1681894907.291054, 2, 'info', 'Analyzed 39000 files containing 452.06 MB of data so far'),
	(543, 1681894917.330766, 2, 'info', 'Analyzed 39100 files containing 452.09 MB of data so far'),
	(544, 1681894927.227846, 2, 'info', 'Analyzed 39200 files containing 452.1 MB of data so far'),
	(545, 1681894937.604656, 2, 'info', 'Analyzed 39300 files containing 452.15 MB of data so far'),
	(546, 1681894947.980380, 2, 'info', 'Analyzed 39400 files containing 452.15 MB of data so far'),
	(547, 1681894982.739613, 2, 'info', 'Analyzed 39500 files containing 452.43 MB of data so far'),
	(548, 1681894991.766867, 2, 'info', 'Analyzed 39600 files containing 452.79 MB of data so far'),
	(549, 1681895002.143955, 2, 'info', 'Analyzed 39700 files containing 452.89 MB of data so far'),
	(550, 1681895012.335377, 2, 'info', 'Analyzed 39800 files containing 452.9 MB of data so far'),
	(551, 1681895021.895740, 2, 'info', 'Analyzed 39900 files containing 452.91 MB of data so far'),
	(552, 1681895055.841298, 2, 'info', 'Analyzed 40000 files containing 452.92 MB of data so far'),
	(553, 1681895064.424912, 2, 'info', 'Analyzed 40100 files containing 452.94 MB of data so far'),
	(554, 1681895072.714481, 2, 'info', 'Analyzed 40200 files containing 453.13 MB of data so far'),
	(555, 1681895082.707433, 2, 'info', 'Analyzed 40300 files containing 453.36 MB of data so far'),
	(556, 1681895092.700136, 2, 'info', 'Analyzed 40400 files containing 453.6 MB of data so far'),
	(557, 1681895128.838125, 2, 'info', 'Analyzed 40500 files containing 453.76 MB of data so far'),
	(558, 1681895138.815763, 2, 'info', 'Analyzed 40600 files containing 455.04 MB of data so far'),
	(559, 1681895145.904390, 2, 'info', 'Analyzed 40700 files containing 455.28 MB of data so far'),
	(560, 1681895153.352862, 2, 'info', 'Analyzed 40800 files containing 455.93 MB of data so far'),
	(561, 1681895160.375203, 2, 'info', 'Analyzed 40900 files containing 456.8 MB of data so far'),
	(562, 1681895195.371253, 2, 'info', 'Analyzed 41000 files containing 457.25 MB of data so far'),
	(563, 1681895206.332177, 2, 'info', 'Analyzed 41100 files containing 458.69 MB of data so far'),
	(564, 1681895217.446570, 2, 'info', 'Analyzed 41200 files containing 459.4 MB of data so far'),
	(565, 1681895227.748847, 2, 'info', 'Analyzed 41300 files containing 459.91 MB of data so far'),
	(566, 1681895262.591527, 2, 'info', 'Analyzed 41400 files containing 460.04 MB of data so far'),
	(567, 1681895272.685707, 2, 'info', 'Analyzed 41500 files containing 460.36 MB of data so far'),
	(568, 1681895282.789952, 2, 'info', 'Analyzed 41600 files containing 460.85 MB of data so far'),
	(569, 1681895293.093866, 2, 'info', 'Analyzed 41700 files containing 460.93 MB of data so far'),
	(570, 1681895303.919374, 2, 'info', 'Analyzed 41800 files containing 461.02 MB of data so far'),
	(571, 1681895339.823331, 2, 'info', 'Analyzed 41900 files containing 461.08 MB of data so far'),
	(572, 1681895350.230182, 2, 'info', 'Analyzed 42000 files containing 461.3 MB of data so far'),
	(573, 1681895359.057887, 2, 'info', 'Analyzed 42100 files containing 461.33 MB of data so far'),
	(574, 1681895367.735947, 2, 'info', 'Analyzed 42200 files containing 461.35 MB of data so far'),
	(575, 1681895377.341032, 2, 'info', 'Analyzed 42300 files containing 461.36 MB of data so far'),
	(576, 1681895411.032396, 2, 'info', 'Analyzed 42400 files containing 461.38 MB of data so far'),
	(577, 1681895418.466932, 2, 'info', 'Analyzed 42500 files containing 462.04 MB of data so far'),
	(578, 1681895425.581805, 2, 'info', 'Analyzed 42600 files containing 462.15 MB of data so far'),
	(579, 1681895432.578369, 2, 'info', 'Analyzed 42700 files containing 462.29 MB of data so far'),
	(580, 1681895440.148163, 2, 'info', 'Analyzed 42800 files containing 462.64 MB of data so far'),
	(581, 1681895447.148276, 2, 'info', 'Analyzed 42900 files containing 462.79 MB of data so far'),
	(582, 1681895481.656477, 2, 'info', 'Analyzed 43000 files containing 463.43 MB of data so far'),
	(583, 1681895492.280457, 2, 'info', 'Analyzed 43100 files containing 463.74 MB of data so far'),
	(584, 1681895502.825910, 2, 'info', 'Analyzed 43200 files containing 464.68 MB of data so far'),
	(585, 1681895513.437713, 2, 'info', 'Analyzed 43300 files containing 464.87 MB of data so far'),
	(586, 1681895549.211519, 2, 'info', 'Analyzed 43400 files containing 467.02 MB of data so far'),
	(587, 1681895558.391724, 2, 'info', 'Analyzed 43500 files containing 467.46 MB of data so far'),
	(588, 1681895567.940760, 2, 'info', 'Analyzed 43600 files containing 467.54 MB of data so far'),
	(589, 1681895578.165569, 2, 'info', 'Analyzed 43700 files containing 467.63 MB of data so far'),
	(590, 1681895589.144241, 2, 'info', 'Analyzed 43800 files containing 467.76 MB of data so far'),
	(591, 1681895624.873236, 2, 'info', 'Analyzed 43900 files containing 468.05 MB of data so far'),
	(592, 1681895634.107348, 2, 'info', 'Analyzed 44000 files containing 468.86 MB of data so far'),
	(593, 1681895643.080840, 2, 'info', 'Analyzed 44100 files containing 469.17 MB of data so far'),
	(594, 1681895652.586434, 2, 'info', 'Analyzed 44200 files containing 469.55 MB of data so far'),
	(595, 1681895663.459919, 2, 'info', 'Analyzed 44300 files containing 474.79 MB of data so far'),
	(596, 1681895701.141255, 2, 'info', 'Analyzed 44400 files containing 475.02 MB of data so far'),
	(597, 1681895712.574733, 2, 'info', 'Analyzed 44500 files containing 476.31 MB of data so far'),
	(598, 1681895721.463322, 2, 'info', 'Analyzed 44600 files containing 476.53 MB of data so far'),
	(599, 1681895730.628410, 2, 'info', 'Analyzed 44700 files containing 479.2 MB of data so far'),
	(600, 1681895766.846744, 2, 'info', 'Analyzed 44800 files containing 479.39 MB of data so far'),
	(601, 1681895777.690735, 2, 'info', 'Analyzed 44900 files containing 480.06 MB of data so far'),
	(602, 1681895788.251026, 2, 'info', 'Analyzed 45000 files containing 480.35 MB of data so far'),
	(603, 1681895798.919541, 2, 'info', 'Analyzed 45100 files containing 481.11 MB of data so far'),
	(604, 1681895809.954310, 2, 'info', 'Analyzed 45200 files containing 481.49 MB of data so far'),
	(605, 1681895844.603315, 2, 'info', 'Analyzed 45300 files containing 481.7 MB of data so far'),
	(606, 1681895853.713693, 2, 'info', 'Analyzed 45400 files containing 482.37 MB of data so far'),
	(607, 1681895860.887208, 2, 'info', 'Analyzed 45500 files containing 482.62 MB of data so far'),
	(608, 1681895868.444449, 2, 'info', 'Analyzed 45600 files containing 482.73 MB of data so far'),
	(609, 1681895875.669813, 2, 'info', 'Analyzed 45700 files containing 482.86 MB of data so far'),
	(610, 1681895911.164417, 2, 'info', 'Analyzed 45800 files containing 483.2 MB of data so far'),
	(611, 1681895921.227527, 2, 'info', 'Analyzed 45900 files containing 483.47 MB of data so far'),
	(612, 1681895931.312445, 2, 'info', 'Analyzed 46000 files containing 484.3 MB of data so far'),
	(613, 1681895942.044363, 2, 'info', 'Analyzed 46100 files containing 485.06 MB of data so far'),
	(614, 1681895952.392424, 2, 'info', 'Analyzed 46200 files containing 485.61 MB of data so far'),
	(615, 1681895988.245216, 2, 'info', 'Analyzed 46300 files containing 486.37 MB of data so far'),
	(616, 1681895997.795689, 2, 'info', 'Analyzed 46400 files containing 486.68 MB of data so far'),
	(617, 1681896006.798870, 2, 'info', 'Analyzed 46500 files containing 487.07 MB of data so far'),
	(618, 1681896016.854385, 2, 'info', 'Analyzed 46600 files containing 487.09 MB of data so far'),
	(619, 1681896054.670077, 2, 'info', 'Analyzed 46700 files containing 487.11 MB of data so far'),
	(620, 1681896064.901826, 2, 'info', 'Analyzed 46800 files containing 487.13 MB of data so far'),
	(621, 1681896073.419309, 2, 'info', 'Analyzed 46900 files containing 487.8 MB of data so far'),
	(622, 1681896083.252361, 2, 'info', 'Analyzed 47000 files containing 489.42 MB of data so far'),
	(623, 1681896091.877307, 2, 'info', 'Analyzed 47100 files containing 489.56 MB of data so far'),
	(624, 1681896129.099881, 2, 'info', 'Analyzed 47200 files containing 490.28 MB of data so far'),
	(625, 1681896140.517115, 2, 'info', 'Analyzed 47300 files containing 493.72 MB of data so far'),
	(626, 1681896151.235367, 2, 'info', 'Analyzed 47400 files containing 494.64 MB of data so far'),
	(627, 1681896161.174769, 2, 'info', 'Analyzed 47500 files containing 494.82 MB of data so far'),
	(628, 1681896169.525676, 2, 'info', 'Analyzed 47600 files containing 496.85 MB of data so far'),
	(629, 1681896206.270777, 2, 'info', 'Analyzed 47700 files containing 497.09 MB of data so far'),
	(630, 1681896216.434246, 2, 'info', 'Analyzed 47800 files containing 497.11 MB of data so far'),
	(631, 1681896226.270830, 2, 'info', 'Analyzed 47900 files containing 497.13 MB of data so far'),
	(632, 1681896236.536655, 2, 'info', 'Analyzed 48000 files containing 497.34 MB of data so far'),
	(633, 1681896273.308179, 2, 'info', 'Analyzed 48100 files containing 497.43 MB of data so far'),
	(634, 1681896282.189165, 2, 'info', 'Analyzed 48200 files containing 497.52 MB of data so far'),
	(635, 1681896292.437888, 2, 'info', 'Analyzed 48300 files containing 497.73 MB of data so far'),
	(636, 1681896302.234070, 2, 'info', 'Analyzed 48400 files containing 497.92 MB of data so far'),
	(637, 1681896312.296686, 2, 'info', 'Analyzed 48500 files containing 498.14 MB of data so far'),
	(638, 1681896348.981914, 2, 'info', 'Analyzed 48600 files containing 498.28 MB of data so far'),
	(639, 1681896357.347030, 2, 'info', 'Analyzed 48700 files containing 498.3 MB of data so far'),
	(640, 1681896365.911067, 2, 'info', 'Analyzed 48800 files containing 498.33 MB of data so far'),
	(641, 1681896375.454739, 2, 'info', 'Analyzed 48900 files containing 498.56 MB of data so far'),
	(642, 1681896385.693241, 2, 'info', 'Analyzed 49000 files containing 498.65 MB of data so far'),
	(643, 1681896423.133278, 2, 'info', 'Analyzed 49100 files containing 498.75 MB of data so far'),
	(644, 1681896432.691540, 2, 'info', 'Analyzed 49200 files containing 498.96 MB of data so far'),
	(645, 1681896441.656148, 2, 'info', 'Analyzed 49300 files containing 499.18 MB of data so far'),
	(646, 1681896492.047236, 2, 'info', 'Analyzed 49400 files containing 499.44 MB of data so far'),
	(647, 1681896502.770293, 2, 'info', 'Analyzed 49500 files containing 499.5 MB of data so far'),
	(648, 1681896516.061120, 2, 'info', 'Analyzed 49600 files containing 499.53 MB of data so far'),
	(649, 1681896526.720397, 2, 'info', 'Analyzed 49700 files containing 499.56 MB of data so far'),
	(650, 1681896565.705512, 2, 'info', 'Analyzed 49800 files containing 499.59 MB of data so far'),
	(651, 1681896594.546477, 2, 'info', 'Analyzed 49900 files containing 502.32 MB of data so far'),
	(652, 1681896603.374177, 2, 'info', 'Analyzed 50000 files containing 502.51 MB of data so far'),
	(653, 1681896642.065371, 2, 'info', 'Analyzed 50100 files containing 502.71 MB of data so far'),
	(654, 1681896653.969394, 2, 'info', 'Analyzed 50200 files containing 502.88 MB of data so far'),
	(655, 1681896664.771165, 2, 'info', 'Analyzed 50300 files containing 503.04 MB of data so far'),
	(656, 1681896675.250743, 2, 'info', 'Analyzed 50400 files containing 503.39 MB of data so far'),
	(657, 1681896711.365518, 2, 'info', 'Analyzed 50500 files containing 503.7 MB of data so far'),
	(658, 1681896720.317306, 2, 'info', 'Analyzed 50600 files containing 504.01 MB of data so far'),
	(659, 1681896730.391892, 2, 'info', 'Analyzed 50700 files containing 504.3 MB of data so far'),
	(660, 1681896741.286575, 2, 'info', 'Analyzed 50800 files containing 504.33 MB of data so far'),
	(661, 1681896778.908075, 2, 'info', 'Analyzed 50900 files containing 504.57 MB of data so far'),
	(662, 1681896789.734302, 2, 'info', 'Analyzed 51000 files containing 504.82 MB of data so far'),
	(663, 1681896798.881183, 2, 'info', 'Analyzed 51100 files containing 505.11 MB of data so far'),
	(664, 1681896807.785878, 2, 'info', 'Analyzed 51200 files containing 505.23 MB of data so far'),
	(665, 1681896816.995047, 2, 'info', 'Analyzed 51300 files containing 510.34 MB of data so far'),
	(666, 1681896853.299729, 2, 'info', 'Analyzed 51400 files containing 510.81 MB of data so far'),
	(667, 1681896863.969615, 2, 'info', 'Analyzed 51500 files containing 511.05 MB of data so far'),
	(668, 1681896874.478499, 2, 'info', 'Analyzed 51600 files containing 511.13 MB of data so far'),
	(669, 1681896883.587430, 2, 'info', 'Analyzed 51700 files containing 511.37 MB of data so far'),
	(670, 1681896892.228410, 2, 'info', 'Analyzed 51800 files containing 513.39 MB of data so far'),
	(671, 1681896928.068892, 2, 'info', 'Analyzed 51900 files containing 515.24 MB of data so far'),
	(672, 1681896938.508038, 2, 'info', 'Analyzed 52000 files containing 515.71 MB of data so far'),
	(673, 1681896948.821042, 2, 'info', 'Analyzed 52100 files containing 516.05 MB of data so far'),
	(674, 1681896958.912803, 2, 'info', 'Analyzed 52200 files containing 516.38 MB of data so far'),
	(675, 1681896994.894618, 2, 'info', 'Analyzed 52300 files containing 516.6 MB of data so far'),
	(676, 1681897005.150194, 2, 'info', 'Analyzed 52400 files containing 516.76 MB of data so far'),
	(677, 1681897015.524566, 2, 'info', 'Analyzed 52500 files containing 517.01 MB of data so far'),
	(678, 1681897026.172509, 2, 'info', 'Analyzed 52600 files containing 517.31 MB of data so far'),
	(679, 1681897036.149647, 2, 'info', 'Analyzed 52700 files containing 517.46 MB of data so far'),
	(680, 1681897071.679777, 2, 'info', 'Analyzed 52800 files containing 517.61 MB of data so far'),
	(681, 1681897080.418484, 2, 'info', 'Analyzed 52900 files containing 517.87 MB of data so far'),
	(682, 1681897090.545728, 2, 'info', 'Analyzed 53000 files containing 518.06 MB of data so far'),
	(683, 1681897101.189920, 2, 'info', 'Analyzed 53100 files containing 518.41 MB of data so far'),
	(684, 1681897138.707058, 2, 'info', 'Analyzed 53200 files containing 518.63 MB of data so far'),
	(685, 1681897147.321100, 2, 'info', 'Analyzed 53300 files containing 519.43 MB of data so far'),
	(686, 1681897156.347488, 2, 'info', 'Analyzed 53400 files containing 520.24 MB of data so far'),
	(687, 1681897166.121321, 2, 'info', 'Analyzed 53500 files containing 520.74 MB of data so far'),
	(688, 1681897176.214088, 2, 'info', 'Analyzed 53600 files containing 521.05 MB of data so far'),
	(689, 1681897213.616752, 2, 'info', 'Analyzed 53700 files containing 521.43 MB of data so far'),
	(690, 1681897224.720257, 2, 'info', 'Analyzed 53800 files containing 521.56 MB of data so far'),
	(691, 1681897233.171197, 2, 'info', 'Analyzed 53900 files containing 521.67 MB of data so far'),
	(692, 1681897241.745423, 2, 'info', 'Analyzed 54000 files containing 521.91 MB of data so far'),
	(693, 1681897250.729247, 2, 'info', 'Analyzed 54100 files containing 522.08 MB of data so far'),
	(694, 1681897287.990081, 2, 'info', 'Analyzed 54200 files containing 522.26 MB of data so far'),
	(695, 1681897298.357876, 2, 'info', 'Analyzed 54300 files containing 522.44 MB of data so far'),
	(696, 1681897308.233955, 2, 'info', 'Analyzed 54400 files containing 522.82 MB of data so far'),
	(697, 1681897317.634915, 2, 'info', 'Analyzed 54500 files containing 522.97 MB of data so far'),
	(698, 1681897353.672718, 2, 'info', 'Analyzed 54600 files containing 526.11 MB of data so far'),
	(699, 1681897364.689755, 2, 'info', 'Analyzed 54700 files containing 588.35 MB of data so far'),
	(700, 1681897374.825309, 2, 'info', 'Analyzed 54800 files containing 588.62 MB of data so far'),
	(701, 1681897387.016831, 2, 'info', 'Analyzed 54900 files containing 588.79 MB of data so far'),
	(702, 1681897424.158271, 2, 'info', 'Analyzed 55000 files containing 589.3 MB of data so far'),
	(703, 1681897432.599795, 2, 'info', 'Analyzed 55100 files containing 589.53 MB of data so far'),
	(704, 1681897441.369143, 2, 'info', 'Analyzed 55200 files containing 590.4 MB of data so far'),
	(705, 1681897452.637767, 2, 'info', 'Analyzed 55300 files containing 620.95 MB of data so far'),
	(706, 1681897463.790697, 2, 'info', 'Analyzed 55400 files containing 623.41 MB of data so far'),
	(707, 1681897499.079359, 2, 'info', 'Analyzed 55500 files containing 625.36 MB of data so far'),
	(708, 1681897508.934618, 2, 'info', 'Analyzed 55600 files containing 626.2 MB of data so far'),
	(709, 1681897530.317278, 2, 'info', 'Analyzed 55700 files containing 626.44 MB of data so far'),
	(710, 1681897574.414990, 2, 'info', 'Analyzed 55800 files containing 627.06 MB of data so far'),
	(711, 1681897595.219493, 2, 'info', 'Analyzed 55900 files containing 627.55 MB of data so far'),
	(712, 1681897640.415593, 2, 'info', 'Analyzed 56000 files containing 628.23 MB of data so far'),
	(713, 1681897662.083894, 2, 'info', 'Analyzed 56100 files containing 629.54 MB of data so far'),
	(714, 1681897679.831475, 2, 'info', 'Analyzed 56200 files containing 631.38 MB of data so far'),
	(715, 1681897714.546172, 2, 'info', 'Analyzed 56300 files containing 632.25 MB of data so far'),
	(716, 1681897747.906687, 2, 'info', 'Analyzed 56400 files containing 634.07 MB of data so far'),
	(717, 1681897780.789783, 2, 'info', 'Analyzed 56500 files containing 636.49 MB of data so far'),
	(718, 1681897791.195667, 2, 'info', 'Analyzed 56600 files containing 637.3 MB of data so far'),
	(719, 1681897801.744029, 2, 'info', 'Analyzed 56700 files containing 639.11 MB of data so far'),
	(720, 1681897812.084831, 2, 'info', 'Analyzed 56800 files containing 639.88 MB of data so far'),
	(721, 1681897821.606486, 2, 'info', 'Analyzed 56900 files containing 640.21 MB of data so far'),
	(722, 1681897856.062124, 2, 'info', 'Analyzed 57000 files containing 640.39 MB of data so far'),
	(723, 1681897866.147455, 2, 'info', 'Analyzed 57100 files containing 640.6 MB of data so far'),
	(724, 1681897876.526749, 2, 'info', 'Analyzed 57200 files containing 640.87 MB of data so far'),
	(725, 1681897886.729457, 2, 'info', 'Analyzed 57300 files containing 640.98 MB of data so far'),
	(726, 1681897923.284555, 2, 'info', 'Analyzed 57400 files containing 641.15 MB of data so far'),
	(727, 1681897933.191325, 2, 'info', 'Analyzed 57500 files containing 641.96 MB of data so far'),
	(728, 1681897942.100180, 2, 'info', 'Analyzed 57600 files containing 644.06 MB of data so far'),
	(729, 1681897952.187941, 2, 'info', 'Analyzed 57700 files containing 646.82 MB of data so far'),
	(730, 1681897962.734592, 2, 'info', 'Analyzed 57800 files containing 648.53 MB of data so far'),
	(731, 1681898000.691605, 2, 'info', 'Analyzed 57900 files containing 650.31 MB of data so far'),
	(732, 1681898010.111882, 2, 'info', 'Analyzed 58000 files containing 664.41 MB of data so far'),
	(733, 1681898019.035222, 2, 'info', 'Analyzed 58100 files containing 668.06 MB of data so far'),
	(734, 1681898027.523872, 2, 'info', 'Analyzed 58200 files containing 670.07 MB of data so far'),
	(735, 1681898037.054898, 2, 'info', 'Analyzed 58300 files containing 671.49 MB of data so far'),
	(736, 1681898073.716775, 2, 'info', 'Analyzed 58400 files containing 676.11 MB of data so far'),
	(737, 1681898083.677946, 2, 'info', 'Analyzed 58500 files containing 677.42 MB of data so far'),
	(738, 1681898093.679439, 2, 'info', 'Analyzed 58600 files containing 679.16 MB of data so far'),
	(739, 1681898097.481759, 2, 'info', 'Analyzed 58633 files containing 679.51 MB of data.'),
	(740, 1681898097.501659, 10, 'info', 'SUM_ENDOK:Comparing core WordPress files against originals in repository'),
	(741, 1681898097.583616, 10, 'info', 'SUM_ENDOK:Comparing open source themes against WordPress.org originals'),
	(742, 1681898097.644366, 10, 'info', 'SUM_ENDBAD:Comparing plugins against WordPress.org originals'),
	(743, 1681898097.704180, 10, 'info', 'SUM_ENDOK:Scanning for unknown files in wp-admin and wp-includes'),
	(744, 1681898097.763997, 10, 'info', 'SUM_ENDOK:Scanning for known malware files'),
	(745, 1681898097.844071, 10, 'info', 'SUM_START:Check for publicly accessible configuration files, backup files and logs'),
	(746, 1681898098.010370, 10, 'info', 'SUM_ENDOK:Check for publicly accessible configuration files, backup files and logs'),
	(747, 1681898098.127658, 10, 'info', 'SUM_START:Scanning file contents for infections and vulnerabilities'),
	(748, 1681898098.168119, 10, 'info', 'SUM_START:Scanning file contents for URLs on a domain blocklist'),
	(749, 1681898101.048743, 2, 'info', 'Starting scan of file contents'),
	(750, 1681898102.157721, 2, 'info', 'Scanned contents of 12 additional files at 11.69 per second'),
	(751, 1681898103.179248, 2, 'info', 'Scanned contents of 32 additional files at 15.63 per second'),
	(752, 1681898104.219173, 2, 'info', 'Scanned contents of 51 additional files at 16.52 per second'),
	(753, 1681898105.239889, 2, 'info', 'Scanned contents of 72 additional files at 17.52 per second'),
	(754, 1681898106.249068, 2, 'info', 'Scanned contents of 92 additional files at 17.98 per second'),
	(755, 1681898107.302029, 2, 'info', 'Scanned contents of 106 additional files at 17.18 per second'),
	(756, 1681898108.331166, 2, 'info', 'Scanned contents of 125 additional files at 17.36 per second'),
	(757, 1681898109.374458, 2, 'info', 'Scanned contents of 147 additional files at 17.83 per second'),
	(758, 1681898110.389627, 2, 'info', 'Scanned contents of 164 additional files at 17.71 per second'),
	(759, 1681898111.414737, 2, 'info', 'Scanned contents of 184 additional files at 17.89 per second'),
	(760, 1681898137.358669, 2, 'info', 'Scanned contents of 196 additional files at 5.41 per second'),
	(761, 1681898138.419844, 2, 'info', 'Scanned contents of 213 additional files at 5.71 per second'),
	(762, 1681898139.421289, 2, 'info', 'Scanned contents of 228 additional files at 5.95 per second'),
	(763, 1681898140.475912, 2, 'info', 'Scanned contents of 244 additional files at 6.20 per second'),
	(764, 1681898141.502673, 2, 'info', 'Scanned contents of 262 additional files at 6.49 per second'),
	(765, 1681898142.534930, 2, 'info', 'Scanned contents of 278 additional files at 6.71 per second'),
	(766, 1681898143.566614, 2, 'info', 'Scanned contents of 294 additional files at 6.93 per second'),
	(767, 1681898144.578412, 2, 'info', 'Scanned contents of 303 additional files at 6.97 per second'),
	(768, 1681898145.590243, 2, 'info', 'Scanned contents of 320 additional files at 7.20 per second'),
	(769, 1681898146.644168, 2, 'info', 'Scanned contents of 338 additional files at 7.43 per second'),
	(770, 1681898147.681622, 2, 'info', 'Scanned contents of 355 additional files at 7.63 per second'),
	(771, 1681898148.737390, 2, 'info', 'Scanned contents of 374 additional files at 7.86 per second'),
	(772, 1681898149.790638, 2, 'info', 'Scanned contents of 392 additional files at 8.06 per second'),
	(773, 1681898150.845230, 2, 'info', 'Scanned contents of 406 additional files at 8.17 per second'),
	(774, 1681898151.877220, 2, 'info', 'Scanned contents of 417 additional files at 8.22 per second'),
	(775, 1681898152.914138, 2, 'info', 'Scanned contents of 430 additional files at 8.30 per second'),
	(776, 1681898153.953940, 2, 'info', 'Scanned contents of 447 additional files at 8.46 per second'),
	(777, 1681898154.975385, 2, 'info', 'Scanned contents of 464 additional files at 8.62 per second'),
	(778, 1681898156.009945, 2, 'info', 'Scanned contents of 482 additional files at 8.78 per second'),
	(779, 1681898157.045271, 2, 'info', 'Scanned contents of 497 additional files at 8.89 per second'),
	(780, 1681898157.190679, 1, 'info', '-------------------'),
	(781, 1681898157.240488, 1, 'info', 'Scan interrupted. Scanned 58633 files, 65 plugins, 5 themes, 0 posts, 0 comments and 0 URLs in 3 hours 1 second.'),
	(782, 1681898157.264802, 10, 'info', 'SUM_FINAL:Scan interrupted. You have 2 new issues to fix. See below.'),
	(783, 1681898170.513678, 2, 'info', 'Wordfence used 60 MB of memory for scan. Server peak memory usage was: 124 MB'),
	(784, 1681898170.528571, 2, 'error', 'Scan terminated with error: The scan time limit of 3 hours has been exceeded and the scan will be terminated. This limit can be customized on the options page. <a href="https://www.wordfence.com/help/?query=scan-time-limit" target="_blank" rel="noopener noreferrer">Get More Information<span class="screen-reader-text"> (opens in new tab)</span></a>'),
	(785, 1688176071.570259, 1, 'info', 'Scan stop request received.'),
	(786, 1688176071.594014, 10, 'info', 'SUM_KILLED:A request was received to stop the previous scan.');

-- Dumping structure for таблиця db.hadpj_wftrafficrates
CREATE TABLE IF NOT EXISTS `hadpj_wftrafficrates` (
  `eMin` int(10) unsigned NOT NULL,
  `IP` binary(16) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `hitType` enum('hit','404') NOT NULL DEFAULT 'hit',
  `hits` int(10) unsigned NOT NULL,
  PRIMARY KEY (`eMin`,`IP`,`hitType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wftrafficrates: ~0 rows (приблизно)
DELETE FROM `hadpj_wftrafficrates`;

-- Dumping structure for таблиця db.hadpj_wfwaffailures
CREATE TABLE IF NOT EXISTS `hadpj_wfwaffailures` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `throwable` text NOT NULL,
  `rule_id` int(10) unsigned DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- Dumping data for table db.hadpj_wfwaffailures: ~0 rows (приблизно)
DELETE FROM `hadpj_wfwaffailures`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
