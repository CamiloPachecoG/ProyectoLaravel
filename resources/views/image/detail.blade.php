@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card-body">
                <div class="image-container">
                    <img src="{{ route('image.file', ['filename'=>$image->image_path]) }}"/>
                </div>
            </div>
        </div>

        <div class="col-md-5">
        @include('includes.message')

            <div class="card pub_image pub_image_detail">
                <div class="card-header">

                    @if($image->user->image)
                    <div class="container-avatar">
                        <img src="{{ route('user.avatar', ['filename'=>$image->user->image]) }}" class="avatar">
                    </div>
                    @endif
                    
                    <div class="data-user">
                        {{ $image->user->nick }}
                    </div>

                    @if(Auth::user() && Auth::user()->id == $image->user->id)
                    <div class="actions"> 
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href=" {{ route('image.edit', ['id' => $image->id]) }} ">
                                Editar
                            </a>

                            <a class="dropdown-item" href=" {{ route('image.delete', ['id' => $image->id]) }} ">
                                Eliminar 
                            </a>
                        </div>   
                    </div>
                    @endif  
                </div>

                <div class="card-body">

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
                        <br>
                        <strong>{{ count($image->likes).' Me gusta'}}</strong>
                    </div>
                    
                    <div class="description">
                        <span class="nickname">{{  $image->user->nick }} </span>
                        <p>{{  $image->description }}</p>
                    </div>

                    <div class="clearfix"></div>
                    <div class="comments">
                    

                         <h3>{{ count($image->comments) }} Comentarios</h2>
                        <br>
                        
                        @foreach($image->comments as $comment)
                            <div class="comment">
                                <span class="nickname">{{  $comment->user->nick }} </span>
                                <p>{{  $comment->content }}
                                @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                    <a href="{{ route('comment.delete', ['id' => $comment->id]) }}" class="btn btn-sm">x</a>
                                @endif
                                </p>    
                            </div>
                        @endforeach

                        <span class="date"> {{ \FormatTime::LongTimeFilter($image->created_at) }}</span>
                        <hr>

                        <form method="POST" action="{{ route('comment.save') }}">
                            @csrf

                            <input type="hidden" name="imagen_id" value=" {{$image->id}} ">
                            <p>
                                <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content"></textarea>
                                @if($errors->has('content'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                @endif
                            </p>
                            <input type="submit" class="btn btn-primary" value="Enviar">
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
