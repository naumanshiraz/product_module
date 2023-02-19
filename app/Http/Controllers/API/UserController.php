<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\ProductAdded;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;
use Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::all();

        return $this->sendResponse($users, 'Users Retrieved Successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
        ];

        $product = User::create($data);

        return $this->sendResponse($product, 'Product Created Successfully.');
    }
}
