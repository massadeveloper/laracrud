<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

 class ModelOrdini extends Model
        {

protected $table ="components";

protected $fillable= ['id','nomecontroller','namespacemodel','nomemodel','namespacecontroller','nometabelladb'];

}
        ?>