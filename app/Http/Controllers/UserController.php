<?php

namespace App\Http\Controllers;

use App\Models\Reviewfiles;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ReviewModel;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


use Mail;

class UserController extends Controller
{
    public function index()
    {
        $review = new ReviewModel();
        $cnt = $review->count();

        return view('welcome',[ 'num_review'=>$cnt,'all_review'=>$review->all() ]);
    }

    public function review($id)
    {
        $rev = ReviewModel::find(($id));

        $subject = $rev->subject;
        $textreview = $rev->message;
        $user_id_review = $rev->user_id;


        $revimg = Reviewfiles::where('review_id', '=', $rev->id)->first();

        $filePath = '';
        if ($revimg) {
            $filePath = $revimg->filePath;

        }

        return view('user.review',compact('subject','textreview','filePath','user_id_review'));
     }

    public function create()
    {
        return view('user.create');
    }

    public function add_review(Request $request)
    {
        
        $valid = $request->validate([
            'subject' => 'required|max:255',
            'message' => 'required',
            'file' => 'required|file|mimes:jpg|max:1024',
        ]);


        $review = new ReviewModel();

        $review->subject = $request->input('subject');
        $review->message = $request->input('message');
        
        $review->email = Auth::user()->email;
        $review->user_id = Auth::user()->id;
        $review->save();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();

            $filePath = $file->storeAs('uploads', $fileName,'public');

        
            $reviewfile = new Reviewfiles();

            $reviewfile->user_id = Auth::user()->id;
            $reviewfile->review_id = $review->id;
            $reviewfile->filename = $fileName;
            $reviewfile->filePath = $filePath;

            $reviewfile->save();
        }    

        return redirect()->route('dashboard');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed']
        ]);

        $user = User::create($request->all());
        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    public function login()
    {
        return view('user.login');
    }

    public function loginAuth(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required',],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard')->with('success', 'Welcome, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Wrong login or password',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    
    public function dashboard()
    {
        $myR = new ReviewModel();
        return view('user.dashboard',['review' => $myR->all()]);
    }

    public function forgotPasswordStore(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPasswordUpdate(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }


    public function send()
    {
       
        Mail::send(['text' => 'user.mail'],['name','web dev blog'], function($message){
            $message->to('antanenkomail@gmail.com','To web blog')->subject('test email');
            $message->from('antanenkomail@gmail.com','web dev blog');
        });

        return view('user.mail');
        
    }
}
