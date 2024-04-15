<?php
$servername = "localhost"; 
$username = "quiczwaq_locked"; 
$password = "Dsa123!@#";    
$dbname = "quiczwaq_locked"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
?>
