<?php

class Url {
    
    private $status;
    private $size;
    private $percent;
    private $speed;
    private $time;
    private $pid;
    private $hash;
    private $url;
    
    function __construct( $url=null ) {
        
        if ( !is_null( $url ) ) {
            $this->url = $url;
            $this->hash = md5( $url );
            $this->status = "new";
        }
    }
    
    function find( $hash ) {
        
        if ( !file_exists( DATA_PATH.$hash.'.json' ) )
            throw new InvalidUrlException();
        
        $data = json_decode( file_get_contents( DATA_PATH.$hash.'.json' ) );
        
        foreach ( get_object_vars($data) as $key => $value )
            $this->$key = $value;
    }
    
    function save() {
        
        foreach ( get_object_vars($this) as $field => $value )
            $json->$field = $value;
        
        file_put_contents(DATA_PATH.$hash.'.json', json_encode( $json ) );
        
        return $this;
    }
    
    function to_json() {
        
        if ( !file_exists( DATA_PATH.$hash.'.json' ) )
            throw new InvalidUrlException();
        
        return file_get_contents( DATA_PATH.$hash.'.json' );
    }
    
    function set_size( $size ) {
        
        $this->size = $size;
        return $this;
    }
    
    function set_percent( $percent ) {
        
        if ( $percent == 100 )
            $this->set_status( 'complete' );
        
        $this->percent = $percent;
        return $this;
    }
    
    function set_download_speed( $speed ) {
        
        $this->speed = $speed;
        return $this;
    }
    
    function set_time_remaining( $time ) {
        
        $this->time = $time;
        return $this;
    }
    
    function set_status( $status ) {
        
        $this->status = $status;
        return $this;
    }
    
    function set_pid( $pid ) {
        
        file_put_contents(RUN_PATH.$url->get_hash().'.pid', $pid);
    }
    
    function get_pid() {
        
        if ( file_exists(RUN_PATH.$url->get_hash().'.pid') )        
            return file_get_contents(RUN_PATH.$url->get_hash().'.pid');
        
        throw new InvalidProcessException();
    }
}