<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/customers",
     *      operationId="getCustomers",
     *      tags={"Customers"},
     *      summary="Get list of customers",
     *      description="Returns a paginated list of customers with optional filtering based on various parameters.",
     *      @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="Filter by customer name",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="email",
     *          in="query",
     *          description="Filter by exact customer email",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="partner_id",
     *          in="query",
     *          description="Filter by exact partner ID associated with the customer",
     *          required=false,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="discount",
     *          in="query",
     *          description="Filter by discount rate",
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
     *                  @OA\Items(ref="#/components/schemas/Customer")
     *              ),
     *              @OA\Property(
     *                  property="links",
     *                  type="object",
     *                  @OA\Property(property="first", type="string", example="http://localhost:8000/api/customers?page=1"),
     *                  @OA\Property(property="last", type="string", example="http://localhost:8000/api/customers?page=10"),
     *                  @OA\Property(property="prev", type="string", nullable=true, example="http://localhost:8000/api/customers?page=1"),
     *                  @OA\Property(property="next", type="string", nullable=true, example="http://localhost:8000/api/customers?page=3")
     *              ),
     *              @OA\Property(
     *                  property="meta",
     *                  type="object",
     *                  @OA\Property(property="current_page", type="integer", example=2),
     *                  @OA\Property(property="from", type="integer", example=16),
     *                  @OA\Property(property="last_page", type="integer", example=10),
     *                  @OA\Property(property="path", type="string", example="http://localhost:8000/api/customers"),
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
        $customers = QueryBuilder::for(Customer::class)
            ->allowedFilters([
                'name',
                AllowedFilter::exact('email'),
                AllowedFilter::exact('partner_id'),
                'discount'
            ])
            ->paginate()
            ->appends(request()->query());

        return CustomerResource::collection($customers);
    }

    /**
     * @OA\Post(
     *      path="/api/customers",
     *      operationId="addCustomer",
     *      tags={"Customers"},
     *      summary="Create a new customer",
     *      description="Creates a new customer record in the database.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="Customer data to create",
     *          @OA\JsonContent(ref="#/components/schemas/Customer")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Customer created successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Customer"
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
     * )
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());

        return CustomerResource::make($customer);
    }

    /**
     * @OA\Get(
     *      path="/api/customers/{id}",
     *      operationId="getCustomerById",
     *      tags={"Customers"},
     *      summary="Get a single customer",
     *      description="Returns a single customer by ID.",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the customer to return",
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
     *                  ref="#/components/schemas/Customer"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Customer not found",
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
    public function show(Customer $customer)
    {
        return CustomerResource::make($customer);
    }

    /**
     * @OA\Put(
     *      path="/customers/{id}",
     *      operationId="updateCustomer",
     *      tags={"Customers"},
     *      summary="Update a customer",
     *      description="Updates a customer's record in the database and returns the updated customer.",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the customer to update",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Customer data to update",
     *          @OA\JsonContent(ref="#/components/schemas/Customer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Customer updated successfully",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Customer"
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
     *          description="Customer not found",
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
     *                  example="The input has validation errors",
     *                  description="General error message"
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
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return CustomerResource::make($customer);
    }

    /**
     * @OA\Delete(
     *      path="/customers/{id}",
     *      operationId="deleteCustomer",
     *      tags={"Customers"},
     *      summary="Delete a customer",
     *      description="Deletes a specific customer by ID and returns no content.",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the customer to delete",
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
     *          description="Customer not found",
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
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->noContent();
    }
}
