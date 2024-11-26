@extends('layouts.main')
 
@section('title', 'Project Notes')
 
@section('cssLinks')
    <link rel="stylesheet" href="{{url('css/styles.css')}}">
    <link rel="stylesheet" href="{{url('css/dropdown.css')}}">
    <link rel="stylesheet" href="{{url('css/cards.css')}}">
    <link rel="stylesheet" href="{{url('css/modal.css')}}">

@endsection
 
@section('content')
    <ul class="cards">
        @foreach ($createdNotes as $note)
            <a href="/note/{{ $note->id }}">
                <li class="cards_item">
                    <div class="card" style="
                    background: repeating-linear-gradient(#0000 0 calc(1.2rem - 1px),{{ $note->line_color }} 0 1.2rem) 
                    right bottom /100% 100%,linear-gradient({{ $note->note_color }} 0 0) 30px 0/2px 100% {{ $note->note_color }}">
                    @if ($note->image)
                        <div class="card_image"><img src="{{ url($note->image) }}"></div>
                    @endif
                    <div class="card_content">
                        <h2 class="card_title" style="color: {{ $note->text_color }}">{{ $note->title }}</h2>
                    </div>
                    </div>
                </li>
            </a>
        @endforeach
        @foreach ($guestNotes as $note)
            <a href="/note/{{ $note->id }}">
                <li class="cards_item">
                    <div class="card" style="
                    background: repeating-linear-gradient(#0000 0 calc(1.2rem - 1px),{{ $note->line_color }} 0 1.2rem) 
                    right bottom /100% 100%,linear-gradient({{ $note->note_color }} 0 0) 30px 0/2px 100% {{ $note->note_color }}">
                    @if ($note->image)
                        <div class="card_image"><img src="{{ url($note->image) }}"></div>
                    @endif
                    <div class="card_content">
                        <h2 class="card_title" style="color: {{ $note->text_color }}">{{ $note->title }}</h2>
                    </div>
                    </div>
                </li>
            </a>
        @endforeach
    </ul>
@endsection