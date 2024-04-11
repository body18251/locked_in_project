<?php
// التحقق مما إذا تم استلام المعرف (id) بشكل صحيح
if (isset($_POST['id'])) {
    // الاتصال بقاعدة البيانات
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'quiczwaq_locked';

    try {
        // اتصال بقاعدة البيانات باستخدام PDO
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        
        // جلب رقم الهاتف المرتبط بالمعرف المحدد
 // جلب رقم الهاتف المرتبط بالمعرف المحدد
$query_phone = "SELECT `phone` FROM `customer_error` WHERE `id` = :id";
$statement_phone = $pdo->prepare($query_phone);
$statement_phone->execute(array(':id' => $_POST['id']));
$phone_row = $statement_phone->fetch(PDO::FETCH_ASSOC);
$mobile = $phone_row['phone'];

// التحقق مما إذا تم جلب رقم الهاتف بنجاح
if ($mobile) {
    // تحضير الاستعلام لتحديث الحالة إلى 1
    $query_update = "UPDATE `customer_error` SET `status` = 1 WHERE `id` = :id";
    $statement_update = $pdo->prepare($query_update);
    $statement_update->execute(array(':id' => $_POST['id']));

    // إرسال رسالة بالتوجيه إلى الرقم المناسب الذي تم جلبه
    $message = "تم حل المشكلة بنجاح. شكرا لتواصلكم معنا!";
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://app.topwhats.com/send-message?api_key=QNlpPsDeVMx7U4Q7NK6GLbAc2H0QMh&sender=201508239717&number='.$mobile.'&message='.urlencode($message).'&type=text',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    // الرد بنجاح
    echo "تم تحديث الحالة بنجاح وتم إرسال الرسالة بنجاح.";
} else {
    // في حالة عدم جلب رقم الهاتف بنجاح
    echo "حدث خطأ: لم يتم جلب رقم الهاتف.";
}

        // الرد بنجاح
        echo "تم تحديث الحالة بنجاح وتم إرسال الرسالة بنجاح.";
    } catch (PDOException $e) {
        // في حالة حدوث خطأ
        echo "حدث خطأ: " . $e->getMessage();
    }
} else {
    // إذا لم يتم استلام المعرف (id)
    echo "المعرف (id) غير متوفر.";
}
?>
