<?php
/**
 * Created by PhpStorm.
 * User: etema
 * Date: 3/19/16
 * Time: 8:13 PM
 */

//Database interface
interface IDatabase{
    public function tableName();
    public function rules();
}

interface IModules{
    public function addModule($tarFile);
    public function getModuleInfo($module_name);
    public function getModuleList();
    public function getModuleListWithInfo();
    public function removeModule();
    public function getModulePkItems($module = null);
    public function getModulePkItemsScript($module=null);
    public function getModulesPkItems();
}

//Controller interface
interface IController{
    public function actionIndex();
}

interface IXml{
    public function rules();
}