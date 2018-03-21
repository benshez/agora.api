<?php



namespace Agora\Modules\Base\Actions;

use Interop\Container\ContainerInterface;
use Agora\Modules\Base\Actions\BaseAction;
use Agora\Modules\Base\Actions\BaseSave;

class BaseDelete extends BaseAction
{

    /**
     * Base Delete Action
     *
     * @param $entity Entity Class.
     *
     * @return void
     */
    public function delete($entity)
    {
        $manager = $this->getEntityManager();
        $manager->remove($entity);
        $manager->flush($entity);
    }
}
