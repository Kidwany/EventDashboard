<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendContract extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    protected $contract;
    /**
     * @var
     */
    protected $user;
    /**
     * @var
     */
    protected $event;
    /**
     * @var
     */
    protected $application_id;


    /**
     * SendContract constructor.
     * @param $contract
     * @param $user
     * @param $event
     * @param $application_id
     */
    public function __construct($contract, $user, $event, $application_id)
    {
        $this->contract = $contract;
        $this->user = $user;
        $this->event = $event;
        $this->application_id = $application_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contract')
            ->subject('توثيق العقد')
            ->from('info@hemmtk.com', 'توثيق العقد')
            ->attach($this->contract)
            ->with('user', $this->user)
            ->with('event', $this->event)
            ->with('application_id', $this->application_id);
    }
}
