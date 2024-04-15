<?php
$servername = "localhost"; 
$username = "quiczwaq_locked"; 
$password = "Dsa123!@#";    
$dbname = "quiczwaq_locked"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobile_number = $_POST['mobile_number'];
    $gender = $_POST['gender'];
    $type = $_POST['type'];

    // التحقق من تكرار البريد الإلكتروني
    $check_email_query = "SELECT * FROM admins WHERE email='$email'";
    $result_email = $conn->query($check_email_query);
    if ($result_email->num_rows > 0) {
        echo "البريد الإلكتروني مكرر!";
    } else {
        // التحقق من تكرار رقم الهاتف
        $check_mobile_query = "SELECT * FROM admins WHERE mobile_number='$mobile_number'";
        $result_mobile = $conn->query($check_mobile_query);
        if ($result_mobile->num_rows > 0) {
            echo "رقم الهاتف مسجل من قبل!";
        } else {
            // إدراج البيانات في الجدول
            $insert_query = "INSERT INTO admins (employee_name, email, password, mobile_number, Gender, type)
                             VALUES ('$name', '$email', '$password', '$mobile_number', '$gender', '$type')";
            if ($conn->query($insert_query) === TRUE) {
                echo "تم إضافة الموظف بنجاح!";
            } else {
                echo "خطأ في إدراج البيانات: " . $conn->error;
            }
        }
    }
}
?>
