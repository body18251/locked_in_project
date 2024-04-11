<?php
session_start(); 

if(isset($_SESSION['user_id'])) { 
    header("Location: index.php"); 
    exit();
}
include("includes/header.php");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quiczwaq_locked";

$errorMessage = ""; 
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_POST['phone']) && isset($_POST['password'])) {
        $entered_phone = $_POST['phone'];
        $entered_password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM admins WHERE mobile_number = :phone AND password = :password");
        $stmt->bindParam(':phone', $entered_phone);
        $stmt->bindParam(':password', $entered_password);
        $stmt->execute();

        $user = $stmt->fetch();
        if ($user) {
            if ($user['status'] == 1) {
                // تخزين جميع بيانات المستخدم في السيشن بعد تسجيل الدخول
                $_SESSION['user'] = $user;
                header("Location: index.php");
                exit();
            } elseif ($user['status'] == 0) {
                $errorMessage = "Your account is blocked.";
            }
        } else {
            $errorMessage = "Phone number or password is incorrect.";
        }
    }
} catch(PDOException $e) {
    $errorMessage = "خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <div class="fix-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6">
                    <div class="card mb-0 h-auto">
                        <div class="card-body">
                            <div class="text-center mb-2">
                                <img src="images/locked-logo.png" alt="Image" width="100" height="100">
                            </div>
                            <form action="login.php" method="POST">
                                <div class="form-group">
                                    <label class="form-label" for="username">phone number</label>
                                    <input type="number" class="form-control" placeholder="20XXXXXXXXXX" id="phone" name="phone">
                                </div>
                                <div class="mb-4 position-relative">
                                    <label class="form-label" for="dlabPassword">Password</label>
                                    <input type="password" id="dlabPassword" class="form-control" placeholder="Password" name="password" >
                                </div>
                                <?php if(!empty($errorMessage)) { ?>
                                    <div id="errorMessage" class="alert alert-danger" role="alert">
                                        <?php echo $errorMessage; ?>
                                    </div>
                                    <script>
                                        setTimeout(function() {
                                            var errorMessageElement = document.getElementById("errorMessage");
                                            if (errorMessageElement) {
                                                errorMessageElement.style.display = "none";
                                            }
                                        }, 2000); 
                                    </script>
                                <?php } ?>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
