<?php
include("includes/header2.php");

?>
<?php
session_start(); 

if(isset($_SESSION['user'])) { 
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
                            <h4>Add Admin</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            
                            <li class="breadcrumb-item"><a href="add-professor.php">Admins</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Admin</a></li>
                        </ol>
                    </div>
                </div>
				<?php
$servername = "localhost"; 
$username = "root"; 
$password = "";    
$dbname = "quiczwaq_locked"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobile_number = $_POST['mobile_number'];
    $gender = $_POST['gender'];
    $type = $_POST['type'];

    // التحقق من تكرار البريد الإلكتروني
    $check_email_query = "SELECT * FROM admins WHERE email='$email'";
    $result_email = $conn->query($check_email_query);
    if ($result_email->num_rows > 0) {
		echo '<p style="color: red; font-weight: bold;">البريد الألكتروني مسجل من قبل</p>';



    } else {
        // التحقق من تكرار رقم الهاتف
        $check_mobile_query = "SELECT * FROM admins WHERE mobile_number='$mobile_number'";
        $result_mobile = $conn->query($check_mobile_query);
        if ($result_mobile->num_rows > 0) {
			echo '<p style="color: red; font-weight: bold;">رقم الهاتف مسجل من قبل </p>';
        } else {
            // إدراج البيانات في الجدول
            $insert_query = "INSERT INTO admins (employee_name, email, password, mobile_number, Gender, type)
                             VALUES ('$name', '$email', '$password', '$mobile_number', '$gender', '$type')";
            if ($conn->query($insert_query) === TRUE) {
				echo '<p style="color: green; font-weight: bold;">تمت إضافة الموظف بنجاح</p>';
            } else {
                echo "خطأ في إدراج البيانات: " . $conn->error;
            }
        }
    }
}
?>



				<div class="row">
					<div class="col-xl-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
								<h5 class="card-title">Basic Info</h5>
							</div>
							<div class="card-body">
							<form action="" method="post" id="addStaffForm">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label class="form-label" for="first_name"> Name</label>
												<input placeholder="Enter  Name" id="name" name="name" type="text" class="form-control" required="">
												
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="form-label" for="email_here">Email Here</label>
												<input placeholder="Email Here" id="email_here" name="email" type="email" class="form-control" required="">
											</div>
										</div>
									
									
										<div class="col-sm-6">
											<div class="form-group">
												<label class="form-label" for="password">Password</label>
												<div class="input-group pass-group">
													<input placeholder="Password" id="password" type="password" name="password"  class="form-control pass-input" required="">
													<span class="input-group-text pass-handle"> 
														<i class="fa fa-eye-slash"></i>
														<i class="fa fa-eye"></i>
													</span>
												</div>
											</div>
										</div>
									
										<div class="col-sm-6">
											<div class="form-group">
												<label class="form-label" for="mobile_number">Mobile Number</label>
												<input placeholder="Mobile Number" id="mobile_number" type="number" name="mobile_number" class="form-control" required="">
											</div>
										</div>
										<div class="col-sm-6">
    <div class="form-group">
        <label class="form-label">Gender</label>
        <select class="form-control" name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
    </div>
</div>

<div class="col-sm-6">
    <div class="form-group">
        <label class="form-label">Type</label>
        <select class="form-control" name="type" required>
            <option value="">Select Type</option>
            <option value="Super">Super</option>
            <option value="Admin">Admin</option>
            <option value="teacher">Teacher</option>
        </select>
    </div>
</div>

									
										
<!-- <button class="dropdown-item" onclick="confirmDelete(<?php echo $row['admin_id']; ?>)">Delete</button> -->

										<div class="col-lg-12 col-md-12 col-sm-12">
										<button type="button" name="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Submit</button>
										<button type="reset" class="btn btn-danger light">Cancel</button>
										</div>
									</div>

                                                    
                                    <div class="modal fade" id="exampleModalCenter">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Admin add confirm</h5>
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