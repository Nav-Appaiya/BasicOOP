<?php
/**
 * Created by PhpStorm.
 * User: Nav
 * Date: 28-12-2014
 * Time: 0:40
 */

require 'Chest.php';
require 'Lock.php';

$chest = new Chest(new Lock());

$chest->close();
