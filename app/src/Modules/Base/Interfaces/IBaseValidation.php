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

namespace Agora\Modules\Base\Interfaces;

interface IBaseValidation
{
    public function __construct(IBaseAction $action);

    public function setAction(IBaseAction $action);

    public function getAction();

    public function setMessagesArray($error = null, $class = null, $key = null);

    public function getMessagesAray();

    public function isValid($value);

    public function formIsValid(array $fields, array $values);

    public function create();

    public function createValidators(array $fields, array $values);

    public function dispose();
}
