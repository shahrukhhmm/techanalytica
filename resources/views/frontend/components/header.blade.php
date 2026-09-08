<header>
    <div class="container">
        <div class="nav-inner">
            <a href="{{ route('frontend.home') }}" class="logo">
                <div class="logo-dots">
                    <div class="logo-dot" style="background: #ff3b7b;"></div>
                    <div class="logo-dot" style="background: #ff735c;"></div>
                    <div class="logo-dot" style="background: #d83b7d;"></div>
                    <div class="logo-dot" style="background: #ff3b7b;"></div>
                    <div class="logo-dot" style="background: #a4358a;"></div>
                    <div class="logo-dot" style="background: #ff735c;"></div>
                </div>
                <span>Tech<span style="font-weight: 400; color: rgba(255,255,255,0.92);">Analytica</span></span>
            </a>
            
            <ul class="nav-links">
                <li><a href="{{ route('frontend.blogs') }}" class="{{ request()->routeIs('frontend.blogs*') ? 'active-nav' : '' }}">Content Hub</a></li>
                <li><a href="{{ route('frontend.leaderboard') }}">Top Rated</a></li>
                <li><a href="{{ route('frontend.tools.index') }}" class="{{ request()->routeIs('frontend.tools*') ? 'active-nav' : '' }}">Tools Directory</a></li>
                
                <!-- Industries / Categories Dropdown -->
                <li class="nav-dropdown">
                    <a href="{{ route('frontend.tools.index') }}" class="nav-dropdown-trigger">
                        <span>{{ (isset($navIndustries) && $navIndustries->count() > 0) ? 'Industries' : 'Categories' }}</span>
                        <i class="fa-solid fa-chevron-down nav-arrow"></i>
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-menu-inner">
                            @if(isset($navIndustries) && $navIndustries->count() > 0)
                                @foreach($navIndustries as $ind)
                                    <a href="{{ route('frontend.tools.index') }}" class="dropdown-item">
                                        <div class="dropdown-icon" style="background: rgba(255, 59, 123, 0.15); color: #ff3b7b;"><i class="fa-solid fa-layer-group"></i></div>
                                        <div class="dropdown-info">
                                            <div class="dropdown-title">{{ $ind->name }}</div>
                                            <div class="dropdown-desc">{{ $ind->tools_count }} software tools</div>
                                        </div>
                                    </a>
                                @endforeach
                            @elseif(isset($categories) && $categories->count() > 0)
                                @foreach($categories->take(6) as $cat)
                                    <a href="{{ route('frontend.tools.index', ['category_id' => $cat->id]) }}" class="dropdown-item">
                                        <div class="dropdown-icon" style="background: rgba(255, 59, 123, 0.15); color: #ff3b7b;"><i class="fa-solid fa-shapes"></i></div>
                                        <div class="dropdown-info">
                                            <div class="dropdown-title">{{ $cat->name }}</div>
                                            <div class="dropdown-desc">{{ $cat->tools_count }} software tools</div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <a href="{{ route('frontend.tools.index') }}" class="dropdown-item">
                                    <div class="dropdown-info">
                                        <div class="dropdown-title">Explore All Software</div>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                </li>

                <li><a href="{{ route('frontend.compare') }}" class="{{ request()->routeIs('frontend.compare*') ? 'active-nav' : '' }}">Compare</a></li>
            </ul>

            <div class="nav-actions">
                <a href="{{ route('frontend.compare') }}" class="btn-calc">
                    <span>Comparisons Calculator</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

                <button class="hamburger-btn" onclick="toggleMenu()" aria-label="Toggle Menu">
                    <i class="fa-solid fa-bars" id="menuToggleIcon"></i>
                </button>
            </div>
        </div>
    </div>
</header>

