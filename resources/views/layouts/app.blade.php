<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyFurniture</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>

    {{-- Loading overlay (inline styles so it appears immediately) --}}
    <div id="loading-overlay" style="position:fixed;inset:0;display:flex;align-items:center;justify-content:center;background-color:#fff;z-index:99999;transition:opacity .25s;">
        <div style="text-align:center;">
            <div class="spinner-border text-warning" role="status" style="width:3rem;height:3rem;border-width:.35rem"></div>
            <div class="mt-2 text-muted small">Loading...</div>
        </div>
    </div>

    <main>
        {{-- Admin quickbar (visible to authenticated admins) --}}
        @auth
            @if(auth()->user()->is_admin ?? false)
                {{-- Floating button only visible on medium+ screens to avoid covering mobile UI --}}
                <div class="position-fixed d-none d-md-block" style="right:16px;bottom:16px;z-index:1050">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-warning shadow rounded-pill">Admin</a>
                </div>
            @endif
        @endauth

        @yield('content')
    </main>

    <script>
        // Hide the loading overlay once the DOM is ready or on window load
        function hideLoading() {
            var ov = document.getElementById('loading-overlay');
            if (!ov) return;
            ov.style.opacity = '0';
            setTimeout(function(){ ov.style.display = 'none'; }, 300);
        }

        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            hideLoading();
        } else {
            document.addEventListener('DOMContentLoaded', hideLoading);
            window.addEventListener('load', hideLoading);
        }

        // Show overlay on link click or form submit to avoid white flash while navigating
        document.addEventListener('click', function(e){
            var a = e.target.closest && e.target.closest('a');
            if (a && a.href && a.target !== '_blank' && !a.hasAttribute('download')) {
                var ov = document.getElementById('loading-overlay');
                if (ov) { ov.style.display = 'flex'; ov.style.opacity = '1'; }
            }
        });

        document.addEventListener('submit', function(e){
            var ov = document.getElementById('loading-overlay');
            if (ov) { ov.style.display = 'flex'; ov.style.opacity = '1'; }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
