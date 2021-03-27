<?php

namespace App\Http\Controllers;

use App\models\Mail as AppMail;
use App\Mail\UserEmail;
use Illuminate\Http\Request;
use Validator;
use Mail;
use DB;

class MailController extends Controller
{
    public function index(Request $request)
    {
        $condition = $request->condition;
        $term = $request->term;
        $emails = AppMail::with('status')
        ->when($term, function($query, $term) use($condition){
            return $query->where($condition,'like', '%'.$term.'%');
        })
        
        ->latest()
        ->paginate(10);
        return response([
            'success' => true,
            'message' => 'List of Emails found',
            'data' => $emails
        ], 200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to' => 'required|email',
            'from' => 'required|email',
            'subject' => 'required|max:100',
            'text_content' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid data provided',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $mail = new AppMail();
            $mail->to = $request->to;
            $mail->from = $request->from;
            $mail->subject = $request->subject;
            $mail->text_content = $request->text_content;
            $mail->html_content = $request->html_content;
            $mail->status_id = 1;
            $mail->save();

            // save attachment if available
            $file_name = 'attachment';
            if ($request->hasFile($file_name) && $request->file($file_name)->isValid()) {
                $file = $request->file_name;
                $timestamp = str_replace([' ', ':'], '-', date("Ymd"));
                $name = $timestamp .'_'. $request->file($file_name)->getClientOriginalName();
                $request->file($file_name)->move(config('app.external_folder') . '/files/', $name);
                DB::table('attachments')->insert(
                    [
                        'url' => config('app.external_folder') .'/files/'. $name,
                        'mail_id' => $mail->id,
                    ]
                );
                // send attachment mails
                Mail::to(new UserEmail($mail), $mail, function($message)use($mail) {
                    $message->to($email["to"])->subject($email["subject"]);
                    $message->attach(config('app.external_folder') .'/files/'. $name);
                });
            }else{
                // Send emails without attachments
                Mail::to($mail->to)->queue(new UserEmail($mail));
            }

            // Update mail status
            $mail->status_id = 2;
            $mail->save();

            if ($mail) {
                return response()->json([
                    'success' => true,
                    'message' => 'Email Saved Succesfully',
                    'data' => $mail,
                ], 201);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to save email',
                    'data' => null,
                ], 400);
            }
        }
    }

    public function show($id)
    {
        $email = AppMail::whereId($id)->firstorFail();
        return response()->json([
            'success' => true,
            'message' => 'Emails found',
            'data' => $email,
        ], 200);
    }
}
