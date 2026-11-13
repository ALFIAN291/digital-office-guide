@props([
    'message',
    'chapters' => [],
    'scenes' => [],
    'compact' => false,
    'autoplay' => true,
])

@php
    $rawList = $message->chapters_list ?? [];
    $fallbackUrl = trim($message->video_url ?? '');

    $videoPlaylist = collect($rawList)->map(function ($item, $idx) use ($message) {
        $url = trim((string) ($item['video_url'] ?? ''));
        $title = trim((string) ($item['title'] ?? ''));
        if ($title === '') {
            $title = $idx === 0 ? ($message->title ?: 'Video Sambutan Manajemen') : ('Video ' . ($idx + 1));
        }
        return [
            'id' => $item['id'] ?? ('vid-' . ($idx + 1)),
            'title' => $title,
            'video_url' => $url,
        ];
    })->filter(function ($item) {
        return $item['video_url'] !== '' || $item['title'] !== '';
    })->values()->all();

    if (empty($videoPlaylist)) {
        $videoPlaylist = [
            [
                'id' => 'vid-1',
                'title' => $message->title ?: 'Sambutan Manajemen Akebono Karawang',
                'video_url' => $fallbackUrl,
            ]
        ];
    }
@endphp

<div class="space-y-3"
     x-data="{
        playlist: {{ Js::from($videoPlaylist) }},
        activeIndex: 0,
        shouldAutoplay: {{ $autoplay ? 'true' : 'false' }},

        get currentVideo() {
            return this.playlist[this.activeIndex] || this.playlist[0] || { title: 'Video Sambutan', video_url: '' };
        },

        extractYoutubeId(url) {
            if (!url) return null;
            const m = url.match(/(?:youtube\.com\/(?:watch\?(?:.*&)?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{6,})/);
            return m ? m[1] : null;
        },

        isYoutube(url) {
            return !!this.extractYoutubeId(url);
        },

        youtubeEmbedUrl(url) {
            const ytId = this.extractYoutubeId(url);
            if (!ytId) return url;
            const auto = this.shouldAutoplay ? '1' : '0';
            return 'https://www.youtube.com/embed/' + ytId + '?autoplay=' + auto + '&rel=0&modestbranding=1&playsinline=1';
        },

        videoThumbnail(url) {
            const ytId = this.extractYoutubeId(url);
            if (ytId) {
                return 'https://img.youtube.com/vi/' + ytId + '/mqdefault.jpg';
            }
            return '{{ asset('images/hero-office.jpg') }}';
        },

        selectVideo(idx) {
            this.activeIndex = idx;
            this.shouldAutoplay = true;
            this.$nextTick(() => {
                if (this.$refs.directVideo && !this.isYoutube(this.currentVideo.video_url)) {
                    this.$refs.directVideo.load();
                    this.$refs.directVideo.play().catch(() => {});
                }
            });
        }
     }">

    @auth
        <div class="flex items-center justify-between gap-2 px-3.5 py-2 rounded-xl bg-sky-50 border border-sky-200 text-xs">
            <span class="font-bold text-[#0f2e54] truncate" x-text="'🎬 Memutar: ' + currentVideo.title"></span>
            <a href="{{ route('admin.message.edit') }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-[#0084f8] hover:bg-[#006fd6] text-white font-extrabold text-[11px] transition shrink-0">
                <span>+ Kelola Daftar Video di Admin</span>
            </a>
        </div>
    @endauth

    <div class="grid grid-cols-1 {{ $compact ? 'md:grid-cols-12' : 'lg:grid-cols-12' }} gap-3 sm:gap-4 items-start">

        <!-- Left Side: Direct Video Player (Autoplays Immediately) -->
        <div class="{{ $compact ? 'md:col-span-8' : 'lg:col-span-8' }} space-y-2">
            <div class="relative w-full aspect-video rounded-2xl overflow-hidden bg-slate-950 border border-slate-200 shadow-sm flex items-center justify-center">

                <!-- 1. YouTube Direct Embed (Autoplay) -->
                <template x-if="currentVideo.video_url && isYoutube(currentVideo.video_url)">
                    <iframe :key="currentVideo.id + '-' + activeIndex"
                            :src="youtubeEmbedUrl(currentVideo.video_url)"
                            :title="currentVideo.title"
                            class="w-full h-full"
                            frameborder="0"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                </template>

                <!-- 2. Uploaded MP4 / Direct Video File (Autoplay) -->
                <template x-if="currentVideo.video_url && !isYoutube(currentVideo.video_url)">
                    <video x-ref="directVideo"
                           :key="currentVideo.id + '-' + activeIndex"
                           :src="currentVideo.video_url"
                           controls
                           autoplay
                           playsinline
                           class="w-full h-full object-contain bg-black"></video>
                </template>

                <!-- 3. Empty State if Admin hasn't added any video URL/file yet -->
                <template x-if="!currentVideo.video_url">
                    <div class="text-center p-6 text-white space-y-2">
                        <div class="text-3xl">🎬</div>
                        <div class="text-sm font-extrabold">Belum Ada Video Terpasang</div>
                        <p class="text-xs text-slate-400 max-w-xs mx-auto">Silakan tambahkan Link YouTube atau Upload File Video MP4 melalui menu Admin.</p>
                        @auth
                            <a href="{{ route('admin.message.edit') }}"
                               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#0084f8] hover:bg-[#006fd6] text-white text-xs font-extrabold transition mt-1">
                                <span>+ Tambah Video Sekarang</span>
                            </a>
                        @endauth
                    </div>
                </template>
            </div>

            <!-- Active Video Title Bar below player -->
            <div class="flex items-center justify-between gap-2 px-3 py-2 rounded-xl bg-slate-50 border border-slate-200/80">
                <div class="flex items-center gap-2 min-w-0">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shrink-0"></span>
                    <span class="text-xs sm:text-sm font-extrabold text-[#0f2e54] truncate" x-text="currentVideo.title"></span>
                </div>
                <span class="text-[10px] font-bold text-[#0084f8] bg-sky-50 border border-sky-200 px-2 py-0.5 rounded-full shrink-0"
                      x-text="'Video ' + (activeIndex + 1) + ' / ' + playlist.length"></span>
            </div>
        </div>

        <!-- Right Side: Daftar Nama Video (Video Playlist) -->
        <div class="{{ $compact ? 'md:col-span-4' : 'lg:col-span-4' }} bg-slate-50/80 rounded-2xl border border-slate-200/80 p-2.5 space-y-2">
            <div class="flex items-center justify-between px-1 pt-0.5">
                <span class="text-xs font-extrabold text-[#0f2e54]">Daftar Video</span>
                <span class="text-[10px] font-bold text-slate-400" x-text="playlist.length + ' Video'"></span>
            </div>

            <div class="flex flex-col gap-2 max-h-[260px] sm:max-h-[300px] overflow-y-auto pr-0.5">
                <template x-for="(vid, idx) in playlist" :key="vid.id + '-' + idx">
                    <button type="button" @click="selectVideo(idx)"
                            class="w-full text-left p-2 rounded-xl border transition flex items-center gap-2.5 cursor-pointer group"
                            :class="activeIndex === idx ? 'bg-white border-[#0084f8] shadow-xs ring-2 ring-[#0084f8]/20' : 'bg-white/80 border-slate-200/80 hover:bg-white hover:border-sky-300'">
                        <!-- Video Thumbnail -->
                        <div class="relative w-16 h-11 rounded-lg overflow-hidden shrink-0 bg-slate-900 flex items-center justify-center">
                            <img :src="videoThumbnail(vid.video_url)" :alt="vid.title" class="w-full h-full object-cover opacity-90">
                            <div class="absolute inset-0 bg-slate-950/30 flex items-center justify-center">
                                <span class="w-5 h-5 rounded-full flex items-center justify-center text-[9px] font-bold text-white shadow-xs"
                                      :class="activeIndex === idx ? 'bg-[#0084f8]' : 'bg-slate-900/75 group-hover:bg-[#0084f8]'">
                                    ▶
                                </span>
                            </div>
                        </div>

                        <!-- Nama Video Langsung -->
                        <div class="min-w-0 flex-1">
                            <div class="text-xs font-extrabold leading-snug line-clamp-2"
                                 :class="activeIndex === idx ? 'text-[#0084f8]' : 'text-[#0f2e54] group-hover:text-[#0084f8]'"
                                 x-text="vid.title"></div>
                            <div class="text-[10px] font-semibold mt-0.5"
                                 :class="activeIndex === idx ? 'text-emerald-600' : 'text-slate-400'"
                                 x-text="activeIndex === idx ? '● Sedang Diputar' : 'Klik untuk putar'"></div>
                        </div>
                    </button>
                </template>
            </div>
        </div>

    </div>
</div>
