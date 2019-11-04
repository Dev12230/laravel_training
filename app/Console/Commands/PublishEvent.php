<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Illuminate\Support\Arr;

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
    private $firebase,$database;

    public function __construct()
    {
        parent::__construct();

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/FirebaseKey.json');
        $this->firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://trainingfirebase-e35e2.firebaseio.com/')->create();
        $this->database = $this->firebase ->getDatabase();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $events=Event::all();
        foreach ($events as $event) {
            if (strtotime($event->start_date) <= strtotime(now('Africa/cairo')) &&  strtotime(now('Africa/cairo')) <= strtotime($event->end_date)) {
                $event->update(['is_publish'=>true]);
                $this->insertInFirebase($event,$this->getStoredEvents());
            } else {
                $event->update(['is_publish'=>false]);
                $this->updateFirebase($event,$this->getStoredEvents());
            }
        }
    }

    public function insertInFirebase($event,$eventsIds){
        if(!in_array($event['id'],$eventsIds)){
            $this->database->getReference('events')->push($event->toArray());
        }
    }

    public function updateFirebase($event,$eventsIds){
        if(in_array($event['id'],$eventsIds)){
            $idIndex=array_search($event['id'],$eventsIds);
            $Key=$this->database->getReference('events')->getChildKeys();
            $this->database->getReference('events/'.$Key[$idIndex])->remove();
        }
    }

    public function getStoredEvents(){
        $events=$this->database->getReference('events')->getValue();
        $events ? $ids=Arr::pluck($events,'id') :$ids=[];
        return $ids;
    }
}
