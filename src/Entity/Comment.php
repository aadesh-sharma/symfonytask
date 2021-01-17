<?php

namespace App\Entity;
use App\Entity\User;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commentBy;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $postTitle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {   
        $this->status = $status;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getCommentBy(): ?User
    {
        return $this->commentBy;
    }

    public function setCommentBy(?User $commentBy): self
    {
        $this->commentBy = $commentBy;

        return $this;
    }

    
    public function getPostTitle(): ?Post
    {
        return $this->postTitle;
    }

    public function setPostTitle(?Post $postTitle): self
    {
        $this->postTitle = $postTitle;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedValue () {
        $this->created = new \DateTime();
    }

    /**
     * @ORM\PrePersist
     */
    public function getCommentByValue(): ?User
    {
        return $this->commentBy;
    }
     
     /**
     * @ORM\PrePersist
     */
    public function  setStatusValue(): ?User
    {
        $this->status=0;
    }

    // /**
    //  * @ORM\PrePersist
    //  */
    // public function setCommentByValue(?User $commentBy): self
    // {
    //     $this->commentBy = $commentBy;

    //     return $this;
    // }


   
}
