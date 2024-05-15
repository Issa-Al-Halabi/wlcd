<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAboutsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('abouts')){
			Schema::create('abouts', function(Blueprint $table)
			{
				$table->increments('id');
				$table->text('about_description');

				$table->text('one_heading');
				$table->text('one_text');
				$table->string('one_first_image', 191);
				$table->string('one_second_image', 191);
				$table->string('one_third_image', 191);
				
				$table->text('two_heading');
				$table->text('two_text');

				$table->text('two_first_title');
				$table->text('two_first_text');
				$table->string('two_first_image', 191);

				$table->text('two_second_title');
				$table->text('two_second_text');
				$table->string('two_second_image', 191);

				$table->text('two_third_title');
				$table->text('two_third_text');
				$table->string('two_third_image', 191);

				$table->text('three_first_heading');
				$table->text('three_first_text');
				$table->string('three_first_image', 191);

				
				$table->text('three_second_heading');
				$table->text('three_second_text');
				$table->string('three_second_image', 191);

				$table->text('facebook_link')->nullable();
				$table->text('twitter_link')->nullable();
				$table->text('instagram_link')->nullable();
				$table->text('linkedin_link')->nullable();
				$table->text('youtube_link')->nullable();

				$table->timestamps();
			});
		}
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('abouts');
	}

}
