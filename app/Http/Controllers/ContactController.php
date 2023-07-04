<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\FooterController;
use App\Models\Contact;
use App\Models\ContentElement;
use App\Models\Footer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ContactController extends Controller
{
    public function index()
    {
        $route = Route::current()->getName();

        $footer = ContentElement::where('name', FooterController::TEMPLATE_NAME)->first();
        $footer->content = json_decode($footer->content);

        return view('frontend.contact', compact('footer', 'route'));
    }

    public function saveMessage(Request $request)
    {
        Contact::insert([
            'name'    => $request->name,
            'email'   => $request->email,
            'subject' => $request->subject,
            'phone'   => $request->phone,
            'message' => $request->message,
        ]);

        $notification = [
            'message'    => 'Your Message Submited Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
}
