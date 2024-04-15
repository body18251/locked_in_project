<?php
include("includes/header2.php");
session_start();

if(isset($_SESSION['user'])) { 
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $track = $_POST['track'];
    $Book_id = $_POST['Book_id'];
    $name = $_POST['name'];

    // اتصل بقاعدة البيانات وأدخل بيانات السؤال الجديد
    $servername = "localhost";
    $username = "quiczwaq_locked";
    $password = "Dsa123!@#";
    $dbname = "quiczwaq_locked";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

    // استخدم استعلام قاعدة البيانات لإدخال السؤال
   // استخدم استعلام قاعدة البيانات لإدخال البيانات
   $insert_query = $conn->prepare("INSERT INTO courses (track, Book_id, name) VALUES (?, ?, ?)");
   $insert_query->bind_param("sss", $track, $Book_id, $name);
   


    if ($insert_query->execute()) {
        // إذا تمت العملية بنجاح، قم بتحويل المستخدم إلى صفحة نجاح الإضافة
        header("Location: course_groups.php");
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
                            <h4>Add Group</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="add-branch.php">Courses</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Group</a></li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Add Group</h5>
                            </div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="group_id">Track</label>
                                                <select id="track" name="track" class="form-control" required="">
    <option value="">Select Group</option>
    <?php
    $servername = "localhost";
    $username = "quiczwaq_locked";
    $password = "Dsa123!@#";
    $dbname = "quiczwaq_locked";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

    // يمكنك استخدام الاتصال بقاعدة البيانات مرة واحدة للحصول على البيانات
    $sql = "SELECT `id`, `crm_name` FROM `tracks`";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['crm_name'] . '">' . $row['crm_name'] . '</option>';
        }
    }
    ?>
</select>



                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="Group">Book id</label>
                                                <input placeholder="Book id" id="Book_id" name="Book_id" type="text" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="Group">Name</label>
                                                <input placeholder="Name" id="name" name="name" type="text" class="form-control" required="">
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
