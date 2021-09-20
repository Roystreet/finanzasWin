<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;
use File;


class backUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:backup';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'back up sistemas finanzas.';

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
$name = "SYS-PE-FINANAZAS-PRODUCION-".date("Y").date("m").date("d").date("H").date("i").date("s").'.backup';
$path = '/var/www/win-system/storage/logs/';
$salida = shell_exec('PGPASSWORD="yjlcofok2vb7hobl" pg_dump -Fc -v -h db-peru-do-user-4438451-0.a.db.ondigitalocean.com -p 25060 -U doadmin > '.$path.$name.' 3eWFkdVtvK');



  $fileData = File::get($path.$name);

  Storage::cloud()->put($name , $fileData);
unlink('storage/logs/'.$name);

    }
}
