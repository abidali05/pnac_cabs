<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ClientSatisficationRequest;
use App\Models\ClientSatisfication;
use App\Models\User;
use App\Models\MessageToCab;
use App\Models\ApplicationStatus;
use App\Models\UserDetail;

class ClientSatisficationController extends Controller
{
    public function clientSatisficationIndex()
    {
        $user_id = auth()->id();
        $user = User::withWhereHas('userDetail', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->first();
        // dd($user->userDetail->designation);
        return view('admin.client_satisfied.index', compact('user'));
    }


    public function clientSatisficationStore(Request $request)
    {
        $data = $request->only((new ClientSatisfication)->getFillable());
        $data['user_id'] = auth()->id();
        ClientSatisfication::updateOrCreate(['user_id' => $data['user_id']], $data);

        return redirect()->back()->with('success', 'Client Satisfaction Form submitted successfully.');
    }

    public function messageNotificationIndex()
    {
        $user = auth()->user();
        // $messages = ApplicationStatus::with('userAccount', 'general')->get();
        // i coeded
        // $messages = ApplicationStatus::with('userAccount', 'general')->whereHas('general', function ($q) use ($user) {
        //     $q->where('user_id', $user->id);
        // })->get(); 
        
        $messages = MessageToCab::where('user_account_id', $user->id)->get();
        // dd($user->id);
        // i coeded
        return view('admin.message.index', compact('messages'));
    }

    public function messageNotificationDetail($id)
    {
        // $message = ApplicationStatus::with('userAccount', 'general')->where('id', $id)->first();
        $message = MessageToCab::where('id', $id)->first();
        
        // dd($messages);
        return view('admin.message.detail', compact('message'));
    }
}

