<?php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] === false) {
    header("Location: ../../login_main.php");
    exit();
  }
?>
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