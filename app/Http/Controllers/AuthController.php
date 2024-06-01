<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Grpc\ChannelCredentials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Rootadminweb\DoLoginRequest;
use Rootadminweb\DoLogoutRequest;
use Rootadminweb\RootAdminWebServiceClient;
use Validator;
use App\Models\User;

class AuthController extends Controller {

    /**
     * Display login of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function login(){
        $title = "Login";
        $description = "Some description for the page";
        return view('auth.login',compact('title','description'));
    }

    /**
     * Display register of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function register(){
        $title = "Register";
        $description = "Some description for the page";
        return view('auth.register',compact('title','description'));
    }

    /**
     * Display forget password of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function forgetPassword(){
        $title = "Forget Password";
        $description = "Some description for the page";
        return view('auth.forget_password',compact('title','description'));
    }

    /**
     * make the user able to register
     *
     * @return
     */
    public function signup(Request $request){
        $validators=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required'
        ]);
        if($validators->fails()){
            return redirect()->route('register')->withErrors($validators)->withInput();
        }else{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();
            auth()->login($user);
            return redirect()->intended(route('dashboard.demo_one','en'))->with('message','Registration was successfull !');
        }
    }

    /**
     * make the user able to login
     *
     * @return
     */
    public function authenticate(Request $request){
        $validators=Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if($validators->fails()){
            return redirect()->route('login')->withErrors($validators)->withInput();
        }else{
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
                return redirect()->intended(route('dashboard.demo_one','en'))->with('message','Welcome back !');
            }else{
                return redirect()->route('login')->with('message','Login failed !Email/Password is incorrect !');
            }
        }
    }

    public function doLogin(Request $request){
        Log::debug('DoLogin');

        $payloadArray = json_decode($request->getContent(), true);

//        select all from table mt_user_reseller where email = $email mysql
        $res = DB::connection('mysql')->select('SELECT * FROM mt_user_reseller_new WHERE email = "' . $payloadArray[0] . '"');

        if (count($res) == 0) {
            Log::debug('DoLogin Failed: User Not Found');
            echo 'user not found';
        } elseif (password_verify($payloadArray[1], $res[0]->password) && ($res[0]->role != "PARTICIPANT")) {
            $request->session()->put('sessionEmail', $payloadArray[0]);
            $request->session()->put('sessionId', $res[0]->id);
            $request->session()->put('sessionName', $res[0]->nama);
            $request->session()->put('sessionPhone', $res[0]->phone);
            $request->session()->put('sessionPic', $res[0]->pic);
            $request->session()->put('sessionPrincipalUpline', $res[0]->principal_upline);
            $request->session()->put('sessionResellerUpline', $res[0]->reseller_upline);

            if ($res[0]->role == "ROOT_ADMIN") {
                $request->session()->put('sessionRole', 'ROOT_ADMIN');
            } else if ($res[0]->role == "PRINCIPAL") {
                $request->session()->put('sessionRole', 'PRINCIPAL');
            } else if ($res[0]->role == "RESELLER") {
                $request->session()->put('sessionRole', 'RESELLER');
            }


            $session = $payloadArray[0] . "|" . $res[0]->id . "|" . $res[0]->nama . "|" . $res[0]->phone;
            $request->session()->put('sessionSignature', $session);

            echo 'yes';
        } else {
            Log::debug('DoLogin Failed: Wrong Password');
            echo 'wrong password';
        }

        echo '';
    }

    /**
     * make the user able to logout
     *
     * @return
     */
    public function logout(Request $request){
        $request->session()->flush();

        Auth::logout();
        return redirect()->route('login')->with('error','Successfully Logged out !');
    }
}
