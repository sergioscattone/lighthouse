<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function mostExpensiveOrder(): Order|null
    {
        return Order::where('user_id', $this->id)->orderBy('total_amount')->limit(1)->first();
    }

    public function withAllProducts(): Builder
    {
        return DB::table($this->getTable())
            ->whereIn('id', function($query)
            {
                $query->select(DB::raw(
                    '`user_id` from (select `user_id`, count(DISTINCT `product_id`) as user_prod_qt '.
                    'FROM orders group by user_id having user_prod_qt = (select count(id) from `products`)) as pre_filter'));
            });
    }

    public function withHighestTotalSales(): Builder
    {
        return DB::table($this->getTable())
            ->whereIn('id', function($query)
            {
                $query->select(DB::raw(
                    '`user_id` from (select `user_id`, sum(`total_amount`) as user_prod_amount '.
                    'FROM orders group by user_id order by user_prod_amount desc limit '.self::HIEGHEST_QT.') as pre_filter'));
            });
    }
}
