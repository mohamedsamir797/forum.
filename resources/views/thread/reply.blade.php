<reply :attributes="{{ $reply }}" inline-template v-cloak>
<div>
    <div id="reply-{{ $reply->id }}" class="card ">

        <div class="card-header level">
            <h5 class="flex">
                <a href="/profiles/{{ $reply->owner->name }}">{{ $reply->owner->name }}</a>
                said : {{ $reply->created_at->diffForHumans() }}
            </h5>

            <div>
                @if( !$reply->isFavotited() )
                <form action="/replies/{{$reply->id}}/favorites" method="post">
                    @csrf
                    <button type="submit" class="btn btn-default">
                        <i style="font-size: 20px;"  @if($reply->isFavotited())class="fas fa-heart text-danger" @else class="fas fa-heart" @endif ></i> {{ $reply->favorites->count() }}
                    </button>
                </form>
                @else
                <form action="/replies/{{$reply->id}}/favorites" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-default" >
                        <i style="font-size: 20px;" @if($reply->isFavotited())class="fas fa-heart text-danger" @else class="fas fa-heart" @endif ></i> {{ $reply->favorites->count() }}
                    </button>
                </form>
                    @endif
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-sm btn-primary" @click="update" >Update</button>
                <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>

            </div>
            <div v-else v-text="body">
            </div>
        </div>

        @can('update',$reply)
            <div class="card-footer level">
                <button class="btn btn-sm btn-secondary mr-2" @click="editing= true">Edit</button>
                <form action="/replies/{{ $reply->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"> Delete</button>
                </form>
            </div>
        @endcan
    </div>
    <br>
</div>
</reply>
<br>
<br>
