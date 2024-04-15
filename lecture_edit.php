<?php
include("includes/header2.php");
session_start();

if(isset($_SESSION['user'])) { 
    $servername = "localhost"; 
    $username = "quiczwaq_locked"; 
    $password = "Dsa123!@#";    
    $dbname = "quiczwaq_locked"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $lecture_id = $_POST['lecture_id'];
        $course_id = $_POST['course_id'];
        $lecture_name = $_POST['lecture_name'];
        $duration_minutes = $_POST['duration_minutes'];

        $update_query = "UPDATE lectures SET course_id=?, lecture_name=?, duration_minutes=? WHERE id=?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("issi", $course_id, $lecture_name, $duration_minutes, $lecture_id);
        $update_result = $stmt->execute();

        if ($update_result) {
            header("Location: lectures.php"); // توجيه المستخدم إلى الصفحة الرئيسية بعد نجاح التحديث
            exit();
        } else {
            echo "Failed to update lecture data.";
        }
    }

    $lecture_id = $_GET['id']; // افتراض أن الرابط يحمل معرف المحاضرة
    $query = "SELECT * FROM lectures WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $lecture_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include head content here -->
    <?php include("includes/includes.php"); ?>
</head>
<body>
    <!-- Main wrapper start -->
    <div id="main-wrapper">
        <?php include("includes/header2.php"); ?>
        <!-- Content body start -->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <!-- Include breadcrumb code here -->
                </div>
                <div class="row">
                    <div class="col-xl-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Edit Lecture</h5>
                            </div>
                            <div class="card-body">
                                <form action="#" method="post" id="editLectureForm">
                                    <input type="hidden" name="lecture_id" value="<?php echo $lecture_id; ?>">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="course_id">Course</label>
                                                <select id="course_id" name="course_id" class="form-control" required="">
                                                    <option value="">Select Course</option>
                                                    <?php
                                                       $course_query = "SELECT `id`, `name` FROM `courses`";
                                                       $course_result = $conn->query($course_query);
                                                       if ($course_result->num_rows > 0) {
                                                           while ($course_row = $course_result->fetch_assoc()) {
                                                               $selected = ($row['course_id'] == $course_row['id']) ? "selected" : "";
                                                               echo '<option value="' . $course_row['id'] . '" ' . $selected . '>' . $course_row['name'] . '</option>';
                                                           }
                                                       }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="lecture_name">Lecture Name</label>
                                                <input placeholder="Lecture Name" id="lecture_name" name="lecture_name" type="text" class="form-control" required="" value="<?php echo $row['lecture_name']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="duration_minutes">Duration (minutes)</label>
                                                <input placeholder="Duration (minutes)" id="duration_minutes" name="duration_minutes" type="text" class="form-control" required="" value="<?php echo $row['duration_minutes']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Content body end -->
        <!-- Footer start -->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="http://otech.agency/" target="_blank">O tech Agency</a> 2024</p>
            </div>
        </div>
        <!-- Footer end -->
    </div>
    <!-- Main wrapper end -->
    <!-- Scripts -->
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
    exit(); // استخدام exit() بعد الانتهاء من عملية التحقق
}

header("Location: login.php"); // توجيه المستخدم إلى صفحة تسجيل الدخول إذا لم يكن لديه جلسة نشطة
exit();
?>
