<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
<section class="login-section">
        <div class="login-container">
                   <form class="login-form">
                            <div class="login-header">
                                <h2>Admin Login</h2>
                            </div>
                    
                        <div class="form-group">
                            <input type="email"id="email" name="email" placeholder=""required/>
                            <label for="email">Email</label>
                            <span class="icon" aria-hidden="true">
                                <img src="assets/icons/email.png" alt="">
                            </span>
                        </div>
                        <div class="form-group">
                            <input type="password" id="password"name="password" placeholder="" required/>
                            <label for="password">Password</label>
                            <span class="icon" aria-hidden="true">
                                <img src="assets/icons/password.png" alt="">
                            </span>
                        </div>
                        <div class="remember-container">
                            <div class="remember-me">
                                <input type="checkbox" id="remember" name="remember" />
                                <label for="remember">Remember me</label>
                            </div>
                        </div>
                        <button type="submit">LOGIN</button>
                  </form>
        </div>
</section>

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