<header>
    <div class="container">
        <div class="nav-inner">
            <a href="{{ route('frontend.home') }}" class="logo">
                <div class="logo-dots">
                    <div class="logo-dot"></div>
                    <div class="logo-dot"></div>
                    <div class="logo-dot"></div>
                    <div class="logo-dot"></div>
                    <div class="logo-dot"></div>
                    <div class="logo-dot"></div>
                </div>
                <span>TechAnalytica</span>
            </a>
            
            <ul class="nav-links">
                <li><a href="{{ route('frontend.tools.index') }}">AI Software</a></li>
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
                                        <div class="dropdown-icon" style="background: rgba(224, 67, 133, 0.15); color: #e04385;"><i class="fa-solid fa-layer-group"></i></div>
                                        <div class="dropdown-info">
                                            <div class="dropdown-title">{{ $ind->name }}</div>
                                            <div class="dropdown-desc">{{ $ind->tools_count }} AI products</div>
                                        </div>
                                    </a>
                                @endforeach
                            @elseif(isset($categories) && $categories->count() > 0)
                                @foreach($categories->take(6) as $cat)
                                    <a href="{{ route('frontend.tools.index', ['category_id' => $cat->id]) }}" class="dropdown-item">
                                        <div class="dropdown-icon" style="background: rgba(224, 67, 133, 0.15); color: #e04385;"><i class="fa-solid fa-shapes"></i></div>
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

                <!-- Vendors Dropdown -->
                <li class="nav-dropdown">
                    <a href="{{ route('frontend.tools.index') }}" class="nav-dropdown-trigger">
                        <span>Vendors</span>
                        <i class="fa-solid fa-chevron-down nav-arrow"></i>
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-menu-inner">
                            <a href="{{ route('frontend.vendors.show', 'salesforce-sales-cloud') }}" class="dropdown-item">
                                <div class="dropdown-icon" style="background: rgba(0, 161, 224, 0.15); color: #00a1e0;"><i class="fa-solid fa-cloud"></i></div>
                                <div class="dropdown-info">
                                    <div class="dropdown-title">Salesforce Sales Cloud</div>
                                    <div class="dropdown-desc">Enterprise CRM • TechScore 98/100</div>
                                </div>
                            </a>
                            <a href="{{ route('frontend.vendors.show', 'hubspot-sales-hub') }}" class="dropdown-item">
                                <div class="dropdown-icon" style="background: rgba(255, 122, 89, 0.15); color: #ff7a59;"><i class="fa-brands fa-hubspot"></i></div>
                                <div class="dropdown-info">
                                    <div class="dropdown-title">HubSpot Sales Hub</div>
                                    <div class="dropdown-desc">Best for Startups • Free Tier</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>
                <li><a href="{{ route('frontend.blogs') }}">Blogs</a></li>
            </ul>

            <div class="nav-actions">
                <a href="{{ route('frontend.compare') }}" class="btn-calc">
                    Comparisons Calculator <i class="fa-solid fa-arrow-right"></i>
                </a>

                <button class="hamburger-btn" onclick="toggleMenu()" aria-label="Toggle Menu">
                    <i class="fa-solid fa-bars" id="menuToggleIcon"></i>
                </button>
            </div>
        </div>
    </div>
</header>

