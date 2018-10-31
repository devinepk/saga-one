@extends('layout.journal')

@section('additional_link_tags')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('page-title', 'Edit Entry')

@section('journal-content')
<entry-header>
    {{ $entry['title'] }}
</entry-header>

<button class="float-right btn btn-primary btn-save">Save</button>
<div id="toolbar" class="ql-toolbar ql-snow">
    <span class="ql-formats">
        <button class="ql-bold" type="button"></button>
        <button class="ql-italic" type="button"></button>
        <button class="ql-underline" type="button"></button>
        <button class="ql-strike" type="button"></button>
    </span>

    <span class="ql-formats">
        <span class="ql-color ql-picker ql-color-picker">
            <span class="ql-picker-label" tabindex="0" role="button" aria-expanded="false" aria-controls="ql-picker-options-2"></span>

            <span class="ql-picker-options" aria-hidden="true" tabindex="-1" id="ql-picker-options-2">
                <span tabindex="0" role="button" class="ql-picker-item ql-selected ql-primary"></span>
                <span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#e60000" style="background-color: rgb(230, 0, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#ff9900" style="background-color: rgb(255, 153, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#ffff00" style="background-color: rgb(255, 255, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#008a00" style="background-color: rgb(0, 138, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#0066cc" style="background-color: rgb(0, 102, 204);"></span>
                <span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#9933ff" style="background-color: rgb(153, 51, 255);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#ffffff" style="background-color: rgb(255, 255, 255);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#facccc" style="background-color: rgb(250, 204, 204);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#ffebcc" style="background-color: rgb(255, 235, 204);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#ffffcc" style="background-color: rgb(255, 255, 204);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#cce8cc" style="background-color: rgb(204, 232, 204);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#cce0f5" style="background-color: rgb(204, 224, 245);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#ebd6ff" style="background-color: rgb(235, 214, 255);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#bbbbbb" style="background-color: rgb(187, 187, 187);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#f06666" style="background-color: rgb(240, 102, 102);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#ffc266" style="background-color: rgb(255, 194, 102);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#ffff66" style="background-color: rgb(255, 255, 102);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#66b966" style="background-color: rgb(102, 185, 102);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#66a3e0" style="background-color: rgb(102, 163, 224);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#c285ff" style="background-color: rgb(194, 133, 255);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#888888" style="background-color: rgb(136, 136, 136);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#a10000" style="background-color: rgb(161, 0, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#b26b00" style="background-color: rgb(178, 107, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#b2b200" style="background-color: rgb(178, 178, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#006100" style="background-color: rgb(0, 97, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#0047b2" style="background-color: rgb(0, 71, 178);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#6b24b2" style="background-color: rgb(107, 36, 178);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#444444" style="background-color: rgb(68, 68, 68);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#5c0000" style="background-color: rgb(92, 0, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#663d00" style="background-color: rgb(102, 61, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#666600" style="background-color: rgb(102, 102, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#003700" style="background-color: rgb(0, 55, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#002966" style="background-color: rgb(0, 41, 102);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#3d1466" style="background-color: rgb(61, 20, 102);"></span>
            </span>
        </span>

        <select class="ql-color" style="display: none;">
            <option selected="selected"></option>
            <option value="#e60000"></option>
            <option value="#ff9900"></option>
            <option value="#ffff00"></option>
            <option value="#008a00"></option>
            <option value="#0066cc"></option>
            <option value="#9933ff"></option>
            <option value="#ffffff"></option>
            <option value="#facccc"></option>
            <option value="#ffebcc"></option>
            <option value="#ffffcc"></option>
            <option value="#cce8cc"></option>
            <option value="#cce0f5"></option>
            <option value="#ebd6ff"></option>
            <option value="#bbbbbb"></option>
            <option value="#f06666"></option>
            <option value="#ffc266"></option>
            <option value="#ffff66"></option>
            <option value="#66b966"></option>
            <option value="#66a3e0"></option>
            <option value="#c285ff"></option>
            <option value="#888888"></option>
            <option value="#a10000"></option>
            <option value="#b26b00"></option>
            <option value="#b2b200"></option>
            <option value="#006100"></option>
            <option value="#0047b2"></option>
            <option value="#6b24b2"></option>
            <option value="#444444"></option>
            <option value="#5c0000"></option>
            <option value="#663d00"></option>
            <option value="#666600"></option>
            <option value="#003700"></option>
            <option value="#002966"></option>
            <option value="#3d1466"></option>
        </select>

        <span class="ql-background ql-picker ql-color-picker">
            <span class="ql-picker-label" tabindex="0" role="button" aria-expanded="false" aria-controls="ql-picker-options-3"></span>
            <span class="ql-picker-options" aria-hidden="true" tabindex="-1" id="ql-picker-options-3">
                <span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#000000" style="background-color: rgb(0, 0, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#e60000" style="background-color: rgb(230, 0, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#ff9900" style="background-color: rgb(255, 153, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#ffff00" style="background-color: rgb(255, 255, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#008a00" style="background-color: rgb(0, 138, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#0066cc" style="background-color: rgb(0, 102, 204);"></span>
                <span tabindex="0" role="button" class="ql-picker-item ql-primary" data-value="#9933ff" style="background-color: rgb(153, 51, 255);"></span>
                <span tabindex="0" role="button" class="ql-picker-item ql-selected"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#facccc" style="background-color: rgb(250, 204, 204);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#ffebcc" style="background-color: rgb(255, 235, 204);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#ffffcc" style="background-color: rgb(255, 255, 204);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#cce8cc" style="background-color: rgb(204, 232, 204);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#cce0f5" style="background-color: rgb(204, 224, 245);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#ebd6ff" style="background-color: rgb(235, 214, 255);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#bbbbbb" style="background-color: rgb(187, 187, 187);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#f06666" style="background-color: rgb(240, 102, 102);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#ffc266" style="background-color: rgb(255, 194, 102);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#ffff66" style="background-color: rgb(255, 255, 102);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#66b966" style="background-color: rgb(102, 185, 102);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#66a3e0" style="background-color: rgb(102, 163, 224);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#c285ff" style="background-color: rgb(194, 133, 255);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#888888" style="background-color: rgb(136, 136, 136);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#a10000" style="background-color: rgb(161, 0, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#b26b00" style="background-color: rgb(178, 107, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#b2b200" style="background-color: rgb(178, 178, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#006100" style="background-color: rgb(0, 97, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#0047b2" style="background-color: rgb(0, 71, 178);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#6b24b2" style="background-color: rgb(107, 36, 178);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#444444" style="background-color: rgb(68, 68, 68);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#5c0000" style="background-color: rgb(92, 0, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#663d00" style="background-color: rgb(102, 61, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#666600" style="background-color: rgb(102, 102, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#003700" style="background-color: rgb(0, 55, 0);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#002966" style="background-color: rgb(0, 41, 102);"></span>
                <span tabindex="0" role="button" class="ql-picker-item" data-value="#3d1466" style="background-color: rgb(61, 20, 102);"></span>
            </span>
        </span>

        <select class="ql-background" style="display: none;">
            <option value="#000000"></option>
            <option value="#e60000"></option>
            <option value="#ff9900"></option>
            <option value="#ffff00"></option>
            <option value="#008a00"></option>
            <option value="#0066cc"></option>
            <option value="#9933ff"></option>
            <option selected="selected"></option>
            <option value="#facccc"></option>
            <option value="#ffebcc"></option>
            <option value="#ffffcc"></option>
            <option value="#cce8cc"></option>
            <option value="#cce0f5"></option>
            <option value="#ebd6ff"></option>
            <option value="#bbbbbb"></option>
            <option value="#f06666"></option>
            <option value="#ffc266"></option>
            <option value="#ffff66"></option>
            <option value="#66b966"></option>
            <option value="#66a3e0"></option>
            <option value="#c285ff"></option>
            <option value="#888888"></option>
            <option value="#a10000"></option>
            <option value="#b26b00"></option>
            <option value="#b2b200"></option>
            <option value="#006100"></option>
            <option value="#0047b2"></option>
            <option value="#6b24b2"></option>
            <option value="#444444"></option>
            <option value="#5c0000"></option>
            <option value="#663d00"></option>
            <option value="#666600"></option>
            <option value="#003700"></option>
            <option value="#002966"></option>
            <option value="#3d1466"></option>
        </select>
    </span>

    <span class="ql-formats">
        <button class="ql-script" value="sub" type="button"></button>
        <button class="ql-script" value="super" type="button"></button>
        <button class="ql-blockquote" type="button"></button>
    </span>

    <span class="ql-formats">
        <button class="ql-list" value="ordered" type="button"></button>
        <button class="ql-list" value="bullet" type="button"></button>
        <button class="ql-indent" value="-1" type="button"></button>
        <button class="ql-indent" value="+1" type="button"></button>
    </span>

    <span class="ql-formats">
        <span class="ql-align ql-picker ql-icon-picker">
            <span class="ql-picker-label" tabindex="0" role="button" aria-expanded="false" aria-controls="ql-picker-options-4"></span>
        </span>
    </span>

    <select class="ql-align" style="display: none;">
        <option selected="selected"></option>
        <option value="center"></option>
        <option value="right"></option>
        <option value="justify"></option>
    </select>

    <span class="ql-formats">
        <button class="ql-link" type="button"></button>
        <button class="ql-image" type="button"></button>
    </span>

    <span class="ql-formats">
        <button class="ql-clean" type="button"></button>
    </span>

