<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

$file = "log/log.txt";
$f = fopen($file, 'rb');
$line = fgets($f);
fclose($f);
$contents = file($file, FILE_IGNORE_NEW_LINES);
$first_line = array_shift($contents);
file_put_contents($file, implode("\r\n", $contents));
// $time = date('r');
echo "data:{$line}\n\n";
flush();
?>