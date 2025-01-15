<?php
require '../../db.php';

$limit = 100; // Số lượng bản ghi mỗi trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$searchGPLX = isset($_GET['searchGPLX']) ? $_GET['searchGPLX'] : '';
$searchNgayCap = isset($_GET['searchNgayCap']) ? $_GET['searchNgayCap'] : '';
$searchNoiCap = isset($_GET['searchNoiCap']) ? $_GET['searchNoiCap'] : '';
$searchHanDung = isset($_GET['searchHanDung']) ? $_GET['searchHanDung'] : '';
$searchBang = isset($_GET['searchBang']) ? $_GET['searchBang'] : '';
$searchSoCCCD = isset($_GET['searchSoCCCD']) ? $_GET['searchSoCCCD'] : '';
$searchMSDN = isset($_GET['searchMSDN']) ? $_GET['searchMSDN'] : '';

$sql = "SELECT * FROM BangLaiXe WHERE 1=1";
$sqlCount = "SELECT COUNT(*) as total FROM BangLaiXe WHERE 1=1";

$params = array();
if (!empty($searchGPLX)) {
    $sql .= " AND SoBangLai LIKE ?";
    $sqlCount .= " AND SoBangLai LIKE ?";
    $params[] = '%' . $searchGPLX . '%';
}
if (!empty($searchNgayCap)) {
    $sql .= " AND CONVERT(VARCHAR, NgayCap, 23) LIKE ?";
    $sqlCount .= " AND CONVERT(VARCHAR, NgayCap, 23) LIKE ?";
    $params[] = '%' . $searchNgayCap . '%';
}
if (!empty($searchNoiCap)) {
    $sql .= " AND NoiCap LIKE ?";
    $sqlCount .= " AND NoiCap LIKE ?";
    $params[] = '%' . $searchNoiCap . '%';
}
if (!empty($searchHanDung)) {
    $sql .= " AND CONVERT(VARCHAR, NgayHetHan, 23) LIKE ?";
    $sqlCount .= " AND CONVERT(VARCHAR, NgayHetHan, 23) LIKE ?";
    $params[] = '%' . $searchHanDung . '%';
}
if (!empty($searchBang)) {
    $sql .= " AND LoaiBang LIKE ?";
    $sqlCount .= " AND LoaiBang LIKE ?";
    $params[] = '%' . $searchBang . '%';
}
if (!empty($searchSoCCCD)) {
    $sql .= " AND SoCCCD LIKE ?";
    $sqlCount .= " AND SoCCCD LIKE ?";
    $params[] = '%' . $searchSoCCCD . '%';
}
if (!empty($searchMSDN)) {
    $sql .= " AND MaSoDoanhNghiep LIKE ?";
    $sqlCount .= " AND MaSoDoanhNghiep LIKE ?";
    $params[] = '%' . $searchMSDN . '%';
}

$count_stmt = sqlsrv_query($conn, $sqlCount, $params);
if ($count_stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$count_row = sqlsrv_fetch_array($count_stmt, SQLSRV_FETCH_ASSOC);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);

sqlsrv_free_stmt($count_stmt);

$sql .= " ORDER BY SoBangLai OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";
$params[] = $offset;
$params[] = $limit;

