<?php
include('LazyConnection.php');
include('LazyConnector.php');


// define a function to open a mysqlconnection and return the the mysql-link
$mysql_open = function(){
    $mysql_host = 'localhost';
    $mysql_user = 'root';
    $mysql_pass = '';
    $mysql_db = 'test';

    $mysql_link = mysql_connect($mysql_host, $mysql_user, $mysql_pass);
    mysql_query("SET NAMES 'utf8'",$mysql_link);
    if (!$mysql_link) {
        die(mysql_error());
    }
    $db_selected = mysql_select_db($mysql_db, $mysql_link);
    if (!$db_selected) {
        die(mysql_error());
    }
    return $mysql_link;
};

//define a function to close the connection
$mysql_close = function($handler){
    mysql_close($handler);
};

// define a function to fire a query
$mysql_query = function($handler,$value){
    return mysql_query($value,$handler);
};

// init a LazyConnector
$lc = new LazyConnector();
$lc->addConnection('mysql', $mysql_open, $mysql_close);
$lc->addConnectionfunction('mysql','query',$mysql_query);



// now you can use the mysql-connection lazy
$result = $lc->useConnectionfunction('mysql','query','SELECT testcol1, testcol2 FROM testtable');
while($row = mysql_fetch_array($result)){
    print_r($row);
}

//at the termination the connection will be closed automatically