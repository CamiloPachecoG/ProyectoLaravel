<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function save(Request $request){

        //Validacion
        $validate = $this->validate($request, [
            'image_id' => 'integer|required',
            'content' => 'string|required',
        ]);
         
        //Recoger datos
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        //Asigno valor al objeto
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        //Guardar BD
        $comment->save();

        //Redirección
        return redirect()->route('image.detail', ['id' => $image_id])
                         ->with([
                            'message'=> 'Comentario publicado'
                         ]);


    }

    public function delete($id){

        //Conseguir datos del usuario identificado
        $user = \Auth::user();

        //Conseguir objeto del comentario
        $comment = Comment::find($id);

        //Comprobar si soy el dueño del comentario o dueño de la publicación

        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
            $comment->delete();
            //Redirección
            return redirect()->route('image.detail', ['id' => $comment->image->id])
                             ->with([
                                'message'=> 'Comentario eliminado'
                            ]);
        }else{
            //Redirección
            return redirect()->route('image.detail', ['id' => $comment->image->id])
                             ->with([
                                'message'=> 'Comentario no se ha eliminado'
                            ]);
        }

    }
}
