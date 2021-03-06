<?php
namespace app\rbac\helpers;

use app\models\User;
use app\rbac\models\Role;
use Yii;

/**
 * RBAC helper class.
 */
class RbacHelper
{
    /**
     * In development environment we want to give theCreator role to the first signed up user.
     * This user should be You. 
     * If user is not first, there is no need to automatically give him role, his role is authenticated user '@'.
     * In case you want to give some of your custom roles to users by default, this is a good place to do it.
     *
     * @param  integer $id The id of the registered user.
     * @return boolean     True if theCreator role is assigned or if there was no need to do it.
     */
    public static function assignRole($id)
    {

        // lets see how many users we got so far
        $usersCount = User::find()->count();

        // Give role unaccepted user
        if ($usersCount != 1) {
			// this is first user ( you ), lets give you the theCreator role
			$auth = Yii::$app->authManager;
			$role = $auth->getRole('MemberUnaccepted');
			$info = $auth->assign($role, $id);

			// if assignment was successful return true, else return false to alarm the problem
			return ($info->roleName == "MemberUnaccepted") ? true : false ;
        }

        // this is first user ( you ), lets give you the theCreator role
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('theCreator');
        $info = $auth->assign($role, $id);

        // if assignment was successful return true, else return false to alarm the problem
        return ($info->roleName == "theCreator") ? true : false ;
    }
}

