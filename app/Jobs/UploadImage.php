<?php

namespace App\Jobs;

use File;
use Image;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $disk = $this->user->disk;
        $filename = $this->user->user_img;
        $original_file = storage_path() . '/uploads/original/'. $filename;

        try{
            Image::make($original_file)
                ->fit(600, 800, function($constraint){
                    $constraint->aspectRatio();
                })
                ->save($large = storage_path('uploads/large/'. $filename));

            Image::make($original_file)
                ->fit(200, 250, function($constraint){
                    $constraint->aspectRatio();
                })
                ->save($thumbnail = storage_path('uploads/thumbnail/'. $filename));

            if(Storage::disk($disk)->put('uploads/images/original/'.$filename, fopen($original_file, 'r+'))){
                File::delete($original_file);
            }

            if(Storage::disk($disk)->put('uploads/images/large/'.$filename, fopen($large, 'r+'))){
                File::delete($large);
            }

            if(Storage::disk($disk)->put('uploads/images/thumbnail/'.$filename, fopen($thumbnail, 'r+'))){
                File::delete($thumbnail);
            }

            $this->user->update([
                'upload_successful' => true
            ]);

        }catch(\Exception $e){
            \Log::error($e->getMessage());
        }
    }
}
