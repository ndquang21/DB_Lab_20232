<?php
require '../../db.php';

$limit = 100; // Số lượng bản ghi mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$searchCCCD = isset($_GET['searchCCCD']) ? $_GET['searchCCCD'] : '';
$searchNgayThi = isset($_GET['searchNgayThi']) ? $_GET['searchNgayThi'] : '';
$searchBang = isset($_GET['searchBang']) ? $_GET['searchBang'] : '';
$searchLT = isset($_GET['searchLT']) ? $_GET['searchLT'] : '';
$searchTH = isset($_GET['searchTH']) ? $_GET['searchTH'] : '';
$searchKQ = isset($_GET['searchKQ']) ? $_GET['searchKQ'] : '';

$sql = "SELECT * FROM LichSuDaoTaoSatHach WHERE 1=1";
$sqlCount = "SELECT COUNT(*) as total FROM LichSuDaoTaoSatHach WHERE 1=1";

$params = array();
if (!empty($searchCCCD)) {
    $sql .= " AND SoCCCD LIKE ?";
    $sqlCount .= " AND SoCCCD LIKE ?";
    $params[] = '%' . $searchCCCD . '%';
}
if (!empty($searchNgayThi)) {
    $sql .= " AND NgayThi = ?";
    $sqlCount .= " AND NgayThi = ?";
    $params[] = $searchNgayThi;
}
if (!empty($searchBang)) {
    $sql .= " AND LoaiBang LIKE ?";
    $sqlCount .= " AND LoaiBang LIKE ?";
    $params[] = '%' . $searchBang . '%';
}
if (!empty($searchLT)) {
    $sql .= " AND DiemLyThuyet = ?";
    $sqlCount .= " AND DiemLyThuyet = ?";
    $params[] = (int)$searchLT;
}
if (!empty($searchTH)) {
    $sql .= " AND DiemThucHanh = ?";
    $sqlCount .= " AND DiemThucHanh = ?";
    $params[] = (int)$searchTH;
}
if (!empty($searchKQ)) {
    $sql .= " AND KetQua LIKE ?";
    $sqlCount .= " AND KetQua LIKE ?";
    $params[] = '%' . $searchKQ . '%';
}

$count_stmt = sqlsrv_query($conn, $sqlCount, $params);
if ($count_stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$count_row = sqlsrv_fetch_array($count_stmt, SQLSRV_FETCH_ASSOC);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);

sqlsrv_free_stmt($count_stmt);

$sql .= " ORDER BY NgayThi DESC OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
$params[] = $offset;
$params[] = $limit;

$stmt = sqlsrv_query($conn, $sql, $params);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$tests = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $tests[] = $row;
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
    <title>Driver License Test History</title>

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
                    <a class="navbar-brand" href="#">Driver License Test</a>
                </div>
            </nav>
            <!--  -->
            <div class="container" id="main" style="max-width: 90%">
                <form method="GET" action="">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">CCCD</th>
                                <th scope="col">Ngày thi</th>
                                <th scope="col">Loại bằng</th>
                                <th scope="col">Điểm lý thuyết</th>
                                <th scope="col">Điểm thực hành</th>
                                <th scope="col">Kết quả</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <th><input type="text" class="form-control" name="searchCCCD" placeholder="CCCD" value="<?= htmlspecialchars($searchCCCD) ?>"></th>
                                <th><input type="date" class="form-control" name="searchNgayThi" placeholder="Ngày thi" value="<?= htmlspecialchars($searchNgayThi) ?>"></th>
                                <th><input type="text" class="form-control" name="searchBang" placeholder="Loại bằng" value="<?= htmlspecialchars($searchBang) ?>"></th>
                                <th><input type="number" class="form-control" name="searchLT" placeholder="Điểm lý thuyết" value="<?= htmlspecialchars($searchLT) ?>"></th>
                                <th><input type="number" class="form-control" name="searchTH" placeholder="Điểm thực hành" value="<?= htmlspecialchars($searchTH) ?>"></th>
                                <th><input type="text" class="form-control" name="searchKQ" placeholder="Kết quả" value="<?= htmlspecialchars($searchKQ) ?>"></th>
                                <th><button type="submit" class="btn btn-primary">Search</button></th>
                            </tr>
                        </thead>
                        <tbody id="driverTable">
                            <?php foreach ($tests as $test): ?>
                            <tr>
                                <td><?= htmlspecialchars($test['SoCCCD']) ?></td>
                                <td><?= htmlspecialchars($test['NgayThi']->format('d-m-Y')) ?></td>
                                <td><?= htmlspecialchars($test['LoaiBang']) ?></td>
                                <td><?= htmlspecialchars($test['DiemLyThuyet']) ?></td>
                                <td><?= htmlspecialchars($test['DiemThucHanh']) ?></td>
                                <td><?= htmlspecialchars($test['KetQua']) ?></td>
                                <td>
                                    <button class="btn btn-danger btn-delete" data-cccd="<?= htmlspecialchars($test['SoCCCD']) ?>" data-loaibang="<?= htmlspecialchars($test['LoaiBang']) ?>">
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
                            <a class="page-link" href="?page=<?= max(1, $page - 1) ?>&searchCCCD=<?= htmlspecialchars($searchCCCD) ?>&searchNgayThi=<?= htmlspecialchars($searchNgayThi) ?>&searchBang=<?= htmlspecialchars($searchBang) ?>&searchLT=<?= htmlspecialchars($searchLT) ?>&searchTH=<?= htmlspecialchars($searchTH) ?>&searchKQ=<?= htmlspecialchars($searchKQ) ?>">Previous</a>
                        </li>
                        <li class="page-item">
                            <form class="page-link" method="GET" action="">
                                <input type="hidden" name="searchCCCD" value="<?= htmlspecialchars($searchCCCD) ?>">
                                <input type="hidden" name="searchNgayThi" value="<?= htmlspecialchars($searchNgayThi) ?>">
                                <input type="hidden" name="searchBang" value="<?= htmlspecialchars($searchBang) ?>">
                                <input type="hidden" name="searchLT" value="<?= htmlspecialchars($searchLT) ?>">
                                <input type="hidden" name="searchTH" value="<?= htmlspecialchars($searchTH) ?>">
                                <input type="hidden" name="searchKQ" value="<?= htmlspecialchars($searchKQ) ?>">
                                <input type="number" name="page" value="<?= $page ?>" min="1" max="<?= $total_pages ?>" style="width: 60px;">
                                <input type="submit" value="Go">
                            </form>
                        </li>
                        <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>&searchCCCD=<?= htmlspecialchars($searchCCCD) ?>&searchNgayThi=<?= htmlspecialchars($searchNgayThi) ?>&searchBang=<?= htmlspecialchars($searchBang) ?>&searchLT=<?= htmlspecialchars($searchLT) ?>&searchTH=<?= htmlspecialchars($searchTH) ?>&searchKQ=<?= htmlspecialchars($searchKQ) ?>">Next</a>
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
                    const LoaiBang = this.dataset.loaibang;
                    const confirmed = confirm('Bạn có chắc chắn muốn xóa bản ghi này không?');

                    if (confirmed) {
                        fetch('../delete/delete_driverLicenseTest.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `SoCCCD=${encodeURIComponent(SoCCCD)}&LoaiBang=${encodeURIComponent(LoaiBang)}`
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
