<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Topics
 *
 * @property string $channel
 * @property string $setBy
 * @property string $website_trim
 * @method static \Illuminate\Database\Eloquent\Builder|Topics newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Topics newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Topics query()
 * @method static \Illuminate\Database\Eloquent\Builder|Topics whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topics whereSetBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Topics whereWebsiteTrim($value)
 * @mixin \Eloquent
 */
class Topics extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'channel_topics';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'channel';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['setBy', 'website_trim'];

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

}
