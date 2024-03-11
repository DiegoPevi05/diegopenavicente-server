<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogModel;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $month = $request->query('month', Carbon::now()->month);
        $year = $request->query('year', Carbon::now()->year);
        $authUser = $request->user();

        //GET NOTIFICATIONS

        $logsQuery = LogModel::query();

        if ($authUser->role != User::ROLE_ADMIN) {
            $logsQuery->whereIn('user_role', [User::ROLE_CLIENT])->where('id', $authUser->id);
        }

        $logsQuery->orderBy('created_at', 'desc');

        // Paginate the categories
        $logs = $logsQuery->paginate(6);

        // Get the requested page from the query string
        $page = $request->query('page');

        if ($page && ($page < 1 || $page > $logs->lastPage())) {
            return redirect()->route('home.index');
        }

        $searchParam = $page ? $page : '';


        $import_total = 0;

        //caculate import total for the current month based on the unique_payment on the users created in the current_month and 
        //the users that are not created in the current month and their billing_cycle is monthly or yearly and the billing_day is the current day or the current day is greater than the billing_day
        //and the billing_month is the current month
        // only fetch users with role client
        $users_imports = [];

        $users_imports = User::where(function($query) {
            $query->whereMonth('created_at', Carbon::now()->month)->where('role', 'CLIENT');
        })->orWhere(function($query){
            $query->where('billing_cycle', 'MONTHLY')->where('billing_day', '>=', Carbon::now()->day);
        })->orWhere(function($query){
            $query->where('billing_cycle', 'YEARLY')->where('billing_day', '>=', Carbon::now()->day)->where('billing_month', Carbon::now()->month);
        })->get();

        if($authUser->role == 'CLIENT'){
            $users_imports = $users_imports->filter(function($user) use ($authUser){
                return $user->id == $authUser->id;
            });
        }



        //if the user is created this month the unique_payment should be added to the import_total else the gross_amount should be added to the import_total
        foreach($users_imports as $user){
            if(Carbon::now()->month == $user->created_at->month){
                $import_total += $user->unique_payment;
            }else{
                $import_total += $user->gross_amount;
            }
        }

        //Generate a list of objects containg dates, gross_import and user.name of the users in the current month that should be billed, for example
        //if a user got a billing cycle of yearly and the billing_month is the current month should be the date generated with the billing_day and billing_month of the user
        //if a user got a billing cycle of monthly should be the date generated with the billing day and the current month
        //if the user got a billing cycle of one_time no object should be generated
        $users = [];
        $users = User::where(function($query) use ($month, $year){
            $query->whereMonth('created_at', $month)->whereYear('created_at', $year)->where('role', 'CLIENT');
        })->orWhere(function($query) use ($month, $year){
            $query->where('billing_cycle', 'MONTHLY');
        })->orWhere(function($query) use ($month, $year){
            $query->where('billing_cycle', 'YEARLY')->where('billing_month', $month);
        })->get();

        if($authUser->role == 'CLIENT'){
            //filter the above $users with the $authUser.id
            $users = $users->filter(function($user) use ($authUser){
                return $user->id == $authUser->id;
            });
        }

        $billing_dates = [];
        foreach($users as $user){
            if($user->billing_cycle == 'ONE_TIME'){
                continue;
            }

            $gross_amount = $user->gross_amount;
            $type = 'CiclePayment';

            if($month == $user->created_at->month && $year == $user->created_at->year){
                $date = Carbon::createFromDate($year, $month, $user->created_at->day);
                $gross_amount = $user->unique_payment;
                $type = 'UniquePayment';

            }else{
                $date = Carbon::createFromDate($year, $month, $user->billing_day);
            }

            $billing_dates[] = [
                'date' => $date,
                'gross_amount' => $gross_amount,
                'type' => $type,
                'user' => $user->name
            ];
        }

        return view('home.index',compact('logs','billing_dates','import_total','searchParam'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}