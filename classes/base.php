<?php

namespace PUBS {

  /**
   * Base Class for PUBS Objects
   */
  class PUBS_Base
  {

    protected static $_User;  // WP User
    protected static $_UserEmail;
    protected static $_UserID;


    private static $didInit = false;  //<- To make sure static init only runs once.

    public static function User()
    {
      PUBS_Base::init();
      return PUBS_Base::$_User;
    }

    public static function UserIsAdmin()
    {
      PUBS_Base::init();
      return current_user_can('administrator');
    }

    public static function UserEmail()
    {
      PUBS_Base::init();
      return PUBS_Base::$_UserEmail;
    }

    public static function UserID()
    {
      PUBS_Base::init();
      return PUBS_Base::$_UserID;
    }

    private static function init()
    {
      if (!PUBS_Base::$didInit) {
        PUBS_Base::$didInit = true;
        // one-time init code.
        // Get the current user
        PUBS_Base::$_User = \wp_get_current_user();
        PUBS_Base::$_UserEmail = PUBS_Base::$_User->user_email;
        PUBS_Base::$_UserID = PUBS_Base::$_User->ID;
      }
    }

    public function __construct()
    {
    }

    function __set($name, $value)
    {
      if (method_exists($this, $name)) {
        $this->$name($value);
      } else {
        // Getter/Setter not defined so set as property of object
        $this->$name = $value;
      }
    }

    function __get($name)
    {
      if (method_exists($this, $name)) {
        return $this->$name();
      } elseif (property_exists($this, $name)) {
        // Getter/Setter not defined so return property if it exists
        return $this->$name;
      }
      return null;
    }
  }
}