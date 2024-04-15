<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Partner",
 *     type="object",
 *     title="Partner",
 *     description="Schema for Partner data",
 *     required={"name", "vat", "email", "address", "commission"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier of the partner"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Full name of the partner"
 *     ),
 *     @OA\Property(
 *         property="vat",
 *         type="string",
 *         description="VAT number of the partner"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Email address of the partner"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         description="Physical address of the partner"
 *     ),
 *     @OA\Property(
 *         property="commission",
 *         type="number",
 *         format="float",
 *         description="Commission rate for the partner"
 *     )
 * )
 */
class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vat',
        'email',
        'address',
        'comission'
    ];
}
