<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HBYS - @yield('title', 'Yönetim Paneli')</title>
    <!-- Resource Hints for Ultra-Fast CDN Loading -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">

    <link href="{{ asset('vendor/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/hospital.css') }}?v={{ time() }}">
    @stack('styles')
</head>
<body class="bg-light">
    <div class="d-flex" id="wrapper">
        @include('layouts.partials.sidebar')

        <div id="page-content-wrapper" class="w-100 d-flex flex-column min-vh-100">
            @include('layouts.partials.navbar')

            <main class="container-fluid p-4 flex-grow-1">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>

            @include('layouts.partials.footer')
        </div>
    </div>

    <script src="{{ asset('vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/table-dynamic-filter.js') }}?v={{ time() }}"></script>
    <script>
        window.updateNotificationBadgeCount = function(count) {
            const badges = document.querySelectorAll('.js-unread-count-badge');
            badges.forEach(b => {
                if (count > 0) {
                    b.textContent = count > 9 ? '9+' : count;
                    b.classList.remove('d-none');
                } else {
                    b.textContent = '0';
                    b.classList.add('d-none');
                }
            });

            const headerBadges = document.querySelectorAll('.js-unread-header-badge');
            headerBadges.forEach(hb => {
                hb.textContent = count + ' Okunmamış';
            });
        };

        window.markNavNotificationRead = function(id, btnElement) {
            fetch("{{ url('/notifications/mark-read') }}/" + id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (typeof data.unread_count !== 'undefined') {
                        window.updateNotificationBadgeCount(data.unread_count);
                    }
                    const item = document.querySelector('.nav-alert-item-' + id);
                    if (item) {
                        item.classList.remove('bg-light', 'font-weight-bold');
                        item.classList.add('bg-white', 'text-muted', 'opacity-75');
                        const dot = item.querySelector('.nav-unread-dot');
                        if (dot) dot.remove();
                    }
                    if (btnElement) btnElement.remove();

                    if (typeof updatePageStats === 'function') {
                        updatePageStats(data.stats, data.unread_count);
                    }
                }
            })
            .catch(err => console.error(err));
        };

        window.markAllNavNotificationsRead = function() {
            fetch("{{ url('/notifications/mark-all-read') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    if (typeof data.unread_count !== 'undefined') {
                        window.updateNotificationBadgeCount(data.unread_count);
                    }
                    const list = document.getElementById('nav-dropdown-alerts-list');
                    if (list) {
                        list.querySelectorAll('.list-group-item').forEach(item => {
                            item.classList.remove('bg-light', 'font-weight-bold');
                            item.classList.add('bg-white', 'text-muted', 'opacity-75');
                        });
                        list.querySelectorAll('.nav-unread-dot').forEach(dot => dot.remove());
                        list.querySelectorAll('button').forEach(btn => btn.remove());
                    }

                    if (typeof updatePageStats === 'function') {
                        updatePageStats(data.stats, data.unread_count);
                    }
                }
            })
            .catch(err => console.error(err));
        };
    </script>
    @stack('scripts')
</body>
</html>