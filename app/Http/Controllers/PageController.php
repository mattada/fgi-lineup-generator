<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Content;
use App\Player;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{

    public function getPage(Request $request, $slug)
    {
        $page = Content::bySlug($slug)->first();

        return view('static-page')->with('page', $page);
    }

    public function getArticle(Request $request, $slug)
    {
        $article = Content::bySlug($slug)->first();

        return view('article')->with('article', $article);
    }

    public function contactUs(Request $request)
    {
        return view('contact-us');
    }

    public function submitContactUs(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'email' => 'required|email',
            'comment' => 'required'
        ]);

        $contact = Contact::create($request->all());

        //TODO: create email template
        Mail::send('emails.contact-us', $contact->toArray(), function ($message) use($contact){

            $message->from('support@fantasygolfinsiders.com');

            $message->to("dalton@activelogiclabs.com");

        });

        return view('contact-thanks')->with('contact', $contact);
    }

    public function ownershipPercentagePredictions(Request $request)
    {
        $players = Player::get();

        return view('own-percent')->with('players', $players);
    }

    public function getColumns(Request $request, $columns)
    {
        if (empty($columns)) {
            return redirect(url('/'));
        }

        $columns = Content::article()->bySection($columns)->orderBy('created_at', 'DESC')->paginate(25);

        return view('columns', ['columns' => $columns]);
    }

    public function images(Request $request, $filepath)
    {
        $filepath = str_replace('public/uploads/', '', $filepath);

        $path = storage_path() . '/app/public/uploads/' . $filepath;

        if(!\Illuminate\Support\Facades\File::exists($path)) abort(404);

        $file = \Illuminate\Support\Facades\File::get($path);
        $type = \Illuminate\Support\Facades\File::mimeType($path);

        $response = \Illuminate\Support\Facades\Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
