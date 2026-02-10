<?php

namespace App\Http\Controllers\dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Analytics extends Controller
{
  public function index(Request $request)
  {
    return view('content.dashboard.dashboards-analytics');
  }

}
