<?php 
include_once 'include/header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ISO Audit System Dashboard</title>
  <style>
    /* General Styles */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      color: #333;
      min-height: 100vh; /* Ensure full height of the screen */
      position: relative;
    }

    /* Background Slideshow */
    .background-slideshow {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1; /* Ensure it stays in the background */
      overflow: hidden;
    }

    .background-slideshow img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      position: absolute;
      top: 0;
      left: 0;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }

    .background-slideshow img.active {
      opacity: 1;
    }

    /* Header */
    header {
      background-color: rgba(76, 175, 80, 0.8); /* Semi-transparent background */
      color: white;
      padding: 20px;
      text-align: center;
      font-size: 24px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      position: relative;
      z-index: 1;
    }

    /* Dashboard Container */
    .dashboard-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      padding: 20px;
      position: relative;
      z-index: 1;
    }

    /* Cards */
    .card {
      background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin: 10px;
      width: 30%;
      text-align: center;
    }

    .card h2 {
      font-size: 20px;
      margin-bottom: 10px;
    }

    .card p {
      font-size: 16px;
      color: #666;
    }

    /* Footer */
    footer {
      background-color: rgba(51, 51, 51, 0.8); /* Semi-transparent background */
      color: white;
      text-align: center;
      padding: 15px;
      position: fixed;
      bottom: 0;
      width: 100%;
      z-index: 1;
    }
  </style>
</head>
<body>

  <!-- Background Slideshow -->
  <div class="background-slideshow">
    <img src="img/1.jpg" alt="Photo 1" class="active">
    <img src="img/2.jpg" alt="Photo 2">
    <img src="img/3.png" alt="Photo 3">
  </div>

  <!-- Header -->
 

  <!-- Footer -->
  <footer>
    <p>Dynamic Technologies Pvt Ltd 2025 IT Department</p>
  </footer>

  <!-- JavaScript for Background Slideshow -->
  <script>
    let images = document.querySelectorAll('.background-slideshow img');
    let currentIndex = 0;

    function changeImage() {
      images[currentIndex].classList.remove('active');
      currentIndex = (currentIndex + 1) % images.length;
      images[currentIndex].classList.add('active');
    }

    setInterval(changeImage, 5000); // Change image every 5 seconds
  </script>

</body>
</html>