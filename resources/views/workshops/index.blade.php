@extends('layouts.user')

@section('title', 'My Workshops')

@push('styles')
    <style>

    </style>
@endpush

@section('content')
    <section class="container py-5">
        <div class="text-center text-md-start mb-5">
            <p class="text-uppercase text-muted small fw-semibold mb-2" style="letter-spacing: 2px;">
                Lernräume verwalten
            </p>
            <h1 class="fw-bold display-6" style="color: #1f2933;">
                Meine Workshops
            </h1>
            <p class="text-muted mb-0" style="max-width: 640px;">
                Behalte den Überblick über alle Lernräume, die du erstellst. Starte einen Workshop, um direkt ins Moderator-Dashboard zu springen.
            </p>
        </div>

        <x-my-wrokshops-list :myCourses="$myCourses" />
    </section>
@endsection
