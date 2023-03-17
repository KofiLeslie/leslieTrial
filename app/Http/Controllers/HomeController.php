<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $pgdata = [];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::find(auth()->id());
        $this->pgdata['token'] = $user->createToken('API TOKEN')->plainTextToken;
        $chk = Media::whereUser_id(auth()->id())->count();
        $this->pgdata['media'] = $chk > 0 ? Media::whereUser_id(auth()->id())->get() : [];
        return view('home', $this->pgdata);
    }
}
