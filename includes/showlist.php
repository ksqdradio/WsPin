<?php
/** 
* Plugin Name: WsPin
* Description:  Call Spinitron API
* License:     GPL2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
*  */

include __DIR__ . '/getClient.php';
/** SpinitronApiClient $client */

/** showlist function returns all upcoming programs
 */
function showlist() {
	global $client;
//	$rstring = "";

	// calls Spinitron API and returns array with shows
	$result = $client->search('shows');

	foreach ($result['items'] as $show) {
                $stime = new DateTime($show['start']);
		$stime = $stime->setTimezone(new DateTimeZone($show['timezone']));
                $stime = $stime->format('l g:ia') ;
		$title = htmlspecialchars($show['title'], ENT_NOQUOTES);
		$href  = !is_null($show['url']) ? $show['url'] : "#" ;
		$rstring .= <<<EOT
<p class='spin_list'>$stime <a href="$href">$title</a></p>
EOT;
	}
	return $rstring;
}
