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
 * @filename: Verbs.php
 * @author  : Nir Simionovich <nirs@cloudonix.io>
 * @created : 2024-08-27
 * @link    : https://developers.cloudonix.com/cxml
 * @license : MIT License
 */

namespace Cloudonix\CXML;

class Verbs
{
    private array $simpleVerbs = [
        "SAY",
        "PLAY",
        "HANGUP",
        "REDIRECT",
        "PAUSE",
        "DIAL",
        "REJECT"
    ];
    private array $compoundVerbs = [
        "GATHER" => [
            "PLAY",
            "SAY",
            "PAUSE"
        ],
        "START" => [
            "STREAM"
        ],
        "RECORD" => [
            "PLAY",
            "SAY",
            "PAUSE"
        ]
    ];

    public function __construct() {
    }

    public function __destruct() {
    }

    public function is_simple(string $verb): bool
    {
        if (in_array(strtoupper($verb), $this->simpleVerbs)) return true;
        return false;
    }

    public function is_compound(string $verb): bool
    {
        if (array_key_exists(strtoupper($verb), $this->compoundVerbs)) return true;
        return false;
    }
}