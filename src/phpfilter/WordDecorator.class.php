<?php

/**
 * Description of Decorator
 *
 * @author rioultf
 */
abstract class WordDecorator {

    static protected $NULL_TYPE = "NULL";
    protected $type;

    protected function __construct($_type) {
        $this->type = $_type;
    }

    public function toString() {
        //return "<decorator type=\"$this->type\"></decorator>\n";
        return $this->type . ':true';
    }

}

//-----------------------------------------------------------
abstract class WordDecoratorValue extends WordDecorator {

    protected $value;

    protected function __construct($_type, $value) {
        parent::__construct($_type);
        $this->value = $value;
    }

    public function toString() {
        return $this->type . ':' . $this->value;
    }

}

//-----------------------------------------------------------
//-----------------------------------------------------------
//-----------------------------------------------------------
class WordDecoratorConstructor {

    static public function construct($text, $lastSeparator) {
        $ret = array();
        
        if (WordDecoratorOrdinal::match($text))
            $ret[] = new WordDecoratorOrdinal($text);

        if (preg_match('/^[A-Z]+$/', $text))
            $ret[] = new WordDecoratorNoLowerCase();

        if (preg_match('/^[0-9]+$/', $text))
            $ret[] = new WordDecoratorNumber($text);

//        if (WordDecoratorYear::match($text))
//            $ret[] = new WordDecoratorYear($text);
       
//        $month = WordDecoratorMonth::match($text);
//        //echo $month . "\n";
//        if ($month != -1)
//            $ret[] = new WordDecoratorMonth($month);
        
        if ($lastSeparator == '.' && TopLevelDecorator::match($text))
            $ret[] = new TopLevelDecorator(strtoupper ($text));
       
        if (Protocol::match($text))
            $ret[] = new Protocol ($text);

        return $ret;
    }

}

//-----------------------------------------------------------
class WordDecoratorNoLowerCase extends WordDecorator {

    static private $TYPE = "noLowerCase";

    public function __construct() {
        parent::__construct(self::$TYPE);
    }

}

//-----------------------------------------------------------
class WordDecoratorFirstWord extends WordDecorator {

    static private $TYPE = "firstWord";

    public function __construct() {
        parent::__construct(self::$TYPE);
    }

}

//-----------------------------------------------------------
class WordDecoratorLastWord extends WordDecorator {

    static private $TYPE = "lastWord";

    public function __construct() {
        parent::__construct(self::$TYPE);
    }

}

//-----------------------------------------------------------
class WordDecoratorStartWith extends WordDecoratorValue {

    static private $TYPE = "startsWith";

    public function __construct($value) {
        parent::__construct(self::$TYPE, $value);
    }

}

//-----------------------------------------------------------
class WordDecoratorNumber extends WordDecoratorValue {

    static private $TYPE = "number";

    public function __construct($value) {
        parent::__construct(self::$TYPE, $value);
    }
    
}

//-----------------------------------------------------------
class WordDecoratorOrdinal extends WordDecoratorValue {

    static private $TYPE = "ordinal";

    public function __construct($value) {
        parent::__construct(self::$TYPE, substr($value, 0, strlen($value) - 2));
    }
    
    public function match($text){
        if (preg_match('/[0-9]+th/', $text) || $text == '1st' || $text == '2nd' || $text == '3rd')
                return TRUE;
        return FALSE;
    }
    
    public function toString() {
        return $this->type;
    }

}

//-----------------------------------------------------------
class WordDecoratorSeparator extends WordDecoratorValue {

    static private $TYPE = "separator";

