<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col" style="max-width: 340px;">
                <a href="{{ route('frontend.home') }}" class="logo" style="margin-bottom: 18px; display: inline-flex;">
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
                <p style="font-size: 14px; color: var(--text-secondary); line-height: 1.65; margin-bottom: 22px;">
                    Sharper thinking for the people building what's next. Independent benchmarks, deep-dive software comparisons, and editorial research for high-velocity teams.
                </p>
                <div style="display: flex; gap: 12px;">
                    <a href="https://twitter.com" target="_blank" rel="noopener" class="footer-social-btn" aria-label="Twitter"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                    <a href="https://linkedin.com" target="_blank" rel="noopener" class="footer-social-btn" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="https://github.com" target="_blank" rel="noopener" class="footer-social-btn" aria-label="GitHub"><i class="fa-brands fa-github"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h5>Editorial Hub</h5>
                <ul>
                    <li><a href="{{ route('frontend.blogs') }}">All Insights</a></li>
                    <li><a href="{{ route('frontend.blogs') }}">Deep Dives & Cases</a></li>
                    <li><a href="{{ route('frontend.blogs') }}">Trends & Reports</a></li>
                    <li><a href="{{ route('frontend.blogs') }}">Founder Stories</a></li>
                    <li><a href="{{ route('frontend.blogs') }}">Research & Data</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h5>Software Directory</h5>
                <ul>
                    <li><a href="{{ route('frontend.tools.index') }}">Browse Directory</a></li>
                    <li><a href="{{ route('frontend.leaderboard') }}">TechScore Leaderboard</a></li>
                    <li><a href="{{ route('frontend.compare') }}">Side-by-Side Comparison</a></li>
                    <li><a href="javascript:void(0)" onclick="openModal('submitToolModal')">Submit AI Software</a></li>
                    <li><a href="javascript:void(0)" onclick="openModal('claimToolModal')">Claim Vendor Profile</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h5>Platform & Legal</h5>
                <ul>
                    <li><a href="{{ route('frontend.home') }}">About TechAnalytica</a></li>
                    <li><a href="{{ route('frontend.tools.index') }}">Evaluation Criteria</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Editorial Standards</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} TechAnalytica. All rights reserved. Built for engineering and product decision-makers.</p>
            <div style="display: flex; gap: 24px; font-size: 13px; color: var(--text-secondary);">
                <span>System Status: <span style="color: #10b981; font-weight: 600;">Operational</span></span>
                <span>Version: <span style="color: #fff; font-weight: 600;">2026.1</span></span>
            </div>
        </div>
    </div>
</footer>
