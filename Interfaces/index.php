<?php
require 'Collection.php';
require 'TalkInterface.php';
require 'Dog.php';
require 'Cat.php';
//$collection = new Collection();
//$collection->add('foo');
//$collection->add('bar');
//echo json_encode($collection);

$dog = new Dog();
$cat = new Cat();

echo $cat->talk();
echo $dog->talk();

