<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class exampleController extends Controller
{
    //
    public function homePage() {
        //
        $ourName = 'Mogaya';
        $animals = ['Meowsalot', 'Barksalot', 'Purrsloud'];

        return view('homepage', ['allAnimals' => $animals, 'name' => $ourName, 'catName' => 'Meowsalot']);
    }

    public function aboutPage() {
        return view('single-post');
    }
}
