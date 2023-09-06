<?php

header('Content-Type: application/json');
require_once('./config/config.php');
require_once('./functions/functions.php');
require_once('./functions/public_functions.php');


$data = json_decode(file_get_contents('php://input'));


if(is_null($data) || (!isset($data->trackId) || !isset($data->timeLeft))) {
    http_response_code(400);
}

updateUserQuizTrackTime($data->trackId, $data->timeLeft);