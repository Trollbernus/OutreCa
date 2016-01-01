<?php

namespace Mastio\PhotoSwipeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 */
class Image
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @var integer
     */
    private $height;

    /**
     * @var integer
     */
    private $width;

    /**
     * @var integer
     */
    private $previewHeight;

    /**
     * @var integer
     */
    private $previewWidth;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return Image
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set width
     *
     * @param integer $width
     * @return Image
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set previewHeight
     *
     * @param integer $previewHeight
     * @return Image
     */
    public function setPreviewHeight($previewHeight)
    {
        $this->previewHeight = $previewHeight;

        return $this;
    }

    /**
     * Get previewHeight
     *
     * @return integer
     */
    public function getPreviewHeight()
    {
        return $this->previewHeight;
    }

    /**
     * Set previewWidth
     *
     * @param integer $previewWidth
     * @return Image
     */
    public function setPreviewWidth($previewWidth)
    {
        $this->previewWidth = $previewWidth;

        return $this;
    }

    /**
     * Get previewWidth
     *
     * @return integer
     */
    public function getPreviewWidth()
    {
        return $this->previewWidth;
    }

    /**
     * @var \Mastio\PhotoSwipeBundle\Entity\Gallery
     */
    private $gallery;


    /**
     * Set gallery
     *
     * @param \Mastio\PhotoSwipeBundle\Entity\Gallery $gallery
     * @return Image
     */
    public function setGallery(\Mastio\PhotoSwipeBundle\Entity\Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \Mastio\PhotoSwipeBundle\Entity\Gallery 
     */
    public function getGallery()
    {
        return $this->gallery;
    }
}
