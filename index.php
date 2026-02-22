<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kenko Life | Track Better. Live Stronger.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- External CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Scroll Animations -->
    <script src="assets/js/scroll.js" defer></script>
</head>
<body>

<!-- HERO -->
<section class="hero" style="
    background:
        linear-gradient(rgba(0,0,0,.65), rgba(0,0,0,.65)),
        url('assets/images/gympic3.jpeg') center/cover no-repeat;
">
    <div class="reveal">
        <img src="assets/images/kenko_logo.png" alt="Kenko Life Logo" style="width:120px;margin-bottom:20px;">
        <h1>Kenko Life</h1>
        <p>Track Better. Live Stronger.</p>

        <a href="login.php" class="btn btn-primary">Member Login</a>
        <a href="register.php" class="btn btn-light">Join Now</a><br>
        <a href="admin_landing.php" class="btn btn-outline">Admin / Trainer Portal</a>
    </div>
</section>

<!-- QUOTES -->
<section class="quotes reveal">
    <h2>Stay Motivated</h2>
    <div class="quote">“Your body achieves what your mind believes.”</div>
    <div class="quote">“Small progress is still progress.”</div>
</section>

<!-- LIFESTYLE / BALANCE IMAGE -->
<section class="reveal" style="padding:0;">
    <div style="
        height:70vh;
        background:
            linear-gradient(rgba(0,0,0,.4), rgba(0,0,0,.4)),
            url('assets/images/gympic2.jpeg') center/cover no-repeat;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#fff;
        text-align:center;
    ">
        <h2 style="font-size:2.5rem;">
            Balanced Fitness Through Training & Nutrition
        </h2>
    </div>
</section>

<!-- FEATURES -->
<section class="reveal">
    <div class="section-title">
        <h2>Features</h2>
        <p>Everything you need in one place</p>
    </div>

    <div class="features">
        <img src="assets/images/healthy_food_new.jpg" alt="Healthy Food">

        <ul>
            <li>🏋️ Workout Tracking</li>
            <li>🥗 Nutrition Monitoring</li>
            <li>📊 BMI & Progress Charts</li>
            <li>🔥 Fitness Motivation</li>
        </ul>
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="testimonials reveal">
    <div class="section-title">
        <h2>User Feedback</h2>
    </div>

    <div class="testimonial-grid">
        <div class="card">“Lost 8kg in 4 months using Kenko Life.”</div>
        <div class="card">“Simple UI and powerful tracking tools.”</div>
        <div class="card">“Keeps me disciplined every day.”</div>
    </div>
</section>

<!-- CTA -->
<section class="cta reveal">
    <h2>Start Your Fitness Journey Today</h2>
    <a href="register.php" class="btn btn-light">Join Now</a>
</section>

<!-- FOOTER -->
<footer style="background:#111;color:#aaa;text-align:center;padding:20px;">
    © <?php echo date("Y"); ?> Kenko Life • Fitness Tracker
</footer>

</body>
</html>
