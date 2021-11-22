<?php

namespace App\Http\Controllers\director;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Depository;
use App\Roles\UserRoles;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(6);
        $roles = UserRoles::getRolesList();
        return view('crm.director.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $user = new User();
        $depositories = Depository::select(['id','name'])->get();
        return view('crm.director.users.create', compact('user', 'depositories'));
    }

    public function store(Request $request)
    {
        $userData = $this->validateUserData($request);

        $user = User::create($userData);
        if ($user) {
            return redirect()->route('director.users.edit', $user->id)
                ->with('success', 'Фойдаланувчи '. $user->name. ' муваффақиятли яратилди!' );
        }
        return redirect()->back()->withErrors('Номаълум хатолик рўй берди, қайта уриниб кўринг');
    }

    public function edit(User $user)
    {
        $depositories = Depository::select(['id','name'])->get();
        return view('crm.director.users.create', compact('user', 'depositories'));
    }

    public function update(Request $request, User $user)
    {
        $userData = $this->validateUserData($request);
        $updated = $user->update($userData);

        if ($updated) {
            return redirect()->back()
                ->with('success', 'Фойдаланувчи '. $user->name. ' маълумотлари муваффақиятли таҳрирланди!' );
        }
        return redirect()->back()->withErrors('Номаълум хатолик рўй берди, қайта уриниб кўринг');
    }

    public function delete(User $user)
    {
        return view('crm.director.dashboard');
    }

    protected function validateUserData($request)
    {
        $isCreatingNew = (bool) $request->method() === 'post';
        $requiredIfCreate = $isCreatingNew ? 'required' : 'nullable';

        $validated = $request->validate([
            'name' => $requiredIfCreate.'|string|max:255|min:3',
            'email' => [$requiredIfCreate,'email', Rule::unique('users')->ignore($request->input('id'))],
            'password' => [$requiredIfCreate, 'confirmed', Password::min(8)->mixedCase()->letters()->numbers()->symbols()],
            'telegram_id' => 'nullable|string|max:30',
            'roles' => 'nullable|array'
        ]);

        if ($isCreatingNew) {
            $validated['remember_token'] = Str::random(10);
        }
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        return $validated;
    }
}
