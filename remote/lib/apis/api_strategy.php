<?php

class Api_strategy {
    
    function error( $message ) {
        
        $json->error = 1;
        $json->message = $message;
        
        return $json;
    }
    
    function success( $message ) {
        
        $json->error = 0;
        $json->message = $message;
        
        return $json;
    }
}

