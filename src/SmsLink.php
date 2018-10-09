<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 10/4/18
 * Time: 14:30
 */

namespace nguyenanhung\VnTelcoPhoneNumber;
if (!interface_exists('nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'ProjectInterface.php';
}
if (!interface_exists('nguyenanhung\VnTelcoPhoneNumber\Interfaces\SmsLinkInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'SmsLinkInterface.php';
}

use nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterface;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\SmsLinkInterface;
use nguyenanhung\VnTelcoPhoneNumber\Repository;

/**
 * Class SmsLink
 *
 * @package    nguyenanhung\VnTelcoPhoneNumber
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
class SmsLink implements ProjectInterface, SmsLinkInterface
{
    /**
     * SmsLink constructor.
     */
    public function __construct()
    {
    }

    /**
     * Function getVersion
     *
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/9/18 13:38
     *
     * @return mixed|string Current Project Version
     * @example 1.0.0
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Function addScript
     * Call with add Content Js Sms
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 13:39
     *
     * @return mixed|null Content Js Sms Link from file config sms_link
     * @see   /Repository/config/sms_link.php
     */
    public function addScript()
    {
        $smsLink = Repository\DataRepository::getData('sms_link');
        if (isset($smsLink['script'])) {
            return $smsLink['script'];
        }

        return NULL;
    }

    /**
     * Function getLink
     * Get Link include Sms to Sending, use Content place href='''
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 13:40
     *
     * @param string $phone_number Phone number to parse
     * @param string $body         Body Sms to Sending
     *
     * @return mixed|string Content Send Sms
     */
    public function getLink($phone_number = '', $body = '')
    {
        if (!empty($body)) {
            $body = "?body=" . $body;
        }
        $sms = 'sms:' . trim($phone_number . $body);

        return $sms;
    }
}
