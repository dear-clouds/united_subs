<?php

class Mom_Mailchimp_Error extends Exception {}
class Mom_Mailchimp_HttpError extends Mom_Mailchimp_Error {}

/**
 * The parameters passed to the API call are invalid or not provided when required
 */
class Mom_Mailchimp_ValidationError extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_ServerError_MethodUnknown extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_ServerError_InvalidParameters extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Unknown_Exception extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Request_TimedOut extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Zend_Uri_Exception extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_PDOException extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Avesta_Db_Exception extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_XML_RPC2_Exception extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_XML_RPC2_FaultException extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Too_Many_Connections extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Parse_Exception extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_User_Unknown extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_User_Disabled extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_User_DoesNotExist extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_User_NotApproved extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Invalid_ApiKey extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_User_UnderMaintenance extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Invalid_AppKey extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Invalid_IP extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_User_DoesExist extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_User_InvalidRole extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_User_InvalidAction extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_User_MissingEmail extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_User_CannotSendCampaign extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_User_MissingModuleOutbox extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_User_ModuleAlreadyPurchased extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_User_ModuleNotPurchased extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_User_NotEnoughCredit extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_MC_InvalidPayment extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_List_DoesNotExist extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_List_InvalidInterestFieldType extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_List_InvalidOption extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_List_InvalidUnsubMember extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_List_InvalidBounceMember extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_List_AlreadySubscribed extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_List_NotSubscribed extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_List_InvalidImport extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_MC_PastedList_Duplicate extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_MC_PastedList_InvalidImport extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Email_AlreadySubscribed extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Email_AlreadyUnsubscribed extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Email_NotExists extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Email_NotSubscribed extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_List_MergeFieldRequired extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_List_CannotRemoveEmailMerge extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_List_Merge_InvalidMergeID extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_List_TooManyMergeFields extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_List_InvalidMergeField extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_List_InvalidInterestGroup extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_List_TooManyInterestGroups extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Campaign_DoesNotExist extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Campaign_StatsNotAvailable extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Campaign_InvalidAbsplit extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Campaign_InvalidContent extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Campaign_InvalidOption extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Campaign_InvalidStatus extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Campaign_NotSaved extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Campaign_InvalidSegment extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Campaign_InvalidRss extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Campaign_InvalidAuto extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_MC_ContentImport_InvalidArchive extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Campaign_BounceMissing extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Campaign_InvalidTemplate extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Invalid_EcommOrder extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Absplit_UnknownError extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Absplit_UnknownSplitTest extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Absplit_UnknownTestType extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Absplit_UnknownWaitUnit extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Absplit_UnknownWinnerType extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Absplit_WinnerNotSelected extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Invalid_Analytics extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Invalid_DateTime extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Invalid_Email extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Invalid_SendType extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Invalid_Template extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Invalid_TrackingOptions extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Invalid_Options extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Invalid_Folder extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Invalid_URL extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Module_Unknown extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_MonthlyPlan_Unknown extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Order_TypeUnknown extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Invalid_PagingLimit extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Invalid_PagingStart extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_Max_Size_Reached extends Mom_Mailchimp_Error {}

/**
 * None
 */
class Mom_Mailchimp_MC_SearchException extends Mom_Mailchimp_Error {}


