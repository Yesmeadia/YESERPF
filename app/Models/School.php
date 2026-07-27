<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The model's default attribute values.
     * Mirrors the DB column defaults so Eloquent reflects them immediately after create().
     */
    protected $attributes = [
        'status'                   => 'registered',
        'male_students'            => 0,
        'female_students'          => 0,
        'teaching_male_staff'      => 0,
        'teaching_female_staff'    => 0,
        'non_teaching_male_staff'  => 0,
        'non_teaching_female_staff'=> 0,
        'total_students'           => 0,
        'total_teachers'           => 0,
    ];

    protected $fillable = [
        'code',
        'name',
        'state_id',
        'zone_id',
        'category_id',
        'principal_name',
        'email',
        'phone',
        'address',
        'suic_code',
        // Domain fields
        'existing_domain',
        'desired_domain',
        // Students
        'male_students',
        'female_students',
        // Teaching staff
        'teaching_male_staff',
        'teaching_female_staff',
        // Non-teaching staff
        'non_teaching_male_staff',
        'non_teaching_female_staff',
        // Legacy totals (kept for backwards compatibility)
        'total_students',
        'total_teachers',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'male_students'            => 'integer',
        'female_students'          => 'integer',
        'teaching_male_staff'      => 'integer',
        'teaching_female_staff'    => 'integer',
        'non_teaching_male_staff'  => 'integer',
        'non_teaching_female_staff'=> 'integer',
        'total_students'           => 'integer',
        'total_teachers'           => 'integer',
    ];

    /** Computed total students (male + female) */
    public function getTotalStudentsComputedAttribute(): int
    {
        return ($this->male_students ?? 0) + ($this->female_students ?? 0);
    }

    /** Computed total teaching staff (male + female) */
    public function getTotalTeachingStaffAttribute(): int
    {
        return ($this->teaching_male_staff ?? 0) + ($this->teaching_female_staff ?? 0);
    }

    /** Computed total non-teaching staff (male + female) */
    public function getTotalNonTeachingStaffAttribute(): int
    {
        return ($this->non_teaching_male_staff ?? 0) + ($this->non_teaching_female_staff ?? 0);
    }

    /** Computed grand total of all staff */
    public function getTotalStaffAttribute(): int
    {
        return $this->total_teaching_staff + $this->total_non_teaching_staff;
    }

    // Relationships
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(SchoolStatusHistory::class)->orderBy('created_at', 'desc');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class)->orderBy('created_at', 'desc');
    }

    // Query Scopes — new status lifecycle
    public function scopeRegistered(Builder $query): Builder
    {
        return $query->where('status', 'registered');
    }

    public function scopeUnderConstruction(Builder $query): Builder
    {
        return $query->where('status', 'under_construction');
    }

    public function scopeTrialRunning(Builder $query): Builder
    {
        return $query->where('status', 'trial_running');
    }

    public function scopeOnGoing(Builder $query): Builder
    {
        return $query->where('status', 'on_going');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (empty($term)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('code', 'like', "%{$term}%")
              ->orWhere('principal_name', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%");
        });
    }

    public static function generateUniqueCode(): string
    {
        $prefix = 'SCH-' . date('Y');
        $random = strtoupper(substr(uniqid(), -5));
        $code = "{$prefix}-{$random}";

        while (static::where('code', $code)->exists()) {
            $random = strtoupper(substr(uniqid(), -5));
            $code = "{$prefix}-{$random}";
        }

        return $code;
    }
}
