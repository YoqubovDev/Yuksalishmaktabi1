<body class="bg-gray-50" x-data="{ 
    showZoom: false, 
    zoomImage: '',
    openZoom(img) {
        this.zoomImage = img;
        this.showZoom = true;
        document.body.style.overflow = 'hidden';
    },
    closeZoom() {
        this.showZoom = false;
        document.body.style.overflow = '';
    }
}" @keydown.escape.window="closeZoom()">
<x-header></x-header>
<style>
    .badge-oltin { background-color: #FEF3C7; color: #92400E; border: 1px solid #F59E0B; }
    .badge-kumush { background-color: #F3F4F6; color: #374151; border: 1px solid #9CA3AF; }
    .badge-bronza { background-color: #FFEDD5; color: #9A3412; border: 1px solid #EA580C; }
    .badge-default { background-color: #E0E7FF; color: #3730A3; border: 1px solid #6366F1; }
    [x-cloak] { display: none !important; }
</style>

    <!-- Achievements Section Header -->
    <section id="achievements" class="py-16 bg-gradient-to-b from-blue-900 to-blue-800">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-white mb-4">Talabalar yutuqlari</h2>
                <div class="w-24 h-1 bg-yellow-400 mx-auto mb-6"></div>
                <p class="text-blue-100 max-w-2xl mx-auto">Iqtidorli talabalarimizning yuksak natijalari va a'lo
                    yutuqlarini e'tirof etamiz</p>
            </div>
        </div>
    </section>

    <!-- Achievements Cards - Database dan ma'lumotlar -->
    <section class="py-12 md:py-16 -mt-12 md:-mt-24">
        <div class="container mx-auto px-4">
            @if($achievements->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-600 text-xl">Hozircha yutuqlar qo'shilmagan</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($achievements as $achievement)
                <div @click="openZoom('{{ $achievement->image ? asset('storage/' . $achievement->image) : '' }}')"
                    class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl cursor-pointer group">
                    <div class="h-56 w-full relative overflow-hidden">
                        @if($achievement->image)
                        <img src="{{ asset('storage/' . $achievement->image) }}" class="w-full h-full object-cover"
                            alt="{{ $achievement->name }}">
                        @else
                        <div
                            class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                            <i class="fas fa-trophy text-white text-6xl"></i>
                        </div>
                        @endif
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all flex items-center justify-center">
                            <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 transform scale-50 group-hover:scale-100 transition-all text-3xl"></i>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800">{{ $achievement->name }}</h3>
                            @if($achievement->badge)
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                            @if(stripos($achievement->badge, 'oltin') !== false || stripos($achievement->badge, 'gold') !== false)
                                                badge-oltin
                                            @elseif(stripos($achievement->badge, 'kumush') !== false || stripos($achievement->badge, 'silver') !== false)
                                                badge-kumush
                                            @elseif(stripos($achievement->badge, 'bronza') !== false || stripos($achievement->badge, 'bronze') !== false)
                                                badge-bronza
                                            @else
                                                badge-default
                                            @endif
                                        ">
                                {{ $achievement->badge }}
                            </span>
                            @endif
                        </div>
                        <p class="text-gray-600 mb-4">{{ $achievement->description }}</p>
                        @if($achievement->category)
                        <div class="mt-4">
                            <span
                                class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">
                                <i class="fas fa-tag mr-1"></i>{{ $achievement->category }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    <!-- Achievements Counter -->
    <section class="py-12 md:py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">


            <div class="text-center">
                <div class="text-5xl font-bold text-blue-600 mb-2 counter" data-target="{{ $stats?->cefr ?? 0 }}">0</div>
                <div class="text-gray-600 font-medium">CEFR sertifikatlari</div>
            </div>


            <div class="text-center">
                <div class="text-5xl font-bold text-blue-600 mb-2 counter" data-target="{{ $stats?->universitet ?? 0 }}">0</div>
                <div class="text-gray-600 font-medium">Universitetlarga qabul %</div>
            </div>


            <div class="text-center">
                <div class="text-5xl font-bold text-blue-600 mb-2 counter" data-target="{{ $stats?->ielts ?? 0 }}">0</div>
                <div class="text-gray-600 font-medium">IELTS yuqori balllar</div>
            </div>


            <div class="text-center">
                <div class="text-5xl font-bold text-blue-600 mb-2 counter" data-target="{{ $stats?->sat ?? 0 }}">0</div>
                <div class="text-gray-600 font-medium">SAT yuqori balllar</div>
            </div>


        </div>
    </div>
</section>


<script>
    const counters = document.querySelectorAll('.counter');
    const speed = 150;


    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const inc = target / speed;


            if(count < target) {
                counter.innerText = Math.ceil(count + inc);
                requestAnimationFrame(updateCount);
            } else {
                counter.innerText = target;
            }
        };


        updateCount();
    });
</script>

    <!-- Footer -->
    <x-footer></x-footer>


    <!-- Counter Animation Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.counter');
        const speed = 200;

        const animateCounter = (counter) => {
            const target = +counter.getAttribute('data-target');
            const increment = target / speed;
            let count = 0;

            const updateCount = () => {
                count += increment;
                if (count < target) {
                    counter.innerText = Math.ceil(count);
                    setTimeout(updateCount, 10);
                } else {
                    counter.innerText = target;
                }
            };

            updateCount();
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        });

        counters.forEach(counter => observer.observe(counter));
    });
    </script>

    <!-- Zoom Modal -->
    <div x-show="showZoom" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[3000] flex items-center justify-center p-4 bg-black bg-opacity-90" 
         x-cloak
         @click="closeZoom()">
        
        <div class="relative max-w-5xl w-full h-full flex items-center justify-center">
            <button @click="closeZoom()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10 p-2 bg-white bg-opacity-10 rounded-full transition-colors">
                <i class="fas fa-times text-2xl"></i>
            </button>
            <img :src="zoomImage" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl" @click.stop alt="Zoomed view">
        </div>
    </div>
</body>
</html>
