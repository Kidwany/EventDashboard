<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @property integer $id
 * @property integer $user_id
 * @property string $passport_no
 * @property string $passport_expire_date
 * @property int $identity_image_id
 */
class UserDocuments extends Model
{
    /**
     * @var string
     */
    protected $connection = 'mysql';
    /**
     * @var string
     */
    protected $table = 'user_documents';

    /**
     * @var array
     */
    protected $fillable = ['user_id','passport_no','passport_expire_date','identity_image_id', 'second_identity_image_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function identityImage()
    {
        return $this->belongsTo(Image::class,'identity_image_id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function back_image()
    {
        return $this->belongsTo(Image::class,'second_identity_image_id')->withDefault();
    }


}
