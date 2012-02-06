<?php

/**
 * Class defined all the Constant value of the CMS.
 * 
 * 
 * @author Tuan Nguyen
 * @version 1.0
 * @package common.components
 */

class ConstantDefine{
    
	
	const SITE_NAME='HocMoiNgay';
	const SITE_NAME_URL='HocMoiNgay.com';
	const SUPPORT_EMAIL='support@hocmoingay.com';
	
	
	
	
    /**
     * Constant related to User
     */
    const USER_ERROR_NOT_ACTIVE=3;
    
    const USER_STATUS_DISABLED=0;
    const USER_STATUS_ACTIVE=1;
    
    const USER_SALT='hefd3213cxzczjdasdase321';
	const USER_RECOVER_PASS_SALT='dsa23cvm034ax403449';
    
    public static function getUserStatus(){
        return array(
            self::USER_STATUS_DISABLED=>t("Disabled"),
            self::USER_STATUS_ACTIVE=>t("Active"));
    }
                                     
    
    
    const USER_GROUP_ADMIN='Admin';
    const USER_GROUP_EDITOR='Editor';
    const USER_GROUP_REPORTER='Reporter';
    
    
    
    /**
     * Constant related to Object
     * 
     */
    
    const OBJECT_STATUS_PUBLISHED=1;
    const OBJECT_STATUS_DRAFT=2;
    const OBJECT_STATUS_PENDING=3;
    const OBJECT_STATUS_HIDDEN=4;
    
    public static function getObjectStatus(){
        return array(
                 self::OBJECT_STATUS_PUBLISHED=>t("Published"),
                 self::OBJECT_STATUS_DRAFT=>t("Draft"),
                 self::OBJECT_STATUS_PENDING=>t("Pending"),
                 self::OBJECT_STATUS_HIDDEN=>t("Hidden")
                );
    }
        
    const OBJECT_ALLOW_COMMENT=1;
    const OBJECT_DISABLE_COMMENT=2;
    
    public static function getObjectCommentStatus(){
        return array(
                 self::OBJECT_ALLOW_COMMENT=>t("Allow"),
                 self::OBJECT_DISABLE_COMMENT=>t("Disable"),                 
                );
    }
   
    /**
     * Constant related to Transfer
     *         
     */
    const TRANS_ROLE=1;
    const TRANS_PERSON=2;
    const TRANS_STATUS=3;
    
    
    /**
     * Constant related to Menu
     *         
     */
    const MENU_TYPE_PAGE=1;
    const MENU_TYPE_TERM=2;
    const MENU_TYPE_URL=3;
    const MENU_TYPE_STRING=4;
    
    public static function getMenuType(){
        return array(
                 self::MENU_TYPE_URL=>t("Link to URL"),                 
                 self::MENU_TYPE_PAGE=>t("Link to Page"),
                 self::MENU_TYPE_TERM=>t("Link to a Term Page"),                                 
                 self::MENU_TYPE_STRING=>t("String"),
                );
    }
    
    
    /**
     * Constant related to Content List
     *         
     */
    const CONTENT_LIST_TYPE_MANUAL=1;
    const CONTENT_LIST_TYPE_AUTO=2;
   
    
    public static function getContentListType(){
        return array(
                 self::CONTENT_LIST_TYPE_MANUAL=>t("Manual"),                 
                 self::CONTENT_LIST_TYPE_AUTO=>t("Auto"),
                 
                );
    }
    
    const CONTENT_LIST_CRITERIA_NEWEST=1;
    const CONTENT_LIST_CRITERIA_MOST_VIEWED_ALLTIME=2;
   
    
    public static function getContentListCriteria(){
        return array(
                 self::CONTENT_LIST_CRITERIA_NEWEST=>t("Newsest"),                 
                 self::CONTENT_LIST_CRITERIA_MOST_VIEWED_ALLTIME=>t("Most viewed all time"),                 
                );
    }
    
    /**
     * Constant related to Page
     *         
     */
    const PAGE_ACTIVE=1;
    const PAGE_DISABLE=2;
    
    public static function getPageStatus(){
        return array(
                 self::PAGE_ACTIVE=>t("Active"),
                 self::PAGE_DISABLE=>t("Disable"),                 
                );
    }
    
    const PAGE_ALLOW_INDEX=1;
    const PAGE_NOT_ALLOW_INDEX=2;
    
    public static function getPageIndexStatus(){
        return array(
                 self::PAGE_ALLOW_INDEX=>t("Allow index"),
                 self::PAGE_NOT_ALLOW_INDEX=>t("Not allow Index"),                 
                );
    }
    
    const PAGE_ALLOW_FOLLOW=1;
    const PAGE_NOT_ALLOW_FOLLOW=2;
    
    public static function getPageFollowStatus(){
        return array(
                 self::PAGE_ALLOW_FOLLOW=>t("Allow follow"),
                 self::PAGE_NOT_ALLOW_FOLLOW=>t("Not allow follow"),                 
                );
    }
    
    
    const PAGE_BLOCK_ACTIVE=1;
    const PAGE_BLOCK_DISABLE=2;
    
    public static function getPageBlockStatus(){
        return array(
                 self::PAGE_BLOCK_ACTIVE=>t("Active"),
                 self::PAGE_BLOCK_DISABLE=>t("Disable"),                 
                );
    }
    
    /**
     * Constant related to Avatar Size
     */    
    
    const AVATAR_SIZE_96=96;
    const AVATAR_SIZE_23=23;
          
    public static function getAvatarSizes(){
        return array(
            self::AVATAR_SIZE_23=>t("23"),
            self::AVATAR_SIZE_96=>t("96"));
    }
    
}

?>
