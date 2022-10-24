<?php

namespace App\Http\Controllers;

use App\PhotoComments;
use Illuminate\Http\Request;
use Auth;

class PhotoCommentsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($photo_uid, $user_id)
    {
        $body = "";

        $template = '
            <div class="comment">
                <a class="by" href="%s">%s</a>
                <span>
                    %s
                </span>
            </div>
        ';


        $comments = PhotoComments::with(["by_user","owner_user"])->where("photo_uid", $photo_uid)->orderBy('created_at', 'desc')->get();

        if(count($comments) == 0){
            $body = "<div class='empty'> Não há comentários ainda</div>";
        }

        foreach($comments as $comment){

            if($user_id != $comment->owner && !$comment->visible){
                continue;
            }

            $comment_template = $template;

            if($user_id == $comment->owner){
        
                $comment_template .= '
                    <div class="more">
                        <a data-callback="changeCommentVisibility" 
                            data-method="post" 
                            class="btn btn-primary btn-small btn-comment-visibility lw-ajax-link-action" 
                            href="/api/photo/comment/%s/change-visibility">%s</a>
                        <span class="date">%s</span> 
                    </div>
                ';

            } else {
                $comment_template .= '
                    <div class="more" data-comment="%s %s">                      
                        <span class="date">%s</span> 
                    </div>
                '; 
            }

            // user url, usename, comment, comment_id, visibility, date
            $visibility_label = $comment->visible ? "Ocultar" : "Exibir";

            $date = $comment->created_at->diffForHumans();

            $body .= sprintf($comment_template, "/@" . $comment->by_user->username, $comment->by_user->first_name, $comment->comment, $comment->id, $visibility_label, $date);
        }

        return $this->response(1, [
            "message" => "Listar comentários",
            "show_message" => false,
            "html" => $body
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($photo_uid, Request $request)
    {

        $comment = new PhotoComments;
        $comment->photo_uid = $photo_uid;
        $comment->comment = $request->input("comment");
        $comment->by = $request->input("by");
        $comment->owner = $request->input("owner");
        $comment->visible = false;
        $success = $comment->save();

        if($success){
            return $this->response(1, [
                "message" => "Comentário enviado com sucesso!",
                "show_message" => true,
                "image_uid" => $comment->photo_uid
            ]);
        } else {
            return $this->response(2, [
                "message" => "Erro ao salvar comentário!",
                "show_message" => true,
                "image_uid" => $comment->photo_uid
            ]);
        }

        return $response;
    }


    public function changeVisibility($comment_id)
    {

        $comment = PhotoComments::find($comment_id);
        $comment->visible = !$comment->visible;
        $comment->save();

        return $this->response(1, [
            "message" => "Visibilidade alterada com sucesso!",
            "show_message" => true,
            "image_uid" => $comment->photo_uid
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PhotoComments  $photoComments
     * @return \Illuminate\Http\Response
     */
    public function show(PhotoComments $photoComments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PhotoComments  $photoComments
     * @return \Illuminate\Http\Response
     */
    public function edit(PhotoComments $photoComments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PhotoComments  $photoComments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhotoComments $photoComments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PhotoComments  $photoComments
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhotoComments $photoComments)
    {
        //
    }

    public function response($reaction, $data){
        return [
            "response_token" => 0,
            "reaction" => $reaction,
            "incident" => null,
            "data" => $data,
            "response_action" => [
                "type" => null,
                "target" => null,
                "content" => null,
                "url" => null
            ]
        ];
    }
}
