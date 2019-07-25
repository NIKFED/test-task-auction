@extends('layouts.app')

@section('content')
    <main role="main">
        <view-component :picture="{{json_encode($picture_data)}}"></view-component>

        <footer class="text-muted">
            <div class="container">
                <p class="float-right">
                    <a href="#">Back to top</a>
                </p>
            </div>
        </footer>
    </main>
@endsection