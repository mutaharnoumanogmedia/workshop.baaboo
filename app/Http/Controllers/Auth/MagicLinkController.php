<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\MagicLinkService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MagicLinkEmail;
use App\Services\UserAccountService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class MagicLinkController extends Controller
{
    //
    protected $magicLinkService;

    public function __construct(MagicLinkService $magicLinkService)
    {
        $this->magicLinkService = $magicLinkService;
    }

    public function send(Request $request)
    {

        $request->validate(['email' => 'required|email']);


        $response = (new UserAccountService())->getUserAccountByEmail($request->email); // response from login.baaboo api

        $response = $response->getData();
        if (!isset($response->customer)) {
            return back()->with('error', 'No customer account was found associated with the provided email address.');
        }

        $customerData = $response->customer;

        // $user = (new User)->newInstance($response->customer, true);
        $user = new User([
            'id' => $customerData->id,
            'name' => $customerData->name ?  $customerData->name : $customerData->first_name . ' ' . $customerData->last_name,
            'email' => $customerData->email,
            'password' => bcrypt("123456789")
        ]);

        $magicLink = $this->magicLinkService->create($user);

        // Dispatch job to send email with magic link
        try {
            if ($request->has('send_email') && $request->send_email == "1") {
                //do nothing
                Mail::to($user->email)->send(new MagicLinkEmail($magicLink));
            }
            // \App\Jobs\SendMagicLinkEmail::dispatch($user->email, $magicLink);
        } catch (\Exception $e) {
            return response(['error', 'We were unable to send the magic link email at this time. Please try again shortly.', 'exception' => $e->getMessage()], 500);
        }

        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $magicLink,
                'message' => 'We’ve sent you a magic link! Please check your email inbox or spam folder.'
            ]);
        }
        return back()->with('success', '<b>We’ve sent you a magic link!</b>
                    <br><br>
                    Please check your email inbox or spam folder. Sometimes it can take a few minutes
                    to arrive. If you don’t see it, try refreshing your inbox</b>');
    }

    public function verify(Request $request, $token)
    {
        $user = $this->magicLinkService->verify($token);

        if (!$user) {
            return redirect()->route('login')->with('error', 'The magic link is invalid or has expired.');
        }

        $credentials = ["email" => $user->email, "password" => bcrypt("123456789")];
        if (Auth::attempt($credentials)) {

            return redirect()->route('user.dashboard');
        } else {
            return back()->with("error", "Issue error magic link login");
        }
    }
}
