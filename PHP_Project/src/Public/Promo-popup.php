<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotional Popup</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Promotional Popup Styles */
        .promo-popup {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 300px;
            padding: 15px;
            background-color: #f1f1f1;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            display: none; 
            z-index: 1000;
        }

        .promo-popup h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .promo-popup p {
            font-size: 14px;
            color: #666;
        }

        .promo-popup img {
            margin-top: 10px;
            border-radius: 5px;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 18px;
            cursor: pointer;
            color: #888;
        }


    </style>
</head>
<body>
    <!-- Cửa sổ bật lên quảng cáo -->
    <div id="promo-popup" class="promo-popup">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h3>Special Promotion!</h3>
        <p>Get 20% off on your first order! Use code: FIRST20</p>
        <img src="" alt="Promotion Image" style="width: 100%;"/>
    </div>

    <script>
            // Hàm hiển thị cửa sổ khi trang tải xong
        window.onload = function() {
            // Kiểm tra xem cửa sổ đã bị đóng và khi nào
            let lastClosedTime = localStorage.getItem('promoPopupClosedTime');
            let currentTime = new Date().getTime();
            let timeDiff = currentTime - lastClosedTime;

            // Kiểm tra nếu đã hơn 12 giờ (43200000 mili giây)
            if (!lastClosedTime || timeDiff >= 43200000) { // 43200000 ms = 12 giờ
                document.getElementById("promo-popup").style.display = "block";
            }
        }

        // Hàm đóng cửa sổ và lưu thời gian đóng
        function closePopup() {
            document.getElementById("promo-popup").style.display = "none";

            // Lưu thời gian hiện tại là thời gian cuối cùng cửa sổ bị đóng
            localStorage.setItem('promoPopupClosedTime', new Date().getTime());
        }

    </script>
</body>
</html>
