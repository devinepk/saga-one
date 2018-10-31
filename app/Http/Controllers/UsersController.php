<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    protected $journal1 = [
        'id' => 1,
        'title' => 'Journal 1',
        'description' => 'A journal for friends',
        'cover_url' => '/img/cover1.jpg',
        'participants' => [
            ['name' => 'Bobby Bob'],
            ['name' => 'Bobbert Bob'],
            ['name' => 'Bonnie Bobbington'],
            ['name' => 'Boris Bobford']
        ]
    ];

    protected $journal2 = [
        'id' => 2,
        'title' => 'Journal 2',
        'description' => 'A journal for family',
        'cover_url' => '/img/cover1.jpg',
        'participants' => [
            ['name' => 'Bobby Bob'],
            ['name' => 'Billy Bobbly'],
            ['name' => 'Bongo Bor']
        ]
    ];

    protected $journal3 = [
        'id' => 3,
        'title' => 'Journal 3',
        'description' => 'A journal for everybody!',
        'cover_url' => '/img/cover1.jpg',
        'participants' => [
        ]
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('user.index', ['user' => Auth::user(), 'journals' => [$this->journal1, $this->journal2, $this->journal3]]);
    }

    public function account(Request $request)
    {
        return view('user.account', ['user' => Auth::user()]);
    }
}
