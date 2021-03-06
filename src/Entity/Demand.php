<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DemandRepository")
 */
class Demand
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
    private $client;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Board", mappedBy="demand")
     */
    private $boards;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", mappedBy="demand")
     */
    private $tags;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $clientRequest;

    /**

     * @ORM\Column(type="date", nullable=true)
     */
    private $deadline;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Resume", mappedBy="demand")
     */
    private $resumes;




    public function __construct()
    {
        $this->boards = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getClient(): ?string
    {
        return $this->client;
    }
    public function setClient(string $client): self
    {
        $this->client = $client;
        return $this;
    }
    /**
     * @return Collection|Board[]
     */
    public function getBoards(): Collection
    {
        return $this->boards;
    }
    public function addBoard(Board $board): self
    {
        if (!$this->boards->contains($board)) {
            $this->boards[] = $board;
            $board->setDemand($this);
        }
        return $this;
    }
    public function removeBoard(Board $board): self
    {
        if ($this->boards->contains($board)) {
            $this->boards->removeElement($board);
            // set the owning side to null (unless already changed)
            if ($board->getDemand() === $this) {
                $board->setDemand(null);
            }
        }
        return $this;
    }
    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }
    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addDemand($this);
        }
        return $this;
    }
    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            $tag->removeDemand($this);
        }
        return $this;
    }
    public function getClientRequest(): ?string
    {
        return $this->clientRequest;
    }
    public function setClientRequest(?string $clientRequest): self
    {
        $this->clientRequest = $clientRequest;
        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(?\DateTimeInterface $deadline): self
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Resume[]
     */
    public function getResumes(): Collection
    {
        return $this->resumes;
    }
    public function addResume(Resume $resume): self
    {
        if (!$this->resumes->contains($resume)) {
            $this->resumes[] = $resume;
            $resume->setDemand($this);
        }
        return $this;
    }
    public function removeResume(Resume $resume): self
    {
        if ($this->resumes->contains($resume)) {
            $this->resumes->removeElement($resume);
            // set the owning side to null (unless already changed)
            if ($resume->getDemand() === $this) {
                $resume->setDemand(null);
            }
        }
        return $this;
    }
}
