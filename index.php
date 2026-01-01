<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>FitTrack — Fitness Made Simple</title>

<style>
:root{
  --accent:#ff7b00;
  --accent2:#ff9a36;
  --glass:rgba(255,255,255,.08);
  --muted:rgba(255,255,255,.7);
  --radius:22px;
  --shadow:0 20px 60px rgba(0,0,0,.6);
  font-family:Inter,system-ui,Segoe UI,Roboto,Arial;
  color-scheme:dark;
}

*{box-sizing:border-box}
html,body{height:100%;margin:0}

body{
  background:url("images/fit2.jpg") center/cover no-repeat fixed;
  display:flex;
  flex-direction:column;
}

body::before{
  content:"";
  position:fixed;
  inset:0;
  background:rgba(12,10,12,.55);
  backdrop-filter:blur(6px);
  z-index:0;
}

/* NAVBAR */
.nav{
  position:relative;
  z-index:2;
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:18px 40px;
}

.logo{
  font-size:22px;
  font-weight:800;
  letter-spacing:.5px;
}

.nav a{
  margin-left:16px;
  text-decoration:none;
  color:#fff;
  font-weight:600;
}

.btn{
  padding:10px 18px;
  border-radius:12px;
  background:linear-gradient(90deg,var(--accent),var(--accent2));
  color:#fff;
  text-decoration:none;
  box-shadow:0 10px 30px rgba(255,120,0,.25);
}

/* HERO */
.hero{
  position:relative;
  z-index:2;
  flex:1;
  display:grid;
  grid-template-columns:1.1fr .9fr;
  gap:40px;
  align-items:center;
  padding:60px;
  max-width:1200px;
  margin:auto;
}

.hero-card{
  background:linear-gradient(180deg,rgba(255,255,255,.04),rgba(255,255,255,.02));
  border-radius:var(--radius);
  padding:48px;
  box-shadow:var(--shadow);
  border:1px solid rgba(255,255,255,.08);
  backdrop-filter:blur(14px);
}

.hero h1{
  font-size:42px;
  margin:0 0 14px;
}

.hero p{
  color:var(--muted);
  font-size:17px;
  line-height:1.6;
}

.hero-actions{
  margin-top:28px;
  display:flex;
  gap:16px;
}

.btn-outline{
  padding:10px 18px;
  border-radius:12px;
  border:1px solid rgba(255,255,255,.2);
  color:#fff;
  text-decoration:none;
}

/* ILLUSTRATION */
.illustration{
  text-align:center;
}

.illustration img{
  max-width:100%;
  filter:drop-shadow(0 20px 50px rgba(0,0,0,.7));
}

/* FOOTER */
.footer{
  position:relative;
  z-index:2;
  text-align:center;
  padding:16px;
  font-size:13px;
  color:var(--muted);
}

/* MOBILE */
@media(max-width:900px){
  .hero{
    grid-template-columns:1fr;
    padding:30px;
    text-align:center;
  }
  .hero-actions{justify-content:center}
}
</style>
</head>

<body>

<!-- NAV -->
<header class="nav">
  <div class="logo">🏋️ FitTrack</div>
  <div>
    <a href="login.php">Login</a>
    <a href="register.php" class="btn">Get Started</a>
  </div>
</header>

<!-- HERO -->
<section class="hero">

  <div class="hero-card">
    <h1>Fitness, Simplified.</h1>
    <p>
      Track workouts, calories, body metrics, and progress —
      all in one beautiful dashboard built for consistency and results.
    </p>

    <div class="hero-actions">
      <a href="register.php" class="btn">Create Free Account</a>
      <a href="login.php" class="btn-outline">Login</a>
    </div>
  </div>

  

</section>

<!-- FOOTER -->
<footer class="footer">
  © <?php echo date("Y"); ?> FitTrack • Built for growth 💪
</footer>

</body>
</html>
