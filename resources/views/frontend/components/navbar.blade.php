<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Techanalytica – No Gradient, Solid Glass on Scroll</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary:   '#FE4A97',
            secondary: '#FA7A77',
            accent:    '#A554EF',
            light:     '#EFF2EF',
            dark:      '#353531',
          }
        }
      }
    }
  </script>

  <style>
    /* Center-grow underline on hover */
    .nav-link {
      position: relative;
      display: inline-flex;
      align-items: center;
      padding-bottom: 4px;
      color: #353531;
      transition: color 0.35s ease;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      width: 0;
      height: 2.5px;
      background: linear-gradient(90deg, #FE4A97, #A554EF);
      border-radius: 9999px;
      transform: translateX(-50%) scaleX(0);
      transform-origin: center;
      transition: transform 0.38s cubic-bezier(0.65, 0.05, 0.36, 1);
    }

    .nav-link:hover,
    .nav-link:focus-visible {
      color: #FE4A97;
    }

    .nav-link:hover::after,
    .nav-link:focus-visible::after {
      transform: translateX(-50%) scaleX(1);
    }

    /* Dropdown arrow rotation */
    .has-dropdown svg {
      transition: transform 0.3s ease;
    }

    .has-dropdown:hover svg {
      transform: rotate(180deg);
    }

    /* Glass navbar scroll behavior – SOLID color, no gradient */
    nav {
      transition: all 0.45s cubic-bezier(0.16, 1, 0.3, 1);
      background-color: rgba(239, 242, 239, 0.65);   /* light: #EFF2EF with opacity */
      backdrop-filter: blur(6px);
      border-bottom: 1px solid rgba(229, 231, 235, 0.35);
    }

    nav.scrolled {
      background-color: rgba(239, 242, 239, 0.96);   /* more solid on scroll */
      backdrop-filter: blur(16px);
      box-shadow: 0 10px 25px -10px rgba(0,0,0,0.12);
      border-bottom: 1px solid rgba(229, 231, 235, 0.6);
    }

    nav.scrolled-entering {
      transform: translateY(-50px);
      opacity: 0.82;
    }

    /* Mega menu (Software) hover lift */
    .mega-item:hover {
      background: rgba(254, 74, 151, 0.065);
      transform: translateY(-2px);
    }

    /* Multi-level dropdown (Industries) – CodePen style */
    .dropdown,
    .submenu {
      position: absolute;
      background: rgba(18, 20, 30, 0.95);
      backdrop-filter: blur(14px);
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 12px;
      box-shadow: 0 12px 40px rgba(0,0,0,0.25);
      min-width: 240px;
      padding: 8px 0;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.16s ease;
    }

    .has-dropdown:hover > .dropdown,
    .has-dropdown:focus-within > .dropdown {
      opacity: 1;
      pointer-events: auto;
    }

    .dropdown-item.has-submenu:hover > .submenu,
    .dropdown-item.has-submenu:focus-within > .submenu {
      opacity: 1;
      pointer-events: auto;
    }

    .submenu {
      top: -8px;
      left: 100%;
    }

    .dropdown-item,
    .sub-item {
      display: flex;
      align-items: center;
      padding: 10px 20px;
      color: rgba(255,255,255,0.9);
      text-decoration: none;
      transition: background 0.18s ease;
    }

    .dropdown-item:hover,
    .sub-item:hover {
      background: rgba(255,255,255,0.08);
      color: white;
    }

    .arrow-right {
      margin-left: auto;
      font-size: 0.9rem;
      opacity: 0.7;
    }

    .menu-text {
      @apply text-sm lg:text-base font-medium tracking-wide;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-[#EFF2EF]/40 to-white min-h-screen text-[#353531]">

<!-- NAVBAR -->
<nav class="w-full z-50 fixed top-0" id="navbar">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16 md:h-20 transition-all duration-500">

      <!-- LOGO -->
      <a href="#" class="flex items-center gap-2.5">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary to-accent flex items-center justify-center text-white font-bold text-lg shadow-md">
          TA
        </div>
        <span class="text-xl md:text-2xl font-extrabold bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
          Techanalytica
        </span>
      </a>

      <!-- MENU -->
      <div class="hidden md:flex items-center justify-center flex-1 space-x-8 lg:space-x-10 xl:space-x-12">

        <!-- Software – mega grid (previous style) -->
        <div class="relative group has-dropdown">
          <a href="#" class="nav-link menu-text">
            Software
            <svg class="ml-1.5 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </a>
          <div class="absolute left-1/2 -translate-x-1/2 top-full pt-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 pointer-events-none group-hover:pointer-events-auto w-[720px] max-w-[90vw]">
            <div class="bg-white rounded-2xl shadow-2xl border border-gray-100/70 overflow-hidden p-8">
              <div class="grid grid-cols-2 gap-6">
                <a href="#" class="mega-item flex items-start gap-4 p-5 rounded-xl transition duration-200">
                  <div class="text-3xl flex-shrink-0">💻</div>
                  <div>
                    <h4 class="font-semibold text-dark group-hover:text-primary">Project Management</h4>
                    <p class="text-sm text-gray-600 mt-1">Asana, Monday, ClickUp, Jira</p>
                  </div>
                </a>
                <a href="#" class="mega-item flex items-start gap-4 p-5 rounded-xl transition duration-200">
                  <div class="text-3xl flex-shrink-0">🤝</div>
                  <div>
                    <h4 class="font-semibold text-dark group-hover:text-primary">CRM</h4>
                    <p class="text-sm text-gray-600 mt-1">Salesforce, HubSpot, Zoho</p>
                  </div>
                </a>
                <a href="#" class="mega-item flex items-start gap-4 p-5 rounded-xl transition duration-200">
                  <div class="text-3xl flex-shrink-0">📊</div>
                  <div>
                    <h4 class="font-semibold text-dark group-hover:text-primary">Analytics & BI</h4>
                    <p class="text-sm text-gray-600 mt-1">Tableau, Power BI, Looker</p>
                  </div>
                </a>
                <a href="#" class="mega-item flex items-start gap-4 p-5 rounded-xl transition duration-200">
                  <div class="text-3xl flex-shrink-0">🛒</div>
                  <div>
                    <h4 class="font-semibold text-dark group-hover:text-primary">E-commerce Platforms</h4>
                    <p class="text-sm text-gray-600 mt-1">Shopify, WooCommerce</p>
                  </div>
                </a>
                <a href="#" class="mega-item flex items-start gap-4 p-5 rounded-xl transition duration-200">
                  <div class="text-3xl flex-shrink-0">📧</div>
                  <div>
                    <h4 class="font-semibold text-dark group-hover:text-primary">Marketing Automation</h4>
                    <p class="text-sm text-gray-600 mt-1">ActiveCampaign, Klaviyo</p>
                  </div>
                </a>
                <a href="#" class="mega-item flex items-start gap-4 p-5 rounded-xl transition duration-200">
                  <div class="text-3xl flex-shrink-0">🛠</div>
                  <div>
                    <h4 class="font-semibold text-dark group-hover:text-primary">Dev Tools</h4>
                    <p class="text-sm text-gray-600 mt-1">GitHub, Postman, Docker</p>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Industries – multi-level side dropdown -->
        <div class="relative group has-dropdown">
          <a href="#" class="nav-link menu-text">
            Industries
            <svg class="ml-1.5 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </a>
          <div class="dropdown">
            <div class="dropdown-item has-submenu relative">
              <a href="#" class="flex items-center justify-between w-full">
                Healthcare
                <span class="arrow-right">›</span>
              </a>
              <div class="submenu">
                <a href="#" class="sub-item">Electronic Health Records</a>
                <a href="#" class="sub-item">Telemedicine Platforms</a>
                <a href="#" class="sub-item">Practice Management</a>
                <a href="#" class="sub-item">Medical Billing</a>
              </div>
            </div>
            <div class="dropdown-item has-submenu relative">
              <a href="#" class="flex items-center justify-between w-full">
                Education
                <span class="arrow-right">›</span>
              </a>
              <div class="submenu">
                <a href="#" class="sub-item">Learning Management Systems</a>
                <a href="#" class="sub-item">Student Information Systems</a>
                <a href="#" class="sub-item">Campus Management</a>
              </div>
            </div>
            <div class="dropdown-item has-submenu relative">
              <a href="#" class="flex items-center justify-between w-full">
                Finance & Banking
                <span class="arrow-right">›</span>
              </a>
              <div class="submenu">
                <a href="#" class="sub-item">Core Banking Software</a>
                <a href="#" class="sub-item">FinTech Platforms</a>
                <a href="#" class="sub-item">Accounting & ERP</a>
              </div>
            </div>
            <div class="dropdown-item has-submenu relative">
              <a href="#" class="flex items-center justify-between w-full">
                Retail & E-commerce
                <span class="arrow-right">›</span>
              </a>
              <div class="submenu">
                <a href="#" class="sub-item">POS Systems</a>
                <a href="#" class="sub-item">Inventory Management</a>
                <a href="#" class="sub-item">Omnichannel Solutions</a>
              </div>
            </div>
            <a href="#" class="dropdown-item">Manufacturing</a>
          </div>
        </div>

        <!-- Vendors – simple -->
        <div class="relative group has-dropdown">
          <a href="#" class="nav-link menu-text">
            Vendors
            <svg class="ml-1.5 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </a>
          <div class="dropdown">
            <a href="#" class="dropdown-item">Salesforce</a>
            <a href="#" class="dropdown-item">Microsoft</a>
            <a href="#" class="dropdown-item">Google</a>
            <a href="#" class="dropdown-item">Adobe</a>
            <a href="#" class="dropdown-item">Oracle</a>
          </div>
        </div>

        <a href="#" class="nav-link menu-text">Write a Review</a>
        <a href="#" class="nav-link menu-text">Blog</a>
        <a href="#" class="nav-link menu-text">About Us</a>
      </div>

      <!-- CTA -->
      <div class="hidden md:block flex-shrink-0">
        <a href="#" class="bg-gradient-to-r from-primary via-secondary to-accent text-white font-semibold px-6 py-2.5 rounded-full hover:shadow-xl hover:shadow-primary/30 transition transform hover:-translate-y-0.5 text-sm lg:text-base">
          Join or Login
        </a>
      </div>

      <!-- Hamburger -->
      <button id="mobile-menu-btn" class="md:hidden text-dark focus:outline-none">
        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>
  </div>
</nav>

<!-- Mobile Menu -->
<div id="mobile-menu" class="fixed inset-0 bg-black/60 z-50 hidden">
  <div class="absolute right-0 top-0 bottom-0 w-4/5 max-w-sm bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out">
    <div class="p-6 flex flex-col h-full">
      <div class="flex justify-between items-center mb-10">
        <span class="text-xl font-bold bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">Menu</span>
        <button id="close-menu" class="text-gray-500 hover:text-dark">
          <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
      <nav class="flex flex-col space-y-5 text-base font-medium">
        <a href="#" class="hover:text-primary">Software</a>
        <a href="#" class="hover:text-primary">Industries</a>
        <a href="#" class="hover:text-primary">Vendors</a>
        <a href="#" class="hover:text-primary">Write a Review</a>
        <a href="#" class="hover:text-primary">Blog</a>
        <a href="#" class="hover:text-primary">About Us</a>
        <a href="#" class="bg-gradient-to-r from-primary to-accent text-white py-3 px-6 rounded-full text-center mt-6">Join or Login</a>
      </nav>
    </div>
  </div>
</div>

<!-- Spacer -->
<div class="h-20 md:h-20"></div>

<!-- Test content -->
<div class="min-h-screen flex items-center justify-center text-center px-6">
  <div>
    <h1 class="text-5xl md:text-7xl font-extrabold bg-gradient-to-r from-primary via-secondary to-accent bg-clip-text text-transparent mb-6">
      No Gradient Navbar
    </h1>
    <p class="text-xl text-gray-700 max-w-2xl mx-auto">
      Solid light background + glass effect on scroll (no gradient used)
    </p>
  </div>
</div>

<script>
// Scroll → stronger glass effect
const navbar = document.getElementById('navbar');

window.addEventListener('scroll', () => {
  const scroll = window.scrollY;

  if (scroll > 80) {
    if (!navbar.classList.contains('scrolled')) {
      navbar.classList.add('scrolled-entering');
      setTimeout(() => {
        navbar.classList.remove('scrolled-entering');
        navbar.classList.add('scrolled');
      }, 20);
    }
  } else {
    navbar.classList.remove('scrolled', 'scrolled-entering');
  }
});

// Mobile menu toggle
const btn = document.getElementById('mobile-menu-btn');
const menu = document.getElementById('mobile-menu');
const closeBtn = document.getElementById('close-menu');

btn.addEventListener('click', () => {
  menu.classList.remove('hidden');
  setTimeout(() => menu.querySelector('div').classList.remove('translate-x-full'), 10);
});

closeBtn.addEventListener('click', () => {
  menu.querySelector('div').classList.add('translate-x-full');
  setTimeout(() => menu.classList.add('hidden'), 300);
});

menu.addEventListener('click', (e) => {
  if (e.target === menu) {
    menu.querySelector('div').classList.add('translate-x-full');
    setTimeout(() => menu.classList.add('hidden'), 300);
  }
});
</script>

</body>
</html>