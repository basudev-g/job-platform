<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{

    use HasFactory, Notifiable;


    protected $fillable = [
        'name', 'email', 'password', 'role', 'company_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

     // JWT methods
    public function getJWTIdentifier() { return $this->getKey(); }
    public function getJWTCustomClaims() { return []; }

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function jobListings()
    {
        return $this->hasMany(JobListing::class, 'posted_by');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
