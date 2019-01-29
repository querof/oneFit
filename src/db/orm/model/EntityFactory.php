<?php

namespace src\db\orm\model;

use PHPUnit\Framework\TestCase;
use src\db\orm\model\Excercises;
use src\db\orm\model\Plan;
use src\db\orm\model\User;
use src\db\orm\model\UserPlan;
use src\db\orm\model\WorkoutDays;
use src\db\orm\model\WorkoutDaysExcercises;

/*
 * An implementation of the factory pattern; to create the entities objects.
 */

class EntityFactory
{

  /*
   * String Property that contains the type of entity.
   */

    private $type;


    /**
     * Method thats create the entity objects.
     */

    public function create($type)
    {
        if ($type == 'excercises') {
            return new Excercises();
        } elseif ($type == 'plan') {
            return new Plan();
        } elseif ($type == 'user') {
            return new User();
        } elseif ($type == 'user_plan') {
            return new UserPlan();
        } elseif ($type == 'workout_days') {
            return new WorkoutDays();
        } elseif ($type == 'workout_days_excercises') {
            return new WorkoutDaysExcercises();
        }
    }
}
