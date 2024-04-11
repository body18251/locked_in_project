<?php
include("includes/header2.php");
session_start();

if(isset($_SESSION['user'])) { 
    // إعداد الاتصال بقاعدة البيانات
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "quiczwaq_locked";
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

    // الاستعلام عن المحاضرات وأسماء الكورسات
    $sql_lectures = "SELECT l.id, c.name AS course_name, l.lecture_name, l.duration_minutes 
                    FROM lectures l 
                    INNER JOIN courses c ON l.course_id = c.id";
    $result_lectures = $conn->query($sql_lectures);
?>

<body>

<div class="sk-three-bounce">
    <div class="sk-child sk-bounce1"></div>
    <div class="sk-child sk-bounce2"></div>
    <div class="sk-child sk-bounce3"></div>
</div>
</div>

<div id="main-wrapper">
    <?php include("includes/includes.php"); ?>

    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>All Lectures</h4>
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Lectures</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0);">All Lectures</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Lectures</h4>
                            <?php
                            $userType = $_SESSION['user']['type'];
                            if ($userType == 'Super') {
                                echo '<a href="add_lecture.php" class="btn btn-primary">+ Add new</a>';
                            }
                            ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th style="width:80px;">#</th>
                                            <th>Course Name</th>
                                            <th>Lecture Name</th>
                                            <th>Duration (minutes)</th>
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
                                        if ($result_lectures->num_rows > 0) {
                                            $row_number_lectures = 1;
                                            while ($row_lectures = $result_lectures->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td><strong>" . $row_number_lectures . "</strong></td>";
                                                echo "<td>" . $row_lectures['course_name'] . "</td>"; // عرض اسم الكورس بدلاً من الـ ID
                                                echo "<td>" . $row_lectures['lecture_name'] . "</td>";
                                                echo "<td>" . $row_lectures['duration_minutes'] . "</td>";
                                                $userType = $_SESSION['user']['type'];
                                                if ($userType == 'Super') {
                                                    echo '
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="lecture_edit.php?id=' . $row_lectures['id'] . '" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fa fa-pencil"></i></a>
                                                            <a href="lecture_delete.php?id=' . $row_lectures['id'] . '" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </td>
                                                    ';
                                                }
                                                echo "</tr>";
                                                $row_number_lectures++;
                                            }
                                        } else {
                                            echo "<tr><td colspan=\"4\">لا توجد بيانات متاحة</td></tr>";
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
