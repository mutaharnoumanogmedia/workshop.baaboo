@extends('layouts.user')

@section('title', 'User Dashboard')


@section('content')
    <div class="mb-4">
        <h2 class="fw-bold">Welcome back, {{Auth::user()->first_name}}!</h2>
        <p class="text-muted">Continue your learning journey</p>
    </div>

    {{-- <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="icon" style="background-color: var(--primary-orange);">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="ms-3">
                        <h3 class="mb-0 fw-bold">8</h3>
                        <p class="text-muted mb-0 small">Active Workshops</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="icon" style="background-color: #28a745;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="ms-3">
                        <h3 class="mb-0 fw-bold">12</h3>
                        <p class="text-muted mb-0 small">Completed</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="icon" style="background-color: #ffc107;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="ms-3">
                        <h3 class="mb-0 fw-bold">45h</h3>
                        <p class="text-muted mb-0 small">Learning Time</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="icon" style="background-color: #17a2b8;">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="ms-3">
                        <h3 class="mb-0 fw-bold">5</h3>
                        <p class="text-muted mb-0 small">Certificates</p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Continue Learning -->
    <div class="mb-4">
        <h4 class="fw-bold mb-3">My Workshops</h4>
        <div class="row">
            @forelse ($myCourses as $course)
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
    </div>

    <!-- All My Workshops -->
    {{-- <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">More workshops</h4>
            <div class="btn-group" role="group">
                <button class="btn btn-sm btn-outline-secondary active">All</button>
                <button class="btn btn-sm btn-outline-secondary">In Progress</button>
                <button class="btn btn-sm btn-outline-secondary">Completed</button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="workshop-card">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&h=400&fit=crop"
                            alt="Workshop" class="workshop-img">
                        <span class="progress-badge" style="color: var(--primary-orange);">28% Complete</span>
                    </div>
                    <div class="workshop-content">
                        <span class="category-badge">Programming</span>
                        <h5 class="mt-2 mb-2 fw-bold">Python for Data Science</h5>
                        <p class="text-muted small mb-3"><i class="fas fa-user"></i> Dr. Sarah Mitchell</p>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar" style="width: 28%; background-color: var(--primary-orange);"></div>
                        </div>
                        <button class="btn btn-coursepro btn-sm w-100">Continue Learning</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="workshop-card">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=400&fit=crop"
                            alt="Workshop" class="workshop-img">
                        <span class="progress-badge" style="color: #28a745;">100% Complete</span>
                    </div>
                    <div class="workshop-content">
                        <span class="category-badge">Business</span>
                        <h5 class="mt-2 mb-2 fw-bold">Digital Marketing Strategies</h5>
                        <p class="text-muted small mb-3"><i class="fas fa-user"></i> Mark Johnson</p>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 100%;"></div>
                        </div>
                        <button class="btn btn-outline-secondary btn-sm w-100">View Certificate</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="workshop-card">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=800&h=400&fit=crop"
                            alt="Workshop" class="workshop-img">
                        <span class="progress-badge" style="color: var(--primary-orange);">15% Complete</span>
                    </div>
                    <div class="workshop-content">
                        <span class="category-badge">Leadership</span>
                        <h5 class="mt-2 mb-2 fw-bold">Effective Team Management</h5>
                        <p class="text-muted small mb-3"><i class="fas fa-user"></i> Emily Rodriguez</p>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar" style="width: 15%; background-color: var(--primary-orange);"></div>
                        </div>
                        <button class="btn btn-coursepro btn-sm w-100">Continue Learning</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="workshop-card">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?w=800&h=400&fit=crop"
                            alt="Workshop" class="workshop-img">
                        <span class="progress-badge" style="color: var(--primary-orange);">88% Complete</span>
                    </div>
                    <div class="workshop-content">
                        <span class="category-badge">Technology</span>
                        <h5 class="mt-2 mb-2 fw-bold">Cloud Computing Essentials</h5>
                        <p class="text-muted small mb-3"><i class="fas fa-user"></i> Prof. David Chen</p>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar" style="width: 88%; background-color: var(--primary-orange);"></div>
                        </div>
                        <button class="btn btn-coursepro btn-sm w-100">Continue Learning</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="workshop-card">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=400&fit=crop"
                            alt="Workshop" class="workshop-img">
                        <span class="progress-badge" style="color: var(--primary-orange);">52% Complete</span>
                    </div>
                    <div class="workshop-content">
                        <span class="category-badge">Communication</span>
                        <h5 class="mt-2 mb-2 fw-bold">Public Speaking Mastery</h5>
                        <p class="text-muted small mb-3"><i class="fas fa-user"></i> Jessica Williams</p>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar" style="width: 52%; background-color: var(--primary-orange);"></div>
                        </div>
                        <button class="btn btn-coursepro btn-sm w-100">Continue Learning</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="workshop-card">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=400&fit=crop"
                            alt="Workshop" class="workshop-img">
                        <span class="progress-badge" style="color: #28a745;">100% Complete</span>
                    </div>
                    <div class="workshop-content">
                        <span class="category-badge">Analytics</span>
                        <h5 class="mt-2 mb-2 fw-bold">Business Analytics with Excel</h5>
                        <p class="text-muted small mb-3"><i class="fas fa-user"></i> Robert Taylor</p>
                        <div class="progress mb-3" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 100%;"></div>
                        </div>
                        <button class="btn btn-outline-secondary btn-sm w-100">View Certificate</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Upcoming Sessions -->
        <div class="mb-4">
            <h4 class="fw-bold mb-3">Upcoming Live Sessions</h4>
            <div class="stat-card">
                <div class="row align-items-center mb-3 pb-3 border-bottom">
                    <div class="col-md-8">
                        <h6 class="fw-bold mb-1">Advanced JavaScript - Q&A Session</h6>
                        <p class="text-muted small mb-0"><i class="fas fa-calendar"></i> Tomorrow, 3:00 PM | <i
                                class="fas fa-clock"></i> 1 hour</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-2 mt-md-0">
                        <button class="btn btn-coursepro btn-sm">Join Session</button>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h6 class="fw-bold mb-1">UI/UX Design - Portfolio Review</h6>
                        <p class="text-muted small mb-0"><i class="fas fa-calendar"></i> Dec 25, 2024 5:30 PM | <i
                                class="fas fa-clock"></i> 2 hours</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-2 mt-md-0">
                        <button class="btn btn-outline-secondary btn-sm">Set Reminder</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
