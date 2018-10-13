<?php


use App\Post;
use App\User;
use App\Role;
use App\Country;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//passsing parameter in routes

Route::get('/posts/{id}/{name}',function ($id,$name){
   return "this is the post from ". $name. "with id ". $id;
});

//getting the url of the route

Route::get('admin/post/example',array('as' => 'admin.home' ,function(){
    $url = route('admin.home');
    return "this url is ".$url;

}));
//route that passes data to controller
//Route::get('/post/{id}','PostsController@index');


//route with resource

////Route::resource('post','PostsController');
//Route::get('/contact','PostsController@showMyView');
//Route::get('post/{id}/{name}/{password}','PostsController@showPost');




Route::get('/insert',function(){
    DB::insert('insert into posts(title,body,is_admin) values(?,?,?)',['Php with laravel','Laravel is the best framework for learning',1]);
});

Route::get('/read',function(){
    $result = DB::select('select * from posts where id=?',[1]);
    foreach($result as $post){
        return (
            $post->body
        );

    }
});

Route::get('/update',function(){
   $update = DB::update('update posts set body="this is the update title" where id=?',[1]);
   return $update;
});





/*
 * Eloquent (object oriented model)*/


Route::get('/find',function(){
   //$posts = Post::all();
//    foreach ($posts as $post){
//        return $post->body;
//    }
   //to find the specific id value

    $posts =Post::find(1);
     return $posts->body;

});

Route::get('/findwhere',function(){
    $posts =Post::where('id',1)->orderBy('id','desc')->take(1)->get();
    return $posts;
});

Route::get('/findmore',function(){
   $posts =Post::findOrFail(2);//for failure because data with id 2 is not present now
    $postsuccess =Post::findOrFail(1);//for success data with id 1 is available
    return $posts;

   //if the search result is not found then it displays the sorry page to the user
});



Route::get('/usercount',function(){
    $posts = Post::where('title','<',5)->firstOrFail();//title 5 ota vanda kam xa vane show garxa

    return $posts;
});


//inserting data using eloquent

Route::get('/basicInsert',function(){
    $post =new Post;
    $post->title="New Eloquent title inserted";
    $post->body ='Eloquent is really super easy';
    $post->is_admin=0;
    $post->save();
});

//to use save method to update first find the record that you want then you can update it

Route::get('/basicUpdate',function(){
    $post =Post::find(1);
    $post->title ="Updated Eloquent title";
    $post->body ="Eloquent data is getting updated";
    $post->save();
});

//if we directly used this url it will show massassignement exception
Route::get('/create',function(){
    Post::create([
        'title'=>'the create method',
        'body'=>'i m learning a lot from edwin',
        'is_admin'=>1
    ]);
});



Route::get('/updateeloquent',function(){
   Post::where('id',2)->where('is_admin',0)->update([
       'title'=>'New Php title',
       'body'=>'I love my job'
   ]);
});


Route::get('/delete',function(){
    $post = Post::find(2);
    $post->delete();
});

//another method of delete is


Route::get('/deleteoption',function(){
   Post::destroy(2);

   //to delete multiple data

    Post::destroy([3,4,5]);

    //similary using where keyword

    Post::where('is_admin',0)->delete();
});

//to temporarily delete the data it can be retreived using restoretrashed route
Route::get('softdelete',function(){
Post::find(3)->delete();
});


//to read the temporarily deleted data because we read the data soft deleted using the common read method
Route::get('readsoftdelete',function(){
   $post=Post::withTrashed()->where('id',1)->get();
   return $post;
});


//to read only the softdeleted data
Route::get('onlytrashed',function(){
   $post = Post::onlyTrashed()->get();
   return $post;
});


//to delete the softdeleted data

Route::get('/restoretrashed',function(){

    //Post::withTrashed()->where('id',1)->restore(); //for specific where is used to define specific right
    Post::withTrashed()->restore();  //for all data
});

//to forcely delete all the data even it is a soft delete ...if we dont define the where statement it will delete all the data in data base
Route::get('/forcedelete',function(){
   Post::withTrashed()->where('id',1)->forceDelete();

   //to delete on the trashed item

    //Post::onlyTrashed()->forceDelete();//to deleted the only trashed data

});


//Eloquent Relationship

//One to one relationship

Route::get('/user/{id}/post',function($id){
 //return User::find($id)->post;;
 //similarly we can access

   // return User::find($id)->post->body;
    return User::find($id)->post->title;//post is not the property of the table but it is the method defined in the user model

});


//defining inverse relationship

Route::get('/post/{id}/user',function($id){
    return Post::find($id)->user->name;
});

Route::get('/posts',function(){
    $user = User::find(1);
    foreach ($user->posts as $post){
           echo  "$post->title"."<br>";
    }
});

//many to many relationship



Route::get('/user/{id}/role',function($id){
//    $user = User::find($id);
//    foreach ($user->roles as $role){
//        return $role->name;
//    }



    $user =User::find($id)->roles()->orderBy('id','desc')->get();
    return $user;
});


//accessing user name by accessing the  role table

Route::get('/roles/{id}/users',function($id){

   $user =User::find($id);
   return $user->name;

});

//defining the intermediate table /pivot table

Route::get('user/pivot',function(){
   $user =User::find(1);


   foreach ($user->roles as $role){
       return $role->pivot->user_id;

       //similarly access data but it must be defined in the user table
//       return $role->pivot->created_at;
   }
});



Route::get('user/country',function(){
    $country = Country::find(1);
    foreach($country->posts as $post){
        return  $post->title;
    }
});

