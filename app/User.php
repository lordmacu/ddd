<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
      
     
    public function owner()
    {
      return $this->hasOne('App\Owner','owner_id','id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'password', 'remember_token',
    ];
    
    public function getBySourceId($sourceid){
        return $this->where("id_source",$sourceid)->first();
    }
    
    public function checkBySource($id){
      return $this->where("id_source","LIKE",$id)->get();
    }
    
    
     public function getRandomUsers(){
      return $this
      ->inRandomOrder()
      ->where("nomail",1)
     ->where("updated_at","<",Carbon::today())
      ->take(10)
      ->get();
    }
    public function checkByEmail($email){
      return $this->where("email","LIKE",$email)->get();
    }  
    
    
       public function checkByEmailFirst($email){
      return $this->where("email",$email)->first();
    }  
    
    
    public function getUserByToken($token){
      return $this->where("remember_token",$token)->get();
    }
    
    public function getRandomUser(){
      return $this
      ->inRandomOrder()
      ->where("id","<>",Auth::id())
      ->where("nomail",1)
      ->whereNotNull('alternative_mail')
  //->whereDay('updated_at', '>', "CURDATE()")
      ->first();
    }
    
    public function validator(array $data)
    
    {
     return Validator::make($data, [
       'name' => 'required|max:255',
       'email' => 'required|email|max:255|unique:users',
       'id_source' => 'required|min:6',
     ]);
   }
   
   public function create(array $data)
   {
     $user= new User();
     $user->name=$data['name'];
     $user->email=$data['email'];
     $user->id_source=$data['password'];
     $user->password=bcrypt($data['password']."registerDueno");
     $user->save();
     
     
     return $user;
   } 
   
   
   public function favorites()
   {
    
    
     return $this->belongsToMany('App\Unit', 'unit_favorite', 
      'user_id', 'unit_id');


   }
}
