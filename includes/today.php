<?php
/** 
### License

Copyright 2018 Spinitron, LLC

Permission to use, copy, modify, and/or distribute this software for any purpose with or without fee is hereby granted, provided that the above copyright notice and this permission notice appear in all copies.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.


* Plugin Name: WsPin
* Description:  Call Spinitron API
* License:     GPL2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
*  */

include __DIR__ . '/getClient.php';
/** @var SpinitronApiClient $client */

/** today function returns upcoming programs
 *  @param count is how many hours in the future to return data for
 *  use '0' if you only want one
 */
function today($count) {
	global $client;
//	$rstring = "";

	$acount =abs($count);
	// calls Spinitron API and returns array with shows
	$result = $client->search('shows', ['end' => "+$acount hour"]);

	$tcnt = 0 ; // looks for first one to delete if necessary
	foreach ($result['items'] as $show) {
		if ( ($count >= 0) || ($tcnt != 0) ) {
			$stime = new DateTime($show['start']);
			$stime = $stime->setTimezone(new DateTimeZone($show['timezone']));
			$stime = $stime->format('g:ia') ;
			$title = htmlspecialchars($show['title'], ENT_NOQUOTES);
			$href  = !is_null($show['url']) ? $show['url'] : "#" ;
			$rstring .= <<<EOT
<p class='spin_today'>$stime <a href="$href">$title</a></p>
EOT;
		}
		$tcnt++ ;
	}
	return $rstring;
}
