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
            
              

                <!-- عرض بيانات الإشعارات -->
                <div class="row">
                    <div class="col-xl-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Notifications Data</h4>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Body</th>
                                                <th scope="col">Page</th>
                                                <th scope="col">Time</th>
                                                <th scope="col">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                             $servername = "localhost"; 
                                             $username = "quiczwaq_locked"; 
                                             $password = "Dsa123!@#";    
                                             $dbname = "quiczwaq_locked"; 
                                             
                                             $conn = new mysqli($servername, $username, $password, $dbname);
                                             
                                             if ($conn->connect_error) {
                                                 die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
                                             }
                                            // استعلام SQL لاسترداد بيانات الإشعارات
                                            $sql = "SELECT `id`, `title`, `body`, `time`, `Date`, `page` FROM `notfication`";
                                            $result = mysqli_query($conn, $sql);
                                            if(mysqli_num_rows($result) > 0) {
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<th scope='row'>" . $row['id'] . "</th>";
                                                    echo "<td>" . $row['title'] . "</td>";
                                                    echo "<td>" . $row['body'] . "</td>";
                                                    echo "<td>" . $row['page'] . "</td>";
                                                    echo "<td>" . $row['time'] . "</td>";
                                                    echo "<td>" . $row['Date'] . "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='5'>No notifications found</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /عرض بيانات الإشعارات -->

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
        // بيانات FCM endpoint
        $url = 'https://fcm.googleapis.com/fcm/send';

        // بيانات الإشعار
        $data = array(
            'to' => '/topics/LocekInNotification',
            'notification' => array(
                'title' => $_POST['title'],
                'body' => $_POST['body']
            ),
            'data' => array(
                'url' => '<url of media image>',
                'dl' => '<deeplink action on tap of notification>'
            )
        );

        // تحويل البيانات إلى JSON
        $postData = json_encode($data);

        // العنوان الرئيسي ورؤوس الطلب
        $headers = array(
            'Authorization: key=AAAA33NZ1kk:APA91bEZutopTnqXfRG4iyXGXyQbh9t870JjyrauI_UoxQBYdpUtjKsTkIB50tnu6HOlUGjBdmfKpyxCf_BA4EMqI_P_gct477SjsFKbJjlbPg1aSlAMAXyzYX8FSZUPa35GevPH1Xqn',
            'Content-Type: application/json'
        );

        // تكوين خيارات cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);

        // إرسال الطلب والحصول على الاستجابة
        $response = curl_exec($curl);

        // إغلاق الاستجابة
        curl_close($curl);

        // عرض الاستجابة
        echo $response;

        // إذا تم إرسال الإشعار بنجاح، يتم إضافة البيانات إلى قاعدة البيانات
        if ($response) {
            // قم بتسجيل بيانات الإشعار في قاعدة البيانات
            $title = $_POST['title'];
            $body = $_POST['body'];
            $date = date('Y-m-d H:i:s'); // تاريخ ووقت الإشعار

            // استعلام SQL لتسجيل بيانات الإشعار في قاعدة البيانات
            $sql = "INSERT INTO `notfication` (`title`, `body`, `time`, `Date`) VALUES ('$title', '$body', NOW(), '$date')";
            // يمكنك تنفيذ الاستعلام أيضًا باستخدام PDO أو MySQLi إذا كنت تفضل ذلك

            // هنا يجب عليك تنفيذ الاستعلام والتحقق من نجاح التنفيذ
            // يمكنك استخدام PDO أو MySQLi لتنفيذ الاستعلام
            // هذا مجرد مثال استعرض الاستعلام فقط
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
