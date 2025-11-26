     <div class="row mb-4">
        <div class="col-12">
            <div class="d-card">
                <h2 class="h4 fw-bold mb-2">Welcome back, {{ Auth::user()->first_name }}!</h2>
                <p class="text-muted mb-0">Here's an overview of your application's performance and activity.</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Programs -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="d-card h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted mb-1 small text-uppercase fw-semibold">Total Programs</p>
                        <h3 class="h2 fw-bold mb-0">24</h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(255, 94, 28, 0.1);">
                        <i class="bi bi-journal-text fs-4 text-primary"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-success bg-opacity-10 text-success me-2">
                        <i class="bi bi-arrow-up"></i> 12%
                    </span>
                    <small class="text-muted">vs last month</small>
                </div>
            </div>
        </div>

        <!-- Active Workshops -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="d-card h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted mb-1 small text-uppercase fw-semibold">Active Workshops</p>
                        <h3 class="h2 fw-bold mb-0">48</h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(255, 94, 28, 0.1);">
                        <i class="bi bi-calendar-event fs-4 text-primary"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-success bg-opacity-10 text-success me-2">
                        <i class="bi bi-arrow-up"></i> 8%
                    </span>
                    <small class="text-muted">vs last month</small>
                </div>
            </div>
        </div>

        <!-- Total Modules -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="d-card h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted mb-1 small text-uppercase fw-semibold">Total Modules</p>
                        <h3 class="h2 fw-bold mb-0">156</h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(255, 94, 28, 0.1);">
                        <i class="bi bi-grid-3x3-gap fs-4 text-primary"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-success bg-opacity-10 text-success me-2">
                        <i class="bi bi-arrow-up"></i> 23%
                    </span>
                    <small class="text-muted">vs last month</small>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="d-card h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-muted mb-1 small text-uppercase fw-semibold">Total Users</p>
                        <h3 class="h2 fw-bold mb-0">1,284</h3>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: rgba(255, 94, 28, 0.1);">
                        <i class="bi bi-people-fill fs-4 text-primary"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-danger bg-opacity-10 text-danger me-2">
                        <i class="bi bi-arrow-down"></i> 3%
                    </span>
                    <small class="text-muted">vs last month</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="row g-4 mb-4">
        <!-- Recent Activity -->
        <div class="col-12 col-lg-8">
            <div class="d-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Recent Activity</h5>
                    <a href="#" class="text-primary text-decoration-none small fw-semibold">View All</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="border-0 text-muted small text-uppercase">User</th>
                                <th class="border-0 text-muted small text-uppercase">Action</th>
                                <th class="border-0 text-muted small text-uppercase">Module</th>
                                <th class="border-0 text-muted small text-uppercase">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                            <i class="bi bi-person-fill text-primary"></i>
                                        </div>
                                        <span class="fw-semibold">John Smith</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-success bg-opacity-10 text-success">Completed</span></td>
                                <td>Advanced Programming</td>
                                <td class="text-muted">2 hours ago</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                            <i class="bi bi-person-fill text-primary"></i>
                                        </div>
                                        <span class="fw-semibold">Emma Wilson</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-info bg-opacity-10 text-info">Enrolled</span></td>
                                <td>Web Development Workshop</td>
                                <td class="text-muted">5 hours ago</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                            <i class="bi bi-person-fill text-primary"></i>
                                        </div>
                                        <span class="fw-semibold">Michael Chen</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-warning bg-opacity-10 text-warning">In Progress</span></td>
                                <td>Data Science Basics</td>
                                <td class="text-muted">1 day ago</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                            <i class="bi bi-person-fill text-primary"></i>
                                        </div>
                                        <span class="fw-semibold">Sarah Johnson</span>
                                    </div>
                                </td>
                                <td><span class="badge bg-success bg-opacity-10 text-success">Completed</span></td>
                                <td>UX Design Fundamentals</td>
                                <td class="text-muted">2 days ago</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-12 col-lg-4">
            <div class="d-card h-100">
                <h5 class="fw-bold mb-4">Quick Actions</h5>
                <div class="d-grid gap-3">
                    <a href="#" class="btn btn-primary d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-plus-circle me-2"></i>Add New Program</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="#"
                        class="btn btn-outline-primary d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-calendar-plus me-2"></i>Schedule Workshop</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="#"
                        class="btn btn-outline-primary d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-upload me-2"></i>Upload Module</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="#"
                        class="btn btn-outline-primary d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-person-plus me-2"></i>Invite User</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <!-- System Status -->
                <div class="mt-4 pt-4 border-top">
                    <h6 class="fw-semibold mb-3 small text-uppercase text-muted">System Status</h6>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Server Status</span>
                        <span class="badge bg-success">Online</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="small">Database</span>
                        <span class="badge bg-success">Connected</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small">Storage</span>
                        <span class="badge bg-warning">78% Used</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Programs -->
    <div class="row g-4">
        <div class="col-12">
            <div class="d-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Popular Programs</h5>
                    <a href="#" class="text-primary text-decoration-none small fw-semibold">View All
                        Programs</a>
                </div>
                <div class="row g-3">
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="border rounded-3 p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-primary">Featured</span>
                                <small class="text-muted">24 modules</small>
                            </div>
                            <h6 class="fw-bold mb-2">Full Stack Development</h6>
                            <p class="text-muted small mb-3">Complete web development program covering frontend and
                                backend technologies.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="bi bi-people-fill me-1"></i>342 enrolled</small>
                                <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="border rounded-3 p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-secondary">Popular</span>
                                <small class="text-muted">18 modules</small>
                            </div>
                            <h6 class="fw-bold mb-2">Data Science & AI</h6>
                            <p class="text-muted small mb-3">Master data analysis, machine learning, and artificial
                                intelligence.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="bi bi-people-fill me-1"></i>289 enrolled</small>
                                <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="border rounded-3 p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-success">New</span>
                                <small class="text-muted">12 modules</small>
                            </div>
                            <h6 class="fw-bold mb-2">Digital Marketing</h6>
                            <p class="text-muted small mb-3">Learn SEO, social media marketing, and content strategy.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="bi bi-people-fill me-1"></i>156 enrolled</small>
                                <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="border rounded-3 p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-info">Trending</span>
                                <small class="text-muted">16 modules</small>
                            </div>
                            <h6 class="fw-bold mb-2">Cloud Computing</h6>
                            <p class="text-muted small mb-3">AWS, Azure, and GCP fundamentals and advanced concepts.
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="bi bi-people-fill me-1"></i>214 enrolled</small>
                                <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
