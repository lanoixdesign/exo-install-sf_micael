<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $resume;


    /**
     * @ORM\Column(type="integer")
     */
    private $nbPages;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="books")
     */
    private $author;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * @param mixed $resume
     */
    public function setResume( $resume ): void
    {
        $this->resume = $resume;
    }


    /**
     * @return mixed
     */
    public function getNbPages()
    {
        return $this->nbPages;
    }

    /**
     * @param mixed $nbPages
     */
    public function setNbPages( $nbPages ): void
    {
        $this->nbPages = $nbPages;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }



}
