<?php

// src/AppBundle/Document/Client.php

namespace AppBundle\Document;

use FOS\OAuthServerBundle\Document\Client as BaseClient;

class Client extends BaseClient
{
    protected $id;
}