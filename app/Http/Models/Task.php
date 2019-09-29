<?php


namespace App\Http\Models;


use App\Model;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    const STATE = [
        0 => 'To do',
        1 => 'Doing',
        2 => 'Done',
        3 => 'Aborted'
    ];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    protected $appends = ['state'];
    public function getStateAttribute (){
        return self::STATE[$this->status];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
