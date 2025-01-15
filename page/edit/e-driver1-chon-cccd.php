<?php
//connect
require '../../db.php';
// connect
if(isset($_POST['submit-btn'])){
    $CCCD = $_POST['input-cccd'];
}
$select = " SELECT * 
            FROM NguoiSoHuu
            WHERE SoCCCD = ?";
$params = array($CCCD);
$stmt = sqlsrv_query($conn, $select, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
if (sqlsrv_has_rows($stmt) === false) {         //kiểm tra trong csdl ko có số cccd này
    $_SESSION['error'] = "Không tồn tại người sở hữu này";
    header('location:e-driver.php');
    exit();
}   else{                 //nếu có thì gán giá trị các cột cho các biến để hiển thị trong thuộc tính value
    $row =  sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $_SESSION['OldCCCD'] = $CCCD;
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
          <a class="navbar-brand" href="e-driver.html">Edit driver</a>
        </div>
      </nav>
      <div class="container" id="main">
        <div class="row justify-content-center align-items-center mt-4">
          <div class="col-lg-6 col-lg-offset-4">

            <form action="e-driver2-sua-thong-tin.php" method="post">
              <div class="form-group row mb-3">
                <label for="input-cccd" class="col-sm-3 col-form-label">CCCD</label>
                <div class="col-sm-9">
                  <input required type="text" class="form-control" id="input-cccd" name="input-cccd"
                    value="<?php echo $row['SoCCCD']; ?>" />
                </div>
              </div>
              <div class="form-group row mb-3">
                <label for="input-hoten" class="col-sm-3 col-form-label">Họ tên</label>
                <div class="col-sm-9">
                  <input required type="text" class="form-control" id="input-hoten" name="input-hoten"
                    value="<?php echo $row['HoTen']; ?>" />
                </div>
              </div>
              <div class="form-group row mb-3">
                <label for="input-sodienthoai" class="col-sm-3 col-form-label">Số điện thoại</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="input-sodienthoai" name="input-sodienthoai"
                    value="<?php echo $row['SoDienThoai']; ?>" />
                </div>
              </div>
              <div class="form-group row mb-3">
                <label for="input-diachi" class="col-sm-3 col-form-label" data-validate="Chọn địa chỉ">Địa chỉ</label>
                <div class="col-sm-9">
                  <select class="form-control" id="input-diachi" name="input-diachi">
                    <option value="An Giang" <?php if ($row['DiaChi']=="An Giang" ) echo "selected" ; ?>>An Giang
                    </option>
                    <option value="Bà Rịa - Vũng Tàu" <?php if ($row['DiaChi']=="Bà Rịa - Vũng Tàu" ) echo "selected" ;
                      ?>>Bà Rịa - Vũng Tàu</option>
                    <option value="Bắc Giang" <?php if ($row['DiaChi']=="Bắc Giang" ) echo "selected" ; ?>>Bắc Giang
                    </option>
                    <option value="Bắc Kạn" <?php if ($row['DiaChi']=="Bắc Kạn" ) echo "selected" ; ?>>Bắc Kạn</option>
                    <option value="Bạc Liêu" <?php if ($row['DiaChi']=="Bạc Liêu" ) echo "selected" ; ?>>Bạc Liêu
                    </option>
                    <option value="Bắc Ninh" <?php if ($row['DiaChi']=="Bắc Ninh" ) echo "selected" ; ?>>Bắc Ninh
                    </option>
                    <option value="Bến Tre" <?php if ($row['DiaChi']=="Bến Tre" ) echo "selected" ; ?>>Bến Tre</option>
                    <option value="Bình Định" <?php if ($row['DiaChi']=="Bình Định" ) echo "selected" ; ?>>Bình Định
                    </option>
                    <option value="Bình Dương" <?php if ($row['DiaChi']=="Bình Dương" ) echo "selected" ; ?>>Bình Dương
                    </option>
                    <option value="Bình Phước" <?php if ($row['DiaChi']=="Bình Phước" ) echo "selected" ; ?>>Bình Phước
                    </option>
                    <option value="Bình Thuận" <?php if ($row['DiaChi']=="Bình Thuận" ) echo "selected" ; ?>>Bình Thuận
                    </option>
                    <option value="Cà Mau" <?php if ($row['DiaChi']=="Cà Mau" ) echo "selected" ; ?>>Cà Mau</option>
                    <option value="Cần Thơ" <?php if ($row['DiaChi']=="Cần Thơ" ) echo "selected" ; ?>>Cần Thơ</option>
                    <option value="Cao Bằng" <?php if ($row['DiaChi']=="Cao Bằng" ) echo "selected" ; ?>>Cao Bằng
                    </option>
                    <option value="Đà Nẵng" <?php if ($row['DiaChi']=="Đà Nẵng" ) echo "selected" ; ?>>Đà Nẵng</option>
                    <option value="Đắk Lắk" <?php if ($row['DiaChi']=="Đắk Lắk" ) echo "selected" ; ?>>Đắk Lắk</option>
                    <option value="Đắk Nông" <?php if ($row['DiaChi']=="Đắk Nông" ) echo "selected" ; ?>>Đắk Nông
                    </option>
                    <option value="Điện Biên" <?php if ($row['DiaChi']=="Điện Biên" ) echo "selected" ; ?>>Điện Biên
                    </option>
                    <option value="Đồng Nai" <?php if ($row['DiaChi']=="Đồng Nai" ) echo "selected" ; ?>>Đồng Nai
                    </option>
                    <option value="Đồng Tháp" <?php if ($row['DiaChi']=="Đồng Tháp" ) echo "selected" ; ?>>Đồng Tháp
                    </option>
                    <option value="Gia Lai" <?php if ($row['DiaChi']=="Gia Lai" ) echo "selected" ; ?>>Gia Lai</option>
                    <option value="Hà Giang" <?php if ($row['DiaChi']=="Hà Giang" ) echo "selected" ; ?>>Hà Giang
                    </option>
                    <option value="Hà Nam" <?php if ($row['DiaChi']=="Hà Nam" ) echo "selected" ; ?>>Hà Nam</option>
                    <option value="Hà Nội" <?php if ($row['DiaChi']=="Hà Nội" ) echo "selected" ; ?>>Hà Nội</option>
                    <option value="Hà Tĩnh" <?php if ($row['DiaChi']=="Hà Tĩnh" ) echo "selected" ; ?>>Hà Tĩnh</option>
                    <option value="Hải Dương" <?php if ($row['DiaChi']=="Hải Dương" ) echo "selected" ; ?>>Hải Dương
                    </option>
                    <option value="Hải Phòng" <?php if ($row['DiaChi']=="Hải Phòng" ) echo "selected" ; ?>>Hải Phòng
                    </option>
                    <option value="Hậu Giang" <?php if ($row['DiaChi']=="Hậu Giang" ) echo "selected" ; ?>>Hậu Giang
                    </option>
                    <option value="Hòa Bình" <?php if ($row['DiaChi']=="Hòa Bình" ) echo "selected" ; ?>>Hòa Bình
                    </option>
                    <option value="Hưng Yên" <?php if ($row['DiaChi']=="Hưng Yên" ) echo "selected" ; ?>>Hưng Yên
                    </option>
                    <option value="Khánh Hòa" <?php if ($row['DiaChi']=="Khánh Hòa" ) echo "selected" ; ?>>Khánh Hòa
                    </option>
                    <option value="Kiên Giang" <?php if ($row['DiaChi']=="Kiên Giang" ) echo "selected" ; ?>>Kiên Giang
                    </option>
                    <option value="Kon Tum" <?php if ($row['DiaChi']=="Kon Tum" ) echo "selected" ; ?>>Kon Tum</option>
                    <option value="Lai Châu" <?php if ($row['DiaChi']=="Lai Châu" ) echo "selected" ; ?>>Lai Châu
                    </option>
                    <option value="Lâm Đồng" <?php if ($row['DiaChi']=="Lâm Đồng" ) echo "selected" ; ?>>Lâm Đồng
                    </option>
                    <option value="Lạng Sơn" <?php if ($row['DiaChi']=="Lạng Sơn" ) echo "selected" ; ?>>Lạng Sơn
                    </option>
                    <option value="Lào Cai" <?php if ($row['DiaChi']=="Lào Cai" ) echo "selected" ; ?>>Lào Cai</option>
                    <option value="Long An" <?php if ($row['DiaChi']=="Long An" ) echo "selected" ; ?>>Long An</option>
                    <option value="Nam Định" <?php if ($row['DiaChi']=="Nam Định" ) echo "selected" ; ?>>Nam Định
                    </option>
                    <option value="Nghệ An" <?php if ($row['DiaChi']=="Nghệ An" ) echo "selected" ; ?>>Nghệ An</option>
                    <option value="Ninh Bình" <?php if ($row['DiaChi']=="Ninh Bình" ) echo "selected" ; ?>>Ninh Bình
                    </option>
                    <option value="Ninh Thuận" <?php if ($row['DiaChi']=="Ninh Thuận" ) echo "selected" ; ?>>Ninh Thuận
                    </option>
                    <option value="Phú Thọ" <?php if ($row['DiaChi']=="Phú Thọ" ) echo "selected" ; ?>>Phú Thọ</option>
                    <option value="Phú Yên" <?php if ($row['DiaChi']=="Phú Yên" ) echo "selected" ; ?>>Phú Yên</option>
                    <option value="Quảng Bình" <?php if ($row['DiaChi']=="Quảng Bình" ) echo "selected" ; ?>>Quảng Bình
                    </option>
                    <option value="Quảng Nam" <?php if ($row['DiaChi']=="Quảng Nam" ) echo "selected" ; ?>>Quảng Nam
                    </option>
                    <option value="Quảng Ngãi" <?php if ($row['DiaChi']=="Quảng Ngãi" ) echo "selected" ; ?>>Quảng Ngãi
                    </option>
                    <option value="Quảng Ninh" <?php if ($row['DiaChi']=="Quảng Ninh" ) echo "selected" ; ?>>Quảng Ninh
                    </option>
                    <option value="Quảng Trị" <?php if ($row['DiaChi']=="Quảng Trị" ) echo "selected" ; ?>>Quảng Trị
                    </option>
                    <option value="Sóc Trăng" <?php if ($row['DiaChi']=="Sóc Trăng" ) echo "selected" ; ?>>Sóc Trăng
                    </option>
                    <option value="Sơn La" <?php if ($row['DiaChi']=="Sơn La" ) echo "selected" ; ?>>Sơn La</option>
                    <option value="Tây Ninh" <?php if ($row['DiaChi']=="Tây Ninh" ) echo "selected" ; ?>>Tây Ninh
                    </option>
                    <option value="Thái Bình" <?php if ($row['DiaChi']=="Thái Bình" ) echo "selected" ; ?>>Thái Bình
                    </option>
                    <option value="Thái Nguyên" <?php if ($row['DiaChi']=="Thái Nguyên" ) echo "selected" ; ?>>Thái
                      Nguyên</option>
                    <option value="Thanh Hóa" <?php if ($row['DiaChi']=="Thanh Hóa" ) echo "selected" ; ?>>Thanh Hóa
                    </option>
                    <option value="Thừa Thiên Huế" <?php if ($row['DiaChi']=="Thừa Thiên Huế" ) echo "selected" ; ?>
                      >Thừa Thiên Huế</option>
                    <option value="Tiền Giang" <?php if ($row['DiaChi']=="Tiền Giang" ) echo "selected" ; ?>>Tiền Giang
                    </option>
                    <option value="TP. Hồ Chí Minh" <?php if ($row['DiaChi']=="TP. Hồ Chí Minh" ) echo "selected" ; ?>
                      >TP. Hồ Chí Minh</option>
                    <option value="Trà Vinh" <?php if ($row['DiaChi']=="Trà Vinh" ) echo "selected" ; ?>>Trà Vinh
                    </option>
                    <option value="Tuyên Quang" <?php if ($row['DiaChi']=="Tuyên Quang" ) echo "selected" ; ?>>Tuyên
                      Quang</option>
                    <option value="Vĩnh Long" <?php if ($row['DiaChi']=="Vĩnh Long" ) echo "selected" ; ?>>Vĩnh Long
                    </option>
                    <option value="Vĩnh Phúc" <?php if ($row['DiaChi']=="Vĩnh Phúc" ) echo "selected" ; ?>>Vĩnh Phúc
                    </option>
                    <option value="Yên Bái" <?php if ($row['DiaChi']=="Yên Bái" ) echo "selected" ; ?>>Yên Bái</option>
                  </select>
                </div>
              </div>

              <div class="form-group row mb-3" data-validate="Nhập ngày sinh">
                <label for="input-ngaysinh" class="col-sm-3 col-form-label">Ngày sinh</label>
                <div class="col-sm-4">
                  <input value="<?php echo $row['NgaySinh']->format('Y-m-d'); ?>" required type="date"
                    id="input-ngaysinh" name="input-ngaysinh" min="1900-01-01" max="2023-12-31" class="form-control" />
                </div>
                <label for="input-gioitinh" class="col-sm-2 col-form-label" style="text-align: right">Giới tính</label>
                <div class="col-sm-3">
                  <select class="form-control" id="input-gioitinh" name="input-gioitinh"
                    value="<?php echo $row['GioiTinh']; ?>">
                    <option value="Nam" <?php if ($row['GioiTinh']=="Nam" ) echo "selected"; ?>>Nam</option>
                    <option value="Nữ" <?php if ($row['GioiTinh']=="Nữ" ) echo "selected"; ?>>Nữ</option>
                  </select>
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