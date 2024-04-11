<?php
require('fpdf/fpdf.php');

// اتصال بقاعدة البيانات
$conn = new mysqli('localhost', 'root', '', 'quiczwaq_locked');

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// استعلام SQL لاسترجاع البيانات من جدول قاعدة البيانات
$sql = "SELECT * FROM admins";
$result = $conn->query($sql);

// إنشاء ملف PDF جديد باستخدام FPDF
$pdf = new FPDF();
$pdf->AddPage();

// تضبيط الخطوط والمحتوى
$pdf->SetFont('Arial','B',12);

// إضافة عنوان للجدول
$pdf->Cell(40,10,'Admins Report', 0, 1);

// إضافة رؤوس الأعمدة
$pdf->Cell(10,10,'id',1);
$pdf->Cell(70,10,'name',1);
$pdf->Cell(30,10,'type',1);
$pdf->Cell(40,10,'phone',1);
$pdf->Cell(15,10,'status',1);



$pdf->Ln(); // الانتقال إلى سطر جديد

// إضافة بيانات الجدول من قاعدة البيانات
while($row = $result->fetch_assoc()) {
    $pdf->Cell(10,10,$row['admin_id'],1);
    $pdf->Cell(70,10,$row['employee_name'],1);
    $pdf->Cell(30,10,$row['type'],1);
    $pdf->Cell(40,10,$row['mobile_number'],1);
    $pdf->Cell(15,10,$row['status'],1);

    

    
    $pdf->Ln(); // الانتقال إلى سطر جديد
}

// إرسال الملف PDF للمتصفح
$pdf->Output();

$conn->close();
?>
