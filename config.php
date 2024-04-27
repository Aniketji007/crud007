<?php
$host = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'custom-work';
$port = '10029';

$conn = new  mysqli($host, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    echo $conn->$error;
    die();
}

// Create admin table.

// $query = 'CREATE TABLE IF NOT EXISTS `admin` ( 
//     `id` int(4) NOT NULL auto_increment,
//     `username` varchar(250) NOT NULL UNIQUE,
//     `email` varchar(250) NOT NULL UNIQUE,
//     `password` varchar(250) NOT NULL,
//     primary key(id)
// )';

// $sql = $conn->query($query);

// create user table.

// $query = 'CREATE TABLE IF NOT EXISTS `user` ( 
//     `id` int(4) NOT NULL auto_increment,
//     `username` varchar(250) NOT NULL UNIQUE,
//     `email` varchar(250) NOT NULL UNIQUE,
//     `phone_no` bigint(12) NOT NULL,
//     `dob` DATE NOT NULL,
//     `gender` ENUM("male","female","other"),
//     `hobbies` varchar(250),
//     `course` varchar(250),
//     primary key(id)
// )';

// $sql = $conn->query($query);



