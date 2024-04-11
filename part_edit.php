<?php
include("includes/header2.php");
session_start();

if(isset($_SESSION['user'])) { 
    $servername = "localhost"; 
    $username = "root"; 
    $password = "";    
    $dbname = "quiczwaq_locked"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $lecture_name = $_POST['lecture_name'];
        $video_link = $_POST['video_link'];
        $lecturer_name = $_POST['lecturer_name'];
        $lecture_details = $_POST['lecture_details'];
        $exam_id = $_POST['exam_id'];
        $id_lecture = $_POST['id_lecture'];
        $time = $_POST['time'];

        $update_query = "UPDATE parts SET lecture_name=?, video_link=?, lecturer_name=?, lecture_details=?, exam_id=?, id_lecture=?, time=? WHERE id=?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssssssi", $lecture_name, $video_link, $lecturer_name, $lecture_details, $exam_id, $id_lecture, $time, $id);
        $update_result = $stmt->execute();

        if ($update_result) {
            header("Location: parts.php");
            exit();
        } else {
            echo "Failed to update data.";
        }
    }

    $id = $_GET['id']; // افتراض أن الرابط يحمل معرف الملف
    $query = "SELECT * FROM parts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
?>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
	<?php
        include("includes/includes.php");
        ?>
        <!--**********************************
            Content body start
        ***********************************-->
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
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="lecture_name">Lecture Name</label>
                                            <input id="lecture_name" type="text" name="lecture_name" class="form-control" value="<?php echo $row['lecture_name']; ?>" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="video_link">Video Link</label>
                                            <input id="video_link" type="text" name="video_link" class="form-control" value="<?php echo $row['video_link']; ?>" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="lecturer_name">Lecturer Name</label>
                                            <input id="lecturer_name" type="text" name="lecturer_name" class="form-control" value="<?php echo $row['lecturer_name']; ?>" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="lecture_details">Lecture Details</label>
                                            <input id="lecture_details" type="text" name="lecture_details" class="form-control" value="<?php echo $row['lecture_details']; ?>" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="exam_id">Exam ID</label>
                                            <input id="exam_id" type="text" name="exam_id" class="form-control" value="<?php echo $row['exam_id']; ?>" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
    <div class="form-group">
        <label class="form-label" for="id_lecture">ID Lecture</label>
        <select id="id_lecture" name="id_lecture" class="form-control" required="">
            <option value="">Select Lecture</option>
            <?php
               $sql = "SELECT `id`, `course_id`, `lecture_name`, `duration_minutes`, `exam_id` FROM `lectures`";
               $result = $conn->query($sql);
               if ($result->num_rows > 0) {
                   while ($lecture_row = $result->fetch_assoc()) {
                       $selected = ($lecture_row['id'] == $id_lecture) ? "selected" : "";
                       echo '<option value="' . $lecture_row['id'] . '" ' . $selected . '>' . $lecture_row['lecture_name'] . '</option>';
                   }
               }
            ?>
        </select>
    </div>
</div>


                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="time">Time</label>
                                            <input id="time" type="text" name="time" class="form-control" value="<?php echo $row['time']; ?>" required="">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Submit</button>
                                    </div>
                                </div>
                                <div class="modal fade" id="exampleModalCenter">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm Editing</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <p>Are you sure that you want to modify the data? Please note that the modification will be applied immediately and there is no way to retrieve the previous data in any way..</p>                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
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

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
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
    exit(); // استخدام exit() بعد الانتهاء من عملية التحقق
}

header("Location: login.php"); // توجيه المستخدم إلى صفحة تسجيل الدخول إذا لم يكن لديه جلسة نشطة
exit();
?>
