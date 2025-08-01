<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property string $role
 * @property string|null $facility_name
 * @property string|null $license_number
 * @property string|null $phone_number
 * @property string|null $barangay
 * @property string $status
 * @property string|null $email_verification_token
 * @property int $email_verification_attempts
 * @property \Illuminate\Support\Carbon|null $last_verification_email_sent_at
 * @property \Illuminate\Support\Carbon|null $email_verification_expires_at
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method bool isAdmin()
 * @method bool isParent()
 * @method bool isNutritionist()
 * @method bool isApproved()
 * @method bool isPending()
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'facility_name',
        'license_number',
        'phone_number',
        'barangay',
        'status',
        'email_verification_token',
        'email_verification_attempts',
        'last_verification_email_sent_at',
        'email_verification_expires_at',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_token',
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
            'last_verification_email_sent_at' => 'datetime',
            'email_verification_expires_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'email_verification_attempts' => 0,
        'is_active' => true,
        'status' => 'email_pending',
    ];

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a parent/guardian
     */
    public function isParent(): bool
    {
        return $this->role === 'parents';
    }
    
    /**
     * Check if user is a nutritionist
     */
    public function isNutritionist(): bool
    {
        return $this->role === 'nutritionist';
    }

    /**
     * Check if user is approved
     */
    public function isApproved(): bool
    {
        return $this->getAttribute('status') === 'approved';
    }

    /**
     * Check if user is pending approval
     */
    public function isPending(): bool
    {
        return $this->getAttribute('status') === 'pending';
    }

    /**
     * Generate email verification token
     */
    public function generateEmailVerificationToken(): string
    {
        $token = Str::random(60);
        $currentAttempts = $this->getAttribute('email_verification_attempts') ?? 0;
        
        $this->forceFill([
            'email_verification_token' => $token,
            'email_verification_expires_at' => now()->addMinutes(60),
            'last_verification_email_sent_at' => now(),
            'email_verification_attempts' => $currentAttempts + 1,
        ])->save();
        
        return $token;
    }

    /**
     * Mark email as verified
     */
    public function markEmailAsVerified(): bool
    {
        $this->forceFill([
            'email_verified_at' => now(),
            'email_verification_token' => null,
            'email_verification_expires_at' => null,
            'status' => $this->role === 'nutritionist' ? 'pending' : 'approved',
        ])->save();

        return true;
    }

    /**
     * Check if verification token is expired
     */
    public function isVerificationTokenExpired(): bool
    {
        $expiresAt = $this->getAttribute('email_verification_expires_at');
        if (!$expiresAt) {
            return false;
        }
        
        return now()->isAfter($expiresAt);
    }

    /**
     * Check if user can request new verification email (rate limiting)
     */
    public function canRequestVerificationEmail(): bool
    {
        $lastSent = $this->getAttribute('last_verification_email_sent_at');
        if (!$lastSent) {
            return true;
        }
        
        // Allow new request after 1 minute
        return now()->isAfter(Carbon::parse($lastSent)->addMinutes(1));
    }

    /**
     * Check if verification attempts exceeded limit
     */
    public function hasExceededVerificationAttempts(): bool
    {
        $attempts = $this->getAttribute('email_verification_attempts') ?? 0;
        return $attempts >= 5;
    }

    /**
     * Determine if the user has verified their email address.
     */
    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->getAttribute('email_verified_at'));
    }

    /**
     * Get the email address that should be used for verification.
     */
    public function getEmailForVerification(): string
    {
        return $this->getAttribute('email');
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification(): void
    {
        $token = $this->generateEmailVerificationToken();
        $this->notify(new \App\Notifications\VerifyEmailNotification($token));
    }

    /**
     * Get the children (patients) for the parent user
     */
    public function children()
    {
        return $this->hasMany(Patient::class, 'parent_id');
    }
}
