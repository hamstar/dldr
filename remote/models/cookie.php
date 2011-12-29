<?php

class InvalidCookieException extends Exception {}

class Cookie {
	
	static function create( $host, $content ) {
		
		file_put_contents( COOKIE_PATH.$host, $content );
	}
	
	static function exists( $host ) {
		
		if ( file_exists( COOKIE_PATH . $host ) )
			return true;
			
		throw new InvalidCookieException();
	}
}
