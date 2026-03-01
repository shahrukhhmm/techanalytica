<!-- Newsletter Section -->
<section class="py-20 bg-dark text-white overflow-hidden relative">
    <div class="absolute top-0 right-0 w-96 h-96 bg-primary/20 rounded-full blur-[120px] -mr-48 -mt-48"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-accent/20 rounded-full blur-[120px] -ml-48 -mb-48"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 md:p-16 text-center">
            <h2 class="text-3xl md:text-5xl font-extrabold mb-6">
                Stay Ahead of the <span
                    class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">Tech Curve</span>
            </h2>
            <p class="text-gray-400 text-lg md:text-xl max-w-2xl mx-auto mb-10">
                Get the latest software reviews, industry insights, and tech trends delivered straight to your inbox
                every week.
            </p>

            <form id="newsletter-form" class="max-w-md mx-auto flex flex-col sm:flex-row gap-4">
                <input type="email" id="newsletter-email" placeholder="Enter your email address" required
                    class="flex-1 bg-white/10 border border-white/20 rounded-full px-6 py-4 text-white focus:outline-none focus:ring-2 focus:ring-primary/50 placeholder:text-gray-500">
                <button type="submit"
                    class="bg-gradient-to-r from-primary to-accent text-white font-bold px-8 py-4 rounded-full hover:shadow-xl hover:shadow-primary/30 transition transform hover:-translate-y-1">
                    Subscribe
                </button>
            </form>
            <p id="newsletter-message" class="mt-4 text-sm hidden"></p>
        </div>
    </div>
</section>

<script>
    document.getElementById('newsletter-form').addEventListener('submit', async (e) => {
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
                body: JSON.stringify({
                    email
                })
            });

            const data = await response.json();

            if (response.ok) {
                message.innerText = data.message;
                message.className = 'mt-4 text-sm text-green-400 font-medium';
                message.classList.remove('hidden');
                e.target.reset();
            } else {
                message.innerText = data.errors?.email?.[0] || 'Something went wrong. Please try again.';
                message.className = 'mt-4 text-sm text-red-400 font-medium';
                message.classList.remove('hidden');
            }
        } catch (error) {
            message.innerText = 'Network error. Please check your connection.';
            message.className = 'mt-4 text-sm text-red-400 font-medium';
            message.classList.remove('hidden');
        } finally {
            button.disabled = false;
            button.innerText = 'Subscribe';
        }
    });
</script>
