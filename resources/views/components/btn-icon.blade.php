@props(['id', 'icon'])

{{-- type="button" es el default pero puede sobreescribirse con type="submit" --}}
<button id="{{ $id }}" {{ $attributes->merge(['type' => 'button'])->except(['id', 'icon']) }} class="btn btn-purple btn-icon">
    <img class="img-fluid img-icon" src="{{ $icon }}">
</button>