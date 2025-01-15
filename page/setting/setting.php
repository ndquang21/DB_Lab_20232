<?php
  session_start();
  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
    header("Location: ../../login_main.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Driver Licenses</title>

    <!-- CSS only -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css"
      integrity="sha512-Oy+sz5W86PK0ZIkawrG0iv7XwWhYecM3exvUtMKNJMekGFJtVAhibhRPTpmyTj8+lJCkmWfnpxKgT2OopquBHA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <style>
      table .bi-check-circle-fill {
        color: green;
      }

      table .bi-x-circle-fill {
        color: red;
      }

      table .btn.btn-danger {
        font-size: 14px;
      }
      .alert {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 20px;
        background-color: rgba(255, 0, 0, 0.8);
        color: white;
        transition: opacity 0.6s;
        border-radius: 16px;
        z-index: 1000;
      }
      .alert.fadeout {
        opacity: 0;
      }
    </style>
    <link rel="stylesheet" href="../../style.css" />
  </head>

  <body>
  <div class="wrapper">
  <!-- Sidebar Holder -->
  <div class="log-out">
    <a href="../../logout.php">
      <i class="bi bi-person-circle"></i>
      <h6>Đăng xuất</h6>
    </a>
  </div>
  <!--  -->
  <nav class="m sidebar active">
    <div id="full-w" class="sidebar-header">
      <div class="hid">
        <a href="../../index.php">
          <img src="../../2.png" alt="logo" style="width: 150px; height: 150px; margin: 0 30px" /></a>
      </div>
      <strong><i class="bi bi-list"></i></strong>
    </div>

    <ul class="list-unstyled components">
      <li class="dropdown color">
        <div class="dropdown-content">
          <ul>
            <li><a href="../list/list-driver.php">Drivers</a></li>
            <li>
              <a href="../list/list-driverLicenseTest.php">Driver's license test</a>
            </li>
            <li>
              <a href="../list/list-driverLicense.php">Driver's license</a>
            </li>
            <li>
              <a href="../list/list-drivingTestingFacility.php">Driving testing facility</a>
            </li>
            <li>
              <a href="../list/list-violationHistory.php">Violation history</a>
            </li>
            <li>
              <a href="../list/list-changeDriverLicense.php">Change driver license</a>
            </li>
          </ul>
        </div>
        <a>
          <i class="bi bi-card-checklist"></i>
          List
        </a>
      </li>
      <li class="dropdown">
        <div class="dropdown-content">
          <ul>
            <li><a href="../new/n-driver_html.php">New driver</a></li>
            <li>
              <a href="../new/n-driverTest_html.php">New driver test</a>
            </li>
            <li>
              <a href="../new/n-driverLicense_html.php">New driver license</a>
            </li>
            <li>
              <a href="../new/n-drivingTestingFacility_html.php">New driving testing facility</a>
            </li>
            <li>
              <a href="../new/n-violation_html.php">New violation</a>
            </li>
            <li>
              <a href="../new/n-changeDriverLicense_html.php">New change driver license</a>
            </li>
          </ul>
        </div>
        <a>
          <i class="bi bi-plus-circle"></i>
          New
        </a>
      </li>
      <li class="dropdown">
        <div class="dropdown-content">
          <ul>
            <li>
              <a href="../edit/e-driver.php">Edit driver information</a>
            </li>
            <li>
              <a href="../edit/e-driverLicenseTest.php">Edit driver's license test information</a>
            </li>
            <li>
              <a href="../edit/e-driverLicense.php">Edit driver's license information</a>
            </li>
            <li>
              <a href="../edit/e-violation.php">Edit violation history</a>
            </li>
            <li>
              <a href="../edit/e-drivingTestingFacility.php">Edit driving testing facility information</a>
            </li>
            <li>
              <a href="../edit/e-changeDriverLicense.php">Edit chang driver license history</a>
            </li>
          </ul>
        </div>
        <a>
          <i class="bi bi-pencil-square"></i>
          Edit
        </a>
      </li>
      <li class="">
        <a href="../setting/setting.php">
          <i class="bi bi-gear"></i>
          Setting
        </a>
      </li>
    </ul>
  </nav>
  <nav class="sidebar active"></nav>

      <!-- Page Content Holder -->
      <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
            <a class="navbar-brand" href="#">Driver Licenses</a>
          </div>
        </nav>
        <div class="container" id="main">
          <div class="row justify-content-center align-items-center mt-4">
            <div class="col-lg-6 col-lg-offset-4">
              <form action="./setting_update.php" method="post">
                <div class="form-group row mb-3">
                  <label for="input-type" class="col-sm-3 col-form-label"
                    >Mật khẩu <br />hiện tại</label
                  >
                  <div class="col-sm-9">
                    <input
                      type="password"
                      class="form-control"
                      id="currentpass"
                      name="currentpass"
                      placeholder="Mật khẩu cũ"
                    />
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <label for="input-type" class="col-sm-3 col-form-label"
                    >Mật khẩu <br/>mới</label
                  >
                  <div class="col-sm-9">
                    <input
                      type="password"
                      class="form-control"
                      id="newpass"
                      name="newpass"
                      placeholder="Mật khẩu mới"
                    />
                  </div>
                </div>
                <div class="form-group row mb-3">
                <label for="input-type" class="col-sm-3 col-form-label"
                    > Nhập lại <br/>mật khẩu mới</label
                  >
                  <div class="col-sm-9">
                    <input
                      type="password"
                      class="form-control"
                      id="confirmpass"
                      name="confirmpass"
                      placeholder="Xác nhận lại"
                    />
                  </div>
                </div>
                <button type="submit" class="btn btn-primary" id="submit-btn">
                  Submit
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<div id="error-alert" class="alert">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    ?>
    <!-- JavaScript Bundle with Popper -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
    ></script>
    <script src="../../script/storage.js"></script>
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
