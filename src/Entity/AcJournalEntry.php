<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * AcJournalEntry
 *
 * @ORM\Table(name="ac_journal_entry")
 * @ORM\Entity(repositoryClass="App\Repository\AcJournalEntryRepository")
 */
class AcJournalEntry
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AcJournalUser
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\AcJournalUser", inversedBy="entries")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="author", referencedColumnName="id")
     * })
     */
    private $author;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AcJournalAnswer", mappedBy="entry")
     */
    private $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAuthor(): ?AcJournalUser
    {
        return $this->author;
    }

    public function setAuthor(?AcJournalUser $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|AcJournalAnswer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(AcJournalAnswer $answer) {
        $this->answers->add($answer);
    }

    public function removeAnswer(AcJournalAnswer $answer) {
        $this->answers->removeElement($answer);
    }

    public function answer_excerpt(int $required_length = 20): string
    {
        $excerpt = 'testtesttest';

        // get the first answer from this entry
        $first_answer = $this->answers->first();

        if (isset($first_answer))
        {
            $excerpt = $first_answer->getAnswerText();

            // if the answer is too long, truncate it
            if (strlen($excerpt) > $required_length)
            {
                $excerpt = substr($excerpt, 0, $required_length) . '...';
            }
        }

        return $excerpt;
    }
}
