<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FooterController extends Controller
{

    public function footerSetup()
    {
        $userId       = Auth::user()->id;
        $userData = User::find($userId);
        $footer = Footer::find(1);

        return view('admin.footer.index', compact('footer', 'userData'));
    }

    public function updateFooter(Request $request){

        $footer_id = $request->id;

        Footer::findOrFail($footer_id)->update([
            'number' => $request->number,
            'short_description' => $request->short_description,
            'adress' => $request->adress,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'copyright' => $request->copyright,

        ]);
        $notification = array(
            'message' => 'Footer Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

}
