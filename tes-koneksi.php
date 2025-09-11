<?php
// Buat file ini di root folder aplikasi untuk test koneksi database
// Akses via: http://ticketing.inmeet.net/test_connection.php

$hostname = 'localhost';
$username = 'inmeetn1_ticketing';
$password = 'ticketing2025';
$database = 'inmeetn1_ticketing';

echo "<h2>Database Connection Test</h2>";

// Test dengan MySQLi
echo "<h3>Testing MySQLi Connection:</h3>";
$mysqli = new mysqli($hostname, $username, $password, $database);

if ($mysqli->connect_error) {
    echo "❌ MySQLi Connection failed: " . $mysqli->connect_error . "<br>";
    echo "Error Code: " . $mysqli->connect_errno . "<br>";
} else {
    echo "✅ MySQLi Connection successful!<br>";
    echo "Host info: " . $mysqli->host_info . "<br>";
    echo "Server info: " . $mysqli->server_info . "<br>";
}

// Test dengan PDO
echo "<h3>Testing PDO Connection:</h3>";
try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ PDO Connection successful!<br>";
} catch(PDOException $e) {
    echo "❌ PDO Connection failed: " . $e->getMessage() . "<br>";
}

// Test show tables
if (!$mysqli->connect_error) {
    echo "<h3>Testing Database Access:</h3>";
    $result = $mysqli->query("SHOW TABLES");
    if ($result) {
        echo "✅ Can access database tables:<br>";
        while ($row = $result->fetch_array()) {
            echo "- " . $row[0] . "<br>";
        }
    } else {
        echo "❌ Cannot access database tables: " . $mysqli->error . "<br>";
    }
}

$mysqli->close();

echo "<hr>";
echo "<h3>PHP MySQL Extensions:</h3>";
echo "MySQLi extension: " . (extension_loaded('mysqli') ? '✅ Loaded' : '❌ Not loaded') . "<br>";
echo "MySQL extension: " . (extension_loaded('mysql') ? '✅ Loaded' : '❌ Not loaded') . "<br>";
echo "PDO MySQL extension: " . (extension_loaded('pdo_mysql') ? '✅ Loaded' : '❌ Not loaded') . "<br>";

echo "<h3>PHP Info:</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Current User: " . get_current_user() . "<br>";
echo "Script Owner: " . getmyuid() . "<br>";
?>