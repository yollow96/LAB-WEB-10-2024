<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home')->with([
            'pageTitle' => 'Welcome to Our Website',
            'messageTitle' => 'Home Page',
            'messageContent' => 'Discover amazing content here!'
        ]);
    }

    public function about()
    {
        return view('pages.about')->with([
            'pageTitle' => 'About Us',
            'messageTitle' => 'About Page',
            'messageContent' => 'Learn more about our team and mission.'
        ]);
    }

    public function contact()
    {
        return view('pages.contact')->with([
            'pageTitle' => 'Contact Us',
            'messageTitle' => 'Contact Page',
            'messageContent' => 'Get in touch with us today!'
        ]);
    }
}