<?php

namespace AgoraApi\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * RolesRoutes
 *
 * @ORM\Table(name="roles_routes", indexes={@ORM\Index(name="fk_role_routes_role_id_roles_id_idx", columns={"roles_id"})})
 * @ORM\Entity
 */
class RolesRoutes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=45, nullable=false)
     */
    private $route;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \AgoraApi\Application\Entities\Roles
     *
     * @ORM\ManyToOne(targetEntity="AgoraApi\Application\Entities\Roles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="roles_id", referencedColumnName="id")
     * })
     */
    private $roles;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set route.
     *
     * @param string $route
     *
     * @return RolesRoutes
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route.
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return RolesRoutes
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return RolesRoutes
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set roles.
     *
     * @param \AgoraApi\Application\Entities\Roles|null $roles
     *
     * @return RolesRoutes
     */
    public function setRoles(\AgoraApi\Application\Entities\Roles $roles = null)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles.
     *
     * @return \AgoraApi\Application\Entities\Roles|null
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
