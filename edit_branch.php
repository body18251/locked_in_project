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
        $branch_id = $_POST['branch_id'];
        $branch_name_ar = $_POST['branch_name_ar'];
        $branch_name_en = $_POST['branch_name_en'];
        $branch_name_gr = $_POST['branch_name_gr'];
        $mobile_number = $_POST['mobile_number'];
        $type = $_POST['type'];

        $update_query = "UPDATE branches SET branch_name_ar=?, branch_name_en=?, branch_name_gr=?, mobile_number=?, type=? WHERE id=?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssssi", $branch_name_ar, $branch_name_en, $branch_name_gr, $mobile_number, $type, $branch_id);
        $update_result = $stmt->execute();

        if ($update_result) {
            header("Location: brances.php"); // توجيه المستخدم إلى الصفحة الرئيسية بعد نجاح التحديث
            exit();
        } else {
            echo "Failed to update data.";
        }
    }

    $branch_id = $_GET['id']; // افتراض أن الرابط يحمل معرف الفرع
    $query = "SELECT * FROM branches WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $branch_id);
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
            <!-- row -->
            <div class="container-fluid">
			
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Edit Branch</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="edit_branch.php">Branches</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Branch</a></li>
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

							<form action="#" method="post" id="editBranchForm">
                                    <input type="hidden" name="branch_id" value="<?php echo $branch_id; ?>">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="branch_name_ar">Branch Name (Arabic)</label>
                                                <input id="branch_name_ar" type="text" name="branch_name_ar" class="form-control" value="<?php echo $row['branch_name_ar']; ?>" required="">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="branch_name_en">Branch Name (English)</label>
                                                <input id="branch_name_en" type="text" class="form-control" name="branch_name_en" value="<?php echo $row['branch_name_en']; ?>" required="">
                                            </div>
                                        </div>
                                    
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="branch_name_gr">Branch Name (Greek)</label>
                                                <input id="branch_name_gr" type="text" class="form-control" name="branch_name_gr" value="<?php echo $row['branch_name_gr']; ?>" required="">
                                            </div>
                                        </div>
                                    
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label" for="mobile_number">Mobile Number</label>
                                                <input id="mobile_number" type="tel" maxlength="120" name="mobile_number" value="<?php echo $row['mobile_number']; ?>" class="form-control"  required="">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label">Type</label>
                                                <select class="form-control" id="type" name="type" required>
                                                    <option value="1" <?php if ($row['type'] == '1') echo 'selected'; ?>>Whatsapp</option>
                                                    <option value="2" <?php if ($row['type'] == '2') echo 'selected'; ?>>Phone</option>
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
