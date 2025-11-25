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
use Illuminate\Support\Facades\Validator;

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

        
        $validation  = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validation->fails()) {
            return response()->json(['error' => 'email is required.'], 422);
        }


       $userData = [
            'email' => $request->email,
            'first_name' => substr($request->email, 0, strpos($request->email, '@')),
            'last_name' => ''
       ];

        // $user = (new User)->newInstance($response->customer, true);
        $user = User::firstOrCreate(
            ['email' => $userData['email']],
            [
            'first_name' => $userData['first_name'],
            'last_name' => $userData['last_name'] ?? "",
            'password' => bcrypt("123456789")
            ]
        );

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
                'magic-link' => $magicLink,
                'message' =>
                $request->has('send_email') && $request->send_email == "1" ?
                    'We’ve sent you a magic link! Please check your email inbox or spam folder.'
                    :
                    'Magic link generated successfully, no email sent. Please use the link to log in.'
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

       $user = User::where('email', $user->email)->first();
       if(!$user){
        return redirect()->route('login')->with('error', 'No user found with this email address.');
       }
        if ($user) {
            Auth::login($user);
            return redirect()->route('user.dashboard');
        } else {
            
            return redirect()->route('login')->with('error', 'Issue error magic link login');
        }
    }
}
