<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use OpenApi\Annotations as OA;

class SupplierController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/suppliers",
     *      operationId="getSuppliers",
     *      tags={"Suppliers"},
     *      summary="Get list of suppliers",
     *      description="Returns paginated list of suppliers with navigation links.",
     *      @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="Filter suppliers by name",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *          description="Filter suppliers by exact email",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="max_due_days",
     *          in="query",
     *          description="Filter suppliers by maximum due days",
     *          required=false,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="contract_file",
     *          in="query",
     *          description="Filter suppliers by contract file presence",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Supplier")
     *              ),
     *              @OA\Property(
     *                  property="links",
     *                  type="object",
     *                  @OA\Property(property="first", type="string", description="Link to the first page"),
     *                  @OA\Property(property="last", type="string", description="Link to the last page"),
     *                  @OA\Property(property="prev", type="string", nullable=true, description="Link to the previous page"),
     *                  @OA\Property(property="next", type="string", nullable=true, description="Link to the next page")
     *              ),
     *              @OA\Property(
     *                  property="meta",
     *                  type="object",
     *                  @OA\Property(property="current_page", type="integer", description="Current page number"),
     *                  @OA\Property(property="from", type="integer", description="First item number on the current page"),
     *                  @OA\Property(property="last_page", type="integer", description="Last page number"),
     *                  @OA\Property(property="path", type="string", description="Base path for the paginated links"),
     *                  @OA\Property(property="per_page", type="integer", description="Number of items per page"),
     *                  @OA\Property(property="to", type="integer", description="Last item number on the current page"),
     *                  @OA\Property(property="total", type="integer", description="Total items available")
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
        $suppliers = QueryBuilder::for(Supplier::class)
            ->allowedFilters([
                'name',
                AllowedFilter::exact('email'),
                'max_due_days',
                'contract_file'
            ])
            ->paginate()
            ->appends(request()->query());

        return SupplierResource::collection($suppliers);
    }

    /**
     * @OA\Post(
     *      path="/api/suppliers",
     *      operationId="addSupplier",
     *      tags={"Suppliers"},
     *      summary="Create a new supplier",
     *      description="Creates a new supplier and returns the newly created supplier.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Supplier data to create",
     *          @OA\JsonContent(
     *              required={"name", "email", "max_due_days"},
     *              @OA\Property(property="name", type="string", description="Name of the supplier", example="XPTO"),
     *              @OA\Property(property="email", type="string", format="email", description="Email address of the supplier", example="xpto@email.com"),
     *              @OA\Property(property="vat", type="string", description="VAT number of the supplier", example="123456789"),
     *              @OA\Property(property="max_due_days", type="integer", description="Maximum number of due days allowed", example=30),
     *              @OA\Property(property="contract_file", type="string", description="Path to the contract file associated with the supplier", example="/files/contracts/Supplier_Contract.pdf")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Supplier created successfully",
     *          @OA\JsonContent(ref="#/components/schemas/Supplier")
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request"
     *      )
     * )
     */
    public function store(StoreSupplierRequest $request)
    {
        $supplier = Supplier::create($request->validated());

        return SupplierResource::make($supplier);
    }

    /**
     * @OA\Get(
     *      path="/api/suppliers/{id}",
     *      operationId="getSupplierById",
     *      tags={"Suppliers"},
     *      summary="Get a single supplier",
     *      description="Returns a single supplier by ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID of the supplier to return",
     *          required=true,
     *          in="path",
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
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Supplier")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Supplier not found",
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
    public function show(Supplier $supplier)
    {
        return SupplierResource::make($supplier);
    }

    /**
     * @OA\Put(
     *      path="/api/suppliers/{id}",
     *      operationId="updateSupplier",
     *      tags={"Suppliers"},
     *      summary="Update a supplier",
     *      description="Updates a supplier identified by ID and returns the updated supplier.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID of the supplier to update",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Supplier data to update",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", description="Name of the supplier", example="XPTO"),
     *              @OA\Property(property="email", type="string", description="Email address of the supplier", format="email", example="xpto@email.com"),
     *              @OA\Property(property="vat", type="string", description="VAT number of the supplier", example="123456789"),
     *              @OA\Property(property="max_due_days", type="integer", description="Maximum number of due days allowed", example=30),
     *              @OA\Property(property="contract_file", type="string", description="Path to the contract file associated with the supplier", example="/files/contracts/Supplier_Contract.pdf")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Supplier updated successfully",
     *          @OA\JsonContent(ref="#/components/schemas/Supplier")
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Supplier not found",
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
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());

        return SupplierResource::make($supplier);
    }

    /**
     * @OA\Delete(
     *      path="/api/suppliers/{id}",
     *      operationId="deleteSupplier",
     *      tags={"Suppliers"},
     *      summary="Delete a supplier",
     *      description="Deletes a specific supplier by ID and returns no content.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID of the supplier to delete",
     *          required=true,
     *          in="path",
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
     *          description="Supplier not found",
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
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return response()->noContent();
    }
}
