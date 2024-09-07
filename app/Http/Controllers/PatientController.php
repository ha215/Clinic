<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Response;


class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Page Title
        $this->module_title = 'profile.title';

        // module name
        $this->module_name = 'users';

        // directory path of the module
        $this->module_path = 'users';

        // module icon
        $this->module_icon = 'fa-solid fa-users';

        // module model name, path
        $this->module_model = "App\Models\User";

        view()->share([
            'module_title' => $this->module_title,
            'module_icon' => $this->module_icon,
            'module_name' => $this->module_name,
        ]);
    }

    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $roles = Role::get();
        $modules = config('constant.MODULES');
        $permissions = Permission::get();
        $module_action = 'List';

        return view('permission-role.permissions', compact('roles', 'permissions', 'module_title', 'module_name', 'module_action', 'modules'));
    }

    public function store(Request $request, Role $role_id)
    {
        if (env('IS_DEMO')) {
            return redirect()->back()->with('error', __('messages.permission_denied'));
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = Permission::get()->pluck('name')->toArray();
        $role_id->revokePermissionTo($permissions);
        if (isset($request->permission) && is_array($request->permission)) {
            foreach ($request->permission as $permission => $roles) {
                $pr = Permission::findOrCreate($permission);
                $role_id->permissions()->syncWithoutDetaching([$pr->id]);
            }
        }

        \Artisan::call('cache:clear');

        return redirect()->route('backend.permission-role.list')->withSuccess(__('permission-role.save_form'));
    }
    public function downloadTemplate()
    {
        // Define the CSV headers
        $headers = [
            'first_name', 'email', 'mobile', 'gender', 'date_of_birth', 
             'civil_id', 'departments_id', 'employee_id', 
            'pme_month', 'pme_year'
        ];

        // Create a callback to generate the CSV content
        $callback = function() use ($headers) {
            $file = fopen('php://output', 'w');
            // Write the header row
            fputcsv($file, $headers);
            // Add an example row (optional)
            fputcsv($file, [
                'patient', 'patient67@example.com', '1234567890', 'Male', 
                '1980-01-01', 'user', '12345678', '1', 'EMP001', 
                '1', '1'
            ]);
            fclose($file);
        };

        // Return the response as a CSV download
        return Response::stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="patient_template.csv"',
        ]);
    }

    
}
