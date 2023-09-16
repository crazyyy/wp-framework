<?php
/*
 *  @author nguyenhongphat0 <nguyenhongphat28121998@gmail.com>
 *  @license https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0
 */
if ( ! defined( 'ABSPATH'  )  ) exit;

function developerpack_response( $data ) {
	echo json_encode( $data );
	wp_die();
}

function developerpack_list_files( $path ) {
	$project = realpath( $path );
	$directory = new RecursiveDirectoryIterator( $project );
	$files = new RecursiveIteratorIterator( $directory, RecursiveIteratorIterator::LEAVES_ONLY );
	return $files;
}

function developerpack_archive( $regex, $output, $maxsize, $timeout ) {
	// Extend excecute limit
	if ( isset( $timeout ) ) {
		set_time_limit( $timeout );
	}

	// Get files in directory
	$project = realpath( '..' );
	$files = developerpack_list_files( $project );

	// Initialize archive object
	$zip = new ZipArchive();
	$zip->open( $output, ZipArchive::CREATE | ZipArchive::OVERWRITE );

	foreach ( $files as $name => $file )
	{
		// Skip directories ( they would be added automatically )
		$ok = ( preg_match( $regex, $name ) ) && ( !$file->isDir() ) && ( $file->getSize() < $maxsize );
		if ( $ok )
		{
			// Get real and relative path for current file
			$filePath = $file->getRealPath();
			$relativePath = substr( $filePath, strlen( $project ) + 1 );

			// Add current file to archive
			$zip->addFile( $filePath, $relativePath );
		}
	}

	// Zip archive will be created only after closing object
	return $zip->close();
}

function developerpack_implode_options( $options ) {
	function escape( $path )
	{
		$project = realpath( '..' );
		if ( substr( $path, 0, 1 ) === "/" ) {
			$path = $project.$path;
		}
		$path = str_replace( '.', '\.', $path );
		$path = str_replace( '/', '\/', $path );
		return( $path );
	}
	$options = array_map( "escape", $options );
	$regex = implode( '|', $options );
	return $regex;
}

function developerpack_include_files( $includes ) {
	$regex = developerpack_implode_options( $includes );
	$regex = '/^.*('.$regex.').*$/i';
	return $regex;
}

function developerpack_exclude_files( $excludes ) {
	$regex = developerpack_implode_options( $excludes );
	$regex = '/^((?!'.$regex.').)*$/i';
	return $regex;
}

add_action( 'wp_ajax_developerpack_zip', 'developerpack_zip' );
function developerpack_zip()
{
	$response = array(
		'status' => 400,
	);
	$timeout = absint( $_POST['timeout'] );
	if ( isset( $_POST['maxsize'] ) ) {
		$maxsize = absint( $_POST['maxsize'] );
	} else {
		$maxsize = 1000000;
	}
	$files = $_POST['files'];
	$empty = empty( $files );
	$not_array = ! is_array( $files );
	if ( $empty || $not_array) {
		$response['message'] = 'Not enough parameters';
	}
	foreach ( $files as $file ) {
		if ( $file === '' ) {
			$response['message'] = 'Empty rules are not allowed';
		}
	}
	$rules = $_POST['rule'];
	switch ( $rules ) {
	case 'include':
		$regex = developerpack_include_files( $files );
		break;

	case 'exclude':
		$regex = developerpack_exclude_files( $files );
		break;

	default:
		$response['message'] = 'Invalid rule';
		break;
	}
	if ( ! isset( $response['message'] ) ) {
		$zippath = dirname( __FILE__ ) . '/zip/';
		mkdir( $zippath );
		$output = $zippath . $_POST['output'];
		$success = developerpack_archive( $regex, $output, $maxsize, $timeout );
		if ( $success ) {
			$response['status'] = 200;
			$response['message'] = 'File created successfully';
			$response['output'] = $_POST['output'];
		} else {
			$response['message'] = 'Permission denied!';
		}
	}
	developerpack_response( $response );
}

