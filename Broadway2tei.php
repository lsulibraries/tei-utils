<?php 
require_once 'txt2tei.php'
class Broadway2tei extends txt2tei {
    
    function break_pages($txt){
        
        $pairs = array(
            '#(\-\n+)([0-9]+)\n+THE BROADWAY JOURNAL\.*#' => "$1<pb n=\"$2\" break=\"no\" />",
            '#(\-\n+)THE BROADWAY JOURNAL\.*\n+([0-9]+)#' => "$1<pb n=\"$2\" break=\"no\" />",
            '#([0-9]+)\n+THE BROADWAY JOURNAL\.*#' => "<pb n=\"$1\"/>",
            '#THE BROADWAY JOURNAL\.*\n+([0-9]+)#' => "<pb n=\"$1\"/>",
        );
        $txt = preg_replace(array_keys($pairs), array_values($pairs), $txt);
        return $txt;
    }

}