/**
 * The root address of the document,
 * this is set by the php code
 * @type String|url
 */
var _root = "";

/**
 * Set the ${root} address of the document
 * @param {type} url
 * @returns {undefined}
 */
function wp_set_root(url) {
    _root = url;
}

/**
 * Get the ${root} address of the document
 * @returns {_root|String|url}
 */
function wp_get_root() {
    return _root;
}

/**
 * Simple debug helper for appending HTML to a output div
 * @param {type} msg
 * @returns {undefined}
 */
function dbg(msg) {
    $("#output").append(msg + "<br />");
}

/**
 * Convert the given string into a more HTML friendly format by replacing \r\n with <br>
 * @param {string} msg
 * @returns {string}
 */
function nl2br(msg) {
    return msg.replace(/(?:\r\n|\r|\n)/g, '<br />');
}

/**
 * Function for helping debugging
 * @source http://stackoverflow.com/questions/603987/what-is-the-javascript-equivalent-of-var-dump-or-print-r-in-php
 * @param {type} arr
 * @param {type} level
 * @returns {String}
 */
function print_r(arr, level) {
    var dumped_text = "";
    if (!level)
        level = 0;

    // The padding given at the beginning of the line.
    var level_padding = "";
    for (var j = 0; j < level + 1; j++)
        level_padding += "    ";

    if (typeof (arr) == 'object') { // Array/Hashes/Objects
        for (var item in arr) {
            var value = arr[item];

            if (typeof (value) == 'object') { // If it is an array,
                dumped_text += level_padding + "'" + item + "' ...\n";
                dumped_text += print_r(value, level + 1);
            } else {
                dumped_text += level_padding + "'" + item + "' => \"" + value
                        + "\"\n";
            }
        }
    } else { // Stings/Chars/Numbers etc.
        dumped_text = "===>" + arr + "<===(" + typeof (arr) + ")";
    }
    return dumped_text;
}