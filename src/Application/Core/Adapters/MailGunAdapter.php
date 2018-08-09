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

namespace AgoraApi\Application\Core\Adapters;

use AgoraApi\Application\Services\MailService;

class MailGunAdapter implements MailService
{
    /**
     * @var PHPMailer
     */
    private $_mailgun;
    /**
     * @var string
     */
    private $_domain;

    public function __construct($domain, PHPMailer $mailgun)
    {
        $this->_mailgun = $mailgun;
        $this->_domain = $domain;
    }

    public function sendHtml($to = '', $from = '', $subject = '', $html = '')
    {
        $this->_mailgun->messages()->send($this->_domain, [
            'from' => $from,
            'to' => $to,
            'subject' => $subject,
            'html' => $html,
        ]);
    }

    public function sendText($to = '', $from = '', $subject = '', $text = '')
    {
        $this->_mailgun->messages()->send($this->_domain, [
            'from' => $from,
            'to' => $to,
            'subject' => $subject,
            'text' => $text,
        ]);
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->_domain;
    }
}
