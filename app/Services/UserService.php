<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\UserRepository;


/**
 * Essa classe é responsavel pela regra de negócio do User.
 */
class UserService
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Método para obter todos os usuarios.
     * 
     * @return \Illuminate\Database\Eloquent\Collection; 
     */
    public function getAll(): Collection
    {
        return $this->repository->all();
    }

    /**
     * Método para encontrar o id da transaction.
     * 
     * @param int $id
     * @return \App\Models\User|null
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail( $id): ?User
    {
        return $this->repository->findOrFail($id);
    }

    /**
     * Método responsavel por salvar os dados do usuario.
     * @param array $attributes
     * @return \App\Models\User
     */
    public function save(array $attributes): User
    {
        $user = $this->repository->create($attributes);
        $this->repository->save($user);
        return $user;
    }

    /**
     * Método responsavel por atualizar o usuario pelo seu id.
     * @param int $id
     * @param array $attributes
     * @return \App\Models\User
     */
    public function updateById(int $id, array $attributes): User
    {
        $user = $this->repository->findOrFail($id);
        $this->repository->update($user, $attributes);
        return $user;
    }

    /**
     * Método responsavel por deletar o usuario pelo seu id
     * @param int $id
     * @return void
     */
    public function deleteById(int $id): void
    {
        $this->repository->delete($id);
    }
}