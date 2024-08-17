@extends('layouts.landing_page')

@push('head')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/divisi.css') }}">
<script src="{{ asset('assets/js/divisi.js') }}"></script>

<style>
    html {
        scroll-behavior: smooth;
    }
</style>
@endpush
@section('landing_page-content')
<div class="bodycontainer">
    @php
    $fallbackImage = asset('assets/divisi/kegiatan-divisi/notfound.webp');
    @endphp
    <div class="container infocarddivisi">
        <div class="infocarddivisi-left">
            <div style="display: flex; justify-content: center; align-items: center;">
                <img src="{{ asset('assets/divisi/' . $divisi . '.png') }}" alt="Deskripsi Foto">
            </div>
        </div>
        <div class="infocarddivisi-right">
            <div class="title-container">
                <h1>
                    {{ strtoupper($divisi) }}
                    <div class="tenor-gif-embed" data-postid="26237932" data-share-method="host" data-aspect-ratio="1" data-width="40px" style="margin-left: 10px;">
                    </div>
                </h1>
            </div>
            <div class="container-count dekstop">
                <div class="count">
                    <p class="count-value">{{$count_proyekkerja ?? 0}}</p>
                    <p class="count-label">Proker</p>
                </div>
                <div class="count">
                    <p class="count-value">{{$count_anggota ?? 0}}</p>
                    <p class="count-label">Anggota</p>
                </div>
                <div class="count">
                    <p class="count-value">1</p>
                    <p class="count-label">Komunitas</p>
                </div>
            </div>
            <p>{{ $tentang }}</p>
        </div>
    </div>

    <script type="text/javascript" async src="https://tenor.com/embed.js"></script>


    <div class="container">
        @if(count($prokerItems) > 0)
        <div class="slider-container">
            <button class="slider-nav prev">‹</button>
            <div class="slider">
                @foreach($prokerItems as $item)
                <div class="proker-item" data-info="{{ json_encode(['info' => $item['info'], 'fotokegiatan' => $item['fotokegiatan'], 'title' => $item['title']]) }}" onclick="showInfoProker(this)">
                    <div class="imgrounder">
                        <img src="{{ asset('assets/divisi/' . $divisi . '.png') }}" class="round" onerror="this.src='{{ $fallbackImage }}';" alt="Image not found">
                    </div>
                    <p>{{ $item['title'] }}</p>
                </div>
                @endforeach
            </div>
            <button class="slider-nav next">›</button>
        </div>
        @endif
        <div class="container-count mobile">
            <div class="count">
                <p class="count-value">{{$count_proyekkerja ?? 0}}</p>
                <p class="count-label">Proker</p>
            </div>
            <div class="count">
                <p class="count-value">{{$count_anggota ?? 0}}</p>
                <p class="count-label">Anggota</p>
            </div>
            <div class="count">
                <p class="count-value">1</p>
                <p class="count-label">Komunitas</p>
            </div>
        </div>

        <div id="info-proker" class="info-proker" style="display: none;">
            <span id="close-btn" onclick="hideInfoProker()">X</span>
            <div id="info-content"></div>
        </div>
        <div class="container-member">
            @foreach ($members as $members)
            <div class="member-item">
                <div class="image-background">
                    <img class="imgdivisi" src="{{ asset('assets/divisi/' . $divisi . '.png') }}" alt="Deskripsi Foto">
                    <img class="imgmember" onerror="this.onerror=null; this.src='{{ asset('assets/member/default.png') }}';" src="{{ asset('assets/member/profile/' . $members->image) }}" alt="Foto {{ ucwords($members->name) }}">

                </div>
                <div class="memberinfo">
                    <h1>{{ ucwords($members->name) }}</h1>
                    <p style="text-align: center; color: gray;">{{ ucwords($members->occupation) }} </p>
                    <p style="text-align: center; color: gray;">{{ ucwords($members->periode) }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    const threshold = 50; // Define threshold value

    document.querySelectorAll('.proker-item').forEach(item => {
        let startX;

        item.addEventListener('touchstart', function(event) {
            startX = event.touches[0].clientX;
        });

        item.addEventListener('touchend', function(event) {
            let endX = event.changedTouches[0].clientX;
            if (Math.abs(endX - startX) < threshold) {
                showInfoProker(this);
            }
        });

        item.addEventListener('click', function() {
            showInfoProker(this);
        });
    });

    function showInfoProker(element) {
        let data = JSON.parse(element.getAttribute('data-info'));
        let fallbackImage = '{{ asset("assets/divisi/kegiatan-divisi/notfound.webp") }}';
        let content = `
        <h2>${data.title}</h2>
        <div id="images-wrapper">
    `;

        let fotokegiatan = JSON.parse(data.fotokegiatan);
        fotokegiatan.forEach(function(foto) {
            let imagePath = '{{ asset("assets/divisi/kegiatan-divisi") }}/' + foto.trim();
            content += `<div class="image-container"><img src="${imagePath}" onerror="this.src='${fallbackImage}';" alt="Image not found" onclick="openFullscreen(this);"></div>`;
        });

        content += `
        </div>
        <p>${data.info}</p>
    `;

        document.getElementById('info-content').innerHTML = content;
        document.getElementById('info-proker').style.display = 'flex';

        // Add event listeners for closing the modal
        document.getElementById('close-btn').addEventListener('click', hideInfoProker);
        document.addEventListener('keydown', handleEscapeKey);
        window.addEventListener('popstate', handlePopState);

        // Push a new state to the history stack
        history.pushState(null, null, location.href);
    }

    function openFullscreen(img) {
        // Create a fullscreen container
        const fullscreenContainer = document.createElement('div');
        fullscreenContainer.id = 'fullscreen-container';

        // Create an image element
        const fullscreenImage = document.createElement('img');
        fullscreenImage.id = 'fullscreen-image';
        fullscreenImage.src = img.src;

        // Add the image to the container
        fullscreenContainer.appendChild(fullscreenImage);

        // Add the container to the body
        document.body.appendChild(fullscreenContainer);

        // Use requestAnimationFrame for smoother animation
        requestAnimationFrame(() => {
            fullscreenContainer.classList.add('show');
        });

        // Close the fullscreen view when clicking on the container
        fullscreenContainer.addEventListener('click', function() {
            fullscreenContainer.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(fullscreenContainer);
            }, 1000); // Match the duration of the CSS transition
        });

        // Add event listener for closing fullscreen with 'Esc' key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                fullscreenContainer.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(fullscreenContainer);
                }, 1000);
            }
        });
    }

    function hideInfoProker() {
        document.getElementById('info-proker').style.display = 'none';

        // Remove event listeners
        document.removeEventListener('keydown', handleEscapeKey);
        window.removeEventListener('popstate', handlePopState);
    }

    function handleEscapeKey(event) {
        if (event.key === 'Escape') {
            hideInfoProker();
        }
    }

    function handlePopState() {
        hideInfoProker();
    }
</script>


@endsection
