<?php
/**
 * Operations with disc cache
 * @author Webcraftic <wordpress.webraftic@gmail.com>
 * @copyright (c) 2018 Webraftic Ltd
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class WMAC_PluginCache
 */
class WMAC_PluginCache
{
    /**
     * Cache filename.
     *
     * @var string
     */
    private $filename;

    /**
     * Whether gzipping is done by the web server or us.
     * True => we don't gzip, the web server does it.
     * False => we do it ourselves.
     *
     * @var bool
     */
    private $nogzip;

    /**
     * Ctor.
     *
     * @param string $md5 Hash.
     * @param string $ext Extension.
     */
    public function __construct( $md5, $ext = 'php' )
    {
        $this->nogzip   = WMAC_CACHE_NOGZIP;
        if ( ! $this->nogzip ) {
            $this->filename = WMAC_CACHEFILE_PREFIX . $md5 . '.php';
        } else {
            if ( in_array( $ext, array( 'js', 'css' ) ) ) {
                $this->filename = $ext . '/' . WMAC_CACHEFILE_PREFIX . $md5 . '.' . $ext;
            } else {
                $this->filename = WMAC_CACHEFILE_PREFIX . $md5 . '.' . $ext;
            }
        }
    }

	/**
	 * Get cache dir
	 *
	 * @return string
	 */
	public static function getCacheDir() {
		return WMAC_PluginCache::getPathname();
    }

	/**
	 * Get cache url
	 *
	 * @return string
	 */
	public static function getCacheUrl()
	{
		if ( is_multisite() && apply_filters( 'wmac_separate_blog_caches', true ) ) {
			$blog_id = get_current_blog_id();
			return WMAC_PluginMain::getContentUrl() . WMAC_CACHE_CHILD_DIR . $blog_id . '/';
		} else {
			return WMAC_PluginMain::getContentUrl() . WMAC_CACHE_CHILD_DIR;
		}
	}

    /**
     * Returns true if the cached file exists on disk.
     *
     * @return bool
     */
    public function check()
    {
        return file_exists( self::getCacheDir() . $this->filename );
    }

    /**
     * Returns cache contents if they exist, false otherwise.
     *
     * @return string|false
     */
    public function retrieve()
    {
        if ( $this->check() ) {
            if ( false == $this->nogzip ) {
                return file_get_contents( self::getCacheDir() . $this->filename . '.none' );
            } else {
                return file_get_contents( self::getCacheDir() . $this->filename );
            }
        }
        return false;
    }

    /**
     * Stores given $data in cache.
     *
     * @param string $data Data to cache.
     * @param string $mime Mimetype.
     *
     * @return void
     */
    public function cache( $data, $mime )
    {
        if ( false === $this->nogzip ) {
            // We handle gzipping ourselves.
            $file    = 'default.php';
            $phpcode = file_get_contents( WMAC_PLUGIN_DIR . '/config/' . $file );
            $phpcode = str_replace( array( '%%CONTENT%%', 'exit;' ), array( $mime, '' ), $phpcode );

            file_put_contents( self::getCacheDir() . $this->filename, $phpcode );
            file_put_contents( self::getCacheDir() . $this->filename . '.none', $data );
        } else {
            // Write code to cache without doing anything else.
            file_put_contents( self::getCacheDir() . $this->filename, $data );
            if ( apply_filters( 'wmac_filter_cache_create_static_gzip', false ) ) {
                // Create an additional cached gzip file.
                file_put_contents( self::getCacheDir() . $this->filename . '.gz', gzencode( $data, 9, FORCE_GZIP ) );
            }
        }
    }

    /**
     * Get cache filename.
     *
     * @return string
     */
    public function getname()
    {
        // NOTE: This could've maybe been a do_action() instead, however,
        // that ship has sailed.
        // The original idea here was to provide 3rd party code a hook so that
        // it can "listen" to all the complete auto optimized-urls that the page
        // will emit... Or something to that effect I think?
        apply_filters( 'wmac_filter_cache_getname', WMAC_PluginCache::getCacheUrl() . $this->filename );

        return $this->filename;
    }

