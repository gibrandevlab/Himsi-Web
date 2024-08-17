<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
/**
 * Define the model's default state.
 *
 * @return array
 */
public function definition()
{
	$pw = '12345678';
    /*return [
        'email' => 'admin@gmail.com',
        // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'password' => bcrypt($pw),
        'gender' => "laki-laki",
        'university' => 'UBSI KLA',
        'role_id' => 99
      ];*/

 }

  /**
   * Indicate that the model's email address should be unverified.
   *
   * @return \Illuminate\Database\Eloquent\Factories\Factory
   */
  public function unverified()
  {
  	return $this->state(function (array $attributes) {
  		return [
  			'email_verified_at' => null,
  		];
  	});
  }
}
