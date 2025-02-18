<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head Content -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Job Details</title>
    <link href="css/tailwind.min.css" rel="stylesheet">
    <link href="css/select2.min.css" rel="stylesheet" />
    <script src="css/jquery-3.6.0.min.js"></script>
    <script src="css/select2.min.js"></script>

    <style>
        /* Ensure the body takes full height without scroll */
        html, body {
            height: 100%;
            margin: 0;
        }

        /* Ensures the main content fills the available space and pushes footer down */
        .main-content {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        /* Existing CSS styles */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
            word-wrap: break-word;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .pagination-link {
            padding: 8px 16px;
            margin: 0 4px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .pagination-link:hover {
            background-color: #0056b3;
        }

        .pagination-link.disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .export-button {
            padding: 8px 16px;
            margin: 0 4px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }

        .export-button:hover {
            background-color: #218838;
        }

        .group-header {
            background-color: #e2e8f0;
            font-weight: bold;
        }

        .edit-button {
            padding: 4px 8px;
            border: none;
            border-radius: 4px;
            background-color: #ffc107;
            color: white;
            cursor: pointer;
        }

        .edit-button:hover {
            background-color: #e0a800;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 800px;
            border-radius: 8px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        .save-button {
            padding: 8px 16px;
            margin-top: 12px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        .save-button:hover {
            background-color: #0056b3;
        }

        /* Style for the slideshow container */
        .slideshow-container {
            position: relative;
            width: 100%;
            max-width: 100%;
            margin: auto;
            overflow: hidden;
            height: 86vh; /* Full screen height */
        }

        /* Style for each slide */
        .slide {
            display: none;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .slide.active {
            display: block;
            opacity: 1;
        }

        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensure images cover the container */
        }

        /* Text on top of the image */
        .text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 2rem;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
        }

        /* Style for the next/prev buttons (optional) */
        .prev, .next {
            position: absolute;
            top: 50%;
            padding: 16px;
            color: white;
            background-color: rgba(0, 0, 0, 0.6);
            border: none;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            z-index: 1;
        }

        .prev {
            left: 0;
            transform: translateY(-50%);
        }

        .next {
            right: 0;
            transform: translateY(-50%);
        }

        .prev:hover, .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Style for the dropdown menu */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #007bff;
            min-width: 160px;
            z-index: 1;
            border-radius: 8px;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #0056b3;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Ensure footer stays at the bottom of the page */
        .footer {
            margin-top: auto;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen">
    <div class="main-content">
        <nav class="bg-blue-600 p-2 shadow-md">
            <div class="container mx-auto flex items-center justify-between">
                <!-- Logo/Title Section -->
                <div class="flex items-center">
                    <div class="text-white font-bold text-xl tracking-tight">
                        DT
                        <span class="block text-sm font-light">Pallekele</span>
                    </div>
                </div>

                <!-- Mobile Menu Button (hidden on larger screens) -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-white hover:text-blue-100 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6" id="nav-links">
                    <!-- Dashboard Link -->
                    <a href="index.php" class="text-white hover:text-blue-100 transition-colors duration-300 font-semibold">
                        Dashboard
                    </a>

                    <!-- Dropdown for Job Details and Iso Audit -->
                    <div class="relative dropdown">
                        <button class="text-white hover:text-blue-100 font-semibold">
                            Guest View
                        </button>
                        <div class="dropdown-content">
                            <a href="Job_Details_n.php">View Job Details</a>
                            <a href="iso_audit_view.php">Iso Audit Details</a>
                        </div>
                    </div>

                    <!-- Theam-01 Login Link -->
                    <a href="http://192.168.1.210:4141/home.php" class="text-white hover:text-blue-100 transition-colors duration-300 font-semibold">
                        Theam-01 Login
                    </a>

                    <!-- Job Details Link -->
                    <a href="login.php" class="text-white hover:text-blue-100 transition-colors duration-300 font-semibold">
                        Job Details
                    </a>

                    <!-- Iso Audit Link -->
                    <a href="iso_audit/login.php" class="text-white hover:text-blue-100 transition-colors duration-300 font-semibold">
                        Iso Audit
                    </a>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu (hidden by default) -->
        <div class="md:hidden hidden bg-blue-600" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="http://192.168.1.210:4141/home.php" class="block text-white hover:text-blue-100">Theam-01 Login</a>
                <a href="login.php" class="block text-white hover:text-blue-100">Job Details</a>
                <a href="iso_audit/login.php" class="block text-white hover:text-blue-100">Iso Audit</a>
            </div>
        </div>

        <!-- Image Slideshow -->
        <div class="slideshow-container">
            <!-- Slide 1 -->
            <div class="slide active">
                <img src="img/2.jpg" alt="Slide 1">
            </div>

            <!-- Slide 2 -->
            <div class="slide">
                <img src="img/1.jpg" alt="Slide 2">
            </div>

            <!-- Slide 3 -->
            <div class="slide">
                <img src="img/3.png" alt="Slide 3">
            </div>

            <!-- Navigation buttons (optional) -->
            <button class="prev" onclick="plusSlides(-1)">&#10094;</button>
            <button class="next" onclick="plusSlides(1)">&#10095;</button>
        </div>

    </div>

    <footer class="bg-blue-600 text-white p-2 mt-8 footer">
        <div class="container mx-auto text-center">
            <p class="text-sm">Copyright &copy; 2025. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Slideshow functionality
        let slideIndex = 0;
        let slides = document.querySelectorAll(".slide");

        function showSlides() {
            for (let i = 0; i < slides.length; i++) {
                slides[i].classList.remove("active");
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }
            slides[slideIndex - 1].classList.add("active");
            setTimeout(showSlides, 5000); // Change image every 5 seconds
        }

        // Next/Previous button functionality
        function plusSlides(n) {
            slideIndex += n;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }
            if (slideIndex < 1) {
                slideIndex = slides.length;
            }
            for (let i = 0; i < slides.length; i++) {
                slides[i].classList.remove("active");
            }
            slides[slideIndex - 1].classList.add("active");
        }

        // Initialize slideshow
        showSlides();
    </script>
</body>

</html>
