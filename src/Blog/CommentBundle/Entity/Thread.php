<?php
namespace Blog\CommentBundle\Entity;

use FOS\CommentBundle\Entity\Thread as BaseThread;

class Thread extends BaseThread
{
    /**
     * @var string $id
     */
    protected $id;

    /**
     * Set id
     *
     * @param string $id
     * @return Thread
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
