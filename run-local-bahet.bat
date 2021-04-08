@echo off
if exist .\.env (
  set /P OEM=<.env
) else (
  echo "please copy the .env.tpl file to .env file."
  exit
)
.\bin\behat --colors %OEM%
php -S 0.0.0.0:8000
echo "To view HTML report visit: http://localhost:8000/build/report"
