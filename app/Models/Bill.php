<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bill extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'bills';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function Student(): BelongsTo
    {
        return $this->belongsTo(User::class, "student_id", "id");
    }

    public function Staff(): BelongsTo
    {
        return $this->belongsTo(User::class, "staff_id", "id");
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function Day()
    {
        $now = date("Y-m-d");
        $end = $this->end;
        $day = (strtotime($end) - strtotime($now)) / 3600 / 24;
        if ($day > 10) {
            return view("components.badge", ["day" => $day, 'type' => 'success']);
        } elseif ($day > 0) {
            return view("components.badge", ["day" => $day, 'type' => 'warning']);
        }else{
            return view("components.badge",["day"=>$day,'type'=>'dark']);
        }

    }

    public function Remaining()
    {
        if ($this->disable == 1) {
            return true;
        }
        $now = date("Y-m-d");
        $end = $this->end;
        return (((strtotime($end) - strtotime($now)) / 3600 / 24) > 10) || ((strtotime($end) - strtotime($now)) < 0);

    }
    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
