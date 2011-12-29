<?php

class Url {
	
	function __construct( $url ) {
		
	}
	
	static function find( $hash ) {
		
	}
	
	function set_status( $status ) {
		
		if ( $status == 'complete' ) {
			$this->percent = 100;
			$this->download_speed = 0;
		}
		
		$this->status = $status;
	}
	
}
