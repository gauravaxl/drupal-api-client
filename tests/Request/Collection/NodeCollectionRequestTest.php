<?php

namespace Hussainweb\DrupalApi\Tests\Request\Collection;

use Hussainweb\DrupalApi\Request\Collection\NodeCollectionRequest;

class NodeCollectionRequestTest extends \PHPUnit_Framework_TestCase
{

    public function testRequest()
    {
        $req = new NodeCollectionRequest();
        $this->assertEquals('https://www.drupal.org/api-d7/node.json', $req->getUri());

        $req = new NodeCollectionRequest([
          'page' => 10,
          'limit' => 50,
        ]);
        $this->assertEquals('https://www.drupal.org/api-d7/node.json?page=10&limit=50', $req->getUri());
    }
}
