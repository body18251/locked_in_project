<?php
$servername = "localhost"; 
$username = "quiczwaq_locked"; 
$password = "Dsa123!@#";    
$dbname = "quiczwaq_locked"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
?>
<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
    $statement = $conn->prepare("SELECT * FROM mp3_files_extra WHERE id=?");
    $statement->execute(array($_REQUEST['id']));
    $statement->store_result(); // تخزين النتائج في الذاكرة
    $total = $statement->num_rows; // الحصول على عدد الصفوف المتأثرة بالاستعلام
    
    if( $total == 0 ) {
        header('location: logout.php');
        exit;
    }
    
}
	
// Delete from tbl_video
$statement = $conn->prepare("DELETE FROM mp3_files_extra WHERE id=?");
$statement->execute(array($_REQUEST['id']));

header('location: audiofiles.php');
?>