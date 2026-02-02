<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INS3064 Welcome Page</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 600px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        .info {
            text-align: left;
            margin-top: 20px;
        }

        .label {
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="container">
    <h1>INS3064 Welcome Page</h1>

    <div class="info">
        <?php
            ini_set('display_errors', 1);
            error_reporting(E_ALL);

            // Thông tin sinh viên
            $name = "Bui Quynh Mai";
            $studentId = "22070561";
            $class = "INS306402";
            $email = "quynhmai2708204@gmail.com";

            // Múi giờ Việt Nam 
            date_default_timezone_set("Asia/Ho_Chi_Minh");

            // Thứ trong tuần tiếng Việt
            $days = [
                "Sunday" => "Chủ Nhật",
                "Monday" => "Thứ Hai",
                "Tuesday" => "Thứ Ba",
                "Wednesday" => "Thứ Tư",
                "Thursday" => "Thứ Năm",
                "Friday" => "Thứ Sáu",
                "Saturday" => "Thứ Bảy"
            ];

            $dayVN = $days[date("l")];

            // Ngày và giờ theo yêu cầu
            $date = $dayVN . ", ngày " . date("d") . " tháng " . date("m") . " năm " . date("Y");
            $time = date("H:i:s");
        ?>

        <p><span class="label">Tên:</span> <?php echo $name; ?></p>
        <p><span class="label">ID sinh viên:</span> <?php echo $studentId; ?></p>
        <p><span class="label">Class:</span> <?php echo $class; ?></p>
        <p><span class="label">Email:</span> <?php echo $email; ?></p>
        <p><span class="label">Date:</span> <?php echo $date; ?></p>
        <p><span class="label">Time:</span> <?php echo $time; ?></p>
    </div>

</div>

</body>
</html>
