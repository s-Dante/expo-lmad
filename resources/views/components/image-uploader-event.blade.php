@props([
    'src'       => asset('assets/guest/imageloading_small.png'),
    'imgId'     => 'event-portrait',
    'inputId'   => 'event-file-upload',
    'inputName' => 'poster',
    'btnId'     => 'event-upload-photo',
])

<container class="container-sponsor-logo">
    <img id="{{ $imgId }}" src="{{ $src }}" class="img-fluid sponsor" />
</container>

<input type="file" id="{{ $inputId }}" name="{{ $inputName }}" accept="image/*" style="display: none;"
       data-preview="{{ $imgId }}">
<x-btn-icon id="{{ $btnId }}" icon="{{ asset('assets/guest/upload.png') }}"
    data-target="{{ $inputId }}" onclick="triggerUpload(this)" />