<?php 

namespace App\Mail;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $status;

    public function __construct(Project $project, $status)
    {
        $this->project = $project;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject("Project '{$this->project->title}' Status: {$this->status}")
                    ->view('emails.project_status');
    }
}
