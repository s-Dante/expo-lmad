@props([
    'src' => asset('assets/guest/imageloading_small.png'),
    'imgId' => 'project-portrait',
    'inputId' => 'file-upload',
    'inputName' => 'poster',
    'btnId' => 'upload-photo',
])
     
     
<container class="container-sponsor-logo">
    <img id="{{ $imgId }}" src="{{ $src }}" class="img-fluid sponsor" />
</container>

<input type="file" id="{{ $inputId }}" name="{{ $inputName }}" accept="image/*" style="display: none;">
<x-btn-icon id="{{ $btnId }}" icon="{{ asset('assets/guest/upload.png') }}" />