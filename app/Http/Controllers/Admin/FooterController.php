<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentElement;
use App\Models\Footer;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Foundation\Application as ContractsApplication;

class FooterController extends Controller
{
    const TEMPLATE_NAME = 'footer';

    public array $removeKeys = ['_token', 'name'];

    public function index(): View|Application|Factory|ContractsApplication
    {
        $userId             = Auth::user()->id;
        $userData       = User::find($userId);
        $element        = ContentElement::where('name', self::TEMPLATE_NAME)
                                        ->first();
        $elementContent = isset($element->content) ? json_decode($element->content) : [];
        $templateName   = self::TEMPLATE_NAME;

        return view('admin.footer.index', compact('elementContent', 'templateName', 'userData'));
    }

    public function update(Request $request){

        $content    = $request->all();
        $name       = $content['name'];
        $content               = array_diff_key($content,
            array_flip($this->removeKeys));
        $updateData['content'] = json_encode($content);

        ContentElement::updateOrCreate(
            ['name' => $name],
            $updateData,
        );
        $notification = array(
            'message' => 'Footer Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

}
