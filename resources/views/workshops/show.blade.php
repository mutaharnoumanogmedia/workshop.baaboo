@extends('layouts.user')

@if ($currentVideo)
    @section('title', $currentVideo->title . ' - ' . $course->title)
@endif
@if ($currentVideo->vturb_key)
    @section('header')
        <link rel="preload"
            href="https://scripts.converteai.net/1bbf3f59-5ee7-48db-bbc8-4de570e093db/players/{{ $currentVideo->vturb_key }}/player.js"
            as="script">
        <link rel="preload" href="https://scripts.converteai.net/lib/js/smartplayer/v1/smartplayer.min.js" as="script">
        <link rel="preload"
            href="https://images.converteai.net/1bbf3f59-5ee7-48db-bbc8-4de570e093db/players/{{ $currentVideo->vturb_key }}/thumbnail.jpg"
            as="image">
        <link rel="preload"
            href="https://cdn.converteai.net/1bbf3f59-5ee7-48db-bbc8-4de570e093db/691ff3def49d199be1154f9f/main.m3u8"
            as="fetch">
        <link rel="dns-prefetch" href="https://cdn.converteai.net">
        <link rel="dns-prefetch" href="https://scripts.converteai.net">
        <link rel="dns-prefetch" href="https://images.converteai.net">
        <link rel="dns-prefetch" href="https://api.vturb.com.br">
    @endsection
@endif

@push('styles')
    <style>
        .chapters-sidebar {
            height: 100%;
        }

        .chapter-item {
            border-left: 3px solid transparent;
            transition: all 0.3s;
            position: relative;
            cursor: pointer;
        }

        .chapter-item:hover {
            background-color: var(--light-bg);
            border-left-color: var(--primary-orange);
        }

        .chapter-item.active {
            background-color: var(--light-bg);
            border-left-color: var(--primary-orange);
        }

        .chapter-link {
            position: absolute;
            inset: 0;
        }

        .current-video-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .video-thumbnail {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            background-color: #000;
        }

        .video-thumbnail iframe {
            width: 100%;
            height: 480px;
            border: none;
        }

        .container-pdf-viewer {
            min-width: 650px;
            height: 600px;
            /* overflow: auto; */
        }

        .container-pdf-viewer iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .lesson-active {
            background-color: var(--light-bg) !important;
            border-left: 3px solid var(--primary-orange);
        }

        .video-duration {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.8rem;
        }

        .play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 107, 53, 0.8);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .video-thumbnail:hover .play-icon {
            opacity: 1;
        }

        #chapters-sidenav {
            max-height: 70vh;
            overflow-y: auto;
        }

        @media (max-width: 480px) {
            #chapters-sidenav {
                height: 150px;
                overflow: auto;
            }

            .container-pdf-viewer {
                width: 100%;
                height: 600px;
                /* overflow: auto; */
            }
        }
    </style>
@endpush

