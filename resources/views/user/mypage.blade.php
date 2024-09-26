
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('My Page') }}</div>

                <div class="card-body">
                    {{ __('Welcome to your personal page, ') . Auth::user()->name . '!' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection