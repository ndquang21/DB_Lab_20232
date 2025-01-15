<?php
//connect
require '../../db.php';
// connect
if(isset($_POST['submit-btn'])){
    $CCCD = $_POST['input-cccd'];
    $NgayThi = $_POST['input-ngaythi'];
}
$select = " SELECT *
            FROM LichSuDaoTaoSatHach
            WHERE SoCCCD = ? AND NgayThi = ?";
$params = array($CCCD, $NgayThi);
$stmt = sqlsrv_query($conn, $select, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
if (sqlsrv_has_rows($stmt) === true) {         //trong csdl có số cccd và ngày thi này
    $LicenseTest = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $_SESSION['NgayThi'] = $NgayThi;
    $_SESSION['SoCCCD'] = $CCCD;
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}   else {
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
    $_SESSION['error'] = "Sai số căn cước hoặc ngày thi";
    header("Location:e-driverLicenseTest.php"); 
    exit();}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Driver Licenses</title>

  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css"
    integrity="sha512-Oy+sz5W86PK0ZIkawrG0iv7XwWhYecM3exvUtMKNJMekGFJtVAhibhRPTpmyTj8+lJCkmWfnpxKgT2OopquBHA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

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
  </style>
  <link rel="stylesheet" href="../../style.css" />
</head>

<body>
  <?php
    require './sidebar.php'
  ?>

    <!-- Page Content Holder -->
    <div id="content">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="e-driverLicenseTest1-chon-cccd.php">Edit Driver License Test</a>
        </div>
      </nav>
      <div class="container" id="main">
        <div class="row justify-content-center align-items-center mt-4">
          <div class="col-lg-6 col-lg-offset-4">
            <form action="e-driverLicenseTest2-sua-thong-tin.php" method="post">
              <div class="form-group row mb-3">
                <label for="input-cccd" class="col-sm-3 col-form-label" data-validate="Điền CCCD">CCCD</label>
                <div class="col-sm-9">
                  <input required type="text" class="form-control" id="input-cccd" name="input-cccd"
                    placeholder="Input ID" value="<?php echo $LicenseTest['SoCCCD']; ?>" />
                </div>
              </div>
              <div class="form-group row mb-3">
                <label for="input-name" class="col-sm-3 col-form-label" data-validate="Ngày Thi">Ngày Thi</label>
                <div class="col-sm-4">
                  <input required type="date" id="input-ngaythi" name="input-ngaythi" class="form-control"
                  min="1900-01-01" max="2023-12-31" value="<?php echo $LicenseTest['NgayThi']->format('Y-m-d'); ?>" />
                </div>
                </div>
                <div class="form-group row mb-3">
                  <label for="input-loaibang" class="col-sm-3 col-form-label"
                    >Loại bằng</label
                  >
                  <div class="col-sm-3">
                    <select class="form-control" id="input-gender" name="input-loaibang">
                      <option value="A1" <?php if ($LicenseTest['LoaiBang']=="A1" ) echo "selected" ; ?>>A1</option>
                      <option value="A2" <?php if ($LicenseTest['LoaiBang']=="A2" ) echo "selected" ; ?>>A2</option>
                      <option value="B1" <?php if ($LicenseTest['LoaiBang']=="B1" ) echo "selected" ; ?>>B1</option>
                      <option value="B2" <?php if ($LicenseTest['LoaiBang']=="B2" ) echo "selected" ; ?>>B2</option>
                      <option value="C" <?php if ($LicenseTest['LoaiBang']=="C" ) echo "selected" ; ?>>C</option>
                      <option value="D" <?php if ($LicenseTest['LoaiBang']=="D" ) echo "selected" ; ?>>D</option>
                      <option value="E" <?php if ($LicenseTest['LoaiBang']=="E" ) echo "selected" ; ?>>E</option>
                      <option value="F" <?php if ($LicenseTest['LoaiBang']=="F" ) echo "selected" ; ?>>F</option>
                    </select>
                  </div>
                </div>
              <div class="form-group row mb-3">
                <label for="input-diemlt" class="col-sm-3 col-form-label" data-validate="Điền điểm">Điểm lý thuyết</label>
                <div class="col-sm-9">
                  <input required type="number" class="form-control" id="input-diemlt" name="input-diemlt"
                    placeholder="Input ID" value="<?php echo $LicenseTest['DiemLyThuyet']; ?>"/>
                </div>
              </div>
              <div class="form-group row mb-3">
                <label for="input-cccd" class="col-sm-3 col-form-label" data-validate="Điền điểm">Điểm thực hành</label>
                <div class="col-sm-9">
                  <input required type="number" class="form-control" id="input-diemth" name="input-diemth"
                    placeholder="Input ID" value="<?php echo $LicenseTest['DiemThucHanh']; ?>"/>
                </div>
              </div>
              <button type="submit" class="btn btn-primary" id="submit-btn" name="submit-btn">
                Submit
              </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"></script>
    <script src="../../script/storage.js"></script>
    <script src="../../script/script.js"></script>
    <script src="../../js/main.js"></script>
</body>

</html>