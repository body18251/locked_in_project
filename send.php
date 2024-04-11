<?php

// بيانات FCM endpoint
$url = 'https://fcm.googleapis.com/fcm/send';

// بيانات الإشعار
$data = array(
    'to' => '/topics/LocekInNotification',
    'notification' => array(
        'title' => 'doctor',
        'body' => 'el application tamam ? '
    ),
    'data' => array(
        'url' => '<url of media image>',
        'dl' => '<deeplink action on tap of notification>'
    )
);

// تحويل البيانات إلى JSON
$postData = json_encode($data);

// العنوان الرئيسي ورؤوس الطلب
$headers = array(
    'Authorization: key=AAAA33NZ1kk:APA91bEZutopTnqXfRG4iyXGXyQbh9t870JjyrauI_UoxQBYdpUtjKsTkIB50tnu6HOlUGjBdmfKpyxCf_BA4EMqI_P_gct477SjsFKbJjlbPg1aSlAMAXyzYX8FSZUPa35GevPH1Xqn',
    'Content-Type: application/json'
);


// تكوين خيارات cURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);

// إرسال الطلب والحصول على الاستجابة
$response = curl_exec($curl);

// إغلاق الاستجابة
curl_close($curl);

// عرض الاستجابة
echo $response;

?>
