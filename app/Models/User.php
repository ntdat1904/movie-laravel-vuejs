<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements JWTSubject
{
    CONST ROOT_FOLDER = '/files/';

    protected $table = 'users';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_url', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function like()
    {
        return $this->hasMany(UseLikes::class,'user_id');
    }

    protected function _buildUsers($params)
    {
        $users = User::select('*');
        foreach ($params->all() as $key => $item) {
            switch ($key) {
                case 'id':
                    $users = $users->where('users.id', $item);
                    break;
                case 'name':
                    $users = $users->where('users.name', 'like', sprintf("%%%s%%", trim($item)));
                    break;
                case 'role':
                    $users = $users->where('users.role', $item);
                    break;
                case 'email':
                    $users = $users->where('users.email', 'like', sprintf("%%%s%%", trim($item)));
                    break;
                case 'to':
                    $users = $users->where('users.created_at', '<=', $item);
                    break;
                case 'from':
                    $users = $users->where('users.created_at', '>=', $item);
                    break;
            }
        }
        if (!empty($params['sort']) && !empty($params['order'])) {
            $users = $users->orderBy($params['order'], $params['sort']);
        }
        $users = $users->paginate($params['per_page'] ?? 5);
        if ($users->lastPage() < $users->currentPage()) {
            $params['page'] = $users->lastPage();
            $users = self::_buildUsers($params);
        }
        foreach ($users as $user) {
            $user->img = false;
            if (!empty($user->avatar_url) && Storage::disk('my_upload')->exists(str_replace(self::ROOT_FOLDER, '', $user->avatar_url))) {
                $user->img = true;
            }
        }
        return $users;
    }

    public function sendPasswordResetNotification($token)
    {
        $user = User::where('email',$this->email)->first();
        $user->remember_token = $token;
        $user->save();
        $this->notify(new ResetPassword($token));
    }
}
