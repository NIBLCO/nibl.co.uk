<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

/**
 * App\Models\Packs
 *
 * @property integer $id
 * @property int $bot_id
 * @property int $number
 * @property string $name
 * @property string $size
 * @property integer $sizekbits
 * @property int $episode_number
 * @property string $last_modified
 * @property UpdatepacklistBot $updatepacklistBot
 * @method static \Illuminate\Database\Eloquent\Builder|Packs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Packs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Packs query()
 * @method static \Illuminate\Database\Eloquent\Builder|Packs whereBotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Packs whereEpisodeNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Packs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Packs whereLastModified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Packs whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Packs whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Packs whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Packs whereSizekbits($value)
 * @mixin \Eloquent
 */
class Packs extends Model
{
    use Sortable;

    public $sortable = ['number', 'name', 'sizekbits'];

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
    protected $table = 'updatepacklist_packs';
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';
    /**
     * @var array
     */
    protected $fillable = ['bot_id', 'number', 'name', 'size', 'sizekbits', 'episode_number', 'last_modified'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bot()
    {
        return $this->belongsTo('App\Models\Bots', 'bot_id');
    }
}
