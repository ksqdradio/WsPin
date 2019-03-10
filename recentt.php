<?php
/**
* @file recent.php
* Purpose: refresh page with recent spins
*
* @author Keith Gudger
* @license    http://opensource.org/licenses/BSD-2-Clause
* @version    Release: 1.0
* @package    Spinitron WsPin Wordpress Plugin
* @note       Copy this file to your Wordpress top directory
*
*/

require_once 'wp-content/plugins/WsPin/includes/recent.php';
$count = $_REQUEST['count'];

if (!isset($count)) // sets default to 5 if not present.
        $count = 5 ;

echo recent(intval($count)) ; // count is how many songs
//echo "Count is $count";

?>
