<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login | Kenko Life</title>

<style>
/* ================= CSS VARIABLES ================= */
:root {
  --accent: #ff7b00;
  --accent-2: #ff9a36;
  --text: #ffffff;
  --muted: rgba(255,255,255,0.7);
  --glass-bg: rgba(255,255,255,0.08);
  --glass-border: rgba(255,255,255,0.14);
  --radius: 22px;
  --shadow: 0 18px 50px rgba(0,0,0,0.55);
  --blur: blur(14px);
  font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, Arial;
  color-scheme: dark;
}

/* ================= RESET ================= */
* { box-sizing: border-box; margin: 0; padding: 0; }
html, body { height: 100%; }

/* ================= BACKGROUND SLIDESHOW ================= */
body {
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--text);
  overflow: hidden;
}

body::before {
  content: "";
  position: fixed;
  inset: 0;
  background-size: cover;
  background-position: center;
  animation: slideshow 18s infinite;
  z-index: -2;
}

body::after {
  content: "";
  position: fixed;
  inset: 0;
  background: rgba(10,10,12,0.55);
  backdrop-filter: blur(6px);
  z-index: -1;
}

@keyframes slideshow {
  0%   { background-image: url("assets/images/fit2.jpg"); }
  33%  { background-image: url("assets/images/gympic4.jpeg"); }
  66%  { background-image: url("assets/images/gympic5.jpeg"); }
  100% { background-image: url("assets/images/fit2.jpg"); }
}

/* Reduce motion */
@media (prefers-reduced-motion: reduce) {
  body::before {
    animation: none;
    background-image: url("assets/images/login-bg-1.jpg");
  }
}

/* ================= LOGIN CARD ================= */
main {
  width: min(420px, 92vw);
  padding: 40px;
  background: linear-gradient(
    180deg,
    rgba(255,255,255,0.10),
    rgba(255,255,255,0.04)
  );
  border-radius: var(--radius);
  border: 1px solid var(--glass-border);
  box-shadow: var(--shadow);
  backdrop-filter: var(--blur);
}

h1 {
  text-align: center;
  margin-bottom: 26px;
  font-size: 28px;
  font-weight: 700;
}

/* ================= FORM ================= */
form label {
  display: block;
  margin-bottom: 14px;
}

input {
  width: 100%;
  padding: 15px 16px;
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,0.15);
  background: rgba(255,255,255,0.05);
  color: #fff;
  font-size: 15px;
  outline: none;
}

input:focus {
  border-color: var(--accent);
  box-shadow: 0 0 0 3px rgba(255,123,0,0.25);
}

.actions {
  display: flex;
  justify-content: flex-end;
  margin: 6px 0 14px;
}

.actions a {
  color: var(--accent-2);
  font-size: 13px;
  text-decoration: none;
  font-weight: 600;
}

button {
  width: 100%;
  padding: 15px;
  border-radius: 14px;
  border: none;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
  color: #fff;
  background: linear-gradient(90deg, var(--accent), var(--accent-2));
  box-shadow: 0 12px 30px rgba(255,120,0,0.35);
  transition: transform .15s ease, box-shadow .15s ease;
}

button:hover {
  transform: translateY(-2px);
  box-shadow: 0 18px 40px rgba(255,120,0,0.45);
}

/* ================= DIVIDER ================= */
.divider {
  margin: 22px 0;
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 14px;
  color: var(--muted);
}

.divider::before,
.divider::after {
  content: "";
  flex: 1;
  height: 1px;
  background: rgba(255,255,255,0.15);
}

/* ================= SOCIAL ================= */
.social {
  display: flex;
  gap: 14px;
  justify-content: center;
}

.social button {
  width: 56px;
  height: 48px;
  border-radius: 12px;
  background: rgba(255,255,255,0.08);
  border: 1px solid rgba(255,255,255,0.15);
  color: #fff;
  font-weight: 700;
}

/* ================= FOOTER TEXT ================= */
.signup {
  margin-top: 22px;
  text-align: center;
  font-size: 14px;
  color: var(--muted);
}

.signup a {
  color: var(--accent-2);
  font-weight: 600;
  text-decoration: none;
}

/* ================= MOBILE ================= */
@media (max-width: 480px) {
  main { padding: 26px; }
  h1 { font-size: 22px; }
}
</style>
</head>

<body>

<main role="main" aria-labelledby="login-title">
  <h1 id="login-title">Sign in to Kenko Life</h1>

  <form action="php/login.php" method="POST" novalidate>
    <label>
      <input type="email" name="email" placeholder="Email address" required autocomplete="username">
    </label>

    <label>
      <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
    </label>

    <div class="actions">
      <a href="forgot.php">Forgot password?</a>
    </div>

    <button type="submit">Login</button>

    <div class="divider">or</div>

    <!-- Minimal Social Mockup -->
    <div class="social" style="opacity:0.5; pointer-events:none;">
       <button type="button">G</button>
       <button type="button">f</button>
    </div>

    <div class="signup">
      Don’t have an account?
      <a href="register.php">Create one</a>
    </div>
  </form>
</main>

<script>
// Toggle Password
const togglePw = document.createElement('span');
togglePw.innerHTML = '👁️';
togglePw.style.cssText = 'position:absolute; right:15px; top:42px; cursor:pointer; font-size:18px; color:rgba(255,255,255,0.7);';
const pwInput = document.querySelector('input[name="password"]');
pwInput.parentElement.style.position = 'relative';
pwInput.parentElement.appendChild(togglePw);

togglePw.addEventListener('click', () => {
    pwInput.type = pwInput.type === 'password' ? 'text' : 'password';
});
</script>

</body>
</html>
