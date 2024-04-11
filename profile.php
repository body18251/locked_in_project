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
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Hi, welcome back!</h4>
                            <p class="mb-0">Locked in Dashboard</p>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">App</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="profile card card-body px-3 pt-3 pb-0">
                            <div class="profile-head">
                                <div class="photo-content">
                                    <div class="cover-photo rounded"></div>
                                </div>
                                <div class="profile-info">
									<div class="profile-photo">
										<img src="images/avatar/1.png class="img-fluid rounded-circle" alt="">
									</div>


								
										
						
						
                    <div class="col-xl-8">
                        <div class="card h-auto">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                  
                                        <div class="tab-content">
                                           
										<div class="pt-3">
    <div class="settings-form">
        <h4 class="text-primary">Account Setting</h4>
        <!-- تعديل العنصر form ليشير إلى ملف PHP -->
        <form action="update_user.php" method="POST">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" value="<?php echo $_SESSION['user']['employee_name']; ?>" class="form-control" name="name">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Password</label>
                    <div class="input-group pass-group">
                        <input type="password" value="<?php echo $_SESSION['user']['password']; ?>" class="form-control pass-input" name="password">
                        <span class="input-group-text pass-handle"> 
                            <i class="fa fa-eye-slash"></i>
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" value="<?php echo $_SESSION['user']['email']; ?>" class="form-control" name="email">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Phone number</label>
                    <input type="number" value="<?php echo $_SESSION['user']['mobile_number']; ?>" class="form-control" name="phone">
                </div>
            </div>


                                   
                                    <div class="modal fade" id="exampleModalCenter">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirm editing</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <p>Are you sure that you want to modify the data?</p>                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Save</button>
        </form>
    </div>
</div>


									
                                </div>
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

	<script src="vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    
    <!-- Light Gallery -->
    <script src="vendor/lightgallery/dist/lightgallery.min.js"></script>
    <script src="vendor/lightgallery/dist/plugins/thumbnail/lg-thumbnail.min.js"></script>
    <script src="vendor/lightgallery/dist/plugins/zoom/lg-zoom.min.js"></script>

    
	<!-- Svganimation scripts -->
    <script src="vendor/svganimation/vivus.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="vendor/svganimation/svg.animation.js"></script>

    <script src="js/custom.min.js"></script>
    <script src="js/dlabnav-init.js"></script>
    <script src="js/demo.js"></script>
	
	<script>
		document.querySelector(".sweet-confirm").onclick = function () { 
			Swal.fire({ 
				title: "Block Profile?", 
				text: "Are you sure you want to block profile", 
				type: "warning", showCancelButton: !0, 
				confirmButtonColor: "#DD6B55", 
				confirmButtonText: "Block", 
				closeOnConfirm: !1 
			})
		}
	</script>
</body>
</html>.
<?php
    exit();
}
header("Location: login.php");
exit();
?>