<?php

// Nope, this is just a mockup for Symfony Web Dir, used to try xDebug with symfony projects.

$water = 100;
$vuur = 200;
$wind = 300;
$aarde = 400;

$modder = $water * $aarde * $wind;
echo $modder; //12000000




$modder2 = $vuur*$modder + ( $vuur % $water );
echo $modder2; //2400000000 => Very nice results with xDebug on. #veryUsefull
