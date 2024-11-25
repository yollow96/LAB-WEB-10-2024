@extends('layouts.master')

@section('content')
    <x-message :title="$messageTitle" :message="$messageContent" />
    <div class="mt-4">
        <h2>Get in Touch</h2>
        <p>Have questions? We'd love to hear from you.</p>
        <p>Email us at: contact@example.com</p>
    </div>
@endsection