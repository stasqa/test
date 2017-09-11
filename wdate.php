<?php
    class wdate {

        private $input_date = '';
        private $date = [];
        private $time = [];
        public $y, $m, $d, $h, $i, $s;

        /**
         * @var \DateTime $date_time;
         */
        private $date_time;


        public function __construct($any_date = '') {
            $this->setDate($any_date);
        }

        public function setDate($any_date) {
            $this->input_date = $any_date;
            preg_match_all('/(\d+)(.?)/', $any_date, $match);

            if ($match) {
                foreach($match[1] as $i => $v) {

                    if ($match[2][$i] == '' and $i == count($match[1])-1 and strlen($v)==4) {
                        $this->date[] = (int)$v;
                    }
                    else if ($match[2][$i] == '.') {
                        $this->date[] = (int)$v;
                    }
                    else {
                        $this->time[] = (int)$v;
                    }
                }
            }


            $max = count($this->date);
            $this->y = isset($this->date[$max - 1]) ? (int)$this->date[$max - 1] : 1;
            $this->m = isset($this->date[$max - 2]) ? (int)$this->date[$max - 2] : 1;
            $this->d = isset($this->date[$max - 3]) ? (int)$this->date[$max - 3] : 1;

            $this->h = isset($this->time[0]) ? (int)$this->time[0] : 0;
            $this->i = isset($this->time[1]) ? (int)$this->time[1] : 0;
            $this->s = isset($this->time[2]) ? (int)$this->time[2] : 0;

            $formated = $this->y.'-'.$this->m.'-'.$this->d.' '.$this->h.':'.$this->i.':'.$this->s;
            $this->date_time = new \DateTime($formated);

            unset($formated);
            unset($this->date);
            unset($this->time);
        }

        public function diff($obj) {
            $t1 = $this->date_time->getTimestamp();
            $t2 = $obj->date_time->getTimestamp();

            return ($t1 - $t2);
        }

        public function __destruct() {
            unset($this->y, $this->m, $this->d);
            unset($this->h, $this->i, $this->s);
            unset($this->input_date);
            unset($this->date_time);
        }
    }


    $obj1 = new wdate('01:00:05 21.07.2017');
    $obj2 = new wdate('01:05 21.07.2017');
    $obj3 = new wdate('01: 21.07.2017');
    $obj4 = new wdate('21.07.2017');
    $obj5 = new wdate('07.2017');
    $obj6 = new wdate('2017');
    $obj7 = new wdate('01:');
    $obj8 = new wdate('01:05');
    $obj9 = new wdate('01:05:17');

    var_dump($obj1->diff($obj2)); //-295 s
    var_dump($obj2->diff($obj1)); //295 s
    var_dump($obj2->diff($obj2)); // 0 = equal


?>