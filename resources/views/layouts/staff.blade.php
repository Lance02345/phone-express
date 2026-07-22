<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Staff') | Phone Express</title>
    <link rel="icon" href="{{ asset('Images/faviconapple.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('Images/faviconapple.png') }}">
    <link href="{{ asset('build/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('build/assets/icon-fonts/icons.css') }}" rel="stylesheet">
    <style>
        :root { --staff-green:#0b3b28; --staff-ink:#17251d; --staff-muted:#708078; --staff-line:#e0e7e2; --staff-gold:#f2b33e; }
        * { box-sizing: border-box; } body { min-height:100vh; margin:0; color:var(--staff-ink); background:#f4f7f5; font-family:Arial,sans-serif; }
        .staff-nav { position:sticky; z-index:20; top:0; background:rgba(8,45,30,.96); border-bottom:1px solid rgba(255,255,255,.08); backdrop-filter:blur(16px); }
        .staff-logo { width:185px; height:48px; object-fit:contain; } .staff-user { color:rgba(255,255,255,.68); font-size:.8rem; }
        .staff-links{display:flex;align-items:center;gap:.3rem}.staff-links a{padding:.55rem .75rem;color:rgba(255,255,255,.68);border-radius:9px;font-size:.8rem;font-weight:700;text-decoration:none}.staff-links a:hover,.staff-links a.active{color:#fff;background:rgba(255,255,255,.1)}
        .view-site-link{display:inline-flex;align-items:center;gap:.4rem;padding:.46rem .72rem;color:#f8d58b;border:1px solid rgba(245,182,59,.32);border-radius:99px;font-size:.75rem;font-weight:700;text-decoration:none;white-space:nowrap}.view-site-link:hover{color:#102a1f;background:var(--staff-gold);border-color:var(--staff-gold)}
        .staff-shell { padding:2rem 0 5rem; } .staff-card { background:#fff; border:1px solid var(--staff-line); border-radius:18px; box-shadow:0 14px 36px rgba(20,34,27,.055); }
        .btn-staff { color:#fff; background:#176b45; border-color:#176b45; font-weight:700; } .btn-staff:hover { color:#fff; background:#0f5334; }
        .form-control,.form-select { min-height:48px; border-color:#dce5df; border-radius:11px; } .form-control:focus,.form-select:focus { border-color:#65a27e; box-shadow:0 0 0 4px rgba(23,107,69,.1); }
        @media(max-width:767px){.staff-shell{padding-top:1.2rem}.staff-logo{width:130px}.staff-links{display:none}.staff-user{display:none!important}.view-site-link span{display:none}}
    </style>
    @yield('styles')
</head>
<body>
<nav class="staff-nav py-2"><div class="container-fluid px-lg-5 d-flex align-items-center justify-content-between"><div class="d-flex align-items-center gap-4"><a href="{{ auth()->check() ? route('staff.dashboard') : url('/') }}"><img src="{{ asset('Images/logo-header2.png') }}" class="staff-logo" alt="Phone Express"></a>@auth<div class="staff-links"><a class="{{ request()->routeIs('staff.dashboard') ? 'active' : '' }}" href="{{ route('staff.dashboard') }}">Overview</a>@if(auth()->user()->role === 'admin')<a class="{{ request()->routeIs('staff.catalogue.*') ? 'active' : '' }}" href="{{ route('staff.catalogue.index') }}">Catalogue</a><a class="{{ request()->routeIs('staff.team.*') ? 'active' : '' }}" href="{{ route('staff.team.index') }}">Team</a>@endif</div>@endauth</div>@auth<div class="d-flex align-items-center gap-2 gap-md-3"><a href="{{ url('/') }}" class="view-site-link" title="View public website"><i class="ri-external-link-line"></i><span>View website</span></a><span class="staff-user">{{ auth()->user()->name }} · {{ ucfirst(auth()->user()->role) }}</span><form method="POST" action="{{ route('staff.logout') }}">@csrf<button class="btn btn-sm btn-outline-light rounded-pill px-3">Sign out</button></form></div>@endauth</div></nav>
<main class="staff-shell"><div class="container-fluid px-lg-5">@yield('content')</div></main>
</body>
</html>
