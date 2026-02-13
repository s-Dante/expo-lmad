@props(['id', 'name', 'value', 'label'])

<input type="checkbox" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}" {{ $attributes }}>
<label for="{{ $id }}" class="unselectable quit-highlight">{{ $label }}</label>