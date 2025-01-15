<?php
//connect
require '../../db.php';
// connect
if(isset($_POST['submit-btn'])){
    $SoBangLai = $_POST['input-sobanglai'];
}
$select = " SELECT *
            FROM BangLaiXe
            WHERE SoBangLai = ?";
$params = array($SoBangLai);
$stmt = sqlsrv_query($conn, $select, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
if (sqlsrv_has_rows($stmt) === false) {         //kiểm tra trong csdl ko có số bang lai này
    $_SESSION['error'] = "Không tồn tại bằng lái";
    header('location:e-driverLicense.php');
    exit();
}   else{                 //nếu có thì gán giá trị các cột cho các biến để hiển thị trong thuộc tính value
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $_SESSION['OldLicense'] = $SoBangLai;
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
          <a class="navbar-brand" href="e-driverLicense1-chon-sogplx.php">Edit driver License Information</a>
        </div>
      </nav>
      <div class="container" id="main">
        <div class="row justify-content-center align-items-center mt-4">
          <div class="col-lg-6 col-lg-offset-4">
            <form action="e-driverLicense2-sua-thong-tin.php" method="post">
              <div class="form-group row mb-3">
                <label for="input-sobanglai" class="col-sm-3 col-form-label">Số bằng lái</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="input-sobanglai" name="input-sobanglai"
                    placeholder="Input license ID" required value="<?php echo $row['SoBangLai'];?>" />
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="input-noicap" class="col-sm-3 col-form-label">Nơi cấp</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="input-noicap" name="input-noicap" placeholder="Noi cap"
                    value="<?php echo $row['NoiCap']; ?>" required />
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="input-ngaycap" class="col-sm-3 col-form-label">Ngày cấp</label>
                <div class="col-sm-4">
                  <input type="date" class="form-control" id="input-ngaycap" name="input-ngaycap" 
                  min="1900-01-01" max="2123-12-31" value="<?php echo $row['NgayCap']->format('Y-m-d'); ?>" required />
                </div>
              </div>
              <div class="form-group row mb-3">
                <label for="input-ngayhethan" class="col-sm-3 col-form-label">Ngày hết hạn</label>
                <div class="col-sm-4">
                  <input type="date" class="form-control" id="input-ngayhethan" name="input-ngayhethan" 
                  min="1900-01-01" max="2223-12-31" value="<?php echo $row['NgayHetHan']->format('Y-m-d'); ?>" />
                </div>
              </div>
              <div class="form-group row mb-3">
                <label for="input-loaibang" class="col-sm-3 col-form-label">Loại bằng</label>
                <div class="col-sm-3">
                  <select class="form-control" id="input-loaibang" name="input-loaibang">
                    <option value="A1" <?php if ($row['LoaiBang']=="A1" ) echo "selected" ; ?>>A1</option>
                    <option value="A2" <?php if ($row['LoaiBang']=="A2" ) echo "selected" ; ?>>A2</option>
                    <option value="B1" <?php if ($row['LoaiBang']=="B1" ) echo "selected" ; ?>>B1</option>
                    <option value="B2" <?php if ($row['LoaiBang']=="B2" ) echo "selected" ; ?>>B2</option>
                    <option value="C" <?php if ($row['LoaiBang']=="C" ) echo "selected" ; ?>>C</option>
                    <option value="D" <?php if ($row['LoaiBang']=="D" ) echo "selected" ; ?>>D</option>
                    <option value="E" <?php if ($row['LoaiBang']=="E" ) echo "selected" ; ?>>E</option>
                    <option value="F" <?php if ($row['LoaiBang']=="F" ) echo "selected" ; ?>>F</option>
                  </select>
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="input-cccd" class="col-sm-3 col-form-label">Số CCCD</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="input-cccd" name="input-cccd" placeholder="CCCD"
                    value="<?php echo $row['SoCCCD']; ?>" required />
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="input-masodoanhnghiep" class="col-sm-3 col-form-label">Mã số doanh nghiệp</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="input-masodoanhnghiep" name="input-masodoanhnghiep"
                    placeholder="Mã doanh nghiệp" value="<?php echo $row['MaSoDoanhNghiep'];?>" required />
                </div>
              </div>
              <button type="submit" class="btn btn-primary" id="submit-btn" name="submit-btn">
                Submit
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>
  <script src="../../script/storage.js"></script>
  <script src="../../script.js"></script>
</body>

</html>