function developerpack_human_file_size( $size, $unit="" ) {
	if( ( !$unit && $size >= 1<<30 ) || $unit == "GB" )
		return number_format( $size/( 1<<30 ),2 )." GB";
	if( ( !$unit && $size >= 1<<20 ) || $unit == "MB" )
		return number_format( $size/( 1<<20 ),2 )." MB";
	if( ( !$unit && $size >= 1<<10 ) || $unit == "KB" )
		return number_format( $size/( 1<<10 ),2 )." KB";
	return number_format( $size )." bytes";
}

add_action( 'wp_ajax_developerpack_zipped', 'developerpack_zipped' );
function developerpack_zipped() {
	$path = dirname( __FILE__ ) . '/zip/';
	$project = realpath( '..' );
	$relative = substr( $path, strlen( $project ) + 1 );
	$files = array_diff( scandir( $path ), array( '.', '..' ) );
	$res = array();
	foreach ( $files as $file ) {
		$res[] = array(
			'name' => $file,
			'path' => $relative . $file,
			'size' => developerpack_human_file_size( filesize( $path . $file ) )
		);
	}
	developerpack_response( $res );
}

add_action( 'wp_ajax_developerpack_analize', 'developerpack_analize' );
function developerpack_analize() {
	$start = microtime( true );
	$project = realpath( '..' );
	$files = developerpack_list_files( $project );
	$size = $d = 0;
	foreach ( $files as $name => $file ) {
		$size += $file->getSize();
		$d++;
	}
	developerpack_response( array(
		'total' => $d . ' files and directories',
		'size' => developerpack_human_file_size( $size ),
		'execution_time' => ( microtime( true ) - $start ) . 's'
	) );
}

add_action( 'wp_ajax_developerpack_open', 'developerpack_open' );
function developerpack_open() {
	$project = realpath( '..' );
	$filename = wp_normalize_path( $_POST['file'] );
	$file = $project.'/'.$filename;
	$res = array(
		'status' => 404,
		'message' => 'List directory success'
	);
	if ( $filename !== '' && is_file( $file ) ) {
		$file = $project.'/' . $filename;
		$res['content'] = file_get_contents( $file );
		$res['status'] = 200;
		$res['message'] = 'OK';
	}
	if ( !is_dir( $file ) ) {
		$file = dirname( $file );
		if ( $res['status'] != 200 ) {
			$res['message'] = 'File or directory not found';
		}
	} else {
		$res['status'] = 204;
	}
	$res['pwd'] = $file;
	$ls = scandir( $file );
	$res['ls'] = $ls;
	developerpack_response( $res );
}

add_action( 'wp_ajax_developerpack_save', 'developerpack_save' );
function developerpack_save() {
	$project = realpath( '..' );
	$filename = wp_normalize_path( $_POST['file'] );
	$content = stripslashes( $_POST['content'] );
	$file = $project.'/'.$filename;
	if ( $filename !== '' ) {
		$success = file_put_contents( $file, $content );
		if ( $success !== false ) {
			if ( is_file( $file ) ) {
				$res = array(
					'status' => 200,
					'message' => 'File saved successfully!'
				);
			} elseif ( !is_dir( $file )  ) {
				$res = array(
					'status' => 201,
					'message' => 'File created successfully!'
				);
			}
		} else {
			$res = array(
				'status' => 403,
				'message' => 'Permission denied!'
			);
		}
	} else {
		$res = array(
			'status' => 404,
			'message' => 'Error saving file!'
		);
	}
	developerpack_response( $res );
}

add_action( 'wp_ajax_developerpack_delete', 'developerpack_delete' );
function developerpack_delete() {
	$project = realpath( '..' );
	$filename = wp_normalize_path ( $_POST['file'] );
	$file = $project.'/'.$filename;
	if ( $filename !== '' && is_file( $file ) ) {
		$success = unlink( $file );
		if ( $success ) {
			$res = array(
				'status' => 200,
				'message' => 'File deleted successfully!'
			);
		} else {
			$res = array(
				'status' => 403,
				'message' => 'Permission denied!'
			);
		}
	} else {
		$res = array(
			'status' => 404,
			'message' => 'Nothing has been deleted!'
		);
	}
	developerpack_response( $res );
}
