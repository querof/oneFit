<?php

namespace test\orm;

require_once(__DIR__."/../../autoloader.php");

use PHPUnit\Framework\TestCase;
use src\db\orm\model\Excercises;
use src\db\orm\model\Plan;
use src\db\orm\model\User;
use src\db\orm\model\UserPlan;
use src\db\orm\model\WorkoutDays;
use src\db\orm\model\WorkoutDaysExcercises;

final class OrmTest extends TestCase
{
    public function testUserSave(): void
    {
        $r = new User();
        $numberRnd = rand(0, 99);
        $r->name->setValue('Frank Jose');
        $r->lastname->setValue('Quero Robles');
        $r->email->setValue('querof-'.$numberRnd.'@gmail.com');
        $r->password->setValue('not valid only for test');
        $r->size->setValue(1.70);
        $r->weight->setValue(76);

        $id = $r->save();

        $this->assertGreaterThanOrEqual(1, $id);

        $r->findByPk($id);

        $this->assertNotCount(0, $r->getData());

        $r->password->setValue(md5('darkside'));

        $this->assertGreaterThanOrEqual(1, $r->save());
    }

    public function testPlanSave(): void
    {
        $r = new Plan();

        $r->name->setValue('Advanced');
        $r->description->setValue('Advanced plan');

        $id = $r->save();

        $this->assertGreaterThanOrEqual(1, $id);

        $r->findByPk($id);

        $this->assertNotCount(0, $r->getData());

        $r->name->setValue('Advanced user');

        $this->assertGreaterThanOrEqual(1, $r->save());
    }

    public function testExcercisesSave(): void
    {
        $r = new Excercises();

        $r->name->setValue('Press');
        $r->description->setValue('press in bench');

        $id = $r->save();

        $this->assertGreaterThanOrEqual(1, $id);

        $r->findByPk($id);

        $this->assertNotCount(0, $r->getData());

        $r->name->setValue('Chest press');

        $this->assertGreaterThanOrEqual(1, $r->save());
    }

    public function testUserPlanSave(): void
    {
        $r = new User();
        $numRnd = rand(0, 9999);
        $r->name->setValue('Name-'.$numRnd);
        $r->lastname->setValue('Lastname-'.$numRnd);
        $r->email->setValue('querof'.$numRnd.'@gmail.com');
        $r->password->setValue(md5('darkside'));
        $r->size->setValue(1.70);
        $r->weight->setValue(76);

        $user_id = $r->save();

        $this->assertGreaterThanOrEqual(1, $user_id);


        $r = new Plan();

        $r->name->setValue('Plan-'.$numRnd);
        $r->description->setValue('Desc-'.$numRnd);

        $plan_id = $r->save();
        $this->assertGreaterThanOrEqual(1, $plan_id);

        $r =  new UserPlan();
        $r->userid->setValue($user_id);
        $r->planid->setValue($plan_id);
        $id = $r->save();

        $this->assertGreaterThanOrEqual(1, $r->save());

        $r->findByPk($id);
        $this->assertNotCount(0, $r->getData());
    }

    public function testWorkoutDaysSave(): void
    {
        $numRnd = rand(0, 9999);

        $r = new Plan();

        $r->name->setValue('Plan-'.$numRnd);
        $r->description->setValue('Desc-'.$numRnd);

        $plan_id = $r->save();
        $this->assertGreaterThanOrEqual(1, $plan_id);

        $r =  new WorkoutDays();
        $r->name->setValue('Plan-'.$numRnd);
        $r->description->setValue('Desc-'.$numRnd);
        $r->planid->setValue($plan_id);
        $r->weekday->setValue('mon');
        $id = $r->save();

        $this->assertGreaterThanOrEqual(1, $r->save());

        $r->findByPk($id);
        $this->assertNotCount(0, $r->getData());
    }

    public function testWorkoutDaysExcercisesSave(): void
    {
        $numRnd = rand(0, 9999);

        $r = new Plan();

        $r->name->setValue('Plan-'.$numRnd);
        $r->description->setValue('Desc-'.$numRnd);

        $plan_id = $r->save();

        $r =  new WorkoutDays();
        $r->name->setValue('Plan-'.$numRnd);
        $r->description->setValue('Desc-'.$numRnd);
        $r->planid->setValue($plan_id);
        $r->weekday->setValue('mon');
        $workout_days_id = $r->save();

        // $this->assertGreaterThanOrEqual(1, $workout_days_id);

        $r = new Excercises();

        $r->name->setValue('Exc-'.$numRnd);
        $r->description->setValue('Desc-'.$numRnd);

        $excercise_id = $r->save();

        $r =  new WorkoutDaysExcercises();
        $r->workoutdaysid->setValue($workout_days_id);
        $r->excercisesid->setValue($excercise_id);
        $r->repetitions->setValue(3);
        $id = $r->save();

        $this->assertGreaterThanOrEqual(1, $r->save());

        $r->findByPk($id);
        $this->assertNotCount(0, $r->getData());
    }
}
