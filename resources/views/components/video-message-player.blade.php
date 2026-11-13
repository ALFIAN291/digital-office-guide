@props([
    'message',
    'chapters' => [],
    'scenes' => [],
    'compact' => false,
])

@php
    $chaptersData = !empty($chapters) ? $chapters : \App\Support\OfficeConceptData::defaultVideoChapters();
    $scenesData = !empty($scenes) ? $scenes : \App\Support\OfficeConceptData::videoSceneStrip();
    $videoUrl = trim($message->video_url ?? '');
    $durationText = $message->video_duration ?? '1:18';
    $japaneseTagline = $message->japanese_tagline ?? '新しい職場で、ともに次の未来へ';
@endphp

<div class="space-y-3"
     x-data="{
        chapters: {{ Js::from($chaptersData) }},
        activeChapter: 0,
        isPlaying: false,
        currentTime: 0,
        totalSeconds: 78,
        timer: null,
        videoUrl: {{ Js::from($videoUrl) }},
        isYoutube() {
            return this.videoUrl.includes('youtube.com') || this.videoUrl.includes('youtu.be');
        },
        youtubeEmbedUrl() {
            const match = this.videoUrl.match(/(?:v=|youtu\.be\/|embed\/)([A-Za-z0-9_-]{6,})/);
            return match ? 'https://www.youtube.com/embed/' + match[1] + '?autoplay=1&rel=0' : this.videoUrl;
        },
        togglePlay() {
            if (this.videoUrl && !this.isYoutube()) {
                this.isPlaying = !this.isPlaying;
                this.$nextTick(() => {
                    if (this.$refs.htmlVideo) {
                        if (this.isPlaying) {
                            this.$refs.htmlVideo.play().catch(() => {});
                        } else {
                            this.$refs.htmlVideo.pause();
                        }
                    }
                });
                return;
            }
            this.isPlaying = !this.isPlaying;
            if (this.isPlaying && !this.isYoutube()) {
                this.startTimer();
            } else {
                this.stopTimer();
            }
        },
        startTimer() {
            this.stopTimer();
            this.timer = setInterval(() => {
                if (this.currentTime >= this.totalSeconds) {
                    this.currentTime = 0;
                    this.activeChapter = 0;
                    this.isPlaying = false;
                    this.stopTimer();
                    return;
                }
                this.currentTime++;
                for (let i = this.chapters.length - 1; i >= 0; i--) {
                    if (this.currentTime >= (this.chapters[i].seconds ?? 0)) {
                        this.activeChapter = i;
                        break;
                    }
                }
            }, 1000);
        },
        stopTimer() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
        },
        selectChapter(index) {
            this.activeChapter = index;
            const sec = this.chapters[index]?.seconds ?? 0;
            this.currentTime = sec;
            if (this.videoUrl && !this.isYoutube()) {
                this.isPlaying = true;
                this.$nextTick(() => {
                    if (this.$refs.htmlVideo) {
                        this.$refs.htmlVideo.currentTime = sec;
                        this.$refs.htmlVideo.play().catch(() => {});
                    }
                });
            }
        },
        formatTime(s) {
            const m = Math.floor(s / 60);
            const rem = s % 60;
            return m + ':' + (rem < 10 ? '0' + rem : rem);
        },
        get currentChapter() {
            return this.chapters[this.activeChapter] || this.chapters[0];
        }
     }"
     @keydown.escape.window="stopTimer()">

    @auth
        <div class="flex items-center justify-between gap-2 px-3.5 py-2 rounded-xl bg-sky-50 border border-sky-200 text-xs">
            <span class="font-bold text-[#0f2e54]">
                🎬 Status Video: {{ !empty($videoUrl) ? 'Video Kustom Aktif (' . $videoUrl . ')' : 'Storyboard Interaktif Default' }}
            </span>
            <a href="{{ route('admin.message.edit') }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-[#0084f8] hover:bg-[#006fd6] text-white font-extrabold text-[11px] transition shrink-0">
                <span>+ Upload / Ganti Video di Admin</span>
            </a>
        </div>
    @endauth

    <div class="grid grid-cols-1 {{ $compact ? 'md:grid-cols-12' : 'lg:grid-cols-12' }} gap-3 sm:gap-4 items-stretch">
        <!-- Main Stage Player (Concept Slide 2 Left) -->
        <div class="{{ $compact ? 'md:col-span-7' : 'lg:col-span-8' }} relative rounded-2xl overflow-hidden bg-slate-900 border border-slate-200 shadow-sm flex flex-col justify-between min-h-[250px] sm:min-h-[300px]">

            <!-- Live YouTube Embed when active -->
            <template x-if="videoUrl && isYoutube() && isPlaying">
                <div class="relative w-full h-full min-h-[250px] sm:min-h-[300px] flex-1">
                    <iframe :src="youtubeEmbedUrl()" class="w-full h-full min-h-[250px] sm:min-h-[300px]" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    <button type="button" @click="isPlaying = false"
                            class="absolute top-2.5 right-2.5 px-2.5 py-1 rounded-lg bg-slate-900/80 text-white text-[10px] font-bold hover:bg-slate-900 cursor-pointer">
                        ✕ Tutup Video
                    </button>
                </div>
            </template>

            <!-- Live Uploaded MP4 / Direct Video when active -->
            <div x-show="videoUrl && !isYoutube() && isPlaying" x-cloak class="relative w-full h-full min-h-[250px] sm:min-h-[300px] flex-1 bg-black flex flex-col justify-center">
                <video x-ref="htmlVideo" :src="videoUrl" controls playsinline class="w-full h-full max-h-[340px] object-contain"
                       @ended="isPlaying = false"></video>
            </div>

            <!-- Interactive Concept Storyboard Cover & Player (Shown before playing or when in storyboard mode) -->
            <div x-show="!isPlaying || (!videoUrl)" class="relative flex-1 flex flex-col justify-between">
                <!-- Background scene visual -->
                <img :src="currentChapter.image" :alt="currentChapter.title" class="absolute inset-0 w-full h-full object-cover opacity-85 transition-all duration-500">
                <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/88 to-slate-900/45"></div>

                <!-- Overlay Content Matching Concept Slide 2 (Responsive flex so Play button never overlaps text on Mobile!) -->
                <div class="relative z-10 p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 flex-1">
                    <div class="space-y-1.5 sm:max-w-[65%]">
                        <div class="flex items-center gap-2 flex-wrap">
                            <img src="{{ asset('images/akebono.png') }}" alt="akebono" class="h-4 sm:h-5 w-auto object-contain">
                            <span class="px-2 py-0.5 rounded bg-sky-100 text-[#0084f8] text-[9px] sm:text-[10px] font-extrabold tracking-widest uppercase">
                                OFFICE RELOCATION
                            </span>
                        </div>

                        <h4 class="text-lg sm:text-2xl font-extrabold text-[#0f2e54] leading-tight">
                            Welcome to<br>Our New Workplace
                        </h4>

                        <p class="text-xs sm:text-sm font-bold text-[#0084f8]">
                            {{ $japaneseTagline }}
                        </p>

                        <p class="text-[11px] sm:text-xs text-slate-600 leading-snug line-clamp-2" x-text="currentChapter.desc"></p>

                        <!-- 3 Mini Value Icons (People / Safety / Growth) -->
                        <div class="flex items-center gap-3 pt-1">
                            <div class="flex items-center gap-1 text-[10px] font-bold text-[#0f2e54]">
                                <span class="w-5 h-5 rounded-full bg-sky-100 text-[#0084f8] flex items-center justify-center">👥</span>
                                <span>People</span>
                            </div>
                            <div class="flex items-center gap-1 text-[10px] font-bold text-[#0f2e54]">
                                <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">🛡️</span>
                                <span>Safety</span>
                            </div>
                            <div class="flex items-center gap-1 text-[10px] font-bold text-[#0f2e54]">
                                <span class="w-5 h-5 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">📈</span>
                                <span>Growth</span>
                            </div>
                        </div>
                    </div>

                    <!-- Play Button Badge (Centered cleanly on right for desktop, neat row on mobile) -->
                    <div class="flex sm:flex-col items-center justify-start sm:justify-center gap-2.5 shrink-0">
                        <button type="button" @click="togglePlay()"
                                class="flex items-center sm:flex-col gap-2.5 sm:gap-1.5 group cursor-pointer focus:outline-hidden">
                            <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-[#0f2e54]/90 hover:bg-[#0084f8] border-2 border-white text-white flex items-center justify-center shadow-xl transition group-hover:scale-110">
                                <template x-if="!isPlaying">
                                    <svg class="w-5 h-5 ml-0.5 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </template>
                                <template x-if="isPlaying">
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                                </template>
                            </div>
                            <span class="px-2.5 py-1 rounded-lg bg-slate-900/80 text-white text-[10px] font-extrabold tracking-wider uppercase shadow-xs">
                                <span x-text="isPlaying ? 'PAUSE' : 'PLAY MESSAGE'"></span> ({{ $durationText }})
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Bottom Video Control Bar -->
                <div class="relative z-10 bg-slate-900/95 text-white px-3.5 py-2 flex items-center gap-2.5 text-[11px]">
                    <button type="button" @click="togglePlay()" class="hover:text-sky-400 cursor-pointer font-bold">
                        <span x-text="isPlaying ? '⏸' : '▶'"></span>
                    </button>
                    <span class="font-mono text-[10px] text-slate-300 shrink-0">
                        <span x-text="formatTime(currentTime)">0:00</span> / {{ $durationText }}
                    </span>
                    <div class="flex-1 h-1.5 bg-slate-700 rounded-full overflow-hidden cursor-pointer relative"
                         @click="
                            const rect = $el.getBoundingClientRect();
                            const pct = Math.max(0, Math.min(1, ($event.clientX - rect.left) / rect.width));
                            currentTime = Math.round(pct * totalSeconds);
                            for (let i = chapters.length - 1; i >= 0; i--) {
                                if (currentTime >= (chapters[i].seconds ?? 0)) { activeChapter = i; break; }
                            }
                         ">
                        <div class="h-full bg-[#0084f8] rounded-full transition-all duration-300"
                             :style="'width:' + Math.min(100, Math.round((currentTime / totalSeconds) * 100)) + '%'"></div>
                    </div>
                    <span class="px-1.5 py-0.5 rounded bg-slate-800 text-[9px] font-bold text-sky-300 truncate max-w-[110px]" x-text="currentChapter.title"></span>
                </div>
            </div>
        </div>

        <!-- Right-Side Chapter Playlist (6 Chapters matching Slide 2) -->
        <div class="{{ $compact ? 'md:col-span-5' : 'lg:col-span-4' }} flex flex-col gap-1.5 max-h-[260px] sm:max-h-[300px] overflow-y-auto pr-0.5">
            <template x-for="(chap, idx) in chapters" :key="chap.id">
                <button type="button" @click="selectChapter(idx)"
                        class="w-full text-left p-2 rounded-xl border transition flex items-center gap-2.5 cursor-pointer"
                        :class="activeChapter === idx ? 'bg-sky-50 border-[#0084f8] shadow-2xs ring-1 ring-[#0084f8]/20' : 'bg-white border-slate-200/80 hover:bg-slate-50'">
                    <div class="relative w-16 h-11 rounded-lg overflow-hidden shrink-0 bg-slate-100">
                        <img :src="chap.image" :alt="chap.title" class="w-full h-full object-cover">
                        <span class="absolute bottom-0.5 left-0.5 px-1 py-0.2 rounded bg-slate-900/80 text-white text-[8px] font-mono font-bold" x-text="chap.time.replace(/\s+/g, '')"></span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-xs font-extrabold text-[#0f2e54] truncate" x-text="chap.title"></div>
                        <div class="text-[10px] text-slate-500 line-clamp-1 leading-tight mt-0.5" x-text="chap.desc"></div>
                    </div>
                </button>
            </template>
        </div>
    </div>

    <!-- Bottom 5 Highlight Scene Cards (Concept Slide 2 Bottom Strip) -->
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
        @foreach($scenesData as $scene)
            <button type="button"
                    @click="selectChapter({{ $scene['chapter'] }})"
                    class="group relative h-14 sm:h-16 rounded-xl overflow-hidden border border-slate-200/90 text-left cursor-pointer shadow-2xs hover:border-[#0084f8] transition">
                <img src="{{ office_image($scene['image']) }}" alt="{{ $scene['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-900/45 to-transparent"></div>
                <div class="absolute bottom-1.5 left-2 right-1.5 text-white">
                    <div class="text-[10px] font-extrabold leading-tight truncate">{{ $scene['title'] }}</div>
                    <div class="text-[9px] text-sky-200 truncate">{{ $scene['subtitle'] }}</div>
                </div>
            </button>
        @endforeach
    </div>
</div>
