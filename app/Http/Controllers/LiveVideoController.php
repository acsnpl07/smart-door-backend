<?php

namespace App\Http\Controllers;

class LiveVideoController extends Controller
{
    public function show()
    {
        return response()->json([
            'image_url' => 'https://i.picsum.photos/id/' . random_int(0, 2000) . '/500'
        ]);
    }
}
