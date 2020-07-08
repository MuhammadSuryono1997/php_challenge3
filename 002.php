<?php 
//Something to write to txt log
// $log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
//         "Attempt: ".($result[0]['success']=='1'?'Success':'Failed').PHP_EOL.
//         "User: ".$username.PHP_EOL.
//         "-------------------------".PHP_EOL;

$log = "[".date("Y-m-d g:i")."]".PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('./app.log', $log, FILE_APPEND);
 ?>