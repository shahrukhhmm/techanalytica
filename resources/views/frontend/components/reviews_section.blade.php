<!-- Reviews Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
            <div class="max-w-2xl">
                <h2 class="text-3xl md:text-5xl font-extrabold text-dark mb-4">
                    User <span
                        class="bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">Reviews</span>
                </h2>
                <p class="text-gray-600 text-lg">
                    Real feedback from real users. See what people are saying or share your own experience.
                </p>
            </div>
            <button onclick="document.getElementById('review-modal').classList.remove('hidden')"
                class="bg-dark text-white font-bold px-8 py-4 rounded-full hover:bg-primary transition shadow-lg shrink-0">
                Write a Review
            </button>
        </div>

        <!-- Review Grid (Sample) -->
        <div id="reviews-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Reviews will be loaded here via JS -->
            <div class="animate-pulse flex space-x-4 p-6 bg-gray-50 rounded-2xl">
                <div class="flex-1 space-y-4 py-1">
                    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                    <div class="space-y-2">
                        <div class="h-4 bg-gray-200 rounded"></div>
                        <div class="h-4 bg-gray-200 rounded w-5/6"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div id="review-modal" class="fixed inset-0 bg-black/60 z-[60] flex items-center justify-center hidden px-4">
        <div
            class="bg-white rounded-3xl w-full max-w-xl overflow-hidden shadow-2xl transform transition-all p-8 md:p-12 relative">
            <button onclick="document.getElementById('review-modal').classList.add('hidden')"
                class="absolute top-6 right-6 text-gray-400 hover:text-dark transition">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <h3 class="text-2xl font-bold mb-8">Submit Your Review</h3>

            <form id="review-form" class="space-y-6">
                <input type="hidden" name="tool_id" value="{{ $tool_id ?? '' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                        <input type="text" name="user_name" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/40 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" name="user_email" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/40 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Rating</label>
                    <div class="flex gap-2" id="star-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" data-rating="{{ $i }}"
                                class="star-btn text-gray-300 hover:text-primary transition">
                                <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                                </svg>
                            </button>
                        @endfor
                        <input type="hidden" name="rating" id="rating-input" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Comment</label>
                    <textarea name="comment" rows="4" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-primary/40 focus:bg-white transition"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-primary to-accent text-white font-bold py-4 rounded-xl hover:shadow-xl hover:shadow-primary/30 transition transform hover:-translate-y-1">
                    Submit Review
                </button>
                <p id="review-message" class="text-sm text-center hidden"></p>
            </form>
        </div>
    </div>
</section>

<script>
    // Star Rating Logic
    const stars = document.querySelectorAll('.star-btn');
    const ratingInput = document.getElementById('rating-input');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = star.getAttribute('data-rating');
            ratingInput.value = rating;

            stars.forEach(s => {
                const r = s.getAttribute('data-rating');
                if (r <= rating) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-primary');
                } else {
                    s.classList.add('text-gray-300');
                    s.classList.remove('text-primary');
                }
            });
        });
    });

    // Submit Logic
    document.getElementById('review-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());
        const message = document.getElementById('review-message');
        const button = e.target.querySelector('button');

        if (!data.rating) {
            alert('Please select a rating');
            return;
        }

        button.disabled = true;
        button.innerText = 'Submitting...';

        try {
            const response = await fetch('/api/reviews', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok) {
                message.innerText = 'Review submitted successfully! It will appear once approved.';
                message.className = 'text-sm text-center text-green-500 font-medium';
                message.classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('review-modal').classList.add('hidden');
                    e.target.reset();
                    stars.forEach(s => s.classList.replace('text-primary', 'text-gray-300'));
                    message.classList.add('hidden');
                }, 3000);
            } else {
                message.innerText = result.errors ? Object.values(result.errors)[0][0] :
                    'Error submitting review.';
                message.className = 'text-sm text-center text-red-500 font-medium';
                message.classList.remove('hidden');
            }
        } catch (error) {
            message.innerText = 'Network error.';
            message.className = 'text-sm text-center text-red-500 font-medium';
            message.classList.remove('hidden');
        } finally {
            button.disabled = false;
            button.innerText = 'Submit Review';
        }
    });
</script>
