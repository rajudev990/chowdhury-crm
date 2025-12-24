<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $guarded = [];


    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'type',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function jobexpriences()
    {
        return $this->hasMany(JobExprience::class);
    }
    public function examtypes()
    {
        return $this->hasMany(ExamType::class);
    }
    public function englishlanguages()
    {
        return $this->hasMany(EnglishLanguage::class);
    }
    public function coursetypes()
    {
        return $this->hasMany(CourseType::class);
    }



    public function country()
    {
        return $this->belongsTo(Country::class,'preferred_country');
    }
    public function source()
    {
        return $this->belongsTo(Source::class,'source_id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class,'status_id');
    }
}
