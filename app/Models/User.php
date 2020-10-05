<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property integer $id
 * @property integer $image_id
 * @property integer $parent_id
 * @property integer $created_by
 * @property integer $company_id
 * @property integer $category_id
 * @property integer $phone_id
 * @property int $role_id
 * @property string $name
 * @property string $fname
 * @property string $mname
 * @property string $lname
 * @property string $code_number
 * @property string $email
 * @property string $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property int $city_id
 * @property int $country_id
 * @property string $address
 * @property int $location_id
 * @property string $bio
 * @property string $nationality_id
 * @property string $created_at
 * @property string $updated_at
 * @property UsRole $usRole
 * @property Image $image
 * @property Phone $phone
 */
class User extends Authenticatable
{
    use  Notifiable;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['code_number','image_id', 'phone_id', 'role_id', 'name', 'email', 'email_verified_at', 'password', 'remember_token','city_id', 'country_id', 'address', 'map_location','location_id','platform','mobile_token','lang','bio','nationality','created_at', 'updated_at'];

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Models\UserRole', 'role_id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class,'image_id','id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function phone()
    {
        return $this->belongsTo('App\Models\Phone','phone_id','id')->withDefault();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function socialNetwork()
    {
        return $this->hasOne(Social_network::class,'user_id','id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(){
        return $this->belongsTo(City::class,'city_id','id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(){
        return $this->belongsTo(Country::class,'country_id','id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function verification()
    {
        return $this->hasOne(Verification::class, 'user_id','id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userToken()
    {
        return $this->hasOne(User_token::class, 'user_id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function serviceProviderExperience()
    {
        return $this->hasMany(ServiceProviderExperience::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function serviceProviderExperienceDocs()
    {
        return $this->belongsToMany(Image::class,'sp_experience_docs', 'user_id','image_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paymentInfo()
    {
        return $this->hasOne(UserPaymentInfo::class,'user_id','id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userDocuments()
    {
        return $this->hasOne(UserDocuments::class,'user_id','id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function serviceProviderJobs()
    {
        return $this->belongsToMany(JobTitle::class,'sp_jobs','user_id','job_title_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class,'user_categories','user_id','category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne(Location::class,'id','location_id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function privileges()
    {
        return $this->belongsToMany(Privileges::class, 'user_privilege', 'user_id', 'privilege_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(CompanyCategories::class, 'category_id')->withDefault();
    }
}
