<?php

namespace App\Http\Controllers\Api\V1\Inspirasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use App\Models\Jamaah;
use App\Models\DaftarHaji;
use App\Models\DaftarHajiLog;
use App\Models\PembayaranHaji;
use App\Models\Kbih;
use App\Models\SettingNominalHajiMuda;
use Auth;
use App\Models\PaketTabunganUmrah;
use App\Models\TabunganUmrah;
use App\Helpers\VirtualAccount;
use App\Models\Nasabah;
use DB;
use App\Models\SettingBms;
use App\Models\Inspirasi;
use App\Models\InspirasiComment;
use App\Models\InspirasiLike;
use App\Models\InspirasiView;
use App\Models\InspirasiSubComment;
use App\Models\InspirasiCommentLike;

class InspirasiController extends Controller{
    public function upsert(Request $request){
        $rules = [
            'type'              => 'required|string|in:video,audio,html',
            'title'             => 'required|string',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        DB::beginTransaction();
        if(isset($request->id)){
            $inspirasi                      = Inspirasi::find($request->id);
            if($inspirasi){
                $this->failure('inspirasi tidak ditemukan');
            }
        }else{
            $inspirasi                      = new Inspirasi();
        }
        
        $inspirasi->type                    = $request->type;
        $inspirasi->title                   = $request->title;
        $inspirasi->subtitle                = $request->subtitle;
        $inspirasi->description             = $request->description;
        $inspirasi->html                    = $request->html;
        if($request->duration_second){
            $inspirasi->duration_second     = $request->duration_second;
        }
        $inspirasi->duration_string         = $request->duration_string;
        $inspirasi->thumbnail_id            = $request->thumbnail_id;
        $inspirasi->header_image_id         = $request->header_image_id;
        $inspirasi->audio_id                = $request->audio_id;
        $inspirasi->video_id                = $request->video_id;
        $inspirasi->uploader_name           = $request->uploader_name;
        if($request->is_active){
            $inspirasi->is_active           = $request->is_active;
        }
        $inspirasi->save();
        $inspirasi->refresh();
        DB::commit();
        return $this->success('Berhasil',$inspirasi);
    }

    public function delete(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:inspirasis,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data    = Inspirasi::find($request->id);
        $data->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function detail(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:inspirasis,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user_id                = Auth::id();
        $data                   = Inspirasi::find($request->id);
        $data->load(['thumbnail','header_image','audio','video','comments.sub_comments.user','comments.user']);

        $data->total_comment    = InspirasiComment::where('inspirasi_id',$data->id)->count();
        $data->total_like       = InspirasiLike::where('inspirasi_id',$data->id)->count();
        $data->total_view       = InspirasiView::where('inspirasi_id',$data->id)->count();

        $data->is_commented     = InspirasiComment::where('inspirasi_id',$data->id)->where('user_id',$user_id)->count();
        $data->is_liked         = InspirasiLike::where('inspirasi_id',$data->id)->where('user_id',$user_id)->count();
        $data->is_viewed        = InspirasiView::where('inspirasi_id',$data->id)->where('user_id',$user_id)->count();
        foreach($data->comments as $comment){
            $comment->total_comment                = InspirasiSubComment::where('comment_id',$comment->id)->count();
            $comment->total_like                   = InspirasiCommentLike::where('comment_id',$comment->id)->count();
            $comment->is_liked                     = InspirasiCommentLike::where('comment_id',$comment->id)->where('user_id',$user_id)->count();
        }
        InspirasiView::where('user_id',$user_id)->where('inspirasi_id',$data->id)->delete();
        $view                               = new InspirasiView();
        $view->inspirasi_id                 = $data->id;
        $view->user_id                      = $user_id;
        $view->save();
        return $this->success('Berhasil', $data);
    }

    public function all(Request $request){
        $rules = [
            'type'              => 'required|string|in:video,audio,html',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user_id    = Auth::id();
        $datas      = Inspirasi::select('id','title','subtitle','description','type','duration_second','duration_string','thumbnail_id','header_image_id','audio_id','audio_url','video_id','video_url','uploader_name','is_active','created_at','updated_at')
        ->where('type',$request->type)
        ->where('is_active',1)
        ->orderBy('created_at','desc')
        ->get();
        $datas->load(['thumbnail','header_image','audio','video']);
        foreach($datas as $data){
            $data->total_comment    = InspirasiComment::where('inspirasi_id',$data->id)->count();
            $data->total_like       = InspirasiLike::where('inspirasi_id',$data->id)->count();
            $data->total_view       = InspirasiView::where('inspirasi_id',$data->id)->count();

            $data->is_commented     = InspirasiComment::where('inspirasi_id',$data->id)->where('user_id',$user_id)->count();
            $data->is_liked         = InspirasiLike::where('inspirasi_id',$data->id)->where('user_id',$user_id)->count();
            $data->is_viewed        = InspirasiView::where('inspirasi_id',$data->id)->where('user_id',$user_id)->count();
        }
        return $this->success(@count($datas).' data berhasil ditampilkan', $datas);
    }

    public function comment(Request $request){
        $rules = [
            'id'        => 'required|int|exists:inspirasis,id',
            'comment'   => 'required|string',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        DB::beginTransaction();
        
        $comment                            = new InspirasiComment();
        $comment->inspirasi_id              = $request->id;
        $comment->user_id                   = Auth::id();
        $comment->comment                   = $request->comment;
        $comment->save();
        DB::commit();
        $data                               = Inspirasi::find($request->id);
        $data->load(['thumbnail','header_image','audio','video','comments']);
        return $this->success('Berhasil',$data);
    }

    public function like(Request $request){
        $rules = [
            'id'            => 'required|int|exists:inspirasis,id',
            'type'          => 'required|string|in:like,dislike',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user_id        = Auth::id();
        $inspirasi      = Inspirasi::find($request->id);
        DB::beginTransaction();
        InspirasiLike::where('user_id',$user_id)->where('inspirasi_id',$inspirasi->id)->delete();
        if($request->type == 'like'){
            $like                               = new InspirasiLike();
            $like->inspirasi_id                 = $inspirasi->id;
            $like->user_id                      = $user_id;
            $like->save();
        }
        DB::commit();
        return $this->success('Berhasil');
    }

    public function view(Request $request){
        $rules = [
            'id'            => 'required|int|exists:inspirasis,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user_id                            = Auth::id();
        $inspirasi                          = Inspirasi::find($request->id);
        DB::beginTransaction();
        InspirasiView::where('user_id',$user_id)->where('inspirasi_id',$inspirasi->id)->delete();
        $view                               = new InspirasiView();
        $view->inspirasi_id                 = $inspirasi->id;
        $view->user_id                      = $user_id;
        $view->save();
        DB::commit();
        return $this->success('Berhasil');
    }

    public function likeComment(Request $request){
        $rules = [
            'id'            => 'required|int|exists:inspirasi_comments,id',
            'type'          => 'required|string|in:like,dislike',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $user_id        = Auth::id();
        $comment        = InspirasiComment::find($request->id);
        DB::beginTransaction();
        InspirasiCommentLike::where('user_id',$user_id)->where('comment_id',$comment->id)->delete();
        if($request->type == 'like'){
            $like                               = new InspirasiCommentLike();
            $like->comment_id                   = $comment->id;
            $like->user_id                      = $user_id;
            $like->save();
        }
        DB::commit();
        $data                               = InspirasiComment::find($comment->id);
        $data->load(['user','sub_comments']);
        $data->total_comment                = InspirasiSubComment::where('comment_id',$comment->id)->count();
        $data->total_like                   = InspirasiCommentLike::where('comment_id',$comment->id)->count();
        $data->is_liked                     = InspirasiCommentLike::where('comment_id',$comment->id)->where('user_id',$user_id)->count();
        return $this->success('Berhasil',$data);
    }

    public function subComment(Request $request){
        $rules = [
            'id'        => 'required|int|exists:inspirasi_comments,id',
            'comment'   => 'required|string',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        DB::beginTransaction();
        $user_id                            = Auth::id();
        $comment                            = new InspirasiSubComment();
        $comment->comment_id                = $request->id;
        $comment->user_id                   = $user_id;
        $comment->comment                   = $request->comment;
        $comment->save();
        DB::commit();
        $data                               = InspirasiComment::find($request->id);
        $data->total_comment                = InspirasiSubComment::where('comment_id',$request->id)->count();
        $data->total_like                   = InspirasiCommentLike::where('comment_id',$request->id)->count();
        return $this->success('Berhasil',$data);
    }
}
