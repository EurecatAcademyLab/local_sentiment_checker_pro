// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Javascript & jquery file
 * @package     local_survey_intelligence
 * @author      2023 Aina Palacios, Laia Subirats, Magali Lescano, Alvaro Martin, JuanCarlo Castillo, Santi Fort
 * @copyright   2022 Eurecat.org <dev.academy@eurecat.org>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * Documentation for the setStatusintelligence function.
 * This function sends an AJAX request to a specified URL to update the status.
 * @param {boolean} active - A boolean indicating whether the status is active (true) or inactive (false).
 * @param {string} url - A string indicating the URL to send the AJAX request to.
 * @returns {void}
 */
function setStatusintelligence(active, url) {
    let baseUrl = url.replace(/(.*\/survey_intelligence\/).*$/, '$1');
    url = baseUrl + 'classes/settings/settings.php'

    require(['jquery'], function($) {
        $(document).ready(function () { 
            $.ajax({
                url: url,
                data: {active},
                success: function(data) {
                    console.log('response_status Survey Intelligence' + data);
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('Error! ' + errorThrown);
                }
            });
        });
    });
}

/**
 * Documentation for the setH function.
 * This function sends an AJAX request to a specified URL to update the H.
 * @param {string} h - indicate.
 * @param {string} url - A string indicating the URL to send the AJAX request to.
 * @returns {void}
 */
function seth(h, url) {
    let baseUrl = url.replace(/(.*\/survey_intelligence\/).*$/, '$1');
    url = baseUrl + 'classes/settings/saveh.php'

    require(['jquery'], function($) {
        $(document).ready(function () { 
            $.ajax({
                url: url,
                data: {h},
                success: function(data) {
                    console.log('response_set Survey Intelligence' + data);
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('Error! ' + errorThrown);
                }
            });
        });
    });
}


function setHeaders(headers, xhr) {
    if (headers) {
        for (const key in headers) {
            if (headers.hasOwnProperty(key)) {
                xhr.setRequestHeader(key, headers[key]);
            }
        }
    }
}

/**
 * Calls the WooCommerce API to activate a user's account for a specified product.
 * @async
 * @param {string} yui - A unique identifier for the implementation.
 * @param {string} apikey - The API key for the WooCommerce store.
 * @param {number} product_id - The ID of the product being activated.
 * @param {string} email - The email address of the user being activated.
 * @returns {Promise<Object>} - A Promise that resolves to the response from the API.
 */
async function woocommerce_api_active_intelligence(yui, apikey, product_id, email) {
    try {
        var url = 'https://lab.eurecatacademy.org/?wc-api=wc-am-api&wc_am_action=activate';

        const urlactual = new URL(window.location.href);
        const host = urlactual.host;
        const hash = await hashString(host);

        // seth(hash, url);

        var params = {
            instance: hash,
            object: email + ','+ host,
            product_id: product_id,
            api_key: apikey
        }

        const queryString = Object.keys(params)
            .map((key) => `${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`)
            .join('&');

        const call_url = url +'&'+ queryString

        var xhr = new XMLHttpRequest();
        xhr.open('GET', call_url);
        xhr.responseType = 'json';

        xhr.onload = function() {
            if (xhr.status === 200) {
                var data = xhr.response;
                // handle data
                console.log(data);
            } else {
                // handle error
                console.error('Error getting data from API endpoint');
            }
        };

        xhr.send();

        return data;
    } catch (err) {
        console.log(err);
    }
}

/**
 * Calls the WooCommerce API to check the status of a user.
 * @async
 * @param {string} yui - A unique identifier for the implementation.
 * @param {string} apikey - The API key for the WooCommerce store.
 * @param {number} product_id - The ID of the product being checked.
 * @param {string} email - The email address of the user being checked.
 * @returns {Promise<Object>} - A Promise that resolves to the response from the API.
 */
async function woocommerce_api_status_intelligence(yui, apikey, product_id, email) {
    try {

        var url = 'https://lab.eurecatacademy.org/?wc-api=wc-am-api&wc_am_action=status';

        const urlactual = new URL(window.location.href);
        const host = urlactual.host;
        // console.log(host);
        const hash = await hashString(host);
        // console.log(hash);

        var params = {
            instance: hash,
            object: email + ','+ host,
            product_id: product_id,
            api_key: apikey
        }

        const queryString = Object.keys(params)
            .map((key) => `${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`)
            .join('&');

        const call_url = url +'&'+ queryString
        // console.log(call_url);

        var xhr = new XMLHttpRequest();
        xhr.open('GET', call_url);
        xhr.responseType = 'json';

        xhr.onload = function() {
            if (xhr.status === 200) {
                var data = xhr.response;
                // handle data
                const urlsettings = window.location.href + 'classes/settings/settings.php';
                const urlsaveh = window.location.href + 'classes/settings/saveh.php';

                if (data.status_check == 'active') {
                    var active = 1;
                    seth(hash, urlsaveh)
                    setStatusintelligence(active, urlsettings);
                    insertIntoDiv('Active User');
                } else {
                    var active = 0;
                    setStatusintelligence(active, urlsettings);
                }
                console.log(data)
            }  else {
                // handle error
                console.error('Error getting data from API endpoint');
            }
        };

        xhr.send();

        return data;
    } catch (err) {
        console.log(err);
    }
}

/**
 * Uses the SHA-256 algorithm to create a hash of the specified string.
 * @param {string} str - The string to be hashed.
 * @returns {Promise<string>} - A Promise that resolves to the hash in hexadecimal format.
 */
async function hashString(str) {
    const encoder = new TextEncoder();
    const data = encoder.encode(str);
    const buffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(buffer));
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
    return hashHex;
}

/**
 * Adds text to a specified div element and applies styles for a short period of time before removing the text and styles.
 * @param {string} text - The text to be added to the div element.
 * @returns {void}
 */
function insertIntoDiv(text) {
    var divInclude = document.getElementById('statusintelligence');

    // Insert into div
    divInclude.innerHTML = "<p class='text-info'>" + text + "</p>";

    // Insert button
    var closeButton = document.createElement('button');
    closeButton.innerHTML = 'X';
    closeButton.type = 'button'; // Agregar type='button' para prevenir recargar la página
    closeButton.classList.add('close');
    closeButton.addEventListener('click', function() {
        divInclude.innerHTML = ''; // Eliminar el contenido de divInclude
        divInclude.classList.remove('p-3', 'mb-3', 'rounded', 'bg-light', 'opacity-75', 'd-flex', 'justify-content-between', 'align-items-center');
    });

    // Insert into div
    divInclude.appendChild(closeButton);

    // Insert css
    divInclude.classList.add('p-3', 'mb-3', 'rounded', 'bg-light', 'opacity-75', 'd-flex', 'justify-content-between', 'align-items-center');
}
