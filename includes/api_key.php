<?php
include_once "/var/www/html/wp-config.php";

function get_API_key() {
$dsn = "mysql:dbname=".DB_NAME.";host=".DB_HOST;
$user = DB_USER;
$password=DB_PASSWORD;
$db = new PDO($dsn, $user, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT option_value 
	FROM `wp_options` 
	WHERE option_name = 'WsPin_API_Key_settings'";

$result = $db->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
$pieces = explode('"',$row['option_value']);
return $pieces[3];
}
?>