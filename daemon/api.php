<?php

switch ( $_GET['action'] ) {
	case 'download_complete':
		$url = new Url( $_GET['hash']);
		$url->set_status( 'complete' )
			->save();
		
		$notifier = new Notifier();
		$notifier->send_new_download();
		break;
	default:
		$api->message = 'Invalid Action';
		$api->error = 1;
		break;
}

echo json_encode( $api );

?>
