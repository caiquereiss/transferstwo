<?php
namespace App\Repositories;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;



class UserRepository
{
    public function findOrFail( $id): User
    {
        return User::findOrFail($id);
    }

    public function all(): Collection
    {
        return User::all();
    }

    public function delete(int $id): void
    {
        User::destroy($id);
    }

    public function create(array $attributes): User
    {
        return User::make($attributes);
    }

    public function save(User $user): void
    {
        $user->save();
    }

    public function update(User $user, array $attributes): void
    {
        $user->update($attributes);
    }
}