<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Department;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $departments = Department::active()->orderBy('name')->get();
        return view('auth.register', compact('departments'));
    }

    public function register(Request $request)
    {
        $role = $request->input('role');
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:student,faculty,admin',
            'terms' => 'required|accepted',
        ];

        // Add role-specific rules
        if ($role === 'student') {
            $rules['student_id'] = 'required|string|unique:users|regex:/^[0-9]{3}-[0-9]{2}-[0-9]{4}$/';
            $rules['admission_semester'] = 'required|in:Spring,Summer,Fall';
            $rules['admission_year'] = 'required|integer|min:2020|max:' . (date('Y') + 1);
            $rules['department_id'] = 'required|exists:departments,id';
        } elseif ($role === 'faculty') {
            $rules['department_id'] = 'required|exists:departments,id';
        }

        $validator = Validator::make($request->all(), $rules);

        // Custom validation messages
        $validator->setCustomMessages([
            'student_id.regex' => 'Student ID must be in the format XXX-XX-XXXX (e.g., 221-15-4750)',
            'student_id.unique' => 'This Student ID is already registered',
            'department_id.required' => 'Please select your department',
            'department_id.exists' => 'Selected department is invalid',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Email validation by role
        $email = $request->input('email');
        if ($role === 'student' && !preg_match('/^[^@]+@diu\\.edu\\.bd$/', $email)) {
            return redirect()->back()->withErrors(['email' => 'Student email must end with @diu.edu.bd'])->withInput();
        }
        if ($role === 'faculty' && !preg_match('/^[a-zA-Z]+\\.[a-zA-Z]+@diu\\.edu\\.bd$/', $email)) {
            return redirect()->back()->withErrors(['email' => 'Faculty email must be in the format name.dept@diu.edu.bd'])->withInput();
        }
        if ($role === 'admin' && $email !== 'admin@diu.edu.bd') {
            return redirect()->back()->withErrors(['email' => 'Admin email must be admin@diu.edu.bd'])->withInput();
        }

        // Additional validation for semester based on department
        if ($role === 'student') {
            $department = Department::find($request->input('department_id'));
            $semester = $request->input('admission_semester');
            
            if ($department && $department->semester_type === 'bisemester' && $semester === 'Summer') {
                return redirect()->back()->withErrors([
                    'admission_semester' => 'Summer semester is not available for bi-semester departments'
                ])->withInput();
            }
        }

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $email;
        $user->password = Hash::make($request->input('password'));
        $user->role = $role;

        // Add department for students and faculty
        if ($role === 'student' || $role === 'faculty') {
            $user->department_id = $request->input('department_id');
        }

        // Add student-specific fields
        if ($role === 'student') {
            $user->student_id = $request->input('student_id');
            $user->admission_semester = $request->input('admission_semester');
            $user->admission_year = $request->input('admission_year');
        }

        $user->save();

        return redirect()->route('login')->with('success', 'Registration successful! Please log in to access your dashboard.');
    }
}
