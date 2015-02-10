<?php
/**
 * Created by PhpStorm.
 * User: Nav
 * Date: 28-12-2014
 * Time: 0:40
 */

Class Chest {

    protected $lock;
    protected $isClosed;

    public function __construct(Lock $lock) {
        $this->lock = $lock;
    }

    public function close($lock = true) {
        if($lock === true){
            $this->lock->lock();
        }

        $this->isClosed = true;
        echo 'Closed';
    }

    public function isClosed() {
        return $this->isClosed();
    }

    public function open() {
        if($this->lock->isLocked()){
            $this->lock->unlock();
        }

        $this->isClosed = false;
        echo 'Opened';
    }
}