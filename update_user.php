<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "quiczwaq_locked";
$password = "Dsa123!@#";
$dbname = "quiczwaq_locked";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "UPDATE admins SET employee_name='$name', password='$password', email='$email', mobile_number='$phone' WHERE admin_id='{$_SESSION['user']['admin_id']}'";

if ($conn->query($sql) === TRUE) {
    $_SESSION['user']['employee_name'] = $name;
    $_SESSION['user']['password'] = $password;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['mobile_number'] = $phone;
    
    header("Location: profile.php"); 
} else {
    echo "حدث خطأ أثناء تحديث البيانات: " . $conn->error;
}
}

$conn->close();
?>
