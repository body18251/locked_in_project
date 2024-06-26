<?php
include("includes/header2.php");
session_start(); 

if(isset($_SESSION['user'])) { 
?>

<?php
// التأكد من أن الطلب هو POST وأنه يحتوي على بيانات الفرع لإضافته
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $crm = $_POST['crm'];


    // اتصل بقاعدة البيانات وأدخل بيانات الفرع الجديد
    $servername = "localhost";
    $username = "quiczwaq_locked";
    $password = "Dsa123!@#";
    $dbname = "quiczwaq_locked";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

// إدراج البيانات في الجدول
$insert_query = "INSERT INTO course (name, crm_id)
                 VALUES ('$name', '$crm')";
if ($conn->query($insert_query) === TRUE) {
    // إذا تمت العملية بنجاح، قم بتحويل المستخدم إلى صفحة نجاح الإضافة
    header("Location: courses.php");
    exit;
} else {
    // إذا حدث خطأ، قم بتحويل المستخدم إلى صفحة خطأ
    header("Location: index.php");
    exit;
}


    // إغلاق اتصال قاعدة البيانات
    $conn->close();

    // يجب الخروج من السكربت بعد الانتهاء من عملية الإضافة
    exit;
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
            <!--**********************************
                Content body start
            ***********************************-->

            <div class="container-fluid">
                <!-- Content goes here -->
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Add Course</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Setting</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Courses</a></li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Basic Info</h5>
                            </div>
                            <div class="card-body">
                                <form action="" method="post" id="addPdfForm">
                                    <div class="row">
                                            
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="file_name"> Name</label>
                                                <input placeholder="Name" id="name" name="name" type="text" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="description">crm id</label>
                                                <input placeholder="crm id" id="crm" name="crm" type="number" class="form-control" required="">
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" name="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Submit</button>
                                            <button type="reset" class="btn btn-danger light">Cancel</button>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="exampleModalCenter">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">PDF File add confirm</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Are you sure to add data?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

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
