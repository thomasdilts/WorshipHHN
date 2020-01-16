<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = Yii::t('app', 'Forum');
?>
<div class="site-forum">

    <h3><?= Html::encode($this->title) ?></h3>

	<script type="text/javascript" src="../forum/js/embed.js"></script>
	<noscript>
		Please enable JavaScript to view the
		<a href="//worshiphhn.org/whhn/forum/?ref_noscript">
			discussions powered by Vanilla.
		</a>
	</noscript>
	<div class="vanilla-credit">
		<a class="vanilla-anchor" href="//worshiphhn.org/whhn/forum">
			Discussions by <span class="vanilla-logo">Vanilla</span>
		</a>
	</div>

</div>
