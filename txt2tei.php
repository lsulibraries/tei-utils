<?php

class txt2tei {

    public $settings = array();

    function main($ini){

        $this->settings    = parse_ini_file($ini, true);
        $output_dir   = $this->settings['files']['output_dir'];
        $input_dir   = $this->settings['files']['input_dir'];
        $input_files = array_diff(scandir($input_dir), array('..', '.'));
        $teiheader   = file_get_contents($this->settings['files']['tei_header_path']);
        $teiclose    = file_get_contents($this->settings['files']['tei_close_path']);


        foreach($input_files as $file){
            if(is_dir($file)){
                continue;
            }
            $rawtext   = file_get_contents($input_dir.DIRECTORY_SEPARATOR.$file);
            $cleantext = $this->clean_entities($rawtext);

            $textFeatures = $this->textFeatures($cleantext);
            
            $text_elem = $this->get_text_element($textFeatures);
            $outfile   = str_replace('txt', 'xml', $file);
            $rawXML    = $teiheader.$text_elem.$teiclose;
var_dump($output_dir);
            file_put_contents($output_dir.DIRECTORY_SEPARATOR.$this->get_basename($file).'.xml', $rawXML);
            $xml       = $this->make_doc($rawXML);
            //file_put_contents($output_dir.DIRECTORY_SEPARATOR.get_basename($file).'.xml', $xml);

        }
    }

    function textFeatures($cleantext){

    }

    function make_doc($raw){
        $xml = new DOMDocument();
        $xml->loadXML($raw);
        $xml->formatOutput = true;
        return $xml->saveXML();
    }

    //outermost wrapper
    function get_text_element($txt){

        $body = $this->get_body_element($txt);
        $text = <<<TEX
          <text>
            <front>
              <!-- front matter, if any, goes in <div>s, here -->
            </front>
            <body>
              <!-- main document goes here, possibly divided into <div>s -->
                  <div>$body</div>
            </body>
            <back>
              <!-- here is a sample place for contextual information: -->
              <div type="editorial">
                <listPerson>
                  <person>
                    <persName><!-- canonical name --></persName>
                    <birth>
                      <placeName><!-- where born; date on when= of <birth> --></placeName>
                    </birth>
                    <death>
                      <placeName><!-- where died; date on when= of <death> --></placeName>
                    </death>
                  </person>
                </listPerson>
              </div>
            </back>
          </text>
TEX;

        return $text;
    }

    function get_body_element($txt){
        $broken_pages = $this->break_pages($txt);
        $paragraphized = $this->paragraphize($broken_pages);
        return $paragraphized;
    }

    function delineate_text($txt){
        $txt = preg_replace("/\n/", "\n<lb/>", $txt);
        $txt = preg_replace("#-\n<lb/>#", "-\n<lb break=\"no\"/>", $txt);
        return $txt;
    }

    function break_pages($txt){
        return $txt;
    }

    function paragraphize($txt){
        $parray = explode("\n\n", $txt);
        $paragraphized = '';
        $single_lines = true;
        $tmp_string = '<p>';

        foreach($parray as $p){

            if(substr_count($p, "\n") > 1){
                $paragraphized .= $tmp_string."</p>";
                $tmp_string = '<p>';
                $paragraphized .= "<p>".$this->delineate_text($p)."</p>";
                $single_lines = false;
            }else{
                $tmp_string .= $p."\n";
                $single_lines = true;
            }
        }
        $paragraphized = $single_lines ? $paragraphized.$tmp_string."</p>" : $paragraphized;

        return $paragraphized;
    }

    function clean_entities($txt){
        // nix newlines
        $txt = preg_replace("/\r\n/", "\n", $txt);
        
        // entities
        $ents = array(
            '/&/' => '&amp;'
        );
        $out =  '';
        foreach($ents as $char => $ent){
            $out .= preg_replace(array_keys($ents), array_values($ents), $txt);
        }
        return $out;
    }

    function get_basename($filename){

        $chunks = explode(DIRECTORY_SEPARATOR, $filename);
        if(count($chunks) > 0){
            $filenamne = array_pop($chunks);
        }
        $fixes  = explode('.', $filenamne);
        $prefix = $fixes[0];

        return $prefix;
    }
}

$app = new txt2tei();
$app->main($argv[1]);