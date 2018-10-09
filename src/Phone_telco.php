<?php
/**
 * Project vn-telco-phonenumber.
 * Created by PhpStorm.
 * User: 713uk13m <dev@nguyenanhung.com>
 * Date: 9/21/18
 * Time: 01:40
 */

namespace nguyenanhung\VnTelcoPhoneNumber;
if (!interface_exists('nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'ProjectInterface.php';
}
if (!interface_exists('nguyenanhung\VnTelcoPhoneNumber\Interfaces\PhoneTelcoInterface')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Interfaces' . DIRECTORY_SEPARATOR . 'PhoneTelcoInterface.php';
}
if (!class_exists('nguyenanhung\VnTelcoPhoneNumber\Repository\DataRepository')) {
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'Repository' . DIRECTORY_SEPARATOR . 'DataRepository.php';
}

use nguyenanhung\MyDebug\Debug;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\PhoneTelcoInterface;
use nguyenanhung\VnTelcoPhoneNumber\Interfaces\ProjectInterface;
use nguyenanhung\VnTelcoPhoneNumber\Repository\DataRepository;

/**
 * Class Phone_telco
 *
 * @package    nguyenanhung\VnTelcoPhoneNumber
 * @author     713uk13m <dev@nguyenanhung.com>
 * @copyright  713uk13m <dev@nguyenanhung.com>
 */
class Phone_telco implements ProjectInterface, PhoneTelcoInterface
{
    /**
     * @var object \nguyenanhung\MyDebug\Debug Class Debug Object
     */
    private $debug;
    /**
     * @var bool DEBUG Status
     */
    private $debugStatus = FALSE;
    /**
     * @var string Logger Path
     */
    private $loggerPath = NULL;
    /**
     * @var null Logger Sub Path
     */
    private $loggerSubPath = NULL;
    /**
     * @var string Filename to write Log
     */
    private $loggerFilename = NULL;

    /**
     * Phone_telco constructor.
     */
    public function __construct()
    {
        $this->debug = new Debug();
        if ($this->debugStatus === TRUE) {
            $this->debug->setDebugStatus($this->debugStatus);
            $this->debug->setLoggerPath($this->loggerPath);
            $this->debug->setLoggerSubPath(__CLASS__);
            if (empty($this->loggerFilename)) {
                $this->debug->setLoggerFilename($this->loggerFilename);
            } else {
                $this->debug->setLoggerFilename('Log-' . date('Y-m-d') . '.log');
            }
        }
        $this->debug->debug(__FUNCTION__, '/---------------------------> Class Phone Telco <---------------------------\\');
    }

    /**
     * Function setDebugStatus
     * Set Var to DEBUG and save Log
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 13:47
     *
     * @param bool $debugStatus TRUE if Enable Debug, other if Not
     *
     * @return mixed|void
     */
    public function setDebugStatus($debugStatus = FALSE)
    {
        $this->debugStatus = $debugStatus;
    }

    /**
     * Function setLoggerPath
     * Main Logger Path to Save Log if DEBUG is Enable
     *
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/9/18 13:51
     *
     * @param bool $loggerPath Set Logger Path to Save
     *
     * @example /your/to/path
     *
     * @return mixed|void
     */
    public function setLoggerPath($loggerPath = FALSE)
    {
        $this->loggerPath = $loggerPath;
    }

    /**
     * Function setLoggerSubPath
     * Sub Logger Path to Save Log if DEBUG is Enable
     *
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/8/18 14:38
     *
     * @param bool $loggerSubPath Set Logger Sub Path to Save
     *
     * @example /your/to/path
     *
     * @return mixed|void
     */
    public function setLoggerSubPath($loggerSubPath = FALSE)
    {
        $this->loggerSubPath = $loggerSubPath;
    }

    /**
     * Function setLoggerFilename
     * Logger filename to Save Log if DEBUG is Enable
     *
     * @author  : 713uk13m <dev@nguyenanhung.com>
     * @time    : 10/8/18 14:38
     *
     * @param bool $loggerFilename Set Logger Filename to Save
     *
     * @example Log-2018-10-09.log
     *
     * @return mixed|void
     */
    public function setLoggerFilename($loggerFilename = FALSE)
    {
        $this->loggerFilename = $loggerFilename;
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
     * Function Get Data VN Carrier
     *
     * @author: 713uk13m <dev@nguyenanhung.com>
     * @time  : 10/9/18 14:18
     *
     * @param string $carrier      Full Name of Carrier: Viettel, Vinaphone, MobiFone, Vietnamobile
     * @param string $field_output Field Output: name, id, short_name
     *
     * @return mixed|null Field if exists, null if not or error
     */
    public function carrier_data($carrier = '', $field_output = '')
    {
        $inputParams = [
            'carrier'      => $carrier,
            'field_output' => $field_output
        ];
        $this->debug->info(__FUNCTION__, 'Input Params: ', $inputParams);
        try {
            $vnCarrierData = DataRepository::getData('vn_carrier_data');
            $this->debug->debug(__FUNCTION__, 'VN Carrier All Data: ', $vnCarrierData);
            if (array_key_exists($carrier, $vnCarrierData)) {
                $isCarrier = $vnCarrierData[$carrier];
                $this->debug->debug(__FUNCTION__, 'Is Carrier Data: ', $isCarrier);
                if (array_key_exists($field_output, $isCarrier)) {
                    $result = $isCarrier[$field_output];
                    $this->debug->info(__FUNCTION__, 'Final Result: ', $result);

                    return $result;
                }
            }
        }
        catch (\Exception $e) {
            $message = 'Error File: ' . $e->getFile() . ' - Line: ' . $e->getLine() . ' - Code: ' . $e->getCode() . ' - Message: ' . $e->getMessage();
            $this->debug->error(__FUNCTION__, $message);

            return NULL;
        }

        return NULL;
    }
}
