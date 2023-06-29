<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('users', function (Blueprint $table) {
            
            $table->integer('estat')
                    ->nullable();

            $table->integer('tipusUsuari')
                    ->nullable();

            $table->string('idClientX3',10)
                    ->index()
                    ->nullable();

            $table->string('personaContacte')
                    ->nullable();

            $table->string('telefonContacte')
                  ->nullable();

            $table->string('raoSocial')
                ->nullable();

            $table->string('CIF')
                ->nullable();

            $table->string('Direccio')
                ->nullable();

            $table->string('codiPostal')
                ->nullable();

            $table->string('municipi')
                ->nullable();

            $table->string('provincia')
                ->nullable();

            $table->string('pais')
                ->nullable();

            $table->string('telefon')
                ->nullable();

            $table->boolean('isAdmin')
                ->nullable();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
