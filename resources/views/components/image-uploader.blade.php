@props([
    'src' => asset('assets/guest/imageloading.png'),
    'imgId' => 'project-portrait',
    'inputId' => 'file-upload',
    'inputName' => 'poster',
    'btnId' => 'upload-photo',
])

<img id="{{ $imgId }}" src="{{ $src }}" {{ $attributes->merge(['class' => 'img-fluid project-card']) }} />
<input type="file" id="{{ $inputId }}" name="{{ $inputName }}" accept="image/*" style="display: none;">
<x-btn-icon id="{{ $btnId }}" icon="{{ asset('assets/guest/upload.png') }}" />