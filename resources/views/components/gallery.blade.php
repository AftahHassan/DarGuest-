@props(['images' => [], 'property' => null])

@php
    $imagePaths = $images instanceof \Illuminate\Support\Collection
        ? $images->pluck('image')->values()->toJson()
        : json_encode($images);
    $storageUrl = asset('storage') . '/';
@endphp

<div
    x-data="{
        images: {{ $imagePaths }},
        storageUrl: '{{ $storageUrl }}',
        isOpen: false,
        currentIndex: 0,
        open(index) {
            this.currentIndex = index;
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
        },
        close() {
            this.isOpen = false;
            document.body.style.overflow = '';
        },
        prev() {
            this.currentIndex = this.currentIndex > 0 ? this.currentIndex - 1 : this.images.length - 1;
        },
        next() {
            this.currentIndex = this.currentIndex < this.images.length - 1 ? this.currentIndex + 1 : 0;
        }
    }"
    class="h-full w-full cursor-pointer"
>
    <template x-if="images.length > 0">
        <img :src="storageUrl + images[0]"
             @click="open(0)"
             {{ $attributes->merge(['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500']) }}>
    </template>
    <template x-if="images.length === 0">
        <div class="w-full h-full flex items-center justify-center bg-surface-100">
            {{ $slot ?? '' }}
        </div>
    </template>

    {{-- Lightbox --}}
    <template x-teleport="body">
        <div x-show="isOpen"
             x-transition:enter="transition-opacity duration-300 ease-out"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity duration-200 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center select-none"
             x-on:click.self="close()"
             @keydown.escape.window="close()"
             @keydown.left.window="prev()"
             @keydown.right.window="next()"
             style="display: none;">

            {{-- Close --}}
            <button @click="close()"
                    class="absolute top-4 right-4 z-10 w-10 h-10 rounded-full bg-black/50 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white/70 hover:text-white hover:bg-white/10 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Counter --}}
            <div class="absolute top-4 left-4 z-10 flex items-center gap-2 px-3 py-1.5 rounded-full bg-black/50 backdrop-blur-sm border border-white/10 text-white/70 text-xs font-medium">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.41a2.25 2.25 0 013.182 0l2.909 2.91m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                </svg>
                <span x-text="(currentIndex + 1) + ' / ' + images.length"></span>
            </div>

            {{-- Prev --}}
            <button @click="prev()"
                    x-show="images.length > 1"
                    class="absolute left-4 z-10 w-10 h-10 rounded-full bg-black/50 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white/70 hover:text-white hover:bg-white/10 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </button>

            {{-- Image --}}
            <div class="relative flex items-center justify-center w-full h-full p-16">
                <img :src="storageUrl + images[currentIndex]"
                     :alt="'Image ' + (currentIndex + 1)"
                     class="max-h-full max-w-full object-contain rounded-2xl shadow-2xl">
            </div>

            {{-- Next --}}
            <button @click="next()"
                    x-show="images.length > 1"
                    class="absolute right-4 z-10 w-10 h-10 rounded-full bg-black/50 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white/70 hover:text-white hover:bg-white/10 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                </svg>
            </button>

            {{-- Thumbnails strip --}}
            <div x-show="images.length > 1"
                 class="absolute bottom-4 left-1/2 -translate-x-1/2 z-10 flex items-center gap-2 px-3 py-2 rounded-2xl bg-black/50 backdrop-blur-sm border border-white/10">
                <template x-for="(img, i) in images" :key="i">
                    <button @click="currentIndex = i"
                            :class="i === currentIndex ? 'ring-2 ring-white opacity-100' : 'opacity-50 hover:opacity-80'"
                            class="w-8 h-8 rounded-lg overflow-hidden transition-all duration-200 flex-shrink-0">
                        <img :src="storageUrl + img" class="w-full h-full object-cover">
                    </button>
                </template>
            </div>
        </div>
    </template>
</div>
