<?php
	namespace PHPSTORM_META {
	/** @noinspection PhpUnusedLocalVariableInspection */
	/** @noinspection PhpIllegalArrayKeyTypeInspection */
	$STATIC_METHOD_TYPES = [

		\D('') => [
			'Mongo' instanceof Think\Model\MongoModel,
			'School' instanceof Api\Model\SchoolModel,
			'Channel' instanceof Admin\Model\ChannelModel,
			'Action' instanceof Admin\Model\ActionModel,
			'AuthRule' instanceof Admin\Model\AuthRuleModel,
			'Base' instanceof Api\Model\BaseModel,
			'Member' instanceof Admin\Model\MemberModel,
			'Menu' instanceof Admin\Model\MenuModel,
			'Attachment' instanceof Addons\Attachment\Model\AttachmentModel,
			'Category' instanceof Admin\Model\CategoryModel,
			'Relation' instanceof Think\Model\RelationModel,
			'File' instanceof Admin\Model\FileModel,
			'Picture' instanceof Admin\Model\PictureModel,
			'AuthGroup' instanceof Admin\Model\AuthGroupModel,
			'View' instanceof Think\Model\ViewModel,
			'Config' instanceof Admin\Model\ConfigModel,
			'Student' instanceof Api\Model\StudentModel,
			'Digg' instanceof Addons\Digg\Model\DiggModel,
			'Document' instanceof Admin\Model\DocumentModel,
			'Hooks' instanceof Admin\Model\HooksModel,
			'Adv' instanceof Think\Model\AdvModel,
			'Addons' instanceof Admin\Model\AddonsModel,
			'Weixin' instanceof Api\Model\WeixinModel,
			'Attribute' instanceof Admin\Model\AttributeModel,
			'Tree' instanceof Common\Model\TreeModel,
			'Model' instanceof Admin\Model\ModelModel,
			'Url' instanceof Admin\Model\UrlModel,
			'UcenterMember' instanceof User\Model\UcenterMemberModel,
			'Teacher' instanceof Api\Model\TeacherModel,
		],
		\DL('') => [
			'SchoolLogic' instanceof Api\Logic\SchoolLogic,
			'StudentLogic' instanceof Api\Logic\StudentLogic,
			'DownloadLogic' instanceof Admin\Logic\DownloadLogic,
			'ArticleLogic' instanceof Admin\Logic\ArticleLogic,
			'BaseLogic' instanceof Api\Logic\BaseLogic,
		],
		\DS('') => [
			'ShortMessageS' instanceof Api\Service\ShortMessageS,
			'BaseService' instanceof Api\Service\BaseService,
			'SchoolService' instanceof Api\Service\SchoolService,
			'StudentService' instanceof Api\Service\StudentService,
			'WeixinService' instanceof Api\Service\WeixinService,
		]
	];
}