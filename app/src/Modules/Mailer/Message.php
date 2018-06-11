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

namespace Agora\Modules\Mailer;

class Message
{
    protected $mailer;

    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    public function to($address)
    {
        $this->mailer->addAddress($address);
    }

    public function subject($subject)
    {
        $this->mailer->Subject = $subject;
    }

    public function body($body)
    {
        $this->mailer->Body = $body;
    }

    public function from($from)
    {
        $this->mailer->From = $from;
    }

    public function fromName($fromName)
    {
        $this->mailer->FromName = $fromName;
    }
}
