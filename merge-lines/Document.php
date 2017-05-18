<?php

class Document {
    
    public $input_path;
    public $output_path;
    public $contents;
    
    public function __construct($input) {
        $this->input_path = $input;
        $this->contents = file_get_contents($this->input_path);
    }
    
}


class DocWithGoodLines extends Document {
    
    public $xml;
    public $start_chunk;
    public $end_chunk;
    
    public function __construct($input) {
        parent::__construct($input);
        $this->xml = simplexml_load_string($this->contents);
    }
    
    public function getStartEnd($p, $size = 0){
        $trimmed     = trim($p);
        $chunks      = explode("\n", $trimmed);
        $first_line  = explode(" ", array_shift($chunks));
        if(count($chunks) == 1){
            $last_line = $first_line;
        }
        else{
            $last_line   = explode(" ", array_pop($chunks));
        }
        $first_chunk = implode(" ", array_slice($first_line, 0, $size));
        $last_chunk  = implode(" ", array_slice($last_line, $size * -1));
        return array($first_chunk, $last_chunk);
    }
}