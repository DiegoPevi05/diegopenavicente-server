<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\File;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_CLIENT = 'CLIENT';
    const ROLE_ADMIN = 'ADMIN';
    const BILLING_CYCLES = [
        'MONTHLY' => 'MONTHLY',
        'YEARLY' => 'YEARLY',
        'ONE_TIME' => 'ONE_TIME'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'package',
        'role',
        'billing_cycle',
        'billing_day',
        'billing_month',
        'gross_amount',
        'unique_payment',
        'email_verified_at',
        'recover_token_time',
        'logo',
        'website',
    ];

    public function ExistControllerPackage(){
        $path = app_path('Http/Controllers/' . $this->package);
        return File::isDirectory($path);
    }

    public function getControllerClassesInPackageFolder()
    {
        $controllers = [];
        $package = $this->package;
        $path = app_path('Http/Controllers/' . $package);

        // Get all PHP files in the folder
        $files = File::files($path);

        foreach ($files as $file) {
            // Extract class name from the file
            $className = pathinfo($file, PATHINFO_FILENAME);

            // Form fully qualified class name
            $fullyQualifiedClassName = 'App\\Http\\Controllers\\' . $package . '\\' . $className;

            // Check if the class exists and is a subclass of Controller
            if (class_exists($fullyQualifiedClassName) && is_subclass_of($fullyQualifiedClassName, \App\Http\Controllers\Controller::class)) {
                // Create an instance of the controller
                $controllerInstance = new $fullyQualifiedClassName;
                
                
                // Get the route name from the controller
                if (property_exists($controllerInstance, 'routeName')) {
                    $controllers[] = [
                        'routeName' => $controllerInstance->routeName,
                        'className' => $fullyQualifiedClassName,
                        'icon' => $controllerInstance->icon,
                        'label' => $controllerInstance->label,
                    ];
                }
            }
        }

        return $controllers;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
