<?php

namespace Athena;

class EmailVerificationResult
{
    public $result;
    private $schema = [
        "type" => "object",
        "properties" => [
            "status" => ["type" => "string", "posible_values" => ["deliverable", "undeliverable", "risky", "unknown"]],
            "mxs" => ["type" => "array"],
        ],
        "required" => ["status", "mxs"],
        "additionalProperties" => false
    ];

    public function __construct(array $result)
    {
        $this->result = $result;

        $this->validate();
    }

    public function validate()
    {
        if (!isset($this->result['status'])) {
            throw new \Exception("The result must contain a status key.");
        }

        if (!in_array($this->result['status'], ["deliverable", "undeliverable", "risky", "unknown"])) {
            throw new \Exception('The status must be one of the following: "deliverable", "undeliverable", "risky", "unknown"');
        }

        if (!isset($this->result['mxs'])) {
            throw new \Exception("The mxs must contain a mxs key.");
        }

        if (!is_array($this->result['mxs'])) {
            throw new \Exception("The mxs must be an array.");
        }
    }

    public function getStatus(): string
    {
        return $this->result['status'];
    }

    public function getMxs(): array
    {
        return $this->result['mxs'];
    }

    public function toArray(): array
    {
        return $this->result;
    }
}