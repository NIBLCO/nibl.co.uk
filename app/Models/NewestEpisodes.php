<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\NewestEpisodes
 *
 * @property int $id
 * @property string $seriesname
 * @property int $nextepisode
 * @property boolean $active
 * @method static \Illuminate\Database\Eloquent\Builder|NewestEpisodes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewestEpisodes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NewestEpisodes query()
 * @method static \Illuminate\Database\Eloquent\Builder|NewestEpisodes whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewestEpisodes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewestEpisodes whereNextepisode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NewestEpisodes whereSeriesname($value)
 * @mixin \Eloquent
 */
class NewestEpisodes extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'newestepisode';

    /**
     * @var array
     */
    protected $fillable = ['seriesname', 'nextepisode', 'active'];

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

}