    /**
     * Returns true if given `$file` is considered a valid Мinify And Combine cache file,
     * false otherwise.
     *
     * @param string $dir Directory name (with a trailing slash).
     * @param string $file Filename.
     *
     * @return bool
     */
    protected static function isValidCacheFile( $dir, $file )
    {
        if ( '.' !== $file && '..' !== $file &&
            false !== strpos( $file, WMAC_CACHEFILE_PREFIX ) &&
            is_file( $dir . $file ) ) {

            // It's a valid file!
            return true;
        }

        // Everything else is considered invalid!
        return false;
    }

    /**
     * Clears contents of cache dir.
     *
     * @return void
     */
    protected static function clearCacheClassic()
    {
        $contents = self::getCacheContents();
        foreach ( $contents as $name => $files ) {
            $dir = rtrim( self::getCacheDir() . $name, '/' ) . '/';
            foreach ( $files as $file ) {
                if ( self::isValidCacheFile( $dir, $file ) ) {
	                @unlink( $dir . $file ); // @codingStandardsIgnoreLine
                }
            }
        }

        @unlink( self::getCacheDir() . '/.htaccess' ); // @codingStandardsIgnoreLine
    }

    /**
     * Recursively deletes the specified pathname (file/directory) if possible.
     * Returns true on success, false otherwise.
     *
     * @param string $pathname Pathname to remove.
     *
     * @return bool
     */
    protected static function rmdir( $pathname )
    {
        $files = self::getDirContents( $pathname );
        foreach ( $files as $file ) {
            $path = $pathname . '/' . $file;
            if ( is_dir( $path ) ) {
                self::rmdir( $path );
            } else {
                unlink( $path );
            }
        }

        return rmdir( $pathname );
    }

    /**
     * Clears contents of cache dir by renaming the current
     * cache directory into a new one with a unique name and then
     * re-creating the default (empty) cache directory.
     *
     * @return bool Returns true when everything is done successfully, false otherwise.
     */
    protected static function clearCacheViaRename()
    {
        $ok       = false;
        $dir      = self::getPathnameBase();
        $new_name = self::getUniqueName();

        // Makes sure the new pathname is on the same level...
        $new_pathname = dirname( $dir ) . '/' . $new_name;
        $renamed      = @rename( $dir, $new_pathname ); // @codingStandardsIgnoreLine

        // When renamed, re-create the default cache directory back so it's
        // available again...
        if ( $renamed ) {
            $ok = self::cacheAvail();
        }

        return $ok;
    }

    /**
     * Returns true when advanced cache clearing is enabled.
     *
     * @return bool
     */
    public static function advancedCacheClearEnabled()
    {
        return apply_filters( 'wmac_filter_cache_clear_advanced', false );
    }

    /**
     * Returns a (hopefully) unique new cache folder name for renaming purposes.
     *
     * @return string
     */
    protected static function getUniqueName()
    {
        $prefix   = self::getAdvancedCacheClearPrefix();
        $new_name = uniqid( $prefix, true );

        return $new_name;
    }

    /**
     * Get cache prefix name used in advanced cache clearing mode.
     *
     * @return string
     */
    protected static function getAdvancedCacheClearPrefix()
    {
        $pathname = self::getPathnameBase();
        $basename = basename( $pathname );
        $prefix   = $basename . '-';

        return $prefix;
    }

    /**
     * Returns an array of file and directory names found within
     * the given $pathname without '.' and '..' elements.
     *
     * @param string $pathname Pathname.
     *
     * @return array
     */
    protected static function getDirContents( $pathname )
    {
        return array_slice( scandir( $pathname ), 2 );
    }

