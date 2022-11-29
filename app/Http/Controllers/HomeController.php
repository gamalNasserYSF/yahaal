<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    /**
     * Get a list of users using filtration manner
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // get users by applying filter
        $allUsers = User::filterResults();

        $total_males   = $allUsers->where('gender', 'Male')->count();
        $total_females = $allUsers->where('gender', 'Female')->count();

        // paginate the results
        $users = paginate($allUsers, 24, request('page') ?? 1);

        return view('home', compact('users', 'total_males', 'total_females'));
    }
}
