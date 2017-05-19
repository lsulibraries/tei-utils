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

    function textFeatures($cleantext){
        $distincts = file($this->settings['files']['terms'], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); //file('somefile.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach($distincts as $distinct){
            $count = substr_count($cleantext, $distinct);
            $needle = strtolower($distinct);
            $needle = str_replace(' ', '\s', $needle);
            //$cleantext = str_ireplace($distinct, "<distinct type='slang'>$distinct</distinct>", $cleantext);
            $cleantext = preg_replace("/\b$distinct\b/iu", "<distinct type='slang'>$distinct</distinct>", $cleantext);
        }
        return $this->markChapterHeads($cleantext);
    }

    function markChapterHeads($txt){
        $out = preg_replace("/\n\n+([IVX])+\n\n+/U", "<head>$1</head>", $txt);
        return $out;

    }
}

$z = new zola2tei();
$z->main($argv[1]);