<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verify Code</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="images/img-01.png" alt="IMG">
                </div>

                <form class="login100-form validate-form" action="check_code.php" method="post">
                    <span class="login100-form-title">
                        Verify Code
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Verification code is required">
                        <input class="input100" type="text" name="code" placeholder="Verification Code">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-key" aria-hidden="true"></i>
                        </span>
                    </div>
                    
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Verify
                        </button>
                    </div>

                    <div class="text-center p-t-12">
                        <a class="txt2" href="forgot_password.php">
                            Go back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    session_start();
    if (isset($_SESSION['error'])) {
        echo '<div id="error-alert" class="alert">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    ?>

    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/tilt/tilt.jquery.min.js"></script>
    <script >
        $('.js-tilt').tilt({
            scale: 1.1
        })
    </script>
    <script src="./js/main.js"></script>
    <script>
        window.onload = function() {
            var alert = document.getElementById('error-alert');
            if (alert) {
                setTimeout(function() {
                    alert.classList.add('fadeout');
                }, 2000);
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 2600);
            }
        };
    </script>
</body>
</html>
