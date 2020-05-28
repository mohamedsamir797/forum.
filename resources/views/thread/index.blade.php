@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @forelse($threads as $thread)
                <div class="card">
                    <div class="card-body">
                        <div class="level">
                            <h4 class="flex"><a href="{{ $thread->path() }}">{{ $thread->title }}</a></h4>
                            <strong><a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ str_plural('reply',$thread->replies_count) }}</a></strong><br>
                        </div>
                        {{ $thread->body }}
                    </div>
                </div>
                    <br>
                    @empty
                    <p>There are no relevant threads at this time</p>
                    @endforelse
            </div>
        </div>
    </div>
@endsection
