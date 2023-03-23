<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarDetailsResource;
use App\Http\Resources\CategoriesResource;
use App\Interfaces\CarsDetailInterface;
use App\Interfaces\CategoriesInterface;
use App\Interfaces\UserInterface;
use App\Models\CarDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CarDetailsController extends Controller
{
    protected CategoriesInterface $categories ;

    protected CarsDetailInterface $carsDetail;
    protected UserInterface $userRepository;
    public function __construct(CategoriesInterface $categories, CarsDetailInterface $carsDetail, UserInterface $userRepository)
    {
        $this->categories = $categories;
        $this->carsDetail = $carsDetail;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $carDetails = $this->carsDetail->pagination($request);

        return CarDetailsResource::collection($carDetails);
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
            'model' => 'required|string|max:100',
            'register_no' => 'required|max:255|unique:'.CarDetail::class,
            'color' => 'required|string|max:100',
            'making_year' => 'required|string|max:100',
            'category' =>'required'
        ]);

        $detailArray = [
            'model' => $request->model,
            'register_no' => $request->register_no,
            'color' => $request->color,
            'making_year' => $request->making_year,
            'category_id' => (int) $request->category,
        ];

        $isCreated = $this->carsDetail->create($detailArray);
        if($isCreated)
            return response()->success(true);
        else
            return response()->error(false, 500);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id): \Illuminate\Http\Response|CarDetailsResource
    {
        $carDetail = $this->carsDetail->firstOneWith(['*'], ['id'=> $id], ['category']);
        return new CarDetailsResource($carDetail);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $detailArray = [
            'model' => $request->model,
            'register_no' => $request->register_no,
            'color' => $request->color,
            'making_year' => $request->making_year,
            'category_id' => $request->category,
        ];
        $carModel = $this->carsDetail->findById($id);
        $isUpdated = $this->carsDetail->update($detailArray, $carModel);

        if($isUpdated)
            return response()->success(true);
        else
            return response()->error(false, 500);
    }


    public function destroy($id): \Illuminate\Http\Response
    {
        $carDetail = $this->carsDetail->findById($id);
        $carDetail->delete();

        return response()->noContent();
    }

    public function categories(): AnonymousResourceCollection
    {
        $categories = $this->categories->all();
        return CategoriesResource::collection($categories);

    }
}
