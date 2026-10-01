<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal Resmi Dinas Komunikasi dan Informatika (Diskominfo) Kabupaten Tasikmalaya - Pelayanan Administrasi Publik Terpadu 39 Kecamatan">
    <title>Diskominfo Kabupaten Tasikmalaya — Portal Layanan Publik Terpadu</title>

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    {{-- Custom Page Styles --}}
    @include('landing.partials.styles')

    {{-- Landing Alpine App State & Datasets --}}
    @include('landing.partials.state')
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased selection:bg-[#0a2558] selection:text-white"
      x-data="landingApp()"
      x-init="startAutoPlay()">

    {{-- 1. Header Navigation --}}
    @include('landing.partials.header')

    {{-- 2. Hero Section --}}
    @include('landing.partials.hero')

    {{-- 3. Capaian & Standar Layanan --}}
    @include('landing.partials.capaian')

    {{-- 4. Katalog Layanan Publik Terpadu --}}
    @include('landing.partials.layanan')

    {{-- 5. Tabel Data Kewilayahan 39 Kecamatan --}}
    @include('landing.partials.kewilayahan')

    {{-- 6. Portal PPID & Keterbukaan Informasi Publik --}}
    @include('landing.partials.ppid')

    {{-- 7. FAQ --}}
    @include('landing.partials.faq')

    {{-- 8. Footer --}}
    @include('landing.partials.footer')

    {{-- ═══════════════════════════════════════════════════════════════════════════
         MODALS & INTERACTIVE OVERLAYS
    ═══════════════════════════════════════════════════════════════════════════ --}}
    @include('landing.modals.modal-ppid-form')
    @include('landing.modals.modal-ppid-success')
    @include('landing.modals.modal-ppid-tracking')
    @include('landing.modals.modal-doc-preview')
    @include('landing.modals.modal-pengaduan')
    @include('landing.modals.toast')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
</body>
</html>
