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
use Mailgun\Mailgun;

class MailGunAdapter implements MailService
{
    /**
     * @var Mailgun
     */
    private $mailgun;
    /**
     * @var string
     */
    private $domain;

    public function __construct($domain, Mailgun $mailgun)
    {
        $this->mailgun = $mailgun;
        $this->domain = $domain;
    }

    public function sendHtml($to = '', $from = '', $subject = '', $html = '')
    {
        $this->mailgun->messages()->send($this->domain, [
            'from' => $from,
            'to' => $to,
            'subject' => $subject,
            'html' => $html,
        ]);
    }

    public function sendText($to = '', $from = '', $subject = '', $text = '')
    {
        $this->mailgun->messages()->send($this->domain, [
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
        return $this->domain;
    }
}
