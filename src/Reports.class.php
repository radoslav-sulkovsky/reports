<?php

    require_once __DIR__ . '/simplexlsx.class.php';
    
    class Reports {
        private $xlsx;
        private $date;
        
        public function __construct($file) {
            $this->xlsx = SimpleXLSX::parse($file);
            if($this->xlsx == false) {
                echo SimpleXLSX::parse_error();
                exit;
            }  
        }
        
        /* public function parseMonthly() {
             $rows = $this->xlsx->rows(7);
            
            if(count($rows) >= 2) {
                $sheetName = $this->xlsx->sheetNames();
                $this->date = $sheetName[1];

                for($rows_i = 1; $rows_i < count($rows); $rows_i++) {
                    $agents[$rows_i] = $this->_parseAgent($rows[$rows_i]);
                }
            }
            
            return $agents;
        } */
        
        public function parseDaily() {
            $rows = $this->xlsx->rows();
            $agents = array();
            
            if(count($rows) >= 2) {
                $sheetName = $this->xlsx->sheetNames();
                $this->date = $sheetName[1];

                for($rows_i = 1; $rows_i < count($rows); $rows_i++) {
                    $agents[] = $this->_parseAgent($rows[$rows_i]);
                }
            } else {
                return false;
            }
            
            return $agents;
        }
        
        public function _parseAgent($data) {
            $agentId = $data[0];
            $summaryPauseTime = (int) ceil((float) str_replace(',', '.', $data[1]) * 60);
            $summaryWorkTime = (int) ceil((float) str_replace(',', '.', $data[2]) * 60);
            
            for($i = 3; $i < count($data); $i++) {
                if(strlen($data[$i]) < 1) {
                    break;
                }
                
                $pauseData[] = $this->_parseBreak($data[$i]);
            }
            
            $agent = [
                'date' => $this->date,
                'agent' => $agentId,
                'summaryPauseTime' => $summaryPauseTime,
                'summaryWorkTime' => $summaryWorkTime,
                'pauseData' => $pauseData
            ];
            
            return $agent;
        }
        
        public function _parseBreak($break) {
            $times = explode('-', $break);
            return ['break_start' => $this->date .' '. $times[0], 'break_stop' => $this->date .' '. $times[1], 'pause_time' => (int) strtotime($times[1])-strtotime($times[0])];
        }
    }