$stmt = sqlsrv_query($conn, $sql, $params);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$licenses = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $licenses[] = $row;
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
                    <a class="navbar-brand" href="list-driverLicense">Driver's License</a>
                </div>
            </nav>
            <!--  -->
            <div class="container" id="main" style="max-width: 90%">
                <form method="GET" action="">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Số GPLX</th>
                                <th scope="col">Ngày cấp</th>
                                <th scope="col">Nơi cấp</th>
                                <th scope="col">Hạn dùng</th>
                                <th scope="col">Loại bằng</th>
                                <th scope="col">Số CCCD</th>
                                <th scope="col">Mã doanh nghiệp</th>
                                <th scope="col">Action</th>
                            </tr>
                            <tr>
                                <th><input type="text" class="form-control" name="searchGPLX" placeholder="Số GPLX" value="<?= htmlspecialchars($searchGPLX) ?>"></th>
                                <th><input type="text" class="form-control" name="searchNgayCap" placeholder="Ngày cấp" value="<?= htmlspecialchars($searchNgayCap) ?>"></th>
                                <th><input type="text" class="form-control" name="searchNoiCap" placeholder="Nơi cấp" value="<?= htmlspecialchars($searchNoiCap) ?>"></th>
                                <th><input type="text" class="form-control" name="searchHanDung" placeholder="Hạn dùng" value="<?= htmlspecialchars($searchHanDung) ?>"></th>
                                <th><input type="text" class="form-control" name="searchBang" placeholder="Loại bằng" value="<?= htmlspecialchars($searchBang) ?>"></th>
                                <th><input type="text" class="form-control" name="searchSoCCCD" placeholder="Số CCCD" value="<?= htmlspecialchars($searchSoCCCD) ?>"></th>
                                <th><input type="text" class="form-control" name="searchMSDN" placeholder="Mã doanh nghiệp" value="<?= htmlspecialchars($searchMSDN) ?>"></th>
                                <th><button type="submit" class="btn btn-primary">Search</button></th>
                            </tr>
                        </thead>
                        <tbody id="driverTable">
                            <?php foreach ($licenses as $license): ?>
                            <tr>
                                <td><?= htmlspecialchars($license['SoBangLai']) ?></td>
                                <td><?= htmlspecialchars($license['NgayCap']->format('Y-m-d')) ?></td>
                                <td><?= htmlspecialchars($license['NoiCap']) ?></td>
                                <td><?= htmlspecialchars($license['NgayHetHan']->format('Y-m-d')) ?></td>
                                <td><?= htmlspecialchars($license['LoaiBang']) ?></td>
                                <td><?= htmlspecialchars($license['SoCCCD']) ?></td>
                                <td><?= htmlspecialchars($license['MaSoDoanhNghiep']) ?></td>
                                <td>
                                    <button class="btn btn-danger btn-delete"
                                        data-so-bang-lai="<?= htmlspecialchars($license['SoBangLai']) ?>">Xóa</button>
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
                            <a class="page-link" href="?page=<?= max(1, $page - 1) ?>&searchGPLX=<?= htmlspecialchars($searchGPLX) ?>&searchNgayCap=<?= htmlspecialchars($searchNgayCap) ?>&searchNoiCap=<?= htmlspecialchars($searchNoiCap) ?>&searchHanDung=<?= htmlspecialchars($searchHanDung) ?>&searchBang=<?= htmlspecialchars($searchBang) ?>&searchSoCCCD=<?= htmlspecialchars($searchSoCCCD) ?>&searchMSDN=<?= htmlspecialchars($searchMSDN) ?>">Previous</a>
                        </li>
                        <li class="page-item">
                            <form class="page-link" method="GET" action="">
                                <input type="hidden" name="searchGPLX" value="<?= htmlspecialchars($searchGPLX) ?>">
                                <input type="hidden" name="searchNgayCap" value="<?= htmlspecialchars($searchNgayCap) ?>">
                                <input type="hidden" name="searchNoiCap" value="<?= htmlspecialchars($searchNoiCap) ?>">
                                <input type="hidden" name="searchHanDung" value="<?= htmlspecialchars($searchHanDung) ?>">
                                <input type="hidden" name="searchBang" value="<?= htmlspecialchars($searchBang) ?>">
                                <input type="hidden" name="searchSoCCCD" value="<?= htmlspecialchars($searchSoCCCD) ?>">
                                <input type="hidden" name="searchMSDN" value="<?= htmlspecialchars($searchMSDN) ?>">
                                <input type="number" name="page" value="<?= $page ?>" min="1" max="<?= $total_pages ?>" style="width: 60px;">
                                <input type="submit" value="Go">
                            </form>
                        </li>
                        <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>&searchGPLX=<?= htmlspecialchars($searchGPLX) ?>&searchNgayCap=<?= htmlspecialchars($searchNgayCap) ?>&searchNoiCap=<?= htmlspecialchars($searchNoiCap) ?>&searchHanDung=<?= htmlspecialchars($searchHanDung) ?>&searchBang=<?= htmlspecialchars($searchBang) ?>&searchSoCCCD=<?= htmlspecialchars($searchSoCCCD) ?>&searchMSDN=<?= htmlspecialchars($searchMSDN) ?>">Next</a>
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
                    const SoBangLai = this.dataset.soBangLai;
                    const confirmed = confirm('Bạn có chắc chắn muốn xóa bản ghi này không?');

                    if (confirmed) {
                        fetch('../delete/delete_driverLicense.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `SoBangLai=${encodeURIComponent(SoBangLai)}`
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