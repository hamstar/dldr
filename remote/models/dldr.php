<?php

class Dldr {

    function start( Url $url ) {

        $args = $this->build_args( $url );
        $cmd = "wget $args";

        $pid = $this->run_in_background( $cmd );
        $url->set_pid( $pid );

        $url = $this->analyze_state( $url );
        return $url;
    }

    function build_args( Url $url ) {

        $log_file = RUN_PATH.$url->get_hash().'.log';
        $filename = DOWNLOAD_PATH.$url->get_hash();

        $args = array();

        $args[] = "-b {$url->get_url()}";
        $args[] = "-0 ".$log_file;
        $args[] = "-o ".$filename;

        try {
                $host = parse_url( $url->get_url(), PHP_URL_HOST );
                Cookie::exists( $host );
                $args[] = "--load-cookie ".COOKIE_PATH.$host;
        } catch ( InvalidCookieException $e ) {}

        return implode(' ', $args);
    }

    private function run_in_background( $cmd ) {

        $error_log = RUN_PATH.$this->url->get_hash().'.errors';
        return shell_exec("nohup $cmd 2> $error_log & echo $!");
    }

    private function is_running( Url $url ) {

        try {
            $pid = $url->get_pid();
            $lines = shell_exec("ps $pid|wc -l");

            if ( $lines == 2 )
                return true;

            return false;
        } catch ( InvalidProcessException $e ) {
            return false;
        }
    }

    private function analyze_log( Url $url ) {

        $log_file = RUN_PATH.$url->get_hash().'.log';
        $lines = explode( "\n", file_get_contents( $log_file ) );
        $lines = array_reverse( $lines );

        foreach ( $lines as $line ) {

            if ( !strstr( '%', $line ) )
                continue;

            preg_match( '@(\d+[MKG]).*(\d)% (.*) (.*)@', $line, $m );

            $url->set_size( $m[1] )
                ->set_percent( $m[2] )
                ->set_download_speed( $m[3] )
                ->set_time_remaining( $m[4] );
        }
    }

    function analyze_state( Url $url ) {

        if ( $this->is_running( $url ) ) {
            $url->set_status( 'running' );
        } else {
            $url->set_status( 'stopped' );
        }

        $this->analyze_log($url);

        return $url;
    }
}
