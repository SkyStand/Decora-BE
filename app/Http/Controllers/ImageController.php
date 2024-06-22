<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function get(string $tipe)
    {
        if ($tipe == "product") {
            return asset('storage/post_img');
        }
        return 'nyari apa';
    }
}
