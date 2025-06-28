<!DOCTYPE html>
<html>
<head>

    <title>Room Gallery</title>
   
    <style>
.room-card.standard {
      background-image: url('../images/standard.jpg');

}

.room-card.deluxe {
    background-image: url('../images/deluxe.jpg');
}

.room-card.suite {
    background-image: url('../images/suite.jpg');
}


    </style>
    <script>
        function filterRooms(type) {
            var rooms = document.querySelectorAll('.room-card');
            rooms.forEach(function(room) {
                if(type === 'all' || room.classList.contains(type)) {
                    room.style.display = 'inline-block';
                } else {
                    room.style.display = 'none';
                }
            });
        }
    </script>
</head>
<body>
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
  <?php include('../includes/header.php');?>
  <link rel="stylesheet" href="../style.css" />

  <div class="main-content">
    <h2 style="text-align:center; margin-top: 20px;">Room Types</h2>
<div style="text-align: right; margin: 10px 20px;">


    <div class="filter-buttons">
      <button onclick="filterRooms('all')">All</button>
      <button onclick="filterRooms('standard')">Standard</button>
      <button onclick="filterRooms('deluxe')">Deluxe</button>
      <button onclick="filterRooms('suite')">Suite</button>
    </div>

    <div class="room-wrapper" id="room-list">
      <div class="room-card standard">
       <h3>Standard Room</h3>
    <p>Comfortable and affordable with essential amenities.</p>
    <a href="https://virtual-tour.chrisogrady.com/singapore/hotel-indigo-singapore-katong/index.html?_gl=1*5xfds9*_ga*MTg1MzAxODg1NS4xNzUxMDM4ODIz*_ga_3TH7LLS6F5*czE3NTEwMzg4NTkkbzEkZzEkdDE3NTEwMzg4NzMkajQ2JGwwJGgw" target="_blank" style="display:inline-block; margin-top:10px; padding:8px 16px; background:#007BFF; color:#fff; text-decoration:none; border-radius:5px;">360° Virtual Tour</a>
      </div>
      <div class="room-card deluxe">
        <h3>Deluxe Room</h3>
        <p>Extra space, premium features.</p>
            <a href="https://www.vecteezy.com/photo/41461103-ai-generated-luxurious-hotel-room-with-a-breathtaking-view-of-the-bustling-city-below-showcasing-towering-skyscrapers-and-vibrant-city-lights" target="_blank" style="display:inline-block; margin-top:10px; padding:8px 16px; background:#007BFF; color:#fff; text-decoration:none; border-radius:5px;">360° Virtual Tour</a>

      </div>
      <div class="room-card suite">
        <h3>Suite</h3>
        <p>Luxury suite with top amenities.</p>
        <a href="360tour_suite.html" target="_blank" style="color:#ffd;">360° Virtual Tour</a>
      </div>
    </div>
  </div>

  <?php include('../includes/footer.php'); ?>
</body>
</html>
