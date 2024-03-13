<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\LogService;
use Illuminate\Support\Facades\Mail;
use App\Mail\diegopenavicente\NotifyCreation;

class UserController extends Controller
{

    protected $logService;
    protected $imageRepository;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
        $this->imageRepository = '/logos/';
    }

    public function searchByName(Request $request)
    {
        $name = strtolower($request->input('name')); // Convert input name to lowercase

        $users = User::whereRaw('LOWER(name) like ?', ["%$name%"])
            ->where('role', 'USER') // Filter by role = 'USER'
            ->select('id', 'name', 'email')
            ->limit(5)
            ->get();

        return response()->json($users);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Retrieve only verified users with pagination
        $usersQuery = User::whereNotNull('email_verified_at')->whereNotIn('role', ['ADMIN']);

        // Check if the email search parameter is provided
        $email = $request->query('email');
        if ($email) {
            // Apply the email filter to the query
            $usersQuery->where('email', 'like', '%' . $email . '%');
        }

        // Paginate the filtered users
        $users = $usersQuery->paginate(10);

        // Get the requested page from the query string
        $page = $request->query('page');

        // Redirect to the first page if the requested page is not valid
        if ($page && ($page < 1 || $page > $users->lastPage())) {
            return redirect()->route('users.index');
        }

        // Pass the search parameter to the view
        $searchParam = $email ? $email : '';

        // Return a view or JSON response as desired
        return view('users.index', compact('users', 'searchParam'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data, including the 'role' field
        $validatedData = $request->validate([
            'name' => 'required|max:25',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'package' => 'required|string|max:255',
            'billing_cycle' => 'required|in:' . implode(',', array_keys(User::BILLING_CYCLES)),
            'billing_day' => 'required|integer|min:1|max:31',
            'billing_month' => 'required|integer|min:1|max:12',
            'gross_amount' => 'required|numeric|min:0',
            'unique_payment' => 'required|numeric|min:0',
            'role' => 'required|in:' . User::ROLE_CLIENT,
            'notify' => 'nullable',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'website' => 'nullable|string',
            'language' => 'nullable|in:es,en,it',
        ], [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.max' => 'El campo nombre no puede tener más de 25 caracteres.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula, un número, un carácter especial (@$!%*?&), y tener al menos 8 caracteres.',
            'package.required' => 'El campo paquete es obligatorio.',
            'package.max' => 'El campo paquete no puede tener más de 255 caracteres.',
            'role.required' => 'El campo rol es obligatorio.',
            'role.in' => 'El valor del campo rol es inválido.',
            'billing_cycle.required' => 'El campo ciclo de facturación es obligatorio.',
            'billing_cycle.in' => 'El valor del campo ciclo de facturación es inválido.',
            'billing_day.required' => 'El campo día de facturación es obligatorio.',
            'billing_day.integer' => 'El campo día de facturación debe ser un número entero.',
            'billing_day.min' => 'El campo día de facturación debe ser mayor o igual a 1.',
            'billing_day.max' => 'El campo día de facturación debe ser menor o igual a 31.',
            'billing_month.required' => 'El campo mes de facturación es obligatorio.',
            'billing_month.integer' => 'El campo mes de facturación debe ser un número entero.',
            'billing_month.min' => 'El campo mes de facturación debe ser mayor o igual a 1.',
            'billing_month.max' => 'El campo mes de facturación debe ser menor o igual a 12.',
            'gross_amount.required' => 'El campo monto bruto es obligatorio.',
            'gross_amount.numeric' => 'El campo monto bruto debe ser un número.',
            'gross_amount.min' => 'El campo monto bruto debe ser mayor o igual a 0.',
            'unique_payment.numeric' => 'El campo pago único debe ser un número.',
            'unique_payment.min' => 'El campo pago único debe ser mayor o igual a 0.',
            'unique_payment.required' => 'El campo pago único es obligatorio.',
            'logo.required' => 'El campo logo es obligatorio.',
            'logo.image' => 'El archivo debe ser una imagen.',
            'logo.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg, gif, svg, webp.',
            'logo.max' => 'El archivo no debe ser mayor a 2MB.',
            'website.string' => 'El campo sitio web debe ser una cadena de texto.',
            'language.in' => 'El valor del campo idioma es inválido.',
        ]);

        $destinationPath = public_path() . $this->imageRepository;
        $imageFileName = null;

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $file = $request->file('logo');
            $extension = $file->extension();
            $fileName = 'logo_' . time() . '.' . $extension;
            $file->move($destinationPath, $fileName);
            $imageFileName = $fileName;
        }

        //Notify if its a new user
        $is_notify = isset($validatedData['notify']) && $validatedData['notify'] ? true : false;
        $language = isset($validatedData['language']) ? $validatedData['language'] : 'es';

        if($is_notify){
            
            $notify = new NotifyCreation($validatedData['name'], $language);
            Mail::mailer('default')->to($validatedData['email'])->send($notify);
        }

        // Create a new user with the specified role
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => $validatedData['role'],
            'package' => $validatedData['package'],
            'email_verified_at' => now(),
            'billing_cycle' => $validatedData['billing_cycle'],
            'billing_day' => $validatedData['billing_day'],
            'billing_month' => $validatedData['billing_month'],
            'gross_amount' => $validatedData['gross_amount'],
            'unique_payment' => $validatedData['unique_payment'],
            'logo' => $imageFileName ? $this->imageRepository . $imageFileName : null,
            'website' => $validatedData['website'],
            'language' => $language,
        ]);

        $return_message = 'Usuario creado exitosamente.';

        $this->logService->Log(1,$return_message);

        // Return a success response or redirect as desired
        return redirect()->route('users.index')->with('logSuccess', $return_message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:25',
            'email' => 'required|email|unique:users,email,'. $user->id,
            'password' => 'nullable|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'billing_cycle' => 'required|in:' . implode(',', array_keys(User::BILLING_CYCLES)),
            'billing_day' => 'required|integer|min:1|max:31',
            'billing_month' => 'required|integer|min:1|max:12',
            'gross_amount' => 'required|numeric|min:0',
            'unique_payment' => 'required|numeric|min:0',
            'package' => 'required|string|max:255',
            'role' => 'required|in:' . User::ROLE_CLIENT,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'website' => 'nullable|string',
            'language' => 'nullable|in:es,en,it',
        ], [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.max' => 'El campo nombre no puede tener más de 25 caracteres.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula, un número, un carácter especial (@$!%*?&), y tener al menos 8 caracteres.',
            'package.required' => 'El campo paquete es obligatorio.',
            'package.max' => 'El campo paquete no puede tener más de 255 caracteres.',
            'role.required' => 'El campo rol es obligatorio.',
            'role.in' => 'El valor del campo rol es inválido.',
            'billing_cycle.required' => 'El campo ciclo de facturación es obligatorio.',
            'billing_cycle.in' => 'El valor del campo ciclo de facturación es inválido.',
            'billing_day.required' => 'El campo día de facturación es obligatorio.',
            'billing_day.integer' => 'El campo día de facturación debe ser un número entero.',
            'billing_day.min' => 'El campo día de facturación debe ser mayor o igual a 1.',
            'billing_day.max' => 'El campo día de facturación debe ser menor o igual a 31.',
            'billing_month.required' => 'El campo mes de facturación es obligatorio.',
            'billing_month.integer' => 'El campo mes de facturación debe ser un número entero.',
            'billing_month.min' => 'El campo mes de facturación debe ser mayor o igual a 1.',
            'billing_month.max' => 'El campo mes de facturación debe ser menor o igual a 12.',
            'gross_amount.required' => 'El campo monto bruto es obligatorio.',
            'gross_amount.numeric' => 'El campo monto bruto debe ser un número.',
            'gross_amount.min' => 'El campo monto bruto debe ser mayor o igual a 0.',
            'unique_payment.numeric' => 'El campo pago único debe ser un número.',
            'unique_payment.min' => 'El campo pago único debe ser mayor o igual a 0.',
            'unique_payment.required' => 'El campo pago único es obligatorio.',
            'logo.image' => 'El archivo debe ser una imagen.',
            'logo.mimes' => 'El archivo debe ser de tipo: jpeg, png, jpg, gif, svg, webp.',
            'logo.max' => 'El archivo no debe ser mayor a 2MB.',
            'website.string' => 'El campo sitio web debe ser una cadena de texto.',
            'language.in' => 'El valor del campo idioma es inválido.',
        ]);

        $destinationPath = public_path() . $this->imageRepository;
        $imageOldFilename = $user->logo;
        $imageFileName = null;

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $file = $request->file('logo');
            $extension = $file->extension();
            $fileName = 'logo_' . time() . '.' . $extension;
            $file->move($destinationPath, $fileName);
            $imageFileName = $fileName;

            if ($imageOldFilename !== null) {
                $oldImagePath = public_path($imageOldFilename);
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }else{
            if($user->logo !== null){
                $imageFileName = basename($user->logo);
            }
        }

        // Update user with the specified role
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->package = $validatedData['package'];

        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        $user->role = $validatedData['role'];
        $user->billing_cycle = $validatedData['billing_cycle'];
        $user->billing_day = $validatedData['billing_day'];
        $user->billing_month = $validatedData['billing_month'];
        $user->gross_amount = $validatedData['gross_amount'];
        $user->unique_payment = $validatedData['unique_payment'];
        $user->logo = $imageFileName ? $this->imageRepository . $imageFileName : null;
        $user->website = $validatedData['website'];
        $user->language = isset($validatedData['language']) ? $validatedData['language'] : 'es';
        $user->save();

        $return_message = 'Usuario actualizado exitosamente.';

        $this->logService->Log(1,$return_message);

        // Return a success response or redirect as desired
        return redirect()->route('users.index')->with('logSuccess', $return_message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $imageProfile = $user->logo;

        if ($imageProfile !== null) {
            $ImagePath = public_path($imageProfile);
            if (file_exists($ImagePath) && is_file($ImagePath)) {
                unlink($ImagePath);
            }
        }

        // Delete the specified user
        $user->delete();

        $return_message = 'Usuario borrado exitosamente.';

        $this->logService->Log(1,$return_message);

        // Return a success response or redirect as desired
        return redirect()->route('users.index')->with('logSuccess', $return_message);
    }
}