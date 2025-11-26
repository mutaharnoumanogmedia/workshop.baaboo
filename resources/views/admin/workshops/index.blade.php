<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Workshops') }}
        </h2>
    </x-slot>
    <div class="container-fluid px-4 py-4">
        <div class="d-card">
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>SKU</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Publish Status</th>
                            <th>Created At</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $course->id }}</td>
                                <td>{{ $course->sku }}</td>
                                <td>{{ $course->title }}</td>
                                <td>{{ $course->description }}</td>
                                <td>{{ $course->publish_status }}</td>
                                <td>{{ $course->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('admin.workshops.modules', ['id' => $course->id]) }}"
                                        class="btn btn-primary">
                                        View Modules
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</x-admin-layout>
