cd ..
cd /var/www/my_project/
git pull origin main
bin/console cache:clear
bin/console cache:warmup
echo "successful"
