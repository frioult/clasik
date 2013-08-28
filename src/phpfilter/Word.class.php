<?php

require_once 'WordDecorator.class.php';
require_once 'InternetDecorator.php';

/**
 * Description of Word
 *
 * @author rioultf
 */
class Word {

    /**
     * the string content
     * @var string 
     */
    private $text = "";
    private $decorators = array();

    /**
     * constructor
     * @param string $_text
     */
    function __construct($_text, $lastSeparator) {
        $this->text = $_text;

        $this->decorators = WordDecoratorConstructor::construct($this->text, $lastSeparator);
    }

    function decorate($decorator) {
        $this->decorators[] = $decorator;
    }

    function toString() {
        $ret = '';
        //if (sizeof($this->decorators) == 0){
        if (preg_match('/[a-z]+/i', $this->text)) {
            $ret .= 'text:' . strtolower($this->text);
            $ret .= ' ';
        }
        //$ret = "<content>$this->text</content>\n";
        foreach ($this->decorators as $decorator) {
            $ret .= $decorator->toString();
            $ret .= ' ';
            //$ret .= "\n";
        }
        return $ret;
    }

}

?>
