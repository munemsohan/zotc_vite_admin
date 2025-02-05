<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscriber;
use Mail;
use App\Mail\EmailManager;
use App\Models\ZotcSetting;

class NewsletterController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:send_newsletter'])->only('index');
    }

    public function index(Request $request)
    {
        $users = User::all();
        $subscribers = Subscriber::all();
        return view('backend.marketing.newsletters.index', compact('users', 'subscribers'));
    }

    public function send(Request $request)
    {
        if (env('MAIL_USERNAME') != null) {
            //sends newsletter to selected users
            if ($request->has('user_emails')) {
                foreach ($request->user_emails as $key => $email) {
                    $array['view'] = 'emails.newsletter';
                    $array['subject'] = $request->subject;
                    $array['from'] = env('MAIL_FROM_ADDRESS');
                    $array['content'] = $request->content;

                    try {
                        Mail::to($email)->queue(new EmailManager($array));
                    } catch (\Exception $e) {
                        //dd($e);
                    }
                }
            }

            //sends newsletter to subscribers
            if ($request->has('subscriber_emails')) {
                foreach ($request->subscriber_emails as $key => $email) {
                    $array['view'] = 'emails.newsletter';
                    $array['subject'] = $request->subject;
                    $array['from'] = env('MAIL_FROM_ADDRESS');
                    $array['content'] = $request->content;

                    try {
                        Mail::to($email)->queue(new EmailManager($array));
                    } catch (\Exception $e) {
                        //dd($e);
                    }
                }
            }
        } else {
            flash(translate('Please configure SMTP first'))->error();
            return back();
        }

        flash(translate('Newsletter has been send'))->success();
        return redirect()->route('admin.dashboard');
    }

    public function testEmail(Request $request)
    {
        // Validate email input
        $request->validate([
            'email' => 'required|email'
        ]);

        try {
            // Apply mail settings
            $mailSettings = configureMailSettings();

            // Prepare email data
            $emailData = [
                'view'    => 'emails.newsletter',
                'subject' => "SMTP Test",
                'from'    => $mailSettings['mail_from_address'] ?? 'default@example.com',
                'content' => "This is a test email from zotc settings."
            ];

            // Send email using queued job
            Mail::to($request->email)->queue(new EmailManager($emailData));

            // dd(config('mail.mailers.smtp.port', '587'));

            // Flash success message
            flash(translate('An email has been sent successfully!'))->success();
        } catch (\Exception $e) {
            // Handle exceptions, such as failed mail setup or sending issues
            flash(translate('Failed to send email: ') . $e->getMessage())->error();
            return back()->withInput();
        }

        return back();
    }
}
