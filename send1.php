<?php
// تحقق من أن الطلب الذي تم استقباله هو POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // جلب البيانات المرسلة من النموذج
    $message_content = $_POST["message"];
    $phone_number = $_POST["phone"];

    // هذه الوظيفة تستقبل رقم الهاتف ونص الرسالة كمدخلات وتقوم بإرسال الرسالة عبر API
    function send_message($phone, $message) {
        $api_key = 'QNlpPsDeVMx7U4Q7NK6GLbAc2H0QMh'; // مفتاح الواجهة البرمجية
        $sender = '201508239717'; // المرسل
        $url = 'https://app.topwhats.com/send-message?api_key='.$api_key.'&sender='.$sender.'&number='.$phone.'&message='.urlencode($message).'&type=text';

        // إعداد طلب cURL
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
        ));

        // إرسال الطلب واستقبال الاستجابة
        $response = curl_exec($curl);
        curl_close($curl);

        // إرجاع الاستجابة
        return $response;
    }

    // استخدام الوظيفة لإرسال الرسالة
    $response = send_message($phone_number, $message_content);
    
    // بعد انتهاء العملية، قم بإعادة التوجيه إلى الصفحة المطلوبة
    header("Location: rating_answer.php?page=1");
    exit(); // تأكد من أنه لا يوجد أي إخراج بعد هذا التوجيه
}
?>
