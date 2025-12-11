<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About - Monitoring System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Important for responsiveness -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            overflow-x: hidden;
            position: relative;
            min-height: 100vh;
        }
        .top-bar {
            background-color: #00b34d;
            height: 80px;
            width: 100%;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .go-back-btn {
            background-color: #ffffff;
            color: #00b34d;
            border: 2px solid #00b34d;
            padding: 10px 24px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 30px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .go-back-btn:hover {
            background-color: #00b34d;
            color: #ffffff;
        }

        .main-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 60px 80px;
            min-height: calc(100vh - 70px);
            align-items: flex-start;
        }
        .left-side {
            flex: 1;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 40px;
        }
        .left-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .left-content img {
            max-width: 320px;
            width: 100%;
            margin-bottom: 10px;
            margin-top: 10px;
        }
        .left-content h1 {
            color: #00b34d;
            font-size: 80px;
            font-weight: 900;
            margin: 10px 0;
        }
        .left-content h2 {
            color: #000;
            letter-spacing: 10px;
            font-size: 34px;
            margin: 0 0 20px 0;
            font-weight: 700;
        }
        .left-content p {
            color: #00b34d;
            font-size: 28px;
            font-weight: 700;
            margin: 10px 0;
        }
        .right-side {
            flex: 1;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        .info-box {
            background-color: #e8f5e9;
            border-left: 5px solid #00b34d;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .info-box h3 {
            margin-top: 0;
            color: #00b34d;
            font-size: 28px;
            margin-bottom: 15px;
        }
        .info-box p {
            color: #333;
            line-height: 1.8;
            margin: 0;
            font-size: 16px;
        }
        a {
            color: #00b34d;
            text-decoration: none;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #999;
            font-size: 14px;
            background-color: #f4f4f4;
            margin-top: 40px;
        }

        /* --- Responsive Styles --- */
        @media (max-width: 992px) {
            .main-section {
                flex-direction: column;
                padding: 40px 30px;
                align-items: center;
            }
            .left-side, .right-side {
                width: 100%;
                padding: 0;
            }
            .left-content img {
                max-width: 250px;
            }
            .left-content h1 {
                font-size: 60px;
            }
            .left-content h2 {
                font-size: 26px;
                letter-spacing: 5px;
            }
            .left-content p {
                font-size: 22px;
            }
            .info-box h3 {
                font-size: 24px;
            }
            .info-box p {
                font-size: 15px;
            }
        }

        @media (max-width: 600px) {
            .main-section {
                padding: 30px 20px;
            }
            .top-bar {
                height: 60px;
            }
            .go-back-btn {
                font-size: 16px;
                padding: 5px 15px;
            }
            .left-content img {
                max-width: 180px;
            }
            .left-content h1 {
                font-size: 45px;
            }
            .left-content h2 {
                font-size: 20px;
                letter-spacing: 3px;
            }
            .left-content p {
                font-size: 18px;
            }
            .info-box h3 {
                font-size: 20px;
            }
            .info-box p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="top-bar">
    <button class="go-back-btn" onclick="history.back()">← Back</button>
</div>

<div class="main-section">
    <div class="left-side">
        <div class="left-content">
            <img src="logovan.png" alt="Logo">
            <h1>UV EXPRESS</h1>
            <h2>POLANGUI - LEGAZPI</h2>
            <p>REAL-TIME RIDES,</p>
            <p>REAL-TIME PEACE OF MIND!</p>
        </div>
    </div>

    <div class="right-side">
        <div class="info-box">
            <h3>About the System</h3>
            <p>
                The UV EXPRESS Polangui - Legazpi Monitoring System is a web-based platform designed to manage, monitor, and oversee transportation operations 
                between major destinations such as Polangui and Legazpi. It serves both Drivers and Administrators, ensuring safe, efficient, and transparent transport services.
            </p>
        </div>

        <div class="info-box">
            <h3>Our Vision</h3>
            <p>
                To be the leading platform for safe, efficient, and reliable transportation monitoring, connecting communities through innovation and trust.
            </p>
        </div>

        <div class="info-box">
            <h3>Our Mission</h3>
            <p>
                Our mission is to provide a reliable monitoring system that improves transportation safety, enhances operational efficiency, 
                and supports better decision-making through real-time data tracking and management.
            </p>
        </div>

        <div class="info-box">
            <h3>Contact Us</h3>
            <p>
                For support or inquiries, you may reach us at:<br>
                Email: <a href="mailto:support@monitoringsystem.com">support@monitoringsystem.com</a><br>
                Phone: +63 912 345 6789
            </p>
        </div>
    </div>
</div>

<div class="footer">
    &copy; <?php echo date("Y"); ?> Vehicle Monitoring System. All rights reserved.
</div>

</body>
</html>
