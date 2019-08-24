<?php

namespace app\models;

use Yii;


class LogWhat{
	public const CREATE='create';
	public const DELETE='delete';
	public const FILE_DELETE='file-delete';
	public const FILE_ADD='file-add';
	public const UPDATE='update';
	public const LOGIN='login';
	public const LOGOUT='logout';
	public const TASK_ACCEPT='task-accept';
	public const TASK_REJECT='task-reject';
}
