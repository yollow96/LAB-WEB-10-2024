@extends('layouts.master')

@section('content')
<x-message :title="$messageTitle" :message="$messageContent" />
<div class="hero">
    <div class="hero-text">
        <h1>Hey This Our Website</h1>
        <p class="subtitle">This Our Website</p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde praesentium soluta adipisci possimus repellendus
            vitae quis fuga ratione dolorumque excepturi?</p>
    </div>
    <div class="hero-image">
        <img src="https://picsum.photos/500/300" alt="foto">
    </div>
</div>
@endsection