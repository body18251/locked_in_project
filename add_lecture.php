<?php
include("includes/header2.php");
session_start();

if(isset($_SESSION['user'])) { 
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courses_id = $_POST['courses_id'];
    $lecture_name = $_POST['lecture_name'];
    $duration_minutes = $_POST['duration_minutes'];

    // اتصل بقاعدة البيانات وأدخل بيانات السؤال الجديد
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "quiczwaq_locked";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

    // استخدم استعلام قاعدة البيانات لإدخال السؤال
    $insert_query = $conn->prepare("INSERT INTO lectures (course_id , lecture_name, duration_minutes) VALUES (?, ?, ?)");
    // قم بتغيير "is" إلى "iss" لمطابقة نوع البيانات في حقول الاستعلام
    $insert_query->bind_param("iss", $courses_id, $lecture_name, $duration_minutes);

    if ($insert_query->execute()) {
        // إذا تمت العملية بنجاح، قم بتحويل المستخدم إلى صفحة نجاح الإضافة
        header("Location: Lectures.php");
        exit;
    } else {
        // إذا حدث خطأ، قم بتحويل المستخدم إلى صفحة خطأ
        header("Location: error.php");
        exit;
    }

    // إغلاق اتصال قاعدة البيانات
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include head content here -->
    <?php include("includes/includes.php"); ?>
</head>
<body>
    <div id="main-wrapper">
        <!-- Include header content here -->
        <?php include("includes/header2.php"); ?>

        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Add Lecture</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="add-branch.php">Lectures</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Lecture</a></li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Add Lecture</h5>
                            </div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="courses_id">Course</label>
                                                <select id="courses_id" name="courses_id" class="form-control" required="">
                                                    <option value="">Select Course</option>
                                                    <?php
                                                    $servername = "localhost";
                                                    $username = "root";
                                                    $password = "";
                                                    $dbname = "quiczwaq_locked";
                                                
                                                    $conn = new mysqli($servername, $username, $password, $dbname);
                                                
                                                    if ($conn->connect_error) {
                                                        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
                                                    }
                                                
                                                       // يمكنك استخدام الاتصال بقاعدة البيانات مرة واحدة للحصول على البيانات
                                                       $sql = "SELECT `id`, `name` FROM `courses`";
                                                       $result = $conn->query($sql);
                                                       if ($result->num_rows > 0) {
                                                           while ($row = $result->fetch_assoc()) {
                                                               echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                                           }
                                                       }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="question">Lecture name</label>
                                                <input placeholder="Lecture name" id="lecture_name" name="lecture_name" type="text" class="form-control" required="">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="question">Duration minutes</label>
                                                <input placeholder="Duration minutes" id="duration_minutes" name="duration_minutes" type="text" class="form-control" required="">
                                            </div>
                                        </div>
                                        
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="http://otech.agency/" target="_blank">O tech Agency</a> 2024</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->
    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
    <script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <!-- Svganimation scripts -->
    <script src="vendor/svganimation/vivus.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="vendor/svganimation/svg.animation.js"></script>
    <!-- pickdate -->
    <script src="vendor/pickadate/picker.js"></script>
    <script src="vendor/pickadate/picker.time.js"></script>
    <script src="vendor/pickadate/picker.date.js"></script>
    <!-- Pickdate -->
    <script src="js/plugins-init/pickadate-init.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/dlabnav-init.js"></script>
    <script src="js/demo.js"></script>
</body>
</html>

<?php
    exit();
}
header("Location: login.php");
exit();
?>
