@php
    $totalLessons = $course->chapters->reduce(function ($carry, $chapter) {
        return $carry + $chapter->videos->count() + $chapter->audios->count();
    }, 0);
    $outlineId = 'chapters-sidenav-' . $idSuffix;
@endphp

<div class="p-3">
    <h5 class="fw-bold mb-1" style="color: var(--primary-orange);">
        Kursübersicht
    </h5>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="mb-0 text-muted small">
            {{ $course->chapters->count() }} Lektionen • {{ $totalLessons }} Videos
        </p>
        <button class="btn btn-link btn-sm text-decoration-none px-0 toggle-sections-btn"
            data-outline-target="{{ $outlineId }}">
            Alle Abschnitte erweitern
        </button>
    </div>

    <div class="chapters-list" id="{{ $outlineId }}">
        <div class="course-outline">
            @foreach ($course->chapters as $chapter)
                @php
                    $isCurrentChapter = $chapter->id === $currentChapter->id;
                    $chapterCollapseId = 'chapter-' . $chapter->id . '-' . $idSuffix;

                    $lessons = $chapter->videos->sortBy('order')->concat($chapter->audios->sortBy('order'));
                @endphp
                <div class="section mb-2">
                    <button class="section-header {{ $isCurrentChapter ? '' : 'collapsed' }}  bg-white" type="button"
                        data-bs-toggle="collapse" data-bs-target="#{{ $chapterCollapseId }}"
                        aria-expanded="{{ $isCurrentChapter ? 'true' : 'false' }}"
                        aria-controls="{{ $chapterCollapseId }}">
                        <div>
                            <p class="section-title mb-0">
                                {{ $chapter->order > 0 ? "Lektion {$chapter->order}: " : '' }} {{ $chapter->title }}
                            </p>
                            <span class="section-meta">{{ $lessons->count() }}
                                Videos</span>
                        </div>
                        {{-- <div class="d-flex align-items-center gap-2 text-muted small">
                            <span>0% complete</span>
                            <i class="bi bi-chevron-down section-chevron"></i>
                        </div> --}}
                    </button>
                    <div id="{{ $chapterCollapseId }}"
                        class="collapse chapter-collapse {{ $isCurrentChapter ? 'show' : '' }} bg-white">
                        <ul class="lessons">

                            @forelse ($lessons as $lesson)
                                @php
                                    $isActiveVideo = $currentVideo && $lesson->id === $currentVideo->id;
                                @endphp
                                <li class="lesson-item {{ $isActiveVideo ? 'active' : '' }}">
                                    <a class="lesson-link"
                                        href="{{ route('user.workshop.show', ['id' => $course->id, 'chapter_id' => $chapter->id, 'video_id' => $lesson->id]) }}">
                                        <span class="lesson-index">{{ $lesson->order ?? $loop->iteration }}</span>
                                        <div class="lesson-body">
                                            <p class="lesson-title mb-0">{{ $lesson->title }}</p>
                                            <span class="lesson-details">{{ $lesson->video_type ?? 'video' }}</span>
                                        </div>
                                        @if ($lesson->duration)
                                            <span class="lesson-duration">{{ $lesson->duration }}</span>
                                        @endif
                                    </a>
                                </li>
                            @empty
                                <li class="lesson-item text-muted small">
                                    Keine Lektionen in diesem Abschnitt vorhanden.
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
