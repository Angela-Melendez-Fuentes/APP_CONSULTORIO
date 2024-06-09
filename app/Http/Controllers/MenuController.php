<?php

namespace App\Http\Controllers;

class MenuController extends Controller
{
    public function dashboard(){
        return view('dashboard');
    }

    public function welcome(){
        return view('welcome');
    }

    public function pago(){
        if (auth()->user()->tipo === 'secretaria') {
            return view('secretaria.pago');
        }    
    }

    public function index()
    {
        if (auth()->user()->tipo === 'secretaria') {
            return view('secretaria.dashboard');
        } elseif (auth()->user()->tipo === 'doctor') {
            return view('doctor.dashboard');
        } else{
            return view('dashboard');
        }
    }

}
