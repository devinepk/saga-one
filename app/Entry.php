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
    protected $appends = ['excerpt', 'formatted_created_at', 'formatted_updated_at'];

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
     * Format the created_at attribute for display
     *
     * @return string
     */
    public function getFormattedCreatedAtAttribute() {
        return $this->formatDate(new Carbon($this->created_at, config('app.timezone')));
    }

    /**
     * Format the updated_at attribute for display
     *
     * @return string
     */
    public function getFormattedUpdatedAtAttribute() {
        return $this->formatDate(new Carbon($this->updated_at, config('app.timezone')));
    }

    protected function formatDate(Carbon $date) {
        $weekday = 'l';
        $month_day = '';
        if ($date->diffInDays() > 5) {
            $weekday = 'D';
            $month_day = ', M j';
        }
        $year = (now()->year == $date->year) ? '' : ', Y';
        $format_string = "{$weekday}{$month_day}{$year} \\a\\t g:ia";

        return $date->format($format_string);
    }
}
