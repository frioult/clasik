<?php

require_once 'Word.class.php';
require_once 'SentenceDecorator.class.php';
/**
 * Description of sentence
 *
 * @author rioultf
 */
class Sentence {

    /**
     * the string content
     * @var string 
     */
    private $text = "";

    /**
     * the array of word
     * @var array of word
     */
    private $words = array();

    /**
     * array of sentence decorator
     */
    
    private $decorators = array();
    
    /**
     * array of separator
     */
    static private $separators = array('#', '@', '~', '{', '|', '}', '&', '=', '[', ']', '=', '(', ')', '/', '?', '\\', '+', '-', '*', '"', "'", ':', '.', ' ', '!', '?', ',');
    
    /**
     * constructor
     * @param string $_text
     */
    function __construct($_text) {
        $this->text = $_text;
        //echo "$_text" . strlen($_text) . "\n";
        if (strlen($this->text) == 0)
            return;
        // découpage en mots selon les séparateurs
        $mot = '';
        $i = 0;
        $lastSeparator = '';    // le dernier séparateur avant l'insertion d'un mot
        while (true) {
            if (in_array($this->text[$i], self::$separators) ){
                //echo "sepa $i " . $mot . '"' . $this->text[$i] . '"' . "\n";
                if (strlen($mot) != 0)
                    $this->words[] = new Word($mot, $lastSeparator);
                $mot = '';
                $separator = new Word($this->text[$i], $lastSeparator);
                $lastSeparator = $this->text[$i];
                $separator->decorate(new WordDecoratorSeparator($this->text[$i]));
                $this->words[] = $separator;
                //print_r($this->words);
            }else
                $mot .= $this->text[$i];
            $i ++;
            if ($i >= strlen($this->text))
                break;
        }
        if (strlen($mot) != 0)
            $this->words[] = new Word($mot, $lastSeparator);
        //echo "$i size=" . sizeof($this->words) . "\n";
        $this->words[0]->decorate(new WordDecoratorFirstWord());
        $this->words[sizeof($this->words) - 1]->decorate(new WordDecoratorLastWord());
        
        $this->decorators = SentenceDecoratorConstructor::construct($this);
    }
    
    /**
     * returns the size ie the number of words
     * @return type
     */
    function getSize(){
        return sizeof($this->words);
    }
    
    /**
     * text accessor
     */
    function getText(){
        return $this->text;
    }
    
    /** 
     * return the average length of a word
     * @return string
     */
    function avgWordLength(){
        if ($this->getSize() ==0)
            return 0;
        return strlen($this->text) / $this->getSize();
    }

    function toString() {
        $ret = '';
        foreach ($this->words as $word)
            $ret .= $word->toString();
        //$ret .= round($this->avgWordLength(), 2) . " '$this->text'\n";
//        foreach ($this->decorators as $decorator){
//            echo "totut\n";
//            $ret .= $decorator->toString() . "dec\n";
//        }
        return $ret; // . "</sentence>\n";
    }

}

?>
