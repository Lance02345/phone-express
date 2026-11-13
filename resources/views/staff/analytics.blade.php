@extends('layouts.staff')
@section('title', 'Website analytics')
@section('styles')
<style>
    .an-head{display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:1rem}.an-head h1{margin:0;font-size:1.7rem;font-weight:800;letter-spacing:-.04em}
    .range-chips{display:flex;flex-wrap:wrap;gap:.35rem}.range-chips a{padding:.45rem .8rem;color:#0a0a0a;background:#fff;border:1px solid var(--staff-line);border-radius:99px;font-size:.78rem;font-weight:700;text-decoration:none}.range-chips a.active{color:#fff;background:#0a0a0a;border-color:#0a0a0a}
    .custom-range{display:flex;flex-wrap:wrap;gap:.4rem;align-items:center}.custom-range input{min-height:36px;padding:.3rem .55rem;font-size:.78rem;border:1px solid var(--staff-line);border-radius:9px}.custom-range button{padding:.4rem .8rem;font-size:.78rem}
    .live-chip{display:inline-flex;align-items:center;gap:.45rem;padding:.4rem .75rem;background:#fff;border:1px solid var(--staff-line);border-radius:99px;font-size:.78rem;font-weight:700}.live-dot{width:8px;height:8px;background:#16a34a;border-radius:50%;box-shadow:0 0 0 0 rgba(22,163,74,.5);animation:pulse 2s infinite}@keyframes pulse{70%{box-shadow:0 0 0 8px rgba(22,163,74,0)}100%{box-shadow:0 0 0 0 rgba(22,163,74,0)}}
    .kpi{height:100%;padding:1.1rem 1.15rem}.kpi-label{color:#6b6b6b;font-size:.74rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em}.kpi-value{margin:.35rem 0 .2rem;font-size:1.65rem;font-weight:800;letter-spacing:-.04em}.kpi-sub{color:#7a7a7a;font-size:.74rem}
    .delta{font-weight:800}.delta.up{color:#15803d}.delta.down{color:#b91c1c}.delta.flat{color:#7a7a7a}
    .panel-head{padding:1rem 1.2rem;border-bottom:1px solid var(--staff-line)}.panel-head h2{margin:0;font-size:.98rem;font-weight:800}.panel-head small{color:#7a7a7a}
    .panel-body{padding:.6rem 1.2rem 1rem}
    .bar-row{padding:.45rem 0}.bar-label{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.bar-track{height:6px;margin-top:.3rem;overflow:hidden;background:#efefef;border-radius:99px}.bar-track span{display:block;height:100%;background:linear-gradient(90deg,#0a0a0a,#6b6b6b);border-radius:99px}
    .empty-state{padding:1.4rem .5rem;color:#7a7a7a;font-size:.85rem;text-align:center}
    .heat{display:grid;grid-template-columns:38px repeat(24,minmax(0,1fr));gap:3px;min-width:640px}.heat span{display:block;aspect-ratio:1/1;border-radius:4px}.heat .lbl{display:flex;align-items:center;color:#7a7a7a;font-size:.68rem;aspect-ratio:auto}.heat .hr{color:#9a9a9a;font-size:.6rem;text-align:center;aspect-ratio:auto}
    .an-table th{color:#6b6b6b;font-size:.72rem;text-transform:uppercase;letter-spacing:.04em;white-space:nowrap}.an-table td,.an-table th{padding:.7rem 1rem!important}.an-table td{font-size:.84rem}
    .journey{padding:.85rem 1.2rem;border-bottom:1px solid #eee}.journey:last-child{border-bottom:0}.journey-path{display:flex;flex-wrap:wrap;gap:.3rem;margin-top:.45rem}.journey-path code{padding:.15rem .45rem;color:#0a0a0a;background:#f2f2f2;border-radius:6px;font-size:.72rem}.tag{display:inline-block;padding:.12rem .45rem;background:#f2f2f2;border-radius:99px;font-size:.68rem;font-weight:700}.tag.wa{color:#fff;background:#15803d}
    #trendChart{min-height:320px}
</style>
@endsection
@section('content')
@php
    $fmtDuration = fn (int $s) => $s >= 60 ? intdiv($s, 60).'m '.str_pad($s % 60, 2, '0', STR_PAD_LEFT).'s' : $s.'s';
    $delta = function (string $key, bool $lowerIsBetter = false) use ($summary, $previous) {
        $now = $summary[$key]; $before = $previous[$key];
        if (! $before) { return $now ? '<span class="delta flat">new</span>' : ''; }
        $change = round(($now - $before) / $before * 100);
        $good = $lowerIsBetter ? $change < 0 : $change > 0;
        $class = $change === 0.0 || $change == 0 ? 'flat' : ($good ? 'up' : 'down');
        return '<span class="delta '.$class.'">'.($change > 0 ? '▲' : ($change < 0 ? '▼' : '')).' '.abs($change).'%</span>';
    };
    $sourceNames = ['direct' => 'Direct / typed / apps', 'search' => 'Search engines', 'social' => 'Social media', 'referral' => 'Other websites', 'campaign' => 'Campaign links (UTM)', 'paid' => 'Google Ads'];
    $eventNames = ['whatsapp_click' => 'WhatsApp', 'call_click' => 'Phone call', 'email_click' => 'Email', 'outbound_click' => 'External link'];
    $days = ['', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $heatMax = max(1, max(array_map('max', $heatmap)));
@endphp

<div class="an-head mb-4">
    <div>
        <span class="small fw-bold text-muted">WEBSITE ANALYTICS</span>
        <h1>How customers use the website</h1>
        <div class="text-muted small mt-1">{{ $from->format('j M Y') }} – {{ $to->format('j M Y') }} · compared with the previous {{ $from->diffInDays($to) + 1 }} {{ Str::plural('day', $from->diffInDays($to) + 1) }} · Nairobi time</div>
    </div>
    <div class="d-flex flex-column align-items-lg-end gap-2">
        <span class="live-chip"><span class="live-dot"></span>{{ $live['visitors'] }} on the site now <span class="text-muted fw-normal">(last 5 min)</span></span>
        <div class="range-chips">@foreach($presets as $key => $name)<a href="{{ route('staff.analytics.index', ['range' => $key]) }}" class="{{ $range === $key ? 'active' : '' }}">{{ $name }}</a>@endforeach</div>
        <form class="custom-range" method="GET" action="{{ route('staff.analytics.index') }}">
            <input type="date" name="from" value="{{ $from->toDateString() }}" max="{{ now(config('analytics.timezone'))->toDateString() }}" aria-label="From">
            <input type="date" name="to" value="{{ $to->toDateString() }}" max="{{ now(config('analytics.timezone'))->toDateString() }}" aria-label="To">
            <button class="btn btn-staff btn-sm rounded-pill">Apply</button>
        </form>
    </div>
</div>
@if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

<div class="row g-3 mb-4">
@foreach([
    ['Visitors', number_format($summary['visitors']), 'visitors', false, number_format($summary['new_visitors']).' new · '.number_format($summary['returning_visitors']).' returning'],
    ['Page views', number_format($summary['page_views']), 'page_views', false, number_format($summary['product_views']).' product pages'],
    ['Visits', number_format($summary['sessions']), 'sessions', false, $summary['pages_per_session'].' pages per visit'],
    ['Avg. visit length', $fmtDuration($summary['avg_duration']), 'avg_duration', false, 'first to last page'],
    ['Bounce rate', $summary['bounce_rate'].'%', 'bounce_rate', true, 'left after one page'],
    ['WhatsApp enquiries', number_format($summary['whatsapp_clicks']), 'whatsapp_clicks', false, number_format($summary['call_clicks']).' calls · '.number_format($summary['email_clicks']).' emails'],
    ['Enquiry rate', $summary['conversion_rate'].'%', 'conversion_rate', false, 'visits that opened WhatsApp'],
    ['Searches', number_format($summary['searches']), 'searches', false, 'on the shop page'],
] as [$label, $value, $key, $lowerBetter, $sub])
    <div class="col-6 col-md-4 col-xl-3"><div class="staff-card kpi">
        <div class="kpi-label">{{ $label }}</div>
        <div class="kpi-value">{{ $value }}</div>
        <div class="kpi-sub">{!! $delta($key, $lowerBetter) !!} {{ $sub }}</div>
    </div></div>
@endforeach
</div>

<section class="staff-card mb-4">
    <div class="panel-head d-flex justify-content-between"><h2>Traffic and enquiries over time</h2><small>daily</small></div>
    <div class="panel-body"><div id="trendChart"></div></div>
</section>

<div class="row g-4 mb-4">
    <div class="col-lg-4"><section class="staff-card h-100"><div class="panel-head"><h2>Where visits come from</h2><small>per visit</small></div><div class="panel-body">
        @include('staff.partials.bar-list', ['rows' => $sources, 'label' => 'label', 'value' => 'sessions', 'format' => fn ($v) => $sourceNames[$v] ?? ucfirst($v)])
    </div></section></div>
    <div class="col-lg-4"><section class="staff-card h-100"><div class="panel-head"><h2>Referring websites &amp; apps</h2></div><div class="panel-body">
        @include('staff.partials.bar-list', ['rows' => $referrers, 'label' => 'label', 'value' => 'sessions', 'empty' => 'No visits from other websites yet. WhatsApp and many apps hide the referrer, so those show as “Direct”.'])
    </div></section></div>
    <div class="col-lg-4"><section class="staff-card h-100"><div class="panel-head"><h2>Devices</h2></div><div class="panel-body">
        @include('staff.partials.bar-list', ['rows' => $devices, 'label' => 'label', 'value' => 'sessions', 'format' => fn ($v) => ucfirst($v)])
        <hr class="my-2">
        <div class="small fw-bold text-muted mb-1">Operating system</div>
        @include('staff.partials.bar-list', ['rows' => $systems, 'label' => 'label', 'value' => 'sessions'])
    </div></section></div>
</div>

<section class="staff-card mb-4 overflow-hidden">
    <div class="panel-head d-flex justify-content-between"><h2>Product interest → WhatsApp enquiries</h2><small>which phones get looked at, and which ones turn into conversations</small></div>
    @if($topProducts->isEmpty())<div class="empty-state">Product views will appear here as customers open phone pages.</div>@else
    <div class="table-responsive"><table class="table an-table align-middle mb-0">
        <thead><tr><th>Product</th><th class="text-end">Views</th><th class="text-end">Visitors</th><th class="text-end">WhatsApp</th><th class="text-end">Enquiry rate</th><th class="text-end">Price</th></tr></thead>
        <tbody>@foreach($topProducts as $row)<tr>
            <td><a href="{{ route('phones.show', $row->variant) }}" target="_blank" class="text-reset fw-bold text-decoration-none">{{ $row->variant->name }}</a><div class="small text-muted">{{ $row->variant->product->brand->name ?? '' }}</div></td>
            <td class="text-end">{{ number_format($row->views) }}</td><td class="text-end">{{ number_format($row->visitors) }}</td>
            <td class="text-end">{{ number_format($row->whatsapp) }}</td><td class="text-end fw-bold">{{ $row->rate }}%</td>
            <td class="text-end text-nowrap">{{ $row->variant->price ? 'KES '.number_format($row->variant->price) : 'On request' }}</td>
        </tr>@endforeach</tbody>
    </table></div>@endif
</section>

<div class="row g-4 mb-4">
    <div class="col-lg-4"><section class="staff-card h-100"><div class="panel-head"><h2>What customers search for</h2></div><div class="panel-body">
        @include('staff.partials.bar-list', ['rows' => $searches, 'label' => 'search_term', 'value' => 'searches', 'empty' => 'No searches yet.'])
    </div></section></div>
    <div class="col-lg-4"><section class="staff-card h-100"><div class="panel-head"><h2>Shop filters used</h2></div><div class="panel-body">
        @include('staff.partials.bar-list', ['rows' => $filters, 'label' => 'label', 'value' => 'total', 'empty' => 'No filters used yet.'])
    </div></section></div>
    <div class="col-lg-4"><section class="staff-card h-100"><div class="panel-head"><h2>Brand interest</h2><small>product page views</small></div><div class="panel-body">
        @include('staff.partials.bar-list', ['rows' => $brandInterest, 'label' => 'name', 'value' => 'views'])
    </div></section></div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-4"><section class="staff-card h-100"><div class="panel-head"><h2>Most visited pages</h2></div><div class="panel-body">
        @include('staff.partials.bar-list', ['rows' => $topPages, 'label' => 'path', 'value' => 'views'])
    </div></section></div>
    <div class="col-lg-4"><section class="staff-card h-100"><div class="panel-head"><h2>Landing pages</h2><small>first page of a visit</small></div><div class="panel-body">
        @include('staff.partials.bar-list', ['rows' => $entryPages, 'label' => 'path', 'value' => 'sessions'])
    </div></section></div>
    <div class="col-lg-4"><section class="staff-card h-100"><div class="panel-head"><h2>Exit pages</h2><small>last page before leaving</small></div><div class="panel-body">
        @include('staff.partials.bar-list', ['rows' => $exitPages, 'label' => 'path', 'value' => 'sessions'])
    </div></section></div>
</div>

<section class="staff-card mb-4">
    <div class="panel-head d-flex justify-content-between"><h2>Busiest days &amp; hours</h2><small>page views, Nairobi time; darker = busier</small></div>
    <div class="panel-body overflow-auto">
        <div class="heat">
            <span class="lbl"></span>@for($h = 0; $h < 24; $h++)<span class="hr">{{ $h % 3 === 0 ? $h : '' }}</span>@endfor
            @for($d = 1; $d <= 7; $d++)
                <span class="lbl">{{ $days[$d] }}</span>
                @for($h = 0; $h < 24; $h++)
                    @php($v = $heatmap[$d][$h])
                    <span title="{{ $days[$d] }} {{ str_pad($h, 2, '0', STR_PAD_LEFT) }}:00 · {{ $v }} views" style="background:{{ $v ? 'rgba(10,10,10,'.round(.08 + .92 * $v / $heatMax, 2).')' : '#f2f2f2' }}"></span>
                @endfor
            @endfor
        </div>
    </div>
</section>

<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6"><section class="staff-card h-100"><div class="panel-head"><h2>Browsers &amp; in-app</h2></div><div class="panel-body">
        @include('staff.partials.bar-list', ['rows' => $browsers, 'label' => 'label', 'value' => 'sessions'])
    </div></section></div>
    <div class="col-lg-3 col-md-6"><section class="staff-card h-100"><div class="panel-head"><h2>Contact clicks</h2></div><div class="panel-body">
        @include('staff.partials.bar-list', ['rows' => $events->map(fn ($e) => (object) ['label' => ($eventNames[$e->name] ?? $e->name).($e->label ? ' · '.$e->label : ''), 'total' => $e->total]), 'label' => 'label', 'value' => 'total', 'empty' => 'No WhatsApp, call or email clicks yet.'])
    </div></section></div>
    <div class="col-lg-3 col-md-6"><section class="staff-card h-100"><div class="panel-head"><h2>Campaigns</h2><small>links with ?utm_source=</small></div><div class="panel-body">
        @forelse($campaigns as $c)<div class="bar-row d-flex justify-content-between small"><span class="bar-label">{{ $c->utm_source }}@if($c->utm_medium) / {{ $c->utm_medium }}@endif @if($c->utm_campaign)<span class="text-muted">· {{ $c->utm_campaign }}</span>@endif</span><strong>{{ number_format($c->sessions) }}</strong></div>@empty<div class="empty-state">Add <code>?utm_source=instagram&amp;utm_campaign=black-friday</code> to links you share to track them here.</div>@endforelse
    </div></section></div>
    <div class="col-lg-3 col-md-6"><section class="staff-card h-100"><div class="panel-head"><h2>Live right now</h2><small>last 5 minutes</small></div><div class="panel-body">
        @include('staff.partials.bar-list', ['rows' => $live['pages'], 'label' => 'path', 'value' => 'visitors', 'showShare' => false, 'empty' => 'Nobody on the site right now.'])
        @if($countries->isNotEmpty())<hr class="my-2"><div class="small fw-bold text-muted mb-1">Countries</div>@include('staff.partials.bar-list', ['rows' => $countries, 'label' => 'label', 'value' => 'sessions'])@endif
    </div></section></div>
</div>

<section class="staff-card mb-2">
    <div class="panel-head d-flex justify-content-between"><h2>Latest visits</h2><small>each visitor's path through the site</small></div>
    @forelse($journeys as $j)
        <div class="journey">
            <div class="d-flex flex-wrap justify-content-between gap-2 small">
                <span><strong>{{ $j->started->timezone(config('analytics.timezone'))->format('D j M, H:i') }}</strong>
                    <span class="text-muted">· {{ $fmtDuration((int) $j->started->diffInSeconds($j->ended)) }} · {{ ucfirst($j->device) }} · {{ $j->browser }} on {{ $j->os }} · {{ $sourceNames[$j->source] ?? ucfirst($j->source) }}@if($j->referrer) ({{ $j->referrer }})@endif</span></span>
                <span>@if($j->returning)<span class="tag">Returning</span>@else<span class="tag">New</span>@endif @foreach($j->events as $e)<span class="tag {{ $e === 'whatsapp_click' ? 'wa' : '' }}">{{ $eventNames[$e] ?? $e }}</span> @endforeach</span>
            </div>
            <div class="journey-path">@foreach($j->paths as $p)<code>{{ $p }}</code>@if(! $loop->last)<span class="text-muted small">→</span>@endif @endforeach</div>
        </div>
    @empty
        <div class="empty-state">Visits will show up here as soon as customers browse the website.</div>
    @endforelse
</section>
<p class="text-muted small mb-0">Counts exclude bots, link previews and signed-in staff. Visitors are counted with an anonymous first-party cookie; no IP addresses are stored. Raw data is kept for {{ config('analytics.retention_days') }} days.</p>

<script src="{{ asset('build/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
    (function () {
        var daily = @json($daily);
        new ApexCharts(document.getElementById('trendChart'), {
            chart: { type: 'area', height: 320, toolbar: { show: false }, fontFamily: 'Arial, sans-serif', zoom: { enabled: false } },
            series: [
                { name: 'Page views', type: 'area', data: daily.map(d => d.views) },
                { name: 'Visitors', type: 'line', data: daily.map(d => d.visitors) },
                { name: 'WhatsApp enquiries', type: 'column', data: daily.map(d => d.whatsapp) }
            ],
            labels: daily.map(d => d.date),
            xaxis: { type: 'datetime', labels: { datetimeUTC: false } },
            yaxis: [
                { seriesName: 'Page views', min: 0, forceNiceScale: true, labels: { formatter: v => Math.round(v) } },
                { seriesName: 'Page views', show: false },
                { seriesName: 'WhatsApp enquiries', opposite: true, min: 0, forceNiceScale: true, labels: { formatter: v => Math.round(v) }, title: { text: 'WhatsApp' } }
            ],
            colors: ['#0a0a0a', '#8a8a8a', '#16a34a'],
            stroke: { width: [2, 2, 0], curve: 'smooth' },
            fill: { opacity: [0.12, 1, 0.85] },
            plotOptions: { bar: { columnWidth: '40%', borderRadius: 3 } },
            dataLabels: { enabled: false },
            legend: { position: 'top', horizontalAlign: 'left' },
            grid: { borderColor: '#eee' },
            tooltip: { shared: true, x: { format: 'ddd d MMM yyyy' } }
        }).render();
    })();
</script>
@endsection
