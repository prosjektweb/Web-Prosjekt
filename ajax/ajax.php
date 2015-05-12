<?php
// Require init
require (dirname ( __FILE__ ) . "/" . '../modules/Init.common.php');

// Set templates dir
// chaining of method calls
$smarty->setTemplateDir ( dirname ( __FILE__ ) . "/" )->setCompileDir ( dirname ( __FILE__ ) . "/" . "../templates_c/" );

?>