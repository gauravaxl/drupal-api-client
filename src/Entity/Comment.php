<?php

namespace Hussainweb\DrupalApi\Entity;

class Comment extends Entity
{

    /**
     * {@inheritdoc}
     */
    public function getIdField()
    {
        return 'cid';
    }

    /**
     * {@inheritdoc}
     */
    protected function getIntegerFields()
    {
        return ['cid'];
    }
}
