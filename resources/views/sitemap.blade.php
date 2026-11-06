@php echo '<?xml version="1.0" encoding="UTF-8"?>'; @endphp
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Static pages -->
    <url><loc>{{ url('/') }}</loc></url>
    <url><loc>{{ route('about') }}</loc></url>
    <url><loc>{{ route('services') }}</loc></url>
    <url><loc>{{ route('team') }}</loc></url>
    <url><loc>{{ route('careers') }}</loc></url>
    <url><loc>{{ route('insights') }}</loc></url>
    <url><loc>{{ route('contact-details.show') }}</loc></url>
    <url><loc>{{ route('contact') }}</loc></url>
    <url><loc>{{ route('privacy-policy') }}</loc></url>
    <url><loc>{{ route('terms-of-service') }}</loc></url>

    <!-- Services -->
    @foreach($services as $service)
        <url>
            <loc>{{ route('services.show', $service->id) }}</loc>
        </url>
    @endforeach

    <!-- Insights -->
    @foreach($insights as $insight)
        <url>
            <loc>{{ route('insights.show', $insight->id) }}</loc>
        </url>
    @endforeach
</urlset>