<?php

namespace App\Http\Controllers\Sliders;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactAdminController extends Controller
{

    public function index()
    {
        $userId   = Auth::user()->id;
        $userData = User::find($userId);
        $contacts = Contact::latest()->get();

        return view('admin.contact.index', compact('contacts', 'userData'));
    }


    public function deleteMessage($id)
    {
        Contact::findOrFail($id)->delete();

        $notification = [
            'message'    => 'Your Message Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

}
