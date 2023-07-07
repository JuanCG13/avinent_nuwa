<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HasNoTeam;
use Lab404\Impersonate\Models\Impersonate;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasNoTeam, HasTeams {
        HasNoTeam::ownsTeam insteadof HasTeams;
        HasNoTeam::isCurrentTeam insteadof HasTeams;
    }
    use Impersonate;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'estat',
        'tipusUsuari',
        'personaContacte',
        'telefonContacte',
        'idClientX3',
        'raoSocial',
        'CIF',
        'direccio',
        'codipostal',
        'municipi',
        'provincia',
        'pais',
        'telefon',
        'isAdmin',
        'created_at'
    ];

  
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'isAdmin' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function canImpersonate()
    {
         if ($this->isAdmin == 1 || $this->tipusUsuari == 1) 
             return true;
    }

    public function canBeImpersonated()
    {
         if ($this->isAdmin == 1) 
             return true;
    }

    public function getLoginRoute()
    {
  
        if ($this->isAdmin) 
            return 'admin.dashboard';

        switch($this->estat) {
            case 0: return 'welcome';
            default: return 'dashboard';
        }

    }
}
