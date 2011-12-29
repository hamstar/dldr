<?php

class Cookie_api extends Api_strategy {
    
    function process( $data ) {
        
        try {
            
            Cookie::create( $_POST['host'], $_POST['content'] );
            Cookie::exists( $_POST['host'] );
            
            return $this->success( 'Cookie saved' );
        } catch ( InvalidCookieException $e ) {
            
            return $this->error( 'Cookie not saved' );
        }
    }
}