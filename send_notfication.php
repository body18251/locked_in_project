<?php
header('Content-Type: text/html; charset=utf-8');

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
                            <h4>Notifications</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="add-professor.php">Notifications</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Send Notifications</a></li>
                        </ol>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-xl-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="post" id="editTermsForm">
                                    <div class="row">
                                        <div class="mb-3">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="Title">Title</label>
                                                    <input id="Title" type="text" name="title" class="form-control" required="">
                                                </div>
                                            </div> 
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="Body">Body</label>
                                                    <input id="Body" type="text" name="body" class="form-control" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- Dropdown for selecting page name -->
                                            <div class="form-group">
                                                <label class="form-label" for="PageName">Page Name</label>
                                                <select id="PageName" name="pagename" class="form-control" required="">
                                                    <option value="">Select Page</option>
                                                    <?php
                                                    // Array of pages
                                                    $pages = array(
                                                        "notifications" => "notifications",
                                                        "offers" => "offers",
                                                        // Add more pages if needed
                                                    );

                                                    // Display page options
                                                    foreach ($pages as $pageName => $pageUrl) {
                                                        echo "<option value=\"$pageUrl\">$pageName</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- End of Dropdown -->
                                            <button type="submit" name="send_notification" class="btn btn-primary">Send Notification</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Display notifications data -->
                <div class="row">
                    <div class="col-xl-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <?php
                            $servername = "localhost"; 
                            $username = "root"; 
                            $password = "";    
                            $dbname = "quiczwaq_locked"; 
                            
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            
                            if ($conn->connect_error) {
                                die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
                            }
                            // SQL query to retrieve notification data
                            ?>
                        </div>
                    </div>
                </div>
                <!-- End of displaying notifications data -->

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
    if(isset($_POST['send_notification'])) {
        // FCM endpoint data
        $url = 'https://fcm.googleapis.com/fcm/send';

        // Notification data
        $data = array(
            'to' => '/topics/LocekInNotification',
            'notification' => array(
                'title' => $_POST['title'],
                'body' => $_POST['body']
            ),
            'data' => array(
                'pagename' => $_POST['pagename']
                // 'dl' => '<deeplink action on tap of notification>'
            )
        );

        // Convert data to JSON
        $postData = json_encode($data);

        // Main headers and request headers
        $headers = array(
            'Authorization: key=AAAA33NZ1kk:APA91bEZutopTnqXfRG4iyXGXyQbh9t870JjyrauI_UoxQBYdpUtjKsTkIB50tnu6HOlUGjBdmfKpyxCf_BA4EMqI_P_gct477SjsFKbJjlbPg1aSlAMAXyzYX8FSZUPa35GevPH1Xqn',
            'Content-Type: application/json'
        );

        // cURL options setup
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);

        // Send request and get response
        $response = curl_exec($curl);

        // Close response
        curl_close($curl);

        // Display response
        echo $response;

        // If notification sent successfully, add data to database
        if ($response) {
            // Record notification data in the database
            $title = $_POST['title'];
            $body = $_POST['body'];
            $date = date('Y-m-d'); // Notification date and time
            $time = date('H:i'); // Notification date and time
            $page = $_POST['pagename'];

            // SQL query to record notification data in the database
            $sql = "INSERT INTO `notfication` (`title`, `body`, `time`, `Date`, `page`) VALUES ('$title', '$body', '$time', '$date', '$page')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "تم تسجيل بيانات الإشعار بنجاح في قاعدة البيانات.";
            } else {
                echo "حدث خطأ أثناء تسجيل بيانات الإشعار في قاعدة البيانات.";
            }
        } else {
            echo "حدث خطأ أثناء إرسال الإشعار.";
        }
    }
?>
<?php
    exit();
}
header("Location: login.php");
exit();
?>
