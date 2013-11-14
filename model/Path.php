<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Path
 *
 * @author luciano
 */
class Path {
    
    private $path;
    private $instance = null;


    private function __construct() {
        $this->path = $_SERVER['DOCUMENT_ROOT'] . substr($_SERVER['PHP_SELF'],0, strpos($_SERVER['PHP_SELF'],"/",1));
    }

    public static function getInstance(){
        if($this->instance == null){
            $this->instance = new Path();
        }
        return $this->instance;
    }
}
