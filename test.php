<?php
include "util.php";

$str = "This is code <b>it is bold</b><br /><code>Here is some code</code><invalid>invalid block</code><code withparams=\"Hello\" something=5>Contents</code>";
echo textarea_filter($str);
?>

<form id="themforms" method="post" action="#">

    <input type="file" id="themfiles">

    <input type="button" onClick="doStuff()" value="My button">

</form>

<script type="text/javascript">

    function doStuff() {

        alert("Do sutfF? :SS");

        var fileThing = document.getElementById("themfiles");

        alert(print_r(fileThing.files[0]));

        alert(fileThing);

    }

    /**
     * Thank you stackoverflow, husker ikke hvor jeg fikk den, men var bare for
     * debugging n'eways.
     * 
     * @param arr
     * @param level
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
</script>