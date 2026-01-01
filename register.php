<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Register — FitTrack</title>

<style>


  :root{
    --accent: #ff7b00;
    --accent-2: #ff9a36;
    --muted: rgba(255,255,255,0.7);
    --glass: rgba(255,255,255,0.08);
    --glass-strong: rgba(255,255,255,0.12);
    --radius: 22px;
    --shadow: 0 12px 40px rgba(0,0,0,0.55);
    font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    color-scheme: dark;
  }

  html, body { height:100%; margin:0; padding:0; }

  /* background image (same as login) */
  body{
    background: url('images/fit2.jpg') center/cover no-repeat fixed;
    display:flex;
    align-items:center;
    justify-content:center;
  }

  /* dark blur overlay */
  body::before{
    content:"";
    position:fixed;
    inset:0;
    background: rgba(10,10,10,0.45);
    backdrop-filter: blur(7px);
    z-index:0;
  }

  /* frosted glass card */
  .card{
    position:relative;
    z-index:2;
    width:min(720px, 92vw);
    padding:44px;
    background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.04));
    border-radius: var(--radius);
    border:1px solid rgba(255,255,255,0.06);
    box-shadow: var(--shadow);
    backdrop-filter: blur(12px) saturate(135%);
    color:#fff;
  }

  h1{
    text-align:center;
    margin:0 0 20px;
    font-size:28px;
    font-weight:700;
  }

  .input{
    width:100%;
    margin:10px 0;
    padding:16px 18px;
    font-size:15px;
    border-radius:12px;
    border:1px solid rgba(255,255,255,0.06);
    background:linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.02));
    color:#fff;
    outline:none;
    transition:0.15s;
  }

  .input:focus{
    transform: translateY(-2px);
    box-shadow:0 6px 20px rgba(0,0,0,0.45), 0 0 0 4px rgba(255,123,0,0.1);
  }

  .cta{
    width:100%;
    margin-top:16px;
    padding:16px;
    border:none;
    outline:none;
    border-radius:12px;
    background:linear-gradient(90deg, var(--accent), var(--accent-2));
    box-shadow:0 10px 28px rgba(255,123,0,0.3);
    color:#fff;
    font-size:17px;
    font-weight:700;
    cursor:pointer;
    transition:0.15s;
  }
  .cta:hover{
    transform:translateY(-3px);
    box-shadow:0 16px 42px rgba(255,123,0,0.4);
  }

  .footer-text{
    margin-top:20px;
    text-align:center;
    color:var(--muted);
    font-size:14px;
  }
  .footer-text a{
    color:#ffb86b;
    text-decoration:none;
    font-weight:600;
  }
  .footer-text a:hover{ color:#ffd9a3; }

  @media(max-width:520px){
    .card{ padding:28px; border-radius:16px; }
    h1{ font-size:22px; }
  }
  
.auth input,
.input {
  background: rgba(0, 0, 0, 0.45);
  border: 1px solid rgba(255, 255, 255, 0.15);
  color: #ffffff;
  font-weight: 500;
}

.auth input::placeholder,
.input::placeholder {
  color: rgba(255, 255, 255, 0.75);
}

.auth input:focus,
.input:focus {
  background: rgba(0, 0, 0, 0.6);
  border-color: #ff9a36;
  box-shadow: 0 0 0 3px rgba(255, 123, 0, 0.25);
}

</style>

</head>
<body>

  <div class="card">
    <h1>Create Your Account</h1>

    <form action="php/register.php" method="POST">

      <input class="input" type="text" name="username" placeholder="Username" required>

      <input class="input" type="email" name="email" placeholder="Email" required>

      <input class="input" type="password" name="password" placeholder="Password" required>

      <input class="input" type="number" name="height" placeholder="Height (cm)" required>

      <input class="input" type="number" name="weight" placeholder="Weight (kg)" required>

      <input class="input" type="date" name="dob" required>

      <button class="cta" type="submit">Register</button>

      <div class="footer-text">
        Already have an account?
        <a href="login.php">Login</a>
      </div>

    </form>
  </div>

</body>
</html>
