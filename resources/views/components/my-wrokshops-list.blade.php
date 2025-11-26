<div>
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
                    <a href="https://baaboo.com/products/autogenes-training-videokurs" target="_blank"
                        class="btn btn-primary btn--shopify px-4 py-2 rounded-pill mb-3 mt-4"
                        style="background: #1a1a1a; color: #fff; font-weight: 600; border: none;">
                        Buy Workshop
                    </a>
                    <p class="text-muted small mb-0">Use same email to purchase workshops.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
