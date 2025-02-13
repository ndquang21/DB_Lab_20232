CREATE DATABASE BangLaiXe
DROP DATABASE BangLaiXe
USE BangLaiXe

CREATE TABLE NguoiSoHuu (
    SoCCCD VARCHAR(20) PRIMARY KEY NOT NULL,
	HoTen NVARCHAR(100) NOT NULL,
    SoDienThoai VARCHAR(20),
    DiaChi NVARCHAR(255),
    NgaySinh DATE,
    GioiTinh NVARCHAR(10)
);

CREATE TABLE LichSuDaoTaoSatHach (
    SoCCCD VARCHAR(20) NOT NULL,
    NgayThi DATE NOT NULL,
	LoaiBang VARCHAR(5),
	DiemLyThuyet INT NOT NULL,
	DiemThucHanh INT NOT NULL,
    KetQua NVARCHAR(50),
    FOREIGN KEY (SoCCCD) REFERENCES NguoiSoHuu(SoCCCD) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE CoSoDaoTaoCapBang (
    MaSoDoanhNghiep VARCHAR(20) PRIMARY KEY NOT NULL,
    TenCoSo NVARCHAR(100) NOT NULL,
    MaSoNguoiPhuTrach VARCHAR(20),
    DiaChi NVARCHAR(255),
    DanhGia NVARCHAR(20)
	);

CREATE TABLE BangLaiXe (
    SoBangLai BIGINT PRIMARY KEY NOT NULL,
    NgayCap DATE NOT NULL,
    NoiCap NVARCHAR(255),
    NgayHetHan DATE,
    LoaiBang VARCHAR(5),
    SoCCCD VARCHAR(20) NOT NULL,
    MaSoDoanhNghiep VARCHAR(20) NOT NULL,
    FOREIGN KEY (SoCCCD) REFERENCES NguoiSoHuu(SoCCCD) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (MaSoDoanhNghiep) REFERENCES CoSoDaoTaoCapBang(MaSoDoanhNghiep) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE LichSuViPham (
    SoBangLai BIGINT NOT NULL,
    NgayViPham DATE,
    MoTaViPham NVARCHAR(255) NOT NULL,
    MucPhat DECIMAL(18, 2),
    FOREIGN KEY (SoBangLai) REFERENCES BangLaiXe(SoBangLai) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE CapDoiBangLai (
    SoBangLai BIGINT NOT NULL,
    NgayCapDoi DATE NOT NULL,
    LyDoDoi NVARCHAR(255),
    FOREIGN KEY (SoBangLai) REFERENCES BangLaiXe(SoBangLai) ON UPDATE CASCADE ON DELETE CASCADE
);

Create table Administrators (
	Gmail VARCHAR(50) NOT NULL,
	Pass VARCHAR(20) NOT NULL,
	Name NVARCHAR(50) NOT NULL,
	SDT NVARCHAR(15)
);
Insert into Administrators (Gmail, Pass, Name, SDT) values ('hieudo831@gmail.com', '123456', N'Đỗ Hiếu', '0981026073'),
('phuong.nguyenhong@hust.edu.vn', '1234567890', N'Nguyễn Hồng Phương', '0438696124');
/*Trigger*/
CREATE TRIGGER trg_UpdateKetQua
ON LichSuDaoTaoSatHach
AFTER INSERT, UPDATE
AS
BEGIN
    DECLARE @CanCuoc VARCHAR(20), @DiemLyThuyet INT, @DiemThucHanh INT, @HangBangLai VARCHAR(5), @KetQua NVARCHAR(50);
    SELECT @CanCuoc = i.SoCCCD,
           @DiemLyThuyet = i.DiemLyThuyet,
           @DiemThucHanh = i.DiemThucHanh,
           @HangBangLai = i.LoaiBang
    FROM inserted i
    DECLARE @DiemLyThuyetDat INT = 0, @DiemThucHanhDat INT = 80;
    -- Đặt điểm đạt theo hạng bằng lái
    IF @HangBangLai IN ('A1', 'A2')
    BEGIN
        SET @DiemLyThuyetDat = 21;
    END
    ELSE IF @HangBangLai IN ('B1', 'B2')
    BEGIN
        SET @DiemLyThuyetDat = 27;
    END
    ELSE IF @HangBangLai IN ('C', 'D', 'E', 'F')
    BEGIN
        SET @DiemLyThuyetDat = 28;
    END
    -- Kiểm tra điểm số để xác định kết quả
    IF ((@DiemLyThuyet >= @DiemLyThuyetDat) AND (@DiemThucHanh >= @DiemThucHanhDat))
    BEGIN
        SET @KetQua = N'Đạt';
    END
	ELSE
	BEGIN
        SET @KetQua = N'Không đạt';
    END
    -- Cập nhật kết quả
    UPDATE LichSuDaoTaoSatHach
    SET KetQua = @KetQua
    WHERE SoCCCD = @CanCuoc AND LoaiBang = @HangBangLai;;
END;
Drop trigger trg_UpdateKetQua
truncate table LichSuDaoTaoSatHach
/*Data*/
-- Thêm dữ liệu vào bảng NguoiSoHuu
INSERT INTO NguoiSoHuu (SoCCCD, SoDienThoai, DiaChi, HoTen, NgaySinh, GioiTinh)
VALUES ('123456789', '0987654321', N'TP.HCM', N'Nguyễn Văn A', '1990-01-01', N'Nam'),
       ('987654321', '0123456789', N'TP.HCM', N'Trần Thị B', '1995-05-05', N'Nữ'),
       ('111111111', '0999999999', N'TP.HCM', N'Phạm Văn C', '1988-08-08', N'Nam'),
       ('222222222', '0888888888', N'TP.HCM', N'Lê Thị D', '1993-03-03', N'Nữ'),
       ('545344554', '0914354342', N'TP.HCM', N'Nguyễn Thị B', '1990-01-01', N'Nữ');

-- Thêm dữ liệu vào bảng LichSuDaoTaoSatHach
INSERT INTO LichSuDaoTaoSatHach (SoCCCD, NgayThi, LoaiBang, DiemLyThuyet, DiemThucHanh)
VALUES ('123456789', '2023-01-15', 'A1', 21, 80),
       ('987654321', '2023-02-20', 'B1', 15, 80),
       ('111111111', '2023-03-25', 'B2', 30, 80),
       ('222222222', '2023-04-30', 'A2', 21, 60);

-- Thêm dữ liệu vào bảng CoSoDaoTaoCapBang
INSERT INTO CoSoDaoTaoCapBang (MaSoDoanhNghiep, TenCoSo, DiaChi, DanhGia)
VALUES ('123', N'Trung tâm lái xe AH', N'789 Đường LMN, Quận PQR, Thành phố HCM', N'Tốt'),
       ('456', N'Trường dạy lái xe XYZ', N'012 Đường DEF, Quận GHI, Thành phố HCM', N'Khá'),
	   ('647', N'Trung tâm lái xe ASM', N'789 Đường LMN, Quận PQR, Thành phố HCM', N'Tốt');

-- Thêm dữ liệu vào bảng BangLaiXe
INSERT INTO BangLaiXe (SoBangLai, NgayCap, NoiCap, NgayHetHan, LoaiBang, SoCCCD, MaSoDoanhNghiep)
VALUES ('123456', '2023-03-10', N'Sở Giao thông vận tải', '2028-03-10', 'A1', '123456789', '123'),
       ('111111', '2023-05-30', N'Phòng CSGT quận GHI', '2028-05-30', 'A2', '111111111', '123'),
       ('222222', '2023-06-25', N'Công an phường JKL', '2028-06-25', 'C', '222222222', '456'),
       ('848454', '2023-07-20', N'Phòng CSGT quận XYZ', '2028-07-20', 'B1', '123456789', '647');

-- Thêm dữ liệu vào bảng CapDoiBangLai
INSERT INTO CapDoiBangLai (SoBangLai, NgayCapDoi, LyDoDoi)
VALUES ('123456', '2024-10-15', N'Hết hạn'),
	   ('111111','2024-10-15',N'Hết hạn');

-- Thêm dữ liệu vào bảng LichSuViPham
INSERT INTO LichSuViPham (SoBangLai, NgayViPham, MoTaViPham, MucPhat)
VALUES ('123456', '2024-05-01', N'Vượt đèn đỏ', 500000),
       ('111111', '2024-07-20', N'Vi phạm cấm đỗ', 200000),
       ('222222', '2024-08-30', N'Không đội mũ bảo hiểm', 300000),
       ('123456', '2024-09-05', N'Quá tốc độ', 1500000);