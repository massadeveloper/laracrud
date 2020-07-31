<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    //
    protected $table = 'components';
    protected $fillable = ['namespacemodel','nomemodel','namespacecontroller','nomecontroller','nometabelladb'];
}
