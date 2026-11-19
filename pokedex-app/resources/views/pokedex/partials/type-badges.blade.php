{{-- Badge tipe elemen. Param: $types (array label), $iconOnly (bool, khusus tabel), $variant (opsional: 'light') --}}
<span class="type-badges {{ !empty($iconOnly) ? 'type-badges--icons' : '' }}">
    @foreach ($types as $t)
        @php
            $key = strtolower(trim($t));
            $meta = config("pokedex.types.{$key}");
            $label = $meta['label'] ?? $t;
            $icon = $meta['icon'] ?? '/images/types/normal.svg';
            $color = $meta['color'] ?? '#888888';
        @endphp
        @if (!empty($iconOnly))
            <span class="type-icon-chip" title="{{ $label }}" aria-label="{{ $label }}">
                <img src="{{ asset($icon) }}" alt="{{ $label }}" width="28" height="28" loading="lazy">
            </span>
        @else
            <span class="type-badge {{ isset($variant) ? 'type-badge--'.$variant : '' }}" style="--tc: {{ $color }}">
                <img src="{{ asset($icon) }}" alt="" class="type-badge__icon" width="20" height="20" loading="lazy">
                <span>{{ $label }}</span>
            </span>
        @endif
    @endforeach
</span>
