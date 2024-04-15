<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use App\Http\Resources\PartnerResource;
use App\Models\Partner;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PartnerController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/partners",
     *      operationId="getPartners",
     *      tags={"Partners"},
     *      summary="Get list of partners",
     *      description="Returns a paginated list of partners with optional filtering based on various parameters.",
     *      @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="Filter by partner name",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *          description="Filter by exact partner email",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="commission",
     *          in="query",
     *          description="Filter by commission rate",
     *          required=false,
     *          @OA\Schema(type="number", format="float")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Partner")
     *              ),
     *              @OA\Property(
     *                  property="links",
     *                  type="object",
     *                  @OA\Property(property="first", type="string", example="http://localhost:8000/api/partners?page=1"),
     *                  @OA\Property(property="last", type="string", example="http://localhost:8000/api/partners?page=10"),
     *                  @OA\Property(property="prev", type="string", nullable=true, example="http://localhost:8000/api/partners?page=1"),
     *                  @OA\Property(property="next", type="string", nullable=true, example="http://localhost:8000/api/partners?page=3")
     *              ),
     *              @OA\Property(
     *                  property="meta",
     *                  type="object",
     *                  @OA\Property(property="current_page", type="integer", example=2),
     *                  @OA\Property(property="from", type="integer", example=16),
     *                  @OA\Property(property="last_page", type="integer", example=10),
     *                  @OA\Property(property="path", type="string", example="http://localhost:8000/api/partners"),
     *                  @OA\Property(property="per_page", type="integer", example=15),
     *                  @OA\Property(property="to", type="integer", example=30),
     *                  @OA\Property(property="total", type="integer", example=150)
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      )
     * )
     */
    public function index()
    {
        $partners = QueryBuilder::for(Partner::class)
            ->allowedFilters([
                'name',
                AllowedFilter::exact('email'),
                'comission'
            ])
            ->paginate()
            ->appends(request()->query()); // é acrescentado para nos links da página ter a query na mesma

        return PartnerResource::collection($partners);
    }


    /**
     * @OA\Post(
     *      path="/api/partners",
     *      operationId="addPartner",
     *      tags={"Partners"},
     *      summary="Create a new partner",
     *      description="Creates a new partner record in the database.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Partner data to create",
     *          @OA\JsonContent(ref="#/components/schemas/Partner")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Partner created successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Partner"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Invalid input data"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Validation errors in your request",
     *                  description="Descriptive message about the validation errors"
     *              ),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  additionalProperties={
     *                      @OA\Property(
     *                          type="array",
     *                          @OA\Items(type="string")
     *                      )
     *                  },
     *                  description="Detailed validation errors"
     *              )
     *          )
     *      )
     * )
     */
    public function store(StorePartnerRequest $request)
    {
        $partner = Partner::create($request->validated());

        return PartnerResource::make($partner);
    }

    /**
     * @OA\Get(
     *      path="/api/partners/{id}",
     *      operationId="getPartnerById",
     *      tags={"Partners"},
     *      summary="Get a single partner",
     *      description="Returns a single partner by ID.",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the partner to return",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Partner"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Partner not found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Object not found"
     *              )
     *          )
     *      )
     * )
     */
    public function show(Partner $partner)
    {
        return PartnerResource::make($partner);
    }

    /**
     * @OA\Put(
     *      path="/api/partners/{id}",
     *      operationId="updatePartner",
     *      tags={"Partners"},
     *      summary="Update a partner",
     *      description="Updates a partner's record in the database and returns the updated partner.",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the partner to update",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Partner data to update",
     *          @OA\JsonContent(ref="#/components/schemas/Partner")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Partner updated successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Partner"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Invalid input data"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Partner not found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Object not found"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Validation errors in your request",
     *                  description="Descriptive message about the validation errors"
     *              ),
     *              @OA\Property(
     *                  property="errors",
     *                  type="object",
     *                  additionalProperties={
     *                      @OA\Property(
     *                          type="array",
     *                          @OA\Items(type="string")
     *                      )
     *                  },
     *                  description="Detailed list of validation errors per field"
     *              )
     *          )
     *      )
     * )
     */
    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        $partner->update($request->validated());

        return PartnerResource::make($partner);
    }

    /**
     * @OA\Delete(
     *      path="/api/partners/{id}",
     *      operationId="deletePartner",
     *      tags={"Partners"},
     *      summary="Delete a partner",
     *      description="Deletes a specific partner by ID and returns no content.",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the partner to delete",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="No content (successful deletion)"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Partner not found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Object not found"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy(Partner $partner)
    {
        $partner->delete();

        return response()->noContent();
    }
}
