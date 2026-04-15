<?php

namespace App\Http\Controllers;

use App\Models\TestingSIMDK;
use Illuminate\Http\Request;

class TestingSIMDKController extends Controller
{
    public function submit(Request $request){
        $request['users_id'] = session('account')['id'];

        TestingSIMDK::create($request);
    }
}
