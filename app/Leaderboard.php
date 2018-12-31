<?php declare(strict_types=1);

namespace App;

use App\Course;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leaderboard extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'score'
    ];

    public function getScoreAttribute($value): int
    {
        // Overkill validation in case the DB data is incorrect for some reason
        if (is_int($value) && $value >= 0) {
            return $value;
        }

        return 0;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