    /**
     * Wipes directories which were created as part of the fast cache clearing
     * routine (which renames the current cache directory into a new one with
     * a custom-prefixed unique name).
     *
     * @return bool
     */
    public static function deleteAdvancedCacheClearArtifacts()
    {
        $dir    = self::getPathnameBase();
        $prefix = self::getAdvancedCacheClearPrefix();
        $parent = dirname( $dir );
        $ok     = false;

        // Returns the list of files without '.' and '..' elements.
        $files = self::getDirContents( $parent );
        foreach ( $files as $file ) {
            $path     = $parent . '/' . $file;
            $prefixed = ( false !== strpos( $path, $prefix ) );
            // Removing only our own (prefixed) directories...
            if ( is_dir( $path ) && $prefixed ) {
                $ok = self::rmdir( $path );
            }
        }

        return $ok;
    }

    /**
     * Returns the cache directory pathname used.
     * Done as a function so we canSlightly different
     * if multisite is used and `wmac_separate_blog_caches` filter
     * is used.
     *
     * @return string
     */
    public static function getPathname()
    {
        $pathname = self::getPathnameBase();

        if ( is_multisite() && apply_filters( 'wmac_separate_blog_caches', true ) ) {
            $blog_id   = get_current_blog_id();
            $pathname .= $blog_id . '/';
        }

        return $pathname;
    }

    /**
     * Returns the base path of our cache directory.
     *
     * @return string
     */
    protected static function getPathnameBase()
    {
        $pathname = WP_CONTENT_DIR . WMAC_CACHE_CHILD_DIR;

        return $pathname;
    }

    /**
     * Deletes everything from the cache directories for all sites.
     *
     * @param bool $propagate Whether to trigger additional actions when cache is purged.
     */
    public static function clearAllMultisite( $propagate = true ) {
	    $sites = get_sites( array(
		    'archived' => 0,
		    'mature'   => 0,
		    'spam'     => 0,
		    'deleted'  => 0,
	    ) );

	    foreach ( $sites as $site ) {
		    switch_to_blog( $site->blog_id );

		    self::clearAll( $propagate );

		    restore_current_blog();
	    }
    }

    /**
     * Deletes everything from the cache directories.
     *
     * @param bool $propagate Whether to trigger additional actions when cache is purged.
     *
     * @return bool
     */
    public static function clearAll( $propagate = true )
    {
        if ( ! self::cacheAvail() ) {
            return false;
        }

        // TODO/FIXME: If cache is big, switch to advanced/new cache clearing automatically?
        if ( self::advancedCacheClearEnabled() ) {
            self::clearCacheViaRename();
        } else {
            self::clearCacheClassic();
        }

        // Remove the transient so it gets regenerated...
        delete_transient( 'wmac_stats' );

        // Cache was just purged, clear page cache and allow others to hook into our purging...
        if ( true === $propagate ) {
            if ( ! function_exists( 'wmac_do_cachepurged_action' ) ) {
                function wmac_do_cachepurged_action() {
                    do_action( 'wmac_action_cachepurged' );
                }
            }
            add_action( 'shutdown', 'wmac_do_cachepurged_action', 11 );
            add_action( 'wmac_action_cachepurged', array( 'WbcrFactoryClearfy206_Helpers', 'flushPageCache' ), 10, 0 );
        }

        // Warm cache (part of speedupper)!
        if ( apply_filters( 'wmac_filter_speedupper', true ) ) {
            $url   = site_url() . '/?ao_speedup_cachebuster=' . rand( 1, 100000 );
            $cache = @wp_remote_get( $url ); // @codingStandardsIgnoreLine
            unset( $cache );
        }

        return true;
    }

    /**
     * Wrapper for clearAll but with false param
     * to ensure the event is not propagated to others
     * through our own hooks (to avoid infinite loops).
     *
     * @return bool
     */
    public static function clearAllActionless()
    {
        return self::clearAll( false );
    }

