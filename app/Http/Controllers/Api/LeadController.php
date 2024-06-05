<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function store(Request $request){
        $data = $request->all();

        $validator = Validator::make($data,
            [
                'name'=> 'required|min:3|max:100',
                'email'=> 'required|email',
                'message'=> 'required|min:3'
            ],
            [
                'name.required' => 'Il nome è un campo obbligatorio',
                'name.min' => 'Il nome deve contenere almeno :min caratteri',
                'name.max' => 'Il nome può contenere massimo :max caratteri',
                'email.required' => 'L\'email è un campo obbligatorio',
                'email.email' => 'Il formato non è corretto',
                'message.required' => 'Il messaggio è un campo obbligatorio',
                'message.min' => 'Il messaggio deve contenere almeno :min caratteri'
            ]
        );

        if($validator->fails()){
            $success = false;
            $errors = $validator->errors();
            return response()->json(compact('success', 'errors'));
        }

        $success = true;
        return response()->json(compact('success'));
    }
}
