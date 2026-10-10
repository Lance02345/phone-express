<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Staff') | Digital District Kenya</title>
    <link rel="icon" href="{{ asset('Images/digital-district-kenya-logo.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('Images/digital-district-kenya-logo.png') }}">
    <link href="{{ asset('build/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('build/assets/icon-fonts/icons.css') }}" rel="stylesheet">
    <style>
        :root { --staff-black:#0a0a0a; --staff-ink:#0a0a0a; --staff-muted:#737373; --staff-line:#e5e5e5; }
        * { box-sizing: border-box; } body { min-height:100vh; margin:0; color:var(--staff-ink); background:#f5f5f5; font-family:Arial,sans-serif; }
        .staff-nav { position:sticky; z-index:20; top:0; background:rgba(10,10,10,.96); border-bottom:1px solid rgba(255,255,255,.08); backdrop-filter:blur(16px); }
        .staff-logo { width:56px; height:56px; object-fit:contain; padding:2px; border-radius:8px; background:#fff; } .staff-user { color:rgba(255,255,255,.68); font-size:.8rem; }
        .staff-links{display:flex;align-items:center;gap:.3rem}.staff-links a{padding:.55rem .75rem;color:rgba(255,255,255,.68);border-radius:9px;font-size:.8rem;font-weight:700;text-decoration:none}.staff-links a:hover,.staff-links a.active{color:#fff;background:rgba(255,255,255,.1)}
        .view-site-link{display:inline-flex;align-items:center;gap:.4rem;padding:.46rem .72rem;color:#fff;border:1px solid rgba(255,255,255,.28);border-radius:99px;font-size:.75rem;font-weight:700;text-decoration:none;white-space:nowrap}.view-site-link:hover{color:#0a0a0a;background:#fff;border-color:#fff}
        .staff-shell { padding:2rem 0 5rem; } .staff-card { background:#fff; border:1px solid var(--staff-line); border-radius:18px; box-shadow:0 14px 36px rgba(0,0,0,.05); }
        .btn-staff { color:#fff; background:#0a0a0a; border-color:#0a0a0a; font-weight:700; } .btn-staff:hover { color:#fff; background:#262626; border-color:#262626; }
        .form-control,.form-select { min-height:48px; border-color:#e0e0e0; border-radius:11px; } .form-control:focus,.form-select:focus { border-color:#0a0a0a; box-shadow:0 0 0 4px rgba(0,0,0,.06); }
        .alert-success { color:#0a0a0a; background:#f0f0f0; border-color:#e0e0e0; } .text-success { color:var(--staff-muted)!important; } .bg-success { background-color:#0a0a0a!important; }
        .btn-outline-success { color:#0a0a0a; border-color:#0a0a0a; } .btn-outline-success:hover { color:#fff; background:#0a0a0a; border-color:#0a0a0a; }
        @media(max-width:767px){.staff-shell{padding-top:1.2rem}.staff-logo{width:56px}.staff-links{display:none}.staff-user{display:none!important}.view-site-link span{display:none}}
    </style>
    @yield('styles')
</head>
<body>
<nav class="staff-nav py-2"><div class="container-fluid px-lg-5 d-flex align-items-center justify-content-between"><div class="d-flex align-items-center gap-4"><a href="{{ auth()->check() ? route('staff.dashboard') : url('/') }}"><img src="{{ asset('Images/digital-district-kenya-logo.png') }}" class="staff-logo" alt="Digital District Kenya"></a>@auth<div class="staff-links"><a class="{{ request()->routeIs('staff.dashboard') ? 'active' : '' }}" href="{{ route('staff.dashboard') }}">Overview</a>@if(auth()->user()->role === 'admin')<a class="{{ request()->routeIs('staff.catalogue.*') ? 'active' : '' }}" href="{{ route('staff.catalogue.index') }}">Catalogue</a><a class="{{ request()->routeIs('staff.team.*') ? 'active' : '' }}" href="{{ route('staff.team.index') }}">Team</a>@endif</div>@endauth</div>@auth<div class="d-flex align-items-center gap-2 gap-md-3"><a href="{{ url('/') }}" class="view-site-link" title="View public website"><i class="ri-external-link-line"></i><span>View website</span></a><span class="staff-user">{{ auth()->user()->name }} · {{ ucfirst(auth()->user()->role) }}</span><form method="POST" action="{{ route('staff.logout') }}">@csrf<button class="btn btn-sm btn-outline-light rounded-pill px-3">Sign out</button></form></div>@endauth</div></nav>
<main class="staff-shell"><div class="container-fluid px-lg-5">@yield('content')</div></main>
</body>
</html>
