@extends('layouts.user')

@if ($currentVideo)
    @section('title', $currentVideo->title . ' - ' . $course->title)
@endif
@if ($currentVideo && $currentVideo->vturb_key)
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

        .course-outline {
            border-radius: 12px;
            background-color: #fff;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }

        .section {
            border-bottom: 1px solid #f1f5f9;
        }

        .section:last-child {
            border-bottom: none;
        }

        .section-header {
            width: 100%;
            border: none;
            background: none;
            padding: 1rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .section-header:hover,
        .section-header:focus {
            background-color: #f8fafc;
        }

        .section-title {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 4px;
        }

        .section-meta {
            font-size: 0.82rem;
            color: #94a3b8;
        }

        .section-chevron {
            font-size: 1rem;
            color: #94a3b8;
            transition: transform 0.2s ease;
        }

        .section-header[aria-expanded='true'] .section-chevron {
            transform: rotate(180deg);
        }

        .lessons {
            list-style: none;
            margin: 0;
            padding: 0 0 0.75rem 0;
        }

        .lesson-item {
            padding: 0.85rem 1.25rem;
            border-left: 3px solid transparent;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }

        .lesson-item:hover {
            background-color: #f8fafc;
        }

        .lesson-item.active {
            background-color: #fff7f2;
            border-left-color: var(--primary-orange);
        }

        .lesson-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: inherit;
        }

        .lesson-index {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #edf2f7;
            color: #475569;
            font-size: 0.82rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .lesson-body {
            flex: 1;
        }

        .lesson-title {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .lesson-details {
            font-size: 0.78rem;
            color: #94a3b8;
            text-transform: capitalize;
        }

        .lesson-duration {
            font-size: 0.82rem;
            color: #475569;
            white-space: nowrap;
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

        .chapters-sidebar .chapters-list {
            max-height: 75vh;
            overflow-y: auto;
        }

        .mobile-sticky-video {
            position: relative;
        }

        @media (max-width: 991px) {
            .mobile-sticky-video {
                position: sticky;
                top: 60px;
                z-index: 10;
                background: #fff;
                padding-top: 1rem;
            }

            .chapters-sidebar .chapters-list {
                max-height: none;
            }

            .container-pdf-viewer {
                width: 100%;
                height: 600px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="">
        <div class="row g-4 align-items-start">
            <!-- chapters-Sidebar -->
            <div class="col-12 col-lg-3 col-xl-3 chapters-sidebar p-0 d-none d-lg-block">
                @include('workshops.partials.course-outline', [
                    'course' => $course,
                    'currentChapter' => $currentChapter,
                    'currentVideo' => $currentVideo,
                    'idSuffix' => 'desktop',
                ])
            </div>

            <!-- Main Content -->
            <div class="col-12 col-lg-9 col-xl-9 main-content p-lg-4 p-0">
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
                                <div class="row mb-5 gy-4 align-items-start">
                                    <div class="col-lg-12">
                                        <div class="current-video-card p-lg-4 mobile-sticky-video">
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
                                        </div>
                                       
                                        <p class="text-muted">{{ $currentVideo->description }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>




                        <div class="d-lg-none mt-4">
                            @include('workshops.partials.course-outline', [
                                'course' => $course,
                                'currentChapter' => $currentChapter,
                                'currentVideo' => $currentVideo,
                                'idSuffix' => 'mobile',
                            ])
                        </div>

                        <div class="tab-pane fade p-3 border rounded" id="audio" role="tabpanel">
                            <div class="row mb-5 gy-4">
                                <div class="col-12">
                                    @if ($currentAudio)
                                        <div class="current-video-card p-lg-4">
                                            <div class="row align-items-start">
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
                        <div class="tab-pane fade p-3 border rounded" id="text" role="tabpanel">
                            <h5>Text Explanations</h5>
                            <p>Place your text-based module content here.</p>
                        </div>
                    </div>



                </div>



            </div>
        </div>



    </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof bootstrap === 'undefined') {
                return;
            }

            document.querySelectorAll('.toggle-sections-btn[data-outline-target]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-outline-target');
                    const container = document.getElementById(targetId);

                    if (!container) {
                        return;
                    }

                    const collapses = container.querySelectorAll('.chapter-collapse');
                    if (!collapses.length) {
                        return;
                    }

                    const shouldExpand = Array.from(collapses).some(el => !el.classList.contains(
                        'show'));

                    collapses.forEach(el => {
                        const instance = bootstrap.Collapse.getOrCreateInstance(el, {
                            toggle: false
                        });
                        shouldExpand ? instance.show() : instance.hide();
                    });

                    this.textContent = shouldExpand ? 'Collapse all sections' :
                        'Expand all sections';
                });
            });
        });
    </script>
@endpush
