<style>
/* Footer Base */
#footer {
    background: linear-gradient(135deg, #0a192f 0%, #112240 50%, #1a365d 100%);
    color: #fff;
    padding: 70px 0 25px;
    margin-top: 60px;
    position: relative;
    overflow: hidden;
}

/* Gradient Top Border */
#footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, #00eaff, #0080ff, #00eaff);
    background-size: 200% auto;
    animation: gradientBorder 3s linear infinite;
}

@keyframes gradientBorder {
    0% { background-position: 0% 50%; }
    100% { background-position: 200% 50%; }
}

/* Headings */
#footer h5 {
    font-weight: 700;
    font-size: 18px;
    margin-bottom: 25px;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #00eaff;
    position: relative;
    display: inline-block;
}

#footer h5::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -8px;
    width: 40px;
    height: 3px;
    background: #0080ff;
    border-radius: 2px;
    transition: width 0.3s ease;
}

#footer:hover h5::after {
    width: 100%;
}

/* Text */
#footer p {
    color: rgba(255, 255, 255, 0.7);
    font-size: 14px;
    line-height: 1.8;
}

/* Links */
#footer a {
    color: rgba(255, 255, 255, 0.7);
    display: block;
    margin-bottom: 12px;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 14px;
    position: relative;
}

#footer a:hover {
    color: #ffffff;
    padding-left: 10px;
    text-shadow: 0 0 8px rgba(0, 234, 255, 0.6);
}

.quick-links a::before {
    content: '\f105'; /* FontAwesome right arrow */
    font-family: 'FontAwesome';
    position: absolute;
    left: -15px;
    opacity: 0;
    color: #00eaff;
    transition: left 0.3s ease, opacity 0.3s ease;
}

.quick-links a:hover::before {
    left: 0;
    opacity: 1;
}

.quick-links a:hover {
    padding-left: 20px;
}

/* Social Icons */
.social-icons a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05);
    margin-right: 12px;
    font-size: 18px;
    color: #fff;
    transition: all 0.3s ease;
    padding: 0;
}

.social-icons a:hover {
    background: #00eaff;
    color: #0a192f;
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 234, 255, 0.3);
    padding: 0;
}

.social-icons a::before {
    content: none !important;
}

/* Divider */
.footer-divider {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    margin: 40px 0 25px;
}

/* Bottom text */
.footer-bottom {
    text-align: center;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.6);
    letter-spacing: 0.5px;
}

/* Animation */
#footer {
    animation: fadeInUp 1s ease forwards;
    opacity: 0;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<!-- Footer -->
<section id="footer">
    <div class="container">
        <div class="row">

            <!-- About -->
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <h5>About</h5>
                <p>
                    A modern MCQ-based online examination system designed for seamless testing,
                    real-time performance tracking, and efficient learning. Explore your potential
                    with our interactive platform.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0 quick-links">
                <h5>Quick Links</h5>
                <a href="index.php">Home</a>
                <a href="register.php">Register</a>
                <a href="admin/">Admin Panel</a>
            </div>

            <!-- Contact -->
            <div class="col-lg-4 col-md-12">
                <h5>Contact</h5>
                <p><i class="fa fa-envelope mr-2"></i> aamirshaikh5176@gmail.com</p>
                <p><i class="fa fa-phone mr-2"></i> +91 8265085176</p>

                <!-- Social Icons -->
                <div class="social-icons mt-4">
                    <a href="https://github.com/AamirShaikh5176" target="_blank" title="GitHub">
                        <i class="fa fa-github"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/aamirshaikh5176/" target="_blank" title="LinkedIn">
                        <i class="fa fa-linkedin"></i>
                    </a>
                </div>
            </div>

        </div>

        <div class="footer-divider"></div>

        <div class="footer-bottom">
            &copy; 2026 Online Examination System. Designed by Aamir Shaikh
        </div>
    </div>
</section>

<!-- Scripts -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>