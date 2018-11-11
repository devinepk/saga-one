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
}
