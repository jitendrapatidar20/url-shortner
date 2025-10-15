<?php
namespace App\Http\Controllers\Admin\Auth;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use App\Lib\RenderJson;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class AuthController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Login Screen' ?? '',
            'meta_title' => 'Login Screen' ?? '',
            'meta_keyword' => 'Login Screen' ?? '',
            'meta_description' => 'Login Screen' ?? '',
        ];
        return view('auth.login', $data);
    }

    
    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $blockStatus = $this->getAttemptsStatus($request->ip(), $request->header('User-Agent'), $request->email);

        if (!$blockStatus['status']) {
            $message = $blockStatus['permanent_block']
                ? 'You have been permanently blocked. Contact admin.'
                : 'You are temporarily blocked for 15 minutes.';
            return response()->json(['status' => false, 'error' => $message], 401);
        }

        $user = User::where('email', $request->email)->first();
       

        if (!$user  || !Hash::check($request->password, $user->password)) {
            return response()->json(['status' => false, 'error' => 'Invalid credentials.'], 401);
        }

        if ($user->status != 1) {
            return response()->json(['status' => false, 'error' => 'Account not approved.'], 401);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user->update([
                'last_ip' => $request->ip(),
                'last_latitude' => $request->latitude,
                'last_longitude' => $request->longitude
            ]);


            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'redirect' => route('dashboard')
            ]);
        }

        return response()->json(['status' => false, 'error' => 'Login failed.'], 401);
    }


}


