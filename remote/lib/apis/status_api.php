<?php

class Status_api extends Api_strategy {
    
    function process( $data ) {
        
        try {
            $url = Url::find( $_GET['hash'] );
            $dldr = new Dldr();
            $url = $dldr->analyze_state($url)->save();
            return $url->to_json();
        } catch ( InvalidUrlException $e ) {

        }
    }
}