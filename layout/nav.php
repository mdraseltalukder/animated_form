<?php 

    define('BASE_URL', 'http://localhost/dashboard/Projects/Udemi/loginForm/animated_form/');
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Static Navbar</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <style>
      
      /* Navbar Styles */
      .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background: rgba(34, 34, 34, 0.95);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 2000;
        padding: 15px 0;
        animation: animate 4s linear infinite;
      }

      @keyframes animate {
        0% {
          filter: hue-rotate(0deg);
        }
        100% {
          filter: hue-rotate(360deg);
        }
      }

      .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
      }

      /* Logo Styles */
      .logo {
        font-size: 1.8em;
        font-weight: 700;
        color: #0f0;
        text-decoration: none;
        text-transform: uppercase;
        letter-spacing: 2px;
        animation: animate 4s linear infinite;
        transition: all 0.3s ease;
      }

      .logo:hover {
        transform: scale(1.05);
        text-shadow: 0 0 20px #00ff00;
      }

      /* Navigation Links */
      .nav-links {
        display: flex;
        list-style: none;
        gap: 30px;
        align-items: center;
      }

      .nav-links li {
        position: relative;
      }

      .nav-links a {
        color: #fff;
        text-decoration: none;
        font-weight: 500;
        font-size: 1em;
        padding: 10px 20px;
        border-radius: 25px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
      }


      .nav-links a:hover {
        color: #0f0;
        background: rgba(0, 255, 0, 0.1);
        box-shadow: 0 0 15px rgba(0, 255, 0, 0.3);
        transform: translateY(-2px);
      }

      /* Special styling for Sign In and Sign Up buttons */
      .nav-links .signin-btn {
        background: rgba(0, 255, 0, 0.1);
        border: 1px solid #0f0;
        color: #0f0;
      }

      .nav-links .signin-btn:hover {
        background: #0f0;
        color: #000;
        box-shadow: 0 0 20px #00ff00;
      }

      .nav-links .signup-btn {
        background: #0f0;
        color: #000;
        font-weight: 600;
        animation: animate 4s linear infinite;
      }

      .nav-links .signup-btn:hover {
        background: #00cc00;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 0 25px #00ff00;
      }

      .nav-links .logout-btn {
        background: rgba(255, 0, 0, 0.1);
        border: 1px solid #ff0000;
        color: #ff0000;
      }

      .nav-links .logout-btn:hover {
        background: #ff0000;
        color: #fff;
        box-shadow: 0 0 20px #ff0000;
      }

      /* Mobile Menu Toggle */
      .mobile-toggle {
        display: none;
        flex-direction: column;
        cursor: pointer;
        gap: 4px;
      }

      .mobile-toggle span {
        width: 25px;
        height: 3px;
        background: #0f0;
        transition: all 0.3s ease;
        border-radius: 2px;
      }

      .mobile-toggle.active span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
      }

      .mobile-toggle.active span:nth-child(2) {
        opacity: 0;
      }

      .mobile-toggle.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -6px);
      }

      /* Mobile Responsive */
      @media (max-width: 768px) {
        body {
          padding-top: 70px; /* Adjust for smaller navbar on mobile */
        }

        .nav-links {
          position: fixed;
          top: 70px;
          right: -120%;
          width: 100%;
          height: calc(100vh - 70px);
          background: rgba(34, 34, 34, 0.98);
          flex-direction: column;
          justify-content: flex-start;
          align-items: center;
          padding-top: 50px;
          transition: all 0.3s ease;
          backdrop-filter: blur(10px);
        }

        .nav-links.active {
          right: 0;
        }

        .nav-links li {
          margin: 10px 0;
        }

        .nav-links a {
          font-size: 1.2em;
          padding: 15px 30px;
        }

        .mobile-toggle {
          display: flex;
        }

        .nav-container {
          padding: 0 15px;
        }

        .logo {
          font-size: 1.5em;
        }
      }

      /* Main Content Area - This won't be affected by navbar */
      .main-content {
        position: relative;
        z-index: 1;
        min-height: calc(100vh - 80px);
      }

      /* Demo Content */
      .content {
        padding: 50px 20px;
        text-align: center;
        color: #fff;
      }

      .content h1 {
        font-size: 3em;
        color: #0f0;
        animation: animate 4s linear infinite;
        margin-bottom: 20px;
      }

      .content p {
        font-size: 1.2em;
        max-width: 600px;
        margin: 0 auto 30px;
        line-height: 1.6;
      }

      .content-section {
        margin: 100px 0;
        padding: 50px 20px;
        background: rgba(34, 34, 34, 0.3);
        border-radius: 20px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
      }

      .content-section h2 {
        color: #0f0;
        font-size: 2em;
        margin-bottom: 20px;
      }

      /* Login/Signup Form Container */
      .form-container {
        position: relative;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
      }

      /* Hexagon Background for forms */
      .hexagon-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        animation: animate 4s linear infinite;
      }

      .row {
        display: inline-flex;
        margin-left: -50px;
        margin-top: -32px;
        overflow: hidden;
      }

      .row:nth-child(even) {
        margin-left: 1px;
      }

      .hexagon {
        position: relative;
        height: 110px;
        width: 100px;
        background: #111;
        margin: 1px;
        clip-path: polygon(
          50% 0%,
          100% 25%,
          100% 75%,
          50% 100%,
          0% 75%,
          0% 25%
        );
        transition: all 0.3s ease;
        cursor: pointer;
      }

      

    
    </style>
  </head>
  <body>
    <!-- Static Navbar -->
    <nav class="navbar">
      <div class="nav-container">
        <!-- Logo -->
        <a href="<?= BASE_URL ?>" class="logo">HexaAuth</a>
        
        <!-- Navigation Links -->
        <ul class="nav-links" id="navLinks">
          <li><a href="<?= BASE_URL ?>">Home</a></li>


<?php if(!isset($_SESSION['user'])){?>
          <li><a href="<?= BASE_URL ?>signin.php" class="signin-btn">Sign In</a></li>
          <li><a href="<?= BASE_URL ?>signup.php" class="signup-btn">Sign Up</a></li>
<?php }else{?>
          <li><a href="<?= BASE_URL ?>logout.php" class="logout-php">Logout</a></li>
          <?php }?>
        </ul>

        <!-- Mobile Menu Toggle -->
        <div class="mobile-toggle" id="mobileToggle">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </nav>


    <script>
      // Mobile menu toggle functionality
      const mobileToggle = document.getElementById('mobileToggle');
      const navLinks = document.getElementById('navLinks');

      mobileToggle.addEventListener('click', () => {
        mobileToggle.classList.toggle('active');
        navLinks.classList.toggle('active');
      });

      // Close mobile menu when clicking on a link
      const navLinkItems = document.querySelectorAll('.nav-links a');
      navLinkItems.forEach(link => {
        link.addEventListener('click', () => {
          mobileToggle.classList.remove('active');
          navLinks.classList.remove('active');
        });
      });

      // Close mobile menu when clicking outside
      document.addEventListener('click', (e) => {
        if (!mobileToggle.contains(e.target) && !navLinks.contains(e.target)) {
          mobileToggle.classList.remove('active');
          navLinks.classList.remove('active');
        }
      });

      // Smooth scrolling for anchor links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        });
      });
    </script>
  </body>
</html>