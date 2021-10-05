<?php

namespace App\Http\Controllers;

use App\Car;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    /**
     * Return a list of all cars, the owner and the address of the car.
     *
     * @return array
     * @throws Exception
     */
    public function index(): array
    {
        return DB::table('cars as c')
            ->leftJoin('owners as o', 'o.id', '=','c.owner_id')
            ->leftJoin('addresses as a', 'a.id', '=','c.address_id')
            ->selectRaw("c.id as id, c.make, c.model, c.year, concat_ws(' ',o.first_name, o.last_name) as full_name, a.address, a.city, a.country, a.postal_code")
            ->get()
            ->toArray();
    }

    /**
     * Return a single car, the owner and the address of the car.
     *
     * @param int $car
     * @return array
     * @throws Exception
     */
    public function show(int $car): array
    {
        return DB::table('cars as c')
            ->leftJoin('addresses as a', 'a.id', '=','c.address_id')
            ->leftJoin('owners as o', 'o.id', '=','a.owner_id')
            ->selectRaw('o.first_name,o.last_name,a.address,a.city,a.country,a.postal_code,c.model,c.make,c.year')
            ->where('c.id', '=', $car)
            ->get()
            ->toArray();
    }

    /**
     * Store an car.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $car = Car::create($request->all());

        return response()->json($car, 201);
    }

    /**
     * Update an car.
     *
     * @param Request $request
     * @param Car $car
     * @return JsonResponse
     */
    public function update(Request $request, Car $car): JsonResponse
    {
        $car->update($request->all());

        return response()->json($car, 200);
    }

    /**
     * Delete an car.
     *
     * @param Car $car
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Car $car): JsonResponse
    {
        $car->delete();

        return response()->json(null, 204);
    }

    /**
     * Get average number of owners and address per car.
     *
     * @return array
     * @throws Exception
     */
    public function average_number_of_user_and_address_per_car(): array
    {
        // predefined variables
        $totalCarsOwner = 0;
        $totalCarsAddresses = 0;
        // return an array of number of cars at each address
        $data = DB::table('addresses as a')
            ->leftJoin('owners as o', 'o.id', '=', 'a.owner_id')
            ->leftJoin('cars as c', 'a.id', '=', 'c.address_id')
            ->selectRaw('count(c.id) as number_of_cars')
            ->groupBy('a.id')
            ->get()
            ->toArray();
        // get the total number of elements in the array returned
        $totalAddresses = count($data);
        // get the total number returned
        foreach ($data as $value){
            $totalCarsAddresses += $value->{'number_of_cars'};
        }
        // return an array of number of cars for each owner
        $data = DB::table('owners as o')
            ->leftJoin('addresses as a', 'o.id', '=','a.owner_id')
            ->leftJoin('cars as c', 'a.id', '=','c.address_id')
            ->selectRaw('count(o.id) as number_of_cars')
            ->groupBy('o.id', 'o.created_at', 'o.updated_at', 'first_name', 'last_name')
            ->orderBy('o.id')
            ->get()
            ->toArray();
        // get the total number of elements in the array returned
        $totalOwners = count($data);
        // get the total number returned
        foreach ($data as $value){
            $totalCarsOwner += $value->{'number_of_cars'};
        }
        // find the average, round to the hundredths place
        $returnData[] = [
            'avg_number_of_cars'=> round($totalCarsOwner / $totalOwners,2),
            'avg_number_of_addresses'=> round($totalCarsAddresses / $totalAddresses,2),
        ];
        return $returnData;
    }
}
