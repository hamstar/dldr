<?php

if ( isset( $_GET['action'] ) ) {
	
	switch ( $_GET['action'] ) {
		case 'download':
			$url = new Url( $_GET['url'] );
			$dldr = new Dldr();
			$dldr->start( $url );
			$api->status = "running";
			$api->size = $dldr->get_size();
			break;
		case 'status':
			break;
		default:
			$api->message = 'Invalid Action';
			$api->error = 1;
			break;
	}
}

if ( isset( $_POST['action'] ) {
	
	switch ( $_POST['action'] ) {
		case 'cookie':
			try {
				Cookie::create( $_POST['host'], $_POST['content'] );
				Cookie::exists( $_POST['host'] );
				$api->error = 0;
				$api->message = 'Cookie saved';
			} catch ( InvalidCookieException $e ) {
				$api->message = 'Cookie not saved';
				$api->error = 1;
			}
			break;
		default:
			$api->message = 'Invalid Action';
			$api->error = 1;
			break;
	}
}

echo json_encode( $api );
