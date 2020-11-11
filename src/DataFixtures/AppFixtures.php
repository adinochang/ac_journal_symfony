<?php

namespace App\DataFixtures;

use App\Factory\AcJournalAnswerFactory;
use App\Factory\AcJournalEntryFactory;
use App\Factory\AcJournalQuestionFactory;
use App\Factory\AcJournalUserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct()
    {
    }

    public function load(ObjectManager $manager)
    {
        // create a test user
        $test_user = AcJournalUserFactory::new([
            'email' => 'develop@adinochang.com',
            'password' => 'test2288',
            'roles' => ['ROLE_ADMIN'],
        ])->create();

        // Create two dummy questions
        $question_1 = AcJournalQuestionFactory::new()->create();
        $question_1->setSortOrder(1);
        $question_2 = AcJournalQuestionFactory::new()->create();
        $question_2->setSortOrder(2);
        $question_3 = AcJournalQuestionFactory::new()->create();
        $question_3->setSortOrder(3);

        // Create 30 entries
        $created_at = new \DateTime('120 days ago');

        for($count = 1; $count <= 30; $count++)
        {
            $created_at->add(new \DateInterval('P' . random_int(1, 7) . 'D'));

            $entry = AcJournalEntryFactory::new([
                'created_at' => $created_at,
                'author' => $test_user
            ])->create();

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

            AcJournalAnswerFactory::new([
                'entry' => $entry,
                'question' => $question_3,
                'created_at' => $created_at
            ])
                ->create();
        }

        $manager->flush();
    }
}
