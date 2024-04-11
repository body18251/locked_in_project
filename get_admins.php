<?php
// اتصال بقاعدة البيانات
$host = 'localhost'; 
$username = 'root';  
$password = '';  
$database = 'quiczwaq_locked'; // استبدل بالاسم الصحيح لقاعدة البيانات

try {
    // اتصال بقاعدة البيانات باستخدام PDO
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    
    // استعلام قاعدة البيانات لاسترجاع بيانات الأدمنز
    $query = "SELECT `admin_id`, `employee_name`, `mobile_number` FROM `admins` WHERE 1";
    
    // تنفيذ الاستعلام
    $statement = $pdo->query($query);
    
    // تحويل البيانات إلى مصفوفة متعددة الأبعاد
    $admins = array();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $admins[] = $row;
    }
    
    // إرجاع بيانات الأدمنز بتنسيق JSON
    echo json_encode($admins);
} catch (PDOException $e) {
    // في حالة حدوث خطأ
    echo json_encode(array('error' => $e->getMessage()));
}
?>
