<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InpectionChecklist extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'inpection_checklists';

    protected $fillable = [
        'type',
        'ins_id',
        'checker_id',
        'comment',
    ];
}
