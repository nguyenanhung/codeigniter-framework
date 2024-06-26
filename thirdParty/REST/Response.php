<?php
/**
 * Project codeigniter-framework
 * Created by PhpStorm
 * User: 713uk13m <dev@nguyenanhung.com>
 * Copyright: 713uk13m <dev@nguyenanhung.com>
 * Date: 23/06/2022
 * Time: 01:28
 */

namespace nguyenanhung\CodeIgniter\BaseREST;

use Exception;

/**
 * Response Component based on CI_Output
 *
 * @author  Nick Tsai <myintaer@gmail.com>
 * @since   1.6.1
 * @example
 *  $response = new nguyenanhung\CodeIgniter\BaseREST\Response;
 *  $response->setFormat(nguyenanhung\CodeIgniter\BaseREST\Response::FORMAT_JSON);
 *  $response->setData(['foo'=>'bar']);
 *  $response->setStatusCode(201, 'Created');
 *  $response->send();
 * @todo    Formatters
 */
class Response
{
    /**
     * @var string HTTP response formats
     */
    const FORMAT_RAW = 'raw';
    const FORMAT_HTML = 'html';
    const FORMAT_JSON = 'json';
    const FORMAT_JSONP = 'jsonp';
    const FORMAT_XML = 'xml';
    /**
     * @var object CI_Controller
     */
    public $ci;
    /**
     * @var array the formatters that are supported by default
     */
    public $contentTypes = array(
        self::FORMAT_RAW => 'text/plain;',
        self::FORMAT_HTML => 'text/html;',
        self::FORMAT_JSON => 'application/json;', // RFC 4627
        self::FORMAT_JSONP => 'application/javascript;', // RFC 4329
        self::FORMAT_XML => 'application/xml;', // RFC 2376
    );
    /**
     * @var string the response format. This determines how to convert [[data]] into [[content]]
     * when the latter is not set. The value of this property must be one of the keys declared in the [[formatters]] array.
     * By default, the following formats are supported:
     *
     * - [[FORMAT_RAW]]: the data will be treated as the response content without any conversion.
     *   No extra HTTP header will be added.
     * - [[FORMAT_HTML]]: the data will be treated as the response content without any conversion.
     *   The "Content-Type" header will set as "text/html".
     * - [[FORMAT_JSON]]: the data will be converted into JSON format, and the "Content-Type"
     *   header will be set as "application/json".
     * - [[FORMAT_JSONP]]: the data will be converted into JSONP format, and the "Content-Type"
     *   header will be set as "text/javascript". Note that in this case `$data` must be an array
     *   with "data" and "callback" elements. The former refers to the actual data to be sent,
     *   while the latter refers to the name of the JavaScript callback.
     * - [[FORMAT_XML]]: the data will be converted into XML format. Please refer to [[XmlResponseFormatter]]
     *   for more details.
     *
     * You may customize the formatting process or support additional formats by configuring [[formatters]].
     * @see formatters
     */
    private $_format = self::FORMAT_JSON;
    /**
     * @var int the HTTP status code to send with the response.
     */
    private $_statusCode = 200;

    public function __construct()
    {
        // CI_Controller initialization
        $this->ci = &get_instance();

        log_message('info', 'Third Party Response Class Initialized');
    }

    /**
     * Set Response Format into CI_Output
     *
     * @param string $format Response format
     */
    public function setFormat($format)
    {
        $this->_format = $format;
        // Use formatter content type if exists
        if (isset($this->contentTypes[$this->_format])) {
            $this->ci->output->set_content_type($this->contentTypes[$this->_format]);
        }

        return $this;
    }

    /**
     * Set Response Data into CI_Output
     *
     * @param mixed $data Response data
     *
     * @return object self
     * @todo    Format data before send
     *
     */
    public function setData($data)
    {
        // Format data
        $data = $this->format($data, $this->_format);
        // CI Output
        $this->ci->output->set_output($data);

        return $this;
    }

    /**
     * Get Response Body from CI_Output
     *
     * @return string Response body data
     */
    public function getOutput()
    {
        // CI Output
        return $this->ci->output->get_output();
    }

    /**
     * @return int the HTTP status code to send with the response.
     */
    public function getStatusCode()
    {
        return $this->_statusCode;
    }

    /**
     * Sets the response status code.
     * This method will set the corresponding status text if `$text` is null.
     *
     * @param int $code the status code
     * @param string $text HTTP status text base on PHP http_response_code().
     *
     * @return $this the response object itself
     * @throws Exception if the status code is invalid.
     */
    public function setStatusCode($code, $text = null)
    {
        if ($code === null) {
            $code = 200;
        }
        // Save code into property
        $this->_statusCode = (int)$code;
        // Check status code
        if ($this->getIsInvalid()) {
            throw new Exception("The HTTP status code is invalid: " . $this->_statusCode);
        }
        // Set HTTP status code with options
        if ($text) {
            // Set into CI_Output
            $this->ci->output->set_status_header($this->_statusCode, $text);
        } else {
            // Use PHP function with more code support
            http_response_code($this->_statusCode);
        }

        return $this;
    }

    /**
     * @return bool whether this response has a valid [[statusCode]].
     */
    public function getIsInvalid()
    {
        return $this->getStatusCode() < 100 || $this->getStatusCode() >= 600;
    }

    /**
     * Sends the response to the client.
     */
    public function send()
    {
        $this->ci->output->_display();
        exit;
    }

    /**
     * Common format function by format types. {FORMAT}Format()
     *
     * @param array $data Pre-handle array data
     * @param string $format Format
     *
     * @return string Formatted data by specified formatter
     */
    public function format($data, $format)
    {
        // Case handing. ex. json => Json
        $format = ucfirst(bear_str_to_lower($format));
        $formatFunc = "format" . $format;
        // Use formatter if exists
        if (method_exists($this, $formatFunc)) {
            $data = $this->{$formatFunc}($data);
        } elseif (is_array($data)) {
            // Use JSON while the Formatter not found and the data is array
            $data = self::formatJson($data);
        }

        return $data;
    }

    /**
     * Common format function by format types. {FORMAT}Format()
     *
     * @param array $data Pre-handle array data
     *
     * @return string Formatted data
     */
    public static function formatJson($data)
    {
        return json_encode($data);
    }

    /**
     * JSON output shortcut
     *
     * @param array|mixed $data Callback data body, false will remove body key
     * @param int $statusCode Callback status code
     *
     * @return string|void Response body data
     * @throws \Exception
     */
    public function json($data, $statusCode = null)
    {
        // Set Status Code
        if ($statusCode) {
            $this->setStatusCode($statusCode);
        }

        $this->setFormat(self::FORMAT_JSON);

        if (!is_null($data)) {
            $this->setData($data);
        }

        return $this->send();
    }

    /**
     * Return an instance with the specified header appended with the given value.
     *
     * Existing values for the specified header will be maintained. The new
     * value(s) will be appended to the existing list. If the header did not
     * exist previously, it will be added.
     *
     * PSR-7 standard
     *
     * @param string $name Case-insensitive header field name to add.
     * @param string|string[] $value Header value(s).
     *
     * @return self
     */
    public function withAddedHeader($name, $value)
    {
        $this->ci->output->set_header("{$name}: {$value}");

        return $this;
    }
}
