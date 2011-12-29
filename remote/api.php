<?php

if ( isset( $_GET['action'] ) ) {
    $data = $_GET;
} else if ( isset( $_POST['action'] ) ) {
    $data = $_POST;
} else {
    die('arggh!');
}

require 'config.php';
require 'lib/api_controller.php';
require 'lib/apis/api_strategy.php';

$api = new Api_controller();
$api->process( $data );

echo $api->result();
