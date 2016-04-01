<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('region')->index(); //region name
            $table->string('province')->index(); //province name
            $table->string('town')->index(); //town name
            $table->string('barangay')->index(); //barangay name
            $table->string('place')->index(); //polling place name
            $table->string('cluster')->index(); //cluster id
            $table->string('precinct')->index(); //precinct number
            $table->integer('registered_voters')->unsigned()->nullable(); //count of registered voters
//            $table->unique(
//                [
//                    'region',
//                    'province',
//                    'town',
//                    'barangay',
//                    'place',
//                    'cluster',
//                    'precinct'
//                ]
//            );
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pops');
    }
}
