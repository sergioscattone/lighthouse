<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Query\Builder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    CONST HIEGHEST_QT = 5;

    public function orders(): HasMany
    {
        return $this->HasMany(Order::class, 'user_id');
    }

    public function mostExpensiveOrder(): HasOne
    {
        return $this->HasOne(Order::class, 'user_id')->orderBy('total_amount', 'desc');
    }

    public function withAllProducts(): Builder
    {
        return User::whereIn('id', function($query) {
            // I prefered to use functional $query way instead of User::select('user_id')
            // because 'user_id' does not belong to users, it belongs to a pivot subquery
            $query->select('user_id')
                ->from(
                    // IDK how to write DB::raw('count(DISTINCT `product_id`) as user_prod_qt') with eloquent :'(
                    Order::select('user_id', DB::raw('count(DISTINCT `product_id`) as user_prod_qt'))
                        ->groupBy('user_id')
                        ->having('user_prod_qt', Product::count())
                );
        })
        ->getQuery();
    }

    public function withHighestTotalSales(): Builder
    {
        return User::whereIn('id', function($query) {
            // I prefered to use functional $query way instead of User::select('user_id')
            // because 'user_id' does not belong to users, it belongs to a pivot subquery
            $query->select('user_id')
                ->from(
                    // IDK how to write DB::raw('sum(`total_amount`) as user_prod_amount') with eloquent :'(
                    Order::select('user_id', DB::raw('sum(`total_amount`) as user_prod_amount'))
                        ->groupBy('user_id')
                        ->orderBy('user_prod_amount', 'desc')
                        ->limit(self::HIEGHEST_QT)
                );
        })
        ->getQuery();
    }
}
