<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use App\Http\Resources\PartnerResource;
use App\Models\Partner;
use Spatie\QueryBuilder\QueryBuilder;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partners = QueryBuilder::for(Partner::class)
            ->allowedFilters([
                'name',
                'email',
                'comission'
            ])
            ->paginate()
            ->appends(request()->query()); // é acrescentado para nos links da página ter a query na mesma

        return PartnerResource::collection($partners);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePartnerRequest $request)
    {
        $partner = Partner::create($request->validated());

        return PartnerResource::make($partner);
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        return PartnerResource::make($partner);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        $partner->update($request->validated());

        return PartnerResource::make($partner);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();

        return response()->noContent();
    }
}
