<?php

namespace WeCodePixels\PremailerBundle;

class Premailer
{
    /**
     * The path to the Premailer binary.
     * @var string
     */
    private $bin;

    private $mode;

    private $baseUrl;

    private $queryString;

    private $css;

    private $removeClasses;

    private $removeScripts;

    private $lineLength;

    private $entities;

    private $ioExceptions;

    public function __construct($bin)
    {
        $this->bin = $bin;
    }

    /**
     * @param $value string Output html or txt
     * @return $this
     */
    public function setMode($value)
    {
        $this->mode = $value;

        return $this;
    }

    /**
     * @param $value string Manually set the base URL, useful for local files
     * @return $this
     */
    public function setBaseUrl($value)
    {
        $this->baseUrl = $value;

        return $this;
    }

    /**
     * @param $value string Query string to append to links
     * @return $this
     */
    public function setQueryString($value)
    {
        $this->queryString = $value;

        return $this;
    }

    /**
     * @param $value string Additional stylesheets
     * @return $this
     */
    public function setCss($value)
    {
        $this->css = $value;

        return $this;
    }

    /**
     * @param $value boolean Remove HTML classes
     * @return $this
     */
    public function setRemoveClasses($value)
    {
        $this->removeClasses = $value;

        return $this;
    }

    /**
     * @param $value boolean Remove <script> elements
     * @return $this
     */
    public function setRemoveScripts($value)
    {
        $this->removeScripts = $value;

        return $this;
    }

    /**
     * @param $value int Length of lines when creating plaintext version (default: 65)
     * @return $this
     */
    public function setLineLength($value)
    {
        $this->lineLength = $value;

        return $this;
    }

    /**
     * @param $value boolean Output file with HTML Entities instead of UTF-8 (Nokogiri only)
     * @return $this
     */
    public function setEntities($value)
    {
        $this->entities = $value;

        return $this;
    }

    /**
     * @param $value boolean Abort on I/O errors
     * @return $this
     */
    public function setIoExceptions($value)
    {
        $this->ioExceptions = $value;

        return $this;
    }

    public function execute($inputHtml)
    {
        $command = $this->bin;

        // Create a temporary input file.
        $inputFile = tempnam(sys_get_temp_dir(), 'premailer');
        file_put_contents($inputFile, $inputHtml);
        $command .= ' ' . escapeshellarg($inputFile);

        // Append parameters.
        $parameters = array(
            'mode' => '--mode',
            'baseUrl' => '--base-url',
            'queryString' => '--query-string',
            'css' => '--css',
            'removeClasses' => '--remove-classes',
            'removeScripts' => '--remove-scripts',
            'lineLength' => '--line-length',
            'entities' => '--entities',
            'ioExceptions' => '--io-exceptions'
        );
        foreach ($parameters as $key => $value) {
            if ($this->$key !== null) {
                // If the value is boolean true, then the parameter doesn't need an actual value.
                if (is_bool($this->$key)) {
                    if ($this->$key == true) {
                        $command .= ' ' . $value;
                    }
                } else {
                    $command .= ' ' . $value . '=' . escapeshellarg($this->$key);
                }
            }
        }

        // Execute Premailer with all the bells and whistles.
        $output = shell_exec($command);

        // Remove temporary input file.
        unlink($inputFile);

        return $output;
    }
}
