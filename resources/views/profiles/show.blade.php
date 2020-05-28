@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="modal-header">
                    <h1 class="display-4">
                        {{ $profileUser->name }}
                    </h1>
                </div>
                <h4 class="ml-3">since {{ $profileUser->created_at->diffForHumans() }}</h4>
                 <br>
            @foreach( $activities as $date => $activity)
                    <h3 class="modal-header">{{ $date }}</h3>

                    @foreach( $activity as $record )
                    <div class="card">
                        <div class="card-header">

                            @if( $record->type == 'created_thread')
                                {{ $profileUser->name }} Published a<a class="ml-2" href="{{ $record->subject->path() }}">{{ $record->subject->title }} </a>
                            @endif

                            @if( $record->type == 'created_reply')
                                {{ $profileUser->name }} replied to <a class="ml-2" href="{{ $record->subject->thread->path() }}">{{ $record->subject->thread->title }} </a>
                            @endif

{{--                                @if( $record->type == 'created_Favorite')--}}
{{--                                   <a href="{{ $record->subject->favorited->path() }}"> {{ $profileUser->name }} Favorited a Reply </a>--}}
{{--                                @endif--}}

                        </div>

                        <div class="card-body">
                            @if( $record->type == 'created_thread')
                                {{ $record->subject->body }}
                            @endif
                                @if( $record->type == 'created_reply')
                                    {{ $record->subject->body }}
                                @endif

{{--                                @if( $record->type == 'created_Favorite')--}}
{{--                                    @if($record->subject->favorited->id)--}}
{{--                                    {{ $record->subject->favorited->body }}--}}
{{--                                        @endif--}}
{{--                                @endif--}}
                        </div>

                    </div>
                        <br>

                    @endforeach


                @endforeach
                {{--        {{ $threads->links() }}--}}
            </div>
        </div>
    </div>
@endsection