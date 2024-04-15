<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Supplier",
 *     type="object",
 *     required={"id", "name", "vat", "email", "address", "max_due_days", "contract_file"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="The unique identifier of the supplier"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the supplier"
 *     ),
 *     @OA\Property(
 *         property="vat",
 *         type="string",
 *         description="The VAT of the supplier"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="The email address of the supplier"
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         description="The address of the supplier"
 *     ),
 *     @OA\Property(
 *         property="max_due_days",
 *         type="integer",
 *         description="The maximum number of due days allowed for the supplier"
 *     ),
 *     @OA\Property(
 *         property="contract_file",
 *         type="string",
 *         description="The file path for the contract file associated with the supplier"
 *     )
 * )
 */
class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vat',
        'email',
        'address',
        'max_due_days',
        'contract_file'
    ];
}
