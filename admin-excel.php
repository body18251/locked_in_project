<?php
// اتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiczwaq_locked";

$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// استعلام SQL لاسترجاع البيانات من الجدول
$sql = "SELECT `admin_id`, `employee_name`, `type`, `email`, `password`, `mobile_number`, `status`, `Gender` FROM `admins` WHERE 1";
$result = $conn->query($sql);

// فتح ملف CSV للكتابة
$fp = fopen('admins.csv', 'w');

// كتابة رأس الجدول إلى الملف CSV
$fields = array('admin_id', 'employee_name', 'type', 'email', 'password', 'mobile_number', 'status', 'Gender');
fputcsv($fp, $fields);

// كتابة البيانات إلى الملف CSV
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // كتابة كل صف في ملف CSV بشكل منفصل
        fputcsv($fp, array_values($row));
    }
}

// إغلاق الملف
fclose($fp);

// إغلاق اتصال قاعدة البيانات
$conn->close();

// التحقق مما إذا تم إنشاء الملف بنجاح
if (file_exists('admins.csv')) {
    // توجيه المتصفح لتنزيل الملف
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="admins.csv"');
    readfile('admins.csv');
} else {
    // في حالة عدم وجود الملف، يمكنك هنا توجيه المستخدم إلى صفحة خطأ أو الصفحة الرئيسية مع رسالة تنبيه
    echo "حدث خطأ أثناء إنشاء الملف!";
    header('Location: admins.php');
}
exit();
?>
