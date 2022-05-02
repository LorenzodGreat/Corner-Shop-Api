<?php

namespace App\Models;

use App\Models\Category as ModelsCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];
    
    protected $with=['category'];
    public function category()
    {
        return $this->belongsTo(ModelsCategory::class, "category_id", "id");
    }
}
