<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Entry extends Model
{

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
    public function getExcerptAttribute()
    {
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
    public function getFormattedCreatedAtAttribute()
    {
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

    /**
     * Format a date for display
     *
     * @param Carbon $date
     * @return string
     */
    protected function formatDate(Carbon $date)
    {

        if ($date->diffInDays() < 1) {

            $today = '\\t\\o\\d\\a\\y';
            $weekday = $month_day = $year = '';

        } else {

            $today = '\\o\\n ';
            $weekday = 'l';
            $month_day = '';

            if ($date->diffInDays() > 5) {
                $weekday = 'D';
                $month_day = ', M j';
            }

            $year = (now()->year == $date->year) ? '' : ', Y';
        }

        $format_string = "{$today}{$weekday}{$month_day}{$year} \\a\\t g:ia";

        return $date->format($format_string);
    }
}
