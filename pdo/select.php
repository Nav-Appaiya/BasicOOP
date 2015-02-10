<?php

// Show errors
ini_set('display_errors', '1');

/**
 * PHP PDO
 * select statements
 * 
 */
//setting div style for nicer display
$divStyle = ' background-color:#E8E8E3;
            padding:10px;
            color:#000;
            font-size:16px;
            width:600px;
            margin:0 auto;';

//setting connection parameters
$user = "root";
$password = "";
$database_name = "mydb";
$hostname = "localhost";
$dsn = 'mysql:dbname=' . $database_name . ';host=' . $hostname;

//initialize the connection
$conn = new PDO($dsn, $user, $password);

//creating the table if it not exists
$sqlCreate = "CREATE TABLE IF NOT EXISTS `test` (
            `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `job` VARCHAR(255) NOT NULL,
            PRIMARY KEY (`id`));";
$conn->query($sqlCreate);

//clearing the table
$sqlTruncate = "TRUNCATE table `test`";
$conn->exec($sqlTruncate);
//

//inserting some some data
$sqlInsert = 'INSERT INTO `test` (`name`, `job`) 
VALUES ("john","driver"),
       ("mike","postman"), 
       ("frank","policeman");';
$conn->query($sqlInsert);

//selecting some data
$sqlSelect = "SELECT * from `test`";
$data = $conn->query($sqlSelect);
echo '<div style="' . $divStyle . '">
        <b>These are the select results:</b><br /><br />';
foreach ($data as $row) {
    print "<b>ID:</b> <u>" . $row['id'] . "</u>\t";
    print "<b>NAME:</b> <u>" . $row['name'] . "</u>\t";
    print "<b>JOB:</b> <u>" . $row['job'] . "</u><br />";
}
echo '</div>';

?>