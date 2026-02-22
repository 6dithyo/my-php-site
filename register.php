<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register | Kenko Life</title>

<style>
:root {
  --accent: #ff7b00;
  --accent-2: #ff9a36;
  --muted: rgba(255,255,255,0.7);
  --radius: 22px;
  --shadow: 0 18px 50px rgba(0,0,0,0.55);
  font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, Arial;
  color-scheme: dark;
}

* { box-sizing: border-box; margin: 0; padding: 0; }
html, body { height: 100%; }

/* Background slideshow */
body {
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  color: #fff;
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
  0%   { background-image: url("assets/images/login-bg-1.jpg"); }
  33%  { background-image: url("assets/images/login-bg-2.jpg"); }
  66%  { background-image: url("assets/images/login-bg-3.jpg"); }
  100% { background-image: url("assets/images/login-bg-1.jpg"); }
}

@media (prefers-reduced-motion: reduce) {
  body::before { animation: none; }
}

/* Card */
main {
  width: min(520px, 92vw);
  padding: 40px;
  background: linear-gradient(
    180deg,
    rgba(255,255,255,0.10),
    rgba(255,255,255,0.04)
  );
  border-radius: var(--radius);
  border: 1px solid rgba(255,255,255,0.14);
  box-shadow: var(--shadow);
  backdrop-filter: blur(14px);
}

h1 {
  text-align: center;
  margin-bottom: 24px;
  font-size: 28px;
}

label {
  display: block;
  margin-bottom: 14px;
}

input {
  width: 100%;
  padding: 15px 16px;
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,0.15);
  background: rgba(0,0,0,0.45);
  color: #fff;
  font-size: 15px;
}

input::placeholder {
  color: rgba(255,255,255,0.75);
}

input:focus {
  border-color: var(--accent);
  box-shadow: 0 0 0 3px rgba(255,123,0,0.25);
  outline: none;
}

/* Password toggle */
.password-wrap {
  position: relative;
}

.toggle-password {
  position: absolute;
  right: 14px;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  color: var(--accent-2);
  cursor: pointer;
  font-size: 13px;
}

/* Height / Weight */
.row {
  display: flex;
  gap: 14px;
}

/* Button */
button {
  width: 100%;
  padding: 16px;
  margin-top: 18px;
  border-radius: 14px;
  border: none;
  font-size: 16px;
  font-weight: 700;
  cursor: pointer;
  color: #fff;
  background: linear-gradient(90deg, var(--accent), var(--accent-2));
}

/* Footer */
.footer {
  margin-top: 20px;
  text-align: center;
  font-size: 14px;
  color: var(--muted);
}

.footer a {
  color: var(--accent-2);
  font-weight: 600;
  text-decoration: none;
}

@media (max-width: 480px) {
  main { padding: 26px; }
  .row { flex-direction: column; }
}
</style>
</head>

<body>

<main>
  <h1>Create Your Account</h1>

  <form action="php/register.php" method="POST" novalidate>

    <label>
      <input type="text" name="username" placeholder="Username" required>
    </label>

    <label>
      <input type="email" name="email" placeholder="Email address" required>
    </label>

    <label class="password-wrap">
      <input id="password" type="password" name="password" placeholder="Password" required>
      <button type="button" class="toggle-password" id="toggle-password">Show</button>
    </label>

    <div class="row">
      <label>
        <input type="number" name="height" placeholder="Height (cm)" required>
      </label>
      <label>
        <input type="number" name="weight" placeholder="Weight (kg)" required>
      </label>
    </div>

    <!-- DOB Removed -->

    <!-- Trainer Code (Optional) -->
    <label>
      <input type="text" name="trainer_code" placeholder="Trainer Code (Optional)">
      <small style="color:var(--muted); font-size:12px;">Enter your trainer's code if you have one.</small>
    </label>

    <button type="submit">Register</button>


    <div class="footer">
      Already have an account? <a href="login.php">Login</a>
    </div>

  </form>
</main>

<script>
const toggle = document.getElementById("toggle-password");
const password = document.getElementById("password");

toggle.addEventListener("click", () => {
  password.type = password.type === "password" ? "text" : "password";
  toggle.textContent = password.type === "password" ? "Show" : "Hide";
});
</script>

</body>
</html>
