<?php 
require_once 'txt2tei.php';
class zola2tei extends txt2tei {
    function delineate_text($txt){
        return $txt;
    }
    
    function paragraphize($txt){
        $txt = preg_replace("/[\n]{3,}/", "\n\n", $txt);
        $parray = explode("\n\n", $txt);
        $paragraphs = '<p>';
        return $paragraphs . implode('</p><p>', $parray) . '</p>';
    }

    function postClean($cleantext){
        $distincts = explode("\n", file_get_contents($this->settings['files']['terms']));

        foreach($distincts as $distinct){
            $count = substr_count($cleantext, $distinct);
            echo "looking for $distinct ($count)\n";
            $cleantext = preg_replace("/$distinct/u", "<distinct>$distinct</distinct>", $cleantext);
        }
        return $cleantext;
    }
}

$z = new zola2tei();
$z->main($argv[1]);