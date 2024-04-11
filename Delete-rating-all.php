
<?php
// تفعيل الجلسة إذا لم تكن مفعلة بالفعل
session_start();

// التحقق من تسجيل الدخول
if(isset($_SESSION['user'])) { 
    // اتصال بقاعدة البيانات
    // اتصال بقاعدة البيانات
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "quiczwaq_locked";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

    // اسم الجدول الذي تريد حذف بياناته
    $table_name = "msq_answer";

    // استعلام SQL لحذف جميع البيانات من الجدول
    $sql = "DELETE FROM $table_name";

    // تنفيذ الاستعلام
    if ($conn->query($sql) === TRUE) {
        // تم حذف البيانات بنجاح، قم بتوجيه المستخدم إلى الصفحة الأخرى
        header("Location: rating_answer.php");
        exit(); // تأكد من إنهاء التشغيل بعد التوجيه
    } else {
        echo "حدث خطأ أثناء محاولة حذف البيانات: " . $conn->error;
    }

    // إغلاق اتصال قاعدة البيانات
    $conn->close();
} else {
    // إعادة التوجيه إلى صفحة تسجيل الدخول إذا لم يتم تسجيل الدخول
    header("Location: login.php");
    exit();
}
?>
