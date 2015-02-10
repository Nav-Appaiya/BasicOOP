<?php
/**
 * Created by PhpStorm.
 * User: Nav
 * Date: 28-12-2014
 * Time: 0:53
 */

class Database {


    public function query($query)
    {
        $this->pdo->prepare($sql)->execute();
    }
}