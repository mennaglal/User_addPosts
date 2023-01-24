@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                    <button type="button" class="btn btn-dark" style="margin:40px;padding:15px;"><a href={{('posts')}} style="text-decoration:none;">Go to Posts Page</a></button>
            </div>
        </div>
    </div>
</div>
@endsection
