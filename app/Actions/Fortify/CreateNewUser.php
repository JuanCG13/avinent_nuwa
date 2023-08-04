<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Notifications\UserWelcome;




class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {

        if ($input['customer_type'] == 'A')  {

            $validator = Validator::make($input, [
                'idClientX3' => ['required', 'string', 'unique:users'],
                'cif' => ['required', 'string'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            ]);
                  
            $validator->after(function ($validator) use ($input)  {
                if ($this->checkX3CIFPair($input) == false) {  
                    $validator->errors()->add('idClientX3', __('idX3CIF'));
                }
    
            });

            $validator->validate();

            $newUser = $this->createUserTypeA($input);

            return $newUser;
        }

        if ($input['customer_type'] == 'B')  {

            Validator::make($input, [
                'name' => ['required', 'string'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            ])->validate();

            return $this->createUserTypeB($input);
        }



    }

    protected function checkX3CIFPair($input): Bool {

        if(DB::table('tClients')
        ->select('raoSocial')
        ->whereRaw("idClientX3 = '".$input['idClientX3']."' AND CIF = '".$input['cif']."'")
        ->first()) {
            return true;
        }

        return false;
        
    }

    protected function createUserTypeA($input): User {

        $client = DB::table('tClients')
                    ->select('raoSocial')
                    ->whereRaw("idClientX3 = '".$input['idClientX3']."' AND CIF = '".$input['cif']."'")
                    ->first();
                
        return DB::transaction(function () use ($input, $client) {
            return tap(
                User::create([
                'idClientX3' => $input['idClientX3'],
                'CIF' => $input['cif'],
                'name' => $client->raoSocial,
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'estat' => 1,
                'tipusUsuari' => 1,
                'isAdmin' => 0,
                ]
        ), function (User $user) {
                $this->createTeam($user);
            });
        });


    }


    protected function createUserTypeB($input): User {

            return DB::transaction(function () use ($input) {
                return tap(
                    User::create([
                    'CIF' => $input['cif'],
                    'name' => $input['name'],
                    'raoSocial' => $input['company_name'],
                    'direccio' => $input['direccio'],
                    'municipi' => $input['municipi'],
                    'codipostal' => $input['codipostal'],
                    'provincia' => $input['provincia'],
                    'pais' => $input['pais'],
                    'telefon' => $input['telefon'],
                    'personaContacte' => $input['contact_person'],
                    'telefonContacte' => $input['contact_phone'],
                    'email' => $input['email'],
                    'password' => Hash::make($input['password']),
                    'estat' => 0,
                    'tipusUsuari' => 1,
                    'isAdmin' => 0,
                    ]
            ), function (User $user) {
                    $this->createTeam($user);
                });
            });
        } 



    /**
     * Create a personal team for the user.
     */
    protected function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => $user->name."'s Team",
            'personal_team' => true,
        ]));
    }
}