    /**
     * Returns the contents of our cache dirs.
     *
     * @return array
     */
    protected static function getCacheContents()
    {
        $contents = array();

        foreach ( array( '', 'js', 'css' ) as $dir ) {
            $contents[ $dir ] = scandir( self::getCacheDir() . $dir );
        }

        return $contents;
    }

	/**
	 * Returns stats about cached contents.
	 *
	 * @return array|int|mixed
	 */
    public static function stats()
    {
        $stats = get_transient( 'wmac_stats' );

        // If no transient, do the actual scan!
        if ( ! is_array( $stats ) ) {
            if ( ! self::cacheAvail() ) {
                return 0;
            }
            $stats = self::statsScan();
            $count = $stats[0];
            if ( $count > 100 ) {
                // Store results in transient.
                set_transient(
                    'wmac_stats',
                    $stats,
                    apply_filters( 'wmac_filter_cache_statsexpiry', HOUR_IN_SECONDS )
                );
            }
        }

        return $stats;
    }

	/**
	 * Return cache used data
	 *
	 * @return array
	 */
	public static function getUsedCache(  ) {
		// Retrieve the Autoptimize Cache Stats information.
		$stats = WMAC_PluginCache::stats();

		// Set the Max Size recommended for cache files.
		$max_size = apply_filters( 'wmac_filter_cachecheck_maxsize', 512 * 1024 * 1024 );

		// Retrieve the current Total Files in cache.
		$files = $stats[0];
		// Retrieve the current Total Size of the cache.
		$bytes = $stats[1];
		$size  = WMAC_PluginHelper::format_filesize( $bytes );

		// Calculate the percentage of cache used.
		$percent = ceil( $bytes / $max_size * 100 );
		if ( $percent > 100 ) {
			$percent = 100;
		}

		return array(
			'files'   => $files,
			'size'    => $size,
			'percent' => $percent,
		);
    }

	/**
	 * Return cache used data
	 *
	 * @return array
	 */
	public static function getUsedCacheMultisite() {
		$files = $bytes = 0;

		$sites = get_sites( array(
			'archived' => 0,
			'mature'   => 0,
			'spam'     => 0,
			'deleted'  => 0,
		) );

		foreach ( $sites as $site ) {
			switch_to_blog( $site->blog_id );

			// Retrieve the Autoptimize Cache Stats information.
			$stats = WMAC_PluginCache::stats();

			// Retrieve the current Total Files in cache.
			$files += $stats[0];
			// Retrieve the current Total Size of the cache.
			$bytes += $stats[1];

			restore_current_blog();
		}

		$size = WMAC_PluginHelper::format_filesize( $bytes );

		return array(
			'files' => $files,
			'size'  => $size,
		);
	}

    /**
     * Performs a scan of cache directory contents and returns an array
     * with 3 values: count, size, timestamp.
     * count = total number of found files
     * size = total filesize (in bytes) of found files
     * timestamp = unix timestamp when the scan was last performed/finished.
     *
     * @return array
     */
    protected static function statsScan()
    {
        $count = 0;
        $size  = 0;

        // Scan everything in our cache directories.
        foreach ( self::getCacheContents() as $name => $files ) {
            $dir = rtrim( self::getCacheDir() . $name, '/' ) . '/';
            foreach ( $files as $file ) {
                if ( self::isValidCacheFile( $dir, $file ) ) {
                    if ( WMAC_CACHE_NOGZIP &&
                        (
                            false !== strpos( $file, '.js' ) ||
                            false !== strpos( $file, '.css' ) ||
                            false !== strpos( $file, '.img' ) ||
                            false !== strpos( $file, '.txt' )
                        )
                    ) {
                        // Web server is gzipping, we count .js|.css|.img|.txt files.
                        $count++;
                    } elseif ( ! WMAC_CACHE_NOGZIP && false !== strpos( $file, '.none' ) ) {
                        // We are gzipping ourselves via php, counting only .none files.
                        $count++;
                    }
                    $size += filesize( $dir . $file );
                }
            }
        }

        $stats = array( $count, $size, time() );

        return $stats;
    }

