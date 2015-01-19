<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>@lang('misc.pwReset')</h2>

		<div>
			@lang('misc.resetForm') {{ URL::to('password/reset', array($token)) }}.<br/>
			@lang('misc.expire') {{ Config::get('auth.reminder.expire', 60) }} @lang('misc.minutes')
		</div>
	</body>
</html>
