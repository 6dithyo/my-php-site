<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Login — FitTrack</title>

<style>
  :root{
    --accent: #ff7b00;
    --accent-2: #ff9a36;
    --glass: rgba(255,255,255,0.08);
    --glass-strong: rgba(255,255,255,0.12);
    --muted: rgba(255,255,255,0.7);
    --card-radius: 22px;
    --shadow: 0 12px 40px rgba(0,0,0,0.55);
    color-scheme: dark;
    font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
  }

  /* Fullscreen background using your uploaded screenshot path */
  html,body{height:100%;margin:0}
  body{
    background:url('C:/xampp/htdocs/fitness_tracker/images/fit2.jpg') center/cover no-repeat fixed;
    display:flex;
    align-items:center;
    justify-content:center;
  }

  /* dark overlay + blur for legibility */
  body::before{
    content:"";
    position:fixed;inset:0;
    background: rgba(12,10,12,0.44);
    backdrop-filter: blur(6px) saturate(120%);
    z-index:0;
  }

  /* center card */
  .card {
    position:relative;
    z-index:2;
    width: min(720px, 92vw);
    max-width:720px;
    padding: 42px 44px;
    border-radius: var(--card-radius);
    background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.03));
    box-shadow: var(--shadow);
    border: 1px solid rgba(255,255,255,0.06);
    backdrop-filter: blur(12px) saturate(120%);
    color: #fff;
  }

  h1{
    margin: 0 0 22px 0;
    text-align:center;
    font-size:28px;
    letter-spacing:0.6px;
    font-weight:700;
    color: #fff;
  }

  .form-row{display:block}
  .input {
    width:100%;
    padding:16px 18px;
    margin: 10px 0;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.06);
    background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.02));
    color: #fff;
    outline:none;
    font-size:15px;
    transition: box-shadow 0.15s, transform 0.12s;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.02);
  }
  .input:focus{
    box-shadow: 0 6px 18px rgba(0,0,0,0.5), 0 0 0 4px rgba(255,123,0,0.08);
    transform: translateY(-2px);
  }
  .small {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:6px;
    font-size:13px;
    color: var(--muted);
  }
  .forgot { color: #ffb86b; text-decoration:none; font-weight:600 }
  .cta {
    margin-top:18px;
    width:100%;
    padding:16px;
    border-radius:12px;
    background: linear-gradient(90deg,var(--accent),var(--accent-2));
    color:#fff;
    border:none;
    font-weight:700;
    font-size:16px;
    cursor:pointer;
    box-shadow: 0 8px 24px rgba(255,110,0,0.18);
    transition: transform .12s ease, box-shadow .12s ease;
  }
  .cta:hover{ transform: translateY(-3px); box-shadow: 0 14px 40px rgba(255,110,0,0.24) }

  .divider {
    margin:22px 0;
    display:flex;
    align-items:center;
    gap:12px;
    color: rgba(255,255,255,0.8);
    font-size:14px;
  }
  .divider::before, .divider::after{
    content:"";
    flex:1;
    height:1px;
    background: rgba(255,255,255,0.06);
  }

  .social {
    display:flex;
    gap:18px;
    justify-content:center;
    margin-top:12px;
  }
  .social button {
    width:70px; height:52px;
    border-radius:12px;
    border:1px solid rgba(255,255,255,0.08);
    background: rgba(255,255,255,0.03);
    color:#fff;
    font-weight:700;
    cursor:pointer;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.02);
    transition: transform .12s, background .12s;
  }
  .social button:hover { transform: translateY(-4px); background: rgba(255,255,255,0.06) }

  /* small screens */
  @media (max-width:520px){
    .card { padding: 28px 20px; border-radius: 16px; width:92vw }
    h1{ font-size:22px }
    .social button{ width:56px; height:44px }
  }
</style>
</head>
<body>

  <main class="card" role="main" aria-labelledby="signin">
    <h1 id="signin">Sign in with Email</h1>

    <form class="form" action="php/login.php" method="POST" novalidate>
      <label class="form-row">
        <input class="input" name="email" type="email" placeholder="Username or Email" required autocomplete="username" />
      </label>

      <label class="form-row">
        <input class="input" name="password" type="password" placeholder="Password" required autocomplete="current-password" />
      </label>

      <div class="small">
        <span></span>
        <a class="forgot" href="forgot.php">Forgot password?</a>

      </div>

      <button class="cta" type="submit">Login</button>

      <div class="divider">Or sign in with</div>

      <div class="social" aria-hidden="false">
        <button type="button" title="Google">G</button>
        <button type="button" title="Facebook">f</button>
        <button type="button" title="Apple"></button>
      </div>

      <div class="signup-text" style="text-align:center; margin-top:20px; font-size:14px; color:var(--muted);">
    Don't have an account?
    <a href="register.php" style="color:#ffb86b; font-weight:600; text-decoration:none;">
        Create one
    </a>
</div>

    </form>
  </main>

</body>
</html>
