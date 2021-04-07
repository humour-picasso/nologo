@echo off
if exist [".\.env" ] (
  set %@% = grep -v '^#' .env | xargs -0
) else (
  echo "please copy the .env.tpl file to .env file."
  exit 1
)
.\bin\behat --colors "%@%"
php -S 0.0.0.0:8000
echo "To view HTML report visit: http:/\localhost:8000\build\report"