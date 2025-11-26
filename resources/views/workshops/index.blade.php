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

        <x-my-wrokshops-list :myCourses="$myCourses" />
    </section>
@endsection
