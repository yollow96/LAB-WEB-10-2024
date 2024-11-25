@extends('layouts.master')

@section('content')
    <x-message :title="$messageTitle" :message="$messageContent" />
    <div class="mt-4">
        <h2>Our Story</h2>
        <p>We are a passionate team dedicated to creating amazing web experiences.</p>
        <p>Our mission is to provide the best services to our clients.</p>
    </div>
@endsection