    /**
     * Ensures the cache directory exists, is writeable and contains the
     * required .htaccess files.
     * Returns false in case it fails to ensure any of those things.
     *
     * @return bool
     */
    public static function cacheAvail()
    {
        foreach ( array( '', 'js', 'css' ) as $dir ) {
            if ( ! self::checkCacheDir( self::getCacheDir() . $dir ) ) {
                return false;
            }
        }

        // Using .htaccess inside our cache folder to overrule wp-super-cache.
        $htaccess = self::getCacheDir() . '/.htaccess';
        if ( ! is_file( $htaccess ) ) {
            /**
             * Create `wp-content/AO_htaccess_tmpl` file with
             * whatever htaccess rules you might need
             * if you want to override default AO htaccess
             */
            $htaccess_tmpl = WP_CONTENT_DIR . '/AO_htaccess_tmpl';
            if ( is_file( $htaccess_tmpl ) ) {
                $content = file_get_contents( $htaccess_tmpl );
            } elseif ( is_multisite() || ! WMAC_CACHE_NOGZIP ) {
                $content = '<IfModule mod_expires.c>
        ExpiresActive On
        ExpiresByType text/css A30672000
        ExpiresByType text/javascript A30672000
        ExpiresByType application/javascript A30672000
</IfModule>
<IfModule mod_headers.c>
    Header append Cache-Control "public, immutable"
</IfModule>
<IfModule mod_deflate.c>
        <FilesMatch "\.(js|css)$">
        SetOutputFilter DEFLATE
    </FilesMatch>
</IfModule>
<IfModule mod_authz_core.c>
    <Files *.php>
        Require all granted
    </Files>
</IfModule>
<IfModule !mod_authz_core.c>
    <Files *.php>
        Order allow,deny
        Allow from all
    </Files>
</IfModule>';
            } else {
                $content = '<IfModule mod_expires.c>
        ExpiresActive On
        ExpiresByType text/css A30672000
        ExpiresByType text/javascript A30672000
        ExpiresByType application/javascript A30672000
</IfModule>
<IfModule mod_headers.c>
    Header append Cache-Control "public, immutable"
</IfModule>
<IfModule mod_deflate.c>
    <FilesMatch "\.(js|css)$">
        SetOutputFilter DEFLATE
    </FilesMatch>
</IfModule>
<IfModule mod_authz_core.c>
    <Files *.php>
        Require all denied
    </Files>
</IfModule>
<IfModule !mod_authz_core.c>
    <Files *.php>
        Order deny,allow
        Deny from all
    </Files>
</IfModule>';
            }
            @file_put_contents( $htaccess, $content ); // @codingStandardsIgnoreLine
        }

        // All OK!
        return true;
    }

    /**
     * Ensures the specified `$dir` exists and is writeable.
     * Returns false if that's not the case.
     *
     * @param string $dir Directory to check/create.
     *
     * @return bool
     */
    protected static function checkCacheDir( $dir )
    {
        // Try creating the dir if it doesn't exist.
        if ( ! file_exists( $dir ) ) {
            @mkdir( $dir, 0775, true ); // @codingStandardsIgnoreLine
            if ( ! file_exists( $dir ) ) {
                return false;
            }
        }

        // If we still cannot write, bail.
        if ( ! is_writable( $dir ) ) {
            return false;
        }

        // Create an index.html in there to avoid prying eyes!
        $idx_file = rtrim( $dir, '/\\' ) . '/index.html';
        if ( ! is_file( $idx_file ) ) {
            @file_put_contents( $idx_file, '<html><head><meta name="robots" content="noindex, nofollow"></head><body>Generated by <a href="http://wordpress.org/extend/plugins/" rel="nofollow">Мinify And Combine</a></body></html>' ); // @codingStandardsIgnoreLine
        }

        return true;
    }
}
