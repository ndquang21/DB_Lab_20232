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
            <a class="navbar-brand" href="n-driverLicense_html.php">New Driver License</a>
          </div>
        </nav>
        <div class="container" id="main">
          <div class="row justify-content-center align-items-center mt-4">
            <div class="col-lg-6 col-lg-offset-4">
              <form action="n-driverLicense.php" method="post">
                <div class="form-group row mb-3">
                  <label for="input-sobanglai" class="col-sm-3 col-form-label"
                    >Số bằng lái</label
                  >
                  <div class="col-sm-9">
                    <input
                      type="text"
                      class="form-control"
                      id="input-sobanglai"
                      name="input-sobanglai"
                      placeholder="Input license ID"
                      required
                    />
                  </div>
                </div>

                <div class="form-group row mb-3">
                  <label for="input-noicap" class="col-sm-3 col-form-label"
                    >Nơi cấp
                    </label>
                  <div class="col-sm-9">
                    <input
                      type="text"
                      class="form-control"
                      id="input-noicap"
                      name="input-noicap"
                      placeholder="Nhập nơi cấp"
                      required
                    />
                  </div>
                </div>
                
                <div class="form-group row mb-3">
                  <label for="input-ngaycap" class="col-sm-3 col-form-label"
                    >Ngày cấp</label
                  >
                  <div class="col-sm-4">
                    <input
                      type="date"
                      class="form-control"
                      id="input-ngaycap"
                      name="input-ngaycap"
                      min="1900-01-01"
                      max="2124-05-31"
                      required
                    />
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <label for="input-ngayhethan" class="col-sm-3 col-form-label"
                    >Ngày hết hạn</label
                  >
                  <div class="col-sm-4">
                    <input
                      type="date"
                      class="form-control"
                      id="input-ngayhethan"
                      name="input-ngayhethan"
                      min="1900-06-01"
                      max="2224-12-31"
                    />
                  </div>
                </div>
                <div class="form-group row mb-3">
                  <label for="input-loaibang" class="col-sm-3 col-form-label"
                    >Loại bằng</label
                  >
                  <div class="col-sm-3">
                    <select class="form-control" id="input-gender" name="input-loaibang">
                      <option value="" disabled selected hidden>Chọn bằng</option>
                      <option value="A1">A1</option>
                      <option value="A2">A2</option>
                      <option value="B1">B1</option>
                      <option value="B2">B2</option>
                      <option value="C">C</option>
                      <option value="D">D</option>
                      <option value="E">E</option>
                      <option value="F">F</option>
                    </select>
                  </div>
                </div>
                
                <div class="form-group row mb-3">
                  <label for="input-cccd" class="col-sm-3 col-form-label"
                    >Số CCCD</label
                  >
                  <div class="col-sm-9">
                    <input
                      type="text"
                      class="form-control"
                      id="input-cccd"
                      name="input-cccd"
                      placeholder="CCCD"
                      required
                    />
                  </div>
                </div>
                
                <div class="form-group row mb-3">
                  <label for="input-masodoanhnghiep" class="col-sm-3 col-form-label"
                    >Mã số doanh nghiệp</label
                  >
                  <div class="col-sm-9">
                    <input
                      type="text"
                      class="form-control"
                      id="input-masodoanhnghiep"
                      name="input-masodoanhnghiep"
                      placeholder="Mã doanh nghiệp"
                      required
                    />
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
