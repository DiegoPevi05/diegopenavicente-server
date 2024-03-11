<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\diegopenavicente\RecoverPassword;
use App\Services\LogService;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{

    protected $logService;

    public function __construct(LogService $logService)
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check()) {
                return redirect()->route('home.index');
            }
            return $next($request);
        })->except('logout');
        $this->logService = $logService;
    }

    public function showLoginForm()
    {
        return view('auth.login'); // Use the correct view path
    }

    public function showRegisterForm()
    {
        return view('auth.register'); // Use the correct view path
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ], [
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.exists' => 'El correo electrónico proporcionado no existe.',
            'password.required' => 'El campo contraseña es obligatorio.',
        ]);


        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
             // Check the user's role
            $user = Auth::user();
            $return_message = 'Ha iniciado Sesión.';
            $this->logService->Log(3, $return_message);
            return redirect()->route('home.index');
        }

        return redirect()->route('login')->withInput($request->only('email'))->with('logError','No se ha podido ingresar correctamente');
    }

    /*public function register(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|max:25',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'auth_code' => 'required'
        ], [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.max' => 'El campo nombre no puede tener más de 25 caracteres.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'auth_code.required' => 'El codigo de autorizacion es requerido',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula, un número, un carácter especial (@$!%*?&), y tener al menos 8 caracteres.',
        ]);

        $AuthCode = env('AUTH_REGISTER_CODE');

        if($AuthCode != $validatedData['auth_code']){
            return redirect()->route('register')->withInput($request->only('name','email'))->with('logError','El codigo de autorizacion es incorrecto');
        }

        // Create a new user with the specified role
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => User::ROLE_CLIENT,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('login')->withInput($request->only('email'))->with('logSuccess','Registro exitoso');
    }*/

    public function showRecoverPasswordForm()
    {
        return view('auth.password'); // Use the correct view path
    }

    public function recoverPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.exists' => 'El correo electrónico proporcionado no existe.'
        ]);

        
        $user = User::where('email',$request->input('email'))->first();

        if($user->role == User::ROLE_ADMIN){
            return redirect()->route('recover-password')->with('logError', 'No se puede recuperar la contraseña de un administrador');
        }
        
        // Check if a token was created within the last 15 minutes
        $currentTime = time();
        $lastTokenCreationTime = $user->recover_token_time ?? 0; // Change 'last_token_creation' to your user model's field
        $timeDiff = $currentTime - $lastTokenCreationTime;

        if ($timeDiff < 900) { // 900 seconds = 15 minutes
            return redirect()->route('recover-password')->with('logError', 'Debes esperar 15 minutos antes de solicitar otro token.');
        }

        $new_password = Str::random(16);

        try{
            $recoverPassword =  new RecoverPassword($user->name, $new_password);
            Mail::mailer('default')->to($user->email)->send($recoverPassword);
        }catch (\Exception $e){
            Log::error('Error sending email: '.$e->getMessage());
            return redirect()->route('recover-password')->with('logError', 'Hubo un error enviando el correo, intenta en un rato.');
        }

        $user->recover_token_time = $currentTime;
        $user->password =  bcrypt($new_password);
        $user->save();

        return redirect()->route('recover-password')->with('logSuccess', 'Se ha enviado el correo exitosamente');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }

    public function showTermsOfService()
    {
        return view('auth.terms'); // Use the correct view path
    }
}