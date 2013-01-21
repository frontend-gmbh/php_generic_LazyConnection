<?php
include('LazyConnection.php');
include('LazyConnector.php');


// define a function to open a session
$session_open = function(){
    return session_start();
};

// define a function to get a session-value. first parameter has to be a always handler
$session_get = function($handler,$value){
    if(isset($_SESSION[$value])){
        return $_SESSION[$value];
    }
    return '';
};

// define a function to store values in a session
$session_add = function($handler,$keyvaluearray){
    $_SESSION[$keyvaluearray[0]] =  $keyvaluearray[1];
};

// init a LazyConnector
$lc = new LazyConnector();
$lc->addConnection('session', $session_open);
$lc->addConnectionfunction('session','get',$session_get);
$lc->addConnectionfunction('session','add',$session_add);



// now we can lazy store something in a session
$lc->useConnectionfunction('session','add',array('testindex','testvalue'));

// ..and get data from a session
echo $lc->useConnectionfunction('session','get','testindex');

