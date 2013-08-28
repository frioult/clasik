<?php

error_reporting();

require_once 'Text.class.php';


if ($argc != 2){
    echo "erreur usage : $argv[0] <mail.txt>\n";
    exit();
}
$path = $argv[1];

$input = fopen($path, "r");
if ($input == NULL){
    echo "can't open input=$input\n";
    exit(1);
}

$text = '';
while (!feof($input)){
    $text .= fgets($input);
}

$t = new Text($text);

//var_dump($attachments[0]->content, $attachments[0]->extension);


?>
