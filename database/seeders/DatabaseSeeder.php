<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Member;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	public function run()
	{
		$roles = [
			['id' => 99, 'roleName' => 'admin'],
			['id' => 1, 'roleName' => 'member'],
			['id' => 2, 'roleName' => 'guest'],
		];

		Role::insert($roles);

		$pw = bcrypt('12345678');
		$users = [
			['email' => 'admin@gmail.com', 'password' => $pw, 'gender' => 'laki-laki', 'university' => 'UBSI KLA', 'role_id' => 99],
			['email' => 'ketua@gmail.com', 'password' => $pw, 'gender' => 'laki-laki', 'university' => 'UBSI KLA', 'role_id' => 1],
			['email' => 'wakil@gmail.com', 'password' => $pw, 'gender' => 'laki-laki', 'university' => 'UBSI KLA', 'role_id' => 1],
			['email' => 'bendahara@gmail.com', 'password' => $pw, 'gender' => 'perempuan', 'university' => 'UBSI KLA', 'role_id' => 1],
			['email' => 'sekretaris@gmail.com', 'password' => $pw, 'gender' => 'perempuan', 'university' => 'UBSI KLA', 'role_id' => 1],
			['email' => 'rsdm@gmail.com', 'password' => $pw, 'gender' => 'laki-laki', 'university' => 'UBSI KLA', 'role_id' => 1],
		];

		User::insert($users);

		$members = [
			['id' => 1, 'name' => 'has adhi', 'address' => 'bekasi', 'nim' => '12345671', 'status' => 1, 'phoneNumber' => '899926469501', 'occupation' => 'ketua', 'token' => '2TDSQDY2', 'periode' => '2024-2025', 'user_id' => 2],
			['id' => 2, 'name' => 'sultan', 'address' => 'bekasi', 'nim' => '12345672', 'status' => 1, 'phoneNumber' => '899926469502', 'occupation' => 'wakil ketua', 'token' => 'Y0E9RWDZ', 'periode' => '2024-2025', 'user_id' => 3],
			['id' => 3, 'name' => 'hani', 'address' => 'bekasi', 'nim' => '12345673', 'status' => 1, 'phoneNumber' => '899926469503', 'occupation' => 'bendahara', 'token' => 'P5LSIAFU', 'periode' => '2024-2025', 'user_id' => 4],
			['id' => 4, 'name' => 'indah', 'address' => 'bekasi', 'nim' => '12345674', 'status' => 1, 'phoneNumber' => '899926469504', 'occupation' => 'sekretaris', 'token' => 'NGATPFI2', 'periode' => '2024-2025', 'user_id' => 5],
			['id' => 5, 'name' => 'zaldi', 'address' => 'bekasi', 'nim' => '12345675', 'status' => 1, 'phoneNumber' => '899926469505', 'occupation' => 'ketua koordinator rsdm', 'token' => 'XHH1LHP6', 'periode' => '2024-2025', 'user_id' => 6],
		];

		Member::insert($members);
	}
}
