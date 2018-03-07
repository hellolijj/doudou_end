<?php
	namespace PHPSTORM_META {
	/** @noinspection PhpUnusedLocalVariableInspection */
	/** @noinspection PhpIllegalArrayKeyTypeInspection */
	$STATIC_METHOD_TYPES = [

		\D('') => [
			'Mongo' instanceof Think\Model\MongoModel, 'QuestionCollection' instanceof Api\Model\QuestionCollectionModel, 'QuestionCount' instanceof Api\Model\QuestionCountModel,
			'School' instanceof Api\Model\SchoolModel, 'Channel' instanceof Home\Model\ChannelModel,
			'Base' instanceof Api\Model\BaseModel, 'Class' instanceof Api\Model\ClassModel, 'Member' instanceof Home\Model\MemberModel, 'QuestionChapter' instanceof Api\Model\QuestionChapterModel,
			'Attachment' instanceof Addons\Attachment\Model\AttachmentModel, 'Category' instanceof Home\Model\CategoryModel,
			'Relation' instanceof Think\Model\RelationModel, 'File' instanceof Home\Model\FileModel, 'Course' instanceof Api\Model\CourseModel, 'Signin' instanceof Api\Model\SigninModel,
			'View' instanceof Think\Model\ViewModel, 'Question' instanceof Api\Model\QuestionModel,
			'Student' instanceof Api\Model\StudentModel, 'SigninRecord' instanceof Api\Model\SigninRecordModel, 'InvitationCode' instanceof Api\Model\InvitationCodeModel,
			'Digg' instanceof Addons\Digg\Model\DiggModel, 'Document' instanceof Home\Model\DocumentModel, 'QuestionBank' instanceof Api\Model\QuestionBankModel,
			'Adv' instanceof Think\Model\AdvModel, 'QuestionSet' instanceof Api\Model\QuestionSetModel,
			'Weixin' instanceof Api\Model\WeixinModel,
			'UcenterMember' instanceof User\Model\UcenterMemberModel, 'QuestionRecord' instanceof Api\Model\QuestionRecordModel,
			'Teacher' instanceof Api\Model\TeacherModel,
		],
		\DL('') => [
			'WeixinLogic' instanceof Api\Logic\WeixinLogic,
			'StudentLogic' instanceof Api\Logic\StudentLogic,
			'SchoolLogic' instanceof Api\Logic\SchoolLogic, 'MyLogic' instanceof Api\Logic\MyLogic, 'DownloadLogic' instanceof Home\Logic\DownloadLogic,
			'BaseLogic' instanceof Api\Logic\BaseLogic, 'CourseLogic' instanceof Api\Logic\CourseLogic, 'UserBaseLogic' instanceof Api\Logic\UserBaseLogic, 'ArticleLogic' instanceof Home\Logic\ArticleLogic, 'QuestionLogic' instanceof Api\Logic\QuestionLogic, 'TeacherLogic' instanceof Api\Logic\TeacherLogic, 'SigninLogic' instanceof Api\Logic\SigninLogic,
		],
		\DS('') => ['InvitationService' instanceof Api\Service\InvitationService, 'StudentService' instanceof Api\Service\StudentService, 'ClassService' instanceof Api\Service\ClassService, 'QuestionRecordService' instanceof Api\Service\QuestionRecordService,
			'ShortMessageS' instanceof Api\Service\ShortMessageS, 'QuestionSpecialService' instanceof Api\Service\QuestionSpecialService, 'QuestionService' instanceof Api\Service\QuestionService, 'SigninRecordService' instanceof Api\Service\SigninRecordService, 'QuestionChapterService' instanceof Api\Service\QuestionChapterService, 'WeixinService' instanceof Api\Service\WeixinService, 'QuestionSetService' instanceof Api\Service\QuestionSetService,
			'BaseService' instanceof Api\Service\BaseService, 'TeacherService' instanceof Api\Service\TeacherService,
			'SchoolService' instanceof Api\Service\SchoolService, 'QuestionUploadService' instanceof Admin\Service\QuestionUploadService, 'SigninService' instanceof Api\Service\SigninService, 'TempMsgService' instanceof Api\Service\TempMsgService, 'CourseService' instanceof Api\Service\CourseService, 'ExaminationService' instanceof Api\Service\ExaminationService, 'QuestionCollectService' instanceof Api\Service\QuestionCollectService,
		]
	];
}