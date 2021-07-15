-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Час створення: Лип 15 2021 р., 09:34
-- Версія сервера: 10.3.29-MariaDB-0ubuntu0.20.04.1
-- Версія PHP: 7.3.27-1+focal

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `wings_wings`
--

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_aiowps_events`
--

CREATE TABLE `nammk_aiowps_events` (
  `id` bigint(20) NOT NULL,
  `event_type` varchar(150) NOT NULL DEFAULT '',
  `username` varchar(150) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `event_date` datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
  `ip_or_host` varchar(100) DEFAULT NULL,
  `referer_info` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `event_data` longtext DEFAULT NULL,
  `country_code` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_aiowps_failed_logins`
--

CREATE TABLE `nammk_aiowps_failed_logins` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_login` varchar(150) NOT NULL,
  `failed_login_date` datetime NOT NULL DEFAULT '1000-10-00 10:00:00',
  `login_attempt_ip` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_aiowps_login_activity`
--

CREATE TABLE `nammk_aiowps_login_activity` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_login` varchar(150) NOT NULL,
  `login_date` datetime NOT NULL DEFAULT '1000-10-00 10:00:00',
  `logout_date` datetime NOT NULL DEFAULT '1000-10-00 10:00:00',
  `login_ip` varchar(100) NOT NULL DEFAULT '',
  `login_country` varchar(150) NOT NULL DEFAULT '',
  `browser_type` varchar(150) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_aiowps_login_lockdown`
--

CREATE TABLE `nammk_aiowps_login_lockdown` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_login` varchar(150) NOT NULL,
  `lockdown_date` datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
  `release_date` datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
  `failed_login_ip` varchar(100) NOT NULL DEFAULT '',
  `unlock_key` varchar(128) NOT NULL,
  `lock_reason` varchar(128) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_aiowps_permanent_block`
--

