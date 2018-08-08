<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
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
    private $USE_pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $USE_nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $USE_email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $USE_password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $USE_role;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PhotoUser", mappedBy="PHO_id_user")
     */
    private $photoUsers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommentairesUser", mappedBy="COM_id_user")
     */
    private $commentairesUsers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Spot", mappedBy="SPO_id_User")
     */
    private $spots;

    public function __construct()
    {
        $this->photoUsers = new ArrayCollection();
        $this->commentairesUsers = new ArrayCollection();
        $this->spots = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUSEPseudo(): ?string
    {
        return $this->USE_pseudo;
    }

    public function setUSEPseudo(string $USE_pseudo): self
    {
        $this->USE_pseudo = $USE_pseudo;

        return $this;
    }

    public function getUSENom(): ?string
    {
        return $this->USE_nom;
    }

    public function setUSENom(string $USE_nom): self
    {
        $this->USE_nom = $USE_nom;

        return $this;
    }

    public function getUSEEmail(): ?string
    {
        return $this->USE_email;
    }

    public function setUSEEmail(string $USE_email): self
    {
        $this->USE_email = $USE_email;

        return $this;
    }

    public function getUSEPassword(): ?string
    {
        return $this->USE_password;
    }

    public function setUSEPassword(string $USE_password): self
    {
        $this->USE_password = $USE_password;

        return $this;
    }

    public function getUSERole(): ?string
    {
        return $this->USE_role;
    }

    public function setUSERole(string $USE_role): self
    {
        $this->USE_role = $USE_role;

        return $this;
    }

    /**
     * @return Collection|PhotoUser[]
     */
    public function getPhotoUsers(): Collection
    {
        return $this->photoUsers;
    }

    public function addPhotoUser(PhotoUser $photoUser): self
    {
        if (!$this->photoUsers->contains($photoUser)) {
            $this->photoUsers[] = $photoUser;
            $photoUser->setPHOIdUser($this);
        }

        return $this;
    }

    public function removePhotoUser(PhotoUser $photoUser): self
    {
        if ($this->photoUsers->contains($photoUser)) {
            $this->photoUsers->removeElement($photoUser);
            // set the owning side to null (unless already changed)
            if ($photoUser->getPHOIdUser() === $this) {
                $photoUser->setPHOIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CommentairesUser[]
     */
    public function getCommentairesUsers(): Collection
    {
        return $this->commentairesUsers;
    }

    public function addCommentairesUser(CommentairesUser $commentairesUser): self
    {
        if (!$this->commentairesUsers->contains($commentairesUser)) {
            $this->commentairesUsers[] = $commentairesUser;
            $commentairesUser->setCOMIdUser($this);
        }

        return $this;
    }

    public function removeCommentairesUser(CommentairesUser $commentairesUser): self
    {
        if ($this->commentairesUsers->contains($commentairesUser)) {
            $this->commentairesUsers->removeElement($commentairesUser);
            // set the owning side to null (unless already changed)
            if ($commentairesUser->getCOMIdUser() === $this) {
                $commentairesUser->setCOMIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Spot[]
     */
    public function getSpots(): Collection
    {
        return $this->spots;
    }

    public function addSpot(Spot $spot): self
    {
        if (!$this->spots->contains($spot)) {
            $this->spots[] = $spot;
            $spot->setSPOIdUser($this);
        }

        return $this;
    }

    public function removeSpot(Spot $spot): self
    {
        if ($this->spots->contains($spot)) {
            $this->spots->removeElement($spot);
            // set the owning side to null (unless already changed)
            if ($spot->getSPOIdUser() === $this) {
                $spot->setSPOIdUser(null);
            }
        }

        return $this;
    }
}