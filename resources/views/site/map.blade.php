@extends('layouts.site')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<style>
    #map-wrap {
        position: relative;
        height: 600px;
        width: 100%;
    }
    #village-map {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        height: 100%;
        width: 100%;
        z-index: 1;
        background: #f8fafc;
    }
    .leaflet-pane,
    .leaflet-tile,
    .leaflet-marker-icon,
    .leaflet-marker-shadow,
    .leaflet-tile-container,
    .leaflet-pane > svg,
    .leaflet-pane > canvas,
    .leaflet-zoom-box,
    .leaflet-image-layer,
    .leaflet-layer { position: absolute; }
    .leaflet-container {
        height: 100%;
        width: 100%;
        background: #f8fafc;
        font-family: 'Inter', sans-serif;
    }
    .leaflet-popup-content-wrapper {
        background: #ffffff;
        color: #1e293b;
        border: 1px solid rgba(0,0,0,0.1);
        border-radius: 3px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }
    .leaflet-popup-tip-container .leaflet-popup-tip { background: #ffffff; }
    .leaflet-popup-content { margin: 12px 16px; font-size: 13px; line-height: 1.6; color: #334155; }
    .leaflet-control-zoom a {
        background: #ffffff !important;
        color: #64748b !important;
        border: 1px solid rgba(0,0,0,0.15) !important;
    }
    .leaflet-control-zoom a:hover { background: #f1f5f9 !important; color: #0f172a !important; }
    .leaflet-bar { border: none !important; box-shadow: 0 1px 5px rgba(0,0,0,0.2) !important; }
    .leaflet-control-attribution { background: rgba(255,255,255,0.85) !important; color: #94a3b8 !important; font-size: 10px; }
    .leaflet-control-attribution a { color: #64748b !important; }

    /* Dark mode styling for Leaflet using CSS filters */
    html.dark .leaflet-layer,
    html.dark .leaflet-control-zoom-in,
    html.dark .leaflet-control-zoom-out,
    html.dark .leaflet-control-attribution {
        filter: invert(100%) hue-rotate(180deg) brightness(95%) contrast(90%);
    }
    
    /* Ensure popups look good in dark mode */
    html.dark .leaflet-popup-content-wrapper,
    html.dark .leaflet-popup-tip {
        background: #1e293b;
        color: #f8fafc;
        border-color: rgba(255,255,255,0.1);
    }
    html.dark .leaflet-popup-content {
        color: #cbd5e1;
    }
</style>
@endpush

@section('content')
<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

    <div class="mb-12 max-w-2xl">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-slate-500">Peta Wilayah</p>
        <h1 class="mt-5 text-4xl font-semibold leading-tight text-slate-900 dark:text-white sm:text-5xl">Titik layanan dan fasilitas Kelurahan Simomulyo.</h1>
        <p class="mt-5 text-base leading-8 text-slate-600 dark:text-slate-400">Peta ini menampilkan lokasi kantor kelurahan, fasilitas umum, dan titik penting yang membantu warga menemukan layanan dengan cepat.</p>
    </div>

    {{-- Layout bawah: sidebar + map --}}
    <div class="flex flex-col gap-10 lg:flex-row">

        {{-- Sidebar kiri — lebar tetap --}}
        <div class="w-full space-y-6 lg:w-72 lg:shrink-0">
            <div class="border border-slate-200 bg-white p-6 dark:border-white/8 dark:bg-transparent transition-colors duration-300">
                <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Kantor Kelurahan</p>
                <h2 class="mt-2 text-base font-semibold text-slate-900 dark:text-white">Alamat & Lokasi</h2>
                <p class="mt-4 text-sm leading-6 text-slate-600 dark:text-slate-400">{{ $village['address'] }}</p>
                <div class="mt-4 inline-block bg-slate-100 px-3 py-1.5 text-xs font-mono text-slate-500 dark:bg-white/5">
                    {{ $village['latitude'] }}, {{ $village['longitude'] }}
                </div>
            </div>

            <div class="border border-slate-200 bg-white p-6 dark:border-white/8 dark:bg-transparent transition-colors duration-300">
                <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Titik Penting</p>
                <ul class="mt-4 divide-y divide-slate-200 dark:divide-white/8">
                    @foreach ($village['points'] as $point)
                        <li class="py-4 first:pt-0 last:pb-0">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $point['name'] }}</p>
                            <p class="mt-0.5 text-[10px] uppercase tracking-[0.15em] text-slate-500">{{ $point['type'] }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Map container — flex-1 agar mengisi sisa ruang --}}
        <div class="min-h-[500px] flex-1 border border-slate-200 dark:border-white/8">
            <div id="map-wrap">
                <div id="village-map"></div>
            </div>
        </div>

    </div>
</section>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    window.addEventListener('load', function () {
        const village = @json($village);

        const map = L.map('village-map', {
            zoomControl: false,
            scrollWheelZoom: true,
        }).setView([village.latitude, village.longitude], village.zoom || 15);

        L.control.zoom({ position: 'bottomright' }).addTo(map);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap &copy; CARTO',
        }).addTo(map);

        L.marker([village.latitude, village.longitude])
            .addTo(map)
            .bindPopup('<strong>' + village.name + '</strong><br>' + village.address)
            .openPopup();

        village.points.forEach(function (point) {
            L.marker([point.latitude, point.longitude])
                .addTo(map)
                .bindPopup('<strong>' + point.name + '</strong><br><em>' + point.type + '</em><br>' + (point.description ?? ''));
        });

        // Tiga kali invalidate untuk pastikan container sudah ada dimensinya
        map.invalidateSize();
        setTimeout(function () { map.invalidateSize(); }, 100);
        setTimeout(function () { map.invalidateSize(); }, 400);
    });
</script>
@endpush
