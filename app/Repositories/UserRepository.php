<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repositorio de usuarios.
 */
class UserRepository
{
    /**
     * Método para procurar um usuario especifico.
     * @param int $id
     * @return App\Models\User
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * Método para listar todos os usuarios.
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all(): Collection
    {
        return User::all();
    }

    /**
     * Método para deletar o usuario.
     * @param int $id
     * @return int 
     */
    public function delete(int $id): void
    {
        User::destroy($id);
    }

    /**
     * Método para preencher as informações do usuario.
     * @param array $attributes
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function create(array $attributes): User
    {
        return User::make($attributes);
    }

    /**
     * Método para salvar um usuario.
     * @param User $user 
     * @return void
     */
    public function save(User $user): void
    {
        $user->save();
    }

    /**
     * Método para atualizar um usuario.
     * @param User $user 
     * @param array $attributes
     * @return void
     */
    public function update(User $user, array $attributes): void
    {
        $user->update($attributes);
    }
}