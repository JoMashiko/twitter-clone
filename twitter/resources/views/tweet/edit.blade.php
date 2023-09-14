@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('編集') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tweet.update', $tweet) }}">

                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <textarea class="form-control @error('body') is-invalid @enderror" id="body" rows="3" type="text" name='body' value="{{ old('body') ?? $tweet->body }}" required autofocus></textarea>
                            
                            @error('body')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                             @enderror
                        </div>

                        <div class="d-grid justify-content-md-end">
                            <button class="btn btn-primary" type="submit">{{ __('保存') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
