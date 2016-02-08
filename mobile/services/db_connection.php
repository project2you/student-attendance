<?php

/* Database setup information */
$dbhost = 'localhost';  // Database Host
$dbuser = 'root';       // Database Username
$dbpass = '';           // Database Password
$dbname = 'jq_invoice';      // Database Name

/* Connect to the database */
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
