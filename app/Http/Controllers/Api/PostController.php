<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\ApiResonseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use ApiResonseTrait;
    public function index(){
        $posts =PostResource::collection(Post::get());
        // $posts =Post::get();
        return $this->apiresponce($posts,'ok',200);
        // $array = [
        //     'data'=>$posts,
        //     'message'=>'ok',
        //     'status'=>200
        // ];
        // return response($array,200);
        //$msg = ["ok"];
        //return response($posts,200,$msg);
    }
    public function show($id){
        //$post = new PostResource(Post::find($id));
        $post = Post::find($id);
        if($post){
            return $this->apiresponce(new PostResource($post),'ok',200);
        }
        else{
            return $this->apiresponce($post,'This post not found',404);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'title' =>'required|max:255',
            'body' => 'required',
        ]);
        if($validator->fails()){
            return $this->apiresponce(null,$validator->errors(),400);
        }
        $post = Post::create($request->all());
        if($post){
            return $this->apiresponce(new PostResource($post),'the post saved',201);
        }
        // else{
        //     return $this->apiresponce($post,'the post not save',400);
        // }
    }
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'title' =>'required|max:255',
            'body' => 'required',
        ]);
        if($validator->fails()){
            return $this->apiresponce(null,$validator->errors(),400);
        }
        $post = Post::find($id);
        if(!$post){
            return $this->apiresponce(null,'the post not found',404);
        }
        $post->update($request->all());
        return $this->apiresponce(new PostResource($post),'the post updated',201);

    }
    public function destroy($id){
        $post = Post::find($id);
        if(!$post){
            return $this->apiresponce(null,'the post not found',404);
        }
        $post->destroy($id);
        return $this->apiresponce(null,'the post deleted',200);

    }
}
