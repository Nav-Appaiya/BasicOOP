<?php

/**
 * PHP PDO
 * prepared insert,update,delete
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
$database_name = "test";
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
$conn->exec($sqlCreate);

#INSERT DATA
//inserting some some data
$sqlInsert = 'INSERT INTO `test` (`name`, `job`) 
VALUES (:name1,:job1),
       (:name2,:job3), 
       (:name3,:job3);';
$preparedStatement = $conn->prepare($sqlInsert);
$preparedStatement->execute(array(':name1' => 'Tony', ':job1' => 'gardner', ':name2' => 'Dony', ':job2' => 'carpenter', ':name3' => 'Carl', ':job3' => 'policeman'));

//selecting some data
$sqlSelect = "SELECT * from `test`";
$data = $conn->query($sqlSelect);
echo '<div style="' . $divStyle . '">
        <b>These are the INSERT results:</b><br /><br />';
foreach ($data as $row) {
    print "<b>ID:</b> <u>" . $row['id'] . "</u>\t";
    print "<b>NAME:</b> <u>" . $row['name'] . "</u>\t";
    print "<b>JOB:</b> <u>" . $row['job'] . "</u><br />";
}
echo '</div>';


#UPDATE DATA
//updating some some data
$sqlInsert = 'UPDATE test set name=:name where id=:id';
$preparedStatement = $conn->prepare($sqlInsert);
$preparedStatement->execute(array(':name' => 'MICHAEL', ':id' => 1));

//selecting some data
$sqlSelect = "SELECT * from `test`";
$data = $conn->query($sqlSelect);
echo '<div style="' . $divStyle . '">
        <b>These are the UPDATE results:</b><br /><br />';
foreach ($data as $row) {
    print "<b>ID:</b> <u>" . $row['id'] . "</u>\t";
    print "<b>NAME:</b> <u>" . $row['name'] . "</u>\t";
    print "<b>JOB:</b> <u>" . $row['job'] . "</u><br />";
}
echo '</div>';

#DELETE DATA
//delete some some data
$sqlInsert = 'DELETE from test where id=:id';
$preparedStatement = $conn->prepare($sqlInsert);
$preparedStatement->execute(array(':id' => 1));

//selecting some data
$sqlSelect = "SELECT * from `test`";
$data = $conn->query($sqlSelect);
echo '<div style="' . $divStyle . '">
        <b>These are the DELETE results:</b><br /><br />';
foreach ($data as $row) {
    print "<b>ID:</b> <u>" . $row['id'] . "</u>\t";
    print "<b>NAME:</b> <u>" . $row['name'] . "</u>\t";
    print "<b>JOB:</b> <u>" . $row['job'] . "</u><br />";
}
echo '</div>';

//clearing the table
$sqlTruncate = "TRUNCATE table `test`";
$conn->exec($sqlTruncate);
//
?>