<footer>
    {{-- Gradient accent line at top --}}
    <div style="height: 2px; background: linear-gradient(90deg, transparent 0%, #ff3b7b 30%, #e04385 60%, transparent 100%); margin-bottom: 0;"></div>

    <div class="container">

        {{-- Top footer: brand + newsletter + links --}}
        <div class="footer-top-grid">

            {{-- Brand Column --}}
            <div class="footer-brand-col">
                <a href="{{ route('frontend.home') }}" class="logo" style="margin-bottom: 20px; display: inline-flex;">
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
                <p class="footer-brand-desc">
                    Sharper thinking for the people building what's next. Independent benchmarks, deep-dive software comparisons, and editorial research for high-velocity teams.
                </p>
                {{-- Newsletter --}}
                <div class="footer-newsletter">
                    <div class="footer-newsletter-label"><i class="fa-solid fa-envelope-open-text"></i> Weekly AI Insights — Free</div>
                    <form class="footer-newsletter-form" onsubmit="return false;">
                        <input type="email" placeholder="your@email.com" class="footer-email-input" />
                        <button type="submit" class="footer-subscribe-btn">Subscribe</button>
                    </form>
                </div>
                {{-- Social --}}
                <div class="footer-socials">
                    <a href="https://twitter.com" target="_blank" rel="noopener" class="footer-social-btn" aria-label="Twitter / X">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="https://linkedin.com" target="_blank" rel="noopener" class="footer-social-btn" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="https://github.com" target="_blank" rel="noopener" class="footer-social-btn" aria-label="GitHub"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="footer-social-btn" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            {{-- Link Columns --}}
            <div class="footer-links-grid">
                <div class="footer-col">
                    <h5>Editorial</h5>
                    <ul>
                        <li><a href="{{ route('frontend.blogs') }}">All Insights</a></li>
                        <li><a href="{{ route('frontend.blogs') }}">Deep Dives &amp; Cases</a></li>
                        <li><a href="{{ route('frontend.blogs') }}">Trends &amp; Reports</a></li>
                        <li><a href="{{ route('frontend.blogs') }}">Founder Stories</a></li>
                        <li><a href="{{ route('frontend.blogs') }}">Research &amp; Data</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h5>Directory</h5>
                    <ul>
                        <li><a href="{{ route('frontend.tools.index') }}">Browse Tools</a></li>
                        <li><a href="{{ route('frontend.leaderboard') }}">TechScore Leaderboard</a></li>
                        <li><a href="{{ route('frontend.vendors.index') }}">Vendors</a></li>
                        <li><a href="{{ route('frontend.compare') }}">Compare Software</a></li>
                        <li><a href="javascript:void(0)" onclick="openModal('submitToolModal')">Submit AI Software</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h5>Company</h5>
                    <ul>
                        <li><a href="{{ route('frontend.about') }}">About Us</a></li>
                        <li><a href="{{ route('frontend.tools.index') }}">Evaluation Criteria</a></li>
                        <li><a href="javascript:void(0)" onclick="openModal('claimToolModal')">Claim Vendor Profile</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Editorial Standards</a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Divider --}}
        <div class="footer-divider"></div>

        {{-- Bottom Bar --}}
        <div class="footer-bottom">
            <div class="footer-bottom-left">
                <span>&copy; {{ date('Y') }} TechAnalytica. All rights reserved.</span>
                <span class="footer-bottom-dot">·</span>
                <span>Built for engineering &amp; product teams.</span>
            </div>
            <div class="footer-bottom-right">
                <span class="footer-status-pill">
                    <span class="footer-status-dot"></span> All Systems Operational
                </span>
                <span style="color: var(--text-muted); font-size: 12px;">v2026.1</span>
            </div>
        </div>
    </div>
</footer>

