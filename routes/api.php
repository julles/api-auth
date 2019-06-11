<?php

use Carbon\Carbon;
use Illuminate\Http\Request;

Route::post('login', function (Request $request) {

    $credentials = request(['email', 'password']);

    $user = auth()->attempt($credentials);

    if (!$user) {
        return repsonse()->json([
            'message' => 'Unauthorized (data tidak di temukan)',
        ], 403);
    }

    $token = $request->user()->createToken('Laravel Personal Access Client');

    return response()->json([
        'access_token' => $token->accessToken,
        'token_type' => 'Bearer',
        'expires_at' => Carbon::parse(
            $token->token->expires_at
        )->toDateTimeString(),
    ]);

});

Route::middleware('auth:api')->group(function () {
    Route::get('data', function (Request $request) {
        echo "hi ", $request->name;
    });
});
