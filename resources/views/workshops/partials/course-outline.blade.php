@php
    $totalLessons = $course->chapters->reduce(function ($carry, $chapter) {
        return $carry + $chapter->videos->count();
    }, 0);
    $outlineId = 'chapters-sidenav-' . $idSuffix;
@endphp

<div class="p-3">
    <h5 class="fw-bold mb-1" style="color: var(--primary-orange);">Course content</h5>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="mb-0 text-muted small">
            {{ $course->chapters->count() }} sections • {{ $totalLessons }} lectures
        </p>
        <button class="btn btn-link btn-sm text-decoration-none px-0 toggle-sections-btn"
            data-outline-target="{{ $outlineId }}">
            Expand all sections
        </button>
    </div>

    <div class="chapters-list" id="{{ $outlineId }}">
        <div class="course-outline">
            @foreach ($course->chapters as $chapter)
                @php
                    $isCurrentChapter = $chapter->id === $currentChapter->id;
                    $chapterCollapseId = 'chapter-' . $chapter->id . '-' . $idSuffix;
                @endphp
                <div class="section">
                    <button class="section-header {{ $isCurrentChapter ? '' : 'collapsed' }}" type="button"
                        data-bs-toggle="collapse" data-bs-target="#{{ $chapterCollapseId }}"
                        aria-expanded="{{ $isCurrentChapter ? 'true' : 'false' }}"
                        aria-controls="{{ $chapterCollapseId }}">
                        <div>
                            <p class="section-title mb-0">Section {{ $loop->iteration }}: {{ $chapter->title }}</p>
                            <span class="section-meta">{{ $chapter->videos->count() }} lessons</span>
                        </div>
                        {{-- <div class="d-flex align-items-center gap-2 text-muted small">
                            <span>0% complete</span>
                            <i class="bi bi-chevron-down section-chevron"></i>
                        </div> --}}
                    </button>
                    <div id="{{ $chapterCollapseId }}"
                        class="collapse chapter-collapse {{ $isCurrentChapter ? 'show' : '' }}">
                        <ul class="lessons">
                            @forelse ($chapter->videos->sortBy('order') as $lesson)
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
                                    No lessons added yet
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

