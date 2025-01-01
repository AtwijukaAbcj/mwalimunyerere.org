
<?php include('root/config.php');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mwalimu Nyerere Livelihood Program</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Mwalimu Nyerere Livelihood Program - Empowering communities through impactful initiatives.">
    <meta name="keywords" content="donation, charity, NGO, livelihood, sustainable development">
    <meta name="author" content="MNLP">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- ElegantFonts CSS -->
    <link rel="stylesheet" href="css/elegant-fonts.css">

    <!-- Themify-icons CSS -->
    <link rel="stylesheet" href="css/themify-icons.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="css/swiper.min.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="style.css">

</head>
<body>
<header class="site-header">
  <div class="top-header-bar">
    <div class="container d-flex justify-content-between align-items-center">
      <!-- Left Side: Email and Phone -->
      <div class="header-bar-content">
          <div class="header-bar-email">
              MAIL: <a href="mailto:info@mwalimunyerere.org">info@mwalimunyerere.org</a>
          </div>
          <div class="header-bar-text">
              PHONE: <span>+24 3772 120 091 / +56452 4567</span>
          </div>
      </div>

      <!-- Right Side: Bell Dropdown and Donate Button -->
      <div class="d-flex align-items-center">
          <!-- Bell Dropdown -->
          <div class="nav-item dropdown mr-3">
              <a class="nav-link dropdown-toggle" href="#" id="cartDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-bell"></i> <span class="badge badge-danger" id="cartCount">0</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="cartDropdown" style="width: 300px; max-height: 400px; overflow-y: auto;">
                  <h6 class="dropdown-header">Cart Items</h6>
                  <div id="cartItems">
                      <!-- Cart items will be dynamically loaded here -->
                  </div>
                  <div class="dropdown-divider"></div>
                  <a href="checkout.php" class="dropdown-item text-center">Go to Checkout</a>
              </div>
          </div>

          <!-- Donate Button -->
          <div class="donate-btn">
                <a href="causes.php" 
        class="btn btn-success btn-sm">Donate</a>

          </div>
      </div>
    </div>

  </div>

<!-- Navbar -->
<!-- Navbar -->
 <!-- Navbar Container -->
<div class="navbar-container">
  <nav class="navbar navbar-expand-lg fixed-top navbar-light" id="mainNavbar">
    <div class="container d-flex justify-content-between align-items-center">
      <!-- Branding Logo -->
      <a class="navbar-brand" href="index-2.php">
        <img src="images/logo.png" alt="MNLP Logo" class="logo">
      </a>

      <!-- Mobile Menu Toggle -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar Links -->
      <div class="collapse navbar-collapse justify-content-end" id="mainNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="index-2.php">Home</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="about.php">About Us</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="team.php">Our Team</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="causes.php">Our Causes</a>
          </li>
         <!-- Dropdown for Projects -->
          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="#" id="projectsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Projects
            </a>
            <div class="dropdown-menu active" aria-labelledby="projectsDropdown">
              <a class="dropdown-item active" href="upcoming_projects.php">Upcoming Projects</a>
              <a class="dropdown-item active" href="projects.php">All Projects</a>
            </div>
          </li>

          <li class="nav-item active">
            <a class="nav-link" href="portfolio.html">Gallery</a>
          </li>


          <li class="nav-item active">
            <a class="nav-link" href="events.php">Events</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="contact.html">Contact Us</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>
    </header>

    <!-- Include the JavaScript here -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function loadCartItems() {
            fetch('fetch_cart.php') // PHP script to fetch cart items
                .then(response => response.json())
                .then(data => {
                    const cartItems = document.getElementById('cartItems');
                    const cartCount = document.getElementById('cartCount');

                    cartItems.innerHTML = '';
                    if (data.items.length > 0) {
                        data.items.forEach(item => {
                            cartItems.innerHTML += `
                                <div class="dropdown-item">
                                    <strong>${item.title}</strong>
                                    <p>Quantity: ${item.quantity}</p>
                                </div>
                                <div class="dropdown-divider"></div>
                            `;
                        });
                        cartCount.textContent = data.totalQuantity;
                    } else {
                        cartItems.innerHTML = '<p class="text-center">Your cart is empty.</p>';
                        cartCount.textContent = '0';
                    }
                })
                .catch(error => console.error('Error fetching cart items:', error));
        }

        // Load cart items initially and on dropdown toggle
        loadCartItems();
        document.getElementById('cartDropdown').addEventListener('click', loadCartItems);
    });
</script>