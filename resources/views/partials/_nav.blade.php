<header class="mb-5">
    <div class="header-top">
        <div class="container">
            <div class="logo d-flex">
                <a href="{{ route('dashboard') }}">
                    {{-- <img src="assets/images/logo/logo.png" alt="Logo" srcset=""> --}}
                    <h4 class="font-monospace">WAM DENIM</h4>
                </a>
                <a href="#" class="burger-btn ms-3 d-inline-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </div>
            <div class="header-top-right">
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex align-items-center">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600">{{ ucWords(Auth::user()->fullname) }}</h6>
                                <p class="mb-0 text-sm text-gray-600">
                                    {{ ucWords(implode(',', Auth::user()->user_roles)) }}</p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar bg-warning avatar-lg">
                                    {{-- <img src="assets/images/faces/1.jpg"> --}}
                                    <span class="avatar-content">{{ strtoupper(Auth::user()->email[0]) }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                        style="min-width: 11rem;">
                        <li>
                            <h6 class="dropdown-header">Hello, {{ ucFirst(Auth::user()->name) }}!</h6>
                        </li>
                        <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-person me-2"></i> My
                                Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-gear me-2"></i>
                                Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}"><i
                                    class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <nav class="main-navbar">
        <div class="container">
            <ul>



                <li class="menu-item  ">
                    <a href="{{ route('dashboard') }}" class='menu-link'>
                        <i class="bi bi-house-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-item  has-sub">
                    <a href="{{ route('product.index') }}" class='menu-link'>
                        <i class="bi bi-stack"></i>
                        <span>Products</span>
                    </a>
                    <div class="submenu ">
                        <div class="submenu-group-wrapper">
                            <ul class="submenu-group">

                                <li class="submenu-item  ">
                                    <a href="{{ route('product.index',['status'=>1]) }}" class="submenu-link">Manage</a>
                                </li>
                                <li class="submenu-item  ">
                                    <a href="{{ route('product.create') }}" class="submenu-link">Create</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>

                <li class="menu-item  ">
                    <a href="{{ route('request-transaction.index') }}" class='menu-link'>
                        <i class="bi bi-text-center"></i>
                        <span>Requests</span>
                    </a>
                </li>

                <li class="menu-item  ">
                    <a href="{{ route('grant-transaction.index') }}" class='menu-link'>
                        <i class="bi bi-layout-wtf"></i>
                        <span>Grants</span>
                    </a>
                </li>

                <li class="menu-item  ">
                    <a href="{{ route('import.index') }}" class='menu-link'>
                        <i class="bi bi-box-arrow-in-down"></i>
                        <span>Imports</span>
                    </a>
                </li>

            </ul>
        </div>
    </nav>

</header>
