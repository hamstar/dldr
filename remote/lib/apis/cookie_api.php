<?php

class Cookie_api extends Api_strategy {
    
    function process( $data ) {
        
        try {
            
            Cookie::create( $data->host, $data->content );
            Cookie::exists( $data->host );
            
            return $this->success( 'Cookie saved' );
        } catch ( InvalidCookieException $e ) {
            
            return $this->error( 'Cookie not saved' );
        }
    }
}