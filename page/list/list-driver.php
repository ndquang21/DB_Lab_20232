<?php
require '../../db.php';

$limit = 100; // Số lượng mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$searchCCCD = isset($_GET['searchCCCD']) ? $_GET['searchCCCD'] : '';
$searchHoTen = isset($_GET['searchHoTen']) ? $_GET['searchHoTen'] : '';
$searchSDT = isset($_GET['searchSDT']) ? $_GET['searchSDT'] : '';
$searchDiaChi = isset($_GET['searchDiaChi']) ? $_GET['searchDiaChi'] : '';
$searchNgaySinh = isset($_GET['searchNgaySinh']) ? $_GET['searchNgaySinh'] : '';
$searchGioiTinh = isset($_GET['searchGioiTinh']) ? $_GET['searchGioiTinh'] : '';

$sql = "SELECT * FROM NguoiSoHuu WHERE 1=1";
$sqlCount = "SELECT COUNT(*) as total FROM NguoiSoHuu WHERE 1=1";

$params = array();
if (!empty($searchCCCD)) {
    $sql .= " AND SoCCCD LIKE ?";
    $sqlCount .= " AND SoCCCD LIKE ?";
    $params[] = '%' . $searchCCCD . '%';
}
if (!empty($searchHoTen)) {
    $sql .= " AND HoTen LIKE ?";
    $sqlCount .= " AND HoTen LIKE ?";
    $params[] = '%' . $searchHoTen . '%';
}
if (!empty($searchSDT)) {
    $sql .= " AND SoDienThoai LIKE ?";
    $sqlCount .= " AND SoDienThoai LIKE ?";
    $params[] = '%' . $searchSDT . '%';
}
if (!empty($searchDiaChi)) {
    $sql .= " AND DiaChi LIKE ?";
    $sqlCount .= " AND DiaChi LIKE ?";
    $params[] = '%' . $searchDiaChi . '%';
}
if (!empty($searchNgaySinh)) {
    $sql .= " AND CONVERT(VARCHAR, NgaySinh, 105) LIKE ?";
    $sqlCount .= " AND CONVERT(VARCHAR, NgaySinh, 105) LIKE ?";
    $params[] = '%' . $searchNgaySinh . '%';
}
if (!empty($searchGioiTinh)) {
    $sql .= " AND GioiTinh LIKE ?";
    $sqlCount .= " AND GioiTinh LIKE ?";
    $params[] = '%' . $searchGioiTinh . '%';
}

$count_stmt = sqlsrv_query($conn, $sqlCount, $params);
if ($count_stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$count_row = sqlsrv_fetch_array($count_stmt, SQLSRV_FETCH_ASSOC);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);

sqlsrv_free_stmt($count_stmt);

$sql .= " ORDER BY SoCCCD OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
$params[] = $offset;
$params[] = $limit;

$stmt = sqlsrv_query($conn, $sql, $params);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$drivers = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $drivers[] = $row;
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
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
    <div class="wrapper">
        <?php
        require './Sidebar.php';
        ?>
        <!-- Page Content Holder -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="">
                    <a class="navbar-brand" href="#">Drivers</a>
                </div>
            </nav>
            <!--  -->
            <div class="container" id="main" style="max-width: 90%">
                <form method="GET" action="">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">CCCD</th>
                                <th scope="col">Họ và Tên</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Địa chỉ</th>
                                <th scope="col">Ngày sinh</th>
                                <th scope="col">Giới tính</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <th><input type="text" class="form-control" name="searchCCCD" placeholder="CCCD" value="<?= htmlspecialchars($searchCCCD) ?>"></th>
                                <th><input type="text" class="form-control" name="searchHoTen" placeholder="Họ tên" value="<?= htmlspecialchars($searchHoTen) ?>"></th>
                                <th><input type="text" class="form-control" name="searchSDT" placeholder="Điện thoại" value="<?= htmlspecialchars($searchSDT) ?>"></th>
                                <th><input type="text" class="form-control" name="searchDiaChi" placeholder="Địa chỉ" value="<?= htmlspecialchars($searchDiaChi) ?>"></th>
                                <th><input type="text" class="form-control" name="searchNgaySinh" placeholder="Ngày sinh" value="<?= htmlspecialchars($searchNgaySinh) ?>"></th>
                                <th><input type="text" class="form-control" name="searchGioiTinh" placeholder="Giới tính" value="<?= htmlspecialchars($searchGioiTinh) ?>"></th>
                                <th><button type="submit" class="btn btn-primary">Search</button></th>
                            </tr>
                        </thead>
                        <tbody id="driverTable">
                            <?php foreach ($drivers as $driver): ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars($driver['SoCCCD']) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($driver['HoTen']) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($driver['SoDienThoai']) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($driver['DiaChi']) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($driver['NgaySinh']->format('d-m-Y')) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($driver['GioiTinh']) ?>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-delete"
                                        data-cccd="<?= htmlspecialchars($driver['SoCCCD']) ?>">
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
                            <a class="page-link" href="?page=<?= max(1, $page - 1) ?>&searchCCCD=<?= htmlspecialchars($searchCCCD) ?>&searchHoTen=<?= htmlspecialchars($searchHoTen) ?>&searchSDT=<?= htmlspecialchars($searchSDT) ?>&searchDiaChi=<?= htmlspecialchars($searchDiaChi) ?>&searchNgaySinh=<?= htmlspecialchars($searchNgaySinh) ?>&searchGioiTinh=<?= htmlspecialchars($searchGioiTinh) ?>">Previous</a>
                        </li>
                        <li class="page-item">
                            <form class="page-link" method="GET" action="">
                                <input type="hidden" name="searchCCCD" value="<?= htmlspecialchars($searchCCCD) ?>">
                                <input type="hidden" name="searchHoTen" value="<?= htmlspecialchars($searchHoTen) ?>">
                                <input type="hidden" name="searchSDT" value="<?= htmlspecialchars($searchSDT) ?>">
                                <input type="hidden" name="searchDiaChi" value="<?= htmlspecialchars($searchDiaChi) ?>">
                                <input type="hidden" name="searchNgaySinh" value="<?= htmlspecialchars($searchNgaySinh) ?>">
                                <input type="hidden" name="searchGioiTinh" value="<?= htmlspecialchars($searchGioiTinh) ?>">
                                <input type="number" name="page" value="<?= $page ?>" min="1" max="<?= $total_pages ?>" style="width: 60px;">
                                <input type="submit" value="Go">
                            </form>
                        </li>
                        <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>&searchCCCD=<?= htmlspecialchars($searchCCCD) ?>&searchHoTen=<?= htmlspecialchars($searchHoTen) ?>&searchSDT=<?= htmlspecialchars($searchSDT) ?>&searchDiaChi=<?= htmlspecialchars($searchDiaChi) ?>&searchNgaySinh=<?= htmlspecialchars($searchNgaySinh) ?>&searchGioiTinh=<?= htmlspecialchars($searchGioiTinh) ?>">Next</a>
                        </li>
                    </ul>
                    <p>Page <?= $page ?> of <?= $total_pages ?></p>
                </nav>
            </div>
        </div>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script src="../../script/storage.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const SoCCCD = this.dataset.cccd;
                    const confirmed = confirm('Bạn có chắc chắn muốn xóa bản ghi này không?');

                    if (confirmed) {
                        fetch('../delete/delete_driver.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `SoCCCD=${encodeURIComponent(SoCCCD)}`
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