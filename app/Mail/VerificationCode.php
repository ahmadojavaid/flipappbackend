<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerificationCode extends Mailable
{
    use Queueable, SerializesModels;
    public $user_obj;
    public $code;
    public $reset_password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_obj,$code,$reset_password=0)
    {
        $this->user_obj = $user_obj;
        $this->code = $code;
        $this->reset_password = $reset_password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->reset_password == 0){
            $code = $this->code;
            $user_obj = $this->user_obj;
            return $this->view('email_templates.verify-account',compact('code','user_obj'));   
        }else{
            $code = $this->code;
            $user_obj = $this->user_obj;
            return $this->view('email_templates.reset-password',compact('code','user_obj'));
        }
    }
}
