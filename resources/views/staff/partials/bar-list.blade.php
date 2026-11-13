{{-- $rows: iterable of objects; $label / $value: property names; $format: optional fn(label) --}}
@php($items = collect($rows))
@php($max = max(1, (int) $items->max($value)))
@php($total = max(1, (int) $items->sum($value)))
@forelse($items as $row)
    @php($text = isset($format) ? $format($row->{$label}) : $row->{$label})
    <div class="bar-row">
        <div class="d-flex justify-content-between gap-3 small">
            <span class="bar-label" title="{{ $text }}">{{ $text }}</span>
            <span class="text-nowrap"><strong>{{ number_format($row->{$value}) }}</strong>@if($showShare ?? true) <span class="text-muted">· {{ round($row->{$value} / $total * 100) }}%</span>@endif</span>
        </div>
        <div class="bar-track"><span style="width:{{ $row->{$value} / $max * 100 }}%"></span></div>
    </div>
@empty
    <div class="empty-state">{{ $empty ?? 'No data for this period yet.' }}</div>
@endforelse
