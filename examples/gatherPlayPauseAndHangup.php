<?php
/**
 *  ██████╗██╗      ██████╗ ██╗   ██╗██████╗  ██████╗ ███╗   ██╗██╗██╗  ██╗
 * ██╔════╝██║     ██╔═══██╗██║   ██║██╔══██╗██╔═══██╗████╗  ██║██║╚██╗██╔╝
 * ██║     ██║     ██║   ██║██║   ██║██║  ██║██║   ██║██╔██╗ ██║██║ ╚███╔╝
 * ██║     ██║     ██║   ██║██║   ██║██║  ██║██║   ██║██║╚██╗██║██║ ██╔██╗
 * ╚██████╗███████╗╚██████╔╝╚██████╔╝██████╔╝╚██████╔╝██║ ╚████║██║██╔╝ ██╗
 *  ╚═════╝╚══════╝ ╚═════╝  ╚═════╝ ╚═════╝  ╚═════╝ ╚═╝  ╚═══╝╚═╝╚═╝  ╚═╝
 *
 * @project :  cxml-php
 * @filename: gatherPlayPauseAndHangup.php
 * @author  :   nirs
 * @created :  2024-08-28
 */

require(__DIR__ . "/../vendor/autoload.php");

use Cloudonix\CXML\Response;

$responder = new Response();
$responder->gather([
    $responder->nest->play("https://example.com/playfile.mp3")->attributes(["loop" => 3]),
    $responder->nest->pause()->attributes(["length" => 5]),
])->attributes(["action" => "https://example.com/script.php"]);
$responder->hangup();

echo $responder;