CREATE TABLE `nammk_aiowps_permanent_block` (
  `id` bigint(20) NOT NULL,
  `blocked_ip` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `block_reason` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `country_origin` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `blocked_date` datetime NOT NULL DEFAULT '1000-10-10 10:00:00',
  `unblock` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_blc_filters`
--

CREATE TABLE `nammk_blc_filters` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `params` text COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_blc_instances`
--

CREATE TABLE `nammk_blc_instances` (
  `instance_id` int(10) UNSIGNED NOT NULL,
  `link_id` int(10) UNSIGNED NOT NULL,
  `container_id` int(10) UNSIGNED NOT NULL,
  `container_type` varchar(40) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'post',
  `link_text` text COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `parser_type` varchar(40) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'link',
  `container_field` varchar(250) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_context` varchar(250) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `raw_url` text COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_blc_links`
--

CREATE TABLE `nammk_blc_links` (
  `link_id` int(20) UNSIGNED NOT NULL,
  `url` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `first_failure` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_check` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_success` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_check_attempt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `check_count` int(4) UNSIGNED NOT NULL DEFAULT 0,
  `final_url` text CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `redirect_count` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `log` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `http_code` smallint(6) NOT NULL DEFAULT 0,
  `status_code` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT '',
  `status_text` varchar(250) COLLATE utf8mb4_unicode_520_ci DEFAULT '',
  `request_duration` float NOT NULL DEFAULT 0,
  `timeout` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `broken` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `warning` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `may_recheck` tinyint(1) NOT NULL DEFAULT 1,
  `being_checked` tinyint(1) NOT NULL DEFAULT 0,
  `result_hash` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `false_positive` tinyint(1) NOT NULL DEFAULT 0,
  `dismissed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_blc_synch`
--

CREATE TABLE `nammk_blc_synch` (
  `container_id` int(20) UNSIGNED NOT NULL,
  `container_type` varchar(40) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `synched` tinyint(2) UNSIGNED NOT NULL,
  `last_synch` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_commentmeta`
--

CREATE TABLE `nammk_commentmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_comments`
--

CREATE TABLE `nammk_comments` (
  `comment_ID` bigint(20) UNSIGNED NOT NULL,
  `comment_post_ID` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `comment_author` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT 0,
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'comment',
  `comment_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_db7_forms`
--

CREATE TABLE `nammk_db7_forms` (
  `form_id` bigint(20) NOT NULL,
  `form_post_id` bigint(20) NOT NULL,
  `form_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `form_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_links`
--

CREATE TABLE `nammk_links` (
  `link_id` bigint(20) UNSIGNED NOT NULL,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `link_rating` int(11) NOT NULL DEFAULT 0,
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_options`
--

CREATE TABLE `nammk_options` (
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `nammk_options`
--

INSERT INTO `nammk_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'siteurl', 'http://wp-framework.local', 'yes'),
(2, 'blogname', '', 'yes'),
(3, 'blogdescription', '', 'yes'),
(4, 'users_can_register', '0', 'yes'),
(5, 'admin_email', 'info@wp-framework.local', 'yes'),
(6, 'start_of_week', '1', 'yes'),
(7, 'use_balanceTags', '', 'yes'),
(8, 'use_smilies', '1', 'yes'),
(9, 'require_name_email', '1', 'yes'),
(10, 'comments_notify', '1', 'yes'),
(11, 'posts_per_rss', '10', 'yes'),
(12, 'rss_use_excerpt', '1', 'yes'),
(13, 'mailserver_url', 'mail.example.com', 'yes'),
(14, 'mailserver_login', 'login@example.com', 'yes'),
(15, 'mailserver_pass', 'password', 'yes'),
(16, 'mailserver_port', '110', 'yes'),
(17, 'default_category', '1', 'yes'),
(18, 'default_comment_status', 'open', 'yes'),
(19, 'default_ping_status', 'closed', 'yes'),
(20, 'default_pingback_flag', '1', 'yes'),
(405, 'db_upgraded', '', 'yes'),
(22, 'posts_per_page', '10', 'yes'),
(23, 'date_format', 'd.m.Y', 'yes'),
(24, 'time_format', 'H:i', 'yes'),
(25, 'links_updated_date_format', 'd.m.Y H:i', 'yes'),
(29, 'comment_moderation', '', 'yes'),
(30, 'moderation_notify', '1', 'yes'),
(31, 'permalink_structure', '/%postname%/', 'yes'),
(33, 'hack_file', '0', 'yes'),
(34, 'blog_charset', 'UTF-8', 'yes'),
(35, 'moderation_keys', '', 'no'),
(36, 'active_plugins', 'a:5:{i:0;s:43:\"broken-link-checker/broken-link-checker.php\";i:1;s:33:\"classic-editor/classic-editor.php\";i:2;s:29:\"health-check/health-check.php\";i:3;s:49:\"pb-seo-friendly-images/pb-seo-friendly-images.php\";i:4;s:39:\"wp-file-manager/file_folder_manager.php\";}', 'yes'),
(37, 'home', 'http://wp-framework.local', 'yes'),
(38, 'category_base', '/', 'yes'),
(39, 'ping_sites', 'http://rpc.pingomatic.com\nhttp://rpc.twingly.com\nhttp://api.feedster.com/ping\nhttp://api.moreover.com/RPC2\nhttp://api.moreover.com/ping\nhttp://www.blogdigger.com/RPC2\nhttp://www.blogshares.com/rpc.php\nhttp://www.blogsnow.com/ping\nhttp://www.blogstreet.com/xrbin/xmlrpc.cgi\nhttp://bulkfeeds.net/rpc\nhttp://www.newsisfree.com/xmlrpctest.php\nhttp://ping.blo.gs/\nhttp://ping.feedburner.com\nhttp://ping.syndic8.com/xmlrpc.php\nhttp://ping.weblogalot.com/rpc.php\nhttp://rpc.blogrolling.com/pinger/\nhttp://rpc.technorati.com/rpc/ping\nhttp://rpc.weblogs.com/RPC2\nhttp://www.feedsubmitter.com\nhttp://blo.gs/ping.php\nhttp://www.pingerati.net\nhttp://www.pingmyblog.com\nhttp://geourl.org/ping\nhttp://ipings.com\nhttp://www.weblogalot.com/ping', 'yes'),
(41, 'comment_max_links', '2', 'yes'),
(42, 'gmt_offset', '', 'yes'),
(43, 'default_email_category', '1', 'yes'),
(44, 'recently_edited', '', 'no'),
(45, 'template', 'twentytwentyone', 'yes'),
(46, 'stylesheet', 'twentytwentyone', 'yes'),
(2001, 'finished_updating_comment_type', '1', 'yes'),
(2018, '_site_transient_update_core', 'O:8:\"stdClass\":4:{s:7:\"updates\";a:1:{i:0;O:8:\"stdClass\":10:{s:8:\"response\";s:6:\"latest\";s:8:\"download\";s:65:\"https://downloads.wordpress.org/release/ru_RU/wordpress-5.7.2.zip\";s:6:\"locale\";s:5:\"ru_RU\";s:8:\"packages\";O:8:\"stdClass\":5:{s:4:\"full\";s:65:\"https://downloads.wordpress.org/release/ru_RU/wordpress-5.7.2.zip\";s:10:\"no_content\";s:0:\"\";s:11:\"new_bundled\";s:0:\"\";s:7:\"partial\";s:0:\"\";s:8:\"rollback\";s:0:\"\";}s:7:\"current\";s:5:\"5.7.2\";s:7:\"version\";s:5:\"5.7.2\";s:11:\"php_version\";s:6:\"5.6.20\";s:13:\"mysql_version\";s:3:\"5.0\";s:11:\"new_bundled\";s:3:\"5.6\";s:15:\"partial_version\";s:0:\"\";}}s:12:\"last_checked\";i:1626341467;s:15:\"version_checked\";s:5:\"5.7.2\";s:12:\"translations\";a:0:{}}', 'no'),
(2019, '_site_transient_update_plugins', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1626341467;s:7:\"checked\";a:24:{s:16:\"htm-on-pages.php\";s:3:\"1.1\";s:53:\"accelerated-mobile-pages/accelerated-moblie-pages.php\";s:9:\"1.0.77.12\";s:34:\"advanced-custom-fields-pro/acf.php\";s:5:\"5.8.7\";s:19:\"akismet/akismet.php\";s:6:\"4.1.10\";s:51:\"all-in-one-wp-security-and-firewall/wp-security.php\";s:5:\"4.4.8\";s:27:\"ari-adminer/ari-adminer.php\";s:5:\"1.2.3\";s:42:\"bicycles-by-falbar2/bicycles-by-falbar.php\";s:3:\"2.1\";s:43:\"broken-link-checker/broken-link-checker.php\";s:7:\"1.11.15\";s:33:\"classic-editor/classic-editor.php\";s:3:\"1.6\";s:33:\"complianz-gdpr/complianz-gpdr.php\";s:5:\"5.2.2\";s:36:\"contact-form-7/wp-contact-form-7.php\";s:5:\"5.4.2\";s:42:\"contact-form-cfdb7/contact-form-cfdb-7.php\";s:7:\"1.2.5.9\";s:43:\"custom-post-type-ui/custom-post-type-ui.php\";s:5:\"1.9.2\";s:25:\"fakerpress/fakerpress.php\";s:5:\"0.5.1\";s:29:\"health-check/health-check.php\";s:5:\"1.4.5\";s:35:\"litespeed-cache/litespeed-cache.php\";s:5:\"3.6.4\";s:49:\"pb-seo-friendly-images/pb-seo-friendly-images.php\";s:5:\"4.0.4\";s:47:\"really-simple-ssl/rlrsssl-really-simple-ssl.php\";s:5:\"5.0.2\";s:27:\"updraftplus/updraftplus.php\";s:7:\"1.16.56\";s:25:\"insert-php/insert_php.php\";s:5:\"2.4.1\";s:41:\"wordpress-importer/wordpress-importer.php\";s:3:\"0.7\";s:27:\"wp-optimize/wp-optimize.php\";s:6:\"3.1.11\";s:39:\"wp-file-manager/file_folder_manager.php\";s:5:\"7.1.1\";s:24:\"wordpress-seo/wp-seo.php\";s:4:\"16.7\";}s:8:\"response\";a:0:{}s:12:\"translations\";a:0:{}s:9:\"no_update\";a:22:{s:16:\"htm-on-pages.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:26:\"w.org/plugins/htm-on-pages\";s:4:\"slug\";s:12:\"htm-on-pages\";s:6:\"plugin\";s:16:\"htm-on-pages.php\";s:11:\"new_version\";s:3:\"1.1\";s:3:\"url\";s:43:\"https://wordpress.org/plugins/htm-on-pages/\";s:7:\"package\";s:55:\"https://downloads.wordpress.org/plugin/htm-on-pages.zip\";s:5:\"icons\";a:1:{s:7:\"default\";s:56:\"https://s.w.org/plugins/geopattern-icon/htm-on-pages.svg\";}s:7:\"banners\";a:0:{}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:5:\"2.5.1\";}s:53:\"accelerated-mobile-pages/accelerated-moblie-pages.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:38:\"w.org/plugins/accelerated-mobile-pages\";s:4:\"slug\";s:24:\"accelerated-mobile-pages\";s:6:\"plugin\";s:53:\"accelerated-mobile-pages/accelerated-moblie-pages.php\";s:11:\"new_version\";s:9:\"1.0.77.12\";s:3:\"url\";s:55:\"https://wordpress.org/plugins/accelerated-mobile-pages/\";s:7:\"package\";s:77:\"https://downloads.wordpress.org/plugin/accelerated-mobile-pages.1.0.77.12.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:77:\"https://ps.w.org/accelerated-mobile-pages/assets/icon-256x256.png?rev=1693616\";s:2:\"1x\";s:77:\"https://ps.w.org/accelerated-mobile-pages/assets/icon-128x128.png?rev=1693616\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:80:\"https://ps.w.org/accelerated-mobile-pages/assets/banner-1544x500.png?rev=1776918\";s:2:\"1x\";s:79:\"https://ps.w.org/accelerated-mobile-pages/assets/banner-772x250.png?rev=1776918\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"3.0\";}s:19:\"akismet/akismet.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:21:\"w.org/plugins/akismet\";s:4:\"slug\";s:7:\"akismet\";s:6:\"plugin\";s:19:\"akismet/akismet.php\";s:11:\"new_version\";s:6:\"4.1.10\";s:3:\"url\";s:38:\"https://wordpress.org/plugins/akismet/\";s:7:\"package\";s:57:\"https://downloads.wordpress.org/plugin/akismet.4.1.10.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:59:\"https://ps.w.org/akismet/assets/icon-256x256.png?rev=969272\";s:2:\"1x\";s:59:\"https://ps.w.org/akismet/assets/icon-128x128.png?rev=969272\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:61:\"https://ps.w.org/akismet/assets/banner-772x250.jpg?rev=479904\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.6\";}s:51:\"all-in-one-wp-security-and-firewall/wp-security.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:49:\"w.org/plugins/all-in-one-wp-security-and-firewall\";s:4:\"slug\";s:35:\"all-in-one-wp-security-and-firewall\";s:6:\"plugin\";s:51:\"all-in-one-wp-security-and-firewall/wp-security.php\";s:11:\"new_version\";s:5:\"4.4.8\";s:3:\"url\";s:66:\"https://wordpress.org/plugins/all-in-one-wp-security-and-firewall/\";s:7:\"package\";s:78:\"https://downloads.wordpress.org/plugin/all-in-one-wp-security-and-firewall.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:88:\"https://ps.w.org/all-in-one-wp-security-and-firewall/assets/icon-128x128.png?rev=1232826\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:91:\"https://ps.w.org/all-in-one-wp-security-and-firewall/assets/banner-1544x500.png?rev=1914011\";s:2:\"1x\";s:90:\"https://ps.w.org/all-in-one-wp-security-and-firewall/assets/banner-772x250.png?rev=1914013\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.0\";}s:42:\"bicycles-by-falbar2/bicycles-by-falbar.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:32:\"w.org/plugins/bicycles-by-falbar\";s:4:\"slug\";s:18:\"bicycles-by-falbar\";s:6:\"plugin\";s:42:\"bicycles-by-falbar2/bicycles-by-falbar.php\";s:11:\"new_version\";s:3:\"2.1\";s:3:\"url\";s:49:\"https://wordpress.org/plugins/bicycles-by-falbar/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/bicycles-by-falbar.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:71:\"https://ps.w.org/bicycles-by-falbar/assets/icon-128x128.png?rev=1796680\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:73:\"https://ps.w.org/bicycles-by-falbar/assets/banner-772x250.png?rev=1796680\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:5:\"4.4.2\";}s:43:\"broken-link-checker/broken-link-checker.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:33:\"w.org/plugins/broken-link-checker\";s:4:\"slug\";s:19:\"broken-link-checker\";s:6:\"plugin\";s:43:\"broken-link-checker/broken-link-checker.php\";s:11:\"new_version\";s:7:\"1.11.15\";s:3:\"url\";s:50:\"https://wordpress.org/plugins/broken-link-checker/\";s:7:\"package\";s:70:\"https://downloads.wordpress.org/plugin/broken-link-checker.1.11.15.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:72:\"https://ps.w.org/broken-link-checker/assets/icon-256x256.png?rev=2205502\";s:2:\"1x\";s:72:\"https://ps.w.org/broken-link-checker/assets/icon-128x128.png?rev=2205502\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:75:\"https://ps.w.org/broken-link-checker/assets/banner-1544x500.png?rev=2205502\";s:2:\"1x\";s:74:\"https://ps.w.org/broken-link-checker/assets/banner-772x250.png?rev=2205502\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.6\";}s:33:\"classic-editor/classic-editor.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:28:\"w.org/plugins/classic-editor\";s:4:\"slug\";s:14:\"classic-editor\";s:6:\"plugin\";s:33:\"classic-editor/classic-editor.php\";s:11:\"new_version\";s:3:\"1.6\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/classic-editor/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/classic-editor.1.6.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/classic-editor/assets/icon-256x256.png?rev=1998671\";s:2:\"1x\";s:67:\"https://ps.w.org/classic-editor/assets/icon-128x128.png?rev=1998671\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:70:\"https://ps.w.org/classic-editor/assets/banner-1544x500.png?rev=1998671\";s:2:\"1x\";s:69:\"https://ps.w.org/classic-editor/assets/banner-772x250.png?rev=1998676\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.9\";}s:33:\"complianz-gdpr/complianz-gpdr.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:28:\"w.org/plugins/complianz-gdpr\";s:4:\"slug\";s:14:\"complianz-gdpr\";s:6:\"plugin\";s:33:\"complianz-gdpr/complianz-gpdr.php\";s:11:\"new_version\";s:5:\"5.2.2\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/complianz-gdpr/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/complianz-gdpr.5.2.2.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/complianz-gdpr/assets/icon-256x256.gif?rev=2316449\";s:2:\"1x\";s:67:\"https://ps.w.org/complianz-gdpr/assets/icon-128x128.gif?rev=2316449\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:70:\"https://ps.w.org/complianz-gdpr/assets/banner-1544x500.png?rev=2556320\";s:2:\"1x\";s:69:\"https://ps.w.org/complianz-gdpr/assets/banner-772x250.png?rev=2556320\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.9\";}s:36:\"contact-form-7/wp-contact-form-7.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:28:\"w.org/plugins/contact-form-7\";s:4:\"slug\";s:14:\"contact-form-7\";s:6:\"plugin\";s:36:\"contact-form-7/wp-contact-form-7.php\";s:11:\"new_version\";s:5:\"5.4.2\";s:3:\"url\";s:45:\"https://wordpress.org/plugins/contact-form-7/\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/plugin/contact-form-7.5.4.2.zip\";s:5:\"icons\";a:3:{s:2:\"2x\";s:67:\"https://ps.w.org/contact-form-7/assets/icon-256x256.png?rev=2279696\";s:2:\"1x\";s:59:\"https://ps.w.org/contact-form-7/assets/icon.svg?rev=2339255\";s:3:\"svg\";s:59:\"https://ps.w.org/contact-form-7/assets/icon.svg?rev=2339255\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:69:\"https://ps.w.org/contact-form-7/assets/banner-1544x500.png?rev=860901\";s:2:\"1x\";s:68:\"https://ps.w.org/contact-form-7/assets/banner-772x250.png?rev=880427\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.5\";}s:42:\"contact-form-cfdb7/contact-form-cfdb-7.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:32:\"w.org/plugins/contact-form-cfdb7\";s:4:\"slug\";s:18:\"contact-form-cfdb7\";s:6:\"plugin\";s:42:\"contact-form-cfdb7/contact-form-cfdb-7.php\";s:11:\"new_version\";s:7:\"1.2.5.9\";s:3:\"url\";s:49:\"https://wordpress.org/plugins/contact-form-cfdb7/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/contact-form-cfdb7.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:71:\"https://ps.w.org/contact-form-cfdb7/assets/icon-256x256.png?rev=1619878\";s:2:\"1x\";s:71:\"https://ps.w.org/contact-form-cfdb7/assets/icon-128x128.png?rev=1619878\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:73:\"https://ps.w.org/contact-form-cfdb7/assets/banner-772x250.png?rev=1619902\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.8\";}s:43:\"custom-post-type-ui/custom-post-type-ui.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:33:\"w.org/plugins/custom-post-type-ui\";s:4:\"slug\";s:19:\"custom-post-type-ui\";s:6:\"plugin\";s:43:\"custom-post-type-ui/custom-post-type-ui.php\";s:11:\"new_version\";s:5:\"1.9.2\";s:3:\"url\";s:50:\"https://wordpress.org/plugins/custom-post-type-ui/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/plugin/custom-post-type-ui.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:72:\"https://ps.w.org/custom-post-type-ui/assets/icon-256x256.png?rev=2549362\";s:2:\"1x\";s:72:\"https://ps.w.org/custom-post-type-ui/assets/icon-128x128.png?rev=2549362\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:75:\"https://ps.w.org/custom-post-type-ui/assets/banner-1544x500.png?rev=2549362\";s:2:\"1x\";s:74:\"https://ps.w.org/custom-post-type-ui/assets/banner-772x250.png?rev=2549362\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.5\";}s:25:\"fakerpress/fakerpress.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:24:\"w.org/plugins/fakerpress\";s:4:\"slug\";s:10:\"fakerpress\";s:6:\"plugin\";s:25:\"fakerpress/fakerpress.php\";s:11:\"new_version\";s:5:\"0.5.1\";s:3:\"url\";s:41:\"https://wordpress.org/plugins/fakerpress/\";s:7:\"package\";s:53:\"https://downloads.wordpress.org/plugin/fakerpress.zip\";s:5:\"icons\";a:3:{s:2:\"2x\";s:63:\"https://ps.w.org/fakerpress/assets/icon-256x256.png?rev=1846090\";s:2:\"1x\";s:55:\"https://ps.w.org/fakerpress/assets/icon.svg?rev=1846090\";s:3:\"svg\";s:55:\"https://ps.w.org/fakerpress/assets/icon.svg?rev=1846090\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:66:\"https://ps.w.org/fakerpress/assets/banner-1544x500.png?rev=1152002\";s:2:\"1x\";s:65:\"https://ps.w.org/fakerpress/assets/banner-772x250.png?rev=1152002\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.7\";}s:29:\"health-check/health-check.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:26:\"w.org/plugins/health-check\";s:4:\"slug\";s:12:\"health-check\";s:6:\"plugin\";s:29:\"health-check/health-check.php\";s:11:\"new_version\";s:5:\"1.4.5\";s:3:\"url\";s:43:\"https://wordpress.org/plugins/health-check/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/health-check.1.4.5.zip\";s:5:\"icons\";a:3:{s:2:\"2x\";s:65:\"https://ps.w.org/health-check/assets/icon-256x256.png?rev=1823210\";s:2:\"1x\";s:57:\"https://ps.w.org/health-check/assets/icon.svg?rev=1828244\";s:3:\"svg\";s:57:\"https://ps.w.org/health-check/assets/icon.svg?rev=1828244\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:68:\"https://ps.w.org/health-check/assets/banner-1544x500.png?rev=1823210\";s:2:\"1x\";s:67:\"https://ps.w.org/health-check/assets/banner-772x250.png?rev=1823210\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.0\";}s:35:\"litespeed-cache/litespeed-cache.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:29:\"w.org/plugins/litespeed-cache\";s:4:\"slug\";s:15:\"litespeed-cache\";s:6:\"plugin\";s:35:\"litespeed-cache/litespeed-cache.php\";s:11:\"new_version\";s:5:\"3.6.4\";s:3:\"url\";s:46:\"https://wordpress.org/plugins/litespeed-cache/\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/plugin/litespeed-cache.3.6.4.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:68:\"https://ps.w.org/litespeed-cache/assets/icon-256x256.png?rev=2554181\";s:2:\"1x\";s:68:\"https://ps.w.org/litespeed-cache/assets/icon-128x128.png?rev=2554181\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:71:\"https://ps.w.org/litespeed-cache/assets/banner-1544x500.png?rev=2554181\";s:2:\"1x\";s:70:\"https://ps.w.org/litespeed-cache/assets/banner-772x250.png?rev=2554181\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.0\";}s:49:\"pb-seo-friendly-images/pb-seo-friendly-images.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:36:\"w.org/plugins/pb-seo-friendly-images\";s:4:\"slug\";s:22:\"pb-seo-friendly-images\";s:6:\"plugin\";s:49:\"pb-seo-friendly-images/pb-seo-friendly-images.php\";s:11:\"new_version\";s:5:\"4.0.4\";s:3:\"url\";s:53:\"https://wordpress.org/plugins/pb-seo-friendly-images/\";s:7:\"package\";s:71:\"https://downloads.wordpress.org/plugin/pb-seo-friendly-images.4.0.4.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:75:\"https://ps.w.org/pb-seo-friendly-images/assets/icon-256x256.png?rev=1556388\";s:2:\"1x\";s:75:\"https://ps.w.org/pb-seo-friendly-images/assets/icon-128x128.png?rev=1556388\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:78:\"https://ps.w.org/pb-seo-friendly-images/assets/banner-1544x500.png?rev=1556388\";s:2:\"1x\";s:77:\"https://ps.w.org/pb-seo-friendly-images/assets/banner-772x250.png?rev=1556388\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"5.0\";}s:47:\"really-simple-ssl/rlrsssl-really-simple-ssl.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:31:\"w.org/plugins/really-simple-ssl\";s:4:\"slug\";s:17:\"really-simple-ssl\";s:6:\"plugin\";s:47:\"really-simple-ssl/rlrsssl-really-simple-ssl.php\";s:11:\"new_version\";s:5:\"5.0.2\";s:3:\"url\";s:48:\"https://wordpress.org/plugins/really-simple-ssl/\";s:7:\"package\";s:66:\"https://downloads.wordpress.org/plugin/really-simple-ssl.5.0.2.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:70:\"https://ps.w.org/really-simple-ssl/assets/icon-128x128.png?rev=1782452\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:73:\"https://ps.w.org/really-simple-ssl/assets/banner-1544x500.png?rev=2320223\";s:2:\"1x\";s:72:\"https://ps.w.org/really-simple-ssl/assets/banner-772x250.png?rev=2320228\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.9\";}s:27:\"updraftplus/updraftplus.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:25:\"w.org/plugins/updraftplus\";s:4:\"slug\";s:11:\"updraftplus\";s:6:\"plugin\";s:27:\"updraftplus/updraftplus.php\";s:11:\"new_version\";s:7:\"1.16.56\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/updraftplus/\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/plugin/updraftplus.1.16.56.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/updraftplus/assets/icon-256x256.jpg?rev=1686200\";s:2:\"1x\";s:64:\"https://ps.w.org/updraftplus/assets/icon-128x128.jpg?rev=1686200\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/updraftplus/assets/banner-1544x500.png?rev=1686200\";s:2:\"1x\";s:66:\"https://ps.w.org/updraftplus/assets/banner-772x250.png?rev=1686200\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"3.2\";}s:25:\"insert-php/insert_php.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:24:\"w.org/plugins/insert-php\";s:4:\"slug\";s:10:\"insert-php\";s:6:\"plugin\";s:25:\"insert-php/insert_php.php\";s:11:\"new_version\";s:5:\"2.4.1\";s:3:\"url\";s:41:\"https://wordpress.org/plugins/insert-php/\";s:7:\"package\";s:53:\"https://downloads.wordpress.org/plugin/insert-php.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:63:\"https://ps.w.org/insert-php/assets/icon-256x256.png?rev=2553296\";s:2:\"1x\";s:63:\"https://ps.w.org/insert-php/assets/icon-128x128.png?rev=2553296\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:66:\"https://ps.w.org/insert-php/assets/banner-1544x500.jpg?rev=2474791\";s:2:\"1x\";s:65:\"https://ps.w.org/insert-php/assets/banner-772x250.jpg?rev=2474791\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.8\";}s:41:\"wordpress-importer/wordpress-importer.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:32:\"w.org/plugins/wordpress-importer\";s:4:\"slug\";s:18:\"wordpress-importer\";s:6:\"plugin\";s:41:\"wordpress-importer/wordpress-importer.php\";s:11:\"new_version\";s:3:\"0.7\";s:3:\"url\";s:49:\"https://wordpress.org/plugins/wordpress-importer/\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/plugin/wordpress-importer.0.7.zip\";s:5:\"icons\";a:3:{s:2:\"2x\";s:71:\"https://ps.w.org/wordpress-importer/assets/icon-256x256.png?rev=1908375\";s:2:\"1x\";s:63:\"https://ps.w.org/wordpress-importer/assets/icon.svg?rev=1908375\";s:3:\"svg\";s:63:\"https://ps.w.org/wordpress-importer/assets/icon.svg?rev=1908375\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:72:\"https://ps.w.org/wordpress-importer/assets/banner-772x250.png?rev=547654\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"3.7\";}s:27:\"wp-optimize/wp-optimize.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:25:\"w.org/plugins/wp-optimize\";s:4:\"slug\";s:11:\"wp-optimize\";s:6:\"plugin\";s:27:\"wp-optimize/wp-optimize.php\";s:11:\"new_version\";s:6:\"3.1.11\";s:3:\"url\";s:42:\"https://wordpress.org/plugins/wp-optimize/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/wp-optimize.3.1.11.zip\";s:5:\"icons\";a:2:{s:2:\"2x\";s:64:\"https://ps.w.org/wp-optimize/assets/icon-256x256.png?rev=1552899\";s:2:\"1x\";s:64:\"https://ps.w.org/wp-optimize/assets/icon-128x128.png?rev=1552899\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:67:\"https://ps.w.org/wp-optimize/assets/banner-1544x500.png?rev=2125385\";s:2:\"1x\";s:66:\"https://ps.w.org/wp-optimize/assets/banner-772x250.png?rev=2125385\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.5\";}s:39:\"wp-file-manager/file_folder_manager.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:29:\"w.org/plugins/wp-file-manager\";s:4:\"slug\";s:15:\"wp-file-manager\";s:6:\"plugin\";s:39:\"wp-file-manager/file_folder_manager.php\";s:11:\"new_version\";s:5:\"7.1.1\";s:3:\"url\";s:46:\"https://wordpress.org/plugins/wp-file-manager/\";s:7:\"package\";s:58:\"https://downloads.wordpress.org/plugin/wp-file-manager.zip\";s:5:\"icons\";a:1:{s:2:\"1x\";s:68:\"https://ps.w.org/wp-file-manager/assets/icon-128x128.png?rev=2491299\";}s:7:\"banners\";a:1:{s:2:\"1x\";s:70:\"https://ps.w.org/wp-file-manager/assets/banner-772x250.jpg?rev=2491299\";}s:11:\"banners_rtl\";a:0:{}s:8:\"requires\";s:3:\"4.0\";}s:24:\"wordpress-seo/wp-seo.php\";O:8:\"stdClass\":10:{s:2:\"id\";s:27:\"w.org/plugins/wordpress-seo\";s:4:\"slug\";s:13:\"wordpress-seo\";s:6:\"plugin\";s:24:\"wordpress-seo/wp-seo.php\";s:11:\"new_version\";s:4:\"16.7\";s:3:\"url\";s:44:\"https://wordpress.org/plugins/wordpress-seo/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/plugin/wordpress-seo.16.7.zip\";s:5:\"icons\";a:3:{s:2:\"2x\";s:66:\"https://ps.w.org/wordpress-seo/assets/icon-256x256.png?rev=2363699\";s:2:\"1x\";s:58:\"https://ps.w.org/wordpress-seo/assets/icon.svg?rev=2363699\";s:3:\"svg\";s:58:\"https://ps.w.org/wordpress-seo/assets/icon.svg?rev=2363699\";}s:7:\"banners\";a:2:{s:2:\"2x\";s:69:\"https://ps.w.org/wordpress-seo/assets/banner-1544x500.png?rev=1843435\";s:2:\"1x\";s:68:\"https://ps.w.org/wordpress-seo/assets/banner-772x250.png?rev=1843435\";}s:11:\"banners_rtl\";a:2:{s:2:\"2x\";s:73:\"https://ps.w.org/wordpress-seo/assets/banner-1544x500-rtl.png?rev=1843435\";s:2:\"1x\";s:72:\"https://ps.w.org/wordpress-seo/assets/banner-772x250-rtl.png?rev=1843435\";}s:8:\"requires\";s:3:\"5.6\";}}}', 'no'),
(2006, 'can_compress_scripts', '0', 'no'),
(2021, '_site_transient_update_themes', 'O:8:\"stdClass\":5:{s:12:\"last_checked\";i:1626341482;s:7:\"checked\";a:2:{s:15:\"twentytwentyone\";s:3:\"1.3\";s:12:\"wp-framework\";s:10:\"2020-02-03\";}s:8:\"response\";a:0:{}s:9:\"no_update\";a:2:{s:15:\"twentytwentyone\";a:6:{s:5:\"theme\";s:15:\"twentytwentyone\";s:11:\"new_version\";s:3:\"1.3\";s:3:\"url\";s:45:\"https://wordpress.org/themes/twentytwentyone/\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/theme/twentytwentyone.1.3.zip\";s:8:\"requires\";s:3:\"5.3\";s:12:\"requires_php\";s:3:\"5.6\";}s:12:\"wp-framework\";a:6:{s:5:\"theme\";s:12:\"wp-framework\";s:11:\"new_version\";s:5:\"0.3.6\";s:3:\"url\";s:42:\"https://wordpress.org/themes/wp-framework/\";s:7:\"package\";s:60:\"https://downloads.wordpress.org/theme/wp-framework.0.3.6.zip\";s:8:\"requires\";s:5:\"3.0.0\";s:12:\"requires_php\";b:0;}}s:12:\"translations\";a:0:{}}', 'no'),
(2005, 'https_detection_errors', 'a:0:{}', 'yes'),
(2007, 'theme_mods_twentytwentyone', 'a:2:{i:0;b:0;s:18:\"nav_menu_locations\";a:0:{}}', 'yes'),
(2012, 'pb-seo-friendly-images-dbv', '4.0.0', 'yes'),
(49, 'comment_registration', '', 'yes'),
(50, 'html_type', 'text/html', 'yes'),
(51, 'use_trackback', '0', 'yes'),
(52, 'default_role', 'subscriber', 'yes'),
(53, 'db_version', '49752', 'yes'),
(54, 'uploads_use_yearmonth_folders', '1', 'yes'),
(55, 'upload_path', '', 'yes'),
(56, 'blog_public', '1', 'yes'),
(57, 'default_link_category', '0', 'yes'),
(58, 'show_on_front', 'posts', 'yes'),
(59, 'tag_base', '/', 'yes'),
(60, 'show_avatars', '1', 'yes'),
(61, 'avatar_rating', 'G', 'yes'),
(62, 'upload_url_path', '', 'yes'),
(63, 'thumbnail_size_w', '300', 'yes'),
(64, 'thumbnail_size_h', '300', 'yes'),
(65, 'thumbnail_crop', '1', 'yes'),
(66, 'medium_size_w', '600', 'yes'),
(67, 'medium_size_h', '0', 'yes'),
(68, 'avatar_default', 'wavatar', 'yes'),
(71, 'large_size_w', '1600', 'yes'),
(72, 'large_size_h', '0', 'yes'),
(73, 'image_default_link_type', '', 'yes'),
(74, 'image_default_size', '', 'yes'),
(75, 'image_default_align', '', 'yes'),
(76, 'close_comments_for_old_posts', '', 'yes'),
(77, 'close_comments_days_old', '31', 'yes'),
(78, 'thread_comments', '1', 'yes'),
(79, 'thread_comments_depth', '5', 'yes'),
(80, 'page_comments', '', 'yes'),
(81, 'comments_per_page', '50', 'yes'),
(82, 'default_comments_page', 'newest', 'yes'),
(83, 'comment_order', 'asc', 'yes'),
(84, 'sticky_posts', 'a:0:{}', 'yes'),
(85, 'widget_categories', 'a:2:{i:2;a:4:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:12:\"hierarchical\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(86, 'widget_text', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(87, 'widget_rss', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(88, 'uninstall_plugins', 'a:8:{s:45:\"branded-login-screen/branded-login-screen.php\";a:2:{i:0;s:20:\"Branded_Login_Screen\";i:1;s:9:\"uninstall\";}s:23:\"antivirus/antivirus.php\";a:2:{i:0;s:9:\"AntiVirus\";i:1;s:9:\"uninstall\";}s:29:\"antispam-bee/antispam_bee.php\";a:2:{i:0;s:12:\"Antispam_Bee\";i:1;s:9:\"uninstall\";}s:41:\"better-wp-security/better-wp-security.php\";a:2:{i:0;s:10:\"ITSEC_Core\";i:1;s:12:\"on_uninstall\";}s:49:\"pb-seo-friendly-images/pb-seo-friendly-images.php\";a:2:{i:0;s:19:\"pbSEOFriendlyImages\";i:1;s:9:\"uninstall\";}s:33:\"classic-editor/classic-editor.php\";a:2:{i:0;s:14:\"Classic_Editor\";i:1;s:9:\"uninstall\";}s:27:\"wp-optimize/wp-optimize.php\";s:21:\"wpo_uninstall_actions\";s:49:\"advanced-database-cleaner/advanced-db-cleaner.php\";s:14:\"aDBc_uninstall\";}', 'no'),
(89, 'timezone_string', 'Europe/Moscow', 'yes'),
(91, 'embed_size_w', '', 'yes'),
(92, 'embed_size_h', '600', 'yes'),
(93, 'page_for_posts', '0', 'yes'),
(94, 'page_on_front', '0', 'yes'),
(95, 'default_post_format', '0', 'yes'),
(96, 'initial_db_version', '21707', 'yes'),
(97, 'nammk_user_roles', 'a:5:{s:13:\"administrator\";a:2:{s:4:\"name\";s:13:\"Administrator\";s:12:\"capabilities\";a:62:{s:13:\"switch_themes\";b:1;s:11:\"edit_themes\";b:1;s:16:\"activate_plugins\";b:1;s:12:\"edit_plugins\";b:1;s:10:\"edit_users\";b:1;s:10:\"edit_files\";b:1;s:14:\"manage_options\";b:1;s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:6:\"import\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:8:\"level_10\";b:1;s:7:\"level_9\";b:1;s:7:\"level_8\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;s:12:\"delete_users\";b:1;s:12:\"create_users\";b:1;s:17:\"unfiltered_upload\";b:1;s:14:\"edit_dashboard\";b:1;s:14:\"update_plugins\";b:1;s:14:\"delete_plugins\";b:1;s:15:\"install_plugins\";b:1;s:13:\"update_themes\";b:1;s:14:\"install_themes\";b:1;s:11:\"update_core\";b:1;s:10:\"list_users\";b:1;s:12:\"remove_users\";b:1;s:13:\"promote_users\";b:1;s:18:\"edit_theme_options\";b:1;s:13:\"delete_themes\";b:1;s:6:\"export\";b:1;s:11:\"run_adminer\";b:1;}}s:6:\"editor\";a:2:{s:4:\"name\";s:6:\"Editor\";s:12:\"capabilities\";a:34:{s:17:\"moderate_comments\";b:1;s:17:\"manage_categories\";b:1;s:12:\"manage_links\";b:1;s:12:\"upload_files\";b:1;s:15:\"unfiltered_html\";b:1;s:10:\"edit_posts\";b:1;s:17:\"edit_others_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:10:\"edit_pages\";b:1;s:4:\"read\";b:1;s:7:\"level_7\";b:1;s:7:\"level_6\";b:1;s:7:\"level_5\";b:1;s:7:\"level_4\";b:1;s:7:\"level_3\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:17:\"edit_others_pages\";b:1;s:20:\"edit_published_pages\";b:1;s:13:\"publish_pages\";b:1;s:12:\"delete_pages\";b:1;s:19:\"delete_others_pages\";b:1;s:22:\"delete_published_pages\";b:1;s:12:\"delete_posts\";b:1;s:19:\"delete_others_posts\";b:1;s:22:\"delete_published_posts\";b:1;s:20:\"delete_private_posts\";b:1;s:18:\"edit_private_posts\";b:1;s:18:\"read_private_posts\";b:1;s:20:\"delete_private_pages\";b:1;s:18:\"edit_private_pages\";b:1;s:18:\"read_private_pages\";b:1;}}s:6:\"author\";a:2:{s:4:\"name\";s:6:\"Author\";s:12:\"capabilities\";a:10:{s:12:\"upload_files\";b:1;s:10:\"edit_posts\";b:1;s:20:\"edit_published_posts\";b:1;s:13:\"publish_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_2\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;s:22:\"delete_published_posts\";b:1;}}s:11:\"contributor\";a:2:{s:4:\"name\";s:11:\"Contributor\";s:12:\"capabilities\";a:5:{s:10:\"edit_posts\";b:1;s:4:\"read\";b:1;s:7:\"level_1\";b:1;s:7:\"level_0\";b:1;s:12:\"delete_posts\";b:1;}}s:10:\"subscriber\";a:2:{s:4:\"name\";s:10:\"Subscriber\";s:12:\"capabilities\";a:2:{s:4:\"read\";b:1;s:7:\"level_0\";b:1;}}}', 'yes'),
(98, 'widget_search', 'a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'yes'),
(99, 'widget_recent-posts', 'a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(100, 'widget_recent-comments', 'a:2:{i:2;a:2:{s:5:\"title\";s:0:\"\";s:6:\"number\";i:5;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(101, 'widget_archives', 'a:2:{i:2;a:3:{s:5:\"title\";s:0:\"\";s:5:\"count\";i:0;s:8:\"dropdown\";i:0;}s:12:\"_multiwidget\";i:1;}', 'yes'),
(102, 'widget_meta', 'a:2:{i:2;a:1:{s:5:\"title\";s:0:\"\";}s:12:\"_multiwidget\";i:1;}', 'yes'),
(103, 'sidebars_widgets', 'a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:13:\"array_version\";i:3;}', 'yes'),
(104, 'cron', 'a:19:{i:1626342050;a:1:{s:20:\"blc_cron_check_links\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"10min\";s:4:\"args\";a:0:{}s:8:\"interval\";i:600;}}}i:1626343413;a:1:{s:34:\"wp_privacy_delete_old_export_files\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1626344514;a:1:{s:24:\"aiowps_hourly_cron_event\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"hourly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:3600;}}}i:1626345922;a:1:{s:25:\"delete_expired_transients\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1626346087;a:3:{s:16:\"wp_version_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:17:\"wp_update_plugins\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}s:16:\"wp_update_themes\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1626346097;a:1:{s:19:\"wp_scheduled_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1626351113;a:1:{s:30:\"wp_scheduled_auto_draft_delete\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1626367563;a:1:{s:23:\"aiowps_daily_cron_event\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1626379200;a:1:{s:19:\"hmbkp_schedule_hook\";a:1:{s:32:\"7238d8d892636ada924d8907a1becaca\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:1:{s:2:\"id\";s:10:\"1434587998\";}s:8:\"interval\";i:86400;}}}i:1626384499;a:1:{s:18:\"wp_https_detection\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:10:\"twicedaily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:43200;}}}i:1626396139;a:1:{s:16:\"itsec_purge_logs\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1626418436;a:1:{s:32:\"recovery_mode_clean_expired_keys\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1626419186;a:1:{s:17:\"wmac_cachechecker\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1626419443;a:2:{s:28:\"blc_cron_email_notifications\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}s:29:\"blc_cron_database_maintenance\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1626420775;a:1:{s:19:\"wpseo-reindex-links\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:5:\"daily\";s:4:\"args\";a:0:{}s:8:\"interval\";i:86400;}}}i:1626427699;a:1:{s:30:\"wp_site_health_scheduled_check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}i:1626705383;a:1:{s:18:\"wpseo_onpage_fetch\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}i:1626713257;a:1:{s:40:\"health-check-scheduled-site-status-check\";a:1:{s:32:\"40cd750bba9870f18aada2478b24840a\";a:3:{s:8:\"schedule\";s:6:\"weekly\";s:4:\"args\";a:0:{}s:8:\"interval\";i:604800;}}}s:7:\"version\";i:2;}', 'yes'),
(2035, '_site_transient_timeout_available_translations', '1626352453', 'no');
INSERT INTO `nammk_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(2036, '_site_transient_available_translations', 'a:126:{s:2:\"af\";a:8:{s:8:\"language\";s:2:\"af\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-05-13 15:59:22\";s:12:\"english_name\";s:9:\"Afrikaans\";s:11:\"native_name\";s:9:\"Afrikaans\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/af.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"af\";i:2;s:3:\"afr\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:10:\"Gaan voort\";}}s:2:\"ar\";a:8:{s:8:\"language\";s:2:\"ar\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-07-08 18:29:33\";s:12:\"english_name\";s:6:\"Arabic\";s:11:\"native_name\";s:14:\"العربية\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/ar.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ar\";i:2;s:3:\"ara\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:16:\"المتابعة\";}}s:3:\"ary\";a:8:{s:8:\"language\";s:3:\"ary\";s:7:\"version\";s:6:\"4.8.17\";s:7:\"updated\";s:19:\"2017-01-26 15:42:35\";s:12:\"english_name\";s:15:\"Moroccan Arabic\";s:11:\"native_name\";s:31:\"العربية المغربية\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/translation/core/4.8.17/ary.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ar\";i:3;s:3:\"ary\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:16:\"المتابعة\";}}s:2:\"as\";a:8:{s:8:\"language\";s:2:\"as\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-14 14:01:58\";s:12:\"english_name\";s:8:\"Assamese\";s:11:\"native_name\";s:21:\"অসমীয়া\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/as.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"as\";i:2;s:3:\"asm\";i:3;s:3:\"asm\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:2:\"az\";a:8:{s:8:\"language\";s:2:\"az\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-11-06 00:09:27\";s:12:\"english_name\";s:11:\"Azerbaijani\";s:11:\"native_name\";s:16:\"Azərbaycan dili\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/4.7.2/az.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"az\";i:2;s:3:\"aze\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:5:\"Davam\";}}s:3:\"azb\";a:8:{s:8:\"language\";s:3:\"azb\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-09-12 20:34:31\";s:12:\"english_name\";s:17:\"South Azerbaijani\";s:11:\"native_name\";s:29:\"گؤنئی آذربایجان\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.7.2/azb.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"az\";i:3;s:3:\"azb\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:3:\"bel\";a:8:{s:8:\"language\";s:3:\"bel\";s:7:\"version\";s:6:\"4.9.18\";s:7:\"updated\";s:19:\"2019-10-29 07:54:22\";s:12:\"english_name\";s:10:\"Belarusian\";s:11:\"native_name\";s:29:\"Беларуская мова\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/translation/core/4.9.18/bel.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"be\";i:2;s:3:\"bel\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:20:\"Працягнуць\";}}s:5:\"bg_BG\";a:8:{s:8:\"language\";s:5:\"bg_BG\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-20 19:46:45\";s:12:\"english_name\";s:9:\"Bulgarian\";s:11:\"native_name\";s:18:\"Български\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/bg_BG.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"bg\";i:2;s:3:\"bul\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:22:\"Продължение\";}}s:5:\"bn_BD\";a:8:{s:8:\"language\";s:5:\"bn_BD\";s:7:\"version\";s:5:\"5.4.6\";s:7:\"updated\";s:19:\"2020-10-31 08:48:37\";s:12:\"english_name\";s:20:\"Bengali (Bangladesh)\";s:11:\"native_name\";s:15:\"বাংলা\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.4.6/bn_BD.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"bn\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:23:\"এগিয়ে চল.\";}}s:2:\"bo\";a:8:{s:8:\"language\";s:2:\"bo\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2020-10-30 03:24:38\";s:12:\"english_name\";s:7:\"Tibetan\";s:11:\"native_name\";s:21:\"བོད་ཡིག\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/bo.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"bo\";i:2;s:3:\"tib\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:24:\"མུ་མཐུད།\";}}s:5:\"bs_BA\";a:8:{s:8:\"language\";s:5:\"bs_BA\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-25 07:27:37\";s:12:\"english_name\";s:7:\"Bosnian\";s:11:\"native_name\";s:8:\"Bosanski\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/bs_BA.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"bs\";i:2;s:3:\"bos\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:7:\"Nastavi\";}}s:2:\"ca\";a:8:{s:8:\"language\";s:2:\"ca\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-07-06 08:29:04\";s:12:\"english_name\";s:7:\"Catalan\";s:11:\"native_name\";s:7:\"Català\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/ca.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ca\";i:2;s:3:\"cat\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continua\";}}s:3:\"ceb\";a:8:{s:8:\"language\";s:3:\"ceb\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-03-02 17:25:51\";s:12:\"english_name\";s:7:\"Cebuano\";s:11:\"native_name\";s:7:\"Cebuano\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.7.2/ceb.zip\";s:3:\"iso\";a:2:{i:2;s:3:\"ceb\";i:3;s:3:\"ceb\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:7:\"Padayun\";}}s:5:\"cs_CZ\";a:8:{s:8:\"language\";s:5:\"cs_CZ\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-30 15:14:54\";s:12:\"english_name\";s:5:\"Czech\";s:11:\"native_name\";s:9:\"Čeština\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/cs_CZ.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"cs\";i:2;s:3:\"ces\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:11:\"Pokračovat\";}}s:2:\"cy\";a:8:{s:8:\"language\";s:2:\"cy\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-15 10:32:41\";s:12:\"english_name\";s:5:\"Welsh\";s:11:\"native_name\";s:7:\"Cymraeg\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/cy.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"cy\";i:2;s:3:\"cym\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Parhau\";}}s:5:\"da_DK\";a:8:{s:8:\"language\";s:5:\"da_DK\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-07-09 08:43:53\";s:12:\"english_name\";s:6:\"Danish\";s:11:\"native_name\";s:5:\"Dansk\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/da_DK.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"da\";i:2;s:3:\"dan\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:12:\"Forts&#230;t\";}}s:5:\"de_CH\";a:8:{s:8:\"language\";s:5:\"de_CH\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-03-14 20:06:23\";s:12:\"english_name\";s:20:\"German (Switzerland)\";s:11:\"native_name\";s:17:\"Deutsch (Schweiz)\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/de_CH.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"de\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:10:\"Fortfahren\";}}s:14:\"de_CH_informal\";a:8:{s:8:\"language\";s:14:\"de_CH_informal\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-03-14 20:06:52\";s:12:\"english_name\";s:30:\"German (Switzerland, Informal)\";s:11:\"native_name\";s:21:\"Deutsch (Schweiz, Du)\";s:7:\"package\";s:73:\"https://downloads.wordpress.org/translation/core/5.7.2/de_CH_informal.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"de\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Weiter\";}}s:5:\"de_DE\";a:8:{s:8:\"language\";s:5:\"de_DE\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-07-07 23:24:00\";s:12:\"english_name\";s:6:\"German\";s:11:\"native_name\";s:7:\"Deutsch\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/de_DE.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"de\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:10:\"Fortfahren\";}}s:12:\"de_DE_formal\";a:8:{s:8:\"language\";s:12:\"de_DE_formal\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-07-07 23:23:07\";s:12:\"english_name\";s:15:\"German (Formal)\";s:11:\"native_name\";s:13:\"Deutsch (Sie)\";s:7:\"package\";s:71:\"https://downloads.wordpress.org/translation/core/5.7.2/de_DE_formal.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"de\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:10:\"Fortfahren\";}}s:5:\"de_AT\";a:8:{s:8:\"language\";s:5:\"de_AT\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-08 07:32:43\";s:12:\"english_name\";s:16:\"German (Austria)\";s:11:\"native_name\";s:21:\"Deutsch (Österreich)\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/de_AT.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"de\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Weiter\";}}s:3:\"dsb\";a:8:{s:8:\"language\";s:3:\"dsb\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-15 13:33:04\";s:12:\"english_name\";s:13:\"Lower Sorbian\";s:11:\"native_name\";s:16:\"Dolnoserbšćina\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.7.2/dsb.zip\";s:3:\"iso\";a:2:{i:2;s:3:\"dsb\";i:3;s:3:\"dsb\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:5:\"Dalej\";}}s:3:\"dzo\";a:8:{s:8:\"language\";s:3:\"dzo\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-06-29 08:59:03\";s:12:\"english_name\";s:8:\"Dzongkha\";s:11:\"native_name\";s:18:\"རྫོང་ཁ\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.7.2/dzo.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"dz\";i:2;s:3:\"dzo\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:2:\"el\";a:8:{s:8:\"language\";s:2:\"el\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-30 19:50:02\";s:12:\"english_name\";s:5:\"Greek\";s:11:\"native_name\";s:16:\"Ελληνικά\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/el.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"el\";i:2;s:3:\"ell\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:16:\"Συνέχεια\";}}s:5:\"en_GB\";a:8:{s:8:\"language\";s:5:\"en_GB\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-16 08:10:36\";s:12:\"english_name\";s:12:\"English (UK)\";s:11:\"native_name\";s:12:\"English (UK)\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/en_GB.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"en\";i:2;s:3:\"eng\";i:3;s:3:\"eng\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:5:\"en_ZA\";a:8:{s:8:\"language\";s:5:\"en_ZA\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-15 07:22:30\";s:12:\"english_name\";s:22:\"English (South Africa)\";s:11:\"native_name\";s:22:\"English (South Africa)\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/en_ZA.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"en\";i:2;s:3:\"eng\";i:3;s:3:\"eng\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:5:\"en_AU\";a:8:{s:8:\"language\";s:5:\"en_AU\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-15 04:12:40\";s:12:\"english_name\";s:19:\"English (Australia)\";s:11:\"native_name\";s:19:\"English (Australia)\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/en_AU.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"en\";i:2;s:3:\"eng\";i:3;s:3:\"eng\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:5:\"en_CA\";a:8:{s:8:\"language\";s:5:\"en_CA\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-15 04:12:51\";s:12:\"english_name\";s:16:\"English (Canada)\";s:11:\"native_name\";s:16:\"English (Canada)\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/en_CA.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"en\";i:2;s:3:\"eng\";i:3;s:3:\"eng\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:5:\"en_NZ\";a:8:{s:8:\"language\";s:5:\"en_NZ\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-15 04:12:28\";s:12:\"english_name\";s:21:\"English (New Zealand)\";s:11:\"native_name\";s:21:\"English (New Zealand)\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/en_NZ.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"en\";i:2;s:3:\"eng\";i:3;s:3:\"eng\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:2:\"eo\";a:8:{s:8:\"language\";s:2:\"eo\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-18 09:35:35\";s:12:\"english_name\";s:9:\"Esperanto\";s:11:\"native_name\";s:9:\"Esperanto\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/eo.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"eo\";i:2;s:3:\"epo\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Daŭrigi\";}}s:5:\"es_MX\";a:8:{s:8:\"language\";s:5:\"es_MX\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-16 13:07:32\";s:12:\"english_name\";s:16:\"Spanish (Mexico)\";s:11:\"native_name\";s:19:\"Español de México\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/es_MX.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_CL\";a:8:{s:8:\"language\";s:5:\"es_CL\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-14 16:02:22\";s:12:\"english_name\";s:15:\"Spanish (Chile)\";s:11:\"native_name\";s:17:\"Español de Chile\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/es_CL.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_EC\";a:8:{s:8:\"language\";s:5:\"es_EC\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-15 02:05:34\";s:12:\"english_name\";s:17:\"Spanish (Ecuador)\";s:11:\"native_name\";s:19:\"Español de Ecuador\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/es_EC.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_CO\";a:8:{s:8:\"language\";s:5:\"es_CO\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-04 22:59:08\";s:12:\"english_name\";s:18:\"Spanish (Colombia)\";s:11:\"native_name\";s:20:\"Español de Colombia\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/es_CO.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_CR\";a:8:{s:8:\"language\";s:5:\"es_CR\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-02 03:00:51\";s:12:\"english_name\";s:20:\"Spanish (Costa Rica)\";s:11:\"native_name\";s:22:\"Español de Costa Rica\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/es_CR.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_PE\";a:8:{s:8:\"language\";s:5:\"es_PE\";s:7:\"version\";s:5:\"5.6.4\";s:7:\"updated\";s:19:\"2020-12-11 02:12:59\";s:12:\"english_name\";s:14:\"Spanish (Peru)\";s:11:\"native_name\";s:17:\"Español de Perú\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.6.4/es_PE.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_PR\";a:8:{s:8:\"language\";s:5:\"es_PR\";s:7:\"version\";s:5:\"5.4.6\";s:7:\"updated\";s:19:\"2020-04-29 15:36:59\";s:12:\"english_name\";s:21:\"Spanish (Puerto Rico)\";s:11:\"native_name\";s:23:\"Español de Puerto Rico\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.4.6/es_PR.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_GT\";a:8:{s:8:\"language\";s:5:\"es_GT\";s:7:\"version\";s:6:\"5.2.11\";s:7:\"updated\";s:19:\"2019-03-02 06:35:01\";s:12:\"english_name\";s:19:\"Spanish (Guatemala)\";s:11:\"native_name\";s:21:\"Español de Guatemala\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.11/es_GT.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_AR\";a:8:{s:8:\"language\";s:5:\"es_AR\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-16 02:17:21\";s:12:\"english_name\";s:19:\"Spanish (Argentina)\";s:11:\"native_name\";s:21:\"Español de Argentina\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/es_AR.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_VE\";a:8:{s:8:\"language\";s:5:\"es_VE\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-15 02:05:15\";s:12:\"english_name\";s:19:\"Spanish (Venezuela)\";s:11:\"native_name\";s:21:\"Español de Venezuela\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/es_VE.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_UY\";a:8:{s:8:\"language\";s:5:\"es_UY\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-03-31 18:33:26\";s:12:\"english_name\";s:17:\"Spanish (Uruguay)\";s:11:\"native_name\";s:19:\"Español de Uruguay\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/es_UY.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"es_ES\";a:8:{s:8:\"language\";s:5:\"es_ES\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-10 20:43:51\";s:12:\"english_name\";s:15:\"Spanish (Spain)\";s:11:\"native_name\";s:8:\"Español\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/es_ES.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"es\";i:2;s:3:\"spa\";i:3;s:3:\"spa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:2:\"et\";a:8:{s:8:\"language\";s:2:\"et\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2020-08-12 08:38:59\";s:12:\"english_name\";s:8:\"Estonian\";s:11:\"native_name\";s:5:\"Eesti\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/et.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"et\";i:2;s:3:\"est\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Jätka\";}}s:2:\"eu\";a:8:{s:8:\"language\";s:2:\"eu\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-24 16:08:10\";s:12:\"english_name\";s:6:\"Basque\";s:11:\"native_name\";s:7:\"Euskara\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/eu.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"eu\";i:2;s:3:\"eus\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Jarraitu\";}}s:5:\"fa_IR\";a:8:{s:8:\"language\";s:5:\"fa_IR\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-28 10:15:19\";s:12:\"english_name\";s:7:\"Persian\";s:11:\"native_name\";s:10:\"فارسی\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/fa_IR.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"fa\";i:2;s:3:\"fas\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:10:\"ادامه\";}}s:5:\"fa_AF\";a:8:{s:8:\"language\";s:5:\"fa_AF\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-14 12:40:09\";s:12:\"english_name\";s:21:\"Persian (Afghanistan)\";s:11:\"native_name\";s:31:\"(فارسی (افغانستان\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/fa_AF.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"fa\";i:2;s:3:\"fas\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:10:\"ادامه\";}}s:2:\"fi\";a:8:{s:8:\"language\";s:2:\"fi\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-05-06 05:21:48\";s:12:\"english_name\";s:7:\"Finnish\";s:11:\"native_name\";s:5:\"Suomi\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/fi.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"fi\";i:2;s:3:\"fin\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:5:\"Jatka\";}}s:5:\"fr_CA\";a:8:{s:8:\"language\";s:5:\"fr_CA\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-30 13:29:35\";s:12:\"english_name\";s:15:\"French (Canada)\";s:11:\"native_name\";s:19:\"Français du Canada\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/fr_CA.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"fr\";i:2;s:3:\"fra\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuer\";}}s:5:\"fr_FR\";a:8:{s:8:\"language\";s:5:\"fr_FR\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-24 08:28:29\";s:12:\"english_name\";s:15:\"French (France)\";s:11:\"native_name\";s:9:\"Français\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/fr_FR.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"fr\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuer\";}}s:5:\"fr_BE\";a:8:{s:8:\"language\";s:5:\"fr_BE\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-02-22 13:54:46\";s:12:\"english_name\";s:16:\"French (Belgium)\";s:11:\"native_name\";s:21:\"Français de Belgique\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/fr_BE.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"fr\";i:2;s:3:\"fra\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuer\";}}s:3:\"fur\";a:8:{s:8:\"language\";s:3:\"fur\";s:7:\"version\";s:6:\"4.8.17\";s:7:\"updated\";s:19:\"2018-01-29 17:32:35\";s:12:\"english_name\";s:8:\"Friulian\";s:11:\"native_name\";s:8:\"Friulian\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/translation/core/4.8.17/fur.zip\";s:3:\"iso\";a:2:{i:2;s:3:\"fur\";i:3;s:3:\"fur\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:2:\"gd\";a:8:{s:8:\"language\";s:2:\"gd\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-08-23 17:41:37\";s:12:\"english_name\";s:15:\"Scottish Gaelic\";s:11:\"native_name\";s:9:\"Gàidhlig\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/4.7.2/gd.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"gd\";i:2;s:3:\"gla\";i:3;s:3:\"gla\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:15:\"Lean air adhart\";}}s:5:\"gl_ES\";a:8:{s:8:\"language\";s:5:\"gl_ES\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-21 09:58:55\";s:12:\"english_name\";s:8:\"Galician\";s:11:\"native_name\";s:6:\"Galego\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/gl_ES.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"gl\";i:2;s:3:\"glg\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:2:\"gu\";a:8:{s:8:\"language\";s:2:\"gu\";s:7:\"version\";s:6:\"4.9.18\";s:7:\"updated\";s:19:\"2018-09-14 12:33:48\";s:12:\"english_name\";s:8:\"Gujarati\";s:11:\"native_name\";s:21:\"ગુજરાતી\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.9.18/gu.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"gu\";i:2;s:3:\"guj\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:31:\"ચાલુ રાખવું\";}}s:3:\"haz\";a:8:{s:8:\"language\";s:3:\"haz\";s:7:\"version\";s:6:\"4.4.25\";s:7:\"updated\";s:19:\"2015-12-05 00:59:09\";s:12:\"english_name\";s:8:\"Hazaragi\";s:11:\"native_name\";s:15:\"هزاره گی\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/translation/core/4.4.25/haz.zip\";s:3:\"iso\";a:1:{i:3;s:3:\"haz\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:10:\"ادامه\";}}s:5:\"he_IL\";a:8:{s:8:\"language\";s:5:\"he_IL\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-05-28 16:42:59\";s:12:\"english_name\";s:6:\"Hebrew\";s:11:\"native_name\";s:16:\"עִבְרִית\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/he_IL.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"he\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:12:\"להמשיך\";}}s:5:\"hi_IN\";a:8:{s:8:\"language\";s:5:\"hi_IN\";s:7:\"version\";s:5:\"5.4.6\";s:7:\"updated\";s:19:\"2020-11-06 12:34:38\";s:12:\"english_name\";s:5:\"Hindi\";s:11:\"native_name\";s:18:\"हिन्दी\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.4.6/hi_IN.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"hi\";i:2;s:3:\"hin\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:12:\"जारी\";}}s:2:\"hr\";a:8:{s:8:\"language\";s:2:\"hr\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-05-13 08:03:31\";s:12:\"english_name\";s:8:\"Croatian\";s:11:\"native_name\";s:8:\"Hrvatski\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/hr.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"hr\";i:2;s:3:\"hrv\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:7:\"Nastavi\";}}s:3:\"hsb\";a:8:{s:8:\"language\";s:3:\"hsb\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-15 13:34:18\";s:12:\"english_name\";s:13:\"Upper Sorbian\";s:11:\"native_name\";s:17:\"Hornjoserbšćina\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.7.2/hsb.zip\";s:3:\"iso\";a:2:{i:2;s:3:\"hsb\";i:3;s:3:\"hsb\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:4:\"Dale\";}}s:5:\"hu_HU\";a:8:{s:8:\"language\";s:5:\"hu_HU\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-26 14:52:10\";s:12:\"english_name\";s:9:\"Hungarian\";s:11:\"native_name\";s:6:\"Magyar\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/hu_HU.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"hu\";i:2;s:3:\"hun\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:7:\"Tovább\";}}s:2:\"hy\";a:8:{s:8:\"language\";s:2:\"hy\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-12-03 16:21:10\";s:12:\"english_name\";s:8:\"Armenian\";s:11:\"native_name\";s:14:\"Հայերեն\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/4.7.2/hy.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"hy\";i:2;s:3:\"hye\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:20:\"Շարունակել\";}}s:5:\"id_ID\";a:8:{s:8:\"language\";s:5:\"id_ID\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-24 02:11:27\";s:12:\"english_name\";s:10:\"Indonesian\";s:11:\"native_name\";s:16:\"Bahasa Indonesia\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/id_ID.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"id\";i:2;s:3:\"ind\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Lanjutkan\";}}s:5:\"is_IS\";a:8:{s:8:\"language\";s:5:\"is_IS\";s:7:\"version\";s:6:\"4.9.18\";s:7:\"updated\";s:19:\"2018-12-11 10:40:02\";s:12:\"english_name\";s:9:\"Icelandic\";s:11:\"native_name\";s:9:\"Íslenska\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/4.9.18/is_IS.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"is\";i:2;s:3:\"isl\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Áfram\";}}s:5:\"it_IT\";a:8:{s:8:\"language\";s:5:\"it_IT\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-18 13:45:37\";s:12:\"english_name\";s:7:\"Italian\";s:11:\"native_name\";s:8:\"Italiano\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/it_IT.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"it\";i:2;s:3:\"ita\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continua\";}}s:2:\"ja\";a:8:{s:8:\"language\";s:2:\"ja\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-05-20 01:00:08\";s:12:\"english_name\";s:8:\"Japanese\";s:11:\"native_name\";s:9:\"日本語\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/ja.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"ja\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"続ける\";}}s:5:\"jv_ID\";a:8:{s:8:\"language\";s:5:\"jv_ID\";s:7:\"version\";s:6:\"4.9.18\";s:7:\"updated\";s:19:\"2019-02-16 23:58:56\";s:12:\"english_name\";s:8:\"Javanese\";s:11:\"native_name\";s:9:\"Basa Jawa\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/4.9.18/jv_ID.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"jv\";i:2;s:3:\"jav\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:7:\"Nutugne\";}}s:5:\"ka_GE\";a:8:{s:8:\"language\";s:5:\"ka_GE\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-07-03 08:25:10\";s:12:\"english_name\";s:8:\"Georgian\";s:11:\"native_name\";s:21:\"ქართული\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/ka_GE.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ka\";i:2;s:3:\"kat\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:30:\"გაგრძელება\";}}s:3:\"kab\";a:8:{s:8:\"language\";s:3:\"kab\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-30 20:40:17\";s:12:\"english_name\";s:6:\"Kabyle\";s:11:\"native_name\";s:9:\"Taqbaylit\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.7.2/kab.zip\";s:3:\"iso\";a:2:{i:2;s:3:\"kab\";i:3;s:3:\"kab\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuer\";}}s:2:\"kk\";a:8:{s:8:\"language\";s:2:\"kk\";s:7:\"version\";s:6:\"4.9.18\";s:7:\"updated\";s:19:\"2018-07-10 11:35:44\";s:12:\"english_name\";s:6:\"Kazakh\";s:11:\"native_name\";s:19:\"Қазақ тілі\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.9.18/kk.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"kk\";i:2;s:3:\"kaz\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:20:\"Жалғастыру\";}}s:2:\"km\";a:8:{s:8:\"language\";s:2:\"km\";s:7:\"version\";s:6:\"5.2.11\";s:7:\"updated\";s:19:\"2019-06-10 16:18:28\";s:12:\"english_name\";s:5:\"Khmer\";s:11:\"native_name\";s:27:\"ភាសាខ្មែរ\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.2.11/km.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"km\";i:2;s:3:\"khm\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:12:\"បន្ត\";}}s:2:\"kn\";a:8:{s:8:\"language\";s:2:\"kn\";s:7:\"version\";s:6:\"4.9.18\";s:7:\"updated\";s:19:\"2020-09-30 14:08:59\";s:12:\"english_name\";s:7:\"Kannada\";s:11:\"native_name\";s:15:\"ಕನ್ನಡ\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.9.18/kn.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"kn\";i:2;s:3:\"kan\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:30:\"ಮುಂದುವರೆಸಿ\";}}s:5:\"ko_KR\";a:8:{s:8:\"language\";s:5:\"ko_KR\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-07-08 04:56:41\";s:12:\"english_name\";s:6:\"Korean\";s:11:\"native_name\";s:9:\"한국어\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/ko_KR.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ko\";i:2;s:3:\"kor\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"계속\";}}s:3:\"ckb\";a:8:{s:8:\"language\";s:3:\"ckb\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-17 10:36:11\";s:12:\"english_name\";s:16:\"Kurdish (Sorani)\";s:11:\"native_name\";s:13:\"كوردی‎\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.7.2/ckb.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ku\";i:3;s:3:\"ckb\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:30:\"به‌رده‌وام به‌\";}}s:2:\"lo\";a:8:{s:8:\"language\";s:2:\"lo\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-11-12 09:59:23\";s:12:\"english_name\";s:3:\"Lao\";s:11:\"native_name\";s:21:\"ພາສາລາວ\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/4.7.2/lo.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"lo\";i:2;s:3:\"lao\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"ຕໍ່\";}}s:5:\"lt_LT\";a:8:{s:8:\"language\";s:5:\"lt_LT\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-03-23 12:35:40\";s:12:\"english_name\";s:10:\"Lithuanian\";s:11:\"native_name\";s:15:\"Lietuvių kalba\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/lt_LT.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"lt\";i:2;s:3:\"lit\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Tęsti\";}}s:2:\"lv\";a:8:{s:8:\"language\";s:2:\"lv\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-27 17:07:17\";s:12:\"english_name\";s:7:\"Latvian\";s:11:\"native_name\";s:16:\"Latviešu valoda\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/lv.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"lv\";i:2;s:3:\"lav\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Turpināt\";}}s:5:\"mk_MK\";a:8:{s:8:\"language\";s:5:\"mk_MK\";s:7:\"version\";s:5:\"5.4.6\";s:7:\"updated\";s:19:\"2020-07-01 09:16:57\";s:12:\"english_name\";s:10:\"Macedonian\";s:11:\"native_name\";s:31:\"Македонски јазик\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.4.6/mk_MK.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"mk\";i:2;s:3:\"mkd\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:16:\"Продолжи\";}}s:5:\"ml_IN\";a:8:{s:8:\"language\";s:5:\"ml_IN\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2017-01-27 03:43:32\";s:12:\"english_name\";s:9:\"Malayalam\";s:11:\"native_name\";s:18:\"മലയാളം\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/4.7.2/ml_IN.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ml\";i:2;s:3:\"mal\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:18:\"തുടരുക\";}}s:2:\"mn\";a:8:{s:8:\"language\";s:2:\"mn\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2017-01-12 07:29:35\";s:12:\"english_name\";s:9:\"Mongolian\";s:11:\"native_name\";s:12:\"Монгол\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/4.7.2/mn.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"mn\";i:2;s:3:\"mon\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:24:\"Үргэлжлүүлэх\";}}s:2:\"mr\";a:8:{s:8:\"language\";s:2:\"mr\";s:7:\"version\";s:6:\"4.9.18\";s:7:\"updated\";s:19:\"2019-11-22 15:32:08\";s:12:\"english_name\";s:7:\"Marathi\";s:11:\"native_name\";s:15:\"मराठी\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.9.18/mr.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"mr\";i:2;s:3:\"mar\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:25:\"सुरु ठेवा\";}}s:5:\"ms_MY\";a:8:{s:8:\"language\";s:5:\"ms_MY\";s:7:\"version\";s:6:\"4.9.18\";s:7:\"updated\";s:19:\"2018-08-31 11:57:07\";s:12:\"english_name\";s:5:\"Malay\";s:11:\"native_name\";s:13:\"Bahasa Melayu\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/4.9.18/ms_MY.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ms\";i:2;s:3:\"msa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Teruskan\";}}s:5:\"my_MM\";a:8:{s:8:\"language\";s:5:\"my_MM\";s:7:\"version\";s:6:\"4.2.30\";s:7:\"updated\";s:19:\"2017-12-26 11:57:10\";s:12:\"english_name\";s:17:\"Myanmar (Burmese)\";s:11:\"native_name\";s:15:\"ဗမာစာ\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/4.2.30/my_MM.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"my\";i:2;s:3:\"mya\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:54:\"ဆက်လက်လုပ်ေဆာင်ပါ။\";}}s:5:\"nb_NO\";a:8:{s:8:\"language\";s:5:\"nb_NO\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-08 06:18:21\";s:12:\"english_name\";s:19:\"Norwegian (Bokmål)\";s:11:\"native_name\";s:13:\"Norsk bokmål\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/nb_NO.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"nb\";i:2;s:3:\"nob\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Fortsett\";}}s:5:\"ne_NP\";a:8:{s:8:\"language\";s:5:\"ne_NP\";s:7:\"version\";s:6:\"5.2.11\";s:7:\"updated\";s:19:\"2020-05-31 16:07:59\";s:12:\"english_name\";s:6:\"Nepali\";s:11:\"native_name\";s:18:\"नेपाली\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.2.11/ne_NP.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ne\";i:2;s:3:\"nep\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:31:\"जारीराख्नु \";}}s:5:\"nl_BE\";a:8:{s:8:\"language\";s:5:\"nl_BE\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-18 08:55:40\";s:12:\"english_name\";s:15:\"Dutch (Belgium)\";s:11:\"native_name\";s:20:\"Nederlands (België)\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/nl_BE.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"nl\";i:2;s:3:\"nld\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Doorgaan\";}}s:5:\"nl_NL\";a:8:{s:8:\"language\";s:5:\"nl_NL\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-17 11:46:51\";s:12:\"english_name\";s:5:\"Dutch\";s:11:\"native_name\";s:10:\"Nederlands\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/nl_NL.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"nl\";i:2;s:3:\"nld\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Doorgaan\";}}s:12:\"nl_NL_formal\";a:8:{s:8:\"language\";s:12:\"nl_NL_formal\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-05-10 14:42:01\";s:12:\"english_name\";s:14:\"Dutch (Formal)\";s:11:\"native_name\";s:20:\"Nederlands (Formeel)\";s:7:\"package\";s:71:\"https://downloads.wordpress.org/translation/core/5.7.2/nl_NL_formal.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"nl\";i:2;s:3:\"nld\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Doorgaan\";}}s:5:\"nn_NO\";a:8:{s:8:\"language\";s:5:\"nn_NO\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-03-18 10:59:16\";s:12:\"english_name\";s:19:\"Norwegian (Nynorsk)\";s:11:\"native_name\";s:13:\"Norsk nynorsk\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/nn_NO.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"nn\";i:2;s:3:\"nno\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Hald fram\";}}s:3:\"oci\";a:8:{s:8:\"language\";s:3:\"oci\";s:7:\"version\";s:6:\"4.8.17\";s:7:\"updated\";s:19:\"2017-08-25 10:03:08\";s:12:\"english_name\";s:7:\"Occitan\";s:11:\"native_name\";s:7:\"Occitan\";s:7:\"package\";s:63:\"https://downloads.wordpress.org/translation/core/4.8.17/oci.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"oc\";i:2;s:3:\"oci\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Contunhar\";}}s:5:\"pa_IN\";a:8:{s:8:\"language\";s:5:\"pa_IN\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2017-01-16 05:19:43\";s:12:\"english_name\";s:7:\"Punjabi\";s:11:\"native_name\";s:18:\"ਪੰਜਾਬੀ\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/4.7.2/pa_IN.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"pa\";i:2;s:3:\"pan\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:25:\"ਜਾਰੀ ਰੱਖੋ\";}}s:5:\"pl_PL\";a:8:{s:8:\"language\";s:5:\"pl_PL\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-07-15 07:21:10\";s:12:\"english_name\";s:6:\"Polish\";s:11:\"native_name\";s:6:\"Polski\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/pl_PL.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"pl\";i:2;s:3:\"pol\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Kontynuuj\";}}s:2:\"ps\";a:8:{s:8:\"language\";s:2:\"ps\";s:7:\"version\";s:6:\"4.3.26\";s:7:\"updated\";s:19:\"2015-12-02 21:41:29\";s:12:\"english_name\";s:6:\"Pashto\";s:11:\"native_name\";s:8:\"پښتو\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.3.26/ps.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ps\";i:2;s:3:\"pus\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"دوام\";}}s:5:\"pt_AO\";a:8:{s:8:\"language\";s:5:\"pt_AO\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-05-30 09:51:29\";s:12:\"english_name\";s:19:\"Portuguese (Angola)\";s:11:\"native_name\";s:20:\"Português de Angola\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/pt_AO.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"pt\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"pt_PT\";a:8:{s:8:\"language\";s:5:\"pt_PT\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-07-09 09:41:48\";s:12:\"english_name\";s:21:\"Portuguese (Portugal)\";s:11:\"native_name\";s:10:\"Português\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/pt_PT.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"pt\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:5:\"pt_BR\";a:8:{s:8:\"language\";s:5:\"pt_BR\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-02 12:53:00\";s:12:\"english_name\";s:19:\"Portuguese (Brazil)\";s:11:\"native_name\";s:20:\"Português do Brasil\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/pt_BR.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"pt\";i:2;s:3:\"por\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:10:\"pt_PT_ao90\";a:8:{s:8:\"language\";s:10:\"pt_PT_ao90\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-15 08:18:42\";s:12:\"english_name\";s:27:\"Portuguese (Portugal, AO90)\";s:11:\"native_name\";s:17:\"Português (AO90)\";s:7:\"package\";s:69:\"https://downloads.wordpress.org/translation/core/5.7.2/pt_PT_ao90.zip\";s:3:\"iso\";a:1:{i:1;s:2:\"pt\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuar\";}}s:3:\"rhg\";a:8:{s:8:\"language\";s:3:\"rhg\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-03-16 13:03:18\";s:12:\"english_name\";s:8:\"Rohingya\";s:11:\"native_name\";s:8:\"Ruáinga\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.7.2/rhg.zip\";s:3:\"iso\";a:1:{i:3;s:3:\"rhg\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:5:\"ro_RO\";a:8:{s:8:\"language\";s:5:\"ro_RO\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-07-14 06:38:46\";s:12:\"english_name\";s:8:\"Romanian\";s:11:\"native_name\";s:8:\"Română\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/ro_RO.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ro\";i:2;s:3:\"ron\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Continuă\";}}s:5:\"ru_RU\";a:8:{s:8:\"language\";s:5:\"ru_RU\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-14 18:30:49\";s:12:\"english_name\";s:7:\"Russian\";s:11:\"native_name\";s:14:\"Русский\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/ru_RU.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ru\";i:2;s:3:\"rus\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:20:\"Продолжить\";}}s:3:\"sah\";a:8:{s:8:\"language\";s:3:\"sah\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2017-01-21 02:06:41\";s:12:\"english_name\";s:5:\"Sakha\";s:11:\"native_name\";s:14:\"Сахалыы\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.7.2/sah.zip\";s:3:\"iso\";a:2:{i:2;s:3:\"sah\";i:3;s:3:\"sah\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:12:\"Салҕаа\";}}s:3:\"snd\";a:8:{s:8:\"language\";s:3:\"snd\";s:7:\"version\";s:5:\"5.4.6\";s:7:\"updated\";s:19:\"2020-07-07 01:53:37\";s:12:\"english_name\";s:6:\"Sindhi\";s:11:\"native_name\";s:8:\"سنڌي\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.4.6/snd.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"sd\";i:2;s:3:\"snd\";i:3;s:3:\"snd\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:15:\"اڳتي هلو\";}}s:5:\"si_LK\";a:8:{s:8:\"language\";s:5:\"si_LK\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-11-12 06:00:52\";s:12:\"english_name\";s:7:\"Sinhala\";s:11:\"native_name\";s:15:\"සිංහල\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/4.7.2/si_LK.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"si\";i:2;s:3:\"sin\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:44:\"දිගටම කරගෙන යන්න\";}}s:5:\"sk_SK\";a:8:{s:8:\"language\";s:5:\"sk_SK\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-07-11 15:17:09\";s:12:\"english_name\";s:6:\"Slovak\";s:11:\"native_name\";s:11:\"Slovenčina\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/sk_SK.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"sk\";i:2;s:3:\"slk\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:12:\"Pokračovať\";}}s:3:\"skr\";a:8:{s:8:\"language\";s:3:\"skr\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-04-23 11:54:14\";s:12:\"english_name\";s:7:\"Saraiki\";s:11:\"native_name\";s:14:\"سرائیکی\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/5.7.2/skr.zip\";s:3:\"iso\";a:1:{i:3;s:3:\"skr\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:17:\"جاری رکھو\";}}s:5:\"sl_SI\";a:8:{s:8:\"language\";s:5:\"sl_SI\";s:7:\"version\";s:6:\"5.1.10\";s:7:\"updated\";s:19:\"2019-04-30 13:03:56\";s:12:\"english_name\";s:9:\"Slovenian\";s:11:\"native_name\";s:13:\"Slovenščina\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/5.1.10/sl_SI.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"sl\";i:2;s:3:\"slv\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:10:\"Nadaljujte\";}}s:2:\"sq\";a:8:{s:8:\"language\";s:2:\"sq\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-05-13 15:40:47\";s:12:\"english_name\";s:8:\"Albanian\";s:11:\"native_name\";s:5:\"Shqip\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/sq.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"sq\";i:2;s:3:\"sqi\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"Vazhdo\";}}s:5:\"sr_RS\";a:8:{s:8:\"language\";s:5:\"sr_RS\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-14 19:47:34\";s:12:\"english_name\";s:7:\"Serbian\";s:11:\"native_name\";s:23:\"Српски језик\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/sr_RS.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"sr\";i:2;s:3:\"srp\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:14:\"Настави\";}}s:5:\"sv_SE\";a:8:{s:8:\"language\";s:5:\"sv_SE\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-07-02 21:27:49\";s:12:\"english_name\";s:7:\"Swedish\";s:11:\"native_name\";s:7:\"Svenska\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/sv_SE.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"sv\";i:2;s:3:\"swe\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:9:\"Fortsätt\";}}s:2:\"sw\";a:8:{s:8:\"language\";s:2:\"sw\";s:7:\"version\";s:5:\"5.3.8\";s:7:\"updated\";s:19:\"2019-10-13 15:35:35\";s:12:\"english_name\";s:7:\"Swahili\";s:11:\"native_name\";s:9:\"Kiswahili\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.3.8/sw.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"sw\";i:2;s:3:\"swa\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:7:\"Endelea\";}}s:3:\"szl\";a:8:{s:8:\"language\";s:3:\"szl\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-09-24 19:58:14\";s:12:\"english_name\";s:8:\"Silesian\";s:11:\"native_name\";s:17:\"Ślōnskŏ gŏdka\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.7.2/szl.zip\";s:3:\"iso\";a:1:{i:3;s:3:\"szl\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:13:\"Kōntynuować\";}}s:5:\"ta_IN\";a:8:{s:8:\"language\";s:5:\"ta_IN\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2017-01-27 03:22:47\";s:12:\"english_name\";s:5:\"Tamil\";s:11:\"native_name\";s:15:\"தமிழ்\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/4.7.2/ta_IN.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ta\";i:2;s:3:\"tam\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:24:\"தொடரவும்\";}}s:5:\"ta_LK\";a:8:{s:8:\"language\";s:5:\"ta_LK\";s:7:\"version\";s:6:\"4.2.30\";s:7:\"updated\";s:19:\"2015-12-03 01:07:44\";s:12:\"english_name\";s:17:\"Tamil (Sri Lanka)\";s:11:\"native_name\";s:15:\"தமிழ்\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/4.2.30/ta_LK.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ta\";i:2;s:3:\"tam\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:18:\"தொடர்க\";}}s:2:\"te\";a:8:{s:8:\"language\";s:2:\"te\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2017-01-26 15:47:39\";s:12:\"english_name\";s:6:\"Telugu\";s:11:\"native_name\";s:18:\"తెలుగు\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/4.7.2/te.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"te\";i:2;s:3:\"tel\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:30:\"కొనసాగించు\";}}s:2:\"th\";a:8:{s:8:\"language\";s:2:\"th\";s:7:\"version\";s:5:\"5.5.5\";s:7:\"updated\";s:19:\"2021-07-13 19:33:34\";s:12:\"english_name\";s:4:\"Thai\";s:11:\"native_name\";s:9:\"ไทย\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.5.5/th.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"th\";i:2;s:3:\"tha\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:15:\"ต่อไป\";}}s:2:\"tl\";a:8:{s:8:\"language\";s:2:\"tl\";s:7:\"version\";s:6:\"4.8.17\";s:7:\"updated\";s:19:\"2017-09-30 09:04:29\";s:12:\"english_name\";s:7:\"Tagalog\";s:11:\"native_name\";s:7:\"Tagalog\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.8.17/tl.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"tl\";i:2;s:3:\"tgl\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:10:\"Magpatuloy\";}}s:5:\"tr_TR\";a:8:{s:8:\"language\";s:5:\"tr_TR\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-05-23 09:26:34\";s:12:\"english_name\";s:7:\"Turkish\";s:11:\"native_name\";s:8:\"Türkçe\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/tr_TR.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"tr\";i:2;s:3:\"tur\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:5:\"Devam\";}}s:5:\"tt_RU\";a:8:{s:8:\"language\";s:5:\"tt_RU\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-11-20 20:20:50\";s:12:\"english_name\";s:5:\"Tatar\";s:11:\"native_name\";s:19:\"Татар теле\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/4.7.2/tt_RU.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"tt\";i:2;s:3:\"tat\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:17:\"дәвам итү\";}}s:3:\"tah\";a:8:{s:8:\"language\";s:3:\"tah\";s:7:\"version\";s:5:\"4.7.2\";s:7:\"updated\";s:19:\"2016-03-06 18:39:39\";s:12:\"english_name\";s:8:\"Tahitian\";s:11:\"native_name\";s:10:\"Reo Tahiti\";s:7:\"package\";s:62:\"https://downloads.wordpress.org/translation/core/4.7.2/tah.zip\";s:3:\"iso\";a:3:{i:1;s:2:\"ty\";i:2;s:3:\"tah\";i:3;s:3:\"tah\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:8:\"Continue\";}}s:5:\"ug_CN\";a:8:{s:8:\"language\";s:5:\"ug_CN\";s:7:\"version\";s:6:\"4.9.18\";s:7:\"updated\";s:19:\"2021-07-03 18:41:33\";s:12:\"english_name\";s:6:\"Uighur\";s:11:\"native_name\";s:16:\"ئۇيغۇرچە\";s:7:\"package\";s:65:\"https://downloads.wordpress.org/translation/core/4.9.18/ug_CN.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ug\";i:2;s:3:\"uig\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:26:\"داۋاملاشتۇرۇش\";}}s:2:\"uk\";a:8:{s:8:\"language\";s:2:\"uk\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-17 19:11:00\";s:12:\"english_name\";s:9:\"Ukrainian\";s:11:\"native_name\";s:20:\"Українська\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/uk.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"uk\";i:2;s:3:\"ukr\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:20:\"Продовжити\";}}s:2:\"ur\";a:8:{s:8:\"language\";s:2:\"ur\";s:7:\"version\";s:5:\"5.4.6\";s:7:\"updated\";s:19:\"2020-04-09 11:17:33\";s:12:\"english_name\";s:4:\"Urdu\";s:11:\"native_name\";s:8:\"اردو\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.4.6/ur.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"ur\";i:2;s:3:\"urd\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:19:\"جاری رکھیں\";}}s:5:\"uz_UZ\";a:8:{s:8:\"language\";s:5:\"uz_UZ\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-02-28 12:02:22\";s:12:\"english_name\";s:5:\"Uzbek\";s:11:\"native_name\";s:11:\"O‘zbekcha\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/uz_UZ.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"uz\";i:2;s:3:\"uzb\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:20:\"Продолжить\";}}s:2:\"vi\";a:8:{s:8:\"language\";s:2:\"vi\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-05-23 07:16:16\";s:12:\"english_name\";s:10:\"Vietnamese\";s:11:\"native_name\";s:14:\"Tiếng Việt\";s:7:\"package\";s:61:\"https://downloads.wordpress.org/translation/core/5.7.2/vi.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"vi\";i:2;s:3:\"vie\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:12:\"Tiếp tục\";}}s:5:\"zh_TW\";a:8:{s:8:\"language\";s:5:\"zh_TW\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-05-13 03:20:55\";s:12:\"english_name\";s:16:\"Chinese (Taiwan)\";s:11:\"native_name\";s:12:\"繁體中文\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/zh_TW.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"zh\";i:2;s:3:\"zho\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"繼續\";}}s:5:\"zh_CN\";a:8:{s:8:\"language\";s:5:\"zh_CN\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-06-15 12:16:10\";s:12:\"english_name\";s:15:\"Chinese (China)\";s:11:\"native_name\";s:12:\"简体中文\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/zh_CN.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"zh\";i:2;s:3:\"zho\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"继续\";}}s:5:\"zh_HK\";a:8:{s:8:\"language\";s:5:\"zh_HK\";s:7:\"version\";s:5:\"5.7.2\";s:7:\"updated\";s:19:\"2021-07-03 09:42:47\";s:12:\"english_name\";s:19:\"Chinese (Hong Kong)\";s:11:\"native_name\";s:16:\"香港中文版	\";s:7:\"package\";s:64:\"https://downloads.wordpress.org/translation/core/5.7.2/zh_HK.zip\";s:3:\"iso\";a:2:{i:1;s:2:\"zh\";i:2;s:3:\"zho\";}s:7:\"strings\";a:1:{s:8:\"continue\";s:6:\"繼續\";}}}', 'no');
INSERT INTO `nammk_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(404, 'link_manager_enabled', '0', 'yes'),
(113, 'dashboard_widget_options', 'a:4:{s:25:\"dashboard_recent_comments\";a:1:{s:5:\"items\";i:5;}s:24:\"dashboard_incoming_links\";a:5:{s:4:\"home\";s:21:\"http://wp-framework.local\";s:4:\"link\";s:97:\"http://blogsearch.google.com/blogsearch?scoring=d&partner=wordpress&q=link:http://wp-framework.local/\";s:3:\"url\";s:130:\"http://blogsearch.google.com/blogsearch_feeds?scoring=d&ie=utf-8&num=10&output=rss&partner=wordpress&q=link:http://wp-framework.local/\";s:5:\"items\";i:10;s:9:\"show_date\";b:0;}s:17:\"dashboard_primary\";a:7:{s:4:\"link\";s:26:\"http://wordpress.org/news/\";s:3:\"url\";s:31:\"http://wordpress.org/news/feed/\";s:5:\"title\";s:18:\"Блог WordPress\";s:5:\"items\";i:2;s:12:\"show_summary\";i:1;s:11:\"show_author\";i:0;s:9:\"show_date\";i:1;}s:19:\"dashboard_secondary\";a:7:{s:4:\"link\";s:28:\"http://planet.wordpress.org/\";s:3:\"url\";s:33:\"http://planet.wordpress.org/feed/\";s:5:\"title\";s:37:\"Другие новости WordPress\";s:5:\"items\";i:5;s:12:\"show_summary\";i:0;s:11:\"show_author\";i:0;s:9:\"show_date\";i:0;}}', 'yes'),
(657, 'theme_mods_wp-easy-master', 'a:2:{i:0;b:0;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1422713825;s:4:\"data\";a:2:{s:19:\"wp_inactive_widgets\";a:0:{}s:11:\"widgetArea1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}}}}', 'yes'),
(652, 'theme_mods_twentyfourteen', 'a:2:{i:0;b:0;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1395701065;s:4:\"data\";a:4:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:9:\"sidebar-2\";a:0:{}s:9:\"sidebar-3\";N;}}}', 'yes'),
(146, 'recently_activated', 'a:2:{s:27:\"wp-optimize/wp-optimize.php\";i:1626341640;s:27:\"ari-adminer/ari-adminer.php\";i:1626341510;}', 'yes'),
(709, 'wp-sxd_version', '1.2', 'yes'),
(411, 'theme_mods_twentyeleven', 'a:1:{s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1356130367;s:4:\"data\";a:6:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:9:\"sidebar-2\";a:0:{}s:9:\"sidebar-3\";a:0:{}s:9:\"sidebar-4\";a:0:{}s:9:\"sidebar-5\";a:0:{}}}}', 'yes'),
(412, 'current_theme', 'Twenty Twenty-One', 'yes'),
(413, 'theme_mods_twentytwelve', 'a:2:{i:0;b:0;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1383775628;s:4:\"data\";a:4:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:9:\"sidebar-2\";a:0:{}s:9:\"sidebar-3\";a:0:{}}}}', 'yes'),
(414, 'theme_switched', '', 'yes'),
(776, 'WPLANG', 'ru_RU', 'yes'),
(172, 'wp_spamfree_version', '2.1.1.2', 'yes'),
(173, 'spamfree_count', '0', 'yes'),
(174, 'spamfree_options', 'a:49:{s:22:\"cookie_validation_name\";s:16:\"uqnoxFttdomtDuDa\";s:21:\"cookie_validation_key\";s:16:\"hrvlnEiytgrvscqu\";s:24:\"form_validation_field_js\";s:16:\"ceCsEFxymgyudGCw\";s:22:\"form_validation_key_js\";s:16:\"AFkrBEmvekFwCDxm\";s:24:\"cookie_get_function_name\";s:0:\"\";s:24:\"cookie_set_function_name\";s:0:\"\";s:27:\"cookie_delete_function_name\";s:0:\"\";s:32:\"comment_validation_function_name\";s:0:\"\";s:15:\"last_key_update\";i:1356130082;s:8:\"wp_cache\";N;s:14:\"wp_super_cache\";N;s:20:\"block_all_trackbacks\";s:2:\"on\";s:19:\"block_all_pingbacks\";s:2:\"on\";s:21:\"use_alt_cookie_method\";N;s:26:\"use_alt_cookie_method_only\";N;s:18:\"use_captcha_backup\";N;s:26:\"use_trackback_verification\";N;s:15:\"comment_logging\";N;s:26:\"comment_logging_start_date\";i:0;s:19:\"comment_logging_all\";N;s:26:\"enhanced_comment_blacklist\";N;s:17:\"allow_proxy_users\";N;s:15:\"hide_extra_data\";N;s:20:\"form_include_website\";N;s:20:\"form_require_website\";N;s:18:\"form_include_phone\";N;s:18:\"form_require_phone\";N;s:20:\"form_include_company\";N;s:20:\"form_require_company\";N;s:27:\"form_include_drop_down_menu\";N;s:27:\"form_require_drop_down_menu\";N;s:25:\"form_drop_down_menu_title\";N;s:26:\"form_drop_down_menu_item_1\";N;s:26:\"form_drop_down_menu_item_2\";N;s:26:\"form_drop_down_menu_item_3\";N;s:26:\"form_drop_down_menu_item_4\";N;s:26:\"form_drop_down_menu_item_5\";N;s:26:\"form_drop_down_menu_item_6\";N;s:26:\"form_drop_down_menu_item_7\";N;s:26:\"form_drop_down_menu_item_8\";N;s:26:\"form_drop_down_menu_item_9\";N;s:27:\"form_drop_down_menu_item_10\";N;s:18:\"form_message_width\";N;s:19:\"form_message_height\";N;s:23:\"form_message_min_length\";N;s:22:\"form_message_recipient\";N;s:31:\"form_response_thank_you_message\";N;s:22:\"form_include_user_meta\";N;s:19:\"promote_plugin_link\";N;}', 'yes'),
(650, 'auto_core_update_notified', 'a:4:{s:4:\"type\";s:7:\"success\";s:5:\"email\";s:12:\"info@wp-framework.local\";s:7:\"version\";s:5:\"3.8.1\";s:9:\"timestamp\";i:1395700963;}', 'yes'),
(148, 'add_admin_marker_timestamp', '1352375601', 'no'),
(201, 'ddsg_language', 'Russian', 'yes'),
(202, 'ddsg_items_per_page', '50', 'yes'),
(203, 'ddsg_sm_name', '', 'yes'),
(204, 'ddsg_what_to_show', 'both', 'yes'),
(205, 'ddsg_which_first', 'posts', 'yes'),
(206, 'ddsg_post_sort_order', 'title', 'yes'),
(207, 'ddsg_page_sort_order', 'title', 'yes'),
(208, 'ddsg_comments_on_posts', '', 'yes'),
(209, 'ddsg_comments_on_pages', '', 'yes'),
(210, 'ddsg_show_zero_comments', '', 'yes'),
(211, 'ddsg_hide_future', '', 'yes'),
(212, 'ddsg_new_window', '1', 'yes'),
(213, 'ddsg_show_post_date', '', 'yes'),
(214, 'ddsg_show_page_date', '', 'yes'),
(215, 'ddsg_date_format', 'F jS, Y', 'yes'),
(216, 'ddsg_hide_protected', '1', 'yes'),
(217, 'ddsg_excluded_cats', '', 'yes'),
(218, 'ddsg_excluded_pages', '', 'yes'),
(219, 'ddsg_page_nav', '1', 'yes'),
(220, 'ddsg_page_nav_where', 'top', 'yes'),
(221, 'ddsg_xml_path', '/sitemap.xml', 'yes'),
(222, 'ddsg_xml_where', 'every', 'yes'),
(225, 'seo_friendly_images_alt', '%name %title', 'yes'),
(226, 'seo_friendly_images_title', '%title', 'yes'),
(227, 'seo_friendly_images_override', 'on', 'yes'),
(228, 'seo_friendly_images_override_title', 'off', 'yes'),
(231, 'seo_friendly_images_notice', '1', 'yes'),
(175, 'wpseo', 'a:20:{s:15:\"ms_defaults_set\";b:0;s:7:\"version\";s:6:\"12.9.1\";s:20:\"disableadvanced_meta\";b:0;s:19:\"onpage_indexability\";b:1;s:11:\"baiduverify\";s:0:\"\";s:12:\"googleverify\";s:0:\"\";s:8:\"msverify\";s:0:\"\";s:12:\"yandexverify\";s:0:\"\";s:9:\"site_type\";s:0:\"\";s:20:\"has_multiple_authors\";s:0:\"\";s:16:\"environment_type\";s:0:\"\";s:23:\"content_analysis_active\";b:1;s:23:\"keyword_analysis_active\";b:1;s:21:\"enable_admin_bar_menu\";b:1;s:26:\"enable_cornerstone_content\";b:1;s:18:\"enable_xml_sitemap\";b:1;s:24:\"enable_text_link_counter\";b:1;s:22:\"show_onboarding_notice\";b:0;s:18:\"first_activated_on\";i:1507015975;s:13:\"myyoast-oauth\";b:0;}', 'yes'),
(176, 'wpseo_titles', 'a:74:{s:10:\"title_test\";i:0;s:17:\"forcerewritetitle\";b:0;s:9:\"separator\";s:7:\"sc-dash\";s:16:\"title-home-wpseo\";s:42:\"%%sitename%% %%page%% %%sep%% %%sitedesc%%\";s:18:\"title-author-wpseo\";s:30:\"%%name%%,%%sitename%% %%page%%\";s:19:\"title-archive-wpseo\";s:38:\"%%date%% %%page%% %%sep%% %%sitename%%\";s:18:\"title-search-wpseo\";s:64:\"Вы искали %%searchphrase%% %%page%% %%sep%% %%sitename%%\";s:15:\"title-404-wpseo\";s:57:\"Страница не найдена %%sep%% %%sitename%%\";s:19:\"metadesc-home-wpseo\";s:11:\"%%excerpt%%\";s:21:\"metadesc-author-wpseo\";s:24:\"%%excerpt%% %%sitename%%\";s:22:\"metadesc-archive-wpseo\";s:24:\"%%excerpt%% %%sitename%%\";s:9:\"rssbefore\";s:0:\"\";s:8:\"rssafter\";s:73:\"Запись %%POSTLINK%% впервые появилась %%BLOGLINK%%.\";s:20:\"noindex-author-wpseo\";b:1;s:28:\"noindex-author-noposts-wpseo\";b:1;s:21:\"noindex-archive-wpseo\";b:1;s:14:\"disable-author\";b:1;s:12:\"disable-date\";b:1;s:19:\"disable-post_format\";b:0;s:18:\"disable-attachment\";b:1;s:23:\"is-media-purge-relevant\";b:0;s:20:\"breadcrumbs-404crumb\";s:0:\"\";s:29:\"breadcrumbs-display-blog-page\";b:0;s:20:\"breadcrumbs-boldlast\";b:0;s:25:\"breadcrumbs-archiveprefix\";s:0:\"\";s:18:\"breadcrumbs-enable\";b:0;s:16:\"breadcrumbs-home\";s:0:\"\";s:18:\"breadcrumbs-prefix\";s:0:\"\";s:24:\"breadcrumbs-searchprefix\";s:0:\"\";s:15:\"breadcrumbs-sep\";s:2:\"»\";s:12:\"website_name\";s:0:\"\";s:11:\"person_name\";s:0:\"\";s:11:\"person_logo\";s:0:\"\";s:14:\"person_logo_id\";i:0;s:22:\"alternate_website_name\";s:0:\"\";s:12:\"company_logo\";s:0:\"\";s:15:\"company_logo_id\";i:0;s:12:\"company_name\";s:0:\"\";s:17:\"company_or_person\";s:7:\"company\";s:25:\"company_or_person_user_id\";b:0;s:17:\"stripcategorybase\";b:1;s:10:\"title-post\";s:39:\"%%title%% %%page%% %%sep%% %%sitename%%\";s:13:\"metadesc-post\";s:11:\"%%excerpt%%\";s:12:\"noindex-post\";b:0;s:13:\"showdate-post\";b:1;s:23:\"display-metabox-pt-post\";b:1;s:23:\"post_types-post-maintax\";i:0;s:10:\"title-page\";s:39:\"%%title%% %%page%% %%sep%% %%sitename%%\";s:13:\"metadesc-page\";s:11:\"%%excerpt%%\";s:12:\"noindex-page\";b:0;s:13:\"showdate-page\";b:1;s:23:\"display-metabox-pt-page\";b:1;s:23:\"post_types-page-maintax\";i:0;s:16:\"title-attachment\";s:39:\"%%title%% %%page%% %%sep%% %%sitename%%\";s:19:\"metadesc-attachment\";s:0:\"\";s:18:\"noindex-attachment\";b:0;s:19:\"showdate-attachment\";b:0;s:29:\"display-metabox-pt-attachment\";b:1;s:29:\"post_types-attachment-maintax\";i:0;s:18:\"title-tax-category\";s:44:\"%%term_title%% %%page%% %%sep%% %%sitename%%\";s:21:\"metadesc-tax-category\";s:24:\"%%excerpt%% %%sitename%%\";s:28:\"display-metabox-tax-category\";b:1;s:20:\"noindex-tax-category\";b:1;s:18:\"title-tax-post_tag\";s:44:\"%%term_title%% %%page%% %%sep%% %%sitename%%\";s:21:\"metadesc-tax-post_tag\";s:24:\"%%excerpt%% %%sitename%%\";s:28:\"display-metabox-tax-post_tag\";b:1;s:20:\"noindex-tax-post_tag\";b:1;s:21:\"title-tax-post_format\";s:44:\"%%term_title%% %%page%% %%sep%% %%sitename%%\";s:24:\"metadesc-tax-post_format\";s:24:\"%%excerpt%% %%sitename%%\";s:31:\"display-metabox-tax-post_format\";b:0;s:23:\"noindex-tax-post_format\";b:0;s:26:\"taxonomy-category-ptparent\";s:1:\"0\";s:26:\"taxonomy-post_tag-ptparent\";s:1:\"0\";s:29:\"taxonomy-post_format-ptparent\";s:1:\"0\";}', 'yes'),
(2013, 'fm_key', 'wJ5A2ogHFRNQyIOPY6Lsx9U1r', 'yes'),
(178, 'wpseo_social', 'a:19:{s:13:\"facebook_site\";s:0:\"\";s:13:\"instagram_url\";s:0:\"\";s:12:\"linkedin_url\";s:0:\"\";s:11:\"myspace_url\";s:0:\"\";s:16:\"og_default_image\";s:0:\"\";s:19:\"og_default_image_id\";s:0:\"\";s:18:\"og_frontpage_title\";s:0:\"\";s:17:\"og_frontpage_desc\";s:0:\"\";s:18:\"og_frontpage_image\";s:0:\"\";s:21:\"og_frontpage_image_id\";s:0:\"\";s:9:\"opengraph\";b:1;s:13:\"pinterest_url\";s:0:\"\";s:15:\"pinterestverify\";s:0:\"\";s:7:\"twitter\";b:1;s:12:\"twitter_site\";s:0:\"\";s:17:\"twitter_card_type\";s:19:\"summary_large_image\";s:11:\"youtube_url\";s:0:\"\";s:13:\"wikipedia_url\";s:0:\"\";s:10:\"fbadminapp\";s:0:\"\";}', 'yes'),
(193, 'wpseo_taxonomy_meta', 'a:1:{s:13:\"link_category\";a:1:{i:2;a:1:{s:13:\"wpseo_noindex\";s:7:\"noindex\";}}}', 'yes'),
(195, 'category_children', 'a:0:{}', 'yes'),
(239, 'smcipwp_maxlenght', '170', 'yes'),
(240, 'smcipwp_showcommcount', '', 'yes'),
(248, 'sm_options', 'a:56:{s:18:\"sm_b_prio_provider\";s:41:\"GoogleSitemapGeneratorPrioByCountProvider\";s:13:\"sm_b_filename\";s:11:\"sitemap.xml\";s:10:\"sm_b_debug\";b:1;s:8:\"sm_b_xml\";b:1;s:9:\"sm_b_gzip\";b:1;s:9:\"sm_b_ping\";b:1;s:12:\"sm_b_pingmsn\";b:1;s:19:\"sm_b_manual_enabled\";b:0;s:17:\"sm_b_auto_enabled\";b:1;s:15:\"sm_b_auto_delay\";b:1;s:15:\"sm_b_manual_key\";s:32:\"b96745ccc831ceb3a5d2bb594672a608\";s:11:\"sm_b_memory\";s:0:\"\";s:9:\"sm_b_time\";i:-1;s:14:\"sm_b_max_posts\";i:-1;s:13:\"sm_b_safemode\";b:0;s:18:\"sm_b_style_default\";b:1;s:10:\"sm_b_style\";s:0:\"\";s:11:\"sm_b_robots\";b:1;s:12:\"sm_b_exclude\";a:0:{}s:17:\"sm_b_exclude_cats\";a:0:{}s:18:\"sm_b_location_mode\";s:4:\"auto\";s:20:\"sm_b_filename_manual\";s:0:\"\";s:19:\"sm_b_fileurl_manual\";s:0:\"\";s:10:\"sm_in_home\";b:1;s:11:\"sm_in_posts\";b:1;s:15:\"sm_in_posts_sub\";b:0;s:11:\"sm_in_pages\";b:1;s:10:\"sm_in_cats\";b:0;s:10:\"sm_in_arch\";b:0;s:10:\"sm_in_auth\";b:0;s:10:\"sm_in_tags\";b:0;s:9:\"sm_in_tax\";a:0:{}s:17:\"sm_in_customtypes\";a:0:{}s:13:\"sm_in_lastmod\";b:1;s:10:\"sm_cf_home\";s:5:\"daily\";s:11:\"sm_cf_posts\";s:7:\"monthly\";s:11:\"sm_cf_pages\";s:6:\"weekly\";s:10:\"sm_cf_cats\";s:6:\"weekly\";s:10:\"sm_cf_auth\";s:6:\"weekly\";s:15:\"sm_cf_arch_curr\";s:5:\"daily\";s:14:\"sm_cf_arch_old\";s:6:\"yearly\";s:10:\"sm_cf_tags\";s:6:\"weekly\";s:10:\"sm_pr_home\";d:1;s:11:\"sm_pr_posts\";d:0.59999999999999997779553950749686919152736663818359375;s:15:\"sm_pr_posts_min\";d:0.200000000000000011102230246251565404236316680908203125;s:11:\"sm_pr_pages\";d:0.59999999999999997779553950749686919152736663818359375;s:10:\"sm_pr_cats\";d:0.299999999999999988897769753748434595763683319091796875;s:10:\"sm_pr_arch\";d:0.299999999999999988897769753748434595763683319091796875;s:10:\"sm_pr_auth\";d:0.299999999999999988897769753748434595763683319091796875;s:10:\"sm_pr_tags\";d:0.299999999999999988897769753748434595763683319091796875;s:12:\"sm_i_donated\";b:1;s:17:\"sm_i_hide_donated\";b:1;s:17:\"sm_i_install_date\";i:1352379707;s:14:\"sm_i_hide_note\";b:0;s:15:\"sm_i_hide_works\";b:0;s:16:\"sm_i_hide_donors\";b:0;}', 'yes'),
(241, 'smcipwp_datemodified', '', 'yes'),
(242, 'smcipwp_perpostopt', '', 'yes'),
(249, 'sm_status', 'O:28:\"GoogleSitemapGeneratorStatus\":24:{s:10:\"_startTime\";d:1395701243.7861459255218505859375;s:8:\"_endTime\";d:1395701244.278173923492431640625;s:11:\"_hasChanged\";b:1;s:12:\"_memoryUsage\";i:42729472;s:9:\"_lastPost\";i:0;s:9:\"_lastTime\";i:0;s:8:\"_usedXml\";b:1;s:11:\"_xmlSuccess\";b:1;s:8:\"_xmlPath\";s:50:\"E:/myWorkUp/OpenServer/domains/wp-framework.local/sitemap.xml\";s:7:\"_xmlUrl\";s:26:\"http://wp-framework.local/sitemap.xml\";s:8:\"_usedZip\";b:1;s:11:\"_zipSuccess\";b:1;s:8:\"_zipPath\";s:53:\"E:/myWorkUp/OpenServer/domains/wp-framework.local/sitemap.xml.gz\";s:7:\"_zipUrl\";s:29:\"http://wp-framework.local/sitemap.xml.gz\";s:11:\"_usedGoogle\";b:1;s:10:\"_googleUrl\";s:92:\"http://www.google.com/webmasters/sitemaps/ping?sitemap=http%3A%2F%2Fwp-framework.local%2Fsitemap.xml.gz\";s:15:\"_gooogleSuccess\";b:1;s:16:\"_googleStartTime\";d:1395701243.806147098541259765625;s:14:\"_googleEndTime\";d:1395701244.0151588916778564453125;s:8:\"_usedMsn\";b:1;s:7:\"_msnUrl\";s:85:\"http://www.bing.com/webmaster/ping.aspx?siteMap=http%3A%2F%2Fwp-framework.local%2Fsitemap.xml.gz\";s:11:\"_msnSuccess\";b:1;s:13:\"_msnStartTime\";d:1395701244.0191590785980224609375;s:11:\"_msnEndTime\";d:1395701244.2751729488372802734375;}', 'no'),
(523, 'bwp_gxs_google_news', 'a:9:{s:19:\"enable_news_sitemap\";s:0:\"\";s:20:\"enable_news_keywords\";s:0:\"\";s:16:\"enable_news_ping\";s:0:\"\";s:20:\"enable_news_multicat\";s:0:\"\";s:16:\"select_news_lang\";s:2:\"ru\";s:24:\"select_news_keyword_type\";s:3:\"cat\";s:22:\"select_news_cat_action\";s:3:\"inc\";s:16:\"select_news_cats\";s:0:\"\";s:17:\"input_news_genres\";a:0:{}}', 'yes'),
(532, 'wfb_update_notification', '1', 'yes'),
(530, 'wfb_revision', '5', 'yes'),
(531, 'wfb_contact_methods', 'a:2:{i:0;s:3:\"aim\";i:1;s:3:\"yim\";}', 'yes'),
(529, 'theme_mods_wp-blanck', 'a:2:{i:0;b:0;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1395701006;s:4:\"data\";a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:13:\"widget-area-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:13:\"widget-area-2\";a:0:{}}}}', 'yes'),
(511, 'theme_mods_twentythirteen', 'a:2:{i:0;b:0;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1383778597;s:4:\"data\";a:3:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}s:9:\"sidebar-2\";a:0:{}}}}', 'yes'),
(518, 'bwp_gxs_stats', 'a:5:{s:11:\"enable_ping\";s:3:\"yes\";s:18:\"enable_ping_google\";s:3:\"yes\";s:16:\"enable_ping_bing\";s:3:\"yes\";s:10:\"enable_log\";s:3:\"yes\";s:12:\"enable_debug\";s:0:\"\";}', 'yes'),
(520, 'bwp_gxs_log', 'a:2:{s:3:\"log\";a:0:{}s:7:\"sitemap\";a:0:{}}', 'yes'),
(522, 'bwp_gxs_generator', 'a:29:{s:12:\"enable_cache\";s:3:\"yes\";s:21:\"enable_cache_auto_gen\";s:3:\"yes\";s:11:\"enable_gzip\";s:0:\"\";s:16:\"enable_php_clean\";s:3:\"yes\";s:11:\"enable_xslt\";s:3:\"yes\";s:19:\"enable_sitemap_date\";s:0:\"\";s:23:\"enable_sitemap_taxonomy\";s:3:\"yes\";s:23:\"enable_sitemap_external\";s:0:\"\";s:25:\"enable_sitemap_split_post\";s:3:\"yes\";s:21:\"enable_sitemap_author\";s:0:\"\";s:19:\"enable_sitemap_site\";s:3:\"yes\";s:12:\"enable_stats\";s:3:\"yes\";s:13:\"enable_credit\";s:3:\"yes\";s:13:\"enable_robots\";s:3:\"yes\";s:20:\"enable_global_robots\";s:0:\"\";s:10:\"enable_gmt\";s:3:\"yes\";s:23:\"input_exclude_post_type\";s:0:\"\";s:22:\"input_exclude_taxonomy\";s:8:\"post_tag\";s:15:\"input_cache_age\";s:1:\"1\";s:16:\"input_item_limit\";s:4:\"5000\";s:22:\"input_split_limit_post\";s:4:\"5000\";s:20:\"input_alt_module_dir\";s:49:\"/var/www/crazyyy/data/www/saitobaza.ru/syushukru/\";s:15:\"input_sql_limit\";s:4:\"1000\";s:17:\"input_custom_xslt\";s:0:\"\";s:16:\"select_time_type\";s:4:\"3600\";s:19:\"select_default_freq\";s:5:\"daily\";s:18:\"select_default_pri\";s:1:\"1\";s:14:\"select_min_pri\";s:3:\"0.1\";s:15:\"input_cache_dir\";s:98:\"/var/www/crazyyy/data/www/saitobaza.ru/syushukru/wp-content/plugins/bwp-google-xml-sitemaps/cache/\";}', 'yes'),
(604, 'aiowpsec_db_version', '1.9', 'yes'),
(605, 'aio_wp_security_configs', 'a:98:{s:36:\"aiowps_remove_wp_generator_meta_info\";s:1:\"1\";s:25:\"aiowps_prevent_hotlinking\";s:1:\"1\";s:28:\"aiowps_enable_login_lockdown\";s:1:\"1\";s:28:\"aiowps_allow_unlock_requests\";s:1:\"1\";s:25:\"aiowps_max_login_attempts\";i:3;s:24:\"aiowps_retry_time_period\";i:5;s:26:\"aiowps_lockout_time_length\";i:60;s:28:\"aiowps_set_generic_login_msg\";s:1:\"1\";s:26:\"aiowps_enable_email_notify\";s:0:\"\";s:20:\"aiowps_email_address\";s:19:\"aparserok@gmail.com\";s:27:\"aiowps_enable_forced_logout\";s:0:\"\";s:25:\"aiowps_logout_time_period\";s:2:\"60\";s:39:\"aiowps_enable_invalid_username_lockdown\";s:0:\"\";s:32:\"aiowps_unlock_request_secret_key\";s:20:\"olxdrti3t58m2f2k8yi0\";s:26:\"aiowps_enable_whitelisting\";s:0:\"\";s:27:\"aiowps_allowed_ip_addresses\";s:0:\"\";s:27:\"aiowps_enable_login_captcha\";s:1:\"1\";s:34:\"aiowps_enable_custom_login_captcha\";s:1:\"1\";s:25:\"aiowps_captcha_secret_key\";s:20:\"evnb4iydqjtw24ixfuh9\";s:42:\"aiowps_enable_manual_registration_approval\";s:0:\"\";s:39:\"aiowps_enable_registration_page_captcha\";s:1:\"1\";s:27:\"aiowps_enable_random_prefix\";s:0:\"\";s:31:\"aiowps_enable_automated_backups\";s:1:\"1\";s:26:\"aiowps_db_backup_frequency\";i:1;s:25:\"aiowps_db_backup_interval\";s:1:\"2\";s:26:\"aiowps_backup_files_stored\";i:10;s:32:\"aiowps_send_backup_email_address\";s:0:\"\";s:27:\"aiowps_backup_email_address\";s:19:\"aparserok@gmail.com\";s:27:\"aiowps_disable_file_editing\";s:1:\"1\";s:37:\"aiowps_prevent_default_wp_file_access\";s:1:\"1\";s:22:\"aiowps_system_log_file\";s:9:\"error_log\";s:26:\"aiowps_enable_blacklisting\";s:0:\"\";s:26:\"aiowps_banned_ip_addresses\";s:0:\"\";s:28:\"aiowps_enable_basic_firewall\";s:1:\"1\";s:31:\"aiowps_enable_pingback_firewall\";s:1:\"1\";s:26:\"aiowps_disable_index_views\";s:1:\"1\";s:30:\"aiowps_disable_trace_and_track\";s:1:\"1\";s:28:\"aiowps_forbid_proxy_comments\";s:1:\"1\";s:29:\"aiowps_deny_bad_query_strings\";s:1:\"1\";s:34:\"aiowps_advanced_char_string_filter\";s:1:\"1\";s:25:\"aiowps_enable_5g_firewall\";s:1:\"1\";s:25:\"aiowps_enable_404_logging\";s:0:\"\";s:28:\"aiowps_enable_404_IP_lockout\";s:0:\"\";s:30:\"aiowps_404_lockout_time_length\";s:2:\"60\";s:28:\"aiowps_404_lock_redirect_url\";s:16:\"http://127.0.0.1\";s:31:\"aiowps_enable_rename_login_page\";s:0:\"\";s:28:\"aiowps_enable_login_honeypot\";s:1:\"1\";s:43:\"aiowps_enable_brute_force_attack_prevention\";s:0:\"\";s:30:\"aiowps_brute_force_secret_word\";s:0:\"\";s:24:\"aiowps_cookie_brute_test\";s:29:\"aiowps_cookie_test_iba7hg8tzh\";s:44:\"aiowps_cookie_based_brute_force_redirect_url\";s:16:\"http://127.0.0.1\";s:59:\"aiowps_brute_force_attack_prevention_pw_protected_exception\";s:0:\"\";s:51:\"aiowps_brute_force_attack_prevention_ajax_exception\";s:0:\"\";s:19:\"aiowps_site_lockout\";s:0:\"\";s:23:\"aiowps_site_lockout_msg\";s:0:\"\";s:30:\"aiowps_enable_spambot_blocking\";s:1:\"1\";s:29:\"aiowps_enable_comment_captcha\";s:1:\"1\";s:32:\"aiowps_enable_automated_fcd_scan\";s:1:\"1\";s:25:\"aiowps_fcd_scan_frequency\";i:2;s:24:\"aiowps_fcd_scan_interval\";s:1:\"2\";s:28:\"aiowps_fcd_exclude_filetypes\";s:0:\"\";s:24:\"aiowps_fcd_exclude_files\";s:5:\"cache\";s:26:\"aiowps_send_fcd_scan_email\";s:1:\"1\";s:29:\"aiowps_fcd_scan_email_address\";s:19:\"aparserok@gmail.com\";s:27:\"aiowps_fcds_change_detected\";b:0;s:22:\"aiowps_copy_protection\";s:0:\"\";s:40:\"aiowps_prevent_site_display_inside_frame\";s:0:\"\";s:35:\"aiowps_enable_lost_password_captcha\";s:1:\"1\";s:23:\"aiowps_last_backup_time\";s:19:\"2020-02-03 16:22:23\";s:25:\"aiowps_last_fcd_scan_time\";s:19:\"2020-02-03 16:22:28\";s:19:\"aiowps_enable_debug\";s:0:\"\";s:34:\"aiowps_block_debug_log_file_access\";s:1:\"1\";s:25:\"aiowps_enable_6g_firewall\";s:1:\"1\";s:26:\"aiowps_enable_custom_rules\";s:0:\"\";s:19:\"aiowps_custom_rules\";s:0:\"\";s:31:\"aiowps_enable_autoblock_spam_ip\";s:1:\"1\";s:33:\"aiowps_spam_ip_min_comments_block\";i:3;s:32:\"aiowps_prevent_users_enumeration\";s:0:\"\";s:43:\"aiowps_instantly_lockout_specific_usernames\";a:0:{}s:35:\"aiowps_lockdown_enable_whitelisting\";s:0:\"\";s:36:\"aiowps_lockdown_allowed_ip_addresses\";s:0:\"\";s:35:\"aiowps_enable_registration_honeypot\";s:0:\"\";s:38:\"aiowps_disable_xmlrpc_pingback_methods\";s:0:\"\";s:28:\"aiowps_block_fake_googlebots\";s:1:\"1\";s:26:\"aiowps_cookie_test_success\";s:1:\"1\";s:31:\"aiowps_enable_woo_login_captcha\";s:1:\"1\";s:34:\"aiowps_enable_woo_register_captcha\";s:1:\"1\";s:38:\"aiowps_enable_woo_lostpassword_captcha\";s:1:\"1\";s:25:\"aiowps_recaptcha_site_key\";s:0:\"\";s:27:\"aiowps_recaptcha_secret_key\";s:0:\"\";s:24:\"aiowps_default_recaptcha\";s:0:\"\";s:19:\"aiowps_fcd_filename\";s:26:\"aiowps_fcd_data_ml5x64pna5\";s:27:\"aiowps_max_file_upload_size\";s:2:\"10\";s:32:\"aiowps_place_custom_rules_at_top\";s:0:\"\";s:33:\"aiowps_enable_bp_register_captcha\";s:0:\"\";s:35:\"aiowps_enable_bbp_new_topic_captcha\";s:0:\"\";s:42:\"aiowps_disallow_unauthorized_rest_requests\";s:0:\"\";s:25:\"aiowps_ip_retrieve_method\";s:1:\"0\";}', 'yes'),
(611, 'limit_login_client_type', 'REMOTE_ADDR', 'yes'),
(612, 'limit_login_allowed_retries', '4', 'yes'),
(613, 'limit_login_lockout_duration', '1200', 'yes'),
(614, 'limit_login_allowed_lockouts', '4', 'yes'),
(615, 'limit_login_long_duration', '86400', 'yes'),
(616, 'limit_login_valid_duration', '43200', 'yes'),
(617, 'limit_login_lockout_notify', 'log,email', 'yes'),
(618, 'limit_login_notify_email_after', '4', 'yes'),
(619, 'limit_login_cookies', '1', 'yes'),
(712, 'dl_robots_option', 'Allow: /wp-content/uploads/\r\nDisallow: /wp-login.php\r\nDisallow: /wp-register.php\r\nDisallow: /xmlrpc.php\r\nDisallow: /template.html\r\nDisallow: /wp-content/\r\nDisallow: /tag/\r\nDisallow: /category/\r\nDisallow: /archive/\r\nDisallow: */trackback/\r\nDisallow: */feed/\r\nDisallow: */comments/\r\nDisallow: /?feed=\r\nDisallow: /?s=\r\nSitemap: http://wp-framework.local/sitemap_index.xml', 'yes'),
(1684, 'wbcr_clearfy_ga_cache', '0', 'yes'),
(1685, 'wbcr_clearfy_ga_tracking_id', '', 'yes'),
(1346, 'widget_media_audio', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(1347, 'widget_media_image', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(1348, 'widget_media_video', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(790, 'theme_mods_twentyfifteen', 'a:2:{i:0;b:0;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1428927025;s:4:\"data\";a:2:{s:19:\"wp_inactive_widgets\";a:0:{}s:9:\"sidebar-1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}}}}', 'yes'),
(835, 'theme_mods_wp-framework', 'a:3:{i:0;b:0;s:18:\"custom_css_post_id\";i:-1;s:16:\"sidebars_widgets\";a:2:{s:4:\"time\";i:1626341313;s:4:\"data\";a:2:{s:19:\"wp_inactive_widgets\";a:0:{}s:11:\"widgetarea1\";a:6:{i:0;s:8:\"search-2\";i:1;s:14:\"recent-posts-2\";i:2;s:17:\"recent-comments-2\";i:3;s:10:\"archives-2\";i:4;s:12:\"categories-2\";i:5;s:6:\"meta-2\";}}}}', 'yes'),
(937, 'hmbkp_schedule_1434587998', 'a:7:{s:11:\"max_backups\";i:7;s:8:\"excludes\";a:0:{}s:4:\"type\";s:8:\"database\";s:12:\"reoccurrence\";s:5:\"daily\";s:19:\"schedule_start_time\";d:1434657600;s:14:\"duration_total\";d:4500117172;s:16:\"backup_run_count\";i:3;}', 'yes'),
(939, 'hmbkp_plugin_version', '3.6.4', 'yes'),
(993, 'p3_notices', 'a:0:{}', 'yes'),
(1004, 'p3_scan_', '{\"url\":\"\\/wp-admin\\/admin-ajax.php\",\"ip\":\"127.0.0.1\",\"pid\":10812,\"date\":\"2015-06-18T00:47:06+00:00\",\"theme_name\":\"D:\\\\Works\\\\Verstka\\\\wp-framework\\\\wordpress\\\\wp-content\\\\themes\\\\wp-framework\\\\functions.php\",\"runtime\":{\"total\":0.29789185523987,\"wordpress\":0.12375378608704,\"theme\":0.004298210144043,\"plugins\":0.089087724685669,\"profile\":0.073323011398315,\"breakdown\":{\"p3-profiler\":0.010924339294434,\"all-in-one-wp-security-and-firewall\":0.030353307723999,\"cyr3lat\":0.0012428760528564,\"htm-on-pages\":0.0047204494476318,\"optimize-db\":0.0011062622070312,\"wordpress-seo\":0.037757396697998,\"wp-sxd\":0.0029830932617188}},\"memory\":21757952,\"stacksize\":2366,\"queries\":23}\r\n', 'yes'),
(1009, 'widget_calendar', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(1010, 'widget_tag_cloud', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(1011, 'widget_nav_menu', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(1012, 'widget_pages', 'a:2:{i:1;a:0:{}s:12:\"_multiwidget\";i:1;}', 'yes'),
(1042, 'finished_splitting_shared_terms', '1', 'yes'),
(1118, 'wpseo_dismiss_recalculate', '1', 'yes'),
(1364, 'fresh_site', '0', 'yes'),
(1106, 'site_icon', '0', 'yes'),
(1107, 'medium_large_size_w', '768', 'yes'),
(1108, 'medium_large_size_h', '0', 'yes'),
(1686, 'wbcr_clearfy_ga_script_position', 'footer', 'yes'),
(1687, 'wbcr_clearfy_ga_adjusted_bounce_rate', '0', 'yes'),
(1688, 'wbcr_clearfy_ga_enqueue_order', '0', 'yes'),
(1689, 'wbcr_clearfy_ga_disable_display_features', '0', 'yes'),
(1690, 'wbcr_clearfy_ga_anonymize_ip', '0', 'yes'),
(1691, 'wbcr_clearfy_ga_track_admin', '0', 'yes'),
(1692, 'wbcr_clearfy_lazy_load_google_fonts', '1', 'yes'),
(1463, 'hmbkp_notices', 'a:1:{s:13:\"backup_errors\";a:1:{i:0;s:210:\"php: ZipArchive::close(): Renaming temporary file failed: Invalid argument, C:\\Users\\crazyyy\\wp-framework\\wordpress\\wp-content\\plugins\\backupwordpress\\classes\\backup\\class-backup-engine-file-zip-archive.php, 46\";}}', 'yes'),
(1287, 'acf_version', '5.8.7', 'yes'),
(1304, 'acf_pro_license', 'YToyOntzOjM6ImtleSI7czo3MjoiYjNKa1pYSmZhV1E5TnpZMU9UaDhkSGx3WlQxa1pYWmxiRzl3WlhKOFpHRjBaVDB5TURFMkxUQXpMVEExSURFek9qUXdPalF4IjtzOjM6InVybCI7czoyNToiaHR0cDovL3dwLWZyYW1ld29yay5sb2NhbCI7fQ==', 'yes'),
(1825, 'wpo_cache_config', 'a:16:{s:19:\"enable_page_caching\";b:0;s:23:\"page_cache_length_value\";i:24;s:22:\"page_cache_length_unit\";s:5:\"hours\";s:17:\"page_cache_length\";i:86400;s:20:\"cache_exception_urls\";a:0:{}s:23:\"cache_exception_cookies\";a:0:{}s:30:\"cache_exception_browser_agents\";a:0:{}s:22:\"enable_sitemap_preload\";b:0;s:23:\"enable_schedule_preload\";b:0;s:21:\"preload_schedule_type\";s:0:\"\";s:21:\"enable_mobile_caching\";b:0;s:19:\"enable_user_caching\";b:0;s:8:\"site_url\";s:20:\"https://wp-framework.local/\";s:24:\"enable_cache_per_country\";b:0;s:17:\"wpo_cache_cookies\";a:0:{}s:25:\"wpo_cache_query_variables\";a:0:{}}', 'yes'),
(1420, 'widget_custom_html', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(1466, 'wp-optimize-enable-auto-backup', 'false', 'yes'),
(1457, 'fakerpress-plugin-options', 'a:1:{s:5:\"500px\";a:1:{s:3:\"key\";s:40:\"UBHtxibZdthje2lI4Dai9urqiUrUTYMBqCbPCF4R\";}}', 'yes'),
(1504, 'wpseo_license_server_version', '2', 'yes'),
(2009, 'blc_installation_log', 'a:68:{i:0;a:3:{i:0;i:1;i:1;s:40:\"Plugin activated at 2021-07-15 12:30:04.\";i:2;N;}i:1;a:3:{i:0;i:1;i:1;s:27:\"Installation/update begins.\";i:2;N;}i:2;a:3:{i:0;i:1;i:1;s:25:\"Upgrading the database...\";i:2;N;}i:3;a:3:{i:0;i:1;i:1;s:31:\"... SHOW TABLES (0.001 seconds)\";i:2;N;}i:4;a:3:{i:0;i:1;i:1;s:58:\"... SHOW FULL COLUMNS FROM nammk_blc_filters 0.001 seconds\";i:2;N;}i:5;a:3:{i:0;i:1;i:1;s:51:\"... SHOW INDEX FROM nammk_blc_filters 0.000 seconds\";i:2;N;}i:6;a:3:{i:0;i:1;i:1;s:60:\"... SHOW FULL COLUMNS FROM nammk_blc_instances 0.000 seconds\";i:2;N;}i:7;a:3:{i:0;i:1;i:1;s:53:\"... SHOW INDEX FROM nammk_blc_instances 0.000 seconds\";i:2;N;}i:8;a:3:{i:0;i:1;i:1;s:56:\"... SHOW FULL COLUMNS FROM nammk_blc_links 0.001 seconds\";i:2;N;}i:9;a:3:{i:0;i:1;i:1;s:49:\"... SHOW INDEX FROM nammk_blc_links 0.000 seconds\";i:2;N;}i:10;a:3:{i:0;i:1;i:1;s:56:\"... SHOW FULL COLUMNS FROM nammk_blc_synch 0.000 seconds\";i:2;N;}i:11;a:3:{i:0;i:1;i:1;s:49:\"... SHOW INDEX FROM nammk_blc_synch 0.000 seconds\";i:2;N;}i:12;a:3:{i:0;i:1;i:1;s:106:\" [OK] ALTER TABLE `nammk_blc_instances` MODIFY COLUMN `link_text` text NOT NULL DEFAULT \'\' (0.001 seconds)\";i:2;N;}i:13;a:3:{i:0;i:1;i:1;s:32:\"Schema update took 0.006 seconds\";i:2;N;}i:14;a:3:{i:0;i:1;i:1;s:24:\"Database schema updated.\";i:2;N;}i:15;a:3:{i:0;i:1;i:1;s:31:\"Database successfully upgraded.\";i:2;N;}i:16;a:3:{i:0;i:1;i:1;s:24:\"--- Total: 0.008 seconds\";i:2;N;}i:17;a:3:{i:0;i:1;i:1;s:27:\"Cleaning up the database...\";i:2;N;}i:18;a:3:{i:0;i:1;i:1;s:38:\"... Deleting invalid container records\";i:2;N;}i:19;a:3:{i:0;i:0;i:1;s:44:\"... 0 synch records deleted in 0.000 seconds\";i:2;N;}i:20;a:3:{i:0;i:1;i:1;s:35:\"... Deleting invalid link instances\";i:2;N;}i:21;a:3:{i:0;i:0;i:1;s:40:\"... 0 instances deleted in 0.000 seconds\";i:2;N;}i:22;a:3:{i:0;i:0;i:1;s:45:\"... 0 more instances deleted in 0.000 seconds\";i:2;N;}i:23;a:3:{i:0;i:1;i:1;s:27:\"... Deleting orphaned links\";i:2;N;}i:24;a:3:{i:0;i:0;i:1;s:36:\"... 0 links deleted in 0.000 seconds\";i:2;N;}i:25;a:3:{i:0;i:1;i:1;s:24:\"--- Total: 0.001 seconds\";i:2;N;}i:26;a:3:{i:0;i:1;i:1;s:20:\"Notifying modules...\";i:2;N;}i:27;a:3:{i:0;i:0;i:1;s:25:\"... Updating module cache\";i:2;N;}i:28;a:3:{i:0;i:1;i:1;s:36:\"... Cache refresh took 0.009 seconds\";i:2;N;}i:29;a:3:{i:0;i:0;i:1;s:19:\"... Loading modules\";i:2;N;}i:30;a:3:{i:0;i:1;i:1;s:37:\"... 4 modules loaded in 0.002 seconds\";i:2;N;}i:31;a:3:{i:0;i:0;i:1;s:27:\"... Notifying module \"http\"\";i:2;N;}i:32;a:3:{i:0;i:0;i:1;s:27:\"... Notifying module \"link\"\";i:2;N;}i:33;a:3:{i:0;i:0;i:1;s:28:\"... Notifying module \"image\"\";i:2;N;}i:34;a:3:{i:0;i:0;i:1;s:31:\"... Notifying module \"metadata\"\";i:2;N;}i:35;a:3:{i:0;i:0;i:1;s:32:\"... Notifying module \"url_field\"\";i:2;N;}i:36;a:3:{i:0;i:0;i:1;s:30:\"... Notifying module \"comment\"\";i:2;N;}i:37;a:3:{i:0;i:0;i:1;s:51:\"...... Deleting synch. records for removed comments\";i:2;N;}i:38;a:3:{i:0;i:0;i:1;s:38:\"...... 0 rows deleted in 0.001 seconds\";i:2;N;}i:39;a:3:{i:0;i:0;i:1;s:47:\"...... Creating synch. records for new comments\";i:2;N;}i:40;a:3:{i:0;i:0;i:1;s:39:\"...... 0 rows inserted in 0.000 seconds\";i:2;N;}i:41;a:3:{i:0;i:0;i:1;s:26:\"... Notifying module \"acf\"\";i:2;N;}i:42;a:3:{i:0;i:0;i:1;s:27:\"... Notifying module \"post\"\";i:2;N;}i:43;a:3:{i:0;i:0;i:1;s:74:\"...... Deleting synch records for removed posts & post with invalid status\";i:2;N;}i:44;a:3:{i:0;i:0;i:1;s:81:\"DELETE synch.* FROM nammk_blc_synch AS synch WHERE synch.container_id NOT IN (\'\')\";i:2;N;}i:45;a:3:{i:0;i:0;i:1;s:38:\"...... 0 rows deleted in 0.001 seconds\";i:2;N;}i:46;a:3:{i:0;i:0;i:1;s:41:\"...... Marking changed posts as unsynched\";i:2;N;}i:47;a:3:{i:0;i:0;i:1;s:226:\"UPDATE\n					nammk_blc_synch AS synch\n					JOIN nammk_posts AS posts ON (synch.container_id = posts.ID and synch.container_type=posts.post_type)\n				  SET\n					synched = 0\n				  WHERE\n					synch.last_synch < posts.post_modified\";i:2;N;}i:48;a:3:{i:0;i:0;i:1;s:38:\"...... 0 rows updated in 0.008 seconds\";i:2;N;}i:49;a:3:{i:0;i:0;i:1;s:43:\"...... Creating synch records for new posts\";i:2;N;}i:50;a:3:{i:0;i:0;i:1;s:398:\"INSERT INTO nammk_blc_synch(container_id, container_type, synched)\n				  SELECT posts.id, posts.post_type, 0\n				  FROM\n				    nammk_posts AS posts LEFT JOIN nammk_blc_synch AS synch\n					ON (synch.container_id = posts.ID and synch.container_type=posts.post_type)\n				  WHERE\n				  	posts.post_status IN (\'publish\')\n	 				AND posts.post_type IN (\'post\', \'page\')\n					AND synch.container_id IS NULL\";i:2;N;}i:51;a:3:{i:0;i:0;i:1;s:39:\"...... 0 rows inserted in 0.000 seconds\";i:2;N;}i:52;a:3:{i:0;i:0;i:1;s:27:\"... Notifying module \"page\"\";i:2;N;}i:53;a:3:{i:0;i:0;i:1;s:74:\"...... Skipping \"page\" resyncyh since all post types were already synched.\";i:2;N;}i:54;a:3:{i:0;i:0;i:1;s:38:\"... Notifying module \"youtube-checker\"\";i:2;N;}i:55;a:3:{i:0;i:0;i:1;s:37:\"... Notifying module \"youtube-iframe\"\";i:2;N;}i:56;a:3:{i:0;i:0;i:1;s:28:\"... Notifying module \"dummy\"\";i:2;N;}i:57;a:3:{i:0;i:0;i:1;s:36:\"... Notifying module \"plaintext-url\"\";i:2;N;}i:58;a:3:{i:0;i:1;i:1;s:24:\"--- Total: 0.033 seconds\";i:2;N;}i:59;a:3:{i:0;i:1;i:1;s:38:\"Updating server load limit settings...\";i:2;N;}i:60;a:3:{i:0;i:1;i:1;s:26:\"Optimizing the database...\";i:2;N;}i:61;a:3:{i:0;i:1;i:1;s:24:\"--- Total: 0.074 seconds\";i:2;N;}i:62;a:3:{i:0;i:1;i:1;s:26:\"Completing installation...\";i:2;N;}i:63;a:3:{i:0;i:1;i:1;s:20:\"Configuration saved.\";i:2;N;}i:64;a:3:{i:0;i:1;i:1;s:78:\"Installation/update completed at 2021-07-15 12:30:04 with 29 queries executed.\";i:2;N;}i:65;a:3:{i:0;i:1;i:1;s:25:\"Total time: 0.139 seconds\";i:2;N;}i:66;a:3:{i:0;i:1;i:1;s:13:\"work() starts\";i:2;N;}i:67;a:3:{i:0;i:1;i:1;s:17:\"work(): All done.\";i:2;N;}}', 'yes'),
(2010, 'blc_activation_enabled', '1', 'yes'),
(2011, 'pb-seo-friendly-images', 'a:22:{s:12:\"optimize_img\";s:3:\"all\";s:11:\"sync_method\";s:4:\"both\";s:12:\"override_alt\";s:1:\"1\";s:14:\"override_title\";s:1:\"1\";s:10:\"alt_scheme\";s:14:\"%name - %title\";s:12:\"title_scheme\";s:22:\"%title %category %tags\";s:20:\"pbsfi_enable_caching\";b:0;s:24:\"pbsfi_enable_caching_ttl\";i:86400;s:15:\"enable_lazyload\";s:0:\"\";s:19:\"enable_lazyload_acf\";s:0:\"\";s:22:\"enable_lazyload_styles\";s:0:\"\";s:18:\"lazyload_threshold\";s:0:\"\";s:8:\"wc_title\";s:0:\"\";s:14:\"wc_sync_method\";s:0:\"\";s:15:\"wc_override_alt\";s:0:\"\";s:17:\"wc_override_title\";s:0:\"\";s:13:\"wc_alt_scheme\";s:0:\"\";s:15:\"wc_title_scheme\";s:0:\"\";s:14:\"disable_srcset\";s:0:\"\";s:10:\"link_title\";s:0:\"\";s:8:\"encoding\";s:0:\"\";s:13:\"encoding_mode\";s:8:\"entities\";}', 'yes'),
(1636, '_falbar_bbf_options_params', 'a:6:{s:4:\"code\";a:7:{s:21:\"remove_recentcomments\";i:1;s:13:\"disable_emoji\";i:1;s:21:\"remove_shortlink_link\";i:1;s:15:\"remove_wlw_link\";i:1;s:15:\"remove_rsd_link\";i:1;s:21:\"remove_jquery_migrate\";i:1;s:20:\"remove_html_comments\";i:1;}s:7:\"doubles\";a:5:{s:23:\"remove_attachment_pages\";i:1;s:20:\"remove_archives_date\";i:1;s:22:\"remove_post_pagination\";i:1;s:22:\"remove_archives_author\";i:1;s:17:\"remove_replytocom\";i:1;}s:3:\"seo\";a:2:{s:17:\"set_last_modified\";i:1;s:10:\"robots_txt\";a:2:{s:6:\"enable\";i:1;s:4:\"code\";s:326:\"User-agent: *\r\nDisallow: /wp-admin\r\nDisallow: /wp-includes\r\nDisallow: /wp-content/plugins\r\nDisallow: /wp-content/cache\r\nDisallow: /wp-json/\r\nDisallow: /xmlrpc.php\r\nDisallow: /readme.html\r\nDisallow: /*?\r\nDisallow: /?s=\r\nAllow: /*.css\r\nAllow: /*.js\r\nHost: wp-framework.local\r\nSitemap: http://wp-framework.local/sitemap_index.xml\";}}s:8:\"comments\";a:3:{s:28:\"remove_url_from_comment_form\";i:1;s:33:\"comment_text_convert_links_pseudo\";a:2:{s:6:\"enable\";i:0;s:5:\"style\";s:0:\"\";}s:26:\"pseudo_comment_author_link\";a:2:{s:6:\"enable\";i:0;s:5:\"style\";s:0:\"\";}}s:8:\"security\";a:7:{s:21:\"remove_meta_generator\";i:1;s:21:\"remove_readme_license\";i:1;s:17:\"hide_login_errors\";i:1;s:14:\"disable_xmlrpc\";i:1;s:17:\"remove_admin_page\";i:1;s:22:\"remove_versions_styles\";i:1;s:23:\"remove_versions_scripts\";i:1;}s:12:\"additionally\";a:5:{s:27:\"enable_hidden_settings_page\";i:1;s:17:\"disable_rss_feeds\";i:1;s:22:\"remove_links_admin_bar\";i:1;s:32:\"enable_uplode_filename_lowercase\";i:1;s:14:\"sanitize_title\";i:1;}}', 'yes'),
(1717, 'pbsfi_options', '', 'yes'),
(1632, 'wbcr_clearfy_deactive_preinstall_components', 'a:1:{i:0;s:9:\"yoast_seo\";}', 'yes'),
(1633, 'wbcr_clearfy_plugin_activated', '1567753579', 'yes'),
(1634, 'factory_plugin_versions', 'a:1:{s:12:\"wbcr_clearfy\";s:10:\"free-1.5.3\";}', 'yes'),
(1652, 'wbcr_clearfy_disable_emoji', '1', 'yes'),
(1653, 'wbcr_clearfy_remove_rsd_link', '1', 'yes'),
(1654, 'wbcr_clearfy_remove_wlw_link', '1', 'yes'),
(1655, 'wbcr_clearfy_remove_shortlink_link', '1', 'yes'),
(1656, 'wbcr_clearfy_remove_adjacent_posts_link', '1', 'yes'),
(1657, 'wbcr_clearfy_remove_recent_comments_style', '1', 'yes'),
(1658, 'wbcr_clearfy_yoast_remove_image_from_xml_sitemap', '1', 'yes'),
(1659, 'wbcr_clearfy_yoast_remove_head_comment', '1', 'yes'),
(1660, 'wbcr_clearfy_remove_meta_generator', '1', 'yes'),
(1661, 'wbcr_clearfy_remove_style_version', '1', 'yes'),
(1662, 'wbcr_clearfy_remove_js_version', '1', 'yes'),
(1664, 'wbcr_clearfy_protect_author_get', '1', 'yes'),
(1665, 'wbcr_clearfy_change_login_errors', '1', 'yes'),
(1668, 'wbcr_clearfy_disable_feed', '0', 'yes'),
(1669, 'wbcr_clearfy_disabled_feed_behaviour', 'redirect_301', 'yes'),
(1670, 'wbcr_clearfy_disable_json_rest_api', '0', 'yes'),
(1671, 'wbcr_clearfy_remove_jquery_migrate', '1', 'yes'),
(1672, 'wbcr_clearfy_disable_embeds', '0', 'yes'),
(1673, 'wbcr_clearfy_remove_xfn_link', '0', 'yes'),
(1674, 'wbcr_clearfy_lazy_load_font_awesome', '0', 'yes'),
(1675, 'wbcr_clearfy_disable_dashicons', '0', 'yes'),
(1676, 'wbcr_clearfy_disable_gravatars', '0', 'yes'),
(1677, 'wbcr_clearfy_revisions_disable', '0', 'yes'),
(1678, 'wbcr_clearfy_revision_limit', 'default', 'yes'),
(1679, 'wbcr_clearfy_gutenberg_autosave_control', '0', 'yes'),
(1680, 'wbcr_clearfy_remove_version_exclude', '', 'yes'),
(1681, 'wbcr_clearfy_disable_heartbeat', 'default', 'yes'),
(1682, 'wbcr_clearfy_heartbeat_frequency', 'default', 'yes'),
(1716, 'pbsfi_upgrade_notice', '3.1', 'no'),
(1644, 'wsblc_options', '{\"max_execution_time\":420,\"check_threshold\":72,\"recheck_count\":3,\"recheck_threshold\":1800,\"run_in_dashboard\":true,\"run_via_cron\":true,\"mark_broken_links\":true,\"broken_link_css\":\".broken_link, a.broken_link {\\r\\n\\ttext-decoration: line-through;\\r\\n}\",\"nofollow_broken_links\":false,\"mark_removed_links\":true,\"removed_link_css\":\".removed_link, a.removed_link {\\r\\n\\ttext-decoration: line-through;\\r\\n}\",\"exclusion_list\":[],\"send_email_notifications\":true,\"send_authors_email_notifications\":false,\"notification_email_address\":\"\",\"notification_schedule\":\"daily\",\"last_notification_sent\":0,\"suggestions_enabled\":true,\"warnings_enabled\":true,\"server_load_limit\":null,\"enable_load_limit\":false,\"custom_fields\":[],\"acf_fields\":[],\"enabled_post_statuses\":[\"publish\"],\"autoexpand_widget\":true,\"dashboard_widget_capability\":\"edit_others_posts\",\"show_link_count_bubble\":true,\"table_layout\":\"flexible\",\"table_compact\":true,\"table_visible_columns\":[\"new-url\",\"status\",\"used-in\",\"new-link-text\"],\"table_links_per_page\":30,\"table_color_code_status\":true,\"need_resynch\":false,\"current_db_version\":16,\"timeout\":30,\"highlight_permanent_failures\":false,\"failure_duration_threshold\":3,\"logging_enabled\":false,\"log_file\":\"\",\"incorrect_path\":false,\"clear_log_on\":\"\",\"custom_log_file_enabled\":false,\"installation_complete\":true,\"installation_flag_cleared_on\":\"2021-07-15T09:30:04+00:00 (1626341404.1098)\",\"installation_flag_set_on\":\"2021-07-15T09:30:04+00:00 (1626341404.2475)\",\"user_has_donated\":false,\"donation_flag_fixed\":false,\"show_link_actions\":{\"edit\":true,\"delete\":true,\"blc-discard-action\":true,\"blc-dismiss-action\":true,\"blc-recheck-action\":true,\"blc-deredirect-action\":true},\"youtube_api_key\":\"\",\"blc_post_modified\":\"\",\"first_installation_timestamp\":1567753840,\"active_modules\":{\"http\":{\"ModuleID\":\"http\",\"ModuleCategory\":\"checker\",\"ModuleContext\":\"on-demand\",\"ModuleLazyInit\":true,\"ModuleClassName\":\"blcHttpChecker\",\"ModulePriority\":-1,\"ModuleCheckerUrlPattern\":\"\",\"ModuleHidden\":false,\"ModuleAlwaysActive\":false,\"ModuleRequiresPro\":false,\"Name\":\"Basic HTTP\",\"PluginURI\":\"\",\"Version\":\"1.0\",\"Description\":\"Check all links that have the HTTP\\/HTTPS protocol.\",\"Author\":\"Janis Elsts\",\"AuthorURI\":\"\",\"TextDomain\":\"broken-link-checker\",\"DomainPath\":\"\",\"Network\":false,\"RequiresWP\":\"\",\"RequiresPHP\":\"\",\"Title\":\"Basic HTTP\",\"AuthorName\":\"Janis Elsts\",\"file\":\"checkers\\/http.php\"},\"link\":{\"ModuleID\":\"link\",\"ModuleCategory\":\"parser\",\"ModuleContext\":\"on-demand\",\"ModuleLazyInit\":true,\"ModuleClassName\":\"blcHTMLLink\",\"ModulePriority\":1000,\"ModuleCheckerUrlPattern\":\"\",\"ModuleHidden\":false,\"ModuleAlwaysActive\":false,\"ModuleRequiresPro\":false,\"Name\":\"HTML links\",\"PluginURI\":\"\",\"Version\":\"1.0\",\"Description\":\"Example : <code>&lt;a href=\\\"http:\\/\\/example.com\\/\\\"&gt;link text&lt;\\/a&gt;<\\/code>\",\"Author\":\"Janis Elsts\",\"AuthorURI\":\"\",\"TextDomain\":\"broken-link-checker\",\"DomainPath\":\"\",\"Network\":false,\"RequiresWP\":\"\",\"RequiresPHP\":\"\",\"Title\":\"HTML links\",\"AuthorName\":\"Janis Elsts\",\"file\":\"parsers\\/html_link.php\"},\"image\":{\"ModuleID\":\"image\",\"ModuleCategory\":\"parser\",\"ModuleContext\":\"on-demand\",\"ModuleLazyInit\":true,\"ModuleClassName\":\"blcHTMLImage\",\"ModulePriority\":900,\"ModuleCheckerUrlPattern\":\"\",\"ModuleHidden\":false,\"ModuleAlwaysActive\":false,\"ModuleRequiresPro\":false,\"Name\":\"HTML images\",\"PluginURI\":\"\",\"Version\":\"1.0\",\"Description\":\"e.g. <code>&lt;img src=\\\"http:\\/\\/example.com\\/fluffy.jpg\\\"&gt;<\\/code>\",\"Author\":\"Janis Elsts\",\"AuthorURI\":\"\",\"TextDomain\":\"broken-link-checker\",\"DomainPath\":\"\",\"Network\":false,\"RequiresWP\":\"\",\"RequiresPHP\":\"\",\"Title\":\"HTML images\",\"AuthorName\":\"Janis Elsts\",\"file\":\"parsers\\/image.php\"},\"metadata\":{\"ModuleID\":\"metadata\",\"ModuleCategory\":\"parser\",\"ModuleContext\":\"on-demand\",\"ModuleLazyInit\":true,\"ModuleClassName\":\"blcMetadataParser\",\"ModulePriority\":0,\"ModuleCheckerUrlPattern\":\"\",\"ModuleHidden\":true,\"ModuleAlwaysActive\":true,\"ModuleRequiresPro\":false,\"Name\":\"Metadata\",\"PluginURI\":\"\",\"Version\":\"1.0\",\"Description\":\"Parses metadata (AKA custom fields)\",\"Author\":\"Janis Elsts\",\"AuthorURI\":\"\",\"TextDomain\":\"broken-link-checker\",\"DomainPath\":\"\",\"Network\":false,\"RequiresWP\":\"\",\"RequiresPHP\":\"\",\"Title\":\"Metadata\",\"AuthorName\":\"Janis Elsts\",\"file\":\"parsers\\/metadata.php\"},\"url_field\":{\"ModuleID\":\"url_field\",\"ModuleCategory\":\"parser\",\"ModuleContext\":\"on-demand\",\"ModuleLazyInit\":true,\"ModuleClassName\":\"blcUrlField\",\"ModulePriority\":0,\"ModuleCheckerUrlPattern\":\"\",\"ModuleHidden\":true,\"ModuleAlwaysActive\":true,\"ModuleRequiresPro\":false,\"Name\":\"URL fields\",\"PluginURI\":\"\",\"Version\":\"1.0\",\"Description\":\"Parses data fields that contain a single, plaintext URL.\",\"Author\":\"Janis Elsts\",\"AuthorURI\":\"\",\"TextDomain\":\"broken-link-checker\",\"DomainPath\":\"\",\"Network\":false,\"RequiresWP\":\"\",\"RequiresPHP\":\"\",\"Title\":\"URL fields\",\"AuthorName\":\"Janis Elsts\",\"file\":\"parsers\\/url_field.php\"},\"comment\":{\"ModuleID\":\"comment\",\"ModuleCategory\":\"container\",\"ModuleContext\":\"all\",\"ModuleLazyInit\":false,\"ModuleClassName\":\"blcCommentManager\",\"ModulePriority\":0,\"ModuleCheckerUrlPattern\":\"\",\"ModuleHidden\":false,\"ModuleAlwaysActive\":false,\"ModuleRequiresPro\":false,\"Name\":\"Comments\",\"PluginURI\":\"\",\"Version\":\"1.0\",\"Description\":\"\",\"Author\":\"Janis Elsts\",\"AuthorURI\":\"\",\"TextDomain\":\"broken-link-checker\",\"DomainPath\":\"\",\"Network\":false,\"RequiresWP\":\"\",\"RequiresPHP\":\"\",\"Title\":\"Comments\",\"AuthorName\":\"Janis Elsts\",\"file\":\"containers\\/comment.php\"},\"acf\":{\"ModuleID\":\"acf\",\"ModuleCategory\":\"parser\",\"ModuleContext\":\"on-demand\",\"ModuleLazyInit\":true,\"ModuleClassName\":\"blcACFParser\",\"ModulePriority\":0,\"ModuleCheckerUrlPattern\":\"\",\"ModuleHidden\":true,\"ModuleAlwaysActive\":true,\"ModuleRequiresPro\":false,\"Name\":\"ACF\",\"PluginURI\":\"\",\"Version\":\"1.0\",\"Description\":\"Parses acf fields (AKA custom fields)\",\"Author\":\"Janne Aalto\",\"AuthorURI\":\"\",\"TextDomain\":\"broken-link-checker\",\"DomainPath\":\"\",\"Network\":false,\"RequiresWP\":\"\",\"RequiresPHP\":\"\",\"Title\":\"ACF\",\"AuthorName\":\"Janne Aalto\",\"file\":\"parsers\\/acf_field.php\"},\"post\":{\"Name\":\"Posts\",\"ModuleCategory\":\"container\",\"ModuleContext\":\"all\",\"ModuleClassName\":\"blcAnyPostContainerManager\",\"ModuleID\":\"post\",\"file\":\"\",\"ModuleLazyInit\":false,\"ModulePriority\":0,\"ModuleHidden\":false,\"ModuleAlwaysActive\":false,\"ModuleRequiresPro\":false,\"TextDomain\":\"broken-link-checker\",\"virtual\":true},\"page\":{\"Name\":\"Pages\",\"ModuleCategory\":\"container\",\"ModuleContext\":\"all\",\"ModuleClassName\":\"blcAnyPostContainerManager\",\"ModuleID\":\"page\",\"file\":\"\",\"ModuleLazyInit\":false,\"ModulePriority\":0,\"ModuleHidden\":false,\"ModuleAlwaysActive\":false,\"ModuleRequiresPro\":false,\"TextDomain\":\"broken-link-checker\",\"virtual\":true},\"youtube-checker\":{\"ModuleID\":\"youtube-checker\",\"ModuleCategory\":\"checker\",\"ModuleContext\":\"on-demand\",\"ModuleLazyInit\":true,\"ModuleClassName\":\"blcYouTubeChecker\",\"ModulePriority\":100,\"ModuleCheckerUrlPattern\":\"@^https?:\\/\\/(?:([\\\\w\\\\d]+\\\\.)*youtube\\\\.[^\\/]+\\/watch\\\\?.*v=[^\\/#]|youtu\\\\.be\\/[^\\/#\\\\?]+|(?:[\\\\w\\\\d]+\\\\.)*?youtube\\\\.[^\\/]+\\/(playlist|view_play_list)\\\\?[^\\/#]{15,}?)@i\",\"ModuleHidden\":false,\"ModuleAlwaysActive\":false,\"ModuleRequiresPro\":false,\"Name\":\"YouTube API\",\"PluginURI\":\"\",\"Version\":\"3\",\"Description\":\"Check links to YouTube videos and playlists using the YouTube API.\",\"Author\":\"Janis Elsts\",\"AuthorURI\":\"\",\"TextDomain\":\"broken-link-checker\",\"DomainPath\":\"\",\"Network\":false,\"RequiresWP\":\"\",\"RequiresPHP\":\"\",\"Title\":\"YouTube API\",\"AuthorName\":\"Janis Elsts\",\"file\":\"extras\\/youtube.php\"},\"youtube-iframe\":{\"ModuleID\":\"youtube-iframe\",\"ModuleCategory\":\"parser\",\"ModuleContext\":\"on-demand\",\"ModuleLazyInit\":true,\"ModuleClassName\":\"blcYouTubeIframe\",\"ModulePriority\":120,\"ModuleCheckerUrlPattern\":\"\",\"ModuleHidden\":false,\"ModuleAlwaysActive\":false,\"ModuleRequiresPro\":false,\"Name\":\"Embedded YouTube videos\",\"PluginURI\":\"\",\"Version\":\"1.0\",\"Description\":\"Parse embedded videos from YouTube\",\"Author\":\"Janis Elsts\",\"AuthorURI\":\"\",\"TextDomain\":\"broken-link-checker\",\"DomainPath\":\"\",\"Network\":false,\"RequiresWP\":\"\",\"RequiresPHP\":\"\",\"Title\":\"Embedded YouTube videos\",\"AuthorName\":\"Janis Elsts\",\"file\":\"extras\\/youtube-iframe.php\"},\"dummy\":{\"ModuleID\":\"dummy\",\"ModuleCategory\":\"container\",\"ModuleContext\":\"all\",\"ModuleLazyInit\":false,\"ModuleClassName\":\"blcDummyManager\",\"ModulePriority\":0,\"ModuleCheckerUrlPattern\":\"\",\"ModuleHidden\":true,\"ModuleAlwaysActive\":true,\"ModuleRequiresPro\":false,\"Name\":\"Dummy\",\"PluginURI\":\"\",\"Version\":\"1.0\",\"Description\":\"\",\"Author\":\"Janis Elsts\",\"AuthorURI\":\"\",\"TextDomain\":\"broken-link-checker\",\"DomainPath\":\"\",\"Network\":false,\"RequiresWP\":\"\",\"RequiresPHP\":\"\",\"Title\":\"Dummy\",\"AuthorName\":\"Janis Elsts\",\"file\":\"containers\\/dummy.php\"},\"plaintext-url\":{\"ModuleID\":\"plaintext-url\",\"ModuleCategory\":\"parser\",\"ModuleContext\":\"on-demand\",\"ModuleLazyInit\":true,\"ModuleClassName\":\"blcPlaintextURL\",\"ModulePriority\":800,\"ModuleCheckerUrlPattern\":\"\",\"ModuleHidden\":false,\"ModuleAlwaysActive\":false,\"ModuleRequiresPro\":false,\"Name\":\"Plaintext URLs\",\"PluginURI\":\"\",\"Version\":\"1.0\",\"Description\":\"Parse plaintext URLs as links\",\"Author\":\"Janis Elsts\",\"AuthorURI\":\"\",\"TextDomain\":\"broken-link-checker\",\"DomainPath\":\"\",\"Network\":false,\"RequiresWP\":\"\",\"RequiresPHP\":\"\",\"Title\":\"Plaintext URLs\",\"AuthorName\":\"Janis Elsts\",\"file\":\"extras\\/plaintext-url.php\"}},\"module_deactivated_when\":{\"custom_field\":1567764640,\"acf_field\":1567764640},\"target_resource_usage\":0.25}', 'yes'),
(1532, 'widget_media_gallery', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(1785, 'new_admin_email', 'info@wp-framework.local', 'yes'),
(1820, 'wp-optimize-compression_server', 'resmushit', 'yes'),
(1821, 'wp-optimize-image_quality', 'very_good', 'yes'),
(1822, 'wp-optimize-back_up_original', '1', 'yes'),
(1751, 'wpseo_onpage', 'a:2:{s:6:\"status\";i:-1;s:10:\"last_fetch\";i:1580740591;}', 'yes'),
(1752, 'recovery_keys', 'a:0:{}', 'yes'),
(1598, 'wp_page_for_privacy_policy', '0', 'yes'),
(1599, 'show_comments_cookies_opt_in', '1', 'yes'),
(1693, 'wbcr_clearfy_disable_google_fonts', '0', 'yes'),
(1694, 'wbcr_clearfy_disable_google_maps', '0', 'yes'),
(1695, 'wbcr_clearfy_remove_iframe_google_maps', '0', 'yes'),
(1696, 'wbcr_clearfy_exclude_from_disable_google_maps', '', 'yes'),
(1697, 'wbcr_clearfy_combined_google_fonts_requests_number', '0', 'yes');
INSERT INTO `nammk_options` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1698, 'wbcr_clearfy_combined_font_awesome_requests_number', '0', 'yes'),
(1901, 'wpcf7', 'a:2:{s:7:\"version\";s:5:\"5.1.6\";s:13:\"bulk_validate\";a:4:{s:9:\"timestamp\";i:1580751382;s:7:\"version\";s:5:\"5.1.6\";s:11:\"count_valid\";i:1;s:13:\"count_invalid\";i:0;}}', 'yes'),
(2022, 'auto_update_plugins', 'a:19:{i:0;s:53:\"accelerated-mobile-pages/accelerated-moblie-pages.php\";i:1;s:19:\"akismet/akismet.php\";i:2;s:51:\"all-in-one-wp-security-and-firewall/wp-security.php\";i:3;s:42:\"bicycles-by-falbar2/bicycles-by-falbar.php\";i:4;s:43:\"broken-link-checker/broken-link-checker.php\";i:5;s:33:\"classic-editor/classic-editor.php\";i:6;s:33:\"complianz-gdpr/complianz-gpdr.php\";i:7;s:36:\"contact-form-7/wp-contact-form-7.php\";i:8;s:42:\"contact-form-cfdb7/contact-form-cfdb-7.php\";i:9;s:25:\"fakerpress/fakerpress.php\";i:10;s:29:\"health-check/health-check.php\";i:11;s:35:\"litespeed-cache/litespeed-cache.php\";i:12;s:47:\"really-simple-ssl/rlrsssl-really-simple-ssl.php\";i:13;s:27:\"updraftplus/updraftplus.php\";i:14;s:25:\"insert-php/insert_php.php\";i:15;s:41:\"wordpress-importer/wordpress-importer.php\";i:16;s:39:\"wp-file-manager/file_folder_manager.php\";i:17;s:27:\"wp-optimize/wp-optimize.php\";i:18;s:24:\"wordpress-seo/wp-seo.php\";}', 'no'),
(1904, 'wpo_update_version', '3.1.11', 'yes'),
(1937, 'cfdb7_view_install_date', '2020-02-03 16:47:01', 'yes'),
(1940, 'cptui_new_install', 'false', 'yes'),
(1951, 'classic-editor-allow-users', 'disallow', 'yes'),
(1950, 'classic-editor-replace', 'classic', 'yes'),
(1815, 'wp-optimize-auto', 'a:7:{s:6:\"drafts\";s:4:\"true\";s:8:\"optimize\";s:5:\"false\";s:9:\"revisions\";s:4:\"true\";s:5:\"spams\";s:4:\"true\";s:9:\"transient\";s:5:\"false\";s:5:\"trash\";s:4:\"true\";s:10:\"unapproved\";s:5:\"false\";}', 'yes'),
(1816, 'wp-optimize-settings', 'a:13:{s:10:\"user-spams\";s:4:\"true\";s:15:\"user-unapproved\";s:4:\"true\";s:15:\"user-orphandata\";s:4:\"true\";s:11:\"user-drafts\";s:4:\"true\";s:14:\"user-transient\";s:4:\"true\";s:13:\"user-postmeta\";s:4:\"true\";s:15:\"user-trackbacks\";s:4:\"true\";s:14:\"user-revisions\";s:4:\"true\";s:13:\"user-optimize\";s:4:\"true\";s:14:\"user-pingbacks\";s:4:\"true\";s:10:\"user-trash\";s:4:\"true\";s:16:\"user-commentmeta\";s:4:\"true\";s:13:\"last_saved_in\";s:6:\"3.1.11\";}', 'yes'),
(1817, 'updraft_task_manager_dbversion', '1.1', 'yes'),
(1819, 'wp-optimize-corrupted-tables-count', '0', 'yes'),
(1824, 'wp-optimize-dismiss_notice', '1575017480', 'yes'),
(1781, 'widget_akismet_widget', 'a:1:{s:12:\"_multiwidget\";i:1;}', 'yes'),
(1962, 'wp-optimize-install-or-update-notice-version', '1.0', 'yes'),
(1808, 'wp-optimize-schedule', 'false', 'yes'),
(1809, 'wp-optimize-last-optimized', 'Never', 'yes'),
(1810, 'wp-optimize-schedule-type', 'wpo_weekly', 'yes'),
(1811, 'wp-optimize-retention-enabled', 'false', 'yes'),
(1812, 'wp-optimize-retention-period', '2', 'yes'),
(1813, 'wp-optimize-enable-admin-menu', 'false', 'yes'),
(1814, 'wp-optimize-total-cleaned', '644320', 'yes'),
(1971, '_site_transient_timeout_theme_roots', '1626343282', 'no'),
(1972, '_site_transient_theme_roots', 'a:2:{s:15:\"twentytwentyone\";s:7:\"/themes\";s:12:\"wp-framework\";s:7:\"/themes\";}', 'no'),
(1874, 'admin_email_lifespan', '1641893277', 'yes'),
(1995, 'disallowed_keys', '-online\n.twinstatesnetwork.\n1031-exchange-properties\n125.47.41.166\n148.233.159.58\n165.29.58.126\n189.19.60.94\n189.4.80.48\n190.10.68.228\n194.68.238.7\n195.244.128.237\n195.250.160.37\n196.207.15.201\n196.207.40.213\n196.217.249.190\n1website\n200.51.41.29\n200.65.127.161\n200.68.73.193\n201.210.1.148\n201.234.19.13\n202.115.130.23\n206.245.173.42\n207.41.73.13\n210.212.228.7\n210.22.158.132\n213.239.210.120\n216.195.53.11\n216.213.199.53\n217.141.105.203\n217.141.106.201\n217.141.109.205\n217.141.249.203\n217.141.250.204\n217.65.31.167\n218.63.252.219\n219.209.194.156\n220.178.98.59\n221.122.43.124\n222.127.228.5\n222.221.6.144\n222.240.212.3\n222.82.226.145\n24.222.34.242\n4best-health.\n4u\n58.68.34.59\n61.133.87.226\n64.22.107.90\n64.22.110.2\n64.22.110.34\n67.227.134.4\n69.89.31.233\n70.86.141.82\n72.34.55.196\n74.53.227.178\n74.86.121.13\n80.227.1.100\n80.227.1.101\n80.231.198.77\n83.136.195.229\n85.13.219.98\n86.96.226.13\n86.96.226.14\n86.96.226.15\n87.101.244.6\n87.101.244.9\n88.147.165.40\n88.198.107.250\n88.249.63.217\n92.112.81.15\naccident insurance\nace-decoy-anchors.\nacnetreatment\nadderall\nadipex\nadvicer\nagentmanhoodragged\nalina1026@gmail.com\nallauctions4u.\nallegra\nalprazolam\nambien\namitriptyline\nanal\nanthurium\napexautoloan\nativan\natkins\nauto insurance\navailable-credit.\nbaccarat\nbaccarrat\nbalder\nballhoneys\nbannbaba.\nbbeckford@tscamail.com\nbestweblinks\nbitches\nblackjack\nbllogspot\nblow-ebony-job\nboat-loans\nbondage\nbontril\nbooker\nbutthole\nbuy online\nbuy-levitra-online\nbuy-phentermine\nbuy-porn-movie-online\nbuy-viagra\nbuy-xanax\nbuycialis\nbyob\nc**k\ncaclbca.\ncar insurance\ncar-rental-e-site\ncar-rentals-e-site\ncarisoprodol\ncash-services.\ncasino\ncasino-games\ncasinos\ncasualty insurance\ncephalexin\nchatroom\ncheapcarleasehire\ncheapdisneyvacationspackagesandtickets\ncialis\ncialisonline\ncitalopram\nclitoris\nclomid\ncock\ncollege-knowledge\ncompany-si.\ncontentattack.com\ncoolcoolhu\ncoolhu\ncopulationformmeet\ncraps\ncredit-card-debt\ncredit-cards\ncredit-dreams\ncredit-report-4u\ncreditcard\ncricketblog\ncunt\ncurrency-site\ncwas\ncyclen\ncyclobenzaprine\ncymbalta\ndating-e-site\ndawsonanddadrealty.\nday-trading\ndebt-consolidation\ndebt-consolidation-consultant\ndepressioninformation.net\ndiabservis.\ndidrex\ndiet-pill\ndiet-pills\ndiggdigg.co.cc\ndiscreetordering\ndissimilarly\ndistanceeducation\ndoxycycline\nduty-free\ndutyfree\nephedra\nequityloans\nfacial\nfinalsearch\nfioricet\nflamingosandfriends.\nflower4us\nflowers-leading-site\nforex\nfree-cumshot-gallery\nfree-online-poker\nfree-poker\nfree-ringtones\nfreenet\nfreenet-shopping\nfuck\nfukk\nfucking\ngambling\ngambling-\ngeneric-viagra\nh1.ripway\nhair-loss\nhawaiiresortblog\nheadsetplus\nhealth insurance\nhealth-insurancedeals-4u\nhentai\nholdem\nholdempoker\nholdemsoftware\nholdemtexasturbowilson\nhome-loans-inc.\nhomeequityloans\nhomefinance\nhomemade_sedatives\nhomeowners insurance\nhotel-dealse-site\nhotele-site\nhotelse-site\nhydrocodone\nhydrocone\nhypersearcher\nidealpaydayloans\nifinancialzone\nillcom.\nincest\nincrediblesearch.\ninforeal07.\ninsurance-quotesdeals-4u\ninsurancedeals-4u\ninvestment-loans\nionamin\nirs-problems\njbakerstudios.\njrcreations\njrcreations.\nk74v78@yahoo.com\nkasino\nkenwoodexcelon\nland.ru\nlaserhairremovalhints\nlawyerhints\nlesbian\nlevitra\nlevitra.\nlexapro\nlife insurance\nlifeinsurancehints\nlipitor\nlisinopril\nlopressor\nlorazepam\nlunestra\nlung-cancer\nluxury-linen\nlyndawyllie.\nm2mvc.\nmacinstruct\nmadesukadana.\nmanicsearch\nmark336699@gmail.com\nmaryknollogc.org\nmayopr.com\nmeridia\nmightyslumlords.com\nmlmleads.name\nmohegan sun\nmortgage-4-u\nmortgage-certificates\nmortgagequotes\nmortgagerefinancingtoday.\nmusicfastfinder\nmycolorcontacts\nmydivx.\nnemasoft.\nnetfirms.\nnipple\nnude\nnysm.\nonline casino\nonline casino guide\nonline poker\nonline slots\nonline-casino\nonline-casinos\nonline-debt-consolidation\nonline-gambling\nonline-pharmacy\nonlinegambling-4u\norgasm\nottawavalleyag\nownsthis\noxycodone\noxycontin\np***y\npacific-poker\npalm-texas-holdem-game\nparmacy\nparty-poker\npaxil\npayday loan\npayday-loan\npayday-loans\npenis\npercocet\npersonal-loans\npest-control\npharmacy\nphentermine\nphentermine.\npills-best.\npills-home.\npimpdog@gmail.com\npizzareviewblog\nplatinum-celebs\npoker\npoker-chip\npoker-games\npoker-hands\npoker-online\nporn\npornstar\npornstars\nprescription\nprohosting.\npropecia\nprotonix\nprozac\npussy\nrakeback\nrealtorlist\nrealtorx2\nrefinance-san-diego\nrental-car-e-site\nringtone\nringtones\nromanedirisinghe\nroulette\nsearchingrobot.\nseethishome\nservegame.com\nservehttp.com\nservepics.com\nshaffelrecords.\nshemale\nsightstickysubmit\nskank\nslot-machine\nslotmachine\nslots\nsoma\nstudent-loans\nswingers-search.com\nt35.\ntaboo\ntenuate\nterm insurance quote\ntexas hold\'em\ntexas holdem\ntexas-hold-em-rules\ntexas-hold-em.\ntexas-holdem\nthorcarlson\ntigerspice\ntop-e-site\ntop-franchise\ntop-site\ntrablinka\ntramadol\ntrancetechno.\ntransexual\ntranssexual\ntredgf\ntrim-spa\nturbo-tax\nugly.as\nultram\nunited24.\nvaleofglamorganconservatives\nvalium\nvaltrex\nvaried-poker.\nvcats\nviagra\nviagra-online\nviagrabuy\nviagraonline\nvicodin\nvincedel422@gmail.com\nvioxx\nvmasterpiece\nvneighbor\nvoyeurism\nvpawnshop\nvselling\nvsymphony\nwebsamba.\nwhore\nwiu.edu\nworld-series-of-poker\nwowad\nwpdigger.com\nxanax\nxenical\nxrated\nxxx\nycba\nytmnsfw.com\nz411.\nzenegra\nzithromax\nzolus\nzyban', 'no'),
(1996, 'comment_previously_approved', '1', 'yes'),
(1997, 'auto_plugin_theme_update_emails', 'a:0:{}', 'no'),
(1998, 'auto_update_core_dev', 'enabled', 'yes'),
(1999, 'auto_update_core_minor', 'enabled', 'yes'),
(2000, 'auto_update_core_major', 'unset', 'yes'),
(1909, 'rewrite_rules', 'a:93:{s:11:\"^wp-json/?$\";s:22:\"index.php?rest_route=/\";s:14:\"^wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:21:\"^index.php/wp-json/?$\";s:22:\"index.php?rest_route=/\";s:24:\"^index.php/wp-json/(.*)?\";s:33:\"index.php?rest_route=/$matches[1]\";s:17:\"^wp-sitemap\\.xml$\";s:23:\"index.php?sitemap=index\";s:17:\"^wp-sitemap\\.xsl$\";s:36:\"index.php?sitemap-stylesheet=sitemap\";s:23:\"^wp-sitemap-index\\.xsl$\";s:34:\"index.php?sitemap-stylesheet=index\";s:48:\"^wp-sitemap-([a-z]+?)-([a-z\\d_-]+?)-(\\d+?)\\.xml$\";s:75:\"index.php?sitemap=$matches[1]&sitemap-subtype=$matches[2]&paged=$matches[3]\";s:34:\"^wp-sitemap-([a-z]+?)-(\\d+?)\\.xml$\";s:47:\"index.php?sitemap=$matches[1]&paged=$matches[2]\";s:47:\"category/(.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:42:\"category/(.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:52:\"index.php?category_name=$matches[1]&feed=$matches[2]\";s:23:\"category/(.+?)/embed/?$\";s:46:\"index.php?category_name=$matches[1]&embed=true\";s:35:\"category/(.+?)/page/?([0-9]{1,})/?$\";s:53:\"index.php?category_name=$matches[1]&paged=$matches[2]\";s:17:\"category/(.+?)/?$\";s:35:\"index.php?category_name=$matches[1]\";s:44:\"tag/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:39:\"tag/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?tag=$matches[1]&feed=$matches[2]\";s:20:\"tag/([^/]+)/embed/?$\";s:36:\"index.php?tag=$matches[1]&embed=true\";s:32:\"tag/([^/]+)/page/?([0-9]{1,})/?$\";s:43:\"index.php?tag=$matches[1]&paged=$matches[2]\";s:14:\"tag/([^/]+)/?$\";s:25:\"index.php?tag=$matches[1]\";s:45:\"type/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:40:\"type/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?post_format=$matches[1]&feed=$matches[2]\";s:21:\"type/([^/]+)/embed/?$\";s:44:\"index.php?post_format=$matches[1]&embed=true\";s:33:\"type/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?post_format=$matches[1]&paged=$matches[2]\";s:15:\"type/([^/]+)/?$\";s:33:\"index.php?post_format=$matches[1]\";s:12:\"robots\\.txt$\";s:18:\"index.php?robots=1\";s:13:\"favicon\\.ico$\";s:19:\"index.php?favicon=1\";s:48:\".*wp-(atom|rdf|rss|rss2|feed|commentsrss2)\\.php$\";s:18:\"index.php?feed=old\";s:20:\".*wp-app\\.php(/.*)?$\";s:19:\"index.php?error=403\";s:18:\".*wp-register.php$\";s:23:\"index.php?register=true\";s:32:\"feed/(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:27:\"(feed|rdf|rss|rss2|atom)/?$\";s:27:\"index.php?&feed=$matches[1]\";s:8:\"embed/?$\";s:21:\"index.php?&embed=true\";s:20:\"page/?([0-9]{1,})/?$\";s:28:\"index.php?&paged=$matches[1]\";s:41:\"comments/feed/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:36:\"comments/(feed|rdf|rss|rss2|atom)/?$\";s:42:\"index.php?&feed=$matches[1]&withcomments=1\";s:17:\"comments/embed/?$\";s:21:\"index.php?&embed=true\";s:44:\"search/(.+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:39:\"search/(.+)/(feed|rdf|rss|rss2|atom)/?$\";s:40:\"index.php?s=$matches[1]&feed=$matches[2]\";s:20:\"search/(.+)/embed/?$\";s:34:\"index.php?s=$matches[1]&embed=true\";s:32:\"search/(.+)/page/?([0-9]{1,})/?$\";s:41:\"index.php?s=$matches[1]&paged=$matches[2]\";s:14:\"search/(.+)/?$\";s:23:\"index.php?s=$matches[1]\";s:47:\"author/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:42:\"author/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:50:\"index.php?author_name=$matches[1]&feed=$matches[2]\";s:23:\"author/([^/]+)/embed/?$\";s:44:\"index.php?author_name=$matches[1]&embed=true\";s:35:\"author/([^/]+)/page/?([0-9]{1,})/?$\";s:51:\"index.php?author_name=$matches[1]&paged=$matches[2]\";s:17:\"author/([^/]+)/?$\";s:33:\"index.php?author_name=$matches[1]\";s:69:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:64:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:80:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&feed=$matches[4]\";s:45:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/embed/?$\";s:74:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&embed=true\";s:57:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:81:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]\";s:39:\"([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$\";s:63:\"index.php?year=$matches[1]&monthnum=$matches[2]&day=$matches[3]\";s:56:\"([0-9]{4})/([0-9]{1,2})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:51:\"([0-9]{4})/([0-9]{1,2})/(feed|rdf|rss|rss2|atom)/?$\";s:64:\"index.php?year=$matches[1]&monthnum=$matches[2]&feed=$matches[3]\";s:32:\"([0-9]{4})/([0-9]{1,2})/embed/?$\";s:58:\"index.php?year=$matches[1]&monthnum=$matches[2]&embed=true\";s:44:\"([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$\";s:65:\"index.php?year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]\";s:26:\"([0-9]{4})/([0-9]{1,2})/?$\";s:47:\"index.php?year=$matches[1]&monthnum=$matches[2]\";s:43:\"([0-9]{4})/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:38:\"([0-9]{4})/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?year=$matches[1]&feed=$matches[2]\";s:19:\"([0-9]{4})/embed/?$\";s:37:\"index.php?year=$matches[1]&embed=true\";s:31:\"([0-9]{4})/page/?([0-9]{1,})/?$\";s:44:\"index.php?year=$matches[1]&paged=$matches[2]\";s:13:\"([0-9]{4})/?$\";s:26:\"index.php?year=$matches[1]\";s:27:\".?.+?/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\".?.+?/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\".?.+?/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\".?.+?/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\".?.+?/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"(.?.+?)/embed/?$\";s:41:\"index.php?pagename=$matches[1]&embed=true\";s:20:\"(.?.+?)/trackback/?$\";s:35:\"index.php?pagename=$matches[1]&tb=1\";s:40:\"(.?.+?)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:35:\"(.?.+?)/(feed|rdf|rss|rss2|atom)/?$\";s:47:\"index.php?pagename=$matches[1]&feed=$matches[2]\";s:28:\"(.?.+?)/page/?([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&paged=$matches[2]\";s:35:\"(.?.+?)/comment-page-([0-9]{1,})/?$\";s:48:\"index.php?pagename=$matches[1]&cpage=$matches[2]\";s:24:\"(.?.+?)(?:/([0-9]+))?/?$\";s:47:\"index.php?pagename=$matches[1]&page=$matches[2]\";s:27:\"[^/]+/attachment/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:37:\"[^/]+/attachment/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:57:\"[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:52:\"[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:33:\"[^/]+/attachment/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";s:16:\"([^/]+)/embed/?$\";s:37:\"index.php?name=$matches[1]&embed=true\";s:20:\"([^/]+)/trackback/?$\";s:31:\"index.php?name=$matches[1]&tb=1\";s:40:\"([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:35:\"([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:43:\"index.php?name=$matches[1]&feed=$matches[2]\";s:28:\"([^/]+)/page/?([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&paged=$matches[2]\";s:35:\"([^/]+)/comment-page-([0-9]{1,})/?$\";s:44:\"index.php?name=$matches[1]&cpage=$matches[2]\";s:24:\"([^/]+)(?:/([0-9]+))?/?$\";s:43:\"index.php?name=$matches[1]&page=$matches[2]\";s:16:\"[^/]+/([^/]+)/?$\";s:32:\"index.php?attachment=$matches[1]\";s:26:\"[^/]+/([^/]+)/trackback/?$\";s:37:\"index.php?attachment=$matches[1]&tb=1\";s:46:\"[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:41:\"[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$\";s:49:\"index.php?attachment=$matches[1]&feed=$matches[2]\";s:41:\"[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$\";s:50:\"index.php?attachment=$matches[1]&cpage=$matches[2]\";s:22:\"[^/]+/([^/]+)/embed/?$\";s:43:\"index.php?attachment=$matches[1]&embed=true\";}', 'yes'),
(1978, '_site_transient_timeout_php_check_be350024f30b4b5fb17e000b68f2aafc', '1626946061', 'no'),
(1979, '_site_transient_php_check_be350024f30b4b5fb17e000b68f2aafc', 'a:5:{s:19:\"recommended_version\";s:3:\"7.4\";s:15:\"minimum_version\";s:6:\"5.6.20\";s:12:\"is_supported\";b:1;s:9:\"is_secure\";b:1;s:13:\"is_acceptable\";b:1;}', 'no'),
(1981, '_site_transient_browser_3941ddf92f1f50fe8180ec7043c1892d', 'a:10:{s:4:\"name\";s:6:\"Chrome\";s:7:\"version\";s:13:\"91.0.4472.124\";s:8:\"platform\";s:7:\"Windows\";s:10:\"update_url\";s:29:\"https://www.google.com/chrome\";s:7:\"img_src\";s:43:\"http://s.w.org/images/browsers/chrome.png?1\";s:11:\"img_src_ssl\";s:44:\"https://s.w.org/images/browsers/chrome.png?1\";s:15:\"current_version\";s:2:\"18\";s:7:\"upgrade\";b:0;s:8:\"insecure\";b:0;s:6:\"mobile\";b:0;}', 'no'),
(1982, '_site_transient_timeout_community-events-cb1911c6cb74ba3909a2dd72cf7e2b7c', '1626384480', 'no'),
(1983, '_site_transient_community-events-cb1911c6cb74ba3909a2dd72cf7e2b7c', 'a:4:{s:9:\"sandboxed\";b:0;s:5:\"error\";N;s:8:\"location\";a:1:{s:2:\"ip\";s:12:\"195.34.207.0\";}s:6:\"events\";a:2:{i:0;a:10:{s:4:\"type\";s:6:\"meetup\";s:5:\"title\";s:50:\"Learn WordPress: Watch and Discuss User Management\";s:3:\"url\";s:68:\"https://www.meetup.com/learn-wordpress-discussions/events/279303274/\";s:6:\"meetup\";s:27:\"Learn WordPress Discussions\";s:10:\"meetup_url\";s:51:\"https://www.meetup.com/learn-wordpress-discussions/\";s:4:\"date\";s:19:\"2021-07-15 10:30:00\";s:8:\"end_date\";s:19:\"2021-07-15 11:30:00\";s:20:\"start_unix_timestamp\";i:1626370200;s:18:\"end_unix_timestamp\";i:1626373800;s:8:\"location\";a:4:{s:8:\"location\";s:6:\"Online\";s:7:\"country\";s:2:\"US\";s:8:\"latitude\";d:37.779998779297;s:9:\"longitude\";d:-122.41999816895;}}i:1;a:10:{s:4:\"type\";s:8:\"wordcamp\";s:5:\"title\";s:34:\"WordCamp Santa Clarita Online 2021\";s:3:\"url\";s:39:\"https://santaclarita.wordcamp.org/2021/\";s:6:\"meetup\";N;s:10:\"meetup_url\";N;s:4:\"date\";s:19:\"2021-07-17 00:00:00\";s:8:\"end_date\";s:19:\"2021-07-18 00:00:00\";s:20:\"start_unix_timestamp\";i:1626505200;s:18:\"end_unix_timestamp\";i:1626591600;s:8:\"location\";a:4:{s:8:\"location\";s:6:\"Online\";s:7:\"country\";s:2:\"US\";s:8:\"latitude\";d:34.3677169;s:9:\"longitude\";d:-118.4747173;}}}}', 'no'),
(1980, '_site_transient_timeout_browser_3941ddf92f1f50fe8180ec7043c1892d', '1626946078', 'no'),
(2023, 'wp-optimize-installed-for', '1626341590', 'yes'),
(2024, 'wpo_minify_config', 'a:49:{s:5:\"debug\";b:0;s:19:\"enabled_css_preload\";b:0;s:18:\"enabled_js_preload\";b:0;s:11:\"hpreconnect\";s:0:\"\";s:8:\"hpreload\";s:0:\"\";s:7:\"loadcss\";b:0;s:10:\"remove_css\";b:0;s:17:\"critical_path_css\";s:0:\"\";s:31:\"critical_path_css_is_front_page\";s:0:\"\";s:30:\"preserve_settings_on_uninstall\";b:1;s:22:\"disable_when_logged_in\";b:0;s:16:\"default_protocol\";s:7:\"dynamic\";s:17:\"html_minification\";b:1;s:16:\"clean_header_one\";b:0;s:13:\"emoji_removal\";b:1;s:18:\"merge_google_fonts\";b:1;s:19:\"enable_display_swap\";b:1;s:18:\"remove_googlefonts\";b:0;s:13:\"gfonts_method\";s:6:\"inline\";s:15:\"fawesome_method\";s:7:\"inherit\";s:10:\"enable_css\";b:1;s:23:\"enable_css_minification\";b:1;s:21:\"enable_merging_of_css\";b:1;s:23:\"remove_print_mediatypes\";b:0;s:10:\"inline_css\";b:0;s:9:\"enable_js\";b:1;s:22:\"enable_js_minification\";b:1;s:20:\"enable_merging_of_js\";b:1;s:15:\"enable_defer_js\";s:10:\"individual\";s:13:\"defer_js_type\";s:5:\"defer\";s:12:\"defer_jquery\";b:1;s:18:\"enable_js_trycatch\";b:0;s:19:\"exclude_defer_login\";b:1;s:7:\"cdn_url\";s:0:\"\";s:9:\"cdn_force\";b:0;s:9:\"async_css\";s:0:\"\";s:8:\"async_js\";s:0:\"\";s:24:\"disable_css_inline_merge\";b:1;s:6:\"ualist\";a:8:{i:0;s:12:\"x11.*fox\\/54\";i:1;s:20:\"oid\\s4.*xus.*ome\\/62\";i:2;s:12:\"x11.*ome\\/62\";i:3;s:5:\"oobot\";i:4;s:5:\"ighth\";i:5;s:5:\"tmetr\";i:6;s:6:\"eadles\";i:7;s:5:\"ingdo\";}s:9:\"blacklist\";a:0:{}s:11:\"ignore_list\";a:0:{}s:10:\"exclude_js\";s:0:\"\";s:11:\"exclude_css\";s:0:\"\";s:23:\"edit_default_exclutions\";b:0;s:18:\"merge_allowed_urls\";s:0:\"\";s:7:\"enabled\";b:0;s:17:\"last-cache-update\";i:1626341590;s:14:\"plugin_version\";s:5:\"0.0.0\";s:14:\"cache_lifespan\";i:30;}', 'yes'),
(2025, 'wp-optimize-install-or-update-notice-show-time', '1626341590', 'yes'),
(2027, 'updraft_unlocked_wpo_cache_preloader_creating_tasks', '1', 'no'),
(2028, 'updraft_last_lock_time_wpo_cache_preloader_creating_tasks', '2021-07-15 09:33:16', 'no'),
(2029, 'updraft_semaphore_wpo_cache_preloader_creating_tasks', '0', 'no'),
(2030, 'wp-optimize-is_gzip_compression_enabled', 'gzip', 'yes');

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_postmeta`
--

CREATE TABLE `nammk_postmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `nammk_postmeta`
--

INSERT INTO `nammk_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(91, 39, '_form', '<label> Ваше имя (обязательно)\n    [text* your-name] </label>\n\n<label> Ваш e-mail (обязательно)\n    [email* your-email] </label>\n\n<label> Тема\n    [text your-subject] </label>\n\n<label> Сообщение\n    [textarea your-message] </label>\n\n[submit \"Отправить\"]'),
(92, 39, '_mail', 'a:8:{s:7:\"subject\";s:17:\" \"[your-subject]\"\";s:6:\"sender\";s:26:\" <info@wp-framework.local>\";s:4:\"body\";s:188:\"От: [your-name] <[your-email]>\nТема: [your-subject]\n\nСообщение:\n[your-message]\n\n-- \nЭто сообщение отправлено с сайта  (http://wp-framework.local)\";s:9:\"recipient\";s:23:\"info@wp-framework.local\";s:18:\"additional_headers\";s:22:\"Reply-To: [your-email]\";s:11:\"attachments\";s:0:\"\";s:8:\"use_html\";i:0;s:13:\"exclude_blank\";i:0;}'),
(93, 39, '_mail_2', 'a:9:{s:6:\"active\";b:0;s:7:\"subject\";s:17:\" \"[your-subject]\"\";s:6:\"sender\";s:26:\" <info@wp-framework.local>\";s:4:\"body\";s:129:\"Сообщение:\n[your-message]\n\n-- \nЭто сообщение отправлено с сайта  (http://wp-framework.local)\";s:9:\"recipient\";s:12:\"[your-email]\";s:18:\"additional_headers\";s:33:\"Reply-To: info@wp-framework.local\";s:11:\"attachments\";s:0:\"\";s:8:\"use_html\";i:0;s:13:\"exclude_blank\";i:0;}'),
(94, 39, '_messages', 'a:8:{s:12:\"mail_sent_ok\";s:92:\"Спасибо за Ваше сообщение. Оно успешно отправлено.\";s:12:\"mail_sent_ng\";s:144:\"При отправке сообщения произошла ошибка. Пожалуйста, попробуйте ещё раз позже.\";s:16:\"validation_error\";s:180:\"Одно или несколько полей содержат ошибочные данные. Пожалуйста, проверьте их и попробуйте ещё раз.\";s:4:\"spam\";s:144:\"При отправке сообщения произошла ошибка. Пожалуйста, попробуйте ещё раз позже.\";s:12:\"accept_terms\";s:132:\"Вы должны принять условия и положения перед отправкой вашего сообщения.\";s:16:\"invalid_required\";s:60:\"Поле обязательно для заполнения.\";s:16:\"invalid_too_long\";s:39:\"Поле слишком длинное.\";s:17:\"invalid_too_short\";s:41:\"Поле слишком короткое.\";}'),
(95, 39, '_additional_settings', NULL),
(96, 39, '_locale', 'ru_RU');

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_posts`
--

CREATE TABLE `nammk_posts` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `post_author` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT 0,
  `post_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `nammk_posts`
--

INSERT INTO `nammk_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(39, 2, '2020-02-03 17:36:22', '2020-02-03 14:36:22', '<label> Ваше имя (обязательно)\n    [text* your-name] </label>\n\n<label> Ваш e-mail (обязательно)\n    [email* your-email] </label>\n\n<label> Тема\n    [text your-subject] </label>\n\n<label> Сообщение\n    [textarea your-message] </label>\n\n[submit \"Отправить\"]\n \"[your-subject]\"\n <info@wp-framework.local>\nОт: [your-name] <[your-email]>\nТема: [your-subject]\n\nСообщение:\n[your-message]\n\n-- \nЭто сообщение отправлено с сайта  (http://wp-framework.local)\ninfo@wp-framework.local\nReply-To: [your-email]\n\n0\n0\n\n \"[your-subject]\"\n <info@wp-framework.local>\nСообщение:\n[your-message]\n\n-- \nЭто сообщение отправлено с сайта  (http://wp-framework.local)\n[your-email]\nReply-To: info@wp-framework.local\n\n0\n0\nСпасибо за Ваше сообщение. Оно успешно отправлено.\nПри отправке сообщения произошла ошибка. Пожалуйста, попробуйте ещё раз позже.\nОдно или несколько полей содержат ошибочные данные. Пожалуйста, проверьте их и попробуйте ещё раз.\nПри отправке сообщения произошла ошибка. Пожалуйста, попробуйте ещё раз позже.\nВы должны принять условия и положения перед отправкой вашего сообщения.\nПоле обязательно для заполнения.\nПоле слишком длинное.\nПоле слишком короткое.', 'Контактная форма 1', '', 'publish', 'closed', 'closed', '', 'kontaktnaya-forma-1', '', '', '2020-02-03 17:36:22', '2020-02-03 14:36:22', '', 0, 'http://wp-framework.local/?post_type=wpcf7_contact_form&p=39', 0, 'wpcf7_contact_form', '', 0);

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_termmeta`
--

CREATE TABLE `nammk_termmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_terms`
--

CREATE TABLE `nammk_terms` (
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `nammk_terms`
--

INSERT INTO `nammk_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Без рубрики', 'uncategories', 0),
(2, 'Ссылки', 'links', 0);

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_term_relationships`
--

CREATE TABLE `nammk_term_relationships` (
  `object_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `term_order` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_term_taxonomy`
--

CREATE TABLE `nammk_term_taxonomy` (
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `count` bigint(20) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `nammk_term_taxonomy`
--

INSERT INTO `nammk_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 0),
(2, 2, 'link_category', '', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_tm_taskmeta`
--

CREATE TABLE `nammk_tm_taskmeta` (
  `meta_id` bigint(20) NOT NULL,
  `task_id` bigint(20) NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_tm_tasks`
--

CREATE TABLE `nammk_tm_tasks` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `type` varchar(300) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `class_identifier` varchar(300) COLLATE utf8mb4_unicode_520_ci DEFAULT '0',
  `attempts` int(11) DEFAULT 0,
  `description` varchar(300) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `time_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_locked_at` bigint(20) DEFAULT 0,
  `status` varchar(300) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_usermeta`
--

CREATE TABLE `nammk_usermeta` (
  `umeta_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `nammk_usermeta`
--

INSERT INTO `nammk_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(66, 3, 'facebook', ''),
(65, 3, 'twitter', ''),
(62, 3, 'yim', ''),
(63, 3, 'jabber', ''),
(64, 3, 'googleplus', ''),
(61, 3, 'aim', ''),
(22, 2, 'first_name', ''),
(23, 2, 'last_name', ''),
(24, 2, 'nickname', 'aparserok'),
(25, 2, 'description', ''),
(26, 2, 'rich_editing', 'true'),
(27, 2, 'comment_shortcuts', 'false'),
(28, 2, 'admin_color', 'coffee'),
(29, 2, 'use_ssl', '0'),
(30, 2, 'show_admin_bar_front', 'true'),
(31, 2, 'nammk_capabilities', 'a:1:{s:13:\"administrator\";b:1;}'),
(32, 2, 'nammk_user_level', '10'),
(33, 2, 'dismissed_wp_pointers', 'wp330_toolbar,wp330_saving_widgets,wp340_choose_image_from_library,wp340_customize_current_theme_link,wp350_media,wp360_revisions,wp360_locks,wp496_privacy,wbcr_clearfy_settings_pointer_1_4_2'),
(34, 2, '_yoast_wpseo_profile_updated', '1428927027'),
(60, 3, '_yoast_wpseo_profile_updated', '1428927027'),
(59, 3, 'wpseo_metakey', ''),
(58, 3, 'wpseo_metadesc', ''),
(57, 3, 'wpseo_title', ''),
(44, 3, 'first_name', 'Shiva'),
(45, 3, 'last_name', 'Parameshwara'),
(46, 3, 'nickname', 'shiva'),
(47, 3, 'description', ''),
(48, 3, 'rich_editing', 'true'),
(49, 3, 'comment_shortcuts', 'false'),
(50, 3, 'admin_color', 'midnight'),
(51, 3, 'use_ssl', '0'),
(52, 3, 'show_admin_bar_front', 'true'),
(53, 3, 'nammk_capabilities', 'a:1:{s:13:\"administrator\";b:1;}'),
(54, 3, 'nammk_user_level', '10'),
(55, 3, 'dismissed_wp_pointers', 'wp330_toolbar,wp330_saving_widgets,wp340_choose_image_from_library,wp340_customize_current_theme_link,wp350_media,wp360_revisions,wp360_locks,wp390_widgets,wp410_dfw,wp496_privacy'),
(56, 3, 'nammk_dashboard_quick_press_last_post_id', '35'),
(67, 3, 'last_login_time', '2018-09-24 10:59:59'),
(68, 3, 'session_tokens', 'a:1:{s:64:\"91d95bee62c50a50d8b3a55f6e82e1d2ab39d3fe1c26dadd710959485d307df8\";a:4:{s:10:\"expiration\";i:1538985599;s:2:\"ip\";s:9:\"127.0.0.1\";s:2:\"ua\";s:115:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36\";s:5:\"login\";i:1537775999;}}'),
(81, 3, 'wpseo_ignore_tour', '1'),
(82, 3, 'wpseo_seen_about_version', '3.0.7'),
(83, 3, 'managenav-menuscolumnshidden', 'a:4:{i:0;s:11:\"link-target\";i:1;s:11:\"css-classes\";i:2;s:3:\"xfn\";i:3;s:11:\"description\";}'),
(84, 3, 'metaboxhidden_nav-menus', 'a:2:{i:0;s:8:\"add-post\";i:1;s:12:\"add-post_tag\";}'),
(85, 3, 'wpseo_dismissed_gsc_notice', '1'),
(86, 3, 'meta-box-order_dashboard', 'a:4:{s:6:\"normal\";s:38:\"dashboard_right_now,dashboard_activity\";s:4:\"side\";s:21:\"dashboard_quick_press\";s:7:\"column3\";s:17:\"dashboard_primary\";s:7:\"column4\";s:0:\"\";}'),
(90, 3, 'community-events-location', 'a:1:{s:2:\"ip\";s:9:\"127.0.0.0\";}'),
(88, 3, 'wpseo-dismiss-about', 'seen'),
(89, 3, 'wpseo-dismiss-gsc', 'seen'),
(92, 3, 'wpseo-remove-upsell-notice', '1'),
(93, 3, 'show_try_gutenberg_panel', '0'),
(94, 3, 'show_welcome_panel', '0'),
(95, 2, 'session_tokens', 'a:1:{s:64:\"c605964c5788df6d3db9c42e9e1cb6befa48ea603fc2277659439f1b5f0ef12c\";a:4:{s:10:\"expiration\";i:1627550870;s:2:\"ip\";s:14:\"195.34.207.107\";s:2:\"ua\";s:131:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36 Edg/91.0.864.67\";s:5:\"login\";i:1626341270;}}'),
(104, 2, 'syntax_highlighting', 'true'),
(105, 2, 'locale', ''),
(106, 2, 'aim', ''),
(107, 2, 'yim', ''),
(108, 2, 'jabber', ''),
(96, 2, 'last_login_time', '2019-09-06 09:48:51'),
(97, 2, 'nammk_dashboard_quick_press_last_post_id', '41'),
(98, 2, 'community-events-location', 'a:1:{s:2:\"ip\";s:12:\"195.34.207.0\";}'),
(99, 2, 'show_try_gutenberg_panel', '0'),
(100, 2, 'show_welcome_panel', '0'),
(101, 2, 'closedpostboxes_dashboard', 'a:0:{}'),
(102, 2, 'metaboxhidden_dashboard', 'a:0:{}'),
(103, 2, 'meta-box-order_dashboard', 'a:4:{s:6:\"normal\";s:59:\"dashboard_right_now,dashboard_activity,blc_dashboard_widget\";s:4:\"side\";s:19:\"health_check_status\";s:7:\"column3\";s:21:\"dashboard_quick_press\";s:7:\"column4\";s:17:\"dashboard_primary\";}');

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_users`
--

CREATE TABLE `nammk_users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT 0,
  `display_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп даних таблиці `nammk_users`
--

INSERT INTO `nammk_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(2, 'aparserok', '$P$BeL/j3OEH14GcLKpifdYj.WxBtvxde/', 'aparserok', 'aparserok@gmail.com', '', '2013-11-06 22:37:02', '', 0, 'aparserok'),
(3, 'shiva', '$P$BNdTz5JzMaI1Q5pVX/quZko.M1GHZ80', 'shiva', 'mail@wp-framework.local', 'http://en.wikipedia.org/wiki/Shiva', '2013-12-20 17:06:50', '', 0, 'Shiva Parameshwara');

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_wpfm_backup`
--

CREATE TABLE `nammk_wpfm_backup` (
  `id` int(11) NOT NULL,
  `backup_name` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `backup_date` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_yoast_seo_links`
--

CREATE TABLE `nammk_yoast_seo_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `target_post_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(8) COLLATE utf8mb4_unicode_520_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Структура таблиці `nammk_yoast_seo_meta`
--

CREATE TABLE `nammk_yoast_seo_meta` (
  `object_id` bigint(20) UNSIGNED NOT NULL,
  `internal_link_count` int(10) UNSIGNED DEFAULT NULL,
  `incoming_link_count` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп даних таблиці `nammk_yoast_seo_meta`
--

INSERT INTO `nammk_yoast_seo_meta` (`object_id`, `internal_link_count`, `incoming_link_count`) VALUES
(35, 0, 0);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `nammk_aiowps_events`
--
ALTER TABLE `nammk_aiowps_events`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `nammk_aiowps_failed_logins`
--
ALTER TABLE `nammk_aiowps_failed_logins`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `nammk_aiowps_login_activity`
--
ALTER TABLE `nammk_aiowps_login_activity`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `nammk_aiowps_login_lockdown`
--
ALTER TABLE `nammk_aiowps_login_lockdown`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `nammk_aiowps_permanent_block`
--
ALTER TABLE `nammk_aiowps_permanent_block`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `nammk_blc_filters`
--
ALTER TABLE `nammk_blc_filters`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `nammk_blc_instances`
--
ALTER TABLE `nammk_blc_instances`
  ADD PRIMARY KEY (`instance_id`),
  ADD KEY `link_id` (`link_id`),
  ADD KEY `source_id` (`container_type`,`container_id`),
  ADD KEY `parser_type` (`parser_type`);

--
-- Індекси таблиці `nammk_blc_links`
--
ALTER TABLE `nammk_blc_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `url` (`url`(150)),
  ADD KEY `final_url` (`final_url`(150)),
  ADD KEY `http_code` (`http_code`),
  ADD KEY `broken` (`broken`);

--
-- Індекси таблиці `nammk_blc_synch`
--
ALTER TABLE `nammk_blc_synch`
  ADD PRIMARY KEY (`container_type`,`container_id`),
  ADD KEY `synched` (`synched`);

--
-- Індекси таблиці `nammk_commentmeta`
--
ALTER TABLE `nammk_commentmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Індекси таблиці `nammk_comments`
--
ALTER TABLE `nammk_comments`
  ADD PRIMARY KEY (`comment_ID`),
  ADD KEY `comment_post_ID` (`comment_post_ID`),
  ADD KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  ADD KEY `comment_date_gmt` (`comment_date_gmt`),
  ADD KEY `comment_parent` (`comment_parent`),
  ADD KEY `comment_author_email` (`comment_author_email`(10));

--
-- Індекси таблиці `nammk_db7_forms`
--
ALTER TABLE `nammk_db7_forms`
  ADD PRIMARY KEY (`form_id`);

--
-- Індекси таблиці `nammk_links`
--
ALTER TABLE `nammk_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `link_visible` (`link_visible`);

--
-- Індекси таблиці `nammk_options`
--
ALTER TABLE `nammk_options`
  ADD PRIMARY KEY (`option_id`),
  ADD UNIQUE KEY `option_name` (`option_name`),
  ADD KEY `autoload` (`autoload`);

--
-- Індекси таблиці `nammk_postmeta`
--
ALTER TABLE `nammk_postmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Індекси таблиці `nammk_posts`
--
ALTER TABLE `nammk_posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  ADD KEY `post_parent` (`post_parent`),
  ADD KEY `post_author` (`post_author`),
  ADD KEY `post_name` (`post_name`(191));

--
-- Індекси таблиці `nammk_termmeta`
--
ALTER TABLE `nammk_termmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Індекси таблиці `nammk_terms`
--
ALTER TABLE `nammk_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD KEY `slug` (`slug`(191)),
  ADD KEY `name` (`name`(191));

--
-- Індекси таблиці `nammk_term_relationships`
--
ALTER TABLE `nammk_term_relationships`
  ADD PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  ADD KEY `term_taxonomy_id` (`term_taxonomy_id`);

--
-- Індекси таблиці `nammk_term_taxonomy`
--
ALTER TABLE `nammk_term_taxonomy`
  ADD PRIMARY KEY (`term_taxonomy_id`),
  ADD UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  ADD KEY `taxonomy` (`taxonomy`);

--
-- Індекси таблиці `nammk_tm_taskmeta`
--
ALTER TABLE `nammk_tm_taskmeta`
  ADD PRIMARY KEY (`meta_id`),
  ADD KEY `meta_key` (`meta_key`(191)),
  ADD KEY `task_id` (`task_id`);

--
-- Індекси таблиці `nammk_tm_tasks`
--
ALTER TABLE `nammk_tm_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Індекси таблиці `nammk_usermeta`
--
ALTER TABLE `nammk_usermeta`
  ADD PRIMARY KEY (`umeta_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meta_key` (`meta_key`(191));

--
-- Індекси таблиці `nammk_users`
--
ALTER TABLE `nammk_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_login_key` (`user_login`),
  ADD KEY `user_nicename` (`user_nicename`),
  ADD KEY `user_email` (`user_email`);

--
-- Індекси таблиці `nammk_wpfm_backup`
--
ALTER TABLE `nammk_wpfm_backup`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `nammk_yoast_seo_links`
--
ALTER TABLE `nammk_yoast_seo_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `link_direction` (`post_id`,`type`);

--
-- Індекси таблиці `nammk_yoast_seo_meta`
--
ALTER TABLE `nammk_yoast_seo_meta`
  ADD UNIQUE KEY `object_id` (`object_id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `nammk_aiowps_events`
--
ALTER TABLE `nammk_aiowps_events`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nammk_aiowps_failed_logins`
--
ALTER TABLE `nammk_aiowps_failed_logins`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nammk_aiowps_login_activity`
--
ALTER TABLE `nammk_aiowps_login_activity`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nammk_aiowps_login_lockdown`
--
ALTER TABLE `nammk_aiowps_login_lockdown`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nammk_aiowps_permanent_block`
--
ALTER TABLE `nammk_aiowps_permanent_block`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nammk_blc_filters`
--
ALTER TABLE `nammk_blc_filters`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nammk_blc_instances`
--
ALTER TABLE `nammk_blc_instances`
  MODIFY `instance_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nammk_blc_links`
--
ALTER TABLE `nammk_blc_links`
  MODIFY `link_id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nammk_commentmeta`
--
ALTER TABLE `nammk_commentmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nammk_comments`
--
ALTER TABLE `nammk_comments`
  MODIFY `comment_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nammk_db7_forms`
--
ALTER TABLE `nammk_db7_forms`
  MODIFY `form_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nammk_links`
--
ALTER TABLE `nammk_links`
  MODIFY `link_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nammk_options`
--
ALTER TABLE `nammk_options`
  MODIFY `option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2037;

--
-- AUTO_INCREMENT для таблиці `nammk_postmeta`
--
ALTER TABLE `nammk_postmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT для таблиці `nammk_posts`
--
ALTER TABLE `nammk_posts`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT для таблиці `nammk_termmeta`
--
ALTER TABLE `nammk_termmeta`
  MODIFY `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nammk_terms`
--
ALTER TABLE `nammk_terms`
  MODIFY `term_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблиці `nammk_term_taxonomy`
--
ALTER TABLE `nammk_term_taxonomy`
  MODIFY `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблиці `nammk_tm_taskmeta`
--
ALTER TABLE `nammk_tm_taskmeta`
  MODIFY `meta_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nammk_tm_tasks`
--
ALTER TABLE `nammk_tm_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nammk_usermeta`
--
ALTER TABLE `nammk_usermeta`
  MODIFY `umeta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT для таблиці `nammk_users`
--
ALTER TABLE `nammk_users`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблиці `nammk_wpfm_backup`
--
ALTER TABLE `nammk_wpfm_backup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблиці `nammk_yoast_seo_links`
--
ALTER TABLE `nammk_yoast_seo_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
