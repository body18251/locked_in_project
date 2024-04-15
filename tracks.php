<?php
include("includes/header2.php");

?>
<?php
session_start(); 

if(isset($_SESSION['user'])) { 
    ?>
	<?php
// التأكد من أن الطلب هو POST وأنه يحتوي على معرف المستخدم لحذفه
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userId'])) {
    // احصل على معرف المستخدم المراد حذفه
    $userId = $_POST['userId'];
    
    // اتصل بقاعدة البيانات وقم بحذف المستخدم
    $servername = "localhost";
    $username = "quiczwaq_locked";
    $password = "Dsa123!@#";
    $dbname = "quiczwaq_locked";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

    // استعلام SQL لحذف المستخدم

    if ($conn->query($sql) === TRUE) {
        // إرسال رد ناجح بحالة 200
        http_response_code(200);
        // يمكنك إرسال أي رسالة أخرى إذا أردت
        // echo "تم حذف المستخدم بنجاح";
    } else {
        // إرسال رمز الخطأ بحالة 500 في حالة فشل الاستعلام
        http_response_code(500);
        // يمكنك إرسال رسالة خطأ إضافية إذا أردت
        // echo "حدث خطأ أثناء محاولة حذف المستخدم";
    }

    // إغلاق اتصال قاعدة البيانات
    $conn->close();

    // يجب الخروج من السكربت بعد الانتهاء من عملية الحذف
    exit;
}
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
                            <h4>All Tracks</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Settings</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Tracks</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">All Tracks</h4>
                                <?php
                                $userType = $_SESSION['user']['type'];
                                if ($userType == 'Super') {
                                    echo '<a href="track-add.php" class="btn btn-primary">+ Add new</a>';
                                }
                                ?>
                            </div>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <?php
                                            $servername = "localhost"; 
                                            $username = "quiczwaq_locked"; 
                                            $password = "Dsa123!@#";    
                                            $dbname = "quiczwaq_locked"; 

                                            $conn = new mysqli($servername, $username, $password, $dbname);

                                            if ($conn->connect_error) {
                                                die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
                                            }
                                            ?>

                                            <table class="table table-responsive-md">
                                                <thead>
                                                    <tr>
                                                        <th style="width:80px;">#</th>
                                                        <th>Name</th>
                                                        
                                                        <?php
                                                        $userType = $_SESSION['user']['type'];
                                                        if ($userType == 'Super') {
                                                            echo '<th>Action</th>';
                                                        }
                                                        ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT `id`, `crm_name` FROM `tracks` WHERE 1";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        $row_number = 1;
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td><strong>" . $row_number . "</strong></td>";
                                                            echo "<td>" . $row['crm_name'] . "</td>";
                                                         
                                                            $userType = $_SESSION['user']['type'];
                                                            if ($userType == 'Super') {
                                                                echo '
                                                                    <div class="dropdown">
                                                                      
                                                                        <td>
													<div class="d-flex">
														<a href=" track_delete.php?id=' . $row['id'] . '"" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
													</div>
												</td>
                                               
                                                                        <div class="dropdown-menu">

                                                                            
                                                                        </div>
                                                                    </div>
                                                               ';
                                                            }
                                                            echo "</tr>";
                                                            $row_number++;
                                                        }
                                                    } else {
                                                        echo "<tr><td colspan=\"8\">لا توجد بيانات متاحة</td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




              


					<div id="deleteConfirmationModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
        </div>
    </div>
</div>

			<script>
    function redirectToDeleteUser(userId) {
        window.location.href = "user_delete.php?id=" + userId;
    }
</script>


        </div>
    </div>
</div>

<script>
    function confirmDelete(adminId) {
        $('#deleteConfirmationModal').modal('show');

        // عند النقر على زر الحذف في نافذة التأكيد
        $('#deleteButton').click(function() {
            // قم بإرسال طلب AJAX لحذف الحساب
            $.ajax({
                type: "POST",
                url: "delete_account.php",
                data: { id: adminId },
                success: function(response) {
                    // قم بإعادة تحميل الصفحة بعد حذف الحساب
                    location.reload();
                },
                error:
				function(error) {
                    // في حالة حدوث خطأ، قم بطباعة الخطأ في وحدة التحكم أو التعامل معه بشكل مناسب
                    console.error("حدث خطأ: ", error);
                }
            });
        });
    }

	
</script>

				</div>
				
            </div>
        </div>
		
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
		<!-- <script>
    function confirmDelete(adminId) {
        if (confirm("هل أنت متأكد أنك تريد حذف هذا الحساب؟")) {
            // إذا قام المستخدم بالتأكيد، قم بتوجيهه إلى صفحة الحذف
            window.location.href = "delete_account.php?id=" + adminId;
        }
    }
</script> -->


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
	<!-- <script>
function confirmDelete(adminId) {
    if (confirm("هل أنت متأكد أنك تريد حذف هذا الحساب؟")) {
        // إذا قام المستخدم بالتأكيد، قم بتوجيهه إلى صفحة الحذف
        window.location.href = "delete_account.php?id=" + adminId;
    }
}
</script> -->


    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	
	<!-- Datatable -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="js/plugins-init/datatables.init.js"></script>
	
    <!-- Svganimation scripts -->
    <script src="vendor/svganimation/vivus.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="vendor/svganimation/svg.animation.js"></script>
    
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