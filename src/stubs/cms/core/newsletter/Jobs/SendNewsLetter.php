<?php

namespace cms\core\newsletter\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


use Mail;
use CmsMail;
use cms\core\newsletter\Mail\NewsLetterMail;
use cms\core\newsletter\Models\NewsLetterModel;

class SendNewsLetter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to;
    protected $contents;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to,$content)
    {
        $this->to = $to;
        $this->contents = $content;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        //CmsMail::setMailConfig();
        Mail::to($this->to)->queue(new NewsLetterMail($this->contents));
    }
}
