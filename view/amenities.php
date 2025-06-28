<?php include('../includes/header.php'); ?>
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../view/login.php");
    exit();
}

include('../includes/db.php'); 
date_default_timezone_set('Asia/Dhaka');


function isAmenityOpen($open_hours) {
    $oh = trim(strtolower($open_hours));
    if ($oh === '24/7' || $oh === '24-7' || $oh === 'always open') {
        return true;
    }
    $times = explode('-', $oh);
    if (count($times) != 2) return false;

    $open = strtotime($times[0]);
    $close = strtotime($times[1]);
    $now = time();

    if ($open === false || $close === false) return false;

    if ($close <= $open) {
        $close += 86400;
        if ($now < $open) $now += 86400;
    }

    return ($now >= $open && $now <= $close);
}


function normalizeOpenHours($hours) {
    $hours = strtolower(trim($hours));

    if (strpos($hours, '24') !== false) return '24/7';

    $hours = str_replace(['–', 'to'], '-', $hours);
    $hours = str_replace('open', '', $hours);
    $parts = explode('-', $hours);
    if (count($parts) != 2) return $hours;

    $start = strtotime(trim($parts[0]));
    $end = strtotime(trim($parts[1]));

    if (!$start || !$end) return $hours;

    return date('H:i', $start) . '-' . date('H:i', $end);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Amenities</title>
    <link rel="stylesheet" href="../style.css" />
    <style>
        .filter-buttons {
            text-align: center;
            margin-bottom: 15px;
        }
        .filter-buttons button {
            margin: 0 8px;
            padding: 8px 16px;
            font-size: 1em;
            border: none;
            background-color: #004080;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .filter-buttons button:hover {
            background-color: #0066cc;
        }
        .amenity-card {
            display: inline-block;
            width: 280px;
            height: auto;
            margin: 15px;
            padding: 35px;
            color: white;
            border-radius: 8px;
            background-size: cover;
            background-position: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
            vertical-align: top;
            position: relative;
            overflow: hidden;
        }
        .amenity-card > * {
            position: relative;
            z-index: 2;
        }
        .amenity-card::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            border-radius: 8px;
            z-index: 1;
        }
        .amenity-card h3,
        .amenity-card p {
            color: white;
            margin: 5px 0;
        }
        .status-text {
            font-weight: bold;
        }
    </style>
</head>
<body>
<a href="dashboard.php" style="
      position: fixed;
      top: 15px;
      right: 20px;
      background: #dc3545;
      color: white;
      padding: 8px 14px;
      text-decoration: none;
      border-radius: 6px;
      z-index: 1000;
      font-weight: bold;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  ">Close</a>

<h2 style="text-align:center;">Amenities</h2>

<div class="filter-buttons">
    <button onclick="filterAmenities('all')">All</button>
    <button onclick="filterAmenities('pool')">Pool</button>
    <button onclick="filterAmenities('spa')">Spa</button>
    <button onclick="filterAmenities('gym')">Gym</button>
</div>

<div id="amenities-list" style="text-align:center;">

<?php
$sql = "SELECT * FROM amenities_list";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $type = htmlspecialchars($row['type']);
        $name = htmlspecialchars($row['name']);
        $description = htmlspecialchars($row['description']);
        $original_hours = htmlspecialchars($row['open_hours']);
        $normalized_hours = normalizeOpenHours($row['open_hours']);
        $image = htmlspecialchars($row['image']);

        echo "
        <div class='amenity-card {$type}' style='background-image: url(\"$image\")' data-hours=\"$normalized_hours\">
            <h3>$name</h3>
            <p>$description</p>
            <p>Hours: $original_hours</p>
            <p>Status: <span class='status-text'>Checking...</span></p>
        </div>";
    }
} else {
    echo "<p>No amenities found.</p>";
}
?>

</div>

<script>
function filterAmenities(type) {
    var amenities = document.querySelectorAll('.amenity-card');
    amenities.forEach(function(amenity) {
        if (type === 'all' || amenity.classList.contains(type)) {
            amenity.style.display = 'inline-block';
        } else {
            amenity.style.display = 'none';
        }
    });
}

function isAmenityOpenJS(hoursStr) {
    const now = new Date();
    let currentMinutes = now.getHours() * 60 + now.getMinutes();

    hoursStr = hoursStr.toLowerCase().trim();

    if (['24/7', '24-7', 'always open'].includes(hoursStr)) return true;

    const parts = hoursStr.split('-');
    if (parts.length !== 2) return false;

    function toMinutes(timeStr) {
        const [h, m] = timeStr.split(':');
        return parseInt(h) * 60 + (parseInt(m) || 0);
    }

    const openMin = toMinutes(parts[0]);
    let closeMin = toMinutes(parts[1]);

    if (closeMin <= openMin) closeMin += 1440;
    if (currentMinutes < openMin) currentMinutes += 1440;

    return currentMinutes >= openMin && currentMinutes <= closeMin;
}

function updateAmenityStatuses() {
    document.querySelectorAll('.amenity-card').forEach(card => {
        const hours = card.getAttribute('data-hours');
        const statusSpan = card.querySelector('.status-text');

        const isOpen = isAmenityOpenJS(hours);
        statusSpan.textContent = isOpen ? 'Available' : 'Closed';
        statusSpan.style.color = isOpen ? 'limegreen' : 'red';
    });
}

updateAmenityStatuses();
setInterval(updateAmenityStatuses, 60000);
</script>

<?php include('../includes/footer.php'); ?>
</body>
</html>
