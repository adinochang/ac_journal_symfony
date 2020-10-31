<?php

namespace App\DataFixtures;

use App\Factory\AcJournalAnswerFactory;
use App\Factory\AcJournalEntryFactory;
use App\Factory\AcJournalQuestionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create two dummy questions
        $question_1 = AcJournalQuestionFactory::new()->create();
        $question_2 = AcJournalQuestionFactory::new()->create();

        // Create 30 entries
        $created_at = new \DateTime('120 days ago');

        for($count = 1; $count <= 30; $count++)
        {
            $created_at->add(new \DateInterval('P' . random_int(1, 7) . 'D'));

            $entry = AcJournalEntryFactory::new(['created_at' => $created_at])->create();

            AcJournalAnswerFactory::new([
                    'entry' => $entry,
                    'question' => $question_1,
                    'created_at' => $created_at
                ])
                ->create();

            AcJournalAnswerFactory::new([
                    'entry' => $entry,
                    'question' => $question_2,
                    'created_at' => $created_at
                ])
                ->create();
        }

        $manager->flush();
    }
}
