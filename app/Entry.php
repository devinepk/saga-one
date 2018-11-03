<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Entry extends Model
{
    /**
     * The attributes that should be append to the model's array form
     * and can be accessed with the accessor methods below.
     *
     * @var array
     */
    protected $appends = ['excerpt'];

    /**
     * Get the journal that owns this entry.
     */
    public function journal()
    {
        return $this->belongsTo('App\Journal');
    }

    /**
     * Get the user that wrote this entry.
     */
    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    /**
     * Compute an excerpt for this entry
     *
     * @return string
     */
    public function getExcerptAttribute() {
        // For now, strip tags and return the first 300 characters
        $chars = 300;
        $text = strip_tags($this->body);
        if (strlen($text) > $chars) {
            $text = substr($text, 0, $chars);
            // Cut off at a word boundary
            $text = substr($text, 0, strrpos($text, " "));
            $text .= '...';
        }
        return $text;
    }

    /**
     * Format the created_at attribute
     *
     * @return string
     */
    public function getCreatedAtAttribute($value) {
        $created_at = new Carbon($value, config('app.timezone'));
        $weekday = 'l';
        $month_day = '';
        if ($created_at->diffInDays() > 5) {
            $weekday = 'D';
            $month_day = ', M j';
        }
        $year = (now()->year == $created_at->year) ? '' : ', Y';
        $format_string = "{$weekday}{$month_day}{$year} \\a\\t g:ia";

        return $created_at->format($format_string);
    }
}
