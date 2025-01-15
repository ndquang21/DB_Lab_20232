<?php
  session_start();
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
  <?php
    require './sidebar.php'
  ?>
      <!-- Page Content Holder -->
      <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
            <a class="navbar-brand" href="n-driver_html.php">New driver</a>
          </div>
        </nav>
        <div class="container" id="main">
          <div class="row justify-content-center align-items-center mt-4">
            <div class="col-lg-6 col-lg-offset-6">
              <form action="n-driver.php" method="post">
                <div class="form-group row mb-3" data-validate = "Nhập CCCD">
                  <label for="input-cccd" class="col-sm-3 col-form-label"
                    >CCCD</label
                  >
                  <div class="col-sm-9">
                    <input
                      required
                      type="text"
                      class="form-control"
                      id="input-cccd"
                      name="input-cccd"
                      placeholder="Input ID"
                    />
                  </div>
                </div>
                <div class="form-group row mb-3" data-validate = "Nhập họ tên">
                  <label for="input-name" class="col-sm-3 col-form-label"
                    >Họ và Tên</label
                  >
                  <div class="col-sm-9">
                    <input
                      required
                      type="text"
                      class="form-control"
                      id="input-name"
                      name="input-name"
                      placeholder="Input Full Name"
                    >
                  </div>
                </div>
                <div class="form-group row mb-3" data-validate = "Nhập số điện thoại">
                  <label for="input-phonenumber" class="col-sm-3 col-form-label"
                    >Số điện thoại</label
                  >
                  <div class="col-sm-9">
                    <input
                      type="tel"
                      class="form-control"
                      id="input-phonenumber"
                      name="input-phonenumber"
                      placeholder="Input Phone Number"
                    />
                  </div>
                </div>
                <div class="form-group row mb-3" data-validate = "Nhập ngày sinh">
                  <label for="input-birthday" class="col-sm-3 col-form-label"
                    >Ngày sinh</label
                  >
                  <div class="col-sm-4">
                      <input
                        required
                        type="date"
                        class="form-control"
                        id="input-birthday"
                        name="input-birthday"
                        min="1900-01-01"
                        max="2023-12-31"
                      />                   
                  </div>
                  <label
                    for="input-gender"
                    class="col-sm-2 col-form-label"
                    style="text-align: right"
                    >Giới tính</label
                  >
                  <div class="col-sm-3">
                    <select class="form-control" id="input-gender" name="input-gender" required>
                      <option value="selectsex">Select Gender</option>
                      <option value="Nam">Nam</option>
                      <option value="Nữ">Nữ</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <label for="input-address" class="col-sm-3 col-form-label" data-validate = "Chọn địa chỉ"
                    >Địa chỉ</label
                  >
                  <div class="col-sm-9">
                    <select class="form-control" id="input-address" name="input-address" required>
                      <option disabled hidden selected value="">Chọn tỉnh</option>
                      <option value="An Giang">An Giang</option>
                      <option value="Bà Rịa - Vũng Tàu">Bà Rịa - Vũng Tàu</option>
                      <option value="Bắc Giang">Bắc Giang</option>
                      <option value="Bắc Kạn">Bắc Kạn</option>
                      <option value="Bạc Liêu">Bạc Liêu</option>
                      <option value="Bắc Ninh">Bắc Ninh</option>
                      <option value="Bến Tre">Bến Tre</option>
                      <option value="Bình Định">Bình Định</option>
                      <option value="Bình Dương">Bình Dương</option>
                      <option value="Bình Phước">Bình Phước</option>
                      <option value="Bình Thuận">Bình Thuận</option>
                      <option value="Cà Mau">Cà Mau</option>
                      <option value="Cần Thơ">Cần Thơ</option>
                      <option value="Cao Bằng">Cao Bằng</option>
                      <option value="Đà Nẵng">Đà Nẵng</option>
                      <option value="Đắk Lắk">Đắk Lắk</option>
                      <option value="Đắk Nông">Đắk Nông</option>
                      <option value="Điện Biên">Điện Biên</option>
                      <option value="Đồng Nai">Đồng Nai</option>
                      <option value="Đồng Tháp">Đồng Tháp</option>
                      <option value="Gia Lai">Gia Lai</option>
                      <option value="Hà Giang">Hà Giang</option>
                      <option value="Hà Nam">Hà Nam</option>
                      <option value="Hà Nội">Hà Nội</option>
                      <option value="Hà Tĩnh">Hà Tĩnh</option>
                      <option value="Hải Dương">Hải Dương</option>
                      <option value="Hải Phòng">Hải Phòng</option>
                      <option value="Hậu Giang">Hậu Giang</option>
                      <option value="Hòa Bình">Hòa Bình</option>
                      <option value="Hưng Yên">Hưng Yên</option>
                      <option value="Khánh Hòa">Khánh Hòa</option>
                      <option value="Kiên Giang">Kiên Giang</option>
                      <option value="Kon Tum">Kon Tum</option>
                      <option value="Lai Châu">Lai Châu</option>
                      <option value="Lâm Đồng">Lâm Đồng</option>
                      <option value="Lạng Sơn">Lạng Sơn</option>
                      <option value="Lào Cai">Lào Cai</option>
                      <option value="Long An">Long An</option>
                      <option value="Nam Định">Nam Định</option>
                      <option value="Nghệ An">Nghệ An</option>
                      <option value="Ninh Bình">Ninh Bình</option>
                      <option value="Ninh Thuận">Ninh Thuận</option>
                      <option value="Phú Thọ">Phú Thọ</option>
                      <option value="Phú Yên">Phú Yên</option>
                      <option value="Quảng Bình">Quảng Bình</option>
                      <option value="Quảng Nam">Quảng Nam</option>
                      <option value="Quảng Ngãi">Quảng Ngãi</option>
                      <option value="Quảng Ninh">Quảng Ninh</option>
                      <option value="Quảng Trị">Quảng Trị</option>
                      <option value="Sóc Trăng">Sóc Trăng</option>
                      <option value="Sơn La">Sơn La</option>
                      <option value="Tây Ninh">Tây Ninh</option>
                      <option value="Thái Bình">Thái Bình</option>
                      <option value="Thái Nguyên">Thái Nguyên</option>
                      <option value="Thanh Hóa">Thanh Hóa</option>
                      <option value="Thừa Thiên Huế">Thừa Thiên Huế</option>
                      <option value="Tiền Giang">Tiền Giang</option>
                      <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option>
                      <option value="Trà Vinh">Trà Vinh</option>
                      <option value="Tuyên Quang">Tuyên Quang</option>
                      <option value="Vĩnh Long">Vĩnh Long</option>
                      <option value="Vĩnh Phúc">Vĩnh Phúc</option>
                      <option value="Yên Bái">Yên Bái</option>
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
    <script src="../../script/script.js"></script>
    <script src="../../js/main.js"></script>
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
