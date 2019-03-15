<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function testIndex()
    {
        $registerUser = User::query()->create([
            'phone' => '17311200692'
        ]);

        dd($registerUser->exists);
    }
}
