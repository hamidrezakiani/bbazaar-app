<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailSender extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The demo object instance.
     *
     * @var Data
     */
    public $data;
    public $bladeTemplate;


    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct($data, $bladeTemplate = 'mail_templates.user_registration')
    {
        $this->data = $data;
        $this->bladeTemplate = $bladeTemplate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this/*->from(["someone@somewhere.com"])*/
            ->view($this->bladeTemplate);
         /*   ->with(
                [
                    'testVarOne' => '1',
                    'testVarTwo' => '2',
                ])*/
            /*->attach(public_path('/uploads').'/default-image.JPG', [
                'as' => 'default-image.JPG',
                'mime' => 'image/jpeg',
            ])*/
    }
}
