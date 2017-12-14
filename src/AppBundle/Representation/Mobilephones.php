<?php
/**
 * Created by PhpStorm.
 * User: cyrille
 * Date: 23/11/2017
 * Time: 14:07
 */

namespace AppBundle\Representation;

use Pagerfanta\Pagerfanta;
use JMS\Serializer\Annotation\Type;

class Mobilephones
{
    /**
     * @Type("array<AppBundle\Entity\Mobilephone>")
     */
    public $data;
    public $meta;

    public function __construct(Pagerfanta $data)
    {
        $this->data = $data->getCurrentPageResults();

        $this->addMeta('limit', $data->getMaxPerPage());
        $this->addMeta('current_items', count($data->getCurrentPageResults()));
        $this->addMeta('total_items', $data->getNbResults());
        $this->addMeta('page', $data->getCurrentPage());
        $this->addMeta('a une page suivante', $data->hasNextPage());
    }

    public function addMeta($name, $value)
    {
        if (isset($this->meta[$name])) {
            throw new \LogicException(sprintf('This meta already exists. You are trying to override this meta, use the setMeta method instead for the %s meta.', $name));
        }

        $this->setMeta($name, $value);
    }

    public function setMeta($name, $value)
    {
        $this->meta[$name] = $value;
    }
}