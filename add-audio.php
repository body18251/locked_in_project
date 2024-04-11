<?php
include("includes/header2.php");
session_start();

if(isset($_SESSION['user'])) { 
?>

<?php
// التأكد من أن الطلب هو POST وأنه يحتوي على بيانات الكورس لإضافته
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['pdf_file'])) {
    $course_id = $_POST['course_id'];
    $file_name = $_POST['file_name'];
    $description = $_POST['description'];
    $file_path = $_FILES['pdf_file']['tmp_name']; // اسم الملف المؤقت على الخادم

    // تأكد من أن الملف تم تحميله بنجاح
    if (is_uploaded_file($file_path)) {
        // توليد اسم ملف عشوائي لتجنب تكرار الأسماء
        $random_file_name = uniqid() . '_' . basename($_FILES["pdf_file"]["name"]);
        $upload_directory = "uploads/";

        // انقل الملف المؤقت إلى مجلد التحميل
        if (move_uploaded_file($file_path, $upload_directory . $random_file_name)) {
            // اتصل بقاعدة البيانات وأدخل بيانات الملف الجديد
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "quiczwaq_locked";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
            }

            // توليد الرابط الكامل مع الدومين والمسار النسبي للملف المرفوع
            $domain = "ce-eg.co"; // اسم الدومين الحالي
            $file_url = "https://$domain/$upload_directory$random_file_name"; // الرابط الكامل

            // استخدم الرابط الكامل في استعلام قاعدة البيانات
            $insert_query = $conn->prepare("INSERT INTO mp3_files_extra (course_id, file_name, description, file_path) VALUES (?, ?, ?, ?)");
            $insert_query->bind_param("isss", $course_id, $file_name, $description, $file_url);

            if ($insert_query->execute()) {
                // إذا تمت العملية بنجاح، قم بتحويل المستخدم إلى صفحة نجاح الإضافة
                header("Location: audiofiles.php");
                exit;
            } else {
                // إذا حدث خطأ، قم بتحويل المستخدم إلى صفحة خطأ
                header("Location: index.php");
                exit;
            }

            // إغلاق اتصال قاعدة البيانات
            $conn->close();
        } else {
            // إذا فشل تحميل الملف، عرض رسالة خطأ
            echo "فشل في تحميل الملف.";
        }
    } else {
        // إذا فشل تحميل الملف، عرض رسالة خطأ
        echo "فشل في تحميل الملف.";
    }

    // يجب الخروج من السكربت بعد الانتهاء من عملية الإضافة أو عرض رسالة الخطأ
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
                            <h4>Add Audio file</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="add-branch.php">Extras</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Pdf</a></li>
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
                                                <label class="form-label" for="course_id">Course</label>
                                                <select id="course_id" name="course_id" class="form-control" required="">
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
                                                    $sql = "SELECT `crm_id`, `name` FROM `course`";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo '<option value="' . $row['crm_id'] . '">' . $row['name'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="file_name">File Name</label>
                                                <input placeholder="File Name" id="file_name" name="file_name" type="text" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="description">Description</label>
                                                <input placeholder="Description" id="description" name="description" type="text" class="form-control" required="">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="pdf_file">Upload Audio file</label>
                                                <input id="pdf_file" type="file" name="pdf_file" class="form-control" accept=".mp3" required="">
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
                                                    <h5 class="modal-title">Audio add confirm</h5>
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
