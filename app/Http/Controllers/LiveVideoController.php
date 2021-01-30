<?php

namespace App\Http\Controllers;

class LiveVideoController extends Controller
{
    public function show()
    {
        return response()->json([
            'image_url' => 'https://picsum.photos/id/' . random_int(0, 1000) . '/500'
        ]);
    }
}
