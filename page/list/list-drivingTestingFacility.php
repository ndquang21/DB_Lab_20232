<?php
require '../../db.php';

$limit = 100; // Số lượng bản ghi mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$searchMSDN = isset($_GET['searchMSDN']) ? $_GET['searchMSDN'] : '';
$searchName = isset($_GET['searchName']) ? $_GET['searchName'] : '';
$searchAddress = isset($_GET['searchAddress']) ? $_GET['searchAddress'] : '';
$searchDanhGia = isset($_GET['searchDanhGia']) ? $_GET['searchDanhGia'] : '';

$sql = "SELECT * FROM CoSoDaoTaoCapBang WHERE 1=1";
$sqlCount = "SELECT COUNT(*) as total FROM CoSoDaoTaoCapBang WHERE 1=1";

$params = array();
if (!empty($searchMSDN)) {
    $sql .= " AND MaSoDoanhNghiep LIKE ?";
    $sqlCount .= " AND MaSoDoanhNghiep LIKE ?";
    $params[] = '%' . $searchMSDN . '%';
}
if (!empty($searchName)) {
    $sql .= " AND TenCoSo LIKE ?";
    $sqlCount .= " AND TenCoSo LIKE ?";
    $params[] = '%' . $searchName . '%';
}
if (!empty($searchAddress)) {
    $sql .= " AND DiaChi LIKE ?";
    $sqlCount .= " AND DiaChi LIKE ?";
    $params[] = '%' . $searchAddress . '%';
}
if (!empty($searchDanhGia)) {
    $sql .= " AND DanhGia LIKE ?";
    $sqlCount .= " AND DanhGia LIKE ?";
    $params[] = '%' . $searchDanhGia . '%';
}

$count_stmt = sqlsrv_query($conn, $sqlCount, $params);
if ($count_stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$count_row = sqlsrv_fetch_array($count_stmt, SQLSRV_FETCH_ASSOC);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);

sqlsrv_free_stmt($count_stmt);

$sql .= " ORDER BY MaSoDoanhNghiep OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
$params[] = $offset;
$params[] = $limit;

$stmt = sqlsrv_query($conn, $sql, $params);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$facilities = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $facilities[] = $row;
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Driving testing facility</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" />
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
  <div class="wrapper">
    <?php
    require './Sidebar.php';
    ?>
    <!-- Page Content Holder -->
    <div id="content">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="">
          <a class="navbar-brand" href="list-drivingTestingFacility.php">Driving testing facility</a>
        </div>
      </nav>
      <!--  -->
      <div class="container" id="main" style="max-width: 90%">
        <form method="GET" action="">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Mã doanh nghiệp</th>
                <th scope="col">Tên cơ sở</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Đánh giá</th>
                <th scope="col">Action</th>
              </tr>
              <tr>
                <th><input type="text" class="form-control" name="searchMSDN" placeholder="Mã doanh nghiệp" value="<?= htmlspecialchars($searchMSDN) ?>"></th>
                <th><input type="text" class="form-control" name="searchName" placeholder="Tên" value="<?= htmlspecialchars($searchName) ?>"></th>
                <th><input type="text" class="form-control" name="searchAddress" placeholder="Địa chỉ" value="<?= htmlspecialchars($searchAddress) ?>"></th>
                <th><input type="text" class="form-control" name="searchDanhGia" placeholder="Đánh giá" value="<?= htmlspecialchars($searchDanhGia) ?>"></th>
                <th><button type="submit" class="btn btn-primary">Search</button></th>
              </tr>
            </thead>
            <tbody id="driverTable">
              <?php foreach ($facilities as $facility): ?>
              <tr>
                <td>
                  <?= htmlspecialchars($facility['MaSoDoanhNghiep']) ?>
                </td>
                <td>
                  <?= htmlspecialchars($facility['TenCoSo']) ?>
                </td>
                <td>
                  <?= htmlspecialchars($facility['DiaChi']) ?>
                </td>
                <td>
                  <?= htmlspecialchars($facility['DanhGia']) ?>
                </td>
                <td>
                <button class="btn btn-danger btn-delete" data-so-dn="<?= htmlspecialchars($facility['MaSoDoanhNghiep']) ?>">
                  Xóa
                </button>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </form>

        <!-- Phân trang -->
        <nav aria-label="Page navigation">
          <ul class="pagination">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
              <a class="page-link" href="?page=<?= max(1, $page - 1) ?>&searchMSDN=<?= htmlspecialchars($searchMSDN) ?>&searchName=<?= htmlspecialchars($searchName) ?>&searchAddress=<?= htmlspecialchars($searchAddress) ?>&searchDanhGia=<?= htmlspecialchars($searchDanhGia) ?>">Previous</a>
            </li>
            <li class="page-item">
              <form class="page-link" method="GET" action="">
                <input type="hidden" name="searchMSDN" value="<?= htmlspecialchars($searchMSDN) ?>">
                <input type="hidden" name="searchName" value="<?= htmlspecialchars($searchName) ?>">
                <input type="hidden" name="searchAddress" value="<?= htmlspecialchars($searchAddress) ?>">
                <input type="hidden" name="searchDanhGia" value="<?= htmlspecialchars($searchDanhGia) ?>">
                <input type="number" name="page" value="<?= $page ?>" min="1" max="<?= $total_pages ?>" style="width: 60px;">
                <input type="submit" value="Go">
              </form>
            </li>
            <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
              <a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>&searchMSDN=<?= htmlspecialchars($searchMSDN) ?>&searchName=<?= htmlspecialchars($searchName) ?>&searchAddress=<?= htmlspecialchars($searchAddress) ?>&searchDanhGia=<?= htmlspecialchars($searchDanhGia) ?>">Next</a>
            </li>
          </ul>
          <p>Page <?= $page ?> of <?= $total_pages ?></p>
        </nav>
      </div>
    </div>
  </div>
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../script/storage.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const deleteButtons = document.querySelectorAll('.btn-delete');

      deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
          const MaSoDoanhNghiep = this.dataset.soDn;
          const confirmed = confirm('Bạn có chắc chắn muốn xóa bản ghi này không?');

          if (confirmed) {
            fetch('../delete/delete_drivingTestingFacility.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              },
              body: `MaSoDoanhNghiep=${encodeURIComponent(MaSoDoanhNghiep)}`
            })
              .then(response => response.text())
              .then(data => {
                if (data === 'success') {
                  // Xóa hàng khỏi bảng
                  this.closest('tr').remove();
                } else {
                  alert('Đã xảy ra lỗi khi xóa bản ghi.');
                }
              })
              .catch(error => console.error('Error:', error));
          }
        });
      });
    });
  </script>
</body>
</html>
