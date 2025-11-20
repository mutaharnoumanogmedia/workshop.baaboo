@extends('layouts.workshop')

@section('title', $workshop['title'])

@php
    $totalModules = count($modules);
    $progressUnits = 0;
    foreach ($modules as $chapterInfo) {
        if ($chapterInfo['status'] === 'completed') {
            $progressUnits += 1;
        } elseif ($chapterInfo['status'] === 'in-progress') {
            $progressUnits += 0.5;
        }
    }
    $progress = $totalModules ? round(($progressUnits / $totalModules) * 100) : 0;
    $chapterIndex = array_search($module['id'], array_column($modules, 'id')) ?? 0;
    $chapterNumber = $chapterIndex !== false ? $chapterIndex + 1 : 1;
@endphp

@push('inline-styles')
<style>
    .sidebar {
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
    .lesson-active {
        background-color: var(--light-bg);
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
</style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-xl-2 sidebar p-0">
                <div class="p-3">
                    <h5 class="fw-bold mb-3" style="color: var(--primary-orange);">Course Content</h5>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small">Course Progress</span>
                            <span class="small fw-bold">{{ $progress }}%</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="chapters-list">
                        @foreach ($modules as $chapter)
                            <div class="chapter-item p-3 {{ $chapter['id'] === $module['id'] ? 'active' : '' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 fw-bold">{{ $chapter['name'] }}</h6>
                                        <p class="mb-0 small text-muted">{{ $chapter['lessons'] }} lessons · {{ ucfirst($chapter['status']) }}</p>
                                    </div>
                                    @php
                                        $iconClass = match($chapter['status']) {
                                            'completed' => 'bi-check-circle-fill text-success',
                                            'in-progress' => 'bi-play-circle text-primary',
                                            'locked' => 'bi-lock text-muted',
                                            default => 'bi-play-circle text-primary',
                                        };
                                    @endphp
                                    <i class="bi {{ $iconClass }}"></i>
                                </div>
                                <a class="chapter-link" href="{{ url('/workshop/' . $workshop['id'] . '/module/' . $chapter['id']) }}"></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-xl-10 main-content p-4">
                <div class="row">
                    <div class="col-12">
                        <h2 class="fw-bold mb-4">{{ $workshop['title'] }}</h2>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-12">
                        <div class="current-video-card p-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4 class="fw-bold mb-3">Current Lesson: {{ $module['currentLesson']['title'] }}</h4>
                                    <div class="video-thumbnail mb-3 position-relative">
                                        <div class="ratio ratio-16x9 rounded">
                                            <iframe src="{{ $module['currentLesson']['video'] }}" title="Lesson video" allowfullscreen loading="lazy"></iframe>
                                        </div>
                                        <div class="play-icon">
                                            <i class="bi bi-play-fill"></i>
                                        </div>
                                        <div class="video-duration">{{ $module['currentLesson']['duration'] }}</div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
                                        <div>
                                            <span class="badge bg-primary me-2">Chapter {{ $chapterNumber }}</span>
                                            <span class="badge bg-secondary">Lesson {{ $module['currentLesson']['order'] ?? 1 }}</span>
                                        </div>
                                        <a class="btn btn-coursepro" href="{{ url('/workshop/' . $workshop['id'] . '/module/' . $module['id']) }}">
                                            <i class="bi bi-play-fill me-2"></i>Continue Watching
                                        </a>
                                    </div>
                                    <p class="text-muted">{{ $module['currentLesson']['summary'] }}</p>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="fw-bold mb-3">Up Next</h5>
                                    <div class="list-group">
                                        @forelse ($module['upNext'] as $next)
                                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ $next['thumbnail'] ?? 'https://placehold.co/80x45/FF8C5A/white?text=' . $next['order'] }}"
                                                         class="rounded me-3" alt="Thumbnail">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ $next['title'] }}</h6>
                                                    <small class="text-muted">{{ $next['duration'] }}</small>
                                                </div>
                                            </a>
                                        @empty
                                            <div class="text-muted small">More lessons coming soon.</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h4 class="fw-bold mb-4">{{ $module['name'] }}</h4>
                        <div class="list-group">
                            @forelse ($module['lessonsList'] as $lesson)
                                <div class="list-group-item list-group-item-action d-flex align-items-center p-3 {{ $lesson['active'] ? 'lesson-active' : '' }}">
                                    <div class="flex-shrink-0 me-3 position-relative">
                                        <img src="{{ $lesson['thumbnail'] }}" class="rounded" alt="Thumbnail" style="width: 120px; height: 67px; object-fit: cover;">
                                        <div class="video-duration">{{ $lesson['duration'] }}</div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <h5 class="mb-1">{{ $lesson['title'] }}</h5>
                                            @if ($lesson['state'] === 'completed')
                                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                            @elseif ($lesson['active'])
                                                <i class="bi bi-play-circle text-primary fs-5"></i>
                                            @elseif ($lesson['state'] === 'locked')
                                                <i class="bi bi-lock text-muted fs-5"></i>
                                            @endif
                                        </div>
                                        <p class="mb-1 text-muted">{{ $lesson['summary'] }}</p>
                                        <small class="{{ $lesson['active'] ? 'fw-bold text-warning' : 'text-muted' }}">
                                            @if ($lesson['active'])
                                                Continue from {{ $module['currentLesson']['resumePoint'] }}
                                            @else
                                                {{ ucfirst($lesson['state']) }}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            @empty
                                <div class="list-group-item text-center text-muted">
                                    Lesson cards will appear here soon.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

