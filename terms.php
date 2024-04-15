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
                            <h4>Edit terms & condition</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            
                            <li class="breadcrumb-item"><a href="add-professor.php">Settings</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">terms  & condition</a></li>
                        </ol>
                    </div>
                </div>
			
				<div class="row">
					<div class="col-xl-12 col-xxl-12 col-sm-12">
                        <div class="card">
                           
							<div class="card-body">
							<?php
                            $servername = "localhost"; 
                            $username = "quiczwaq_locked"; 
                            $password = "Dsa123!@#";    
                            $dbname = "quiczwaq_locked"; 
                            
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            
                            if ($conn->connect_error) {
                                die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
                            }
// استعلام لاسترداد البيانات الحالية من قاعدة البيانات
$query = "SELECT `id`, `data` FROM `terms_conditions` WHERE 1";
$result = mysqli_query($conn, $query);

// التحقق من وجود بيانات لعرضها في النموذج
if (mysqli_num_rows($result) > 0) {
    // بداية النموذج
    echo '<form action="" method="post" id="editTermsForm">';
    echo '<div class="row">';
    echo '<div class="mb-3">';

    
    echo '<textarea class="form-control" rows="8" id="comment" name="data">';
    // عرض البيانات الحالية في النموذج
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['data']; // تعديل العرض حسب هيكل الجدول واحتياجاتك
    }
    echo '</textarea>';
    echo '</div>';
    echo '<div class="col-lg-12 col-md-12 col-sm-12">';
    echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">save</button>';

    echo '<div class="modal fade" id="exampleModalCenter">';
    echo '<div class="modal-dialog modal-dialog-centered" role="document">';
    echo '  <div class="modal-content">';
    echo '    <div class="modal-header">';
    echo '      <h5 class="modal-title">Confirm editing</h5>';
    echo '      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>';
    echo '    </div>';
    echo '    <div class="modal-body">';
    echo '       <p>Are you sure that you want to modify the data? Please note that the modification will be applied immediately and there is no way to retrieve the previous data in any way..</p>';
    echo '   </div>';
    echo '   <div class="modal-footer">';
    echo '    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>';
    echo '    <button type="submit" class="btn btn-primary">Save changes</button>';
    echo '  </div>';
    echo ' </div>';
    echo '</div>';
    echo '</div>';
    

    
    echo '</div>';
    echo '</div>';
    echo '</form>';

    // التحقق من تقديم النموذج
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // تحديث البيانات في قاعدة البيانات
        $newData = $_POST['data']; // احصل على البيانات المحدثة من النموذج
        $updateQuery = "UPDATE `terms_conditions` SET `data`='$newData' WHERE 1";
        $updateResult = mysqli_query($conn, $updateQuery);

        // التحقق من نجاح التحديث
        if ($updateResult) {
            echo '<script>';
            echo 'window.location.href = "terms.php";'; // استبدل "page.php" برابط الصفحة التي تريد توجيه المستخدم إليها
            echo '</script>';
        } else {
            echo '<p style="color: red; font-weight: bold;">حدث خطأ أثناء تحديث البيانات.</p>';
        }
    }
} else {
    echo "لا توجد بيانات متاحة.";
}
?>
                    
                             
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