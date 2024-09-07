<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Auth;
use App\Models\Nationality;
use App\Models\Problem;
use App\Models\ClinicsService;


class SettingsController  extends Controller
{
     // use Authorizable;
    protected string $exportClass = '\App\Exports\CustomerExport';

    public function __construct()
    {
        $this->module_title = 't.Settings';

        view()->share([
            'module_title' => $this->module_title,
            
        ]); 
        
    }

    public function index()
    {
        $nationalities = Nationality::all();
        $problems = Problem::all();
        $services = ClinicsService::all();
        return view('backend.systemSettings.index', compact('nationalities', 'problems', 'services'));
    }

    public function storeNationality(Request $request)
    {
          $request->validate(['Nationality' => 'required|string|max:255']);
         Nationality::create(['name' => $request->get('Nationality')]);
         return redirect()->route('settings-index', ['tab' => 'nationalities']);
    }

    public function storeProblem(Request $request)
    {
         $request->validate(['Problem' => 'required|string|max:255']);
         Problem::create(['name' => $request->get('Problem')]);
         return redirect()->route('settings-index',['tab' => 'problems']);
    }

    public function storeService(Request $request)
    {
         $request->validate(['service' => 'required|string|max:255']);
         ClinicsService::create(['name' => $request->get('service')]);
         return redirect()->route('settings-index' ,['tab' => 'services']);
    }
    
}
