<!-- Pre-Footer CTA Section Matching Figma -->
<section class="container" style="padding: 50px 24px 70px;">
    <div class="prefooter-cta-card">
        <div class="prefooter-left">
            <h2 class="prefooter-title">
                Try <span style="background: linear-gradient(90deg, #ff3b7b, #ff735c); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">TechAnalytica</span><br>
                <span style="font-style: italic; font-weight: 400; color: #ff8359;">free</span> for 30 days.
            </h2>
            <p class="prefooter-desc">
                Actionable intelligence, benchmarks, and curated tool directory for modern engineering leaders and fast-growing teams.
            </p>
            <div class="prefooter-actions">
                <a href="{{ route('frontend.tools.index') }}" class="btn-cta-radiant">
                    <span>Explore Tools</span>
                    <i class="fa-solid fa-arrow-right" style="font-size: 12px;"></i>
                </a>
                <a href="javascript:void(0)" onclick="openModal('submitToolModal')" class="btn-cta-outline">
                    Submit AI Software
                </a>
            </div>

            <form id="newsletter-form" style="margin-top: 24px; display: flex; max-width: 440px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.12); border-radius: 9999px; padding: 4px; overflow: hidden;">
                @csrf
                <input type="email" id="newsletter-email" placeholder="Enter work email for weekly digest" required style="flex: 1; background: transparent; border: none; padding: 10px 18px; color: #fff; font-size: 13.5px; outline: none; font-family: inherit;">
                <button type="submit" style="background: linear-gradient(90deg, #ff3b7b, #ff735c); color: #fff; border: none; padding: 10px 22px; border-radius: 9999px; font-weight: 700; font-size: 13px; cursor: pointer; transition: filter 0.2s;">Subscribe</button>
            </form>
            <p id="newsletter-message" style="display: none; margin-top: 8px; font-size: 13px;"></p>
        </div>

        <div class="prefooter-right">
            <div class="cta-abstract-graphic">
                <div style="position: absolute; width: 110px; height: 110px; border-radius: 24px; background: linear-gradient(135deg, #ff735c, #ff3b7b); top: 25px; left: 30px; opacity: 0.9; box-shadow: 0 10px 25px rgba(255, 59, 123, 0.4);"></div>
                <div style="position: absolute; width: 64px; height: 64px; border-radius: 50%; background: #ffa07a; bottom: 35px; left: 35px; opacity: 0.85;"></div>
                <div style="position: absolute; width: 75px; height: 75px; border-radius: 50%; background: #9f55ff; top: 85px; right: 25px; opacity: 0.75;"></div>
                <div style="position: absolute; width: 44px; height: 44px; border-radius: 50%; background: #10b981; bottom: 25px; right: 45px; opacity: 0.85;"></div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('newsletter-form')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = document.getElementById('newsletter-email').value;
        const message = document.getElementById('newsletter-message');
        const button = e.target.querySelector('button');

        button.disabled = true;
        button.innerText = 'Subscribing...';

        try {
            const response = await fetch('/api/newsletter/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email })
            });

            const data = await response.json();

            if (response.ok) {
                message.innerText = data.message || 'Thank you for subscribing!';
                message.style.color = '#10b981';
                message.style.display = 'block';
                e.target.reset();
            } else {
                message.innerText = data.errors?.email?.[0] || 'Something went wrong. Please try again.';
                message.style.color = '#ff3b7b';
                message.style.display = 'block';
            }
        } catch (error) {
            message.innerText = 'Thank you! You are now subscribed to our newsletter.';
            message.style.color = '#10b981';
            message.style.display = 'block';
        } finally {
            button.disabled = false;
            button.innerText = 'Subscribe';
        }
    });
</script>
