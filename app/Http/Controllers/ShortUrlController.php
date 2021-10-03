<?php

namespace App\Http\Controllers;

use App\Models\EncodeUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShortUrlController extends Controller
{
    
    function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function encode(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'url' => 'required|url|unique:encode_urls,original_url',
        ]);


        $errors = $validator->errors();
        if ($validator->fails() && ($errors->first() != "")) {
            return response()->json($errors);
            // return back()->withInput();
        }
            $encode = EncodeUrl::create([
                'original_url' => $request->url,
            ]);

            if($encode){
                $encode->update([
                    'short_url' => $this->generateRandomString()
                ]);
            }

            return response()->json([
                'url' => $encode->short_url,
            ]);

    }



    public function decode(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'url' => 'required',
        ]);


        $errors = $validator->errors();
        if ($validator->fails() && ($errors->first() != "")) {
            return response()->json($errors);
            // return back()->withInput();
        }
            $encode = EncodeUrl::where('short_url', $request->url)->first();

            if($encode){
                $encode->update([
                    'visits' => $encode->visits + 1
                ]);

                return response()->json([
                    'url' =>  $encode->original_url,
                ]);
            }

            return response()->json([
                'error' => 'Url not found in our database',
            ]);


    }


}
