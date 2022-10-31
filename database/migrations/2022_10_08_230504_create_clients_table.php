<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 50);
			$table->string('phone', 11)->unique();
			$table->string('email', 50)->unique();
			$table->string('password');
			$table->date('date_of_birth');
			$table->integer('blood_type_id')->unsigned();
			$table->date('last_donation_date');
			$table->integer('city_id')->unsigned();
			$table->string('pin_code', 5);
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}
