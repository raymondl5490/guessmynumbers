@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="flex flex-row justify-center">
    </div>

    <div id="app">
        <Admin/>
    </div>
</div>
@endsection
