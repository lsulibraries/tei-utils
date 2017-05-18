<?php

$text = <<<EOD
   
yourself.”

 “ Would’nt it answer, Bobby, if I were to leave it at ran-
dom—some time within a year or so, for example ?—must I

say precisely ?”

“If you please, uncle—precisely.-

“Well, then, Bobby, my boy—you’re a fine fellow, are’nt

294

THE BROADWAY JOURNAL.

you ?—since you will have the exact time, I’ll—why, I’ll
oblige you for once.”
EOD;

$pattern = '#([0-9]+)\n+THE BROADWAY JOURNAL\.*#';

        //$printmatches = array();
$match = preg_match($pattern, $text, $matches);



$pairs = array(
        '#([0-9]+)\n+THE BROADWAY JOURNAL\.*#' => "<pb n=\"$1\"/>",
    );
$txt = preg_replace(array_keys($pairs), array_values($pairs), $text);
//$txt = preg_replace('#([0-9]+)\n+THE BROADWAY JOURNAL\.*#', "<pb n=\"$1\"/>", $text);

var_dump($matches);

var_dump($txt);

?>