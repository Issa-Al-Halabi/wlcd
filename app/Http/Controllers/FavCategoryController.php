<?php

namespace App\Http\Controllers;

use App\Categories;
use App\FavCategory;
use App\FavSubcategory;
use App\SubCategory;
use Illuminate\Http\Request;

class FavCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fcategories = Categories::where('status', 1)->get();
        $favcats = [];
        $cat_counts = [];
        foreach ($fcategories as $key => $fcategory) {
            $count = FavCategory::where('category_id', "=", $fcategory->id)->count();
            array_push($cat_counts, $count);
            $favsub = [];
            $subcats = SubCategory::where('category_id', "=", $fcategory->id)->get();

            foreach ($subcats as $key => $subcat) {
                $subcount = FavSubcategory::where('subcategory_id', "=", $subcat->id)->count();
                $favsub[$subcat->title] = $subcount;
            }

            $favcats[$fcategory->title] = $favsub;
        }



        // add stander colors
        $colors = [
            '#E60000', '#00E235', '#CD00E4', '#1800EF', '#E8F000',
            '#FF0033', '#00A226', '#9903A9', '#1EC3C9', '#FFA200',
            '#A50000', '#005A15', '#591361', '#0C0073', '#FF6600',
            '#C70000', '#49EF70', '#F065FF', '#4A62FC', '#A44100',
        ];
        
        // js: array.slice(0, n);
        // php: array_slice($colors, 0, 3);


        $cat_colors = array_slice($colors, 0, sizeof($cat_counts));

        $keys = array_keys($favcats);
        // dd($favcats);

        return view('admin.category.favcategory',compact('favcats', 'cat_counts', 'colors', 'cat_colors', 'keys'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FavCategory  $favCategory
     * @return \Illuminate\Http\Response
     */
    public function show(FavCategory $favCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FavCategory  $favCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(FavCategory $favCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FavCategory  $favCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FavCategory $favCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FavCategory  $favCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(FavCategory $favCategory)
    {
        //
    }
}
