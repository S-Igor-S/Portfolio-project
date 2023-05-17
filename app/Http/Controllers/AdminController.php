<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Foundation\Application as ContractsFoundation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|ContractsFoundation
    {
        $id       = Auth::user()->id;
        $userData = User::find($id);

        return view('admin.index', compact('userData'));
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function profile(): View|Application|Factory|ContractsFoundation
    {
        $id       = Auth::user()->id;
        $userData = User::find($id);

        return view('admin.admin_profile_view', compact('userData'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User Logout Successfully',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function editProfile(): View|Application|Factory|ContractsFoundation
    {
        $id       = Auth::user()->id;
        $userData = User::find($id);

        return view('admin.admin_profile_edit', compact('userData'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeProfile(Request $request): RedirectResponse
    {
        $id             = Auth::user()->id;
        $data           = User::find($id);
        $data->name     = $request->name;
        $data->email    = $request->email;
        $data->username = $request->username;

        if ($request->file('profile_image')) {
            $file = $request->file('profile_image');

            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data->profile_image = $filename;
        }
        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert_type' => 'info'
        );

        return redirect()->route('dashboard.profile')->with($notification);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function changePassword(): View|Application|Factory|ContractsFoundation
    {
        $id       = Auth::user()->id;
        $userData = User::find($id);

        return view('admin.admin_change_password', compact('userData'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validateData = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($validateData['old_password'],$hashedPassword )) {
            $users = User::find(Auth::id());
            $users->password = bcrypt($validateData['new_password']);
            $users->save();

            session()->flash('message','Password Updated Successfully');
            session()->flash('alert_type','info');
        } else {
            session()->flash('message','Old password is not match');
            session()->flash('alert_type','error');
        }

        return redirect()->back();
    }
}
