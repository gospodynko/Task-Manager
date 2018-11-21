<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $length = 24;
        $data = [
            [
                'role'    => 'admin',
                'email' => 'test@gmail.com',
                'password' => password_hash("admin", PASSWORD_DEFAULT), //bcrypt,
                'token' => $token = bin2hex(random_bytes($length)),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ];

        $posts = $this->table('users');
        $posts->insert($data)
            ->save();
    }
}
