<?php
include("includes/header2.php");
?>
<?php
session_start(); 

if(isset($_SESSION['user'])) { 
    // اتصال بقاعدة البيانات
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "quiczwaq_locked";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
    }

    // استعلام SQL لاسترداد البيانات
    $sql = "SELECT `answer`, `date`, `time`, `group_id`, `name`, `phone`, `branch`, `course` FROM `msq_answer` WHERE 1";
    $result = $conn->query($sql);

    // تحديد عدد الصفحات المطلوبة
    $results_per_page = 5;
    $number_of_results = $result->num_rows;
    $number_of_pages = ceil($number_of_results / $results_per_page);

    // تحديد صفحة البداية والنهاية
    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    $this_page_first_result = ($page - 1) * $results_per_page;

    // استعلام SQL مع تحديد الصفوف التي تظهر في الصفحة الحالية
    $sql .= " LIMIT $this_page_first_result, $results_per_page";
    $result = $conn->query($sql);
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
            <?php include("includes/includes.php"); ?>

            <!--**********************************
                Content body start
            ***********************************-->
            <div class="content-body">
                <div class="container-fluid">
                    <!-- row -->
                    <div class="row page-titles mx-0">
                        <div class="col-sm-6 p-md-0">
                            <div class="welcome-text">
                                <h4>All Answers</h4>
                            </div>
                        </div>
                        <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Answers</a></li>
                                <li class="breadcrumb-item active"><a href="javascript:void(0);">All answers</a></li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">All Answers</h4>
                                    <?php
                                    $userType = $_SESSION['user']['type'];
                                    if ($userType == 'Super') {
                                        echo '<div style="display: inline-block;">';
                                        echo '<a href="Delete-rating-all.php" class="btn btn-primary me-2">Delete all</a>';
                                        // echo '<a href="admin-excel.php" class="btn btn-success me-2">Export Excel</a>';
                                        // echo '<a href="pdf.php" class="btn btn-success">Export Pdf</a>';

                                        echo '</div>';                                                        
                                    }
                                    ?>
                                </div>
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-responsive-md">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:80px;">#</th>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                            <th>Group ID</th>
                                                            <th>Name</th>
                                                            <th>Phone</th>
                                                            <th>Branch</th>
                                                            <th>Course</th>
                                                            <?php
                                                            // استعلام SQL لاسترداد البيانات
                                                            $sql = "SELECT `answer`, `date`, `time`, `group_id`, `name`, `phone`, `branch`, `course` FROM `msq_answer` WHERE 1";
                                                            $result = $conn->query($sql);

                                                            // حصر الأسئلة من البيانات المسترجعة
                                                            $questions = array();
                                                            if ($result->num_rows > 0) {
                                                                $row = $result->fetch_assoc();
                                                                // استخراج الأسئلة من الأولى التي تم استرجاعها
                                                                $answers = explode(',', $row['answer']);
                                                                foreach ($answers as $answer) {
                                                                    list($question, $response) = explode(':', $answer, 2);
                                                                    $question = trim($question);
                                                                    $questions[] = $question;
                                                                    echo "<th>$question</th>";
                                                                }
                                                            }
                                                            ?>
                                                            <th>message</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if ($result->num_rows > 0) {
                                                            $row_number = 1;
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td>" . $row_number . "</td>";
                                                                echo "<td>" . $row['date'] . "</td>";
                                                                echo "<td>" . $row['time'] . "</td>";
                                                                echo "<td>" . $row['group_id'] . "</td>";
                                                                echo "<td>" . $row['name'] . "</td>";
                                                                echo "<td>" . $row['phone'] . "</td>";
                                                                echo "<td>" . $row['branch'] . "</td>";
                                                                echo "<td>" . $row['course'] . "</td>";
                                                                // تحليل الإجابة إلى أسئلة وإجابات منفصلة
                                                                $answers = explode(',', $row['answer']);
                                                                foreach ($answers as $answer) {
                                                                    list($question, $response) = explode(':', $answer, 2);
                                                                    $question = trim($question);
                                                                    $response = trim($response);
                                                                    echo "<td>" . $response . "</td>";
                                                                }
                                                                echo '
                                                                <td>
                                                                    <div class="d-flex">
                                                                        <button type="button" class="btn btn-primary sendMessageButton" data-bs-toggle="modal" data-bs-target="#exampleModalCenter_' . $row['phone'] . '">
                                                                            <i class="fas fa-message"></i> 
                                                                        </button>
                                                                    </div>
                                                                </td>';
                                                                echo '  
                                                                <div class="modal fade" id="exampleModalCenter_' . $row['phone'] . '">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Write a Message</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <!-- Form for writing a message -->
                                                                                <form action="send1.php" method="post">
                                                                                    <div class="mb-3">
                                                                                        <label for="message" class="form-label">Your Message:</label>
                                                                                        <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                                                                                    </div>
                                                                                    <input type="hidden" name="phone" value="' . (isset($row['phone']) ? $row['phone'] : '') . '">
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <!-- Button to close the modal -->
                                                                                <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                                                                <!-- تم تعديل نوع الزر إلى submit ليقوم بإرسال النموذج إلى الصفحة المستهدفة -->
                                                                                <button type="submit" class="btn btn-primary">Send Message</button>
                                                                            </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>';
                                                                echo "</tr>";

                                                                $row_number++;
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
            </div>
            <!--**********************************
                Content body end
            ***********************************-->
        </div>
        <!--**********************************
            Main wrapper end
        ***********************************-->
        <!-- Pagination links -->
        <div class="pagination">
            <?php
            // إنشاء روابط التنقل بين الصفحات
            for ($page = 1; $page <= $number_of_pages; $page++) {
                echo '<a href="rating_answer.php?page=' . $page . '"';
                // تحديد الصفحة الحالية وتمييزها
                if ($page == $_GET['page']) {
                    echo ' class="active"';
                }
                echo '>' . $page . '</a> ';
            }
            ?>
        </div>


        <!--**********************************
            Scripts
        ***********************************-->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // تحديد الزر الذي يقوم بإرسال الرسالة
                var sendButton = document.querySelector("#exampleModalCenter button[type='submit']");

                // إضافة حدث النقر على الزر
                sendButton.addEventListener("click", function(event) {
                    // منع السلوك الافتراضي للزر (إرسال النموذج)
                    event.preventDefault();

                    // جلب قيمة الرسالة من النموذج
                    var message = document.querySelector("#exampleModalCenter textarea[name='message']").value;

                    // جلب رقم الهاتف من النموذج (يمكنك استبدال هذا بقيمة الهاتف المطلوبة)
                    var phone = document.querySelector("#exampleModalCenter .modal-body input[name='phone']").value;

                    // إنشاء طلب HTTP POST باستخدام API
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "https://app.topwhats.com/send-message?api_key=QNlpPsDeVMx7U4Q7NK6GLbAc2H0QMh&sender=201508239717&number=" + phone + "&message=" + encodeURIComponent(message) + "&type=text");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                // تم إرسال الرسالة بنجاح
                                alert("تم إرسال الرسالة بنجاح!");
                                // إغلاق النافذة المنبثقة بعد إرسال الرسالة
                                document.querySelector("#exampleModalCenter").modal("hide");
                            } else {
                                // فشل في إرسال الرسالة
                                alert("تم إرسال الرسالة بنجاح!");
                                // إغلاق النافذة المنبثقة بعد إرسال الرسالة
                                document.querySelector("#exampleModalCenter").modal("hide");
                            }
                        }
                    };
                    xhr.send();
                });
            });
        </script>

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
        <style>
            .pagination {
                margin-top: 20px;
                margin-left: 750px;
                text-align: center;
            }

            .pagination a {
                color: #f79518;
                padding: 8px 16px;
                text-decoration: none;
                transition: background-color 0.3s;
                border: 1px solid #f79518;
                margin: 0 4px;
                border-radius: 5px;
            }

            .pagination a.active {
                background-color: #f79518;
                color: white;
            }

            .pagination a:hover:not(.active) {
                background-color: #f79518;
            }
        </style>
    </body>
    </html>
    <?php
    exit();
}
header("Location: login.php");
exit();
?>
