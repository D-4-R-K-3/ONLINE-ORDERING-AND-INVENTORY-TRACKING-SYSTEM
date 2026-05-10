<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title) . ' | ' : '' ?>Aurea</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --bg: #efe8dd;
            --bg-alt: #f8f3eb;
            --surface: rgba(255, 255, 255, 0.52);
            --surface-strong: rgba(255, 255, 255, 0.72);
            --text: #1f1f20;
            --muted: #625f5a;
            --border: rgba(255, 255, 255, 0.6);
            --accent: #ad6d3d;
            --accent-2: #6a9f8f;
            --shadow: 0 18px 45px rgba(56, 36, 17, 0.12);
            --success: #1f8f52;
            --danger: #b44343;
            --warning: #b2812f;
            --info: #3177c8;
        }

        html[data-theme="dark"] {
            --bg: #0f1216;
            --bg-alt: #121820;
            --surface: rgba(20, 26, 36, 0.56);
            --surface-strong: rgba(20, 26, 36, 0.74);
            --text: #eef2f8;
            --muted: #a5afbc;
            --border: rgba(205, 223, 255, 0.15);
            --accent: #f09a65;
            --accent-2: #73bfab;
            --shadow: 0 20px 55px rgba(0, 0, 0, 0.42);
            --success: #2bb46f;
            --danger: #e16565;
            --warning: #deaa44;
            --info: #5e9ded;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);
            font-family: 'Outfit', sans-serif;
            background:
                radial-gradient(circle at 12% 18%, rgba(106, 159, 143, 0.18), transparent 28%),
                radial-gradient(circle at 86% 12%, rgba(173, 109, 61, 0.2), transparent 24%),
                radial-gradient(circle at 52% 86%, rgba(126, 126, 220, 0.1), transparent 35%),
                linear-gradient(145deg, var(--bg), var(--bg-alt));
            transition: background 0.25s ease, color 0.25s ease;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .navbar-brand {
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: 0.01em;
        }

        a {
            color: var(--text);
            text-decoration: none;
        }

        .shell {
            width: min(1220px, calc(100% - 2rem));
            margin: 0 auto;
        }

        .glass {
            background: var(--surface);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .main-nav {
            margin-top: 1rem;
            border-radius: 18px;
            overflow: visible;
            position: relative;
            z-index: 1100;
        }

        .navbar {
            padding: 0.9rem 1.1rem;
            background: transparent;
        }

        .navbar-brand {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            font-size: 1.35rem;
            color: var(--text);
            font-weight: 700;
        }

        .brand-dot {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            color: #fff;
            font-size: 0.9rem;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.18);
        }

        .nav-link {
            border-radius: 10px;
            color: var(--text);
            padding: 0.5rem 0.85rem;
            font-weight: 500;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .nav-link:hover,
        .nav-link:focus {
            background: rgba(255, 255, 255, 0.25);
            color: var(--text);
            transform: translateY(-1px);
        }

        html[data-theme="dark"] .nav-link:hover,
        html[data-theme="dark"] .nav-link:focus {
            background: rgba(255, 255, 255, 0.08);
        }

        .dropdown-menu {
            border: 1px solid var(--border);
            background: var(--surface-strong);
            box-shadow: var(--shadow);
            border-radius: 12px;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            z-index: 2000;
        }

        .dropdown-item {
            color: var(--text);
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.2);
            color: var(--text);
        }

        .theme-toggle {
            border: 1px solid var(--border);
            background: var(--surface-strong);
            color: var(--text);
            border-radius: 999px;
            width: 2.35rem;
            height: 2.35rem;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .theme-toggle:hover {
            transform: translateY(-1px);
        }

        .flash-wrap {
            margin-top: 1rem;
        }

        .alert {
            border-radius: 12px;
            border: 1px solid var(--border);
            color: var(--text);
            background: var(--surface-strong);
            box-shadow: var(--shadow);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .alert-success { border-left: 5px solid var(--success); }
        .alert-danger { border-left: 5px solid var(--danger); }
        .alert-warning { border-left: 5px solid var(--warning); }
        .alert-info { border-left: 5px solid var(--info); }

        .content-shell {
            margin-top: 1.2rem;
            margin-bottom: 2rem;
            animation: fadeSlideIn 0.55s ease;
        }

        @keyframes fadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card,
        .stat-card,
        .modal-content,
        .list-group-item {
            background: var(--surface);
            border: 1px solid var(--border);
            color: var(--text);
            border-radius: 16px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .card-header,
        .table thead th {
            background: transparent;
            border-bottom: 1px solid var(--border);
            color: var(--text);
        }

        .table-responsive {
            border-radius: 14px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
            border: none;
            box-shadow: none;
            border-radius: 0;
            background: transparent;
        }

        .table > :not(caption) > * > * {
            border-bottom-color: var(--border);
            color: var(--text);
            background: transparent;
        }

        .table-hover tbody tr:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        html[data-theme="dark"] .table-hover tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.5);
            color: var(--text);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        html[data-theme="dark"] .form-control,
        html[data-theme="dark"] .form-select {
            background: rgba(255, 255, 255, 0.06);
            color: var(--text);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 0.2rem rgba(173, 109, 61, 0.2);
            background: rgba(255, 255, 255, 0.66);
            color: var(--text);
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.01em;
            padding: 0.52rem 0.95rem;
        }

        .btn-primary,
        .btn-success {
            border: none;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
        }

        .btn-outline-primary,
        .btn-outline-secondary,
        .btn-outline-success,
        .btn-outline-danger,
        .btn-outline-warning,
        .btn-outline-info {
            border-color: rgba(255, 255, 255, 0.55);
            color: var(--text);
            background: rgba(255, 255, 255, 0.14);
        }

        .btn-outline-primary:hover,
        .btn-outline-secondary:hover,
        .btn-outline-success:hover,
        .btn-outline-danger:hover,
        .btn-outline-warning:hover,
        .btn-outline-info:hover {
            color: var(--text);
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.72);
        }

        .footer {
            margin: 1rem auto 2rem;
            padding: 1.4rem 1.6rem;
            border-radius: 18px;
            background: var(--surface);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            color: var(--text);
        }

        .footer p,
        .footer li,
        .footer a {
            color: var(--muted);
        }

        .footer a:hover {
            color: var(--text);
        }

        @media (max-width: 991.98px) {
            .navbar-nav {
                margin-top: 0.75rem;
                gap: 0.2rem;
            }

            .main-nav {
                border-radius: 14px;
                overflow: visible;
            }

            .content-shell {
                margin-top: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .shell {
                width: calc(100% - 1rem);
            }

            .navbar {
                padding: 0.75rem 0.8rem;
            }

            .footer {
                padding: 1.1rem;
            }
        }
    </style>
</head>
<body>
    <div class="shell">
        <header class="main-nav glass">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="/">
                    <span class="brand-dot"><i class="fas fa-cube"></i></span>
                    <span>Aurea</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                        <?php if (session()->get('logged_in')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/">Home</a>
                            </li>

                            <?php if (session()->get('role') === 'Customer'): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/shop/cart"><i class="fas fa-shopping-cart"></i> Cart</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/shop/my-orders">My Orders</a>
                                </li>
                            <?php elseif (in_array(session()->get('role'), ['Admin', 'Staff'])): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="/dashboard">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/dashboard/products">Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/dashboard/inventory">Inventory</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/dashboard/orders">Orders</a>
                                </li>
                            <?php endif; ?>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user-circle"></i> <?= esc(session()->get('first_name') ?? 'User') ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="/auth/profile">Profile</a></li>
                                    <li><a class="dropdown-item" href="/auth/change-password">Change Password</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/auth/logout">Logout</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/auth/login">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/auth/register">Register</a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                            <button class="theme-toggle" id="themeToggle" type="button" aria-label="Toggle theme">
                                <i class="fas fa-moon"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <section class="flash-wrap">
            <?php if (session()->has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> <?= session('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> <?= session('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->has('warning')): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> <?= session('warning') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->has('info')): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle"></i> <?= session('info') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </section>

        <main class="content-shell">
            <?= $this->renderSection('content') ?>
        </main>

        <footer class="footer">
            <div class="row g-4 align-items-start">
                <div class="col-md-5">
                    <h5 class="mb-2">Professional Ordering Experience</h5>
                    <p class="mb-0">A minimalist online ordering and inventory platform powered by CodeIgniter 4, redesigned with a modern glassmorphism interface.</p>
                </div>
                <div class="col-md-4">
                    <h6 class="mb-2">Quick Links</h6>
                    <ul class="list-unstyled mb-0">
                        <li><a href="/">Home</a></li>
                        <li><a href="/shop">Shop</a></li>
                        <li><a href="/auth/login">Login</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="mb-2">Support</h6>
                    <p class="mb-1">support@shop.local</p>
                    <p class="mb-0">+63-555-1234</p>
                </div>
            </div>
            <hr>
            <p class="mb-0 text-center">&copy; <?= date('Y') ?> Aurea. All rights reserved.</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.alert').forEach(function (alert) {
            setTimeout(function () {
                if (window.bootstrap && alert.classList.contains('show')) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        });

        (function () {
            var html = document.documentElement;
            var storageKey = 'shopglass-theme';
            var themeToggle = document.getElementById('themeToggle');

            function applyTheme(theme) {
                html.setAttribute('data-theme', theme);
                if (themeToggle) {
                    themeToggle.innerHTML = theme === 'dark'
                        ? '<i class="fas fa-sun"></i>'
                        : '<i class="fas fa-moon"></i>';
                }
            }

            var storedTheme = localStorage.getItem(storageKey);
            var initialTheme = storedTheme || 'light';
            applyTheme(initialTheme);

            if (themeToggle) {
                themeToggle.addEventListener('click', function () {
                    var currentTheme = html.getAttribute('data-theme') || 'light';
                    var nextTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    localStorage.setItem(storageKey, nextTheme);
                    applyTheme(nextTheme);
                });
            }
        })();
    </script>
</body>
</html>
