<?php

error_reporting();

require_once 'Text.class.php';


if ($argc != 2) {
    echo "erreur usage : $argv[0] <mail.txt>\n";
    exit();
}
$path = $argv[1];

require_once('../lib/php-mime-mail-parser-read-only/MimeMailParser.class.php');

$Parser = new MimeMailParser();
$Parser->setText(file_get_contents($path));
//$Parser->setPath($path);

$from = $Parser->getHeader('from');
$subject = iconv_mime_decode($Parser->getHeader('subject'), 0, "ISO-8859-1");
$text = $Parser->getMessageBody('text');
//$html = $Parser->getMessageBody('html');
$attachments = sizeof($Parser->getAttachments());

// dump it so we can see
//echo $subject . "\n";
echo $text . "\n";
?>
