-- MariaDB dump 10.19  Distrib 10.11.10-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: db
-- ------------------------------------------------------
-- Server version	10.11.10-MariaDB-ubu2204-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `hadpj_aiowps_audit_log`
--

DROP TABLE IF EXISTS `hadpj_aiowps_audit_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_aiowps_audit_log` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_aiowps_audit_log`
--

LOCK TABLES `hadpj_aiowps_audit_log` WRITE;
/*!40000 ALTER TABLE `hadpj_aiowps_audit_log` DISABLE KEYS */;
INSERT INTO `hadpj_aiowps_audit_log` VALUES
(1,1,1,'aparserok','127.0.0.1','info','theme_updated','Theme: Twenty Twenty-One  updated (v1.8)','a:10:{i:0;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:308;s:8:\"function\";s:12:\"record_event\";s:5:\"class\";s:33:\"AIOWPSecurity_Audit_Event_Handler\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:3:{i:0;s:13:\"theme_updated\";i:1;s:40:\"Theme: Twenty Twenty-One  updated (v1.8)\";i:2;s:4:\"info\";}}i:1;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:332;s:8:\"function\";s:13:\"apply_filters\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:2:{i:0;s:0:\"\";i:1;a:3:{i:0;s:13:\"theme_updated\";i:1;s:40:\"Theme: Twenty Twenty-One  updated (v1.8)\";i:2;s:4:\"info\";}}}i:2;a:6:{s:4:\"file\";s:48:\"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php\";s:4:\"line\";i:517;s:8:\"function\";s:9:\"do_action\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:3;a:4:{s:4:\"file\";s:117:\"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php\";s:4:\"line\";i:285;s:8:\"function\";s:9:\"do_action\";s:4:\"args\";a:4:{i:0;s:19:\"aiowps_record_event\";i:1;s:13:\"theme_updated\";i:2;s:40:\"Theme: Twenty Twenty-One  updated (v1.8)\";i:3;s:4:\"info\";}}i:4;a:6:{s:4:\"file\";s:117:\"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php\";s:4:\"line\";i:227;s:8:\"function\";s:19:\"event_theme_changed\";s:5:\"class\";s:26:\"AIOWPSecurity_Audit_Events\";s:4:\"type\";s:2:\"::\";s:4:\"args\";a:3:{i:0;s:7:\"updated\";i:1;s:15:\"twentytwentyone\";i:2;s:0:\"\";}}i:5;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:308;s:8:\"function\";s:13:\"theme_updated\";s:5:\"class\";s:26:\"AIOWPSecurity_Audit_Events\";s:4:\"type\";s:2:\"::\";s:4:\"args\";a:1:{i:0;s:14:\"Theme_Upgrader\";}}i:6;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:332;s:8:\"function\";s:13:\"apply_filters\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:7;a:6:{s:4:\"file\";s:48:\"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php\";s:4:\"line\";i:517;s:8:\"function\";s:9:\"do_action\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:8;a:4:{s:4:\"file\";s:68:\"C:\\Works\\Web\\wp-framework\\wp-admin\\includes\\class-theme-upgrader.php\";s:4:\"line\";i:472;s:8:\"function\";s:9:\"do_action\";s:4:\"args\";a:3:{i:0;s:25:\"upgrader_process_complete\";i:1;O:14:\"Theme_Upgrader\":7:{s:6:\"result\";a:7:{s:6:\"source\";s:81:\"C:/Works/Web/wp-framework/wp-content/upgrade/twentytwentytwo.1.4/twentytwentytwo/\";s:12:\"source_files\";a:11:{i:0;s:6:\"assets\";i:1;s:13:\"functions.php\";i:2;s:3:\"inc\";i:3;s:9:\"index.php\";i:4;s:5:\"parts\";i:5;s:10:\"readme.txt\";i:6;s:14:\"screenshot.png\";i:7;s:9:\"style.css\";i:8;s:6:\"styles\";i:9;s:9:\"templates\";i:10;s:10:\"theme.json\";}s:11:\"destination\";s:60:\"C:\\Works\\Web\\wp-framework/wp-content/themes/twentytwentytwo/\";s:16:\"destination_name\";s:15:\"twentytwentytwo\";s:17:\"local_destination\";s:43:\"C:\\Works\\Web\\wp-framework/wp-content/themes\";s:18:\"remote_destination\";s:60:\"C:/Works/Web/wp-framework/wp-content/themes/twentytwentytwo/\";s:17:\"clear_destination\";b:1;}s:4:\"bulk\";b:1;s:14:\"new_theme_data\";a:0:{}s:7:\"strings\";a:31:{s:18:\"skin_upgrade_start\";s:98:\"The update process is starting. This process may take a while on some hosts, so please be patient.\";s:24:\"skin_update_failed_error\";s:43:\"An error occurred while updating %1$s: %2$s\";s:18:\"skin_update_failed\";s:24:\"The update of %s failed.\";s:22:\"skin_update_successful\";s:24:\"%s updated successfully.\";s:16:\"skin_upgrade_end\";s:32:\"All updates have been completed.\";s:25:\"skin_before_update_header\";s:31:\"Updating Theme %1$s (%2$d/%3$d)\";s:11:\"bad_request\";s:22:\"Invalid data provided.\";s:14:\"fs_unavailable\";s:28:\"Could not access filesystem.\";s:8:\"fs_error\";s:17:\"Filesystem error.\";s:14:\"fs_no_root_dir\";s:42:\"Unable to locate WordPress root directory.\";s:17:\"fs_no_content_dir\";s:58:\"Unable to locate WordPress content directory (wp-content).\";s:17:\"fs_no_plugins_dir\";s:44:\"Unable to locate WordPress plugin directory.\";s:16:\"fs_no_themes_dir\";s:43:\"Unable to locate WordPress theme directory.\";s:12:\"fs_no_folder\";s:36:\"Unable to locate needed folder (%s).\";s:15:\"download_failed\";s:16:\"Download failed.\";s:18:\"installing_package\";s:36:\"Installing the latest version&#8230;\";s:8:\"no_files\";s:30:\"The package contains no files.\";s:13:\"folder_exists\";s:34:\"Destination folder already exists.\";s:12:\"mkdir_failed\";s:27:\"Could not create directory.\";s:20:\"incompatible_archive\";s:35:\"The package could not be installed.\";s:18:\"files_not_writable\";s:124:\"The update cannot be installed because some files could not be copied. This is usually due to inconsistent file permissions.\";s:17:\"maintenance_start\";s:32:\"Enabling Maintenance mode&#8230;\";s:15:\"maintenance_end\";s:33:\"Disabling Maintenance mode&#8230;\";s:10:\"up_to_date\";s:35:\"The theme is at the latest version.\";s:10:\"no_package\";s:29:\"Update package not available.\";s:19:\"downloading_package\";s:59:\"Downloading update from <span class=\"code\">%s</span>&#8230;\";s:14:\"unpack_package\";s:27:\"Unpacking the update&#8230;\";s:10:\"remove_old\";s:44:\"Removing the old version of the theme&#8230;\";s:17:\"remove_old_failed\";s:31:\"Could not remove the old theme.\";s:14:\"process_failed\";s:20:\"Theme update failed.\";s:15:\"process_success\";s:27:\"Theme updated successfully.\";}s:4:\"skin\";O:24:\"Bulk_Theme_Upgrader_Skin\":8:{s:10:\"theme_info\";O:8:\"WP_Theme\":13:{s:6:\"update\";b:0;s:20:\"\0WP_Theme\0theme_root\";s:43:\"C:\\Works\\Web\\wp-framework/wp-content/themes\";s:17:\"\0WP_Theme\0headers\";a:14:{s:4:\"Name\";s:17:\"Twenty Twenty-Two\";s:8:\"ThemeURI\";s:45:\"https://wordpress.org/themes/twentytwentytwo/\";s:11:\"Description\";s:939:\"Built on a solidly designed foundation, Twenty Twenty-Two embraces the idea that everyone deserves a truly unique website. The theme‚Äôs subtle styles are inspired by the diversity and versatility of birds: its typography is lightweight yet strong, its color palette is drawn from nature, and its layout elements sit gently on the page. The true richness of Twenty Twenty-Two lies in its opportunity for customization. The theme is built to take advantage of the Full Site Editing features introduced in WordPress 5.9, which means that colors, typography, and the layout of every single page on your site can be customized to suit your vision. It also includes dozens of block patterns, opening the door to a wide range of professionally designed layouts in just a few clicks. Whether you‚Äôre building a single-page website, a blog, a business website, or a portfolio, Twenty Twenty-Two will help you create a site that is uniquely yours.\";s:6:\"Author\";s:18:\"the WordPress team\";s:9:\"AuthorURI\";s:22:\"https://wordpress.org/\";s:7:\"Version\";s:3:\"1.2\";s:8:\"Template\";s:0:\"\";s:6:\"Status\";s:0:\"\";s:4:\"Tags\";s:171:\"one-column, custom-colors, custom-menu, custom-logo, editor-style, featured-images, full-site-editing, block-patterns, rtl-language-support, sticky-post, threaded-comments\";s:10:\"TextDomain\";s:15:\"twentytwentytwo\";s:10:\"DomainPath\";s:0:\"\";s:10:\"RequiresWP\";s:3:\"5.9\";s:11:\"RequiresPHP\";s:3:\"5.6\";s:9:\"UpdateURI\";s:0:\"\";}s:27:\"\0WP_Theme\0headers_sanitized\";a:3:{s:4:\"Name\";s:17:\"Twenty Twenty-Two\";s:10:\"TextDomain\";s:15:\"twentytwentytwo\";s:10:\"DomainPath\";s:0:\"\";}s:21:\"\0WP_Theme\0block_theme\";b:1;s:25:\"\0WP_Theme\0name_translated\";N;s:16:\"\0WP_Theme\0errors\";N;s:20:\"\0WP_Theme\0stylesheet\";s:15:\"twentytwentytwo\";s:18:\"\0WP_Theme\0template\";s:15:\"twentytwentytwo\";s:16:\"\0WP_Theme\0parent\";N;s:24:\"\0WP_Theme\0theme_root_uri\";N;s:27:\"\0WP_Theme\0textdomain_loaded\";b:0;s:20:\"\0WP_Theme\0cache_hash\";s:32:\"0feca0ad8dfdb6266c757e92676771ed\";}s:7:\"in_loop\";b:0;s:5:\"error\";b:0;s:8:\"upgrader\";r:81;s:11:\"done_header\";b:0;s:11:\"done_footer\";b:0;s:6:\"result\";a:7:{s:6:\"source\";s:81:\"C:/Works/Web/wp-framework/wp-content/upgrade/twentytwentytwo.1.4/twentytwentytwo/\";s:12:\"source_files\";a:11:{i:0;s:6:\"assets\";i:1;s:13:\"functions.php\";i:2;s:3:\"inc\";i:3;s:9:\"index.php\";i:4;s:5:\"parts\";i:5;s:10:\"readme.txt\";i:6;s:14:\"screenshot.png\";i:7;s:9:\"style.css\";i:8;s:6:\"styles\";i:9;s:9:\"templates\";i:10;s:10:\"theme.json\";}s:11:\"destination\";s:60:\"C:\\Works\\Web\\wp-framework/wp-content/themes/twentytwentytwo/\";s:16:\"destination_name\";s:15:\"twentytwentytwo\";s:17:\"local_destination\";s:43:\"C:\\Works\\Web\\wp-framework/wp-content/themes\";s:18:\"remote_destination\";s:60:\"C:/Works/Web/wp-framework/wp-content/themes/twentytwentytwo/\";s:17:\"clear_destination\";b:1;}s:7:\"options\";a:4:{s:3:\"url\";s:85:\"update.php?action=update-selected-themes&amp;themes=twentytwentyone%2Ctwentytwentytwo\";s:5:\"nonce\";s:18:\"bulk-update-themes\";s:5:\"title\";s:0:\"\";s:7:\"context\";b:0;}}s:12:\"update_count\";i:2;s:14:\"update_current\";i:2;}i:2;a:4:{s:6:\"action\";s:6:\"update\";s:4:\"type\";s:5:\"theme\";s:4:\"bulk\";b:1;s:6:\"themes\";a:2:{i:0;s:15:\"twentytwentyone\";i:1;s:15:\"twentytwentytwo\";}}}}i:9;a:6:{s:4:\"file\";s:45:\"C:\\Works\\Web\\wp-framework\\wp-admin\\update.php\";s:4:\"line\";i:252;s:8:\"function\";s:12:\"bulk_upgrade\";s:5:\"class\";s:14:\"Theme_Upgrader\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}}',1681885020),
(2,1,1,'aparserok','127.0.0.1','warning','plugin_deleted','Plugin: ACF 5 Pro JSON Storage  deleted (v1.0.0)','a:14:{i:0;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:308;s:8:\"function\";s:12:\"record_event\";s:5:\"class\";s:33:\"AIOWPSecurity_Audit_Event_Handler\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:3:{i:0;s:14:\"plugin_deleted\";i:1;s:48:\"Plugin: ACF 5 Pro JSON Storage  deleted (v1.0.0)\";i:2;s:7:\"warning\";}}i:1;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:332;s:8:\"function\";s:13:\"apply_filters\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:2:{i:0;s:0:\"\";i:1;a:3:{i:0;s:14:\"plugin_deleted\";i:1;s:48:\"Plugin: ACF 5 Pro JSON Storage  deleted (v1.0.0)\";i:2;s:7:\"warning\";}}}i:2;a:6:{s:4:\"file\";s:48:\"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php\";s:4:\"line\";i:517;s:8:\"function\";s:9:\"do_action\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:3;a:4:{s:4:\"file\";s:117:\"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php\";s:4:\"line\";i:183;s:8:\"function\";s:9:\"do_action\";s:4:\"args\";a:4:{i:0;s:19:\"aiowps_record_event\";i:1;s:14:\"plugin_deleted\";i:2;s:48:\"Plugin: ACF 5 Pro JSON Storage  deleted (v1.0.0)\";i:3;s:7:\"warning\";}}i:4;a:6:{s:4:\"file\";s:117:\"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php\";s:4:\"line\";i:155;s:8:\"function\";s:20:\"event_plugin_changed\";s:5:\"class\";s:26:\"AIOWPSecurity_Audit_Events\";s:4:\"type\";s:2:\"::\";s:4:\"args\";a:4:{i:0;s:7:\"deleted\";i:1;s:45:\"acf-5-pro-json-storage/acf-5-json-storage.php\";i:2;s:0:\"\";i:3;s:7:\"warning\";}}i:5;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:308;s:8:\"function\";s:14:\"plugin_deleted\";s:5:\"class\";s:26:\"AIOWPSecurity_Audit_Events\";s:4:\"type\";s:2:\"::\";s:4:\"args\";a:2:{i:0;s:45:\"acf-5-pro-json-storage/acf-5-json-storage.php\";i:1;b:1;}}i:6;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:332;s:8:\"function\";s:13:\"apply_filters\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:2:{i:0;s:0:\"\";i:1;a:2:{i:0;s:45:\"acf-5-pro-json-storage/acf-5-json-storage.php\";i:1;b:1;}}}i:7;a:6:{s:4:\"file\";s:48:\"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php\";s:4:\"line\";i:517;s:8:\"function\";s:9:\"do_action\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:8;a:4:{s:4:\"file\";s:54:\"C:\\Works\\Web\\wp-framework\\wp-admin\\includes\\plugin.php\";s:4:\"line\";i:988;s:8:\"function\";s:9:\"do_action\";s:4:\"args\";a:3:{i:0;s:14:\"deleted_plugin\";i:1;s:45:\"acf-5-pro-json-storage/acf-5-json-storage.php\";i:2;b:1;}}i:9;a:4:{s:4:\"file\";s:60:\"C:\\Works\\Web\\wp-framework\\wp-admin\\includes\\ajax-actions.php\";s:4:\"line\";i:4701;s:8:\"function\";s:14:\"delete_plugins\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:10;a:4:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:308;s:8:\"function\";s:21:\"wp_ajax_delete_plugin\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:11;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:332;s:8:\"function\";s:13:\"apply_filters\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:2:{i:0;s:0:\"\";i:1;a:1:{i:0;s:0:\"\";}}}i:12;a:6:{s:4:\"file\";s:48:\"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php\";s:4:\"line\";i:517;s:8:\"function\";s:9:\"do_action\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:13;a:4:{s:4:\"file\";s:49:\"C:\\Works\\Web\\wp-framework\\wp-admin\\admin-ajax.php\";s:4:\"line\";i:188;s:8:\"function\";s:9:\"do_action\";s:4:\"args\";a:1:{i:0;s:21:\"wp_ajax_delete-plugin\";}}}',1681885624),
(3,1,1,'aparserok','127.0.0.1','info','plugin_activated','Plugin: Advanced Custom Fields PRO  activated (v5.12.3)','a:10:{i:0;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:308;s:8:\"function\";s:12:\"record_event\";s:5:\"class\";s:33:\"AIOWPSecurity_Audit_Event_Handler\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:3:{i:0;s:16:\"plugin_activated\";i:1;s:55:\"Plugin: Advanced Custom Fields PRO  activated (v5.12.3)\";i:2;s:4:\"info\";}}i:1;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:332;s:8:\"function\";s:13:\"apply_filters\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:2:{i:0;s:0:\"\";i:1;a:3:{i:0;s:16:\"plugin_activated\";i:1;s:55:\"Plugin: Advanced Custom Fields PRO  activated (v5.12.3)\";i:2;s:4:\"info\";}}}i:2;a:6:{s:4:\"file\";s:48:\"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php\";s:4:\"line\";i:517;s:8:\"function\";s:9:\"do_action\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:3;a:4:{s:4:\"file\";s:117:\"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php\";s:4:\"line\";i:183;s:8:\"function\";s:9:\"do_action\";s:4:\"args\";a:4:{i:0;s:19:\"aiowps_record_event\";i:1;s:16:\"plugin_activated\";i:2;s:55:\"Plugin: Advanced Custom Fields PRO  activated (v5.12.3)\";i:3;s:4:\"info\";}}i:4;a:6:{s:4:\"file\";s:117:\"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php\";s:4:\"line\";i:98;s:8:\"function\";s:20:\"event_plugin_changed\";s:5:\"class\";s:26:\"AIOWPSecurity_Audit_Events\";s:4:\"type\";s:2:\"::\";s:4:\"args\";a:3:{i:0;s:9:\"activated\";i:1;s:34:\"advanced-custom-fields-pro/acf.php\";i:2;s:0:\"\";}}i:5;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:308;s:8:\"function\";s:16:\"plugin_activated\";s:5:\"class\";s:26:\"AIOWPSecurity_Audit_Events\";s:4:\"type\";s:2:\"::\";s:4:\"args\";a:2:{i:0;s:34:\"advanced-custom-fields-pro/acf.php\";i:1;b:0;}}i:6;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:332;s:8:\"function\";s:13:\"apply_filters\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:2:{i:0;s:0:\"\";i:1;a:2:{i:0;s:34:\"advanced-custom-fields-pro/acf.php\";i:1;b:0;}}}i:7;a:6:{s:4:\"file\";s:48:\"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php\";s:4:\"line\";i:517;s:8:\"function\";s:9:\"do_action\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:8;a:4:{s:4:\"file\";s:54:\"C:\\Works\\Web\\wp-framework\\wp-admin\\includes\\plugin.php\";s:4:\"line\";i:718;s:8:\"function\";s:9:\"do_action\";s:4:\"args\";a:3:{i:0;s:16:\"activated_plugin\";i:1;s:34:\"advanced-custom-fields-pro/acf.php\";i:2;b:0;}}i:9;a:4:{s:4:\"file\";s:46:\"C:\\Works\\Web\\wp-framework\\wp-admin\\plugins.php\";s:4:\"line\";i:58;s:8:\"function\";s:15:\"activate_plugin\";s:4:\"args\";a:3:{i:0;s:34:\"advanced-custom-fields-pro/acf.php\";i:1;s:98:\"https://wpeb.ddev.site/wp-admin/plugins.php?error=true&plugin=advanced-custom-fields-pro%2Facf.php\";i:2;b:0;}}}',1681885627),
(4,1,1,'aparserok','127.0.0.1','warning','plugin_deleted','Plugin: Akismet Anti-Spam: Spam Protection  deleted (v5.1)','a:14:{i:0;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:308;s:8:\"function\";s:12:\"record_event\";s:5:\"class\";s:33:\"AIOWPSecurity_Audit_Event_Handler\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:3:{i:0;s:14:\"plugin_deleted\";i:1;s:58:\"Plugin: Akismet Anti-Spam: Spam Protection  deleted (v5.1)\";i:2;s:7:\"warning\";}}i:1;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:332;s:8:\"function\";s:13:\"apply_filters\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:2:{i:0;s:0:\"\";i:1;a:3:{i:0;s:14:\"plugin_deleted\";i:1;s:58:\"Plugin: Akismet Anti-Spam: Spam Protection  deleted (v5.1)\";i:2;s:7:\"warning\";}}}i:2;a:6:{s:4:\"file\";s:48:\"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php\";s:4:\"line\";i:517;s:8:\"function\";s:9:\"do_action\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:3;a:4:{s:4:\"file\";s:117:\"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php\";s:4:\"line\";i:183;s:8:\"function\";s:9:\"do_action\";s:4:\"args\";a:4:{i:0;s:19:\"aiowps_record_event\";i:1;s:14:\"plugin_deleted\";i:2;s:58:\"Plugin: Akismet Anti-Spam: Spam Protection  deleted (v5.1)\";i:3;s:7:\"warning\";}}i:4;a:6:{s:4:\"file\";s:117:\"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php\";s:4:\"line\";i:155;s:8:\"function\";s:20:\"event_plugin_changed\";s:5:\"class\";s:26:\"AIOWPSecurity_Audit_Events\";s:4:\"type\";s:2:\"::\";s:4:\"args\";a:4:{i:0;s:7:\"deleted\";i:1;s:19:\"akismet/akismet.php\";i:2;s:0:\"\";i:3;s:7:\"warning\";}}i:5;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:308;s:8:\"function\";s:14:\"plugin_deleted\";s:5:\"class\";s:26:\"AIOWPSecurity_Audit_Events\";s:4:\"type\";s:2:\"::\";s:4:\"args\";a:2:{i:0;s:19:\"akismet/akismet.php\";i:1;b:1;}}i:6;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:332;s:8:\"function\";s:13:\"apply_filters\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:2:{i:0;s:0:\"\";i:1;a:2:{i:0;s:19:\"akismet/akismet.php\";i:1;b:1;}}}i:7;a:6:{s:4:\"file\";s:48:\"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php\";s:4:\"line\";i:517;s:8:\"function\";s:9:\"do_action\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:8;a:4:{s:4:\"file\";s:54:\"C:\\Works\\Web\\wp-framework\\wp-admin\\includes\\plugin.php\";s:4:\"line\";i:988;s:8:\"function\";s:9:\"do_action\";s:4:\"args\";a:3:{i:0;s:14:\"deleted_plugin\";i:1;s:19:\"akismet/akismet.php\";i:2;b:1;}}i:9;a:4:{s:4:\"file\";s:60:\"C:\\Works\\Web\\wp-framework\\wp-admin\\includes\\ajax-actions.php\";s:4:\"line\";i:4701;s:8:\"function\";s:14:\"delete_plugins\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:10;a:4:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:308;s:8:\"function\";s:21:\"wp_ajax_delete_plugin\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:11;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:332;s:8:\"function\";s:13:\"apply_filters\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:2:{i:0;s:0:\"\";i:1;a:1:{i:0;s:0:\"\";}}}i:12;a:6:{s:4:\"file\";s:48:\"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php\";s:4:\"line\";i:517;s:8:\"function\";s:9:\"do_action\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:13;a:4:{s:4:\"file\";s:49:\"C:\\Works\\Web\\wp-framework\\wp-admin\\admin-ajax.php\";s:4:\"line\";i:188;s:8:\"function\";s:9:\"do_action\";s:4:\"args\";a:1:{i:0;s:21:\"wp_ajax_delete-plugin\";}}}',1681885636),
(5,1,1,'aparserok','127.0.0.1','warning','plugin_deactivated','Plugin: All In One WP Security  deactivated (v5.1.7)','a:10:{i:0;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:308;s:8:\"function\";s:12:\"record_event\";s:5:\"class\";s:33:\"AIOWPSecurity_Audit_Event_Handler\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:3:{i:0;s:18:\"plugin_deactivated\";i:1;s:52:\"Plugin: All In One WP Security  deactivated (v5.1.7)\";i:2;s:7:\"warning\";}}i:1;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:332;s:8:\"function\";s:13:\"apply_filters\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:2:{i:0;s:0:\"\";i:1;a:3:{i:0;s:18:\"plugin_deactivated\";i:1;s:52:\"Plugin: All In One WP Security  deactivated (v5.1.7)\";i:2;s:7:\"warning\";}}}i:2;a:6:{s:4:\"file\";s:48:\"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php\";s:4:\"line\";i:517;s:8:\"function\";s:9:\"do_action\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:3;a:4:{s:4:\"file\";s:117:\"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php\";s:4:\"line\";i:183;s:8:\"function\";s:9:\"do_action\";s:4:\"args\";a:4:{i:0;s:19:\"aiowps_record_event\";i:1;s:18:\"plugin_deactivated\";i:2;s:52:\"Plugin: All In One WP Security  deactivated (v5.1.7)\";i:3;s:7:\"warning\";}}i:4;a:6:{s:4:\"file\";s:117:\"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\all-in-one-wp-security-and-firewall\\classes\\wp-security-audit-events.php\";s:4:\"line\";i:129;s:8:\"function\";s:20:\"event_plugin_changed\";s:5:\"class\";s:26:\"AIOWPSecurity_Audit_Events\";s:4:\"type\";s:2:\"::\";s:4:\"args\";a:4:{i:0;s:11:\"deactivated\";i:1;s:51:\"all-in-one-wp-security-and-firewall/wp-security.php\";i:2;s:0:\"\";i:3;s:7:\"warning\";}}i:5;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:308;s:8:\"function\";s:18:\"plugin_deactivated\";s:5:\"class\";s:26:\"AIOWPSecurity_Audit_Events\";s:4:\"type\";s:2:\"::\";s:4:\"args\";a:2:{i:0;s:51:\"all-in-one-wp-security-and-firewall/wp-security.php\";i:1;b:0;}}i:6;a:6:{s:4:\"file\";s:55:\"C:\\Works\\Web\\wp-framework\\wp-includes\\class-wp-hook.php\";s:4:\"line\";i:332;s:8:\"function\";s:13:\"apply_filters\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:2:{i:0;s:0:\"\";i:1;a:2:{i:0;s:51:\"all-in-one-wp-security-and-firewall/wp-security.php\";i:1;b:0;}}}i:7;a:6:{s:4:\"file\";s:48:\"C:\\Works\\Web\\wp-framework\\wp-includes\\plugin.php\";s:4:\"line\";i:517;s:8:\"function\";s:9:\"do_action\";s:5:\"class\";s:7:\"WP_Hook\";s:4:\"type\";s:2:\"->\";s:4:\"args\";a:1:{i:0;s:0:\"\";}}i:8;a:4:{s:4:\"file\";s:54:\"C:\\Works\\Web\\wp-framework\\wp-admin\\includes\\plugin.php\";s:4:\"line\";i:828;s:8:\"function\";s:9:\"do_action\";s:4:\"args\";a:3:{i:0;s:18:\"deactivated_plugin\";i:1;s:51:\"all-in-one-wp-security-and-firewall/wp-security.php\";i:2;b:0;}}i:9;a:4:{s:4:\"file\";s:46:\"C:\\Works\\Web\\wp-framework\\wp-admin\\plugins.php\";s:4:\"line\";i:209;s:8:\"function\";s:18:\"deactivate_plugins\";s:4:\"args\";a:3:{i:0;s:51:\"all-in-one-wp-security-and-firewall/wp-security.php\";i:1;b:0;i:2;b:0;}}}',1681885642);
/*!40000 ALTER TABLE `hadpj_aiowps_audit_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_aiowps_debug_log`
--

DROP TABLE IF EXISTS `hadpj_aiowps_debug_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_aiowps_debug_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `level` varchar(25) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `type` varchar(25) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_aiowps_debug_log`
--

LOCK TABLES `hadpj_aiowps_debug_log` WRITE;
/*!40000 ALTER TABLE `hadpj_aiowps_debug_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_aiowps_debug_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_aiowps_events`
--

DROP TABLE IF EXISTS `hadpj_aiowps_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_aiowps_events` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_aiowps_events`
--

LOCK TABLES `hadpj_aiowps_events` WRITE;
/*!40000 ALTER TABLE `hadpj_aiowps_events` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_aiowps_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_aiowps_failed_logins`
--

DROP TABLE IF EXISTS `hadpj_aiowps_failed_logins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_aiowps_failed_logins` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_aiowps_failed_logins`
--

LOCK TABLES `hadpj_aiowps_failed_logins` WRITE;
/*!40000 ALTER TABLE `hadpj_aiowps_failed_logins` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_aiowps_failed_logins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_aiowps_global_meta`
--

DROP TABLE IF EXISTS `hadpj_aiowps_global_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_aiowps_global_meta` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_aiowps_global_meta`
--

LOCK TABLES `hadpj_aiowps_global_meta` WRITE;
/*!40000 ALTER TABLE `hadpj_aiowps_global_meta` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_aiowps_global_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_aiowps_login_activity`
--

DROP TABLE IF EXISTS `hadpj_aiowps_login_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_aiowps_login_activity` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_aiowps_login_activity`
--

LOCK TABLES `hadpj_aiowps_login_activity` WRITE;
/*!40000 ALTER TABLE `hadpj_aiowps_login_activity` DISABLE KEYS */;
INSERT INTO `hadpj_aiowps_login_activity` VALUES
(1,2,'aparserok','2022-08-03 08:51:58','1000-10-10 10:00:00','127.0.0.1','',''),
(2,2,'aparserok','2022-08-25 20:37:58','1000-10-10 10:00:00','195.34.204.242','',''),
(3,2,'aparserok','2023-04-19 08:55:24','1000-10-10 10:00:00','178.74.236.195','','');
/*!40000 ALTER TABLE `hadpj_aiowps_login_activity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_aiowps_login_lockdown`
--

DROP TABLE IF EXISTS `hadpj_aiowps_login_lockdown`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_aiowps_login_lockdown` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_aiowps_login_lockdown`
--

LOCK TABLES `hadpj_aiowps_login_lockdown` WRITE;
/*!40000 ALTER TABLE `hadpj_aiowps_login_lockdown` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_aiowps_login_lockdown` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_aiowps_permanent_block`
--

DROP TABLE IF EXISTS `hadpj_aiowps_permanent_block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_aiowps_permanent_block` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `blocked_ip` varchar(100) NOT NULL DEFAULT '',
  `block_reason` varchar(128) NOT NULL DEFAULT '',
  `country_origin` varchar(50) NOT NULL DEFAULT '',
  `blocked_date` datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
  `unblock` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `blocked_ip` (`blocked_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_aiowps_permanent_block`
--

LOCK TABLES `hadpj_aiowps_permanent_block` WRITE;
/*!40000 ALTER TABLE `hadpj_aiowps_permanent_block` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_aiowps_permanent_block` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_commentmeta`
--

DROP TABLE IF EXISTS `hadpj_commentmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`meta_key`,`comment_id`,`meta_id`),
  UNIQUE KEY `meta_id` (`meta_id`),
  KEY `comment_id` (`comment_id`,`meta_key`,`meta_value`(32)),
  KEY `meta_value` (`meta_value`(32))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_commentmeta`
--

LOCK TABLES `hadpj_commentmeta` WRITE;
/*!40000 ALTER TABLE `hadpj_commentmeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_commentmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_comments`
--

DROP TABLE IF EXISTS `hadpj_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_comments` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_comments`
--

LOCK TABLES `hadpj_comments` WRITE;
/*!40000 ALTER TABLE `hadpj_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_db7_forms`
--

DROP TABLE IF EXISTS `hadpj_db7_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_db7_forms` (
  `form_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `form_post_id` bigint(20) NOT NULL,
  `form_value` longtext NOT NULL,
  `form_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_db7_forms`
--

LOCK TABLES `hadpj_db7_forms` WRITE;
/*!40000 ALTER TABLE `hadpj_db7_forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_db7_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_links`
--

DROP TABLE IF EXISTS `hadpj_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_links` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_links`
--

LOCK TABLES `hadpj_links` WRITE;
/*!40000 ALTER TABLE `hadpj_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_options`
--

DROP TABLE IF EXISTS `hadpj_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) NOT NULL,
  `option_value` longtext NOT NULL,
  `autoload` varchar(20) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_name`),
  UNIQUE KEY `option_id` (`option_id`),
  KEY `autoload` (`autoload`)
) ENGINE=InnoDB AUTO_INCREMENT=2995 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_options`
--

LOCK TABLES `hadpj_options` WRITE;
/*!40000 ALTER TABLE `hadpj_options` DISABLE KEYS */;
INSERT INTO `hadpj_options` VALUES
(2986,'_site_transient_browser_40b65ea82f99d9ae2d2769173a01ce1b','a:10:{s:4:\"name\";s:6:\"Chrome\";s:7:\"version\";s:9:\"132.0.0.0\";s:8:\"platform\";s:7:\"Windows\";s:10:\"update_url\";s:29:\"https://www.google.com/chrome\";s:7:\"img_src\";s:43:\"http://s.w.org/images/browsers/chrome.png?1\";s:11:\"img_src_ssl\";s:44:\"https://s.w.org/images/browsers/chrome.png?1\";s:15:\"current_version\";s:2:\"18\";s:7:\"upgrade\";b:0;s:8:\"insecure\";b:0;s:6:\"mobile\";b:0;}','off'),
(2982,'_site_transient_php_check_fe7d39417db7b9047896cfef373da8f7','a:5:{s:19:\"recommended_version\";s:3:\"7.4\";s:15:\"minimum_version\";s:6:\"7.2.24\";s:12:\"is_supported\";b:1;s:9:\"is_secure\";b:1;s:13:\"is_acceptable\";b:1;}','off'),
(2978,'_site_transient_theme_roots','a:5:{s:19:\"axio-starter-master\";s:7:\"/themes\";s:16:\"twentytwentyfive\";s:7:\"/themes\";s:16:\"twentytwentyfour\";s:7:\"/themes\";s:15:\"twentytwentyone\";s:7:\"/themes\";s:7:\"wp-wpeb\";s:7:\"/themes\";}','off'),
(2985,'_site_transient_timeout_browser_40b65ea82f99d9ae2d2769173a01ce1b','1734564844','off'),
(2981,'_site_transient_timeout_php_check_fe7d39417db7b9047896cfef373da8f7','1734564842','off'),
(2977,'_site_transient_timeout_theme_roots','1733961900','off'),
(2993,'_site_transient_timeout_wp_theme_files_patterns-a64be370c6a53d17a10b356f6e90c147','1733962126','off'),
(2989,'_site_transient_update_core','O:8:\"stdClass\":4:{s:7:\"updates\";a:1:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:6:\"latest\";s:8:\"download\";s:59:\"https://downloads.wordpress.org/release/wordpress-6.7.1.zip\";s:6:\"locale\";s:5:\"en_US\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:59:\"https://downloads.wordpress.org/release/wordpress-6.7.1.zip\";s:10:\"no_content\";s:70:\"https://downloads.wordpress.org/release/wordpress-6.7.1-no-content.zip\";s:11:\"new_bundled\";s:71:\"https://downloads.wordpress.org/release/wordpress-6.7.1-new-bundled.zip\";s:7:\"partial\";s:0:\"\";s:8:\"rollback\";s:0:\"\";}s:7:\"current\";s:5:\"6.7.1\";s:7:\"version\";s:5:\"6.7.1\";s:11:\"php_version\";s:6:\"7.2.24\";s:13:\"mysql_version\";s:5:\"5.5.5\";s:11:\"new_bundled\";s:3:\"6.7\";s:15:\"partial_version\";s:0:\"\";}}s:12:\"last_checked\";i:1733960310;s:15:\"version_checked\";s:5:\"6.7.1\";s:12:\"translations\";a:0:{}}','off'),
(2991,'_site_transient_update_plugins','O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1733960327;s:8:\"response\";a:0:{}s:12:\"translations\";a:0:{}s:9:\"no_update\";a:49:{s:41:\"acf-code-generator/acf_code_generator.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:32:\"w.org/plugins/acf-code-generator\";s:4:\"slug\";s:18:\"acf-code-generator\";s:6:\"plugin\";s:41:\"acf-code-generator/acf_code_generator.php\";s:11:\"new_version\";s:5:\"1.0.2\";s:3:\"url\";s:49:\"https://wordpress.org/plugins/acf-code-generator/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/acf-code-generator.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:71:\"https://ps.w.org/acf-code-generator/assets/icon-256x256.png?rev=2513505\";s:2:\"1x\";s:71:\"https://ps.w.org/acf-code-generator/assets/icon-256x256.png?rev=2513505\";}s:7:\"banners\";a:0:{}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.0\";}s:29:\"acf-extended/acf-extended.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:26:\"w.org/plugins/acf-extended\";s:4:\"slug\";s:12:\"acf-extended\";s:6:\"plugin\";s:29:\"acf-extended/acf-extended.php\";s:11:\"new_version\";s:7:\"0.9.0.9\";s:3:\"url\";s:43:\"https://wordpress.org/plugins/acf-extended/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/acf-extended.0.9.0.9.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:65:\"https://ps.w.org/acf-extended/assets/icon-256x256.png?rev=2071550\";s:2:\"1x\";s:65:\"https://ps.w.org/acf-extended/assets/icon-128x128.png?rev=2071550\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:68:\"https://ps.w.org/acf-extended/assets/banner-1544x500.png?rev=2071550\";s:2:\"1x\";s:67:\"https://ps.w.org/acf-extended/assets/banner-772x250.png?rev=2071550\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.9\";}s:51:\"all-in-one-wp-migration/all-in-one-wp-migration.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:37:\"w.org/plugins/all-in-one-wp-migration\";s:4:\"slug\";s:23:\"all-in-one-wp-migration\";s:6:\"plugin\";s:51:\"all-in-one-wp-migration/all-in-one-wp-migration.php\";s:11:\"new_version\";s:4:\"7.87\";s:3:\"url\";s:54:\"https://wordpress.org/plugins/all-in-one-wp-migration/\";s:7:\"package\";s:71:\"https://downloads.wordpress.org/plugin/all-in-one-wp-migration.7.87.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:76:\"https://ps.w.org/all-in-one-wp-migration/assets/icon-256x256.png?rev=2458334\";s:2:\"1x\";s:76:\"https://ps.w.org/all-in-one-wp-migration/assets/icon-128x128.png?rev=2458334\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:79:\"https://ps.w.org/all-in-one-wp-migration/assets/banner-1544x500.png?rev=3194978\";s:2:\"1x\";s:78:\"https://ps.w.org/all-in-one-wp-migration/assets/banner-772x250.png?rev=3194978\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"3.3\";}s:51:\"all-in-one-wp-security-and-firewall/wp-security.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:49:\"w.org/plugins/all-in-one-wp-security-and-firewall\";s:4:\"slug\";s:35:\"all-in-one-wp-security-and-firewall\";s:6:\"plugin\";s:51:\"all-in-one-wp-security-and-firewall/wp-security.php\";s:11:\"new_version\";s:5:\"5.3.7\";s:3:\"url\";s:66:\"https://wordpress.org/plugins/all-in-one-wp-security-and-firewall/\";s:7:\"package\";s:84:\"https://downloads.wordpress.org/plugin/all-in-one-wp-security-and-firewall.5.3.7.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:88:\"https://ps.w.org/all-in-one-wp-security-and-firewall/assets/icon-256x256.png?rev=2798307\";s:2:\"1x\";s:88:\"https://ps.w.org/all-in-one-wp-security-and-firewall/assets/icon-128x128.png?rev=2798307\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:91:\"https://ps.w.org/all-in-one-wp-security-and-firewall/assets/banner-1544x500.png?rev=2798307\";s:2:\"1x\";s:90:\"https://ps.w.org/all-in-one-wp-security-and-firewall/assets/banner-772x250.png?rev=2798307\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.0\";}s:43:\"broken-link-checker/broken-link-checker.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:33:\"w.org/plugins/broken-link-checker\";s:4:\"slug\";s:19:\"broken-link-checker\";s:6:\"plugin\";s:43:\"broken-link-checker/broken-link-checker.php\";s:11:\"new_version\";s:5:\"2.4.2\";s:3:\"url\";s:50:\"https://wordpress.org/plugins/broken-link-checker/\";s:7:\"package\";s:68:\"https://downloads.wordpress.org/plugin/broken-link-checker.2.4.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:72:\"https://ps.w.org/broken-link-checker/assets/icon-256x256.png?rev=2900468\";s:2:\"1x\";s:72:\"https://ps.w.org/broken-link-checker/assets/icon-128x128.png?rev=2900468\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:75:\"https://ps.w.org/broken-link-checker/assets/banner-1544x500.png?rev=2900471\";s:2:\"1x\";s:74:\"https://ps.w.org/broken-link-checker/assets/banner-772x250.png?rev=2900471\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.2\";}s:39:\"bulk-page-creator/bulk-page-creator.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:31:\"w.org/plugins/bulk-page-creator\";s:4:\"slug\";s:17:\"bulk-page-creator\";s:6:\"plugin\";s:39:\"bulk-page-creator/bulk-page-creator.php\";s:11:\"new_version\";s:5:\"1.1.4\";s:3:\"url\";s:48:\"https://wordpress.org/plugins/bulk-page-creator/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/bulk-page-creator.zip\";s:5:\"icons\";a:1:{s:7:\"default\";s:61:\"https://s.w.org/plugins/geopattern-icon/bulk-page-creator.svg\";}s:7:\"banners\";a:0:{}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"3.1\";}s:53:\"child-theme-configurator/child-theme-configurator.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:38:\"w.org/plugins/child-theme-configurator\";s:4:\"slug\";s:24:\"child-theme-configurator\";s:6:\"plugin\";s:53:\"child-theme-configurator/child-theme-configurator.php\";s:11:\"new_version\";s:5:\"2.6.6\";s:3:\"url\";s:55:\"https://wordpress.org/plugins/child-theme-configurator/\";s:7:\"package\";s:73:\"https://downloads.wordpress.org/plugin/child-theme-configurator.2.6.6.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:77:\"https://ps.w.org/child-theme-configurator/assets/icon-128x128.png?rev=1557885\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:79:\"https://ps.w.org/child-theme-configurator/assets/banner-772x250.jpg?rev=1557885\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.0\";}s:41:\"child-theme-wizard/child-theme-wizard.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:32:\"w.org/plugins/child-theme-wizard\";s:4:\"slug\";s:18:\"child-theme-wizard\";s:6:\"plugin\";s:41:\"child-theme-wizard/child-theme-wizard.php\";s:11:\"new_version\";s:3:\"1.4\";s:3:\"url\";s:49:\"https://wordpress.org/plugins/child-theme-wizard/\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/plugin/child-theme-wizard.1.4.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:70:\"https://ps.w.org/child-theme-wizard/assets/icon-256x256.png?rev=984426\";s:2:\"1x\";s:70:\"https://ps.w.org/child-theme-wizard/assets/icon-128x128.png?rev=984426\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:73:\"https://ps.w.org/child-theme-wizard/assets/banner-1544x500.png?rev=984451\";s:2:\"1x\";s:72:\"https://ps.w.org/child-theme-wizard/assets/banner-772x250.png?rev=984451\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"3.4\";}s:33:\"classic-editor/classic-editor.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:28:\"w.org/plugins/classic-editor\";s:4:\"slug\";s:14:\"classic-editor\";s:6:\"plugin\";s:33:\"classic-editor/classic-editor.php\";s:11:\"new_version\";s:5:\"1.6.7\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/classic-editor/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/classic-editor.1.6.7.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/classic-editor/assets/icon-256x256.png?rev=1998671\";s:2:\"1x\";s:67:\"https://ps.w.org/classic-editor/assets/icon-128x128.png?rev=1998671\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:70:\"https://ps.w.org/classic-editor/assets/banner-1544x500.png?rev=1998671\";s:2:\"1x\";s:69:\"https://ps.w.org/classic-editor/assets/banner-772x250.png?rev=1998676\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.9\";}s:35:\"classic-widgets/classic-widgets.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:29:\"w.org/plugins/classic-widgets\";s:4:\"slug\";s:15:\"classic-widgets\";s:6:\"plugin\";s:35:\"classic-widgets/classic-widgets.php\";s:11:\"new_version\";s:3:\"0.3\";s:3:\"url\";s:46:\"https://wordpress.org/plugins/classic-widgets/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/plugin/classic-widgets.0.3.zip\";s:5:\"icons\";a:1:{s:7:\"default\";s:59:\"https://s.w.org/plugins/geopattern-icon/classic-widgets.svg\";}s:7:\"banners\";a:0:{}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.9\";}s:33:\"complianz-gdpr/complianz-gpdr.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:28:\"w.org/plugins/complianz-gdpr\";s:4:\"slug\";s:14:\"complianz-gdpr\";s:6:\"plugin\";s:33:\"complianz-gdpr/complianz-gpdr.php\";s:11:\"new_version\";s:5:\"7.1.5\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/complianz-gdpr/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/complianz-gdpr.7.1.5.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/complianz-gdpr/assets/icon-256x256.png?rev=2881064\";s:2:\"1x\";s:67:\"https://ps.w.org/complianz-gdpr/assets/icon-128x128.png?rev=2881064\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:70:\"https://ps.w.org/complianz-gdpr/assets/banner-1544x500.png?rev=2881064\";s:2:\"1x\";s:69:\"https://ps.w.org/complianz-gdpr/assets/banner-772x250.png?rev=2881064\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.9\";}s:36:\"contact-form-7/wp-contact-form-7.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:28:\"w.org/plugins/contact-form-7\";s:4:\"slug\";s:14:\"contact-form-7\";s:6:\"plugin\";s:36:\"contact-form-7/wp-contact-form-7.php\";s:11:\"new_version\";s:5:\"6.0.1\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/contact-form-7/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/contact-form-7.6.0.1.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:59:\"https://ps.w.org/contact-form-7/assets/icon.svg?rev=2339255\";s:3:\"svg\";s:59:\"https://ps.w.org/contact-form-7/assets/icon.svg?rev=2339255\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:69:\"https://ps.w.org/contact-form-7/assets/banner-1544x500.png?rev=860901\";s:2:\"1x\";s:68:\"https://ps.w.org/contact-form-7/assets/banner-772x250.png?rev=880427\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.6\";}s:42:\"contact-form-cfdb7/contact-form-cfdb-7.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:32:\"w.org/plugins/contact-form-cfdb7\";s:4:\"slug\";s:18:\"contact-form-cfdb7\";s:6:\"plugin\";s:42:\"contact-form-cfdb7/contact-form-cfdb-7.php\";s:11:\"new_version\";s:6:\"1.2.10\";s:3:\"url\";s:49:\"https://wordpress.org/plugins/contact-form-cfdb7/\";s:7:\"package\";s:68:\"https://downloads.wordpress.org/plugin/contact-form-cfdb7.1.2.10.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:71:\"https://ps.w.org/contact-form-cfdb7/assets/icon-256x256.png?rev=1619878\";s:2:\"1x\";s:71:\"https://ps.w.org/contact-form-cfdb7/assets/icon-128x128.png?rev=1619878\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:73:\"https://ps.w.org/contact-form-cfdb7/assets/banner-772x250.png?rev=1619902\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.8\";}s:53:\"customizer-export-import/customizer-export-import.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:38:\"w.org/plugins/customizer-export-import\";s:4:\"slug\";s:24:\"customizer-export-import\";s:6:\"plugin\";s:53:\"customizer-export-import/customizer-export-import.php\";s:11:\"new_version\";s:7:\"0.9.7.3\";s:3:\"url\";s:55:\"https://wordpress.org/plugins/customizer-export-import/\";s:7:\"package\";s:75:\"https://downloads.wordpress.org/plugin/customizer-export-import.0.9.7.3.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:77:\"https://ps.w.org/customizer-export-import/assets/icon-256x256.jpg?rev=1049984\";s:2:\"1x\";s:77:\"https://ps.w.org/customizer-export-import/assets/icon-128x128.jpg?rev=1049984\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:79:\"https://ps.w.org/customizer-export-import/assets/banner-772x250.jpg?rev=1049984\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"3.6\";}s:43:\"custom-post-type-ui/custom-post-type-ui.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:33:\"w.org/plugins/custom-post-type-ui\";s:4:\"slug\";s:19:\"custom-post-type-ui\";s:6:\"plugin\";s:43:\"custom-post-type-ui/custom-post-type-ui.php\";s:11:\"new_version\";s:6:\"1.17.2\";s:3:\"url\";s:50:\"https://wordpress.org/plugins/custom-post-type-ui/\";s:7:\"package\";s:69:\"https://downloads.wordpress.org/plugin/custom-post-type-ui.1.17.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:72:\"https://ps.w.org/custom-post-type-ui/assets/icon-256x256.png?rev=2744389\";s:2:\"1x\";s:72:\"https://ps.w.org/custom-post-type-ui/assets/icon-128x128.png?rev=2744389\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:75:\"https://ps.w.org/custom-post-type-ui/assets/banner-1544x500.png?rev=2744389\";s:2:\"1x\";s:74:\"https://ps.w.org/custom-post-type-ui/assets/banner-772x250.png?rev=2744389\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.5\";}s:39:\"https-redirection/https-redirection.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:31:\"w.org/plugins/https-redirection\";s:4:\"slug\";s:17:\"https-redirection\";s:6:\"plugin\";s:39:\"https-redirection/https-redirection.php\";s:11:\"new_version\";s:5:\"1.9.2\";s:3:\"url\";s:48:\"https://wordpress.org/plugins/https-redirection/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/https-redirection.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:70:\"https://ps.w.org/https-redirection/assets/icon-128x128.png?rev=1779143\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:72:\"https://ps.w.org/https-redirection/assets/banner-772x250.png?rev=1779143\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.5\";}s:45:\"enable-svg-webp-ico-upload/itc-svg-upload.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:40:\"w.org/plugins/enable-svg-webp-ico-upload\";s:4:\"slug\";s:26:\"enable-svg-webp-ico-upload\";s:6:\"plugin\";s:45:\"enable-svg-webp-ico-upload/itc-svg-upload.php\";s:11:\"new_version\";s:5:\"1.1.2\";s:3:\"url\";s:57:\"https://wordpress.org/plugins/enable-svg-webp-ico-upload/\";s:7:\"package\";s:75:\"https://downloads.wordpress.org/plugin/enable-svg-webp-ico-upload.1.1.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:79:\"https://ps.w.org/enable-svg-webp-ico-upload/assets/icon-256x256.png?rev=2510822\";s:2:\"1x\";s:79:\"https://ps.w.org/enable-svg-webp-ico-upload/assets/icon-256x256.png?rev=2510822\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:81:\"https://ps.w.org/enable-svg-webp-ico-upload/assets/banner-772x250.png?rev=2510822\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.7\";}s:25:\"auto-sizes/auto-sizes.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:24:\"w.org/plugins/auto-sizes\";s:4:\"slug\";s:10:\"auto-sizes\";s:6:\"plugin\";s:25:\"auto-sizes/auto-sizes.php\";s:11:\"new_version\";s:5:\"1.3.0\";s:3:\"url\";s:41:\"https://wordpress.org/plugins/auto-sizes/\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/plugin/auto-sizes.1.3.0.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:55:\"https://ps.w.org/auto-sizes/assets/icon.svg?rev=3098222\";s:3:\"svg\";s:55:\"https://ps.w.org/auto-sizes/assets/icon.svg?rev=3098222\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:66:\"https://ps.w.org/auto-sizes/assets/banner-1544x500.png?rev=3098222\";s:2:\"1x\";s:65:\"https://ps.w.org/auto-sizes/assets/banner-772x250.png?rev=3098222\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.5\";}s:45:\"ewww-image-optimizer/ewww-image-optimizer.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:34:\"w.org/plugins/ewww-image-optimizer\";s:4:\"slug\";s:20:\"ewww-image-optimizer\";s:6:\"plugin\";s:45:\"ewww-image-optimizer/ewww-image-optimizer.php\";s:11:\"new_version\";s:5:\"8.0.0\";s:3:\"url\";s:51:\"https://wordpress.org/plugins/ewww-image-optimizer/\";s:7:\"package\";s:69:\"https://downloads.wordpress.org/plugin/ewww-image-optimizer.8.0.0.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:73:\"https://ps.w.org/ewww-image-optimizer/assets/icon-256x256.png?rev=1582276\";s:2:\"1x\";s:73:\"https://ps.w.org/ewww-image-optimizer/assets/icon-128x128.png?rev=1582276\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:76:\"https://ps.w.org/ewww-image-optimizer/assets/banner-1544x500.jpg?rev=1582276\";s:2:\"1x\";s:75:\"https://ps.w.org/ewww-image-optimizer/assets/banner-772x250.jpg?rev=1582276\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.4\";}s:25:\"fakerpress/fakerpress.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:24:\"w.org/plugins/fakerpress\";s:4:\"slug\";s:10:\"fakerpress\";s:6:\"plugin\";s:25:\"fakerpress/fakerpress.php\";s:11:\"new_version\";s:5:\"0.6.6\";s:3:\"url\";s:41:\"https://wordpress.org/plugins/fakerpress/\";s:7:\"package\";s:59:\"https://downloads.wordpress.org/plugin/fakerpress.0.6.6.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:55:\"https://ps.w.org/fakerpress/assets/icon.svg?rev=1846090\";s:3:\"svg\";s:55:\"https://ps.w.org/fakerpress/assets/icon.svg?rev=1846090\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:66:\"https://ps.w.org/fakerpress/assets/banner-1544x500.png?rev=1152002\";s:2:\"1x\";s:65:\"https://ps.w.org/fakerpress/assets/banner-772x250.png?rev=1152002\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.5\";}s:29:\"health-check/health-check.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:26:\"w.org/plugins/health-check\";s:4:\"slug\";s:12:\"health-check\";s:6:\"plugin\";s:29:\"health-check/health-check.php\";s:11:\"new_version\";s:5:\"1.7.1\";s:3:\"url\";s:43:\"https://wordpress.org/plugins/health-check/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/health-check.1.7.1.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:57:\"https://ps.w.org/health-check/assets/icon.svg?rev=1828244\";s:3:\"svg\";s:57:\"https://ps.w.org/health-check/assets/icon.svg?rev=1828244\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:68:\"https://ps.w.org/health-check/assets/banner-1544x500.png?rev=1823210\";s:2:\"1x\";s:67:\"https://ps.w.org/health-check/assets/banner-772x250.png?rev=1823210\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.4\";}s:36:\"contact-form-7-honeypot/honeypot.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:37:\"w.org/plugins/contact-form-7-honeypot\";s:4:\"slug\";s:23:\"contact-form-7-honeypot\";s:6:\"plugin\";s:36:\"contact-form-7-honeypot/honeypot.php\";s:11:\"new_version\";s:5:\"2.1.7\";s:3:\"url\";s:54:\"https://wordpress.org/plugins/contact-form-7-honeypot/\";s:7:\"package\";s:72:\"https://downloads.wordpress.org/plugin/contact-form-7-honeypot.2.1.7.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:76:\"https://ps.w.org/contact-form-7-honeypot/assets/icon-256x256.png?rev=2487322\";s:2:\"1x\";s:76:\"https://ps.w.org/contact-form-7-honeypot/assets/icon-128x128.png?rev=2487322\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:79:\"https://ps.w.org/contact-form-7-honeypot/assets/banner-1544x500.png?rev=3139486\";s:2:\"1x\";s:78:\"https://ps.w.org/contact-form-7-honeypot/assets/banner-772x250.png?rev=3139486\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.8\";}s:29:\"http-headers/http-headers.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:26:\"w.org/plugins/http-headers\";s:4:\"slug\";s:12:\"http-headers\";s:6:\"plugin\";s:29:\"http-headers/http-headers.php\";s:11:\"new_version\";s:6:\"1.19.1\";s:3:\"url\";s:43:\"https://wordpress.org/plugins/http-headers/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/plugin/http-headers.1.19.1.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:65:\"https://ps.w.org/http-headers/assets/icon-128x128.png?rev=1413576\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:67:\"https://ps.w.org/http-headers/assets/banner-772x250.jpg?rev=1413577\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"3.2\";}s:30:\"dominant-color-images/load.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:35:\"w.org/plugins/dominant-color-images\";s:4:\"slug\";s:21:\"dominant-color-images\";s:6:\"plugin\";s:30:\"dominant-color-images/load.php\";s:11:\"new_version\";s:5:\"1.1.2\";s:3:\"url\";s:52:\"https://wordpress.org/plugins/dominant-color-images/\";s:7:\"package\";s:70:\"https://downloads.wordpress.org/plugin/dominant-color-images.1.1.2.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:66:\"https://ps.w.org/dominant-color-images/assets/icon.svg?rev=3098225\";s:3:\"svg\";s:66:\"https://ps.w.org/dominant-color-images/assets/icon.svg?rev=3098225\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:77:\"https://ps.w.org/dominant-color-images/assets/banner-1544x500.png?rev=3098225\";s:2:\"1x\";s:76:\"https://ps.w.org/dominant-color-images/assets/banner-772x250.png?rev=3098225\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.5\";}s:53:\"index-wp-mysql-for-speed/index-wp-mysql-for-speed.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:38:\"w.org/plugins/index-wp-mysql-for-speed\";s:4:\"slug\";s:24:\"index-wp-mysql-for-speed\";s:6:\"plugin\";s:53:\"index-wp-mysql-for-speed/index-wp-mysql-for-speed.php\";s:11:\"new_version\";s:5:\"1.5.2\";s:3:\"url\";s:55:\"https://wordpress.org/plugins/index-wp-mysql-for-speed/\";s:7:\"package\";s:73:\"https://downloads.wordpress.org/plugin/index-wp-mysql-for-speed.1.5.2.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:77:\"https://ps.w.org/index-wp-mysql-for-speed/assets/icon-128x128.png?rev=2652667\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:79:\"https://ps.w.org/index-wp-mysql-for-speed/assets/banner-772x250.png?rev=2652667\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.2\";}s:35:\"litespeed-cache/litespeed-cache.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:29:\"w.org/plugins/litespeed-cache\";s:4:\"slug\";s:15:\"litespeed-cache\";s:6:\"plugin\";s:35:\"litespeed-cache/litespeed-cache.php\";s:11:\"new_version\";s:5:\"6.5.3\";s:3:\"url\";s:46:\"https://wordpress.org/plugins/litespeed-cache/\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/plugin/litespeed-cache.6.5.3.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:68:\"https://ps.w.org/litespeed-cache/assets/icon-256x256.png?rev=2554181\";s:2:\"1x\";s:68:\"https://ps.w.org/litespeed-cache/assets/icon-128x128.png?rev=2554181\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:71:\"https://ps.w.org/litespeed-cache/assets/banner-1544x500.png?rev=2554181\";s:2:\"1x\";s:70:\"https://ps.w.org/litespeed-cache/assets/banner-772x250.png?rev=2554181\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.9\";}s:21:\"webp-uploads/load.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:26:\"w.org/plugins/webp-uploads\";s:4:\"slug\";s:12:\"webp-uploads\";s:6:\"plugin\";s:21:\"webp-uploads/load.php\";s:11:\"new_version\";s:5:\"2.3.0\";s:3:\"url\";s:43:\"https://wordpress.org/plugins/webp-uploads/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/webp-uploads.2.3.0.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:57:\"https://ps.w.org/webp-uploads/assets/icon.svg?rev=3098226\";s:3:\"svg\";s:57:\"https://ps.w.org/webp-uploads/assets/icon.svg?rev=3098226\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:68:\"https://ps.w.org/webp-uploads/assets/banner-1544x500.png?rev=3098226\";s:2:\"1x\";s:67:\"https://ps.w.org/webp-uploads/assets/banner-772x250.png?rev=3098226\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.5\";}s:24:\"performance-lab/load.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:29:\"w.org/plugins/performance-lab\";s:4:\"slug\";s:15:\"performance-lab\";s:6:\"plugin\";s:24:\"performance-lab/load.php\";s:11:\"new_version\";s:5:\"3.6.1\";s:3:\"url\";s:46:\"https://wordpress.org/plugins/performance-lab/\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/plugin/performance-lab.3.6.1.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:60:\"https://ps.w.org/performance-lab/assets/icon.svg?rev=2787149\";s:3:\"svg\";s:60:\"https://ps.w.org/performance-lab/assets/icon.svg?rev=2787149\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:71:\"https://ps.w.org/performance-lab/assets/banner-1544x500.png?rev=3098881\";s:2:\"1x\";s:70:\"https://ps.w.org/performance-lab/assets/banner-772x250.png?rev=3098881\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.5\";}s:45:\"performance-profiler/performance-profiler.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:34:\"w.org/plugins/performance-profiler\";s:4:\"slug\";s:20:\"performance-profiler\";s:6:\"plugin\";s:45:\"performance-profiler/performance-profiler.php\";s:11:\"new_version\";s:5:\"0.1.0\";s:3:\"url\";s:51:\"https://wordpress.org/plugins/performance-profiler/\";s:7:\"package\";s:69:\"https://downloads.wordpress.org/plugin/performance-profiler.0.1.0.zip\";s:5:\"icons\";a:1:{s:7:\"default\";s:64:\"https://s.w.org/plugins/geopattern-icon/performance-profiler.svg\";}s:7:\"banners\";a:0:{}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.0\";}s:51:\"performant-translations/performant-translations.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:37:\"w.org/plugins/performant-translations\";s:4:\"slug\";s:23:\"performant-translations\";s:6:\"plugin\";s:51:\"performant-translations/performant-translations.php\";s:11:\"new_version\";s:5:\"1.2.0\";s:3:\"url\";s:54:\"https://wordpress.org/plugins/performant-translations/\";s:7:\"package\";s:72:\"https://downloads.wordpress.org/plugin/performant-translations.1.2.0.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:68:\"https://ps.w.org/performant-translations/assets/icon.svg?rev=3098168\";s:3:\"svg\";s:68:\"https://ps.w.org/performant-translations/assets/icon.svg?rev=3098168\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:79:\"https://ps.w.org/performant-translations/assets/banner-1544x500.png?rev=3098168\";s:2:\"1x\";s:78:\"https://ps.w.org/performant-translations/assets/banner-772x250.png?rev=3103384\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.5\";}s:55:\"plugins-garbage-collector/plugins-garbage-collector.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:39:\"w.org/plugins/plugins-garbage-collector\";s:4:\"slug\";s:25:\"plugins-garbage-collector\";s:6:\"plugin\";s:55:\"plugins-garbage-collector/plugins-garbage-collector.php\";s:11:\"new_version\";s:4:\"0.14\";s:3:\"url\";s:56:\"https://wordpress.org/plugins/plugins-garbage-collector/\";s:7:\"package\";s:73:\"https://downloads.wordpress.org/plugin/plugins-garbage-collector.0.14.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:78:\"https://ps.w.org/plugins-garbage-collector/assets/icon-256x256.png?rev=2327424\";s:2:\"1x\";s:78:\"https://ps.w.org/plugins-garbage-collector/assets/icon-128x128.png?rev=2327424\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:80:\"https://ps.w.org/plugins-garbage-collector/assets/banner-772x250.png?rev=2327425\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.0\";}s:31:\"query-monitor/query-monitor.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:27:\"w.org/plugins/query-monitor\";s:4:\"slug\";s:13:\"query-monitor\";s:6:\"plugin\";s:31:\"query-monitor/query-monitor.php\";s:11:\"new_version\";s:6:\"3.17.0\";s:3:\"url\";s:44:\"https://wordpress.org/plugins/query-monitor/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/query-monitor.3.17.0.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:58:\"https://ps.w.org/query-monitor/assets/icon.svg?rev=2994095\";s:3:\"svg\";s:58:\"https://ps.w.org/query-monitor/assets/icon.svg?rev=2994095\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:69:\"https://ps.w.org/query-monitor/assets/banner-1544x500.png?rev=2870124\";s:2:\"1x\";s:68:\"https://ps.w.org/query-monitor/assets/banner-772x250.png?rev=2457098\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.9\";}s:30:\"seo-by-rank-math/rank-math.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:30:\"w.org/plugins/seo-by-rank-math\";s:4:\"slug\";s:16:\"seo-by-rank-math\";s:6:\"plugin\";s:30:\"seo-by-rank-math/rank-math.php\";s:11:\"new_version\";s:7:\"1.0.234\";s:3:\"url\";s:47:\"https://wordpress.org/plugins/seo-by-rank-math/\";s:7:\"package\";s:67:\"https://downloads.wordpress.org/plugin/seo-by-rank-math.1.0.234.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:61:\"https://ps.w.org/seo-by-rank-math/assets/icon.svg?rev=3015810\";s:3:\"svg\";s:61:\"https://ps.w.org/seo-by-rank-math/assets/icon.svg?rev=3015810\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:72:\"https://ps.w.org/seo-by-rank-math/assets/banner-1544x500.png?rev=2639678\";s:2:\"1x\";s:71:\"https://ps.w.org/seo-by-rank-math/assets/banner-772x250.png?rev=2639678\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"6.3\";}s:45:\"search-and-replace/inpsyde-search-replace.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:32:\"w.org/plugins/search-and-replace\";s:4:\"slug\";s:18:\"search-and-replace\";s:6:\"plugin\";s:45:\"search-and-replace/inpsyde-search-replace.php\";s:11:\"new_version\";s:5:\"3.2.3\";s:3:\"url\";s:49:\"https://wordpress.org/plugins/search-and-replace/\";s:7:\"package\";s:67:\"https://downloads.wordpress.org/plugin/search-and-replace.3.2.3.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:71:\"https://ps.w.org/search-and-replace/assets/icon-256x256.png?rev=1776844\";s:2:\"1x\";s:71:\"https://ps.w.org/search-and-replace/assets/icon-128x128.png?rev=1776844\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:74:\"https://ps.w.org/search-and-replace/assets/banner-1544x500.png?rev=1776844\";s:2:\"1x\";s:73:\"https://ps.w.org/search-and-replace/assets/banner-772x250.png?rev=1776844\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.0\";}s:33:\"seo-image/seo-friendly-images.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:23:\"w.org/plugins/seo-image\";s:4:\"slug\";s:9:\"seo-image\";s:6:\"plugin\";s:33:\"seo-image/seo-friendly-images.php\";s:11:\"new_version\";s:5:\"3.0.5\";s:3:\"url\";s:40:\"https://wordpress.org/plugins/seo-image/\";s:7:\"package\";s:52:\"https://downloads.wordpress.org/plugin/seo-image.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:62:\"https://ps.w.org/seo-image/assets/icon-128x128.png?rev=1050796\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:63:\"https://ps.w.org/seo-image/assets/banner-772x250.png?rev=525849\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"2.7\";}s:43:\"site-health-manager/site-health-manager.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:33:\"w.org/plugins/site-health-manager\";s:4:\"slug\";s:19:\"site-health-manager\";s:6:\"plugin\";s:43:\"site-health-manager/site-health-manager.php\";s:11:\"new_version\";s:5:\"1.1.2\";s:3:\"url\";s:50:\"https://wordpress.org/plugins/site-health-manager/\";s:7:\"package\";s:68:\"https://downloads.wordpress.org/plugin/site-health-manager.1.1.2.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:64:\"https://ps.w.org/site-health-manager/assets/icon.svg?rev=2090933\";s:3:\"svg\";s:64:\"https://ps.w.org/site-health-manager/assets/icon.svg?rev=2090933\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:75:\"https://ps.w.org/site-health-manager/assets/banner-1544x500.png?rev=2093623\";s:2:\"1x\";s:74:\"https://ps.w.org/site-health-manager/assets/banner-772x250.png?rev=2093629\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.2\";}s:35:\"google-site-kit/google-site-kit.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:29:\"w.org/plugins/google-site-kit\";s:4:\"slug\";s:15:\"google-site-kit\";s:6:\"plugin\";s:35:\"google-site-kit/google-site-kit.php\";s:11:\"new_version\";s:7:\"1.141.0\";s:3:\"url\";s:46:\"https://wordpress.org/plugins/google-site-kit/\";s:7:\"package\";s:66:\"https://downloads.wordpress.org/plugin/google-site-kit.1.141.0.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:68:\"https://ps.w.org/google-site-kit/assets/icon-256x256.png?rev=3141863\";s:2:\"1x\";s:68:\"https://ps.w.org/google-site-kit/assets/icon-128x128.png?rev=3141863\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:71:\"https://ps.w.org/google-site-kit/assets/banner-1544x500.png?rev=3141863\";s:2:\"1x\";s:70:\"https://ps.w.org/google-site-kit/assets/banner-772x250.png?rev=3141863\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.2\";}s:27:\"svg-support/svg-support.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:25:\"w.org/plugins/svg-support\";s:4:\"slug\";s:11:\"svg-support\";s:6:\"plugin\";s:27:\"svg-support/svg-support.php\";s:11:\"new_version\";s:5:\"2.5.8\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/svg-support/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/svg-support.2.5.8.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:56:\"https://ps.w.org/svg-support/assets/icon.svg?rev=1417738\";s:3:\"svg\";s:56:\"https://ps.w.org/svg-support/assets/icon.svg?rev=1417738\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/svg-support/assets/banner-1544x500.jpg?rev=1215377\";s:2:\"1x\";s:66:\"https://ps.w.org/svg-support/assets/banner-772x250.jpg?rev=1215377\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.8\";}s:25:\"ukr-to-lat/ukr-to-lat.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:24:\"w.org/plugins/ukr-to-lat\";s:4:\"slug\";s:10:\"ukr-to-lat\";s:6:\"plugin\";s:25:\"ukr-to-lat/ukr-to-lat.php\";s:11:\"new_version\";s:5:\"1.3.5\";s:3:\"url\";s:41:\"https://wordpress.org/plugins/ukr-to-lat/\";s:7:\"package\";s:53:\"https://downloads.wordpress.org/plugin/ukr-to-lat.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:63:\"https://ps.w.org/ukr-to-lat/assets/icon-256x256.png?rev=1942473\";s:2:\"1x\";s:63:\"https://ps.w.org/ukr-to-lat/assets/icon-128x128.png?rev=1942473\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:66:\"https://ps.w.org/ukr-to-lat/assets/banner-1544x500.png?rev=1942473\";s:2:\"1x\";s:65:\"https://ps.w.org/ukr-to-lat/assets/banner-772x250.png?rev=1942473\";}s:11:\"banners_rtl\";a:2:{s:2:\"2x\";s:70:\"https://ps.w.org/ukr-to-lat/assets/banner-1544x500-rtl.png?rev=1942473\";s:2:\"1x\";s:69:\"https://ps.w.org/ukr-to-lat/assets/banner-772x250-rtl.png?rev=1942473\";}s:8:\"requires\";s:3:\"4.6\";}s:27:\"updraftplus/updraftplus.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:25:\"w.org/plugins/updraftplus\";s:4:\"slug\";s:11:\"updraftplus\";s:6:\"plugin\";s:27:\"updraftplus/updraftplus.php\";s:11:\"new_version\";s:7:\"1.24.11\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/updraftplus/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/plugin/updraftplus.1.24.11.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/updraftplus/assets/icon-256x256.jpg?rev=1686200\";s:2:\"1x\";s:64:\"https://ps.w.org/updraftplus/assets/icon-128x128.jpg?rev=1686200\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/updraftplus/assets/banner-1544x500.png?rev=1686200\";s:2:\"1x\";s:66:\"https://ps.w.org/updraftplus/assets/banner-772x250.png?rev=1686200\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"3.2\";}s:53:\"widget-importer-exporter/widget-importer-exporter.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:38:\"w.org/plugins/widget-importer-exporter\";s:4:\"slug\";s:24:\"widget-importer-exporter\";s:6:\"plugin\";s:53:\"widget-importer-exporter/widget-importer-exporter.php\";s:11:\"new_version\";s:5:\"1.6.1\";s:3:\"url\";s:55:\"https://wordpress.org/plugins/widget-importer-exporter/\";s:7:\"package\";s:73:\"https://downloads.wordpress.org/plugin/widget-importer-exporter.1.6.1.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:76:\"https://ps.w.org/widget-importer-exporter/assets/icon-256x256.jpg?rev=990577\";s:2:\"1x\";s:76:\"https://ps.w.org/widget-importer-exporter/assets/icon-128x128.jpg?rev=990577\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:79:\"https://ps.w.org/widget-importer-exporter/assets/banner-1544x500.jpg?rev=775677\";s:2:\"1x\";s:78:\"https://ps.w.org/widget-importer-exporter/assets/banner-772x250.jpg?rev=741218\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"3.5\";}s:23:\"wordfence/wordfence.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:23:\"w.org/plugins/wordfence\";s:4:\"slug\";s:9:\"wordfence\";s:6:\"plugin\";s:23:\"wordfence/wordfence.php\";s:11:\"new_version\";s:5:\"8.0.1\";s:3:\"url\";s:40:\"https://wordpress.org/plugins/wordfence/\";s:7:\"package\";s:58:\"https://downloads.wordpress.org/plugin/wordfence.8.0.1.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:54:\"https://ps.w.org/wordfence/assets/icon.svg?rev=2070865\";s:3:\"svg\";s:54:\"https://ps.w.org/wordfence/assets/icon.svg?rev=2070865\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:65:\"https://ps.w.org/wordfence/assets/banner-1544x500.jpg?rev=2124102\";s:2:\"1x\";s:64:\"https://ps.w.org/wordfence/assets/banner-772x250.jpg?rev=2124102\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.7\";}s:41:\"wordpress-importer/wordpress-importer.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:32:\"w.org/plugins/wordpress-importer\";s:4:\"slug\";s:18:\"wordpress-importer\";s:6:\"plugin\";s:41:\"wordpress-importer/wordpress-importer.php\";s:11:\"new_version\";s:5:\"0.8.3\";s:3:\"url\";s:49:\"https://wordpress.org/plugins/wordpress-importer/\";s:7:\"package\";s:67:\"https://downloads.wordpress.org/plugin/wordpress-importer.0.8.3.zip\";s:5:\"icons\";a:2:{s:2:\"1x\";s:63:\"https://ps.w.org/wordpress-importer/assets/icon.svg?rev=2791650\";s:3:\"svg\";s:63:\"https://ps.w.org/wordpress-importer/assets/icon.svg?rev=2791650\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:72:\"https://ps.w.org/wordpress-importer/assets/banner-772x250.png?rev=547654\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.2\";}s:36:\"inspector-wp/wordpress-inspector.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:26:\"w.org/plugins/inspector-wp\";s:4:\"slug\";s:12:\"inspector-wp\";s:6:\"plugin\";s:36:\"inspector-wp/wordpress-inspector.php\";s:11:\"new_version\";s:5:\"1.1.0\";s:3:\"url\";s:43:\"https://wordpress.org/plugins/inspector-wp/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/inspector-wp.1.1.0.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:65:\"https://ps.w.org/inspector-wp/assets/icon-128x128.png?rev=1409183\";}s:7:\"banners\";a:0:{}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:5:\"3.0.1\";}s:27:\"wp-optimize/wp-optimize.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:25:\"w.org/plugins/wp-optimize\";s:4:\"slug\";s:11:\"wp-optimize\";s:6:\"plugin\";s:27:\"wp-optimize/wp-optimize.php\";s:11:\"new_version\";s:5:\"3.8.0\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/wp-optimize/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/plugin/wp-optimize.3.8.0.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/wp-optimize/assets/icon-256x256.png?rev=1552899\";s:2:\"1x\";s:64:\"https://ps.w.org/wp-optimize/assets/icon-128x128.png?rev=1552899\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/wp-optimize/assets/banner-1544x500.png?rev=2125385\";s:2:\"1x\";s:66:\"https://ps.w.org/wp-optimize/assets/banner-772x250.png?rev=2125385\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.5\";}s:39:\"wp-file-manager/file_folder_manager.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:29:\"w.org/plugins/wp-file-manager\";s:4:\"slug\";s:15:\"wp-file-manager\";s:6:\"plugin\";s:39:\"wp-file-manager/file_folder_manager.php\";s:11:\"new_version\";s:3:\"8.0\";s:3:\"url\";s:46:\"https://wordpress.org/plugins/wp-file-manager/\";s:7:\"package\";s:58:\"https://downloads.wordpress.org/plugin/wp-file-manager.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:68:\"https://ps.w.org/wp-file-manager/assets/icon-128x128.png?rev=2491299\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:70:\"https://ps.w.org/wp-file-manager/assets/banner-772x250.jpg?rev=2491299\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.0\";}s:33:\"wp-performance/wp-performance.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:28:\"w.org/plugins/wp-performance\";s:4:\"slug\";s:14:\"wp-performance\";s:6:\"plugin\";s:33:\"wp-performance/wp-performance.php\";s:11:\"new_version\";s:7:\"1.1.8.3\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/wp-performance/\";s:7:\"package\";s:57:\"https://downloads.wordpress.org/plugin/wp-performance.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:67:\"https://ps.w.org/wp-performance/assets/icon-128x128.png?rev=2002746\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:69:\"https://ps.w.org/wp-performance/assets/banner-772x250.png?rev=2002746\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.7\";}s:37:\"wp-reroute-email/wp-reroute-email.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:30:\"w.org/plugins/wp-reroute-email\";s:4:\"slug\";s:16:\"wp-reroute-email\";s:6:\"plugin\";s:37:\"wp-reroute-email/wp-reroute-email.php\";s:11:\"new_version\";s:5:\"1.5.0\";s:3:\"url\";s:47:\"https://wordpress.org/plugins/wp-reroute-email/\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/plugin/wp-reroute-email.1.5.0.zip\";s:5:\"icons\";a:1:{s:7:\"default\";s:67:\"https://s.w.org/plugins/geopattern-icon/wp-reroute-email_d1e8de.svg\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:71:\"https://ps.w.org/wp-reroute-email/assets/banner-772x250.png?rev=1468438\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";b:0;}s:34:\"advanced-custom-fields-pro/acf.php\";O:8:\"stdClass\":12:{s:4:\"slug\";s:26:\"advanced-custom-fields-pro\";s:6:\"plugin\";s:34:\"advanced-custom-fields-pro/acf.php\";s:11:\"new_version\";s:6:\"6.3.11\";s:3:\"url\";s:36:\"https://www.advancedcustomfields.com\";s:6:\"tested\";s:5:\"6.7.1\";s:7:\"package\";s:0:\"\";s:5:\"icons\";a:1:{s:7:\"default\";s:64:\"https://connect.advancedcustomfields.com/assets/icon-256x256.png\";}s:7:\"banners\";a:2:{s:3:\"low\";s:66:\"https://connect.advancedcustomfields.com/assets/banner-772x250.jpg\";s:4:\"high\";s:67:\"https://connect.advancedcustomfields.com/assets/banner-1544x500.jpg\";}s:8:\"requires\";s:3:\"6.0\";s:12:\"requires_php\";s:3:\"7.4\";s:12:\"release_date\";s:8:\"20241112\";s:6:\"reason\";s:10:\"up_to_date\";}}s:7:\"checked\";a:55:{s:41:\"acf-code-generator/acf_code_generator.php\";s:5:\"1.0.2\";s:29:\"acf-extended/acf-extended.php\";s:7:\"0.9.0.9\";s:41:\"acf-theme-code-pro/acf_theme_code_pro.php\";s:5:\"2.5.6\";s:34:\"advanced-custom-fields-pro/acf.php\";s:6:\"6.3.11\";s:51:\"all-in-one-wp-migration/all-in-one-wp-migration.php\";s:4:\"7.87\";s:91:\"all-in-one-wp-migration-unlimited-extension/all-in-one-wp-migration-unlimited-extension.php\";s:4:\"2.49\";s:51:\"all-in-one-wp-security-and-firewall/wp-security.php\";s:5:\"5.3.7\";s:41:\"another-show-hooks/another-show-hooks.php\";s:5:\"1.0.2\";s:43:\"broken-link-checker/broken-link-checker.php\";s:5:\"2.4.2\";s:39:\"bulk-page-creator/bulk-page-creator.php\";s:5:\"1.1.4\";s:53:\"child-theme-configurator/child-theme-configurator.php\";s:5:\"2.6.6\";s:41:\"child-theme-wizard/child-theme-wizard.php\";s:3:\"1.4\";s:33:\"classic-editor/classic-editor.php\";s:5:\"1.6.7\";s:35:\"classic-widgets/classic-widgets.php\";s:3:\"0.3\";s:33:\"code-generator/code-generator.php\";s:3:\"1.0\";s:33:\"complianz-gdpr/complianz-gpdr.php\";s:5:\"7.1.5\";s:36:\"contact-form-7/wp-contact-form-7.php\";s:5:\"6.0.1\";s:42:\"contact-form-cfdb7/contact-form-cfdb-7.php\";s:6:\"1.2.10\";s:53:\"customizer-export-import/customizer-export-import.php\";s:7:\"0.9.7.3\";s:43:\"custom-post-type-ui/custom-post-type-ui.php\";s:6:\"1.17.2\";s:39:\"https-redirection/https-redirection.php\";s:5:\"1.9.2\";s:45:\"enable-svg-webp-ico-upload/itc-svg-upload.php\";s:5:\"1.1.2\";s:25:\"auto-sizes/auto-sizes.php\";s:5:\"1.3.0\";s:45:\"ewww-image-optimizer/ewww-image-optimizer.php\";s:5:\"8.0.0\";s:25:\"fakerpress/fakerpress.php\";s:5:\"0.6.6\";s:29:\"health-check/health-check.php\";s:5:\"1.7.1\";s:36:\"contact-form-7-honeypot/honeypot.php\";s:5:\"2.1.7\";s:29:\"http-headers/http-headers.php\";s:6:\"1.19.1\";s:30:\"dominant-color-images/load.php\";s:5:\"1.1.2\";s:53:\"index-wp-mysql-for-speed/index-wp-mysql-for-speed.php\";s:5:\"1.5.2\";s:35:\"litespeed-cache/litespeed-cache.php\";s:5:\"6.5.3\";s:21:\"webp-uploads/load.php\";s:5:\"2.3.0\";s:24:\"performance-lab/load.php\";s:5:\"3.6.1\";s:45:\"performance-profiler/performance-profiler.php\";s:5:\"0.1.0\";s:51:\"performant-translations/performant-translations.php\";s:5:\"1.2.0\";s:55:\"plugins-garbage-collector/plugins-garbage-collector.php\";s:4:\"0.14\";s:31:\"query-monitor/query-monitor.php\";s:6:\"3.17.0\";s:39:\"query-monitor-log-viewer/log-viewer.php\";s:8:\"14.05.04\";s:30:\"seo-by-rank-math/rank-math.php\";s:7:\"1.0.234\";s:17:\"revisr/revisr.php\";s:5:\"2.0.2\";s:45:\"search-and-replace/inpsyde-search-replace.php\";s:5:\"3.2.3\";s:33:\"seo-image/seo-friendly-images.php\";s:5:\"3.0.5\";s:43:\"site-health-manager/site-health-manager.php\";s:5:\"1.1.2\";s:35:\"google-site-kit/google-site-kit.php\";s:7:\"1.141.0\";s:27:\"svg-support/svg-support.php\";s:5:\"2.5.8\";s:25:\"ukr-to-lat/ukr-to-lat.php\";s:5:\"1.3.5\";s:27:\"updraftplus/updraftplus.php\";s:7:\"1.24.11\";s:53:\"widget-importer-exporter/widget-importer-exporter.php\";s:5:\"1.6.1\";s:23:\"wordfence/wordfence.php\";s:5:\"8.0.1\";s:41:\"wordpress-importer/wordpress-importer.php\";s:5:\"0.8.3\";s:36:\"inspector-wp/wordpress-inspector.php\";s:5:\"1.1.0\";s:27:\"wp-optimize/wp-optimize.php\";s:5:\"3.8.0\";s:39:\"wp-file-manager/file_folder_manager.php\";s:3:\"8.0\";s:33:\"wp-performance/wp-performance.php\";s:7:\"1.1.8.3\";s:37:\"wp-reroute-email/wp-reroute-email.php\";s:5:\"1.5.0\";}}','off'),
(2992,'_site_transient_update_themes','O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1733960312;s:7:\"checked\";a:5:{s:19:\"axio-starter-master\";s:5:\"1.0.0\";s:16:\"twentytwentyfive\";s:3:\"1.0\";s:16:\"twentytwentyfour\";s:3:\"1.3\";s:15:\"twentytwentyone\";s:3:\"2.4\";s:7:\"wp-wpeb\";s:10:\"2024-07-23\";}s:8:\"response\";a:0:{}s:9:\"no_update\";a:3:{s:16:\"twentytwentyfive\";a:6:{s:5:\"theme\";s:16:\"twentytwentyfive\";s:11:\"new_version\";s:3:\"1.0\";s:3:\"url\";s:46:\"https://wordpress.org/themes/twentytwentyfive/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/theme/twentytwentyfive.1.0.zip\";s:8:\"requires\";s:3:\"6.7\";s:12:\"requires_php\";s:3:\"7.2\";}s:16:\"twentytwentyfour\";a:6:{s:5:\"theme\";s:16:\"twentytwentyfour\";s:11:\"new_version\";s:3:\"1.3\";s:3:\"url\";s:46:\"https://wordpress.org/themes/twentytwentyfour/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/theme/twentytwentyfour.1.3.zip\";s:8:\"requires\";s:3:\"6.4\";s:12:\"requires_php\";s:3:\"7.0\";}s:15:\"twentytwentyone\";a:6:{s:5:\"theme\";s:15:\"twentytwentyone\";s:11:\"new_version\";s:3:\"2.4\";s:3:\"url\";s:45:\"https://wordpress.org/themes/twentytwentyone/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/theme/twentytwentyone.2.4.zip\";s:8:\"requires\";s:3:\"5.3\";s:12:\"requires_php\";s:3:\"5.6\";}}s:12:\"translations\";a:0:{}}','off'),
(2927,'_site_transient_wp_plugin_dependencies_plugin_data','a:0:{}','no'),
(2994,'_site_transient_wp_theme_files_patterns-a64be370c6a53d17a10b356f6e90c147','a:2:{s:7:\"version\";s:10:\"2024-07-23\";s:8:\"patterns\";a:0:{}}','off'),
(2976,'_transient_acf_plugin_updates','a:5:{s:7:\"plugins\";a:0:{}s:9:\"no_update\";a:1:{s:34:\"advanced-custom-fields-pro/acf.php\";a:12:{s:4:\"slug\";s:26:\"advanced-custom-fields-pro\";s:6:\"plugin\";s:34:\"advanced-custom-fields-pro/acf.php\";s:11:\"new_version\";s:6:\"6.3.11\";s:3:\"url\";s:36:\"https://www.advancedcustomfields.com\";s:6:\"tested\";s:5:\"6.7.1\";s:7:\"package\";s:0:\"\";s:5:\"icons\";a:1:{s:7:\"default\";s:64:\"https://connect.advancedcustomfields.com/assets/icon-256x256.png\";}s:7:\"banners\";a:2:{s:3:\"low\";s:66:\"https://connect.advancedcustomfields.com/assets/banner-772x250.jpg\";s:4:\"high\";s:67:\"https://connect.advancedcustomfields.com/assets/banner-1544x500.jpg\";}s:8:\"requires\";s:3:\"6.0\";s:12:\"requires_php\";s:3:\"7.4\";s:12:\"release_date\";s:8:\"20241112\";s:6:\"reason\";s:10:\"up_to_date\";}}s:10:\"expiration\";i:172800;s:6:\"status\";i:1;s:7:\"checked\";a:1:{s:34:\"advanced-custom-fields-pro/acf.php\";s:6:\"6.3.11\";}}','off'),
(2912,'_transient_acf_pro_license_reactivated','1','yes'),
(2973,'_transient_acf_pro_validating_license','1','off'),
(2048,'_transient_health-check-site-status-result','{\"good\":18,\"recommended\":6,\"critical\":0}','yes'),
(2638,'_transient_itc_svg_upload_settings_notice_dismiss_alert','9','yes'),
(2412,'_transient_perflab_set_object_cache_dropin','1','no'),
(2975,'_transient_timeout_acf_plugin_updates','1734133041','off'),
(2972,'_transient_timeout_acf_pro_validating_license','1733960935','off'),
(2386,'_transient_users_online','a:1:{i:0;a:4:{s:7:\"user_id\";i:2;s:13:\"last_activity\";i:1681894525;s:10:\"ip_address\";s:14:\"178.74.236.195\";s:7:\"blog_id\";b:0;}}','no'),
(2448,'_transient_wfRegistrationToken','LefZsV7NyV5vSeI4kPpX4MK9RaIKyfMe9PX7AjxGIqc','no'),
(2956,'_transient_wp_core_block_css_files','a:2:{s:7:\"version\";s:5:\"6.5.5\";s:5:\"files\";a:500:{i:0;s:23:\"archives/editor-rtl.css\";i:1;s:27:\"archives/editor-rtl.min.css\";i:2;s:19:\"archives/editor.css\";i:3;s:23:\"archives/editor.min.css\";i:4;s:22:\"archives/style-rtl.css\";i:5;s:26:\"archives/style-rtl.min.css\";i:6;s:18:\"archives/style.css\";i:7;s:22:\"archives/style.min.css\";i:8;s:20:\"audio/editor-rtl.css\";i:9;s:24:\"audio/editor-rtl.min.css\";i:10;s:16:\"audio/editor.css\";i:11;s:20:\"audio/editor.min.css\";i:12;s:19:\"audio/style-rtl.css\";i:13;s:23:\"audio/style-rtl.min.css\";i:14;s:15:\"audio/style.css\";i:15;s:19:\"audio/style.min.css\";i:16;s:19:\"audio/theme-rtl.css\";i:17;s:23:\"audio/theme-rtl.min.css\";i:18;s:15:\"audio/theme.css\";i:19;s:19:\"audio/theme.min.css\";i:20;s:21:\"avatar/editor-rtl.css\";i:21;s:25:\"avatar/editor-rtl.min.css\";i:22;s:17:\"avatar/editor.css\";i:23;s:21:\"avatar/editor.min.css\";i:24;s:20:\"avatar/style-rtl.css\";i:25;s:24:\"avatar/style-rtl.min.css\";i:26;s:16:\"avatar/style.css\";i:27;s:20:\"avatar/style.min.css\";i:28;s:20:\"block/editor-rtl.css\";i:29;s:24:\"block/editor-rtl.min.css\";i:30;s:16:\"block/editor.css\";i:31;s:20:\"block/editor.min.css\";i:32;s:21:\"button/editor-rtl.css\";i:33;s:25:\"button/editor-rtl.min.css\";i:34;s:17:\"button/editor.css\";i:35;s:21:\"button/editor.min.css\";i:36;s:20:\"button/style-rtl.css\";i:37;s:24:\"button/style-rtl.min.css\";i:38;s:16:\"button/style.css\";i:39;s:20:\"button/style.min.css\";i:40;s:22:\"buttons/editor-rtl.css\";i:41;s:26:\"buttons/editor-rtl.min.css\";i:42;s:18:\"buttons/editor.css\";i:43;s:22:\"buttons/editor.min.css\";i:44;s:21:\"buttons/style-rtl.css\";i:45;s:25:\"buttons/style-rtl.min.css\";i:46;s:17:\"buttons/style.css\";i:47;s:21:\"buttons/style.min.css\";i:48;s:22:\"calendar/style-rtl.css\";i:49;s:26:\"calendar/style-rtl.min.css\";i:50;s:18:\"calendar/style.css\";i:51;s:22:\"calendar/style.min.css\";i:52;s:25:\"categories/editor-rtl.css\";i:53;s:29:\"categories/editor-rtl.min.css\";i:54;s:21:\"categories/editor.css\";i:55;s:25:\"categories/editor.min.css\";i:56;s:24:\"categories/style-rtl.css\";i:57;s:28:\"categories/style-rtl.min.css\";i:58;s:20:\"categories/style.css\";i:59;s:24:\"categories/style.min.css\";i:60;s:19:\"code/editor-rtl.css\";i:61;s:23:\"code/editor-rtl.min.css\";i:62;s:15:\"code/editor.css\";i:63;s:19:\"code/editor.min.css\";i:64;s:18:\"code/style-rtl.css\";i:65;s:22:\"code/style-rtl.min.css\";i:66;s:14:\"code/style.css\";i:67;s:18:\"code/style.min.css\";i:68;s:18:\"code/theme-rtl.css\";i:69;s:22:\"code/theme-rtl.min.css\";i:70;s:14:\"code/theme.css\";i:71;s:18:\"code/theme.min.css\";i:72;s:22:\"columns/editor-rtl.css\";i:73;s:26:\"columns/editor-rtl.min.css\";i:74;s:18:\"columns/editor.css\";i:75;s:22:\"columns/editor.min.css\";i:76;s:21:\"columns/style-rtl.css\";i:77;s:25:\"columns/style-rtl.min.css\";i:78;s:17:\"columns/style.css\";i:79;s:21:\"columns/style.min.css\";i:80;s:29:\"comment-content/style-rtl.css\";i:81;s:33:\"comment-content/style-rtl.min.css\";i:82;s:25:\"comment-content/style.css\";i:83;s:29:\"comment-content/style.min.css\";i:84;s:30:\"comment-template/style-rtl.css\";i:85;s:34:\"comment-template/style-rtl.min.css\";i:86;s:26:\"comment-template/style.css\";i:87;s:30:\"comment-template/style.min.css\";i:88;s:42:\"comments-pagination-numbers/editor-rtl.css\";i:89;s:46:\"comments-pagination-numbers/editor-rtl.min.css\";i:90;s:38:\"comments-pagination-numbers/editor.css\";i:91;s:42:\"comments-pagination-numbers/editor.min.css\";i:92;s:34:\"comments-pagination/editor-rtl.css\";i:93;s:38:\"comments-pagination/editor-rtl.min.css\";i:94;s:30:\"comments-pagination/editor.css\";i:95;s:34:\"comments-pagination/editor.min.css\";i:96;s:33:\"comments-pagination/style-rtl.css\";i:97;s:37:\"comments-pagination/style-rtl.min.css\";i:98;s:29:\"comments-pagination/style.css\";i:99;s:33:\"comments-pagination/style.min.css\";i:100;s:29:\"comments-title/editor-rtl.css\";i:101;s:33:\"comments-title/editor-rtl.min.css\";i:102;s:25:\"comments-title/editor.css\";i:103;s:29:\"comments-title/editor.min.css\";i:104;s:23:\"comments/editor-rtl.css\";i:105;s:27:\"comments/editor-rtl.min.css\";i:106;s:19:\"comments/editor.css\";i:107;s:23:\"comments/editor.min.css\";i:108;s:22:\"comments/style-rtl.css\";i:109;s:26:\"comments/style-rtl.min.css\";i:110;s:18:\"comments/style.css\";i:111;s:22:\"comments/style.min.css\";i:112;s:20:\"cover/editor-rtl.css\";i:113;s:24:\"cover/editor-rtl.min.css\";i:114;s:16:\"cover/editor.css\";i:115;s:20:\"cover/editor.min.css\";i:116;s:19:\"cover/style-rtl.css\";i:117;s:23:\"cover/style-rtl.min.css\";i:118;s:15:\"cover/style.css\";i:119;s:19:\"cover/style.min.css\";i:120;s:22:\"details/editor-rtl.css\";i:121;s:26:\"details/editor-rtl.min.css\";i:122;s:18:\"details/editor.css\";i:123;s:22:\"details/editor.min.css\";i:124;s:21:\"details/style-rtl.css\";i:125;s:25:\"details/style-rtl.min.css\";i:126;s:17:\"details/style.css\";i:127;s:21:\"details/style.min.css\";i:128;s:20:\"embed/editor-rtl.css\";i:129;s:24:\"embed/editor-rtl.min.css\";i:130;s:16:\"embed/editor.css\";i:131;s:20:\"embed/editor.min.css\";i:132;s:19:\"embed/style-rtl.css\";i:133;s:23:\"embed/style-rtl.min.css\";i:134;s:15:\"embed/style.css\";i:135;s:19:\"embed/style.min.css\";i:136;s:19:\"embed/theme-rtl.css\";i:137;s:23:\"embed/theme-rtl.min.css\";i:138;s:15:\"embed/theme.css\";i:139;s:19:\"embed/theme.min.css\";i:140;s:19:\"file/editor-rtl.css\";i:141;s:23:\"file/editor-rtl.min.css\";i:142;s:15:\"file/editor.css\";i:143;s:19:\"file/editor.min.css\";i:144;s:18:\"file/style-rtl.css\";i:145;s:22:\"file/style-rtl.min.css\";i:146;s:14:\"file/style.css\";i:147;s:18:\"file/style.min.css\";i:148;s:23:\"footnotes/style-rtl.css\";i:149;s:27:\"footnotes/style-rtl.min.css\";i:150;s:19:\"footnotes/style.css\";i:151;s:23:\"footnotes/style.min.css\";i:152;s:23:\"freeform/editor-rtl.css\";i:153;s:27:\"freeform/editor-rtl.min.css\";i:154;s:19:\"freeform/editor.css\";i:155;s:23:\"freeform/editor.min.css\";i:156;s:22:\"gallery/editor-rtl.css\";i:157;s:26:\"gallery/editor-rtl.min.css\";i:158;s:18:\"gallery/editor.css\";i:159;s:22:\"gallery/editor.min.css\";i:160;s:21:\"gallery/style-rtl.css\";i:161;s:25:\"gallery/style-rtl.min.css\";i:162;s:17:\"gallery/style.css\";i:163;s:21:\"gallery/style.min.css\";i:164;s:21:\"gallery/theme-rtl.css\";i:165;s:25:\"gallery/theme-rtl.min.css\";i:166;s:17:\"gallery/theme.css\";i:167;s:21:\"gallery/theme.min.css\";i:168;s:20:\"group/editor-rtl.css\";i:169;s:24:\"group/editor-rtl.min.css\";i:170;s:16:\"group/editor.css\";i:171;s:20:\"group/editor.min.css\";i:172;s:19:\"group/style-rtl.css\";i:173;s:23:\"group/style-rtl.min.css\";i:174;s:15:\"group/style.css\";i:175;s:19:\"group/style.min.css\";i:176;s:19:\"group/theme-rtl.css\";i:177;s:23:\"group/theme-rtl.min.css\";i:178;s:15:\"group/theme.css\";i:179;s:19:\"group/theme.min.css\";i:180;s:21:\"heading/style-rtl.css\";i:181;s:25:\"heading/style-rtl.min.css\";i:182;s:17:\"heading/style.css\";i:183;s:21:\"heading/style.min.css\";i:184;s:19:\"html/editor-rtl.css\";i:185;s:23:\"html/editor-rtl.min.css\";i:186;s:15:\"html/editor.css\";i:187;s:19:\"html/editor.min.css\";i:188;s:20:\"image/editor-rtl.css\";i:189;s:24:\"image/editor-rtl.min.css\";i:190;s:16:\"image/editor.css\";i:191;s:20:\"image/editor.min.css\";i:192;s:19:\"image/style-rtl.css\";i:193;s:23:\"image/style-rtl.min.css\";i:194;s:15:\"image/style.css\";i:195;s:19:\"image/style.min.css\";i:196;s:19:\"image/theme-rtl.css\";i:197;s:23:\"image/theme-rtl.min.css\";i:198;s:15:\"image/theme.css\";i:199;s:19:\"image/theme.min.css\";i:200;s:29:\"latest-comments/style-rtl.css\";i:201;s:33:\"latest-comments/style-rtl.min.css\";i:202;s:25:\"latest-comments/style.css\";i:203;s:29:\"latest-comments/style.min.css\";i:204;s:27:\"latest-posts/editor-rtl.css\";i:205;s:31:\"latest-posts/editor-rtl.min.css\";i:206;s:23:\"latest-posts/editor.css\";i:207;s:27:\"latest-posts/editor.min.css\";i:208;s:26:\"latest-posts/style-rtl.css\";i:209;s:30:\"latest-posts/style-rtl.min.css\";i:210;s:22:\"latest-posts/style.css\";i:211;s:26:\"latest-posts/style.min.css\";i:212;s:18:\"list/style-rtl.css\";i:213;s:22:\"list/style-rtl.min.css\";i:214;s:14:\"list/style.css\";i:215;s:18:\"list/style.min.css\";i:216;s:25:\"media-text/editor-rtl.css\";i:217;s:29:\"media-text/editor-rtl.min.css\";i:218;s:21:\"media-text/editor.css\";i:219;s:25:\"media-text/editor.min.css\";i:220;s:24:\"media-text/style-rtl.css\";i:221;s:28:\"media-text/style-rtl.min.css\";i:222;s:20:\"media-text/style.css\";i:223;s:24:\"media-text/style.min.css\";i:224;s:19:\"more/editor-rtl.css\";i:225;s:23:\"more/editor-rtl.min.css\";i:226;s:15:\"more/editor.css\";i:227;s:19:\"more/editor.min.css\";i:228;s:30:\"navigation-link/editor-rtl.css\";i:229;s:34:\"navigation-link/editor-rtl.min.css\";i:230;s:26:\"navigation-link/editor.css\";i:231;s:30:\"navigation-link/editor.min.css\";i:232;s:29:\"navigation-link/style-rtl.css\";i:233;s:33:\"navigation-link/style-rtl.min.css\";i:234;s:25:\"navigation-link/style.css\";i:235;s:29:\"navigation-link/style.min.css\";i:236;s:33:\"navigation-submenu/editor-rtl.css\";i:237;s:37:\"navigation-submenu/editor-rtl.min.css\";i:238;s:29:\"navigation-submenu/editor.css\";i:239;s:33:\"navigation-submenu/editor.min.css\";i:240;s:25:\"navigation/editor-rtl.css\";i:241;s:29:\"navigation/editor-rtl.min.css\";i:242;s:21:\"navigation/editor.css\";i:243;s:25:\"navigation/editor.min.css\";i:244;s:24:\"navigation/style-rtl.css\";i:245;s:28:\"navigation/style-rtl.min.css\";i:246;s:20:\"navigation/style.css\";i:247;s:24:\"navigation/style.min.css\";i:248;s:23:\"nextpage/editor-rtl.css\";i:249;s:27:\"nextpage/editor-rtl.min.css\";i:250;s:19:\"nextpage/editor.css\";i:251;s:23:\"nextpage/editor.min.css\";i:252;s:24:\"page-list/editor-rtl.css\";i:253;s:28:\"page-list/editor-rtl.min.css\";i:254;s:20:\"page-list/editor.css\";i:255;s:24:\"page-list/editor.min.css\";i:256;s:23:\"page-list/style-rtl.css\";i:257;s:27:\"page-list/style-rtl.min.css\";i:258;s:19:\"page-list/style.css\";i:259;s:23:\"page-list/style.min.css\";i:260;s:24:\"paragraph/editor-rtl.css\";i:261;s:28:\"paragraph/editor-rtl.min.css\";i:262;s:20:\"paragraph/editor.css\";i:263;s:24:\"paragraph/editor.min.css\";i:264;s:23:\"paragraph/style-rtl.css\";i:265;s:27:\"paragraph/style-rtl.min.css\";i:266;s:19:\"paragraph/style.css\";i:267;s:23:\"paragraph/style.min.css\";i:268;s:25:\"post-author/style-rtl.css\";i:269;s:29:\"post-author/style-rtl.min.css\";i:270;s:21:\"post-author/style.css\";i:271;s:25:\"post-author/style.min.css\";i:272;s:33:\"post-comments-form/editor-rtl.css\";i:273;s:37:\"post-comments-form/editor-rtl.min.css\";i:274;s:29:\"post-comments-form/editor.css\";i:275;s:33:\"post-comments-form/editor.min.css\";i:276;s:32:\"post-comments-form/style-rtl.css\";i:277;s:36:\"post-comments-form/style-rtl.min.css\";i:278;s:28:\"post-comments-form/style.css\";i:279;s:32:\"post-comments-form/style.min.css\";i:280;s:27:\"post-content/editor-rtl.css\";i:281;s:31:\"post-content/editor-rtl.min.css\";i:282;s:23:\"post-content/editor.css\";i:283;s:27:\"post-content/editor.min.css\";i:284;s:23:\"post-date/style-rtl.css\";i:285;s:27:\"post-date/style-rtl.min.css\";i:286;s:19:\"post-date/style.css\";i:287;s:23:\"post-date/style.min.css\";i:288;s:27:\"post-excerpt/editor-rtl.css\";i:289;s:31:\"post-excerpt/editor-rtl.min.css\";i:290;s:23:\"post-excerpt/editor.css\";i:291;s:27:\"post-excerpt/editor.min.css\";i:292;s:26:\"post-excerpt/style-rtl.css\";i:293;s:30:\"post-excerpt/style-rtl.min.css\";i:294;s:22:\"post-excerpt/style.css\";i:295;s:26:\"post-excerpt/style.min.css\";i:296;s:34:\"post-featured-image/editor-rtl.css\";i:297;s:38:\"post-featured-image/editor-rtl.min.css\";i:298;s:30:\"post-featured-image/editor.css\";i:299;s:34:\"post-featured-image/editor.min.css\";i:300;s:33:\"post-featured-image/style-rtl.css\";i:301;s:37:\"post-featured-image/style-rtl.min.css\";i:302;s:29:\"post-featured-image/style.css\";i:303;s:33:\"post-featured-image/style.min.css\";i:304;s:34:\"post-navigation-link/style-rtl.css\";i:305;s:38:\"post-navigation-link/style-rtl.min.css\";i:306;s:30:\"post-navigation-link/style.css\";i:307;s:34:\"post-navigation-link/style.min.css\";i:308;s:28:\"post-template/editor-rtl.css\";i:309;s:32:\"post-template/editor-rtl.min.css\";i:310;s:24:\"post-template/editor.css\";i:311;s:28:\"post-template/editor.min.css\";i:312;s:27:\"post-template/style-rtl.css\";i:313;s:31:\"post-template/style-rtl.min.css\";i:314;s:23:\"post-template/style.css\";i:315;s:27:\"post-template/style.min.css\";i:316;s:24:\"post-terms/style-rtl.css\";i:317;s:28:\"post-terms/style-rtl.min.css\";i:318;s:20:\"post-terms/style.css\";i:319;s:24:\"post-terms/style.min.css\";i:320;s:24:\"post-title/style-rtl.css\";i:321;s:28:\"post-title/style-rtl.min.css\";i:322;s:20:\"post-title/style.css\";i:323;s:24:\"post-title/style.min.css\";i:324;s:26:\"preformatted/style-rtl.css\";i:325;s:30:\"preformatted/style-rtl.min.css\";i:326;s:22:\"preformatted/style.css\";i:327;s:26:\"preformatted/style.min.css\";i:328;s:24:\"pullquote/editor-rtl.css\";i:329;s:28:\"pullquote/editor-rtl.min.css\";i:330;s:20:\"pullquote/editor.css\";i:331;s:24:\"pullquote/editor.min.css\";i:332;s:23:\"pullquote/style-rtl.css\";i:333;s:27:\"pullquote/style-rtl.min.css\";i:334;s:19:\"pullquote/style.css\";i:335;s:23:\"pullquote/style.min.css\";i:336;s:23:\"pullquote/theme-rtl.css\";i:337;s:27:\"pullquote/theme-rtl.min.css\";i:338;s:19:\"pullquote/theme.css\";i:339;s:23:\"pullquote/theme.min.css\";i:340;s:39:\"query-pagination-numbers/editor-rtl.css\";i:341;s:43:\"query-pagination-numbers/editor-rtl.min.css\";i:342;s:35:\"query-pagination-numbers/editor.css\";i:343;s:39:\"query-pagination-numbers/editor.min.css\";i:344;s:31:\"query-pagination/editor-rtl.css\";i:345;s:35:\"query-pagination/editor-rtl.min.css\";i:346;s:27:\"query-pagination/editor.css\";i:347;s:31:\"query-pagination/editor.min.css\";i:348;s:30:\"query-pagination/style-rtl.css\";i:349;s:34:\"query-pagination/style-rtl.min.css\";i:350;s:26:\"query-pagination/style.css\";i:351;s:30:\"query-pagination/style.min.css\";i:352;s:25:\"query-title/style-rtl.css\";i:353;s:29:\"query-title/style-rtl.min.css\";i:354;s:21:\"query-title/style.css\";i:355;s:25:\"query-title/style.min.css\";i:356;s:20:\"query/editor-rtl.css\";i:357;s:24:\"query/editor-rtl.min.css\";i:358;s:16:\"query/editor.css\";i:359;s:20:\"query/editor.min.css\";i:360;s:19:\"quote/style-rtl.css\";i:361;s:23:\"quote/style-rtl.min.css\";i:362;s:15:\"quote/style.css\";i:363;s:19:\"quote/style.min.css\";i:364;s:19:\"quote/theme-rtl.css\";i:365;s:23:\"quote/theme-rtl.min.css\";i:366;s:15:\"quote/theme.css\";i:367;s:19:\"quote/theme.min.css\";i:368;s:23:\"read-more/style-rtl.css\";i:369;s:27:\"read-more/style-rtl.min.css\";i:370;s:19:\"read-more/style.css\";i:371;s:23:\"read-more/style.min.css\";i:372;s:18:\"rss/editor-rtl.css\";i:373;s:22:\"rss/editor-rtl.min.css\";i:374;s:14:\"rss/editor.css\";i:375;s:18:\"rss/editor.min.css\";i:376;s:17:\"rss/style-rtl.css\";i:377;s:21:\"rss/style-rtl.min.css\";i:378;s:13:\"rss/style.css\";i:379;s:17:\"rss/style.min.css\";i:380;s:21:\"search/editor-rtl.css\";i:381;s:25:\"search/editor-rtl.min.css\";i:382;s:17:\"search/editor.css\";i:383;s:21:\"search/editor.min.css\";i:384;s:20:\"search/style-rtl.css\";i:385;s:24:\"search/style-rtl.min.css\";i:386;s:16:\"search/style.css\";i:387;s:20:\"search/style.min.css\";i:388;s:20:\"search/theme-rtl.css\";i:389;s:24:\"search/theme-rtl.min.css\";i:390;s:16:\"search/theme.css\";i:391;s:20:\"search/theme.min.css\";i:392;s:24:\"separator/editor-rtl.css\";i:393;s:28:\"separator/editor-rtl.min.css\";i:394;s:20:\"separator/editor.css\";i:395;s:24:\"separator/editor.min.css\";i:396;s:23:\"separator/style-rtl.css\";i:397;s:27:\"separator/style-rtl.min.css\";i:398;s:19:\"separator/style.css\";i:399;s:23:\"separator/style.min.css\";i:400;s:23:\"separator/theme-rtl.css\";i:401;s:27:\"separator/theme-rtl.min.css\";i:402;s:19:\"separator/theme.css\";i:403;s:23:\"separator/theme.min.css\";i:404;s:24:\"shortcode/editor-rtl.css\";i:405;s:28:\"shortcode/editor-rtl.min.css\";i:406;s:20:\"shortcode/editor.css\";i:407;s:24:\"shortcode/editor.min.css\";i:408;s:24:\"site-logo/editor-rtl.css\";i:409;s:28:\"site-logo/editor-rtl.min.css\";i:410;s:20:\"site-logo/editor.css\";i:411;s:24:\"site-logo/editor.min.css\";i:412;s:23:\"site-logo/style-rtl.css\";i:413;s:27:\"site-logo/style-rtl.min.css\";i:414;s:19:\"site-logo/style.css\";i:415;s:23:\"site-logo/style.min.css\";i:416;s:27:\"site-tagline/editor-rtl.css\";i:417;s:31:\"site-tagline/editor-rtl.min.css\";i:418;s:23:\"site-tagline/editor.css\";i:419;s:27:\"site-tagline/editor.min.css\";i:420;s:25:\"site-title/editor-rtl.css\";i:421;s:29:\"site-title/editor-rtl.min.css\";i:422;s:21:\"site-title/editor.css\";i:423;s:25:\"site-title/editor.min.css\";i:424;s:24:\"site-title/style-rtl.css\";i:425;s:28:\"site-title/style-rtl.min.css\";i:426;s:20:\"site-title/style.css\";i:427;s:24:\"site-title/style.min.css\";i:428;s:26:\"social-link/editor-rtl.css\";i:429;s:30:\"social-link/editor-rtl.min.css\";i:430;s:22:\"social-link/editor.css\";i:431;s:26:\"social-link/editor.min.css\";i:432;s:27:\"social-links/editor-rtl.css\";i:433;s:31:\"social-links/editor-rtl.min.css\";i:434;s:23:\"social-links/editor.css\";i:435;s:27:\"social-links/editor.min.css\";i:436;s:26:\"social-links/style-rtl.css\";i:437;s:30:\"social-links/style-rtl.min.css\";i:438;s:22:\"social-links/style.css\";i:439;s:26:\"social-links/style.min.css\";i:440;s:21:\"spacer/editor-rtl.css\";i:441;s:25:\"spacer/editor-rtl.min.css\";i:442;s:17:\"spacer/editor.css\";i:443;s:21:\"spacer/editor.min.css\";i:444;s:20:\"spacer/style-rtl.css\";i:445;s:24:\"spacer/style-rtl.min.css\";i:446;s:16:\"spacer/style.css\";i:447;s:20:\"spacer/style.min.css\";i:448;s:20:\"table/editor-rtl.css\";i:449;s:24:\"table/editor-rtl.min.css\";i:450;s:16:\"table/editor.css\";i:451;s:20:\"table/editor.min.css\";i:452;s:19:\"table/style-rtl.css\";i:453;s:23:\"table/style-rtl.min.css\";i:454;s:15:\"table/style.css\";i:455;s:19:\"table/style.min.css\";i:456;s:19:\"table/theme-rtl.css\";i:457;s:23:\"table/theme-rtl.min.css\";i:458;s:15:\"table/theme.css\";i:459;s:19:\"table/theme.min.css\";i:460;s:23:\"tag-cloud/style-rtl.css\";i:461;s:27:\"tag-cloud/style-rtl.min.css\";i:462;s:19:\"tag-cloud/style.css\";i:463;s:23:\"tag-cloud/style.min.css\";i:464;s:28:\"template-part/editor-rtl.css\";i:465;s:32:\"template-part/editor-rtl.min.css\";i:466;s:24:\"template-part/editor.css\";i:467;s:28:\"template-part/editor.min.css\";i:468;s:27:\"template-part/theme-rtl.css\";i:469;s:31:\"template-part/theme-rtl.min.css\";i:470;s:23:\"template-part/theme.css\";i:471;s:27:\"template-part/theme.min.css\";i:472;s:30:\"term-description/style-rtl.css\";i:473;s:34:\"term-description/style-rtl.min.css\";i:474;s:26:\"term-description/style.css\";i:475;s:30:\"term-description/style.min.css\";i:476;s:27:\"text-columns/editor-rtl.css\";i:477;s:31:\"text-columns/editor-rtl.min.css\";i:478;s:23:\"text-columns/editor.css\";i:479;s:27:\"text-columns/editor.min.css\";i:480;s:26:\"text-columns/style-rtl.css\";i:481;s:30:\"text-columns/style-rtl.min.css\";i:482;s:22:\"text-columns/style.css\";i:483;s:26:\"text-columns/style.min.css\";i:484;s:19:\"verse/style-rtl.css\";i:485;s:23:\"verse/style-rtl.min.css\";i:486;s:15:\"verse/style.css\";i:487;s:19:\"verse/style.min.css\";i:488;s:20:\"video/editor-rtl.css\";i:489;s:24:\"video/editor-rtl.min.css\";i:490;s:16:\"video/editor.css\";i:491;s:20:\"video/editor.min.css\";i:492;s:19:\"video/style-rtl.css\";i:493;s:23:\"video/style-rtl.min.css\";i:494;s:15:\"video/style.css\";i:495;s:19:\"video/style.min.css\";i:496;s:19:\"video/theme-rtl.css\";i:497;s:23:\"video/theme-rtl.min.css\";i:498;s:15:\"video/theme.css\";i:499;s:19:\"video/theme.min.css\";}}','yes'),
(1304,'acf_pro_license','YToyOntzOjM6ImtleSI7czo3MjoiYjNKa1pYSmZhV1E5TnpZMU9UaDhkSGx3WlQxa1pYWmxiRzl3WlhKOFpHRjBaVDB5TURFMkxUQXpMVEExSURFek9qUXdPalF4IjtzOjM6InVybCI7czoyMjoiaHR0cHM6Ly93cGViLmRkZXYuc2l0ZSI7fQ==','no'),
(2913,'acf_pro_license_status','a:11:{s:6:\"status\";s:6:\"active\";s:7:\"created\";i:0;s:6:\"expiry\";i:0;s:4:\"name\";s:9:\"Developer\";s:8:\"lifetime\";b:1;s:8:\"refunded\";b:0;s:17:\"view_licenses_url\";s:62:\"https://www.advancedcustomfields.com/my-account/view-licenses/\";s:23:\"manage_subscription_url\";s:0:\"\";s:9:\"error_msg\";s:0:\"\";s:10:\"next_check\";i:1733970838;s:16:\"legacy_multisite\";b:1;}','on'),
(2911,'acf_site_health','{\"version\":\"6.3.9\",\"plugin_type\":\"PRO\",\"update_source\":\"ACF Direct\",\"activated\":true,\"activated_url\":\"https:\\/\\/wpeb.ddev.site\",\"license_type\":\"Developer\",\"license_status\":\"active\",\"subscription_expires\":\"\",\"wp_version\":\"6.6.2\",\"mysql_version\":\"10.11.10-MariaDB-ubu2204-log\",\"is_multisite\":false,\"active_theme\":{\"name\":\"WP Easy Bruce\",\"version\":\"2024-07-23\",\"theme_uri\":\"https:\\/\\/github.com\\/crazyyy\\/wp-framework\",\"stylesheet\":false},\"active_plugins\":{\"advanced-custom-fields-pro\\/acf.php\":{\"name\":\"Advanced Custom Fields PRO\",\"version\":\"6.3.9\",\"plugin_uri\":\"https:\\/\\/www.advancedcustomfields.com\"},\"classic-editor\\/classic-editor.php\":{\"name\":\"Classic Editor\",\"version\":\"1.6.5\",\"plugin_uri\":\"https:\\/\\/wordpress.org\\/plugins\\/classic-editor\\/\"},\"classic-widgets\\/classic-widgets.php\":{\"name\":\"Classic Widgets\",\"version\":\"0.3\",\"plugin_uri\":\"https:\\/\\/wordpress.org\\/plugins\\/classic-widgets\\/\"},\"contact-form-7\\/wp-contact-form-7.php\":{\"name\":\"Contact Form 7\",\"version\":\"5.9.8\",\"plugin_uri\":\"https:\\/\\/contactform7.com\\/\"},\"contact-form-cfdb7\\/contact-form-cfdb-7.php\":{\"name\":\"Contact Form CFDB7\",\"version\":\"1.2.7\",\"plugin_uri\":\"https:\\/\\/ciphercoin.com\\/\"},\"https-redirection\\/https-redirection.php\":{\"name\":\"Easy HTTPS (SSL) Redirection\",\"version\":\"1.9.2\",\"plugin_uri\":\"https:\\/\\/www.tipsandtricks-hq.com\\/wordpress-easy-https-redirection-plugin\"},\"enable-svg-webp-ico-upload\\/itc-svg-upload.php\":{\"name\":\"Enable SVG, WebP, and ICO Upload\",\"version\":\"1.0.6\",\"plugin_uri\":\"https:\\/\\/ideastocode.com\\/plugins\\/enable-svg-WebP-ico-upload\\/\"},\"auto-sizes\\/auto-sizes.php\":{\"name\":\"Enhanced Responsive Images\",\"version\":\"1.3.0\",\"plugin_uri\":\"https:\\/\\/github.com\\/WordPress\\/performance\\/tree\\/trunk\\/plugins\\/auto-sizes\"},\"health-check\\/health-check.php\":{\"name\":\"Health Check & Troubleshooting\",\"version\":\"1.7.1\",\"plugin_uri\":\"https:\\/\\/wordpress.org\\/plugins\\/health-check\\/\"},\"contact-form-7-honeypot\\/honeypot.php\":{\"name\":\"Honeypot for Contact Form 7\",\"version\":\"2.1.5\",\"plugin_uri\":\"https:\\/\\/wpexperts.io\\/\"},\"dominant-color-images\\/load.php\":{\"name\":\"Image Placeholders\",\"version\":\"1.1.2\",\"plugin_uri\":\"https:\\/\\/github.com\\/WordPress\\/performance\\/tree\\/trunk\\/plugins\\/dominant-color-images\"},\"index-wp-mysql-for-speed\\/index-wp-mysql-for-speed.php\":{\"name\":\"Index WP MySQL For Speed\",\"version\":\"1.5.2\",\"plugin_uri\":\"https:\\/\\/plumislandmedia.org\\/index-wp-mysql-for-speed\\/\"},\"webp-uploads\\/load.php\":{\"name\":\"Modern Image Formats\",\"version\":\"2.2.0\",\"plugin_uri\":\"https:\\/\\/github.com\\/WordPress\\/performance\\/tree\\/trunk\\/plugins\\/webp-uploads\"},\"performance-lab\\/load.php\":{\"name\":\"Performance Lab\",\"version\":\"3.5.1\",\"plugin_uri\":\"https:\\/\\/github.com\\/WordPress\\/performance\"},\"performant-translations\\/performant-translations.php\":{\"name\":\"Performant Translations\",\"version\":\"1.2.0\",\"plugin_uri\":\"https:\\/\\/github.com\\/swissspidy\\/performant-translations\"},\"query-monitor\\/query-monitor.php\":{\"name\":\"Query Monitor\",\"version\":\"3.16.4\",\"plugin_uri\":\"https:\\/\\/querymonitor.com\\/\"},\"site-health-manager\\/site-health-manager.php\":{\"name\":\"Site Health Manager\",\"version\":\"1.1.2\",\"plugin_uri\":\"https:\\/\\/wordpress.org\\/plugins\\/site-health-manager\\/\"},\"svg-support\\/svg-support.php\":{\"name\":\"SVG Support\",\"version\":\"2.5.8\",\"plugin_uri\":\"http:\\/\\/wordpress.org\\/plugins\\/svg-support\\/\"},\"ukr-to-lat\\/ukr-to-lat.php\":{\"name\":\"Ukr-To-Lat\",\"version\":\"1.3.5\",\"plugin_uri\":\"https:\\/\\/wordpress.org\\/plugins\\/ukr-to-lat\\/\"}},\"ui_field_groups\":\"0\",\"php_field_groups\":\"0\",\"json_field_groups\":\"0\",\"rest_field_groups\":\"0\",\"number_of_fields_by_type\":[],\"number_of_third_party_fields_by_type\":[],\"post_types_enabled\":true,\"ui_post_types\":\"4\",\"json_post_types\":\"0\",\"ui_taxonomies\":\"3\",\"json_taxonomies\":\"0\",\"ui_options_pages_enabled\":true,\"ui_options_pages\":\"0\",\"json_options_pages\":\"0\",\"php_options_pages\":\"0\",\"rest_api_format\":\"standard\",\"registered_acf_blocks\":\"1\",\"blocks_per_api_version\":{\"v2\":1},\"blocks_per_acf_block_version\":{\"v1\":1},\"blocks_using_post_meta\":\"0\",\"preload_blocks\":true,\"admin_ui_enabled\":true,\"field_type-modal_enabled\":true,\"field_settings_tabs_enabled\":false,\"shortcode_enabled\":true,\"registered_acf_forms\":\"0\",\"json_save_paths\":1,\"json_load_paths\":1,\"last_updated\":1733960045}','off'),
(1287,'acf_version','6.3.11','yes'),
(36,'active_plugins','a:19:{i:0;s:31:\"query-monitor/query-monitor.php\";i:1;s:34:\"advanced-custom-fields-pro/acf.php\";i:2;s:25:\"auto-sizes/auto-sizes.php\";i:3;s:33:\"classic-editor/classic-editor.php\";i:4;s:35:\"classic-widgets/classic-widgets.php\";i:5;s:36:\"contact-form-7-honeypot/honeypot.php\";i:6;s:36:\"contact-form-7/wp-contact-form-7.php\";i:7;s:42:\"contact-form-cfdb7/contact-form-cfdb-7.php\";i:8;s:30:\"dominant-color-images/load.php\";i:9;s:45:\"enable-svg-webp-ico-upload/itc-svg-upload.php\";i:10;s:29:\"health-check/health-check.php\";i:11;s:39:\"https-redirection/https-redirection.php\";i:12;s:53:\"index-wp-mysql-for-speed/index-wp-mysql-for-speed.php\";i:13;s:24:\"performance-lab/load.php\";i:14;s:51:\"performant-translations/performant-translations.php\";i:15;s:43:\"site-health-manager/site-health-manager.php\";i:16;s:27:\"svg-support/svg-support.php\";i:17;s:25:\"ukr-to-lat/ukr-to-lat.php\";i:18;s:21:\"webp-uploads/load.php\";}','yes'),
(148,'add_admin_marker_timestamp','1352375601','no'),
(5,'admin_email','crazyyy@gmail.com','yes'),
(1874,'admin_email_lifespan','1749512042','yes'),
(605,'aio_wp_security_configs','a:112:{s:36:\"aiowps_remove_wp_generator_meta_info\";s:1:\"1\";s:25:\"aiowps_prevent_hotlinking\";s:0:\"\";s:28:\"aiowps_enable_login_lockdown\";s:1:\"1\";s:28:\"aiowps_allow_unlock_requests\";s:1:\"1\";s:25:\"aiowps_max_login_attempts\";i:3;s:24:\"aiowps_retry_time_period\";i:5;s:26:\"aiowps_lockout_time_length\";i:60;s:28:\"aiowps_set_generic_login_msg\";s:1:\"1\";s:26:\"aiowps_enable_email_notify\";s:1:\"1\";s:20:\"aiowps_email_address\";s:19:\"info@wpeb.ddev.site\";s:27:\"aiowps_enable_forced_logout\";s:0:\"\";s:25:\"aiowps_logout_time_period\";s:2:\"60\";s:39:\"aiowps_enable_invalid_username_lockdown\";s:0:\"\";s:32:\"aiowps_unlock_request_secret_key\";s:20:\"ohy7ttxzt7k9r5my7rlz\";s:26:\"aiowps_enable_whitelisting\";s:0:\"\";s:27:\"aiowps_allowed_ip_addresses\";s:0:\"\";s:27:\"aiowps_enable_login_captcha\";s:1:\"1\";s:34:\"aiowps_enable_custom_login_captcha\";s:1:\"1\";s:25:\"aiowps_captcha_secret_key\";s:20:\"evnb4iydqjtw24ixfuh9\";s:42:\"aiowps_enable_manual_registration_approval\";s:0:\"\";s:39:\"aiowps_enable_registration_page_captcha\";s:1:\"1\";s:27:\"aiowps_enable_random_prefix\";s:0:\"\";s:31:\"aiowps_enable_automated_backups\";s:1:\"1\";s:26:\"aiowps_db_backup_frequency\";i:1;s:25:\"aiowps_db_backup_interval\";s:1:\"2\";s:26:\"aiowps_backup_files_stored\";i:5;s:32:\"aiowps_send_backup_email_address\";s:0:\"\";s:27:\"aiowps_backup_email_address\";s:19:\"info@wpeb.ddev.site\";s:27:\"aiowps_disable_file_editing\";s:1:\"1\";s:37:\"aiowps_prevent_default_wp_file_access\";s:0:\"\";s:22:\"aiowps_system_log_file\";s:9:\"error_log\";s:26:\"aiowps_enable_blacklisting\";s:0:\"\";s:26:\"aiowps_banned_ip_addresses\";s:0:\"\";s:28:\"aiowps_enable_basic_firewall\";s:0:\"\";s:31:\"aiowps_enable_pingback_firewall\";s:0:\"\";s:26:\"aiowps_disable_index_views\";s:0:\"\";s:30:\"aiowps_disable_trace_and_track\";s:0:\"\";s:28:\"aiowps_forbid_proxy_comments\";s:0:\"\";s:29:\"aiowps_deny_bad_query_strings\";s:0:\"\";s:34:\"aiowps_advanced_char_string_filter\";s:0:\"\";s:25:\"aiowps_enable_5g_firewall\";s:0:\"\";s:25:\"aiowps_enable_404_logging\";s:0:\"\";s:28:\"aiowps_enable_404_IP_lockout\";s:0:\"\";s:30:\"aiowps_404_lockout_time_length\";s:2:\"60\";s:28:\"aiowps_404_lock_redirect_url\";s:16:\"http://127.0.0.1\";s:31:\"aiowps_enable_rename_login_page\";s:0:\"\";s:28:\"aiowps_enable_login_honeypot\";s:1:\"1\";s:43:\"aiowps_enable_brute_force_attack_prevention\";s:0:\"\";s:30:\"aiowps_brute_force_secret_word\";s:0:\"\";s:24:\"aiowps_cookie_brute_test\";s:29:\"aiowps_cookie_test_iba7hg8tzh\";s:44:\"aiowps_cookie_based_brute_force_redirect_url\";s:16:\"http://127.0.0.1\";s:59:\"aiowps_brute_force_attack_prevention_pw_protected_exception\";s:0:\"\";s:51:\"aiowps_brute_force_attack_prevention_ajax_exception\";s:0:\"\";s:19:\"aiowps_site_lockout\";s:0:\"\";s:23:\"aiowps_site_lockout_msg\";s:0:\"\";s:30:\"aiowps_enable_spambot_blocking\";s:0:\"\";s:29:\"aiowps_enable_comment_captcha\";s:1:\"1\";s:32:\"aiowps_enable_automated_fcd_scan\";s:1:\"1\";s:25:\"aiowps_fcd_scan_frequency\";i:2;s:24:\"aiowps_fcd_scan_interval\";s:1:\"2\";s:28:\"aiowps_fcd_exclude_filetypes\";s:0:\"\";s:24:\"aiowps_fcd_exclude_files\";s:5:\"cache\";s:26:\"aiowps_send_fcd_scan_email\";s:1:\"1\";s:29:\"aiowps_fcd_scan_email_address\";s:19:\"info@wpeb.ddev.site\";s:27:\"aiowps_fcds_change_detected\";b:0;s:22:\"aiowps_copy_protection\";s:0:\"\";s:40:\"aiowps_prevent_site_display_inside_frame\";s:0:\"\";s:35:\"aiowps_enable_lost_password_captcha\";s:1:\"1\";s:23:\"aiowps_last_backup_time\";s:19:\"2022-08-25 20:37:50\";s:25:\"aiowps_last_fcd_scan_time\";s:19:\"2022-08-25 20:37:51\";s:19:\"aiowps_enable_debug\";s:0:\"\";s:34:\"aiowps_block_debug_log_file_access\";s:0:\"\";s:25:\"aiowps_enable_6g_firewall\";s:0:\"\";s:26:\"aiowps_enable_custom_rules\";s:0:\"\";s:19:\"aiowps_custom_rules\";s:0:\"\";s:31:\"aiowps_enable_autoblock_spam_ip\";s:1:\"1\";s:33:\"aiowps_spam_ip_min_comments_block\";i:3;s:32:\"aiowps_prevent_users_enumeration\";s:1:\"1\";s:43:\"aiowps_instantly_lockout_specific_usernames\";a:0:{}s:35:\"aiowps_lockdown_enable_whitelisting\";s:0:\"\";s:36:\"aiowps_lockdown_allowed_ip_addresses\";s:0:\"\";s:35:\"aiowps_enable_registration_honeypot\";s:1:\"1\";s:38:\"aiowps_disable_xmlrpc_pingback_methods\";s:0:\"\";s:28:\"aiowps_block_fake_googlebots\";s:1:\"1\";s:26:\"aiowps_cookie_test_success\";s:1:\"1\";s:31:\"aiowps_enable_woo_login_captcha\";s:1:\"1\";s:34:\"aiowps_enable_woo_register_captcha\";s:1:\"1\";s:38:\"aiowps_enable_woo_lostpassword_captcha\";s:1:\"1\";s:25:\"aiowps_recaptcha_site_key\";s:0:\"\";s:27:\"aiowps_recaptcha_secret_key\";s:0:\"\";s:24:\"aiowps_default_recaptcha\";s:0:\"\";s:19:\"aiowps_fcd_filename\";s:26:\"aiowps_fcd_data_ml5x64pna5\";s:27:\"aiowps_max_file_upload_size\";s:2:\"10\";s:32:\"aiowps_place_custom_rules_at_top\";s:0:\"\";s:33:\"aiowps_enable_bp_register_captcha\";s:0:\"\";s:35:\"aiowps_enable_bbp_new_topic_captcha\";s:0:\"\";s:42:\"aiowps_disallow_unauthorized_rest_requests\";s:0:\"\";s:25:\"aiowps_ip_retrieve_method\";s:1:\"0\";s:12:\"installed-at\";i:1661449064;s:17:\"dismissdashnotice\";i:1693125855;s:36:\"aiowps_enable_php_backtrace_in_email\";s:0:\"\";s:30:\"aiowps_max_lockout_time_length\";s:2:\"60\";s:22:\"aiowps_default_captcha\";s:0:\"\";s:33:\"aiowps_disable_rss_and_atom_feeds\";s:0:\"\";s:35:\"aiowps_disable_application_password\";s:0:\"\";s:33:\"aiowps_enable_trash_spam_comments\";s:0:\"\";s:37:\"aiowps_trash_spam_comments_after_days\";s:2:\"14\";s:25:\"aiowps_turnstile_site_key\";s:0:\"\";s:27:\"aiowps_turnstile_secret_key\";s:0:\"\";s:36:\"aiowps_on_uninstall_delete_db_tables\";s:1:\"1\";s:34:\"aiowps_on_uninstall_delete_configs\";s:1:\"1\";s:21:\"aios_firewall_dismiss\";b:0;}','yes'),
(2416,'aiowps_temp_configs','a:111:{s:36:\"aiowps_remove_wp_generator_meta_info\";s:1:\"1\";s:25:\"aiowps_prevent_hotlinking\";s:1:\"1\";s:28:\"aiowps_enable_login_lockdown\";s:1:\"1\";s:28:\"aiowps_allow_unlock_requests\";s:1:\"1\";s:25:\"aiowps_max_login_attempts\";i:3;s:24:\"aiowps_retry_time_period\";i:5;s:26:\"aiowps_lockout_time_length\";i:60;s:28:\"aiowps_set_generic_login_msg\";s:1:\"1\";s:26:\"aiowps_enable_email_notify\";s:1:\"1\";s:20:\"aiowps_email_address\";s:19:\"info@wpeb.ddev.site\";s:27:\"aiowps_enable_forced_logout\";s:0:\"\";s:25:\"aiowps_logout_time_period\";s:2:\"60\";s:39:\"aiowps_enable_invalid_username_lockdown\";s:0:\"\";s:32:\"aiowps_unlock_request_secret_key\";s:20:\"ohy7ttxzt7k9r5my7rlz\";s:26:\"aiowps_enable_whitelisting\";s:0:\"\";s:27:\"aiowps_allowed_ip_addresses\";s:0:\"\";s:27:\"aiowps_enable_login_captcha\";s:1:\"1\";s:34:\"aiowps_enable_custom_login_captcha\";s:1:\"1\";s:25:\"aiowps_captcha_secret_key\";s:20:\"evnb4iydqjtw24ixfuh9\";s:42:\"aiowps_enable_manual_registration_approval\";s:0:\"\";s:39:\"aiowps_enable_registration_page_captcha\";s:1:\"1\";s:27:\"aiowps_enable_random_prefix\";s:0:\"\";s:31:\"aiowps_enable_automated_backups\";s:1:\"1\";s:26:\"aiowps_db_backup_frequency\";i:1;s:25:\"aiowps_db_backup_interval\";s:1:\"2\";s:26:\"aiowps_backup_files_stored\";i:5;s:32:\"aiowps_send_backup_email_address\";s:0:\"\";s:27:\"aiowps_backup_email_address\";s:19:\"info@wpeb.ddev.site\";s:27:\"aiowps_disable_file_editing\";s:1:\"1\";s:37:\"aiowps_prevent_default_wp_file_access\";s:1:\"1\";s:22:\"aiowps_system_log_file\";s:9:\"error_log\";s:26:\"aiowps_enable_blacklisting\";s:0:\"\";s:26:\"aiowps_banned_ip_addresses\";s:0:\"\";s:28:\"aiowps_enable_basic_firewall\";s:1:\"1\";s:31:\"aiowps_enable_pingback_firewall\";s:1:\"1\";s:26:\"aiowps_disable_index_views\";s:1:\"1\";s:30:\"aiowps_disable_trace_and_track\";s:1:\"1\";s:28:\"aiowps_forbid_proxy_comments\";s:1:\"1\";s:29:\"aiowps_deny_bad_query_strings\";s:1:\"1\";s:34:\"aiowps_advanced_char_string_filter\";s:1:\"1\";s:25:\"aiowps_enable_5g_firewall\";s:1:\"1\";s:25:\"aiowps_enable_404_logging\";s:0:\"\";s:28:\"aiowps_enable_404_IP_lockout\";s:0:\"\";s:30:\"aiowps_404_lockout_time_length\";s:2:\"60\";s:28:\"aiowps_404_lock_redirect_url\";s:16:\"http://127.0.0.1\";s:31:\"aiowps_enable_rename_login_page\";s:0:\"\";s:28:\"aiowps_enable_login_honeypot\";s:1:\"1\";s:43:\"aiowps_enable_brute_force_attack_prevention\";s:0:\"\";s:30:\"aiowps_brute_force_secret_word\";s:0:\"\";s:24:\"aiowps_cookie_brute_test\";s:29:\"aiowps_cookie_test_iba7hg8tzh\";s:44:\"aiowps_cookie_based_brute_force_redirect_url\";s:16:\"http://127.0.0.1\";s:59:\"aiowps_brute_force_attack_prevention_pw_protected_exception\";s:0:\"\";s:51:\"aiowps_brute_force_attack_prevention_ajax_exception\";s:0:\"\";s:19:\"aiowps_site_lockout\";s:0:\"\";s:23:\"aiowps_site_lockout_msg\";s:0:\"\";s:30:\"aiowps_enable_spambot_blocking\";s:1:\"1\";s:29:\"aiowps_enable_comment_captcha\";s:1:\"1\";s:32:\"aiowps_enable_automated_fcd_scan\";s:1:\"1\";s:25:\"aiowps_fcd_scan_frequency\";i:2;s:24:\"aiowps_fcd_scan_interval\";s:1:\"2\";s:28:\"aiowps_fcd_exclude_filetypes\";s:0:\"\";s:24:\"aiowps_fcd_exclude_files\";s:5:\"cache\";s:26:\"aiowps_send_fcd_scan_email\";s:1:\"1\";s:29:\"aiowps_fcd_scan_email_address\";s:19:\"info@wpeb.ddev.site\";s:27:\"aiowps_fcds_change_detected\";b:0;s:22:\"aiowps_copy_protection\";s:0:\"\";s:40:\"aiowps_prevent_site_display_inside_frame\";s:0:\"\";s:35:\"aiowps_enable_lost_password_captcha\";s:1:\"1\";s:23:\"aiowps_last_backup_time\";s:19:\"2022-08-25 20:37:50\";s:25:\"aiowps_last_fcd_scan_time\";s:19:\"2022-08-25 20:37:51\";s:19:\"aiowps_enable_debug\";s:0:\"\";s:34:\"aiowps_block_debug_log_file_access\";s:1:\"1\";s:25:\"aiowps_enable_6g_firewall\";s:1:\"1\";s:26:\"aiowps_enable_custom_rules\";s:0:\"\";s:19:\"aiowps_custom_rules\";s:0:\"\";s:31:\"aiowps_enable_autoblock_spam_ip\";s:1:\"1\";s:33:\"aiowps_spam_ip_min_comments_block\";i:3;s:32:\"aiowps_prevent_users_enumeration\";s:1:\"1\";s:43:\"aiowps_instantly_lockout_specific_usernames\";a:0:{}s:35:\"aiowps_lockdown_enable_whitelisting\";s:0:\"\";s:36:\"aiowps_lockdown_allowed_ip_addresses\";s:0:\"\";s:35:\"aiowps_enable_registration_honeypot\";s:1:\"1\";s:38:\"aiowps_disable_xmlrpc_pingback_methods\";s:0:\"\";s:28:\"aiowps_block_fake_googlebots\";s:1:\"1\";s:26:\"aiowps_cookie_test_success\";s:1:\"1\";s:31:\"aiowps_enable_woo_login_captcha\";s:1:\"1\";s:34:\"aiowps_enable_woo_register_captcha\";s:1:\"1\";s:38:\"aiowps_enable_woo_lostpassword_captcha\";s:1:\"1\";s:25:\"aiowps_recaptcha_site_key\";s:0:\"\";s:27:\"aiowps_recaptcha_secret_key\";s:0:\"\";s:24:\"aiowps_default_recaptcha\";s:0:\"\";s:19:\"aiowps_fcd_filename\";s:26:\"aiowps_fcd_data_ml5x64pna5\";s:27:\"aiowps_max_file_upload_size\";s:2:\"10\";s:32:\"aiowps_place_custom_rules_at_top\";s:0:\"\";s:33:\"aiowps_enable_bp_register_captcha\";s:0:\"\";s:35:\"aiowps_enable_bbp_new_topic_captcha\";s:0:\"\";s:42:\"aiowps_disallow_unauthorized_rest_requests\";s:0:\"\";s:25:\"aiowps_ip_retrieve_method\";s:1:\"0\";s:12:\"installed-at\";i:1661449064;s:17:\"dismissdashnotice\";i:1693125855;s:36:\"aiowps_enable_php_backtrace_in_email\";s:0:\"\";s:30:\"aiowps_max_lockout_time_length\";s:2:\"60\";s:22:\"aiowps_default_captcha\";s:0:\"\";s:33:\"aiowps_disable_rss_and_atom_feeds\";s:0:\"\";s:35:\"aiowps_disable_application_password\";s:0:\"\";s:33:\"aiowps_enable_trash_spam_comments\";s:0:\"\";s:37:\"aiowps_trash_spam_comments_after_days\";s:2:\"14\";s:25:\"aiowps_turnstile_site_key\";s:0:\"\";s:27:\"aiowps_turnstile_secret_key\";s:0:\"\";s:36:\"aiowps_on_uninstall_delete_db_tables\";s:1:\"1\";s:34:\"aiowps_on_uninstall_delete_configs\";s:1:\"1\";}','yes'),
(604,'aiowpsec_db_version','1.9.8','yes'),
(2409,'aiowpsec_firewall_version','1.0.3','yes'),
(650,'auto_core_update_notified','a:4:{s:4:\"type\";s:7:\"success\";s:5:\"email\";s:12:\"info@wpeb.ddev.site\";s:7:\"version\";s:5:\"3.8.1\";s:9:\"timestamp\";i:1395700963;}','yes'),
(1997,'auto_plugin_theme_update_emails','a:0:{}','no'),
(1998,'auto_update_core_dev','enabled','yes'),
(2000,'auto_update_core_major','unset','yes'),
(1999,'auto_update_core_minor','enabled','yes'),
(2022,'auto_update_plugins','a:55:{i:1;s:51:\"all-in-one-wp-security-and-firewall/wp-security.php\";i:2;s:43:\"broken-link-checker/broken-link-checker.php\";i:3;s:33:\"classic-editor/classic-editor.php\";i:4;s:33:\"complianz-gdpr/complianz-gpdr.php\";i:5;s:36:\"contact-form-7/wp-contact-form-7.php\";i:6;s:42:\"contact-form-cfdb7/contact-form-cfdb-7.php\";i:7;s:25:\"fakerpress/fakerpress.php\";i:8;s:29:\"health-check/health-check.php\";i:9;s:35:\"litespeed-cache/litespeed-cache.php\";i:11;s:27:\"updraftplus/updraftplus.php\";i:12;s:41:\"wordpress-importer/wordpress-importer.php\";i:13;s:39:\"wp-file-manager/file_folder_manager.php\";i:14;s:27:\"wp-optimize/wp-optimize.php\";i:15;s:34:\"advanced-custom-fields-pro/acf.php\";i:16;s:29:\"acf-extended/acf-extended.php\";i:17;s:53:\"child-theme-configurator/child-theme-configurator.php\";i:18;s:35:\"classic-widgets/classic-widgets.php\";i:20;s:43:\"custom-post-type-ui/custom-post-type-ui.php\";i:22;s:45:\"enable-svg-webp-ico-upload/itc-svg-upload.php\";i:23;s:45:\"ewww-image-optimizer/ewww-image-optimizer.php\";i:24;s:36:\"contact-form-7-honeypot/honeypot.php\";i:25;s:53:\"index-wp-mysql-for-speed/index-wp-mysql-for-speed.php\";i:26;s:24:\"performance-lab/load.php\";i:29;s:55:\"plugins-garbage-collector/plugins-garbage-collector.php\";i:30;s:31:\"query-monitor/query-monitor.php\";i:31;s:30:\"seo-by-rank-math/rank-math.php\";i:32;s:17:\"revisr/revisr.php\";i:33;s:33:\"seo-image/seo-friendly-images.php\";i:34;s:35:\"google-site-kit/google-site-kit.php\";i:39;s:37:\"wp-reroute-email/wp-reroute-email.php\";i:42;s:39:\"bulk-page-creator/bulk-page-creator.php\";i:43;s:41:\"child-theme-wizard/child-theme-wizard.php\";i:45;s:53:\"customizer-export-import/customizer-export-import.php\";i:49;s:43:\"site-health-manager/site-health-manager.php\";i:51;s:25:\"ukr-to-lat/ukr-to-lat.php\";i:52;s:36:\"inspector-wp/wordpress-inspector.php\";i:54;s:53:\"widget-importer-exporter/widget-importer-exporter.php\";i:55;s:23:\"wordfence/wordfence.php\";i:57;s:39:\"https-redirection/https-redirection.php\";i:58;s:45:\"search-and-replace/inpsyde-search-replace.php\";i:59;s:41:\"acf-code-generator/acf_code_generator.php\";i:62;s:41:\"acf-theme-code-pro/acf_theme_code_pro.php\";i:64;s:51:\"all-in-one-wp-migration/all-in-one-wp-migration.php\";i:65;s:91:\"all-in-one-wp-migration-unlimited-extension/all-in-one-wp-migration-unlimited-extension.php\";i:66;s:41:\"another-show-hooks/another-show-hooks.php\";i:67;s:25:\"auto-sizes/auto-sizes.php\";i:74;s:33:\"code-generator/code-generator.php\";i:86;s:29:\"http-headers/http-headers.php\";i:87;s:30:\"dominant-color-images/load.php\";i:90;s:21:\"webp-uploads/load.php\";i:92;s:45:\"performance-profiler/performance-profiler.php\";i:93;s:51:\"performant-translations/performant-translations.php\";i:96;s:39:\"query-monitor-log-viewer/log-viewer.php\";i:103;s:27:\"svg-support/svg-support.php\";i:111;s:33:\"wp-performance/wp-performance.php\";}','no'),
(68,'avatar_default','wavatar','yes'),
(61,'avatar_rating','G','yes'),
(34,'blog_charset','UTF-8','yes'),
(56,'blog_public','1','yes'),
(3,'blogdescription','','yes'),
(2,'blogname','WBEP Framework','yes'),
(2946,'bodhi_svgs_plugin_version','2.5.8','yes'),
(2947,'bodhi_svgs_settings','a:4:{s:22:\"sanitize_svg_front_end\";s:2:\"on\";s:8:\"restrict\";a:1:{i:0;s:13:\"administrator\";}s:24:\"sanitize_on_upload_roles\";a:2:{i:0;s:13:\"administrator\";i:1;s:6:\"editor\";}s:10:\"css_target\";s:0:\"\";}','yes'),
(520,'bwp_gxs_log','a:2:{s:3:\"log\";a:0:{}s:7:\"sitemap\";a:0:{}}','yes'),
(2990,'can_compress_scripts','0','on'),
(38,'category_base','/','yes'),
(2658,'category_children','a:0:{}','yes'),
(2801,'cfdb7_view_ignore_notice','true','yes'),
(1937,'cfdb7_view_install_date','2020-02-03 16:47:01','yes'),
(1951,'classic-editor-allow-users','disallow','yes'),
(1950,'classic-editor-replace','classic','yes'),
(77,'close_comments_days_old','31','yes'),
(76,'close_comments_for_old_posts','','yes'),
(41,'comment_max_links','2','yes'),
(29,'comment_moderation','','yes'),
(83,'comment_order','asc','yes'),
(1996,'comment_previously_approved','1','yes'),
(49,'comment_registration','','yes'),
(10,'comments_notify','1','yes'),
(81,'comments_per_page','50','yes'),
(1940,'cptui_new_install','false','yes'),
(104,'cron','a:17:{i:1733961181;a:1:{s:29:\"simple_history/maybe_purge_db\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1733961813;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1733964139;a:1:{s:16:\"itsec_purge_logs\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1733983548;a:1:{s:21:\"wp_update_user_counts\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1733984175;a:1:{s:23:\"aiowps_clean_old_events\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1733986436;a:1:{s:32:\"recovery_mode_clean_expired_keys\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1734000322;a:1:{s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1734000487;a:3:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1734000497;a:1:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1734005513;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1734033600;a:1:{s:19:\"hmbkp_schedule_hook\";a:1:{s:32:\"7238d8d892636ada924d8907a1becaca\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:1:{s:2:\"id\";s:10:\"1434587998\";}s:8:\"interval\";i:86400;}}}i:1734039300;a:1:{s:30:\"wp_delete_temp_updater_backups\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}i:1734082099;a:1:{s:30:\"wp_site_health_scheduled_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}i:1734359783;a:1:{s:18:\"wpseo_onpage_fetch\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}i:1734501389;a:1:{s:27:\"acf_update_site_health_data\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}i:1734502588;a:1:{s:24:\"aiowps_weekly_cron_event\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}s:7:\"version\";i:2;}','yes'),
(412,'current_theme','WP Wheel','yes'),
(2535,'d4p_blog_sweeppress_cache','a:1:{s:8:\"sweepers\";a:29:{s:16:\"posts-auto-draft\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:14:{s:4:\"post\";a:7:{s:4:\"type\";s:9:\"post_type\";s:10:\"registered\";b:1;s:10:\"real_title\";s:4:\"post\";s:5:\"title\";s:5:\"Posts\";s:5:\"items\";i:1;s:7:\"records\";i:1;s:4:\"size\";i:0;}s:4:\"page\";a:5:{s:5:\"title\";s:5:\"Pages\";s:10:\"real_title\";s:4:\"page\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:10:\"attachment\";a:5:{s:5:\"title\";s:5:\"Media\";s:10:\"real_title\";s:10:\"attachment\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:8:\"revision\";a:5:{s:5:\"title\";s:9:\"Revisions\";s:10:\"real_title\";s:8:\"revision\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:13:\"nav_menu_item\";a:5:{s:5:\"title\";s:21:\"Navigation Menu Items\";s:10:\"real_title\";s:13:\"nav_menu_item\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:10:\"custom_css\";a:5:{s:5:\"title\";s:10:\"Custom CSS\";s:10:\"real_title\";s:10:\"custom_css\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:19:\"customize_changeset\";a:5:{s:5:\"title\";s:10:\"Changesets\";s:10:\"real_title\";s:19:\"customize_changeset\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:12:\"oembed_cache\";a:5:{s:5:\"title\";s:16:\"oEmbed Responses\";s:10:\"real_title\";s:12:\"oembed_cache\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:12:\"user_request\";a:5:{s:5:\"title\";s:13:\"User Requests\";s:10:\"real_title\";s:12:\"user_request\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:8:\"wp_block\";a:5:{s:5:\"title\";s:15:\"Reusable blocks\";s:10:\"real_title\";s:8:\"wp_block\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:11:\"wp_template\";a:5:{s:5:\"title\";s:9:\"Templates\";s:10:\"real_title\";s:11:\"wp_template\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:16:\"wp_template_part\";a:5:{s:5:\"title\";s:14:\"Template Parts\";s:10:\"real_title\";s:16:\"wp_template_part\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:16:\"wp_global_styles\";a:5:{s:5:\"title\";s:13:\"Global Styles\";s:10:\"real_title\";s:16:\"wp_global_styles\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:13:\"wp_navigation\";a:5:{s:5:\"title\";s:16:\"Navigation Menus\";s:10:\"real_title\";s:13:\"wp_navigation\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:10:\"posts-spam\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:14:{s:4:\"post\";a:5:{s:5:\"title\";s:5:\"Posts\";s:10:\"real_title\";s:4:\"post\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:4:\"page\";a:5:{s:5:\"title\";s:5:\"Pages\";s:10:\"real_title\";s:4:\"page\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:10:\"attachment\";a:5:{s:5:\"title\";s:5:\"Media\";s:10:\"real_title\";s:10:\"attachment\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:8:\"revision\";a:5:{s:5:\"title\";s:9:\"Revisions\";s:10:\"real_title\";s:8:\"revision\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:13:\"nav_menu_item\";a:5:{s:5:\"title\";s:21:\"Navigation Menu Items\";s:10:\"real_title\";s:13:\"nav_menu_item\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:10:\"custom_css\";a:5:{s:5:\"title\";s:10:\"Custom CSS\";s:10:\"real_title\";s:10:\"custom_css\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:19:\"customize_changeset\";a:5:{s:5:\"title\";s:10:\"Changesets\";s:10:\"real_title\";s:19:\"customize_changeset\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:12:\"oembed_cache\";a:5:{s:5:\"title\";s:16:\"oEmbed Responses\";s:10:\"real_title\";s:12:\"oembed_cache\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:12:\"user_request\";a:5:{s:5:\"title\";s:13:\"User Requests\";s:10:\"real_title\";s:12:\"user_request\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:8:\"wp_block\";a:5:{s:5:\"title\";s:15:\"Reusable blocks\";s:10:\"real_title\";s:8:\"wp_block\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:11:\"wp_template\";a:5:{s:5:\"title\";s:9:\"Templates\";s:10:\"real_title\";s:11:\"wp_template\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:16:\"wp_template_part\";a:5:{s:5:\"title\";s:14:\"Template Parts\";s:10:\"real_title\";s:16:\"wp_template_part\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:16:\"wp_global_styles\";a:5:{s:5:\"title\";s:13:\"Global Styles\";s:10:\"real_title\";s:16:\"wp_global_styles\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:13:\"wp_navigation\";a:5:{s:5:\"title\";s:16:\"Navigation Menus\";s:10:\"real_title\";s:13:\"wp_navigation\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:11:\"posts-trash\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:14:{s:4:\"post\";a:5:{s:5:\"title\";s:5:\"Posts\";s:10:\"real_title\";s:4:\"post\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:4:\"page\";a:5:{s:5:\"title\";s:5:\"Pages\";s:10:\"real_title\";s:4:\"page\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:10:\"attachment\";a:5:{s:5:\"title\";s:5:\"Media\";s:10:\"real_title\";s:10:\"attachment\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:8:\"revision\";a:5:{s:5:\"title\";s:9:\"Revisions\";s:10:\"real_title\";s:8:\"revision\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:13:\"nav_menu_item\";a:5:{s:5:\"title\";s:21:\"Navigation Menu Items\";s:10:\"real_title\";s:13:\"nav_menu_item\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:10:\"custom_css\";a:5:{s:5:\"title\";s:10:\"Custom CSS\";s:10:\"real_title\";s:10:\"custom_css\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:19:\"customize_changeset\";a:5:{s:5:\"title\";s:10:\"Changesets\";s:10:\"real_title\";s:19:\"customize_changeset\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:12:\"oembed_cache\";a:5:{s:5:\"title\";s:16:\"oEmbed Responses\";s:10:\"real_title\";s:12:\"oembed_cache\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:12:\"user_request\";a:5:{s:5:\"title\";s:13:\"User Requests\";s:10:\"real_title\";s:12:\"user_request\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:8:\"wp_block\";a:5:{s:5:\"title\";s:15:\"Reusable blocks\";s:10:\"real_title\";s:8:\"wp_block\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:11:\"wp_template\";a:5:{s:5:\"title\";s:9:\"Templates\";s:10:\"real_title\";s:11:\"wp_template\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:16:\"wp_template_part\";a:5:{s:5:\"title\";s:14:\"Template Parts\";s:10:\"real_title\";s:16:\"wp_template_part\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:16:\"wp_global_styles\";a:5:{s:5:\"title\";s:13:\"Global Styles\";s:10:\"real_title\";s:16:\"wp_global_styles\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:13:\"wp_navigation\";a:5:{s:5:\"title\";s:16:\"Navigation Menus\";s:10:\"real_title\";s:13:\"wp_navigation\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:15:\"posts-revisions\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:14:{s:4:\"post\";a:5:{s:5:\"title\";s:5:\"Posts\";s:10:\"real_title\";s:4:\"post\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:4:\"page\";a:5:{s:5:\"title\";s:5:\"Pages\";s:10:\"real_title\";s:4:\"page\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:10:\"attachment\";a:5:{s:5:\"title\";s:5:\"Media\";s:10:\"real_title\";s:10:\"attachment\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:8:\"revision\";a:5:{s:5:\"title\";s:9:\"Revisions\";s:10:\"real_title\";s:8:\"revision\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:13:\"nav_menu_item\";a:5:{s:5:\"title\";s:21:\"Navigation Menu Items\";s:10:\"real_title\";s:13:\"nav_menu_item\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:10:\"custom_css\";a:5:{s:5:\"title\";s:10:\"Custom CSS\";s:10:\"real_title\";s:10:\"custom_css\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:19:\"customize_changeset\";a:5:{s:5:\"title\";s:10:\"Changesets\";s:10:\"real_title\";s:19:\"customize_changeset\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:12:\"oembed_cache\";a:5:{s:5:\"title\";s:16:\"oEmbed Responses\";s:10:\"real_title\";s:12:\"oembed_cache\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:12:\"user_request\";a:5:{s:5:\"title\";s:13:\"User Requests\";s:10:\"real_title\";s:12:\"user_request\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:8:\"wp_block\";a:5:{s:5:\"title\";s:15:\"Reusable blocks\";s:10:\"real_title\";s:8:\"wp_block\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:11:\"wp_template\";a:5:{s:5:\"title\";s:9:\"Templates\";s:10:\"real_title\";s:11:\"wp_template\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:16:\"wp_template_part\";a:5:{s:5:\"title\";s:14:\"Template Parts\";s:10:\"real_title\";s:16:\"wp_template_part\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:16:\"wp_global_styles\";a:5:{s:5:\"title\";s:13:\"Global Styles\";s:10:\"real_title\";s:16:\"wp_global_styles\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:13:\"wp_navigation\";a:5:{s:5:\"title\";s:16:\"Navigation Menus\";s:10:\"real_title\";s:13:\"wp_navigation\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:21:\"posts-draft-revisions\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:14:{s:4:\"post\";a:5:{s:5:\"title\";s:5:\"Posts\";s:10:\"real_title\";s:4:\"post\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:4:\"page\";a:5:{s:5:\"title\";s:5:\"Pages\";s:10:\"real_title\";s:4:\"page\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:10:\"attachment\";a:5:{s:5:\"title\";s:5:\"Media\";s:10:\"real_title\";s:10:\"attachment\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:8:\"revision\";a:5:{s:5:\"title\";s:9:\"Revisions\";s:10:\"real_title\";s:8:\"revision\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:13:\"nav_menu_item\";a:5:{s:5:\"title\";s:21:\"Navigation Menu Items\";s:10:\"real_title\";s:13:\"nav_menu_item\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:10:\"custom_css\";a:5:{s:5:\"title\";s:10:\"Custom CSS\";s:10:\"real_title\";s:10:\"custom_css\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:19:\"customize_changeset\";a:5:{s:5:\"title\";s:10:\"Changesets\";s:10:\"real_title\";s:19:\"customize_changeset\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:12:\"oembed_cache\";a:5:{s:5:\"title\";s:16:\"oEmbed Responses\";s:10:\"real_title\";s:12:\"oembed_cache\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:12:\"user_request\";a:5:{s:5:\"title\";s:13:\"User Requests\";s:10:\"real_title\";s:12:\"user_request\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:8:\"wp_block\";a:5:{s:5:\"title\";s:15:\"Reusable blocks\";s:10:\"real_title\";s:8:\"wp_block\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:11:\"wp_template\";a:5:{s:5:\"title\";s:9:\"Templates\";s:10:\"real_title\";s:11:\"wp_template\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:16:\"wp_template_part\";a:5:{s:5:\"title\";s:14:\"Template Parts\";s:10:\"real_title\";s:16:\"wp_template_part\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:16:\"wp_global_styles\";a:5:{s:5:\"title\";s:13:\"Global Styles\";s:10:\"real_title\";s:16:\"wp_global_styles\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:13:\"wp_navigation\";a:5:{s:5:\"title\";s:16:\"Navigation Menus\";s:10:\"real_title\";s:13:\"wp_navigation\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:24:\"posts-orphaned-revisions\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:24:\"posts-orphaned-revisions\";a:3:{s:5:\"title\";s:18:\"Orphaned Revisions\";s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:14:\"postmeta-locks\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:14:\"postmeta-locks\";a:3:{s:5:\"title\";s:22:\"Meta key: \'_edit_lock\'\";s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:14:\"postmeta-edits\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:14:\"postmeta-edits\";a:3:{s:5:\"title\";s:22:\"Meta key: \'_edit_last\'\";s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:12:\"postmeta-old\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:2:{s:12:\"_wp_old_slug\";a:3:{s:5:\"title\";s:24:\"Meta key: \'_wp_old_slug\'\";s:7:\"records\";i:0;s:4:\"size\";i:0;}s:12:\"_wp_old_date\";a:3:{s:5:\"title\";s:24:\"Meta key: \'_wp_old_date\'\";s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:16:\"postmeta-oembeds\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:16:\"postmeta-oembeds\";a:3:{s:5:\"title\";s:14:\"OEmbed Records\";s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:16:\"postmeta-orphans\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:16:\"postmeta-orphans\";a:3:{s:5:\"title\";s:16:\"Orphaned Records\";s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:13:\"comments-spam\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:4:{s:7:\"comment\";a:5:{s:5:\"title\";s:7:\"Comment\";s:10:\"real_title\";s:7:\"comment\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:9:\"trackback\";a:5:{s:5:\"title\";s:9:\"Trackback\";s:10:\"real_title\";s:9:\"trackback\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:8:\"pingback\";a:5:{s:5:\"title\";s:8:\"Pingback\";s:10:\"real_title\";s:8:\"pingback\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:17:\"gdrts-user-review\";a:5:{s:5:\"title\";s:18:\"Rating User Review\";s:10:\"real_title\";s:17:\"gdrts-user-review\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:14:\"comments-trash\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:4:{s:7:\"comment\";a:5:{s:5:\"title\";s:7:\"Comment\";s:10:\"real_title\";s:7:\"comment\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:9:\"trackback\";a:5:{s:5:\"title\";s:9:\"Trackback\";s:10:\"real_title\";s:9:\"trackback\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:8:\"pingback\";a:5:{s:5:\"title\";s:8:\"Pingback\";s:10:\"real_title\";s:8:\"pingback\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:17:\"gdrts-user-review\";a:5:{s:5:\"title\";s:18:\"Rating User Review\";s:10:\"real_title\";s:17:\"gdrts-user-review\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:19:\"comments-unapproved\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:4:{s:7:\"comment\";a:5:{s:5:\"title\";s:7:\"Comment\";s:10:\"real_title\";s:7:\"comment\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:9:\"trackback\";a:5:{s:5:\"title\";s:9:\"Trackback\";s:10:\"real_title\";s:9:\"trackback\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:8:\"pingback\";a:5:{s:5:\"title\";s:8:\"Pingback\";s:10:\"real_title\";s:8:\"pingback\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}s:17:\"gdrts-user-review\";a:5:{s:5:\"title\";s:18:\"Rating User Review\";s:10:\"real_title\";s:17:\"gdrts-user-review\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:16:\"comments-orphans\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:16:\"comments-orphans\";a:4:{s:5:\"title\";s:17:\"Orphaned Comments\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:19:\"comments-user-agent\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:19:\"comments-user-agent\";a:3:{s:5:\"title\";s:23:\"Records with User Agent\";s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:19:\"commentmeta-orphans\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:19:\"commentmeta-orphans\";a:3:{s:5:\"title\";s:16:\"Orphaned Records\";s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:17:\"pingbacks-cleanup\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:17:\"pingbacks-cleanup\";a:5:{s:5:\"title\";s:8:\"Pingback\";s:10:\"real_title\";s:8:\"pingback\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:18:\"trackbacks-cleanup\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:18:\"trackbacks-cleanup\";a:5:{s:5:\"title\";s:9:\"Trackback\";s:10:\"real_title\";s:9:\"trackback\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:12:\"akismet-meta\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:12:\"akismet-meta\";a:4:{s:5:\"title\";s:15:\"Akismet Records\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:13:\"terms-orphans\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:13:\"terms-orphans\";a:4:{s:5:\"title\";s:14:\"Orphaned Terms\";s:5:\"items\";s:1:\"0\";s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:16:\"termmeta-orphans\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:16:\"termmeta-orphans\";a:3:{s:5:\"title\";s:16:\"Orphaned Records\";s:7:\"records\";s:1:\"0\";s:4:\"size\";s:1:\"0\";}}}s:16:\"usermeta-orphans\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:16:\"usermeta-orphans\";a:3:{s:5:\"title\";s:16:\"Orphaned Records\";s:7:\"records\";s:1:\"0\";s:4:\"size\";s:1:\"0\";}}}s:18:\"expired-transients\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:18:\"expired-transients\";a:5:{s:10:\"transients\";a:2:{s:4:\"site\";a:7:{i:0;s:42:\"php_check_653b16e6c5979ac325fae9f9db6a18fe\";i:1;s:49:\"community-events-1aecf33ab8525ff212ebdffbb438372e\";i:2;s:22:\"available_translations\";i:3;s:40:\"browser_d779790d920bc0f1ab1a364c74903611\";i:4;s:40:\"browser_759b1e79d21e38d89cd2791faa91f8c6\";i:5;s:42:\"php_check_3fde9d06ba9e4fd20d08658e6f30b792\";i:6;s:40:\"browser_199212111a57ddf8d1f2e5cbdad1a5e2\";}s:5:\"local\";a:5:{i:0;s:41:\"feed_mod_d117b5738fbd35bd8c0391cda1f2b5d9\";i:1;s:40:\"dash_v2_88ae138922fe95674369b1cb3d215a2b\";i:2;s:37:\"feed_9bbd59226dc36b9b26cd43f15694c5c3\";i:3;s:37:\"feed_d117b5738fbd35bd8c0391cda1f2b5d9\";i:4;s:41:\"feed_mod_9bbd59226dc36b9b26cd43f15694c5c3\";}}s:5:\"title\";s:18:\"Expired Transients\";s:5:\"items\";i:0;s:7:\"records\";i:24;s:4:\"size\";i:918904;}}}s:9:\"rss-feeds\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:9:\"rss-feeds\";a:5:{s:10:\"transients\";a:2:{s:4:\"site\";a:0:{}s:5:\"local\";a:5:{i:0;s:40:\"dash_v2_88ae138922fe95674369b1cb3d215a2b\";i:1;s:37:\"feed_9bbd59226dc36b9b26cd43f15694c5c3\";i:2;s:37:\"feed_d117b5738fbd35bd8c0391cda1f2b5d9\";i:3;s:41:\"feed_mod_9bbd59226dc36b9b26cd43f15694c5c3\";i:4;s:41:\"feed_mod_d117b5738fbd35bd8c0391cda1f2b5d9\";}}s:5:\"title\";s:9:\"All Feeds\";s:5:\"items\";i:0;s:7:\"records\";i:10;s:4:\"size\";i:867979;}}}s:14:\"all-transients\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:14:\"all-transients\";a:5:{s:10:\"transients\";a:2:{s:4:\"site\";a:12:{i:0;s:22:\"available_translations\";i:1;s:40:\"browser_199212111a57ddf8d1f2e5cbdad1a5e2\";i:2;s:40:\"browser_759b1e79d21e38d89cd2791faa91f8c6\";i:3;s:40:\"browser_d779790d920bc0f1ab1a364c74903611\";i:4;s:49:\"community-events-1aecf33ab8525ff212ebdffbb438372e\";i:5;s:42:\"php_check_3fde9d06ba9e4fd20d08658e6f30b792\";i:6;s:42:\"php_check_653b16e6c5979ac325fae9f9db6a18fe\";i:7;s:40:\"poptags_40cd750bba9870f18aada2478b24840a\";i:8;s:11:\"theme_roots\";i:18;s:11:\"update_core\";i:19;s:14:\"update_plugins\";i:20;s:13:\"update_themes\";}s:5:\"local\";a:10:{i:0;s:18:\"acf_plugin_updates\";i:1;s:40:\"dash_v2_88ae138922fe95674369b1cb3d215a2b\";i:2;s:37:\"feed_9bbd59226dc36b9b26cd43f15694c5c3\";i:3;s:37:\"feed_d117b5738fbd35bd8c0391cda1f2b5d9\";i:4;s:41:\"feed_mod_9bbd59226dc36b9b26cd43f15694c5c3\";i:5;s:41:\"feed_mod_d117b5738fbd35bd8c0391cda1f2b5d9\";i:6;s:31:\"health-check-site-status-result\";i:7;s:31:\"perflab_set_object_cache_dropin\";i:13;s:12:\"users_online\";i:14;s:19:\"wfRegistrationToken\";}}s:5:\"title\";s:14:\"All Transients\";s:5:\"items\";i:0;s:7:\"records\";i:36;s:4:\"size\";i:977618;}}}s:9:\"cron-jobs\";a:2:{s:6:\"expire\";i:1692313608;s:4:\"data\";a:1:{s:9:\"cron-jobs\";a:4:{s:5:\"title\";s:13:\"All CRON Jobs\";s:5:\"items\";i:0;s:7:\"records\";i:1;s:4:\"size\";i:3469;}}}s:15:\"optimize-tables\";a:2:{s:6:\"expire\";i:1692313610;s:4:\"data\";a:1:{s:15:\"optimize-tables\";a:4:{s:5:\"title\";s:17:\"Fragmented Tables\";s:5:\"items\";i:0;s:7:\"records\";i:0;s:4:\"size\";i:0;}}}s:13:\"repair-tables\";a:2:{s:6:\"expire\";i:1692313610;s:4:\"data\";a:0:{}}}}','yes'),
(2533,'d4p_blog_sweeppress_core','a:2:{s:9:\"activated\";i:0;s:9:\"installed\";s:19:\"2023-08-17 21:02:33\";}','yes'),
(2538,'d4p_blog_sweeppress_info','a:21:{s:4:\"code\";s:10:\"sweeppress\";s:7:\"version\";s:3:\"2.3\";s:5:\"build\";i:90;s:7:\"updated\";s:10:\"2023.08.11\";s:6:\"status\";s:6:\"stable\";s:7:\"edition\";s:4:\"lite\";s:8:\"released\";s:10:\"2022.03.03\";s:10:\"plugin_url\";s:0:\"\";s:10:\"github_url\";s:0:\"\";s:10:\"wp_org_url\";s:0:\"\";s:17:\"is_bbpress_plugin\";b:0;s:11:\"author_name\";s:14:\"Milan Petrovic\";s:10:\"author_url\";s:26:\"https://www.dev4press.com/\";s:3:\"php\";s:3:\"7.3\";s:5:\"mysql\";s:3:\"5.0\";s:3:\"cms\";a:2:{s:9:\"wordpress\";s:3:\"5.5\";s:12:\"classicpress\";s:3:\"1.2\";}s:7:\"plugins\";a:2:{s:7:\"bbpress\";b:0;s:10:\"buddypress\";b:0;}s:7:\"install\";b:0;s:6:\"update\";b:0;s:8:\"previous\";i:0;s:12:\"translations\";a:0:{}}','yes'),
(2536,'d4p_blog_sweeppress_settings','a:3:{s:10:\"expand_cli\";b:1;s:11:\"expand_rest\";b:0;s:19:\"hide_backup_notices\";b:1;}','yes'),
(2534,'d4p_blog_sweeppress_statistics','a:2:{s:6:\"months\";a:0:{}s:5:\"total\";a:0:{}}','yes'),
(2537,'d4p_blog_sweeppress_sweepers','a:23:{s:19:\"estimated_mode_full\";b:0;s:15:\"estimated_cache\";b:1;s:26:\"keep_days_posts-auto-draft\";i:14;s:20:\"keep_days_posts-spam\";i:14;s:21:\"keep_days_posts-trash\";i:14;s:25:\"keep_days_posts-revisions\";i:14;s:31:\"keep_days_posts-draft-revisions\";i:14;s:23:\"keep_days_comments-spam\";i:14;s:24:\"keep_days_comments-trash\";i:14;s:29:\"keep_days_comments-unapproved\";i:60;s:27:\"keep_days_comments-pingback\";i:14;s:28:\"keep_days_comments-trackback\";i:14;s:21:\"keep_days_comments-ua\";i:14;s:26:\"keep_days_comments-akismet\";i:14;s:26:\"keep_days_signups-inactive\";i:90;s:29:\"keep_days_actionscheduler-log\";i:14;s:32:\"keep_days_actionscheduler-failed\";i:14;s:34:\"keep_days_actionscheduler-complete\";i:14;s:34:\"keep_days_actionscheduler-canceled\";i:14;s:27:\"db_table_optimize_threshold\";i:40;s:26:\"db_table_optimize_min_size\";i:6;s:24:\"db_table_optimize_method\";s:8:\"optimize\";s:19:\"last_used_timestamp\";a:0:{}}','yes'),
(113,'dashboard_widget_options','a:4:{s:25:\"dashboard_recent_comments\";a:1:{s:5:\"items\";i:5;}s:24:\"dashboard_incoming_links\";a:5:{s:4:\"home\";s:21:\"http://wpeb.ddev.site\";s:4:\"link\";s:97:\"http://blogsearch.google.com/blogsearch?scoring=d&partner=wordpress&q=link:http://wpeb.ddev.site/\";s:3:\"url\";s:130:\"http://blogsearch.google.com/blogsearch_feeds?scoring=d&ie=utf-8&num=10&output=rss&partner=wordpress&q=link:http://wpeb.ddev.site/\";s:5:\"items\";i:10;s:9:\"show_date\";b:0;}s:17:\"dashboard_primary\";a:7:{s:4:\"link\";s:26:\"http://wordpress.org/news/\";s:3:\"url\";s:31:\"http://wordpress.org/news/feed/\";s:5:\"title\";s:18:\"–ë–ª–æ–≥ WordPress\";s:5:\"items\";i:2;s:12:\"show_summary\";i:1;s:11:\"show_author\";i:0;s:9:\"show_date\";i:1;}s:19:\"dashboard_secondary\";a:7:{s:4:\"link\";s:28:\"http://planet.wordpress.org/\";s:3:\"url\";s:33:\"http://planet.wordpress.org/feed/\";s:5:\"title\";s:37:\"–î—Ä—É–≥–∏–µ –Ω–æ–≤–æ—Å—Ç–∏ WordPress\";s:5:\"items\";i:5;s:12:\"show_summary\";i:0;s:11:\"show_author\";i:0;s:9:\"show_date\";i:0;}}','off'),
(23,'date_format','d.m.Y','yes'),
(405,'db_upgraded','','on'),
(53,'db_version','58975','yes'),
(202,'ddsg_items_per_page','50','yes'),
(201,'ddsg_language','Russian','yes'),
(2550,'debugpress_settings','a:32:{s:10:\"access_key\";s:14:\"debugaccesskey\";s:2:\"pr\";s:4:\"kint\";s:6:\"active\";b:0;s:5:\"admin\";b:1;s:8:\"frontend\";b:0;s:4:\"ajax\";b:1;s:16:\"ajax_to_debuglog\";b:0;s:9:\"mousetrap\";b:0;s:18:\"mousetrap_sequence\";s:12:\"ctrl+shift+u\";s:12:\"button_admin\";s:7:\"toolbar\";s:15:\"button_frontend\";s:7:\"toolbar\";s:15:\"for_super_admin\";b:1;s:9:\"for_roles\";a:5:{i:0;s:13:\"administrator\";i:1;s:6:\"editor\";i:2;s:6:\"author\";i:3;s:11:\"contributor\";i:4;s:10:\"subscriber\";}s:11:\"for_visitor\";b:0;s:12:\"auto_wpdebug\";b:0;s:16:\"auto_savequeries\";b:0;s:15:\"errors_override\";b:1;s:19:\"deprecated_override\";b:1;s:21:\"doingitwrong_override\";b:1;s:14:\"panel_rewriter\";b:1;s:13:\"panel_request\";b:1;s:14:\"panel_debuglog\";b:1;s:13:\"panel_content\";b:0;s:11:\"panel_hooks\";b:1;s:11:\"panel_roles\";b:0;s:13:\"panel_enqueue\";b:1;s:12:\"panel_system\";b:1;s:10:\"panel_user\";b:0;s:15:\"panel_constants\";b:1;s:10:\"panel_http\";b:1;s:9:\"panel_php\";b:1;s:13:\"panel_bbpress\";b:0;}','yes'),
(17,'default_category','1','yes'),
(18,'default_comment_status','open','yes'),
(82,'default_comments_page','newest','yes'),
(43,'default_email_category','1','yes'),
(57,'default_link_category','0','yes'),
(19,'default_ping_status','closed','yes'),
(20,'default_pingback_flag','1','yes'),
(95,'default_post_format','0','yes'),
(52,'default_role','subscriber','yes'),
(1995,'disallowed_keys','-online\n.twinstatesnetwork.\n1031-exchange-properties\n125.47.41.166\n148.233.159.58\n165.29.58.126\n189.19.60.94\n189.4.80.48\n190.10.68.228\n194.68.238.7\n195.244.128.237\n195.250.160.37\n196.207.15.201\n196.207.40.213\n196.217.249.190\n1website\n200.51.41.29\n200.65.127.161\n200.68.73.193\n201.210.1.148\n201.234.19.13\n202.115.130.23\n206.245.173.42\n207.41.73.13\n210.212.228.7\n210.22.158.132\n213.239.210.120\n216.195.53.11\n216.213.199.53\n217.141.105.203\n217.141.106.201\n217.141.109.205\n217.141.249.203\n217.141.250.204\n217.65.31.167\n218.63.252.219\n219.209.194.156\n220.178.98.59\n221.122.43.124\n222.127.228.5\n222.221.6.144\n222.240.212.3\n222.82.226.145\n24.222.34.242\n4best-health.\n4u\n58.68.34.59\n61.133.87.226\n64.22.107.90\n64.22.110.2\n64.22.110.34\n67.227.134.4\n69.89.31.233\n70.86.141.82\n72.34.55.196\n74.53.227.178\n74.86.121.13\n80.227.1.100\n80.227.1.101\n80.231.198.77\n83.136.195.229\n85.13.219.98\n86.96.226.13\n86.96.226.14\n86.96.226.15\n87.101.244.6\n87.101.244.9\n88.147.165.40\n88.198.107.250\n88.249.63.217\n92.112.81.15\naccident insurance\nace-decoy-anchors.\nacnetreatment\nadderall\nadipex\nadvicer\nagentmanhoodragged\nalina1026@gmail.com\nallauctions4u.\nallegra\nalprazolam\nambien\namitriptyline\nanal\nanthurium\napexautoloan\nativan\natkins\nauto insurance\navailable-credit.\nbaccarat\nbaccarrat\nbalder\nballhoneys\nbannbaba.\nbbeckford@tscamail.com\nbestweblinks\nbitches\nblackjack\nbllogspot\nblow-ebony-job\nboat-loans\nbondage\nbontril\nbooker\nbutthole\nbuy online\nbuy-levitra-online\nbuy-phentermine\nbuy-porn-movie-online\nbuy-viagra\nbuy-xanax\nbuycialis\nbyob\nc**k\ncaclbca.\ncar insurance\ncar-rental-e-site\ncar-rentals-e-site\ncarisoprodol\ncash-services.\ncasino\ncasino-games\ncasinos\ncasualty insurance\ncephalexin\nchatroom\ncheapcarleasehire\ncheapdisneyvacationspackagesandtickets\ncialis\ncialisonline\ncitalopram\nclitoris\nclomid\ncock\ncollege-knowledge\ncompany-si.\ncontentattack.com\ncoolcoolhu\ncoolhu\ncopulationformmeet\ncraps\ncredit-card-debt\ncredit-cards\ncredit-dreams\ncredit-report-4u\ncreditcard\ncricketblog\ncunt\ncurrency-site\ncwas\ncyclen\ncyclobenzaprine\ncymbalta\ndating-e-site\ndawsonanddadrealty.\nday-trading\ndebt-consolidation\ndebt-consolidation-consultant\ndepressioninformation.net\ndiabservis.\ndidrex\ndiet-pill\ndiet-pills\ndiggdigg.co.cc\ndiscreetordering\ndissimilarly\ndistanceeducation\ndoxycycline\nduty-free\ndutyfree\nephedra\nequityloans\nfacial\nfinalsearch\nfioricet\nflamingosandfriends.\nflower4us\nflowers-leading-site\nforex\nfree-cumshot-gallery\nfree-online-poker\nfree-poker\nfree-ringtones\nfreenet\nfreenet-shopping\nfuck\nfukk\nfucking\ngambling\ngambling-\ngeneric-viagra\nh1.ripway\nhair-loss\nhawaiiresortblog\nheadsetplus\nhealth insurance\nhealth-insurancedeals-4u\nhentai\nholdem\nholdempoker\nholdemsoftware\nholdemtexasturbowilson\nhome-loans-inc.\nhomeequityloans\nhomefinance\nhomemade_sedatives\nhomeowners insurance\nhotel-dealse-site\nhotele-site\nhotelse-site\nhydrocodone\nhydrocone\nhypersearcher\nidealpaydayloans\nifinancialzone\nillcom.\nincest\nincrediblesearch.\ninforeal07.\ninsurance-quotesdeals-4u\ninsurancedeals-4u\ninvestment-loans\nionamin\nirs-problems\njbakerstudios.\njrcreations\njrcreations.\nk74v78@yahoo.com\nkasino\nkenwoodexcelon\nland.ru\nlaserhairremovalhints\nlawyerhints\nlesbian\nlevitra\nlevitra.\nlexapro\nlife insurance\nlifeinsurancehints\nlipitor\nlisinopril\nlopressor\nlorazepam\nlunestra\nlung-cancer\nluxury-linen\nlyndawyllie.\nm2mvc.\nmacinstruct\nmadesukadana.\nmanicsearch\nmark336699@gmail.com\nmaryknollogc.org\nmayopr.com\nmeridia\nmightyslumlords.com\nmlmleads.name\nmohegan sun\nmortgage-4-u\nmortgage-certificates\nmortgagequotes\nmortgagerefinancingtoday.\nmusicfastfinder\nmycolorcontacts\nmydivx.\nnemasoft.\nnetfirms.\nnipple\nnude\nnysm.\nonline casino\nonline casino guide\nonline poker\nonline slots\nonline-casino\nonline-casinos\nonline-debt-consolidation\nonline-gambling\nonline-pharmacy\nonlinegambling-4u\norgasm\nottawavalleyag\nownsthis\noxycodone\noxycontin\np***y\npacific-poker\npalm-texas-holdem-game\nparmacy\nparty-poker\npaxil\npayday loan\npayday-loan\npayday-loans\npenis\npercocet\npersonal-loans\npest-control\npharmacy\nphentermine\nphentermine.\npills-best.\npills-home.\npimpdog@gmail.com\npizzareviewblog\nplatinum-celebs\npoker\npoker-chip\npoker-games\npoker-hands\npoker-online\nporn\npornstar\npornstars\nprescription\nprohosting.\npropecia\nprotonix\nprozac\npussy\nrakeback\nrealtorlist\nrealtorx2\nrefinance-san-diego\nrental-car-e-site\nringtone\nringtones\nromanedirisinghe\nroulette\nsearchingrobot.\nseethishome\nservegame.com\nservehttp.com\nservepics.com\nshaffelrecords.\nshemale\nsightstickysubmit\nskank\nslot-machine\nslotmachine\nslots\nsoma\nstudent-loans\nswingers-search.com\nt35.\ntaboo\ntenuate\nterm insurance quote\ntexas hold\'em\ntexas holdem\ntexas-hold-em-rules\ntexas-hold-em.\ntexas-holdem\nthorcarlson\ntigerspice\ntop-e-site\ntop-franchise\ntop-site\ntrablinka\ntramadol\ntrancetechno.\ntransexual\ntranssexual\ntredgf\ntrim-spa\nturbo-tax\nugly.as\nultram\nunited24.\nvaleofglamorganconservatives\nvalium\nvaltrex\nvaried-poker.\nvcats\nviagra\nviagra-online\nviagrabuy\nviagraonline\nvicodin\nvincedel422@gmail.com\nvioxx\nvmasterpiece\nvneighbor\nvoyeurism\nvpawnshop\nvselling\nvsymphony\nwebsamba.\nwhore\nwiu.edu\nworld-series-of-poker\nwowad\nwpdigger.com\nxanax\nxenical\nxrated\nxxx\nycba\nytmnsfw.com\nz411.\nzenegra\nzithromax\nzolus\nzyban','no'),
(92,'embed_size_h','600','yes'),
(91,'embed_size_w','','yes'),
(1634,'factory_plugin_versions','a:1:{s:12:\"wbcr_clearfy\";s:10:\"free-1.5.3\";}','yes'),
(1457,'fakerpress-plugin-options','a:1:{s:5:\"500px\";a:1:{s:3:\"key\";s:40:\"UBHtxibZdthje2lI4Dai9urqiUrUTYMBqCbPCF4R\";}}','yes'),
(1042,'finished_splitting_shared_terms','1','yes'),
(2001,'finished_updating_comment_type','1','yes'),
(2013,'fm_key','wJ5A2ogHFRNQyIOPY6Lsx9U1r','yes'),
(1364,'fresh_site','0','off'),
(42,'gmt_offset','','yes'),
(33,'hack_file','0','yes'),
(97,'hadpj_user_roles','a:5:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:66:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;s:11:\"run_adminer\";b:1;s:23:\"wf2fa_activate_2fa_self\";b:1;s:25:\"wf2fa_activate_2fa_others\";b:1;s:21:\"wf2fa_manage_settings\";b:1;s:12:\"cfdb7_access\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}}','yes'),
(1463,'hmbkp_notices','a:1:{s:13:\"backup_errors\";a:1:{i:0;s:210:\"php: ZipArchive::close(): Renaming temporary file failed: Invalid argument, C:\\Users\\crazyyy\\wp-framework\\wordpress\\wp-content\\plugins\\backupwordpress\\classes\\backup\\class-backup-engine-file-zip-archive.php, 46\";}}','yes'),
(939,'hmbkp_plugin_version','3.6.4','yes'),
(937,'hmbkp_schedule_1434587998','a:7:{s:11:\"max_backups\";i:7;s:8:\"excludes\";a:0:{}s:4:\"type\";s:8:\"database\";s:12:\"reoccurrence\";s:5:\"daily\";s:19:\"schedule_start_time\";d:1434657600;s:14:\"duration_total\";d:4500117172;s:16:\"backup_run_count\";i:3;}','yes'),
(37,'home','http://wpeb.ddev.site','yes'),
(2631,'honeypot4cf7_config','a:12:{s:14:\"store_honeypot\";i:0;s:11:\"placeholder\";s:0:\"\";s:21:\"accessibility_message\";s:0:\"\";s:22:\"w3c_valid_autocomplete\";a:1:{i:0;s:5:\"false\";}s:15:\"move_inline_css\";a:1:{i:0;s:5:\"false\";}s:9:\"nomessage\";a:1:{i:0;s:5:\"false\";}s:17:\"timecheck_enabled\";a:1:{i:0;s:5:\"false\";}s:15:\"timecheck_value\";i:4;s:14:\"honeypot_count\";i:0;s:21:\"honeypot_install_date\";i:1694130764;s:30:\"honeypot_cf7_req_msg_dismissed\";i:0;s:20:\"honeypot4cf7_version\";s:5:\"2.1.7\";}','yes'),
(50,'html_type','text/html','yes'),
(2005,'https_detection_errors','a:1:{s:23:\"ssl_verification_failed\";a:1:{i:0;s:24:\"SSL verification failed.\";}}','off'),
(2670,'httpsrdrctn_options','a:5:{s:5:\"https\";s:1:\"1\";s:12:\"https_domain\";s:1:\"1\";s:17:\"https_pages_array\";a:0:{}s:15:\"force_resources\";s:1:\"1\";s:21:\"plugin_option_version\";s:5:\"1.9.2\";}','yes'),
(2627,'ideastocode_module_settings','a:1:{s:14:\"itc_svg_upload\";a:5:{s:4:\"name\";s:14:\"itc_svg_upload\";s:5:\"title\";s:33:\"Enable SVG, WebP &amp; ICO Upload\";s:4:\"slug\";s:14:\"itc-svg-upload\";s:7:\"version\";s:5:\"1.0.1\";s:8:\"settings\";s:23:\"itc_svg_upload_settings\";}}','yes'),
(75,'image_default_align','','yes'),
(73,'image_default_link_type','','yes'),
(74,'image_default_size','','yes'),
(2639,'ImfsPage','a:5:{s:12:\"majorVersion\";d:1.4;s:10:\"wp_version\";s:5:\"6.5.5\";s:13:\"wp_db_version\";i:57155;s:6:\"backup\";a:0:{}s:14:\"plugin_version\";s:6:\"1.4.18\";}','yes'),
(2632,'imfsQueryMonitor','','yes'),
(96,'initial_db_version','21707','yes'),
(2628,'itc_svg_upload_settings','a:3:{s:3:\"svg\";i:1;s:4:\"webp\";i:1;s:3:\"ico\";i:1;}','yes'),
(72,'large_size_h','0','yes'),
(71,'large_size_w','1600','yes'),
(614,'limit_login_allowed_lockouts','4','yes'),
(612,'limit_login_allowed_retries','4','yes'),
(611,'limit_login_client_type','REMOTE_ADDR','yes'),
(619,'limit_login_cookies','1','yes'),
(613,'limit_login_lockout_duration','1200','yes'),
(617,'limit_login_lockout_notify','log,email','yes'),
(615,'limit_login_long_duration','86400','yes'),
(618,'limit_login_notify_email_after','4','yes'),
(616,'limit_login_valid_duration','43200','yes'),
(404,'link_manager_enabled','0','yes'),
(25,'links_updated_date_format','d.m.Y H:i','yes'),
(14,'mailserver_login','login@example.com','yes'),
(15,'mailserver_pass','password','yes'),
(16,'mailserver_port','110','yes'),
(13,'mailserver_url','mail.example.com','yes'),
(1108,'medium_large_size_h','0','yes'),
(1107,'medium_large_size_w','768','yes'),
(67,'medium_size_h','0','yes'),
(66,'medium_size_w','600','yes'),
(35,'moderation_keys','','no'),
(30,'moderation_notify','1','yes'),
(2426,'new_admin_email','crazyyy@gmail.com','yes'),
(993,'p3_notices','a:0:{}','yes'),
(1004,'p3_scan_','{\"url\":\"\\/wp-admin\\/admin-ajax.php\",\"ip\":\"127.0.0.1\",\"pid\":10812,\"date\":\"2015-06-18T00:47:06+00:00\",\"theme_name\":\"D:\\\\Works\\\\Verstka\\\\wp-framework\\\\wordpress\\\\wp-content\\\\themes\\\\wp-framework\\\\functions.php\",\"runtime\":{\"total\":0.29789185523987,\"wordpress\":0.12375378608704,\"theme\":0.004298210144043,\"plugins\":0.089087724685669,\"profile\":0.073323011398315,\"breakdown\":{\"p3-profiler\":0.010924339294434,\"all-in-one-wp-security-and-firewall\":0.030353307723999,\"cyr3lat\":0.0012428760528564,\"htm-on-pages\":0.0047204494476318,\"optimize-db\":0.0011062622070312,\"wordpress-seo\":0.037757396697998,\"wp-sxd\":0.0029830932617188}},\"memory\":21757952,\"stacksize\":2366,\"queries\":23}\r\n','yes'),
(80,'page_comments','','yes'),
(93,'page_for_posts','0','yes'),
(94,'page_on_front','0','yes'),
(1717,'pbsfi_options','','yes'),
(31,'permalink_structure','/%postname%/','yes'),
(39,'ping_sites','https://topicexchange.com/RPC2\nhttps://www.blogstreet.com/xrbin/xmlrpc.cgi\nhttps://bulkfeeds.net/rpc\nhttps://www.feedsubmitter.com\nhttps://blog.with2.net/ping.php\nhttps://www.pingerati.net\nhttps://blog.with2.net/ping.php\nhttps://topicexchange.com/RPC2\nhttps://bulkfeeds.net/rpc\nhttps://rpc.blogbuzzmachine.com/RPC2\nhttps://rpc.pingomatic.com/\nhttps://www.feedsubmitter.com/\nhttps://www.bitacoles.net/ping.php\nhttps://blogmatcher.com/u.php\nhttps://blogsearch.google.com/ping/RPC2\nhttps://xmlrpc.blogg.de/\nhttps://rpc.twingly.com/\nhttps://www.blogdigger.com/RPC2\nhttps://www.blogshares.com/rpc.php\nhttps://pingoat.com/goat/RPC2\nhttps://ping.blo.gs/\nhttps://www.weblogues.com/RPC/\nhttps://www.popdex.com/addsite.php\nhttps://www.blogoole.com/ping/\nhttps://www.blogoon.net/ping/\nhttps://coreblog.org/ping/','yes'),
(22,'posts_per_page','10','yes'),
(11,'posts_per_rss','10','yes'),
(146,'recently_activated','a:5:{s:33:\"wp-performance/wp-performance.php\";i:1719988496;s:45:\"search-and-replace/inpsyde-search-replace.php\";i:1719987307;s:27:\"samudra-log/samudra-log.php\";i:1719987296;s:27:\"wp-optimize/wp-optimize.php\";i:1719987222;s:25:\"debugpress/debugpress.php\";i:1719986865;}','off'),
(44,'recently_edited','','no'),
(1752,'recovery_keys','a:0:{}','off'),
(9,'require_name_email','1','yes'),
(1909,'rewrite_rules','a:94:{s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:17:\"^wp-sitemap\\.xml$\";s:23:\"index.php?sitemap=index\";s:17:\"^wp-sitemap\\.xsl$\";s:36:\"index.php?sitemap-stylesheet=sitemap\";s:23:\"^wp-sitemap-index\\.xsl$\";s:34:\"index.php?sitemap-stylesheet=index\";s:48:\"^wp-sitemap-([a-z]+?)-([a-z\\d_-]+?)-(\\d+?)\\.xml$\";s:75:\"index.php?sitemap=$matches[1]&sitemap-subtype=$matches[2]&paged=$matches[3]\";s:34:\"^wp-sitemap-([a-z]+?)-(\\d+?)\\.xml$\";s:47:\"index.php?sitemap=$matches[1]&paged=$matches[2]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:12:\"robots\\.txt$\";s:18:\"index.php?robots=1\";s:13:\"favicon\\.ico$\";s:19:\"index.php?favicon=1\";s:12:\"sitemap\\.xml\";s:24:\"index.php??sitemap=index\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:23:\"author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:45:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:32:\"([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:19:\"([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";s:27:\"[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\"[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\"[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\"[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"([^/]+)/embed/?$\";s:37:\"index.php?name=$matches[1]&embed=true\";s:20:\"([^/]+)/trackback/?$\";s:31:\"index.php?name=$matches[1]&tb=1\";s:40:\"([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:35:\"([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:28:\"([^/]+)/page/?([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&paged=$matches[2]\";s:35:\"([^/]+)/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&cpage=$matches[2]\";s:24:\"([^/]+)(?:/([0-9]+))?/?$\";s:43:\"index.php?name=$matches[1]&page=$matches[2]\";s:16:\"[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:26:\"[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:46:\"[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:41:\"[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:41:\"[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:22:\"[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";}','yes'),
(12,'rss_use_excerpt','1','yes'),
(225,'seo_friendly_images_alt','%name %title','yes'),
(231,'seo_friendly_images_notice','1','yes'),
(227,'seo_friendly_images_override','on','yes'),
(228,'seo_friendly_images_override_title','off','yes'),
(226,'seo_friendly_images_title','%title','yes'),
(60,'show_avatars','1','yes'),
(1599,'show_comments_cookies_opt_in','1','yes'),
(58,'show_on_front','posts','yes'),
(103,'sidebars_widgets','a:4:{s:19:\"wp_inactive_widgets\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:13:\"widget-area-1\";a:0:{}s:13:\"widget-area-2\";a:0:{}s:13:\"array_version\";i:3;}','yes'),
(2410,'simba_tfa_priv_key_format','1','no'),
(2636,'simple_history_enable_rss_feed','0','yes'),
(2697,'simplehistory_AvailableUpdatesLogger_plugin_updates_available','a:3:{s:34:\"advanced-custom-fields-pro/acf.php\";a:1:{s:15:\"checked_version\";s:7:\"6.2.1.1\";}s:53:\"accelerated-mobile-pages/accelerated-moblie-pages.php\";a:1:{s:15:\"checked_version\";s:6:\"1.0.89\";}s:35:\"google-site-kit/google-site-kit.php\";a:1:{s:15:\"checked_version\";s:7:\"1.109.0\";}}','yes'),
(1106,'site_icon','0','yes'),
(1,'siteurl','http://wpeb.ddev.site','yes'),
(248,'sm_options','a:56:{s:18:\"sm_b_prio_provider\";s:41:\"GoogleSitemapGeneratorPrioByCountProvider\";s:13:\"sm_b_filename\";s:11:\"sitemap.xml\";s:10:\"sm_b_debug\";b:1;s:8:\"sm_b_xml\";b:1;s:9:\"sm_b_gzip\";b:1;s:9:\"sm_b_ping\";b:1;s:12:\"sm_b_pingmsn\";b:1;s:19:\"sm_b_manual_enabled\";b:0;s:17:\"sm_b_auto_enabled\";b:1;s:15:\"sm_b_auto_delay\";b:1;s:15:\"sm_b_manual_key\";s:32:\"b96745ccc831ceb3a5d2bb594672a608\";s:11:\"sm_b_memory\";s:0:\"\";s:9:\"sm_b_time\";i:-1;s:14:\"sm_b_max_posts\";i:-1;s:13:\"sm_b_safemode\";b:0;s:18:\"sm_b_style_default\";b:1;s:10:\"sm_b_style\";s:0:\"\";s:11:\"sm_b_robots\";b:1;s:12:\"sm_b_exclude\";a:0:{}s:17:\"sm_b_exclude_cats\";a:0:{}s:18:\"sm_b_location_mode\";s:4:\"auto\";s:20:\"sm_b_filename_manual\";s:0:\"\";s:19:\"sm_b_fileurl_manual\";s:0:\"\";s:10:\"sm_in_home\";b:1;s:11:\"sm_in_posts\";b:1;s:15:\"sm_in_posts_sub\";b:0;s:11:\"sm_in_pages\";b:1;s:10:\"sm_in_cats\";b:0;s:10:\"sm_in_arch\";b:0;s:10:\"sm_in_auth\";b:0;s:10:\"sm_in_tags\";b:0;s:9:\"sm_in_tax\";a:0:{}s:17:\"sm_in_customtypes\";a:0:{}s:13:\"sm_in_lastmod\";b:1;s:10:\"sm_cf_home\";s:5:\"daily\";s:11:\"sm_cf_posts\";s:7:\"monthly\";s:11:\"sm_cf_pages\";s:6:\"weekly\";s:10:\"sm_cf_cats\";s:6:\"weekly\";s:10:\"sm_cf_auth\";s:6:\"weekly\";s:15:\"sm_cf_arch_curr\";s:5:\"daily\";s:14:\"sm_cf_arch_old\";s:6:\"yearly\";s:10:\"sm_cf_tags\";s:6:\"weekly\";s:10:\"sm_pr_home\";d:1;s:11:\"sm_pr_posts\";d:0.6;s:15:\"sm_pr_posts_min\";d:0.2;s:11:\"sm_pr_pages\";d:0.6;s:10:\"sm_pr_cats\";d:0.3;s:10:\"sm_pr_arch\";d:0.3;s:10:\"sm_pr_auth\";d:0.3;s:10:\"sm_pr_tags\";d:0.3;s:12:\"sm_i_donated\";b:1;s:17:\"sm_i_hide_donated\";b:1;s:17:\"sm_i_install_date\";i:1352379707;s:14:\"sm_i_hide_note\";b:0;s:15:\"sm_i_hide_works\";b:0;s:16:\"sm_i_hide_donors\";b:0;}','yes'),
(249,'sm_status','O:28:\"GoogleSitemapGeneratorStatus\":24:{s:10:\"_startTime\";d:1395701243.7861459255218505859375;s:8:\"_endTime\";d:1395701244.278173923492431640625;s:11:\"_hasChanged\";b:1;s:12:\"_memoryUsage\";i:42729472;s:9:\"_lastPost\";i:0;s:9:\"_lastTime\";i:0;s:8:\"_usedXml\";b:1;s:11:\"_xmlSuccess\";b:1;s:8:\"_xmlPath\";s:50:\"E:/myWorkUp/OpenServer/domains/wpeb.ddev.site/sitemap.xml\";s:7:\"_xmlUrl\";s:26:\"http://wpeb.ddev.site/sitemap.xml\";s:8:\"_usedZip\";b:1;s:11:\"_zipSuccess\";b:1;s:8:\"_zipPath\";s:53:\"E:/myWorkUp/OpenServer/domains/wpeb.ddev.site/sitemap.xml.gz\";s:7:\"_zipUrl\";s:29:\"http://wpeb.ddev.site/sitemap.xml.gz\";s:11:\"_usedGoogle\";b:1;s:10:\"_googleUrl\";s:92:\"http://www.google.com/webmasters/sitemaps/ping?sitemap=http%3A%2F%2Fwpeb.ddev.site%2Fsitemap.xml.gz\";s:15:\"_gooogleSuccess\";b:1;s:16:\"_googleStartTime\";d:1395701243.806147098541259765625;s:14:\"_googleEndTime\";d:1395701244.0151588916778564453125;s:8:\"_usedMsn\";b:1;s:7:\"_msnUrl\";s:85:\"http://www.bing.com/webmaster/ping.aspx?siteMap=http%3A%2F%2Fwpeb.ddev.site%2Fsitemap.xml.gz\";s:11:\"_msnSuccess\";b:1;s:13:\"_msnStartTime\";d:1395701244.0191590785980224609375;s:11:\"_msnEndTime\";d:1395701244.2751729488372802734375;}','no'),
(173,'spamfree_count','0','yes'),
(6,'start_of_week','1','yes'),
(84,'sticky_posts','a:0:{}','yes'),
(46,'stylesheet','wp-wpeb','yes'),
(59,'tag_base','/','yes'),
(45,'template','wp-wpeb','yes'),
(411,'theme_mods_twentyeleven','a:1:{s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1356130367;s:4:\"data\";a:6:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:9:\"sidebar-2\";a:0:{}s:9:\"sidebar-3\";a:0:{}s:9:\"sidebar-4\";a:0:{}s:9:\"sidebar-5\";a:0:{}}}}','no'),
(790,'theme_mods_twentyfifteen','a:2:{i:0;b:0;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1428927025;s:4:\"data\";a:2:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}}}}','no'),
(652,'theme_mods_twentyfourteen','a:2:{i:0;b:0;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1395701065;s:4:\"data\";a:4:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:9:\"sidebar-2\";a:0:{}s:9:\"sidebar-3\";N;}}}','no'),
(511,'theme_mods_twentythirteen','a:2:{i:0;b:0;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1383778597;s:4:\"data\";a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:9:\"sidebar-2\";a:0:{}}}}','no'),
(413,'theme_mods_twentytwelve','a:2:{i:0;b:0;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1383775628;s:4:\"data\";a:4:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:9:\"sidebar-2\";a:0:{}s:9:\"sidebar-3\";a:0:{}}}}','no'),
(2955,'theme_mods_twentytwentyfour','a:4:{i:0;b:0;s:19:\"wp_classic_sidebars\";a:0:{}s:18:\"nav_menu_locations\";a:0:{}s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1719988365;s:4:\"data\";a:1:{s:19:\"wp_inactive_widgets\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}}}}','no'),
(2007,'theme_mods_twentytwentyone','a:4:{i:0;b:0;s:18:\"nav_menu_locations\";a:0:{}s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1694130992;s:4:\"data\";a:2:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}}}}','no'),
(529,'theme_mods_wp-blanck','a:2:{i:0;b:0;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1395701006;s:4:\"data\";a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:13:\"widget-area-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:13:\"widget-area-2\";a:0:{}}}}','no'),
(657,'theme_mods_wp-easy-master','a:2:{i:0;b:0;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1422713825;s:4:\"data\";a:2:{s:19:\"wp_inactive_widgets\";a:0:{}s:11:\"widgetArea1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}}}}','no'),
(835,'theme_mods_wp-framework','a:4:{i:0;b:0;s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1719988361;s:4:\"data\";a:4:{s:19:\"wp_inactive_widgets\";a:0:{}s:13:\"widget-area-1\";a:0:{}s:13:\"widget-area-2\";a:0:{}s:11:\"widgetarea1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}}}s:18:\"nav_menu_locations\";a:0:{}}','no'),
(2961,'theme_mods_wp-wpeb','a:3:{i:0;b:0;s:18:\"nav_menu_locations\";a:0:{}s:18:\"custom_css_post_id\";i:-1;}','yes'),
(414,'theme_switched','','yes'),
(78,'thread_comments','1','yes'),
(79,'thread_comments_depth','5','yes'),
(65,'thumbnail_crop','1','yes'),
(64,'thumbnail_size_h','300','yes'),
(63,'thumbnail_size_w','300','yes'),
(24,'time_format','H:i','yes'),
(89,'timezone_string','Europe/Kiev','yes'),
(88,'uninstall_plugins','a:14:{s:45:\"branded-login-screen/branded-login-screen.php\";a:2:{i:0;s:20:\"Branded_Login_Screen\";i:1;s:9:\"uninstall\";}s:23:\"antivirus/antivirus.php\";a:2:{i:0;s:9:\"AntiVirus\";i:1;s:9:\"uninstall\";}s:29:\"antispam-bee/antispam_bee.php\";a:2:{i:0;s:12:\"Antispam_Bee\";i:1;s:9:\"uninstall\";}s:41:\"better-wp-security/better-wp-security.php\";a:2:{i:0;s:10:\"ITSEC_Core\";i:1;s:12:\"on_uninstall\";}s:33:\"classic-editor/classic-editor.php\";a:2:{i:0;s:14:\"Classic_Editor\";i:1;s:9:\"uninstall\";}s:49:\"advanced-database-cleaner/advanced-db-cleaner.php\";s:14:\"aDBc_uninstall\";s:49:\"pb-seo-friendly-images/pb-seo-friendly-images.php\";a:2:{i:0;s:19:\"pbSEOFriendlyImages\";i:1;s:9:\"uninstall\";}s:51:\"all-in-one-wp-security-and-firewall/wp-security.php\";a:2:{i:0;s:15:\"AIO_WP_Security\";i:1;s:17:\"uninstall_handler\";}s:27:\"wp-optimize/wp-optimize.php\";a:2:{i:0;s:13:\"WPO_Uninstall\";i:1;s:7:\"actions\";}s:53:\"advanced-database-cleaner-pro/advanced-db-cleaner.php\";a:2:{i:0;s:28:\"ADBC_Advanced_DB_Cleaner_Pro\";i:1;s:14:\"aDBc_uninstall\";}s:39:\"https-redirection/https-redirection.php\";s:26:\"httpsrdrctn_delete_options\";s:36:\"contact-form-7-honeypot/honeypot.php\";s:22:\"honeypot4cf7_uninstall\";s:33:\"wp-performance/wp-performance.php\";s:13:\"wpp_uninstall\";s:29:\"webp-express/webp-express.php\";a:2:{i:0;s:28:\"\\WebPExpress\\PluginUninstall\";i:1;s:9:\"uninstall\";}}','no'),
(2028,'updraft_last_lock_time_wpo_cache_preloader_creating_tasks','2021-07-15 09:33:16','no'),
(2935,'updraft_lock_wpo_minify_preloader_creating_tasks','0','no'),
(2933,'updraft_lock_wpo_page_cache_preloader_creating_tasks','0','no'),
(2029,'updraft_semaphore_wpo_cache_preloader_creating_tasks','0','no'),
(2929,'updraft_task_manager_dbversion','1.1','yes'),
(2928,'updraft_task_manager_plugins','a:1:{i:0;s:27:\"wp-optimize/wp-optimize.php\";}','yes'),
(2027,'updraft_unlocked_wpo_cache_preloader_creating_tasks','1','no'),
(55,'upload_path','','yes'),
(62,'upload_url_path','','yes'),
(54,'uploads_use_yearmonth_folders','1','yes'),
(7,'use_balanceTags','','yes'),
(8,'use_smilies','1','yes'),
(51,'use_trackback','0','yes'),
(2194,'user_count','2','no'),
(4,'users_can_register','0','yes'),
(1665,'wbcr_clearfy_change_login_errors','1','yes'),
(1675,'wbcr_clearfy_disable_dashicons','0','yes'),
(1672,'wbcr_clearfy_disable_embeds','0','yes'),
(1652,'wbcr_clearfy_disable_emoji','1','yes'),
(1668,'wbcr_clearfy_disable_feed','0','yes'),
(1693,'wbcr_clearfy_disable_google_fonts','0','yes'),
(1694,'wbcr_clearfy_disable_google_maps','0','yes'),
(1676,'wbcr_clearfy_disable_gravatars','0','yes'),
(1681,'wbcr_clearfy_disable_heartbeat','default','yes'),
(1670,'wbcr_clearfy_disable_json_rest_api','0','yes'),
(1669,'wbcr_clearfy_disabled_feed_behaviour','redirect_301','yes'),
(1687,'wbcr_clearfy_ga_adjusted_bounce_rate','0','yes'),
(1690,'wbcr_clearfy_ga_anonymize_ip','0','yes'),
(1684,'wbcr_clearfy_ga_cache','0','yes'),
(1688,'wbcr_clearfy_ga_enqueue_order','0','yes'),
(1686,'wbcr_clearfy_ga_script_position','footer','yes'),
(1691,'wbcr_clearfy_ga_track_admin','0','yes'),
(1685,'wbcr_clearfy_ga_tracking_id','','yes'),
(1679,'wbcr_clearfy_gutenberg_autosave_control','0','yes'),
(1682,'wbcr_clearfy_heartbeat_frequency','default','yes'),
(1674,'wbcr_clearfy_lazy_load_font_awesome','0','yes'),
(1692,'wbcr_clearfy_lazy_load_google_fonts','1','yes'),
(1633,'wbcr_clearfy_plugin_activated','1567753579','yes'),
(1664,'wbcr_clearfy_protect_author_get','1','yes'),
(1656,'wbcr_clearfy_remove_adjacent_posts_link','1','yes'),
(1695,'wbcr_clearfy_remove_iframe_google_maps','0','yes'),
(1671,'wbcr_clearfy_remove_jquery_migrate','1','yes'),
(1662,'wbcr_clearfy_remove_js_version','1','yes'),
(1660,'wbcr_clearfy_remove_meta_generator','1','yes'),
(1657,'wbcr_clearfy_remove_recent_comments_style','1','yes'),
(1653,'wbcr_clearfy_remove_rsd_link','1','yes'),
(1655,'wbcr_clearfy_remove_shortlink_link','1','yes'),
(1661,'wbcr_clearfy_remove_style_version','1','yes'),
(1680,'wbcr_clearfy_remove_version_exclude','','yes'),
(1654,'wbcr_clearfy_remove_wlw_link','1','yes'),
(1673,'wbcr_clearfy_remove_xfn_link','0','yes'),
(1678,'wbcr_clearfy_revision_limit','default','yes'),
(1677,'wbcr_clearfy_revisions_disable','0','yes'),
(2444,'wf_plugin_act_error','','yes'),
(531,'wfb_contact_methods','a:2:{i:0;s:3:\"aim\";i:1;s:3:\"yim\";}','yes'),
(532,'wfb_update_notification','1','yes'),
(2439,'wfls_last_role_change','1688175523','no'),
(1781,'widget_akismet_widget','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
(101,'widget_archives','a:2:{i:2;a:3:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}','yes'),
(2065,'widget_block','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
(1009,'widget_calendar','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),
(85,'widget_categories','a:2:{i:2;a:4:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:12:\"hierarchical\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}','yes'),
(1420,'widget_custom_html','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
(1346,'widget_media_audio','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
(1532,'widget_media_gallery','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
(1347,'widget_media_image','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
(1348,'widget_media_video','a:1:{s:12:\"_multiwidget\";i:1;}','yes'),
(102,'widget_meta','a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}','yes'),
(1011,'widget_nav_menu','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),
(1012,'widget_pages','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),
(100,'widget_recent-comments','a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}','yes'),
(99,'widget_recent-posts','a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}','yes'),
(87,'widget_rss','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),
(98,'widget_search','a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}','yes'),
(1010,'widget_tag_cloud','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),
(86,'widget_text','a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}','yes'),
(2441,'wordfence_case','','yes'),
(2442,'wordfence_installed','1','yes'),
(2440,'wordfence_version','7.10.0','yes'),
(2443,'wordfenceActivated','0','yes'),
(2891,'wp_attachment_pages_enabled','1','yes'),
(2068,'wp_force_deactivated_plugins','a:0:{}','off'),
(1598,'wp_page_for_privacy_policy','0','yes'),
(172,'wp_spamfree_version','2.1.1.2','yes'),
(1815,'wp-optimize-auto','a:7:{s:6:\"drafts\";s:4:\"true\";s:8:\"optimize\";s:5:\"false\";s:9:\"revisions\";s:4:\"true\";s:5:\"spams\";s:4:\"true\";s:9:\"transient\";s:5:\"false\";s:5:\"trash\";s:4:\"true\";s:10:\"unapproved\";s:5:\"false\";}','yes'),
(1822,'wp-optimize-back_up_original','1','yes'),
(1820,'wp-optimize-compression_server','resmushit','yes'),
(1819,'wp-optimize-corrupted-tables-count','0','yes'),
(1824,'wp-optimize-dismiss_notice','1575017480','yes'),
(1813,'wp-optimize-enable-admin-menu','false','yes'),
(1466,'wp-optimize-enable-auto-backup','false','yes'),
(1821,'wp-optimize-image_quality','very_good','yes'),
(2944,'wp-optimize-install-or-update-notice-version','1.1','yes'),
(2023,'wp-optimize-installed-for','1626341590','yes'),
(2934,'wp-optimize-is_gzip_compression_enabled','gzip','yes'),
(1809,'wp-optimize-last-optimized','Never','yes'),
(1811,'wp-optimize-retention-enabled','false','yes'),
(1812,'wp-optimize-retention-period','2','yes'),
(1808,'wp-optimize-schedule','false','yes'),
(1810,'wp-optimize-schedule-type','wpo_weekly','yes'),
(1816,'wp-optimize-settings','a:13:{s:10:\"user-spams\";s:4:\"true\";s:15:\"user-unapproved\";s:4:\"true\";s:15:\"user-orphandata\";s:4:\"true\";s:11:\"user-drafts\";s:4:\"true\";s:14:\"user-transient\";s:4:\"true\";s:13:\"user-postmeta\";s:4:\"true\";s:15:\"user-trackbacks\";s:4:\"true\";s:14:\"user-revisions\";s:4:\"true\";s:13:\"user-optimize\";s:4:\"true\";s:14:\"user-pingbacks\";s:4:\"true\";s:10:\"user-trash\";s:4:\"true\";s:16:\"user-commentmeta\";s:4:\"true\";s:13:\"last_saved_in\";s:6:\"3.1.11\";}','yes'),
(1814,'wp-optimize-total-cleaned','644320','yes'),
(1901,'wpcf7','a:2:{s:7:\"version\";s:5:\"6.0.1\";s:13:\"bulk_validate\";a:4:{s:9:\"timestamp\";i:1719987513;s:7:\"version\";s:5:\"5.9.6\";s:11:\"count_valid\";i:1;s:13:\"count_invalid\";i:0;}}','yes'),
(776,'WPLANG','','yes'),
(1825,'wpo_cache_config','a:24:{s:19:\"enable_page_caching\";b:0;s:23:\"page_cache_length_value\";i:24;s:22:\"page_cache_length_unit\";s:5:\"hours\";s:17:\"page_cache_length\";i:86400;s:32:\"cache_exception_conditional_tags\";a:0:{}s:20:\"cache_exception_urls\";a:0:{}s:23:\"cache_exception_cookies\";a:0:{}s:30:\"cache_exception_browser_agents\";a:0:{}s:22:\"enable_sitemap_preload\";b:0;s:23:\"enable_schedule_preload\";b:0;s:21:\"preload_schedule_type\";s:0:\"\";s:21:\"enable_mobile_caching\";b:0;s:19:\"enable_user_caching\";b:0;s:8:\"site_url\";s:23:\"https://wpeb.ddev.site/\";s:24:\"enable_cache_per_country\";b:0;s:19:\"permalink_structure\";s:12:\"/%postname%/\";s:7:\"uploads\";s:32:\"/var/www/html/wp-content/uploads\";s:10:\"gmt_offset\";d:3;s:15:\"timezone_string\";s:11:\"Europe/Kiev\";s:11:\"date_format\";s:5:\"d.m.Y\";s:11:\"time_format\";s:3:\"H:i\";s:15:\"use_webp_images\";b:0;s:17:\"wpo_cache_cookies\";a:0:{}s:25:\"wpo_cache_query_variables\";a:0:{}}','yes'),
(2024,'wpo_minify_config','a:52:{s:5:\"debug\";b:0;s:19:\"enabled_css_preload\";b:0;s:18:\"enabled_js_preload\";b:0;s:11:\"hpreconnect\";s:0:\"\";s:8:\"hpreload\";s:0:\"\";s:7:\"loadcss\";b:0;s:10:\"remove_css\";b:0;s:17:\"critical_path_css\";s:0:\"\";s:31:\"critical_path_css_is_front_page\";s:0:\"\";s:30:\"preserve_settings_on_uninstall\";b:1;s:22:\"disable_when_logged_in\";b:0;s:16:\"default_protocol\";s:7:\"dynamic\";s:17:\"html_minification\";b:1;s:16:\"clean_header_one\";b:0;s:13:\"emoji_removal\";b:1;s:18:\"merge_google_fonts\";b:1;s:19:\"enable_display_swap\";b:1;s:18:\"remove_googlefonts\";b:0;s:13:\"gfonts_method\";s:6:\"inline\";s:15:\"fawesome_method\";s:7:\"inherit\";s:10:\"enable_css\";b:1;s:23:\"enable_css_minification\";b:1;s:21:\"enable_merging_of_css\";b:1;s:23:\"remove_print_mediatypes\";b:0;s:10:\"inline_css\";b:0;s:9:\"enable_js\";b:1;s:22:\"enable_js_minification\";b:1;s:20:\"enable_merging_of_js\";b:1;s:15:\"enable_defer_js\";s:10:\"individual\";s:13:\"defer_js_type\";s:5:\"defer\";s:12:\"defer_jquery\";b:1;s:18:\"enable_js_trycatch\";b:0;s:19:\"exclude_defer_login\";b:1;s:7:\"cdn_url\";s:0:\"\";s:9:\"cdn_force\";b:0;s:9:\"async_css\";s:0:\"\";s:8:\"async_js\";s:0:\"\";s:24:\"disable_css_inline_merge\";b:1;s:6:\"ualist\";a:5:{i:0;s:9:\"Googlebot\";i:1;s:17:\"Chrome-Lighthouse\";i:2;s:8:\"GTmetrix\";i:3;s:14:\"HeadlessChrome\";i:4;s:7:\"Pingdom\";}s:32:\"exclude_js_from_page_speed_tools\";b:0;s:33:\"exclude_css_from_page_speed_tools\";b:0;s:9:\"blacklist\";a:0:{}s:11:\"ignore_list\";a:0:{}s:10:\"exclude_js\";s:0:\"\";s:11:\"exclude_css\";s:0:\"\";s:23:\"edit_default_exclutions\";b:0;s:18:\"merge_allowed_urls\";s:0:\"\";s:7:\"enabled\";b:0;s:17:\"last-cache-update\";i:1719987173;s:14:\"plugin_version\";s:5:\"0.0.0\";s:14:\"cache_lifespan\";i:30;s:25:\"merge_inline_extra_css_js\";b:1;}','yes'),
(1904,'wpo_update_version','3.4.1','yes'),
(2730,'wpp_browser_cache','','yes'),
(2721,'wpp_cache','','yes'),
(2723,'wpp_cache_length','3600','yes'),
(2722,'wpp_cache_time','10','yes'),
(2729,'wpp_cache_url_exclude','','yes'),
(2786,'wpp_cdn','','yes'),
(2788,'wpp_cdn_exclude','','yes'),
(2787,'wpp_cdn_hostname','','yes'),
(2797,'wpp_cf_enabled','','yes'),
(2728,'wpp_clear_assets','','yes'),
(2718,'wpp_critical_css_list','a:5:{i:0;s:44:\"wp-includes/css/dist/block-library/style.css\";i:1;s:57:\"wp-content/plugins/contact-form-7/includes/css/styles.css\";i:2;s:48:\"wp-includes/css/dist/block-library/style.min.css\";i:3;s:43:\"wp-includes/blocks/navigation/style.min.css\";i:4;s:38:\"wp-includes/blocks/image/style.min.css\";}','yes'),
(2745,'wpp_css_combine','','yes'),
(2754,'wpp_css_combine_fonts','','yes'),
(2751,'wpp_css_defer','','yes'),
(2747,'wpp_css_disable','','yes'),
(2750,'wpp_css_disable_except','','yes'),
(2759,'wpp_css_disable_loggedin','','yes'),
(2748,'wpp_css_disable_position','','yes'),
(2749,'wpp_css_disable_selected','','yes'),
(2757,'wpp_css_file_exclude','','yes'),
(2755,'wpp_css_font_display','','yes'),
(2746,'wpp_css_inline','','yes'),
(2743,'wpp_css_minify','','yes'),
(2744,'wpp_css_minify_inline','','yes'),
(2753,'wpp_css_preconnect','','yes'),
(2752,'wpp_css_prefetch','','yes'),
(2756,'wpp_css_url_exclude','','yes'),
(2796,'wpp_current_settings','1694813686','yes'),
(2794,'wpp_db_cleanup_autodrafts','','yes'),
(2793,'wpp_db_cleanup_cron','','yes'),
(2795,'wpp_db_cleanup_frequency','none','yes'),
(2790,'wpp_db_cleanup_revisions','','yes'),
(2791,'wpp_db_cleanup_spam','','yes'),
(2789,'wpp_db_cleanup_transients','','yes'),
(2792,'wpp_db_cleanup_trash','','yes'),
(2726,'wpp_delete_clear','','yes'),
(2784,'wpp_disable_embeds','','yes'),
(2783,'wpp_disable_emoji','','yes'),
(2777,'wpp_disable_lazy_mobile','','yes'),
(2785,'wpp_enable_log','1','yes'),
(2968,'wpp_external_js_list','a:1:{i:0;s:65:\"//cdn.jsdelivr.net/npm/modernizr@3.12.0/lib/cli.min.js?ver=3.12.0\";}','yes'),
(2731,'wpp_gzip_compression','','yes'),
(2737,'wpp_html_minify_aggressive','','yes'),
(2736,'wpp_html_minify_normal','','yes'),
(2735,'wpp_html_optimization','','yes'),
(2738,'wpp_html_remove_comments','','yes'),
(2739,'wpp_html_remove_link_type','','yes'),
(2741,'wpp_html_remove_qoutes','','yes'),
(2740,'wpp_html_remove_script_type','','yes'),
(2742,'wpp_html_url_exclude','','yes'),
(2780,'wpp_image_url_exclude','','yes'),
(2778,'wpp_images_containers_ids','','yes'),
(2779,'wpp_images_exclude','','yes'),
(2775,'wpp_images_force','','yes'),
(2776,'wpp_images_lazy','','yes'),
(2774,'wpp_images_resp','','yes'),
(2762,'wpp_js_combine','','yes'),
(2764,'wpp_js_defer','','yes'),
(2768,'wpp_js_disable','','yes'),
(2771,'wpp_js_disable_except','','yes'),
(2773,'wpp_js_disable_loggedin','','yes'),
(2769,'wpp_js_disable_position','','yes'),
(2770,'wpp_js_disable_selected','','yes'),
(2772,'wpp_js_file_exclude','','yes'),
(2763,'wpp_js_inline','','yes'),
(2760,'wpp_js_minify','','yes'),
(2761,'wpp_js_minify_inline','','yes'),
(2766,'wpp_js_preconnect','','yes'),
(2765,'wpp_js_prefetch','','yes'),
(2767,'wpp_js_url_exclude','','yes'),
(2727,'wpp_mobile_cache','','yes'),
(2966,'wpp_plugin_css_list','a:1:{i:0;s:57:\"wp-content/plugins/contact-form-7/includes/css/styles.css\";}','yes'),
(2967,'wpp_plugin_js_list','a:2:{i:0;s:58:\"wp-content/plugins/contact-form-7/includes/swv/js/index.js\";i:1;s:54:\"wp-content/plugins/contact-form-7/includes/js/index.js\";}','yes'),
(2969,'wpp_prefetch_js_list','a:1:{i:0;s:16:\"cdn.jsdelivr.net\";}','yes'),
(2798,'wpp_prefetch_pages','','yes'),
(2725,'wpp_save_clear','','yes'),
(2734,'wpp_search_bots_exclude','','yes'),
(2732,'wpp_sitemaps_list','','yes'),
(2964,'wpp_theme_css_list','a:1:{i:0;s:48:\"wp-includes/css/dist/block-library/style.min.css\";}','yes'),
(2965,'wpp_theme_js_list','a:2:{i:0;s:35:\"wp-includes/js/jquery/jquery.min.js\";i:1;s:43:\"wp-includes/js/jquery/jquery-migrate.min.js\";}','yes'),
(2724,'wpp_update_clear','','yes'),
(2733,'wpp_user_agents_exclude','','yes'),
(2799,'wpp_varnish_auto_purge','','yes'),
(2800,'wpp_varnish_custom_host','','yes'),
(2782,'wpp_video_url_exclude','','yes'),
(2781,'wpp_videos_lazy','','yes'),
(175,'wpseo','a:20:{s:15:\"ms_defaults_set\";b:0;s:7:\"version\";s:6:\"12.9.1\";s:20:\"disableadvanced_meta\";b:0;s:19:\"onpage_indexability\";b:1;s:11:\"baiduverify\";s:0:\"\";s:12:\"googleverify\";s:0:\"\";s:8:\"msverify\";s:0:\"\";s:12:\"yandexverify\";s:0:\"\";s:9:\"site_type\";s:0:\"\";s:20:\"has_multiple_authors\";s:0:\"\";s:16:\"environment_type\";s:0:\"\";s:23:\"content_analysis_active\";b:1;s:23:\"keyword_analysis_active\";b:1;s:21:\"enable_admin_bar_menu\";b:1;s:26:\"enable_cornerstone_content\";b:1;s:18:\"enable_xml_sitemap\";b:1;s:24:\"enable_text_link_counter\";b:1;s:22:\"show_onboarding_notice\";b:0;s:18:\"first_activated_on\";i:1507015975;s:13:\"myyoast-oauth\";b:0;}','yes'),
(1751,'wpseo_onpage','a:2:{s:6:\"status\";i:-1;s:10:\"last_fetch\";i:1580740591;}','yes'),
(178,'wpseo_social','a:19:{s:13:\"facebook_site\";s:0:\"\";s:13:\"instagram_url\";s:0:\"\";s:12:\"linkedin_url\";s:0:\"\";s:11:\"myspace_url\";s:0:\"\";s:16:\"og_default_image\";s:0:\"\";s:19:\"og_default_image_id\";s:0:\"\";s:18:\"og_frontpage_title\";s:0:\"\";s:17:\"og_frontpage_desc\";s:0:\"\";s:18:\"og_frontpage_image\";s:0:\"\";s:21:\"og_frontpage_image_id\";s:0:\"\";s:9:\"opengraph\";b:1;s:13:\"pinterest_url\";s:0:\"\";s:15:\"pinterestverify\";s:0:\"\";s:7:\"twitter\";b:1;s:12:\"twitter_site\";s:0:\"\";s:17:\"twitter_card_type\";s:19:\"summary_large_image\";s:11:\"youtube_url\";s:0:\"\";s:13:\"wikipedia_url\";s:0:\"\";s:10:\"fbadminapp\";s:0:\"\";}','yes'),
(193,'wpseo_taxonomy_meta','a:1:{s:13:\"link_category\";a:1:{i:2;a:1:{s:13:\"wpseo_noindex\";s:7:\"noindex\";}}}','yes'),
(176,'wpseo_titles','a:74:{s:10:\"title_test\";i:0;s:17:\"forcerewritetitle\";b:0;s:9:\"separator\";s:7:\"sc-dash\";s:16:\"title-home-wpseo\";s:42:\"%%sitename%% %%page%% %%sep%% %%sitedesc%%\";s:18:\"title-author-wpseo\";s:30:\"%%name%%,%%sitename%% %%page%%\";s:19:\"title-archive-wpseo\";s:38:\"%%date%% %%page%% %%sep%% %%sitename%%\";s:18:\"title-search-wpseo\";s:64:\"–í—ã –∏—Å–∫–∞–ª–∏ %%searchphrase%% %%page%% %%sep%% %%sitename%%\";s:15:\"title-404-wpseo\";s:57:\"–°—Ç—Ä–∞–Ω–∏—Ü–∞ –Ω–µ –Ω–∞–π–¥–µ–Ω–∞ %%sep%% %%sitename%%\";s:19:\"metadesc-home-wpseo\";s:11:\"%%excerpt%%\";s:21:\"metadesc-author-wpseo\";s:24:\"%%excerpt%% %%sitename%%\";s:22:\"metadesc-archive-wpseo\";s:24:\"%%excerpt%% %%sitename%%\";s:9:\"rssbefore\";s:0:\"\";s:8:\"rssafter\";s:73:\"–ó–∞–ø–∏—Å—å %%POSTLINK%% –≤–ø–µ—Ä–≤—ã–µ –ø–æ—è–≤–∏–ª–∞—Å—å %%BLOGLINK%%.\";s:20:\"noindex-author-wpseo\";b:1;s:28:\"noindex-author-noposts-wpseo\";b:1;s:21:\"noindex-archive-wpseo\";b:1;s:14:\"disable-author\";b:1;s:12:\"disable-date\";b:1;s:19:\"disable-post_format\";b:0;s:18:\"disable-attachment\";b:1;s:23:\"is-media-purge-relevant\";b:0;s:20:\"breadcrumbs-404crumb\";s:0:\"\";s:29:\"breadcrumbs-display-blog-page\";b:0;s:20:\"breadcrumbs-boldlast\";b:0;s:25:\"breadcrumbs-archiveprefix\";s:0:\"\";s:18:\"breadcrumbs-enable\";b:0;s:16:\"breadcrumbs-home\";s:0:\"\";s:18:\"breadcrumbs-prefix\";s:0:\"\";s:24:\"breadcrumbs-searchprefix\";s:0:\"\";s:15:\"breadcrumbs-sep\";s:2:\"¬ª\";s:12:\"website_name\";s:0:\"\";s:11:\"person_name\";s:0:\"\";s:11:\"person_logo\";s:0:\"\";s:14:\"person_logo_id\";i:0;s:22:\"alternate_website_name\";s:0:\"\";s:12:\"company_logo\";s:0:\"\";s:15:\"company_logo_id\";i:0;s:12:\"company_name\";s:0:\"\";s:17:\"company_or_person\";s:7:\"company\";s:25:\"company_or_person_user_id\";b:0;s:17:\"stripcategorybase\";b:1;s:10:\"title-post\";s:39:\"%%title%% %%page%% %%sep%% %%sitename%%\";s:13:\"metadesc-post\";s:11:\"%%excerpt%%\";s:12:\"noindex-post\";b:0;s:13:\"showdate-post\";b:1;s:23:\"display-metabox-pt-post\";b:1;s:23:\"post_types-post-maintax\";i:0;s:10:\"title-page\";s:39:\"%%title%% %%page%% %%sep%% %%sitename%%\";s:13:\"metadesc-page\";s:11:\"%%excerpt%%\";s:12:\"noindex-page\";b:0;s:13:\"showdate-page\";b:1;s:23:\"display-metabox-pt-page\";b:1;s:23:\"post_types-page-maintax\";i:0;s:16:\"title-attachment\";s:39:\"%%title%% %%page%% %%sep%% %%sitename%%\";s:19:\"metadesc-attachment\";s:0:\"\";s:18:\"noindex-attachment\";b:0;s:19:\"showdate-attachment\";b:0;s:29:\"display-metabox-pt-attachment\";b:1;s:29:\"post_types-attachment-maintax\";i:0;s:18:\"title-tax-category\";s:44:\"%%term_title%% %%page%% %%sep%% %%sitename%%\";s:21:\"metadesc-tax-category\";s:24:\"%%excerpt%% %%sitename%%\";s:28:\"display-metabox-tax-category\";b:1;s:20:\"noindex-tax-category\";b:1;s:18:\"title-tax-post_tag\";s:44:\"%%term_title%% %%page%% %%sep%% %%sitename%%\";s:21:\"metadesc-tax-post_tag\";s:24:\"%%excerpt%% %%sitename%%\";s:28:\"display-metabox-tax-post_tag\";b:1;s:20:\"noindex-tax-post_tag\";b:1;s:21:\"title-tax-post_format\";s:44:\"%%term_title%% %%page%% %%sep%% %%sitename%%\";s:24:\"metadesc-tax-post_format\";s:24:\"%%excerpt%% %%sitename%%\";s:31:\"display-metabox-tax-post_format\";b:0;s:23:\"noindex-tax-post_format\";b:0;s:26:\"taxonomy-category-ptparent\";s:1:\"0\";s:26:\"taxonomy-post_tag-ptparent\";s:1:\"0\";s:29:\"taxonomy-post_format-ptparent\";s:1:\"0\";}','yes'),
(2175,'wpto','a:35:{s:15:\"css_js_versions\";i:0;s:17:\"wp_version_number\";i:1;s:13:\"remove_oembed\";i:1;s:21:\"remove_jquery_migrate\";i:0;s:20:\"remove_emoji_release\";i:1;s:26:\"remove_recent_comments_css\";i:1;s:15:\"remove_rsd_link\";i:1;s:15:\"remove_rss_feed\";i:0;s:18:\"remove_wlwmanifest\";i:1;s:14:\"remove_wp_json\";i:1;s:19:\"remove_wp_shortlink\";i:1;s:20:\"remove_wp_post_links\";i:0;s:15:\"remove_pingback\";i:0;s:19:\"remove_dns_prefetch\";i:0;s:24:\"remove_yoast_information\";i:0;s:21:\"wc_add_payment_method\";i:0;s:16:\"wc_lost_password\";i:0;s:15:\"wc_price_slider\";i:0;s:17:\"wc_single_product\";i:0;s:14:\"wc_add_to_cart\";i:0;s:17:\"wc_cart_fragments\";i:0;s:19:\"wc_credit_card_form\";i:0;s:11:\"wc_checkout\";i:0;s:24:\"wc_add_to_cart_variation\";i:0;s:7:\"wc_cart\";i:0;s:9:\"wc_chosen\";i:0;s:11:\"woocommerce\";i:0;s:11:\"prettyPhoto\";i:0;s:16:\"prettyPhoto_init\";i:0;s:14:\"jquery_blockui\";i:0;s:18:\"jquery_placeholder\";i:0;s:14:\"jquery_payment\";i:0;s:8:\"fancybox\";i:0;s:8:\"jqueryui\";i:0;s:11:\"html_minify\";i:0;}','yes');
/*!40000 ALTER TABLE `hadpj_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_postmeta`
--

DROP TABLE IF EXISTS `hadpj_postmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`post_id`,`meta_key`,`meta_id`),
  UNIQUE KEY `meta_id` (`meta_id`),
  KEY `meta_key` (`meta_key`,`meta_value`(32),`post_id`,`meta_id`),
  KEY `meta_value` (`meta_value`(32),`meta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_postmeta`
--

LOCK TABLES `hadpj_postmeta` WRITE;
/*!40000 ALTER TABLE `hadpj_postmeta` DISABLE KEYS */;
INSERT INTO `hadpj_postmeta` VALUES
(106,48,'_additional_settings',''),
(102,48,'_form','<label> Your name\n    [text* your-name autocomplete:name] </label>\n\n<label> Your email\n    [email* your-email autocomplete:email] </label>\n\n<label> Subject\n    [text* your-subject] </label>\n\n<label> Your message (optional)\n    [textarea your-message] </label>\n\n[submit \"Submit\"]'),
(108,48,'_hash','e63906deeb18db99890dfec251d75460266dfbf6'),
(107,48,'_locale','en_US'),
(103,48,'_mail','a:9:{s:6:\"active\";b:1;s:7:\"subject\";s:30:\"[_site_title] \"[your-subject]\"\";s:6:\"sender\";s:40:\"[_site_title] <wordpress@wpeb.ddev.site>\";s:9:\"recipient\";s:19:\"[_site_admin_email]\";s:4:\"body\";s:161:\"From: [your-name] [your-email]\nSubject: [your-subject]\n\nMessage Body:\n[your-message]\n\n-- \nThis e-mail was sent from a contact form on [_site_title] ([_site_url])\";s:18:\"additional_headers\";s:22:\"Reply-To: [your-email]\";s:11:\"attachments\";s:0:\"\";s:8:\"use_html\";b:0;s:13:\"exclude_blank\";b:0;}'),
(104,48,'_mail_2','a:9:{s:6:\"active\";b:0;s:7:\"subject\";s:30:\"[_site_title] \"[your-subject]\"\";s:6:\"sender\";s:40:\"[_site_title] <wordpress@wpeb.ddev.site>\";s:9:\"recipient\";s:12:\"[your-email]\";s:4:\"body\";s:105:\"Message Body:\n[your-message]\n\n-- \nThis e-mail was sent from a contact form on [_site_title] ([_site_url])\";s:18:\"additional_headers\";s:29:\"Reply-To: [_site_admin_email]\";s:11:\"attachments\";s:0:\"\";s:8:\"use_html\";b:0;s:13:\"exclude_blank\";b:0;}'),
(105,48,'_messages','a:22:{s:12:\"mail_sent_ok\";s:45:\"Thank you for your message. It has been sent.\";s:12:\"mail_sent_ng\";s:71:\"There was an error trying to send your message. Please try again later.\";s:16:\"validation_error\";s:61:\"One or more fields have an error. Please check and try again.\";s:4:\"spam\";s:71:\"There was an error trying to send your message. Please try again later.\";s:12:\"accept_terms\";s:69:\"You must accept the terms and conditions before sending your message.\";s:16:\"invalid_required\";s:27:\"Please fill out this field.\";s:16:\"invalid_too_long\";s:32:\"This field has a too long input.\";s:17:\"invalid_too_short\";s:33:\"This field has a too short input.\";s:13:\"upload_failed\";s:46:\"There was an unknown error uploading the file.\";s:24:\"upload_file_type_invalid\";s:49:\"You are not allowed to upload files of this type.\";s:21:\"upload_file_too_large\";s:31:\"The uploaded file is too large.\";s:23:\"upload_failed_php_error\";s:38:\"There was an error uploading the file.\";s:12:\"invalid_date\";s:41:\"Please enter a date in YYYY-MM-DD format.\";s:14:\"date_too_early\";s:32:\"This field has a too early date.\";s:13:\"date_too_late\";s:31:\"This field has a too late date.\";s:14:\"invalid_number\";s:22:\"Please enter a number.\";s:16:\"number_too_small\";s:34:\"This field has a too small number.\";s:16:\"number_too_large\";s:34:\"This field has a too large number.\";s:23:\"quiz_answer_not_correct\";s:36:\"The answer to the quiz is incorrect.\";s:13:\"invalid_email\";s:30:\"Please enter an email address.\";s:11:\"invalid_url\";s:19:\"Please enter a URL.\";s:11:\"invalid_tel\";s:32:\"Please enter a telephone number.\";}');
/*!40000 ALTER TABLE `hadpj_postmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_posts`
--

DROP TABLE IF EXISTS `hadpj_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_posts` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_posts`
--

LOCK TABLES `hadpj_posts` WRITE;
/*!40000 ALTER TABLE `hadpj_posts` DISABLE KEYS */;
INSERT INTO `hadpj_posts` VALUES
(48,2,'2023-09-08 02:56:08','2023-09-07 23:56:08','<label> Your name\r\n    [text* your-name autocomplete:name] </label>\r\n\r\n<label> Your email\r\n    [email* your-email autocomplete:email] </label>\r\n\r\n<label> Subject\r\n    [text* your-subject] </label>\r\n\r\n<label> Your message (optional)\r\n    [textarea your-message] </label>\r\n\r\n[submit \"Submit\"]\n1\n[_site_title] \"[your-subject]\"\n[_site_title] <wordpress@wpeb.ddev.site>\n[_site_admin_email]\nFrom: [your-name] [your-email]\r\nSubject: [your-subject]\r\n\r\nMessage Body:\r\n[your-message]\r\n\r\n-- \r\nThis e-mail was sent from a contact form on [_site_title] ([_site_url])\nReply-To: [your-email]\n\n\n\n\n[_site_title] \"[your-subject]\"\n[_site_title] <wordpress@wpeb.ddev.site>\n[your-email]\nMessage Body:\r\n[your-message]\r\n\r\n-- \r\nThis e-mail was sent from a contact form on [_site_title] ([_site_url])\nReply-To: [_site_admin_email]\n\n\n\nThank you for your message. It has been sent.\nThere was an error trying to send your message. Please try again later.\nOne or more fields have an error. Please check and try again.\nThere was an error trying to send your message. Please try again later.\nYou must accept the terms and conditions before sending your message.\nPlease fill out this field.\nThis field has a too long input.\nThis field has a too short input.\nThere was an unknown error uploading the file.\nYou are not allowed to upload files of this type.\nThe uploaded file is too large.\nThere was an error uploading the file.\nPlease enter a date in YYYY-MM-DD format.\nThis field has a too early date.\nThis field has a too late date.\nPlease enter a number.\nThis field has a too small number.\nThis field has a too large number.\nThe answer to the quiz is incorrect.\nPlease enter an email address.\nPlease enter a URL.\nPlease enter a telephone number.','Contact Form','','publish','closed','closed','','contact-form','','','2023-09-08 02:56:08','2023-09-07 23:56:08','',0,'https://wpeb.ddev.site/?post_type=wpcf7_contact_form&p=48',0,'wpcf7_contact_form','',0),
(49,0,'2024-07-03 09:32:45','2024-07-03 06:32:45','<!-- wp:page-list /-->','Navigation','','publish','closed','closed','','navigation','','','2024-07-03 09:32:45','2024-07-03 06:32:45','',0,'https://wpeb.ddev.site/navigation/',0,'wp_navigation','',0);
/*!40000 ALTER TABLE `hadpj_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_term_relationships`
--

DROP TABLE IF EXISTS `hadpj_term_relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `term_taxonomy_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `term_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_term_relationships`
--

LOCK TABLES `hadpj_term_relationships` WRITE;
/*!40000 ALTER TABLE `hadpj_term_relationships` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_term_relationships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_term_taxonomy`
--

DROP TABLE IF EXISTS `hadpj_term_taxonomy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_term_taxonomy` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_term_taxonomy`
--

LOCK TABLES `hadpj_term_taxonomy` WRITE;
/*!40000 ALTER TABLE `hadpj_term_taxonomy` DISABLE KEYS */;
INSERT INTO `hadpj_term_taxonomy` VALUES
(1,1,'category','',0,0),
(2,2,'link_category','',0,0);
/*!40000 ALTER TABLE `hadpj_term_taxonomy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_termmeta`
--

DROP TABLE IF EXISTS `hadpj_termmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_termmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`term_id`,`meta_key`,`meta_id`),
  UNIQUE KEY `meta_id` (`meta_id`),
  KEY `meta_key` (`meta_key`,`meta_value`(32),`term_id`,`meta_id`),
  KEY `meta_value` (`meta_value`(32),`meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_termmeta`
--

LOCK TABLES `hadpj_termmeta` WRITE;
/*!40000 ALTER TABLE `hadpj_termmeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_termmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_terms`
--

DROP TABLE IF EXISTS `hadpj_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '',
  `slug` varchar(200) NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_terms`
--

LOCK TABLES `hadpj_terms` WRITE;
/*!40000 ALTER TABLE `hadpj_terms` DISABLE KEYS */;
INSERT INTO `hadpj_terms` VALUES
(1,'X','uncategories',0),
(2,'–°—Å—ã–ª–∫–∏','links',0);
/*!40000 ALTER TABLE `hadpj_terms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_tm_taskmeta`
--

DROP TABLE IF EXISTS `hadpj_tm_taskmeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_tm_taskmeta` (
  `meta_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `task_id` bigint(20) NOT NULL DEFAULT 0,
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`meta_id`),
  KEY `meta_key` (`meta_key`(191)),
  KEY `task_id` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_tm_taskmeta`
--

LOCK TABLES `hadpj_tm_taskmeta` WRITE;
/*!40000 ALTER TABLE `hadpj_tm_taskmeta` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_tm_taskmeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_tm_tasks`
--

DROP TABLE IF EXISTS `hadpj_tm_tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_tm_tasks` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_tm_tasks`
--

LOCK TABLES `hadpj_tm_tasks` WRITE;
/*!40000 ALTER TABLE `hadpj_tm_tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_tm_tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_usermeta`
--

DROP TABLE IF EXISTS `hadpj_usermeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` longtext DEFAULT NULL,
  PRIMARY KEY (`user_id`,`meta_key`,`umeta_id`),
  UNIQUE KEY `umeta_id` (`umeta_id`),
  KEY `meta_key` (`meta_key`,`meta_value`(32),`user_id`,`umeta_id`),
  KEY `meta_value` (`meta_value`(32),`umeta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_usermeta`
--

LOCK TABLES `hadpj_usermeta` WRITE;
/*!40000 ALTER TABLE `hadpj_usermeta` DISABLE KEYS */;
INSERT INTO `hadpj_usermeta` VALUES
(34,2,'_yoast_wpseo_profile_updated','1428927027'),
(110,2,'acf_user_settings','a:3:{s:20:\"taxonomies-first-run\";b:1;s:19:\"post-type-first-run\";b:1;s:23:\"options-pages-first-run\";b:1;}'),
(28,2,'admin_color','coffee'),
(106,2,'aim',''),
(101,2,'closedpostboxes_dashboard','a:0:{}'),
(27,2,'comment_shortcuts','false'),
(98,2,'community-events-location','a:1:{s:2:\"ip\";s:10:\"172.18.0.0\";}'),
(25,2,'description',''),
(33,2,'dismissed_wp_pointers','wp330_toolbar,wp330_saving_widgets,wp340_choose_image_from_library,wp340_customize_current_theme_link,wp350_media,wp360_revisions,wp360_locks,wp496_privacy,wbcr_clearfy_settings_pointer_1_4_2,perflab-admin-pointer,perflab-module-migration-pointer'),
(22,2,'first_name',''),
(31,2,'hadpj_capabilities','a:1:{s:13:\"administrator\";b:1;}'),
(97,2,'hadpj_dashboard_quick_press_last_post_id','45'),
(32,2,'hadpj_user_level','10'),
(108,2,'jabber',''),
(96,2,'last_login_time','2023-04-19 08:55:24'),
(23,2,'last_name',''),
(105,2,'locale',''),
(111,2,'manageedit-acf-post-typecolumnshidden','a:1:{i:0;s:7:\"acf-key\";}'),
(109,2,'manageedit-acf-taxonomycolumnshidden','a:1:{i:0;s:7:\"acf-key\";}'),
(115,2,'manageedit-acf-ui-options-pagecolumnshidden','a:1:{i:0;s:7:\"acf-key\";}'),
(103,2,'meta-box-order_dashboard','a:4:{s:6:\"normal\";s:41:\"dashboard_site_health,dashboard_right_now\";s:4:\"side\";s:32:\"wordfence_activity_report_widget\";s:7:\"column3\";s:40:\"dashboard_activity,dashboard_quick_press\";s:7:\"column4\";s:17:\"dashboard_primary\";}'),
(102,2,'metaboxhidden_dashboard','a:0:{}'),
(24,2,'nickname','aparserok'),
(26,2,'rich_editing','true'),
(95,2,'session_tokens','a:1:{s:64:\"f4c78130c786ae3ff2a0aa09662c595056e8f4aee9edffd91ef7712f3b754723\";a:4:{s:10:\"expiration\";i:1735169639;s:2:\"ip\";s:10:\"172.18.0.5\";s:2:\"ua\";s:125:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 Edg/132.0.0.0\";s:5:\"login\";i:1733960039;}}'),
(30,2,'show_admin_bar_front','true'),
(99,2,'show_try_gutenberg_panel','0'),
(100,2,'show_welcome_panel','0'),
(104,2,'syntax_highlighting','true'),
(29,2,'use_ssl','0'),
(114,2,'wfls-last-login','1688175250'),
(116,2,'wpcf7_hide_welcome_panel_on','a:2:{i:0;s:3:\"5.8\";i:1;s:3:\"5.9\";}'),
(107,2,'yim',''),
(60,3,'_yoast_wpseo_profile_updated','1428927027'),
(50,3,'admin_color','midnight'),
(61,3,'aim',''),
(49,3,'comment_shortcuts','false'),
(90,3,'community-events-location','a:1:{s:2:\"ip\";s:9:\"127.0.0.0\";}'),
(47,3,'description',''),
(55,3,'dismissed_wp_pointers','wp330_toolbar,wp330_saving_widgets,wp340_choose_image_from_library,wp340_customize_current_theme_link,wp350_media,wp360_revisions,wp360_locks,wp390_widgets,wp410_dfw,wp496_privacy'),
(66,3,'facebook',''),
(44,3,'first_name','Shiva'),
(64,3,'googleplus',''),
(53,3,'hadpj_capabilities','a:1:{s:13:\"administrator\";b:1;}'),
(56,3,'hadpj_dashboard_quick_press_last_post_id','35'),
(54,3,'hadpj_user_level','10'),
(63,3,'jabber',''),
(67,3,'last_login_time','2018-09-24 10:59:59'),
(45,3,'last_name','Parameshwara'),
(113,3,'locale',''),
(83,3,'managenav-menuscolumnshidden','a:4:{i:0;s:11:\"link-target\";i:1;s:11:\"css-classes\";i:2;s:3:\"xfn\";i:3;s:11:\"description\";}'),
(86,3,'meta-box-order_dashboard','a:4:{s:6:\"normal\";s:38:\"dashboard_right_now,dashboard_activity\";s:4:\"side\";s:21:\"dashboard_quick_press\";s:7:\"column3\";s:17:\"dashboard_primary\";s:7:\"column4\";s:0:\"\";}'),
(84,3,'metaboxhidden_nav-menus','a:2:{i:0;s:8:\"add-post\";i:1;s:12:\"add-post_tag\";}'),
(46,3,'nickname','shiva'),
(48,3,'rich_editing','true'),
(68,3,'session_tokens','a:1:{s:64:\"91d95bee62c50a50d8b3a55f6e82e1d2ab39d3fe1c26dadd710959485d307df8\";a:4:{s:10:\"expiration\";i:1538985599;s:2:\"ip\";s:9:\"127.0.0.1\";s:2:\"ua\";s:115:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36\";s:5:\"login\";i:1537775999;}}'),
(52,3,'show_admin_bar_front','true'),
(93,3,'show_try_gutenberg_panel','0'),
(94,3,'show_welcome_panel','0'),
(112,3,'syntax_highlighting','true'),
(65,3,'twitter',''),
(51,3,'use_ssl','0'),
(85,3,'wpseo_dismissed_gsc_notice','1'),
(81,3,'wpseo_ignore_tour','1'),
(58,3,'wpseo_metadesc',''),
(59,3,'wpseo_metakey',''),
(82,3,'wpseo_seen_about_version','3.0.7'),
(57,3,'wpseo_title',''),
(88,3,'wpseo-dismiss-about','seen'),
(89,3,'wpseo-dismiss-gsc','seen'),
(92,3,'wpseo-remove-upsell-notice','1'),
(62,3,'yim','');
/*!40000 ALTER TABLE `hadpj_usermeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_users`
--

DROP TABLE IF EXISTS `hadpj_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_users` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_users`
--

LOCK TABLES `hadpj_users` WRITE;
/*!40000 ALTER TABLE `hadpj_users` DISABLE KEYS */;
INSERT INTO `hadpj_users` VALUES
(2,'aparserok','$P$B/elTum9/FTA.MrU6bDt580YXCJiCn0','aparserok','aparserok@gmail.com','','2013-11-06 22:37:02','',0,'aparserok'),
(3,'shiva','$P$BNdTz5JzMaI1Q5pVX/quZko.M1GHZ80','shiva','crazyyy@gmail.com','http://en.wikipedia.org/wiki/Shiva','2013-12-20 17:06:50','',0,'Shiva Parameshwara');
/*!40000 ALTER TABLE `hadpj_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfblockediplog`
--

DROP TABLE IF EXISTS `hadpj_wfblockediplog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfblockediplog` (
  `IP` binary(16) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `countryCode` varchar(2) NOT NULL,
  `blockCount` int(10) unsigned NOT NULL DEFAULT 0,
  `unixday` int(10) unsigned NOT NULL,
  `blockType` varchar(50) NOT NULL DEFAULT 'generic',
  PRIMARY KEY (`IP`,`unixday`,`blockType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfblockediplog`
--

LOCK TABLES `hadpj_wfblockediplog` WRITE;
/*!40000 ALTER TABLE `hadpj_wfblockediplog` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_wfblockediplog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfblocks7`
--

DROP TABLE IF EXISTS `hadpj_wfblocks7`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfblocks7` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfblocks7`
--

LOCK TABLES `hadpj_wfblocks7` WRITE;
/*!40000 ALTER TABLE `hadpj_wfblocks7` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_wfblocks7` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfconfig`
--

DROP TABLE IF EXISTS `hadpj_wfconfig`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfconfig` (
  `name` varchar(100) NOT NULL,
  `val` longblob DEFAULT NULL,
  `autoload` enum('no','yes') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfconfig`
--

LOCK TABLES `hadpj_wfconfig` WRITE;
/*!40000 ALTER TABLE `hadpj_wfconfig` DISABLE KEYS */;
INSERT INTO `hadpj_wfconfig` VALUES
('activatingIP','127.0.0.1','yes'),
('actUpdateInterval','2','yes'),
('addCacheComment','0','yes'),
('adminUserList','b:0;','yes'),
('advancedCommentScanning','1','yes'),
('ajaxWatcherDisabled_admin','0','yes'),
('ajaxWatcherDisabled_front','0','yes'),
('alertEmails','aparserok@gmail.com','yes'),
('alertOn_adminLogin','1','yes'),
('alertOn_block','1','yes'),
('alertOn_breachLogin','1','yes'),
('alertOn_firstAdminLoginOnly','0','yes'),
('alertOn_firstNonAdminLoginOnly','0','yes'),
('alertOn_loginLockout','1','yes'),
('alertOn_lostPasswdForm','1','yes'),
('alertOn_nonAdminLogin','0','yes'),
('alertOn_scanIssues','1','yes'),
('alertOn_severityLevel','25','yes'),
('alertOn_throttle','0','yes'),
('alertOn_update','0','yes'),
('alertOn_wafDeactivated','1','yes'),
('alertOn_wordfenceDeactivated','1','yes'),
('alert_maxHourly','0','yes'),
('allowed404s','/favicon.ico\n/apple-touch-icon*.png\n/*@2x.png\n/browserconfig.xml','yes'),
('allowed404s6116Migration','1','yes'),
('allowHTTPSCaching','0','yes'),
('allowLegacy2FA','0','yes'),
('allScansScheduled','a:0:{}','yes'),
('apiKey','bd7f40430bd420717684daa129785b4ea1a8a7982cb212ea03dba5db463f7e7e27259b8aa643aa5abe4d8c20c067b56234c54656a53a84b47aa2c00d08f42734','yes'),
('autoBlockScanners','1','yes'),
('autoUpdate','1','yes'),
('autoUpdateAttempts','0','yes'),
('bannedURLs','','yes'),
('blockCustomText','','yes'),
('blockedTime','300','yes'),
('blocks702Migration','1','yes'),
('cacheType','disabled','yes'),
('cbl_action','block','yes'),
('cbl_bypassRedirDest','','yes'),
('cbl_bypassRedirURL','','yes'),
('cbl_bypassViewURL','','yes'),
('cbl_cookieVal','643f8d3742af1','yes'),
('cbl_loggedInBlocked','','yes'),
('cbl_redirURL','','yes'),
('cbl_restOfSiteBlocked','1','yes'),
('checkSpamIP','1','yes'),
('config701Migration','1','yes'),
('config720Migration','1','yes'),
('configWritingTest','469fc90ae8850c88047c513b5941745d','no'),
('configWritingTest_ser','a:1:{i:0;s:32:\"469fc90ae8850c88047c513b5941745d\";}','no'),
('coreHashes','ã\0\0\0\0\0\0\n\0ÄÊa:2:{s:4:\"hash\";s:64:\"551cccad0061ef6b8199c3cfea922e6081e33fe2190a4bdb9742438733ff7cc1\";s:6:\"hashes\";s:140960:\"\0≠àÎW7áé±ht#ì	≤öq°ª)§∫d≈Ë˙$\0–…\0(∆Îù∞xJ{Ïh¢œÆç%çß\r^≤◊:Ä˚(„5¡ó\0(–úò˙Z˙Y˜Yò@‡Iq©Óõ»ó#·—Tª·˘@\04ﬂóºtùÇ\\v¶QÁ¸ﬁπæÙ\'_À·¬ajx “¶€\0E=j∂ÉÀ»ã|ùp8.Ê¬Ωˇ˜À÷§ÒÛSGpÂÉ\0Eq≠xøÉî√Paßà˜>bv·D™øo4VäG;a<±ﬁ\0^NùŸÂºòae|K†∑-‡∆‹∞“Õ…ú=ÁÑ\0bú&Fûˆò≥ˇ%|wõÌ*Qr;ê|/ä=(AßÛ‰<¸\0Öë•#ÊBÌ5‡øjÜÛ$#ı‡j!üµ˛–bNÄÙjˆ\0ê€ßˇÂ4( K†I|äÑØ0∫ÏµqD.^ævØ\0ù>|Ê;(ﬂØ\\W*ú7?åˆ\nÿN™¡2=√7[Uo\0µÎi‰”÷Ñù\"ﬁ˚„∆]—^Ë∞˛XD˛ì2](\0πáˆ/å°o)ˆÙ:4]±„_«¯ﬂ+ÃîÎécΩ˛◊\0‘eµ*Î@ítÑ¿±\"Èê·Éq	»êN˛í5˜ÑH•\0‰9€wíiÑÛ◊Ì5Çﬂ¬–ìß√}àˇ¥h¬Ã\0Î¸ZÃàª~Ì0±=ÔËGá#¥C˜ˇZ}≈*†Üp\0ÌT|ÃÖ_¨’SÚ8≠¥O0Œº™¬∏0™√™â6ï\0˜˘-bsËG®\n(hr\Z.ÛnÂı˘!e»◊z.YxÄ◊UœiçÕ5G†Ë‹$P¬¸uÕvèATâë¿¥pülÁJ¢õ}¢Ç∂a\Z»\0VX=:àÇ8~\"2˝ ¶D∂IËXV™f∏EW£œeìÄﬂGß]∏Ò¥q)6óÌ	≈j‹ÌîınNÿ§^}0[PúKXsì§+»âa±w©SÇ∂‡[ÛU`|WS≥PDÊ∞ÁæüNh¨»b!ï∆Ú≠#ß8iﬂ>kq6øRÑEˇ5ûî:ó\"¸Ö;B≠éi.qXı‡A4˚≠ê‰uUúà+◊±ÀÖ¥œ±ÑÁ∑T™_^gy™zGÇL\"1∞˚≥çU}6:üül|áÏ(„ú¶¡ñq{∆V¿~uÍ<¢Dh¶o*øØåcœ¨0ﬂÒŒ¡x¢cl$á	ô4⁄›mï∑‰…¯oæø`vA:ß¯ôÏà`{rfÀ¡Ô_˚S3/sçŸm⁄?dö^Õî0ﬂX0„#qñ¬-mlœ*Äœ#TÒåcô¡xEµ«¬ÉyÓà≈©ú‚Hú‡˜Ó>Ã„$…2˛‰é]‚í%∆Ï*ú6ﬁ\\˛dp˘€õ!ùΩs%ü‡]Z◊Y«oÂä›øü˛ü•Ñ©ëÙ…r;G–˜\"ä•Gu˜…ﬂ&√w]Í-HÄ\rRW˝Ω\\Ã5ı¶ıÚ\'≥å=√Pñ≈π‹ sZFà‘§oD-x?Ï<†u∂¸Ñq˝XQÄ7aiÃ\rIC“pEñK·»ÃáyΩÄkä—©}À£ú\\ç$≠p\"∑&Ãp+^Ñ∫’\Zı{©Øé€Ã¬òπ5ˇ|ôf¢„µÖSÕLöo3E˝x¿∫˝—•U„ˇ∞q®`éq4uÌ∂¯Z¢Æπ∞Ø[n˘8îO£Ïr7áÕ0H01YL$RRAhJ6¥ÁM¶w:/7ö. ⁄èPî¡Éh.B¬U-—óÚ\'Ts¡™z+pøêõ◊pHaúP0ç4ï√DÌ!Ã2Â{—F∞Õπ|·©ˆ•§p8$óh˚¬\"dˆ3ˇ¨†\\ï£pYïQÎ·£éõK4ﬁó∏éÿ∫˛Ku≥\0M‘x>]Z€¯\"—z—8≈é«VﬂM˙ÀªyUL§Ö¡K´˘CÀWaèÂ\\∞ËÀÅƒ\nÉ;Ë•0Âƒ†\"f´–êŒüÔ“\'\rÕç§˝DƒdM≈◊Ÿ˘√˜ßsÀ«øâÿ⁄¥¯$2Ùj)√,\n≤\' #6‰ß9\n¯Ω^èÓŒ	nt∫\"V8¡M@ıHÿüQ˜Ø[S$¸çáœ⁄ñ©ımKÿ2Üe≤fÈteæ4˘úö\ZGG.¿f≠±Vy`∏…ˇ)\".o[`◊œê›\r…nîÛÁjnºviU\n@,õ+!%u	re4Ÿ+JuP$,ñWNçŸPŸ2“\"≈ûò,|^‚ÂÄyﬁ≤ÒÚ/\Z(A∞1]¸/∆Ö≠BëMÛj:≠Â@—´»G+S€f∂∫´ˇπdVûiâ\n∞6W∑˙‘ë\\<ÁOÃEj2¨QÚä◊÷î\r¿|˛X6¬Ï‘Ó“/46§JÚ’…?‘’ÊXíGXÜ~Üñuôü˙ic\r‚p™´ı¥˚Q÷«ÌôúΩ˜\r?còLŸT”äï˘Óqg¶»´?córá»∏¶t≠dÆ¨ÊB\rTJ¬,Qì”$öTDh◊Ò–((Zdèz∂πvOˇØØ¬_ïü;∆Äõ≥EåpYˆ.’&}ˆ∫_∫	‘Qêø∆Åâç„oS‚nn˚ÃµvÍ¯\0)∞ˆÃ”øñ›”§Â:DILV≠\0y≈Z˛à)õæKâ\n„ÖÀ‹òDã~ôâ%Ro¯Ôcâ÷7Æ\r¶∫LªÊ>1ä›à]ö^]¨R…¢NFôMÙ‚JÃ,òÔ˜iÍI.2 öª>1∑Zÿ;◊®æÇ1‘Å$ö!°áW:	®SxÔDq5∫‡/w∫€_W:úÿ+f1z˘∏g¢¶ã\\YÚ˙‚mıx≥GO0«Œ‚jo].„ñΩÆBú=Ωf~:NæÃ§Fa6¢’°Ÿ\nY çÿ”\'∫Ëi˚¬Á+≠`≠¬fGYbmüÔUP©ôMÅôJÈ⁄°0Ä&Cv¬ËMì$Ö€Ë˙∂OΩ∑4-K∏	o6€lbˆ1EÂ;±7x˘?-ô«±å®ZﬁzEªüâ*Ünk±ªâE◊m@Ïû„ÈˆéÈ1sÆ≠Yï#1$–È\Z£=Iòàäùøb£éXBrΩ?ä∑ÏÕ•-ÙÇ!«i∫>°[ø≤e¯V{–W¢!FµP˛b<&¬ÑAä‡–¸’8”`…Â]wBÀ˘Œ∫ıù@kp&ªõπh4‘õµ2∂èô∫f\'ˆG—”œISïÊ}†}R‚•Ö˝J–õZ[`∆ˆm¶ˇIî$=Ñ≠˘ºπDìã÷õ&ƒ«æ@ê+’¢À–qO.ØåÖx&éÆ*pßéˆ@˝ùlÎ¡–“˛˜Œí/kz=¨iªÍÓ“ SÚ®∞‘¿˝\Z\Z4⁄∂1È5¡™«2í3\r#?E…Q∑ÀÿL∂’Im$œZ Â™B\ZÔ!Ñ„ú&öÕñéóCkÜ`7ãœ◊\'/πΩ]‰i™≤5†\0º“µ©ä2SCÇ·≈+2±»¸f!Og–veΩCﬁhÓˇî÷Œ%%÷Ï-”’)^\\Åâ¢\0´t`ñkê‡≤@ßÉõUÊO≈î§cp¶œ>„!8HB6•œ‡„Ï‚=ìbÒ¬â!ßÙnäz\0ßOS~KÍ¯Á|$ÿÎˆ∞T°ÏÔ¡ÖÊlJ∆¯bˇOwüê‡–·Õf\nT¿˛≤≠Eg\ZUÍ\r¯ü£èl{‡≤SYD7I’.`Ë‰µ√è}#Ÿß˛ûÙJ4 ¨6Èé¨ΩÏM&$!ù2d<û™\\	|\\ó?g¸\nKN¢çeÈ”åª&ù¬–éu—°Iqôtº∑ãn~T	_j◊ç-òõÜ…%≥¶?û7°0iñªÀ}Õe›iZ÷Oô&E+rXéeê{e™ΩmXŒ»ˆ<º:¶KSy{†Ær∑>K^s‚VS2oıH÷è·_Ó€)7°©ö„–z_oeÔ’˝≈≠yß^/?h;@r‚K%‡·LPÖ«f®‡cÀ(|’_]†€UÃÕío~MEˇËÔ◊Ü›ãŸs¨˘RpÁd’ŒF[ˇ¸\'r›5l˛ó•ËîùÂ™ÄéÓ¥sËÉÚ@Z2]¶Û∫iæ®®](J~n¯3Ï‡œùøŸÄÅhjÅÛq⁄o—2±ÜkL˝õJQßc\0œ8|V‹ÀAë¸˝äéN⁄∫∂)\r¬m‰MAºÃÊDæ∞os,ñ’Í$ªãÙgJ	·≈ñÿ7l}ÿa°Òæ‘»¡äØ√w|€gRLh!ˆ∞Å1“RÛ˛ù&\'ò˝k±D\':8Yﬁ®KçAa¨-øRHˆT“ˇ˝ˇ•’˝ä™ª(:Û=ﬂ§\'\\’\0®∂Ø|«8Õ(¥à]xíZ‰¥œvJ+Ë~ÜSâ$Ÿã6œÓvgêA—ú¿ ãQ?≠j¨`JìÒ©Nı]Ó0&ñÒbõ\0ÎV?9¥¡∫∂—\"≠.˜I3Ùë2r)rkí+`ΩNiMÁÒ2]<æ	æh\n⁄À•çó˛OÌÄ3å5Fû–»\\Ã\0˜ûì,vSÁÁ+p\n˝.áßôÈ¥\rƒJ*RT	¸!åÊA&ñ’UÛBÕtG=_:\\Í]>iü£?Œ∑@⁄π‹aK’∫⁄*ø†‘Ω+]≤Äµ“Æg∆â^62ÛG¶û\rÉS†Ö|±;)•$=X¡n!√∫ÆÇl=ÿ@ıAÕ∞”Ò:ﬁV56U∆˛x5ÙPxõõÕ&Ûø:VìVÊ˚⁄-qXπÍA9¿MÁ4ﬁ‡Ü-≤∞ê©t\n{Î—ıÜ}ˇMI	AE0N„ˆ‹ ˚µÑ≈.T0b([Œ≤Å‹û™£ıÌoYd‘Œ%‹ Â+£[ªB∫ï f∂<3)|ïûüy-ØdÇ∞¥ Ù]`,5ÜÔl9Ño»π§x´ú;ëàıæxZü†’q@…ı∂‰51a•IxàªºMOY¿UÚ\rãZÍtäKœ≠ÈuJOy≈π¢&“∏¯ƒ*Îë‹≤∆us#ëût1≤#4ÁÕˆ¥√‰Çπ\ZÄ¡\'&›8—\0√™îøıõm9;:·ƒÕºÑf¬∆fÑ)ìô§IÔú≥Õ;¡˛Poi√„ß⁄=êD·éØ‰§0SlÌhsg‹∫{î,òÃ)\Z|úÌﬁÚØ<Ñ\nìxíæ*‘◊Ûé˝◊iƒÛñ’…`ôÄhàˇ`ìP°è*Õ§π!j1m!ñ~ùJ≠é\r¶O”]éÅY<çyå}É\Zª>…∫H®ØI|‹«PÙË±ﬂËÆ‡Bb•Ωe‘^¸öŒà;VT1®Œcj®] k^ßO◊Í§9´A9ù/ÿ\ZÛå%ò@b§.å`ªïö po÷¿Ôdfπ∆?ªjr£‰YÂèe|’Hå˜h>›,ãecﬁ°ñR˙es5-ìö‡D=«ƒ˚<Û⁄:3„Õœ©ëMÁÒù‘>ªãˇrÓ6À‘§–Ù%zãu€á7˛}ªFÀòƒ[yx±Ø]k·∆›≠˜YrÉá÷º9£IV,C2ç\"ìï…V—l∑ópà]l2¢PÔ¯f>ÏıKp‘«÷öJîæôbvw∞`Ó©™µ*ªwÈ†Û}±À¯©∂* òÒò)>2Éq§ñe•Ä^’¿)åPíç¶«n˚GfRÙ@Ol,>ivƒ:∞`ƒtQ∆*∑8\'•<ìÛ\n„ã¡íº†JÚè∑;ìH`˜Qÿù6pqæˇÿaÛ%ÎÆÒ\rÜÿ	¸Ï\"ÖAênà3HÿIsÃ:Y•§a¡e0B“≤yıPp\nÔ≠æØ®ôÚ∆!ŒõÕˇªŸ&∞÷…Ö\'M∫–4„öBüS¯ﬂ…+\'•4&º$ÿ°°ÛVgg§·oŒ¸g~ŸÎm/‡°/&t+‰˘‚s◊Ïæ‰‘\"#:Z´‹Ø4„ìâ&_&€««6\"xF|w`AZ_+vL\r}∞éNﬂPÂ…Ê6É´∏äΩ¢_Î“∞Ê›æî˝l2°bû©πq√ú$UÑv°Ò	l,s®≈Ÿ\"\r˚mûË`ª·Y◊ìØUî∂X^ûMs˜óç6RüH@Ò	&âÂÜæ§B«xûˆ@d∆R#U≥ÙO˛PgõûsH¸oË)n’ŒˇWrÈÅŒtèZÏM™“˛Ë?%ÜÔπàV˙‹¿¢D±∞Fvÿ9¥1{|Èˆ;È\n$yn»öíhMãE‘—:zü‹¸‡@Øà¡¸‹*9VõªåŒºÛ[E£∂Bu}<®ÓÑ±\Z#∂d∏4*˚?òúÂ∏d™Q]Bx.|9D¯ˆ:h@÷¬Qˇœ/U\0-|_€¢1˘g-Ò+¥≠∑ﬁ}¸‘ò!^iB≥–ÚJ¸’\\W§]êfßú@@Öw£=	.]∂ÌkZ1—ôm“GıÇ˝]‘x‡0¯Íï…	14\"1úIx™ıGL¶[	ïÇ±>(G·A:å˝«	64µÆàÁ π2DM»M‚$À\rÊæêiì\0‘¨ã	8\\≈¨ÁÆj˘AíÅ î5—+Xù≠úoàT˘m∞_|	MÎ∞Ïyu$ú1ºck_ëKˇo›f€œm≥Öπ%˚	g)[.âr\n‡oîi◊{4äõQ\n\r8Hå\rfX¿Ë	v∂lª¥ıŸÆﬂ˜!ˇπˇPÄ≤m˝¯ï\n6|œîK	~–ıCË»´ôØ7§‡√:¿£s&uÀ‰ŸÏÅj‘Àt	©+ˆ{RÙÉ‰”ŸÑÂ‘Àn˝t,¥«û¶`µïŒ|UÓñ	≠	Ωú#tâÃπªÍ´p=¨I\"º¶òè)F	÷ì≈‹Ò-å\nqUâÀi∫◊Õ-õ$‡h*Ìÿmôl	ÊVhò–LCâè¬ª>U∆8.≈`∆@<KÈ„h	¸Õø∏ U%≈O®Hﬁ°ÒüÖ@ø~x\\6Œƒ~‚\n<∫:òXÜh«QAT∫¿ÔÏ∑oé·p2ı∂π8>¯\n*Ñ≤<◊˜∫”≥≥?HMç≤\'V’ÈËêLÓº\'[R€\n@&ÿÍ[DqSﬁ¡ ”Ï‡Bó◊N#FâBÖ‰\n*AnïÑ∏.]ÈBÈƒt˙vÉ!âW“ßMwí9›˚F\n+P_tQˇVoÍ˙©≤™7nˇ\nz#˘8Õ˙∫“€ﬂJ\nGk˘†~ngòñm.Î3\\ñ\nÊ∞1iÇ‘jg÷∏”\nv≠?ÃuÏ	“»»fﬂh6⁄2B˛ÉË?Ò2\03î}¶\nxâÁmØ´ÖnV=ODºì\0T≠⁄ﬁ)âœU‹„©\n}.¢íÜÂ◊˜vÊñeØ\nµ?Ê∞.zü™EÖª⁄–+…°\nãê\\_9(Ù)7Ç\nó÷/ıSÊ‡\'‰gﬂÉÜvï£√\n°9d£«Ïgè~@ñ§Æ|ÎB-ü¡∞≤ú⁄ê˝6=£ù\n§T¬[Cpπ±ß‚(,¨_V+‰L\r€®Iπ¸(.àÑ\n•s˙H◊µ—ác Î-y//˝?á\rÆ$MÃ§j3\nßaqYK¥J“îŒÄp˘\ZJ¸jêØ\\P«ò»\n‘\n∂Ø⁄∑õtnå\râEanÚéJ;}(Ô““ô©Ò¬.∞ƒ9\n∏X:ÄºQÿ}◊+ˆOó\\ﬂ_ì	{º‹ìC\'a◊y:§ﬂ\n¡˚ ≈W\"Ìà˙ÎwÜ\05—S NrèÀ˝©äºöh\n◊C„Ÿ0ƒpFd˘∞álï\0øû\"uÍô~2\"ıTØΩp\Z\nËv…[\0«ıáXZppi˝.Ã°cπ;~&åÜ›¯\nÓ∑Œ&™)h4–_`’F„Lìù<ó„:`#pf¢ÏÚ\n˘òò€RW#ﬁà¥ Â¶Q•∆ƒì4E[£\'ƒzì\rÖì)ÖÉk≥ÃéO‹dS0ÈX±zØ˙Ü_Û»ﬁ¬61káèK(£·]1»zØukpR∂!¢â≥çåóYC8ª≥’`dfhñ.^8¶‰Ù !{ ¿›F¸NëL{ŒÁz≈)™˙,≠\"ßwÕWœ˝S≤åJ«≤˛û’¡K≠S¡™¥¿u·æíπMà¬cc÷ÕﬁcdDô(ãQ±Ã\\ô\raÚï[ÑJ?T”–?—ˇ˙Gºd°Ê(sÜ©™¢‘ÓtÙ¶BUI+uõò¿CØ„≈∂ÖRêëü„SF2>¬3`•˚v…˛\'ò:js(Åù-NÍß≤ö÷†∏ÔñÁêNÁ3ÉÏïÙ:‚VS;€≈·CT\nÄª]†˛•CárJæ2é™À…m5CZá\0Ÿ/@@1ﬂ1ŒD◊’Æ6Ω∏8g\n)eƒ’⁄zÈÒl®1˘MHõë&›∆SÓ.>ıUëB|2õ¸”úOU}ø⁄(‘∞°˝¿zÃπ∆=Í‰ÜÄ 0j2°4\n:á≤Wìnè˛®î\\C2tcÁ2¡¨ƒíZVÜRÍÈ°É[ßÇl#4ˇÀª>1Œµ¢¥E˛Ä¬l|lh¨Æ£Ÿ ]˝å‰:‘Y≈àı3	öß”Ï\\gmÃªÒ1)q+#„òÚŸbÊ^0rR_“≤øàYn,ê™Jö©©ΩŒÕÅìT»NB∫(Ÿ-±ßgıÍ\\IC⁄û◊:r√nÖÃøÜ>TwÿD\nÆQº!ò@iD‰¯√rÇË¥»≠!wzè˜L{©ÔJ—y7-—mÈ◊·ìGÈ¥ûY‚ä[®ÕÙ„k »En#Xv’iáw˜Rçª:ûMê7K¨kRä¢D∑ï¨ë.ÑÛ≤© L9åÙ%±S˜®≥J*ò¿ñÖn\'Õ™t^¿Œ–V…π≈Oáú∆«Ï*Û(úòÑ∑ä7YãÓ(Vç›z|%\0\'jç∑’≠lÅ¯˜ÿµÆ$hÁTCÓÙﬂ’ûN˚8kˆ»∫…ôy∑*ô<I\n∆’ˇ‰™(¯ê»˝xÄ$ùˇC\n€∏mú-BÓ©ÀÛÏõÏYVAlÕº2æVS¸#n€ÿÚXºñã’6˜√XÓîõ‚ÒDU»Tˆ=ıñ1Oø@¯,x‘œ˝íà›≥Ÿ ÿ)Æèº\rè&‹d5∑s/,ó\"Ïd∑‘_»JΩ.ﬁŸ&tè8ˆ&mKX+ÕC∑∆Ü\n!ë;[oV˘w22≥öπ\rª≥ﬁâ#<*Q–f˚ö(•Ñı≠ô\r%∂P®ñò”˘cWÈ-:\'2ÑU·ê\'Ft‡›©z\rÖä}¿‰üπ-V±€ﬂ∞ﬁ\'eCC Ö„e-2,0\r1?ñ;IBú=S±˜\Zì2Õê÷•ë&˛◊ÜZ§BÆ¨ª\r5C›ŸñòÚ™NÀ˘ès≈ÿk˙◊˙lõ\'t35ø∂∞™\rN”ÊIÜYõ∑Ω¯ô‘Ø!î«Í6)¨ÒI£Y\rQi¸^ö\ZB|≠‰f≤ëCëøË-/r±ﬁU«YŸ¢≈B\rX∑[cdpSs3”%.XÛÂ|Aà∫ƒw¸ò#(JL\raÇ{pÎ9—ŸÂÛ(Añ)À°ÖÃÆSPVÜÃsÎ6Ï#i\rnuèäÓ:Ft\Z±§\"P9ˇµ∏qPæâúR∏ÆPA†\ráºÀkï<vW‡P‰¿úv™„g(H—Çµ¢cé+d7\rîY”¯t⁄W^§¸¨}rIx€ØÛ∫uÜç$Á/dMkÿ\r†UˇÚá:ÔwˆÁÎ‘,»Àﬂ&ÁKÖp&·\ZöÅ—\r™7GŸõ†rÌXyl÷Ô≥†<U5p8‚≠néËö\r¬õÿ◊Xd	D\nË£ÏÒé¨qºbc˜\ZuóÌ¿\rŸì£“C7,öæ<‹˙‹p≠,œL˘‚µ~rY˙s#Ä\rÁ\"æ(qqö6ÁZNÜË¥œÊñ…˚ñ’≈ü&Âh©œ\rÚ\n›ÓÃ*Jñ‘6¥§©æ˚îV^±œ%W\\¿y¨\0ÃÏª@:ÉGC—)Ã¶éˆ|u9 ËZ<Pr?s2\'Ìh?I∆œIÎ¬3z(BüGQ#âó`p‰S:eJ«&Ñ/ñ ù·a…ã®ì`Ô˜˛\nå}˚Á\Z\\x’+√G\\%R£µÕO¢§6≥‡˚Ì}Ó∞„ïìÊÇ´ƒ-™F˙kRVÀ£6ö∑ÉG_e\r≠¶\"‰}’Q^u‚’¯¿ø£YtYÆêâsNl…dU|ﬂ7ôëtÏU‡FYÄõ»nà[Ô\n◊ß\ZZ\r\n≤¬ÇÿÒd.§´jiΩ!ˆØÅ„!a‘IWRH€j∞wHBB«ÌïŒÌu§Xp\0b‰Ue“$OrŒ∞YeºJX•p∫W	!ÎèL´	o˜—¶ü?Å¡11 ÊÅ®]˚Q[Ø⁄7*˚aê3ﬁ«æ⁄hââ,°U˙é™cÅ\\ÎØkiö≤†ª6u¯‡J\n3*¨ìKv iÑÂAè&‡4í˙´=áDÈ÷q!Ëì∏÷ßf;4ìôP‰Zµ¯eµO!òvx.eË”8ójY¶ª˚Áﬂ0\Z¢¥ÄËPÖP1Ø‘S/¿èﬁ0ê?ÎU!ıÕùàæﬂΩ∏ıÚ6∞??œœˆZûëvàw=2H:ı)x.∞ÙÆá≥…o\\≈‘JÜ¬tÆLUÀ’oÌıﬂÒ≠L∂ø~ü–)6”Kœ5S$ Ç8ó«›◊‚°ß5gêg7É3lsuÿæ´yà›‡ãZ¢w⁄†õ0YE\0ÈÂœ£Ë∫´i\\˘¬ﬁ|íºîòÕ7âŸwqâ“;,ríÌ‰LùX‚¸Ü±Á»\\35qv.Rﬂºh<<ÍÔ´ët˜hDä$å¬\\1l$yà,¥Ô`póM•«j]#⁄W≠BëTmü˛Ωπ7gy\Z§†]O˝ÆY§TÄ≠Û¡bÆP«öÊòÅà˙F‚MÖ(Òb;ÀèÙK·ÛÊ´g´&\nı-ì˚nzEja ∂#Ç[’ùYdIdf@\\ÇK2oóñÿÇ/*“~€HwËˇc@€2éÌ,ÈÚ”˘¥∂P±0ÎÌ¡∫È¶Œ„Óèx`’Åûà⁄dZvs˛.‘ƒkãí∫Öﬁ\Z¶5≈\0´∫yXìß$»ıjÎ§ãà÷Ià¬ˆ8¢œÃ@t=ﬁ‰{9v‘∆>:Ã∑M\Z‘œµëî±∏\rBtù\rœ◊Ãœ3˚ÇiΩÑ0bn¬‘j:û$L ÅgŒÉr¥aòΩÂ≠±ÇˆöÑtèıC ˇY£\nô‹HÅﬂ˙$$üTÉÃû}^ÒpfO]≈«≠N3≠%\r\\ä‡-ÿAπJ≤K›™Kó‡èÉ˝7PØxeÊ\'£PH¯ˇÂH˝P=,ªO=öé»≈+À¡gÿo¥Yq®a|ﬁ\nk®3Lß#ôºêçLããÎN¡∑}Ôú\Z¯EÂ˘O\\0∏u≈ FOR\Z)ƒÅßËÑ;S†\'bN<vŸw˙LS⁄ª´sTÅ≥≈|œ>QÎŒ∞œi}⁄GÂDÖ£é7·†OF5Ï¢B◊NovŸﬂ»:Aù_-3£˚x\ZJºBì@káy50Èìœ…\n≠◊Q„(ÁØ;Æ4Ù¡è.ùÛ∏Ú`Rá≈wÙã!ÛTì∫uwm°t5…o\nÃ2A\"kîﬂöz≠ˇ|lS…Pp‹k‘G∆M—8«¸Éï°›‘πÕ‹ˆfÚEÀx;Àù±£…Oÿ[¿˜ÛÃJ`uO‚v&_‹Ÿ‹-]™õÉ∆EñÁ;|Øµx$†ÂÌ(òt`\"ÚÌ/\Z=·`>&ÓáoRä÷´Ÿ˙™	Ê⁄≤ÓÁ}∆Z	wÈ%˛ˆ(4)∂;\rÂÌ;¢)6qi9CÙ‹2È‹t÷d64êK’Æ⁄AÿU)€≥!†û°Pdlw‰+¥˛Ø>∆;Á†ﬂO¨±-L˚Åhyä˚ML)\\VHÃ„3_@AJ!Ì_∞™drNﬂd“G¢ù;ûœ∑6¡<≥·∞Ú˙∫†wjõ;‘VΩ€4dkœ‘∑‹è>∑Dâåj√,pÑ∆˛k~*ä∫Æ›d}ÁØ[º‘ÌÁH˘?‚iK∂[ºiæ˙/€(ıØã‚^ûê\\Çåˆ4¢ûc-°√»ú°˛)ˆÕó €∑ı¢“@c.ÏV_;qˆ¶™:uM¯≠€XÆ˝úbWÖÏZ`ÔƒE≤ÿ∂\r«SËÒkyÌÏ%Ñ/˛-ëéu_EC©?oÕTg˚NLC\"MÔ61…ø‰\\à)ÆjèiÆ˜Í¡Ò]„m•Übä#Øô´6àßC2†óŒaoﬂ2·®ÅF˝√‰ÀÅLÿW°îÆ%\rVJ~¯påÌ$°¡ñP(ãÒqä«˙\0ÑRSÈ;\rsÚ}º∫o%ä©XOwR	…\\òÛB–;z‹¿“ı˘Òb# qöæèl¶ºEÅÙàSåWDÚÄÊLexÏ›È™¥@m!—˛ç~∂Óß—|d˚ET9v,¥W—ãÇá‹ ÄKKÏò—#\0™ fõÁæÄG∫~µÑp»ËoPqÎ9®√\rbL\\9ˆ2◊¨ßÜnê*PPº\0A¢wÉ:oHRRàESÃGâ¬ èT-Îa*Qf±,Sª7Ùœqù‘Ãì<¶U*\";bæríÍ€^∞&ê¬7j˘F≈ë¯˙á¿“±y–ZA\" Yå!ï	=¨öxˆ`Jﬂ©i.¨?w~Î/\"wæU{´í“Lf◊è1:’§y;®&€Üﬁπ[rD´ﬁbÛNvïå„§Ñ¢’\nˇ\ZwrâƒkHuE§ÏÏÙN¡/ÔJY∑í˛gˆSi˜ñ)îN]oÚÎ’}ﬂ0<Å¡,ƒÌÎeS</ˆ‹ì8C“©T2IÜUX–jFÍæ\rPJ6¨\\Ìd$Se=gè¡Æò¯€ùJﬁ∞S∑0º£ilâwwÆ4ã:ô¯‘⁄\"DΩã•èÄ=[ï∏ZÃÔ\rããÁ#¶A@»f3®1_<»—ÓvÅ£œÀ¸(QN–‹YCwoÈÕ¿€Ù}zÔˆ/ê+xŸ±óÆ\Z8’Ó˚3§ïØÛÛ€ÄT¡—ë/∫«*®2^¬o‹∞Ï\n≠0¸˛\0”œ1Óx?F(…8éØ‹VÌÈ≈Ÿ/`8‹˘–Ü¿¬å„◊t¨2‘:≤]XK%◊	EL≠ÿÂÑüÌétÈ∞~®nFÁ^m∫‹ƒKYƒNß∆\"„Ë Ät€hRœDÈÜP¬>(’F-—$>QÅ∞éA*0l[U[î±µ⁄A7≠EŒOx∆ü±:Yß√{°Ò îù2g˚Z¡ì+j{‹hì¯ˆNû.m∑€©+À6ôúr0¡Ö±q¥„X≈{4¶aõ˚©ÀÁ4ΩïøÖ=P‘“û%^\\$∂¸rföízò;@hß¢Ë¨¨&ßf{ªä2TàÄ,JgÅ~ƒKObøèÇH÷$ç(˚¿˛\r_Æ\nt§lÏ	ÛÅç6±‡Ax	ê70)P;Á§\01º´úM{}i’ÆÉ¸E‘ﬂç\nÏ∞}HNfŒç0/¡è,u∂ﬁ¯I¯¿∆ˇÚíı)Ê-[\0™∑=÷π?§+;Q¶Ö/◊¨W/{∫òﬂölDA£ÑU…ÍRpΩrmm\rF6Ì©„˙åÿ∑à°ié(\":û@üc‡ã∑:†<R)Ç•%+:¡º¯®…G%Cy*‡m?€¥∂/ƒ\r!—ˇÃÖÊi™AHK2∞Ôƒw:€%.Û;j@€¥£)H&ÓóRë◊∞£ƒÌêR÷„ˇwciîFÙÏzõ˛\r_c;‚QAﬁ–ËJR∑Q6}Æùå%ô\0„íwòÖùQ1¶çh~«B∏ß◊∫ åàÑ∏ §!Ìg¿y£•»{Â8„ƒŸ¢˜‡7\n\nÔQËÛ¿4Hw@´≥8<Sn-G¢aMƒRA”ØèÉï¢gT1¸€^0>Ïà\réúåÒÂä∏÷¨+)ﬁ◊7X[_ßu“€±H–ÿ]\"º™¥¬°`ƒnrãXa’;„?~ëäRπûq3¸∏ŸΩ∏R ±©⁄aÂr\0“˛©B<cô=ORì¬äÃv≥B¢n|Jº±In≤;51VˆÅSKê¬6«êH∞Úi‘I•ü (.fOã”dx,æ0XløÄ‹JÎ˙.”*ƒJsü9«À&û$ÉüÒ¿»\rN÷Z/ÆaUâ∆è`≥dèLå?Ï>C|…Æ ã^vÚÖâsÇ_%ÑW›∏Ô\rJñËÛ*ƒfízK‡òHvÆ§M,øÀƒ,ı€zª¶„°´Ï?jk¡∫œ[◊0}å—FW@ÒU0Õ«W’gS¿¨2c≈ÍFFà|’2`85íSbÍG?e?q7É∏¢ú#pj⁄•|…®\0YÂÔÇÅ‹∞O|¯aV3EáFW^@lì2˛4K¬Ã<\\ÿ/#\ZæÅ∏≤–jpáÒ!CóóB®Œ⁄ãTLÂX›6≠jÓ·y¬\Z\nÍò—ë÷4∫W¡\\\Z”T‡®¥”M\\–V˚dEÍ“‡∂∂|@›]å)2‘ïiq«j¢Ï\'óVp˝,‰ﬂˇúË’K∫ﬁzMùr#ªÎ‹6ùhÊÙq	:∑@ƒﬂÆõ\rœﬂ 0l“ûÑ∑ˇ·«·ä6Œj•§ÒÃ¯Zmäc˙É¡˛-´ìk≈—Ë≠Y£∆€xJ›”5ùÌΩ¸_÷*ﬁ˝ñ]O\\ìîsóMÜ÷\n’Túî27å´Èo⁄†Cﬁg`cüôﬁÀ∞m’upa†\\ò|/JÓyß2Âfy2q˝tœ@Wük‡mxŸG ƒ∞VÕí¥◊µ®ùŒpzkË®çÓn!ä„Ú>xõ\\Ωh|¿,Åe¥0?àÜs4n˜,‰Lmuôå\Z‹^ŒÖhU}1}=Ÿz£Ëi¡Òy\'\'|KØ≤W?[†r(\r‚\Z3É∑Ãz©ÿª◊fW^PÉ1Yÿ2&‘–€ëpAµUÿﬁ¢%öıß‚òf‹§G<Ç+HH4˚ywyÈ™\'hz≤x·˙\"∂vâ\\Úp“$ª∏bo¿ô)cH˙vS‹µn_„ôà•(a§ßWcÕ¥Aú¸œ`k‘≠B ú—Æ,2£é◊˜Sàÿ^√∫ÙDÒ±Ôı\Z—£0?ÀﬁñøfÛt∂™&›!-êU8ˆÜ<í¥GzÔ<3\0R”-k–,öu¯◊º)≥ÜÊû\0≠≤\n˘9e\n!I9KòW˜´‹«º?_∆IaYOrg˜Y≥ „„Ò/íàø~UJO§.≈Ä#µÚE·ãˇ˙5¥*ä\'C≈qk?óR≥0©û}<›Ã§°‹¡˜¯.Å π∂$^$æäm€Êwﬁª`.A√_[Ú¶rE£Â]˛JÆ#ÈºŸ+ﬂò£4ˇDΩ∂ù,E„πÎ«°GfÛy5‹ü@âànNÒÑ°·´	›36ƒMë¨Ô[œyÈFRD”m÷ﬂ:Ñm‚è\\ﬂ˚ÿÏ,TÍ3y»Õ“?ÃPêº˛π‘à+oòÛäKqraï‡UìWj˜jà:M±⁄…SÏÛÔC\0®«–ôEö∫p⁄éåU=\\ŸÅ´2%±˝¸ 72BØï9∫æ‘‰9k—Òœ\r?r «˛qQeô-µ=Ç˘øıÊ˚«”OzŒ≥¬2z!ïó≠.áw‡ÅÏ\ZFPA¿¶πS”ÉPÅálñZ≈N¿È”!&ÄõQwÙ|æc;\0,2àa⁄¢U¯ËßPªÌûrY‘o:Wö3ßñ\"6¨uxhÍﬁ¯€S€ÿ¶Æ´3)]TïC¡≠Àé1B∂Ç\"$œ§_ˆY[^°e\náﬁ41•≠LßÚH›©‚Ã®Ú<˙‡“W`íÇeÌ‚Ω€ˆ	éU∞&úz¯’øR˝ˇB=PáKqÅFñuﬂ~ï„ä\Z8àå…ˆÌ‹ﬁW¶2\0Ë˛	“e¸Ω`hã‡p√,ÂÎ-nÉ˘}ì;Fõı• \Z/qË@˚∆Q!Xüw>„ãÄ∆7æ.Ñl˚8≥ËµÚleπQ,Ö¿ûê≈◊Ì	nÔ“aÇ≤TﬂåCƒ”Ä#Å∆…‹üïÙÁ6úw˙&€¢f¥U‚ø\nº˝`íVrô{¶ÙYUö¨\"V1ƒ	«]Æ98}¥.˙@Ò\rf[…ñ&˛ªÛ÷1^ø¢ôıg¬û+fVË¸`6)	≠5˙ΩEŒŸS˝jñÕ…ˇÖ⁄rÙK≈ÏÒÂuj∆˜ÿ%âˆpÿ÷Aìêıàå†9Xc<_:—˜l#¶(Â«Äv)…£ò,ïÇƒπ∏Üv ˜V-§n˙ûz‚WÛ¨ËìE“2‚D˚Ωﬂ˚˛†H˛!~\\Í©†F¡gÎôJ\Zop\'ˆ]Mi@íÇ¯Û˜P;µõ»VKi¸˘V(‘~níà&^VT‚Snÿ«◊^Û‡EßΩy	ÿu˚\0ciÒ^SuÀ%ôD™{o‰x’\\4\'Å1ñ0pÈ…˙G&˚º∆o À˘º¿AM„q…€5œ@Ï=à≈ ¯@®Î˛‚3Ÿ#\Z–∂/*t\rŒ€6<XÔ˚\ràIFP‚xÅ«N^‘+á5H9_r†©≤Ë?ÔMŒ©ó‘¥√Yµ∫5D`$Bfy¿I”SüWqÿõ«Îærﬁc˘W£Úw\Z˙ì(Ú‰ÄÓâÜ&=\rôeL–|)®a¢Ûj.≠¢VÚ‘C6¿ïÔ\r≥üd˛\n3[@Ô\r÷©ú‹Ñ\'Q≤\n≈í©+†N¡AŒ¢ê¢Í§:Wà®øÈ‡ˆ˘Ï†<\'¶÷„dˇÙ˝Ê∏íSB≥4,‰‰ø˜h“…‹ü+≠ﬂ»{ÃórÖ~aˆAƒècü≈KèAj°TGîï/6Ë’Ï˛\nÄ]≈<E&@«∑Ú(\0æÀa{|Ô,È•@ÍhaÉZ«›ªåπâî∞N/F]\0cOJh‰√ôLœCÑ	˘8◊´hlƒ2Í\"i\r2”£-‡≠è¬X°C +õRæa,¶Ê©f6á ó!\\©I&C˙#2MŒ8_6ws‹Eä˚UÌ∏¯P¢[ÿW“ë¥œ4L∫{4â≈\Z†ÿU˙òuwó¿é\'ÅÁûü∫h¢QÓiˇü≥5z\r√&á–Ç`~Û≠\'\rÏQ†l;4€ï¨±Áó◊eÛc1bˇ0ëwﬂ~ü{˜±wcjæ|m]a_öˆπêÚdÉØı´∏4N˝ú^˜\\~îØ òô◊ÛÌí†7q/\"]∫‘Â$Óê˘&<‘º	°Q€·YÌû)ù∂∞\ri\0\"4ﬂïmlÌ…\"W±KëxßöI0$\rÿ!L7≥ÆäÔõK3@öô\"[qü‚ÔÀØvË1 ç©ŒK&.≈]–˝«¬0÷ô8¸ë p#¸~Üı\\o±”Å=1≥’ÕÓD,ƒp˛	⁄±4zŒÆ)îà‰˙ıFíŒ\r8xŸ’œNz$¢wFöÌºmØ∫$\"òõßÆíîª]X∞¨¨÷eı˝\"¯?™|2˛Y	≈åë¯¢»t¨-	˘π˙Ê‡£üvØT—’®¢ÊÉ2H`oﬁHPOn≠uDpR÷ΩÄ„íRÜ†nO»∆k2Œ©@7 \'y∑UŸôK;¯@IÙ™˘»:7}Ì∫.£aÚ	ÃëHMœ©:	qFÁCO¥ãÑ◊˙¸Â˜™c#ä≤äÊ˝†y\r›≈Ï∆Èö<’•ÜlΩ4‡òô§ò÷¨·(ª÷ÔÛöw	Ω]·ÔÂ5ÂıãFn?ï`Êb8æ)èΩÚk∏ˆá¢€Õö(S;íw‡Aq÷^»;ÒıT»Œπÿ[óc¬ˆ∫JD_¥ñ=$x”BÛ2ÎÉô$5)¡S∏û≤jrxÖVüÊIR-[Ñ“üÈ1êπ.;\"ªÈ=1‹(C]e(Ωd-|5QCÿ…vÆú,—?…aädﬂ”ˆÊkVälŸEWö‰∂±R*9¬∏)7îâÎm˚v¡X≠Úb⁄∑\'Üp	Z9@≥∑S\r0,t`2±plÍÛsô˜≠W”úØºÓ)™0ä8aIpopÑA˛àB´ŸHﬂ7¢Mô¨º¥)ôÕ˚ ü·JˇÜObÓ\0Í!ÿX£+cÕé™ç±∫∏Ú«ÆÙÜÑ‘ë8–@ˇ¯úGƒhÖöar6† »r‹VèB:Á\'Æ 4-≤µ∞»¿I9ªÌà#Ì\"ëƒ‡i›î[´˙-ølîó¿+ãì„\'2YÌ…ÛUÇ~nZô·Ñı¨c¿tƒtäMõh?öÿDmŸ%π¡ ãdÍ]ƒÕ\Z¥»’	MÿµB\Zæ∞rª/Oöà5í¶Ü%±NÃ∂Ê¿\Z\n2ÁË£~óµ≈\nÚ\rÆ‘ıû=a”‚∏¨ó]Òï◊˜7ÌΩ\Z\n≤≈¨˛™æW±¥OñOıÄø,‘∫Nãﬂ∆EÃ\Z\r7ƒhZõπÀÓBLGçøÀ+ã¸ÓvÚS®dŸÕ2ÿ\ZiÁò\rø∞Î/éq≈Å°ª¢uVcÁxì-l‰lÆ8\Zò…Ï√öÛZ√æñ¸ﬁ®6£Æ¶W2ÃlIÊ96G\Z¢B˙Xf\"∆‘≠Æü…ÎúO›†ñ%‚®K3—ì93hù\Z‹4˛2o^i™»‘wﬂ$Se(I™í}Pí((Ùˆ\ZQ\nÖSõµ≥^M\0ñ√ô]M\Zîâ`:£ò·˚c\ZTcœÇø6[Ê°LâB≈c∏l›Œ\rxâÁR()Èƒa?\Z[IûøŒ ô`:ó}ûßõV\ZºâçT’Dnπ˝+·/`{\Z^\\%Ì€k˜áOäêØôÄ≠eƒi¯©:†iãÁÒã o\ZqR‚Tá=ó\0Í¥›,◊\ZXDÌîö‘\Z¥há˜ƒÃK8h\Zxy7è{≥Ë ≤Ëê·¶ê≈zQ1+5:#Mu<‚Ø\ZÖdhà∆®,»ä†ôa˛Ï√˙‹ëÖÜiK¶±#âA\Zàt˘÷Y-{RV €∑FR˘π!Í%8∑ª`˚?O\ZìIa˙^‡í∞ÒÎiJãûHä:ûjÍ:ï∫¿b¬¬ä´\Z≥;4JpR”óöıÆ⁄éXƒV\\ù2p&‡“Ÿﬂ\n\Z∫Õm“¥`S˝Ë|˚áïÿ0	SÆsüèüEAëLÁˆ≥\Z‰ú´„»:˚…H2f◊ù[›Jm<ùåî˝x√<ú0î\ZÈ7æÅõç‡€¥Ω√>€0 XıöÖãœòèÙÿ\Z˘ASËÎ[Ú[∞Ñkn/ß:ø%àÔ>\Z\'ÜÒä_ÓûØ\Z˛öK†è⁄GìUm˛0ä;AﬂÚ≥°Üàçí-vÖn‚\0]á–Ü¥§{lÕ˚CMv„¯…æ@®∆ëTÔ97C§=y¨Z˘ˇÑË3øÛŒâ§c3méî!Æpêr≠É˚˚&,Òê÷˚Y*û…l}JÊpx5K≤5&\0CRdR5P,Bça#1ÉQf\Z\rÿ›äûP[äŸYÿ¯fdä£fsRt\'/iØQf7ÍúÆ⁄&\'d∞èWñz“ì|∂›1ÚêŸ…éz\"z|ı¶≤s‚e–›Q∏göÍJ—–≠z-¯˚Xó+∏|¶Û@ŒV¶ŒcŒxÒ…Ô™§˜ãs|ò0ñù¸‡úv…∂Pß5TÒ‚ç†!w„RLõƒj•Zá^\'{üãª †ı)8m}.\r¢dô∏_Ænº5±i?¯W)ú∞:ç\\`¥^´VõΩ=Ãw=\"À[<ÚœU‹Ä©úƒµ≤Í9˘êYCW£Ú«-µ‚ô¸ûGMÛédz[ΩägΩ bÓœÂÍ§ºÏ&‹{7Å∫øß≥37ki÷‡÷ê5—î3èÇ¨N0PôÆ5yå}@Ÿ™Â˚∫·b1Øpo4…¬A÷{Üı/\"ﬁÒrÀuï¥0yL≥i∑(¿‚ÚHπ\'àvÿ-3†*3ºÑìô^¸”c(^U#µñ√ˇg…ph⁄€z{:é€7bc/…LïV9Ω„bªòÎa≥ÚîrÒ‰~Dñ‡∏,È˙?—†ﬁGd)FAÇÁíuÁÌ`á`Á⁄øo±ÅËˇº€≠r¡ïa±–ıÛ‚ﬁ◊⁄Ücª,=ÌsK§>P◊°ÆÆe⁄õ)9R≠†⁄B£∞û[∑Œ≈|ÒŸı”√¸ˆ-sßåˇò1ùì éSP¨˛“Ü‘E»GIÍ45è’MCÔgYˇ˘<®-b≤ÍOÓ,∞Çw[∆˘6eJ∂≤G7U]\\ôJÊ5\\–Nï(-\r…Xˆ_œj\rè15-Q‰¡õ_∆Y\ng^˝ ∏\"|¸µ.Y|€bÇ“˛ÂO-Ïb$◊t+§8jÍK◊π\Z´◊œX#Ï[”‡™w¿öºÕw˚qç¸™51∏ËDj„ãËÖLH^ÈΩüt+ƒ?àåãñ\Zc√iÒŒ{Ÿ√≠Æq@:œ[ØbÈdl9÷÷Ä,ù≥‹±ÓÉMS,e∆lNrú}Ì6•ﬁnÙé\0O!\"Øj¶:(££!b*C\ráz“\"{Î∫t\r ó=Å«I)È†^ç´sb\Zß¶°åZé\nS≠ù\raÇÙ¢L€&•¥ ‚≠vÓ3+kCJÇ≈IÚ\Z<Å†\0¯P>±†¨%@5ÍvÒ%‚(“ ‰ÙôÚJ¯˘ßØÖaI”∏\\—ìàHåøO\'\nè◊(P˘”≥§æ\n»r’‰	»s∞»ÒJÊ™˙bÛmLhÁ¨á˚[¥£å∂±\'{0à˛—l÷uœÊ íhk°ãı≠FN ®\n…,U|√Î°ù‚ßXÊﬁ5Ÿ)ŸaTÿ›Â‘© %2ï˚˝˚Ry¬ËÇÍ≈´i*ÿ%h%Ê’∆’·Á∂$)`v:#fì™´òü˛.x˜d\núòπé:ÃxAÏˇ-‡¶H>¯∏JÏ¬y;Ó·ı≈”<ûI8w2A 	≈áÉ¯⁄∏ÿû∞0¿øâ2¸ñyK∞|ÅÔ_íò—‚Âê%dﬂ“`2ˆ9™Öxm¬ÒlíQÄWØûËñïU=dôπ£Z°Ë∏	´È ícëWZ:¡wP◊Û{6Ly´?ÿ∑c˚‚“‰Ï‹I\n˛®ıï£ﬂæ∞B2ﬂµ±ª∏z’†ev»zÜå∂3Òé∆òUÄê{Ó^qa%IôB›–õÕWÌ„˝<VüA=ﬁl∏ÎLó∆^ü<èkLè§ã†sj›“•?Ìbﬁ…ñ»í|ËÑBÌê?-(Ö˙+xd˙6SP—Ijã“ó©:K≠œˆ—-ú`UûM‚∞≈uØn÷ßú]BeI◊Y\rf˛6È˝˛∑yÕ;üµµ6\r)–ÃcU»´d4¢BînDŒ’¬ÆQ˘∂n+R¬”J1eÑ,ÏÒP 6;\'ó6òï\"˝÷ ds¥\r„=ã V‡òí\"n*·R-™!Œﬁ`ŒCG÷ãπŸÖ\"∂^›e§\n|5Ôœ.ﬁ∞ä„óÅ…˙Œ8π!¢9:ü%Ó…±ÑÖ§êˆ\'&;∂˙Cø◊r¬ALã*3qòû8ìè∫Ï$«\"Ônè˙≥˝ô$ÂFo§ef$ï„ÓSÖ4CÍ◊\0}UJ5}ºﬁ&‹Jmyƒ‚NL5®ÿŒ\r\Zò∂0s3Á˚u≥6!$æ0úKJéÇ¡®\r22ÒÃﬂñ]ÙˆÄ√ì\'L\0∆€—ÒIòM…qﬂ2ÿÀ™„èΩ\ZÁáßª∏€i(·¿oáÇÏ)›Nﬁ¢„VBá“ ¡n˙LÌ‚c„à\r›‡ ø5óªÖú 2ÒB÷Gì3Öuá´≤≤Õ*”0o˝B«Ø˛⁄÷Ÿhœ˚‰‚ Œ}Cá Î∫oÄGÿ}BdﬁgªDÿâ$ÍüO<L#1£OÿF14.+Íøkc˘*ãê¯9\'qï.¬‹›;ëF¶Áõ◊√rÄP\'Û˙≠è›l¯ó‚1¥e^>b6ÿchN ÏùÌºE4#\\èíG¶Y˙ZÅ>√AQá≥éb&µò¡ãYZêo·ú>QrüÕ°í∞òÌi9\0T9\\>$à2œ¬Çúœ›≤ÿÊjÀ‘Ûr˛≥whq≠¢√MÎ¿TUÚ˙–©wáîÕôCHN\0…Iî<ÊóååçΩ˜.ÕO¨ò˜¢ûˆﬂ∆è¬ÜÕß≤ÌÏ¬‹fh_2E≤ß_T˛.Zuiœ’Y˛∆˚Ák.\\{g·:Ì≠—Ù≠ó´FÑhdÛÚµaÅÒ§ÒGÛIëõ\0q≠◊πaè\Z≥\"D\'Ô¶œ∞ç\Zù;I>)$¬piä\"≈)®”l±—}’*÷Õ3ªyXÛZâ◊Êjoy∏∆\\oCÿ’w=∞ÄÄùus™n@´ËŒ=]N1ı%P0ôÑﬁÀ.\"çâpÜØüéT•”ú˜q(%7N¶™ÖÚ§òOÍ2\"h™kU˘v¶àrÛﬁ¥¨∞∞’\'ÅrÈ-ÖA€DÉÑ^EıcZWqî˘8Öà5êè„˝qÈÜr∆Ã„@Œ¸7VR≈€ò]Ø7NÉiíÂ‘jR\"~R⁄ÿˇO|‚∫•f¬`ÙS:ƒˆ\ré◊Â€b-\\≥| €É£¯î9E¥È¯g±Ë“Éfíé±]πHh~ŸwÜÂÈw€O\0LhD:m	Ü√3(TNÄó⁄Ì≈Ì,Ò∑≈ÓÇ¬¯åÅj∂p¨Jµ⁄¡Ã∫”ﬁ”Ë»Œ≥òSyÔÆ9sÖ68r∏MﬁÙ⁄†®c‰‰ã€¿—4b¨oTìáåº,ˇ>£\nuÇØ	ÕU`.9>Y3`èyk†ÚüŒö∑¿6d?j¨•ô/£&ùb”\"°Û\nè„<5.BãÒzô“n»ÛÄ1YY]}‡Ï{6€^ú\rﬂÂoÒ˛ †aX‹ñ^Ùç€	í§ÖÊçÑs0üƒ◊…ªs¢y0ÇÏ1ë…)f®x§üñ ¯æ˚§X‡`¯Ÿ[Z76Í◊ë.üÅ-è*ÿP´«óUÓ-8m@e˘0å5§\\∏´wMv‘1.≤ƒ ûR˚™fq\"^‰hS€;Xˆè•ñ~¯YÌÌYúßö^Â´¸œªõjcπTÓòx‡Fw7¢?D?ÙΩ¨Fa\0”∞™-≈@Áh1Ë‘+˛˛K(Ò—„—aº„Ÿ]êÒ¥DRÒﬂ:[â_I3yÄµ‚î wt◊üª#Fù3˜ªµ=2Á¥’2Iã8 €JpL˛]†]}≤ı‡0né£ºP\rQ¨•Àﬂ“‘cJã”YBÒµ=niQ“=NeŸ’±unS,ä’Âh ›‹ÀXÚÕ:™_Ÿ˘Uü«-∏·JƒrS˝5¥îî∂„¸∂Ö˝ëbt˚ΩL»í∏|ƒõn 4è\0∫ŸíÛ\'ƒ/XMK,f\"*Z$ÔÌºÑ4∏Çª õ%Ø-Êb#€6u|ëæƒñ}°bÊåJsÚ6… ‚h%ê\nfﬁJ(ŒUêìZπ˛µu·@•èàD´RzC .•,2F*õœ—z&@§Ù;ƒ`x^¬#.ÒÑW(ñ` :Ök˝YÑä•MjxR÷Å÷¥ñP=è„T¬_U~ﬁQ  H’ ±‡yÍﬁ4ˇBWî@cî\\ß¶ÿ»Jﬂäq„◊GC W°aQ÷◊x´êıÇDŸ2-q%µol˛(—Ó]?A· kuPéñΩtù§ÕÃä√∆z®\"qg√¸∆‘‚¿=Ö(0◊ l⁄\n¬∞&|•\"‰wK~õÄ30,ä‡¯>≥P≠æÈ&w mˇ2¿ïˇNªÍ8˙aó>BdL¡UµoVd^ â§ûŸ¸Ì∞\'∆†© $nﬁX±Ä¥37⁄N≤ñ<∏g â‹YL´ß&ëØ>‚≠Œ G\Zu€%XÇˆ-)¡ó“ ö)óï¸>¸¿Å◊Qóı|€˙	]vâüCÍ†,˝ˇ õ7Í ƒáÍK˝4Ù˝sNs”	Qü<˛så|ó·•Ô· Æ\n	Á\Z?`ê%TÄpÒ6Ùÿ¡#IRÎ´˘˜lúRÑ⁄ ”å[*öktÂC¨ë`x∂{c‘!’ô\ZVWÓSŸ‘sËtå ‘Óƒ@W4n˛Ç∑Ô*òt˘òQ`EJ†›)è»)e%C!≥BwŒÌî¥áQÄ\r\ZÙ-ÖÖË˝1À˛O≤!´ÔóƒTê§·ØıóvÜ≠Ï€¿ãÅâŒ±˚ıË!⁄®-œÒOhùËc.é\ZH6!ßŸps¸4zQ…$\0!ƒ)u«^ü÷)Úh\rø‰»±>uOKé,hc$ú∏!,ìel»sÌ\\ÿ˜˘055Ï.fOt¡Û≥˜˚eç∏}!5AR¸/úœ{CaÄF9ˇZ∫_Ót´å%8™,=€´!?”U!ÓÕ)lnﬂUnˆ(\Z«ÖâFÄZáÊÈˇn!Z‹mNxIé>W>%ù¸*ÔròÙèì^ê±#\\µQD!]êÕØ%uOÆb˚≤åç;Ì¶Õ∞è(2[\n¬óΩ_!iÓ›\\ ≤◊åeQ\0òr∫z.ç+;\0\Z)â™oÀ5£3®!àﬁ˙˘\'î®oÍ]∫ﬂÔ±Ú≥tËJØ∆:soTﬂ√!ôx§–6Ê^qªÆƒ>F70ûV÷µVñ>Ø>≤·µÎ∞!ûÆ°$™Ê1≈≠9ÜºÜ5\n2d\\aŸWóï\Zq∞3x†!§:Øq…¥&¢Ùgôzû68÷õ¸dÂ…«œ;tV;U!©&–x›˘î[w§ç¿˚)§∆»Éc¸NñS˝aŒ!¥•Ó>$wƒú¶ˆ°¢Fˇ\n%ì`IJ◊M6óoÅ(“ñ!ªbÉôFÊﬁâg2o√i\nNl+\n˝ñôﬂµ£Ób!Œˇã5A√†«¿Ø–~˘I∫¸ÙøÓ \\ÄÉv(ˆc‘F!‹ˇ(\'e–é∂\r804@ßödïD…4˛àKSÑkV!‡a¿èîZU£ûÔâ/<rg$ΩR4gÕZ¬0¥˜lë!„Â\r;òm1œºÄ.Ë{r∞Ä6@∂C¥‰Hc^\"A˜!Îƒ©tXÛ≈QôŒÓ\"˙çﬁæ‹—ím]¿‡ô‰2J\"T‚YKãÑ˝†±¡∞J÷Ù,/˛º‘\\ç/ ˚d\"∫h>:ƒÍ·Q ˘çÍ±Àsik°ZµÿùùﬂËEw}b\"“:º+·@ bÍ$æœçTØAtÀ6årŒ£\":fn˘êJ\"≤-vS†õ¥XæÔ˜æ¿ıŸ^≠\rÀ†#\"JRIx˝¨Ô9ıéW¿nŒ\"µ¶Ça‰¶ˆ‘ôæÜˆßÈ\"L0]Äòì˚èæ”ÜıŸ•y)UePù∆¬^˜õAÿŒ\"S„∏.87~96s¬≥yjr\'åÂ]s\0†êì\"\\Ä®“¸Íﬂ&SßñºπÑìâ^Ç“\r†xQå⁄Ïfµ\"nNΩÒv?ÓKÉ∂∏ãg^Â:m∏∂ôÛBlbZ\"ÜΩ+f5f(gdCìŒ<i’À≥]u∆®2Ÿıƒº\"ïíÑ$lò}÷eÈ≥Êê…ÎX¡\\å%»í\'AÂÃJ\"ï¯	Æø.FÕ¢÷Y\\ıûgFyóé2\n\rMÜZí¥\"ö¯GŸ$@ÄÃ˘Pƒπ\Z7~‘ßO∆¶p„db†¸\"ù):zeÖ0Eπé8˝Ü=!˛ñ7°”∫÷l<ìZΩP\"†/∏JKª’}µÅ¥uù∆—vËa‡Hç˙¶QòLE»¡\"∏ΩÕ!∞zF€∫6å∆˛Ωâ¸Î&ﬂ\n§ßsÆ|Ó\" äÓ«è5â¢\".M„pï¥¢-zx)Rö.%‘.ô¡8\"ÿåV2M.È\\Îô˚e#¯NÿÌ»°œ>€.§˝:¶‡I¯\"ﬁ_§ÌÛr™§ùÅ–è¸”M¸DZN…aüä≠\"‰´2e‹ÉA#’·Qˆ≥)\rÂj|ô·\\Èrmß=‘¡˙\"ÎLõp®6-@≥î!#∑^kY⁄ÆXV£F¬ÄX‹65¥\"Ï=Ûö\r≈Bé∏>¸í\"ŒH·˜@ZÊ#X∞VøWŒ´\"ıË8ø0#>¸nÂ‡yl¶Ãv˛¥∆©rK~Ñ8\"˝;z√`Ç~gÂº^æ_÷‹‹Rõˆ¢5Ñ˙—Ç(ˆ”#ƒü_‹µ?ÕW»÷/≠ûC+πÇÉ˜∫U“ºKG#Ö2±ËsÂ—\'|xöóÚ,q≥ô¬¥€⁄ﬁ£ø\\\"\\*dq#˝Lj@P\\ñE»ºıÈ∏n˝xÀ$W“´r1Ÿæ6}#2;#¡/7\n QrsE&]¿—¡IêeãYÎcÁg#Oyw;pÖπî”øzüw,!Ä:;umjıÕä∏)#S¯RÔm-Œz≈üQ∂¨\rÿ«‰°:ç QÍV¿¶◊ #flòÊ~FÉÿcAmƒΩ¶b\rV÷ØqP9i√œØª#fÜËˆW*oñÿ_Ê\nü„Ê≠«÷U8Ø_™¢\r÷£z#mï´˛båT•·Æ…∏÷=í¯©VÍì187ñ>èÉ#Éµ_”Ås(∑∑ÀsxÒa{À€ç{A-Â¯Ùèá##∞Ã®wAÃ/cÚ“[·‚&Ge\Zx%%Á”=íC[a#±ôgÛ«ÔC√Yõ<äÂ¸b¥IÛV?æøJi^∑aU¥B#≥ÆyƒΩ˘Tfªá‹<Ωæ,Ô9z’,Óû;¿P–õ¶#”ô>ho/¡>¶,æF±±‰™mË˘É@`É0öÔ#g#÷\06¶î˘|–†ì’YDäéÖ≈¿õÃ∞ÿ£wty#ÁùØ M∞∞+ó∂åB¯*TvÕG«í?™oLJ™s˘ù#ËBoKm±◊ƒuÛÃÔq˜≥GÿKLÔäÖ“5¶=Oﬂ#˙V}ÄÈ©õF\'yΩ•#≈v	◊º\"√ôíÊ6“GÅŒJ¸#ˇ˛Ø∞ÀÚ⁄]ß=Ÿ0˘¨í\n\röƒûíç^Ê\'Î<$_¸ÈŸ-ª\'Ú8u–P¸“c‰¿6Ÿ#	KEumÁŸ$\rò”«‹∑2¢›ì⁄œº’+ÇBÓ√˚©…°Q(-$≥ü¥F:6~QQ\'◊ç¶:‰3~§»Ûª ¡ß§U$Eq<âp†Q∑(&{=í˘˝XÀt‹\Z˙Ò\'Ìﬁ\rΩ~$#\'Ú¿Ób»}‘$X:∂cƒæ˙m˝]à\"¥V§$2ØÜ	Ωï™J8À›+¶n\nbO+9∫¨¸2ò‡™Àq$?¬\ZWÎ7‚mﬂ(w{KïÑ°\\€∂é◊ÆéñƒjÑt$C˛§r·{3ıº;Lnü,u w`¨∞¬ã·7˙˘p˘E$I·l;ø˚∆¸˚_W\Zd€©∞¿ßŒà\0fm•÷$XA¶8≠í8 Ãﬁ¡3ûk.bΩ4àÒDZ∫Ï•Ω$^ıW+Nà«Nß	¥®“ª@ŒyA$≠œÙGÏ•ﬂ+Z[($h/€Ï*√ÖZÁOÅÚx+øà-Î°ñÈHÿ©TE¿·ø$jö^2	å‹Ωì4`Ç‘Q¸ÅÓïQúÎt≤yTré\'$læ∞€µ	à¨§n§às}⁄ZÂ∆◊Ú°á?ò|º:Ì$áV&¥<Ó% ÊóÖ.√⁄ﬂlâ≥‰ˆ¯„πØ˚Êû$®∏E,©_ß≤w˛˘¨ƒMJI:∫∑îûéW´~¿∂Ø$æÖ§ö`†£ÚÂ5Ï~VWClZæ∂áˇñÌ≤	°|GN$¬€±ºÁl–ØsÜF,û≈≥eIx÷\Zç:¡Â>˙;‡3$“€Ê]‰:)Ñ~K◊F,B4w˜üºïèŸ®/cÿ,ô∫H$‘ëú…Ó¥<Ò»*Yª+∫‰˙`pÅ€_ó/„»û)Od$„ˆâÑ±`ØMHn™#Ü<K£∂ﬁﬂË*\rΩ¡¡e%%é·k∂ƒlfá;{è›ÖT•_¿œ<{x%•[4d·%S3BG\n9K°Ω\"‡U„f∫q◊*Aõj5„\'¡œ±%Yùûy\Zä™è@‰⁄§˝~&«®1Ø#Ü2Q¿i◊Æ%nM«ÆË∫iÒíD7ì@qäV‚“#vœE©>TCdW%v+Ôîê4)©%ÓOiˇ+a‡dgòF2!ùàT+…%ÑûkÒûúr _îõâ–Síµp¬ÔEµ∞Üî3±Ê%∞õf3¥qEﬁbôƒ<ÍÛrÎÿ]B[µ˛S@k1\'b%æí>≤fì˝Ëπ„ÜXJ‘&·–ñ§’>Zïy2p#Ô%∆07∏sâ\0\'zM|À:9#‚h7¿d¬Ja6˜◊!\\%∆≤ˆÁ‹aÎU>»ÕÓZÊZ”	YD^@Nƒ⁄¯N%ö%‚8X_ë“≤◊ßß%$9ŸîÖ*Ñ_∏¿Í€˘Ûõ©Ù[%˚ªÓ‹â±˘ê`˛˙ïª≥n«‹õõTKÈxCtïæ&ÌX›‚y&Ã∑-;◊ëåùuøHÓÔÓ‰\\s!œ˘5ö\0&\n§»»¿µùuíOb&ª\"ıM¨˘f?˚+ATË±(§M&çÔp©õÿ’Òjó+çı“ä˛%ös<≠\\±$&I±§“—ná‡Ù	w≤Úﬂ¨öso/ƒ*ÆÜÈ°¯éAŸ&J™ —¥ÃOﬁ·|ÊÄdû),Óó)	…∞+\Zót&aÅm{[Û>€Bv\\`öŒ :nw’c)»ﬂó%Z0‰&|∫ÄO	gÒ)ˆ2ª´*Ä◊´7‘o-∏›ûrÛ?¯‚ƒ&Ñ[onπß«Ò ölñ˙Ìaœ≥ât‚WLäQO≤Q¬cÛ&ùŸñú` ì‘˛¶‰Ú#tﬁô,óQµé)Då9&ûƒtÄÔÊ*ñè2é®§~í|˙1/»Uﬁ8ˇVY}$&≠æ¯»mì4tX˚FÜ˛å°@∏RµÆÿ è∫πbL&”•Yk‚˝\Z†nﬂ∞XªŒOÍı„£⁄±Èæh€ÿb)&Òı⁄˝!Ñˇ‚GÍ€À!∂Cõ oF˚Q`üB∫…ÓQü\'ô◊l_J”ˇVƒÏSu8VHJÑ¶í£Ÿ“˜yC\'º™DƒÇ·D1Åïß˙`⁄Ø†Á/5)ÚÃÕ¸F1©∏\'ª∂Æ+Fª.‡}M>W\nwJΩ]}&∆#V\n”‹\'(«\0*Ú—Pg\Z$ó\"PHG!˘ª˙áé˝‘â5åjèN\'@˙ıΩ?Bí{¥uBt–Õi°\'Sèﬂ?\n∂=„ŒPCŒ\'F.Ø1ÏEœ)ùï¡Hé;‚lî/.n¯7”««|WÁ*\'Gø¶L‡™ œs\réüŸ÷+·Q∑N*ı+r;_1Ö√Yˆ\'S{<èùó?í˛À*„fî;∞≤/√{í\'ÍúÏv\'k7^ØY´ﬁÍ–6÷®{JÔ‰/Œ’öÇ…∫œdN©Û\'åŸQêÒ_û√+gÆ‡*d©úÌrV«†∑¡˚≈\'*\'´pÓGg€_P@EuE-Ôjbc=ÁHË†ï\\M§ﬁWä\'∞°Ê$É1,;‘b„LÎê(Àì—Ã∞Oƒ\rMïg–¥–\'√iZ\"∆Æ”f=˘D◊Fï»GºÔÈÛ\n_¡B>‚qYﬁ¥\'∆*«ãw)M°€>ÍSY\nˆäSöö4œvn⁄aﬁˇÈ\'»»9_e≈Z˜Â∑hÅZÏVaÈá¶åºvuÅÍ[*S\'œN‡9·…Ï°r∏g_T∆»ªk˘ÇŒ¯ñõÆB∫—y\'’q∑˘&1–Á,û›S˜Nj64cÏGÕ&Z_‚·3j\'€^ ˘∞≤§5j%—Vñl÷Á{Á=äÈ {¡m∑@Ÿﬁ¡·\'ﬂm/πñlr¿øÈ…8Í∆*l	=$Êûí”=£h79a\'Êj*Ï,¶AÜê.É…˚+Ö-˜T∑®Ô¨≤à*\'Ì„¡‰¢ŸçNãf⁄Ó[ÛOégÊ∂Óü|\ZË	ˇ+\'Ó¥xˆr≤X∏k„….⁄Ò~‚≈b5∑«ü®<“M¬Â“(:´˝MQÏﬂ =˝Î©™ﬂ™yyLªïﬁ¢Áå⁄(Cd?hvìÅæ›“∫n*å˜1‘ÓZÉàVÑ(=ÅXïtwÏ…¨DŸ†.=H\ZSÒ“¯°µ\Z·ª5w·(?ﬂæ€n·T §Z´¶ÜΩ˝†\\9ÒÂ8vWπ¯»\Z•(E\0˘	ˆ73—/>àu0êß∑π¬AH*$\\°˛»ı(\\√∞w0#rãFﬂºŸ•^GÇAcw®,t¥Åîé©¥(aù8∞‹ƒÚ)ÄË~%ÔcG›‘:~ªç\\\0p#t¢ëF?≈(fp\\3{¨?\"“];>WñØäÌ∑qBË›Ï5©mo(nŸÈ–søºsTÚj+<$ü|rE˜Œ~‚åÈ⁄(y:wj5Éå1˘∫ª\ZÁ! `≥Æç<û¢!_ã(}∏6È†æÈëˇˇÍ›Õõ\"ªíò‡®˚ÈÇ$#°(Äèwèyëïe\rÖ63TÒ¡Q—-çæàÉYíTú=G(ïŒò\\ıâﬁn ‹lpuπÍëù&]ö∞yòiõJ)(Æf§¶ñ¢qiËI‘pﬁ‹≤„,˜˙ÌKò„Òù(√≠—ƒº\rC	°¸vÖô±°SÊÏKO]l]¨tè≤ø(«mˇ}¬:÷Éπ{ôÆFi\r~^á¸ñ™`∑@Ä2$å(⁄ÆÂ≠wS4’˚B®lÖq`8œzª·W:5HI)z4ÅÛ∏…pçhziâê˛T±v…–/°‘∞x¢î≥∏)!§Å/øÅ≠P≤d«√ÍtÚO¬;DùC·§â˙7P5)%^¢ñVÚt¿_Ó\"L&x?–.‡õ•ŒÚ´“™—*|2OQ)JJQ∏%òÊÑx\Zïá¨¯	ÄªrÏ]§(R`¡)NŒ\\n¡ÀmE¡\Zkìc˙ˆ÷Q˜§ø≠(a÷ÔÙ)QF¿ﬁ∂˙ÈŸ–céÛµBWù≈k¢≈˜!óÒ)ZÙ!YîŸç⁄ÏØPA‰;æÆÆö]n˚îëïï)a°–QOh–°/z√†ÊS\06ÒŒ˛`⁄å )}¥V∆O«gß-w/¢^∞w6!E„˝àËË–Ú~É5On«)§°4\"m:D¶[:K~>ÂòÙ≥ÇbÏ1¡E‘©()ƒ!e°èÉ±£–§R›ÄzgÜg6ë—çlêÒ¨ê[≤{)‘Q1òŸ™Ëpî$´2Àùn#[z*/	*?§|¨)ÙX.\ràïπΩjÖcƒÀT[qí1«ø‹]M»:ÙΩâ´*≈˘˝›&óÑøÕÿS§§â“∆Ωté‘0Óûæô®ıÓ*%“π-ÒÀm\\˚Õ€(´<¯`}yú†ÂxÇ	à[l* µﬁj˘ÛœY£Ñ6XASÇÏÕê\0t_¶·öB*0Ã?¢ì\r≈ÿYoXd¯	ﬁ:Ìæ©•é@≤ŒMFIÊ)*NÈ™±w∏å‡jéáu\r‡¯ß3À‚˚•Ù£Ù*Pº|Àø(WØÂaóOB®ßÖAÄe◊¿æ˛•ˇ:£’+Î*RN⁄î%>ï+£ﬂÆ6Ÿ“◊Ën^wj˛»9˝≤8‹*^—ÙsJ˝^1∆@EõÂHŸµ5àEW6>Ìi$´±ò*enå©|”ó€QõøDU[M!B\Z◊XÛ2üUgy¨*j4£úm3:†PÀ‡0à\0Â\0ÔO˜¨À9‹¡`*k /ŸYlÚßI›>CK:ÅÓxÎ⁄ﬂ›AßnÌ6[*πÁm·“∞—«ïù(÷ySlôìS«XL£	˝3QnúŸT*¡Y«◊D>)ë˚kæ\'‰Y‹O+õj*¸ﬂUY‚2µFµ*¬◊·’(éá¢9ÒæÕåvÂ&5d2|≥—úo<Øv8*‚ÆÒnT˜HSaQÉ¿ Ãp§˛GŸeˆıÎ£’ıògz*Â.C‹ÆÒ·)‹iò±X«Íˆ÷F8é9—é,Ø⁄‰£*Ó¬á‡jlµJÉ[ƒ∏ÿØëiïu*_êˇ	Áû˘∑¥ *wVS∞1ôY´ãÉ∏∞\'ı;Œn_ébø„ÂÌü6Ò+sæìfÌhIå¶µ7≈ˆïÑÙ‹qÛ¶ zÔ”}04+â‰’%ù€<©ìÊÅ“ÚhÚ¥˝ÃaÊÚt¶>’‰º++Ä≠BPxP\'\"‡”‚XàpÛÅ–T©Ïëhw\"e†+(Oi~î.I%∑∆•Ó?\"~Y‰πãˆÔb¸oQ\\‹Y’+E–Àé˛˜RáâÒ9KBë¬‚Ò≈$˛\Z 5ﬁß∞Wd+I∞ÿ*¨íøõèõ √\"2íÔ‰≠Ê:Gflîåp‡=Ê∏+^àﬂHÆˇuﬂ≤Œ÷®Áºn¢TÎòÊÁZÿÔ7ú»+úà¢Úk†d\Z\'»çÍ,∏G∑wwÇﬁ÷¬qNﬁ+π˘ZPõ˝‹÷‹2Ù—lv,,Ìê2Õ¿RøVÍ~íI+‡Î·”÷›Í±Zr\\çaÀÔz‰Ó„k÷ÃßŒ±k+ËÈË˛˚±£Ô Wqzé\"ß[◊†ÀΩ_≈{¿ ,\rNMÏò‚d∞_ìïz_T3$7Xc.5AòXâ◊˝,ñ˛XâŸÖWvY9…b‘Å\'˘Ú7 Ö}\n‹,#‚|∂xÀIhã‹à€GÚ:‚`3–¢{_^Òˇc·,aY”‡}PR6ÉÍ„`Ω)KÌ¸fûism ∏πË,h¬g8Ù’∫üL˝…ãΩZè˜:áí\ZÛ‡¸√≠ù>¥7,mÉ˛\ZùrﬂbÎ’…»Ã¿J|&\\˙¶\"C8)àOûÊ”},üüœ~8˘◊øK3k.FP?R()‘oÚ»jçrt,Æ‰Û1Ü¶≠^ÆÍ7\r’x6$\'÷.—Õ·ÚÑS·WF‡,∞!\\u|Å1ÌÙè—Ì;•8¢}Æsèñãærõ„E^É,≤lT—ïôΩ%ÔPÍ~»úxq\r∆⁄”∆ﬁ∂ÆÇfÁ«,≥S†Ω\Z«\rí∑zÀÉ‹]”¨#ëçpD*tXâk∞Óê,∑g£ÂE‰Æ^\"«§5É¬∏™±⁄6¶‰óFOïá,…⁄Ä1f,Ms]BÑÈ#^‹⁄X¨º´Ü=Éd`„,‘Ä∫J`‘j0øA\nê¸¡*ÆL°€zG,€i⁄S~?:5^:¯b\\BG„QÀoóz!ãbvÈﬂE|,„Ø¢Ú/z]ˆã≈Ú_˘óººõW≠òÿpdº¥©.f-µ \0¥∏&ì≈Ô_K:¨|‚ñ¥,Y∞»¥4UTƒëø-7bkŸöA53ægFEk|ç∏^⁄íënª^Í)π-#ç;≈πD†¶Í∆√‰ßo˛∂ûIY√MˇAÙuª-4aàkO“˝67ΩÂÅZﬁ°Rï)¯˚“‘&π~	Ÿ-;i\\3˝†.°œ\'=œè≈rs\'Û1ï\0Ñ<™-@éÇg %à¸ßÜåuON\\}@l‡∞Ã•f\'ª„Ûº-FPìπ≈9NÜ§föõ´è ;™ºÓ∑ñhÁÌló4E-ΩH∆P{c‹ª:£n{2˘sZù∞q:≥7 A)l-”ålá^Á.‘´Í–»;	>ºΩÕ<‰˚;üËnC\\Ò¥-◊™1˝:ø∆˘c¬Ñ&h…Õ	›÷≥±Î4V∞ßFΩ-È±,hÂ8ñfªaP∂jgWÇ>≥qå˛Ω’\\úq0≠-Ìﬂ‡kÑ«yn:ÙíäQ±2€ Ää¥öóÙ?√x›-‹vâwó\\yËUÙ+.$aWà›ï2.ÕFÕﬁ-˜{≠=mMÚzêÿ⁄ ∂°çK∆zåºgR*É‚õ(.›Î(2ÁGKzjè\"ı ,Ë5Í5è+ˆ% {	¬W.«Á~\rﬂB|\\Ë’≠}Ó≠:tJã—Ósf…Z˛¸Ï.´ﬂ…\"Ÿw¬ä∏k~è?ö\'®Lûè-ﬁ Ö+Ê?.%%≠ÿåå˜k…êT≥aﬂ¿EæåQdu∞8¢Ÿç~÷3.)Øy\ZÙJ\nˆ*Fº£h,∂ÜTõTÌu‘É◊ N.K◊nãG\'¢z‰Ù=_Âô‰ƒ®Î©K\nÕØ·O`r9.d-véäú€∫≤≈í»#u—7öë)∏“ì{µ¶.{¶fZƒ%ü˘{˛34ÒÃÌÇ`zo<≤\":qe5Ab..ıáI«˜ÀŒ)6Z©n)ˇ\"6\Z]\r3ŒCFZûWΩ.è)G]Cå‚‡ù{î.Æ=ΩCı+„[p◊’-æR∑.öB∫¯xúá~Cdîê∆\r(olvÙ¡Ω˙‡∞+◊¡£k\n.‹¢„SP*öÓ°É6;ß]XRC—…Ü\reâgñfÚ.ﬁ–πh‹dBiH…Ä‡nìs∑Çà¢·ùóã\\±ﬁÒˆO.Ú«ƒ:‰ï%q/ì}!í*´ù‚:r\Z^¡E›«ˇ¢º/øu¿¢C;à¸≈,!0ÕAéA+¶C«üêg23/ÃsÊs≥ØZ*∫j)iﬂ–±Æe´†ÙQπ3>s<Ò/^Å‚W)H◊Á\\y¡=Z3%∑1Åq^Qd“aÈØH/¿ø<±Eˇü=CÀ˚Ï$íxˇìBHxöÉJ“`Jw/&dxëG:êIVt§ÕÜüÿÀY∂j·«œM?Rä≈\"/#Â◊ÑÀˆ◊ñ˙4˚$ü«Ω™ªÿÔ~r>-h%8ïX◊/,±b£ˇï’2H˛Ë¯ç„=X”≤\0¿∫Ûı‘DƒNÌb1/.ŸòöΩò”Ó√á˘‡Kv˝\\ñÊ)◊˜wΩ€Sπ/7˝⁄Ù0/!B∏ßsÉÈÍÏ›íoB‹Õª•êe±}y^/>£⁄wi`ﬁSêèÉæ”{°oFí°íÔ˝Ü:≠£i8ç/M∂Ñú∞4™ÍH&§˙o≤l=®|@’uQÒD}ÇWßp/_æ9^ä`5Jó“º,åÀ÷⁄ﬂY¥‚ajÄKŸE›ÂlÌ/v ˙\'I5ﬂR/^\nBR7Ø0é1nQ=âù*Q/Ñô|ÖwŒÖï±jàR◊√z∑ZHcxS  JbÀÕå¶/ÖYÍleüzIGz¨‹Îzsà´•s=\\É}Ê/éÕ‘£˜êöZµ°g\0cVû◊•vÁ·πdõZ∂/ô	43s◊˝Œx ÒØ|\"¢@∆-8„,è^F∂/úñGO%<é\"‚‡ä!5èèƒ®Æ«`0<πhCJ≤∏î±/ù¥…\0∂âN·KoÉò ©€≠Ë©°{¢ngg›Í/ü˚|`˝≈z¡™Zˆ\0^\n∞àÕé#0˜á\"ùîÙ\0@ûµÊ/ßÁXùûé≈ÉΩ‚Ò‡Y]øèñ†î¯IÅÁ˜ÿO«/Ω)¯ßÒ‰À≤À¯‡jtS∞+KUV›SÉxöÔá\\/æº?úÄ<@q˘üvÍ°ˆ4˘?Ñr’cmã5ı/ÀFA@TΩÔZ5«a° )LOf–WîªRl!∂\"tàö/€œJªtR8ù∑Ë‘÷ìÜ9–HÚµd≥¯Fÿ£8≠ë/È7ù\0ÿq©e\nO^0£s‘ê@Ó7¿“ˇT™å¯y0ì!ß‘Q+7Ø„Û`GÛ#Ù\r˛)’«S<\Zˇ{b–0˙àèΩñC?„B≈k’\0\'ÕÅÆ<ˇ◊í+F/&\ZCË‹ı0Û≠ío†§7‘Çÿù¿^≤ë\ZtŸU◊:+Í°“0ÏCO™‹¢6Yˆyó¥˛∏†K8Ü<îG˜ûTºJá0)¨Ö5∂¸÷iKe⁄ÂÙ£íj’àí ‘¸Tˆ|æF$À4t0FÄ6^ §pÉ	,€wßR}nèlDáoÔYD»å\Zï0J;;ÊQÎàx*Ñ©,Uªä”ƒæÏ<g˛_;ßo-H0X!ﬁç\nB\"`√Å6ˆËˇ†D© ˚œKP?±Ô∞‰_ä0Xπ73S;¯†«\03m‰&)Ÿ$K>7ùwtT¥\"µ0[n”⁄ïrµwÎ˝e&≥˝ÓE_«Jù„CË°Ÿ‰íà0iœG/˛+UÓëW3Iúi\r®¬∑8àîÿµS ∏ß8ï0s»a¡±•Ö∞¶`\"*∫m(|-=©9ø∆Ñ˙†§A@0¿(¬À‹<È~Uœ-t.ô&ê]%/wà1Ö©äR®o0Çi˙¶\Z€j¨±√àôº~˙3§¢~˙á÷üNŒUë0åÚQ9\'´ój\r‹Å‰pâWCÇmˆg0b®°ıu+ˆ<0†øœ·ˆ®ËSbéÄ∫]ã^åÏD´Ï§—üd´‹0•ÖgæÜ“–∫ Â≤´}ˇbIYweñ.ÍGû—0©p äR‚^=©˙Yõ†¯ºo(·‰áa*¢7¡`¡0Ø‹,d9…òÛÑ∑Gı\n6˙ÍP“«$JC97,nÈHÁ0ËqeRä1:\'∞ì¬„QêDáu»„hV„–¬wœá0ÛÃ˜†Ç\rXyqﬁ\\dâ¯Ç]j≈â: +RÑ(ˇ7Œó0¯∫?@›\nQ¢õ∆ü§¢q0	2ºÅàz˙Rˆï—Ào@0¯…¯YñÏiÀ—æÎ‰cè1ÀÅ˝ \Z±≤≥[á^r0¸\r¡HçCxé^\nÍêÎî#ˆÁQÌÃÎY∂4NXÖ1Ñ!3Q*Ñ\nœÙX⁄}≥(ƒb«z•=•ú.≈˘/1&ZV∫0—c;˜ªd«ClöﬁŸŒæP`Öñ˘üc˝1/p™ŒJVQÉßÏ2vÖé˛ÏïÄû]L9Áe?4J15VÉ‚∆^,˚πãégK◊‰ˇÈ|#ø0£Idµl·o1E(”|TÊÄVcª-N¬ø-ÏÌﬁæÑ~znÚÏ}µ.µ1\\Û^°ú„8à¨Úƒ.“lõ∑jÂ–Öå®Õ4x≤]õ|1]õT«¬íÏ2J\\+	‰i¶6Sév©ÆS,EÔÄ¥â1eÍÒ‰ÖÅ≠8o£NÿT‹:˚w8ùƒ<•:⁄’®Ó1h\n@˙îﬁêÛEA:Ú\"H9°˙8ÇGó◊Eø1á‘Àuæ\'éY	£Ú√ /%˘«º\0õàÁ•ÒB∏¬\01å-#ˆÛ$Ω¸≤Ñp˜&∫Åh5hÌJâm9≥ˇÉm.Ç1í 7íıHô}∑Æ≠hütqåE¡äu6€«x]∫1îSP^&!È £!\r\nOÒ¨6\'Rò Ä˙6°a\nµ-1úHå¸Ï—\"ÿgyﬂ¸—Ü*Ÿ&\Z±ÅŒœb&fK˛1°¢ø_¨ª´Xá#/I*DπN≈|Êqx ¿]\n±\\t1≥Û¢®f∏@gò¯Ï<¯˜gó-vIÑõPÈ‡8Ó·Å≥1◊ãˇÕ0*∫E©3:/í≥2p°‘’Øû\0K2^˛(1Ô6sË4⁄>gäÅ¯HT¬˙µsÑ*üNVâB™ﬂ”1Ú\n	Tk5tÌ◊{j∞¥.\Z†ÈBΩ5$∫V¨Ú{Ú26?√¥%I8#ÉAaüçßWÇº=Ò™›˚“ÄVONhEœ2AÒç˛WB]±∂bû}˜øcﬁèØBôƒË˜#…2B∑Qb9ÒLÇÚÜ\'äƒ»Õõ¢‰∏˝B®BTé2Dl±yÏ§O_!ÄDÂFjF^∏=Œ-Ôv®Q\"T2v¥2Höòás|k√-D`¬äÒ]^è9‹˜‚™¡Õƒcı,2SLÀ√bàÏ{º≥‰öƒ—Xs”«Ö*û@)Qò2vziÚ€M%\\‘ÌXt‚#›Óûá$≠ûèeµ*Éæã2{yC$%B“E;˘ï®¶¯ã4>©Í´fñ›&êb=Ù‚r2}©¿)vD$t2˘.PÏó≥˜∑á2åAá¸⁄GÙΩ˛8Q2ì%êb¬…˜›SΩÉ™Oèˇ5 ]	Lf«òß\ná£^º2òÒ”ÜJ·Jô/CC7N÷ç◊å\r™»j»ˇãÃi2ÃMm° Q¥fÕ!·û=sˆ*î˚ôò2”˙Á\"!-“2ÿóßƒåÑÕœ_g[)@ÊÊâ˚23>≤å«,Ò.º¶2Ïªˇ-ΩÂÌø;/¥{êM¸aæëÇﬁèÜÑ√ª\\îuyÍ2ÛŸπ‘<≠ÊdI=•@M8≠”>™4ác!^i N3fK∆fY”8~Dh_÷‹È©™î«%*&zÁF∏0-‰3(ÑÓJ {¥*ÅôÄ‚è\r[Ûü…⁄‹Ωí}ÜW33)\"∆K\\,‹‹ˆh+ñÓ\\\")˚`∞ì/W≤⁄33à9Dk«Nd\rÏFáõ$±Oá2Ì>acêôc;ôSˆ3Eî!îõ÷ÜﬁÉXO+Û¶ñÛº)à\r^gP«ÅJ3O¢ôÄj¸}.£Û”„√¯j	^W/Q(œø–∏hBC3Z:◊2$æFy”P‚7bÿ°¸: ó‰yáM˙›ÔÌ3r≠˘=Ö´	a‘ÖöÒÁ6ò~1Ö¥tü˘¡}Çk3ãi∞äÂàçZ+≤+<A&±œÎ‹nÈ„?´ºÇ%¡3¢J~wUV.gDîØö%ﬁ†£Û.˜øP	Ç<QÔ3œ7H0œ0⁄¡⁄‘≠*:ﬁ”>‚Òaû_⁄Ó∑r`g3’¨⁄KYÖC‰Xñ-∏ÓkˇìÌg9[≈Î€≥µ“Ñö4PÎ¢¢\Z⁄–+Kib«E±W–íq`rπ\nQœL∏4\rû¡≈(HO_)ëµy÷JñÒÉw‡L„≈ˇÜÛÜ¡ˆ4®K\0¨$Õ⁄√|%‹∞^ÒqÔ˜B€±&Ç•œKÖÙº4, j¥≠Ú¬E6©ÜŒ˛¢‹˙ìÊ@µ˙À9&ñYPd¸4-î;*B_|ÅTÁïBàı Ÿ!∞÷˛\'˜o\nÎQ”nù4Weõ.ﬂeŸ˚˛>u…ë±ŒyÉ√Vcù…˝“@à4g—ì7íºˆG>ÖÅ\\ìÛJπ‹÷ZlÆÃ2¸∞∆4ÅUæùßQ\r1#_f∫≠º¢¢∞H¶˚í*I—dløü4ëãéıﬁH}AC{“Hh/˘}s˘fﬁ—Y√·à£4£%ﬁC]Óƒq@≤‡®Ùm7kÍDËÒ˚ù•ñùWØ‹*_4±∂]ØÙé]@w:¸yŸ∫X)%«Ä[bõtbs≠m/›94ª%_^^Â[æÏ£2∂…ù‚˚¬iØ”s.∑«™ç-á4ÀÅYﬁ2ıÈÀΩ5MåÄf’ûv2,À.º‡á∂\\~Ü˝®4“ƒ\Zr}√Má»cPœ\\√Gœ¢l8‘Ê¢ÔE˝•58ìÿ“u_#ÙgxôªÅT·å∑‡7‹Ú˙#’lı´ rù5ΩcÌƒ[ó/8‡¡Ì>Ù8g1Z‡ná‡ÛB»•gÅx5Iw˝N“¸eÛøz˝’æEÆs- M$£Ëg$˙é5#_ª˜Dÿû;}6]˛Å&É”˛]Ã∂é¸&âigÊ>W5$;ò´/ø Åm—k´Ìÿz ó≥ô†ìpÉ˛A5*¬®¡PƒŸo;Ë,´Ü£X»ãËy÷E[~â–√5B `Ì˙≠øæD⁄◊í«Sx|4¯q|“≠^íÌ]Ö5Y›Y+˛ÿW˝Ôó4Úπû~˚:j£/:ŒŸë,¶äñj5oÄÉäxÿﬂ˘à“~Ï,”“ \ZÂ±F<îáH5ãÕ±∞hö◊ÁÙYÛëIÀ&€BïÎiUI≠?ƒ“ë5ñp7í”3ü˝µ∆Ëa®a)®I”ˆõ‚·„>/Ω@5ô	ÆXxt≈B\ZÊ∆}O•û≤„á˚Lü†=\rÛ6∑µI5§∑<‚£‹8SIúÛR\rAŸsÎÔ§∆sf[HúD£35Óf`dP&¯r:„]˚Ç¸’⁄Ô∞ªΩ”èzÿÛW#[ƒ5Û`ú©ﬂHè∫Íï¿ê⁄Áæ‹¯°÷∫>—R5¡EOI5˝éÙ$lB]f˘E8f,}pQ∂¨Ôø◊qtBZá1O˚6,:}u4!Z{–äöùÏÚw1≥&‰v1∆Ø?⁄N@Ÿ’6=†¥G!J|GlúøÔ•Ã£∂8(ÍxHÔ,ÂQ66GÒ\rÈkH:í\r,6ú°Y’ßjÄhΩ=Qí$rF˜óa6X˛W“€\r2Ya\nó€N‡ÉÇD;3ø>°?ˇ)?V÷6k>◊∫£›	Q⁄Í⁄—Ha[◊ëÈ]{∞9∑¿ŸFº¢6t™Y~\'IÖY+6Ôçı5}íjê≤gÿÒÅŒhÆy”:6ÉùR‡√PJ√í2]bÓD\rµ\0JÛ√nÚRií–„ÊZË6ä}üë‡ÒÂ¶Âo\ZÉSuøÏSßı4ÃÄn\rh˛6äΩ\\“Ê•ÖTbÒ{)p2°u,Æº÷Ö…•£!wlò÷bó6ú]—pÂt=VÀŸ˝Ô»Xà⁄¶ı·≠Úø‚fYçùÎ6…ïIï“£çMk’aê_˘ÎﬂG’#È1œ‡≤—m6ÍÚ¥Œœ’º|d5l¬ºg4Ñ0Ê\'üB`V„ééá6\\’\nt√ù\0Ä`6Õã&)™·n‚óƒek\"S¸∏h7ŸISÿXäÛÓei∏NÿÓënò&ÀÂΩπ≥˛dúay—7\nä@3Ál,ÌUlÇƒL‘∞XfRuD÷YRsÌˆmÇ7ÁM™IÓæä.ÁúÙ⁄Òõ-*ìú\rù∆ëÊ7»ßíÂ\\È›±—î@èÕ∞b¸÷d‡xÏ?Ö°Í7ëó)J2∑,\"ˇ\Z≈V#æµbÇ®’{∞Œ7Äı¡Æ\Z©„∆¿>©Q„©;£~o˚‡gYFΩ7]UPÆˇ*2©à†ê“™é#bÚÇÀV ®ïŒE‹Xj7bé1úÄß8ﬂ!¥€U=Ö¢…Ämöçæ®÷{YQá7m´õø0Á ‰û§ñ3≈£õK7ñ˘Ú\nFg0Ìåb›ïW 7núvéÊhÕñÿX˝d∏\"ÉÙÈÕâJËåèÒ⁄à7qp¿.—}îa†\r¿`ç7—nööísÒB‹˙å}@”Öv7|\n6∫3´¸¿´“6ø#è6—Iﬁ◊Ê?ç¥»‡ ò7}·Õ…ŸÛ>´≥ûº≤Ê`ıJ+iV≠Ú]£À6æ™7ôŸÇÆ∑Ú\ZEö¨.E{(ÀYç—“Khd`zåk∂7ºIò÷c˜HÉÏ<=˛¸=\"Û¯F)\0Õ[!X‚\\Ê7Â≠¸#q≠$âˆêTÁT)Foe\'&?çPrj%o7˚@lD›ÈﬁÏI§R*ù)UÜ“µëó•ËR‰∂&\0e£®7˚|Ï&,S…Wƒ¶l~ä∞°†e|Tæ5ãóñÇèoﬁﬂ8\0™xq˚± ˘ã™rgk*\"@TCRZ=Úfíë§8K*}\"}uæa•⁄©ﬂÓ˛’ﬂ»Ô}õ#V^°Õ‰}^g8K«ñ⁄¥\"-?¬?,[ã¿{/¥Ou|E’ÊpÛ‚ã8`—∞ƒMãU8?òÇi$ﬂÓ≈ÎÓõ\"≥OÑ{ùò¬8o0çÍÀ;Ï‡ßóú∑PjÒÎë™9I(ñ›‘hm~ˇüœ8~/èÛ∞SıÔ•˘#WUD~c9u©uT—v8ux:ß°¥+H\Z’+§Í2ƒÔOö)⁄ΩºBÒµx8⁄ì1üã≠b;ç˜¸0eR⁄ ÒjÏuU`ﬂ`†is¬92g¢‡¬Ê≠Ï∆–˝¡˛K:˚ra‹W;\'”éﬁÃﬁ19fG3ÛCÎsw[<›ÿh«˚\\√äæ∞;;OA(Ks∞9>|Äﬂèûıy…Æ¸éˆ°,än∏≥añS≠›>\\S9I™‹<RÓaß~“T™e8JG,dËÚÃ[ÖJs29P6íATa~R,~F\r÷â´+Ãoá)¢•\Za0Íp9P≈†`8_ÊK#ı£ÓÁ,÷lS≥Vd*6T3-`~9T-§¢H»èû :9Ö¶•ò1‹Sª\\\rb?FC©”‰Ω9Wmà∫\Z X†ó®∑Q?uM\0GuÃÎã7íç…nOé•9eÌ9ëDı˙g2[Oeâ•—˘ƒ”-ÔÑºîDqTÜnoK-9f`EwoÑúºﬂ{ıö)Q1W¶ï<ôÿÃ∂…ã9pím√‘RzÆ÷m¿òAq*çË”ZÉ3ÙééV∑\nü-9y‘Ü&/AXãHÚi{bª”˜Ü7fë•˝rwí—„=m9ä1ªƒY±z=&Ü3ñã.T∞‘ˆ Q‚A[$Ö…§îZq9ô7äTÒµôË€≈BÏRúÃ#[\rO:ÑK)˜ü≈X˝9ú5ç∆V]á*¶sÍàªµjÚq7´ıÀ®°»3Ï“9√¶‚¿%‡!©∫bdV@ŒO G‘aM€√„æ®\nµ{d9Œn•ë€~ÇA†ÉbŸHcÜÂx;ãÂBùÆÆo>1<9ﬁJú|UA6@ä)Y∫“>$U≈Ÿö‚Èß•6b\"9·Û~%qˆ•2^J≤ÒD3]Z√Õ¿˚4qÙÉTıêÎ9Ú≤ƒ∆∑]ê6§z*6uÑjLÒ\0É<)æ+ÓÙ\0Â9˜´Ÿ‘$2©„!Ë∫èÖÃu≤ìƒ€ÈŒô)Ö\0–Øª9˛‡ûçqBYaŸásd§y˛P√π(πClü;]´∏%…:ZÇ?SjM•aå\0˘yJÜc/∏E¯#Œ8–Ë†s:\nÂ1—.¢√’Vƒ\\…¡«dÜS=ú\"E,vv0≤|ì:$Ä˜ùU“y\Z\n*‚+ñÈˇ≈æ+cy™53â3eÍ3:i\"R\"w`úõÃR—IÒúÑXﬁLëÕñöÃ7€âÜY∂:k6ÁZJô£Wj?ÀvÎAâ∂à^aüÄ-YÍEÁœ8.,%:kº\n<(Q« ¶-g®‹vv]Ëö¢·‘i≥˝»eèUóN:ã€≈OÒå™3÷õKÕiDÈâõòÇÈ-Ç-Ã*Ø3K/:†°àj\'≤}í!û†Ñ}DD∑%XÔ◊·6‚D:°\'∫¢∏é\Z›?ÁDﬂÊ-Sp\'LÌo›\"u§Ö‰`pœ:¨èõŸy8Öñ{#Õ’øÖmÁ˙ˆ÷6mz¯6Y(9:¥∂ˇ›¡â mËˇ˜e0i7YÄß,<Yﬁà-|Ä¡ûΩ:Ã˜»dé— ˇeUÄÍÔ&®\0†÷WÂ≈C}>a4ß»:œ_Éllﬂ|SÍ\nv∆\"õ2¥†‹’Á¬¡$ØëØr):œi=£\ZY‰euÕÛ¬)”™mÎÉ≠}∏⁄s?˘§:ˇ\n[≥ví…g%Gp‰a?>üà—mì_k¡Ñˇ5:ˇU•#π?áôê_jLß2S2‘ˆΩ¸âÒ„U∑™£H^;R¿âÓçœ^∫y]ÎÚ∏‰%a3_)Œ;te‚ÈÆ;J™E≈]Nîÿj¬ùÃ.áÃÊ1•*EñóâÌgWMÑÇ;WÕ≠ˇ†™±%H)wö<~–D|ü7Vè»<Ã»J‹;d˜†ﬂ©Ñ,Z≠zÒ^uñ¶X—ò8à}∂˜l$£Y;gΩé¡lS…π¡\0G,i8M¬åÇ\0Á˝π©ÒÛú;rÔÒö‚„tÔ˝«„h°öÔ≠ÿíåVg(ÅegŸ1AâH‚;zæóm p˙Km\0\']s\Z¯)≥MR!\\£U<˝ËøÌ;ä\r\0oso˛ôB>√î]Õÿ˜‚ucì∫Ú†r’¢Tã;ê√\Zm}ßgœÂÍÍ˘OÜ_tƒ%n°»Ö€ØáwÆ?;°Ë0ıNUî-˚\n∞»ƒ˚Ú$Œ°æúÎJ‰„åÅ;™∑—á·Që†ßπ®ZÕ[ÍïÉ™Ì∆€h^2u£*;ª7’DñnR—W›N4@ìÅ¥J˛s¡`÷I∫ˆ®‰;»P«˛Œ÷∫Óàv}M•Z÷µ&ïVΩπ’ <JS;œüµõßj\\ÿ˘%zôvöÚ©îÉè}dÛˇ83e™_;Í@Ôä_ñM -Á‡’Öâ«Ô˜›,(gäB‡ﬁCÃ\'4/;Îê]A(Ç1åÁÉx&¢‰öÃÆ^ªÿl_‹k8c<çF≈‡†¥\0D…;PwùóQ∏ú–t¯÷s›œÅØ<∑5úÍ©∫‰ıΩ’∫àç∑vÄÄÀÒ\"»ò⁄™úÂ¬<ÈØ:ÅG⁄ﬂ&D]‘É´ÕE3 	uÊ›úﬂtüû≥< `2!l~Ús¯ëÚ™DU¨=ô§§⁄œTöR˝Âú@I<!{]ÀùwfõÔÙ§ü÷∞Ñz=~ÓS˛ÙA>nJÍ<\'†Ûé<‡±\'[OeÄ˜˘0’ê„ ¸u‹!ÙX	ãg<7ËÖS dTÔ	{~–”}&(94ÕYó_¢S#+TÀ\Z∂<?ni6~íéœä\0ÄÈ’z˘£õ˚ﬁÓ”≠Dzm\'={?63T<mÜ2ÄÅ¡ËıÂÅ[»ÙgäÙÿCÉ|ü‹0ô¥¯⁄å<qÕ#;ï&Ñp6fƒÇ^Ωæ¯Ø8ù+‘:˜¨È°‚—HÒ<x:»wÏ©‚ÛÓÉLdÏdŒ|G%NÜÈ=©s©<õ\0Õê††—…$⁄±”5≈µã«ô![ïƒGê7]5+<®íH.<˚1zÅÙff:©/|÷5°Fü\"©<^ı˜}˙›<™ˇ„˛∞P,vuS√·k»÷5¯3löêD TZÁ~O<∏.xnEe◊ø™j?\'o2ïÜú“\Zh<í:-Rr{<‘´˙!q¿úÚä’2{èüˆªQ:úŒÖπÄ•2UÜ?=A@5Å”æ¡≤Õæ\"Õv…kkaœõa‚µ¥.kÚgÁÊE=%xß,«\'}î<Ï*Èp∏ˆ„uXÑp–sÏ˝àHÅ#r=Mb˛gû`<¡CÛò¡ÚX6°˚˙ÿ.4x¬ßÃ{=Q»s˜f–¯#Õìî1\"C®ñ+3bÓì5•|<P‡C=]ÛÛ˘m∑\'¬O® P´0;&x\"Œ¶ïöÉ√⁄e”=ö„ÛÍ⁄π¶˝»Ù\\Î0‰$÷Ï‰”[æ#¸b=üØÌ±$ÎƒH”3ï‘f4ÒDÂ¸±°V≠rj—!?ˆ—=Œ¯ó¨.	€ïç &‘IgCq†[OŸÿSÑ=—dtz\\‡IgNÏ\n¥d%≠?8≠≥Æe%`s2˚ÙI>\Z‘◊€]∆öñBÃèXvíÿ∞cØöÒπ”.N2¬N“π–Ø>\"8≤˘‚π*S@-ÇˆbH∞à€\"Àaiä∫õûExã>\"eY◊-¶:0®∞˝∆37ù˘û˛,j¿≥ç›O‚¨>rf∆	/¶l˘Ÿ∏$\ny+b+0ZH™0wbÍV«ùùè>á@ZãHÉ”ê«ìíß∫9†ü)üWÓè|Ñ9Í§^~†>ë	tNÌ}ø˙%Â¬€«ÌÛØÕ⁄‚ò7‚ µ¬6…>óµã∏ï∫∞+1¸ò°XπêsÃÈ≤VçÓ◊TCÃÊ¨>–é§∫<Ë©gÕ\\^_∑•˘Ω9üK˝Âˆ•:>“µPÌTœªÅ˚ü±ß7rÔ`ì¸àK¬˘Àí#ûF>◊EoGá¨¯0W^ì™⁄≠>&iÆnˆ\0ΩÜ˙ŒÛY9>‡xﬂ»f?)√œSÅ˚ãvRKáZπõ¯âÑnΩÒR>Ó‘π£Ó„ÀÓWﬂ^;ûÔﬁË·‚a*q‚oˇ·ic˝Ω≥>ˇ∏G„∫Ê+õGâY/ÑC≠Íïª‹Ä6€r…&∂ª†?O>u…z∑/Aı«ö	n5E-˘ëIÑ∆GUhﬂ≥?	]ÑM.ä¶nä∏‰±b4sﬁ¡TÙ+œHà¶?⁄ü>!©dÔŸ˘‚¿E_5Ï;$~$®ÑßÒ&∆†\rµ?)„ò äÂwY”xÜmN#¢\"( 0wi˙IŸπ2¿Òi?!a0?+m£!©ZåºΩuC®<:∞”—Õ˛Õ‰>ÌGq˜?\'¨–Ä|8ßi«{_–z_)-©2Æ=wmoΩw‹–°?,gußèV‡¢…¬î-UbÎ‚‘ƒ<eA—«©KN°˛?3Õ≥¶í†•ä¥”ÛD[ÁqJïá≈éÇïg*h§Y?5Kœ∂ÆÒjB *D∫π‹‰P•˙?4ûÒ^áîº?>∫–e©ç—‡˛Òºùc∫˝2uçìØ’Ûuûˆˆ–?H\'ÕS¸D>Ì<56©Ãß5c·®#_{8˘âcf?Q®O∏…xôRî\"ÌÃ&¿®Z-≤C¢ù¶Ì∏j\r?_±ﬁ6bŸ%ü£∂„ªßõ´Ë÷™K’Á«ØxLû¿bÕü?†ì˙ó™h]û0\0⁄	B¢¶ô…Çà‡L°†J÷ø?”œ\r€¥‡<óËŸ„Î~˜≤üÎS◊1.ØﬁQ±Eæm?ÎıYÍù§≤∏;‹Æ¬·S{Bv∫,Jî{9ö±?ıâW^Àz\0∏”Y*`\\¡P∑+í…-Zúæê∆ ™lo?ˆèõE4Û@Ê+ú>∏¢Ç≤~£_te¯Œ˝v\nh≥@Æ$Ü˛yZŒ§T±’+Ç∏IÈfØÿíc#p†C¯@vPÖ·ÕË‘oÍÂ4OÎuêù∫∏ˆ∫¶ìéY7j—§@s—\'îb ”N9E=–æ±›S—0§VâÃ{»K@àÎk˜ÑÙæ§æ‰X$Œ©PB	¥ÚÊ≤=P–S@*5≠]˝GøùãÄÙ≤›˚ºƒ÷Ä´‹3)A{óAÅq@:xçˇcùä√ÜPVèã‡Ôqtèä¥(Ñ◊*§À@CA∞RA≥5≥ØP¸}îßÛ%öbI^ΩC3∑Æ˙ˇ@Loò÷üÅGî≤◊jß_x0`Ê˝8CüÍ{œp@`@Z=πûsXÓ/ÿ$XvÛ\0∏ˇ∂uêy≥8=7úÜÏ@^<€¨\'=‚f©ın+¡~Ω‰wÇç;Úù¸ô\0Æ“@`±7∞ÖZ«õ˘bvP©âı2¯tÔ@hl»q∏ﬁ“Ä@qbÆju™èO ´;ÖxÖŸÌ¨Ê\Z{%y	Ã*Ñõ]@v≥Kﬁ®kÍ√%~Ü|Å`ºÿ`Ñ<5PÎ€ÌäÍ.@|I™N¿AΩÂYÆò:_I‚°§Œ¸a±*Ñè)ıg¬F@â~ﬁbRÖÈèí§ÏZ‹^®∆gπ£ı4út\\E[]Œx.∏@êl◊l¸4“Ùw¿2ø≥l™Œq¶Œ3P±‰‡\"üÒæ@ûïF3™øÚ\\;ÙeÂà0€Åö ÎNÕQPè£©\Z@´;ÑÆ EÌ†ÓxSß\r÷=ŒK¶A-Îıpû◊y@µ@…¶°† =ÙKwÄŸ∏\rk¶)\\Xs ëï]⁄ ‹à@ºQ4ƒ¶P¢ÒÓ™±¿lπèNÿåœÔF!¬€Kª≥¢ÂëA$ﬂ0©j∫g\0…3dhfGT›ÌG¸)Ã∑≥!A92–!Z9ú˝^v*π\0D8\Z=QµyÇÙ\ZAbÙAv°{/G™gˆ^6∆~F‘\nƒñ√ﬁSA	ìΩÇªAÄºËÆ5ﬁƒ˘NˆkÖj(W‹{l¸»¬9éXIk.Q\"#AÜ≤´ùíâc°º7ÄÓ6ﬂQN^Ú\"B‘z¥ÔÕçÅNAç´ù2,ô0F\rv<†qbö9◊&«∞Ós€&¡/„Aó¥©ÑZ%‰Ü6P„√ôHÁó˚Æ[h\n@Ô <¶ºA†/˙ıe» £PÍö3¡sE‰Çbz·ÃÔ%xKƒ#TÙ´A¿jä⁄±ˇ]ΩUÊ˙f›89bïyFvw1æÑÃ$àeÙA≈N~ö˙ÙmDD*ÿW é\n¥e©\Z◊ˆ^øDhuﬂ]A”@z¢$zY‚œ≠umŸpÅπ‹îı^∂£6¬/£bﬁA’Ç°‘8OÊ–≤‰ÄÌºéúOzúªy≈K\ZtÆ\\A’‹Ó™ãiﬂ§^ÒœÙ€fﬂWÕä√üv∫¢#ü\Zg¨aA‹ÌÎïŸÂ„è)˙6œ.k#’a\rU∏à≤Aﬁe[	é∫ävÃõ3¯æØkÁg\n\"Ö•πÆÔ‡›åËAÏ∞txâ</Y‚˘∆D€Œ·ñ:=—Ûo´ õò	uÖAˇ˝ R<K…Â!tÔD∂J·˝N˚Ω]F!∆ö|\rjB\0àû7rÔî\nñ75ö¨É≥HüœÑK~ã+Ç‹DBoáBñ˘5∏}\r}dT†˝‰/¥–®Ó»êÿé¿È,BBI\\c±cx|ü¶≥c\rÏîwHN,4àﬂ?ÿ“Bå!!ÙΩ‰$˙„Ç±÷Ñ!∂˜V[éÆ–˚¢]«êÀÚQ\'B&à≈JˇçP:oÜ§˚l G|Pƒ:q’_pä!Œ~§B*ú/z‚Èn¶‰Î-èãT˝fY£¬ƒzO|ÖEÏVˆBçﬁF$bﬂÈ≤¯‘$.Ö-zFneÉM‘*/ÑËöÁ¢Î|BïV’≈˛ç\n,∞∂ƒÓæ£O{∆Çê9ı“¢ô∞˝Û,ÛñBüMZ‹ˇrDûgKŸ˜Zîy≥{∂!»d˜Õƒ¸–VB <û=†P\'\r≥Øäl›˚5hhH@ÒCp3œ2…≠vCcB÷Rªƒ*8≈ò°”ÔTÂêˆ/]s∑.9T(»Íø‘B€•D~«ñ‹¨ﬂB>\\_EîàqÄ…“ÁlÿOxy\na≈B‹\nÁô®ƒ°?}Vx¢ºqA€–Ωaò≥Iç’wA\'6B„¢IòËqÉö0˙q\Zœ* ™ÈZ>√«%Cÿ!lC6mÂ©Ëèõ•Ì◊ml… ˝ıëù∆⁄2á}$\\A/C>0Ì⁄,cÔ‹œJ¡vùyò»Ïöì(T›ÑÁûIïCN6Ô‘Z:ôczÁ15Í˘¡(EsÎ{(í˘M◊ΩCj·••-´DX\rHKˇÆÑ´Î’qæM `oªíàCn‚Ucú]¸¿Ø ¸LÍ·ò]ƒ¢6Ω¿C1r˛CtëÖπ[ñ”P9oé&—ñ∑cv—C«°‚çÇbô≤;Cá]ÉÛ…UΩ:3µ<…¯v=\rà\\äÂG„)∏ÕCâ‚vπm9ù)¡∂ì€ÊwÃlÁ‹NÅd¸?π>o¨CóÂ4)÷¯ííìΩÇi«åé<1œu‘–é∏œ\"CúOÇ5áXî˛Wœ	√ŒN˘Ó¢·JîΩÕ6˚ÂC´]Û◊™.7Ìà⁄fbÌ π¶öo—	$ªL·ôÕÊpDCµÌ¯3®(`°Ëe#•èΩbˆ3’è~;o¨á“¬4TC“˜åjöU#HLæ\\Y%˙˝\"Å‹rSÏ{®ıt— ™C‹Ω=#\\â4C¯.˚f‘‰>)!„ﬂ \"÷g€kC›y‘ä√JDo†Hºy˛Í∏$ı—‹+Ò|∞CÍO∏W%ìÆ§tﬂèﬁY◊|¬’&ã0ùV¬å–\\ÃCÙ9ñ~Æáf~&ÍíÚ%{	7Ò»°[ø{aOyÌ›Dg9ã’•ù‘+ã†õΩ«wËw\'ﬁﬂYJƒE’D2Pçwr8’Ió˛eWí}˛ù)äsﬂn—‡∞ˆ≥\0˛ˇD?ñj^*æŒ•{2π	W¿c|ß ˇ]ã‘yç¸tDCÖà\\N\ZK`aıóo®°Ï2ıL∑JƒSw5:LªTDHoB‰T\"ó¡™/πT[ÇháN;„÷*çw¥o¥©^¥∞ÆDLSg—Õgæ›®ª‹?†ÁåëÅÂÕœû´Y1—õ hDWË•˙n“L∞4…+§Xí´_ä;≠¶Çá≈•¬êDk‰ 5ˆ2¯Ò÷¸“o›‚ÔÙÖ´Ë‰á+•◊§I0¶Dp\"äbõP÷mENÅ˜}^Øπ≥[‹˙⁄:®q˛fæ§DÄ©i\"Ò¡˜¢«û˙t€±åR@Ö8π⁄∂ ÒuvuDÇT◊Eô)$GÚ etÊsÃÆEŸπ¨™\n≠¢Ê„Dèﬂ\"äKÍñåTÑú•+qrÀ9†ö¸çtJ£v!!D£%}≥IÉ⁄Ómã„F2Ô=ê(à\'+•‰AíëX”Dßò˘\"eœ9ãV÷˝Iïïmâ425C⁄¨AÛPΩ%_D¥∆é≠6∆πS¥x‰´hjÔ∞åG≠]iœ“i∞ëÃ_D∂Uº;F=£πÅËΩd¶¯ZüK/Ï≥h-$ª›ÁX#D«‰\0wëÏƒVóÏvRwoâñ´âÔ◊~ËMR˘DﬁT’X6ï_8T&\ZUc\Z~Æ¿ú@™ÅQí¬ﬂ”3gÛTDÍz˝\nr∆≈“÷‰#o8∂ê≠]‘qÒÀ©8gø⁄wñ‘D˘\nDKbuÁ4iQ\'í:È©-!Íö:	Ø˙2ŒWi\\›D˘ú¶Nπô-I0ñˇÃ0?á4‡zf¡Ä<·HnÌE\rŸ◊¢ 4¶/§X!¡3˘Ë¨~\0ü∂“È]üE(ƒÁ⁄è¿¬K\"¬y§å˘69=aﬁ1cçì3¯˙0òmE*»Òh5|y;f\r±k¿Äè‘aáÌì§~NÀrE0¿8÷µLÛ´ê˝}qe%èv∑B¿|:±h¶wÜE7∑3~„°Kµ\02≥àÚ”7r\"U™%º-Ú_:≤E:˙ôkfËdútps*H@Îú+êI 35_\Zrå3¥EG-=¿äè•|ËÜ6W î+xA0ıÜIcq_ñ+EJ˙VU˜2b7jMy¢8]◊nF}∞ﬁZá≤?4ÌÍÀE`É¡f;øùuÌ≥\'wI˜$é0Vûo0H3˚ˆ]E}¢°úZn’ç.GÑ∏ñ{$ãX’Í∫(jyqÍ£o=EíÅ™áÓ6‹x7‡îõÂn÷˜oj†a∏˙h.πeéÎ5ΩEö†ı\'ﬁ%Xmö-ˇQªsÿ˚·ƒäKeb´¯b©XpbE®-8\nëuá⁄T/¿¬ßŒŒèi‚øx‰˙r&§ Ê3E®QÈ∂Œ÷d§ß8íL‹Æ≈π@Ò¸™†Ï#]sÔ≠E–àõƒ¯\ZÎTîï›õØü˝§◊µÑÀ$ÅÁÈ;±QEÈ!∂!âæÕ•¸âÉ)r;€n6ÍÆEkÍS1˛$`^FÅ Õ•Z©Z(5JC©¬Â˚°k˘®\"¸´ÛÛ|dwqF«æö\'∫T%cÎ*|k¢®ë»ÉΩ””u\Z≤ôN±ÙÁMF¥kfS»GK#:»¿∑≥›ím∏SkÅ‹¬≈%ÎF≠hÎﬁô¯∫Ô´HmŒëkô»‹≤=Ê¢ØôçF˜wïÿ≥Y¿„=Áıú!ÓBù¥\rÿJú≈9¥èF!	˙Pôˆ\r\'Ûwìù∏:(îQ\ní=jlıËhj∂¨F+\"∫£‡˘2|+ˆFUö√äÿ;Y∂I·çî}f}|FCˆA—˝>ù=≤öÛh1≠XJWDXò4‘\"ä=TXFOó°ˇV3\"¯™ıúÔ‘º£™!k–PÚFVõ—ó±aË6y±p\'Ó3Æ•]µ\'Ü¥Ó”˛,F}&w=4quÆ\Z¨€˘≠çX?∑F{˚©W•B!ΩFßØäè{KÿP:ÜiÚ™gF¥\\ˆ‹Z	(\0GpF®˚¯∏…˛ûyΩΩÄ≈˝ôﬂÈÌ‚3n˙≈‡Û”#‹;F©ßÙ¿R¥<`ø=#i‚∂zùAg≥Dd)Ã¿ãqFº€zŒg≠Ÿsf˝7òBª˜πX≤ÒÅ–∑Iw±EÒ…F„òtˆ¢«£v˚÷\Z•:Î;Ñ˛`÷jµ †‘B°GÇõ^–óŒ±ÒîõtGπe¯ÂöÕ)◊ŸÌ≤˙\\GΩnéì®UØÛ>)_\Z1ødÜ/⁄ù≈2Å°í“>\Z⁄JG\'AQhÓMÕ‘VÌß∂vâS(ùòGèº¨l^~@y›GB«TïÇgá◊{ñy√à∑™¢ÜCáîñŸŒŸIÈ“ÇŸGBÏ‡“#î(ˆ>î∑á+:À·˘‘æ\Z˛‰h˛ﬁ/TÇGI}Øâ?\Z‹)[>\"nÂ`∫Œ˜ŸCÅí—Â†cf„îG]ÄÀΩ{0nŸë)mÊwhnÌ∏m≠´TCÒŒ&ÅG^òPˇ[ÚŸ÷∞a+À‰Çìﬁˆ›àmógœ ¢?˜Gsq\"°˜qkï∂,ùŸ&u{n∫äi>ü®·m”Gs}Í£©≤•~V/	›≠ÊŸ§[ˆÎÌ:ÒYç£◊\\Gt_!ÛßHXÕ˚≠´–´wcØqœÏe‰˙˛6≈>ÓTÅkG~x%ÌçæÉÀ≥Ò‚Û>)ûµçæd(≈\ZBNJ!GÖÎ+ß⁄8ìv≥ÕÆ1g*=^5éV¯ÙèøÈÄÖ∑\n»\'Gä@áP»É√Uà! 9Ô1XYMì…ˇQeà \0◊ç`∆Gç¥?}Áo>»«UŒåˇ5ÆO*q˙&+vÇ3\ZRmh@Gëôgr8…,ÔBÃﬁc]uç_∑a\rÃä≤– ;ò~ÀGΩ¶W\r\Zá‰G$È7iD>…bã§·^œÆ»Ô4ˆGƒ≥ÀóªYqUÈÑ¶¥®¥l‚\"	Ï»,]‚˚fßC\"sG∆ˆ\'îΩY°æΩ7ÀˇÈ5TπjÁd5:¬ÄìŸX}{¸GÿH{≤pï<ZºﬂtM®áh`·K–ƒ«ALñø≈G±¶çücÎ»`B+91l%S¬;‡8B!∂÷∫∆G˜ÿÌ:ó≥}Ú´õÁ§Ô\\Ø\rù¨èÀ˜#}g‡¡¿ÛuÎHÛAf∫%÷≥1h∞*#ÎÎ\Z∑UEUhéç>B=ráHp\r≥\0V‹QŒ]µπ%<ã†Ÿˇ	–&si\Z≠[ïHÖﬂHe˘QŒŒe	=:¨Ê2sO≈8◊OıΩr»ú≈ñ“H,œoã˝∏1Ù@O>†„çïÕR{ı∆‚í5k©eïÀƒH69ÏÛó√ü¿$Kù≤Ø&˙Ûâk≥≠⁄·—ïë\0y}H9mÈP»•ﬂ\"¶TÄûä∂À˘∆’©˛÷/5 {!ﬂ#œ˚^HB¡ü˙ò]=|\r”UJ¬¢ —ËI±¡â®≠w÷jù ~HNœ>ŸŸ+fˆ„ÚVQ—âû2ßûÂΩÁÀ^Õ–HYÉòfAp≤0]˝ôOc¬ãóB ß/¢Ô°±$ëg:H`kfNñ∞LÙ‰ıh◊`˚àoÌË[agvEHa«˜î˜“¿YB¶3ùGDÜ´€äÏıY∏|ÂÂ_‚]¿H{√8;sPÇ%;£që–9\\ö◊}ÛIÄìWó™HôŸ§ê]√™˘\0ÿÎï{/|ù» ˆodlÄJ/1±H•Å©QÔÉë®0zÌ/¿t”$∆È⁄Å»7»)ÊÃIHØà ¿ˇ{ˇ‰\"!b(¬ÔÎArıÏD¥]Ï…ﬂR;ï≠H∑„ÀJ·≤ü¢√†` ®˜ÚÖ˚tØHV¨{Hø∂Ëπ5±\"wqnG8 xC∑àZö(éÓ˜´\07ˇ¢Hƒ∆é˘ó›À+@µIÎ∑‹báö^=∂QvM6_iLH‰3ñ:Bk[e<KRÉT6Î¨uLÅ¡ˆëbÄéhŒÒ˘ÀIá•≠10ó%ÛV`ﬁÆf¨a˙ˆ¶≤8~(◊ıßãùI;BäÙªS•Ûª©‚G¨lø∫îDâkŸl,\0âÂ‰)IGQp∏úÕ5uΩÚå\0c¿{¬}≠ÁAÏ¬>IN“‰ÆˇEôÁØèjã4ìG\Z\Z}îÆ´CøJ≈CæIZæì4πˇ‹÷ª{“ó◊7taŸx–íH≠1ñ¢∆÷IyÒœ\r|≠q™õñSA˝*Ü	Áƒ}Hø‡P¡îÊIâ|·ôµ0«›·æ7a“nπç“êe;è\\UÙú˜⁄I£>ŸΩ‚Ô^iliAÆ$UM¬ô>ú∏™l®)£π$iI§¿g-ø””Æ∂P?{ﬁu‚ORÏRr%ãÎì~ﬁ–IÆ‘?äæ‘RÒ`#•‡C\'\'\"∑Æ”\\j\0aR≤_ÓÙIŒËP’$–K—~·¢P¨´mhf‚Ò l<!,%ﬁf‰˙Iœ3d7∞Z4êäUÿÆ!V“R¸ô\"∆ﬂÜKoúd(‚≤I¯BæqM 5{s6 liÊY–,û…¶d”√Ÿe√\reUI˚‹?´5jπÕn7‡êø+#Ik•ƒS¶⁄ÔõcâàI˛z˜V°%æN“)Ω°⁄S \\ç≤≤n´$-/Aà@‹`JR2ÔõŒÓÒ_πs{\n/˙vgLiÚúõ:%ê°ÏJà¶ßúe©N2\0ÌY •Øby®_∑Báö‘˝ÈQÒJ(|\"äDÁ÷w@Œ¢ñòwÓÔß;`ÆS˛†°E·\'…]J0^iÊNô’È§∏Æy≈LÈ¬mØøæ¯Îs{à·(J;?[(”Ê*Q˝Ç{•84·Ö∂Af˘U±˘˝Üˇ5f;®JWÛÊ‹e¸j˘†ØJA®£ÀU]1Çé^s?èZÇ∆\0JX#j’¿«wˆ‘”öY˚˘ÊUZ+Úıv‰†*+åÓ∑J]≤∆†<SMvidzÑÂ´◊˝>Äç‡¶Ö&<dìòCJj∞;˛÷„Kû„;sº\\¢ï2«~Ä⁄ã4ΩJ~√ƒ=°;ÎÖû¸î#ñ†·	\"K\ZE+áÌΩ∆13∞òJâ3êıAZ[áß;â`ìõ¥ü≥ æÉ3À¶ƒoü◊Jì4«+`b	Ôà—\0èYüëyÿ¨6WqD√ÖJö ÑÀ√V°sfô^∑î≥•Ã™Ù¸ùÁÛ0G\\äìJ®ä¨YôéF ¡†>%ïPMFÍ?†i∫OóÍJ¨â	p5vÖ„îÑvΩıﬁÙ¥8äâúÉÄ( ∞≠¡ÔJ∑bjbÓâ4Djw*4ûæ‘È±ãp˜-:Vx@Ûü~Jºï˜N¨@ó`Ÿ®˝πP)@-8Y∞XèÏ-çÿ—J–6d¢„AóÀl{ù¡–ô\0∂üÅõÉﬂJÌØ˜ÓhJﬂè∆Å}0Ú¿À.‘‰˚pÉŒe	GŒ‹^ó~ïªQyJ„î$ßÒEÊæ!\ZÄÛ\"‘∆ÛwåON’–áé´^mJÏÌP∞’#d	TÎ®é=ÏÜv*Qfß¶tz\nìΩ±KI≥Â1Zƒ.†|ø≈=É3˜S0\rÅû˜8]Ñ+K3πùSŒ„xF∏Hn∂πZDaã›€≥‹wÔs)*xK;P»aszënZâ˙ãàó£*dWƒëÌ´jâ]rKPçáîF1)o—Ù47Ê‚ñ@VˇO‰ÁfU5ègÃÏKa;®◊æ$˘(UiÈÚ{i≠N)hi\'ÖÛ∂TÕåY01Kb°C\r ˆ¸∑it•ÍÖ£‹\rè?÷\Zä‰Ω·”6∑Ke´]Èo„¸Ô¢àâ?>ùÒMåë¢3ˆ<ØóÓÄXKxd]p¿ÏîüÏ6rÓÒÄ7qü˘7ênhª‡XJÅ!KÄ‘¥ÀëákÈHV€˝‡Ü◊AZ!⁄ö°êø”––˜\\ÔŒKÉçı;Ñπ.8^“&ƒ»\ZïÊt›%™n‚Úì|T∫·»Käíöht˜£êˆµÄ√¢¡¬™ñxö∫‰\0,\nyw ¬çKûzç≠Õº3c÷◊ﬁñ22é?CÙ∑†Æ∆@‰b_LK¢;ºztÂ¨uµÓë,1}Ω∑V\Z&!Ö¸5W´¸,(K≠kò$H≠”Ìt8°0ô%\Zªµ\'çë°Ä%é  	ujK≥OôˇEÆÍn€AFÚ>Æö£⁄íèd3¯í\Z_ª0D)\'K˚œ\na⁄Ñh)ƒà#ùÂ∑ÜB›PÂ°$˚;¶¿L$Q–ˆA\Zˇ3≠oT–÷üÒxÂp\\âCàôÒ–i≠5L&¸˝zæ¡äÑœ÷èõÕ≠+’	¬*&Xª•ˆ&R&ﬂeL>êÀÁÏS\0‘—}ﬂîø‚π\"≤.çjÙn»°z%ûa†|LE\'ì≤éóJÄnE˝@îªl—r!3ŒÜîè¬È∑Õv\rLLæ‘)<Ò∂’îò´¿jÔFˇúêWˇÍÏB0ñ#pm‘LOHTêcı¨˛K„6ÆÑÊ.Öe£;¯]¿AesÀøS†©FLS¿©†#VàoÄ8ki.£e\"k©ô´˚í£ﬂ¶“ÍÚpLq4ø…‰ëZì¥’µÜH\0≈e7f=ÍÁ™\rﬁ\nDC>OVLz7\ZU€ºx{êUW?EQ‰KÇ0‡Ü\Z˜ß˘`hl…Lê(pyp‹]…Û& 8Âø,\"6ªÕ$cM◊≥Z}uÚ≈L∞Y5õÊ{—LÓIl#6MÁXHÔxP!\'˛˙+Œm\"ÊÙL¥f6ò—Î=¶([—ÖÄ≈Ûï`ïı#7~µ(aL»ÍO<´e7ºj}Û;‹hØó&Kê–9Ù¯<ï ã®¬L…≈¡&}≥ÜPœÔ‹õÿ§ |b31‘Å“Œ≥LÃCÌï¥1%ÃP«≠VÓÁ©´q{§ï{r\"H§.´Q«LÃC®∞U¡…‰ÿhU;4Ên}Rm´§x;Ë®ƒå‹ﬂL”vQ4‘‰±¿xåÉô°¨ﬂA>áókrÌk-ß\0‡L‹:}¯å%,§‚É\\}£~8\\¬˛ªOaí†8 DsXãL‹®\\Hª¯=cŒ\ZÔè‚IÉpãbÄx∆n5•¿ºˇIL‰*~Œ†‡®Eâxæ§Æ I<•\'’ULhk_ãçÅfˇBLˆõÂ]E‘;Bñ/y/k]˝ÆrçØ\"õ˚< H$…ÁL˙ÌøØôòÚRH‚xﬂ˝sƒq”5]˛÷ÌM€f9M\nA\'J@c§VÎM|è)Æ™=˛¸5‚ªc[ÿŸˇô!M\0(•ˇ@çhF(¬®êo\ZB∞FúA\rôwï7ôñMÑ«¬±MﬁC“◊–-î˘î8çVÚ]\"Æ?Fùœ/–ªáMVãÄs•∫ıêhÏ…$ÙC⁄ùr+B∑wﬁ& u&k†Mk_!:∞√≥ìaâªãø#ì™À˛⁄¯\\	^1≥„M9≥9¡Ñ7´èŒV%l‹zâ[B6Ë\n‘qÇ ïÁ√ÃMY~qí∏_$¯19±wŸÂﬁ`åØ¡ÒÕ˛¶\ZÓ”M[ÿiˆø%M™·ADΩ.ÒØl.\ZnÕ ˝êp¥TãtÉMyL;è-ò⁄õ%I∂u\\êâK|ê,Ãû‚√fÌ˚] õMè;*jáÆh“\04\'◊u\r_ñ–`Ït\"˘OÕùñ˛4MòƒÆ¸.4jW[·‰a`Aè˘Å•˘>ú?6eX¡M¿´qº\0q›.àû2›æöA/^GÃŸ/Q˚ætr™úÍM”¨ÔP◊Ëñ=»çMÇ”>lwØÏ¿õ…óovÜ\0MÏÄ~–≈ÀY°ák¯@Lˇ\"#\"/;cÆÜvj~\0ÏdﬂMÚ¯Ùﬂœ∏\ZPã\\x“’Á\09âFÊ\'?’á∑˜Ì=ÅMˆSpÿ·}TÉ˜.!ˇ©˚$|NÍø\\µ∏≈◊ƒ¸ªYNƒ‚›ùEhﬁ∆Õﬁí\Z‚√›Ø§,P.g‹KNmˆ¢Üäglë)º¥•AìèÛ¢ΩÑà¡?ñá ¸NÇN‹egR»wSñnÅÕ\nç∂ØG˚ô–öëΩäê£ØqN9ÿì]`»T•ﬁ*LÊ)wÊÚ\0óÖ+¯ƒ√É-r]êÁÀNA;÷∑oïã„5ø9ãé0Ñ÷6«Ól˙√Ülyz£œNL2º§h⁄´F•$H[=N Rµû2\rQ$ﬂ{¸˘Ñ)NUñ–Ôö{ˆ∏áWÅÁkz\\∫mÇòôΩlf«ÎŒ#7N`?g®\Z”ÿÇûÀÄ∆Ëz±ÌrzÖe=◊s•‡%å>ÈNp.j™ÏÉ£f¥7F•,D≈∆€2Ÿ≠:ƒ§2≠+,•Nz‚Äó“°r¥π9;”Ù¥õ,=ƒËı‰óàdÜ¢GyN»©üxÉ=‚.ÅÂü€í∏G∏§ónÅ¯Œca(NÄ\"¬?ﬂ›X®—h…L˙Êf?e!#+øovéÃ`à–n∂N®◊:÷˚∆é∞Í>›%Á,7Ë	Ág‚é`eÈzö,N≠v≤–ÍﬁèÁLTgwRˆˆÄçñ\\ò–GÔh,ñ¥N¥Äá—e>h¶Ã@‹J|jÙŒl˜≈∑p>U∏–èNµjﬂ$»»-ÒGE)Äπà≥&J©«4—Gø‚ÍùùTN∫≈ké˚”≤ŸÿG\'É:ãØ±ò2]ø¸F√+îããﬁNÓYƒGDb˛i¬\\iRL<ÿ&\'?Õˇ¿„<∑˛≥U3XNˇß´WNlN4~òå J&†Ró\\xêdú◊ætR_È¢„ O©	Yˇ@≤9üPÆ∑-æ∏Ì¡≈À>˙5™ŒUw\n\'OÅR÷k‘g)∂eF√®∞¡ºlı,åõ⁄@ Ù´íOŸ®õ|·e]|mKø~ÈF®”ÇÀê;ãJ\"¥™§∫O(µÓ{\\Ø«®Uﬁ^D¡%˛ù!‰∂£™Ü°Xﬁ—XJO:XÖZ…%îÁßM;éóãã	;?Æô§’ólÊ%ºOCdo^û˘ºr≤ıïî?û”≤ûd∫˘ÙŒ8˙&VÆOGæﬁ£Y8+]⁄^w‚tÊ∫‘ÂX]›Øìs6QzOV÷Á¯/ü´Ω~Z“ <›)œr!h=õ˛XÕ4¥XOeIﬂVi\\q<∫:˚mÈ¥W≥DlKáÕÑﬁ⁄\'B–IÑOpbÂ6Â<Fœª´i÷∆‰≤ØHpÜ\08ï2æ˚£CÓù*OÑeÑ/ø<ëÏÍHƒ}	 JæÉ∂®tãÜJÇ˝3K√OÖÏ%zé∏≥æΩ˜wvú„W8XØF≠à]˙¡®lèUOêàg˚6r\r˛\nÙp¢çªHºÃêñ÷∑éó|ƒOîAR∞Ñ`qLÆ?Ø◊¨ÀO»3vÂv\0UowÀ\0KúΩOò≈Û‚q%s5z˚tÜÎg˘µíôUUˆÓÓ««i~~ÔOßW\ZÇ9ç≈a∏qù(îé:†3πﬁ+¢*+æõ£à“m;ÍO‰~xwUÅ.]†bfW’`≥hâöWÚÉ\\‹≠∏mP\nkH∫û‚6w#rè¸v{0Öı£=Ô´å\0„i.Pz∫Z®§˚©bÿoBLπ]∆Ó+n¨@$G„*üQ—htPÄ¸\nÑO#~Ìı#ïä¸ |ˆ‰éF:QÅ>›Ñ‰G√PkS˛ZÎz¥ÉΩñ0´Dì÷œ´°Iπ,1h∆·«]jP=¬ŸqŒ˙·òŒ\"\\&…4ƒÓ∂ÚoËìè0ö©iPBˇ1B ç8âaSﬂh@<Ì†^!õè©î|\n„ø‡PBôHü—<˛}ˇF√≈JÁõ‚àgÑ≠=rv◊ä˙˚qPD+À¢≥R∆Ü≈‹≈Éıƒ5Bh˛Xπ‚]lﬁWP_¿∫Mü4òµW˚M$\r]æê\nÅ¨÷˝]íî≥|∞¯a*Pk:ESØÔv\ZòL÷¡Ç≥a∂©ﬁﬁ\"i\0SO2s·ë=‰P~π€Âÿ§ëX7L∂G∂0©ª∞Ü QÀ˚dkL;Â}P¶πÿV\nBß^~˝à´Uh ˇyªrÓ.F«>6pNõPÅps%Ω√\\*˚·Û“ #Q=Éº£QCg8ÙPÉ1mKØ= Yè4‡$Ã	írÇ÷®ÿ\r(|/gÀ•$°Pój\n\nπhbZÔW≤>}¯˘nˆªìoFb*RàÍÖP§ƒΩº7_cøZ˛Í—sÃ82F˘Æ%Ï™\ZFJ:7P¿P∞Ì*H∆≤É¡äB?¬B≈n¥Ù∆§1K ]ﬂsgP∑áı3óÓJF˙√ëçm≈Ëﬂ\0â[l%©û£÷$ˇ\rPøƒK&Oò´⁄5Æ\'ÇRTÀ¢œ\"L¶r¡<œëè6€⁄P«,ñ\\ßÔ√◊Û¡≠·ﬁZ∑Û`·‰ !˛s≠∫£Ü3PŒW±‡≥’JÓ\0w~°Æ\ry!R\Zã[BE&@√˘$\r„PÂOÕ\r\0–›â÷†U}$Ôa˙‹)S~\'√A\\éKP˜î©%˛èπ?ÁkN&—{(éÕbGé!„ù®úî¨Q\rLdû^◊!DG4⁄¯gét◊µÌ öæHˇ∑\"£ªQàAYZbèΩDeOÅ◊Æ0ü{ÚÛYõ0ËéÈXvQ&∑ªgˆçÎì£a®É©úI•\Z5äEc&#éM/Q8®É.‡f\Z`ö>€˚î™Àz;ˆÉ∂ô+¢8$3ˇQ>+]å´6\'üGqô*r-≠U∂Z\\±>ˆ#)‚µMQJr˝Z#6\ZÌÎd&!;]‘˛sZ˙ø\ne√ŸËÍ7 ˚QKPè¶;ÀX”¶_f)ù”ä¸‡ÏCú?´*û£ÆQjπÈ€4b∫$V7UƒÙÑÉ‰å®M|RbBth’QtAFB;<b|≥ªOPÛ£tË€gyWüçZãœÓãQá–úhEªcûN0¬ÎG«	ñ7™=Éµµm0È;’]Qä˙]Ÿ›B·ºÉØ‡r4∞?N&êÿu∞ZsøîQÅ®†^QèáJC£ò}fΩ∑¿L™¢[`%%ô¶Àö≈øbπÉiG®Qêzz∑≥∑u}îœò˛’øπ∏˘Úø±>g∏ô&9‰8—Qõ™ˆH\'ËÙ<≈~dh√ßèñ¯™Õr˙$‚u√≠0Q°˜!πﬂt±©L7	é\n,N§ß±{NˇíÕw9Q¢‡ïüµ[ª#≥∂T§”Ø“`ÏØ0ıéîèQ‘éRééIQ§N¥\\«¿üsûmG´ùiﬂ&Ω∏!0ë\'ÑÔ2ÚQ§T∏ü\Z\"ôs‘≠Z\'@µ‘¬ëõ>=;F∆sı«P[QÀÆ5w=€CzÀ?\r.hÕ+†pÇ\rW˝4UÖFÎ0÷Q”~≠uRkH%ˆ6‚≥tñu”Y–0ºä9§|˜*/†ï‹RÒ|7ø™Â5çò˜¢IÇ|fö(ºÔáˇÿj\0R(ﬂ≥\\˙ﬂ•Hâ£3ù‚ıﬂ±˘‹U=†˘NŸKÛRe£†√{(øTF‚·œ≤QîÖ˛A€≈	Ô«¥¡»NRr˙¢˘á2+P∏ï; Ör{\0‘ÍÃL]„ò€áØ’v+Ru8Øip=ºJ£éı˘î]ºıÛî‚wBŒ‡çœ¬ÇËæRÕ™è’õÜõ2òÒó¡$â!‰à∫F~eﬁHâ`…URÓP¡Êı¢\"b†ïM®…=—sHm”ußñ∏/ˆÅMÆRÚÒ≈ﬁ·üÑÈÛa:hx∏ñE	ügkA˘‹	+†œSœ÷†«ÉùnD◊JêäH0€h@ıÎ€Å*Nt`º—JSºÏ≈tBm€Ñ4tõÂë\\ N9°ÜHÑ6ˇß˝€√ëSBdûˇqÖRV+?ﬂÂ£«ÛÚéªØ•ı0Èˇ‚ÆSK√I≠r)É},2ß‰xq‘„j§¯6+≠ëàƒi©D≠S^[máØ_ÿ¬Ô¬,Y∆˘ù·%q∫[G‡®ÍD˝Á=oùS_–Rìv≠F∑®ôFÏ5ºﬂ≥7sÂ\"OíŸı\'„GSh√Á·`.«!ã1eÓ”UG19rj<b›4$◊USõ,µ˛o®5»ã\0¯€\'ñY°√b-XjQÊ»(,F‡SµÈﬂ–-¬y‚Ôq.¥/v5A™’ÃÛî¸t*∑SΩı1V÷DÜõÜFE—T4f» €Å–ÛπéNãßé·S‰˛àÈÑŒ\n@G›√„fÏ_`IF∏aQm]-˜<SÛ≠∞Ì¬¬|∑Ô†Éü‡|äIññ2§!ViË∂¶ASıÃèé≤[;∏cπé∆√C\ZïEÃ“ƒ4≠?6Û–S˜Aï4c\\D“56-äÕ#ºæd*≥ü““Ω”æèR˝˛ÜT	y^‚\nŒ√\\«ew\Z–K»W‹ÂrN©e/{ﬂ∆TÉ≥X˘%∞ó∏ÔNuÿ©ßz~c∆¢‰®C	W[Tz∂∫1PW˜j=‹b∑◊Y\'«™tNT)Ë®ì{\'T*‚Y‡ªnõZv.\røâﬁ_©\"»à\n´)jç‘eT<›!ãM—Î,≈zÏ[Ü~>V›2˘Ö#}ëÕE)˜òTTö´2∑ü?%…iÀIÿ	¯`√V-Ω  ’äò¨tTVπâ∂\\Ê-OKX«Øõ….≈πN√›–ôéu°¶1^TY®∫Ù£;äGVÉŒ\\7¥ÂhW~‡O\\Q{∂\"T_˛Å ’˛†Gé‹Ùlˆy∫NèÁ2NiÊ3•™À˘§TgeÇ\\PMÂü¸¯Øw˚Q{ki}ãâ\r∂i¬Tìuıs…Ú)æmÎ∑Ë[|l¶Ù≈Iˇﬁ\\¬≥\Z…Å°mUT•ÄQ§<Jhw¯ˆ≤à)‡å˛\n\\ˆ7<ÆÃΩøÛÍG\\T√ÒˇF¥”HâQX@fS·ÖıBùä© Dh8V˜I?TÌÜw∏_±`zzŒvé˘5`rPÆ[˝}~3¿Ù¥UÀêTÓœì©∆∆0.∫√∞ë!ÙíÓ˜hÀPü1s0Éd¨TÒm9¡Ëã‚Îü˘¬π≠ÜÂvï∑›.x∏ôïßØ—9U‰9ÛåÓÉ¡’»õ\ZA”=CmÑY°u\ZØnßÕÓùŒUÇÌëV´Œôı≠pWx‘¬$îèı?ªÃ‰‚áºPΩUÉÄÙçcZíal(€+;˝Ø\Z&∏Eç\"§H≥yµ˘LU04+@qj?çô35¬—S£r›{ı€àR◊˙;ÕéU;S¥»¥ÏTS2.À}∏∆1XìSHÖ&ÒÍºXˇE6ôUKCWÈ¬Õ¢/ëZ3å«\Z”∂Iè≤ñqúÓ£Óˇ ˙øUW&k?u≠nè˘.N±o¡≥Ë^Ï”ÒXÆ£÷€Ö5PUi<∂¿ßçîÚT	,sT∏‡¢ÿ·aÌª6¬ ç˜°VUl“6>8—‚S‘·íªfuù8â∫…	q~¿$r√ÈáUmÿPﬁ„Â¨g[6òmÜ	e∑c€Yè;Ë‚ÊU}8Êü:l„÷ëëı∂≈óô[≥ŒJ“É‰Éﬁ\'ôûgèUîyãB∫ÙÁ\'l;F—‚áV”∏âz©`|\n˛æC1BmUïèk⁄\Z®\"÷4ôi`FVmÜπ¬¨GXÉˇòëiïEU°·÷€∂Bó©?‚wNÄ à-ÒüÙƒåÛm\Z’ßïU≠äM˜: ›óŒL-ç^ö)ó§Ωß„∆|÷;%ıUø…À–»Úïs(ª4>\0Éxä}ÒävëX˙*WR\0>Uﬁ—˙ÈW∂æqPùu∏UóTá=?V#Ì20¬f‚~\\U·àÚÍö¨≤7ûÈ≤Eôß≤E‘¢n;È≠∫á©9⁄Ù¢kUÈÊ≠…ßÜkÒÄ)â©ÄI)GÈ∏55	©áfÈR7UíÉîú`Œõ)ÕΩHE⁄l≤#ÑezÇ«ÜÌ@ëD‘UÒeDùúﬁÚDk·X§5\\h=,ËôU\Zòà8Zˇ\0ÌU˝ﬁ.ãä§X˝Â}«b£¡,W≤sfyyEïQÿF_∏ä[Vn.v&Œ„a+íìØ˝8Ó≥	ôüœ€ö≤uØA<WV,©{+‰π‚•x}-¯Ω\n uM8g˝ç>,lª€ú{TVAô\0◊ì¡DN`\në)Pƒk9ÙWQµ±üÛ“å∑≈ª>VKºâà∏Ña¨F’q©k˘N˜∆i¡ 7Œ∫®ÂîPÓVX◊ÚW„‘ñﬁxÄ@*k˝ãU?Pï¬6º—¢\"å≠5V_QïZÆÒHŒÿõºN\\ËË&IU±bÛöÇá\Z|„˜}†VÜæ¶ÈxGŸòão)yıÈÜ0„ø`c‘Vã‡°õÍõÀÛJ[lu∞øì≥Xk˚‡∑ÈUvΩ\"PV§¶ôX¯Ãœ—Qî3 ‘Â‚«L!hº\"ië‚#:@V¨ûÃ≤Dù3ƒ3 ò>/Â◊∆Qu` §∑R@@Vª\néÕ≥wˇµà≈ìga\\◊ÔÄà~J8w‡˙ÖN:mΩN+V¡ˆÌ˝EÛ‚I0u¿Xœ»˜≠ê^Ÿ@&›2*÷ùX—V«bqPJÎ’ﬁ\0Ù¥Ø?’H˝˜ÖœY÷Ó¶zVŒ™\Z\0®G7h\"±]†êc¬.ø±∞µ.Ã≠êI∂kXﬂV‘q]é5‘ .]°@M˘ƒ*“uÛ«∞b ù∂DLJ7VÈ*–:ﬂç>∏∑I<ﬂ7ﬁÚ{∫˛+ÿ%÷Ù¢º˜¢Wa°V˙>÷E¨ÄÅfw)\\á¿˙‘QQ.ÛHº∫¶zÿ¿´Ü\r…V¸Úkï8v‰>KPÄ3âXç{Ú÷:ûlc@WîE&TèV˛U∏\\O†°¬Î8∞NOy∂!báº¥yÔAv«ZW\r5í|î±aÇ±UâõÇÕà ˙3(|Øáﬂ…ìªkéÉW÷™ö¯ÿﬂ2◊|œ0ÛN®“µx«£YO24pW;à&êéc6«pD¬X]`‡¨gàóåP–„◊åU]!ÌWe≈çΩß_ı÷Å›≤:…Å}˙ó@RÂÈ◊Wõ–∏EX˙WfC3Æ–ÊKu!‘7J!l7Àæ„ãƒbÍ˛»‘ø£Wh¯?·Cexl}ﬁ$ ”àOJ˘õcﬁ†ÆÜ_»WsyWháaœµ∫µ®:[\"5aÇ∏ÅcQQt	ÄEıWw´£¢ïR%Å«G√`{πÏ¶\\ê]Ü3+˚G]lª-`WÑyÄ”ÄV™]@åaMÀÚ∞xezEÆh€sQæÂgmgWÜxÔ§/4Æ¨Íü˜/—\'x/«÷ë˘-©∞ÿ\Zzsπ’yWü»oè˝5“ÅRjœ?öòU∑ò£µZ◊(ÏOÒ%ìzW¶è˜xÖ≤∑O„ä`5«‹Á$=·ﬁU>o˙¥âÑW—æ\r¿%,ΩZ	A+îªuˇÇ8 ’◊Á2,gèLƒ\Z_›WŸ⁄w~∏s®RÛ8Q,ÅÃq!¥Ë˚\\sÜü˜kMÂWı9Ô,Ô–P2eÎ!Xµ:ô^uIµÙVnõÌNY´≥¥W˚Ñ}¸ø§ë 8.t¢f∑ÿÙÚ–ƒòÌ0\'áÈ	±W˚≈Í”¡O}¢lÇeVd±Áì¡`îäπ1 0bÒøW@XX‚P⁄Øü H∆_é˜0æ„Nc\nZ‚º˛`O‹‡X\Zí¢?yv⁄}˚ˇïˇäÇhD§.…Â¨õM°vê)X\Zõp/}‚ˇ‚’∫‡ \r_¬»<\"˘Ωü\Z“!˝}À•X(Ë¶î˛ò˙˘7Øãô+NÏbŸ&1πY[; £·ÇX(Û∂fˇª‚Îò\0ñæ†è3J€ÀÀm›<\n%l‡rΩ…XHÌPÔpEË%¯–*É+%âÖºæåπt‘–◊f`∆Xb≤}îÃøLëä,ŸgC”ÓëÓy~˝ôeb\'˝\n4ç1ÌXc\"å´h™.ΩAıãb™qèÇúÎK¨”πwë_U@9XiﬂˇÈécR≤)R›«†Œ.õ#`jj≈è∏3?Xp*-[⁄DP<óV8±A#ØèÒsAgS´ªœnãc∆ΩXà»»≈∫=ˇ )e◊éæåì.Îxñí§ipXûL]O}F˘»w	Vy\"ßûÁ#aqƒ\"=∫À«˚rX§≈√ñeô$û<qé≈>îjÖMè˜„ò5Ã∏z>6ÁX∂!øwÒ4êˆ‘-<[·œE»˘—A›b•§¥«g◊z≠X∫»ìPÒåI‰Jµ¯pe8Á ,cmáÈˇÀ[õX“}w…ó‹˛R6©7€uM∑TÇ!˜æ‹ü ∑†\r2ˆ©XÂxEâæK∆™.÷«,lX>w{oyÏﬂiã%UHqAcXÏ¡rÉå5ÖyôÖï•w]j™ùŒ≥⁄Øz–∂É\ZÙ±YV$âÛƒˇ/Ô•ü@=≤˜Ö√ÓªV-Ωÿdc∞Y£E¸ª4•ò•≥eÜV∑L F/îUk,°∆~¢Y?c¿*´_◊aµ)ã¿\0|ŸÒ4S≤täÉà}π-‚ ÅYADØêˇß] àîÄxYN.°Úè‚à7l}eûKYBéÈRbÅÿ-tsxücˇoÆ@“‘æP¸»…´YCœ©œü°$ÎpÀØ=üqj=hs\"Ê¯(\ZNÓç)‰ÚYtm¸k9ﬁQ¡ÁÖá0Ä`˝ƒıNªö⁄i¨íãÔYèì%¯FöÑV≠O´Â¡ëác˛¥™$˚mˇ3Ω\rYõl5ΩpY=∑´Ë!Ì\\^oxô>úS—…8‰Y¶-Y¢µ`x¶^.π›H#∆π/Ç2†ˆˇËÃ◊›4¸ƒì cY¶@µe£ê?⁄W\\\'¯l§mÁ^ã9∞ØƒèﬁÆ-õ+‘Y¡ÀÏ≈œiH∆\0ê®“U3$L¿û≥$ïûuÒìH‰sÚY‡7…°‹ºa/c$€Æä7\rDr\\Ωö.òÏ¶ˆÊFE—ŒYÛ1n•Å8£∆Dùo≥X‰a0…´¡£‘qËûp&EçñZ£4róÉΩìB÷èéìŸznó’¢>È \'˙dRÌŒZ™õGã\n+:PÂ|>s∞êPc^ôM\"q«Í¡§Ö«Z%§∑4˘\'ì\n‘CÙÓ`≈⁄Z√≥ÀÂ4–cj∂/lZ6ûrÂUóB˜!≥tÈR≥ytJ˚óI0+dI\"Ó1ÎZWj’I\Z¬g*(®Tÿ\n\\L¥Äbr7t…Ä≤\nœEAÊZWrÖÛ\\#πÕï	˛!π^ltú˚îÀ›|o«Cÿ …lZ^°Ïx ™ ´ÍÑ-ñ}©ù:…è\\É·r∂˛›ÚNZb)ŒVlJΩÖfd¶æÑ°XÚ“#lW†@ W ZëÏS-˘`Ûÿ~≠ÁnVÎïû\"“\ZUMáT;ø¬Ù?Zù”¶Å8yÈièÎå√ÓkP\Z3Œ ¬ëËëäÔ]õËøZ–÷™¡mÎñïó\"|OßÌ»∫J◊}^∑Í@ì∆ªÂZ’çÖâ†˙†Î›Z/.Î)¸˛‡w¶Œ}•∑ÈÜ∂÷ËêZÊÈ-rÂªíˆ^é*`t6áëíß/¬ì[<œhÈÔ˘[\nxÖSÿSYPÂû´BÒœ_XÉﬁ«K8S€˛a#ÊÍ[\n»*k0Ê5DÎaò4Ã¥â÷¸±·;–\0/_ñ7„a[èï&(‹á\0ë“…ŒïlÑj¸¯¨Gù”˙˘Ò∑n[\Z$›kÀπ˛±Èåd?á\\{\Zøƒ›ê≥g/„_,ip<[$∫r(¿Î¥⁄õÄ∑Óú8¶tbèMq\0>¶5F[5óµ4(KL9∆&-kâ¿GRK$√≈z,¸b6Fp˘‚[8s˛iı!éµ»@ØÎÆù{ÕBéu$f˛ºëÚ<[B•ˇ©›…˚<ªsô©*À˘;—’πC∆]+·É∆ÃSés[D˛Ê\nphŸSÓu∏o9Üa`‘\0B,\r˚i[e2∑<˛wˆt5ØH“¯Æ‰m˘|ˆ◊€Øx#FÎ…)=h[eπáæ6”Sùª‰Î\"Ñªì√±¶xakAyR[t;}Ãn[π∂Z¶VL¨ü[¶æqT√u!ÕÔÀ-.¸Ê[ué#Å∫“\'˛KF}àa~\ZY∑	1·€ÛûL.®—p˚ç[[8åÊúÏa˝kI©Ä∏ÏÈ%\'ûn©Ä&‘˘ ÈG≥[Ä)ﬂãÏT0ËuDWP\",Lî«´[≠I,ﬁ≤Z≤F[ñî%yºKR®—„b6∆=F\\∫√∆ad¬˚Ôø·[ò…ﬂÃU:ÀÉVN˚:ëOàêe‡x˚Œä‘J/Z[ùº~úK∆XÈÄÇ[\r\"\Z,¿3z¬.ÔáSÃ\"¶;r[£Í¿\n)–>l=—l∫¯VÉÀ;Oówóó~ Ä∫[©ûÛæf\'TOT¶›ÃeÛ®¶f==∫„ú&”i[≈6‡‰“;]Ç…Ÿqd¶‰›JÙ\n} Ç∏…•§D[÷‡‰y¸VÖ¥ |ãtù\r\Z–ˆ/]X\\m$˝íÆ‰€[Ï»äD1VïyEàM	öØ‚eÃ»\n~%U‡,¶+ûè\\…≠GΩÕ´Ö¢F¯V6BZµÂ≤ﬂ@€™2Xä4Mw\\Jt.æN˚·ÿ4\0É8⁄\"ÜÿÃ•èA;(R[äìl6\\^;◊™h±z{áª≈aTØãùBÜ©ôÛ{Ì`»µ\\sÃqÉ)ì|—Ω÷IJ<Õß,xLI2[Kˆ£ﬁ0‰Pd\\x∂c,˚ƒkåWbûüaÃéﬂ2©\nëï[e]\r sJ\\|ÊﬂØÏT(tˇ2˝±¬àÖDn\\£ë˝∆‡3†\Z#†\\à#G7Äõë¯Å1•∞\0nXs∞d˜∆Ô…«¡ı∂\\îÙ?æßùúïBÅ⁄:Ï{”ñ73¬ö≈L∑ŒîJﬂ\\ï283=}f.ŸŒp{€Á£®∆≠:Ωº”md\\üAÇRZn∆9ÓÏlr(X˘uîOôöÊmC…Ÿ‡úÑC\\´_{î„[¡ëG€DŸ%îÜ®@X∫o[tOx1•\\±î¡HODƒ®{œd}d2Îs√IÉÙ1eO:¥y—™Ä±\\∫WÉ…ºâSWË#6+2∫ç}O}|FT±\\¡Iä\r\\÷µ$ÉŸm]I˘ÑEˇ #∂≈(\"Ä‘sc≠1Ñ.\\‚lC¯˛v!€¬˜BäßwnsÓ€ò%y\Z∑ç©Y(\\ËÛ±˙⁄ò=Ç0ÉbﬁÚú©≤ë2÷öˇΩ î`sTR<\\Ûäˇ3ÌìSÓÑR„\0ªNÚ¥ÿEãu=ﬂòoÔÌ\\ÙÆyõT{ÜÃ‚≥ÒõﬂM⁄ÂPìu|)?€\0@\\›—1B\\˘ûU6Œ”°j›Ä]bz‹é6Èx+}\'èrçÏçÀÈ“ô] ¬À|$‰,bèEw≥¨ùØ`&uI\"π5Ö‡`a]—FíÕ5&ÙäŸ-]ü¥øV4‚…dB@êFıÁ£])ÖS®w‰„››MÎU’ùXÖ˙¢Q‘=âXó|˙∏]<r£∫÷ΩØˇºŒ4«j\nΩ®Áê„hNRãz/û>¿˙’]A.˜…§Ö˝ÙÇÌz‚.„“jé∏/zª∂µ∆˛©˘è]HΩæB⁄“‹	Õm3Õ›¸˘—Åh¢™‹Ø0x!ek¢¥-]J˝∆ƒ¯åebU´ßf»7bƒ^p3KOF‹ç‚º∂ñïÁ]Nq˝CN≠•ˆ⁄Ÿì—‘Å}~Ó<aı¢´¡˚•€]`~$âùØò„®mg[ÿK„5»Núd√jsiöRÕF]f√›Cä¯¶-\\Oa+Î∞é#i4˛≤xö$jK]§»…ÜË∏»Ùãmˇ{˘w«∞#ﬂü^È…,nå∂¥µ,>]Æ£FHrPÁ-sìÚen|ã∏Xq\r¶mfŸ`·y˘]ƒ⁄Cò°≈Ä˘π–Py£…(‘ÚÏc‘:C#Úä8ˆ∑]ˆ‡‚vY”\nÇué)üÃÅSEEı\\Ù>Aò?]LîV]˚µöËïrøø6|©€W©‰ËåÑÄ˘w\'ŒY]˝–¿°¯V0∏«5,˘MŒå9œn∑rDUuÁ7]ˇ%êhqOâø–ö›¶˙Ï†tﬁq¿;+sùV1BÑÂ’]ˇ¿ÿï®√YÒ\'æTÉ˘„“π0≠ ìP¨=<˚˚†qö^‘¡T‡»∫^ÔÜáƒ∑>`ù}j NG—\\\'ÃÖ^Õ>\"ä5ÈJ+f¥Øi™7h&Cˆœ≠Xª±2˛\ZØK^7q¸≤Ù∞Ud>©VπN≥†ıcß”ha¿ëp9k<^>’ˆr=`úæî≥∑7´ \ZêÎñÂ∑Ë)•xÕÂ^AGìêú»^›¿7 Õæ´Õ6`—¸*˛$^πvÑœÈî_^J„ÂpÅ!˘…<ì¡ õY«˜ñ©êw≤Ω\n˛¯)l^Nbu\Zx¿\'!T∂Ë˛°8 oΩÃ	yõY|ë~ïC\'^W;s]ÿ-4ßØ‡VÄﬁ8¥4¶∆^ÉÕº∫ÂÄ,iï—^g ˆKãœc°Z›0Ï(⁄!ˇπ~æzWÍ\":Nû^m˛‹m[ÿ(ò≤CÌ´,m.^¸óvÇD›“G=ms®v„^¶ﬂúÉ√ﬁÃŒúÎ∫»ú≥5y\\≥¬·s„‹¸ñ%Ωò^´ ˙Á™q†(jó Â™\0I˘ñf}—˛≈\"l◊¸\Zm^∑:ñU∑õ€rØUÏ–¨ÀDøUA6YføÙÄCb^∏ïUßjxî∑{ñü+\"&?5πYãp—µˇD?ºŒÂT^¿‹Ä◊\nØ0{zsåÑ>NzÈú/Ÿ@Û6◊R^Ãü¯ØLGõµZ‹ØQÒ8VåWóÖ9Á\n°Hb2^ÕHR7‘-éIAúƒ√øL#Á~{º⁄Üï¯…Uƒè⁄~Ÿ…^›å)Æn∂T·h):3\"WjEv9à˜∆NnZ-m—µÀK^‰P∫K:π`XÇæ˜¬Y÷qpÀÀIª˚—~µ^È™Ìe2æå2eD¬¬˙\rÆà≈˙/V¯ÒΩq^<,◊Ÿ^˙Ω√ÓÅ¯.ﬂ:Æ%5)4N®Äíc∂j,÷®6|^˝◊ã‹Ñ˙yiT≠ôWÈ¨aûäÛD#∂ÃFuñÂÜÊ2_2ˆﬁf\nw/ﬁ©π}†\rº<∫‡ﬁ8Z˚µú$Ñ_„ØM7∞∆ƒòçTf&%Zî©Ä1Äü‡ŒS≈/-˛v_|BÿO\Zﬂ≠/B„ë˙lk|ôS|d«àhe≥›P‡_,ÅÓÁŒaLO 0l”îB\\ÉU≤{¸ÔEπrßÛáπ@4_-n‹2zYfyèÖ#Ü‡°ñVP∑†M»\"~˝_^¶õ_=>7b·ô\níºè6àhÈ∂®Pj|ı\"àxªh»y_?∏,Í˛¿I‡àbe}ÈÈ8∆\\LÏ£aså„∑/_TÅ_:rÇc–ˆﬂò“sÃNÃ/›]È\n¨{ÏzñJ_du‹˜Aõ#fE£*Ñ.\nn9ÌßûT\ZË¡9pYbXà_lbÚÆ•R∏,À\'´¥ÙI∞hûeëúRÉ‚ÍD8}H_oΩµ∞YŸ±…‘RÅQôç¨_}«GJ1mÑˆ]‡~¯_ç8Ûª@Ù´zdf0p`oè÷qqÕ◊U:§ê«_ò»7Qøª´ê0≤WìÈÉAë-@\ZCΩßTïMç2ëG_ûÿΩôï37~Öúq/j§û\nÔÑÔ9ªSﬁ#sè©_±´’îJ¥Â®\n¸ŸZìD¸æ.™sΩA	1™d Õ≤_∑Â6ì4	öÉ‘PÌ¨K_ﬂ`ø÷IÀ®‹1?‰ß≈L_∏˘˚±%MÄSK¶9¿$yàÔ´√∂ÓgäÄÑë_Gˇ_…$@\"°4](„èÍ•XU∏jƒ≥f´¥Is°Úå“É_’Y’UsE∆πT–4qPòÓÂüMæ·DS⁄F>ü C6_€◊õ?&mûΩH[πJRì®c#˝ ¶Ÿú¨M6EÅÇ‡_Ó,@ƒ\\Sµ˘7‰lºo—ÍFœP€˛TéÎﬂﬁ®G9_ˆ3Ã•»˛3˝Í*m	°h\ZænM∑Ø≤ Ò—¸ÏÒkXÏ`åû>:â™6‘©fÔëô±	¯¬µÍ(ır£·P`∑>PÕàÀô¿$I+=°∆õ0˙µtëW26S˛_¶<pH`>¥¡NgÒæñK)“À„ñ¬ûà°p&0L@eÎ\Z¨`Tπ∞.ı|	€ûƒâ©[bTú⁄ÁI¨˘äåú©•àÜ˜Ç``ÌıtD;”–˘µ?^+ ì5mË—P˛|Û&`{ÛY∆Ò§h’uA≤lT≠»N•-Áo¬rgÍÃÏ˛í`Ç\n¡ˇ∆Õ‰˘R ]≠õs¬?öIìdi#Æ8Gp`à¶∫hs˛Ä4DúUÎû.f´à$ôªE•aÊ<pÅç[“`íÌß\Zª¢”>fî>‡-\n})ÄŸﬁûáÆ≈gGK÷!`üÀ!\r;^w∞çÆ≥ƒjMRU\"&›ªIû ùiÌ<l^HÔ`´=ÿ˜›I†xä¸\'‡uˇ‡–|§ê‡ŒôK´à!`±dIèUgQ|Xô!·f¿π~jüm%ÇZˆ™–ƒpñ`∂r±Ω{R©.1ÁBïiKk)éﬂ¶5Mî≤µÆ’`Ò¸S,¿–´Ö=Í 3Ó R=‡hR1¬\ZèˆM‚Ñ$æa\\CÖõ‰“ÇñLœ…nÙUÀ[˛‹†˝{\'áUa\nâUîÿ~ÆöûXáèsò«\\\r>ﬂcfç\"ÚÛÆa£2>èÓ’bÁ¿[∫/WÛâñtz\rl¥y¡o˘UÄda\'å¬…éØD⁄u9MJµ˙Ÿ5u|Cım§FhS§¢00ïaC∏’$Â¢qas©≤6[`úöuäÀ÷ì¿@çW]-ÕßawÃAV» ÿ>[˜ãGAïßI\ZÏ ÷‚Ícr\\lËaúfÍòKø§ÜZX~∫¡˝Õ∫°æ3˚bä]L∏<7a†«+J#‡ˇ\r/_ÃÏT±QP◊ÛâOåŸlëÈΩél?aø≤E<2`\rµ_àÒraèÄ\n≤‰∑{!Øí{ëΩôQÿØa¡≤æµÅ~ÕßïûÅZBv˚òLj⁄*çAhÛ*†Éb¿a‡Ë≥ÿÛ†zCÂ±ÖZ›Äú†º;Î4àr=ìŒò|≠aÓuç˘YÚï]èÚò‰iZ‹§OîÁ	ÚÆU«h$ª\'©ùaˆÆ‚›Dà¶é¨√mEñò©R¡Bt‘\r”?fQb\r¿ìC?˘DÜø˜K}“˙øóy•/ÑÂ;|MÒT$Ë?Òb-Èìa?å<ÛÈ\Z-∑ÆÃÏr\r$˙¯§ZÓÖ|Yæ\nbGå03‚äºö“\rQ∫Q¡Q@ÑvIÉF.3ÌM‹≤%U·bJçím-˝¨ ßË˝’5⁄53P#ÕA{∏é·÷6˝˘\r54bO⁄Q‚w√πÏL—†√¢˛©¨ñçôõÉ9Q¿‘lrlbP9–Í√˙ﬁ§yPØ€Âg„—\"Ó¨ƒò¸ã\"V¿bST2•Œë´CCD”\\`›Æ>≠Eèâˇ?‹J—3™®bgBóxüÀÕ…ñ)#ÈBïÑ_˘uÆÒı©®r›ﬂÆ+bπ˝WÃÊ∑(ˆéçõ:†å|„±◊[⁄KÒ0∞b∫KÁıs…mÑFdÂA¡Î€åã≠õêRï$¶	¸≥bªbµŸ≤•JÆ4k&rˇ¢hXŒ+ƒv◊˝Otﬂ$ÙÏb¿≤0#œ¶Ìñ§òêA*è>∏pjqúL*LN*\Z4‘bœÃÈ;ï±ÿΩﬁÏw\"üÉSß8è\\zëÊ£©}“N0b€QÜ\ZëÍèB£◊ZQXNTèã6…œﬁ{í•hB‹qâbÈ≤ãÙàÄÆ9©‹!Ω≈X±¯Ä:\r3_:∆…„mcbıíÁq≤·q˙[ò∞¶Á”JsêÊÿ¢_~≈4/†…`q b˜p¸—dÓ^R\nß`	ø=dA´c4¥eÛÁÒs,c#∆à|F˙êw°J\0Ø`w~¡^vEpŸè˚L¡ïïLcæKÕò˜GŸÒ|†·˜˘˜\0◊wO>”W!íæ cøŸ˙≤åâ:∏ŒÂUe®”H†C¡B\")SÉŒµ{Ëc&ˇÁ~LâRt j>⁄Øº§«ˆ„ÒE@>Í«¢`¬cIH1≈®í•?™Ç ›\"ä˚= „¸\n∑≥w\"‡{∞¢“xcS¶g°Ó±˙y(Œ≈0^£Óxüa&[Ú5 fcTá2°È™òÏÁ\'æTe+b 6;ÚcæŒ˛yc`G¨Ç√Ë∂ÚŸ•ÁT‹¸Û≠~z¢ôF…+“U»êY⁄,c≠¥Oˇå∫`H∏áƒ;¸–≥√ƒ“CeÏﬂ]œô≤Tπcª9Æ◊õåaI‚¯aX8\rr,F¸\"œ¶◊C2Syác—≈–^\"ÜÏæìœUü‰€aã?¯ª™WSQgbª…°“ác’Ho¶õ‘ìƒ±¿RUÛ~oö¬œ≥,⁄P¡)RWF˜cÈ™Æjﬁæ®ë?˚l\'Ú84ÔÁF=/3;6™)_q€ÿcÔ.sH≥·*Ÿ-ÿ®ˆ_Í:’‰Ä¿%ñ;R\'ãKéÑ—c˜‰!¬#Bßi*+\"ˆ\rπnö˜ÁI∆àºX√â˙ wŸc˚√ ó˙œí†BZÈÜ‹7√≤ﬂ;_ÃZñèevã≤d$Gºêô˚jÅw}XXâyçu2ÌZ=˘≤èIo*€6d/e‹\\s˝√S¯:ÏßÜ—¯Ñ$fl©≤m¬oÈjd1˙3˘\'múÅzÏU=&Ÿ™$‘Ÿ?tıÿÛ◊â$˚h\"wd5[Ê&*%Ù◊\r‡€G≤åÍ8	ÚpS”-Ï©üq`97dB›ë…\\ŸE©’€gEˇ8\nñ∑Ú§å∆±z\\\rxÒ/ßdP‚±±∫ù¯æ©X.]‚ÃÛ9…F⁄Pû·ˆ+ãÑzdWå\'MJπe…~vxŒh{»s_™|q˙aë›¥∫∆eÕ¨dcﬁ3bΩ[∑]	Ä§~?;\\[—Xkïô–ó∫ä`Åsdf/ñ»dBlùõ—‚ÁŸáÚP˙õQÿ=Ä¬#djqí˘e^¬1wK4IntÂfVC2˜¶Á˛2@qÚdr\\ÔÉ˚=ﬁyãZ–ƒ]õãØ∂˘.◊…±∆˙À dÄ|I¢m°’€tÂPûÚÁÄ®˛∫9ãÿ6„£Å|dÉø	YóóÔÉ@@õì+°œå“ìgË ê>$/í‚dëÃÉŒÊÇqx?í\'?lÌπêJﬁk˙Sç–#ﬂÓ≠ﬂd®îæIX&‹çöÓsΩ!µ,„ÀÁ,\ZVwYLÏd≠rSzn<NÃ{ê1J›,ãà¶[o6´`‹WªoÓ„d“0Ë¿±(ûÓ∏úÖX}vñÔ∑`Òﬁ\"d‰´ÙWÓi€ˆ^$¿£üÂÃä_ÚÅµfÊdÚri§Å\"ófvxÅúÚ Ö¡e∂K≠A?é≤®SÌ2ˇdÛN˚WNΩVSC∆®!≠\\K;e!£Ö◊Ÿ*T•ê‚d¸ú∑9¨¶ú”0Ä2á”Àˇhê,A*ˇ¶;3OéAøe4§§ˇc“r}öcŸ∏eKøWC˜s$‰Xgü‡à-e5àkyHµ~¢Ñ•≠^}˝Ù\\†êàfîá#¥∏6’◊Ùe:iK˚†p[ìÛ—◊∆8ÒqBÂQÒƒõ(3îñeTm¥?òUy7,íèKÈ\rìàpSU»¿Øn¢8Õ∑@e`›Ü‡.˜ŒÉ:éîjÅEÛ\Z≥“∞†ÂËÇ5ﬂ\Z®)en±R.	OFÊúOXÔôP˙Ìhì°‹YC>øWÍeõYˆÃªL˝«˛∂s{TÅæ™Ì=BÍrvIFUK◊:eÃEB	™•¶LzÆtõæ=„Fú,ÏfaßáZƒ‡{≠í‘≤e÷ﬂJ*ŸÃbVÜ,çCv¨b¢ É˚ôPµ~Ö˙ã$eÿìÓªºÑ‘rØJQ◊(∂O@_÷y\'ß+€*&w≤–\".e˜˜”b|(GΩ∆Ú™Ô\ZÏ™rK√Õ<∫úõ7Ò…«òf=Eƒ‹®YÒ\nÚ2É’fÏVöLà$/DE±›◊fl/»io÷√V€L5‰rp∏HÕÖ—ú5!Ÿfp¸0U«~øëΩ∆ë⁄Ôú]„fõO#ïiUÃ|dêpf1\'§Û)Ué…∫ãO +◊pÒ‚ÊÇ˙ãP\rÎköŒ∂Ëf?‰ás”ä¬1òòâ@cd`πÂ˚Ëã≤”˜6¸ƒfSæ~Ø\'hÇ,˚íP.E1J˛>3&ú˙`B˘(˙¨Lfb\"=¸¬gΩ.õÔÍ>{a€áaNá∏l;)ÍO&a,Wfh†≈P1¬é8ëjIU˙ÿ?7zŒì∆j˛u∫≠+j(>foÔr\n&Ÿ£‹/	ñE.ìFﬁMÊ¸§‚ß«_Ühèâ∞fµ9∫™‚»»Üyá7îÊË,W2É)˙©[Ï≈* og‰”¶\r˙W:ÌPûyÂ»}p!Ó;ï\rÇûc	%∏,g-Ô–Ñ∆Ë#h;>ñﬁ	å|°Ñ£3ÕzB◊ÀV¯˛Á˚g6§B¬Np¸˙˝£&·«˛\Zg¨q:Êês∏d—⁄’¸ﬁg;74Ÿ£∑eZ∆…=`7y»˛úÆ¥!¸uTÈ9V\ZÖgV∂|”∫gaWoƒEΩûˇ\"˜{Q˘T ÍS{>giI?F]	Æ{®∞’[øŒï˘$π^#äîÕû’d	gÖAÙk–ËD∑´	ÄdBß(9Ú—›Ê¬‘Ω‚…&∑gâaÛaqÆ$Çú+q´0k+&î¥ÓÄ;\Z\nl$ñhgé%b]Zj˘d)≤π-≥üpúFœ˛˙èñjü 9gõ‘≈ >∫õ¿0Æn)≥·¥X2¥)Çó 0?8ÛÚyÌgü§ŒÍÅ∆>î∫†ŸóÄ◊Yâó†l¡\rÔó\n	Pm∂Ag†=áè{wu2©ú·™xÑíöµj‰5Îà?˛Å°õ¸œg≤;a⁄¬ø]ÜX±r∆~∑Óˆ\nìt—¬π†n¯ø29éìg∆.≈$Ûo8qµß;Z7tz?¿ã›Œ«∞Êª¨⁄¢Í+gŒ™Ó#è€ÿKÑíQ]à∏˜ï\nÌ44wìÒK£É‰g“—HÍ7›IÄ äó|ØHi—≈≥lCﬁ≤‰®ªg€gÒdÅv|U=éêD≤FBÊ;≥~ÏjèZ¨fÓúg‡”ïWñÖöÌ—¶∆\n[T˘\nuA[z≠‚ÉGzah\r… í€©#j∂E¿;’´ÂËÌ˚}Qe-Ç6ƒÄÙCh\"ìnøß9¸(a‡õháﬁø«Áä[äGQ˙à<\"Çh\'Ä+ï:ÍËu∞gÉcYcçù‹Ÿgﬁ‹=¬“hh0zN¢ôÂW:’‰\\ùjÎÊXΩ%èıÖ@Ãfâ;ƒhBkD]{ï8ã√«h™∫·~-2çq ÆÔº¡‡aZõzhIØù∑© x<ùáÆ˛®Éù%ï€ji∞’¬¶ò$h\\¥¢¶|qA\"˜Æ_;^˛Øgã‡ïcwÃŒ‰õ\r{PhâÖÌ„¡ï¨˜Z}õá€áﬂb¢Ñ˙æ‰Œî‰r”ç>◊h∫h<g‘Ãs).™◊ñ°™æäWÀ0ØxZHCD«hº]3Ê¿Öl%YÊ+øâ!®ãÜFÅ´o^å=ï‰h’ºoÃ8u\Z:…8˙N‰Ó7†IM!Ï\Z∑l‘jÙ#7h˘p≠SÄ=T_k. Ê>ÚU’C÷mﬁiVΩÔh˚ñ1üÁp∂ÓF∫)y≠d ±®vNyN/π®>…uÇi‘rı´Ÿ	ß!8•ª¥©@ûDÓaæEçÑŒ{i+;N™‡3»«Ãñ± EÜ‚›∂óA‰π¥ø Ω£+i:à°ô;∆é0ô$Pv˚ãú˙ŒF\nSpÙ2◊÷πi[-Rˇ[Ω¨4ú‡úÃ†∏/IwFß—E	U„Ux´ i`WíâVdö¸Ã‰gz\0ï *¬úò®N·∑å^‡‚eipZ&œ–˚`UnÃ$PÈ9ΩxA	ã”âƒΩ¸’\0±iyHàE˘—µ3Eå\"ì˜:ﬁLÔ\rXä€Ä,$|uƒWpi~˜∑Ù≠Ü::lú”w≈ÀâŒ§è’´‚8Qi€(ΩwAiê}eP≥.P|Sß[wà Î†»W•&wÄ4ÉéxiíÊÏM∆W@ûU˚}ﬂPóOºı“OÑJjÉr4ÁﬂM_E{iì‘0ìyNõ∏G\\8·9É\'∂Øê1+ê8*Hdi£êÍºiYSí \'íÎåµ`RÎ^òÑ∏yúg4i±n\"}ÑVéªu©3)!∆´Ë»˙Zœº~’\\C^&Œ$i≤ ±L.1©j…uû¿ã«ÏÈ—0öu˝Â/¬&ÒS0i∏˝®·vÕ*+∏ç¸&è &@kM&QÑ œÕíi“õoæ‚√ıH˜”ùéæJ1¸•Ωé¢¿Ñﬂpµ@çti„t.%¥-≈èx;\nó>r˝#,úÏKÒ+»∑i‰cıÌ√\'Õî“ûª>ôœ:Çî2n≤Q†ößná^Si¯h0=˙£⁄]8Y´E\n*ı”Ωû∂∫¿ns—‹àjh\n—ò†‰(Ä·&ÉÑê£E§∏®e™I\\‹s`|jºê›ŒSì◊Ã=£s ÚÔÅºïÃº*˜ÅØa‚	äÒjÚbÈ±ÌöÑÃ^U®sv8—¬ç$bèù¥ÑM·3yíj!˛iáØH4“¡]˝eL¬8û\r´—Sôl±»cbj0¶ë4‡1@Eª‰©Xª<Ÿ\0µ“+&üYj$6g∂Cj6vtà5Âr#gAWFŸû⁄≈œ#Ò˙YÎ∂≈ ÖØ~j<ˆ©	—©*$‹∞*s£ráM`¨Ùe“ã!É˛j=ÂÎ8P„ôNÿ‰òT\ròÜ]LÆÆÈ∆ŸT›C\0\nÚjC,ÊUîMa£„¶\\kdDﬂŒwÓêÑi∞€≠≤jGÀ\'ÊC1¥Kh˚âbºı*|¨¯¸¶YFπ∏jI\n£&U@öóî˝¬Ê4o=±üπÒw|xì”°®˝^œjPV¢ü¸]’gÑé¸2L˚RSlwµBq—K∂¢íje+=ÀµhOÍd\n:t˜ò©(Ÿ˛≥Ñé“t§∆%º1øçj|TTò†*ô∑›/#[∂˝;‘U[©B?,û‹êç¢`5jÇü8⁄™N9›që¢æíÜõ†ÿ9\rºD@ÒfTUjÇÃÏ·4˚Cu\"ÿB(Ú≥7Ÿ„\rX†ƒF4üuöNc“√àjÜ·’P©.ÉcHêqÛI<Œ;wúhBãNb8\\8cÙÈjåqØà[@Ë”Ta‹`∏v’+ıs˚—Ö‘ﬂ·åfﬂÓãjõ≠	÷∂Œ–˜-ÚäÛ%Z≤L9I~xmHå’É◊jùoÇ9\n’†õŒíyÍâ[≤é1	ÈóÙI…≈™ÄØjü\Z¢pá£˚ISÒ≈b ü«S}¬_∆Vö¬ï√§Üj£ú&Zìy\nÊr[¶Ñ!Ãƒë÷ëIˆ¬Ó}	€I+ßj®~À¥nBAø√-¢“‘òF¸O⁄Z*–‘’3yAª^jæØ`ÓÅ≤+AÂ+˛˜9Ω5∑•••ä SJ:9√rj÷Øc¡íQ1\0Foõ êfyHüDˆ0@)·ÑC“Íj‡ñ]I\Zñ‚Kxz’ù™^´àÍ©!buôÒ∞j˚ˆëA¥\0Ï.∆S¯hNÍ}◊ïFä|YÃE\Z>—≈N¶»j˝SwÙKña^√&úü“4	Æç˙ëè‹ÓtBª€¨ikæi8Ω5{Ò®?}ù©’˘íè\"!ºãAW,@z‡àUkπlq«Us˛n∂Ö3\\}%2∂?rz≈BáÃ≤˙°‹”k2©{zÂÖ◊–$µ\0+3¥õÈQ”âXﬁÀº£ P˛¸ÔkH%|§Qe‘H¢z\rYáoï6Fpì§i0[≤ΩÁØÄkN®IPÛıî»ı-\Z7}H†ÇéDC˙;ÆŒÆ>£EàƒkUM‡,πkñEH+ë±yÎœJvˆyˆPK”®ÛÀ¿≠Ée*k]∞^âÇ=Æﬁu\ZÌ∂;æd™Í2∑é˙≈kè¯XÕÛµêÁDç\'wù‚£˜‚ÖMıˇCﬁ\n·é∫\'k¨ëÒÊæwœ6XN\rüªó£Á0⁄cÁ“ŸÔ’ñÚk∂3/B˛û‹Û	ﬂ™\ZîpÛ\"÷J•gûh≥ïªk”‰†…∑dZ∂qN–õØ\ZÁ,≤F\\Â»\ZÌD+Ô”k€UÀ€ú[9ÿÄjçÛLÀ¿2u¶¡9Ï?uªÒá£k‹]˙Î70TŒﬁ≠qßΩï#ØC¬√÷†ô“≤0‰jëk‚¨Zuî–“øëÕ,Üπ=\'û»ÙˆÆ–°Å«ó:Ã®kÔåõPñ;ÂÚ¡ëíN3pÏ„Í\ZxqâœRWˆØ∆lÑöÂ÷ªqS)ˆ?¶ÙÁ¨ÎÀ\\Z‘≠Ñîå!Ü?l⁄¶≠î›¯Ò=ïùQ®>|ZÿŒ¸…äªÙÙ>F5YÉ—l!ãÉ™}[z£mÛ™ß•ÅÁ⁄¸£WÜ÷#	±⁄Íç\ZlLU[´døg.\rïƒÕ5¬Óp\rQ±ëÄ<¯[´vr0l_](7eÜ/™ÅË—6¸ødÈ⁄Œ›pÎ¡ök#ªlöﬂHøÅÄ‚ÏÒ›á\r]0◊$ı{¯Â	%Oê!—ÿ⁄l¢ª!Æ›ˆâ∂Oı∂ØÔeuyMÈm1´À/≥Ûl≠≠K$«s0FP|PÍ«\\€V•SÕ&6B´=∑˙—≤éRêl∆i4Ïø¶°rnµû±¬Óu≥)KÄj¶5ÄÊÉW	l„Óà-•˘ÅC¸‹jñ∑ÿí¢g…\\∞rƒæœ∏CIÀCl˘aé{!h…Pw{Ê%&ﬁ÷ Y0∆äÅ“íÉ±|tm\0Ç\r>ú»ë’Ov<»⁄k°a£eÈCÒÉ»‘˘@mÚ€œOõ]^À-,•qsr∞§6µV¯%F≤⁄ªË£„me—á_Ó˙TG\"^ÁjU@¸Ÿs=F—Ü˙5|¶õm\rXC–9S…guhˆ¶~∂ﬁRkYmeË‚˝ØmN†å¬–’\nTm‘ﬂÈG#–ò∑„}ãZöY’Ä\"m9∂≠(ù‘º¸ì±y[≥EAΩîÛößI¡\"Be]Òm;A˝\rd‘+ÏıπÈÑj®7·À’˝qN˝”y	¿vç\"P˜m`ß√6ÎΩ©©œ≥º˙Æ%Ù⁄HjÆ‰lìÃ¨?ôñ.ml¥íõÚ|‡,C∫+ËIbI$”®È¨\ZHÑŒ£^\"lQAÎml„ß‘üƒBù:ª˙á,º%cÅ5iN˜õÄ9Ø¿mnm>ﬁéŸQQ0ﬁ504|$8˜“]W∂p_Ÿ∆Ltsm|i)m`mI}IdKj+É9õVˆıÕÄj¡|,Úƒ•m~<]åxLÒÚ¥1±ã‰A8ïzò\0Ü-)@ Ö¯mÇ£bO-Ê7¬∞ôOøa$¸Lê¡w?˛JEQùU8mñoyfrG›ﬁ⁄T^5ﬁîÛ\\kùp–0à[*!◊Ëmòv<ÌÙ.KÆì	1\\∏ˆß WPµœL˘àåé`ƒmö◊©Ÿs]S7LAZ&<ÏÏÑñ≥vﬂÇ»ÌfPøFù§mm£G†’Íù À¬ã=∑ä≈‚Ú~Õ5OURD\\Wqñ·e‚m¶ÿäóÑ}ó¿˘ü∂‡BP\'|{M2Ò˜gÍ◊ëYÿmæ≠M†»⁄ΩÒ›©ù=FßV€7≠RÓÕ∂}9Ωdg=m⁄”•\'ìÈ∫ôR“Ä“å˙*z˙ù#:≥◊ˆ,˚`$‚êcm„˙`ek}√¢ÙàyFæ[≠ˇˆuŒ\nÄeõò≤≤≥≈^mÁˇ•<FÅºh‰v˙%Eœë1“^Aõ‘ª\r°îmˆì%Âô Ñ\\˚àÀ[<çò-N•éñ2˚‡¥ER0m˝Ø∏É…¿Ëªjö—ˆ8t…ó”ÌK¸\r±∂ª?◊G*§znDs&UèÒCî‘É˘n},≠ÌiÌ\0vıï_øl\r≥‰n4cyp∂ø}¥Ì¥%4¯πmãb&+uvB¬â®n5⁄–j¬ÜAx3fùLï{–√¡ì˜Èi∆é9°nB†Ñ%E¬∂>È9d[[}∑3‰π+Öhl_õnLˇzÌ<Êﬂkﬁ…Ö7Äk-ó\ZêAÂAD◊§—`(2nZä\rc˜ %ËmG‘Ú‚Vñ@m‚@vT‡˚IJÊKn\\ ˘ê∏ß‰/Jﬂ⁄-+‘—\rŒX*Jü•ÑÅi˙HndkË.ÎCèz]…9fi0⁄Òﬁjœèù\'Y¶GØ˙g>npgúg˚zÛ g∫5Ãs.n5¢ÜµLåW¬4ú≥±nq 0«#ÜOÇ}¿\"ä¥EäNÑt≤û!™Æ©CÈnu‡˙–π÷oÏLœ≥¢ÛSoÔcoUFaÎ˜[â◊±ﬁe\0\\n£TƒâI¬ËòÍÔví‹ÍyOi«í4â™Mx£ünÄË≈Ë-≠«Qù1H.x(j’´8ÔØ«Xﬂ D†¡nÅà!∏5]Ú–Xˆ¨Î≠õÛæËS„;⁄u<}3U8ﬁ\' nî-áyu_¥æ\":~Iï8ıœ*2´˘YãrÉ¸„5‰n®Ï;‡NÊ9Ä@I-≈zÆÃπë§>·ôÿÙÅGq≈¸∞ ñn∂0ÌºùoF!ƒV_1\'ü•îx®ƒhs<z=nºØÉj∏ùw€c√=ÿ—ò˛ZÆ7◊VÉ=ur˝Àhn”G0í%E(G&‹WXÜü1t¸F!∞£–›‰–nÁÅ¥U®€ƒ˙®¬¢’H¸»ﬂ•„◊ZOÁ“ÁhÙ?\rn¸§i…L&MŸòx=ê≤ÿNì„f[øy=Ò/¥So+ÅùU‚Y˚›µﬂõr0~xÜπOs§,2ÃwoùÇ∞îöhÊèıQd¢M¬\0Öé;H’èÜ˙ùpÔ‘7Co\0àêEîœ≈§¸Cw  h#9\\ÈìΩØØ|ˆÀı›o˝E¬≤tQQbo\nÆ˛∫ÔrÓ°Qq⁄·\"Å/±ÇéÖo2·ëq˜\"Î,Hfî!Oõ˛◊¶úÊwZ=P¢Lo5r·ö †‡+£Æˆ“}æÙù£äoñ38Ä¯JÃo7\\¢j¢¬UB/Ì˜O©øÓÈÓÖ4˚D`0Òÿ`/Eo:G$†.¨\Z%Ë©–ëÀFõÅíF™hÇS¡ßuî<¨oKSÒ€c3Á÷˜ø˙YØWˆ$€«yÊ6Vl21@ò·9¡>ovQ\"˚òÑåìc4°ÖíÏyIΩAR›È™KSUoëQÚ÷t\'ÑÿFÊOSíçê⁄ò€ãπU‚.R˙o≥êõ}\nÅdâ∆÷ë´%?êêÑ√˛MÄÏõ™ı§ˇ ;î∑oÀ◊ÖøCHÀ˜úÄlaË∫’ò˙qﬁnãF}“˙uoﬂ¸…ëE+øwæı–—dôcã#œ{ACÓ\Zg∑oÎ£÷ëÁR‡`#¬:Ÿ÷•6d«àõ8Ô˙Ç–»\ZoÓÛxı‘6˙ç€}DPˇ\rMòbË¬1aı¶ª⁄|i·NôoÒ¸ò\r1d._∂πf/Á7q‘AåEºï∏íp†W|±bÜOÖù<f’c Î#_V¥»|Á\\;˘ZΩÛp\n}\0™]tt!˘Öx∞ L\'mæµ,iŒÒ«f–K#$sppmµ+⁄>„\\#J2=î)Ù¡\Zÿ’X””Æ=P	~rpì%h¨õ‰§‘7®=◊AP∫Õ¡√c(@∆ºõp%{éerB›Î⁄	º¬Ö–d>HﬁKÅ5úÕ˚¨-c1>}p(%›x5IYÈK¸ÉùfM§Q	˜⁄≠£L_:Ã˜Gp+¬4È”N§dñ‹J∫u\0í5H{’7`S_FvŸË⁄p7RVäƒä:€^LÓ©~ÙÚä“ª:‰àÿTWóéWp<D§ 9ëŸå«	†DpõÎH2Ü°ïLReGÅ˛M´pLdvÔX3\">Œb«ÑÑYÛÇ_[MÄœµ\'pÛ0ÑépTc åOj-ÂŒ¢	sujÆî4˚ØI˝TÔ◊#∞¡Çpk∫ÊxËÉ—•L“ó©Ìî)ÚDÓÃAÇzãYÄn±VÓ8÷pá~ûÁà√‰å$\Z˚tB›@gôZz^L¶ÈÕ•pöày¸¡≤ ˇJz\\äEµÚåH’†ÎT`\nìàó«\\7p°£ÌΩ“%Ç—ò»ÆW‘zÏÓÃÄ+QSèrÎ=´∑:¿5p©Yò—π!eÛu0vç˚ﬂ?.j˙π∆[Ççà,ƒ®Ü!ïp¡»m£”ò¥D‰÷Âﬁ.uûìIdn¿∑Çπ˙1wp =DY\'cqãå‡∑≈≠gaw O¡a<§;÷9ˇñpŸuÅÊ-iéÏ,⁄ÄípüÒW√çÁøc}h ¯påpËÒÎ‚2‹Wê“|‘[MQﬂÕ“ıëWwëv$|≠Cp˝ﬁÛ+¸∏àL“˙œÎº‡,˛Wy¸4m‚ü|C¸®q«,ñ\0…:„>|°´òŒACòzﬂ¬ΩèÃlqgõb–‡Äa«–Ò¸–Ô‹ˇˆ,–O„©ñ%ÂVìq(òóFlÃËãónjp°Er-R~¬O‡øæSN+êKq*àO◊Dûöl™Wç2aÎﬁ\\,D˚%1<¬Ëñ‹≠Ô•qq.\ZâkÛëÿÄEÖ·∏€#Ê…Ù‡qÇäŸê£\"ößq=Î1Æë#ˇ;∞°π+î≤Ÿ\\^Éëâîp∞$∆˘∫qYä3i\'”⁄Gõ±„¢Cñ?o(˜ôòÄê\0\"+I}lq[8◊ÚdıÉ∏Ëwå˚âﬂsòõ#≠b˛j:75 qcO2v‰h°Ωˆç1(˛O2¯g	_X™≠ƒZÍUqi¥¥j≥j÷e*ZÖµúèHG[ƒ?=ñ?jÏz‘ÑFaFqzLÚk√\">‡ŸE∆∞z∫xª·QÁe6˙¥ÁπÈqz˛+£k◊êâFz¯3ì”7-∏R6>ã≥Èë√‘#n&q}§bNáä∞O¬núûYVÅ8ËYı•R3SHâC\rjqëºœë˘˛\0d‘@–õÌà0lª,ÁÎˇë¢÷¶ËtDqôCP Œ!‹3ã”¸◊Î–∞_ dã	«∏uuñÖiäGqùª YÅå∆±Òe$Ô£irhNF∂I•lÛä¥,˘oiq¡Ì £uG(ÎäaVËÖê7fÃÈz‡£ÓÒûL∏mƒ≥q√∫∑Ÿ´&Ωı’UzèHkãoáñVﬂ»!+lVåO™ñüq≈‰Ô‡ŒóvCFÒá¬0ºwá◊/Qcáò}/[∆ qË˛$Õ—1W÷ë˚∑=ñJ=<®¿ë ˘Ì-\\#∆¡Ør\ZWËÂ	‹ød,÷àˇL_@º‡J£JA®pb\\∑©r±<ÃKßäÍe˚éÌ2Kø≠{E√Öò∫ÛÙÉOÚr,	R˙BóπìfÊ0ˇz^ä*Hßa*‚à:r4(^0ÚøÕˇFƒ1∞¥»∂s•t—\nr¥4πŒÛ∂rH‹awVm≤«7Àc≠:ˆ‹êÀa·4Â€‘{+ï„=[rKX?¢kz^CÖÃà9X\Ze◊˝FèªYé3ù8á_˝rV€jï-≠jnŒ√[MÕÒw\n=p…≤≤dÄ4∂Êc⁄œr_!€·•LPp«f<vsÂﬂ$‚\'‚˙î‚§ÙËorl[M√á\'íãÖ¡≥H´$ï≈›πß>≈Qü_ç‰πrå‡¿	äL\r∏-∞\n}^◊\n)˜*„¥„ÄÜê–Æ\0ÌººrÆÂbS‰¢àö√%Vé»üV[9önΩÆ!ûÑœèr∏Ñ’√Y«ÚË\0òjÂâ˘o;ÀŸq>w–,‹uûôrÃ˚¬˘oZïÊû`∞Ôa%“,¸@∞∂ù˚H\"J7Øxr”mÑ\"ï]=a‡n$·‡±7-j\"≈›\"–4)NMrrŸNP_;Ê bàÅª0€f»L\"9u°ÈSá≈Â«,rÊß;¥ÌÕ/n#Ì~ÿÜÆõó¸™ÊpÖ$`ÕöºW}>rıQ[°„˚äOΩﬂﬂGO–Ä\'‘òLëóÆ±ÀáÓrı]¿`≤8b´˝@ºÈ#TÄ„éFË\'w?›í6r¯¥ﬂÇŒCZˆ‹ƒËÛÓZ{¡ LÜº!∂(€ÓíÄ≈;s‰µ#a\\±ùîíÔ˚û8QÉ˘0≤s˙l }ﬂØ]—6s\Zrµ:≥<[◊Rdô}:≈Yd±y≤(ã—©PÄ\"∞‰Ps\'˝Üj{ıFC‰∫hô®Ã\'GÂÏMòg0¿Æfûs( «8°(õ‰É\ZŒ>e6°Aà®RüQ!3¥æ>œÜœˆs+à\rU\02‰Â≥#◊\ZÅ~ºz››ÄhËsÓòçÃ´s.CU®±€†ıΩMÀ^≥oSÃF8‡6EÔ§Úª˚sN–lD\Z5ÃÇ¬2øGÜÍW©œRΩ•´ªîFƒ’ñsP∂á‘3„4´	5©≤>€≤#√v◊ÒŸG‘ùpîsP˚‘4åÕÆ4•≠ºqoÕ\"ˆF\\	^:QŸ∑ö—sá˝#X€ñ+pFXT%?ú?•¨crS°yNŒ∫&I˛\\íñs†àî_£d¥çYeâkûP∂(¨HP›6P¥O˚s®DVãiÊöﬂæ˝[ûb”*˚aóVaéê˝	Ω ¨Î¯s≤øUîå$$ÒﬁÊÏVÀÚg˛œ—»b\"lx∞m ‚s‚¨8N\ZÁ0ÂÇÎ-∫ÕŒ1ˆ∏…¬∂M‰=¸â1±˙¢©s¸2óil)1‰yº˛›j§uıHuM‘t5(IÒ:—E[t\r{÷kÉ?iŒk‰ïC\nL„ÉëbÔÃá›WytØ*ÃΩvdW„;1!lH≤«–Ï9É˛\'<´	C√ftõlTõ^¥‚˚7«Âá?1‹	[‡ã]®¯É®#TÕ#t:sêr„∂9¯’ÎºcaÀ>˝S|0ı‡¯+/\\3ïj@tBùªÀy¸˚∆iC8Õø™ûL4õD£Q˛ÃÓ\0Ωoz¶tG=9í\0ªìa∑ ÆúÈb>\ZÄOôzÚòcåœı1≈}tIqÛ⁄|\ZG°wP’8±^6¬ıeÖNŸcìf	ÕtârX#\'Ö˘XlmRq{Ùø8∑€8FÅ˘‹ÒÄåãtôGV&^`∆.^2â∞IX√‘&$÷GÎ9â, MBÍt¿≠ä2zËv¥f˚#¥Å†€∆:M¥›‚≥ë{%t≈…ÿ>\Z/A„ÊÿıÅ˘ˆG*∂Åƒ6åe.©áQit–ï∫s«)W≠j≥DrºôDi∫•<§ü6…Nß√˘Ft÷·∏π⁄¡ñ]ﬁ∏∫Æ·´HÄç˘ôZMm°ÿ‹ıã⁄mu\r}[íµ-∑»ô◊B–˙U`BE‹rZÇnà»Z?*öu´Öú»fÆKÏœÛM∑ ]∂Â=_mA98ø\0©u Nr8ƒ„ˆ≥\r1ÌÊ\'Ñp{Òqbs/˛ìæÜ•u#gTd˝.Có¸¨≠ÿ˘ÊYg†–ã±UWûÊa{ıu)÷r◊BÊ.Œp˜ÛcÅì=√—t\'Ÿ◊s)πë”<Iu-—£ëºéAHá¥Z∑ù64ä?≤—ß:·†‚¢}u6,]Â≥g¬8M˜ƒUÜdÕ]8µ7ÃNX ¢©â}Mnu?|éPŸ4¶ôTVÏm+ÛÏsœ¸®˘îqádm~)u@?Óõ‘í$p˚*Ω%«À„∫Îr(b=œùAÈÍóiÚ‘uÉÄ•√=€¶µ¥ÑÌRnJ+è^Ì„Z‚ö\'=¿›ÌU\'åuâüÇπ@“¸›jÒh¥0/Âê \'0OØMuåDŒú √ßâ1˘Ã1{ÉÇiõ\Z§-˚jÅªø¯ò–íuö¥†]ëâ$)Ì ≈»ﬂwÿ‡Ó∂5h1#}æ◊8tº\Zuõ;rıäj˘ˇÅJ%© ∆0$Ω´üUïCÃ:ı\ZY!uúËò#eo^3˜ì|xà°ÑÍΩòƒÔûÀPú™uù	Ñù¸x•”¡–{	_E‡ï€èd(^‰ö6u˚èıôHﬂ‚U?/:Í∫®‰Aw\0≠¶x2⁄ö˜p∆>Bv\0WbmA°[∂Î8i°E‚‰RøS0E¨`7d‡~õv\0«·πkë…ETvè“3dxìe ôÖñ\0z?`ïºúv7cö\0|ºq[ÅjÎQâ[&L˚∆óøPÃN˙¢lÅvÀ9˘\ZR\rÖ2ÙÛ@¢‰]3ãòz#\nÚÔøq\r3ævê–\'Ê2–Y./T°}ôt b≥Hêä<6⁄Py-‹v»œxgÅgÔgy)Œ¶ˇ“∏s!Ô@XQ¢Rc1äFv% _ƒ\0–b$më&`ÎÛñ≈(˚=ôm<–b\Zo0pv.îèŒ°W®‘ªlqøH—”oã¨r\'´Jm7œbÂÛv26Ü}€ûË‚á\Z‚\noãØg$‰$•@[°Có\\Vv3)<™â>˜ërÛ∂y(Lº1¸yUçÈª\n©v‚f„av4Zﬂ}kØ »j≈¯>X“‘ÀöπWR/%jÜ5t†ƒv6ú\\„ÕyvT\\M¡åÚ	FQKGÄu0˘Ìˇ‹v?HmàÆr–qø\0˛Löë§‹>=e\nS®ÛåÚRãv@n¬LÜ÷Ó¢!ùrÎÏoÛÓ\nÂªÓÚµ⁄∑π¶ƒ∫vY¢<ï\r‰¬4eö6ÒoôéßR§˘;’êØC;◊vüÔéÙ!û≥∫˛•z…ﬂ®∆A1ƒ √¸‘`©[äÒ≥-v¶”Cùêá	aŒ\'Fﬁ;Ä¯Ú±z⁄ªî(eJÌ±Lv∞;aˇ\'\"Õs†‹{ÑCt±(~Â+Ú~muﬁ¬ @v∂|ÀPu<>õn4p‰R.Å˛„ısI<√‹¸õØ¿˙vª€2·œÇ¶æZ˚ª™7ªì∫QÛ˘˜øΩXwFÄu}vﬁ{_5÷Ù[·tÀZ;a+Ãù§Xï\nx\\ÄıÚ&vÎ√ˇa-iQYΩ–hJt´	œHiÉÙîÁñ2&Éi~vÚÎè1RÅ C÷Öm≤⁄◊ûR»eV98§¨Ãx˝ﬁßv˘°=}ÌÜ≠î:vt!)ôTÇ&î”ˇîÚ‡ö∆Ù˙4w◊†`g0Oõı˘±Ö!í∑£+ŸU\Z4ÕˇjVΩ9woHpıÆ¨Â˘›√éí \"M^≠Y\"ŒˇÉ˘SﬁÔà’ìß\0ÄÒw∏A!’(vÈ.Bc?[‡ÀD\Z;vÖﬂçEîU•®w&C}5QŸí◊¢ˇu…<ÿ4Uw†’+hÒ÷›ﬁLÀOåw0?±çùp∫n~ê(ß3e4´˛˛B¶!Qw∆ªLbÆ∏w<[ÀSˆ%lÜn,Û-S¿~Íº]MDπp¬«å√àµ®w=c^©:¬^Næ[∞é ‰Xì% %Nœ,Ùw@Ú†c|ﬂh´(≈ÍHz—X[ü_∆:Äxç∫0É)KwDiˇg≈k\Z#ºÔVÁJ PN]ºª	Y\\8àd úwHoÙ’å7Îˇ9lÌ\n!ò{Ó¥äO[OˇZ¯jwM.ÎÁÖ#S÷{–.°õÌúúΩ°D£G8Ûq(µFœ¿¶wP±ò:B≤!õãnÉ®$dŒ2e∏„|6”π—Æ:0≤ wSƒt+∞\ZÔ¨ÆHH±«‹∑z†HÑñoÀı\'3{î¢ˆw]<Ω	^ŸJ˙dOhÑ¨˛Y˛H™◊ûÒ£t.‰¨(@,wf∆∆øto€Ê”ÇXXçGˆëÏ\nFƒúcIsﬁ*ﬂ§£wlôE\'~‹Në\r4dAÀéØ@∏7j;Ì.°öW[gΩÇwÑª‡G¥íTƒà„—á_§|\'Kø\r,Ω„#scwÖqÔïX¶9ﬂ\0®¢™ß˝V\\‰¿ïΩÈ”%«”twé~B•Õ£a¬’®1—‘ù°u?n∑ë \Zﬁ˘ˆ∆ odw∑èc4y°™ÕO˘.Ã¸»~HóΩ{Ê_ óÜV–ìøw…>SaæŒ›	¬?ΩúÃúô’szú∞ßæâi√æwœ∆\nåàÌ~;H4‘«ú„/t‘Í´ˇ≤_vÓéi%]”w÷^qπà92:çËÅ‚ß◊_kﬁÊ√_]§z`äû=*1wﬂπx¨Äo\0¯Ÿ(¸¸èø+%ı5ÎBú∂BSrl?!Gw‰ü∫ –‡Q∂◊~ u®Qí‘÷4¨1Ñ\nx:ÛüwÂ/b›±\n]¬\nANäA∫\0π€ŒvLÃÉ°GwÁ∫√º}\Z—O∑gÅÔ« f#‹Eπ1g=gÕRzãñFx#oC:[“L6làrÄzç|w¥«3‚:´BÇ=Ω•ôx\Zù€ìEÖû°\\k™!\n\\Dâ∫6∞RàÕ‹~óxwÿê^ò”tFèx{∑Áô÷¶ÛÍ7Á`≠-‹„º»ÜéÌx3zè	l«rgRMq¿Ë;Á√¢ºhª¿§0¸ç:”∂x3ëMÈ1´ü˝w:Ã™ëx–M(Úy/è2ÆÀ,x5®ür#–áXt∆%JFCDá£±˚\rŒúÿ\0üè…—xKPÉ”Èÿ˘%›Lìa⁄°⁄ÎUÃxˇ∆\nºGéUƒT‰xP1vì£‹’Àõo©‘0{œW√OÜI- z≤ÔwCE‚xh@jÜ±AöŒ≠ÇÆŒ∞‹h’YÚ*~itÕ\nåwÈ±\0%xëèQnπgøèÏgW.6£Yö‰ı∑z#÷Iƒ≤´xß’$á‰ïP&’}Ùë`\\QyGpr•Ã*}è9YÇx≈∑(ùÌ≤µÔG*&˝»IAvú—Ñ_°R!á?àx»à\'eˆÓ≈é™4m#≈€8‚’u®∆Vëh˛ï˚ê©xÕo€?ë!lN;8g‹_Äπ[j◊ú3&ŒÇq∞3»¶Qx›T¿ﬂ»±—nØ^«¿Jn\rC@˘Î‘†G˙´\\xËˆïª¬SÜΩÔá¬˘n]±ﬁBÉÛrÊΩ/Û›u<\rxÙóÖ‚Y„€\ZÜ>k™éE∫Ø≠MóR6.âô‰\r[ºÓxˆl,BÍ≥%Ê\\∞áO!öÛæÆS<Ê≥yºø–R≈¿˙x˘‘¥W%\'7&\\az<í AK◊o–%†|7ùÎØ˝Ky ›£∏x#\rˆÎÙjŸ€§£‚E‰TÊCúIf‡õnZy-Û8≈ºã<€·¶@<]Je<øw^€Ñ‡ΩCY¢0ÊB≠y8ãV¸xê^ÑÓ∑°àÓùk˙Âjì∂ONlÏ\"3`áy9Ë÷t≠˚Ω∫$ﬂJàf≥•∆üª◊Á≈˙—\n[dáwÓyK6≥®h‡ÑÆ+>AÓî¡W[≠Ò°˙‹◊,Ô1/èœ¡y^&	Ü‰\r&H⁄3˜ªõ‘\\†F∏£[5≤\0Í∂/yc∆++ÅS&Ía§1èg€’≠Ûà[y·óÉƒ©ç•ü∑nyd-f—r\\·úï>X≠1Ø †-Q®ˇNç“yr:\'›?e—OñºäF®Zª©´ﬁ∆Ù§ËØÆ\0û3•yó8eÑó˚ˆ‘ﬁ›÷Ê(ä¥ôó¢@ﬂ$ˇÚ·ﬁk(\Zıyó„àîã4…t¨F¥KÚ†ˆ§Ô§v9ﬂgˆ>M@Ä“«yû¨Ñâ«ßï8=⁄uÔò<≥&(3ãeå¨_‹`\0Ñ∂y´UÒbâ\'d04¿Ítâãoπ/\Z+àÒ]!ŒÛËdã:yÆ\r!≤í\r¥s|‹∞køFÕÀˇªa2⁄º@≈Ó\ZyºWˇê@ï„ﬁÁ√Ôı]˚aÌ¡˘∂ıX«%©TÜy…‹èuº~Ï˚61Ú´Z…Å\\ˇ/[Álá˝Ÿ¸(yﬁ L$Lê	rjôk¸‡KÉÙ˜áÏÙ⁄jVx\0I—sﬂzFÕ+ä1¶@ã∆,¶„õåÎ0äCŒJ£O‡!‘zãéÒbˆØ™€Ë¯≠Ø÷¨€≥ygæFbÁeE›=∫ºËzLj≥ò‰R3Z\nÜ\Z»œ”Ê–ì(·nf“\rÙ˜∏z$p~Òª=P€pê\'íª·ˇeyπËKèè!v^kzPø*$	ˇıe≤(WI!ñ[(ÑÙé‹ö>< ∫âÚzUm{â⁄øY>pé¿÷•x≥w\nTœmwÎ\Zı~‰ÏIäzÇ˜eàe `‰~éˆwÄ˙ç˝„ãÚºG$us4o≈ç8zí«Û$≤EÜg“„∂gä9öK93)UÛòπ:‘Sz¢_“JØ?Qı)∫î·–œê–æaL^„;VêΩ˙Êz™rÖœOU]§L›Wq$øªN–ÙAw§†ΩŒ›Nóz…\"¿ˆ|Ç5‹óßÓ:lW8]ÚP¸bN˛C~zÈ-6Çüé©i	F<>£¡íLOê<k‘®1\nòr\\ƒzÌôk˘œ§cæQÚ=í‘oJ)Á°÷\0.•e©ª2 “,zÙHm¨a¯µ‰~B ;@´˚lıâ\'eÕ€ºsD≈ë;{æ3¯ôlˆép™^˜3ƒ⁄k∫‡;–ÿ\nÏk¿˙Ë{˜†2ûw¯\rOH‹SÇu‹ün°±”ü‹¢≤ªõ•ë{u)ò£x!‚D@ü|àH«F—9ù›Bu2Õ\r<’[?{5˙y»Üdj2&´Ó =I‡‚U,qCî<¬mÀÛUòú{@ö‡§®$g+ˆïEíã¿‰ÙËg[rç3Ú¸é÷{EÿA\n≠ö≠æÏÅ˛ˇ∆ÎÍ√Œ√	 ´6ìQ`U{Mœ3±#„Ù_B?nŒ˝g≤Ï—<€vw-i{\nëÌ©{iä;|-#qYÊd_;¶¸QH™\\©µ˘ë™ßB%∫’{çsaÅà¿ºVmH∫ªï¢˚	Ÿ±+Ùrß<ƒ∏T;‰[ã{ôì\r≈õ¢9∞≈11™T_P,[D“Á˝:Ûø∆˘wû{¢n]÷\0÷àò›nª\rœµÙ…<ßwÀ∑X)É‡⁄:{≥Ñ,Çt„4S)h˘déå˜¬;èõ}K·É—1·{¿g/Ëœ\\ÃE«∞\ZËI|\'·ÑõD∑i˚ÍÖ!H{ƒOîWÏ=!Ãè–W\\\0vR˝ø™&ˇŸ~G ΩÕ–#{–©NÔ‰¿±7¢!QZ√\0E›1ÿÕ¶—˚‘⁄§!g‘{ˆ™¿ªıx™Pû®¬ *+™]Lâ‚í|pØπ^=n|ÇÖòmﬁ…{ˆcD‡1“◊\"D]]=ÿ…Ù-c\\É|]–oîõ(jF\'˛¿*¿∂¥·Ÿ°∆óÓEF$K#|ÂhÇ–PÏúi≈Ù>ËãÏ@ÒJÊ6≥–lQéM„ûÇ|#ïæèò°vúîÄØh`JOôAxÆùˇ\'º^∆|(\\âºQ–&jôã\"Üàí∑n	Ù\nu’€‹¡—†|4rc¶»êÀçDV*¿µˇæ∏{í3Fê¯|EØdÅôÀ\r∫q–»Æ#¸9∂ûœ\nÆJÏÍtÔ|F∏ùYÅ˜cê~\'øB é_ÔıêÅ-dlËº0h|QÏhç≈[ÅsÜob\"˝∂˛A†∫f/÷$˜Â|˝ú|U6Ás\ZJZ˝≈\r‡~5ﬂ‹∆™\Z|∫ﬂÊ$ÿ˘°›ö|Y\rÈ®:l_û∆ô=ßπ›§ù.M\n«◊∫ë*º|b‡)MGA\0Ã 3Y\0éÔ´ˆœQ™ßˇ∞ΩyLú=|m!ì5√¢zdlˆ⁄Ø4uOln{+∆P»;©\r|q‹7ríúÆﬂçü˜{«,¿\'áÃåŒ\næ¿_€≈|{Óèπ®FèΩ√Î\Z)cé	5!q8Ôc\\kpÂKÛ>|Ç&Îèï˛1¥`¿	ïïBÚ	ﬂNt-s°Û†e[|Ü-≤ﬂëß:oôá”Å∂li¯¡<ß¨aı+áúì%Ñ˘P|ïô\Z$“\"´_wÊB∞&iÿÚtù\Z|™≥Üù|õ@&çèoï|«X4P˚u@¶C¨o’Ÿ9õRåÀd≥|£zp-Ävºà d¸›’.ä,[\Z»¬|QÎbïF|±“uàﬂÃèÙƒ_ÌNac˝ˇòµ:-∑üï;|ª¸p—®≤∫π7{Õçê+•√ÙFÌ;”È} U§ù| É[√¬Ñ^BcxÕÇ≈ê ^à†@<=∑£FÚDœ|ÀÜê”∞Pó¿<’µ>∫‘DdA.“G}… }≠_|œÖzí·,–j=gß»∑Ù	éüŸÍ≤˙TF!w®d|”N!x®ê‰V$îW8qIA©ˆC]1!”í	≠±}^‰º\Z•%EÚ›∑2=¶õc˚ÏÃÉP˜FŸ´≈÷}ﬂ _Ç„ò˛Á‹ÿ¶bÅøq€å(h=ÊFÔƒº}CY“Ö≥8÷#j<Ø¡ŸÎQ\0∆ò:‹/∏D }DÀ	4?¨ºé˛sº∑.MπÁ*ã£Ó{T™»á∏Fd\rá}cã˙±[ñ/“NH j¸˚nÚëÇ√æÎLï\ZXêm}eEx¿ÍÌIã≈<∞ªgB\Z˘9˜skfˇ∑˛(h∫}yéÏ#≈©¢MﬂsÅsòë¯Æ·D£∞j\"Ÿ}{˛Äq}ïîPïd,ÿ_Pö“9§1∑+BwïÜ∆Füô~Mß˘} ûØ’4!œÏ ê®YÙ6Y%˚dXÇSŸª¨\0Gµë}€¬-6◊\'∞f¶nT†Y@ê©°y_{|né<«Ë»	}Âmô-÷+ë—vi†1æ˚üsÑ\nå™õU¢˜•ë8u}Ë)H@«ﬂüVbR\"\"Õ•ÿ0Å◊π„ˆo¸µkí®∏}˙åﬁ	WÄ∏˙bâ2·cf©HBé£yáÔu˘©P~e˝2ËÉ“Á˝4xπ`õﬂÈ‚Q¶x<C≠4∆‹_¶~\n-5¬RTΩ•˙•¯◊w4ÃÍÑ}3ì}w3&œy7~√CpÅÜæV_ê<ráZ¢˛JÜ˝áG‘π?Œøú\\~\"=éÍBÂÍª¿´éÍc¶†∞\ZÏë\rÆzôån3^˝~5:ü‹ôéµ‰FöÏˇìLWﬁˇπs@ÎÜò”NßÈ7Ç~>,‰O0FÁ‹ˇ2v∆F\r}™˜…ûìÍ¿kTZ;õ™”¢~DZS¶TÃµˆp-7ÍEev_ÒQyömòK\\∂åî)pã~G¢6ú86Í*ìŸÁ£¸\" ‚ßåûf\Z¶=^◊\r¨ë~PjgkŒñ	¸ˆf:ßã\"ŸvEÓπ¡y0—s’ﬂ§£d~QoEŸ3RoJ®9>ÊX£ïËÁŒµ«\"ÿá‹1É~v›~–z¥S5çÑﬁ»¢´åiΩyàÆåXÒp÷dH~x´\"&/Ì–‚€V§Ú¢!∏†cªa›6 ∂ft…^áÿ~År ßáàëüd†ÜKHqü·ï#Í%¥YøZÍóâÅ~£±^4ë«*∫*Æ’:±r¥…CÌsÃ˛%uKhdÁ~π‹EªUa·éqRh}üÛÏ‰?£B@çŸ:¨ë‰∞ßÜ~∆Gl*h$*V´{Mπ&UlƒIæ\Z\\ﬁzí®ô~‘;¬YÏ§õ±N≥På«¢±lÙ≈&©4êÁú%\0~‡…)+:ÒÌ ô1≈¨ÿà\"la@Mπ¢åS”Ωk–√·~·∑’Ñ¶:à◊Ÿ´“⁄\rÖrq03aÕΩ∂Ìˇ‰!{‚-~·∏vóú‘<πgz_¶Áﬂ›ë·	RC	~û5B[1E∏…_ıÆÔ\'ÉÏ¿•&xmÛÚ†¯fÌïR2Ih+Nq$,!%â>oï5Ù&qú⁄èÎZóq-Súoà4¶P“«9Îuõ,õèà£˘*·3âÊRÆì WÆI¿D[1h—í’3ÏòX?”¡?$∆g∆`ƒﬁ¿‰∂ù`£†L\r9;`\\tMQ˛¨Dj7i¿ÆDñ¬fbaÍﬁ9Sû¡%‚,#ÏÃîæ§œÒÎc£~rÉ»¿«r»w¥CpÅMÒ≈\0©êwô∫ádƒJ™ï]@¯∆»›‹∂§eu©∂_≥Øˆü(ü‹®ujÁˇ¯´õõ≥È–«pΩPœÛúåÂ5\\Üñ÷å˛(◊D ÷r¸àÒáá≈“3Òf!UHûéÂQ‡^3˛Ï\nìµAC™ìí´ƒ·sˇ§uñ<úfï8s“ÛÆlãp›Z˛Æ(Fc1˜\'ïÊøâ«„ìjÚ$cFÉePnaº≥ﬁ¶Ü@Ù#âÄ\0$6i2‘nÏ…tôÚˆ_ëo√ﬂ√vÕﬂâpj‚õﬁOYvÄqQﬂ,|‰a6∏ ÌË-=S÷çæêIë™pd÷ÌÄ%_#µ˚ŒÂüÍÔkèC”†! ùÖ!Úns`ª)^aÄIY\0πøˆ¬1sXë	vaC¨øHÜ‚ﬁﬁØ9ŒÄLÓik˝–8>:Gıs†≠‡^Íu`ÔJ≈=TŸN°`‰¬ÄQ5cU±¢–Fa=ÂO»Úèú≈åË‹∞¡TıÆ\\hÄXÖ8›”Á∫GR\0ßz_B√?<(Ù–åeo∑Äu…:€@GoÎ5 Ìºó{`ÒÂ∫çdQz]¿á<ùÄ{#πGÆåÁÊÊ	;Äc¶¶¬∆\\73!“}÷\0¥20ÄáÕåö„ØBì§iø\\5,¶k?¯Lâ«ä*_»ÑÁ˙Äâ‡b«u%dN‡¨‚v3€ tp>?X?Êl:\"ÄòÄL·Tò≤“ò$xDsö^˘h_!kCª\"1\'¸ô_‘ÄúxÕ9êÆ‡ÇlPÓyf∏Iuîáô&πpÀ3ú°2áæ∆Ä∏ÒOk—hê£WSéb‹ﬁ^S\r†)Ô[«e˜D<›ÄøùÓÅg/{>Ã\\IöÑ6◊R˜‡ß5.v˛ﬂã∫∞ Ä f6àØëæ*ü#6ì·ó⁄‘:ƒcKx:1#Ÿ®‰≥Ä›Ü=$ÒºOË/Kf‘∫≈ÂñÑ>∑8~3>◊çë√ﬁÄ˘©∆\rY3æ°5È)◊ÙÊÿ>FSæáÀ=àè(™Ä˚k)πYt◊ï‰©ã≈º8π]cí>%⁄9\ríÀœ§›ÁÄ˛ñfzªõõUÁ¢‚œ<ÈMh™&EïNä+—Ä€Å˜ãÙ–ìH¸ O>ﬂ06}ˇ#¨˘<Qì°Å˝n∫˙‡wﬂ–ˆƒkˆVY‘á/ @ÉùúÇÅ¶—ÎÚ|€Ä≤û\'&ZÀ•~o∆óZ⁄ñáÒ\'Ô˙6ÅgÇ∫i0B±<a†0ƒ≤[´ôˇ\0=…∆ÚU™Å0Ω†”-TK#•†i∂>◊l∂.¢Z0¯KÅ™·]åÅ<äíl>Ê&ﬁáCy\Z|W∞¢Æ	Y|z>6à€}ΩøÅ\\ ’yÒë´\\ñFe‘S#lt^5:~à/ÆbÅ]¶©èä{Ù© ˝.\\+˙B· ¿†®BÑ∞ZÂ«3®#Åf4.xÕi:àpY¥Ad‡åBÕK“ü\r!U3J›ÅnmÉ$]cm–<rû,#ú⁄\0É!8*J‹1‹åCì§bÅwÒ‘◊yóââp√∏∫\0EIntUÊ]◊∞hãÅyRÔ^£Û2êÃv *ßËPL<Óãˇﬂ≈ßÈS“ôÅôw8ÿ´‹áSi.=$#	≈bª/:›LVì∏Á‰Åú{l©¥_ßÌ3t ÔØ¡ny†@„8\ZΩfUºåÈ[Å∫%™µ Mâ∆‚Ìú;\ZL“†·πj∑\n_ÇöÅÅè0Å«ﬂ‰Y‡<¶ôT˝ÆiÏº÷¥	Jæ]Ï⁄8¥N¯ÿªÅ‘Ω,≈¨¡—bf®ÜÊ`)A.?qéÌæ_L1∂û£”tÅ‘Áˇ4mT˝ÎÒìdã6ÑWoõkµÎ,”Æ?aÀGÅ¸£ÊÀäπB«7J?∞≠⁄nÒ)Èp)§=jk\"/%>ÇÀ;˚π◊⁄€íg%@tﬁlàçs≈›¿ÓÀjÍjÖr∆Çr6yZπ±˚.˜\\˛ÎŒû˙\0Øı¿?©`b{CÇªTD.fà0ál©∞ãø¢<≈xààÔCqZ`hÇ\"$óv¢∂Rã‚¯9„yÊ©€ç…Ïùo4Ûh:	\n°*Çf∆ä2ï◊gnÓÅÖ2I‡ {Cì[HrA\ZbÇÇ˝—€ñ˜‹ÜlWœGüÒ∑UaÚ‘˙∂ﬂG˛ÚËb{\nÇài·èÚkTvQ4’èá¨˙»ÈE\r0EÖ)lÇå`Íü&@Ú©ö∫∫`¸\'a1äâkÃñVS+\nWyÇçˆÓ‘ùMâˆÂ9>¸˛±U:æ\ní¥∆’¢\06Çëæ◊\rªQ\\°lz?9y•òòÅNπq©ÒJf0€Ó£Çó[‹√‘;P\0∫Ω•X-\'*õòı\0Ie#ﬁ¸®Çµ“C—Ô¯•¡/–M¡¥˛Ñ”Ë;€K\nAt/ÜcÇÂC\nò]«\\ÎJ√ﬁÍΩÏﬁ‡=Ø∞\\\rRqÒ•L†ÇËÖ™pÁ/àÅŸƒ§¸DQ.πûG∂“»ó{ı<)§ÏM¡PÇÈ—|Îƒ˙yE‘^8≤€}ìÓﬂÿön˜ä∂t≤&OòÇÙ¯8(dúÛ56GJ\'C€:R,;àZ,ú\ZF«B>ÇÙù…,\\§	XwÍÕl4ˇ•>ëÕo¨Ö‡\Z»[_Ç˛6ã.$Kyo_3DÎ&QB≤••È€2ﬁœ\0T˝\\\'_É©ME√w^ê°Tüw[X´j4óô¢s∑∑ÆÎG⁄É5±hò)Ëp\"Kº4cÌ!\Zƒ…≠·∏>∆˜≈$ÓÉ<\\ÿ&e˚Ô¨\nPœ¬\\•*˚Fy¥?°ö|·IëhÉFIXÃFØãHÂøE\Z*9›∂◊£/B°ãâÄF˙	¬>&—ÉJ⁄5õ4«…«ÿA6ïì#\"b2SÈvJº·@À‰íÚ{ÉU≠1ÿù⁄∏>)T}¬Ö∞4¶˘:∂ÿÓ4˚Sm≈˛ÂÉVàÌΩYWÿ >\0\0qM[Ol\"o Ëà≤3S•±\r(7É_ ËªY£o¶$öbµÙ∞‹§Ïôrﬁ9á´2È4’—?yÊÉÄiÇø>~≈f±ΩKJ˙ÖÉ` ıÈÙ⁄3Ë‘uxÒîEÉÖÊ¢ñ^’ó»cÀ|ß¸‹Ÿçû4‰|c8¨\\√û9YÉè€≥%àL`N/~s‹Ü4û}?\\QÓÜ∞C„˛Ó€`ÆÉêÈ’èØó&m&=–C}÷Œc¢îS<%¯ï`¯˝	É†¶&˝∆IØõEib‹±∫èl™ì@!¥€‹C¶É©◊\'0:¢IÈWÅUÑsA´@;ÈˇJ/8‘q⁄™Ìg√É∂õlDAƒ◊ëAì=Ú˛<û¨Òh9)ºAlæÖœtÉ¬©±Ç|yg8T:5,u⁄ÑFÖújX4é\rW<0Y∞Éﬁ{V9ã\\.ÃIp?•H[ôsBÕHˆxGq§Zÿ8/ZÉﬂ%πFw< Ë+-;ÂQnπgpäéÆ˛’åplÒVˆNÉËÁ´fÅñõVV.|ƒvX”˛ïN¥∞8D◊â«D·äGÑ\\ﬂÿŸ÷I€PÿG1hFYåâ‘:w	ﬂbd2¡3ÃâÑgïB@∏]B†ÃyÚ q†+6∆Ä=¶íí_ÄõÒ7Ñk‘√y¬~ª”mË»ùÂ¡G˙|F©¡¢¶:Ü9ü4ÑuZ7>f‡†ÿ´DÑÜóﬁi‘«Ugp˛Ÿ©v‰™Ñç“{Î\0˜ø/¶¥9\'ôôúx~∂≈—∞f˙7ÏÎÆQÑñÀäœoÑ ,´|Í$˘AèﬂåÕù¸`§ÿ…s’›Ñ¶W_¯w√\rz]ﬁ∑v¡X÷Ñ#ªb£€xNŒÌÑ¶£÷qâFL˛”g~~Ï4¯U⁄ü+˚\r¶˘ †∞ïÑ¨ô?Œæz‹2l„å Ò=ÛÄè!ˆﬂ§$°x°î}Ñ∫‹‹Öˆ∫e(86†6gΩPE¶∂tµ√å	˙s´YkÑø˜˝ú˛Mc««≥o1+çYúlÁíª©V#º∫ÑıÑœqœ´Ôp_ßjßõf”?8omc5÷í¸\\PM%Ω≈”’™Ñﬂ	T0JÒ\0ÁôÙÕ(=ÏD≈*¡€òÂÂ”µ>˙âèÑˆ\0‚µZÃÎ(◊Ø§èŒÇˆ|†Ó∆\0Ç∑#ÖïäèÖ‡¯á◊˝ß~^y2ÚcÛtËâH¸&øDO\r˘¥ZœäÖ≈∏⁄l’sÉ@0jd2S*\rÁ¨KÉßô≤≥åà•âÖåT(¶≥gí.¥ŸÉßÛ˝Åt¨}	åzCS¯0 jπÖ)w÷dâœ‚ÈVﬂÂú•∂¶1À”J{ÙÙhV ÊÇ\'ÖJ”b¥-i.9÷EA˘~ü+|%\0ùˆÖ¬Ï˘ä@ mÖVëw‰Á%©%»:†3CQ#+g÷Ùõ	ïñeπ}◊ÖÅŒÏ@%s5F≈íj¨fpvÒ¡ƒG∞∏ÒV˝€¸ÖåMçvx¬Í–!!™à‡ÓÏ90M÷óÇ•yµã-t3oÖåXD±»wÂëX¡‚≤ º†ÔáxT¸ÈÒçA]WêÖ¶æeZ\0ópõÙ°ı7∏„ﬂg†KÎzXF¢ÍD¢»kÖ©5pB˜éÄ#ÌéÉ‰:Nø˛”p[∑œ»Fdõ*nÖ¡¶7√dÎ∑è1\Zh6x:i6ìûLf §`O˜zÖ’~ø”\\êåâAj!û^Eê•h©Ü‹◊˙{è¥RP¢Ö·áhOÏã	ˆg÷p™3∞≤X|)F}hæ9P§è·*Ö˙âK_	À˜˝&Z2Jîi;Ès±¿b∏öÖ~~:¢Ü~Uwœi€´uEôfµIrqÊ“ÊpìEÊW?úÜÎ #É‹à≥*“\\†´˝©f´}∑’™Ã±m€ΩúÜ24Ûj∫i¥›(S3Ñ§\r25y\0≤2yS–°éfU≤ÜNî…ºJA1\0sP‘+?ß>∞~y\ZYm¬¯ûp‡5Ü\\ûçåsˆI[Á(.ÀŸEƒ5 Mh%I¬Ö“L*ﬂ4y@Ü^xÉ>ˇ‘Îp$÷!øpçÈä[ˆr\rf^„nú◊EÜd∫fæå÷3]°bv<%pIHﬁ: ˛ÛôW=¬ÆŒÜi±\0è©¬˚Fs´\ZNñ¿˛Ã‹aFR»´â?|Z=´ÁpÜÉµ˛πU)Æ\Z±ØÀˇº…!¯õåÅÅç:æyùÆ4ÜÑÒDY\0˝6»)∞√‚|ö’)ı0∏xÜ;Q[5Ê„SÜ…ù Ë»∑¶dTKà:oãÎ•V”LãßïEÇÏî2üÜ‹Î§yÈ°E˘˛6¡_¿Ç%Xc_ÿÒ+ò|V7ÚTÜÏ=’∏N…69ÿı\n˙pˇ´¶ê=x/NÓ”ê≥FsÜÔ/»ó‹\ZC™˛êée‹ª¥åΩiL$µ@øVØ_%¡≈ÜıDX∆+CÏ]éDØ$W+ìf»õyi><Ü\\ü4É∑Ü˜]\nÍc»«ÂŒ‹ˆ\réÌ∫∆Ê˘6Á°K‰∂-•}—B¡Ü˛«ˆr»(\rnÁ§b|8Ì÷‰ˆä“ö¢b≤á˙^+∆Úç≠ëMrVä5—»-\rÒ§◊\r†ˆJ‹<á$⁄jü°ßAb◊πæW\"0AEﬂˇêö…‡=c‚›∂ïG∂á/twvÑ7©ÏK„õ¥”oG«ßÑvÁ”Êtô‰ØaAXáIÏˆ©lÈEÜK‡∞—¶¯¶?Z£0JT¨⁄Úá‚·UôáXìîˆ≤	∂ﬁx6R\náèîaX¸Ç÷´5«F›Ê\'Ò˙‘ám¶4Œ@ﬂxú5‘g«@≈OÉ√s¨t7ózΩøîãQÊwáÄäôØ∑\0˝Â,É7á†x/À@69	≠–ä‹E∏*#äááÜÛ›/p?iÎQø˝k“g∆±yô€≈ {ﬂ€#áù\\o%E9¡ÒP ÀésÑæ]§ŸhÕÇR;b¶E:\0áµ÷7€&[à/=sö¯c“¥≈¿ÏL˙¯HÚDçÚl±áª¸C„bñÃ‚∫«´Åo∑oÃMI]2|ùP^<qD+£á¿ú_´˜˙üd˛+∏≤%n˛–G#H–¥%‹òçrÑüœ‹á J<•\nè”îów2¥ßˆ√¬ÒÁ¨{SU%ˆí	N3yá u;∞VDÎôŒ¡cmWHÏ∂Ó—…“\'K˙gR¸\náÍ÷úŒÂÉ#¯](ÆQ\'nﬁ¢∏yóz∂MaøÕ|¢Æáœ◊ˇZÑ83P#ÍËW—(P)ˆã”Á\n§ŸÙ’úá„£7|öùá#¸´|ò§Çig˚òä™ô≈Â¥ëá˘ÿ>≥=Éth∫@~1≤J≥—¿µ#x9Q™bvL\nÍá˙\'¨◊b˛ïrLº\r8¯÷íÿ“\\ùÑÍ√Ïí8òØcÖIà˜ŒÚ˚]uZœÕ®[\'iŒ#°Ø3è]ºbæZ\nxÑ©àÖ~(0“;†Z≈≥áÖ4ˆè«81ÇO ik˘ôˇûíà(rÈÙ.P∆åÿ§ˆ∆x∫Ón±ÆGAhÕYﬁIÂ£à0„v¸∏û6≥∞¨-˘ÄÙ£Wk)(yÛñjRvà5”ìU˛ƒì*\Zô∞ò\"¬Lv—::	ˇ∆»îj FªØà@V:ô2G€àÕ~O…‹_iS\nJ£ÏI>)ıD3j\nàEÚöI5xp“*I£\r!£	Pif´VqÓã◊lF‰DàVS≥><Ô˚…ßX[\"v-VÄ∏ˆ!∫•vä[Ë8àeE¿:B…‰«âÒåÍî8!ﬁ>EÅôê¬öaC‹tÔàe©Qâsõ«,Mzô÷X{Æ\\[∫(HfCPîA¥ªvày5Â™Èˇ“F∑¬‡µ≠Y^¥™“Ï„4}˘!?àÉ˝¯¯ËÇ⁄\nó\0˜≠»<ñ¬8h,O\Z_∞©S‚A·àõ~nD∏m†ŒnCè!÷∫˘4ÂKÖô„∏)›Öå3Ä_ à¥‡ˆ_¨1Â[ìîÕ¿Fé*õJãåæ@-©$•ﬁà√TçòáÄ$ÔTD£MR¨ÎÖπ£~»Fè-°ö5ÆÈôÇ{àÿ™\0Ü˜Wx&Ø_á	3g_`∆B∆wΩi¡[˙ﬂ\'à€\nTËT\0ºåç\"Ω´-ﬁûèv	øûÙ±âk˛∞àË∂Yõd4 âw∫£Ò™∞ãΩ˝;/uã)Ÿ¢X¥‡¿\ràÏ˚§/_oÀ°[í§âB€«”Û\nKKxm∂|æÁT*Hàı9K@këÑdf´«ˇdQ0?–W*ç™Ê≠òfa9à¯Ÿèû§⁄áö∑]ÓS≥ŒÖHDWIÙÓF„~¶ÁÑ∞â<X1g9]=-„“åÈã˝˝>Ë≈°0¡8(Ù•öâ\r4h˛H≈î’”H¯blÉú˛®X∂Tª\n´\0y\"âaRTfë˛≈B-Å.ƒRc/ìênµ‘Mú¿ó,=gâ$ß(}ÛB‚›ÆDñ9i§§@°îÇ◊]dE¡Õ^âCAmîÀ7˘tb°v˘·[5Í‘S{GÂRôiÆ6âK7¯°3!ò⁄˛s∫tàiãq)’∏ùJŒ\\(\'ÅUç∆âLÕ§¶~¶Üô[˜ÛŸ¥â;R6ûøÇyÿ0v π)∏dΩâR«¬/Ø\nfJÑ√hîvi5¸rrπñ\\z\"ù6•q%	!âkòó˝Q*˙;MäûË¡£∞uO*ºß·-\\jµâmkeéw[p‘•1„Ã%ú†ı∏7c©p!Ló7wgâ~Î]\'†Œ=,7˛9ávÖï‹/¸_óæú!ﬂÄPâ∞wS5ò†Ìb#fJÓWæneoRﬁ¨¥´ÙA§ÔW_fEâ¬}ö˜*B+º‰ÆvœòD-·@Atwëõr≥§ÙFãNâ“R_È˛\\e+õ≈!ø hoÊ¨ %9”≠ùçœ¨âŸÉÃ	íñßKW§e2‘PØÓæÇñ[Á, GÏâﬁ7oà\\;õ›Ô∆íC¡(€î™H\\›ò9ô»fıˇ/âÂâV©˙ï”|Ÿ≥Á¯iˆà•®3<Pin\ZèæE´OâÔ•VoîCu	åÜÏö17,sÂ∑u•Õâv,±ø≤¸êâıKÛyJcêπeÚ≈F¬G…’Ó’¸2üuô´]\"\\§â˘#3Ó\nV‹dH-SLˆ86›∂“¿è;°õ6ﬂ	â˛ÊyO¬œÍœ=√PœÂoéΩﬂ–£?æîßä€buóÍ˘˘»◊îÆî≠Æ\0ˇëG®\\%¥AÃ«ËÚÔä\"ıÛ˚∏^ı–cŒØ„˚kô€‹éoŒTä+%ß≈$Á√[ä[ﬂ/tH/åƒ(›é2áäñ∞Àeq«3€ûHÎ-Xáät? ˇLõ—A±˝$G¢Ì?Cû§øåqÍúÜGG⁄Tä|ÊÅP¬:6´¶hL6^âEÑzPu†≤ñK√;l˘)äôÑâ™∏cˇÎ<S\"≤ÕUŒBIÔìóD\nm?â5¯fÉäØ•ã§\"M∂£,ê·O=üÓ:ì†G‡>Íä¥˛ëømÇ`!∫l{_,DîëLñŒ+’2Äi˛4«Ñ ä≈Ö¥ÙÎ.êz;£˝& ®ªﬁqÈ±Á¢√ªàØ9äÕ˝‘ÄŸj÷É7\nT¨‘tiC‹b–âŒOKêÒÃä„Ø¶0NVâ∂…Äk≈ÿbàXù9°˝¥•ÂQ\\™\\äÏmà›,z¶oÙ∫FƒSIÇa¡)~Ûa‘FÌ=¿ˆ2ÂÁä˚\n)©æú–Ú·}$Ó˛¶Ïâ¡$˜ïπN‹)Çîa„˚ä˛d*\'‰I<ﬁ}Ç™)ÿªP™*l•ó¬wâàKBã}èﬁúı˙¡√s2C`ª¡ü›h`W‚>èè¨Æã!ïÌ\"8zHõ0Å—i° ûƒV(â+¿˚kßañPµã)∫¯≤2\0‰’íŒ\0ãæ˝¨·∑U¯“‰(rÌbw«ã9k\"m{ÔRÿ7Ëa%,q∫JM0ËòœwÈ)Â^®¢ã_Œ†+£\"g%ÁîñO0˚Æ[!∑<I9„√\"ØûNáEãh‹ïAOk>†f5 ∆9%,ˇ<±◊Óö9;]è9À≤ôãi©Ì0’¯ÃIc”;∆Â∆äÎﬂ@üpè–•P\r{I\0âãëˇ(<CÑ£øyÖµ°œ¶]1‘£ßÀøD•GrcÚ\nÀãœ pC3Q3Æ∆#9\\\n#I’hq24õ>öM{ãﬁuösΩäíπ!Rd/˝hZSÛC	ÓõìÁ]_Øçã˚WØ-{ŸWF˘vÚv4[Âi?irÀzG‹ˆa◊å/∏\nŸâüp†±ÆR∆?61ª.x°álëˆ\"≤>£åºé‹Å%|o¢ Æo3É˙Æñd›‹l›à‡s9å?9ß‹:PùükZúá¿§I%-ˆ⁄‰˚U•?ú∑˜M¸$åLπeü‚¢íU_F=–Á`o^ôFpiO@≤∑^/¶åX\r¯Ò˚—è!Ôπ–hìÊ⁄6Kƒw?Æ°où=ó7åoÉ|<Ÿ’‘õRÈS™ KVQLn≠Ñwéó¯©˜Œrås7g¯⁄xP0∂´ôµà  _xè_˘˚zµ÷ìáÙ…•åzdÛ÷Í‰^ü–ßÅG¬ŸDC.%ÃÕ{?_ÔŒˇ±zÒπå}+ÍiU&4c¸?=›ΩìÚKËD`Ç(Ï$åÇ(Œ[÷‰Ö†@h9<}÷R˘=¬-ÙÔ+KÖ[„;E®xåû-…©»€H\0ˇÛÖ9”k∞]¿4:õBí2Ê«6eå∏@^¬‡IÕÆ‚s¶ìä¥∑ØLä:}|9Û∆∂ºKXkåÂ•,k› xî˜∞∏…~6uz∞`ÿäiiñ7ÚRµå˙ª°ßq¯€3@ÕÛnM‹‡©5›ÅàÎ7•-7§çåˇî#ìKÖËT7πn.Ö=≈$∑£ŒqYı∏\0˛\"MÇ˙Â(ç\nOraåHQ∞˘Ë61Ö¨%Ÿ∫xåO[AÕ∏˙ÎÒaç\Z\"`“É›=»±RvHÇmÜÖâf`¥¸±lºsûWøç:í˘€u˘#£Ü`Ã∑Oº√ìz,ˆ£ê˚–n_≠©çBB‘–Â¬\nµSd3ïñìW∫ÁLö+&˘ÏåëcçD`ß_´eﬂˆd£vJN·ï™•¿>bg2ÜäZïTHÍçF»S}Ì“◊!*ÇrUjﬂÕk¥§$4mxY∂çJ†_Ç√\r‰Ók¯«@7‘W	⁄Ò§$w(Ê“MÄçP⁄XùÖÜpCÏ}À≤˚ò˘„˝›™®V.°åçWPr˜ôƒ÷E!Âìoœ¶¨øΩIü]ßù1PCN9\\ºçf1	2≥vvmÍ√≈^LÆ‰ßÈ÷–◊yf(ø_<>M–çfvãÄq¡™\r¥á7jZ2¨)i8õ&˛À<0~ÌÄçt&ub¸v¸¿ÀZ—ìØÆ€aÊ©Óë_I”\nBÉ∏cçybÄÀiØ¢XfK¶◊ªZ H¥„WrµRkL“ÈC ùç⁄õ/ƒx\0úÎsî-Q€Å≥∑ºËèŒ≈#¯\0’n{çáçÛÚ]\r√W¿h0Ÿ@Ó≤=Ïr˛ÿœIK‘Æçà˛~gƒü0‚»£)!ªåÑ—±„K&ÿ@<ì\n%	dß>?ççâG÷g»t!Ω3]#ﬁ≥jNù7Ë£û|›¬&?ç®«∞ˇ’≤bö>‘ ‡¬¿Y>r]ôbæÉå®œá3É¢ç¨ıﬁ¥ΩX‡¥>m›>–√ÉOUyëvÚÜH\n¿;‡Qçƒ±g\"∑¢©WA“ß_g”€sÏàÎU˛ôMíú-Gm\"¶ç∆cµm#{útµ”##üâ!·6≠\'DÑ´Ûı!¢ı£ç€\\÷°âq‚<pZÚ´˜´§q3˛¿glÛ™ôõ∞#§iç‚UÀP£¢”(sP∞ôg∞ã¥„ˇ/Dgà}â#˜ÿ&çÎéH‚3ƒ&Xw“ºYùùªœ:zΩ†q{ÎÏIüÜ<çÓsú∏≠õUxätWÀgAO/©ím∆∞Brb™,ÁÃ}é71áñ≠ˇO[°ìßû\'GÁ∫÷¡Çd7z\r|§q-[éIv˘¬ŒxªD!≈fœñÍÂc‡DFC≈ ]ïÒ5ÌéXªQ\nxπ√!ßs”ÊT™éÑÙΩPƒ¬æ⁄T1§!é`µB›IÚŸrQòµ®q\"á„îZ°F¥~ﬁ¶-√d±ıôélWÍì]!ìrÜît T≈$MKP\0‚∂ûl˛®O\'dûéÇ]<ÿH≈≈Á„≤›ßóër¯@Xaëí‚õ \"cù∆éà|†ﬂÕW00RıÂ¨∂8≥•Nh.øs)›7\0;Xéñ\\‚t™ëïI7û“Sc4,¢Oê/`“ª∆é¨ı[%pP\Z¶˝èõ”›cFöÿÚÌ~®c£πR¯ÀÜéªViÍM‡JÅπ\n12≈Ù\0›Ñ¥Ô®x1ÄX˙†ÿéƒ\rƒÓTÈ=2&Å{$©î∆∑`z#?@¯Ã\\≈\0ué—5∂t«¬ÈiˇktÑj3ÿ\rÛ‡hóvèacJ\rà¡éÿFˆÔMGázùùŸ˚—pÇ	˚Í(ã_ôﬂv¡—¬≤ÑéŸç@˛¯kr«Ìyﬂ‹~ØàÅƒ∫C9lÿxu@˜«∆·é·H¨˛»Œy·>7∑„ÃH÷f≤„F€4∑´Òîî<\Z≈éÈã]sLÈ¢ÛoxEl!\0úœœ¸∑gUg¶‰Å\nÛÇÙGé\"‹˙â∂Ô˜G¬Ô-®ÑOäå\'≤ÊBÁ© „^é¯c~\\fR;π#Ñö‹Ø]ï∆»¿1ë@ƒVkòh®@é˙Üv„û¯Ω\"Ö@:~áCGÙKE`¬^-‘B¡\'Fè*ÚS1?¥||«wÙ∫ñ•~`Ua¸ºÍã=\n3Éçè-ã:oâRFÒ*&É\r√Js‚Jß§™à\rd^…öè=P®öÚ=¡yŒp∞ËyÇPÙˇÊÂ*u]ˇı´û*èhYef·≈€m√VrŒ%£œ÷)”Çx	©Îc›`≥9´èy≈D#Ó¯oÌò◊\rÖóµáÊÎpÜj@\'˚%”˜èö(±ë¨ßÑ\rã\"`ª4°Î÷-XoúlK˘k$Îè—ØÑf˘7y”ñâÎus#‰Üi$	Ö\\XÑi Ñô</jè’Ω\n⁄¶*çœí\0ú+Ëÿî%†ﬁVÈªâÍéyw¨\Z1Åè‰ÏÃ1ï0+Ùﬁ†§Ÿ‹]¯Î≤  ìˆ\\ùπUC_sè∂ˆËøÁ±!)Ë~Õ¥›≠Ò>÷¬À°Q5∑∆æúbèÛsê\Zp.ì(Y*Èá®uùΩí%y«ÎyëeS•è˜h\'∏:áâ¸x\\¬ÈF`fË¢s¶„BêXê#ƒM¨lüñ‰W \0Íí#Û_Û›‚≈EŸúÎLë∏ã]Zê2å}Ω ~8fH≈’›ß•ÑO¥wûàπ$}‰ˆjêEÉkw$ÿè˛Ùh|°ÁÎaX•xíNGÒZ˘ãn7¬êRstˇ…∫ï≈∞‘˘0ø6<W°U¥.ìs:I˘>˝¿êT-¶◊6fO∞Ôlb]∆‚9PÖ¬ΩÖåÁ@ 1≈¸^êêxzÎÍŸoU5øe2y˛¸)qä ≠n +˜£‚ØêÑU»0i∞°€q°º¬†,1√∏œé£„,∞Öºπô„êïô£–}@ÌL¿íâ(ﬂÕôVZóg´≠|_}–U)ê©≥87^ª*¶S$ @ÅK¯Úï^/T¢∞\Z™Èî2µê≈\"\n@+¯™≤Ë¸„‡\nV)-d∑ò é∂C˘êÀ‚≠õ≈˚ iÎ{»PAƒÕÜkŒ˚Ò˙d©§áM\n©Ååê◊+v´òÆ5∆ø^”54≠AÓlÉ∞es¨Å˙§˙í^ÿê◊§öÅ†R˙Êc”gÔ⁄”ÄÊQˆ€ãÏÿc˜@¥y¨âëç–Æ*ï]a≤—’/¢ì>^Ùo</∫9?Ú©ºsëÆë:Ó)Ÿ1ß\"Ä{/ÜÔpTj‰ÆŸñ…\\˚â\Z≈?MÄëùç°–‚n{1)\n¸õ†Ñ-ëQÀG•\Z?Zé˛}/3âë\'ìı“l:∆9±w‚):Iıô)¬ÇöÃíùÅ]O£ëCê¬{dvîc^ŸÃü9Œe≥ßQë€_ÉWoè{_ëT7’QÃ ÇÖ˜ŒwÅ˚†L.Ë∞áM†∆Í=‰B÷ëí\rÂ¨\0Atè»ëN‰\r¢˝>ß-¶-bmYUMeòëºIÜ¶_i §•V∂ÿƒHàY(ÒïoŸﬂ†úÓ≠¡Çë¬êêä!ê∞k{˝ustŸº∆íál|˝’aêz™∫4ëÃÒ¶5ö5@	^ n4Ëk´∏=˙\r	ª_ÊKñﬁ\"áﬁXë◊]4óﬂ@ô¥NS	™—tûwî“†ˇ˜aF^˝∫˚•ëÏÀÓñòÓ·E!î‘ˆ@Z≠[Ê|èÜ„i(~ë˜«_M‘·8U¸º´.pF´˜˘¬wé:E`MBÅ‚¸ßíLˇiE™ ;øíää‘äù‘Ráy—õjp≤]c?ŒÌí\nT∞î£MOmK”w`JÂ˙ÒÄÁ‹4/ww-6 Ãí ûΩqØnJ–0\"dJ›çÌ™ªÅáR\Z5ŒÚ,•jdØí\'Yà≤BcHâ7*å(ﬂí,Êó$ﬁ©“’œkå‡öí3`tmú´˝ç5^∞7°}¥M“RÄ`˝-µxÒ…ícáõrÊ-ëA¿$⁄:T∏˛Ô«V¨8&ÛE√75ígæoÖwÁØV≈ª√Íû≠ñB—õV∏ÑÄëjÀÃ|kíq≈‰®YÊjY9Ë⁄‹MñHûõÆïÓEX∏[X≤íõ]@Gö3¶∏á:Omo]?G°Ô[∂!Yêä÷íú·ı˚Sﬂè1÷ì—}ÙdœQ*£tê…/á^R√∂éµbí´=9Øàπ@à≈dÖì£Ê·rä 2H4◊—äíÆJMB∆Ú—¶´}„Ì\rô20â2h◊(G:êË?{í∞˛r\"∏\0\'5»w∏˜›≥Ûôtﬁ3cë4≠Y\0VI:>	íÕX\"ÙFq≥óU∏{ñﬁ†πiM$Ãµ<ë4ãñl˚Òíÿ§Ì†∂É8∂0î/\n}∂J`3øcl6È∆HπWì	í9z^q-ˆ¶˚7ûöÔä6,ës≠v≈ÑTe}¥æ†ì5  ;≥uÓ˜+ƒ,3.º•-ü√è9ö#FÔÃ}¢ÇEì¸jvA\0˝&÷ﬂ5≈x¢P,öz\r&‚8πgEﬂÃì\\c÷>k,-ó™\rhi˛ﬁIZ+^ ¿F©åîF¬Vì\'$$òæIt¥¸û•˝˜ØÎ„&kÓ˚ -ñÆ8lÑZ6ì>F‘Yä\\3ßú8√ÂfˇGÊO…√p>˙Kes!2ìYæ˘Öf´xMó´¿w¶|W$‘<ë&h“ÒïßÎ70Äìk7Ô∑N2çwFôäuO4-@cÎt¢…∑3¥(∞¸ìk•GÂØ≤‰\nŒÉCD#æ6»u\ZÎ÷ÑE⁄£@K1ìy\"ì/Sá5‡ ¯¸ØM3¸8¢iØ)BC[Ô‹öì~îZWÓ¿Küi7¯ë/Zäéº…™HzÖ&ã0,ùê∑ìà∞?R-‚∆Õe≈j2≠#XÌH∂\nd≥5\0¬∑øìàÁÙ¢xπø\"}Ôv}®Ò––—u0\n‚M\n◊dÜ∏>•·ìéÉ@,z\nôå¢ë&à“@]÷“D›·6NáÔI\"\"{Á4ìñ:g°≤˛Ò\rÆ¶åI˝S©ƒlùûπ–£≠∆÷Ô/ì§∂Ìπm~ÖY¯nrÛ87¡›’ECÃ\n∑j1s’Dì≠„)U«@’3™kÛ{Å];ö≤»ÏÇƒâ∑a’åì‡–ÕQÙd∆ˇ≥8˝ók5∏ÉÚú5ai«*‰UWóè˜sì‚á∏s{q√˙úKcB∏œà*çõú\0Âì&∆º\0?wÌoì˝—òSåüÆ$§¶Äƒ–‘GÜèÌ£∫∆JNglc^î^HHµÔ^zÁ‹S≠&^†ªûFîÒﬁøhY;»kn›î|ŒTS‰ÃO¨cwû‹ÒDŸõOeiËÕj3O–)îΩoúÆ\Z`N~uŸ©…bûXñ…$ˆZúŸòâçèî¿Z›üi_Ùõ≠L∆5>©}R%¡Zü¯≈A‚>Õ%|î“ŒÌ¥¡@÷Çp®wÿÎ^ı‹o(âÈfPk\"Eî„’∫Öl5—zÉZÜ´8Ï¡ÿ‡Ãq™∫Ω}\rœ–2î˚{¬$å—7F--s‚ûõG2≥,a˝¿Ó?â‹dèïIu3ÑÌmßÚÙK=¯ûÎV\\ã±‘á‚òç|æ‘ﬁï6Mjá	÷m«≈9$*xß∂Ög¥U(x˝Â‰9ï9“PπTó⁄ n’°cÅ6Ç\nﬁ¢á{zÆtéò@ï;=§JMÚZ‡»}`Ó•ËÛ·¡ãÇ˘‡∑¨e˜~vÔJï?ö\"/Üi¥»\rñ<H°Åi5◊+:~p1KãG{∆ï`ÿÕ›∏ºÚ¬π\r?íÜ yÓtÆçbg…=!”´æÚßèïàQ6¿ÃÚ9°Ö`\"-tPÉß(cnÉ◊/ò˘øÊ¿>öïúÅ)b@èHOéÄ?˛•5>PQ∏Áç	·µFöÁºÉÏ`ï™\'ª‡%„Yà¿ÉÍ©ï‚∏‹Ào€∞&£dƒtQûßï∑¿Ω;<v‡£ƒ}\'P[äY%/?_@≠e§&´˙êõï–˝Ü˚º\'≥ıGpp2[zD™wNÅ¥ΩÎûj˙√ï¯X‰=ù¶–ßlê1Yò^≤2xÏƒO^˙Ë‰§Î;ñ?LÂu5ReÍvπ&ﬂŒ-îkUobE≥Ö⁄¿çñ7‹º¯éÛzL{∑‘{∑MÀTG.{©ã}¶Å)¶c¿¸ûñIÎ†º+@Íˇ±>H„¶#qL=ÏÎa¬.îcÅUÃ\ZñMwâ£®ÊÌÚJÕ√ó® ê˙∑ı\'bö\n»è}\ZñQ!£·çxòë\r5±ŸÕDQíU‰‘KˇÄ‹ÖêÖ±ßﬁñÇ¿:(O.Xiﬂ+î&	ıM‚íEﬁ	∏àæ¨ËzFgñéê˘o¢1ãê˘:ã—≥\Zû…È∞>A∏\rqñ˘7ñï0Oç|¡%6`	ÇPIéY„;I†(À≈¶œãYŒ€ñ≠Âºuf/ç›Z˙º\r“Âˇ·G¸s<÷hÔ¨4“—ñªo…WxÙê™≥€∫!—ŸMz0V_.=*ym\0¯ñ¡C™{!Y√R®Üa≤\"•ö	`F?MàÀUá∞«≠[*ñŒa:—&∑3‹∏<u◊LJûÃPÜ#È=9+FÒsñ‘÷q—…IBßæ:ÆU{G@‘BöÌ=À«\'ÿ÷&»ñﬂ˘âfC —~¯.ßn,à∫±1`ü™o9]Â¶k\Z±æñÒq4Ÿ±xøàr∞Ûê*¯è∂”¶wéRñZ“	õZÎJñˆh>‘E|7¥àË‹bΩ{—d±8*⁄ÕY±ﬂy—óB.˜ù∫ıÌ*¢Û	ÚlÚ2Q≠äì_d_ßÔ,6óQÒaA[˛ÿ≤óØ˝ªÊ=πâÿ	2˛‚mÖÌºüó@Íﬂî> @ATm~Fm”†ìN…l„l>ËıhóIÓ…2Yø÷÷!Éln}ø∞1dÂÒ•Z—≈≈◊óKê¥7ÁG˘∂˜ﬂ?-U>òÇª∫∫É—tQ…+qÌKz:ónÈ9>ëj5ßËdÒ‰3À˚=«íÄòY±°sNqqópÎc◊Ò‹u»∫tV5∆»§m9\Z8å∞å£q}óu}oÉ8>&©V¡ÔΩ˝&N€Aµ≤Ú,\rôÃjYóáÿ—“nxIvÊIv∞ÚÛ‘ö–Î!2q#&aàìÒ;L˘óà¡lØ $„Æd£ö3\ZÂ&2‘	%Ø\rÃ%~é–◊W≤óä÷8ºÒhüÒsﬂ+d‡∞∆É¶ú·∞*&„9…Øﬂóñãó+n}à“≈`îˇ+jë“	˛éﬂQ¯®CËçóóPf–‘•Æ∆E∂ÅÜZÎëN%âË=–ÀË	Ó$¨…óú»ÛÁÿ[\"!≈v’O\r#ç-ÛS’Z8(…ÉA◊“∑â‰hóüŸŸ˛ƒ·…/º∞v‡‡ê.O¡º2ûWá∂ˇ\nó•9Üf/3MM;#G⁄™WO&ítS˚O\Z±≠¿∆òÚóª˙d»*¬JÉ?ë^wézTäG–ßı,ÄÑ‚“ƒóÕƒ\n\\yq–›#1≠òÍé6π&Z\n8˚”ä¥ã˝óﬂUuBÂ‡©ãÇ9˙EL‘a=‰TÏ/˚–8é,i?¡óﬂ√»DÚ/Ω ∂-≈ &~Ù\'…ãâÅú›±Ÿåª‰™¿ó˛øÁœ]ãÍ∆˘ˇÖëúÇ‚•!zDñW+ıÆµjJò‰”(r†]§ \n=+¿í…WU}Oê/injı4«uò9ìœØ„\\-£/O≤“5dXS^Ìù`çÊMì.ÅòN–S±I∆w∫*Ç/\r⁄ièè¸w‡álû¸µ%—7òRÍc(ÚZ=m≠±Éì ¿€óöA˘ƒÒ\'Ãj;äßLB\"ò^“/µ±:éøÛqQ∆oBﬂf ıløG2ƒúäòh\rÙã=Á–…¨À•°cø∑µHıw{TRz>Ò=MÎ∆òw¨`íw˛≤înÌıNêë¢ˇ3=€ÕühKrør∫iò}I^L\\95‰NﬁYÔ¢Ö∞;Ì?z†´aE=íòäÚJåë8¶[˙C=Sπ—° kê§”{£ùœ[Ñkò•ÏFÄÙ`ìRl>ßƒ)ÌìÜo…8≥07M•R◊nÕÀÔòòÆ}\rƒæE~˙∏€Û≈êí\r\"\'óùÏ≥ìÉ04øtbtòØw„¨’K“\\»iU¨VD}”3y¯ú(ÂÓsüø$ˇÌò TﬂÁê±ªaÇ	A≤aΩ¯|†Å;ûTrèÛ…ØÕ(£òò◊&o{˜©!•˘˚2Îo ™éû“í∫ÁD^–ØD1òÔ \nÈÌ¨9Ê)Kb}´SÉp° ÂåMcPûAYXòÒ—+{^«Ÿ´X(Úﬂõ áì´M[Á¯>Úê⁄mñMò˜πC±´∞ŸÙoMtÀ}—qqXA÷iYQı√Mﬁò˙\"#¢°ÿE©…ÚJp~&w´°ª°Æ ∆_ÇÑ⁄ô6=´«Ôuq˘e4_oqñ÷ãtp^B•a@^#öô$™gâçôÖK˝d„˘≤/õƒó5ìò\\HΩR¯‘]‹.ôH%EÅq˘˘„‡ £Å∆©cnú≠åâ\0ª¨µ«⁄¸ªôQ«£d3MEÁDﬂƒv/ÛZ∞_aØ!—/.‚A1◊‘‹ôVÆ£Òs©˛|ÊÃ—¬bPoù25È*åSÕÊ§û6ßôi‚,ÊÇÌmªOè¨•#Ω?Vb»,ÇC-‹¢c≈æ\Zh·ôpàé\ZYvú1]@√¥©Ûæı¯ì⁄yó$]Ç‘6ù•ˇôy=¶¨¡gŒ÷ò˛çá≈ﬂ…eåàQõß¥b÷˛\\ãôèÎÏo~Ü‹á˜] OL˜HPºxÚ	›9lK≥SßÔôôí#ÅÙ§¸nÿ6¶Ω@#Gb◊bµ5_È*BàpXπ„ô‹rV√wõ\rAU(ñ\rÿbeÀ&U6[ÜØFÇ#`l€,ôÍ√[u\0Të9££ﬂ<†	cÚ&AËwº\ZÌEŒNÍôÒ£Y∞óqŒ‹ƒûi˘•6ß-%1LÀ≠›ê;\ZÕ˛ô¯Ú2í„uYÎ@è\ní∏‚WË‹ë–∫π÷%?°ÌæÚöëüñ;Ö`,Ë“ƒC¡’ãÒ˙BË∑xÛ¯äöVùıu(|Î´/ßÛ9¨µ¥ÙJ˙€ê@˚ì§hyöºΩº(§æKÀ4ö\ZU†å+h˜±A\"Û?Ú_6GAmöÏﬁöÃËÄ!3øh‹ÑÛ˛£\"‰ÏVj`’íö+Î*G–6j¬q`8Ó&R1`ŸœÛ˝\r\Z{€¯É†ö5y®Gâ\\˙Ç⁄Ò0…ÏMó·x[≈¯≈-Ú˝™ê∏ö<P6Y£ëÍE≈[3oHSV–òÁ†E]:S*—ÀöDÄˇõœ{vJØ“-C:IÀJô*H«]Ωòò9˝[öFü√|A9ùªíx¬⁄~∑dÇrÏÔ¶ö[;Ëü#;.ÍHôA€£øcÖ<ø›ÎEp&U\nöÇO˛¡KE…rÒB…¡±¯ ≥ıgU¢ﬁ‡a1/ï¿qXöá˚Â§ûÀd∞á9SyrCT\0µ—´.Õ¥Yb€jNZæMö∫§Ï<h˝¡s±’ΩI∫ñ\\åâË5\'–ùõﬂL¯I¿xXö»ÁÚ`ˆ«EÖ—™–ŸB+áAõôp:ÅGÅ∂¡:òﬁÂ,ö’õôK{P|´ôL/”÷\"¿≥EûálÆ+´‹¢GwÀèö˜ÍñıŒra«Hº\n¥»}`’R°±N‘Ë∑|«¥î:Gõw&◊≥√?/K$^ce?^ZdO#÷%°XxÊä ÜØø∆õ-F8⁄„yäìdô≤ﬂ]3Œf^äÈúÎç6C¯wÉŸõ;eRv™åZ´¯[2πà›–≠µAä¨>ï¢ø6„BVWõ?Ï\\v¢®≠“ß™x´P√Ep∆Á‡Ö˝Ïß6ÙÌ!IPõg~xàØﬁ§æ!⁄™ » ñ˜}+∏`ø∏ô’aõ-ç”¨3+πÜ¿@wÿFı›_+xÀ∑”ÄŒ+\'CœÔ`õÅ!VÈ ˙Æ»ˇ-OD‚€Dá•Ûx√˝Ca›_-÷õú&•úÕoBîh‡\0î6ˇùÑ ˙ó6Ω+£Ïu0Üõ¢ˇ∑ÎÃÁÊ•2ö‘≠p\Z;§Di®Õbi·\"r\Z@õ•!:ªñMÍÓu¸YSÍ•¶ö%Cpá¢Ø,\"GÜÉENõ¶NN◊ﬂL/ï4—ˇﬁp`Œë·∏ÿ41Ω˙Põ´ÇcÈÕqı€27øÌ´πÃ1‹I±ª ^™–¶≥õºDv‘nZÕUˇáC7åê∏ÚÙÅUpx,†w¥∫ä«√õÕÄ˙vNxÃk°l¢fB2ÚÄΩQ≤¨WΩkÒú¥U⁄ú\"**ÎˆRîËÎıô¢ß‹kòhÊœW`≠ÓŸ≠úR|®5µ“Áò÷nu-\\≈◊:‘úY\'KˆFå˚Éú\Z1ZπS%4‰È¸Vb*PÜ[∞±ëôd8geÕΩC\Zú\ZSÔ≠j0ñèë13Ó¡°ç4]Õ)óΩ’È≈Œ∂ú\Z]ñ(  9∆ØÄH¸øê≥x—&ÆF»Ë\"ß=v.‹/|—úK0‹“õzΩ˙\'u¬z©πu˜¶¿ø´`Ã∂$Àú\"µX–¡ÂïÍïÔMN·ÕÜæ&¯V™\'#«ôÃO§ãú0ÿ-kàq2wçπSc∂≥ö§?d¨ﬂUÅ»‡ıH\nQ7ú3h ´€‚Ê‹m<¢≈GM]í3πp+LÇ¶óKN«úHRfûÅµ$«|Èk¥´|s\rÕﬂ˙Ã£64\rÎªIbmúHÊ?¡C\n«DÜﬁ‘à›¡t9!º† Ç√¯¢¡“DØúWÚ“~öÚ<~…ƒJÄ(ìÏuä‚òµŒB˛&ö‚O¡¡úz≥ï8÷Ö‹à‹àÛ{sçf—|¬ﬂ∂≠‹}~˙(=5Ê«úú™Áëä[m —¨ûòØ7ß†É¿Aùm¿¨«ÿ	,ú•¶Ñ˘LÖCTúÙNR◊Ä—âî@;ÍCºOuØJú±•9üı®∂òÆ\"ÉÅ\ZO∞œß√â·ï∆ìã{O˝Nrú∑ÁX´ÎòŒÊUÈïú§Q”Ÿ©\n i/$ñ€:t≤niúæÑÿKSfÈ⁄]Èõc«‰ˇX\nn\ZÑ˜¿Fç≥úÁÓÊ—Á˜ÄàpôpJÑÊVôÆ¨üA#\\1Êˆ{AÖú ◊√ªßı´Õ•J´ÔìOêmOö:œôÈÁ‹lòWñ5ú¸Tå2≥ÅÓÉDBê$ã^Vy⁄gπΩ…ô~˙|ßù\rUÅÑ–tJ÷`Üg04	n≤»’ûFÌLZ≥ëˆù\ZæqQIW#(4ø…\ZÚbù=9º˙¯-C§è/së#ù]Æ¥:ú·fR-_Æ\rXõ©Ò\'ìÄÊ€rX4<V;Gãù6ÀÆÖC€ä≤%G¥8µÎÛq“)œ•‹‚£v«Øjù7ZõÌ˜\"SÏËeÎ(ö®êµ´$KVCÇ‹‰mù[Îù;ÜW8<{bÁÊ\' ≈èìÖƒq`\në3ü›oÕﬁ≥Bù@8ıÜJc√Ω≥≈n&V…πüî/[©)€ªzÉ§ù[é“˜gˆ±E«>b`*„e∑—–Næ›ìø\r	È¥˚Éùh«– Hj¯ „	gËQ.X˛]Òézò—©*gà‡w∂ùÄ„„/^xGqù1%S9Î˚?R¡Ê∞#¢®B~≤Ò::ùÜ„XÚãg5[m–ÂQ”®õCM.C\0ÁW{ï‚4\\vkŒù©¿x¡Å‘ÿ[Ì§ª%°∫ñùÌ@ú‹cﬁËŒÙ©ù¡ŸÜ#\Z>OÊ;ÏjGgﬂ¶R0∆‘Gl‡Y(ÎùÀ\"y4Çhì/ÿEÏÇ°ªp∞°4§3≠37¨-s’£‹+ùÕf^∆ÕﬁÁÖô‰Æzœ⁄:≥ÚÖÅñó¨»FôÕëÅñ∫√ù‘⁄¢b?Ø∑˘£ª@◊ÒÀ®ˇ]ËrH˜§!¿|Ú(µaù◊´»vC,¸ˆ‰T1>K)||yD·◊p‰èÇØ«Û¿BùŸ‹ÁΩç£◊†#A.Æ{Ari=øM-∑˛?ù⁄3u;≠Ô\\ô‹›#√«S¥Ü˘ŒR≤\\π;…Y•∂êù¸ﬂµzÑõéCF™#L‹!N@6¨Ñ9ëûjÿc@%‡ ‹û⁄?èLé‹$bmjT0)±üﬁÂ∫†ÙŒ„|ê˝lû¶Ä`$†÷\\{Ûõ—\"¥∫?~cj:áë∂Ô√®∆ûá«áÙü\0(•8‡òÉG˛f†Ì»Wi‚pJ©pMbVgûÆC/éçV!îW—Áó3Òﬂ‘πiì9±›*m≈V†wûì©kZäP[:–Ì∏˝UjBº¡é5ÜÇÅE≤Æì û$Ì\rà(õı‘á˛~YÔG=C\nwÍÍÖ≠9G)é\\ñMû0xa$k∏¥Ÿ•∑‰«4≠a&dkGSÇé#<õÀ˝x‚û>)\"&%qˇŸ£Ì¯u4àKMø$Ó°oû∫›≠{¬A\rûQIÁºQÛ\Z”(µBﬂ}O‡^Q4ÖuTÏvø˚êÓ÷1ûÉï˙à)”Ê¥\\Nz‡ﬁoî«\'\n]¡g\ZáêÁuFπû≠(:\r·∏ŒSŒ‰‡∏ŒlﬂV•l&—◊r’\\;;™PûŒtÛNÁ…Ä›‹ªıïÜH€êªëªß‹%kH\\¶ZÉ‡ûœºøÉOaæåø‘ËJÊ˜‡aEº¡≤7Ïdh|òû‡Ûé´qB˘\\)6—æpD¡W{€ì€æ!$ §5g[9û⁄SÌØ‰ˆZ6¬†û>ˇ),èÃ…(ÖEÚê√<û˝;-õfÕN˘ßI„ëYè®Y⁄≤ªΩÌeäŸ\r§üññØ~˚…<©ák¨æ—\"`	‘•[éﬂ¨îü\Z)^Ktz ‚`t^⁄u]≈5È8ipvk\Z˚‹üé£™±%Tí˛åîÆõ1û”#ßW¡ı$–€)z/WLü-ZÇÑE{‘»˜Å˚K —≠vË∑_áßΩ_\"ìl&‘ü3„I49∞q∏Œå·èÔ¯ZúYøFU	-&\"∆(∂œ6ü:è’/ÛV\\¥FâÒK&ßf	:¡¸™Ä7Ì˙9µ\Zü]Üïñ\'ƒ√:∏â·¿ÀrQ˝FGâﬂµôπá¢#üb?˘ñÔy‚gÒ	V˙iÂîWˇíÀ\Z⁄X›Jçx⁄µ’çüq*”◊V8,x—“∏⁄$≠›†´IBS•;√ …ï8üé1˙∞°¨lL\'\\ö∏udÄ¯˙≥júF⁄◊ïVQCüé3õx)ƒ!ÈTUõ33Ws/w¡òq∑∆a_KBü¥”	.AªÙÍáÎ∑YÊËﬁDµñZ<ﬁX¥m\ncü–h}ÆÙìÇÙ’!ÂaXÃ…±—9à†‹6ÛÔ#›üÿ»¡{mèë]ëRWrãﬁôî´†Úù®V• üBôa◊üÁß¶Fzô¬˛J≥O#À%ƒûI,S´Mƒ˚Vú[uü˜\r˜uBÑóVñËo ”—Í≤˛ø—# »ÍIv4Øü˜d™êÔ?π‹’ÓéÑQÉlHJ‡“6\\2ƒ˙me˚8(æ†‘‘\\·•0¨\Z%ÎheÄ[Ì¬>K5\Z¥†õ*†V¡∫\\îÚz%Œxƒ¶Y1xYf[F„X6c«†*⁄¬éukÖß;ï®)çâÛgRë„îIb~ø\Z†4ûVÄ +uê®‰å˜¥cr˘Ëõ>◊\0_ﬂs†;“œ∏å“‡àB·ı¯s‘’1Mó+Jÿ5CÜ$âr†<0îﬂÁƒ†…ã[!ÕáÈªü∑\\d¡5cr˝Fâ†M‘Ù=àãÛ]Ô”^∏‹©Éπ	_n=√ù„&o\\L†P2è¢ur±~oá(ÔÑM‡ F‰S«·‚ì*:lÿ5\Z≈>†ZÂDπrgÂoµEùI‹≈Hº˜PÈΩg˜î^†]nÕ¸0Õ/«¨‡à˜¡s?ˇ€F¸◊œé„IÔÏsò\n4†^˝TŸÈX›r&‘íl∂Ÿ¡(EËC4)ˆˆ£Øä\Z†rK(ã1ˇ2‘e‘^Zr#π≤ãñÔjéW†÷y…5†à-e	Gø_ÛˇÂmª –rÌÉ?gW∏¨’†Å≥‡ã:5´W´ƒ˛Õ›b4# >)c°†SuÔﬁ Õ⁄†àÒ†rö°2—•˛Œ@F?öÂ&ÖÖ÷s¨~øì’†î($ˆÃª.Ë›√◊LxkWNg<ÚêøÂˆ¸Û†ô\\“RgûÖ_®¸√1í…·3€Ø)16úéO˚ﬁÉ¨††^L≥;ππÀãÍ.#LË§àI.Ωß]Ê„ˇ†∞+ˇÑˇ´›ÊˆÈõﬁ–Jp´∑(¯9Ÿ∞X√Œå\n†¬“\0í°†ü*p…ƒÃïÏ^ XEÜ1¶ØoO˜éÛÙé†«3rﬂ†ò1nv\0jƒH¿Âk7»qÕ-‡’;CŸ9†«ÊRÍ…_ÿiœ$™œ‘ä°û®ï6tqm‰›4_rÎn†’â$u∑*&ê?∫¨e`=8è«€ÊîÚ9è«˛=•Ë\0Ω†„Â‹•±¬Eµ⁄›â «X8´ÕYm	ªÈ„ûâŸQ®≠†ËlA¨ßﬁ\n¿!Ñg¬Î˙Cn|ËI≤ê‚¡#*ﬂ0\'p†ÈÚáTˇî,ú˙≈Rræ∫ÿ°í¢†Aóˆ„™ÓÕ5§s°\r˝˘p>¨¬*Ä9w¬óÉídg_+o‚9Å“0√Ï°÷ä©soü ä∆¯¬/∂]O]À8\0qg_Ä«\Z´Ø^°ìEèí6{:,\';ZªB ‚ßcﬂ¿•˘ÂìNÿ°\"¬É!gÒ˘§ª¥xöuºE™\r˚Ãâ8Úi&Fì°?Â¯w[‚ÑüËø¢Zë …q¸ª!\\‰ˇ\'-Qx\0L°Dôø-Z#S–¶˜Ì[%…ölì≥°Òz*m“¢°PW·1˘ \\>ÕûuLvŒ}»:wû—ÁP([fÆ¬ﬁ°0˜°[[¢ˇŸ\nudv8è‘fåçÖ‰°Rª∂DúlûÇ’°eªù$öÀ*}÷¢Zh˝\\wÇOWÔ⁄wÀSiê7æGô;°xÑÖV˘Ÿ\"å\0íû∑›§à∆´Òñ∏Hõ‡2ˇ`°zwÅõ`oi0ÊVj◊\0Ÿä–lj.⁄ÖBı¢Ï∫\'ø°|Z‘ﬁ√∏s˙Ê-p0p@πﬂ[¥§º¯ÅÍLãæÎfá°ød@èƒ‚êa1Æëﬁkv¡ûäü<+êrº	ìΩHÀ˘°ƒbX“ûØLÑ®„ÊW1&ì@˛réJ÷ﬁ⁄á°«ûsbø_ò`6K+¡∑ìlÒ¢˘|‚S.£†P^°Ûl‘‰	l9’/»¨x`»Ûﬁ:eu)ãün\'ª\Zcò¢E”\\©¡ö|ñœ:D˙ÃNÅ÷l,él#¿ìØCËD%¢K]Øú˙‡®Q–†â‹¬L¯!ûç•jƒR…Êká¡¢V =~Rä¿[∫ŒCº;>‘¯fM√BÚRÚ+¢mö£vn„	t¿ø;=%JÑ·yÎ†•R%¯0—\nf˛¢/e˜ÎÇ·√ñ∂IL*‘üŒrWtÙ&BmèvWU¢#wIèïÜ$ä⁄Klh5ˇb4:Œ—ïWn‡wÇ¢3Tg-Z¥„BFî(O)öŸ\rfòzà·?∏û◊\'Ä¢=\râ¢0ôCÏUR˘\"ı$dº√©è6Ò•∏˘∞)¢IS∆—∂ó\n‡E]˝m˘Y5c\rwcDÁπ‰4òAqÇ¢QÚixóåñ˜æWD2oŸF∑§0˝ƒ+óÂvBJ‡˛Ø¢XΩì¥\0TÎÌ´¢±•POõ]\Z8U…ÌÀmVq˛¢^o#ùôZõBÙëaCuÕwIT-Ç$eÇ∑*1¢g|vÖ”ﬁÍv	ê€vÖ ƒõW\0…(Ïë@j†π^xÏ¢hÈ∑)‡≠Ÿøì˝“ vüSh_‚≠=⁄XD””p¢iˇ-Ωõw–FÍa°\ZPN;Ê´ÀÆû∞hÉ∑J˚4¢mB¢¥‡èB;Ù3”ØÒœÕhPœ; )⁄ìVz\0D§Û¢r?œ{Ÿ.Ç≈<Éßı¸nÆ;††VË‡.R‰ª‡¢yÉRüTxª\\¡˝h‹˛~D @n\\«πîﬂivïÌ¢zﬂ{Åà\Zî]_q≠|@ÿT∞bsô¸BzèV&Œ§Ïk<¢ëöt˚CzÙ êû§Õnê`j\r≠MÕN\"AgÛ◊Ê¢ë˘x%¥&ıñÔÎypæ¡5êê‡◊L&¡Ü]‰¯[”R’¢ïYºΩB—µÖ\0≠…\\4:\r∂a∑íôπóØo≤|(;“¢∞ñøLÛ]Í≤ÄNj‡˘∞ﬂu≈zaæ»hpF†¢¬3ñë¸H˚—O≥)-ˇ>!\"\'Ÿ$t-}∆◊M˚¢«61p9ì«°©Ù§∫Ââ√‹k˛£◊Tb :XÀ%nä£¢‹¢ìˇx≤J–;†úvwèwß†|U‘-à%=ôFÃÏ˘å£ˇ´MÔøﬂ>gq=˜ËtGàOwmjd¿)πÌﬂ£\0áæ$Qä%_ù‚Ó·◊ﬁ‚{¨1Õﬁéú7Î⁄Ö£\rƒ,?∑ÏïÒ»zD˛x°çïã&Üô˘˜fvı©£$„¡„HK¥ÙÛAh±…çÜßÖr\0ŸaF1ëmç‘ç£8P∆?è≥ù±AlmËÌ π¡:2MóËîﬁm‹X:~⁄£8Â†,À¥ˇÀÌîtª˙˝©ûT^◊¢+\0¬∞^£Uû‰`‡<,MWæÈó¬t\\úÇ„í+äT√Ñ\"^J%£VÏüCy3BVtI ppººFÔyöﬂ/s‹Æ¸è£}G‰T@°œ‡!éQRÁm`∂™à+N˚*u∆6£üNÉ‚[ˇs¢<ƒé)‡√ ∫Z√ﬁ9QB≈Ê≈å°∞£ ıù¬\'˙GË,~Iúf≈ô¿Ã÷õ∑NüoÓYtç°øÍ£—‡8q£ÈsM∑uï±[…◊•VW©–≠4pp7ŒÓÌ‘£‚;¡û≥§\Z‹ïéAäwˆ‘W°II°w”˙	âêÜÏ|£‰•ÓÙ∏d 2LuõåüÃÈÉÌ=#œJR9:x›\Z´z§ê\'á”#m:ÖuZ«∏»>ç8–˚®¸∑Ñ|◊Œ{K§i™≤E<»˛§z?eL≤<M\\°}∞§vÉ≥6ƒÛ§\Z•8zêRv`›\\.Ä)Ôä.˙^¿¬Àpƒî∑§/E{~2	Evöì£h:¶m˛ÓwµWÇÂ√dŒ”®$§B|Sû1,∏¢|Ò¢K∆Y$çTTL_Ã|£h®@ﬂù§P%ﬁHD>Ì§øÛ Ÿøff?_À2ìY\0d#v¢«Ê§TúÑÕU˘–¶≈[TmGÚna–»mq›Y\nT©orqKK§crµ <#P5r±hf_áD´◊m÷îmNˇÄ+ôKè¢§w<PBÒÆËZC˜k∫SIæQ!è⁄\n}i§{˜VO⁄u-¡ø“Qd;⁄++O;vúDÃ)(ûP9åh§ï]Ìê,v…Ævñ¿ö´±JM (0(&ô#åÏü¥>§ö_Q7%ﬂl|µ[ÿÙül∞|…‚ﬂòA”Üñ¡Iäºé§ùyÊ~Ë˛¡k\'$—ë±ﬂ„»Ë^ŒY—\"Ω†awE.‡Î§Æç¶„™‹5˛]áÏÃ˚Æ~¨Ωo]bT›≈˛\nÒ√ßáŸ-§ØåG”‹=ÿ√[ˆüFJ¬¬4Ÿ@ê≈∑û¢¥Êqa˚b§ºn†dÂ´…\0˛ÿnø¥Xf6?,≠¢Æ= §ù§Œ ◊K\'ﬂÎ9àÉ√oód–?pàÚ‡GüZ{Å‚e&\"§”SÜ¶ø\nT§kÍN&(uu0Ï!œ©7¡$öV9’§’wœ|⁄N\ZvFd6f~úñn∞d›Z$¬i*ñˆ\'lA§Ò\\`îtoÈÀÙGﬂ„\"©›ˆÓü*∞˝+cW d´§˙ÄîΩ+™ŒäMÚ?\ZÅÚL†ö˜∫r®Z%\0Ã\"l”•YŒMÂë2£<Õﬂ	VTo¿^%F„î_Dt±!…‰ç•gò©NQ	µ†Øîäã/Êÿÿ	∑y5ìØëêØÍŒ∏c•iπ¥	àK∆N5⁄à˝Ge‰QB≤˛ï\ZÔ≠k`Ë√§•mu¨§9≥u∑H|•å¸ óÿ‹ñaQL˛≤÷UøûΩ•á˝0\Z˙~{vhúã‚è∆áÁwíRjIyphÛÅ•gs•å˛s†—&—:∞◊C„ø©‚È\r÷mŸ9>zo|.“ÛÆ•çH‡¡ª‘Ã∆⁄iû‡Ìçc˜!ßôI).ehàµëØ∑â•î\rç«©ÛPπ\'‚RÎI—˝Rõö\0¯®ë)ﬁ$≈u≈•ΩåÛ	µÈk—œf]W^\n≤<†Ë¥°€˝çb_Òƒá‚•»∏[G∂à¸&RÅ9ª2‡Ÿ&≠ÄD¯DcQ°‚EQ•”Ç_üoÛ˘âèfIo	ò}Bí3&Y$PíÙ§ •Ú∏{⁄kZxS?Œt\"Q¨ÆÎ?ô(£nær3˝˙•ÙåΩ¡A–Ã¯˜]]Îhiº≤»{‹ ‘Éë∆ßc¬JÒ•˚}|ëﬂ\nÕØﬁ∞AÕ(>úµj÷2O∆û}VÍO†ª◊¶wD—{¢so	àk–ﬂjLAŸ¡£¨ûèRÉ	ÆòV¶\ZzæL0•¥Qwbﬁ√◊Ä—Öù¡àñfRË∂=k≠«Ê¶&©Kïøps÷çy‰ˇ\Zò@?7GüêcÆê#EUõ¶)˛‡Œ‡œµ9ÙD[∑¸˝•.NV‘KuZï\'ﬁÇ’ê?©¶0◊¨·®íñÁˇ–;J;\0±j=\"(â’P]<Xı¶4Õ£m%ÔÃÜ\'†∂?€2¶[¸QËÄê8/sG¶7m¬Ì’wﬁ){∏\\Iç è\'ÙQ}mÀÆ$“R4¥U¶:kÇ$‚Gw 1Ê@Ôº…u≤iLƒ0Kƒ∏:Ï@¶E^ÿõâ36ÄèvçëÁ®!l{∞PVw¢ÈS·¢!πn¶H+ãÚ\"Ü\0Ud‡ñ:¢û\nıÍòO´ò*îS–†¶L˘ŸÑ˝üÏ.\r>÷õn´]–æˆ¯√9˙^	∫aÇ¶ZÀ_pÆ˘hRf}ºÍ	PﬁØöZô{÷¢JÑ¡Zº¶b±´ÕR´u+Ñ$Jpç)€∞#Ëò•å>ÊXV%¶z_X¬Ì@KOuKMFÅ©¯ıq:ÖRSOÜ ôÆu—ù¶|=oÅ%-ôì„ÑÀ˛t,uÅûë∑.Î‡ÿ Åó\r¶íHxe¨UõÁÃ“Í˙¨UHKÕ^ÏÌ«Ñ_%∂◊ö˘ã*¶•∞π´¿∂\'ÌªÜ¸˜Blm&µŸ¬ö^œ/Ç∆ÿ±-¶∏ÒMp†ÍÛ˜#<_ÿÀ•d^ùª ∆¥‘œ”¡5Á¶∫˚Óƒ∫∂Ãåª„&å˘∂÷≥ñÜ›4@78·ÌÙp¶ƒõÓnÂ∆+‹‹ÇÊÀ¨‰ß\ns5Ã¯‹*ÉD^‡kä¶ 2mi^∏+ﬂQêf˙\'√N,äntR&Ô«*á\r¶’SàPúKÙ?xª7≈.ﬁ˝’û›*L≈u•K÷ç¶î‚v2Zg“,zÍ[^®£◊Öî™YÁπ˜g¸ˆv¥¶¯˛˝‚≠§YZØV%õIs!¡–±©ü‹j8>∆\0ÿ¶¸’¸õänÈˇG≤U¡våËiï•3ëDº¶CA¶6D»¶˛∏`ÌLs<Ú≠Úä≈¢Ï€…ﬁt∂Eß>Pı™Ùóﬂsß±\n#HNoé˝≠ú„Ó&Ì©¢¢‘WZÍÄÃMlß5∫˝e)qào˛uvRØº⁄¨®ÕÅ#ë¥‰[ßqOyå4¯`5…•∫∆)æd)Ã]≥\0J©Ûó|MπÙôßs¢`bFú+¨u\0≤∂#Ø\rÊå Lm”NﬂåuÆã‰Ìßuc^=¨¬°DU{.°ØˆƒØ.’ø•¨]‹Ò≠d0”ßzEvGL7Öt|⁄%\'åß4ë∏%¨“fáp#eßçh”-”ƒ¬úºh¸8q9¿π\Zx≈	≤VGí%%h/%ßçèRÒ/∆‰ŒÆqÈÚeG±F^6ï`vëBI	ù|2ßóPS?öhF¡Ma§¿Ê—»ÇUê´E∞~zñìﬁßû#∆^8ZıÅΩÄyÄ©7U‹≤∫={˘åsÒ‰Œ&àFW\nß™R_	¡\'ﬁ◊Hôòu)W∆C}”D&õ7¸,HÇß⁄)m-»EN”MÏîA£√˚™Õõ	,ß_~Y◊µ?ckß⁄_\0°TÛ0yÜkÄıÂÊ„M38ïWå\\è„ÂQ7Fí\\ß›14ÅgÜ3—¬\'%¯L| óÉ{ÌW%ŸÍ_g	∑@Mß›–\'˙ÆFï|S=’í·Ô´\\[8°(YÓˇYÍ˚¥ßÎVd7{mˇ`Cí9+ße˝©fπ“Ø˜6áÛ†ÍÌUßˆ\Za¿zﬂè[Ó_îK†}PÏ√0;∂r…ëB©Á@ç?ß¯@[P◊üÚ—^ì3Ê‘D5Vw\0û\r\'ÄÓTÀÌß¸˚P¥Œ¢`ƒòeûŒ≠â—uˆ¨–K>fLò/®lÿ4!Üû\r¡†Z<õÛΩáPé–l∑Ê—_‡≤Œ®¬/ﬁ\'F9r\Z!Ê–p©Ù\'6D;%^-˝xh¨®%O†4êy:Xî0ï÷^™YuGyDÒ≥Q“˜˘b˛Ï®(∆g´Ep÷Üı£ri›ô°hFï·Ë=ÌÌƒyZîQO¿®/›L%≤Ú¨@€=≈¿-ˇñeÀŒ-I+Råû™∞z˛®<\'‡ —ñr—vqSíÂKU7‚Wàﬂ§_i˛Ù´9q®Qo	A˝4f‚îgSÄ∑’á˙hÅ%=ZãNÿ=˛_®Qu~“øÑû˙$3Gùç¬åU4ø&\" ÄKFÒß®jîÈ†T(¶5¥Âó›o[·âÖÈwïO´P\\ë•>0®ñ3	ÊÛ{Å…ü”a√6]0\nÏø*…(‡)Œ\nê¥Ô®ñ«ûüå\0°ìzΩv˜V€MAJU™laë1 ∆∑≈®úürXéù‰>ﬁ€åÛ5S∆§H[{äÎPgºŸ®ùºVÃ!6\"	Bò‘–ÉÆ´h9ºØ€Ì.ÏÖŒF≤8Ñ®£ÈÒve8˚:ΩŸÓc;∞%Ë⁄t}5;≠F[†?EX∞®∫nÿ¥G~œZæ›∏ßµ\\¢¸B[)π¢zÏ∏ç∫„m®»¨O˚°Ö~BÁ∑|A&¥ñàö≈˛›Ü≈› ÈBJ8?®»3ßê^í_Õ¢òó§π∑op ´çUCgwﬁ(i~®ÃMz„ıÂeøÆÀx∑nﬁª∫Xù),¸‘#ñ”®÷¬˚œ1ª∞Táz|Ÿ\'—¶ùUf+˘2ÈãW[NT©\0.l>Wv&„ŒÁÙœÒÓ˙q©vß+ë¸I≠N~ûW©L Ù|F≤ ÈÉÛKGO™]à5^˘AGπ\"$ËA[?©æ:“M¿°Á2(√ÃV†â£ÊóÂAì¬Ï/|b˝ë.©èÀÂ4”L\'iWFT≥–éÿôáÀ—‡r7„¢Óì75©F|Dë†FIJ”5Â3m÷À,Yl¶wêN¢∆ã¢F˘©e\\\\ù®áØóy2Ö#üπni¿¸‘˘FØ3úíÊ¥NÜ©r¢b0ì„3jgü⁄—ı•é\\˚ËmPﬂPÃjx‡©Ñ„˛5ÊîP˚$j‰®Ûæ\"„`ı\"vÀRÄ\nÏ≥÷l∏_©õ÷À9»ßnã\\\Zﬁ¯ÑrªR„\\®Í∞™òê¬Ù[≥©∏O‚§Ûoô”¯˝\\.ã¨a†8‚˚úöÑ4r¡5$Ü©πãê	±C\nÜ\ntYˇw˝r’cº\'¡Syª˚:G©¿`}.˚,â]|ÌÌ∫÷Ö›–øü–µù¬¡I¯Ü€©“b±¡ñπÿÃö˙ÿ˘◊˘‚w[$Q≤”¨h,∑a™ìÄªÅ\Z¯∞Œ÷˜cN∞˘CÖC˝n∞–√∏ïøÇÄë™ì\Zœˇ$Öä#„k\\=ØØç¸¨ZÆŸGÛ¿v≥◊‹åo™Ë©ë®ouØj>Ç◊]¸7!ñØ§”ák™\raH%o»¿WkåœhÑ∑¿0io≠|¨∏‘ß¿3™\'»ù\'¶Ÿc≤L:b¯”¿_‹LëèXx˝0I ™+Q©∞–;ÀÒﬂ/ûhE;Ë?T“8ËV‹í†íó˜ÿ™A#IàÉîåà’%d{∞∞FƒÿÌÔ\0+æ\"6Œ∆π»™JIZ;wË%ó∂!’ÈÉ¯W9ÂÎ÷—±˜S√	}Õ9n¯™N-Æ>ï£éƒòtŒ¸¥Ø¸B‚¢/‘£(qÿ˙‘[™T&¨‡7,«º]m+7â^¡Í´í®Æ¶Ü˙vÛK7™[E®u\r:ëã&iÅ|:†50= ¨ÂSçˆUuµ5∞≤™^_w|)ãW6õØŸcƒ*&ƒ™—˘]õ€«Z÷Ò\r4¨≠™tÑﬁ˘„ö\ZÊwMiﬁÂ®∆êG>B\\å©ègÙ—™vì`Œ(1in£öéú ◊◊5U{I‰êoÚ4êBµ™éÓ]íSfÃ1–Æ#≤8ZLΩÿ˙Û§ı¶†Ë}˜ÂO™ñBÂ»´[yÌ˚∑Åâ‚Æ›}BxwI¸ZÎ–ß &º™õNáÿÂ-)Õà√ÊªÉÖû~5»|zI(:.ÔÓ£Àí™¨*üóÀgîH-#=a◊$-ì-û9\'¿c⁄™≤Bæ@\\HıN8æP®·ﬂ£ÌD∏Û.¯¡¥™≈uúΩí∞Ô¨«ˇ¨y›~B5v⁄7[õk$l»Ö<˙ÿ™ ?I&kΩú‘°ËEïYB=≈b*“øŒ3Ft™’ö¸æîË Q˚ÊÜêDºPïŒÿÇ_?y—`å£°¯´™◊5Ëm¨{ÊTç‘<gáFÅ+j\'áp˚çQú›™˜\"}≈Fpz.∫˘∏T‘&lG¢≈M©ki_Â\ZñQ´\nÄ]Ì(õ¥_èÂ,pgi1î≥ı∏}˛Ø.íÕá3w¿´´z¢$Wê<§ßleP[ô?Ëçâ¬¬pÆ>ºÀH’´#j—À#E¯ãÈ^C≠5¨Ω≈ë‹î)=“=mf„ht´)\'´®z1*ò~6∫U„EË¿ ˝¸ΩëÈÊ4ï[kP´1¢Æπwø”Æà„ˇ\\‘¡†^Ëˇ∂∫`Y~õF±´9áı-…a9RdlwŸj√RaÛÈS(7∆©¶\r‹\'´Eº^¥ørnÅ‚Õ2Õ™U?ÇÂó∏W\\ÎVöe´L,A/ö\" óõŒ4Ù≤zXÙ1È]ÌØºΩ[∫´MT@J≈ÅÛé˚mÅ‰4äN´2a0Nm).:Ù“™}´]ˆ%ºv€‘·cæ“›àç¯(˘YªìUe%√!∂TF´iÆ/4áiÌ“ê\n!<®âjY∞|BQÛÆNçp⁄wx´o9Ò∑jõ:Og7(Ω˚d©¯KQA™ìäÅÎrU⁄&´≥©õÜ¢Z÷¿®~f˚,È∑ø˚ˇÇøΩ‹ª\ndöä´ü`´4œ.≠{”mœñ‹Sáæ®‡9\n]b¢G+\n(x´£©7ˆ¬\"ÄŒ˜Ø\"€5nûÇ“€”ÁWIi…—“Ëa´Ÿz§à_›Æo^2S\'ŒVAF…Xˇj#ªñ[Õ´‡3´HŒœƒ@!äΩ†Ìﬂ¬+siA$uN9µTµ´·+†Â´∆∫D¸É=∆#ÿw¸j¶xÌy”ãhâOB.h†´Â2öó;œbI˛qá„á€ÿS√Ó]ÔBö…^	˛ÌQÉ´;fWçV¢ï\0s¯ìlË‰^Äó‰∞}!ôß‹/e*¨\"O-4_piL\0Q[\"Kr &&7´√¡œ‹Zd\r±®¨\'ﬂ#Ñ›W∑l);*ö=π$∫9ø9Ocorù]‹»¨-Ò b’ﬁÁ‡ã`¸‡Â(®dƒı\n#‰D!ÜÍŒ¨:uË®s®äWO‚˚å“ˇ¶(ˇõPXæ2÷õt ¨=¨ÁgÕÁ¿yî0&Ã˛Ú‚Î/Çj€‘Ù¸‹ó‡#Ëx¨V¡eazù”¬ÓÂﬂ◊U‹û|-äı¯“»T°[7≈|¨|ÔæAÆ©tu‘ÃŒ∫ia2¸§¥∂Ø€0∂ä≤—ÌΩƒ¨û]FõõsfËà*ΩMåö\'{HsÉ‹˙©lÄ\nmL¨≥7,M!m€ñ®ü\n˛=FK 	 .úò.>D(¨≈€Ÿ™ÏO§°ı-¡R∫6îÔß‰W=±˘q;7û–6¨”‹oÊí¥≤\rV>Ÿ=É≠5Ç¯ÛÖËçtì”„[ﬂì¨ÈÃŒ€\0˙¡Ó®©÷su¡1†h,OT≥ÆˇùUÃ¨Ì$®&˙^Ä9∂]Wg‡Ω≥Gá≤–”ÿË\">≠JÆoíe\'§7XéwÜ(öucãJß°∫[1úΩ\rê≠ZÒ‚±ö[±Qj\"é0ZÇ7◊≈-WNá5é©‡≠\Zï/yF˜˚≤&í∫∞ÔÎ}=\\HÌ‘V@r\"ÉB≠ ÕÄzœóo≠÷ø◊ˇ≈¢ƒ&Œ»£™è%;GÇaÛï≠3~ÜÇY∆º\n\n.fd˜ÜŸ\\>8{ŒÜAHˇJ≠E¥ö¨„´2¢> ∆ÿ¸õ1Õ}á∂¡õ¨ì\0Ê:a≠Tê‘M[ç–-o	ãâ_ÛºÎ\\f\\ƒçjïtÉ∂±≠z\"›HPØíü´lÑÁº≥πÉ¸?˙–x4—P,ÊEÂÆ≠}a∏b`·ÄZnÊˇ†˚†°/ü^5Æ÷⁄’)≠öoÂ∂è\0´≥5¡…Ÿx ¬Ä%á,ì_`˚@·Ø¸Øcé≠¢?T¨àDÙ›ÁBuÆ‰=781¯Ëzˆ`~Ä√ªö≠´ÈÒ“R\'Çµÿ)Fˇ]\rı^õÀ”n@≠h 5‚≠±ô¢à’ò∞A-z‹’ÿÊÚºÇ£”.k—ªÅ/ôÒÉ≠≤V\"5PGîï±7Û}jÕ!ñmYZvàØr•I∆í∂p≠√4ªÿÒØßÊ{±∑âJ⁄ÕYE‹ç‘x∆µƒ(±Ÿ´E¶≠∆µ÷·5Á¶d„Ï=?NÆrŸs¨©Ω˛Ê°.£Pæ¸ç≠–Å√§O∂2…:~Ω,˙÷)Z–UﬁsÜk‘Ù’\\u≠⁄$ú™è˛1£J’ñí3œﬁ1G3p≥ª¯Ròm€ÁèÆú<Âè≈®Ôı‹Ö˛«˘7i„UÂ\'£®£z∏:	Æ ˆ6˙¢ÓàÔ„/–z@í÷6Tÿ&\0‚CpõÀÑ∫äÆ(ô•$µÄÉn≈Tw¶V˝Ÿ’;–¯LQè72ÄÆN«¿Õã-mœﬁ4|¶0\0;§∫¸∞WÀ4Í≤bàôÆQ(…û–˘ˆ@‚tal2ú„Xì¶ÊÉÌÊÀcÊ˝ÔIÆRL∏˛èû 2è9Ç°^îdØ6_V$CÅü8t‡{SÆ\\†ùÓÇ“€É ‡ÉIÓÙé¯£ÉbÚˇ∫\'h∑5⁄Æ_ù˘∂ÿ\ZQ…íiÍÎàôO∑s∆Jô:h[æø⁄Æ	è€Æ_∆/SttÚR îÂWÈâCUŒx¥¥~≤:rˇQ‚®Æwπ•òÜÖE˜Ö¡ı„pøÃƒV—º‘Ó¯¸¬scƒ`PÆâãEÿëØ]}ê†‹Éw˙z,Ù˚<ö‚?ßP™‡&‰Æï#Æss¬√j6tv®Dz‡ELZûdMÎ™∂WáÒ9ÆõITLc´¶r\\˛h	=YkHTxDÅ£e‰ª:ç#ÆÆÚo±ê0m∞ˆœøi¶˙yé˚ÆΩ≥€Ç˜l|4¶h¨Æ¥NÛ¥á“O~%Ñˆ\n}\Z∏∑„Ù¡HúÆº[6âa˘âüB2jf◊7îÙúπ»‘‹fL~E‡lªf\ZÆº]Õ‹§VB\0nú%M…/Ç™[◊„;Ñ*¸°ˆÊõ˛ÆøÈŒ&/ˇ·_≈ÙËº/Ä!Ÿ ¿rÖÿÊˆΩ¿zÆ—¬æ¬¸†‘$et⁄¿%±Tn5î«?É*€BâRg≥ßÆ›dm?¿‹*\r4õ&#4∞NúeTs«–êﬂM÷¡Æ‰!ôr≠˜ÀÈŸ£Œﬂ˝ú™‡0aÍTÊ…\0‡⁄≤å@ﬁÆÌ.m)§N„uó¥40ä¡ß∂ùd0nîñh\"Ìæ$˝Æı˘ƒWwYKL\n≈Ï	-*˝Ë…^e\"e∆(_,gØ\0˜$Úßí˝\rëøÃO;zjJƒ“,nq ÉU8cØ≥Ø¡ºOæÅ\'Ñxô‘vWó\"»¯„jC¥+oìÑ%~°úØÂ´qı≠¶OÙ\rÌÔˇçÔòÊP¥â\'ÙßGrHqê°Ø\' º¡[yâ-NƒIzc`Ï#…’”¸ã¶0ø—ø˚◊ﬂØ;Ñ⁄˝<	`>7˛∏Ts|˛46ÈØfííBØ!Õ{ØC*iŒÇ\Z\"’‡cÂ9–…qØL£‘¨Ø•∑ ‰*7pØÄO6ºS`énÌÙ±jÛ∞VÖFmT™`¸¢b3&ØÖ.√j”„›§(qSj√p!pu›zI0J\0á¯Ÿ&\\ArØ§÷ævì¸∞ÊW§µ^‹®∫‹/Ñ,®Gâp¿˙ªƒﬂúÅØ¨„@dÜÓ«√ü-ﬁ»ß“õÇ∞“x≠¿ˇ∫Fkb˚s‡zØØX§òhã¬%˚Mµœn¢ÒcCE+c:é•\0¨e¬Ù…\rñØ∞ﬁ™®Î~Ñ\nÄM◊w_ã¯a<Â>V‘Xú\Zl‡˘5j¿Ø≤~d3£ﬂvç_hÚi≠–0‚7‡«ß?‘{eá&¯Û⁄©äØ∏\0ÕÕè\'4n@Ò˛√”ˇÃÿ\Z•.„^¯diä$GŸØ¬6-÷¢\0•çØq˙ÆÒÅxw&a\'çv˙VÁ∆“ßØÊ#Ùc« wrÜ4wç≥§°%}¥P,Hˇ‘”R(º∞á∂Ä√T˜©6a˙€\"@ÄöJ¬mœ l/√âhSŸ∞ &^SÁﬁ—h=ç.ÈMÂ\nÊ‡6S€Q˚„úaHtéû˙∞8hïëùÌs‡Œ]ó±\Z¥üU*F˛∞Rg:Ù(Ø€B\\∞L≠|‘ã‡∆\Z/À5ññLr§Ò`[™RBîÿôW*_˘5∞NÌñ^Ö;‘Î¶&:¬ã†∏ò\nW1*UÎyKe≈∞S®!˝.!êÕƒ¶Ú5Cè^ôû’€å	¬õ±ƒ∞|vVÔuæ≈MöM=rvÉ¬Ì^\"r-é≥$Ä£„Õ∞äUq#\0∞˘áÑHD`òåÙÒ>Ñv±‘Û∑+íOÎ€È∞ò7ö˘¯Æ}\\æ:3“π∂\\âdAÆìye8h@‹∂∞„∏sCU⁄‰‹)ÂOÉtﬂ∂èÙ‰Œ⁄π/m3R´?‘∞ˆ®§wâ”˘≠√ZL‘π Ù´Ú£∑¢5cÑZ˜ÒS∞˚.^\'⁄ÁÂë∞Ü%‚˚J( Váì†/+®µMËÃÈ§±\0‰.y€3ö6™x> [/.“tT¢]√wpX◊%˛ê]£±Ÿ∫~|4u·≠˚õo–›Af\\ƒê˙Q(•·û√ã±\Z¡†%ﬂ÷|^øê¯∆ƒ]ŸÈˆYÿ^˙F´†#c*(ÿÎ±#ú\n=<ÃeÊ„^†“∑\'#S‚=wâW|†K:”\0¶kG±%øôπoC‡∫ÿÇlı\'¡ªNà\nñp_∑çòÛ†ƒé®±+$›iÁ7=Õ˘òI˚5ô∑Ÿ„ŸiBê÷‹4<Ôù“±,Û‘˚F»âgïßMèΩË»Rhj∂·ÈYÄÖƒ±/ <)ÆÖöÍ®p‚Q∂ –öíÁÖP_s˙ä≈Z±0TŸXåÆAÒí#6{»K>Ÿ˘~®Ñq°I‚=!±486¿∑—>$–Vs yJy9ÀDû \ZÃ_`∫X?4∏±=!ﬂ\\ÛzóRhp⁄\0\ZÄÂ}Öø@Í,Ïr‚Q‡!ßUÒ±fY5•u§°‡œ±Ä\n¯EêõfaqŸ“∫ßøZ:˛“±âÖ˚«b∏ﬂ«L√n-#[\"ç6û1zvi~±ä3gπF\ZŸ4\Z/«…¯“ó|C˝Aªb9Ñg‰˜=±äÿ><P∂0ñ\rîÀµ≥Í°Õcöá+\r*+H®\n$^—±ì¢&ù>HLi#a\"£¥¨ÿOøfﬂ˝,–8ı±õ,M4aµ!˜É_~—ö‚CO◊¥&Ö¬8“Y≠:Ìﬂ_±¿ÿâ¸ƒ˙ÖÌˇ\'qPó#≈∑úü[Ô®‹`µ~;±«ÒH§kMX÷M“Lï`b∑Ö÷ˇõ:¯$πdÆ˚ö\r±”ÊÜs´•À>£ÑßL>\n&îHÅ©Àº>#ÍåÜ≈◊7°±◊9\\+Õø<wCœ“}ú\"	∫≤\nT)Q\\uß:Íb&p≈±‰ˇ}ÛñBH.Gó;d\\Z√·CœàçÜ\Zo/›˛±íb±ÓoÔ#¶W¯ø◊±≠.]H>Z*0˛¸Î„ooæ±˝º±Qwf<…Ø]ﬁÚqm•Èf¨ë~µp≈ºˆ=±˝¿LJë˛·•hÎWgy>πÄ !}Y˛,:öÑvŒ≤\nﬂ¬à.üÂ™›5Y∆6Ë”}ßo—üi-Ì˝(∂~Í≤	«W˜œÅp`$<ı\\õâ5wJkSf3ê6«ß«õ≤mÇ0*@/Û¥˙WboûœwZï¯l\'[ë«Ÿî\\6≤1Èi™:óâ©S9\\¡,$Ÿí∑»<\ruÙv2 6ûFg≤Gû,|„8Œ⁄”Ó‡£…i1ˇ–<2⁄,á8’·+w≤lUôëÏßy™íu##e´d‡	–A3Q5ÇRª≤p1\'rÎSl¶º˘Y(7wA‰£„O)FP]ô∞ƒƒ„6≤~\"ÉíÂﬁ“?B¥wM“≥(N`€qñÿØ®©ÕU≤îî]Ã“Ü\0ÍÍıˇB∏]3™»€´≈#…Ì…C‡d5F≤úC;‘©yNπ®•*)J˝-∞™ØÊﬁ¥1vÙj.≤¨óê°´•yá1πB«∑«qk\n*;z√…›8jöÁ»c≤ƒÒ£¸q˝#ﬂc-aP‰ùF©& \\(◊1Ω´˝£(R≤…ƒ»^¥‡ßÂ´\rmü)·O7ïx{@*ç;„=ç≥≤€èÀ–˛@ä¯s‚Í„≥;ıJ ò[‘óI¯>~ßÆÃˆ4≥\r\Z´÷∆$A˘C—SwXZ{}ªajÜD˚}b–9≥-úúœ%´\"Ô!Nò€_)‘\\öòº¡˜*1√∞Ô‹í≥5o3òñrX\Z”&?˝¥V\nü )ºKë-¯„MÈ$°≥≥AÈÌÕå∑áÏk	´–/mßÒdÊÙÛ§ú”≤js≥EF¥<3ï¡gìè´{\'¢mv~ÆD•EÇfM≥NºÙêÅsÍÓ\"*\'7¥üÇp$i∫xøºî¥»≠§vµ≥`ïˆêG˚¬J√yï$∞:Áxty*YÕﬂ∞˙Ã%¸Ï≥d´>ƒ˜Üº∫	¢iÏHÆ∫¨ﬂb$™&ûnË‡Í6óp\Z≥Å^H\Z&E5CCq¬%“.AB∑ £Vû⁄óÂ˝øC;≥Ç7\" AÖb®IYIÑ\0Á:ó)—∑«•ƒ`wcw≥ò\nûNœI«≈÷+œa\Zs Lz∑fŸˇ#4C\rVvÃ≥¢Èby:âÉ8õ3˘≥oﬁ\Z≥ıäÄ±Êìˆ\"⁄π˙≥¨Æœü?ÆÛò…êj§òÌAí>V\r÷ãou∫ÿ–≥Ø\\.$k⁄Ω¥πŒöäÅe–ÌhÅÅ±nÀ‰›n!!ﬁ≥ªµ}ß«ÕiºK4KTÛTb=2U·ä∞OBñπ`ë≥À≥∆+T§¿Î9]À-!I˝v„√sñ¶[˝h˝ò˜œ?∆≥À29ìº{∑qKŒæπè–îˇ!°ÔI\0ûü(ÒI`≥”∑ó€Ø	(Óí√hs-‚—ô∏G´$%TBy u©≥ÿ©‰˛xÅá◊ô;g“dBü]E”\rçﬂ‚r8·˘Ôœ≥‚ù+N+R‚fË‡€UPt©	‡9·‚ôx≤ÿŸlÜú≥Ê2≈™’[j∆óIhâ¶*È@I=ÒÉÿhã§¢Q€¶≥ÏÔ—Ö0r√ß\rÆbR vO~∞ïnw}ﬂØûgK3’èt¥ßπe¨$∞DvÑ≠ﬁÙE£Z6‘f—∏Ç+(æÍ)ø—¥!†ÂÁÑ\"aDr°9aCá53Øß{ÓÑˇA÷{™¥*—çb2Kwwq“øπo&ïÓG∞DÕ¢®a\\ÙLÙç’¥+^¬	úú…p¸£BèJ∂›x„√»7÷?Q·±∑£[¥=ÂåÇﬂê»’•≈^û¸‡€¸^èø3P≤Í¨ís¶¥Iáã!‚¥¡ì>¢∞™@ÅúÚYâÅçüõ{≤<ßò¥N“ˇ≤˘a+‚Éûœ78c*QtœS,·8ŒΩ‹\0¥T\'µÎL®OOxó¸‡Z_E¡1’T Ù1∂VÓmH¥Y7tR~„ÁÂ∂ÙÇkî{öôYã£ÿD+)Ó‡Y;¥]ã∂âÏ^íœe-+âAænı÷Ú˜5&·Ø˘_Å‡ˇ÷¸¥q4+SHÊxÊƒï{≈?fÍœm3•°Õ»`ÍˆaÛ¥à÷ˇteBƒK82ÃΩﬂ◊VıÂnF{‚i(¢˘] f”¥ª°˚.#,∫áﬁtéç\0W&•ñ∑≥ë‹;y¬cØàü˘™<¥Ω‘–qŸ–åËÀ2ƒ˝⁄Ë—˘è5›∏Á;àÕ‰NÜk¥—˛=xn“Ù%˛vA†î[•y8nÓ\n	(hÇ!˙¨e¥ÿ˜Æò¥kbûHküµΩˆî«[b0Qy7«äåE¥⁄3Sjz≈$\ZM]∞6åò8ÄDz¥˘£kTykm|§-¥„„Ωè@√ñ]yë%U?úvwêXlˆ^Ò{q ¥ÏùDõ6•8ÖNÛ?£%aP≈ß)Ö]ÅNC–1°Cˇ¥ÌLÛåW\\M!DJÇyÆ7F·(<\nì‘¯oM,Z¥¸óÏ`1OÍY—Ô≤ÜAæQÁ∞Œ2:¡*Ï†t´”\n´ˇµÊhO|â;Ãz(ç¢√âä\'¿ÀÙ•ôú£•‰˙µà;∑whë{·#6˙ÑqY¶}ËΩÊ6GW»èµ!~È˜Î“ôZ√£œÉ~S‡‘˜åûLKjèJ|®µ4û¶<«&Cn\ro€ºãó0+Àç>á|ÃÓPJÄ±Pµ*˘†m¢ÙlπÛ∑‡@6T—ïﬁ˝\"çé®ã“∑ØAlµHügØæ9ˇëLƒ‘∞MËÙˆ=w¶:UÆK◊•ÆêDµIÔHÁÓﬁ÷˚ŸÊ†&dtM6◊Á≥&π€µb°Ï8ˇœZ	kô{Ÿ<ŸÖJìW©≈»~\\Ïû¨2µc√„ùﬂ\ntŒÆJmI!K3|M“1™ı‡j°+ÃH\\ËµdyÚ÷ˆÇˆÜq±úE~íﬂÉ!ê‹>\'câÎ™¬sŸtµ≥Z*J^›;6‘≥\Z~ùID’Æ$x«P’iAU-µøî]Ü=ìó©\rj1ï[WfÓ%îø>qp<’äœ\nÖµ⁄æ≤)Ï†À^^»c%øÊW≠Ä£œmûíÕ$µ„:\'bL g›}dA	º,•r◊ÊÙ∑€wùKw/·>µÍÚ&z©k· újMπÆU:~oáç„—h•}π5Æ[µÔ;ƒRf™Ò…à∫5‰k_Ô˜ÊjQrÊ™QµıV€\'È¥≈d—M†ı2*^‰∫\0Á\n…qÕ#\Z‰â©eﬁµ˙≤¢ä’I¡Tv5¥‹ÑÎSy8˚#±ø‰GyF‚ùÃ$∂\nr`ÛËZ˝ØçpøGáG*∂\rr\nôË>|ı´ËY∂&îW4x¢∞WÁí™¢Zú)±é\r‘ì(aÔøy{;À∂2¨f·∞Qò,∆Ú—·—+<∑\\\0\\\'ô‚Æù	æ˝∂3G”d ﬂ¨Tî≤¯*ß˙Äß“¬J\n√^D1ö‘o∑∂=·ù$(1Ê¶˘é…\r€ñô/˘zhëTÁ<Õ]íò∂o÷:x<UqˆPJã}PI†ÃI]Ëëy l«H\np·∂Äu⁄˜!∞4ﬂíÌ»›jF™\nz˜„\\Wö‚ó|Û˜r”∂Çbœí\0E÷0+F7¸Ãö\rñ<!-:Z[ØœZj‰˝∂Öm`_´ª¶ıÔ˜2Õ]‹\"⁄{(4´0{¢÷£¿Îé∂√ÿ}\rq;;)DÕm[äˇ5≠º!⁄&Áç`¶µ∂c∂‡>?`(›Æ>Hf¸=\\√T¶-]gûàròîï{Ò∂ˇG[‚\Z†‹—xÀ∆DsπuÕ¶˝˛—ﬁ±√4EXD≤6∑\0Ñ‹óDì¨·”CèxﬁbQfârﬁ03â_LAå_‹»g∑20mz¯∑{T()1÷Z5-PqçBÒ·∞–“ñMä∑Gx99dáêåîè‰ÅäNé˚Á5ì´Ω8˙\'øA·∑–∑vNtçvjµˆ©I¡˙?!˘\\\Z\"ÛΩ4·Ûˆè<µ4∑{}àa–ë·8a¨;[\Z&+:˝3WÁÎ¢Ö?\ry§∑¢œQŒÄúŒ∑Û!Le”Ëä√s©§E¯g#‰\ZwjÁtø#∑©•≥W°Â$%[ó°É6Â˙”‚¿Pm™á¥úÅ\\I®Y∑∏”*ã“Ã%vbb<J<òØs¸jÔ⁄ƒ∫‘¥Uz‰Ô∑∫Ñ9˚Á∏ô;ÉO[x`ó‡*„8H…*rù˝.ùPÏ∑ƒ#ZûÇ÷ıv¶ä:º.N“M≠VÊËrz$…}Ù9É∑ ‹˜:ﬂq–Cúª¨†>,—|íÁ4ˆÅ«0F|=≠.∑À·2«ê•ﬁ{ÃE[rƒPE~P(^…ﬁ\\>]!∑’rÁ^8¬•Z#uøÔ`ùÌx+I[»0ŸNâM∑ﬂ[x‰V\"2√˚FÍØqÁ‚√á√‚ìıìÛH∆ï∏4™Ì£6#\r0Jö7\0Ù[i˘ırÔBÅç¥ÆŒ„-p∏òÒ*©i≤Ø∆≠1’Óõ{Ç◊(H» ‘åÊDÆü∏ /˙ëClgıí9NvÑ∫‹DB\"÷ÍÏA@%Ä∏\'+hÁLÒ‚ë∆÷^^Ó+Ω#e∏)….Ê\\µQ‰à\"Ç∏6zÉä¿}_T4xÊ∞Ùm˙ça™¬Ω#E…¸â¶œÔ∏>uó‹·ÙXò$={+c‹ßl¯èo—‡TŒ\'.ıóé∏EãìﬁŒÓ]≥·\"f)|ÿns˙ˆMÄñdm⁄À∏O—;v¶W˛Æál·‡+`Ë`B¸‹\\œÊ&kkä˝Â∏hÃ◊i€Ô¿‘q≈Öø˘m	§‹wçb{Agø˘/ö˜≈∏òsÌ√§6’I-“-çmåDW4«2¬üVïÛ9 Xë∏ô-ØÂ˝•÷‘Å° ƒ˝∆û±^Åè©L“ÌïG‰Õ8„∏≠ŸDC<¬Wˆ√F¸Nµ˙£B\Zä∑ Ç	{˜yWPJi∏≤ø»\Z<@úkœÂq˝saÖ,jJ€!–wŸSûÂ·∏µ∑πﬁô‹)==Ä)±∏©eFKÏxø:5D9@ì∏ÿÇäœ®\'¶<MçtÔ©v$d]#Ïßõ˝æÑÎﬂ∏„X[nJï@”Ù zvªéÅT\Z0:t{¡^!=Ó≠é∏„’˘Ò.`8G‘?|¿Ê#ˇCà’=ùà≤(À6◊õ∏ÚÅiuÜh\"KS1©™èè¸Rò¨ ÒÆŸÔ+/ˇ;˛˝∏˚ùiYñ.7/⁄X˝ËÃM7û~YÅî+¡‘/\\ëÏ1≈ÓπÍnÁX \ZA∞\r–“Ü‡µÃE„˜rÃBËˆ»–ãgπ%˙ΩÓ3‹≈«◊≥ÿEºq=v,∑∂üV˝\"∂/÷CÍíπ=ëπœ8Œ°u‚ÑP	ﬁk≈â/ÛLöAN3⁄)‰πECC‰π=ÎÅ˜Ç–\0µ{Ä◊ßÀ\"};•¡Èæ°åêtπO´¬€˜æmó_∑í™jWGÄ˙\\∆…·boj¿Hπ]x!+∑>ΩŸ‹ˆ‘é±Á¿˝zû˙º4¶J˛1–~JπÖ«9Kßm¡°˚¡`ßõvÿã^√ìGRfÒÔπòÚ‹&§ΩvcD¥Ä†O∫vë¿cQ¯]•P=ä„¯πúÙˆÌ$aFâ´◊jF‰&|uPU„¢MeG1·û¯£‚π≥€ﬂπ„≤Â„b€•!	§9~’¸GgùlØÚ™æ®˜»πŒêﬁ3|oµ?ÃD^a—@ Á≤CóCóı≤–N&–PπÔSÁt‚i≤«z°r≥È{ØcY†©ÆGË±À¡*3π˜\0¥»áz°=ÜB∞£ñ¯l3Éäu@ö√øc˜¥è1 ,ü∫)ﬂa)ÁqŸº≠q˛ƒf‚ı‰æLÜõˇ1Ÿ—JÖ|b(∫#}©\\EÜ’∫¬ æ§’„ÄóπàäUÅ˘ãL‚&õÖ∫6o&ÄÇÿ°Ü[äˆÒtJY’“$âMì˚AÿÉ´µøqø˙∫6©¶\\Y?+c2$ü´êœÚÁ)6ÍÌº8*Ê»∞:E∫@}Ê…zPWE4R˝c	ƒâˇ€ìjÔ⁄î\'ƒnö∫M˛}9…`ÒAR)ıííØyÄ©∆$±*[Ûÿ¿|∂À∫VB&ipU¶ ô.ó‚ViìÀttë]˜\\;H€I∫d›Dppí¯SÏÛí≤¡Ås∞J£ë«¢ñ\ZÚC2]∫hö‰?≥›±÷Üñ~8ûŸl©»™4,«û?¥∫àlˇkJ„ô∏3g>òÇÀ⁄∑¿dGzfwSCÂ<∫ßvÆ–\0ÎÊf{¢Ê8:•€\ZÖ\09AÙ©¯B-®∫Æ\\±ü\"ÓãR∑ÀLFÃv…©∆°-◊&i¢ßıˆ∫µˇêòN±Jéç)ñ·≈Òsº∂+¡£·N¸Ùmñ∫›√ugŒhÉ2%ÄÈ.°g∏ô0∏˙¶πK ı≤Ç>‚è∫‰úG£ˇÄ.P@J·3tñB®kº˜Ñ”√D|$ÉTs	∫˝$YöÑ∂üb\"“)Ú™Hzèd∫∫“Â<˜üñˇ“ª#û‡©ya\\©⁄´:KËÄB†À8…Ÿco4ô⁄‘>Gñª1J£`Ø¡Zß∑©éI=≥ÙcBfeµ∆∑CÑ\0´ª22Ôß¡≤JnßÛMÜ∞ÏF¢∆2∏¡æ—x¸<é∆åª6&FµL\rë›ˇ<\ZR∫#Ï∫ù£Ldp=Ë@fIWXï\"ªMBﬁ1–QwoX4bx±çc)@DéÀ•∞Œkªa≈ÀØ|9Y\"Ùîà›iùâ¶*ÈUö˘L<6\'I>∑ªbñ5p™<ıeÎZ°ps≥–}ˇ[å…Y!∞§öçm«#ªeÁˆlp∑¶Œ.êx©∫\0®mxèP/d;sT¶≠s•Mµ=ªjÏ%⁄0ûbÔŸN¯tR&yè≠.™˚sE¶£¨$iªlØû{”y∏⁄#îÕ‹]i‘F«»FÁ3J–=º{$ç†Àª/ 8&àÉÔsÂ3oÇòøÙ¸,\nﬂ∞ÒΩjòÎ<ªBH˛@?í a±„á¿„”˝éˇı÷g≠ﬁj%≤aπÛªÜ Y\"pß–ˇ˝Â’kì≤ÑbÛÒ}ÒªﬂÎqBÑÙ˘å}ªõ,?◊Ú]öøö/Î1¸{®ñ®âı÷∆Ñ⁄/Î:Qﬁª™Æ«v ıÌ>rr)qÂAoË\rÀ:;(S>êª¥˚êB≠!V»5R˛_Bµx< |9ƒ\'bL*^ªπ√˜˜Z\n∑íí\\»©Ò≥ƒ|Ú–…kZâ=øô\"ªÔîC ˝(k\"!Îô€~∞5û3ø¥ÒÖ¸‘\rÄœõ$LªÛtª*1◊3◊p8AÑÒt#›Ü®?]·Dwöü_ººXßY5hn.ﬂcÖeõ\"…”å≠	üÑ\ZS…ˆºñ«‹:…·˛v¥BæiÈ7JÃ7Œ]1®k“k©1G¬º,`|]$9Ê`™,Ù˚w\r>Æ≠-±W˚π⁄7*ÎºÁ<:ãígjˆ6ñ†Tz30¬8∞Xh·µ^~mœ~º Ÿu◊µ¥ﬁÑπÜ»22çùíRùYüRP4H9ë¬O˝}Xºc@Pº`˘2—_∞ÕPVbñB»≠ItJ†ÃÄrº{OßsÓÚ\r∂˘ÍÆÈñA°Õ3Û≥«¢j!8á¯}˝ºõ˘®æc◊GÒJ€À¥†`ínÿòπUúíº\nö˜=¨±º¢¯IµªØ»n}\'˛`Cò5÷ö%˝{∑Aô˚ö/–^ºÆÁrÄ)∑prAJçBáQˇv¬ep˛Ô˜)Ã ÔRüôºΩNyºäƒHø∞Ôy+3ãH(H^èíeΩE1ÙîoÛyºﬂ÷åHFœı–˘Y?\nå’¸}Vµ÷ÑÈ≠òn∂ÈrÙºˇ\0v1£Ís‘NÌ>cIDŸ¶æù÷ÑIÈ≠0ˇ-Ω*‚F„–:Æ£√Ö=IH\'xì‚\\\"√–\'ë≥:Ω*;:»«›jªl‘3†0dÄ‚scÓä©\0q|KFΩ0öÅå_q˘Â≠YsBK•b÷∑bÆÒ(±7^:ˇ≈ÀΩ2ãdl@¸WH≈Ò÷w›\0ôÄ	wWúK9òìÇ•äŸùΩ3C,w≈ıíË≥WÃë≈>™∏\nõc6i∑S˙!Ç‡∫âΩY8V#r´QÇ$[)áºz∫n√°úW;øªW—†›•Ω`°ñßW‘AA\ZÚ!sn?R”v∂‡ò∫m}a‰x÷{ΩoÄJÛô·®∑N•5q‰⁄K≠ıÜ‘Z_ÕÈ©VÃ#åÌΩp‹W£Õ]BS7˜äjà†YÀ4ÚciÖ≥ñAÌWª\\Œ¿Ω~YñıW4âÕ#a0”<˘g|.J•¯∫DSëÙy∑‡\0aΩøeºÆÉ˜Ê„‘¶G9~Ωrs»jJ–ëO∆ËΩ¬}‹‹’5·õeˇ3πŸ3¡émhyDÊåQ(Ωƒ§‡êg^œLÿ\\FÎqA\"Ú«‰˝√í¡@ÔΩ“Ä«[;ûK®kq?BÊÜy∆:P\r\0àÀ!óãE·√êΩ“#∂ë‰MOz´˛qöÉé~ÖÌŒì8È∞,ƒıÑ∞Ω’üˇÃ/‰ﬁ∏êj!Tàé°∏´„NTÿ≠°◊	”‚ìΩ‰Ö¨+.S…^QíiÕ¶ö&√∑ÍﬁYX1\"î˝ÉÏΩÁåI€+rœ|Ÿw‘ÕÇT1a>00nioΩ˙+À\ZÚoo`¸yf˙n—y√=C—Œ˙’™8:˜ŒæeZT£á’WÕ0w X‹$‚q/¬£Ç1éªÑΩS4æ˚i‘j#ÏDœÍ¶À]î–Uu∫¸§_à…(K¡æú-ëÑ´ˇ“«n¥D(@Ωàˇ∏∫&ÈÉ6ﬁoπZ‰&µæ$¬∆b–≥°X‚é\\ÅmfkJ„ó⁄ì≠I¬çÁä B·æ()∞&.£}ë_ÊjŒhÆF(Æôú÷´Ç‰îˆ]æ*|Wju˝≈t.!\Zf=Œ>/Œ\'Ò¶¸Ñ^Oáïo°¨”Eæ;3\'‹(?æÛüG>cg x™Wë °ßÃçV-ÔEÍæArDx±¡ï+ûË+`’c`®/[¶ŒÇÓ-˘JÎH⁄næOQôÖ˛ÜÑ_˜*á}„£É≥‹å£éÄ˝‚|πæQ–ë∂\rq-Fâ‰ùÛV∆0¥Äöà@∂π¶‰ï‚⁄æTŸÜ˘Ï— \nﬁZñï~Å†\ZÛó,o¡{ı¿˛l[æU÷¯´∑E¢X}AJv∏d\Z¥ø<`ea¿®˜ºæXªÏ9$Go∆œ)ÂÕ’∏r?ÅSé¥î*–8åq¬æ}∂¨=3x˚A9º™ÒÀlè´p\0Ç∆∞”9e.Oæ¨mØ)qp˘çÏﬂÙpJ√Nnxh\Zâa±ƒ? √4öæ∂·¯ªFsfYÿ2X7\nº@k%|/Â@J:y∂$Lqæ∏rh)uF@1„˛É„§˘ÉÀûñoîﬂA<ÓÊ¸TQ„«ø\r˘94Jb‰© ≥r™1¯ı›LL¨ÉÜìŸ£dáøÓO^,ÿR∫ÙßNæèsçSnÏ/ƒß®ot≤ˆUˆ§Ø˛ø$D_ë˝P!„Üd\0Lp¬Ok7ıNl˚≤ÿLnç\nqø&x2Ñ„¥€Â*‘nº;Y{öÌ¿uDWﬂ[äñdÍg˝{ødú  BÔs»˚˘n∑¸ÇΩà9ø≠ìiÁ„S*LDEøÅ$˘ÉÉ¸Apf≠ñl_:YT‹^,FdŒîãP¡‹g∂EøÅòÃÉVò¿ßÎÌˇ˜•ıö@P°ç8¯ÌÇS0öJ»™øåí®®\"§Ä>0ﬂmTæë‚∞Õﬁˇ÷!„\ZŸÌ°9èAøù•)Z/à‘@¶∑*à6ÒyÍR7,‰ì°D¡‡ø¢FŸfl™~£0#¥F∂©yÆWy©ï$¡¿É-ø´Ñ\rmñÓË‘}Qœ4%{À‚∞{`É\"2nE›*V$ãø ∑“x°cãRYKπ¶Sø´M∂¥áO-›vY•õ Œ|ø–˛œI∆Ä^Q.a≤W(fõÀøb\nâ;UBøﬁ√g˘n¬Ωä¬E„ï9¿æ[9≠|<C+~ÅÓ∏ÅT°îøÊRBE˜¥†œ¸–nH.—VR3+÷ΩΩfj¬vÑì5øÏ˚+i#\"iR,k2qœXø8	÷†,It8ôØ“ÇﬂYÓøÚUNÍ*Ç>FëZ–í˝-˙zêµπ ¡	Ãë≤T˚gqú¿¸åˇí‹ßG8)°N‹*Ëπâ‡Ë¸*01ãG9¿!1ÚﬂÂ≈}æWå´F∞8ù¨|éVaˇÿÛpV‚\Z2Ï¿$R9Lûâ÷G&mî[∂”èp(öf$ RÀŒzX’¿Z8tÑß˛œ80pV¢€çg<È\n¢≠E:0o?Ú%¿ìî⁄°c÷‡Oà\\ﬁ±Diπ∏c,7[8ÉNGs?¿†È◊ êˇ3§ÃUëQf~á-X5⁄ﬁ\rJÀVÊ⁄«¿£-à´c%#Ôepû~¿÷8œö]kŒd˜nO¿ßÊEâ≈¢î§7ò®?>πªAÚ…2NÜpÒ$u≥ƒ¿ª÷päÉ6Y∏∏`»èªÕˇ˛#πvÒòRÎ0u^Æ˛/œ¿º\'~,∑Ëè €sJÃ˚$ç§∑ÚTl>6÷H<¿¿oBr[ØÈ∞n◊¨©*¬™X®z‚ë\"√ £õY≈¿À_£‡îØ<ùá≥‚ã\'}ßôÕ@i…¿X¿º¢^k¿◊VQƒ˛‡= ßã!Œ‡˘·ØÏÙ±dÄ~πç+ÀO€¿ÍΩ≈iÌgi!ﬂ«¯ÃH∆\n\nu+o}¢–ØnÄì¿π£¿Îπòπ[Ä…hDóeñ(ØﬁùfO§[œìv°¿˜©\ZÊdé«Ôq|jê?RéN>áAA∏{z=Œ\0t˜≈¿˙Ws	a›Å˝i’˘iøW[/;¥ãqáP~ÎSr|û¿˙ÅLæπ¸8«eﬂV@À5úúú √Ë]ƒ˚îU∞ûV¡1Nkô¿‘Ü	ß3O Çù—¬ŸÑìÚ9k«ãL[¡AS\Z3H	¬’Q9Õ≥o≥@h_Ø⁄!1S/£Ëx¡Bâ´†Ù†¯MWéXr0aFïÙd{QøxëÔ…`¥‚¡S≥Ç8,ﬂ^+Óæ\\ÈèØ€\")>(J„ÍŒ˚ã,˝≠e¢¡hË=⁄·õUóP|ÁÖ?≈7ø≤⁄—TvA2YBº\\_ä¡Üã¥d’aÍ•Âå!õ\"êìQYP¬Ô56#ˇ*¡≠OyΩ‘¨,∞úsù2åÊÍò·xßpFıóT-o¢¡∞u	™TTÔ>ÒÖ&Wáÿmø_ÓxÀ–ò4r˛kÉ)¡¿q∫u€ÎêF¶@Iet ∞∑K¶c5grßµûkØŸæ†¡ÛSñd∂1DS≤ôÀÎZá€Ûî¸ñΩ\"øπ:4È∏¡˙øKLJ_Jöê—˝A<ˇDÜ∆Ñ±±»$Œ’&ñÄlS¬R°ŒsÔÀGW≤‘ƒóÅT‹Û\ZZ‚æ‘%≤¿¥Î™¬uπ›_®˜H\"ù»Æ§ÔﬂV~	0áìä0Œjù¬Hb–Ωë\'ˆ`î/ﬁÉ}X”3™\n†ﬂD{|¿≤á	¬Q‰˝aK0Rb=µÙ®‚´—∂XÔ◊Æ,c\n5i™k¢¬h‚aﬂå5©˙’>tŸå∏^8BírZ‚§`^ê¬ã„=1¢{K“Ù√	ú¨~ûÿ∏1Ñ`\"ÏLÑ\\|õÅ¬ñw.DkÄ†<¿ˇÑ· dÅØ√û˙râ¢OjÒ≥¬º∑™§⁄É(Èè≈˝∞)#}µåûG˘l∞Jv)¬ø<Œ~¸Õ∞zu˘h,yqùpÂh”¡ΩO3A(ÊY¬’-!V∞ª>d¶*jPåF›	»;Q∆µ±öN1aGú(¬˛)äs‚≥0J/Æ∏@Ÿ(rOç| AÆè>mø®/[åÕ√‡*nB_˚RG-∑YXÇŒ/¬äîéZüKÓπq‘0√–$Ö—H¬á¢€ ›]po=\'s¯˛ X&ÕãEà”;\Z√‚%¢ê*«jµfÖ/∆i¨>á;ı	‡Z∏Ûø\0°æ√*sà\n∂7)˘˛]Vl^B√Ò¸ó>ÊÊÓ¨˛ú°é√- t@ìÄ^~ø´◊W·-ÊO&4#√h{‡IlÚ√1¯@ólhb˘¢ÆT7a+Øƒƒ÷y$Ω˝[ „´7¥∑√B§7kÕæ3ûµíK≥æÀd\0÷.e¿ãΩ^7AAﬂ‚√R&D˙Gm1eEöÍø:√¢Ìı©Ö°sÆÍlîÃÔ√\\«K«ä≠ú¡mÓ÷b\0ôVÄŸ96 ∏ó\'º?–nHã√â≈vŸ“Œ˛p\ZÅùﬂæÄ≠©V·˙Ç€àZ6Òj¨jÄ√ã„±H%¶ˇf¶Vü÷ó∑ÙM^¥≈ˇ^4Ã\Z∞£√ùœŒ€ït}Éáy%Jn‚ÑÊÌ<ÒÜ~ˆÖ\Z≠jÈ√¶g≥Ωƒmp(_¬YN≥åjÇs>ö˛∂¶¬ESi√≤\"Êè€”É∆ãª‰›óT^ÙﬁÇ®á§µˇw˚ î√Œ]E‘´ùËΩô‚.ﬂF=|≤ÕÚ¿Ò’÷ﬁ‡√˘!.‹s?øÜg6G8ß ë\\2xô_ ‹·Ï5\'»¡Œ√˝ÌïV?\rÂ&èÛ≤⁄ÃEHDu`§Fü2¶<À\"hƒÃ◊÷≠˙øÄ≤—÷KÄ√&RsƒfiK$¯cÛîóN\Zhƒ	9ˇ“≠í∂d–àVæ˜oﬂ°c¢8Qßö1E/ =•ƒ\rX†¶›É	h^÷/˜WXgjU@⁄6%±õ0I\r˜ƒ‚º€D4e6ÉSo5RÈZfçﬁ±Ó“<≈∏v∆ƒ ¡0†∏°ì!!Ú◊ıN«Êí÷¢∆ΩKr=ﬂ)4Éuƒ+váDêˆ∑>÷‹m\0Ÿ¸ãä≥“a)»‰7t2äÕ´Aƒ:Æı©—‰¡áyL¬™%X‹öølYD∫¯é”}ƒ;7èsÃª∆™˚ç±ÑÙ≤?˝±£Ï÷√≠sÕ©5DÃƒL Q˘¶\n(v∆y◊eùÓ⁄r	6sÕŸˇ5Q°çZ_^mƒ]Æ#knn\r®¶ŸƒÒ)÷1≠:®\rÈx≈˘øg	‡ƒl®!˜¨ÿúÑS\ZÒ©ªc/$.BEΩk\'ZFyˆ|ˇA∫°ƒvPUIEAL`¨†L_˘·2,ıMt÷)o·f.»z%ƒì©.ˇp!ih08πÃnÊd⁄7M˚l˛õÚTÁR†ﬂƒïÜÕx\'™u~zäÇ®≠Ö¢e|∫\\EËƒv”2r∑Úƒú–v 7ì¢gãiU˜eﬁ´t»æ§!Õì<AﬂaâOgƒûå«ë„èK]Q_ˆräo–ÿËûXœ≥.˙⁄o‘ƒ»·AÃ≥\r˜ÃÓŸŸ]y†Î≈~1]	L(p_««ºƒ‰]ç†p^¥Üã8»◊cLâ”ôÆnêıÂRÖÕ\0üRƒÂ‹\Z\"‘ˆ\r h˜‡z\Z™E£íS)nnMRåa≈\ZpK3=V#ej‡i◊N<íV¸èê¿]¿∂\Zò≈r∂î? …_}Éä9zπ–ù¡“€fi∑ï`‚≈.=ˇªmò\Z®≈l·a<cÜGBûê√\"$ßñ§‚)é≈8§∆$Wñ‰**ÑfË±S/â,HÛ„k!]\Zjq≈B‡l„ç˙π¿∞Gu%ˆ?nc÷Úfdïv‰∂ﬂÍ‰d≈GBñw€´’iJ∫O‡◊®ZÏ@çû-Ω.≥qÚ≈Hÿx7©©˚Æ°Ñ\0ƒ;Ø4\0ïﬁ\Z›o÷RD≠ï\Z≈Jµœ…v\"™(pä≠∑Õ{vÉ;˜fÀã ˆ&Uu÷uè≈Uˇ^$dÃ`„∑œÛåvåÓ7ÓfErR«-¸y¬–≈Vﬂ*âLgÆ≈bJ˘ÑÍxÅ»ﬂ.g0VÏÉªZesWTm≈^≤\"æÇQª—úG(Õ¢€e≤K¸@^¶(1÷]!†\'\\≈sôørK™S€·Ë–#AÄ/\\¬\n°ÛÕ\Z\0äc|f˝f¡≈ô<Tƒ>¸]|OΩ√÷\n\'™¨ÿ‘$KåØ#\"jÒ,˚îã≈õè<=™!”-uWÔ=´T\0˘c•·ÑíÀF`î±◊π≈¶O≠¥\r¯√π¢+æ\0ΩêAˆ\nN8¯¯∂å5p≈¬†Båb˜tVV:œ®<(ÙÓyåƒk^ºÉmº<¸≈∆Ï¶eïÈ6Äam˜‘ÆúÓ‰è˙R%M1;ñ§≈—ËÅzèDùk16ß‚àÉ\r†BX—öòßz∞y°ıﬁóˇ≈Ô@tÜ!0¶%‰⁄/Å;§+è(›ÄÔt\ZïUÙ)¸≤ù≈Òä·t‰ˇŒ	-≤¶b[Ì)>∞◊\Z\ræ–gÛ¨6≈˙⁄ﬂ∑\\ëq≈˜-w\'≈HB‡ˆK˘t99€JmŒÊ¸|q∆HÉ\n© w28+›√l†rÆü∂oÎP@¸s>L◊{¢∆4`ÙD–”MÔº»Á“ÍµÂoú∞a‚Y√„m˘Äyt∫…∆P*Ù¡\nD’≥0AA\n∑k¥z}—*ÁÇ$¸cÜ∆S—)KxXÄÆ1èŸˇÿ◊”º©¢≈À…›~¡∆b¿¸”›•ˇœ9ΩwEE3É≤Ã…|:G‰¶u,v∆l»æl¡ôtd±¢ìA±4fËñ¬¡@HŸÚ—eXqü∆Å\Zd%†\nÿˆ[—KnÆé0¡Û÷!Úñıç&^∂ÿp∆Ñ+¯ïﬂ‹nâT\0πïÏo<\\?≥’_.,πO”îU∆êfBÃ‰çéç‡±¬∆Cˆ›<Zæx0áÕŸœË≠É∆úæÓ¥5-¿Zd´¬ìn3 I◊‹Õ\rC¨œ\ZH˘¸cA∆®ûf}˚∏¿>^z˚T´RsEy¯ª∫:ﬂv¿ ã8∆Øó<ÂÑ1∂¥÷≥äÉ-ÖPﬂf@àßG \rG‡çµy∆¥.◊ g]¨Jz∂Éï`íôÿΩ•≠$LÛçKfë<—∆¥sfÁOñC‘|uÖÃt=)Û¥¸´k% §Yaî@∆∫\Z4Ç_Ó9lR‚‘kUõØk\rP\'7∏¡/^‚∆”≈≥t—F\\Ã\rÄ?∂Êv√—ÙWCYnïqC›ˇ}8|∆·ÅM”\\°ì<d^Ô\"ƒÖí9ﬁïÑAÜ§¬ÑNâƒî˘∆Ê™Úúú†È\\bÊZ·ë_Øu¢Cπ,PI1‡[\0Â2â_∆Ë≥H9zn©Dû®	π∑ïrY[ú∏·÷\"?°\"ƒZ«ˇäcÒ¶±Ø∞gú\r‹~ Úê“«êV⁄·É5?»B‘« $˝i1aÓ0EQËaQõáæ‚ì›2§öF–\\>0«/·.ÖÄ\nwä«\'îâO-\\mo}%-ì®\0Ôé•{∫«@ó£¡\nà{Èﬁ	›í€Èı≠ÂS/«-6R∆”äËÿ\0∑«OeL§oXr\Z€÷¥QJÛÊæ•êeöî:¢Pˆﬁ\r(u«Y\nÁó¨Ûô}K¥ç≈¿ÒÇ«¬≥ˆZ?¨A‚í,\Z©«Y·Íum•⁄Àﬁ<slM∆aPL/È´+vôwd‰«ÅS‘zÈ‘QÕc\\ÏNñıÛß‰Ê~(fZFƒJÓë~\n<«îäYMŸgE+ﬁU‰Xê€57∑HE¥¶ht…6¢Ósé«£∫@x?„–L˚∑Heﬂx∫›∏qí∫*’∫Ñç∏««a.Ç˝dNG˜Ì¶kN◊öÌPı\'ìhH>[“∞«—¬[g§§-È¬d˚≠9#	á35∂{¢Ò¢æÍGg{ÿt«ﬂˆ¡<ÔπyëS›Ä˘‡<ü≥ÜNœÁ!)Òv“—«Íƒ¢m%—QHöy\0÷r|}¥DãÃ‹Ù{Jy3W6;«Ïß¯X˘≥^‘\'ÄPØ1|—Ä8&d‡ƒñK—]«»	í“≈‰©¿E4vÛ˜˙◊€¨ÑäÄ>t&g‚k»\"ä∫Œ\r•+¥ÌªfU∫ ∞4ÿxYπ*Rƒﬁlº’£z»U™c¿Î\n5∏KôôçëÄÈ»∑∑ªª84]$À0T`1»oÙF˚≈\"óØ&‘\"9 ™‹ƒ(ÏúÌzŒ&ŒÂêÃ±»Åu√“∆ßÂ∆Áû€cÓ·ÛØu‘jÖÕ”ÑlÌ˚tÛ»ÉoÓgï¥ÇQíóÑ—Ì˝fÂ˘ﬂÏEÒ∏-f„»àèÑÿIyù\0]Q»·º£§ﬁ(ôÌÆˇ¸ÔÕ≤Ò»≥≠∞(‡^zqp}Ÿ≥Å∑?Ëâ{.íÚºÜ’ôG«ÒpÄ»µ0îïê8–»S9∫M\\‘1÷¥nÉ·û†¡/{≥Ü4»ªIüﬂ≈îªq“d¬ú‹<⁄PlŸm¸Ï,9/,ÜI;?%»¿˚Ωy[.]_z∫’aZ%€UÚ$DW-Í{Œ¸};πy»¡*§0’õs”:@“&°O\nŒ—ov#ûœΩ0›≈D#ë»…#≤‚a~¬7‘∫MâÒﬁß/<]π√ÁFt„Õ÷è…\"…O`3±ËëÒÚvTlÀÔŒéß¬ã\rGòﬁW´ı6…,ÆŒÉ_§ùöú{‚*ÇO%EªÉ˚HL\rjÚM…D—ùü√b≥SF\\ûv©∂l%ç\'œÕ∞^≥3…Eü>Îè˙Àëß¡Y√¿ç,XÒÛû‰öRk°ı¯2ò˙…I?~ 4˜ªﬂ]4Ø˚«áüKÇ≠F™˝\"v´I(…QLÈOî¢¿ÌíP†ª˜Ø£(Á˚ìËmüœ|9pº…YÀuc®Ç?-⁄‚¸˛Ã…∆FÌΩ¿Ÿ=Dq˜∏Jkfü…¢˙¬::KêqÓ©≥âÈ¶3â˙üè5∆F˚pu@ˇ¯…ÆamÜÄ»ôß@ïDå≤m§PÿÂèîÛˇJãÎ¢…Ø	j[IY|‘≤Ïù™bëX$çn∞¥ÖG>éÇ≤…LI…ØO3eñêÕFª‘„õÜ∑÷v+®„¿.r/‹>ü,…¥ﬂÅ10Rzçç µ∞Üg\ZﬂÅ‘ë7§Ñ˘»≤”˚‡ ™%·úÀB]gÎ\"`.E…¢qßí≤Á™◊‡-C∑Œ÷ ⁄9ö˙ˇ6q ÎÑ<RÜ_â¡\nÇYBb÷ÒÎƒS\"πB -+G„Q◊èJÕ2≤ŸŸ~snm‡™1+uf¡\'sOd NtkêΩ´9^{¨≠˝sx*X‡Æ\näóﬂb∂sÇ¢È∑ Q›h\Z˜P?Ù“L∑±∞yß8˙ﬂ&â>˚⁄I¨¶B+Éa wqÀèÔå\\Ö N];L?sBisÌÿÉÚÛÔ(‹Ä zH˙ªOà±?™—€∑¨ÇGÿ€†‘ô—>Zˇì	ú~Í Éƒ„˝y“g-“ÈåGyvªmÎˇ\"ÂîGB&iæ7q •ô∂v2úÀZá˘¿}K_≥	ﬁj∏—ÊIôl0î9¬R ±~o©„2\0ì?Sê©V=´≠˜®ZÃÊ¡ﬂsëÒ ∆LMk˛∑;P…hJK{í+‚fâ0÷|∞#Ωõ8ï:k œ¢efÀÌH>Ò\\≠pê¨V)Ï…$ù|xﬁ<Sºº ﬂÈ≈˝ ˘Úﬂ™GGﬂ0h¯â¡d‚rÈéÑÖ\nlßjﬂ „s!•êŒ~È¯BÕOl⁄;iÔKe?®>VPÆbA™ ÂyÌ¢+⁄’L/S©’åã$.ˆbnÎeçÕûB™ ÓÇxŸMªñgÚ‡˛F—h‰Wıè€~d\\”1…aŸ\nß ÙTp@Ê¬«òvDz|∂3E6íE∏	jˆù\\ƒPπ∂(Àgﬂ⁄C¸é?‡#Ã”$/ÎÒ™Tá§´ËA}Â˚\\ÀDU⁄π^ò±äé\\Ê¢€mÔ≈$ˇ∑Io¢*·∫æV\0À!Î[Ö öˇ#‡Ÿﬁá¥*\Z´mh¯ø•pªÉ6ØoÀ2&ôÙ\\+‹˛»\0P<IYM ¶vØû\"Û°	∏™™èXÀ8Õdà9#◊ZÀ—ùoœÛ\nT§#ˇåtˇã∆9rd77æÀ:≤øÿ#!î∫µ]6ÓêÜ£I¥03˚ó«——µéÜ!RYÀ=~◊äu(Ó,£∑\r∫DπÌjTÊŒ˚OÆãï~\"ŸLÀBUx£ÿƒlrXw∂c¨Î<ù¿z!\níbÔO¶πÀp¡øL35pD^8¡DXâå⁄#q÷ªÍ´ﬁ\'˘fÉÍŸÀÒ„.N!¢≠q?M£ÜÀ*∆]Ÿ·-ê£ y3,4P9∆ïÀäì%(ΩΩ∫≥‘|”‚õ©µú⁄›vq\0ΩÂ}…ÍÌ\\lnÀ†9èë’˝Häú«±ÄUhê∏LgNƒ{1W(ñw£\n€À∫C°˚¡Ñ¸\\’=ïvp∞¨O√WÛ†)áÎ[Ó–°MÜÀ≈ÕÁ2ÍﬁSò≠È›S{zbΩ˛-ÔÕ®§À”4]?•^Dk=3ö!©Z=	©ˇ–kƒÒB¬ß¥´√ÈÕÀ’*P≤¢yX&%æ0Vı˙…⁄˛¢ù>\0ŸV˚KNÀÙ\"KP¥∏KÖ/+°›à´R$˘fﬂˆ!ÎùÅ>ü…7ÀÙMiÈÿÏ_Ç\"™4Üä›	ªªZg»˛ÆäÉ—\"aÀÙxh\"ëÇåí\'M˜i¯5·5Làﬁ“∆Ÿ)ÉÍ¨\\eÀ˚åVAŒÂö ·˛Ì7îùƒ¯©rd≈∆m ƒ∂beÃ˙Tº©ª”,å˜ÓóWMz(≤æ«=«å	ﬂ<Ã5ùÂ/ü#PÖN†g◊z\Z¥&∞å¶∆xΩä≠?49Ã<c\'âc:y4ŒOg8ƒ≤FËG\0\n÷£Z7|ˆÃAq˙+SO\rŒzÃ~(«f∆Y≤Í‡aœŒπ˝£y=A\r°Ã`úï]∆¢ç V«]¶Ñ◊)#ñ˚¬dŸOåXÅ1∂§rÃeT8kì,¡óYû‡¡h\\¿ê∫cµ˙YNµõÃiT7v1ßX~J¢©£¥ÈÉı˜®Í=_[iÑ\riJÈÃq¨Õo2Ê“ãeå}§±ŸXto|çzJÅH„üﬁ∞ûÊ>ÃÜêF√±√Ñ#\rb4¡8ÓÊLïIü€µ©?·2ô}Ãé†1áBõËSﬁ¯Ób`;\0&:Tu%∞f^⁄Å5Ãì>-Pc/sërtÊß)¨–xK>Úl$,•\Z±¥¯üÃö◊ÁQ’\0u˚4J47≤¡:ˇ\"R,6¥µŒ\0\\ºñÃ®Ütû´ÖX\'◊J‹≥Å⁄aiÛ¯mºÈ>#Màe÷»ÃµÚ∂ £±â›*Ão2“dªëæ*_6ú§¯c\nzpÃ¯Ã∏‰ù\0Ë¶SEã6ßâp”˙˛óÊOx4`!‡ÕÚÃ—q¿Jﬁ±≥Øe XÌæ¨{~k§ø\0a÷í9¢ÔpA∂Ã€&øaû—&J˘_Ã⁄ \"OäTaŒ\nπû≠SÒ›»¯.Ã›∆7ƒùÆX˛ÍπË`j\n•fˆ }ÇDÂErΩÃÒF†˛˝§JÔ?æC¡ˆçÀN–¢¥r…7ﬁ‘eßAêÃÙVk•¬É];˚Y–øE‰ô°m6%\\Ç3deúÕ\n¨uä8K∞8BT◊I)ñõ€W\'˜ñ¿Ñé≥|™=Õ´]m8≈âî≠n-`¶uñ&ät Óﬂú¢‚â√S·uÕùºj2ÄkpÊWÏ6óè{0@\n-ì§•µt9Õ$∑-œVrT¬sY›•¨/˜ÿÂàh)£`Ù6πÕ3\nÁ\0fByjê≠ZiÑ€\n∞Füÿ∫èÿﬁ\0÷ ¬µ#Õ7ÿfÑ¢úÍ‘¯hCaT\"—ë^>2Ññ¥^~\"πå-ÕI-.óßº\ríQ1*a‰˜	D.éÖ6¨é›ÕOG‘\npÅÃQj¡◊ë8Ù.q}PÊ“ù©ÀJ:hQÕyyÅf\\uÒ¶·ç:Ù—66k<øRV8:xÍ À»ë≈Õà{g-øZ}≥è¸^0:ë~¶…+√>âx[ê®«PÕ®úÎó8‡QÚÃÔ\\‰˘–fM≠ùJ÷˝íı˛æ¶ëù°Õ√J™8æöGöñ\"úÁçÉéN/6Â jñ)RVÒ9¶ß ÀÕ yOÛÒRvÇ€nXƒ3ßf%0y8x{ØNoŸ:KÕ—∞ó•y+Ó!∑1ö±åÓEÜÊÂ√ÄÌ\'ºøŒU®° èÕ‡ﬁ %IxºûΩÑ`ø˘ª≤í—Lb…ö‹[_I%Æ®¨Õ‰◊«Üm_â|SL¨ïºÅ†hüa—\'\nπ–	(”\ZÕı\"f_≈i\\µõÉ¬G=X∂1±Âº!5ª4¬V–?g˜–Œ!Ÿ©ˆ!ù_#Ç˚¸*«ì≥⁄Á∂B	:•˝í_Œ$‘Ãª∞{œõ‡ Óâ@]ò”é¡Sü∆C\0‘‡3ÈxóåŒG≤˜X]◊∏j%¢´=%˚Ô<€I—ÄÁhV8qW£ãŒSúßÿË\ZNΩﬂ| \"àhekï>tæ3Sˇêm*3™Œ^ÒeÆ9|#UÍ´6UOµµºÒ˛Tbæ‡Ïo°•~Œs≈/‹‚Òã.y±N+4[xVºò5∑+Dî\"†ûG{\\Œu-êT∆©∫≈ÿ\\êX€i∑Öà˝¡{ﬁ !7)˜Œ{d£2Sÿı°¨•∏gzfƒûÛMJ˙±KKY1„¢Œá^\nƒbóÇq<v`x∂‰£K§£¡ZóWéœ>∞Gw÷’Œéç∆uÊ‹L“%Á\0˝âÏì˚É¡ ÕÔ±œM0˚@ŒïøN–:˘9…ˇRØ}≥5U\\ü˚_ÉÖ^s\n»|˙ŒŒó°˘)ånS&[{T.Ä∑6Y„Ói*ØHØÛÛ≥ÁY_Œ®ö4˚óOø¶oÑÑ¨∑aRÀØß´^êNrk/5‚Œ≠wJ.÷π°á“àrÔ≤˙·~—Ûw=4üjÿÃ»”êŒÆOúÜOÆÏyÉù¬#M®´PÏuÊbT2.t›âŸ∞ŒÆﬁ∏FØ\Zg®T†∞ëÀÔ‰i»Ü0bùÚwÙiÒ∏Œ⁄∑ù{ÖºûΩ¬÷0Eˇ÷Œñ◊∏@Û¨KxœÈ ç:ŒﬂILô«Ìü\0∆öõü|ÑC˛ñ‘	&M6È\"E;Œ˙‚≤ûi´`®n7Ã(¸}Â¨˙9Ç/¯#Tò?œDPøX`˛d°”ÇÆÛ„|⁄—õ:¬íDò3„C≈Sœ dâÛ`ÚØû+4öYÍ;YÆ∆èZçZtı#}œCåklSì¥t√Ua\"6ÙkHDÖ¢¢Uä∑xKU∂>5õ≈œJ ßÍ∑-éêLáEª{_EÉπÒ\0ß	˙©RB•}ÍœN≈sÆEêCã%ŒŒ\'ı€ìﬂüRf•?í\ràèƒÕ¿œU∏neà–˘ì\"ü4ààÿ\0Cp/‡5È˚Ã˝|˘œX@„∫™ˇ˚gp¸.ßç∂\n¿5_„Uq⁄†s?K3åœ^Òk«ß!\0ﬁºLÕﬁΩ\rëbïè’£Á›≠,œlôu›ö∑‡≈> -¥:Ñâ[B«ì|*ÔCñ«£@œá8Ÿ7!“⁄\"†(ÂRœãÇñ2\r\Za≠DDå{Öo‡œåû=_}≥+~ÚÊΩË¿Œ(»ûe§ÏÅvrC[m‚KœπÚ%Ëô¨Yu{].ÒèÓ¯ÿ◊íÅd¢.ò–@Ü∑œœ∏õˆ$˝∏‚aŒé5Qøπ√÷c∏õ„âVjvÖ`dœË»êå˜mmÑY≥◊¿Q,|º:¥Kí í∫%•DL–# ¸bÂ¥XWb∫p˙?≤Õˇ\n©Q∏@xÀHcÎ–(ÔXã.ŸG˘™«µ^Kı°˙,8≤Æ®˙Ÿb2p–*X»OLÎﬁa/£ˆ’Ëèˆ{ÿíaô∑wn\nóóyL–I‡F≥ﬁ)|#¢µÛpö±SäìRÉNbTˇóis–m¨ÛT∂√J{)AÔoŒ»ênŒ;å9µ%∏¸n[:⁄–mˆãµ˙tÿ˚÷…ogÊ87›P«v…Z:ÕEF°º˙¬M–s,ñ∂æÊ¡Ï6‰«Lb!íG3Jv^5K `GC–é»LÕX]Ω\'k™“A˚mî]ç∑æõJ7ÁΩMîB©–îálWhë<Sß=Â™\\˘\"0†ÄiCôDM“ﬁq\ZØ–ô†íBˆ˝z\Z„ïk V‹⁄Úw®nØ·Ûùl)\rÏ–úT±ê—ÅFC)k|ö∆W≥çjÉ¡N∆…©Z]†/e{–≤e^Ω≤∑Kç\rüs†;SˆeâD+„VcæÚ,/‘N–æë;Ïcù\0◊Ñ5s+ú{Éuë•7î˙∑^ìùÏä–Âîﬂ≠kFÉ5-nÕ!Ìx`Ok¥ås„å–Óu=J$ò†u	ö∞8‚ˆ‘@ÂZx`ﬁ˜Åô#ﬁ)é+ó–Óôp≠o·PäÀ§ùhzÂ¬«Y˜ë[|`˝‡;]∑¢’–Úˇäb•`&h≤2»¬)V•KF}’àÍm†?*f˚Êê≠–˜@Ê%Táƒ∑Ïx6“íçO£”Ñø9ùƒÑí¸†9.z8–˙π·ã¡XÀñ<R≤h #IJÁÇ·* T‰q™≤\0t<§—büCK7jπBúYÌCƒnë¬ª…Ãπ)B#)ˆ—\n@À}„n¶«FØ…Œ>€k7X*¢˙ve”{}bë°—DÓæ™Z⁄\r_ß.>‚Q}÷≤å‰• |é›∏hOj—ﬂ€”I®∆ÒçP0Œπo-¬¯ØÑj¬≈ÚC—-˚¶—ÊWπ’BBu¥Ñ⁄ÓûsŸø	#gçˇ2≠&∫*—<Õ‘ûå∞1…˙V‚=¶ØÙ(Ñå¶¥sSà˙lâ.—BÂ+uÄ\\Ì€ß„É-;Ì-R8kpéß4C˜9—RWJÃ°f+V˜øUÕ‰m˙“9jå‘O¯ßDÜ™‘Ì—zqËî∑â¥ûÉáÚôgÉ\r”íèdK‰˘Ù:D—¨ﬁº.·A®ºé√QÑ∏%8;+√[}©ú2\0Oä—¬¡\nqbm∞~	+æ≠Èû¬jπD…≈ß§…Ω≤’5∂h—À´\Zx$“wB|9‚W©8¢£gk£8Ylj¸oô“\n` \r$%ÎeG\Z∞8Ö	cb¬π#k øuh(\\ÂF“#Éj‘∆ÛW7‰Ó\"◊e K¥CÛ¡dsí2Râ\'Y“.∑ƒëè3Õ˛Eåﬁ9D>ﬁ	õù.®›2ò,ü!“@%}ø1i}∏.πk÷õê¸k·gp›ëbõƒy9ê“YÃSçÇﬁ˝[úw\0m0H›+¬«Ÿ\rqãé(œ2˜=¬“]¯ä$…ÜpÉ˝Œ„LdGﬂa2æx±‹~eÏ_Z÷Á“a5ìßö´◊Ï–™¯⁄π-·•{ê¯ÈòUé¥VdH“r∞œVéî(-°Wâﬂ#QÓ®ä˘?`G˜uGp~nù-“ìDjkì¬ˇÄháÇÅ¢ºà)Öfx≥wˇÍÀÍLQª“ìñsaå\"ƒo?·Ü˚˛–©£Æ¯ªòäc9CßáÖˆ“ßÇÿ1 8,„©^•2äÍöy÷Iò’[u(Å°“√Q®†ì-Øyjô÷$ieëŸYi{pÿ¯πí\\ó“≈8œˆÊ⁄™∆f.Á$FºıL6wfûj\\Ωi”Axk“—s∑t¸Ñ~§€’˛‘nß¬¢^˝2™‡πô†f∑ƒV)“‡ ç*^D.o¬·‰RÌ|D„9O≤ï4[ûJÉø≤¡∞”	\"≠<ÎÚ ∆ù∂áãä2ªÓ,*•5µ˜p⁄G°⁄”;‚˘ãw2Å^ìÌ•fÎ€üÎ5π∏@’ßÕ3Ç=”E°?Çá:Ì√zMÏ$ä÷Óq∑e∆≠bÄa2≥E!td¨”^Á◊jjÎ)RüBx∫BLá° Ü=I“5E÷9”gj\"Xk¿Çëåªí∞sÈ≈ﬁ	&ÂQÈ=Iä”jÚEáNŒ7é\n;R˘Æ}l∏˛pfVñbâm¥ºâ”m¬ˇhÓc\\µJ∏√◊ˆ~9ëHÌJø¶$[®´¿x[Ã÷ù”~»m/ÊÌ˚»∂çî¸>ﬂ≈©T.)ñ,l∂;;¨o[”Ü‹ÀâDågöu\nƒ‚Y2.ÂáC0√éMﬁ(”ã;sdÇO∏Ù&h⁄gC0ñª∂áu!Œ[ç+‘\0˝”û*ÿ≥ ÍjEäWß;ÈﬁŸ‰>$:ÛøÃà4d¡Q+aJ”®+±`qsï{9ø¨ÑOFíú∞x•vNmsÇÒ{Í”Æ¡¬æä&∫º¡j\0–v´S†∑‚Å¿˙˚êÃÏ|.Âk”∑ƒÜì{Á∫øm√-a.Gñ‰¢«B1´ˇnó∑…◊:s”∏Éÿ9óA!‡÷=∆¿ë◊∫ÖaÍ	ÚÅ‰L P:”Õ‘ú¥Ì˜ÈÃ∂:wyjú=∫°¸“ï≠÷ƒ´6xˆΩºyŒ”˜SÃ≈ûúy[9»¯Â†l:ËZ=÷ÕÊÛ‘?V§∫«2T%<ŒãÃ™“¬—¨ΩJ±⁄¿íŸbë+ï‘/?BÀ’<\\œ|8ËW)\0∆j|∑≤∂(	ÀyºzÚ‘6ßï33Wq∂\'ß’x¨0`°CÊıAW\'Æ>›©‘AÃ$Ç¨sîÜ˘8ø∑ÙË*w˙,ª∂˚˘^4‘KÇÒ·ï\"w™-\0C“ˇòV!Ù˝é)3∆ßçU’ßy‚R‘QAÊ|s⁄˘Ù•∫aùŒ3¢jqdPâò˜Od¨™R}{»‘u\nahÜFzΩ§fø\\î\rˇg≠¸mÄqû‘úI|y\'€⁄ˇÒ v‰dÒÙß≈å#ﬁœÆtôË‘•ÂÆÇ≥E°åO1¯\":©9π°(ÒTQ≤Ê\"äM4%‘¡ÈÙ&ríO–fA[»≤4™…è›êqU}R‡\"Øµ≥Ê¡G‘«Ñ∆¯ÈL∂g+°\0vŒQÚßv1∞ìR2ﬂ°‘œ/∆îŸ~óœû-º\\ÿ ™\Z˚≠@G>‚ÿﬁuËÙyâ‘ÓÀax≥Ún`˘•f„w?’6y}>“‹m\nM◊Êñ»R’\r–À¢ ﬁ\Z¢’NëtÔ∫AúFòA\rÃ|÷?§””¸´’4íA¢&E(6çÌ~çe‚|vH∏Àl´;Ó‰Æ‡R≠’\ZVÀÚyØf`ôTëﬁ∞—√ò`áÒ°öÕs[’|úCŒ»I˚m≈yu>jÑ©äÄô«\"¶e˚[8%’\Z\r˙»€Œ‰À§Ç\rN}ﬂRó‘m„D<’kÂû¸’1®è\nì˘%æDÕ{R”¢\0õMè+⁄Œ2‘”¢ÄÃÊ’;ﬂ\r¥M @Ü…j•˘òc£3.∑R√2†üë-’BH≈¯)Î/π n0;Ÿ[«¢`ù3ﬁˆ\0&V’OeZ}{Æã« 7†tBR#\rø∏\n0fì_`€ΩŒ¿’\\…\n}(ìn»aüØÓw◊C9ã-AñöIQEÑD’^≥Yl2ˇ®ŸJjÀf\"3πózW£0YÆÔP{Áî{’yÑTzwÉyjÜmÄ‘À¨Ä\'‰Ô®fÒ‰⁄öG’¸ƒíı◊GN€2íı*ÌúRmWF~ÑmK$Qä’é1¯Á®œm.JM\\kÿVæ?1 [`u>\0!,ªπ’ïø¨ >≠o¸*˝ÆÂ ,_wEô†ôé]I`[3’ñÈr¬\r¨ßGˇVpGG¢◊›äX3Ìﬂ¯èÄõ¿ÿ;’ú¯∫„5IÀÜÉœ3’ßKnLm\\UÓk⁄JÿµlL’¶á`òAª^{∑”„BªˇbÉ\rN∆¶ãÄèÜ\Zﬂ…≈’”8çìYd^Ü^ûu•YÁq,c$çΩ:$(ßY÷z∏/g’ÂJ¨>#Û\nÒ\"7®ÒÔ`)äwøﬁè1™0.¡^Rè’˜b«‚Üˆ±Í¥öf›’é»RS\rÄÒGÒ4ÂÁá÷(Øπ!˙OX*å‰ˆ˘ä˝§“7íA©Úl±\"ã…«÷&é¿ap6f±K)π^o©ÁÅêOsë<´ó»ÍA6¬÷3ÊAﬂØÜ%wZŒ5-D‹⁄ºÈÓÈ@ﬁ¿¬ó∞◊÷JâSõ\\<ëCﬁè–=s\'WI&\Zã(˛–vaTo÷O·,\ry\"∂∆∫HoÎıS≠vÍP	æçSKÃwãcp≠÷UÙ%(‹l·fU}‚≠ÊÁÒ∏h˘p2Ÿˇ+nDÀ ≠÷~∞ôõ‚˜cØyhçG≥KõÆSüÓhuP•¶•˙ m¢(÷Ü„vB«ëdX ±Á1f≠vH¨éÕyŒ)Ò´l…÷öâŸƒÉ3ÕíÄ\rŒùƒπÑ©ÓËíTNÙ3¿_*ò.÷ûÍ£&˙u◊rûÃˆÅ|Ù—÷i+Q≠`≈∏M1ØU÷†)ñ¯©Ìñ8÷Ùl∞˜/Z‡§Rˆ=≤YpÖ´˝÷›OñØ2I˚—u>&À∑¿†ôËuÚUµŒƒñÉ´Í{÷Ê∞x`À &{;´ŸuŒ’¢µ.¿Á˜¢çX˘®v‹aã◊Æëßkdo\\ï§Ê…ÌoË©˘~(yÿ&j◊Õ¬F¶◊É“%¨@§I°µå(™.#ñì5U[÷ãDB@ˆÖi~1î◊\'7√ñèé\0ÒWî¿∆2jóÒÃˇ ô˙ÍÑ‘—{`Ä¸◊01]!÷•\n“cç3*œ”ÛaV÷Üe∂∆ó”»‘ü’◊9RÌÏOt\rŒC_ﬁ◊˘ß‹4cÿzˇ®SÜﬁ‚s”T◊AqÜc⁄∑ø¬í59´a˝Oˆ˘Î“ÑÍ?ßtÇ¸◊M)ÜP≠HüŸπ≈úkœé%7fà+»$⁄.∫⁄~”õ€◊MxkvÑ\rnŸsüû]%Æî≥∞ÃÅˇ°T¨ƒâ“©™◊^≈{∆é›uÓ◊ÒÌ–ˇí∫ìŒj-{V°=OÕ\\ùÓ◊dT5^+óÙﬂÇ`,¶¬<‹ÎWÿàNèlõS›Õ◊j±ù“’?ç?f&:¶sÎ[#µRDs≥•; Öi◊lbXáí.”-¨t/´∫y†õ”kO’á«|{W9çø◊mdJNRÈjúÌ8?|õƒH!âs—íi{OT6Ú®–Îµ◊{z4ò8à0¯og3úx◊‡F±áRÚ˝«.ÉË:+Ä◊∞…ß&‰Ñá˚ê2Î«–C.åa∫âeE0Á,9◊‘\'ZS5ÄõáÔ4à°ùG[´ª\\eøÄ}*<Í|L;˜z◊⁄x’÷x?&€¯WFèËf≠=Ë„xÈ;“∏ô.uL◊Ùö∑)‘ú2ü˚d«œL{˘ÄÂ0ÄŒ3 5æΩYí!ÿU\nhq\\ØÆDﬁG€hBÑê,⁄;b&¥‹<èÈC≠ÿ$ÏH\n>öãªâT¨†˜EıG‚Nô–`ˆ‚-ﬁ*Õÿ(∫qç∫¢ñ#‘úÇºDì]KÊÉ„–X†¬–ÿJÍïnø˙∑piŒÆo¿ß(ÀﬁF ÇÖ∞„˝rr^$ÓÿOŒ5µˆ¸M›&ıJ˙ê˘¸DœKÇ0£F„Nw0\\ÿP›ªçs-\"ªdõ,Ω‰∏ñ„Ñn«7z:Än’…SKnâÿSùTv‡u»È!@bv±7NgÎ˚VCúÖä% {¯àÿ~4ûu’ŒÀ˜	k@ü5í=À(§Ê{\"≤Xùÿ<ç˙≈ÿé\\X¸‚)Ï–®¬Æ4¡ ∏cW√æ#E5€ˆ”Ç…e%Áÿ√‚/öﬁÁh]†ì≈Õﬁ≤ª#—à9ì≤èÔ`v⁄…¡ÿﬂ‡b∆9ÛN/ëﬁlR˝agL˚°Íw‘∫·èQ¶å\'ÿÍbŸ(c«/õÔ≤∆:ª≤Ù¯+ıàﬂ¬ÓÑ~ÿ„‰ZÿÓ¸µÅµ≤ˆÒ|\0uå‹%rvBÅTë iÊã∑ìÛÿÙﬁÇN‹…´´‘˝·ø‡/°Ü=ıñ1Ü‹I∂”ˇŸDj0\\lõ“M¥51(R·Ê;\\g’åe¯’û˛$ÁŸ_,ØjÖ˛Ëñ∂√˚t¢C@˜ºœä∂¸Äâ∂Ÿ&8Hç◊Éaq_§/Ò¿˝†ï≥ÜôBuZÙŸ&â?¥yÿ Ì=”°¶√C6ôd6Úm«\\¥]vayŸT*´fëZ/‰8Üﬂ¨¿êúU(WÚ÷ÌˆUÚÔó{Á-ñ∫ŸVÕóúŸ8$4ßl\\˝‘L4yØ\rÒot´f`8Ü‘^Ÿ`§ßò=¨@˚l§Tz≈ú8÷)}î~ñH}±ÇqŸóˇﬁNî•öaiÀ˝€9Uâ≥¢·§ª—\Z{˚ˆŸòâ˘\"’Ò˛[Å—,ŸT˝#äH’Œ5\0˘F	\r’RöosŸôﬂ˝$º—∞Ñπ’R®eùj`^Ñ™7ÃËëü%„‡¨yŸúõ≥¶ˇMËÛæ9\Z÷/∑¥÷ \'Ì´Ù÷ı Ÿûò4bVètÓÉ˚Í’Átkã¿ÖEp%Ò~D`%ƒ\0ë;Ÿ¥Œ M\né∂øWX\néË∫®“|Õ|3ﬂú‘˛+¯+∏4,Ÿ∑™Á¥±ò1]˘÷≤lzéºbûVPÍπxÎÃú¨=Ÿ≈≠Õ?∆/ëíøƒå)Â-\'L‘ó xÂ!Ù¢Uw≤Ÿÿ_nFaıéŸ>e3ºü;vzöﬂ„t‹Â’Pùi(¸dŸÿŒ|\ZVw7BAz“·zMk+¿ö∏¯Oö5Ó≠∆Õ@ƒŸ›&}à,py∆F(%≤LdÔêˆ\r*n=YNtÅŸÔ™,köLÆ]*ñ∫]>N5c	YnêÙ±Òl)\"ÜŸÔqöqpuò™uäâ4F¬ÄÊ«÷›Ü$Õ”ïÔû⁄_Ÿp~Ã*Ãﬂ60§#§?BTËPÑ|Ω¬ˇ:˚X¥⁄k«Ù>ŒÒ`ÀWﬂO‹@π!Ÿæîp}Æﬂ_0[¥⁄\Z@÷d≠\nf!BÔåœ>jß◊\\R^3“‚πÛ™⁄éVô–cZºŒ=.\0Ö˝∏¶‹à‹ı\\ê∫\'à∆,ˇô(⁄&Äœ‰˘M1^t&*/:7`P\n∏ÄS!:˙b=°⁄(‡›mybVıaI≈jWpôåØ(!AÈÎﬁ<(±X⁄.#ÀR[$V<¢ÂZ>f+†ˇ∂m’ΩRh_i;1≤÷zm⁄6@£Ãd˜3◊5(ïG\\ë‹ßDoùi	Pép*vw⁄;«Ëù‰‰X?=Ês|VßFò˝∆¢Id≥öE<8µŸm⁄J.ïEwjÙ‘ˆùﬁ“#_\Z‹ûfÆnNÄÅ˛7íâ∑ù⁄U/§ìË/gˇ#™ÕJK≤”í≈]Â†πá¸¿≤»˝|¨Mô⁄n–YÇM\n™å}2 `í€QÊÛﬂv«Ò_Ì\rzBû^=⁄Ö∂c:Ì∆‹æ|@∏∞lı\'∆“e±©óﬂ≤ì†~√⁄⁄ÜL-u5Zkwã=03O∏çå* ;XJêé¢≤\'z0⁄´≈≤∂ˇˆT\"œ€\\Sã@•Ñﬁ•ñ+0yrx9ÙM,Çõ⁄Æ(á\"°Y<%∞I 0c+	∂±ÉƒMƒÏv1⁄∫Q˛©G‰Éûu∆Gi‘Ø“góØÃÁ#dNı†,Åàó⁄√Ú÷¢‚¸íºÔ∂Ë_Éçˆö5Ü^WÁ{£Kb⁄ÀF–yPX»ƒpü^M∫∆¥s>Í\ZÇH«.\r∂¡–⁄–˝ﬂèZ£\\UD—‡˛O‹tÛﬁî≥&≈îLZOê\Z£4⁄ﬂvdU”“ÚÈ=â√Ö=cx\\˜µÈ≠û5\'“µ€d’ª`πõkΩ¬_[aJ{°÷p\ZúE=Ñ(XÇíÛ€?l;åò]÷À)O=bîπïäÒ◊÷πí\nèôêªê€\\s	√p§JåTX~Ü◊\\Ès±Ak◊\Z-=ê}F€bñ·úæÔTEw!ßÜ}ûa}.õ& c-B»\'°Sj?€pÂáÄ,çXû®√Í©pˆ„˙!Ç:Ù±ÃEª¿ŒsÂ€tè6ñ˜ıSzÏ√•ø˘´Z•„áÊ˝Î—˙,èj’€ÇwT\\‚Ö ¨è+⁄=≈—·û∂ÚÖb\'^˜xÿK√.–€ë˛&\ZÈå∑ﬂ€ê7Í∞~Ëø¯ƒ±Ü‡rb·©ˇ€£ÎÇ‘∞<Äˇ–ö~_Èm?#±Üº©Ì#ùB	Ó(“€•~èb%Öw\0 òz±9äws”‘n˘Ÿ>Dy1€ßñï¯ÜË#)\"Uı≠Œ‘˝G§˛∫¥€‹ëÈ]ı≠€≠ÅM:EúﬁZ€<v(@^ïïùÚçeıÌùK„è\0€≥}sYDkè6õ–ÎâÒÕMµ√(kGNáÿ©\\BŒá€ª¯oXcÕ‚Œ\nëjJÊæ#õü@ÅR†0∂ÅÛ`€¡Tç’jÒ§5‡Dû˝≠-8Fé⁄÷Q\r%—.›m€ƒ5ÅR¬„ñ©\r;ˆgPklÑr<‚ËCDä‚0*\nˆ)€—≈¬m÷”x:∞.¿oûﬁw˝p‘¥6b@‚WÇFk€”-πÎ÷€œÏÔ‹—1È‰qÇ[ê¢4ö2\Z@—rª: €”™Nã˜lT≠DìÖ€,\'õ;Œ=´∏Ü%»~Ê	H`‹M?˝~\"»Õu%≈[˛,êl§ãâ˙+?F-}±M)å‹É›Ã`@}6Á∞–Ô[d=w\\ò∆+yÂÕ%eë-¥_ˆ‹+à∞^èï√J6¬ ^Nih»ıèOJkfˆiB™Œ·‹•DúÃâI~—¸Òß≈˙.lú‚≤v´Pgª·öwv\r‹\"aMI¯«Ò\\›P¨;bÛ’>Íßí5>7Dub´lg†ﬁ‹=z^´z)táıó?≈™ÔÈ≥ä<)ñì+Å$·>‹BÄFV≠dº0•’3”‡ä¯¨mÊRÓ2t¶›/v‹S 4Õh¨\"ïhAD\'∂\'|Î∫6[kF=◊\nyi≈ı´‹fÛmª≥±âR˛≤Ö‘ÃóUíiçÿúœÁ÷!Yπ‹háLÍÁaø˛Èó®b¯À|\r,7@\\\'>’ı∫ô0ÿ‹nÉ+S˚˙KáÀŒ&ÄsØÑÒ—â∑\\;Y∑qª9öë‹w•m3ütÔ	õ«–´Qvö#`i-1Ÿû‰U˙h ‹ëÒãëÑ«£g˛÷⁄\n‹‹˜4 ]¥D¯$ÉØÒW¢π‹óïEπVÅº8÷ãi;ê±f¿e‰|≠Ã‚¢À§ÜÀ‹ù.r°µ≤ YMDMK»qçˆƒπzÎZÔpÁÔ˝ﬁﬂ’‹£x≥≈L#À!›ÓE±~p#Çwºàˆp˝1[©0L¥ˆ\n‹±f≤úûX§≈IÒ`&ïõØ:ï=^ÅèbÁKG¡\0.‘Ã‹¥&ä#º‘kpãe`£Ú∑™±†hôfùœsIûXNk‹«ó!∫‡JB(ALÖ.V#8ˆde\\äÜB_ï&‹…:¯µK≥∫ø:êı\"¬á$_Â«•˝\ZòÜèg†πÖ‹–pêSIîÁ€{«´2jP±µfÂGi+YHÒK‹◊Ä§·ÖÓ√ﬁ&¶©Ùf8ïß÷äÑÛÆHk[%Û∂∏‹„m÷r¬ä›s+n≤0ŸOf¸ûﬂÏ÷†Æå7¿ÌyÄ‹ˆ◊„Ô˘Á®∂˛∂ÈÅ\n£oN{mnP,Ÿh®+p]h4›≈Óßg\0x‚-ìï¨®8£ì¿¯ﬂ˙EËmbçﬂE\rH›	Z∫∂mºéã›\"Æ6áä•N`Ô! B\'wCïÀÆî›.∞0{\'~K.sùJõ∑µIP⁄´∫&nRá	∞2›J∂˘ØX}ö˙ké;\nˇ‰ˆ¡È5ÒøV¥rû˚4›äwµ?¬úL)£‰≠K∏ˇÂÜf4Ÿ∫\ra~˜ÅtnTÃ¸›©zKõ±uë√Y·‡.√√m˝i¬4üí´*¨UT‚›¥™œ¯Ó\"cøYOÄ|DÂ\0¯¡;Ì.¸®ñ”—¥∫*N›¥¿K¬ÒbTﬂ3ïy¥*Ÿ˙˙◊†µ\rF¯åò∑˝ñ›øp¸\\‰/h#]\"\nÎ=Õ/ ˛ã¢MZ÷É≤·◊I›‹33πu†n∞±M5Kh&ÕbV\\%òZ$ËiˆÓ÷›‚C±1Ÿ~sŸ\\Â6Œr€ò‚Ùå¬˝é∏\nŒ£…›ÍÁ6ttáé|Î¸…hf•≠S?ÓfÌ_z¢™å`ÙyÇ›ıÔ»ÎÖ(H˙2Å\nyœÄ8è‚ÖF—pøò‡B›¯»kø¬ ´.Eª†ü\"yÀ3¯(…ùO6¬Su’õZ&ﬁˇŒÍS,Æ	…◊‘pˆ\nb!ÍÛs!úÕÆ]Ç>»ﬁ\nòÛO∫€j«¯‘5ªRLCâIòe¶Ù∫Ë·ªîJe\0ﬁ.SîFà>Ì.ú´Á›Óù®wÔgﬁ:$Ä\Z	û±™Vﬁ8{‰ıV˜Ì˙9À/Œj⁄zbbûﬁ€hF¯µ+î\0~öﬁX€t·«û¨ÉCº∏{ï–„%®©fÕ\"Ç¥Z_m=ûâﬁZ>D[π{∂©Œ/≥ém9qN‘9wN|\nﬁ÷•Ÿ¬sﬁj*–ÒbîåêÓTˇÛÖO5pÂp¥`ÄÑ)¬ƒﬁñ«pˆü¬1i˝≈–ú’∂˚&Ò”19ﬁ†}D3Ã≤ªﬁö$>™¿˜è™*ÒÙ»»÷~wa∞\r‘¡µxåöÅÑﬁ•\\ﬁ}¸9QZ◊Ë\rHO\Zô+»Cµ3\rÕáqÜ—¸Åô,‚ﬁ±‘€Ó\n1Á∂$ƒd8v^!*ò3»ÁÛ#Õúv@ﬁ¬3¨&hù±N;yÇB\Z‡™ÂN§ 8	j¸xﬁo˘ﬁ÷XQl~?ã8íπï∏÷iÊ”Íi8|°´Ü˛’Leﬁ˛˙Øù’˜ÀI”_y:˜∂éì&«Î≥˚R™zﬂ≤<OT%x\Z¥‚‹Çit11Eπg‹U&Ω¢2ﬂ1∞èYI\nf	úÍπY·¶ä”œFrL«ôºÿ7ÄﬂuÖ°ï¥»Sñt÷ó˘≥ıpËú«Ø$UÇ-≤mˆ©ﬂ âó~–‹V∞>É¢ØÚòÄπÁEY\rí,iº’Çà˛ﬂ!\rÑ2nƒD¨õ¿9TÈ%T÷ñŒ\r>ôÇõÏá∆æ‚Œ¸ﬂA˝Y‰{,P\0~bïäù\"‹É∞õΩÓÉÍ◊©n\0A„π=ﬂRéíò<ÓF{»;xŸæ€∂Iƒx3¶\nÈz«ñ€ùQ ﬂhù∞¬-nÒ&˚U±Ïe\\—Xjö`¯¸nŸè≠Å≈|Ú&ﬂk¡ó2ÿ˘ ∞„S|ßÿÙI⁄ÖﬂÜRùÿ˝yπrˇﬂv@|ﬂz˜%Ã”∂p,¡çÅro;B5\0±⁄CÆÖyaFﬂvŸVNc€ääi˜Baï÷·‹”∆T«fÄXﬂ˜ﬂ|†≥jÚ™”b∑™dPœCW>b·Ê∞$=O‹t«êﬂó>G8j≈j±4áï8µ-sÅZÓá‘ès≈ùf™?ﬂÖy˜RÎòzÂ5ÒµTßò\0ÀDUçÁ££	´wÃØÿﬂå\n˚â¸rÜÉsg…¥≈⁄ù„5Z¢}ÃºØı‚ÑﬂåıPÅ ˝Ω‹ªÜ\0∑{QÅÁ–©#Ó˜m,¡x\\`ar_ﬂîıÃ}>&ûIy∏	páó¿by1©∞8ãÅgúJ\n†∞ﬂôw§∑,ÿ‰¨ s∆ü∂lalkHäÔJ‡n†›?&b+Œﬂ†ÉÑB.qf6*_ÖÌ-◊Î™˘á¶WñI£’4óˆK2ﬂß∆)Ûˆπ•s˚gÒÁØ,Ñ¯¸He‰|ï\"ˇjÃã2(ﬂπêVÔ˛™à—Á˚œN´A=¥ˇ≤X›¿˜\"Ï√.Ä\nﬂ≈Öiá2ó≥~Í<¥gªq‘¥TœóˆÊÓ~Ç%>ãﬂ‘ç6mˇÆìñ_®5”Ù≥ü¯ÌõË}œ;[IﬂÚFÍˆi±”Í„|x¨7N§ô*T§œœ‡Z¶¥jî\rﬂÛu^kb⁄µƒÿ»)ÜP\0òÄ◊[\'‡.§l7Ü‰^\rﬂˆ?ä%’R˛øÍcí¡≠IgláÏü˘ñ¢QRx\Z–ÀÆï‡ØR´-SÆZoé3“≥CAõjªóØ	ôMîë^‡2“…ñ<îtfp\'“‹P6ﬂ±…˙)∂uõ¥@¸äÂ‡SÖˇùC≠oÜ∂≠m9¨ ÙÖ4]∑2IeE¸òkÖÑq‡h¬ˆ@N>ÃﬁáÕòRRSo s™BycÛ!Õıl‡É™¢ÁÍ	ÅMJh^ˆÖ`≈º7∂˝Z‡=Œ⁄‡^‘Ø§Ø‡ÖœƒçΩ1ÕTgë´ÿ±ˇ¿DÀÒw‡hœl‡éÀ‘ëìÀÏ_ãxÜ4é∞ÆÌ\r[Úœ	\r+π˘Öæê~‡ê\"jó\\ÍÁ≤Éh_EÃV\"∂ß∑R≠ü“Üc‡úﬁ}ú◊o©i”øFp‹&KÕIP Ω±D≤·[âí˘‡¢‘E=3iJ[aƒ›x≠(aBΩtgÒP	äâBÉ€˙Ü\"‡≥ÑΩ±∆\"-d¿J§¨∞î•©’´	UΩ{òîéˆ‡œ(‹QGË<C∞<ºí•˜ÍF\Zm_=|Ök¬Ñ±B√¥‡—4®·>]F¥fw\'‡ÇÜà••øÊ¨öÍ„≠Evm8î‡Èa¯ƒÜÓ®•ÍJ ˇΩµH⁄¢#eß†ÅR˚æ7\"d‡Ùá#! E!,ÒÊîcl‡5ÑB\\	W¥\"g‹∑ø}}·Ëî¸|ü¨ìàCÑ C0Ω¸≤Ûv”«0KÈ∞\r- ·Ë…Ó¥Ëpπ≈èÆ˙∫4,ô·ÈKY(óIé†· xD®QÉπ·/¢t˙´‡≈võ±…Ó«πUÂø8π·&›.a©ïYA¯â=∞6à¯	›ºÿÊ4è\0çe0åßÃ·-¶‚©È4J†\0Û)S÷¥≈‘ÕÎÚ? k\"4‡Zπ.·Z9êÖÅ\r°k≤’ÔXÍ∆eã_^àq(—µ˚/Ãπ·hùá—2§˙Î2&€Xàt-ÂÂ€¬a¸úZ∏n·m˙sN‚èQ\"?ªmFN8™?ôpi\Z≤hÍ©ÅHÊzÎ·éûO,‰kîh¨iY£¥e’8;w*Aﬁä&\'DÅ:·ô–5í`Ùv>ëÁÅdËékˇ}<†Ω∫ˆ6«˛Ä ôè·ü»ÄÚKBÓ€µ&|UB∆ı\0®Yºè‘;@7“Ò≥Ï‰·†GJ„Ú€ΩÊè∑+÷Iæ§-Öìç∆Í∞i3◊<· Óe\n!Òd>«Á·aÇÒ˜ˆ±%+£eT7 ı“ßg·—èŸÂ¢ÈøﬂdÎßÎÇÒ,w=	©{|\ZZoœ¢.ö¿·‹p÷]ÌU\Zeﬂ⁄˚OßlP®ƒŒ÷&A{∞ä5··[8#ç=èGòÊ{tjã\ZC`∆qR%ÁÆ⁄D≥ã\"·Â/ˇ∆w?Z)H%¡Kì-úxrNúpÍî®‘Ú%˝‚\r/<Úı©\r∂gl+üQä_rÄ-m√PÓh¶Qâá‡‚$,∂©Ö©5ˆ%måú¸‰Ìßæˇ€,ª\nu(ﬁûw0‚KoHJ,aÙª	îrÜU9\'s?Ã|àÛô´æ‰Ù‚R0ôœAtRWÎE †)©Á÷ÖuTâ±¨RπœY≈‚T6ô¬rÇ‰≥\Z¢IZ)≥˛[w[]Ô°=`LÔ†√û‚V GÎLﬂ‰°˜ô¨¶mJóƒaŒœf§oÄ\0Âê‘‚Wªòeÿ2⁄`‘•:Z?ç¶ö¢”Ïè^X=G»Œ≥π‚b<ÅHîGß‚wE◊21ÔwhÑa3(J«@‚g)ï§Úz®ÑçÎü≥9Áœ≈=∞¡8‹‘˝ƒ\'„KI\rn∞‚Äµ`˙iz †Úy}˝≥fWÃmhÔGmMï≥∂]‚òH\rÏuíâ:ç∫4à·õÃ©¢i≤Ù˜óó7[ÅG‚§Ï≥ôr„/a4†v)öw}Uı≥+˙ìË∞Ü{3‚•æ®œµπÛæîÍÁëâóN)]ÙÚW1ó“+Z±ß‚®* †“u<‡ˇeÎÎË\nﬁÁ,õß•&≠€Õ≠1ø‚ Ä€:If	Ã⁄¶%Çã±5–@Qâ85ı Ç1€-5‚’¬’ºymÈn*$Ô\\lµ¸GöÖ»¡*≤E‰M\nl‚◊≠œm≥[-˘B≤8Y¥üŸ∫™ídô®˚J6· S.‚€V59·Ü˚ú˙4*∑Ñ∂føH	ºáÏrôö*\0ÒY‚„±ø;+h<RÙæüÒµπV≈_„◊u&RÉ≈·ë:‚Íò∆πÈW\rbC®Jüô9†ûnÅ‡FB òyﬂJ/„ad∏ÀìVß“BZLCÄ˘π¶;íwx„Y^¡„&^°”=∑x ÜEs-µ¡y@÷Gºyó\ZıÚ≈}¯ùq„-™≥Û—Åo/@¯8ÿ7≤≤ü?õÃ!c∞¨^™H˛ç\0„Eú*–⁄™IÚz3^M±éïP4ê∆•∂Fl√wRC„H1ì\0H\rgf¥^Hq*Éﬂv˛6M«g2‹¬¨∞„IÆYæñî„õg≤∑÷_¶À˘µ,˝\ZI.&;ç”ær„V<Sg‡ùUù|ø4E+5Â§Cı828®òã“ùΩ„o˘\'€?”ıä_Ê8≈‰€ó0]$47F\Z£A#Ñ[∞RA„r–≈5ù7á«{õ0≤7f=Í9G˚cNÃ√˘yŒüor„|Ç∏AÓ\ZÅÌUò\0ÆŒjJ¥éŒÜP»M6.\n?„~ç¢o‚ï«Œ•ôTXJ)*aõÜ∫L#ÙV÷Ò≈∑äÓ„˙42BÍ2é¢¸±,u∂Ô ïn}~¬“ÇZ-„®3Ø6	≈‡û£õ¯>”Ø•\Zˇz?<^¿Ê¡°Öœﬁ∫©„™%8è¨˜\"øyŸ±OlBÊ=VGë·hÛã!‚≥ÃKˆ<„ŸJöqØ«;ª(5nO«j¶nYZ5q⁄«P‹†ƒŒ4„ÙzgzBÏtWnåW˛¢&ªcﬁ\'J@{TÁ»÷rüqØ	ü‰*k˜”J+ﬂ0˙œ}˛VLÅæf6	ï‚«¸”Ü`lI*H‰?≤6≠ã˚√Gß}hÍo⁄BÉÍÒ üá%„˘µL‰@°ƒ•°Ú¸buâçÅ(FHP\\»ØC9!≤cn¿‰N*NJgßù™}YvÀ‚µ7—Oh%.\"AóX‰*‰ØÇ∑:´rˇ†µõoO«\'7xæ9¥†È)y≥ë˚j‰—?wk—6Úç¿å£(.•Tñ vóÃØ1ãÎ™Ω®ªë‰Ê˚é˛5ëNÀÌb7Ÿ≥Uwä¿*)⁄h	+⁄û≤‰Èá\n)Q∂‡N k€¬UÓ4û…¸J∞Mõ—\\ÃÒÍV‰Î´ﬂı^1µ‹Ó√Á®u≤ÓrYﬁ•1m≥wÊÙí±t‰Ï⁄¯¶à&òCr\'BMF”u\ZxŸ“/D9¡´zH‰Û&UÈˇ>»+Tú≠ÙK˘F(ó≥,`:7≠ÜQ‰¯‰˙«±-FÑ°éZ´QÈT∆∑n\r¶ı∑{åè„¡‰¸ÏövAôºŸÛëH¯\0áeq$ÛW’Djõ≥K+{j®ÂPu¿œÖ¸π~˚\r|F•≈Sûa(„JÄ}»üµA\rÂ1P‘xúzöuÌÓ—∑±;gtS7Ñ◊ÈGn+Ç¢QÂ1‚∆rg§ìëQ◊ yg·–ﬂ5˘±.h¢îf∞ˇhmÂ;Ωˆê»k¢ ªÙ≤±W8°‹–Àâå°Ù⁄n·tÂA‹ËÉ¯byóMœê;(uj˚˘?÷Û]Î$ÕCﬁˇÏ&eÂZÊ√%ø,zfØw#nÿî5≤0Då*/rÖx™∂PÂg÷Êbñ =#‡¢\0ˆMú)›B◊·„Ö\\e˘±ÂàCA¯Ô≤wÉäŸwK∞HY¯™Õ\"˜¥‰0d¥ﬂ∑ûÂî¿~»ÿ˝kÌ:µ£\nÏ¯‰‚Y®√Øy.æ5 <Ä‰îÂ£o ∆ºoP?πñÜ¸©D∏ìOê%≥˙⁄µN:(Ï≤Â≤{•Zÿ”åUÜJï£¯k#HáÖT]^•Uˇ\0TíjÂ¥†&πY|Ìês<ì≤µ’È”Båö‰J	Ú(z⁄™\nÂ∑ƒÖ[∆∑GÆœ•¬÷±!IüzÛAË4Nˇ:”äŒÂ∏U	û[ñ«√∫ÍÊy-»’‹Ú¯äÛò )≠‰õ5Â»_‚Ba\rcˇ≠ÇÎ—ˇ;£ˆÇpÓÊ◊vàgm-,Â”»˝_çÌº\"TõPú].Ìû≠jÓ¶8\\3«c\ZŸ^‘˝Â‘@i# UcjH´q.ó!˛‚Óø€¥	^ÅUú”\r„æsÂ‚∂ˆ&‰zÉë≥\\ı⁄›L“†ê•‹¢Kcu[§ÂÊçû˛;mÂπ°ôF}I≠-6·únŒ$è[ÂÈ®é$\n¡É¬9ü2%ÕV∂Ÿ˙¬î“0D2`êqú®ÂÓ®T&≤π%—Ìqå5√¢ˇy\nV⁄åæôH©t»Âˆÿ»:ú–<ák%∑èõ˚ë¬‰ˇ (ıÑ¬1≤”.ÊpéIå∏uòäº‹eI™t9éÎ‘]ÅÑ\05πÙÂ^Ê\Z!Åû˘‹cÁxN∞Æd◊i‘GeAI@Ô\'i€§ˇzø¶Ê*Õ˝bTëJ”-2„‘Ã<Ö8Ko|ínF&QÛ ItÊ-Z\rìÀÖáÚH´FÆ wb‰9—ø\Z”xRÓ◊„÷cÊIü0„{ö»eQD‰– ÏÁÄ{ë∞~aK\\-÷B\Z¨Ê](5z∆!¸U«‚N[·a¿9ª{›œœ∆‘j©õB0P˙ÊoU≠ú»€KØòj¶⁄aWî≈õ\'Ñ¥óŒyà≥¨YËÊõó>÷‚@-úœ‰∫Ï=ïÊ	gÚÑ_ö≥ıÊ§Ò{-SP+f£¥Q˙p‰‘Î87i!*IÂÌ‡ßÊ»£7É\Z‘,Òù°ö‰®[xÀŒR,<XéÍ¶»Ê…6ÎKkπ	ÌÌåo¥åòyAºw)ˆƒ}\\C	\n—Úº=Ê’â{£∂ÜïΩo◊∂gbêUéïúh∫6âˇñXEíç.Êÿ€Râun5jöä©Ù∏⁄O\0È6\ntÏuŸ=Å¥¥Ê⁄˘óß5QÊ˙%«õ|ﬂÇé¢¡Y≥Mﬁ\\…Jªaû·bÊˆƒ¡T ‡˜jüèè›bGar∏UﬂÍÑ~ï\ZoZÊˆ\"T…∑≈\rMŸ +Ë¬ö	`ëàÃ‘gOÂlÊ˛:îÊÏ‚Ê¯l≥}s1§iJoƒZö3w‘/atÿÁ6íµaKáØãÈ5Ö»î4ê\\4êM˜Y∂^eäxèM~Á?\\p˚éiEEÀ˛ ,õ8±ˇ∏æ)¢T≈n,˚ÑqªÁSF¬zî»≤MR˝√W3√“\\œåÄË\r«◊qØƒÚ1?ÁXEø∞çGDÜf∞‹L≠S¬qÖÜ`÷	Äî»Ÿ∑ÁsÔÜP¯…≤WõãM®QÛ~@‰≈Ø√√ó“ÕîÁÇøE»√Ó$>9¨6g\0≠Î√àø];µ≈là¨†ÁÖ\0lö*\ræüçå∆\n%ûE\'»t˚˚FÎ‡‰ùÜç˘ÁÖ∂\Zf=?±û;[ßîÈ%Û¬÷j◊ƒ{jãÙMa7Áèroÿ´…Ë€lÓ]FAå1_ÜÌÇÊËÑ\nÔÃ¿!Áó∞f˘WeJSíìZüwÎkÏXπ∫⁄±‹Ú”çÁöÿ~øÁã\n} @ô=ﬁ·‹\\Y≥ÒY¡C™à]»«¢ÈëÁ¢ÇÄÜ“5†π¢ÃcßZ°œÁ∞\rˆªl∂YÁ§∆û[#ƒi[ü˜5–ñ–≥4\0‹«2m∆Ã&Ôôh`Áß∆q\n\"é)\nä—ÍSe]úÈ~§&^vèπäwÁ≈úã°¥ãáv|⁄ÜÖ`z`±ÆÑ≤I{˚z‘÷CÄ9Á…]W™ÚàÓ9’ã ∏oz=™Æôp≥r¯ƒÛ˛7ÁŒ¨’4µ≤9ÏÂëEâÁ˘Á\Z\'ôx$˙ìÒØèìñÂË\0£H\n({›S=gË≥ÆŸˇ¬âkyoÃ‰?˛îïºËΩ∏œ8’á•–|B€ÁíDÖäˇÊ´1òã3úÿ7ö›Ë∂Ì≈£ùÈÅ¢\n<Yz\'±…jÏXú∂ª`Í°fr•QË\Zˆ»øê”4ˇ·¸´MÜF/«-Ófëørì:CK\nË€8]ìõPY›¿5H˝ºÂgb«‹:í<ûx›¢¶‘XËÇ«,sË›’\Ziô(±6Ë≤ø!ò˙ûˇgå—ä—k8Ë&®ﬁ\\˙•-õ“ı38ûÂ≤ük‘nêæ ç…œ£Ë,+ùˇYy.ù2¿\rt*q7Ïÿ,jå_HÀdºQPY±@Ë-¢¬õdå¥x¯jΩè)î£dmàx‘ÃÅﬂªáÎ?Ë9›±|˚æX!¢lΩã∑˙%1+„wÖÁ‘$≠5ËJÌck!‘õËìHÊFºfKË\Zæñˆ≠ç˚Rú$H§Ë¥ZYÓ°¡Ä\n~Ì‹P.ÂÍxÍúÉ N◊˝√Æ(πgFË w©ên~i;õ≥V÷Ä%ÛTFì±~øe|,|6DËÊFR¡\na˝*!_^Ë≤ø¶r˜Ö`Hø´a¶Òb«Ë¯w˜@Ë©Y‘Ã√¿a_â^ÀÀf§¢^Í—¬(ƒ\rOË˝´>◊Ë∏≠,ì◊ÉÅûπöØ˝è\\qÁßúÈ≥rÔ*≥êÔÑ≥⁄¡æLñlf¢∞≠ä∞<†’wûÈ;∑?∆·æ›öµd Çt-ÃÃ¸8e‰0Wé¯~ª*È>< *±Ï0V˜ÍáÁÂ£‰©ÿ\04æ~è“t°µ˙UâÈgLÛQö˘¢∫ä“˘Á£∫1Z“ktx¨√*˝ö∏5ÅIÈq¨ôÚ*÷lmK“£kƒ\"–MˇQ? pßçíaÿÇÁ¶4ÈÑ≥~„æ•›êµÑnÑn\'¥-ùòÁÑÒò“âVﬁ>ÁÈà¢⁄õ‘r],?i(R;æ¿Ωê}æò>ï÷‹ÈûQV!yvpcÃíP`†à-ûe9rJìK\'t≈œ>;È´•˙ƒßgZÔò¡˙åÎC›ﬁß‘J†o¿È*^Ò¢È…∞1ñNªJ˝Rí·i¿BËÌé‘Oı”¨BÃÍVÈ◊h¥pCÈ%‰‚ZÌñ}æ=¢ôs<€îüÀ[ZË#g *È⁄È∞\ZÈê;1\ZEî?IcÆ_ÄÜÊêcƒ#≈à—MÈËû-µ[\"πn≥E™*9áêpì:÷cZT\\◊Áõ:_ΩÍñ&#`Q∏\n.	.éEê¨@¨—é.˙©%E¥∏gÿ¸àÍ=·ûN3‰¸∏>ΩÏ¨gú|ùS(F—j«ï\nŸ’;ïeËÍXÌ4P£ievÿ˚ÊÏWﬂso⁄ã≈LÒ≠QBW√b•Íe∏x˛ÒAÌjÅ,p§rÒàkïjV∞iÉ…ÍõŸ]»A¶\"î•ë±ó3#¿q ∆Ü÷\Zæ)+êl\0#<9Í¨•\"œï¸ìÙA•Ÿv’hzƒJ>AéqÉ‰Wﬂ&zUÍÆV®öµ∆\nW8è ≠≤`è\0ayxH√µπ◊†cÈÍŒèÕøÕ∞µ€9O¸8Ò^^Á]¶Ω˝t*fÊ%À˝YEÍÌ∆5< `Wˇ≤hµ´Àj0g˜_MÜ¸™—TJÍÔ\np≤Öc¬â[´˘«_:E(.)ì&$*~œ(gfìÎÿ;üóác©◊\0Ã¢∏πc‚˜e€:Hb>R@\'=ΩvÎ@5)€ÎÓy≈&°÷´ìèÜã\rª∂ú;ƒ”&Î∆ÿõ∆øØÿªÕ5|Vø{£◊æ¸A\rreAFzK`Î\"Ÿ?–ﬂE¨ız€ÍcùRçúz±–ÕûÛ.V«~!Î6¯òk8ï÷Ω¨Èˇß†W\'–|«òÃ˝órf≠H	/Î@\':{™YΩT3NZ•O«QÀ∂‹©8”N?5»ÏnÎAîπ.∫yóùaˇÈ§∑í#ëöŒc¡¢Ω^S·ßÎAÉ˝_ö»ﬂ7˝\'hcvúë]Ω‘#\':ŸzÿÎK◊lﬂ‡?˜Yk“È≈2ÇÛ…ÏW>ßÿÙ-àMıÎP˚N`g?\\\n¬\rK∂¥πè\0ﬂJ<«ò3bxT:ÎW*ñ”™rÅóÓ-6¢fˆpxc◊,hoNÉI˜Î[Õ\\ﬂ`ˇnBÊ7è$Œá#t˝\"S¨m–⁄-ÆßCÎ`Õ¨…äŒÅsŒE#)(ªÿÙA[îhô\'˘Æ¯ÁÎ|‡˘kaOÔIäÓh›9A\08(ø?ºK\nµˆçÕ†∏ÎÄZNt≠a¬Z¨îf+«†ë\nıKË·∞˙ù∑∞úbØÎ°n8úı€‡1\"P£™¡‰Ï&±8◊X;√U^é€ø“ﬂÎ§LDL9∆4ì›¨J“Êï›ÉıCÌ¶lE<a«àÖÔˆÎÎ•l„.ƒìz⁄Õ]\n∫’\Zâ˝:õ¬zs\0nƒΩÃÎ∂ˇ∞>∏e≈[7ì“NJı™tté@Íé`∂2ZÎπ\'SßVŸ\"Í*âXAüvkúOxºﬁ°÷mdFF√ÖfÎ“a+á6»¨Á≥Â¡˜)rb∆4î ≤g¥©}SìxÎ€v÷ªña ©∆D\05SSÜ-íŒ*√^”Öå\\w≤ÎÍÖ±ç¨/Y6_†Ï†—w pk≤wˆ¡¥0ˇˇßÎ≠“%`0ä∏™ïvl∑°µ\rÆòò\n?ø4…øÏr÷çùO©nøı_4ƒ`Ö/ì-Ò\'¿ÓaYI|6∆ÚêÏ`Z‚4ë®\nøÈ\"û±l\'¡„U8yÓkSlˆÿµA∆Ï(GLº¶8!ê’<zΩKr÷i„·ImVáe(iCx˘Ï/?áø®Oëæ«E•q°≤i7A:ä3\rî≥ò¢ù:Ï?∞˝2=ã,¨+)ÕÃª˛”n£gö≥ª3©(∑Ó°ÏDóÌ‘aà!_yÅÅ˛	¬QìVGKâ≥“ÇΩösv@÷ÏEâ\n√F	ç	‰ı≤M´√ﬂ%{≈ﬂaë⁄`,‡±ÏN∫À‘˘\0Â}Aåv≥®√Aæë$Œ=ﬁ08Q◊jÄÆÏV\\ÅÜPË[‡pHa›F~yQ§ÀäÙ„Ä•‡√rÙ·Ï`êÂß\ZÊÀ‹9Ò˜ï8Ra>r’ZÂÏ!¥e%©Ïd°uH/l+“Ôﬁ†‚›‘Ó÷.Ñ√ˇI6äÒ(€ˇÏõéyóRÙjÚ∑\nM¢«¯Ø»x\r.sàŒÇ˜ÖÁèﬂ¡å&Ïß^ü˙5Pí´ón‰Ó>ü·:¿˝›¥Õ,GÚI∞zëR•ÏÆù¿í¢y•Ó√Y#®«≥√E	¥Ë92øÅûû‰ÑÏØªÉvnjs,_Y{\Zkïò]µŸõz∏JÚ^zÅÍÏ∑{ëMé˛…˛9l+:A¢Í}0§ö0»›.Ω@LÏ∆3¢lÂõîâ\\’Hi‹µxÑfÓLl#@≈§ãÂe+Ï◊π=íææ≥So\nh—±¢Ÿã!J~·∫ûê«°…πÏ·Ωô¡g\r¡ÑyÙuCxƒ‘;P{Û≥kÿÓ∆ÈyMÏ„#µh†.òêí?Èıt#…†áÇ£\"¸ëÎz)`ñÏ˙RI+ã_#aÿˇp[o◊Ò|\'Î:@ÙÓÛAè™◊} EÌ√È•¨2,Úí°¡)∫ùìw_ÍD â‘∂ßÕÇÌŒ‘6j4∞0FäÜScˆ\"´µ~÷÷G8<\'Û¿àﬁÌπÄÉ≥Ωë:Ô¡®åMƒ6©™ø/ÓøU≠9)ÌOÖ‡„ﬁ·™ﬁWT¡ç>ïÀ˚äçS¡Ä0\0…;ßıQOÌ%$K˛	ùú’\'ﬂ‡Õï{)≤∞_∫“¬ƒùé#/qÌ&ÙOƒ[ ∂—˜Oπ\"¬≤Ê,ÍÏÙl?2j&óù›ÌÌ,ák‡∫˚‰˛õ•˚$t3ﬂÛ?iYœ≤Y⁄∑OÜÌ5]IˇÁ{ˆ¶Œ£õ§ÉŸöëXÇLÎl«ÃÚÃ#,\nÌW”Mbô©X∞≥zp)\'ÏïFÒó‚{ßÙPniqåæ9Ìoß√Ã≥l5 y9ÚMbÜ&èiKñËues∂<%Ìq—¨6Ÿ˛I¨¨ΩFô_ëÇ\'Qï7ó3#5XN∏ÌxL+∫÷ñ}	gTj∞Ù,ﬁ)0fúí€Ìß≠;7p>ÌÉDy(È∫ª&DŸ-s\'Ï„ø#÷õXÃﬁâÍŒÜï>ºÌíè›9»FÑ‹ê±ê† ˜d»„Ì÷∞H]@eÈPaÌôyä≈ù&)‘ß¸ª0–x)/“m€ÖÕrŸUzﬂÌ®ï˛ÍÑºŸ&öïπ[jí}wR˜E˝∑Å•v‡ù‰ÌÃ{AÔÑÒÙGâ5ˆF‰øi	ùy*dq]úOé»X=Ì‹û¬ì√W[Bú\rD›¨Á˝Ç‰†Ë≥v˚p◊⁄Ì˘>˝íj*∂°ÃÏö¨ªeÌ3÷pû]Ê¨LÅÿ}û`Ó‘`ÅŒDX1Û®ò‰Á¢ÿπìÛWJÕˆöÕ]c∆àfÓ	u¯J0f∞j\0÷ÅësÏ–ZRâ~ï]Õ¡¥ﬂ*√¶‹Ó\"€rdê†Så2È!Ê{ó÷£:=˙Nz‰‡Ô√gÜ&˛Ó$óF,çlKÍ∏â/√ç9ˆzﬁ√úu†Í\Z\"ÿdmÓ*\Z‹Ó‰¨X›Õπ[I|ï4rÒ_úxSÇ¥©Ó*t¡ñÄ€^Á&∆/ \\$Ã“Íùr\\` ≥a˛ÃÓ7%Äøe≈±CS6’ÍÄˇ“«ÄËh§2.^W®wÒêÓHË√Æ4ÒƒÚn˛~2p{wq\Z.(Ù¥W—aÓ_NËÛCú≥àn‹d,yºpØæU≥~∂ó…2 ©˘Ów«:µççjU /∏™t#Lˇøé\"u‚tÖ‚P«w\"ÓÖ¥L€x|Ô(.ay‚—´uÕ#\Zû⁄Ñe˜úúuÓè«uIÂ;o∑èË,1˘{˜ò[r—∏5È∂b®,Ó†˘ΩâB2Û´+Y‘GHÈıºQÈM∑Æp+÷ iÓ≥«2—vC∞≠í∆míù*—i˙û¸QLC∑H8Ó¿RvJÎ‹jÖ√oúô◊ﬁºf2RFtΩØÖ	{[OÓ÷b∫4òÇˇ?’¯‰fs^≈Y⁄Ÿ\0â©¡©¢Ω¿^˜ÓÌxÍ{˘ÜN¡0GuÛD/ÖS¢ ÒˇƒÅ¡≤˜ì;ÓÓ%¸mp2X[èj_aG∑Öπ–‚Övª@ﬁ2ë´b\\˛Ô\0ÊìÉÌ´ê~*J’jTŸ\Zw∑?/ôcÉgóã)e’Ô¨¯ˆZ~&¢qªŸN7”Û Z-ÌáÃ…ŒÖrı—$EÔ\Z3b\n¶ÓÊNyoHÎNÑmQ˚—va˝NÔ/	‰YÔ!v‚ë46]3∫]£Î3Ë<ßµù⁄óìÒµîÔ<á*=‹tÛÖ°¢pEëKL∂À»÷[úMrx%\0Ôb0qq¨ƒÇıÆ|xªÓíÔÒ:¨ê_≥òVÖ5:·UñëSÔo2“æPˇuâA_ï*}Î~ ÙÇ\'K9ˆ;Ùæˇ4ÔÅ÷pç´‰\n+=UØO™}›ÓÖ6‘ä|ºâË±}<yÔ≠º÷âKÓhxﬁ´(R·ÔÒ1 ı=~≈P‰wçƒÔ¬∫T°+∑Inˆô\r{∏„MÎô„˜_‡ªò`3xØÔ‰4áïLÍ#\\r∞º‘πF≈ \"ã$qœcÌ@\nÊˇÔ¯´CÒ‚KnAçÏO] ô`˛oß¶äCõ˝KÅ¶Ç≈.à˘ëU8uÖ±õiœƒËH<pSh€Zÿ∞/\r.ÇOÙ˚}9ûfPèkçù»o¯÷2,î=A}P®#\r5Ûk¥‡õ,P¨D∑+™>Jª‘5Îîß˘nÄŒ.\0UéRqœk\'Öæöû®i_i,Ö\n—GÀÙ+L.\rQä\0ÄΩ%∂\'ÛyÛmñ_ò‹#Í?⁄—E1\0´¬≤ ˜7ì•5mw>ZÕ˘ﬂ2Q2K=¨^NÉ‹‚q§ŸÛ§ÌQ\nÙISÑ}V#ÌN7=âÍ…∑ä5¯‘ûgDºÚ©>h]3⁄\nê0_¨—ç·Wgè¢1*•V¡¶êÂ¡FIP¥§†xØãfÏvLª@ËŸƒp‡¿Ó∆R;Kòÿ¯ —¿˙RÃÒ[:[ˇÊ*wø(Ê1Ä™ yŒjL3Àá∑dÑ\'≠˛V&}lõ≈]dOÏ—gÒ∆VßÊ:”Ÿ5≈ÀfHµ§A~l!ê/ª6‰y‘∂ûÓ!™π[^¶IŸ∑O3«≥Eÿ}{ò›Y∂z¨Ωåèçá#¶‚ÒÄ@⁄ˆXaÕ∞]Á‚()cˇkœ–!~sÛ~hÆÌÓ¢q0€¡ïX?8˘ÃÖôÉ‡Há€i,+x˙ºÕµåSEÂÆ9ær=ò#_~≠\\£/SÕªŸ(YC/#/‡ÄDÙ^>•6\\Ωæ„‚Vø6 EÈëi«*ŸX,§ê/≤6Òˇ⁄‡◊◊}%]·và	ßÇ\ZY˚´®·<û}]Ò8Êcõ‹4=}åXÌj(	;ﬂ›w„ÅgŒ÷∏,\\RÒÇ0©$k∆oàA≠Ö{ø∞∏Üˇ 2#Ïòam™à\'ôÒÉY#ŒÚOÆÁ(&\r\n0ÿ{z…„Äˆ«˚7πj«·ªÂÒ•R∫víïÇ^0“ı?¯2DhŸ4ÜSG∆8RHìe¸œÒ∏4⁄â3≈z\ZrÌK,ÓIﬁó≈Oe¿x®—üáÛi}ÑÛ.ÒÀkQæ_Í3´∞9ãy\n£b€-5c,RπñÒËç3£ß≈\'Ñr¥ò.]9cÀx∑™ﬂöY9Ì\\~œÛÚ¬ÿƒf÷ ∆«∂h˝j}uópIXÂp‚⁄æŒ©T≤ßÖÚ/”6ùFÄÉèkÕTÜEè;ÊH	#€ﬂõﬁˆàÕ{ÚC\'V€®/…ÈH_n{›‘FW‘Í?^’Æ¢VüÔã ÚN	±·ª-´≤≤jπõ«s\ZjhﬂΩC·»ô™I˘Î≤EÚRâò˙1¿„Gû≈∏ƒã±Óëd/8‘ÌìZ{{•Sí*QÚb‰ù¡Uãaˆ»–À9e◊ΩRß≤Xá?Ê•êà1±µÚih\ZŒ“ï¸ÉXºT˜9Ä•Ä€ÚEﬂé¢iö—Ü	Úv≤ïï&≤=GûüÈVükr2Œ◊C5∂≠∏œmÙ ~q~åÚâ±ÿ;rfX·Ö∏ΩìeX»t¢≈™.+[§µ£˚ÚéÂí©H{v˙ÃÚ./s|U»Z”»Aßh$DU≤s”ÀÚ≠Ê˙IÕ{\'\01¡„‚‹åò‰ár¯™ék¶äDﬂ‰Ú¬a≤c…ˆ¥ˆ#kÙQbm(ˆπ(∑†{ia^®\\vÏ∑JÚ÷M©îCÅ`QA6†_Õ~Çj”cà,1ÆÓåF\n)7‹Ú‰©æ!Ë@•òÎ	”nõà˜K^$€ÎNÄVj°˝ qÚÏ`JÖBZõﬁÖàJ¢åïX†0u¶9†>•!Æâv1íÛ†Ïv™ÍƒÖØ>°õ™–®Ó&€Dô6X]`Ô«=Ûs\0”Í1©y5z‘Â…4ŒO®¬ö|p¬A5¢PÌ€Û%Muå‘‰#ï®g±°]Æzm‹¶≥¯â8â÷Úu∏Û(fyèﬁ√2˝…–≠œ9º‡ex‹kz™B¸´4€Ú6ÛHy∑/=û›u4º_c¶µÖ	Œø\'éëÆM|4≥ÛgE;+\\π)H–qœ›{ù@√dX{a2’H¥=∑ƒÛÖGÕ»6Cm≠≈:Ó|ƒ“!%®‚Öp8«Ugøå´ÛíèÎ§AÁNà’y˙qo Ö#&]è#mV∞€ï∫r»πÛ¶¬‘L·=¶÷6mùzQh®¥ZàÍˆÚú‡Å¡— C”Û¨ µ® TØŒ±ààÂiïΩﬂ†Pom\\D5~‘!¿ÖÑ†ÛÆ≠Àﬁo¶Èa[ôce´Uı>T»ı›√∏∑~3ÖÎ$:Û–óÜ˘√˜e®Â„Wâ_6|óT-›>{‹rC\nÃ=±Û⁄k»≈RdåjÄ¶6øƒÙûT„œ¬Î¯Œ\'Ç≥¢Û‚¬œÔt∞‚Æ›a\'ÓX%=ÊBñ-›EpÖ~û\'ˇu)Û˘í3HŒ_cx¯≈N„û€pn¶¶x{VÖ´Ç@”Ùf!∑∑D.S∞∞J/ﬁxk˘nZ∂~q∆Í6LÍÇ®$‘ÙØà?{II%ı&úêÅV(AwÆÿ<‰©ªÑ ÍçcÙ$–aÇ=•∏ÆËµ!3CπPY¨‚°.c%«0b?OÙ)MÌü¥ô˚¯À[¬%>xdÎ]?ZäÒ¥ùû1ıÄºÙ5èŸŒqˆ)ïÅ9W/`ØÁkWËV*‡ç_i_\'h MaÙCQW‹~K€0±X~DŒ<˝§Õ>Ã5ÎO!	U\'£ÒÙIa”¥9+∂ÂçÌ6Ïß⁄fF…£7´r,¡ı?œÀOÙPì”\Z‚rü(gaÎûu;YàRá>Ë∫v\\Ÿ¬?sÎkÙ\\∏ ∏~–mÜî‡V˝‚|›ê•\0ôâ!‘ÙŸñX6±∂Ùa™võ/%1UˇEd†»_w\'±ﬁ¢ó∂◊KGs≥*<vÙu.òÄ˘ÏÍóS≤ÕA`\n§	tß˙ˇp\'ù‚\\Àë+&Ùë°*u4™µc	\Z{\ròçàÜˆ§ı@l(2œu•‹ÙÆ-V∞ˇíŒ‚JÀÄÖ¢zïÿß`*#ñ‰jÙØxZ∂…&Á\Zﬁ{C\rB∂]¢çﬁY·#<\0!_ÙºM~(â™•˙≠k‹‡_çMË÷Wº‘FÇiâ]»´”Ù¡Î∂ÂiÀçí°BŸ›l@ÜçjÎ!Î\0@Ç˛ŒãÙ≈≤é3˜¥á≤pv`Òr9HüÉ(∂cﬂWﬁèK\"Ö$Ù∆G‡êœ≠\'∑6‹Iù\"ÛV€…ú=´¬0π€˛µº≤Ò\ZÙ«Û◊h÷≠›Ü<e1L¢!”≥¯Ñ\Z™äD§KæóiÙÕ@*SåƒòRg‘…∫	rê∏Õzﬁ˜2,o€œQÆπÙœïŒFUˆÖÈltÄ∞*≥g™ßÎ–V‚ò≤√π«ÀÙ◊‘€¨É£Bj∆LNÉ˘hZÏÌe%ìD\'â«¸G}wÓÙÂEœk*	™œWÿåjª°|Åï¬K\'í†l◊»à<ÙÌ≤ä”«“ÍfdU»∆¨∂ÊÇ…»\\ÍØfH‹ÀÎˆ˜vÑıI¨Iö›wﬂd¶4\"∞ÈÜó—‡ﬁ“0_’ÎhÌ^1ı† -Âc÷j¶Htf›¨”?Û· D)ƒ\'∑÷hcF,ı4Ø|i”Ql∞pßÍt˜>Ò%y£®≤‰1P•bB¸ıRÇ˝¶ÅÙ[B}ñ\n[å⁄‹;	I2qËëU‘>Âın)ÕÑ∏∫Ix¥Ò¥VV$∫ÃZ=æîq≈UO˙ê‡cıÉÔÊ\n‘«Ã4ê\r\'Rü2‰8œF(>FÑ2 î›ıî¬\"Qj6øh≥Î\'ñVh¶≠~∆∆Adí∫Ä7‹ı¶DöcÄ…›Aâ\ZµHØzy›¿IìÌÓÍQËâ]ëoı“%<ª∞DN´Nã˜Mû^ÛÆ^∫æ/jC9Útbñ¶pˆ\r<Î!!déeüpı¬\Z¬ˆ	•0mzì√«òÈ%ˆÖËUâ^æ¨™ã9p›Ù&ŸÓÕ`ˆnM{¨ næLˆ\ZN˙äÒ:áJ0º≤L©2ùÊ˚\"L±Ì‚Øút¬ˆ%>úÅ:1∏èWôµRø⁄ÿäÕ©∞¬Q‘iÇÒ~’^Gˆ7p/Ë+\Z≠÷z∞Ç™⁄:MÙKÉûpßÉ‘o§*Aæˆvrí`G·ÃÉŒS˝Ä∞Ñ©¬$ ·¡2|Ç®>ÈıâYˆwM¸W[˛Î ¥ﬂIÀÓ/ØH-j\r%ËDí∞≥…àÄˆÉ+ØP4’g.Ω‡ûƒ{Œ· ˛^Wúƒ/![quèˆàÕT Æ&g…ñ–\r.Öƒ:ÿ)ßQŸ›7ã›£ ôhˆ≥\"büY(V›—WÀ|/5[˝r…∑*œ –Mñ⁄‘lˆ∫ør·˛n©∂zWÑ˙m:f¯O&y(ÎH‹¥„‘˘ˆª\n™#_FØD:±Æ’1I”}U\"\0HÿBü&`∆8˚Ämˆ»!U°c%rT†îÍ„.™çqÉxÜÎπû=\0ˆ⁄‘\"¯I‡8cÔ_›;¢k‡6Ω˘R§rãÁE?{d¬¬ˆ›G_ÕAîõÍ7©ºú√c0+õŸ^EŒÈh1Ó‰Ñ{ÎÛ˜9UÕ,∑éﬁ%k1Xù\r LcêNÔâ;Ω<KŒ˜{ñ*“˙kìL§ΩúÕ˝ñÏE,Õt*´J∏.	Ïó˜ºª*Ê≠Å\\5úµcù%™a˚§PüT¡õg≥x»ª˜=ó‹|@î ‘ÉƒŸ\\ØõHVq2™Œv5¬o´õ,ô\0˜7˚I—¥˘Eá≥£ô∆90.BAeµ4>è]y˛SÇPkô˜=¸9iŒfCu	l6EÄ#ÒZt,#<ã\ZL«4Zº¥˜FU™±øÅ!}\\÷äˇÙ_»ï´Œo¿/BÃ\\!˜Z<&¡^áS€‹ËéVƒ¿?Ω¿∫RÜ√ä•]ÄÇ	Ñ˜ﬁÕÆ6›ÿÙªRæä‘§zÜ§8ç\\4î˘wÊƒcã˜ﬂyéºÄ›sñò¯Mô)9@Ûä£Ó˛…ä2Óã–¡ÿ.¡˜ÍV¸/B∞Œc5aó∫\rRI†G>?£®Áy;Õ+ö˙â˜Ù\'˘SAE¶D>Ã”∆ﬁqqaÁ_ ÀÿàK)ÙA∫¯,7qâ¯>d\'˘ï∑â∫@≤@xƒ¬∞îEΩ]|¯/∫Û±YQÄ∞;•#Ê6Ãyc‰»å˙ ó…jˇﬂ»L¯2©À-[— 3ªÊ˝]S≥≥ù.Ô„\\˛ü0◊î£’¯B/\n…jìz\'aÁˇÙ∏∑ß¯Ω˜Ÿ’FêL\Z¯H-L	`$p1/>:ró˝ﬁV†«ô=={ÕOr¯R‹xg”J9G0>z◊c&ˆI√Üb4~®*L™Q¯Rkg!iÕÔf¶nb.*ÎÕŒ∑€ÿ¢$œgwÀ¯TŒ©#;?≤⁄`“?–…;\"åËA‰ˆY|ù˚óX;u¯aÙw?oaîÊÓbN$ç≤gIÃˆœÙı+«∑·R.¯eÓ\Z˙Ë‡¿ÙptÒµ÷·£à•…:\Z§`\'8¡y`¯ï•wâWˆ0„€»P∑™RÜ∆á≤Ó]±Pˆd´ﬁ$*H¯ù9\n?ög{—˜•gs˚	gO»‡XûIÿ#n¯§®!F#Y»ºv\"|È:‡›ØCG#\nYπE[ÇëVüwŒ¯πi¢%®-%F˛\0ÎÂ¿[ònÓ1Sêaé±”+“”‰]¯€B™E2ÿsñ≈é)ñ?‘üçÃB∞	Ó§*ËZúOˇ¯€ín+èz¸`ﬂó›◊]£^éÈë$ºdõgœ“Gfº¯Ám‰∞G8≤@~nÛÒ?‚	x∂ƒ*’ëxΩk˚˛Sã¯Îûµ9¿¶≤˙îU◊RÅ›º\"•EIº {Ü`zÂÎ$Ñ¯Ï®ÄqÌÊÎZ6h÷≤CæÜR=¶8H†âŒê‘…<¯ÌÕ>ÊyÍËyÂ=Ù˚ ÙÿÉïœGÚ’”©&òë¯Ó0˝‘*ó∑≤¸u„\0uç\rôÊ+M\nM∆ø”4Ä¯f˘_ûMGÖ‡Ê%2qπÂæ0Ë/“ì:;ÂÖÍe‰W§Gí˘ à›P‰ƒ,‘ˆK¥îA]H‘˙Î%ÈÛ˚Ì¶AıÊQ˘<Øò£ì!B¨|$k®Æº›à†# åe¨i%0˘DÊ¥€ûVËöπxRBBy%ƒh—Wv≥Œ«∂mÿ}n˘G>p˚„—π˙·W˛ÉÁ√È5öwıôƒOŒEÕÃæ∂m˘Güî. ’ÉªgÇ˘?¬É–r∞–¢js$_îD&÷óª˘H´≤·ù≠s%‚˙∆v¸x-‚ËÓ#ıøºÅ?	‰Í˘T•π¥5·´)ﬂ¯\\Npö±∏¡Ë[ä·>ª‰&¨˘]åë‚à˜:ˇú¯.ª—•◊áÑ¢Ã4ˆöûUãé⁄˘hnl±ê√h¿» ´ÕjF¨**\ZåµÛWÓnfrP#3 ˘w÷¢$ÿÈè’Ì°¬°Ê°ò3˛º≠D«\\»[¢I£Ä˘óówDç=O$l\Z›ûÔÂIù‚9<ÄÁ0oxÈº>˘≠L1†Ã\Z?ñØÍ˜fË]≈˚–t2–àòËÚ5˚≤˙˘≥IòvÀ®C¿(™ﬂ±wziõ•C\038ß\'UàìÈ˘µ$ˆS™¢(‘]4‚P∂”ïøæcU‹v≈·¢≠ó(Øc˘ÕÑ…Ø˝TŒΩ⁄ê$_˝É‚ıÆ•S¯ÍÒâ©ÒÅ–äﬁ|˘–|ÖÂŸn”„Dìù~Ωñv-≥;&àπ„WÓ≤ö•0˘·;‰È7À\"ëL~ﬁÖªLE∫`!‡)lÃ õ˝hL˘ÎOÿ/Ã©3çΩz4èŒö˚C:Ufz^^GnÁı¥„˘Ïç/∑pR1ëC˙Ã¨20∞2ÄJΩŒç<±ë:∑_˘ÌB!s*˛π√l™∞ˆ6«’ÿ\"Q_˝»π©2Æ∂öa7˘Ó<\\U}œ\"A®¥≤s‹¬?ó‹C9áª“Ò`¬r´»˘0√ââœ√ÓÚ\0Ëÿ1º÷y£i˙N7,N]‹8‰˘˚œ™æé¸òÃƒÕ‹Cë,01õSÕ≠Á-ÄaúΩb˘¸™pYÌx{VcﬁˇoÄ¯lNG¢qlkbá°˘Ò·¶a˙Ú√±‘üáyb–÷@ÀY”‰‘(J5}◊∏dìt`Mu˙ºÃ∆ÇÄUz[Á∫w\\= º\0[\nKçixµ-b>¥≈˙,E˝dΩ“î‡\nNﬂ-éÎÓ\0¥9çpM0+±Ω~0ü˙:6r¬Ωc…œ	Ö‚h{ÄM\\Û∂“À–J¨ö,∫k\r?˙˙O\Z/ﬁÜfÖΩ‡?Ωx»É9∫˙\rQP@\rÔÃ\Zæ·¡˚˙S“zÛΩ¨\n≥¿E¥Oåìµ«wF.P˘Í)n>≥˘<Òœ˙W®ŒS)øá–_◊]µÊÍ√Yˇaä\'kYπ≠Ÿˇ›˙_otÎr„£)Õ÷CßìπŸEÆI«m/Ω;◊Ô‡Îg˙gº≈≠éã∆±“‡0`¸Æ£8^˘˘Ï\\Ç¶∆ã˝~ñ†˙~íJ±Ã7$kSsYme(∞|£Ç.∏ê≈πzZ‡≈[˙¢∏™Î™æl∞cÈÏùãÖèäq⁄o◊ü°ù∏K»÷õ+˙∞∫%ÌÿÇ√!aŒ29\n‹„»ˇΩ`®F_hî†*äy˙∫.∂Z±€≠PÓ0∑®\"ÄíjÖ≈Œß=xat\\K˙◊hì£·9¶ı¿‰w«è–ƒÌºê;Z)ı¬ÓK˛~ﬁ˙ﬂQÇ[::›¸¥jûsêﬁÿ^Z@2n‚Ï≥ve)e_˙‰uÓÇÈÓ!≈9Ω]¥we<ªπáŒÅπiJkNê˙ÍuM¸ÛŸçããO„I0x{MyùR\r¥~ªÆS≤Ó˙ÌµBSTÖ™Ω†h¬Zs©*Ü˜≤è[?	PO¥ìv˙ÛD≈åi*Ôéb˜’⁄*°;ÿ©Dì⁄®≤nÛ/N‡ú˙ÛI¯®}7+∆ï§A˜‹‡lÊ¨øB˜ıt€\'s˜t˙˙Çæsh´wÌ•‰k1]ˇ\':Ú&eøtê§bØtÒÓ˙ˇ*Œ\n\'ºZ%±¿$^ŸÚÙ*πB•¸R_~Ò;AäïÚ˙ˇk8´⁄ÊÛ\\=Ü>Jıπ∫ƒ1Ì¿~(ãÊÈAcÔq˚o%TF˛O-¡Gz¬JTN>⁄\'øŸÒ˝ÇîÁò#.˚D•=±Ù¯“Ÿaﬁ:Ùﬂ\'jïK˘‰ WHSí™‹˚`\r»y~E‰~|à\nRÀi)flóÈ•îe}„)ld˚*Ù√ÄIÒF™^Çê»Øó‹íÏâÂW¯íÈ@û~Ω›ò«˚T `»l©Ï¿ ﬁ9æòÁù™Pﬁk÷KV“‚d™›*„˚X\0MáoÔïDO=hŸWπ˚\0 ·7$˜›ÍóÙR∏T˚b˝∏z˙Hp¿f¿ú?˜@—ò›≤‡I†˘∂æäG±]˚q”M;å’>l\nAÅÌµé>ÂŒkòh«ÿ›R∫∆Ò8˚yO¨ätÔldÙU–˝^¡≠E°%Oànﬁπ¡~}˚©êJ[™An>ö„¢»P:≤õÈ√∆7‡Ó´4iwåùÓ˚≠ŸqèÔcÁsœ @Ä\"/‰Ÿ¡≈°|sP|0õë√¥˛˚∞ä!ßJ…»[h7eì^ÔJûèT´uµV∞î⁄ÖÚ6˚µªbJÒ≥ıRÍ©#åˇ‘≤ãYu¢nÈnOñú˚˚πøé#£\r–F1_“¢\'ûSzß<¬J8´@›b˚‰cÅ\nizΩN£y◊äÏÙ¥}Àú.‹˛ÏÆ\Zª^°≠ö˚Ò*èÃ∂=∑≤ Ÿñá.ı)~ Ò	Ã_OP¸\n¯x+è©U«◊1ÔõwÎÓÄzú)≠\"4Ñ+‹B\\¸¨íIIˇ%∏%Ë\"–ñXüú¢Â~X4;;›]*≈	¸&∆ÙπÙ\"T—˛QWvRi∫≤d˙3ím˛`a≈¯3\r¸45q$®&Œí9QO*zΩkBÖéÄΩµû˛jdE,¸TgãOrP~¯tgn©gö…Ì(∏W¶{v®Í—Õ^Ù¸Z¨Ë}»êC6›û˜´+ë?ã€∏Z¯PÀd?P¸\\ƒ“˘ËÉkO◊˝√¯}H¶\"FÔ+:ÃµLZíKA¸ry¸‰9H¯$≈ƒ™ÏÃﬂ50K5:\'Úƒä∆$Ù‹‘∫üö¸x°ã«¬rº^/˚£ \'Dá~Ïï4ËdÙÕ¬`8`q¸è◊Üd≈™C*Ük]¨0…æ\"Ä‡˛‚Õ∂#8KÂÆƒ¸ßr◊¿íÿ|\ZÈ„Çê5¨b·äT2ºÆÀph=¥±ﬂ¸¨Æóßjé#œjRÖÖœ’	™è®⁄|áz¬˛¸03≈¸æ‹∏OV1®SlfwVÁ¶Œ1	¸ÿl?Œï.\rï¸∆®ê;pê∏è-‰§e*Ó“—`ûà [Ìßp5Uˇ¸ÿÕ≥ß–·¶{ú£·n•ø¬!z[€>µf∏t4âè¸Ó˜s^¶tE+WÍLÍ’ØâËˇ¶CéÍ¯“©œáH˝hüZ;P·».§ÁÛÀs.∏ù1∫õq˛+‹ã\rí4 ˝$PdµuU1π»Ù◊8õó<Kn‚s°µ¿pçGR˜b˝:L¿√0Ò˜¨j}ºyïÏäüWƒø«Sh°5GH˝;€VÉ≠(¸ (∆\ZB\0à\rÀl≈óô‡¬B‰s∞#3˝?+ÊÍáWp‚§PæMÁk]º<px_¡\"R›Lki†òG˝Apì\Z\\Ω¢·è?hçÁ8∞™ÛÄQã»$ñd1˙ÏÀå˝GPP˘(‘œû¡”ÓSÀ·3Q˝?(H|,¯;päÒ˝H@y∆Ñøùk}Ã{åØ[´«W{åLGÕ.·vO«´û\"˝M\r6Icƒ˜Ω˝ÅÚEë´,M+,¢«ñ∏Âfäû ˝MPÊÜ[∞Y&Â®œ\räØ,∑°ÎYDxŒ¬xÊ©˜˝Vﬁåò\Z≠“~¥VDÈŸ…Z6ﬂaW ¿_‡˜¢t ©k˝gÏi\n¡B±_»Í[ï\0ã›7¢Ÿ4Úw5◊ÿÃq·ÎÇ˝y∞ü‰⁄1±–©3´&≥Tt›»π£Í8ÅÄ=‚ÀS˝P∂yÛYmÌÌ´à˚m∂ÊΩUÌI∂ÊœO¿F	!ï˘˝éÓõq¿¨OÁ§~√æ`è∑œ∑7ìi.K˛‹ÍKù¥Ï˝úù˛;å¢3@¢Ü\"é¡_“ìÅd™/5øÅ˝üè‡%É¥€Ë9îU6>˜ÅNc∞VäM∞Tp˜W \r0•˝§‰ÁÅZ|õ\\éTâ-á±B˝D\"–,Q√u‹≥¡˜n°˝Øè¶.òê«ÌÒ⁄A\Z› X¶m,¨ÈP\rÎóJ∑h‹˝„x≈Q#íõ\0¬Åâ¿tg˚§Ú°F™¡ŒN°ıﬂv˝Û&õW\"¸ƒ≤ê}:ÄÆÒk’S‡˜-e&sÒcÙ˛1hÈÿó]m3ƒ∫Xq∞√è˜Ïj¬_ﬁyÆ[+xÚEË˛«V0zŸÍ¡xiù«˛\nÃÌ≤€Fû\nÀË∑˛7ë€4∆Ê¨ã\\Û†MË=Ñ∞ÊOÇ°ùñh≥ø£ôí˛=ÿÌln&Œ—¯æÑÁƒÉÊJ«”óµâ£~ƒƒﬁ˜ÖÈl˛L;ï-∫ŒF“ƒ\0”ŸU±É*/∑ó÷÷d„.>z_€˛ME»M’è-/vƒÁ_⁄Öcíú‚ØÈ?,U&¸ﬂ\"ñãR˛[‡òºR·±∆ÿ·|LÏıåïß<uQRîV≥§†∏x˛s†è	b[–y¶iœC‡‚®ı\0ˆ‚Ù„T˛q@W~á˛{ô·πúgÒIU9ˇ\0Å≈ÿ⁄°SwÌqí\\(LpR^˛ù_mÀo≤<e«Á{ÑFE≤P\n-¿·ﬁ,5H˛º:§ú@æÊ∆\r‡%∑≠-ÉôΩΩ‡,$y∑√kË˛ø\\˝3ÜÎî¢ﬂì{ΩB2óA·ôÍ÷GŸ<äê&%˛¡˘ﬂºw$û¶ôcéTV¬∂\râ|f¯7hC¡p\Z–˛›8öwÅG˛+âdUx—’Xcà—®VÚ*ø6ÿi(Œ˛ÂH÷XwŸ6[Ú˛|˝JaŸÕ¥Á–ñ“q^¸•˛ÏOûh;xAÙ3◊˜-\r¨ËùhMú>kv7•≈[˛Úûﬁ◊ád£ÃÇzR<Øø2ıÍËKàÆ”ÿ√7âIì˛˝I∆!1&ôj∂á[6õºàö56iπ8Áõnût˛˝lô*ˇ«Ò?∑àÚΩ/]¿\Z¯4Ì®πtXÍ*˝πÚ5Æˇ2Û.p≤¬∑–\"ÑFú6Zÿô\nπ›$zå˜z∏§\rˇ9`\\&S9‚~{-LK≈ùI€TñiÿÔ;ïu!Æˆˇ7Ùˇ±òUÕe∞H> -Ùù‰%G†µ(åmŒ\0ò˘ˇDO;Üô^ÒK‘‰èlµøΩÄÿ∏!‡/?aF”zÏÚ#ˇU≥%fˆÓ≠{¯xÛ iå<ÁπfØú;ØòµñöâKˇZ9ﬁ∞N˙›Wj_âHÒ¨]œÕöVîI˘R[ÎÉõ÷Bˇwös∞–bN}ºqYÖ«˝7zoïUÊ™uÙ\'°•÷1ˇêkØÆí~P,o¸®¡ Ç-~¶B æÀi>1π/#ˇ¥ﬁ#ˆ€yöãX‘oa™Ö\\DÅ≈ûheb§âıˇ¬‡hÉÊ?)ó3éª1‡uÛü°sòﬁ_sÒ≥¢–®dˇƒ>V†*Ràü/\0òàÚ€„”∑Ô~r∆%ç\"“ ÊûÚˇ≈Ú8lbÿŒ∫ˇß\"û7eéEå=n~€—Õô\'2’C/ˇÀ‚˙∂è∏rÕ\r«ÃàŸ\rã;—J¨UåÀë-Û\\Bˇ÷?ªõ	CøQñæ€c2 GÉÇî‚ìΩeÂﬁh£‰hÔëˇ⁄›å^›@ÛÀ∂\\},n—‹ø€õ~AÎF◊,Ïˇ‚\"¯«¢Ï@¨\nüpy4&æ7Ç:òwOñh4j˘y®Dÿˇ˝{≈<nó–ΩØ>!ƒÌ2˙§_U÷d~†ﬁpÿÁ≤7O\";}ÖTÄ\'\0','no'),
('currentCronKey','','yes'),
('dashboardData','a:4:{s:9:\"generated\";i:1688174798;s:3:\"tdf\";a:3:{s:9:\"community\";i:5539;s:7:\"premium\";i:5613;s:9:\"blacklist\";i:8989;}s:10:\"attackdata\";a:3:{s:3:\"24h\";a:24:{i:0;a:2:{s:1:\"t\";i:1688086800;s:1:\"c\";i:17482950;}i:1;a:2:{s:1:\"t\";i:1688090400;s:1:\"c\";i:18419748;}i:2;a:2:{s:1:\"t\";i:1688094000;s:1:\"c\";i:17533492;}i:3;a:2:{s:1:\"t\";i:1688097600;s:1:\"c\";i:19101390;}i:4;a:2:{s:1:\"t\";i:1688101200;s:1:\"c\";i:19346438;}i:5;a:2:{s:1:\"t\";i:1688104800;s:1:\"c\";i:19955327;}i:6;a:2:{s:1:\"t\";i:1688108400;s:1:\"c\";i:18440847;}i:7;a:2:{s:1:\"t\";i:1688112000;s:1:\"c\";i:16031847;}i:8;a:2:{s:1:\"t\";i:1688115600;s:1:\"c\";i:15189348;}i:9;a:2:{s:1:\"t\";i:1688119200;s:1:\"c\";i:14041209;}i:10;a:2:{s:1:\"t\";i:1688122800;s:1:\"c\";i:13212665;}i:11;a:2:{s:1:\"t\";i:1688126400;s:1:\"c\";i:12041776;}i:12;a:2:{s:1:\"t\";i:1688130000;s:1:\"c\";i:10788537;}i:13;a:2:{s:1:\"t\";i:1688133600;s:1:\"c\";i:8420160;}i:14;a:2:{s:1:\"t\";i:1688137200;s:1:\"c\";i:8011599;}i:15;a:2:{s:1:\"t\";i:1688140800;s:1:\"c\";i:9870630;}i:16;a:2:{s:1:\"t\";i:1688144400;s:1:\"c\";i:10503474;}i:17;a:2:{s:1:\"t\";i:1688148000;s:1:\"c\";i:8632394;}i:18;a:2:{s:1:\"t\";i:1688151600;s:1:\"c\";i:8550903;}i:19;a:2:{s:1:\"t\";i:1688155200;s:1:\"c\";i:8268782;}i:20;a:2:{s:1:\"t\";i:1688158800;s:1:\"c\";i:8806185;}i:21;a:2:{s:1:\"t\";i:1688162400;s:1:\"c\";i:8773909;}i:22;a:2:{s:1:\"t\";i:1688166000;s:1:\"c\";i:8222172;}i:23;a:2:{s:1:\"t\";i:1688169600;s:1:\"c\";i:7905220;}}s:2:\"7d\";a:7:{i:0;a:2:{s:1:\"t\";i:1687564800;s:1:\"c\";i:272208970;}i:1;a:2:{s:1:\"t\";i:1687651200;s:1:\"c\";i:331304146;}i:2;a:2:{s:1:\"t\";i:1687737600;s:1:\"c\";i:351138838;}i:3;a:2:{s:1:\"t\";i:1687824000;s:1:\"c\";i:332526105;}i:4;a:2:{s:1:\"t\";i:1687910400;s:1:\"c\";i:267292108;}i:5;a:2:{s:1:\"t\";i:1687996800;s:1:\"c\";i:312782139;}i:6;a:2:{s:1:\"t\";i:1688083200;s:1:\"c\";i:309885392;}}s:3:\"30d\";a:30:{i:0;a:2:{s:1:\"t\";i:1685577600;s:1:\"c\";i:306493401;}i:1;a:2:{s:1:\"t\";i:1685664000;s:1:\"c\";i:281391234;}i:2;a:2:{s:1:\"t\";i:1685750400;s:1:\"c\";i:273177599;}i:3;a:2:{s:1:\"t\";i:1685836800;s:1:\"c\";i:341335984;}i:4;a:2:{s:1:\"t\";i:1685923200;s:1:\"c\";i:274155396;}i:5;a:2:{s:1:\"t\";i:1686009600;s:1:\"c\";i:318953163;}i:6;a:2:{s:1:\"t\";i:1686096000;s:1:\"c\";i:307601947;}i:7;a:2:{s:1:\"t\";i:1686182400;s:1:\"c\";i:99443176;}i:8;a:2:{s:1:\"t\";i:1686268800;s:1:\"c\";i:380286513;}i:9;a:2:{s:1:\"t\";i:1686355200;s:1:\"c\";i:183176596;}i:10;a:2:{s:1:\"t\";i:1686441600;s:1:\"c\";i:269984149;}i:11;a:2:{s:1:\"t\";i:1686528000;s:1:\"c\";i:106311647;}i:12;a:2:{s:1:\"t\";i:1686614400;s:1:\"c\";i:111850787;}i:13;a:2:{s:1:\"t\";i:1686700800;s:1:\"c\";i:124047005;}i:14;a:2:{s:1:\"t\";i:1686787200;s:1:\"c\";i:110134235;}i:15;a:2:{s:1:\"t\";i:1686873600;s:1:\"c\";i:344657184;}i:16;a:2:{s:1:\"t\";i:1686960000;s:1:\"c\";i:332391569;}i:17;a:2:{s:1:\"t\";i:1687046400;s:1:\"c\";i:402565203;}i:18;a:2:{s:1:\"t\";i:1687132800;s:1:\"c\";i:276970588;}i:19;a:2:{s:1:\"t\";i:1687219200;s:1:\"c\";i:322393296;}i:20;a:2:{s:1:\"t\";i:1687305600;s:1:\"c\";i:267799282;}i:21;a:2:{s:1:\"t\";i:1687392000;s:1:\"c\";i:317718916;}i:22;a:2:{s:1:\"t\";i:1687478400;s:1:\"c\";i:291187722;}i:23;a:2:{s:1:\"t\";i:1687564800;s:1:\"c\";i:272208970;}i:24;a:2:{s:1:\"t\";i:1687651200;s:1:\"c\";i:331304146;}i:25;a:2:{s:1:\"t\";i:1687737600;s:1:\"c\";i:351138838;}i:26;a:2:{s:1:\"t\";i:1687824000;s:1:\"c\";i:332526105;}i:27;a:2:{s:1:\"t\";i:1687910400;s:1:\"c\";i:267292108;}i:28;a:2:{s:1:\"t\";i:1687996800;s:1:\"c\";i:312782139;}i:29;a:2:{s:1:\"t\";i:1688083200;s:1:\"c\";i:309885392;}}}s:9:\"countries\";a:1:{s:2:\"7d\";a:10:{i:0;a:2:{s:2:\"cd\";s:2:\"US\";s:2:\"ct\";i:883769996;}i:1;a:2:{s:2:\"cd\";s:2:\"SG\";s:2:\"ct\";i:242225949;}i:2;a:2:{s:2:\"cd\";s:2:\"DE\";s:2:\"ct\";i:193633310;}i:3;a:2:{s:2:\"cd\";s:2:\"FR\";s:2:\"ct\";i:150944856;}i:4;a:2:{s:2:\"cd\";s:2:\"IN\";s:2:\"ct\";i:121191262;}i:5;a:2:{s:2:\"cd\";s:2:\"CN\";s:2:\"ct\";i:92279494;}i:6;a:2:{s:2:\"cd\";s:2:\"NL\";s:2:\"ct\";i:89035341;}i:7;a:2:{s:2:\"cd\";s:2:\"GB\";s:2:\"ct\";i:74214571;}i:8;a:2:{s:2:\"cd\";s:2:\"VN\";s:2:\"ct\";i:72531502;}i:9;a:2:{s:2:\"cd\";s:2:\"RU\";s:2:\"ct\";i:61408808;}}}}','yes'),
('debugOn','0','yes'),
('deleteTablesOnDeact','','yes'),
('detectProxyNextCheck','1688780328','no'),
('detectProxyNonce','efdc87c9a02ef16d633d7c9a3f41a774f8a43fa048f65325c30a2fb3fa64ade3','no'),
('detectProxyRecommendation','','no'),
('diagnosticsWflogsRemovalHistory','[]','no'),
('disableCodeExecutionUploads','1','yes'),
('disableCodeExecutionUploadsPHP7Migrated','1','yes'),
('disableConfigCaching','0','yes'),
('disableWAFIPBlocking','0','yes'),
('disclosureStates','a:50:{s:22:\"global-options-license\";b:1;s:33:\"global-options-view-customization\";b:1;s:22:\"global-options-general\";b:1;s:24:\"global-options-dashboard\";b:1;s:20:\"global-options-alert\";b:1;s:28:\"global-options-email-summary\";b:1;s:20:\"waf-options-advanced\";b:1;s:22:\"waf-options-bruteforce\";b:1;s:26:\"wf-scanner-options-general\";b:1;s:30:\"wf-scanner-options-performance\";b:1;s:25:\"wf-scanner-options-custom\";b:1;s:33:\"wf-unified-global-options-license\";b:1;s:44:\"wf-unified-global-options-view-customization\";b:1;s:33:\"wf-unified-global-options-general\";b:1;s:35:\"wf-unified-global-options-dashboard\";b:1;s:31:\"wf-unified-global-options-alert\";b:1;s:39:\"wf-unified-global-options-email-summary\";b:1;s:28:\"wf-unified-waf-options-basic\";b:1;s:31:\"wf-unified-waf-options-advanced\";b:1;s:33:\"wf-unified-waf-options-bruteforce\";b:1;s:35:\"wf-unified-blocking-options-country\";b:1;s:35:\"wf-unified-scanner-options-schedule\";b:1;s:32:\"wf-unified-scanner-options-basic\";b:1;s:34:\"wf-unified-scanner-options-general\";b:1;s:38:\"wf-unified-scanner-options-performance\";b:1;s:33:\"wf-unified-scanner-options-custom\";b:1;s:31:\"wf-unified-live-traffic-options\";b:1;s:30:\"wf-diagnostics-wordfencestatus\";b:1;s:25:\"wf-diagnostics-filesystem\";b:1;s:30:\"wf-diagnostics-wordfenceconfig\";b:1;s:32:\"wf-diagnostics-wordfencefirewall\";b:1;s:20:\"wf-diagnostics-mysql\";b:1;s:29:\"wf-diagnostics-phpenvironment\";b:1;s:27:\"wf-diagnostics-connectivity\";b:1;s:19:\"wf-diagnostics-time\";b:1;s:24:\"wf-diagnostics-client-ip\";b:1;s:34:\"wf-diagnostics-wordpress-constants\";b:1;s:32:\"wf-diagnostics-wordpress-plugins\";b:1;s:35:\"wf-diagnostics-mu-wordpress-plugins\";b:1;s:39:\"wf-diagnostics-dropin-wordpress-plugins\";b:1;s:31:\"wf-diagnostics-wordpress-themes\";b:1;s:34:\"wf-diagnostics-wordpress-cron-jobs\";b:1;s:30:\"wf-diagnostics-database-tables\";b:1;s:24:\"wf-diagnostics-log-files\";b:1;s:26:\"wf-diagnostics-other-tests\";b:1;s:32:\"wf-diagnostics-debugging-options\";b:1;s:35:\"wf-unified-waf-options-ratelimiting\";b:1;s:34:\"wf-unified-waf-options-whitelisted\";b:1;s:22:\"wf-unified-2fa-options\";b:1;s:20:\"wf-scan-activity-log\";b:1;}','yes'),
('dismissAutoPrependNotice','0','yes'),
('displayAutomaticBlocks','1','yes'),
('displayTopLevelBlocking','1','yes'),
('displayTopLevelLiveTraffic','1','yes'),
('displayTopLevelOptions','1','yes'),
('emailedIssuesList','a:1:{i:0;a:2:{s:7:\"ignoreC\";s:32:\"6df5d32dab8471256bb53ca3f3b5c843\";s:7:\"ignoreP\";s:32:\"181447348de2f66f53c1a116c0aa1265\";}}','yes'),
('email_summary_dashboard_widget_enabled','1','yes'),
('email_summary_enabled','1','yes'),
('email_summary_excluded_directories','wp-content/cache\nwp-content/wflogs\nwp-content/updraft\nwp-content/litespeed','yes'),
('email_summary_interval','monthly','yes'),
('enableRemoteIpLookup','1','yes'),
('encKey','9b10826f745f5464','yes'),
('fileContentsGSB6315Migration','1','yes'),
('firewallEnabled','1','yes'),
('hasKeyConflict','0','yes'),
('howGetIPs','','yes'),
('howGetIPs_trusted_proxies','','yes'),
('isPaid','','yes'),
('keyType','free','yes'),
('lastAdminLogin','a:6:{s:6:\"userID\";i:2;s:8:\"username\";s:9:\"aparserok\";s:9:\"firstName\";s:0:\"\";s:8:\"lastName\";s:0:\"\";s:4:\"time\";s:25:\"Sat 1st July @ 04:33:56AM\";s:2:\"IP\";s:9:\"127.0.0.1\";}','yes'),
('lastBlockAggregation','1688175525','yes'),
('lastDashboardCheck','1688175274','yes'),
('lastEmailHash','1688176128:cf7136ac0c01f7291873f96ea85f4f4d','yes'),
('lastNotificationID','5','no'),
('lastPermissionsTemplateCheck','1688175219','yes'),
('lastScanCompleted','The scan time limit of 3 hours has been exceeded and the scan will be terminated. This limit can be customized on the options page. <a href=\"https://www.wordfence.com/help/?query=scan-time-limit\" target=\"_blank\" rel=\"noopener noreferrer\">Get More Information<span class=\"screen-reader-text\"> (opens in new tab)</span></a>','yes'),
('lastScanFailureType','','yes'),
('liveActivityPauseEnabled','1','yes'),
('liveTrafficEnabled','0','yes'),
('liveTraf_displayExpandedRecords','0','no'),
('liveTraf_ignoreIPs','','yes'),
('liveTraf_ignorePublishers','1','yes'),
('liveTraf_ignoreUA','','yes'),
('liveTraf_ignoreUsers','','yes'),
('liveTraf_maxAge','30','yes'),
('liveTraf_maxRows','2000','yes'),
('loginSecurityEnabled','1','yes'),
('loginSec_blockAdminReg','1','yes'),
('loginSec_breachPasswds','admins','yes'),
('loginSec_breachPasswds_enabled','1','yes'),
('loginSec_countFailMins','240','yes'),
('loginSec_disableApplicationPasswords','1','yes'),
('loginSec_disableAuthorScan','1','yes'),
('loginSec_disableOEmbedAuthor','0','yes'),
('loginSec_enableSeparateTwoFactor','','yes'),
('loginSec_lockInvalidUsers','0','yes'),
('loginSec_lockoutMins','240','yes'),
('loginSec_maskLoginErrors','1','yes'),
('loginSec_maxFailures','20','yes'),
('loginSec_maxForgotPasswd','20','yes'),
('loginSec_requireAdminTwoFactor','0','yes'),
('loginSec_strongPasswds','pubs','yes'),
('loginSec_strongPasswds_enabled','1','yes'),
('loginSec_userBlacklist','','yes'),
('longEncKey','3c25f529984a2a9ad85e1fb6535376535c69618832fe137382aae7c4d45590c8','yes'),
('lowResourceScansEnabled','1','yes'),
('lowResourceScanWaitStep','','yes'),
('malwarePrefixes','ã\0\0\0\0\0\0\n÷y8Ô\0ŸóªŒù;ÀΩsIYJÖäBR$RI%QäDŸZHJ!I+ÖJî§Hëäî¥i!*)•EE+“&~ﬂﬂüÁúyûyﬂÁù3ÁÃ3>„«åè\no>^◊ﬂ\'Ã_wBÿx≥1„uOø\Zﬁˇ ’%Ôe\r…?ECÀƒ)•≥éMæ>Ì≤Õ8)˚ˇ}ñ„u◊Ñ˙-XÔˆˇÀ1ffñÊˇm\0ñÈ\0¯˝\0›r‡a?\0xG7\0?€†)˚Ù`ëù\0ˆ4¿÷D¬K@‹bHΩ\0YÆ+ gZ\0πp\ZêœÍ®õã\0Íﬂ@1∂PtÑÙ°Ä180Â\0˚v6¿Ÿ». ‡);Ä˜æß¥’º\Z@Uó	®”{\0ué†æ\'‘œÓ¬Ã@p_çˆÄFª–\\q4∑∆\0Z.=Ä÷¬_Äˆ\r0h≤ÍÌËåÔt&’:AãÄ!∑Ì\0]˝ﬂÄÓ§\n@7Ë\0†˚b?†gêË]¨ñŸ€;Äa‹l`ÿ,[¿0Ï`∏Ì`x˝,0¸`00ºØaåòÒÏ$`dΩ0ZßU\\\0å>ÕåK>∆Ô&∂)Ä…Ê/¿®S5¿ËΩ)Ä;0ùÛ≠Är∞ÿ=	õª7Î?Ó±¿∏Î≠¿∏∫`\\C`9ﬁ∞*XX’êÄ’Ôd`¸…~`Ç6LàXK˛÷ó_÷Wñ6$`€˜∞ª∏òt¶òt/ò<$pê8∑7éO”\0ß¸`öm0mù‡Ç.V!¿Ù›˝ÄkH,‡\Z˝òﬁÃHfú~Ãx8ò9Ωòï¸òu˙‡6~‡ñÖ≥éÓ´\\˜üπ¿\\ß`Ó√w¿<«:`^s0ü≥\0,?\0,H{\r,8„,(N\0\\Y\0,¯ûx,˛x‰¶\0ûcO´”Ägˆ#`°Ω-∞–u‡•≠xxõsÄ∑/‡]ò\0,π%|àÎÄ„¯lº¯™0¿˜,ı‘ñY∑À÷˛g◊8`Ÿ◊¿≤—ÄüÏ‡Áû¯]Ù¸ÍCÅÂ\'v\0˛k‹Ä\0…& `O,ê:	X©ò&\"@`ÁH h˙4 8Z«¡‹Å’‡s`ıﬁI¿\Z0X”∫ŸõÑA@XPvπ/6\"∞J bÈ\Z \"k\0XßØ÷ı:Î˝Ô\0∂ÜëóQ ÚU5dïùDG]\06=]lnç∂XÜ[V¡@¨.ƒE±ˇΩªÿ$àΩ∑ÿ˙Û∞ıè.∞-©ÿ∂Ô,∞Ì˘; ~Œj >ÈüNÒuÁÅÑµ˘@Bé#ê8∫H‹7H|;ÿÅ.vÑ¨íú+Ä$ó iá?∞s‰ π+\nÿı 	ÿç,v4{êó¿f7∞gÎo`Ôß˚¿>Ÿw`ﬂ»^`_ÔN`≠êR<Ê)AÅ‘=…¿Åq¿ÅóR M˜6êf0\nHó/\02∆KÄg; √c\"ê9P≤0%kÄ√”¢ÄÏ·ô@∂ﬂD gﬂ= Áû3pdQ!p¥˝4p¨Y‰÷‹Ú¿Ì@ﬁzs Ô£ê◊ÁúpÕN\Z˛\nåÛÅÇt_‡T£p™[B±@°ÒI†p˛m†·\Z†∞=(Ïûúnªú1\ZúY\Z{¨äó{%\'FÁ|¶\0Á*^•&ù¿˘ôï¿Ö)⁄¿ÖÌâ@ô¸(õ2(OR£≥ÄÀß™ÄÀw&WﬁÊ\0ïì`†“m=Pπ2®’@ıÙk@ıF†:ÒP}Æ’|Æ◊Ÿ7:ÜµÜ£Ä⁄S˜Ä⁄€ÁÄ[9Z¿]∏r®”ô\0‘5G˜f6\0˜|Â¿}E$pﬂ@øxêxx8˚2ƒ/†¡4h∏txtˆ–8S4°œÄ«c√Ä«Q¿„GÓ¿üß¿≥Õ^@À≈6‡yÏ ‡<xajºÿ˚\rxi9x9Y	º‹^º¨è^K⁄ñ∫mÈb‡µ∑=:$xù1x;rˆ≤)–Æc¥Ø\rºü–	|hK:ùÃÅO|ÄœªuÅ/∂≥Äoã¢ÅÔÁß]Àˆ›¿#†[œ˝?Ò@˜¬@†˚à–„=èÌÅ\røÅ_Ö«æ¯õU¸˝∂Ëª˜¯7c\"oN)0†ÇKÄ‡µK 4MÑÚ?Ä–ß˚ |Ñcº@ƒ∫Dˆ∫Çhº-à/1\'ƒ˛Œq¨ƒùÜÅx‘êx6$/ÕE÷.†»Î8(Z;]äÀ¢@Òî@k@…$P2ŸîÜﬂ•[ﬂÄ2ªhPˆu:H•DÉT˚3ê¶À@fø\'»{≤Õ˘ G§Ç‹∫P•â\0U˚AUR\0®÷Í’üÄÍãÈ†˙ﬁ~P-ÖE©†∞n8®ôUjÈ•ÅZ√ÉZÛ|A≠∆M†∂~!®ÌUj?˘j?{*õ\rÍËÂÉ:õ≤Aùö-‡‡¿vppº)8D≥¢WÍZ;Å∫ØÅ˙€”@W–¿ÛhÚ84-zq	8lÈ0–pÆ4ÃN\r_[Ä√Ÿ\r‡p?8ºXíé∏ú\Z}M\0ç]A„Ÿ;A„Ò†	îö»⁄@ì8™—ıÎ.8\Z\\öé}öZÕ¬ÔÄÊ‡ –º∑Î≥{*gp∑b8ÆÌ\0h9v>hπ˚hô5¥ö¯¥JN\0«ÁÈÉÇ˚@kôhΩ˛\rh}¿¥˛π¥Ÿ⁄ÏlmN^m A€oE‡ƒ/„@;Á~–ÓU8i—?–>&úÃ/\'?O\0ß|D@ß@\'pZŸ–Ÿz!Ë<˘8=á]#~Ä3gÇ3¶GÇ35\r‡Ã+G¿YènÄn¡Ÿ˜ÄÓ_A˜ú±‡!8ÆÁ∫XÉÛÙ”¡yE¡˘Í¡˘È¿˘ˇ¸¡Œ‡Ç»\r‡Ç$%Ë!o=ÜÔ=ÍüÄ≠ñ†gÖ∏pœ\0∏ú/∏∞y∏hÌApQÂ\Z–K≤Ùö¥Ù:R.∂ﬂ.æ¸Ùnâó‰ÁÉæèÇK=”¿•G∑ÇKÛT‡≤k–˛˙eçW∏dÇ+ﬁOW|Î˝7]W>ÿû∆¡¿G0ÿ¢Æ≤4W]\0W›X	≠ÖÂÇ¡{0¯µí?^ÜΩXÜu«Ä·#ﬂÇÉÃ¡àü∂‡⁄ı!‡⁄MØ¿u+>ÅÎ™ˆÉÎoöÉQ>è¡®3ˆ‡F¯4∏±À\0å^5	å>î	F>n˙°∆\\]∆< ¡Õ\r\npÛ”LpÛ´‡ñ+ç‡Vf=∏u∫7∏m˙2p[ÍWp€â}‡∂\'0nb∑Ÿå∑å\0„˜ÄÒI’`¬í,p;øLlß¡6°‡éG¡§X)ò‘‹&Øú\n&ß?w}H˜¯∑Ç{{ÊÇ˚¥áÉ˚Ê=\0˜ﬂØ˜*SóxÄ©-ü¿e‡Å˚`⁄ë+`⁄˝r0Ì©\rò>hxpıD0„[=òÈË*pÁÅá∑^\0≥R¿lUò›û\0ÊÑ\0s˛åè1õ¡c/˜ÅπìU`Ó\"38_R\nˇ¯Ãõò\0Ê5ûÛ˛ˆÅ˘˜À¿¸Î¡12∞ y6Xê˙,¯ª<µxÍ√9∞–Ï*XX˜,ÚôΩ`¡3%O¿≥≤M‡Y+s¨ø<ª&<˚€\r,60Kò@∞¥0<Ô∑º0lX∆ıÉeπ3¿ãJ∞B∂¨0´+Ê.+¬gÉóñÑÄó)7≤gxy’EäÒ\\ä◊H∞´+∑´FEÇWøå´«oØπ?ØE<Øœ◊kÚC¡öˇ9uº˝¨5æﬁÙºΩ,ºù™ﬁÆ©o˜ÇwuÁÇwá^Î∆∏ÇÏÏ¿ãñÇ\'Çë‡√ˇÍ–†Ô	>\nj∂\0}qwßÉç=ë`SΩ=¯-Î{(¿\'o¡Êi‡≥$lëıÉ-#gÄœ◊Å/ ∞µû_ö$É//‘ÇØ¸+¿WÁ?ÄØû„‡u\0¯ú	æs∞ﬂµïÅÔzßÉÔ˘µ‡{õ^C“ct<ÿ1<\0ÏvîπÅùÁm¿ON÷‡ßŸŸ‡ßsŒ‡ß€ß¿O/Î¡œ ¯π¶¸Ú~¯U¥¸>}8¯ΩX	v≈]ª:∞€X\nvÔ{ˆD›{ÀNÅ?„1ÁÔbó◊o◊2_W¿vW∂¯´u6¯˚¬\ZÔ#Ô√‡?√ı‡ø≤0∞üÍ˚k;¿ÅW; ¿ìÜÄ47C‡›ÏpÜ #∫ù¡\n{û0\0¡v∂|ÁÑê!ƒb9Ñ.y° l◊Ø∫Êç1Äàm#!r˚\'àº\Z\nëù!—ºXH≤%í:+!È©´êÙ∆[Hf…æ\\Ä‰S≈ê¸ï-D\riÖ®„\'!Öª§hŸ)1Rj/Äîw, Œ¨‚ì€!ı?H0˝	VG!aª$ÏÖ49Ø ≠wAêˆ4_HG{§ÛO\r÷ﬁ\rˆtáá<Öﬂ{\r˘˜“ÀüÈ}‹ÈªáÙWºáÙwoÑÙøò@C«÷A√‹ûA√|A√J°aóª √Ç+–àñ5–»Yrh‰›#ê—‰\Z»Ëü\n2Ó%!ÄFi-ÜFÇF\'æÉLﬂ4Bcd%–ò+ 3üd»ú\"†±Í]–ÿ-È–8„$»≤p*dY∆BVæ@„\'ÈC,t €$dmŸMXŸó ˚√k ˚ÏÛ–ªEê√rHQBésS†©iŸê”h⁄™´ê≥˚7»π;‰‡πlö\0πº\0M\'C”˘h˙≈.»’≥r]=r›˙r}Úö5*ö=˙$4OËÜÊ_<	-¯Ô<⁄C è$‰IxAûs]°Ö¬4h·Ñ–Bo3h·=Z4|=¥Ë±+¥ËœS»´v\'‰ÌîyßZCK<«AK≤„†%’´!ü!Î Îx»◊}Úº°•\Z øõﬂ ø7w†Âá‚†ÂOfB+÷\r@+chÂûÖ– ª√°ïo@+{CÅˆÈP`≈;h;Z5ÕZ’§ÅÇ›†‡\"h5≠v7ÖVóáB´/ñCk‡π–\Z◊PH÷(t:Öﬁ_Öç¯Öd†(¬È!±˜;¥~‘h˝R	˘,ä	5ÖbrnAõáVBõ+>A[ÏÔC[w|Ö‚,=†I$î03Jÿ9\0%¸ò\nm∑jÜÅ´ï–éò(…¥JöÏ%m˝/Ø%Ω˙\n%_ávMπ\nÌ∫Ú⁄ùÌq€Ìπ¥⁄Û«⁄OA)g_@)/⁄†Tq%t¿‚îVò•O|\0L∫Ã	Ã\ne∏≈AôfYPÊÑ(ÛÒË9OËpÁy(kHîkÂ¯ËCG8tdit‰ÿË»ìË(g≥ª{˚k	_“\r?~ ˚¯ ∑ÃÄÚ#G@˘C˘w÷C\'‡_–	ãü–	óY–â¥[–…Ø°®*ÿZùj}	ÍBÖœCEàT‰9*⁄>*˙	Ag\n~C≈ä˜Pq®*ﬁ?*)ÃÇJNÜŒπ*†swÊC•c †ÛõpË|û7t˛‘TËÇË2TÄAWôA3‰–%/	t‹	UM_UΩqÅÆn]]MïB’G†k	á°kßøC5û–\r„ÔP≠Gts˜cËñ¡LË∂X›Ì9\0’iå†:” Ëﬁ:∫◊Æ›è∞Ä–†∫ø†zŒ™j=™õ5nÛÜ∑\'BO˝@Õ˜Î†ÁÀ@ËÂøuPwj3¢†∂%Y–kÍ\rÙz ËM∆zËmr‘æ9zˇ«˙q˙“˙e‘ëiuö\nuz˝Ä:„ †O◊Z†œ~M–óö„–◊¯o–∑˝F–˜‘N®Îr‘Ì	u«¸É∫ìµ†Ó{_°ks°ﬁ3zPoUÙs’mËg˝aWA<R†>Ì{–øûl®øFÍÔ√aê4Ö¡©q0îzÜm¸`∏¶FÙû¡à—uÀwÇ±Îá`‹&∆/√Ñ˘rò› ˇ‹ÇI`L¶ñ¡¢ëâ∞(ª	µ≥∞∏[KMÜ%\'¡“K…∞Ù±,\nÀˆºÖeµ?a:*¶è_ÑïF7`eîV¬ ◊&0Câ`Nësâá`’‚À∞Í◊qXXí≈Œ∞t5,4¡\Z˚dX≥CkØ∫ö:\"Çu|&¡:m«·¡õPx≤}>¨ªÓ!¨ó–Î]‹Îõ{¬C≈– ˝0‰<¨›6t>Ô<\0è4ò\0èô›9\rΩ`£Ol\\k	õ|˜ÉM˛Y¡¶^û∞π$6w˛õühÖ-˙∂¿V6k`´§E¯∏x|…=ÿ∫lS€4øÑm˛6¬∂_¬ÌR‡â•ƒóÿn”>ÿ~∞!<9ºvà};\\4Ö\rè¿SØoÖßôi¡”™_¬”ûR∞≥Œ(ÿy¬\rÿπËÏB?Ü]£*û—qû	¸ÇgNº\rœÙ0ÉgfnÅg≈¿nR`∑ÇÏÎbÿ˝ÃxN∞<◊PœÛ=œwú/ÿ¨Ç=`]x°’x·ˆ>x—π°∞W…?x±À}xÒ[ˆ÷.Éó|tá}F$¡ˇïˆqx\r˚Ù0∞Ô˘PxÈÌ›“C·eöxxYÂjxY’+ÿOoÏU	˚Â¿ÀÔ\rÇ˝Kıaˇñù∞ˇg\rº“–\0^YpÎ	⁄ò√Åkˇ¡´\Z ‡`>ﬁ∏^=ÍºÊE≤ÁÚÃùµ}A√aÂépÿ[Á¬Ûm·à≥Y∫Ó«Üíªp§±y1	é¨©Ü#˚o√Q3]·®¬8Ítº1˘º1•ﬁ¯¿ﬁ¯Òº…lÛ!é˘ò«Ç◊‡ÿ›ºıÃ;x[ƒ(x€6ésy\0«è¯«W-Ä„__Å„;Ü√€hx«ëõp“¥hx\'ﬁ>ﬁÂvﬁ#⁄Ôyıﬁ;È8º˜„x_Ô{TÔI¿˚ßáS‡∂qÅk‡πC‡7ã·4[N[Îß_nÄ”oî¿ÈÕ[‡Éﬂ\r‡s78c•6ú—Âgö	gf¨Å≥K:·ú€·#·Më£>Q¶>z≈>f≥>ÓL¡yG‡ºÎpﬁ£˘p˛†◊	\"\n>ëp>—˜>©ﬂ	üÙüºÌå,Çé;¬ßNÿ¡Ö]YÈEõ·\"„H¯Ã∞£Ÿö¯ÏmK∏∏..Yu.˘9>∑r|˛Ÿ<¯ø.cœ√S˛¿ë\rp≈ÌÖï!pïm\\uÊ!|ıÙ1¯Z‚%∏&g.|£∫\rÆ•¬µÒ˝pÌ˛v¯Ê¸≈-#¯62æckﬂqkÉÎÏû√uå‡∫.s¯ûÿæWe?ÙqÜ<ÇñåÜÎm@∏>⁄nÿ7ƒoÅÓ‰√è‚V√M£Z‡«ß÷¿Ofô¿Õªı‡Êø·g5¸‹w¸º÷~Q9n=L¿/=ù‡W+ı·W˝?·∂UéÎH¯›ÿª∏^¯]ˆ-¯›ﬂ´wø√â6¯„X¯„“F∏Û™;‹˘~)¸©o¸5x*¸ıÕo¯€Mg¯ªw±r∏À√\rÓ⁄owΩ€w?6Ö{\Z˜¡=Ìs·1À·√Ω:ëœÀ´‡_√#‡_ª\'¡øùÃ·?^ïüK¯Ôº#_ÔÕpÊ∏?[<›\0¥ùÜ>ÿ\"@Ãn»>ç¿‘7©ã†So#h }=¡¶ÆD∞ÂÌ^q!›D<9\0ﬂND$∑!íÊ/à¥Rëπ9!≤„∑™Ê&¢®MDù∑⁄u$BÔˇÖ–OÓ#JÓ¢ú˝aëLÑ}ÿäp÷¡oöéG_ ™sW’ıNDù±QÁG≈Dxv\n—≤˚éhE◊ ZˇmÕLDª®—n_áh\rDâÆ ÉÆéGtæ˝Ct~5\"Éß¢»‡≈ùàﬁoDÔ„Dﬂ‡¢ˇG1{à¥NFÜ>™@Ü!©à!∫1Öˇöèå\\w1\né@å÷ö\"F}Á„vàÒ∆»Ëü¶à©}b⁄∏≥‚\'2f‡>bVeÇòK& Ê^o≈]ƒ\"u\'2éºåå[jäåãöÇåªèX*G#ñ≠g+ubÜÿË©èƒ∆ﬂ	±%“êâu}à›\\d“⁄a»§c+{{	2e°‚‡qò{q(ıFÎÜ!N:ÉêiõaƒyC‚ºc*‚|<q>øqærq9}ôÓ<ô^ıô˛˘	2£°ô’äÃ¸πô%êY™πà[®7‚˛1ô3˙\Z2«≈ôªj\"2˜B\Z2˜Ω)2∑∑ôß˙ÅÃ3≤DÊÔπáÃØZÜ,»ÑxÑ¯!a%àg‰ƒsÉxõâ,‹æY€!^ï€o¨ÒÕ@º◊#KjZﬂ‹	»R}CdÈ¸U»“ÿCàﬂ⁄2ƒÔh$‚ógé¯ıæAñøê +NﬁB¸UYHÄ*YŸΩ	\\	ÃÉûÚFÎmêUû?êUŸ4˛(–Ü«ùEÇOˇBVßÓEV7C÷Lƒë5GÌê	)XÇÑN[èÑ÷§#·KA$‚˙Zd≠n≤nÓsdΩ\"Yã¨øTÄl\0≠ëhÛ$:‡]qâqˆG6Û·»ñ)Ö»∂≈√ëm)Ûëx◊j$øÉ$,Zã$¨˛ã$$E∂óêÌÕwê7Jë$’,$Èí\r≤s¨ŸπÒí|Òí‹√\"{úø!{¬uêΩìW {û#{?mFˆ]@ˆSœê˝ø> ˚ˇô )ã∆\")æí´ç§\ZERÁŒCRÔ7\"\"Œ ﬁ#i[∆ u‰‡‰$$s€x‰–∏Ò»a´.‰pb3íuüE≤ø: ŸΩô»{‰Ëﬁª»—ë£è’»±≤≥HÓ6=‰¯…„Ü!ybëìJ9y°9Ymá†ç»i—E§hrr∆·\0r&’\n9S¯9kÙ9;Î3rˆÑR<Õ)—ÌEJö,ês}<R:Î7RÍ>πPõãîÕ°ë≤¢gHŸ˝D§¨°π8Æπ∏ÈrI„Ñ\\?\Zπ<èB.ß!W^k#ïßÆ ïw‚ê*√&§*∞π:aRΩ%πNmDjÜØGj‚n#7:JêZ≠ıHÌÀHÌo‰¶§πŸé ∑•!»›‘QH]π1r/[π˜{\'rø-©üïä4ÿˆ#èéU\"çÕ5HìÌ§)üG{¿»ìŸ7ëß{•»”ﬁÖHÛõı»≥,K§e»$§≈˘1Ú¬øyy´yE¯!m‚ôHõÒ8§ÌŒ\Z§≠eÚ&NykÛyª÷yw¿y◊ÍÅ¥K;êˆ‚˝H{m?Ú8ÖºCë˜ÁÚê\\ÚÒø˙v§=D:_î\"üV|C>Ω≥@>É8Ú“Bæ,[Ü|)¥Bæú≠@æî.BæÕ˛Ü|˚—åÙˇF~Ã¸é¸h‘ ΩÛêﬁÄR§7ÕÈ-õè¸4{Ö¸>z˘}¶˘£UÅ¸Ò¨@˛&; }K§Hﬂ3‰ˆÈ≤	È_pÈoªä¿êÅøô(¯¸\'\nu•£∞:	EÓ˙†Ë õ(\Z¯Ek’(ÆtBq√˚(YÇäÜØE≈¢®ÿ¥ïº?â ÆODÂ™®™Bï3⁄PF/e>c(€êár#ºPç˜pTs¬d5‹®Aá<~ãÍä P›q*T˜ë/™€2’„ﬂ†zÎPΩúRTØÒ7™?ïFıÂË–ÏŸ®°Aj-Bá˚CGOGçœ®I˙q‘‰™:Êıl‘LP¢fª⁄Q≥CãPB-∂˜¢]jÒ„5:∂Ì\":Œ¡7Û\"j˘\Z@≠\\Ô°Va7–Ò{eËÑïπ®5¢÷œˆ°∂c›Q€}c—â¬‘>àNﬁ≤ù«°ÔuP«ôCQ«Î:ËTÕg‘i’xtöÃù∂=u)åB]Œ∂†”±2t∫z=Í˙x:Ctù…ñ¢n•û®[e;:õòÄŒûzu{	ùS®çŒç[äŒÎöåŒ|é.0πãz≤ Í•{ızTé.ﬁ=\rı—í£>ΩE®oÈ‘˜ù6∫‘≈ı[rıkãDW4åE˝≥æ°˛ˆ°˛Õ€–ïÉ˛°+=Ó†+É`teØ>∫ä⁄ÑÆJnDÉçÙ—’£o†´/;¢!c◊°°ﬁõ—∞\'4|G,\Zû˚]k˛]?Ë-∫!x∫·§\ZI8£á˜†\'ÔE7Ë∆\Zçi.B7ªºE7Á£ËÊ/1hlc9∫5e\ZÁ*G_°	±S–Ì_ù–ƒ/æËé[S—ù·5hÚLc4˘Üö‹%Cw≈–ËnE\r∫€>›}Â∫7n∫o∑∫ˇã5ö¢wM1¥@SŒmBSÆX†¶›BS£Æ‹G”ú—¥}Uh∫ëz0VÑfÏ|ÜfÍ›@3ˇ’¢ál|—√#√–√\n—¨1uh÷≠”hVÛ4gÑÊåM@s‚\"–úÏX4Áe(öÛa$zÙd4öª≠Õ-—EèûàÊ≠(FÛ≤ñ°˘3t—|ˇøh~Ù4øÕ=qFOÙÌCOÊm@X-–éE∆¨CNÃFO≠ØBO{FOø?ä«$£%˛ËΩΩËÖƒZÙB˚0¥L˜\rZÊt-õu-+¸àñ◊Î£∑≠G/˜e°Wæ§†ïü\\— ﬁ∑ËUù˝ËU˝Ë’aNh5¥≠÷rF´+£’k–k%ÕËµ{ã–k_’Ëı∑’ËıûXÙÜ¸z„bZkÌÄ÷ÆqBoRçËÕÀ^ËÕÍzÙv‰(ÙŒö´ËΩ≠ËΩ}≠Ë}Wz?&\0}([Ü>\\ùã>íh£I⁄ÿaà6˛âGõ∏ıhìm⁄TÄ>â…Gü¬uËSè°Ë3}VbÉ∂Ïî¢-Æ†œwΩGüü9Ç∂ÆzÖæÙ˝Or\"˙≤5}5∂}e›áæZˇ}’˛}=æ	}=Î˙˙Q(⁄nrmüÙ\ZmcÉæOtEﬂﬂ»D?å…G;l–G/¥cÛ¥„,âv˙}B?üﬂÉ~˛<˝\Zá~i∞FøjMFøÍ_DøÕFøõçFªò\rhóÊ⁄ußÌ∫˚Ì˙»£›£ú–ÓC–Ós´—û‚Ùá√/¥◊•˝•FˇtºB˚ÇÊ¢ˇ÷ﬂC˚!S¥T⁄o÷çˆGÕ@˚3¶£˝˘Ë\0RäÅ≠O0§\Z≈–·ñcX{Ü˝ã¿Ú_~?\r# ]0‚Ê;å¨vƒDyLlûÑâ}¬0Ò≤lLb`áI‚Œb≤ïw1ŸÜ˚òÏÄQÃyåqS\ZØƒ∏32å/?è©jûb™ﬂNòzÙ-L}ƒS∑ÖaöÆSòÊO¶5Ï¶≠ÁÇiÁb⁄Uã0ÌÎ	òŒSslàn¶{ ”É0Ω’?1ΩºWòﬁ◊Iò¡¡HÃ‡»SlhB\"6,~\r6Ï[fZå\r˜/¿Ü_òãç∞*∆F˚Éç¸[çOÊ∞—5°ÿË/©ò©÷ Ã¥&c≤≥/kæ{‡663\Z[˛gÚ◊TÅY¿,√ı1À⁄lº…Ll|≠-6a§	f3Ó/f3ÎfÀø¬lÌ1€®ˇÚÙÂÿƒ·æÿ$ˆ6©Ù6i†≥◊YâMYÄM)˘Å9ôaéméÿ‘a7∞©°C∞iå6ÌÜ;Êí2s˘HaÆ?Ç±™¡ÿå#ß±Y5 Ê&¡‹®cÿÏ∏nÃùs¡ÊÙgbsÂ+±πÜ˝ÿ‹ﬂûÿº“7ÿºo?∞˘6ˇq)∂\0æÖ-h◊≈<∆˜as€1œ≈=òÁﬁòg¡RÃÛπÊ˘÷[∏SÖy±±≈Éaãóû¡º”∞%?ﬂ`>éK∞eÉﬁaÀ&]¿¸ób+z≥∞Ä!êÒ»˚ã≠tﬁç≠|5|q|{[5e4Úî˝:ÑÀ\\±‡g$Bta!ﬁ±êÚ◊X®áÖæL¿¬™Ó`·gå∞à·≥±˚uÿ∫á±uÒÿÜ«ΩÿÜg±\r_ú±»]∆XÙà√XÙ…ıXtq>∂â‹Ñm™ÖmÄmN8çm>t€¸¡€≤€ã=öé≈˛ı«∂fÕ«‚ÙZ∞∏I\rXºxˇp=ñ˝K®˛åmóÁa€U˙ÿˆ*∂ΩÈñx;KÏ˝Ä%›∑√v¶ü≈í√YlöãÌîbª£plœî5ÿûß≈ÿæü∞‘Ik±‘LK=iÉ•ˆ.¿\'`È√√∞Ùÿ—X˙ÕÏ‡Ô4,3x\rvh˜Ï∞ÓÏ∞è?ñe˙À∫nãeÍbŸi4ñc‹ÉπÒ; N¡é-À¬éΩ:ÑÂ¶cπóú±<tñ\'ùéÂ©∂byw\r∞|h!v‚ª;	˛¿NÓäÑ?¬\nDcßè-¿ätﬂ`EÆqX—u.Í&±3∫Èÿô‡uÿŸÂ,V¨J«äõ∞‚-!X…°©XIœeÏ\\ˇF¨t¸9¨‘⁄+ùÆ¬J›i¨¥Íøº%ªDåïu¬ !%V˛€ªàè¡*n√*˙˝∞KZ˝ÿ•o[±Àz∫ÿï/Xe‘n¨Í;Ö]µf∞´?n`’mO∞k\'7b◊\rc◊ó∫b◊o.¡Æ∑\r≈jb∞ö={±öºÿ\r∑Uÿ\rØcÿç;ÿçÊ˘X-7\r´}ˇªôªµÕ	ª]=ª€Ö’!˚∞:ÀZÏﬁÚÿ˝%ÿ√—µX√–9XÉ%Ñ5B_±\'Ö]Xsî%ˆltˆ,<kπVÖµ¸2«Z˘ïX´3Üµ˙ôb≠ª¶c/Wb//EaØﬂ-«ﬁ0[±∑7±wßù∞˜»gÏ}o÷¡ç¬>πÏƒæ*≈ÿ˜°ıX◊Ùj¨+{2÷]Åı∏,¬~G±Î“∞QYÿ/,˚µ\\Ç˝ä¯Å˝vZá˝±‡±?NÖÿﬂ’#±øÔH¨oœB¨ØΩ˚˜Ê,÷ﬂ‹á;q†™áé˛ß–\0G<‹q\\ø\'M\'„¢˜qÒ	\\rk.Â˜‡“üSq ˆÆhj¬Y≠hú›”äsïõqu–F\\(›Çkt◊·\ZcÆmùäkﬂ∂¡5‚:∂‡:Û˝pù\rJ|∞õ>d¥5>d≈[\\∑RÖÎˆ¯·z€æ·z{öp˝≠6∏~Â]‹‡Úi‹‡…B|òÙ>Ã V≠¬Gt≈çÂ∏q~n¸ınrt=>*Â<>ÍD%>˙ÓM‹ÙÚO‹t`‚]ÑèÈ8åõ’º∆Õá|¿Õm‹‹„,nﬁmà[†ı¯ÿÑp|lÍ;|z\n∑<Æ¿≠éO≈≠nò„„uá‡„ó=¿«w8·vØ¬\'Tü«mln„6∂z∏ÕŒ[∏Mç-nÛ≠	∑ùç‡]7„vÉzpªwÒ…˝∂¯î`k|J˙O‹¡?w[â;M¡Ω·é;Mq«#\r¯‘òd|jZÓ‘›ÖO≥∫ç;ˇ∆]∏∏Kü>›0ün∫üôÓÉœÃ0≈gÆ√g°E¯¨\0O|Vw%>;¯\Z>˚®7Ón∑ü∑Ï,>ˇ¢5æ¿>_∞e/ÓÒÈÓy∂˜¨[ä/¥ÿè/|∂\n_‰q˜zä{u‡^\Z‹€0˜v∆Ω/V·>«ÉqüO¡∏Ô≤K¯Rß6|È˚ª¯2ÌÂ¯Ú ¯\nª)¯äûS¯äükpˇ\'^¯ êﬂx >_µ%_ı5zˆ	æiäØ^p_Ωp4:êåá}_ÜáØ◊¬√£‡·OjÒà{3ÒàOèuíã¯:u:æa’y|√∆	x‰¸uxd‹<ÚxYaâGÂ√7\ZN¡7ﬁøçGs◊ÒË?1¯&ˇ5xåﬁg<&≠èy±\Zèiüão˛ﬂ|ˇæee4æÂÌ6|ÀÁqxÏùj|´ºﬂzi(æm	è«ŸÔ∆^≈é4·€·t<≥¬˝a<Ò¿6|GŒG<Èæ5æsÀ|g[%æ≥√ﬂŸ;Oˆu¡ìW‰‚ª2ﬂ·ª:∂‚ª2¯hæÁ≈5|/ëäÔª¢çÔ?ÛO	Ó√S“è‚©Z«TO-¸¿ûìxzŒ&¸†~~0x%û1Eåg,ã∆3 ˇ‚ô	˚Ã‘OxfC<~»Åƒ-XàdãﬁˇœjO¿≥/Ø≈èxÔ≈è\\{Ñy4œEˇ‡π5û€ûáü ÛÒì á¯…†9¯…T/?/àZÉ\\?ÅÙü¿ÀÁ‡ß≠«„ßwO¬O◊i·ßﬂﬁ¿Ow¸∆ãÿªxQÑü]nçÀÙÒbÀ\"ºxÔmºùÉó¥Ü·•a_Ò“œe¯yô?~æÃ?Â	~˛Õ+º|\"É_ÃÜ_vˇÉ_ˆ	∆Ø,}ÖWj›¿´ÇV‚U%3´≥x¸ÍÒìxı™>º:ˇ~ÕÎ=~m≈0¸⁄yc¸˙–[¯ı–j¸˙’\\ºÖ◊8‚51µ¯ç9,~S”âﬂúØ∆oò‡∑øX‡w5;ÒªCù˛søª√Î†Cx›pk¸ûª!~ÔÎo¸¡¸P¸°,8È ˛˚8ºä¬e.x£*o·ç˚¥¶µæx”fºièﬁTíä7›öÇ7ı1¯„,˛Xá?±è?ôÿÖ∑Ã:Ñ∑lè∑7√[ÓŒ¡ü/q¡_Ñ·≠èÒó∂xõ«uº-à«€N\0¯Îqœ◊±£∑q)¯€t[W¬‡Ôû.∆ﬂó<√ﬂ˜«?<¬;|éY¯ßmìÒœz/Òœ∂3ÒœgS/MØg7·_{,Òo”˚ÒoµÒÔk÷·]ï\Zº˚‘.ºgw6˛√™ˇqœˇ—fä˜Æk√{7xo˙a¸\'iãˇäñ„øﬁ◊‡ø]≈æÇˇ>’äˇ~—Öˇ—ÊÒ?&[ø≤¯ﬂÅ´x_íˇ«;·ˇ*@º≥1ﬁ_É†¶¯Ä˜r|‡ÀA¥_GÄÛ0’Ñ\0K)zwî@‘?ƒ¿é@v»Å™®Ì0„ˆò≈N?–BöhÇ04\'ƒ-0!ôÛèêÙù$d)˙Urò†w$ &;ÇClÂgÇΩ7Ö‡p]Çºê‡|	>b/¡óˆ*^ãPe≤Ñ0Ô0°y}ô–\ZöCh%7⁄Éf⁄ü⁄_wÉ°€ƒ`b\"1xÎbàh11DaCËÖ}%Ùˆ\ZD,aP3îZ≤ÑVSEÓ	\"Üé ÜÔ;Nåx¨Kå$«#i[b‰H#¬Ë—C¬xﬁU¬Dvé01Î!FœFâ—´>£„Ñi‘Hbå’EbLT\'aÊÔDXú{NX|ﬂNåã~Bå€˜â◊ıê∞‰|KÉ/Ñ•y\"a9Oó∞|íOX~]IXˆ|$¨íâÒñ´â	≠´	Î·◊	ï/1±Âa˝ö∞ÎAÿ})%Ïı¥	˚˝ŒÑ˝Ωnb É/ƒîvÑCØ%·ËüIL≈wSáƒSW∂N6ßßñ#Ñ”∑Qƒ¥ô	g≠ÎÑ≥Ω+·\\H∏\'\\FU.%,·˙Ó1#p=1h&fûöEÃ\"àY\'r	7∑IÑ€≥ÂÑ€õ¬›…Äpèv\"‹è%Ó	ƒúŸÛàπ„pbÓéò«TÛ[«öµ	À6¬S/òt]NxñÃ$•âØÒ◊/◊cÑóØäX<=öXbA,~∏öëJ,ôÆ$|òWÑœ|ÜùÛôX*Æ#ñfÃ ñÊÜKœ∆KÔﬂ\"¸tÎàŒ;	É\"†)öX9d\Z∏.ìlºH”kâ5√Øk¢Ãà5œàê	ÈDËR#\"ÃÍˆ$ë˚fOÑÁ‹ ÷Rƒ:v±ûXKl\\DDÖWQ?kàçE-ƒ¶@bAl±>Nlπ2õà]1üà›øéÿZtìÿ∂√úàªNƒ=o&‚Ü€Â◊âƒ–”D‚ÂEDíd5ë4ÃÑH:<ïÿÖû&vãFª#≤â›èÍà=6ãà=èµâΩˇÙ˛SLÏ\'‹à˝+‹â˝«⁄â˝)=Däcë˙6ì8≥Ç8p˙-q‡Lëf¥àHõ·D§ΩF§èˆ#“ÁÈµÔàÙÊyDz˚a‚‡’èƒ!¿ú8dHrØ\'≤`k\"´4â»i§à#ìeƒ—à£Øìâ‹°óâ‹\'à„Z˜àºõìàºo·DæfÄ»sá»_<ï8©ﬂDdcD·§˚ƒÈ®#D—¥’Dëáú(\n<Ouág¿AD…Kî(u\\BîÓ∏Oî˛7[ÁOø\'.î¸&.‘⁄èe⁄›DŸ˜¢¨WJî„àr\'¢¸êò(?∑Ç∏Ëæí∏XßM\\|Úï®®Æ\'.ø!à*â)QµÎQuh(QΩªü∏∂dÄ∏`F‘W7ÿ\\‚∆p	Q{Ÿã∏9}qÀ&ì∏ekE‹∫B‹>∏Ö∏˝BM‹gN‹YëO‹âxC‹©_A‹ÈﬂM‹cN˜\'˜Mkà˚ﬁ)ƒ˝}Êƒ˝„wàr)Ò`√\n‚¡ó‚°ç-Ò∞oQ∑à®ﬂ7ã®oL&\Z¯ùDC”\"‚Q≤;—¯‘öh|YL<YëA<ÈªI<› %ûÌ!ö-ÃàgCY‚Ÿ9k¢eŸq¢%-èxAÍ≠Ø@‚Âˆ$‚¸ñxxéx€yñ¯∞æã¯¿á¯Ë÷O|\\F÷Dß¨èË‘ΩEt.J|÷6#>¶ü”¥âo iƒ7ıl¢KGt≠Ø\'∫|àûù”âû„wâû—3D¸H⁄@Ù∆ÎΩ∑Ωop‚∑GÒª¶õ¯ì˝ô¯”´EÙÈ{}?~˝”ü˝ÆSâµ>1–püx.%¡ç/Hòı a£h.Vì»–Z© 1qâπÕ#qµâ/ﬁAGWìƒ”s$	ê‰Ê9§8¡Ñî˙6írˇS$µ÷è§æ= B8I?Ô#≈3íô?Öd\Z„Hvh)…æB≤›y$Á∞û‰Xì\\i3©:áTóº!±)<‹Ojñ=!5NíZÚ$RÀı\r©5Ô9ÑZIÍ\Zí§ﬁâï§æ$é‘/ä%ıüÆ\"\rRQ“ ›ö4¯+\'á-¸A´•HC>ö4‘˙OëÇæ}\Z9bŒrƒ—Nrdﬁ0r‰ç!§ë´i‰ˆüüI„’i|c:i|k7i¬û\"MúFë&±œH≥2\'“<si¡÷ëc\'_%«•+IÀ—£H+”Xrºd9^JéçŸK⁄lYO⁄6&mßΩ mg˙ë∂çoHª5è……D9ŸUM:ÏyI:‹“%1“q;HNıYDNç%ßû˘MN≥¯FNÀØ#ùwêŒ©^§ŸKNÄI◊≥€…W I∑≠ãHwˇc§{SÈ˛Ωìú#i&ÁLyDŒ)ùNŒ≠a…y≤‰<Ì‰ÇgÜ§Á4“≥Íπdπ∞ƒÖ\\dÎD.*\'Ω¢<HØ‰≥§◊°§◊˚Á§◊Á}‰bﬂø§∑◊“g‰Z“WìN˙ !}∞§Ô«c‰“µ…•	{»•?-»eeKI?ƒÉ\\fN.–@Æ—CÆ∏NÆhM\'˝]Í…Äã…ïOÉ»¿∂Ö‰™:r’ÔØ‰™ø√»`œ?‰j#sr\r”BÜå\r C\"2‰»w2¨ úá∂í·ßã…ß2\"4êå(|LÆ›/%◊>Ù&◊ï©»u≥»ıõGêLfí>O##GFêën∂dd/FF—S…(œK‰∆uÎ»ç1œ…h≈2:y4π	≠#7ç⁄JnÚﬁOn*~Fn∫lD∆¨L∆¥-\'7è;DnNYO∆ô›\"÷m$J´»ƒç±d‚«ü‰é5Û…§_dRø7π3$ì’ŒdÚûdr◊∂Nr7Òè‹Ì#&˜…≥…˝˜B»õèdÍıÕ‰-Ú¿Œïd⁄=rõô9ˇ)ô•ﬂ@fôUìYïŸdV+ôΩn\'ôSµÖ<≤RFÖí»c/=…\\ÑÃ\r∏KÊ^}HÊ˛ªEﬂıáÃk:OÊÀ¥»N\nÚdÅ+Y∞$Rk»¬Ô#…”º-y˙D\ZY§® ãÜ~&œ<è!ã-FíÁ`#ÚúµynZ\"yÆY™ÂC^M!/Ñm\'À&\'À∂=\'À˙l»Úë«…rØJ≤<|-Y~Î=y1MNV¨¶…KZ:‰•©/…J∑Gdïù=yµ`yµ˚Y=Ì5Yù‚IVÁo!Ø”:‰ı\"%y˝⁄X≤f¶+YSÍJ÷∫eí7çNê7√k…[Ñöº”M÷È<$ÔÕ{K>pJ\'\\t ä≈‰CcÚ·Úai˘ÎU≤¡{1Ÿ8Mül -&õnëMÌ◊…«.≈‰„K»«o{»\'kﬁìO=º…fY*ŸlûO6OÕ õWo!õìz»gÜ≥»g˛ü…g_EdÀü∑‰ÛR;Ú˘Ûù‰Ûﬂ6d´á5ŸÍ˜î|SΩÖ|Û=ó|;®É|ˆú|[íÔn˝!€Ø\'€Ø∆êÔÛµ»ÏkÚ√5=Ú„Ã≤√≤é¸î0ú¸îQD~6?D~Ó⁄N~9˙Ä¸RJ~[ÇêﬂÚÊí]»F≤ªxŸ]ÊMv?u&{r‚…^¬ç¸Öh»_ÍJÚW=@˛æŸD˛b»?-…øV{»æ…ø…~Â≤ˇÚ(≤øÍí¬àÄ⁄=\"p…U‹R.Çødãêm\"TvPDL≤ë>\"≤ˇñHlc.œz+{≠âk(ë|˝8ëº«Q§XΩF§xKähü\"fZÖàıu±ØoDâ¯àã\"ı¥Ò\"Õ¬fëŒÓ◊¢!;4¢!èBD∫ Hëﬁù_\"Ωg≈\"Ω∑é¢aü\rE√G&àF:o;úüô/2~·/\Z›˜A4vmîh‹∞—¢qwA—xH\"\Z?\\#≤6¯!≤ù<Ed\',ŸŒM÷‹M.s9¢â\"Güπ\"«ñ]¢©Û—¥3ØEŒãD.ÿ—Ù™¢˘ÀD3ﬁDãfûàÕ.º#ro=&öìõ,ö;sêhﬁ†ü¢yCœàÊr¢ygÓä<NOytıãZù-ä(ZTÜãºäghâºoFã|2)ëOïø»ßmª»Ácóhô‚ª»o¶©»œÎÅ»ÔÑΩh≈\\s—ä∏?\"ã¢Ä7E+›lD+?˜âcÉEAC/ã÷TÙã¬æ6ã¬o.Öw≠≠çˇ\'Z{≈V¥ˆâΩhCPûhC —Ü*R¥ÒÃ^—¶nGQLâB¥9¯òhÎù¡¢xÏâ(æÃBîxˇ±(	>+⁄ÈyR¥≥¢H¥øçhˇ”ı¢˝ﬂ4¢îëﬂD)!Ÿ¢îÆ±¢WÊâ“ «ã“˙ñã“sgà>>/ 0_+ »€- xÎ&:4ØHt(cü(˚Bµ(ª)Tî#dâéHmDGM\rEGì:DGÛ>ãrìˇ”n!:æÊÇ(ÔﬁQ˛;—â(mQ°h±®pÚZQ—≤ù¢¢ÃzQQ˘P—Ò—Ÿ‡	¢≥k“D≈ıüD•√˜äJFàJèfàŒãDÁ•˚D*kEe´Vã ÇDÂáµEÂgBD˛3Eó‰DWfûU&ÈãÆnµU´≠D◊Æ˝]˚¸Pt›nÅ®Fñ#™©û,™˝∆ân~±›28.∫º›â4’Y¥àÓÖ¢˚Á≤Eı‰Q˝ßvQCîRÙh˛OQ£ËÆ®)ÿX‘T0AÙ8K*z¢q5+5\'E/bÌE/Æ^µNX.jm∏,zy^Ωzó,jõÈ)z3hºËMÙ—[˘\n—;≈4Q«ñ¡¢éD‘åã>/[(˙º‚©ËÛ⁄B—óD—◊‰ë¢ØgÙEﬂˇÎΩÔæÔE]ﬂÚD›7x—øµ¢ø(˙ªÛ≤Ëo∆}Qﬂ&πËﬂÉ6—øÆ∑b¿J,F&UâQ«1öÍ(&Ú˚ƒ‰á]bQõØX¢%K∆ÓÀ∂˘âeŸëbπláXûÛ],Ø8-¶µ2ƒÙ¯X1Ì¸\\¨?àô=≈ºˇ\"±∫d•XÎ’FÒ‡±˘‚¡ØVàı‹Gâı⁄“ƒJT<t‚5ÒPœ	bC°C<|π£xDı\\Ò»…«ƒ#{x±Qı\r±Òc±YﬁV±YÅâÿjä£ÿ™≥C<·ÙNÒÑ“Ubk¿PlÌΩTl‚$∂ù¸X<—/Wlü˜J<≈@Á?≈Sﬁ;àßz±bß6bßƒ”ÕO˚ò.ûˆ˜®ÿeılÒt›fÒÙ`çÿµÀP<kUêx÷≥/b∑=b∑åµb∑Ã$±˚ûÌ‚9˛ù‚π]k≈ÛüTâ=ÔÅbœ‚≈€óäÔö-^¸æPº¯€K±˜FkÒ“Eì≈K;÷âóã¶äWÃmØ¯æAÏ_ù)‹ƒïß≈Å+~ãWI”≈´jíƒ¡•¥8∏átDàCg§ã√4é‚∞Œ≠‚àˆ‚µfq‰uëx„’€‚MÖv‚MØ∑ãcÄqåÅÆx≥÷\\ÒÊæ€‚-ï€≈qjSq<tCú‡$à|Î≈	˚Ùƒ€ﬂ\Zäìàwz4âìK´≈{!Òﬁñ.Òﬁü◊≈©QØƒj≈iõ˜â”í„≈kOã>Jgågi‚¨ÀÌ‚ú÷ü‚#Îßàèw_ÁÈ>Á]\\,>í(.≠¸›*>e(.{G\\ÿ°ü9éäœnrónƒ•o÷âÀ∆í‚Ú¢ß‚ãCä/∫}W*Wƒâ/{à/o._Ÿ—#æRò+Æ⁄î Æä;!æöm-Æ∑H|˝∆qq≠´Ö¯V¬ÒÌ[Cƒ∑€Ù≈wénﬂ9ªU|wàì∏é˙(~∞∂P¸ô%~∏cå∏˛‚hqÉ%\'nw7ƒM7|Œ7\n£≈ç[ƒMÓ:‚\'‘ÒìÏ`qÛ˛‚ñ“[‚Á73≈/ˆõä_4:ä_Ùæ∑ÍÌ∑Ó£≈≠÷‚6ÀG‚∂-Æ‚◊∆á≈ØÎ‰‚7†ï¯M˜Ò;ëΩ∏Ω∑¯Ωiµ¯ΩÛxÒ«+ƒüxë¯ì˚)ÒÁk≈üøì‚Ø˝£≈ﬂd¡‚oÀãø[]wΩVä{ñà{>6âl©ˇ≈?:≈ø¶Xà˚&”‚˛AKƒ˝∆◊≈˝ª≈´\Z$¿›r	ò.Åã«K‡Ô%xÛc	±•XB> !Z7HHiêÑ‹˚X\"\"~HDÂ$¢[”%bm=âåí(ß]ï0A\n	{°O¢rö(QüsóÆ·‰ â¶˜ôd–\"ôd–2çd–Ü\'ù®FâŒ∆ù›x[ân…6â^§ßDË â¡âí°ã]%C?èóÀ[\"1<m.NoìåÙïå¸sIbú{Eb≤Úãƒ‰ÉX2Íå£dTÁQ…h˚…Ëd±dÃıâ˘∂%ãÎ=í±¡ùí±ªÕ$„G;I&¥áJl¿^âMÑçƒÊÒlâ]¿3â}¨ódä°ƒ·ÄΩƒq«\'…T#B2’⁄L‚4<N‚t˜¨ƒ©añdZ†çƒYÎ™ƒπÏªƒ≈ıΩdF,ôÒÔídf‹n…¨k	∑I.íπÁwKÊ`$Û˙díÎΩ$~Cèìè˝JâGU≠d·?…bìgí≈ŸÛ$ãKgHº_6Kñ»IñËDIñÃ<#Y≤<X≤$‘[‚£ﬁ+ÒâZ%Y∆Õê¯Ô!Òo´ëLœëÙ8IVèì¨\\ˇJ®nïûˇ\'Yg+	z\Z(	zM≤feÇdÕÎΩí5?ç%!ÓÁ%a∆÷í∞í$Iÿ≈{í∞G%·≤IƒÉ\n…ZÁ,…∫ù	íh|Édì\0I6ıçìƒ‹x\"âumêlÂﬁJ∂^mñl˚+IÚû&ŸiGHv˙€KíOËHˆx{Hˆ¨⁄\"Ÿ;˚¶doÍ	…ﬁ◊%˚Ê∏Jˆ«ôHR}ﬁHLñ§’Õê§ˇ}-…PƒK2I≤¶rílôΩ$ª∑QíìÚPrtúXrtŸb…—ÙL…—WIí\\˚eí‹Ωíº≈Ä$Ôıi…	}7…â≠ÌíÇ®SíSÛHNeﬁêú:¸LrÊ‘!…Ÿô≥$Á>ÎIŒıã%•nª$•>*IÈ…˘UπíÛ°%e+√$e]Üí\nñTûó\\˙º_RÈÚHrm√…ıç^í[ıo%wxS…›Î%uÚ≠í:√5í∫]í{õs%˜v~í‹ˇæXÚ¿w§‰QÒ9I”ı%íßv—íÊ∫€ígº%œ#s%œØ∑H^æ y·ÚKÚbÕI…ãÿ…À£•íóß‚%ØÆ\rï¥›≥ê¥=ÏîºﬁÈ,yèßIﬁÔ≥î|0Ëì|Ñ^J>≈¨ì|ˆWK>7úì|˛†ê|ŸÎ&˘Ú3HÚmœH…∑ÙcíÔÊõ$ﬂoåñtkõJzºTíû;¶í3K%?ãGI~<(˘›m+È˚õ*xzI\nŸ≠êBSl§0u]ä¯öI	iºT$KóäO$KeCª§≤·ÆR≈ ER∆/I ^èîÚ\\™î;-’ö(’ZuK™m˚X:\"w®tDÔ?È»©ì•#›√§F€¬•&`®tÙK:Jí!5Î°tÃÜ*Èò›k§fãÇ§fë{•Ê∂Ô•Ê’—Rã©/§.W§wJ«éåñé˝I:6ÕP:∂ªUjÕçí⁄$üñ⁄¥ÿImgÆì⁄6<ï⁄‰HÌ‚˚§vﬂÇ§ìF‰K\'Öûê⁄èö#ùV,ùú«J¶à§S-B§S[«Jùf‹ó:eíN‘“iˇÈÙ\rÖ“ˇÓJg≠:*u”vî∫Á§≥üåî∫GåíŒq€)ùáTJ88K=˝Ì§û)C§-FHΩ¨Ã•ãOÛRÔdπ‘ª§OÍ„Ë)ım,]v8PÍ\'¨í˙ç‹)ıõ’&ıK˚-ı´\ZêÆΩïÆ0ƒ§˛˙Õ“UÎ6KÉ¸Z§¡‹&i∞Ó9i–◊“‡∏\"i{â4DV#\r—,\r∑JCuóIC#>H√^nïÜuúîÜ˝ÆïF\Z}ìF:‡“®S•1˚^I7ªI∑M…î∆Ò›“ÑÔ§;&Hìñë&WJwâÈ.˝Ì“]ëŒ“]è\"§˚mÁI˜?…î¶ÿñ¶\\åó¶÷îJ”WËK3áÕêˆÈìf’åñfﬂ¥ëu˘ =zË•Ù¯¡ß“wÈI]\\zÚ◊3iÊ*=5Ì°¥Ël≠Ùl}µ¥§Í≠Ù‹∫—“ÚÉ∑§cii\'ΩT‰-≠‹˛TZì&ΩñÓ!Ω—\'ΩﬁªKz≥˜éÙ÷Éù“€fï“;K}§u·q“∫Ê˚“{póÙﬁ•pÈ˝aè§N®§ıf˛“G+\"§ç5Q“∆∫’“¶	˘“\'sNJüÙﬂî>Ω≤Q˙¥ˆ©Ùi˝%iÛÂë“Áñë“ÁofH_z∫I€é∏J_[ìæûù%}kHﬂvµKﬂ≠Ãóæçí~ú ÌÿΩM⁄y%B˙iªZ˙Y∑K˙π6X˙uaîÙÎ¡?“ÔT©Ù{Ïni◊Ë_“Æ\"ÈèeC•Ωi•Fﬂï˛…/˝õ*Ì!Ì˚˝G⁄èÌîˆGÆïªØ»¿¢/2ËJÖ~<HÜ˙ºï°˚eÿ3s~AK&˙I…ƒ‡ôD\\.ìåÁe“Ä-2πi´L~P¶¯R/£œ• òrL∆bd¨K¶åu?.cˇ€ó3d‹Oˆ…¯qô2µvçLΩ˜ÑL;v∞lPﬁtôŒÕ8Ÿ`tÅlpcΩL7Ò≥LﬂjØÃ¿lélh∞ÅÃ0⁄D6¢ÚìÃËVØÃx˚Mô	rG6Íø5£«>ëçˆ˙$35…Ã>íô=LëYÔïç=·#[‚,w…Zfâ°≤	JGô≠˘pô≠ﬂ|ô}˘hŸ‰|©lJ˜\'ôc≤H6m∞çl∫I¶ÃuøølÊ©e≤ô≠d≥*@ô[ÙBŸ<®D6y,õó‚$õ?>L6ø\'EÊÒFÊ9®XÊÈ˝Z∂0ËûÃ{ÒvôwÚ6ôœbâÃ˜HòÃ˜\Z Û√ø…¸æ…ñoõ+Û˜më˘ó_ñÖ‘ÓìÖ<≈d°\rÕ≤¨Ì≤Ûgd·ıdk≈:≤uK≤ddë∂?e3çeè;…¢…¢O˙ 6’.í≈¨ﬂ/€≤uÖ,∂0Y€Ó(€vÕ]g,ã\'„e	#ªe	À∂{xÀıﬁ»wNëÌ¯≥DñTæKñ]ñº«R∂gÓzŸﬁaød{≠\ne˚}œ…ˆﬂ)ë•í•ö.;∞ΩBvú ;X·\";X7Dñ—;LñÒ\'Yv»=Uñ≈Ú≤#9ï≤cV~≤c{]eπ˛ù≤„€>ÀÚÁ®e˜√eßÊÊ \nß<ñˆ‹ïùû&;cú(+ÆÈìﬂ\\ ;7ÏÑÏ¸ÑŸgmŸÖ¯0Y˘∞è≤Ú	ñ≤Kó˛s£Wv©.Pv≈ìîU´˛…ÆÖ»j˛Í»nòï’zÀdwÓ\'…ÍÇû»ÍŒZ…Í™‚e˜Ñ»Ó€ÀÓœî=lú {<ß]ˆDy[÷,˛)k∂tó=KY\"k!\\e-Ú]≤Á•Ke≠‹!ŸKÓïÏ•±õÏe -{ÛYˆ <B÷ˆx∂ÏıSZˆ&⁄Q÷æ„©ÏCg°¨Cv]ˆIY.˚lû%˚ÚV.˚“”.˚v{ùÏ«‹%≤ÂkdΩürdΩ}5≤?E¶≤ø¢˚≤∫oeˇ∂ó…˛]2ñı7|ì\r âFÚ®nü-G˙F…QÔ09Nøê„Àp9~¢RNÏ˚,\'~-íãnåîã«E»≈∆»%§Ø\\jÀ»eÓ€Â≤ˆyrqGNX»ï´Âl¬69{\\-ÁI7π`\"◊>Øík◊W 5˙…uöπNÔx˘‡Á9r›{ß‰˙ÎπA≠£‹∞Ë≠|ƒÕ-Úë‰#o}ñM©ñsÛÂ&Øø»GÈd»Mó∑ M∑5 MK∂ Õj‰f?7…Õ\'QÚ±¿πe,∑JÆï[ïg \'xó[wπÀmûê€˝,îO˘»àr«1ò‹Ò/*w:yLÓÙq@>mﬂE˘¥ÎÂ”*ÛÂ”°rWÌ?Ú¢9r˜ık‰s«‰sNF»ÁÙÓóœ{ßñ/∞\Z*_êtYÓ±ÚÉ‹„[ô‹£\'HÓπb∞‹≥§Hæ(E_æ(sß‹Àæ@Óu◊Zæó{•‰K>èë/€5Zx©A|°B|≠|ı]Næ&}¢<‰È7yò÷9yò›#y∏ªß<\"Ïñ|˝ày§n®|£LGæQ1Jæq‡¥<:I_ù ﬂ4w™|Î‰t˘÷?î|€Xæ≠~õ<nÍyy¬‡v˘«Hyrßß|◊ÇÉÚ]ˇº‰ª7§…˜Ñõ ˜4ò…˜uÎ…Sﬁ• S%’ÚÉã∂»≈∫À≥¨À≥oìgÔ~(œ>˜[ûÛÔë<◊√Hûõ0C~<ÄíÁõ˘»O¬Â¶G‰ﬂM‰Eõc‰E/îÚ≥+KÂgøåî§…ã\rSÂ%≠ÂÚŒ”‰ez¨º\"/G~i®ã¸Ú§xyeÎyµ€iyu÷b˘µ±∆Ú\Z£&˘ÕÜJ˘ÕÅ∑Ú[ô\n˘Ìö6˘˝ßC‰ö|‰èﬂñ◊]ó?˙a*on õíCÂM5ÚgfÒÚgÔ_ [ùY˘Àe◊Âm€ﬁ ﬂ˛-ê∑W◊»€ªX˘˚;¡ÚèC3‰˜UÚŒ-iÚOZπÚOÀù‰üﬁÍ»?}™êY>X˛ı4#ˇˆ4Z˛›Áµ¸˚\0 Ô –ó˜z£Úﬁùß‰?Ô˝êˇ™¯*ˇ{°OﬁW’.Ô◊ù.®=AeŸîJ!¯\\\në˜P¯P\n_D·õ/P‰h=ä|ÙÇ\"ﬂ÷Q¢˜)Ò¨≈î8`<%—Û¶$ø!J¶XJ…l£)Ÿµ≠îÏÛ9Jn6@…œ\r•(AQÔ )≈ÍHäé‹G—Q˝îÚÓSäëÆ•”ßªë†ÿCª(.È≈µÜPº®ÖRÔ\\K©˚#(M»bJÀö†¥ö√(±7•£πMÈX∆RCÏæPCé\\§Ü<ºNÈŒ∏BÈ}ŸIÈ3ã)}≠` \0~Fı£⁄SCè€Q√¿RjX“=jÿ/k 0{65¸º5¢b5‚Q 5í\ZGç|]CM˙MÕ‡(„K[(?5eísñ\Ze˙û\Z’ZKç~ÊFç1\n†ÃÚ%îŸµT |Óy b=Hç=}ì\Zg∏â\Z∑b+5nS?5n◊> jç\reuv5·~e≥Ãñ≤âè¢lÓîÌ≥‘ƒáü®âèı(;Ûπî]X85©ÛeÔˆóö2˚5eLM	˛C9¨YH9‰l£z÷Sé©©©Ò¡îìÂ ©¨ÇræïEπ¯ñQ.áí)ó„ﬂ)óÜß‘t£Û‘ÙEÊ‘Ù‘ÙW_)◊…<ÂÍaCÕx~ëöπü¶f-:Hπ	{)7Ø& mßÂ˚ûr?6éro7°Ê9@Õ_KÕ˜´¢Ê¶DıP¢R CúKy˛-§⁄]°º÷ÁR^ü\")ü˜)_p7Âªó£ñnªF-+æE˘…fP~Òw©ÂZ?((ä\n†9*‡√njÂ¸ÒT‡–b*p√<j’√\ZjıörjuR\rj<õ\nÀ;KÖßôP·„©µÓµéO≠ˇˆè⁄pæå⁄£õä,›KE^ZLm‹2úävN•¢£Q—∑®Mü˛Põ>o¢6w€Rõ˚NR[&é†∂∏(©-˛s®8øX*ﬁtµ›c9ïòXDÌ‡Î®ZAT“¶[T≤ô#ïú˜ù⁄Ââ⁄u û⁄uÎ&µ€•Ö⁄˝=Ç⁄˚{\"µø@Dÿ∏å:p‘óJüôK•œíPÈØèS\r∆Só•Q#‚®ÉYç‘¡?MTëEe8Œ£0¶=L:#¢≤æ6PŸzaT∂~ïÛ\\JŸoNπ0à:zaïk±Ñ:1$è:q7ò:Ò;ü:π«ç*¯zë:ˆâ:ıc!Ux´ò:Ì6ã:s‚+uÊ∑@yR%√⁄®íƒeT)µÇ*ù~ê:øÂUvzUÆÙ§ èËQÛ?QF™bÎsÍr≠	uy‡Uµ=ü∫j1Ñ∫∆‘uØN™Fg:U≥fUª$é∫eQ∑ﬁjQ∑®;Nv‘]’^Íﬁ?ÍÅﬁRÍÅ£.ı`ˆ\rÍ!»SèıË« ™—≤äj¸`E5˛úG5U$RèÁSè”î‘ìêÍ…Å›‘SG\rıLœózñ^Hµ§â©ÁõHÍ˘nıBkı¬tı¬’ûjÛj¶⁄‚/QØ’«®7É√®7óqÍùéı.v	ıﬁÚ.ıæ¢úÍ8‘Ju\"A‘ßA~‘ÁN?ÍKdı5&î˙˙Æò˙Ü…©oùK©Ô˘o®.≥OTW‡f™´ßÇÍù⁄Mıo°~N˘A˝r-†~œ∑¢˛‡∫‘ﬂËß‘ﬂ_∆Tür’7*ãÍªÖÍˇ∫NÙRÄ≠è–Œï\n®h∞ñÆR¿ﬂ*êYKÿ(^:[A‰›R»Ç\nYÔ?Ö‹®MA›≤S(Í÷+ËµwJ◊9\neæÅBYŸ†`4M\n¶|ºÇ˝ÚG¡)Û<uC¡Gÿ+¯ã£™≤A\nu˚9Ö0\"\\°=ê¶D∫(Ì\\ß–14TËxVËæß–c˙zó‰\n˝AÜ-≈\n√Œoä·Ûó*FÃ^£±´B1‚üõb‰Ô·\n£¡M\n„“è\n„kk&Tæ¬dpê¬$xå¬dáü¬‘)J1ÜV+∆,Wå	ÒPåy>MaFlWòyùWò≠y°0ªû≠∞–8(,VD+∆æ?≠7∆X1Œ·úb‹Úø\nÀπŒ\nÀ–äÒëä	7:^+lM‘\n€c/vZì†uäIÁ.*&}^¨∞7˛§òrË∫¬·9Øò\ZÆR8Ò{”≤Á(¶›NR8´PÖÎäq\n◊Ë8≈åÓl≈L€^≈Ãƒ≈¨i!\n7SF·ˆeû¬m†F1[ˇªb∂yÆbvHû¬˝ÁD≈<ªäyùÂä˘Ï\"Ö\ZÆ∏,(<˘ Öß©X∏:R±pÀ0≈¢1cãéÜ(º$sãì[ﬁãÍKñﬁV,Èπ¶≠ü§X¶{_±ÃqóbYB®¬œdòby„|≈\nÉy\nP¢7„˛9c˛µÀéCuÓäÄnäïsü(\\Q¨í/T¨r~§⁄˜Ml˙B|=W±¶mπ\"‰ΩT⁄)¬l·∑7+¬ª+¬˚˛(\"˛ÎÖàqñäà}Üäµ*÷Æ;´X˚Ø@±·˜*E‘Ò•äMºõ_äÿ+…äÿÍ<E¬ÊmäÌªâÀ+âõ6)+v0;ñMPÏ¨´Hˆ?Øÿïà)v\'J{GùSÏu˝™ÿ[à*RWe+R7MV§n”Q§7∏(“;}Èﬂ∆(2|)2“6(2≠úôé«ô±2≈°ü&ä√qÉá≈*?YfAä¨IwŸ?„GvKG\n‚«R√«Ö3ä<√%ä|õ4E~Ù≈…≈…Ω\'ªAEÅv§‚‘bNQ8bß‚Ùòä”øÌE[’äbç∑¢ÿáTeÁW§]är˝ZEÓ®®∏í§∏¥Q\\ZÌ¨∏t∂Uq˘}å‚J◊IEeËE2_Qu¥‚ÍÑˇV˝ËQT√âäjÒ;Euâó¢∫˚è‚z…\n≈Õ—ûäõ„á(nø¶∏Ö\\T‹jwU‹Nx¨∏˝˝•‚Óº*≈›]Ku∆mä:oµ‚ﬁÃx≈˝ ©¢ﬁp≥¢qàï¢q‰Ec•h“¨hj-R<∂zÆxÇ*û∞ıäßÁ*ÕÊëäfßpEsÔ~≈≥ºEK˘≈só„ä÷€mü6(^/tRºÆ’(ﬁù´x¥RÒ˛È~EGLª¢sJª‚S†£‚S_°‚À≈óª]	ÒäÓÍEÔ~≈O{ï‚óÎ≈ØÖ∫ä_ëy_≈_aæ‚Ô\"’Ó*˙Ã!\ZòVFˇ\Zi–Ë\rÕ¶·Cu4rI†ëÅÉ4∫•ó∆\Zü—X«\\\Z_/£Ò®J\ZøPAìg˙hë^-éV—‚⁄=¥ƒÑ†%˚/”í€iYIMOgh˙„,ö—≤•ô„õiÊoÕ:\04[ìGsw_”*µ/≠ÚS—™∑ˇhuH6≠ŒqßÖui!>ÅÆ•ÖZÜ÷ÿ’—öÀæ¥ñI5≠}˝<=Ëu1≠SC—:øÁ–ÉmjÈ¡a•Ù[Å÷u´§ıÜú£\rZÎË°ÉuË°A0=4§G>t£ç∂æ£çˆ©i£úFzîÅm\Z]Hõ\\§«8«“c∫˜–f∆ãh≥P/⁄Öhã¢\0⁄“¯0mπ0ï∂“æH[Ì“ß≠ö:È	E=·¡T⁄∆um´Ωí∂µ5¢m√2i€_Ω¥˝(m_M–S*G–S±ùÙTj=u˝zÍŸìÙ‘÷y¥Së=Õπòûÿ@ªåºDªLFªÏ©†]Ój—.ﬂkÈÈoœ”Æ‹X⁄ıPÌ˙/äûaﬁJœ‹ßEœ∂8Hœ~Ÿ@ªÎHh˜°Ôh˜óh˜◊=\'@èû≥n=Á‰Iz¡ZòˆôE/æΩåˆÆO/ôÙóˆ	 ß}n¶óÕºA˚πO¢ó◊<¢ó?¶ÈLÃ~”+\n„È\0∑2:0HCØ˙\"•É˛y—´„´Ë5´EÙö¥Z:£Èê—wÈPG5ˆk-Ój@ááE—·ÁMËä<zm\rAØ®°◊]MoPπ–˙∫È®≠\rÙ∆˝€ÈË c:˙Œ}z”{5£?ÑéYËG«Ï∏Ho±H¢c≠7”±≥N—±QñÙ÷”Üt‹⁄Òt‹/3:n¿öéØ]O\'ÿ-§ÆÇÙˆS:qR:ù8CC\'˘/ñ}ßw,Ø£ìÚø–;g◊–;Õ°w¶àÈ‰–trV!ΩKÿGÔÚ:LÔ\n÷¢w8NÔñT“)3«–)W≥Ë‘ñtÍ \n:uGù˙s*}‡ü#ù~MN‘\ZDgN°3ÔÂ“áºsËCßÈ√^£È√˘atV¨ùÕ›¢≥	˙H∆?˙Ëiò>ÊhIk_IÁ&T—yÿq:Ô ˙‰¸t¡bw∫ Ë)]p.ú>’√”ßìn”ßk¶—≈ÆWÈ»á.ë¢KöF”ÁL;Ès=Ù9œAt©];}>m8}·€*∫¸s]·\r–qÈÙ•m˙äg1}ÂÃ˙júöÆE—’©ªËk=≥ËZÉ∫÷y}KÂMﬂ2◊¢oOà§o_ΩLﬂE7–uQ=ÙΩ≠÷ÙΩãñÙΩ>ÅæO§–ı“∫~b,]xÜÆ?5înÿæå~$ •ô’—è\Z∑“ç^ìË«ü—OÁ=°õ7}•õÔŒ†[Üô”-ﬁôtÀÔ|∫ÂÔ|˙E…\0›zNónΩiD∑>w§_n~AølJø2¥£€`O∫\rŸCø;î~Ìœ“ØÉ˝È˜âIÙáÉìËè¬s˙„ÛÒÒ™˝ÒY4›ûAwlòKw¥÷–ùæ–ùÀè”ùÖ«ËŒá&Ù\'ø˙Sp˝uu2˝5TBΩGˇdLw-˙@w-Ì†ª\"f—]G∆–›ø›Èﬁ‚›Ùœ=œË_æŒÙÔÂcË>ã|˙üe%˝/ÿÅÓáé”ª>*°k%:dÉ[8BâÌtS‚`¢RîsE) µPä?nRJâyJŸÏ{J˘(©R˛hçíﬁ*©ôî‘ŒâJ¥BI€LQ“õ£îLAêíwO…ıÑ*˘ìSî*¡\\©\Zì™TÕ^©TEéS\nf†Rx≤G)º÷Rj)(µGnQj˜?U~≤Z9‰ $•ÆÁ	•û◊]•ﬁïÛJ}” ¬eÂHÕKÂ»9u ëØãïF/é)çÅ≠Jc;{•…‡Â(ÛzÂË„≥îc¥w+ÕÃ+ÕºïÊ&?îcy•r‹îÒ q·Ä“ 7Z9˛{ä“ö¡î÷6˚ï÷Ÿãï6±oî∂˝5 â™ïœÖ)\'<W⁄0Jªˇˆµ{Ï§ú|§A9sSN}RÈ4SÈ$+ùúW:ïV:˝;£úvl±rZçôr∫5Æú>uê“µ®LÈz~ü“ı√OÂ√ô œﬂ(gΩ2W∫ÀW∫7≠QŒ	ù§ú≥3A9∑ërﬁsZÈl°\\ºgÉrÒIÂ‚≤≥JoØJΩ\\•œ∂©J_ü7J__c•ÔnC•ÔëXÂ“Â eè≥îÀæ∂+˝˙Ê(ó√◊ïÀãF+óﬂ»TÆµDπrpµ2HI*É€ï´\'(Wo^Ø\\}œ_πF∫Fí‰¨˘Ó£U_QÜV µ	2Â:QÆsÿ≠\\7”Iπ·Ì^eîÏárS¿wÂ¶Uïõ˙ﬂ(cƒ) òÎ≠ -ö<ÂñﬂØî±fWî[ß}Qn{F*„>)„Å• ¯ëwïÒsü+„#bï	“m [@πù;ß‹æÇWnOﬂ¢L|3Iôƒ«(ì\'≠PÓjÓRÓ¶?+wJUÓKKU¶≤ îúÖ 4—seZ˘e˙eceó≠Ãòh©Ãÿl®<4∆Qyh}äÚPÎBÂ·†C √Qz ;eŒ‚√ #V± £í1 £ˆ6 £eWî«∞JeÓ\"oeÓ[©2/(SôüZ£ÃøÑ(OåŸ§,Pˆ)úïß&¥+OÕ«ïßé7+˜¨Wû˘1HyV¨<´=Dy÷h°Ú¨√/eÒ«HeâzÆ≤df´≤ƒßZYt]YÃ*œΩß<wy©≤¥€Ly=•,#ü*À¨o(/^∆îo~SVXË*+∆>Q^“€´º¸cïÚJÙ}Âï¯_ +/.*Øt›RVY∂+´‚ÏïUŸØîU]î’ßieu€ÂµÇ O£îµÓ§ÚñÉßÚ÷ÆÂ≠7î∑«q €√î∑≥T €\'Ãîw$m ;π§ÚŒõ≠ ªÀó*Îlbî˜VˇÁiôÚÅ°û≤ÒÎrecﬂiÂS@Ÿ‹ÙD˘Ïòã≤elõÚEﬁMÂÀÉîØé+îØŒ)_Ω˝Æl3¶|=\'L˘∫\'W˘ˆ‰!Âª™Be{h≠Ú˝ö^eá∫RŸ1öSv“˚ïù≈’ Øï«îﬂ˛ÏW~?>OŸ5E•Ï˙ÆPvCÆ Ó€— û®≤wÚÄ≤˜eÇÚg‘`Â/ﬂÀ ﬂ3(ﬂó*ˇÏU˛K g\0¨ãÅfœaêïØ§M¡`€Ø3“•µå4\'çëπ√»7Ÿ2qÉQ0…å‚X:£4π¯ﬂ•0JóiåÚ„Ü›3öa;„ﬁ©åQ—˘åj˜HFÿñ…h¬„ÕÉﬂåñ«dF[]«h˚{3⁄œæ2Éú3:£õù%/ô¡g62Cú\'1∫FûåÆŸ4Fo«;FØ2ö—{0˙	⁄å~’)∆¿•ûñ∫í1t\\≈˛˛Àå∏ÚèÒ˙c¥Ù<c\\Úò1ôrç1I∏…åZﬂ¬å^Ûé\Z¡ò∆|g∆ƒÓd∆‹ÀX$Ïa,«ºd¨.ç`∆{…òÒÀ{ôÒyïåu@c≥/ú±ìüd&˘⁄3ìB¥òIÏòIô∑˚0∆˛p,3π5öôi1iÊÃ‘ÀŸå”™\0∆©Í„‘Ùìqz¸çôe¶ï}eú”≠Á2G∆ÂÖ;„ö;Çôπn3À¯:3;ˆ3Ôx!≥`ˆtf¡≤fAÊb∆cÛ(∆3j„˘K¬xç[Ã¯Ë1>W2_c	„koÕ,›™œ,m\r`ñ˛˝√,[Ÿ∆,ª˜ÅY÷Ï §≤L@])≥r{≥J4åY’Ó√)L\\&8∂á	Œ?Àø˙ŒÑLôœÑ’3!±ﬁLH˙.&‰ê.“b…Ñ˘1aVQLXÎ&¨-á	7ªœD|_œ¨{ÿƒ¨kÒc÷}[√¨7∏√Dd\"C\"ô®’áô®üWôçC≤ôçôçU€ôç≠∫LÙë*fcœƒD11gôÿΩÃ÷Ö9Ã÷˜ıÃ∂!µLú£w0òIH∫…$dï3	ÁıôÌÔLòƒ·L‚+]&±ªùIäáôùÕ/ô]IÎò›cÜ3{îÀò=Ôv3˚Ÿ3)h5ì≤„ì÷çIÆ2È°£ôÉN2A9LfÛX&K˚ì5\rg≤noc≤#F09àìcR…Y=Ç9rm	s‘Ê\rsÙoìKúer„€ò‹õrÊ∏Ó&Ô\'&ØR`Ú^OcÚ=_0\'∂OdN2µÃ…¥≥Ã…úçLA sÊîﬁÊÙø°Lë—¶»J¬mÂò3¶8sfâ#SºO`ä/¶0≈èø2≈¶3ÁB&3Á_˝`.–˚ô/¸ôÚ}QLyÁbÊ‚πL∂ô©¯&b.Màg.≠ÆaÆ§ÕaÆ\\ûŒT.Ã`*ÀÂL’˛≠Ã’Â4suá/SΩ˙\0S˝zsçµcÆ≠<À\\ª?úπû–œ\\øòœ‘L:¡‘ÏzÃ‹ ˙òL\"sÉ›¡‹Îcn∫ÔdnVG37_52∑\"ß2∑øÏeÓÃ=√‘eª0˜Ü,eÓù}≈‹O˚À‹ˇyòy÷¡<|-gÍı/0ıëL˝ª≥L√íi¸9ùi¬íô¶_˚ò«C‚ô\'’3ôß\'äôÊ£ùÃ≥€Oôgøæ0-ÜÃÛµïÃãã+ôóKó3/S∫ò6°Öy}?ãy´<¬º˝råyßqa⁄€Õò˜sLò˜\rπÃá•∑ôá2ôÁMôè\\òéΩ˚ôégôéwFLÁ|Ûy«\0Û%Aó˘r»Å˘íK1_SqÊk)Œ|c1ﬂ∑cæø»g∫ÃÆ0]ï¶˚ ÙÏ•ôû””ÛcÛê˝Á.Û´<ÛªÒ Û7©ö˘{ﬂô˘÷∆¸kFô≈Cf†¢õhÒb¡ª2Ú9…B90]>ÀBø√X∏Í(ˇ~«\"øñ∞®„hã9¡bOo≥∏{<K Ω,ÅÎ≥ƒ2/V4Ó+9 g•~«X˘/9KÈG≤äÜ◊¨‚Ô2ñ6Ófiì,Ω~´¥R≥ \rÀXÂë4ñ9|ÖeæØbπmYïI#´ö=éU\rÿ∞j£PV˝q+HpVK≈jŸ˜∞ÉåXù°8´ì|í’È4a{¶≤É?g±C‹eÏê˙ZVWsï’5ÒcusQV∑‡´7Ãú’∑S±˙Æz¨AÃX÷†∏ö5Ëx≈\ZZﬂeá∫Ïp•;úãcá_≈é O±#,›ŸÏàªÊÏH≥´Ï»¥≈Ï®aŸQ7è≤c⁄\'≥f∫Â¨YGk>\"Ä5-∞Ê6Ysá}¨eÕé5y¡é5£ÿqçŸq//∞V#CÿÒ”§¨µ≈÷⁄k=k}y%k£Á¿⁄òf±6yZÏDœ÷éù√NZ±ì∂ﬁe\'5d\'ı}dÌÈuÏî·(Î‡ΩüuÇ÷≥No&≥Œ’_XÁsXó–ÏÙÛ~ÏD`›N=a›Œ4≥≥è›`Á¨ü≈Œi∆Ÿy+∆≤\nBXèÏ¢c∑X/Û≈¨◊Rû]Ï‡≈.ˆ `ΩßÁ≥ﬁ\'◊≥KÜ·Ïíˇjø‰õ¿˙jOe}GT≤æsKÿel1ªÏª7ÎwCÕÆ¥¯ŒÆúgƒ%¶≤¡”≠Ÿ’€\rÿ’ÁzŸ’ı%Ï\Z∞ñ]ì§bC¥kÿÅ\r€∆ÜæŒÜi=a√F˙≥a£´ÿpìR6B±k€ø∞ÎæG±ë≤f6≤B√n¥œa£m˝ŸhO6:d;ìö≈nn©c∑xx±[€æ≤q»6Ó¿s6.o-õ†µàM“Mgì.ù`ìölŸùÿ-vg˙R6yRªÀ{2ªÎ¬vœöCÏ˛ÌiÏ˛ÍkÏ˛⁄B6u¡^6u◊&ˆ@Î$6m√y6Ìr*õqQ√f¸⁄¡fBﬂŸÏˆClŒÃÌlNÜ9õ”ÎÀqÉ=:a9{tÓiˆhJ>{ÙM{li {l≈;6◊d){<˛õ7^ƒû–∞cF≤^ﬁla’hˆ¥Y\Z{:`œ\0/Ÿ≥´è≤gøj≥≈éÿ‚?ŸíÇZˆ‹ñ≈Ïπb[ˆ‹£”Ï˘ï3ŸH[û¿ñﬂèd/gT≤ïr∂r»y∂™Y`ØjØdØ]ËdØ˝ˆaØOπ√ﬁêG≥7‹ˆFH={ÛÏjˆÊÄΩ£Œ÷âó±uVWŸ˚T{k{ˇT%˚¿‡2˚¿‹Ö}∞ˆ˚0<å≠Ôiaπö±è¢|ÿGÒèŸGÕüŸ«öüÏ„∑¡ÏìA9lsJ€\\πÇ}6Øê}∂–ÉmπSÃ∂<7düLbü/∏«æ‹7Ü}yr<˚J5ù}µÀÇ}mn√æﬁıÅ}Û…à}kÔŒæõ2çmosf€äŸ˜∑~≤=0∂√r/€y·+˚	òœ~™òÃ~ﬁªÄ˝RZ√~’hÿØÓ9Ï◊$ˆ;|à˝Ó¸Ç˝>aª∫«≤›Âylè•6€„QŒ˛òö…˛Ãü∆˛ö]¿˛∂\ZÃ˛â`ˇ⁄{≤}6∞k‚˛ìŒ˛}Ùù˝€d¡ˆÈ≤}—qlˇ¸j∂ø‡,€_€Õ(-ÿÅ;˚9¿ÎlÕÅπ$≠ÎÊ†¶\\Xƒ!∆w9d<¿°{Ì8ÏÏsé2Ç#¶öp‰Õ/úxµ)\')7„§Í©úÙd\Z\'”‰q2Áéñ0úrPß¸jœ)˚påÀ3é…;œ1Mg9Vg«æ±‚8Ûé˜› Òq|]ßRp™∫5úÍa6ßn≈	«9°e\ZßY£‡4ópN{g7(ΩàtÔ0ßc◊Ã\rÓ ·tcÍ9Ω3çú˛îóúAÛTŒ‡K7Ùnÿëè‹P?nx£7bò=7¬d,7“$ây©ÅY´ÕçlX¡MÂåªóq&—πQ¡ﬂ∏Qmâ‹Ë]nÙÉnÙ£∑‹Ë◊≥8S∞õ3\r.‰∆4ØÂÃ/ç·∆®∏qmΩúÂ∞Cú•˘BŒ“—à≥‹¬Y˝9«çO)‰∆ß˜qZ-8Î°úMƒ!ŒÊ`$g˚‰7±Â.g∑•ÑõÙtgoQ MŸ¬Mˆl„&_≠Âû‚¶ûç‡¶ñˆsS+hŒ…%ãs⁄R«MSdr”¡úÛ,_Œ˘ÒŒ≈Ú87òÃÕx…ÕxtúõıÁ7◊`	7w‹DnÓ9[nﬁn^Ú1næL‡,∫√-®Vq°…úGÁ.ŒS&Â<ç·&*πÖˇVsãfqﬁcnrK<‚9ü£Õúœ[äÛu9ﬂ›0Á˚–õ[\Z,pÀnŸr~z‹ÚC∏Â?,8.ÄÛü8âP\'rÅ+>qÅ´,π¿}π¿œ2nï˘&.Xtéë‡B&«q°õãπ–¥R.¥±ê[Á-„÷£Áπıπ?∏»	O∏®hnìwc·¡≈L‘„b~≠‡∂¸ö»≈∂∂q[∑ø‡∂˛´„‚¢√∏¯ø˚∏r,óêÔœ%ﬁ]∆%Uù„íu∆qªT∏=Nô‹û;K∏Ω”r˚íÁs˚˛›„ˆ\'çÊˆ_ﬂ •Ë{q)π•ó∏4>ÖK´À•”7πÙÿ≈‹¡ßw»N…eâC∏Ï?<ó37å;·ÃÌ(ÁéÈ+πc=‹Ò™[\\ıÖÀª”…Âœ^ÀÂœÂ∏¸]Áπ˚∂p\'Œm‡Nù√ùºZ¡ùÏ∂„\n∫∏¬>[ÓÙiW‘aœùvsgéø·Œé π‚Yπ‚®≈\\â[WR±û;Á†√ùÎ> ïÇáπRË5WÍ9é+›˘Ä+ΩÎÃï\r+· ¶[reØèsÂ~∑πãÛ~pHWAÁsófusWorï[™π Øk∏™ƒ‹’¡π´«⁄∏Îèìπö≤‹çá4W;6öªY{ÑªìÌ¬›UqwÕNquh&wOÕ›3bπ{ìØr˜l‡¥\n‹√ëΩ‹√9g∏áQW_îkx¥ë{t∫ïk\\˛ûkx¡=+_…=ª\Z√µ,‡û3bÓ≈˘2Æµg?˜“‰\Z˜2·6◊v⁄òkªYÃµøÂ>¿\'∏ciÓ„l◊1]áÎ¥ÌÂ:›pÆ”›ü˚πä˚¥u5˜ô¸≈}…tÁæñŒ„æ\'vp]ñìπÆC◊’πóÎ÷™„∫+πûgø∏ﬁ7<˜ÛÄà˚ôâp&πq˜õrﬂ8s}ÛÁp}âØ∏⁄Ñÿ∞Ø„ÅÛ!<ËZœCRñá.LÂ°Gz<‘Qƒ√w	5‰Qâ	èˆoÁ±ßn<©Ûò\'G›ÊI˚\"^4§âm≤‡E{Ùx—√øºÑ Ê%ÎNÒRÔ^öSÃKîÛTFOïÚ\nx4ØàL‰˚˚xEIOÔl‡ïçsyÓ√mû∑ÌÁ’Òõyı·gºl=ØµkØU\'‚çôœ _≈Î÷Û:s¯¡©?˘¡7Û˘!G∂Ú√NöÛÜS~ÛÜßµx√2~¯⁄_¸óL~ƒû ~‰Ö{ºÒrÑ7I+‚M:„¯QFÛ˘—±∂ºÈ·ﬁ4ÁoZìŒõ>ÿƒèô∏Ñü¿è©Æ·Õî∂º˘Sﬁ¸€pﬁbzo·kÃ[Ïi‡-uüñWŒÒVÍ8ﬁjl\"oı·	?˛f??æ-ùüPnœ[∑o‰mjLy€†ºÌöwºÌ)Åü=õü∏%ü∑õÛÜ∑œû≈OœOôY¬O)∫À;‰◊éß“¯©3™˘©Ωs¯ié)ºÛñHﬁeÏ-ﬁeúÔÒäüÓ÷√ªöó3Dã˘y•¸åßC˘ôc÷Ò≥àj~÷~V/¬ªπé‡›2Í˘ŸÛÓª¯y-n¸|ØÕ¸¸⁄K¸ÇÔ◊¯Ö˜£¯ÖœÒ^[C˘≈\'GÛã+\'ÛﬁN¸íÈû¸íwJﬁœ˜ Ô? Ñ˜ü¶Õî‡~[Å÷#¯UóÀ¯`πø:`øÊk8\"_œáá!É¯êo/˘PlzÈvΩÇèl·√œLÂ#bı˘àg~¸ZÏ9øÓáÑ_ˇ/©¸¡GÍ¨Á##ˇÒQ_\n˘çÌ˛ÇﬂT^Õoju‡7uMÊ7GfÛ[v‰∑4˘[ÊÚ€~·∑’¸„„®,>n¯A>Œ<àèK‰„÷Ê„„É¯¯ÚÕ|‰Ãoß+˘Ì„”˘DÖ+ü¯˛6ü ÔT%ÛªB”˘›¶3˘=∂¸^Ú øOÂS”ˇ©-˘¥ëÓ|ZAüV˝ê?‰U…g˘ÛYe«˘¨ü—|∂√>€Ì4ü≥v	üSpïœ©ÁèiS¸1◊w¸±U:¸±2>óµ‚Û.\'Ú˘∑´˘¸\'w¯¸ø¯zñ¸â€˝¸âÔ˘Ç*æ`õ_pm_8ú/h…ÂOm„OΩú¬üÍ_¬÷GÛß”.ÒßK~Euï|QgI„œ5¸Ÿ¸%¸ŸŒˇ‚Ø	¸ŸÅª|q˝;æ$2ì/)√ü{_ _àj‰/4M‰ÀL¶ÒeG\0æ¨!õØà€œ_äëWvﬂ·ØÏµ‚Ødå‡+ŸNæzjm˛˛ZG›ÖÁØgÚ7¢b˘[-e¸mÈ`˛vsgxg¬ﬂ≠èÂÔ\'UÚ˜ªÛVŒÊ.;œ?,œ◊Ø;Œ◊ªŒ7Ãÿ¬7‹~¿7≠úœ?÷∆¯\'é\r¸S˘`˛©*ìj9ìo∂H·õùÜÛœ\\øÛ-≥ª¯ÁU¸Û˘=¸˚/¸ãÈﬂ¯÷9|kÔ:˛%Ò/ï#¯óª3¯W©„¯6~\"ﬂfÀø¶œÒØUoRÒosœÚÔ!}˛}˚;˛cˇxæ=»wV€ùm¸\'^Õñ«_˛<Âø∂À˘oå˘oˇ|¯.àÔˆö«wGÀ¯√¯G_ÒΩ∑_Úø&zÛø<_ÚøUy¸o„—¸_√ø¸ﬂæÔ¡M˛ﬂ›˛ﬂ\'æ…˜kU˝«Ú˝≈Û¯’y~‡àFËLVÅ*pëΩ\n‹0DnvRÅª›Uê˚_Ï‰ßBÔWaøŒ©¡WU¯·ª*º‹QEhÃTƒ{\\%ﬁ˜\\%…Æí‰;´‰¯oï|îΩä\n°Täñ*⁄<LE{9©î£‰*¶dÅäÂzUÏßó*ŒÁ∫J5ºP%0E*·hÇJì)RiN<SiπOUi\'ùViWó©¥Ô˛RÈà©t&˝lP\r∆ΩTÉµN®ÜLø†“uü´“K5SÈΩ¯¢“è|Ø“ø`¢2ª¢\ZÒÀ_e4|∞ ÿb≥ dEôjT ’®Ãt’®÷’hπT5⁄ãVçé“Sô^ÀWç—éPôKRTÊmTÊ¡∑TÊâ›™±K.©∆V$´∆%IUñ»ïeS† Ú˜|’¯’¯∂ïµÕ~’DD¨≤ßpï˝•j≤ﬂN•©êç*á [ï√—4ï£≠Ω ±∂QÂ¯}ãj™ßè È∫ZÂÙ‡ô Èœ’4Ù∞ yÏ9ïÛ¯C*ÁîïÛëY*CΩˇ˛ˆó©¶«Ö™¶7æWMËVÕX8_5s¯t’ÃQÜ™Ÿµ∑TÓÃjï{ÓLï{…Bï{Eûjéq˛ÍTs |UsZUs~π™Ê¶æQÕ\\ÆöÁw^5ÆΩj¡ï˜*è;ù*œ#üUÁæR-\\ÙQµ∞Ê¥jQÊ?ïó·c’‚\rÁUã”é©üΩ©Z¸ﬁCÂ}!Dµdﬁrïœè*_i• ∑√Fµ,bùjŸV=ïﬂ⁄µ™Â#“T˛Tï*ÄTl<ßZyÔÆ*îÉ*∞8^µ™πY4d@ºäS≠>w^µFÎª*d”2UHB¶*TKÆ\nç€§\n®¬\nT·¡Uk;W©÷´„U∆\'®¢º«´6\rÿ´bæÛ™-Õú*∂‡™jÎ/’÷™<U¬©o™ƒäf’éò4’Æø™›Ã8’æ⁄•™˝McT©≤›™Kf´“Ã®“\"´“µÛUÈ´#T√{TO™,ˇ˚™lÍ±*;»Wï≥ÛΩÍËÂ—™cU^™\\≈Un*≠ }xTu<∂FuÀVùt_§*Xfß*(π¶:ı_ü∫ı´\nÁÏPVu©ŒÃUùm∞Tõ˙´äÎÁ©JNf´J*Ø™ŒuèSïÂ\0™Úíõ™Ú&µ™º{éÍbÉõ™¬`™™bÎ0U≈ﬂv’%+Pu)©JuY∑[uŸ4CueÃ’ï=Å™™Íâ™´>a™´á“T’˛_T’™kCÓ™ÆM\\£∫û>Zu„÷YU≠Ê¶™÷oõÍÊÛ’ÌE™{œá©?Q=»˙™™ﬂß™œ∫´jXí©j«TMFI™¶Ïü™«ãtTOE{TÕâ≠™ñó=™ñÆ™÷KìT≠Ó´^Üö™^fß©^˘f™^≈<QΩ⁄˚üO\r™6◊™∂ΩœTo’ô™∑Ûó®ﬁ-|•zˇ—Uı¡ÈÜÍ√¡`UáæΩ™√›[’9ìTuÓfUüL©>ÔY†˙\\Ú[ıπ·îÍÎøq™o\r#TﬂûœTußö™∫[8UOÎL’è˘ë™â±™?ÜOUq’üÀTSı≈´Ê~W3F©œ_j¿˚º\Z8`ßü™¡Ôfj»ÒΩ\Z ITC«é´W#Éß®qG5qA©&^T©E&jq∂F-s|´ñ˘åSÀÒ˜jπ¸ØözW¢VÃ\'’äÚõj≈GïöˆLU+ı™ô˛}jñ™9\'µj§ÉZpÿ´f5©Ö?µv\nßdªD=®N_=ËqçzÊ,µ~„jµABµ·ı%uÍ·A:ÍbCıà·ÖÍEÔ’#ÆÓRè4œUè|rFmqLmtF§6ñNUË´M‰ﬂ’&i\rjìW’£?™M”ñ™«òPõ7åS[ËSèÖ?®«Èy´«ÓVè{˚Hm9a∞zº˚<ıÑ)>jk&Em=[_m≥†Qms˚™⁄ˆPôz¢˜ıƒ£Á‘v£ø˛ß[m•∂ÀPO⁄ıQ=˘@èzJBàzJªß⁄AæK=’òUOùµR=ı¯\nµ”ƒyjßmMÍic⁄’Œoﬁ´]¬„’3GæSœ‹Ë¢ûô+Uœ>4\\Ì>˝ä⁄}IÅz©Á§œTœQ®û;w±zÓ∫≥Íπù∂Íπ3’Ûû”ÍØ6®=_4©˙.T/≤˜V/⁄+R/∫ı]Ìµ…TÌïY™^Ï⁄ß^|B≠ˆv>´ˆﬁ¥EΩ$…^ÌÛ$CÌÀT™óRW‘Kw⁄©˝2•jˇìê⁄ø„¥:`xñz•j™:P.VØ ÏSÎZ´Éè9™W7Ñ®Wø‘k◊´C¬≠’!y.ÍP≠ˇË‹VáÁ’k\'üQØã4TØªJ™◊G|Uopx†éZí¨éÍ–Vo\\j¶ﬁ4Û¨z”º°ÍM˘\ZuÏ·BulÅá:ˆ«0ıVÉı÷Éˇ‘q≠Í∏\'[’Ò‘Iu¸ºÍÑÂŸÍÌ\Zôz˚V^Ω„—IuíˆıŒÖUÍùóc‘…CN©ìﬂQÔ˛Ôô˜8®˜xLVÔ-çUÔ;V®N1ï©Sø®S˜ûUßæõÆ>b§Nox§>®ΩUùQ4R}h«|ı°Úvı·#+‘Y°zÍÏU6ÍúA˙Í\\ÉÍ„=À’y!fÍº›”‘\'6ª©O<;¶>˘˚Æ∫ 2Y}ÍÒKu·Âhuaáµ∫Î*ıÈC‘ß˚›‘g¢ıYøu±c±∫$⁄S]“›ß>Ø™œø©/¯lTó≈∞ÍÚñDıEø`ı≈∑Í\n˝Hı%’9ı•ã—ÍÀ≥≤’ó_æR_—9£Æ,2S_≠ª≠Æ~Å®Ø[[®Ø˜«´oLQﬂà[™æq„∂∫v£æπ|ø˙ˆ¬\nıùc’w˜W®Ô%g´Ô’_Wﬂ≠£~`Ä®rÍé∂ÍóF®<Q?ºØßÆ◊t™$YÍÜ%ø’è÷È®ø£Í¶7^Í«Hç˙±d™˙q¨~¢wO˝‰ß~ †Íß”Á´õüf©üﬂ’Uø®Pø‹ΩM˝joê∫çXØnÎ0RøÜn´ﬂ4j©ﬂæ˜VøÀËTø´∫¶n_∞F›~tà˙càç˙„õ u«@Ñ∫”ÛÜ˙ì~≤˙”Ω{Í/\'™ø¨Ww9˚®ªÃW˜há©{“∂™8mQˇtú°˛πƒW˝kÍ^ıØ=S‘øÕ™ˇ,ÕPˇy˚Q˝7Wåú≠x/QÙÁ¿ƒ2|Í †ÛF	ËZB¿r;k#`◊◊	8¯C¿«#„<oäÄøë	$≤L%Â‚FA≤…GêjäŸÙ{Çl÷\'A>£TP&8 Ã”ªe∏¿ñºÿs\nAıŒ_Pﬂ\"®œåÑø\"AÛË§†µ\"L–ûD⁄·Â¬ ´RA«;EBÕÜÍÜΩÜdäÖ!πwΩIÉΩ˚ÖÇ~—-Aˇ›Z¡†d∏04Ê™0Ï„G¡–Ìà0<A_~£GﬁÄ\nFñ≥£–wÇqe°0Í¡r¡å€-Xh∂c∑•\ncwπc€¸ÖÒcÍÖÒ˛¡¬¯3fÇı÷Ççæë0q˚pa‚˛RaR¥û0©+^∞|{GZ∞üµY∞o;*Lﬁﬂ.8\0üÖ©·K\'—\\¡˘≤HòÆ;Nò°øSò5Ò∞‡V˝Hp´	fW«sºRÖyV~¬º›¬ºÀWÑ”<Ö\r∫Ç«∏\"¡ìô.,∫ÛE2_\'xu7K»GÇÔøÈ¬≤–$¡ü\\/¯Î•	Å:Ö¿Â3Ñ¿¬ıB‡Èo¬™áà4£W∫˙S™’ÇÒ_Bp£Ø∞z“auÈaÕÖz!DàB·D!t√h!4≠A=ˇQ€V-DDâÖàl+!¢÷n¸&¨Mq6\\6\"ÂBTøFÿpTÿ4·Ä#9&ƒ	1˜“ÖÕÊÅ¬ÊèÉÖ-„Ö-2Ö≠\"Ñm©ìÑ∏a·B‹¸”B\\ﬁ8!Æ+Càü8_ào/‚{DB¬~RHHø*lüï-l	âYÁÖ˚ZÖ$«óB“l7ag»waÁﬂ·¬Ó?ˇÑ=ÎW{\n˚çÑÈ_!e!§¸÷R\rçÑT=!uŸ;·ÄÏíê&o“Ÿ	g˛|#dÃr2¢!cœR!„∑ãê©Ô%dñÀÑC°ìÑCÎ”Ñ√+:Ö,€OBVJáêM8	Ÿ1£Ñ#1OÑcs{Ö‹QÀÖ‹5åp|ÓX·¯¶Z!Oì˜ü!¯Z!ÕQ!?!Q»OsNoN‹bÖSnWÖB3s·å…·ÏøQ¬πqB©˘&°Ù›r·¬ìsBôAúPˆæD∏(	.Ó9\'\\º9_∏l6K®\\ΩO®∫í(\\UØÆ˛Z(Tõò	’ü˜◊Ÿµ¬ı≥2°fr¶pjnÃlnDX	µ£,Ñ⁄Óµ¬-˛∞pÎ˘r·éR$‹Yr\\∏ì(‹Ed¬]°nÿp·ﬁF\\∏w⁄]∏‹W∏gèpˇõ\\x∏‰æP?°U®ÃÍs?ıÂûB„îBcË\'°±ÆOh\ZºRx<∆Bxj7Dx∫bπtOì,€UhY¯Vhyn$<ﬂÌ*<ø„+º–€.¥öÊ	/€\nØ8{·ïS∑ÍkØ–6cÆ–v-VhÎﬁ,ºÒoﬁ-ˇ\"ºkù ¥áB{ïè~Ÿ7·CØÅ–Y)|¬>\nüÃ√Ñœˆ\Z·Ω@¯:Û∑M/G¯6)B¯ÊµJ¯ñ2Q¯v-HË\ZÛ@Ëæí$ÙØzﬂ0BÔ◊.·gÚ·◊Së◊UGËªY.Ù˝›!\\ô®F}”\0ŸQ\Z†vßxÛOöòk¿Ì\rdÿØÅòj‡Å\ræJÉû≠◊†Ô^ha\Z¸„\'\r9®L#⁄æQ#ÒH#M∫Æëov—»Ø5h‰OfkkÛ5¥ı~\r]sH£TO’(”?k∏—75\\3¶·>Œ÷˜M4¸≥_\Z’Z-ç™◊@#¸M“hE´4:⁄„4:/Ojt:?h?◊◊ËEFkÙˆN◊Ë˝iÙ5Ωïö°NrÕ0JK3lÃ\"ç·Á1ö·•+4FÙç—Í∑\Z„£ÌöQSÕ(ÁQöQ◊M5£~÷å÷\Z™1µ≤–å	ü°≥~ô∆,Ëé∆<‚Ω∆|Sé∆¢CK3ˆ@ùfúˆrÕ∏K±\Z´§ß\Z´“yö	}C4÷IÔ56\r5v∏õ∆Nÿ©±k\\´ô2ÙÄfä€Õî≠Î4{-5S√⁄4SÛM4N∑çsÊçsuØ∆Â/£ô.≤÷L‘\Z◊˘K5ÆûöôLêfñƒR3k–gçõßqQÆq€tT„ˆ|¨f∂ÌÕ\\ÙãfÓ§ßö˘GAÕÇﬂó5œ”4Ôº4ûœÇ4sfh˚°ÒB≤4^É5ö≈V;4ã£ÕíŸ¥∆y©ÒMÿ≠Ò€∞S≥º|ΩfEtåfEºø∆ˇ‰çˇ[ï&@{ü&¿iµ&†ßC≥“˙Ñf•„}Õ •ü5+≥ﬁhV~]§Y5Ûàf’ºRMP*†	Óx°Y≠ø˙óy8o«ë≠ÑQ˜Œ‹πsgÓ:wüªI®®î(JëîB®Dã≠ï6!R≤fßRJˆ}ß\r%T$K»“Çh°¸~|ûÛ>œ<sﬁ˜úÛ=3Ô!]7A8ÍPLº˜è‡Â9N8ëuì‡≠EQÒ%¯¸åR˛Ø^¸€Rßﬂ8N]@8ÛPópÊc·ÃØ=ÑÄº B@Á,!`ˆ!m?·‹g=¬˘€\rÑ∫ΩÑzŒÑãÈiÑK‹ıÑKM¬Â[.Ñ´øéBﬂ◊	ÑPDâ~æòp˝„#BÑY\0!¬“Çp√£ñp£7ü•ÁG∏ÈvûpÛX·ñ¬BÙÂÂÑ€/ﬁbñ-&ƒ@9Ñò‡çÑ¯ˆ+ÑìêêùGH¯öIH<·KH,p%‹ãwíìwf>íñÄÑ§¨lB2÷EHŸrçêÚ\0$§z»Rkæ“„MV€	ÛnÑ¨aòê5[K∏+8C∏ﬂªï¿YDxH–$<t[DxË•Hx¥Ãõ®›ò8?ö∏céê´™F»-˛E»mÒ%‰CõÖ¨ıÑ¢§ÔÑ¢6SBÒÓvBÒŸïÑóBI˜jB•¿ÄPù~óP›oK®=âPw{1°Ó’FBΩE°˛ÃB}-É–p±É–ê¢Ghî&45|$<ÛÙ!<ã¸Bxq‡·≈£¬Àˇ„yY:Fhnr\'¥‹‰Z≈iÑV˝aBÎÓXBk¡,·ïs\n·’ëœÑ◊÷ﬂ	Ø˜)⁄JÑ∂πÑˆîÑéêœÑŒ%#ÑŒàMÑŒ,+¬[b°K§OËJﬁEË6⁄GË.∫JË>FËY]OËâm!Ù‰∏>&—Ωõ	}>K	}Oç	˝«¨	πgü∏\'	üD◊üéü∆ïü˛Uó∫≠.£ﬁÜvÜ5¶√¢€Ñë‘£ÑëØuÑ±Á	_á	ﬂˆÑÔûEÑI%?¬$„	a“œò0ÌNòæ«!Ã»Ø&ÃYM¯≈\\J¯N¯5–@¯]XO¯s˜\navã0kÊGò›WBò{ç˛ y˛]$ ŸGÂZ\'àÚÓôD˘v*Q¡Àå®<†@\\®ªè∏0≠à∏CQ-v\'Q=%j~k$.Ÿ´J‘ö”!.›ïB‘~F&ÍHéu¢^uÜéuŸoâz´àzy·ƒµáà+~>$Æ‹~ï∏ÚÖÑH\\mH‹¸à‡æãDH¸ãçπ…À\\âd‰ër~›ŸJDCó©o	D:˘n<!2‰úâåì£DÊΩ=DÃ‚\Z+\'±\"ˆ#è»π˚Ö»…6!ÚÊlà¸êi¢@Gù(û!‚ã_qm¢»«à(Ê√D±ù(Ÿ=EîÚé•›ÜDYÖ?—@N4N\"Æ≈\rÑç¥©D£ïÛD#ÉZ¢q:qÕØ@‚:´‚∫ö¢âh\r—‰Ï\'¢È¥<q˝Õn‚˙Rú∏~‹á∏QEÉ∏q	Åh6–C‹ﬁK‹|D@‹¸µü∏˘◊;¢˘∆ıƒ-Í%ƒ-E^DóQ¢≈%¢•È—Ún4q[V&—ÍùhïÍA¥i∂ ⁄n¯L¥ã0\'⁄çLwÔ∫E‹›øõhŸN‹≥b%qèì*qœº\"—ÅÀ#:\\8L‹wWçË∏iûË∏Â—±áJt⁄ÍDt*ã#:õÑ]û \\˝çË™~ñË&¨%∫G €øë\'çxLÙ‡Ω<NΩ˙\rà^ì‚±7ΩƒcÌâ«˛-#û¥˜#zﬂﬁHÙ˘yáË{≠ÑËµÖËˇ\"û™ä%ûÕâ$ûùp!,8Gÿ±ó–4@TπA‘»#ûS%û[≤Öx^=ïx˛¥-Ò¬‚›ƒ\'ƒ‡¸\"bÁ)‚≈∑ıƒKÂcƒK˝äƒÀÀp‚eÍ!‚UÕibËÚlbË%gbhÙ1úìCÁé√Ì\nà·∑ˇØÔ<EåæFåt=HºatäU˛ìx≥.íªQâª-ûÎAå”ˆ%∆ô˛!∆9ù!∆Ω›BLÏ|AºSÎEL∫◊GL*ÿOLﬁDL~˛?_Îà©nâ©œâiGû”.i3÷û\'fx†ƒå/õâôÜƒÃΩπƒÃ£µƒ,£ÕƒªWà˜ˇÂ≥W∏≥7<$fWπ¿˜à9¢Eƒì’ƒGyàè/û!Ê˙ü¸àJ÷ƒ¬7tb±ö±ò~óXXC,Åâ%Ù!b…m*±îcJ,Â? ñ\ZxÀ—~b≈ÓNbU¯&bUƒb=xíXœ!÷s˘ƒ˙ö£ƒ¶≥âœÂØüÉœâœØ¸ æ†V_ò?\'æ∞Q$6o|Cl>óDl!x[≠à≠∑uâØ]ﬁ_áŒﬂ∏?#∂≥Ô;Uàù_û¸œ[‚;–Å¯˛N%Ò˝§*±+d9±Î„jbwå±Áå>±g,ñ¯1‘Ñ¯1\\@ÏΩvåÿ˚‰=±ˇt+±?ÁÒìùÒ”(ü8»j!Ÿá=6áopâüµ¬àü9ßâü≥Çà#~«â£¥6‚ËÖùƒ—∏R‚òëà8Æ*\"~±Ï&~m≥\"~{&G¸˛}í8Òn%qR/q“Îqjâ\rqjN@¸q\'Nøú$˛\\nE¸iK&˛Zué¯G\\Bú5&Œ:LúÀ2&Œçkˇı{Áaq~=»Ì\"\nª\nØ\0äÎµ%áq@©˛†4¸Pñø\n®l∞Tºó™\näÄ™˛_@µ‘XxﬁXÙã	®≈ú‘FÅ≈öu¿‚x@}—†Œ‘ÕÍπø\0ÕÂ\0ÕìÁ\0≠ºõÄNXæA–g\0+åÉÅN^\014 Ü]\0p-\0Ïo¿êa\0Lë‡£Î\0)( ï/»m\0ú]PLz 	!ÄË{àg-Ä‘∑h‘sÄzF†æ]–|≠Z–i\0Sc#¿|0?Û\0÷÷vÄ5Á`n7¿º\0∑√‡˘\0_Ô¿gÁ¸ª%Ä Ô \\˙\Z^ªÀø\0¬j#\0ó,C›Äààû£Äd˛: sñdÉy¿*˝?ÄÅ¬5¿‡K	∞\ZrV8\rúåø÷\0klkÄu\n:¿:;¿$«ÿ∏/∞1/0ªµ0gÆÃû¿ñ≥Ø\0ãç4¿r…%`kÌf`€I¿äõ\nXÒ⁄Î“f`ªC∞√CÏº‘Ï€Ä]˚ß\0€µiÄ›≠«¿ÓÂ¡Ä˝+ÿ≥;p»ÃÍúÅΩÀæ{]ŸÄ£|∞ﬂÌ#‡‡8›Œ‚ÅÉ=ıÄ€÷M¿a8<ˇ¿æ\0\'“O[1‡56ÛwN8õ>AÄ/„0‡[t;}ª8˝q8˚øüÛN¿˘Ã> Xœ~˘∏∏.‚ô¿•ØœÅÀ‡ÍüE@»”‡⁄`f>Ñ9L·fΩ@¯ã6‡∫ép}kp˝ª3i¸\ZàL?Dñ~\"gKÅ<[‡∆” JMàÚª‹ÙZ	‹zÈD_KnG5\0∑ã˚Äòéd Vuà%é±œ\"Ä8¬% nj17›$¡@¢$ﬁÒ˚õÅ;‚`‡ŒÈ[@“ÊJ πg9êÚºHi›§ˆ⁄iì˙@∫óê·ª»xt»<K\02œÂôa@÷m?‡ûapÔW	pü˝»&Ø≤∆\0V,\0Æî˜∑9N\'Äú{!@NªH’»u∑û|_\r‰ôé\0˘µa@˛m†`ØPò|(ääÓàÅ¢<	PÏ<˚µ%vÄRÚ#†Lê\rî\'Ö\0UrÄ™˝°@’üd†fWPs#\0®]CÍÆ\rçÈ@cÔf†i…w†â–<•DOÕ∑OÌÛÅßû˝¿ÀsÄf›£@Û\Z3†EÕh©SZÉ7≠◊~ØªÄv€≈@á˛5†c$xkØºıêÔ~Ä˜B†ã.tµ∫Û⁄ÅÓ‡=¯8^Ù6+\0Ω3q@ü\\0–óÎ¸ØáÅ0U`†ú\0åè√œüYKÅ5`‰q;0v+ÀÒ\0∆>_∆Ì˚ÄÒÔù¿°Âh$U^¯*NæÓiæ≠æŸ<&\"È¿ƒÌt`¢Î\"0π±òºËL·⁄¿‘i‡Á√?¿o«o¿ü9‡ﬂÀı¿ºÂ`˛¡;`>ü —ÁAπ{óA˘ùg@˘hGPE(.˙]	™ïAµ7Ô@µëó†˙]+P£œ‘TI5ù@Õ@*®9\\\r.Õpó\\\0óè\0uË’†Û&®∑≤‘£3@Ωh9pÖ‡∏\"°$Ïﬁ©€ARÛ4HÓˆa$D|Õ@‘—§%>i˘ãA∫y(»$fÉLÀœ Ä@6«dª√ ◊k‰fÊÅºœãAÅm$(‚ÓE-(¶}≈7Aq\\6(1>J\nú@…«)P T\0ıb¡U˙∏jö\Z\Z˚ÄÜì∑@cŸu–xKhÏËÆ	Ï◊=◊Í€Åk_öÄÎ∂˚Ç¶Çp}É∏¡˙∏q€7p£„qpch∏11¥X<n5*∑ö?∑3∑ûr∑Üﬂ∑∆õÅVWÆÄ÷Ù[†uâ∏]hn?˛¥9⁄Ó“MmO:Ä∂9õ@˚¿.pœóÛ†É†tx,˜^w˜áÈÉî«¿Ì\Zˇ#|eÅæçÄN∫•†SÑ3Ë4©:Mù˛ùQ\0tôéﬁz∫&2@◊‹‡aﬂ!ùè†ß´9Ëôô\0z-ùè-éè≠æ\n*Ä«è.è7ÊÅ«ªVÄ\'ı+¿ìπd–gµ6Ë≥≈Ùç}\0˙f^˝Ùr@øN{–üıÙ?˝Ùø“ûZŒOèÉg7(ÄÏ3`¿w0∞œR^\nûª°^P\0¿T#B≈A¬o{¢º4∞ºB‹	Ü\\€^;¥\rnØü√¡®Äs`‘\r30™9å\Z/o˛©£ÉK¡ÿÅ€`‹	{0>·=ò>LÔdÃÇwJ¨¿§\rä`“è\r`r∆B0E„ò“7¶_€¶«Ï”;∆¿å‡Ö`&≤\0Ã<uÃJπﬁ”ÔçˆÅ˜O˘ÅŸ“›‡É’)‡É›o¿éY‡É∆ a◊y0«˝3ò[˝Ã≠=>QLü¥ÌÛÙ\r¡<◊80Ô•2òèùÛ„ß¿¸9o∞Ä{\r,ÿ|,pY¯FÅqÔ¿Ç∫`¡ãø`°§,∂\0≥ª¡¬∞p,,Zî-ñãp.X¥À\r,\n˛=±ãy\0Xºq+X|≥,NIãSµ¿‚ÏÖ`Òß∞dg,Xr’\n,âùK/[Ç•y{¡“◊õ¡“Y:X∂ÂXÊﬁ	ñ%™Éei\n`π≤XN\rÀ\r}¿Úu˚¡Úÿ,∞º\0Àø\rÄÂøΩ¿\n≈∞BU¨01+∂l+∂›+.TÇèR¿ä«È`Eç5X1ZV.Ï+Ø?+ß|¡ _+¡*•f∞*$¨∫ôVÂü´~≠´ÊÇ’ƒç`5:VÈÅ’é™`ç¬u∞÷9¨=¶\0÷˙¿⁄Óˇ◊üR¿:\r∞Óﬁo∞ÆaX◊s¨ÎÎft¡˙˙`˝°J∞>“¨OÎ€ï¿˙N.X?‚\r6¨Ã>É\r;˙¿ÜB>ÿPªlò´˝`£C>ÿ¯ºl;6ŒlÁ5¡&≈X∞…Õ\Zl:æ¨4[≥¿ñ%∞%f\'ÿ“ÑÇØH\Z‡+n#¯*\"|ı6|5ô	æ©ÇofóÉi>‡;«\Z˝ÜX˝ﬁc‡˚òﬂ`óJ/ÿΩ÷Ïn›\0~ ﬁ?~K{óLÇ˝æ‡ÄÊYp`I¯âbU˜ÄCñ‡49d\né⁄?G[ ¡±\0ˇËéœÓø∏dÄ_jŒÉ_7É_Õ™¿Ø˘—‡◊Ø[¿oﬁ?¡oÅg¿âú\\ÌN^0ß@/pJÿNÅ?r@pöpú>N˚îÅ”πü¿È™	◊û≈‡Ô∏Qw◊:⁄ŒˆéÅs•/¡óÿ‡ø;õ¡˘ƒU‡¸W_íúB)In;NíOë$$Ö»fíbäê§ÿºò§qè§∫8ö¥»h3I≠/ä¥òwñ¥ÿZù¥¯å\ZICI“8í4\"à$çöﬂ$ç.>i…ïs$-I+iÈ˙n“R∑A““;’$Ìø±$MWíN$JZÆÊKZæ—ù¥º≠Ü§ª¬õ§k|â§7∆#≠`ÊêVÿ)ìV8Ï#≠8yóDêÒHƒÁ&$ äLø¸%A“~%:ãD…ßë––˙ZãDSN!1-™I¨ÆS$¨™ûÑµÜê∞˜OHÏoŒ$Œ¢i\'ÙâS¯àƒc\0$ﬁ5í0∑ÜÑáZëDºI‚í‰’IÚ%Ñ$\\KíyF20IÁ∑ëVkÀìV«›%≤oêå—“⁄˝§uœ∂ìLT]I&ÓèI¶ßmH¶¡$”K;IÎeIÎ+´H≤JI:Øë6*ÖíÃ®«Hf1>§Õs$s5“ñÙ€$z…\"Àå¥É¯å¥„Ë(…Üû¥ãE⁄U∞údáTíÏ€ìˆ@Y§=gvíˆ§Üê‘KHÕ$áW%§ΩB“ﬁ◊!$GõD“oí”Õø$◊¯«$◊¢$7…ÌÂ…]fJrﬂ1Grèà\'R-$÷é&~I:ÚƒÄt<ªÅ‰-æHÚ6}LÚ>>HÚæåë|^\Zë|ˇ\"˘3#˘Ö}$˘/ˇK:e<C:u”ót*Fït÷˜)Ä˚åp#Üà$ë[IÅc«IAy3§F∫§Vﬁ§G\"IóèÜì.ﬂ”!]yÌN∫∂»ÇtM¢@\nÛL%Öˇ;H∫äIÖ§àÎì§àÆç§àôÎ§»˘K§[∂I∑?êb•ÀH±nV§∏Ù˝§¯ﬂ§D8çî∞ètgë*)IåêRﬁ†§T-úîπ˘)3ÆâîÂ¥ítWN@∫>D∫/zO∫oQE V}H ^I _Dzh]Nz}ãÙhÖàÙ»4ëÙË˙!“„˚øIè´ñìÚDé§<ÔFRﬁµ§º¬rRæ´åî?˜îT†qåT∏≈çT‹pùTvCL*k∫F*ÁØ ï[ì ÁIïÑ«§™làTıdúTΩË©⁄s©˙€ARç@™›^O™ÉŒêÍOÙì\ZŒ˝\"5ÆÌ#5¶n#5>\"5=¥!=ÕÕ\"={ıïÙl∞âÙ‹Á,Èy}È˘”“ÛœÌ§fÉ§V1â‘˙Ú:È5àÙzÒRõ#Lz√Ë\'Ωπ∂öÙñN\"Ω∑∞!u˝ñ.´\0R◊˛;§ÆÀ«H]ﬂ¬IÌoëz¸\"ı±y§æÇRø÷]RˇæRËERâ+i‡∑\Zip˘}“†«;“êÏ+i¯¸i8≤Ä4‹í>/€K\Z9<O\Zy⁄K\ZΩ¸Ö4:ôN\ZÛ\"çMæ\"ç˝{H\ZÁ#}9B˙ä˙ìæY<$M,U#˝ËøCöv\Z%M?Ï%˝år$˝Ïä&˝ƒH?ßní~a\"“á|“ü3⁄§YG5“ú\nô47ÁE˙ÀπI˙[|ùÙ˜ÀQ“?\n$∑L\n…c!9CoH^~#$˜Zp˘$¥†	Ñ|7Ñ\rêb\nRŸ∫R5kÑTÕÉ†ÖÆ+°Öµ–¢ü!µG5êƒÄ4‹ÔCKîŒ@KZ ≠Öê÷çµêVe¥Ù›gH˚…MH;Ô¥‹îÈ\ZÏÄV¸IÜV\"Ú°6\"æ≠Ä\0f\"§ÓÅÄ{S¶Ç¬5 ®Y\"Ôªë/+CgàB5É(kl!t¢∫ÁC‘àf˛¢∑ÄÌƒºOáX[¶!Ão\'ƒ&∆CúÑ|à\'áxÜ˚ ûw4ƒœ‘Ü¯ˇ!˛¸\0$X›	<w@ÇêfHPAáÔŒC∏ß$˙gâM4!Èãh’ˆg–™¥h’êd∞md0c	≠&§@ÜÊ&êa«\0d¯Î5d|Ä÷,ÕÜ÷r†5kπ–öuhÌ:)¥éºZ?CÑ6(Ä6ºtá6¯C\'Ô@fú7–ÊçbhÛ?&d°P	Y∆÷Bñ„F–V≥u–∂Ôª!k·e»:(	≤Ä∂?mÄ∂œøÅv,éÜv8iA6ø hßÅ;dGº\rŸÌwÄB¸†}:|hüˇZhﬂÕ≈–~πvhˇ<\nπ\\≥Å\\ﬂ@n+C ∑Ptàí\nﬁtÚÿ6\nµYı∞Öé6ØÇ<œA^Í!/†Úä.Äéõ\\Ñéâ°ìKg Ôœ üÂqêO˘doÅ| ÓAæq»˜ˆ‰«.Ç¸ØC~øL!ˇ’Æ–)ìËTΩ:Ì√ÜNó3°”MP\'\nr:ù{?ùﬂÏ]ûÅ.X*C¡ª®–≈ÊfËb€RË“Ík–•≥&–’ãÖ–’¢∑PŸ∫6±\n’ñBa¸(Ï˙I(,>\nkπÖ[≥†àˇs±zäËËÑ\"~´Aë©ÇˇIánLΩÜ¢˙_A7ŸZ–-ı Ë¡∫˝˚%+lÇ‚p(Ó{=oˆ\nä?%–ØA	Î°ÑÍÔPB_\'î#∫Û°J.ãÇR≤Æ@©˘\\(√È8îq(\r <†LŸîyÁ\Zî9¯ r®Ü≤¢øBw+ö°lN4Ù‡`\ZÙ\rÖ˛‚Aè	|Ëqîî{ëÂñ§@O˛◊e˚î˜}îÔ{ oÀÄ\n˝øAÖÀ†¢`U®§v*•X@•ª°rr+TyÅ*√C†™$TΩ<™…UáÍ˛˜]7d5‰ÇöB®iGÙ¥ËÙ¥ z!>\rµîûÜ^ôf@ØBAØèoÜ^7P[ó1‘ˆı‘~Åu8OCÈó†éÈP\'öu~†Œ?œ°ÓÌ˚†ÓÚ√–áﬂ Pˇ˛á–¿ÏË+˙d$É>eéBÉ\'5°¡4/hı*hh…kËÛÚËsâ4F›ç’˚CcÌâ–¯™[–¯—E–óíaË€†Ù›˙^ZMT;AÍ–§˙,4ô=M]QÜ~∏&A”üqh&?˙µ’˙ïø˙˝®˙Û\nÅÊ^‘B_ïAˇº»r≥˝d˘«”d˘Ícd^Y·ª?YÒ⁄i≤bÓ≤b€$Yy;ù¨ú‡NV.Ñ»*1Ydï;qd’Ka‰Öo¸»j◊XdMøª‰•£ﬂ…ÀÕ‰e&5dm´≤ŒÍ!≤N◊;ÚÚûﬂd]ç≤Æû-Y∑ î¨ˇåºB]üº\"zêº¢ïO&®ªëâ7ëÅ¶Udp8Ä=˛NÜ¸ #Öœ…h˙:2öS@f-ìê±õ2ˆ®ÖÃV8CÊ¨Êëπ€:…‹¥dÓ]52ø\"Ûág…á≤‡“y≤∞· Y8öNéÁêÒ-ã…¢\"≤ò≤ë,∂í•ÊÓdi⁄m≤¥≤ä,kÒ\'À¶2»˙ûd˝‰lÚ™w»‰Cd¨üº\Z¢ëWˇŒ&ØÒ2\"Ø)zL^ßsòºﬁky}Çy”¶>≤9„\"yã∏öº≈Gôl1ºàl˘„ŸZ˜	Ÿ∫ˇ-y{9NﬁÒ¢ûº£\"ÔÕ!ÔíW\"€Í_$€^6 €]ΩNﬁ}LHﬁ≥»Éºß∆áÏ‡UGﬁ˚‡\rŸπHv¨1\'ÔøôL>p8éÏ§GvÜNíùì…Œ·{….«oíè%ú‘#ªZ≥»ná$dwß7d˜c\Zd˜®Md˜;Ô»áÔ…áÔèê?∫Gˆ@~êèZq…«T‚…«_xêèˇ\"üËíOÆÚ#ü|~ïÏCô!˚T÷ì}\\»˛oÚ…ßÓÏ#ü6è\"üæ_B–È\">1\'ÊõëÉr»ÁV®êœm}Fæ†◊M˛7Eæ∏‚˘ä|˘jÑ6˘jœ	rHπ˘\Z?ÉzË#9¥éDÌ®%á]˝übkÚı/RrƒÀø‰HY˘∆ŒO‰õK´»∑…‰hMú=kIæ=úMé]‰Géu€CéÎπCéﬂGé∏èúd6CN:MNFÆëì›î…)µrÍyr⁄9}r∆è=‰ÃÄk‰Ã©rV§)˘Óaú|Ø]Hæ_|ùú£xûú≥lòúìˆøm∆»è‘7ê´ìM,#?¶n$?Ë&Á*Æ\'Á™ŸìsItrﬁç‰Ç∆IrAwπËb!π(%Å\\ílA.•–…•aâ‰≤y)πúÁOÆ ù Wë‰ ;È‰Íõu‰Í1OrçÖå\\ìB\'◊ +ík[-…µûìÎõ»\rz€»\r‘{‰Ütr„H˘9†A~1# øT&í_{ëõÃ»Õm»-¡Õ‰÷,˘ï|	˘’b9Ú+≠≠‰WŸ™‰◊úHr€r[û-˘çˆ3Úõ=w»Ì£Á…îC‰éÕâ‰éBGÚª◊A‰Æ¯=‰Ó±‰ûm∂‰^5&πWßñ‹kvë‹{{ú‹ˇ3û<¯Xì<ÏH˛]\'èD^!è\nüìG\r∑ì«öå»„‘zÚx–mÚóÖq‰/ﬁÚ◊≠;…ﬂ^˚ìøÛ≤…ﬂÌÉ»\rw…ì|&yÍˇ,øK˛!I ˇ∞ı!œm!ˇå˜&ˇ,⁄I˛ŸyÖ¸sÍ˘◊ˇ˝˙ÀŒè¸knö¸;ÿâ¸\'“Å<´6CûÌŸ@ûÌS&œŸjêÁJ?ìˇ˛ﬂücF»f»ÛÔ‘aπö)Xû§À[˚√ÚG_¬Ú7Ö∞¸L¨p ^`\0+™ﬂÇ=	∞Rb¨Ù‰4¨|£V.‘ÜUñØÉU,`ï£Î`’•°Bx^h`´Ô“Ö5ÔÖ5ªo¬KŒ˙¬KæláóÓí¡ÀﬁaÌ•1∞ˆ÷Õ∞ˆ.5Xgy,¨cy^æb#¨ª®÷5¥Üu„m`Ωbº¢Ù#º¢y^iy\Z&å`ˆWåWÇ¡Ñ„0…Íü{\r£	#0U§S7‰¬‘‹µ0uj3LùiÜiR;òÈP3Î∏0Î⁄IS8c˜ﬂ√Ï^0;„/ÃqpÅ9ﬂ/¿\\‹Láıèa·-∆	Ê∞(¸,äê¬¢Ñ*XTd	ãjG`1∞ñhX¡é,Ò€K—XjOáı›‘·U·ÎaÉUi∞°•%l‰òÔZ_\nØ—ƒ‡5·≈öÊe∞…û∞©÷ºÒ¬Sxcƒ\"xc≤&lˆõo˛3\nõ/¿Ê1€`Û¸ÿº¥∂X˚ﬁzÚºµÁºmÙ3l>[?Ä‡°·]Ω|x◊Ø•∞-˜0lõV€—;aªÙx∑á!Ï ‹\n;8˝os~¡œz`áy	Ï∏ê;ÓöÇKá‡´¡&ça\'ç	ÿôÛ\nvjÉ]àvA÷cÿµ∏vcÆÑè‘√π1è¯x˚ ¡∞ÔõÎ∞ﬂ÷RÿØq>e&Ñœxß√go™¿gSƒŸG8 ˆ2Ë\"·⁄pPR‘ü[ú\rü´x\0_¯ÎÀüÑÉÔﬁÜ/ﬁÄ/±Ç‡Kª7¬óﬂ¬ó\'∫‡´gXµêwµô”pËˇuÕÛÖC√°ß·0¯6tté0‡¿7V≠Ç£~≥‡hXé˛•ﬂVçÄcß>¡q∂√qRéã·Ñ `8Ò^!ú¯£\rNR∫\'Å€‡§p2M\'˚√…Q˙pÚ}}8µ‹\0NãlÉ3¸P¯^N¸¿Äsíó¿èlZ·GŸ´‡\'{Æ√OˆÇüUÖÛn	·Çˇ5^òd\0ÈŸ¬E3^pIÄ)\\˙ƒ\Z.€ı.{∂.?]\nóﬂ*áÀﬂ&¿ÂR· Á·™¶p’¯∏⁄∑ÆX\rW_>Wˇ†¿5ÀT‡\ZœópÌâL∏~d\nn\\–7.ıÇõ4ö·&⁄∏…Öüü,áüüÇ_êû¿/p¯Öøtqá_‰¿-πè‡÷ó	pk[\'¸ Ì)¸*É_ıá€‘·∂◊ã‡∂O¯ç¥n_˝nÎÜ;ÊN¿ùÀ\"‡ŒuL∏sr\'¸Ó‚¯˝ A∏k_‹ùpÆÄ?-á?\\2Ä˚Ó¬}ã+‡~;\"<–°ºˇRÿZÚ<4÷≠ÜáÆt¬√b/x¯â<‚Æèº\0èiﬂÄ«/™√„cR¯Àˆ ¯´W¸ı\rûÿ∏û◊ÄßÜá‡ü]·ü…á·_Ø¶·ŸgxnH˛€Ïˇcù•»)ˇ†»mR‰Q)râ(Úñ˚(Úæé˘{, leøá≤¿eeAÁ%ä‚eE)°ü¢<µÄ¢\"Ë§®l¨°®Ô°®‹±¢®T_ß®‘vSä«)\rÔP>˘BYƒ‹EY‘{á¢ÊRA—‘I•,1÷£,È†S¥‹µ)Z^Ì]ÛÌroäŒöoîÂcäûZ\"Eo8Ö≤ÇsÇ≤‚∑Ñ≤2g3Ö–¯ûBL¢Ô5Q\0G&Ö‘8AÅTˇR»_Z(íf\nÂB>π3HA™ûQ®˛&Í†-ÖˆmÖ1©IaÖÕSÿá◊Pÿûw)Ï,O\n˚óÖ˚m7Ößªè\"–~LîØ¢ms(¬k0E$*°à∂éRD≠©Õä4§ê\";7K—∑m¶Ëü–ß¨Z…¶¨‚=¶Ñº°º»•¨^≥ób(Ó†!O)Fõ~Såv|•]†œQ÷¶l§¨€Œ¢ò4ôR÷´úß¨‹GŸ∞€å≤)(ê≤È˚4e”¨!e≥!ó≤ÂÊgä≈õ`äe@±,G±|yü≤5Ò¸ˇ$P∂N≠¶Xª∑PlÙ√(6w)vNQÏûRvˇÂSÏu˝)ˆi)%\')•´({ï¢){;z(˚vÃRˆ59PT\\£8_¢S\\L\r).M∑(ÆΩ3∑ÿîC…ëîCo_Q<éˆR<4)ûº6äßï‚yÙ!≈ÛÙ	äg˛&äAì‚u¯+Â8?ÂÑñÄrízïr“2Ç‚Ω‡≈{≥5≈{ì‚ÌŸIÒÆQ|E;(˛KñR¸…w)˛F’î”/Ú(gÚ€)gµÙ)g/˜SV˝†¶æ£avî†»îs¢˚îÛãU)ÁO*P.|Ì°üß\\lÃ°\\2*£\\˙¥Ñrô7Lπ‹„HπBOπÚeÂZ|#%TpóZ4E	s∏C	{ÒÖ÷rçÀ£\\ﬂ–@πIπûá©aNâl∞¶‹`»Sn\\¯JπëÛûr„•%äsãmbGâ~1BπΩ´û◊¥àíp˙%—1üíÙ•åí<UGIπJ•§Ê¨°§æ§§ˆ/ß§±”(È’ôîå™îåó]îLÁLJñHπªg%õ •d≥Jˆ∫\0 Éd\r √%JŒÙv #’	 cI5Âq’9J°Œ•Ë∆•‘∞àRŒ“£î˚˙P*¨î ã:î*ÍeJUy:•⁄©òRÜR„∫üROI©ﬂ •‘Áæ£4pÁ)\r^*îF5SJ£¶•q[•È Z SΩEîß≥_)œåHîg{ÆRûÎıSû£€(œÌÓR^>|Fi\r›Mi≠<Cy≠Bim†¥m˝Di´πKi\'P⁄eâîé:•£‡ÂÌ∂Mî∑Á_RﬁOû§tS™(={∫)=])R>>xJ˘8uÜ“+êQz7ü¢|¬[)üfVQˇVQÜzØSÜï\"(ü≠ï(üØÓ•|˛eGΩzï2fQ∆\nì)„ ;(„¬gîoƒcîâóΩî…¥Ûî©ÉK(?2C(3Eâî_kc(ø6~¶¸2;Lô˝ÄQÊ∫≈îøêÂÔ‘*DNo)\"wJQ`ê≈úàíÍ/Di≥¢ä˘\"32êEí.dQ∞¢ÜN\"jGO\"Í5RDcã¢±›—Tπé,q‹Ö,yÇ,€™å,;Ω—ﬁ‚çh˚©!:_%àÓäàÆÔD7±	Y°1Ä¨ê\"Ñ„·Q;\01º‡å¿-…¸Ì-Ç,Aê∞_Í´è†±ü*|°Â!¥2EÑæÏ+¬L=Ç0ﬂ‰\"ÃŸ5k˘FÀÿà∞˜>C∏TEÑÀnA¯9w˛¨\"òÙAÑÍF~3	ù¬…K5D˙ÿ—ËDVÖE ´Ü KŒ!€#C∆9ƒàb¨ø1ﬁÒ1˛?˛u+/ Î.\nëu3ëu}€M}ƒ‰‡ƒ$“1u–E÷ªT!õÙëMgêÕ7d≥ãŸ|Œ1◊…E∂Tqãõ∑Às)»∂∫?»∂ÔdƒJ°±v◊G∂◊å ;8#»NøndÁ˚nd◊˙À»ÆKk€hƒé·åÿm≥AÏ¸áë›çMà˝JEƒ˛Â\nƒQø9¿=Çÿ<Ä»ËGúœ˚!/|D\\/f#GÙ#GÜàGÙc‰Ë-K‰hn‚πh‚ô#DºÓß ^Ø\"«÷¯#«6Œ «Í¢ë„™Ó»q+‰¯ﬁV‰D’‰dàÒñ[ãxz ﬁôgÔûàèıƒ˜≤3‚€\'F¸˝êSÔ`‰¥≤=r∫¸7rÊ≠	»<Ü∫Go?EÇÑ÷H–!=‰|?$¯VrÈ”‰Ú.‰Ú|+rE”π·ä\\˘ˇ◊p•hr’drm·r≠m	]‡áÑ]ÑÑ~˘éÑëÆ a5ÓŸçÑøYâDX˛O.±k7u∏âz6Å‹<rπyg\ZπU¨ÇD@nk[\"∑Y3Húc67§Éƒ\røFí~ØDíÊ›ë‰ﬁv$Â4Ç§t:#©=?ë‘€êÙ≠HF5éd.˚âdÚ∏Hf¡-$ÎÚ rwÂ(rÔ};íÕ–B≤ÖÆHÆV í€;Ç<9≥y“IGÚ4˙ëºÄF$Ôs(R»ØC\n\'„ë\"j?R‰˙)rÎBä‹ E)£HI		)%BJYqH©ÎR⁄©éîÕ) Â∫!H9Ú)o¸ÅîˇõD™µ\rêjf$R›”Å‘¯ˆ#µ∞Rª!	©›ÃAj+!uH“‡„Ñ4<‡\"ç\'Úë∆˘øHìŒR‰i⁄w‰yπ\rÚ\"¯“\\qy•Èåº:WÉ¥YüD⁄∆û\"oÆrê7ıEHZètH\rê◊6‰-ı>Ú^/y0yﬂPÇtg/F>¥»êz+“s‡“S{˘h•é|,˝á|´Cz„\nêﬁª\0“˜Q(=Ö“=ê¡nO‰≥ºÚ˘o2˙Í2>Óã|	àDæ“o _o/Dæ%ùF&Çû#ì⁄∫»$≥ôRÌF¶¯Õ»ÃÍd&ÇÜÃdv#3y»œéL‰WÀ}‰7z˘3>äÃV!s≥óêøB\'‰Ô•\'»?Õfd~Ø2Ù2ˇh*g∂U‡G£\n\'–q—wL—•QËÇß◊QEÕ®bp™òUÏhDˇu£ §\\TŸ÷U˝€ä.ÙÍDΩÀA’¬¢—≈í®∫i™a>ÄjÿF5®∆√jT„O∫ƒ˚∫‰ÚTÀ§’˙2Ä.Î5Dµ∂¢:!ó–ÂÑItyg-™õ;ÑÆp8áÆ‘ŒEWÊúEÅ?î4‡ÅB±â(ô÷ÑíÈ{QÚëµ(∑°0rÖÀû¢»•÷M°‘&J;úÄ“\\PÊ©8î˘æ≈⁄ÊQ∂≈3î´ÂŸ_D“*THiGÖÃT¯®≈?æ@EW7¢¢gr®XxÀRQ…ˆ0T4]%|èÆÍÚA\rNk†Ü>Ó®Q˙\r‘XE]sv3∫vÛ∫6‘]˚HÇÆ}ı]º5y™ÑöÆ⁄ÖÆ˜ŸàÆø˛]ﬂÖn†Ñ£faC®Ÿ¿4∫âœD7?~éökü@Õ˛F∑¸©G-ÆD-µ˝P+ã´®µ€‘∫‚:∫√j√äEwff¢vÚ≠®}Ï/‘æg?∫«a∫ßˆ	∫ß€›3}›ÎüÉÓ3|ÜÓª¨ÅÓK2EAO‘±ˆ6z`’>Ù¿n3Ù¿Cu˙ßç∫¨8áÏyÉ∫R\rP◊Ñ®˚• ‘cS8ÍqπıòÂ£«À-–ì7\\—ìΩn®è≥5Ís“\nıIØG}˜¢˛“ØË©DOÙ¥ÓzÙtÿÙt§\ZdWåû≥RAœ/Å^p®F/‰X°∫—‡Ä@4¯ˇò/∂[£geËï†\ZÙJ§\Zzï;ç^›êäÜƒ––˘V4Ãg\rÎ?ÖÜ/úG√-™—à+\ZÈàF$†7n¯£7J/†Qº4j›4*»ç˙mÉﬁúMFo\rÌDcùK–Xè^4éÌÑ∆ma°Ò£≠hÇM\\TÄﬁqﬁâ&mµAì∂†…kç–îÁB4ısö¶µM√|–¥Áçh∆ˆ	4„⁄0ö1[éfÒ^£Yn˜—ªbWÙÓª\"Ù˛uÙÅ€RÙ¡≈ZÙ¡ïóhŒº1˙®˚9˙∏&}¸q1ö+»Csí—\'ﬂh^ÉZ∞≥-pòE\r–¬Hw¥ÉZ§gè≠m@ã´ü†%â·hi»6¥¨nZ.ﬂáVˆ£’e0Z£⁄å÷‹b†µMñh}A&Zˇ2mPjCëh”óVÙÈ*˙¥6}ûº}q5m^à∂\\œB[zù—Vœ0Ù’˙Z∑}Ìûäææ?â∂\'i°ÌEÌháº⁄ŸÜæ]¥}ª~+˙>ßÌbÑ¢›J—Ó‰%h˜⁄=\n£VG°lv†=¨Éhœ´}ËGÙ⁄´uÌΩÎãˆç°˝E…Ë`˙ÃDáç-—œØ-–ë5°Ëò¨\rﬂÒØZÄ~I˚Ö~çtAø+¢ﬂ¿ËDB\r:…úG\'≥“—)ÕiÙGƒÙÁ˙ØËOã<Ùgæ˙yÑ˛~é˛Æºé˛yè¢≥´¶–π’ÂË‹[ÙÔX!˙2@Á…≥Ë¸≠óT9å™Ä∂R¬éQ^Ø§.∏˜ò™‹êC]8^H]¨iL]øé™©ÆO’‰GQó–ª®K÷]§jÖQó*•Qó?j§Í∂ZRWF_£Æúv•TPâ„⁄T\0õ†?\n©‡âETíG&ï\\|ê\nÔ8IÖØ¶¬π7©’**%©ñäÏ€AEÚì®‘5vTÍ-{*µÕíJ´±•“ﬁ®Ùı5T∆ÍwTñB7ïüK≈vÖP±#∆TÏÁï}âKeG∑S9¿(ïsnïãfPπmnTn«w*?#ù*⁄Nb*T<›ó*V;@Øˆ£J`ê*≠’¢ ‡E‘U¥T™¡)™AÍo™°À+™ë¸q™ë≥’h(îjú⁄B5n]J]£”O]sƒÄ∫.úE5˘{îj∫Nûj=G›ºpàjﬁˇà∫e∑:uÀD’¬q’¢5ójÒSâ∫mÎr™’ÉÉT´áb™ı-ÍˆÓ+‘·E‘5‘ùû‘]˘#T€ÜÕT€∂/Tªæe‘›A™=Ò4uœ¬iÍﬁ˚À©˚RR◊∂Sª>S˜Ô\\DuV“§∫m©£∫U∆S›-(T˜¸ªT˜!-ÍëÖ€©/S©ˇéP=Wˇ¢zû†z6K©^FjTØ„6‘c¡‘„=‘Äz\"∂özÚK’{h\r’G˝\n’ÁË7™œ±˝Tü[ª®æ‹∑Tﬂó Tﬂ·˝Tøuˇ®~iO®˛q•‘SY4Í©˙€‘”=è®gˆLQB<®Á“\"®Á:nR/Ï?@Ω–lA\r6QÉﬂq©ó¬óQ/+Q©W†0Íï=C‘´rŒ‘´∫*‘Ë\nıöÁ*Íµ”q‘kùÍ‘–Ö˝‘–otjXç&5Ïõ<5¸l5B£åz„ï&5*∞Ä\ZU∫É\Zı7Üzìtòzs†î\Z-S££K©1„Œ‘X‰5ﬁ∫Å\ZüÈBM0ˇGM‘7§&:ÜPì=®…gr®)â5‘T≥~jÍ=.5ı~<5Õ4çö~æùö•“FÕ⁄ÆBΩW˙î˙¿-Ç˙ eı·ESÍ√L	ı·\\)5«?Ç˙Ëjıq§2ıq.è˙¯]:57x-5œ=íZ0?E-“t†ñ¯zPÀ\"T®ÂßSÀ”À©ﬂS+˜º†÷+\\¶6¨é°6rÓPÛ©çï‘&CjS·OÍ”¸.ÍãíÁ‘ˇ\"©Õ±\n‘ˇJjÀ®9ıï…eÍ´ΩC‘W›_©mÁ7Q€Íj®ÌÎæP€SL®ÿ5j«’U‘wY|Íªó´©Ô˛ˆRﬂØl¶vëñRª6ôS?Æ5•~¸ÿGÌ›XDÌ;OÌoXG4u¶ÖtRá\ZSá∫©‘œÔª®#_‚©£∫G©£‹˝‘1˚„‘q´‘oáæS\'ô7®ì›°‘©iKÍ4…ü:#wû:TRg‹ÆSgºAÍÔ∂U‘?*Ò‘?oÎ®sEÎ©s?Ü©èﬂ†˛§Pˇπ/°˛;Úè:o„Lùﬂ?Hì;;BìP¶…á∑–‰õTh\nCki“Ë4≈òyö“—4%Øo4ÂC}4ÂOq4Âo\\öJÉ\rMe˙8Mµ¶-ºzó∂»\\ë∂(fm—x\"m±Õ6ö˙⁄Iö∫ó¶ﬁ£@”8°J”8≥ï¶ëH”,©£-·Ω°-â~N[í|ù¶E‹L”äÕ£iœˇ•ÈîY”ñ7f”ÙLé–VÍﬁ¢ «i¿m\Z}ùæ[A#M5—»kúhÛ≈4DëHCÌ†QRi‘¨l\Z›†ôFw◊°1L,håñ.\Zs›v\Z3i7çµPü∆Ú£a˜#h≈∑4éÀ$çìÉ∆’}I„∂ˇ•Òiº¢4ﬁ¸\Z?¯Mºè&ºJß	≥\Zh¯∆ì4—“˝4Q?MfA[Uî@3T“ßnw§≠;O3Jû†•B¥5¥µ‹ik∑\\¶≠7ñ—÷v†≠èê£mD^”6≤∆hMØ–6Ó€L3É‰if«3iõæƒ”ÃÂiÊilöyÜmãKmK|6Õbçfπ0èf9.§m[©C€ñ≥ü∂}IÕfeÕô¶Ÿ‹ £Ì¨k£Ìú¸I≥]\\D≥”Ë•ŸâShªµ™iªÉ\'hˆÀiˆv54˚\r¥=Wñ“ˆ˙{“u¥˝2iò\n4ß2OöÀÉﬂ4◊g∆47VÕ-h1Õ˝¥Õ}é@;“_OÛ °yﬁ©°y—hﬁ\nhæ´—|.”¸∞VöüS ÕÔX1Õˇï<Ìî<óvfùî‡sÉ»ú$ºN;ww-Ì“Ûg¥ÀAªhW¶]ÈßÖ\\ÿJ)˙Mç^I“§ÖÂß–¬˛E”¬mﬂ—¬˚e¥åHã¨|Mª—SHª˘˝ÌVæ5-⁄2òvõ¯ì€˛Åw∆Å◊˘à•≈¶–‚´—‚[ci	Ú˛¥ÑÏJZ¬≥tZbÛ;⁄ùÂ¡¥§úW¥§ŒaZ2∫âñÏîñ¬‘¢•<FK[–@À8oDÀ»;HÀ“í–≤V«–≤.?†e}±§›=Ö”Ó)‹£›èR°eÎKhŸwhßZièæ“q’hèŒ…”Eh–r˝ÃhOòû¥\'Âiy\0ùñ?ºäVhyåVUC+|≠G+Z£B+j£õ@¥‚Ci≈°üi•“JZ©µ\'≠¥FùVÓ´M+O˘ü¡G¥Ú…7¥äEZÂ⁄JZ’·VZ5˘/≠&2òVs†’il†’≠˚DkòWß5t†=54°=_Ûòˆ¸«9⁄ã S¥ó⁄Îh/˚ﬂ—ZVÙ“ZÖé¥WrÆ¥◊VühØÎN”⁄º\0Z{ÍZ\'›å÷≥Ä÷9uíˆ6÷üˆˆéÌm⁄⁄˚…\"Z◊76≠˚d,ÌCk-≠w˚NZÔ\'î6Ä•”>q⁄iü$óhü¢ßiüË–U¶hÉ_ñ—ÜC“h√ı°¥œÍÓ¥œ÷M¥:@ykHg;–∆w\r–æ∏*”æ˙◊”æˆÓ•}”¢}˜ˇD˚J†M¡WiSÈ$⁄è⁄Ã)ê6ssûˆ+CD˚ÁI˚√U§˝)=CõïˇIõù^AõCÉi„]Ë\nOn“ïî“ï¯•te=[∫\nTCWqêß´ˆBtµåetµ…óÙ≈ñªËög\nËK‹\'ÈZz|˙“ËGÙeÊ˛tû]ßøôæ‹Í}yÃ	∫Æ˛k∫˘\n]om}@¶ØX’G_yl}ÂçGÙïm9t¿\'áﬁ°—¡{ôt¯M9EGó§SÕıË‘Ä::ı˚\':}AùûEgT=°3ß/—YÍWÈòM%Î ¢≥ﬂ$”πa\":˜ﬁr:oYù∑Û)ù7∑êŒ◊YG«˜á—Ò∫˚tÒ≠F∫tã]v©äÆø≤Änxr›¯ﬁb∫Òsîn¸Ò\0}M§îæV¡çæVRL_˚ºúæN„}ù¶›$Ó\'›dﬁénz˜ }Ωº>}}ö}√ﬁït≥üóËfø_–Õ]mÈ[Ü˛“-¢ó”∑fsÈ€ñ—∑ıL—∑çqË€_;”wHlË;v:–mËvM∫tªi˙Ó˘Ù›O˜—Ìã.–˜%—,>–˜…´”˜ÌºAﬂÁÁJwÏ †;ÌH¶ª»›†ªÏv•<ıÑ~s\r›S§ªÌ˚Lw«ø“›ªv“wE—OL–èåo°=m@˜\\ëÓıÄB˜zö@?ëJß{„QtüSËæ¯b∫üw(›Ø6áÓˇéM?µ¿ñ~JÊJ?Ì@∞ºM\\Ñ–’ìÈÅŒÙ@ˇÉÙ¿∑{ËÁ˜ˇ¶Î9“/_S¢á¯Ô†á§bÙêt}z∏ö)=B§Iè“¨ßGù%–oÂπ“£Ø–„j_–„ÜÙÈÒ|ËÒïÈÙÑêz‚)wzb‘jzby4=qˆ-=Ÿ)èûÚÅBO+Î£ß}4†gll†g‘’–3>$“3±ØÙ,Gc˙˝ˆTz∂æ.=ª§gèÓ¢?Ä-È÷|£?º9Fœ]⁄OœÀ∑¶Á˝xLœõI£Á?]H/¯?üÖ¯-z°Q	Ω0ˇ8Ω∞JÅ^|2ò^‹	“K87Ë•·=Ù≤•gËe∆âÙä∏.z•¶Ωäæà^UÎJØ˛æô^Cl§◊†æÙ\Z∑Jz≠∆<Ωv©ΩVGDØ€ÂJo∞†–õ7“õŒ?¶ø<ÎGoÓú†øÇ	ÙW√ﬂÈØ3]ÈØﬂ©”€LSÈm›lzªë.Ω›\'çﬁùBª`1˝ù„7z◊ezO‡Vzœï˚Ùè~–˚ÏÉÈ}·∑È}	\nÙ˛Ì\rÙ~◊jzÖ9}`ÛC˙ß£πÙ°œkË#5%Ù/⁄NÙ/˚>—øjå–øØ{Oˇææç˛=Í˝{˙ˇTj—\'4=Èì1EÙ…ƒA˙d˜y˙‘≈wÙ5˙ﬂÌÙ_è“kÏ°ˇ’w•ˇ›ÁCˇáh—ˇ/ßœÔ}Lüw‰1‰ˆ¥2î¸^2îÆ72î˛,f®ñÏd,|,«P;ÂƒX¨%e®√ÜıÌvıﬂöú{å%ˆëå%◊=Z#b∆≤m⁄åeáü1¥-å⁄)Üéëc˘≥(ÜÓ≤dÜ.˙î±¢¥ï±r¡:∆ Ù:kfˆÚD•9PwíA“—c¿&ëJw2ŸÚåÅºhfPG3hÓ$ÌäÉ.wïAOAOSYá¡<Ì…`/ë18ÓﬁÔ]¡8ô!¯±ÜÅáÕ3DnCtﬂâ!±aH~¥0§˛O“.Üæó±jˇ∆™+öÉÌÛÔ´˜O1Vß¸?Ê§?bnàa•∆1å/?c¨©-e¨≠ˇ»0˝Úáa˙Îc„V9ÜWóaÊ›»ÿî2√ÿTBdl™\nalöﬂÕÿº•ï±˘À>∆ã1∆ñøñÀêΩÀb∆÷c˙kg∆é:CÜç:ƒ∞*;wø`Ï˙∫åa+È`ÿé0v´-bÏŸ…pËÂ0ˆ:_gÏ-π¡ÿø5ó±Ú\n„¿Nk∆ÅQoÜ≥0á·<€√8∏ò≈8òcÃ8XπËBn∫n¿4„âx∆ëù9å#È7G◊Ôax&Sûo;«∑gﬂqôq¸¡oÜ∑z√€£ä·#\'«Ÿ\\œıa2¸¨Ÿˇ¯∆©¢x∆Èeqå3õrgs\ngˇe\0Å∆Aå¿˚WÅ_˙A.’åsüÁ≠∆ﬁπ2Ç’Æ0Ç˜â¡Á¡]åãfk√$åÀsKW3Æ1B;˘å∞9FxÕ$#Ç´«à¯«∏±Û.„ÜÀ7∆MÙ„¶ÒFÙ¯v∆Ìò	FÃ⁄F¸˛XF|ÚOF¬ï|F¬‹ #ÒÿaFíÒ;FÚÏ#µàƒHm’g§AÉåtµ9F∫¨ÅëÒríëô˘õqóÓ∆∏õÀf‹-+d‹-`‹ª∏êqØ,àë¢¡xˆ	„a∂Ñë√[√»ié`‰Æe‰≈,b‰Øõa‰ﬂ⁄ƒ(›cò3\n3-E£®r\'£5eA%)£ƒfûQ“ÚñQ∆;ƒ(˚’ (_ì∆(?KfT¢<FÖÈ=F≈ófFep£™9ñQ^∆®é⁄¿®Y´…®	b0jû2jﬁ\\`‘.›Ãhààf4bå¶\'ÓågΩ∫åfÕ(FÎ∫\råVØ.∆kÒN∆k£çå∂„çﬂ£=w7££Ù(„Ì£”åwZW]‹F◊uú—≠¥Ä—Ω«óÒ°ºÖÒ±ı2£WÆõ—˚¿ë—˜[¿h≠c| 2>Ωúe^Vdv•2Ü†<∆–@,ch(Å1¸¡ë1‹ì…? 5Dc€å1/∆W ¯:ˇúÒçıÉÒMvÖÒ≠bàÒ}«U∆.dLúSß¶S˘á?Ï2~î≥”‡K∆ÙÉ„åô≥L∆œ‹oåü≠]å_À˙∏:å?¬d∆luc∂3ó1Á(dÃπß1Êﬁß3˛∫È3˛6ëˇt0˛•∫1Âﬁˆ1Â˜È2d#L≈√R¶“¯#¶rñ)Se@¬T˘Ê√T≠b.“Ê0˝#1¸e.˛—»TﬂgŒ‘XÂ«‘ %0µ>0ó6™1ó…ñ3µi3uÏØ3u‚Ωô:øN1ó«&0ı®˛L=VSÔßsÖy\rs≈ì√Ãï∫ÛLÇë=ì‡Tœïò‰„Lx¶ì	ˇ’a\"U˘LÙ¬:&⁄V d ù`2ˇi¸è.ì≈a2±K=Lˆ¬ÖLˆ…øLˆ≠ÖLécìÔÒñ)†f1kﬂ3ÒÂóôx¬r&^qü)JaäfÜôíıôíÙsL˝gÊ™Ä@Ê™Ú8Ê™7LÉÀ˚ò•JLC¶!‡À4Ùtg\ZÈï0ç’∂0ç)ILì”ML”%√LS›ãL”Ò£Ãı˛∑ô.á2Õéô07¶37{d3∑hÃ2∑p_2∑úÇò[ûö0-Ê3-o‘2-ﬂobZ˛ranÛ2∑ÂdÓÿ`¡¥IIfÓƒ≥ô;;\\ôªÿ;òª§FLª°Lªokòª71w;ÿ2Ì˜?`⁄Jf:0ò©«òoñ3˜.≥cÓ’]…‹\'\neÓÛ∏»‹43˜˜ÆexŒtj©b:[,d:_HeÃô_ld∫√t”º∆t_xÜÈ¬tˇÇ0).f\n±gz¸õy®/ùÈañƒÙH&3=^ˇ`zöûfzYç3è±⁄ô\'ˆG3}}çòæg3OŸË2OùºÃ<tîy:úy∆}öyˆÃaÊŸä^f¿„|fØãtcÜy~Pã¸gäyÈ†!Ûr«mÊÂ·”Ã+çô!˘∫Ãê_bÊµ∆0fË”0fIìæ*ê˛,Å˛¡íqc32o7ÛÜÈafîb2ÛVéÛ∂”36^Éõ˜ç˚æÑWsèô¿Ê1Ô$92ìÜ(Ã‰◊ô)ï<fjËbfÍ≠fjº3ç2»L≥>ÃL€…g¶{t03oü`fu0Ôq˜3≥µû1≥KçôO1yñ1E,bÊÔ∫ ÃøEbÊˇ cD`ï®1ãç ô≈3ãÁ1K4?2K^Rô%Ω5Ãíi1≥\\mÑY.ƒôï›ªô’Îcò5çáô5øäòµ§•ÃZß%Ãzø8fÉê∆lHﬁÀlË…f6ﬁ0õàüòMvÃßÕÃÁ ^ÃÁ}ﬂôœˇ∞ô/\nò≠ﬁ ≥uÏ)≥}ÛVfÕìŸ©Ã|kqàŸòœÏªß¿ÏﬂÕÏü=Ãpè`<º≈ƒ˜2áîGôC6oô√V≈ÃëŸ1Ê»_Ê®JsLï ¸≤¨é˘%vî˘ïøö˘MÃ¸PŒ¸~´ä9Y\01ß÷®1<ŒúY5«¸ï «¸Û;ó9{Nâ9˚¨ù9;˛ö97ñƒ¸∑Gï9ﬂõ¿úˇ∫õ• mg)<ñc)Qˇ∞î5XJy&,•é2ñ≤\"KÂFKu„a÷¬àµ∞b-*“b-^¿Z<Ó≈RÔzÀ“ÄY\ZË<K#(K≥`	kIŸkñv0KÁ( “Èçe-è≥t⁄±tﬂ∂±Vˆo`˚YD\'C0^¡ubXêã\']√aQM¸Y¥c1,⁄Û?,⁄Á≠,⁄˜Õ,Ü˜m≥æç≈ÿ«bÖU±Xè˛≤X˝≠,¨2ü≈ﬁ¶À‚ê∞8b\r/Ô>ãoÅ±¯qr,˛HK©í%4ﬁ¡¬Õ:YxûK¥Àê%Q{¬íh-`IDÔXí$Kz¯K&e…ú4Y≤z,˝Eñ¡Ú^÷j∫-kıÁÀ,£∫è¨5áfXkÓ¨d≠[˛ÜµÆﬁâeÚË4À,ù¿2?∑çeq.áey,åµıh\rk[.À*óŒ⁄é˛emóy≤∂{ˆ≤läX6O÷Œt÷nd;À*cŸmg9[ç∞úºXŒø/∞\\÷8±é@˙¨£€ãX^^+Y\'ΩÔ±|µ¨Y~cÆ,π^ñø›RñåÓˇÏcæb^Qc÷—YÅ„ù¨¿â&÷›G¨wœ≤.º{Ã∫$âb]äˆe]™na]^≤Æzøb]\rNaÖ‰ˆ±ÆÈZ∞ÆŸ	Y°e∫¨∞-u¨∞è7Y·ä¨®≠+ ∆öu+·+zQ7+z?ó}/úu{9ôø.ïüìï∏c5+±∂àï¸i)+∏«JõÖXÈÑ=¨Ù‹É¨å(àï—Ã \\≤≤ﬁ)∞Ó.ˇ ∫ØüŒz‡∞õïì∂ûı(	a=Œ*c=9˘Åï◊îïüUŒ*ΩfÃ‹c¸Õe¬YÖ≈›¨¬ö¨¢™BV1È´x=∆*âöfï˘Ógï/ê≤ ˇ^1sÜU)øâUu0¯∫XUáœ±™/v±jˆi∞jW¯∞jc%¨∫kKYıó¨ÜˇÛ”tVè’4‘ z Ô`=3Lg=7SgΩpã`Ω:√zÒœéıíıë’\\ô√je≠aΩ˛=Œz≥ˆÎÕü÷;⁄=÷{Œ_V≈Çı·¿Íπÿ¡Í≠ﬂ…Í[∑ê5h=Œ\Z∫‡≈\Z˙‹ \ZπìÕ\Z…d±F∫¶Y£aÔYc¬◊¨±˚ klcçww∞æπ®∞&*XSZJ¨© q÷TK\'ÎáökzÛ÷tˆw÷Ù/ú5ÉûfÕÃî±~ö¿¨ü	Ò¨üˇ@÷Øg—¨Yë7kˆr,kvf˝U(cÕØeÕ€≥Ê£ª19”LÓœ &o∞S‘ƒû?«M≥1≈ySé¬T)Jò™Ö\0[hóÅ-_é-:ª[‘∂S#áaj\n¶f/¡‘ö˝±≈ âÿ‚∏LCÃ¬4Á0ÕÅdl…⁄lâ”lIB¶uæ”JZÄ-É8òNW?∂¸˛.l˘ú1¶Î—É≠PÓƒVl®≈Vÿ˘`+ÛÂ±ï.bDêãJ1  Êµ1“äåÙv]ã¡†îhål≈≈`û“¿{k…∞«®!%Õ˘+Fªnà—ó8bÃîQå9¥cm›Ç±-`úµ∫«÷„<∑∆∏Aç˜ÚyåõqÿfbÇ®9L∏ Í~∆Dœ\Z1—H&π÷âIò¥`ìÌ∑¡V-l¡V≠¸ÉpQlu*ÄÓ—ƒåñi`F:fîËáΩW«åπsò±îÉø;Ä≠Iƒ÷‹S≈÷¥îa&9Á0”eNÿˇ!l£ufˆ„4fn≥\Z3O\Z√ÃÔÁa[èaVùò’#6fΩﬁ≥Œ∆v^a;®è0°?∂Û)€•\r€mRâÌ∂\n¡Ï√0lè«∂ßÍ;Êp«€€€ª	sî\"ò„*ylÁNlˇ¿!Ï¿_UÃÈ\\Ê¨ËÇπpØb.ÉÿA»s›¸\Zs«>cÓÊ~˝\nÊ^ˆ;\Z˘Û∫’Ç€WèﬂÖù∞√±ì#}òè…Ã◊ÛÊa;•›ÖùZkåù›¢Éù=Çag?∆ÇúaÏ¸“T,xÌ2,¯£\'vI9ªDªá]:‰Ü]Ó7¡Bﬁü√¬¸Ê±’)ÿı«ó±»;[±{X›ã\n∂¬nña7Àûb—Y±òÓ,ÊÎS,V£ãﬂÚãw˝é%\\â∆B∂bâEˇ3◊ã›°ébwRcIW+∞§±√X\n[KıÑ∞4Ê/,ÌoñæTÇe:7côıK±ÃE,K∏À⁄pÀ⁄£Çeπà±ªã√∞{≤Sÿ˝ˆ`≥3ˆ‡¶3ˆp	{ÿoé=ÊÏ≈rÔ*cOå≥∞\'ˆQX~∂+†èaMÊX!ÏÉï8c%\nXÈΩZ¨¨§´h¿™¶¥∞ö\r&XÕÖz¨VbÇ’ecıK`\rÁ5±ÜB¨·è÷∑kTÃ√öb$ÿSiˆÏ5{ﬁ‹Ö5€a≠ÑﬂX+´kÌØ¬⁄à¨Õ•k;ZÄµ5ÿz.÷°‹ÑΩ¨∞∑o√∞wπ€±˜Ú±˜&„X◊í≥XŸÎfM`¢èc=ïeÿGµ◊XØï\Z÷ø—ÎwB±˛cÍÿß6wlÿHAÊ∞˝œÿò‡ˆï≤˚v…˚.Ôà}_9é}?ØÜ}üzçM∂Ob”ê6ÌwõŒøãÕD^≈f¢ób3„Üÿœ¨Ï◊\"Ï◊Î\'ÿz4ˆß˛5ˆw—MÏo∆%ÏÔ¥ˆœ3˚™â˝+◊aÀmµg+g/–€ ^Ë…^p~Ä≠»qc+⁄Õ±=∑≥ï∆cÿ ˆÈlÂ+wŸ™ZÔÿ™´EÏEÍÆl59îΩÿ∆â≠‡≈÷ÿ»÷¯ªü≠È∞µ†-l≠—\n∂ˆ≤=lm7y∂∂w[˚ÅΩºœÜ≠k˝è≠;≤å≠«:«÷+ReÎ’%±W\\CŸ+ÚKÿ+^]efû±[6âa∆&•m`ìÖﬂÿ‰-OÿîÛ8q|¿F‚˛∑œ?≥ëÔ˛l‘ÙõÍ¢ ¶y∏±iC˚ŸÙÍl¶N2õŸæàÕ*ÀbcÔ™ÿÏ|M6ØﬁèÕÎ©bö+Ÿ8˙êçﬂº Ω©eã]é±≈ÜŸ“%ÎŸ“§lvç-k±gÀãŸ˙æ_Ÿ˙©\rl˝Êˆ™Á\0€h«$€hp9€¯b{›iåmr\ncõ™¶∞M√ü≤ÕHd∂Ê¡ﬁd1¿ﬁ4Àfo69¿∂pa[nª≈∂Ç£ÿVNl+#∂µπàm˝K»ﬁ~ΩáΩ£Ÿümö∆∂È^ƒ∂-wc€ô±ÌÅUÏ=h€¡œÖΩWn-{_h{Ñ:{ˇó1ˆÅÿ„Ïb∂”ZU∂≥¬Z∂≥õÑÌ2∫ÑÌÚ/ö}H}˚HU+€clò}¥yÄ}Loñ}\\Ì&˚∏ÿñ}bΩ˚Dv˚Dw˚‰∫2∂∑„r∂/SáÌ[T»ˆ∑‘cü‚.füæˆò}f˛$˚Ï≤KÏ≥˜⁄ÿ∑˛≤/<äa\'≥/ì6∞Ø8}d_©ƒÿWΩw∞C¯?Ÿ!ØdÏ0∏ô•»éª¬éÏPgﬂfﬂö5cﬂ6”gﬂæ†√é¡gÿ1ûqÏòƒ7Ïÿ#ÿqßW∞„Üo≥fBÿI/ÂŸ…\r√Ï4+v∫˘vñÎoˆ›’Bˆ›∑vÏ{à˚ﬁé-Ï{ç—Ï˚j˜Ÿ˜˜4≥Ôè≤≥ïKŸujÿè(UÏGv$ˆcÉ)ˆ„ Ï\'¬Ï¢\'EÏb˘9vqç]‹œ.ûŸ¬.y≠¿.}PÕÆ44`W—˝ÿUÅ≈ÏjTÃÆ´Z»ÆAŸıõV∞„Ïg˜Ÿ/$ˆ˜£ÏLã›ä\\bø\n#∞€‰ˇ±€ÙÊÿmËªçÃn3éb∑g±€ZgŸ7ó≤;ˇ◊ [è2ˆ;≈:ˆ’GÏ€ÿ=+íŸ=ﬁ!Ïè1€ÿΩã›˚}˙ [ÿ˝ûÜÏ˛`	˚ì·[ˆ;ˆ»—´Ï—Úbˆ;ã=VqÖ˝mµ-˚[µ*{≤<ñ˝Tcˇ˙–¬˛Q¡˛≥b	˚œ\\,{.p{Óf{Æ˙5˚ØÆ7˚ü0{ﬁBï#g˛ï#wô«ëwÂ(0Æp‹ûsº.‡(ù¢pîæ˜rîWÕsT|!é™Àˇx<‡®FsTs 8™ﬂº8œp	s‘∆ù8Í◊ws4.l‡hƒmÊhƒøÊh\"!ú%∫-ùPŒ≤ÆùÌ‰\0éŒí éŒ!ŒäΩúôó8+ ›9+€£8+ﬂ28ƒåûÁÄ!€9$•Mh1¬Åﬁzp»d*áÃ·¿ù9ô∆AFÁ9Ë6á∫)ÇCΩ>¡°;…q∫{9L“y3¯á˘Ä¬aÌY¿¡ß9Ï[\nÓÙn/©í√ü‡®æA0WU‡‡Kk8¯fé8≤ô#3SÊ»6ßsd>ã9´^ü‡¨˛∞ïc4qåo∞9∆”Zú5ƒuúu‘•”}:úçÄ-g„zsŒF7éŸ`(«ÏKgSêÄ≥≠¿ä≥c´\'gáÕmé\rV≈±â·Ï <œ±”Œ±ÛÙ‰ÿ]ø ±ß\'rˆ6sˆM>‡Ïg|ÊPŒÂ»y∆q9€ƒq’îr‹j“8áÕVs<íVqén~¡Ò‚Upº\ZséIhú„W_rN:Âx∑{p|:Ù8æVtéˇ¡VéÿYŒ)I9ÁÙ°3ú”ÅÛú≥¢PŒYwÁÏÌN‡ÜvŒπ0ÁíüsÈ‡Œ•÷&Œ’Û’ú–ÙtNË(õÆq¬À>qÆ+\0úà3NdÎ%Œ\rÍ)Œ\r·ŒçÇ≠ú®<ús´∞èmô√π\rØ‰ƒ*[qbo|·ƒªÓ‚$h¶qíp⁄Wr>ûÂ$>Y»I⁄o∆IöVÁ§»ü·§Ñ◊sRnDq“ó&q2Gù9YYúª÷zú{o‰8˜&J8˜Â$ú˚Ü9ú˚ÉiúÏ#úﬁQúúJ#Œ£âßú\\ØvNnÈSŒìW_9yß~qÚ^Np\n¥+9EF9≈î\'ú‚£€8%√cúR≠NÈ˙hNy¯SN≈©N•±5ßäl∆©Iæ≈©}±ÅS˚„ß~˘nNΩùßqú»ií¥qö∫◊qö&pûz§qû)lÁ<[»yÊ©Ãyñ˘òÛ¨BçÛbØêÛÚgß•–ëÛ*√ÄÛ™˝ß-Êº·Üpﬁ¨á8op⁄\'Î8≈/8ùS79o∑ø‚º„I9Ô÷˜pﬁoåÂÙÏ∫ÃÈ}:√ÈÉ’9}ÙÀú˛Önú˛eœ8˝‰5úÅà&Œ@ë7Á”˛úOew9üöı8É^1ú!øèúa’	Œ0kÄ3Ã?Ãï€»+≥‡å}Ç8„∆\'8_ﬁ„|ı™·|€¬ô‘$r&œ7r&£9ìO≤8?V‡úi“2ŒÙ⁄4ŒÙ1ŒT»ôÂ¸)®‰¸yzë´òë«U¸óÀU∫gÕU˙pÜ´L‡™>l‰.“öÂ™õΩ·™gﬁÂj*|Â.ÈÂjorµÔ8su\ZøqóÔÕÂÍÍÈsuÈÆ\\›Êª\\ΩÙTÓ\n{ÓJ{.a€n.·„K.Òu ù‡Ül.ê/«w∞π†g¨ó„í⁄q!yw.îƒ%_yÕ•®¸ÊRíá∏®—..3SÅÀR∞Â≤WjqπıC\\^móüÊÀx?Á\n\r∂sÖØVsq„ª\\º\ZÁJp%ÆLqÜ´ø´Ñ´Ûçk0≈]Ìqêª:£Åª∫zÇªzPÖkà¿\\√è˝\\„ºß‹µ£u\\”gñ‹ı€∑s◊Á<‚nÊöëﬂp7ª◊q7«\ZrÕØr∑‰r∏ñTπ€v\nπVˇ˚µ˘èù\Zﬂ∏ª˚ˆrÌ?xr˜¨ò‚Óy„≈u»è‰:¸pÂ:Ãs˜Æz«›õ¡›«r√∏éOz∏ŒÛm‹Éñç‹Éuó∏Æï◊∏nü/p›∑∏áJzπáCìπá#ÿ\\Oßs\\œäNÆóü	˜)É{l”^Ó±∂4Ó…Œü\\øLÆüﬁvÓ)6˜å|˜LÑ9˜¨ŸSÓŸ›¶‹Ä⁄?‹Ûcz‹Ûì˜Ç˚Gn∞ŒÓ%MÓ•ÜÓïx]Óï)6˜™u˜Z(õ{≠€Ñ*»\r=“ \r-m„Üù‹¿\r{∑è{ßq#u∏}™‹à!=nƒo.7“œéycä{„Ô$7jœKÓ≠2˜Vµàmuû{[yú{;˜(7ˆ unlÃ?n¸IWn©úõpo	7°¸\07qW7q>Ä{GòõëÃM Ã‰&eΩ·¶€¿M\'+q”õπH7£Ê\Z7k	ƒÕäÀÁﬁ5Y¡Ωk—…ΩÎ/Êﬁ≠ÂpÔ/ΩŒΩ/< ÕNƒ}@“·>\\q^ÿ√}ò¯á˚Ë2ï˚¯õõ[˝Ü˚dŸ\0˜…à7èÃ-ÁÅN‹¢“\"nQÛ\"n1j -qr·ñYsÀ˝‹≤’~‹≤›Æ‹\nCSnÂÆΩ‹ \'∆‹ S‹™ﬁ‹ÍÖÚ‹ö◊⁄‹Z°\Z∑nv∑ﬁ©ñ€pﬁö€¯§û€î\'‡>Ω®«}∂≈õ˚<Ê3˜y+á˚B˜;˜≈=˜%∫É˚ÚH1∑5)ü€f3 m?? Ì0Õ‚v‹J·vL[rª‰‘π]∑÷p?ÇA‹èwr{O§q{Ø+r{„E‹ﬁæ€‹>¯.∑Õ9nt∑ø∏É;lw` ö˚Iu˜ìk6w‡IÊ/Ó‰{€páköπü/ÿsG¶rG~ü·é÷]‡~Qcpø‹NÁ~˘¡˝÷W«ùË˛»˝ÃsdTrqßálπ3¢bÓÃx?˜ßÂ˛&s~=Œ˝•˙û˚À‰2˜∑ÒzÓüå!ÓüO÷‹9 yÓ¸Ì>û¸∂Nû¸˚2ûÇYO·°o¡º2O1>Üßÿ”¿SínÊ)[ΩÂ-¨·-ä2‚©©+Û/X∆SP∆Sˇ~èßÈ≈[≤ºïßmuÑß„·…[ûW∆”eæÁÈU÷ÚV>iÊñèÚ†èÄ\nxÑŸ<»g-è|\Z„¡ßxà¬+∫≥ñ«PôÊqíUyú¥zóï«∑k‚	∑´ÛÑ≥Ì<…Îûå»ìâÛdØvÚVü\\»[˝∏àg®Òå\"*xF„;x∆6üy∆G™xk	™ºuŸœ‘˘!o}f\no√ˆ}º\r/BxÒºç[ØÛ6ÓK„Y¨ÿÕ≥t2‚YV{Û,?<Ám}D‰m„¶∂ço‚YE≈Ò∂3ﬂÚl¢+y;/*v^~œ€e|Ç∑ÀVÅ∑Î¶3œŒÚ1œÆÙ$œ°ı>oÔ„º}ùqº}JxéN\Z<ßk,û”O]ﬁAŸNﬁ¡ygû+oÑÁÊˆÑÁŒ}≈;Ú©ûwT=úwtb\'œ+˚Ôƒ˙dﬁ…U}ºìïÓºìs<Ô¬yûØ˛]û_vœ˝\0Ô4‰ ;≥—ëph/ b/(–ãT‡ƒ;óıåw˛˚}ﬁÖˆL^p 5ﬁ≈eOxΩ\\yó_‡]Cxó\rúxWÿ´xWèsyWÉ≥xWÔÒÆæ4‰Ö¨Y¡ªW≈ı‚ÖŸÒ¬º2y·^ûºÎ¡«y◊Ô\\·›8vêµ#îu\"åMy¡ªçûÂ≈Ïz»ãyÈƒã}(Ê≈”¬xÒNÈº¯ºÑœyâæﬁùÙÉº$ìN^ÚÅ/º‰æáº«Ωºådo^∆\\/3x/3ˆ/kã	/´$êw˜Ã!ﬁΩ‘áº˚°©ºÏo¡ºÏÈ≈ºájyè‚xπ€jyπMµºº˜iº|õº¬˚yEwTy≈¢Sº‚\\îWí1À+Õ}Õ+sÊï≈¸‡ïÕÚ KnÛ*¨ûÚ*2≥yïjt^•¡?^tëW’—∆´ØÛÍ÷>Â’Ö∂ÛÍI[xı&^Ωs8ØÅ⁄»k∏˙ç˜¥µä◊ºoØ%zê˜\Z∆xØ¥Ú∫lry]\rºÆãﬂy]Ÿ>ºÓmd^˜Â›ºmﬁá∆=º/ŒÒzLy}¨`^ﬂö#ºæ©ºæÒº~•£ºO™£ºO«xüŒΩ‚\rûñÚüù‡\rìxCµ«y√ƒBﬁ0b«v…·\ráÍÒ>Ø‰Ò>ø˘Œ˚zó¡˚V2√˚~îœõXÛ&éΩÂM‹Xœõ§bº)Ûªºﬂü∂˛|åÂÕ2”x≥âNº95UﬁﬂQKﬁø?Èº˘1o~b-o~ﬁä/ÔLÂÀ_\0˘\n:˘\nÂ˘JzbæRŒæ\nPÃW1≤‡´DÊÛUz»|’ä¸Ö«¸¯ã«¯ã∏Ú|5Òjæ⁄∫2æöÖØV=ƒWÎ2ÂkÃ¯\Zï>|ç._sß&_≥c7¡àø,·\'_WßÉØZÛıÆ:WˆÛâ,3>q˚>1µïd-ÁìÏ.Û°ìñ|X›àOπˆÅèˇ‚£ÑA>J˚ ß.$Û©`\rüÊÆ∆ß]¨‡3\"I|∆ìx>s•\nüï~úœÍ~Ãgˇ~∆Á¸ˆ‰s´í¯º+d>/’Ñ/H˜‚„ÀÎ¯∏%Åè{ÏÊãlö˘‚≥÷|	=é/5k‡K˜≈•^ö|˝˛ß¸UAy|Ém#|É˜Ê|Éâ?|É_É|„⁄U¸56V¸5Æ’¸µ´ñÛ◊©LÒ◊≠t‰õòÃ◊ß’7®?„õ=Ó‚õïà˘fu\"æY}-”õFæ˘ac˛ñs/¯í;|Éı¸mr*¸mæ∑¯VÀŸ|Î3Î˘÷Ÿì¸ÌGB¯;#=¯ªlô¸]≥â|[~ﬂˆ 0ﬂ6<óø;Ô ˜óÀ|˚I>ﬂ˛◊CæCÅøñ*àÄÔ¥a\rﬂi[ﬂÂ–*˛¡sÂ|7ÆﬂÕ˙6ﬂ}Wﬂ˝˜Q˛ë:*ﬂcáﬂ£ ÑÙÖﬂÛà<ﬂ´∞élG\"ˇ¯≠4˛ÒTy˛âu˛…Ás|üXuæO¬UæﬂV%æø‘éÔø”öÔpˇîr/ˇîS\rˇÙõM¸@◊K¸†»˛π¿¸Û}±¸–~c˛uÁ?¸E\Z?b<ÖI‹«èÃ?…èZÕ‡GÕiÛo˙*Ûouﬂ„G?‰«_¿èô˝√è˚∏íÔıãü∞Ù0?¡YãüÛÔD~‚\'qÉ¯IF˘ióNÛ”óõ3Ø©ÒÔæZ øwÆÜ∫¿œf‹‚?úº»‰»<æîü˜EûüosíütÇüføP;ï_¯±Ç_§V /ö±‚/\r‚?ZÕ/ı‰óæâ‰WXÓÁW∏à¯©â¸ä&S~≈∑B~Âû~•ø-ø \Z‚WáèÛkV‡◊±Z˘ı&~}ΩÑﬂˇ˚ç£«¯œ[oÛõ∑Òõª2¯-ª’˘-3•¸◊CM¸7€nÚ;‘;¯ù˚Ûﬂ:óÒﬂ~‚wˇÚ?»)Û?Ëæ‰¨W‰lô„Ï¨‡˜Nﬂ‚˜EÛ˚◊}„h‡ÜÚáÿ-¸°üG˘√Q˛gè1˛ãƒ·§ÒGèfÛ«RŸ¸±f˛ó≠â¸/5#¸/ìØ˘_W:Ûø∏¸ØúÁ¸Øq¯ﬂ¯n¸oéÚ¸oæπ¸os+¯ﬂÿÒ\'Ó\'oÒ¿u¸^N¸ô‘k¸üÃ\n˛œç˘?\'÷ÚµåÚ€·ˇ—˙ÕˇSÁ«üuB¯sóÊ¯s´˘ç∂ÚˇâÅ¬“qÅ¬P∞@a∂^∞‡_†X#(~æ(Paø®XËT≥ç™9w˛^Û,:c)P”®y”\ZCGö§{Ç%ÆZ;ÀÀ¨hœû,ˇ∑@†{.G†õ’.–Îó	V0¡\n€ø‚q∂\0ÿ¯V\0ú|* ≠Ω* ı∏	»cogÂb±\0˘b/@XÙî•Ä:uL@[A@Kû06	ò\r˜,¢\0≥]/¿n∆ÿR˚Ós\'j\\¿[I|#|≥dÅ‡¯fÅ†¨G xg.∂°—ì\0Å∏{F …çH~/¨\"—´.≈Vü˘%0¥|(06¿kÔ™÷ﬁ˜¨K,ò¨ØòÏòípÅÈ:oÅÈñ3Ç\r§`¡ÜÉrÇ\røO6>:\'03ˇ\"0˚ô&ÿt5A`ﬁ˙G`·\n∂>X)ÿ÷î!∞≤Xùø%∞~¯?7€gt6∂IõÀ¶Ç]Ø[⁄wÅÌVSÅ]ÚÄ¿ÆÀS∞«^S∞Ání`Ô‚}ÇΩ:˚”,~WúŒ;	ú5\nú/o∏n\nJıÆ“á◊7m7ÒÑ¿˝ÑÜ¿=/BpX1Yp¯áXpƒ÷Bp‰¨û‡Ë˛ıÇ£e⁄ØEq/ØÉ/_¶‡XQé‡xã≤‡ÑŸV¡…ë¿;®¿\'Ù∫¿Á∫Æ¿\'¶I‡õK¯éo¯—l˛€¬ßh«˝Çs∫GÁÂÎ4‰¡ï≥Çãi¡erñ‡raú‡äœ† ƒ\"Opm§I > ∏ÆºTp]ç\"à–ÍD‹ˇüR}A‰±UÇà•‡Ê≥B¡-ì`AÙæLAt{∞‡v?]cÇ7Hs∆Lß‘\"H8E$l$fÎ	í‰eÇ$Á$AR¿† π?Uê¢z[ê2ˆHêZ•!HÎ“˛d.\rdrhÇ˚à@ê}ŒLêÛL,»ô÷‰˙\r\nû<⁄-x21!»ªz]ê◊Ú}fÇ<A—πA—%Æ†ËEî†ƒ&YP˙Ûò†t6LP÷		 Q;AyÉ∑†Ú¡FAe9]P˘ŸCP’í ®q‘‘¶XÍGB\ríPA√∂/Ç∆\'!Ç&À:¡ÛÖ˙ÇÁ∑◊\nû9.xÒ∞N–*I–ö:\"xıè*x˝†MÜ˜G–æpë†Ω•S–·· Ë~\'ËÏ˝.xg<+xwQ[ÓŒê‡]˜à‡˝M¡˚/ÇÆ§A7\'R–mp[·®á†\'“@–sœN—˛ª‡„Äá†7EY–wÙ√ê†ßÖ‡”â\\¡ß¥>¡‡m?¡ç£Ç·ƒsÇë}g#yyÇ—ï)Çqÿ@≈^A0¡?&ò∏7\'ò¯ÿ)ò¥úL~ÑSnÇﬂè~L	¶õ?w¸tI¸.Ë¸û¶fMØ	fØÃ÷i	Êé™\n˛*”õÇ–%¡¸ç\'Ç˘X(ÁvG(ón î{pP(ó˜^(Ô/T∞ïi\núÓ.∏ó!\\ï-Tµî.∫¸\\®ñ}_∏ÿ¨P˝}µPsÒ°Q(‘≤†µÏÁÑZ¬•ˆØÑÀ~µ∆Ñ⁄iÄP;›M®¶$‘=tB®õL®˜x°ê@Î\Z?\nâ˙uB	I7	…ÜÜBxK∂æb$§‰5È!µì\'§Ué	{\\Ñ¨Œ”Bla§ê≠(‰Ë¡Bıäê√Nr+Ô\nENöBiE(sx$‘M\ZËÑ´Éw	\rÁõÑFDU°œXhdÛ^hÏg\'\\+á	◊éñM2ˆ◊z+\\8 \\7.‹é*‹ÛN∏ÒßÇpìnê–¸í°–<ÃRhﬁÏ/¥®VZÙÆZN<nµY(‹˙∂E∏m¬NhΩ¥Rh}\'B∏]ÎñpáQ¢–FÌñ–fU±póE¨–÷˘ªp∑⁄]°ΩnÖ–>eÅ–æÙ∑–˛œE·^x≥@Úê–˘»5°ÀñF°KKµ–ùh&tÔù≤ﬂ\"<løHx8ƒYx¯Ìo·ëµÚBù@°á≈O°«sE°Á√µ¬cVy¬c{¥Ö\'>ı	OZmzG}˙k˝?M	œhf	œ‘ØÜ\nÑAgJÑA%#¬sñ[Ö¡ÚKÑ¡GÑ¬ãèKÑóÆE	/øÏ^1€\"ºí;-º“ º2˝[xµ‹BxÌΩTzh©0,S$˚+º?#åÑÓ	o,[\'ºA} º˘»S˝;H3]\'åïÊcÿ	5ûm	¬;ÔÖIi¬dﬂΩ¬î&PòVvSòˆ6Oò.Á\"L◊ﬂ\'Lüf`¬◊·˝ØÖ˜É^≥˜Á	≥o&	l[.|\">¥>ºõ$|ÿ∞]ò≥›_¯Ëaè0O®(Ã;ä	Û7\\Ê_ø#ÃüèÃö‘GûããØ{	ÀÛ∆Ñï¢Qae˘5a’ˇ⁄Æ^ó+¨Ö’Ö˚Ö56œÖ\r¶¬∆˜ÀÑç#a¬ßÄïŸ·.·ÛÂÒ¬ñ°¬ñ˚Ñ≠=¬WÖ!¬◊¥{¬7A´ÖÌfç¬ˆP]aÁ™Ô¬wk¥ÑÔ	ª4ìÑ]m©¬ÆŒJawÜ∑∞gÎAaœn}aüˇUa_Á.·PÃr·∞ˇv·©q·Õ¬·§o¬œã\n?oÚ~;±X¯-ﬂ@8e\nß˜Œ(\Zjﬁ˛\\)¸uÛîp÷å\'ú;> úK•Á*\nˇû…˛ÛüŒüÆŒW§‡r⁄{p\ZW0ΩÇ+ú=å+º~à´¸V«Uß6·™?™ÒÖË|—˝µ∏⁄˝o∏⁄K#\\≠EW\'©‚\ZÚ]∏∆Å|i(ætr\Z◊a[·:µ¯ræÆKú«uÀ·zK˙pΩ–›¯\nÊ8æR≤_πâèØ¨]Ä„ÑÑá8È¢\ru\\∆a~#é®∆—•\"ú\ZM√©Ø~„¥.8≠]ßG◊‚‚Œê&·åÁÁq÷eCúﬂäcˇ\\pŒJú;÷ÅÛŒ¥„ºöÕ8€núüèÇΩqA{<.¯gå„Q´q—ﬂ∏òÈäã˜]∆≈ÁGq)Uóﬁ◊¡e‰\\&¯åÀÃ˜‚≤üù¯™≈’q#’C∏√7:dàÀˆ‚kLﬁ‡k‹¶5S ¯⁄∂7¯⁄q7ëz„¶ˆ-∏È»S|=Ëão∞	≈7Æè¡7∫;‡é‡f€-p≥ÉD‹,læ)¬7€ß‚Ê:≈∏EYn1œ¬-ÕõqKæÕ)ﬂV≤∑Z)≈≠v	qk*Äo?À«mÚ∏MﬂÈ˝	ﬂïÉÔjw«wçù√mcÀp€\"\'|˜˚¯Â’¯ûïâ¯r/æ«|ﬂ∞wàœ«F‡{5ïΩzªÒ}‘Ω∏„≈\'∏cı|ˇ‡_¸Ä≤3Ó¥ÔÓ‰Và;]„‡.´\rÒÉ€pWBÓˆh!Ó÷ÓÖ⁄∞?¸ÿ?¸ÔÓ!⁄â{º˚Ç{ﬁ}Ñ{V∂·ûˇN‡^îp¸¯K\r¸ƒˇu<@∆Ω	∏Ô-G‹èÆé˚ô¿∏øu9~Í—W¸,≈?€#ƒñâ\0x?6çÌ\\Ä›\Z≈ÉÜ„Á‰^„Á»Òsv~ﬁH?Ô=å_0\'‚jˇ·¡p:~1«/5∆/ ÀœÒ´ôO´œÙ›ªx»ùx»té™‡·≤ß¯ı\"ÒˇXqﬁèxòàGﬁ~áﬂà9ÄGi¡£ﬁæ¿oÂD·—∫Êx|Œ?<—tO*>á\'À´‚)‡?<Âáû Ÿèßæ¨≈”\\„Y˛˘¯›¿.¸û‡-~Oˇ~|Ç?Tó√sÇºúz	ûhã?ŸÉ‚˘;ü‚˘y¬3G¢-xQV^Ù2/˙màc?ÒíOÒí?º¥0/≠>èóN‰‡ÂÅxÂ)\n^ΩDØ©6ƒkÌ∫Ò∫£xÉÒºëÓà7Ì’«üﬁ;Å?œê«ü\0x≥ü5ﬁ·à7ˇ⁄ä∑‹˚çø‚ß‚Øƒq¯kÓi¸µXo∑ZÄ∑Wn¿€Gn‡õ	xÁÚ|¸≠_˛6œ;tó«¬ªL≤ÒÆ°zºÎ˚Uº[ªˇ∞ˇxêÅlË√˚FV‡˝„˝ıπ¯Ä≈>Ëÿè]¿á;Æ‡üáUëe©¯»œ)|Õ≈G≠ˆ·_VRÒØé\r¯◊ì;ÒÔó>·ì¨›¯T—˛√\'ü¶x·”≈≠¯Ù\Z>ÛÎ >Ûßˇm∂\0ˇΩ=ˇÌÌèœî‡skŒ„ˇÓ∑ä‰ò€EÚNë¸{@¥‡…ëb(RıÆ©6•â\"KEOuä^fãô¯äÕm-6\niúâ-y≥Z¥dJ “‚Yâ¥é‹i›Ω\'Z™4.Z\Z¸A¥Ù°T¥lï°hYnëhY©L§C¯ “	±-ﬂ[)“uÚÈÌ ÈçiâVp£E+|≠dﬁ≠¨Y#\"<; \":œâ@™ô‹°!Ç&1Ÿ˚òÆTQ™9Æ(B˙ DËT®àñK1*˛äòÁDÿ˝√\"Œï1g _ƒUPqc\"Óã\"oq¥à«¨Ò2óàxzD|=ñà=Úˇ¡Û¶H∞≤U$ ,	™CDÇﬁﬂ\"¸âùH4Í íuuãÙÎ⁄E⁄M\"Éq-ë·ˆ˝\"√=ô\"√Œã¢5;ˆâ÷Ñªà÷°¶\"…ú»‰x´»§·°hΩ¶ßh˝1ôh}»/—˙Ø•¢\r\\\r—ÜuÉ¢\rGE nã6vNã6˛^(2#÷âÃv|m2	m∫ê ⁄≤™G¥%®_d°j(≤X§\"≤ø%⁄\n®â∂ﬁX-⁄∂∑]dÂUdΩ√O¥Ωâ.⁄µ¢JdªÿUd\'ß\"⁄R\"⁄≥õ(r8—-rHIÌ’\\+⁄G[\'⁄∑˚õh_Ò1—æñı¢˝›)¢%\"ßg´DÆûä<¥ÇDﬁkDE†Ëÿ≥\r¢[Ÿ¢eπ¢ìîj—I;W—…∏w¢ì\rA\"o9+ëwƒsëˇSe—i•—Èñh—ÈÅe¢3€1Q¿õi—9˛ú(XÌü(ÿˆÖ(ÿS(\n\rﬂ˚ü —•S·¢À˝™¢k›.¢P”^QXÚ}Q¯Å<Q¯∏æË˙:k—ı∂J—ıèÀDëÖ#¢xÄË∆Ó«¢õ˜ÛE∑nÌ›¶ÀD1ÏjQÃ¶nQLÊ5QúÁQ\\P°(Qı∑Ëé©ó(â!J‚:àí+ô¢îŒQ*ˇ™(5ﬂKîñ§$Já¥Dô{˚Eô7DôiEôU4Qñã°ËÆÒk—ΩÖgE˜|ïE˜˛Eà≤«,D¥∑ã4n=Ù+Â(øÂ\\˚ﬂ&Ç¢ú>%—£ÔE‰	Q—öLQQ≈Q—¸gQ±˝sQ±ÎQqX∫®d¡Qâíß®‘Î±®åÆ**ØoïwNä*G.ã™ÆˇU◊Ëâjd?DçjlQ?N‘î¬=Õ0=€/=´Ò=œñâö˘ãZ<EØé∫ã⁄⁄bDÌˇŸ€36ä:ÇË¢é¡F—;ﬁîË]_∂Ë›7é®Î,_‘›≤C‘˚Ã[‘G…\ræ˘ \Zû\r}÷w}˛˙U4b*\Z’äçºçñ:â∆B√DckD_¯«E_∂¶âæö™äæ›êä¶ÃªE?∂äE”Zd—LÍ—OæâËwbëËO«—¨ä©h∂Á¨hˆ€\Z—È¥ËØÁ±úaàXŒ7Y,3\'^pøC¨H˝$VÙ;(VÇ≈ãˆÛƒã⁄àì,≈ã≥4ƒã+8bıü/≈\ZLw±FbàXÛË.±ñŒJÒR”2Ò“ÅaÒ≤%Abm$÷±X!÷Ÿ˙^¨˚J$÷≥˛+^ë≠%&∏ˆäâ˚£ƒ‡áÖbËü–‰\r1,¨√µbxÿMLqÆSéˇ£’41µrØòÊ”!fP11Cü.f‹gàôª#ƒÃ˛41´–[å≠Ÿ.∆2|ƒl—!1{xDÃŸpNÃ[LÛ éòwEÃÔàÔZƒ¬g˜≈¬Ê1n†*∆◊ãNÆK2À≈íÚ?b)rF,õ⁄$÷\'ÏÎãÌ≈«c≈7]ƒüÙ≈´]TƒÜ[÷ä\rìâ\rúÕïâçÖ\'ƒk´*ƒÎÆ†bì{°bìíÂbì∆x±Ió≠x˝–VÒÂÒÜ„ƒ∆.ãÕ\Z®b≥v9±Ÿß±˘¬(±yúπÿ‚ÿ±≈ko±%;Ll)m[˛2[È¸[7…ƒ€;ŒâwåP≈;∑ÆÔ|ˇVºkÌ∏ÿV—NlÁıGº€JSløï(ﬁs’VÏ@t;Xà\\õƒ˚¯â˜€\\Xâ‡;ƒN’«ƒŒzŸb?uÒ¡\\éÿUG vC]≈nùßƒá§˚≈áÌkƒGˆ˙â=ﬁ{=ö_qH|\"VO|“Ùö¯d~¶ÿ{w§ÿª˚0(bü{õ≈æÒi‚SîBÒ©f?Ò©©≠‚”ƒßØ‹üœx&æ∞î&æ†À_ÄRƒ\ni‚`~∞¯ „FÒ’êVq€ZÚ„é8î∂Ef™/˚?7™[ƒÏpq◊Hy+T|CÎê8ÍﬁÒÕ¨k‚Ë[Wƒ—Y≈±øÁƒqñ;ƒÒ÷ü≈ÒAŒ‚¯ê=‚¯hq|Ì%qZ,N∞ÿ/NHﬁ/N§kã=Jƒâç‚;\n=‚;˜≠ƒIÁ˚ƒIwéäì\Z2ƒ…’π‚‘hâ8≠ \\úNéß_*gTEä3è|gYÃäÔ 3≈wW|ﬂ5˝,æ_BgÁÕà®ä»Ë‚áQ=‚∆aÒc?Xúõ™)Œ}ÚG¸ÑäàÛ8/≈yŒ+≈˘NÀ≈Ö“\nqaÆÉ∏p@Q\\4ÒV\\<A\\≤‚à∏L„π∏¸Òuqy´ü∏\"5X\\Ÿ≤C\\•¯P\\ÂQ\\{kΩ∏Ayó¯È˜qÒ3π]‚g¬s‚gÔpÒÛ‘\ZÒK%%ÒK ˜\n≈/Õàõﬂàõªüà[8‚ñ‰˜‚◊Ï«‚◊ØÁƒmo‘≈m}>‚7{TƒÌ„˛‚é›dq«ˇµË\\¥F¸NiÅ∏koï∏k8_¸aπÜ¯√^é¯√âqOaö¯cÃ®¯cv¥∏ó≤H<p¡[<tˆ∏x®÷E<‘„&˛lıD<˙RK<6¶\'áMƒß´ƒìf›‚\n-‚ÎÍƒ?Ûƒ3\Z±‚ôûrÒÃÿ1Òœ\"ô¯gãâ¯W^Ç¯œ©É‚?ˇ\nƒ≥°ø≈s5Å‚ø´∂âˇ]hœSàÁw:K‰⁄K»OHÿÿJq≤DÈ∫∂DÈë™D˘Àâ™∆FâÍ\nëDu”g…¬\rC5_Íˇ∏J‘Úl%ãıì$Íg[$Íâ;$ÍowJ4B3%ö˝çí%çK%ZNY≠¨cmıâˆ^7âˆÿ…Ú”]·kâÆ8F¢˚K_Bÿ.!:ÍKàs]h˘=	π»E´‘H`-D”ª%‘›5Íû≈∫’q	}wÅÑa±C¬∫∂XÇqˇJ8k$‹Õó$‹=∆ﬁúP\"ﬁ‰+ë™xI§õIíUZ%hâƒ‡‰òƒpwãƒË’wâ1qΩƒ∏ô)Y#Îê¨iOíò4ﬁíònöóò\rêòæ]&YO‹&YﬂÉI6é\'J6]LîlÜÆKÃ≈k%ñ˚f%€ŒXH¨tóI¨\rkGL≤˝˛u…ìèí7+$6Ïõo$ª÷ÓíÏÍ¯%±’ûñÿûËîÿû.ëÿ≈JÏé5Kv+zHÏO=ïÿ◊úîÏ1˚\'qêoî8®\\ïÏsÒî»>!q˙Dí8[’J\\N$óJ6OJˆ˝ê∏NI‹ÌÚ%áå¨%á7hK∑ÕH<‰Á$±|…Q˘âÁµ/KrBﬁPr“®KrÚµ©ƒ[—_‚ùÂ Ò	î¯2ä$æ”…gæƒ6^rJ˘ô‰‘À)…iÖøí”Oß$gî …ô€á%g>ä%g+$ÅŒ$Å	Åís¥ísõæIŒŸIŒ›Ïîú+‚IŒ´=ñúÔ\\(	æ”/	.],	Æ%H.“ˇHÆ∞øJÆäﬂIB‰3$a\Z…í∞ÍDI∏˘I¯±‰∫•è$‚‘∞$‚qó$í\Z-âî\rJ¢õ$7eùíõ.—íõˇ¶%1Z$IÃ:KIÃË2I‹°í∏¥`I<ÿ)πs†VíÃUí§‘ÎK“†	Iö˚∏$]Áà$+3Qíı$HrØ*MÚPÔ∏‰·¨ö$«Îú‰ëjû‰±Fñ‰qEík≤\\í}Síõ ê‘◊H\nöÛ$ÖæÊí¬´—í¬xSIa“¨§»Ò∑§h∏RR¬{,)IÅ%•©ﬁí≤†1Iπ‹CIEx∂§2Á§§≤˜†§JœARmò%©≥î‘.óì4¨\"J\Z\\+$\r„™íF$H“8yR“tˆú§)ˇ¥‰i∂PÚºóº(Ûëº|9#i^\'iQﬂ%i)¯*i}K“v3BÚfÂI{ûæ§£˙®‰≠Ïπ‰Ωã∑‰}˘C…˚)CI◊À|…áE)ímùíºD“#Ÿ*ÈŸ€/ÈÈ{#ÈΩ¨/ÈÌ◊ñ.JD_%˚H>˘‘K>u&JÜVÊJÜ7\\í[NH>JíåöyJ∆$cÖâíÒê„íÔÎ %ﬂœ◊Iæ_0óLhﬁîL–’$ì¢…dÿn…‰≠H…‘?%…O]…œPLÚÎØí‰˜APÚ€«\\ÚßÛ™‰Ô¶@…ﬂí.…ﬂ©/í˘ÉÉR9»T*ø≠H™tR∫p≥ïta∞D∫HiN∫Qó.:∞]™¶˘C™f” ]¸}óT√}D™ie#]¢¯A∫ÑÉHµHá•ZáœIµnIµ^€Kµ˛\\ñjÕuIóvÜKµçs•⁄üiRù|äTÁe≥Tßü$]~Ú†TWíÆt¸,%8}êF¥•ƒÛ•ƒŒÀR¿~D\n∏ÎHÅê\Z)8‚)%tKI{∫§$«çR»ì%%W⁄Ka8\\\n_⁄&Ö+À•îñ)ÂˇK*èJ©áÁ•‘[3RZlñîûæU ‹√ñbÓ™R,kDä\r∆KyO‹§¸õ{§√y©‡íßWø/≈€ˆJ≈◊•‚π©dïùT*#ï•KeÕER˝ß©}ªtı©≠“’©R„øá•kÚnK◊]oóÆ+”ñöâïnH¬•jøI7¶nñn¨÷êöô?óö≈•õ‡Ì“MÊRszó‘\\`\"›b∞[∫≈ó\'µ¯)µºì\"›ÍˇC∫Õm≥‘ S]jÌ®*›æìnØ’ïnˇπG∫CYU∫„$›q5@jù\"µuàî⁄e&JÌjR˚wÈûY∂‘¡‹VÍ≤MÍÑmê:Y8Jù\\«§ŒÇRÕ>©KpÜÙ‡\\zp⁄QÍ⁄¸AÍ∂mXÍÊì&uî∫”⁄§Ó¸tÈ°`KÈ°_W•ÊÈRØF9È1£W“ìÿ5È…iM©œ?\\ÍgH˝ùÓK˝ÉÂ§˛ü§˛m©ˇÙiÈôß€§gÁ§ÅJ∑•Å_‹•Á®w•Á≤JœUlíûﬂ‘/\r˛ˇ,¡©§ór•“ÀHz≈\Zñ^©Iî^uœî^˚›,\rÂØíÜ PixòH\Z·‡-çòΩ/çœKo|ïˇ@\Z5,Ωµ•C\ZªjP\ZØú#ç˜£KˆzHì”^Hì´ˇISU.KSeK”îy“4Ú∞4˝%Cö,Õåª%ÕöèëﬁÔsìf€ÜI\Z}ì>∫F˙∏J&ÕÎ-óú…ê\rIãéØñù`Hã˙r§≈∂Ú“2tRZñ∫[ZéÂK+¥b•á\0i≈i%<!≠Ù}\"≠ZÅI´ºïVoñV˚©H´ÀKkNK§µz•µ¶Á•µØøIkgWJÎÄı“∫Ì5“¶$Èã]Õ“ó´Qiãø≥¥ıÏ:ikò±¥≠rõ¥mFQ⁄Æ[ mwôë∂˚®I;˙VHﬂæˇ!}7Ë.}ØÏ+ÌZ*Ì∫ë&Ì~F⁄˝4I⁄≥6]⁄”T*ÌÌQêˆEVI˚Üã§˝élÈ‡¶Èê≤µtà∑[:tòt(U[:ÃNó~~{W:B©êé:8I«îﬁI«ØJ«|•_¿`È◊Ä5“	gX:q◊V:πêNfßKg∫Hû“ë˛J)ñ˛Íz&˝-¶KWæï˛πO:´ªF:ê/ùS≥îŒmQñŒﬂLê…Ïï)®Ôó)\\îì)9»îrø…î	∑e èµe*ÿ.ôÍÊ}2’è€eÖ±≤EÆõeÍ$¶L›T_¶°P#[˙ÒßlŸ•!ôˆﬂ*ôN∏≤LÁO©l9’D¶{fùLO;^∂BÈ¨l$/[±cΩl•a¢åñ Ä¡<xtPF“¯(ÉºêA◊ïdP‰^y‚Ñå¬ﬂ-£ålï°›ù2Í¶Ö2:Â¶å~œHFvñ1ÍµeÃìâ2ñQØåeó&cyre¨g?dÿG\'ª‡úåìU(„5Â wKe¬Ôwd¯çˇ\0ΩÌ2±£≤L|é#ì5 d\Zì2ŸıyŸ™£Ÿjú#3Ù∂ì≠”ª$[«]$3)Tíô⁄’ 6~{,3{_)3◊µïôWYÀ,bdñKÌeñŒ°≤mG.…∂˝∫.≥∫‹(≥ñGe÷Kd÷€ze÷m≈2˚√Ôe{0_Ÿûå0Ÿû¨´2ç2áô”∑”2W|áÃı¿yô´≥õÃÕX,;§\';tzáÏàFãÃCç/Û»ß…<äÓ éz ézÂ <IKdû˛•2/EëÏ∏™TvºèÏDOÊ/Ûm^&Û˝‚-Û”Úí˘ã˛£∞æ£π|ﬂ8ÄãPH Jd5ÏT¢>„˘ÏÒ|ˆûI•\"*öVˆHV\"#	EYY	…ÃH≤J∂≤\"îÍ˜˝ù˚ºŒ˚üÁúÁæØÎ˙„2á‹\"!°æè˜Á!^:ÀY*ƒSÒÈtÜ¯EwC¸˙e!~¡ˇ◊Uê\0ß√ê¿«⁄ê¿‚<H‡l$»ŸrÓ;$‘∞*|	Ω∑~rG6rÁ›H¯˚»]Ø/êªÂzêàøÅê»C<H‰ªÕê(]MH‘ÂDH4-\nrèíâï:â›q\0rˇ\noõIºwíd–\nI:4I≤á$Ö[AR‘ëêî‹ÉêG2ûêG∆ãêGdG»„Q*$-÷íøí^í>•yjtíπ/Ú¨<Ú<Ò-$zí-¸…o3Ä‰o,C\n¯ÒêÇLH¡ §P9R¯6R$BälÕ!Eâ« ≈iü /ª˜A^=ª)ìÇîù\0)Î{)[∫ıüH≈62§¢úyΩÈ§R–\n©¸Q\n©ZìÖTÔx©6’Ä‘M)C\Z.hC\Z<`êÜi	H£˙H£π§ÈkÍÄ§Â°§•l“zw	“ZpÚë˚ÚqX\n“Q¯“˘Á §´O“m{“Ì\\˘Î˘‚=\r˘íß˘™¥2∏˛\r2dLÜø ]ÇÎ!√FıêaÀd»».=»àádT^2vØ2ñ_\0˘&ÒÚ])Ú∑ÚΩT2ÈõôíÏÉL«ÜA¶ST!”É<»å[,d&˚‰á¥dÅÒ\r≤TY§yCØmÉ,ﬁ{\r˘um+‰wødπ…\n≤<u≤j[Y\r£BVˇ.B˛8ïC6Ã≈êçCsêøg!˝Œ@˛>~\r˘woÚÔÈ»ø·`®D<*0˘ü%®Ùd\rT∆X*É◊Ç <SÜn˘ì›Zs*Ø≤›æk∫„çTŸ$™{™g	U#¥@’€‚†\Zw°\ZüÌ†ª√“°ö¬h®ÊÂPÕ≈PÌ‰”PùÌ!P\\	TßË\nTwﬂT7\n’Ì/áÍ=oÜÍÔΩ’wÁ@˜2ÜÓΩî	5‘ˆÇöfN@Õ∂©@é<Äí:=2µ(RÜZ¸kÖΩ˙\njeﬁ	=Ê·	=ˆÌ$Ù8ì\r=y\0\nIÑBÂ‰†–ù(˝\n{ÍÖˇbBg2qÆäÙTÄb˜B±3Pú˙>(˛F;\rJÄ˛Ä¢ü@AÂ(¯DJ2;•¸jÜRâuP⁄˛(ÌU	î3•äá2Á°ÃﬂÌP; >q æ˝ !ÌÄrÖPnŸ®@\'*|\0ˆÄä>~áäGÉ†‚#ËâØ”Pkï«–ì¶/°ß‘ò–”vnP[ÖªP€ã˜°é2≥PG|‘Ò∆CËπìf–sE=–∫+Pgå6‘π\ruQuÜ∫®É∫tò@]„°–Kz*–K§†óØJB//LB/ØÃA›Ñ∑†Óf\\Ë’0,Ùjï	Ù∆Ä2Ù¶S.Ù÷∑MPœX%®2z˚„<‘ÔU4‡ª54pY\Z4m\r6ˇ\r∆ûÉÜÏ>\r•§BC#!––ËÀ˚–;£Ê–ªßf†w_ÄFë°ë>’–»l\Z4Z…\Z}ˇ94f@\0ç\r™Çﬁ?jç;çOôÖ&¢†â‘.h‚ÙshÚïBhÚ’!hÚ˚á–á‹hJ‰%Ë#˙ËÆ\0ö*}Ïªöˆ&4mvö˛@öû∑ö±©ö!ßÕx¥˙‰L*ÙIB	4≥≈öïÛ˙Ïö∞\0Õ•`°yñ“–<\'h^|4Ô\rö7ﬂ\0Õ˚;ÕoÙÄæàÚá∞ÔB™R°≈whq¿\"¥8h+¥¯q9¥$DZí¶\0-~}È	}•ÜÑæÍ∆AÀ¬F°e˜≥†Â∞hÖÚ9ËÎñ4hÂ˘!Ëâ«–7rw†’¡ì–Í‘–⁄76–∫ã£–˙sg°\r˜,°\rÌK–&Ÿo–¶h≥&⁄≤&Ü∂ÒüC€Ã°Ìn\'°Ì·z–ˆ‰eh˚Áã–ˆë–√=–Œ3G°]⁄á†]Wå†]∆–Æ!hw…OhÌ¥Oh\rÌõîÅ~˛x˙yQ\r˙•E⁄~⁄ˇΩ: Û:∞z\r:$ñÄ•∆@áï\\°√£I–QMKËX∞:ÙõíÙLù÷ÖN<‹ùúáNßÍB˜Ctlá˛ƒ°Ûy–ôì–’Ì\n–U≥YË⁄tÌÎt}π∫±Ÿ˙/hÙﬂ∞L¬ ∂ÈI7LÚ®7LÚULÚ&=\0ìje¿6ÎV¿§	Í0ô\Z$L÷Ú/Lñ}&€Û	∂ÂÃlÀEKÿñ—k09€Î0yˇ£0˘Lòœ∂Ìå2LQ¶\r∂˝YLI#¶|Z¶¶Ry¶*u¶J;SÍSÔÖ©ˇ‰¡vj√vãCaö\Zõa⁄íÓ0Ì+7a⁄)ßa:F]0ë¶Î|¶wËLØÚl;†	;‡§3PkáÜT¬å‰¶`F®UòÅôï{√Ã≥ù`ÊuüaáBäaáFp∞√Kÿ—}0Àniÿ1]ÿq”ã∞„ü`«ﬂÅAı2`∞ê;08º\Z˜ÃÄ!?_á°’ç`ËòtÊH{å√?±áÛ90R°4åö≤£kÕ¿ËèÆ√ØGaÃ„0¶\rczÔÉ1}CaÃ˙=0j∆ÍºcÉoaxå˚‰åWÖÒ±N0˛Ç\rL∞VÊ¿Ñ]xò¯Ñ+L|˜L|?	vn;1∫≥v§¡¨ó∑¿N±¬Ï\rraˆÿ!ÿôn<ÏÇ≈>òSè:Ïb≤ÏÚèzÿï∆0w˘◊∞´*?aWuR`◊^¸Ä]7ﬂªÈ¥	vÛ≥\nÏÊè\ròá:Ê1{Ê∂ÛÜ9√|˛L√¸øùáÍ&¿¡;\ZaÅ√)∞`A8,8¸#,ƒƒ¬UÖÖZf√BQÜ∞–?XhM#,ÏsÏÓ6kXD‰8,≤-\ZŸﬂãR˚ãi≤Å›ìÈá›+_É≈Y‹Ö≈ù~ã__á=¿0`	ÏTXB–,1\rÑ%Æ¡ít\r`…Õ√∞G7˛¬RÉKa©’<XjcÏÒ@,M¬ñ∂ÉKÉ‹Ñ•„aÈ#c∞Ùj∞\'í?aOTzaOÔ¿27ÌÖe™Ñ=ß+¬≤sXvâ-,/ ñ°V†‹+–á\0Ö∞¢$5XÒXÒ1/XÒ¬KX	d\rVÍ5\0+ìáï~ÎÅïŒ›ÉΩ≤vÅï©Ö√ L|`eË-∞2ˇYXyr¨b;VQ,{]~V)JÉΩ·\"aoÚzaU\"GXUÍ3XµV˝,V≥°\r´;Ë´KWÖ’i¬ÍMΩ`\ru„∞∆ô˝∞¶[á`Ô¯q∞ñû<ÿ{	\rÿáñc∞è¨.XGô¨€n\0ˆ˘Î-XˇÆ/∞~˜∞˛p#X6xº	6tﬁ6Ï7+»ÅMÃô¡&÷raìzç∞…Ôë∞)≠NÿTO<l˙‰ l∫Ù:l&zÏáÒ\ZÏáΩ/ÏG˚l	¿Êl7√Ê5ÊaÛ⁄ˇ¡ê`ã˚∑¬øÕ¿~ŸÃ¬~#˜¬ñUˆ√VÃºa+øVa´w√˛ÿ¿˛ÑZ¬÷+≠aÎ’9∞øŒ;aˇ&n¿%£7‡õÛ⁄·“n„≠ﬁF≠µc≠Àöp9ÀE∏<R\0óoÇoˇ\0WînÖ+¬«‡ä3Zp≈ye∏‚Ü\\)‚+|áF=|«»\Z|\'‚|\'Ò<\\9wÆ≤BÖ´f\\Ñ´ˆz¡’wúÑ´øÉÔNÇ¡w?¡5Õ≥·öêõp-‚4\\´VæÁú|Où2\\€∞Æ˜¡Æ◊#	◊óèÄÔï	áÔµ^ÜÔ´äáÔßºÉåh¿\r«~¡Õ¡ÍÙ¿\ZûÇƒT¿^√\r¿Õøô√uÇ.¿è,ûÄ[*õ¬è]ÚÉü@√·?˜¬Å≠8pJ\réxªéx_\rG=ﬁG[n¿—¨påˆ[8>√N®hÑö˛¬ô2CpñÚ~8Î%8˜ª:úw\0Áﬂ·¿è¡ÖæpëÎ}∏¯I8¸,nç]Éü4hÉü\nñÖüÆöÇ€˛Ç€˛~∑«ƒ¡œNÑü›=\0?ÃÅüMKÑ;Œ¡œMÚ‡Nt‹Ÿ›~qk\n‹UI~9Ô/¸äÃG¯ï˝u+¡”+o·WÜØ¿›~{¡›…$¯’∞J¯µÉ¯µN=¯µ\r¯MÃ0¸fÓ¸fÂ9¯≠•≠[}·^‹+sÓïó˜©”á˚¥Ö¬˝Á·A°3`≠+‡êx(Í!<‘.Í¥Î÷Ñá¿ÔzŸ¬ÔNL√#{¬#éY¬c˚Ì‡Ò3ﬂ‡	?x‚”~xÚò<ÂÒix D¸Òë&¯„n]xöƒyxö‚ox˙ˆ~x∆€q¯”£∆ß¸πb7¸π√xnV$<Ô‰mx^⁄&xﬁáZx~íº‡Ôx·Ê˜‚pxâ-^R¢…¸yZ^:U/ÏÜWUÄW?<ØÒÛÇ◊yl¿Î∆ê∫Esx=‰/¸mr	¸mΩºQüoÑ∫¬õí8¶9ºπ\'˛é~˛NP7’oMÜ¿?|ZÅ∑π√;zÏ·ùÍYŒ«mŒ∑-Ó¯xØ sxÔ&º7€\rﬁ;Âˇ¢ˇ¸†˛ˇr5>p¢>pÖ\r˙’.~û\ZÄè™%¡G)u—∫´—{¯ò≥3|Ãe	>V;)áè[üáè?>\nˇ|>ëFÄOAõ‡”W,‡”ﬁ^ÈJK¯è¿˘\02|Qò_ºªæ[_|˘æÑHÖ/ÖÔÜ/eB‡+N·Îgñ‡\'›·Ìõ·gÂÅMá\0…RÄ4>êéxHg¿Yüe`Àõ˜Ä‹ïj@Æm7 7Ùêw=	(∞´ÖP†¯˛6∞=ı\'∞=œÿæˆP˙—Ïÿg	Ï‹⁄Ïújîç\rï~@eâ\0®~˘®ı˛‘€0Äz˚I`W¸/`7xÿΩah’øˆ.{>{æ™{EÄﬁ≠\Z@_aÿk=Ïè4\0<;X*\nn\0F˝ÀÄ±Ÿ$`≤Á`íúòöw¶ŸÕÄô;\Z0K®ˆÿáUGÄ√\ZAÄÖÙ¿Ú…e¿ä6Xù]\0¨\"≈¿1ΩR‡X·p|ˇpº!\0±Ÿ@Æé∞YU\0ÓR¿˝>?—\0¬?@~†(≠,\0’Ê`Í˝¨ªÄÕˇ‡ç\0x‰%\0üäÄ¯µ\0Oœ`z7@≤ÀH…V\0ÈÈ @>Ç\0»7Ü À\rÄöv	†…]Ë<:¿h0ò_&é]¿;Í¶§\0!≠ßÅªR\0Î†%¿∫\"8Y{8-˝∞ï⁄ÿ98\0ˆßûˆØr\0áèÅ3Á˚Ä≥Ó˘Ä„àp˛Ü8_+	89êgÃ‡\\H.¢W\0”(¿Â”a‡ Ø¿ÌÀ‡6§∏?nò‘7àßÅ[\'Wi1‡Èx¶åﬁ±íÄw\\%‡pù=¯)Ï\0¸úÒÄ_ﬁ[¿øa(Y\0Çÿ@»4ÑïãÄ;Øü\0wtÄ¬8“\nDV16@LªpÔ};|à]è‚‚qüÛÅ¯xO ~QHåí.ƒIÀ ô~Hfı\0…√H‡·ûk¿√\nE‡·\"Hπ§r◊Ä‘z7 Mﬂ\0Hˇ\0»ò\r\0û\"ÜÅßˇˆYùT‡Ÿ£\r‡˘çÁ¿Ûß3¿ÛC [F\Z»Ω\"rﬂzo%ÅÇè◊Å¬ÖR†®Æ(∂ﬂwt/u∂Ø£Å◊W[Ä◊Ûq@•ØP˘ö\nTæ•o&TÄ*ïN†Í¢<PuÖT’[’˚îÄÍ∏£@\r\n‘ 	Ä⁄”C@›j)–∞öÙÅfÕT†9‚7–úõ¥Em©GÄè⁄ÅˆÒX†”h–˘\'¯¥`t)9\0]kö@wÔ–#„ÙÏ4z>\0Ω¡H‡sà\'–_a|Õ8|ïj˛É¡¿ œåKõ>CÅŸõ¿à=¯Vµò†πÃ5`*Ú005”€∏¿¥í)0}˙;0˝˙\00=m	Ãı.?7∑?5ã˙#¿¢Ìc`±H\r¯ïÌ¸j˘¸<,¡fÄÂÅÂﬂt`eâ¨Í˘k“∑Ä5ù`˝Ö!∞^√\06HP`ÉÂ\0¸%›˛4ÑƒãÉâπÑ§ÓBÚ≈\'Ñ¥aB∫\nBvﬂÑúNBŒÁbõ∆4b[s(BQ_°x#±Ω¯4B…$±Sr/BÂÄPù»C®ÒÚÍÀ“à]“”\rìƒn√à›cΩà=√⁄¶;:/:5|Ñn¶B/2°˛bØ±7Ó6boN:bø£‚Ä⁄_ƒÅáäÉ\r£™ãÍ<¬‰ÚQÑIÙIÑ…£ ÑÈQYÑô.\ra6pq_ç0O©@ò∑úGû—@X‹(GX<∏é8j¶Ö8JéBù<Å∞<÷ã∞<+FX9Œ!¨<U«=.!é«ˆ\" û!†AwÔÀ‡∞Ä˙ Ä»7$ûÜ@=›Ñ@\rµ#–¡˜Ë„-ç¿*ƒ#∞ÇpÓ‘[1 A˙∏Aﬁ›à _-EPÙ≤î=µd/Ç∂Ô(Ç÷ÏÜ†¥ Å7,}\'Ç`OU!8≤	Nü	BÓB0∫!< D]c‚¥\rÑ5˘2‚‰M;ƒ)B‚TD‚T_‚¥Ë\'¬÷ aÁã∞ÕîGÿ©3vuÑ]£\"¬ﬁ¢aü:äpP	G8§Gú—?Ç8C≤FúèµA8È<@\\ú#\\»?.ù≥àÀ˝	à+Ô:nè‹Ó‰Qƒ’¶Hƒµí/àkkàÎS/◊\"ÆØ÷\"n®”7ñ!nﬁ—@‹,˙Ç∏˘˝.‚÷\Z·eQÜ∫õå :ÑÜf º^#ºøó\"|ıæS˛Ê†\Z·µ·ﬂÚÑÄ#Ç•5¡}Cà‡’5DòÒ_DƒVé∏∂\rqgp>ºåàxˆ\0y$9gâàúøÜà¡\'#Ó]¨EƒJC‹œ=ÜàﬂQÉàmB$»\"NæG$∫F$ÊÊ#´ÜIø. Rº_!R Úè<√©?iøØ#“Õœ\"“c≤Úàåfƒì`_ƒSΩ€à¨–4ƒ≥E&\"˚H\"{*ëC¯Ç»…E‰4/!rãv!ÚÃØ!ÚÌ—à\n\';o\"ä8{%òãàóáé#J\r#Ø&e‹Dπ÷^DÖÙoD%œÒF \0Qª2â®`à˙àà˙16¢AdÄhqD4<.C4µ ö$kM∏pD”\'KD≥›Œ; ö_ÔC¥XÔØ\\F¥æâ@¥Œ!⁄Fùmﬂ$ˇ≥äh7B¥ß∂—àN<¢ÛA¢s!—\r÷#∫o¨\"∫__l˚_AD±ÒU5	ÒU BπÜøàˆ…Cå¶÷ F€âàÒàÒü.à…∆Ìà©]ÕàÈ>YƒÙö\01≥y1hèò˚!ÊÆß!~¬Ûraà≈Åà≈òƒØ¸<ƒRé>bŸæ\0±\\ÄXç∂A¨éÂ\"˛∏=@¨/ 6,àøáÂm!˛æ)A¸ªÑ¯WnÇ¯7v)qm)53á‹‹@G \ZHY§6rKBrk)\'äB π÷!∂ .·ë€8ìH≈rª≤©¥/©‰âBÓ≠\"w^xÇ‹YÍâTñçD*_É\"’ªFêªˇAjlnBj8!5F\"5/H#5_!˜õ!µ˛ uMjëz˜kë{£†»˝G¶ê˚K€êH“`^iGi®\0i¶å4\"\r M’¢ëf_7êGR.!-™uëGª|êñfHÀgGê«·1»„7\"êêH»Õ9$43:v	ﬂ”çÑsºê\0Î#®¯âDæC¢_w!qR&Hú„i$.+	∆ûAííêd÷m$y&Iy;É§Í}B“Vˆ\"Èzp$C©…ú1D≤%#Ÿ≈d$ªÅÇ‰ v#9—ÎHNÛ7$3…ÕëÇÇq§†Æ)<Û)⁄;ÜK6 ≈î§µ€y‰iÈT‰it$“v€“ŒÊ0“ﬁSyÊv	ÚÃc‰ôÁ6»35ëg•aH«´L‰9Ø\Z‰E∞y1zÈRıÈÚaÈ˙Fy©ΩyY¡y˘—g‰ïØœênkë»´9‰µÓK»õ;ë7∂Í\"oﬂAﬁå1CﬁJ∆#oMÌEzòŒ =≠óêû\0“3áÖÙÒ˚ÜÙYë˛ﬂü ÷Ø\"wBÜ∏u\"Cj^ Cc √æ!#∂›@F8bë>üêë*LdT¡dTk2\ZˇMüCﬁ™Aﬁõ|áåe%!c/\"„döëÒ˚6!hÓG&Xö!‚∫ë	ˇ}ü®⁄èLíiD¶ÿœ\"SÆÖ#S*/ 5^E¶I-#”êBdZ¢12√bôÁÉ|Í∆CfÓﬁÑÃ,ºÅÃzêáÃ™f#ü€ú@æ~ã|qÅ|QÙ\ZYê≥Ñ,<öÄ,Ñ˛FñîmCæ<ä,ıiCñ˛YEæR¿ À–»2¿YÜ≠Bñ=ÿå¨ÎAVÑÿ#+R*ëïáêïOêoˆ5 ´Lê’ÓC»jü1dÕÅ˝»˙S”»•_»w≤!TÄl‹7ÄlÙ2Fæãﬁåly˘ŸzW˘A˚4Ú\"˙øïÙ5ÚCÌ(Ú√L=≤Ì¯≤Ì™+Ú£¡e‰«†´»è_ßëÌw\\ê·»éd:≤ÛŸYüÜÏyÉ¸§ç@vyU!ª“◊ê›w∂#{‰”ëΩõü {—j»œ#ˆ»œˇÂ|r¿ 9p59Sâ¯[ç*2@éÏCé˛ÿÉ”¯Ä¸VŒA~7G~∑lCŒ‹Ö#g∫7!ÁE\"Á’’ëÛèI»‚s‰ÇC:r—2πò#á¸}uÚ˜É‰üÁ˜ˇSè\\cBêç+êˇ¶{Q%wPõv<Em2≥CI:*°$üK¢§~FméYGm˝ÄíN\"£dºCP≤R(Ÿ”⁄(Ÿ$jÀÌ®≠«†∂˛Ü⁄Ê¯µm=•xâÅRíHG)µY£v∏5†vr`(Â@1JyéR!!P*‘œ(ï≥˚P™Ue(µÕèQ\Z.u(M˘hî¶À~îV◊<Jke•s÷•[€é“S5FÈ≈¢ÙcPzQ˙F«P˙6I(˝⁄+(˝E‘>…\\‘Å\rîÅT ¿\'\nehá2⁄kç2ŸÌã2=è2€gÑ2£F°>ú@ô_∞GRSFjñD˙°á:º˘ÍpR/ÍàC1 ¬/eÈ±à≤ºìá≤Ã.EY¡†¨¸◊Q«¯[P«D¶®„àQL#ﬂ5ÜJ£Ä⁄$\"‹Ö‡†P>”(Tm7\n5∑ÜB/H£0˘P∏˚—(\\±\nøπÖœ D]Œ£àqœP§ßR(Raä\"2C—RTPÙR#t≈2Ã@q2tP‹õ(¡œhîpT%ä9àøuCùê*EYÔ…@ŸÏ8É≤¡ƒ°lhn(õÓ\ZîÌ…-(;´Yî=¸ °ä:3nÑ:+ìè:{érîŸä∫ê–ärZëD9ó†.∫\r†\\¨\"Q.¥}(° %óâr…Aπ∆ÏF]∫`Ö∫Ã{é∫bÒ	uu3Ä∫˛,uss\"Í¶G(ÍfL*Í3uÎ}Í÷¯[îá˚yî◊¶î◊-UîWz k∆Â”ÔàÚ’ŸÉÚ5^G˘>C˘ÔtG˘?,Dƒ;¢ãQ¡ÆZ®‡FT∏√*ºuëûÜä&C≈¸hE›S≈¢ÓeG£ÓNA›_wF≈:Çä4D%HY¢\Zˆ£í∂†íuçP…wø¢R∂÷£RPS®îv(ÍQ \'‘£˜TÍ)T˚ÍÈûø®ÃÈÕ®Ã? *KÉâzfïéz6∞ı<SıºNı¸}:*[ˆ&*;∏\0ï#˙Ñ ç’DÂñ˜†ÚË%®<ó´®ºœ *øZı\";U3U‹]ç*Q+GΩt’AïjY¢Jõ2QØ6¢Pe∫_QÂò\\T˘¿ ™|â™8Å™úÕCUõZ£™Câ®öè&®öŸÀ®⁄ëÌ®:W!™Ó^™ÆË™Óg™ag™Åu’4ÌÖz«∏áj±Bµp˝P≠Úí®ª⁄Qù˜π®OjE®.ì\\TwQ,™˚›STÔfoTﬂë€®>óc®˛	Tˇ¢j@4è\Z∏¢£gQ√\ZŒ®aÌÌ®·¶ß®ë√≠®ëcèQ#£F)gP£ßTPcSq®Ò∏‘∑j\nÍ˚_‘√	5uéöeúB˝‹>âö∑WD-∏M†ï∏®ﬂ›QÀ{Ò®ÂË‘ä!µ¬˚âZcP+)K®ıâ ‘∆y;‘?ãKhâ™>Ù¶∞∑ËM±eh…ú|¥‘¡]h)Œ¥Th(ZÍczÛj4Z÷∫ΩÂF8z+„,zÎ„hπ‰¥ºuZñÇV¯–âVX@o[>ãVÃJB+∂©£◊]—€ã\0ÙŒo¥ÚıN¥rt;Z˘#\Z≠RüáVÈæÖV=~≠ö˘≠&w≠¶~Ωã5âﬁuS≠qŒ≠1=ã÷¥%°5Ôò°µ∂Â†˜üFÎÈ°uèÑ°uäh=ΩE¥˛øË˝˚—Oı–¶\rh≥îÛËCWâËCÀÙaq⁄ígÇ>ﬁ&âÜ<”FC^=CCıÔ¢a\Z˚—0ñ\Z~¬\rƒùC)–àÇP42Ÿç∫2ÜFÕ™¢1ß˙–òòèhlõ#\ZØºé&JÕ£â\'˙—‡—4I5M*àBì™µ—TÓöÍKE”j.°ÈnÀhz˝4õàDsøÓ@ÛÌu–Úi¥‡{%Zîı-˙˙-Œøå>1GA[k@[œj£O÷Z¢m6hõÎË”‡ ⁄ˆ˛]¥Ì≥oh;Z⁄NÑ∂˚aÄvhyè>”dÉv,uCü\'E_\Z°/›B_»=Äv“¯Üv⁄?ÜvùB;ö£/ﬁDª¨Ö£]¸F_æÛÌv~\nÌÆÚ\rÌnËÑv_;áæ⁄ÂÄæa7äæıŒÌ&†=¸≥—^Z–^ˆè—ﬁ;\'—ﬁw£o[#—æ¶L¥oV-⁄ﬂˆ2: ÉHÓG<Ÿé|UÜ¸`ÉôDS®ËPπ4tXï}«‡˙N^	Aáw=FGy”–—Ì’Ë«ÕËò0t¨a:÷¯*:.íÜéﬂÑéÖ~–ù¿âB\'‹9ÇNòˆG\'->D?YC?¸Ä~ºB@ßπ¸@ßÖ†”=—+{–O>)¢üz†3◊*–œ‡„Ëg)ÈËg/9ËÁá/°üìﬂ£üg—ŸÌá—9*—π>t^´˙Eì˙≈üìËÇÈt!’]háAó¥ÔDóBÉ—•¡ÈË24]∆–Fóo∞–˜f–Ø◊—ïÜkËJÓqte€iÙõ©rÙõÖTtï•1∫*–\n]UãEWΩ°´{HË\ZQ8∫ˆV;∫v*˝∂BÄn∑F7?F7ﬂE7Y›D7∑z£ﬂ!\\ˇ≥Å~?Än›}›\Z%F∑>zÑ˛∞ˆ›¶∂›VdÜno2Bw\ZDw¶˘£?	Â–ü˛^AwÉvËÓ\0∫GºÄÓkìE©¶†ø,<F¥ê–”KË¡ñËa+>zxh=≤==™UÅ˜ŒAè«]F€˚˝≠[\Z˝ΩÆ=a\Zèû∞∏åûÑ≠†\'Ã—Sª˝—≥*∆Ëπ™NÙœ†IÙœª∂Ë?zë0è^Ã?Ü^>ñà^æC/{ﬂ@Øº´FØ≤”–AËç{ÚËøà´Ëø(_åÑi1fìLfSÛwåÙ…iøTåÃÜ\0≥ÂÄfÎCåú>#W¯#C£·f[≥f˚Aå“L;Fi·fgà<FŸvF•Î+F˚£Z›éQW≈Ïﬁº≥˚b\ZFS´\0£6é—ÇÜ`ˆ∏˙`t:Á1˙WÃﬁ¿Ãﬁûò}G⁄0˚\'1˚¢1®ÃÅ,KÃÅzUåvc∏5cxÖÜ1¸[Å1©r∆òöbL19√Ûﬂ€0áNπ`›á9‘›É±0ga,\Zl0GyÓò£n0ñﬂŒ`éUñbéóÏ¿@$˙0êùU(nóO∆ ùÛ0»J÷É⁄≈¬†ƒ2T∞\"ï∞	É3ç√‡\"ˇapcV‹‹\ZÅ¡7Lb6G1`\'CZŒ≈Pí\Z)CG`òfÅÊÈó˘2Ü˝E√Y4ƒéeb¯ó∆1“-å J#<2è}ı¿Xáú√úTm√ÿÙ?¬úrÂ`lÂa;É.åCÃÃôµAÃôçÃ9Ö>åì‘Yåì•∆Èf.Ê‚óWWUkåõ™2∆-n∆ÌÕ(∆˝X=Ê\ZIsÌø∫^“«‹¯lãπŸòåππ âπïYãÒ0yâÒp\\¿x¯çb|<„1∑µº0æú„_ˇ@åo∑∆wL„ès≈¯óyc\"O`>dc•œaÂ√1AæZò‡°2L(ÆJ∫äπ;èâpP√DNc¢\rÂ0˜TL‹ø	L|Z>&¡*ìrìhxìx6\0ì8?èIs√<‹yìRôÉIy\'âI}iàI◊‡a24IòåW˝òåIOL∆ÚaÃS5ÊÈ°Lñ¶/&À!ìÛÒ&gq\rì≥∆‰¬W0yôﬂ1yBL˛nOÃãÙÃãø0ÖbuL·›`LQÓOL±ô)¶ÑÒSrãyπqÛ \'S÷’ä)Á˛¡î{yc^wGcﬁ|l∆ºã≈ºôJ√‘äûcﬁ:%c\Z¸—òÜ®lL√R2¶I˜¶•˜)ÊΩ«Ê}Ä/¶ïRäi˝äi]ÂbZˇa>¶6a⁄√Õ1=%õ1}7\'1}Òg0_Ü*0˝á≤0˝˜À1˝%o0_›õ1£òÅ’%Ã‡ƒ-Ãê	3¸“\r3¸˜\'f‰ÃÃ(ÉâÛ0≈åw`æŸb&Ùéa&fr1S\\f âèôÿÜôï¸ÇôMl¡¸îÛ«,∫çc~±û`~eÍañJ7cñÜ√0ÀÁ¬1ÀòÂ÷òKWÃöıKÃ˙if=\r≥^◊èŸ‡]≈lº˚à˘´tÛs+©y\0+≈ò¡J9≈J];àï„ôbÂT±ÚK˝ÿmπø±€*z∞€æ˝√* ù∆*û<ç›ﬁÚªΩΩ\nª”‚&vß+àU	Òƒ™¸ö√™	ËXµË¨:Ÿ´≤ªÎUv˜Z4VÎ‡?¨ñïVÀÛvœ˛!¨˛L>vÔˇ≠ƒÓ;÷è›Ö›Wwª_bªZä5¨ã¬\ZïA∞∆jVXµkXìΩŒX”√Á±¶U∞f	X≥%-¨Ÿ∆]Ï¡¥?XÛWuÿC∂6ÿCg§±á5∞á›‹∞Gìnaa+µXx`^˜,fafÛXƒ9,‚ë2—ÔåEmv≈b.\Zb±àáXlã	ñpyK¯pK\Z¿~Ò∞‰≤~,ıfñ&3é•ôWci™Xˆ6/,€JÀ1Œ√ré¬rM¨∞‹S=X0çÂE`˘Õ|¨P∫+|cçEaEe±\'˙ÑXk›¨ı“ ˆdd÷¶¸:ˆî‚3Ï)„FÏÈçP¨Ìˇ¥<Öµü\rƒûŸSÖ={yÎËúçut©¿û◊abù…O±ŒÇ`Ï≈åÏ≈—X¨´%ˆ™cˆÍ◊)Ïuœ0Ïç\nÏç9\"ˆÊóq¨ºÎˆ`Ω&r±^k>XÔéL¨œ÷Z¨œ]>÷g÷{;≤Îª;Î{B\ZÎüå\rt„`Éè‰`É˝`Éß\\±!2∞!¨ìÿêµIlƒ∂ÿHM,6J|\Z˝£	≥(èΩˇ¸6~◊Gl¸KÏÉ¸+ÿÑ\'°ÿƒ\n6È›;l“è}ÿd	l≤Ö6˘ô56y<˚0ÿõÚéà}tSõzƒ¶∑}≈>ı◊¿f≤[±ôoæ`3We∞906\'L	õrõ?Ò˚bk0ˆ≈˛;ÿ—dlÅB\n∂¿Í>∂Ä|[¯>[Ñÿä-Ó0ƒñÓk√æ¬’a_eIbÀXÿ\n≈Îÿä∂¢’\n[1\\Ö≠îÜ≠ºç≈V6ÓƒVÆ∑`´{7ck§-±5–]ÿ⁄ÁΩÿ˙ìl}m+∂~\n¿÷ˇ”¬æ\rú√6\\˝émhü«6‚˝∞MUVÿÊÊÿwƒüÿwˇ∞-R*ÿôùÿñ%ÿ^∂Â /lKÖ:ˆ˝g#lÎlk Klkó3∂MämgVc;äß∞›WâÿlO@∂Ô∑∂ﬂ‘˚µ⁄;®˜;x1\r;XeÅ¢<¬=ãƒ∂aáØ{bá7R∞£/%∞cÕØ∞Sü€±Søwag6!∞?bagµœaÁºæb>Ú¿.º¡bS≥∞øÊá∞KÒ∫ÿïÍaÏÍ˚Áá\0ªˆ‚*nK\Z∑©œ\'˘¨\0\'µ/\'µˆ∑y`\'Ω≤åìq5¬…F¿…˛2«m¡©„‰n;„∂m^«ms¿mÏƒ)äåq€ßp;ëq;ÒGq áæ‚T‹ﬂ„T{`8µ◊pjüqj?ƒ8µ≈s8ı=18ıÇ›∏]“qªé‡¥Ïup{Ù>‚t0n8ùó;pzS”8}ï<ú˛>Nøˇ$no∑∑˘(nÔ(g≤”\ngb~gÇé¡ôxƒôÙ1p¶aXúu;Ó‡Ewúπ4wË+wòﬁÜ;πw‘¿Îà«A\Z/„`5·8ÿ‘=¸õ>ôçLlq®÷ZÜQä√rq∏∏G8º¨é`A∆ùãpƒò”ä#Ÿå‡»ŸÉ8äïéRÍÖ£öÃ·hkn8˙},é±…«2◊ƒ±Ç˛”~«Æp∆±ªﬂ„∏ıpºèA8¡À˚8!Û4N8“àç)·ƒØcq÷”L‹…¡\"ú\ri\Zg±Ç;Â∏wÍÖ&Ó¥˘y‹È∏$‹ÈÒFúm“Vú›!mú}◊cú})Óå˝\"ŒQ~?ŒëÁËßä;óG¿9Æ∆9«qNo[qŒ∞úÛ€◊8Á—púõ€Wú[Êú€Îú[-Á·âª¶[àªÆíÜªôùÅÛcpuñ8œ=∏€e∑p~£≠8N.@•\Zpb–\"ÅtˇØ$˝a∏†M)∏†£Ì∏`ã\\∞0:8ã/G„\"\nCpës∏»M¶∏»M∏{⁄	∏{,%\\‹ç~\\“Â;∏dz5.Ÿn	ó‹Ÿä{¯çâKπ‘ä{§Õ¿=≤Q≈=Íî¿=v∑√•Aπ∏\'∑íqôÈ∏¨on∏gõqœ˝Ø‚≤§„≤ﬂç‡r«‡r¶,pπßÏqπ°«qyöP\\Ä¿Â9å‚Ú[qZ≥∏ÇÍã∏¢I+‹KÌ/∏ó{]q•j∏W7^‚^%|¬ïÖÔ¡ï+®·*ÙeqïŸ∏ZyÆñ9çk˙Ô]Õﬁ4\\Û∑ì∏X<ÆÕékª{◊ˆ=◊éZ√µO#pb\\˘7Æ„”N\\◊πo∏Æp\r\\◊»=\\/áÎ\r⁄âÎ˝„ÇÎ#9·>á˘‚˙=û„˙[ô∏ñ-nPY7åŸÖ>Sçyiç©Ÿâyw7Ú˚÷´^/n\\+7Ó>Ä1≈}õ©∆}ßàp.2∏âf)‹dÂ‹î¬s‹‘v5‹T17Ca·fæ(‡fÊ!∏≤_p?∂U‚~h¿q≥öF∏Ÿ„q≥≈…∏Ÿe&Óg(Ä[\0ﬂ‚í∏E˛c‹“áV‹≤·0n9\ZÖ[~Û∑Bá‚VA‹Í/‹üg≈∏µ®0‹z8∑ﬁ≈m8∫·6Çæ„6fµqˇõ±—_qˇf«õÆ‹∆ozp/πÎ^“f/Ÿ„èó“¡‚•.PRπÛ¯Õ™zxÈ/[ÅóÈ≈Àj¶·∑Óè√ÀÆ‡Â•r€MÒ€&ƒ¯Ìea¯ù÷3xÂÑoxï˙Aº™0Ø:SäW] ¡´ı	Í^≥¯]($~◊…RºÜÒ]¸n;mº÷”	¸ˆ^¸û*9º∂¥^-ƒÔªïÄﬂÇÑﬂo[âﬂøTç?∞4á7êT∆ô≈‡∆ÒÜqxc(\Zo|Zo|·\Zﬁ8†oÚ˙	ﬁÙà\0o⁄ˆ	o˙ëÑ77ﬁã?TËä?≤Ÿd≠oÅ>Ç?∆§‡èoÉ·èÀ„°ñÒ–¬<¥‹˚aÉá\']¿√_CÒ¿î\Zıx\Zè~°ä\'Ì∆‚IE9xRÀ[<˘l+û‚§ãßzè‚i-“x∫{?û6ág’N·Ÿ\'ÚÒ|úûÔPçÓ2¬üÿîâ∑nD·≠7xáÛ¯SAd¸iÒ:ﬁ6h3ﬁ˛{˛Ãx)˛ºR9˛¬Æºì˝kºìÛ6º”¬1º≥9—)Ô¢\"çø‹˘ÔF≈ªy‘‡›ÇYxw˝5º{`9˛™v˛:\'\n=1√‰4˛˜3˛∆¬¸ç5y¸MΩxœP\'ºó9ÔU¯ÔÌ{Ô}_Ô+Ü˜ÛA‡Ç$ãQ¯†∂W¯‡Ñx|pÆ\0ÚYÊs°¢äèh;àè<–ãè5¡G!y¯h√1|Ãè|Ão|\\°>˛˘˛Åé˛¡ëù¯Ã|BK|¬\'¸√ÉèÒ≥ÙÒèFÜ©öA¯‘\0Y¸c®˛â√¸7}¸ìß≈¯g®N¸≥Àa¯Á˛y\"à>kéœ9∏àœ’≤∆Á’ù≈Á≠„˘ª«æ0ëè/:É/∂ÿã/~±Ç/!¥„_Z¸√óë\\Â;˜·ÀÍÂO‚+ÙLÒ\rßØì<Òoﬁ¶‡´|‹UﬂÒ’õs’[\"’ìÆ¯\Zô<|Õˆ9|\rˇ)æfÆˇˆ¡3¸€ƒ`|c˛æy”k¸;RæÂh1˛Ωm˛˝˜≥¯÷b|kì;æu\0Çˇxmæ=ÜÔ¡%„{>Í‚{k¯>W˛≥ç\"˛sa\0˛sÈv¸Áû/¯ØP¸\0‚7~∞(?⁄ëåc‚«*˚c\r¯qΩb¸˜G\n¯Ôu£¯Ômﬂ&·\'UÒìd~“ˆ~*D?Ìx?=•éüŸ‡gXe¯9I&˛ßM\r˛gy\r~AÃ¡ˇ>Äˇ}møDQ≈ØË¯?}\'ÒÜãÒk:˛¯µö2¸⁄g+¸z˚V¸?Îõ¯sëÑMÀ7ín6…Bk¬fs¬Ó^¬÷¡˘çÇ¬W¬6ÂU¬∂iAQPFPlõ (N∑îéCJ∏BÇR @P\nô\"Ïÿ\\CÿŸ}ñ†⁄5@PßÁ4Of4√n¥*ﬁˆp6ˆ‹/ Ï©%hoΩK–\r{A–õú#Ë€ÎÙWZ{/µˆ¶áˆ.…ˆ}À%Ïœ~FÿüÛê∞ˇ˝=ÇA’¡PŒÜ`»Ò&f\\\"µfå~<$ø›E0ôW$T%9F∞®+%»†Á	0Æ\"»ü# ˜vê’·dˇ Ô3cÅ!`¿)ñ¶J¿Êgp Æº‰:o£H¿ª˜+Aq/Å(5L û¯B†‹\"P+üh¥#⁄ΩõV’Å≠ûG‡|´&p~•∏∑ì‹Us? àıwƒ‚$Ç∏Ï·ƒôLÇµJ!¡˙ıQÇı∞+¡F≠öp\nM8U¯Ép:*ú`ªMì`Îzê`˚s¡ˆó‡†eF8õA$8ö.„_˚◊	Á„ﬂ.∞_.ƒû#8E‘úÖJÑãWø\\z ◊>¬ä‡æŸàpuÀ9¬’òb¬uªkÑõÂ\0¡#Í:¡#©ô‡ı´É‡}ÆÖ‡]FÓ‰|.ç|Ó/<ÅõÃ	A∂∆Ñ‡˙MÑ$âRjBÉ¬fR	aÎß	w÷s	·ubB¯Ωâ\\®!Dü&b¥	˜do∂¨”âΩˇÂ™!iw:!âÿ@Hzëê≤cÅê¢OHYŸNx‘≤BHmxDxÃ\Z §IN“_&§ÀJû<*\"d¢Ç	ô?û˘œ\"A¬sΩ=ÑÏ(5BÓ˝tBÓoB^t#!ﬂ‘óêﬂ∏õP∞ÕñPdRG(*í&ˇp&î¯í%æÑí⁄¬+÷vBπ÷O¬kÙ·µm#°RÍ°≤æàÊ¬AB’ò)°ÅÛú–9â–¯ﬁä–∏Exw{à–‚Ox(éæäKhu›Ah˝)\"¥˛µ\'¥‡	mºTB€•;Ñv,°Ûë·Sñ–+•KË√®˙\"÷_¸Ú	_Èè	&’ÑÓa¿ˆ\na¿Ûa ®Å0êjO\Z\n$£L	#≥∆Ñ—|¬ÿMÄ0ÆËJo{D¯ˆLè›\"í0ŸúKò>πL¯1¬%Ãjü%Ãem%¸¸ÍAò±%,(˚<FãuÑ_u¬Ø&·∑‡·˜[Y¬“8a©˛:·œCE¬∫Ê/¬˙áÑ\r9+¬Ü0Ç∞—yúöI¯7\\GîpN%n¬\\#JY#àõ˜ú$JGeÑ.Dô@}¢ll?qÀë-Dπ‘1¢|‰¢¢£/qªcQIzô®Tqô∏√¯qgî<Q˘x!QUú®ÓúO‹ewì®·ZM‘¸9G‹ÛAÅ∏ÁìQ?ÜO‹€ˇúx`ù@4DƒçòØâFâ∆mÎDìM2ƒC±aƒCMX‚·o_âGJ{âGY|‚—oôD´ªÊƒ„`%N:CDÍë/gâ®á}DÙü\"fÇà9?Hƒ∏|\'b\\ﬂ	ÈfDBì6ë(˙@$&⁄âCzDRq\rë\"™\"“∞õà¥¨DÊQw\"ÈLd≠cà√7DŒ¡b\"Áû&ë3K‰nw\"rç\"Ôaë7ñK‰´˘∆CD!¢ûhÌJ<©K#⁄\0KDõ{%Dõﬂ˚âßvƒOU3àß˛ñOã#àß”Hƒ”µ=D€\r5¢ùÈk¢˝—˛æ6—!Eèx¶˛—Ò†Ò√áx˛‡9‚≈2êxqLLtô^&∫∆≤âÆS¡ƒÀ p¢õå9—ùöJtg8›À∫àÓu(‚’ÇWƒÎ‘Ûƒ‚≥ƒµ*DèK\'àYæDœâ/D/	¢ü·+¢ΩûËÁL$˙ü®%˙œäâAS3ƒ‡áãƒP˜0bË£óƒ∞£üàw\0\r‚ùü√ƒàõ˛C%FﬁØ F)3âQè.£\rêƒÂQ‚=øb‹ÈU‚iCb\"CLÇ\\$&pâI_]â)o∆àè\Zà©˚S√^õ*3?”◊àÈ_…ƒ∆m‚ìzƒ\'Ö÷ƒ\'Ôü üWÖ≥w> fØ]#ÊΩ›DÃ◊0$ÊÔﬁGÃ˜zI,(/ }≥&1%ñT~%æƒÔ!æät\"ñÖæ ñØù&æ>-K|ÌvÖ¯∫ é¯&ˆ)±Zf±÷r;±Ó§ÄXÁ@\"÷çÔ%÷øÀ!æΩ‹Nl⁄˝Éÿ¨£HlU˜\'∂˛|I¸pﬂàÿ¶bOl€#Ilõà#~<dOÏÿ,GÏhû$~R{FÏÇ{Tâ=›<b/&Ñ¯≈Œõ¯≈ΩÇÿØ©JÏ/Í\"ús#„[â√ì}ƒQ|6qlóê¯-÷ã¯≠ˇ3Ò;÷í¯˝Òi‚˜’}ƒ	çßƒ	D<q#Eú2˙Jú:[LúäÇßŸaƒﬁ‚è—‚,Tù8˜ë8˚¯qNSHú[–&˛,ªHúø◊L\\æI¸}#ì¯€˚5qŸ˙\0qeÓq≠¬ë∏÷=J\\Ø?F‹–É7¬}àˇd<¿M w¿M7∫¿MŸ†$ä	Jë˛Äõ}“@YØbpKÌ\"(Ø\Z ÎˆÇÚãe†¬7;Pqh\n‹º∑∑ïl@%◊É‡Ω%pß…pÁ_P9LTy’í	†ZŒuPùF’YP#¥‘Xõw_15≈4PõÛ‘∂}Í(Ä∫óûÇ∫±hpÔ=p_â6∏ﬂf‹Ô&˜7ˇ˜ø;Ë*\rÊAC[6h∏æ\n\ZÒdA„D–xc4)‹ö¸w7”√;@≥QU`íhÆü	÷–-HÊ†Â≈*–Í¸XÂ\nI˘B7Å0‘„›a±Â ,o+¯öÄ¿£ B[\"È˝  Ë\nàBø± ˆ\nƒéÜÅ¯µXêÄˇ·øAb™1nö¡¥:êdSÙüIê*+RèLÄTØ\0êvÿ§Õ™ÄÙ≠ ˝(“ÁA¶9d Î¸ »ö≥\09Å$ê+8rW  ﬂÛ%»ü∏\nlº@ÅS5(4v\0Eûr†h^Kæ\0OXS¿SN†Ì~W–63¥3éÌ,CA{√ˇ\\ø⁄ó2@˚v1Ëpˇ?ï‡Y:xñ”û-¯ûÌˆ[¶¡ü¡vÅ†3ˆ!xëŸ∫|7/·˜Äó\rí¿À—˛‡…däl(x≈9ºÍıº˙\"º∫~\0ºÊQ^è¡Ä75Å7Ìc¿õgM¿õèÇ7˚ûÄ*;Aœ<ËŸ\rz£[@o∞\nÙ˛aﬁ÷\0˝ÓkÇ˛zv†ˇä\'™3Üëù¿∞÷k`ÿ˜0ŒÛ*0ºéﬁ-@Éwá7¿»O`‘aY0Zﬁå9.ﬁ[c•ı¿Xãc`‹Í50^πLxÓ\0&ZÓ]j¡$©0)Ì>òº/|∏z|∏°¶H7Å)rÁ¡Ω!0Ö®>r¸O-L›‘\r¶N7Äi/ı¡¥\Z:òˆi7òû“f¥YÅO∂€ÄO°{¿Ãø¿LøH˘&E˘Áp0;ı(òùeÊ$ïÄ9≈Õ`ŒË0◊ Ã#ﬂ\0Ûö¿¸v;ÖÊGÖÈ9≈II∞P‚Xx›\n,gä¡¢tXÙs,YeÇ/ì2¿RU#∞¥Î	¯ÍÁ∞,D|≥VΩukdÉ5A£`m:¨€≥¨Kˇæ=~\0|Îü6»Ä\r±!`√√„`≥\ZlÓáÇÔn?\0[;ŒÉ(›‡áºX∞-?vA¿vÛ\\∞Ω8¸§Ÿ~BiÄüÓºª¶‰¿Ó‰J∞˚’S∞∑£ÏãË˚2ÓÇ_∆“¡˛=Æ‡◊<¯5È¯µx8∆Ú›¿!g88Ù>}∂\rS}é•iÅì}tpä]N≠\0ß˜ÆÅ”Cù‡úÏ¯s~8\rœΩõY‡b«A◊ƒ∏§¯\\⁄Ó.-•Å∫z¡µÕ[¿\r√PíDŸ]“&Ωˇ¯l!…4⁄ëd/˙ì‰§¥IÚ\\\"I~LDR»–$)º…\"),rH€ bI€©X“ˆƒ“éå4“Œ%$ej4Iy±Ü¥{îD“¥Î#i≠ìˆË£I{äH⁄◊%H:»\\í.å§˚Kä§ﬂ1N⁄ßuõ¥/2ÜtÄÆO:PëL:0D2t®&G•íLﬂ#¸òF2?˚àt»’Ét®¡åt®È\"È–dÈà„8…‚\ZôtO:äè#ı#2&YB<Iñ‘	íÂ¥\r…JNãd5J:~nâtº˛\r	j≤çœ≠$¡_°H¿N\"»âÑ‘ÅìêÜí$§	˘VäÑ¬/êPì{Iò©≥$\\R	7√\"\\ÓìàΩ$“±S$Ú÷8uœ~4$—Lí™$∂¸{€ÿïƒÆË#q¥IúK;H<Á)Ø0õ$êÑﬂ’I\"~#It¢ètB^ôt\"cêt‚Ô0Èd«“…!êtÚád≥ïG≤È–%ùV(\"ùæSI≤µcëloì_ì.XÈì.dMí.õíú’çHŒ¡oIÆ©ˇHóÚRIóCênJ\'ínÌÆ#y4Zìº:X§€∑±$ˇ	RÄÃ$)‡Ö4è2ØF\nÌµ#Öhë¢4æí¢ÃHQãÍ§Ë;H“Ω‚vR¨±)vnÈ˛]R‹ãbR‹ÃR|¿%“Éƒõ§D˚dRí<Üî§—OzH˛œDÈ·O)ÂJ)gHJµ·íGìí“€RIy§ßı6§ßr§Ã∆_§¨âE“3©ø§Áí\"Rˆ11)€ï@ ˆ}M ı{Lzﬂ Ëöê\n‚ˆì\nÎjIE;ﬂêä¸\nH≈À§B(©tYçTÊ“G*ﬂ+Az}Ù5Èu2ÖTÈ>A™\\+$Ω1ú$ΩÈÜë™,FH’èﬂíj∏…§ökØIuk§∑”ì§Üt	Ro©Yj©˘t#©˘™!©˚Ç‘r™Å‘“ùJjY’#Ω?Â@jÂ©ìZøõë>lﬂCjÀÑí⁄≤ãHÌ/≤HùfÚ§Oßüë>æ u=Ì&uCÁIüqOI_Ü6ëæÃÆê˙˝dI˝˜•IÁUHaÈ§¡Œo§!—&“∞Ui8“á41;Oö‹Òú4ôwâ49¿$MŒ=\"M~LöÆ&Õúí\'ÕÍÔ&Õ˘ø%˝<cE˙ıáÙÛ°i^Ì	i>ªÅ¥êtí¥hï˙üÁ§E<ôÙ€Hô¥“AZ¡±I´R*§’†R“jz3iÌ…_“˙÷“˙Â!“˙£§øöWI›∑ê˛›∑$KÜë%ª\0≤îã6yÛÖdÈöd≤L?Ö,;íBﬁíPGﬁí¡!ÀÅÅd9j;Y^2à,ø÷JVÓ +ö\\$+>o\'+ˆŸí∑+¥ë∑ªKﬁûΩBV∫õKﬁI#+W4ìï˚OëUÏìUŒëUÔñëU{ƒd5áRÚnC&Y2L÷åeíµ¥ß…Z0GÚ§Y˛ù¨Û∏ë¨;F÷1\'Ô5ŸIﬁ˚∑ól\0K\"\\Y%	[»∆Yá…&wk…&Ø»&„»fg»fÉd≤πm>˘˘H∫\'Ÿ¢<ù|‘wÉ|¥„3˘ËØJÚÒ-™‰„ﬂèê! ûdàım2d!âãü#√⁄Á»˚áddHFÆ¥ëQrw»hœ\Z2∫´ÇåQœ$„ˆÁëÒîKdróLû S6¡»î¢x2ùîNf§˙ë9£2g\\ÜÃu.\'Ûuc…¸ª2d˛˝\r≤ ﬁÉ,Ã∏EN›\"ãﬁkì≈ˇ>ëO:˜üg‰uÈdk„G‰ì+Ú)g4Ÿ6îO∂M‹F∂-ñ €ÈëÌY)‰≥Æ4ÚŸ\"˘<æà|!}ÖÏ‰{íÏ¨„Gvﬁ;IæËìOæ8‘Cv±ˆ\"ª4Ï\"ª\n!ªrã»Æµt≤Î™\Z˘“#Ä|©∞à|Yvé|π~ä|≠®ç|≠—ï|}ÛÚ\rî˘¶<å|ÀCˆ”&{Ê∫ëΩ5\"»>`\'ŸßBæ≠â\'˚˙\"∏ú&\\^!∫¶ëÉfêÉçwìÉø$ìÉOìC†Á…°‘prXl=˘ŒéErÃµo‰òõS‰{’ì‰˚—ª»qug»Æ∆í¯fì¿≥‰ƒ+ﬁ‰ƒÙ£‰§-á…I⁄,r“cgrr˛UÚ√-&‰á∆f‰á·8räT˘1Tñú∂ˇ*9˝Ä9√™è¸dß/˘Ih˘©ÏKÚ”Èdr&y?9sŒû¸ÏV(9õ_CŒÆ Áp√»9≈›‰»ÖúBr—ñnrë!ó\\¥qÄ\\|ûN~˘“ô¸Ú„}Ú+‘CÚ´Á…eÌ7»ÂÜ!‰Ú≥z‰ä`CÚ∑ rUf2πZ‚πZ“á\\ΩWû\\õHÆŒ«êkTØíÎº§»o1o…ç⁄‰∆Ø…M./…Mo…M≥≥‰Ê∏yÚªùZ‰ñÏ˚‰ñıÚ{£‰˜√rkÿ˘√O)r[¿#rG/É‹π/î‹ı_∫˝Ç…ΩGB»}}„‰ØÊ‰ØºÚ◊”&‰°ö›‰·3ø»√ç[»#ˇıxÙ‰	Ú®˝ÚË\0ñ<:\r\'èu¬…„~{»ﬂ∂æ$Oîë\'\ZÉ»ìÒ‰È˝e‰i+yF‘N˛9M˛ëMû={ä<˚5è<\'xDûﬂZIûW˝EûoU#œzM˛enA˛¡ëüíó≥íˇ‹Í$Øëì…kuˆ‰ø+n‰;¨)Áÿ©/ä4Jëπ˛ò≤≈∫õ≤≈Yô≤≈≠â≤%4ü¢p„E°Ê1E—˚\"e˚÷& ˆsK%ä7EUˆEùZLQ_ë°Ïí £Ï∫”G—H{JŸM,£Ï.v•hÆ8R¥˚(:uÎîΩæ\Zî‹& ˛6 ÅJ8≈pó%≈0∂öbÑ Såí¨)FÛä…1≈4=éb˙NöbFRÃÉb)Êe\\ °Wî#∆KØäÂä}?≈Í≠)Â¯Œz ÒÃó»•\nPß\0#|\n\"PõÇà≠£†˙(ò#õ(¯i\'\n·‰	\n˘l>Ö˙_æ¨§êg/Qh‰W˙Gi\ncÎ/\nsÅHa—p„ÖÂLa\'†pUÆÅÖ˚ı	E’Ç\"‹TDπ«PNÎ¥QN◊ıPl∑¸¶8\\ﬁM9„¸ÇrÊ%úrV—çrñ|är÷ZÇr66ârN≥õrŒ›ìr>Vûr·§ÂÇC≈…‘Ü‚t‘ë‚ltê‚‚∫ì‚pé‚∫cÉ‚Ípî‚\ZﬁOπL∏EπR˘örUzërUmÑr5üOπvHÉrÌ|&ÂZÏ ııy \r”` Õ∫´èmg(ûrŒOì‚)p•xzÚ)^Ωî€E°ﬂ;ïø/NîÄKJ–UJPçò4¯_ÈRBj(!#—î∞ø)wîœQ¬π˚(wç6(ë∫$J‘ÈtJÙïjJWáõÚí˚)%æ€ÑÚ\0YMy‡ÏMy–K¢$JRÔ±(â©á(Iy£î\r<%E∑åí?Byó@yºÎÂ±…0%≠Ωíí÷À§§_\"P“Kz)È’w)Rìî∞áÚ$WèÚî´N…º∆£dÌ<HyˆWÉÚúœ†<ˇ(A……∆Rr:ﬂSr9aî|˘PJ~‹ ãÌ.îÇ+îBD-•›-JëéÂ%!èÚí∫áR⁄öIyuØöRv•ú¥N©x{ïÚ⁄DìR©€Gy≥˚Â\r-áÚ∆µéRï\"O©ÈyJ©˘ÆO©e¨Sj€∫)ußr)ıjî∑á¨(o˚ )\r=2îfìøîf« ª‹áîñ€„î˜Úî˜ä( ï~ ááZî›á(mÛ˚(gï(m?)ùN≥îŒô6 \' JóÇà“#¶Ù\\¢ÙÜ)}§PJπÂ´æe‡&ä2É¢ŒZRÜmî!N)eHºü2t≤ã2Ù©Ä2¨*§sßå*Q∆∂ÖQ∆|.R∆ØHQ∆=Âˇì@Øß|«∫Q¶˛î©38 T[e∫ õ2#sä2Û7åÚ√¢äÚ„j Â«ÕîŸ™\0 hJ˘µgâ≤Ï|Ñ≤|Ìeπ9áÚg€Âœô˚îµ¨gîıMÌî\ru ßÅÚ∑ƒïÚè~ôÚÔë*!´@ïπL›îÏ@›Ù˛.UÚæusÍZµ©[d©Ú˝	‘m]-T≈N&u«◊Tï∏ΩTïóZTUıwTU∑(™ÍıWT’ågTµMX™⁄Œ:™Z∏!U-˘=u◊V™∆Ë)ÍÓÏ™&Ÿâ™Ö\n°jüï§ÍƒŒPu>£ÍQ∫©zó!T˝˚KT˝QuÕ2uˇ∑ã‘MTÉ≠ÀTH5˘{ûj∫Õìj∫=ójvLöjˆ¸=ı‡≠øTÛ<8ı–ûÍa]%Ía&ıU7Í£\r™≈i-™≈˜kTãﬂpÍ—∏*™ı#’Í‘“˛õ\nM%Sa´õ®ÄWM\0©hœ≥T‹ñ.*Æ‰ ï0úH°4*ÈÈïºf@•HÌ¶RäéR©˚\n©4Óg*}Å $˝§2õPY=™TŒA*ï˛†ÚR˘-®•v™ ‚\rUê;O})•ä∑®Q≠å®÷œÃ©∂S©∂9b™ùU\Z’°XûzÊƒ\'Íô(WÍô’`ÍŸ‰WTGX/ı‹ó!Íy£‘\Z…‘⁄®ñˇRùÍ;®N_ﬂSù}Õ©Œ5ÍeÚA™õ≈™€Â≠T∑∂\'T˜¨}‘´{c®Wçº©WÉÀ®◊ıÓSØˇŸEΩd@ΩëTOΩy%çz´∞îÍpãÍÛ«äÍª#ÅÍ€‡K\rò‘£*yP≈‘¿∞€‘¿¢%jpé\Z\ZTA\rÕv§Ü˛ Q√^ø°ÜÕ&RÔ¥º†Üã≠©w˚Ç®◊ô‘àªÛ‘ò-Z‘{¢hÍΩÃXÍΩOè®±´‘∏„[®ÒÎz‘$mÍ£∑˚®è/vR”ÜØS”Âç©È‚˜‘LÖöôRAÕlò•fŸ:QüÌW§>?¸ãöΩ˝5€+õöΩzùöÎ«¢ÊÌíßÊ7GPÇ¶©„≈‘¬ì2‘¬ıœ‘¢W˙‘¢u9j±Zµ¯/ùZ≤{/µ¥≥áZ&SÀÈ‘\n´(j•n>ı\rzµJ∑òZıTÅZRk˘,j=}É˙V§O}rñ˙ˆç1µ±{Ü⁄tÅ@mÚπI}óB}77B}£J}ˇ{µıˆ_Í§ıcÌvj˚…jŸÄ⁄…ÂR;cj©ùI	‘Œô˝‘OóJ®üÚ—‘.ô\"jWZ\"µªUá⁄khKÌ˚o˙s®˝mÍ†ƒ)Í`â-uXÚuƒtñ:∫≠å:^˘ç˙- Ü˙›EHù≤ŸDùææó:˝!Ö˙cÆí:{iu∂∫ï:ª‚Gùo|H]ËºB˝Ö¶˛äw¶˛66°.—ÿ‘•≥{©À˜¸®+ÉQ‘Uu5ÚıèR=ıœ}uÕ˜u}À#Í∫Œu˝fu{à˙◊∑Ö˙∑=à˙OÁ#ı_Ö-ıﬂHMsö∂…›ã&Ö;L€,1M€Ïø@€¸≠à&#è°…XÎ“∂ÏA—∂Ü⁄–∂¶Ü—‰>˚“‰5∑“‰˚ãh€\\WhäØÎiJ	4•§K4•Fm\'3ï∂≥‰MEcû¶“Öß©◊—‘Iv¥]2t⁄.ÕRöÜ¬*MS·M≥qå¶`h{în–ˆPi{“ ¥=œÉh{zÁh⁄®Vö∂W	MÁ∆[öÆa,M_!â∂Wî∂◊ˆ$mø \"mˇ£%⁄Å4eöAÀOöa§4Õ(Ò\rÕx‰\ZÕd;âfÊG3ïßô•«–Ãz¥ÉòÔ4sœ@⁄aø\n⁄ëy4ãö•ùfπD†Yç—éôé“ IT\ZHß[é”ê÷4‰˜4Ç÷\Zq˚\Z>¶ëM:id\Z9nôFQ∑£Qﬁ`h4Âª4∫ﬂ<çxò∆‡—òÏ&\Z[Øà∆Œß±Wo—8tê∆£n¢Òœ£ÒØñ–œ∆i¬Æ˚4:ù&\ne”NË<¢ù¯>H;y∂áfs=èv˙YÕ.…çÊ–räÊ–ıëv&˛ÌÏıFö#‹ÄvnÌ)Ì∫õv·.öv·Ÿ]⁄Öw˛4\'ã_4g¸Iösw\"ÌbÕ(Ìr¬ö˚n+⁄µª6¥ÎËã¥ÎqÉ¥Ú¥õ˚Ri∑éß–n-n•ydè“<Qœhﬁô◊i>ﬂﬁ—¸Œ|†˘[Ÿ—¨#iÅ[¸i°≥¶¥®W¡¥Ëe:-f‰Ìﬁá5ZÏZlC-ˆg-û\"Kãœ◊§=Ä>§%‹/°%¢iâÁø”Ø˜“}ÿ¥ƒ-È®-•ÒÌ±πêñôAK+º@ÀÄg—ûËﬂ£eIähœ•hœï%i9¿KZÓr\'-œ®ïñwNÀ{™FÀè∑ßΩ0„“^ò+—\n|Uh˛áiÖ⁄Y¥BÍ\Z≠∞˚=≠Ù‡>Z©Á3ZeR>≠Í·+Z’\')ZÕÉ&ZÕÚwZ≠÷YZÌÎ\\Zù,áVó~ÜV7˘ÜVˇ%Ü÷@h\rBiZ√)ZSÇ÷ÙGçˆÆÜF˚†,OkÉƒ–⁄Æ-—⁄Ó–⁄Ì@Z{@≠}πù÷±e/≠#1ì÷˘∞ò÷Y®@˚ÌNÎÜÕ”∫üÖ”zŒG–z.û£ıe+”>J”æÏ÷°ıø|HÎÔ8I˚™wù6pqé6å‘°çD^§çÕ¥±ö⁄¯e⁄wÊ⁄˜ã¥â\Zmÿ†M>q•M\r7”f\rgh≥6C¥Ÿ˜hsßhd)⁄‚•e⁄í√5⁄í3ù∂T…§-T¢≠)“V’∑”Vw≈”V{n–VìiË_h:?”÷_•≠ﬂ\\°≠cÈ ∑ÈRh˙Êô7Ù≠T]n_?]æ‚*]·d}õ¸]∫¢À(]1YùæcˇV˙ŒÀteÇêÆºÒñÆb‚AW\ræOW€lB◊®ŸB◊>ZN◊~M◊~ˇù~‡÷›pã;›—O∫—∂∫±ﬂ∫qõn“SJ7Ì‚–Õ.Ï•õ=–ßº:N7ó˚L7œπD?îÜß—O¢[pbËgÍÈV8k∫UP-›™}ïv¶CgìÈp§#‡U”ëc\rtT˜:fÒ\ZkËE«Ü‹§c”¥ÈÿZw:énL«M£Ë∏˘5:˛›N:˛É-ùh•É_û”I3:©IöNé3£ì´ËÙ—kt∆©Y:#øçŒz˛áŒñ˛Dg´¯”9êtÕÉŒ∫BÁ\"ˇ–yjËºK≥tﬁçB:A®4“Ö~õÈ¢?1tÒi5∫8=ó.Œè£ãé–O<´°€$U”m⁄uÈ6‹È∂3˙táG˙ôó¡ÙÛMÙÛo/”ù_µ“/Íx—]–]Ét7¯U∫{y3˝öF)˝7ôÓqc+›c¥ÜÓ)}òÓuÂ˝6SëÓ´´N˜˝E•˚Èﬂ§(ø† }ËπÈÅo⁄ËAÌAÙ`â9z∞◊6z·=¬EèÏßG.x–£¥Ë˜N—cëÙ˚Ï:z‹øez|p˝Å˚]˙Éw\ZÙ‚UzB∆)z“⁄/z≤Î,=˘Ü=π,óû*%§ß™ÿ“G\\•?nøHOê§ßáÔßßœŒ—3v—Ë¬˙ì°›Ùß;ÊËYá’Èy^˘ÙôœËÖZfÙRŸyziñ^Ê©I/ã	£øﬁaD„úEØµæCØ-˘Coæ≈•∑Ñû¢ø_êßw∫&—?\rù£wÂ_†wØé—{ÜÌËΩÇÙﬁÿãÙﬁÑ(zoˇ5˙g€Vzr(˝´í>7GHÃ§è¿ÙëÚp˙Ë[Ä>Ê¸ú>ÊﬁEﬂ|ì>±ô>^xé>ﬁ®AˇÊm@ˇÓ“Fˇﬁ&Aü8yù>©ËLü¨Ë”v5ÙÈ[\"˙Ù˝GÇ>}ˆ“_˙¨ó}nõ}.◊ëæhvúæhÓM_tÑ–ó‹£/Yá–WêÈ+ãÈ´öÙUC˙ü{2Ùu°}£§â!q´ã±i,é!È∞∆ê≤Ÿ¬ÿå´a»¯ˇ`»§¬≤°°Ÿá4ÜÏbcãaCnè6C>ì∆ÿ&zƒPt-`(.80vj1îO•0îœ“ ï{*eïZcÜöÒcÜ\ZÏ)CÌûò°÷+«ÿ%{õ±ª4ï°ih –ÏdhYî3¥H≠—zÜ∂√%ÜéMCß…–=∆`Ëﬁ|∆–{RŒ–7êcËˇ{)çå}$\Z√@Vïaê‡√0í\ZfÖæ`˜ﬁdƒRáÖGÑAå£üŸ´˙´◊›åc*åcˇDå„ı˚–mÔ–ä\\5êxœ0ê°îá#∆¿∞&q∑«ûA|Z¡\0˝2‰BıO5É˘¿î¡|±»‡Œ>`∑Õ3Ñ˛2ƒ!Ô÷°Íåì‰x∆…b∆…èrå”p„¥ß?√vı>√ﬁ–á·†æÉ·\0{«pd8∂|dú©1ŒÛÁgÆ2ŒØß2.¸f0ú¨_1ú:*N\\Ü≥ç\n√e%Ö·Z&…∏§¬∏L2g\\Æôg\\ÓÖ2‹ºü2‹uv0‹s ˜∂A∆Ur„öa\r„Vï√c⁄ã·=ué·ÛÉ»∏XÕ£~e¯´¶3¸363iå Õ`F∞Ï#4ZñZ Õ3bÑ?ùb‹-0\"TQ˛Åå®Må®Ù=åÀFÃıå{_3‚`Uåxı›å—√åˇF‚çYF‚Ú8„·œ˝åî[åîGå‘“	∆„Õ≤åt|	#ùÕ»‹ÒîÒÏ≤„Yæ7#{∫íëΩl »1Ì`‰‡ç9Á\'πÎßyRÔygz˘ÌÕå{\\\"£HÁ£8.àQ¸#ôÒ JèÒÍ’FπﬁSFE6¿®®êfTtU0^õ92*eWï%ï?ıop?Ui\0£öádTáz2™€\\’ÎåöÆ6FØÑQÁÄg‘}^`‘Õ[2Í{ìoœ)1ﬁz2oﬂøc4‰63\ZkåÊ›jåÊÙØåw5ùå˚Y∆{\r∆{>£’lâÒ·c„√∫£Õ`|d∫1>fJ1⁄S¨çÜåNÓ„Ss?£Àâ»Ë\nˇ¡Ë˙xò—M∂bÙD˘3z≤˙=’ª}O¢}›∆€z∆WâøåØÆRå\nÅ1¥.¡Ængå<Œgåo°1æãåâ√∑w˚ìˆΩåI\'[∆îQ+caÃ&<cÃm˛¡ò”ke¸<î∆¯|â1ˇﬂY<€»X≤Ïb,\Zb¨ä]´…“å? ˆå?’ﬂkÆõkU\nåç3Ìå\r9∆ﬂ¥<∆?{\Z„ﬂ:ô)°ß√‹îpú)©uÑ)Ÿë≈‹åéaJ„§ô2‘ò≤≤ò[/1∑ÃÍ3∑æ»` aæ1ÂÆæc À\\g k\r0d/3\\∆ô€¶ôäG{ôäP¶íi4sá˛:S˘r5S•7å©ºe™]]g™ïf1w]ÚfÓ∫&œ‹ïï ‹“«‹˝˜=S›¿‘ºﬁ¡‘|9≈‘Í^ej˝±eÓâOdÓ˘só©Ω÷œ‘wÖ2˜BN0˜Ì›ƒ‹ˇ‡.” â∆4ºQ∆4Jqb\Z5¨1çcò&äøô&úd¶…ﬂ¶È	+¶Y÷=Ê¡CsÃÉ=ﬁLÛH}Ê°û8Ê°^ÊaZ”\" ñiëh«< {»<ö§Œ<⁄¢ ¥‘6dZ©leZg0≠ÃckLËÁΩL¯Ê`&º(ï	ˇ∏ŒxπL‡ˆ&\"‹åâ,Îbb\Z•ô∏Ì˚ô∏=;ò8å*_}îIÏúeíÜ‡LÚüe&ı5äImKf“%˘LzÂI&[Ê,ì›≠À‰»U19≥ÓLÆó,S(¡a\nΩØ1E7iLÒÌ¶\r¸Ûî^Û¥*»¥•O2Ì≤ôv˝≥L{€¶É¿txŒt9«t<íÕ<Á/f^hz»tBW3ùMÕòŒıÒÃã≠—Ló–ÛÃK§bÊÂMhÊçL∑K;ònõôÓ6ÃkC$Êµ_∑ô◊≥ò◊\"ò7édz8D1=∫∑1=	Wôûˇ|ò^ëALØ^o¶èÌ¶OV&”w/éÈw∏èÈÁQ∆Ùﬂ€«Ùg\\a˙Ûﬁ3˝œÛò˛π®ˇ¨3∂Æ2ƒÃÄØkÃ‡≈qf®ô3lhÄyGÓÛNã93¸y.3BqçQwïâMbF>x å¨d1£ô1¸DÊΩCzÃ{ô±Ù\"flˇkÊ}]Ê}∑rf•âg]Ãåsé`∆πv3„Øƒ0ÿ≈3ƒ¥3†˝Ãƒ fíœSfr¡WÊCw3≈IüôÚMô˘»Œàô∫≤âô1∏Ã|b£ÃÃTNef^œaf—÷òœ∞^ÃÏ∆3ÃÏçÃúﬂéÃ‹ˆ#Ãº˚Df˛•f˛ÁuÊ	}Êã€ŒÃÇt_f¡∏%≥êÏ«,\\gçh3K˛Ã1K≥LôØ\n>2_˝ôaæZ[cñΩbñ«úfñ)0À\'è0+Ã}òØG™òoûÑ2´s˙ô5QÃ∑FÁôoãn1◊âÃf\nèŸ‘Ãlöc∂ØevRü2ªo>fv?YbvˇŸ«ÏyÃaˆ9âô_\"kô_¶=ô˝K—ÃØªô-jÃ!SÊ–^sË√-Ê–ógÃ°πTÊ0ªÜ9b˜Ä9íHcéECôceLÊ˜æRÊÑCs\"JÜ9ıï9Y(¡ú⁄Àúv∏«úe?aŒ›ôc˛¨ÃeŒÉˇòã\'<ôKyFÃÂÊÚ‡\ZseüπÚe7sµÍs≠ÕûπÆ1¿¸nÀ¸˚p\'Ûü\r¿¸™œí¯ôŒíT.bI“≤§∫˚Y“æ±§K±d…≥d<n∞d\nY≤˚\ZX≤n¨-íé,9’W,πw?XÚ‹zñ¸ı/¨m2*¨mj±¨m,\r÷∂ÄHñ‚r7k{¿C÷ˆ¶r÷ˆqñ≤Çµ„’Yñ™\"ç•∂ˇ7KÌ∑&KìÕR/ÍfÌz$diÌˆaÌâHfÈÃË≤t6lXz◊ÕYzÒp÷ﬁ†A÷ﬁ˛p÷æ=ÁX˚o°X¿5ñAC/À`ÚÀ`YüeßôeÿQ 2jmcC–,„+,ìÀLÕ:¯¯Î`#ÑeÓ’Õ2Oâb\Z`q˙≈≤∏√:*ò`ÌüaYM&≥é5>a[&∞é7∂±é/—X∞-*,ÿçèK`!d≤Ç3,Ñœ\nQú…B™g°˚ü±0Ü,P\'ãéobÅYdìÁ,JQã™˚öEı≤èYåo\'X,\rœ◊ê≈{ù¿‚7$±‹Rñ–vô%Ùôa	õÀY‚öù,Î±÷…ôK¨ìãñÕÕ~ñç∑<ÀÊ…1÷©[{YßMÓ≥lœO≤ÏUŒ≥Œ˛˙ŒrºÅa9Ÿ]aπÄJ,ó%÷•ìb÷ï7ˆ,∑¸<ñªe>Î*5Åuu%Üu≠qòuCÈÎ.üu„RÀœÚ∏«Ú\\ùdyC±|^<f˘|+g›&ï∞|ÕJYæG“X~“´,øùwY~Òxñˇ˘ñ”<+PcíÏf}⁄ƒ\nÎwa›9– ∫√\n/8¬∫€˙êafÀä¿~bEtô±¢û~c≈º˙¿∫˜uûªÀù´Ãä?e≈{≥YÒŸa¨¯±$VÇr+â¥âïùÀJ˙$d•$ùe•ld±Rg‘Xiv∂¨4_VZÑïﬁ˚ÑïëW¿ ¯˙âıƒÌ?ﬂ XOUa¨Ã_YYøÓ≤rüXy>¨ºƒVﬁYVæÏ!V~N<+2ÇıÇ∞üU4˘ôUä”cΩ:LfΩ≤™fïk¨≤ o±*ÜXoñáX’5ö¨ze_V√iKV£ç;´ôÛä’≤Ô?ã¨HÎCâı1«ó’Æ•…jOcuh∞:±9¨ŒëJ÷ßœ∑Y]‘∑¨n∂3´Gcç’„≈Í›≤˙ÓL∞˙˛J∞˙!r¨Ø˚îYW¨Å⁄~÷ ˇk∞bâ5‰Ωì5sb\rﬂµgç}n`çM)∞∆S¸Yﬂ/ÿ±&ßYS›◊X”÷txÎ«âß¨Ôﬁ≥f˜ΩdÕRSXsÊ\\÷\\ì%k> ñ5ˇuéµXg∆˙ÖÃ˙5˜ãµd+œZ¶øa≠lF≥Vbw±VÁÏYzGYÎ\ZY6≥%tãŸáo±7=mdK˝dKÒÿR!|∂TÙq∂Ùv)∂Ù.∂¥&ç-s ù-s;ôΩ•)îΩQ«ﬁ˙|[n˜[^∆é-ˇË2[±¬V≤}¡VzqèΩ£ŒÄΩ∞U§ylı®lı_*lÕj∂œó≠ö…÷zeŒﬁ”\'¡÷>ûÕ÷fcÎ(]`Î§≤uµ⁄Ÿ∫πT∂ûHÃ÷˜¥¸è{_]€@≠çm`Œ6≥Ÿõÿáæ<a±êa	±f[D.≤èÈ≤èÂ>gC?`CÌ˙Ÿ∞Zl¯|3…g±Q“πltùêç)`≥q˙ilúéç˚ÍÕ∆#Vÿxøe6>ı\0õ(±á\r¶N±¡˛ÎlR‡õÙ„+õ\"U¡¶úõeSØ9±©˛Zl⁄=õéwd”FŸÃ˝ÖlÊÅp6”*ëÕﬁWƒÊÄ≥9úr6«≠ÑÕçº≈Êf¨≤˘˚ ÿ¸[Oÿ|øE6!ü-HXb{Ÿ¢$<[4„ƒ∂æfÕ>ıVâ}öÛåmk^Õ∂]∏Ã∂Md€e¥±Ìû6≥Ì>Ìc€v∞Ìˇ‹g;¿óÿÁÇÿô4ˆôc?ÿgÌ`;æ©füÛ\'±ù´≥ùf8lgf2€9o7€•Ç vùc±/5d_÷∑d_™≥/;Ôe_Æòd_QWf_Ÿm ær2õ}m“é}m£ò}= Ä}√Ä¡æÂ‹¡ˆ0¢≥=[Ÿv≤=Z7ÿ^cWÿﬁª3ÿﬁw‹ŸﬁoŸ>…3l_;–˚;XÓ;;D∆ù–fá’∆≥√\ZzŸw¥\nŸ·œ¬ÿwO±ÿwÛåÿ˜\Zÿëª4ŸëgŸëY$vTÉ	;ÍS1;™˜	;:4ä}œg˚ﬁºàÎ˛î}øÔ;˜ÄOèb«ümb«ﬂhc?Ëd?hg\'Zﬂ`?∫5Œ~Ù⁄Å˝8z7;m€yvö¢4;Ì¯=ˆìÆœÏ\'?äŸô<vÊá˝ÏÏòÛÏúÅ\ZvÆÚ\'vÓ©∑Ï‹‡dvnïùG8ÕŒ˚0ƒŒÁ?gÁ_⁄ŒŒø√~Quú]d°Õ.Ílg˚6±Knπ≤KºO∞K\n∞K—oŸ•Ù◊ÏW’Xˆ´ûvôsªº≥ï]am«~”≥ã]eµï˝6<ë›¯‡\Z˚=Œ˛®âew™∞ª\"∆Ÿ]≠ŒÏn´˚Ïœ±£Ïœüÿ_n|bâMg˜#œ≤˚ÌÿN8ˆÄ˚oˆ¿Ãeˆ‡s]ˆêa{®Æî=¢6ƒû@˘∞\'ÿNÏ	·\"{Í“ {Í…+ˆÃ!ˆèPgˆOœ@ˆºc*{˛¸7ˆb‘\n˚7£ä˝õsò˝˚Ñ&{i´<{i{È0âΩ≤Á\Z{≈iÑΩü√˛ÉUdØÈ∑±◊NE≥◊9#Ï\r	ˆF*ì˝*«˛g˘üË3Ï•éÑ∑G≤√ë\n÷‡lÓÇq§üpd©ñŸ{Âú-Õ€9re\n˘Ôuô|éb$ö≥Û‡GeÎGe‡Gïm»Qõ>ÕŸı¶ù£Ö1„h_‚ËXpt/∂pÙØõsˆ*]‚ÏÌØÊÏ≥ª¿ŸÁ˛í≥ˇ¨gˇ5.ÁÄÔkéÅ}\Z«†Ÿüc¸Î\'«LsÄcˆ∏ës–°îs–Yñcn¡„òüú‚r”‰π¥ôs‰⁄CŒ—,«<˜ü8Œq=ut{0z@ë◊ÿ‡¿”>q\09\"H]„\0≥ÉÑëe±èÉﬁdœAg>Á`x%<›ÉÉ»‡‡øpR‚¡\nÒåá¯LÅJπs¿{π∞√ùC rHK6r{>á‹Œ°X19îoF⁄Qá>∏ƒa¿wq≠ıNm áÀ*Âpπ,◊!ñ√sÏ‡˝U9\0Õµsƒá‚8‚*ÁÑ„.éıëœkJ5«:´Ås2ı(Átõ\r«Œı2«>Ù«AáÀq∏aœ9„…9õıí„x√q¥XÁúã+Á\\»H·\\xJ‚8È<‚8K^Á8À˝Â\\ºR…q±•r\\*s\\S—úK»ŒÂ¶zŒÂû6éª‡ÁÍkŒ’’Œ-K«S#ê„IM„xû˚ŒÒ\\p‰xw⁄s|n.q¸nÂr¸ï⁄8Å~\rú†≥DN–¿\'XÊ\'8Ù7\'¯=ú\ZÚàzﬂÉ∂⁄»π£¥¬	◊‚qÓ˛◊ˇËN.\'z†úsœÖ…âï8±Àú˚ÖxŒ˝e\'ÓX#\'Œ‡ƒE„ƒÎ{p‚œ˛‰ƒˇK·<hsí¨éqíﬁœs˛˜ûîûaŒ#\rUN*ô¡IÕ˘ÃIs9 I˚f¡IõW„§-ù‚§_ê·§ßKq2‹úåkKúßgaú,]NV‰SNV÷\nÁôı~N6ßÉì}“ëìTÀ…ü2ÂºHé‡Ÿ·î›9%iO8/£t8Ø⁄úÚ(NEn%Áu«N%ÌÁçåSMÚ‡Tˇv„‘mÂ‘]øÕ©ãç„‘/xrﬁé 8\rw|8\rœe9ç‘úfE\'NÀ3·:9-ˇ*8≠∏˝ú÷|NkÉÁC°;ÁCõêÛaÒß-a7Á£lÁ„ætŒ«œÂúv‰-N˚(ó”≈¯ÀÈ‚‰toÊÙ`\n8=I◊9=ç ú^Ù0ß˜˛!NoÀNﬂs#ŒÁ¸BŒÁq[Œóó∫ú~üZNˇ∑«úØ”ÈúQ#gXjû3¢{û3jë¡Ω/Êå-ór∆ùæq∆s—úo\r)úÔ\nQúÔøñ8åbŒTI:g˙Ug&€Ö33øèÛc•î3KP·,zœr~5ks~\'\'qñdƒú•¥`Œ“KGŒÚéÛúïüŒüuŒﬂ»&ŒøxÆ‰≥^Æ‘HW⁄‡ﬁ˛re4Vπ2-S\\ôÖ´‹-°BÆ\\åWÓSW¡Æï´x*òª}e7WÈ¡wÁ¨W\\·™\\>ÕU-W‚™-\'s’KD\\\r££\\ÕÄc\\≠(_Æv\\4W{Hü´€k»’√›„Ó5˝…›øî{‡V◊–O»5lÈ‡\Z|·\Z)ypç ë\\cË)ÆqT◊‰L	◊‰ﬁIÆI=ékjrÕ%*∏Ê3lÓ·mß∏vØ∏Gı-∏ñ\ZM\\ÀΩ\\´#;πVı6‹c∞‹c≥(.BÍ=·∞»EDnÁ\"o˙s1JI\\·)sñŒ≈Ñ^Âb™Ã∏òﬂR\\Ï\r;.¯3úKÓj‚í«π‘†!.m˚Y.3Â/óudóUSœe7*r9≠>\\Æzó{ƒÑÀΩ»‚rg,πB•Ì\\·%WÙÍ8W|Â\"◊∫Ï\r◊ÊØÄ{*2ô{⁄+úkkvûkß˘úkG\rÂ⁄]·:êWπˆÈ‹≥∏gΩOrœQÙπÁº÷∏Á¬∫∏NªT∏ŒÎßπ.´Æk®2◊ıû˜“æ´‹KÂ´‹+w€πÓ≤\"Ó’à‹´oﬂsØElÂ^õ≠Âﬁ`[soTfp=a\\Ø£ÁπB_n¿)Gn@—n`—n‡8óºÓ√\r9≤Œ\rIÀ‚Ü∂<‡ﬁIªÀΩ”vû{g„7<Ó˜ÆÁ6n$ìŒç ñÂF}Fq£≈TnÃ)OnÃ™	˜>µü{ø9ú˚`,èõêå‰&*Â&ÍÂ&{ÿpSÏ/sSfÓrSπ“‹‘—fn˙€\0nzÎ]n∆ıÌ‹åÁÀ‹\'™Ÿ‹ßF\n‹Ã(47≥jÄõ5ªã˚¨Bìõ≠£ƒÕéqÊÊÏvÁÊB~qs”ÉππUJ‹ºq\n∑®˙∑ÑE‰ñÂp_∂‡æ\Zø…}ıÔ7∑ÏÚnY¶\n∑Ï≈nyÊwn≈uÓk∑õ‹◊%\'∏ï)‹™∏n’⁄*∑öUÕ≠›ô«≠ÌÚÊ÷|Ê÷Ø∑rﬂ:„æÌÀÊ6í‚6œÁ6Ü]·6πËpõﬁÙpõM&πÕväˇi„6óÙrﬂ2πÌ{›∏ÕÌ‹ÆˆÀ‹ﬁ|n_~#˜s-Ö˚eÀ\n˜Àz1∑K∑ˇƒ∑ˇe<∑øv7˜´E˜kõwí¬|uã;º∆·é¸‚éÆﬁÂéùI·é›ap«Õ«πﬂﬁFs\'è˜q\'ﬂà∏S^qß*œqgo{sgsë‹πOw∏?˜}Â˛ú˛ƒù∑Á.¨œr7up?ﬁÂ˛>ä‰˛˛ªáª|‡w5öƒ˝Ûûœ]Wu‚ÆSC∏Î˛0Ó˙›iÓ_N˜ﬂë‹$Óø€r<	¶7ORÊ3O“Xä∑ŸJç∑9œö∑πØõ\'-c…ìûˇ»ì=®√€œÂ…S1<˜Á<≈ü]<•hﬁé°Wºùüry Û^<’óÓ<ıòù<ı:OÉX»”¯»‰ÌÔ‡ÌNÕÊÌûº…”Ñü·i:§Û4œ\ZÒ4Ø≠Ú4ó˚xZí∑xZwÊx{n’Ú¥´‹x∫í€x∫¨ˇ≤ë≈”KŒ‰È/	y˚dõy˚5|ﬁÃ3¿Ç<ÉÜ<√˝û1÷ëgLu·G}‚øGÒL£<”˚<ûŸ¬$Ôê˝[ﬁ°âﬁ·Û˚yá„±<q:œJ‚,œJçœ;&?ƒ;&<Œ;vÓ\r˛aéá¿≤yàﬁ<‘}˙l\"ùU¡√ºi‰aÍyò∂eñ\Z«√ókH÷%<2∞ƒ£vö®ìJ<˙Â*=7ù«î∏ƒco]„q-Gx‹¡[<·∂ù<qÕ4ÔDï,ÔDó-ÔƒZÔ§π\"œfKœÉ·Ÿ$\"xß;Úl¡ZûmµœÆœ≥ˇÆ¡s∏“ƒ;ã?œ;[ÒôÁ([≈s$\\Á9>LÂù√ïÚŒ5$ÚŒΩ?¬s≤±‚9≈∏úŸ“<ÿœ5z3Ôíä7Ô,àwY∫ÑwπÈÔäAÔö/ÔÊèº[ÑxûáÒ\'û\'…òÁEêÊy≈hÚº]∞<ﬂDûﬂñBûüß=œÔÈ}ûˇH&/@Á/‡•/p[%/‘ÂÖ| „ÖÛBgya•h^8ÇÀø˝çwWRÇâõ„EëfyQº^T’/⁄¶ï≥˚/Êø⁄›óH‰›_î‡≈KˆÒ‚#UyÒﬂØÒJxè.˙“Õ›xÈwﬂÒû∫ÿÛ2õ>≤ÓVÛ≤™«yœ4û	yœäüûó˚Ò≤Õ‹xŸLx9Ù]º‹\nÔEˆ_^Åi3Ø–¿ÜWºk?Øx˙Øƒ∏ìWbb +±îÂï‹Ë‰Ωî˙≈+çÎÂΩ:VÃ{ïU«{’¯ìW¶¬+Ø∞ÂUh]ÁΩ÷t„UöPyofπº\Z—^ÕÀ;º∫ﬂ÷ºzhØûﬁJçÛ\Zéú‡5¢nÚ\Z˚pº∆eÄ◊®Àk˛Ì¬{g°Ã{|ü◊¢zò˜ænÖ◊z<ñ◊vŒã◊÷µã◊Ó>¬˚‰ˆù◊Â∫õ◊Ì≤ÃÎkx}•6ºœ!bﬁÁÒ∑º/:\'x_O|‚\rúçÂ\r›∆©ˇ…›˝ú7JÒÊç:úÊç~|¬˚fª»õD(Ò¶∂]„M˝„Õ‰f	ºπjﬁœ‰ﬁoﬁÔ◊\'xKâxKœoÚñ>`yKÍyÀÿ	ﬁ\n˛7o5õœ[˝À˚£ÔÀ[7¶Ú˛Í yÒ#º´ˇ¯õn7µ,Ò%kj˘RÀDæ∫Å/ÀÂo›>»óÌÂÀõxÚÂÔlÂÀ∑4Û=T˘äyk|≈öß¸Ì˛ˆ»R˛ˆWﬂ˘J’|Âèá˘*ùk|u0õØ˛wôØqô≈◊\n„k4ßÒwÛ\n¯öÀr|≠DK˛Ÿ3|mïpæ6-ïØÕØ·Î∆:Ûı§~Ûı_ø‡Ôı\'Ò˜ºƒﬂ˜ÕﬂÔ‹Õ?¿∏»?–R 7z˛ìo‹@‚õ@~ÛM»™|Q(ﬂÃ˚ﬂ‹mˇ∞¬˛õAæEòˇË›≠¸£IPæ’±Õ|´€°¸„Ÿ\'¯@éqÖÃG4Â£˚¯òck|Ã7ªUìèOr‰„{Ã˘ÑËO|¢ª%4˛√\'˘Û)2ë|J,ÑOÛù·”+æÚÈΩâ|fø>ü{p7üÀk‡Û7á&„|¡ôiæ]…2Z¯¬._T2Œ∑ç·€&eÒÌ~ÍÒÌ˛|·_XŒÁ;Er¯.£¯Æ#p˛ï\0/æ[—%æª¿úSZñsœˇ÷ëØ|èõZ|è!ﬂc≤áÔ)·√˜D-=Òé|/übæWÌqæWsﬂ”Õ˜Ÿ·œ˜…~¡˜\r„˚˝µ‰BÒ…;˘A¢1~∞Ü!?¯¸?¯ÍG~«oN‡ﬂe}‡ﬂ]~œèxºùÒÓ\r?jÑ”ÁGq¯Qm¸Ë\'L˛=36ˇûø4ˇﬁp7ˇﬁ\nÜﬂÈˇ~ò>?N∂äß$«èﬂÁ«_GÛ¸¬Úñ<¯â?˘Î%˘©÷˛„I¸¥ç„¸t¸>~:˜:?C˛ˇÈ/~f¢ˇŸ÷$~ˆüa~é›E~Ó£7¸‹Ü6~SÅüW◊¿œò œO≈ÒÛ3¯/ÙÁ¯Öos˘%¯~…˜8˛K„/¸ó°ß¯•K¸W√G˘eÁ3˘eØÛÀ˘Î¸ÚN~≈À-¸Jsu˛Àã¸™Úo¸Í©#¸\Z›Ø¸\Z˚2~çèøVˆøÆ~êﬂÒõx„¸Ê5k~ãÅ/ø(‡øˇ® ﬂŒoï~¬ˇHt‚∑´˘ÌpO~«à/øs‹îˇI ÊwŸMªä∑Ò{∫˛˚£¯üSÀ˘_ÆÉ¸˛Ò]¸C. ≈‰ø‰mÊÛá\\˛É)˛à>ö?¶ßœóâÁè˛·;A„srÁO¨ÎßÓñÛgÜ¸¯≥RS¸Ÿ~êˇ3oåˇÛ¿üØã‚œ/\rZR¯ã√¸ﬂÌ¸ﬂ_Ò◊¥ÓÒ◊--¯ˇûò	§0[Re(¡ÊﬂÀÈ\nö@∫Îøúy\'ÿ˙˚•@Œ\"T ˇÈã@·Ò∏@°˝ì@—Æ_†∂ﬂ¸(P∫C(•$vú\rÏTËÏ4i(´*ëá*ûT´ßj◊O	‘äÍ°Å˙üèÇ]√ΩçìLÅñJ†Uï#–›≈ËÔËé¨	ﬂﬁE‹\r</<òêé\nÃÙ6fºÅôB`n∂[pËh∫‡y≥‡ê‡†‡àsè‡Ëﬂœàç¢\0äæ.Ä…Œ	‡•(\"VÄY‡	∞÷·|®õÄ(yM@¨2Ä ÖP’N@ñP‚/\n®Û\Z=[@gx©◊åÅ@ÛN¿⁄R+‡|pˇÓÌ6	YÜ°’¥@¯Å/—~\nN8=Xõ¨ènXè|ú\nNiñl/–ˆ\\ÅCF‡}ü‡Ã∂¡Ÿrú¿—V[p^)Pp¡n≥‡Çœê¿IF,p“#.\Z<∏v‘.ç‘	.õèÆOÆÙ˚‹Ox‹›ÌÓ!$¡µ5¡ÕœΩè-4ÅG8K‡˘ä*’\'	|\0Å_Bâ¿ﬂÚó Ëtõ ¯:(UàÑzº‹˘`*∏Ûß^~RMp˜jö bR_˝»H\nÓΩƒæQ‹7˚\'∏è€$àª&\'x∞oCê∞Îä AøXê‘$HvO<¸n,Hôø&x‘›$x4R H}∞\"HÕë<F_§…Ì§Aó∏Çå6¶ ÛWë Á(»’-‰È	Úå?\nÚD^åΩ∫´ä÷’≈ù¶Çí⁄$¡À^™†B∫SPq_[∫3SzD$xcçTΩZT«Ë\njˆ‘6GÍ∂§	Í/ø‘ßßﬁ∫!\ríìÇFkA„µh¬/	ö-§-\'©Çñ_¡˚S≠3CÇvÎ<Aß|Ñ†Ûá™†Îví†7√C–∑œJ–wÓí‡Û‡Ç‡è ËW1ÿè\'ÔÜC3ÇëÊΩÇë∂N¡(:E0ö,|y	æ-≥ﬂµˆ	æ_y$òê8-òhG	¶<“3€7	f*≠?r≥˙ÌÇŸûF¡B÷i¡ÔπÇ•µ|¡™Á\'¡i%¡ü˜ìÇ5õ%¡z”¡ﬂk\"°ƒoÇPrﬂ·ÊKBiã?BÈ8°t·/°ÙÙO°å“g°Ãπ[BŸ0°ÏLÇpãZâPNÊ§PŒÃE(◊á ˚\'	Â_8‡°Ç˚f°B⁄êp˚´sB•ôx·é îpGãpgF¨PUû&T}rA®.qS∏˚8T®;≤U®/€.4r€)4z£(4“\ZøpöËèËˇZ 8≠í‡¬cPW!hB√MÑ0u\'!Ïxç^#Ñg∂	äÊB§ÁÜE?)D	n	QW˙ÖòÃJ!¶œ\\àØ—íªkÑ{	!≠%§Ôö2i\"!ÎJÇê-≤r“Ñ¢äBÎ∏≠BÎï·I3\r°çœ·©≤0°›∂–ﬁCUhø˙Ex¶iQx∂˙®ÏƒU°„Ç–Q,#<\'8.<◊µ(<ò*<*]Ë%º\"(ºB∫eæ∫ç‹^m\r^◊bo|π)º5yEË1åzùhzùtzÀäÖﬁ+óÑ~0°ﬂÇå0pG¢û.ECÑ°Q9¬pSYa¯o≤0B’Zu¶G}ªD£V\'åy≠)ºG{\"º?C∆-N\n–çÑ|„Ö	´¬ƒ¶(aíIòl\'Lˆë&Ê\nì7~\nSUÜÑiAaö€ú0ÉÖ>π\\-ÃT?&Ãå∏$ÃœfÈH\nük>/x+ÃFÌf˚∑\ns}¬ºOÆ¬ºõÑ˘2¬Êm¬ÇãõÑEK(aq»ê∞‰Ãa…Õ˚¬“õç¬WY6¬≤ˆ2ayÓ·Î˙Á¬7ﬂÑUÑU_ÛÖµ˜«ÑuüÑı¶xa=ÁÅ∞^\"|;E6>6|6ô]6ó6m6õPÖÕﬁR¬Ê¢∞•/|Ø˚V¯˛∂ë˝·˚˛R·É¬/Ñ*;Öm™é¬6O_a[˛oaª§ë∞ˇQÿ˛ò-Ï®∂vâN	ªI?ÑΩø∂ø˘#ÏOÛ~=El©F\r3LÑ#óîÑ#•ö¬ëµ·ËÒ¬Q_P8Æ≤O8Æ\Z,¸&]-¸÷≥M¯m∏M¯›<Z¯=°T8a!ú˙*ú–¬IºÆp2˛ªp*±N8sG ¸y¸Åp°Úòp’%\\ì∑Æ≠g\n7ºÿ¬ÁñE∞^ëƒÖ—¶2?ëdråhs⁄_—Êñël˚}—€£\"π=4ë\"%Rúñmó≠)Ω„àvx8ãv<Ÿ)⁄1%)⁄I,Ì¨âTù≤D™^˝\"µêë˙¢èhó+S§1◊%⁄çº)⁄£Ii/üÈ¯	E:\rdë~¬!—˛*w—˛Ò¢õP\"CØ\Zë≥Pd≤€NdR?)2fE¶_àÃ\nùDÂEÊ€äEá¥EáÜäøY¥ùÖEñàéﬂfãéÁA\"´Dê‘o\"x⁄	<3MDâêUa\"‘·JÍÌaZ†-B_Üà0/„Eÿ}Ì\"ÏH≠ﬂ‰#Yc\"0FGNçâHÛÖ\"ä—oı5QD√ãËÕö\"ÜﬂC£ﬁ\\ƒÍPqû‘ä¯»~øP(¸^Y€YüóY‘äN:Tâlñ5EßsáEˆ?GEé≈J¢s¯ —y7—?¶ËBûñË‚5eë´‘GëÎÎã¢À[æâ.E¢+të[ùü»=\'∫vxMt}‰üË÷á€\"≤ñ»ã~A‰P$Ú˙ñ ÚæJ˘o(Ú/ML lF™àBÙLE°(]Qò∑™ËÆiä(‚¢Ω(joÖ(ˆNäË>ë\'∫ˇ◊R…≈ßæ=»ã%‰6â\rEI.“¢§‡K¢î˙4—£ã◊D©≤EÈêá¢úôËÈÓ¢ßFÄË)¯WÙÙyá(3[Wîµ=RÙå@eªñä≤_»ã≤´óEŸùQÓéh—€Ω¢7JDÖº\\Q·•PQëë¨®®pTT‘+-*öÛ.âJÎã^]y.z¯üæuQÅ&™∏õ&™àø)™{(™Ò–5åôâ\ZÕä\ZëDçÉæ¢Ê$5—ª‹QÀÕQ€iIQªœ9QÁæ®˚l≠®Áƒ∏®Á‚Q?›U‘Ô\Z\"˙˙µGÙı◊≤h\0Y.\Z*\r\Z˚ãÜñ.àÜKñDc€ÃEc˘—∏˙f—x’N—˜WL—æR4qö\"öÑ”D?˛õªÊ∑D≥v™¢ŸEE—‹û—úN§hÆiY4˜[R¥V$Z˙â~É¢ﬂM<—≤ù≥hï5#˙ì—+ﬁdÀoZ-oæ].ñVÀî´àe˝∑ã∑ ∞≈[Ø;àÂrpb˘¨,±¬/±‚ZÄx˚≠˝‚Ìo¸≈J«¥ƒ;XäwXÃâw\\?#ﬁëuJºÁ(ﬁ…++#abÀy±Í˙òXMŸT¨f˛K¨ÜØ´«.â5¨PbÕk\nbÕ!åX´Ô≤X•&÷=\'Î~˙\'÷õmÎÀmÎ≈â˜nÌÔÂÓÔ={V|†‰ñÿ†»Al‘µKl,Rl|÷]l2ΩIlVì&6%ãñßäÕ?;àóﬁi\'∂∏p\\|¥˜∂ÿ +C|l[ó¯X§´z,_Õ÷CÎNã·™Zb`ü¶ë•\'FÆû„t¨≈xC\r1û–+∆€wã	«*≈Dg1ë”,&ø⁄%¶‡%ƒTûóò.π\"f^Q¥ûä≈\n≠bÒ—\\Ò	ˇì‚mÄÿ⁄eß¯$0-∂|->uÒ•¯Ù◊øb[Û)±-o∑ÿˆ¢ÜÿnLZl˜€Yloü.∂˜˙+∂ˇN;xbáWçbGŒ{Òπ«=‚Ûﬂ•ƒÁß+≈‡‚ìJ‚S‚ãƒc‚K™y‚+·e‚+£øƒÓ@∫ÿ}dV|Mõ.æv®\\|çi(æ÷qX|m*æÆxM|›/]|Û\Z]|Îû¨ÿ£≠MÏi†-ˆå7{\ZãΩÄ$±◊ì(±W≈N±˜±œçˇ1\\üÒXQ\0¿eßaŸ\"—îdî\r¥–≥˜ﬁ{?vŸ+-+\"í•ë≠\"îôÜåE »ËˇÒ˝‹˚Úwœ9˜wŒ\0Hñ\0!!;\0!Ô¡Ä∞Ol@ÿx ú(Ñ?\"6Ø\"|Í\0˛7ëz7\0QŒJÄ(–u@‘õÕÄ®æe@4?sBàÅ{b>*\0b?S±≤Ä∏^ ôHÈ(\\\'≠\0n0‹8c∏A\r\0‹\\ô\0§/h2¸[ôyÄl≠¿ù779ÍØ9EIÄª∏)@Aˆ@·Õ„Ä‚^†$†D|P2ÖTl\"\0*Ü˛*˜e*_|<⁄‚x<Âxí›	xJ≥<Mﬁ®Æ¯®…ü‘¸ä‘¨%û]=®u≥‘æ˛\n®k\0‘Ä\0Í√•ÄÁuÄF›@£—C@kV$†ıc%†›E–Q∆º4‹	xuﬁ–ı$–mmËF™\0∫__Ù(ñ\0zYÓÄ>ƒ^@ﬂ,	vc–ˇ∫0‡≤0h…NÜN¨ÜÜî\0Cü#I\0#ø˜\0ﬁz\0%Äe˛Äœx	`,Aex\Z0ôL+&{¯Ä…•e¿î«f¿‹0ù\0=„=‡áR4‡6Û“\'¿œ&e¿úπ\'`ﬁÓ3`ûO¸∫s∞P{∞(g\0X‹€Xv€XAÊVVœæ\0¨vˆ\0÷÷é\0÷è\0÷õ&ÆD¿Fm(‡ﬂ°¿øc;Äõ‹¡@9(_  ø\0Æ˛*ƒ⁄õÔ\0ïûÊïsÄ -ÄõÊÅõÉ’Ä[,Ô∑™‡Å[-ÿ¿mzwÄ€nêÄjIÄZ⁄R†ñŒ\nPÁöP˜‰i†¡¿(–®˘–®_h|ˆ–84h≤∑hv«∏{Ù– P¥29¥:ph≈éZÀÖ≠;wm_,ÌM1@’˚ˇ{t‡¢Å˚∏üÄFé\0ò≤k~*ÓÒÛ:h:uêÄN”I¿£-≤¿£ÛõÄ«˛¬Ä.ˆgÅÆÀI@7˝œ@∑Ês@wÑ∏R8–„Õo†«G†Á’O@œ¶C@/6Ëı[xÚË”∑ËKû⁄õ<≈ûè˝VtÄ˛vÄ˛e`¿è◊¿s˜ÅÁmÅˆ=\0^tÓ^|gº8£ºîˇ¯¸0Hı,0ËÁI‡ÂÒ@@∑ÚÿM€°{Ó\0°È@h’3 ¸f)ﬁıàåaQ‰ ™∏àﬁbåæ±≈h ÓÑƒª|‚? ”ÄÑÁï@‚«@ yhH∫§Œ«iJ7Ä¥XK m2H[2Ç∫ÅÃf*êm•\rd_\0≤úÄÁ-@é‡=êg#ÚßÄÛ?@ÅK>Prﬁ(˘æî⁄=J7∫Ä!aoÅ!ıJ¿êoÄ!”Ì¿ºc¿7>¿˜C¿ﬂ≠¿+>ÔÄWƒgÄ1ûä¿¯$0˛z0æ¥òX<\0L*=L÷I&CÒ¿‰Ë7¿î>¿k9GÄiáæØœﬁÚﬁ≈o˛ã¶´cÅÈ1ﬂÅYı¿¨p`ˆ˘¿Ï`v…0Á˘q`Æò+»Ê1ÎÄyIõÄys⁄¿|Ì_¿{ƒE‡Ω®5`∆X®©\n,º(,L˘,l˛	ºÔòº:,™˛\n,ˆ˜ñû—ñ>ª,øö\n,œÃV⁄2Äè=gÅU°¿\'˝¿jK∞Ê2\r¯πXN÷’w\0\no\0w˛oÙ;∞ôÔ\0l—G[l‚ÄÌ˜KÄˇ◊Sßäÿô˚¯≤7¯äôÏv\næ˘|ÿ•	ÏÈ~Ï›5ÏM>\nÏ˚‹|ßó|ókÏœD\0D?œGvöﬂˇµé~}¸‡¥¯±„$o	¯y‹¯≈;\Z8±Èpb&8Y€ú\\€ú2›¸öùúÆºúni~Ø∞\0~ˇ›úŸïú	«gíÍÄ39ã¿ôµ$‡èZ]‡O‰g‡œ(G‡œ[n¿˘˘∑¿_r≤¿ÖóÎ¿ﬂzı¿ﬂ\'¿ﬂ¥¿?Åã¥ß¿•7˝¿øm◊ÅkóŒ7öúA2¨7 £˚ Âı\'†Õ∂Q†Õí<–Êﬁ†Õ}&†-π%†≠b%êZıêz˝uêÜÈê∆%êÊè:êV˘~êV{Hõû\0⁄q…¥#˛HwS7Hwg1H∑a§Áµ§˜\0\r“O4Ì<—\0⁄˘˛\'»4‡»ˆd˙¶d&x2/eÇv!áA∞˝ KÁ.ê%\Z⁄}Ç⁄c¢⁄sE¥Á¥g–dmb≤Œv\0ÌS≠Ì3UÌ˚âÌü:Ë‰kÅB´Åï~ÄwIAN[UAN«AŒ†êÀ%Uê´‹?ê˚ƒ7–Òì#†„eÓ†@G–âèπ èÍÕ èÒbê∑B\0ËdqËdª=»ßYÚù˙:#åùÖ⁄ÅŒVˆÇ¸7VAÁmt@Áè“@≈–•^((4»¬ÇSÉÇ$S†‡ 00Ê&B⁄ÇûA_Ω¡$€AàxC‚∑\r±D!I© ¥`ÑißÉpÏ= ‹≠n>gÑ_öD∑AƒS™ b¶,àbW¢8QŒ„ATáW *Ì>à:õ¢·Ω@å1àiôb(ÅÿªnÉ8Z@‹¸ ˛m¡\n$LpIr@!áÏ@°áõ@°ï—†–VyPXÏQPd8tÂ∆uPtc(fÈ(V2äCÉ‚/ÁÉ“˚@	ØïA©r≠†‘($Ëöz\"Ë:¸	Ëz—Ë˙«Y–çœ<–Õ¿–ÕiËŒî„ ÿ2 º5 *leﬂ∫\r∫ÉÂ\ZAyQf†|ê&(ˇ∆P˛ãiP˛r7Ë^Ø1Ëﬁƒ9PÅ‚	PÅèTPrtﬂ¬tøÕÙ¿ Ù¿ˆ0®86TRˇ	Tje*Ωïë>ÄN∏Å*º@ï‡QPÂ⁄–£S–„Ìm†*u Ëâ∑ËÈw?Pı≠S†∫P›Í/P£‘ËQj\\∏	jzXj~j˛Íj5rµ&ùµQô†∂å PßêÍ|ÒÙJ¯Ùjp;®Àj7®À’‘ïÛø#P∑OËçÓËÕµPo5‘göÍ{µÙn|ÙÓ_®ˇV:h0‡	hÓc–‡íh®*4úï\Z±z\ZÕ~\n\Z≥¸\r˙≤ı*h¸»c–8˘)h<›\r4Â\rö∏aö»ÏM⁄GÇ¶Bë†©Ñü†ÈÎr†ZN†\0!hæÛË∑Õ–o\Z	Ù˝YdÇ\rwÅñüù≠<ÇÅ˛æ∞˝ùV≠Ô{Zø≠ˇæ⁄Ëvm|¸\rñq9ñ%…ÄeØ+ÇÂŸ`ÖÍR∞¢•X1\rVÏ,+A“¿J5…`e≥ÊhxÀ°O‡≠8_VÒ:x[@x[Ñ#x[jx˚ôi∞™‘¨˙Ø¨fêVÉä¡ÍÎ?¡\ZœÇ5>Ók:èÄ5Åµ§¡Z·`Ì”Î`ùî∞Œã∞Œõx∞ÆQX∑÷„ŸÇıRã¿˙ö·`}˚I∞~Ω;X l®€\n64¿Ä\ró.ÇçXO¿Fq/¡¶à˝`”·\'`≥{T∞˘sÆÃdÆOΩ`ãò;`´À„‡=œz¿∂!œ¿{_YÅÌG∫¿ˆﬂí¿ÏN∞√{>¥/¯@ä¯¿GU∞£¯ÿ±∂\r|ƒ∂|‰ﬁ4¯»Ú	∞ì„ ¯Ëéd1)¯Û,ÿeµÏ˙9Ï∂l>^{|BÑ{`ŒÄ=-ñ¡ûè≠¿^j¡ﬁf•`Ô¿∞w≈y∞w/	|≤RÏ”¢\nˆY	\0˚&⁄É}ˆÄOi3¿ß⁄:¿gé&Åœ™ÜÇ˝˛éÇœ#wÉœáÀÉ/,Ç=ö¿ÅÀ!‡¿’Yp∞Ó~e∫¨û\0Ü‰πÄ!Ø∏`(b;G√Z„¡50ÇËFiΩ£üA¡òo÷`|@+üû∆w^d’¡D ò\\T¶˝0”ÌÊ¡Ù&òÒ†ÃîßÄôE0˚èòﬂ\rÊ<~ÊyºÛwl∫~Ä≈æ?¡‚%`iÇ=X⁄é\0K«ÆÇC^p¡!C‡P£:p(¡˙Â8l«8\"bëß\réå4GN.ÅØ*©ÄØ<_˝€é1é=y/~Nà÷\'zn\'Ò˚¡…ß¡)8\Z8’Cú\Zπú˙˘*¯Zˇ&µECÕS¿7ÔEÉoÉˇÇo\'LÉoﬂõßóDÄÔúææS1Œ±Áî&Ås›¢¡w!∆‡ªòdp>\n\\∞\r\ræÔw|ür\r|øÅ.≤>.r:.feÇK⁄¡• ˘‡“ep˘wpπm¿ˇ™¡Â6É\"üÉFÉ+‹\0?÷öW˝…\0?Ò\0?9ó~ `Ä´-Åüù^?Î*?[Åk±Ê‡∫9)¯π«SÛK5‡Áƒ)pÉ◊mpC[3¯≈\\∏i≠‹bTn=ˇ‹öln˝H∑›¨∑èÅ_Œø≤†É_≠=wù}Ó\"¥ÄªfG¿›√w¿o‹·‡7,pO¡opÔﬂ7‡æÄ;3&¯]È4x‡‰x∞f+¯Ωy<¯}•\0<⁄ß\0˛‡b˛»x˛X˛¯¥<ñv¸±<˛Ê0xb#xíKOfËÇß\0€¿_ŸK‡ô€¡‡ü∏v‹¬˛,¬çõ‡%π(R-º<∂¸˜zxù’\0˛∑â˛óˇ≤IåÄ»]÷É»_Ç(ÄnB4@î#_Bîo’CTÿÔ *BT~◊@∂x\n![ÆÑl©Ölﬂﬁ	Ÿﬁq¢f^QÀ√A‘J  ÍuS\rô6àÜ¸&à∆2¢π¸¢ÖëB¥Hˇ :DK»éA4d«ßàÆª6Dt\0¢Wˇ\n≤ÛR-dgìƒ`i\'ƒPó1Ãˇ\01™:1ÍâÖkUBL(Âì™Ià…p4ƒtˇuàYŒ>àπ9bNyŸÂ≈áXÕWAˆ,¶@¨ÔüÉÿ›≠ÄÿïAˆZ˛ÜÏΩgŸ[k±ÔÉÿØèB∂ÑCˆ]˚ŸœCCˆ™Ç>DÉ8∂Ñ8y@?åBéà±ßﬂµêcÏs◊5ƒ=öqø}\nr<¿‚±Ú‚©<ÒDjC<√5 û\r\'!û3àw|\'‰dÊWàèÁ:ƒ\'ı(ƒ˜ÌQ»©÷ê3\ZÀê3ô gm& ~™{ ~VêÄ∆$»9’»≈m6êKè÷!ÅUZê R¨ÎÀ@`ÍLÅç3!⁄˝º¡D}Ü`™\\ òeOnõ>/°@E;!ÑCÎ“ããÚœ:ÂBÁúá05f!L¿*ÑW\ra?ACÿëéˇ~à†˛6Dîõ	ÛqÑÑ_ﬂâ0PÅDÑmÖDi‘@¢>∏B¢\rS!—ª·êËêò√ìêÿÄÉêÿw(H\\ª7s	Øy?ôâüÆÅ$l\nÅ$ P!…r$HJ˚:$UJÇ\\ìÒÜ\\πV6πï Ñ§ª ÈÈhH˙]kH¶±<$k+í’‘…&@Ó–∆!w6Ç!π9ëêªg+ yv|»Ωãá ˜nòC\nN≥!ó√ ÖJ≠ê%HIù-§t”)Hπº:‰·ïgêG¸˝ê«nVê«Ly»„ªÁ UlG»ìΩ ê\'vê\'µZêß¿THı°áêÍ£ê\Z˛3»3⁄fHmﬁ+H]/RÁ%§·F\Z‰≈ıH”KHã¸3HáB>§£õyy»Ú≤¢\r“ı;Ú&˙1‰M\n“cﬁÈ5qÑÙÜÓÅº5πygÅÉàﬁC$çê°(»à[	dì\0≠®Äå~¯˘¯¸$‰3˜\'‰K\n\r2~˚d‚9\r2…ıÜ|=ÖÜLÎÑCæˇ\ZÖÃÏàÄÃfdA~R\n ?ﬂyBÊ7·!ÛA-ê_«Á øµêEÅ≤òY¸‘Y.xYÓ?Y—KÑ¨à!+≈›êøŒ”êUŸKêU»*$≤∆·C÷˝ˆ@÷!ﬂ!ˇJ.Ce°ΩPπ}˜†r≥P9®¬óE®¢öT±f™$É*ÂgBïöPPeeUËÊ6\0T•›í¨›NŒá™:)BUÉ>@’4EPıå®F¥T#’⁄÷’Y8›8\n›¡AuEw°∫•ü†zÓ«°zm>P˝¯H®°â‘H˝0‘Ë|7‘®ˇ‘‘ºj.ﬂµ∞ÀáZ:9A≠hâPkáﬂPk±‘ˆ÷>®mï\0∫]›7Ø›ÓÙÄc6Ù`ŸkË°¿›–C?°á;∂@_ÈAè<@Cèû“Åç8=öcu¶˝Ç:pÅ„ÂC›÷4†«3à–„•.–ÚzP„®ßs4‘k”S®˜nu®˜’\"ËIûz2Ü=9q\0Í„„\0ıΩsÍ˚˙\ZÙ‘è>ËÑ,Ù%\rzŒg;Ù‹˜ø–K%ä–ÀA√P@M=¬CaŸ∑†‘,(Ç¥Eñ‹Ñ\"◊ôPî)äÇ7C1CuPÏöä)Ö‚ˇ%B	Ÿ(·#JJŸ%•üáRP⁄›Pft\'î£ˇ Ïá\n°JPÒâáPqy<T≤9*µ)ÉJ&–€5hàá4‰ÚKhËM\'hhÀahX?\ZÆ\Z˛m74R£\ZikçÏxçºç¬ﬂÅFUåAØl¸Ü^EúÖF˚hC„¶G†Òó°â÷\\hb◊4	XMECì\"™°)–k»2Ë5¸ÙÜÆÙÊÛ–€Ÿn–tYUh:˜øEhFX4cûÕÙÑfiiC≥Q–mhLöõÌΩ{Ê4/lZÄx-hÒÖXBãB¸†≈TGh	≈Z∂”Z˘r˙®2˙ÿ€ZE˚\r}B›\n}í¶\r}Ú~?ÙÈßXhMÄ¥fzZ{HZwÒ6¥>˘5¥æ°Zˇﬁ˙<˜¥·R¥ÒN0Ùπ⁄‘m>∫⁄ˆË\r¥≠ì\nÌ05ÑvåŸ@;œB;oX@_›äÅæ™\rÉæj∏\0}Ω5˙\Zí\0Ì⁄dÌbéCªBd°›üR°oÊ;†=m¶–æi/Ë[£≥–∑Œœ†˝–ÊË˚˝©–—kM–€ÆA?ù˝Ñ8\0˝TÜÇém©Äé˘B«∫˚†„ë7°„7æA«ÔD@\'O´@\'	[°ìOí°_ü=É~ø|\n˙Ω≠:sùE“°?ù–˘Ì˜°ÛÀ†ø\nûA3†y!–ﬂfbË‚X%t	Ô	]>∫|\'\Z∫¸úñﬂ°°ÀkÜ–ø6<Ë\Zq+t≠]&#åÇm  ¡6˝¥Å…Y∏¬‰∫ãa\nÉÉ0≈´\Z0ÂÑ\ZòJqlÀóÿV¨6l€˛£∞m#ÿvb5Lz\r¶æ+¶ái^4Çi)ƒ¿tæàazr\0ÿŒ”π∞ùQ\n0Y#ò¡éò¡’&ò±	flS3N<3≥`¶˚K`f\ZJ0≥>ò˘ùì∞]ë∆∞›ÕPÿÓﬂÓ0´˘Vò=EÊÃ·∂Ô¨Ï¿˚.ÿAÚ%ÿ°∂òìºÃy–v®s9ñs€*s≥˛ÛrVÅyˇÑù¥Ω\rÛ	7É˘V¿NMD¡Œ<äÅùªÛ„¿¸√a˛0ˇπó∞st=ÿEKX†·‡¬Ä;\rD¬\0π%0‡û`Ïß·\rCVà`»⁄[0¢Ü>ø√ﬁ‹√∂lÉûé¬(ÂdıT!åö\\£ÈÆ¡òW¿∏ÍO`‹w÷&ÙnÉ	?ÌÇât¶a¢êk0±÷iòòm\rì¢\na·Z`·ñõa\0∞»£ﬂaWNÕ√ÆﬁD√Æ˛1á%û{K§¨¬R¶û¿RG´`◊É6√ÆØé¿n∏ÓÄ›t2áej>Äe“±∞,ác∞,‰}Xˆ÷>Xˆ2,ápñ{Ï(,ÔãÏﬁê+¨ Í8¨–µV(ÿ	+ˇ+,¯øj+2º+˙\r+æ¸	V\\Ú\0V≤ı\Z¨§«V∫Ì¨¥—V.‰¬ K\Z`°:∞ä¶0X≈ƒ:¨Ú∫¨Ju¨J	´ÇO¡ûîN¿ûTh√ûí”aO≥o¡™ëc∞\Z2ˆ¨â{ˆä\0k∏kh€\rkxk˛ÅµuæÑµ\rb`ÌÒ•∞>÷q-\r÷9zˆíSÎŸ\"Î˝lÎãRÑΩ≠c¡ﬁ˘ƒ¿˙€¡∞¡wÆ∞·hÿà{#Ï˝ 5ÿËv¬ˇfa£âø`‰N¬>ºœÅ}t≠Ö}y<õ∞ªõ¥ÉMô∂√æ≠?ÜM´<Ä}ﬂ˚nÅ}œb¡f=a≥s`ÿCÿèç#∞π»|ÿ\\ó:Ïw\0l—®∂x2∂JÖ≠â∞uﬁmÿø±≠M±‡≤ºU∏lå\\ﬁ]ÆDºWŸqæ≈ªæ•°\0Æö\\W´ˆÑ´ı@‡jø~√’◊ pÕ)_∏÷M\Z\\˚Ω\\7j7\\Ø˝\\oA◊øü7ê	Äπ7RåÑ=Ÿ	7÷JÉ_ª71òÑõ>Äõ ›Äõ:ï¿M…\'‡¶√—p3ìSp≥W∂pÛ⁄)∏˘å|ó·‹≤_∑˙qæR∑ŒÄ[¡mäá‡v8,‹^∑no˜Ó¿«¡ª?Å¶0‡áWÕ·é∆∏£w,iÅôtÉ;›=\nw˙ÀÜÂ8¡è.Ìáªö√›˜¿›&Ô√›∑láøJÖ{—·ﬁ1~püÚl∏Ø›‹¸~¶M~±™	h	∂¬ªø¿\'·¡Ì”À…Õp¿˘68Ωá9ô¬ë≥fp‘w;8FCéøÛNàáÑ¬I∫pWNì´Å3jÁ‡å˘\Z8˚{ú∑£Œø™MÇ·b<.fœ¡%ìkpÈørxH»ixH˜xËπPxËÌ@xÿ˛∞,<‚∫><“KøÍ‡ø\ZØ\0è5É«,Æ√c/„·±çn8«]∏…:xºŒ2<^‚èøw?°O8O(<OL“Ü\'•‡©!˚·7k¡oåÓáﬂ‹˚	~Ûe¸v w¯Ìz#xñm;<ó¸ûõ.Üﬂ’˙øßù/¯x^(F¿Ô„·≈õÄ‚ÿ‚¥‚5?x…P+º‘ı:º‘◊^>ﬁ®iØ∏öØX¶¿+MQGÿœ«ësjâ#ºÊA?º6\ZØÀoî\\Ç7\rî¬õ|Ñ7/¸Å7ˇ[Ä∑‘®¬[8Vìˇ«ÛΩ:NUºÛ8\n˛Z«˛z¢\n˛z#ﬁmqﬁ©Ô@¡˚ƒ˜·ÔúF‡Ô\Z3‡∆B¯–◊L¯pê|$Ì\Z|§œ\n>Í∏€\Zˇ\"˜˛≈h>—\nü¨&√ø~É√g@ô‚œŸC˛≤—9≠A¯ú∑\'¸◊X>|z\ræÄá/i<Å/}ÛÅØË∑¬W3·k·D¯zÿK¯FP¸)!√xèê-;çêìπãêﬂ¥åê?Ràê_ \Z\'J¡EÂ^oƒÊ ˇí[T_ ∂›˛ÖP5µC®©CÍ\'‰\ZÃ≠¢Ñ∂ÖBÁDb«Î;àW∫n˚˙\'4;√´;3mâ∑+&C+mÑaØÏˇDì„&≥öeÑy‚QÑ˘C\n¬ºVaŸv±˚Ûeƒ‰MÑu·,¬ÊX8¬VÜã∞m?Öÿª÷àpPA8ú-D8<åGÏãËEÏÁ˚!]›ä8îÈä8Ú–·¥˘$¬\ZépÆ \"éÖÌA∏F#\\øË ‹“kÓ#%3Ñ«≥YÑR·ïÊÑöÉµjC¯~‰\"NMé!ŒºçBú%Úóî—à@9\"åRQ@›C\0\\J@b28‰áÄªsztÕ>f≠\nÅ˝‡Ö¿¡U¯Ë◊¬≈±AIf!(ÛTÌ•Ç±\'¡¸D∞¬SEÇS<á‡jÿ ∏›æ\r!Ç\\Aàr¨≈&Dàõ#\"TJGÑÖæBÑW1WÕ◊1˚F1◊.!bç±…5àÿÍDÏÁvDÏd=\"Œı\"Æ´˙	ë‡{\0ëXòâHb…\"ínC$w^@§Ü&#R∞◊\"≠i+g7¸n n‹úC‹åE‹∆∂\"“≠íÈ)ÈÌ˝àåÁ$D∆z=\"”,ë\r∏Ç»û⁄Ñ»!}D‹ïÔF‹ùSF‰˝iA‹Cy#\n”⁄ÖØz^$#J¨%à\nM3D≈ïyƒcπDƒ„ã{èºO?À!™s≥œ´Ω\r+πàF¯1Dcd=¢±h\0—¯ÃÒÇw—§èhrñ Z.ò\"⁄!uàN—Uƒ´∂ ƒÎ„èØWö]r˚›O5oﬁAÙ¸ﬂﬁﬂ }Aº\rtCºÎWFÙ=sàAÆ1TkÅxÔcÖ¯†ÙÒ¡–ÒÒq‚ì¬vƒ§Ebj?\rÒµ˚b\Z≤åò˝ﬁçò€9èò?CÃ«N#Êøî\"~9mF,º‘@¸~òèX<YèX‰7 V,1à’KàU±&ÌG¨˝ﬁÉX◊πäÿÜ\"6ämˇ_!˛ÂX\"eT/#e îêÚvJHÖ”ëä”‰ÊA\nrãÏN‰ñæ)‰÷X:rÎΩ	‰∂§j\0©˙‘\n©nùÇTÁ™\"5öê\ZSçHç’7H≠®≥H≠Ëœ»	&HΩ=æH}~rgz?“`Á?§·/u§ëi“Ëh1“Xä4Ê◊\"M¸Gë&ì5H3w1“Ï˜&§≈∂d§E¶2“r∏iı$πGÕπâGZ.#≠Yøê6QH[Ì„»}{!§äëá’ıëá´˛!ì§»#õN\"ùÃêŒ?Wê.9˙Hó˛V§+_ÈfıÈëOFz:æBz≈©\"Ω2Æ#Ω÷çëﬁ≥Øê>ˆsHﬂz1“wmy &y è<›¯yˆ¿Ú¨Ø1“,ÉÙã\"˝êóo œŸÏCû79Å<Ô˙y^\0E^4!Ö/êA\rH‡éH`\0	Ç…#A‚$ÿã; ¡H&Úv	’WCBÉÕê0¬∆¯ÇD*ñ\"ëÆH‹ÒQ$˛∞í\\£é§ 9 ©a„Hjè	ív+IÁëåS}HFÚ^$£Í\rí◊ª…[{Ç‰#áÇêBÉ≥H—§8§)±xçîåBJ”ê“≤á»modË.2d:\Z¶ÉEÜøGFêAY»à|d‰ˆ»®Ù_»®{6»+Y»+O∞»´F◊ˇ7Éåª$D∆ΩÚF∆\"„Ûêâ&2Õ∂\ZôVªô62ÇºÌ/ÉLﬂ\"A¶€ı ”√ÙëôòpdV‡5d÷¯‰ù2WPÑº{HÑ,E©,!ã¥lêE«CêE›$‰˘‰5yd±Î,≤‚¢\0˘xœ>‰„t‰„Ò}»ß‰5‰”‘9duK≤vYK◊E÷J›ëu◊#^ _4Z\"_üG6=kF6≠6 [¥é [hQ»I7≤5ﬂŸ∂ªŸNŒGv∫◊\";a{ëù#ëØ.ˇCæ%!{]Ó!˚éê}ôêoÂíëoC. ˚5„ê˝ﬁï»˛˚»˛i]‰∞¬,rdÒ2r4·6ÚÉ÷i‰á÷d‰«TÚ”Gc‰g,ÚÛE+‰Áö‰X29÷îá|FN22êì¡»)π(‰‘Wo‰Ù¬‰w;1rÜEŒB_ ¬öësÏq‰ok,ÚÑÉ¸”¯πHŸâ\\™UF.}ˇä\\q>é¸;\rBÆ¶\"◊µ\'êÎ˚N\"ˇ›D…*£d∑°d…∂(yâ\nJ°y\ZµôèRŸÅR±®F©†4Q[Ó¢∂Æ~GmªÜ⁄Vˆ•\nNG©ñ„QjÔVQ\Z	®[∆Q∫N’(›^Oîﬁéxîû˘.îÄ“K∏Ç2‘‹Ñ2. BùEôõ£L˝¨Pª÷\"Pª’›QV!®=r\n®=*π(Î⁄(õc®ˇÁ=‘>≥É®Éõ€Q=ÌPá6ÌGŸÀA9Mw¢ú≥=Q«∂ñ¢éA®„©s®∑P\':-P\'&ÜQûÔQ^ﬂ[PﬁèE(ÔV‘IGÍ$=Â\0¢¸BPÁÕ®j\'PœG]˙úâ\n)¢Ç~é£ÇÉü†Ç_@Å•Ò(»ƒ\nö°ÄÇÈÂ†`≠√(å&Ö˘ãA·:P¯=ÁQ¯© )ŒEnqGQ6öP‘b6äv&EÎ7@—ôWQÃ*(±gJ|≠%IAI∆‰P“î/(i%d†Bü⁄¢\"ˆ®¢\"˚¢b\\mP1ßÀQq/\nQÒÄﬂ®DÖpTí∆(*…Ì*‚éJââC•˛ÆB]É°ÆI⁄P◊Íˇ¢Æı	P◊’ZP7ÆW¢nFˇE›ÿéJá∆¢2®å©VTÊﬁ	TÊ°tTÊ≈ZTf™*k[*À-ugÿï˚DïgWÄ +IBÂ?≠BÂØûF[W°JûÑ¢Jª≤Peæ€P”]Pá¢* Z® ∏:‘£À8‘„◊≥®™+QO\ZbPO—e®Í›7P5i*®ZgTùU«c°\Zj∑£^–QM;ˇ†ö˜›A5Á°Zı∂£Z‘P8]T«r\nÍed/Íï†’•’ÂÌÇÍ◊°∫÷sP›˘®7Jç®7òè®∑ÍA®∑˜i®∑n®w∆ù®wƒ!T§7™ˇ~6j‡ﬁf‘‡—‘»Ÿ}®ëú®˜&ØQ£fn®7ùPÓ/°>Î°>\'Æ£æÏE}¡\r£æPQ_B/¢∆Ø¢¶zo°¶´ˇ†æ+X†f*P?µkQÛØÎQÛo#QøÇìQ•ˇP√!®?O≤Qã\rõPã√ﬂQÀ_PÀ„Î®Â?â®’Îq®ı¶Ø®çËMqÔ–õ˙Ü–rg\'—r;¥\\wZæ°≠GG+ûc†ï~D´Ù—[∂ı¢∑8ﬁFoyyΩ¥\rΩ5≈\r≠ÍûÄV˝¥≠±Å÷:Qå÷oBÎ5I–˙E≈h˝e⁄@fmòICVè°\r_ú@ÈmE7·–fü—fg¥πs⁄‹£mq›mQ§Ö∂(ﬁá∂Ù¯Ç∂º‡É∂ƒCÔéºÑ∂	E€LÅ–ˆ\'z—ˆgû£˜€——˚9O–,àËÔ<–œª¢&9°è™…†ùãm—./∆—n[Œ¢›éß£›~Ù°››–ÓhoÙÒj9ÙâñQ¥óõ⁄À\'}rG:⁄g\Z⁄⁄Üˆ=≠á>•ïÜ>JAüµ◊F˚ùìE˚€¸A_<iáæòIG_úÔA_R‰¢/ÌyçæT\"E2Ó°Étﬂ†Él4`¿\Z\r¨·†A%˚–†éh–ﬂ#h∞¶\Z\\ËÉÜ|8èÜ)lE√ï2—=…hx˘\Z°ÓÜFÓÂ†—|4Npç˚ıçœ◊A8h‚ˆq4—çè¶Œ3–4ùch∫Õ/4}åÇf⁄Üfz!—Ãå}hÊ+4áF≥(_—Ïo{—\"ÕM*FÛ\0fhÂ&ZPÁàÙE¢Ö„hÒA=¥Ù¨2:4ÑéP∂GG\\˘Ñé\\˛çæ  FG7q–1]t\"\"ùrj:VÅN’‘B_WA°oﬁÎ@ﬂÏåDﬂ>ÆÅN\'˝CgÔUCg≥:—ŸÂ\"tn~-˙n~:OEù/ºÄægı],@ó–≈Sœ–•ÌÜË≤∏QtŸ¬]tÖ…Wt≈œÔËJå∫ÚœÙ£g—ËG?xË«âjË\'“nÙS’˝ËßaËß)tÌ-t-!]ÿ˝‹g›h@7Ê$°_‘¢—Mö£Ëf’\\tÛ$›˛w˝ÍY\Z˙5Ò∫À˙∫´3›]›äÓqËA˜pËËû∫◊áçÓ„ˇF˜ıÔA˜ç∂¢ﬂYlAø+g£áñ◊–√Ú1Ëë@!zgÜÕ˛é˛∞nÜ˛»CA£—fÙƒ€NÙî˝Ì:˝m9=Ûd=Û‚\0˙«÷FÙ| =?s˝[…˝+á^äÉ†W2—+opË5Û›ËuÂiÙÜd˝/F˝Ø„˙ﬂº#„ˆ#€èëÈ¿»ÃÆbd~Öa‰-å0ÚÓÉÖ£Âˇ¡(]‡bîœcîóvb∂¯∑c∂⁄™b∂´tc∂KOb∂?Ø¿l_w«®]≈®/b‘n`‘zoa‘É1Zî„Ìg«0:ﬁXån™9FÔ7£∑¥Ä—˜™¿Ëﬂ€¿Ï\\J√Ãˆcm1#,c*AbLG∏ò]}äK•ΩKMuåUÜcç≤≈ÿl”ƒÿ÷˝∆ÿ!aˆ ú√Ï√\n1˚„\n0®9òÉ”Ø1áˆ®`´)a[e0GÇZ1Œõ≤1«]∆;ç9ˆc/∆%¶„ô˘„M}å9¿«úÏπÖ9ﬂÇ9ù´ç9=vs∆n;ÊLa∆Ôı.åˇZÊ¸^]Ã˘øòó>c.›ácΩœb%ùò†qUÃÂSKÄàè…b1‡G#Àl‰);◊çÅçﬂ∆†t›1®§0™\rÇA+˛∆†˚1ò^\\ƒsææCr≠√ê»g0§´w1î‹èzCØÙ¿0ó0Ïc%ˆ*√5¬pªèbxŒ0¸±RåHF(°cDÜ˚1b‹\råƒ€∂¨à	œÂb\"Óø¡D!ÓaÆÏ¬\\Å¨`Æ†v`Æ¥.bÆö˜cÆíµ1—Wpò∏’ÕòxL¸?LÇm/&±∆ì¨6éIïÔ«§&R1i#9òÙ∞L˙$ìÉ”¡‰ÖV`Ú√Õ0˘•ò¸Æ#ò¬Ê˛º7¶ç)3VƒîπÄ)ÁLaé£0ï8ò øÒòGDÃSÂÌòß˜ëò\Z+0ÊôÛıSk˜Sk¿‘ïø«‘Ω¡‘o€åiï`^òê0/ı1MzLìK*¶˘›*¶Eîài}Å∆¥mçiπåyu0Û˙”’√tıb∫˛(a∫ô(ÃõÄvLÕ”#»ƒÙ˙û¬ÙY≈b˙√Ù}}ÅykÏåy¬Ï:åp˘Ñò[∆=ë«À‹≈ebÜæ√ºR0£~Ô0¡òO◊0ccãò/«∆0„Æ`&ï1M˝òIÕ\\ÃdÄf≤mf\nUçô∫ÔáôZ;É˘zá˘Z˝\rÛu9ÛÌL<fz´ff33Î°Ä˘q[3óÜ˘µ\nÛkÈf·˚oÃü&=ÃbFfÒ¡kÃbµ?fY ¡,gªaV1kö&òµÎ0ÃZô#fåŸê∑«lÿ£0àÉòçóÆòB±2è±≤p¨¸yM¨|¡V¨¬H>V)fªŸ \0ªy©\rªµÂ4vª#ª}ÌV5ïèUM˚ÉUü√j<\nƒj:\ZauTc∞:˛o±;∂™awò€c\r¥’±Ü>≤X„;¨I…\Z÷d‡÷vkﬁXÑ›µ8âµ<iÜµ Bb≠Â∞÷j\rXÎ™Ï^W¨=^ªü¨é›ˇj{`«mÏ‡~ÏÅ0wÏÅ ;ÿCMaXg”\nÏ1Õˇ;„•p¨÷Î¶›Åuã¥ƒ∫€…`›ÈbÏ	ù|¨ßÚw¨Á\r÷´—\n{2’Î˛Î3rÎ{÷Î˚˙%ˆ‘EÏÒ)¨_Îs¨ﬂl÷ø&pj+6‡’\rÏ≈ü÷ÿ¿œÅÿÀ3πX¿∑,®¸\"ö°âÖ∂±–±!,|g:·®ÖE\Zù√¢|±®&-Bc1[\\±ΩÛXú}6Âcâ87,ÒÕ,˘∑\'ñ“bÖe˛ä¬≤‚∞¨Y,;ÅÅÂPnaπeÖXÓw9,ùå2√±\"˘T¨Ç¬J‘~b%,V\ZÜï~8àïŒƒÜfﬂ¡Üù\0`√ÜIÿ∞y46‹»^æàçP`#ø«Fr∆±Qiÿ+(}lÃﬁBlL7’éMÚ\'aì…Öÿîùñÿî£9ÿÈslÍˇ9ª¶◊ÉM;ëÖΩy\n{#»{„uˆÊŒ„ÿõ+ôÿõÎÎÿ€\nˇ∞∑üù¡fd˚c3´J±Yavÿ;^Sÿú/&ÿ‹Ω˝ÿ‹ ln”Nl~ö#ˆ^π∂`Ø\"∂¿Â∂∞\ZÖ-6œ¬« cãóÚ∞≈Î∆ÿÀmÿíòªÿ2p2∂ú^É}x[[·ﬁç≠Ø≈>äΩÄ}4=á≠*cü§2±’âÿ\Z$[ÎÒ[∑±[ﬂjÑ}Ôàm4ºâ}°˜€\Z◊ÜmÌ+¬∂∏b€ÍR∞mK∞Zõ∞Aﬁÿé‡lÁÌ}ÿŒá∑∞ØºÄÿ.‘{lÄÌÍ•bªøMb{w÷`ﬂ:Ô¬æí`ﬂ≈›√ˆßYa˚ß|±˝_cå±Év∞CN’ÿëæõÿ—’5Ï\'ã£ÿ±8ÏX˚\rÏÿHˆãq+ˆKT#v‚Nv \rãù \"aøZ~«~}◊Ä˝ÊÈç˝æ¡¿Œà∆ŒM`gÜ}±≥…Iÿo`¶8bÁî8ÿ˘x{Ï|πv¡p\0ª`2è˝]Ö√˛¡ı`è“∞´M}ÿ\'G∞ˇÆ∏cˇ-o¡…ò+‡6Òü‚dã˚q ûU8Â©t‹ñ‚Z‹V’E‹÷›Áp€.)‚∂oR¡©€‡‘vìqj¢9úZf?NÌ…!úÜ^N√—ßÈ≈i≠é‚vË√Èﬁ\r¬Èˆ|¡È«∑„vRŒ‡vñ`q&Œ†∞g00ä3å€ç3åè≈c„å?bq¶ÇBúi|Œ,ˆ Œ,i3Œúbç3O<Ü3øªÄ€5√Y‰Œ„¨|ü‚¨(\n8´$mú’£ü8ÎÊÉ8m2Œ6É€´eá€;Ògˇ¸Œ˛OŒ“åsò´¡\\zà;ÙÁxÃw§%\0Át+\Zw‘nÁ,„äs·‹IÌ8ƒúßs	ŒÛˆoú˜n?ú˜ﬁ,‹…íw∏ìØ•8_ìe‹Ÿ“œ8øcúüW\rŒœ_ÁGŒ«˘Öû≈]h¯çªÿªÇ,øà^\\¡]ﬁ˘\rwyWTÕ¿A∂/‚ jÛ8»+jPáÉN¬¡ºq0F?qPá@>ƒ!>2p»}Ôq»[x Pá˘·ç√Nh‚p÷8‹uW~:\0áˇ•Ö#H_·àgpd›\'8rÚE◊G9Íã£Í‡hŒÆ8⁄ım\\«∏3ÑcÙU·∏În8ﬁ˙ú@%\'8àz˘‚ƒ.8ÒÒÀ8q\'˘øyJ>êpa[4q·)p¿n\\Dr.r≤	Uäª⁄”Ñã=RàãM∏ÖãÕ≠ƒ≈UÌ≈≈ım¬≈ß©·löp	p	wŒ„ˇ*„íN*‚íj∏‰ó˚q©Ía∏¥úù∏õ ù∏tﬂ\n\\˙u.#ÉÀÚ˙âÀ’.≈Â’Ã‡ÚñO‡Ú˜˚·Úù=q˘ì¡∏{A[p÷\\Aœ>\\¡‹v‹}◊\\ëƒ	˜`bW\\÷Ä+õ· ggq«Vpè„›1ƒ=˛Èá{z†WΩıÆÊü=ÓYzÆŒÙ\"ÆŒuW_Æâk‹s◊x‚ÆÒ¡y\\˝Æ˘◊õ«µ®π‡ZñÚpmê∏v˘p\\{Œg\\g˝g‹Àz‹ÀÈ˚∏W˜~‡^Õõˇ/˜˙‹\ZÆ€ø\n◊}ÎÓÌä<Ó› o‹\0ß7{7¥)7‘w\Z7Ïq7Ã÷¿\rG·ÜÎo·FVqÔ=√pÔë!∏˜ç˛∏˜Y∏O^,‹T|=ÓÎ7ùêÜ˚Æ°è˚ﬁ∑Çõî„f–∏YÕS∏Y∆)‹Ôs∏®y‹èIs‹\\H◊ˇœîQ‹ﬂ∫2‹Ü≥\nn£u3ÓﬂCmºLÍiºlÃmºG\rØò]âW∫ÙøÓÕ¯Õ∆õÕ»¯Õ/áÒ*úS¯-â«Ò[[æ‡∑YÓ¬´˙‡UÀÊj®Ωxı}Xº˙‘^c\ZÄ◊îyÑ◊)p∆Î,¥„uV€;b˙zz9x}X^?˝+ﬁ¿ropÅÉ7\n;å7˙F¿H«˚∆SùxEºπã:~◊ælºÂ‡~˜>-º’ÌLºµâ=ﬁV„ﬁvÃø~Ô†WÄwH5¡;îÇÒ˚É/‡˜˜«;d‡€[GvJNØˆ‡ùgeÒ«ê{Òn^\'nÛÅ¯„}¯óÜÒ^Í\rxﬂö/xﬂY¸)ø≥¯3˜w„œ∂=«˚ik‚˝LÆ„˝ü\Z„œk^¬üw ‡/¿”ÒAVÆ¯ I>¯z˛r√\"†Ùp˜√ÿŒx`c(Ç1∆C\rÙÒ∞£}xòOB‚·*Òpg	qQèl«£RS®f3<:\0ã«*m«c\râx¬T2û∞˙O‘;Ö\'¡ú‰ÉWÒîÉó‰<Âœ<’íÑßŒ€„È°rx˙˜r<„Ú<ì#ágMË‚ŸN◊l¬c<ß«œã¬Œx‚Ö¿kxë\"/zÊé+≈KÏ]Ò“≈√¯êÊ6|∏•,>‹JûÍÅœ•‡#ÎÉÒëSy¯+7ÃÒWÀÒ	Z|Çˇ\0>!˘>·O>qÛ,>Ò¿%|rü\"8ÉOùÖ·Øπh„”\\ì◊9E¯ÎO‚o¥©·oø!‡”sX¯åµ¯Ã\Z&>ãµü˝>˛ÆÒ>œÎ$˛^_8˙ˇk2˛˜æÿƒ_Ïóç/a7‡À|ÃÒe˛≥¯áöz¯\nﬁ-|•ˇ¯ÍæZ«_”`äØs]ƒ◊·cıÒı¯˙—◊¯Á]¯áÙÕèÉ-áºÒÌ„€”Lùù’¯óÎ∑ˇﬂ1|˜∂<|w±˛çz>æw[3æhå∞ºÅí‚á~«ˇ,¬p‘ƒ¥†‚?ﬁ“ƒ“Q∆∫„Åˇ¢?Éˇñ¡OúØ¡OI¬Oû∆‡ß>Ò_ÌúÒ_Òﬂ˛¿œ ﬁ≈œ\Z>¿œé4‚H*Ò?≤Ó„dá·ÁróÒsu[Ûi‚BãÈQ¯≈Wπ¯ÂÉã¯Âüz¯Âïm¯Ù~•©ø˙øQûGÿtïKPFîﬂ‹&(ø?Gÿ¨_IÿpÜ†Rpó∞›∑Ö∞=˝*a{è†Í\\CPMü#®ˆ9Tááj¢^Ç∫A!A3bÜ†ıﬁü†=‡J–	L\'Ï˚t/ì˙≤ëÑùóævñÍå\Z£ä~Çπs9aó[=¡≤B@∞¨◊$ÏFÌ!X5hl6yÏ¸C	{Éµ{ÖÑΩø2˚ÇYÑ}œ6åç\r?\"˙Ç#8~\'Qè&Aû#·∞G\"{	Gﬂ∏úy^ÑcL6¡Â¶\Z¡›πöp‹6êp<ı1¡£Mh8K,Í\"x›à$x=3!x€UºIw	ﬁ%`ÇèS0·‘˛	¬ÈWw	ßﬂà	gù¥~≤q?≠)Çøá¡øvï‡ﬂÙípnxÖpæzåpæı+·uÖpQFôpÒò\Z!®DãÙ£ã‹ÌB∏¸Bã\0∏iK\0ñ©`∏Ø∏s\n1 ! ’´»∑åk/[N%‡“\'	Ñk^bç@ryJ ]#ê:,	d´<yúK†¯v®ø¥≠Á	l˝H˚êÅ—%pÁ#º‰hÇê±ù ´Ñ˘£Q¨%A∫bMàTœ&Dﬂ#Dío¢î™Q˚¢Œ+Æ∏vÆ‹©&\\)9O∏≤aG∏⁄ôNàé∏Kà^ù\"ƒ{+‚ïÑ‰<2!%˙3!•~Ép]≈ëpÛÄ2·÷Ê¬-p·V^	!›·\n!=Á-!ÉöN»4ã d&-≤≥ŸŸ°Ñ;Àü	w1≠Ñªs=Ñº≤\\B~L(°‡ˇ|n{C(.ÿE(5F(ïÍÊd—ñÑ\n§°¢Rã»æÇP’YOx2–Nx\Zuñt˙(°∆>ëP¨J®+i\'<?:Ghdæ$ºËT!ºx%%º“±\"º™Q!º.yMË~&tOﬁdˇ Ù<CzGìΩ_¢o´ˇ∏\Z¸	ÉºR¬`z:a$Ï&a§Œï˛¢î0˙∫É0:L$|8÷M¯∞~öÒÒu¬ß)8·s\\·À—ìÑÒ%ÑÒ±n¬dΩ*·Îè%¬7Óe¬∑¬U¬∑j6a\Z‹I¯>[@ò›Kò#ªÊ¯zÑπ\"_¬‹áüÑy’\Z¬B–w¬Ô›¬ÔGÚÑE ì∞§”GXZ#,˚÷˛&÷Áæ6@à2ª\"â≤ØòDπ=`¢|Ô9¢¢MQi˙>qÀ—cƒ-Dg‚∂˝äƒm«Íâ€H+ƒm<8QıÅQùdB‘– jÓÿA‘4˘F‘<I‘∫µﬁn\"j[â⁄SÌD°Q<D‘m¿ı!≈ƒùW>wÆô\r¬˜\rJ{àÜ’D£á¢…Ã0—‹…ò∏ÀóI¥ºÁ@¥Ún\"Z˝ªG‹”tÅhΩ«âh}fÇh„\'⁄Z®m≥Sàv-Ôâ{!\\¢˝Ê\r¢}ö—˛.ç∏oÎU‚°c_àá2µâáùèÙﬁ#˘°Ot˙iHté‹Kt—{EtyΩ@tªúHtã?G<Ó C<±-ãx‚Ú1¢«u¢ßr—≥’óËΩı—˚}Ò$Ô8Ò‘\\Ò,AÜËÁ.%˙aÉâÁ¶ÏàÁE±ƒªùâû«/ºó\'^TGU‚àÅÒ˝D\0cí\0A:Dà⁄4Í\"$¬	à≥d\"‚ÃYpÑà ò$¢ïuàhÁóDÃ±D\\⁄<˜¢íHàÕ\"RÖà‘;\"ÕtùHkw\"2ÃmàÃ!:ëï∞è» $Ÿrgàl∑DN¸\"ë[ÈN‰v˘yÇ<¢P∫ù(\"Ω\'äÕÍâ‚†cDq.à()X%J!áâR¬KbòZ1b◊bÿóQëIå<=Cåå¸Gåå◊%FE˜£câ1±HbÃ8Ü›IåEn!∆9‹ ∆u$&õ>%¶‹Q\'¶¸à!¶“àijˆƒ¥[â◊«.o‘;o€∫3âb&eâòÂxÑò≠kCÃ÷7\'ÊÃ#âπÁws¡b^n%1Ôn1Ø˙ Ò∏ÉXò.\"Î<í\'>xO,~∏óXÊRM,ß$VﬁΩL||·0Ò©îC¨ÆÀ%÷ò7ü)ú!÷\Z—àµ¡—ƒÜê‚ãºDbìl,±˘`±e˚bÀΩXbkÕKbßF#±” ÖÿâÔ\'æ≤h#ææ;JÏfßª£zâ=*˜à=vœà=≥/â}iaƒæ%4Òù≥#±ø€ú8gq(:ä8Ù˛+q$ªÜ¯˛‰E‚GÓÒc‹G‚®û8ˆ¸7q\"h?q‰Gú<¶A¸ä	!N{•øø#˛´U~#˛Í7!.Púâã‹b‚íäqâòL\\‘ Æ®Wv&Æk◊∑∫◊ëB‚∆÷<‚∆«‚ø\"i”¶ù§M·˚H≤E$πGí¸	IiFRp\")¥^!)\"ÂHä\\Iq,û§î@R∫ëîH§Õ˜p$ïÀb“ˇí +í x#iÀ€Û$µ≤Díz¨I=Ωó§i˚à§ÂE“ä’\"i’îí¥Î\nH;∏Û$Ω≠C$˝i\ZißriÁYí™ÅdrKB2˘ùK2˝[M2ÛP&ô!.ëvegí,–æ$¨…bÌ7iwXi˜\r%“Ó˙íH≤z¬&Ì	;E≤æÏL≤˛* Ÿ9û\"Ÿâ\"Iv\r4íΩæ+iüëÈ@ŒÈ`±È0°ètD=ÜtÔOr©&π4◊ì\\∫ë‹Ùê‹}_ì<ªy$o›Ω§ì«µI>óÔì|Óhê|€BHßòHß∑∆ìNõ>$ùq\'ùÛP ]Pã#˛[%ΩzL\n˙ºF\nVºL\nﬁ]L∫|›í‹{ç<pÄå∫F)ıê@FI†®}ò±‡ì éÉ$»x-	z·	:ºçÑ∞U%°ÛHòŒ1æƒùDº2H\"t!ëa÷$ÚO•‘õDÖGì®\\%=˜#â—TAb\"±*ìÿVGHúﬁygfôƒK}Julêƒ√ﬁ$…Â≥$I°)IRÚÖ\Z7D\nú\'Ö_¡ì\"∞XRD¬“ï@\"È\nùF∫˙r\')⁄‹ñΩCä∆Zêb˛~\'≈eë&IâGéêíöII/˝H7˚H7Ü´I∑&Ÿ§Ù¢Û§Ã‹%Rf	íî}{àt«Ë%ÈŒ«rRnı“›_ﬂIy~Hy◊UH˘&§¸kq§¸È÷ùT`˛ÄTÿ|éT‘hGzp6ÑÙ \"ëTºãC*π  ïÙ\'ëJ&ÛHegHeûE§2»\0©,GÅT>ÛÅTqjàT¡X%=⁄¸ÜTE€Iz©OzJS$U[=$’lœ$’,&=ﬂ>MzÓ@%=?ˇîÙºÈ#©…πî‘ÙÌ©yO!©˘†+©πòGj^§êZeVI≠˚!§V®:©=NÍ`˝Øq;È´ÑÙ™„.©´\nAÍö\Z\"ΩÒ‚ízLîH}i•§æ\rWRø-û‘ø∏@\Z‡˛$\rûç%\rm]\'\r›‹N\Z>rï4<PA\Zïç&ç\ZÜíF∑íF[¬H˛øüP\Z§O‹À§±ˆ\n“ÑO%i‚k%iíêOö¸‘@˙˙ØÑÙÌá.i6˜in˛È˜7\niÈÁY““Ç1i˘Ô=“äÅ¥R7LZÈ¯NZô-%˝ΩhCZﬂﬂJZôë÷{¨HÿY“?72YvSYn¬î,7gGñÁ0…Ú	,≤“ûbÚÊ‡ødïk…‰m⁄C‰Ìﬁ dMßd≠\ZY;YÅº„£	YoBH÷∑û%Î£êd˝µK‰ù§\"≤°¬≤°¯#Ÿ86Ñl‚Ä\"õZ˚íMΩÇ»f6L≤ôs.Ÿº¬ÉlÈÀ [ûœ$Ôaê≠É”»÷w»6^Á»6c&d€w»∂ïÂd€âl≤ùB Ÿ°iŸ·%êºoˆ˘–g≤£“≤„’%ÚQ≈/‰£ü`‰£k‰cQ‰cÕ„d“Ÿep7ŸuM>æ›ä|<≈ãÏ}˛Ÿ;ëC>9ÂFˆÅ¯í}˜ë}âÖdﬂOPÚÈ«∑»ß{wêœl{@>Œ üEZê˝ˆÙê˝N˘ê˝	8Ú9p˘¬°£‰M‰KGä»óíío∑êÉ+·‰‡˙rpÛ_ÚÂÿT2ÿSâ1ë!Ã:24iö}C!√cÇ…ÿádƒ))1„NFæÿ £ﬁ®ì—Uª»Ë˜zdL∞àå°9ëÒr02˛∞*ô¯∂ùLfˇ#ì£ì©F©dÍP-ô˙}?ô∂QGf¶¶ëY≤)dVH8ô5iLÊ\\ëπ-ÍdÓ|ô˜˚8ôøíCÜ»¬k´di‘o≤¥ öÚÔ/9¢Ï\r9í˘éÂÙä|%ÉDæRæDév˚BéYà\'«jgí¥êì.êì Dˇk\"\' ß)‘êØèÙëØˇ%ﬂŒío/ˇ%g\\O$gåØí3w≠ê3Ôéí≥‡˝‰¨ÆdÚù‘`rŒÂ%ré»îúS GŒY˝LŒ–»y©0r^Ö9Ôù<9ˇ›4˘Åﬂ/rIã˘°æ˘QEπ éAÆ:¨C~É¸4¸9˘iVπZﬁô¸¨(ù\\€Ü!◊y¨íüìOìüW|\'7LÀëèæ!7ñfêGÂ»Mh>πÈÅ‹¨`InÈDì[Ìﬁë[/Ì%∑f¬…≠+è»Ì*ß»ÌEæ‰éoˆ‰é˘*ÚK ˘•‰\"˘Âè‰W~ö‰◊Ω‰.`5˘Mÿ\'r6è‹sgå‹ﬂæJÓˇä\'Ùn%Ù°…ÉòÚêf\Z˘„ô(Ú£Úó©À‰…RmÚT·?Úå\në<£QA˛QSK˛ÈnH˛)Õ ˇºsüº Ò\'/z-ìó\Zì»Àåc‰ÂiÚ A?Ú\nˆ$y#m/˘_|.Eˆo%EN;è\"◊nFë∑∞¢(U°li¶l3Ú¶®~ •®ÔŒ§®◊˚S4vçP¥⁄Ú(;Æ©St1-›>#äûPÜ¢óªó¢Ø§AŸiˆ?säÅ 	ä·\Z≈˛.ä&âbLπI1˛é¢òwPL€ŒQÃª:(ﬂº(VÇ-k7≈˙ã6≈∆Ì6≈fòA±\rt°ÿçn¶ÏSÖRˆΩì°Ï˜~@9\0.•òı§ä‹F9,ÄrÿKç‚∏ÛÂhÊ7 —\'˙Á¿îc{òîc¬1äÎÎä[¯ä€/<≈C&ã‚yqà‚\\F9πiérÚÍÂdÊCä/fÜ‚[◊E9ì{ür¶q≈œ‡0≈œ*ï‚7	¢¯Á›°ÏP¶p¢(Â&îs%Eîã˙ •Ä\"J`ÛEJ–!\n%®Ó%X∞¥ï^j•@PG(0v(>:JA¸ˇ}»k ‘»\nˆÜ=ª∂õÇ´Xß‡k)Ñ›\n·÷0ÖXlL!ës)ãáJ‰\nU@°ßfRËøwS¨(Ãó¡÷ïN\n˜˜y\nØt3Öàß/º†àåÊ(‚ª&ÒlE¬\n§Ñ¬⁄(a%¸b%¸âÂäÓ_JÃ¿8%Êì7%6jñw‡%ÆdñíË∞õí8å•$◊îSRe()]îk¶æîkáï)◊<G(iÌﬂ)◊i)◊øZRn|§‹\nQ“„ûS“R≤Á+)πEJÓá?îª˜ú(y(\n%èHπwbûR†M)∞Õ£<\0ù£îl∫O)—°îm´°îY§R “Ñî≤{ﬁîÚE<•|˘\'Âao6•rü\'ÂíFyl¥óÚ∏√éR’4HybmA©ÓbSjŸ˜)u\nw(u¡\0J÷éR¡ß‘+ÜQÍ∑ü†<øÒî“8øÉ“$/KiÇ\0)≠z(⁄?(c)ùm™îŒô\" K…ÂÂ†,•À˛.•ÏJÈsØ£ºuŒ¢º€∑â2òmKyˇ0ÉÚ~àC˘x{úÚÈÅ-eL¨H˘Rpì2y]ï2˘:ñ2U\'C˘∫B§|˚ó@ôÊC(3Áº)?,™(svUî_\rî_ˇ¬)‘(F\')ã\'÷)À&ïîïÄ=îUo5 Íàe≠kâ≤nï≤ﬁ@ßlËÃS6X ø 9™ÃoÍ¶/Ø©≤(>Uñ{Å*OJß*ÿ∏SpÈT•3ˆT%‡3™Ú	U%œê∫Â’gÍ∂_®j®j>NTçÌ˘TMÖœTÌ´ΩT›ÜcT›&UÔtU/Ì#U/ˇ)u\'%Ç∫ÛÍ™¡Ó5™—U’ƒÍ’T”òj:>L5≥{M5o8L›ñC›’L›’dAµ,9M›˝lñjΩ”éj}7òjì}éjõ	°⁄ñ8SÌé,QûQ‹,†ÍDRù{P]~n°∫∫?¢∫^¸CuÕ6¶∫Æ`®—ˆTœu™◊èz“RôÍS∫ïzZdM=´ΩázˆãÍO0•˙ˇ†òˇ¢^Pª@Ω@Ÿ†^\nÃ•^Bã®Åñ[©Åy‘¿˛lÍÂ⁄t*DkÜ\n}—GE∏%Që±è©»GÂT‘\'e*j:üä÷£b.S®ÿá©x/ü™B%∏¸†\ZQâ®ƒ^1ï:πÖJ≥¶“äd®¥vs*Ìs(ï~bï:J•KÆP#ATñü\"ï¥ç AP©úP2ïÈ¢\nÉG®Bç*V|B?T°JŒTIw(5§ ã\ZzN\rO}K\rêI\ro∫HçÙ+•FWØSc{®q`j“A25π¬âörÄJM›©OMÖÎR”ûRo•4Soá˙R3≤œS≥ﬂßﬁY*¢Êà¬®wó3®Ô®Öπg©˜_TQXÄ©≈Ó`jI¯.j…wCj©^µ•F-øıç˙–míZÅï£VvSÈ\\§>≈Sü †>}B}˙ ê˙ÙÁYjmC=µ¸Å˙#°6∏©/“Põj‹©ÕÔ7®m™Ö‘ˆ>µ£cµk“ô⁄{¥é⁄_dM0®¢<±¶÷]†∂à©É_èSá=Ë‘ëÌû‘ë¥zÍ®Zu•N˝êÚë˙•=ä:æˇ=u|1Ü:@ù~Eù∂h§~kPg¥á©3“9ÍLÅÄ˙√%â˙„>ì˙£˙\ZıßÊmÍ√â:WûLùG‹°˛6uß.qœQó¯«©kwP◊ÜÓR◊ı#©Îõ©S\"Í?ãc‘ıgiõp4YSM^Hß…gbiä)4•\'é4•o⁄Ê„„¥≠Òr¥Ìji™rBöjB!MÌù¶y\'Mslî¶√|E”k~D”ﬂ‚D38ÍA3\0—h0ö¡ö°ß;ÕêÙïfHôßÂy—å\Zv”Lñ‚i¶•töô˘ Õ|s*m◊5Eö≈ÎZ⁄Ó4Î˚e4ÎŒW4Îï€4õEköù\\?Õn∆òf∑¯ú∂œ≠î∂àv‡‘Ì`é.Ì˙}⁄@ÕI#öÊ§wóÊtÍÕY√äÊíRHs\røNsZßπÁ_†πˇŸ†œyJ;°πÉÊÈ:CÛÙ©£y!Khﬁÿ34o&ëvrﬂ(Ì‰L.ÕG‹DÛYÖ–|∑,—|≠ähæ)\\⁄©+¥”^ñ¥3ê:⁄ô	(Õﬂ\\JÛ/<EÛ˛Ç†—@;gL;G—¶ùãΩJ;oÕ¶⁄)”ÇÂ‡¥‡ª0⁄ÂMQ¥À¶ió!x\ZLˆ#\rÊsÜm•¡Ô1iHY\ryXâÜÜ∆”04å◊\ZZE√≠w”1_hD\0çF{πç∆–Ó§1u´i,«X\ZãÒá∆V“ÿπé4Œï\Zßhç3≤ô∆€&¢	7à4â˝qöt⁄ñ≤MJE†Ö—ê¥ô#¥ãiÒø”dZdÏ4-j‘Üv\r†≈8Ì†≈\\†≈F|£≈Wß–‰‘iI>bZ“ıc¥k‚ﬂ¥kèJiiª›h◊_ô—nÏıß›`V—n›Oª…:IKW\0–2ﬂ“2)ˇhô}Å¥,Æ-{cçvgÔZN≠-óÇ†›=TGÀâ¢Â1•ÂCﬂ”\n6liÖ[©¥¬âW¥¢Ä⁄¸fZÒv/Zq∞\n≠DØáVÁ—Jâøh•©£¥Ú∏_¥äêã¥«—ﬂièo7“{C´“ö°=π?A´nI£=s≥£=√º†={ØE´Ô •=W|Ek”\Z‡ı¥ﬁ ≠az/≠aeÇ÷Ù!î÷Ão¶5øm•5ΩOkë\r†µ‰º°µªˆ–:HZ«T\nÌeÀ⁄+U⁄´i≠kÁZ◊>>≠+‹ö÷](G{C:DÎ—€OÎ9‰EÎ}}ç÷wúJÎ+ªL{{.Éˆñ¢F{glK{w\\ìˆ.|ÖˆÓö3m@ﬂí6~É6ºFßçîÀ”ﬁK¬iÔ+Îh£\'Y¥—œøhXﬂh{RiütKiüûø¢}ö∂£}Æ~I˚¸aê6XKÎˇH§ç∑ç—&∂l–¶éÏ¶Mc“æAÀh”‘4⁄wôÌ¥ÔÎl⁄Ã\"Å6[,O˚…}AõÛÜ”~]¢“2”~œÔ°-=9J[j}I[>ÂB[yÅ•≠öæß≠Y¿hkïû¥u˝z⁄»ô∂ë‘D€h{L€Xhß˝≥ß”˛}u§Àïi—+∞t%≠j˙Ê∫JQ:}+§ùæ›	Dﬂﬁ4D◊ÿ_G◊hˇE◊òó“5ÀlËZ© ∫÷5∫6L◊ñ¢Î*å”u{≠È˙\'™Ë˙È	tCS∫Ÿ≈,∫håæk+âæÀ∂êæ€£óneßO∑˙¶B∑ﬁ\ZG∑Lß[É~“mÃ÷È∂T#∫]∆8›Æ7ín7J∑[€Gﬂ+I°€«\0Ë2^“ÛuÈG\\Atß¯<∫So˝ÿÙ›ÂÆ	›=hçÓ>wá~(¢{öN—=)wÈû}Étœçi∫¨îÓ∞N˜›dL˜e◊“}€∞tﬂ?∑Èßî–OKEÙ3¢ÕÙ≥¿£Ù≥=È˛∆t∂&›øåHP§\\ªM®Î¢ü˜§“œdÈÁ√3ÈÕ®Ùã{+ËÔO—/);“/%ƒ”/Â°Z‰“∆”ÉÚSË¡øyÙÀA”t‡+:òN∑ø§#7”—°^tLP	3xãéΩËK«>o£¿D:Ÿ7˝ˇ/ùÏØNß~†”Z‡t∫ﬁU:„Ç?ùq˚-ùÒ(ìŒ°Ñ“9œ˛“˘¯t¡c}∫pAgW“≈Ö£t…ﬁa∫T)â.≈L”•-9Ùóhz»€z(ˇ$=˙ÇnrîŒ∂£_ôÍ£_ΩIèë_°«Õ”„?=£\',¸°\', –ª≠È©{ﬁ”ØôÄÈi¢A˙ç6=˝¯\"=˝≤==e=„W\r˝ŒN=◊fÑû[\r£ﬂΩ}êûwp\'=OßÁqçË˘ì˚Ë˜ÓÔ°¥·È«ÈEìÙ>≤Ù“°ÙÚÛ(˙√d?zÂ¥\'ΩÍﬂ˝…·˙‰_˙ìo3Ùß\nNÙj≥mÙÍìˆÙjt&ΩÊL<˝Ÿ©i˙3I=˝πu\nΩ¡Go8ûEo¿j–_–Œ—_§pË/∆„ËÕ◊—[Ï÷È-Ÿ…ÙVçjzõâ?ΩÌŒNzßΩ.ΩsÒ˝eÑîﬁU™FÔ˘?OÔ6ó—˚◊¨ËÉ’_ÈÉ\rÙ°ÿf˙0aÉ˛ûkNüwÇ˛æ,ò˛A˛>˝√	m˙Áó6Ù/;~–«Â˛“«ùÈ„\'ÉÈ„7Ó“\'´È”∆ÓÙÔP˙œ}^vô˛GÒ˝¸\n}Òåæ|”îæ\\B_Q‰—W⁄ÌË˙“WçØ—WŒ—W¡’Ùµ≥^Ù5ñ\n}›hïæÓzèæ°SJﬂXf»x#2ı\nŸ}Ÿw;r€\n¡Á\n-RÜ¢‚ÜbÒIÜRbC9Â+csÅ\"cãM?cÎ2c€5eÜ™Ñ°˙‹Ö°yÕ–®˚»–Lêeh∏3t6’1vÑ_gË—◊˙û⁄˝1ÉüªF/Ø3åá¡ìÙHÜÈıEÜiv√l˘!cWò√≤c∑|√™nÇa}}òa˝√∫ÚcØ3î±whà±w√ÇaÛ%√æ˙+√°uc∑ö±ˇ‚∆~æ\r„\04áq›S∆!´GÔ^∆ã4∆ëË$∆Q´J∆—HÜÛK∆±kÅW8ù·é:…∆G2|<æ2|}€æ1ıå≥é3Œñπ1¸Üø‰ØåÄK…åÄ+&åÄÊ€åÄô=åsíA∆π<„“π%F–\\(#¯‰>∆ÂJP›√\0˛ 3ÄQêÿÇıƒ3`…€(ÌSTπ;£9≈¿˛~Ï∫g_Õ¿=¥d‡?å3àîNQ|çAÚ’fêﬁV1»≈˜4ÿ=.õ¡`0>1sGlﬂ-N§#ÉÁ,C<qÇ!mA3B/1\"ú∑3\"¢£˘Ìå´Yìåò˘|FÏ÷ÀåÿåF¸kEFJ≥#∆Hù\01“Tåä›åõˆ÷åõ˚w2nP`‹,Ke‹⁄,f‹j±e‹z»HﬂÒñë~È#ù˘àëâæ ∏cg‰Ù_b‰ãπø8åªçˆåŒWF°ï\r£0¡Éqﬂ;ñQî≥ïQ‘ï≈x–˙ÅQ\\˛ùQ‹qÅQböÕ(Ω¡(mãeî2™ﬁ’3û‡¨O5J-å∫N1£ﬁ!ç—°Ü—x√h§¸f4∆¥0ö∂‰3Zw∏0Z]É≠\"cF{ÀwFß5íÒ≤¸!„ïéê—›äfºQégºÅ^cºπÜeÙ©u2˙ßÔˆﬁgÙ¢CoIå·ßÂåëm!åëâ;åë€Ô\'	å˜øÃ£ZråèÂﬁåO?åü1>´3cœ’ã(∆§Ì<c:Pã1ùÎ…òIﬂ∆òΩƒ¯ë•≈¯ôª¿òèËe¸2≥a¸r∫√Xä|ƒXŸYœ¯˚≥ï±z ô±˙{É±Vgl@v3e´áô≤œ≠òrœˆ3ôgô*VıÃ-{>3∑F~enìﬂ≈‹fö»TﬂïÕ‘`gjT15è‹fj≤ïô⁄∆«ô:ıÕÃ\\<s«è+L=Ô_L=ÅÄ©ˇ˜$s\'¬ùπÀ`Ó§Ìf\ZNc\Z+m0wi§2≠vﬂgZ›‘gZ_ 1Ì&\Zôˆr;ôˆ\'ôˆD¶C$áπøÛÛ‡<ïyÿ…öÈhÎÀ<r«úÈ§wáÈ¥¡t÷>Œ<&c∫¯È0]É¥ôÓù¶˜Å_LoD”;äŒÙN{…<≈f˙xãô>¬ò>K÷Lﬂí¶Ô˚ÎÃ”«¸òg»ÛLâ”øˇ*Û¬Æ∑ÃòlÊ•?ô¡È$ÊÂO©L@3ô	ƒ≥ò`n\"∂ô«ÑâJòpoe&<KÜâX)a\"}“ô®\'MLtŸ£ï¡ƒñ1âk£L∫ûI÷”gRã”ô¥∏E&›¡§üˆf2HoòÃìLñíìÂï»dùôe≤Ç≤ô,∏ì›ˆñ…S\Zb\n>˙3%“\\fHÔyf(„3î;¡å8sñ`Ãº\";ÃåÆˇŒåy{ü3ØÃå•=d∆ºe∆U…3„∆ôq;òÒÓóòÒ]ôâ}ıÃ$Â,fíü93ÂÓofÍm&Ûz7Ê\rsÛ∆’«Ã[ÚÃåôÎÃÃN\rf6]»ÃN<ÕºÛç»Ã¡bôyŒ f˛T.ÛûN\r≥¿Î-≥–®ïY8„Ãºè1»^g>XgñË÷3K` Ãíörf…å-≥Ù‡Wfπ{1≥R·\n≥r)Û11öYÂÏ ¨ [gVÕf1üﬁâ`÷‰√ô5?¢ò5´GôœÍJòœùÍòœ€hÃ&o\"≥Èe≥Yv\'≥˘§3≥Mˇ≥ÌÖ/≥›∏ÅŸNrgv\'1_mQbvô^cvA¢ò]YÉÃãefØñŸKöbˆˇ_õôÉ˜ªòı‡ÃOn˜òcVÃ±*Êóoôé8ÊLç9/Ùa˛Üó1ˇLÍ1ªæ2ó¶_0óÅ^Ãø#âÃıâ1ñÃc(kSò-Kˆ;ì%w¯Kâ˘è•¸Ã⁄Z{èµMVâµç¥á•^´¡RÔŸÕRü˜bim$≥¥Éà,m2õ•Ûßè•≥‚¬⁄ë¶À“UaÈ©Ø≤Ù¨öX˙˝ÁX;œƒ≤å˛Ófô‡œ±LÔ˘≤Ã<Å,≥ÁñπB&À“Ÿáe…ÍdY÷\'±¨L≠XV	bñÕ!uñÕÁ´,;˜(÷^˚D÷æ˝U¨˝ß∆X˚	â¨°È¨√÷ì,ß«/YGV≥ú√N≤éÈX«∞Y«æõ≤\\R+Y«¬YÌ√¨ì…’, ÎîÖÂ7tóÂﬂíÀ:G3aùìL∞.&gû‡≤ÇÛ;Yó7e≤.õJX\0S]‡ áx6∆fı≤ÄÂ˘,ê√‰˝‘tÖs:ÀB\Z˙≤–	wY*äÖı¯Ã\"ƒ’≥àﬂﬁ≤»‚19√äE˘ÙéE]ŒbqY¨€a,V·A{;ò≈πØ»‚Ü∞x;Ë,Å÷vñ\0¯é%tmb	≥Y\"åK‘4¡\nÛteE ≥\"w⁄∞¢õYWº¶YW5≈¨´IœX—µlVú±Äw≈ä;ûÕJ÷≥íw|`%€h≤R˛±R™Y◊Í6X◊∫cXi[ÛXiê£¨Î*Ÿ¨óà¨[¶⁄¨€\'%¨Ù√ô¨Lπ^V÷éV∂ú3+˚~#Îºûï§≥rêm¨úπHV^ã6´`‡+´ï∆zêqëUlN`ï®÷≤J.Œ≥ ‰∏¨2\núUn‡Àzÿëœz∏ﬁƒ™8∑»™xdœz$˚åUuöÕ™	Y’7ü±j\rÙYµí´¨fôè¨Ê{BVKB´’p7´\r5œjè™cuDmauÙgΩ¬O≤∫.±zY=é\'Y=Ó&¨ﬁÎ≠˜\r÷;b?´ﬂÄƒÍØñ∞˙kÀYCvy¨°ï√¨·˘6÷Íw÷àÓN÷»°d÷®F\nkÙWÎCáıŸˆ\"k¨ﬁÑıEFüıÂ_/k¸Øò5QY«öXA±¶4\\XS∆Y¨o]m¨ÔÇ÷˜™R÷Ïi÷ÏCÎáœU÷O÷5÷úŒ<k˛7â5ˇÁ5k~≈éıgÁ)÷üx÷ﬂâ÷Íßi÷ödk=ˇkΩkåµ·éıÔÇΩivÄ≠vç≠‰º¿V˙ëœVñì∞ï\"ÿõ7±7√|Ÿ*ë™Ï-˚Mÿ€Ùÿ€«9ÏÌ≤l’S∂&ƒì≠ÖΩ¿÷ZB≥µ-Ÿ;v∞wVﬂeÔÏŸ`Ëay	Ÿ¶∆õŸ¶Æl3œ›l≥âlÛ8€≤ØûΩ;¡ûmczÇmªpãmg‚∆v®	fÔ+bÔÎ™b™_gJd;	´ŸŒÙèlàÄÌzeâÌ:yóÌ&wç}¬ìœˆ(≤a{v~e{)Hÿ^;lom[∂w %∂wÌNˆiÌgÏ3v@ˆô Ï≥Ö=Ï≥ï˚Ÿg±˝.≤˝ÆQÿ˛ŒˆÏsgôÏKrcÏK:Ï¿Ï`b&;¯Ísv◊œÏ‡\r?6`Ué\rÙì≤!≥[ŸPõlËy6¬ó¡F\\Õa#U¶Ÿ®˝≥lt“G66ZáçW≠b„=Œ≤Ò(96AuûM\0k∞	M√l¢Ó16—YÅMv™fSjÿ,i0õ€7∆Ê«)∞cΩl—Êl∂h‰[ºˆÑ-1ãeKÉÿíísl…H[Z„Õñvç≥C…áÿ°≠ªÿa∑w≥#û˜±#o∞£‚¢ÿQ´lˆ’/ìÏhı˝ÏòøeÏÿÁGÿqS+ÏÑP;Ò’CvÚfUv≤A˚\ZŒNÛÊ≤Ø[†Ÿ◊\'mŸ7WmŸ∑øF≥≥ï‹ÿw2 Ï|o);ˇÅªpﬁä}?Ó˚~˙vë•ª∏|ô]brô]Ú…É]ñ[ .W∑g?‘µ`?l›¬Æ∞sgW0&ÿUˆXvï√~\Z∂õ]cØ¬~Üø¬ÆeE≤Î‰ÜŸı£üÿœ-ü∞U±õ^f7_f∑Ç›ÿ≠åZv«â-ÏŒ.!ªùœÓ˙V»Ó9Æ¿ÓπS√Ó˚ù∆~kÃaøõ£≤˚ã≤˚üµ≥ÕN±áLn∞áèÙ≥G>y≥ﬂ«úaøøëŒ~ˇ¿Ü˝˛ë˚√ñ ˆ«c2Ïœ6ÿc\rßŸ„Gè≥\'Ôœ±ßäÜŸSˇòÏo÷ˇÛ1`O”QÏÈ¯>ˆw≥6ˆÏß\Zˆœª∂Ïü}Ï_AµÏ_IrÏÖ≥7ŸÏ•ë∑Ïï°0ˆ_eSˆﬂc±Ï\rõáô≠\\éYü##¸Àëiµ‚lJOÊ»eÊr‰Q8ÚÌ˘ƒjéÇ´G!≤á£Ωï£P{ä£¨¸ö£|Ë6GÖR≈Ÿ»Ál5ª¡Ÿ\nå‚l•}Êl{0≈ŸnƒŸé|¿Q”as4Â¢8Z∑~q¥Óst∑æÁËbΩ≥78z?Z9˙679˙‡`é˛Tg\'√1f—8fü≠9ñ!:+7g\'òc]‰X?0·ÿ\0?slÔŸqÏ4g8v	ˆgøŒg?ÁÁ–—wúC“Œ·˜#«E\ZÁ®`/«π–É„R—œqyÓ¿q’l‚∏ad9neõ9Ó≤œ9\' 9N∂/-éwÏuéÔ9ŒiYÁ¥K%Á¨ß\rÁl¡ «œƒå„ÁS Ò#8p¸Oõs¸Á\Z9‰N@o/ÁRP=ÁRL\'¯œ‡ıáË„Ä<‘\0…Å…ê8Gﬂ8π◊‘\'˙∫[ë¡!Àyq»ñçäç2á™*ÊP˜÷s®WW8‘uWM5äCõîÂ0Üi¶ÂMsOáŸC‚∞-‘9‹c_9ºeWé†˘*GD7ÊàæÈsBgˇp¬§jú◊O8ëìú´g8±†[úÿt2\'ˆG3\'!≥îìÚ«ÖìxœI„>„§çs97-87å≥9∑ß«8ÈæNzõàì>(œ…(z……Nÿ πÉ1‰‰ûﬁÃ…Ì£pÚû§rÚﬁZqÚ_£9˜\nã8U\'8ÖŒ˝≠O9EÁú¢÷Áú‚41ß¸S(Á—Âãú«≤Á9è—o9’\',95Óú:∑1N#¿yqÚ%ÁÖOß≈Ü iëB8-…è9-7z8-”ÊúVGNkúß\r8…i+} i[éÊtú9ãïúóØb9Ø\nÁ8Ø/9Ø√÷9]ÕñúÆnoŒõªLŒõ_#ú^≤Ä”õZ√Èù~»È3∏≈yk„ºçÃ‰º£p˙◊^r os˙èr=8C”ú°óÆúëÓXŒ˚+_8£ëú—8cŒËóÛ!!ÅÛ·sÁ√ÚŒGOYŒ«gÁ9üá8„g„9„eŒÑ5ñ3y:ÇÛı[\rÁ™ãÛÌˇúOoI‡ÃÏz ô˘Œ‡ÃﬁÕô=•ƒôΩÃÁÃ≤ˇ_S-8o˜qñ¨Ósñêœ9K_ﬂsV,ˆsVNpVÉúø9PŒﬂŒ\nŒÍé[ú’∞3ú5ßŒÜ9ëÛèpòª)ªÄ+AÊ ﬁ¨Ê ˛ÿƒï´_· ç¡∏ÚåRÆ|IWŸøç´<9…›¸ç¬U·Æs∑ê ‹-Ò‹≠	™‹ÌNBÆÍW8WçΩõ´˛≥ü´ë˘ó´Òƒ’éÚ‰Í8©ruÁœpı s\rBVπF\rv\\£…XÆIB%◊<ƒµœ‰ZÓï„⁄Ï%qmeì∏v⁄_∏{ü)r˜~r˜È¥p˜Eπ˚>krB¶πáXM‹Cè√πáUkπéHoÆ„õÛ‹#£≠‹£à&Æs^Ó±≥èπ.ÑÉ\\ó◊Mo◊›À=æßã{¸ƒ?Óq∆CÓqi.˜¯è€‹*ªπ\'û^„zxóp=ÕπûI\\œ?˙\\o-9Ó…›DÓ…⁄ì\\ü˙≠‹”\'?qœÙzr˝6©q˝q˝π˛\Züπ˛¶\\˜XÆˇõ∞mà†ø¬\r∞Ω¿=g2Œ=◊∏∆=/PÂ^úÛ‰^Í÷‚öÂGFpÉÀ\nπ¡?∏`›[\\à‰≤xöÂcπ–∏8.≤ èã™Ë‚¢œπò∏ª\\l _.˘ﬁa.•]¿•Q£πÙÛ.„«•Sﬁpôäπl/.ª˙ ó˝&ÄÀ),‡r/	∏ºF-Æ^\0W8≈ÌQÊäÕÆq≈ydÆD;ë+≠≠ÊJ_irC÷‹–‘‹0Ü#7Ú≈$7ràƒΩBs„^ç·^}øô˝ à#√‡∆(\'rc—«∏q?Œq˜s?∆sìÙΩ∏… 9nrÚsn n ∏=˜\Z>Ñ{mµçõ¶ Ω°tÖ{ìﬂœΩﬁ»Ω’êÃΩg¬Ω›·f∏_Áf⁄∏∑\rπYVm‹¨‚”‹Ï	%nŒ”!nŒP7OŒí[∞^…-<\'œ-Ï[Âﬁgısãm‹Úò4neF∑ä˜à[ï)√}ÇÚÂ>\rÂ>ù1‰>3Z„>s∞‰>W\Z„6ú!r[π≠1e‹÷BÓ´ÂG‹◊[èr_r∏ØÜ∏Ø?sﬂ‘Õs{Œ∫p{ßπ†ß‹¡`yÓ‡]gÓ∞ùw∏\'ü;bÉÊæ◊m‚æwõ„æ?ìŒ}øÓ»˝`ÂÃ˝DL‡~˙Úã˚˘¬Ó¯^+Ó¯!ÓxƒEÓƒÓ˚7wj›à˚ıs7˜˝3˜[a#w¶{ï;´áÁ˛Lgq˛€πqWÓ|f9w·Zwac\'˜˜_\'Ó“≥=‹’s‹ø\ZO∏´y(Ó⁄°ÓZáw˝ Äªmœ›(˙¬˝∑Ωü˚/‰/O∆xOf‡o”Wû|ıAûBÌû +eﬁ6t\'o[vo[{2OÌÅO”téß≈ÊÌ≠„Èu>‡Ñl]ïy∆Æ<Sµ<ÛÄ_º]ûœy÷\n˜y÷\0œ:tòg≥ºÃ≥≠‡Ï™ÚÏÍdyˆ˚ º}{yÕfxGdªyNÜä<W/ÔxM:œc7íÁyyœÛ[\ZœsyäÁÖÔ‰yU¯Ûº:3xß^ÚN”NŒ\0ÓÒŒ†Aº3ÔL®Ô¨Ôûvî∞1√ª0‡]T\ZÂ…nÂwÛÇ˝ˆÛÇ√≤xó›&xóΩ{yóGºyÄ„P ˆ%P›ƒby¿˚<êE4ÁÅOZÒ¿È#<Ù+jê¬É˛“Ê!†*<ƒbØ€Ã√ﬂHÂNÎÛU:<bèt·èl1À#W®Ò(¯c< ÙC’Jõ«Lï·±ƒ4Î„èw√è\'àéÊ	^òÚÑjüxBÊ4O¯¡•rx‚ÅDû§˙OÍé‡Öå˛·Ö|1„Öæﬁ‡E§‰E‹)ÂEå£yQp>ÔJ_Ô™ e^¨g/ÆœK⁄LÂ•ZÚRÉnÛÆ/OÛnD˝‚›h~ƒª5µÖw;˙2/›Ô/ΩÎ:/É?√ÀäøŒÀ∆*Ò≤°º;∫ìº;Kxw≠èÚÓô„›=±¬ÀkÒÁÂ˚|·›;yÉwè~îwo˛Ø xÖw∆+Úë„=H<¬+£ÊU^àÂU>∏¬{Ï<Œ´r˘¬´zü {z0ä˜Ù—~^5ßöW›ìW√à‰’™ÒÍéDÚ\Zâ^„∏=ÔÖbØi¿ï◊¨ıí◊¢œk±ó·µ$⁄0yº∂L\nØÏ√ÎÚÜÒﬁ\0yoH°ºûÓh^oπî◊_H„\rºû‰\ry√[y£1Wxò«yc˝Ìº/\Zèx_Êxﬂ£Kx3…èy≥∆ìºõÇx?2Ëºü†∑ºü˘ﬁ/ŸﬁØÚoºì2ﬁ¢¬sﬁ ◊ﬁ_8Ü˜wÊÔÔz&oΩ å˜Ôí/ÔﬂTST\"S«4_.ƒÜ/œÆÂ+xÛe≥˘äªç˘äOe¯äÛ`æ ∑À¸-ßl˘[\"ı¯[ \'¯[ñÛ˘[Áú˘€Ó~Áo{øáøù–»W›»‰´∑*Ú5æÖ5=˝¯;é;Ûuw√¯zé£|}“6æaáoÿS¿7Úø¿7 fÚçÂ;¯∆jdæqíoÆãøÎ|ﬂ\"\Z¬∑TáÒ-/ÁÛ≠–7˘÷ÒF|O<ﬂ÷Xôo[rìoßØƒ∑ª≤áo7äø◊Sìøœ‡-ˇÄ˝m˛¡F<ˇ–ﬁA˛°”d˛!1îXÈˇÙ-æ£Ÿiæ„+&ˇ»\nùÔ‰∂ŒwÍπ¡?™˘è‘?ûÔº≈çÔ‹ê¬?v\"é¨yﬂ”>áÔŸ¨ ?upå 5ÉÍ˙ˇÙ≈›¸3Âñ|ø$?\0◊ÀŸ«?\'Øƒ?ø\'Ü>ÆÇ>¡‹6ƒæÀæıâyãîŸ˚ˇÚ’#|@ÁY>òÂŒá~ÚaOŒ·ZC|∏ﬁ$ì·««}=≈«˝˙»«üO‰„36Ûââ>©NèOÚ)Ü∑¯T˘ì|Z<õO˜åÁ”Ò|Üâ3ü≥„0üÛDçœ3dÛÖΩè˘¢¡„|)Í	_∫zÜ≤-öíêÀ\rÅÛ√‘ì¯a´ô¸H;~‰“˛’∫Ì¸Ë˚ô¸XÁE~ı?q≤îü¥7ïü,y«OÆ§ÛìW≤¯©œT¯©Ø¯◊N,Ú”\0¸tàüô»œbyÛ≥zu¯9‘y~ŒC8?w¶Éüƒœ/3‚Ç˘Öœ>K¢wÛK˝F¯e¬¸rº?ˇ!$üˇ∞añˇœ2ø“=ç_ÂÃ·?„Ûüj$Û´/‘Úkr¯œ‡_¯µû¸:õN~˝‘2ˇπÚ1~√º\ZøÒ€~~„:êﬂ\"∑ oY7·∑iD€áù¯ùµ¸ó∑7Û_Àæ‡ø˚…Ô Ï„wæ∆ÔÓ÷·wè‡˜/‡+˘Y√¸¡óL˛–!s˛pp0§ºõˇ°\'Äˇa@ûˇŸù«€|Ä?·èÖﬂ‰Ò> üH—‡LÚøéªÛßó5¯3S˘?∆nÒÁŒ˚ÚÁÂÌ¯ø˛ÛˇºzÕ_Ñ∏ÒóµC˘ÀÎo˘+óç¯+CB˛\ZBáøFè‡ØΩ¨»ï^»ïAä4Å“Xç@ı]∞}3@†Üi®˜X\n43ü¥‘MZé.wÅﬁ\'Å˛ÅÌÇùÑ%¡ŒÇù?@mBµ¿†“\\`Ë)0§¢ÜwFráF‰RÅ±%[`™¸D` Œò´åÃááŸÇ›°óV≈o{î6œ∂}pÅù>J`Â ∞{Nÿu‹ÿ_z+p–O8à∑ˆÎ~ÏwsÏüYÙ∑˙Ë%8¬”πZ/p⁄2(pÇ¬G:.¿BÅ€`´¿ΩG‡N¸-ÿIxûæ,¸Ù^‡≠∫,89¨()˜¯T=úi$–YúF\\∏2\"∏Dy.‘OØ	óù¿°»˘©\0‰(\0µ˝Äô‡»∏fU\0±=$Äx†2R‘xA\0z	‡á≠3‚OÖ\0µ∞,¿\'%	à:TÒWçÄ,£ †^NP_:\n˜Íå±s·≥ÄUÓ\"`•8-™ŒHëÄg¯[¿ˇæW ˛*@ÑG“¢–NÅ(Û≠@Ïm\"ã€çÅtÔÅî{U⁄.à≤”DÖõÆ™˝\\=¥KÀƒäëÇ8Úä ÓN± ÆFCê∂Iê|BêHX$fní~†…œûRÜï©ÛÇÎ!ÇÎ_‰◊gyÇ?/\nnª”È“È—[ôÇNAÊZ≠ ´tã ˚|ó‡Œ€$ANPè ˜ÑÅ ˜kö‡n⁄A^‰1A>vü†‡fõ†‡K≥†`$(ƒ}‹∑Õ…øyf	äJñ•â∑e◊Âı≤Ç\nÎ∑Ç \næ‡Q∞@¯aú†\nLT\n™$ª’≥˚œN£çª^\ZªËÇ∆sÇ∆OYÇ&:\\–úp@–<µG–÷˜K–.x.Ë»˙,Ëx¶ Ëdrù°]Çó€/\'/˝ôÇW?A˜¥ä†«rX–kt^–Î· ËcàÔö5˝OWy~ÇAë`Ø#^QåXÂ	F˙GÔsÔ>∏?|8/|ñÌåQÀco&>Ç…£çÇ…‚-ÇØFÖÇogv\næıƒ\næs	ÇÔ¸ﬂÇ•N¡L\0]0-ÃTzf…>Çü˘b¡Ø∂@¡Bhå`·ç´`È“_¡í–_∞,îµ∏%îΩ—&îAÑ\nPo°‚ËS·Ê`äPÂ»}·VõY·ˆÕ’¬Ìµ4°™\\íPÕ–[®ˆÀ\\®~ÿQ®ŸvX®Õÿ)‘.èjØö	u¥ôBùû\'¬	¬ÔıÇiB˝FK·Œ◊CB√KyBcΩ√B„\\°	¢Hh∫ 4◊©ö◊ûÓ28*‹Uo%¥\0ç-}	B´•v·ûèßÖ÷ªo\n≠SIB±´–6∏Nh∑π]hwZWhwÆF∏˜åH∏∑(¥OÕ:xBÖ…Î¬}ªtÖ˚SÑ˚˚gÑádeÑáŒü:^‹#tƒÖNß\'ÑN˛6Bß2û–πH,t°y	]›yB7W·Òsx·…ûΩBüò≥Bø§–?=_Ë?Ü˙ØX\nV./Ï^ú^⁄R\'ºf›ÖA.¬†Õ¬`§∫ÄÆV¥Ö¿êªBPŒm!∏ÒßÚ.PôBUnawBÿªGB¯â›BºWà$®\nQŒÍBT¢Pàæÿ/ƒƒ±\r_Öÿè}B\\.Iàõz-ƒ\'V\n	â_Ö$›!âi!$Õ\"ÖdßÛB≤‘LH~çRøO	YÇ.!++\\»Mº&‰)\n˘™BaÇôPƒnä/áCñfÖ°=Ñaa¯J¨\n¬Hxu∞Q≠ù!å…´∆‚vŒ\nì´ÜÑ…/	SÖ©}◊Öig\ZÑ◊7OØ;U	oòbÑ7so€ÏfÏfÂÈ\n≥Ÿ:¬3;aŒIyaNjπ0OFFòO”Êﬂ6ÊˇﬁKöZ	Î´Ö˜Áƒ¬\"Â.aÒ°¬‚Ú¬‚˙EaâÌå∞¨-DX%jV©	kb±¬gogÖµ+a}mõ∞æ◊V¯|Wè∞—Âú∞iÚè∞Âπ°∞√ä\"Ïx$ÏÖ/K}Ö/_;ˆ_øôv?‡{vÍ{ΩÑΩﬂÚÖo-	ˆIÑÉ.L·†XC8£$%:?:m~îﬁ~¸˜F¯©ÏñplƒR8ﬁZ _⁄-úrŸ$ú∫\"¸⁄ë(¸Ê÷*¸˚(¸˛¸ÅpˆåìpvÒîá…äáw†«i±pÓ†ëpﬁp\\¯+/¸}*¸›≠$¸£rQ¯áµ,\\öH˛M~#\\EÌÆÖØ◊ø©	ˇ}=*⁄‘ñ\"R85.R¯P§0ÒN§xãH1%V§X1\'R:)R¬∂äî ìDJﬂ∂äî~m©åm5\0â∂;ã∂ﬂûmO©˙5ãTÀ>ätà_E:º\"ù|¢h«é¢´ëæs°»ÄÀ¨=ZÎâå{~àL;èäÃØÕâv\r\Zâ,é«â,-\"ãÃNë≈ù\"+;]ëUHdµ≤[d\rÅâl|≠D6,ëmXdª,⁄;ºKdo4.≤æYdˇˆÅhCøË@e®Ë‡∏ËPÏ™Ë–„}¢√äÀ¢√®ã¢√Ò¢£Ïi——°\0ësı?—1…à»Uyß»5&R‰ÊË&ráæπÁ’ä<í@\"œs¢ìﬁ’¢ìcY\"Ífëœ?ÑËîoòËÙ˛>—u¨ËlÔ_ë¶H‰ﬂ˘MtNΩJt¡|Ct©ÚÆË“¬CQ∞,J\\ö-\n~≈]ÓQ]˛¨.»äE@˘r∞fõdºGäkÅ\ZöD`/åÍª.Ç*¡ö/ã‡∫]\"ƒ9R.SÑÃø*BGDãTÓÌ·î´ààäÎ™Dîÿ&%=CDÎ.—Êàÿõ\\EÏ6W%EƒÒFD¸î€\"°äïHƒCãƒŒÅ\"âﬂëd÷UeX%∫z5PSzKÍ)J˙ J≤∞%WàR.NàR≥/ãRªEi©OEi?zE73oãnV-ãn>›∂6•me¥¿Ewé àÓîlÂ4èäÓ§â\näÔâÓ_Œ›/\rπTää;ˇàJñË¢R‹WQ˘ïK¢Ú;ã¢á´f¢\nû∑®‚ÊvQE^T1˛@TÒÛ®Ë±Ú—„¨e—ì◊EO.›=›|ZÙ¥!™Ê†Dœ^Dıu1¢Á2¢˜?¢¶$yQ”¢≥®E≠O‘¢_&j]:\"ÍP<&Í∏,ÍΩ‰ä^â^PEØ~wâ^ÀrDØ\nD=ÉE}áwäﬁ)»àÜ>ﬁçú6çÑ%àFb¢˜$S—«√Ú¢èÁæã>>Õ}!æçÎıä∆Õ°¢Ò∏h¸›íh‚“1—%öö}ì◊}≥i}+< öNàæ´qE≥Ü)¢ŸøÌ¢ü‚4—œW¢ük¢_*\n¢_GzD&‰DÀ∂OD+˜°¢ïÖ*—ﬂ√k¢øG>ä˛Ü≠ã˛ﬁÁâVç¢’Öv—Z‹úhmH Z˚6&Zgæ≠æ&ﬁ‰.ﬁ¥l¸øP±\\m±\\sßXÓ}∂Xæ®L¨ P¨Dàï‚wâ∑íâ∑ﬂÉä’IbM/±fYÉX+≤X¨uç,÷.4Î®øÎñ”≈zíb˝∏ÿ(∏Zl™©.6MâMØc≈¶EÜb3{%ÒÆ!bã“N±≈ãU±Â∑UÒn%w±’+°xOAÜÿ¶PFl33(∂MÒ€ﬁtÔU-Ô≈µà˜\nR≈ˆ~ñb˚¬±ÉÍòxˇÔK‚ÉuwƒﬂÕãè¸?ïyñ+v\n⁄#v˙ıS|Ù`é¯ËE±3$JÏíÙYÏöf*v≠[ª÷ßâOÏñà=vÀã=æâƒ^nbØÔ€≈ﬁ∞bÔªhÒI“W±Ôˆﬂ‚SëDÒ©fSÒÈ©>Òô]ª≈˛Æà˝	Ω‚söÊ‚ãÏ^Ò≈°q‡‘q·≥8(Ì∞8¯G8{UDéâ¡∆Öb∞Ø¶¸á/ÜTƒP\\Ü\Z?+Üùt√:æãasnb‘féE∫%F+˜â—Gƒòi°Îº\"∆\rƒâ	Aø≈ÃM1°(&++ã…›˛b Ìy1ıƒq1Õ≤]LÀ}+¶k.ãô~õƒÏ@k1˚˜W1ÁÄòsO]ÃÎjÛ>6àÖ€æäÖºXÿ.∂øªøà≈ΩÕbâê-q-á^ÍáÊïã√∂Ò≈ë{µƒQï◊≈W»ƒWªó≈qá_â„\Z ≈	MHqRÑ•8≈“Sú⁄Y\'æ¶èßù¯øÚÇ5≈iˇéãØ\rﬂ>ﬂ≤ùßÀ[ä”zã3ˇ∑“+Œ6sg€˙â≥{~ãsFNäs˛Âäsµt≈y≤qQ∫¢∏ÿz^\\|‹[\\\\9(.ë&äK¢œâ+ﬂäù> Æb—ƒ5‰/‚g‘õ‚:çq}Õ7q˝ø5ÒÛ·BqÉßù∏…eU‹¥b/nÒä∑“ ‚∂cƒmL∞∏Ì¡qás£∏#PG‹ë øÑ¸wˇ_sΩó~â{[ƒ}Œ¶‚∑º{‚∑Wøãﬂñ≈Ô∂øCMà˚øà˚gƒCâ}‚°‘LÒ—\'‚—\"¨¯É‚!Ò™π¯„\nD¸Ÿí+˛‚:,ûË˛)û\\pOÖûõæ(û>µ$ûærV¸˝´óxflV<{&K<õ®*˛]\"˛≠&ûk}!ûkgàÁ]Éƒø“6ãJ≈+ÒÔ˙ü‚?òqÒíi©x9\'P¸Wß\\ºˆ+^œSo\\&àˇ≠8I6ÅüI‰Øúê(ÈÏì(QÜ$*VÈï/9í≠õ∏í≠ˆG$[C‰%€~‹ìlü˙ —ÿ-—ærI¢˝8W¢›wO¢cÛU¢s\"—ô…îÏ∞⁄)—ÂJÙçP};°D%1Ùx˝øaâQ5ObÙfáƒhƒSb4.1ñ—íc{%∆Bàƒ‰ùÖƒd»[bÆ˙Gb8,Ÿ5}Vba‹.ŸmâìXµÌñÿh√%6àâÕªÌ[3âÌ‚âùﬁM…^u/…ﬁ∆UâΩRb∫\\≤_˜†‰\0§KrdjF‚l}F‚¢Z$qÛHñ∏ì∏_	ëx\Z`$ûﬁﬂ%û>âÁŸ,âÁuòƒÎT∑ƒÎçë‰T⁄uâﬂ¸1âˇ19âˇ◊DI¿)Ç‰¸^…˘‘◊íﬁ›í”?%¨${ﬁKÇ\\ﬁHÇ.´H\0∆â–é?Û†ë+\'A)¸ï`2_J∞˛|	éóên%d\'	e.°Ô€.°7p%ÙnòÑ˘X∆÷ø]vå∂Ñù+aØ>ñpÏH∏rQ^º¨Ñ·õD\0\0IöD y-‘ÑID7$‚Uâ‰‰ú$dOÆÓ+âËûï\\i\rìDmïƒÈ<ïƒDH‚§G%qubI¢∫±$yG™$u~´‰⁄ã≥íÎ‚_í$7ªF%ÈìI∆ÀnI∂$SrgAMíKê‰.ìÏôî89H\næK\nÊI\nö%Ößí˚èF$˜⁄%îl$≈≤I±˜gIY+ERæéì<§£%è76I™÷IÍ\'$ı{“$ıyíÜ´0Ic¬Ic˝¢‰≈Œ%…ã‚≥í¶3O%MÁí¶ZwI”úº§Y˜≤§%#iïΩ+iS5ê¥9B%Ì~\'$/ÓK^}çìt\'VHﬁlz#È)æ\"È)Èóºùêº˚¥(pcH®\'%Éæ	í!%°d84F2áîºøh!˘‡T$˘¸gT2&|!éê|°|î|)òì|5îåª|îåã´$ìv.ío*íÔ~h…wëûdFˇ®d¶È≥dÊmódVÈèd÷˝ò‰á¡n…Àx…è≥√íüxí˘Îí_;e$øÅzí?˝Yí≈b®d	8/YJ·Iñ%á$ÀÓH÷î~I÷éVK÷Æ§J÷æÄ$kS.íû%ˇÄcRôi“M¢„RYA†Tˆ≥ÜT—˜ºTÒ•èTIÛ∂t≥u∂TÖc-UiLënﬂ„&Uﬂ«î™ˇ∫\"’‚J5Ú¨•Z∑§⁄o•:ºT˜{åT/IW™/{N™ØQ™˙ÖTˇ√¢tßõ±‘$2S∫k«Ä‘rÔ©ÂïyÈn9©’UÆtœ˛$©ı.Ä‘¶p\\jó= uòaJ˜π∑K˜ÁÃI|éë‘Ãírï:°b§Gπ£“cÆS“cŸ\rRán©õ€ÄÙxãëÙƒÈâïÌRœ“F©W˚{©∑\\ΩÙdVû‘w£Rz †JzäøGz˙∞´ÙL‡MÈπÌ∑•Á¸ÆIœó‚•Áø˚K/{K/ŸñJ/5ÔïÕJªÇ§\0{)»cJ\nB5KA“3RX∆†n~Vä‰	§»˜O•®fÅù–/E?	îbÂRlºØ˚ƒHJPtïœñíîàRíäÉîluPJ˛Q*%ˇ©ìRjj§L)s‘C “¨ì≤,√§\\∞Çî˚¯˜ÕÖ˜\0<î…*QFI¢í\"Yô©àDf!QÙ›{ÔΩGeSv	%£àÜ\n!âåHë¯ˇŒˇ≈Á</Ó9˜‹{üÁ‹ÒÊ≤s€9{≥\09_U\0∑˝ÿÄ;=ñÄ\\ÿ{@n„}@Ó‰K@ûY4 /np˜\0Xø\0(æ\0r≥¿…\0∏Ó8\0∂Û\0Ÿ–@æÛ†¶1\0L•\0kò¿ÔÒ©\0‚ü€\0“È>\0È~5ÄR1†\\\00⁄èÿqë\0nºÄ˚•¿$0\0Bd@b‰\nê\\ﬂê‡Œ\0§_\Z\0ÚÆ\"¿Ωà4¿=Ù5@·ñ\"@·›«Ä\"åPÙ®\nPÏ,îº◊înø(›„\r(Ω–(„Ôî3\r\0èJVΩäÄJMg@ÂT7†™Ú:†vΩ:‡Ò>(‡…b0‡ic	†!¨–L·^§F:Nãëˇ≈\'|@g¢\Z†ß\0Ë2E\0ﬁ;x{u\'‡-FÓ‘$†«o‡Éa‡£…N¿Gö‡SÔ3@oÿ<†üv–_≠\n®ªhkéƒ\0ÜPH¿∞Ï:`∏√0<ë¯R7q:©{”ï\0æ^˘	òÿLﬁÒL2\'S˚/¶◊ª¶π\0scJˇŸ¯πÌ‡ÁÚ‡∑J?‡˜ß+ÄÂÔß\0∑]\0¨V\0V/¯◊˝ºT∏T\"˚¸w\"i7_n8x∏·§∏’‹§^T1˜n>È‹\\3T’˙TM¸T≥ø‹¬»™_§\0’ÛfÄ[cˇ≈∑v}jujmó∑w8ÔÓp9‘É”Åz/Ä;ü\0\ZvçvÉÄFK%@„øY¿Ω˛±¿˝Á˝Å«cÅÄÒ¿/@¿É–Ì¿C†O¿√nÍ@´wΩ¿#ıßÅ÷Nm@C{‡±.–Œ®x¸®–ë‹<ct÷∆\0ùYâ¿S∏ı@w–c†GÊc‡ôc¿3üoΩ∂Ö˝Í]Åg∑∆œÍ∂˝5óÄ˛IßÅ¡˙ä¿–πM¿ÛÎ€ÅÁ±ØÄ∑\Z/6^l‹ºÿüªÈ[˝á√+äÅ·N/ëê¿»/`îS:0ÍÁo`¥€0∫•c†åÒ,∆dØnfØÜü^•kØ>ò^}Áåç∆·‹Ä	—0`\"Ó>∫c˙I‡ıÇ?¿‰)0eL[ÔLã⁄	Lﬂ’Ã(ˇÃñ\03üÏﬁƒ[o\n;ÄŸØﬁs^õoW2Äy˜≥ÄwlÄ\0P(∞l\0z÷\0A«sÅ†ËX àß∫¡COÅ‡≈E Ã˛∆r¬≠lÅ≤k@xàx»\"A\r@Tà^M‚≠ΩÅD-K Ò0HºÆ\r$b¨ÅƒgÖ@*hê:∂»äk≤¿@‡%êû‰núrmöÅ\\/)ê˜‰˘&ÄÇ√ˆ@¡áó@Ò:)P|í◊‰%¿n†tœ&†L´(;:ºoh\n|p≠\nX¸Ê+∞dó3∞§Û?KßÅ•5∆¿G∑ÏÅñâ¿jœ£¿Zıª¿⁄ìD‡co!È¶E‡”}F¿ß‚œ¿ßÕÅOøÁk{Äœ¬π¿Áœp¿f‹‡g\'`+ ¯r«u‡K<ÂìH`\'‰%∞sÂ9ı˝`W˘\Z∞kp∞˚{<∞{…¯f„∞g”I‡G«‡Á†9‡\0)¯Eø\Z¯%Ò9Àpdõ\'p‰ˆu‡ÿ÷R‡ˆ7p¨Ú-k·g‡¯ÜT‡¯÷p‡∑‘y‡788°…N| ~ﬂhú¨€ú:N=o˛XZNÔÉg˛®n^˛ú{ú?#Œ|ÄÛ˜¢Ä˙ÎÅøz‹ÄãÕ¿?!*¿ï-	¿≥ª¿5K{‡⁄ø€ Ö·Xê“˝2–_hCÔeêÚICê2‘¥…D¥…§í9⁄‹v§ä‹\0R3∫RÀ©UwÄ‘yÍ ıöxêz˚I–VﬁêÜ>§9“x\n“åÌiıR@⁄ˇA:ê>ên¢§€„	⁄°ˇ§o“˚\n⁄u`dX∫d‘œ√ò „∆Xê…˙Dê…©ﬂ ê)»‰_$hoã>»Ù¸w–æ<êYÂI–˛∑Pêy·:êEt–õ\r≤4ùYiYm˝≤z¥dµ–:öˆ\ntÙÊgêçç:»ŒGdˇ=tºK‰ 4π¢Ä‹†° ∑_gAßµAó∑Å<ØˆÉºx /ˇ\nêW∞»˚I5»Áh»w˝(ê◊\nﬁ>u\0ßÄÇ‹|AAµ\Z†‡∏˜†–7pPËr$Ë|≥Ë¸‰–ÖgÎAaªÆÄ¬–@·õãA·• Pƒ)( \r∫‚ÍäVPEˇäπö∫j∫⁄’äçñÅ˛˛\0%™‘Ä7ÀAI÷W@)0P µ˚†‹%Pä`îÚ\n\0J=z\rtcˆ,(˝ì3(£Â1(£/\Zî…â›|Â8oÂ\\Ú›YÙÂô-Ç\0◊Y ¿s+–jË°>ΩÇgA∞«@∞èº¶Ñ¨5aéùaçÚ@ÿÇ^n¸/àr@Dµ‹¢ñ˙Çh]AÃa\0à]‚0I ˛sü∆ÒCABµaê(#$˙ˆ$6P\0…6s@r¢îﬂS\r*(oV:Ç\nA≈ß∑ÇJÈë†2D®º™\ZÙ¢5ËaÚK–#`?®˙ƒOPmÿ)P-O‘à‹\rz∂ØÙÏ|®‡z°\nz!ØΩ([j_+u¸nΩ∑2ıD·@œYÅz∏†æˆPø‡Ësnh‡4êó˙≤ˇ<hd/\n4∫\Z-˛˙j{Ù\rı4Ò0h¢˛(h¢54˘¬4Âl˙±}4}Ôh∆•4{:\04\'∫˙=”˙√Œ˝µüØÀ1Ø#ûØ¸VM	V}∫º≈Ù X3»¨ô¥¨≠T\r÷ÒÎ$»¡:∑ç¡€å[¡€[Ç∑}[\0o/\n\0Î ¿>`É˛∞◊l|¥l∏º˚\Z\Zº˚∂º˚Óû+O¿{f¸¡&\nA‡˝øƒ`ãìã`ãq{Å+—‡√ﬁ˜¿VwÏ¡÷/`[√n∞m˛ÿ∂Áÿ.¶||√=q¿âgB∞√ïB∞CÏ81\0>iH;mÄO	a`◊‹`7‹[∞{Ï2ÿ√Ò;ÿ„π2¯Ãç≠`ØºX∞◊ÿÁRÿ◊5ÏK*˚> Çœ∫Å˝ÔÃÇ˝\'˝¿AY≠‡  ^p–h\n8‰}	84oÊó/UGz\0¡ó›œÇ£¸ÄcN◊Äcé‡Xo*8éúéﬂF\'Zˇ\0\'π~_kfÅìó>ÉSù¿ißd‡4∫¯QæÒCú~Î\n8£J|Û˙8˚¯?Ìîm‡\\‰,8∑π|w~+.VB¿†08È^Cg¿–|∫\nÜÆÄQGˆÇQ÷3`‘}F◊;É±sØ¿¯©0·Z,ò‰í&[∫Å…˝˘`äg\Zò¬¸¶Í2¿¥≤´`˙Ÿ=`:®\ZÃÿ™Êòﬁ\0sÃ≠¿‹Ì`˛ûˇ∞∏`AXÍi\0ñ-%ÉÂjn‡{≠ˇ¿˜üÆÁ[<nH:l—¡e©—‡≤[¿Â*„‡áy‡G_<¿äTpÖh\0\\|\\ÂHW«∂Ç´ß!‡«8¯i$¸Tæ\0n≤xn: \0?ŸÅõ≠èÄõ°`p3≥\0‹˙T‹˙\rnÀk\0øîﬂøRQ\0w<åwÃ@¡ùZª¿ù:A‡◊I¡o5ÓÄ?xâ¡‡[¡Å·‡O ë‡>x\n∏OÓWX˜´Ω\\∫∏π<ÿz≥¸Â¸xd3<¢-è`m¡£õÊ¡£».ÿkx\\Cûà_Or.É\'_˜ÉlO˜zÉgÁ¿≥É¡≥·π‡Y—9œxÌûØ:˛•ˆ¸ã€˛ïè/∆iÄﬂÄÄó◊ö¡âü!ÎﬁèBL$EÖyà\"ª¢X≈É¨?ŸŸ0i	Q∂¸ŸúâÇlÆ‹QcMC∂É®õ}Ñ®\'/A‘≈`»÷wçãıÕ;˙M±2Dªı;D«±¢Àº—[?—3®ÖË<—w…ÑË«˜C“u ÜªV {∂ÆÉÏÈÜALú‹ {øCLÔ-Bˆm?	1GC,^æÇ˙±‹\0ÅXˆGAœ∏C¨6á=9Z=±nQÅÿ$)AlC- ∂Çà}Í‰x⁄»âGg!Œ˜j!n{˜–\Zà{=ƒ#|\0‚Å´Åú±CŒtáAŒLtBºl˝ ^®Ôí\"àFÒa©@|3å!˛ïH¿õ\\H‡^2$êÂ	 )Ü\\2éÉ\\JC.˝àáDÙI!ë_k óÕ?CÆÑ¥@¢;-!qkFêÑ®0H¬ïêÑk∫ê§%9‰Zˆz»µäy»uÉq»uHZ’6»ç !‰ﬂ\ní	•C2r 7è„!Y’ Y3æêÏä≠ê‹qHNk8‰v´‰v?rg;\ní´˝íÎ·…-y…€¶…Cøá\0N@Ä£µê	àÖ@êù»`⁄≤ˇlA;øÜ`eÏÔs¸ﬁ!xÙCà#ÒÁ(ÑTl!7@®\nK™A,Ñ˙L°yÂAhëß t≈!„¯OÉr¬j~	aﬂAÿ	õ·»ŒA8£ º*D¿^Ñà¥f \"ß\Zà42\"˝˚\"3º	ëøøπy∞Ç‰«# ˘=«!ED1§ÿ„§dRö∂RfyÚ»Xyƒ6Ç‘lÄ‘º˛©µ˜Ñ‘“#!µ\r>ê⁄	\n§ÆÕÚ∏ΩÚƒiºx\n“îV	yéRÄº∞Iá¥ËXAZW!≠œˇ@Z;Ô@^Ì\'A^â{ ]“HW/ÚæÚ.ÈanÑ|jSÄ|˙ó	È’£@z}4 ΩOA˙å!ê>ü\\H_“˜∞“ˇπ2–U	⁄˘2‘ëNoÉ|9/ÜL\n=!ìﬂì ?¥: ?B.@f~ÍCÊöù s´\"»OﬂMêü≥Mêy[m»¸Í\"‰πÚ;y/‰w˝m»ü·ìê•úêÂıÈêøâqêø?r ˇ¢„!´>dÕÔ\nTq›/Ë˙JuËFŸTÖPU[áÅ™≠OÄ™·y–-ô°ÍG@’kc†öâª°⁄\ZŸPm-$Tªõ’£A∑ÌQÄn˜™ÎÒ∫„ó1T_Â\"tßitÁõ´–]∞H®Ab	‘5Ÿ59ÑöpwB˜Ü∫AM<†¶ÿËæ£˝–˝÷®Ö≈9®-j—çÑ8~zÃ=Ë!◊Ë!øË°Ù∞=jEpÇZ—s†Gl–£ª¡PÎá-PÎoãPÎﬂP≥dË±üiP;ã7P;⁄ ‘~Ω7‘aó‘!,	Íê“	uΩÅ:U¸Ü:o>u÷∫u=º\nuçvÅ∫∆ªC]ãÌ†ßÕœAO˙u€auˇ®ıËÜzn|ıT#Bœ∞î°ﬁ±\'°æ„Pø¥CP?.ÍWÇ˙;õ@dn–êΩ%–s⁄=–s¶è†ÁØC√¥∑@√A/]JÑ^˛Øø(¬Ù™ÁwhÁ-4!öMÚπM˙~z]ÛÙz4ö¢?Mı.Ç¶~rÅ¶∂Co¯j@3R¥†ôË[–õ\'b†Y[j°∑.ˇÖﬁ ˛ÕyøΩΩ;8πiAA–˝Pp\nIjÜ¬ˆ∏Aaˇ≠¬ŒälÇb›†¯ç+PBÂ(Ÿ•Ïø•‚Z°‘∑:PÍ¥.î3Å2\\Ç≤∂úÖ≤tã°¨?@(ßéÂåﬂÄr˜É†<„›PI*‘´É\nr®Ë¸O®x*\r*Q*áJnhA•oiP9¶zèÚöˇ.¥»¥Z\Z‚-}m\r}∏±˙˘Z·µ≠“C´2hUç¥Z+	Z£≠=±≠Â`†u∆˛–«àFË„5Ù…ñ◊–\'’Û–\'üÑ–˙é&Ë”sÅ–Fm¥—B\0m\\Ü>Év@üØŸ@[¥|˛€ZÚ†-· –Vy\r¥µ4⁄:Ω⁄∫≤⁄ˆ4⁄÷\rmˇ=}9Â}µ}ÙïXÌ8ﬂ\r}g«áˆƒ_ÇˆdÌÄ~ÚÖ~jˇ\nÌΩ™à{\r<≤:§°b‹Çcú†√ow@Gç†#‘qËà‹:\Zh\r6Çé.à°ceËX	˙5Ï1tb:y\rùñXBgbˇBÁû¸ÉŒ\r˙BázB˜ÁCØe@óf=°+ÏËZ]t≠c¶‡µ¶t¶¶‰•[Ø[Øw∂°Úlcûl#s∂iÔ\'òJ∆^ÿÊ∂C∞Õ+—0’ÕŸ0µm/`jœò0µÊqÿñd0lK)∂ÂÒL=U¶N¯	”πì”UòÇÌê?ÜÌ(˝€1>3∞+áîâa{∂mÉÌ!a&é\n0”€™∞}sﬁ0Û◊aÊG)0Û§6ò˘5÷ÍaÊô∞ÉÏ`Ô,Ï–,vh%vX≥b‹áY\'ûÄs0ÑŸ…Ùaˆ7ra\'é÷¡◊;¿SíaNﬁoaß.`Æ˚^¬Œ$¿Œ|ÄyˇçÄ˘¡^¿”aAôs∞†¬ﬂ∞`x=ÏßZ5;∑vA°ﬁ4ã¬\"k\'a—Ç˚∞òMó`16∞´†X¨û,é¨ã+≥Ö≈UÉ`q≥XX¸ÌyX¸¸CX¸≤ñ(#¿í¥W`Iß$∞§n ,’ ñﬁÀYÉe‘√a7e ∞¨çÊ∞¨\n∞¨4,;Bñ≥ßñ˚≠\r†Y¡ gˇ¬‡øú`G-ÇGÜ!¶“a®œ.0‘˜<˙ÖgÎ√e*√˘ÁaÑÔa0¬?%	ÛFVqÜëìn¿»9Îa‰˙9%≠F€Ícl˚c÷¡‹\Z£W∆§j¬XÁÙ`Ïƒ{0ˆws◊∏\r∆≈ª¡xÀ0æFåØcî†`Çﬁs0¡r/L®u&öÚÉIF00iuL∂ÓLÊãÜ…øøÑ›S^Ü›◊KÑÂøÜÂ;}Çÿá√\nüÑ¿ ÊFa≠Ìaèä∞\n7eX’ß∞\Z„.X]˙Ï1´\0÷±\r÷ãÅ5ÂN¬ö Rÿ3ªnÿss¨Ÿ~¨˘6÷<¿ÇΩT€	{io{y/÷1Ù÷Ω˚ Ï\r{7ÏΩ#ˆ>Ÿ÷SèÖ}®~˚ËŸ\n˚§Î≥,á}ﬁæ˚ús6|ÁlT˝\'lÏ_8l|ÀOÿƒl2∑6ï7\0˚!Ç¬¶wˆ√f\\Ω`3–jÿÏÇlNŸˆs∞\r∂`Ñ˝zq\Z∂xV\rˆ€0ˆ˚›iÿﬂ;ï∞ïOÿøÿZyl≠°æŒXæŒwÆî_?∑WﬁlﬂD›ﬂr·\\s\n◊\\õÅk9	◊5+ÉÎÜ[√wúäÅÎ˚ﬁÖÔº¸\nn‡í74¡ç6$¡ç<·ªÏ‡ªÉl·{¡˜é\\Üõ*‰¿˜≈lÇÔkÑõ=?7Îø\r7«S·ﬁX¬Ã¿r”·áÌﬂ¿«_ÑÓÃÇ~Ì∑≤=∑öÿ?≤Ò‹Z¨∑±∫?VË∑k∑‡ˆ·ˆ≥pGè|∏”ˆ∏S◊9∏{Ë‹Ω∑ÓvÓ‚˜¶nÅ˚ÏÑ¡}éùÉ˚dN¿œæ´Çå‡Å:w·Aô/<Ùà¸B1~ëïøX2\0øÿ˛v˛\r<,⁄	æ·<Í@&¸ Ç¸jÂ	x¬a¯µ£w‡…z?‡)À%4<ÕoûﬁÀÖgæ€øâuág˘^ÖﬂÚæ\0œfK‡Ÿ˜¢‡∑sZ‡πwxÓΩ+<‡c¯›—T8Ä∏¶Á¿¡õ/√¡øO¡a!ø‡à› 8Úc˘πééî√—˚‡ª$8v˜óø«GﬂÉ„±p¸ª8ÒªN:ÖáìxFp“\0N±jÄ3˙M‡º02\\&ÜÁp·Ø∏9\0óÿÖ¬Â◊√Â,c∏\\‘kûØœg¡ll·\Z‡≈9‚≈ãv:º‰Wºú˚^yÂºZt^„æ˛8˜!º^—˛ÙﬁDXÇ7ﬂ¯19\no9Ü∑‹¬€\Zí‡ÌfØ·/Wá·]Âü·›O¿ﬂ8°·o ä‡oæ˙¬ﬂﬁ √ﬂâ*·ÔöÛ‡=õ‡˜ß¡? ,·Ωu.æ<|®È(|ÿÅë¡G~^Åè~ÏÑèΩ⁄ˇ˙˘>|¸˜\Z¸˚·v¯‰>*|ÚƒI¯T±\'|Z˜|f8>≥z>{p>ZÅˇ‘ﬁˇπÕæ–ˇ˛Àˆ ¸˜’p¯üˇÍjyéXwt°£ÉP‘PG(:ˇF(˚Î/Ë!÷ﬂqBl∏hÉÿKA®¢n\"‘0ÎÍíÍ\Zl\'Ñ&œ°˘1°£äBl{–Éÿlèÿﬁ|°ã©@ËôL!Ù¬¢z·ó˙äΩàùõø!vπ|BÏí˙!v5‘#ú•É™XÑ°ınÑqØ=¬xB±\'™\0±áÖ0πâCÏ≠|ä0µ≥AòΩ∫ÖÿèΩç0_~à∞p!»∂ ,mHà√jIà√ZQà#èO é’#é6W#¨èDXÉÕ÷DmƒâÛØëÔÿ\r«Áõ\'KÑ\'üiÑÛÒ)ÑÎ)gÑkN\n‚t;·y’q∆ä8BxÈÛæÑoÒvÑÔo‚¨Î#Ñˇ∂màÄï*D‡a.\"ËIDê’uDP—DpX\"D#q.æ™√@ÑÊBÑNÈ .ToE\\ºÃD\\îBa^Óà0å\0Vææâé?®Ñ∏ÙäàÛBƒúàCƒƒX#ÆûCƒÓIEƒE‰ ‚ÚÒÁâf¶àDÔ.D‚ÿiDe\nq›ß\Zëºgë≤%ëñüçHÁ#“·à◊qDFêëqÓ\n\"≥L\rq”¯=‚&√ëÂø\rëu7qÀË<\"ÁëÎ¡F‰Y_B‰·Õy#EàªwS\Zwπ)`|xÀ≠GÄf#¿◊UPÂ´¯n6q*Å:tÅ?E\Z¨D˘_E8Ü†Ú·ö¬~m◊]¡<\\Ü`2Ø#Xß‹¨»øNÁ?Én9ÉQ‚7¶©ö\ZBöHFHKø!‰û*à{¬˜K:‰∫“Ö˛IàBà¢g.¢ËÒD—\ZQmÑ(~=ç(h#J~Ü!J!pDYú&¢<°\0Q^ÑxXp\nQy™Òò®àx\\vÒ¯áÒ‰ÖÒdrÒTy—x†\r—Xı—ÿHG4~ãE4Â#ö~; ûe†œàôàf¨¢’|/¢Ìx¢ÔäË0m@tl@tﬂ©Et„%à∑gÙoI:à∑´€=˚Ô!zJ√=ã0ƒƒá»˝àO‰àæ{0ƒgﬂ/àÅµeƒP1åYBø@å(‡£+)àØâ´àq≥ƒ∏Õ/ƒxùÒ›èòö⁄è¯1ØÉò=œEÃ>≠AÃ]ÙGÃGu#ÊÎ>!~Mª#~;á\"ñ‘\røBˇÏˇ¬%à’øk_kó¶êÎõA»ıˇÙêNúC*ØKAn<©⁄’ÜT”E™Mç ∑@œ\"’UöëÍ´°»≠ä«ê⁄ëˇÈ{Ü‘1‹å‘ùDÓ⁄ã4LXá4å!çk#˜,@ê&t,“§EÜ‹ªïÄ4’>é4o=å<î=ä<¢!èDÏD’–AZ´Kê6MµHªásH˚«≠»„-§É–\0È‘Èº%È™ëÇ<≠ÏÖÙ‹XÇ<Û\'ÈÂB@z˘ò!Ω˛.#Ω€bêæ˚lëæl§ÔRÚ¨2∞Ò2 ÅÄòÄ!C£êÅ42»™‰˘µZ¸y~¬\ny1ÓÚbV12Ï„F‰•+·»K∑»ÖdƒÏcd~≈g!Ø_ Ø,9 czùêqs,d¬√»ƒ‚Td“yÚ⁄€]»Î†3»dÙd t62ug,25ãLª9éL+˘Äº!˝Ñº—Gfæ√#o\Z´\"≥éØGf5^EﬁN2AﬁŸCÊﬁvGÊ≠ó\"Y◊ê@FÜtD¬ò˚ê0…c$‹3âÿπäDv ÉáëHª)$2Àâf\\C‚‹’ê¯¢5$·tí–ﬂÉ$ïrë‰[ëîΩ€ë‘kÌH⁄û$-Ó2íûcÜd‘å#Ÿ9Øêúo-H^Êí\'\rFÚïlëÇcP§‡f=R0y)‰>Aäø!Ep4RÑªÄó˙œ§¯Ÿ\"R‹+FJ_B ©!eI±H/)ˇdáºíÖ|p|˘ÄxY∞Ô ≤‡T≤\03Ñ,h@!Vi»¬»xdQîYµYÃhEñh˙ ÀvN À\"˙êèrÙëïYëUIóëUø#´Ÿ»Í¯€»j`≤∫YÁbã¨c∆#„ﬁ#Îè–ê\rcRd”U&ÚY‰-‰≥ÿN‰Ûüêœ]∆êœAÜ»ñ”\r»∂õ3»vc)≤}ÓÚ%‘˘\níÅÏ8Ú˘ZgÚ5•Ÿ≈yàÏzÜEv+Bêo´êo€˜#ﬂ,#ﬂ˝WÛÔ±ˇêÔø‘!{Ó!êü»?êΩÁGê}Øêø6\"áØnB~”ÛG~;=ãúX‹èú€OF˛l& Ága»≈ÁQ»?-u»•}z»•?‰rñr˘ûÚØÆ\'Úoû*rmƒ•¥p•KF©¥å¢TMO°TèL¢Tœ5¢∂¬&Q[«`(çÕı(Õ˚GQZ{!(≠7j®Ì∆Í®Ì=6(›Ã‘é∆”(˝⁄ã®ù5QÜéû(£Û(„ñ›®=!üQ{∑P{˝«Q{á¨P˚N‘†ˆ¡(3Œ‘~{j?\ZÑ⁄?∂e·ı\Zu∞Ó\0Í‡{MîÂu\'î’¯Iî’Øc®#]®£së(kã◊(ÎãXîMÒ‘±|î≠‰/ ∂a+ ﬁ;u|„ÍDKÍdœ8 π¸ÍÌ Âd- e‡\0 ^ÄrÏDπáÊ£‹pPûF;Q^“Vîœ∫e‘Ÿ-E®≥K€P˛Í\\T@›T‡>KT–5TPÓ8*ÿ‰*ÿ‚	*Ù4∫™å:øÌ\nÍBG,*lvuIÅä<˙u%\0ç∫\"¬†bºÜPW3mPÒ˚w†‚F≈?«°zË®$ﬂ´®§©0‘uù«®‰k9®·WP7˘†“_(¢2L›QôØ£2«\\QŸÔ‰®˘ÍŒ˘X‘ùDK‘ù‘˜®‹_ï®ºm êjÄ˚†@Ö\n(pÙMxÇÄÇ÷øEA_ºD¡”Ø¢êÜ÷(‰õõ(‘°z\Z;É¬JÆ¢(ä( ê\0E5ØD1zx(6¨≈1(@qáQº‡7(æ°äO◊E	è≠C	JQ\"Í$J¨˘%È{Ñí&ÀQ“ÓÎ(iø%JÆ[Ö∫Á @›ª‘å∫§Ñz@/BŒj¢äØ:£J÷ﬂ@ïÿ&£J7£ (®≤âù®á“\"‘£Á÷®J´TÂ˝2TÂt0™⁄>UùPÄ™n\n@’l˛åzºÊàz\".C’_î°Í„P\rhT„ùu®∆ÇxTc°)™yÒÍ≈™•Í\0™-®’∂¸’Ä£^>À@u∏N†:ûé£:√ﬂ†^{ΩCΩæÍãÍ⁄‹àÍzˆıÊnÍÌà\ZÍÉg/Í„˚#®èùPüœQ}.¢˙ÜD®≈$‘‡V9Íç\ZM[Aç?@M\0Ø¢&›≠Qì¥®©ìQ®©G\"‘T◊‘åﬁ]‘O∑u®y“n‘¬Ú‘/Â=®_y2‘Ô∫.‘í„\"j˘∞ıw˚>‘_ÙÍ/±µ≤)µ≤fÇZ[pE+Ω\\èV˙„çﬁ®vΩ©UΩiı+zÛôIÙñz,Z›H	≠Ó\\ÉVod£5Ú\'—\Z≠hM.Z≥…≠˘á÷éBkC˛†µÀ—€b\0h›œ€–;ÿÙé9+¥^≠GÔL—EÔRÆGƒß†\rﬁæB¶8°ç<&—F… Ë›∞rÙû*⁄4—Ω/1\rΩo≠m&øèﬁü2à>h±múÖ∂zﬁã∂Ó~ã>ÊFE˚&C;π¢éâ—\'áç—\'\'F–NñQËSQôhóKhW˚ÁË”±R¥õB?⁄˝J9⁄#É>ì∑äˆ™\ZB{ó⁄£}¬ï—æF.hø¥_E˙¨E⁄;\nê~8¸$˙ãi™Dü[⁄â›;Ç]>Äæ`G_à¢/ƒ.£/,á£/˙®£/f[†√Ç˚–·6˝ËK&ËKtƒ¨˙≤?}9≤}º}y©\0%øÉéV¢cÓ†ØÍ_F_-ˇÄéMyÇé]˛ÖéS…D«ﬂA£º¢Mæ£Ø]i@\';ã–…—G—…◊ËîﬂéË‘’∑Ë4ˇZtZE4:mÙ˙∆ù±ôèŒ8\ZÜŒÑ}Fﬂt*Aﬂ§/£o>É£oùÿÇŒ˛äAÁlﬁÅmG-2–@K\Z‘úéß◊¢¡‹D4§ø\rıD√y˚–¡ìh‰ïÛh‰Ìb4*ñÖF’ó£—á£1«˛°1çh¨›I4ÆYçÁûGì†…∆öh\nß\nMyÊÇ¶√ª–,Ê{4Î°Õ°Ÿ–\"4GÂös±ÕπÏÑÊΩSCÛ∑mG˜°≈\'´—‚R¥xƒ-©*CK∑•†•/Ë{í–ÖÒ<t±]Ç”Cóm\0¢À–cËÚM€–Â{≥–ÂfsËG˚Ã—◊¨—’‘≠ËÍ\rtMŒ&tm]˜Ä~¢˜]‹én‘ˇœ›Ñî°ü%æG?ªÊé~vg\0˝¨j›,UA7€ç~a≥	˝¬Ó!∫jènE,£€æ˘°;C –ØEûËn•{Ë7ùó—oµ&—ÔìÈËû˚ËêÀËﬁËtˇÒAÙ@ó+z\Z=T˙˝es˙ÀÓÙ˜ z‘∞	˝ı™1z\\Ø=Ó5à˛ñƒBè≠EOö|@O˛¥BOÆ˝COˇ1FœXüEœºT@œ∆;¢Áé>Aˇ‹?Ä^8‘é^LE/DF¢Í?°i,¢»—ø/r–Kûß—Àè–+ÃåB´F·G6FIı)fΩi+fc€f„H>f[äQü¿®1Œa‘]Ç1[€∫1[ªÔ`4Ìµ0Z«£0⁄ØM1:3$åÆfGcå^®5F√fÁÊÃÆ*ÃÆõÊò]Ão„k”µxÃ>’5åYE+∆\\1s@–Ö±Âc_>ã±j⁄â9ÇÛ√Èû≈X≥…k©;∆¶Yc{æc{cg2á±_˘Ä9˛¥„†∞„@“¿úLı≈ú:∫„:êçqΩèqªåqœÅb<vÊ`<¸V0Á 0g¶∑cºÊb|û9`|ˇ`¸1˛H_L¿P.&P √~»√7ƒ:`Ç7+cB‘ØaBﬁ‰cŒÈm≈Ñ2hòÛ\ZôòÅmò∞ébLÿå1ÊRm(&B©s≈˝\n&z˚2&v≤Wµì∏~&Ò”Lí°&πˆ&≈˛&ır&5èI3zâIç¡§õób2Ù_c2’Nb2ù0ô•á1∑ê\0L∂6ì¸äÏ¬ÄÌu1êÒ˝»ﬂ@å|)«¿+|0àêHr˝I≤?Éuƒ`+ﬁb‹ﬂØ\0CΩ≈Po’ahÈz…)„˜ì.ƒ∞\ru0lÆ3Ü›q√5p«0B¶6FL+¬H‚f0“¡Eål◊1ÃΩÏ;ò˚+…ò◊Æ`0ª1*òÇ\'LI∫%¶¥¶Ã.SÆòèy¥∆Tú	¬T›±¬TÔ±¡Tw¥cjÂò:ÎÃSœòßIòÊ3◊1ÕUPÃãÌSòV”Lk˚UL;rÛíÙÛJŸ\rÛÍ›#LG©¶s%”Â°ÉÈz^åÈNŸÄÈ.¿º©Ï√ºÎæçy7ﬂãÈyıÛ±°ÛÒ´¶∑Ì¶o)”è°b˙Ÿùò˛¬MòœC9ò°keò/â0#;˙0£s©òØ∏\0Ã7Qf‚*3ÒúÉ˘÷Ü˘˛Î$fjÉ3u%3≈!a~qòÈ´|ÃÃEgÃÏ9%Ã‹ò.Êßv:ÊÁÌ∑òü≤kò˘ı¡òynf^¡,ΩÉ˘•>Ü˘eIƒ,∆Oc˛úò√,\ra˛\Zc0≥1+Gl0ˇ¢!òˇî0kSÎ±Î§G∞\nØ±ä«waCj±äøûaïXÔ±Î=∆∞Îa ÿ\r]7±ñå±*˚Ù∞õ]ﬁcUÕ∞™\0K¨j≠vÀÁ¨vÃ6¨vˆ4V«‡Vá\rª-Ìv{„7¨Æ5´Õ¬ÍˆÖcuø≈ÍÂ¸¡Í¡º±;ˆbwy∆`wµﬁ√\Z<\n∆\Zj¨`w«±{>~ƒöÑÎ`M>∑c˜.Ω«Ó˚æk¶Ôè5{ªÄ5Îﬂà5ˇ\\É=tÚˆ…kôÎÄµ∫Ò{Ù›4÷ñ≈≈⁄ﬂ√⁄>›ÉµK∆⁄oHƒØl√ü’∆ûü¡ûHH√ûX)ƒ:Ñô`¿ΩX«ÿT¨#AÑu6v∆∫åèb›ŒÑ`›7(b=\rwcΩzö±æ€™±æ?Äÿ≥NÅÿ≥ÿ≥E0¨ˇ±6lPŒlPõ=6x•öÉ\rùac/Ãc/Ü$`√6b√Fª∞aÛ√ÿHò*6rﬁ{y]8ˆr‰ylî…zl∂]◊ççnû«∆f∞±¥_ÿ$[l˘)6iÆ{Ìº769$õ¸˛\"6ÕC{#Ù&6C.¿fZ˛¡f˙º≈ﬁ¸hÑÕ\ZÿåΩï\0«ﬁ˙p{€Í67•õÀ\\√D:X†˘{,–éÉ’{c![V±…`,bÂ7i#¬¢?˛ƒ¢Æa±w%X\\¬a,xKo≈õ\"∞d;,ùßã•w€`ƒ6,„Yñi£áÂ‘˜`y⁄\ZXæÁW¨XVx›+¸ÜïúYèï©Ô∆ Òäÿ˚ªÆbÔ?®«>P_∆>Yá-;êä-[s¡ñ€ecfLbµÔ∆>zSá≠TL¡VÍ.c´2ﬂa´÷ÿj´çÿö™”ÿ∫çbl]n∂{[áªâ≠{ÌÄ≠õ¸ä}¸Ëˆ…ª+ÿ˙¸ÿ∆3±ç1tl”°\0lìøˆUà}6™˚ﬂjÇ∞ÕEÎ±-©LlK…lKÀ\n∂\rﬁÉÌÃ‹Ñ}≠Ìâ}∑ª˚ûÓá˝∞?˚Qïé˝(ò∆ˆn-≈ˆ›)∆ˆ}«~ÊGacG±√˙JÿëÔÁ±£˚/¸ˇ€“—ø&ÿ±s<ÏXî-v\nfÅ˝±c\'v&…\0;üˆªP7â˝ºÖ˝ïc◊)aóñ≥±À{“±€û`ˇæÕ«˛Ì≈b◊ä≠p\n–úBßxn√”)ú≤qn„»Kúäh	ß∫åS]ç≈©mD·‘˜®·‘OÚqÍ^Ÿ8çÀe8ÕSï8ÕoøpZSqZü·tÚø‚∂ı’„Ù∂õ„Ùåöq˙æQ∏]±,úÅ¡vúÅG6ŒÊå3÷ù√ˆ„åoÊ‚v;Ó∆Ì)òƒÌ=ëÑ€€›ä3M:â€ßeÇ€œ˙Ü37zç3è>å;hˇw=Ç;d>à;‰3ã;œ√.Ωá;¬g‚éÓ∞∆=Ùw‘=\nw4´gÕ∏Ñ≥Ÿ`å≥i≥¬Ÿ>yä≥˝√Ÿ≠_á≥Àß„émƒ◊«9&v·g5qN‚F‹©G8◊i=‹È}Ôpß„Rpn∫È8wß%ú{^,Œ3‘wÊˆAúWU7ŒÎ˜ŒØ˝Ó¨‚ú?øpÓ2.∞f.»˜Ó\\•%Ó¸=ÓÇˆ1‹Ev8.ÏY!.º§˛ã_Ÿäª‘æwµÂãªíˇ˝ ˝lC»¡≈ˇ¿%»sp	ØtqI˜Æ‚ÆëFp◊Òp◊ü q…∆˜q)jﬁ∏‘∫√∏¥+i∏Ã∆∏õgöqY∏[{ﬁ„≤ˇî·rJ\Zpπø7‚ÚV‡\0¡Ö8PÇ©¿!z3pH’Xr˜6 ˛$=SÑ√?„∞å`.ÊWoá√üºá#ún≈¢}pÑØŒ8¢¶éÿûÅ#Ó¬ë>d‡»¥\ZÕœG*¿qé„8Dßß«Køå„√±8¡]ú–˚N(1ƒâuÖ8Òïw8ôHàì€pdÆ∏¬X.Æ8ÉÑ+q¡ï∆œ‡Jø\r„S¬U4k·*ı‚*üN„™µh∏ö®\\çÙ*ÆvÎ*Æñ∆’˛c‚Í4pèáÜpO˛⁄‚Í˜[‡ÍoÆ‚û˙}ƒ=M¿·û˛Ωékãƒ=;u˜ÇÔÜkπ’ÑkôÙ¬µ™Ï¿µ}Ó≈µœÅp/]jqØ*n‚:ÆÑ‡^Wå‚^ˇyÇÎ2S√u˘9„ﬁÈd‡ﬁ?ö«}®è√}‹ÆÇÎ5|ÇÎ-zâÎ£&·˙‹g‘o‹`+7`Ä&;‚æ§äp#:0‹òl7ÓÎê+Ó[í?n¢Öõ¢¡˝xq˜c–7]´Åõ~v73çõ)T≈ÕÜu‚Ê?\'·*Rqøˆëqø‹™pø~Ù„˝qø«∏∏?\Zópƒé∏?ÀOqﬂi„Vı‡˛˝WÀk˘x≈—\rx•/º≤ìØúèﬂ»Iƒ´ºÜ·U7^√´>l¡o˘„ÉWŸÉﬂö}øïΩä◊êº√k,≈k˙„µ6˝«‰^€RØ\r˙Ü◊9Ñ√Îÿ«„u‹ºÒ:)VxùL^ßÍ^∑◊ø„ù\n~ÁësxCΩ<º·ıáx√éhºëoú÷ç7f=√ÔykÑ7	¯Ä7π¢Ç7iºÅ7•f‚Mk¯x”ß’x3Ïﬁå¡õ◊è„˛··Ω≥¬[^≥ƒ[¶qÒñÄR¸aÎx+ÕGx€M¡x€6Wº=íÖ?ﬁ:äw0Ò∆;D„a€Ò\'èY‚O⁄U‚O^„ùvàNã`ºÛ;%¸©¿¸)§!ﬁ≈&Ô⁄„Üw´/≈{˝Hƒ{õ¨·}≥‚˝û1~_?‡AAî¯ \Z\\D√7}¿∑9·Éº«áO‚/Æ‹¡ákË‚√µN·√C\ZÒóŒ¡ó¬ZE¯H≠=¯Hk|‰·	|Tü7˛JS4˛Jª\r/√«D+‚Ø∫l≈_}¿«\"„„õUÒ	wFÒ	3≠¯§€ó◊’ø·Sµx¯Ã¯Ã,w|¶®	¯K˚>[´üm•ãœŒ\Z¿Á¨ˇçœ©„oﬁ∆ﬂÜ∑‡Ô\\ÿàœ›]äœ=\Záœ3æâœÛÆ≈Á=πéø¥˜µ∏˚4©«ÉN,‡°µ˙xÿy\næÁÓO√#N„ÎxîÂC<:‰\0´sèõ`‡Òπ«ÒÑ0û¿OXﬁÇ\'FÂ„IÃﬂxR…8û¶7Åß˜⁄·≈<cËûŸ˝œﬁœéú¿Û7Ÿ„Ö.^X<åó¸{âó2˜·•.xÈÑ*^Ü\"‚Âk¸}‰.|e_o3æt˝|yy4˛aÌ!¸£4\"æ¬j_q„5æ2Õ_πv_Î˛ˇ∏!ˇ‰ˇ4≥\0ﬂpÈ\'æÈùˇluˇ\\˘\ZæY/\0ˇ‚Ú3|€õq|˚∞?˛UÆ\ræ{˜G¸Ê¸õ˚oÒÔç=ŒÊ¯O·◊ü™¯¯ﬁΩ-¯œyÁüÁ„áé—ÒCnÒ¯°E{¸àÚ¸XÊ ~L˛ˇït?n\rˇ\r∏?—jÉü,∫Ñü\n(¬Oïñ‡ú∂≈œ ~‚gDﬂ≥oBst	~aá˛óì7˛◊›O¯EJ	˛∑ü6~…ÿøÙYå_’¿„WO<¬Ø^U∆ØŸÑ‡◊¸9Eö∞˛p6a˝õv¬˙©6¬&k!a<Ä∞©‚AµñNPG‘B˛4ÆÖ4 óZ«C	ZIö≠\'›Ñm›¬ˆß(¬;Ç^˘1Ç^ÕSÇ˛æJÇ·ŒU¬ò∞ß6î`\"v$ÏÂˆ	¶ˆùΩL0˚…\'XÏï,Œ= X¿+¸Á∑	ìÓ>øG8d3I8l&\"~\'^~D8\"¶é»j	6Á:	«T„∂6$Ç˝‹y¬	c	¡Å¸üÁ#\'º¡ÖØIpôú\'∏ﬁu#∏Îè‹ˇï<ŒBûÈQØß.®/¡ñI-È!¯ôØßŸBPô!òÿJ~~á‹üA}öG∏0„Fì·Â@B‰õªÑÀ;+	Wˆµ¢õ+	±ﬁ|B,Nà=#ƒ˘1qè.‚⁄∑*Ãâ£ü◊¥ö	…L!YÆ@H°∏R€üR?“Ï”4.!´~+·ñ¬BŒéaBéÿãêÛæÉê”ﬂF∏≠ÿ@»›L∏Îıù\0‰\0„‡ïBp¶ò\0¬N¿DòÛÅ\0„PÕÛtàÄ”â&‡©hÅ.#>V»Z!≤I W´(†QeBù@;ˆÄ@+ªK†¶Ë_ÙŸWÜˆ\nÅi¥ï¿2√ÿ}∂^Ò-ØƒÖ »é\"HÙxizAZúK∏∑îD(à»#vrEn.Ñ‚çNÑ‚;BiÈ?BÈÁªÑ2ΩuÑr»V¬C#9·!öP¡ä$Tvï#rBıπˇDË™üﬂ TO>\'‘êu‹Ñ∫y,·ââ·IA\0·Iï/·…p°°3áú\"!¥0-óm˘€	Ì ÍÑWˇÕˇ’ØjBáŒ,°S·+·ır2·Õd2·Ìô^¬€ÊDBèü°üJHW!Ê8æ¿ÆæoFÃ¶	#w£9alw\n·Îœ”ÑÒÃ◊ÑièÑÈß˙Ñ<aÜ«%¸bGÈ£Ñ?˘>Ñe¿·_\'î∞6ÛÄ®¿–&*˝c◊“âüóU¨+â*ù*D5«›D5è^¢\Z¶è∏eíETﬂüDTgï’üú&jÙ≤à\ZK˚àZkGâ⁄gÜà∫áuCWâ∫âµD]¶Ñ®˚ÿì∏CVJ‘ÀΩE‘ﬂnL‹µÒqóñqW«c¢A¿s¢·úq˜Ù¢…K—túhz}—,‰—,ùJ‹—F‹ø¨O4«âÊÕ·DÛ_ßâ=\Zàá<û%⁄-°âñR_¢ï¡z‚ä—FôK¥•>#⁄MÌïñâ«˜⁄è{õ∑º\":öMù¨tâŒnƒS£IDóƒ&¢´Œ¢kﬁu¢k…—m}—›ØÜËû{áËﬁqÉËqo?ÒÃø!¢˜ —∑µåxˆ]—ﬂÓ—?ßér›ì2üI<˜Aï∫œö:≠H<ØUO<oeA<_G\"^Ñ¸%^¨zMèÎ$F\\zKåh\'F¸I\'Föm%FÌ˛Fº≤ ∆‰óØäåàW[¨àÒÆ÷˚ì8ôƒk:R‚µ’(b …6‚çRb:Û1√ˆ\01£È41Û∞ÒÊEk‚Õ¥<‚Õ)1+Cºı∑Åò3¸ôxª`òxªk?Òˆ◊P‚ùm´ƒ;π›ƒ\\ﬂbﬁÒGƒªNªâwá@D¿∂l\"D‘AÑLÏ$B=Ìà0ß;DÒû’DDÖDdµ7ŸPJDN◊ÒZSDB¥àH®Y wIπ:Drl\"ë¸vôH%ÿ6∑àÃ–DÊ£&\"Û5ä»n√9zßâ€,¢¿Cï(»#\nD¡/¢‚¢kQr*ã(π:GîfeªéÔ›ù$ﬁìÓ!ﬁwI$>ÌÏàè±ƒ\nçÔƒäebw±‚ëîXQ’L¨‹ñA¨Dvk‚ækﬁƒ:£b›%±A©òÿH\Z\'>◊ΩN|ﬁÌAl6] ∂®Æ[˜QâÌN±ƒŒÓj‚kMÒı…vb◊=-b◊7Mb◊‘\Z±{ù:Òø&‚[ù¯∂{äÿ√ ~∫À%~z¯çÿ∑#ëÿÁªèÿWÚÖÿ™Öÿø2J¸l£A0M%©§GÏ]à£æ«Íˇ«ß	ƒ…Ä‚‘ÒáJqÆpà¯sõqõL¸UiF¸ı;ñ∏ÿà%˛%˛F!àK[fâKv=ƒ•gÜƒ•ïz‚2Œò∏ºÏN¸ªCD\\±±\"Æú?FR8ÿCRX≠\')jPIä◊ÙHJ˜◊ì÷G¸$m8™L⁄p@⁄xøí¥Òk*iÛxIUËIR;H\'©π˛\"mYÏ!©3èê4‘ê¥|I⁄%â§ùj(“.6íd†ÆB28¿$•í∆$$√“$√ $c5*…¯i	iwÂ$…$∂ùdÀ ôSH¶5É$3{…l!õ¥˜Q“~áí˘·´$Û¶ç$‘Oí≈≥a“Å’˚§É9ÈpÿGí’°\'§#∏*“Q;\0È(ıÈËè”$k¶…z≠åd≥≥öt,\\ád´L$Ÿ›+\"/˚N:ÒB@:y}ûtr‰8È‰¥>…)8Ñ‰Ã:Hr.¿ê\\£–$7m	…ù ù—Âí|>Üì|Ì¶HæA$øƒ“Ÿˇ∆Ïø…ã†Åx÷üú•E\n—Ì!ù≥#ùÔ &]‡ÛHubHa]«H·ÏHó†˙§K≤qRdß3)ÍÌ<)˙é)∆BÖt’îF∫zÃù˚0Ä˜∑ùœ<FJÏﬂMJÍ∫F∫∆~D∫^ÂI∫˛\"ït˝ª*)y[)U?åî∂È\"È∆ ÖtÚâîSpût˚Ö/)o€0)/§ètw˝PÔ:	xÍ=	à˘D&Åﬂ∫ì æõHp\Z	˝˘	ΩúA¬VDìpUH¯sΩ$Rèâ|ªúD›!—jwëËEı$fHâÌßDb) qÕ∆I¸¨0í@ˇ*I2˙ö$µìÓøxCz‡‡M*\0∑ì\n]≤HEèÎI≈ˆ˚H%∞AR)ˆ2©lg\r©<WÉÙH∫áTë>E™¨—\"U/Iµ{ûêÍ>‚HèèëKD§\'ªˆíÍùˆê\Zp±§Á§ÁCã§ñ≠§∂Ôn§ˆÉL“À\r§óyªH#È§ÆØxR◊¬“çY“õ“§7\rÎHoWHoOôêﬁe4êﬁıˇ%ıÙàInü\'}≤à#}∫ÆK˙$÷%ıÕë˙koì>õ<&\rl@ë‹Øìd$“@æ6i–aû4à$\r[ëFc£Hcá\\Icó©§±®t“◊∫V“¯Q3“˜My§…Í§…~Èáß	i~Gi˛ˆiûJZ–ﬁEZ»‹A˙•µ@˙ùßC˙∑M˙7˚è¥∫NÖ¥ñíNV^§ê7ﬂ–!´\Z¸&´RDd5üOdçàçdÌÚ∂≤&Ú∂∑7…∫”O»;ﬁëı(dΩN2Yﬂ¿Å¨Œ!Ô‹¶Lﬁ˘œìlåµ&Ô.≥\"Ônâ&Ôûí˜D:ë˜@pdTyÔw-≤È°U≤YmŸ‰B6oﬁM∂x©E>¯ÈŸRä%˛–K><“M>fÃ ÛV Éæ\"ü¯pÅÏòÇ ü¸1K>Æ@>EºAv˝ΩÉÏÓŒ!ª4»ûÀˆdœ’Ô‰3ó≥…ﬁ◊»~æ‰≥7…˛ù…˛_°‰Ä\0%r¿urêÖ*94†î|˛@-˘Bˆ&rò	í6wì~<Åü\"_Iõ%«‘»…W˛ëØhìc7GícU∑ë„/ë„5Ç…Ò—‰xor|öú‡EN,˙LN¨…%_”…◊ ‘…◊\'7ììç+……}·‰¥H9cíú!ﬂ@Œ ˆ#ﬂr™ ﬂzΩDŒéô%Áj∏íÛ4ŒëÔzfêÔæ{Fæ˚æöPŸMTëÅMd∏Õc2‚ÿu2¬möå8∑Éå‰îê—M—dÃâÁd\\º#üK&òyê…Âø»‰∂P2\rÖ$”Oæ&”E}d˙Ú%2CøâÃTìôÅ2˘íÃ\\) ≥\\Ëd6&ñÃ@ëπ_ì˘±d~Û%2Lò¸$Ö6dI‡^≤˘à,yµù,ıˆ$K¡·dŸõcdπÚ˘ﬁåî|ˇ…%r˛.	9»ô\\p∞û\\êbG.®õ\'™…Öç*‰‚‡JrIõ\\ËG~Ù¢á\\‘HÆÃ\0ì+{»UøÜ…’rMru£	˘	eû‹p·πÒL6˘ôr˘y_\ZππˇπÂÚKrKû-π6In›˙é‹ øT©!ø<I~ÎF~˘Ï π#üH~m3O~›O~ìîC~gM~7ªâ¸sñ¸i›<˘Skπ˜E\nπOINÓ[~HÓM&˙ﬂ&Î◊ìá-ê«∂∂íøq‘»!”‰â\\4y‚ó<u∑Å¸„Gy˙Œ(y˙å<˚Zù<ØH˛ÖÓ /ñ«ë◊Ï\'ˇô\0êóÚ…ØjíWˇª9≠{íJQ®˙AQ§PîÕQîûzQî¶wQ÷/Pî-T)õ∫Ç(*KcµìıC ÷g7(\ZM\nm£˝îÌ(∫;R(;¨–}ªªîùjÛîùèS(ªˆ¯PÁRåRó(F‰c„Y>≈xâN1±⁄M1ª©@1õõ¶Ï?{âb±ˆñbπÓ≈Ú¬äe÷ ≈ÎK9º‰L9j†I9jiK±é0£XSí(6^(6u›õñiäÕ⁄käm≈;ä˝ö>Â∏VﬁﬁPéøL†8h>¶8NZPNJ‹)N\r…Á‰uÁw/)ßÙvS\\6I).µ&î”˙Ø(n0}ä{@ÂÃÕ ôßø)>áŒR|Œ$S|„(~ºÇˇ¥SŒÃ)g>RÉîêà8J¸8%4»Ü&ES\"¥‹)ëêî»KÖî»§yJd˚ ÂÒJåJ7%ffÄr’0Ér5tírıﬂ(%Ò”y µÁﬂ(…êcîeìîÙ3J:LIøOß‹ÑNRræ¯SnﬂÌ•‹˜£‰kRÓ¶®R\0≤(\n»¶ùv5¶@l«(êÀ]hÿ7\nÃìKAXSêÔM(»^O\näúÇ˘ﬁH¡ãbT9Ö8=@°ËR(WüP()\\\n51ôB€~ÜB{ôC°_±£0T(å€_( \nc5â¬ä}IaoWß∞•„ˆ£\n\n{éN·Ó=D·W)¸7w(Ç©Qä–ºë\"$¢àˆSƒ·á(‚õ(bÄ\"›=Aë:ë)r·M É’vJæ·_J¡Ñ*•p\ZI)äeQäù±îRº•liòRÓÎGy(≥•<\n8C©8hO©œ°T.n•T∑∏Q™ã)5&Ìî⁄ÍJ›Œ J]ì\"Â±Ω;ÂqÍ6 ìÑ5J}˘]J√yJSJ\n•©¨ÑÚåÔJy6≤èÚ‹Ji%Û)m\Zùîvw*ÂÂ⁄MJG˛[Jßn•€…êÚû∏è“”µBÈYå•|òÕ¢|\"\\§|ZPz∑áS˙vFP˙h4 Á3ª(üΩIî¡Käî¡ËU Ì< ó}Ωî/◊QæLS(£ÁÂî—‘x ◊[ß(ﬂ {(ﬂ\nŒQæ„Ê)ìNµîÈ]Ô(3)s |Üà≤–ZE˘µ‚O˘}WïÚª<ÑÚg”) íô*eâOY\rè§¨ΩU¢*D7Sñ“©ä[Ü©äÔT•#‘\rn…‘çh-™ VE™ ¡\'‘Õ\'˚©õﬂü†nÉPU}U®j÷˚®[ß®[dÅ‘≠1®ö•_©:-Á©:/˘‘Ì\nÒ‘Ìá/S∑Áü¶Íû>I›¡w£Í5UPw* ©;oS©ªÚ®Ü:õ®F√c‘›1Á©{æwS˜,∏S˜¨`®{UvSÕ∆vP-®vùßRÌ˚Hµ‹<O=L0§ˆR≠+Ã©6ØœSÌ6ä®v~b™]\\’˛ÿzÍq\0ı¯≥™√Œ?TG0’qNçÍdøFuﬁ»¶ûÇQ]æA®ÆªnROo•P=lŒP=\n¿Tè)’3˙\r’gd/’∑ˇ+’œEı[ä£û\rM¢˙Îo•˙{û¶˙{èR6®P5‘`ä\Z\\8L\r?L=b@=WM°Ü-öQ/ms£FÏ?Açr¯JΩ¢rà\ZΩSç\Z£Ãß∆lù£∆ƒPc®q\nÛ‘¯Áç‘˚j¢ı⁄.}j≤„ajÚ;,5’júö:IMã—¶fÙ˙S3¶OQ318j&ßàö9ÙñzÛZ\n5K+Üöe\'¢f° ©Y‚„‘¨˚ß®Y?6So=Òßﬁ\Z>MΩµ¨EÕ~QMÕ”,†ÊΩ«PÔrs©‡”iT(aê\n3]°¬í“®∞€ÓT¯Â£TL÷e*¶ÙªÕòä_J%ﬁ\Z§˚©dU\r*9vöJ!p©T ï¬Sôé*≥g;ïïêKÂ†#©\\\r8ïÔuÉ ˜ç£\néYR≥O®\"’h™ÿÒUÏT@ïô;PÂÁ;©˜ú‘©˜»À‘á?Q∫]®Ö7.RA®EF®≈ª*©%ÚC‘“µ,Âµ\"5õZïYI≠ÒºO≠;Gß÷∑Ì°>ΩÿLm¿VS-Põí±‘Á3$js£µyRç˙¬1à˙\"≤ï⁄“ûOmSû§∂/R;P·‘N…KÍÎdSjóÁgj◊\0á⁄ÌÇ¶æ3Ô¶æ{ØF˝†˘ö˙·û˙gF˝á⁄VOÌõ0°~∂Æß~é¶™⁄Qw;Q˚ß®√/≈‘/üÙ®£‰Íh[ı+„7u[Dù$ƒQß4ÓSl∏I˝1–IùFm•Œ=˘@]®1£.ﬁ•˛&|°˛f˛£.•ïRóYG©’x‘ïÂo‘¢C¥uö4E“$M)RHS]§≠o?F€PòN€P¶O€Xã∂±Ó\rMÂú¶ˆ–ó¶VO”ÿ∫@”å ßi ”4;ÇiZl]öˆ‡⁄v…öÆ`Å∂ccMÔLMøÏ	móm\rm<ÖfhîD3?°ÌôŸO3ÈÙ¢ô‚¬i˚è”ˆΩI§ôy*“ˆ7û•ôiìï¥a^¥OWi„ßiá!Hö’÷,ö’∂c4´Sù4+*ûfıÔ/ÕÊõÌUçf´±Åfõ=H≥˚ovçç4˚}üh\'¨—Níi\'˛›£9ç⁄–úÉ4Á∏{4Á‹Qö´≠/ÕµÒÕıµ1ÌÙS⁄i˚√¥”ëiß_in ≠4w(Õ}∂òÊQ≥ÖÊ˘£åÊ=±ûÊ∑Ó<Õoå@;{8ôÊˇÖNÏ¶£˝h!ñ1¥˛Z® ZËû\Z⁄yƒ$Ì¬÷B⁄ÖÑL⁄ÃO⁄Ö∫C¥ã◊kiC¥ã≈9¥∞Zx—(-Bkíì¸éÉä†≈|u°≈ﬁL†≈ú¶≈≠˝£≈†≈˜iâzwiI˚æ“í‹¨iIúO¥§\'\0⁄µ®M¥k±Oh◊ﬁ¨ß•‘ﬁ¢•^ΩJÀ@Ciô˛¥,ÕDZvÆ-[¯Üvª®Üv⁄JÀ›ëJÀÕ\\GªãP§›]∆–@/≠h–ÏX\Z¥ªãÜH¥¢! 7—É4\Z2úCC9Ì¢°2hË–5\Z÷Í\rÁ˚ÄÜ∑¢“¯\\\Z¡|7çpËçÙRüF-û•—à4∫ìÑ∆Ï;I„X~†q-hº–Xöô&\\!—$f≈4ŸF!M¶∂ëV§F+ö\n¶ïò¶ïÔ§ïg—iÂe·¥á™ièljiUﬁ+¥*˙ÒùV˚Sçˆ8·ÌÒ∞ú÷5OkLú£5él°51Ùh-UbZk¥≠-…ô÷N9C{i£Ω,ßΩúﬂN{X§u,oßuñ—^¯”^üªI{})îˆF;Üˆf8õˆ—dïˆ…C˚ƒ\\£}ö“˙˙}i˝J„¥!g(md¥Ç6˚ã6VzÑ6÷}Éˆµ$ñ6^öI˚ˆAõ@Æ—æÀ¥…\r⁄‘U4Ì«<ñ6KT°ÕJ¸h≥èÎhs\n¥ü\'hÛ%›¥E˜T⁄Ô‚ü¥ﬂKèiµ/“˛Í–V^œ—˛-u“V≥öikW∫hk] ⁄⁄L.}=˝	}CÉ6}√ü(˙g,}kµòÆqÕÄÆ©øB◊tH£Î ◊—∑ôÓ§oW˜§ÎN∫–ıÏRÈ;\r=ËFDS∫qU}ü{}ø˘˙~ﬁ-∫E“g∫Ö¥ç~0Ë4›íîF∑:πënı ãnÛ#înßüJ∑;∏ìnWK∑?XN∑O¶€3ÀÈ˜√Ë\'ôwË\'ß<ËÆÎÄtW‚O˙ÈÑ9∫˚ÕE∫;œëÓ°ZI?≥˘›{√[∫œÿ›Wq›œ’ú~6)üh‘FÒè¢á$N”CFËÁÙ∂–C/Ôß_–T§_8B8O;ÁMÀ•á∑’–/]ßGÿd”//e”Øh>°_	©°_9WOøÚÍ5=ˆJ=ÓıEzºu=rÜˇ[Lø]MO∂{NO∂o†ßË3È)ÅÙI=•Ô5=ıD\"˝¶∆,˝¶Æ˝&¯6=Î–F˙-Õf˙≠˝ˆqe˙ÌM˙mI=W∞@ﬁ£Éﬁ&—!WÈ–ï:ùG«Dﬁ¢côIt.ÜN<ÙìNåœ¶ì6ù•SCÔ—iïØÈå˚\ntfºù•®OgoÿFÁ¯”9◊*Ë âŒ›ÓLÁÌÃ£ÛN“˘_Ât{+]∏{]îTNóÏr•K…È2/E∫\\·-˝µè~_°ç~ﬂ|ú~?™çûè§ÁÀõË˘u’Ù¢ÉÖÙ\"ò\nΩX=ù^‚ëH/ßó≥ñËS∞Ù Ôdz’n%zUÔ?z]∂%˝â‚)˙ÉkÙ¶˝)ÙÁEÙÊTWzÀÆÙV=mznΩ=!Ç˛jù9˝gäﬁ˘ÉGÚï˛˙‹Ωk/Ü˛F°â˛6©ê˛ŒrÜ˛ﬁp?˝„Öy˙ßØpzﬂFS˙ÁSÙœ•X˙Äè?}\0⁄E÷[•	à°è◊“GÈ#@˙»/c˙ÿfg˙W≠uÙØ>ÌÙ	˝;h3˝Gı˙ÙA˙åá	}ÊS4}ŒçIü˚‚Iü[n•œÁ/—Ä˙ØßÈøCõÈøª{ÈKOØ—óCËÀUﬂË+πp˙ ÉN˙øX}øãæ*Î†Ø~Î£ØŒ˜2@ Ü¬ßÜŒÿ‡\'cl∏uÜ°º˚\0Cy–ì±ë2¿ÿî8ÃÿÙú«ÿ‹≈Pµµ`®»Uã°fÚå°ˆœé°Œk`®èehÏÛbh\\™`h734;K⁄Áåm€2t”o3vL]`Ëµ∞;µåùë;cª\0\"ÜÅç%√0w◊ò”¶Eû”_„≥ÓT∆˛áÜ9Zïaﬁ`«8†∏ƒ8 ´f¸ÆÃ8dÀ84ùÃ∞‹ÑfXÚñVÂôå£JG	%Î)õ†£õk««\"l«ÍÆ3ÏbvO˜3ÏÂ˙å„¡*å„á&√1®ïqrTâ·thç·Ãﬂƒp^õgú2®d∏˙fú~ù∆pæ¡Ã~ÕD‡û$sÜß†å·˘xû·U•√ö,bx{2|.g¯çûdúïÿ0¸ıˇ0úÑå‡F/äjíqa5ù^ö ∏t√àúG3.gˇdDY‹aD˜j2b‘˛2bìw2bsDå§8F“;c∆µ≥åTÌå¥\\F⁄»8#˝Ÿ~F˙ª+åõo0nÈûgd“˚O„éO\"„#7Ú#óyöq˜r\n®ƒfÄÒ?ê∆E‹ØèÅﬁ{àÅ}¯ãÅÀôeô$i«F9Ç»†˛ª¬`∏{3ytcÖ¡`∫›g0Øùfp”\\@É˚c;ÉKeÔG3ÑCî≤Ö!∫âdH‹°˘5SÜ¸Ê-Üúö∆∏Øl¬x∞Ì:„¡çΩå¸Ø˛åv£`h£¯#õQ≤∏ôQ˛∏äÒË—F•≤£Rˇ7£Íé£zÑQ}á»®âxÀ®!‚u◊è˜U3”uıäHFΩﬂF˝CF}˚4£·k\Z£qÄ∆hR.f4y—œ[å/hÁ≠V∆åóåÌ|Fßí5£sõ1„u¥„ı˜LF∑f-£õGgtèw2ﬁËö0ﬁ$3ﬁfY2ﬁÊÁ1z@åû?ÕåæêFﬂWFﬂ⁄V∆ÁGSåÅœÒåA;∆`ó1∏≤ï1ú˚É1Rçfå›a|;“ƒ¯v#îÒÌac\"ö»òXæ«¯æÔ+cíÇaL1è0¶ÿ∆,ŒòΩaÃÁÈ3->0cˇ0SsŒBKùNåÉ´’ΩÃu˚ôÎnôÎöZòäywôäòX¶R†î©‘wñπ>œ‹PfnË≤f*+h0U<rò*c]ÃÕ3	L\rÛD¶&ßç©£xüπ›hÜ©´tÇπ#ÙSÔH2sgA\nsÁÄπ+{”†Mãiàäf\Z≤1\rG&òF§X¶±ÿóπÁÚsÊûﬁLS·,”¨—öπ?Iãπ˘3”b‰Û¿lÛ‡L\rÛê0·?\0¶•‡9”*πôiıªáimºÃ<¶6Œ<fX¬t∫qóÈ‘›Àt∂˘À<5‰»t9¬tª¸ïÈˆ˘”ùÒõÈ…)bûqöbûyÎÃÙ˛˜ÖÈ£¿Ù¡_b¥œ0côÅåÃ¿Wf]ƒŸ¢ƒ9ÅcûªzäyÆ7íÍ”…ºhˆòy1%üvjûˆZù~§ÄÓÚäq÷ôy˘¥3ÍÉ◊%b∆OD2„ˇÍ3ÓÙ3ØMg3ØØˇ º~;ôô|OáôBWc¶ä<òié`Êç$f∆|>3so3s‰3k•õôMµfÊ˛~ÕÃhaÊÂ÷1ÔÓê0#qLêF?l>…Á0!€®Lò˝[&Úf	˘dââôhÊ\nìGbbM‘ò∏€ÌLı>ì0wÄI:›ƒ$]D1IÕ_òÙ7yLVB\nì}‡	ì}fä………er€áò‹ë5&œÏ(ì?TÀeò¢?Wô‚Ìb¶toSûEcﬁWËgﬁˇùÃ|P¥¬|ÑŒÃ˜5a ~3ãéX2ãOÊ1K˜]bñøæ√¨l÷`V~D0´‹Jòµ©\'òµØÕòèÕ0ÎCø1ü:ºe6™á0õ™jòœ=˙òœó2õsùô/∂3[Œº`∂ƒ(1€É›ôØ{ôØ˙|ô‹hf∑ Ä˘&ÈÛÌñ&Ê€sﬁÃûèÛÃ4CÊGmgf/†ìŸO≠g~ˆ˜fl|»p bƒ<`È™1á2∑1ø:€3øf#ô_ÛÛôﬂ6∏0øÖbôﬂ&XÃÔÙÊ∏s\ZaŒôç1n¿1n1ÁQ/ô¶Îòã»Ã≈OÊoøÊü≠ŒÃ?∫≥Ã?ÈQÃeÉ›Ãø*ò+Øôˇîöô´œYä7&YJ¬XÎHXN7±6\\Ìb)œûf)/`m}À⁄tæòµI†Ã⁄TÉ`mZ;ÀRâ.e©LV±6€ÔgmÜ^bmÓ0`©>Œe©≠ì±‘îÖ,5ø,µ4K\råc©uÕ∞4#∂±4ë/YöçY,ÌñK,≠ç¨]^J,C˙6ñ°À2˙fÌπbÀ⁄3‹¬2â©bô<ˇÀ⁄ª§…⁄∑Î6ÀÏîúµøÓ!À|—öeëï»:∞Câu ˇÎ ‘ÅuπÎêõåux±ùeÂ`Y1:XGåXG*-YG\r±lTáX6=Ó,õæ÷1Ω\\ñmÊ#ñ-;Äe˚ÔÎ∏é)Î¯6÷	ﬂ8÷ârÀ·ÃzñÉ@õÂL˜fπ¸£≥\\ﬂ°Yß‰¨39.,/…À°œÚ.6f˘ƒ(∞Œ˙Ñ≤Œ^D±)•¨ sV–Å\nVp+âíS≈:ó…:øπäuûØÕ:?o»∫ÃÉu±eêÓó«\nˇ<Ãä|tá}Ãä\rs`]\rΩ≈∫⁄òƒäÌ∫¿ä˝xåïH∞Æøó±“fYÈ·oY7\'lYŸÌ¨Ïî$VŒÀó¨;5•,¿5„_Ùœíl»B1XË÷I6È	õÛöÖ´æ…¬=—a“w≥(ôYî±peÌ1ã˙Œå≈àta1ùXÏîqG˛ó≈]õeÒ¥≥YÇ°eñ–˙?YfKæù…íˇIa›ÉÃ∞Ócé±Ó?∞tÍ±Ú_@YX≠¨ÇÑ+¨Çóu¨\"∑[¨\"b´∏ƒ*πécï9¿*\r‹À*˝≤∆*É± ÚÉYÂam¨áÍõYè,«Yèo±*.¨™C6¨ÍcV\rœîU#«≤jF¨«ÖßYO:˙YOÛX\r·+¨ÜÅDV„FEV”6eVSP´)^É’‘ËŒz’√zVÉc5π…j…?¿jm}«j©euÙqY„ªXù∆L÷ÎÉ;XØk¨Ó∞a÷€ÌWYÎRXü¨KYü>[∞zõY}·s¨}k¿œ\Z ∞Ü<O≥æ|‹Õ\Z˘¿˙∫ÈÎõ·\"Î€u÷dπ)k™8Ç5ÕgÕ<\"≥f}{Y≥‹¨Ÿo÷‹‚8k!…âµÄy«˙Âm ˙ìc-aÑ¨Â≥¨ÂKÿÎÄ%lÖ˘lEk[)Ë[È≤-{˝ãB∂ri:{£ü\"{c\"üΩ±ÀåΩi√\0{Ûî[u’ò≠æ`«÷ÿö≠πSü≠yŒû≠˘Ô+[sã≠’Ñ`ÎÍnbÎ:U≥uﬂ∞ı\r?±w2|Ÿ;≈lÉOoŸªu´Ÿ{’Õÿ¶mlSπîm∂´ímÂ¿6‚ÿg™ÿ){ŸôelÀùfÏ£Ã1∂çY€&Î	˚òœ€ˆÜúm˚û»>,eob7¬>±˙úÌ∞C¿vúúbü“› >Ub≈vŸˆîÌ˙IÅ}∫Ó,€ÕAÉÌæÔ$€}ÃúÌyd/€,d{{Hÿﬁi!loI>€G\'ëÌcMb˚ªe±˝·]Ï¿±Rv–ˆ%v∂\0ˆπø◊ÿàfÏãæâÏ0±#;ÏŸ˚“˚˜ÏàuçÏ»åˇn6±vT[!;Í”&ˆ»1ˆïESv¥È\n;FEï´⁄Œéwlf\'Ï	b\'‰©∞ìr,Ÿ©G;Ÿ©ˆzÏ¥\roÿiºÿ7‚Ÿ7:˜∞”~≥3ÇKŸÕ:Ïåˆ›Ïõzdˆ-¡$;˚Ê1ˆÌòNˆùÿΩÏº›tˆ]m\"x à\rÙØfÉ)lHõú\rÕ5bC6ºÊ:mˆëç1bc¶“Ÿ¯”Ml¬bõ8¬cìõŸîøÕlÍÎól⁄∫l⁄∂h6çìÃftIÿLΩClN¡0õG◊aÛZïŸ|‡%6üvï-ä≥aãõø∞•:	lŸõP∂<?ù˝Äj≈Œè‡∞ã¬cŸEJÏ¢ﬂkÏ‚3v1\"ü]b˚ò]Æíƒ.ﬂ©…~xŸÜ˝(OÉ]%bWØ´gWø/a◊la∞kg◊~9Ã~Ï‚À~¢YŒ~B≤ü‚_∞ü÷π≤•ﬁÏ¶Ì˜ÿœ®+Ïg«ŸœÎÑÏÊkÆÏ’SÏ÷B$ªm’å›Æ\"`ø§Ï`wÏÂ±ªù”Ÿo\Z¥ÿoﬁ}aø∑Œgø.f≥ÿüù7∞ÛåÿC\rÓÏ1Óˆÿã«Ï±ÖÀÏÒ,wˆT≤\Z{n√>ˆœﬂ+Ï˘ÿˆ¸T{¡ƒÇΩP∂ÖΩË*gˇŸ¥õΩzøàΩˆÂ+{m≈^˚ˆö£‡’ÕQX.·(•n·(ÂüÊ¨∑ÔÊl\\òÂljTÂlv^·l~≈QªúƒQ´› Q◊sÁ®GVq‘”wq4é~‚hjq¥eﬁúÌ©ß9∫qØ8˙,G9çc(>…1ÓÔ‰ò·ò,Nqˆ⁄Gpˆo‹¡Ÿœü‰ò”ŸÛˆ9é≈\\Á@¯ŒÅø+úCúC$Á–C\rŒaÔ\nŒ·îSú√èÍ9VÕΩú#è„8G∫Œré:eré==«±;¢ ±˜¶qéì%G+(Á‰∏«%U¿q}P∆ÒŸœÒˆp|^Ï‰¯…ØpŒÓ˘ƒ9€πóà8Ã	π√	\\¶sÇäú`áìús3RNÈ	\'lbà˛)Äa8≈âên‰DJ\r9ëø8óÕº8Q⁄mú®(\'™‰\nÁ ôse9ÜMY‡D∑ÑpbßÊ9Ò~ø9	àúƒÒú$ÎóúTÜ9Á∆ÈaŒç9GN˙∆múå†ßúÃÒeŒÕŸCú[?Î99ˆ*ú€o„8∑Á9wrˆpÚ“÷qÓÜiq\0ﬂ#9êÇeÙÊYÃ¸8[‚`\'°ú•W&Á‡oÁÜÕ8Dêá»˘¿!∂¨qàÀ∂íòCä	Áêï˝8î0áz9ôC£·–˜Ÿpnù∆ÌΩ∆Ú;{Û%€˛\ná;X ·˛ ·ƒnQÆG|Û0GÃ•r$£ú{gﬂsÚÔip\nÜ8Ec¶ú“ufúRïNÈq}NŸ62ßsêS˛ ÉS>∞âÛh¯5ßÚc5ß ÷çS•¬©;3œ©“‰<ya∆y\Zœ„<•ù‰4fÑp\Z[9çü÷s\ZGwpû)à8œ;[9/òKúÕ˙ú∂çIúˆÄ-úóùŒ+ç˚úŒ]Mún‚(Áçé”sŸáÛÒ‡:Œ«Ôyúﬁ¯kúæ«*úÛ\0ŒPi<gò¡˘¢Êål∏…ë8£	ú1‚Œ◊‘@Œx?ÇÛmÔ gB√î3i#ÊÃ‚8ú˘Œ?úÖGŒ¬¬#Œ‚l1Á7áÕ˘sÀYÊ°9+Íg9+â[9+C8´.m\\Öõ£\\Ö—˜\\≈}Óz≥ó‹\r£æ\\e—kÓ¶à5Óf´QÆö¸WS˘\"W3»’∫&·j£∏:ÑaÓˆıüπ∫Î‰\\]Èw«¶ó‹!€∏…˙\\CB◊p¿5\ny√5˙ÒÖª\'õœ›3Ì 5I¸¿5˘∞âª∑›êª/yÖªo‰9wˇôqÆyû2◊\"Ãâ{õ˜∞G%◊ÍƒÓQˆ.ÆuAÆ≠ˆ&Æm™◊^¿µƒ=˛„\'◊!d3◊a∫ùÎÿX»=yzôÎítüÎ“µüÎ:fÀ=çs›Ünp›I\\]+ÆáâÎ©†«ı‹é‰z˙ÈpΩ6=ÊzÎ3∏>’bÓY˝]‹≥S™\\ˇu[∏˛˛ÆˇïYÆˇ;Mn†áxı+7Ë˜\'n≈8n0lÑ{æ¬\r5r‡^∏pà{œΩ ”Â^¸ˆè{qÌ7úîƒ\r6r/}\\‡F∂≥πó◊s£4?p£Ë‹›Yn¨ÊwÓuô!7%‹íõz¶Ç{„e7]|åõæ¸ù{Gı!7ËƒΩÛç∏±û““„ÇœFsa∂u\\XÍ5.Ïﬂ./‡˛πsâQ	\\íbódÒñKäIÂí˛û„íÎπ\\J˜~.µ|ûKªπìK„õqÈÅq\\DŒeÙ¬π,\ZéÀŒﬁŒÂ π–ÆPD„ä£Œq≈†ÆT¡Å+]JÊﬁ3£rÔqÔıü‡ﬁﬂ‰ﬁßesÛüπ˘ì≠‹¬¯ì‹¢àn1µÑ[\nRÊñ˜∆sn|œ≠∞&q+lˆs+¶Ør´vNsÈÁ>Òè‚>ô|Ã}\Zg¿mæ¿måY«mƒqõúz∏œ6xsü+πœµèpüœrõÕß∏/,Ør_¥Â∂‰Ê∂‰/q[Ôáq€˜≥∏/ãvq;4ør;&np;w∆p_ﬂoÊæ]œ„æ›µï˚Óü6∑ßhñ˚a~ê˚—R¿˝D˘¬˝Ù9ú€´ÂÃÌÂ•r˚wœs˚[∫πüÕ-∏Ù`Ó ní;‘ö;¥6ÕÆ)Á~ôt‚é’⁄p«&™∏_É#∏„FhÓƒzÓ˜X2˜;`û;yNõ;˘¨ù;πrå;ªpà;Ø	ÊŒÔY«ùøÊ»]àÛ‰.Ù^‡.¸’‡.⁄7rˇÑæ‰˛πÁ.iÌÊ˛UÙÊ˛≈§qWùw÷Ò;xÎ™jÌxäÌØyJ{ZyJ√(ﬁ˙uŒ<emO%Ò#oÀÌHûzπú∑5ΩÖßù∞Öß›W¬”){»€KÁmK∂@<]Ê1û~ú*OˇÆœ@é·~∂‚IyF¿Iû…3ˆuÂWÔ„7*Òvm‡ôÿXÚˆÇøÚˆ}vÁôQµy˚îÛÃùFyÊC<ã√?xé0ûÖ_:œ¢¬áwêËƒ;Ñ’‡Y™?„Yû)„ˆCÒ¨ÍÆÒlæBx«ˇÃ.<«¸«ºì⁄Cºì:ºìvøxÆ“≠º”&yßÀ1<˜b0œC=àÁÅ…‡yƒºÍ≠x>˚vÛ|Ñﬁ<9ôÄÂpÁxAÁuyAâ5ºêÏùºË4/\\.ÂE|<¬ãXÒbzfyW’Ωyqõ≤yâófxI€VxI${ﬁµÂºÎ˛ßy◊ø›Â]_ÛÊ%Ô˘»KëbxiJqº4e/ﬁçΩ\nºÙ˝≠ºÙ¿Õºå)/£[ÃÀÏÁÛn>¨„e9ªÛ≤ªÛy9ñˇx9˜ÚrFªyy_ˇÒ\0(–Z√Óı·S∫y‡Æ£<4œúáyÚñáµuÁaª[x¯`-iŒ#såyîC{yîLè∫6»£˝LÂ1n˛˜†W:Ãc[ªÒÿ„ã<>ã«)´·qªÀyº{ <~†ú\'8{ä\'®j‰IÕ∂‰â{y˜vÅy˜¢≤x˜˚ÒÓ{∏ÒÓW^Ê›o:∆ªø¨ÕÀˇfÀÀˇ˚ÅW–uàW8Ì»+ûHÂïHæÒJ˚ ˛\rÒ /tÛÆ√Û*F-xïÎ,yï∆9º %$Ø⁄pàWÌ˝ãW}i=Ø˙Ô&^ÕÈßº⁄Ï≥º∫Sº∫8 Ønê∆´O‰=%\rûŒxOWOÛ\Z¥’x\rüéÚö:2yœ,˚yœo%Ûö5‰ºf∞Ä◊⁄4¬{uÃî◊—ôŒÎTV·u:uÚ:;õx]w7∫>ûÂΩ9&‡Ωâ‘ÂΩ)Ÿƒ{+€¬{∑˜Ô]¥&ØÁ\\ØÁYØO≈Î¯OÒOﬁ`æoXÈ=ÔãqÔüÃc_‡ç_lÁçœ©Òæ˜;Ò¶Â’ºÈπTﬁ,tä7WÂÕ˚}˜)ÔœVﬁ“îoÂœﬁøç\0ﬁøcìºçy´Uøx´çº5S[ﬁ⁄9!oÌúøéªƒW8“¿WXYœWq‚oÆ\'ÒUmY|’ºZæ*0äØv]ƒﬂÚ’êø5“ôøµ˚Î\nÄØq,óØi*·k)-µ˙µ£?µ__‰Î,Úuª˘;‘˘;⁄∂ıÃ3¯˙ãÆ¸ù˛)|ÉTGæAgﬂ¯Ω-∑éØÖ;ˇvKæ≈ë.æÀ∑ wÚ8∫Úú¨Áº◊¬?¥˝ˇp¥ˇËΩEæµÜ1ˇXá\nﬂ÷gäo∑Ó	ﬂ^aﬂ^i/ﬂ~˛\nˇ‰ã™ˇﬂ5ﬂÜÔZR»w˝“¡wK“‡ªM£˘ÓÔu¯€a|èvˇLf\rˇLV=ﬂKèÃ˜≤_«˜ﬁüÕ˜±ò‡˚ÑhÚ}M˘˛;˘!:˘°W«˘\Z˘r˛Æˇ¬ß0˛≈ß˘k˘˘·If¸KiQ¸@??¢∆ÅyÀÇ˘‘ˇ Õm¸+2	ˇj4ôªﬁç è+—Â«Æ·\'Ë´Û-˘	üq¸§0o~J„~j`%?µeöü∂„;?}‚=?#ïÀœ‡hÒ3OÕÛo%gÒoÕÁg_~∆œ~|ïÁñ%PXœ=ÊÉnÂ¡§f>∏Á22Y¿á,%°T>\\y^õ…G+ÊÒ˛||´üppåOXv·ìtA|“˛n>âëœß2¶¯¥~/>˝Üüq¡g:Òôïr>s)åœ“\nÁÛ¬¯º4>;ûœœõÂãw8Û≈wøÒ%ßOÒ%çW¯í%=˛Ω‘o¸{¨~˛}øn˛˝HˇAÇˇ3Ä_êmÀ/4ÆÁvA˘Eß€¯EóèãÊ∂ÒK¿∂¸rÂ~≈p$øÍÿ_~uå_›1√ØÌﬁÕØ3ØÂ?ÒLÊ?áü|ÛÎ°+¸&,ïˇ‹∫åˇ‚Zø%6õﬂÆxäﬂnvóﬂ~ÒøÛX6ø”Õüﬂ˘Ó>ø€Î;øªtˇÕ´¸∑—/¯oœﬂjÚﬂ;¡˘=§¸]3¸è·≈¸>´U~ˇF}˛¿ˆ¸¡#5¸/;Ä¸/»5˛X‚˛◊˛¯C:ˇõ¢ªô?±TÀˇÓ–√ˇÓıñˇ„ÁZ©Ü?˝^Ö?qÇ?õ„«_Ë\\«_x˚Ñˇ{{ i¯6˘%åø≤4…ˇß‡…_˝:Ã_˝M·Ø’º¨˚N¨[9 P:ıC†4h(ÿ†<)ÿ∏√F†V\"P{FlπU†>∫M†˛˝º@}qø`ÎûzÅeL†}[O†”ÙR†Î)ÿ·¯I`‡˜W`µS`∞tR`®Â-0.òp&cè¶\ZZÇ}cOf˘≥O)ÇﬁÇ}@¡°s9ÇCy£ÇC’BÅ•cä‡Ë∂‡(*G`sÓü‡òV´¿nÆZ`∑:+8˛(Hp|9RpÇë,pH≥8\n\'/úbÅs Ås·∞‡‘i¨¿ı»uÅóÜ∂¿˚±£¿[)8€èhÅAŒäÇú£ TtPp1\"Jj+˝QpÈdπ‡Rh∞ rú%à©z$∏j^*àeˆ\nb+o\n‚?∂\nj8ÇÑÓhARÁ¨ •œGêz>ZêZ»§>º.HW6§[	2Ïç7-\r7[Y‹\"AŒÓ,AN˙¡Ì≠3Ç€$î‡é†Apg˙† ˜ñö‡nÊ‡îÅ\0‡*\0Ñ<\0¬€@øêú.Ä*`Î+∞õÎb\"$EÄ¯2 @n–7Ë≤\0Û&¿¸	`ç®B˙?——V@tø8	»+ÚÍ	M)V@sF	hÇ%ΩLC¿8;(`\\ò0`˜LØZ˜¸&È,¨Ö	ÑÆãëI IÚHjbíâ ÅÏlë@.\n‹3ó	Ó≈f\n–7ÖäUÇ‚ÀAÇ≤#Â=ëÇäÑAA≈ä•†ÚúÆ†ÚŒEAÂHâ†zÓª†FÈá†&€CPÉÀ<·™\n\Zä\r*_\ríıÇ∆¨\\¡≥l∫‡π+R–öˇV“%XjIQ–ÈΩ_˙€å‡ı“fA◊Ñø‡Ω…¡˚:kAœ†≠‡£ﬁÄ‡ìoÇ†˜®ï`‡ø<\r≠j	F¢]#…€#¡H—∏`îäå=SåM}åCÇÔ/tSãW?é~LL\nfÄ≥ÇüªFøÙmøÿ¡ØäﬂÇE«¡b“~¡R.T∞ºqØ`ŸR_∞\\¶*¯[´-X94.X	j¨H/Vö≠+üYÇ!G´/oæ	7n»™“Ñõ?U]ÃÖ[Ç:Ñ\Zs°V)R®ı€Z®ÌË)‘æS)‘Z∑ù≥Í*Ö	wò¥w¿ Ñ;ﬁ	ÖzûÆBΩÿz°°∑øp˜ùF°È©–¥/‹w¢A∏ÔºßpﬂÏW°Y9Fh÷&4Ob	¥‘-6ìo≠îd¬#Åm¬#ﬂ\nè]ZÀ{Ñ÷øíÖ«\\ÏÖvÕm¬„iÅBÉ°”LöîÔ≤ƒSxä∞_xät]Ë*‘∫;ï=∂X\n=≥n\n=©πBØc°◊´gBﬂœ˛BøàU°ﬂÂ)·Yaú–ˇÏCa¿ÅW¬†“&ap∏ø0¯áõ0ƒgQr)<ø¯Wx·¯äB‰†0¨hß“(O·sD1^yW(å±n∆xﬁ∆Ÿ„rsÖÒë›¬ÎçÖi∂¶¬Ù∏è¬õóÑY»„¬¨ñ¬[.·≠&Ç0˚`≠∂Âv·ù ∫0ó£&Ã˚ÙTT<%TØ¶\nÅ†H!($N~5.Ñ^Ú¬ˆë◊3Ö»…;B|e!qCÑê¯s´ê,Îíü*…3ÓB ëe!Â]Hµ	Yó∂πª Ö<Ø∑B˙Üê◊’&‰áﬁÚ[ ÑB+°ò1\'î>˝\'î˚n çÑ˜&ÀÑ‹œÛù3Ö5c¬BÛa—Úea±aÉ∞ò⁄/,≤Ñ•kÂ¬2∆Naπæü∞¢!,\'>,∫*|4ﬂ%¨ÿb*¨ƒÃ	+KJÑ’k°¬ög¡¬⁄£Õ¬Zü7¬Zöã∞ˆCä∞vXWX\'cÎjY¬∫é≠¬ßõÖÕæwÑ/˛Ü	_≈ÖØZ˜ª/•	ª£áÖoÊ:ÑoïãÖü˝/?ˇKÿ°Ñ©ÑÉÎöÑÉ*˚Ö√æ¬a©p¯’àp¯X¯Ö˛J8E8j é›Ré—ÌÑcMßÖc/ÀÑ„>_Ñ„ìK¬o(·T‡¢p∫rΩpÜe,úı]∏p‰Ç◊˛·¢ö¢pÒûªpÒÂC·üc@·ﬂÀßÑ´Á£E\n,™H·^§&K§x´_§º…Q¥±©F¥±ôˇüˇ‚=ë /S—€ëznõHÛÒ_ëÀW§c\nÈFâ∂ˇëãt3ñD;élÈÒD˙7D˙7ëÅ4]dT©\'⁄˝¥N¥G≠_dZŸ)2[,ÌÁZàπà,/Eä,ø%â¨ü‰àé]älDvj\'D\'œ–EN#~\"Á#e\"óRëÀ⁄—È’XëáU‰±MK‰Ÿ)Ú(yûöyYyÖ.ãºŒ/ã|˘V\"ø†8ëﬂ;C—Y’Á¢≥fΩ¢≥áD5BQ–¡”¢†´Q∞IÑ(x‘[≤’XÚ…GtÓƒQhÚg—ÖEC—EïQÃAt•¬YçU¸œQårà(æ≤Hî‡*%PsEI*£¢Î∫ñ¢‰@∞(y Wî¬ä“êô¢¥\'E7z\ZEôx—Õ*{QñKΩËñ .Q∂˜eQ6 Pt˚6Ot˜‚V ßWÅ^¡˜ìDÃub¸ªµŒSÑvÎa◊aiE\"l1VÑmå·ÑA\"º÷:·^óà¢\\ƒfoq ~à8ØBE¸ÑqˇÊyë¯ø±Hæ≈äd\"Ÿ”˜\"y0Et?2Oîü¥Iîã\n¿@Q¡√\nQ¡¢XT(ô√wâ pM¢rFõËyLT¡*UÔl’^äÍ÷m’mJ’qïEı!¢ß‘Q}V‘4MÙÏ⁄\r—ãK|—ã«E/D-´oD≠ãZëÅ¢÷ñã¢∂{\0Q˚6∂®Ω8IÙÍó°®ÇuJ´EØœØu˚ûuè¥âﬁ$ãﬁL∂à˙n≈â˙Ω¬E˝Ö¢œ„/DÉãD√∑äÜÀîD#≤ü¢ëØøE£qä¢Ø·Dﬂ\"ô¢	Vçh“\\A4˘›B4ußhÍßëËáûìËá\\4ÃÕ(ÕΩ˜ÕMã~b\'EˇÂk°’U¥ˆäËóÉæhô\Z+˙˚sßËÔ\ZOÙÔdìhı˘&—ZM¨‡¯Q¨Äπ\"Vºı|áXÈΩ∑XπÿQºQ™\'VqâUÆΩ´)Dä5h√‚m\r∂bΩc\"±ûhãXO>$÷øc,6xˆTlÕVl∞ÿ!6RBàç◊ƒ{€ª≈¶˚PbÛ‚W‚ÉAø≈áÌˆãè%äƒ∂ã¡b;äûÿ^A*∂∞èÑàO,›ü¸`(vNˇ.>µ\Z,vQÍªXïâ]2Q‚”1À‚”œãƒÓJ/ƒÓj„b˜œbÁcb÷åÿÎΩôÿªµÿO^\"ˆW^—ƒ›oƒÅ¿@q`›^qYé¯‹_Ç8‘˛Ñ84’HZ…_P~\'Ô|/éVG∞Sƒã7ƒó7ü_ﬁ(é ÿ%æ2õ éK4«ëã„ø÷âR≈â·\r‚‰œi‚tá‚Ã∑⁄‚,√9qñ—q÷AMq÷Ò-ÚÒ≠2-ÒùÓ qn¥≤8Ø&Tú˜•C|óÁ,@≈Ä\'≈b‡Â3b∞πèäö√úˇâa‰1¨qNå\0åãQn˝b‘Ee1z,Wåﬂb$∆ﬂJ”úCƒ¥æòéÿ/f∑à9n{≈üy1?í+ïπâ≈ı9‚¬ì>‚\"|ë∏∏Ùº∏‰ﬁ]qy^É¯—%Ç∏RsH\\i«Wîä´ÓÄ≈Uüøà´F¨ƒ5˝ƒµfw≈ıg‚˙íHÒ”ùƒOõï≈\rËlqCÌå∏QÛÖ∏Òjá¯ôÇí¯yÂOÒÛA≤∏ô_\'~ÒPK‹zß_‹Ü§ã€∆â_Ó¸,~≈6wh¢ƒØuÛ≈]:‚Æí_‚wW ≈=≈˜ƒi”‚æ„BqøÜΩ∏?Á£x‡t∂x0U<¨èv˝OHBƒìCÒ‚…Ô(ÒÙ}éx6·èxvä*˛πè&˛i~G¸d$û\'zãÁ9ñ‚Öy∂¯WÿÇ¯◊}∞¯WıMÒØ˜xÒüKó≈Kø€ƒÀ\rÖ‚	ñ‚’æY…:gKâ¢=O≤±∆C≤qÍ≠DÂiàDÌàD¢vmH¢6‹/Q7;(QŒñlΩ3-—ÿd\"—»∞îh`çë1â¶zÉDú)—ø‰\"ŸÂ‘,Ÿ5^!1àÍóÈK$ªó-%{4HˆÃ˛îÏtóÏ{õ\'Ÿø:*1∑>!1œ∫&9\\xYbµ\'Gb%oñÈÆíKˇ&±ΩJïÿ>JÏ>òHéW¸ëú %ı7$éØ\"$Œì6íS˚êíS◊˛H\\´$.Uâ€=uâ˚àƒ˝€&âkR‚ıB&Ò˙a)Ò∂uê¯«ßIÇvJÇì-%!«\Z%!Â…ís¡W$ÁO`%ÁQíã…E©‰‚È[í∞¨$Iò∞NˆÄ â¬ÆìDïéKÆ`píËÇQ…µÉ…ı>ídß	IÍ˝Éí‘ÜI\Z(Ikñ§FI2é%ôÙBIfFíÖ} πU%…~€!πΩ[\"πC2ï‰ÓP˝Oí˚ …3Uï‹ç?#π˚–NÙ;(`%¿	d˜	LÔû&^ë¿3t%G§˙F	Z#CÇ∂Õì†”¿ÙØz	˙è´Àıí‡nKóã%ÑÑ˝BE¬»¶Iòﬂc%ÏÕ·∂!@¬ó∞3#%úÀéŒÉnCºÑ˜bT\"\Z9,√\r$r+{â	ì»õ7JÓùPï‹ãRó\0¢%	í¬€I·gI·¿I…Ìíí\"IiAâ‰·ﬁcíG˛öíG)	íä=Ø$É≈í™3ëíÍT\rI5¨JR{%MRøù\'it(ë4∂Jöz2$œ4˛IûùIûÖJ%Ì—˙íˆö§£≥§À˙á‰=F“Î{N“õh#ÈΩ;\"È7ûñÙ[`$˝—≈íœÄ>…@Êídtï/∑’óLºHí|/ïH&ˇH$?l:%?JÓJ¶è|óLCÓH¶Áù$3=éíYZödˆª¢‰◊w…¢çöd±ÿX≤8!î¸…•J˛6$+N7$´ù=RE˜mR≈@_©bòµTÒ~∏tΩ‚êt}œÈÜ6}©ä<O∫˘ÒîT≠°C∫%gY∫•Æ\\∫e¿]∫eºW™nº&’ÑJµÏR≠ïãRmÉØRÌ?=RJ∑t{®öt˚“g©.eìT∑î#’m≠êÍ›ÔñÓ|æOjî#›mÿ$››c.›£Ê.5y‚\'›\'JÕ§m“É≥~“CZR+µR+”©≠≠ë‘∂_(µüñ⁄J•éﬁjRÁ\'S“S?§ßø8IOOˇñzúòïz™ÊI=1 RØ.û‘€¥‘GÂì‘ßa@zˆ¡M©ˇsÆ4$‰õ4DË*=◊tG\Zz\"\r+	ê^öuìFlMê^ﬁ)çNêIc∑JcRP“∏…ai|Iöd,Mπn\'M[Jo`¬§È¶“Ùè\r“åÌbÈMì;“¨ãë“[<7iˆNò4˚V©4[¯Bz;ò+Ω„ÿ%ÕõdHÔÓÓìBÔ∆JaOiRTD©≈{\"≈~Íñ‚◊§Ñ#R¢SJ>W(•4¸íRmÔHiñVR∫gÉî!hñ2™<•L€V)ßrF Õﬁ\"ÂıçI≈ÁÖRÈ´©Ã;C*Wôñﬁ◊˛\"ΩøGQ˙¿˚ç4øzü¥¿tEZí˝IZj°\'-míñ)πIÀù]•èﬁÆH\rzH+N8K´˙•5˜§5QΩ“⁄‹[“⁄ôı“«€èJ1ë÷îKÎk9“ÿkÈ≥á2È≥∂„“Á#ï“ÁÛs“Êß|ÈPãÙ≈D⁄‚zP⁄˚C⁄ ~,m´\ní∂ıDJ€ÀÛ§/œûìæƒ §Ø⁄∑K;éÂJ;µ<§ù÷{•ùˆN“Œ/˝“◊Á•›xÅÙùNäÙ›•;“wY•ÔA;•‘ç§=4§Ø8I{I§˝ˆc“œ_ó§[ù§µ“°º“·áØ§£>)“±·Ω“	ÈòÙ{I:s,ùëñŒ4ºîŒ6kHgW•sKÀ“ü{:§ø∂Jˇ§HˇT™HW=ÆJWk”•k‚e\nÀXô¬j≠L˘x¶l£´≤lìƒG∂≈•T¶~ƒK¶Ny)S_x\"”\\-ñi©\r…¥ú*dZWA2-íßL[sA¶›Ô*”)ñm∑ÿ!”5»óÈ∫.”ØNï⁄¯…åï5e∆®\\ôIÈWôÈØk≤};5d˚o¯À,,≈≤ÉÁ≤ÉR=Ÿ°›{dñ±V2´êØ2+¯zô’løÃjû!;⁄%ëYøá…l`èe«≤@≤»=2ßÕ≥2ßÆpôãg∞ÃıOÊ6wNÊˆ˜ÜÃùèîπ˜‹ïy˛	ñy\ré |m4dæ∂|ôÔ-#ôo9[Êß)ëù]Ÿ,ÛﬂÒWÊ_•,P\rê†d!G3eÁÜ^…B„¬dÁÉÉea[ﬂ»¬ŒDÀ¬ﬂlîEûÃóE∂Á»._«»¢óe—3óe1¡s≤òÛ;d12¶,∂Ûö,N“/ãõ˜ê%$≈…ÚeIÒÎe◊1≤dpΩ,˘_†,≈ÀBñÀë•<Z\'K\ròñ•&\nd©T_Ÿ\rDüÏFüÆ,˝√9YvKñ\rQë›yxUñÀQíÂ>–êÂµÀÚzë≤ª\ZŸ]‹Iÿ£PıG…`ï2¥|UÜM*ó·Æï·êÛ2\\M≥åh§$#&fÀH¶¶2“My˜9*£¶ª…Ë¶\0ù9%£í1Ï:d‹k&P∆éˇ „ã”e¬*]ô¯¢£LúÔ$ì|Ä»§%s≤{íhŸΩk≤˚6ÀÚÈ…\n ~…\nœûó9$»ä>“e≈∆s≤GÅ¨‘ ´¯ˆ@V\rOî’X≈»Í‡;dèreO∑À\ZÇeç°≤∆†LYc”CŸ3∫äÏyæü¨µ„ª¨ÕG,kˇˆ]÷˛√Aˆ“,{IÖ»^∑‹ïu›hëΩΩ‚%{gsXˆn≤AˆÈƒaŸß≤{≤æC≤æ?YøbäÏ≥våÏ≥„ŸÁ•ü≤¡É·≤—lŸhÀ\'Ÿ¯SŸƒ.Äl‚{ÑlÚ]ìÏ«ΩΩ≤ôÂ≤üÍøe;¸dø7i»ñæ»˛∫O»˛˘8À˛ÖΩì˝ãî≠©ïÀÇÂ\n}™rÖﬂ›r•∂ìr•©OÚı}—Ú\r˘Ür]˘¶È@πJbº|s⁄&π*Ì≠\\µÚÇ\\Ìßß\\c]¨\\„∞ì\\É+◊L»µ˝‰Z9	rm#ö\\ª|≥\\«ì\\tCæ≠ÂÉ\\ÔXü\\Ô‘à\\ÔUì‹@mTn π\'7h∏.7\n*óÔ~ÛPæÁ–>πâN¨‹‰J≤‹T±Dnj∂*7ΩBêõŒ}ëõwç»Õø‡‰ﬂN»úIêî8 mY\'?4ıJn©ö#?åˇ)?b¥$?z≈Un∑˜•¸¯ï˘Ò¢øÚ„èÚÂ«1Âéº2π„`π¸‰6s˘…ÌŒr\'L±‹˘>FÓíë\"wiVîª\"!r7‚gπ{ :πóÎvπ◊›\\πWœ	˘Ÿrwyê’yP:BÙ^W¥‘/πÙXí”-Kﬁ,cûìáq”‰·dæ¸“€%˘•Ây§›:˘Â¶Vy [ÛÙÅ¸*f@õÁ*èÁ»„G#‰â\'<Â◊œ≤‰◊ã˜»ì∆Âix˘\rI´<√ﬂ@û1≤]~S9@~ÎT°<˚≈%yN‚oy]I~{ÿK~˚Ôyn∂´<ÔÀq94Ì¨⁄ì\'GΩ?#G#9rÃ∂Krlà¢€≤Né3çì„–9^+\'Å‰$¯?9Ø#ß¨∂À©.UrZú™ú• gÂ˜09ág*ÁyÂ¢Õ9rÒsEπ‰Cä\\˙&U~è|Û?Â˜ZR‰˜ÅGÂ~ƒÀ=«‰≈’‰%õ‰F»+äŒ +Í\\ÂïÔM‰U9æÚÍŸªÚöB¶ºñpM^˜≈]˛xËå¸	ﬁO^?ê o|Öí?Û{,vŒP˛¸Ôòº˘ÔUy´ıäºÌ˘y;JA˛Ú$Z˛Rb$ECÀ;Vè ª\"Â]˜WÂ›33Úw\nΩÚw&Ú˜ YÚ˙<˘£I˘á∞^˘‹ê¸„Á@yﬂÏ®º—I>†.àhñ*øìù°»á2ü…á»…Ú1ÚQ˘XΩ\\˛U€E>˛Ù∏¸õ—\'˘∑ƒˇ1\\ü·\\pQ\0¿)#IeF€(Jí»JïMëëJf¢…*…à˘ÔΩ˜ﬁ”*)ÖH•å¢xﬂÁ>øÁ|ª˜‹sÓásÛ;ø‹àÏúØÔúj‹–9≠æ™s::æs∫«ØÛªùqÁw÷ùŒÔØœv˛8µ‘˘#›˘ã}†sV£ºsˆ⁄µŒﬂÒÚŒﬂ°Œ?o⁄:ó∂Ot.•úÔ¸k	Ô¸õz†≤∞†Í…¨“Ú¨ö¨ñø¨Ó\0®U‘\0‘€E\0ç\\>@„É@Su†eΩ†Ì1X◊…ËºmË¶\\l‹Dú±l™≠l>|∞πD	ÿå90Rgå|ﬁåŒ·∆QÛ\0# ¿Ïâ`Kf`Kª¿¸ƒ[¿∂&`{©*`«ËI¿Ó]≠Ä›Ô\0ñ˜Ä\0+˝Ä’SKÄ5∞y˜	`ó]∞´\0ÏÁ„\ZMœ\0é¿°?bÄì¿pÿøp8ˇ ‡0pQˇ\0pK=	¯YdÓx©ﬁxiºÚ\Z\0^3¿që-¿\'V	πx‡C1\0¯Ë¸t4~EBÄZ	8Ÿ}pJ?pÍ^2 HU	¸úN‘úqK\0D›≤úõ}àŒÜŒ«æ\0\\á\0bî´±-@úd >Ú\0 æ¥O#.QòÄÑV\Z Å∏‹‹∏‚¶\n∏\"H\0$:Ï$F?\0$˛õ$ü˘H=s\rê\n=H€|p˝˚g@pêıa7‡&mpã⁄\0»µ‰TnÔ¸\0∏]®(»π\0(∏€(‘y(\Zz\r(ax\0Ó9]‹ø∫p_zP— T¸∞\0T¡U1l@’üx@ımC¿„ê/Ä˙à¿§\n†!\\hËø\rht¬û•fûM$\0ûó≠4£§ÄÊÒ›Äñ,[@˚Wu\0P\n\0öœ@ÒY\07\0íú@Zc˚@\0j3\0Äñ\0ÿ,\0˚\r ïHÛ\n\0ı¬]\0=î‡Ó≈x\r\0Çw·\0·ËwÄ»Eª=»Ú\0ÚÙˇ=≈‰∞´\0Eˇ.Är≠@ix†É\0î7è\0î8@wg&†ﬂÙ‡ÌP\r`dÈ*‡£Ó`Ùo `|µ\00±30ud`äÕ\0LÎŒ\0¶˜†ﬂ(`¿∑)m¿‚<`fòôY\0¸Ã˙\0ò~ò≥*\0,§î˛DÌ,©¡\0K†Ä%|‡Ô∫d¿ø˝†ä∑Pı›Pu—∏™h?P≠‹®6T\0‘‹U\\C¬\0µ:≥ÅÎoÄ:F@ùw!¿ıëŸ¿ı∑^7⁄\07¯@≥C@≥7WÄ÷+¿≠´«Å;∂Â\0w¥ÍwG¸\0Z˙™\0-Ôœ-{TÅ÷√Ä6’†≠o3–∂—∏œÍp_Ä*–°Â–·o–Q®	t\\Çù.\rùwáùCÁÅŒx7†ÀóX‡÷]†´›_†«≥„@œ≠A¿£œÅ«Æçè“˙¨Õ˙™Z}Ì©@øÊh‡	ı”@ó†T·Æ\rˇÎÜºúÜ\Z>Ü>)ÜJıÅ°_˛\0√æ<Ü_ÈûˆOÉÙÄßßø\0œX|ûÈ˝å Ò\0Fß≠û/^8Sº yå]G∆BlÅq;ÄÒNÀ¿xüb`|xÚñn‡U◊R‡’tC`bÛW`\",\0ò∫\nL÷”ØaÅÈPS`:≤\nxÎˆO`∂Íg`Œ…~`Æﬂ ∂ˇ~`ﬁÿC‡ùS•¿;Ì/ÄÅ˛¿¯	`ap)∞ÿy∞Ù˙#‡ΩG#¿˚ë—¿≤÷g¿2X˛‡%!≠XYˇX}o∞∫˛±Áq∑5Ò¯E`m¸z`≠<Xw3¯¨Ò∞I™æ\0ÛÅ≠´?[-Ø[agÅ/ô›¿vóÉ@Ïq∏\nà˘bwY\0Ò´∂\0	#ô@b>HöË\0R&\nÄTó √Ï êπÂêc‰\'âÅÇıZ@°„E†¯˚Z†,:Pˆ∑®ºΩÿÍÏ.^vK˛\0ªøˆ{º…¿æÃ!‡€ôo¿w≈L‡0,¯æy¯ûh¸P˘\Z¯QE¸»|¸TÛ¯y<8n®\ró,\'.ΩNU‰øŒdøŸÑ¢Ä?˜âÅ?œRÄ?…¿_˙¿Ÿ£oÄ≥oúÅÛ‘ç¿ﬂŒ~¿•¡‡ø{2‡r·	‡ ¡z‡  H≈¬§⁄©Œ^≠¢ÙÇVΩÌ≠∂É‘<ˆÅ‘ÖÍ \rÎêÜÌ7êÜ¥§Ÿ≠aà@k˜›È¥…@hèA∫øèÅÙBÚ@˙≤\Z–fﬂêa∆oêQ÷êiOhÀ#\"hã‚»¸ó»Bd°≤»;⁄⁄;	⁄vR⁄÷ì⁄÷o\r⁄^b⁄1ó≤ä~⁄…Ì¡`@{?lŸiÌ◊Äú,MAáÈç†√R?êÛe&»\0Y]\0:2˝‰\ZËrùππîÇ‹“p wŒ+ê«ôu èX–—‡|–—Aﬁ⁄™ Ô˜¡ üÂ>êü¢‰¨‰ˇyËT\nr)œÖ∏‘ÄBÆ.ÅBœÉB^mÖ}*ERZAg9X–πG2–9>tﬁj=ËÇ1t·Ç/Ë ÛÌ/(ñ¸Ô÷\0äÚt),î¥tŸ∆tº\rt˘_ËjÃËÍ≈P“ÂrPÚ9(\r	J◊ÃeÿÍÅ2\\Ï@YèOÄrBÏAπ)-†‹7†€\'â†º–†<F(ø˝ËNÔ–]ﬂPÌ,®\n*˛ïÇÓRAÂˇﬂ„¡ûœ†áEGAï{´AïQØAè}CAèﬂo’Ñ^’^≈ÄjÎ¸@u›PÉ∆NPy‘®]j§ÖÄö>AœsU@œYßAÕü∆@-\ZAm«(†ˆÁy†Wn@Ä8;–bÿJÃ@ Û ‰_«A¯TlÇØæBò”A»≠Ô@®´ªA®¨&V&·œeÉà–tqD™åë7ºëk˜Å(Ω`≠¢Dì¥Äòü{Alµß ∂V4à„ﬁ	‚jqoÄx˘@¸gM Iä=H⁄h\0í—’@ÚåEê‚:‘’˝‘ΩF‘∑˙Ëu™7ËıP#ËçŒYPˇE®_1\Z–Z\Z $Äµ¬AÉ5A√DS–˚π –»›À†èØ\Z@£Q†Ò<h¸≠;ËÀ’$–∑:4Ëª˘C–wÓ\'–Ãj#–œ(]–\\ÆhAœ¥®\r˙˝-¥îπ¥Tœ˝KÅñ’>Çñª\0†ï\n– S_∞ v6Xe\rVm<^Ωæ¨vÒ=X›8º¶+ºnm9Xß\r^ø6º1&¨oπl∞·xuº§\0õÑ±¿Êá¡V≠`ãïçbŒ]˘‡ùì•‡››/¿ñ¢£‡=˚÷Ç˜ÃÄmoËÇ˜=ÎÔﬂ}º(l?| Ÿ|†!|@vÏhsÏîÊ	>Ú‚ÿ›ˆdÉ=j¡Gs^Äè~æ>~5Ïm‹ˆÆ∏ˆ&ƒÉΩª™¡>!o¿~ç%‡¡\'Hﬁ‡›¡˛Öæ‡ s)8(µºÁ2¯å[8B˝8≤˝\"¯ÏÈeŸ;pT˛ 8zß8˙˜$8>~¯RD3¯ä…	p“…’‡‰∂)päö	8eáúrı8}˝3p˙≈ã‡t¬[p:9	ú?ŒÃ˜gæ#Å≥Æ—¿Y/ŒÄ≥Pâ‡,ÈvÕáÈ‡[Ê‡l8;Î-8\'˜:8áY	Œ}1Œ]©\0ﬂvÅÛ†‡{°G¿˜·¡ïÍ	‡J«ipÂk}p’ upı;pÌm0∏∂›\\w[\0ÆdnHõ7‘‚¡OU˛Çü©Éü˝ÊÇõRﬁÄõX±‡¶πVÛ7Z‡f„/‡ñ≥ì‡ñ®fpkÛfÀ‰c‡óy˝‡óèí¡: pÁ[0‡∂ÑÉ¡kÆÉ¡Ôª¿ê¨Û`ÿN?0\"¨åƒDÄëØg¡ËÎ/¡ÿ‚h0Æä∆Øãì/SªÎ¡¥}≈`ZR	ò±©ÃBÉô)]`÷‰0ªnÃ;•ÊIOÇ˘U`~X(òﬁ<\r\rôÅ•¸4∞t˘X∞,◊mw]IwU˝\0wª:Ä˚˛æ˜;ÿÄ˚IP¿Ûz€_¡oˇ¨qó¡#·O¿(C‡—€˜¡ü4ı¿ü<±‡âm™‡/°L§\r¸ı‘◊˘∑g˜^¯áJ3xÊ†\0¸À=<{ûkWˇ}d˛˚1¸œÌ¯_˚??bxYÂ\nxÖæ¢Ç)Ñ®∫hAV›nÜ¨í@V„í!jq~ç#/ öÉ!ZwaêµÍ»:SkàŒ”Ûê\r*!∫≥¶›9\Zd„®>ƒ Ω\0bà(Ñ\'˚BLK ¶·\rS˘ZàŸŒLàŸ£)»ñG\"»ñÍ~àE<≤ıë6d“≤K”≤+‚ƒ2sƒFŸ˘øÎ≈êΩ÷w!vŸ∂ê}Ô˙ ˇÆÖ8˛ÏÇ8.’@ú3m .Î˛Á˜‚“SqM)Ä∏¶∂@\\°·◊˛vàªÊQàGÎ*àvƒ≥ò9\nñBº>ÃBé©øÜxﬂNÖ¯;Ò…Rá¯vºÉúê˝Çú¯™9È”ÒoçÖ¯Cü@¸Ai¡ê–»\\»ôo …êàß\"Hdf$Í√_»ı%»–wHlO%$.¢˜È+$>UrÌ˙#H“’\\H™–ífΩπ~\\r=i$£OπÒ§íy¸‰ñœ»-t‰÷‚OH∂V$ß∫\0r{ıyHﬁﬁãê¸•SêÇHm»›4*‰.\0)íÔÑî<5ÖîƒB ?èC*iß!U»t»#˝UêÍ	‰ÒÉÁêZ§.Ë3§Óˆ-H}·IHC@	§!ÅyNTá4W–!/Ç∂A^‘’A⁄&¢ /õêéˇ{–9í∏$@Äú˝ê˝	®q\'û·AË•@–!ù“ùe≈Ê\rÑ\Z›	°ãÄ0ÓeAÿﬁUŒÕQ˜ú-Ño*ÑØk@DiG R€à‘ÂDÈÖ»∆ ! ëwêÓãêﬁõ,Hﬂ•sê7˘ê˜v@»à≈0d‰ÚA∑2∫ùM{Ì>˘t˜\ZdLCÛ‰B&Wl Sw} _O¥A¶lÖ¸%AfL∑@~ˆ™C~Â ø*«!≥‡ê9}3»¬z+»ÔwG!Ω À∏êÂÀ!êÂi»Úb)dEUQ@U∂lÑ™ƒî@U<†™c†j◊f°ÍÉPıèl®ÊvË⁄ßÅPÌˆV®é~Táe]ÔÛ™∑%™g[’˜…ÉnvHÑnÆ@\r˜‰C∑‹çÅnyIÉögÓÄö‰A∑Œ\'@∑móA∑•˘A∑˝9›æq+t◊◊)®ï÷)®’Ú®µe,‘˙¯v®uÒ>®5\nµ˘˚∫g[tÔå?‘vW7‘∂Ë‘ŒÏ‘Ó˛[Ëæ≠Â–}B®}¶ÙÄÕ*®„]G®K»®À+®”z§ÿÍZ⁄u°¥ù–£Îb†GC“†«t–cØ@Ωc-°ﬁπ∆Püª.PﬂgfPøìõ°\'˝NAOÅﬂ@˝üf@˝ﬂã†!G†°y#––áª†aoº°·–36N–≥K[†Álg°—zC–hOÙ|≤\n4∆=\Z„Yç˝ÏΩàaA/íB„z∑C„˚â–Ñ—$ËÂñ^Ëï’Ë’º1h‚B+ÙZ¯ÙZ‚4i˜[hR·hr»7hÍã(h\Zºö~ŒöΩ~	ΩiÄﬁÏ«Asˆ∑Co;@Û÷\n†ºJË]≠IhaΩ¥»cZÏ¶Äñ<|-y‘-i[Ωﬂ∏-ürá>jÜV¶ûÅVfB´£–j≤¥Fˇ\"¥Êﬂ}hm]¥ˆU=¥Óv¥ø⁄\0⁄	mdNAü~úá>∑5Ä>œ)Ñ6#Ñ–ïLhã∂\r¥•3˙‚⁄zóm≥˘mûá∂ﬂ/Üv∏éC;.ÏÑv¶p°–’%PÿÖüP¯»c(*„£B±y>P\\¿k(˘æ7îzi\0J˝pJ?u ààÇ≤{B9ﬁÊP^˘~(Ôy\rT®æZÄä\\†‚ÊPÒg\'®4r*˚bï_ﬂUﬁAª¢c†›Õ–˛AÙ›ï4ËÂthàN\\9_˝h’\n˝m[	ÖéUBøDC\'5;°ìZv–…,\0tr˛*ÙÎ„2Ë˜5E–˜Û°≥„O°s’û–˘};†ÛÒ°ãË‚	Ë‚\\t©ƒ∫4 Ü.}çÜ.˝z]f‰AW˙-`™hLu¸+Lu≈¶ﬁ¸¶°±\r¶≠\n[„˘¶ù·”¶v√¥?ﬁÅiˇöá≠˚\r[,∂~—¶Á∞¶Á≥¶˛f–u∂ÈË[òë„oòÒs\0Ãƒ„*Ã<Ó5Ã¸∫fû·≥HÉmÀ€€EÇY∆˝ÅY”aVmﬂa6˙¶0õga{“Å∞=Ï`{]E∞Ω‰k0€˚ü`v‡ÿ~ßBò˝Éò=NÊ–\\;¯Ê)Ïê¯=Ïölÿa√xÿaÒò≥Z ÃyDÊ¢≠s·≠Åid¿\\q⁄0◊ØÊ07Oò˚É≥0è»òÁrÏÿø.ÿq«0ﬂøa\'∫≠`˛XÄG8,Hc‚˙R”µõáÖÌwÜùæƒÄù9tQπ1QãÙπ;[≤ã:»Üùõ0á]H÷Ñ≈ÈÅ≈T‰√bÍ¡.\nŒ¡‚ª√aÒSÀ∞ÑºÎ∞+;ﬁ√UÊ`âÊ«a◊vmÉ]ã:ªˆı.,©K=6Àx„ªÒ∂v≥=ñs≤vª™ñõª„éÜ›A≠É¥∞a®vX¡«µ∞ªiPÿ]æ\r¨¯I!¨d≠-¨t \rvo=\rVv¡VŒ€	{‡V	ÛÖUiÿ¬Ÿ`èj`èÿ¿j@A∞˙y}XÉÔ\ZX√“Nÿ”∏Xÿ”á\r∞Á∂ç∞Á!ë∞fñ¨e}¨ıâ\ZÏeˆAÿÀ™–é\0%a†öiÚX£ˇÜπ~Ü› Ü·∂Ë¬ZÜ0¸K1ÆF ÖQL´aî`Ù∑Ø`åçœ`å‰Ø0¶ÊuÛv1å›◊~<	æÖ…ŒSa≤è”0‚1LÈπS.ﬂÑuó¡∫`}õ∞æ◊i∞◊ŒØa˝õºa˝ˇ÷√ò7`ÉØZaC‘ÿ∞)\rˆﬁ46≤7ˆq’>ÿËquÿËe8lîŸ˚‰ô˚|≠6Á\rØ\\õÊ¿æ¶¬~<É˝®˚ıõ}][‹7˚ßÍ˚W`\0[6î¬VÜ®p’R¯jcc∏fe\\Î–I∏÷-\0|mf*\\;◊˛z\0ÆSl_ü∞Æ{<ÆÁ,É8ß√\rﬁáoZ_7âÉ¬M]¡∑av¿∑;a·€?¿w0W¡wE5¡˜‘0·{j}‡{\Z0=Ô^¿Ì¸ﬂ¿ÌBø¬˜Ì∞ÉÔ_ﬂÓáÔg™¡ÌM	ép”WÉÓp«ÈY∏So&¸pP/‹ÖÛ\nÓ\"mÄ…˝\rwo¢¬=çepœ÷µ£Î∏cw‚·ﬁ´0V_‡\'|ü¿Oj¬OyÜüzΩ8ÌøTx@a<–“òzX]	z\n…táá`¯ê/Íê?Ω0æf˛p\0~∫-\r~Êp<“p~˛›,¸B„/xåf<&ÃÛs/<˛»<>^~	>\nOò¨Ç_s¡ìÌn¡SF°4Swx˙ü¯ıd<CÛ-<cÛIxFõ=<£„9<c∂~£%ûπñø)pÜgÉ·9ÁX€+nºÓH¯ùuO·wÇﬂ√Ô‰øÖﬂ!è√ÔH+‡:RxÅ„=xë∫-º¯¸C¯=kUxŸ≠Û≤Gª·c0¯√ºÚ˚AxÂ/{xmÁAx]E=ºAá7èÑ7‘√ß~4xSW	¸πÓ*¯ÛﬁxKD3ºÂa\nºµÿﬁ∂Ωﬁ^ˆ\Zﬁ)€Æ5ÄÉròpÕ{pË)∆OÇ#ö4·ÿ;Åpº†NH√âäkpäçú ˇß=NÑ3Rˆ√YªËpkú]\'Ñs»#p~”Y8_˛.∞√EÜG·bÑ\\bïózµ¡eN¿Â&pπb/\\¡Ö+XKpe¢º;€ﬁ˜8˛:£\0ﬁü≠ÎoıøD¯∞E\0|Á	A¡?úuÅèöÓÅè:√GkO˜ˇ¿?=¸3rÉèmÑè\r∂¿«Ü¥·„[∂¡«	>/±â/…*/ï÷)ã€©q\r¯Ù÷UÈFôì9ªy¯‹É¯¬W0¸wS=¸˜ãıﬂø·\n¶‡∆˝‡K÷5∞B’1°Ít	°∆ÃChÏ}Ä–<Ç@¨Òt@¨u{ÉX{Œ°≥µ°˚R±IÛ\ZbìÄè0\0\"Ly∫3”LÑ˘æIÑy¶a˛\r±≥c±˚j%¬“{aYÃ@X≈ÄVÉÛk,±7Ú!¬Æ]a7t±œ$±Ô∂&bf±ˇ0±ˇÿ0¬˛›2‚¿\n¬¡∫·∞ˇ¬—±·¯8qhì¬	bã8\\¨èp9ºÄpôa#\\=«nËÀwî·aπ·Q1ç¿?Bxp#G#\Z«:˛ éü_èÓ\\A¯ÿ!¸Må˛¥	ÑøË7\"@íâô√!¬è9!¬°[ßèß#\"v\"ŒVT ŒBb—Î1ôàƒD‹WDº◊FD|+\rëpuëêv	q•Ó-‚Íz)\"Qu\nqm8ëtˆ\n\"5hëZ÷É∏nõå∏ﬁhÄ»ÔDdu≈\"n&»∑W#≤„Ø#≤Òeà´hDŒæ\ZDé„SDÓYMD˛¡>D¡œVD—ﬂ!Dqˇ\n¢dÕFD…Ã‚æﬁEƒ}Y¢‹UÇ(øÿÇ(©DTD#*Ó=BT∞;vnB<@Ø êLïÁ#U÷~àÍCÔèûG<ˆ!jÌ<OÆe!û¸*B<›˙	—‰vÒ¸Í¢uG!¢¯—bÖxπåx9u—Æ6Çháá\":û|Ct0^#^MZ#Ä\\º#fB¿ßàû‘iïC†eÈåG≥2â¿øì#àˆ`ë5é ◊ÏGP\"’¨ÇU~¡B|D∞‰kú…]ÓmÇ+ŒE(Xﬂ†¡œXç‰´#Ñ°œ1Ñ0l!Ã<ÇêÙu#§Ã\'Ÿ÷€˘ºBÀF(»G]ôNàT¢w¶—7ûÖËw:ÑËü,AºıÉ\"ÜÏ›C=ƒ{fbpÒ!”\nÒ±:1:IGL¨≠CLJ_±˘àØ”‘ªàÈıàüõ à_ŒÔøû≈\"~ΩE¸¶\"~\r\r fÔas4ƒ‹◊}à˘Õø?x ~O∏!Û[ç´€+¸§ F#§öÚ;R”#©u»©ïÊÉ\\ªŸ	π÷1\Z©”w\Z©G)A\Zp©H#üe§ÖÉrtπs¸r˜¢“Ê¬u‰ﬁ\n&roO“vw“Ó\0iÁ?É¥ÎçAÓ;GÓﬂæπ_â¥˜Ωà¥ #‡HßŸ<§Û¬§ãØÚàK-“ÌW“#ÜãÙ¯=è<Ê>Ñ<ŒWGˇé@_.Ez◊+ë>≥Øëæ÷(§Ô«§ÔØ»ì€Ωê\'€¢êÅCd∞\"≤>\Z˙&y∫·ÚåÜÚÃË+d‰yÓÌd¥yŒ@∆•°ëq7cêÒô„»¯«e»K6»+3˝»´êâ-=»k˙d“π$d≤ø;2πªôº¯ô\n3B¶1ÏêÈ¡Ω»Îë»Î3+»€3ë7êëôW˚ëY†\n‰Õ?d∂ÕgdÆúãº›ÖÃﬂ°ÖÃØ?åÃo9Ö,xØá,4ˆB]9É,vûGñÊ∆ KÔÆAñ”ΩëÜ1ˇ{ç|◊YiRÜ|ç|E÷©¯ ÎÎê\r˛Ü»∆y)Úyg5≤9}Ÿ‹öãl]\ZB∂ÕAæ¸€èlè≠C∂Cø\"_¶\"{JêÄ‡Hp^RBB(\"$4Î&ˆ¨\0	C‘#*NH‰O$∆Â*«EbrLêõ)$ΩIåd|ºédÓA≤´mëú>H˛Âv§8h	)æÏÜ<Åî\0ﬁ •ó3ë“‹áHiÌ.§îÜî~˙ÉîáÃ#Âä|§©ÏHBvyÂ ª„\nêØØë˝Œë»∫1rDæsoAæ◊\0 Gˇ?„S‹I‰∏Ér¸‚M‰Ñß˘•äúDÔANE\"øÓ»EN◊\"gŒsë?\rÚê?„‡»ﬂ_1»≈û%‰ﬂù»1(’KîÍ«\r®UjßP´<QjA1(u•qNÜ“HWCiÆ∂Bi¢ï®µß˝PkŸã(ù3F(ùG€PÎ/C≠ÖZ?Cm»ØCÈÏBm4˝Ñ28MGm“˘å⁄Ù‘e|x5 8∆ezËjÀ!‘ñ˚I(}mî≈æÁ®Ãø®]/€P÷˘◊Q÷2CîÕªX‘û®u®}´ï®}ﬁ£(G∂ÍP„Í–‹\0ÍHI=ÍHø ’˙; Ìd -ÜrÎoGy3QÌP«¿(ﬂ\'Q\'Ê&QßﬁD˘{ÜÚ+PÅ©6®‡£GP!˛â®å*<\'>?Ñ:ÌÀEùÒyÅ:Sµ	u¶¡±|\ryÀuÆ/∑}«ßùÖäª˜\r˜≈uâ∏\rïêΩ˝;Pó=V°.wÀPW¢MPWÀ≈®k⁄£®î“T\ZA\rïˆÀu˝Ü*ÉıïÈÒïuÊ2Ífd$Ív›?Tûı-T>Ó2*üﬁâ∫ÛµUtoUÏÎç*Æ_Aï˘† .¥† ∑®† O°P}e®õåPZ1®ák‹P!ì®Jv	™:2U›@=n.D’l–@’G’¥Î£jK†jï~®zH)Í…ﬁp‘W$™¡õÉj¯Üj‘ºäz∫aÍ)¥\nıt`ıl”qT”¯Íπn™ªàj—‡¢ZÙùP-É[PméRTu’![BΩ æäÍ‹¥Ä´¢@GÉQ {ZçÇçÍ†‡:œPâ\0¬R\rÖ6mC·∆BPx’Q˛®>\nˇ˚!ä DÄ(íKäº1EÌ@Qg◊£ËëPÙgps€E´0\0≈‚>EÒ,>†O\\P¬\n\'îp~%:±%æß@â∑¢däî\\π•àË@)¿6(%™’’ÿáÍ‚<Du{¡QΩ‚M®>\Zı&¥ıÊÙ$™_´5†VÉ\ZPèB\rnÎA\r&—PÉÕY®w˜H®wø™QÔ≤QÔcsQÔôP£ù:®œï|‘Áa jåæÄ\ZW±A}ë£¶rQﬂT≥Pﬂ”7£fÍßPø‚ô®_	4‘¨6ıªuı\'(	µt.µºn/j•ÂZ%Õ≠Ç^B´Z%¢Wqòhu©.Z˝Ô{¥ÊÓçhMÀË5ï«—kÌÇ–k_ºAkª|FÎ@—ÎøΩBo:RÜﬁ,¢°çék£ç¶ﬂ¢ç=—&∏:¥È™¥i‚=¥ôA⁄¨⁄ΩÂP	⁄|Ωmû3Ö6/´G[L%°∑Æ±Do∑}àﬁ˛&Ω#Î(zÁ]?ÙÆ˜ÙÓ¬áË=J9zogz/È:⁄Œˆzˇ„mË-pÙÅohá_√hßx5ÙaÏ5¥Û⁄ªhóèÙë±5Ë#À\0¥´°5⁄’+Ì÷dÇˆ °èË†è&G{=ƒ†}©h?◊TÙâpÙI\'\"˙Tv8˙‘‘¥ˇ˙X¥ˇ#:p¨$†CFÛ–aœ–ßµ5—ßˇ¯°#ã¬—Á\n7¢£ØΩBGˇ3C_pÀD«öF\'Ë≠B\'¸ƒ†Ø4nC_i\ZA_£ãø°—ß–IQéË§€ÖË§≈DtZ˚Nt:πùæGg®üFg‚^†oûç@ﬂÏ⁄ÜŒ@gcç–π∂|t˛√3Ë;mbt‚$∫(L]T\ZÇæW&@óOy°Ú§Ë*ˇ6t˝\0˙(]]…B?ﬁ-G?æ>áÆYLG◊ü)E?QúA?´1C?ø˛›‹ A∑®‹Fø8Én§°_-|GQÎ–¿”h∞€U4¸ë\rØπåFj8°ë˘›h4\râ∆4=@„4º–∏√˝h£M\ZCìﬁoCS“o†È–4Îy/ö{∫Õ_˛é\0Í—Ç∑Ø—B–(Z§˙?∆3¥∏3\n-9ŸÉñm*D+X{– P-¥íı›≈˛åÓ.çDw∑¢–=ãzËﬁ–}°çË˛ìõ–oëtÙªÖ!Ù˚0#Ù£ÕËœèˆ£?◊—–cˆŸË1OÙ¯N\rÙÑ…iÙ†5zJ•=ïSÉûzàD∏Ñ˛÷ãFœ8ÓAˇ\\Aˇ\ZBœ¢°Á||—suNË˘åËEÉΩËEóÙø…+Ëï÷Éï0/Ã™cZò’g∂`‘Ï‰ıDcåzcfM£’~≥÷¥\r£]Ôç—~ñÑYó)«Ë¨#c÷ü	∆¨˚à1®´¡l\n”¬läYèŸîÙ≥Y˜fsn0∆¯U7∆‘Ô7fÀ`<∆‹1\ZcÓÖŸ\Z{≥UPÅ±4ÃƒX&\\≈X≤?`¨b¢1V\\ fèE1∆ˆ*≥œ≥\Z≥üõâ±Ø‘√}ä90fâqPƒ8Ï¡8‚‚1áRñ1áàg4∆˘«måã≈åÀi5ÃëEå´q-∆’≤„~HéÒéÒ¯ÊÉ9jdà9VÎã9ˆ7\Zs‹osú„£õáÒ±πèÒÒˇãÒM<àÒ≥Û¬¯]0≈Ë0ÒÕò¿üôò‡œ…ò–⁄Lò≈LxÛ^L8¯-Êˆ&¢Ê&bÂ>&˙Ò&Ãyl\0ÊBü&FØ[cäâ[∑ì((≈\\S?Éπ÷äI:˛ì|,ìÖƒ§ha“m1È…«1U17˙„0ôz{07o217«œc≤ãbÚwÃb\nëL!˙¶êÇ¡møÉ)⁄ÒS‹áƒî‰∂aJ™1e1ó0eø§òÚÔ0–VÃÉËÃ·vLÂñOò*%\nÛ»âyƒ&c-_∆<>ké©1Ëƒ‘,cjÓ˝≈4Ï⁄ái¶bûyˇ¡4ÔÔƒº∏˘”v›ÛÚ`9¶]\'”N;ÑyæxD¿\0–5‡¬DÔ;rzÈÈ≈@CL10n59ûÖAy≈cPÅ^T,	ÉäﬂÖA´¸üñ&lÉ˘‹ä¡¸˛Ö¡˘bp9”‹êÜ`Cäªã°Ùl∆–_`1Ã-NAÜOÎ«çë„{å¢¿»í0≤≈;π‡;¶Î¬kÃÎΩyò◊M+òI8f8“3¸a7Ê#íé=à˘ÑÿÄô–˚à˘Bü≈Lû˝ÅôDªc¶Ú]0S=çòØÓNòÈÃÙú\nÊ@ä˘uÑ˘ıfÆáÄY®¬¸˘9èY¸€ÉYn\'`ñ∂òÂ7w0+‡	¨Í˘µÿU∞´√S±ÍO‹∞\Zçx¨ÊqvÕ±Cÿµ}&XÌÕ#XÌñÿı\rçX˝öOÿMúl¨°∞kºAÅ5.:Å5˛≤Ç5E≈bÕ^¯cÕsècÕ—]Xø&Ï∂ NÏˆÿÔÿ‰Àÿ]∑z∞VK∞÷ªÜ∞÷âNXÎd¨çd-÷Ê#ªØ[é›oÜ›?¨Ö=`¡¡8ÊÜ=Ë¥Ñ=xÌ:ˆ`˜mÏ¡ﬁ3ÿ√yôXÁ¥:¨3¸1÷Ö˚Îz_ÑıÃ\r≈”æé=Ê{,‚\"ˆ¯9ˆ¯≤:÷ßèé=∆û®≤∆ûú2«ûÍ¥«˙w-bè`C‚ó±°Í-ÿ0\Z6,Ä\r√¥cœ8&b#úl∞Ω%ÿs˜8ÿs–$lÙ	ˆ¢b«-¿^Ú¬^J∏éMH3ƒ^9¨ãΩJr¬^ÀXÉM˙méMæÎäM.˝ÜM{ÌèΩæ\Zõ—ñèΩ1põYñÅÕÈcsÛK∞πmØ∞πÃzÏmŒUl^‰nl˛∞1ˆø[ËÅ-jªà-¬a±˜÷`Ô/aÀt>cÀ‹Õ∞Âyll9PÜ≠»*≈>(Ωç}∏~[i!¡V%?∆>ﬁ5Å≠W_ç≠Ç∞œ»!ÿÁ◊∞œ≥Ç∞-¶ÛÿñÃªÿVù|lke<∂≠—˚“·ˆe¬KÏKÏ´Nc,@ohıtzécb°áR±PüﬂXX¸f,~ã ]ÉE…wa±/À∞XKH¯ã%∆’câ¸X“‚0ñ\"≈“ˇƒ“~∞t\r,„~ñ5ºÀm5¡Úºj∞¸∞f,	+ºüâ¡ä>Œc≈	_∞RM¨Ù™\ZVˆ)+‚ÇïãÍ±äh¨QéUﬁ6∆*;ÿÆ“9lwƒlwc\'∂g~€w‡ˆı1vÄ$≈0¶±&ˆÌΩ0Ï€Ïª15Ï–ÿÏ˚sÿëv‰π\nˆ„ôFÏ«œ=ÿQÉ5ÿâè´∞_©ÿØt∞”«*±?◊˝ƒ˛ƒ+∞s”≥ÿﬂVÿEë5ˆo”Ïø4uÏøábÏÚë≥ÿÂ!Ï\n¿ßR9àS’⁄ÇS}îå[e3éS˜l¿i|J≈≠y=É[{Ú-N˚ÀúéXÄ[Øgç[∑Ä[OH¬Èî‚Ù(H‹∆5Ÿ∏çsÜ8˝´ﬂqÜN`úqg+ŒDﬂ∑Eå€¢Øä€ä≈„∂í÷‡∂_Q√mØ„‡vcqªÖqño%8´oWq÷	wq÷b/ú\rä€s¯8nè◊n_Æ>Œq≥)Ó–Œi;w∏Ó!Œ˘i:Óà^.Ó»ﬁ[∏„ãÈ8Ô}ªqﬁ«˜·|/„|Åπ8øëÉ∏ìeop˛Ú\\Äˆ.\\\0*¯Ñ\">∆	√q¡=wq°wv„B;2paz@‹i´´∏3,\\‘¶\\t@\'Ó|PÓ|ßÓ¸dÓÇƒìØ¿≈≠n¡]v≈]Œ[çªöÆÉKlv¡]ªˇól§çKNK¬%ﬂ˚ÖK±ÿéKﬂxó^óÇKﬁçª~˝Ó∆`.2ÜªYπ	ó›wóÎÔÅÀ7µ∆Â€¬ÂGj·\nüò·äçÆ„J&∫peæ©∏≤;\n\\≈ñ6‹É£T‹ÉS˚pΩV·*O„™¥}qè5ˆ·ÍV©„Í±Ω∏\'„˙∏Üm\\ca7Æ∆¿52Üqœo p-Ü0\\ÀÆ\\^˜‚◊7\\Î⁄^\\õ˝Q\\õd\Z˜ÌÅÎêm≈uﬁp√RpÄR(Hd· «pPã˝8Ë´,bÊ!’?ãC®≈añﬁ·(Q«qîºì8ÍQéæ◊«ÿÓçcZPpÃîFs1«“[¬±6¬Ò”ﬁ„¯≈p¸«N8ÅK=N,]Éì(<q›n!∏n+\\w“3\\œd\rÆ˜◊(Æ_·ÜÎ_ö¬Ω=t˜ñ<É=»¿çk„∆d˛∏qv8n|ÖéõË}à˚r&˜Ü∆}ëg‡æ>Ì¡Mü£‚¶o\\¡}ª2Ñõ˘∆˝TG„~∫G‡~F∏„~ÊY‡~\nÓ·f-ˆ·f/U·Ê¢pøpã&c∏≈}À∏≈áÜ∏•?œp+“p>xï2^e—ØjsØñ˚\nØ6°Ç◊∞∆kN¬k‚«k.•‚µ66‚µ ßÒZÛ0¸∫Ä0¸˙,ºÅM!~S◊#¸Êtﬁ–˚(ﬁËË ﬁ»Oo∂Üå7õc‚∑4ﬁ√õÔî·Õ‡∑n€àﬂ*D·∑{F‡∑3≠;4T;≤e¯]é_Òª5CV‚\nºç°\nﬁÜüÑﬂì∏å∑≠5ƒ;TU‡è˛∆;˘X‚]té‚è‰|¿ª.Á‡›ŒìÒn#Ωxè?Òûû¯£ÛxØÛjxØIG¸ÒÉxØ8ºœÒNºØ–b]˛§÷A¸…›F¯ì¯-¯Äı=¯ ”)|–-|˛<|]|ËÌ%|ò™->Ïe	˛ÙÅ\r¯”agÒß…X|âè<Ûµf>Íe˛‹|Ù∂\n¸‚(˛b‚N|‹N>Œ5© 	ü∞?üêΩ\Zü	+)¯Àß·ØX|«_Òe·ìL\\…áQ¯G|Ü¿üE∑ƒÁtÊ‡s§©ˇ´∆Á:≠«Á\r‡¿WÒw\'úEQM¯‚¶|iÜ˛ﬁœB¸}˝õ¯Ú‡z|˘›|≈Y|’é/¯*ó\n|ïk&æ\nÜ∆W	ˇ‡›~ÉØûñ‡kÀ3Òu^Q¯:òæÆÖo§º¿72ü·yñ¯ßßjO√KÒO€ ¯÷óõÒmc™¯∂ü^¯ó∂¯Œ	3<¿*‹mááﬁ‚aaÕxD§è»¡#⁄∂‚Qâcxt…4û∞\'\rOjW«ìœl¡SU–xÍûP<ı/O”w∆”|‚È©-x˙J7ûYãg¸P‚9vx^¿ºŸä˜,„•N~x)‘ÈûxŸ[^¡Á„ª2óÒ›N„{vr=ÆüÒ=c%¯^p1˛Õ>w|Ò-¸Äõ˛-Ô˛Ìk¸‡ˆ€¯¡·\Z¸∞w\'˛˝Í{¯ë’?Ò#≈b¸\'›É¯œY±¯œùó„ﬂÒÁÈ¯/áû‚\'S∑·ß.o¬]-¡Oœñ‚ø¿–≈§ÜˇQu?ì}?”˙øPp\Zø ±¡ˇÒ}Ç_ås∆ˇµÕ√ˇ≈]∆ˇ˝â_˘ùOPybJP}\ZBP3t\'®+a-€sÑµó‚kìl	⁄ü?÷ù8AXøˆ!aC–=ˇõ†õ÷D–Õ€B–3Ùﬁi6,ÙA…˝ô,¬¶€@¬Ê¸∑√u±√ÙW√‹iÇ—ö!Ç—aÇ±˘Ç1·¡xÏ¡dEÖ∞≈1ò∞•Ê2¡‚V\"a«Íi¬ÓÃÇıÉ¬ûÉûÑ=ïIªOÜ˚¯Ç=™öp¿@Ö‡pÉApêÉ	ﬂ¢¥áS?\\›˛˜Ú!¡›f¡À∆á‡Â”KJi\'[»$_sòp|0ã‡s‡¡ßfÄ‡;\ZEÎN#úÿüE8u‰!®µálÊC›ïBWNõÊNÁÍNœº\'úŸ¯ápfÆùÂ∫H8Ø’@8[BàBb≠G±àèÑãµ<¬≈∫(Bº)!~4òp	dJ∏´F∏ZSK∏∫êKHﬁ„IH}2EHãYG∏˛<çê°\ZK»ÿ^O∏±$#dVú\'d\"b7øù&dØ9@»~æùê›fE»)8O»Û_C»L\'‹1A\nwû&≥≈KxB…•ÔÑRBÈ-6·ﬁ?¬˝û9Bô…KBŸÆBYù:°ÇD®Ë!T,~$<8¯ìP•jBxt$à8>ñP´5K®ÕﬂD®w™\"<{J\"º((\'¥Ó¶⁄∑ç⁄‹´.:É	êùÑéÅœÑWóv\0ÉÍ¿‚Qê(&Äo	‡ãC∞Ï	¿#@>d‡?-Ë_÷<†çÄüõ\'S˛àÌMÚˆs j=ÌçÅû„E`ÆÀ%∞ k	Ïáöé˙ Åg◊G‡„∂Ñ÷C!Kõ ~É%H´Ô§Ω˚	2OB◊√€Ñn+°sÜ–„¬!ÙÆÖzO&zS>ﬁL~%ÙØ˘H¨M%º{ïJ⁄D™˝FVﬁ/ã	}ì	ØIü÷<&|\nR\'|ÆÒ\"å\'®&ª˚Swç	SÃ≠Ñ©ÆWÑiœ_ÑÔ—ÑÔwÊR\n	Û\rﬁÑ´ ¬¢∆_¬_≥KÑøizÑˇ∫ÿÑÂ‹ﬂÑï•)‚™kAƒU%«âkÙäâkÙ_µDp¢vc\rq˝^=‚ãh‚Æq√T\nQ7{Ä®~à∏±TN4Hb\rûV7˙\rØxç\Zoçùà∆ûµDs;¢ô€¢ŸÕ1¢Ÿä∏µÍ\Zq˚ö‚ˆSsDÀ<9—{õh’jJ¥ˆS!⁄xo#ÓÕ&Ó-_O¥ﬁ&⁄Ÿ#âvöDªÜ&‚æO·D˚ΩéD˚©‚ü3ƒ≥âWõ~K%:…$:∆Îù∫WàŒìªânæ∑ân·zD∑6—Ûz—[úË]·JÙÜ[}q¡ƒSIƒ\0€wƒ\0¯Zb‡X%1®‹ãƒ˝NâÔ ÜÙl!Üûé#Ü^÷#F™}\'FAˆc⁄à1”ƒãÆ∫ƒ¯$‚Â§+ƒ+ÎÖƒkÄ%bím:1âç$¶<GØ√Æ3i≠ƒõ/]à∑pØâŸÓœâ9…Õƒú∫?ƒ\\ìãƒ‹>‚mÕøƒ€{—ƒÇkÍƒªvFƒbçÀƒRﬂ6bivÒﬁD6Òﬁ7Ò·Ü)‚CãUƒáﬁ6ƒGèƒ:Ùb]ˇ6b˝˛Gƒ˙„\'àıÕ°ƒzÈ$Ò…\'‚”ê+ƒgÓgàœ\n°ƒgMÎâM&pb”[bìœb”ÔΩƒ˜<à/Z#â/Ø©€Îé€{“à.≥ƒÙE‚´Ï≥Dı2\"∫BÑ	âPﬁk\"ÏƒF\"<Ë˘AƒMkÒ∑¥àD›oD2p7ë¸ŒÇ»ÿfMd1âÃÉ7àLÁ.\"ÛÂ3\"≥wí»“ºBdA	DV˜n\"g˙ë€ØI‰˛˙EñX≈”oâí\rÅD©Á=¢¥∑û(À”& ◊ªíÁà]‹^b7=àÿ€=MÏ£»âØ·X‚[s7‚;ìgƒwAD‚ª§Z‚;…(q\\BæëG|__OπL¸@øD¸¸!ñ¯yf#qÃßû8Ÿ‚Núzuã¯ïºì8MπL¸∂Y@¸æ–@ú9MúÈK&˛˜ˇ$Œ’l%ŒoÙ\".‹Ã$.¸˚J¸3<H\\<VG\\d¥ˇn˝I¸[F¸€≤ü¯ÔG\ZÒﬂoM‚rõ§≈ìT‚Hj\Z˙$µW9$uïı$ı\'ﬁ$ç>)I£?í§i]H“fÏ È3H:åIÎ_%m0.\"mH∫?<HÕ˛ê6&Ó!mö¢í6ÚHÜµOHÜBGíQîdbgO2¡ﬁ%ô>º@2≈Ï!ôEÆ&m…œ$ô{YìÃ√Øê,nñë∂çtëv?∫H≤4Ì#YÈ‹!Y—Ö$kÛ{$õﬁ^“˛q*…q˙ ÈP\0ötòÆE:¨¯@ræÖ&πl>Fr1ı#yTì<@kI>´}H>øE$ü≈\"íÔ±líÔ¯kíﬂÅ-$ø§SÎ÷ìNÖZêŒÉIÅ‡vRp≈/Rhx\n)¥ƒô⁄3@\nùCíN˚œë\"6:ê\"\"’HgΩùIÁıéêŒÉ_ë.ÃKI1Gœìbû”I±ı`Rt\')˛A:)‹DJ(æDJ #]±˜!]]üCJåJ!]{FJ ô%eDòí23\rIYHY<I∑*≥HŸé\nRŒD\n)ó‰E∫ÌUI ”›K*RÛ#ïDìJ∂ëJñûêÓÔ;E*Û8C™8ÛõTπŸÇT…#Uıõêï-êjTIµSßI\rÌ-§∆∑˜IO[ñHÕÊ<“ão2R´hé‘f≠Kj≥øEjﬂ`Nj7∫DjﬂGj€ì:¥Oì:ﬁ∆ê:ÜÔë^πií^˝Í\'u6>\'uæ∞!LåHÄV%	¯·>	|ãOg´ë¿Ø∑ì ügI–ˇ{	{É$¡èº#!≥$‰u7*.öÑ∂M%°œ∑ì–ÛOHxΩL˛j âà(\'ë~zì»∆ñ$r»ıÇ\râ∂qâYÂHb]áí8WçIú7&$û¡è@‚Î,ì¯€IÇ´oH¬f$I¥Í/I\\qå$ù‹Eí©˙ê‰	I!ˇBR^0$)ô∂$Â¿mRINÍﬁˆç‘ÛöMÍY#\r•⁄ìÜÿµ§°ﬁ0“˚ûO§`1È„ËG“ßå“¯™Û§Ò˛\n“óªi§Ø€æíæ4Hﬂ˙åHﬂ7ÛI?∑ﬂ\"˝Í‹Kö+<CöÎˇ@öﬂOZX›MZ»Í\'-@˙∑«ù¥|0É¨&´t+»´Ìç…´ãéìWˇú&´EÎí’√ûì’øYë5‘Ní54¥…Z√O…Zøg…k\0»:f~dùVÚ˙≥Æ‰\ry»∫öt≤˛Ω-d/ySﬁ Ÿ®≈çlD‚íç≥…&!œ»&ìûdS^\0ŸÙ›:≤YVŸ<Á\nyÎèfÚ∂8cÚvŸGÚµ\"ÚŒ·s‰›˜ù»ñß.ë-ã …V9≤!ÖlMºB∂ñUë≠ˇ@»6ëw…{aÂd[Å\rŸn€*≤ù-ôl◊!#Ô◊ô%ÔÁôêÌﬂ…EA‰Éáﬁì^\";Ót&;*»GJ◊ì›÷Œí›Üu»Ó7¿‰£CG»G®íè›9NˆÜõìΩ∆dﬂöÁ‰Vx≤¿)r†h59”MrêìÑ≥\"ıeíÉO:êÉây‰ò9‘•ív™èÓpä|:–á|˙˛ZÚiz˘å±	˘Ïâµ‰®…Á.ßìœˇ!_(ëc˛ôê„Ú^í„á”…óX‰+ÿÚïœ‰´•tÚ’ÁK‰k∑U……∑~ëì+ﬁìSÙö»©flr˙zr∫ù+9›Wìú>Úèú˛≈á|Ω*É|˝Q79„j/9ÉÏKæ–!g∆_#g>ÑíoûΩKŒ˛wõúÛ®úú∞@Œ≠}AŒ;‹NŒ£‰ëÛè=$ﬂΩjC.,…&Vê-‰¬˜\"r—≈yrWJ.ﬁ”N.›≠G.\rºAæo{á\\Ê:E._ÁN./X!?\0= ?¨1!Wˆﬂ!W{√»’ÅÈ‰«˜…5ø^êkµëÎÆ·»ıDπûD~Z2K~&R#7 »/|ê[uÜ»≠g…m∫W…m∑Ú…m”‰óÓ]‰vCr«:˘’y4ÿñ@’\\$CîD2dÄ@Ü∆”»–10¶˙âåhΩH∆Vµìqo…‰;2qü=ôT–D&#^ë)&…Ùˆ82&3x∂dv˚;2Áà5ôÛıY∞Eó,<ò,,ã\"ãc»bÔÕdâÊYrˇYz3Ä,ãV!À…Z‰Æ±Jrè)Å‹¸õ¸H&îfëﬂëJ»C~E‰Ô‰Q≥,Úg◊ª‰/â›‰/C¡‰…ùÚî≥˘´◊sÚè{`ÚèÊ\nÚè3‰≠Î…?»?6ê¢Æìm\"ˇ\\l!œ~˙Bû<D˛E^ZìN^zxÄ¸wQAQ’Qß¨“9LYµaâ≤Íö≤⁄KQ€Ä¶hºü•h¸dR4˜ﬂ°h“âî5R2eÕè#-’Zäñ‘û¢˚™â¢˜íN—˘C1hÃ£@ﬂR\"(õ¥S6CˆR6c)õgéRåØ|°ò∏o¶òL0)¶u)¶èÏ(¶Úg3Ω!ä≈e[¿m n/#ä•O≈≤\nF±ﬁA±vÚ§XWGPlèÈRl–î}z(˚n(˚ùaî˝°G(ˆfîﬁÁ(àG)A)éÊ$ °/)á ±0ÂHÛg J)≈≠4à‚ﬁá‚π;à‚ÂÔEÒ:óM9∂≥ùrº%É‚G”£ú,‚P§0J¿˚Ωî–?O)aMî3çî»ìµî≥°≠îÛ´R)±Q.î8ï˚î8F%!Nìí0ûrYcÜrŸOπ¸ Érπ\'ÖrÂhÂJÃ U7k ’Œl U¯Jb·(%±HIÊ∑RR>˙Q“ÃÔP“*∂P“8îÙ7J∆YJ∆ì\0J∆–vJ¶o\'%Ûéí)ΩLπ…Ô¢‹Íú¶‰Öí(yœT)w>q)Åcîª7QÓ>›Fπ;–H)å{L)2–†£îx(˜m](˜øÿQ AJ•k5•Z˝6•⁄|éÚX/éÚI©Îã†‘)\rˆ[)O;)œ‚])M∆Èî&ØfJÚ$Â˘¡ Û\\<Â˘˝iJ≥&ä“¢SAy!≤ß¥È0(/çä(ùé/(‡uYp˝ LM•@∂∆S ó’)∞ˆ}~%ÄÇ®k£†÷}ß†‚∑P0Ng)ÿLÀ@R%Á)Ñç\na;ùB≤ŸJ!k†ê˜fP®[7Ph≈-Ü’\n{Â\rÖªÕü¬M´¶pﬂ7Rx˚á(º§{¡ïQä`È0Etπè\"m?Ië˛æDëyèR‰=0Jœ≈6JØÁ•7˜0•óOy]íA8~å2¥D¯†ºù¢Pﬁ˝§ºÀfSﬁç¿(#g≤)#7Û)ˆ9PFœ•|æ±ÖÚYlJ_uñ21bK˘≤L¢LuﬁßLç¢(”v∂îÈ√8 ˜Z w c œMuîüﬁÂîŸî, ¸1c B« ÔÙJ ‚U= Rá1e≈JY˘RAUÎ?I’lâ§jNRµ¢V®Z}0ÍZs	U;√ï™3∫ü∫·a;U˜‡U˜¡\nUÔÉU?œÑj∞!ãj\0ÿB5Xj¶n^mF5\"ÍQç◊RMå©fÀÈ‘-}©Êä∑Tã/õ®€∂§P∑π]£ÓÃ]K›ÂtõjÈüGµLŒ•ZŸP≠µ©÷Qm‘=%·‘Ωü-©v+¡T{˜\Z™=‡’ûE§»ŸI=xåz†)çzp°ãz(eòÍ$˛JuC©n¡¡T∑–.™˚ëST˜¿1™ª¿çÍÅ¢zñ&QΩR/PΩP}2iTü™Ôa{™ﬂ:’Ô«zÍ…=Û‘Sß+©ß‘‡ËU‘®>ıLÚjTÜzÓcı‹ujÙiCj4ûDç¶Sc~•S/n\\GΩò–Iç/–•∆W|¢∆/®	zS‘ƒÚpj“üc‘‰ìO®…¸$j∫°êz}◊{jft3ıÊ˚á‘[´á©∑é˛°Ê⁄n§ÊéPs˘w©πC´®∑B®y·~‘ºK®˘º‘|Eıé˚IjÅ”µ\0ÒÜz˜∆$ın˛cj	dûZ∫ÀîZ∂È,µÏÍ-jô≤ãZ6¸âZ~…ÑZÒH}p›ì˙‡¡CÍ√êã‘*√U‘*¿gj˜µÊ’µ÷ºñ˙ÙÇ\rµ©ˆı9ƒÄ⁄|•å⁄¢-£∂|‚Q;7≠¢NQ!FUT®—I*ÙÖú\nÀK¶\"™º®»˚ÛT‘_*éÛòJd•í|{©‰≈N*5∫ÅJ˚æô ,q†Úa√T1JDï8ïP•èÙ®“∫ªTÈÏj™åÑ• ¶÷PªÍò‘n¢µ[~û⁄ñOÌAÖR_√ÆRﬂ§ÿR˚øæ§îUSöQﬂf˚Q?l+¶~ÃLß~ﬁO’˘J˝¥6Ç˙È‡WÍX5ç:Ó“KùßNR¶®ìoÉ©ìü(‘oà*Í7Œ	Í˜…ÍèJu¶üB˝µ˘u˘R:u•lö¶{@S’1†©~ë–VÌØ†≠zPISÛË†ix=§iˆ£≠Ò\n£≠yÃ•iÌ.•i∂£iØ&—¥∑Åi⁄ˇíiÎùÃi∫va4ÉÔ”¥M¨ö—i!Õ(Ó!ÕË&ùf\ZC†ô è”ÃJ7”∂hShAc4ã¶(ökö∂ı‘3⁄VLm˚˙¥Ì3_h;}∂—vç“,õ,hñ˝JöÂDÕ™˘<Õ\nSA≥˛L€#⁄J≥U}K≥Õ†Ÿ]zL≥+F”ˆ≠w†Ì{◊J€©èv‡èÕ¡vòÊ–\\JsÏ†B{—ú¿i.¸⁄ëÚã4◊Sù4Wƒ$ÕıÎ[ö€=2Õ=>òÊ^˝êÊ^ØKÛ®c”ºé^¢Wz–|Ù—|…¥ì€è“\"h\rû¥ üJZ0h=-X|ívëHªvî>§ùπ˚äi≠†Eñw“\"9L⁄˘ç⁄y[ZÃk*-÷4á˚¸9-˛¸ÌíQ ÌÍBÌ⁄æ\r¥kcdZ“,-)ÖLKâﬂBKM…¢••Ÿ—“´/–Æ_ò•›†iYë¥õ#$⁄Õ9¥[§c¥ºâ¥<Á ⁄ùÿHZ·!≠T¯ÇV˙Fªﬂ`@+ìó— 7ChÂ,CZEÍ\Z⁄É5{h5”*-fh5…=¥\Z·≠÷˝≠˛˙0Ì…Ÿ%ZÉY5≠·∂=Ì©∑Ìô÷EZ”™/¥¶#⁄¥Á·Ω¥Êƒ|Zsúˆ¬PN{aæâˆb∑≠UPA{ÈˆÉ÷aÒå÷¶ΩR˝C{EqßΩöj¶÷o¶O“@EWhê1\ZÙ«A\Z:OÉÔß¡øy–C@\Z≤àO√Nu—p4r˘n\ZıΩ?çzáF√6–Ë%L\Z#Jó∆‹˚û∆Ù˛?Ü\r—òJ\Z´tê∆¬≠ß±∑¸/Øü∆âã£qèêh\\ﬁqö∞J—ƒkÑ4Ÿ¡öåÑ°…Eù4EY\Z≠À=â÷’5LÎ ¶u7m£u/Æ–zki}∆ﬁ¥>Ák¥>o≠/Ox5CÙâ°\rﬁ∫A{óXE{\'\'”ÜL{h√•Å¥˜´¡¥Ë⁄N,Ìjö6¡C”¶Ãπ¥o{X¥o9ªi?^§Õº∂¢˝$‘”f\r˙i≥•·¥YÏI⁄‹∆>⁄™óˆ\'©Åˆ7ïC˚+]C[I§≠<,¢´Ù9”WI˚Ë´u:ÈöÉÈk¨@t≠Ì7Ë:v“◊/QÈD	Ù\r=èÈ∫±≥t›€;È=ˇ–7&L—ıs\\È;ÁËsÎËõ˙=ÈÜô[ÈÜœ÷—çãË∆9˝t”YC˙êæ›\nHﬂ!ˇKﬂ1Ûçæ”I∑ÒºK∑Å[—˜ÓK†Ô¶–˜Ç\0ÙΩøÓ”mΩkÈ∂⁄Ù}åMÙ˝Á—˜œ∏–Ìè2Ëˆ18∫˝˝}t{l.˝Ä„q∫√Ñ\Z›±mâ~H¥Hw2_°;=}K?úÄÓ¢QB?≤c›ï3Iw˝WGw{¶{ò[”=ıé—Ω^N“}jEt?0˝DS=ê7N¸CÇ¡Ëaîdz¯Ëez¯Ç.=¸Ø\r˝L¢-=‚§=b˘=≤Àê˘´ùµSA?ßˆåkHèΩ”LøX…¶«πAè∑9OèßØ–„ßN—h>ÙÑ¡«ÙÀ<˝\ZâEOJ¯KO*\r¢ßÌl†gòÒË\'¡Ù=≥ÙõØv”oπﬁ£ﬂÇ˚”o1™È∑~aÈŸÄ;ÙúO…Ù€ºèÙºç¡Ù<x=ˇî\r˝Nˆ\'zAm8˝ÆÓ4˝Æ˚}z°Ÿ]zaùΩ∞Ò3Ω¯Ñ\'Ω¥ïD/Öz—ÔÔR£óÛ°Ùä\0Mz≈úΩjGΩZ®CØ~øHl°◊Ω(†◊Ωd”ÎÜ9ÙzÁ?Ù∆ùgÈçÔ∑”üIÂÙ&GzSÅ*Ω	VFo¢˜“ü=£?ü~Joén§7ßz“[ö?—[†©ÙVÉÌÙ∂˝•ø=Ω›˜/Ω˝€8Ω£wô˛ 4â˛ ÷ü˛ #ì˛*f;Ω”h3Ω≥Iì@∆—otÈ¿7QtÜDá∆å–°B0:nEái”·	Ut‰Œf:ÚÁ{: èK«D|¢c*˙Ëÿ:%˜G«`È¯ñt¬ì∑t‚ïx:iG>ùfBß©i–ô€ËLñåŒJ˚Egﬁ”9tW:ﬂMBÁÁ}¶ÛõAt·È∑tq»g∫ò∫è.9rÜ.ΩßKßSÈÚõŸte∑ΩÎ4ëﬁÀ –˚6G“_Gæ¶øá—˚\rÎËÉ¨È#?È„:.Ùâ›ìÙâÆÙ/˘˙ã>ıw/}˙ C˙wwo˙√Ùôöh˙Lè˛s?ò˛Îâí>ÔÒç>SÖ>_Füo=Oˇ˝¨áæ‰£ˇK≤§/sÏÈÀo∆Ë+òW’CåU≈ÕµdcÜ∫…SÜz\\C=˝\ZC˝ÊC´pC´ˇ6CÎä°≥ÀXÜ36Ï˙Õÿ\0qbË˛–elL^blÑ~`Ëgk2BåÕÂåÕ=Ü°⁄\n√–Ë√•√ê⁄Œ0=öÃ∞8‡Õÿ:zî±≠TÖ±Ω4ó±≥0ô±´Ì\"√ÍM	√Zá…∞>d…∞‰3ˆ~çdÿˆÁ0ÏÇÖåÉOY«ué˝Aå√Ç-Á#OŒÉŒEC◊_Üka√}ﬂuÜ˚Ñ·qc√£iÇqtg2√ÎC„X•„Xåqº#É·+\\≈Û≈2N \'É!åS5w˛FåÄ¬jF†˝OF°Fàé*ÓdÑõÛß◊˝dú3\"\"ü0\"^å≥ˇ(å(éqn’G∆πÙ∆˘›è1Í≥åÿ≠ø=-qVÉåKøT	πå§¬måå]FFx #É…a‹(B2n|b‹*qf‰m~ƒ»e‰/≈3Ó˛a≈<gî /1Jã∫˜úK˜7Ÿ1ÓÁq˜Ò:å2@!£‹BÉQ°1»®$Ù3jnÏf‘˝ 3ÍÎ¿å˙˜Óå\'uª\rµMÖèÕ∫ùå6«/åWm∆´{˚ÄóÂ\0lû^ªÖæl√Ä®ob@ﬁò0†˜∞+VDÂ6«¿«0pÈS¬õbN1ÉÙ\'É∫ﬁéAo®e–üe0F√ú≥⁄ÆZ3É∑—ñ!ÓbàŒÂ2DWØ2$œO3§Ô0‰ay.ü!üπ∆P4ä]EånH8£GSü—”õÕxΩ9òÒfO%„çÏ:c∞$Ä1Hg}˚ÃxØµïÒ˛•Ñ1íÔÀ{˙á1·ΩöÒÖnÀ¯¬+`|:Ãò“˙ƒ¯⁄úŒ¯VﬁÃòù≈1Ê0wW;ãáå•úa∆ﬂÄ4∆Úœ|∆ÚÔl¶\n \\≈Úf™Î¸a™ﬂ€¬‘»RgÆï%1µQwòÃ´ô?$1\rOôõz1ç˜v2ç[ô∆K⁄L3ÀN¶y¨s[ëàπÉÊ«‹Y‹»¥l†1≠JWò6’wò{&ãòº62ﬂ_fæ¸ày8 t˛˘óÈ“jÕtÅAò.KÆÃ#≥ΩL◊ñ≥L7ª\Z¶{Ä%”˝É7”˝€:ÊÒÎ—Ã„˘iLo\'\r¶èG!”È¡Ùy˝ãÈg\0fû0=«<{óy“ä≈Ù7ie˙áΩa˙Á§2 &òÅz[ôÅÊ˜ôA-$f®\rñy∫ÊÛ4˜ÛÃƒf†ÄŸ–ÕºPèf^¿ò±[n3Ø¨=¿ºöœe^}≤çyº»L≤ve&Iò…QYÃ‘˜>Ã‘17fÍÑ3ÌB;3›√Çy£Ë3ìî Ã\"|gﬁ⁄ º5tùôÕ dfOlcÊ®Á0oè0Ûœ0Û†MÃ;≤qf¡âÕÃÇ™Xfax ≥5ÅY4Åc◊Ï`˜1K_~fñ≈ÌfñIæ1À	ÓÃäWô¢ÊÉÍªÃGéœòè^≤ô’ò,Ê„±Ã\'Ô…Ãg≠-Ã¶[√ÃÁüÆ2õkò/F2ò≠Â◊ôÌ{_2€+O0€Á÷2_nbÇ:ﬂ0¡˙LËπLò)ö	?˚àâÍ<¬D_≤cíÃÏô§Ì∫LRé3ìê»§~ˇƒd=f3ŸèN1Ö[ùô\"üõLQ·]¶®_É)^eJ∆òLYŒ.¶¸SS·^œÏ“?…Ï∫¨ ÏJ)avG0{√≈Ã◊€!Ã◊µ_òoRtò˝≠⁄Ã¡»Ê‡ÎcÃwXÊpís¯°s‰ﬂÊıÿˇ%2?\Z3«tWòcNΩÃ±∑Ãâ!ÛKp(ÛK¯Ê‰&>s“,û9ŸNg~EÆeNGÄò”üòﬂ‘BôﬂèŒ0g¥ô3ﬂO0Á`=ÃÖ’uÃÖZ/Ê¬À&Ê_¬Êrÿ<s%|Ñ•2ë¡ZUm√Zı6Éµ:O¿Zç∂d©üb±4XU,MÊ)÷ö∑Xk˙µX⁄kD¨uï≠¨ı◊Ó∞÷ó¬YÎ_t≥6ª≤toﬂaÈ˛(fÈiÂ±6™∫∞Ùq%,èø¨Õá…,„˜Œ,ì≤8ñÈ«=,≥.÷ñœñ˘d<ÀB-ëµ5ÁkÎá\"÷vÊ[÷\rG÷N·4k˜·Û,´ñUZ4Àä´Õ≤ym¿⁄ìŒ≤Ω»≤ÖV∞ÏíXvÌ9¨}ÔkXˆˇX∂L≤WÌ`9Zò∞Õ¿YNo6∞Ô◊d9ÎsY.)øX.MBñá¬íÂµˆÀÎ›*ñ◊˚÷±‚jñohÀ∑8âÂd≤NÆ∞NÓ< :ı¸/ÎË+‡)åËì¡\nhf&≠∞B⁄î¨–¶+¨PI+¨Lì&¥dùvœcE$Í≤\"`Y¨sß˙Y—ãˆ¨Ûˆ≥.L≠f≈Ñ‡Y1¸¨ÿu˜XqGáYW.}e%\Z≤íµU˛7∆J∂Hf•ñëXi˛lVzÛGV:«ïuΩ<ãïQ¥Ã∫q+3WÃ zyôïı&ùï5∑ƒ∫uFèu+É  n\0≤≤1%¨úÛÊ¨\\ÛIVÆÏ%Îˆv<+ø^ìU»∫ÎsâUÌÃ*\\~«*zi√*æ±¿∫w4åuøÒ´åÁ¬*Wècï?¸Ã*o≥b=à/d=»ºÕz¯ŸÇUIA≤™lXè[“Xµ˝˛¨z˘V√[]÷”sGXœTmYœ\r‘Xœ∑Î±û£¨6è%÷KKw÷K¬´Ωzôı*°Å’iöƒÍ\\∂cÅ^fÅ◊(X`ÛvÑœÇn∞†ÈlxÖù∫œÇŒ≤`\rr8êÖ≤“c°\Z⁄Yò«ã,ÃÜÖmŒ¬=¥eëñû≤»Ydã∂„+ãyZ¬bôF≥ÿA∑˘K∏æá%‹õ»câßYåKZÃí∂;±d	,≈ÍYñ“(ò’%qgΩ˛æ»z≥[É’ﬂÍÃ\Z¿aYÉÉøXC˜XÔwÈ∞>n5e}>cçnë≥FΩ-XüF6≤∆~∏≥∆˘¨	îkB∆e}aúdMˆN±¶∞B÷7y.Î;¯\'ÎÁøB÷Ø•O¨π…÷¸Ì¨˘kQm\'Îü∆S÷øì´Y+“Y∂jËO∂∫öí≠±w+[#…û≠iÙê≠YS»÷⁄¿÷∫Iek=ckßè±u6*Ÿ:M∂ﬁ¡ÎlΩñIˆ∆∞vˆ&§€–‘òm(≠aÖ;≤Õ(Il≥I8{À≠ØÏÌœŸ€ßÓ≥wbw∞wπå≥w·≤wøe[Ü≤-ÿ6°ÿ6gŸ6∏ãÏΩ*˛l[2€.⁄óΩ/˘%˚‡”∂£Êy∂cY€ëΩéÌ‰øã}¯S\r€•Ñœv£‹eΩ&fqd˚‰ñ∞˝úRŸ~ŸÏ*\ZÏøŸ\'Ô∞OÈ∏∞˝_∞˝h≥\"±cè≤I;ÿ¡jLv°:v”ÏêµÜÏêõNÏ∞Iv¯ßyˆÈsõÿg\\¨ŸgÊ2ÿyJvƒ≥+Ï¡vˆŸ9	˚Çﬁ1ˆ70;f¥ùÎÀNd^b_Koe_{Œg_˚≥äùtë√Næ∏Éù2Ùåùj¯Üù˙LƒN]x»NK™eßΩ:«æ!ag‹ÏaﬂzÅcg˚ìÿ9ÎÙÿ9∫oŸ∑Ø,≤Û\rãŸ˘Útˆù+¶Ï¬ÁÆÏ‚ª§êÕæá›√æüeóÖ≤´ø*ÿè˘>Ï⁄øüŸı@ªû∑ç]Ø¯¬n(ıc7‹Øa7Ê<`?M≤f?%˝ß<Ÿœ2‰Ï¶„<v”D.˚y≤\rª9%ù›¸∆ç˝‚Ÿˆãø›Ï÷∞ÀÏ∂W˛Ïˆ∏v{	ä›ŒZawƒ\\ew4ÏawÙæb™˛≤Å]Ól‡H0ãb√æSÿpÄ˝!ìçâˆ`cÜø±Ò;^≤â;≠ŸƒÎ^líw\nõîÀ&ï≤…WÊÿ‘aC6≠¡ÜMk˙À¶çÍ±Yq6˚j\'õ¯ñÕCÛŸ|üp∂¿ˆ[ÄÒaãŒΩ`À=.±ÂØäÿJ=v∂ù›ùËÕ~„ \\˝ö˝Óã{(‰>{ÿ>ü=\\/aøOÕbø/®aèÑ™±?‹˙¬˝ß∆˛|uÄ=i5Ã˛˙A ûæﬂ«˛ñ’…˛a≤¬ûÒ{√˛YûÃûuŸ»ûãy≈û+>Õ˛Ìì¬˛˝§è˝{÷ú˝ÁI˚œÙˆ¢⁄vˆ\"ﬁÉΩ4 ˛Áàc//º„®ÏrTÌd’#8™Ë|é*AÉ≥ πù≥jñœYÌºñ≥\Z‡∆Q˚∫ç£Yªö£Úé£uı,g≠˙gmæ1gÌœQé∂ÍjŒ:[>g]zg›À4Œî	g≈Ÿ0Æ√—µTÂËæÁË~˝¬—À;ÕŸ®ﬁ ŸhüÕ—ˇ∏Ã1x+ÂÚS9∆Œpé…ß◊”«qsœ]Û„´8Jé≈ygªJgªôgªßgg¢;g\'yÄ≥ìäÁÏ^£ÀŸ˝Õ±¨ÈÊX%‹‚Xø˚√±ûòÁÏ…dsˆvÈqˆu˛·ÿgÚ9m—‡Œ¡©%é#b«ë±ôsÿ£ús8ˇÁ0åÕq¶‹Á˘Úñ„Æ#ÁxXn„x¶@9ûïø8G8pº6rºŒˇ‚xçµpéÌ5Âx9>√û_i\0«Ùó„ˇ√	¯©œ	l˚ 	rù‡}_·_p‚ÑVòs¬ìúp√`ŒÈÑ6NDä?\'ÚI0Á¨’ŒŸ√k9gÎq¢»ˇ8ÁÆC9—V/8—nsúhxÁÇŒ_Œ¢åw:ãóÌ¡âUr.©›„\\:Î«πt#ãs©œñìpjåì\05„\\≠∆r“Ã’9iÂπúÎóÍ97ö[8ôfúÃ;ﬂ9ô@ŒM∏ÇsSDÁ‹z¨ …·19πÆú\\6íìó∏âsgÇS47»)QósJ∑frJw˙sJôâú“Óú˚Gwq õ_r*‚Ê9bÁa‡\rŒ√ÿ^N6îS%3ÂT∑xr™aO9O∏=úÜıúﬂÀúÜïzŒSˇ!Œ≥èïú¶t/NXì”¢SœiŸ¢‰¥X⁄q^⁄˘p^≤M8ÌOZ9}Œ´_•úNï@†9\0—0›¡¶≠ÁÄ÷tq‡´ó8à]	dZ(ı¥àÉ3ΩÃ¡ER8…^·›)“òC ÷„–N\ZsË9%Üê√¥:Õ·®s8ú_8\\wÔî#®u„¶°◊éÜ	G‘≠…ë¶r8≤õ`éLpë£<ﬂ¿È)Ï‚ºÜMr6[qÏüp29É≈Œú°UUú—+ûú—¨aŒ\'„ŒÁXŒÿ◊@Œ∏¯#gbÎŒdÈfŒWâÑ3≠&ÁLo˝Œô~Vƒ˘Ûç3”E„¸jÊÃ.‰Ã∑sÊÆ≠·,òP8á\0úÆG8À¸ú∑_\\„@Æäù3WöÕUÁœr5¶_sµ^ÏÂjáßs◊}IÊn(@sı´èr7=K·\Z«ÈsM^rÕtÓs∑Ë§rÕ]Í∏«úπ>ï‹Ì*˝‹ÌNr∑ﬂ‡Óÿ≈›q˘\nwwÙeÆ’;Ædàk_‡⁄àúπ{Ä«π{+G∏Vc∏˙√∏JuÆ”ôzÓ·…aÆÎ˙Æko◊u0ÖÎYQÃ=ˆr/˜x\'áÎcˇçÎì∫Ãı{∞áÎáMÂû‡p˝ï‹ T87¯ÚnÿŒinXù7≈ç¿˛„Fuqœ„À∏Ï£π1´µπ1aß∏1È¡‹Xì˚sÑ{Q?ä{±¿ΩÃÂ∆Àær/Yæ‰^ œ·&DqRÕπ	w∏	§ÓÂ#ÓÂL6˜ A7Èçõrg57ñÃM›Å·¶&1∏iÂ‹¥ïZn:¿Õ¯øf7b∂r3…«∏ô Tn÷,7kÇÀΩiW Ω•6«Ωıˇè)˚∂7g-õõüÃ-ÑëπEv£‹‚#Tn©c	˜~3á[ô≥õ[˘ºî[…HÁVG8pﬂ¶rÎFUπ\r>¶‹ÜÄ‹ÊNÓÛµ/∏Õè¬πÕ£Gπ-Òw∏≠øπmk;π/«x‹ÆÇH\'pÕ\\‡È\'\\‡kS.(ó……\\πê¿D.$m5¬ªÕÖ≠‰B}Cπ∞∏M\\XU+Üïr’Á∏à>g.ÚB3)ŸœEIés—\n8ªÛó ÏÁ#Rπ$ø$.˘E<ó‚ÛéKªî¡e±Uπ¨Ô$.˚Û5.˜Ô.o◊s.Ôu\nó?ﬂ¬úÂqÖØπ¢ÅnÆËØWñÒö+Îı‡vÅ\'∏]\'nu∑«Ì∑œ–ú€óX¡}mﬂÕ}ù•«ÌøáÂˆK¬∏ò~Ó€‘DÓ !Å˚N∫Ö;Ï1…¸ÃŸ∏ô;r	…˝pxå˚©pÅ˚È◊#ÓÁ£‹Ò\rÓx…sÓ€XÓWµÓèƒ=‹„˝‹ø`‹ô{ˆ‹˘]?∏Î¥∏óÀ∏∆Wqèﬂ‡.-pˇÆ˚√˝ª-Äª¸€àßN˛Œ”ÿC·i›äÁi◊Ò÷∫Ë÷¶PykØ{÷•t÷çÚ6lÚÊm8nÕ”µõÂÈK~–áxFf<ìüHû©}œÃA 3_˜çgnc ≥¿·Yå∏Ò∂◊\ZÛvt\rÒvŒº‡ÌﬁŒ≥\Z∆¨&ŒÚl* x{5sxv¿º}…!<˚5|û˝ŒTﬁfÔ@_Ô¿Á.ûC´#Ô √;RˆçwÑö…s≠Ì‡π‚nÒ‹?‘<«<xGOÁe$ÒºÛºíry^aûö¬Ûö—‚˘ºbÚNXHx\'2!<ˇ◊x˛qvº\0Ö9/H„/®åÀIáÒBGâº∫µºpÅ	ÔtºÄw:=î—‡¬ã\\g ã¨X‡ù}¿‚≈∂k.n; ã≥º¬K0Y‰% ºy	?Byó_ˇ‚]˛¬KÂÛítÈº‰5áy◊ﬂhÒnÊ˝‰›öß≤£{yŸıfº\\·6ﬁÌªÎx∑„y˘_N\n≤<ySºª1ìºBS8Ø»ÄÃ+˙ö ªW\'‰UDŸ*Œw¶|ÁUéªÚ©\"x’˜x5OCx5+ºˇ1^o\rÔπeØ•3ì◊2ã◊vlÑ◊Üx≈{˘Ê6Øù∏»kc¡k;ÀÎ¯xÄ◊1{àäJ‡¡¬jx∞IıØíái’Êa&byò&O–‚·{<b«Sq√#uiÚ(fOxîÖÔ<ÍlèıúG+áÛh§$„¬èhÊ1$èyLÎYÀ”É«ö∂‡qvÎ∏%©<Ó◊É<æiOX…*Ò<Q9é◊u¯7Ø∑äÃÎS=«{Ìjœ{æâ◊è”·ΩuÊÚgßyÉˇ¨xCØˆÜwÍÛFú∂Fpﬁgì\\ﬁÑI;o“˝=o*∞á˜’ˆ/Ô+ê7#oÁ˝Í)ÂÕ>Î„ÕÎ\\ÂÕ7w~G˛º}¬[Ú¿ÛñπÒU7ÚUøjÛW™ÛWg◊ÚWÉÆÚW#á¯\ZœoÚ5√\'¯kRæÚµçC¯ÎÓË◊;¸ÊÎEœ\r≤≥¯¥+|„S|”7i|”_5|≥…Õ¸-˜ûÕsõ¯[WW∑Œﬁ‚o[\'‰oÛ\r‚ÔÙ˙ÃﬂÕ∏Œ∑0˘Vﬁ?¯÷ó=˘{™ê|€ø˘˚_¥Ì}m˘¸Éäc|«zﬂæÉÔl™¡wvÛùÉ˘.CÊ¸#Ôí¯ÆM,æ+»w˝˝ÇÔ˛ÃàÔÒºãÔ©˙ô‘Ì\ZˇxHˇx›+æ|åJÌ\r?†‡3?0Õé»†ÛÉ”£˘°~ˆ¸àáR˛ŸSÔ¯—Á∂Û£GNÛœ”ﬁ/HVÛc_u„0~|Ë?~a#ˇR„!˛ïÙ^~bE:?•ú…O˚Ã‰g(>Úo|‡gz¥Ûoö=‰ﬂj.‰g_:ÕœŒ6„g?À‰gìÙ¯9õ¯∑Ì>oì.ÒÛrº˘Åñ¸ªô™¸ªc~¸¢^¸{Êæ¸˚∫¯ãÓ¸á¸á√˛£u˛#õ_j»Ï’¡Øπú«Økù∑Òkõ}˘\rW±¸FCøq∆öﬂ$?œ~‚\"øe Éﬂæi+ø#¿çﬂY≈5Û!c?¯–‰6>,ˆ6K‰#åI|‘èÕ|ú»ãOÿk¬\'PﬁÚ	3›|‚ì>9cüº\"Á”üÈ⁄¯Ùıt>=Á*üﬁ¿gv]ÊsÇ&˘\\ÏF>ó>ƒÁ\rÁÚ\r£|Qv7_|xò/Ÿpí/…Ò·Àƒ\0æl¥üØÿ≈Wà\n¯ Iu~o™àﬂW@Êøvõ·˜{®ÒÛõ˘ÉÛ`˛0üˇ~˜F˛?1ˇ√„˛®&Ù≥\Zˇ”ˆ˛gï4˛Á%¸1ï¸±€¯c=≈¸â˚Ø¯_÷ü‡≠Ï„3ä‡ßNÒgüÁœ!ÓÚV]Âˇâ8Ã_rêˇjUÛˇÜıÒˇ≠‡/õ\"¯+™z¸ï◊*Ï&ÅÍÜ/’ô(¡™Õµu∫µÀEç‰ÅFC∞∆Â°@À≥U†Ó%–z‰.–˙xP†ÙN∞Œ˘Å@Á∑T∞°˜É@óh.–˝¬Ë¡Ù˙†ΩÇÕ\ZÅax´¿à”(01ﬂ*0Y»òÃ	v⁄Èv]Ïz,ÿ}Ö%∞ß,ﬂõ\n¨96ªl{6çl˜≠ÿù}&∞´\ZÏwNÿ;®å8∏L	2ﬁ_NIkn?<ùµ€*8∫tN‡•3+8ñZ-8÷˜Epl∏X‡Ω\r-ævP‡˝nI‡˝+D‡„:/›=*8¸W‡øÒ¶ j≥ lÑ Ú€fA4U\"8??!∏`f˚ø*¡ÖêÕÇò5ﬂ1[	.>π!à√ìÒ˘«ó∫ÒÇƒÏlA“Yî 9¿Qêt§|W\n“£M◊Qß◊á‹◊\'‡Çå\Z5¡\rãH¡ç∏6A÷”ÔÇ[à=Çúuø9]AŒÿeAÆpç ˜Ìí‡vyAﬁi©†`√:A¡Œ¡›Ò„ÇªjÇB’AÒ°üÇ◊”ÇÆ∂†twØ†4Y ∏˜$Vp?ñ,(3‘î°÷ ué™/Îï\Z	ç≤ÔÇgá˛	ö¸è	öÅ-Á2-ıgÌ¢A«©ªÇWSªù˛WÄæt»j∑\0RµC\0¡ﬁ@É£®\'∑®gëÙe}Z(‡≤N	Î√Ñ¨ÄPﬁ! “jÂÒ†Ä~ÀG¿(\nò®TãS(`CN\n¯3z¡πø—ë*ÅÉà	Œ±Ú•@<i)ê1HŸÅttü@6ó,P@h≈õ4AèÖ≠†WeY–wˇµ‡Õ¡¿mc¡@J04Cå‡S+∑FâÇqÛ\'Ç/I?ìSV”É¡7Û£Çπ›ÛÇπ¡‹^∞x∞[∞xé(XZw@∞Ùˇ˚˛˜“\\®zÍ∫pı6m·jﬂçBı±°FL±P+ØZ®]í&‘9Ó ‹•!‹P€&‘ÎõÍègç|jÖ∆¡ãB„P{°	N(4’öEπ	Õ*Ñfd-·ñ’∑Öƒ0·÷¬ù¬)[ÑªÓh	w¡bÖª√rÖ6{ÉÖ6è¬Ω˝wÖv.ÛBªVBª`-·~´|°=,WxP\'t<#tö∫¯\n]lÖÆ\ZR°kÙ∏–ıZø–meïËŒ]¬£âm¬£kÖ«lãÖ«7úzóL}\\ÀÖ\'¶€Ö˛;ﬂ\n∫|ÑÅ¡Ha‡9é0Ë˘Aaê‡©0h*æ˛Eí¨%›≤\"k[\'<mOûé≤ûY≥Nx&bBxÊÕä0\".Ai—#å¥?\"ååÍF≈Fx	£äˇ/˘c§#¬ÿ¨0a,⁄Xx1aE∑h&ºÏ¨#L\\^Ûﬁ Lπ L›„.L≈.”tÖÈmèÖÈ≤√¬Î€±¬ÃÃ{¬[Gx¬€+¬”k¬ª*ÑEWû\nKmÖ˜.ñI´ÖÛ>´vg\n≠*¨∂Vá˛V\'ºVÔVw‡ÖırÅIo∂∞±j@ÿëü•<>#éõ<Ö-*±¬ñ∆R·ãäDa˚]a{vû∞ù„ lß\n;œPÑÄ+øÖ¿ÕB!ËÎò<|M˛ë ÑE~\"üö\nQ∫˚ÖÿçBÏgG!û¸LH∞ú˜DI.Ñ4®ê÷ì*dåÖÃá±B∂ßßêì÷,‰›:#‰Âï\n˘\0m°P~L(∫≥$îÓ\'•√ÌBY0U(°ï:øÑJÎ°íµSÿ2v	ø	ª=.\n{xU¬ﬁ¥ã¬^‘maﬂ}∂∞o‰ï\rΩDÿØc$p8%|ªÈéph»Q¯>+A¯1 Z¯1œ]8 ?(¸\\%¸<ÚM8f,é;w«È¬	G]·ƒO8!≤N:ùN’>NAOøi~<\"ú~\"N√v	ßôd·7∑·∑∆·∑	äpf^[¯Û£õpvSøpÓJóp˛S∏%\\\\ª,\\,ÿ/\\B^˛k	ÆHD™n?D™ŸóD´<BDj:f\"5ìrë˙Cë˙C§Q iêNã4>Ëã4á°¢5„^¢µ1\r\"Ω\'kDıÁDD˙7Dz≠¢M™•\"#õß\"#‡5ëI‘~ëŸπ\n—÷∫´¢mµK¢ù-m¢›ÕA\"Îˇkìäl\Z%¢Ω∏A—˛ı?D˚∑KDE\'D4ä\r”EéÚ—!ˆëãπÅ»UˆB‰÷Ô#r7¶ä‹ù]EÓo„EÁ2EÈEû¡m¢£\r6¢c	üE«5	\"ÔÄ”\"ü\rXëèû™»∫Y‰WÎ\":ô⁄(:e‰\':µl%Ú◊¯\'Úü∞Ór‚jDAGvãÇRE¡fEß¸E´üàŒû/äN\ZEÁÊã.O≈/fãxp—eî(Q±Oî8)∫∆Í%›#ãRÛD£¢LOîÖx%∫•ã≤-wä≤ÓãrUJEπöÀ¢‹ù¢€ªD˘±%¢ªñç¢ªó∑à\nﬂø$ãäUwàäùï¶ûï\"›D˜¢èä ∆øä*l=Dï;7àE£Dè∫\ZE’œ3E5ˇ◊•fw≥®ˆz≠®é˝]TˇÓöËI•HÙ§Ö\'zÏ5\\:+z¶˙CÙ,∂FÙÚX‘¥ŸS‘T–+zÓù\'zë!Ω¿ã⁄û6â^J;EÌª7ã⁄d¢Õü¢é◊EØÚWã^-∂â\0∏\"p◊WÏŸ=L^(B¢EâæÕfä0ÎÁEò¿\"ñ˚ZÑ‹aˇ˛ë\n„E¥ıBçzIƒ¯\'qPEº2;Ô!Dƒ˚^#‚Î[ã˛\"aU$$ãEbàB$—‹!í‡GD≤ }\"π’¨HâGä∫RÂ¢ÆÅ(Q∑™ë®\'ŸD‘€EıPE}8G—kû\\Ùz,zQ-Í†+\Zàˇü¬MÙŒï(\Z⁄h/\Z≤gâﬁÔSΩﬂ+\ZY•+\Z5»çæ1}ÊGã>O–D_^ESıﬂDﬂ#Nàf™Øãf ¶¢ô∑¢9c—¬˜_¢?H—“◊|—øõ}¢ÂÒõbU≥\nÒ*√Ò™æÒ™%5±⁄+ÇX=)÷@]Ø9H¨µ„òxæEº!pßx√È^ÒÜ¶◊b›˚±.-ﬁhäÎá\râı(±˛ªf±Å[ßÿ‡ú∂x≥ö∫ÿhû 63y+6€n#6ã∆ä-à∂‚mó2ƒ;Bﬂäwˆ?Ô.*[nû[∂Ì[Mﬁ[˝vÔ›7!∂*€≈≤ƒ˚0kƒ˚AkƒˆqX±˝ScÒÅ€B±Éª@Ï\0ßäVâ˙*v\n:!vo;_pùª˛ø‹˜yâèÍm{—{ƒ«Ω∫≈ﬁ*h±˜Kåÿû*ˆù⁄\'ˆ€û-ˆ{áü»´üú˛$>µ_M|Í4K|ÍQÇÿø˛ßÿøﬂQËz⁄àÉ›Àƒ!œg≈°=/≈·ªvà#6∆à#˛îã£~ΩG/<üØ:\">ˇ4T|qDUœô_ä˙)NX˜Nú∞—JúPtT|•¶\\|µ–Lú¸ŸFúrhQú∫æ\\ú⁄Ò[úV\nßQ≤≈Èahq:fZúﬁ€%æÆ{B|]!Œ<\ngñïâ≥.à≥>ã≈7˛g?+ŒÓ¨g,âs(ç‚€Ç	q~D™¯Æe¥¯Æ5Q\\î’#æ_ ﬂßÀ≈e˚ƒ§ï‚áû‚ òQq%xΩ∏Íüâ¯Q∑•∏n≠â∏øG\\q\\¸‰,M‹hÂ%~vyL‹7?ﬂwC¸¥I‹<∫G‹r+T‹2qW‹2˜^¸¢›S‹⁄e+nªó+n˚î\'Ó(≈ã*T1@{AÍúÉpÛb∞èß⁄Í\"ÜU´ä·¢1‚Îz1r_ïÈá#S]≈HÄBå§^£x€≈(ió],∆ô8àq«ƒÑ⁄)1Që&&i≈âIf\n1}TL/ﬁ\"f§ŸãôW7âôÄbñKµò≠W$Ê¨ÎsÓ◊ãˇ<≈Ç:òXl$ü˙øHÑX:ŒÀΩ≈›áº≈=õVƒ}s◊ƒo¢Jƒo¶ß≈FS‚∑\"≈#ˇøáè&=‚—ƒlÒ®-˛4Ñè•`≈S=‚Ø6äß_(≈ﬂW{ägF°‚_\\Ò¨Û^Ò‹Û)ÒB≠©x°cF¸˚p∏¯∑h^ºñ$^\Z¸-^3î®8≠ñ¨V∂I4êñÌÓFâŒ*M…˙Èhân:O¢◊ÛH≤Ò‘:â·æâ˚ëƒX7Mbå\\ê ñòXˇíò‹bILG√$[™-%[∆%Ê˚%Êê|â≈/…÷Z¶d€>îd;…X≤£ÒÜd«/äd˜˙óí›øAÎÑlîdOÅªdœHàƒ.¥Zb◊πUb\' ŸwEW≤%9∞Øƒ±dü‰V;âÛ}∏ƒ%\Z(qy\nói¥ó∏¢≤$Æ?%nU%ûa≈œï#í£ÔœHº\"ŒHéeÍJ|»›_Ôﬂ‚ﬂ{øÛhâﬂÃI¿ˆﬂí¿¡RI	sI(π] ‚J¬üúêDÈêDnWëD‚<$ë‚9I‘”’ísuItËÄ‰ºë¶‰ºbã$ˆd•$^ˆQr…*Zriö%π \rï$˙ıKÆ9HÆÂKR˙í$)øËíT\0EíVï§â8íÙH?…uıH…ıò|…\r±$”Ø@í	ï‰~jñ‰õë$wåŒH\n’z%Eﬂ%≈ª7Hä_?ëî%˜jZ%˜m~J ŒíîÅs$Â‘kí\nœ7íá5æí =Ví w˘í*ﬂí*¯;…£â…„FmI\rÍë§Fæ\"©=.©Ω,ë‘9≠ó‘!\Z$ı™Aí\'áˇI\Z¶”%ç;å%œÉ˝%ÕÌrI3vø§%◊@“ Ôë¥=í¥ˇHît¿<$Ä¿`	 ´ZﬁˇFNˇ(~I1—dÖø≈ ï†¶’$Ëü}L±çÑ†g !æîêŒ9IHyq“Û\n	UsIBÉ\rHí	*ípfoJÑŒ-°E\">zH\"ÈƒId:SyëæD¡Jñ(W≠ïÙ4WHz√r$Ω…+íæ≥±íææ Iﬂw§‰u`ò‰5E_ÚFó)y3a y∑<!2ÆêΩVJﬁßÓíå®JF¸[%í:$£zUíœk,$co5%ìÙ[ío)ñíoØ$ﬂ\rµ$ﬂÕ(íÀÉíŸ-7$ÛÛíﬂFíﬂ‰/íﬂK…_ô‰vH≤»hë,πØñ¸˝ë%YˆJñ,˚˝ë¨ÙHUÏI“UZIRµ‡6©˙˜/RMˇ	©Ê+πT≥ÛùTÀ∏B™uwèt≠3G™Ë&]7n#’ô¶H7`Ì•F6J7LÅ§zwI7N≠íÍø€\'›t:I∫y›ˇ\\•õ;W§Ü»©±£ÜtK¡}È‹!ÈVt≤t˜ﬁáRÀ®ìR´œ˜•÷â≥“=?Á•{æR€DM©›·Ω“8ÈaÌRg†¶‘%˝∞ÙW)u›…îz®oóz\ZÇ•û÷2©Á«(©œ=äÙÑ~ØÙÑÂ!ÈâêU“ìv[•\'/˝íﬁﬁ$\r‰øóµ9KC∞\nih5M\Z⁄ñ&\r”ÏíÜ-˙K√1π“3\ZÈôµü§(å4Í¢∑4ZπWzA.Ω@Nì∆Ó—î∆ t•qÖª•ÒöI“œ`ÈÂôÙz·uiÜÛ§4s∞Jö’‘-Õ\Zº-Ωi˘Jö=vUz€÷[zS\"Õ€ÒQöoÇìﬁ˘ª,-¯Ì,-¯Î&-§nëQœJãæ˜KãUã§≈Û]“Ìfi…PßÙ)Lzo¨BzÔ´•Ùæ˚ÇÙ˛µFi9¸ñ¥BÎÜ¥bzùÙA˚CiÂ·“JwÇ¥:∑\\Z]Ï#≠—íIkº\Z•5Ü“⁄fmi]B±¥.SUZ◊@ë÷;∂JÎ›KüÈÜJõç•Õc§Õe«§-·F“ñÖK“\Z§/ ∂H[À£•mÑ“6•ß¥›∂D\nà˙#â§‡≠ÓR®ÓÇ⁄\róB=•õ4)\"¶[ä)◊ëb´ö§XÚc)æZ %fÕI©É+Rñ∞_ Øπ\'›óJöWKÂÁ,§Ú_-R≈gg©rnJ⁄õÔ,Ì£•\r7•oø∆KèîK⁄§ÉﬁKﬂ’(•C#PÈ»]È»aGÈ«òç“èÂ$Èÿ¢tº˝ñÙK\'L˙eŸY:MëNfJßß2•ﬂÆ §ﬂUJ˙ÎIÁ…y“˘üPÈ“ìVÈÚπ\ZÈr∆®teïñtexX¶rrJ¶⁄h,[=ÛM¶>≠îiH‚d\ZÔ∫döS2≠t†L´ñ&”˙ñ*”˙ì/[ß-”∂fÀ÷˘Sd∫ı€dzVŸ2Ω=z2Ω_ô2}ãô~ñ°Lø!S∂ŸYKfp^f¸õ 39‘\'3≥wóôø¥ñôÂ2s \ZôÖ5Ef¡√»vÿÆëÌ˙ªWf=≥\"≥©íŸÓ2ìŸ∫ lÉ/»ˆ€\Z…Ïw9 ÏGñd” Ÿ°ñ«≤CÌö≤Cø◊»ﬂ∏#sVKñπåëdG ≥eÆoÆÀ‹4«dåd76 éùïyek»º˛UΩ&éÀºßÆ…¸ﬁÁ»N¬ˇ»NmäñùJP»Ø[»Ç~_í€±e¡˚*e¡æ0Y»ù+≤êqê,‰ﬂ~YhG⁄íùﬁ•êùâëEn@À\"wgÀ\"√∂»\"ßÃeQæ7dQO ¢ué ¢Ø¥»b,zd1nπˇ£Àb∏I≤ÿ¨,˛L˜cNø£C_&ªTªEñ\0âî]=ÙTñ¯›_ñT5/K≠ì•*î•\\ø+KÖ#d◊7Ã Æ˜±d`oŸ\rŸå,”Ûï,k∞TvÎÛ¥,[,À¡Úd∑ÖWdynYûﬂŸù@Ÿù|YA\ZKV–.+RMêΩê}\ZîMmîï¿ÕeÂAY•û™¨2£JVIŒê=z${Ù¥FV=¯TVõ˝Fˆƒ\"^÷0 ñ=ã˘.k…⁄Óîµ…NÀ⁄.≤énKŸ+ïZŸ´¬RYÁ™aYgƒ^@á\'Me¿±aËHîÙ|èrmü˙,L[Ñ…0˚Ád∏áèd∏	;>ŒTFHŸ\'#9!ed˚•·ÑåÒ€K∆‰˛ì1Kd,ˇ\nGΩN∆”£ ¯|ôP˜∞LTU,ì0úeíÓG2iﬁNôt M÷ÖLîuaé»∫™ÀztÉe=ˇÔﬂkﬂ%ÎÌ+p‚À\\ø ﬁ∫˛ï\rΩìÀF|Wd#Ô∂À>ƒ‰…>\\Y#et»∆‘ô≤Òk\Z≤Ò2∫Ïã™Ωlr«!ŸdOälr¬G6u‡ãläñ}}Ê,˚uXˆ≥™U6õΩ$õ-\\+[(?)˚]c+˚„∂Qˆ˜p¶ÏüTˆ/Á¨\\≈†]Æ“‹+Wè˛!WøZ/◊à°»5≤T‰öΩbπÊÁﬂÚ5OUÂ⁄˘Â⁄/ﬂ ı,r˝v\rπ>ô.7ÿˆPn\'On|?Nn‚<\"79ıBn“Nñõ\06ÀMæ\\ñ[8HÂ€ä∫Â;Ñ€Â;ï?‰;K‰ªƒÚ]∆yÚ]ñˆÚ›ô‰ñÅÓrÎï$πç„-πçãö‹∂TEn˜§Dæq@n{N~0∑M~ÿ™O~òëª:<ïªÌZ%˜ÿ‰.˜B, Ω∑.ÀΩœO»}6˘ }∫=Â\'V/…OEî ˝˝ø ÉÏ…Ú‡¬,yËçZyXÇÖ<L9#w[îá◊ Âß{ﬂÀ#∂uÀ#F˙‰ë¡$y‰Û5Ú®cJ˘π§≠Úhù˚ÚÛÙuÚç+Úÿ∏:yÇeá<¡ŸDû0Î$ø≤ˆä¸\nı†¸*lQûh2&O<%øÊáë_˚◊*O^áí\'”hÚ‰!û<Â‰iy Ì\'ÚîÖﬂÚ4£˚Ú4%Uû—ˆH~√G_~„¬˘çz˘MËIy°I^XˆV^¯L /BRÂ≈G_…Ôk∏ Ôˇ–ëóØ1îWÈSÂU&>ÚjóÁÚÍ≤˝ÚöÛSÚ⁄>Ky]«∞ºq[∂º±zT˛¥kï¸ô≈NyÀı-ÚóÖ,y«üÚŒ°\n9@ë/∫ ‰¿T9Ë«§Ü±ê√Wùî√±NrƒÊ\Z9bÂõiW,GÖ…—üòr„≠Ô)«Áﬂêâ˜Â§∂e9yO∞ú,{*gÆØë≥Ÿü‰<“äúosT.∏\"ÓÖ ÖÛNr—πªrâoõ\\$ Â«»ıŸreqüº;©Wﬁìº$Ômãì˜7V…û»ﬂÚ»Úa;¥|ò~Q˛ﬁ%ˇÿ_\"ˇ8n\"ˇ‰°%ˇ|G]˛ì\"˚@ñO§ô»ßÍo»ßü®ÀßW∞Ú™ ˘èè0˘ØÚR˘ú w˘‹Ïn˘¬bë|±pH˛/2U˛/;JæÃMV¨.¨S®€Î+4◊Ph≠âP¨Mx¶X∑cØb]ÚC≈zUòbC∆.≈Ü¶}\n›eU≈∆ÌIäçeª˙∑√æ;õV´+=˚&nXÖŸ\\ÑbÀs#Ö≈MkÖE˚Q≈VU∞bÎv¶bk]ìbõJ±c«åbßwΩbg‹k≈N¡y≈.≥Ö’ürÖuŸnÖÕïÖ]L´¬>µKaˇ˘≤‚‡Ê,≈¡%[Ö£zÇ¬ë:°8ûü§¡!>‹Öo¶ë¬/;Dqb≠XqBøKq‚sª‚‰93≈©ø’\n≥\"Ö?°R∏ÀWË{C¸–LÚ≠;#SÑei*\"÷N)\"Bfë¥|≈Yómäs˙kÁ˛™+.pró÷0óè/(˝(Æ]˛ÆH⁄#P§ËøQ§Öe+ÆﬂÅ*nlûW‹à≠Qd¡ùŸ)äúÆZEÆ≠ë\"˜fà\"W	W‰≠ºR‰ã˛)ÚGw*\n£Í≈∆⁄ä{6`EY¬zE˘»®¢¬Í©¢rˆ¥‚iAQsıà¢÷€BQ€∞§®K›©x¢_£h–&)öº⁄M),EõπΩ‚Â™5äNdï‰uHö&*†±¸√:Ú·3Œ∂KÅ;È§¿7ΩW‡€ÇxÙ=^È¨†ñ;+Ë8k#±F¡∏™`ˆ+Xjç\n#N¡Ó6Rp}Ú‹ﬁ[\nÓòäÇ∑Z†¨ˆVø*Dñ\nq„ÇB¸‹U!9—´ê]Ç)d\"Ö¸ÌÖ≤D™PV_Pt*^ﬂÖ*ÜÒäwz¶äwÿä°€G√b§b∏á¨—Q|¿”∏b≈«èEäO˜Èä1úb¸Léb<ΩT1ﬁuW1±…GÒeCü‚ãS∏br›¢b2ß¯vÊ™‚«πCäü‚r≈ÏŒ}äŸ4w≈Ï´/äy∂b^+J1Øø]1ˇÛêb9uèbπ©L±2S°T?™TçTÆ.ÚQ™5Ù*◊(Ö 5_+◊Bï uÑèJÕı ı\'˛(ußÔ*\r^*7KïÜ_˜)ç\r -èãî€-6+w}MSZÍVZùØR⁄¥QÓqê(˜Å5î˚óçî∆ÀJ.Ly–h≠Ú`ñô“—fVyH©t\nB(ùûΩW∂™R:G7*]Æ/+èhûTÙ)]ÈKJ∑hê“c◊¥“À›QÈıZWy¸≥ó“˚Éõ“˚Gö“OyJy\"ê´<iUûä4Rû¢≤ï˛˙t•Í•÷se†]ë20å§q{Ø9ıNz{A:ú°√f)√f® ”V0ÂÈÃ 3q◊îQŸ\'ïÁ∏~ Ë§\Ze|É∂ÚíŒÂ•*±2·Û]Âeº@y≈¶EyuÏÑ2qáô21ÍÄ2±pªÚö˘[eívò2IJQ&∑*ìóØ(Sc*S± Îgﬂ+3E% Ãèı ¨ÖÚÊÀZÂ≠î!eˆôeN‹¥2Áâµ2˜Ù#eû’>Âù\"é≤¿§,hW†tïw7;(ÔækRãï≈˛\r ‚n\'e© [ÂΩèì ˚Q ˚y ≤æte˘%°≤úéSñ⁄•|ê?´¨`+ùåUV≥• Z¿ceΩ‘S˘dë¢l<∂¢|\ZÃV6}ôS6{ç(_®˜)€8óîÌk|îÌ…;ïÌ’	 vZø≤ΩªO˘ V°Ï<vVŸ…QS±ï‡™ÉJXQå.G+”Wî»≠Îî®˝X%˙,Lâ˘°ØƒåU‚¸û(Ò\'Ó*Òël%˛ûáíÿ≤_IjIWRd))#cJ™WΩí°˝[…p&)©B%3SW…9a§‰_+94®í€åUÚrMïº˜R•–ó¨~/SJ!J…ÕV•‰˜s•Ù„•|qΩRQt_©å”R*üµ(ª√¬ï›}¡ ÓîΩ˘€î}ˇÔ˝6Ó±ÚΩ≈Â˚ÂÛÑÚ”„C ±⁄)ÂD1Y9_PNeÓVNµ\\QN-\Z+ß?h+øª(ø˝Gqyás·u\\()°!M•BF»àPF	âåR°î(´l*Ÿ≤GT¢¢R……Ví—}˜ﬁ{ÔiÙ˛ﬁÁ<üøÓΩœô˜‹{“ˇrQ˜ˇr…∂˘W∂˛~:¸WtjÁ_QO˛_ÒøíøãÎúˇ. u˛.ıí˛.)€ˇ.|wEÙw≈¬†í∞Í@@5.†⁄7P≥∑®\'‘ÁwVá∫V‚k˙M\Z%æÄµ≤¿∫â=Äı¡”Ä\râ\0mÓEÄŒ¥=@◊í–ıQËVËN66ùhlj¨\0l~∞ı\0∞}”U¿ˆ·%¿ÓãÄ›oB\0ª˘ﬂ\0¥^¿ﬁ∑rÄ!∏∞Ô~1`_%p†-\n`åªj\0åSÿ\0ã·˚\0õO.\0õœÊ\0€5\0€J¿v&`◊p8¯‡8á808›{pÒÓ∏úé;<8Vî8~n¿’Ì.¿µ‹‡÷∑pr}¿k≠¿«+‡ÛÒ.‡¥ë‡ø‡õQ	8≥8Û™‡wÄ	sú¯/H\0A«sÁü¯\0B‘^\0B\ZÄãPÄã„R¿≈©áÄ–∫ÛÄpïÀÄuS@Ñm\' ÇÅ\\]ø∏∂s‡⁄πä∏Æ`n4_‹4Û‹—‹|∫ìπ\ZwsﬂªêÿÏ\rH3$œíeMÄ‘ƒﬂÄåsL@Êm5¿ù!#@ñLêµú∏ˇ6p‡\r ÁêsÓ\Z ÁI4 ˜À†®u/†¯÷N@q€f@©\nP6èTÏ8®äd™yœµÄ⁄œu@¿„¨9¿„wıÜnÄß9ÓÄßmw\0\r?g\0œj˜ûçkû7=º8¸\"ﬁbÃ–t˘†ÂÎ~¿‡MI‡ÕÛMÄ∑6çÄw∑{\0Ô˛¥Ó¥F¡\0ÔÕÚm˝FÄ_O@˜˛0@∑Ôq@wS.‡CF†Áø|ˆm=¯xD\rÒd‡cÀ‡£∏È…$` ;\n0Êå|â|©≠|-|≥›¯6cò≤0LßNf¸ÄôA%`6ï\n¯;¯°√,£Ü	¯©¸vpÃ˝)¸…∑\0¸ôª\0ò7¸¯ªO¯˚˜\0$<Ätó†kÓ†ﬁWH“	\0Jº	ÄR†øN0‹\0BπÄ§Æ†!Øÿ,4Ä≥\0‡ã\0Ù=Ä0π æiê\\=êp≠2X\"@~∆†Xµ†¯4X‹{∞x		X—2¨–ºÅ*û∫@ïpp’±T†ZÍ$PcÏ-Pk–\0∏Åãj7münän6\rÍ;æ\0ÍøHÍ/|n+9‹æØ∏g_p·\'phxÁpﬂk:¿6\0¥h‚¯h∫∆h∫3h∂¬\0Z¥çÂNÂÔZ⁄%-”ZÄV«Äá[]Å6ÁFÄ∂ÈÌ@€˛∑@«G5@G¬3‡Qì†S\rË¨¶tæ|Ër`\r¯R<–X\nÙ∞›	ÙHåztgOŒÈ=∑oz“TÅßz;Ä^5a¿”6÷¿”^Ü¿3Cû@j0‡˛m`p‘s‡9ü‡πZk‡πÜ€¿Û§`à…+`9\rB˝ºhß@ÄW·R`‰w`‰Ô`‘05ñ\nå>ﬁPÒﬁÔ∆º}åı8åkú∆Ä∑``‚û?¿ƒkOÅIiÄ…ç˝¿‰:¿LB#Œá\0‡ΩÑ˚¿˚%¿lª^`v†0;ƒ	ò˝j\r0wiòó˝\rò_åÊœ\rNâÄ√ﬂÅÖO0¿¢û¿7ñÅ%Iì¿“\ra¿2Ö∞¨:∫\r¯PO¯–.Xw∞\rXü(>˝Ë\n|:u¯,dπã\0¯‹˚≈≈;)∞i`ÿlÈ|µ|M-æq\Z\0∂˛—æü,\0∂yM\0;‹”Äùﬁ›¿ŒŒd‡á˙`œ˛~`è-ÿ7∑¯Q<Ï◊±W‹é:üé%ÆéµRÅcÄ_˚GÄì5P‡∑q+‡Ê\"pÜ,Œ^Ÿ¸±±¯√Q¯+3¯kÆ¯ky¯€{¯õúÎ~\\¿m˛›ÑD°Òr ÏŒ ¨¯\rNr\"Ÿ.@î˛# ZΩàˆ˛	DüﬁD◊˘Ò◊è	$@\"r;ê‘;§}∫§s ÄÃ0êAJ2ùÄÏ´ÄÏV ßÄ‰,oÚ^X_rÄ¢Gs@ÈŸ@Y°-P˛cP±k®dc&ÄKFÅ¿•Ç˝¿¡t‡øÀ™†UÆLêzî¥zÎ–\ZbHcbhùπh˝1h}d#h=œ¥Ai	\0ÈÜÄA™Ä6óçÉ∂Ù<ÈÈAzÄ%–V”g†≠_/ÉÙOÅ∂=‡É∂˝4mø·\r⁄ª⁄Œ√Äv:¨Ì|q¥≥U\0⁄%˚\r⁄≠w	¥«è⁄ªZ⁄ÎR2¥˜ÌÛ>	:†sd£Äôyúô∂ÇÃ´mACØ@á‘™AñÙu†√«ÔÅ?„ÇlüÉé0Ê@éGg@ŒˇâÀËX 9–1Ïê+r≥hπÁˆÉ|.4Ä|Ü◊ÉŒ<ÿ\0Ú”˘Õ@˛ˆi†≥œÉÇŒÑÉŒUÔùg”A!œcA?Ì\0]∏\0\nΩ4\n≠®]ùq]≥Ωäå\0∫¡\0ÉnNNÇbWo≈=I%0ﬁÅnÉ˜ÇíÔ%€˝%ü\r%WòÉRm∑ÇRˇ$Ä“ê?AÈ©*†;1s†;∑k@w™ë†¨¶†˚/A97Årﬂ˜ÄÚå◊É\n&@ÖÎAEäœ†‚ßN†‚WÎA%_ˆÇJÊ\ZA%$®T	*˝≠*€*≥@¢AU≠gA58}–C\nTÎÙT˚\rz¸®TÔêz⁄‚j }z…\rΩæØ\rzªqÙŒ ‘ö+ΩÔ‘Ωü;jÛrµÅÓÇ⁄y†q®s≠#®ìYÍ6«Ä∫Î‹@¨ˇÅ>T^ı∆ÒAΩ21Ë„˙m†A◊\n–`Ê\Z–ﬂ4∫˛8h‘◊4⁄)çæ\ZüΩö(WÄ&z€@ì>/Aﬂ\\E†©ß◊A≥N–wYËG£?Ë«ó›†_Ñ\r†ﬂ¨}†É?†Ö/Å \0I‹∑	ºﬁk-Ç oR@P¸˙œK´¡ÒL\n8¢Ìˇ	¢˝~btΩ±ù@l`à≠PqﬁºqC ﬁ%àÁûÊ\0A¬ß@‚\0Gêu$}~$s&Éñ;ÇñQ?¡*´wÅUs∂Å’’¿Í;∂Å◊Ãük8Ä5UèÅuº`›Éﬂ¿õwáÇ∑l˝ﬁñÉoõgÄ∑-∆ÅwﬁÔ*¨Äh`√œ‡˝á¡&™Ê‡É\\\"ÿ‹iÿ¸.l^∂d∂Ä≠´¡6:E`€õ`{— ¯H˘ÿ·6Ï∞`vÓ÷;”\0ªå_ªÌÛ{¨*{Ø?ˆ.ÉO7yÄ}kg¿gÆñÄ˝Y…‡\0Ì◊‡\0z68p&H]\\§ÄÉ•n‡ÛŸ‡≈k¿œû_9ˆ|%GéÄ]G~\\_◊¬Éod€Éof6ÉcéÅcÚÉ¡qep©\'\'ÏÈﬂ26\0ﬂRFÉo_≤\'n§Ä·„‡îµ‡‘ûﬂ‡¥≤0pZﬂp˙Ñ\'8]fŒ\\7Œ∫0ŒÇ~g¡b¿˜ÅÔè¬¿y‚(p¡6{pAŒ!p¡ì‡/piÕspô\\~¶\0\\q◊\\kgÆÛ\\◊•ÅÈ›?˛∏~\nˆ7÷OÄã‡g\Zπ‡gÌ,sO;Û∞ß‡Á7g¿œkwÇõ∂6Åõå’¿M«Y‡ÊtÀ+·‡ó)!‡W∏%—¸Nq\n‹\n£Å€/çÇ;l√¡ùM\0p◊	∏˚b3¯√ó)p5\Z‹|ÓW8Ä?˝xXû?;YçèòWÅG.óÇG*ê‡QµÎ‡—(kh˚ggKSWU.¯´Ø:xÚ!¸\rœODÉß£∑Åß€x‡œ?‡ô{ª¡3ã\n¨ﬁ+ÏnKè¿pœp*¯Áó«‡_¢≥‡πÌp¸ı¬ô‡Öª¿¿È`‡œG`–}6^·FgÄ—â;¿ò´00~ˆ5O)\0[∏`“—œ`R_òÏ6	¶Æ©S∑˙ÅÈªV¿Ù[ﬁ`ÜˆC0ÛD4òµæÃ:∞Ã6ëÅŸ.O¿Ïz(ò-lÛÉ¿¸r0;U\rÄ≈[í¡í˝˙`ÖˇW∞º¸oŒ¢ömQÌ∏Q3;	Qg~Åh¯WA4«L ö_á ZöLà∂E=D∑R≤±Ê!dS…1»ñáUΩ3∫˝Cë}Çd[X.d[„)».≤ã‹\rŸc˝≤ß\n1l‹98°1˝¯bÜòÖò˚ùÉò£Ds°#ƒb}\Zƒ\"Øb˘È)ƒJÀrX√bìe±ŒÇÿ›bCÏı?Bé¨æq®˜Ü8zÏÖ8%/CúÉ⁄!.◊Ú!«ˇÃB‹p∑ n“à{¯A»…vàóâƒ{Áƒõ∫r:·$‡ÃH`I7$»dTDÇú[ﬂπdÄ\\≤ÉÑ⁄P ·2!·ÉÎ øˆB\"ÊÍ W§ê´9ˆêkÌiê»‘d»ıòê®gHTr;‰FG8‰fâ\n‰&˛\Z$¶P\rS}w·<‰ñz‰VÒ\0‰ˆ’Wê§öê$G#H“ôªê‰}HÍH*$=Ò$Ωk$√z$S|r«t‰éü+‰˛∫N»}ÍzHvæ/$o\0…ØåÄ‰≥J!Ö˚!Öó ÖπÈê¢◊êbÇ1§ƒå)π&Åî>‹)è\nÅT.B™ú9ê∫Ò»„Õêz˝ê˙?Ø!Oml!O=[ O´˜C\Z}!\ruAê∆—uêÁyx»ãZ\'»Œ(§IO“ú‡y9õ\ny›>iâsÅºŸ°yÛ˘.‰\r\ni}}“ÓQ\rit“°•È‰	 ];!]è¿êÓ¸≥êÓä^»áUMêûÉ˘êûCÖêû£o =È$HÔS§/Ë§ˇì2‡ˆ212\0π|Ò2ˆ˜$då_ôXˇ2iÇ|;ôÚXÜLóÖBf´r!~∏C,á _â!êSÂ®∆k,1Çx{Ç:›¡‹ﬂ\n¡ºª	¡õ©C6\rmB‘˚\n!nÎáê6d@®;L!åSﬂ!Ó Ñ˘Äa=NÇpv¸ÑÂ$à»ø\"\Z@ƒ¥-iç	DÊí\në[kB‰∑WCzêEØ˝ê≈?ŒPïı,®™Ìc®Z=™·o]è√CµÕAu=U†yÊ–-˚´°[é@∑<Ëányª∫Â”-®ﬁ¯6®æÒt˙ t{´:‘‡cto“Ëﬁ\'–}ñÔ†˚æ&C˜9\r=ÿ≠5çÇö˛\rÜö›¨Éö˝°@ÕèjAÕ36C-j.B-°†ñË+–√Á^@ÌbP;q:ÙàÉÙ~ÍîZu	ˆá€˚zÏπ\nÙÿÎ”–„ç⁄PWÛ«P◊Yu®0Í¬@O¿s°\'øœB=˚;†>·\rPÙg®èê	=ì˜Íwv‘o¸‘èÖÑîÑ’¯@œŸ®Aœ)^AC¨øCC~*†óûÕB√æ∂C√}–+2hƒÊM–à¶˜–õñ™–h4Ó…;Ë≠á·–$˚,h´\nö˘ÀöeZΩÔÁ	ΩüVÕ˛È\nÕ]âÅÊÖ¥BÛB†?f°≈~⁄–‚Ÿ«–\nZ÷´ÑV>C´dÓ–á\'ﬂC&®Akµ.Bkï&–⁄ï%h›Öih]F\Z¥n<˙»¯\rÙë˙®	≠îCü´/@üﬂvÅæê÷C[fí†≠ª^C[ß€†Ôı™†Ô˝S°m3xh˚∆–ˆÉ–Æ†`h∑Í9hèG:¥Ø°È?8–Å Ë¿s.tpe:bkÌ¢B«bT°cµ3–ØÁ∂@øÅØ@ßØ@gÔ£†≥‡–Ô{‘†?}ú†?oFCˇTØÖŒ_àÅ.÷Ö.ÿ†¿›((HÜÄB>A!}PËñV(|h\0äºnE\'A1R(¶däô©Ç‚âg†Ñ\\<îË¥	JlNÜí$P“≠ùP“õÔP≤⁄(e€V(µm=î˛W `H†ñîµSeΩKÖrﬁ‚° €ÅÚf P¡ôWPÒR2TJÄ v|Ä b®¸Ö)T±◊™àkÖ*Äø°ãı+–•uó†K’°Àæﬁ–ÂG-–ªB†ˇNÿ¬TÚ<a™∆π05Ô∞’`´—∞µ¬÷E0Œ\'ÿ∆ˇ&‚ç‹˝0=√µ0=Alki#Lv7l€˘ÿéêì∞âáa{l÷√ˆúvÉÌA¿ˆF÷√ˆŒ¿ˆ≠;\r€˜Lv‡	v‡Âò—]ÃÿΩf,¡L4“a\003Ûo0Ûtò˘Èõ∞C—◊aá ˇ¿¨º~√¨ÆÀa65}0{Õ9ò}f?·s∞àá9˚©¬ú_aŒ§#0óó(ÿÒ	0∑Oæ07–,Ã#ƒ\0Êﬂ\0;qÒ&ÏT˛òÔ¬Gò/7Êª∏Ûª]\nÛÉ≈¿¸e@ÿŸ¿Ì∞Ä4,ÄßÀÅmÿzÚ¥îﬁµ	vnv.È#Ï|!v˛yÏ<‡ÏBßv°«vI6≠ÖÖE>áÖM>ÄÖ)\"a·ﬂ‹aOK`WwG¬Æ=ø	ã“ˇã∂\nÑE§∞o–∞ﬂΩ`1!JX¨æ,∂ƒ∑”«|K`h¡nÂõ¿n[[¬ío¬R¸v¬RbB`)Ï)X™ï,}ª	,£ª©	ªSª˜Ì*Ïx=Ïû4ñµ∫	ñE˘ÀüÖÂv0aπZ∞º§rX–ñﬂ˝ñÀÅl¬\nˇ‘¿ä C`E\\2¨∏‡¨xTV™¢+5Äïf©√ ˆ]ÑU¬aÙ!Xeü&¨¶Ù7Ï·ÿCà/ÏëˆäÉ=©∏\r´_ï´8{:ük*Ä5:a/6¿ö«aÕÒ«`Ø¸6¿^√ﬁj5¡ﬁy¡⁄æ.¡⁄›>¬:lÜ`ü`]˛·∞ÆÊ∞nﬂı∞´ê∞[§∞µjXœ37X_ÜÏ#èÎ\Z√>çá\r8[√ÜNÑ\r›∏JsÄ\r=T¬FÚ«`£]Û∞—1}ÿÁÒª∞â5>∞Øπÿ‰.lÔ˚ñuˆm:6µ˙=lÊ6\0ˆK˚Â∑ˆÎˆKnõ;≠Ñ˝I_ÑÕWﬂáûºÅÅZa\'7‰„\r¥g\nÔ6Ç!\nÀaàáóaË6xõ∑Ü˚S√	Å·/˛Ö—SaÃî,˚#GŒÉÒÍ>¿x”Jò‡”^òƒÚL“ìπÁ¿´{a\nI&LŸø∂Ù>∂r±∂íæÆÍ>W{ÀÇ´ÎD¬’€‡´u5ª#·k“n¡5ü”‡öl¯∫∑ﬁuÉ—p≠n\r∏∂˝(\\˚„.∏Nˇ\n\\˜N9|cq|S¬,|SÆæÈ˘)¯ÊUW‡[Í·[~mÖo∑µáo˜˚ﬂÅ~ﬂ∂ﬂΩæw„#¯ﬁøø·˚Çv¿˜µ9¿˜wy¡<iÜŸ¡ç<\r‡F‚N∏âG6¸ ¸&‹¥W7kó¡Õ‰O·Êæ•pãÆ:∏•È	∏Uv‹⁄+n}û∑Ÿnwan¡	~Ñá;Ëî¬t·éØT‡Gõv¬è∂O¿è˛…Ä;˚]Ü;ﬂ;?Ó+ÅªZï¬]õ÷¬›ßt·\'‘‡v—Ÿ\rpœ‹st~jım¯)Ù‹wÛ∏ÔÅü¿´Lx`e¸<ø\n~q∆ö6}\nÈ¬CôÊÀã0¯ˇ¯ï\"<‚Â\0¸∫!\r~}rEá¿£gŒ√c√c\nl‡∑‚¿DùèD=x\"Á8<πﬁû‹xû∂üOªˇûÎÇßÀF‡{‡~Wµûùzû´üœçÅô>á˝~JÄ?‡ñ√À˜˚√ÀÎË\nì?\n˜œÍˆRxÕ˛wá∑“‡è«œ¿ÎµR·œ<7¿üu<ÅøL ¬_+S‡ojË÷+ˇ‡Ô˝·m\'|‡m[x€Ú5xªa:º˝m	º„Ëx«ùΩˇxè¥˛Úÿ˙ò˛ÇÄèPÕ‡£#{‡cG∆·c!.±ˇÙæÜá±˚ˇ èÖO÷ı¿ßN∫¡ß\Z∂¬ß…Ωi·W¯¥\\>Ω¸>Û >√*Ç_óˇ´ˇIÑ¬[∂¬ñ¬Á2·◊ˆ¡ÅÈk‡‡mœ‡‡À\'‡‡úUppM∫+ı•¿±.&p‹Îp|’f8Å\'Ÿ[¬◊7¡π´À‡\\Â&∏`Ì∏\0r\r.6Éãi¡≈D\\∂Æ–ÙÄ+O¸Ü+\Z‡J‡u¯\"dæÙ_›.1u·KÀÔ*ê6Ñ™)bıÜxƒö «çäƒZØqÑfIB≥w±°¬°s¡°Ûk±iÕ$BœM°˜x±mõ±≠w±Û∆3ÑA^!bœãCàΩœc{I%#h ¬xd\r‚‡ó=àÉ\\¶æWC˘À7ÑU◊qÑMŸkÑÏ0¬´â8ÚG·‡s\n·ÿºqtπ·l·ép∂’B∏.!uà„ÓˇÆÏ1Ñ[ß·æÒ-¬=ZÑ8yƒ	q≤<·yl¬Û_\n‚î^#¬Îr\0¬k\Z¬«§·Î5à]°\"Œhq~ß8ˇπdÑ?…∂8ÜAm∫ä™˙äíE\"ÇEIàs9÷∆\".–V#.™ó∂Ã#BÕ»à–§õà∞µ)à∞ëfƒïƒïa‚˙∫>ƒı´`D‘*)\"ÍR#‚FD\"æ¬ë†ÄH˘äH*Ò@§\\@!Rﬁ3©ß*w*wààª…#à,É(DVÂƒ}”Áà‹õæàÇsà¢‚Ó¢8üÑ(~ç(ØFîNé\"J˘`DEZ9¢Ú»oDu—DÕ’\'àö«µàá÷nàZèvƒ„u«è˝ÜèÁŒ ÍkÙıÌEàß´ä\r`\'ƒs–\n‚E⁄¢©Ï9‚=ÒJ˛Ò˙ä¢eÂ&‚çA‚ù◊>DÎ«D˚ÕDÁ˛ÀàÆ€£àÆGqà.•¢ªˆ¢~—˚Ã—áF|ôFÙÌG\\ÃBfd!Üä~ Ü9ª#Q7„´\n„auà/ﬁRƒî*bbØb‚ˆWƒDıyƒTfbäu1C˚éò˝båòùåA¸\0]F,|◊E\0P˙‡ép≈cD˜;∫•	Ωﬂè@oπâ@\'ãËOµ¸±˚¨A◊éA∞X˛ˆ©<ªæ¡i>ã‡,E~g#D+_‚A[Ñtr!€4éêT!ñ¬¯à•ƒ“¸0by◊ƒ≤+±pC¸K¿#UÚFê*KHuÿ\0RGÆ÷yç\\Î∂à‘r/Cnx§Ö‘é5GÍN˝FÍ˛¸É‘%E#uó‚ëõ8ùH=YRˇd	Rü”é‹Ó∞ππ„]róJróy\ZrWÚ$rœÌb‰ﬁÖ„H„ÃkHìÉF»Éõñë¶Ω5H≥˝(§’ı%§ıìU»√£sH€M\"§mH6“æ®ÈËÚy‘ùÖtJ‘F:e∂#ùÛíê.\'—Hó{vHóäI‰±»Á»„;µê«Øõ\"]”_ ›Æ#=∫ëΩûHœ≠iHœèˇêß÷ﬁEz©Ë Ω∫fêß\röëgba»35_ëg˙¡Hˇß}»≥J2‡B2∏\"rm-Ú“„√»–ßëóO, /_¯éº¸ªy’§\nyUèºV◊Äº∆„\"Ø\'g\"Ø?æçåÚÈBFO¸Aﬁ\\πàåŸVÇå)hE∆∆ÆF∆N«#„µi»ıÎ»Ñ=‰≠dJI2•JôÚ ô…tEﬁ’JAﬁ})Eﬁù+Df%	êYH2?˛52_yYòé,ﬂA\"4êEbêÃê•……»“ØêeOê•Áêÿ» 3Wê5	9»∫4M‰£# ‰ììªêOB-ëı7#êı„.»ß±»ÁbdÛ˛Z‰À$U‰+_ÚÕÜ»73»w}kë≠´Æ!ﬂüãB∂ØyäÏ|°äÏ>CvﬂlF~`®\"{T•»û?doŸó5áÏ´≤Fˆ°‚ë¯\"á^∂#á€æ Gí GP÷» ‰ËÂg»œkx»	á‰◊C‰‰Q5‰‰çT‰‘ó7»È˘m»Ô46Úáü˘Û-˘+Ñá¸UB@˛>Ú9˜|5Úè∆0Ú¸rûÅG˛5AÇ\nTê ©‹ÆÉÑuw#·7\nêp`ˆâ∫QÉDÎëËKˆHÃT\rçƒé5!Òä$—Ò!í∏2ç$/<F“{ÑH∆›Q$cÿ…êL\"ôÚY${\\…!ÏFrS+ë‹åØHﬁ∫§†˘R<è˛Ê#≈c◊êR\r§îéBJWFë≤ÕH˘ßsH˘)ó≈!ﬁx§r3©‹ü˘À»≈5ﬂêÀ∂»Âêh‰2Â\rrÂﬂ3‰?•\'JE @≠⁄úàRHD≠∆©£÷®ùEihrQk∑Y†4∑~Bi∫-†÷ëx(-æj√>jCdJ«ÈJgÏ;Jwı+îÓd	j”z‘¶j≥fJœÙ+Jœ/•ó˝•7Úµï}µïÉ⁄ˆôà⁄—PÄ⁄π∑\ZµÎÚ_‘>L	jˇÙn‘‰2ÍÄÉ2 ì†å]÷°Ljo†¨\'⁄Pá√7°Á Pˆ!/PéΩ®£»(˜œPÓ∆ßQÓáµPÓTwîGt2Íƒj&ÍÑ‘\0Âπ6Â©káÚºr\ZÂI»@ùZkÖ:%hAy†Œ0lQ˛‡À®Ä\0*†Ï,*–ˆ*\\*höä\ni´EÖ@o¢Bçˆ†B?1PW•7P◊47†\"◊\\B]¿¢n$P±{w£‚v–PqT$*~’ï5x\ru;TÅJå·°íö?£í›P)¶®Ùˇˆ‹ô£Ó._CeÂE°Óg}De;@ÂÑ·P˘lTÅ T—ΩQ‘É=2T…	™LÚUYœBUΩØD’Ë:†ÊŸ¢j{$®Z“fT-üá™;-A’≈úB’\rﬁA=rA’_.B5<°\Zè®°\Z3rQœR°ö˛E¢^m˘èCq®ñM7P-!TKí’2tıvã6Í]G™ı˝Í}Ë+T€i™ÀÈ™€â˙üˇÄ<TèW\Z™◊‡#™Ô@?™Ô∆)TøÑÅ˙Ù¸#j¿t58†ã\Z^&£FÓ›DçRÖ®1\"Í≥VÍ[|#j*IÄöæVÄ˙Ówı=»ıÀ˙.j˛èÍ/ãzÎ°ÄÈ´Q¿˜1(–ª^x<ÕrD¡∂£P∞6\n°–D!M(‰Û«(‘–y˙t\n3›Ä¬ÊJQÿ°∑(ú-Öe°])(≤˛Ÿã¢\\†ò[‘QÃñ˚W-äÉDq0P¸]`ﬂJ%\rD	¢zP‚á=(≈ˆ/(≈∞5j)FµÙÓ.jÖ⁄äZar—*Îè£Ugø°’w∂¢’Àû¢◊Lî†5ˆ]GkXZ£58ËµI·hÕû{ËuIË\r@ÙÜ±J¥ˆºZ«©\r≠smZw‡/z£Ìz„¯$z≥©*zsÍ>Ùl>z«’0ÙéøÁ–;\'˜°wi%£\rÏÚ–#ÌË}[=—Êéo—ñØc–VıË√ˆ7–6€\r—67é¢Ì å–v›\rh«ßÊh\'KK¥évQÚ—«√«–«_¥£]µhh◊h˜ÒhV.˙ƒ⁄ÔË_~°Oöv£=.°=Âè–ß¬ú–ﬁMh‹O¥Øñ\'⁄óº\r}F\ZàˆﬂiÄˆØãB˚è≤—øV°ÉºÉ–¡ñœ–!{–¥≈Ë—oˇ◊ñ@ÛËÀeõ–Wn‹@_50AGÓ≤FG´üDGõ=BG—7.¢–7G+–q^/—∑∂——∑LÃ–∑àcË€õ…Ëƒ[-Ëƒô1tZÒgt∫ÂitzC:#—ùAœ@göÔFgÀiËú›Ô—y≠VË<Q(∫@#]î∏˝@’˝@Cà.=’á.}ÏåÆLwBW6ï¢+±Dtu}∫f>	˝T∫ˆÈ,∫V9èÆãxç~ëÜ~|+˝6å~ëSè~A<Än⁄´çn¢è£_˜¢_Ω{É~Õ1A∑ú›ãny]ènx¢ﬂ™ùCø]∑Ä~˚§˝Ó/˝˛X∫}›RA˜≠Ù°?F◊†?V=CZìÖXgÖÿ7è¯éLoE-I–√*YËaıMËß≥Ë—ÀÌË—˛2Ù(Ÿ=Ê@èEmCèO◊£?œÙ†øjé¢ø*3–ìFcËoN—ﬂ‰ΩË©8z*œ˝›~˝[Ç˛πc˝Ûv˙óﬂMÙÔ=õ–øó—ÛG:–í04p‚7\Z„äóÌACTº—–˜—0H\Z±ΩçxëäFº†ëz~hé∆§d°1√Õh˛(\ZkÛç?Ä@„Î8h“w[49‚ö<ä¶‹»BS’.¢ôú14sÂ3ö}êçf«∫¢πø.£˘Ü\n4?Üà	√–≤1<Zæ.-ﬂ“ãñ˚ö†ïnìËn7—ˇ¸u—ˇP@åJ.≥jêÑQõCa÷¨a4b«0Îvü¬lX>Ä—5›åŸ‘∑≥Â¡P∂`∂P´0ztÃV√~Ã÷Á)ò„∆ò$fÁ≠Øòù )f∞≥ß’≥w!c`bˆ_•bˆ+S0¨\\0F˝f„µ∂„ÌCìsÔ0&iw0ù1¶Üﬂ1¶W0Ô®ò√e€˙`åÉÒ<∆i∆È¿åÛT ∆ô∏ÇqŸiÜ9¶¡∆cwaéq/`éü\"c\\UÓc‹åo`‹Öè˛4åÁL/∆À*\n„Û„£ƒ`¸û20~J)∆øV„ﬂ°Ü	p—∆àÔbÇΩø`Ç\'V0ÁD0ÁGÙ1Áe[0!Ÿeòzø1∑Ç1°›ó1·\'va¬„0óáôò´À›ò(`Ê¶Û.Låw&û\ZÄπp	ì®˝ìÏâI~≠çIãIØ˙Ñ…ƒ`2ªÓbÓÿ€a≤>`≤Í<0˜ç]1Ÿ;∑ar å19o‹09øÏ091yArL¡∂ò{S0Ï\0ò‚mYò‚€+ò‚+LÒÃeL)ˆ!¶Ï˜Lyc(¶r7\0Sµ“â©ˆ0¬T˚7c™gÛ1M\Z1a]Œ√<\Z¬cÀò\'QL˝ÓrL√ò”?ÇiîÈbû›ﬁåy^˝Ûú`åy!.∆4k`ö≥;1Õ7Ã´˝sò◊iLÀLÊÕ™dLõ§”åƒt≠\01æea˙J}0}=6ò~Lˇ¯\"fËÌ)ÃË˜dÃ¯d\rÊÀRf‚∏Êk¥5f“v3˘∂\n3e~Û˝d&Ê«é˝ò\0Ãœîoò_õ,1øûcÊ¬ﬁaÊæ¿0s§Oò?0:Zòo]ÃBx&∞ ∞‡`\0N`—,t©Ÿ¬@\Z0êäËVkÙæÓÉ2ü¡`ï°úC%ﬂ¥	CQã¬PF±jÕ4ÜÊz√ÿnÉa˛2¬∞∫F1¬πNå®ı\'FÑ:åGò`ƒë@åÙR/F^}≥Tt\r≥LË«¸S+ƒ™‰Vb’Ø^√™˜OcWØn∆ÆûZã’p≈júÃ∆jÇÿÿuù÷ÿupkÏz´*Ï˙∏5ÿı¨N¨∂Ω\nvsE8VÔ…{Ï÷õO±€˚bw?¿ÓÓ¨∆\Z¨…¿Ó1=à›øßª)∆\ZÕ›«\Z2±&C{∞¶Œ·X”ƒF¨)∞k~«{®YÅµZ|èµnıƒ⁄Ëjcm‰∞∂ÊŸX€T÷Œ˙÷Ó>kOçu∏?Üu⁄•Üu9VÖu+˘ãu=à=ıÍ.÷wÎÌ¢çıQU¡ûÆC`O3¢±æñb¨oä:ˆLu2ˆÃkÏŸUg±gM≈ÿÄÜΩÿ r+6¯[6¯˚fÏπº^ÏπÆ.Ïπü/∞NUb/⁄ﬂ¿^åÎ∆^ÍÛ¬^BWaCÒ∞óøû√^a5`Øæ›éΩv|/6˙›CÏç\'O∞7Y∞±aÿX‹*l<Ó6ˆ?õh≤õËÕ¡&°K±©w/aS«‹±˜≤æaÔ›≈ﬁÉ8b≥û9`Ôo#aÔ˚Ω¡Êò:as —ÿºClÅÆ#ˆÅ)[Úw-∂ÏÆ∂ºìç-ÔZã≠À√VÓ[¬Vq¡V7õckåb±µ∑wbk?\'aüc⁄\'∞/èaõÌ«63µˇC˚˙‘]Ïõì⁄ÿ∑óº∞≠∂ÿ˜;pÿ√üÿéòΩÿéŸÿŒ˜Ô±ù]eÿŒ/ÿ.ClW≈Clw∂!∂õ]äÌπçÌ’πÇÌ5¡ˆÊáa˚û%b˚¨∞ü¡ÿ°óÿ°ôQÏpPv8R;rÒv‰EvÏ,\0;VŸà˝|ñä˝ÚÆ;·•Üù∏íÄùà?Éùò‚cøfÏ¿~˝ı˚ÌØ;kJ¿˛êã∞?≥¢±?üΩ¡˛:˜˚;H˚;&˚;óèù[u;Á‘É]∏6ä˝{‰2ˆÔ— Ïﬂ(,ÄA¿?^√ÇN>ƒÇo’`7écëÔ±®sá±xƒ<ñ`qK»ãƒío°∞Ù	Xˆç*,{@ÀŸSéÂÃb9¸˜XÆ≠VbPÖïXÎa%”©X…ØÔX©∆Q¨4€\0+K8Ñï~Éï€fbÂÔaï;l±JË¨íÂÑ]¸∆ƒ.]‘≈._⁄á˝á‘«©:æ¬©æW¡©uæ¿≠yVÜ[Î¬≠#X·÷Ô®∆i=Ò¡mV„tû‡6ä£q[‚Œ„∂dY„∂j5„∂^‘¿È_n«mSøá€¶¡m;˝\Z∑˝∂;n˚ó\\‹éÔq;˙·‚∆q{æ‡ˆ«m¡†Ø¬áp∆≥+8c¡9‹Aù˚8”\Z)Œ¨üá≥„ªº∆ŸyêqˆF8˚∞√8F-Œ≈+Á¬∏Å;~æw¸B2Œu\rÁÍÚÁ›çsœY¬πK„p\'|Ùq\'h#8œH=ú\'Tw™p\0Á≥y\rŒgÁ?úèy(Œ\';ÁõYÅ;ªπw∂ı\n.Ë`.hÍ!.xœM\\ô2\\p˘ÓB˝‹Eo1.Ùî.4∞ö˘	ﬁªwŸ∏wEØwıD.Úh2Óz Y‹ı/\0\\î´.j⁄	çu∆Es∫p—+Ö∏Ü.∏=Û∏õùC∏õøÔ„b∆q14.NÁ.ÆÒ.>Éªuﬂw´˜#.Ò]).iÊ#.9-óö’äKŸÄÀàÿâÀÎ‡2ÕO‡2üı‚Ói%„ÓwÂ·≤gÊq9∆Å∏úÚ\\N/óÛwó˚çÀÊ„Ú[„åU„Ä˚q%∂q•ƒU∏2O\\yHÆ¬Ù%Æ™.WëÉ´æ·Å{d^à{¢~\0˜§9W?kÇ{öº◊¿ã≈5,;·^¨!„ZúpÔíıpÔ\n\\qÔ‰„:\"pI’∏Æ‡ ‹áxs\\èﬂ]\\O¿K\\Ô°\\ÔØR\\ﬂ3\\_˚m‹«∫7∏è†∏˛\0=‹\'M‹@Ñn0∏7Tv7¸ÅÖ1:Ç›Èå[‚æ,[‡&∂∫‡æNó‚&’˚pìÆ‡&K\npﬂFŒ·¶nøƒM´ú«ÕXX‚fpwq≥á≈∏Ÿ…K∏Ôt‹˜¯=∏_{V·~øê‡Ê\n’qˆk‡ÄGq@-~#‰6éÉêçq∞î885á‘:éCn¿‡êy>8dì>9∏á∂I≈°ìÚpõ+8LE\rCY∆·Y8¬G|sG∆‚»ê8äG[w«Zª«È∫Ö„Ÿ\r‚¯“4_6É‚∑„Ñ¨8QK\ZN¸úÑìùl¿…∫6‚_·ñ7\0qÀx‹ø#ñ∏≥Fx’˘xUØñXàWOÒ¿kXç‚5‹FÒöØcÒhº∂π^«)øÒ[~„‹*¸¶ù€ÒõM≥Ò[◊i·∑ÓD‚w÷[‚wk2Òª}¬Òªâ|¸^ïcxC7*ﬁ0¥o8Ùo¯5øœ/\0øØ˜\0ﬁ(t=ﬁËëﬁ¯¥ﬁ∏.o¨l¬õ§Y‚Mûu‚∫?ƒõ∂‡ÕZ≠ÒÊ’ º˘\"ﬁö)¡û(√€xÕ‚m7ñ‡èºD„çÔ„[·è∂‚è÷∫·è~:äwYul1ﬁ›ar-ÔtÔöä˜ìàÒÂõJ|†w\n>∞v	îÉƒá|«_àﬂåø»Î≈_u‚C∑}¿_ˆ2¡G¨+«Gÿü«_\rê·Ø*4◊Ú´Òëπ9¯(Ω1|T}|M{éèâÁ„ckìÒqÊ˚I:~¯‰€OÒ©j◊Òô:[ôÉ\'w#áw—˜Jl˜Cn‚≥ó≠9\r¯Çæ∂_H8à/\"?√)≈êD|…ˆ¯≤Ê|ôHä/ùéØªÄØ\0ëU„÷¯*¡æÆ‰æÓY.˛ëY˛…˙5¯\'˜ÒO\r[Oáû„ƒ∂¯∆#áÒçŸh¸≥ºf¸Û42˛yñ˛y„|”S_|Û«|ÛÃ;¸´{/ÒoN¯wîØ¯÷óÂ¯÷A¸˚±p|{2ﬂ©ÆÉÔ¥!·?æΩÇÔøæﬂˇj?Úg	?∫ı,~t<˛≥˘W¸Ñó~rs~ √?\r?ÅüÖπ·ÿ“Òø^u‡´M„Åıôx»°cxhã5Ü¡√ur´ﬁxD‚âYƒ£_Ÿ„—‰x¸]<û{OﬁØÇg:aÒLJ6ûUÚœﬁıœû*¿≥ëˇ-œ|«Û÷‚˘i%x·¿6º%¿ã6QíïÌxyö^9øøÿ¶è_∫qøT˝øÑ7¿ØúÙ#®t˛\"®™çTmM™ü‘«5	Í‘V¬ÍH}ÇÜ˙ Ak;ü∞A∆#ËÜü\'Ë>–$lÃô$l|9Oÿ¸B–è˛H–oÖ∂1û∂ªÖv∏~#Ï2˚G0¸ÚÖ∞o¥ü`§ŸE0Ú¸M0äUåæñåµ\"	&ØÃÀ¬	¶ﬂË≥≤M3Ù ¡|Ÿôph8ú`izñ`µøé`ΩŸó`]¶F∞Ê 	á©˙€wRÇ-Hç`7◊JpàÏ#8m\0úOn!∏€E8v\ZMpΩ=CpmzEp˝™Jp+|Lp\'ƒN‹”!ú¸ÎM8ıˆ$¡Îß*·Ù;¬ÀÑ\0k!8»Öp>d5·¸≈∑ÑÛoaÑ°øZõ∫m	ì’e	Ñ–ÆBò√NB˛!|[4·rK!ÇÿA∏û{â5À$D´¢7r	7`∂Ñõ±LBån!&´òªNàz‚Œ·Òˆ˜	ÒàBBâ!°tÜê.!§l_EHÔ¨\"d∆¸\"dfÃ2DB&ßôpG¡#‹=B\'‹=ˆìp∑àE∏7ÂE»>-%‰ºo%‰o.$pÑ¢)°Ã_óPFœ#TúF®òµ\"TÆn\"T-Z™Ôij˙#˙	èéÁk#<ˆºJx¸féxnûP®\'‘≥¸ç˘Ñw∑‹	ÔÓ¸&º√…≠›ÔyZÑ6≠=ÑnèCÑ?ª	˛}$Ù@±ÑæΩÑæÎzÑOYÎ	üﬁú Ú	CïÍÑaÀ4¬óÕ¬DÙY¬W’ÎÑØÑ¬d6Å0sDNòπE¯æ—É˝Á\n·;)ëcı\"aôG¯\\$Ãª∫Ê#?˛ﬁØ&¸m<D\0‘ ¸7MÄŒè\0€RIÄŸ’eZDﬂ	Æ\'†BwPY\rÏÅÌÇ’cÒ‡ÒÎK„ZÅÈ°M`FÚ	¨\',gD‡ç∏¸˚ﬁ\nç §À¬{ÇhAdNAeÒz3ÇÙ‘OÇ¥Wã ãøGê5‰aëE∂*a1…ç∞4˛ú∞l\\BX)≈V&CˇÏüU\\`ƒU6_àjST‚jÒqÕ„¢Üâ)QR@\\{®è∏.Â0Q«ªç®Î≈%n˛–D‹b¨B‘œøA‘oÁ∑o!nØˆ\"n†àªW9w◊Ω ÓFu\r>Ã˜t˜fàÜ˚Ïâ˚M¢à˚O≠\"8dN<P“E4ZùH4Qˇ@4˘÷I4ø∑H<4G¥‹xíh¢ Z Æ≠‚ñâV5√D´üND+`Òpt1Òå\r—FÓN<rı—°ŸàËÄW#:FM]zwè◊íâÆn˙DèáDèÜãƒC‚…ÛüâûÆ`¢Á;u‚©4—+∂ÜË˝FóË=wãË„?JÙπ+#ûVøH<ÌJÙΩD\'˙>I%˙v§˝* à^GâÁ[µà&7√\"Üπ[√\'Dƒpl\"Ò2Mºjé$^ã$FjÔ\"^ˇ˙ù≠{Çùˆèx„I1ÒÊ«\"båS1ÓœbBƒÒ∂Ú\01ÈY.1üELÀﬁGL/⁄KÃ8|Ñò9”Bº≥ÀÖxØh+1ÀÄDÃ’L\'Ê¬sCàE€´àEπ°ƒbW,±xâN,—q#ñÚqƒä”zƒ™Ω_â’!◊â5âè∑kü⁄m<F|îΩB|TPN|¨^N¨üXO¨ˇuÜÿ`nGl(Ò%6æxO|ÈA|sÔ*ÒÕ+3‚€{àÔ.Ù[\'Ô€ﬂ€7W;ÌFâùw≥â›˜©ƒﬁçƒ^¡;bﬂ?-‚« ‚«Ÿb°±øÁ±éJ¸îYE®Ì\"™∑áy{â£æmƒÒ‚€ƒœº‚Òõ˜#‚Ùw\nq˙◊&‚Ã]qÊ∑.ÒÁãÌƒüà‚ÔG‚ËqÅqö¸VIÖ|\"Ç.Aˇtâ0\"ÏèÒ„$©ÆBD\Zæ#\"πﬂâò•=D¬Á)\"QúO$1ﬂ…\"O\"›È&ë9£MdØã#≤øÔ%r•QD^•ë«h\'Ú∑Î˘˛«àb=w¢‹wQq˘-QQ7ATö]\'.>{N\\Ïœ#.ÌÒ .ıù\'.o %.ˇ\"WÏfH*u9§U®$U ImMiç›{íÜaI”pú¥n]\'iù’íñì7Ika?i√Ì€$m≤=i3ÊiÓIœSï¥ı—“÷	“.›u§]£“ÓM\0“Óòí¡ÂFí¡/“[=“Å◊\'I∆∫°$SÁC$À¸í’£7§√PUíÕl9…ŒáI≤oÛ!•ú!^%9wŒì\\ﬂí\\™â§„Av$∑÷”$Okí«7…öHÚX^O:Ö\"ù4Ô$ù¨Ë&ù:ëJÚR}JÚÍ8MÚ~9D:çj\'˘¶#˘Ê’ê|ªmIAUèHwØ&]\Zà$]¢ø%ÖÌ≠!Ö’›!]Ó,#]1Ã$]!;í\"’H◊º°§»ç÷§H”K§Î˜BIQÊ|R¥◊~R4ºùtsæÜìªãÀ*$≈˘Wí‚ì∆HÒÉU§Ñu“-<)©»Öî≤¥çîO$•Ò#IÈfHáíIv≠§ÃÜ§;á9§;GíÓ˝)\"eUπì≤’ΩIπè‰§Ç=RwôT®cAzêM*Óú&ïª]!Uƒ7ì*õ7íj6GêjOø =“û!=π§O™/2&5{Ì$5_t&Ωƒvë^ù˙Ajit ΩI®%Ω€-\"µÜÈíZˇìZ1·§˜cœIÌV∆§ŒSRÁù‘;•OÍ;OÍì˙ì>2I˝U:§±oA§1YÈÛ≠§Øo˚IS≥§Ì`“Ãè§Ôbçˇ¯M˙qJ˙Mä ˝aŸëÊÔYì–˚I\0)	¯A◊ì`âK$ÿà:	û¸Ç“I»îFñæD\"xù%ÊÈ$‚˛„$¢)ÇDû˘K¢:ÿëhó_ëh1PΩVHbﬂi!q¬oë8»\0øﬂö$0%	µI¢µ1$1ñ$˝-\'…\\‡$πlâ$W∆ëîRí2∫Å¥®~Ü¥ò_JZ≤ñëVb˚HˇúIˇNzê˛ï≈íUnl\"´‘îëU”¡dµ¿≤ZY1yÕ¡)≤∆§YUN÷¸D÷~!Ø√;íµ|…⁄g˛íµ{Û…ª»[‘≠»[^\"o%êıèµë∑møEﬁV∏ïº#\'ìlH6˙M6~K6}Ä\'õm5#õÌK\"õ›AëÕi©d+{>Ÿ˙V!˘∞o%Ÿﬁ†ë|‰ô&Ÿa√≤„¸K≤ãIŸ≈ﬁí|¨¨ëÏäëê=Âdt˘$üDˆÙ\'ü\Z“$˚@¢»ß◊m\"ü6M$ünq\"˚ZÙê˝€èíœÆííœJï‰Ähr†≈rP2õ¥tÄl}Ñ¸–é¸Fì|Æ¯/9‰`,˘By˘í⁄.rÿ∆ròÅ#9Ã‘ÉÓHéìØ`.ëØ–‰´¶»W›ì…W/˘êØ9ÍíØπµíØç˛&_Ø˘@éRQê£ú0‰õfk…±´€…	gê–‰[ë’‰[Ï»∑øÖêìR·‰çBrj–irÍµ”‰ªù=‰Ïÿ6rn”5rAÑ\\´$1Ní‹≠\'óòªêKZì»•f6‰“xCrÖ˝!rïy5π\nJÆ•ìk*]…µoR»µ˝(rùi(˘…0û¸4qò¸Ùé7π!Ôπ·ç9˘AÖ¸|M~·&%7o\"7Ô`ê_)ﬁì_w∞…oøéë€û\'ë€=…ùÈ‰‡jrÔ÷`rÔrÔ˘„∑4r–0πøf7π“@º%%]\0íárœìáì»√3Â‰ë◊≈‰Ò^MÚdi\'y™b˘{ˇ^ÚœàzÚØŸ	ÚoO8˘wT.˘€üºê¬%.\n…¿¡@2(∑ä¢3…`Ì.2ÃBèåÆH\'c∂r»òøÛdÏs2NµìLàœ!OLêâ∏_dí˝W2˘ÉônI¶(-…ÙKÜdF⁄2≥Ú%ôı!ëÃ	∑%s5G…‹cÜd~±Y∞÷à,»8GÃ:ë≤€0Y(j!ãYT≤d;ñ,[h#À€\Z»JïQ≤2#úº»Üìóˆóìó˛´ôÂ›RÚäÍy%`EÖMYì-°hLÕQ÷∫”)öS)ö≤îuw∂R¥j˛P6®_°Ë¸ª@—çxO—-AS6ÌS6ùÙ§l>mAŸ¸˚eã/ô≤£‘ô≤”be◊©kî]- Æﬂ(ª`-É√√É_\0 ﬁ¯ ﬁ¢$ä·FO ˛ùî˝Ÿîö)™z)F1˝îÉg7SÃÉ)áÇ_S,Ò=+Ø´W|ä:ÇrÿjÄb£C±m¶ÿ=“§8Ñ\rP◊fRuvQúz(.á”)«¥3(n“JäõAÒà9J9a‰H91ΩÖr“/à‚’‡DÒçP°ú©˘JÒ{pó‚◊óMÒ_ØE	Ù≤£∆∫PÇ3ß(™S.ˆS.¢\"(ó K(·GR)·É]î+’2 U:ÜrÌ¨	%Ú†3%⁄#ü]Hπy0Érs–ûCs•ƒíƒîÑ—1 m˜îDÀUîÙ \'J∆C6%3‰$%SlOπ£§dÌË¶dY‹£d’ƒSÓÁ∂PÚbØRÚà@JæÖ?•»j•»Î!•hdÂ¡{ ÑÑR∂J)∑ßTl…°T¶=§Tô°TØr•‘lù§‘¯\n)5íèî∆™oîg~îg9 sa\rÂ≈Üîó´(Õ9bJÛ\"ÇÚjKyclOy{±úÚN#âÚ.Ë=Â]î!Âù4ïÚﬁªÖ“ˆÁ˙ÃS:¸˛R:ΩF(]Aïîò•wC\"•/”ä“W∞Ö“—ì“_$§|¢ﬂ¶n)•ûÚ°%iSÜÚå)√\0*e‰úeTe\reÏûÇ2ˆ-e¨mÇÚ˘DÂsz9Âs˚\r + ó\03 Ñˇj DÁ^ D∑\ZÂõ≈m 7∑4 ‘ÓÀî©Í) ÄDôm•Ã.ﬂ¢|œK°|ÔM¶,¯-R˛ﬁ•\0£(Äo\n0Î8Ùy‚ñJÅTwS ùá(0˝ﬂÿª”xx=q˜AO§ …x\n⁄ÕöÇ%S∞+O)ÿ,Ö¨yêB>6J°‹Uß–_£0˚SÿIcéG·b›)¸kø)¸ÍO·ñ0ä–_HëË§S$¶I^\'Erñ\"\'Ωß(4™)ä≤À≤ù≤ËêEYLÒ¶,\'Rñ“(KEAîïUîï] øä√îÇZÍ™ÏKTı±«‘’U%‘5ª8‘5W?P5R+©öS4Í˙∂Íz∆y™é÷U˜W9uìﬁ9ÍÊ™O‘Õ?4®[v.P∑Ï{G’+m£nı˜ßnÅ§ÓÑöPw{ïR\r6n°\Zæ\\C›7˙Ö∫o°Üjd°I59ÆE5Ò¢Z‘_£ZıëjEú°⁄í®∂≈w©v^è®vÅ⁄TP’q›9™„õ˚Tßñ›Tßy3™À±IÍqœ2™k*™Îœ1™+Â(’MœÖÍÆíCuÔ	¶û¸dD=’à£z[∞©ﬁ¥a™œıÙ>#ÍißW‘”	™Ôò5ıÃø6™ü—™ﬂG&’Á™øœkÍŸ	‘¿’Î©ÅÅﬂ©Å›⁄‘sõ‘Ûæi‘Û›G©°£\'®°tMjòÌSjÿ‡mÍµç`Í5Î«‘»ˇŒFN7SØÎ^°^˜≠•FΩ∞ßﬁ4†Sc\\J®±/∆©ÒjbÍ-Ç5ıˆ‰nj‚∫’‘ƒÑijÚ•_‘‰¡}‘îìÔ©)·%‘îñ,jÍsWjö≥.5-êIM+„Q3\n^S3◊FS3\ræRÔºõ¢ﬁèû°Ê>SÛ~PÛ˘‘jaÖZ8X@-ú+£mŒ†Â<†>–Ï¶>ΩD-=J-Y•ñı-RÀOÅ®ª©ÔNQkQhj›ã˙∏Ìıq˚fÍì˝LÍìÎ‘ß∏vÍS≤í˙îÛå⁄\0∏OmﬁvÅ⁄‹\r†æ∫7Nmâj•æ€ÿD}ü‰OmTS€Ì\Z®]ªŒS?‰ôQ˚ÙéP?˙^£~*¯@∞’¶<å¢=<A>ΩÅ:¸*Å:åÅQá%è®£Ü>‘Ò8*u‹F˝ÍùJ˝Z‹D˝¶Bù\"\ZPgÌ®≥\'©≥\\Íè{3‘üy‘üM©?óûQÁÄ´©«ç©◊á©¿‰T`Õ)*XGÖòÌß\"OÌ•¢ﬂ<†bÏ˙©ò˙*ñ›H≈uyQqÀÂT¬Lï»H§“‹T˙V*›Henõ•≤FŒPY≤œTŒ7ïﬂaJ¨M¢\nt®¢ŸTY€{™‹m\'U1yé∫xFù∫ò¯à∫ºWá∫ÚM˝òK˝◊7KSâ6†©\Z<†≠û≤°i∫M”h9L”Ñﬁ°≠ª8A[˙Ç¶ïfN”\Z#—6¥2i0/i∞û4Ì~m£∑\Zm≥¡öû⁄4mÎ≠|⁄Vë*M»ù∂ÕÍ*m[Ω	m˚K?⁄éûM¥]öñ¥]Km¥›wÚh{Ô•Ì˝QH3ƒ‰”ˆ\n§7}ß&“Ã˜\r”,∂º°R:–,Î.“,Ÿ4+óá4[ÚÕ>ÏÕÒºîv¥pÑvtAóÊ+§93çi.’≥¥c]z¥„⁄8ökÜ:Õ›qÕù¥B;QôF;yñE;˘ïJÛÙÙßy˛ZM;ıMÛﬁ˝ìÊ}:Õ€iévöhM;cwâÊg”IÛªLh¡”Çb*iAãoi¡ë¥ÛX]⁄yòvÅîJª‰óNª$Ì¢Ö∂•”¬] h%Ê¥ÎÕc¥Î‚8ZT}5Ì∆·d⁄ç81-FTMãΩ≥á€¨Oã%4—‚H¥¯LÌˆ±/¥ƒ§9ZÚŸDZJ∂-’HèñjŸ@KÀ⁄@Kj”2vÌ§e\Z&—2›Ó“2ãßhw÷i“ÓTÆ•›Cú¢›–≤ﬁ|°e!‹i˘ß/–Úœ$”ä¸®¥€6ZIv≠4eôV∆˜•ïgç–™ﬁ®—™”ùhul;⁄cÕc¥«‘[¥«Çã¥\'áöiıfZÉlñ÷¯nÄˆ,˛-ÌπQ)ÌÂˆP⁄´\r⁄´B8Ìµ·≠e$í÷\"§ΩÒ˙A{Û–éˆ6–úˆ>‹üˆ^·@Î|3MÎ*c–∫◊W–ù;hCt⁄HnmÃ>ö6éﬂJ˚íÙåˆÂ]m¢Ùm¢¨êˆu’ Ìká9Ì[L	mäæë6m€C˚—K˚yÚ\0Ì˜Òs¥?ãiÄì´i¿\ZÆF¢®4–Ÿ\Zd”\Z$‚\rˆ÷è\'–êí1\Z°wúF˛xèFıD–®ì`\Zm-â∆∞£1=Ài\\õ]4˛\"∞Lß	?–ƒÊ™4±_Mf7Iì≈˝•…\'Ñ4≈Ûw4•6Ü∂î0H[é<O[ÿ@˚óˇåÆ2Ï@_µñÆ™ãÆ\n§—’æÊ”’b˙\ZÂz∫ÜXüæˆg#}Ωo}}9ÖææÅÆïŸM◊™∏O◊ÓyK◊Iè°Î¿ñÈ∫g˚È∫ƒb˙∆ê[ÙM€^“ı‰—ı‚È[ˇ”ıü†Î/O”wÿÇÈ;ÀÁÈªƒ«ËYÙΩro∫! ëæœ\'ÇæØ‰.›§ûI?∏=ònö7K7;QK?dúH∑,ºO∑¨÷†[MË÷Qh∫u«Q∫5Õñnõıö~ƒAJw‹Ew¥,°;z¬Ëé#èÈGu\ZÈN´√ÈN4∫ÛÕa∫3˚›YaJwâ(£yùÓzq;›M?qo˝‰ütœä(∫◊A=∫◊è∫O¬∫oöò~÷∏ü~÷Â=¿Wó–êF¥zH<˚ûƒÌ•á¥:“C~ü§_∏rà~QeÑ~ÂÛ4=\"Û>=‚˘=‚k˝öt3=R∑Ç~}ı4=*ˆ=öÚî‹IèµO•«%Ë”„£µÈÒ©)ÙÑ_…ÙÑﬂuÙ€èÌÈ…ÙîÕZÙI=m8ìû.W£gú_Eœ®-°gLbÈÑZzÊ# ˝æ˘q˙˝zˆP\'=õCœŸC§Á™&”Û÷d”ÛL»ÙÇªÙ¬ÈÖeñÙBx\0Ω»y=ΩƒTì^BÅ“À7î—´íÈµè“˘§?#ñ—_®O“_hœ—_@xÙ&}czSZΩ˘–NzÛ˚ÁÙóß-Ë-Í^Ù7ZÛÙ7{åËo≤‡Ù÷zª„Iz˚G&ΩÉ¯òﬁ˘«òﬁk£˜ÉªÈ˝ÿ@˙ßïH˙¿√◊Ù—P0}t˙!}Ï¥˝ÀX}\"…Ä>eRDüô°ˇ\\_OˇôAˇ5ÔDˇ;3MˇªXLá§–°üêtÿ\':¸ :b„C: fÇé˙{åé¬≈”—ö:t¥˛k:zË:„ì@«DËÿÁ\rt,⁄ÜN,5•«-ÈDb$ùH\'«T“…ÕŒtÚ‡I:µCß.U“i{È¥_>tÜ~\'ùë~ïŒxDß3(Õt&@g•lß≥Ê>–Ÿã:ÁY\rù[I†1Ë¬˘]t1@ó≠?CóÖ∂“t¡öÆdm¢/Ü}£/≈E–ó⁄ÌÈK„^ÙÂËEÜJÕWÜÍÛfÜjã\'CÕ\n¿PKÃ`®u„Í¸b∆jc≠€#∆ZˆnÜfÚ c›E∆zµ\\Üv…jÜŒ	.C\'@…–=Æ –Ì1t\'Á›”õ5*˙Û?€N0vDE2vﬁ_Àÿª˚+cØ∞õaxÕÜaÿbJÖå}˝w¶CÓ≥≥ﬂfÅÊßÃÊ¿XÜ˘ÚQÜÂ£3õıÎ∂gå#„å#éÁG4GR60é,2≤Ü„OÜ”YoÜs©?√ôÆ√p9§∆pI> p)˚Œ8.|¡p+Ü3‹PüÓÛ\rÎnÜG7ïq¬5ÅqÇ˘î·yó ⁄Ö`xeex=˛¡±0NO g`/~¶Éˇç¡å≥¶ìå\0#Péd eYùfú{°¡8_2Õ)ud\\‹¡∏tÓ#TNc\\s~Œ∏ÊNfD∫3\"ìÂåHe7„zQ3# £äc„ƒàm§0‚\ZÉÒï⁄å§5å‰{ø…•´)É9åTìãåÙ∞3åÃ5ÛåªNw}«wÖ˚˜9]åúê{åºÅ›å¸≠Èå|ŸF—º\n„„£xÔ\0£xÙ£‰√FŸæ˚å2⁄£¸â\'£b≈®∏øöQqgT¨‘3™=Ø3jg‘å%2ju‚µå◊åGTèuàå\'ª>3ûjE1\Z‚[MZWMM0FÛÜ@Fsù£π{é—od4cìÕÇå∑ôëå∑Ñn∆ª]?Ôrì≠¡å˜óëå∂8{F[É£=Ë£˝ñ%£#∏ù—¡¸√¯p*à—˚\0≈ËÖï1˙5é1Æ2ö\0å∞cÄ¥ç1yí1tù¬vÿ¿Œπ¿~æñ1Ú≥ö1™_»}ˆî1∂„%c\\K ß80>ªj3>óM1æ‡ó_¢_Ûôå…ñF∆Ãq∆8ú1∑≥ñÒg¬X˙Œ\0ú∫À\0ûÃeÄ∂g2¿H‰˚%pïw˛ @n¸¬@=00ª∂20‹ç,`ã\'1p´ç¯[◊¥É|ûAñ∑0(7t4m!Év„ÉV√†ÕN0Ë’*Ü‹ï¡˛FbpLZ@É;ôœ‡|a∂Ωc“\rR∑1ÜÙÜ!˝PœPÓf,F82õf+œ≤+îgå/ŸLïOGô´n1U/«0UÁé0UïfLı¬√LuX sıŒ~¶∆#0s≠x\'S”Dãπ¡eà©dnn<Œ‹≤~Åπ≈Ÿå©?púπÉóÀ‹≠øâπg‡sÔû¶°ˆ+Ê~≠\ZÊ˛=ˇò∆¡ML„¬AÊAX”tµ”ÙûiÆ\rgöÁ“ôáÓ3µG3·N2-”ﬁ1≠sL€w¶mÎ¶-IèiwÎ”>~=”>wíi_ıÖydÏÛhùàÈ·1ùœk0ùKø1è,3èª72]ı73›ûÔc∫[µ2O(Tôûù*LÔô¶œùGÃ”!◊ògTÁòg0ULø){ÊY=3ÊYŸf@æ>3∞¶ÅyÆ∆ºòeÜû?ÕﬂKdÜ[êò·Gü1√i@f¯‚Ûr⁄?ÊÂ˚ôW-ıôWã.1Øb1Ø˜`Fâ\"ô—õæ1£c[ò—ôuÃõ€ò7kò±i\nf¸·fºÔ3Açƒº˙Ñô<:¬LÔûafûÛcﬁ1˙¿ÃæS¿Ãny¡ÃÜôŸä?Ã\\q83ÔX&3è∫ëô\'πƒ,RÛb9w2î<f>ê$1K<©ÃR…5fÂ°mÃJÈCfïá:≥Í}≥Z”âYS–≈¨)^b÷˙o`÷~1ÎÇø1?∫Œ|rÓ≥˛Ï∆wëŸ–0»lº/g>ãz…|ˆw≥)è¬|Ωe;≥≈Õl°$0ﬂ<ö`æ=Bg∂~Kbæ_À`æ<…Ïî}f~8∏õ˘·Ï≥ÁT\r≥ß´ÄŸ{πîŸØyí9∏*õ9|éÕ;«úx±ä˘µ<ô9›wä9çâb˛¯1«¸˘t+Û◊EkÊÔ˙|Êºc\"s>}ö9ˇgÄπ‡)g£¨ò Û(&µÉ	ﬁÈŒÑŸ1·–wL8Ô#!ë0që<&˛¯;&æ óIà»$Ã{2âè\'òDäíIIÂ3©Êô¥ d&\r c“`∆L∫8ì˛Ã˚?2òåøÕLNeìC˘√‰ÓògrÌ\'òí∞0¶§¨í)›Úö)[e¬î’` Z2ïª‚ô !sEÿ≈¸óªÜ•¶¬R˜π≈ZΩ=õ•—˝Ç•¡Á±÷y∞¥™÷≤¥/6∞¥˚ºY:ŸV,›ÎX∫t3÷∆,o÷&c$kS™kSÕå–Y€OmfÌ›∆⁄Î≠Õ:`qÜe2øçu0πçeﬂ¬≤∏}ÅuH}àuH+öe£√`ŸÿY∂ùj,[Ü!ÀŒ≈ìejÎH˙kñ£çÇÂ‰«rz¿r\"ÄYŒYS,g\ZìÂR7Œr!N≤éóÿ≥éyœrÌ?√rÎ∂gπÍYûæì¨S1À¨S#,ØÑñ∑ùÂ}·\0ÎÃµß,øì&¨≥ÌV@ +‡˝÷9D\ZÎº€UVHê\'+$;êR7»∫ê4Õ∫4Ì∆\n_©e]˛9«ä®®eEÄ6≤Æÿƒä¨n`E‚W≥ÆÔ±nÆ5b›‹ôÃ∫Èıúõ˙õÁ\\¬ä£?`≈øyÕä_4b›∆^e%f¸`%5¡X…~’¨î‰qVJ„YV*(ûïˆ8úï~¢éïi„  ,Œbe	ò¨˚ü≥YŸsY9m¡¨ºµë¨ºT+ˇ§´–≤âU8_∆zË;´tœ=V˘ÒlVeƒwVÂ[{V•∞ÅU5∞üUıÛ2´ä`’:*Xµøo≥Í\ZÆ≥Í\0Xè˛≥˘…92Î©≈O÷”íU¨Ç´qíıÏÇ´)Û´˘Ä	´π~ÄıÍÅ1Î’w\r÷kWÎıÖ´¨7©I¨∑OãXoï_XÌÃW¨é∏S¨é∫dV«\"ú’’´¬Í©˘ÀÍ•>fı—cıU(Y} ù¨¡kì¨°+;X£´¢Y£ï¨qª^÷ÁÆ¨/-¨oı◊Xﬂà6¨©7X”éªX”§ã¨ôã¨ô8]÷èîW¨üÅX÷Øãe¨ﬂUP÷\\Hkn&ùıß¡˙ÛßÖ5Ô\reÕG|d-Ù‹g-LZ∞\0û;YÄ÷,‡\0Ü™~ÀﬂdÅiŸ,hœ~íÖXY`°º±Pæ7XÉY∂3èE®ó∞àµˇ¡`•û,r√\r%À¢n!≥ò\"m+vãïÓÀ‚™M∞∏^áX‹{WX\\¿qã\ZKP˝Ñ%⁄˝Ü%r-gâŒ.≤d\nMñ\\k\'Kæ≤ó•4«≤7∫±3∞ñ,‹YK¯÷râ/[Ât{U‡∂:^…VÁ˝aØÜ≥◊Ñ≥◊‰qŸ\ZZclç∆R∂∆≥`ˆZÎˆ⁄â9∂ÊW2{ùÛm∂ñ‘á≠˝©Ä≠Ét`Î&M≤7Êleoˆœgo˝òœ÷œöcoﬂ¥ñΩù∏¬ﬁ˝¶åm`§Õ6(>»6Ëñ≤˜¯&≤˜ñ:≤˜ˆ¥∞˜¢„ÿÜﬁ’l√,&˚@ˇ2€ƒT¬6)+båTaõ˛D≤Õæøfõ˚‹eÚ∫Œ∂º/e[E[≥≠bû∞≠èÓ`€òu±m§çlªp=∂]\"Émd€ﬂHdMub;>e;ÖRŸN&l\'†9€Ÿ∂ç}‹∏í}Beü„≥OLeüƒÑ∞=ô«ÿß»≈lØ‰*∂wÓ;∂ØÃ>Û/ûjö∏˘*˚\\√_ˆy’Lˆ˘Òzˆ˘•{Ïê„EÏ◊!Ï„ÏKÄv(„;Ïe;|˚˚ä≥:˚JÄ?˚ Ã$;\"¬úQ«æzxÖ}mˆ˚⁄ø3ÏH´’ÏhÖ/˚¶ú…éIÃc«|mf«Î´≥KŸ∑äÿâ¿øÏª^vÍõ≠ÏåÌ0vÊ⁄v&¨é}Gró}gyÑùe≤áù}qûùÕKbÁæaÁwO≤Ûø\"Ÿ˘à@vjªxª√Iv—¨˚ÅO1˚¡œWÏó3ÏÚ+üŸÂ≠YÏ\nO/vÂ	svı⁄zvÕt-˚°ú˝pœ~8\nc?úa?ròe?Úhd?›a?â7b?ﬁ∆~™˝Ç˝tœ;v„-5ˆ≥Û^ÏgIŸœƒÏ¶µfÏ¶ÙˆK„HˆÀÛ’ÏWv;ÿØg^±[≤?≤[ÚÿoÆ*ÿoÕﬂ±[#ŸmH}vG.Ü›]–ÃÓÆ¯«˛‡ù¿ÓıŸœ˛ËùÕÓ7re˜3ÈÏO6;ÿ‡.ˆ!\'ˆ¯ß!ˆó“\\ˆ‰÷{Ï…˙Qˆt¡)ˆÃMˆlZ7{∂%Ç˝kÍ,{Œrú=ó}ë˝˜°+˚oèà\rx¬û¸Àˆ€∞¡?N∞°;∆ÿPø6‹¡FlÉ±ßùÿHJ>Ö›≈FﬂπÕ∆¿\nÿx≠q6—CìM6‘d”rÿÙÿ\rlˆ%õ˘ÉÕ^~ÕÊ‡SŸ‹Ñ&6ø¢î-∞hcÔ≤%ûˇÿ\nïüle˙4{iæàΩ$ÿÀ^9µâΩ2yã£≤˝G}„gı¶˝ú’£˚8\Z∆÷çkè8k’á8Îúq÷ΩtÂ¨èdp¥»8∫ﬁ\"éÓÛ\nŒÊ6éﬁ™éûÏ*g+(î£ı%gõ◊gªm.g–Ü≥ì~ì≥W±ìcTΩÖcÙ{«¯Áé…*%Á†\Zãs0;èspv«‹màc˛√ïca;»±º÷œ±|~úcÌ¸êcÌ>Œ9,{»±ŸP ±1õÁÿ®slWö8v«≤8viá<é£Ò_éc]/«xåsÙ´«˘Ü&«•¬ôs|\"Çs¸∑-«’$ä„ñö∆qˇŸ«ÒB=ÁxØ—Áxﬂq|,9æ>ﬂ8æÈŒú3Á∫8g 9~&fø–éølÁlˆ9NÄﬁvN–	}NpÕnŒ9öÁÛÁ¸\'‰fÁ“!(\'IÁ\\æ‡≈π\\ÿÕπ¸ ësE3èÚÂ\\’„\\MZ√âÚl·‹ósnf97=Åúõ/rné˝ÂƒÄ™9Ò√≠úÑÔùúƒäÕúd◊=úîﬁ;ú‘5DN™Ò\'’l\'ıd\'˝ÎmNÊΩ,Œ›±Œ=ødŒ}|\'˚¸]Nˆ`\'Gtàì_≈)_√)àç‚Úb8E¬Ωú^}úEvúÜß¸ºß<É»©xyöÛ&üÛ0>åSÎ{ôSΩùSgV«©NÁ<Z.‡<Y-·‘kû‚4XúÂ4ÆÉqûëüq^qö¥ã9M\rúó6IúWï78Ø\rú8-ˆ\'9mW\"9mmúvÎ`Nª‘ì”È¢∆˘_‹z∂}„ÙX¡9=/É9Ωó…ú~øÁúO˜Xú◊èú°ùñú·ËJŒpWgtl+gl#í3∂{à3>;ƒôò!p&xŒ7]\ZÁõ,û3„¬ô÷~ŒônÈ‡L9ƒôÒL‚ÃêÑúŸ∂`ŒwË?Œè8ŒOø≠ú_≈¶úﬂÔ˘ú9ãüúﬂŒﬂuO9‡ÌG8‡wØ9ê≠ó8ê∂ ÑÈ¡A¿§]8-„`^rpÍ∫‹y√ou„ê\ZbÉ9ál[À°Ù94}mpáy·+á9zÜ√\Zà‰pÀ8º!é@˚!GPë∆`ú9¬öé8ËG≤Wù#˛»ë r92∂Ç£ÿ¥ä£‘˚¿˘wÈ\ZÁFƒ]eB„™Vr’˛ˇ‹\rs◊≠Ωœ]∑oäªÆ”á´•™∆’⁄∫É´urÖª¡cú´sgíª	£…’s˛¿›Zd√’◊°pıÕí∏€ö∏»JÓﬁ#6‹Ω„À\\C\rÆ!ûÃ5\\ŒÂ\Z˝”·\Z∑sM÷åsMX@Æ© AÆ©ô3◊¥Ó(◊tæÇk¶j∆5SFrQ≥πViÎπVmá∏V|◊Æœu0∫¬u»∫œuûùÁ∫Üıp]ˇòq›ä˛q›#πÓ–Ó…K&\\ÎÆoáÎÔ˙ãÎZõÎ÷ã`Pœ\rB€qÉkÅ‹syó∏ÁP‹ìXÓßdÓ•#•‹–öC‹–FKn(6é’ÊÜ«‚ÜÉË‹+gœpØ4pØMπE‹´)xn§¡7n‘´á‹hÕı‹ËÍ+‹Óπ7ﬂ\'rcßî‹XÙ,7·‡6Ó-.ó{ÔœM<+‰& }∏…+◊πi„<n∫é7˝¬9n:«ìõŒ5‡fl5‡ﬁ≈\\‰ﬁ«r≥[ZπŸ3µ‹ÀnŒ‰inÆJ7ﬂêõ_ÈŒ-:VÃ-öÅrH0‹b±∑ƒ/î[~Ú<∑¸\\>∑≤I¡≠…‚>:Ó«}¸Ö˚d#ö˚Ù1Ö˚TÚô€P„ƒmX™Á6Ê‰6Rm∏œ˝)‹ÁM¡‹¶C-‹WÇ+‹wï‹VV4˜=mô€˛å€˛¯,∑ÀÀö€ïÔ…Ì·%q$RÓ`.è;2öÀ€¸ô˚Y]á˚˘ü!˜ã∂Ñ;Q¥ñ;Å∆˝z≈Ü;	Î‰~sÌ‚ŒòjqgMqg	‹Ÿ•É‹Ôõßπ?\"∏?\"M∏?w·˛˜Â˛ZΩñ˚K≤»˝≥ŒÅ;_tì;œSpNè¸˜ù⁄¿ñsÅ]>\\ Ú„»U„ÇëH.ƒ~íﬂwáß©p·K_∏„$.¢—õãTTr1‡F.>:éKt˚Œ%¿πd˛.„∆.ãº»eqÉ∏Ï~.ßwóßïÃÂ\rjs˘ì∆\\ÒŒ%Æ‰õW\"sÊJ7Kπ≤Á÷\\˘ö^Æ‚rW¡„ÆP•‹ZOeÈ3oÂOı“Uû⁄¥	oı¡rﬁÍƒKº5ÅÓ<çí≥<\r‘=ﬁZ≤!oΩj?O+Â.Oã›»”ˆÂÛt„“x∫bosJ:OˇIoÊo˚üLﬁvÉ∑É√€ÈÑgê™…€Û÷ó∑ ‡Ì]; 3‹æçg(ŸÕ€w\'é∑?È\rœ®Mçg≤Ö…3i]√;ò)‚¨⁄ƒ;¯(çw∞Ì+œ¯ègˆ.Çgæ\'àg°o≈≥¯`œ≥¸cƒ≥ÇeÛ¨î<Îıã<õõóy∂´~ÏnzÒÏÔÚéºäÂ9»Ê9&iÚé¶éñMÚéVËÛé‚ÕyNh œi)óÁº∆sâr‡ˇ2ÀÛ`mÊyàÛx\'Ã˝y\'75Ò<ÎéÚº*üÚ|_©Û|øºÁ˘πõÚ¸Æü‚ùm%9Ú.®.Y#y°óÀyaøûÛ¬òmº+èÇyWiøx◊√˙y◊”Kx1€?ÛbdΩºÿŒ5ºXëw‚/¡·\nÔñU:Ôˆ•ﬁÌ´˚x∑˚¡º€+fºƒ÷^Ú^0/u/\r<ÕÀ†yÒ2≥Íxw^ÛÓyû‰›√·xYœxYÉªy9IqººÕ∫ºº¸r^b/Øpı^—ÌáºbÀ\Z^©È;^©ÀØØÕ+€ù∆+ìÁïc\nxç^≈ª*^•æ+Ø“ÜÀ´÷˘»´&åÓo‡’˛”Ê’I˛Úı:ÒÍΩÓÛû≤Êy\r\'Ïx\rm;y\rﬁã#RﬁﬂKº&ıﬁÎÏ#ºÈiﬁ¢ÔÌ∑Q^õ°Øøç◊tñ◊1$„u^*·}ÿgŒ˚p.è˜°¥í◊É$Û>è>1MyÎ\"x>_x%∫ºAgﬁ‡µFﬁ`å&ox≤ò7S≈Åü‰çA·ºÒÒ{º/áÆÚ&ˆPxﬂBÕy”’wy”“`ﬁÃ\'9o∂ÁÔ˚mﬁ/ÌÔºﬂ€¯º9|1ÔOÃ\rﬁBƒo·Ñ˜W+Ç˜w1õPA\0±yÄPÑÁÁA<P¯V¯f\0∫ÀôEñ‡zHzÁ~zb+èz°îG´Ê1Œl„1™Òÿ∑ yú=v<NŒ/cÕ„Ó˛…„.±y¸Õë<~HO∞ˇO–Z å$DÃ\r<±AO™ Shãy\n1íß¸πá∑xÔoÒeoQ,·≠îyÒUvYÛU>ì¯*b_˛™∫w|U-_ùÖ„Ø—_‰Ø9Ü„kÃ5Õ™˘öáT˘Î6.Û◊áÚµlNÒ78MÚµ√ä˘⁄F¸çªÇ¯ù ¯[7‰oΩB‡Ôtﬂ√ﬂeŒ„Ô˙4Ãﬂ]¢√ﬂÉ–ÁÔ˝wåo∏qÑø_^À?†jÃ?≈ã\0î`ëƒ7‚˘∆M|ì¨\'|Sˇè|Û˝Ø˘*m|Àﬂ•|´<ﬂÍÉ5ﬂ˙¸2ﬂÊ‘væÕ„ü¸£ílæÛï´|g“ﬂ%ràÔﬁ≈wKQ·ª«f=éZ=Úç¯\'÷ŸÚO2nÚOJûÚOÂ⁄ÚΩç≥¯ﬁâR˛È≤◊¸≥⁄„¸Ä\Z#~\0–èÿ1ƒ æ»?∑Î1ˇ¸Á˛˘ô+¸ãø∫˘óèÒ/m˚≈ø¥Oüz†â*π…6‚_NÔÂ_˛Ñ·GlûÂG‘nÂ_€˚Å˘†Å˝˙\0ˇzÚ~Lc-?v∑Ä€ºó;\"·«¢ÆÛ„Q¸ÑüÕ¸ƒ¸1~bu5?ÈÆÇü§ÙÂÁøÁÁ√;˘˘K\"~·˛?¸¢m˚˘EY;¯÷tÒîü‚ãp¸íMÀ¸+<ø‚Ó9~Õ*\Zø÷q#ˇQtˇIjˇ)F¡oà‘Ê7NJ˘œ“∑Ûõ,¢˘Õ[L˘/ø›‚ø“ZÊøæ˛ìˇ\Zï≈c◊ƒÎ›œdÄˇûΩÃo_‚wÏ“‰wÿz˛ÖﬂÒçÀÔL´·w˚ÿÚ{’ó˘Ω∂h~ˇ¶&˛»≥ ˛h«c˛ÿ<ò?Ÿ›¡üäÕ„O˝}¡üNø…ü~R≈üMøÔ⁄Õˇ	Ø‚ˇ *ÂˇNÁÇ√¯Åp˛Ç“ã†r˘ ù£|–ì>¯Ò5>tM	Z√„CQÔ¯pB\r˙≈«¯øÁcû_Êc≠¯X˚ß|lèèˇ]œ\'Ï1·EI±◊¯î¶ﬂ|ö<ãœ†ôO∏|Ê´e>Î≥=ü5˘Äœ’ç„ÛC_Ú•´|Â_#Å †@Â≈eÅj®L†V–.Xsy∑`ÕìÀçÃ¡⁄-kwi÷˙>¨].h÷\nö®UÇu;=Î>k\n÷[\n∫\\ïÇÕÆo[ÓÌlÕ~/ÿJˇ#–ª!–g•∂Ÿ¶\n∂◊}ÏÃ)Ïj\"	võΩÏ.«	vwièˆÆWÏ›\nö&\nsÍÃ>åèˇòÏz∆	LOÑLˇª¶¶åZÅô€.ÅyA∫¿\\ë$∞xÛK`π˝µ¿≤ˆΩ¿™Ö)∞^ø,∞ﬁ(∞∂ùÿXl9˛Y‡–vZ‡®uN‡òj\'pƒÿénu∏Æó\\m—7˚∑ÅÅ{¬ÅáG‡8#êËN]x-8’˘Z‡≈¢ºa˝Åœõ7Ç”\r˛¡kA¿K]A`]ª‡‹±(¡πò‡¸zœo)ú_\\Ñ®Â\nBØB``Añ#∏ÿ(’ø%ˇw@pπ¥KpU«YpıÄ°‡ztÇ zµÉ‡∆—ALæø Fí)àΩ‹~†§˜	RçÆR_CiN:Ç¥`;A∫cÄ ˝Q≤ „¯≤ Sá&∏S—*∏{Úî‡nAÑ‡˛—<Aûaì†@#BP~{Ø†2„®†∆∑JPÛU*®˘â<úè<∂©‘/H\rvYÇÜ˜P¡3Uê‡ôıà‡˘1sAÛv¡+ΩZ¡´}ÒÇWvFÇ◊¡	ÇñmïÇñåjAÎÅ%A´G¨†≠$hoLt¨)t>ß	∫cmnh>>\nzéçzä}=µFÇû—:Aè(D–«z(LhUØ˚]_Ω*UŸ%≥Ü\n∆Œ	∆.¥æÑ1_≤ÇØ•`rË•`Rj\"¯¶ﬁ(òŸ.¯±!K„,HK›I0ﬂwF\0å\n¿iW‡;&(+ÄÁ`O∫pÛa‹yI\0è˙+@:Îê¡îUÄí¥;Ñ+\'Ñ\ZôÄd¥C@^”-† &‘∑Î4C™ÄfW\'`¶óX˜ˆ	ÿ!>v€UØ¥X )},êf»t,≤Ô›%®F∞§G,9,kÙ	VcÑjÁœ’™V’û∆\n’∫»Bç3kÖö·óÑöQ¬\r^p°ˆØ≥Bù}¬ç.\'ÖzóúÑ˙zÖ˙ß˝Ñ;;ÑªæÖŒ}¬=ÊıB#¯o°ëLCh≤ŒQh\"ÿ\"4\r+öÍÕìMÑ_3ÖVû	B57°\r∞[hÎQ&¥_œ:n˘&<äs∫¿lÑ«Ì∫iΩ∫9‘	›XæBè˝d°á√q°L$<q{Vx¢ <•f.<•úzâÖ>zzBÓ3·È8ûtÊf·Èö9·ô∏|aP’à‹˚aHAÖb6Oxq.Yx…Êû0Ãµ^nê&º<Á*åå^w^Gˆ£‹\'ÖQ\07avLxC˜å∆KgaÃætaÃ©ﬂ¬X◊,aÏÖ}¬§Ô˙¬‰∂´¬dnô0ôü#LøR.LÔ{+ÃxÏ,Ã¸b\"º{ªJxO7_xﬂK(ÃÜúÊîÌÊéØÊØ¨DE	ãl$¬¢w>¬‚hkaÈI∂∞4ﬂBXÕΩ/¨ù÷¢ÕÖµÇ[¬∫\rÑu:@a~DX\'π*|úﬁ)|∫®6ÜcÖœ´∂_ØæF\nõ UÖMãÌ¬óì¬Wy¬Vc®}f°∞ÕÈ∫∞mzè∞}[π∞=xì∞√6\\ÿÒâ\"Ï¸°)Ïı—ˆŒW?Ìùtl†ÏÑ#*X·√R8¬ÅGG˚Ñ£ÃC¬Ò·¯;·TÙ∞pöŸ*úqª(¸ûÒÕÑ?÷˛–i˛>N˛æk)ú£Â\nˇ∏ø˛π ˛›ù!ú8&>&üZÇ£ˇ	¡ÖÖ(AüÕ‹$ƒl&1	6ˇ—#ƒ:)ÑÿkßÑD¸y!©ÍÄê|÷Z»h|\"dmÈÚÖ¸‹.!ˇÈQ°`’k°∞ÃW(¸äŒ\'\n≈NìBÈ]°îÈ)îΩ  ~ˇ ø«\n+KBÂõp·‚æg¬≈\0·\"≥N∏tjT∏ÑáW®,ëÍûeëÍuë™rE¥∫}Y¥ˆFîh-‚ñh-eQ¥>-“Úi[ÍätdS¢Mﬁl—ñ#û¢-+q¢Ìáâˆæ{ 2πºUt0øGd÷∂Ud±ÂÅ»‚ZthS®»⁄Û≥Ëï8—·W—·\'èDá9Å\"{¬-—ÙNëÉ◊êË®-Ltî¢)rz*rûQàéπ∆ä\\w˘ä\\›DÆÕ9\"W∆eë[∞°»]ı´»C£Etj∑»ÎÚ?ë˜Gë7∆V‰M„ãNùû(ùôK˘Ô∏(:õ#:;ƒ‘<ãˆãÇÂ?DÁn˘äŒÔ∞Ö¨)]H@ã.ä.˝Á«%ÑPZÎ/∫‹ªFÒqTAﬂ$äêNãÆéº];T#∫vU!ä4‹-ä2|!äÓEgÈà¢q«D76ÜànÑçãn∞Eqté(ÒGä(q!J≤z)JvÃ•º√ä2Ò2—=\\ûË˛®(;fTî˚hç(∑ˇö(ø,*tM¬D≈ãD•˙Ò¢RÎã¢RÁ¢“∂¢“üæ¢≤h5QŸÔ¢r=≤®Ú◊ú®ä=)™˙∑OT}>_T√‘=L? ™M.’À=YZ’©=uÉäû◊hã^ly#zQäµ<ÛΩ’+Ω+9+zá}\"j=^\"jm>&zèmµÕöä⁄3ªE^À¢.Û\r¢.∑¢n@ô®GØ]‘Áñ-Í?Ï!ÍwÑä>==\'˙D9/\Z<…\rm<-\Z._\rè∂à∆™tE_åâ¢…£<—d|èËõ±πËã öv‰à¶=D≥◊A¢Ïﬂ¢ﬂ¯è¢π`®hna\\4«;-˙Û,GÙ◊◊FåoìLE¿πß\"pPú~A.Ç\'àê\rX:Ñ%¬÷a¢uDòﬁæ±^D\\Ÿ\'\"}ˇ&\"?Í—õõDLKÑàu»Iƒ∂9!‚Æ…Ò6{àx‚nˇLãH¿»	8a\"…ütë¥i@$-RL◊äî¶ö‚Uôô‚UıS‚Umü≈´~ÔØ¢9äU5Õƒ™ùqb’\0±˙3\'ÒÍÑ˜‚5;ı≈\Z‘zÒZõ±ñFµxC˘w±n|ßxcÎQÒÊ√m‚≠;ƒ[ßÕ≈˙•∑ƒ;‚ƒªÏƒªmOà\ræÔ_{Vléõõ+Ü≈éÖbã¥CbÀSqb´†≠b´ÚÁb˘z±≠„g±-ØBlœ)Ô;’ü;Ø€+vÅ˘ãOÜ<ü,π#ˆS≈˛]ö‚Ä–4q†gÉ8∏»J\\Ê.ñ≠àœigàCDc‚Øà/?_J9!˚±C|πÏÄ¯Ú[ÒµŸyÒı˘Aq‘_ê¯Ü˜¢¯Ê2A∑J&é∑⁄\'éüÇãoèéãoãu≈Is∂‚$CúÏÌ$NNM\'?8,N˛ªZú¢_ú\"-ß%âSó“≈i®∑‚;Ò6‚ªeBq∂^á8/tXú˜›C\\xIM¸ \"I\\åkó§òâKhqŸáNq#Æ88$ÆË; Æ¯tY\\9e+Ær≈ãk>l◊Ωx-~\\æ^\\ˇΩU\\O~+~ä:)~∫$7‘îàHΩ‚^µ∏—gø∏Òl©¯≈¡fÒã„‚¶ÖO‚fˇqsLô¯ÂqWÒ+ìø‚◊Y8qÀ∂_‚ñ+´≈oüü∑jú∑Ω≤∑ëüä;JÔä;˚ƒ›~ì‚}UqèŸMqØÁê∏ø˝ßxp6Y<Ï.WÔè[¯à«\'›ƒ_4ã\'Çk≈_◊Oˆ\\OŒ\\Oøãg˜Gäø≥£ƒøÜ<ƒøWŒäÁm≈Û+Ò¬æ1–®FúâC‚ªƒ–Ì∑ƒHRÆ]ºJåπ~Vå˜ä„\Z≈D»!1y{πò‹≥YÃÚÖâYw%bVIÃ>!fóÕãE±Ë)ñ;¿≈ã›|Ò‚¸IÒ{RºúU+^¶JT~LIVGI46ƒK4\rÕJÅd˝p∑D€˜ÉD˜„ºdSÄádÛQ7…ñÔA=A∞Dˇc∂d˚¶kí]ˆ·-CâA⁄>…ﬁÇ\nâ·πí}Yc#Vbz@ ±ËY+±LNóX-\\ñ.CJl\Z]$6øL$∂◊èHlìÓKlÀ.Ié¿7IÈ”í£ıõ%Œ|¥ƒeqµƒuùªƒ›iΩƒ˝ÏSâá s…I[Kâgkºƒ+kãƒÁò£‰¨]ó$¿◊@8ñ’ﬂë}*	û2ï≥ÿíib…ÚC…≈L†‰\"k≠$Ù\nQr-∑YÈøQrf+â∫2-â™ﬂ$π—‡&πY±Y˚-â¨ï‹*aInµñHnÁhHíŒ~ó§√$È£´%ôMÛí;ˆí;—Ø$˜˛ÖHrn.Jr\'$yF˛í¸Ï.I¡QSI·ŸI·ÛIakû§∏P.)nóî»wHJá„%oK*=èI*r$U}aíÍ’éíÍ8Iç´DÚDì‘f‹ì‘•a$uπ⁄í∫ñIÁª‰—Ï≤‰…:Ñ‰âûæ§È8V“Ã›#yπÊî§•<T““‡ i]AI⁄ÈíNπä§{¯ì§G‘)È-NìÙÉs%üÓ$H∆Va%cì%íÒ¢d≥K2±Ì≥d2¡E2µçd∫Ú≥‰{¿≤dn9T∑êÄwoí@ﬁYJ‡=8¬JÇjBH0\'%¸û*	—5VB:∞EB\Z_êêÊ≥%îc÷J‡òÑrÎéÑ:£!°íûHHX◊ØJ∏óøJDÂ?$bıiâ‰›®D2a+ë7çJ¥$ã∑pí≈∫Cí•]÷í•Cw%ˇ¿Ó“UÆM“UÂ©™U¶T5⁄@™f\'UÉ}ñj@˜H◊J◊.ËHµYKµô^“Õ∑~I∑î©I∑`Ã•€¶	RNßtOvº‘∞\"Uz¿ú/5„•&wñ§&ƒÀR”ßR©ŸÜüRã·È·’æ“√Àw•∂X©Ω≠Bz:/u¸Ó&u\"òJù∆Kè˝–ë∫∫K›ŸW•\'î§^“©œ∏ΩÙ¥Û/©ﬂG©Ë#ÈŸu•ö˛“¿UÖ“†—ç“sQ!“Û}ß•!øI/UK√É˛H#äì§W}§W•ı“kº∑“»uˇ¡píF_9*ΩÈ®îﬁL—í∆âf•Ò7B§	M“ÑnÈ-/È≠&uÈm˝`Èmø.ÈÌ¶É“$ù∑“îò\\i ãjijbá4mRWöÎ%Mœ€-ÕºÛNz«ßWz7âÙûIò4ã≤Yz«Vi^}ä4Ø{õ¥Ëñï¥xs≠¥ÿÔê¥ò∏_Z⁄∞NZﬁáëV¨H+wOK+[J´,”•UÒ)“™7÷“ÍÛZ“öûœ“áô\r“:ÌFiùO±¥Æ©Y˙∏xùÙ11G˙ƒ%}¬JÎu+•ı˜üHÎ\'ØHå˛IÓÙK_¨aKõW©Hõ?ˇëæÍrëæˆ^ë∂ú,ë∂§dH[xÈ˛GÈ€$KiÎ≠k“V¸:iG‡gi«≠`i\'ÆW⁄Âp_⁄}€R˙·M®¥7•@˙ÒêB˙±¢]˙È?ùGoHjZ§É„“°G:“°A∂t‰p∂tD0-ı©í~ãˇ.˝V,˝ˆ,C˙çì˛∏tP˙k£ªÙó€ºÙWö£Ù˜]∫`=%]¿Hˇˆ•J1R»µ◊R`I\n@H·P)‚Eº—˛Eä¨í¢jt•XÛ)6eçwÄ,≈_∂î‚◊I	•\")ÒÊ;)˘3XJM;\"•VûîRß:§åßo•!_ Í\0HŸ‡RæF Õ”íÚ˚Ï§\"˚oRâ	]*≠Ke7\r• Ñ5“•G§KPÈäˆô™˛)ôZÛålıCŸö\r≠≤u´eÎ\"ÇdÎ’À÷√¶eÎÖﬁ2≠Ú/≤\rÎ˚d⁄˘Í2Ìó˜e⁄„v2›Âª2Ω@≤lÎı£≤≠¿;2}ìqô>r≥Ã‡„oôT!3Lòì&_ëN6 ˆ1Êe˚oƒ…ˆ+ 2£u≠2#ÇÃÿ<Vvn¥Ã¥å+3;–!3ﬂ3\'≥H0ñY§æí⁄z]vh∑≥ÃJ„ÑÏ0AOf_€/≥_Àé\'e2«W)2Á[Q2Áﬁè2W–nôõ˜ô[9WÊ˝-ÛòïùT7îù‹/ïyÆ ;≈Øë˘∏˙ |ZOÀ|§•≤3œŒ»¸52ˇ…≤@ßbY|†Ï\\X©Ï¸ûó≤ÛÕèdóSºeó≥h≤+ÁQ≤+HGYk∑Ï*ÌºÏ™\"Rvmﬂ^Ÿµíü≤»„∑eë±ı≤»¶<Y‰àÅ,:ˆ∑,:˘•,ò(ã%¨ï›ö|,ª\r~&KlÀí‘£d)√eÒ≤ò∫ÏŒÕ≤;√,Ÿ›\r∫≤,›Y÷ª]≤ú©≤‹¬!Y.2LñWóÂ#óe<d≈≥BYâöHVÚﬁIV:—%+ªñ)´¯\\(´º{KV≠ﬁ$´—,ó’\\ÀjÍKd˜øë=lçî’n πreè™NÀ”≈≤ß?©≤ßÿrY√⁄;≤g∑›dœz2d/=»^5ñ ^·eØïªeo“Y≤6k∞¨˝ƒFY˚óeY;õ)Îd’Àzí7 zù1≤æ˙Ÿ¿eUŸ\0\"L6º∫I6æ&ˆí}Î÷î}[ÃìMU»¶iWd≥ˆu≤YXálñ√î˝¯¥Eˆ”køÏ◊næÏ◊D±ÏœÈõ≤?µ√≤˚bŸ_\r†®íÅ∑ó… Œ…êçèd®ç{e(?C¶ØMÜÕW»p7;d¯–æßNF∏+#>®îëU/À»Î¬d‰˛pÕ¢FF√ídt‹z√8C∆Zõ#c≠€+c1˜…8;d@éåõQ(pjd¢ÉÁe\"k[ôËUÉL˙®Q&õJì…/Á î\reãjtŸ mŸø|3Ÿø∫;r’A≤|ıGæÊ`ñ|çÖè|MNë|Ì§â\\Û˝n˘∫ΩÚuëÎÂÎw®…µ¢drùñAπûÉó\\Ôûó\\ˇΩá|õ˛q˘4LæcÂª|˜`≤|èø\\æwPMnÿ#ëÔõ,ﬂøn£¸\0Ó±‹»<VnÙG[nº=Wnúï/7ûòñ<ﬁ+7›~Gn÷ù-?‰l\"∑\\;+∑¸—,∑2Óë[\'ç o˜îÆ∑î€?¸#?¢~[~ƒ6MÓP˚\\Ó@Á»·l˘QáÉÚ£Ô?ÀùN4»ùﬂF ›^…Oåj…OHˇ»=7éÀ=á\n‰ß&fÂ>µ<πœáP˘ÈürﬂÔ&r_∆g˘Y∂X\\»óá‹›+øTxFÊ CûóáÎï_˘)è¯ºIÒëGj€»onìﬂ<a è±‘ì«Tä‰qE›Ú¯⁄”Ú¯:¢<·gã¸∂Aû®±Jû$®ó\'Ô√ S~?óß@À”Ú‰œSÂ˜¿ÂŸ€£‰yIpyﬁK¶<o—D^¿¸,/í˜GÀKˆ¯ K+·Ú“°!yÖÙÅº:ÕO˛»≥Y˛8Û§¸±Úæº˛I˛‘kïº!ºY˛ZPﬁy_˛ÊU¶¸m\nY˛ŒX ◊± oeô…ﬂ°‰m.ΩÚv◊ÉÚ≥fy«¿®ºC)ÔÃ¬ ;+;‰ù“›ÚÆn∂º€ƒY˛A£Z˛a∆I˛È}è|¯Ωµ|§¡S>*!À«¢ÌÂc?ÒÚ/ªﬂ…ø‘ÌìOlüëOòÀøû»ßR g˜G»gìn»ø˜u…ó…ﬁ Á›ëÚÖAS˘¬bõ¸Ø	\\˛◊î*^æ á¥T…°emrË§≥ñ“$áÅJÂ≠1r∏~§ûp^ézCì£_ˇícw1ÂXêùwÂñ–î„ãÂÑl¥úòR&\'—≥Â‰\0;9u&g¨Ní3ˇlë≥<…9Z29/Îßú˜aüú7≈ì˚ Â\"≠πHT,â˝Â‚—	πò5\'óéíK˝ßÂãw⁄‰ãœÀóŒ‰À÷D˘J∏ª|ÂvïB•¬C°20™X’˛Y°6âU®o>†P?ù®XªqªB´8D±aªüb€D±icÇbK-X°ØˇK°ü}H±-ÙÑb\"I±36S±À0M±{UÜ¬¿,]±Áµß¬–}D±/oçbﬂß´ä˝À\n≈ˇÖ±Nø‚†˝í‚‡‘KÖŸHï¬‹{Ta˛–HaëQ´∞=‹ß∞=Ê¢∞ﬂ¥¢p∏R£pŒ)éﬁˇ§pRΩ¢p◊5Vxò7+<Ä9äØC^>Œ\n/?mÖÔpà¬Ø™C·Ô≠¶ü*Œ^sT¨y™@<SÓnU};£‚g)ŒãrÛ).›G*B+S·ÜbExú¶‚2œVq≈cJqe(XqΩ˝é\"∫nç‚Fqè\"v»@˜Å†à7lR‹⁄ÙYqÎrã‚vÅΩ\"±q@ëtÙ¨\"Ÿ¸¥\"EU¢Hï>Td\0™ˇé)≤ÚR˜Ø~T‰ÃÑ*r34π‹Àä¢©‚ÅkÆ¢¨÷]QæIWQnü¶(è) „ü* G™ï¢ï^CäJø\"Eefæ¢≤uá¢Í®®n¸´®˛ô°x¸Ù™¢ﬁÛÆ¢±^K—¯Ï±¢πlΩ‚•é°‚UıM≈k3≈Î€ä◊çÁ-$º‚›Â≈{o[E[tä¢3?N—’¨Ëöπ°Ëﬁ®©¯p√W—#ÕSÙ˘‘*>ñß+˙Õﬂ(jlΩéäÅÒ)≈ÒµbtüØbl˙•‚´Í}≈dÿ≤b¶•òy©ò˝’´¯çwV¸Ÿ=®¯˚§\0¨ıT\0\Zî\n†ÒÑ\Zb≠@ûR O)PKØxü„\n¸6a˝\n\"ÁØÇ**»)k|ÉÇ√~¶‡Fg*∏¥œŸ]¡k…V±\nÌäBŒ;§Pﬁ•PîúR(föã3jä•ó\0≈ä˝7≈J#M©RP≠\\u%^©jó°TÎ¬+’wÃ+’]tïÍ¸^•∫§Dπöa®\\czNπÊ3Nπ«SÆ∑úSÆèÿ£\\ü5¨‘¢?UÍËWÍ5+uÊ’ï∫ó¸ï=+7◊ÓQnn≤PnÈLVnçJWÓÿv\\π„’∏rßTOπÀvØ“‡€_ÂûÙOJCÒàrü∆KÂ>-¶rü≥≥rﬂµ*•±∂£“8„ÑÚ‡ê¶Ú \r•<»âVöû…TöùQöıºTöûS*;¶¥tRZÌéVZÌ¶¥Òá(mŒö+ÌN*Ìcïv¸E•}UÜÚ(#NÈl-P:S›ï.ÓT•À •k◊/•ª≈\r•ªΩ\\ÈÅ∏©Ùrÿ¶ÙBûP˙l\\≠<ù$Vû~}Ry¶πMÈ\'Ω†<+ø©pW‘Ö*∞© `ßzÂ9”tÂ˘¶ ã\rﬁ ∞ò˜ ÀAGïW[_(#Á◊+£\no)£K÷)ofﬁS∆Âó(oôT*ì\rî…ıoï)K ‘+Ö Ù5ö tÁ)Â›yÆ2ÎÍ≤2ß1[ô√mVÊemRÊw¯*ﬂ§(ã˙ïÏÛïZø)KW˘(KŸ} ö€\'î5,oÂ√ov ⁄ï|eÌá≤NT>™›©|í{M˘¥Ë†≤!ºWŸHèR>∑8Ø|~≠G˘\"gV˘û¶|µ6U˘˙¨ü≤Â‡Ä≤ÂÓ≤≤µ«_˘ﬁÊ≠Ú}T£≤≠ÕOŸn–≠lØÎWv°Rî›âi æ»´ èeBÉr†üß?¨ÙTüUYQÉ\Zî#¶èî#ÿpÂ-_˘%˙ôr\"ıõÚkÄÉr2Ç™úD~UN„”î”luÂÏÜW kÆ)ÙŒ)3µîsîmªîÄ-.J\0ıâ∏⁄J	∂¯´ÑúWBn¯)aÃKJ8ËÆÒ–Uâ‹•P\"[ï(ù£Jå„q%°Ïïí$\nPímæ*)&Îï‘ê%Û∞\\…ú∏°‰Îu*˘âh•¿∂C)‚·îOŒ√XùrŸ!bq’ˇ\Z†œx >Ä„ECÉ+ârâJi©4.•¨8\\CK\"B	óî∫“NÈIIëHÑ–¿•T$\r°%ëPäT$Rt“•ˇzÓ’ÔÌ˜Û≥Àè—†Pz∫ÈnÇng@∑(%Ëô≥zÖ◊CÔÛß†œQeËª£î≠™@ŸÎ(®´ÉÍÊhPç-/ÅÊ§À†yÙ¸⁄g¸öZ≥ì`»|WÚ≥¥ïÃA;§Ëˆ¨=]–õ©zÙ˚,˝~Ò†_R\r˙ï`ÒF™]ÑQ}r¡p`<π=£€π`Ùc$L–5Äi%\'a˙ó50cö\'òN—”yf`˙Ê1XtçÎ˜¿:eXü˜\0≠∞±]∂¡ˆy∞˚mÿ-=vˇª·`ükˆ≈Â0øe,P+Gıë∞¯ª,}4\nñÌÙÖÂÆn‡úu\\œÂ√*√e‡n1‹_<Ç’ÔØÅÁR˝^ì`Ìˆ≥∞ˆ’tY±|ﬁÄﬂÒd;i˛CÄ}¨Ëg¬F}?ÿ=6ñ™¬&›∞Ÿq:lﬁUõœD¬6uÇ†Nmÿ9ÙÏ>Èª¬ﬁq˝aot*x∏B D\'B‹o@H„¯ﬂÙ*84J¬LÖ∞ú˜pÏÇD˝g?9eD;«AÃ_eS}bˇ,ÇÿΩÖÁ†\rqÎVBº”EàwUáÁÔê8b$N2á$µH⁄RggéÇîP#87k=úü}.¯ÍAz◊\\H_<2ŒlÑKwáÃ2o∏º~\\˘ñ\nW’ï·ÍöÁpÕ∞nVô@ﬁÊT»;∑˙¬ÌÃp∏3¥7‹Id∏”˛Úc.¿=}∏Áø\néÊBQX)<MÜG\njP|˘<<q_•Åè°Ã¯=îyˆÉ≤TCx∂\'\Zû;~ÖÁIÔ†b…p®\\´\0UGW¡À_¡+\'x}—ÍFÎ@ùQ&º”˙Ôä¥†·â4jƒB£Ûhº˘_ãè@Û¨Â©p¥Ïˇ≠ü2°M2|wæùÉ:[√Oïwsµ¸|z†3Ë—*`ùvÏ‚≤ª÷öaOYÜJ¡\n®tB\r{∑.¿>Nﬁ®|…\ZU~t‡/;Œ¢ÍÂ8`¨\'¸˛’/ÃAç›®q!v˘éöõíQ{P#õ7ı˜W£¡ä´hpÎéÍˆGe˛ÅÜÛ£qÙ†Ì8∆¨«ÿtG£KG–ËJ>ékUƒ	/\"pbÆ\Z/ÓáìVt≈)Ω›–$ÃMö£Iâ6Nµ±∆iW4p˙h\rúÒ˚Q4µ[Ü¶·É—,`ŒQ™«9Cﬂ‡úöWh~‰Z\\˙-≤—“ˇ)Z^|Çñizh≠2≠Ì—F˚2⁄*úC;∑l¥/:éÜﬂpÅK9.Ò˚\róÑU‚≤!˚–i…=tz:WÊMDówQË\Z˙=\\é†G‹ÔËë8=ﬂèCœ/—Kw5z≠rBØ¿V\\”7◊L\n√5è¢˜?{–g¯ÙM´CﬂúzÙ≠ﬂÉ~ÁÒœI∑1@µ?nL≤¡@≈+∏9˙n±xÇ[Ωbq´_wÚ∞¡ÌÅÀp«5{‹Âoè{ˆƒ·ﬁm^∏ÔÌ4∂4≈˝¡_p?¥„Å3ó¿õ’x0˝\ZrùÖá6ıƒ–‡%x8¶èÏ™√£ÒÆNvïâ—qõ0Ê[∆ˆöç±∫éw¢\n„}‘å≤#ûyÒ&<÷∆$çCòîúç…ö„0•©?û`ÑÈ=1c˝[Ã¯˙/5·eW+Ã≤äYSzK=fÁ`NbﬁË≤oÏùÜ7ˇ{õ˜›oMôä∑?«ª5òÔ±ÔeÏ∆{◊˝±¿e%j,¡BˇXd\\ã˜ÌÒ˛—\n|°Ç≈üöI?G,›\\èeœª„≥Ñh|ˆ∂	üﬂ\rƒ\nø`¨‹5+kØc’∏]¯“ø_V¡ÍîX]Ω\rk<W`≠‚I¨ΩÇoæb]¶æ5ûâ?NΩã3µ„ÛÅÿûéÕﬂn`Ky~VŸåü…\røºÍ¿ØFIÿ~d∂w~H√Û˙‡ùçÿ˘3\0·ót$´{»ì£I—4ú?ø¶n.Õ‘}¿rÍë\\E=Ì3Ii¸gÍ5ÀîzøøB}‹:H9/ùTˆ≈Pøüi@ü—§úMÉ“†q«i–ır“\\[Bö«íÊ≠˙5¸\"i]J!Ì·ìH{YÈúâßa]7–∞≠wIoû	È=n&É´dË‹LÜ!/»∞v>ç\røL∆™»¯Î%ö4„0M*J¢)ö\'i ¢d¢^J&ˇ$“‘„h⁄Å{4≠|+M7/†ôû¶d∫¶êÊ∫ö—‹ÖdnÈLÅH\r&d9ÕêÊ•ìm‹E˙}S9®,%á≥6ÙG»öïBÛøá“¸BßÌ§Eª»ÒF9ñœ•≈%\Z¥ts-M;LÀú√…yw≠ts†U´Øí˚\\ZÌ@’é‰πey≈áê◊eZgùN>·ö‰õπó|ÔO%?Ø0˙≥°ç¸5ï»ﬂ;î6X”ÊP⁄ñ@ª∆Ì¢}”Çhüﬂ⁄á(∏†?òËK÷|¢êıÔÈ‡Xc:§§Máº\'P®Å5ÖñŸ–·2:û—Hë3/PTkù\\	tj≈dä≠+¢”7À(n·1JP$JPk°ÑEùî®ÛîílÕ(È∫ùÌ≠Bgá≠ß≥>îÚøJ-ç¶‘Ü:?£í“bú)ÌQ•5ÈS∆1o˙{A]äJ†ÀÁ<(kv\"]uø@◊^”ıå  6LŸv~îì„B9πÁËF G ù|Örøˇ§[]ÃÈ÷œ2 ÚÇÚ74P˛ˆ≈T‘‰Dzô”√Ö:ÙËÃ*˛ˆçJﬁ]¶ß£OR©g_*\r2ß“s*”\ZHeÎﬁPπ≤-ïˇﬁFï«s®™ã=U;ç¢Í¸2™uÈIµG“ª’ÙÓL Ω∑Ô§˜?fP√î˙(-‘øáöoÜRsÛ~˙‘ÚµhÌ¶ñKmÙ˘≈Kj_∫Ç⁄´®£Ou∏U–˜‘ÎÙs@˝\\Ÿãƒ ÜÑ∆póÕÃ];-X!≤ërSYq¢˜?ñïŒ¶rØ=VŒˆgïßU‹œ.â˚Ωy…™]G∞ÍSVmV‰uXm~\'´eﬁ‰A}áÚ‡¶<∏—ôµÊ˘Ú–êJ÷YpÉu˜M`›Œ<Ã⁄ÑáeO`ΩπœŸ`Ù56»ÎÕ#V≠Êaù<‚x	è¯§¡#\r◊Ò»∆È<∫[èΩlœ„ÃñÒx„æ<añ:OˇÑ\'∫⁄∞±Ôdû<√ù\'áÌ‰)Œ3Ÿ§Láßû^Ã3ó&≥i~œéW`≥™M<«Ì[&›b+Â,ûÁpãÌ«{≤ΩÔ^0∂úZGÚ‚;5ºÙt/_W¿ÀÉ?Ûä≤\rÏRm≈ÆÛ&™_ŸÕ´â›N]e˜”yuè-ÏqŸê=ØÆcØ±±º&Bx≠e(ØΩ∂ù◊’≤∑ß&{\'Ò∫?ˆôb æô£ŸO˜oPˇáf.‚@-\\~ÄÉä¨9®]çwm±‰›£ÁºØQïÉ∑òqÅ8~µÉCå¢8tq9áﬁ©‰√O{pÿötÀ®Ê∞6|¥s&ªŸïèg#G‰_·àØ8“πë#Î	c\r>πQù£S?sLËO>’xãO˝[√±ä9V´ÜOo„”‚ÃÒ+Ôp¸›ïú‡ìƒIÉ˘¨ﬁNﬁËÕ…Myú¸èß(·s≥æÛy˝¡|qÆßØh‰Ù}Öú°Æ∆√î˘Ôâá8´˛&_®‰úˆfæÒk-Á™’≠Ú£|{»Næù—ìÔÆ∆w}˛Ê|Ô|Ô¯..(⁄ÃÖ;Í˘°\"Ú√º(~ÿñŒè€∫Ûì›’¸\"˘Èpu.7I·Á•E\\Ò–ç+^Ás•ﬂa~i;û´˚¿Øn¸‡◊#fÚÎÜg\\”≈Ék5ñs≠ÂN~SÿÖﬂ¸;ùÎnˆ·∫;É˘m„ÆüÏŒı€>r˝µHn®|ÃC«pì·}˛4@Ö?≠´Â÷ø∂Ú◊‹%¸MœéøY~‰ßÖÛè±^åg3˜bÈ⁄ØQÚPÁâ“6]Q>Q\'˝]æàÍjQ´}!ÍeWdËÂ¢5!QÜ‰ÑãvÄøh«gäˆ}O\Z8Wt\"~ùXO—)Œ›é2Ï§±ËÔ*√«4ã˛†$—?≥C˙_ÉØ˚ƒÄ˙À(ÌEáƒ–¬H∆<8(c*A∆ôd DjïIÀ£dJ¢∫Lm6ó€ﬁäÈ5±»V´Q±buJSlUä≈6ƒ∂¶áÿ÷æ€wä]ÚT±ü⁄)Û[ÃdA‚HYx⁄UÇ£8Œ*î%Ê ≤‘åeiLî8π´ä”´4Y5t§¨⁄T#´;ãWIä¨ıÒÔ·…∫ÊÒ)	_+KY?{å¯˜Wêø4L‰Ø‡Ÿ∫3M∂(JêÁzŸi•(;Ûã%ÿ”Xˆ\'ªJàzõL“íÉˇvì–ò>rxêáÑ\rkêàx+â¥Ë.ëWÇ‰Ñ∆Z9Ò£ãD5ıñòŒ?‰T‚Pâ›X-	+NH‚ëãíXV()k^KJ`Ñ§ÏÈ\'©c˝%uFÅúSìÛi#$”≠H≤ÑIñÀs…™ÿ\"Yµ%rı”π6\'A≤\"$\'*RrÌ≠%◊©@Úﬁ∫…ùúR…?T$˘°ÓR01J\n\'ŒìBUyêV*u\n‰qêì<˛ﬁEäwIqM†∑∂HIŒgy:–JûŒ<$•c §¥≠@ éI˘~yæ˛ãTx{H≈∂πRY Uçw‰e[≠º˙≠BjﬁöKM€Z©=~BÍÇ◊…;ÖŸÚNÀEﬁM»ì˙9(\r˝{K√€è“–û%ç.Ω•i∏ã|2⁄ -ìµ‰ÀŸf˘Rë+≠ªHÎ_iΩ>GæfÕìØgÂk{ê|Ì®ïˆÌ ∑¡Q“1›]:∂ôHG¸\"È®nêŒ˚K‰Á\ZS˘˘ Mï¶–ß$aã≠¬Õ©√flˇ?…wZj»ë\0','no'),
('manualScanType','onceDaily','yes'),
('max404Crawlers','DISABLED','yes'),
('max404Crawlers_action','throttle','yes'),
('max404Humans','DISABLED','yes'),
('max404Humans_action','throttle','yes'),
('maxExecutionTime','0','yes'),
('maxGlobalRequests','DISABLED','yes'),
('maxGlobalRequests_action','throttle','yes'),
('maxMem','256','yes'),
('maxRequestsCrawlers','DISABLED','yes'),
('maxRequestsCrawlers_action','throttle','yes'),
('maxRequestsHumans','DISABLED','yes'),
('maxRequestsHumans_action','throttle','yes'),
('migration636_email_summary_excluded_directories','1','no'),
('needsNewTour_blocking','0','yes'),
('needsNewTour_dashboard','0','yes'),
('needsNewTour_firewall','0','yes'),
('needsNewTour_livetraffic','0','yes'),
('needsNewTour_loginsecurity','0','yes'),
('needsNewTour_scan','0','yes'),
('needsUpgradeTour_blocking','0','yes'),
('needsUpgradeTour_dashboard','0','yes'),
('needsUpgradeTour_firewall','0','yes'),
('needsUpgradeTour_livetraffic','0','yes'),
('needsUpgradeTour_loginsecurity','0','yes'),
('needsUpgradeTour_scan','0','yes'),
('neverBlockBG','neverBlockVerified','yes'),
('notification_blogHighlights','1','yes'),
('notification_productUpdates','1','yes'),
('notification_promotions','1','yes'),
('notification_scanStatus','1','yes'),
('notification_securityAlerts','1','yes'),
('notification_updatesNeeded','1','yes'),
('onboardingAttempt1','skipped','yes'),
('onboardingAttempt2','','no'),
('onboardingAttempt3','','no'),
('onboardingAttempt3Initial','0','yes'),
('onboardingDelayedAt','0','yes'),
('other_blockBadPOST','0','yes'),
('other_bypassLitespeedNoabort','1','yes'),
('other_hideWPVersion','1','yes'),
('other_pwStrengthOnUpdate','1','yes'),
('other_scanComments','1','yes'),
('other_scanOutside','1','yes'),
('other_WFNet','1','yes'),
('previousWflogsFileList','[\".htaccess\",\"attack-data.php\",\"config-livewaf.php\",\"config-synced.php\",\"config-transient.php\",\"config.php\",\"GeoLite2-Country.mmdb\",\"ips.php\",\"rules.php\",\"template.php\"]','yes'),
('scanAjaxTestSuccessful','1','yes'),
('scanFileProcessing','a:2:{i:0;s:40:\"node_modules/uuid/dist/umd/uuidv1.min.js\";i:1;i:1681898156;}','yes'),
('scanMonitorLastAttempt','1681898136','yes'),
('scanMonitorLastAttemptMode','custom','yes'),
('scanMonitorLastAttemptWasFork','1','yes'),
('scanMonitorLastSuccess','1681898137','yes'),
('scanMonitorRemainingResumeAttempts','2','yes'),
('scansEnabled_checkGSB','1','yes'),
('scansEnabled_checkHowGetIPs','1','yes'),
('scansEnabled_checkReadableConfig','1','yes'),
('scansEnabled_comments','1','yes'),
('scansEnabled_core','1','yes'),
('scansEnabled_coreUnknown','1','yes'),
('scansEnabled_diskSpace','1','yes'),
('scansEnabled_fileContents','1','yes'),
('scansEnabled_fileContentsGSB','1','yes'),
('scansEnabled_geoipSupport','1','yes'),
('scansEnabled_highSense','0','yes'),
('scansEnabled_malware','1','yes'),
('scansEnabled_oldVersions','1','yes'),
('scansEnabled_options','1','yes'),
('scansEnabled_passwds','1','yes'),
('scansEnabled_plugins','1','yes'),
('scansEnabled_posts','1','yes'),
('scansEnabled_scanImages','1','yes'),
('scansEnabled_suspectedFiles','1','yes'),
('scansEnabled_suspiciousAdminUsers','1','yes'),
('scansEnabled_suspiciousOptions','1','yes'),
('scansEnabled_themes','1','yes'),
('scansEnabled_wafStatus','1','yes'),
('scansEnabled_wpscan_directoryListingEnabled','1','yes'),
('scansEnabled_wpscan_fullPathDisclosure','1','yes'),
('scanStageStatuses','a:11:{s:13:\"spamvertising\";a:4:{s:6:\"status\";s:7:\"premium\";s:7:\"started\";i:0;s:8:\"finished\";i:0;s:8:\"expected\";i:0;}s:4:\"spam\";a:4:{s:6:\"status\";s:7:\"premium\";s:7:\"started\";i:0;s:8:\"finished\";i:0;s:8:\"expected\";i:0;}s:9:\"blacklist\";a:4:{s:6:\"status\";s:7:\"premium\";s:7:\"started\";i:0;s:8:\"finished\";i:0;s:8:\"expected\";i:0;}s:6:\"server\";a:4:{s:6:\"status\";s:16:\"complete-success\";s:7:\"started\";i:5;s:8:\"finished\";i:5;s:8:\"expected\";i:5;}s:7:\"changes\";a:4:{s:6:\"status\";s:16:\"complete-warning\";s:7:\"started\";i:4;s:8:\"finished\";i:4;s:8:\"expected\";i:4;}s:6:\"public\";a:4:{s:6:\"status\";s:7:\"running\";s:7:\"started\";i:1;s:8:\"finished\";i:1;s:8:\"expected\";i:2;}s:7:\"malware\";a:4:{s:6:\"status\";s:7:\"running\";s:7:\"started\";i:2;s:8:\"finished\";i:1;s:8:\"expected\";i:2;}s:7:\"content\";a:4:{s:6:\"status\";s:7:\"running\";s:7:\"started\";i:1;s:8:\"finished\";i:0;s:8:\"expected\";i:3;}s:8:\"password\";a:4:{s:6:\"status\";s:7:\"pending\";s:7:\"started\";i:0;s:8:\"finished\";i:0;s:8:\"expected\";i:1;}s:13:\"vulnerability\";a:4:{s:6:\"status\";s:7:\"pending\";s:7:\"started\";i:0;s:8:\"finished\";i:0;s:8:\"expected\";i:1;}s:7:\"options\";a:4:{s:6:\"status\";s:7:\"pending\";s:7:\"started\";i:0;s:8:\"finished\";i:0;s:8:\"expected\";i:2;}}','no'),
('scanTime','1681898157.3623','yes'),
('scanType','custom','yes'),
('scan_exclude','','yes'),
('scan_force_ipv4_start','0','yes'),
('scan_include_extra','','yes'),
('scan_maxDuration','','yes'),
('scan_maxIssues','1000','yes'),
('scan_max_resume_attempts','2','yes'),
('schedMode','auto','yes'),
('schedStartHour','1','yes'),
('scheduledScansEnabled','1','yes'),
('serverDNS','1688175220;200503;127.0.0.1','yes'),
('serverIP','1688175529;178.74.237.150','yes'),
('showAdminBarMenu','1','yes'),
('signatureUpdateTime','1681837487','yes'),
('spamvertizeCheck','1','yes'),
('ssl_verify','1','yes'),
('startScansRemotely','0','yes'),
('supportContent','{}','no'),
('supportHash','','no'),
('timeoffset_wf','0','yes'),
('timeoffset_wf_updated','1688175237','yes'),
('totalAlertsSent','2','yes'),
('totalLoginHits','2','yes'),
('totalLogins','1','yes'),
('totalScansRun','1','yes'),
('touppBypassNextCheck','0','yes'),
('touppPromptNeeded','0','yes'),
('vulnerabilities_plugin','a:65:{i:0;a:4:{s:4:\"slug\";s:24:\"accelerated-mobile-pages\";s:11:\"fromVersion\";s:6:\"1.0.86\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:1;a:4:{s:4:\"slug\";s:12:\"acf-extended\";s:11:\"fromVersion\";s:7:\"0.8.9.3\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:2;a:4:{s:4:\"slug\";s:35:\"all-in-one-wp-security-and-firewall\";s:11:\"fromVersion\";s:5:\"5.1.9\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:3;a:4:{s:4:\"slug\";s:9:\"axio-core\";s:11:\"fromVersion\";s:5:\"1.1.2\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:4;a:4:{s:4:\"slug\";s:19:\"broken-link-checker\";s:11:\"fromVersion\";s:5:\"2.2.0\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:5;a:4:{s:4:\"slug\";s:17:\"bulk-page-creator\";s:11:\"fromVersion\";s:5:\"1.1.4\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:6;a:4:{s:4:\"slug\";s:24:\"child-theme-configurator\";s:11:\"fromVersion\";s:5:\"2.6.2\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:7;a:4:{s:4:\"slug\";s:18:\"child-theme-wizard\";s:11:\"fromVersion\";s:3:\"1.4\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:8;a:4:{s:4:\"slug\";s:14:\"classic-editor\";s:11:\"fromVersion\";s:5:\"1.6.3\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:9;a:4:{s:4:\"slug\";s:15:\"classic-widgets\";s:11:\"fromVersion\";s:3:\"0.3\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:10;a:4:{s:4:\"slug\";s:4:\"cmb2\";s:11:\"fromVersion\";s:6:\"2.10.1\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:11;a:4:{s:4:\"slug\";s:25:\"code-quality-control-tool\";s:11:\"fromVersion\";s:3:\"0.1\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:12;a:4:{s:4:\"slug\";s:14:\"complianz-gdpr\";s:11:\"fromVersion\";s:5:\"6.4.7\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:13;a:4:{s:4:\"slug\";s:14:\"contact-form-7\";s:11:\"fromVersion\";s:5:\"5.7.7\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:14;a:4:{s:4:\"slug\";s:18:\"contact-form-cfdb7\";s:11:\"fromVersion\";s:7:\"1.2.6.5\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:15;a:4:{s:4:\"slug\";s:24:\"customizer-export-import\";s:11:\"fromVersion\";s:5:\"0.9.6\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:16;a:4:{s:4:\"slug\";s:19:\"custom-post-type-ui\";s:11:\"fromVersion\";s:6:\"1.13.6\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:17;a:4:{s:4:\"slug\";s:5:\"debug\";s:11:\"fromVersion\";s:4:\"1.10\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:18;a:4:{s:4:\"slug\";s:9:\"debug-bar\";s:11:\"fromVersion\";s:5:\"1.1.4\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:19;a:4:{s:4:\"slug\";s:21:\"disable-admin-notices\";s:11:\"fromVersion\";s:5:\"1.3.3\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:20;a:6:{s:4:\"slug\";s:26:\"enable-svg-webp-ico-upload\";s:11:\"fromVersion\";s:5:\"1.0.3\";s:10:\"vulnerable\";b:1;s:4:\"link\";s:108:\"https://www.wordfence.com/threat-intel/vulnerabilities/id/6df7bd57-7d2f-4098-b2d0-ffb2e8ed5868?source=plugin\";s:5:\"score\";s:4:\"5.40\";s:6:\"vector\";s:44:\"CVSS:3.1/AV:N/AC:L/PR:L/UI:N/S:U/C:L/I:L/A:N\";}i:21;a:4:{s:4:\"slug\";s:20:\"ewww-image-optimizer\";s:11:\"fromVersion\";s:5:\"7.1.0\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:22;a:4:{s:4:\"slug\";s:12:\"f12-profiler\";s:11:\"fromVersion\";s:5:\"1.3.9\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:23;a:4:{s:4:\"slug\";s:10:\"fakerpress\";s:11:\"fromVersion\";s:5:\"0.6.1\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:24;a:4:{s:4:\"slug\";s:12:\"health-check\";s:11:\"fromVersion\";s:5:\"1.6.0\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:25;a:4:{s:4:\"slug\";s:23:\"contact-form-7-honeypot\";s:11:\"fromVersion\";s:5:\"2.1.1\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:26;a:4:{s:4:\"slug\";s:24:\"index-wp-mysql-for-speed\";s:11:\"fromVersion\";s:6:\"1.4.13\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:27;a:4:{s:4:\"slug\";s:15:\"litespeed-cache\";s:11:\"fromVersion\";s:3:\"5.5\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:28;a:4:{s:4:\"slug\";s:28:\"orbisius-child-theme-creator\";s:11:\"fromVersion\";s:5:\"1.5.4\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:29;a:4:{s:4:\"slug\";s:15:\"performance-lab\";s:11:\"fromVersion\";s:5:\"2.4.0\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:30;a:4:{s:4:\"slug\";s:16:\"plugin-detective\";s:11:\"fromVersion\";s:6:\"1.2.14\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:31;a:4:{s:4:\"slug\";s:16:\"plugin-inspector\";s:11:\"fromVersion\";s:3:\"1.5\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:32;a:4:{s:4:\"slug\";s:25:\"plugins-garbage-collector\";s:11:\"fromVersion\";s:4:\"0.14\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:33;a:4:{s:4:\"slug\";s:13:\"query-monitor\";s:11:\"fromVersion\";s:6:\"3.12.3\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:34;a:4:{s:4:\"slug\";s:16:\"seo-by-rank-math\";s:11:\"fromVersion\";s:7:\"1.0.118\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:35;a:4:{s:4:\"slug\";s:17:\"really-simple-ssl\";s:11:\"fromVersion\";s:5:\"7.0.5\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:36;a:4:{s:4:\"slug\";s:23:\"rewrite-rules-inspector\";s:11:\"fromVersion\";s:5:\"1.3.1\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:37;a:4:{s:4:\"slug\";s:9:\"seo-image\";s:11:\"fromVersion\";s:5:\"3.0.5\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:38;a:4:{s:4:\"slug\";s:14:\"simple-history\";s:11:\"fromVersion\";s:5:\"4.1.0\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:39;a:4:{s:4:\"slug\";s:19:\"site-health-manager\";s:11:\"fromVersion\";s:5:\"1.1.2\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:40;a:4:{s:4:\"slug\";s:15:\"google-site-kit\";s:11:\"fromVersion\";s:7:\"1.103.0\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:41;a:6:{s:4:\"slug\";s:24:\"quick-edit-template-link\";s:11:\"fromVersion\";s:5:\"3.1.2\";s:10:\"vulnerable\";b:1;s:4:\"link\";s:108:\"https://www.wordfence.com/threat-intel/vulnerabilities/id/8da0fed9-4b88-4b68-b317-124fe678cfa4?source=plugin\";s:5:\"score\";s:4:\"4.30\";s:6:\"vector\";s:44:\"CVSS:3.1/AV:N/AC:L/PR:N/UI:R/S:U/C:N/I:L/A:N\";}i:42;a:4:{s:4:\"slug\";s:11:\"theme-check\";s:11:\"fromVersion\";s:8:\"20230417\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:43;a:4:{s:4:\"slug\";s:15:\"theme-inspector\";s:11:\"fromVersion\";s:5:\"4.0.1\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:44;a:4:{s:4:\"slug\";s:10:\"ukr-to-lat\";s:11:\"fromVersion\";s:5:\"1.3.5\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:45;a:4:{s:4:\"slug\";s:11:\"updraftplus\";s:11:\"fromVersion\";s:6:\"1.23.6\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:46;a:4:{s:4:\"slug\";s:12:\"webp-express\";s:11:\"fromVersion\";s:6:\"0.25.6\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:47;a:4:{s:4:\"slug\";s:24:\"widget-importer-exporter\";s:11:\"fromVersion\";s:5:\"1.6.1\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:48;a:4:{s:4:\"slug\";s:10:\"insert-php\";s:11:\"fromVersion\";s:6:\"2.4.10\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:49;a:4:{s:4:\"slug\";s:9:\"wordfence\";s:11:\"fromVersion\";s:6:\"7.10.0\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:50;a:4:{s:4:\"slug\";s:18:\"wordpress-importer\";s:11:\"fromVersion\";s:5:\"0.8.1\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:51;a:4:{s:4:\"slug\";s:12:\"inspector-wp\";s:11:\"fromVersion\";s:5:\"1.1.0\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:52;a:4:{s:4:\"slug\";s:11:\"wp-optimize\";s:11:\"fromVersion\";s:6:\"3.2.15\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:53;a:4:{s:4:\"slug\";s:12:\"wp-debugging\";s:11:\"fromVersion\";s:7:\"2.11.22\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:54;a:4:{s:4:\"slug\";s:15:\"wp-file-manager\";s:11:\"fromVersion\";s:5:\"7.1.9\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:55;a:4:{s:4:\"slug\";s:13:\"wp-log-viewer\";s:11:\"fromVersion\";s:5:\"1.2.1\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:56;a:4:{s:4:\"slug\";s:15:\"wp-mail-logging\";s:11:\"fromVersion\";s:6:\"1.12.0\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:57;a:4:{s:4:\"slug\";s:16:\"wp-reroute-email\";s:11:\"fromVersion\";s:5:\"1.4.9\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:58;a:4:{s:4:\"slug\";s:18:\"wp-theme-optimizer\";s:11:\"fromVersion\";s:5:\"1.1.4\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:59;a:4:{s:4:\"slug\";s:13:\"wp-theme-test\";s:11:\"fromVersion\";s:5:\"1.2.1\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:60;a:4:{s:4:\"slug\";s:13:\"wordpress-seo\";s:11:\"fromVersion\";s:5:\"20.10\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:61;a:4:{s:4:\"slug\";s:18:\"acf-theme-code-pro\";s:11:\"fromVersion\";s:5:\"2.5.3\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:62;a:6:{s:4:\"slug\";s:26:\"advanced-custom-fields-pro\";s:11:\"fromVersion\";s:5:\"6.1.4\";s:10:\"vulnerable\";b:1;s:4:\"link\";s:108:\"https://www.wordfence.com/threat-intel/vulnerabilities/id/e7ae8dcd-00b6-4afc-85bb-6697820bb37c?source=plugin\";s:5:\"score\";s:4:\"6.10\";s:6:\"vector\";s:44:\"CVSS:3.1/AV:N/AC:L/PR:N/UI:R/S:C/C:L/I:L/A:N\";}i:63;a:4:{s:4:\"slug\";s:29:\"advanced-database-cleaner-pro\";s:11:\"fromVersion\";s:5:\"3.1.7\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}i:64;a:4:{s:4:\"slug\";s:6:\"revisr\";s:11:\"fromVersion\";s:5:\"2.0.2\";s:10:\"vulnerable\";b:0;s:4:\"link\";b:0;}}','yes'),
('wafAlertInterval','600','yes'),
('wafAlertOnAttacks','1','yes'),
('wafAlertThreshold','100','yes'),
('wafAlertWhitelist','','yes'),
('waf_status','learning-mode','yes'),
('wfKillRequested','1688176071','no'),
('wfPeakMemory','130023424','no'),
('wfScanStartVersion','6.2','yes'),
('wfsd_engine','','no'),
('wfStatusStartMsgs','a:16:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:0:\"\";i:7;s:0:\"\";i:8;s:0:\"\";i:9;s:0:\"\";i:10;s:0:\"\";i:11;s:0:\"\";i:12;s:0:\"\";i:13;s:0:\"\";i:14;s:57:\"Scanning file contents for infections and vulnerabilities\";i:15;s:53:\"Scanning file contents for URLs on a domain blocklist\";}','yes'),
('wf_scanLastStatusTime','0','yes'),
('wf_scanRunning','','yes'),
('wf_summaryItems','a:8:{s:12:\"scannedPosts\";i:0;s:15:\"scannedComments\";i:0;s:12:\"scannedFiles\";i:58633;s:14:\"scannedPlugins\";i:65;s:13:\"scannedThemes\";i:5;s:12:\"scannedUsers\";i:0;s:11:\"scannedURLs\";i:0;s:10:\"lastUpdate\";i:1681898112;}','yes'),
('whitelisted','','yes'),
('whitelistedServices','{}','yes'),
('whitelistHash','','no'),
('whitelistPresets','{}','no'),
('wordfenceI18n','1','yes'),
('wordpressPluginVersions','a:65:{s:24:\"accelerated-mobile-pages\";s:6:\"1.0.86\";s:12:\"acf-extended\";s:7:\"0.8.9.3\";s:18:\"acf-theme-code-pro\";s:5:\"2.5.3\";s:26:\"advanced-custom-fields-pro\";s:5:\"6.1.4\";s:29:\"advanced-database-cleaner-pro\";s:5:\"3.1.7\";s:35:\"all-in-one-wp-security-and-firewall\";s:5:\"5.1.9\";s:9:\"axio-core\";s:5:\"1.1.2\";s:19:\"broken-link-checker\";s:5:\"2.2.0\";s:17:\"bulk-page-creator\";s:5:\"1.1.4\";s:24:\"child-theme-configurator\";s:5:\"2.6.2\";s:18:\"child-theme-wizard\";s:3:\"1.4\";s:14:\"classic-editor\";s:5:\"1.6.3\";s:15:\"classic-widgets\";s:3:\"0.3\";s:4:\"cmb2\";s:6:\"2.10.1\";s:25:\"code-quality-control-tool\";s:3:\"0.1\";s:14:\"complianz-gdpr\";s:5:\"6.4.7\";s:14:\"contact-form-7\";s:5:\"5.7.7\";s:18:\"contact-form-cfdb7\";s:7:\"1.2.6.5\";s:24:\"customizer-export-import\";s:5:\"0.9.6\";s:19:\"custom-post-type-ui\";s:6:\"1.13.6\";s:5:\"debug\";s:4:\"1.10\";s:9:\"debug-bar\";s:5:\"1.1.4\";s:21:\"disable-admin-notices\";s:5:\"1.3.3\";s:26:\"enable-svg-webp-ico-upload\";s:5:\"1.0.3\";s:20:\"ewww-image-optimizer\";s:5:\"7.1.0\";s:12:\"f12-profiler\";s:5:\"1.3.9\";s:10:\"fakerpress\";s:5:\"0.6.1\";s:12:\"health-check\";s:5:\"1.6.0\";s:23:\"contact-form-7-honeypot\";s:5:\"2.1.1\";s:24:\"index-wp-mysql-for-speed\";s:6:\"1.4.13\";s:15:\"litespeed-cache\";s:3:\"5.5\";s:28:\"orbisius-child-theme-creator\";s:5:\"1.5.4\";s:15:\"performance-lab\";s:5:\"2.4.0\";s:16:\"plugin-detective\";s:6:\"1.2.14\";s:16:\"plugin-inspector\";s:3:\"1.5\";s:25:\"plugins-garbage-collector\";s:4:\"0.14\";s:13:\"query-monitor\";s:6:\"3.12.3\";s:16:\"seo-by-rank-math\";s:7:\"1.0.118\";s:17:\"really-simple-ssl\";s:5:\"7.0.5\";s:6:\"revisr\";s:5:\"2.0.2\";s:23:\"rewrite-rules-inspector\";s:5:\"1.3.1\";s:9:\"seo-image\";s:5:\"3.0.5\";s:14:\"simple-history\";s:5:\"4.1.0\";s:19:\"site-health-manager\";s:5:\"1.1.2\";s:15:\"google-site-kit\";s:7:\"1.103.0\";s:24:\"quick-edit-template-link\";s:5:\"3.1.2\";s:11:\"theme-check\";s:8:\"20230417\";s:15:\"theme-inspector\";s:5:\"4.0.1\";s:10:\"ukr-to-lat\";s:5:\"1.3.5\";s:11:\"updraftplus\";s:6:\"1.23.6\";s:12:\"webp-express\";s:6:\"0.25.6\";s:24:\"widget-importer-exporter\";s:5:\"1.6.1\";s:10:\"insert-php\";s:6:\"2.4.10\";s:9:\"wordfence\";s:6:\"7.10.0\";s:18:\"wordpress-importer\";s:5:\"0.8.1\";s:12:\"inspector-wp\";s:5:\"1.1.0\";s:11:\"wp-optimize\";s:6:\"3.2.15\";s:12:\"wp-debugging\";s:7:\"2.11.22\";s:15:\"wp-file-manager\";s:5:\"7.1.9\";s:13:\"wp-log-viewer\";s:5:\"1.2.1\";s:15:\"wp-mail-logging\";s:6:\"1.12.0\";s:16:\"wp-reroute-email\";s:5:\"1.4.9\";s:18:\"wp-theme-optimizer\";s:5:\"1.1.4\";s:13:\"wp-theme-test\";s:5:\"1.2.1\";s:13:\"wordpress-seo\";s:5:\"20.10\";}','yes'),
('wordpressThemeVersions','a:5:{s:19:\"axio-starter-master\";s:5:\"1.0.0\";s:15:\"twentytwentyone\";s:3:\"1.8\";s:17:\"twentytwentythree\";s:3:\"1.1\";s:15:\"twentytwentytwo\";s:3:\"1.4\";s:12:\"wp-framework\";s:10:\"2023-05-24\";}','yes'),
('wordpressVersion','6.2.2','yes'),
('wp_home_url','https://wp-framework.pp.ua','yes'),
('wp_site_url','https://wp-framework.pp.ua','yes');
/*!40000 ALTER TABLE `hadpj_wfconfig` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfcrawlers`
--

DROP TABLE IF EXISTS `hadpj_wfcrawlers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfcrawlers` (
  `IP` binary(16) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `patternSig` binary(16) NOT NULL,
  `status` char(8) NOT NULL,
  `lastUpdate` int(10) unsigned NOT NULL,
  `PTR` varchar(255) DEFAULT '',
  PRIMARY KEY (`IP`,`patternSig`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfcrawlers`
--

LOCK TABLES `hadpj_wfcrawlers` WRITE;
/*!40000 ALTER TABLE `hadpj_wfcrawlers` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_wfcrawlers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wffilechanges`
--

DROP TABLE IF EXISTS `hadpj_wffilechanges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wffilechanges` (
  `filenameHash` char(64) NOT NULL,
  `file` varchar(1000) NOT NULL,
  `md5` char(32) NOT NULL,
  PRIMARY KEY (`filenameHash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wffilechanges`
--

LOCK TABLES `hadpj_wffilechanges` WRITE;
/*!40000 ALTER TABLE `hadpj_wffilechanges` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_wffilechanges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wffilemods`
--

DROP TABLE IF EXISTS `hadpj_wffilemods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wffilemods` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wffilemods`
--

LOCK TABLES `hadpj_wffilemods` WRITE;
/*!40000 ALTER TABLE `hadpj_wffilemods` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_wffilemods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfhits`
--

DROP TABLE IF EXISTS `hadpj_wfhits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfhits` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfhits`
--

LOCK TABLES `hadpj_wfhits` WRITE;
/*!40000 ALTER TABLE `hadpj_wfhits` DISABLE KEYS */;
INSERT INTO `hadpj_wfhits` VALUES
(1,0.000000,1688175236.719319,'\0\0\0\0\0\0\0\0\0\0ˇˇ\0\0',0,302,0,2,0,'https://wpeb.ddev.site/wp-login.php','https://wpeb.ddev.site/wp-login.php?redirect_to=https%3A%2F%2Fwpeb.ddev.site%2Fwp-admin%2F&reauth=1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36 Edg/115.0.1901.151','loginOK',NULL,NULL);
/*!40000 ALTER TABLE `hadpj_wfhits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfhoover`
--

DROP TABLE IF EXISTS `hadpj_wfhoover`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfhoover` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner` text DEFAULT NULL,
  `host` text DEFAULT NULL,
  `path` text DEFAULT NULL,
  `hostKey` varbinary(124) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `k2` (`hostKey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfhoover`
--

LOCK TABLES `hadpj_wfhoover` WRITE;
/*!40000 ALTER TABLE `hadpj_wfhoover` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_wfhoover` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfissues`
--

DROP TABLE IF EXISTS `hadpj_wfissues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfissues` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfissues`
--

LOCK TABLES `hadpj_wfissues` WRITE;
/*!40000 ALTER TABLE `hadpj_wfissues` DISABLE KEYS */;
INSERT INTO `hadpj_wfissues` VALUES
(1,1681898097,1681898097,'new','knownfile',50,'181447348de2f66f53c1a116c0aa1265','6df5d32dab8471256bb53ca3f3b5c843','Modified plugin file: wp-content/plugins/seo-image/seo-friendly-images.class.php','This file belongs to plugin \"SEO Friendly Images\" version \"3.0.5\" and has been modified from the file that is distributed by WordPress.org for this version. Please use the link to see how the file has changed. If you have modified this file yourself, you can safely ignore this warning. If you see a lot of changed files in a plugin that have been made by the author, then try uninstalling and reinstalling the plugin to force an upgrade. Doing this is a workaround for plugin authors who don\'t manage their code correctly. <a href=\"https://www.wordfence.com/help/?query=scan-result-modified-plugin\" target=\"_blank\" rel=\"noopener noreferrer\">Learn More<span class=\"screen-reader-text\"> (opens in new tab)</span></a>','a:10:{s:4:\"file\";s:58:\"wp-content/plugins/seo-image/seo-friendly-images.class.php\";s:8:\"realFile\";s:84:\"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\seo-image\\seo-friendly-images.class.php\";s:5:\"cType\";s:6:\"plugin\";s:7:\"canDiff\";b:1;s:6:\"canFix\";b:1;s:9:\"canDelete\";b:0;s:5:\"cName\";s:19:\"SEO Friendly Images\";s:8:\"cVersion\";s:5:\"3.0.5\";s:4:\"cKey\";s:33:\"seo-image/seo-friendly-images.php\";s:10:\"haveIssues\";s:7:\"plugins\";}');
/*!40000 ALTER TABLE `hadpj_wfissues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfknownfilelist`
--

DROP TABLE IF EXISTS `hadpj_wfknownfilelist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfknownfilelist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `path` text NOT NULL,
  `wordpress_path` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfknownfilelist`
--

LOCK TABLES `hadpj_wfknownfilelist` WRITE;
/*!40000 ALTER TABLE `hadpj_wfknownfilelist` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_wfknownfilelist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wflivetraffichuman`
--

DROP TABLE IF EXISTS `hadpj_wflivetraffichuman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wflivetraffichuman` (
  `IP` binary(16) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `identifier` binary(32) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `expiration` int(10) unsigned NOT NULL,
  PRIMARY KEY (`IP`,`identifier`),
  KEY `expiration` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wflivetraffichuman`
--

LOCK TABLES `hadpj_wflivetraffichuman` WRITE;
/*!40000 ALTER TABLE `hadpj_wflivetraffichuman` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_wflivetraffichuman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wflocs`
--

DROP TABLE IF EXISTS `hadpj_wflocs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wflocs` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wflocs`
--

LOCK TABLES `hadpj_wflocs` WRITE;
/*!40000 ALTER TABLE `hadpj_wflocs` DISABLE KEYS */;
INSERT INTO `hadpj_wflocs` VALUES
('\0\0\0\0\0\0\0\0\0\0ˇˇ\0\0',1688175237,1,'','','','',0.0000000,0.0000000);
/*!40000 ALTER TABLE `hadpj_wflocs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wflogins`
--

DROP TABLE IF EXISTS `hadpj_wflogins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wflogins` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wflogins`
--

LOCK TABLES `hadpj_wflogins` WRITE;
/*!40000 ALTER TABLE `hadpj_wflogins` DISABLE KEYS */;
INSERT INTO `hadpj_wflogins` VALUES
(1,1,1688175236.976641,0,'loginOK','aparserok',2,'\0\0\0\0\0\0\0\0\0\0ˇˇ\0\0','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36 Edg/115.0.1901.151');
/*!40000 ALTER TABLE `hadpj_wflogins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfls_2fa_secrets`
--

DROP TABLE IF EXISTS `hadpj_wfls_2fa_secrets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfls_2fa_secrets` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfls_2fa_secrets`
--

LOCK TABLES `hadpj_wfls_2fa_secrets` WRITE;
/*!40000 ALTER TABLE `hadpj_wfls_2fa_secrets` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_wfls_2fa_secrets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfls_role_counts`
--

DROP TABLE IF EXISTS `hadpj_wfls_role_counts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfls_role_counts` (
  `serialized_roles` varbinary(255) NOT NULL,
  `two_factor_inactive` tinyint(1) NOT NULL,
  `user_count` bigint(20) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`serialized_roles`,`two_factor_inactive`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfls_role_counts`
--

LOCK TABLES `hadpj_wfls_role_counts` WRITE;
/*!40000 ALTER TABLE `hadpj_wfls_role_counts` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_wfls_role_counts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfls_settings`
--

DROP TABLE IF EXISTS `hadpj_wfls_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfls_settings` (
  `name` varchar(191) NOT NULL DEFAULT '',
  `value` longblob DEFAULT NULL,
  `autoload` enum('no','yes') NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfls_settings`
--

LOCK TABLES `hadpj_wfls_settings` WRITE;
/*!40000 ALTER TABLE `hadpj_wfls_settings` DISABLE KEYS */;
INSERT INTO `hadpj_wfls_settings` VALUES
('2fa-user-grace-period','10','yes'),
('allow-xml-rpc','1','yes'),
('captcha-stats','{\"counts\":[0,0,0,0,0,0,0,0,0,0,0],\"avg\":0}','yes'),
('delete-deactivation','','yes'),
('disable-temporary-tables','0','yes'),
('enable-auth-captcha','','yes'),
('enable-login-history-columns','1','yes'),
('enable-shortcode','','yes'),
('enable-woocommerce-account-integration','','yes'),
('enable-woocommerce-integration','','yes'),
('global-notices','[]','yes'),
('ip-source','','yes'),
('ip-trusted-proxies','','yes'),
('last-secret-refresh','1681886486','yes'),
('recaptcha-threshold','0.5','yes'),
('remember-device','','yes'),
('remember-device-duration','2592000','yes'),
('require-2fa-grace-period-enabled','','yes'),
('require-2fa.administrator','','yes'),
('schema-version','2','yes'),
('shared-hash-secret','595a09cfdcd576671fd28740468ef7eeb04a68a7f9e3e1465c69751cf446d411','yes'),
('shared-symmetric-secret','697dc9dba40d8d29362d5b95564c3f5d3f88157c4855fecea0cbbed73ca9c8d9','yes'),
('stack-ui-columns','1','yes'),
('user-count-query-state','','yes'),
('whitelisted','','yes'),
('xmlrpc-enabled','1','yes');
/*!40000 ALTER TABLE `hadpj_wfls_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfnotifications`
--

DROP TABLE IF EXISTS `hadpj_wfnotifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfnotifications` (
  `id` varchar(32) NOT NULL DEFAULT '',
  `new` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `category` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT 1000,
  `ctime` int(10) unsigned NOT NULL,
  `html` text NOT NULL,
  `links` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfnotifications`
--

LOCK TABLES `hadpj_wfnotifications` WRITE;
/*!40000 ALTER TABLE `hadpj_wfnotifications` DISABLE KEYS */;
INSERT INTO `hadpj_wfnotifications` VALUES
('site-AEAAAAA',0,'wfplugin_scan',502,1688175513,'<a href=\"https://wpeb.ddev.site/wp-admin/admin.php?page=WordfenceScan\">Scan aborted due to duration limit</a>','[]');
/*!40000 ALTER TABLE `hadpj_wfnotifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfpendingissues`
--

DROP TABLE IF EXISTS `hadpj_wfpendingissues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfpendingissues` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfpendingissues`
--

LOCK TABLES `hadpj_wfpendingissues` WRITE;
/*!40000 ALTER TABLE `hadpj_wfpendingissues` DISABLE KEYS */;
INSERT INTO `hadpj_wfpendingissues` VALUES
(1,1681890771,1681890771,'new','knownfile',50,'181447348de2f66f53c1a116c0aa1265','6df5d32dab8471256bb53ca3f3b5c843','Modified plugin file: wp-content/plugins/seo-image/seo-friendly-images.class.php','This file belongs to plugin \"SEO Friendly Images\" version \"3.0.5\" and has been modified from the file that is distributed by WordPress.org for this version. Please use the link to see how the file has changed. If you have modified this file yourself, you can safely ignore this warning. If you see a lot of changed files in a plugin that have been made by the author, then try uninstalling and reinstalling the plugin to force an upgrade. Doing this is a workaround for plugin authors who don\'t manage their code correctly. <a href=\"https://www.wordfence.com/help/?query=scan-result-modified-plugin\" target=\"_blank\" rel=\"noopener noreferrer\">Learn More<span class=\"screen-reader-text\"> (opens in new tab)</span></a>','a:10:{s:4:\"file\";s:58:\"wp-content/plugins/seo-image/seo-friendly-images.class.php\";s:8:\"realFile\";s:84:\"C:\\Works\\Web\\wp-framework\\wp-content\\plugins\\seo-image\\seo-friendly-images.class.php\";s:5:\"cType\";s:6:\"plugin\";s:7:\"canDiff\";b:1;s:6:\"canFix\";b:1;s:9:\"canDelete\";b:0;s:5:\"cName\";s:19:\"SEO Friendly Images\";s:8:\"cVersion\";s:5:\"3.0.5\";s:4:\"cKey\";s:33:\"seo-image/seo-friendly-images.php\";s:10:\"haveIssues\";s:7:\"plugins\";}');
/*!40000 ALTER TABLE `hadpj_wfpendingissues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfreversecache`
--

DROP TABLE IF EXISTS `hadpj_wfreversecache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfreversecache` (
  `IP` binary(16) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `host` varchar(255) NOT NULL,
  `lastUpdate` int(10) unsigned NOT NULL,
  PRIMARY KEY (`IP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfreversecache`
--

LOCK TABLES `hadpj_wfreversecache` WRITE;
/*!40000 ALTER TABLE `hadpj_wfreversecache` DISABLE KEYS */;
INSERT INTO `hadpj_wfreversecache` VALUES
('\0\0\0\0\0\0\0\0\0\0ˇˇ\0\0','minimog.local',1688175237);
/*!40000 ALTER TABLE `hadpj_wfreversecache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfsnipcache`
--

DROP TABLE IF EXISTS `hadpj_wfsnipcache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfsnipcache` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfsnipcache`
--

LOCK TABLES `hadpj_wfsnipcache` WRITE;
/*!40000 ALTER TABLE `hadpj_wfsnipcache` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_wfsnipcache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfstatus`
--

DROP TABLE IF EXISTS `hadpj_wfstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfstatus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ctime` double(17,6) unsigned NOT NULL,
  `level` tinyint(3) unsigned NOT NULL,
  `type` char(5) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `k1` (`ctime`),
  KEY `k2` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=788 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfstatus`
--

LOCK TABLES `hadpj_wfstatus` WRITE;
/*!40000 ALTER TABLE `hadpj_wfstatus` DISABLE KEYS */;
INSERT INTO `hadpj_wfstatus` VALUES
(1,1681887355.390894,1,'info','Using low resource scanning'),
(2,1681887355.422363,10,'info','SUM_PREP:Preparing a new scan.'),
(3,1681887355.495515,1,'info','Contacting Wordfence to initiate scan'),
(4,1681887356.356661,10,'info','SUM_PAIDONLY:Check if your site is being Spamvertized is for paid members only'),
(5,1681887358.431831,10,'info','SUM_PAIDONLY:Checking if your IP is generating spam is for paid members only'),
(6,1681887360.889857,10,'info','SUM_PAIDONLY:Checking if your site is on a domain blocklist is for paid members only'),
(7,1681887363.039263,10,'info','SUM_START:Checking for the most secure way to get IPs'),
(8,1681887363.087514,10,'info','SUM_ENDSKIPPED:Checking for the most secure way to get IPs'),
(9,1681887363.148148,10,'info','SUM_START:Scanning to check available disk space'),
(10,1681887363.179760,2,'info','Total disk space: 467.49 GB -- Free disk space: 76.74 GB'),
(11,1681887363.195788,2,'info','The disk has 78581.7 MB available'),
(12,1681887363.211060,10,'info','SUM_ENDOK:Scanning to check available disk space'),
(13,1681887363.274038,10,'info','SUM_START:Checking Web Application Firewall status'),
(14,1681887363.304690,10,'info','SUM_ENDOK:Checking Web Application Firewall status'),
(15,1681887363.367634,10,'info','SUM_START:Checking for future GeoIP support'),
(16,1681887363.399111,10,'info','SUM_ENDOK:Checking for future GeoIP support'),
(17,1681887363.461214,10,'info','SUM_START:Checking for paths skipped due to scan settings'),
(18,1681887363.493864,10,'info','SUM_ENDOK:Checking for paths skipped due to scan settings'),
(19,1681887363.540647,2,'info','Including files that are outside the WordPress installation in the scan.'),
(20,1681887363.554750,2,'info','Getting plugin list from WordPress'),
(21,1681887363.708255,2,'info','Found 65 plugins'),
(22,1681887363.724064,2,'info','Getting theme list from WordPress'),
(23,1681887363.748028,2,'info','Found 5 themes'),
(24,1681887364.303381,10,'info','SUM_START:Fetching core, theme and plugin file signatures from Wordfence'),
(25,1681887369.571018,10,'info','SUM_ENDSUCCESS:Fetching core, theme and plugin file signatures from Wordfence'),
(26,1681887369.640778,10,'info','SUM_START:Fetching list of known malware files from Wordfence'),
(27,1681887371.405846,10,'info','SUM_ENDSUCCESS:Fetching list of known malware files from Wordfence'),
(28,1681887371.495092,10,'info','SUM_START:Fetching list of known core files from Wordfence'),
(29,1681887373.300077,10,'info','SUM_ENDSUCCESS:Fetching list of known core files from Wordfence'),
(30,1681887373.363017,10,'info','SUM_START:Comparing core WordPress files against originals in repository'),
(31,1681887373.409748,10,'info','SUM_START:Comparing open source themes against WordPress.org originals'),
(32,1681887373.456583,10,'info','SUM_START:Comparing plugins against WordPress.org originals'),
(33,1681887373.503475,10,'info','SUM_START:Scanning for known malware files'),
(34,1681887373.550224,10,'info','SUM_START:Scanning for unknown files in wp-admin and wp-includes'),
(35,1681887373.982315,2,'info','500 files indexed'),
(36,1681887374.416120,2,'info','1000 files indexed'),
(37,1681887374.877112,2,'info','1500 files indexed'),
(38,1681887375.377281,2,'info','2000 files indexed'),
(39,1681887376.043231,2,'info','2500 files indexed'),
(40,1681887376.371742,2,'info','3000 files indexed'),
(41,1681887376.588596,2,'info','3500 files indexed'),
(42,1681887376.839616,2,'info','4000 files indexed'),
(43,1681887377.078518,2,'info','4500 files indexed'),
(44,1681887377.404356,2,'info','5000 files indexed'),
(45,1681887377.666280,2,'info','5500 files indexed'),
(46,1681887377.987815,2,'info','6000 files indexed'),
(47,1681887378.266117,2,'info','6500 files indexed'),
(48,1681887378.562908,2,'info','7000 files indexed'),
(49,1681887378.856454,2,'info','7500 files indexed'),
(50,1681887379.093861,2,'info','8000 files indexed'),
(51,1681887379.519068,2,'info','8500 files indexed'),
(52,1681887380.168129,2,'info','9000 files indexed'),
(53,1681887380.669136,2,'info','9500 files indexed'),
(54,1681887381.116555,2,'info','10000 files indexed'),
(55,1681887381.729891,2,'info','10500 files indexed'),
(56,1681887382.454608,2,'info','11000 files indexed'),
(57,1681887383.103657,2,'info','11500 files indexed'),
(58,1681887383.522106,2,'info','12000 files indexed'),
(59,1681887384.339579,2,'info','12500 files indexed'),
(60,1681887385.021767,2,'info','13000 files indexed'),
(61,1681887385.725213,2,'info','13500 files indexed'),
(62,1681887386.068712,2,'info','14000 files indexed'),
(63,1681887386.506071,2,'info','14500 files indexed'),
(64,1681887387.041972,2,'info','15000 files indexed'),
(65,1681887387.577788,2,'info','15500 files indexed'),
(66,1681887388.296788,2,'info','16000 files indexed'),
(67,1681887388.832583,2,'info','16500 files indexed'),
(68,1681887389.545405,2,'info','17000 files indexed'),
(69,1681887390.320320,2,'info','17500 files indexed'),
(70,1681887391.002438,2,'info','18000 files indexed'),
(71,1681887391.528954,2,'info','18500 files indexed'),
(72,1681887392.248477,2,'info','19000 files indexed'),
(73,1681887392.862616,2,'info','19500 files indexed'),
(74,1681887393.663856,2,'info','20000 files indexed'),
(75,1681887394.520382,2,'info','20500 files indexed'),
(76,1681887395.542749,2,'info','21000 files indexed'),
(77,1681887396.278584,2,'info','21500 files indexed'),
(78,1681887396.969296,2,'info','22000 files indexed'),
(79,1681887397.777328,2,'info','22500 files indexed'),
(80,1681887398.404276,2,'info','23000 files indexed'),
(81,1681887398.919687,2,'info','23500 files indexed'),
(82,1681887399.601907,2,'info','24000 files indexed'),
(83,1681887400.420051,2,'info','24500 files indexed'),
(84,1681887401.001163,2,'info','25000 files indexed'),
(85,1681887401.559175,2,'info','25500 files indexed'),
(86,1681887402.028619,2,'info','25847 files indexed'),
(87,1681887404.300892,2,'info','26347 files indexed'),
(88,1681887404.637705,2,'info','26847 files indexed'),
(89,1681887405.018805,2,'info','27347 files indexed'),
(90,1681887405.413435,2,'info','27847 files indexed'),
(91,1681887405.685775,2,'info','28347 files indexed'),
(92,1681887406.024959,2,'info','28847 files indexed'),
(93,1681887406.330396,2,'info','29347 files indexed'),
(94,1681887406.696190,2,'info','29847 files indexed'),
(95,1681887407.000689,2,'info','30347 files indexed'),
(96,1681887407.260102,2,'info','30847 files indexed'),
(97,1681887407.530610,2,'info','31347 files indexed'),
(98,1681887407.846306,2,'info','31847 files indexed'),
(99,1681887408.161079,2,'info','32347 files indexed'),
(100,1681887408.453635,2,'info','32847 files indexed'),
(101,1681887408.856756,2,'info','33347 files indexed'),
(102,1681887409.233616,2,'info','33847 files indexed'),
(103,1681887409.628306,2,'info','34347 files indexed'),
(104,1681887409.933786,2,'info','34847 files indexed'),
(105,1681887410.505286,2,'info','35347 files indexed'),
(106,1681887410.906843,2,'info','35847 files indexed'),
(107,1681887411.257118,2,'info','36347 files indexed'),
(108,1681887411.893497,2,'info','36847 files indexed'),
(109,1681887412.575655,2,'info','37347 files indexed'),
(110,1681887413.177906,2,'info','37847 files indexed'),
(111,1681887413.780991,2,'info','38347 files indexed'),
(112,1681887414.389159,2,'info','38847 files indexed'),
(113,1681887414.905500,2,'info','39347 files indexed'),
(114,1681887415.591938,2,'info','39847 files indexed'),
(115,1681887416.284310,2,'info','40347 files indexed'),
(116,1681887416.882152,2,'info','40847 files indexed'),
(117,1681887417.452251,2,'info','41347 files indexed'),
(118,1681887418.010221,2,'info','41847 files indexed'),
(119,1681887418.391200,2,'info','42347 files indexed'),
(120,1681887418.783528,2,'info','42847 files indexed'),
(121,1681887419.309084,2,'info','43347 files indexed'),
(122,1681887420.119744,2,'info','43847 files indexed'),
(123,1681887420.867352,2,'info','44347 files indexed'),
(124,1681887421.492575,2,'info','44847 files indexed'),
(125,1681887422.090605,2,'info','45347 files indexed'),
(126,1681887422.650194,2,'info','45847 files indexed'),
(127,1681887423.226053,2,'info','46347 files indexed'),
(128,1681887423.641922,2,'info','46847 files indexed'),
(129,1681887424.262050,2,'info','47347 files indexed'),
(130,1681887424.754658,2,'info','47847 files indexed'),
(131,1681887425.224160,2,'info','48347 files indexed'),
(132,1681887425.726744,2,'info','48847 files indexed'),
(133,1681887426.197221,2,'info','49347 files indexed'),
(134,1681887426.943295,2,'info','49847 files indexed'),
(135,1681887427.382081,2,'info','50347 files indexed'),
(136,1681887427.852545,2,'info','50847 files indexed'),
(137,1681887428.361172,2,'info','51347 files indexed'),
(138,1681887428.899630,2,'info','51847 files indexed'),
(139,1681887429.415072,2,'info','52347 files indexed'),
(140,1681887430.362659,2,'info','52847 files indexed'),
(141,1681887431.060207,2,'info','53347 files indexed'),
(142,1681887431.662396,2,'info','53847 files indexed'),
(143,1681887432.319892,2,'info','54347 files indexed'),
(144,1681887432.845697,2,'info','54847 files indexed'),
(145,1681887433.491995,2,'info','55347 files indexed'),
(146,1681887434.083198,2,'info','55847 files indexed'),
(147,1681887434.465231,2,'info','56347 files indexed'),
(148,1681887434.813110,2,'info','56847 files indexed'),
(149,1681887435.112508,2,'info','57347 files indexed'),
(150,1681887435.428875,2,'info','57847 files indexed'),
(151,1681887435.889979,2,'info','58347 files indexed'),
(152,1681887436.106851,2,'info','58634 files indexed'),
(153,1681887445.245965,2,'info','Analyzed 100 files containing 2.03 MB of data so far'),
(154,1681887483.101276,2,'info','Analyzed 200 files containing 5.27 MB of data so far'),
(155,1681887493.333681,2,'info','Analyzed 300 files containing 7.65 MB of data so far'),
(156,1681887503.416403,2,'info','Analyzed 400 files containing 8.81 MB of data so far'),
(157,1681887511.984098,2,'info','Analyzed 500 files containing 9.89 MB of data so far'),
(158,1681887520.947483,2,'info','Analyzed 600 files containing 10.32 MB of data so far'),
(159,1681887557.135938,2,'info','Analyzed 700 files containing 11.13 MB of data so far'),
(160,1681887567.904961,2,'info','Analyzed 800 files containing 12.44 MB of data so far'),
(161,1681887577.760901,2,'info','Analyzed 900 files containing 12.68 MB of data so far'),
(162,1681887586.508498,2,'info','Analyzed 1000 files containing 13.15 MB of data so far'),
(163,1681887622.163475,2,'info','Analyzed 1100 files containing 15.2 MB of data so far'),
(164,1681887632.504414,2,'info','Analyzed 1200 files containing 18.69 MB of data so far'),
(165,1681887643.078557,2,'info','Analyzed 1300 files containing 19.63 MB of data so far'),
(166,1681887653.870436,2,'info','Analyzed 1400 files containing 21.35 MB of data so far'),
(167,1681887663.572629,2,'info','Analyzed 1500 files containing 25.57 MB of data so far'),
(168,1681887699.462737,2,'info','Analyzed 1600 files containing 26.26 MB of data so far'),
(169,1681887709.419401,2,'info','Analyzed 1700 files containing 27.95 MB of data so far'),
(170,1681887719.641703,2,'info','Analyzed 1800 files containing 29.62 MB of data so far'),
(171,1681887730.293529,2,'info','Analyzed 1900 files containing 40.29 MB of data so far'),
(172,1681887766.834505,2,'info','Analyzed 2000 files containing 42.38 MB of data so far'),
(173,1681887776.048816,2,'info','Analyzed 2100 files containing 43.13 MB of data so far'),
(174,1681887785.001070,2,'info','Analyzed 2200 files containing 47.06 MB of data so far'),
(175,1681887795.019652,2,'info','Analyzed 2300 files containing 47.51 MB of data so far'),
(176,1681887806.230428,2,'info','Analyzed 2400 files containing 48.1 MB of data so far'),
(177,1681887842.153912,2,'info','Analyzed 2500 files containing 48.44 MB of data so far'),
(178,1681887851.334684,2,'info','Analyzed 2600 files containing 51.16 MB of data so far'),
(179,1681887859.787655,2,'info','Analyzed 2700 files containing 53.45 MB of data so far'),
(180,1681887869.021613,2,'info','Analyzed 2800 files containing 56.32 MB of data so far'),
(181,1681887906.090532,2,'info','Analyzed 2900 files containing 58.69 MB of data so far'),
(182,1681887916.566931,2,'info','Analyzed 3000 files containing 59.41 MB of data so far'),
(183,1681887927.376797,2,'info','Analyzed 3100 files containing 60.11 MB of data so far'),
(184,1681887937.217827,2,'info','Analyzed 3200 files containing 60.94 MB of data so far'),
(185,1681887945.403798,2,'info','Analyzed 3300 files containing 61.78 MB of data so far'),
(186,1681887981.754757,2,'info','Analyzed 3400 files containing 63.32 MB of data so far'),
(187,1681887991.792343,2,'info','Analyzed 3500 files containing 65.29 MB of data so far'),
(188,1681888082.079636,2,'info','Analyzed 3600 files containing 65.41 MB of data so far'),
(189,1681888405.892352,2,'info','Analyzed 3700 files containing 67.48 MB of data so far'),
(190,1681889121.647326,2,'info','Analyzed 3800 files containing 69.75 MB of data so far'),
(191,1681889347.657125,2,'info','Analyzed 3900 files containing 70.11 MB of data so far'),
(192,1681889430.681638,2,'info','Analyzed 4000 files containing 79.09 MB of data so far'),
(193,1681889469.998137,2,'info','Analyzed 4100 files containing 80.05 MB of data so far'),
(194,1681889578.795424,2,'info','Analyzed 4200 files containing 80.09 MB of data so far'),
(195,1681889617.753548,2,'info','Analyzed 4300 files containing 80.89 MB of data so far'),
(196,1681889635.883452,2,'info','Analyzed 4400 files containing 81.23 MB of data so far'),
(197,1681889688.893616,2,'info','Analyzed 4500 files containing 81.87 MB of data so far'),
(198,1681889698.889807,2,'info','Analyzed 4600 files containing 82.44 MB of data so far'),
(199,1681889708.097003,2,'info','Analyzed 4700 files containing 83 MB of data so far'),
(200,1681889716.399101,2,'info','Analyzed 4800 files containing 84.88 MB of data so far'),
(201,1681889725.322879,2,'info','Analyzed 4900 files containing 85.4 MB of data so far'),
(202,1681889762.050886,2,'info','Analyzed 5000 files containing 85.8 MB of data so far'),
(203,1681889771.946591,2,'info','Analyzed 5100 files containing 86.42 MB of data so far'),
(204,1681889782.261842,2,'info','Analyzed 5200 files containing 103.07 MB of data so far'),
(205,1681889791.501677,2,'info','Analyzed 5300 files containing 104.08 MB of data so far'),
(206,1681889827.305779,2,'info','Analyzed 5400 files containing 105.01 MB of data so far'),
(207,1681889837.382812,2,'info','Analyzed 5500 files containing 109.08 MB of data so far'),
(208,1681889847.754912,2,'info','Analyzed 5600 files containing 112.32 MB of data so far'),
(209,1681889858.058832,2,'info','Analyzed 5700 files containing 113.06 MB of data so far'),
(210,1681889867.832995,2,'info','Analyzed 5800 files containing 113.66 MB of data so far'),
(211,1681889903.616372,2,'info','Analyzed 5900 files containing 115.79 MB of data so far'),
(212,1681889913.835504,2,'info','Analyzed 6000 files containing 117.81 MB of data so far'),
(213,1681889923.789492,2,'info','Analyzed 6100 files containing 120.57 MB of data so far'),
(214,1681889934.547666,2,'info','Analyzed 6200 files containing 122.46 MB of data so far'),
(215,1681889967.615230,2,'info','Analyzed 6300 files containing 123.57 MB of data so far'),
(216,1681889977.186350,2,'info','Analyzed 6400 files containing 123.73 MB of data so far'),
(217,1681889987.182133,2,'info','Analyzed 6500 files containing 123.81 MB of data so far'),
(218,1681890060.034234,2,'info','Analyzed 6600 files containing 123.87 MB of data so far'),
(219,1681890069.506798,2,'info','Analyzed 6700 files containing 123.95 MB of data so far'),
(220,1681890078.189528,2,'info','Analyzed 6800 files containing 124.09 MB of data so far'),
(221,1681890087.104744,2,'info','Analyzed 6900 files containing 124.21 MB of data so far'),
(222,1681890097.250043,2,'info','Analyzed 7000 files containing 124.33 MB of data so far'),
(223,1681890133.075811,2,'info','Analyzed 7100 files containing 124.46 MB of data so far'),
(224,1681890143.344205,2,'info','Analyzed 7200 files containing 125.14 MB of data so far'),
(225,1681890151.996689,2,'info','Analyzed 7300 files containing 126.18 MB of data so far'),
(226,1681890160.971039,2,'info','Analyzed 7400 files containing 130.71 MB of data so far'),
(227,1681890197.607532,2,'info','Analyzed 7500 files containing 131.04 MB of data so far'),
(228,1681890208.133686,2,'info','Analyzed 7600 files containing 131.78 MB of data so far'),
(229,1681890218.172850,2,'info','Analyzed 7700 files containing 132.09 MB of data so far'),
(230,1681890226.863699,2,'info','Analyzed 7800 files containing 132.41 MB of data so far'),
(231,1681890235.771627,2,'info','Analyzed 7900 files containing 132.66 MB of data so far'),
(232,1681890273.213057,2,'info','Analyzed 8000 files containing 132.92 MB of data so far'),
(233,1681890283.168871,2,'info','Analyzed 8100 files containing 133.27 MB of data so far'),
(234,1681890293.369355,2,'info','Analyzed 8200 files containing 133.57 MB of data so far'),
(235,1681890301.897037,2,'info','Analyzed 8300 files containing 133.97 MB of data so far'),
(236,1681890310.307392,2,'info','Analyzed 8400 files containing 134.46 MB of data so far'),
(237,1681890346.218095,2,'info','Analyzed 8500 files containing 134.81 MB of data so far'),
(238,1681890356.250693,2,'info','Analyzed 8600 files containing 135.82 MB of data so far'),
(239,1681890366.682850,2,'info','Analyzed 8700 files containing 136.33 MB of data so far'),
(240,1681890375.607312,2,'info','Analyzed 8800 files containing 137.42 MB of data so far'),
(241,1681890384.018950,2,'info','Analyzed 8900 files containing 139.03 MB of data so far'),
(242,1681890418.695958,2,'info','Analyzed 9000 files containing 139.79 MB of data so far'),
(243,1681890429.143569,2,'info','Analyzed 9100 files containing 140.6 MB of data so far'),
(244,1681890439.462037,2,'info','Analyzed 9200 files containing 140.93 MB of data so far'),
(245,1681890449.444319,2,'info','Analyzed 9300 files containing 143.02 MB of data so far'),
(246,1681890484.823159,2,'info','Analyzed 9400 files containing 144.25 MB of data so far'),
(247,1681890494.221767,2,'info','Analyzed 9500 files containing 144.56 MB of data so far'),
(248,1681890504.486823,2,'info','Analyzed 9600 files containing 145.77 MB of data so far'),
(249,1681890514.927459,2,'info','Analyzed 9700 files containing 149.04 MB of data so far'),
(250,1681890524.764345,2,'info','Analyzed 9800 files containing 150.08 MB of data so far'),
(251,1681890559.047807,2,'info','Analyzed 9900 files containing 150.69 MB of data so far'),
(252,1681890567.756544,2,'info','Analyzed 10000 files containing 151.08 MB of data so far'),
(253,1681890577.457628,2,'info','Analyzed 10100 files containing 151.85 MB of data so far'),
(254,1681890587.374088,2,'info','Analyzed 10200 files containing 152.02 MB of data so far'),
(255,1681890597.308110,2,'info','Analyzed 10300 files containing 152.93 MB of data so far'),
(256,1681890633.185340,2,'info','Analyzed 10400 files containing 153.56 MB of data so far'),
(257,1681890643.217329,2,'info','Analyzed 10500 files containing 154.88 MB of data so far'),
(258,1681890653.118269,2,'info','Analyzed 10600 files containing 156.9 MB of data so far'),
(259,1681890662.047221,2,'info','Analyzed 10700 files containing 157.34 MB of data so far'),
(260,1681890670.272747,2,'info','Analyzed 10800 files containing 158.74 MB of data so far'),
(261,1681890705.439834,2,'info','Analyzed 10900 files containing 159.49 MB of data so far'),
(262,1681890715.738903,2,'info','Analyzed 11000 files containing 159.96 MB of data so far'),
(263,1681890725.804801,2,'info','Analyzed 11100 files containing 160.79 MB of data so far'),
(264,1681890735.286723,2,'info','Analyzed 11200 files containing 161.3 MB of data so far'),
(265,1681890771.117171,2,'info','Analyzed 11300 files containing 161.8 MB of data so far'),
(266,1681890781.259516,2,'info','Analyzed 11400 files containing 162.69 MB of data so far'),
(267,1681890791.111074,2,'info','Analyzed 11500 files containing 163.19 MB of data so far'),
(268,1681890801.617614,2,'info','Analyzed 11600 files containing 164.15 MB of data so far'),
(269,1681890811.533844,2,'info','Analyzed 11700 files containing 165.42 MB of data so far'),
(270,1681890846.413591,2,'info','Analyzed 11800 files containing 166.8 MB of data so far'),
(271,1681890856.797244,2,'info','Analyzed 11900 files containing 169.22 MB of data so far'),
(272,1681890866.965940,2,'info','Analyzed 12000 files containing 182.28 MB of data so far'),
(273,1681890877.158139,2,'info','Analyzed 12100 files containing 183.56 MB of data so far'),
(274,1681890913.861122,2,'info','Analyzed 12200 files containing 184.14 MB of data so far'),
(275,1681890922.657545,2,'info','Analyzed 12300 files containing 184.39 MB of data so far'),
(276,1681890931.294458,2,'info','Analyzed 12400 files containing 184.91 MB of data so far'),
(277,1681890941.586550,2,'info','Analyzed 12500 files containing 186.52 MB of data so far'),
(278,1681890951.664226,2,'info','Analyzed 12600 files containing 186.65 MB of data so far'),
(279,1681890986.833385,2,'info','Analyzed 12700 files containing 186.9 MB of data so far'),
(280,1681890995.506179,2,'info','Analyzed 12800 files containing 188.01 MB of data so far'),
(281,1681891004.596375,2,'info','Analyzed 12900 files containing 188.6 MB of data so far'),
(282,1681891014.561495,2,'info','Analyzed 13000 files containing 189.94 MB of data so far'),
(283,1681891024.593691,2,'info','Analyzed 13100 files containing 190.02 MB of data so far'),
(284,1681891059.739857,2,'info','Analyzed 13200 files containing 190.4 MB of data so far'),
(285,1681891068.645968,2,'info','Analyzed 13300 files containing 205.95 MB of data so far'),
(286,1681891077.231815,2,'info','Analyzed 13400 files containing 206.25 MB of data so far'),
(287,1681891087.295145,2,'info','Analyzed 13500 files containing 207.44 MB of data so far'),
(288,1681891097.110469,2,'info','Analyzed 13600 files containing 209.23 MB of data so far'),
(289,1681891133.157304,2,'info','Analyzed 13700 files containing 216.61 MB of data so far'),
(290,1681891141.829571,2,'info','Analyzed 13800 files containing 218.31 MB of data so far'),
(291,1681891150.008519,2,'info','Analyzed 13900 files containing 219.19 MB of data so far'),
(292,1681891158.611080,2,'info','Analyzed 14000 files containing 220.1 MB of data so far'),
(293,1681891168.474009,2,'info','Analyzed 14100 files containing 220.65 MB of data so far'),
(294,1681891204.268947,2,'info','Analyzed 14200 files containing 221.11 MB of data so far'),
(295,1681891214.106761,2,'info','Analyzed 14300 files containing 222.04 MB of data so far'),
(296,1681891221.809287,2,'info','Analyzed 14400 files containing 223.42 MB of data so far'),
(297,1681891228.989598,2,'info','Analyzed 14500 files containing 229.52 MB of data so far'),
(298,1681891235.883349,2,'info','Analyzed 14600 files containing 230.13 MB of data so far'),
(299,1681891268.505897,2,'info','Analyzed 14700 files containing 230.29 MB of data so far'),
(300,1681891278.610660,2,'info','Analyzed 14800 files containing 231.08 MB of data so far'),
(301,1681891288.755037,2,'info','Analyzed 14900 files containing 231.49 MB of data so far'),
(302,1681891297.927094,2,'info','Analyzed 15000 files containing 231.78 MB of data so far'),
(303,1681891306.158250,2,'info','Analyzed 15100 files containing 232.33 MB of data so far'),
(304,1681891340.726260,2,'info','Analyzed 15200 files containing 232.76 MB of data so far'),
(305,1681891350.918014,2,'info','Analyzed 15300 files containing 233.05 MB of data so far'),
(306,1681891361.208249,2,'info','Analyzed 15400 files containing 234.13 MB of data so far'),
(307,1681891369.882012,2,'info','Analyzed 15500 files containing 237.09 MB of data so far'),
(308,1681891378.409049,2,'info','Analyzed 15600 files containing 237.63 MB of data so far'),
(309,1681891413.269891,2,'info','Analyzed 15700 files containing 238.23 MB of data so far'),
(310,1681891423.104238,2,'info','Analyzed 15800 files containing 241.44 MB of data so far'),
(311,1681891432.994531,2,'info','Analyzed 15900 files containing 243.66 MB of data so far'),
(312,1681891443.496878,2,'info','Analyzed 16000 files containing 247.58 MB of data so far'),
(313,1681891452.676280,2,'info','Analyzed 16100 files containing 249.28 MB of data so far'),
(314,1681891487.368134,2,'info','Analyzed 16200 files containing 249.52 MB of data so far'),
(315,1681891497.784116,2,'info','Analyzed 16300 files containing 251.48 MB of data so far'),
(316,1681891507.713384,2,'info','Analyzed 16400 files containing 251.99 MB of data so far'),
(317,1681891517.439140,2,'info','Analyzed 16500 files containing 252.89 MB of data so far'),
(318,1681891553.097505,2,'info','Analyzed 16600 files containing 255.23 MB of data so far'),
(319,1681891561.451646,2,'info','Analyzed 16700 files containing 255.71 MB of data so far'),
(320,1681891570.486592,2,'info','Analyzed 16800 files containing 256.26 MB of data so far'),
(321,1681891580.730369,2,'info','Analyzed 16900 files containing 256.65 MB of data so far'),
(322,1681891590.784324,2,'info','Analyzed 17000 files containing 257.02 MB of data so far'),
(323,1681891626.197342,2,'info','Analyzed 17100 files containing 257.34 MB of data so far'),
(324,1681891634.425254,2,'info','Analyzed 17200 files containing 258.25 MB of data so far'),
(325,1681891643.585551,2,'info','Analyzed 17300 files containing 259.51 MB of data so far'),
(326,1681891653.643073,2,'info','Analyzed 17400 files containing 260.02 MB of data so far'),
(327,1681891663.450343,2,'info','Analyzed 17500 files containing 260.19 MB of data so far'),
(328,1681891697.964612,2,'info','Analyzed 17600 files containing 261.18 MB of data so far'),
(329,1681891706.580438,2,'info','Analyzed 17700 files containing 261.58 MB of data so far'),
(330,1681891715.447322,2,'info','Analyzed 17800 files containing 261.71 MB of data so far'),
(331,1681891725.105357,2,'info','Analyzed 17900 files containing 262.57 MB of data so far'),
(332,1681891735.081193,2,'info','Analyzed 18000 files containing 264.82 MB of data so far'),
(333,1681891771.591362,2,'info','Analyzed 18100 files containing 268.23 MB of data so far'),
(334,1681891782.076076,2,'info','Analyzed 18200 files containing 274.44 MB of data so far'),
(335,1681891792.251059,2,'info','Analyzed 18300 files containing 280.74 MB of data so far'),
(336,1681891801.840957,2,'info','Analyzed 18400 files containing 285.76 MB of data so far'),
(337,1681891810.228192,2,'info','Analyzed 18500 files containing 286.15 MB of data so far'),
(338,1681891846.372266,2,'info','Analyzed 18600 files containing 286.49 MB of data so far'),
(339,1681891856.495069,2,'info','Analyzed 18700 files containing 286.85 MB of data so far'),
(340,1681891866.635818,2,'info','Analyzed 18800 files containing 289.82 MB of data so far'),
(341,1681891876.717029,2,'info','Analyzed 18900 files containing 290.03 MB of data so far'),
(342,1681891912.603654,2,'info','Analyzed 19000 files containing 378.96 MB of data so far'),
(343,1681891921.154502,2,'info','Analyzed 19100 files containing 379.17 MB of data so far'),
(344,1681891930.359648,2,'info','Analyzed 19200 files containing 379.22 MB of data so far'),
(345,1681891940.913705,2,'info','Analyzed 19300 files containing 380.21 MB of data so far'),
(346,1681891951.137951,2,'info','Analyzed 19400 files containing 380.71 MB of data so far'),
(347,1681891986.858586,2,'info','Analyzed 19500 files containing 381.68 MB of data so far'),
(348,1681891996.269138,2,'info','Analyzed 19600 files containing 382.32 MB of data so far'),
(349,1681892004.935020,2,'info','Analyzed 19700 files containing 382.93 MB of data so far'),
(350,1681892013.485803,2,'info','Analyzed 19800 files containing 384.96 MB of data so far'),
(351,1681892022.335502,2,'info','Analyzed 19900 files containing 385.27 MB of data so far'),
(352,1681892058.820749,2,'info','Analyzed 20000 files containing 385.54 MB of data so far'),
(353,1681892068.963823,2,'info','Analyzed 20100 files containing 387.56 MB of data so far'),
(354,1681892078.699567,2,'info','Analyzed 20200 files containing 387.57 MB of data so far'),
(355,1681892087.362634,2,'info','Analyzed 20300 files containing 387.59 MB of data so far'),
(356,1681892095.779705,2,'info','Analyzed 20400 files containing 387.6 MB of data so far'),
(357,1681892131.529310,2,'info','Analyzed 20500 files containing 387.63 MB of data so far'),
(358,1681892141.504917,2,'info','Analyzed 20600 files containing 387.65 MB of data so far'),
(359,1681892151.285910,2,'info','Analyzed 20700 files containing 387.66 MB of data so far'),
(360,1681892159.840996,2,'info','Analyzed 20800 files containing 387.7 MB of data so far'),
(361,1681892194.314143,2,'info','Analyzed 20900 files containing 387.78 MB of data so far'),
(362,1681892204.211011,2,'info','Analyzed 21000 files containing 387.82 MB of data so far'),
(363,1681892214.124140,2,'info','Analyzed 21100 files containing 387.87 MB of data so far'),
(364,1681892224.086271,2,'info','Analyzed 21200 files containing 387.94 MB of data so far'),
(365,1681892232.768924,2,'info','Analyzed 21300 files containing 388.01 MB of data so far'),
(366,1681892268.011646,2,'info','Analyzed 21400 files containing 388.07 MB of data so far'),
(367,1681892277.986100,2,'info','Analyzed 21500 files containing 388.12 MB of data so far'),
(368,1681892287.990469,2,'info','Analyzed 21600 files containing 388.33 MB of data so far'),
(369,1681892298.999607,2,'info','Analyzed 21700 files containing 388.42 MB of data so far'),
(370,1681892308.796507,2,'info','Analyzed 21800 files containing 388.57 MB of data so far'),
(371,1681892341.862380,2,'info','Analyzed 21900 files containing 389.7 MB of data so far'),
(372,1681892348.904771,2,'info','Analyzed 22000 files containing 391.43 MB of data so far'),
(373,1681892355.679707,2,'info','Analyzed 22100 files containing 391.6 MB of data so far'),
(374,1681892362.706096,2,'info','Analyzed 22200 files containing 391.82 MB of data so far'),
(375,1681892369.960514,2,'info','Analyzed 22300 files containing 393.72 MB of data so far'),
(376,1681892377.703312,2,'info','Analyzed 22400 files containing 394.4 MB of data so far'),
(377,1681892411.337519,2,'info','Analyzed 22500 files containing 394.9 MB of data so far'),
(378,1681892421.647440,2,'info','Analyzed 22600 files containing 399.42 MB of data so far'),
(379,1681892431.886197,2,'info','Analyzed 22700 files containing 401.53 MB of data so far'),
(380,1681892441.733581,2,'info','Analyzed 22800 files containing 403.64 MB of data so far'),
(381,1681892451.751259,2,'info','Analyzed 22900 files containing 404.55 MB of data so far'),
(382,1681892487.114374,2,'info','Analyzed 23000 files containing 404.76 MB of data so far'),
(383,1681892495.422261,2,'info','Analyzed 23100 files containing 405.07 MB of data so far'),
(384,1681892503.670574,2,'info','Analyzed 23200 files containing 405.5 MB of data so far'),
(385,1681892513.521333,2,'info','Analyzed 23300 files containing 405.69 MB of data so far'),
(386,1681892523.878921,2,'info','Analyzed 23400 files containing 405.92 MB of data so far'),
(387,1681892559.612337,2,'info','Analyzed 23500 files containing 406.59 MB of data so far'),
(388,1681892569.508887,2,'info','Analyzed 23600 files containing 406.79 MB of data so far'),
(389,1681892578.072061,2,'info','Analyzed 23700 files containing 406.99 MB of data so far'),
(390,1681892586.800142,2,'info','Analyzed 23800 files containing 407.26 MB of data so far'),
(391,1681892595.661521,2,'info','Analyzed 23900 files containing 407.66 MB of data so far'),
(392,1681892631.602142,2,'info','Analyzed 24000 files containing 408.11 MB of data so far'),
(393,1681892641.919827,2,'info','Analyzed 24100 files containing 409.36 MB of data so far'),
(394,1681892651.560993,2,'info','Analyzed 24200 files containing 410.66 MB of data so far'),
(395,1681892659.030605,2,'info','Analyzed 24300 files containing 410.81 MB of data so far'),
(396,1681892666.060416,2,'info','Analyzed 24400 files containing 411.22 MB of data so far'),
(397,1681892702.861795,2,'info','Analyzed 24500 files containing 411.39 MB of data so far'),
(398,1681892712.923185,2,'info','Analyzed 24600 files containing 411.53 MB of data so far'),
(399,1681892723.429406,2,'info','Analyzed 24700 files containing 411.66 MB of data so far'),
(400,1681892734.139572,2,'info','Analyzed 24800 files containing 411.8 MB of data so far'),
(401,1681892768.177981,2,'info','Analyzed 24900 files containing 411.94 MB of data so far'),
(402,1681892778.390380,2,'info','Analyzed 25000 files containing 412.12 MB of data so far'),
(403,1681892789.092678,2,'info','Analyzed 25100 files containing 412.53 MB of data so far'),
(404,1681892799.420062,2,'info','Analyzed 25200 files containing 412.93 MB of data so far'),
(405,1681892809.776315,2,'info','Analyzed 25300 files containing 413.44 MB of data so far'),
(406,1681892844.588535,2,'info','Analyzed 25400 files containing 413.73 MB of data so far'),
(407,1681892853.408353,2,'info','Analyzed 25500 files containing 413.98 MB of data so far'),
(408,1681892862.392650,2,'info','Analyzed 25600 files containing 414.32 MB of data so far'),
(409,1681892872.765659,2,'info','Analyzed 25700 files containing 414.63 MB of data so far'),
(410,1681892908.610820,2,'info','Analyzed 25800 files containing 414.68 MB of data so far'),
(411,1681892918.994813,2,'info','Analyzed 25900 files containing 414.69 MB of data so far'),
(412,1681892928.529387,2,'info','Analyzed 26000 files containing 414.7 MB of data so far'),
(413,1681892937.496953,2,'info','Analyzed 26100 files containing 414.71 MB of data so far'),
(414,1681892946.080785,2,'info','Analyzed 26200 files containing 414.73 MB of data so far'),
(415,1681892979.757278,2,'info','Analyzed 26300 files containing 414.76 MB of data so far'),
(416,1681892989.623551,2,'info','Analyzed 26400 files containing 414.78 MB of data so far'),
(417,1681892999.776876,2,'info','Analyzed 26500 files containing 414.8 MB of data so far'),
(418,1681893017.851216,2,'info','Analyzed 26600 files containing 414.81 MB of data so far'),
(419,1681893055.602863,2,'info','Analyzed 26700 files containing 414.82 MB of data so far'),
(420,1681893064.709110,2,'info','Analyzed 26800 files containing 414.82 MB of data so far'),
(421,1681893073.241077,2,'info','Analyzed 26900 files containing 414.83 MB of data so far'),
(422,1681893081.875922,2,'info','Analyzed 27000 files containing 414.83 MB of data so far'),
(423,1681893091.829404,2,'info','Analyzed 27100 files containing 414.84 MB of data so far'),
(424,1681893127.488016,2,'info','Analyzed 27200 files containing 414.85 MB of data so far'),
(425,1681893138.014553,2,'info','Analyzed 27300 files containing 414.86 MB of data so far'),
(426,1681893147.881854,2,'info','Analyzed 27400 files containing 414.89 MB of data so far'),
(427,1681893156.463998,2,'info','Analyzed 27500 files containing 414.9 MB of data so far'),
(428,1681893165.447440,2,'info','Analyzed 27600 files containing 414.92 MB of data so far'),
(429,1681893201.112866,2,'info','Analyzed 27700 files containing 414.93 MB of data so far'),
(430,1681893211.168078,2,'info','Analyzed 27800 files containing 415.02 MB of data so far'),
(431,1681893221.536475,2,'info','Analyzed 27900 files containing 415.09 MB of data so far'),
(432,1681893232.026360,2,'info','Analyzed 28000 files containing 415.18 MB of data so far'),
(433,1681893266.492090,2,'info','Analyzed 28100 files containing 415.25 MB of data so far'),
(434,1681893275.736589,2,'info','Analyzed 28200 files containing 415.36 MB of data so far'),
(435,1681893286.035446,2,'info','Analyzed 28300 files containing 415.44 MB of data so far'),
(436,1681893296.075217,2,'info','Analyzed 28400 files containing 415.51 MB of data so far'),
(437,1681893306.157985,2,'info','Analyzed 28500 files containing 415.63 MB of data so far'),
(438,1681893342.161813,2,'info','Analyzed 28600 files containing 415.65 MB of data so far'),
(439,1681893351.002063,2,'info','Analyzed 28700 files containing 415.67 MB of data so far'),
(440,1681893359.589648,2,'info','Analyzed 28800 files containing 415.67 MB of data so far'),
(441,1681893369.499272,2,'info','Analyzed 28900 files containing 415.68 MB of data so far'),
(442,1681893380.006714,2,'info','Analyzed 29000 files containing 416.37 MB of data so far'),
(443,1681893416.495983,2,'info','Analyzed 29100 files containing 416.72 MB of data so far'),
(444,1681893426.195701,2,'info','Analyzed 29200 files containing 417.12 MB of data so far'),
(445,1681893434.647302,2,'info','Analyzed 29300 files containing 418.01 MB of data so far'),
(446,1681893443.467319,2,'info','Analyzed 29400 files containing 418.66 MB of data so far'),
(447,1681893453.763628,2,'info','Analyzed 29500 files containing 419.67 MB of data so far'),
(448,1681893489.334172,2,'info','Analyzed 29600 files containing 420.17 MB of data so far'),
(449,1681893499.553237,2,'info','Analyzed 29700 files containing 420.37 MB of data so far'),
(450,1681893509.560529,2,'info','Analyzed 29800 files containing 420.9 MB of data so far'),
(451,1681893519.624293,2,'info','Analyzed 29900 files containing 421.15 MB of data so far'),
(452,1681893554.112543,2,'info','Analyzed 30000 files containing 421.71 MB of data so far'),
(453,1681893564.442951,2,'info','Analyzed 30100 files containing 421.97 MB of data so far'),
(454,1681893574.852554,2,'info','Analyzed 30200 files containing 422.52 MB of data so far'),
(455,1681893582.251032,2,'info','Analyzed 30300 files containing 422.59 MB of data so far'),
(456,1681893589.167099,2,'info','Analyzed 30400 files containing 422.67 MB of data so far'),
(457,1681893622.765094,2,'info','Analyzed 30500 files containing 422.74 MB of data so far'),
(458,1681893632.633917,2,'info','Analyzed 30600 files containing 422.82 MB of data so far'),
(459,1681893642.643977,2,'info','Analyzed 30700 files containing 422.91 MB of data so far'),
(460,1681893653.227149,2,'info','Analyzed 30800 files containing 422.99 MB of data so far'),
(461,1681893663.416357,2,'info','Analyzed 30900 files containing 423.07 MB of data so far'),
(462,1681893697.571474,2,'info','Analyzed 31000 files containing 423.14 MB of data so far'),
(463,1681893706.614611,2,'info','Analyzed 31100 files containing 423.23 MB of data so far'),
(464,1681893715.487934,2,'info','Analyzed 31200 files containing 423.31 MB of data so far'),
(465,1681893725.687169,2,'info','Analyzed 31300 files containing 423.39 MB of data so far'),
(466,1681893735.646673,2,'info','Analyzed 31400 files containing 423.48 MB of data so far'),
(467,1681893772.734468,2,'info','Analyzed 31500 files containing 423.56 MB of data so far'),
(468,1681893782.673179,2,'info','Analyzed 31600 files containing 423.62 MB of data so far'),
(469,1681893791.131084,2,'info','Analyzed 31700 files containing 424.04 MB of data so far'),
(470,1681893799.722207,2,'info','Analyzed 31800 files containing 424.15 MB of data so far'),
(471,1681893808.514810,2,'info','Analyzed 31900 files containing 424.18 MB of data so far'),
(472,1681893844.251339,2,'info','Analyzed 32000 files containing 424.2 MB of data so far'),
(473,1681893854.118546,2,'info','Analyzed 32100 files containing 424.24 MB of data so far'),
(474,1681893864.173280,2,'info','Analyzed 32200 files containing 424.47 MB of data so far'),
(475,1681893873.645937,2,'info','Analyzed 32300 files containing 425.2 MB of data so far'),
(476,1681893908.958786,2,'info','Analyzed 32400 files containing 425.92 MB of data so far'),
(477,1681893920.286297,2,'info','Analyzed 32500 files containing 426.4 MB of data so far'),
(478,1681893930.915215,2,'info','Analyzed 32600 files containing 427.16 MB of data so far'),
(479,1681893941.848426,2,'info','Analyzed 32700 files containing 427.86 MB of data so far'),
(480,1681893952.458738,2,'info','Analyzed 32800 files containing 429.39 MB of data so far'),
(481,1681893986.581362,2,'info','Analyzed 32900 files containing 429.6 MB of data so far'),
(482,1681893995.644111,2,'info','Analyzed 33000 files containing 429.75 MB of data so far'),
(483,1681894005.495388,2,'info','Analyzed 33100 files containing 429.8 MB of data so far'),
(484,1681894016.263554,2,'info','Analyzed 33200 files containing 430.22 MB of data so far'),
(485,1681894052.842936,2,'info','Analyzed 33300 files containing 430.39 MB of data so far'),
(486,1681894061.271577,2,'info','Analyzed 33400 files containing 430.74 MB of data so far'),
(487,1681894069.716018,2,'info','Analyzed 33500 files containing 431.01 MB of data so far'),
(488,1681894078.772306,2,'info','Analyzed 33600 files containing 431.35 MB of data so far'),
(489,1681894088.941487,2,'info','Analyzed 33700 files containing 431.53 MB of data so far'),
(490,1681894125.057814,2,'info','Analyzed 33800 files containing 431.72 MB of data so far'),
(491,1681894135.029930,2,'info','Analyzed 33900 files containing 432.98 MB of data so far'),
(492,1681894142.653681,2,'info','Analyzed 34000 files containing 433.35 MB of data so far'),
(493,1681894149.662964,2,'info','Analyzed 34100 files containing 433.83 MB of data so far'),
(494,1681894156.990805,2,'info','Analyzed 34200 files containing 434 MB of data so far'),
(495,1681894163.976289,2,'info','Analyzed 34300 files containing 434.36 MB of data so far'),
(496,1681894198.711207,2,'info','Analyzed 34400 files containing 436.33 MB of data so far'),
(497,1681894209.049145,2,'info','Analyzed 34500 files containing 437.15 MB of data so far'),
(498,1681894219.158072,2,'info','Analyzed 34600 files containing 437.6 MB of data so far'),
(499,1681894229.169739,2,'info','Analyzed 34700 files containing 438.18 MB of data so far'),
(500,1681894238.199322,2,'info','Analyzed 34800 files containing 438.96 MB of data so far'),
(501,1681894274.105118,2,'info','Analyzed 34900 files containing 439.49 MB of data so far'),
(502,1681894284.224290,2,'info','Analyzed 35000 files containing 440.88 MB of data so far'),
(503,1681894294.260801,2,'info','Analyzed 35100 files containing 441.14 MB of data so far'),
(504,1681894304.444966,2,'info','Analyzed 35200 files containing 441.47 MB of data so far'),
(505,1681894339.115836,2,'info','Analyzed 35300 files containing 441.77 MB of data so far'),
(506,1681894348.360155,2,'info','Analyzed 35400 files containing 442.01 MB of data so far'),
(507,1681894358.777300,2,'info','Analyzed 35500 files containing 443.53 MB of data so far'),
(508,1681894368.707219,2,'info','Analyzed 35600 files containing 443.77 MB of data so far'),
(509,1681894378.778210,2,'info','Analyzed 35700 files containing 443.86 MB of data so far'),
(510,1681894414.096668,2,'info','Analyzed 35800 files containing 443.97 MB of data so far'),
(511,1681894425.972099,2,'info','Analyzed 35900 files containing 444.54 MB of data so far'),
(512,1681894435.107236,2,'info','Analyzed 36000 files containing 445 MB of data so far'),
(513,1681894445.340064,2,'info','Analyzed 36100 files containing 446.01 MB of data so far'),
(514,1681894481.959979,2,'info','Analyzed 36200 files containing 446.16 MB of data so far'),
(515,1681894490.912349,2,'info','Analyzed 36300 files containing 447.12 MB of data so far'),
(516,1681894499.957700,2,'info','Analyzed 36400 files containing 447.85 MB of data so far'),
(517,1681894508.618810,2,'info','Analyzed 36500 files containing 448.06 MB of data so far'),
(518,1681894518.593774,2,'info','Analyzed 36600 files containing 448.24 MB of data so far'),
(519,1681894555.417763,2,'info','Analyzed 36700 files containing 448.37 MB of data so far'),
(520,1681894565.058251,2,'info','Analyzed 36800 files containing 448.49 MB of data so far'),
(521,1681894573.885973,2,'info','Analyzed 36900 files containing 448.62 MB of data so far'),
(522,1681894582.843739,2,'info','Analyzed 37000 files containing 448.74 MB of data so far'),
(523,1681894593.486667,2,'info','Analyzed 37100 files containing 448.97 MB of data so far'),
(524,1681894628.981872,2,'info','Analyzed 37200 files containing 449.12 MB of data so far'),
(525,1681894638.935326,2,'info','Analyzed 37300 files containing 449.28 MB of data so far'),
(526,1681894647.772715,2,'info','Analyzed 37400 files containing 449.36 MB of data so far'),
(527,1681894656.801472,2,'info','Analyzed 37500 files containing 449.43 MB of data so far'),
(528,1681894693.376663,2,'info','Analyzed 37600 files containing 449.44 MB of data so far'),
(529,1681894703.944243,2,'info','Analyzed 37700 files containing 449.45 MB of data so far'),
(530,1681894714.061059,2,'info','Analyzed 37800 files containing 449.46 MB of data so far'),
(531,1681894722.863175,2,'info','Analyzed 37900 files containing 451.11 MB of data so far'),
(532,1681894732.092615,2,'info','Analyzed 38000 files containing 451.32 MB of data so far'),
(533,1681894767.235645,2,'info','Analyzed 38100 files containing 451.49 MB of data so far'),
(534,1681894777.754659,2,'info','Analyzed 38200 files containing 451.64 MB of data so far'),
(535,1681894788.278028,2,'info','Analyzed 38300 files containing 451.83 MB of data so far'),
(536,1681894797.712480,2,'info','Analyzed 38400 files containing 451.94 MB of data so far'),
(537,1681894806.226727,2,'info','Analyzed 38500 files containing 451.99 MB of data so far'),
(538,1681894841.683273,2,'info','Analyzed 38600 files containing 452 MB of data so far'),
(539,1681894851.809997,2,'info','Analyzed 38700 files containing 452.02 MB of data so far'),
(540,1681894861.980474,2,'info','Analyzed 38800 files containing 452.03 MB of data so far'),
(541,1681894871.959308,2,'info','Analyzed 38900 files containing 452.04 MB of data so far'),
(542,1681894907.291054,2,'info','Analyzed 39000 files containing 452.06 MB of data so far'),
(543,1681894917.330766,2,'info','Analyzed 39100 files containing 452.09 MB of data so far'),
(544,1681894927.227846,2,'info','Analyzed 39200 files containing 452.1 MB of data so far'),
(545,1681894937.604656,2,'info','Analyzed 39300 files containing 452.15 MB of data so far'),
(546,1681894947.980380,2,'info','Analyzed 39400 files containing 452.15 MB of data so far'),
(547,1681894982.739613,2,'info','Analyzed 39500 files containing 452.43 MB of data so far'),
(548,1681894991.766867,2,'info','Analyzed 39600 files containing 452.79 MB of data so far'),
(549,1681895002.143955,2,'info','Analyzed 39700 files containing 452.89 MB of data so far'),
(550,1681895012.335377,2,'info','Analyzed 39800 files containing 452.9 MB of data so far'),
(551,1681895021.895740,2,'info','Analyzed 39900 files containing 452.91 MB of data so far'),
(552,1681895055.841298,2,'info','Analyzed 40000 files containing 452.92 MB of data so far'),
(553,1681895064.424912,2,'info','Analyzed 40100 files containing 452.94 MB of data so far'),
(554,1681895072.714481,2,'info','Analyzed 40200 files containing 453.13 MB of data so far'),
(555,1681895082.707433,2,'info','Analyzed 40300 files containing 453.36 MB of data so far'),
(556,1681895092.700136,2,'info','Analyzed 40400 files containing 453.6 MB of data so far'),
(557,1681895128.838125,2,'info','Analyzed 40500 files containing 453.76 MB of data so far'),
(558,1681895138.815763,2,'info','Analyzed 40600 files containing 455.04 MB of data so far'),
(559,1681895145.904390,2,'info','Analyzed 40700 files containing 455.28 MB of data so far'),
(560,1681895153.352862,2,'info','Analyzed 40800 files containing 455.93 MB of data so far'),
(561,1681895160.375203,2,'info','Analyzed 40900 files containing 456.8 MB of data so far'),
(562,1681895195.371253,2,'info','Analyzed 41000 files containing 457.25 MB of data so far'),
(563,1681895206.332177,2,'info','Analyzed 41100 files containing 458.69 MB of data so far'),
(564,1681895217.446570,2,'info','Analyzed 41200 files containing 459.4 MB of data so far'),
(565,1681895227.748847,2,'info','Analyzed 41300 files containing 459.91 MB of data so far'),
(566,1681895262.591527,2,'info','Analyzed 41400 files containing 460.04 MB of data so far'),
(567,1681895272.685707,2,'info','Analyzed 41500 files containing 460.36 MB of data so far'),
(568,1681895282.789952,2,'info','Analyzed 41600 files containing 460.85 MB of data so far'),
(569,1681895293.093866,2,'info','Analyzed 41700 files containing 460.93 MB of data so far'),
(570,1681895303.919374,2,'info','Analyzed 41800 files containing 461.02 MB of data so far'),
(571,1681895339.823331,2,'info','Analyzed 41900 files containing 461.08 MB of data so far'),
(572,1681895350.230182,2,'info','Analyzed 42000 files containing 461.3 MB of data so far'),
(573,1681895359.057887,2,'info','Analyzed 42100 files containing 461.33 MB of data so far'),
(574,1681895367.735947,2,'info','Analyzed 42200 files containing 461.35 MB of data so far'),
(575,1681895377.341032,2,'info','Analyzed 42300 files containing 461.36 MB of data so far'),
(576,1681895411.032396,2,'info','Analyzed 42400 files containing 461.38 MB of data so far'),
(577,1681895418.466932,2,'info','Analyzed 42500 files containing 462.04 MB of data so far'),
(578,1681895425.581805,2,'info','Analyzed 42600 files containing 462.15 MB of data so far'),
(579,1681895432.578369,2,'info','Analyzed 42700 files containing 462.29 MB of data so far'),
(580,1681895440.148163,2,'info','Analyzed 42800 files containing 462.64 MB of data so far'),
(581,1681895447.148276,2,'info','Analyzed 42900 files containing 462.79 MB of data so far'),
(582,1681895481.656477,2,'info','Analyzed 43000 files containing 463.43 MB of data so far'),
(583,1681895492.280457,2,'info','Analyzed 43100 files containing 463.74 MB of data so far'),
(584,1681895502.825910,2,'info','Analyzed 43200 files containing 464.68 MB of data so far'),
(585,1681895513.437713,2,'info','Analyzed 43300 files containing 464.87 MB of data so far'),
(586,1681895549.211519,2,'info','Analyzed 43400 files containing 467.02 MB of data so far'),
(587,1681895558.391724,2,'info','Analyzed 43500 files containing 467.46 MB of data so far'),
(588,1681895567.940760,2,'info','Analyzed 43600 files containing 467.54 MB of data so far'),
(589,1681895578.165569,2,'info','Analyzed 43700 files containing 467.63 MB of data so far'),
(590,1681895589.144241,2,'info','Analyzed 43800 files containing 467.76 MB of data so far'),
(591,1681895624.873236,2,'info','Analyzed 43900 files containing 468.05 MB of data so far'),
(592,1681895634.107348,2,'info','Analyzed 44000 files containing 468.86 MB of data so far'),
(593,1681895643.080840,2,'info','Analyzed 44100 files containing 469.17 MB of data so far'),
(594,1681895652.586434,2,'info','Analyzed 44200 files containing 469.55 MB of data so far'),
(595,1681895663.459919,2,'info','Analyzed 44300 files containing 474.79 MB of data so far'),
(596,1681895701.141255,2,'info','Analyzed 44400 files containing 475.02 MB of data so far'),
(597,1681895712.574733,2,'info','Analyzed 44500 files containing 476.31 MB of data so far'),
(598,1681895721.463322,2,'info','Analyzed 44600 files containing 476.53 MB of data so far'),
(599,1681895730.628410,2,'info','Analyzed 44700 files containing 479.2 MB of data so far'),
(600,1681895766.846744,2,'info','Analyzed 44800 files containing 479.39 MB of data so far'),
(601,1681895777.690735,2,'info','Analyzed 44900 files containing 480.06 MB of data so far'),
(602,1681895788.251026,2,'info','Analyzed 45000 files containing 480.35 MB of data so far'),
(603,1681895798.919541,2,'info','Analyzed 45100 files containing 481.11 MB of data so far'),
(604,1681895809.954310,2,'info','Analyzed 45200 files containing 481.49 MB of data so far'),
(605,1681895844.603315,2,'info','Analyzed 45300 files containing 481.7 MB of data so far'),
(606,1681895853.713693,2,'info','Analyzed 45400 files containing 482.37 MB of data so far'),
(607,1681895860.887208,2,'info','Analyzed 45500 files containing 482.62 MB of data so far'),
(608,1681895868.444449,2,'info','Analyzed 45600 files containing 482.73 MB of data so far'),
(609,1681895875.669813,2,'info','Analyzed 45700 files containing 482.86 MB of data so far'),
(610,1681895911.164417,2,'info','Analyzed 45800 files containing 483.2 MB of data so far'),
(611,1681895921.227527,2,'info','Analyzed 45900 files containing 483.47 MB of data so far'),
(612,1681895931.312445,2,'info','Analyzed 46000 files containing 484.3 MB of data so far'),
(613,1681895942.044363,2,'info','Analyzed 46100 files containing 485.06 MB of data so far'),
(614,1681895952.392424,2,'info','Analyzed 46200 files containing 485.61 MB of data so far'),
(615,1681895988.245216,2,'info','Analyzed 46300 files containing 486.37 MB of data so far'),
(616,1681895997.795689,2,'info','Analyzed 46400 files containing 486.68 MB of data so far'),
(617,1681896006.798870,2,'info','Analyzed 46500 files containing 487.07 MB of data so far'),
(618,1681896016.854385,2,'info','Analyzed 46600 files containing 487.09 MB of data so far'),
(619,1681896054.670077,2,'info','Analyzed 46700 files containing 487.11 MB of data so far'),
(620,1681896064.901826,2,'info','Analyzed 46800 files containing 487.13 MB of data so far'),
(621,1681896073.419309,2,'info','Analyzed 46900 files containing 487.8 MB of data so far'),
(622,1681896083.252361,2,'info','Analyzed 47000 files containing 489.42 MB of data so far'),
(623,1681896091.877307,2,'info','Analyzed 47100 files containing 489.56 MB of data so far'),
(624,1681896129.099881,2,'info','Analyzed 47200 files containing 490.28 MB of data so far'),
(625,1681896140.517115,2,'info','Analyzed 47300 files containing 493.72 MB of data so far'),
(626,1681896151.235367,2,'info','Analyzed 47400 files containing 494.64 MB of data so far'),
(627,1681896161.174769,2,'info','Analyzed 47500 files containing 494.82 MB of data so far'),
(628,1681896169.525676,2,'info','Analyzed 47600 files containing 496.85 MB of data so far'),
(629,1681896206.270777,2,'info','Analyzed 47700 files containing 497.09 MB of data so far'),
(630,1681896216.434246,2,'info','Analyzed 47800 files containing 497.11 MB of data so far'),
(631,1681896226.270830,2,'info','Analyzed 47900 files containing 497.13 MB of data so far'),
(632,1681896236.536655,2,'info','Analyzed 48000 files containing 497.34 MB of data so far'),
(633,1681896273.308179,2,'info','Analyzed 48100 files containing 497.43 MB of data so far'),
(634,1681896282.189165,2,'info','Analyzed 48200 files containing 497.52 MB of data so far'),
(635,1681896292.437888,2,'info','Analyzed 48300 files containing 497.73 MB of data so far'),
(636,1681896302.234070,2,'info','Analyzed 48400 files containing 497.92 MB of data so far'),
(637,1681896312.296686,2,'info','Analyzed 48500 files containing 498.14 MB of data so far'),
(638,1681896348.981914,2,'info','Analyzed 48600 files containing 498.28 MB of data so far'),
(639,1681896357.347030,2,'info','Analyzed 48700 files containing 498.3 MB of data so far'),
(640,1681896365.911067,2,'info','Analyzed 48800 files containing 498.33 MB of data so far'),
(641,1681896375.454739,2,'info','Analyzed 48900 files containing 498.56 MB of data so far'),
(642,1681896385.693241,2,'info','Analyzed 49000 files containing 498.65 MB of data so far'),
(643,1681896423.133278,2,'info','Analyzed 49100 files containing 498.75 MB of data so far'),
(644,1681896432.691540,2,'info','Analyzed 49200 files containing 498.96 MB of data so far'),
(645,1681896441.656148,2,'info','Analyzed 49300 files containing 499.18 MB of data so far'),
(646,1681896492.047236,2,'info','Analyzed 49400 files containing 499.44 MB of data so far'),
(647,1681896502.770293,2,'info','Analyzed 49500 files containing 499.5 MB of data so far'),
(648,1681896516.061120,2,'info','Analyzed 49600 files containing 499.53 MB of data so far'),
(649,1681896526.720397,2,'info','Analyzed 49700 files containing 499.56 MB of data so far'),
(650,1681896565.705512,2,'info','Analyzed 49800 files containing 499.59 MB of data so far'),
(651,1681896594.546477,2,'info','Analyzed 49900 files containing 502.32 MB of data so far'),
(652,1681896603.374177,2,'info','Analyzed 50000 files containing 502.51 MB of data so far'),
(653,1681896642.065371,2,'info','Analyzed 50100 files containing 502.71 MB of data so far'),
(654,1681896653.969394,2,'info','Analyzed 50200 files containing 502.88 MB of data so far'),
(655,1681896664.771165,2,'info','Analyzed 50300 files containing 503.04 MB of data so far'),
(656,1681896675.250743,2,'info','Analyzed 50400 files containing 503.39 MB of data so far'),
(657,1681896711.365518,2,'info','Analyzed 50500 files containing 503.7 MB of data so far'),
(658,1681896720.317306,2,'info','Analyzed 50600 files containing 504.01 MB of data so far'),
(659,1681896730.391892,2,'info','Analyzed 50700 files containing 504.3 MB of data so far'),
(660,1681896741.286575,2,'info','Analyzed 50800 files containing 504.33 MB of data so far'),
(661,1681896778.908075,2,'info','Analyzed 50900 files containing 504.57 MB of data so far'),
(662,1681896789.734302,2,'info','Analyzed 51000 files containing 504.82 MB of data so far'),
(663,1681896798.881183,2,'info','Analyzed 51100 files containing 505.11 MB of data so far'),
(664,1681896807.785878,2,'info','Analyzed 51200 files containing 505.23 MB of data so far'),
(665,1681896816.995047,2,'info','Analyzed 51300 files containing 510.34 MB of data so far'),
(666,1681896853.299729,2,'info','Analyzed 51400 files containing 510.81 MB of data so far'),
(667,1681896863.969615,2,'info','Analyzed 51500 files containing 511.05 MB of data so far'),
(668,1681896874.478499,2,'info','Analyzed 51600 files containing 511.13 MB of data so far'),
(669,1681896883.587430,2,'info','Analyzed 51700 files containing 511.37 MB of data so far'),
(670,1681896892.228410,2,'info','Analyzed 51800 files containing 513.39 MB of data so far'),
(671,1681896928.068892,2,'info','Analyzed 51900 files containing 515.24 MB of data so far'),
(672,1681896938.508038,2,'info','Analyzed 52000 files containing 515.71 MB of data so far'),
(673,1681896948.821042,2,'info','Analyzed 52100 files containing 516.05 MB of data so far'),
(674,1681896958.912803,2,'info','Analyzed 52200 files containing 516.38 MB of data so far'),
(675,1681896994.894618,2,'info','Analyzed 52300 files containing 516.6 MB of data so far'),
(676,1681897005.150194,2,'info','Analyzed 52400 files containing 516.76 MB of data so far'),
(677,1681897015.524566,2,'info','Analyzed 52500 files containing 517.01 MB of data so far'),
(678,1681897026.172509,2,'info','Analyzed 52600 files containing 517.31 MB of data so far'),
(679,1681897036.149647,2,'info','Analyzed 52700 files containing 517.46 MB of data so far'),
(680,1681897071.679777,2,'info','Analyzed 52800 files containing 517.61 MB of data so far'),
(681,1681897080.418484,2,'info','Analyzed 52900 files containing 517.87 MB of data so far'),
(682,1681897090.545728,2,'info','Analyzed 53000 files containing 518.06 MB of data so far'),
(683,1681897101.189920,2,'info','Analyzed 53100 files containing 518.41 MB of data so far'),
(684,1681897138.707058,2,'info','Analyzed 53200 files containing 518.63 MB of data so far'),
(685,1681897147.321100,2,'info','Analyzed 53300 files containing 519.43 MB of data so far'),
(686,1681897156.347488,2,'info','Analyzed 53400 files containing 520.24 MB of data so far'),
(687,1681897166.121321,2,'info','Analyzed 53500 files containing 520.74 MB of data so far'),
(688,1681897176.214088,2,'info','Analyzed 53600 files containing 521.05 MB of data so far'),
(689,1681897213.616752,2,'info','Analyzed 53700 files containing 521.43 MB of data so far'),
(690,1681897224.720257,2,'info','Analyzed 53800 files containing 521.56 MB of data so far'),
(691,1681897233.171197,2,'info','Analyzed 53900 files containing 521.67 MB of data so far'),
(692,1681897241.745423,2,'info','Analyzed 54000 files containing 521.91 MB of data so far'),
(693,1681897250.729247,2,'info','Analyzed 54100 files containing 522.08 MB of data so far'),
(694,1681897287.990081,2,'info','Analyzed 54200 files containing 522.26 MB of data so far'),
(695,1681897298.357876,2,'info','Analyzed 54300 files containing 522.44 MB of data so far'),
(696,1681897308.233955,2,'info','Analyzed 54400 files containing 522.82 MB of data so far'),
(697,1681897317.634915,2,'info','Analyzed 54500 files containing 522.97 MB of data so far'),
(698,1681897353.672718,2,'info','Analyzed 54600 files containing 526.11 MB of data so far'),
(699,1681897364.689755,2,'info','Analyzed 54700 files containing 588.35 MB of data so far'),
(700,1681897374.825309,2,'info','Analyzed 54800 files containing 588.62 MB of data so far'),
(701,1681897387.016831,2,'info','Analyzed 54900 files containing 588.79 MB of data so far'),
(702,1681897424.158271,2,'info','Analyzed 55000 files containing 589.3 MB of data so far'),
(703,1681897432.599795,2,'info','Analyzed 55100 files containing 589.53 MB of data so far'),
(704,1681897441.369143,2,'info','Analyzed 55200 files containing 590.4 MB of data so far'),
(705,1681897452.637767,2,'info','Analyzed 55300 files containing 620.95 MB of data so far'),
(706,1681897463.790697,2,'info','Analyzed 55400 files containing 623.41 MB of data so far'),
(707,1681897499.079359,2,'info','Analyzed 55500 files containing 625.36 MB of data so far'),
(708,1681897508.934618,2,'info','Analyzed 55600 files containing 626.2 MB of data so far'),
(709,1681897530.317278,2,'info','Analyzed 55700 files containing 626.44 MB of data so far'),
(710,1681897574.414990,2,'info','Analyzed 55800 files containing 627.06 MB of data so far'),
(711,1681897595.219493,2,'info','Analyzed 55900 files containing 627.55 MB of data so far'),
(712,1681897640.415593,2,'info','Analyzed 56000 files containing 628.23 MB of data so far'),
(713,1681897662.083894,2,'info','Analyzed 56100 files containing 629.54 MB of data so far'),
(714,1681897679.831475,2,'info','Analyzed 56200 files containing 631.38 MB of data so far'),
(715,1681897714.546172,2,'info','Analyzed 56300 files containing 632.25 MB of data so far'),
(716,1681897747.906687,2,'info','Analyzed 56400 files containing 634.07 MB of data so far'),
(717,1681897780.789783,2,'info','Analyzed 56500 files containing 636.49 MB of data so far'),
(718,1681897791.195667,2,'info','Analyzed 56600 files containing 637.3 MB of data so far'),
(719,1681897801.744029,2,'info','Analyzed 56700 files containing 639.11 MB of data so far'),
(720,1681897812.084831,2,'info','Analyzed 56800 files containing 639.88 MB of data so far'),
(721,1681897821.606486,2,'info','Analyzed 56900 files containing 640.21 MB of data so far'),
(722,1681897856.062124,2,'info','Analyzed 57000 files containing 640.39 MB of data so far'),
(723,1681897866.147455,2,'info','Analyzed 57100 files containing 640.6 MB of data so far'),
(724,1681897876.526749,2,'info','Analyzed 57200 files containing 640.87 MB of data so far'),
(725,1681897886.729457,2,'info','Analyzed 57300 files containing 640.98 MB of data so far'),
(726,1681897923.284555,2,'info','Analyzed 57400 files containing 641.15 MB of data so far'),
(727,1681897933.191325,2,'info','Analyzed 57500 files containing 641.96 MB of data so far'),
(728,1681897942.100180,2,'info','Analyzed 57600 files containing 644.06 MB of data so far'),
(729,1681897952.187941,2,'info','Analyzed 57700 files containing 646.82 MB of data so far'),
(730,1681897962.734592,2,'info','Analyzed 57800 files containing 648.53 MB of data so far'),
(731,1681898000.691605,2,'info','Analyzed 57900 files containing 650.31 MB of data so far'),
(732,1681898010.111882,2,'info','Analyzed 58000 files containing 664.41 MB of data so far'),
(733,1681898019.035222,2,'info','Analyzed 58100 files containing 668.06 MB of data so far'),
(734,1681898027.523872,2,'info','Analyzed 58200 files containing 670.07 MB of data so far'),
(735,1681898037.054898,2,'info','Analyzed 58300 files containing 671.49 MB of data so far'),
(736,1681898073.716775,2,'info','Analyzed 58400 files containing 676.11 MB of data so far'),
(737,1681898083.677946,2,'info','Analyzed 58500 files containing 677.42 MB of data so far'),
(738,1681898093.679439,2,'info','Analyzed 58600 files containing 679.16 MB of data so far'),
(739,1681898097.481759,2,'info','Analyzed 58633 files containing 679.51 MB of data.'),
(740,1681898097.501659,10,'info','SUM_ENDOK:Comparing core WordPress files against originals in repository'),
(741,1681898097.583616,10,'info','SUM_ENDOK:Comparing open source themes against WordPress.org originals'),
(742,1681898097.644366,10,'info','SUM_ENDBAD:Comparing plugins against WordPress.org originals'),
(743,1681898097.704180,10,'info','SUM_ENDOK:Scanning for unknown files in wp-admin and wp-includes'),
(744,1681898097.763997,10,'info','SUM_ENDOK:Scanning for known malware files'),
(745,1681898097.844071,10,'info','SUM_START:Check for publicly accessible configuration files, backup files and logs'),
(746,1681898098.010370,10,'info','SUM_ENDOK:Check for publicly accessible configuration files, backup files and logs'),
(747,1681898098.127658,10,'info','SUM_START:Scanning file contents for infections and vulnerabilities'),
(748,1681898098.168119,10,'info','SUM_START:Scanning file contents for URLs on a domain blocklist'),
(749,1681898101.048743,2,'info','Starting scan of file contents'),
(750,1681898102.157721,2,'info','Scanned contents of 12 additional files at 11.69 per second'),
(751,1681898103.179248,2,'info','Scanned contents of 32 additional files at 15.63 per second'),
(752,1681898104.219173,2,'info','Scanned contents of 51 additional files at 16.52 per second'),
(753,1681898105.239889,2,'info','Scanned contents of 72 additional files at 17.52 per second'),
(754,1681898106.249068,2,'info','Scanned contents of 92 additional files at 17.98 per second'),
(755,1681898107.302029,2,'info','Scanned contents of 106 additional files at 17.18 per second'),
(756,1681898108.331166,2,'info','Scanned contents of 125 additional files at 17.36 per second'),
(757,1681898109.374458,2,'info','Scanned contents of 147 additional files at 17.83 per second'),
(758,1681898110.389627,2,'info','Scanned contents of 164 additional files at 17.71 per second'),
(759,1681898111.414737,2,'info','Scanned contents of 184 additional files at 17.89 per second'),
(760,1681898137.358669,2,'info','Scanned contents of 196 additional files at 5.41 per second'),
(761,1681898138.419844,2,'info','Scanned contents of 213 additional files at 5.71 per second'),
(762,1681898139.421289,2,'info','Scanned contents of 228 additional files at 5.95 per second'),
(763,1681898140.475912,2,'info','Scanned contents of 244 additional files at 6.20 per second'),
(764,1681898141.502673,2,'info','Scanned contents of 262 additional files at 6.49 per second'),
(765,1681898142.534930,2,'info','Scanned contents of 278 additional files at 6.71 per second'),
(766,1681898143.566614,2,'info','Scanned contents of 294 additional files at 6.93 per second'),
(767,1681898144.578412,2,'info','Scanned contents of 303 additional files at 6.97 per second'),
(768,1681898145.590243,2,'info','Scanned contents of 320 additional files at 7.20 per second'),
(769,1681898146.644168,2,'info','Scanned contents of 338 additional files at 7.43 per second'),
(770,1681898147.681622,2,'info','Scanned contents of 355 additional files at 7.63 per second'),
(771,1681898148.737390,2,'info','Scanned contents of 374 additional files at 7.86 per second'),
(772,1681898149.790638,2,'info','Scanned contents of 392 additional files at 8.06 per second'),
(773,1681898150.845230,2,'info','Scanned contents of 406 additional files at 8.17 per second'),
(774,1681898151.877220,2,'info','Scanned contents of 417 additional files at 8.22 per second'),
(775,1681898152.914138,2,'info','Scanned contents of 430 additional files at 8.30 per second'),
(776,1681898153.953940,2,'info','Scanned contents of 447 additional files at 8.46 per second'),
(777,1681898154.975385,2,'info','Scanned contents of 464 additional files at 8.62 per second'),
(778,1681898156.009945,2,'info','Scanned contents of 482 additional files at 8.78 per second'),
(779,1681898157.045271,2,'info','Scanned contents of 497 additional files at 8.89 per second'),
(780,1681898157.190679,1,'info','-------------------'),
(781,1681898157.240488,1,'info','Scan interrupted. Scanned 58633 files, 65 plugins, 5 themes, 0 posts, 0 comments and 0 URLs in 3 hours 1 second.'),
(782,1681898157.264802,10,'info','SUM_FINAL:Scan interrupted. You have 2 new issues to fix. See below.'),
(783,1681898170.513678,2,'info','Wordfence used 60 MB of memory for scan. Server peak memory usage was: 124 MB'),
(784,1681898170.528571,2,'error','Scan terminated with error: The scan time limit of 3 hours has been exceeded and the scan will be terminated. This limit can be customized on the options page. <a href=\"https://www.wordfence.com/help/?query=scan-time-limit\" target=\"_blank\" rel=\"noopener noreferrer\">Get More Information<span class=\"screen-reader-text\"> (opens in new tab)</span></a>'),
(785,1688176071.570259,1,'info','Scan stop request received.'),
(786,1688176071.594014,10,'info','SUM_KILLED:A request was received to stop the previous scan.');
/*!40000 ALTER TABLE `hadpj_wfstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wftrafficrates`
--

DROP TABLE IF EXISTS `hadpj_wftrafficrates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wftrafficrates` (
  `eMin` int(10) unsigned NOT NULL,
  `IP` binary(16) NOT NULL DEFAULT '\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0',
  `hitType` enum('hit','404') NOT NULL DEFAULT 'hit',
  `hits` int(10) unsigned NOT NULL,
  PRIMARY KEY (`eMin`,`IP`,`hitType`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wftrafficrates`
--

LOCK TABLES `hadpj_wftrafficrates` WRITE;
/*!40000 ALTER TABLE `hadpj_wftrafficrates` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_wftrafficrates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hadpj_wfwaffailures`
--

DROP TABLE IF EXISTS `hadpj_wfwaffailures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hadpj_wfwaffailures` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `throwable` text NOT NULL,
  `rule_id` int(10) unsigned DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hadpj_wfwaffailures`
--

LOCK TABLES `hadpj_wfwaffailures` WRITE;
/*!40000 ALTER TABLE `hadpj_wfwaffailures` DISABLE KEYS */;
/*!40000 ALTER TABLE `hadpj_wfwaffailures` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-11 23:39:18
