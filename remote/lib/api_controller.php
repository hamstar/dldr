<?php

class Api_controller {

    private function check_data($data) {
        
        if ( !isset( $data->action ) )
            throw new Exception('Action must be set');
    }

    private function pre_process($data) {
        
        $obj = new StdClass();
        
        foreach ( $data as $key => $value )
            $obj->$key = urldecode($value);
        
        return $obj;
    }
    
    private function set_strategy( $action ) {
        
        $filename = 'apis/'.$action.'_api.php';
        $classname = ucfirst( $action.'_api');
        
        if ( !file_exists( $filename ) )
            throw new Exception('Api file not found');
            
        require $filename;
        
        if ( !class_exists( $classname ) )
            throw new Exception('Api class not found');
        
        $this->strategy = new $classname;
    }
    
    function process( $data ) {
        
        $data = $this->pre_process( $data );
        $this->check_data( $data );
        $this->set_strategy( $data->action );
        
        $this->result = $this->strategy->process( $data );
    }
    
    function result() {
        
        return json_encode( $this->result );
    }
}