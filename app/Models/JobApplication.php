<?php

namespace App\Models;

use Database\Factories\JobApplicationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    /** @use HasFactory<JobApplicationFactory> */
    use HasFactory;

    protected $fillable = ['job_opening_id', 'role_title', 'full_name', 'email', 'phone', 'location', 'qualification', 'experience_years', 'current_company', 'notice_period', 'cover_letter', 'resume_path'];

    public function jobOpening(): BelongsTo
    {
        return $this->belongsTo(JobOpening::class)->withTrashed();
    }

    protected function casts(): array
    {
        return ['experience_years' => 'integer'];
    }
}
