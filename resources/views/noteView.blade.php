@extends('layouts.main')
 
@section('title', 'Project Notes - Note View')
 
@section('cssLinks')
    <link rel="stylesheet" href="{{url('css/styles.css')}}">
    <link rel="stylesheet" href="{{url('css/dropdown.css')}}">
    <link rel="stylesheet" href="{{url('css/cards.css')}}">
    <link rel="stylesheet" href="{{url('css/modal.css')}}">
@endsection
 
@section('content')
    <a href="/note/{{ $note->id }}/edit">edit note</a>
    @if($note->creator_id == Auth::id())
        <a href="/note/{{ $note->id }}/delete">delete note</a>
        <a href="#friend-modal">add friend</a>
    @endif
    <div class="card" style="
    margin: 0 15px;
    background: repeating-linear-gradient(#0000 0 calc(1.2rem - 1px),{{ $note->line_color }} 0 1.2rem) 
    right bottom /100% 100%,linear-gradient({{ $note->note_color }} 0 0) 30px 0/2px 100% {{ $note->note_color }}">
    @if ($note->image)
        <div class="card_image_single"><img src="{{ url($note->image) }}"></div>
    @endif
    <div class="card_content">
        <h2 class="card_title" style="color: {{ $note->text_color }}">{{ $note->title }}</h2>
        {!! $note->content !!}
    </div>
    </div>
    @if($note->creator_id == Auth::id())
        <div id="friend-modal" class="modal">
            <div class="modal__content">
                <form action="/note/{{ $note->id }}/add-friend" method="post">
                    @csrf
                    <h2>Выбери друга</h2>
                    @foreach ($friends as $friend)
                        <input type="checkbox" 
                        id="friend-{{ $friend->id }}" 
                        name="friends[]" 
                        value="{{ $friend->id }}"
                        @if (in_array($friend->id, $friendIds))
                            checked
                        @endif
                        >
                        <label for="friend-{{ $friend->id }}">{{ $friend->name }} - <i>{{ $friend->email }}</i></label><br>
                    @endforeach
                    <br>
                    <button type="submit">Выбрать</button>
                </form>
                <a href="#" class="modal__close">&times;</a>
            </div>
        </div>
    @endif
@endsection