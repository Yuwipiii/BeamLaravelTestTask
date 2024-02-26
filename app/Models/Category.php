<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OAS\Schema(
 *   schema="Category",
 *   type="object",
 *   required={"name"},
 * )
 * Class Category
 * @package Incase\Models
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

}
