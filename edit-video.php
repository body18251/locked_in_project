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
        $pdf_id = $_POST['pdf_id'];
        $file_name = $_POST['file_name'];
        $description = $_POST['description'];
        $course_id = $_POST['course_id'];

        $update_query = "UPDATE video_files_extra SET file_name=?, description=?, course_id=? WHERE id=?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssii", $file_name, $description, $course_id, $pdf_id);
        $update_result = $stmt->execute();

        if ($update_result) {
            if (!empty($_POST['pdf_url'])) {
                $pdf_url = $_POST['pdf_url']; // احصل على عنوان URL لملف الصوت
                // تحديث عنوان URL لملف الصوت في قاعدة البيانات
                $update_url_query = "UPDATE video_files_extra SET file_path=? WHERE id=?";
                $stmt_url = $conn->prepare($update_url_query);
                $stmt_url->bind_param("si", $pdf_url, $pdf_id);
                $update_url_result = $stmt_url->execute();
                if (!$update_url_result) {
                    echo "Failed to update file URL data.";
                }
            }
            
            header("Location: video.php"); // توجيه المستخدم إلى الصفحة الرئيسية بعد نجاح التحديث
            exit();
        } else {
            echo "Failed to update data.";
        }
    }

    $pdf_id = $_GET['id']; // افتراض أن الرابط يحمل معرف الملف
    $query = "SELECT * FROM video_files_extra WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $pdf_id);
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
                            <h5 class="card-title">Edit audio File</h5>
                        </div>
                        <div class="card-body">
                            <form action="#" method="post" id="editPDFForm" enctype="multipart/form-data">
                                <input type="hidden" name="pdf_id" value="<?php echo $pdf_id; ?>">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="file_name">File Name</label>
                                            <input id="file_name" type="text" name="file_name" class="form-control" value="<?php echo $row['file_name']; ?>" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="description">Description</label>
                                            <input id="description" type="text" name="description" class="form-control" value="<?php echo $row['description']; ?>" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="pdf_url">Audio File URL</label>
                                            <input id="pdf_url" type="text" name="pdf_url" class="form-control" value="<?php echo $row['file_path']; ?>" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="course_id">Course</label>
                                            <select id="course_id" name="course_id" class="form-control" required="">
                                                <option value="">Select Course</option>
                                                <?php
                                                   $sql = "SELECT `crm_id`, `name` FROM `course`";
                                                   $result = $conn->query($sql);
                                                   if ($result->num_rows > 0) {
                                                       while ($course_row = $result->fetch_assoc()) {
                                                           $selected = ($row['course_id'] == $course_row['crm_id']) ? "selected" : "";
                                                           echo '<option value="' . $course_row['crm_id'] . '" ' . $selected . '>' . $course_row['name'] . '</option>';
                                                       }
                                                   }
                                                ?>
                                            </select>
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