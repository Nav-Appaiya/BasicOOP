<?php
/**
 * Created by PhpStorm.
 * User: Nav
 * Date: 28-12-2014
 * Time: 0:40
 */

class Lock {

    protected $isLocked;

    public function lock(){
        $this->isLocked = true;
    }

    public function unlock(){
        $this->isLocked = false;
    }

    public function isLocked(){
        return $this->isLocked();
    }

}