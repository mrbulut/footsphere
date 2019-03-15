<?php
/**
 * Created by PhpStorm.
 * User: muzaffer
 * Date: 04.02.2019
 * Time: 09:19
 */

include_once ROOT_PATH . "/src/entities/concrete/UserConcrete.php";
include_once ROOT_PATH . "/src/entities/abstract/Container.php";
include_once ROOT_PATH . "/src/data/abstract/DatabaseTableDao.php";
include_once ROOT_PATH . "/src/data/abstract/IDatabaseTableDao.php";
include_once ABSPATH . "wp-includes/pluggable.php";
require_once ABSPATH . "wp-admin/upgrade-functions.php";
require_once ABSPATH . "wp-includes/registration.php";
require_once ABSPATH . "wp-admin/includes/user.php";

/*
     * $this->Rows[0] => $Id;
     * $this->Rows[1] => $user_pass;
     * $this->Rows[2] => $user_email;
     * $this->Rows[3] => $user_registered; // Date
     * $this->Rows[4] => $display_name;
     * $this->Rows[5] => $user_role;
  */

class UserDal extends DatabaseTableDao implements IDatabaseTableDao
{
    private $Rows;
    private $User;
    private $UserId;

    /**
     * @return null
     */
    public function getUserId()
    {
        return $this->UserId;
    }

    /**
     * @param null $UserId
     */
    public function setUserId($UserId)
    {
        $this->UserId = $UserId;
    }


    /**
     * @return User
     */
    public function getUser()
    {
        return $this->User;
    }

    public function __construct($UserId = null)
    {

        if ($UserId == null) {
            if (is_user_logged_in()) {
                $current_user = wp_get_current_user();
                $this->UserId = $current_user->ID;
            } else {
                $this->UserId = $UserId;
            }
        } else {
            $this->UserId = $UserId;
        }


        $this->User = new User();
        $this->Rows = parent::CreateTable(Container::getInstance(new User()), "wp_users");

        self::getUserWP($this->UserId);
    }

    public function createUser(User $user, $Cap)
    {
        $user_id = username_exists($user->getUserName());




        if (!$user_id) {
            if (email_exists($user->getUserEmail()) == false) {

                $sifre = wp_hash_password($user->getUserPass());
                $user->setUserPass($sifre);

                $user_id = wp_create_user(
                    $user->getUserName(),
                     $user->getUserPass(),
                    $user->getUserEmail());

                if ($user_id) {
                    wp_update_user(array('ID' => $user_id, 'role' => $Cap));
                    wp_update_user(array('ID' => $user_id, 'display_name' => $user->getDisplayName()));

                    return $user_id;
                } else
                    return false;
            } else {
                return false;
            }


        } else {
            return $user_id;
        }


    }

    public function deleteUser($UserId)
    {
        return wp_delete_user($UserId);
    }


    public function updateUserWP(User $user, User $UserWhere)
    {
        if ($user) {
            $this->settingQuery($user, $UserWhere);
            if ($user->getDisplayName()) {
                $data['key'] = 'display_name';
                $data['value'] = $user->getDisplayName();
                self::updateWpByTheKey($data, $UserWhere->getID());
            }
            if ($user->getUserEmail()) {
                $data['key'] = 'user_email';
                $data['value'] = $user->getUserEmail();
                self::updateWpByTheKey($data, $UserWhere->getID());
            }

            if ($user->getUserPass()) {
                $data['key'] = 'user_pass';
                $data['value'] = $user->getUserPass();
                self::updateWpByTheKey($data, $UserWhere->getID());
            }


        }

    }

    private function updateWpByTheKey($data, $UserId)
    {
        try {
            $this->update(
                array(
                    $data['key'] => $data['value']
                ),
                array(
                    'ID' => $UserId
                )
            );
        } catch (Exception $exception) {

        }
    }

    public function getUserWP($UserId)
    {
        if ($UserId) {
            $data = get_userdata($UserId);
            $this->User->setID($data->ID);
            $this->User->setUserName($data->user_login);
            $this->User->setDisplayName($data->display_name);
            $this->User->setUserEmail($data->user_email);
            $this->User->setUserPass($data->user_pass);
            $this->User->setUserRegistered($data->user_registered);

            if (count($data->wp_capabilities) > 0) {
                foreach ($data->wp_capabilities as $key => $value) {
                    $this->User->setUserRole($key);
                    break;
                }
            }
        }


    }


}


