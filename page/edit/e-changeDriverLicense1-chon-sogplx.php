<?php
//connect
require '../../db.php';
// connect
$SoBangLai = $_POST['input-sobanglai'];
$NgayCapDoi = $_POST['input-ngaycapdoi'];

$select = " SELECT *
            FROM CapDoiBangLai
            WHERE SoBangLai = ? AND NgayCapDoi = ?";
$params = array($SoBangLai, $NgayCapDoi);
$stmt = sqlsrv_query($conn, $select, $params);

if (sqlsrv_has_rows($stmt) === false) {         //kiểm tra trong csdl ko có số bằng lái và ngày đổi này
    $_SESSION['error'] = "Sai bằng lái hoặc ngày cấp đổi";
    header('location:e-changeDriverLicense.php');
    exit();
}   else{                 //nếu có thì gán giá trị các cột cho các biến để hiển thị trong thuộc tính value
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $_SESSION['licenseNum'] = $SoBangLai;
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
          <a class="navbar-brand" href="#">New driver</a>
        </div>
      </nav>
      <div class="container" id="main">
        <div class="row justify-content-center align-items-center mt-4">
          <div class="col-lg-6 col-lg-offset-4">
            <form action="e-changeDriverLicense2-sua-thong-tin.php" method="post">
              <div class="form-group row mb-3">
                <label for="input-sobanglai" class="col-sm-3 col-form-label">Số bằng lái</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="input-sobanglai" name="input-sobanglai"
                    placeholder="Số bằng lái" value="<?php echo $row['SoBangLai']; ?>" required />
                </div>
              </div>
              <div class="form-group row mb-3">
                <label for="input-ngaycapdoi" class="col-sm-3 col-form-label">Ngày cấp đổi</label>
                <div class="col-sm-4">
                  <input type="date" id="input-ngaycapdoi" name="input-ngaycapdoi" class="form-control"
                  min="1900-01-01" max="2223-12-31" value="<?php echo $row['NgayCapDoi']->format('Y-m-d'); ?>" required />
                </div>
              </div>
              <div class="form-group row mb-3">
                <label for="input-lydo" class="col-sm-3 col-form-label">Lí do đổi</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="input-lydo" name="input-lydo" placeholder="Lý do"
                    value="<?php echo $row['LyDoDoi']; ?>" required />
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
  <script src="../../script/script.js"></script>
</body>
</html>