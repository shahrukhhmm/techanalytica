<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <a href="{{ route('frontend.home') }}" class="logo" style="margin-bottom: 16px;">
                    <div class="logo-dots">
                        <div class="logo-dot"></div>
                        <div class="logo-dot"></div>
                        <div class="logo-dot"></div>
                    </div>
                    <span>TechAnalytica</span>
                </a>
                <p style="font-size: 13px; color: var(--text-secondary); max-width: 300px;">
                    The premier platform for discovering, evaluating, and adopting software tools for modern teams.
                </p>
            </div>

            <div class="footer-col">
                <h5>Product</h5>
                <ul>
                    <li><a href="{{ route('frontend.tools.index') }}">Categories</a></li>
                    <li><a href="{{ route('frontend.tools.index') }}">Trending Tools</a></li>
                    <li><a href="{{ route('frontend.compare') }}">Compare Tools</a></li>
                    <li><a href="javascript:void(0)" onclick="openModal('submitToolModal')">Submit Tool</a></li>
                    <li><a href="javascript:void(0)" onclick="openModal('claimToolModal')">Claim AI Tool</a></li>
                </ul>
            </div>


            <div class="footer-col">
                <h5>Company</h5>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h5>Legal</h5>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Cookie Policy</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} TechAnalytica. All rights reserved.</p>
            <div style="display: flex; gap: 16px;">
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                <a href="#"><i class="fa-brands fa-github"></i></a>
            </div>
        </div>
    </div>
</footer>
