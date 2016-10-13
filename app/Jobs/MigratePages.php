<?php

namespace App\Jobs;

use App\Content;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class MigratePages extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::connection('fgi_pro')->table('wp_posts')->where('post_type', 'page')->chunk(2, function($pages) {

            foreach ($pages as $page) {

                if (!empty($page->post_name)) {

                    $pattern = "/.*cointent_lockedcontent.*/";

                    $content = new Content();

                    $content->type = 'page';
                    $content->title = $page->post_title;
                    $content->title_slug = $page->post_name;
                    $content->preview = preg_replace('/(\r\n|\r|\n)/', '</p><p>', trim(preg_split($pattern, $page->post_content)[0]));
                    $content->content = preg_replace('/(\r\n|\r|\n)/', '</p><p>', trim(preg_replace($pattern, "", $page->post_content)));
                    $content->subscription_group = 'fgi';
                    $content->created_at = $page->post_date;

                    $content->save();

                }

            }

        });
    }
}