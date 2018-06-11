<?php
/**
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

namespace Agora\Modules\Base\Options;

use Agora\Modules\Base\Interfaces\IBaseOptions;

class BaseOptions implements IBaseOptions
{
    private $_options = ['part' => '', 'class' => '', 'extention' => ''];

    /**
     * Ctor Options
     *
     * @param array $options Options.
     */
    public function __construct(array $options)
    {
        $this->setOptions($options);
    }

    /**
     * Set Options
     *
     * @param array $options Options.
     */
    public function setOptions(array $options)
    {
        $this->_options = array_merge($this->_options, $options);
    }

    /**
     * Get Options
     *
     * @return array Options
     */
    public function getOptions()
    {
        $options = $this->_options;

        return $options;
    }

    /**
     * Get Options
     *
     * @param string $option Option.
     *
     * @return Option
     */
    public function getOption(string $option)
    {
        $option = $this->_options[$option];

        return $option;
    }
}
