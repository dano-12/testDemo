  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>TMC</title>
      <link rel="stylesheet" href="style/styles.css">
  </head>

  <body>
  <header>
      <div class="overlay"></div>
      <img id = "logo"src="assets/logo/logo.png" alt="">
      <div class="companyName">
          <h2>TOYO METAL CRAFT</h2>
      </div>
      <div class="off-screen-menu">
          <ul class = "sections">
              <li><a  class="active"href=""><img src="assets/icons/home.png"alt=""><span>Home</span></a></li>
              <li><a href="aboutUs.php"><img src="assets\icons\info.png"alt=""><span>About us</span></a></li>
              <li><a href="finished-project.php"><img src="assets\icons\fprojects.png"alt=""><span>Finished Projects</span></a></li>
              <li><a href="product-list.php"><img src="assets\icons\products.png"alt=""><span>Product list</span></a></li>
              <li><a href="contact-us.php"><img src="assets\icons\contactUs.png"alt=""><span>Contact us</span></a></li>
          </ul>      
      </div>
      <nav>
          <div class="ham-menu">
              <span></span>
              <span></span>
              <span></span>
          </div>
      </nav>
  </header>
  <section class="carouselSection">
    <div class="carousel">
      <button class="carousel-button prev">&lt;</button>
      <div class="carousel-track-container">
        <ul class="carousel-track">
          <li class="carousel-slide">
            <img src="assets/dsa.jfif" alt="dsa">
            <h1>Finished Project</h1>
            <a href="aboutUs.php" class="slide-button">SEE THEM</a>
          </li>
          <li class="carousel-slide">
            <img src="assets/dasa.jfif" alt="dasa">
            <h1>Products</h1>
            <a href="#" class="slide-button">Go Now</a>
          </li>
          <li class="carousel-slide">
            <img src="assets/cat.jfif" alt="cat">
            <h1>Contact us</h1>
            <a href="#" class="slide-button">Go Now</a>
          </li> 
          <li class="carousel-slide">
            <img src="assets/tat.jfif" alt="tat">
            <h1>Finished Project</h1>
            <a href="#" class="slide-button">Go Now</a>
          </li>
        </ul>
      </div>
      <button class="carousel-button next">&gt;</button>
    </div>
  </section>
  <script src = "scripts/carousel.js"></script>
  <script src="scripts/menu-toggle.js"></script>
  <footer>
    <div class="footer-container">
            <div class="footer-column-footer-nav">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Finished Projects</a></li>
                    <li><a href="#">Product List</a></li>
                    <li><a href="#">Contact us</a></li>
                </ul>
            </div>
        <div class="footer-column-footer-contact">
            <p>0917 140 8929</p>
            <p>222 don basilio bautista danpalit, Malabon,<br> Philippines</p>
        </div>
        <div class="footer-column-footer-logo">
            <img src="assets/logo/logo.png" alt="TMC Logo">
            <p>Toyo Metal Craft</p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2025 TMC All right reserved</p>
    </div>
</footer>
</body>
</html>