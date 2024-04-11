<?php
session_start();

// قم بإلغاء الجلسة
session_unset();

// أنهي الجلسة
session_destroy();

// قم بتوجيه المستخدم إلى صفحة تسجيل الدخول بعد تسجيل الخروج
header("Location: login.php");
exit();
?>
