<?php

namespace App\Http\Controllers;

use App\Address;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Expression;

class AddressController extends Controller
{
    /**
     * Return a list of all addresses, the owner and the number of cars at the address.
     *
     * @return array
     * @throws Exception
     */
    public function index(): array
    {
        return DB::table('addresses as a')
            ->leftJoin('owners as o', 'o.id', '=', 'a.owner_id')
            ->leftJoin('cars as c', 'a.id', '=', 'c.address_id')
            ->selectRaw("concat_ws(' ',o.first_name,o.last_name) as full_name, a.* , count(o.id) as number_of_cars")
            ->groupBy('o.first_name', 'o.last_name', 'a.id', 'a.created_at', 'a.updated_at', 'a.address', 'a.city', 'a.country', 'a.postal_code', 'a.owner_id', 'o.id')
            ->orderBy('o.id')
            ->get()
            ->toArray();
    }

    /**
     * Return a single address, the owner and the cars associated to the address.
     *
     * @param int $address
     * @return array
     * @throws Exception
     */
    public function show(int $address): array
    {
        return DB::table('addresses as a')
            ->leftJoin('cars as c', 'a.id', '=','c.address_id')
            ->leftJoin('owners as o', 'o.id', '=','a.owner_id')
            ->selectRaw('o.first_name,o.last_name,a.address,a.city,a.country,a.postal_code,c.model,c.make,c.year')
            ->where('a.id', '=', $address)
            ->get()
            ->toArray();
    }

    /**
     * Store an address.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $address = Address::create($request->all());

        return response()->json($address, 201);
    }

    /**
     * Update an address.
     *
     * @param Request $request
     * @param Address $address
     * @return JsonResponse
     */
    public function update(Request $request, Address $address): JsonResponse
    {
        $address->update($request->all());

        return response()->json($address, 200);
    }

    /**
     * Delete an address.
     *
     * @param Address $address
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Address $address): JsonResponse
    {
        $address->delete();

        return response()->json(null, 204);
    }

    /**
     * Get average number of cars per address.
     *
     * @return array
     * @throws Exception
     */
    public function average_number_of_cars_per_address(): array
    {
        // predefined variables
        $totalCars = 0;
        // return an array of number_of_cars
        $data = DB::table('addresses as a')
            ->leftJoin('owners as o', 'o.id', '=', 'a.owner_id')
            ->leftJoin('cars as c', 'a.id', '=', 'c.address_id')
            ->selectRaw('count(c.id) as number_of_cars')
            ->groupBy('a.id')
            ->get()
            ->toArray();
        // get the total number of elements in the array returned
        $total = count($data);
        // get the total number returned
        foreach ($data as $value){
            $totalCars += $value->{'number_of_cars'};
        }
        // find the average, round to the hundredths place
        $returnData[] = [
            'number_of_cars' => round($totalCars / $total, 2),
        ];
        return $returnData;
    }
}
