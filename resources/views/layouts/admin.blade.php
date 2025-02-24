<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Car Rental</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Sidebar Styling */
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            color: #fff;
            padding-top: 30px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link {
            color: #d1d1d1;
        }

        .sidebar .nav-link:hover {
            background-color: #007bff;
            color: #fff;
        }

        .sidebar i {
            margin-right: 10px;
        }

        .sidebar .collapse {
            display: none;
        }

        .sidebar .collapse.show {
            display: block;
        }

        /* Main content margin */
        .content-wrapper {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        /* Mobile view adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                display: none;
                position: absolute;
                z-index: 999;
            }

            .sidebar.active {
                width: 250px;
                display: block;
            }

            .content-wrapper {
                margin-left: 0;
            }

            .navbar-toggler {
                display: block;
            }

            .toggle-btn {
                display: block;
            }
        }

        /* Hide toggle button on desktop */
        @media (min-width: 769px) {
            .toggle-btn {
                display: none;
            }
        }
    </style>
</head>
<body>

   <!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="text-white ms-3">Admin Panel</h4>
    </div>
    <div class="list-group">
        <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('admin.cars.index') }}" class="list-group-item list-group-item-action">
            <i class="fas fa-car"></i> Manage Cars
        </a>
        <a href="{{ route('admin.rentals.index') }}" class="list-group-item list-group-item-action">
            <i class="fas fa-calendar-check"></i> Manage Rentals
        </a>
        <a href="{{ route('admin.customer.index') }}" class="list-group-item list-group-item-action">
            <i class="fas fa-users"></i> Manage Customers
        </a>
        <!-- Logout link -->
        <a href="{{ route('logout') }}" class="list-group-item list-group-item-action text-danger"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</div>

<!-- Logout form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

    <!-- Main Content -->
    <div class="content-wrapper">
        <button class="btn btn-primary toggle-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <div class="container my-4">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-4">
        &copy; {{ date('Y') }} Car Rental System | Admin Panel
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to toggle sidebar visibility on mobile
        function toggleSidebar() {
            var sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("active");
        }
    </script>
</body>
</html>
