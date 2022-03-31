<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $question = [
            [
                'question' => 'How long have you been a caregiver?',
                'slug' => 'caregiver experience'
            ],
            [
                'question' => 'On a scale of 1 to 5, how much personal reward do you gain from caring for elderly and disabled persons?',
                'slug' => 'personal reward gain by caring for old people'
            ],
            [
                'question' => 'Do you have reliable transportation?',
                'slug' => 'reliable transportation'
            ],
            [
                'question' => 'How’s your day going?',
                'slug' => 'entire day went'
            ],
            [
                'question' => 'Can you perform all the duties in the job description?',
                'slug' => 'can perform all duties'
            ],
            [
                'question' => 'Can you work with clients with pets?',
                'slug' => 'can work with clients having pets'
            ],
            [
                'question' => 'Do you Smoke?',
                'slug' => 'smoke'
            ],
            [
                'question' => 'Can you care for clients who smoke?',
                'slug' => 'care for client who smoke'
            ],
            [
                'question' => 'What do you like (or think you would like) most about working with older adults?',
                'slug' => 'thoughts about working with older clients'
            ],
            [
                'question' => 'Are you over 18 years old?',
                'slug' => '18 years old'
            ],
            [
                'question' => 'Have you ever been convicted of a crime?',
                'slug' => 'convicted of a crime'
            ],
            [
                'question' => 'Do you have any professional references?',
                'slug' => 'professional reference'
            ],
            [
                'question' => 'Can you supply a copy of your PA Criminal Background Check?',
                'slug' => 'can provide criminal background check document'
            ],
            [
                'question' => 'Can you supply a copy of your completed W-4 form?',
                'slug' => 'can provide w-4 form'
            ],
            [
                'question' => 'Are you able to legally work in the US?',
                'slug' => 'can legally work in USA'
            ],
            [
                'question' => 'On a scale of 1 to 5, how are your communication skills, 5 meaning excellent?',
                'slug' => 'communication skill rating'
            ],
            [
                'question' => 'Can you easily deal with difficult people?',
                'slug' => 'can deal with difficult people'
            ],
            [
                'question' => 'On a scale of 1 to 5, 5 being very compassionate, how compassionate are you?',
                'slug' => 'compassionate rating'
            ],
            [
                'question' => 'Are you friendly and get along well with others?',
                'slug' => 'friendly'
            ],
            [
                'question' => 'Do you have hobbies you can enjoy with a client?',
                'slug' => 'hobbies'
            ],
            [
                'question' => 'Would you like to care for clients that live with children?',
                'slug' => 'can work with clients having kids'
            ],
        ];

        foreach($question as $key => $item){
            Question::create([
                'question' => $item['question'],
                'slug' => $item['slug']
            ]);
        }
    }
}
