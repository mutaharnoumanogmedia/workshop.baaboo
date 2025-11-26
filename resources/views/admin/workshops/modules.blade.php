<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Workshops Modules : ' . $course->title) }}
        </h2>
    </x-slot>

    <div class="container-fluid px-4 py-4">
        <div class="d-card">
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Chapter Title</th>
                            <th>Videos</th>
                            <th>Audios</th>
                            <th>Resources</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($course->chapters as $chapter)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $chapter->title }}</td>
                                <td>
                                    <ol>
                                        @foreach ($chapter->videos as $video)
                                            <li>{{ $video->title }} ({{ $video->duration }} mins)</li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td>
                                    <ol>
                                        @foreach ($chapter->audios as $audio)
                                            <li>{{ $audio->title }} ({{ $audio->duration }} mins)</li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td>
                                    <ul>
                                        @foreach ($chapter->resources as $resource)
                                            <li>{{ $resource->title }} ({{ $resource->type }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-admin-layout>
