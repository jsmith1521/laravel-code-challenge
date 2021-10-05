<?php

namespace App\Http\Controllers;

use App\Owner;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    /**
     * Return a list of all owners, number of car and number of addresses associated with the owner.
     *
     * @return array
     * @throws Exception
     */
    public function index(): array
    {
        return DB::table('owners as o')
            ->leftJoin('addresses as a', 'o.id', '=','a.owner_id')
            ->leftJoin('cars as c', 'a.id', '=','c.address_id')
            ->selectRaw('o.*, count(o.id) as number_of_cars, count(distinct a.id) as number_of_addresses')
            ->groupBy('o.id', 'o.created_at', 'o.updated_at', 'first_name', 'last_name')
            ->orderBy('o.id')
            ->get()
            ->toArray();
    }

    /**
     * Return a single owner and the associated addresses and cars.
     *
     * @param int $owner
     * @return array
     * @throws Exception
     */
    public function show(int $owner): array
    {
        return DB::table('owners as o')
            ->leftJoin('addresses as a', 'o.id', '=','a.owner_id')
            ->leftJoin('cars as c', 'a.id', '=','c.address_id')
            ->selectRaw('o.first_name,o.last_name,a.address,a.city,a.country,a.postal_code,c.model,c.make,c.year')
            ->where('o.id', '=', $owner)
            ->get()
            ->toArray();
    }

    /**
     * Store an owner.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $owner = Owner::create($request->all());

        return response()->json($owner, 201);
    }

    /**
     * Update an owner.
     *
     * @param Request $request
     * @param Owner $owner
     * @return JsonResponse
     */
    public function update(Request $request, Owner $owner): JsonResponse
    {

        $owner->update($request->all());

        return response()->json($owner, 200);
    }

    /**
     * Delete an owner.
     *
     * @param Owner $owner
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Owner $owner): JsonResponse
    {
        $owner->delete();

        return response()->json(null, 204);
    }

    /**
     * Get average number of addresses and cars, respectively, per user.
     *
     * @return array
     * @throws Exception
     */
    public function average_number_addresses_and_cars_per_user(): array
    {
        // predefined variables
        $totalCars = 0;
        $totaladdresses = 0;
        // return an array of number_of_cars and number_of_addresses
        $data = DB::table('owners as o')
            ->leftJoin('addresses as a', 'o.id', '=','a.owner_id')
            ->leftJoin('cars as c', 'a.id', '=','c.address_id')
            ->selectRaw('count(c.id) as number_of_cars, count(distinct a.id) as number_of_addresses')
            ->groupBy('o.id', 'o.created_at', 'o.updated_at', 'first_name', 'last_name')
            ->orderBy('o.id')
            ->get()
            ->toArray();
        // get the total number of elements in the array returned
        $total = count($data);
        // get the total number returned
        foreach ($data as $value){
            $totalCars += $value->{'number_of_cars'};
            $totaladdresses += $value->{'number_of_addresses'};
        }
        // find the average, round to the hundredths place
        $returnData[] = [
            'avg_number_of_cars'=> round($totalCars / $total,2),
            'avg_number_of_addresses'=> round($totaladdresses / $total,2),
        ];
        return $returnData;
    }
}
