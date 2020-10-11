<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property string $organization_id
 * @property string $commercial_register
 * @property int $chamber_of_commerce_membership
 * @property string $social_insurance
 * @property int $zakkah_certificate
 * @property string $saawada_certificate
 * @property string $updated_at
 */

class OrganizationDocs extends Model
{
    protected $connection = 'mysql';
    protected $table = 'organizations_docs';
}
