<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->only([
            'u_id', 'app_id', 'language', 'operating_system'
        ]);

        $validator = Validator::make($data, [
            'u_id' => ['required', 'string'],
            'app_id' => ['required', 'string'],
            'language' => ['required', 'string', 'in:en,tr'],
            'operating_system' => ['required', 'string', 'in:android,ios'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $token = $this->attempt($data);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('device')->factory()->getTTL() * 60
        ]);
    }

    public function getAuthGuard()
    {
        return auth('device');
    }

    public function attempt(array $data)
    {
        return $this->getAuthGuard()->attempt($data);
    }
}
