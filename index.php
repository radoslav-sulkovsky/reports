<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once __DIR__ . '/src/Reports.class.php';
    require_once __DIR__ . '/src/Db.php';
    
    $db = Db::getInstance();
    
    $reports = new Reports("Worktime report_2018-04-13.xlsx");
    $data = $reports->parseDaily();
    
    foreach($data as $agent) {
        $db->insert('worktime', ['agent' => $agent['agent'], 'data' => $agent['date'], 'worktime' => $agent['summaryWorkTime'], 'pausetime' => $agent['summaryPauseTime']]);
        foreach($agent['pauseData'] as $pause) {
            $db->insert('breaks_details', ['agent' => $agent['agent'], 'break_start' => $pause['break_start'], 'break_stop' => $pause['break_stop'], 'time' => $pause['pause_time']]);
        }
    }