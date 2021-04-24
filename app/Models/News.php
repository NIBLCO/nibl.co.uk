<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\News
 *
 * @property int $sn_id
 * @property string $sn_created_by
 * @property string $sn_context
 * @property string $sn_created_at
 * @property string $sn_published_at
 * @method static \Illuminate\Database\Eloquent\Builder|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News query()
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSnContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSnCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSnCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSnPublishedAt($value)
 * @mixin \Eloquent
 */
class News extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'site_news';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'sn_id';

    /**
     * @var array
     */
    protected $fillable = ['sn_created_by', 'sn_context', 'sn_created_at', 'sn_published_at'];

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

}
