<?php
// monitor.php
include 'dbconnection.php';

try {
    $stmt = $pdo->prepare("
        SELECT 
            vans.plate_number, 
            vans.available_seats, 
            vans.status, 
            vans.departure_time, 
            vans.arrival_time, 
            drivers.name AS driver_name, 
            drivers.contact_number
        FROM vans
        INNER JOIN drivers ON vans.driver_id = drivers.driver_id
        WHERE drivers.is_approved = 'approved'
    ");
    $stmt->execute();
    $vans = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Van Monitor</title>
    <style>
        body {
            font-family: 'Poppins';
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .header {
            background-color: #00b050;
            color: white;
            padding: 10px;
            display: flex;
            align-items: center;
            position: relative;
        }
        .header-icon {
            color:black;

        }
        .menu-icon {
            font-size: 28px;
            cursor: pointer;
            margin-right: 20px;
            margin-left: 50px;
            padding: 5px;
        }
        .menu {
            display: none;
            position: absolute;
            top: 90px;
            left: 10px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
            z-index: 100;
            width: 250px;
        }
        .menu a {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            text-decoration: none;
            color: #333;
            border-bottom: 1px solid #eee;
            gap: 10px;
        }
        .menu a img {
            width: 80px;
            height: 50px;
            object-fit: contain;
        }
        .menu a:hover {
            background-color: #00b050;
            color: white;
        }
        .header-content {
            flex-grow: 1;
            text-align: center;
        }
        .header-content h1 {
            margin: 0;
            font-size: 36px;
            font-weight: bold;
        }
        .header-content p {
            margin: 5px 0;
            letter-spacing: 15px;
            font-size: 20px;
            color: black;
        }
        .main-container {
            display: flex;
        }
        .filter-sidebar {
            width: 200px;
            padding: 20px;
            background: white;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            margin: 30px;
            height: fit-content;
            border-radius: 10px;
        }
        .filter-sidebar h3 {
            margin-top: 0;
            color: #00b050;
            font-size: 20px;
            text-align: center;
        }
        .filter-sidebar button {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            background-color: #00b050;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-weight: none;
            transition: background-color 0.3s, transform 0.2s;
        }
        .filter-sidebar button:hover {
            background-color: #00823d;
        }
        .filter-sidebar button.active {
            background-color: #00823d;
            color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 176, 80, 0.4);
            transform: scale(1.05);
        }
        .vans-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            padding: 30px;
        }
        .van-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 250px;
            padding: 20px;
            text-align: center;
        }
        .van-card img {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }
        .plate-number {
            background: #e0e0e0;
            padding: 10px;
            font-weight: none;
            font-size: 18px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .info-title {
            font-weight: none;
            color: #00b050;
            margin: 10px 0 5px;
        }
        .info-value {
            font-size: 20px;
            font-weight: none;
            margin-bottom: 10px;
        }
        .status {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: none;
            color: black;
            display: inline-block;
            margin-bottom: 5px;
        }
        .waiting { background-color: orange; }
        .traveling { background-color: rgb(38, 178, 54); }
        .arrived { background-color: rgb(22, 119, 45); }
        .parked { background-color: #6c757d; }
        .driver-name {
            margin-top: 10px;
            font-weight: none;
            letter-spacing: 1px;
        }
        .time-info {
            font-size: 14px;
            margin-top: 5px;
            color: #555;
        }
        .done-monitoring-container {
            text-align: center;
            margin: 30px 0;
        }
        .done-monitoring-btn {
            background-color: #00b050;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 18px;
            border-radius: 30px;
            font-weight: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .done-monitoring-btn:hover {
            background-color: #00823d;
        }

        /* Responsive Navbar Text */
        @media (max-width: 768px) {
            .header-content h1 {
                font-size: 24px;
            }

            .header-content p {
                font-size: 14px;
                letter-spacing: 5px;
            }

            .menu-icon {
                font-size: 22px;
                margin-left: 20px;
            }

            .header-content h1 img {
                height: 30px;
            }
        }

        @media (max-width: 480px) {
            .header-content h1 {
                font-size: 18px;
            }

            .header-content p {
                font-size: 12px;
                letter-spacing: 2px;
            }

            .menu {
                width: 200px;
                top: 70px;
                left: 5px;
            }

            .menu-icon {
                font-size: 20px;
                margin-left: 15px;
            }
        }
    </style>

    <script>
        function toggleMenu() {
            var menu = document.getElementById('menu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }

        function filterVans(status, clickedButton) {
            var cards = document.getElementsByClassName('van-card');
            for (var i = 0; i < cards.length; i++) {
                var card = cards[i];
                var cardStatus = card.querySelector('.status').classList[1]; 
                if (status === 'all' || cardStatus === status) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            }

            var buttons = document.querySelectorAll('.filter-sidebar button');
            buttons.forEach(function(button) {
                button.classList.remove('active');
            });
            clickedButton.classList.add('active');
        }
    </script>
</head>
<body>

<div class="header">
    <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
    <div id="menu" class="menu">
        <a href="index.php">
            <img src="home.png" alt="Home Icon"> Home
        </a>
        <a href="driver_register.php">
            <img src="reg.png" alt="Register Icon"> Register
        </a>
        <a href="login.php">
            <img src="log.png" alt="Login Icon"> Login
        </a>
        <a href="about.php">
            <img src="us.png" alt="About Us Icon"> About Us
        </a>
    </div>
    <div class="header-content">
        <h1 style="display: flex; align-items: center; justify-content: center; gap: 15px;">
            <img src="car.png" alt="Car Icon" style="height: 60px;"> UV EXPRESS
        </h1>
        <p>POLANGUI - LEGAZPI</p>
    </div>
</div>

<div class="main-container">
    <div class="filter-sidebar">
        <h3>Show Vans by Status</h3>
        <button onclick="filterVans('all', this)" class="active">All Vans</button>
        <button onclick="filterVans('waiting', this)">Waiting</button>
        <button onclick="filterVans('traveling', this)">Traveling</button>
        <button onclick="filterVans('arrived', this)">Arrived</button>
        <button onclick="filterVans('parked', this)">Parked</button>
    </div>

    <div class="vans-container" id="vansContainer">
        <?php foreach ($vans as $van): 
            $statusClass = strtolower($van['status']);
        ?>
        <div class="van-card">
            <img src="van.png" alt="Van Image">
            <div class="plate-number"><?php echo htmlspecialchars($van['plate_number']); ?></div>

            <div class="info-title">Available No. of Seats</div>
            <div class="info-value"><?php echo htmlspecialchars($van['available_seats']); ?></div>

            <div class="info-title">Status</div>
            <div class="status <?php echo $statusClass; ?>">
                <?php echo ucfirst(htmlspecialchars($van['status'])); ?>
            </div>
            <?php if ($van['status'] == 'traveling' && $van['departure_time']): ?>
                <div class="time-info">Departed at:<br><?php echo date('g:i A', strtotime($van['departure_time'])); ?></div>
            <?php elseif ($van['status'] == 'arrived' && $van['arrival_time']): ?>
                <div class="time-info">Arrived at:<br><?php echo date('g:i A', strtotime($van['arrival_time'])); ?></div>
            <?php endif; ?>

            <div class="info-title">Contact Number</div>
            <div class="info-value"><?php echo htmlspecialchars($van['contact_number']); ?></div>

            <div class="info-title">Driver</div>
            <div class="driver-name"><?php echo htmlspecialchars(strtoupper($van['driver_name'])); ?></div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="done-monitoring-container">
    <a href="index.php">
        <button class="done-monitoring-btn">Done Monitoring</button>
    </a>
</div>

</body>
</html>
