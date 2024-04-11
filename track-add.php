<?php
include("includes/header2.php");
session_start();

if(isset($_SESSION['user'])) { 
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $crm_name = $_POST['crm_name'];

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
    $insert_query = $conn->prepare("INSERT INTO tracks (crm_name) VALUES (?)");
    // قم بتغيير "is" إلى "iss" لمطابقة نوع البيانات في حقول الاستعلام
    $insert_query->bind_param("s", $crm_name);

    if ($insert_query->execute()) {
        // إذا تمت العملية بنجاح، قم بتحويل المستخدم إلى صفحة نجاح الإضافة
        header("Location: tracks.php");
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
                            <h4>Add Track</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="add-branch.php">Settings</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Track</a></li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Add Track</h5>
                            </div>
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="row">
                                       
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="Track">Track</label>
                                                <input placeholder="Track" id="crm_name" name="crm_name" type="text" class="form-control" required="">
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
