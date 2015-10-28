<?php

class Date {

    /**
     * Are the months named in pt-BR, ordered calendar.
     * 
     * @var array
     */
    static $months_pt_br = array(
        'Janeiro',
        'Fevereiro',
        'Março',
        'Abril',
        'Maio',
        'Junho',
        'Julho',
        'Agosto',
        'Setembro',
        'Outubro',
        'Novembro',
        'Dezembro'
    );
    
    /**
     * Is the date passed in constructor Class
     * @var string
     */
    private $date;
    
    /**
     * Is the date divided by construct param $inputFormat
     * 
     * @var string
     */
    private $dateExplode;
    
    /**
     * Is the template format to applied date final.
     * 
     * @var string
     */
    private $outputFormat;
    
    /**
     * This is the format that the date came earlier.
     * 
     * @var string
     */
    private $inputFormat;

    /**
     * Construct date Object.
     * 
     * @param type $date
     * @param type $inputFormat
     * @param type $outputformat
     */
    public function __construct($date, $inputFormat = 'Y-m-d H:i:s', $outputformat = 'Y-m-d H:i:s') {
        $this->date = $date;
        $this->inputFormat = $inputFormat;
        $this->outputFormat = $outputformat;
        $this->dataExplode();
        $this->outputFormat();
    }

    public function getDate() {
        return $this->date;
    }

    public function getExplode() {
        return $this->dateExplode;
    }

    public function getYear() {
        return $this->dateExplode['Y'];
    }

    public function getMonth() {
        return $this->dateExplode['m'];
    }

    public function getDay() {
        return $this->dateExplode['d'];
    }

    public function getHour() {
        return $this->dateExplode['H'];
    }

    public function getMinute() {
        return $this->dateExplode['i'];
    }

    public function getSecond() {
        return $this->dateExplode['s'];
    }

    private function outputFormat() {
        $this->date = $this->outputFormat;
        $outputFormat = preg_replace('/[^a-zA-Z]/', '', $this->outputFormat);

        foreach (str_split($outputFormat) as $char) {
            if (array_key_exists($char, $this->dateExplode)) {
                $this->date = str_replace($char, $this->dateExplode[$char], $this->date);
            }
        }
    }

    private function dataExplode() {
        $date = preg_replace('/[^0-9]/', '', $this->date);
        $inputFormat = preg_replace('/[^a-zA-Z]/', '', $this->inputFormat);

        foreach (str_split($inputFormat) as $char) {
            $remove = $char == 'Y' ? 4 : 2;
            $this->dateExplode[$char] = str_pad((substr($date, 0, $remove) ? : 00), $remove, 0, STR_PAD_LEFT);
            $date = substr($date, $remove);
        }
    }

    public function is() {
        $date = \DateTime::createFromFormat($this->outputFormat, $this->date);
        return $date && $date->format($this->outputFormat) == $this->date;
    }

    public function compare(Date $date) {
        $currentTime = strtotime($this->getDate());
        $argTime = strtotime($date->getDate());

        if ($currentTime > $argTime) {
            return 1; //argumento menor
        } elseif ($currentTime < $argTime) {
            return -1;  //atual menor
        }
        return 0; //iguais
    }

    public function getTime() {
        if ($this->is()) {
            return strtotime($this->getDate());
        }
        return null;
    }
    
    # STATIC #

    /**
     * Get month name in pt-BR, by number month in calendar.
     * 
     * @param int $number Calendar month number
     * @return string month name
     */
    static function month_pt_br($number) {
        return self::$months_pt_br[$number - 1];
    }

}
