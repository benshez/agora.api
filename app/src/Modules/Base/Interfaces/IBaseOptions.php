<?php
/**
 * BaseController File Doc Comment
 *
 * PHP Version 7.0.10
 *
 * @category  BaseOptions
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/geo-services
 */

namespace Agora\Modules\Base\Interfaces;

interface IBaseOptions
{
    /**
     * Ctor Options
     *
     * @param array $options Options.
     *
     * @return void
     */
    public function __construct(array $options);

    /**
     * Set Options
     *
     * @param array $options Options.
     *
     * @return void
     */
    public function setOptions(array $options);

    /**
     * Get Options
     *
     * @return array Options
     */
    public function getOptions();

    /**
     * Get Option
     *
     * @param string $option Option.
     *
     * @return 1 Option
     */
    public function getOption(string $option);
}
