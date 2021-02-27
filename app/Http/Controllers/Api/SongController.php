<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Song;

class SongController extends Controller
{
    public function index()
    {
      return Song::get(['link','name']);
    }

    public function getVideoInfo()
    {
        $id = request()->route('link');

        if(!empty($id)) {

            $strm = array(
                'http' => array(
                    'method' => 'GET',
                    'header' => 'referer: https://www.youtube.com/'
                )
            );
            $context = stream_context_create($strm);
            $content = file_get_contents('https://www.youtube.com/get_video_info?html5=1&video_id=' . $id, false, $context);

            parse_str($content, $arr);
            if (is_array($arr)) {
                foreach ($arr as &$v) {
                    $v = rawurldecode($v);
                    if (is_object(json_decode($v))) {
                        $v = json_decode($v, true);
                    };
                };
            };
dd($arr);
            return $arr['player_response']['streamingData']['adaptiveFormats'][6]['url'];
        }
    }
}
