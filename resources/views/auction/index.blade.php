@extends('layouts.app')

@section('content')
    <main role="main">
        <div class="album py-5 bg-light">
            <auction-component :user_id="{{json_encode(Auth::user()->id)}}"></auction-component>
            <chat-component :user_id="{{json_encode(Auth::user()->id)}}"></chat-component>
        </div>

        <footer class="text-muted">
            <div class="container">
                <p class="float-right">
                    <a href="#">Back to top</a>
                </p>
            </div>
        </footer>
    </main>
@endsection
