@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-white mb-3">
                <div class="card-body">
                    <h6 class="card-title">
                        {{ $tweet->user->display_name }}
                        <span class="text-muted">{{ '@' }}{{ $tweet->user->user_name }}</span>
                        <span class="text-muted">{{ '・' }}{{ $tweet->created_at->format('h:i A · M d, Y') }}</span>
                    </h6>
                    <p class="card-text">
                        {{ $tweet->body }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
