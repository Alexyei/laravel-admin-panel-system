<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use DOMDocument;
use DOMNode;
use FilesystemIterator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $articleImgPath = '/images/post/article/';

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
        $posts = Post::with('tags')->orderBy('id','desc')->paginate(5);
        return view('backend.post.index', ['posts' => $posts]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['bail', 'required', 'min:2', 'max:500'],
            'description' => ['bail', 'required', 'min:2', 'max:500'],
            'text' => ['bail', 'required', 'min:2', 'max:30000'],
            'category' => ['bail', 'required', 'exists:categories,id'],
            'mainImg' => ['bail', 'required', 'mimes:jpg,jpeg,png,gif,webp', 'max:5048'],
            'tags' => ['bail', 'required'],
        ]);

        foreach (array_column(json_decode(request()->tags), 'code') as $tag) {
            if (!Tag::find($tag))
                return redirect()->back()->withErrors(["tags_validate" => "Ошибка валидации тегов!"]);
        }

//        dd(request()->mainImg);
        // 10 +  '_' + 239 + '.' + 4 = 255
        $newMainImgName = time() . '_' . mb_substr(request()->name, 0, 239) . '.' . request()->mainImg->extension();
        request()->mainImg->move(public_path('images/post/main'), $newMainImgName);
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
        $new_post->text = $this->articleImgsSync($new_post->text, $this->articleImgPath . $new_post->id.'/');
        $new_post->save();
        return redirect()->back()->with(['success' => 'Пост создан!']);
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

        return view('frontend.post', ['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {

        //dd($post->tags()->get());
        return view('backend.post.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'name' => ['bail', 'required', 'min:2', 'max:500'],
            'description' => ['bail', 'required', 'min:2', 'max:500'],
            'text' => ['bail', 'required', 'min:2', 'max:30000'],
            'category' => ['bail', 'required', 'exists:categories,id'],
            'mainImg' => ['bail', 'mimes:jpg,jpeg,png,gif,webp', 'max:5048'],
            'tags' => ['bail', 'required'],
        ]);

        foreach (array_column(json_decode(request()->tags), 'code') as $tag) {
            if (!Tag::find($tag))
                return redirect()->back()->withErrors(["tags_validate" => "Ошибка валидации тегов!"]);
        }

        if (request()->mainImg) {
            $newMainImgName = time() . '_' . mb_substr(request()->name, 0, 239) . '.' . request()->mainImg->extension();
            request()->mainImg->move(public_path('images/post/main'), $newMainImgName);

            if (File::exists(public_path('images/post/main/' . $post->mainImg))) {
                File::delete(public_path('images/post/main/' . $post->mainImg));
            }
            $post->update(['mainImg' => $newMainImgName]);
        }

//dd(htmlentities(request()->text));
        $post->update([
            'name' => request()->name,
            'description' => request()->description,
            'text' => request()->text,
            'category' => request()->category,
        ]);

        $post->tags()->sync(array_column(json_decode(request()->tags), 'code'));
        $post->text = $this->articleImgsSync($post->text, $this->articleImgPath . $post->id.'/', true);
        $post->save();
        return redirect()->back()->with(['success' => 'Пост был успешно обновлён!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //Удаляем главное изображение
        if (File::exists(public_path('images/post/main/' . $post->mainImg))) {
            File::delete(public_path('images/post/main/' . $post->mainImg));
        }

        //удаляем изображения из статьи
        if (File::exists(public_path($this->articleImgPath . $post->id))) {
            File::deleteDirectory(public_path($this->articleImgPath . $post->id));
        }

        //удаляем данные о посте из БД
        $post->delete();

        return redirect()->back()->with(['success' => 'Пост был успешно удалён!']);
    }


    // перенос из папки /storage/app/public/uploads/ не достающих изображений
    // если delete === true, удаляет неиспользуемые картинки в директории статьи (опция для update)
    // $text гененрирует tinyMCE
    public function articleImgsSync($text, $new_path = '/images/post/article/100/', $delete = false)
    {


        $old_path = '/storage/uploads/';
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->loadHTML('<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'.$text);
          // dd($doc->saveHTML());
        $tags = $doc->getElementsByTagName('img');


        $temp_img_names = [];
        $save_img_names = [];
        foreach ($tags as $tag) {

            $old_src = $tag->getAttribute('src');
            $src_name = array_slice(mb_split("\/", $old_src), -1)[0];

            if (!str_starts_with($old_src,  $old_path)) {
                $save_img_names[] = $src_name;
                continue;
            }


            $temp_img_names[] = $src_name;
            $new_src_url = $new_path . $src_name;
            $tag->setAttribute('src', $new_src_url);
        }
        $new_text = $this->DOMinnerHTML($doc->getElementsByTagName('body')[0]);

        //dd($new_text);
        //move $img_name to $new_path
        if (!File::exists(public_path($new_path))) {
            File::makeDirectory(public_path($new_path));
        }

        foreach ($temp_img_names as $img) {
            File::move(public_path( $old_path . $img), public_path($new_path . $img));
        }


        if ($delete
            && iterator_count(new FilesystemIterator(pUblic_path($new_path), FilesystemIterator::SKIP_DOTS))
            !== (count($save_img_names) + count($temp_img_names))) {


            $images_in_dir = array_diff(scandir(public_path($new_path)), array('..', '.'));
            $del_img_names = array_diff($images_in_dir, $save_img_names, $temp_img_names);
            foreach ($del_img_names as $img) {
                File::delete(public_path($new_path . $img));
            }
        }

        return $new_text;
    }

    function DOMinnerHTML(DOMNode $element)
    {
        $innerHTML = "";
        $children = $element->childNodes;

        foreach ($children as $child) {
            $innerHTML .= $element->ownerDocument->saveHTML($child);
        }

        return $innerHTML;
    }
}
