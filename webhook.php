<?php
define("ERROR_FILE", dirname(__FILE__) . "/error.txt");
define("LOG_FILE", dirname(__FILE__) . "/ratings.txt");

$body = file_get_contents("php://input");
$notification = json_decode($body, true);

if ($notification == NULL) {
	http_response_code(500);
	file_put_contents(ERROR_FILE, $body . "\n", FILE_APPEND | LOCK_EX);
	exit();
}

foreach ($notification ["messages"] as $message) {
	if ($message ["type"] != "menu_rating") {
		continue;
	}
	$poi = $message ["poi"];
	writeLog($poi ["country"] . "\t");
	writeLog($poi ["location"] . "\t");
	writeLog($poi ["poi"] . "\t");
	$rating = $message ["rating"];
	writeLog($rating ["id"] . "\t");
	writeLog($rating ["timestamp"] . "\t");
	writeLog($rating ["stars"] . "\t");
	$meal = $rating ["meal"];
	writeLog($meal ["day"] . "\t");
	$category = $meal ["category"];
	writeLog($category ["position"] . "\t");
	writeLog($meal ["position"] . "\n");
}

function writeLog($content) {
	file_put_contents(LOG_FILE, $content, FILE_APPEND | LOCK_EX);
}

?>