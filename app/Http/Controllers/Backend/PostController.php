<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        $new_tag = new Tag();
//        $new_tag->name = 'Ruby';
//        $new_tag->save();
//        $new_tag = new Tag();
//        $new_tag->name = 'Python';
//        $new_tag->save();
//        $new_tag = new Tag();
//        $new_tag->name = 'Perl';
//        $new_tag->save();
//        $new_tag = new Tag();
//        $new_tag->name = 'JavaScript';
//        $new_tag->save();
//        $new_tag = new Tag();
//        $new_tag->name = 'Anime';
//        $new_tag->save();
//        $new_tag = new Tag();
//        $new_tag->name = 'Software';
//        $new_tag->save();
//        $new_tag = new Tag();
//        $new_tag->name = '😀Fun😀';
//        $new_tag->save();
//        $new_tag = new Tag();
//        $new_tag->name = 'Hardware';
//        $new_tag->save();
//        return 'tags created!';
        $posts = Post::with('tags')->paginate(5);
        return view('backend.post.index',['post'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $categories = Category::all();
       // $tags = Tag::all();
        return view('backend.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['bail','required','min:2','max:500'],
            'description' => ['bail','required','min:2','max:500'],
            'text' => ['bail','required','min:2','max:30000'],
            'category' => ['bail','required','exists:categories,id'],
            'mainImg' => ['bail','required','mimes:jpg,jpeg,png,gif,webp','max:5048'],
            'tags' => ['bail','required'],
        ]);

        foreach (array_column(json_decode(request()->tags), 'code') as $tag){
            if (!Tag::find($tag))
                return redirect()->back()->withErrors(["tags_validate"=>"Ошибка валидации тегов!"]);
        }

//        dd(request()->mainImg);
        // 10 +  '_' + 239 + '.' + 4 = 255
        $newMainImgName = time() . '_' . mb_substr(request()->name, 0, 239) . '.' . request()->mainImg->extension();
        request()->mainImg->move(public_path('images/post/main'),$newMainImgName);
//dd(request());
       // dd(array_column(json_decode(request()->tags), 'code'));

//        $new_post = new Post();
//        $new_post->name = 'first_post';
//        $new_post->description = 'desc of first_post';
//        $new_post->text = 'Если вам нужно обновить существующую строку в промежуточной таблице ваших отношений, вы можете использовать этот updateExistingPivotметод. Этот метод принимает внешний ключ промежуточной записи и массив атрибутов для обновления:';
//        $new_post->mainImg = "No image select";
//        $new_post->category = request()->category;
//        $new_post->save();
//        $new_post->tags()->sync(array_column(json_decode(request()->tags), 'code'));

        $new_post = Post::create([
            'name' => request()->name,
            'description' => request()->description,
            'text' => request()->text,
            'category' => request()->category,
            'mainImg' => $newMainImgName
        ]);

        $new_post->tags()->sync(array_column(json_decode(request()->tags), 'code'));

        return redirect()->back()->with(['success'=>'Пост создан!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //dd($post->tags()->get());
        return view('backend.post.edit',['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        return redirect()->back()->with(['success'=>'Пост был успешно обновлён!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back()->with(['success'=>'Пост был успешно удалён!']);
    }
}
