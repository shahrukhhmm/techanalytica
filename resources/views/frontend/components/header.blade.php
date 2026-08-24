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
                <li class="nav-dropdown">
                    <a href="#" class="nav-dropdown-trigger">
                        <span>AI Software</span>
                        <i class="fa-solid fa-chevron-down nav-arrow"></i>
                    </a>

                    <!-- Hover Dropdown Menu -->
                    <div class="dropdown-menu">
                        <div class="dropdown-menu-inner">
                            <a href="#" class="dropdown-item">
                                <div class="dropdown-icon" style="background: rgba(224, 67, 133, 0.15); color: #e04385;"><i class="fa-solid fa-brain"></i></div>
                                <div class="dropdown-info">
                                    <div class="dropdown-title">Generative AI Tools</div>
                                    <div class="dropdown-desc">LLMs, text generation & neural assistants</div>
                                </div>
                            </a>
                            <a href="#" class="dropdown-item">
                                <div class="dropdown-icon" style="background: rgba(164, 53, 138, 0.15); color: #a4358a;"><i class="fa-solid fa-code"></i></div>
                                <div class="dropdown-info">
                                    <div class="dropdown-title">Developer & Code AI</div>
                                    <div class="dropdown-desc">Code copilots, refactoring & automated testing</div>
                                </div>
                            </a>
                            <a href="#" class="dropdown-item">
                                <div class="dropdown-icon" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6;"><i class="fa-solid fa-palette"></i></div>
                                <div class="dropdown-info">
                                    <div class="dropdown-title">Image & Design Generators</div>
                                    <div class="dropdown-desc">Text-to-image, vector graphics & UI tools</div>
                                </div>
                            </a>
                            <a href="#" class="dropdown-item">
                                <div class="dropdown-icon" style="background: rgba(16, 185, 129, 0.15); color: #10b981;"><i class="fa-solid fa-chart-pie"></i></div>
                                <div class="dropdown-info">
                                    <div class="dropdown-title">Data & Business Intelligence</div>
                                    <div class="dropdown-desc">Predictive analytics & executive reporting</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>
                <!-- Industries Dropdown -->
                <li class="nav-dropdown">
                    <a href="#" class="nav-dropdown-trigger">
                        <span>Industries</span>
                        <i class="fa-solid fa-chevron-down nav-arrow"></i>
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-menu-inner">
                            <a href="#" class="dropdown-item">
                                <div class="dropdown-icon" style="background: rgba(245, 158, 11, 0.15); color: #f59e0b;"><i class="fa-solid fa-stethoscope"></i></div>
                                <div class="dropdown-info">
                                    <div class="dropdown-title">Healthcare & Biotech</div>
                                    <div class="dropdown-desc">HIPAA compliant AI, EMR & clinical tools</div>
                                </div>
                            </a>
                            <a href="#" class="dropdown-item">
                                <div class="dropdown-icon" style="background: rgba(16, 185, 129, 0.15); color: #10b981;"><i class="fa-solid fa-building-columns"></i></div>
                                <div class="dropdown-info">
                                    <div class="dropdown-title">Fintech & Banking</div>
                                    <div class="dropdown-desc">Fraud detection, algorithmic trading & compliance</div>
                                </div>
                            </a>
                            <a href="#" class="dropdown-item">
                                <div class="dropdown-icon" style="background: rgba(59, 130, 246, 0.15); color: #3b82f6;"><i class="fa-solid fa-cart-shopping"></i></div>
                                <div class="dropdown-info">
                                    <div class="dropdown-title">E-Commerce & Retail</div>
                                    <div class="dropdown-desc">Personalization engines & inventory AI</div>
                                </div>
                            </a>
                            <a href="#" class="dropdown-item">
                                <div class="dropdown-icon" style="background: rgba(224, 67, 133, 0.15); color: #e04385;"><i class="fa-solid fa-cloud"></i></div>
                                <div class="dropdown-info">
                                    <div class="dropdown-title">Enterprise SaaS</div>
                                    <div class="dropdown-desc">Multi-tenant CRM, ERP & billing platforms</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>

                <!-- Vendors Dropdown -->
                <li class="nav-dropdown">
                    <a href="{{ route('frontend.vendors.crm') }}" class="nav-dropdown-trigger">
                        <span>Vendors</span>
                        <i class="fa-solid fa-chevron-down nav-arrow"></i>
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-menu-inner">
                            <a href="{{ route('frontend.vendors.crm') }}" class="dropdown-item">
                                <div class="dropdown-icon" style="background: rgba(0, 161, 224, 0.15); color: #00a1e0;"><i class="fa-solid fa-cloud"></i></div>
                                <div class="dropdown-info">
                                    <div class="dropdown-title">Salesforce Sales Cloud</div>
                                    <div class="dropdown-desc">Top Enterprise CRM • TechScore 98/100</div>
                                </div>
                            </a>
                            <a href="{{ route('frontend.vendors.crm') }}" class="dropdown-item">
                                <div class="dropdown-icon" style="background: rgba(255, 122, 89, 0.15); color: #ff7a59;"><i class="fa-brands fa-hubspot"></i></div>
                                <div class="dropdown-info">
                                    <div class="dropdown-title">HubSpot Sales Hub</div>
                                    <div class="dropdown-desc">Best for Startups • Free tier available</div>
                                </div>
                            </a>
                            <a href="{{ route('frontend.vendors.crm') }}" class="dropdown-item">
                                <div class="dropdown-icon" style="background: rgba(228, 37, 39, 0.15); color: #e42527;"><i class="fa-solid fa-boxes-stacked"></i></div>
                                <div class="dropdown-info">
                                    <div class="dropdown-title">Zoho CRM</div>
                                    <div class="dropdown-desc">Best Value for SMBs • Zia AI powered</div>
                                </div>
                            </a>
                            <a href="{{ route('frontend.vendors.crm') }}" class="dropdown-item">
                                <div class="dropdown-icon" style="background: rgba(49, 169, 82, 0.15); color: #31a952;"><i class="fa-solid fa-chart-line"></i></div>
                                <div class="dropdown-info">
                                    <div class="dropdown-title">Pipedrive</div>
                                    <div class="dropdown-desc">Visual deal pipelines & sales analytics</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>

                <li><a href="{{ route('frontend.blogs') }}">Blogs</a></li>
            </ul>



            <div class="nav-actions">
                <button class="btn-calc">
                    ROI Calculator <i class="fa-solid fa-arrow-right"></i>
                </button>

                <button class="hamburger-btn" onclick="toggleMenu()" aria-label="Toggle Menu">
                    <i class="fa-solid fa-bars" id="menuToggleIcon"></i>
                </button>
            </div>
        </div>
    </div>
</header>
