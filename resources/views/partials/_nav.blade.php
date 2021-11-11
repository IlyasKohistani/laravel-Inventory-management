
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
                                        <p class="mb-0 text-sm text-gray-600">{{  ucWords(implode(',' , Auth::user()->user_roles)) }}</p>
                                    </div>
                                    <div class="user-img d-flex align-items-center">
                                        <div class="avatar bg-warning avatar-lg">
                                            {{-- <img src="assets/images/faces/1.jpg"> --}}
                                            <span class="avatar-content">{{ strtoupper(Auth::user()->email[0]) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
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
                        
                        
                        
                        <li
                            class="menu-item  ">
                            <a href="{{ route('dashboard') }}" class='menu-link'>
                                <i class="bi bi-house-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li
                            class="menu-item  ">
                            <a href="{{ route('import.index') }}" class='menu-link'>
                                <i class="bi bi-collection-fill"></i>
                                <span>Imports</span>
                            </a>
                        </li>

                        <li
                            class="menu-item  ">
                            <a href="{{ route('import.index') }}" class='menu-link'>
                                <i class="bi bi-list-ol"></i>
                                <span>Products</span>
                            </a>
                        </li>
                        
                        
                        
                        <li
                            class="menu-item  has-sub">
                            <a href="#" class='menu-link'>
                                <i class="bi bi-stack"></i>
                                <span>Components</span>
                            </a>
                            <div
                                class="submenu ">
                                <!-- Wrap to submenu-group-wrapper if you want 3-level submenu. Otherwise remove it. -->
                                <div class="submenu-group-wrapper">
                                    
                                    
                                    <ul class="submenu-group">
                                        
                                        <li
                                            class="submenu-item  ">
                                            <a href="component-alert.html"
                                                class='submenu-link'>Alert</a>

                                            
                                        </li>
                                        
                                    
                                    
                                        <li
                                            class="submenu-item  ">
                                            <a href="component-badge.html"
                                                class='submenu-link'>Badge</a>

                                            
                                        </li>
                                        
                                    
                                    
                                        <li
                                            class="submenu-item  ">
                                            <a href="component-breadcrumb.html"
                                                class='submenu-link'>Breadcrumb</a>

                                            
                                        </li>
                                        
                                    
                                    
                                        <li
                                            class="submenu-item  ">
                                            <a href="component-button.html"
                                                class='submenu-link'>Button</a>

                                            
                                        </li>
                                        
                                    
                                    
                                        <li
                                            class="submenu-item  ">
                                            <a href="component-card.html"
                                                class='submenu-link'>Card</a>

                                            
                                        </li>
                                        
                                    
                                    
                                        <li
                                            class="submenu-item  ">
                                            <a href="component-carousel.html"
                                                class='submenu-link'>Carousel</a>

                                            
                                        </li>
                                        
                                    
                                    
                                        <li
                                            class="submenu-item  ">
                                            <a href="component-dropdown.html"
                                                class='submenu-link'>Dropdown</a>

                                            
                                        </li>
                                        
                                    
                                    
                                        <li
                                            class="submenu-item  ">
                                            <a href="component-list-group.html"
                                                class='submenu-link'>List Group</a>

                                            
                                        </li>
                                        
                                    </ul>
                                    
                                    
                                    
                                    <ul class="submenu-group">
                                        
                                        <li
                                            class="submenu-item  ">
                                            <a href="component-modal.html"
                                                class='submenu-link'>Modal</a>

                                            
                                        </li>
                                        
                                    
                                    
                                        <li
                                            class="submenu-item  ">
                                            <a href="component-navs.html"
                                                class='submenu-link'>Navs</a>

                                            
                                        </li>
                                        
                                    
                                    
                                        <li
                                            class="submenu-item  ">
                                            <a href="component-pagination.html"
                                                class='submenu-link'>Pagination</a>

                                            
                                        </li>
                                        
                                    
                                    
                                        <li
                                            class="submenu-item  ">
                                            <a href="component-progress.html"
                                                class='submenu-link'>Progress</a>

                                            
                                        </li>
                                        
                                    
                                    
                                        <li
                                            class="submenu-item  ">
                                            <a href="component-spinner.html"
                                                class='submenu-link'>Spinner</a>

                                            
                                        </li>
                                        
                                    
                                    
                                        <li
                                            class="submenu-item  ">
                                            <a href="component-tooltip.html"
                                                class='submenu-link'>Tooltip</a>

                                            
                                        </li>
                                        
                                    
                                    
                                        <li
                                            class="submenu-item  has-sub">
                                            <a href="#"
                                                class='submenu-link'>Extra Components</a>

                                            
                                            <!-- 3 Level Submenu -->
                                            <ul class="subsubmenu">
                                                
                                                <li class="subsubmenu-item ">
                                                    <a href="extra-component-avatar.html" class="subsubmenu-link">Avatar</a>
                                                </li>
                                                
                                                <li class="subsubmenu-item ">
                                                    <a href="extra-component-sweetalert.html" class="subsubmenu-link">Sweet Alert</a>
                                                </li>
                                                
                                                <li class="subsubmenu-item ">
                                                    <a href="extra-component-toastify.html" class="subsubmenu-link">Toastify</a>
                                                </li>
                                                
                                                <li class="subsubmenu-item ">
                                                    <a href="extra-component-rating.html" class="subsubmenu-link">Rating</a>
                                                </li>
                                                
                                                <li class="subsubmenu-item ">
                                                    <a href="extra-component-divider.html" class="subsubmenu-link">Divider</a>
                                                </li>
                                                
                                            </ul>
                                            
                                        </li>
                                        
                                    
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </nav>

        </header>
