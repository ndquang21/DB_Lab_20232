<?php
require '../../db.php';

$limit = 100; // Số lượng mỗi page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$searchSoGPLX = isset($_GET['searchGPLX']) ? $_GET['searchGPLX'] : '';
$searchNgayCap = isset($_GET['searchNgayCap']) ? $_GET['searchNgayCap'] : '';
$searchLyDo = isset($_GET['searchLyDo']) ? $_GET['searchLyDo'] : '';

$sql = "SELECT SoBangLai, NgayCapDoi, LyDoDoi FROM CapDoiBangLai WHERE 1=1";
$sqlCount = "SELECT COUNT(*) as total FROM CapDoiBangLai WHERE 1=1";

$params = array();
if (!empty($searchSoGPLX)) {
    $sql .= " AND SoBangLai LIKE ?";
    $sqlCount .= " AND SoBangLai LIKE ?";
    $params[] = '%' . $searchSoGPLX . '%';
}
if (!empty($searchNgayCap)) {
    $sql .= " AND CONVERT(VARCHAR, NgayCapDoi, 105) LIKE ?";
    $sqlCount .= " AND CONVERT(VARCHAR, NgayCapDoi, 105) LIKE ?";
    $params[] = '%' . $searchNgayCap . '%';
}
if (!empty($searchLyDo)) {
    $sql .= " AND LyDoDoi LIKE ?";
    $sqlCount .= " AND LyDoDoi LIKE ?";
    $params[] = '%' . $searchLyDo . '%';
}

// Truy vấn tổng số bản ghi
$count_stmt = sqlsrv_query($conn, $sqlCount, $params);
if ($count_stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$count_row = sqlsrv_fetch_array($count_stmt, SQLSRV_FETCH_ASSOC);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);

sqlsrv_free_stmt($count_stmt);

// Thêm phân trang
$sql .= " ORDER BY SoBangLai OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
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
    <title>Change Driver Licence</title>
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
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="">
                    <a class="navbar-brand" href="#">Change Driver Licence</a>
                </div>
            </nav>
            <div class="container" id="main" style="max-width: 90%">
                <form method="GET" action="">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Số GPLX</th>
                                <th scope="col">Ngày cấp đổi</th>
                                <th scope="col">Lí do thay đổi</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <th><input type="text" class="form-control" name="searchGPLX" placeholder="Số GPLX" value="<?= htmlspecialchars($searchSoGPLX) ?>"></th>
                                <th><input type="text" class="form-control" name="searchNgayCap" placeholder="Ngày đổi" value="<?= htmlspecialchars($searchNgayCap) ?>"></th>
                                <th><input type="text" class="form-control" name="searchLyDo" placeholder="Lý do" value="<?= htmlspecialchars($searchLyDo) ?>"></th>
                                <th><button type="submit" class="btn btn-primary">Search</button></th>
                            </tr>
                        </thead>
                        <tbody id="driverTable">
                            <?php foreach ($drivers as $driver): ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars($driver['SoBangLai']) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($driver['NgayCapDoi']->format('d-m-Y')) ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($driver['LyDoDoi']) ?>
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-delete"
                                        data-so-bang-lai="<?= htmlspecialchars($driver['SoBangLai']) ?>"
                                        data-ngay-cap-doi="<?= htmlspecialchars($driver['NgayCapDoi']->format('Y-m-d')) ?>">
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
                            <a class="page-link" href="?page=<?= max(1, $page - 1) ?>&searchGPLX=<?= htmlspecialchars($searchSoGPLX) ?>&searchNgayCap=<?= htmlspecialchars($searchNgayCap) ?>&searchLyDo=<?= htmlspecialchars($searchLyDo) ?>">Previous</a>
                        </li>
                        <li class="page-item">
                            <form class="page-link" method="GET" action="">
                                <input type="hidden" name="searchGPLX" value="<?= htmlspecialchars($searchSoGPLX) ?>">
                                <input type="hidden" name="searchNgayCap" value="<?= htmlspecialchars($searchNgayCap) ?>">
                                <input type="hidden" name="searchLyDo" value="<?= htmlspecialchars($searchLyDo) ?>">
                                <input type="number" name="page" value="<?= $page ?>" min="1" max="<?= $total_pages ?>" style="width: 60px;">
                                <input type="submit" value="Go">
                            </form>
                        </li>
                        <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>&searchGPLX=<?= htmlspecialchars($searchSoGPLX) ?>&searchNgayCap=<?= htmlspecialchars($searchNgayCap) ?>&searchLyDo=<?= htmlspecialchars($searchLyDo) ?>">Next</a>
                        </li>
                    </ul>
                    <p>Page <?= $page ?> of <?= $total_pages ?></p>
                </nav>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../script/storage.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const SoBangLai = this.dataset.soBangLai;
                    const NgayCapDoi = this.dataset.ngayCapDoi;
                    const confirmed = confirm('Bạn có chắc chắn muốn xóa bản ghi này không?');

                    if (confirmed) {
                        fetch('../delete/delete_changeDriverLicense.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `SoBangLai=${encodeURIComponent(SoBangLai)}&NgayCapDoi=${encodeURIComponent(NgayCapDoi)}`
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
