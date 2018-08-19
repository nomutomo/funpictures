<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImagesController;

use App\User;
use App\Message; //追加
use App\Image; //追加
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{

    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            if( isset($user) ) {
                $messages = $user->feed_messages()->orderBy('created_at', 'desc')->paginate(20);
    
                $data = [
                    'user' => $user,
                    'messages' => $messages,
                ];
            }
        }
        //return $data;
        return view('welcome', $data);
    }
    
    public function put(Request $request)
    {
        
        $this->validate($request, [
            'content' => 'required|max:191',
            'file' => [
                // アップロードされたファイルであること
                'file',
                // 画像ファイルであること
                'image',
                // MIMEタイプを指定
                'mimes:jpeg,jpg,png,gif',
                // 最小縦横120px 最大縦横400px
                'dimensions:min_width=120,min_height=120,max_width=1000,max_height=1000',
                // 容量最大1024
                'max:1024',
            ]
        ]);
        
        $user = \Auth::user();
        
        
        $request->user()->messages()->create([
            'content' => $request->content,
        ]);
        
        $message_id = $user->messages()->max('id');
    
        //return $request->file;
        $filename = $request->file;
    
        if ($filename === null) {
        } else {
            $filename = basename($request->file->store('public/avatar/' . $user->id));
            $request->user()->images()->create([
                'image_path' => $filename,
                'message_id' => $message_id,
            ]);
        }

        return redirect()->back();
        
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);

        //return $request;

        $request->user()->messages()->create([
            'content' => $request->content,
        ]);

        return redirect()->back();
    }
    
    public function destroy(Request $request,$id)
    {
        //return $request;
        $message = \App\Message::find($id);
        
        //return $message;
        if( isset($message) ) {
            if (\Auth::id() === $message->user_id) {
                if($message->images()->count() > 0){
                    $oldfile = $request->image_path;
                    if ($oldfile === null){
                    } else {
                        Storage::delete('public/avatar/' . $message->user_id . '/' . $oldfile);
                    }
                }
                $message->delete(); //カスケードでimagesも削除される。
            }
        }
        
        return redirect()->back();
    }
    
}
