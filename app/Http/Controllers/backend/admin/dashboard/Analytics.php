<?php

namespace App\Http\Controllers\backend\admin\dashboard;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Analytics extends Controller
{
  public function index(Request $request)
  {
    return view('backend.admin.content.dashboard.dashboards-analytics');
  }

}
