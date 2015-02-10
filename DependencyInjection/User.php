<?php
/**
 * Created by PhpStorm.
 * User: Nav
 * Date: 28-12-2014
 * Time: 0:53
 */

class User {

    protected $db;

    public function __construct(Database $db){
        $this->db = $db;
    }

    public function create(array $data)
    {
        $this->db->query('INSERT INTO users');
    }

}