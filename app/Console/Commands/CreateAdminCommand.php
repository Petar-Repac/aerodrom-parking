<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin account for the dashboard';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->ask('Admin name');
        $email = $this->ask('Admin email');

        $validator = Validator::make(
            ['name' => $name, 'email' => $email],
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            ],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $password = $this->secret('Admin password');
        $passwordConfirmation = $this->secret('Confirm password');

        $passwordValidator = Validator::make(
            ['password' => $password, 'password_confirmation' => $passwordConfirmation],
            ['password' => ['required', 'confirmed', Password::min(8)]],
        );

        if ($passwordValidator->fails()) {
            foreach ($passwordValidator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $admin = User::create([
            'name' => $name,
            'email' => $email,
            // The User model's 'password' cast is 'hashed', so this hashes automatically.
            'password' => $password,
        ]);

        $this->info(sprintf('Admin "%s" <%s> created successfully.', $admin->name, $admin->email));

        return self::SUCCESS;
    }
}
