<?php
include("includes/header2.php");
session_start();

if(isset($_SESSION['user'])) { 
    // إعداد الاتصال بقاعدة البيانات
    $servername = "localhost";
    $username = "quiczwaq_locked";
    $password = "Dsa123!@#";
    $dbname = "quiczwaq_locked";
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

    // الاستعلام عن الأجزاء مع اسم المحاضرة من جدول الكورسات
    $sql_parts = "SELECT p.id, c.lecture_name AS course_lecture, p.lecture_name, p.video_link, p.lecturer_name, p.lecture_details, p.exam_id, p.id_lecture, p.time
                  FROM parts p
                  LEFT JOIN lectures c ON p.id_lecture = c.id";
    $result_parts = $conn->query($sql_parts);
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
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>All Parts</h4>
                        


                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Parts</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">All Parts</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Parts</h4>
                            <?php
                                $userType = $_SESSION['user']['type'];
                                if ($userType == 'Super') {
                                    echo '<a href="add_part.php" class="btn btn-primary">+ Add new</a>';
                                }
                                ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th style="width:80px;">#</th>
                                            <th>Course Lecture</th>
                                            <th>Part Name</th>
                                            <th>Video Link</th>
                                            <th>Lecturer Name</th>
                                            <th>Lecture Details</th>
                                            <th>Exam ID</th>
                                            <th>Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result_parts->num_rows > 0) {
                                            $row_number_parts = 1;
                                            while ($row_parts = $result_parts->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td><strong>" . $row_number_parts . "</strong></td>";
                                                echo "<td>" . $row_parts['course_lecture'] . "</td>";
                                                echo "<td>" . $row_parts['lecture_name'] . "</td>";
                                                echo "<td>" . $row_parts['video_link'] . "</td>";
                                                echo "<td>" . $row_parts['lecturer_name'] . "</td>";
                                                echo "<td>" . $row_parts['lecture_details'] . "</td>";
                                                echo "<td>" . $row_parts['exam_id'] . "</td>";
                                                echo "<td>" . $row_parts['time'] . "</td>";
                                                $userType = $_SESSION['user']['type'];
                                                if ($userType == 'Super') {
                                                    echo '
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="part_edit.php?id=' . $row_parts['id'] . '" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fa fa-pencil"></i></a>
                                                            <a href="part_delete.php?id=' . $row_parts['id'] . '" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </td>
                                                    ';
                                                }
                                                echo "</tr>";
                                                $row_number_parts++;
                                            }
                                        } else {
                                            echo "<tr><td colspan=\"10\">No data available</td></tr>";
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

</div>

<!-- Required vendors -->
<script src="vendor/global/global.min.js"></script>
<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<!-- Datatable -->
<script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="js/plugins-init/datatables.init.js"></script>
<!-- Svganimation scripts -->
<script src="vendor/svganimation/vivus.min.js"></script>
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
