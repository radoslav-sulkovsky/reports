<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Db
 *
 * @author rados
 */
class Db {
    
    // dane dostępowe bazy danych MySQL
    private $sqlData = [
        'hostname'  => 'localhost',
        'username'  => 'aseto',
        'password'  => 'sS7E76VMBas8LSjY',
        'port'      => '3306',
        'database'  => 'aseto'
    ];
    
    // inicjalizacja instancji
    private static $instance = null;
    private $link;
    
    // konstruktor klasy
    private function __construct() {
        $this->link = new mysqli($this->sqlData['hostname'], 
            $this->sqlData['username'], 
            $this->sqlData['password'], 
            $this->sqlData['database'], 
            $this->sqlData['port']);
        
        if($this->link->connect_errno) {
            die($this->link->connect_error);
        }
        
        $this->link->set_charset('utf8mb4');
        
        // if(!$this->checkDatabase()) {
        //    die('Baza danych nie została skonfigurowana!');
        // }
    }
    
    private function checkDatabase() {
        if($query = $this->query("SHOW TABLES LIKE 'users'")) {
            if($query->num_rows > 0) {
                return true;
            }
            return false;
        }
        return false;
    } 
    
    // zabezpieczenie danych dostępowych bazy danych MySQL
    public function __debugInfo() {
        $properties = get_object_vars($this);
        unset($properties['sqlData']);

        return $properties;
    }
    
    public static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new Db();
        }
        return self::$instance;
    }
    
    // mysqli::query
    public function query($sql) {
        $query = $this->link->query($sql);
 
        return $query;
    }

    // mysqli::prepare
    public function prepare($sql) {
        $statement = $this->link->prepare($sql);
 
        return $statement;
    }
    
    // mysqli::real_escape_string
    public function escape($string) {
        return $this->link->real_escape_string($string);
    }
    
    // db insert
    public function insert($table, $params = []) {
        $keys       = array_keys($params);
        $lastKey    = array_search(end($params), $params);
        $values     = '';
        
        foreach($params as $name => $value) {
            $values .= '\'' . $this->escape($value)  . '\'' . (($lastKey == $name) ? '' : ', ');
        }
        
        $query = 'INSERT INTO `'. $this->escape($table) .'` ('. implode(', ', $keys) .') VALUES('. $values .')';
        
        if($this->query($query)) {
            return true;
        }
        
        return false;
    }
    
    // db update | $where = [$field, $value, $operator]
    public function update($table, $params = [], $where = []) {
        $lastKey    = array_search(end($params), $params);
        $values     = '';
        
        foreach($params as $name => $value) {
            $values .= '`'. $this->escape($name)  .'` = \''. $this->escape($value) . '\'' . (($lastKey == $name) ? '' : ', ');
        }
        
        $where = '`'. $this->escape($where[0])  .'` '. $this->escape($where[2]) .' \''. $this->escape($where[1]) . '\'';
        
        $query = 'UPDATE `'. $this->escape($table) .'` SET '. $values .' WHERE '. $where;
        
        if($this->query($query)) {
            return true;
        }
        
        return false;
    }   
}