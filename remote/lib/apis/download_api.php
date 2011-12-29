<?php

class Download_api extends Api_strategy {
    
    function process( $data ) {
        
        $url = new Url( $_GET['url'] );
        $dldr = new Dldr();
        $dldr->start( $url );
        
        return $url->to_json();
    }
}