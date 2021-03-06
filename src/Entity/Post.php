<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Post
{    
    // /**
    //  * @ORM\Column(type="string", length=255)
    //  * @var string
    //  */
    // private $image;

    // /**
    //  * @Vich\UploadableField(mapping="posts", fileNameProperty="image")
    //  * @var File
    //  */
    // private $imageFile;



    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoryName;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="postTitle")
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

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

    public function getCategoryName(): ?Category
    {
        return $this->categoryName;
    }

    public function setCategoryName(?Category $categoryName): self
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    // public function setImageFile(File $image = null)
    // {
    //     $this->imageFile = $image;

    //     // VERY IMPORTANT:
    //     // It is required that at least one field changes if you are using Doctrine,
    //     // otherwise the event listeners won't be called and the file is lost
    //     if ($image) {
    //         // if 'updatedAt' is not defined in your entity, use another property
    //         $this->updated = new \DateTime('now');
    //     }
    // }

    // public function getImageFile()
    // {
    //     return $this->imageFile;
    // }

    // public function setImage($image)
    // {
    //     $this->image = $image;
    // }

    // public function getImage()
    // {
    //     return $this->image;
    // }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedValue () {
        $this->created = new \DateTime();
    }

    /**
     * @ORM\PrePersist
     */
    public function setUpdatedValue () {
        $this->updated = new \DateTime();
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPostTitle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPostTitle() === $this) {
                $comment->setPostTitle(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->title;
    }

}
