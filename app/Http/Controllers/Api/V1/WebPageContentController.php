<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\PageContenctResource;
use App\Http\Resources\PageResource;
use App\Http\Resources\WebPageContenctResource;
use App\LanguageString;
use App\Page;
use App\WebPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebPageContentController extends Controller
{
   /**
     *  Display a listing of Page Content
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        try{
        $page_slug = $request->get('slug');
        $page_id = $request->get('page_id');
       if(isset($page_slug) && $page_id == null){
           $page_detail = WebPageContenctResource::collection(WebPage::translated()->where(['slug'=>$page_slug,'page_status'=>1])->get());
       }else {
           $page_detail = WebPageContenctResource::collection(WebPage::translated()->where(['id' => $page_id, 'page_status' => 1])->get());
       }
            if(count($page_detail)>0){
                $page_detail = $page_detail[0];
            }else{
                $page_detail = [];
            }

        return response()->json( $page_detail,200, ['Content-Type' => 'application/json; charset=UTF-8',
            'charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);;
            }catch(\Exception $e){
        $message = LanguageString::translated()->where('bls_name_key','error')->first()->name;
        $error = ['field'=>'Languages','message'=>$message];
        $errors =[$error];
        return response()->json(['success'=>false,'code'=>'500','errors' => $errors], 500);
        }
    }
}
