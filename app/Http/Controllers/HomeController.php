<?php

/*

Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This class is the controller for home page.

*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
  //----------------------------------------------------------------------------------------------------------------------------
  // Constructor

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }

  //----------------------------------------------------------------------------------------------------------------------------
  // Functions

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
      return view('home');
    }
}
