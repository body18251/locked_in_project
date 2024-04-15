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
        $group_id = $_POST['group_id'];
        $name = $_POST['name'];
        $title = $_POST['title'];
        $description = $_POST['description'];

        $update_query = "UPDATE rating_groups SET name=?, title=?, description=? WHERE id=?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssi", $name, $title, $description, $group_id);
        $update_result = $stmt->execute();

        if ($update_result) {
            header("Location: rating_groups.php"); // توجيه المستخدم إلى الصفحة الرئيسية بعد نجاح التحديث
            exit();
        } else {
            echo "Failed to update data.";
        }
    }

    $group_id = $_GET['id']; // افتراض أن الرابط يحمل معرف الجروب
    $query = "SELECT * FROM rating_groups WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $group_id);
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
                            <h5 class="card-title">Edit Rating Group</h5>
                        </div>
                        <div class="card-body">
                            <form action="#" method="post" id="editRatingGroupForm">
                                <input type="hidden" name="group_id" value="<?php echo $group_id; ?>">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="name">Name</label>
                                            <input id="name" type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="title">Title</label>
                                            <input id="title" type="text" name="title" class="form-control" value="<?php echo $row['title']; ?>" required="">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label" for="description">Description</label>
                                            <input id="description" type="text" name="description" class="form-control" value="<?php echo $row['description']; ?>" required="">
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
