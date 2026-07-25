<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('frontend.pages.home.index');
    }

    public function blogs()
    {
        return view('frontend.pages.blogs.index');
    }

    public function blogDetail()
    {
        return view('frontend.pages.blogs.show');
    }

    public function crmVendor()
    {
        return view('frontend.pages.vendors.crm');
    }

    public function vendorDetail()
    {
        return view('frontend.pages.vendors.show');
    }
}