@section('content')
    <div class="">
        <div class="row">
            <!-- chapters-Sidebar -->
            <div class="col-lg-3 col-xl-2 chapters-sidebar p-0">
                <div class="p-3">
                    <h5 class="fw-bold mb-3" style="color: var(--primary-orange);">Course Content</h5>

                    <!-- Progress Section -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small">Course Progress</span>
                            <span class="small fw-bold">0%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" style="width: 35%;" aria-valuenow="35"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <!-- Chapters List -->
                    <div class="chapters-list" id="chapters-sidenav">
                        @foreach ($course->chapters as $chapter)
                            <a href="{{ route('user.workshop.show', ['id' => $course->id, 'chapter_id' => $chapter->id]) }}"
                                class="d-block text-decoration-none chapter-item p-3  @if ($chapter->id === $currentChapter->id) active @endif">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 fw-bold">Chapter {{ $loop->iteration }}: {{ $chapter->title }}
                                        </h6>
                                        <p class="mb-0 small text-muted">0/{{ $chapter->videos->count() }} lessons
                                            completed
                                        </p>
                                    </div>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9 col-xl-10 main-content p-lg-4 p-0">
                <div class="row">
                    <div class="col-12">
                        <h2 class="fw-bold mb-4">
                            {{ $course->title }}
                        </h2>
                    </div>
                </div>

                <div class="">


                    <!-- Nav Pills -->
                    <ul class="nav nav-pills mb-3" id="otherModulesTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="video-tab" data-bs-toggle="pill" data-bs-target="#video"
                                type="button" role="tab">
                                <i class="fa-solid fa-video"></i>
                                <span class="course-nav-text">
                                    Video Lessons
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="audio-tab" data-bs-toggle="pill" data-bs-target="#audio"
                                type="button" role="tab">
                                <i class="fa-solid fa-headphones"></i>

                                <span class="course-nav-text">
                                    Audio Files
                                </span>
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pdfs-tab" data-bs-toggle="pill" data-bs-target="#pdfs"
                                type="button" role="tab">
                                <i class="fa-regular fa-file-pdf"></i>

                                <span class="course-nav-text">
                                    Downloadable PDFs
                                </span>
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="text-tab" data-bs-toggle="pill" data-bs-target="#text"
                                type="button" role="tab">
                                <i class="fa-regular fa-file-lines"></i>
                                <span class="course-nav-text">
                                    Text Explanations
                                </span>
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="otherModulesContent">
                        <div class="tab-pane fade show active p-3 border rounded" id="video" role="tabpanel">
                            <!-- Current Video Section -->
                            @if ($currentVideo)
                                <div class="row mb-5">
                                    <div class="col-12">
                                        <div class="current-video-card p-lg-4">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h4 class="fw-bold mb-3">{{ $currentVideo->title }}</h4>
                                                    <div class="video-thumbnail mb-3 position-relative">
                                                        <div id="vid_{{ $currentVideo->vturb_key }}"
                                                            style="position: relative; width: 100%; padding: 56.25% 0 0;">
                                                            <img id="thumb_{{ $currentVideo->vturb_key }}"
                                                                src="https://images.converteai.net/1bbf3f59-5ee7-48db-bbc8-4de570e093db/players/{{ $currentVideo->vturb_key }}/thumbnail.jpg"
                                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; display: block;"
                                                                alt="thumbnail">
                                                            <div id="backdrop_{{ $currentVideo->vturb_key }}"
                                                                style=" -webkit-backdrop-filter: blur(5px); backdrop-filter: blur(5px); position: absolute; top: 0; height: 100%; width: 100%; ">
                                                            </div>
                                                        </div>
                                                        <script type="text/javascript" id="scr_{{ $currentVideo->vturb_key }}">
                                                            var s = document.createElement("script");
                                                            s.src =
                                                                "https://scripts.converteai.net/1bbf3f59-5ee7-48db-bbc8-4de570e093db/players/{{ $currentVideo->vturb_key }}/player.js",
                                                                s.async = !0, document.head.appendChild(s);
                                                        </script>

                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div>
                                                            <span class="badge bg-primary me-2">Video
                                                                {{ $currentVideo->order }}</span>
                                                            <span class="badge bg-secondary"> {{ $currentVideo->order }}
                                                                of
                                                                {{ $currentChapter->videos->count() }}</span>
                                                        </div>

                                                    </div>
                                                    <p class="text-muted">{{ $currentVideo->description }}</p>

                                                </div>
                                                <div class="col-md-4">
                                                    <h5 class="fw-bold mb-3">Up Next</h5>
                                                    <div class="list-group">
                                                        @foreach ($currentChapter->videos->where('video_type', 'video') as $video)
                                                            <a href="{{ route('user.workshop.show', ['id' => $course->id, 'chapter_id' => $currentChapter->id, 'video_id' => $video->id]) }}"
                                                                class="list-group-item list-group-item-action d-flex align-items-center bg-transparent @if ($video->id === $currentVideo->id) lesson-active @endif p-2 mb-2">
                                                                <div class="flex-shrink-0">
                                                                    <img src="https://placehold.co/80x45/FF8C5A/white?text={{ $video->order }}"
                                                                        class="rounded me-3" alt="Thumbnail">
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <h6 class="mb-1">{{ $video->title }}</h6>
                                                                    <small
                                                                        class="text-muted">{{ $video->duration }}</small>
                                                                </div>
                                                            </a>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>


                        <div class="tab-pane fade show p-3 border rounded" id="audio" role="tabpanel">
                            <div class="row mb-5">
                                <div class="col-12">
                                    @if ($currentAudio)
                                        <div class="current-video-card p-lg-4">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h4 class="fw-bold mb-3">{{ $currentAudio->title }}</h4>
                                                    <div class="video-thumbnail mb-3 position-relative">
                                                        <div id="vid_{{ $currentAudio->vturb_key }}"
                                                            style="position: relative; width: 100%; padding: 56.25% 0 0;">
                                                            <img id="thumb_{{ $currentAudio->vturb_key }}"
                                                                src="https://images.converteai.net/1bbf3f59-5ee7-48db-bbc8-4de570e093db/players/{{ $currentAudio->vturb_key }}/thumbnail.jpg"
                                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; display: block;"
                                                                alt="thumbnail">
                                                            <div id="backdrop_{{ $currentAudio->vturb_key }}"
                                                                style=" -webkit-backdrop-filter: blur(5px); backdrop-filter: blur(5px); position: absolute; top: 0; height: 100%; width: 100%; ">
                                                            </div>
                                                        </div>
                                                        <script type="text/javascript" id="scr_{{ $currentAudio->vturb_key }}">
                                                            var s = document.createElement("script");
                                                            s.src =
                                                                "https://scripts.converteai.net/1bbf3f59-5ee7-48db-bbc8-4de570e093db/players/{{ $currentAudio->vturb_key }}/player.js",
                                                                s.async = !0, document.head.appendChild(s);
                                                        </script>

                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <div>
                                                            <span class="badge bg-primary me-2">Video
                                                                {{ $currentAudio->order }}</span>
                                                            <span class="badge bg-secondary"> {{ $currentAudio->order }}
                                                                of
                                                                {{ $currentChapter->videos->count() }}</span>
                                                        </div>

                                                    </div>
                                                    <p class="text-muted">{{ $currentAudio->description }}</p>

                                                </div>
                                                <div class="col-md-4">
                                                    <h5 class="fw-bold mb-3">Up Next</h5>
                                                    <div class="list-group">
                                                        @foreach ($currentChapter->videos->where('video_type', 'audio') as $audio)
                                                            <a href="{{ route('user.workshop.show', ['id' => $course->id, 'chapter_id' => $currentChapter->id, 'video_id' => $audio->id]) }}"
                                                                class="list-group-item list-group-item-action d-flex align-items-center bg-transparent @if ($audio->id === $currentAudio->id) lesson-active @endif p-2 mb-2">
                                                                <div class="flex-shrink-0">
                                                                    <img src="https://placehold.co/80x45/FF8C5A/white?text={{ $audio->order }}"
                                                                        class="rounded me-3" alt="Thumbnail">
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <h6 class="mb-1">{{ $audio->title }}</h6>
                                                                    <small
                                                                        class="text-muted">{{ $audio->duration }}</small>
                                                                </div>
                                                            </a>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade p-3 border rounded" id="pdfs" role="tabpanel">
                            <h5>Downloadable PDFs</h5>
                            <div class="d-flex">
                                <!-- Side Navigation -->
                                <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                    aria-orientation="vertical">
                                    @foreach ($currentChapter->resources->where('type', 'pdf') as $resource)
                                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="v-pills-pdfs-tab"
                                            data-bs-toggle="pill" data-bs-target="#v-pills-pdfs-{{ $loop->index }}"
                                            type="button" role="tab"
                                            aria-controls="v-pills-pdfs-{{ $loop->index }}" aria-selected="true">


                                            {{ $loop->iteration }}. {{ $resource->title }}
                                        </button>
                                    @endforeach
                                </div>

                                <!-- Tab Content -->
                                <div class="tab-content" id="v-pills-tabContent">
                                    @foreach ($currentChapter->resources->where('type', 'pdf') as $resource)
                                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                            id="v-pills-pdfs-{{ $loop->index }}" role="tabpanel"
                                            aria-labelledby="v-pills-pdfs-tab">
                                            <h5>{{ $resource->title }}</h5>
                                            <div class="container-pdf-viewer">
                                                @if ($resource->url)
                                                    <iframe src="{{ url($resource->url) }}" class="w-100 h-100"
                                                        frameborder="0"></iframe>
                                                @endif
                                                @if ($resource->embed != null)
                                                    {!! $resource->embed !!}
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade p-3 border rounded" id="text" role="tabpanel">
                        <h5>Text Explanations</h5>
                        <p>Place your text-based module content here.</p>
                    </div>

                </div>
            </div>



        </div>
    </div>
    </div>
@endsection
