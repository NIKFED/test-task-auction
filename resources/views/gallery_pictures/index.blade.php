@extends('layouts.app')

@section('content')
    <main role="main">
        <div class="album py-5 bg-light">
            <picture-component :user_id="{{ json_encode(Auth::user()->id) }}"></picture-component>
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