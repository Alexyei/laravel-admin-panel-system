<?php


namespace App\Http\View\Composers;

use App\Models\Tag;
use Illuminate\View\View;

class TagsWithCountComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('tags', Tag::withCount('posts')->orderBy('posts_count','desc')->take(8)->get());
    }

}
