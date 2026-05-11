@props(['id', 'icon'])

<button id="{{ $id }}" type="button" {{ $attributes->except(['id', 'icon']) }} class="btn btn-purple btn-icon">
    <img class="img-fluid img-icon" src="{{ $icon }}">
</button>