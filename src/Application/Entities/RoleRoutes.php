<?php

/*
 * This file is part of the Agora API.
 *
 * PHP Version 7.1.9
 *
 * @category  Agora
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/agora.api
 */

declare(strict_types=1);

namespace AgoraApi\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoleRoutes.
 *
 * @ORM\Table(name="role_routes", indexes={@ORM\Index(name="fk_role_routes_role_id_roles_id_idx", columns={"roles_id"})})
 * @ORM\Entity
 */
class RoleRoutes
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
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * })
     */
    private $role;

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
     * @return RoleRoutes
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
     * @return RoleRoutes
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
     * @return RoleRoutes
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
     * Set role.
     *
     * @param \AgoraApi\Application\Entities\Roles|null $role
     *
     * @return RoleRoutes
     */
    public function setRole(\AgoraApi\Application\Entities\Roles $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return \AgoraApi\Application\Entities\Roles|null
     */
    public function getRole()
    {
        return $this->role;
    }
}
