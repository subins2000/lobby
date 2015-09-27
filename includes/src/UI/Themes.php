<?php
namespace Lobby\UI;

require_once L_DIR . "/includes/src/UI/Panel.php";

class Themes extends \Lobby {
  
  /**
   * Cache results
   */
  private static $cache = array();
  
  private static $theme;
  private static $theme_loc;
  
  /**
   * Initialization
   */
  public static function init(){
    self::$theme = getOption("active_theme");
    if(self::$theme == null){
      self::$theme = "hine";
    }else if(self::validTheme(self::$theme) === false){
      self::$theme = "hine";
    }
    if(!\Lobby::status("lobby.serve") && !\Lobby::status("lobby.install")){
      self::loadTheme();
    }
  }
  
  /**
   * Get themes installed
   */
  public static function getThemes(){
    if(!isset(self::$cache["themes"])){
      self::$cache['themes'] = array();
      $theme_folders = array_diff(scandir(THEMESE_DIR), array('..', '.'));
    
      foreach($theme_folders as $theme_folder_name){
        if(self::valid($theme_folder_name)){
          self::$cache['themes'][$theme_folder_name] = 1;
        }
      }
    }
    return self::$cache['themes'];
  }
  
  /**
   * Load a theme
   */
  public static function loadTheme(){
    define("THEME_ID", self::$theme);
    define("THEME_DIR", THEMES_DIR . "/" . self::$theme);
    define("THEME_URL", THEMES_URL . "/" . self::$theme);
    
    require_once L_DIR . "/includes/src/UI/Theme.php";
    require_once THEME_DIR . "/Theme.php";
    $className = "\Lobby\UI\Themes\\" . self::$theme;
    $GLOBALS["THEME_OBJ"] = new $className();
    
    $GLOBALS["THEME_OBJ"]->init();
    /**
     * Load Panel
     */
    if(\Lobby::status("lobby.admin")){
      \Lobby::hook("admin.head.begin", function(){
        $GLOBALS["THEME_OBJ"]->panel(true);
        $GLOBALS["THEME_OBJ"]->addStyle("/style.css");
      });
      \Lobby::hook("admin.body.begin", function() {
        echo $GLOBALS["THEME_OBJ"]->inc("/Panel/load.admin.php");
      });
    }else{
      $GLOBALS["THEME_OBJ"]->addStyle("/style.css");
      \Lobby::hook("head.begin", function(){
        $GLOBALS["THEME_OBJ"]->panel(false);
      });
      \Lobby::hook("body.begin", function() {
        echo $GLOBALS["THEME_OBJ"]->inc("/Panel/load.php");
      });
    }
  }
  
  /**
   * Load Dashboard
   */
  public static function loadDashboard($dashboard_items){
    if($dashboard_items == "head"){
      $GLOBALS["THEME_OBJ"]->dashboard();
    }else{
      echo $GLOBALS["THEME_OBJ"]->inc("/Dashboard/load.php");
    }
  }
  
  /**
   * Check if a theme is valid
   */
  public static function validTheme($theme){
    $valid = false;
    $loc = THEMES_DIR . "/$theme";
    
    /**
     * Does the "Theme.php" file in theme directory exist ?
     */
    if(file_exists("$loc/Dashboard/load.php") && file_exists("$loc/Panel/load.php")){
      $valid = true;
    }
    return $valid;
  }
  
}
\Lobby\UI\Themes::init();