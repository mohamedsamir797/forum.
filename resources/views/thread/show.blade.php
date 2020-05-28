@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-8">
                    <div class="card">
                            <div class="card-header level">
                                <span class="flex">
                            <a href="/profiles/{{ $thread->creator->name }}">{{ $thread->creator->name }}</a>
                            {{ $thread->title }}
                                </span>
                                @can('update',$thread)
                           <span>
                               <form action="{{ $thread->path() }}" method="post">
                                   @csrf
                                   @method('DELETE')
                                   <button type="submit" class="btn btn-default">Delete</button>
                               </form>
                           </span>
                                    @endcan
                            </div>

                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>
                    <br>

                @foreach( $replies as $reply)
                    @include('thread.reply')
                    @endforeach

                {{ $replies->links() }}

            @if(auth()->check())
               <form action="{{ $thread->path().'/replies' }}" method="post">
                   @csrf
                   <div class="form-group">
                       <textarea class="form-control" name="body" rows="3" placeholder="have something to say ? "></textarea>
                   </div>
                   <button type="submit" class="btn btn-default" >Submit</button>
               </form>
                @else
                    <div class="col-md-8 text-center">
                         <p>if you need to participate in this discussion please <a href="{{ route('login') }}"> sign in </a> </p>
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>this thread was published {{ $thread->created_at->diffForHumans() }}
                        by <a href="/profiles/{{ $thread->creator->name }}">{{ $thread->creator->name }}</a> and currently has
                            {{ $thread->replies_count }} {{ str_plural('comment',$thread->replies_count) }}
                        </p>

                             @if($thread->isSuscribed())
                                 <form action="/threads/{{ $thread->channel_id }}/{{ $thread->id }}/subscriptions/delete" method="post">
                                      @csrf
                                     @method('DELETE')
                                     <button type="submit" class="btn btn-danger">un subscribe</button>

                                 </form>
                              @else

                            <form action="/threads/{{ $thread->channel_id }}/{{ $thread->id }}/subscriptions" method="post">
                                @csrf
                                 <button type="submit" class="btn btn-primary">Subscribe</button>
                             </form>

                             @endif

                    </div>
                </div>
                <br>
            </div>
        </div>

    </div>
@endsection
