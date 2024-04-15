<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Customer",
 *     type="object",
 *     title="Customer",
 *     description="Schema for Customer data",
 *     required={"name", "vat", "email", "address", "partner_id", "discount"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier of the customer"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Full name of the customer"
 *     ),
 *     @OA\Property(
 *         property="vat",
 *         type="string",
 *         description="VAT number of the customer"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Email address of the customer"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         description="Physical address of the customer"
 *     ),
 *     @OA\Property(
 *         property="partner_id",
 *         type="integer",
 *         description="Identifier for the partner associated with the customer",
 *         format="int64"
 *     ),
 *     @OA\Property(
 *         property="discount",
 *         type="number",
 *         format="float",
 *         description="Discount rate applicable to the customer"
 *     )
 * )
 */
class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vat',
        'email',
        'address',
        'partner_id',
        'discount'
    ];
}
