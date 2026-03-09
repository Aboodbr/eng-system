<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Project;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterUserRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);
            $user->role = $validated['role'];
            $user->save();

            Auth::login($user);
            return $this->redirectUser($user);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'حدث خطأ أثناء إنشاء الحساب، يرجى المحاولة مرة أخرى لاحقًا']);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                return $this->redirectUser(Auth::user());
            }

            return back()->withErrors(['email' => 'بيانات تسجيل الدخول غير صحيحة'])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'حدث خطأ أثناء تسجيل الدخول، يرجى المحاولة مرة أخرى لاحقًا']);
        }
    }

    private function redirectUser($user)
    {
        if (!$user) {
            return redirect()->route('home')->withErrors(['error' => 'حدث خطأ أثناء تسجيل الدخول']);
        }

        return match ($user->role) {
            'admin' => redirect()->route('dashboard.dashboard'),
            'engineer' => redirect()->route('engineer'),
            'secretary' => redirect()->route('secretary'),
            'accountant' => redirect()->route('accountant'),
            default => redirect()->route('home'),
        };
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function adminDashboard()
    {
        $users = User::paginate(10);
        $usersCount = User::count();
    
        $totalProjectsCount = Project::whereNull('parent_id')->count();
    
        return view('dashboard.dashboard', compact('users', 'totalProjectsCount', 'usersCount'));
    }

    // عرض صفحة تعديل المستخدم
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.edit-user', compact('user'));
    }

    // تحديث بيانات المستخدم
    public function updateUser(UpdateUserRequest $request, $id)
    {
        $validated = $request->validated();

        $user = User::findOrFail($id);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        return redirect()->route('dashboard.dashboard')->with('success', 'تم تعديل المستخدم بنجاح!');
    }

    // حذف المستخدم
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        
        // منع المدير من حذف نفسه
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'لا يمكنك حذف حسابك الخاص!');
        }

        $user->delete();
        return redirect()->route('dashboard.dashboard')->with('success', 'تم حذف المستخدم بنجاح!');
    }

    public function engineerDashboard()
    {
        $engineers = User::where('role', 'engineer')->where('id', '!=', Auth::id())->get();
        $receivedProjects = Project::where('receiver_id', Auth::id())->get();
        $sentProjects = Project::where('sender_id', Auth::id())->get();
        return view('dashboard.engineer', compact('engineers', 'receivedProjects', 'sentProjects'));
    }

    public function secretaryDashboard()
    {
        $projects = Project::with('receiver')
            ->where('sender_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        $engineers = User::where('role', 'engineer')->get();
        return view('dashboard.secretary', compact('projects', 'engineers'));
    }

    public function accountantDashboard()
    {
        $transactions = Transaction::paginate(10);
        return view('dashboard.accountant', compact('transactions'));
    }
}