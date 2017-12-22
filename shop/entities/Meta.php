<?php
namespace shop\entities;


class Meta
{
    public $title;
    public $description;
    //public $nofollow;
    //public $noindex;
    public $robots;

    public function __construct($title, $description, $robots = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->robots = $robots;
        //$this->nofollow = $nofollow;
        //$this->noindex = $noindex;
    }

}