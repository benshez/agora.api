<?php
/**
 * Save File Doc Comment
 *
 * PHP Version 7.0.10
 *
 * @category  Save
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/geo-services
 */

namespace Agora\Bundles\Industries\Controller;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Agora\Modules\Base\Options\BaseOptions;
use Agora\Modules\Base\Controller\BaseController;
use Agora\Bundles\Industries\Interfaces\IIndustriesController;

class Controller extends BaseController implements IIndustriesController
{
    private $_options = array(
        'part' => 'messages',
        'class' => 'industries',
        'extention' => 'validation:autocomplete:message:IndustriesNotFound'
    );
    
    /**
     * Find Industry By Description
     *
     * @param RequestInterface  $request  Request Interface.
     *
     * @param ResponseInterface $response Response Interface.
     *
     * @param array             $args     Args.
     *
     * @return Industry
     */
    public function autoComplete(
        RequestInterface $request,
        ResponseInterface $response,
        array $args
    ) {
        $fetched = $this->fetched(
            $request,
            $response,
            $this->getAction()->autoComplete(
                $args
            ),
            new BaseOptions($this->_options)
        );
        
        if ($fetched) {
            return $fetched;
        }
        
        return false;
    }
}
