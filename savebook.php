<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "bookstore";
$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) die("ไม่สามารถติดต่อกับ MySQL ได้");
// mysqli_select_db($dbname, $conn) or die("ไม่สามารถเลือกฐานข้อมูล school ได้");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); //ให้โชว์ข้อความนี้ขึนมา แล้วออกจากโปรแกรมไปเลยไม่ทำต่อ
}
mysqli_query($conn, "SET character_set_results=tis620");
mysqli_query($conn, "SET character_set_client=tis620");
mysqli_query($conn, "SET character_set_connection=tis620");
$Flag = true;
$ImageFile = htmlspecialchars(trim($ImageFile));
if ($ImageFile == "") {
    echo "<B><CENTER><li>คุณไม่ได้เลือกรูปภาพ.</CENTER></B><BR>";
} else {
    $ImageFile_name;
    $ImageFile_type;
    $ImageFile_size;
    if ($ImageFile_type == "image/gif" or $ImageFile_type == "image/pjpeg") {
        if ($ImageFile_size <= $max_size) {
            copy($ImageFile, "pictures/$ImageFile_name");
            unlink($ImageFile);
            $image = $ImageFile_name;
            $Flag = true;
        } else {
            echo "<CENTER><li>รูปภาพมีขนาดใหญ่กว่า 50 kb.<BR></CENTER>";
            echo "<CENTER><input type=\"button\" value=\"กลับไปแก้ไข\" ";
            echo "onclick=\"history.back();\" style=\"cursor:hand\"></CENTER>";
            $Flag = false;
        }
    } else {
        echo "<CENTER><li>รูปภาพไม่ใช่ไฟล์ประเภท GIF หรือ JPG <BR></CENTER>";
        echo "<CENTER><input type=\"button\" value=\"กลับไปแก้ไข\" ";
        echo "onclick=\"history.back();\" style=\"cursor:hand\"></CENTER>";
        $Flag = false;
    }
}
if ($Flag) {
    $BDate = date("Y-m-d");
    $sql = "INSERT INTO book (BookID ,BookName, TypeID, StatusID, Publish,
UnitPrice,UnitRent, DayAmount ,Picture,BookDate) VALUES
('$BookID','$BookName','$TypeID','$StatusID', '$Publish',
'$UnitPrice','$UnitRent','$DayAmount','$image','$BDate')";
    mysqli_query($conn, $sql) or die("INSERT ลงตาราง book มีข้อผิดพลาดเกิดขึ้น" .
        mysqli_error($conn));
    echo "<br><br><CENTER><H2>บันทึกข้อมูลเรียบร้อย</H2><BR><BR></CENTER>";
    echo "<CENTER><A HREF=\"listofbook.php\">แสดงข้อมูลทั้งหมด</A></CENTER>";
}
mysqli_close($conn);
