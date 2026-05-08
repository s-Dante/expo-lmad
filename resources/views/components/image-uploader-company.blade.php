@props([
    'src'       => asset('assets/guest/imageloading_small.png'),
    'imgId'     => 'company-portrait',
    'inputId'   => 'file-upload',
    'inputName' => 'logo',
    'btnId'     => 'upload-photo',
])

<container class="container-sponsor-logo">
    <div class="blum">
        <div class="star">
            <img id="{{ $imgId }}" src="{{ $src }}" class="img-fluid sponsor" />
        </div>
    </div>
</container>

<input type="file" id="{{ $inputId }}" name="{{ $inputName }}" accept="image/*" style="display: none;"
       data-preview="{{ $imgId }}">
<x-btn-icon id="{{ $btnId }}" icon="{{ asset('assets/guest/upload.png') }}"
    data-target="{{ $inputId }}" onclick="triggerUpload(this)" />