    public function __construct($value) {
        switch ($value){
            case ' ':
                parent::__construct(self::$TYPE, 'SPACE');
                break;
            case '~':
                parent::__construct(self::$TYPE, 'TILDE');
                break;
            case '@':
                parent::__construct(self::$TYPE, 'AT');
                break;
            case '=':
                parent::__construct(self::$TYPE, 'EQUAL');
                break;
            case '#':
                parent::__construct(self::$TYPE, 'SHARP');
                break;
            case '{':
                parent::__construct(self::$TYPE, 'OACCOLADE');
                break;
            case '}':
                parent::__construct(self::$TYPE, 'CACCOLADE');
                break;
            case '[':
                parent::__construct(self::$TYPE, 'OBRACKET');
                break;
            case ']':
                parent::__construct(self::$TYPE, 'CBRACKET');
                break;
            case '(':
                parent::__construct(self::$TYPE, 'OPARENTHESE');
                break;
            case ')':
                parent::__construct(self::$TYPE, 'CPARENTHESE');
                break;
            case '|':
                parent::__construct(self::$TYPE, 'PIPE');
                break;
            case '&':
                parent::__construct(self::$TYPE, 'ESPERLUETTE');
                break;
            case ':':
                parent::__construct(self::$TYPE, 'TWO_POINTS');
                break;
            case ',':
                parent::__construct(self::$TYPE, 'COMMA');
                break;
            case '?':
                parent::__construct(self::$TYPE, 'QUESTION');
                break;
            case '.':
                parent::__construct(self::$TYPE, 'DOT');
                break;
            case '/':
                parent::__construct(self::$TYPE, 'SLASH');
                break;
            case '!':
                parent::__construct(self::$TYPE, 'EXCLAMATION');
                break;
            case '-':
                parent::__construct(self::$TYPE, 'MINUS');
                break;
            case '_':
                parent::__construct(self::$TYPE, 'UNDERSCORE');
                break;
            case '\\':
                parent::__construct(self::$TYPE, 'BACKSLASH');
                break;
            case '+':
                parent::__construct(self::$TYPE, 'PLUS');
                break;
            case '*':
                parent::__construct(self::$TYPE, 'STAR');
                break;
            case '"':
                parent::__construct(self::$TYPE, 'GUILLEMET');
                break;
            case "'":
                parent::__construct(self::$TYPE, 'QUOTE');
                break;
            default:
                die("unknown separator " . $value . "\n");
        }
    }
    
    function toString() {
        return 'separator:' . $this->value;
    }

}

//-----------------------------------------------------------
class WordDecoratorEndWith extends WordDecoratorValue {

    static private $TYPE = "endsWith";

    public function __construct($value) {
        parent::__construct(self::$TYPE, $value);
    }

}

//-----------------------------------------------------------
class WordDecoratorYear extends WordDecoratorValue {

    static private $TYPE = "year";

    static public function match($word) {
        if (preg_match('/[12][0-9][0-9][0-9]/', $word)) {
            $value = (int) $word;
            if (1800 < $value && $value <= 2100)
                return TRUE;
        }
        return FALSE;
    }

    public function __construct($value) {
        parent::__construct(self::$TYPE, $value);
    }

    public function toString() {
        return $this->type;
    }
}

//-----------------------------------------------------------
class WordDecoratorMonth extends WordDecoratorValue {

    static private $TYPE = "month";

    static public function match($word) {
        //echo "word = $word";
        switch (strtolower($word)) {
            case 'jan':
            case 'jan.':
            case 'january':
            case 'janvier':
                return 'JANUARY';
                break;
            case 'feb':
            case 'feb.':
            case 'february':
            case 'fev.':
            case 'fevrier':
            case 'février':
                return 'FEBRUARY';
                break;
            case 'mar':
            case 'mar.':
            case 'mar.':
            case 'march':
            case 'mars':
                return 'MARCH';
                break;
            case 'apr':
            case 'apr.':
            case 'april':
            case 'avril':
            case 'avr':
            case 'avr.':
                return 'APRIL';
                break;
            case 'may':
            case 'mai':
                return 'MAY';
                break;
            case 'jun':
            case 'jun.':
            case 'june':
            case 'juin':
                return 'JUNE';
                break;
            case 'jul':
            case 'jul.':
            case 'july':
            case 'juillet':
                return 'JULY';
                break;
            case 'august':
            case 'aug':
            case 'aug.':
            case 'août':
            case 'aout':
            case 'aou':
            case 'aou.':
                return 'AUGUST';
                break;
            case 'september':
            case 'sep.':
            case 'sep':
            case 'septembre':
            case 'sep.':
            case 'sep':
                return 'SEPTEMBER';
                break;
            case 'october':
            case 'oct.':
            case 'oct':
            case 'octobre':
                return 'NOVEMBER';
                break;
            case 'november':
            case 'nov.':
            case 'nov':
            case 'novembre':
                return 11;
                break;
            case 'decembre':
            case 'dec':
            case 'dec.':
            case 'decembre':
            case 'décembre':
            case 'déc.':
            case 'déc':
                return 'DECEMBER';
                break;
        }
        return -1;
    }

    public function __construct($value) {
        parent::__construct(self::$TYPE, $value);
    }

}

?>
