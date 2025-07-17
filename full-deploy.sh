#!/bin/bash

# CONFIG
LOCAL_DIR=$(pwd)
REMOTE_USER=ubuntu
REMOTE_HOST=your-ec2-ip
REMOTE_PATH=/var/www/html/your-laravel-project
SSH_KEY=~/.ssh/id_rsa # optional, if you use a custom key

echo "🔨 Step 1: Building assets..."
npm run build

echo "📦 Step 2: Syncing project to EC2..."
rsync -avz --exclude=node_modules \
           --exclude=.git \
           --exclude=storage/logs \
           --exclude=storage/framework/sessions \
           --exclude=vendor \
           --delete \
           -e "ssh -i $SSH_KEY" \
           $LOCAL_DIR/ $REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH

echo "🧰 Step 3: Running server-side setup..."
ssh -i $SSH_KEY $REMOTE_USER@$REMOTE_HOST << EOF
    cd $REMOTE_PATH

    echo "📦 Installing dependencies..."
    composer install --no-dev --optimize-autoloader

    echo "⚙️ Running Laravel commands..."
    php artisan config:clear
    php artisan config:cache
    php artisan view:clear
    php artisan migrate --force

    echo "🔐 Fixing permissions..."
    chown -R www-data:www-data storage bootstrap/cache
    chmod -R 775 storage bootstrap/cache

    echo "✅ Deployment done on server."
EOF

echo "🚀 Deployment finished!"


# chmod +x full-deploy.sh
# ./deploy.sh