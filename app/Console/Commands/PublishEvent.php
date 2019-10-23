<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event;

class PublishEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish:event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'when start date event will publish and at end  date event will close ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $events=Event::all();
        foreach ($events as $event){
            if(strtotime($event->start_date) <= strtotime(now('Africa/cairo')) &&  strtotime(now('Africa/cairo')) <= strtotime($event->end_date) ){  
                $event->update(['is_publish'=>true]);
            }else{
                $event->update(['is_publish'=>false]);
            }
        }
    }
}
