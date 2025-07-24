<x-dynamic-layout>
    <!-- content -->
    <div class="body-content">  
        <div class="container">
            <div class="wrapper">
                <h1>Pengumuman</h1>
                @foreach ($announcements as $announcement)
                    <div class="announcement">
                        <h2>{{ $announcement->title }}</h2>
                        <p>{{ $announcement->content }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-dynamic-layout>