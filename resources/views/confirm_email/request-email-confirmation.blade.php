@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <p class="lead">{{$user->name}} get confirmation email link</p>
            <form action="{{ route('send-confirmation-email', $user) }}" method="post">
                {{csrf_field()}}
                <input type="hidden" value="{{ $user->email }}" name="email">
                <input type="submit" class="btn btn-secondary" value="Send">
            </form>
        </div>
    </div>

@endsection