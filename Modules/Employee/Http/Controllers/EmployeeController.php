<?php

namespace Modules\Employee\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Employee\Entities\Employee;
use Throwable;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('password.confirm')->only('edit');
    }

    protected function validate_data($request, $employee_id = null, $user_id = null)
    {
        $validate = [
            "employee_name" => "bail|required|string|max:191",
            "employee_position" => "nullable|string|max:191",
            "employee_phone" => "required|digits_between:8,20|unique:employees,employee_phone,{$employee_id},employee_id",
            "email" => "required|string|max:191|email|unique:users,email,{$user_id},id",
            "employee_address" => "nullable|string|max:191",
        ];

        return $request->validate($validate);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $employees = Employee::all();

        return view('employee::index', ['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('employee::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validated_data = $this->validate_data($request);

        try {
            // Create new user
            $user = User::with('relatedEmployee')->create([
                'name' => $validated_data['employee_name'],
                'email' => $validated_data['email'],
                'password' => Hash::make('Password!'),
            ]);
            $user->assignRole(['admin']);

            // Create new emp
            $employee = new Employee([
                'employee_name' => $validated_data['employee_name'],
                'employee_phone' => $validated_data['employee_phone'],
                'employee_position' => $validated_data['employee_position'],
                'employee_address' => $validated_data['employee_address'],
            ]);
            $user->relatedEmployee()->save($employee);

            return redirect()->route('employee.index')->with('success', 'Berhasil menambah karyawan baru. Passwordnya adalah Password!');
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('employee::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param Employee $employee
     * @return Renderable
     */
    public function edit(Employee $employee): Renderable
    {
        return view('employee::edit', ['employee' => $employee->loadMissing('relatedUser')]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Employee $employee
     * @return RedirectResponse
     */
    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $validated_data = $this->validate_data($request, $employee->employee_id, $employee->user_id);

        try {
            DB::beginTransaction();

            $employee->update($validated_data);
            $employee->loadMissing('relatedUser');
            $employee->relatedUser->name = $validated_data['employee_name'];
            $employee->relatedUser->email = $validated_data['email'];
            $employee->relatedUser->save();
            $employee->relatedUser->syncRoles(['admin']);

            DB::commit();

            return redirect()->route('employee.index')->with('success', 'Berhasil memperbarui informasi karyawan');
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Employee $employee
     * @return RedirectResponse
     */
    public function destroy(Employee $employee)
    {
        try {
            DB::beginTransaction();

            $employee->delete();
            $employee->loadMissing('relatedUser');
            $employee->relatedUser->removeRole('admin');
            $employee->relatedUser->delete();

            DB::commit();

            return redirect()->route('employee.index')->with('success', 'Berhasil menghapus karyawan');
        } catch (Throwable $e) {
            DB::rollBack();

            return back()->withErrors($e->getMessage())->withInput();
        }
    }
}
