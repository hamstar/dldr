<?php

class Dldr {

	function start( Url $url ) {
		
		$this->url = $url;
		$args = $this->build_args();
		$cmd = "wget $args";
		
		$pid = $this->run_in_background( $cmd );
	}
	
	function build_args() {
		
		$this->log_file = RUN_PATH.$this->url->get_hash();
		$this->filename = DOWNLOAD_PATH.$this->url->get_hash();
		
		$args = array();
		
		$args[] = "-b {$url->get_url()}";
		$args[] = "-0 ".$this->log_file;
		$args[] = "-o ".$this->filename;
		
		try {
			$host = parse_url( $this->url->get_url(), PHP_URL_HOST );
			Cookie::exists( $host );
			$args[] = "--load-cookie ".COOKIE_PATH.$host;
		} catch ( InvalidCookieException $e ) {}
		
		return implode(' ', $args);
	}
	
	function run_in_background( $cmd ) {
		
		$error_log = RUN_PATH.$this->url->get_hash().'.errors';
		return shell_exec("nohup $cmd 2> $error_log & echo $!");
	}
}
