<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exam';

    protected $fillable = ['question','option1','option2','option3','option4'];
    
    public function category(){
        return $this->belongsToMany(Category::class, 'category_exam', 'exam_id', 'category_id');
    }
}
