<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Interfaces\CategoriesInterface;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoiesController extends Controller
{
    protected CategoriesInterface $categories ;
    public function __construct(CategoriesInterface $categories)
    {
        $this->categories = $categories;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $carDetails = $this->categories->pagination($request);

        return CategoriesResource::collection($carDetails);
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
            'name' => 'required|max:255|unique:'.Category::class,
        ]);

        $isCreated = $this->categories->create(['name' => $request->name]);
        if($isCreated)
            return response()->success(true);
        else
            return response()->error(false, 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return new CategoriesResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,'.$category->id,
        ]);
        $isUpdated = $this->categories->update(['name' => $request->name], $category);
        if($isUpdated)
            return response()->success(true);
        else
            return response()->error(false, 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();
    }
}
