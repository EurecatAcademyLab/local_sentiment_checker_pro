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
function setStatusSurvey(active, url) {
    require(['jquery'], function($) {
        $(document).ready(function () { 
            $.ajax({
                url: url,
                data: {active},
                success: function(data) {
                    // console.log(data);
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
 * @param {string} host - A string indicating the host.
 * @param {string} url - A string indicating the URL to send the AJAX request to.
 * @returns {void}
 */
function sethSurvey(h, url, host) {

    require(['jquery'], function($) {
        $(document).ready(function () { 
            $.ajax({
                url: url,
                data: {h, host},
                success: function(data) {
                    // console.log(data);
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
        var data = '';
        var url = 'https://lab.eurecatacademy.org/?wc-api=wc-am-api&wc_am_action=activate';

        let urlactualSurvey = window.location.href;
        let newUrl = urlactualSurvey.replace(/\/admin(.*)$/, '');
        let finalUrlSurvey = newUrl + '/local/survey_intelligence/classes/settings/savehsurvey.php'

        const urlactualsurvey = new URL(window.location.href);
        const host = urlactualsurvey.host;
        const hash = await hashString(host + 'survey');

        sethSurvey(hash, finalUrlSurvey, host);

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
                console.log('validation Survey Intelligence: ' + data.success);
            } else {
                // handle error
                console.error('Error getting data from API endpoint');
            }
        };

        xhr.send();

        if (data != undefined) {
            return data;
        }
    } catch (err) {
        console.log(err);
    }
}

/**
 * Calls the WooCommerce API to check the status of a user.
 * @async
 * @param {string} yui - A unique identifier for the implementation.
 * @param {string} apikey - The API key for the WooCommerce store.
 * @param {number} productid - The ID of the product being checked.
 * @param {string} email - The email address of the user being checked.
 * @param {string} plugin - The plugin name.
 * @param {string} privacy - The checkbox if a user accept conditions.
 * @returns {Promise<Object>} - A Promise that resolves to the response from the API.
 */
async function woocommerce_api_status_intelligence(yui, apikey, productid, email, plugin, privacy) {
    try {

        var data = '';
        email = email.replace(/\s+/g, "");
        if (email.length == 0 || email == '') {
            console.log('email')
            validateEmailSurvey();
        } else if (!productid  || productid != 142){
            validateProductSurvey();
        } else if (apikey != 'aa7cda56d137325b560dc9d1136e5474d08ff5b9' || apikey == 0 || apikey == '' || apikey.length == 0){
            validateApikeySurvey();
        } else if ( privacy == 0){
            validatePrivacySurvey();
        } else if (apikey == 'aa7cda56d137325b560dc9d1136e5474d08ff5b9' && productid == 142 && plugin == 'survey_intelligence'){
            validateApikeySurveyCorrect();
            validateProductSurveyCorrect();

            var url = 'https://lab.eurecatacademy.org/?wc-api=wc-am-api&wc_am_action=status';

            const urlactual = new URL(window.location.href);
            const host = urlactual.host;
            const hash = await hashString(host + 'survey');

            var params = {
                instance: hash,
                object: email + ','+ host,
                product_id: productid,
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
                    const urlSurvey = window.location.href;
                    let urlSettingsSurvey, finalUrlSurvey;
                    if (urlSurvey.indexOf("index") !== -1) {
                        urlSettingsSurvey = urlSurvey.replace(/index.+$/, 'classes/settings/settingsSurvey.php');
                        finalUrlSurvey = urlSurvey.replace(/index.+$/, 'classes/settings/surveysavehash.php');
                    } else {
                        urlSettingsSurvey = urlSurvey.replace(/\/admin\/.*$/, '/local/survey_intelligence/classes/settings/settingsSurvey.php');
                        finalUrlSurvey = urlSurvey.replace(/\/admin\/.*$/, '/local/survey_intelligence/classes/settings/Surveysavehash.php');
                    }

                    // handle data
                    if (data.status_check == 'active') {
                        var active = 1;
                        sethSurvey(hash, finalUrlSurvey, host)
                        setStatusSurvey(active, urlSettingsSurvey);
                        insertIntoDivSurvey('Active User');
                        console.log('Status Survey Intelligence: ' + data.status_check);
                    } else {
                        var active = 0;
                        setStatusSurvey(active, urlSettingsSurvey);
                        console.log('Status Survey Intelligence: ' + data.status_check);
                    }
                }  else {
                    // handle error
                    console.error('Error getting data from API endpoint');
                }
            };

            xhr.send();
            if (data != undefined) {
                return data;
            }
        }
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
function insertIntoDivSurvey(text) {
    var divInclude = document.getElementById('statusintelligence');
    if (divInclude != null) {
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
}


/**
 * To check if user introduce a valid email and send a message. 
 */
function validateEmailSurvey() {

    var existingErrorDiv = document.getElementById("id_si_unvalid_mail");
    if (!existingErrorDiv) {
        var element = document.getElementById("id_s_local_survey_intelligence_email");
        if (element) {
            var sibling = element.nextSibling;
            var errorDiv = document.createElement("div");
            errorDiv.innerText = "Do not leave this field empty";
            errorDiv.setAttribute("style", "color: red");
            errorDiv.setAttribute("id", "id_si_unvalid_mail");
            element.parentNode.insertBefore(errorDiv, sibling);
        }
    }
}

/**
 * To check if user have a valid key and send a message to wrong. 
 */
function validateApikeySurvey() {
    var existingErrorDiv = document.getElementById("id_si_unvalid");
    if (!existingErrorDiv) {
        var element = document.getElementById("id_s_local_survey_intelligence_apikey");
        if (element) {
            var sibling = element.nextSibling;
            var errorDiv = document.createElement("div");
            errorDiv.innerText = "Invalid API Key";
            errorDiv.setAttribute("style", "color: red");
            errorDiv.setAttribute("id", "id_si_unvalid");
            element.parentNode.insertBefore(errorDiv, sibling);
        }
    }
}

/**
 * To check if user have a valid key and send a message "Valid". 
 */
function validateApikeySurveyCorrect() {
    var existingErrorDiv = document.getElementById("id_si_unvalid");
    if (!existingErrorDiv) {
        var element = document.getElementById("id_s_local_survey_intelligence_apikey");
        if (element) {
            var sibling = element.nextSibling;
            var errorDiv = document.createElement("div");
            errorDiv.innerText = "Valid API Key";
            errorDiv.setAttribute("style", "color: green");
            errorDiv.setAttribute("id", "id_si_unvalid");
            element.parentNode.insertBefore(errorDiv, sibling);
        }
    }
}

/**
 * To check if user have a valid key and send a message "Valid". 
 */
function validateProductSurvey() {
    var existingErrorDiv = document.getElementById("id_si_unvalid_product_Survey");
    if (!existingErrorDiv) {
        var element = document.getElementById("id_s_local_survey_intelligence_productid");
        if (element) {
            var sibling = element.nextSibling;
            var errorDiv = document.createElement("div");
            errorDiv.innerText = "Invalid Product";
            errorDiv.setAttribute("style", "color: red");
            errorDiv.setAttribute("id", "id_si_unvalid_product_Survey");
            element.parentNode.insertBefore(errorDiv, sibling);
        }
    }
}
/**
 * To check if user have a valid key and send a message "Valid". 
 */
function validateProductSurveyCorrect() {
    var existingErrorDiv = document.getElementById("id_si_unvalid_product_Survey");
    if (!existingErrorDiv) {
        var element = document.getElementById("id_s_local_survey_intelligence_productid");
        if (element) {
            var sibling = element.nextSibling;
            var errorDiv = document.createElement("div");
            errorDiv.innerText = "Valid Product";
            errorDiv.setAttribute("style", "color: green");
            errorDiv.setAttribute("id", "id_si_unvalid_product_Survey");
            element.parentNode.insertBefore(errorDiv, sibling);
        }
    }
}

/**
 * To check if user have a valid key and send a message "Valid". 
 */
function validatePrivacySurvey() {
    var existingErrorDiv = document.getElementById("id_si_unvalid_privacy");
    if (!existingErrorDiv) {
        var element = document.getElementById("id_s_local_survey_intelligence_privacy");
        if (element) {
            var sibling = element.nextSibling;
            var errorDiv = document.createElement("div");
            errorDiv.innerText = "Do not leave this checkbox uncheck";
            errorDiv.setAttribute("style", "color: red");
            errorDiv.setAttribute("id", "id_si_unvalid_privacy");
            element.parentNode.insertBefore(errorDiv, sibling);
        }
    }
}
