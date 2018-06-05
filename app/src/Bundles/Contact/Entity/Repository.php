<?php

namespace Agora\Bundles\Contact\Entity;

use Agora\Modules\Base\Entity\BaseEntity;

class Repository extends BaseEntity
{
    /** @ORM\PostPersist */ 
    public function onPostPersist()
    {
        $mailer = '';
    }
}
