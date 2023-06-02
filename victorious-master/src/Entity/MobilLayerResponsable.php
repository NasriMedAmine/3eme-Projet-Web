<?php

namespace App\Entity;

class MobilLayerResponsable
{

    public function __construct()
    {
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    private User $user;



}