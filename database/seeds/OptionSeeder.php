<?php

use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('options')->delete();

        $contact_page = factory(App\Models\Option::class)->create([
            'key' => 'key_block_contact_left',
            'value' => serialize(["_token" => "3LVsL4x9Taifr0AbnOVLCx81dooG7I9gAxpdU8iq",
                        "contact_title" => "Contact Us",
                        "contact_description" => "We are available Monday through Saturday. We can often schedule next day appointments.",
                        "call_title" => "Call or Text Today!",
                        "call_number" => "480-393-6890",
                        "email_title" => "Email",
                        "email_address" => "admin@rowboat.com"
                        ]),
        ]);
    }
}
