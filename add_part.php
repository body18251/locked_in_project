<?php
include("includes/header2.php");
session_start();

if(isset($_SESSION['user'])) { 
?>

<?php
// التأكد من أن الطلب هو POST وأنه يحتوي على بيانات الكورس لإضافته
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lecture_name = $_POST['lecture_name'];
    $video_link = $_POST['video_link'];
    $lecturer_name = $_POST['lecturer_name'];
    $lecture_details = $_POST['lecture_details'];
    $exam_id = $_POST['exam_id'];
    $id_lecture = $_POST['id_lecture'];
    $time = $_POST['time'];

    // اتصل بقاعدة البيانات وأدخل بيانات الملف الجديد
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "quiczwaq_locked";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

    // استخدم البيانات المستقبلة لإنشاء استعلام INSERT
    $insert_query = $conn->prepare("INSERT INTO parts (lecture_name, video_link, lecturer_name, lecture_details, exam_id, id_lecture, time) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insert_query->bind_param("sssssss", $lecture_name, $video_link, $lecturer_name, $lecture_details, $exam_id, $id_lecture, $time);

    if ($insert_query->execute()) {
        // إذا تمت العملية بنجاح، قم بتحويل المستخدم إلى صفحة نجاح الإضافة
        header("Location: parts.php");
        exit;
    } else {
        // إذا حدث خطأ، قم بتحويل المستخدم إلى صفحة خطأ
        header("Location: index.php");
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
            <!--**********************************
                Content body start
            ***********************************-->

            <div class="container-fluid">
                <!-- Content goes here -->
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Add New Part</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="add-branch.php">Parts</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Part</a></li>
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
                                <form action="" method="post" id="addBranchForm" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="lecture_name">Lecture Name</label>
                                                <input placeholder="Lecture Name" id="lecture_name" name="lecture_name" type="text" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="video_link">Video Link</label>
                                                <input placeholder="Video Link" id="video_link" name="video_link" type="text" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="lecturer_name">Lecturer Name</label>
                                                <input placeholder="Lecturer Name" id="lecturer_name" name="lecturer_name" type="text" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="lecture_details">Lecture Details</label>
                                                <input placeholder="Lecture Details" id="lecture_details" name="lecture_details" type="text" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="exam_id">Exam ID</label>
                                                <input placeholder="Exam ID" id="exam_id" name="exam_id" type="text" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="id_lecture">Lecture</label>
                                                <select id="id_lecture" name="id_lecture" class="form-control" required="">
                                                    <option value="">Select Lecture</option>
                                                    <?php
                                                    $servername = "localhost";
                                                    $username = "root";
                                                    $password = "";
                                                    $dbname = "quiczwaq_locked";

                                                    $conn = new mysqli($servername, $username, $password, $dbname);

                                                    if ($conn->connect_error) {
                                                        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
                                                    }

                                                    $sql = "SELECT `id`, `lecture_name` FROM `lectures`";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo '<option value="' . $row['id'] . '">' . $row['lecture_name'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="time">Time</label>
                                                <input placeholder="Time" id="time" name="time" type="text" class="form-control" required="">
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
                                                    <h5 class="modal-title">Lecture add confirm</h5>
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
