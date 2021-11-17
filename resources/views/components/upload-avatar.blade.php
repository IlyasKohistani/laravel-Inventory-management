<div class="avatar-upload @if(isset($parent_class)){{ $parent_class }} @endif">
    <div class="avatar-edit">
        <input type='file' id="imageUpload" name="image" accept="image/*" />
        <label for="imageUpload"><i id="imageUploadPen" class="bi bi-pencil-fill"></i></label>
    </div>
    <div class="avatar-preview">
        <div id="imagePreview" style="background-image: url({{ isset($background_url) ? $background_url : asset('images/bg/no-pictures.png') }});">
        </div>
    </div>
</div>
