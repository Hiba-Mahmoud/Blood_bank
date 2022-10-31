<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDonationRequestsTable extends Migration {

	public function up()
	{
		Schema::create('donation_requests', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('patient_name', 100);
			$table->string('patient_phone', 11);
			$table->smallInteger('patient_age');
			$table->integer('city_id')->unsigned();
			$table->string('hospital_name');
			$table->string('hospital_address');
			$table->integer('blood_type_id')->unsigned();
			$table->smallInteger('bags_num');
			$table->text('details');
			$table->integer('client_id')->unsigned();
			$table->decimal('longitude', 10,8);
			$table->decimal('latitude', 10,8);
		});
	}

	public function down()
	{
		Schema::drop('donation_requests');
	}
}