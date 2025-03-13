<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
            'device_name' => 'string|max:255',
            'abilities' => 'nullable|array'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            

            // هاتلي قيمة الديفايس نيم لو مش موجود هاتلي الديفولت الهيدر تاع الريكويست اسمه يوزر اجينت
            $device_name = $request->post('device_name', $request->userAgent());

            // هنا كلاس كرييت توكن هاد جاهز الي استدعناه في المودل 
            // بياخد اول اشي اسم التوكت واحنا سمناه ديفايس نيم 
            // وخزنلي ياه بمتغير التوكن
            $abilities = $request->post('abilities', []);
            $token = $user->createToken($device_name, $abilities)->plainTextToken;
            // $token = $user->createToken($device_name, $request->post('abilities'));

            // هاد بحال اليوزر كان auth
            return Response::json([
                 'code' => 1,  // هاد بدل المسج
                'token' => $token,
                'user' => $user,
            ], 201);

        }
// غير ذلك ارجعلي 401
        return Response::json([
            'code' => 0,
            'message' => 'Invalid credentials',
        ], 401);
        
    }

    public function destroy($token = null)
    {
        $user = Auth::guard('sanctum')->user();


        // هاد حالة لو بدي اعمل حزف لكل التوكن مرة وحدة زي فيس بزك انهاء جميع الجلسات
        // Revoke all tokens
        // $user->tokens()->delete();

        if (null === $token) {
            $user->currentAccessToken()->delete();
            return;
        }
//
        $personalAccessToken = PersonalAccessToken::findToken($token);
        if (
            $user->id == $personalAccessToken->tokenable_id 
            && get_class($user) == $personalAccessToken->tokenable_type
        ) {
            $personalAccessToken->delete();
        }
    }
}
