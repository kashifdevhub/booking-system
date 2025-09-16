{{-- resources/views/welcome.blade.php --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>{{ config('app.name', 'Mini Booking System') }}</title>

  <!-- Minimal styles -->
  <style>
    :root{
      --nav-height:64px;
      --overlay: rgba(6,23,34,0.45);
      --accent: #06b6d4;
      --muted: rgba(255,255,255,0.9);
    }
    html,body{height:100%;margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial}
    .bg {
      position:fixed; inset:0; background-image: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80');
      background-size:cover; background-position:center; filter:brightness(.9);
      z-index:-2;
    }
    .overlay { position:fixed; inset:0; background:var(--overlay); z-index:-1; }
    header { height:var(--nav-height); display:flex; align-items:center; justify-content:space-between; padding:0 20px; color:var(--muted); }
    .brand { color:#fff; font-weight:700; letter-spacing:.6px; display:flex; gap:10px; align-items:center }
    .navlinks a { margin-left:12px; text-decoration:none; color:#fff; padding:8px 12px; border-radius:8px; font-weight:600 }
    .navlinks a.login { background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.08) }
    .navlinks a.register { background:var(--accent); color:#002; }
    .center {
      height: calc(100% - var(--nav-height));
      display:flex; align-items:center; justify-content:center; text-align:center; padding:24px;
    }
    .hero { color:#fff; max-width:820px; }
    .title { font-size:38px; margin:0 0 12px 0; font-weight:700; text-shadow:0 6px 18px rgba(2,6,23,0.6) }
    .subtitle { margin:0 0 20px 0; color:rgba(255,255,255,0.92); font-size:16px }
    .cta { display:inline-block; padding:12px 18px; border-radius:10px; background:var(--accent); color:#002; font-weight:700; text-decoration:none }
    @media (max-width:640px){
      .title { font-size:28px }
      header { padding:0 12px }
    }
  </style>
</head>
<body>
  <div class="bg" aria-hidden="true"></div>
  <div class="overlay" aria-hidden="true"></div>

  <header>
    <div class="brand">
      <div style="width:36px;height:36px;border-radius:6px;background:linear-gradient(135deg,#06b6d4,#0ea5a4);display:flex;align-items:center;justify-content:center;color:#002;font-weight:800">M</div>
      <div>
        <div style="font-size:14px">{{ config('app.name', 'Mini Booking System') }}</div>
        <div style="font-size:11px;opacity:.9">Flights & Hotels</div>
      </div>
    </div>

    <nav class="navlinks">
      @auth
        @if(auth()->user()->is_admin)
          <a href="{{ route('admin.dashboard') }}" class="login">Admin</a>
        @else
          <a href="{{ url('/') }}" class="login">Search</a>
        @endif
        <a href="{{ route('dashboard') }}" class="login">Account</a>
      @else
        <a href="{{ route('login') }}" class="login">Log in</a>
        @if (Route::has('register'))
          <a href="{{ route('register') }}" class="register">Register</a>
        @endif
      @endauth
    </nav>
  </header>

  <div class="center">
    <div class="hero">
      <h1 class="title">Plan your next trip — fast.</h1>
      <p class="subtitle">Search flights and hotels </p>
      <p>
        <a class="cta" href="{{route('login')}}">Search Flights</a>
      </p>
    </div>
  </div>
</body>
</html>
