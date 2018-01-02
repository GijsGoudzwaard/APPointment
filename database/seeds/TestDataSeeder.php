<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Appointment;
use App\Models\AppointmentType;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Allison','Arthur','Ana','Alex','Arlene','Alberto','Barry','Bertha','Bill','Bonnie','Bret','Beryl','Chantal','Cristobal','Claudette','Charley','Cindy','Chris','Dean','Dolly','Danny','Danielle','Dennis','Debby','Erin','Edouard','Erika','Earl','Emily','Ernesto','Felix','Fay','Fabian','Frances','Franklin','Florence','Gabielle','Gustav','Grace','Gaston','Gert','Gordon','Humberto','Hanna','Henri','Hermine','Harvey','Helene','Iris','Isidore','Isabel','Ivan','Irene','Isaac','Jerry','Josephine','Juan','Jeanne','Jose','Joyce','Karen','Kyle','Kate','Karl','Katrina','Kirk','Lorenzo','Lili','Larry','Lisa','Lee','Leslie','Michelle','Marco','Mindy','Maria','Michael','Noel','Nana','Nicholas','Nicole','Nate','Nadine','Olga','Omar','Odette','Otto','Ophelia','Oscar','Pablo','Paloma','Peter','Paula','Philippe','Patty','Rebekah','Rene','Rose','Richard','Rita','Rafael','Sebastien','Sally','Sam','Shary','Stan','Sandy','Tanya','Teddy','Teresa','Tomas','Tammy','Tony','Van','Vicky','Victor','Virginie','Vince','Valerie','Wendy','Wilfred','Wanda','Walter','Wilma','William','Kumiko','Aki','Miharu','Chiaki','Michiyo','Itoe','Nanaho','Reina','Emi','Yumi','Ayumi','Kaori','Sayuri','Rie','Miyuki','Hitomi','Naoko','Miwa','Etsuko','Akane','Kazuko','Miyako','Youko','Sachiko','Mieko','Toshie','Junko'];

        $appointment_type1 = new AppointmentType();
        $appointment_type1->name = 'Testing';
        $appointment_type1->time = 30;
        $appointment_type1->buffer = 0;
        $appointment_type1->price = '17,95';
        $appointment_type1->company_id = 1;
        $appointment_type1->save();

        if (User::where('email', 'wheatley@aperturelabaratories.com')->first()) {
            $user = User::where('email', 'wheatley@aperturelabaratories.com')->first();
        } else {
            $user = new User();
            $user->firstname = 'Wheatley';
            $user->surname = '';
            $user->email = 'wheatley@aperturelabaratories.com';
            $user->phonenumber = '1234567890';
            $user->password = bcrypt('johndoe');
            $user->role = User::role('employee');
            $user->active = 1;
            $user->company_id = 1;
            $user->save();
        }

        for ($i = 0; $i <= 200; $i++) {
            $appointment = new Appointment();
            $appointment->name = $names[array_rand($names)];
            $appointment->employee_id = $user->id;
            $appointment->appointment_type_id = $appointment_type1->id;

            $start_month = new Carbon('first day of this month');
            $end_month = new Carbon('last day of this month');

            $date = mt_rand($start_month->timestamp, $end_month->timestamp);
            $appointment->scheduled_at = date("Y-m-d H:i:s", $date);
            $appointment->save();
        }

        $appointment_type2 = new AppointmentType();
        $appointment_type2->name = 'Fix testing area';
        $appointment_type2->time = 45;
        $appointment_type2->buffer = 0;
        $appointment_type2->price = '24,95';
        $appointment_type2->company_id = 1;
        $appointment_type2->save();

        for ($i = 0; $i <= 25; $i++) {
            $appointment = new Appointment();
            $appointment->name = $names[array_rand($names)];
            $appointment->employee_id = $user->id;
            $appointment->appointment_type_id = $appointment_type2->id;

            $start_month = new Carbon('first day of this month');
            $end_month = new Carbon('last day of this month');

            $date = mt_rand($start_month->timestamp, $end_month->timestamp);
            $appointment->scheduled_at = date("Y-m-d H:i:s", $date);
            $appointment->save();
        }
    }
}
