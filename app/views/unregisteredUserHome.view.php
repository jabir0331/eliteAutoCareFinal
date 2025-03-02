<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel = "stylesheet" href = "<?= CSS ?>/index.css">
    <link rel = "icon" href = "<?= IMAGES ?>/logo.webp">
    <title>Elite Auto Care - Modern Car Service</title>
    <style>
        .error{
            color: red;
            font-size: 0.9em;
            text-align: left;
        }    
    </style>
</head>

<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="<?= IMAGES ?>/logo.webp" alt="Logo">
                <span>Elite Auto Care</span>
            </div>
            <button class="mobile-menu-btn" aria-label="Toggle menu">
                <i class="fas fa-bars"></i>
            </button>
            <nav>
                <a href="<?= ROOT ?>/RegisteredUserHome">Home</a>
                <a href="#about">About Us</a>
                <a href="#services">Our Services</a>
                <a href="#how-it-works">How It Works</a>
                <a href="https://wa.me/94715770109" target="_blank">Contact Us</a>
            </nav>
        </div>
    </header>

    <!-- Mobile Navigation -->
    <div class="mobile-nav">
        <a href="<?= ROOT ?>/Home">Home</a>
        <a href="#about">About Us</a>
        <a href="#services">Our Services</a>
        <a href="#how-it-works">How It Works</a>
        <a href="https://wa.me/94715770109" target="_blank">Contact Us</a>
    </div>
    <div class="overlay"></div>

    <section class="hero">
        <div class="hero-container">
            <div>
                <h1>Expert Car Care at Your Fingertips</h1>
                <p>Experience seamless car maintenance with our AI-powered booking system. Professional service,
                    transparent pricing, and convenience - all in one place.</p>
                <div class="button-group">
                    <a href="#" class="button button-primary" style="width: 100%;">
                        Get Started
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <img src="<?= IMAGES ?>/heroSection.jpg" alt="Car Service" class="hero-image">
        </div>
    </section>

    <section id="about" class="about">
        <div class="about-container">
            <div class="about-logo">
                <img src="<?= IMAGES ?>/logo.webp" alt="Elite Auto Care Logo">
                <h3>Elite Auto Care</h3>
                <p>Established 2020</p>
            </div>
            <div class="about-content">
                <div class="section-header" style="margin-bottom: 2rem;">
                    <h2>About Us</h2>
                    <p>Your Trusted Partner in Automotive Excellence</p>
                </div>
                <p>At Elite Auto Care, we've revolutionized the way car maintenance is done. Founded in 2020, we combine
                    cutting-edge technology with expert craftsmanship to deliver unparalleled automotive care. Our team
                    of certified technicians brings decades of combined experience, ensuring your vehicle receives the
                    highest standard of service. We pride ourselves on transparency, reliability, and customer
                    satisfaction, utilizing advanced diagnostics and genuine parts to keep your car performing at its
                    best. Whether it's routine maintenance or complex repairs, we're committed to providing convenient,
                    professional, and affordable solutions tailored to your needs.</p>
            </div>
        </div>
    </section>

    <section id="services" class="services">
        <div class="section-header">
            <h2>Our Services</h2>
            <p>Comprehensive car care solutions tailored to your needs</p>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <i class="fas fa-cogs"></i>
                <h3>Smart Diagnostics</h3>
                <p>Advanced computer diagnostics to identify and resolve issues quickly and accurately.</p>
            </div>
            <div class="service-card">
                <i class="fas fa-tools"></i>
                <h3>Expert Repairs</h3>
                <p>Professional repairs by certified mechanics using state-of-the-art equipment.</p>
            </div>
            <div class="service-card">
                <i class="fas fa-clock"></i>
                <h3>Regular Maintenance</h3>
                <p>Scheduled maintenance services to keep your vehicle running at peak performance.</p>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="services">
        <div class="section-header">
            <h2>How It Works</h2>
            <p>Simple, transparent process for your convenience</p>
        </div>
        <div class="steps">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Book Online</h3>
                <p>Choose your service and preferred time slot through our easy booking system.</p>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <h3>Confirm Details</h3>
                <p>Receive instant confirmation and reminders for your appointment.</p>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <h3>Get Service</h3>
                <p>Enjoy professional service with real-time updates on your vehicle.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-container">
            <p>© 2025 Elite Auto Care. All rights reserved.</p>
            <div class="footer-links">
                <a href="https://maps.app.goo.gl/kpFb4depU5LB4zDR9"><i class="fa fa-location-arrow" aria-hidden="true"></i> Find Us</a>
                <a href="https://www.instagram.com/ucsc_lk/?hl=en"><i class="fab fa-instagram"></i> Instagram</a>
                <a href="https://www.facebook.com/UCSC.LK/" target="_blank"><i class="fab fa-facebook"></i> Facebook</a>
                <a href="https://wa.me/94715770109?text=Hello,%20I'm%20interested%20in%20your%20car%20service.%20Can%20you%20provide%20more%20details?" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
            </div>
        </div>
    </footer>

    <!--Popup modal for Signup-->
    <div class="modal" id="signupModal">
        <div class="modal-content">
            <button class="close-button" id="closeModal">
                <i class="fas fa-times"></i>
            </button>

            <div class="modal-header">
                <h2 class="text-2xl font-bold" id="modalTitle">Create Account</h2>
                <p class="text-secondary" id="modalSubtitle">Join Elite Auto Care for smart car maintenance</p>
            </div>

            <div class="modal-body">
                <form id="signupForm" method = "POST" action = "<?= ROOT ?>/Home/userSignup">
                    <!-- Step 1: Account Details -->
                    <div id="step1" class="step">
                        
                        <div class = "error">
                            <?php echo isset($data['errors']['email']) ? '* ' . $data['errors']['email'] : ''; ?>
                        </div>
                        <div class="form-group">
                            <i class="fas fa-envelope"></i>
                            <input type="email" class="form-input" placeholder="Email address" name = "email" required>
                        </div>

                        <div class = "error">
                            <?php echo isset($data['errors']['password']) ? '* ' . $data['errors']['password'] : ''; ?>
                        </div>
                        <div class="form-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" class="form-input" placeholder="Password" name = "password" required>
                        </div>

                        <div class = "error">
                            <?php echo isset($data['errors']['confirmPassword']) ? '* ' . $data['errors']['confirmPassword'] : ''; ?>
                        </div>
                        <div class="form-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" class="form-input" placeholder="Confirm password" name = "confirmPassword" required>
                        </div>

                        <button type="button" class="button button-primary" onclick="nextStep()">Continue</button>
                        <div class="signin-link">
                            Already have an account? <a href="#">Login</a>
                        </div>
                    </div>

                    <!-- Step 2: Car Details -->
                    <div id="step2" class="step" style="display: none;">
                        
                        <div class="error">
                            <?php echo isset($data['errors']['make']) ? '* ' . $data['errors']['make'] : ''; ?>
                        </div>
                        <div class="form-group">
                            <i class="fas fa-car"></i>
                            <input type="text" class="form-input" placeholder="Car Make (Eg: Toyota)" name = "make" required>
                        </div>

                        <div class="error">
                            <?php echo isset($data['errors']['model']) ? '* ' . $data['errors']['model'] : ''; ?>
                        </div>
                        <div class="form-group">
                            <i class="fas fa-car"></i>
                            <input type="text" class="form-input" placeholder="Car Model (Eg: Aqua)" name = "model" required>
                        </div>

                        <div class="error">
                            <?php echo isset($data['errors']['plate_number']) ? '* ' . $data['errors']['plate_number'] : ''; ?>
                        </div>
                        <div class="form-group">
                            <i class="fas fa-barcode"></i>
                            <input type="text" class="form-input" placeholder="Number Plate Num(Format: CAR-1234)" name = "plateNum" required>
                        </div>

                        <div style="display: grid;">
                            <button type="button" class="button button-primary" style="margin-bottom: 7.5px;" onclick="backStep()">Back</button>
                            <button type="submit" class="button button-primary">Complete Signup</button>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <div class="progress-dots">
                    <div class="dot active"></div>
                    <div class="dot"></div>
                </div>
            </div>
        </div>
    </div>

    <!--Popup modal for Login-->
    <div class="modal" id="loginModal">
        <div class="modal-content">
            <button class="close-button" id="closeLoginModal">
                <i class="fas fa-times"></i>
            </button>

            <div class="modal-header">
                <h2 class="text-2xl font-bold">Welcome Back</h2>
                <p class="text-secondary">Log in to your Elite Auto Care account</p>
            </div>

            <div class="modal-body">
                <form id="loginForm" method = "POST" action = "<?= ROOT ?>/Home/userLogin">
                    <div class="step">

                        <div class = "error">
                            <?php echo isset($data['errors']['user_error']) ? '* ' . $data['errors']['user_error'] : ''; ?>
                        </div>
                        <div class="form-group">
                            <i class="fas fa-envelope"></i>
                            <input type="email" class="form-input" placeholder="Email address" name = "emailForLogin" required>
                        </div>

                        <div class = "error">
                            <?php echo isset($data['errors']['password_error']) ? '* ' . $data['errors']['password_error'] : ''; ?>
                        </div>
                        <div class="form-group">
                            <i class="fas fa-lock"></i>
                            <input type="password" class="form-input" placeholder="Password" name = "passwordForLogin" required>
                        </div>
                        <button type="submit" class="button button-primary">Log In</button>
                        <div class="auth-switch">
                            Don't have an account? <a id="switchToSignup">Sign up</a>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>

    <!--Below scripted is included for mobile responsiveness related functionalities-->
    <script src = "<?= JS ?>/mobileNav.js"></script>

    <!--Script for the signup and login popup functionality-->
    <script src="<?= JS ?>/activeNav.js"></script>

    <!--Handle popup functionalities of the signup and login popups-->
    <script src="<?= JS ?>/index.js"></script>

    <?php
        if (!empty($data['errors'])) {
            
            if($data['errors']['errorType'] == 'signUpErrors'){

                if (isset($data['errors']['email']) || isset($data['errors']['password']) || isset($data['errors']['confirmPassword'])) {

                    echo    '<script>
                                signupModal.classList.add("active");
                                document.body.style.overflow = "hidden";
                            </script>';
                }
                else{
                    echo    '<script>
                                signupModal.classList.add("active");
                                step1.style.display = "none";
                                step2.style.display = "block";
                                modalTitle.textContent = "Car Details";
                                modalSubtitle.textContent = "Help us provide personalized service recommendations";

                                const newDots = document.querySelectorAll(".dot");
                                newDots[0].classList.remove("active");
                                newDots[1].classList.add("active");

                                document.body.style.overflow = "hidden";
                            </script>';
                }
            }
            else if($data['errors']['errorType'] == 'loginErrors'){
                echo '<script>
                        loginModal.classList.add("active");
                        document.body.style.overflow = "hidden";
                        
                    </script>';
            }
            
        }
        
    
        
    ?>
</body>

</html>