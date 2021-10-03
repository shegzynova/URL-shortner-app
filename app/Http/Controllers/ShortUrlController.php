<?php

namespace App\Http\Controllers;

use App\Models\EncodeUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShortUrlController extends Controller
{
    

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


}
