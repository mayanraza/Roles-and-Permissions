<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Validator;




class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view articles'])->only(['index']);
        $this->middleware(['permission:edit articles'])->only(['edit']);
        $this->middleware(['permission:create articles'])->only(['create']);
        $this->middleware(['permission:delete articles'])->only(['destroy']);
    }







    public function index()
    {
        $articles = Article::orderBy("created_at", 'asc')
            ->paginate(5);


        // dd($roles);


        return view("article.index", ["articles" => $articles]);

    }

    public function create()
    {
        $articles = Article::orderBy("title", "asc")->get();

        return view("article.create", ["articles" => $articles]);
    }










    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "text" => "required",
            "author" => "required",
            "title" => "required",
        ]);

        if ($validator->passes()) {
            // dd($request->permissions);
            $articles = Article::create([
                "title" => $request->title,
                "text" => $request->text,
                "author" => $request->author,

            ]);


            return redirect()->route("article.index")->with("success", "Article created successfully..!!");
        } else {
            return redirect()->route("article-create")->withInput()->withErrors($validator);
        }
    }






















    public function edit($id)
    {
        $article = Article::findOrFail($id);
        //
        return view(
            "article.edit",
            ["article" => $article,]
        );

    }
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);



        $validator = Validator::make($request->all(), [
            "text" => "required",
            "author" => "required",
            "title" => "required",
        ]);



        if ($validator->passes()) {
            // dd($request->permissions);

            $article->title = $request->title;
            $article->text = $request->text;
            $article->author = $request->author;
            $article->save();


            return redirect()->route("article.index")->with("success", "Article updated successfully..!!");
        } else {
            return redirect()->route("article-edit")->withInput()->withErrors($validator);
        }
    }







    public function destroy(Request $request)
    {
        $article = Article::findOrFail($request->id);


        if ($article == null) {
            session()->flash('error', "Article not found..!!");

            return response()->json([
                "status" => false,
            ]);
        }


        $article->delete();
        session()->flash('success', "Article deleted successfully..!!");
        return response()->json([
            "status" => true,
        ]);


    }




}
