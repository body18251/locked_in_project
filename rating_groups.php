<?php
include("includes/header2.php");
?>
<?php
session_start(); 

if(isset($_SESSION['user'])) { 
    ?>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userId'])) {
        $userId = $_POST['userId'];
        
        $servername = "localhost";
        $username = "quiczwaq_locked";
        $password = "Dsa123!@#";
        $dbname = "quiczwaq_locked";
    
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        if ($conn->connect_error) {
            die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
        }
    
    
        if ($conn->query($sql) === TRUE) {
            http_response_code(200);
        } else {
            http_response_code(500);
        }
    
        $conn->close();
    
        exit;
    }
    ?>

    <body>
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

    <div id="main-wrapper">
        <?php
        include("includes/includes.php");
        ?>

        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>All Rating Groups</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Rating</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Rating Groups</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">All Rating Groups</h4>
                                <?php
                                $userType = $_SESSION['user']['type'];
                                if ($userType == 'Super') {
                                    echo '<a href="new_group_rating.php" class="btn btn-primary">+ Add new</a>';
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
                                                        <th>Title</th>
                                                        <th>Description</th>
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
                                                    $sql = "SELECT id, name, title, description FROM rating_groups";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        $row_number = 1;
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<tr>";
                                                            echo "<td><strong>" . $row_number . "</strong></td>";
                                                            echo "<td>" . $row['name'] . "</td>";
                                                            echo "<td>" . $row['title'] . "</td>";
                                                            echo "<td>" . $row['description'] . "</td>";
                                                            $userType = $_SESSION['user']['type'];
                                                            if ($userType == 'Super') {
                                                                echo '
                                                                    <td>
                                                                        <div class="d-flex">
                                                                            <a href="rating_group_edit.php?id=' . $row['id'] . '" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fa fa-pencil"></i></a>
                                                                            <a href="rating_group_delete.php?id=' . $row['id'] . '" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                                        </div>
                                                                    </td>
                                                                ';
                                                            }
                                                            echo "</tr>";
                                                            $row_number++;
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
        </div>

        <script src="vendor/global/global.min.js"></script>
        <script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
        <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
        <script src="js/plugins-init/datatables.init.js"></script>
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
