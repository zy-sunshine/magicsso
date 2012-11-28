<?php
require "./lib/IXR_Library.inc.php";

$rpc = new IXR_Client( "http://127.0.0.1/linuxfans/magicwordpress/xmlrpc.php" );
$status = $rpc->query(
    "demo.sayHello"    // method name
);

if( !$status ) {
    print "Error ( " . $rpc->getErrorCode( ) . " ) : ";
    print $rpc->getErrorMessage( ) . "\n";
    exit;
}

$data = $rpc->getResponse( );
print_r( $data );

?>