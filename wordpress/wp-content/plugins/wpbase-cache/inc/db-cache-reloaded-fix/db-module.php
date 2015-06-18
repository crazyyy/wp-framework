<?php
    $path = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
    if(is_file($path.'/db.php')){
    rename($path.'/db.php',$path.'/db_old.php');
    header( "refresh:2;" );

    }
?>