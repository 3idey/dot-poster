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
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'city',
        'role',
        'avatar',
        'is_banned',
        'google_id',
        'google_token',
        'google_refresh_token',
    ];

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

    // relationships
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function wishlistProducts()
    {
        return $this->belongsToMany(Product::class, 'wishlists')->withTimestamps();
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isVendor()
    {
        return $this->role === 'vendor';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function isActive()
    {
        return $this->is_active;
    }

    public function getAvatarUrlAttribute()
    {
        if (! $this->avatar) {
            return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=0D8ABC&color=fff';
        }

        // If avatar starts with http, it's a Google/external URL
        if (str_starts_with($this->avatar, 'http')) {
            return $this->avatar;
        }

        // Otherwise, it's a local file
        return asset('storage/'.$this->avatar);
    }
    public function isSubscribed()
    {
        return \App\Models\Newsletter::where('email', $this->email)
            ->where('is_active', true)
            ->exists();
    }

    public function savedPaymentMethods()
    {
        return $this->hasMany(SavedPaymentMethod::class);
    }

    public function getDefaultPaymentMethodAttribute()
    {
        return $this->savedPaymentMethods()->where('is_default', true)->first();
    }
}
