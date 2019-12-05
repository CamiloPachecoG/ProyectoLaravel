<div class="card pub_image">
        <div class="card-header">

            @if($image->user->image)
            <div class="container-avatar">
                <img src="{{ route('user.avatar', ['filename'=>$image->user->image]) }}" class="avatar">
            </div>
            @endif
            
            <div class="data-user">
                <a href=" {{ route('profile', ['id' => $image->user->id]) }} ">
                    {{ $image->user->nick }}
                </a>
            </div>
            
        </div>

        <div class="card-body">
            <div class="image-container">
                <img src="{{ route('image.file', ['filename'=>$image->image_path]) }}"/>
            </div>

            <div class="likes">
                <?php $user_like = false; ?>
                @foreach($image->likes as $like)
                    @if($like->user->id == Auth::user()->id)
                        <?php $user_like = true; ?>
                    @endif
                @endforeach

                @if($user_like)
                    <img src="{{ asset('img/heart-red.png')}}" data-id="{{$image->id}}" class="btn-dislike">
                @else
                    <img src="{{ asset('img/heart-black.png')}}" data-id="{{$image->id}}" class="btn-like">
                @endif
                    <a href="{{ route('image.detail', ['id' => $image->id]) }}"><img src="{{ asset('img/comment.png') }}" class="comentario"></a>
                <br>
                <strong>{{ count($image->likes).' Me gusta'}}</strong>
            </div>
            
            <div class="description">
                <strong>{{  $image->user->nick.' ' }}</strong>{{  $image->description }}
            </div>
                @if(count($image->comments) > 1)
                    <a href="{{ route('image.detail', ['id' => $image->id]) }}" class="btn-comments"> Ver los {{ count($image->comments) }} Comentarios</a>
                    <br>
                @elseif(count($image->comments) == 1)
                    <a href="{{ route('image.detail', ['id' => $image->id]) }}" class="btn-comments"> Ver Comentario</a>
                    <br>
                @endif
                <span class="date"> {{ \FormatTime::LongTimeFilter($image->created_at) }}</span>
        </div>
    </div>