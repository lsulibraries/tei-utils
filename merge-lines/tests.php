<?php

require_once 'Document.php';


function testGetStartEnd(){
    $clean = new DocWithGoodLines('docs/in/clean/BroadwayJournal_18450628.xml');
    foreach($clean->xml->getDocNamespaces() as $strPrefix => $strNamespace) {
        if(strlen($strPrefix)==0) {
            $strPrefix="a"; //Assign an arbitrary namespace prefix.
        }
        $clean->xml->registerXPathNamespace($strPrefix,$strNamespace);
    }
    $paras = $clean->xml->xpath("//$strPrefix:p");
    //var_dump($paras); die();
    foreach($paras as $p){
        //echo $p;  
        list($start, $end) = $clean->getStartEnd($p->__toString(), 5);
        var_dump($start, $end);
        echo "\n";
    }
    
}


testGetStartEnd();