<?php
/**
 *  ██████╗██╗      ██████╗ ██╗   ██╗██████╗  ██████╗ ███╗   ██╗██╗██╗  ██╗
 * ██╔════╝██║     ██╔═══██╗██║   ██║██╔══██╗██╔═══██╗████╗  ██║██║╚██╗██╔╝
 * ██║     ██║     ██║   ██║██║   ██║██║  ██║██║   ██║██╔██╗ ██║██║ ╚███╔╝
 * ██║     ██║     ██║   ██║██║   ██║██║  ██║██║   ██║██║╚██╗██║██║ ██╔██╗
 * ╚██████╗███████╗╚██████╔╝╚██████╔╝██████╔╝╚██████╔╝██║ ╚████║██║██╔╝ ██╗
 *  ╚═════╝╚══════╝ ╚═════╝  ╚═════╝ ╚═════╝  ╚═════╝ ╚═╝  ╚═══╝╚═╝╚═╝  ╚═╝
 *
 * @project : cxml-php
 * @filename: Responder.php
 * @author  : Nir Simionovich <nirs@cloudonix.io>
 * @created : 2024-08-27
 * @link    : https://developers.cloudonix.com/cxml
 * @license : MIT License
 */


namespace Cloudonix\CXML;

class Response extends CompoundVerb
{
    private array $payloadArray = [];

    /**
     * CXML Response Constructor
     */
    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function attributes(array $verbAttributes): self
    {
        return $this;
    }

    /**
     * Magic function to build new CXML Verbs according to verb name and verb type
     *
     * @param $method
     * @param $args
     *
     * @return CompoundVerb|SimpleVerb|false
     */
    public function __call($method, $args) {
        switch (strtoupper($method)) {
            case "DIAL":
            case "HANGUP":
            case "REJECT":
            case "SAY":
            case "PLAY":
            case "PAUSE":
            case "REDIRECT":
            case "STREAM":
                return $this->payloadArray[] = (new SimpleVerb($method))->content($args);
                break;
            case "GATHER":
            case "RECORD":
            case "START":
                return $this->payloadArray[] = (new CompoundVerb($method))->content($args);
                break;
        }
        return false;
    }

    /**
     * Output CXML Response as CXML Plain-Text String
     *
     * @return string
     */
    public function __toString(): string
    {
        $cxmlResponse = "<Response>\n";
        foreach ($this->payloadArray as $verbObject) {
            $cxmlResponse .= "  " . $verbObject ."\n";
        }
        $cxmlResponse .= "</Response>";
        return $cxmlResponse;
    }
}