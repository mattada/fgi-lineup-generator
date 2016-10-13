<?php

namespace App\Jobs;

use App\Content;
use App\Jobs\Job;
use App\Traits\DatabaseRoutingTrait;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class MigratePosts extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DatabaseRoutingTrait;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->setDatabaseConnection('fgi_pro');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
//    public function handle()
//    {
//        $columns = DB::connection('fgi_pro')->select("DESCRIBE wp_posts");
//
//        $types = array('post', 'attachment');
//        $selectArray = array();
//
//        foreach ($types as $table => $type) {
//
//            foreach ($columns as $column) {
//
//                $selectArray[] = "{$type}.{$column->Field} as {$type}_{$column->Field}";
//
//            }
//
//        }
//
//        $selectString = implode(", ", $selectArray);
//
//        $sql = "select {$selectString}, wp_users.*
//                from wp_posts as post
//                join wp_users on wp_users.id = post.post_author
//                join wp_posts as attachment on attachment.post_parent = post.ID
//                join wp_term_relationships on post.ID = wp_term_relationships.object_id
//                join wp_term_taxonomy on wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
//                join wp_terms on wp_term_taxonomy.term_id = wp_terms.term_id
//                where attachment.post_type = 'attachment'";
//
//        DB::connection('fgi_pro')
//            ->table('wp_posts as post')
//            ->select(DB::raw("{$selectString}, wp_users.*, wp_terms.*"))
//            ->join('wp_users', 'wp_users.id', '=', 'post.post_author')
//            ->join('wp_posts as attachment', 'attachment.post_parent', '=', 'post.ID')
//            ->join('wp_term_relationships', 'post.ID', '=', 'wp_term_relationships.object_id')
//            ->join('wp_term_taxonomy', 'wp_term_relationships.term_taxonomy_id', '=', 'wp_term_taxonomy.term_taxonomy_id')
//            ->join('wp_terms', 'wp_term_taxonomy.term_id', '=', 'wp_terms.term_id')
//            ->where('attachment.post_type', 'attachment')
//            ->chunk(2, function($posts) {
//
//                foreach ($posts as $post) {
//
//
//
//                    $content = Content::where('title', $post->post_post_title)->first();
//
//                    if ($content) {
//
//                        $this->buildContent($content, $post);
//
//                    } else {
//
//                        $content = new Content();
//
//                        $this->buildContent($content, $post);
//
//                    }
//
////
////                    $content = new Content();
////
////                    $content->type = 'article';
////                    $content->title = $post->post_post_title;
////                    $content->title_slug = str_slug($post->post_post_title);
////                    $content->thumbnail = str_replace("http://fantasygolfinsider.com/wp-content/", "", $post->attachment_guid);
////                    $content->preview = preg_replace('/(\r\n|\r|\n)/', '</p><p>', trim(preg_split($pattern, $post->post_post_content)[0]));
////                    $content->content = preg_replace('/(\r\n|\r|\n)/', '</p><p>', trim(preg_replace($pattern, "", $post->post_post_content)));
////                    $content->subscription_group = 'fgi';
////                    $content->section = $post->name;
////                    $content->created_at = $post->post_post_date;
//
//                    $content->save();
//                }
//
//            });
//
//    }


    public function handle()
    {
        DB::connection('fgi_pro')
            ->table('wp_posts')
            ->select(DB::raw("wp_posts.*, wp_users.display_name, wp_terms.*"))
            ->join('wp_users', 'wp_users.id', '=', 'wp_posts.post_author')
            ->join('wp_term_relationships', 'wp_posts.ID', '=', 'wp_term_relationships.object_id')
            ->join('wp_term_taxonomy', 'wp_term_relationships.term_taxonomy_id', '=', 'wp_term_taxonomy.term_taxonomy_id')
            ->join('wp_terms', 'wp_term_taxonomy.term_id', '=', 'wp_terms.term_id')
            ->where('post_type', 'post')
            ->where('post_status', 'publish')
            ->chunk(10, function($posts) {

            foreach ($posts as $post) {

                $attachment = DB::connection('fgi_pro')->table('wp_posts')->where('post_type', 'attachment')->where('post_parent', $post->ID)->orderBy('post_date', 'DESC')->limit(1)->first();

                $pattern = "/.*cointent_lockedcontent.*/";

                $content = new Content();

                $content->type = 'article';
                $content->title = $post->post_title;
                $content->title_slug = $post->post_name;
                $content->thumbnail = !empty($attachment->guid) ? str_replace("http://fantasygolfinsider.com/wp-content/uploads/", "", $attachment->guid) : null;
                $content->preview = preg_replace('/(\r\n|\r|\n)/', '</p><p>', trim(preg_split($pattern, $post->post_content)[0]));
                $content->content = preg_replace('/(\r\n|\r|\n)/', '</p><p>', trim(preg_replace($pattern, "", $post->post_content)));
                $content->subscription_group = 'fgi';
                $content->section = $this->defineSection($post->name);
                $content->author = $post->display_name;
                $content->created_at = $post->post_date;

                $content->save();

            }

        });
    }


    private function defineSection($name)
    {
        $section = null;

        switch ($name) {
            case "Expert Columns":
                $section = 'expert';
                break;
            case "Fantasy Golf Strategy":
                $section = 'strategy';
                break;
            case "Fantasy Golf Preview":
                $section = 'preview';
                break;
            case "Fantasy Golfer of the week":
                $section = 'golfer-of-the-week';
                break;
            default:
                $section = null;
                break;
        }

        return $section;
    }

}
