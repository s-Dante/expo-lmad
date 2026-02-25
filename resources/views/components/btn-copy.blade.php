@props(['target', 'icon' => 'assets/teacher/CopiarVector.png'])

<button type="button" {{ $attributes->merge(['class' => 'btn btn-purple btn-icon state-saved']) }}
    data-target="{{ $target }}">
    <img src="{{ asset($icon) }}" draggable="false" alt="Copiar">
</button>