<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        return view('index');
    }

    public function register(){
        return view('register');
    }

    public function login(Request $req){
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($req->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $is_match =  Auth::attempt($req->only('email', 'password')); // using this remenmber me we can keep user logged in even after closing the browser
        if(!$is_match){
            return redirect()->back()->withErrors(['credentials' => 'Invalid Credentials'])->withInput();
        }
        // on successful login redirect to dashboard
        return redirect()->route('home');

    }

    public function create(Request $req){
        $rules = [
            'name' => 'required', 'email' => 'required|unique:users', 'password' => 'required'
        ];

        $is_validate = Validator::make($req->all(), $rules);

        if($is_validate->fails()){
            return redirect()->back()->withErrors($is_validate)->withInput();
        }

        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->save();
        Auth::login($user);
        return redirect()->route('home');

    }

    public function show(){
        $posts = POST::with('comments')->with('tags')->select('id', 'title')->get();
        // foreach($posts as $post){
        //     echo "Post: " . $post->title . "<br>";
        //     foreach ($post->comments as $comment) {
        //         echo "- " . $comment->content . "<br>";
        //     }
        // }

        // foreach($posts as $post){
            // echo "Post" . $post->title . '<br>';
            // foreach($post->tags as $tag){
            //     echo "<div class='tag'>" . $tag->tag . '</div>'  ;
            // }
            // echo '<pre>';
            // print_r($post);
            // echo '</pre>';
        // }
        return response()->json($posts);

        // dd($posts);
        // print_r($data);
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
