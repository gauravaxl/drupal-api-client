<?php

namespace Hussainweb\DrupalApi\Entity;

use Psr\Http\Message\ResponseInterface;

abstract class Entity
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @param mixed $rawData
     */
    final public function __construct(protected $rawData)
    {
    }

    /**
     * Get the original raw data.
     *
     * @return mixed
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * Get the response entity data.
     *
     * @return mixed
     */
    public function getData()
    {
        if (!$this->data) {
            // Convert the appropriate fields to integer.
            $this->data = (object) $this->rawData;
            $int_fields = $this->getIntegerFields();
            foreach ($int_fields as $field) {
                $this->data->$field = (int) $this->data->$field;
            }
        }

        return $this->data;
    }

    /**
     * Get the specified property from the data.
     *
     * @param string $name
     *   Property name
     *
     * @return mixed
     *   Value for the property name.
     */
    public function __get($name)
    {
        return $this->rawData->$name ?? null;
    }

    /**
     * Set the value to a specified property.
     *
     * @param string $name
     *   Property name
     * @param mixed $value
     *   Value
     */
    public function __set($name, mixed $value): void
    {
        $this->rawData->$name = $value;
    }

    /**
     * Check if the property is set.
     *
     * @param string $name
     *   Property name
     *
     * @return bool
     *   True if the property exists.
     */
    public function __isset($name): bool
    {
        return isset($this->rawData->$name);
    }

    /**
     * Retrieve the name of the field which holds the id of the entity.
     *
     * @return string
     *   The name of the field which holds the id of the entity.
     */
    abstract public function getIdField(): string;

    /**
     * Get the Id of the entity.
     *
     * @return mixed
     */
    public function getId()
    {
        $id_field = $this->getIdField();
        return $this->getData()->$id_field;
    }

    /**
     * Retrieve the names of fields which are supposed to be integers.
     *
     * @return string[]
     *   Array of field names which are supposed to be integers.
     */
    abstract protected function getIntegerFields(): array;

    /**
     * Construct the object from a HTTP Response.
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *   Response object to parse.
     *
     * @return static
     *   The EntityCollection object for the response.
     */
    public static function fromResponse(ResponseInterface $response): self
    {
        return new static(json_decode((string) $response->getBody(), null, 512, JSON_THROW_ON_ERROR));
    }
}
