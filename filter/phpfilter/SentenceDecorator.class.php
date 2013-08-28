<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SentenceDecorator
 *
 * @author rioultf
 */

abstract class SentenceDecorator {
    //put your code here
    
    static protected $NULL_TYPE = "NULL";
    protected $type;

    protected function __construct($_type) {
        $this->type = $_type;
    }

    public function toString() {
        return "<decorator type=\"$this->type\"></decorator>\n";
        return $this->type;
    }

}

class SentenceDecoratorConstructor {

    static public function construct($sentence) {
        //echo "$text\n";
        $ret = array();
        
        if (ShortSentenceDecorator::match($sentence))
            $ret[] = new ShortSentenceDecorator();
        if (HLineDecorator::match($sentence))
            $ret[] = new HLineDecorator();
        
        return $ret;
    }

}

class ShortSentenceDecorator extends SentenceDecorator{
    static private $MAX_WORD = 20;
    static private $TYPE = "SHORT_SENT";
    
    static public function match($sentence){
        return ($sentence->getSize() <= self::$MAX_WORD);
    }
    
    public function __construct(){
        parent::__construct(self::$TYPE);
    }
}

class HLineDecorator extends SentenceDecorator{
    static private $TYPE = "HLINE";
    
    static public function match($sentence){
        return strlen($sentence->getText()) / $sentence->getSize() < 1.2;
    }
    
    public function __construct(){
        parent::__construct(self::$TYPE);
    }
}

class EnumDecorator extends SentenceDecorator{
    static private $TYPE = "ENUM";
    
    static public function match($sentence){
        return true;
    }
    
    public function __construct(){
        parent::__construct(self::$TYPE);
    }
}

?>
