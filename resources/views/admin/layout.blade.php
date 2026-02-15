<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Center | Dipika Store</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2ecc71;
            --primary-dark: #27ae60;
            --secondary: #1e293b;
            --background: #f1f5f9;
            --surface: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --radius: 12px;
            --sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--background);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--secondary);
            color: white;
            padding: 32px 20px;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 100;
        }

        .sidebar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 48px;
            padding-left: 12px;
            color: var(--primary);
        }

        .sidebar-brand span {
            color: white;
        }

        .nav-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: var(--radius);
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-item:hover {
            color: white;
            background: rgba(255, 255, 255, 0.05);
        }

        .nav-item.active {
            color: white;
            background: var(--primary);
        }

        .add-product-btn {
            background: rgba(46, 204, 113, 0.15);
            color: var(--primary);
            margin-top: 24px;
        }

        .add-product-btn:hover {
            background: var(--primary);
            color: white;
        }

        /* Main Content Area */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .top-bar {
            background: var(--surface);
            height: 72px;
            padding: 0 40px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            border-bottom: 1px solid var(--border);
        }

        .logout-form {
            margin: 0;
        }

        .logout-btn {
            background: #fee2e2;
            color: #ef4444;
            border: none;
            padding: 8px 16px;
            border-radius: var(--radius);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background: #ef4444;
            color: white;
        }

        .content {
            padding: 40px;
        }

        /* Reusable Admin Components */
        .card {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 32px;
        }

        .card-body {
            padding: 24px;
        }

        h1 {
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 32px;
        }

        .alert {
            padding: 16px 20px;
            border-radius: var(--radius);
            margin-bottom: 24px;
            font-weight: 600;
        }

        .alert-success {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        /* Modified Table for Admin */
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            text-align: left;
            padding: 16px;
            background: #f8fafc;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border);
        }

        .table td {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-sm {
            padding: 4px 12px;
            font-size: 0.75rem;
        }

        .justify-content-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mb-4 {
            margin-bottom: 32px;
        }

        .d-inline {
            display: inline;
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 80px;
                padding: 32px 10px;
            }

            .sidebar-brand span,
            .nav-item span {
                display: none;
            }

            .nav-item {
                justify-content: center;
            }

            .main-wrapper {
                margin-left: 80px;
            }
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-brand">
            D<span>S</span> Admin
        </div>
        <nav class="nav-group">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.products') }}"
                class="nav-item {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                <span>Products</span>
            </a>
            <a href="{{ route('admin.orders') }}"
                class="nav-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                <span>Orders</span>
            </a>
            <a href="{{ route('admin.products.create') }}" class="nav-item add-product-btn">
                <span>+ Add Product</span>
            </a>

            <div style="margin-top: auto; padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="{{ route('home') }}" class="nav-item" style="color: #94a3b8;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px;" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Back to Store</span>
                </a>
            </div>
        </nav>
    </aside>

    <div class="main-wrapper">
        <header class="top-bar">
            <form action="{{ route('admin.logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">Log out</button>
            </form>
        </header>

        <main class="content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>

</html>