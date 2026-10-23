@props(['title', 'value', 'icon', 'color' => 'primary'])

<div class="card border-0 shadow-sm h-100">
    <div class="card-body d-flex align-items-center gap-3">
        <div class="rounded-circle bg-{{ $color }}-subtle text-{{ $color }} d-flex align-items-center justify-content-center flex-shrink-0" style="width: 3rem; height: 3rem;">
            <i class="bi {{ $icon }} fs-4" aria-hidden="true"></i>
        </div>
        <div>
            <p class="text-muted mb-1">{{ $title }}</p>
            <p class="h3 mb-0">{{ number_format($value) }}</p>
        </div>
    </div>
</div>
