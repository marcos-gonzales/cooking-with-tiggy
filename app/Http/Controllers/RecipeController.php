<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Rating;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('category', 'user', 'ratings', 'comments')->latest()
            ->when(Request::input('search'), function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('ingredients', 'like', '%' . $search . '%');
            })->paginate();

        return Inertia::render('Recipes/Index', [
            'recipes' => $recipes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Inertia\Inertia;
     */
    public function create()
    {
        return Inertia::render('Recipes/Create', [
            'categories' => Category::with('recipes')->get(),
            'user_id' => auth()->user()->id ?? null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Inertia\Inertia;
     */
    public function store()
    {
        $input = Request::validate([
            'name' => ['required', 'string'],
            'ingredients' => ['required', 'string'],
            'estimated_time' => ['required', 'integer'],
            'steps' => ['required', 'string'],
            'user_id' => ['required', 'integer'],
            'category_id' => ['required', 'integer'],
            'file_path' => ['required', 'file']
        ]);

        $filenameWithExt = Request::file('file_path')->getClientOriginalName();
        //Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        // Get just ext
        $extension = Request::file('file_path')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $filename . '_' . now() . '.' . $extension;
        // Upload Image

        $recipe = Recipe::create($input);

        $recipe->file_path = Request::file('file_path')->storeAs('public/recipes', $fileNameToStore);
        $recipe->save();
        return redirect('/recipes')->with('success', 'Recipe has been saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
//        DB::connection()->enableQueryLog();
//        $queries = DB::getQueryLog();
        $recipe = Recipe::with('user', 'category', 'comments', 'ratings')->find(Request::get('id'));

        return Inertia::render('Recipes/Show', [
            'recipe' => $recipe
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recipe = Recipe::find($id);
        $recipe->delete();
        return redirect()->back()->with('success', 'post has been deleted');
    }

    public function recipeUserIndex($userId)
    {
        $recipes = Recipe::with('category', 'user', 'ratings', 'comments')->latest()->where('user_id', $userId)
            ->when(Request::input('search'), function ($query, $search) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhere('user_id', $userId)
                    ->where('ingredients', 'like', '%' . $search . '%');
            })->paginate();

        return Inertia::render('Recipes/UserIndex', [
            'recipes' => $recipes
        ]);
    }

    public function recipesCategoryIndex($category)
    {
        $recipes = Recipe::with('category', 'user', 'ratings', 'comments')->latest()->where('category_id', $category)
            ->when(Request::input('search'), function ($query, $search) use ($category) {
                $query->where('category_id', $category)
                    ->where('name', 'like', '%' . $search . '%')
                    ->orWhere('category_id', $category)
                    ->where('ingredients', 'like', '%' . $search . '%');
            })->paginate();
        return Inertia::render('Recipes/Categories', ['recipes' => $recipes]);
    }

    public
    function recipeComment($recipeId)
    {
        Request::validate([
            'comment' => 'required|string'
        ]);

        $user = User::where('email', Request::get('email'))->first();

        Comment::create([
            'user_id' => $user->id,
            'user_input' => Request::get('comment'),
            'recipe_id' => $recipeId,
            'file_path' => $user->file_path
        ]);

        return redirect()->back()->with('success', 'comment posted');
    }

    public
    function recipeLikes()
    {
        $group = [];
        $recipes = Rating::with('recipe')->groupBy('recipe_id')->select('recipe_id')->count();
        dd($recipes);

        return Inertia::render('Recipes/Categories', ['recipes' => $recipes]);
    }
}
