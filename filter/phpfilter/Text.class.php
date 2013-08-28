<?php

require_once 'Sentence.class.php';


/**
 * Description of Text
 *
 * @author rioultf
 */
class Text {
    //put your code here

    /**
     * the string content
     * @var string 
     */
    private $text = "";

    /**
     * constructor
     * @param string $_text
     */
    function __construct($_text) {
        $this->text = $_text;

        $sentences = split("\n", $this->text);
        foreach ($sentences as $sentence) {
            //echo "----" . $sentence . "\n";
            $seq = new Sentence($sentence);
            echo $seq->toString() . "\n";
        }
    }

}
?>
