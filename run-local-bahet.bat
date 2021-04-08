@echo off
if exist .\.env (
	setlocal enabledelayedexpansion
	for /f %%i in (.env) do (
		set %%i
		)
) else (
  	echo "please copy the .env.tpl file to .env file."
  	exit
)

set var=
:LOOP
	set index=%1
	if %index%! == ! goto END
	
rem	add your logic in here
	call set "var=%%var%% %%index%%"
	shift
	goto LOOP
	
:END


.\bin\behat --colors %var% 
php -S 0.0.0.0:8000
@echo "To view HTML report visit: http://localhost:8000/build/report"
