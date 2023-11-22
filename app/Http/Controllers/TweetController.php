<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TweetController extends Controller
{
    public function index(){
        return Inertia::render('Welcome', [
            'tweets' => Tweet::orderBy('id', 'desc')->get()
        ]);
    }

    public function store(Request $request) {
        // dd($request->tweet);
        $file = null;
        $extension = null;
        $fileName = null;
        $path = '';

        if($request->hasFile('file')) {
            $file = $request->file('file');
            $request->validate(['file' => 'required|mimes:jpg,jpeg,png,mp4']);
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $extension === 'mp4' ? $path = '/videos/' : $path = '/pics/';
        }

        $tweet = new Tweet;

        $tweet->name = 'EM Software LTD';
        $tweet->handle = '@emsoftwareltd';
        $tweet->image = 'https://yt3.ggpht.com/_vquydpLun_nuxj0f7zM5oWTK2NGY2YSNBrjlQYikhfQw_w49D3rksdGjCqxoe4o9uiYiQjR=s88-c-k-c0x00ffffff-no-rj';
        $tweet->tweet = $request->input('tweet');
        if($fileName) {
            $tweet->file = $path . $fileName;
            $tweet->is_video = $extension === 'mp4' ? true : false;
            $file->move(public_path() . $path, $fileName);
        }
        $tweet->comments = rand(5, 500);
        $tweet->retweets = rand(5, 500);
        $tweet->likes = rand(5, 500);
        $tweet->analytics = rand(5, 500);

        $tweet->save();
    }

    /**
     * Remove the specific resource from storage
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $tweet = Tweet::find($id);

        if(!is_null($tweet->file) && file_exists(public_path() . $tweet->file)) {
            unlink(public_path() . $tweet->file);
        }

        $tweet->delete();

        return redirect()->route('tweets.index');
    }
}
