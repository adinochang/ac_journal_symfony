<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AcJournalAnswer
 *
 * @ORM\Table(name="ac_journal_answer", indexes={@ORM\Index(name="IDX_270A522D1E27F6BF", columns={"question_id"}), @ORM\Index(name="IDX_270A522DBA364942", columns={"entry_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\AcJournalAnswerRepository")
 */
class AcJournalAnswer
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
     * @var string
     *
     * @ORM\Column(name="answer_text", type="text", length=8, nullable=false)
     */
    private $answerText;

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
     * @var \AcJournalQuestion
     *
     * @ORM\ManyToOne(targetEntity="AcJournalQuestion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="question_id", referencedColumnName="id")
     * })
     */
    private $question;

    /**
     * @var \AcJournalEntry
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\AcJournalEntry", inversedBy="answers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entry_id", referencedColumnName="id")
     * })
     */
    private $entry;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAnswerText(): ?string
    {
        return $this->answerText;
    }

    public function setAnswerText(string $answerText): self
    {
        $this->answerText = $answerText;

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

    public function getQuestion(): ?AcJournalQuestion
    {
        return $this->question;
    }

    public function setQuestion(?AcJournalQuestion $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getEntry(): ?AcJournalEntry
    {
        return $this->entry;
    }

    public function setEntry(?AcJournalEntry $entry): self
    {
        $this->entry = $entry;

        return $this;
    }


}
