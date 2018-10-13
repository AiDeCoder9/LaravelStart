<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    //model takes the name of the database table if we define the model name post it will search the database for the table name posts
    //so in case we use different model name instead of table name we have to define it like

   // protected $table ='posts'; //where posts is the name of the table in database an postadmin is the name of the model

    //if similarly primary key is not named id
    //protected $primaryKey ='post_id';//name of id in database table


    //to prevent from massassignment exception

    use SoftDeletes;

//to add deleted at colummn php artisan make:migration add_deleted_at_column_to_posts_table --table=posts
    protected $dates =['deleted_at'];

    protected $fillable =[
      'title',
        'body',
        'is_admin'
    ];

//for inverse relationship

    public function user(){
        return $this->belongsTo('App\User');
    }

}
