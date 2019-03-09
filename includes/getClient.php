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

/**
 * @var SpinitronApiClient $client a client instance available in any including context
*/

if (!isset($client)) {
    include_once __DIR__ . '/SpinitronApiClient.php';
    include_once __DIR__ . '/api_key.php';
    $API_key = get_API_key();

    $client = new SpinitronApiClient(
//        get_option('WsPin_API_Key_settings')['WsPin_API_Key_field'],
        $API_key,
        __DIR__ . '/../cache'
    );
}

