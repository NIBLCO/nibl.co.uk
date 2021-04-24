<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Bots
 *
 * @property int $id
 * @property int $status_id
 * @property string $name
 * @property string $url
 * @property string $type
 * @property string $owner
 * @property string $last_seen
 * @property string $last_processed
 * @property boolean $informative
 * @property boolean $batchenable
 * @property boolean $external
 * @property int $parser_id
 * @property UpdatepacklistStatus $updatepacklistStatus
 * @property UpdatepacklistPack[] $updatepacklistPacks
 * @method static \Illuminate\Database\Eloquent\Builder|Bots newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bots newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bots query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bots whereBatchenable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bots whereExternal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bots whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bots whereInformative($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bots whereLastProcessed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bots whereLastSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bots whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bots whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bots whereParserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bots whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bots whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bots whereUrl($value)
 * @mixin \Eloquent
 * @property-read int|null $updatepacklist_packs_count
 */
class Bots extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'updatepacklist_bots';
    /**
     * @var array
     */
    protected $fillable = ['status_id', 'name', 'url', 'type', 'owner', 'last_seen', 'last_processed', 'informative', 'batchenable', 'external', 'parser_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function packs()
    {
        return $this->hasMany('App\Models\Packs', 'bot_id');
    }

}
