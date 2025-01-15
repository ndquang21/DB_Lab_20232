<?php
//connect
require '../../db.php';
// connect

$MaSoDoanhNghiep = $_POST['input-masodoanhnghiep'];

$select = " SELECT * 
            FROM CoSoDaoTaoCapBang
            WHERE MaSoDoanhNghiep = ?";
$params = array($MaSoDoanhNghiep);
$stmt = sqlsrv_query($conn, $select, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
if (sqlsrv_has_rows($stmt) === false) {         //kiểm tra trong csdl ko có ma doanh nghiep này
    $_SESSION['error'] = "Không tồn tại doanh nghiệp";
    header('location:e-drivingTestingFacility.php');
    exit();
}   else{                 //nếu có thì gán giá trị các cột cho các biến để hiển thị trong thuộc tính value
    $row =  sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if($row){
        $TenCoSo = $row['TenCoSo'];
        $DiaChi = $row['DiaChi'];
        $_SESSION['OldDN'] = $MaSoDoanhNghiep;
    }
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
          <a class="navbar-brand" href="#">Edit driving testing facility</a>
        </div>
      </nav>
      <div class="container" id="main">
        <div class="row justify-content-center align-items-center mt-4">
          <div class="col-lg-6 col-lg-offset-6">
            <form action="e-drivingTestingFacility2-sua-thong-tin.php" method="post">
              <div class="form-group row mb-3">
                <label for="input-masodoanhnghiep" class="col-sm-3 col-form-label">Mã Doanh nghiệp</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="input-masodoanhnghiep" name="input-masodoanhnghiep"
                    placeholder="Business Code" value="<?php echo $MaSoDoanhNghiep; ?>" required />
                </div>
              </div>
              <div class="form-group row mb-3">
                <label for="input-tencoso" class="col-sm-3 col-form-label">Tên cơ sở</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="input-tencoso" name="input-tencoso"
                    placeholder="Tên cơ sở" value="<?php echo $TenCoSo; ?>" required />
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="input-diachi" class="col-sm-3 col-form-label">Địa chỉ</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="input-diachi" name="input-diachi" placeholder="Địa chỉ"
                    value="<?php echo $DiaChi; ?>" required />
                </div>
              </div>

              <div class="form-group row mb-3">
                <label for="input-danhgia" class="col-sm-3 col-form-label">Đánh giá</label>
                <div class="col-sm-9">
                  <select class="form-control" id="input-danhgia" name="input-danhgia">
                    <option value="Tốt" <?php if ($row['DanhGia']=="Tốt" ) echo "selected" ; ?>>Tốt</option>
                    <option value="Khá" <?php if ($row['DanhGia']=="Khá" ) echo "selected" ; ?>>Khá</option>
                    <option value="Trung bình" <?php if ($row['DanhGia']=="Trung bình" ) echo "selected" ; ?>>Trung bình</option>
                  </select>
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

  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>
  <script src="../../script/storage.js"></script>
  <script src="../../script.js"></script>
</body>

</html>