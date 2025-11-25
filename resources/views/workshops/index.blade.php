@extends('layouts.user')

@section('title', 'My Workshops')

@push('styles')
    <style>

    </style>
@endpush

@section('content')
    <section class="container py-5">
        <div class="text-center text-md-start mb-5">
            <p class="text-uppercase text-muted small fw-semibold mb-2" style="letter-spacing: 2px;">Workspace</p>
            <h1 class="fw-bold display-6" style="color: #1f2933;">My Workshops</h1>
            <p class="text-muted mb-0" style="max-width: 640px;">
                Track all learning spaces you curate. Launch a workshop to jump directly into the facilitator dashboard.
            </p>
        </div>

        <div class="row g-4">
            @forelse ($courses as $course)
                <div class="col-md-6 col-xl-4 d-flex">
                    <article class="workshop-card w-100 d-flex flex-column">
                        <div class="d-flex justify-content-between text-uppercase text-muted small">
                            <span>{{ 'Inital Training' }}</span>
                            <span>
                                {{ \Carbon\Carbon::parse($course->created_at)->diffForHumans() }}</span>
                        </div>
                        <h2 class="mt-3 h4 fw-bold" style="color: #111827;">{{ $course->title }}</h2>
                        <p class="text-muted mb-4 flex-grow-1">{{ Str::substr($course->description, 0, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge rounded-pill badge-soft">{{ $course->chapters->count() }} chapters</span>
                                
                            </div>
                            <a href="{{ route('user.workshop.show', ['id' => $course->id]) }}"
                                class="btn btn-coursepro rounded-pill px-4">
                                Start now
                            </a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="workshop-card text-center">
                        <p class="h5 text-muted mb-2">No workshops yet</p>
                        <p class="text-muted small mb-0">Assigned workshops will appear here.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </section>
@endsection
