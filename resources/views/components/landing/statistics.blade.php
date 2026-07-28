<section class="relative py-20 overflow-hidden bg-white border-y border-surface-200">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-12">
            @php
                $stats = [
                    ['value' => '500', 'suffix' => '+', 'label' => 'Logements', 'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25'],
                    ['value' => '12', 'suffix' => 'k+', 'label' => 'Voyageurs', 'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z'],
                    ['value' => '98', 'suffix' => '%', 'label' => 'Satisfaction', 'icon' => 'M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z'],
                    ['value' => '24/7', 'suffix' => '', 'label' => 'Assistant IA', 'icon' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z']
                ];
            @endphp

            @foreach ($stats as $i => $stat)
                <div data-aos="fade-up" data-aos-delay="{{ $i * 100 }}" class="text-center">
                    <div class="w-12 h-12 rounded-xl bg-navy-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-navy-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}"/>
                        </svg>
                    </div>
                    <div class="text-3xl sm:text-4xl font-bold text-navy-700 tracking-tight">
                        <span x-data="{ count: 0 }"
                              x-init="const el = $el; const observer = new IntersectionObserver((entries) => {
                                  if (entries[0].isIntersecting) {
                                      const target = {{ $stat['value'] }};
                                      if (typeof target === 'number') {
                                          let start = 0, end = target, duration = 2000, interval = 16;
                                          let timer = setInterval(() => {
                                              start += Math.ceil(end / (duration / interval));
                                              if (start >= end) { start = end; clearInterval(timer); }
                                              el.textContent = start;
                                          }, interval);
                                      }
                                      observer.disconnect();
                                  }
                              }); observer.observe(el)">
                            {{ $stat['value'] }}
                        </span>
                        <span>{{ $stat['suffix'] }}</span>
                    </div>
                    <p class="text-sm text-surface-500 mt-1">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>