</div>

{{-- FIRST TRY, HAS TOOLTIPS --}}
<div id="toolbar" class="ql-toolbar" style="display:none;">
    <select class="ql-size ql-formats" data-toggle="tooltip" data-placement="top" title="Font size">
        <option value="small"></option>

        <option selected></option>

        <option value="large"></option>

        <option value="huge"></option>

    </select>
    <span class="ql-formats">
        <button class="ql-bold" data-toggle="tooltip" data-placement="bottom" title="Bold"></button>
        <button class="ql-italic" data-toggle="tooltip" data-placement="bottom" title="Italic"></button>
        <button class="ql-underline" data-toggle="tooltip" data-placement="bottom" title="Underline"></button>
        <button class="ql-strike" data-toggle="tooltip" data-placement="bottom" title="Strikethrough"></button>
    </span>

    <span class="ql-formats">
        <button class="ql-color" data-toggle="tooltip" data-placement="bottom" title="Text color"></button>
        <button class="ql-background" data-toggle="tooltip" data-placement="bottom" title="Background color"></button>
    </span>

    <span class="ql-formats">
        <button class="ql-script" value="sub" data-toggle="tooltip" data-placement="bottom" title="Superscript"></button>
        <button class="ql-script" value="super" data-toggle="tooltip" data-placement="bottom" title="Subscript"></button>
    </span>

    <span class="ql-formats">
        <button class="ql-blockquote" data-toggle="tooltip" data-placement="bottom" title="Blockquote"></button>
        <button class="ql-indent" data-toggle="tooltip" data-placement="bottom" title="Increase indent"></button>
    </span>

    <span class="ql-formats">
        <button class="ql-list" data-toggle="tooltip" data-placement="bottom" title="List"></button>
    </span>



</div>

<div id="editor" class="p-2">
    {!! $entry['body'] !!}
</div>
@endsection

@section('bottom_of_body')
<!-- Link to Quill library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<!-- Initialize Quill -->
<script>
var quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: "#toolbar"
    }
});
// Enable all tooltips
$('[data-toggle="tooltip"]').tooltip();
</script>
@endsection
