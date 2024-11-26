@extends('layouts.main')
 
@section('title', 'Project Notes - New Note')
 
@section('cssLinks')
    <link rel="stylesheet" href="{{url('css/styles.css')}}">
    <link rel="stylesheet" href="{{url('css/dropdown.css')}}">
    <link rel="stylesheet" href="{{url('css/cards.css')}}">
    <link rel="stylesheet" href="{{url('css/modal.css')}}">
    <link rel="stylesheet" href="{{url('css/edit.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css"/> <!-- 'nano' theme -->
@endsection
 
@section('content')
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <a href="#color-modal">Настройки цвета</a>
    <form action="/note/submit" method="post" enctype="multipart/form-data" id="noteForm">
        @csrf
        <div class="card"
            style="background: repeating-linear-gradient(#0000 0 calc(1.2rem - 1px),{{ $line_color }} 0 1.2rem) 
            right bottom /100% 100%,linear-gradient({{ $note_color }} 0 0) 30px 0/2px 100% {{ $note_color }}"
            >
            <input type="file" name="image">
            <div class="card_content">
                <input class="inputTitle" type="text" name="title" placeholder="Note Name" style="
                    background: {{ $note_color }};
                    color: {{ $text_color }}
                    ">
                <input type="hidden" name="content">
                <div id="editor">
                    <p>Start type here</p>
                </div>
                <button type="submit">Create Note</button>
            </div>
        </div>
    </form>

    <div id="color-modal" class="modal">
        <div class="modal__content">
            <form action="/note/color/create" method="post" id="colorForm">
                @csrf
                <h2>Цвет заметки</h2>
                <label>Заметка</label><input type="text" name="note_color" class="color-picker1"></input><br>    
                <label>Заголовок</label><input type="text" name="text_color" class="color-picker2"></input><br>
                <label>Сторка</label><input type="text" name="line_color" class="color-picker3"></input><br>
                <button type="submit">Применить</button>
            </form>
            <a href="#" class="modal__close">&times;</a>
        </div>
    </div>
@endsection

@section('jsScripts')
    <!-- Include the Quill library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <!-- color picker link -->
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
    <!-- Initialize Quill editor -->
    <script>
        const toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
            ['blockquote', 'code-block'],
            ['link', 'image', 'video', 'formula'],

            [{ 'header': 1 }, { 'header': 2 }],               // custom button values
            [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
            [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
            [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
            [{ 'direction': 'rtl' }],                         // text direction

            [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

            [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
            [{ 'font': [] }],
            [{ 'align': [] }],

            ['clean']                                         // remove formatting button
        ];

        const quill = new Quill('#editor', {
        modules: {
            toolbar: toolbarOptions
        },
        theme: 'snow'
        });

        var form = document.getElementById('noteForm');
        form.onsubmit = function () {
            // Populate hidden form on submit
            var content = document.querySelector('input[name=content]');
            content.value = quill.root.innerHTML;
        }
    </script>   
    <!-- color picker elements -->
    <script>
        let colorPicker1 = document.querySelector('.color-picker1');
        const color1 = Pickr.create({
            el: colorPicker1,
            useAsButton: true,
            theme: 'classic',
            closeWithKey: 'Escape',
            default: '{{ $note_color }}',
            swatches: [
                'rgba(244, 67, 54, 1)',
                'rgba(233, 30, 99, 0.95)',
                'rgba(156, 39, 176, 0.9)',
                'rgba(103, 58, 183, 0.85)',
                'rgba(63, 81, 181, 0.8)',
                'rgba(33, 150, 243, 0.75)',
                'rgba(3, 169, 244, 0.7)',
                'rgba(0, 188, 212, 0.7)',
                'rgba(0, 150, 136, 0.75)',
                'rgba(76, 175, 80, 0.8)',
                'rgba(139, 195, 74, 0.85)',
                'rgba(205, 220, 57, 0.9)',
                'rgba(255, 235, 59, 0.95)',
                'rgba(255, 193, 7, 1)'
            ],

            components: {

                // Main components
                preview: true,
                opacity: true,
                hue: true,
                

                // Input / output Options
                interaction: {
                    hex: true,
                    rgba: true,
                    hsla: true,
                    hsva: true,
                    cmyk: true,
                    input: true,
                    clear: true,
                    save: true
                }
            }
        }).on('init', pickr => {
            colorPicker1.value = pickr.getSelectedColor().toHEXA().toString(0);
        }).on('save', color => {
            colorPicker1.value = color.toHEXA().toString(0);
            pickr.hide();
        });
        let colorPicker2 = document.querySelector('.color-picker2');
        const color2 = Pickr.create({
            el: colorPicker2,
            useAsButton: true,
            theme: 'classic',
            default: '{{ $text_color }}',
            closeWithKey: 'Escape',
            swatches: [
                'rgba(244, 67, 54, 1)',
                'rgba(233, 30, 99, 0.95)',
                'rgba(156, 39, 176, 0.9)',
                'rgba(103, 58, 183, 0.85)',
                'rgba(63, 81, 181, 0.8)',
                'rgba(33, 150, 243, 0.75)',
                'rgba(3, 169, 244, 0.7)',
                'rgba(0, 188, 212, 0.7)',
                'rgba(0, 150, 136, 0.75)',
                'rgba(76, 175, 80, 0.8)',
                'rgba(139, 195, 74, 0.85)',
                'rgba(205, 220, 57, 0.9)',
                'rgba(255, 235, 59, 0.95)',
                'rgba(255, 193, 7, 1)'
            ],

            components: {

                // Main components
                preview: true,
                opacity: true,
                hue: true,
                

                // Input / output Options
                interaction: {
                    hex: true,
                    rgba: true,
                    hsla: true,
                    hsva: true,
                    cmyk: true,
                    input: true,
                    clear: true,
                    save: true
                }
            }
        }).on('init', pickr => {
            colorPicker2.value = pickr.getSelectedColor().toHEXA().toString(0);
        }).on('save', color => {
            colorPicker2.value = color.toHEXA().toString(0);
            pickr.hide();
        });
        let colorPicker3 = document.querySelector('.color-picker3');
        const color3 = Pickr.create({
            el: colorPicker3,
            useAsButton: true,
            theme: 'classic',
            default: '{{ $line_color }}',
            closeWithKey: 'Escape',
            swatches: [
                'rgba(244, 67, 54, 1)',
                'rgba(233, 30, 99, 0.95)',
                'rgba(156, 39, 176, 0.9)',
                'rgba(103, 58, 183, 0.85)',
                'rgba(63, 81, 181, 0.8)',
                'rgba(33, 150, 243, 0.75)',
                'rgba(3, 169, 244, 0.7)',
                'rgba(0, 188, 212, 0.7)',
                'rgba(0, 150, 136, 0.75)',
                'rgba(76, 175, 80, 0.8)',
                'rgba(139, 195, 74, 0.85)',
                'rgba(205, 220, 57, 0.9)',
                'rgba(255, 235, 59, 0.95)',
                'rgba(255, 193, 7, 1)'
            ],

            components: {

                // Main components
                preview: true,
                opacity: true,
                hue: true,
                

                // Input / output Options
                interaction: {
                    hex: true,
                    rgba: true,
                    hsla: true,
                    hsva: true,
                    cmyk: true,
                    input: true,
                    clear: true,
                    save: true
                }
            }
        }).on('init', pickr => {
            colorPicker3.value = pickr.getSelectedColor().toHEXA().toString(0);
        }).on('save', color => {
            colorPicker3.value = color.toHEXA().toString(0);
            pickr.hide();
        });
    </script>
@endsection